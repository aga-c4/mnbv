<?php
/**
 * Универсальный шаблон вывода данных в консоль.
 */

//Если это открытие из браузера, то делаем вывод как теста
if (!Glob::$vars['console']) header('Content-Type: text/plain; charset=utf-8');

//Выводимый контент
$itemCounter = 0;
if (!empty($item['page_h1'])){ echo $item['page_h1'] . "\n------------\n";$itemCounter++;}
if (!empty($item['page_content'])){ echo $item['page_content'] . "\n------------\n";$itemCounter++;}
if (isset($item) && is_array($item) && count($item)>$itemCounter) {var_dump($item); echo "\n------------\n";}
MNBVf::putFinStatToLog();
if (SysLogs::getErrors()!=''){echo "ERRORS:\n" . SysLogs::getErrors() . "\n------------\n";}
if (SysLogs::getLog()!=''){echo "LOG:\n" . SysLogs::getLog() . "\n------------\n";}
