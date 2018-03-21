<?php
/**
 * router.php Маршрутизатор модуля mnbv
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Дефолтовые значения
Glob::$vars['mnbv_module'] = Glob::$vars['mnbv_def_module']; //Модуль MNBV по-умолчанию
Glob::$vars['mnbv_controller'] = Glob::$vars['mnbv_def_controller']; //Контроллер MNBV по-умолчанию
Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_def_action']; //Действие MNBV по-умолчанию

//Разбор URL для определния параметров
Glob::$vars['mnbv_route_arr'] = array();
if (!empty(Glob::$vars['request']['route_url'])) {
    Glob::$vars['mnbv_route_arr'] = preg_split("/\//",Glob::$vars['request']['route_url']);
    foreach(Glob::$vars['mnbv_route_arr'] as $key=>$value) Glob::$vars['mnbv_route_arr'][$key] = SysBF::checkStr($value,'routeitem');
    SysLogs::addLog('REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
    SysLogs::addLog('RouteStr: ' . implode('/',Glob::$vars['mnbv_route_arr']));
}

//Выберем модуль из пользовательских, если нет, то из основных
Glob::$vars['mnbv_module_path'] = APP_MODULESPATH;
if (!empty(Glob::$vars['mnbv_route_arr'][0]) && !empty(Glob::$vars['app_module_alias'][strval(Glob::$vars['mnbv_route_arr'][0])])) {
    Glob::$vars['mnbv_module'] = Glob::$vars['app_module_alias'][strval(Glob::$vars['mnbv_route_arr'][0])];
    Glob::$vars['mnbv_module_path'] = USER_MODULESPATH;
}elseif (!empty(Glob::$vars['mnbv_route_arr'][0]) && !empty(Glob::$vars['module_alias'][strval(Glob::$vars['mnbv_route_arr'][0])])) {
    Glob::$vars['mnbv_module'] = Glob::$vars['module_alias'][strval(Glob::$vars['mnbv_route_arr'][0])];
}

//Определение из параметров запроса
if (!empty(Glob::$vars['request']['mnbv_module'])) Glob::$vars['mnbv_module'] = SysBF::checkStr(Glob::$vars['request']['mnbv_module'],'routeitem');
