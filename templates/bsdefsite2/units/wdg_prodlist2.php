<?php
/**
 * Шаблон вывода списка объектов, вложенных в текущий объект текущего хранилища
 * Данные передаются массиве $item
 */
?>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-1">
<?
//Список объектов
$itemCounter = 0;
$listSize = count($item['list']);
$max_item_3 = $listSize - $listSize%3;
foreach ($item['list'] as $key=>$value) if ($key>0) {
    $dopItemClassStr = '';
    //if ($itemCounter==1) $dopItemClassStr = ''; // Если на минимуме 1 товар. то так: ' d-none d-md-block';  //d-sm-none d-xl-block
    //elseif ($itemCounter==2) $dopItemClassStr = ' d-none d-lg-block';
    //elseif ($itemCounter>2) $dopItemClassStr = ' d-none d-xl-block';
    if ($itemCounter+1>$max_item_3) $dopItemClassStr = ' d-block d-md-none d-lg-block';
    $itemCounter++;
?>
<?
/*(SysBF::getFrArr($value,'type')!=1)?(MNBVf::getDateStr(SysBF::getFrArr($value,'date',0),array('mnbv_format'=>'type1')).': '):'';
 * col-sm-12 col-md-6 col-lg-4 col-xl-3
 */ 
?>
    <div class="col mb-2<?=$dopItemClassStr;?>">
        <div class="card m-1 bg-light h-100 shadow">
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
        <div class="card-body">
            <h5 class="card-title"><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=SysBF::getFrArr($value,'name','');?></a></h5>
    <?=($value['type']==1 && !empty($value['about']))?('<p class="card-text">'.$value['about'].'</p>'):'';?>
<? if (!empty($value['price']) && $value['price']>0){
    ?><?=Lang::get("Price");?>: <span style="font-weight:bold;"><?=SysBF::getFrArr($value,'price','').Glob::$vars['prod_currency_suf'];?></span>
<? if (!empty($value['oldprice']) && $value['oldprice']>$value['price']){ ?> 
            <span class="text-decoration-line-through"><?=$value['oldprice'].Glob::$vars['prod_currency_suf'];?></span>
<?}?>
    <br>
<? if (!empty($value['discount_price']) && $value['discount_price']>0 && $value['discount_price']<$value['price']){?><?=Lang::get("Discount price");?>: <span style="font-weight:bold;color:green;"><?=SysBF::getFrArr($value,'discount_price','').Glob::$vars['prod_currency_suf'];?></span><br>
<?}?>

<?}?>
<? 
if ((empty($value['type']) || $value['type']!=1) && !empty($value['price']) && $value['price']>0){
if (Glob::$vars['cart_ajax']){?>  
            <button type="button" id="bbc<?=$value['id'];?>" class="btn btn-primary" onclick="addToCart('<?=$value['id'];?>')"><?=Lang::get('Buy');?></button>
<?}else{?>
            <a href="<?=MNBVf::requestUrl((!Lang::isDefLang())?'altlang':'',SysBF::getFrArr(Glob::$vars,'cart_url',''));?>?act=add&prodid=<?=$value['id'];?>" class="btn btn-primary"><?=Lang::get('Buy');?></a>
    <? 
}
} 
//print_r($value);
?>
            </div>
        </div>
    </div>    
<? } ?>  
</div>
