<?php
require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php');
?>
    
    <link rel="shortcut icon" href="<?=WWW_IMGPATH;?>logo/smallico.ico">
    
    <!-- Bootstrap core CSS -->
    <link href="<?=WWW_SRCPATH;?>bootstrap3/docs/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?=WWW_SRCPATH;?>bootstrap3/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=WWW_SRCPATH;?>bsdefsite/css/navbar-static-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?=WWW_SRCPATH;?>bootstrap3/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <LINK href="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/css/mnbv.css" type="text/css" rel="Stylesheet" media="screen">
    <LINK type="/text/css" href="<?=WWW_SRCPATH;?>lightbox/css/lightbox.min.css" rel="stylesheet">
  </head>

  <body>

    <!-- Static navbar -->
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/" style="margin-top: 0px;"><img src="<?=WWW_SRCPATH.MNBV_MAINMODULE;?>/img/logo/logomini1.png" width="27" height="30" border="0"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
<?MNBVf::startVidget('gormenu',$item,3);?>
          <ul class="nav navbar-nav navbar-right">
<?
    if (Lang::isDefLang()){ //Это основной язык
        ?>
            <li class="active"><a href=""><?=Lang::getDefLang();?> <span class="sr-only">(current)</span></a></li>
            <li><a href="<?=((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'');?>"><?=Lang::getAltLangName();?></a></li>
        <?
    }else{ //Это альтернативный язык
        ?>
            <li><a href="<?=((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'');?>"><?=Lang::getDefLang();?> <span class="sr-only">(current)</span></a></li>
            <li class="active"><a href=""><?=Lang::getAltLangName();?></a></li>
        <?
    }
?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="container">
<?=(!empty($item['obj']['nav_arr']))?MNBVf::getNavStr($item['obj']['nav_arr'],array('fin_link_ctive'=>false,'link_class'=>'nav','delim'=>' -> ')):'';?><br>
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
    </div> <!-- /container -->
    
    <footer class="footer">
      <div class="container">
        <span style="color:blue;">&nbsp;&nbsp;<?
if (Glob::$vars['user']->get('userid')>0) $langUserName = 'No name'; else $langUserName = '';
if (Glob::$vars['user']->get('name')!='') $langUserName = Glob::$vars['user']->get('name');
if (!Lang::isDefLang()&&Glob::$vars['user']->get('namelang')!='') $langUserName = Glob::$vars['user']->get('namelang');
echo '<a href="/intranet/auth">'.$langUserName.'</a>';
?></span>
        <span style="float:right;">Сopyright © 2006-2018, AGA-C4  <?=SysBF::getFrArr($item,'site_name');?>&nbsp;&nbsp;</span>
      </div>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?=WWW_SRCPATH;?>bootstrap3/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?=WWW_SRCPATH;?>bootstrap3/docs/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=WWW_SRCPATH;?>bootstrap3/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    
    <script src="<?=WWW_SRCPATH;?>lightbox/js/lightbox-plus-jquery.min.js"></script>
  </body>
</html>
