<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */
?>
<ul class="navbar-nav mr-auto">

<? 
$itemCounter = 0;
foreach ($item['list'] as $key=>$menuItem) if ($key>0) { 
    $dopItemClassStr = ($itemCounter>4)?' d-xl-none d-xxl-none':'';
    $itemCounter++;
?>
<li class="nav-item<?=$dopItemClassStr;?>"><a class="nav-link my-nav-link" href="<?=SysBF::getFrArr($menuItem,'url','');?>"><?=SysBF::getFrArr($menuItem,'name','');?></a></li>

<? } ?>
</ul>
