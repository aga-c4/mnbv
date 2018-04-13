<?php
/**
 * config.php Основные переменные системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

/**
 * Class GlobVars - реестр глобальных переменных
 */
class Glob {

    /**
     * @var array - Массив реестра глобальных переменных
     */
    public static $vars = array(
        'weeks_arr' => array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oсt","Nov","Des"),
        'request' => array(), //Ассоциативный массив параметров запроса
        'response' => null, //Массив, содержащий обработанные данные ответа
        'module' => 'mnbv', //загружаемый модуль - по-умолчанию загружаем default TODO - Поменяйте, если хотите сделать базовым другой модуль
        'controller' => null, //исполняемый контроллер
        'action' => 'index', //исполняемое действие - по-умолчанию выполняем index
        'tpl_mode' => 'html', //Формат ответа (txt,html,json,none)
        'console' => false, //true - вывод в консоль, false - вывод в браузер
        'json_prefix' => '', //Префикс перед выдачей json
        'page_title' => '', //Метатег title
        'page_keywords' => '', //Метатег keywords
        'page_description' => '', //Метатег description
        'page_h1' => '', //Содержание основного заголовка страницы
        'datetime_start' => '', //Время запуска скрипта date("Y-m-d G:i:s")
        'time_start' => '', //Время запуска скрипта Unix
        'autoload_console_log_view' => false, //Если true, то в консоли выведет сообщения о загрузке классов Нужно для отладки
    );
    
    public static function get($key){
        if (isset(self::$vars["$key"])) return self::$vars["$key"];
        else return null;
    }
    
    private function __construct(){}
    private function __clone(){}

}

