<?php
/**
 * Корневой файл модуля
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

SysLogs::addLog('Start MNBV module ['.Glob::$vars['mnbv_module'].']');

//Инициализация текущего модуля
if (!isset(Glob::$vars['mnbv_tpl'])) Glob::$vars['mnbv_tpl'] = MNBV_DEF_TPL; //Название текущего дизайна
SysLogs::addLog('MNBV template: ' . Glob::$vars['mnbv_tpl']);
require_once MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'init.php'); //Инициализация модуля
require_once MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'router.php'); //Маршрутизация модуля

//Выбор и запуск контроллера
$controllerFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], MOD_CONTROLLERSPATH . Glob::$vars['mnbv_controller'] . 'Controller.class.php');
if(file_exists($controllerFile)) {

    require_once $controllerFile;
    $controllerName = SysBF::trueName(Glob::$vars['mnbv_controller'],'title') . "Controller";
    $actionName = "action_" . Glob::$vars['mnbv_action'];

    $controllerObj = new $controllerName(Glob::$vars['mnbv_module']);
    if(method_exists($controllerObj, $actionName))
        $controllerObj->$actionName(Glob::$vars['tpl_mode'],Glob::$vars['console']);
    else
        $controllerObj->action_index(Glob::$vars['tpl_mode'],Glob::$vars['console']);

}else{//Действие при ошибочном контроллере
    
    SysLogs::addError('Error: Wrong controller [' . Glob::$vars['mnbv_controller'] . ']');
    MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], '404.php'),$item,$tpl_mode);
    trigger_error('Error: Wrong controller [' . Glob::$vars['mnbv_controller'] . '] route: ['.Glob::$vars['request']['route_url'].']');
    
}

