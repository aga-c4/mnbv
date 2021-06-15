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
     * @var type массив параметров и их значений
     */
    public $paramArr = array();
    
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
     * @var type демо режим, когда текстовое описание и изображения генерятся не из фида (надо для исключения претензий правообладателей). 
     */
    public $demoMode = true;
    
    //Примеры демо картинок для тестовой загрузки каталога
    private $demoImgArr = array(
        "/src/mnbv/img/demo/p1.jpg",
        "/src/mnbv/img/demo/p2.jpg",
        "/src/mnbv/img/demo/p3.jpg",
        "/src/mnbv/img/demo/p4.jpg"
    );
    
    //Случайный выбор тестовой картинки из имеющихся
    private function getDemoImgUrl(){
        $imgKol = count($this->demoImgArr);
        if (!$imgKol) return '';
        $key = rand(0,$imgKol-1);
        return $this->demoImgArr[$key];
    }
    
    /**
     * Рассчитывае количество знаков после запятой исходника, если это не число, то вернет null
     * @param mixed $source - значение параметра
     * @return array количество знаков до и после запятой array('size'=>0,'dmsize'=>0), если число, null - это не число
     */
    public function valDmSize($source){
        $result = null;
        
        $source2 = trim(strval($source));
        
        //Проверка что это число
        if (preg_match("/[^0-9\.,]+/", $source2)) return $result;
        
        $source2 = str_replace('.', ',', $source2);
        $srcArr = preg_split("/,/", $source2);
        if (!is_array($srcArr)) return $result; 
        if (count($srcArr)>2) return $result;
        if (!count($srcArr)) return $result; 
        
        $size = $dmsize = 0;
        if (isset($srcArr[0])) $size = strlen(strval(intval($srcArr[0])));
        if (!empty($srcArr[0]) && isset($srcArr[1])) $dmsize = strlen(strval(intval($srcArr[1])));
        
        return array('size'=>$size,'dmsize'=>$dmsize);
    }
    
    
    /**
     * Преобразует ВШГ с разделителями (/ или x) в массив целых значений
     * @param type $strVal
     * @return type
     */
    public function getProdSize($strVal){
        $strVal = preg_replace("~[^0-9\.,x/]~", "", $strVal);
        $strVal = str_replace(',', '.', $strVal);
        $strVal = preg_replace("/х/", 'x', $strVal); //Русская Х
        $strVal = str_replace('/', 'x', $strVal);
        $srcArr = preg_split("/x/", $strVal);
        $result = array();
        if (isset($srcArr[0]) && ceil($srcArr[0])>0) $result['h'] = ceil($srcArr[0]);
        if (isset($srcArr[1]) && ceil($srcArr[1])>0) $result['w'] = ceil($srcArr[1]);
        if (isset($srcArr[2]) && ceil($srcArr[2])>0) $result['l'] = ceil($srcArr[2]);
        return $result;
    }
    
    /**
     * Возвращает вес в кг из строки с весом в кг или г с ед. изм в конце
     * @param type $strVal
     * @return type
     */
    public function getProdWeight($strVal){
        $k = 1;
        if (preg_match("/кг/", $strVal)) $k = 1;
        if (preg_match("/ г/", $strVal)) $k = 0.001;
        $strVal = preg_replace("~[^0-9\.,]+~", "", $strVal);
        $strVal = floatval(str_replace(',', '.', $strVal));
        return round($strVal*$k,3);
    }
    
    /**
     * Возвращает true, если $strVal не должно создавать нового атрибута
     * @param type $strVal
     */
    public function checkAttrExeptions($strVal){
        $result = false;
        if ('Вес' === $strVal) $result = true;
        if ('Габариты (ВxШxГ) (см)' === $strVal) $result = true;
        if ('Брутто размер (ВхШхГ) (см)' === $strVal) $result = true;
        if ('Страна-производитель' === $strVal) $result = true;
        if ('Габариты брутто (ВхШхГ) (см)' === $strVal) $result = true;
        return $result;
    }

    /**
     * Загузка предустановленных параметров
     * @param type $strVal
     */
    public function startParamArr(){
        $this->paramArr = array(
            "Цвет" => Array(
                "name" => "Цвет",
                "dbid" => 12,
                "vals" => Array(),
                "size" => null, 
                "vars" => Array(
                    "dbtype" => "int",
                    "active" => "update",
                    "table" => "td",
                    "type" => "select",
                    "size" => 1,
                    "linkstorage" => "attributes",
                    "filter_folder" => 12,
                    "filter_type" => "all",
                    "checktype" => "int",
                    "lang" => "all",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
            
            "Брутто вес (кг)" => Array(
                "name" => "Брутто вес (кг)",
                "dbid" => 8,
                "vals" => Array(),
                "size" => Array("size"=>7,"dmsize"=>3),
                "vars" => Array(
                    "dbtype" => "decimal",
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "filter_type" => "all",
                    "checktype" => "decimal",
                    "lang" => "all",
                    "size" => 7,
                    "dmsize" => 3,
                ),
                "infilter" => 1,
            ),
            
            "Вес (кг)" => Array(
                "name" => "Вес (кг)",
                "dbid" => 3,
                "vals" => Array(),
                "size" => Array("size"=>7,"dmsize"=>3),
                "vars" => Array(
                    "dbtype" => "decimal",
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "filter_type" => "all",
                    "checktype" => "decimal",
                    "lang" => "all",
                    "size" => 7,
                    "dmsize" => 3,
                ),
                "infilter" => 1,
            ),
            
            "Высота (cм)" => Array(
                "name" => "Высота (cм)",
                "dbid" => 5,
                "vals" => Array(),

                "size" => Array(
                    "size" => 1,
                    "dmsize" => 0,
                ),
                "vars" => Array(
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "size" => 10,
                    "dmsize" => 0,
                    "linkstorage" => "attributes",
                    "filter_folder" => 20,
                    "filter_type" => "objects",
                    "checktype" => "int",
                    "lang" => "all",
                    "viewindex" => 0,
                    "dbtype" => "int",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
            
            "Ширина (cм)" => Array(
                "name" => "Ширина (cм)",
                "dbid" => 6,
                "vals" => Array(),

                "size" => Array(
                    "size" => 1,
                    "dmsize" => 0,
                ),
                "vars" => Array(
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "size" => 10,
                    "dmsize" => 0,
                    "linkstorage" => "attributes",
                    "filter_folder" => 20,
                    "filter_type" => "objects",
                    "checktype" => "int",
                    "lang" => "all",
                    "viewindex" => 0,
                    "dbtype" => "int",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
            
            "Длина (cм)" => Array(
                "name" => "Длина (cм)",
                "dbid" => 7,
                "vals" => Array(),

                "size" => Array(
                    "size" => 1,
                    "dmsize" => 0,
                ),
                "vars" => Array(
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "size" => 10,
                    "dmsize" => 0,
                    "linkstorage" => "attributes",
                    "filter_folder" => 20,
                    "filter_type" => "objects",
                    "checktype" => "int",
                    "lang" => "all",
                    "viewindex" => 0,
                    "dbtype" => "int",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
            
            "Брутто высота (см)" => Array(
                "name" => "Брутто высота (см)",
                "dbid" => 9,
                "vals" => Array(),

                "size" => Array(
                    "size" => 1,
                    "dmsize" => 0,
                ),
                "vars" => Array(
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "size" => 10,
                    "dmsize" => 0,
                    "linkstorage" => "attributes",
                    "filter_folder" => 20,
                    "filter_type" => "objects",
                    "checktype" => "int",
                    "lang" => "all",
                    "viewindex" => 0,
                    "dbtype" => "int",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
            
            "Брутто ширина (см)" => Array(
                "name" => "Брутто ширина (см)",
                "dbid" => 10,
                "vals" => Array(),

                "size" => Array(
                    "size" => 1,
                    "dmsize" => 0,
                ),
                "vars" => Array(
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "size" => 10,
                    "dmsize" => 0,
                    "linkstorage" => "attributes",
                    "filter_folder" => 20,
                    "filter_type" => "objects",
                    "checktype" => "int",
                    "lang" => "all",
                    "viewindex" => 0,
                    "dbtype" => "int",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
            
            "Брутто длина (см)" => Array(
                "name" => "Брутто длина (см)",
                "dbid" => 11,
                "vals" => Array(),

                "size" => Array(
                    "size" => 1,
                    "dmsize" => 0,
                ),
                "vars" => Array(
                    "active" => "update",
                    "table" => "td",
                    "type" => "text",
                    "size" => 10,
                    "dmsize" => 0,
                    "linkstorage" => "attributes",
                    "filter_folder" => 20,
                    "filter_type" => "objects",
                    "checktype" => "int",
                    "lang" => "all",
                    "viewindex" => 0,
                    "dbtype" => "int",
                    "notset" => 1,
                ),
                "infilter" => 1,
            ),
        );
    }
    
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
                $prod_no_check = SysBF::getFrArr($scriptvarsArr, 'prod_no_check',0,'intval');
                $this->siteid = SysBF::getFrArr($scriptvarsArr, 'siteid',0);
                $this->cat_deny = SysBF::getFrArr($scriptvarsArr, 'cat_deny',array());
                $cat_allow = SysBF::getFrArr($scriptvarsArr, 'cat_allow','all');
                if (is_array($cat_allow)){ //Элементы массива должны быть строковыми
                    $this->cat_allow = array();
                    foreach($cat_allow as $kval) $this->cat_allow[] = strval($kval);
                }
                $this->demoMode = (!empty($scriptvarsArr['demo_mode']))?true:false;
                $this->vendArr = array();
                $this->countryArr = array();
                $this->startParamArr(); //Установка дефолтовых стартовых параметров каталога
                $this->catArr = array('root' => array(
                    "id" => 0,
                    "parentid" => 0,
                    "name" => 'root',
                    "alias" => '',
                    "searchstr" => '',
                    //"allow" => true,
                    "dbid" => $this->cat_point,
                    "attrnames" => array(),
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
                        "attrnames" => array(), //Массив названий атрибутов категорий
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
                    
                    //Параметры
                    foreach ($node->param as $curParam){
                        //print_r($curParam);                        
                        $paramAttr = $curParam->attributes();
                        if (empty($paramAttr['name'])) continue;
                        $paramName = trim(strval($paramAttr['name']));
                        $curParamItemName = trim(strval($curParam));
                        
                        if ($this->checkAttrExeptions($paramName)) continue;
                        //echo "param=[$paramName][$curParamItemName]\n";
                        
                        if (!in_array($paramName,$this->catArr["$categoryId"]["attrnames"])) {
                            $this->catArr["$categoryId"]["attrnames"][] = $paramName;
                            echo "Add attr [$paramName] to cat[$categoryId]\n";
                        }
                        
                        if (!isset($this->paramArr[$paramName])) $this->paramArr[$paramName] = array('name'=>$paramName, 'dbid'=>0,'vals'=>array(),'size'=>null); 
                        
                        if (in_array($curParamItemName,$this->paramArr["$paramName"]['vals'])) continue;
                        $this->paramArr[$paramName]['vals'][] = $curParamItemName; 
                        
                        $sizeArr = $this->paramArr[$paramName]["size"];
                        $curSizeArr = $this->valDmSize($curParamItemName);
                        if ($curSizeArr===null) {
                            $this->paramArr[$paramName]["size"] = null;
                        } else {
                            if ($this->paramArr[$paramName]["size"]===null) $this->paramArr[$paramName]["size"] = $curSizeArr;
                            else {
                                if (empty($this->paramArr[$paramName]["size"]["size"]) || $curSizeArr["size"] > $this->paramArr[$paramName]["size"]["size"]) {
                                    $this->paramArr[$paramName]["size"]["size"] = $curSizeArr["size"];
                                }
                                if (empty($this->paramArr[$paramName]["size"]["dmsize"]) || $curSizeArr["dmsize"] > $this->paramArr[$paramName]["size"]["dmsize"]){
                                    $this->paramArr[$paramName]["size"]["dmsize"] = $curSizeArr["dmsize"];
                                }
                            }
                        }
                        
                    }
                    
                    $prodCounter++;
                    //echo "$prodCounter id=[$id] catid=[$categoryId]  vend=[$vendorStr][$vendor] ".$this->getMem()."\n";
                    
                }
                
                echo "createParamss ".$this->getMem()."\n";
                $this->createProdParams();
                
                echo "createFolders ".$this->getMem()."\n";
                $this->createFolders();
                
                //print_r($this->paramArr);
                //print_r($this->catArr);
                
                echo "Products - circle2 ".$this->getMem()."\n";
                
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
                    if ($this->demoMode) $partnumber = '';
                    
                    //Проверка на категорию
                    $parentid = 0;
                    $upFolderName = $upFolderAlias = '';
                    $categoryId = (!empty($node->categoryId))?intval($node->categoryId):0;
                    if (!empty($categoryId) && isset($this->catArr[strval($categoryId)]) && isset($this->catArr[strval($categoryId)]['dbid'])) { // && $this->checkFolder($categoryId)
                        $parentid = $this->catArr[strval($categoryId)]['dbid'];
                        $upFolderAlias = (!empty($this->catArr[strval($categoryId)]['full_alias']))?$this->catArr[strval($categoryId)]['full_alias']:'';
                        $upFolderName = (!empty($this->catArr[strval($categoryId)]['name']))?$this->catArr[strval($categoryId)]['name']:'';
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
                    
                    //Цена и наличие
                    $price = (!empty($node->price))?round(floatval($node->price),2):0;
                    $quantity = (isset($attrArr['available'])&&$attrArr['available']=="true")?1:0;
                    $instock = (!empty($quantity))?1:4;
                    
                    //Проверки пройдены
                    $prodCounter++;
                    
                    //Что считать входным идентификатором и что делать если его нет (вы для себя делайте по вашим задачам)
                    if (empty($outid)) continue;
                    //Подгрузим данные о товаре, если они есть
                    $product = false;
                    if (!$prod_no_check){
                        $res = MNBVStorage::getObj(Glob::$vars['prod_storage'],
                                array("id","name","price","quantity","instock"),
                                array("outid","=",$outid,"and","type","!=",ST_FOLDER));
                        if (!empty($res[0])) $product = $res[1];
                    }
                    
                    $searchObj = new MNBVSearch();
                    if ($product!==false){ //Найден подходящий внутренний товар, доработаем его
                        
                        /* //Эти поля пока не правим
                        $updateArr["parentid"] = $parentid;
                        $updateArr["vendor"] = $vendorid;
                        $updateArr["country"] = $countryid;
                        $updateArr["partnumber"] = $partnumber;
                        $updateArr["donorurl"] = (!empty($node->url))?SysBF::checkStr($node->typePrefix,'url'):'';
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
                         */
                        
                        //Обязательно редактируемые поля
                        $updateArr = array();
                        if ($product["price"]!=$price) $updateArr["price"] = $price;
                        if ($product["instock"]!=$instock) $updateArr["instock"] = $instock;
                        if ($product["quantity"]!=$quantity) $updateArr["quantity"] = $quantity;
                        
                        if (count($updateArr)){
                            $updateArr["datestr"] = $this->thisDateTime;
                            $updateArr["date"] = $this->thisTime;
                            $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                            $updateArr["editdate"] = $this->thisTime;
                            $updateArr["editip"] = GetEnv('REMOTE_ADDR');            
                            MNBVStorage::setObj(Glob::$vars['prod_storage'], $updateArr, array("id",'=',$product["id"]));
                            echo "Update prod id=[{$product["id"]}] parentid=[$parentid] name=[{$product["name"]}]\n";
                        }
                        
                    } else { //Добавим новый товар
                        
                        $updateArr["parentid"] = $parentid;
                        $updateArr["vendor"] = $vendorid;
                        $updateArr["country"] = $countryid;
                        $updateArr["partnumber"] = $partnumber;
                        $updateArr["donorurl"] = (!empty($node->url))?SysBF::checkStr($node->url,'url'):'';
                        $updateArr["prefix"] = (!empty($node->typePrefix))?SysBF::checkStr($node->typePrefix,'stringkav'):'';
                        $updateArr["model"] = (!empty($node->model))?SysBF::checkStr($node->model,'stringkav'):'';
                        $updateArr["name"] = $updateArr["prefix"] . ' ' . $vendorStr . ' ' . $updateArr["model"];
                        $updateArr["alias"] = MNBVf::str2alias($updateArr["model"]);
                        
                        if ($this->demoMode) $updateArr["text"] = $updateArr["name"] . ', ' . $updateArr["name"] . ', ' . $updateArr["name"] . ', ' . $updateArr["name"] . ', ' . $updateArr["name"] . '.<br><br>Демонстрационный товар, предложение не является офертой. Демонстрационный товар, предложение не является офертой. Демонстрационный товар, предложение не является офертой.';
                        else $updateArr["text"] = (!empty($node->description))?str_replace("\n","<br>\n",SysBF::checkStr($node->description,'stringkav')):'';
                        
                        $updateArr["barcode"] = (!empty($node->barcode))?SysBF::checkStr($node->barcode,'stringkav'):'';
                        $updateArr["outid"] = $outid;
                        
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
                            if ($this->demoMode) $picture = $this->getDemoImgUrl();
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
                        
                        $updateArr["price"] = $price;
                        $updateArr["instock"] = $instock;
                        $updateArr["quantity"] = $quantity;
                        
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
                        
                        
                        //Параметры
                        $attrValsArr = array();
                        $attrDBAddArr = array();
                        foreach ($node->param as $curParam){
                            
                            //print_r($curParam);                        
                            $paramAttr = $curParam->attributes();
                            if (empty($paramAttr['name'])) continue;
                            $paramName = trim(strval($paramAttr['name']));
                            $curParamItemName = trim(strval($curParam));
                            //echo "param=[$paramName][$curParamItemName]\n";                     
                            
                            //Параметры - исключения
                            $mainAttrOk = true;
                            if ('Вес' === $paramName) {
                                
                                $mainAttrOk = false;
                                $paramName = 'Вес (кг)';
                                $curParamItemValue = $this->getProdWeight($curParamItemName);
                                $attrValsArr["attr".$this->paramArr[$paramName]["dbid"]] = $curParamItemValue;                   

                                $attrDBAddArr[] = array(
                                    "attrid"=>$this->paramArr[$paramName]["dbid"],
                                    "vint"=>MNBVf::decimal2int($curParamItemValue,3),
                                );
                                
                            } elseif ('Габариты (ВxШxГ) (см)' === $paramName) {
                                
                                $mainAttrOk = false;
                                $curParamItemArr = $this->getProdSize($curParamItemName);
                                
                                if (!empty($curParamItemArr["h"])){
                                    $attrValsArr["attr".$this->paramArr["Высота (cм)"]["dbid"]] = intval($curParamItemArr["h"]);
                                    $attrDBAddArr[] = array(
                                        "attrid"=>$this->paramArr["Высота (cм)"]["dbid"],
                                        "vint"=>intval($curParamItemArr["h"]),
                                    );
                                }
                                
                                if (!empty($curParamItemArr["w"])){
                                    $attrValsArr["attr".$this->paramArr["Ширина (cм)"]["dbid"]] = intval($curParamItemArr["w"]);
                                    $attrDBAddArr[] = array(
                                        "attrid"=>$this->paramArr["Ширина (cм)"]["dbid"],
                                        "vint"=>intval($curParamItemArr["w"]),
                                    );
                                }
                                
                                if (!empty($curParamItemArr["l"])){
                                    $attrValsArr["attr".$this->paramArr["Длина (cм)"]["dbid"]] = intval($curParamItemArr["l"]);
                                    $attrDBAddArr[] = array(
                                        "attrid"=>$this->paramArr["Длина (cм)"]["dbid"],
                                        "vint"=>intval($curParamItemArr["l"]),
                                    );
                                }
                                
                            } elseif ('Брутто размер (ВхШхГ) (см)' === $paramName) {
                                
                                $mainAttrOk = false;
                                $curParamItemArr = $this->getProdSize($curParamItemName);
                                
                                if (!empty($curParamItemArr["h"])){
                                    $attrValsArr["attr".$this->paramArr["Брутто высота (см)"]["dbid"]] = intval($curParamItemArr["h"]);
                                    $attrDBAddArr[] = array(
                                        "attrid"=>$this->paramArr["Брутто высота (см)"]["dbid"],
                                        "vint"=>intval($curParamItemArr["h"]),
                                    );
                                }
                                
                                if (!empty($curParamItemArr["w"])){
                                    $attrValsArr["attr".$this->paramArr["Брутто ширина (см)"]["dbid"]] = intval($curParamItemArr["w"]);
                                    $attrDBAddArr[] = array(
                                        "attrid"=>$this->paramArr["Брутто ширина (см)"]["dbid"],
                                        "vint"=>intval($curParamItemArr["w"]),
                                    );
                                }
                                
                                if (!empty($curParamItemArr["l"])){
                                    $attrValsArr["attr".$this->paramArr["Брутто длина (см)"]["dbid"]] = intval($curParamItemArr["l"]);
                                    $attrDBAddArr[] = array(
                                        "attrid"=>$this->paramArr["Брутто длина (см)"]["dbid"],
                                        "vint"=>intval($curParamItemArr["l"]),
                                    );
                                }
                                
                            } 
                            
                            if ($mainAttrOk) { //Поток стандатрной обработки параметров
                                
                                if (!isset($this->paramArr["$paramName"])) continue;    
                                if (!isset($this->paramArr[$paramName]["vars"])) {echo "----> NO Vars in [$paramName]";continue;}
                                if (!isset($this->paramArr[$paramName]["vars"]["type"])) {
                                    echo "----> NO Vars type in [$paramName]";
                                    if (!isset($this->paramArr[$paramName]["vals"])) echo "----> NO Vals in [$paramName]";
                                    elseif (!is_array($this->paramArr[$paramName]["vals"]) || !count($this->paramArr[$paramName]["vals"])) echo "----> NO items in Vals in [$paramName]";
                                    print_r($this->paramArr[$paramName]["vars"]);
                                    continue;
                                }
                                if (!isset($this->paramArr[$paramName]["vars"]["checktype"])) {
                                    echo "----> NO Vars checktype in [$paramName]";
                                    if (!isset($this->paramArr[$paramName]["vals"])) echo "----> NO Vals in [$paramName]";
                                    elseif (!is_array($this->paramArr[$paramName]["vals"]) || !count($this->paramArr[$paramName]["vals"])) echo "----> NO items in Vals in [$paramName]";
                                    print_r($this->paramArr[$paramName]["vars"]);
                                    continue;
                                }
                                
                                if ($this->paramArr[$paramName]["vars"]["type"] === 'select'){
                                    $curParamItemDbId = (!empty($this->paramArr[$paramName]["vals"]["$curParamItemName"]))?$this->paramArr[$paramName]["vals"]["$curParamItemName"]:0; 
                                    if (!empty($curParamItemDbId) && !empty($this->paramArr[$paramName]["dbid"])) {
                                        $attrValsArr["attr".$this->paramArr[$paramName]["dbid"]] = $curParamItemDbId;   

                                        $attrDBAddArr[] = array(
                                            "attrid"=>$this->paramArr[$paramName]["dbid"],
                                            "vint"=>$curParamItemDbId,
                                        ); 
                                    }
                                }elseif($this->paramArr[$paramName]["vars"]["checktype"]==='decimal'){  
                                    $curParamItemValue = floatval($curParamItemName);
                                    $dmsize = (!empty($this->paramArr[$paramName]["vars"]["size"]["dmsize"]))?intval($this->paramArr[$paramName]["vars"]["size"]["dmsize"]):0;
                                    if (!empty($dmsize)) $curParamItemValue = round($curParamItemValue,$dmsize);
                                    if (!empty($this->paramArr[$paramName]["dbid"])) {
                                        $attrValsArr["attr".$this->paramArr[$paramName]["dbid"]] = $curParamItemValue;                   

                                        $attrDBAddArr[] = array(
                                            "attrid"=>$this->paramArr[$paramName]["dbid"],
                                            "vint"=>MNBVf::decimal2int($curParamItemValue,$dmsize),
                                        );
                                    }
                                }elseif($this->paramArr[$paramName]["vars"]["checktype"]==='string'){
                                    if (!empty($this->paramArr[$paramName]["dbid"])) {
                                        $attrValsArr["attr".$this->paramArr[$paramName]["dbid"]] = $curParamItemName;

                                        $attrDBAddArr[] = array(
                                            "attrid"=>$this->paramArr[$paramName]["dbid"],
                                            "vstr"=>$curParamItemName,
                                        );
                                    }
                                }elseif($this->paramArr[$paramName]["vars"]["checktype"]==='int'){
                                    if (!empty($this->paramArr[$paramName]["dbid"])) {
                                        $attrValsArr["attr".$this->paramArr[$paramName]["dbid"]] = intval($curParamItemName);

                                        $attrDBAddArr[] = array(
                                            "attrid"=>$this->paramArr[$paramName]["dbid"],
                                            "vint"=>intval($curParamItemName),
                                        ); 
                                    }
                                }
                                
                                if ($paramName==='Цвет'){
                                    $prodColorStrNorm = SysBF::strNormalize($curParamItemName);
                                    //if (false===strpos(SysBF::normUpdate($updateArr["norm_search"]),SysBF::normUpdate($prodColorStrNorm))){
                                    if (!empty($prodColorStrNorm)) { //Так будет корректнее индекс
                                        $prodColorStr = $curParamItemName;
                                        $updateArr["norm_search"] .= ',' . $prodColorStrNorm;
                                    }
                                }
                                
                            }

                        }
                        if (count($attrValsArr)) {
                            $updateArr['attrvals'] = json_encode($attrValsArr);
                            //echo "attrvals=[{$updateArr['attrvals']}]\n";
                        }

                        $prodid = MNBVStorage::addObj(Glob::$vars['prod_storage'], $updateArr);
                        
                        //Сформируем поисковые строки
                        $sExeptArr = array();
                        $searchObj->del(Glob::$vars['prod_storage'],$prodid);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,"$prodid",0,6,$this->siteid,$sExeptArr);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$updateArr["partnumber"],0,2,$this->siteid,$sExeptArr);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,preg_replace("/[^0-9]/","",$updateArr["partnumber"]),0,2,$this->siteid,$sExeptArr);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$updateArr["barcode"],0,2,$this->siteid,$sExeptArr);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid, str_replace(' ', '', $updateArr["model"]),0,2,$this->siteid,$sExeptArr);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,preg_replace("/[^0-9]/","",$updateArr["model"]),0,2,$this->siteid,$sExeptArr);
                        if (!empty($upFolderName) && $upFolderName!=='root') $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$upFolderName,0,2,$this->siteid,$sExeptArr);
                        //$sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$updateArr["name"],0,2,$this->siteid,$sExeptArr);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$updateArr["prefix"],0,2,$this->siteid,$sExeptArr);
                        if (!empty($vendorid)) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$this->vendArr[$vendorStr]["name"],0,2,$this->siteid,$sExeptArr);
                        if (!empty($countryid)) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$this->countryArr[$countryStr]["name"],0,1,$this->siteid,$sExeptArr);
                        if (!empty($prodColorStr)) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$prodid,$prodColorStr,0,1,$this->siteid,$sExeptArr);
                        
                        
                        if (false!==$prodid) {
                            $item = array('obj'=>$updateArr);
                            $item['obj']["id"] = $prodid;

                            //Если требуется, то внесем изменения в хранилище алиасов
                            if (!empty(SysStorage::$storage[Glob::$vars['prod_storage']]['custom_url'])){
                                $urlmaster = new MNBVURL(2,Glob::$vars['url_types']); 
                                $urlmaster->setItemAlias(Glob::$vars['prod_storage'],$item['obj']["id"],$item['obj']['alias'],$item['obj']['type'],$upFolderAlias,$item['obj']['siteid']);
                                SysLogs::addLog("Update URL: urltype=[".Glob::$vars['prod_storage']."] id=[".$item['obj']["id"]."] alias=[".$item['obj']['alias']."] objtype=[".$item['obj']['type']."] siteId=[".$item['obj']['siteid']."]");
                            }
                            

                            //Пополним индекс атрибутов  
                            if (count($attrValsArr)
                                    && !empty(SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'])
                                    && isset(SysStorage::$storage[SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse']])
                                    ){ //Есть что добавить в индекс атрибутов и индекс такой существует и используется
                                foreach($attrDBAddArr as $addAtrItem){
                                    if (!empty($addAtrItem["type"]) && $addAtrItem["type"]==='list0'){ //Если это список, то чистим индекс и заново заполняем
                                        $res = MNBVStorage::delObj(SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],
                                                array("objid","=",$prodid,"and","attrid","=",$addAtrItem["attrid"]));
                                        //echo "Delete Index Attr[{$addAtrItem['attrid']}] to object[{$addAtrItem['objid']}] " . (($res)?($res.' successful!'):' error!') ."\n";
                                    }

                                    $addAtrItem["objid"] = $prodid;
                                    $addAtrItem["objparentid"] = $parentid;

                                    $res = MNBVStorage::getObj(
                                        SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],
                                        array("id"),
                                        array("objid","=",$prodid,"and","attrid","=",$addAtrItem["attrid"])); 
                                    if (!empty($res[0]) && !isset($addAtrItem["type"])) {
                                        $res = MNBVStorage::setObj(SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'], $addAtrItem, array("id",'=',$res[1]["id"]));
                                        //echo "Update Index Attr[{$addAtrItem['attrid']}] to object[$prodid] " . (($res)?($res.' successful!'):' error!') ."\n";
                                    } else {    
                                        if (isset($addAtrItem["type"])) unset($addAtrItem["type"]);
                                        $res = MNBVStorage::addObj(SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'], $addAtrItem);
                                        //echo "Create Index Attr[{$addAtrItem['attrid']}] to object[$prodid] " . (($res)?($res.' successful!'):' error!') ."\n";
                                    }
                                }
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
     * Проверка наличия и возможности использования категории
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
        if (is_array($this->cat_allow) && in_array($key,$this->cat_allow)) {
            $this->catArr[$key]["allow"] = true;
            if (!in_array($key,$this->cats_stru['root'])) $this->cats_stru['root'][] = $key; 
            $result = true;
        }
        
        //Нет категории верхнего уровня
        if (!$result){
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
        }
        //echo "check cat[$key] res=[".(($result)?'TRUE':'FALSE')."]\n";
        return $result; 
    }
    
    
    /**
     * Создает категории товаров, которые пока не существуют в точке монтирования и ниже
     * @param mixed $parentid_out алиас или идентификатор папки, элементы которой обрабатываем 
     */
    private function createFolders($parentid_out='root'){
        static $level = 0;
        $searchObj = new MNBVSearch();
        $sExeptArr = array();
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
                $attrupArr = array(); 
                $attrArr = array();
                $attrAllArr = array();
                $res = MNBVStorage::getObj(Glob::$vars['prod_storage'],
                        array("id","searchstr","name","namelang","attrup","attr"),
                        array("outid","=",$outid,"and","type","=",ST_FOLDER));
                if (!empty($res[0])) {
                    $folder = $res[1];
                    
                    $dbfolderid = $res[1]["id"];
                    $attrupArr = SysBF::json_decode($folder["attrup"]);
                    $attrArr = SysBF::json_decode($folder["attr"]);
                    foreach($attrupArr as $atval) $attrAllArr[] = $atval["name"];
                    foreach($attrArr as $atval) $attrAllArr[] = $atval["name"];
                    
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
                        
                        //Сформируем поисковые строки
                        $searchObj->del(Glob::$vars['prod_storage'],$dbfolderid);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$dbfolderid,$updateArr["name"].' '.$updateArr["searchstr"],1,2,$this->siteid,$sExeptArr);
                        if (!empty($folder["namelang"])) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$dbfolderid,$folder["namelang"],1,2,$this->siteid,$sExeptArr);
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
                        
                        $attrupArr = SysBF::json_decode($updateArr["attrup"]);
                        foreach($attrupArr as $atval) $attrAllArr[] = $atval["name"];
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
                        
                        //Сформируем поисковые строки
                        $searchObj->del(Glob::$vars['prod_storage'],$dbfolderid);
                        $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$dbfolderid,$updateArr["name"],1,1,$this->siteid,$sExeptArr);
                        if (!empty($updateArr["searchstr"])) $sExeptArr[] = $searchObj->set(Glob::$vars['prod_storage'],$dbfolderid,$updateArr["searchstr"],1,1,$this->siteid,$sExeptArr);
                    
                        echo "Add folder id=[{$dbfolderid}] parentid=[$parentid] [{$updateArr["name"]}]\n";
                    }else{
                        echo "Add folder error parentid=[$parentid] [{$updateArr["name"]}]\n";
                    }
                }
                
                //Проверим на необходимость добавить атрибутов из фида
                $addAttr = false;
                foreach($this->catArr[$folderid]["attrnames"] as $attrname) {
                    if (!in_array($attrname,$attrAllArr)) {
                        $attrArr[] = array(
                            "objid"=>$dbfolderid,
                            "pozid"=>1000,
                            "attrid"=>$this->paramArr[$attrname]["dbid"],
                            "name"=>$attrname,
                            //"namelang"=>"",
                            "infilter"=>$this->paramArr[$attrname]["infilter"],
                        );
                        $addAttr = true;
                    }
                }
                if ($addAttr) {
                    MNBVStorage::setObj(Glob::$vars['prod_storage'], array("attr"=> json_encode($attrArr)), array("id",'=',$dbfolderid,"and","type","=",ST_FOLDER));
                }
                
                //Обработаем вложенные категории
                $this->createFolders($outid);
            }
        }
        
    }
    
    /**
     * Создает атрибуты товаров из массива $this->paramArr
     */
    private function createProdParams(){
        
        //$this->paramArr[$paramName] = array('name'=>$paramName, 'dbid'=>0, 'vals'=>array(), 'size'=>null);
        if (!isset(SysStorage::$storage[Glob::$vars['attr_storage']])) return false;
        
        $attrStorage = Glob::$vars['attr_storage'];
               
        foreach ($this->paramArr as $key=>$value){
        
            $pozid = 1000;
            $dnuse = false;
            $infilter = false;
            $inlist = false;
            $inshort = false;
            $index = false;
            $name = $value["name"];
            $attrType = 0;
            
            $dbtype = 'int';
            $active = 'update';
            $table = 'td';
            $type = 'text';
            $size = 0;
            $dmsize = 0;
            $notset = true;
            $filter_type = 'objects';            
            $checktype = 'int';
            $lang = 'all';
            
            //Определим тип атрибута и его настройки
            if($value['size']===null && count($value['vals'])>500 && $name!=='Цвет') { //Строка
                $dbtype = 'string';
                $type = 'text';
                $size = 255;
                $dmsize = 0;
                $checktype = 'string';
            }
            elseif ($value['size']===null) { //Перечисление
                $infilter = true;
                $attrType = 1;
                $dbtype = 'int';
                $type = 'select';
                $size = 1;
                $dmsize = 0;
                $checktype = 'int';
            }
            elseif(!empty($value['size']['size']) && empty($value['size']['dmsize'])) { //INT
                $infilter = true;
                $dbtype = 'int';
                $type = 'text';
                $size = 10;
                $dmsize = 0;
                $checktype = 'int';
            }elseif(!empty($value['size']['size']) && !empty($value['size']['dmsize'])) { //DECIMAL
                $infilter = true;
                $dbtype = 'decimal';
                $type = 'text';
                $size = $value['size']['size'];
                $dmsize = $value['size']['dmsize'];
                $checktype = 'decimal';
                
                //В сумме знаков должно быть до 10, без учета разделителя 
                if ($dmsize>9) $dmsize = 9;
                if ($size>10) $dmsize = 0;
                elseif ($size+$dmsize>10) {
                    $dmsize = 10 - $size;
                }
                
                if ($size+$dmsize<10) $size = 10 - $dmsize;
            }
            
            //Если слишком много знаков в числе или нет их количества, то это строка
            if (empty($size) || ($dbtype!=='string' && $size>10)) {
                $attrType = 0;
                $pozid = 1000;
                $dnuse = false;
                $infilter = false;
                $inlist = false;
                $inshort = false;
                $index = false;
            
                $dbtype = 'string';
                $type = 'text';
                $size = 255;
                $dmsize = 0;
                $checktype = 'string';
            }
            
            
            $attrNode = false;
            $attrNodeId = 0;
            $res = MNBVStorage::getObj($attrStorage,
                    array("id","vars"),
                    array("name","=",$name,"and","parentid","=",1));
            if (!empty($res[0])) {
                
                $attrNode = $res[1];
                $attrNodeId = $attrNode["id"];
                $varsStr = $attrNode['vars'];
                $varArr = SysBF::json_decode($varsStr);
                
                echo "Found attrNode id=[".$attrNode["id"]."] [{$name}]\n";
                
            } else { 
                
                //Если атрибута не нашлось - создадим его
                $updateArr = array();
                $updateArr["name"] = $name;
                $updateArr["alias"] = MNBVf::str2alias($name);
                $updateArr["parentid"] = Glob::$vars['vend_storage_rootid'];
                $updateArr["pozid"] = $pozid;
                $updateArr["visible"] = 1;
                $updateArr["first"] = 0;
                $updateArr["access"] = 0;
                $updateArr["access2"] = 210;
                $updateArr["type"] = $attrType;
                $updateArr["datestr"] = $this->thisDateTime;
                $updateArr["date"] = $this->thisTime;
                $updateArr["siteid"] = $this->siteid;
                $updateArr["author"] = Glob::$vars['user']->get('name');
                $updateArr["createuser"] = Glob::$vars['user']->get('userid');
                $updateArr["createdate"] = $this->thisTime;
                $updateArr["edituser"] = Glob::$vars['user']->get('userid');
                $updateArr["editdate"] = $this->thisTime;
                $updateArr["editip"] = GetEnv('REMOTE_ADDR');
                $attrNodeId = MNBVStorage::addObj($attrStorage, $updateArr);

                //Подправим параметры атрибута
                $varArr = array(
                    "active"=>$active,
                    "table"=>$table,
                    "type"=>$type,
                    "size"=>$size,
                    "dmsize"=>$dmsize,
                    "linkstorage"=>$attrStorage,
                    "filter_folder"=>$attrNodeId,
                    "filter_type"=>$filter_type,
                    "checktype"=>$checktype,
                    "lang"=>$lang,
                    "viewindex"=>0,
                    "dbtype"=>$dbtype,
                    "notset"=>$notset
                );
                $varsStr = json_encode($varArr);
                MNBVStorage::setObj($attrStorage, array("vars"=>$varsStr), array("id",'=',$attrNodeId));
                echo "Create attrNode id=[".$attrNodeId."] [{$updateArr["name"]}]\n"; 
            }
            $this->paramArr[$key]["dbid"] = $attrNodeId;
            $this->paramArr[$key]["vars"] = $varArr;
            
            //Для перечисления проверим его элементы, при необходимости создадим новые
            if ($type === 'select' && count($value["vals"])){
                
                $itemsFinArr = array();
                //print_r($value);
                foreach($value["vals"] as $itemName){
                    $itemId = 0;
                    $res = MNBVStorage::getObj($attrStorage,
                            array("id"),
                            array("parentid","=",$attrNodeId,"and","name","=",$itemName));
                    if (!empty($res[0])) {
                        $itemId = $res[1]["id"];
                        $itemsFinArr["$itemName"] = $itemId;
                        echo "Found attrVal id=[$itemId] [$itemName]\n";
                    } else { 

                        //Если атрибута не нашлось - создадим его
                        $updateArr = array();
                        $updateArr["name"] = $itemName;
                        $updateArr["parentid"] = $attrNodeId;
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
                        $itemId = MNBVStorage::addObj($attrStorage, $updateArr);
                        $itemsFinArr["$itemName"] = $itemId;
                        echo "Create attrVal id=[".$itemId."] [$itemName]\n"; 
                        
                    }
                    
                }
                
                $this->paramArr[$key]["vals"] = $itemsFinArr;
                
            }else{
                $this->paramArr[$key]["vals"] = array();
            }
            $this->paramArr[$key]["infilter"] = $infilter;
        
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
