<?php
/**
 * Блок изображений, который может использоваться в выводе объектов
 */
?>
<!-- Images -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>

<div class="lightbox-gallery">       
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
        // data-gallery="gallery1" чтоб привеязать к одной галерее с последовательным переходом.
        ?>
        <a href='<?=SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'src_big','');?>' 
           data-lightbox="lightbox" data-title="<?=SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'name','');?>">
            <img src='<?=SysBF::getFrArr($item['sub_obj']['files']["img"]["1"],'src','');?>'<?=$imgWStr;?><?=$imgWStr;?> 
                style="max-width: 98%;">
        </a><br>
    <?
    }
}

//Под основным изображением выведем минигаллерею с открытием больших картинок
//Вывод типа: <a href='URL_big' data-toggle="lightbox" data-title='$row->name'><img src='URL'></a>
$formImgNum = (isset($item["img_max_size"]["form_img_num"]))?intval($item["img_max_size"]["form_img_num"]):5; //количество изображений в панели редактирования
for ($i=2;$i<=$formImgNum;$i++){
    if (isset($item['sub_obj']['files']["img"]["$i"]) && !$tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($item['sub_obj']['files']["img"]["$i"],'src',''))){ //Это не специфический объект - выводим

        $imgWStr = (isset($value['files']["img"]["$i"]['size']['min']['w']))?(' width="'.$value['files']["img"]["$i"]['size']['min']['w'].'"'):'';
        if ($imgWStr=='' && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
        $imgHStr = (isset($value['files']["img"]["$i"]['size']['min']['h']))?(' height="'.$value['files']["img"]["$i"]['size']['min']['h'].'"'):'';

        //Название картинки
        $n = SysBF::getFrArr($item['sub_obj']['files']["img"]["$i"],'name','');

        //URL обычной картинки
        $u = SysBF::getFrArr($item['sub_obj']['files']["img"]["$i"],'src_min','');

        //URL ссылка большой картинки
        $a1 = (SysBF::getFrArr($item['sub_obj']['files']["img"]["$i"],'src_big'))?'<a href="'.$item['sub_obj']['files']["img"]["$i"]['src_big'].'" data-lightbox="lightbox" data-title="'.$n.'">':'';
        $a2 = (!empty($a1))?'</a>':'';

        echo $a1 . '<img class="img-fluid" src="' . $u . '""' . $imgWStr . $imgWStr . '>' . $a2 . "\n";
    }
}
?>        
</div>
<!-- /Images -->
