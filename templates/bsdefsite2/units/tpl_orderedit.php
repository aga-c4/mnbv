<?php
/**
 * Шаблон вывода формы корзины
 * Данные передаются массиве $item
 */
?>
<style>
table, tr, td, th, tbody, thead{
    display:block;
    width:100%;
    display:block;
}
@media (min-width:768px){
    table{
        display:table;
        width:auto;
    }
    tbody, thead{
        display:table-row-group;
        width:auto;
    }
    tr{
        display:table-row;
        width:auto;
    }
    td, th{
        display:table-cell;
        width:auto;
    }
}
</style>
<!--
<table class="table table-striped w-100">
    <thead class="table-light">
        <tr>
            <th>
            <th width="100%">Товар</th>
            <th style="min-width:100px;">Цена, <?=Glob::$vars['prod_currency_suf'];?></th>
            <th style="min-width:50px;">Кол.</th>
            <th style="min-width:100px;">Сумма, <?=Glob::$vars['prod_currency_suf'];?></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th>1</th><td>Синхрофазотрон зеленый, суперкрутой и с супер длинным названием, которое никуда не лезет</td><td>28000</td><td>2</td><td>56000</td>
        </tr>
        <tr>
            <th>2</th><td>Синхрофазотрон 327</td><td>28000</td><td>2</td><td>56000</td>
        </tr>
        <tr>
            <th>3</th><td>Синхрофазотрон 327</td><td>28000</td><td>2</td><td>56000</td>
        </tr>
        <tr>
            <th>4</th><td>Синхрофазотрон 327</td><td>28000</td><td>2</td><td>56000</td>
        </tr>
    </tbody>
</table>
-->

<div class="mt-3">
    <a class="btn btn-primary mb-3" href="/cart" role="button">Вернуться к редактированию заказа</a>
    <h5>Данные по заказу:</h5>
    Стоимость товаров: 5600 р.<br>
    Включая скидку: 800 р.<br>
    Масса товара: 20 кг.<br>
    Количество товара: 2 шт<br>
    Объем товара: 2,3 м3<br>
    Высота: 1,5м<br>
    Мин. ширина/глубина: 20 см.<br>
    Мак. ширина/глубина: 60 см.
</div>

<div class="mt-3">
    <h5>Доставка:</h5>
</div>
<!--
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv1">
  <label class="form-check-label" for="rdDeliv1">
    Самовывоз (бесплатно)
  </label>
</div>
-->
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv2" checked>
  <label class="form-check-label" for="rdDeliv1">
    Курьер в пределах МКАД (600р.)
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv3">
  <label class="form-check-label" for="rdDeliv1">
    Транспортная компания по Московскому региону (600р.)
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="deliv1" id="rdDeliv4">
  <label class="form-check-label" for="rdDeliv1">
    Транспортная компания по Московскому России (5000р.)
  </label>
</div>

<div class="mt-3">
    <h5>Оплата:</h5>
    <select id="paymode" name="paymode" onChange="" class="form-select" style="width: auto;">
        <option value="1">Наличными</option>
        <option value="2" selected>Картой банка</option>
        <option value="3">Яндекс деньги (бонус 2%)</option>
    </select>   
</div>

<div class="mt-3">
    <h5>Данные по оплате:</h5>
    Стоимость доставки: 600 р.<br>
    <b>Всего к оплате: 6900 р.</b>
</div>

<div class="mt-3">
    <h5>Данные покупателя:</h5>
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
<? /*<input type=submit class="btn btn-primary" value="<?=Lang::get("Send order");?>">*/?>
<a class="btn btn-primary mb-3" href="/order?step=send" role="button">Отправить заказ</a>    
<input type=hidden name=act value="create">
</form>

</div>

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
