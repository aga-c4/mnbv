<?php
/**
 * Инициализация основных хранилищ типа массив
 * User: AGA-C4
 * Date: 21.07.16
 * Time: 14:59
 */

/**
 * Установка значений массива типов отображений атрибутов хранилищ
 */
SysStorage::$arraySt["attrviewtypes"] = array(
    "1" => array("id"=>1,"parentid"=>0,"type"=>1,"visible"=>1,"name"=>"Типы отображения атрибутов","namelang"=>"Attributes view types"),
    "2" => array("id"=>2,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"cтрока","namelang"=>"string","alias" => "string"),
    "3" => array("id"=>3,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"целое число","namelang"=>"int","alias" => "int"),
    "4" => array("id"=>4,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"число с запятой","namelang"=>"decimal","alias" => "decimal"),
    "5" => array("id"=>5,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"дата","namelang"=>"date","alias" => "date"),
    "6" => array("id"=>6,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"дата-время","namelang"=>"datetime","alias" => "datetime"),
    "7" => array("id"=>7,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"текст","namelang"=>"textarea","alias" => "textarea"),
    "8" => array("id"=>8,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"выбор из списка","namelang"=>"select","alias" => "select"),
    "9" => array("id"=>9,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"радио","namelang"=>"radio","alias" => "radio"),
    "10" => array("id"=>10,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"чекбокс","namelang"=>"checkBox","alias" => "checkBox"),
    "11" => array("id"=>11,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"список чекбоксов","namelang"=>"checkBox list","alias" => "checkBoxlist"),
    "12" => array("id"=>12,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"выбор из привязанного списка","namelang"=>"select","alias" => "list"),
    "13" => array("id"=>13,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"скрытый атрибут","namelang"=>"hidden","alias" => "hidden"),
    "14" => array("id"=>14,"parentid"=>1,"type"=>0,"visible"=>1,"name"=>"неотображаемый атрибут","namelang"=>"noview","alias" => "noview"),
);
