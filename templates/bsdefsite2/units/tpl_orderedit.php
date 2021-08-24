<?php
/**
 * Шаблон вывода формы корзины
 * Данные передаются массиве $item
 */

if ($item['cart_qty']>0){
?>
<style>
table, tr, td, th, tbody{
    width:100%;
    display:block;
}

thead{
    display:none;
}
    
@media (min-width:768px){
    table{
        display:table;
        width:auto;
    }
    tbody, thead{
        display:table-row-group;
        width:auto;
    }
    tr{
        display:table-row;
        width:auto;
    }
    td, th{
        display:table-cell;
        width:auto;
    }
}
</style>

<table class="table table-striped w-100">
    <thead class="table-light">
        <tr class="tblhead">
            <th style="width:100px;"></th>
            <th  class="tlbhead" width="100%">Товар</th>
            <th style="min-width:100px;">Цена, <?=Glob::$vars['prod_currency_suf'];?></th>
            <th style="min-width:50px;">Кол.</th>
            <th style="min-width:100px;">Сумма, <?=Glob::$vars['prod_currency_suf'];?></th>
        </tr>
    </thead>

    <tbody>
        <?
        $counter = 1;
        foreach($item['cart_items']['list'] as $value) { ?>
        <tr>
            <th style="width:100px;"><?
                $itemImg = SysBF::getFrArr($value,'img','');
                if (!empty($itemImg)) {
                    echo '<a href="'.SysBF::getFrArr($value,'url','').'"><img src="'.$itemImg.'" style="width:100%;"></a>';
                }
            ?></th>
            <td><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=SysBF::getFrArr($value,'name','');?></a><br>
                    Код товара: <?=SysBF::getFrArr($value,'prodid','');?>    
                <? 
            if (!empty($value["deficit"])){ ?>
                <br><?=(!empty($value["instock"]))?('<b>В наличии '.$value["instock"].' ед.</b> / '):'';?><b class="text-danger">Под заказ <?=$value["deficit"];?> ед.</b>    
            <? } else  {?>
                <br><b>Есть в наличии</b>
            <? } ?></td>
            <td><span class="d-md-none">Цена: </span><b><?=SysBF::getFrArr($value,'price','');?></b><span class="d-md-none"> <?=Glob::$vars['prod_currency_suf'];?></span></td>
            <td><span class="d-md-none">Количество: </span><?=SysBF::getFrArr($value,'qty',0);?></td>
            <td><span class="d-md-none">Сумма: </span><b><?=SysBF::getFrArr($value,'itemsum','');?></b><span class="d-md-none"> <?=Glob::$vars['prod_currency_suf'];?></span></td>
        </tr>
        <? $counter++;} ?>
    </tbody>
</table>

<a class="btn btn-primary mb-3" href="/cart" role="button">Вернуться к редактированию заказа</a>
<? if (!empty($item['cart_items']['deficit']) && empty($item['cart_instock_status'])) {?>
<a class="btn btn-primary mb-3" href="/order?instock=true" role="button">Заказать из наличия</a>
<?}elseif(!empty($item['cart_instock_status']) && Glob::$vars['order_full_link']){?>
<a class="btn btn-primary mb-3" href="/order?instock=false" role="button">Полный заказ</a>
<? } ?>

<div class="mt-3">
    <h5>Стоимость товаров: <?=SysBF::getFrArr($item['cart_items'],'prsum',0).' '.Glob::$vars['prod_currency_suf'];?></h5>
    <?
    if (SysBF::getFrArr($item['cart_items'],'prdisc',0)>0) echo 'Включая скидку: '.SysBF::getFrArr($item['cart_items'],'prdisc',0).' '.Glob::$vars['prod_currency_suf']."<br>\n";
    if (SysBF::getFrArr($item['cart_items'],'weight',0)>0) echo 'Масса товара: '.SysBF::getFrArr($item['cart_items'],'weight',0)." кг<br>\n";
    echo 'Количество товара: '.SysBF::getFrArr($item['cart_items'],'qty',0)." шт<br>\n";
    if (SysBF::getFrArr($item['cart_items'],'volume',0)>0) echo 'Объем товара: '.SysBF::getFrArr($item['cart_items'],'volume',0)." м3<br>\n";
    if (SysBF::getFrArr($item['cart_items'],'height',0)>0) echo 'Высота: '.SysBF::getFrArr($item['cart_items'],'height',0)." cм<br>\n";
    if (SysBF::getFrArr($item['cart_items'],'minw',0)>0) echo 'Мин. ширина/глубина: '.SysBF::getFrArr($item['cart_items'],'minw',0)." см<br>\n";
    if (SysBF::getFrArr($item['cart_items'],'maxw',0)>0) echo 'Макc. ширина/глубина: '.SysBF::getFrArr($item['cart_items'],'maxw',0)." см\n";
    ?>
</div>

<script>
    var selectform=0;
    function selform()
    {
        selectform=selectform+1;
        if (selectform >1 ){
            document.ordupd.submit();
        }
    }
    function selform2()
    {
            selectform=0;
    }
</script>
<form method=post action="" id="ordupd" name="ordupd" class="form1">
<input type=hidden name=act value="upd">
<div class="mt-3">
    <h5>Доставка:</h5>
</div>

<input class="form-check-input" type="radio" name="delivid" id="rddeliv0" value="0"<?=(!empty($item['cart_items']["deliv_type_id"]))?' checked':'';?> onclick="document.ordupd.submit();">
<label class="form-check-label" for="rddeliv0">Не выбрано</label>
    
<?
if (is_array($item['cart_items']['deliv_list']) && count($item['cart_items']['deliv_list'])){
    $dlcnt = 0; 
    foreach($item['cart_items']['deliv_list'] as $value) { $dlcnt++; ?>
<div class="form-check">
    <input class="form-check-input" type="radio" name="delivid" id="rddeliv<?=$dlcnt;?>" value="<?=SysBF::getFrArr($value,'id',0);?>"<?=(!empty($value["selected"]))?' checked':'';?> onclick="document.ordupd.submit();">
    <label class="form-check-label" for="rddeliv<?=$dlcnt;?>">
    <?=SysBF::getFrArr($value,'name','');?> (<?=SysBF::getFrArr($value,'price','').' '.Glob::$vars['prod_currency_suf'];?>)
  </label>
</div>
<? } ?>

<div class="mt-3">
    <h5>Оплата:</h5>
    
    <input class="form-check-input" type="radio" name="payid" id="rdpay0" value="0"<?=(!empty($item['cart_items']["pay_type_id"]))?' checked':'';?> onclick="document.ordupd.submit();">
    <label class="form-check-label" for="rdpay0">Не выбрано</label>

<?
if (is_array($item['cart_items']['pay_list']) && count($item['cart_items']['pay_list'])){
    $dlcnt = 0; 
    foreach($item['cart_items']['pay_list'] as $value) { $dlcnt++; ?>
<div class="form-check">
    <input class="form-check-input" type="radio" name="payid" id="rdpay<?=$dlcnt;?>" value="<?=SysBF::getFrArr($value,'id',0);?>"<?=(!empty($value["selected"]))?' checked':'';?> onclick="document.ordupd.submit();">
    <label class="form-check-label" for="rdpay<?=$dlcnt;?>">
    <?=SysBF::getFrArr($value,'name','');?>
  </label>
</div>
<? } 
}else{?>
Нет подходящего типа оплаты, наш менедежер свяжется с вами для определения оптимального варианта оплаты.    
<?}?>  
</div>

<? }else{ ?>
Нет подходящего типа доставки, наш менедежер свяжется с вами для определения оптимального варианта доставки.
<?}?>

</form>

<div class="mt-3">
    <h5>Данные по оплате:</h5>
    Стоимость доставки: <?=SysBF::getFrArr($item['cart_items'],'delivsum',0).' '.Glob::$vars['prod_currency_suf'];?><br>
    <b>Всего к оплате: <?=SysBF::getFrArr($item['cart_items'],'finsum',0).' '.Glob::$vars['prod_currency_suf'];?></b>
</div>

<?
if (Glob::$vars['order_empty_deliv_pay'] || (!empty($item['cart_items']["deliv_type_id"]) && !empty($item['cart_items']["pay_type_id"]))){
?>
<div class="mt-3">
    <h5>Данные покупателя:</h5>

<form method=post action="" name="edit" class="form1">
<table class="base">
<? MNBVf::objPropGenerator($item['sub_obj']['sub_obj_storage'], $item['sub_obj'], $item['sub_obj']['form_folder'], $item['mnbv_altlang'],'print'); ?>     
</table>
    
    
<div class="w-100 confirmatext">
    
    <div class="mt-3">
        <input type="checkbox" name="ordcond" id="ordcond"<?=(!empty($item["ordcond_ok"]))?' checked':'';?>>
        <label for="ordcond">Ознакомлен и согласен с условиями, правилами и тарифами:</a></label>
        <a href="javascript:void(0);" id="collapseConfirm1" onclick='$("#collapseConfirm").removeClass("d-none"); $("#collapseConfirm1").addClass("d-none");'>Подробнее</a>
        <? if (empty($item["ordcond_ok"])) {?>
        <Br>(<span class="text-danger">для оформления заказа необходимо согласиться с условиями, правилами и тарфиами</span>)
        <?}?>
    </div>
    
    <div  id="collapseConfirm" class="w-100 mt-3 d-none">
      <ol>
        <li>Ознакомлен и согласен с <a target="_blank" href="/delivery">условиями
            доставки</a> и <a href="/delivery" target="_blank">получения товара</a></li>
        <li>Ознакомлен с <a target="_blank" href="/delivery">тарифами на
            пронос и подъем техники вручную</a>, не входящими в стандартную доставку.</li>
        <li>Я даю согласие на получение электронного письма от <?=$_SERVER["HTTP_HOST"];?> с просьбой оставить отзыв.</li>

        <li>Порядок получения товара.
            <ul>
              <li>Получателем товара, оплаченного с помощью банковской карты, может быть только владелец карты или получатель, указанный при оформлении заказа. </li>
              <li>При получении товара, оплаченного с использованием онлайн платежа, получателю товара
                необходимо предъявить сотруднику магазина паспорт или иной документ, удостоверяющий личность.
              </li>
              <li>Если получатель товара не является плательщиком, то в целях безопасности,
                согласно рекомендации платежных систем, проверка корректности платежа может занять до 3-х дней.
              </li>
            </ul>
          </li>
        
      </ol>
      <a href="javascript:void(0);" onclick='$("#collapseConfirm").addClass("d-none");  $("#collapseConfirm1").removeClass("d-none");'>Свернуть</a>
    </div>
    
    <div class="mt-3">
        <input type="checkbox" name="ordconfirm" id="ordconfirm"<?=(!empty($item["ordconfirm_ok"]))?' checked':'';?>>
    Я даю согласие на обработку указанных в этой веб-форме моих персональных данных, включая право поручения обработки другим лицам
    на условиях, изложенных в <a href="/defence/" target="_blank">Политике в отношении обработки персональных данных в Интернете</a>, с которой я ознакомился.
    <? if (empty($item["ordconfirm_ok"])) {?>
    <Br>(<span class="text-danger">Для оформления заказа необходимо согласиться на обработку персональных данны</span>)
    <?}?>
    </div>

</div>  
    
<input type=submit class="btn btn-primary mt-3" value="<?=Lang::get("Edit");?>">
<button class="btn btn-primary mt-3" onclick="editCheck();">Отправить заказ</button>
    
<input type=hidden name=act value="updinfo">
</form>

<script>
    function editCheck(){
        if (document.edit.ordcond.checked == true && document.edit.ordconfirm.checked == true){
            document.edit.act.value='send'; 
        }
        document.edit.submit();
    }
    
    <?
    if (!empty($item['ordlbl'])){
        if ($item['ordlbl'] == 'ordcond'){
            echo 'document.edit.ordcond.focus();';
        }elseif ($item['ordlbl'] == 'ordconfirm'){
            echo 'document.edit.ordconfirm.focus();';
        }
    }
    ?>
</script>    
    
</div>
<? }else{ ?>
<div class="w-100 mt-3 text-danger">
    Для продолжения заказа необходимо выбрать способ доставки и тип оплаты.
</div>
<? } ?>
<link type="text/css" href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/datepicker.css" rel="Stylesheet" />
<script type="text/javascript" src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/ui.datepicker.js"></script>
<script>
    $(".datepickerTimeField").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        firstDay: 1, changeFirstDay: false,
        navigationAsDateFormat: false,
        duration: 0 // отключаем эффект появления
    });
</script>
<div class=clear></div>

<? } else { ?>
    Ваша корзина пуста.
<? }
    