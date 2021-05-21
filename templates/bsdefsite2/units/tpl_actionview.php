<?php
/**
 * Шаблон вывода объектов хранилища
 * Данные передаются массиве $item
 */
?>

<? require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/wdg_imagesblockfirst.php'); ?>

<? if (SysBF::getFrArr($item,'type')!=ST_FOLDER) {
    $dateStr = '';
    if ($date1=SysBF::getFrArr($item['sub_obj'],'date1',0)) {
        $dateStr .= '<span style="font-weight:bold;">'.' с ' . MNBVf::getDateStr($date1,array('mnbv_format'=>'type1')).'</span>';
        $noDate = false;
    }
    if ($date2=SysBF::getFrArr($item['sub_obj'],'date2',0)) {
        $dateStr .= '<span style="font-weight:bold;">'.' по ' . MNBVf::getDateStr($date2,array('mnbv_format'=>'type1')).'</span>';
        $noDate = false;
    }
    if ($dateStr!=='') echo '<p>Срок действия акции' . $dateStr . '</p>';
} ?>
<p><i><?=SysBF::getFrArr($item['sub_obj'],'about','');?></i></p>
<?=SysBF::getFrArr($item['sub_obj'],'text','');?>
