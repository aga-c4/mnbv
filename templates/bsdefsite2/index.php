<?php
require_once MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'head.php');
?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?/* Ранее было так <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"> */?>

    <link rel="shortcut icon" href="<?=WWW_IMGPATH;?>logo/smallico.ico">
    
    <!-- Bootstrap CSS -->
<?/* 
 * <link href="<?=WWW_SRCPATH;?>bootstrap3/docs/dist/css/bootstrap.min.css" rel="stylesheet">
 * <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
 * <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
 * <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
 */?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?=WWW_SRCPATH;?>bsdefsite2/css/main.css">
    
<?/* Было так <LINK rel="Stylesheet" type="/text/css" href="<?=WWW_SRCPATH;?>bsdefsite2/css/mnbv.css">
    <LINK rel="Stylesheet" type="/text/css" href="<?=WWW_SRCPATH;?>lightbox/dist/ekko-lightbox.css">*/?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <?=(!empty(Glob::$vars['counter_block']))?Glob::$vars['counter_block']:'';?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler mr-2 mb-1" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
            <a href="<?=MNBVf::requestUrl(Lang::isAltLang()?'altlang':'','/');?>" class="navbar-brand">DEMO</a>
        
            <div class="collapse navbar-collapse" id="navbarContent">
                
                <ul class="d-xl-none navbar-nav navbar-right">
                    <li><a class="nav-link my-nav-link" href="<?=MNBVf::requestUrl(Lang::isAltLang()?'altlang':'','/');?>"><?=Lang::get('Main page');?></a></li>
                </ul>
<?
//MNBVf::startVidget('gormenu',$item,3);
echo MNBVf::startVidget('pglist',$item,array(
    'storage' => 'products',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'vidget_alias' => 'gormenucatalog',//Алиас текущего виджета для идентификации (иногда важно знать в каком конкретно месте вызывается виджет)
    'folderid' => 1,//папка из которой будут выбираться объекты. Если не задано, то без учета папки
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 0,//количество выводимых элементов
    'list_sort' => 'pozid', //сортировка списка
    'data_mode' => 'light', //Облегченный вывод - только названия, идентификатор, типы и урлы
    //'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'folders',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    //'obj_prop_conf' => array( //Массив конфигурации вывода параметров объекта. По-умолчанию строка 'no_conf' - параметры не выводятся
    //    "price" => array("name"=>"price", "type"=>"text", "active" => "print")
    //)
),'wdg_catmenu.php');?>                
       
                <ul class="navbar-nav navbar-right">
                <?
            if (Lang::isDefLang()){ //Это основной язык
                /*<li><a class="nav-link my-nav-link disabled" href="<?=((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'');?>"><?=Lang::getDefLang();?></a></li>*/
                ?>
                    <li><a class="nav-link my-nav-link" href="<?=((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'');?>"><?=Lang::getAltLangName();?></a></li>
                <?
            }else{ //Это альтернативный язык disabled
                ?>
                    <li><a class="nav-link my-nav-link" href="<?=((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'');?>"><?=Lang::getDefLang();?></a></li>
                <?
                /*<li><a class="nav-link my-nav-link disabled" href="<?=((!empty($item['page_url_swlang']))?$item['page_url_swlang']:'');?>"><?=Lang::getAltLangName();?></a></li>*/
            }
                ?>
                </ul>
                
            </div>
                        
            <div class="text-right pl-2 pr-1" id="cartico" style="background: url(/src/mnbv/img/logo/cart-blue.png) no-repeat; background-position: left center; background-size: 32px 30px; min-width:40px; min-height: 32px;">
                <a href='<?=MNBVf::requestUrl(Lang::isAltLang()?'altlang':'','/');?>cart'><span class="badge rounded-pill bg-light text-dark" id="carticoqty"></span></a>
            </div>
            
            <script>
                function checkHeadSearchForm() {
                    if (document.getElementById('hdsearch').value == '') {
                         document.getElementById('hdsearch').focus();
                         return false;
                    }
                    document.headSearchForm.submit();
                }
            </script>
            <form name="headSearchForm" action="<?=MNBVf::requestUrl(Lang::isAltLang()?'altlang':'','/search');?>" class="d-flex ml-auto" method="GET" onsubmit="return checkHeadSearchForm();">
                <input type="search" class="form-control mr-2" name="search" id="hdsearch" placeholder="<?=Lang::get('Search string');?>" onclick="document.getElementById('hdsearch').value='';">
                <button class="btn btn-outline-success bg-transparent text-light mr-2" onclick="checkHeadSearchForm();"><?=Lang::get('Find');?></button>
            </form>
        </div>       
    </nav>

    <main>
        
    <div class="container">
        <div class="row">   
            <!-- Карусель -->         
            <div id="carouselCaptions" class="carousel slide" data-ride="carousel">    
