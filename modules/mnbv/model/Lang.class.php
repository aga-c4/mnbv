<?php
/**
 * LangDict.class.php Класс работы со словарями
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class Lang {

    /**
     * @var array Массив, содержащий список алиасов допустимых адресов
     */
    public static $langsList = array('ru','eng');
    
    /**
     * @var string текущий язык интерфейса
     */
    private static $lang = "ru";
    
    /**
     * @var string текущий язык интерфейса
     */
    private static $altlangName = "eng";

    /**
     * @var bool Статус альтернативного языка в списках для текущего языка
     */
    private static $altlang = false;
    
    /**
     * @var string дефолтовый язык
     */
    private static $defLang = "ru";

    /**
     * @var array Массив, содержащий рабочие словари
     */
    public static $dict = array();
    
    /**
     * Возвращает дефолтовый язык
     * @return string
     */    
    public static function getDefLang(){
        return self::$defLang;
    }
    
    /**
     * Возвращает текущий язык интерфейса
     * @return string
     */
    public static function getLang(){
        return self::$lang;
    }
    
    /**
     * Возвращает алиас альтернативного языка интерфейса
     * @return string
     */
    public static function getAltLangName(){
        return self::$altlangName;
    }
    
    /**
     * Возвращает массив допустимых алиасов языков интерфейса системы
     * @return string
     */
    public static function getLangList(){
        return self::$langsList;
    }
    
    /**
     * Возвращает статус альтернативного языка в списках для текущего языка
     * @return bool
     */
    public static function isAltLang(){
        $res = self::$altlang;
        //if (!self::isDefLang()) $res = (self::$altlang)?false:true;
        return $res;
    }

    /**
     * Устанавливает статус альтернативного языка в списках для текущего языка
     * @param bool $key - ключ значение маркера альтернативного языка
     * @return bool
     */
    public static function setAltLang($value=false){
        self::$altlang = (!empty($value))?true:false;
    }

    /**
     * Возвращает истину, если используется дефолтовый язык
     * @return bool
     */
    public static function isDefLang(){
        return (self::$lang==self::$defLang)?true:false;
    }

    /**
     * Добавляет в список алиасов допустимых языков еще языки
     * @param array $langs - массив алиасов добавляемых языков
     */
    public static function addNewLangs($langs=array()){
        if (!is_array($langs)) return false;
        foreach($langs as $value)if (!in_array($value,self::$langsList)) self::$langsList[] = "$value";
        return true;
    }

    /**
     * Устанавливает язык интерфейса из списка предустановленных вариантов
     * @param $lang
     */
    public static function setLang($lang){
        if (in_array($lang,self::$langsList)) self::$lang = $lang;
        else self::$lang = self::$defLang;
    }
    
    /**
     * Устанавливает алиас альтернативного языка интерфейса из списка предустановленных вариантов
     * @param $lang
     */
    public static function setAltLangName($lang){
        if (in_array($lang,self::$langsList)) self::$altlangName = $lang;
    }

    /**
     * Устанавливает язык по-умолчанию из списка предустановленных вариантов
     * @param $lang
     */
    public static function setDefLang($lang){
        if (in_array($lang,self::$langsList)) self::$defLang = $lang;
    }

    /**
     * Возвращает Строку из словаря по ключу
     * @param $key - ключ
     * @param $folder - ключ группы
     * @return string - найденная строка
     */
    public static function  get($key,$folder='',$defRes='',$lang='noLang'){

        if (!in_array($lang,self::$langsList)) $lang = self::$lang;

        if ($folder!=''){
            if (isset(self::$dict["$lang"]["$folder"]["$key"])) return self::$dict["$lang"]["$folder"]["$key"];
            if (isset(self::$dict[self::$defLang]["$folder"]["$key"])) return self::$dict["$lang"]["$folder"]["$key"];
        }else{
            if (isset(self::$dict["$lang"]["$key"])) return self::$dict["$lang"]["$key"];
            if (isset(self::$dict[self::$defLang]["$key"])) return self::$dict[self::$defLang]["$key"];
        }
        SysLogs::addLog('No LangLib: ['.$lang.']['.$folder.']['.$key.']');
        if (!empty($defRes)) return $defRes;
        
        return $key;

    }

    /**
     * Добавляет в словарь элементы из массива типа array("ключ"=>"значение")
     * @param $key
     * @param string $value
     * @param string $type
     */
    public static function addToDict($AddArr,$lang='noLang'){
        if (!is_array($AddArr)) return false;

        if (!in_array($lang,self::$langsList)) return false;
        if (!isset(self::$dict["$lang"])) self::$dict["$lang"] = array();

        foreach($AddArr as $key=>$value){
            if (is_array($value)) foreach($value as $key2=>$value2) self::$dict["$lang"]["$key"]["$key2"] = $value2;
            else self::$dict["$lang"]["$key"] = $value;
        }
        return true;
    }

    /**
     * Очичает словарь для выбранного языка
     * @param string $lang - язык из списка предустановленных
     */
    public static function clearDict($lang='noLang'){
        if (isset(self::$dict["$lang"])) self::$dict["$lang"] = array();
    }

    private function __construct(){}
    private function __clone(){}

} 