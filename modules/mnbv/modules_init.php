<?php
/**
 * Начальная инициализация модуля. Как правило этот файл одинаковый и совпадает с типовым из модуля mnbvdefault, однако в некоторых модулях он может отличаться
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00 
 */
SysLogs::addLog('Modules_init start mnbv_module = ['.Glob::$vars['mnbv_module'].'].' );

//Определим домен и сооветственно сайт для данного домена, при необходимости сделаем редирект---------------------------
if (!isset($_SERVER['SERVER_NAME'])) $_SERVER['SERVER_NAME'] = '';
$currentDomen = strtolower($_SERVER['SERVER_NAME']);

//Установим дефолтовые параметры сайта
Glob::$vars['mnbv_site'] = array(
    'id' => 0,
    'protocol' => '//',
    'domain' => $currentDomen,
    'maindomain' => $currentDomen,
    'cookiedomain' => '.'.$currentDomen,
    'template' => MNBV_DEF_TPL,
    'storage' => MNBV_DEF_SITE_STORAGE,
    'startid' => MNBV_DEF_SITE_OBJ,
    'pgid' => MNBV_DEF_SITE_OBJ,
    'sorturl' => 1,
    'pginurl' => 1,
);
$storageRes = MNBVStorage::getObj('sites',
            array("id","protocol","domain","maindomain","cookiedomain","first","filesdomain","canonical","mobile","amp_site","template","storage","startid","counters_arr","sorturl","pginurl","fullurl","module"),
            array(array("domain","=","$currentDomen","or","maindomain","=","$currentDomen"),"and","visible","=",1));
$siteArr = ($storageRes[0]>0)?$storageRes[1]:null;
if (!empty($storageRes[0])){ //Домен найден
    $siteArr['id'] = $siteArr['id'];
    if (empty($siteArr['domain'])) $siteArr['domain'] = $currentDomen;
    if (empty($siteArr['maindomain'])) $siteArr['maindomain'] = $siteArr['domain'];
    if (empty($siteArr['protocol'])) $siteArr['protocol'] = '//';
    if (empty($siteArr['template'])) $siteArr['template'] = MNBV_DEF_TPL;
    if (!empty($siteArr['startid'])) $siteArr['pgid'] = $siteArr['startid'];
    if ($siteArr['maindomain']==$currentDomen && MNBVf::validateRequestProtocol($siteArr['protocol'])){ 
        //Найден основной домен и протокол подходит, работаем с ним
        if (empty($siteArr['cookiedomain'])) $siteArr['cookiedomain'] = (!empty($siteArr['maindomain']))?('.'.$siteArr['maindomain']):'';
    }else{ //Найден не основной домен, редирактим на основной
        $redirectUrl = $siteArr['protocol'] . $siteArr['maindomain'] . (($_SERVER['REQUEST_URI']!='/')?$_SERVER['REQUEST_URI']:'');
        SysLogs::addLog('Site router: domain = ['.$currentDomen.'] is not the main mirror. Redirect to '.$redirectUrl);
        MNBVf::redirect($redirectUrl);
    }
}else{ //Если домен не найден, то загрузим сайт с дефолтового домена через редирект на его основное
    $storageRes = MNBVStorage::getObj('sites',
                array("id","protocol","domain","maindomain","cookiedomain","first","filesdomain","canonical","mobile","amp_site","template","storage","startid","counters_arr","sorturl","pginurl","fullurl","module"),
                array("visible","=",1,'and',"first","=",1));
    $siteArr = ($storageRes[0]>0)?$storageRes[1]:null;
    if (!empty($storageRes[0])){//Объект для редактирования найден
        $siteArr['id'] = $siteArr['id'];
        if (empty($siteArr['domain'])) $siteArr['domain'] = $currentDomen;
        if (empty($siteArr['maindomain'])) $siteArr['maindomain'] = $siteArr['domain'];
        if (empty($siteArr['cookiedomain'])) $siteArr['cookiedomain'] = (!empty($siteArr['maindomain']))?('.'.$siteArr['maindomain']):'';
        if (empty($siteArr['protocol'])) $siteArr['protocol'] = '//';
        Glob::$vars['mnbv_site'] = $siteArr;
        if ($siteArr['maindomain'] != $currentDomen){ //Редиректим, если основной домен - другой.
            $redirectUrl = $siteArr['protocol'] . $siteArr['maindomain'] . (($_SERVER['REQUEST_URI']!='/')?$_SERVER['REQUEST_URI']:'');
            SysLogs::addLog('Site router: domain = ['.$currentDomen.'] not found. Redirect to '.$redirectUrl);
            MNBVf::redirect($redirectUrl);
        }else{
            SysLogs::addLog('Site router: domain = ['.$currentDomen.']. Default site selected.' );
        }
    }
}
Glob::$vars['mnbv_site'] = $siteArr;
if (empty(Glob::$vars['mnbv_site']['cookiedomain'])) Glob::$vars['mnbv_site']['cookiedomain'] = '.'.$currentDomen;
SysLogs::addLog('Site ['.Glob::$vars['mnbv_site']['id'].']=>['.Glob::$vars['mnbv_site']['maindomain'].']');
//----------------------------------------------------------------------------------------------------------------------

