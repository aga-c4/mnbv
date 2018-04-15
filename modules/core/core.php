<?php
/**
 * core.php Скрипт запуска ядра системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

error_reporting(E_ALL); // E_ALL  & ~E_NOTICE  E_ERROR  & ~E_DEPRECATED

/**
 * Путь к директории с основными модулями системы
 */
define("APP_MODULESPATH" , 'modules/'); //Путь к директории с модулями системы

/**
 * Путь к директории с пользовательскими модулями системы
 */
define("USER_MODULESPATH",'app/modules/');

//Загрузка дефолтовых и пользовательских констант и конфигов. Конфиги работают по принципу замещения.
if(file_exists(USER_MODULESPATH . 'core/config/constants.php')) require_once (USER_MODULESPATH . 'core/config/constants.php');
require_once APP_MODULESPATH . 'core/config/constants.php';

/**
 * Основной загрузчик классов CORE с поддержкой namespace с адресацией от папки модулей
 * @param $class_name
 */
spl_autoload_register (function ($class_name) {
    $test = false; //(Glob::$vars['console'])?true:false; //Если true, то в консоли выведет сообщения о загрузке классов Нужно для отладки
    $class_name = ltrim($class_name, '\\');
    if (false!==stripos($class_name,'\\')) {
        // Преобразование namespace в полный путь к файлу
        // Поддержка стандарта PSR-0 (https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
        $class =  APP_VENDORS . str_replace(array('\\','_'), DIRECTORY_SEPARATOR, $class_name) . '.php';
    }else{
        //В остальных случаях забираем из моделей core
        $class =  CORE_PATH . 'model/' . $class_name . '.class.php';
    }
    if ($test) echo 'Try to load class: ' . $class . "\n";
    if(file_exists($class)) {
        require_once ($class);
        if ($test) echo ' Ok!'; 
    }else{
        if ($test) echo ' Not found!';
    }
    if ($test) echo "\n";
} );

SysLogs::addLog('Start module [core]');

//Автозагрузка вендоров
if(file_exists(APP_VENDORS . 'autoload.php')) require_once (APP_VENDORS . 'autoload.php');

if(file_exists(USER_MODULESPATH . 'core/config/config.php')) require_once (USER_MODULESPATH . 'core/config/config.php');
require_once APP_MODULESPATH . 'core/config/config.php';

//Стартовая инициализация элементов системы: дефолтовая и пользовательская
if(file_exists(USER_MODULESPATH . 'core/init.php'))  require_once (USER_MODULESPATH . 'core/init.php'); //Пользовательский init, если есть
else require_once APP_MODULESPATH . 'core/init.php'; //Дефолтовый init, если нет пользовательского

//Маршрутизация запроса: дефолтовая и пользовательская
if(file_exists(USER_MODULESPATH . 'core/router.php'))  require_once (USER_MODULESPATH . 'core/router.php'); //Пользовательский маршрутизатор, если есть
else require_once APP_MODULESPATH . 'core/router.php'; //Дефолтовый марщрутизатор, если нет пользовательского

$moduleFile =  APP_MODULESPATH . Glob::$vars['module'] . '/' . Glob::$vars['module'] . '.php';
if(file_exists($moduleFile)) require_once ($moduleFile);
else { //Действие при ошибочном модуле
    SysLogs::addError('Error: Wrong module ['.$moduleFile.']');
    switch (Glob::$vars['tpl_mode']) {
        case "html": //Вывод в html формате для Web
            require_once APP_MODULESPATH . 'default/view/404.php';
            break;
        case "txt": //Вывод в текстовом формате для консоли
            require_once APP_MODULESPATH . 'default/view/txtmain.php';
            break;
        case "json": //Вывод в json формате
            if (!Glob::$vars['console']) header('Content-Type: text/json; charset=UTF-8');
            echo Glob::$vars['json_prefix'] . '{}';
            break;
    }
}

//Сохраним лог, если это требуется
if (SysLogs::$logSave) SysLogs::SaveLog();
