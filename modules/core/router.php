<?php
/**
 * router.php Маршрутизатор Первичный
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Прямое указание модуля в параметрах
if (!empty(Glob::$vars['request']['module'])) Glob::$vars['module'] = SysBF::checkStr(Glob::$vars['request']['module'], 'routeitem');

//Сформируем строку маршрутизации
if (!empty(Glob::$vars['request']['route_url'])) Glob::$vars['mnbv_route_url'] = SysBF::checkStr(Glob::$vars['request']['route_url'],'url');
else Glob::$vars['request']['route_url'] = '/';
