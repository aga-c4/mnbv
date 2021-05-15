<?php
/**
 * Шаблон вывода объектов хранилища
 * Данные передаются массиве $item
 */
?>

<? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/wdg_imagesblockfirst.php'); ?>

<p>
    <?=(SysBF::getFrArr($item,'type')!=1)?('<b>'.MNBVf::getDateStr(SysBF::getFrArr($item['sub_obj'],'date',0),array('mnbv_format'=>'type1')).':</b> '):'';?>
    <i><?=SysBF::getFrArr($item['sub_obj'],'about','');?></i>
</p>
<?=SysBF::getFrArr($item['sub_obj'],'text','');?>
