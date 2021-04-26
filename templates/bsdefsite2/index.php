<?php
require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php');
?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?/* Ранее было так <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"> */?>

    <link rel="shortcut icon" href="<?=WWW_IMGPATH;?>logo/smallico.ico">
    
    <!-- Bootstrap CSS -->
<?/* Было так <link href="<?=WWW_SRCPATH;?>bootstrap3/docs/dist/css/bootstrap.min.css" rel="stylesheet">*/?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?=WWW_SRCPATH;?>bsdefsite2/css/main.css">
    
<?/* Было так <LINK rel="Stylesheet" type="/text/css" href="<?=WWW_SRCPATH;?>bsdefsite2/css/mnbv.css">
    <LINK rel="Stylesheet" type="/text/css" href="<?=WWW_SRCPATH;?>lightbox/dist/ekko-lightbox.css">*/?>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand">DemoWebShop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span></button>
        
            <div class="collapse navbar-collapse" id="navbarContent">
<?
//MNBVf::startVidget('gormenu',$item,3);
echo MNBVf::startVidget('pglist',$item,array(
    'storage' => 'products',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 1,//папка из которой будут выбираться объекты. Если не задано, то без учета папки
    'list_main_alias' => '/catalog',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 0,//количество выводимых элементов
    'list_sort' => 'posid', //сортировка списка
    //'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'folders',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/catalog',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Products catalog'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    //'obj_prop_conf' => array( //Массив конфигурации вывода параметров объекта. По-умолчанию строка 'no_conf' - параметры не выводятся
    //    "price" => array("name"=>"price", "type"=>"text", "active" => "print")
    //)
),'wdg_catmenu.php');?>                
       
                <form action="/searsh" class="d-flex" method="GET">
                    <input type="search" placeholder="Search" class="form-control mr-2">
                    <button class="btn btn-outline-success bg-transparent text-light">Search</button>
                </form>
            </div>
        </div>       
    </nav>

    <main>
        
        <div class="container">
            <div class="row">   
<!-- Карусель -->         
<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/src/bsdefsite2/img/p1_2.jpg" class="d-block w-100" alt="Баннер1">
    </div>
    <div class="carousel-item">
        <img src="/src/bsdefsite2/img/p1_3.jpg" class="d-block w-100" alt="Баннер2">
        <div class="carousel-caption d-sm-block">
            <h5>Second slide label</h5>
            <div class="d-none d-md-block">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br> consectetur adipiscing elit, consectetur</p>
            </div>
        </div>
    </div>
    <div class="carousel-item">
      <img src="/src/bsdefsite2/img/p1_4.jpg" class="d-block w-100" alt="Баннер3">
    </div>
    <div class="carousel-item">
      <img src="/src/bsdefsite2/img/p1_5.jpg" class="d-block w-100" alt="Баннер4">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
</div>
         </div>
<!-- /Карусель -->        
    
<div class="w-100"></div>

<?php
echo (!empty($item['page_h1'])) ? ('<div class="w-100"><h1>'.$item['page_h1']."</h1></div>\n") : '';
echo (!empty($item['page_content'])) ? ($item['page_content']."\n") : '';
if (!empty($item['page_sctpl'])) {require(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.$item['page_sctpl']));}
echo (!empty($item['page_content2'])) ? ($item['page_content2']."\n") : '';
?>

<? //Виджет баннеров акций (если надо не в карусели)
/*
echo Lang::get('Special offers') . ':<br>';
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'actions',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/actions',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 2,//количество выводимых элементов
    'list_sort' => 'id', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/actions',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('All actions'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    'obj_prop_conf' => array( //Массив конфигурации вывода параметров объекта. По-умолчанию строка 'no_conf' - параметры не выводятся
        "price" => array("name"=>"price", "type"=>"text", "active" => "print")
    )
),
'wdg_prodlist.php');
 */
?>

<? //Виджет товаров
//echo '<b>'.Lang::get('Special offers').':</b><br>';
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'products',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/catalog',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 4,//количество выводимых элементов
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
<div class="w-100 mt-3 pl-1"><a href="/news" class="h5 text-dark font-weight-bold text-decoration-none"><?=Lang::get('News');?></a></div>
<? //Виджет новостей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'news',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 1,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/news',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 3,//количество выводимых элементов
    'list_sort' => 'date_desc', //сортировка списка
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/news',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('News archive'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    ),
'wdg_newslist.php');
?>
<div class="w-100 mt-3 p-1"><a href="/articles" class="h5 text-dark font-weight-bold text-decoration-none"><?=Lang::get('Articles');?></a></div>
<? //Виджет статей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'articles',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => '/articles',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 4,//количество выводимых элементов
    'list_sort' => 'date_desc', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => '/articles',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Articles archive'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
),
'wdg_articleslist.php');
?>

    </div>
    </main>
    
    <footer class="mt-3 footer bg-dark text-light ">
        <div class="container">
            <div class="row">
                <div class="pt-3 col-md-3 col-sm-6 col-xs-12">
                    <b>О Компании:</b><br>
<?=MNBVf::startVidget('menu',$item,3,'wdg_footermenu.php');?>
                </div>
                <div class="pt-3 col-md-3 col-sm-6 col-xs-12">
                    <b>Контент:</b><br>
<?=MNBVf::startVidget('menu',$item,4,'wdg_footermenu.php');?>
                </div>
                <div class="pt-3 col-md-6 col-sm-12">
                    
<? //Виджет описания магазина в футоре
MNBVf::startVidget('pg',$item,array(
    'storage' => 'site',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'id' => 19,//папка из которой будут выбираться объекты. Если не задано, то 1
));
?>
                    
                    Сopyright © 2006-<?=date("Y");?>, AGA-C4  <?=SysBF::getFrArr($item,'site_name');?>
                </div>
            </div>
        </div>
    </footer>

    
    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    
<?/* Было так 
    <script src="<?=WWW_SRCPATH;?>lightbox/dist/ekko-lightbox.min.js"></script>
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
    </script>
     */?>
    
<?
MNBVf::putFinStatToLog();
if (SysLogs::getLog()!=''){echo "<pre>LOG:\n"  . SysLogs::getLog() . "-------\n</pre>";}
if (SysLogs::getErrors()!=''){echo "<pre>ERRORS:\n" . SysLogs::getErrors() . "-------\n</pre>";}
?>
  </body>
</html>