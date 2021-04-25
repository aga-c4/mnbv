<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */
foreach ($menuArr as $menuItem) {
    echo '<a class="" href="' . $menuItem['url'] . '">' . $menuItem['name'] . '</a><br>'."\n";
}
