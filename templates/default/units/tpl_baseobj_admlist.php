<?php
/**
 * Шаблон универсальной таблицы объектов с возможностью редактирования
 */
MNBVf::startVidget('filterstandart',$item);
$listTargetStr = (!empty($item["list_link_target"])&&$item["list_link_target"]=='_blank')?' target=_blank':'';
?>

<table class="base">
<tr>
<th><?
if ($item['list_base_url_sort']=='sort_id/') {echo '<a  style="color:green;font-weight:bold;" href="' . $item["list_base_url"] . 'sort_id_desc/' . $item['list_base_url_lang'] . '">N</a>';}
elseif ($item['list_base_url_sort']=='sort_id_desc/') {echo '<a  style="color:red;font-weight:bold;" href="' . $item["list_base_url"] . 'sort_date/' . $item['list_base_url_lang'] . '">N</a>';}
elseif ($item['list_base_url_sort']=='sort_date/') {echo '<a  style="color:green;font-weight:bold;" href="' . $item["list_base_url"] . 'sort_date_desc/' . $item['list_base_url_lang'] . '">D</a>';}
elseif ($item['list_base_url_sort']=='sort_date_desc/') {echo '<a  style="color:red;font-weight:bold;" href="' . $item["list_base_url"] . $item['list_base_url_lang'] . '">D</a>';}
else {echo '<a style="font-weight:bold;" href="' . $item["list_base_url"] . 'sort_id/' . $item['list_base_url_lang'] . '">N</a>';}
?></th>
<? if (empty($item['list_not_edit'])){?>
<th><?
if ($item['list_base_url_sort']=='sort_pozid/') {echo '<a  style="color:green;font-weight:bold;" href="' . $item["list_base_url"] . $item['list_base_url_lang'] . '">'.Lang::get("mPoz").'</a>';}
else {echo '<a style="font-weight:bold;" href="' . $item["list_base_url"] . 'sort_pozid/' . $item['list_base_url_lang'] . '">'.Lang::get("mPoz").'</a>';}
?></th>
<? } ?>
<th><?
if ($item['list_base_url_sort']=='sort_visible/') {echo '<a  style="color:green;font-weight:bold;" href="' . $item["list_base_url"] . 'sort_visible_desc/' . $item['list_base_url_lang'] . '">'.Lang::get("mVis").'</a>';}
elseif ($item['list_base_url_sort']=='sort_visible_desc/') {echo '<a  style="color:red;font-weight:bold;" href="' . $item["list_base_url"] . $item['list_base_url_lang'] . '">'.Lang::get("mVis").'</a>';}
else {echo '<a style="font-weight:bold;" href="' . $item["list_base_url"] . 'sort_visible/' . $item['list_base_url_lang'] . '">'.Lang::get("mVis").'</a>';}
?></th>
<th><?
if ($item['list_base_url_sort']=='sort_first/') {echo '<a  style="color:green;font-weight:bold;" href="' . $item["list_base_url"] . 'sort_first_desc/' . $item['list_base_url_lang'] . '">'.Lang::get("mGl").'</a>';}
elseif ($item['list_base_url_sort']=='sort_first_desc/') {echo '<a  style="color:red;font-weight:bold;" href="' . $item["list_base_url"] . $item['list_base_url_lang'] . '">'.Lang::get("mGl").'</a>';}
else {echo '<a style="font-weight:bold;" href="' . $item["list_base_url"] . 'sort_first/' . $item['list_base_url_lang'] . '">'.Lang::get("mGl").'</a>';}
?></th>
<th></th>
<th align="left"><?
if (!empty(Glob::$vars['mnbv_altlang_vis'])){
    echo '<span style="float: right;">';
    if ($item['mnbv_altlang']) {echo '<a href="'.$item["list_base_url"].$item['list_base_url_sort'].(($item['list_page']>1)?('pg'.$item['list_page'].'/'):'').'">'.Lang::get("mLang").'</a>|<b>'.Lang::get("mAltLang").'</b>';}
    else {echo '<b>'.Lang::get("mLang").'</b>|<a href="'.$item["list_base_url"].$item['list_base_url_sort'].'altlang/'.(($item['list_page']>1)?('pg'.$item['list_page'].'/'):'').'">'.Lang::get("mAltLang").'</a>';}
    echo '&nbsp;</span>';
}

