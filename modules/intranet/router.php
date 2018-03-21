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

//Разбор URL для определния параметров 
if (!empty(Glob::$vars['mnbv_route_arr'][1])) Glob::$vars['mnbv_controller'] = SysBF::trueName(Glob::$vars['mnbv_route_arr'][1],'title'); 

//Маршруты для разных контроллеров данного модуля (в алиасе контроллера перва буква заглавная, остальные в нижнем регистре!!!)
if (Glob::$vars['mnbv_controller']==='Storage'){//Контроллер хранилищ
    if (!empty(Glob::$vars['mnbv_route_arr'][2])) {
        Glob::$vars['mnbv_usestorage'] = Glob::$vars['mnbv_route_arr'][2];
        if (!empty(Glob::$vars['mnbv_route_arr'][3])&&Glob::$vars['mnbv_route_arr'][3]==='create'){//Создание хранилища
            Glob::$vars['mnbv_action'] = 'createstorage'; 
        }else{//Обычная работа с объектами хранилищ
            Glob::$vars['mnbv_action'] = 'admlist';
            Glob::$vars['mnbv_listpg'] = 0;
            $kol_mnbv_route_arr = count(Glob::$vars['mnbv_route_arr']);
            
            if (empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])) { //Уберем последнюю пустую запись
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
            }

            if (!empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])&&preg_match("/^folder_[0-9a-zA-Zа-яА-ЯёЁ\-_]+$/", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])){//Есть вкладка
                Glob::$vars['mnbv_form_folder'] = SysBF::checkStr(preg_replace("/^folder_/","",Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]),'strictstr');
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
                $kol_mnbv_route_arr--;
            }

            if (!empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])&&preg_match("/^pg[0-9]+$/", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])){//Есть номера страниц
                Glob::$vars['mnbv_listpg'] = intval(preg_replace("/[^0-9]/","",Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]));
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
                $kol_mnbv_route_arr--;
            }

            if (!empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])&&Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]=='altlang'){//Есть альтернативный язык
                Glob::$vars['mnbv_altlang'] = true;
                Lang::setAltLang(true); //Установим маркер альтернативного языка
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
                $kol_mnbv_route_arr--;
            }
            
            if (!empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])&&preg_match("/^sort_([^\/]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть сортировка
                Glob::$vars['mnbv_listsort'] = strtolower($matches[1]);
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
                $kol_mnbv_route_arr--;
            }

            if (!empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])&&preg_match("/^flh_([0-9a-zA-Z]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть фильтрация
                Glob::$vars['mnbv_filter_hash'] = strtolower($matches[1]);
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
                $kol_mnbv_route_arr--;
            }
            
            if (!empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]) && in_array(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],array('update','create','view','viewlist'))){//Есть сортировка
                Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1];
                unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
                $kol_mnbv_route_arr--;
            }
                
            if (!empty(Glob::$vars['mnbv_route_arr'][3])&&!preg_match("/^pg[0-9]+$/", Glob::$vars['mnbv_route_arr'][3])) Glob::$vars['mnbv_useobj'] = Glob::$vars['mnbv_route_arr'][3];
            
            unset(Glob::$vars['mnbv_route_arr'][0]);
            unset(Glob::$vars['mnbv_route_arr'][1]);
            unset(Glob::$vars['mnbv_route_arr'][2]);
            //На выходе остался массив с фильтрами
        }
    }
}else{
    if (!empty(Glob::$vars['mnbv_route_arr'][2])) Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_route_arr'][2];
}

//Определение из параметров запроса
if (!empty(Glob::$vars['request']['mnbv_controller'])) Glob::$vars['mnbv_controller'] = SysBF::trueName(SysBF::checkStr(Glob::$vars['request']['mnbv_controller'],'title'),'routeitem');
if (!empty(Glob::$vars['request']['mnbv_action'])) Glob::$vars['mnbv_action'] = strtolower(SysBF::checkStr(Glob::$vars['request']['mnbv_action']),'routeitem');
SysLogs::addLog('Module:['.Glob::$vars['mnbv_module'].'] Controller:['.Glob::$vars['mnbv_controller'].'] Action:['.Glob::$vars['mnbv_action'].']');