<?php
/**
 * Универсальный шаблон вывода данных в консоль.
 */

//Если это открытие из браузера, то делаем вывод как теста
if (!Glob::$vars['console']) header('Content-Type: text/plain; charset=utf-8');

//Выводимый контент
echo (!empty($item['page_h1']))?($item['page_h1'] . "\n------------\n"):'';
echo (!empty($item['page_content']))?($item['page_content'] . "\n------------\n"):'';
if (isset($item)) {var_dump($item); echo "\n------------\n";}
if (SysLogs::getErrors()!=''){echo "ERRORS:\n" . SysLogs::getErrors() . "\n------------\n";}
if (SysLogs::getLog()!=''){echo "LOG:\n" . SysLogs::getLog() . "\n------------\n";}
