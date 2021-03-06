<?php
/**
 * Редактирование универсальных объектов системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class StorageController {
    
    //TODO - сделать метод получения значения заданного номера атрибута для заданного товара и использовать его для добавление цвета в поисковый индекс
    
    /**
     * @var string Имя модуля контроллера в нижнем регистре(Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';
    
    /**
     * @var string наименование контроллера - требуется в ряде случаев при формировании URL и т.п. 
     */
    public $controllerName = 'storage';
    
    /**
     * @var string папка словаря интерфейса
     */
    public $tplFolder = 'storage';

    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = '';

    /**
     * @var array массив основных свойств папок в данном хранилище
     */
    private $foldersArr = array();

    /**
     * @var array массив вложенных в папку нижестоящих папок
     */
    private $parentArr = array();

    /**
     * Конструктор класса BaseobjController
     * @param string название (алиас) текущего модуля 
     */
    public function __construct($thisModuleName) {
        $this->thisModuleName = strtolower($thisModuleName);
    }

    /**
     * Установка текущего хранилища для контроллера
     * @param $storage - алиас хранилища
     */
    public function setStorage($storage){
        $this->storage = $storage;
    }

    /**
     * Получение текущего хранилища для контроллера
     * @param $storage - алиас хранилища
     */
    public function getStorage(){
        return $this->storage;
    }
    
    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_storagelist($tpl_mode, $console);//Покажем хелп
    }


    /**
     * Внесение изменений в свойства нижестоящих папок в заданной папке
     * @param $storage - хранилище
     * @param $folderId - родительская папка
     * @return bool - результат операции
     */
    public function setUpObjInfo($folderId){

        //Счетчик уровней вложенности, с ограниением максимум 10 уровней
        static $levelCounter = 0;
        if ($levelCounter>10) return true;

        //Сформируем данные для размещения в нижестоящих папках
        $storageRes2 = MNBVStorage::upObjInfo($this->foldersArr["$folderId"]);
        $upfolders = $storageRes2["upfolders"];
        $attrup = $storageRes2["attrup"];

        //Скорректируем данные в массиве папок
        if (isset($this->parentArr["$folderId"])){
            $res = MNBVStorage::setObj($this->getStorage(), array("upfolders"=>$upfolders,"attrup"=>$attrup), array("parentid",'=',$folderId,'and',"type",'=',ST_FOLDER));
            SysLogs::addLog("Update folder objects /".$this->getStorage()."/".$folderId."/ ".(($res)?'successful!':'error!'));

            $parentArr = $this->parentArr["$folderId"];
            foreach($parentArr as $objId){
                $this->foldersArr["$objId"]["upfolders"] = $upfolders;
                $this->foldersArr["$objId"]["attrup"] = $attrup;
                $levelCounter++;
                $this->setUpObjInfo($this->foldersArr["$objId"]["id"]);
                $levelCounter--;
            }
        }

        return true;
        
    }

    /**
     * Обновляет поля с данными о вышестоящих папках и их атрибутах
     * @param $storage - хранилище
     * @param $folderId - id папки от которой вниз пойдет обновление
     */
    private function updateUpObjInfo($folderAttr=array()){

        if (empty($folderAttr["id"])) return true; //Если не задан идентификатор папки, то ничего не делаем

        $folderId = $folderAttr["id"]; //Идентификатор родительской папки в которой будут проводиться изменения

        $this->foldersArr = array(); //Массив сведений о папке
        $this->parentArr = array(); //Массив вложенных в папку нижестоящих папок
        $storageRes = MNBVStorage::getObj(
            $this->getStorage(),
            array("id,parentid,attr"),
            array("type","=",ST_FOLDER));
        if (!empty($storageRes[0])) {
            unset($storageRes[0]);
            foreach($storageRes as $value){
                $parentid = (string)$value["parentid"];
                if (!isset($this->parentArr[$parentid]))$this->parentArr[$parentid] = array();
                $this->parentArr[$parentid][] = (string)$value["id"];
                $this->foldersArr[(string)$value["id"]] = array(
                    "id" => (string)$value["id"],
                    "parentid" => (string)$value["parentid"],
                    "attr" => $value['attr'],
                    "upfolders" => '', //для нижестоящих папок
                    "attrup" => '', //для нижестоящих папок
                );
            }
        }

        $this->foldersArr["$folderId"]["upfolders"] = $folderAttr["upfolders"];
        $this->foldersArr["$folderId"]["attrup"] = $folderAttr["attrup"];
        $this->foldersArr["$folderId"]["attr"] = $folderAttr["attr"];

        $this->setUpObjInfo($folderId);

        return true;
    }
    
    
    /**
     * Удаляет из индекса атрибутов элементы, связанные с заданными атрибутами во всех нижестоящих папках
     * @param $storage - алиас хранилища к которому привязаны атрибуты
     * @param $folderId - id папки от которой вниз пойдет обновление
     * @param $delAttrIdArr - массив с идентификаторами атрибутов
     */
    private function delDnAttr($storage,$folderId,$delAttrIdArr=array()){

        $folderId = intval($folderId);
        if (empty($folderId)) return true; //Если не задан идентификатор папки, то ничего не делаем
        
        //При необходимости удалим из индекса удаленные поля
        if (empty(SysStorage::$storage[$storage]['arrtindexuse']) || !isset(SysStorage::$storage[SysStorage::$storage[$storage]['arrtindexuse']])) return true;

        $storageRes = MNBVStorage::getObj(
            $this->getStorage(),
            array("id"),
            array("parentid","=",$folderId,"and","type","=",ST_FOLDER));
        if (!empty($storageRes[0])) {
            unset($storageRes[0]);
            foreach ($storageRes as $value){
                foreach($delAttrIdArr as $realKeyId){
                    $res = MNBVStorage::delObj(SysStorage::$storage[$storage]['arrtindexuse'],
                            array("objparentid","=",$value['id'],"and","attrid","=",$realKeyId));
                    SysLogs::addLog("Delete Index Attr[{$realKeyId}] to objparentid[{$value['id']}] " . (($res)?($res.' successful!'):' error!'));
                }
                $this->delDnAttr($storage,$value['id'],$delAttrIdArr);
            }
        }
        return true;
    }

     /**
     * Поправляет uttrup в нижестоящих папках
     * @param $folderId - id папки от которой вниз пойдет обновление
     * @param $attrArr - массив с атрибутами вышестоящей категории
     */
    private function updDnAttrup ($folderId,$attrArr=array()){

        $folderId = intval($folderId);
        if (empty($folderId)) return true; //Если не задан идентификатор папки, то ничего не делаем
        
        $updateArr = array();
        if (count($attrArr)>0) $updateArr["attrup"] = json_encode($attrArr); else $updateArr["attr"] = '';	
        
        $storageRes = MNBVStorage::getObj(
            $this->getStorage(),
            array("id,parentid,attr"),
            array("parentid","=",$folderId,"and","type","=",ST_FOLDER));
        if (!empty($storageRes[0])) {
            unset($storageRes[0]);
            foreach($storageRes as $value){
                //Поправим текущую папку
                $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$value["id"]));
                SysLogs::addLog("Update Attrup objid[{$value['id']}] " . (($res)?($res.' successful!'):' error!'));
                
                //Дополним $attrArr полями из текущей папки
                $useAttrArr = $attrArr;
                if (!empty($value['attr'])) {
                    $curItemAttr = SysBF::json_decode($value['attr']);
                    if (is_array($curItemAttr)) foreach($curItemAttr as $attrVal) $useAttrArr[] = $attrVal;
                }
                $this->delDnAttr($value['id'],$useAttrArr);
            }
        }
        return true;
    }   

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_storagelist($tpl_mode='html', $console=false){

        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Storage list","module_names"); //Метатеги
        $item = array(); //Массив данных, передаваемых во View
        $PgHtml = '';
        if (!empty($PgHtml) && $tpl_mode=='html'){$PgHtml = "<pre>$PgHtml</pre>";}

        $item['storage_group'] = Glob::$vars['session']->get('storage_group');
        SysLogs::addLog("storage_group:". $item['storage_group']);
        $storage_group = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'storage_group',''),'routeitem');
        if (!empty($storage_group) && $storage_group !== $item['storage_group']) {
            $item['storage_group'] = ($storage_group=='all')?'':$storage_group;
            Glob::$vars['session']->set('storage_group',$item['storage_group']);
            SysLogs::addLog("storage_group update:". $item['storage_group']);
        }

        $item['page_sctpl'] = 'tpl_storagelist.php';
        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;
        
        $item['list'] = array();
        foreach (SysStorage::$storage as $key => $value) {
            if (!empty($value['group']) && $value['group']=='noview') continue;
            if (!empty($value['list']) && !is_array($value['list'])) continue;
            if ((empty($item['storage_group']) || (!empty($value['group'])&&$item['storage_group']==$value['group']))&&(Glob::$vars['user']->get('root')||(!empty($value['access2'])&&in_array($value['access2'],Glob::$vars['user']->get('permarr'))))) {
                $item['list']["$key"]["name"] = MNBVf::getItemName($value,Glob::$vars['mnbv_altlang'],'no-name');
                $item['list']["$key"]["url"] = '/' . Glob::$vars['mnbv_module'] . '/' . $this->controllerName . '/' . $key . '/' . ((Lang::isDefLang())?'':'altlang/');
            }
        }

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }
    
    /**
     * Создание хранилища, если не существует поддерживающая его структура
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_createstorage($tpl_mode='html', $console=false){
        
        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Сreate storage","storage"); //Метатеги
        $item = array(); //Массив данных, передаваемых во View

        $PgHtml = Lang::get("Сreate storage","storage");
        //$item['page_sctpl'] = 'tpl_objlist.php';
        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
    /**
     * Список объектов хранилища
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_list($tpl_mode='html', $console=false){
        
        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Object list","module_names"); //Метатеги
        $item = array(); //Массив данных, передаваемых во View

        $PgHtml = '';
        $item['page_sctpl'] = 'tpl_objlist.php';
        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;
        
        $item['list'] = array();        
        foreach ($item['list'] as $key => $value) $item['list']["$key"]["url"] = '/' . $this->thisModuleName . '/' . $key . '/';

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
    /**
     * Список объектов хранилища
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_admlist($tpl_mode='html', $console=false){

        $thisTime = time();
        $thisDateTime = date("Y-m-d H:i:s",$thisTime);
        $this->setStorage(Glob::$vars['mnbv_usestorage']);

        $item = array(); //Массив данных, передаваемых во View
        $item['list_storage_alias'] = $this->getStorage();
        $item['mnbv_altlang'] = Glob::$vars['mnbv_altlang'];
        $item['list_storage_alias'] = $this->getStorage();
        $item['list_not_edit'] = (!empty(SysStorage::$storage[$item['list_storage_alias']]['listnotedit']))?true:false;
        
        $searchObj = new MNBVSearch();
        $sExeptArr = array();
        
        //Страницы
        $item['list_page'] = (Glob::$vars['mnbv_listpg']>1)?Glob::$vars['mnbv_listpg']:1;
        $item['list_start_item'] = Glob::$vars['list_max_items'] * ($item['list_page'] - 1);
        $item['list_max_items'] = Glob::$vars['list_max_items'];
        
        //Сведения о родительской папке -------------------------------------------------------------------------------
        $parentid = (!empty(Glob::$vars['mnbv_useobj']))?Glob::$vars['mnbv_useobj']:0;
        $item["parent_name"] = $item["parent_name_min"] =  Lang::get("Root folder");
        $item["parent_url"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/'  . (($item['mnbv_altlang'])?'altlang/':'');;

        $storageRes = array(0);
        if ($parentid>0){//Если задан корневой раздел, то получим данные по нему
            $storageRes = MNBVStorage::getObj($this->getStorage(),
                array("id","parentid","visible","first","access","access2","name","namelang","vars","siteid"),
                array("id","=",$parentid));
        }

        $item['parent'] = (!empty($storageRes[0]))?$storageRes[1]:null;

        if (Glob::$vars['user']->get('root')||(in_array(SysStorage::$storage[$this->getStorage()]['access'],Glob::$vars['user']->get('permarr')) && (!empty($storageRes[0])||$parentid==0))){ //Если корневой раздел найден и доступен
        
        $item["parent_id"] = (!empty($item["parent"]["id"]))?$item["parent"]["id"]:0;
        if (!empty($item["parent"])) {
            $item["parent_name"] = MNBVf::getItemName($item["parent"],$item['mnbv_altlang']);
            $item["parent_name_min"] = mb_substr($item["parent_name"],0,17,'utf-8');
            if ($item["parent_name"]!=$item["parent_name_min"]) $item["parent_name_min"] .= '...';
        }
        if (empty($item["parent"]["access"])&&!empty(SysStorage::$storage[$this->getStorage()]['access'])) $item["parent"]["access"] = SysStorage::$storage[$this->getStorage()]['access'];
        if (empty($item["parent"]["access2"])&&!empty(SysStorage::$storage[$this->getStorage()]['access2'])) $item["parent"]["access2"] = SysStorage::$storage[$this->getStorage()]['access2'];
        if (empty($item["parent"]["access"])) $item["parent"]["access"] = 0;
        if (empty($item["parent"]["access2"])) $item["parent"]["access2"] = 0;
        if (Lang::getLang() != Lang::getDefLang() && !empty($item['parent'][1]['namelang'])) $item["parent_name"] = $item["parent"]["namelang"];
        if (!empty($item["parent"]["parentid"]))$item["parent_url"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . ((!empty($item["parent"]["parentid"]))?($item["parent"]["parentid"] . '/'):'');
        if ($parentid>0 && !empty($item["parent"]["id"])) $item["parent_edit"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item["parent"]["id"] . '/update/';
        
        $item['parent']['vars'] = (!empty($item['parent']['vars']))?SysBF::json_decode($item['parent']['vars']):array();
        //Конец сведений о родительской папке --------------------------------------------------------------------------

        //При наличии специализированного контроллера обработки данного хранилища подгрузим и выполним его
        //$storageSubController =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], MOD_CONTROLLERSPATH . 'Storage'.SysBF::trueName($this->getStorage(),'title').'ListController.php');
        //if(file_exists($storageSubController)) include $storageSubController;
        
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');   
        switch ($act){
            
            case 'update': //Редактирование элемента списка      
                $gid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gid',0),'id');
                if ($gid>0 && $upd_obj = MNBVf::getStorageObject($this->getStorage(),$gid,array('altlang'=>Glob::$vars['mnbv_altlang']))){
                        
                    //Получим новые значения полей
                    $gpozid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gpozid',0),'int');
                    $gvisible = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gvisible',0),'on');
                    $gfirst = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gfirst',0),'on');
                    if (isset(Glob::$vars['request']['gname'])){
                        $gnamekey = 'name';
                        $gname = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gname',''),'string');
                    }
                    if (isset(Glob::$vars['request']['gnamelang'])){
                        $gnamekey = 'namelang';
                        $gname = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gnamelang',''),'string');
                    }
                    $gaccess = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gaccess',0),'int');
                    $gaccess2 = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gaccess2',0),'int');
                    $gdel = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gdel',''),'on');
                    
                    if ($gdel==1){ //Удалим данную запись, если это требуется
                        $res = MNBVStorage::delObj($this->getStorage(),array("id",'=',$gid));
                        SysLogs::addLog("Delete object /".$this->getStorage()."/".$gid."/ ".(($res)?'successful!':'error!'));
                        $redirectToList = true;
                    }else{ //Установим новые значения полей.

                        $updateArr = array(
                            "pozid"=>$gpozid,
                            "visible"=>$gvisible,
                            "first"=>$gfirst,
                            "$gnamekey"=>$gname,
                            "access"=>$gaccess,
                            "access2"=>$gaccess2,
                        );

                        $updateArr["author"] = Glob::$vars['user']->get('name');
                        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                        $updateArr["editdate"] = $thisTime;
                        $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                        
                        //Если поменялись:папка, название(р/л), префикс(р/л), модель, то перегенерим поисковые поля
                        if ($this->getStorage()===Glob::$vars['prod_storage'] 
                                && (isset($updateArr["name"])||isset($updateArr["namelang"])
                                ||isset($updateArr["prefix"])||isset($updateArr["prefixlang"])
                                ||isset($updateArr["partnumber"])||isset($updateArr["model"]))){
                                    
                            $sr_type = (isset($updateArr["type"]))?$updateArr["type"]:$upd_obj["type"];    
                            $sr_name = (isset($updateArr["name"]))?$updateArr["name"]:$upd_obj["name"];    
                            $sr_namelang = (isset($updateArr["namelang"]))?$updateArr["namelang"]:$upd_obj["namelang"]; 
                            $sr_prefix = (isset($updateArr["prefix"]))?$updateArr["prefix"]:$upd_obj["prefix"]; 
                            $sr_prefixlang = (isset($updateArr["prefixlang"]))?$updateArr["prefixlang"]:$upd_obj["prefixlang"]; 
                            $sr_partnumber = (isset($updateArr["partnumber"]))?$updateArr["partnumber"]:$upd_obj["partnumber"]; 
                            $sr_model = (isset($updateArr["model"]))?$updateArr["model"]:$upd_obj["model"]; 
                            $sr_barcode = (isset($updateArr["barcode"]))?$updateArr["barcode"]:$upd_obj["barcode"];
        
                            $updateArr["norm_partnumber"] = '';
                            $updateArr["norm_search"] = '';
                            if ($sr_type!==ST_FOLDER) {
                                $updateArr["norm_search"] .= ',' . $upd_obj["id"];
                                $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_barcode,'zpt_ok');
                                $updateArr["norm_partnumber"] .= SysBF::strNormalize($sr_partnumber,'zpt_ok');
                                $updateArr["norm_search"] .= ',' . $updateArr["norm_partnumber"];
                                $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_model);
                                //Подтянем имя вендора
                                /*
                                $res = MNBVStorage::getObj(Glob::$vars['vend_storage'],
                                        array("name","namelang"),
                                        array("id","=",$updateArr["vendor"]));
                                if (!empty($res[0])) {
                                    $updateArr["norm_search"] .= ',' . SysBF::strNormalize($res[1]['name']);
                                    $updateArr["norm_search"] .= ',' . SysBF::strNormalize($res[1]['namelang']);
                                }
                                 */
                            }
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_name);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_namelang);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_prefix);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_prefixlang); 
                            
                            SysLogs::addLog("Update norm_partnumber=[{$updateArr["norm_partnumber"]}]");
                            SysLogs::addLog("Update norm_search=[{$updateArr["norm_search"]}]");
                            
                            //TODO - важно! Надо добавить вендора и цвет
                            $searchObj->del(Glob::$vars['prod_storage'],$gid);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$gid,0,3,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$sr_partnumber,0,1,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,preg_replace("/[^0-9]/","",$sr_partnumber),0,1,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$sr_barcode,0,1,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,str_replace(' ', '', $sr_model),0,1,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,preg_replace("/[^0-9]/","",$sr_model),0,1,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$sr_prefix,0,1,$upd_obj["siteid"],$sExeptArr);
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$sr_prefixlang,0,1,$upd_obj["siteid"],$sExeptArr);
                            //$sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$sr_name,0,1,$upd_obj["siteid"],$sExeptArr);
                            //$sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$gid,$sr_namelang,0,1,$upd_obj["siteid"],$sExeptArr)
                            $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item["parent"]['name'],$sr_namelang,0,2,$upd_obj["siteid"],$sExeptArr);
                            if (!empty($item["parent"]['namelang'])) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item["parent"]['namelang'],$sr_namelang,0,2,$upd_obj["siteid"],$sExeptArr);

                        }

                        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$gid));
                        SysLogs::addLog("Update object /".$this->getStorage()."/".$gid."/ ".(($res)?'successful!':'error!'));
                    }
                }
            break;
            
            case 'create': //Редактирование элемента списка
                //Получим новые значения полей
                $gpozid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gpozid',0),'int');
                $gvisible = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gvisible',0),'on');
                $gfirst = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gfirst',0),'on');
                $gname = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'gname','string'),'');
                $gaccess = (!empty($item["parent"]["access"]))?$item["parent"]["access"]:SysStorage::$storage[$this->getStorage()]['access']; //Наследуем из вышестоящего раздела, если это корень, то из свойств хранилища
                $gaccess2 = (!empty($item["parent"]["access2"]))?$item["parent"]["access2"]:SysStorage::$storage[$this->getStorage()]['access2']; //Наследуем из вышестоящего раздела, если это корень, то из свойств хранилища
                $gtype = SysBF::checkStr((SysBF::getFrArr(Glob::$vars['request'],'gtype',0)),'int');
                $gsiteid = (!empty($item["parent"]["siteid"]))?$item["parent"]["siteid"]:0;
                
                SysLogs::addLog("Create object gname=[$gname]");
                
                if (!empty($gname)){

                    $updateArr = array(
                        "parentid"=>$parentid,
                        "pozid"=>$gpozid,
                        "visible"=>$gvisible,
                        "first"=>$gfirst,
                        "name"=>$gname,
                        "access"=>$gaccess,
                        "access2"=>$gaccess2,
                        "type"=>$gtype,
                        "datestr"=>$thisDateTime,
                        "date"=>$thisTime,
                        "siteid"=>$gsiteid,
                    );

                    //Если это папка, то поправим атрибуты вышестоящих папок, поправим ссылку на вышестоящие директории.
                    if (isset($updateArr["type"]) && $updateArr["type"]==ST_FOLDER && isset($updateArr["parentid"])) {
                        $newParentid = $parentid;
                        $storageRes = MNBVStorage::getObj(
                            $this->getStorage(),
                            array("id,upfolders,attrup,attr"),
                            array("id","=",$newParentid));
                        $varsArr = array();
                        if (!empty($storageRes[0])) {//Есть сведения о родительской папке
                            $storageRes2 = MNBVStorage::upObjInfo($storageRes[1]);
                            $updateArr["upfolders"] = $storageRes2["upfolders"];
                            $updateArr["attrup"] = $storageRes2["attrup"];
                        }else{//Нет сведений о родительской папке
                            $updateArr["upfolders"] = '';
                            $updateArr["attrup"] = '';
                        }
                    }
                    if (!empty($varsArrUpd)) {if (count($varsArr)>0) $updateArr["vars"] = json_encode($varsArr); else $updateArr["vars"] = '';}

                    $updateArr["author"] = Glob::$vars['user']->get('name');
                    $updateArr["createuser"] = Glob::$vars['user']->get('userid');
                    $updateArr["createdate"] = $thisTime;
                    $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                    $updateArr["editdate"] = $thisTime;
                    $updateArr["editip"] = GetEnv('REMOTE_ADDR');

                    $res = MNBVStorage::addObj($this->getStorage(), $updateArr);
                    SysLogs::addLog("Create object /".$this->getStorage()."/" . (($res)?($res.'/ successful!'):' error!'));
                    $redirectToList = true;
                }
            break;
            
        }  
       
        //Формирование настроек списка: фильтров, сортировки, номеров страниц
        $quFilterArr = array("parentid","=",$parentid); //Фильтры
        $quConfArr = array("countFoundRows"=>true, "sort"=>array(), "limit"=>array($item['list_start_item'],$item['list_max_items'])); //Сортировка

        //Фильтры списка
        $item['list_filter_values'] = array();
        $list_filter_str = '';
        if (!empty(Glob::$vars['mnbv_uri'])&&!empty(SysStorage::$storage[$this->getStorage()]['filter'])&&!empty(SysStorage::$storage[$this->getStorage()]['filter']['view'])){
            //Возьмем фильтр, привязанный к данному хранилищу
            $list_filter = SysStorage::$storage[$this->getStorage()]['filter']; //Пока только фильтр из хранилища по-умолчанию
            $list_filter_values = array();
            foreach ($list_filter['view'] as $flPoz=>$view){
                $flPoz = strval($flPoz);
                if ($view["type"]!=="submitstr"){
                    $flPozVal = null;
                    if (preg_match("/fl_".$flPoz."=([^&]+)/i",Glob::$vars['mnbv_query_string'],$fltrLstArr) && !empty($fltrLstArr[1])) $flPozVal = $fltrLstArr[1];
                    if (isset(Glob::$vars['request']["fl_$flPoz"])) $flPozVal = Glob::$vars['request']["fl_$flPoz"];
                    if (!empty($flPozVal) && $flPozVal!=='nofltr'){
                        $list_filter_values[$flPoz] = $flPozVal;
                        $list_filter_str .= (($list_filter_str!='')?'&':'')."fl_$flPoz=" . $flPozVal;

                        //Сформируем условия
                        switch ($view['type']){
                            case 'same':
                            case 'select':
                                array_push($quFilterArr, "and","$flPoz","=",$flPozVal);
                                break;

                            case 'like':
                                array_push($quFilterArr, "and","$flPoz","like",'%'.$flPozVal.'%');
                                break;

                            case 'more':
                                array_push($quFilterArr, "and","$flPoz",">=",$flPozVal);
                                break;

                            case 'less':
                                array_push($quFilterArr, "and","$flPoz","<=",$flPozVal);
                                break;
                        }
                    }
                }
            }
            $item['list_filter_values'] = $list_filter_values;
            if ($list_filter_str!='') SysLogs::addLog("Filter str=[".$list_filter_str."]");
        }
        
        //Сортировка списка
        //Дефолтовое значение сортировки
        $quConfArr["sort"] = (!empty($item['parent']['vars']['list_sort']))?MNBVf::getSortArr($item['parent']['vars']['list_sort']):array(); //Получим дефолтовую сортировку, если она есть.
        if (!empty(Glob::$vars['mnbv_listsort'])) {
            $item['list_sort']=Glob::$vars['mnbv_listsort'];
            $quConfArr["sort"] = MNBVf::getSortArr($item['list_sort']);
        }
        
        //Базовый URL текущей страницы 
        $item["list_storage_url"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/';
        $item["list_base_url"] = $item["list_storage_url"] . ((!empty($item["parent_id"]))?($item["parent_id"] . '/'):'');
        $item['list_base_url_filter'] = $list_filter_str;
        $item['list_base_url_sort'] = ((!empty($item["list_sort"]))?('sort_'.$item["list_sort"] . '/'):''); //Строка фильтров и сортировки текущего списка
        $item["list_base_url_lang"] = (($item['mnbv_altlang'])?'altlang/':'');
        $item["list_base_url_full"] = $item["list_base_url"] . $item['list_base_url_sort'] . $item['list_base_url_lang'];
        $item["list_base_url_pg"] = (($item['list_page']>1)?'pg'.($item['list_page'].'/'):'');
        $item["list_base_url_alldop"] =  $item['list_base_url_sort'] . $item["list_base_url_lang"] . $item["list_base_url_pg"];
        $item["list_base_url_clear"] =  $item["list_base_url"] . $item["list_base_url_lang"];

        if (isset(SysStorage::$storage[$this->getStorage()]['list']['main']['target']) && SysStorage::$storage[$this->getStorage()]['list']['main']['target']=='_blank') $item["list_link_target"]='_blank';
        
        //При необходимости перебросим пользователя на другую страницу
        if (!empty($redirectToList)) MNBVf::redirect($item["list_base_url_full"].$item["list_base_url_pg"]); //При создании объекта перебросим в тот же список
        
        //Список объектов
        $item['list'] = MNBVStorage::getObjAcc($this->getStorage(),
                array("id","pozid","type","typeval","visible","access","access2","first","name","namelang"),
                $quFilterArr,$quConfArr);
        $item['list_size'] = (int)$item['list'][0]; unset($item['list'][0]); //Вынесем размер списка из массива 
        if ($item["parent_id"]==0 && !(count($item['list'])>0)) { //Нет ни одного объекта в корневой категории
            $PgHtml = '<a href="/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/create/">'.Lang::get("Create storage",$this->tplFolder).'</a>';
        }else{//Категория не нулевая или присутствуют объекты, выводим обычный интерфейс
            foreach ($item['list'] as $key=>$value) if ($key>0) {
                if (!empty($value["id"])) {
                    if ($value["type"]==1)$item['list'][$key]["url"] = $item["list_storage_url"] . $value["id"] . '/' . $item["list_base_url_lang"];
                    else $item['list'][$key]["url"] = $item["list_storage_url"] . $value["id"] . '/update/' . $item["list_base_url_alldop"];
                }
            }
        }
        
        //Метатеги 
        //Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Object list","module_names");   
        Glob::$vars['page_title'] = '/' . $this->controllerName . '/' . $this->getStorage() . '/' . ((!empty($parentid))?($parentid . '/'):'');
        $item['page_h1'] = (!empty(SysStorage::$storage[$this->getStorage()]))?MNBVf::getItemName(SysStorage::$storage[$this->getStorage()]):'';    
        $PgHtml = '';
        $item['page_sctpl'] = 'tpl_baseobj_admlist.php';  
        
        }else{//Нет доступа к отображению папки
            //Метатеги 
            //Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Object list","module_names");   
            Glob::$vars['page_title'] = '/' . $this->controllerName;
            $item['page_h1'] = Lang::get("Storages");    
            $PgHtml = Lang::get("Access denied") . '!';
            //$item['page_sctpl'] = 'tpl_baseobj_admlist.php';  
        }
        
        //Контент страницы  
        $item['page_content'] = $PgHtml;
        
        SysLogs::addLog('Lang: ' . Lang::getLang());
        SysLogs::addLog('DefLang: ' . Lang::getDefLang());

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }


    /**
     * Получает из массива маршрутизации Glob::$vars['mnbv_route_arr'] фильтры и сортировку
     * @return array
     */
    public function getFiltersFromRoute(){
        $result = array("filters","sort");
        foreach(Glob::$vars['mnbv_route_arr'] as $key=>$value) {
            ;// Виды фильтров:
            // /ff_ПОЛЕ_1_123/ - ПОЛЕ>123
            // /ff_ПОЛЕ_2_123/ - ПОЛЕ<123
            // /ff_ПОЛЕ_123/ - ПОЛЕ=123 если параметр строковый или текстовый, то поиск по like '%строка%'
            // /ff-ПОЛЕ_123/ - ПОЛЕ!=123
        }
        return $result;
    }

    /**
     * Получает переменные редактирования из входящих переменных Glob::$vars['request']
     * @return array
     */
    public function getUpdateFromRequest(){
        $result = array();
        foreach(Glob::$vars['request'] as $key=>$value) {
            ;
        }
        return $result;
    }

    /**
     * Редактирование объекта
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_update($tpl_mode='html', $console=false){

        $thisTime = time();

        $this->setStorage(Glob::$vars['mnbv_usestorage']);
        
        $PgHtml = '';//'<a href="/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . Glob::$vars['mnbv_useobj'] . '/view/">Object view</a>';
        $item = array(); //Массив данных, передаваемых во View
        $item['mnbv_altlang'] = Glob::$vars['mnbv_altlang'];
        $item["id"] = Glob::$vars['mnbv_useobj'];

        //Страницы
        $item['list_page'] = (Glob::$vars['mnbv_listpg']>1)?Glob::$vars['mnbv_listpg']:1;
        $item['list_start_item'] = Glob::$vars['list_max_items'] * ($item['list_page'] - 1);
        $item['list_max_items'] = Glob::$vars['list_max_items'];
        
        $item['usestorage'] = $this->getStorage();

        //Фильтры списка
        foreach(Glob::$vars['mnbv_route_arr'] as $key=>$value) {
            ;// Виды фильтров:
            // /ff_ПОЛЕ_1_123/ - ПОЛЕ>123
            // /ff_ПОЛЕ_2_123/ - ПОЛЕ<123
            // /ff_ПОЛЕ_123/ - ПОЛЕ=123 если параметр строковый или текстовый, то поиск по like '%строка%'
            // /ff_ПОЛЕ_123_not/ - ПОЛЕ!=123

            //Виды сортировок:

        }

        //Сортировка списка
        if (!empty(Glob::$vars['mnbv_listsort'])) {
            $item['list_sort']=Glob::$vars['mnbv_listsort'];
            $quConfArr["sort"] = MNBVf::getSortArr($item['list_sort']);
        }

        //Сведения по текущему объекту и по его родительской папке -----------------------------------------------------
        if ($item['obj'] = MNBVf::getStorageObject($this->getStorage(),$item["id"],array('altlang'=>Glob::$vars['mnbv_altlang']))){//Объект для редактирования найден
  
        if (Lang::getLang() != Lang::getDefLang() && !empty($item['obj']['parent']['namelang'])) $item['obj']['parent_name'] = $item['obj']['parent']['namelang'];
        $item['obj']['parent_url'] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/'  . ((Glob::$vars['mnbv_altlang'])?'altlang/':'');
        if (!empty($item['obj']['parent']['parentid'])) $item['obj']['parent_url'] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . ((!empty($item['obj']['parent']['parentid']))?($item['obj']['parent']['parentid'] . '/'):'');
        if (!empty($item['obj']['parent_id']) && !empty($item['obj']['parent']['id'])) $item['obj']['parent_edit'] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item['obj']['parent']['id'] . '/update/';
        
        //Определим вкладку, если надо
        $item['form_one_folder'] = (count(SysStorage::$storage[$this->getStorage()]['view'])<2);
        $item['form_folders_url'] = array();
        $folderscounter = 0;
        foreach (SysStorage::$storage[$this->getStorage()]['view'] as $key=>$value) {
            if (!isset($value["viewonly"]) || ($value["viewonly"]==='folders' && $item['obj']["type"]==ST_FOLDER) || ($value["viewonly"]==='objects' && $item['obj']["type"]==ST_OBJECT)){
                $item['form_folders_url']["$key"] = ($folderscounter>0)?"folder_$key/":'';
                if ($folderscounter==0 || (!empty(Glob::$vars['mnbv_form_folder'])&&Glob::$vars['mnbv_form_folder']==$key)) {
                    $item['form_folder'] = $key;
                    $item['form_folder_url'] = $item['form_folders_url']["$key"];
                }
                $folderscounter++;
            }
        }

        //Отображение панели приложенных файлов
        Glob::$vars['intranet_img_panel_view'] = (Glob::$vars['session']->get('intranet_img_panel_view'))?true:false;

        //Конец сведений по текущему объекту и по его родительской папке -----------------------------------------------


        //При наличии специализированного контроллера обработки данного хранилища подгрузим и выполним его
        $storageSubController =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], MOD_CONTROLLERSPATH . 'Storage'.SysBF::trueName($this->getStorage(),'title').'Controller.php');
        if(file_exists($storageSubController)) include $storageSubController;

        //Возможные действия -------------------------------------------------------------------------------------------
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
        switch ($act){

            case 'update': //Редактирование элемента списка
                $ob_id = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_id',0),'id');
                if (!empty($item["id"]) && $item["id"] == $ob_id){//Должны совпадать, чтоб чего не надо не поменять при случае

                    //Установка маркеров видимости и выделения
                    $ob_visible = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_visible',0),'on');
                    $ob_first = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'ob_first',0),'on');

                    //Получим новые значения полей
                    $updateArr = array("visible"=>$ob_visible, "first"=>$ob_first,);
                    $varsArr = $item['obj']['vars'];
                    $attrValsArr = $item['obj']['attrvals'];
                    $attrArr = $item['obj']['attr'];
                    $attrDBAddArr = array();
                    $attrDelArr = array(); //Массив маркеров удаления атрибутов
                    $varsArrUpd = $attrArrUpd = $attrValsArrUpd = false; //Маркеры необходимости редактирования
                    $attrAddArr = array("objid"=>intval($item["id"])); //Массив добавленного атрибута
                    foreach(Glob::$vars['request'] as $key=>$value){
                        $updateType = false;
                        if (preg_match("/^ob_/",$key) && $key!='ob_visible' && $key!='ob_first' && $key!='ob_id') {
                            $realKey = preg_replace("/^ob_/","",$key);
                            if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["$realKey"]))continue;
                            $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["$realKey"];
                            if ($realKey=='typeval') $realKeyView = array("name"=>"typeval", "type"=>"text", "size"=>255,"width"=>"70%","checktype" => "url");
                            else $realKeyView = SysStorage::$storage[$this->getStorage()]["view"][$item['form_folder']]["$realKey"];                            
                            $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                            $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';
                            $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='ob_',$prefKey='obk_', $prefUpd='obd_');
                            if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                            $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';
                            $updateArr["$realKey"] = SysBF::checkStr($value,$checkType);    
                        }elseif (preg_match("/^obv_/",$key)) {
                            $realKey = preg_replace("/^obv_/","",$key);
                            if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["vars"]["list"]["$realKey"]))continue;
                            $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["vars"]["list"]["$realKey"];
                            $realKeyView = SysStorage::$storage[$this->getStorage()]["view"][$item['form_folder']]["vars"]["view"]["$realKey"];
                            $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                            $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';                            
                            $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='obv_',$prefKey='obvk_', $prefUpd='obvd_');
                            if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                            $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';                            
                            if (!empty($value)) $varsArr["$realKey"] = SysBF::checkStr($value,$checkType); 
                            elseif(isset($varsArr["$realKey"]))unset($varsArr["$realKey"]);
                            $varsArrUpd = true;
                        }elseif (preg_match("/^oba_/",$key)) {
                            $keyRouteArr = preg_split("/_/",$key);
                            $attrItemId = ($keyRouteArr[1]=='add')?'add':intval($keyRouteArr[1]);
                            $realKey = $keyRouteArr[2];
                            if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["attr"]["list"]["$realKey"]))continue;
                            $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["attr"]["list"]["$realKey"];
                            $realKeyView = SysStorage::$storage[$this->getStorage()]["view"][$item['form_folder']]["attr"]["view"]["$realKey"];
                            $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                            $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';                           
                            $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='oba_'.$attrItemId.'_',$prefKey='obak_'.$attrItemId.'_', $prefUpd='obad_'.$attrItemId.'_');
                            if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                            if ($realKey==='delitem' && $value && $attrItemId!=='add') $attrDelArr[]=$attrItemId;                           
                            $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';
                            if (!empty($value)&&$attrItemId==='add')$attrAddArr["$realKey"] = SysBF::checkStr($value,$checkType);
                            elseif (!empty($value)) $attrArr[$attrItemId]["$realKey"] = SysBF::checkStr($value,$checkType);
                            elseif(isset($attrArr[$attrItemId]["$realKey"]))unset($attrArr[$attrItemId]["$realKey"]);
                            $attrArrUpd = true;
                        } elseif (preg_match("/^obav_/",$key)) {                           
                            $realKey = preg_replace("/^obav_/","",$key);
                            $realKeyId = intval(preg_replace("/^attr/","",$realKey));
                            if (empty($realKeyId) || !isset($item["obj"]["attrview"]["$realKey"]))continue;
                            $realKeyView = $item["obj"]["attrview"]["$realKey"];
                            $keyType = ($realKeyView["dbtype"])?$realKeyView["dbtype"]:'';
                            $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';  
                            $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='obav_',$prefKey='obavk_', $prefUpd='obavd_');
                            if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                            $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';                           
                            if (!empty($value)) $attrValsArr["$realKey"] = SysBF::checkStr($value,$checkType); 
                            elseif(isset($attrValsArr["$realKey"]))unset($attrValsArr["$realKey"]);
                            $attrValsArrUpd = true;  
                            
                            //Подготовим данные для сохранения в таблицу (елси это требуется).
                            if ($realKeyView["dbtype"]==="decimal"){
                                $attrDBAddArr[] = array(
                                    "objid"=>$item["id"],
                                    "objparentid"=>$item['obj']['parent']['id'],
                                    "attrid"=>$realKeyId,
                                    "vint"=>MNBVf::decimal2int($attrValsArr["$realKey"],intval($realKeyView["dmsize"])),
                                );
                                $attrValsArr["$realKey"] = round($attrValsArr["$realKey"],intval($realKeyView["dmsize"]));
                            } elseif ($realKeyView["dbtype"]==="int" && $realKeyView["type"]==="list"){
                                //В этом режиме можно выбрать несколько значений за раз, запишем просто их последовательно в базу
                                $listItemValArr = json_decode($attrValsArr["$realKey"]);
                                $curCnt=0;                 
                                if (is_array($listItemValArr)) foreach ($listItemValArr as $lval){
                                    $attrDBAddArr[] = array(
                                        "objid"=>$item["id"],
                                        "objparentid"=>$item['obj']['parent']['id'],
                                        "attrid"=>$realKeyId,
                                        "vint"=>$lval,
                                        "type"=>'list'.$curCnt, //Костылек - в первую запись пишем маркер, по которому удалим из индекса все итемы, а потом добавим
                                    );   
                                    $curCnt++;
                                }
                            } elseif ($realKeyView["dbtype"]==="int"){
                                $attrDBAddArr[] = array(
                                    "objid"=>$item["id"],
                                    "objparentid"=>$item['obj']['parent']['id'],
                                    "attrid"=>$realKeyId,
                                    "vint"=>(!empty($attrValsArr["$realKey"]))?$attrValsArr["$realKey"]:0,
                                );                                
                            }  elseif ($realKeyView["dbtype"]==="string"){
                                $attrDBAddArr[] = array(
                                    "objid"=>$item["id"],
                                    "objparentid"=>$item['obj']['parent']['id'],
                                    "attrid"=>$realKeyId,
                                    "vstr"=>(!empty($attrValsArr["$realKey"]))?$attrValsArr["$realKey"]:'',
                                );
                            }   
                                
                            /* 
                             * Array(
                                    [attr3] => Array
                                        (
                                            [active] => update
                                            [table] => td
                                            [type] => text
                                            [width] => 100%
                                            [filter_type] => all
                                            [checktype] => decimal
                                            [lang] => all
                                            [size] => 11
                                            [dmsize] => 3,
                                            [dbtype] => decimal
                                            [pozid] => 300
                                            [inshort] => 1
                                            [name] => attr3
                                            [namedef] => Вес,кг
                                            [namelang] => Weight,kg
                                        )
                             */
                        }

                    }

                    //Если это папка, то поправим атрибуты вышестоящих папок, поправим ссылку на вышестоящие директории.
                    $tecNewType = (isset($updateArr["type"]))?$updateArr["type"]:$item['obj']["type"];
                    $tecNewParentid = (isset($updateArr["parentid"]))?$updateArr["parentid"]:$item['obj']["parentid"];

                    if (isset($attrAddArr) && count($attrAddArr)>1 && !empty($attrAddArr['attrid'])) $attrArr[]=$attrAddArr; //Если есть новый атрибут, добавим его к массиву атрибутов
                    if ($varsArrUpd) {if (count($varsArr)>0) $updateArr["vars"] = json_encode($varsArr); else $updateArr["vars"] = '';}
                    if ($attrValsArr){if (count($attrValsArr)>0) $updateArr["attrvals"] = json_encode($attrValsArr); else $updateArr["attrvals"] = '';}
                    if ($attrArrUpd) {
                        $delAttrIdArr = array();
                        foreach($attrDelArr as $value) {
                            //При необходимости удалим из индекса удаленные поля    
                            //echo "$value => [{$attrArr[$value]['attrid']}]; ";
                            if (!empty(SysStorage::$storage[$this->getStorage()]['arrtindexuse'])
                                && isset(SysStorage::$storage[SysStorage::$storage[$this->getStorage()]['arrtindexuse']])){
                                $res = MNBVStorage::delObj(SysStorage::$storage[$this->getStorage()]['arrtindexuse'],
                                    array("objparentid","=",$item["id"],"and","attrid","=",$attrArr[$value]['attrid']));
                                SysLogs::addLog("Delete Index Attr[{$attrArr[$value]['attrid']}] to objparentid[{$item["id"]}] " . (($res)?($res.' successful!'):' error!'));
                                $delAttrIdArr[] = $attrArr[$value]['attrid'];
                            }
                            
                            unset($attrArr[$value]); //Удалим из массива выбранные элементы
                        }
                        if (count($delAttrIdArr)) $this->delDnAttr($this->getStorage(),$item["id"],$delAttrIdArr);
                        if (count($attrArr)>0) $updateArr["attr"] = json_encode($attrArr); else $updateArr["attr"] = '';
                        if (count($item['obj']['attr'])>0) $oldAttr = json_encode($item['obj']['attr']); else $oldAttr = '';
                        
                        if ($updateArr["attr"]!==$oldAttr) {
                            $attrArrFin = $item['obj']['attrup'];
                            foreach ($attrArr as $attrvl) $attrArrFin[] = $attrvl;
                            $this->updDnAttrup($item["id"],$attrArrFin);
                        }
                        
                    }

                    //При необходимости подкорректируем вложенные папки
                    $upFolderAlias = '';
                    //||(isset($updateArr["parentid"])&&isset($updateArr["type"])&&$updateArr["parentid"]!=$item['obj']["parentid"] это там было не понятно зачем, оставил, потом разберусь
                    if ($tecNewType==ST_FOLDER && ((isset($updateArr["parentid"])&&$updateArr["parentid"]!=$item['obj']["parentid"])||$attrArrUpd)) {
                        SysLogs::addLog("DnFolders update: tecNewType=[$tecNewType] updateArr={parentid=[".((isset($updateArr["parentid"]))?$updateArr["parentid"]:'NotSet')."] type=[".((isset($updateArr["type"]))?$updateArr["type"]:'NotSet')."] attrArrUpd=[".(($attrArrUpd)?'True':'False')."])");
                        $storageRes = MNBVStorage::getObj(
                            $this->getStorage(),
                            array("id,upfolders,attrup,attr,alias"),
                            array("id","=",$tecNewParentid));
                        if (!empty($storageRes[0])) {//Есть сведения о родительской папке
                            //die(var_dump($storageRes[1]));
                            $storageRes2 = MNBVStorage::upObjInfo($storageRes[1]);
                            $updateArr["upfolders"] = $storageRes2["upfolders"];
                            $updateArr["attrup"] = $storageRes2["attrup"];
                            $upFolderAlias = $storageRes2["alias"];
                            //SysLogs::addLog("------------>storageRes[1]={'alias':'{$storageRes[1]["alias"]}', 'id':'{$storageRes[1]["id"]}'}");
                            //SysLogs::addLog("------------>storageRes2={'alias':'{$storageRes2["alias"]}', 'id':'{$storageRes2["id"]}','attrup':'{$storageRes2["attrup"]}'}");
                        }else{//Нет сведений о родительской папке
                            $updateArr["upfolders"] = '';
                            $updateArr["attrup"] = '';
                            $upFolderAlias = '';
                        }

                        //Внесем изменения в нижестоящие папки
                        $tecNewAttr = (isset($updateArr["attr"]))?$updateArr["attr"]:((isset($item["obj"]["attr"]) && count($item["obj"]["attr"]>0))?json_encode($item["obj"]["attr"]):'');
                        $this->updateUpObjInfo(array("id"=>$item['id'],"upfolders"=>$updateArr["upfolders"],"attrup"=>$updateArr["attrup"],"attr"=>$tecNewAttr));
                    }else{ //Если папку не меняли, получим данные по родительской папке
                        $storageRes = MNBVStorage::getObj(
                            $this->getStorage(),
                            array("id,alias"),
                            array("id","=",$tecNewParentid));
                        if (!empty($storageRes[0])) $upFolderAlias = $storageRes[1]["alias"];
                    }
                    
                    //Выполним обработку входных данных
                    if ('on' == SysBF::getFrArr(Glob::$vars['request'],'obd_alias_autogen','')) $updateArr["alias"] = MNBVf::str2alias (SysBF::getFrArr($updateArr,'name','')); //Авто формирование алиаса
                                      
                    if (SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'del',''),'on')==1){ //Удалим данную запись, если это требуется
                        $res = MNBVStorage::delObj($this->getStorage(),array("id",'=',$item["id"]));
                        SysLogs::addLog("Delete object /".$this->getStorage()."/".$item["id"]."/ ".(($res)?'successful!':'error!'));
                        $redirectToList = true;
                    }else{ //Установим новые значения полей.
                        $updateArr["author"] = Glob::$vars['user']->get('name');
                        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                        $updateArr["editdate"] = $thisTime;
                        $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                        
                        //Если поменялись:папка, название(р/л), префикс(р/л), модель, то перегенерим поисковые поля
                        if ($this->getStorage()===Glob::$vars['prod_storage'] 
                                && (isset($updateArr["name"])||isset($updateArr["namelang"])
                                ||isset($updateArr["prefix"])||isset($updateArr["prefixlang"])
                                ||isset($updateArr["partnumber"])||isset($updateArr["model"]))){
                                    
                            $sr_type = (isset($updateArr["type"]))?$updateArr["type"]:$item['obj']["type"];    
                            $sr_name = (isset($updateArr["name"]))?$updateArr["name"]:$item['obj']["name"];    
                            $sr_namelang = (isset($updateArr["namelang"]))?$updateArr["namelang"]:$item['obj']["namelang"]; 
                            $sr_prefix = (isset($updateArr["prefix"]))?$updateArr["prefix"]:$item['obj']["prefix"]; 
                            $sr_prefixlang = (isset($updateArr["prefixlang"]))?$updateArr["prefixlang"]:$item['obj']["prefixlang"]; 
                            $sr_partnumber = (isset($updateArr["partnumber"]))?$updateArr["partnumber"]:$item['obj']["partnumber"]; 
                            $sr_model = (isset($updateArr["model"]))?$updateArr["model"]:$item['obj']["model"]; 
                            $sr_barcode = (isset($updateArr["barcode"]))?$updateArr["barcode"]:$item['obj']["barcode"];
        
                            $updateArr["norm_partnumber"] = '';
                            $updateArr["norm_search"] = '';
                            $searchObj = new MNBVSearch();
                            $sExeptArr = array();
                            $searchObj->del(Glob::$vars['prod_storage'],$item['obj']["id"]);
                            if ($sr_type!==ST_FOLDER) {
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$item['obj']["id"],0,6,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_partnumber,0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],preg_replace("/[^0-9]/","",$sr_partnumber),0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_barcode,0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],str_replace(' ', '', $sr_model),0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],preg_replace("/[^0-9]/","",$sr_model),0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_prefix,0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_prefixlang,0,2,$item['obj']["siteid"],$sExeptArr);
                                //$sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_name,0,2,$item['obj']["siteid"],$sExeptArr);
                                //$sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_namelang,0,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']['parent']['name'],$sr_name,0,2,$item['obj']["siteid"],$sExeptArr);
                                if (!empty($item['obj']['parent']['namelang'])) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']['parent']['namelang'],$sr_namelang,0,2,$item['obj']["siteid"],$sExeptArr);
                            
                                $updateArr["norm_search"] .= ',' . $item['obj']["id"];
                                $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_barcode,'zpt_ok');
                                $updateArr["norm_partnumber"] .= SysBF::strNormalize($sr_partnumber,'zpt_ok');
                                $updateArr["norm_search"] .= ',' . $updateArr["norm_partnumber"];
                                $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_model);
                                
                                //Подтянем имя вендора
                                $res = MNBVStorage::getObj(Glob::$vars['vend_storage'],
                                        array("name","namelang"),
                                        array("id","=",$item['obj']["vendor"]));
                                if (!empty($res[0])) {
                                    $updateArr["norm_search"] .= ',' . SysBF::strNormalize($res[1]['name']);
                                    $updateArr["norm_search"] .= ',' . SysBF::strNormalize($res[1]['namelang']);
                                    $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$res[1]['name'],0,2,$item['obj']["siteid"],$sExeptArr);
                                    $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$res[1]['namelang'],0,2,$item['obj']["siteid"],$sExeptArr);
                                }
                                
                                //Подтянем Страну
                                $res = MNBVStorage::getObj(Glob::$vars['prod_country_storage'],
                                        array("name","namelang"),
                                        array("id","=",$item['obj']["country"]));
                                if (!empty($res[0])) {
                                    $updateArr["norm_search"] .= ',' . SysBF::strNormalize($res[1]['name']);
                                    $updateArr["norm_search"] .= ',' . SysBF::strNormalize($res[1]['namelang']);
                                    $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$res[1]['name'],0,1,$item['obj']["siteid"],$sExeptArr);
                                    $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$res[1]['namelang'],0,1,$item['obj']["siteid"],$sExeptArr);
                                }
                                
                                //TODO - позже подтянуть также цвет
                            }else{
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_prefix,1,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_prefixlang,1,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_name,1,2,$item['obj']["siteid"],$sExeptArr);
                                $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$item['obj']["id"],$sr_namelang,1,2,$item['obj']["siteid"],$sExeptArr);
                            }
                            
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_name);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_namelang);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_prefix);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($sr_prefixlang); 
                            
                            SysLogs::addLog("Update norm_partnumber=[{$updateArr["norm_partnumber"]}]");
                            SysLogs::addLog("Update norm_search=[{$updateArr["norm_search"]}]");
                            
                            //Определим мин и макс размеры
                            $updateArr["brminw"] = 0;
                            $updateArr["brmaxw"] = 0;
                            if (!empty($updateArr["onlyvert"])){ //Можно перевозить только вертикально. выбираем из длины и ширины
                                if (!empty($updateArr["brwidth"]) && $updateArr["brwidth"]>$updateArr["brmaxw"]) $updateArr["brmaxw"] = $updateArr["brwidth"];
                                if (!empty($updateArr["brlength"]) && $updateArr["brlength"]>$updateArr["brmaxw"]) $updateArr["brmaxw"] = $updateArr["brlength"];

                                if (!empty($updateArr["brwidth"]) && $updateArr["brwidth"]<$updateArr["brminw"]) $updateArr["brminw"] = $updateArr["brwidth"];
                                if (!empty($updateArr["brlength"]) && $updateArr["brlength"]<$updateArr["brminw"]) $updateArr["brminw"] = $updateArr["brlength"];
                            }else{ //Можно перевозить как угодно
                                if (!empty($updateArr["brheight"]) && $updateArr["brheight"]>$updateArr["brmaxw"]) $updateArr["brmaxw"] = $updateArr["brheight"];
                                if (!empty($updateArr["brwidth"]) && $updateArr["brwidth"]>$updateArr["brmaxw"]) $updateArr["brmaxw"] = $updateArr["brwidth"];
                                if (!empty($updateArr["brlength"]) && $updateArr["brlength"]>$updateArr["brmaxw"]) $updateArr["brmaxw"] = $updateArr["brlength"];

                                if (!empty($updateArr["brheight"]) && $updateArr["brheight"]<$updateArr["brmaxw"]) $updateArr["brminw"] = $updateArr["brheight"];
                                if (!empty($updateArr["brwidth"]) && $updateArr["brwidth"]<$updateArr["brminw"]) $updateArr["brminw"] = $updateArr["brwidth"];
                                if (!empty($updateArr["brlength"]) && $updateArr["brlength"]<$updateArr["brminw"]) $updateArr["brminw"] = $updateArr["brlength"];
                            }
                                
                            //Объем
                            if (!empty($updateArr["brwidth"]) && !empty($updateArr["brheight"]) && !empty($updateArr["brlength"])) {
                                $updateArr["brvolume"] = $updateArr["brwidth"] * $updateArr["brheight"] * $updateArr["brlength"] / 1000000;
                            }
                            
                            //Весовая категория
                            $updateArr["weightgr"] = 0;
                            if (!empty($updateArr["brweight"])){
                                foreach(Glob::$vars['one_weightgr_types_levels'] as $key=>$vval) {
                                    if ($updateArr["brweight"]>$vval) continue;
                                    $updateArr["weightgr"] = $key;
                                    break;
                                }
                            }
                            
                            //Размерная категория
                            $updateArr["sizegr"] = 0;
                            foreach(Glob::$vars['one_sizegr_types_levels'] as $key=>$vval) {
                                if ($updateArr["brvolume"]>$vval["v"]) continue;
                                if (!empty($updateArr["brheight"]) && $updateArr["brheight"]>$vval["h"]) continue;
                                if (!empty($updateArr["brmaxw"]) && $updateArr["brmaxw"]>$vval["l"]) continue;
                                $updateArr["sizegr"] = $key;
                                break;
                            }
                            
                        }
                        
                        $res = MNBVStorage::setObj($this->getStorage(), $updateArr, array("id",'=',$item["id"]));
                        SysLogs::addLog("Update object /".$this->getStorage()."/".$item["id"]."/ ".(($res)?'successful!':'error!'));
                        
                        //Доработаем индекс
                        if (count($attrDBAddArr)
                                && !empty(SysStorage::$storage[$this->getStorage()]['arrtindexuse'])
                                && isset(SysStorage::$storage[SysStorage::$storage[$this->getStorage()]['arrtindexuse']])
                                ){ //Есть что добавить в индекс атрибутов и индекс такой существует и используется
                            foreach($attrDBAddArr as $addAtrItem){
                                if (!empty($addAtrItem["type"]) && $addAtrItem["type"]==='list0'){ //Если это список, то чистим индекс и заново заполняем
                                    $res = MNBVStorage::delObj(SysStorage::$storage[$this->getStorage()]['arrtindexuse'],
                                            array("objid","=",$addAtrItem["objid"],"and","attrid","=",$addAtrItem["attrid"]));
                                    SysLogs::addLog("Delete Index Attr[{$addAtrItem['attrid']}] to object[{$addAtrItem['objid']}] " . (($res)?($res.' successful!'):' error!'));
                                }
                                    
                                $res = MNBVStorage::getObj(
                                    SysStorage::$storage[$this->getStorage()]['arrtindexuse'],
                                    array("id"),
                                    array("objid","=",$addAtrItem["objid"],"and","attrid","=",$addAtrItem["attrid"])); 
                                if (!empty($res[0]) && !isset($addAtrItem["type"])) {
                                    $res = MNBVStorage::setObj(SysStorage::$storage[$this->getStorage()]['arrtindexuse'], $addAtrItem, array("id",'=',$res[1]["id"]));
                                    SysLogs::addLog("Update Index Attr[{$addAtrItem['attrid']}] to object[{$addAtrItem['objid']}] " . (($res)?($res.' successful!'):' error!'));
                                } else {    
                                    if (isset($addAtrItem["type"])) unset($addAtrItem["type"]);
                                    $res = MNBVStorage::addObj(SysStorage::$storage[$this->getStorage()]['arrtindexuse'], $addAtrItem);
                                    SysLogs::addLog("Create Index Attr[{$addAtrItem['attrid']}] to object[{$addAtrItem['objid']}] " . (($res)?($res.' successful!'):' error!'));
                                }
                            }
                        }
                        
                        $reloadObjects = true;
                    }

                    //Если требуется, то переключим видимость панели приложенных файлов
                    if ($imgpanelsw = SysBF::getFrArr(Glob::$vars['request'],'imgpanelsw','')) {
                        Glob::$vars['intranet_img_panel_view'] = ($imgpanelsw == 'right' || $imgpanelsw == 'down')?$imgpanelsw:false;
                        Glob::$vars['session']->set('intranet_img_panel_view',Glob::$vars['intranet_img_panel_view']);
                        Glob::$vars['session']->save(); //Сохраним данные сессии
                    }
                }

                break;

        }
        //Возможные действия конец обработки ---------------------------------------------------------------------------

        if (!empty($reloadObjects)){//Еще раз получим сведения по текущему объекту, если были изменения.
         
            $item['obj'] = MNBVf::getStorageObject($this->getStorage(),$item["id"],array('altlang'=>Glob::$vars['mnbv_altlang']));
            
            if (Lang::getLang() != Lang::getDefLang() && !empty($item['obj']['parent']['namelang'])) $item['obj']['parent_name'] = $item['obj']['parent']['namelang'];
            $item['obj']['parent_url'] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/'  . ((Glob::$vars['mnbv_altlang'])?'altlang/':'');
            if (!empty($item['obj']['parent']['parentid'])) $item['obj']['parent_url'] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . ((!empty($item['obj']['parent']['parentid']))?($item['obj']['parent']['parentid'] . '/'):'');
            if (!empty($item['obj']['parent_id']) && !empty($item['obj']['parent']['id'])) $item['obj']['parent_edit'] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item['obj']['parent']['id'] . '/update/';

            //Определим вкладку, если надо
            $item['form_one_folder'] = (count(SysStorage::$storage[$this->getStorage()]['view'])<2);
            $item['form_folders_url'] = array();
            $folderscounter = 0;
            foreach (SysStorage::$storage[$this->getStorage()]['view'] as $key=>$value) {
                if (!isset($value["viewonly"]) || ($value["viewonly"]==='folders' && $item['obj']["type"]==ST_FOLDER) || ($value["viewonly"]==='objects' && $item['obj']["type"]==ST_OBJECT)){
                    $item['form_folders_url']["$key"] = ($folderscounter>0)?"folder_$key/":'';
                    if ($folderscounter==0 || (!empty(Glob::$vars['mnbv_form_folder'])&&Glob::$vars['mnbv_form_folder']==$key)) {
                        $item['form_folder'] = $key;
                        $item['form_folder_url'] = $item['form_folders_url']["$key"];
                    }
                    $folderscounter++;
                }
            }
            
            //Если требуется, то внесем изменения в хранилище алиасов
            if (!empty(SysStorage::$storage[$item['usestorage']]['custom_url'])){
                $urlmaster = new MNBVURL(2,Glob::$vars['url_types']); 
                $urlmaster->setItemAlias($item['usestorage'],$item['obj']["id"],$item['obj']['alias'],$item['obj']['type'],$upFolderAlias,$item['obj']['siteid']);
                SysLogs::addLog("Update URL: urltype=[".$item['usestorage']."] id=[".$item['obj']["id"]."] alias=[".$item['obj']['alias']."] objtype=[".$item['obj']['type']."] upFolderAlias=[$upFolderAlias] siteId=[".$item['obj']['siteid']."]");
            }

        }
        
        //Конец сведений по текущему объекту и по его родительской папке -----------------------------------------------


        //Базовые URL
        $item["list_storage_url"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/';
        $item["list_base_url"] = $item["list_storage_url"] . ((!empty($item['obj']["parent"]["id"]))?($item['obj']["parent"]["id"] . '/'):'');
        $item['list_base_url_filter'] = '';
        $item['list_base_url_sort'] = ((!empty($item["list_sort"]))?($item["list_sort"] . '/'):''); //Строка фильтров и сортировки текущего списка
        $item["list_base_url_lang"] = (($item['mnbv_altlang'])?'altlang/':'');
        $item["list_base_url_altlang"] = (($item['mnbv_altlang'])?'':'altlang/');
        $item["list_base_url_pg"] = (($item['list_page']>1)?'pg'.($item['list_page'].'/'):'');
        $item["list_base_url_alldop"] =  $item['list_base_url_filter'] . $item['list_base_url_sort'] . $item["list_base_url_lang"] . $item["list_base_url_pg"];
        $item["list_base_url_full"] = $item["list_base_url"] . $item["list_base_url_alldop"];
        $item["obj_view_url"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item["obj"]["id"] . '/view/' . $item["list_base_url_alldop"];
        $item["obj_update_url_lang"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item["obj"]["id"] . '/update/' . $item['list_base_url_filter'] . $item['list_base_url_sort'] . $item["list_base_url_lang"] . $item["list_base_url_pg"];
        $item["obj_update_url_altlang"] = '/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item["obj"]["id"] . '/update/' . $item['list_base_url_filter'] . $item['list_base_url_sort'] . $item["list_base_url_altlang"] . $item["list_base_url_pg"];

        //При необходимости перебросим пользователя на другую страницу
        if (!empty($redirectToList)) MNBVf::redirect($item["list_base_url_full"]); //При создании объекта перебросим в тот же список

        //Метатеги
        //Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Object list","module_names");
        Glob::$vars['page_title'] = '/' . $this->controllerName . '/' . $this->getStorage() . '/' . $item["id"] . '/update/';
        $item['page_h1'] = MNBVf::getItemName(SysStorage::$storage[$this->getStorage()]);
        $item['page_sctpl'] = 'tpl_baseobjupdate.php';

        //Изменение настроек панели приложенных изображений
        $maxSizeProfile = (isset(Glob::$vars['img_max_size'][$item['usestorage']]))?$item['usestorage']:"default";
        $item["img_max_size"] = MNBVf::getImgMaxSize($maxSizeProfile,Glob::$vars['img_max_size']); //Массив с настройками трансформации
        $form_img_num = $item["img_max_size"]['form_img_num'];  //Количество изображений в панели редактирования
        $form_att_num = $item["img_max_size"]['form_att_num'];  //Количество приложенных файлов в панели редактирования
        $item["img_max_size_profile"] = $maxSizeProfile; //Название профиля размеров изображений
        if ($item["obj"]["id"] == Glob::$vars['session']->get('img_max_size_objid') && $imgSizeType = Glob::$vars['session']->get('img_max_size_profile')) {
            if (isset(Glob::$vars['img_max_size']["$imgSizeType"])) $maxSizeProfile = $imgSizeType;
            $item["img_max_size"] = MNBVf::getImgMaxSize($maxSizeProfile,Glob::$vars['img_max_size']); //Массив с настройками трансформации
            $item["img_max_size_profile"] = $maxSizeProfile; //Название профиля размеров изображений
            $item["img_max_size"]['form_img_num'] = $form_img_num;  //Количество изображений в панели редактирования
            $item["img_max_size"]['form_att_num'] = $form_att_num;  //Количество приложенных файлов в панели редактирования
        }
        $item["img_сrop_type"] = $item["img_max_size"]["img_update"]; //Тип трансформации изображения берем четко из конфига по текущему хранилищу
        //---------------------------------------------------


        }else{//Нет доступа к отображению папки
            //Метатеги 
            //Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Object list","module_names");   
            Glob::$vars['page_title'] = '/' . $this->controllerName;
            $item['page_h1'] = Lang::get("Storages");    
            $PgHtml = Lang::get("Access denied") . '!';
            //$item['page_sctpl'] = 'tpl_baseobj_admlist.php';  
        }
        
        $item['page_content'] = $PgHtml;

        //Формирование полей nd,ch,dt,vars объекта --------------------------------------------------------------------------

        //Конец формирования полей объекта -----------------------------------------------------------------------------

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);

        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();   
        
    }
    
    /**
     * Редактирование объекта
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_view($tpl_mode='html', $console=false){

        $this->setStorage(Glob::$vars['mnbv_usestorage']);
        
        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("View object","module_names"); //Метатеги
        $item = array(); //Массив данных, передаваемых во View
        $PgHtml = '<a href="/' . $this->thisModuleName . '/' . $this->controllerName . '/' . $this->getStorage() . '/' . Glob::$vars['mnbv_useobj'] . '/update/">Object update</a>';

        //$item['page_sctpl'] = 'tpl_baseobjlist.php';
        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_content'] = $PgHtml;

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main.php'),$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
}
