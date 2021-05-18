<?php
/**
 * Шаблон вывода виджета горизонтального меню
 */
?>
  <ul class="pagination">
<? if ($list_page!=1) {/*Первая страница и многоточие*/ ?>      
    <li class="page-item"><a class="page-link" href="<?=MNBVf::generateObjUrl($item,array('altlang'=>Lang::isAltLang(),'pg'=>1,'page_list_url'=>$page_list_url));?>">1</a></li>      
<? }else{ ?>
    <li class="page-item active"><span class="page-link">1</span></li>    
<? } 
if ($blockStart>2) {?>    
    <li class="page-item"><span class="page-link">...</span></li>
<? } 

//Блок
for ($i=$blockStart;$i<=$blockEnd;$i++) {
    if ($i==1||$i==$pages) continue;
    if ($list_page!=$i) {?>
    <li class="page-item"><a class="page-link" href="<?=MNBVf::generateObjUrl($item,array('altlang'=>Lang::isAltLang(),'pg'=>$i,'page_list_url'=>$page_list_url));?>"><?=$i;?></a></li>
<?  } else { ?>
    <li class="page-item active"><span class="page-link"><?=$i;?></span></li>
<?  } 
}

//Многоточие и последняя страница
if ($blockEnd<$pages-1) {?>
    <li class="page-item"><span class="page-link">...</span></li>
<? } 
if ($list_page!=$pages) {?>
    <li class="page-item"><a class="page-link" href="<?=MNBVf::generateObjUrl($item,array('altlang'=>Lang::isAltLang(),'pg'=>$pages,'page_list_url'=>$page_list_url));?>"><?=$pages;?></a></li> 
<? }else{ ?>
    <li class="page-item active"><span class="page-link"><?=$pages;?></span></li>    
<? }

