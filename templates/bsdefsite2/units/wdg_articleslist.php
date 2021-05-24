<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
?>
<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 g-1">
<?
//Список объектов
$itemCounter = 0;
foreach ($item['list'] as $key=>$value) if ($key>0) {
    $dopItemClassStr = '';
    if ($itemCounter>0) $dopItemClassStr = ' d-none d-sm-block';
    $itemCounter++;
?>
    <div class="col mb-2<?=$dopItemClassStr;?>">
        <div class="card mb-0 mr-2 bg-white h-100">
            
            <div class="row g-0">
                <div class="col-md-4">
<?
if (isset($value['files']["img"]["1"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его 
    //Ютуб заменяем превьюшкой
    $yuScrArr = MNBVf::getYoutubeScreenByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''));
    //$imgWStr = ' width=""';
    //$imgHStr = ' height=""';
    if (empty($imgWStr) && isset($item['img_max_size']['img_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_max_w'] .'"';
?>
        <a href="<?=SysBF::getFrArr($value,'url','');?>" class="prodlist-img-a w-100 d-flex justify-content-center bg-white"><img class="card-img-top prodlist-img h-100" src='<?=SysBF::getFrArr($yuScrArr,'default','');?>' alt="<?=SysBF::getFrArr($value,'name','');?>"></a>
<?
} else {//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
    if (isset($value['files']['img']["1"])){ 
        //Подготовим размеры изображений
        $imgWStr = (isset($value['files']["img"]["1"]['size']['w']))?(' width="'.$value['files']["img"]["1"]['size']['w'].'"'):'';
        if ($imgWStr=='' && isset($item['img_max_size']['img_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_max_w'] .'"';
        $imgHStr = (isset($value['files']["img"]["1"]['size']['h']))?(' height="'.$value['files']["img"]["1"]['size']['h'].'"'):'';
?>
        <a href="<?=SysBF::getFrArr($value,'url','');?>" class="prodlist-img-a w-100 d-flex justify-content-center bg-white"><img class="card-img-top prodlist-img h-100" src='<?=SysBF::getFrArr($value['files']["img"]["1"],'src','');?>' alt="<?=SysBF::getFrArr($value,'name','');?>"></a>
<? 
    }
} 
?>
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=SysBF::getFrArr($value,'name','');?></a></h5>
                        <?=(SysBF::getFrArr($value,'type')!=1)?('<span class="card-subtitle mb-2 text-muted">'.MNBVf::getDateStr(SysBF::getFrArr($value,'date',0),array('mnbv_format'=>'type1')).'</span>'):'';?>
                        <?=(!empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):'';?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<? } ?>  
</div>
