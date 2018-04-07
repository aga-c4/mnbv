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
    <b><?=Lang::get("User");?>: <?=SysBF::getFrArr($item['user'],'fio','');?></b>
    <input type=hidden name=ul value=''>
    <input type=hidden name=up value=''>
    <input type=hidden name=fu value=''>
    <input type=hidden name=act value='auth'>
    <br><input type=submit value='<?=Lang::get("Exit");?>'><br>
    </FORM>
<br>
<?
if (MNBVf::getViewLogsStatus()){//Настройки логов и редректа и всего остального доступны только тем, у кого в админке стоит маркер viewlogs
?>
<FORM action='' method=post name=authform>
    <b><?=Lang::get("logs_view");?>:</b> <input type="checkBox" name="logs_view"<?=(SysLogs::$logView)?' checked':'';?>><br>
    <b><?=Lang::get("allow_redirect");?>:</b> <input type="checkBox" name="allow_redirect"<?=(Glob::$vars['allow_redirect'])?' checked':'';?>><br>
    <input type=hidden name=act value='update'>
    <br><input type=submit value='<?=Lang::get("Edit");?>'><br>
</FORM>
<?}
