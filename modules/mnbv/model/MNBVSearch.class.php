<?php
/**
 * Класс работы с кешем
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVSearch {
    
    /**
     * @var type Название переменной сессии
     */
    protected $storage = 'searchindex';
    
    /**
     * @var int количество слов по которым осуществляется поиск 
     */
    private $searchWords = 3;
    
    private $storageArr = array(
        "products" => "1",
    );
    
    /**
     * Возвращает идентификатор хранилища для маркировки элементов поискового индекса
     * @param type $storage
     * @return type
     */
    private function getIdByStorage($storage){
        return SysBF::getFrArr($this->storageArr, $storage, 0, 'intval');
    }
    
    /**
     * При инициализации загрузим данные сессии
     * @param string $storage - алиас хранилища кеша
     */
    public function __construct($storage='searchindex') {

        if (!empty(SysStorage::$storage["$storage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$storage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$storage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $this->storage = $storage;
        }else{
            SysLogs::addError("No storage: $storage");
            return false;
        }

    }

    /**
     * Установка элемента индекса
     * @param int $storage алиас хранилища
     * @param int $objid идентификатор элемента
     * @param string $search строка для поиска
     * @param int $objtype тип элемента (0 по-умолчанию)
     * @param int $weight вес элемента  (1 по-умолчанию)
     * @param int $siteid идентификатор сайта (0 по-умолчанию без ограничения)
     * @param array $exeptions массив нормализованных строк-исключений
     * @return string строка индекса или false, если запись не была осуществлена
     */
    public function set($storage, $objid, $search, $objtype=0, $weight=1, $siteid=0, $exeptions=null)
    {
        $result = false;
        //SysLogs::addLog("MNBVSearch:get str [".$search."]");
        
        $search = SysBF::prepareSearchStr($search);
        //TODO - сделать убирание запятых, точек с запятыми, и делить по пробелам и завоидть как разные слова
        $search = preg_replace("~[\.,;/()]~", " ", $search);
        $search=preg_replace("/ ( )+/u"," ",$search);
        $search=preg_replace("/э/u","е",$search);
        $searchArr = preg_split("/ /", $search);
        
        if (!is_array($exeptions)) $exeptions = array();
        
        foreach ($searchArr as $searchStr){
            $storageId = $this->getIdByStorage($storage);
            $objid = intval($objid);
            if (empty($objid)) return false;
            $objtype = intval($objtype);
            $weight = intval($weight);
            $siteid = intval($siteid);
            $normstr = SysBF::strNormalize($searchStr);
            if (mb_strlen($normstr,'utf-8')<2 && !preg_match("/[0-9]/", $normstr)) continue;
            $normstr = SysBF::normUpdate($normstr);
            
            if (in_array($normstr,$exeptions)) continue; //Для исключения повторяющихся слов
            
            $updateArr = array(
                "siteid" => $siteid,
                "type" => $storageId,
                "objid" => $objid,
                "objtype" => $objtype,
                "normstr" => $normstr,
                "weight" => $weight
            );

            $addId = MNBVStorage::addObj($this->storage, $updateArr,'',false);
            //SysLogs::addLog("MNBVSearch:add index [$normstr]");
            $exeptions[] = $normstr;
            $result = $normstr;
        }
        return $exeptions;

    }
    
    
    /**
     * Установка элемента индекса
     * @param int $storage алиас хранилища
     * @param int $objid идентификатор элемента
     * @return boolean
     */
    public function del($storage, $objid)
    {
        
        $storageId = $this->getIdByStorage($storage);
        $objid = intval($objid);
        MNBVStorage::delObj($this->storage, array("objid","=","$objid","and","type","=",$storageId));
        return true;

    }
    
    /**
     * Получение элементов по поисковой строке
     * @param int $storage алиас хранилища
     * @param int $limit максимальное количество результатов (по-умолчанию 100)
     * @param string $search строка для поиска
     * @param int $objtype тип элемента (0 по-умолчанию)
     * @param int $siteid идентификатор сайта (0 по-умолчанию без ограничения)
     * @return array
     */
    public function get($search, $storage='', $limit=100, $objtype=0, $siteid=0)
    {
        
        $storageId = $this->getIdByStorage($storage);
        $objtype = intval($objtype);
        $siteid = intval($siteid);
        
        $search=preg_replace("/э/u","е",$search);
        $normstr = SysBF::strNormalize($search,'space_ok');
        $searchArr = preg_split("/ /",$normstr);
        
        $counter = 0;
        $quFilterArrDop = array();
        foreach($searchArr as $nword){
            if ($counter > $this->searchWords) break;
            if ($counter) array_push($quFilterArrDop, "or");
            array_push($quFilterArr, "normstr","like","$nword%");
            $counter++;
        }
        
        $quFilterArr = array(array($quFilterArrDop)); //Фильтры        
        if (!empty($storageId)) array_push($quFilterArr, "and","type","=",$storageId);
        if (!empty($objtype)) array_push($quFilterArr, "and","objtype","=",$objtype);
        if (!empty($siteid)) array_push($quFilterArr, "and","siteid","=",$siteid);
        
        $quConfArr = array("countFoundRows"=>true, "sort"=>array("wsum"=>"desc"),"group"=>"objid"); //Сортировка
        if (!empty($limit)) $quConfArr["limit"] = array(0,$limit);
        
        $storageRes = MNBVStorage::getObj(
            $this->storage,
            array("objid","objtype",array("sum(weight)","wsum")),
            $quFilterArr,
            $quConfArr);
        if (!empty($storageRes[0])){
            return $storageRes[1];
        }

        return null;

    }
    
}