Glob::$vars['session'] = new MNBVSession(true); //Инициализация сессии

//В любом случае в куках продублируем различные идентификаторы сессий---------------------------------------------------
//Техническая стабильная сессия. Пишется в куку на MNBVSID_TTL дней и обновляется при каждом заходе
if(empty($_COOKIE[MNBVSID])) {
    Glob::$vars['MNBVSID'] =  (!empty(Glob::$vars['session']->sid))?Glob::$vars['session']->sid:md5(date("YmdHis").rand(0,32000));
    setcookie(MNBVSID, Glob::$vars['MNBVSID'],(time()+MNBVSID_TTL),"/",Glob::$vars['mnbv_site']['cookiedomain']);
    $_COOKIE[MNBVSID] = Glob::$vars['MNBVSID'];
}else{
    if (!empty(Glob::$vars['session']->sid) && Glob::$vars['session']->sid != $_COOKIE[MNBVSID]) { //Если есть различие между кукой и сессией, то у сессии приоритет, правим куку
        Glob::$vars['MNBVSID'] = Glob::$vars['session']->sid;
        setcookie(MNBVSID, Glob::$vars['MNBVSID'],(time()+MNBVSID_TTL),"/",Glob::$vars['mnbv_site']['cookiedomain']);
        $_COOKIE[MNBVSID] = Glob::$vars['MNBVSID'];
    } else  {
        //Обновим дату хранения куки
        setcookie(MNBVSID, $_COOKIE[MNBVSID],(time()+MNBVSID_TTL),"/",Glob::$vars['mnbv_site']['cookiedomain']);
        Glob::$vars['MNBVSID'] =  $_COOKIE[MNBVSID];
    }
}

//Короткая сессия персонализации персонализации, которая живет только во время текущей сессии
if(!isset($_COOKIE[MNBVSIDSHORT])) {
    Glob::$vars['MNBVSIDSHORT'] =  md5(date("YmdHis").rand(0,32000));
    setcookie(MNBVSIDSHORT, Glob::$vars['MNBVSIDSHORT'],0,"/",Glob::$vars['mnbv_site']['cookiedomain']);
    $_COOKIE[MNBVSIDSHORT]=Glob::$vars['MNBVSIDSHORT'];
}else{
    Glob::$vars['MNBVSIDSHORT'] =  $_COOKIE['MNBVSIDSHORT'];
}