if ($item['list_base_url_sort']=='sort_name/') {echo '<a  style="color:green;font-weight:bold;" href="' . $item["list_base_url"] . 'sort_namelang/' . $item['list_base_url_lang'] . '">'.Lang::get("Name").'</a>';}
elseif ($item['list_base_url_sort']=='sort_namelang/') {echo '<a  style="color:blue;font-weight:bold;" href="' . $item["list_base_url"] . $item['list_base_url_lang'] . '">'.Lang::get("Name").'</a>';}
else {echo '<a style="font-weight:bold;" href="' . $item["list_base_url"] . 'sort_name/' . $item['list_base_url_lang'] . '">'.Lang::get("Name").'</a>';}
?></th>
<? if (empty($item['list_not_edit'])){?>
<th><?=Lang::get("mView");?></th>
<th><?=Lang::get("mEdit");?></th>
<th>DEL</th>
<? } ?>
<th><?=Lang::get("Action");?></th>
</TR>
 
<tr>
<th><?=(SysBF::getFrArr($item,'parent_id')>0)?SysBF::getFrArr($item,'parent_id'):'';?></th>
<? if (empty($item['list_not_edit'])){?>
<th></th>
<? } ?>
<th><input type="checkBox" <?=(SysBF::getFrArr($item["parent"],'visible'))?'checked':'';?> disabled></th>
<th><input type="checkBox" <?=(SysBF::getFrArr($item["parent"],'first'))?'checked':'';?> disabled></th>
<th><a class="link1" href="<?=(isset(Glob::$vars['back_url_last']))?Glob::$vars['back_url_last'].'?back=on':'/';?>"><img src="<?=WWW_IMGPATH;?>admin/dir.gif" border=0></a></th>
<th style="text-align: left;"><a class="link1" href="<?=SysBF::getFrArr($item,'parent_url');?><?=$item['list_base_url_lang'];?>" title="<?=SysBF::getFrArr($item,'parent_name');?>"><b><?=SysBF::getFrArr($item,'parent_name_min');?></b></a></th>
<? if (empty($item['list_not_edit'])){?>
<th><?=SysBF::getFrArr($item["parent"],'access',0);?></th>
<th><?=SysBF::getFrArr($item["parent"],'access2',0);?></th>
<th></th>
<? } ?>
<th align="right"><a class="link1" href="<?=SysBF::getFrArr($item,'parent_edit');?>"><?=(!empty($item["parent_edit"]))?Lang::get("Edit"):'';?></a></th>
</tr>
<?
if (isset($item['list'])&&is_array($item['list'])){
    echo "<ul>\n";
    foreach ($item['list'] as $key => $value) {
        
        $pghref = SysBF::getFrArr($value,'url','');    
        $pgtype = SysBF::getFrArr($value,'type',0); 
?>
<tr  onmouseover="style.backgroundColor='#FFFF99'" onmouseout="style.backgroundColor='#FFFFFF'">
<form method=post action="" class="form1">
        <? if (!empty($item['list_not_edit'])){//Вариант с минимальным редактированием 
?>
<td><?=SysBF::getFrArr($value,'id',0);?><input type="hidden" name="gid" value="<?=SysBF::getFrArr($value,'id',0);?>"></td>
<td align=center><input type="checkBox" name=gvisible <?=(!empty($value['visible']))?'checked':'';?>></td>
<td align=center><input type="checkBox" name=gfirst <?=(!empty($value['first']))?'checked':'';?>></td>
<td><?
if ($pgtype==1){echo '<a href="'.$pghref.'"><img src="'.WWW_IMGPATH.'admin/dir.gif" border="0"></a>';}
elseif ($pgtype==2){echo '<a href="'.$pghref.'"><img src="'.WWW_IMGPATH.'admin/url.jpg" border="0"></a>';}
elseif ($pgtype==3){echo '<a href="'.$pghref.'"><img src="'.WWW_IMGPATH.'admin/url.jpg" border="1"></a>';}
else {echo '<a href="'.$pghref.'"'.$listTargetStr.'><img src="'.WWW_IMGPATH.'admin/file.gif" border="0"></a>';}
echo "</td>\n";
$gnameval = MNBVf::getItemName($value,$item['mnbv_altlang']);
$gnameid = ($item['mnbv_altlang'])?'gnamelang':'gname';
if ($gnameval == '') $gnameval = $value['name'];
if ($pgtype==3){echo '<td width="100%" align="right">('.SysBF::getFrArr($value,'typeval').')&nbsp;'.$gnameval;}
else {echo '<td width="100%"><a href="'.$pghref.'"'.(($pgtype==0)?$listTargetStr:'').'>'.$gnameval.'</a>';}
?>
<td><input type="submit" style="WIDTH:100%" value="<?=Lang::get("Edit");?>"></td>
<input type="hidden" name="act" value="update" >
</form></tr>
<?
        }else{//Вариант с полноценным редактированием    
?>            
<td><?=SysBF::getFrArr($value,'id',0);?><input type="hidden" name="gid" value="<?=SysBF::getFrArr($value,'id',0);?>"></td>
<td><input type="text" name="gpozid" value="<?=SysBF::getFrArr($value,'pozid',0);?>" size="5" style="text-align:right;"></td>
<td align=center><input type="checkBox" name=gvisible <?=(!empty($value['visible']))?'checked':'';?>></td>
<td align=center><input type="checkBox" name=gfirst <?=(!empty($value['first']))?'checked':'';?>></td>
<td><?
if ($pgtype==1){echo '<a href="'.$pghref.'"><img src="'.WWW_IMGPATH.'admin/dir.gif" border="0"></a>';}
elseif ($pgtype==2){echo '<a href="'.$pghref.'"><img src="'.WWW_IMGPATH.'admin/url.jpg" border="0"></a>';}
elseif ($pgtype==3){echo '<a href="'.$pghref.'"><img src="'.WWW_IMGPATH.'admin/url.jpg" border="1"></a>';}
else {echo '<a href="'.$pghref.'"'.$listTargetStr.'><img src="'.WWW_IMGPATH.'admin/file.gif" border="0"></a>';}
echo "</td>\n";
$gnameval = MNBVf::getItemName($value,$item['mnbv_altlang']);
$gnameid = ($item['mnbv_altlang'])?'gnamelang':'gname';
if ($gnameval == '') $gnameval = $value['name'];
if ($pgtype==3){echo '<td width="100%" align="right">('.SysBF::getFrArr($value,'typeval').')&nbsp;<input type="text" name="'.$gnameid.'" value="'.$gnameval.'" style="WIDTH: 80%">';}
else {echo '<td width="100%"><input type="text" name="'.$gnameid.'" value="'.$gnameval.'" style="WIDTH: 100%">';}
?>  
<td><input type="text" name="gaccess" value="<?=SysBF::getFrArr($value,'access',0);?>" style="WIDTH: 100%"></td>
<td><input type="text" name="gaccess2" value="<?=SysBF::getFrArr($value,'access2',0);?>" style="WIDTH: 100%"></td>
<th><input type="checkBox" name=gdel ></th>
<td><input type="submit" style="WIDTH:100%" value="<?=Lang::get("Edit");?>"></td>
<input type="hidden" name="act" value="update" >
</form></tr>
<?
        }
    }
}
?>

