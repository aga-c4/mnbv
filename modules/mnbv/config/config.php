<?php
################################################################################
# Основные системные переменные
################################################################################
Glob::$vars['def_lang'] = 'ru'; //Язык системы по-умолчанию (в т.ч. базовый язык БД).
Glob::$vars['lang'] = 'ru'; //Язык интерфейса по-умолчанию (на каком языке в настоящий момент отображается интерфейс)
Glob::$vars['mnbv_altlang_name'] = 'en'; //Системный алиас альтернативного языка
Glob::$vars['mnbv_altlang'] = false; //Маркер отображение элементов списка на альтернативном языке
Glob::$vars['mnbv_altlang_vis'] = true; //Маркер необходимости вывода переключателя языков в списке
Glob::$vars['back_url_max_num'] = 15; //Количество хранимых обратных URL
Glob::$vars['list_max_items'] = 21; //Количество объектов на 1 странице в списке
Glob::$vars['txt_max_size'] = 10000; //Максимальная длина текста, вводимого пользователем
Glob::$vars['sysusers_storage'] = 'sysusers'; //Хранилище пользователей
Glob::$vars['users_storage'] = 'users'; //Хранилище пользователей
Glob::$vars['site_allow_ip'] = null; //ip с которых возможен доступ к сайтам - массив шаблонов, (если null задан, то доступно всем)
Glob::$vars['admin_allow_ip'] = null; //ip с которых возможен доступ к панели менеджера - массив шаблонов, (если null задан, то доступно всем)
Glob::$vars['file_edit_allow_ip'] = null; //ip с которых возможен доступ к файл менеджеру - массив шаблонов, (если null задан, то доступно всем)
Glob::$vars['cart_url'] = '/cart'; //Базовый URL корзины для добавления товаров, он будет модифицирован с учетом домена, протокола и пр.
Glob::$vars['def_text_editor'] = ''; //('', 'tmce' или 'xinha') Для подключения tmce - скачайте радактор с официального сайта https://www.tinymce.com/ 
                                     // и разместите в папке /www/src/mnbv/tmce . Он не включен в сборку, т.к. его лицензия не позволяет использование 
                                     // в продуктах под BSD лицензией. В связи с этим в ближайшее время будет интегрирован xinha
Glob::$vars['robotsStorage'] = 'robots'; //Хранилище типов роботов
Glob::$vars['robotsRunStorage'] = 'robotsrun'; //Хранилище заданий роботов

##############################################################################
# Доступные модули системы и их алиасы (ключи - используются при вызове модуля)
##############################################################################
Glob::$vars['module_alias'] = array( //Базовые модули в папке modules
    'core' => 'core', //Ядро системы
    'default' => 'default', //Пустой модуль, для демонстрации
    'mnbv' => 'mnbv', //Корневой модуль CMS MNBV
    'mnbvapi' => 'mnbvapi', //Модуль API MNBV
    'mnbvsite' => 'mnbvsite', //Модуль дефолтового сайта
    'intranet' => 'intranet', //Модуль интерфейса администратора
    'sdata' => 'sdata', //Модуль выдачи закрытого контента из папки /sdata/
    'imgeditor' => 'imgeditor', //Модуль редактора изображений
);
Glob::$vars['app_module_alias'] = array( //Пользовательские модули в папке app имеют приоритет перез базовыми, при этом в модуле могут быть лишь измененные файлы по отношению к такому же базовому
    //По аналогии с module_alias
);

################################################################################
# Параметры дефолтового запуска системы
################################################################################
Glob::$vars['mnbv_def_module'] = 'mnbvsite'; //Модуль MNBV по-умолчанию
Glob::$vars['mnbv_def_controller'] = 'mnbvsite'; //Контроллер MNBV по-умолчанию
Glob::$vars['mnbv_def_action'] = 'index'; //Действие MNBV по-умолчанию
Glob::$vars['mnbv_uri'] = (!empty($_SERVER["REQUEST_URI"]))?$_SERVER["REQUEST_URI"]:'';
Glob::$vars['mnbv_query_string'] = (!empty($_SERVER["QUERY_STRING"]))?$_SERVER['QUERY_STRING']:'';

##############################################################################
# Переменные работы с Базами и хранилищами данных
##############################################################################
//Установка доступов к БД
SysStorage::setDb('mysql1',array(
    'host' => '127.0.0.1',
    'database' => 'mnbv8',
    'user' => 'root',
    //'password' => ''
));
Glob::$vars['mysql_script'] = "z:/usr/local/mysql-5.1/bin/mysql.exe"; //Для отладки в Денвере


