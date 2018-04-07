<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */

//Список объектов
foreach ($item['list'] as $key=>$value) if ($key>0) {
?>
<?=(SysBF::getFrArr($value,'type')!=1)?(MNBVf::getDateStr(SysBF::getFrArr($value,'date',0),array('mnbv_format'=>'type1')).': '):'';?>
<a href="<?=SysBF::getFrArr($value,'url','');?>"><?=SysBF::getFrArr($value,'name','');?></a><br>

<?
if (isset($value['files']["img"]["1"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его 
    //Ютуб заменяем превьюшкой
    $yuScrArr = MNBVf::getYoutubeScreenByURL(SysBF::getFrArr($value['files']["img"]["1"],'src',''));
    //$imgWStr = ' width=""';
    //$imgHStr = ' height=""';
    if (empty($imgWStr) && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
?>
<a href="<?=SysBF::getFrArr($value,'url','');?>"><img src='<?=SysBF::getFrArr($yuScrArr,'default','');?>'<?=$imgWStr;?><?=$imgWStr;?>></a><br>
<?
} else {//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
    if (isset($value['files']['img']["1"])){ 
        //Подготовим размеры изображений
        $imgWStr = (isset($value['files']["img"]["1"]['size']['min']['w']))?(' width="'.$value['files']["img"]["1"]['size']['min']['w'].'"'):'';
        if ($imgWStr=='' && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
        $imgHStr = (isset($value['files']["img"]["1"]['size']['min']['h']))?(' height="'.$value['files']["img"]["1"]['size']['min']['h'].'"'):'';
?>
<a href="<?=SysBF::getFrArr($value,'url','');?>"><img src='<?=SysBF::getFrArr($value['files']["img"]["1"],'src_min','');?>'<?=$imgWStr;?><?=$imgWStr;?>></a><br>
<? 
    }
} 
?>

<?
//Вариант с выводом параметров из массива
foreach ($value['obj_prop_arr'] as $propValue) echo '<b>'. SysBF::getFrArr($propValue,'name','') . '</b>: ' . SysBF::getFrArr($propValue,'value','') . '<br>'."\n";
?>

<?=(!empty($value['about']))?($value['about']).'<br>':'';?>
<br>
<?
}

if (!empty($item['list_link'])) echo '<a href="'.$item['list_link'].'">'.SysBF::getFrArr($item,'list_link_name',Lang::get('More Info').'...').'</a>'."<br>\n";

