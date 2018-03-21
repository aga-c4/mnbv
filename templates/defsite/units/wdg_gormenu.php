<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */

echo $menuStr = '';
foreach ($menuArr as $menuItem) {
    $menuStr .= ((empty($menuStr))?'| ':' | ') . '<a href="' . $menuItem['url'] . '"' . ((!empty($menuItem['active']))?' class="selected"':'') . '>' . $menuItem['name'] . '</a>';
}
echo $menuStr;