<?php
/**
 * router.php Маршрутизатор модуля default
 *
 * Created by Konstantin Khachaturyan
 * User: AGA-C4
 * Date: 09.04.15
 * Time: 16:53
 */

//if (!empty(Glob::$vars['request']['module'])) { Glob::$vars['module'] = Glob::$vars['request']['module'];}
if (!empty(Glob::$vars['request']['controller'])) Glob::$vars['controller'] = Glob::$vars['request']['controller']; 
else Glob::$vars['controller'] = SysBF::trueName(Glob::$vars['module'],'title');
if (!empty(Glob::$vars['request']['action'])) Glob::$vars['action'] = Glob::$vars['request']['action'];

//Разбор URL для определния параметров
Glob::$vars['route_arr'] = array();
if (!empty(Glob::$vars['request']['route_url'])) {
    $route_arr = preg_split("/\//", Glob::$vars['request']['route_url']);
    foreach($route_arr as $key=>$value) {
        if (!empty($value)) {
            $route_arr[$key] = SysBF::checkStr($value,'routeitem');
        } else {
            unset($route_arr[$key]);
        }
    }

    Glob::$vars['route_arr'] = array();
    foreach($route_arr as $value) Glob::$vars['route_arr'][] = $value;

    $request_uri_str = (!empty($_SERVER['REQUEST_URI']))?$_SERVER['REQUEST_URI']:'';
    SysLogs::addLog('REQUEST_URI: ' . $request_uri_str);
    SysLogs::addLog('RouteStr: ' . implode('/',Glob::$vars['route_arr']));
}

//Выберем модуль из пользовательских, если нет, то из основных
if (!empty(Glob::$vars['route_arr'][0])) {
    Glob::$vars['action'] = strval(Glob::$vars['route_arr'][0]);
}
$controller = Glob::$vars['controller'];
$action = Glob::$vars['action'];

SysLogs::addLog('Core router: Module=['.Glob::$vars['module'].'] Controller=['.$controller.'] Action=['.$action.']');