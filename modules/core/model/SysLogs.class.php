<?php
/**
 * SysLogs.class.php Обработчик логов работы системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

/**
 * Class SysLogs работа с логами системы
 */
class SysLogs {

    /**
     * @var string Лог работы скрипта
     */
    protected static $log = '';

    /**
     * @var boolean Определяет будет ли вообще накапливаться информация по логу. Не влияет на настройку вывода лога в консоль. Важно для длительно работающих циклических скриптов, где это может сожрать всю память
     */
    public static $logsEnable = true;

    /**
     * @var boolean Определяет будет ли вообще накапливаться информация по ошибкам. Не влияет на настройку вывода лога в консоль. Важно для длительно работающих циклических скриптов, где это может сожрать всю память
     */
    public static $errorsEnable = true;

    /**
     * @var boolean Перед каждой записью выводить дату-время
     */
    public static $logViewTime = false;

    /**
     * @var boolean Перед каждой записью выводить контроллер
     */
    public static $logViewController = false;

    /**
     * @var boolean Видимость Лога работы скрипта
     */
    public static $logView = false;

    /**
     * @var bool Выводить сообщения непосредственно при их формировании
     */
    public static $logRTView = false;

    /**
     * @var boolean Сохранение Лога работы скрипта
     */
    public static $logSave = false;

    /**
     * @var string Ошибки работы скрипта
     */
    protected static $errors = '';

    /**
     * @var boolean Видимость Ошибок работы скрипта
     */
    public static $errorsView = false;
    
    /**
     * @var boolean Если true, то в лог выгрузили финальные записи о времени исполнения скрипта и т.п. (обычно проиходит в шаблоне MNBVf::putDBStatToLog();) 
     */
    public static $logComplete = false;
	
    /**
     * Добавляет сообщение об ошибке в Лог ошибок и общий Лог
     * @param string $errorMessage
     */
    public static function addError($errorMessage){
        $dopStr = ((self::$logViewTime)?(date("Y-m-d G:i:s").'   '):'') . ((self::$logViewController && !empty(Glob::$vars['controller']))?(Glob::$vars['controller']. '   '):'');
        if (strlen(self::$log)>100000 || strlen(self::$errors)>100000) self::clearOutErrLog();
        if (self::$errorsEnable) self::$errors .= $dopStr . $errorMessage . "\n";
        if (self::$logsEnable) self::$log .= $dopStr . $errorMessage . "\n";
        if (self::$logRTView) echo $dopStr . $errorMessage . "\n"; //При необходимости тут же выводим
    }
	
    /**
     * Добавляет сообщение в Лог выполнения скрипта
     * @param string $errorMessage
     */
    public static function addLog($logMessage){
        $dopStr = ((self::$logViewTime)?(date("Y-m-d G:i:s").'   '):'') . ((self::$logViewController && !empty(Glob::$vars['controller']))?(Glob::$vars['controller']. '   '):'');
        if (strlen(self::$log)>100000) self::clearOutLog();
        if (self::$logsEnable) self::$log .= $dopStr . $logMessage . "\n";
        if (self::$logRTView && self::$logView) echo $dopStr . $logMessage . "\n"; //При необходимости тут же выводим
    }

    /**
     * Оставляет в логе последние записи (сколько задано). По-умолчанию 100000 символов.
     * @param int $maxStr допустимое количество записей в логе
     */
    public static function clearOutLog($maxStr=100000){
        self::$log = substr(self::$log,(-1*$maxStr));
    }

    /**
     * Оставляет в логе ошибок последние записи (сколько задано). По-умолчанию 100000 символов.
     * @param int $maxStr допустимое количество записей в логе
     */
    public static function clearOutErrLog($maxStr=100000){
        self::$errors = substr(self::$errors,(-1*$maxStr));
        self::$log = substr(self::$log,(-1*$maxStr));
    }

    /**
     * Возвращает лог ошибок
     * @return array
     */
    public static function getErrors(){
        return (self::$errorsView)?self::$errors:'';
    }

    /**
     * Возвращает Лог выполнения скрипта
     * @return array
     */
    public static function getLog(){
        return (self::$logView)?self::$log:'';
    }
	
    /**
     * Сохранение Лога выполнения скрипта
     */
    public static function SaveLog(){
        if (self::$logSave){
            //Сформируем окончательный лог для сохранения
            $logTxt = "-=[ SysLog ".date("Y-m-d G:i:s")." ]=-\n";
            if (self::$errorsView && self::getErrors()!=''){$logTxt .= "ERRORS:\n" . self::getErrors() . "-------\n\n";}
            if (self::$logView && self::getLog()!=''){$logTxt .= "LOG:\n" . self::getLog() . "-------\n\n";}

            //Сохраним лог на диске
            SysBF::saveFile(APP_LOGSPATH.'Syslog'.date("Y-m-d-G-i-s").'.txt',$logTxt);
        }
    }

}
