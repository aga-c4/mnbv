<?php
/**
 * SysStorage.class.php класс работы с хранилищами
 * Хранилище - это некий контейнер для хранения объектов, который может быть реализован на различных типах баз данных
 * Для каждого типа БД может быть создано несколько хранилищ, по необходимости.
 * Важно использовать механизм хранилищ для работы с БД, т.к. здесь можно централизованно задать названия таблиц,
 * префиксы таблиц и др параметры структуры БД.
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Константы типов хранилищ
define("ST_OBJECT", 0);
define("ST_FOLDER", 1);
define("ST_URL", 2);
define("ST_LINK", 3);
define("ST_PHOTO", 4);

/**
 * Class SysStorage - класс работы с хранилищами
 */
class SysStorage {

    /**
     * @var array - список допустимых в системе типов хранилищ
     */
    public static $dbtypes = array(
        'mysql',
        'mongodb',
        'redis',
        'file',
        'array',
    );

    /**
     * @var array - массив, содержащий значения хранилищь типа "массив" в виде массивов
     */
    public static $arraySt = array();

    /**
     * @var array - дефолтовые настройки допустимых типов данных для хранения в БД если null, то дефолтовое значение не определено,
     * можно установить уже при определении структуры хранилища
     * "dbtype" - тип поля в БД: (int|bigint|decimal|float|varchar|text|longtext|timestamp|datetime|date)
     * "size" - размер поля, если null, то ставиться дефолтовый размер для  выбранной базы данных (либо просто не передается)
     * "decimal" - для полей типа decimal задает количество знаков после запятой
     * "defval" - дефолтовое значение, если "defval"=>null, то допустимо нулевое значение
     * "autoinc" - автоинкремент, если "autoinc"=>true, то делается автоинкремент при добавлении
     * "checktype" - тип проверки входных данных
     * "ifnull" - значение, подставляющееся, если пришел null
     */
    public static $storageTypes = array(

        //Число - если "decimal"=>0, то это int, иначе это decimal с заданной дробной частью; "dbtype" - тип для базы данных
        "int" => array("type"=>"int", "name"=>"целое число", "namelang"=>"int", "size"=>null, "dbtype"=>"int", "creatval"=>"0", "defval"=>0, "autoinc"=>false, "decimal"=>0, "checktype" => "int", "ifnull"=>0),

        //Число - если "decimal"=>0, то это int, иначе это decimal с заданной дробной частью; "dbtype" - тип для базы данных
        "decimal" => array("type"=>"decimal", "size"=>null, "dbtype"=>"decimal", "creatval"=>"0", "defval"=>0, "autoinc"=>false, "decimal"=>4, "checktype" => "decimal", "ifnull"=>0),

        //Число с плавающей точкой; "dbtype" - тип для базы данных
        "float" => array("type"=>"float", "size"=>null, "dbtype"=>"float", "creatval"=>"0", "defval"=>0, "autoinc"=>false, "decimal"=>0, "checktype" => "decimal", "ifnull"=>0),

        //Строка
        "string" => array("type"=>"varchar", "size"=>null, "dbtype"=>"varchar", "creatval"=>"", "defval"=>"", "checktype" => "", "ifnull"=>""),

        //Текст возможные значения "dbtype" : text, mediumtext, longtext
        "text" => array("type"=>"text", "size"=>null, "dbtype"=>"text", "defval"=>"", "creatval"=>"", "checktype" => "", "ifnull"=>""),

        //Дата-время - еcли "defval"=>"current_timestamp", то подставляется текущее время
        //возможные значения "dbtype" : int, timestamp, datetime, date
        "datetime" => array("type"=>"datetime", "size"=>10, "dbtype"=>"int", "creatval"=>"0", "defval"=>"0", "autoinc"=>false, "checktype" => "", "ifnull"=>"0"),

    );

    /**
     * @var array служебный массив выбора типов данных ($storageTypes) для выбора из списка в редактировании хранилищ и подобных местах
     */
    public static $storageTypesForSelect = array("int" => "int", "decimal" => "decimal", "float" => "float", "string" => "string", "text" => "text", "datetime" => "datetime");