##############################################################################
# Стандартные размеры изображений
##############################################################################
//Универсальные. Можно будет отдельно в хранилище настраивать дополнительные и из хранилища наращивать данный массив на старте модуля
Glob::$vars['img_max_size'] = array(
"default" => array(//Дефолтовые настройки 0 в одном из измерений - не закачивать или не создавать изображение
    'dnloadto' => 'object',         //Куда закачивать файл Варианты object - в заданный объект / tmp - в tmp папку + запись в сессию названия файла (производное от сессии) с типом
    'img_type' => 'jpg',            //Тип изображение по-умолчанию
    'img_max_w' => 600,             //Максимальная ширина базового изображения
    'img_max_h' => 600,             //Максимальная высота базового изображения
    'img_quality' => 100,           //Процент сжатия изображений
    'img_update' => 'none',         //Тим изменения для всех видов изображений по-умолчанию none. Варианты:
                                    // "none" - пропорционально сжать,
                                    // "crop-top" - пропорционально по мин измерению и от верха обрезать лишнее,
                                    // "crop-center" - пропорционально по мин измерению и от центра обрезать лишнее.
    'img_min_max_w' => 100,         //Максимальная ширина минииконки
    'img_min_max_h' => 100,         //Максимальная высота минииконки
    'img_min_quality' => 100,       //Процент сжатия изображений
    'img_big_max_w' => 1920,        //Максимальная ширина большого изображения
    'img_big_max_h' => 1024,        //Максимальная высота большого изображения
    'img_big_quality' => 100,       //Процент сжатия изображений
    'form_img_num' => 5,            //Количество изображений в панели редактирования
    'form_att_num' => 5,            //Количество приложенных файлов в панели редактирования

    'text' => false,                //Выводить поле редактирования Text для описания картинки (надо наприме в некоторых баннерах)
),

"products" => array(//Для товаров
    'img_min_max_w' => 40,     //Максимальная ширина минииконки
    'img_min_max_h' => 30,     //Максимальная высота минииконки
    'form_img_num' => 5,            //Количество изображений в панели редактирования
    'form_att_num' => 3,            //Количество приложенных файлов в панели редактирования
),
    
"banners_1288x300" => array(//Горизонтальный большой баннер главной страницы
    'img_max_w' => 1288,             //Максимальная ширина базового изображения
    'img_max_h' => 300,             //Максимальная высота базового изображения
    'img_update' => 'crop-center',  //Тим изменения - обрезать от центра
    'img_min_max_w' => 0,           //Максимальная ширина минииконки
    'img_big_max_w' => 0,           //Максимальная ширина большого изображения
    'form_img_num' => 7,            //Количество изображений в панели редактирования
    'form_att_num' => 0,            //Количество приложенных файлов в панели редактирования
    'text' => true,                //Выводить поле редактирования Text для описания картинки (надо наприме в некоторых баннерах)
),

/*
"banners_972x200" => array(//Горизонтальный большой баннер главной страницы
    'img_max_w' => 972,             //Максимальная ширина базового изображения
    'img_max_h' => 200,             //Максимальная высота базового изображения
    'img_update' => 'crop-center',  //Тим изменения - обрезать от центра
    'img_min_max_w' => 0,           //Максимальная ширина минииконки
    'img_big_max_w' => 0,           //Максимальная ширина большого изображения
    'form_img_num' => 7,            //Количество изображений в панели редактирования
    'form_att_num' => 0,            //Количество приложенных файлов в панели редактирования
    'text' => true,                //Выводить поле редактирования Text для описания картинки (надо наприме в некоторых баннерах)
),
 */

"banners_728x90" => array(//Горизонтальный баннер основной
    'img_max_w' => 728,             //Максимальная ширина базового изображения
    'img_max_h' => 90,              //Максимальная высота базового изображения
    'img_update' => 'crop-center', //Тим изменения - обрезать от центра
    'img_min_max_w' => 0,           //Максимальная ширина минииконки
    'img_big_max_w' => 0,           //Максимальная ширина большого изображения
    'form_img_num' => 7,            //Количество изображений в панели редактирования
    'form_att_num' => 0,            //Количество приложенных файлов в панели редактирования
    'text' => true,                //Выводить поле редактирования Text для описания картинки (надо наприме в некоторых баннерах)
),

"photo_editor" => array(//Загрузка для фоторедактора
    'dnloadto' => 'tmp',            //Куда закачивать файл
    'img_max_w' => 1920,            //Максимальная ширина базового изображения
    'img_max_h' => 1024,            //Максимальная высота базового изображения
    'img_update' => 'none',         //Тим изменения для всех видов изображений по-умолчанию none. Варианты:
)
);

