<?php
/**
 * Словарь русского языка
 * Принцип:
 * в корне - основные слова для всех модулей
 * во вложенных массивах - слова модулей
 */
$langTmpArr = array(
    //Названия для страниц текущего модуля
    "module_names" => array(
        "MNBV site" => "Сайт",
        "MNBV intranet" => "Интранет",
        "MNBV authorization" => "Авторизация",
        "Storage list" => "Список хранилищ",
        "Object list" => "Объекты хранилища",
        "Update object" => "Редактирование объекта",
        "View object" => "Просмотр объекта",
    ),
    "storage" => array(
        "Create storage" => "Создать хранилище",
        "mLang" => "рус", //Основной язык
        "mAltLang" => "англ", //Альтернативный язык
    ),
);

Lang::addToDict($langTmpArr,'ru');
unset($langTmpArr);