<tr>
<form method=post action="" class="form1">
<th><input type="text" style="WIDTH: 100%" ssize="10" name="gfrid" value="" ></th>
<? if (empty($item['list_not_edit'])){?>
<th><input type="text" size="4" style="text-align:right;WIDTH: 100%" name=gpozid value=100 ></th>
<? } ?>
<th><input type="checkBox" name="gvisible" checked></th>
<th><input type="checkBox" name="gfirst" ></th>
<th colspan="<?=(empty($item['list_not_edit']))?5:2;?>"  class="line"><SELECT name="gtype" width="2">
<OPTION value="0" selected><?=Lang::get("Page");?></OPTION>
<OPTION value="1"><?=Lang::get("Folder");?></OPTION>
<OPTION value="2">URL</OPTION>
<OPTION value="3"><?=Lang::get("Other page");?></OPTION>
</SELECT><input type="text" style="WIDTH: 60%" ssize="40" name="gname" value="" ></th>
<th><input type=submit value="<?=Lang::get("Add");?>" style='WIDTH:100%'></th>
<input type=hidden name=act value="create" >
<input type=hidden name=razd value="0" >
</form>
</tr>

</table>
<? if (isset($item['list_max_items'])&&isset($item['list_size'])&&$item['list_max_items']<$item['list_size']) {echo Lang::get("Pages").': ' . MNBVf::getItemsNums($item['list_size'],$item['list_max_items'],$item['list_page'],$item["list_base_url_full"],$item['list_base_url_filter'],5);} ?>
<br>