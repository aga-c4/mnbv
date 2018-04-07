<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */

echo $menuStr = '<ul class="nav navbar-nav">'."\n";
$menuStr .= '<a href="'.(isset(Glob::$vars['back_url_last']))?Glob::$vars['back_url_last'].'?back=on':'/'.'"><--</a>'."\n";
foreach ($menuArr as $menuItem) {
    $menuStr .= '<li' . ((!empty($menuItem['active']))?' class="active"':'') . '><a href="' . $menuItem['url'] . '">' . $menuItem['name'] . '</a></li>'."\n";
}
echo $menuStr .= '</ul>'."\n";

/*Пример
<ul class="nav navbar-nav">
  <li class="active"><a href="#">О компании</a></li>
  <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Каталог <span class="caret"></span></a>
      <ul class="dropdown-menu">
          <li><a href="#">Категория1</a></li>
          <li><a href="#">Категория2</a></li>
          <li><a href="#">Категория3</a></li>
          <li role="separator" class="divider"></li>
          <li class="dropdown-header">Спец.предложения</li>
          <li><a href="#">Новинки</a></li>
          <li><a href="#">Уцененка</a></li>
      </ul>
  </li>
  <li><a href="#contact">Акции</a></li>
  <li><a href="#contact">Контакты</a></li>
  <li><a href="#contact">Авторизация</a></li>
</ul>
 */