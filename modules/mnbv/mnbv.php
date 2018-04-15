<?php
/**
 * main.php Файл инициализации основного модуля системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

if (!defined("MNBV_MAINMODULE")) 
/**
 * Путь к модулю ядра CMS.MNBV, если установлена и используется
 */
define("MNBV_MAINMODULE",'mnbv');

if (!defined("MNBV_PATH")) 
/**
 * Путь к модулю ядра MNBV
 */
define("MNBV_PATH",'modules/mnbv/');

/**
 * Основной загрузчик классов MNBV
 * @param $class_name
 */
spl_autoload_register (function ($class_name) {
    if (false===stripos($class_name,'\\')) { //Неймспейсы мы уже обработали в core
        $test = (Glob::$vars['console'] && !empty(Glob::$vars['autoload_console_log_view']))?true:false; //Если true, то в консоли выведет сообщения о загрузке классов
        $class =  MNBV_PATH . 'model/' . $class_name . '.class.php';
        if ($test) echo 'Try to load class: ' . $class . "\n";
        if(file_exists($class)) {
            require_once ($class);
            if ($test) echo ' Ok!'; 
        }else{
            if ($test) echo ' Not found!';
        }
        if ($test) echo "\n";
    }
} );

//Базовая инициализация MNBV
SysLogs::addLog('Start module ['.Glob::$vars['module'].']');

//Инициализация текущего модуля
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/constants.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/constants.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового
require_once MNBV_PATH . 'config/constants.php';    //Константы модуля

require_once MNBV_PATH . 'config/config.php';    //Базовый конфиг модуля
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/config.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/config.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового

require_once MNBV_PATH . 'config/storage.php'; //Настройки хранилищ
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/storage.php')) require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/storage.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового

if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/init.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/init.php'); //Пользовательский init, если есть
else require_once MNBV_PATH . 'init.php'; //Дефолтовый init, если нет пользовательского

if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/router.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/router.php'); //Пользовательский маршрутизатор, если есть
else require_once MNBV_PATH . 'router.php'; //Дефолтовый марщрутизатор, если нет пользовательского

$moduleFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], Glob::$vars['mnbv_module'] . '.php');
if(file_exists($moduleFile)) require_once ($moduleFile);
else { //Действие при ошибочном модуле - попробуем открыть модуль по-умолчанию
    Glob::$vars['mnbv_module'] = Glob::$vars['mnbv_def_module'];
    $moduleFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], Glob::$vars['mnbv_module'] . '.php');
    if(file_exists($moduleFile)) require_once ($moduleFile);
    else { //Действие при ошибочном модуле
        SysLogs::addError('Error: Wrong module ['.$moduleFile.']');
        MNBVf::render(MNBVf::getRealTplName(MNBV_DEF_TPL,'404.php'),array(),Glob::$vars['tpl_mode']);
    }
}
