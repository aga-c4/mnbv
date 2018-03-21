<?php
/**
 * router.php Маршрутизатор модуля intranet
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Формирование массива ссылок возврата и други связанных с ними системных переменных
MNBVf::updateBackUrl(MNBVf::requestUrl());

//Дефолтовые значения
Glob::$vars['mnbv_controller'] = Glob::$vars['mnbv_def_controller'] = SysBF::trueName(Glob::$vars['mnbv_module'],'title'); //Контроллер MNBV по-умолчанию
Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_def_action'] = 'index'; //Действие MNBV по-умолчанию

//Определение из параметров запроса
if (!empty(Glob::$vars['request']['mnbv_controller'])) Glob::$vars['mnbv_controller'] = SysBF::trueName(SysBF::checkStr(Glob::$vars['request']['mnbv_controller'],'title'),'routeitem');
if (!empty(Glob::$vars['request']['mnbv_action'])) Glob::$vars['mnbv_action'] = strtolower(SysBF::checkStr(Glob::$vars['request']['mnbv_action']),'routeitem');
SysLogs::addLog('Module:['.Glob::$vars['mnbv_module'].'] Controller:['.Glob::$vars['mnbv_controller'].'] Action:['.Glob::$vars['mnbv_action'].']');