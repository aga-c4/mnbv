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
                <th>
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
                <th><?=$counter;?></th>
                <td><a href="<?=SysBF::getFrArr($value,'url','');?>"><?=SysBF::getFrArr($value,'name','');?></a><? 
                if (!empty($value["deficit"])){ ?>
                    <br><?=(!empty($value["instock"]))?('<b>В наличии '.$value["instock"].' ед.</b> / '):'';?><b class="text-danger">Под заказ <?=$value["deficit"];?> ед.</b>    
                <? } else  {?>
                    <br><b>Есть в наличии</b>
                <? } ?></td>
                <td><?=SysBF::getFrArr($value,'price','');?></td>
                <td><input type="text" size="4" id="qty<?=$value["id"];?>" name=qty<?=$value["id"];?> class="form-control w-100" value="<?=SysBF::getFrArr($value,'qty',0);?>"></td>
                <td><?=SysBF::getFrArr($value,'itemsum','');?></td>
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
        Стоимость товаров: <?=SysBF::getFrArr($item['cart_items'],'prsum',0).' '.Glob::$vars['prod_currency_suf'];?><br>
        Включая скидку: <?=SysBF::getFrArr($item['cart_items'],'prdisc',0).' '.Glob::$vars['prod_currency_suf'];?><br>
        Масса товара: <?=SysBF::getFrArr($item['cart_items'],'weight',0);?> кг<br>
        Количество товара: <?=SysBF::getFrArr($item['cart_items'],'qty',0);?> шт<br>
        Объем товара: <?=SysBF::getFrArr($item['cart_items'],'volume',0);?> м3<br>
        Высота: <?=SysBF::getFrArr($item['cart_items'],'height',0);?> cм<br>
        Мин. ширина/глубина: <?=SysBF::getFrArr($item['cart_items'],'minw',0);?> см<br>
        Макc. ширина/глубина: <?=SysBF::getFrArr($item['cart_items'],'maxw',0);?> см
    </div>

    <a class="btn btn-primary mt-3" href="/order?instock=false" role="button">Заказать все</a>
    <? if (!empty($item['cart_items']['deficit'])) {?>
    <a class="btn btn-primary mt-3" href="/order?instock=true" role="button">Заказать из наличия</a>
    <?}?>

</form>

<? } else { ?>
    Ваша корзина пуста.
<? } ?>