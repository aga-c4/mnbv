<?php
/**
 * Шаблон вывода объектов хранилища
 * Данные передаются массиве $item
 */
?>

<? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/wdg_imagesblock.php'); ?>

<p>
    <? if (!empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){?><b><?=Lang::get("Price");?>:</b> <span style="font-weight:bold;color:red;"><?=SysBF::getFrArr($item['sub_obj'],'price','');?>р.</span><?}?>
    <? if (!empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){?><br><b><?=Lang::get("Discount price");?>:</b> <span style="font-weight:bold;color:green;"><?=SysBF::getFrArr($item['sub_obj'],'discount_price','');?>р.</span><?}?>
    <? if (!empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0 && !empty($item['sub_obj']['oldprice']) && $item['sub_obj']['oldprice']>$item['sub_obj']['price']){?><br><b><?=Lang::get("Old Price");?>:</b> <span style="font-weight:bold;color:red;text-decoration: line-through;"><?=SysBF::getFrArr($item['sub_obj'],'oldprice','');?>р.</span><?}?>
    <? if (empty($item['sub_obj']['type']) || $item['sub_obj']['type']!=1 && !empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){?><br><button onclick="location.href = '<?=MNBVf::requestUrl((!Lang::isDefLang())?'altlang':'',SysBF::getFrArr(Glob::$vars,'cart_url',''));?>?product_id=<?=$item['sub_obj']['id'];?>';"><?=Lang::get('Buy');?></button><?}?>
</p>

<? if (false) {/*Параметры непосредственный вывод*/?>
<table class="base">
<tr><td style="width:150px;"><img src="<?=WWW_IMGPATH;?>pix.gif" style="width:150px;height:1px;"><br><b><?=Lang::get("Parameters");?>:</b></td><td style="width:100%;"></td> 
<? MNBVf::objPropGenerator($item['sub_obj']['sub_obj_storage'], $item['sub_obj'], $item['sub_obj']['form_folder'], $item['mnbv_altlang'],'print'); ?>     
</table>
<?}?>

<b><?=Lang::get("Parameters");?>:</b><br>
<?
//Вариант с выводом параметров из массива
$paramsArr = MNBVf::objPropGenerator($item['sub_obj']['sub_obj_storage'], $item['sub_obj'], $item['sub_obj']['form_folder'], $item['mnbv_altlang'],'array');
foreach ($paramsArr as $value) echo '<b>'. SysBF::getFrArr($value,'name','') . '</b>: ' . SysBF::getFrArr($value,'value','') . '<br>'."\n";
?>



<?=SysBF::getFrArr($item['sub_obj'],'text','');?>

