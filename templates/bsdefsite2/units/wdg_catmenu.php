<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */
?>
<ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link my-nav-link" href="/<?=(Lang::isAltLang()?Lang::getLang():'');?>catalog"><?=(Lang::isAltLang()?'Catalog':'Каталог');?></a></li>
<? 
$itemCounter = 0;
foreach ($item['list'] as $key=>$menuItem) if ($key>0) {
    $itemCounter++;
    $dopItemClassStr = ($itemCounter>4)?' d-xl-none d-xxl-none':'';
?>
<li class="nav-item<?=$dopItemClassStr;?>"><a class="nav-link my-nav-link" href="<?=SysBF::getFrArr($menuItem,'url','');?>"><?=SysBF::getFrArr($menuItem,'name','');?></a></li>

<? } ?>
</ul>
