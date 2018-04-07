<?php
/**
 * Шаблон редактирования объекта
 */

$pgid = SysBF::getFrArr($item['obj'],'id',0); //Id данного объекта

if (Glob::$vars['def_text_editor']=='tmce'){ //Будет выводиться, если в конфиге установлен как текстовый редактор по-умолчанию
?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/tmce/js/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        editor_deselector : "no-tiny",
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        // Theme options
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,insertdate,inserttime",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        
        //Мои добавки----------------------------------------------
        convert_urls : false, //Внимание - добавил, чтоб слеши не удалялись
        //---------------------------------------------------------

        // Example content CSS (should be your site CSS)
        //content_css : "css/content.css",
        content_css : "<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/mnbv.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/tmce/lists/template_list.js",
        external_link_list_url : "<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/tmce/lists/link_list.js",
        external_image_list_url : "<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/tmce/lists/image_list.js",
        media_external_list_url : "<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/tmce/lists/media_list.js",

        // Style formats
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}}
            //{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            //{title : 'Example 1', inline : 'span', classes : 'example1'},
            //{title : 'Example 2', inline : 'span', classes : 'example2'},
            //{title : 'Table styles'},
            //{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        formats : {
            alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
            aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
            alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
            alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
            //bold : {inline : 'span', 'classes' : 'bold'},
            //italic : {inline : 'span', 'classes' : 'italic'},
            //underline : {inline : 'span', 'classes' : 'underline', exact : true},
            bold : {inline : 'b'},
            italic : {inline : 'i'},
            underline : {inline : 'u'},
            strikethrough : {inline : 'del'}
        },

        // Replace values for the template plugin
        template_replace_values : {
            username : "MNBV",
            staffid : "267945"
        }
    });
</script>
<!-- /TinyMCE -->
<? } ?>

<table class="base" <?=(Glob::$vars['intranet_img_panel_view']=='right')?'style="float:left;min-width:590px;width:68%;margin-right: 20px;margin-bottom: 20px;"':'';?>>
    <SCRIPT>function Checkedit0(ef0objid){
        if (ef0objid=='ob_id') ef0objid = document.edit0.ob_id.value;
        location.href = '<?=$item["list_storage_url"];?>' + ef0objid + '/update/'+'<?=$item["list_base_url_alldop"];?>';
    }</SCRIPT>
    <form class="form1" action="" name="edit0" method="post" ENCTYPE="multipart/form-data">
    <tr>
        <th class=line colspan="2"><b><?=Lang::get("Go to");?>:</b>
            
            <?
            if (!empty(Glob::$vars['mnbv_altlang_vis'])){
                echo '<span style="float: right;">';
                if ($item['mnbv_altlang']) echo '<a href="'.$item["obj_update_url_altlang"].$item['form_folder_url'].'">'.Lang::get("mLang","storage").'</a>|<b>'.Lang::get("mAltLang","storage").'</b>';
                else echo '<b>'.Lang::get("mLang","storage").'</b>|<a href="'.$item["obj_update_url_altlang"].$item['form_folder_url'].'">'.Lang::get("mAltLang","storage").'</a>';
                echo '&nbsp;</span>';
            }
            
            $prevObjId = SysBF::getFrArr($item['obj'],'id',0) - 1;
            $nextObjId = SysBF::getFrArr($item['obj'],'id',0) + 1;
            ?>
            
            <a href="#" class="link1" onclick="Checkedit0(<?=$prevObjId;?>);"><b><<<</b></a>
            <input size="10" type="text" style="width:60px;" name="ob_id" value="<?=SysBF::getFrArr($item['obj'],'id',0);?>">
            <a href="#" class="link1" onclick="Checkedit0(<?=$nextObjId;?>);"><b>>>></b></a>
            <input style="width: 120px;" value="<?=Lang::get("Go");?>" type="button" onclick="Checkedit0('ob_id');">
            | <a href="<?=SysBF::getFrArr($item,'list_base_url_full')?>"><b><?=Lang::get("Return back");?></a></b></a>
        </th>
    </tr>
    </form>

    <tr><td colspan="2"><?

            //Выбор вкладки, если их больше чем 1
            if (!$item['form_one_folder']){
                $counter=0;
                foreach ($item['form_folders_url'] as $key=>$value) {
                    echo (($counter>0)?' | ':'') . (($item['form_folder']==$key)?('[<span style="font-weight:bold;">'.Lang::get($key,"storagefolders").'</span>]'):('[<a href="'.$item["obj_update_url_lang"].$value.'">'.Lang::get($key,"storagefolders").']</a>'));
                    $counter++;
                }
            }else echo "&nbsp";

            ?></td></tr>

        <form class="form1" action="" name="edit" method="post" ENCTYPE="multipart/form-data">
        <tr>
            <?
            $pixblockstr = '<img src="'.WWW_IMGPATH.'pix.gif" style="width:100px;height:1px;"><br>';
            if (SysBF::getFrArr($item['obj'],'first',0)==1) {echo '<th class=line style="background:#66ff66;">'.$pixblockstr.'<b>N:'.SysBF::getFrArr($item['obj'],'id',0).'</b><br><b>Ok!:</b><input type="checkBox" name="ob_first" checked></th>';}
            else {echo '<th class=line>'.$pixblockstr.'<b>N:'.SysBF::getFrArr($item['obj'],'id',0).'</b><br><b>Ok!:</b><input type="checkBox" name="ob_first"></th>';}
            echo "\n".'<th style="text-align:left;" width="100%"><b>'.Lang::get("Visible").':</b>';
            if (SysBF::getFrArr($item['obj'],'visible',0)==1) {echo '<input type="checkBox" name="ob_visible" checked> | ';}
            else {echo '<input type="checkBox" name="ob_visible" > | ';}
            echo '<input class=bigsubmit_vid value="'.Lang::get("Edit").'" type="submit">';
            if (!SysBF::getFrArr($item['obj'],'visible',0)){echo '<br><b>'.Lang::get("Delete").':</b> <input type="checkBox" name="del">';}
            else {echo '<br><b>'.Lang::get("Visible OFF to delete object").'</b>';}
            ?>
        </tr>

