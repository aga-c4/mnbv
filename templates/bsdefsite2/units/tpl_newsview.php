<?php
/**
 * Шаблон вывода объектов хранилища
 * Данные передаются массиве $item
 */
?>
<div class ="row">
    <div class="col-sm-12 col-md-6">
        <? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/wdg_imagesblockfirst.php'); ?>
    </div>
    <div class="col-sm-12 col-md-6">
        
        <p>
            <?=(SysBF::getFrArr($item['sub_obj'],'type')!=1)?('<b>'.MNBVf::getDateStr(SysBF::getFrArr($item['sub_obj'],'date',0),array('mnbv_format'=>'type1')).':</b><br> '):'';?>
            <i><?=SysBF::getFrArr($item['sub_obj'],'about','');?></i>
        </p>

    </div>  
</div>

<div class="w-100">
<?=SysBF::getFrArr($item['sub_obj'],'text','');?>
</div>


