<?php
/**
 * Шаблон вывода списка объектов
 * Список объектов передается в элементе массива $item['list']
 * Поля:
 * "ru_name" , "eng_name" ... -  название позиции на требуемом языке (обязательно передавать хотя бы на дефолтовом языке)
 */

if (isset($item['list'])&&is_array($item['list'])){
    echo "<ul>\n";
    foreach ($item['list'] as $key => $value) {
        echo '<li><a href="'.$value["url"].'">'.$value["name"]."</a></li>\n";
    }
    echo "</ul>\n";
}
