<?php
/**
 * init.php Стартовая инициализация переменных системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Время запуска скрипта выполняем после загрузки библиотеки системных функций
Glob::$vars['datetime_start'] = date("Y-m-d G:i:s");
Glob::$vars['time_start'] = SysBF::getmicrotime();

//Классы работы с БД (можно подключать непосредственно в модулях, если не используется везде)
//require_once APP_MODULESPATH . 'core/model/DbMysql.class.php'; //TODO - раскомментировать, если работаем с MySQL
//require_once APP_MODULESPATH . 'core/model/DbMnogo.class.php'; //TODO - раскомментировать, если работаем с Mnogo
//require_once APP_MODULESPATH . 'core/model/DbRedis.class.php'; //TODO - раскомментировать, если работаем с Redis
//require_once APP_MODULESPATH . 'core/model/DbMemcache.class.php'; //TODO - раскомментировать, если работаем с Memcache

//Настройка работы логов
if (isset ($systemLogView)) SysLogs::$logView = ($systemLogView)?true:false; //Видимость Лога работы скрипта
if (isset ($systemLogRTView)) SysLogs::$logRTView = ($systemLogRTView)?true:false; //Выводить сообщения непосредственно при их формировании
if (isset ($systemLogSave)) SysLogs::$logSave = ($systemLogSave)?true:false; //Сохранение Лога работы скрипта
if (isset ($systemLogBakCreate)) SysLogs::$logBakCreate = ($systemLogBakCreate)?true:false; //Сохранение Лога работы скрипта
if (isset ($systemErrorsView)) SysLogs::$errorsView = ($systemErrorsView)?true:false; //Видимость Ошибок работы скрипта

/*
 * Обработка входных параметров.
 * Внимание! Существует директива magic_quotes_sybase. Она вместо слеша добавляет кавычку и ОТМЕНЯЕТ действие magic_quotes_gpc.
 * Если она у вас установлена, тогда доработайте схему преобразования входных данных
 */
if (get_magic_quotes_gpc()) { 
  SysBF::stripsl($_GET);
  SysBF::stripsl($_POST);
  SysBF::stripsl($_COOKIE); 
  SysBF::strips($_REQUEST);
  if (isset($_SERVER['PHP_AUTH_USER'])) SysBF::stripsl($_SERVER['PHP_AUTH_USER']); 
  if (isset($_SERVER['PHP_AUTH_PW']))   SysBF::stripsl($_SERVER['PHP_AUTH_PW']);  
  //if (isset($argv) && is_array($argv)) SysBF::stripsl($argv);  TODO - проверить вдальнейшем и при необходимости раскомментировать
}

//Разместим параметры запроса в глобальный массив Glob::$vars['request']
SysBF::getRequest((isset($startFromConsole)&&$startFromConsole)?$startFromConsole:false);

//Определим формат вывода
if (Glob::$vars['console']) Glob::$vars['tpl_mode'] = 'txt'; //Если это консоль, то по умолчанию выводим в тексте
if (isset($startTplMode)) Glob::$vars['tpl_mode'] = $startTplMode; //Если четко установлено, то следуем ему
if (!empty(Glob::$vars['request']['tpl_mode'])) { //Если во входных параметрах есть непосредственное указание, то следуем ему
    switch (Glob::$vars['request']['tpl_mode']) {
        case "html": //Вывод в html формате для Web
            Glob::$vars['tpl_mode'] = 'html';
            break;
        case "txt": //Вывод в текстовом формате для консоли
            Glob::$vars['tpl_mode'] = 'txt';
            break;
        case "json": //Вывод в json формате
            Glob::$vars['tpl_mode'] = 'json';
            break;
    }
}

Glob::$vars['allow_redirect'] = (!empty($sysremRedirectsAllow))?true:false; //Разрешение системных редиректов

if (!empty($startModule)) Glob::$vars['module'] = strtolower($startModule);
