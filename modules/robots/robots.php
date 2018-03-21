<?php
/**
 * main.php Файл инициализации основного модуля системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Базовая инициализация
Glob::$vars['console'] = true;
Glob::$vars['tpl_mode'] = 'txt'; //Если это консоль, то по умолчанию выводим в тексте
SysLogs::$logViewTime = true; //Перед каждой записью выводить дату-время
SysLogs::$logViewController = false; //Перед каждой записью выводить контроллер
SysLogs::addLog('Start module ['.Glob::$vars['module'].']');
require_once MNBV_PATH . MOD_MODELSPATH . 'Lang.class.php';  //Класс работы со словарями
require_once CORE_PATH . MOD_MODELSPATH . 'DbMysql.class.php'; //Класс MySql
require_once CORE_PATH . MOD_MODELSPATH . 'SysStorage.class.php'; //Класс хранилищ данных
require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVf.class.php'; //Класс базовых функций системы MNBV

//Инициализация текущего модуля
require_once MNBV_PATH . 'config/config.php';    //Базовый конфиг модуля
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/config.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/config.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового

require_once MNBV_PATH . 'config/storage.php'; //Настройки хранилищ
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/storage.php')) require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/storage.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового

if(file_exists(USER_MODULESPATH . Glob::$vars['module'] . '/init.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/init.php'); //Пользовательский init, если есть
else require_once APP_MODULESPATH . Glob::$vars['module'] . '/init.php'; //Дефолтовый init, если нет пользовательского

if(file_exists(USER_MODULESPATH . Glob::$vars['module'] . '/router.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/router.php'); //Пользовательский маршрутизатор, если есть
else require_once APP_MODULESPATH . Glob::$vars['module'] . '/router.php'; //Дефолтовый марщрутизатор, если нет пользовательского

$controllerName = 'Robots' . $controller."Controller";
$controllerFile =  MNBVf::getRealFileName(Glob::$vars['module'], MOD_CONTROLLERSPATH . $controllerName . '.class.php');
if(file_exists($controllerFile)) {

    require_once MNBVf::getRealFileName(MNBV_MAINMODULE, MOD_CONTROLLERSPATH . 'AbstractMnbvsiteController.class.php'); //Подгрузим абстрактный класс контроллера
    require_once $controllerFile;
    $actionName = "action_".$action;

    $controllerObj = new $controllerName($controller);
    if(method_exists($controllerObj, $actionName))
        $controllerObj->$actionName(Glob::$vars['tpl_mode'],Glob::$vars['console']);
    else
        $controllerObj->action_index(Glob::$vars['tpl_mode'],Glob::$vars['console']);

}else{//Действие при ошибочном контроллере
    SysLogs::addError('Error: Wrong controller ['.$controllerFile.']');
}

