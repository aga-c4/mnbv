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
        "MNBV intranet" => "Intranet",
        "MNBV authorization" => "Authorization",
        "Storage list" => "Storage list",
        "Object list" => "Object list",
        "Update object" => "Update object",
        "View object" => "View object",
    ),
    "storage" => array(
        "Create storage" => "Create storage",
        "mLang" => "ru", //Основной язык
        "mAltLang" => "en", //Альтернативный язык
    ),
);

Lang::addToDict($langTmpArr,'en');
unset($langTmpArr);