//Типы файлов (расширения), принимаемых системой для загрузки в объекты
Glob::$vars['file_types'] = array(
    //Если ничего не нашли, то отдадим этот
    "default" => array("logo"=>"filetypes/logo-txt.jpg","logo_min"=>"filetypes/logo-txt-min.jpg","logo_big"=>"filetypes/logo-txt-big.jpg","type"=>"att"),

    //Изображения (возможна модификация)
    "jpg" => array("logo"=>"","logo_min"=>"","logo_big"=>"","type"=>"img"),
    "jpeg" => array("logo"=>"","logo_min"=>"","logo_big"=>"","type"=>"img"),
    "png" => array("logo"=>"","logo_min"=>"","logo_big"=>"","type"=>"img"),
    "gif" => array("logo"=>"","logo_min"=>"","logo_big"=>"","type"=>"img"),
    "bmp" => array("logo"=>"","logo_min"=>"","logo_big"=>"","type"=>"img"),

    //Остальные файлы - только закачка/удаление
    "swf" => array("logo"=>"","filetypes/logo_min"=>"","filetypes/logo_big"=>"","type"=>"flash"),
    "txt" => array("logo"=>"filetypes/logo-txt.jpg","logo_min"=>"filetypes/logo-txt-min.jpg","logo_big"=>"filetypes/logo-txt-big.jpg","type"=>"att"),
    "rtf" => array("logo"=>"filetypes/logo-doc.gif","logo_min"=>"filetypes/logo-doc-min.gif","logo_big"=>"filetypes/logo-doc-big.gif","type"=>"att"),
    "doc" => array("logo"=>"filetypes/logo-doc.gif","logo_min"=>"filetypes/logo-doc-min.gif","logo_big"=>"filetypes/logo-doc-big.gif","type"=>"att"),
    "docx" => array("logo"=>"filetypes/logo-doc.gif","logo_min"=>"filetypes/logo-doc-min.gif","logo_big"=>"filetypes/logo-doc-big.gif","type"=>"att"),
    "xls" => array("logo"=>"filetypes/logo-xls.gif","logo_min"=>"filetypes/logo-xls-min.gif","logo_big"=>"filetypes/logo-xls-big.gif","type"=>"att"),
    "xlsx" => array("logo"=>"filetypes/logo-xls.gif","logo_min"=>"filetypes/logo-xls-min.gif","logo_big"=>"filetypes/logo-xls-big.gif","type"=>"att"),
    "ppt" => array("logo"=>"filetypes/logo-ppt.jpg","logo_min"=>"filetypes/logo-ppt-min.jpg","logo_big"=>"filetypes/logo-ppt-big.jpg","type"=>"att"),
    "pptx" => array("logo"=>"filetypes/logo-ppt.jpg","logo_min"=>"filetypes/logo-ppt-min.jpg","logo_big"=>"filetypes/logo-ppt-big.jpg","type"=>"att"),
    "pdf" => array("logo"=>"filetypes/logo-pdf.gif","logo_min"=>"filetypes/logo-pdf-min.gif","logo_big"=>"filetypes/logo-pdf-big.gif","type"=>"att"),
    "zip" => array("logo"=>"filetypes/logo-zip.jpg","logo_min"=>"filetypes/logo-zip-min.jpg","logo_big"=>"filetypes/logo-zip-big.jpg","type"=>"att"),
    "rar" => array("logo"=>"filetypes/logo-zip.jpg","logo_min"=>"filetypes/logo-zip-min.jpg","logo_big"=>"filetypes/logo-zip-big.jpg","type"=>"att"),
    "7z" => array("logo"=>"filetypes/logo-zip.jpg","logo_min"=>"filetypes/logo-zip-min.jpg","logo_big"=>"filetypes/logo-zip-big.jpg","type"=>"att"),
    "tif" => array("logo"=>"filetypes/logo-txt.jpg","logo_min"=>"filetypes/logo-txt-min.jpg","logo_big"=>"filetypes/logo-txt-big.jpg","type"=>"att"),
    "tiff" => array("logo"=>"filetypes/logo-txt.jpg","logo_min"=>"filetypes/logo-txt-min.jpg","logo_big"=>"filetypes/logo-txt-big.jpg","type"=>"att"),
);

