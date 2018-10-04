<?php
/**
 * Установка значений массива типов отображений атрибутов хранилищ
 */
SysStorage::$arraySt["usersgr"] = array(
    //Основные группы
    "1" => array("id"=>1,"pozid"=>100,"parentid"=>0,"type"=>1,"visible"=>1,"first"=>0,"name"=>"Группы пользователей","namelang"=>"Users Groups","access"=>0,"access2"=>2),
    "2" => array("id"=>2,"pozid"=>101,"parentid"=>1,"type"=>0,"visible"=>0,"first"=>0,"name"=>"Суперпользователь","namelang"=>"Root","access"=>0,"access2"=>2),
    "3" => array("id"=>3,"pozid"=>102,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Самозарегистрированные пользователи","namelang"=>"Site users","access"=>0,"access2"=>2),
    "4" => array("id"=>4,"pozid"=>103,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Группа Демо-доступа","namelang"=>"Demo","access"=>0,"access2"=>2),
    
    //Группы работы с контентом
    "101" => array("id"=>101,"pozid"=>201,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа cо страницами","namelang"=>"Content manager","access"=>0,"access2"=>2),
    "102" => array("id"=>102,"pozid"=>202,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c основным хранилищем","namelang"=>"Main Storage manager","access"=>0,"access2"=>2),
    "103" => array("id"=>103,"pozid"=>203,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c атрибутами","namelang"=>"Attributes manager","access"=>0,"access2"=>2),
    "104" => array("id"=>104,"pozid"=>204,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c меню","namelang"=>"Menu manager","access"=>0,"access2"=>2),
    "105" => array("id"=>105,"pozid"=>205,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c новостей","namelang"=>"News manager","access"=>0,"access2"=>2),
    "106" => array("id"=>106,"pozid"=>206,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа cо статьями","namelang"=>"Articles manager","access"=>0,"access2"=>2),
    "107" => array("id"=>107,"pozid"=>207,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c шаблонами","namelang"=>"Templates manager","access"=>0,"access2"=>2),
    "108" => array("id"=>108,"pozid"=>208,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с голосованиями (опросами)","namelang"=>"Votes manager","access"=>0,"access2"=>2),
    "109" => array("id"=>109,"pozid"=>209,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с файлами","namelang"=>"Files manager","access"=>0,"access2"=>2),
    "110" => array("id"=>110,"pozid"=>210,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с пользователями","namelang"=>"Users manager","access"=>0,"access2"=>2),
    "111" => array("id"=>111,"pozid"=>211,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с баннерами","namelang"=>"Banners manager","access"=>0,"access2"=>2),
    "112" => array("id"=>112,"pozid"=>212,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с рассылками","namelang"=>"Subscribe manager","access"=>0,"access2"=>2),
    "113" => array("id"=>113,"pozid"=>213,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c E-mail","namelang"=>"E-mails manager","access"=>0,"access2"=>2),
    "114" => array("id"=>114,"pozid"=>214,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c форумом","namelang"=>"Forum manager","access"=>0,"access2"=>2),
    "115" => array("id"=>115,"pozid"=>215,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с форумом добавление тем","namelang"=>"Forum add topics","access"=>0,"access2"=>2),
    "116" => array("id"=>116,"pozid"=>216,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с форумом закрытые темы","namelang"=>"Forum private topics","access"=>0,"access2"=>2),
    "117" => array("id"=>117,"pozid"=>217,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с сообщениями","namelang"=>"Messages manager","access"=>0,"access2"=>2),
    "118" => array("id"=>118,"pozid"=>218,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа c заказами","namelang"=>"Orders manager","access"=>0,"access2"=>2),
    
    //Группы учетной системы.
    "200" => array("id"=>200,"pozid"=>300,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа в Интранете","namelang"=>"Intranet","access"=>0,"access2"=>2),
    "201" => array("id"=>201,"pozid"=>301,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Директор","namelang"=>"Director","access"=>0,"access2"=>2),
    "202" => array("id"=>202,"pozid"=>302,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Главбух","namelang"=>"GLBuh","access"=>0,"access2"=>2),
    "203" => array("id"=>203,"pozid"=>303,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Мастер-Приемщик","namelang"=>"Master-priem","access"=>0,"access2"=>2),
    "204" => array("id"=>204,"pozid"=>304,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Менеджеры","namelang"=>"Manager","access"=>0,"access2"=>2),
    "205" => array("id"=>205,"pozid"=>305,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Главный по задачам","namelang"=>"Tickets manager","access"=>0,"access2"=>2),
    "206" => array("id"=>206,"pozid"=>306,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Просмотр всех задач","namelang"=>"Tickets master","access"=>0,"access2"=>2),
    "207" => array("id"=>207,"pozid"=>307,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с задачами","namelang"=>"Tickets work","access"=>0,"access2"=>2),
    "208" => array("id"=>208,"pozid"=>308,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с кассой","namelang"=>"Kassa manager","access"=>0,"access2"=>2),
    "209" => array("id"=>209,"pozid"=>309,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Просмотр Товаров с ограниченным доступом","namelang"=>"Spec products view","access"=>0,"access2"=>2),
    "210" => array("id"=>210,"pozid"=>310,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с каталогом товаров","namelang"=>"Product catalog manager","access"=>0,"access2"=>2),
    "211" => array("id"=>211,"pozid"=>311,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа со структурой каталога товаров","namelang"=>"Product catalog stru manager","access"=>0,"access2"=>2),
    "212" => array("id"=>212,"pozid"=>312,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с контрагентами","namelang"=>"Klient manager","access"=>0,"access2"=>2),
    "213" => array("id"=>213,"pozid"=>313,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с расчетами","namelang"=>"Payment manager","access"=>0,"access2"=>2),
    
    /*
    //Параметры брокера (номера зарезервированы, не использовать.)
    "301" => array("id"=>301,"pozid"=>301,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с Z-Broker","namelang"=>"Z-Broker","access"=>0,"access2"=>2),
    "302" => array("id"=>302,"pozid"=>302,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с Z-Broker конфигурацией","namelang"=>"Z-Broker config","access"=>0,"access2"=>2),
    "303" => array("id"=>303,"pozid"=>303,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с Z-Broker биржами","namelang"=>"Z-Broker config","access"=>0,"access2"=>2),
    "304" => array("id"=>304,"pozid"=>304,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с Z-Broker роботами","namelang"=>"Z-Broker bots","access"=>0,"access2"=>2),
    "305" => array("id"=>305,"pozid"=>305,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Работа с Z-Broker заданиями","namelang"=>"Z-Broker activity","access"=>0,"access2"=>2),
    "306" => array("id"=>306,"pozid"=>306,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Z-Broker менеджеры","namelang"=>"Z-Broker managers","access"=>0,"access2"=>2),
    "307" => array("id"=>307,"pozid"=>307,"parentid"=>1,"type"=>0,"visible"=>1,"first"=>0,"name"=>"Z-Broker Pro-Users","namelang"=>"Z-Broker Pro-Users","access"=>0,"access2"=>2),
    */
	
);