    /**
     * @var array служебный массив выбора типов данных ($storageTypes) для выбора из списка в редактировании хранилищ и подобных местах
     */
    public static $storageViewTypesForSelect = array("text" => "text","textarea" => "textarea", "datetime" => "datetime", "date" => "date", "select" => "select", "radio" => "radio",
    "checkBox" => "checkBox", "list" => "list", "frlist" => "frlist", "lineblock" => "lineblock", "submitstr" => "submitstr", "hidden" => "hidden", "noview" => "noview");

    /**
     * @var array типы объектов хранилищ
     */
    public static $storageTypesOfObjects = array("0" =>"Object", "1"=>"Folder", "2"=>"Url", "3"=>"Link", "4"=>"Photo");

    /**
     * @var string - тип БД по-умолчанию
     */
    public static $defDbType = 'mysql';

    /**
     * @var string - БД по-умолчанию
     */
    public static $defDb = 'mysql1';

    /**
     * @var string - тип хранилища по-умолчанию
     */
    public static $defstorage = 'main';

    /**
     * @var array - типы хранилищ
     */
    public static $storageGroups = array(
        'system',
        'site',
    );

    /**
     * @var array используемые в системе Хранилища. При работе со стандартной структурой данных,  используйте их
     * в работе с БД, а не указывайте названия таблиц напрямую. Этим вы обезопасите себя от нарушения работоспособности
     * при смене названия стандартных таблиц и др. настроек.
     * TODO - определите тут используемые хранилища, если они не инициализируются непосредственно из модулей
     */
    public static $storage = array(
        'main' => array( //Реестр хранилиш
            'db' => 'mysql1', //База данных
            'table' => 'page', //Таблица
            'access' => 0, // Доступ на чтение
            'access2' => 0, // Доступ на редактирование
        ),
    );

    /**
     * @var array - используемые в системе Базы данных. Может быть в том числе несколько линков к одной БД.
     * TODO - определите тут используемые базы данных, если они не инициализируются непосредственно из модулей
     */
    public static $db = array(
        //Ненужное закомментить и по необходимости использовать
        'mysql1' => array( //MySQL база данных
            'link' => null, // Текущий объект для работы с БД или null, если не задан
            'dbtype' => 'mysql', // Тип БД
            'view' => true, // Отображение в списке хранилиш
            'stuse' => true, // Возможность подсоединения к свойствам системных объектов
            'host' => 'localhost', // Адрес
            'port' => 3306, // Порт или null, если не задан
            'user' => null, // Пользователь или null, если не задан
            'password' => null, // Пароль или null, если не задан
            'database' => null, // Название БД  или null, если не задан
            'charset' => 'utf8', // Кодировка БД  или null, если не задан
            'collation' => 'utf8_general_ci', // Сравнение БД  или null, если не задан
        ),
        'mongodb1' => array( //MongoDB база данных
            'link' => null, // Текущий объект для работы с БД или null, если не задан
            'dbtype' => 'mongodb', // Тип БД
            'view' => true, // Отображение в списке хранилиш
            'stuse' => true, // Возможность подсоединения к свойствам системных объектов
            'host'=>'localhost', // Адрес
            'port' => 27017, // Порт или null, если не задан
            'ssl' => null, // Массив с параметрами SSL или null, если не задан
            'context' => null, // Массив с контекстом SSL или null, если не задан
            'user'=>null, // Пользователь или null, если не задан
            'password'=>null, // Пароль или null, если не задан
            'database'=>null, // Название БД  или null, если не задан
            'charset'=>'utf8', // Кодировка БД  или null, если не задан
            'collation'=>'utf8_general_ci', // Сравнение БД  или null, если не задан
        ),
        'redis1' => array( //Redis  база данных
            'link' => null, // Текущий объект для работы с БД или null, если не задан
            'dbtype' => 'redis', // Тип БД
            'view' => true, // Отображение в списке хранилиш
            'stuse' => true, // Возможность подсоединения к свойствам системных объектов
            'host'=>'localhost', // Адрес
            'port' => 6379, // Порт или null, если не задан
            'database' => null, // Идентификатор БД  или null, если не задан
            'charset' => 'utf8', // Кодировка БД  или null, если не задан
            'collation' => 'utf8_general_ci', // Сравнение БД  или null, если не задан
        ),
        'files1' => array( //Работа с файлами из заданной папки
            'obj' => null, // Текущий объект для работы с БД или null, если не задан
            'dbtype' => 'file',
            'view' => true, // Отображение в списке хранилиш
            'stuse' => true, // Возможность подсоединения к свойствам системных объектов
            'folder' => null, // Название папки  или null, если не задан
            'charset' => 'utf8', // Кодировка БД  или null, если не задан
            'collation' => 'utf8_general_ci', // Сравнение БД  или null, если не задан
        ),
        'array1' => array(
            'obj' => null, // Текущий объект для работы с БД или null, если не задан
            'dbtype' => 'array',
            'view' => true, // Отображение в списке хранилиш
            'stuse' => true, // Возможность подсоединения к свойствам системных объектов
            'folder' => null, // Название папки  или null, если не задан
            'charset' => 'utf8', // Кодировка БД  или null, если не задан
            'collation' => 'utf8_general_ci', // Сравнение БД  или null, если не задан
        ),
    );
    
