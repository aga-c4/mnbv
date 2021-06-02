<?php
/**
 * RobotsController class - класс робота для сбора основной статистики биржи Yobit
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class RobotsCatimportController extends AbstractMnbvsiteController{

    /**
     * @var string - Имя робота
     */
    public $thisModuleName = '';

    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }
    
    /**
     * @var array - массив категорий с метками активности и блокировки. 
     */
    public $catArr = array();
    
    /**
     * @var array - массив вендоров с алиасами, синонимами и названиями. 
     */
    public $vendArr = array();
    
    /**
     * @var array - массив стран с алиасами, синонимами и названиями. 
     */
    public $countryArr = array();
    
    /**
     * @var array массив запрещенных к загрузке категорий с учетом вложенных
     */
    public $cat_deny = array();
    
    /**
     * @var array массив разрешенных к загрузке категорий с учетом вложенных
     */
    public $cat_allow = 'all';

    /**
     * @var $int категория в которую мы импортируем структуру товаров
     */
    public $cat_point = 1;
    
    /**
     * @var array массив, содержащий стурктуру категорий импорта ('root' - самый высокий уровень) 
     */
    public $cats_stru = array();

    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        #################################################################
        # Стартовый конфиг
        #################################################################
        ini_set('max_execution_time', 0); //Максимальное время выполнения скрипта, установим в 0, чтоб небыло ограничений. Устанавливаем в контроллере, т.к. могут быть роботы с установленным ограничением по времени
        $usleepTime = 1; //1 секунда - понадобится позже при вычислении реального времени выполнения.
        //SysLogs::$logsEnable = false; //Накапливать лог
        //SysLogs::$errorsEnable = false; //Накапливать лог ошибок
        //SysLogs::$logRTView = true; //Выводить сообщения непосредственно при их формировании. Если не установлено SysLogs::$logView, то выводятся только ошибки
        //SysLogs::$logView = false; //Показывать лог событий скрипта (суммарный для ошибок и событий). Если не задано, то сообщения обычные в лог не будут выводиться даже при установленном SysLogs::$logRTView
        #################################################################

        usleep(1000000 * $usleepTime); //Спим $usleepTime секунд. чтоб все по базам записалось
        $procId = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'proc',''),'int');
        $rsid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'rsid',''),'strictstr');

        $proc = new MNBVRobot($procId);
        $procProp = $proc->getObj();
        $proc->setPsid($rsid);
        $procProp['sid'] = $rsid;

        if ($procProp!==null && (empty($procProp['sid']) || $procProp['sid']==$rsid)) {//Продолжаем работу только если данное задание не имеет sid, т.е. не запущено.

            //Откроем сессию, подключим пользователя, того, кто был редактором задания на выполнение.
            Glob::$vars['session'] = new MNBVSession(true,'','Nosave'); //Инициализация сессии
            Glob::$vars['session']->set('userid',$procProp['edituser']); //Скрипт запускается от идентификатора пользователя последнего редактора
            Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));

            //Установки языка и инициализация словаря
            if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
            MNBVf::requireFile(MNBVf::getRealFileName($this->thisModuleName, 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля

            echo "Start MNBV robot " . $this->thisModuleName . "! \n";
            echo "RSid=[$rsid]\n";
            echo "Pid=[".$proc->getPid()."]\n";
            echo "UserId=[".Glob::$vars['session']->get('userid')."]\n";
            echo "Script=[".$procProp['vars']['script']."]\n";
            echo "Output=[".$procProp['vars']['output']."]\n";

            $continueOk = true;
            
            $procProp = $proc->getObjById($procId);
            $scriptvarsArr = array();
            if (!empty($procProp['vars']['scriptvars'])) {
                echo "Scriptvars=".$procProp['vars']['scriptvars']."\n";
                $scriptvarsArr = json_decode($procProp['vars']['scriptvars'],true);
            }
            
            if (!is_array($scriptvarsArr)){
                echo "Error: no scriptvarsArr!\n";
                $continueOk = false;
            }
            
            //То, что делает робот
            echo date("Y-m-d G:i:s") . " Run script!\n";
            $this->thisTime = time();
            $this->thisDateTime = date("Y-m-d H:i:s",$this->thisTime);

            ############################################################################################################
            ## То, что делает робот
            ############################################################################################################
            /*
            //Открое файл с логом для записи туда результата работы
            //Запишем в файл
            $outputFilename = str_replace('[obj_id]',$procId,$outputFilename); //Имя файла лога действий этого скрипта.
            $outputFilenamePos = str_replace('[obj_id]',$procId,$outputFilenamePos); //Имя файла лога позиций этого скрипта.
            //Зарегистрируем приложенные файлы, куда будем выгружать данные
            if (!isset($procProp['files']['att'])) $procProp['files']['att'] = array();
            $procProp['files']['att']['3'] = array('type'=>'txt','fname'=>'log.txt');
            if (!isset($procProp['files']['att'])) $procProp['files']['att'] = array();
            $procProp['files']['att']['4'] = array('type'=>'txt','fname'=>'logpos.csv');
            $procPropFilesUpd = json_encode($procProp['files']);
            MNBVStorage::setObj(Glob::$vars['robotsRunStorage'], array('files'=>$procPropFilesUpd), array("id",'=',$procProp["id"]));
            */            
            
            ####################################################################
            ## Формирование товаров и категорий из YML фида
            ####################################################################

            if ($continueOk) {
                $feedSource = (!empty($scriptvarsArr['feed_source']))?$scriptvarsArr['feed_source']:'';
                if (empty($feedSource) || !file_exists($feedSource)) {
                    echo "Error: File [$feedSource] is not exist!\n";
                    $continueOk = false;
                } 
            }
            
            if ($continueOk) {
                $feedFileStr = file_get_contents($feedSource);
                if ($feedFileStr===false){
                    echo "Error opening file [$feedSource]!\n";
                    $continueOk = false;
                }
            }

            if ($continueOk) { //Фид найден и распарсен, далее обработка
                $objSource = simplexml_load_string($feedFileStr); //XML в объект
                //$arrSource =  (array) $objSource; //Объект в массив
                //print_r($arrSource);
                //$jsonSource = json_encode($objSource); //Объект в JSON
                //$arraySource = json_decode($jsonSource,TRUE); //JSON в массив

                //составим массив структуры категорий с маркерами активности, в т.ч. проверим товар на блокировку по категории, включая вложенные
                $this->siteid = SysBF::getFrArr($scriptvarsArr, 'siteid',0);
                $this->cat_deny = SysBF::getFrArr($scriptvarsArr, 'cat_deny',array());
                $this->cat_allow = SysBF::getFrArr($scriptvarsArr, 'cat_allow','all');
                $this->vendArr = array();
                $this->countryArr = array();
                $this->catArr = array('root' => array(
                    "id" => 0,
                    "parentid" => 0,
                    "name" => 'root',
                    "alias" => '',
                    "searchstr" => '',
                    "allow" => true,
                    "dbid" => $this->cat_point
                ));
                $this->cats_stru['root'] = array();
                foreach ($objSource->shop->categories->children() as $node){
                    $attrArr = $node->attributes();
                    if (!isset($attrArr['id'])) continue;
                    $id = intval($attrArr['id']); //!!!Возможны иные преобразования категории из базового значения
                    if ($id==0) continue;
                    $parentid = (!empty($attrArr['parentId']))?intval($attrArr['parentId']):'root';
                    $key = strval($id);
                    $itemName = SysBF::checkStr($node,'stringkav');
                    $this->catArr[$key] = array(
                        "id" => $id,
                        "parentid" => $parentid,
                        "name" => $itemName,
                        "alias" => MNBVf::str2alias($node),
                        "full_alias" => MNBVf::str2alias($node),
                        "searchstr"=>"", //Строка для синонимов, если есть возможность их получить.
                    );
                    echo "cat id=[$id] parentid=[$parentid] [".$itemName."] alias=[".$this->catArr[$key]["alias"]."]\n";
                }

                echo "Products - circle1 ".$this->getMem()."\n";
                
                //Первый проход по товарам, создадим недостающие категории, вендоры, атрибуты и их значения
                $prodCounter = 0;
                foreach ($objSource->shop->offers->children() as $node){
                    $attrArr = $node->attributes();
                    if (!isset($attrArr['id'])) continue;
                    
                    $id = intval($attrArr['id']); //!!!Возможны иные преобразования товара из базового значения
                    $xmlCode = (!empty($node->xmlCode))?intval($node->xmlCode):0; //!!!Возможны иные преобразования товара из базового значения
                    if ($id==0) continue;
                    //if ($xmlCode==0) continue;
                    
                    //Что считать входным идентификатором и что делать если его нет (вы для себя делайте по вашим задачам)
                    $outid = $id;
                    //$outid = $xmlCode; //Вариант выбора базового id из источника
                    if (empty($outid)) continue;
                    
                    $categoryId = (!empty($node->categoryId))?intval($node->categoryId):0;
                    if ($categoryId==0) continue;
                    if (!$this->checkFolder($categoryId)) continue;
                    
                    //Вендор 
                    $vendor_search = '';
                    $vendorStr = (!empty($node->vendor))?SysBF::checkStr($node->vendor,'stringkav'):'';
                    $vendor = $this->checkVendor($vendorStr,$vendor_search);
                    if (empty($vendor)) continue;
                    
                    //Страна
                    $country_search = '';
                    $countryStr = (!empty($node->country_of_origin))?SysBF::checkStr($node->country_of_origin,'stringkav'):'';
                    $country = $this->checkCountry($countryStr,$country_search);
                    if (empty($country)) continue;
                    
                        
                    $prodCounter++;
                    //echo "$prodCounter id=[$id] catid=[$categoryId]  vend=[$vendorStr][$vendor] ".$this->getMem()."\n";
                    
                    //Разбор параметров - надо доработать
                }
                
                echo "Products - circle2 ".$this->getMem()."\n";
                
                $this->createFolders();
                
                //Второй проход по товарам, параллельно сверяясь и дополняя массив категорий
                $prodCounter = 0;
                foreach ($objSource->shop->offers->children() as $node){
                    $updateArr = array();
                    $updateArr["searchstr"] = '';
                    $attrArr = $node->attributes();
                    if (!isset($attrArr['id'])) continue;
                    
                    $id = intval($attrArr['id']); //!!!Возможны иные преобразования товара из базового значения
                    $xmlCode = (!empty($node->xmlCode))?intval($node->xmlCode):0; //!!!Возможны иные преобразования товара из базового значения
                    
                    if ($id==0) continue;
                    //if ($xmlCode==0) continue;
                    
                    //Что считать входным идентификатором и что делать если его нет (вы для себя делайте по вашим задачам)
                    $outid = $id;
                    //$outid = $xmlCode; //Вариант выбора базового id из источника
                    $partnumber = $xmlCode;
                    
                    //Проверка на категорию
                    $parentid = 0;
                    $upFolderAlias = '';
                    $categoryId = (!empty($node->categoryId))?intval($node->categoryId):0;
                    if (!empty($categoryId) && isset($this->catArr[strval($categoryId)]) && isset($this->catArr[strval($categoryId)]['dbid'])) {
                        $parentid = $this->catArr[strval($categoryId)]['dbid'];
                        $upFolderAlias = (!empty($this->catArr[strval($categoryId)]['full_alias']))?$this->catArr[strval($categoryId)]['full_alias']:'';
                        if (!empty($this->catArr[strval($categoryId)]['searchstr'])) $updateArr["searchstr"] .= ',' . $this->catArr[strval($categoryId)]['searchstr'];
                    }else{
                        continue;
                    }
                    
                    
                    //Проверка на вендора
                    $vendorStr = (!empty($node->vendor))?trim(SysBF::checkStr($node->vendor,'stringkav')):'';
                    $vendorid = 0;
                    if (!empty($vendorStr) && isset($this->vendArr[$vendorStr]) && !empty($this->vendArr[$vendorStr]["dbid"])) {
                        $vendorid = $this->vendArr[$vendorStr]["dbid"];
                        if (!empty($this->vendArr[$vendorStr]["searchstr"])) $updateArr["searchstr"] .= ',' . $this->vendArr[$vendorStr]["searchstr"];
                    }else{
                        continue;
                    }
                    
                    //Проверка на страну
                    $countryStr = (!empty($node->country_of_origin))?trim(SysBF::checkStr($node->country_of_origin,'stringkav')):'';
                    $countryid = 0;
                    if (!empty($countryStr) && isset($this->countryArr[$countryStr]) && !empty($this->countryArr[$countryStr]["dbid"])) {
                        $countryid = $this->countryArr[$countryStr]["dbid"];
                        if (!empty($this->countryArr[$countryStr]["searchstr"])) $updateArr["searchstr"] .= ',' . $this->countryArr[$countryStr]["searchstr"];
                    }else{
                        continue;
                    }      
                    
                    //Проверки пройдены
                    $prodCounter++;
                    
                    //Что считать входным идентификатором и что делать если его нет (вы для себя делайте по вашим задачам)
                    if (empty($outid)) continue;
                    //Подгрузим данные о товаре, если они есть
                    $product = false;
                    $res = MNBVStorage::getObj(Glob::$vars['prod_storage'],
                            array("*"),
                            array("outid","=",$outid,"and","type","!=",ST_FOLDER));
                    if (!empty($res[0])) $product = $res[1];
                    
                    if ($product!==false){ //Найден подходящий внутренний товар, доработаем его
                        
                        $updateArr["parentid"] = $parentid;
                        $updateArr["vendor"] = $vendorid;
                        $updateArr["country"] = $countryid;
                        $updateArr["partnumber"] = $partnumber;
                        $updateArr["quantity"] = (isset($attrArr['available'])&&$attrArr['available']=="true")?1:0;
                        $updateArr["donorurl"] = (!empty($node->url))?SysBF::checkStr($node->typePrefix,'url'):'';
                        $updateArr["price"] = (!empty($node->price))?round(floatval($node->price),2):0;
                        $updateArr["prefix"] = (!empty($node->typePrefix))?SysBF::checkStr($node->typePrefix,'stringkav'):'';
                        $updateArr["model"] = (!empty($node->model))?SysBF::checkStr($node->model,'stringkav'):'';
                        $updateArr["name"] = $updateArr["prefix"] . ' ' . $vendorStr . ' ' . $updateArr["model"];
                        $updateArr["alias"] = MNBVf::str2alias($updateArr["model"]);
                        $updateArr["text"] = (!empty($node->description))?str_replace("\n","<br>\n",SysBF::checkStr($node->description,'stringkav')):'';
                        $updateArr["barcode"] = (!empty($node->barcode))?SysBF::checkStr($node->barcode,'stringkav'):'';

                        //Добавим картинки
                        $pictureSrc = (array) $node->picture;
                        $picture = '';
                        if (is_array($pictureSrc)) {
                            foreach ($pictureSrc as $curPic){
                                if (!empty($curPic)) {
                                    $picture = SysBF::checkStr($curPic,'url');
                                    break; //На старте делаем только одну, нужно еще определить откуда ее брать, если это не ссылка
                                }
                            }
                        }else{
                            $picture = (!empty($pictureSrc))?$pictureSrc:'';
                        }
                        
                        //Сформируем поисковые строки
                        $updateArr["norm_partnumber"] = '';
                        $updateArr["norm_search"] = '';
                        $updateArr["norm_partnumber"] .= SysBF::strNormalize($updateArr["partnumber"],'zpt_ok');
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($product["id"]);
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["barcode"],'zpt_ok');
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["norm_partnumber"]);
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["model"]);
                        if (isset($this->vendArr[$vendorStr])) {
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->vendArr[$vendorStr]["name"]);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->vendArr[$vendorStr]["searchstr"]);
                        }
                        if (isset($this->countryArr[$countryStr])) {
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->countryArr[$countryStr]["name"]);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->countryArr[$countryStr]["searchstr"]);
                        }
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["name"]);
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["prefix"]);

                        if (!empty($picture)){
                            $product['files'] = json_decode($product['files'],true);
                            if (!isset($product['files']['img'])) $product['files']['img'] = array();
                            $product['files']['img']['1'] = array(
                                "name" => $updateArr["name"],
                                "url" => $picture,
                                //"type" => "jpg",
                                "edituser" => Glob::$vars['user']->get('userid'),
                                "editdate" => $this->thisTime,
                                "editip" => GetEnv('REMOTE_ADDR')
                            );
                            $updateArr['files'] = json_encode($product['files']);
                            $updateArr['donorimg'] = $picture;
                        }
                        $updateArr["datestr"] = $this->thisDateTime;
                        $updateArr["date"] = $this->thisTime;
                        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                        $updateArr["editdate"] = $this->thisTime;
                        $updateArr["editip"] = GetEnv('REMOTE_ADDR');            
                        MNBVStorage::setObj(Glob::$vars['prod_storage'], $updateArr, array("id",'=',$product["id"]));
                        echo "Update prod id=[{$product["id"]}] parentid=[$parentid] name=[{$product["name"]}]\n";
                        
                    } else { //Добавим новый товар
                        
                        $updateArr["parentid"] = $parentid;
                        $updateArr["vendor"] = $vendorid;
                        $updateArr["country"] = $countryid;
                        $updateArr["partnumber"] = $partnumber;
                        $updateArr["quantity"] = (isset($attrArr['available'])&&$attrArr['available']=="true")?1:0;
                        $updateArr["donorurl"] = (!empty($node->url))?SysBF::checkStr($node->typePrefix,'url'):'';
                        $updateArr["price"] = (!empty($node->price))?round(floatval($node->price),2):0;
                        $updateArr["prefix"] = (!empty($node->typePrefix))?SysBF::checkStr($node->typePrefix,'stringkav'):'';
                        $updateArr["model"] = (!empty($node->model))?SysBF::checkStr($node->model,'stringkav'):'';
                        $updateArr["name"] = $updateArr["prefix"] . ' ' . $vendorStr . ' ' . $updateArr["model"];
                        $updateArr["alias"] = MNBVf::str2alias($updateArr["model"]);
                        $updateArr["text"] = (!empty($node->description))?str_replace("\n","<br>\n",SysBF::checkStr($node->description,'stringkav')):'';
                        $updateArr["barcode"] = (!empty($node->barcode))?SysBF::checkStr($node->barcode,'stringkav'):'';
                        $updateArr["outid"] = $outid;
                        
                        
                        //Сформируем поисковые строки
                        $updateArr["norm_partnumber"] = '';
                        $updateArr["norm_search"] = '';
                        $updateArr["norm_partnumber"] .= SysBF::strNormalize($updateArr["partnumber"],'zpt_ok');
                        //$updateArr["norm_search"] .= ',' . SysBF::strNormalize($product["id"]);
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["barcode"],'zpt_ok');
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["norm_partnumber"]);
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["model"]);
                        if (isset($this->vendArr[$vendorStr])) {
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->vendArr[$vendorStr]["name"]);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->vendArr[$vendorStr]["searchstr"]);
                        }
                        if (isset($this->countryArr[$countryStr])) {
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->countryArr[$countryStr]["name"]);
                            $updateArr["norm_search"] .= ',' . SysBF::strNormalize($this->countryArr[$countryStr]["searchstr"]);
                        }
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["name"]);
                        $updateArr["norm_search"] .= ',' . SysBF::strNormalize($updateArr["prefix"]);

                        //Добавим картинки
                        $pictureSrc = (array) $node->picture;
                        $picture = '';
                        if (is_array($pictureSrc)) {
                            foreach ($pictureSrc as $curPic){
                                if (!empty($curPic)) {
                                    $picture = SysBF::checkStr($curPic,'url');
                                    break; //На старте делаем только одну, нужно еще определить откуда ее брать, если это не ссылка
                                }
                            }
                        }else{
                            $picture = (!empty($pictureSrc))?$pictureSrc:'';
                        }
                    
                        if (!empty($picture)){
                            $product['files'] = array();
                            $product['files']['img'] = array();
                            $product['files']['img']['1'] = array(
                                "name" => $updateArr["name"],
                                "url" => $picture,
                                //"type" => "jpg",
                                "edituser" => Glob::$vars['user']->get('userid'),
                                "editdate" => $this->thisTime,
                                "editip" => GetEnv('REMOTE_ADDR')
                            );
                            $updateArr['files'] = json_encode($product['files']);
                            $updateArr['donorimg'] = $picture;
                        }
                        
                        $updateArr["pozid"] = 100;
                        $updateArr["visible"] = 1;
                        $updateArr["first"] = 0;
                        $updateArr["access"] = 0;
                        $updateArr["access2"] = 210;
                        $updateArr["type"] = 0;
                        $updateArr["datestr"] = $this->thisDateTime;
                        $updateArr["date"] = $this->thisTime;
                        $updateArr["siteid"] = $this->siteid;
                        $updateArr["author"] = Glob::$vars['user']->get('name');
                        $updateArr["createuser"] = Glob::$vars['user']->get('userid');
                        $updateArr["createdate"] = $this->thisTime;
                        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                        $updateArr["editdate"] = $this->thisTime;
                        $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                        
                        //Разбор параметров - надо доработать

                        $prodid = MNBVStorage::addObj(Glob::$vars['prod_storage'], $updateArr);
                        
                        if (false!==$prodid) {
                            $item = array('obj'=>$updateArr);
                            $item['obj']["id"] = $prodid;

                            //Если требуется, то внесем изменения в хранилище алиасов
                            if (!empty(SysStorage::$storage[Glob::$vars['prod_storage']]['custom_url'])){
                                $urlmaster = new MNBVURL(2,Glob::$vars['url_types']); 
                                $urlmaster->setItemAlias(Glob::$vars['prod_storage'],$item['obj']["id"],$item['obj']['alias'],$item['obj']['type'],$upFolderAlias,$item['obj']['siteid']);
                                SysLogs::addLog("Update URL: urltype=[".Glob::$vars['prod_storage']."] id=[".$item['obj']["id"]."] alias=[".$item['obj']['alias']."] objtype=[".$item['obj']['type']."] siteId=[".$item['obj']['siteid']."]");
                            }

                            echo "Add prod id=[$prodid] parentid=[$parentid] name=[{$updateArr["name"]}]\n";
                        } else {
                            echo "Add prod error parentid=[$parentid] name=[{$updateArr["name"]}]\n";
                        }
                                                         
                    }

                }
                
            }
            
            $proc->clear('status'); //Если если это не бесконечный циклический процесс, то перед выходом очистим данные по процессу.

            //Запишем конфиг и логи----------------------
            MNBVf::putFinStatToLog();

        }

    }
    
    /**
     * Проверка наличия и возможности использования вендора, при необходимости - создание вендора
     * @param string $vendorStr - название вендора - как пришло в фиде 
     * @param string $vendor_search - строка синонимов из фида
     * @return intval $id - идентификатор вендора найденный или созданный или false, если ошибка и идентификатор найти не удалось.
     */
    private function checkVendor($vendorStr,$vendor_search=''){
        
        $vendorStr = trim($vendorStr);

        //Если уже отработали этого вендора, то не повторяемся
        if (!empty($vendorStr) && isset($this->vendArr[$vendorStr])) return $this->vendArr[$vendorStr]["id"];
        
        $updateArr = array();
        $vendor = false;
        $res = MNBVStorage::getObj(Glob::$vars['vend_storage'],
                array("id","searchstr"),
                array("name","=",$vendorStr));
        if (!empty($res[0])) {
            $vendor = $res[1];
            echo "Found vendor id=[".$vendor["id"]."] [{$vendorStr}]\n";
            if (!empty($vendor_search)) {
                //Подправим вендору синонимы, если они пришли из фида
                $this->vendArr[$vendorStr]["searchstr"] = $vendor_search;
                $updateArr["searchstr"] = $this->vendArr[$vendorStr]["searchstr"]; //Приоритет синонимов из фида 
                $updateArr["datestr"] = $this->thisDateTime;
                $updateArr["date"] = $this->thisTime;
                $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                $updateArr["editdate"] = $this->thisTime;
                $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                MNBVStorage::setObj(Glob::$vars['vend_storage'], $updateArr, array("id",'=',$vendor["id"]));
                echo "Update vendor id=[{$vendor["id"]}] [{$vendorStr}]\n";
            }
            if (empty($vendor_search) && !empty($vendor["searchstr"])) $vendor_search = $vendor["searchstr"];
            $this->vendArr[$vendorStr] = array(
                "id" => $vendor["id"],
                "name" => $vendorStr,
                "searchstr" => $vendor_search, //Строка для синонимов, если есть возможность их получить.
                "dbid" => $vendor["id"],
            );         
        
            return $vendor["id"];
        }
        
        //Если вендора не нашлось - создадим его
        $updateArr["searchstr"] = (!empty($vendor_search))?$vendor_search:'';
        $updateArr["name"] = $vendorStr;
        $updateArr["alias"] = MNBVf::str2alias($vendorStr);
        $updateArr["parentid"] = Glob::$vars['vend_storage_rootid'];
        $updateArr["pozid"] = 100;
        $updateArr["visible"] = 1;
        $updateArr["first"] = 0;
        $updateArr["access"] = 0;
        $updateArr["access2"] = 210;
        $updateArr["type"] = 0;
        $updateArr["datestr"] = $this->thisDateTime;
        $updateArr["date"] = $this->thisTime;
        $updateArr["siteid"] = $this->siteid;
        $updateArr["author"] = Glob::$vars['user']->get('name');
        $updateArr["createuser"] = Glob::$vars['user']->get('userid');
        $updateArr["createdate"] = $this->thisTime;
        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
        $updateArr["editdate"] = $this->thisTime;
        $updateArr["editip"] = GetEnv('REMOTE_ADDR');
        $vendid = MNBVStorage::addObj(Glob::$vars['vend_storage'], $updateArr);
        
        if (false!==$vendid) {
            $item = array('obj'=>$updateArr);
            $item['obj']["id"] = $vendid;
                    
            //Если требуется, то внесем изменения в хранилище алиасов
            if (!empty(SysStorage::$storage[Glob::$vars['vend_storage']]['custom_url'])){
                $upFolderAlias = '';
                $urlmaster = new MNBVURL(2,Glob::$vars['url_types']); 
                $urlmaster->setItemAlias(Glob::$vars['vend_storage'],$item['obj']["id"],$item['obj']['alias'],$item['obj']['type'],$upFolderAlias,$item['obj']['siteid']);
                SysLogs::addLog("Update URL: urltype=[".Glob::$vars['prod_storage']."] id=[".$item['obj']["id"]."] alias=[".$item['obj']['alias']."] objtype=[".$item['obj']['type']."] siteId=[".$item['obj']['siteid']."]");
            }
                    
            echo "Add vendor id=[{$vendid}] [{$vendorStr}]\n";
        } else {
            echo "Add vendor error vendorStr=[$vendorStr] from [{$updateArr["name"]}]\n";
        }
        
        if ($vendid===false) return false;
        
        $this->vendArr[$vendorStr] = array(
            "id" => $vendid,
            "name" => $vendorStr,
            "searchstr" => $updateArr["searchstr"], //Строка для синонимов, если есть возможность их получить.
            "dbid" => $vendid,
        );         
        
        return $vendid; 
    }
    
    /**
     * Проверка наличия и возможности использования страны, при необходимости - создание страны
     * @param string $countryStr - название страны - как пришло в фиде 
     * @param string $country_search - строка синонимов из фида
     * @return intval $id - идентификатор страны найденный или созданный или false, если ошибка и идентификатор найти не удалось.
     */
    private function checkCountry($countryStr,$country_search=''){
        
        $countryStr = trim($countryStr);

        //Если уже отработали этого вендора, то не повторяемся
        if (!empty($countryStr) && isset($this->countryArr[$countryStr])) return $this->countryArr[$countryStr]["id"];
        
        $updateArr = array();
        $country = false;
        $res = MNBVStorage::getObj(Glob::$vars['prod_country_storage'],
                array("id","searchstr"),
                array("name","=",$countryStr));
        if (!empty($res[0])) {
            $country = $res[1];
            echo "Found country id=[".$country["id"]."] [{$countryStr}]\n";
            if (!empty($country_search)) {
                //Подправим вендору синонимы, если они пришли из фида
                $this->countryArr[$countryStr]["searchstr"] = $country_search;
                $updateArr["searchstr"] = $this->countryArr[$countryStr]["searchstr"]; //Приоритет синонимов из фида 
                $updateArr["datestr"] = $this->thisDateTime;
                $updateArr["date"] = $this->thisTime;
                $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                $updateArr["editdate"] = $this->thisTime;
                $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                MNBVStorage::setObj(Glob::$vars['prod_country_storage'], $updateArr, array("id",'=',$country["id"]));
                echo "Update country id=[{$country["id"]}] [{$countryStr}]\n";
            }
            if (empty($country_search) && !empty($country["searchstr"])) $country_search = $country["searchstr"];
            $this->countryArr[$countryStr] = array(
                "id" => $country["id"],
                "name" => $countryStr,
                "searchstr" => $country_search, //Строка для синонимов, если есть возможность их получить.
                "dbid" => $country["id"],
            );         
        
            return $country["id"];
        }
        
        //Если вендора не нашлось - создадим его
        $updateArr["searchstr"] = (!empty($country_search))?$country_search:'';
        $updateArr["name"] = $countryStr;
        $updateArr["alias"] = MNBVf::str2alias($countryStr);
        $updateArr["parentid"] = Glob::$vars['prod_country_rootid'];
        $updateArr["pozid"] = 100;
        $updateArr["visible"] = 1;
        $updateArr["first"] = 0;
        $updateArr["access"] = 0;
        $updateArr["access2"] = 210;
        $updateArr["type"] = 0;
        $updateArr["datestr"] = $this->thisDateTime;
        $updateArr["date"] = $this->thisTime;
        $updateArr["siteid"] = $this->siteid;
        $updateArr["author"] = Glob::$vars['user']->get('name');
        $updateArr["createuser"] = Glob::$vars['user']->get('userid');
        $updateArr["createdate"] = $this->thisTime;
        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
        $updateArr["editdate"] = $this->thisTime;
        $updateArr["editip"] = GetEnv('REMOTE_ADDR');
        $countryid = MNBVStorage::addObj(Glob::$vars['prod_country_storage'], $updateArr);
        
        if (false!==$countryid) {     
            echo "Add country id=[{$countryid}] [{$countryStr}]\n";
        } else {
            echo "Add country error countryStr=[$countryStr] from [{$updateArr["name"]}]\n";
        }
        
        if ($country===false) return false;
        
        $this->countryArr[$countryStr] = array(
            "id" => $countryid,
            "name" => $countryStr,
            "searchstr" => $updateArr["searchstr"], //Строка для синонимов, если есть возможность их получить.
            "dbid" => $countryid,
        );         
        
        return $countryid; 
    }

        
    /**
     * Проверка наличия и возможности использования категории, при необходимости - создание категорий
     * @param mixed $categoryId 
     * @return boolean
     */
    private function checkFolder($categoryId){
        static $level = 0;
        $level++;
        if ($level>10) {
            $level--;
            return false;
        }
        $level--;
                
        $key = strval($categoryId);
        $result = true;
        if (!isset($this->catArr[$key])) return false;
        if (isset($this->catArr[$key]["allow"]) && !$this->catArr[$key]["allow"]) return false;
        if (isset($this->catArr[$key]["allow"]) && $this->catArr[$key]["allow"]) return true;
        
        $result = false;
        //Проверим текущую категорию на вхождение в запрещенные выбранные
        if (is_array($this->cat_deny) && in_array($key,$this->cat_deny)) {
            $this->catArr[$key]["allow"] = false;
            return false;
        }
        
        //Проверим текущую категорию на вхождение в допустимые выбранные
        if (is_array($this->cat_allow) && in_array($key)) {
            $this->catArr[$key]["allow"] = true;
            if (!in_array($key,$this->cats_stru['root'])) $this->cats_stru['root'][] = $key; 
            $result = true;
        }
        
        //Нет категории верхнего уровня
        if (empty($this->catArr[$key]["parentid"])) { //Вышестоящей категории нет, 
            if ($this->cat_allow === 'all') {
                $this->catArr[$key]["allow"] = true;
                if (!in_array($key,$this->cats_stru['root'])) $this->cats_stru['root'][] = $key;
                $result = true;
            }else{
                $this->catArr[$key]["allow"] = false;
                return false;
            }
        }else{ //Вышестоящая категория есть
            $result = $this->checkFolder($this->catArr[$key]["parentid"]);
            $this->catArr[$key]["allow"] = $result;
            if ($result) {
                $parentid = strval($this->catArr[$key]["parentid"]);
                if (!isset($this->cats_stru[$parentid])) $this->cats_stru[$parentid] = array();
                if (!in_array($key,$this->cats_stru[$parentid])) $this->cats_stru[$parentid][] = $key;
            }
        }
        
        return $result; 
    }
    
    
    /**
     * Создает категории товаров, которые пока не существуют в точке монтирования и ниже
     * @param mixed $parentid_out алиас или идентификатор папки, элементы которой обрабатываем 
     */
    private function createFolders($parentid_out='root'){
        static $level = 0;
        $level++;
        if ($level>10) {
            $level--;
            return false;
        }
        $level--;
        
        $parentid_out = strval($parentid_out);
        
        $folder = false;
        $upFLD = false;
        $alias = '';
        $parentid = 0;
        if ($parentid_out==='root'){
            $res = MNBVStorage::getObj(Glob::$vars['prod_storage'],
                array("id","attr","attrup","upfolders","alias"),
                array("id","=",$this->cat_point));
        }else{
            $outid = strval($this->catArr[$parentid_out]['id']);
            $res = MNBVStorage::getObj(Glob::$vars['prod_storage'],
                array("id","attr","attrup","upfolders","alias"),
                array("outid","=",$outid,"and","type","=",ST_FOLDER));
        }
        if (!empty($res[0])) {
            $folder = $res[1];
            $upFLD = MNBVStorage::upObjInfo($folder);
            $parentid = $folder["id"];
            $alias = $folder["alias"];
        }
        if (!empty($alias)) $alias .= '/';

        if (empty($parentid)) return false; //Без точки монтирования не продолжаем
        
        if (isset($this->cats_stru[$parentid_out]) && is_array($this->cats_stru[$parentid_out])){
            foreach ($this->cats_stru[$parentid_out] as $folderid){
                if (empty($this->catArr[$folderid]['allow'])) continue; 

                $updateArr = array();
                $outid = strval($this->catArr[$folderid]['id']);
                $folder = false;
                $res = MNBVStorage::getObj(Glob::$vars['prod_storage'],
                        array("id","searchstr","name"),
                        array("outid","=",$outid,"and","type","=",ST_FOLDER));
                if (!empty($res[0])) {
                    $folder = $res[1];
                    //Если фидом не задана строка синонимов поиска, то заберем ее из базы
                    if (!empty($this->catArr[$folderid]["searchstr"])) $updateArr["searchstr"] = $this->catArr[$folderid]["searchstr"]; //Приоритет синонимов из фида 
                    if (empty($this->catArr[$folderid]["searchstr"]) && !empty($folder["searchstr"])) {
                        $this->catArr[$folderid]["searchstr"] = $folder["searchstr"];
                        $updateArr["datestr"] = $this->thisDateTime;
                        $updateArr["date"] = $this->thisTime;
                        $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                        $updateArr["editdate"] = $this->thisTime;
                        $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                        MNBVStorage::setObj(Glob::$vars['prod_storage'], $updateArr, array("id",'=',$folder["id"]));
                        echo "Update folder id=[{$folder["id"]}] parentid=[$parentid] [{$folder["name"]}]\n";
                    }
                    $this->catArr[$folderid]["dbid"] = $folder["id"];
                }else{

                    //Если категории не нашлось - создадим ее
                    if (!empty($this->catArr[$folderid]["alias"])) {
                        $updateArr["alias"] = '';
                        if (!empty($alias)) $updateArr["alias"] .= $alias;
                        $updateArr["alias"] .= $this->catArr[$folderid]["alias"];
                        $this->catArr[$folderid]["full_alias"] = $updateArr["alias"];
                    }

                    if (!empty($this->catArr[$folderid]["searchstr"])) $updateArr["searchstr"] = $this->catArr[$outid]["searchstr"];

                    if (false!==$upFLD){
                        $updateArr["attrup"] = $upFLD["attrup"];
                        $updateArr["upfolders"] = $upFLD["upfolders"];    
                    }

                    $updateArr["outid"] = $outid;
                    $updateArr["name"] = $this->catArr[$folderid]["name"];
                    $updateArr["parentid"] = $parentid;
                    if (false!== strpos($updateArr["name"],'ксессуар')) { //Аксессуары в конец
                        $updateArr["pozid"] = 10000;
                    }else{
                        $updateArr["pozid"] = 100;
                    }
                    $updateArr["visible"] = 1;
                    $updateArr["first"] = 0;
                    $updateArr["access"] = 0;
                    $updateArr["access2"] = 210;
                    $updateArr["type"] = 1;
                    $updateArr["datestr"] = $this->thisDateTime;
                    $updateArr["date"] = $this->thisTime;
                    $updateArr["siteid"] = $this->siteid;
                    $updateArr["author"] = Glob::$vars['user']->get('name');
                    $updateArr["createuser"] = Glob::$vars['user']->get('userid');
                    $updateArr["createdate"] = $this->thisTime;
                    $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                    $updateArr["editdate"] = $this->thisTime;
                    $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                    $dbfolderid = MNBVStorage::addObj(Glob::$vars['prod_storage'], $updateArr);
                    if (false!==$folderid) {
                        $this->catArr[$folderid]["dbid"] = $dbfolderid;
      
                        $item = array('obj'=>$updateArr);
                        $item['obj']["id"] = $dbfolderid;
                    
                        //Если требуется, то внесем изменения в хранилище алиасов
                        if (!empty(SysStorage::$storage[Glob::$vars['prod_storage']]['custom_url'])){
                            $upFolderAlias = '';
                            $urlmaster = new MNBVURL(2,Glob::$vars['url_types']); 
                            $urlmaster->setItemAlias(Glob::$vars['prod_storage'],$item['obj']["id"],$item['obj']['alias'],$item['obj']['type'],$upFolderAlias,$item['obj']['siteid']);
                            SysLogs::addLog("Update URL: urltype=[".Glob::$vars['prod_storage']."] id=[".$item['obj']["id"]."] alias=[".$item['obj']['alias']."] objtype=[".$item['obj']['type']."] upFolderAlias=[$upFolderAlias] siteId=[".$item['obj']['siteid']."]");
                        }
                    
                        echo "Add folder id=[{$dbfolderid}] parentid=[$parentid] [{$updateArr["name"]}]\n";
                    }else{
                        echo "Add folder error parentid=[$parentid] [{$updateArr["name"]}]\n";
                    }
                }

                //Обработаем вложенные категории
                $this->createFolders($outid);
            }
        }
        
    }
    
    /**
     * готовит строку с использованием памяти
     * @return string
     */
    private function getMem(){
        $memory_peak_usage = intval(memory_get_peak_usage()/1024) . 'kB';
        $memory_fin_usage = intval(memory_get_usage()/1024) . 'kB';
        return "MemPeak=[$memory_peak_usage] Memfin=[$memory_fin_usage]";
    }

}
