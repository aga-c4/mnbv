<?php
/**
 * Шаблон вывода списка объектов
 * Список объектов передается в элементе массива $item['list']
 * Поля:
 * "ru_name" , "eng_name" ... -  название позиции на требуемом языке (обязательно передавать хотя бы на дефолтовом языке)
 */

//Фильтр по группам
?>
<form method="get" name="edit0" action="">
    <?
    echo '<select name="storage_group" onChange="document.edit0.submit()">'."\n";
    echo '<option value="all">'.Lang::get('Storage groups','storageGroups')."</option>\n";
    foreach (SysStorage::$storageGroups as $value){
        echo '<option value="'.$value.'"'.(($item['storage_group']==$value)?' selected':'').'>'.Lang::get($value,'storageGroups')."</option>\n";
    }
    echo "</select>\n";
    ?>
</form>
<?
if (isset($item['list'])&&is_array($item['list'])){
    echo "<ul>\n";
    foreach ($item['list'] as $key => $value) {
        echo '<li><a href="'.$value["url"].'">'.$value["name"]."</a></li>\n";
    }
    echo "</ul>\n";
}