<?
        //Выведем элементы формы редактирования параметров объектов
        MNBVf::objPropGenerator(SysBF::getFrArr($item,'usestorage',''), $item['obj'], SysStorage::$storage[Glob::$vars['mnbv_usestorage']]['view'][$item['form_folder']], $item['mnbv_altlang'],'print');
?>
    <input type="hidden" name="ob_id" value="<?=SysBF::getFrArr($item['obj'],'id',0);?>">
    <input type="hidden" name="act" value="update">
    <input type="hidden" name="imgpanelsw" value="">

    <script>
        function imgpanelswch(ipsvval){
            document.edit.imgpanelsw.value = ipsvval;
            document.edit.submit();
            return true;
        }
    </script>
    <?=(!Glob::$vars['intranet_img_panel_view'])?'<tr><th class="line" colspan="2"><input class="bigsubmit_vid" value="'. Lang::get('Files RIGHT') .'" type="button" onclick="imgpanelswch(\'right\');"> <input class="bigsubmit_vid" value="'. Lang::get('Files DOWN') .'" type="button" onclick="imgpanelswch(\'down\');"></th></tr>':'';?>

    </form>
</table>

<? if (Glob::$vars['intranet_img_panel_view']=='right'||Glob::$vars['intranet_img_panel_view']=='down') { ?>
<!-- Files -->
<?
//подготовим служебные данные
$formImgNum = (isset($item["img_max_size"]["form_img_num"]))?intval($item["img_max_size"]["form_img_num"]):5; //количество изображений в панели редактирования
$formAttNum = (isset($item["img_max_size"]["form_att_num"]))?intval($item["img_max_size"]["form_att_num"]):5; //количество приложенных файлов в панели редактирования
$upl_imgnam = array();
$upl_attnam = array();
for ($i=1;$i<=$formImgNum;$i++) $upl_imgnam["$i"] = 'Img'.$i; //Изображения
for ($i=1;$i<=$formAttNum;$i++) $upl_attnam["$i"] = Lang::get('File').$i;//Другие Аттачи
?>
<script>
function slot_update(slot_action,slot_type,slot_id){
    if (slot_action == '') return false;
    document.getElementById('uplformloading').style.display='block';
    if (slot_type=='img' || slot_type=='att') document.uploadForm.slot_type.value = slot_type;
    if (Number.isInteger(slot_id)) document.uploadForm.slot_id.value = slot_id;
    document.uploadForm.act.value = slot_action;
    document.uploadForm.submit();
    return true;
}
</script>
<table class="base" <?=(Glob::$vars['intranet_img_panel_view']=='right')?'style="float:left; min-width:310px;width:30%;"':'';?>>
<form class="form1" action='/mnbvapi/upload/<?=Glob::$vars['mnbv_usestorage'];?>/<?=SysBF::getFrArr($item['obj'],'id',0);?>/' name='uploadForm' method='post' target='hiddenframe' enctype='multipart/form-data'>

    <!-- Images -->
    <tr><th class="line" colspan="2"><input class="bigsubmit_vid" value="<?=Lang::get('Files OFF');?>" type="button" onclick="imgpanelswch('off');">
        <input class="bigsubmit_vid" value="<?=(Glob::$vars['intranet_img_panel_view']!='right')?Lang::get('Files RIGHT'):Lang::get('Files DOWN');?>" type="button" onclick="imgpanelswch('<?=(Glob::$vars['intranet_img_panel_view']!='right')?'right':'down';?>');"></th></tr>
    <tr><td class="line" colspan="2">&nbsp;</td></tr>
    <tr><th class="line" colspan="2"><?=Lang::get('Images');?> <input class="bigsubmit_vid" value="<?=Lang::get('Edit files');?>" type="submit"> <input class="bigsubmit_vid" value="<?=Lang::get('Open the editor');?>" type="button" onclick="window.open('/imgeditor/');"></th></tr>
    <tr><td class="line" colspan="2"><b><?=Lang::get('Size config');?>:</b> <select name="img_max_size">
    <?
    //Список профилей размеров изображений
    foreach(Glob::$vars['img_max_size'] as $profKey=>$profVal){
        echo '<OPTION value="'.$profKey.'"'.(($item["img_max_size_profile"] == $profKey)?'selected':'').'>' . $profKey . '</OPTION>'."\n";
    }
    ?>
    </select></td></tr>
    <tr><td class="line" colspan="2"><b><?=Lang::get('Transform');?>:</b> <select name="img_сrop_type">
    <OPTION value='none' <?=($item["img_сrop_type"] == 'none')?'selected':'';?>><?=Lang::get('None transform');?></OPTION>
    <OPTION value='crop-top' <?=($item["img_сrop_type"] == 'crop-top')?'selected':'';?>><?=Lang::get('crop-top');?></OPTION>
    <OPTION value='crop-center' <?=($item["img_сrop_type"] == 'crop-center')?'selected':'';?>><?=Lang::get('crop-center');?></OPTION>
    </select></b></td></tr>
    <tr><td class="line" colspan="2">&nbsp;</td></tr>
    <? for ($i=1;$i<=$formImgNum;$i++){ ?>
    <tr><td colspan=2>
        <b><?=$upl_imgnam["$i"];?></b>
        <input type="file" name="ufimg<?=$i;?>" onChange="slot_update('upload','img',<?=$i;?>)" style="width:120px;">
        <input value="<?=Lang::get("Load from editor");?>" type="button" onclick="slot_update('frimgeditor','img',<?=$i;?>);"><br>
        URL: <input type='text' name='ufimgurl[<?=$i;?>]' value="<?=(!empty($item['obj']['files']["img"]["$i"]["url"]))?$item['obj']['files']["img"]["$i"]["url"]:'';?>" style="width:80%;"><br>
        <div id=resimg<?=$i;?> style='margin: 0 1em 0 0;float:left;width:100%'>
            <?
            if (isset($item['obj']['files']["img"]["$i"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($item['obj']['files']["img"]["$i"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его 
                echo $tecObjTxtCode;
            }else{//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
            if (isset($item['obj']['files']['img']["$i"])){ ?>
            <?=(SysBF::getFrArr($item['obj']['files']["img"]["$i"],'go_link'))?'<a href="'.$item['obj']['files']["img"]["$i"]['go_link'].'" target=_blank>':'';?><img src='<?=SysBF::getFrArr($item['obj']['files']["img"]["$i"],'src','');?>' style="max-width:100%"><?=(SysBF::getFrArr($item['obj']['files']["img"]["$i"],'go_link'))?'</a>':'';?><br>
            <input type="button" onclick="slot_update('delete','img',<?=$i;?>);" value="<?=Lang::get("Delete");?>"><br>
            <?=Lang::get('Name');?>: <input type='text' name='ufimgname[<?=$i;?>]' value="<?=(!empty($item['obj']['files']["img"]["$i"]["name"]))?$item['obj']['files']["img"]["$i"]["name"]:'';?>" style="width:80%;"><br>
            <?if (!empty($item["img_max_size"]["text"])){?><?=Lang::get('Text');?>: <input type='text' name='ufimgtext[<?=$i;?>]' value="<?=(!empty($item['obj']['files']["img"]["$i"]["text"]))?$item['obj']['files']["img"]["$i"]["text"]:'';?>" style="width:80%;"><br><?}?>
            <?=Lang::get('Link');?>: <input type='text' name='ufimglink[<?=$i;?>]' value="<?=(!empty($item['obj']['files']["img"]["$i"]["link"]))?$item['obj']['files']["img"]["$i"]["link"]:'';?>" style="width:80%;"><br>
            &nbsp;
            <? }} ?>
        </div>
    </td></tr>
    <? } ?>
    <!-- /Images -->

    <!-- Attachements -->
    <tr><th class="line" colspan="2"><?=Lang::get('Attachements');?></th></tr>
    <? for ($i=1;$i<=$formAttNum;$i++){ ?>
        <tr><td colspan=2>
        <b><?=$upl_attnam["$i"];?></b>
        <input type="file" name="ufatt<?=$i;?>" onChange="slot_update('upload','att',<?=$i;?>)"><br>
        URL: <input type='text' name='ufatturl[<?=$i;?>]' value="<?=(!empty($item['obj']['files']["att"]["$i"]["url"]))?$item['obj']['files']["att"]["$i"]["url"]:'';?>" style="width:80%;"><br>
        <input type=hidden name=fattdel<?=$i;?> value=''>
        <div id=resatt<?=$i;?> style='margin: 0 1em 0 0;float:left; width:100%'>
            <? if (isset($item['obj']['files']['att']["$i"])){ ?>
            <?=(SysBF::getFrArr($item['obj']['files']["att"]["$i"],'go_link'))?'<a href="'.$item['obj']['files']["att"]["$i"]['go_link'].'" target=_blank>':'';?><img src='<?=SysBF::getFrArr($item['obj']['files']["att"]["$i"],'src','');?>'><?=(SysBF::getFrArr($item['obj']['files']["att"]["$i"],'go_link'))?'</a>':'';?><br>
            <input type="button" onclick="slot_update('delete','att',<?=$i;?>);" value="<?=Lang::get("Delete");?>"><br>
            <?=Lang::get('Name');?>: <input type='text' name='ufattname[<?=$i;?>]' value="<?=(!empty($item['obj']['files']["att"]["$i"]["name"]))?$item['obj']['files']["att"]["$i"]["name"]:'';?>" style="width:80%;"><br>
            &nbsp;
            <? } ?>
        </div>
    </td></tr>
    <? } ?>
    <!-- Attachements -->

    <tr><th class="line" colspan="2"><input class="bigsubmit_vid" value="<?=Lang::get('Edit files');?>" type="submit"></th></tr>
    <input type="hidden" name="mainformname" value="edit">
    <input type="hidden" name="uplformname" value="uploadForm">
    <input type="hidden" name="act" value="update">
    <input type="hidden" name="slot_type" value="">
    <input type="hidden" name="slot_id" value="">
</form>

    <tr><td colspan=2>
    <div id=uplformloading style='display:none;'>
        Идет загрузка...
    </div>
    <iframe id='hiddenframe' name='hiddenframe' style='<?=(SysLogs::$logView && SysLogs::getLog()!=''||SysLogs::$errorsView && SysLogs::getErrors()!='')?'width:100%; height:150px; border:0':'width:0; height:0; border:0';?>'></iframe>
    </td></tr>
</table>
<!-- /Files -->

<? } ?>

<div class=clear></div>

<link type="text/css" href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/datepicker.css" rel="Stylesheet" />
<script type="text/javascript" src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/ui.datepicker.js"></script>
<script>
    $(".datepickerTimeField").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        firstDay: 1, changeFirstDay: false,
        navigationAsDateFormat: false,
        duration: 0 // отключаем эффект появления
    });
</script>