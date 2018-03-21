<?
//Базовые переменные для определения формата вывода и работы с логами (испльзуются только для иницаиализации, в работе используем Glob)
$startFromConsole = false; //Маркер запуска из консоли
$startTplMode = 'html'; //Формат ответа (txt,html,json,none)
$systemLogView = true; //Видимость Лога работы скрипта
$systemLogRTView = false; //Выводить сообщения непосредственно при их формировании
$systemLogSave = false; //Сохранение Лога работы скрипта
$systemErrorsView = false; //Видимость Ошибок работы скрипта
$sysremRedirectsAllow = true; //Разрешение системных редиректов

chdir(__DIR__ . '/../'); //Стартовая директория - рутовая
require_once 'modules/core/core.php'; //Запуск системы