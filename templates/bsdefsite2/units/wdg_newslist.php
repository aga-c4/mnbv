<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 g-1">
<?
//Список объектов
$itemCounter = 0;
foreach ($item['list'] as $key=>$value) if ($key>0) {
    $dopItemClassStr = ($itemCounter>1)?' d-sm-none d-xl-block':'';
    $itemCounter++;
?>
    <div class="col mb-2<?=$dopItemClassStr;?>">
        <div class="card m-1 bg-light h-100 border-0">
            <div class="card-body p-1">
                <?=(SysBF::getFrArr($value,'type')!=1)?('<span class="card-subtitle mb-2 text-muted">'.MNBVf::getDateStr(SysBF::getFrArr($value,'date',0),array('mnbv_format'=>'type1')).'</span>'):'';?>
<? if (!empty($value['text'])){ ?>
                <span class="card-title"><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=(!empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):SysBF::getFrArr($value,'name','');?></a></span>
<? } else {?>
                <?=(!empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):'';?>
<? } ?>
            </div>
        </div>
    </div>    
<? } ?>  
</div>
