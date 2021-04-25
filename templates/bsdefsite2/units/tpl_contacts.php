<?php
/**
 * Шаблон вывода формы обратной связи
 * Данные передаются массиве $item
 */

if (!empty($item['sub_obj']['messageOk'])){
    echo '<br><b>'.Lang::get("Your message sent").'</b><br>';
}else{
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
        
        convert_urls : false, //Внимание - добавил, чтоб слеши не удалялись

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

<form method=post action="" name="edit" class="form1">
<table class="base">
<? MNBVf::objPropGenerator($item['sub_obj']['sub_obj_storage'], $item['sub_obj'], $item['sub_obj']['form_folder'], $item['mnbv_altlang'],'print'); ?>     
</table>
<input type=submit class="bigsubmit_vid" value="<?=Lang::get("Send message");?>">
<input type=hidden name=act value="create">
</form>

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
<div class=clear></div>
<? }
