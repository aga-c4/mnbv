<?php
/**
 * Блок изображений, который может использоваться в выводе объектов
 */
?>
<!-- Images -->      
<?
//Вывод изображения
if (isset($item['sub_obj']['files']["img"]["1"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его
    //Ютуб заменяем превьюшкой
    $yuScrArr = MNBVf::getObjCodeByURL(SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'src',''));
    //$imgWStr = ' width=""';
    //$imgHStr = ' height=""';
    if (empty($imgWStr) && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
    ?>
    <?=MNBVf::getObjCodeByURL(SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'src',''));?><br>
<?
} else {//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
    if (isset($item['sub_obj']['files']['img']["1"])){
        //Подготовим размеры изображений
        if (empty($item['sub_obj']['files']["img"]["1"]["url"])){
            $imgWStr = (isset($item['sub_obj']['files']["img"]["1"]['size']['w']))?(' width="'.$item['sub_obj']['files']["img"]["1"]['size']['w'].'"'):'';
            if ($imgWStr=='' && isset($item['img_max_size']['img_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_max_w'] .'"';
            $imgHStr = (isset($item['sub_obj']['files']["img"]["1"]['size']['h']))?(' height="'.$item['sub_obj']['files']["img"]["1"]['size']['h'].'"'):'';
        }else{
            $imgWStr = $imgHStr = '';
        }
        ?>
            <img src='<?=SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'src','');?>'<?=$imgWStr;?><?=$imgWStr;?> style="max-width: 98%;">
    <?
    }
}
?>
<!-- /Images -->
