<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
?>

<?if (!empty($item['list_sort_types'])&&is_array($item['list_sort_types'])){?>
<SCRIPT>
function CheckListSort(){
    sortAlias = document.listsort.list_sort_select.value;
    location.href = '<?=SysBF::getFrArr($item,'page_list_url','');?>' + '/sort_' + sortAlias;
}
</SCRIPT>
<form class="form1" action="" name="listsort" method="post" ENCTYPE="multipart/form-data">
    <?
    echo '<select name="list_sort_select" onChange="CheckListSort()">'."\n";
    echo '<option value="">'.Lang::get('list_sort_select','list_sort_types')."</option>\n";
    foreach ($item['list_sort_types'] as $key=>$value){
        echo '<option value="'.$key.'">'.Lang::get($value,'list_sort_types')."</option>\n";
    }
    echo "</select>\n";
    ?>
</form>
<br>
<? } ?>

<?
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
<a href="<?=SysBF::getFrArr($value,'url','');?>"><img style="float:left;padding-right: 5px;" src='<?=SysBF::getFrArr($yuScrArr,'default','');?>'<?=$imgWStr;?><?=$imgWStr;?>></a>
<?
} else {//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
    if (isset($value['files']['img']["1"])){ 
        //Подготовим размеры изображений
        $imgWStr = (isset($value['files']["img"]["1"]['size']['min']['w']))?(' width="'.$value['files']["img"]["1"]['size']['min']['w'].'"'):'';
        if ($imgWStr=='' && isset($item['img_max_size']['img_min_max_w'])) $imgWStr = ' width="'. $item['img_max_size']['img_min_max_w'] .'"';
        $imgHStr = (isset($value['files']["img"]["1"]['size']['min']['h']))?(' height="'.$value['files']["img"]["1"]['size']['min']['h'].'"'):'';
?>
<a href="<?=SysBF::getFrArr($value,'url','');?>"><img style="float:left;padding-right: 5px;" src='<?=SysBF::getFrArr($value['files']["img"]["1"],'src_min','');?>'<?=$imgWStr;?><?=$imgWStr;?>></a>
<? 
    }
} 
?>
<? if (!empty($value['price']) && $value['price']>0){?>Цена: <span style="font-weight:bold;color:red;"><?=SysBF::getFrArr($value,'price','');?>р.</span><br><?}?>
<? if (!empty($value['discount_price']) && $value['discount_price']>0){?><?=Lang::get("Discount price");?>: <span style="font-weight:bold;color:green;"><?=SysBF::getFrArr($value,'discount_price','');?>р.</span><br><?}?>
<? if (!empty($value['price']) && $value['price']>0 && !empty($value['oldprice']) && $value['oldprice']>$value['price']){?>Старая цена: <span style="font-weight:bold;color:red;text-decoration: line-through;"><?=SysBF::getFrArr($value,'oldprice','');?>р.</span><br><?}?>
<div class="clear"></div>
<?=(!empty($value['about']))?($value['about']).'<br>':'';?>
<? if (empty($value['type']) || $value['type']!=1 && !empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){?><button onclick="location.href = '<?=MNBVf::requestUrl((!Lang::isDefLang())?'altlang':'',SysBF::getFrArr(Glob::$vars,'cart_url',''));?>?product_id=<?=$value['id'];?>';"><?=Lang::get('Buy');?></button><br><?}?>
<br>
<?
}
?>

<? 
//Номера страниц
if (isset($item['list_max_items'])&&isset($item['list_size'])&&$item['list_max_items']<$item['list_size']) {
    echo Lang::get("Pages").': ' . MNBVf::getSiteItemsNums($item['obj'],$item['page_list_num_conf']);
} 
?>