//Длинная сессия персонализации, которая живет максимально долго (до конца эпохи Unix)
if(!isset($_COOKIE[MNBVSIDLONG])) {
    Glob::$vars['MNBVSIDLONG'] =  md5(date("YmdHis").rand(0,32000));
    setcookie(MNBVSIDLONG, Glob::$vars['MNBVSIDLONG'],mktime(23,59,0,12,31,2037),"/",Glob::$vars['mnbv_site']['cookiedomain']);
    $_COOKIE[MNBVSIDLONG] = Glob::$vars['MNBVSIDLONG'];
}else{
    Glob::$vars['MNBVSIDLONG'] =  $_COOKIE[MNBVSIDLONG];
}
//Установим в куку Unix метку последнего захода с данного устройства
setcookie(MNBVSIDLV, time(), mktime(23,59,0,12,31,2037),"/",Glob::$vars['mnbv_site']['cookiedomain']);

//----------------------------------------------------------------------------------------------------------------------


//Обработаем UTM метки и запишем при необходимости их в сессию и куку --------------------------------------------------
if (!empty($_GET['utm_source']))   {
    $s = strtolower($_GET['utm_source']);
    Glob::$vars['session']->set('utm_source',$s);
    setcookie("utm_source", $s, 0, "/", Glob::$vars['mnbv_site']['cookiedomain']);
}
if (!empty($_GET['utm_medium']))   {
    $s = strtolower($_GET['utm_medium']);
    Glob::$vars['session']->set('utm_medium',$s);
    setcookie("utm_medium", $s, 0, "/", Glob::$vars['mnbv_site']['cookiedomain']);
}
if (!empty($_GET['utm_campaign'])) {
    $s = strtolower($_GET['utm_campaign']);
    Glob::$vars['session']->set('utm_campaign',$s);
    setcookie("utm_campaign", $s, 0, "/", Glob::$vars['mnbv_site']['cookiedomain']);
}
if (!empty($_GET['utm_term'])) {
    $s = strtolower($_GET['utm_term']);
    Glob::$vars['session']->set('utm_term',$s);
    setcookie("utm_term", $s, 0, "/", Glob::$vars['mnbv_site']['cookiedomain']);
}
//SysLogs::addLog("utm_source=[".Glob::$vars['session']->get('utm_source')."] utm_medium=[".Glob::$vars['session']->get('utm_source')."] utm_campaign=[".Glob::$vars['session']->get('utm_campaign')."] utm_term=[".Glob::$vars['session']->get('utm_term')."]");

//----------------------------------------------------------------------------------------------------------------------

//Видимость Лога работы скрипта
if (NULL!==Glob::$vars['session']->get('logs_view')) SysLogs::$logView = (Glob::$vars['session']->get('logs_view'))?true:false;
//Подключение пользователя
if (!Glob::$vars['session']->get('userid')) Glob::$vars['session']->set('userid',0);
Glob::$vars['user'] = new MNBVUser(Glob::$vars['session']->get('userid'));
//Если есть в сессии, то установим статус редиректа
if (NULL!==Glob::$vars['session']->get('allow_redirect')) Glob::$vars['allow_redirect'] = (Glob::$vars['session']->get('allow_redirect'))?true:false;
//Установки языка и инициализация словаря
SysLogs::addLog('lang=['.Glob::$vars['lang'].'] def_lang=['.Glob::$vars['def_lang'].'] Lang::lang=['.Lang::getLang().'] Lang::def_lang=['.Lang::getDefLang().'] Lang::alt_lang=['.((Lang::isAltLang())?'TRUE':'FALSE').']');
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBV_PATH . 'lang/LangDict_'.Glob::$vars['lang'].'.php'); //Переподключим основной словарь с языком пользователя
MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['lang'].'.php')); //Словарь модуля 
if (Lang::getLang() != Lang::getDefLang()) MNBVf::requireFile(MNBVf::getRealFileName(Glob::$vars['mnbv_module'], 'lang/LangDict_'.Glob::$vars['def_lang'].'.php'));  //Словарь модуля дефолтовый
