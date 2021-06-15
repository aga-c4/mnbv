<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */
?>
<ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link my-nav-link" href="/<?=(Lang::isAltLang())?(Lang::getLang().'/'):'';?>catalog"><?=(Lang::isAltLang()?'Catalog':'Каталог');?></a></li>
<? 
$itemCounter = 0;
$menuLenght = 0;
foreach ($item['list'] as $key=>$menuItem) if ($key>0) {
    $itemCounter++;
    $menuName = SysBF::getFrArr($menuItem,'name','');
    $menuLenght += mb_strlen($menuName,'utf-8');
    $dopItemClassStr = ($menuLenght>60 || $itemCounter>4)?' d-xl-none d-xxl-none':'';
?>
<li class="nav-item<?=$dopItemClassStr;?>"><a class="nav-link my-nav-link" href="<?=SysBF::getFrArr($menuItem,'url','');?>"><?=$menuName;?></a></li>

<? } ?>
</ul>
