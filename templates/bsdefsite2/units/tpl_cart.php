<?php
/**
 * Шаблон авторизации
 * Данные передаются массиве $item
 * Поля:
 * 'login' - если задано, то установим стартовое значение login
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
<form class="w-100" action="/cart" method=post name=cartform>
    <table class="table table-striped w-100">
        <thead class="table-light">
            <tr class="tblhead">
                <th style="width:100px;"></th>
                <th  class="tlbhead" width="100%">Товар</th>
                <th style="min-width:100px;">Цена, <?=Glob::$vars['prod_currency_suf'];?></th>
                <th style="min-width:50px;">Кол.</th>
                <th style="min-width:100px;">Сумма, <?=Glob::$vars['prod_currency_suf'];?></th>
                <th></th>
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
                <td><span class="d-md-none">Количество: </span><input type="text" size="4" id="qty<?=$value["id"];?>" name=qty<?=$value["id"];?> class="form-control" value="<?=SysBF::getFrArr($value,'qty',0);?>"></td>
                <td><span class="d-md-none">Сумма: </span><b><?=SysBF::getFrArr($value,'itemsum','');?></b><span class="d-md-none"> <?=Glob::$vars['prod_currency_suf'];?></span></td>
                <td><a href="/cart/?act=rem&itemid=<?=$value["id"];?>" class="text-decoration-none">❌</a></td>
                <input type="hidden" name="crtitem[]" value="<?=$value["id"];?>">
            </tr>
            <? $counter++;} ?>
        </tbody>
    </table>
    
    <input type="hidden" name="act" value="upd">
    
    <button type="submit" class="btn btn-primary mt-3">Пересчитать</button>
    <a class="btn btn-primary mt-3" href="/cart/?act=clear" role="button">Очистить корзину</a>

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

    <a class="btn btn-primary mt-3" href="/order?instock=false" role="button">Заказать все</a>
    <? if (!empty($item['cart_items']['deficit'])) {?>
    <a class="btn btn-primary mt-3" href="/order?instock=true" role="button">Заказать из наличия</a>
    <?}?>

</form>

<? } else { ?>
    Ваша корзина пуста.
<? } ?>