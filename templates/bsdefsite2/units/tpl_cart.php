<?php
/**
 * Шаблон авторизации
 * Данные передаются массиве $item
 * Поля:
 * 'login' - если задано, то установим стартовое значение login
 */
?>
<style>
table, tr, td, th, tbody, thead{
    display:block;
    width:100%;
    display:block;
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
<form class="w-100" action="" method=post name=cartform>
    <table class="table table-striped w-100">
        <thead class="table-light">
            <tr>
                <th>
                <th width="100%">Товар</th>
                <th style="min-width:100px;">Цена, <?=Glob::$vars['prod_currency_suf'];?></th>
                <th style="min-width:50px;">Кол.</th>
                <th style="min-width:100px;">Сумма, <?=Glob::$vars['prod_currency_suf'];?></th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <th>1</th><td><a href="/catalog/avtomaticheskie-stiral-nye-mashiny/pr_8-wre-76-p2-xww">Синхрофазотрон зеленый, суперкрутой и с супер длинным названием, которое никуда не лезет</a></td><td>28000</td><td><input type="text" size="4" id="qty1" name=qty class="form-control w-100" value="2"></td><td>56000</td><td>❌</td>
            </tr>
            <tr>
                <th>2</th><td><a href="/catalog/avtomaticheskie-stiral-nye-mashiny/pr_8-wre-76-p2-xww">Синхрофазотрон 327</a></td><td>28000</td><td><input type="text" size="4" id="qty1" name=qty class="form-control w-100" value="2"></td><td>56000</td><td>❌</td>
            </tr>
            <tr>
                <th>3</th><td><a href="/catalog/avtomaticheskie-stiral-nye-mashiny/pr_8-wre-76-p2-xww">Синхрофазотрон 327</a></td><td>28000</td><td><input type="text" size="4" id="qty1" name=qty class="form-control w-100" value="2"></td><td>56000</td><td>❌</td>
            </tr>
            <tr>
                <th>4</th><td><a href="/catalog/avtomaticheskie-stiral-nye-mashiny/pr_8-wre-76-p2-xww">Синхрофазотрон 327</a></td><td>28000</td><td><input type="text" size="4" id="qty1" name=qty class="form-control w-100" value="2"></td><td>56000</td><td>❌</td>
            </tr>
        </tbody>
    </table>
</form>

<div class="mt-3">
    Стоимость товаров: 5600 р.<br>
    Включая скидку: 800 р.<br>
    Масса товара: 20 кг.<br>
    Количество товара: 2 шт<br>
    Объем товара: 2,3 м3<br>
    Высота: 1,5м<br>
    Минимальнное измерение: 20 см.
</div>

<button type="button" class="btn btn-primary my-3">Пересчитать</button>
<button type="button" class="btn btn-primary my-3">Очистить корзину</button>
<a class="btn btn-primary my-3" href="/order" role="button">Оформить заказ</a>

