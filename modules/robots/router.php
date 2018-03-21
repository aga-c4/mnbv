<?php
/**
 * router.php Маршрутизатор модуля robots
 *
 * Created by Konstantin Khachaturyan
 * User: AGA-C4
 * Date: 09.04.15
 * Time: 16:53
 */
$controller = Glob::$vars['controller'] = Glob::$vars['mnbv_controller'] = SysBF::trueName(Glob::$vars['module'],'title');
$action = Glob::$vars['action'] = Glob::$vars['mnbv_action'] = 'index';

//Установим служебную переменную, которая управляем выбором пользовательского кода, если он есть и отличается от основного.
Glob::$vars['mnbv_module_path'] = APP_MODULESPATH;
if (!empty(Glob::$vars['module']) && !empty(Glob::$vars['app_module_alias'][strval(Glob::$vars['module'])])) Glob::$vars['mnbv_module_path'] = USER_MODULESPATH;

if (!empty(Glob::$vars['request']['robot'])) $controller = Glob::$vars['controller'] = Glob::$vars['mnbv_controller'] = SysBF::trueName(SysBF::checkStr(Glob::$vars['request']['robot'],'routeitem'),'title');
if (!empty(Glob::$vars['request']['action'])) $action = Glob::$vars['action'] = Glob::$vars['mnbv_action'] = SysBF::checkStr(Glob::$vars['request']['action'],'routeitem');

if (!empty(Glob::$vars['request']['debug'])) SysLogs::$logView = true; //Можно включить лог
if (!empty(Glob::$vars['request']['logviewtime'])) SysLogs::$logViewTime = true; //Можно включить лог
if (!empty(Glob::$vars['request']['logviewcontroller'])) SysLogs::$logViewController = true; //Можно включить лог

SysLogs::addLog('Robots router: Module=['.Glob::$vars['module'].'] Controller=['.Glob::$vars['controller'].'] Action=['.Glob::$vars['action'].']');

