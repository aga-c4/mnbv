<?php
/**
 * main.php Файл инициализации основного модуля системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

/**
 * Основной загрузчик классов MNBV
 * @param $class_name
 */
spl_autoload_register (function ($class_name) {
    if (false===stripos($class_name,'\\')) { //Неймспейсы мы уже обработали в core
        $test = (Glob::$vars['console'])?Glob::$vars['autoload_console_log_view']:false; //Если true, то в консоли выведет сообщения о загрузке классов
        $class =  MNBV_PATH . 'model/' . $class_name . '.class.php';
        if ($test) echo 'Try to load class: ' . $class . "\n";
        if(file_exists($class)) {
            require_once ($class);
            if ($test) echo ' Ok!'; 
        }else{
            echo ' Not found!';
        }
        if ($test) echo "\n";
    }
} );

//Базовая инициализация
Glob::$vars['console'] = true;
Glob::$vars['tpl_mode'] = 'txt'; //Если это консоль, то по умолчанию выводим в тексте
Glob::$vars['robotsStorage'] = (!empty($robotsStorage))?$robotsStorage:'robots'; //Хранилище типов роботов
Glob::$vars['robotsRunStorage'] = (!empty($robotsRunStorage))?$robotsRunStorage:'robotsrun'; //Хранилище заданий роботов
SysLogs::$logViewTime = true; //Перед каждой записью выводить дату-время
SysLogs::$logViewController = false; //Перед каждой записью выводить контроллер
SysLogs::addLog('Start module ['.Glob::$vars['module'].']');

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

