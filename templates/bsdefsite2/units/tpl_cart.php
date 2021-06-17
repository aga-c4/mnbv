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

<button type="button" class="btn btn-primary mb-3">Пересчитать</button>

<div style="">
    <h5>Доставка:</h5>
</div>

<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv1">
  <label class="form-check-label" for="rdDeliv1">
    Самовывоз (бесплатно)
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv2" checked>
  <label class="form-check-label" for="rdDeliv1">
    Курьер в пределах МКАД (600р.)
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv3">
  <label class="form-check-label" for="rdDeliv1">
    Транспортная компания по Московскому региону (600р.)
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv4">
  <label class="form-check-label" for="rdDeliv1">
    Транспортная компания по Московскому России (5000р.)
  </label>
</div>

<div class="mt-3">
    <h5>Оплата:</h5>
    <select id="paymode" name="paymode" onChange="" class="form-select" style="width: auto;">
        <option value="1" selected>Наличными</option>
        <option value="2">Картой банка</option>
        <option value="3">Яндекс деньги (бонус 2%)</option>
    </select>   
</div>

<div class="mt-3">
    Стоимость товаров: 5600 р.<br>
    Включая скидку: 800 р.<br>
    Стоимость доставки: 600 р.<br>
    <b>Всего к оплате: 6900 р.</b>
</div>

<a class="btn btn-primary mt-3" href="/order" role="button">Оформить заказ</a>
