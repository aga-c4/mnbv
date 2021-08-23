<?php
/**
 * Шаблон вывода объектов хранилища
 * Данные передаются массиве $item
 */
?>
<div class ="row">    
    <div class="col-sm-12 col-md-6">
        <? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/wdg_imagesblock.php'); ?>
    </div>
    <div class="col-sm-12 col-md-6">
        
    <p>
    <?=Lang::get("Code");?>: <?=SysBF::getFrArr($item['sub_obj'],'id','');?><br>    
<? if (!empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){
    ?><?=Lang::get("Price");?>: <span style="font-weight:bold;"><?=SysBF::getFrArr($item['sub_obj'],'price','').Glob::$vars['prod_currency_suf'];?></span>
<? if (!empty($item['sub_obj']['oldprice']) && $item['sub_obj']['oldprice']>$item['sub_obj']['price']){ ?> 
            <span class="text-decoration-line-through"><?=$item['sub_obj']['oldprice'].Glob::$vars['prod_currency_suf'];?></span>
<?}?>
    <br>
<? if (!empty($item['sub_obj']['discount_price']) && $item['sub_obj']['discount_price']>0 && $item['sub_obj']['discount_price']<$item['sub_obj']['price']){?><?=Lang::get("Discount price");?>: <span style="font-weight:bold;color:green;"><?=SysBF::getFrArr($item['sub_obj'],'discount_price','').Glob::$vars['prod_currency_suf'];;?></span><br>
<?}?>
<?}?>
<? if ((empty($item['sub_obj']['type']) || $item['sub_obj']['type']!=1) && !empty($item['sub_obj']['price']) && $item['sub_obj']['price']>0){
if (Glob::$vars['cart_ajax']){?>  
            <button type="button" id="bbc<?=$item['sub_obj']['id'];?>" class="btn btn-primary" onclick="addToCart('<?=$item['sub_obj']['id'];?>')"><?=Lang::get('Buy');?></button>
<?}else{?>
            <a href="<?=MNBVf::requestUrl((!Lang::isDefLang())?'altlang':'',SysBF::getFrArr(Glob::$vars,'cart_url',''));?>?act=add&prodid=<?=$item['sub_obj']['id'];?>" class="btn btn-primary"><?=Lang::get('Buy');?></a>
<? }
}?>
    </p>

    <p>
    <?
//Вариант с выводом параметров из массива   array("name"=>"instock", "type"=>"select", "viewindex" =>false, "notset" =>true,  "delim"=>" | ", "checktype" => "int"),
$paramsArr = MNBVf::objPropGenerator($item['sub_obj']['sub_obj_storage'], $item['sub_obj'], array(
    "instock" => array("name"=>"instock", "type"=>"select", "viewindex" =>false,),
    "vendor" => array("name"=>"vendor", "type"=>"select", "viewindex" =>false),
    "model" => array("name"=>"model", "type"=>"text", "viewindex" =>false),
    "partnumber" => array("name"=>"partnumber", "type"=>"text", "viewindex" =>false),
    "barcode" => array("name"=>"barcode", "type"=>"text", "viewindex" =>false),
    "country" => array("name"=>"country", "type"=>"select", "viewindex" =>false),
    //"attrvalsmini" => array("name"=>"attrvalsmini", "type"=>"attrvalsmini")
    ), $item['mnbv_altlang'],'array');
$itemCounter = 0;
foreach ($paramsArr as $value) {
    //if ($itemCounter==0) echo '<b>'.Lang::get("Parameters").':</b><br>';
    $curIremVal = SysBF::getFrArr($value,'value','');
    if (!empty($curIremVal)) echo '<b>'. SysBF::getFrArr($value,'name','') . '</b>: ' . $curIremVal . '<br>'."\n";
    $itemCounter++;
}
?>
    </p>
    
    </div>  
</div>

<div class="accordion" id="prodaccordion">
    
    <div class="w-100 my-3">
        <ul class="nav nav-tabs">
            <li class="nav-item" id="headingOne">
              <a class="nav-link active" id="linktxt" data-toggle="collapse" href="#prtext" role="button" aria-expanded="true" aria-controls="prtext" onclick='$("#linktxt").addClass("active"); $("#linkattr").removeClass("active");'><?=Lang::get("Description");?></a>
            </li>
            <li class="nav-item" id="headingTwo">
              <a class="nav-link" id="linkattr" data-toggle="collapse" href="#prattr" role="button" aria-expanded="false" aria-controls="prattr" onclick='$("#linkattr").addClass("active"); $("#linktxt").removeClass("active");'><?=Lang::get("Parameters");?></a>
            </li>
        </ul>
    </div>    

    <div class="w-100 collapse show" id="prtext" aria-labelledby="headingOne" data-parent="#prodaccordion">
    <?=SysBF::getFrArr($item['sub_obj'],'text','');?>
    </div>

    <div class="w-100 collapse" id="prattr" aria-labelledby="headingTwo" data-parent="#prodaccordion">
    <?
    //Вариант с выводом параметров из массива
    $paramsArr = MNBVf::objPropGenerator($item['sub_obj']['sub_obj_storage'], $item['sub_obj'], array(
        "country" => array("name"=>"country", "type"=>"select", "viewindex" =>false),
        "attrvals" => array("name"=>"attrvals", "type"=>"attrvals")
        ), $item['mnbv_altlang'],'array');
    $itemCounter = 0;
    foreach ($paramsArr as $value) {
        //if ($itemCounter==0) echo '<b>'.Lang::get("Parameters").':</b><br>';
        $curIremVal = SysBF::getFrArr($value,'value','');
        if (!empty($curIremVal)) echo '<b>'. SysBF::getFrArr($value,'name','') . '</b>: ' . $curIremVal . '<br>'."\n";
        $itemCounter++;
    }
    ?>
    </div>

</div>
