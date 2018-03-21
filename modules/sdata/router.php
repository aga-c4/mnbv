<?php
/**
 * router.php Маршрутизатор модуля intranet
 * Предполагается, что вся статика будет иметь пути типа sdata/products/img/(p123_1.jpg|p123_1_big.jpg|p123_1_min.jpg)
 * Нам надо выделить:
 * obj_id - идентификатор объекта
 * slot_type - тип слота статики (img/att)
 * slot_id - идентификатор слота
 * $file_type - тип файла (из допустимых для данного хранилища типов)
 * img_type - вариант изображения (normal/min/big)
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

//Получим данные по объекту и приложенному файлу
if (!empty(Glob::$vars['mnbv_route_arr'][1]) && !empty(Glob::$vars['mnbv_route_arr'][2]) && !empty(Glob::$vars['mnbv_route_arr'][3])) {
    Glob::$vars['mnbv_usestorage'] = Glob::$vars['mnbv_route_arr'][1]; //Хранилище
    Glob::$vars['mnbv_fileinfo'] = array(
        "status" => true,                                  //Статус что все нормально
    );
    Glob::$vars['mnbv_fileinfo']["slot_type"] = strtolower(Glob::$vars['mnbv_route_arr'][2]); //тип слота статики (img/att)
    Glob::$vars['mnbv_fileinfo']["fname"] = trim(Glob::$vars['mnbv_route_arr'][3]); //название файла, кото

    $fname = strtolower(Glob::$vars['mnbv_route_arr'][3]);
    $rabFArr = explode('.',$fname);
    $rabFArrCount = count($rabFArr);

    if ($rabFArrCount!=2 || empty($rabFArr[1])) {
        Glob::$vars['mnbv_fileinfo']['status'] = false;
        SysLogs::addError('Error: File routing: [' . $fname . ']');
    } else {
        Glob::$vars['mnbv_fileinfo']['file_type'] = $rabFArr[1]; //тип слота статики (img/att)

        $fnameMain = trim($rabFArr[0],'p'); //Отрезали первую букву
        $fnameMainArr = explode('_',$fnameMain);

        if (empty($fnameMainArr[0]) || empty($fnameMainArr[1])) {
            Glob::$vars['mnbv_fileinfo']['status'] = false;
            SysLogs::addError('Error: File analysis: [' . $rabFArr[0] . ']');
        }
        else {
            Glob::$vars['mnbv_useobj'] = $fnameMainArr[0]; //идентификатор объекта
            Glob::$vars['mnbv_fileinfo']['slot_id'] = $fnameMainArr[1]; //идентификатор слота
            Glob::$vars['mnbv_fileinfo']['img_type'] = (!empty($fnameMainArr[2]))?$fnameMainArr[2]:''; //вариант изображения (normal/min/big)
        }
    }

    $kol_mnbv_route_arr = count(Glob::$vars['mnbv_route_arr']);

    unset(Glob::$vars['mnbv_route_arr'][0]);
    unset(Glob::$vars['mnbv_route_arr'][1]);
    unset(Glob::$vars['mnbv_route_arr'][2]);
    unset(Glob::$vars['mnbv_route_arr'][3]);

    if (empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])) { //Уберем последнюю пустую запись
        unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
    }

}else{
    Glob::$vars['mnbv_fileinfo'] = array("status" => false);
    SysLogs::addError('Error: URL routing: [' . Glob::$vars['request']['route_url'] . ']');
}

//Определение из параметров запроса
if (!empty(Glob::$vars['request']['mnbv_controller'])) Glob::$vars['mnbv_controller'] = SysBF::trueName(SysBF::checkStr(Glob::$vars['request']['mnbv_controller'],'title'),'routeitem');
if (!empty(Glob::$vars['request']['mnbv_action'])) Glob::$vars['mnbv_action'] = strtolower(SysBF::checkStr(Glob::$vars['request']['mnbv_action']),'routeitem');
SysLogs::addLog('Module:['.Glob::$vars['mnbv_module'].'] Controller:['.Glob::$vars['mnbv_controller'].'] Action:['.Glob::$vars['mnbv_action'].']');