    /**
     * @var array - массив дефолтовых параметров, регулирующих формат вывода/редактирования
     * "type" => (строка) - формат редактирования поля text, textarea, select, multiselect radio, checkBox, list (выбор элемента из привязанного списка)
     * "size" => (число) - размер поля - обычно высота в строках, если это text, то максимальная длина строки в поле
     * "storage" => (строка) - алиас хранилища для организации связей, "this" - текущее хранилище, если это массив, то типа ("ключ"=>"значение") из которого выбираются варианты значения поля
     * "folder" => (число) - ID раздела из которого будут выбираться альтернативы для организации связей, если null, то любой объект из хранилища
     * "filter" => (строка) (objects|folders|all) - типы объектов связей (по-умолчанию objects), если null, то без фильтра
     * Если какое то из значений в настройках конкретного хранилища или его элемента не задано, то используется дефолтовые значения из массива:
     */
    public static $storageTypesView = array("type"=>"text","size"=>255,"storage"=>null,"folder"=>null,"filter"=>"all");

    /**
     * Возвращает ссылку на объект работы с БД хранилища
     * @param $storage алиас хранилища
     * @param $action действие: "reconnect" - обновление соединения, "checkconnect" - проверить и если надо возобновить коннект., "nocheck" - не проверять реальный коннект, просто отдать линк (по-умолчанию)
     * @return null
     */
    public static function getLink($storage,$action='nocheck'){
        //Посмотрим есть ли ссылка на базу в реестре хранилищ и в реестре БД
        if (!empty(self::$storage["$storage"])&&!empty(self::$storage["$storage"]['db'])&&!empty(self::$db[self::$storage["$storage"]['db']])){

            if (!empty(self::$db[self::$storage["$storage"]['db']]['link']) && $action!='checkconnect' && $action!='reconnect') //База в реестре обнаружена
                return self::$db[self::$storage["$storage"]['db']]['link'];
            else { //База есть, коннекта пока нет, установим коннект, запишем его в реестр и передадим на выход
                //Если тип базы не установлен, то устанавливаем его в дефолтовый тип
                if (empty(self::$db[self::$storage["$storage"]['db']]['dbtype'])) self::$db[self::$storage["$storage"]['db']]['dbtype'] = self::$defDbType;
                switch (self::$db[self::$storage["$storage"]['db']]['dbtype']){
                    case 'mysql':
                        //Приконнектимся к MySQL с имеющимися параметрами
                        DbMysql::addDb(self::$storage["$storage"]['db'],self::$db[self::$storage["$storage"]['db']]);
                        self::$db[self::$storage["$storage"]['db']]['link'] = DbMysql::getInstance(self::$storage["$storage"]['db'],$action);
                        return self::$db[self::$storage["$storage"]['db']]['link'];
                        break;
                    case 'mongodb':
                        return null;
                        break;
                    case 'redis':
                        return null;
                        break;
                    case 'files':
                        return null;
                        break;
                }
                return null; //Тип БД определен не верно
            }
        } else return null; //Базы в реестре нет, объект получить не получится
    }
    
    /**
     * Возвращает допустимые в системы типы баз данных
     * @return type
     */
    public static function getDBTypes(){
        return self::$dbtypes;
    }
    
