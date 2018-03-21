<?php
/**
 * Словарь английского языка
 * Принцип:
 * в корне - основные слова для всех модулей
 * во вложенных массивах - слова модулей
 */
$langTmpArr = array(
    
    //Названия для страниц текущего модуля
    "module_names" => array(
        "MNBV site" => "Site",
    ),
    
);

Lang::addToDict($langTmpArr,'eng');
unset($langTmpArr);
