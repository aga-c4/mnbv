<?php
require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php');
?>
<link rel="shortcut icon" href="<?=WWW_IMGPATH;?>logo/smallico.ico">
<LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/mnbv.css" type="text/css" rel="Stylesheet" media="screen">
<link type="/text/css" href="/src/mnbv/css/jquery.lightbox.css" rel="stylesheet">

<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery-1.7.1.js" type="text/javascript"></script>
<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery.lightbox.js?show_linkback=false&amp;show_helper_text=false&amp;show_info=true&amp;show_extended_info=true&amp;keys.close=z&amp;keys.prev=q&amp;keys.next=e&amp;text.image=Фото&amp;text.of=из&amp;text.close=Закрыть&amp;text.download=Загрузить" type="text/javascript"></script>
<script src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/js/jquery.lightbox_start.js" type="text/javascript"></script>
</head>
<body>
<div class="container" style="width:<?=$intranet_width_str;?>;">

<div class="gormenu" style="width:<?=$intranet_width_str;?>;overflow: hidden;">
<span style="float:right;padding-right:5px;">
<?
    if (Lang::isDefLang()){ //Это основной язык
        echo ' | <b>' . Lang::getDefLang() . '</b> | <a href="' . ((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'') . '">' . Lang::getAltLangName() . '</a>';
    }else{ //Это альтернативный язык
        echo ' | <a href="' . ((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'') . '">' . Lang::getDefLang() . '</a> | <b>' . Lang::getAltLangName() . '</b>';
    }

?>
</span>
<a href="<?=((!empty(Glob::$vars['mnbv_site']['maindomain']))?(Glob::$vars['mnbv_site']['protocol'].Glob::$vars['mnbv_site']['maindomain']):'/').((Lang::isAltLang())?('/'.Lang::getAltLangName()):'');?>"><img src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/img/logo/logomini1.png" width="27" height="30" border="0" style="vertical-align: middle;"></a>
<?MNBVf::startVidget('gormenu',$item,3);?>
</div>

<div class="content">
<?=MNBVf::getNavStr($item['obj']['nav_arr'],array('fin_link_ctive'=>false,'link_class'=>'nav','delim'=>' -> '));?><br>
<?php
echo (!empty($item['page_h1'])) ? ("<h1>".$item['page_h1']."</h1>\n") : '';
echo (!empty($item['page_content'])) ? ($item['page_content']."\n") : '';
if (!empty($item['page_sctpl'])) {require(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.$item['page_sctpl']));}
?>

<hr><br>
<b><?=Lang::get('Last news');?>:</b><br>
<? //Виджет новостей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'news',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 1,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/news',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 2,//количество выводимых элементов
    'list_sort' => 'date_desc', //сортировка списка
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/news',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('News archive'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
));
?>
<br>
<hr><br>
<b><?=Lang::get('Last articles');?>:</b><br>
<? //Виджет новостей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'articles',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/articles',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 2,//количество выводимых элементов
    'list_sort' => 'date_desc', //сортировка списка
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/articles',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Articles archive'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
));
?>
<br>
<hr><br>
<b><?=Lang::get('Special offers');?>:</b><br>
<? //Виджет новостей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'products',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/catalog',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 3,//количество выводимых элементов
    'list_sort' => 'id', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/catalog',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Products catalog'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    'obj_prop_conf' => array( //Массив конфигурации вывода параметров объекта. По-умолчанию строка 'no_conf' - параметры не выводятся
        "price" => array("name"=>"price", "type"=>"text", "active" => "print")
    )
),
'wdg_prodlist.php');
?>


<?
echo (!empty($item['page_content2'])) ? ($item['page_content']."\n") : '';
MNBVf::putFinStatToLog();
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n"  . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";}
?>
</div>

<div class="futor" style="width:<?=$intranet_width_str;?>;">
<span style="color:blue;">&nbsp;&nbsp;<?
if (Glob::$vars['user']->get('userid')>0) $langUserName = 'No name'; else $langUserName = '';
if (Glob::$vars['user']->get('name')!='') $langUserName = Glob::$vars['user']->get('name');
if (!Lang::isDefLang()&&Glob::$vars['user']->get('namelang')!='') $langUserName = Glob::$vars['user']->get('namelang');
echo '<a href="/intranet/auth/">'.$langUserName.'</a>';
?></span>
<span style="float:right;">Сopyright © 2006-2018, AGA-C4 <?=SysBF::getFrArr($item,'site_name');?>&nbsp;&nbsp;</span>
</div>
</div>

</body>
</html>
