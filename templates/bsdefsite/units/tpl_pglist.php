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

<?=(!empty($value['about']))?($value['about']).'<br>':'';?>
<br>
<?
}
?>

<? 
//Номера страниц
if (isset($item['list_max_items'])&&isset($item['list_size'])&&$item['list_max_items']<$item['list_size']) {
    echo Lang::get("Pages").': ' . MNBVf::getSiteItemsNums($item['obj']['parent'],$item['page_list_num_conf']);
} 
?>

