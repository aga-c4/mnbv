<?php
/**
 * main.php Файл инициализации основного модуля системы
 *
 * Created by Konstantin Khachaturyan
 * User: AGA-C4
 * Date: 09.04.15
 * Time: 16:53
 */
$thisModuleName = Glob::$vars['module'];

//require_once APP_MODULESPATH . 'core/'. MOD_MODELSPATH .'/DbMysql.class.php'; //Класс MySql
//require_once APP_MODULESPATH . 'core/'. MOD_MODELSPATH .'/SysStorage.class.php';    //Класс хранилищ данных

require_once USER_MODULESPATH . $thisModuleName . '/router.php';    //Маршрутизация модуля

$controllerFile =  USER_MODULESPATH . Glob::$vars['module'] . '/' . MOD_CONTROLLERSPATH . $controller . 'Controller.class.php';
if(file_exists($controllerFile)) {

    require_once $controllerFile;
    $controllerName = $controller."Controller";
    $actionName = "action_".$action;

    $controllerObj = new $controllerName($thisModuleName);
    if(method_exists($controllerObj, $actionName))
        $controllerObj->$actionName(Glob::$vars['tpl_mode'],Glob::$vars['console']);
    else
        $controllerObj->action_index(Glob::$vars['tpl_mode'],Glob::$vars['console']);

}else{//Действие при ошибочном контроллере
    SysLogs::addError('Error: Wrong controller ['.$controller.']');
    switch (Glob::$vars['tpl_mode']) {
        case "html": //Вывод в html формате для Web
            require_once APP_MODULESPATH . 'default/view/404.php';
            break;
        case "txt": //Вывод в текстовом формате для консоли
            require_once APP_MODULESPATH  . 'default/view/txtmain.php';
            break;
        case "json": //Вывод в json формате
            if (!Glob::$vars['console']){header('Content-Type: text/json; charset=UTF-8');}
            echo Glob::$vars['json_prefix'] . '{}';
            break;
    }
}
