<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */

if (Lang::isAltLang() && !empty($item['sub_obj']['textlang'])) echo SysBF::getFrArr($item['sub_obj'],'textlang','');
elseif (!Lang::isAltLang() && !empty($item['sub_obj']['text'])) echo SysBF::getFrArr($item['sub_obj'],'text','');

