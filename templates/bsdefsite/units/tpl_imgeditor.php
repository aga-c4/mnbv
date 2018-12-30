<?php
/**
 * Шаблон графического редактора
 *
 * Created by Konstantin Khachaturyan
 * User: AGA-C4
 * Date: 09.04.15
 * Time: 16:53
 */
?>
<script type="text/javascript" src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/thcrt.js"></script>
<? if (empty($item["img_editor_view"])) { ?>
<form class="form1" action='' name='uploadForm' method='post' enctype='multipart/form-data'>
    <input type="file" name="ufimg" onchange="window.parent.document.forms['uploadForm'].submit();">
    <input type="hidden" name="act" value="upload">
</form>

<? }else{ ?>

<div id="imagearea" style="position:relative; cursor: crosshair; width:<?=SysBF::getFrArr($item,'img_editor_file_w',0);?>px; height:<?=SysBF::getFrArr($item,'img_editor_file_h',0);?>px; border-width:0; background-image: url('<?=SysBF::getFrArr($item,'img_editor_file','')."?cache_id=".date("YmdGis");?>')" align=left  onclick='mouseHandler(event)' onmousemove='mouseHandler(event)'>
    <div id="area"></div>
</div>

<form action='' name='imgredForm' method='post'><b>[</b><b style="color:green;">
x1:<input type="text" id="x1_inp" name="x1_inp" value="0" style='width:50px;text-align:right;' onChange="inpXYUpd();">
y1:<input type="text" id="y1_inp" name="y1_inp" value="0" style='width:50px;text-align:right;' onChange="inpXYUpd();"> ==>
x2:<input type="text" id="x2_inp" name="x2_inp" value="<?=SysBF::getFrArr($item,'img_editor_file_w',0);?>" style='width:50px;text-align:right;' onChange="inpXYUpd();">
y2:<input type="text" id="y2_inp" name="y2_inp" value="<?=SysBF::getFrArr($item,'img_editor_file_h',0);?>" style='width:50px;text-align:right;' onChange="inpXYUpd();">
</b><b>]</b>&nbsp;&nbsp;&nbsp;<b>[</b><b style="color:green;">
w1:<input type="text" id="th_width" value="<?=SysBF::getFrArr($item,'img_editor_file_w',0);?>" style='width:50px;text-align:right;' onChange="inpWidthUpd();">
h1:<input type="text" id="th_height" value="<?=SysBF::getFrArr($item,'img_editor_file_h',0);?>" style='width:50px;text-align:right;' onChange="inpHeightUpd();"> ==>
w2:<input type="text" id="th_w" name="th_w" value="<?=SysBF::getFrArr($item,'img_editor_file_w',0);?>" style='width:50px;text-align:right;' onChange="inpWnovUpd();">
h2:<input type="text" id="th_h" name="th_h" value="<?=SysBF::getFrArr($item,'img_editor_file_h',0);?>" style='width:50px;text-align:right;' onChange="inpHnovUpd();">
</b><b>]</b>
<input class='bigsubmit_vid'  value='<?=Lang::get("Edit");?>' type='submit'>
<input class='bigsubmit_vid'  value='<?=Lang::get("Delete");?>' type='submit' onclick="document.imgredForm.act.value = 'delete';">
<input type=hidden name=act  value='update'>
</tr>
</form>
<? } ?>