//Варианты сортировок в рамках системы MNBV. Ключ - алиас сортировки, значение - массив сортировки для формирования запроса
Glob::$vars['sort_types'] = array(
    'default' => array("pozid"=>"inc","name"=>"inc"), //сортировка по позиции объекта, названию
    'id' => array("id"=>"inc"), //сортировка по id объекта
    'id_desc' => array("id"=>"desc"), //сортировка по id объекта по убыванию
    'date' => array("date"=>"inc"), //сортировка по date объекта
    'date_desc' => array("date"=>"desc"), //сортировка по date объекта по убыванию
    'pozid' => array("pozid"=>"inc","name"=>"inc"), //сортировка по позиции объекта, названию
    'visible' => array("visible"=>"inc","id"=>"inc"), //сортировка по видимости, id desc
    'visible_desc' => array("visible"=>"desc","id"=>"desc"), //сортировка по видимости, id desc
    'first' => array("first"=>"inc","id"=>"inc"), //сортировка по маркеру first inc, id inc
    'first_desc' => array("first"=>"desc","id"=>"desc"), //сортировка по маркеру first desc, id desc
    'name' => array("name"=>"inc"), //сортировка по полю name не важно включен альтернативный язык или нет
    'name_desc' => array("name"=>"desc"), //сортировка по полю name не важно включен альтернативный язык или нет
    'namelang' => array("namelang"=>"inc"), //сортировка по полю name не важно включен альтернативный язык или нет
    'namelang_desc' => array("namelang"=>"desc"), //сортировка по полю name не важно включен альтернативный язык или нет

    'price' => array("price"=>"inc"), //сортировка по цене
    'price_desc' => array("price"=>"desc"), //сортировка по цене по убыванию
);

//Создание массива вариантов сортировки для админки.
Glob::$vars['sort_types_st'] = array();
foreach (Glob::$vars['sort_types'] as $key => $value) {
    Glob::$vars['sort_types_st'][$key] = $key;
}

/*Дефолтовые типы объектов для формирования ЧПУ (URL).
* @var string Дефолтовые типы объектов для формирования ЧПУ (URL) импортируется из Glob::$vars['url_types'] обычно.
* ключ - название хранилища, либо может быть иной. Схема с названием хранилища удобна, т.к. позволяет автоматизировать передачу данных
* mod_pref алиас контроллера
* cat_alias_view определяет наличие алиасов в URL ОБЪЕКТА, в категории он будет в любом случае
* item_pref префикс объекта
* alias_delim - отделяет идентификатор объекта от алиаса объекта
* alias_view - необходимость вывода алиаса объекта
* item_postf - то, что идет после алиаса для всех объектов (к примеру закрывающий слеш)
 */
Glob::$vars['url_types'] = array(
    "products" => array('id'=>1,'mod_pref'=>'catalog','cat_alias_view'=>true,'item_pref'=>'pr_','alias_delim'=>'-','alias_view'=>true,'item_postf'=>''),  //Параметры товара
    "news" => array('id'=>2,'mod_pref'=>'news','cat_alias_view'=>true,'item_pref'=>'nv_','alias_delim'=>'-','alias_view'=>true,'item_postf'=>''),        //Параметры новости
    "articles" => array('id'=>3,'mod_pref'=>'articles','cat_alias_view'=>true,'item_pref'=>'art_','alias_delim'=>'-','alias_view'=>true,'item_postf'=>''),//Параметры статьи
    "actions" => array('id'=>4,'mod_pref'=>'actions','cat_alias_view'=>true,'item_pref'=>'act_','alias_delim'=>'-','alias_view'=>true,'item_postf'=>''), //Параметры отзывов
);

/**
 * Шаблон автогенерации названия товара
 * Автозамены:
 * {{prefix}} - Префикс
 * {{vendor}} - Вендор
 * {{vendor}} - Модель
 * {{partnumber}} - Артикул
 */
Glob::$vars['prod_name_tpl'] = '{{prefix}} {{vendor}} {{vendor}}';

Glob::$vars['prod_storage'] = 'products'; //Хранилище списка товаров
Glob::$vars['prod_storage_rootid'] = 1; //Корневая папка каталога товаров
Glob::$vars['prod_country_storage'] = 'countries'; //Хранилище списка стран
Glob::$vars['prod_country_folderid'] = 1; //Идентификатор папки со странами в хранилище
Glob::$vars['prod_filters_cache_ttl'] = 5*60; //Время жизни кеша фильтра в каталоге товара
Glob::$vars['gormenu_cache_ttl'] = 5*60; //Время жизни кеша фильтра в каталоге товара