<? 
/*
//Виджет акций
//echo '<b>'.Lang::get('Special offers').':</b><br>';
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'actions',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/actions',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 5,//количество выводимых элементов
    'list_sort' => 'pozid', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'objects', //('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/actions',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Actions'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
),
'wdg_actionslist.php');
*/

//Виджет брендзон
//echo '<b>'.Lang::get('Special offers').':</b><br>';
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'vendors',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/bz',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 5,//количество выводимых элементов
    'list_sort' => 'pozid', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'all', //('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/bz',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Brands'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    'ban_img_id' => 5, //Номер изображения баннера
),
'wdg_actionslist.php');

?>
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

<? //Виджет товаров
//echo '<b>'.Lang::get('Special offers').':</b><br>';
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'products',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/catalog',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 4,//количество выводимых элементов
    'list_sort' => 'pozid', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'all',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/catalog',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('Products catalog'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    'obj_prop_conf' => array( //Массив конфигурации вывода параметров объекта. По-умолчанию строка 'no_conf' - параметры не выводятся
        "price" => array("name"=>"price", "type"=>"text", "active" => "print")
    )
),
'wdg_prodlist.php');
?>
<div class="w-100 mt-3 pl-1"><a href="<?=(Lang::isAltLang()?('/'.Lang::getAltLangName()):'');?>/news" class="h5 text-dark font-weight-bold text-decoration-none"><?=Lang::get('News');?></a></div>
<? //Виджет новостей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'news',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 1,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/news',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 3,//количество выводимых элементов
    'list_sort' => 'date_desc', //сортировка списка
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/news',//ссылка на полный список объектов, если требуется
    'list_link_name' => Lang::get('News archive'),//анкор ссылки на полный список объектов, если требуется
    'altlang' => Lang::isAltLang(),//вывод на альтернативном языке
    ),
'wdg_newslist.php');
?>
<div class="w-100 mt-3 p-1"><a href="<?=(Lang::isAltLang()?('/'.Lang::getAltLangName()):'');?>/articles" class="h5 text-dark font-weight-bold text-decoration-none"><?=Lang::get('Articles');?></a></div>
<? //Виджет статей
MNBVf::startVidget('pglist',$item,array(
    'storage' => 'articles',//хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
    'folderid' => 0,//папка из которой будут выбираться объекты. Если не задано, то 1
    'list_main_alias' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/articles',//основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
    'folder_start_id' => 1,//идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
    'list_max_items' => 2,//количество выводимых элементов
    'list_sort' => 'date_desc', //сортировка списка
    'only_first' =>true, //выводить только объекты, выделенные свойством First (Гл)
    'filter_type' => 'objects',//('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
    'list_link' => (Lang::isAltLang()?('/'.Lang::getAltLangName()):'').'/articles',//ссылка на полный список объектов, если требуется
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
                    <b><?=Lang::get('Company');?>:</b><br>
<?=MNBVf::startVidget('menu',$item,3,'wdg_footermenu.php');?>
                </div>
                <div class="pt-3 col-md-3 col-sm-6 col-xs-12">
                    <b><?=Lang::get('Content');?>:</b><br>
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
                    [PgGen <?=sprintf ("%01.4f",(SysBF::getmicrotime() - Glob::$vars['time_start']));?>s][MaxMem <?=intval(memory_get_peak_usage()/1024).'kB';?>]
                </div>
            </div>
        </div>
    </footer>

    
    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    
    <? /*
     * <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
     * <!-- Вариант 2: Bootstrap JS отдельно от Popper
     * <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
     * <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
     * 
     * Альфа 5 хз, может она и старее прошлого варианта
     * <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     * <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script> 
     *
     * И еще вариант 3я альфа 
     * <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    -->*/?>
    
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

<script>
function getCartQty(){
    $.ajax({
        url: "/cart?onlyqty=true",
        cache: false,
        success: function(html){
            $("#carticoqty").text(html);
        }
    });
}

let bbcOk = new Array();
function addToCart(prodid){
    if (typeof bbcOk["bbc"+prodid] === "undefined"){
        $.ajax({
            url: '/cart?act=add&prodid='+prodid+'&tpl_mode=json',
            cache: false,
            success: function(html){
                getCartQty();
            }
        });
    
        $("#bbc"+prodid).removeClass("btn-primary");
        $("#bbc"+prodid).addClass("btn-outline-success");
        document.getElementById("bbc"+prodid).innerText="Перейти в корзину";
        bbcOk["bbc"+prodid] = true;
    }else{
        document.location.href = "/cart";
    }
}

getCartQty();
</script>
