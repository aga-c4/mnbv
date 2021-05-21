<?php
/**
 * Шаблон данных о пользователе
 * Данные передаются массиве $item
 * Поля:
 * 'login' - если задано, то установим стартовое значение login
 */
?>
<div class="row w-100 my-4"></div>
<div class="row justify-content-md-center">
    <div class="my-5 align-middle col-lg-4 col-md-6 col-sm-8 col-xs-12">
        <FORM action='' method=post name=authform>
        <b><?=Lang::get("User");?>:</b> <?=MNBVf::getItemName($item['user'],Lang::isAltLang());?><br>
        <b><?=Lang::get("Discount");?>:</b> <?=MNBVf::getItemName($item['user']['discarr'],Lang::isAltLang());?> (<b><?=SysBF::getFrArr($item['user'],'discvalstr','');?></b>)
        <input type=hidden name=ul value=''>
        <input type=hidden name=up value=''>
        <input type=hidden name=fu value=''>
        <input type=hidden name=act value='auth'>
        <br><input type=submit value='<?=Lang::get("Exit");?>'><br>
        </FORM>
        <br>
        <a href="/intranet"><?=Lang::get("Go to Intranet");?></a>
    </div>
</div>
