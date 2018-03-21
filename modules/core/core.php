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

/**
 * Путь к модулю ядра MNBV
 */
define("MNBV_MAINMODULE",'mnbv');

//Загрузка дефолтовых и пользовательских констант и конфигов. Конфиги работают по принципу замещения.
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE .'/config/constants.php')) require_once (USER_MODULESPATH . MNBV_MAINMODULE .'/config/constants.php');
if(file_exists(USER_MODULESPATH . 'core/config/constants.php')) require_once (USER_MODULESPATH . 'core/config/constants.php');
require_once APP_MODULESPATH . 'core/config/constants.php';
if(file_exists(USER_MODULESPATH . 'core/config/config.php')) require_once (USER_MODULESPATH . 'core/config/config.php');
require_once APP_MODULESPATH . 'core/config/config.php';

//Основные классы системы
require_once APP_MODULESPATH . 'core/model/SysBF.class.php'; //Библиотека системных функций
require_once APP_MODULESPATH . 'core/model/SysLogs.class.php'; //Класс работы с логами
SysLogs::addLog('Start module [core]');

//Стартовая инициализация элементов системы: дефолтовая и пользовательская
if(file_exists(USER_MODULESPATH . 'core/init.php'))  require_once (USER_MODULESPATH . 'core/init.php'); //Пользовательский init, если есть
else require_once APP_MODULESPATH . 'core/init.php'; //Дефолтовый init, если нет пользовательского

//Маршрутизация запроса: дефолтовая и пользовательская
if(file_exists(USER_MODULESPATH . 'core/router.php'))  require_once (USER_MODULESPATH . 'core/router.php'); //Пользовательский маршрутизатор, если есть
else require_once APP_MODULESPATH . 'core/router.php'; //Дефолтовый марщрутизатор, если нет пользовательского

/**
 * Основной загрузчик классов - реализация для MNBV. TODO - измените или отключите его, если вы не используете MNBV
 * @param $class_name
 */
function __autoload($class_name) {
    // Преобразование namespace в полный путь к файлу
    $class = APP_MODULESPATH . 'mnbv/model/' . str_replace('\\', '/', $class_name) . '.class.php';
    require_once $class;
}

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
