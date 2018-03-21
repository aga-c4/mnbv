<?php
/**
 * router.php Маршрутизатор модуля intranet
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Формирование массива ссылок возврата и други связанных с ними системных переменных
MNBVf::updateBackUrl(MNBVf::requestUrl());

//Дефолтовые значения
Glob::$vars['mnbv_controller'] = Glob::$vars['mnbv_def_controller'] = SysBF::trueName(Glob::$vars['mnbv_module'],'title'); //Контроллер MNBV по-умолчанию
Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_def_action'] = 'index'; //Действие MNBV по-умолчанию

//Разбор URL для определния параметров 
if (!empty(Glob::$vars['mnbv_route_arr'][1])) Glob::$vars['mnbv_controller'] = SysBF::trueName(Glob::$vars['mnbv_route_arr'][1],'title'); 

//Маршруты для разных контроллеров данного модуля (в алиасе контроллера перва буква заглавная, остальные в нижнем регистре!!!)
if (Glob::$vars['mnbv_controller']==='Upload'){//Контроллер хранилищ
    if (!empty(Glob::$vars['mnbv_route_arr'][2]) && !empty(Glob::$vars['mnbv_route_arr'][3])) {
        Glob::$vars['mnbv_usestorage'] = Glob::$vars['mnbv_route_arr'][2];
        Glob::$vars['mnbv_useobj'] = Glob::$vars['mnbv_route_arr'][3];
        Glob::$vars['mnbv_act'] = 'upload';
        $kol_mnbv_route_arr = count(Glob::$vars['mnbv_route_arr']);

        unset(Glob::$vars['mnbv_route_arr'][0]);
        unset(Glob::$vars['mnbv_route_arr'][1]);
        unset(Glob::$vars['mnbv_route_arr'][2]);
        unset(Glob::$vars['mnbv_route_arr'][3]);

        if (empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])) { //Уберем последнюю пустую запись
            unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
        }
            
    }
}else{
    if (!empty(Glob::$vars['mnbv_route_arr'][2])) Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_route_arr'][2];
}

//Определение из параметров запроса
if (!empty(Glob::$vars['request']['mnbv_controller'])) Glob::$vars['mnbv_controller'] = SysBF::trueName(SysBF::checkStr(Glob::$vars['request']['mnbv_controller'],'title'),'routeitem');
if (!empty(Glob::$vars['request']['mnbv_action'])) Glob::$vars['mnbv_action'] = strtolower(SysBF::checkStr(Glob::$vars['request']['mnbv_action']),'routeitem');
SysLogs::addLog('Module:['.Glob::$vars['mnbv_module'].'] Controller:['.Glob::$vars['mnbv_controller'].'] Action:['.Glob::$vars['mnbv_action'].']');