    /**
     * Возвращает хранилище по-умолчанию
     * @return type
     */
    public static function getDefStorage(){
        return self::$defstorage;
    }

    /**
     * Возвращает массив со свойствами базы данных
     * @param string $storage - алиас базы данных
     * @return array массив со свойствами базы данных
     */
    public static function getDb($db){
        if (isset(self::$db["$db"])) return self::$storage["$db"];
        return null;
    }

    /**
     * Добавляет в массив со свойствами базы данных элементы из входящего массива
     * @param $storage - название базы данных
     * @param array $storageArr - массив с добавляемыми свойствами базы данных
     */
    public static function setdb($db,array $dbArr){
        if (is_array($dbArr)) foreach ($dbArr as $key=>$value) self::$db["$db"]["$key"] = $value;
    }

    /**
     * Очищает структуру хранилищ
     * @param string $storage - алиас хранилища
     * @return array массив со свойствами хранилища
     */
    public static function clear(){
        self::$storage = array();
    }
    
    /**
     * Возвращает массив со свойствами хранилища
     * @param string $storage - алиас хранилища
     * @return array массив со свойствами хранилища
     */
    public static function get($storage){
        if (isset(self::$storage["$storage"])) return self::$storage["$storage"];
        return null;
    }

    /**
     * Добавляет в массив со свойствами хранилища элементы из входящего массива
     * @param $storage - название хранилища
     * @param array $storageArr - массив с добавляемыми свойствами хранилища
     */
    public static function set($storage,array $storageArr){
        if (is_array($storageArr)) foreach ($storageArr as $key=>$value) self::$storage["$storage"]["$key"] = $value;
    }

    /**
     * Получение данных по вышестоящему объекту
     * @param $arrStr - строка в JSON
     * @return array - массив {"upfolders"=>string,"attrup"=>string}
     */

    /**
     * Получение данных по вышестоящему объекту
     * @param $objArr {"id"=>int/string, "upfolders"=>string, "attrup"=>string, "attr"=>string}
     * @param $typeinp - строка содержащая тип входных данных('string' - строка (по-умолчанию), 'array' - массив). Необязательный параметр
     * @param $typeout - строка содержащая тип выходных данных('string' - строка (по-умолчанию), 'array' - массив). Необязательный параметр
     * @param $dnuse - включать в атрибуты только те, у которых есть метка dnuse по-умолчанию true.
     * @return array
     */
    public static function upObjInfo($objArr,$typeinp='string',$typeout='string',$dnuse=true){

        $result = array("upfolders"=>array(),"attrup"=>array());

        //Если не задан id объекта, то выводим пустые значения
        if (empty($objArr["id"])) {
            if ($typeout==='string') return array("upfolders"=>"","attrup"=>"");
            else return $result;
        }

        if (!empty($objArr['upfolders'])){
            if ($typeinp==='string') $upfolders = json_decode($objArr['upfolders'],true);
            else $upfolders = $objArr['upfolders'];
        }
        if (empty($upfolders)) $upfolders = array();
        $upfolders[] = $objArr["id"];
        if ($typeout==='string') $result["upfolders"] = json_encode($upfolders);
        else $result["upfolders"] = $upfolders;

        if (!empty($objArr['attr'])){
            if ($typeinp==='string') $attr = json_decode($objArr['attr'],true);
            else $attr = $objArr['attr'];
        }
        if (empty($attr)) $attr = array();

        if (!empty($objArr['attrup'])){
            if ($typeinp==='string') $attrup = json_decode($objArr['attrup'],true);
            else $attrup = $objArr['attrup'];
        }
        if (empty($attrup)) $attrup = array();

        foreach($attr as $value) if (!$dnuse || !empty($value["dnuse"])) $attrup[] = $value;
        if ($typeout==='string') $result["attrup"] = (count($attrup)>0)?json_encode($attrup):'';
        else $result["attrup"] = $attrup;

        return $result;
    }

    /**
     * Дополняет массив отображения дефолтовыми параметрами
     * @param array $viewArr
     * @return array
     */
    public static function updateViewArr($viewArr=array()){
        $result = (is_array($viewArr))?$viewArr:array();
        if (!isset($result["type"]))$result["type"] = "text";
        return $result;
    }

} 
