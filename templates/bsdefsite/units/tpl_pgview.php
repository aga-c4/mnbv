<?php
/**
 * Шаблон вывода объектов хранилища
 * Данные передаются массиве $item
 */
?>

<? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/wdg_imagesblock.php'); ?>

<p>
    <i><?=(SysBF::getFrArr($item,'type')!=1)?(MNBVf::getDateStr(SysBF::getFrArr($item['sub_obj'],'date',0),array('mnbv_format'=>'type1')).': '):'';?>
    <?=SysBF::getFrArr($item['sub_obj'],'about','');?></i>
</p>
<?=SysBF::getFrArr($item['sub_obj'],'text','');?>
