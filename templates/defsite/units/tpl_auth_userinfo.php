<?php
/**
 * Шаблон данных о пользователе
 * Данные передаются массиве $item
 * Поля:
 * 'login' - если задано, то установим стартовое значение login
 */
?>
<br>
<FORM action='' method=post name=authform>
<b><?=Lang::get("User");?>:</b> <?=SysBF::getFrArr($item['user'],'fio','');?><br>
<b><?=Lang::get("Discount");?>:</b> <?=SysBF::getFrArr($item['user'],'discname','');?> <b><?=SysBF::getFrArr($item['user'],'discvalstr','');?></b>
<input type=hidden name=ul value=''>
<input type=hidden name=up value=''>
<input type=hidden name=fu value=''>
<input type=hidden name=act value='auth'>
<br><input type=submit value='<?=Lang::get("Exit");?>'><br>
</FORM>
<br>
<a href="/intranet"><?=Lang::get("Go to Intranet");?></a>
