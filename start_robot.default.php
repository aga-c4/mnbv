<?php
/**
 * Файл запуска консоли TODO - Файл запуска и настрек робота из консоли
 * запускаем в Видовсе так:
 * php start_robot.php session=ИдентификаторЗадания > data/storage_files/zbrobotsrun/att/p[ИдентификаторЗадания]_1.txt
 *
 * запускаем в Unix так:
 * nohup php start_robot.php session=ИдентификаторЗадания > data/storage_files/zbrobotsrun/att/p[ИдентификаторЗадания]_1.txt &
 *
 * В обоих случаях результат будет писаться в data/storage_files/zbrobotsrun/att/p[ИдентификаторЗадания]_1.txt
 */

//Базовые переменные для определения формата вывода и работы с логами (испльзуются только для иницаиализации, в работе используем Glob)
$startFromConsole = true; //Маркер запуска из консоли
$startTplMode = 'txt'; //Формат ответа (txt,html,json,none)
$startModule = 'robots'; //Запускаемый базовый модуль, если не установлен, то берем из констант и конфига
$systemLogView = false; //Видимость Лога работы скрипта
$systemLogRTView = true; //Выводить сообщения непосредственно при их формировании
$systemLogSave = false; //Сохранение Лога работы скрипта
$systemErrorsView = false; //Видимость Ошибок работы скрипта
$sysremRedirectsAllow = false; //Разрешение системных редиректов
chdir(__DIR__); //Стартовая директория - рутовая
require_once 'modules/core/core.php'; //Запуск системы