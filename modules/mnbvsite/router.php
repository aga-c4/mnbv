<?php
/**
 * router.php универсальный маршрутизатор модулей mnbv
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Формирование массива ссылок возврата и други связанных с ними системных переменных
MNBVf::updateBackUrl(MNBVf::requestUrl());

Glob::$vars['no_cache'] = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'no_cache',''),'on');

//Дефолтовые значения-----------------------------------------------------------
Glob::$vars['mnbv_controller'] = Glob::$vars['mnbv_def_controller'] = SysBF::trueName(Glob::$vars['mnbv_module'],'title'); //Контроллер MNBV по-умолчанию
Glob::$vars['mnbv_action'] = Glob::$vars['mnbv_def_action'] = 'index'; //Действие MNBV по-умолчанию

//Определение из параметров запроса
if (!empty(Glob::$vars['request']['mnbv_controller'])) Glob::$vars['mnbv_controller'] = SysBF::trueName(SysBF::checkStr(Glob::$vars['request']['mnbv_controller'],'title'),'routeitem');
if (!empty(Glob::$vars['request']['mnbv_action'])) Glob::$vars['mnbv_action'] = SysBF::checkStr(Glob::$vars['request']['mnbv_action'],'routeitem');
SysLogs::addLog('Module:['.Glob::$vars['mnbv_module'].'] Controller:['.Glob::$vars['mnbv_controller'].'] Action:['.Glob::$vars['mnbv_action'].']');
//------------------------------------------------------------------------------

//Обработка языка интерфейса----------------------------------------------------
$kol_mnbv_route_arr = count(Glob::$vars['mnbv_route_arr']);
if (strtolower(Glob::$vars['mnbv_route_arr'][0]) == Lang::getAltLangName()){//Есть альтернативный язык
    Glob::$vars['lang'] = Lang::getAltLangName();
    Glob::$vars['mnbv_altlang'] = true;
    Lang::setAltLang(true); //Установим маркер альтернативного языка
    Lang::setLang(strtolower(Glob::$vars['mnbv_route_arr'][0]));
    array_shift(Glob::$vars['mnbv_route_arr']);$kol_mnbv_route_arr--;
    
    //Пересоберем заново массив mnbv_route_arr
    $res = array();
    foreach (Glob::$vars['mnbv_route_arr'] as $value) $res[] = $value;
    Glob::$vars['mnbv_route_arr'] = $res;
    SysLogs::addLog('lang=['.Glob::$vars['lang'].'] def_lang=['.Glob::$vars['def_lang'].'] Lang::lang=['.Lang::getLang().']  Lang::def_lang=['.Lang::getDefLang().'] Lang::alt_lang=['.((Lang::isAltLang())?'TRUE':'FALSE').']');
    
    //Переподключим словари
    if (!Lang::isDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
    MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля 
    if (!Lang::isDefLang()) MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['def_lang'].'.php'));  //Словарь модуля дефолтовый
}
//Конец обработки языка интерфейса-------------------------------------------------------


//Определим открываемый объект из корневой структуры сайта по алиасу или идентификатору объекта
$act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
if (!empty(Glob::$vars['mnbv_route_arr'][0])){ //Выбор объекта по алиасу
    if (preg_match("/^id([0-9]+)$/ui", Glob::$vars['mnbv_route_arr'][0], $matches)){//Есть номера страниц
        $pgid = intval($matches[1]);
        $currFilterArr = array("id",'=',$pgid,'and',"visible",'=',1);
        SysLogs::addLog("Site router: alias page id = [$pgid]");
        $unsertFirst = true;
    }else{
        $tecObjAlias = strtolower(Glob::$vars['mnbv_route_arr'][0]);
        $currFilterArr = array("alias",'=',$tecObjAlias,'and',"visible",'=',1);
        SysLogs::addLog("Site router: page alias = [$tecObjAlias]");
        $unsertFirst = true;
    }
}elseif($pgid = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'id',0),'int')){ //Выбор дефолтового объекта
    $currFilterArr = array("id",'=',$pgid,'and',"visible",'=',1);
    SysLogs::addLog("Site router: GET page id = [".$pgid."]");
}else{ //Выбор дефолтового объекта
    $currFilterArr = array("id",'=',Glob::$vars['mnbv_site']['startid'],'and',"visible",'=',1);
    SysLogs::addLog("Site router: default page = [".Glob::$vars['mnbv_site']['startid']."]");
}
$storageRes = MNBVStorage::getObjAcc(Glob::$vars['mnbv_site']['storage'],
            array("id,vars"),
            $currFilterArr);
Glob::$vars['mnbv_site']['pgid'] = (!empty($storageRes[1]["id"]))?$storageRes[1]["id"]:0;
SysLogs::addLog("Site router: current page = [".Glob::$vars['mnbv_site']['pgid']."]");
$curPageScriptStorage = '';
if (!empty($storageRes[1]["vars"])) {
    $curPageVars = SysBF::json_decode($storageRes[1]["vars"]);
    $curPageScriptStorage = (!empty($curPageVars["script_storage"]))?$curPageVars["script_storage"]:'';
    //if (!empty($unsertFirst)) array_shift(Glob::$vars['mnbv_route_arr']);$kol_mnbv_route_arr--;
}


//Получим основные управляющие переменные из URL----------------------------------------------------
//Уберем последнюю пустую запись
if ($kol_mnbv_route_arr>0 && empty(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1])) {
    unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
}

//Номер страницы списка
if ($kol_mnbv_route_arr>0 && preg_match("/^pg([0-9]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть номера страниц
    Glob::$vars['mnbv_listpg'] = intval($matches[1]);
    unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
}
if (SysBF::getFrArr(Glob::$vars['request'],'pg')) Glob::$vars['mnbv_listpg'] = SysBF::getFrArr(Glob::$vars['request'],'pg'); //Прямое указание имеет преимущество
if (!empty(Glob::$vars['mnbv_listpg'])) SysLogs::addLog("Site router: list pg = [".Glob::$vars['mnbv_listpg']."]");

//Тип сортировки списка
if ($kol_mnbv_route_arr>0 && preg_match("/^sort_([^\/]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть сортировка
    Glob::$vars['mnbv_listsort'] = strtolower($matches[1]);
    unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
}
if (SysBF::getFrArr(Glob::$vars['request'],'sort')) Glob::$vars['mnbv_listsort'] = SysBF::getFrArr(Glob::$vars['request'],'sort'); //Прямое указание имеет преимущество
if (!empty(Glob::$vars['mnbv_listsort'])) SysLogs::addLog("Site router: list sort = [".Glob::$vars['mnbv_listsort']."]");

Glob::$vars['mnbv_urlmaster'] = new MNBVURL(2,Glob::$vars['url_types']); 

//Получим вендора
if ($kol_mnbv_route_arr>0 && preg_match("/([^\/]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть сортировка
    Glob::$vars['mnbv_site']['sub_vend'] = strtolower($matches[1]);
    if (!empty(Glob::$vars['mnbv_site']['sub_vend']))  $urlArr = Glob::$vars['mnbv_urlmaster']->getIdByURL(Glob::$vars['vend_storage'],Glob::$vars['mnbv_site']['sub_vend'],Glob::$vars['mnbv_site']['id']);
    if (isset($urlArr) && is_array($urlArr)){
        if (!empty($urlArr['list_id'])) { //Ищем на уровне чистого алиаса без префиксов всяких
            Glob::$vars['mnbv_site']['sub_vendid'] = $urlArr['list_id'];
            unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);$kol_mnbv_route_arr--;
            SysLogs::addLog("Site router: sub_vend = [".Glob::$vars['mnbv_site']['sub_vend'].'] sub_vendid = ['.Glob::$vars['mnbv_site']['sub_vendid'].']');
        }
    }
}

//Обработаем ЧПУ URL
Glob::$vars['mnbv_cur_master_uri'] = $currMasterUri = '/' . implode('/',Glob::$vars['mnbv_route_arr']); //Неразобранный остаток строки

//Получим категорию и товар для каталога товаров
SysLogs::addLog("Site router: currMasterUri = [".$currMasterUri."] curPageScriptStorage=[$curPageScriptStorage]");
if (!empty($curPageScriptStorage))  $urlArr = Glob::$vars['mnbv_urlmaster']->getIdByURL($curPageScriptStorage,$currMasterUri,Glob::$vars['mnbv_site']['id']);
if (isset($urlArr) && is_array($urlArr)){
    if (!empty($urlArr['obj_id'])) Glob::$vars['mnbv_site']['sub_id'] = $urlArr['obj_id'];
    if (!empty($urlArr['list_id'])) Glob::$vars['mnbv_site']['sub_list_id'] = $urlArr['list_id'];
}


//Если не нашли ничего по ЧПУ, то пойдем по стандартной схеме разбора URL
if (empty(Glob::$vars['mnbv_site']['sub_id']) && empty(Glob::$vars['mnbv_site']['sub_list_id'])){
    //Номер объекта подчиненного хранилища
    if ($kol_mnbv_route_arr>0 && preg_match("/^io([0-9]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть номера страниц
        Glob::$vars['mnbv_site']['sub_id'] = intval($matches[1]);
        unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
        $kol_mnbv_route_arr--;
    }
    if (SysBF::getFrArr(Glob::$vars['request'],'io')) Glob::$vars['mnbv_site']['sub_id'] = SysBF::getFrArr(Glob::$vars['request'],'io'); //Прямое указание имеет преимущество

    //Номер списка подчиненного хранилища
    if ($kol_mnbv_route_arr>0 && preg_match("/^il([0-9]+)$/ui", Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1],$matches)){//Есть номера страниц
        Glob::$vars['mnbv_site']['sub_list_id'] = intval($matches[1]);
        unset(Glob::$vars['mnbv_route_arr'][$kol_mnbv_route_arr-1]);
        $kol_mnbv_route_arr--;
    }
    if (SysBF::getFrArr(Glob::$vars['request'],'il')) Glob::$vars['mnbv_site']['sub_list_id'] = SysBF::getFrArr(Glob::$vars['request'],'il'); //Прямое указание имеет преимущество
}

if (!empty(Glob::$vars['mnbv_site']['sub_id'])) SysLogs::addLog("Site router: list subid = [".Glob::$vars['mnbv_site']['sub_id']."]");
if (!empty(Glob::$vars['mnbv_site']['sub_list_id'])) SysLogs::addLog("Site router: list subid = [".Glob::$vars['mnbv_site']['sub_list_id']."]");

//Фильтрация списка
if (SysBF::getFrArr(Glob::$vars['request'],'filters')) {
    Glob::$vars['mnbv_listfilterstr'] = SysBF::getFrArr(Glob::$vars['request'],'filters');
    $listfilterstr = 'filters=';
    
    Glob::$vars['mnbv_listfilter'] = array();
    $filterArr = preg_split("/;/", Glob::$vars['mnbv_listfilterstr']);
    foreach ($filterArr as $filterItemStr){
        $tecArr = preg_split("/:/", $filterItemStr);
        if (empty($tecArr[0]) || !isset($tecArr[1])) continue; //Нет значения фильтра
        if ($listfilterstr!=='filters=') $listfilterstr .= ';';
        $listfilterstr .= $tecArr[0] . ':';
        if (false!==strpos($tecArr[1],',')) {
            $tecArr[1] = str_replace(' ', '', $tecArr[1]);
            $listfilterstr .= $tecArr[1];
            $tecArr[1] = array("type"=>"list","vals"=>preg_split("/,/", $tecArr[1]));
        }elseif (false!==strpos($tecArr[1],'-')) {
            $tecArr[1] = str_replace(' ', '', $tecArr[1]);
            $listfilterstr .= $tecArr[1];
            $tecArr[1] = array("type"=>"range","vals"=>preg_split("/-/", $tecArr[1]));
        }else{
            $listfilterstr .= $tecArr[1];
        }
        Glob::$vars['mnbv_listfilter'][strval($tecArr[0])] = $tecArr[1];
    }
    Glob::$vars['mnbv_listfilterstr'] = '';
    if ($listfilterstr!=='filters=') Glob::$vars['mnbv_listfilterstr'] = $listfilterstr;
    $filtersQty = count(Glob::$vars['mnbv_listfilter']);
    if (empty($filtersQty)) unset(Glob::$vars['mnbv_listfilter']); //Если нет фильтров, то не передаем этого массива вовсе
    if (!empty(Glob::$vars['mnbv_listfilterstr'])) SysLogs::addLog("Site router: list filter = [".Glob::$vars['mnbv_listfilterstr']."] found $filtersQty filter items");
}

