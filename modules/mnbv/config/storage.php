<?php
##############################################################################
# Переменные работы с Базами и хранилищами данных
##############################################################################

/**
 * Определение базовых структур данных (можно определять непосредственно в хранилищах)
 * Для определения хранилищ используются следующие ключи:
 * "type" => (строка) (int|decimal|float|string|text|datetime|array|vars) - тип поля хранилища, смотри возможные в SysStorage::$storageTypes[]
 * "size" => (число) - длина поля хранилища
 * "dbtype" => (строка) (int|bigint|decimal|varchar|text|longtext|timestamp|datetime|date|) - тип поля в БД
 * "creatval" => значение при создании, если "creatval"=>null, то допустимо нулевое значение это дефолтовые значения при создании объекта
 * "autoinc" => (true|false) - автоинкремент при добавлении,
 * "checktype" => (строка) (int|url|...) - тип фильтрации входных данных - входной параметр к методу проверки входных данных
 * "list" => (array) - массив элементов вложенной структуры по аналогии с корневым массивом подобных элементов
 * "view" => (array) - массив параметров, регулирующих формат вывода/редактирования
 * "index" => (число) - использовать в индексе для фильтрации 1 - использовать, 0 - не использовать (по-умолчанию)
 * "linkstorage" => (строка) - алиас хранилища для организации связей, "this" - текущее хранилище, если это массив, то типа ("ключ"=>"значение") из которого выбираются варианты значения поля
 */
$storageDefStruArr = array(
    "id" => array("type"=>"int", "size"=>11, "creatval"=>0, "autoinc"=>true, "dbtype"=>"int"), // идентификатор объекта
    "datestr" => array("type"=>"string", "size"=>19, "creatval"=>"0000-00-00 00:00:00", "dbtype"=>"varchar"), // Дата-время объекта в строковой форме
    "parentid" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"this"), // id вышестоящего раздела (категории)
    "pozid" => array("type"=>"int", "size"=>11, "creatval"=>100, "dbtype"=>"int"), // позиция
    "type" => array("type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>SysStorage::$storageTypesOfObjects), // тип
    "typeval" => array("type"=>"string", "size"=>255, "creatval"=>0, "dbtype"=>"varchar"), // значение URL или другого объекта для этих типов "type"
    "visible" => array("type"=>"int", "size"=>1, "creatval"=>1, "dbtype"=>"int"), // (0-не видим,1-видим) Возможно будут и иные варианты (модерация и т.п.)
    "access" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"usersgr"), // id группы доступа на чтение
    "access2" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"usersgr"), // id группы доступа на редактирование
    "first" => array("type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"), // маркер универсальный
    "name" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Название объекта
    "namelang" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Название на альтернативном язвке
    "comm" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Краткий комментарий
    "alias" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Алиас объекта
    "tags" => array("type"=>"tags", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Тэги объекта
    "about" => array("type"=>"text", "creatval"=>"", "dbtype"=>"text"), // Краткое описание
    "aboutlang" => array("type"=>"text", "creatval"=>"", "dbtype"=>"text"), // Краткое описание на альтернативном языке
    "text" => array("type"=>"text", "creatval"=>"", "dbtype"=>"text"), // Текст
    "textlang" => array("type"=>"text", "creatval"=>"", "dbtype"=>"text"), // Текст на альтернативном языке
    "date" => array("type"=>"datetime", "size"=>10, "creatval"=>"0", "dbtype"=>"int"), // UNIX Дата-время объекта
    "date1" => array("type"=>"datetime", "size"=>10, "creatval"=>"0", "dbtype"=>"int"), // UNIX Дата-время начала отображения (объекта)
    "date2" => array("type"=>"datetime", "size"=>10, "creatval"=>"0", "dbtype"=>"int"), // UNIX Дата-время окончания отображения (иногда удаления объекта)
    "createuser" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int"), // id пользователя создателя
    "createdate" => array("type"=>"datetime", "size"=>10, "creatval"=>"0", "dbtype"=>"int"), // UNIX Дата-время создания (объекта)
    "edituser" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int"), // id пользователя редактора
    "editdate" => array("type"=>"datetime", "size"=>10, "creatval"=>"0", "dbtype"=>"int"), // UNIX Дата-время редактирования (объекта)
    "editip" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // IP адрес редактирования (объекта)
    "author" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Имя автора строкой
    "vars" => array("type"=>"array", "dbtype"=>"text", "list"=>array( //Массив свойств объекта, по которым невозможна выборка (перечислены предустановленные)
        "title" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // метатег title
        "keywords" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // метатег keywords
        "description" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // метатег description
        "tpl_file" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Файл внешнего шаблона,
        "tpl2_file" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Файл внешнего шаблона дополнительный,
        "script" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // запускаемый скрипт,
        "script_tpl_file" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Первый шаблон запускаемого скрипта (обычно вывод списка или единственный шаблон)
        "script_tpl2_file" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), // Второй шаблон запускаемого скрипта (обычно вывод объекта)
        "script_storage" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"), //Хранилище данных скрипта
        "script_folder" => array("type"=>"int", "size"=>11, "creatval"=>"0", "dbtype"=>"int"), // Стартовая папка скрипта
        "scriptvalign" => array("type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>array("1" =>"Down", "2"=>"Top")), // Если 1, то выполнение до текста
        "scriptvars" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"text"), // код инициализации скрипта - запускается перед выполнением скрипта нужен для конфигурирования скрипта по месту.
        "list_sort" => array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar", "linkstorage"=>Glob::$vars['sort_types_st']), // Дефолтовая сортировка списка в рамках данного раздела,
        "list_max_items" => array("type"=>"int", "size"=>11, "creatval"=>"0", "dbtype"=>"int"), // Стартовая папка скрипта
    )),
    "attrup" => array("type"=>"array", "dbtype"=>"text"), //Конфиг наследуемых атрибутов вышестоящих папок
    "attr" => array("type"=>"array", "dbtype"=>"text", "list"=>array(//Конфиг атрибутов для папки
        "objid" => array("type"=>"int", "size"=>11, "name"=>"objId", "creatval"=>"0", "dbtype"=>"int"), // Идентификатор объекта к которому привязан атрибут
        "attrid" => array("type"=>"int", "size"=>11, "name"=>"attrid", "creatval"=>"0", "dbtype"=>"int","linkstorage"=>"attributes"), // Идентификатор атрибута
        "pozid" => array("type"=>"int", "size"=>11, "name"=>"pozid", "creatval"=>"0", "dbtype"=>"int"), // Позиция вывода
        "name" => array("type"=>"string", "size"=>255, "name"=>"name", "creatval"=>"", "dbtype"=>"varchar"), // Название объекта
        "namedlang" => array("type"=>"string", "size"=>255, "name"=>"namedlang", "creatval"=>"", "dbtype"=>"varchar"), // (строка) - Название объекта используется для названия на основном языке (если не задано, используем name)
        "namelang" => array("type"=>"string", "size"=>255, "name"=>"namelang", "creatval"=>"", "dbtype"=>"varchar"), // (строка) - Название объекта используется для альтернативного названия на другом языке.
        "dnuse" => array("type"=>"int", "size"=>1, "name"=>"dnuse", "creatval"=>0, "dbtype"=>"int", "linkstorage" => array("0" =>"No", "1"=>"Yes")), // Наследовать в нижестоящих разделах
        "inlist" => array("type"=>"int", "size"=>1, "name"=>"inlist", "creatval"=>0, "dbtype"=>"int", "linkstorage" => array("0" =>"No", "1"=>"Yes")), // Отображать в списках
        "inshort" => array("type"=>"int", "size"=>1, "name"=>"inshort", "creatval"=>0, "dbtype"=>"int", "linkstorage" => array("0" =>"No", "1"=>"Yes")), // Отображать в кратком наборе свойств
        "index" => array("type"=>"int", "size"=>1, "name"=>"index", "creatval"=>0, "dbtype"=>"int", "linkstorage" => array("0" =>"No", "1"=>"Yes")), // Отображать в фильтрах
        "delitem" => array("type"=>"int", "size"=>1, "name"=>"delitem", "creatval"=>0, "dbtype"=>"int"), // Наследовать в нижестоящих разделах
    )),
    "attrvals"  => array("type"=>"array", "dbtype"=>"text"), //Значения атрибутов для папки
    "upfolders" => array("type"=>"array", "dbtype"=>"text"), //Для категории - список вышестоящих категорий сначала - корневые. (сделать обработку массовой перегенерации данного поля в хранилище)
    "files"  => array("type"=>"array", "dbtype"=>"text"),   //Приложенные файлы
    "siteid" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"sites"), // id вышестоящего раздела (категории)
);

/**
 * Массив дефолтового отображения объекта в т.ч. в режиме редактирования
 * Значения полей массива элементов отображения
 * 1й уровень - названия вкладок первая вкладка отображается по-умолчанию
 * 2й уровень - элементы хранилища во вкладке
 * "name"=>
 * 
 * "active" => (строка) - вариант отображения (update - можно редактировать (по-умолчанию), noupdate - нельзя редактировать, print - просто вывод данных)
 * "table" => (строка) - тип поля таблицы (th,td,thline,tdline) Последние 2 варианта - когда все в 1 ячейку укладывается
 * "type" => (строка) - формат редактирования поля text, password, passwdscr, textarea, select, radio, checkBox, list, frlist (выбор элемента из привязанного списка),
 *                      datetime, date, value (вывод значений), var_dump (вывод вардампа значений), hidden, lineblock, submitstr, null - не выводить ничего,
 *                      attrconf - конфиг атрибутов, attrvalsmini - сокращенный вывод атрибутов, attrvals - вывод атрибутов
 * "typeval" => (строка) - при необходимости название поля значения для данного элемента (URL, другой объект...)
 * "size" => (число) - максимальный размер значения
 * "rows" =>  (число) - количество строк в многострочных полях
 * "linkstorage" => (строка) - алиас хранилища для организации связей, "this" - текущее хранилище, если это массив, то типа ("ключ"=>"значение") из которого выбираются варианты значения поля. Если не задано, то используется "linkstorage" из структуры хранилища
 * "viewindex" => (bool) - если это список, то отображать в нем идентификаторы элементов
 * "notset" => (bool) - если это список, то выводить там значение не установлено =0
 * "delim" => (строка) - разделитель списка в отображении списка чекбоксов
 * "filter_folder" => (число) - ID раздела из которого будут выбираться альтернативы для организации связей, если null, то любой объект из хранилища
 * "filter_type" => (строка) - (objects|folders|all) - типы объектов связей (по-умолчанию objects), если null, то без фильтра
 * "filter_vis" => (bool) - отображать только видимые элементы
 * "submitbt" => (bool) - размещать ли рядом с полем кнопку отправки формы
 * "altlang" => название поля на альтернативном языке, если есть.
 * "checktype" => (строка) - тип фильтрации входных данных для входа SysBF::checkStr()
 * "lang" => (строка) - языковое отображение (all - для всех языков (по-умолчанию), lang - для основного языка, altlang - для дополнительного языка)
 * "width" => (строка) - ширина поля
 * "viewonly" => (строка) - (objects|folders), неотображаемый элемент, определяющий видимость вкладки, если не задан, то отображать всегда
 * "style" => то что должно вывестись в теге style=""
 * "frfile" => если "type" = "textarea" и "active" = "print", то данные могут быть взяты из указанного файла, количество последних строк задается в параметре "rows"
 * Если какое то из значений не задано, то используется дефолтовые значения из массива:
 * SysStorage::$storageTypesView = array("type"=>"text","size"=>255,"filter_folder"=>null,"filter_type"="all");
 */
$storageDefViewArr = array(
    "main" => array(
        //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
        "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
        "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
        "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
        "tags" => array("name"=>"tags", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
        "parentid" => array("name"=>"parentid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"folders", "checktype" => "id"),
        "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
        "attrvals" => array("name"=>"attrvalsmini", "type"=>"attrvalsmini"), //Значения атрибутов для папки укороченный вариант
        "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"tdline", "colspan"=>"", "string"=>""),
        "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>2,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
        "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>4,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "clear3" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"tdline", "string"=>""),
        "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
        "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
        "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
        "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
        "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    )
);

/**
 * Массив дефолтового отображения списка объектов в т.ч. в режиме редактирования
 * Значения полей массива элементов отображения идентичные массиву отображения единичного объекта $storageDefViewArr
 */
$storageDefListArr = array(
    "main" => array(
        //"target" => "_blank",
        "view" => array(
            "parentid" => array("name"=>"parentid", "type"=>"noview"),
            "id" => array("name"=>"id", "type"=>"int","size"=>11,"width"=>"100%","checktype"=>"id"),
            "visible" => array("name"=>"visible", "type"=>"checkbox","table" =>"td","checktype" => "on"),
            "first" => array("name"=>"first", "type"=>"checkbox","table" =>"td","checktype" => "on"),
            "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
            "namelang" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
            "access" => array("name"=>"access", "type"=>"int","size"=>11,"width"=>"100%","checktype"=>"int"),
            "access2" => array("name"=>"access2", "type"=>"int","size"=>11,"width"=>"100%","checktype"=>"int"),
            "delchbox" => array("name"=>"delchbox", "type"=>"delchbox", "table" =>"th"),
            "submitstr" => array("name"=>"submitstr", "type"=>"submitstr"),
        )
    )
);

/**
 * Массив дефолтового отображения фильтра списка объекта
 * Значения полей массива элементов отображения
 * 
 * "autosubmit" - авто переход при изменении
 * "fltr_method" - метод передачи данных фильтра в сессию (get|post) get - по-умолчанию
 * "fltr_redirect" - авторедирект после установки данных фильтра в сессию
 * "view" - описание полей фильтра и их вывода:
 * 1й уровень - названия полей фильтрации
 * 2й уровень - отображение фильтра:
 * "name" название поля,
 * "type" тип фильтра (like,same,more,less,select)
 * "checktype" тип проверки входных данных
 * Если тип select, то у него дополнительные поля:
 * "viewindex" показвать идентификаторы выбора,
 * "notset" показывать "не установлено" с названием поля значение "nofltr",
 * "linkstorage" если задан массив, то он определяет элементы выбора для фильтрации,
 * "filter_type" определяет тип фильтрации элементов выбора (без фильтрации/объект/папка),
 * "filter_folder" определяет папку из которой выводятся элементы фильтра, если не задано, то выводятся элементы из всех папок.
 * "name-def" - жесткое указание имени поля на дефолтовом языке
 * "namelang" - жесткое указание поля на альтернативном языке
 * "print_name" - указание алиаса имени по которому будет найдено имя по словарю
 * Результатом работы фильтра будут параметры GET запроса типа:
 * fltrid = идентификатор виджета фильтра (если есть - он поможет потом разобрать его параметры, если они не стандартные)
 * fl_названиеполя1=значение
 * fl_названиеполя1=less--значение
 * fl_названиеполя1=more--значение
 * fl_названиеполя1=like--значение
 * fl_названиеполя1=in--значение1,значение2,значение3...
 */
$storageDefFilterArr = array(
    "autosubmit" => true,
    "fltr_method" => 'get',
    "view" => array(
        "name" => array("name"=>"name", "type"=>"like", "checktype" => "routeitem"),
        "visible" => array("name"=>"visible", "type"=>"select", "viewindex" =>false, "notset" =>true, "checktype" => "int", "linkstorage"=>array("1" =>"Yes", "0"=>"No")),
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr", "string"=>"Filter"),
));

################################################################################
#  Определим хранилища
################################################################################
SysStorage::clear(); //Очистим структуру

//Корневое хранилище сайта ------------------
SysStorage::$storage['site'] = array( //Корневая таблица сайта
    'group' => 'site', //Группа хранилищ
    'ru_name' => 'Сайт', //Название на русском
    'eng_name' => 'Site', //Название на английском
    'base_storage' => true, //Если существует и true, то это основное хранилище и его объекты непосредственно выводятся, иначе для вывода используются контроллеры
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_site', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 102, // Доступ на редактирование
    //'accessv' => array("view" => 202), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 2), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'files_security' => false, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);

SysStorage::$storage['site']['view']['seo'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
            "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"SEO"),
            "title" => array("name"=>"title", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "keywords" => array("name"=>"keywords", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "description" => array("name"=>"description", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        ),
    ),
);

SysStorage::$storage['site']['view']['text'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>43,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>43,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
);

SysStorage::$storage['site']['view']['script'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
            "tpl_file" => array("name"=>"tpl_file", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "tpl2_file" => array("name"=>"tpl2_file", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "script" => array("name"=>"script", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "script_tpl_file" => array("name"=>"script_tpl_file", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "script_tpl2_file" => array("name"=>"script_tpl2_file", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "script_storage" => array("name"=>"script_storage", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "script_folder" => array("name"=>"script_folder", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "list_max_items" => array("name"=>"list_max_items", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "int"),
            "list_sort" => array("name"=>"list_sort", "type"=>"select", "notset" =>true,"width"=>"100%","checktype" => "routeitem"),
            "scriptvalign" => array("name"=>"scriptvalign", "type"=>"select", "viewindex" =>false, "notset" =>true, "checktype" => "int"),
            "scriptvars" => array("name"=>"scriptvars", "type"=>"textarea","editor"=>false,"rows"=>20,"width"=>"100%","table" =>"thline","checktype" => "text"),
        ),
    ),
);

//------------------------------------------


//Хранилище задач ------------------
SysStorage::$storage['tickets'] = array( //Задачи
    'group' => 'site', //Группа хранилищ
    'ru_name' => 'Задачи', //Название на русском
    'eng_name' => 'Tickets', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_tickets', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 200, // Доступ на редактирование
    //'accessv' => array("view" => 202), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 2), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);

SysStorage::$storage['tickets']['view']['text'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>45,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>45,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
);
//------------------------------------------

//Хранилище базовых типов скидок ------------------
SysStorage::$storage['discounts'] = array( //Корневая таблица сайта
    'group' => 'site', //Группа хранилищ
    'ru_name' => 'Скидки', //Название на русском
    'eng_name' => 'Вiscounts', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_discounts', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 210, // Доступ на редактирование
    //'accessv' => array("view" => 202), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 2), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'files_security' => false, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);

SysStorage::$storage['discounts']['stru']['discpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['discounts']['stru']['discval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");

SysStorage::$storage['discounts']['view']['main'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "discpr" => array("name"=>"discpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "discval" => array("name"=>"discval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
);
//------------------------------------------

//---Хранилище атрибутов--------------------------
SysStorage::$storage['attributes'] = array( //Корневая таблица сайта
    'group' => 'system', //Группа хранилищ
    'ru_name' => 'Атрибуты хранилищ', //Название на русском
    'eng_name' => 'Storages attributes', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_attributes', //Таблица атрибутов
    'access' => 0, // Доступ на чтение
    'access2' => 103, // Доступ на редактирование
    //'accessv' => array("view" => 103), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 103), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
);

SysStorage::$storage['attributes']['stru']['vars']['list'] = array(
    //Из базовых
    "files" => array("type"=>"array"), // [array("id"=>"type",...)] приложенные файлы (изображения, документы и т.п. для возможного вывода их за рамки сервера)

    //Специальные
    "dbtype" => array("name"=>"dbtype", "type"=>"string", "size"=>20, "creatval"=>"string", "dbtype"=>"varchar", "linkstorage" => array("int"=>"int", "decimal" =>"decimal", "string"=>"string", "text"=>"text","datetime"=>"datetime")),
    "active" => array("name"=>"active", "type"=>"string", "size"=>20, "creatval"=>"update", "dbtype"=>"varchar", "linkstorage" => array("update" =>"update", "noupdate"=>"noupdate", "print"=>"print")),
    "table" => array("name"=>"table", "type"=>"string", "size"=>20, "creatval"=>"td", "dbtype"=>"varchar", "linkstorage" => array("td"=>"td", "th" =>"th", "tdline"=>"tdline", "thline"=>"thline")),
    "type" => array("name"=>"type", "type"=>"string", "size"=>20, "creatval"=>"text", "dbtype"=>"varchar", "linkstorage" => array("text"=>"text", "textarea" =>"textarea", "select"=>"select", "radio"=>"radio","checkBox"=>"checkBox","list"=>"list","frlist"=>"frlist","datetime"=>"datetime","date"=>"date","value"=>"value","var_dump"=>"var_dump","hidden"=>"hidden","lineblock"=>"lineblock","submitstr"=>"submitstr","null"=>"null")),
    "size" => array("name"=>"size", "type"=>"int", "size"=>5, "creatval"=>255, "dbtype"=>"int"),
    "rows" => array("name"=>"rows", "type"=>"int", "size"=>5, "creatval"=>1, "dbtype"=>"int"),
    "width" => array("name"=>"width", "type"=>"string", "size"=>5, "creatval"=>"100%", "dbtype"=>"varchar"),
    "viewindex" => array("name"=>"viewindex", "type"=>"string", "size"=>255, "creatval"=>"0", "dbtype"=>"varchar"),
    "notset" => array("name"=>"notset", "type"=>"string", "size"=>255, "creatval"=>"1", "dbtype"=>"varchar"),
    "delim" => array("name"=>"delim", "type"=>"string", "size"=>255, "creatval"=>" ", "dbtype"=>"varchar"),
    "linkstorage" => array("name"=>"linkstorage", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "filter_folder" => array("name"=>"filter_folder", "type"=>"int", "size"=>5, "creatval"=>0, "dbtype"=>"int"),
    "filter_type" => array("name"=>"filter_type", "type"=>"string", "size"=>20, "creatval"=>"all", "dbtype"=>"varchar", "linkstorage" => array("all"=>"all", "objects" =>"objects", "folders"=>"folders")),
    "filter_vis" => array("name"=>"filter_vis", "type"=>"int", "size"=>1, "creatval"=>1, "dbtype"=>"int"),
    "submitbt" => array("name"=>"submitbt", "type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"),
    "checktype" => array("name"=>"checktype", "type"=>"string", "size"=>20, "creatval"=>"all", "dbtype"=>"varchar", "linkstorage" => array("no"=>"No","int"=>"int","decimal"=>"decimal","datetime"=>"datetime","strictstr"=>"strictstr","string"=>"string","text"=>"text","email"=>"email","on"=>"on","id"=>"id","routeitem"=>"routeitem","url"=>"url")),
    "lang" => array("name"=>"lang", "type"=>"string", "size"=>20, "creatval"=>"all", "dbtype"=>"varchar", "linkstorage" => array("all"=>"all", "lang" =>"lang", "altlang"=>"altlang")),

);

SysStorage::$storage['attributes']['view']['fields'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"), //Альтернативный язык
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table"=>"thline", "string"=>"Attributes fields"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "dbtype" => array("name"=>"dbtype", "type"=>"select",  "checktype" => "id"),
        "active" => array("name"=>"active", "type"=>"select", "table" =>"td", "checktype" => "id"),
        "table" => array("name"=>"table", "type"=>"select",  "checktype" => "id"),
        "type" => array("name"=>"type", "type"=>"select",  "checktype" => "id"),
        "size" => array("name"=>"size", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "rows" => array("name"=>"rows", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "id"),
        "width" => array("name"=>"width", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "viewindex" => array("name"=>"viewindex", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
        "notset" => array("name"=>"notset", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
        "delim" => array("name"=>"delim", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "linkstorage" => array("name"=>"linkstorage", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "filter_folder" => array("name"=>"filter_folder", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "id"),
        "filter_type" => array("name"=>"filter_type", "type"=>"select",  "checktype" => "id"),
        "filter_vis" => array("name"=>"filter_vis", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
        "submitbt" => array("name"=>"submitbt", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
        "checktype" => array("name"=>"checktype", "type"=>"select",  "checktype" => "id"),
        "lang" => array("name"=>"lang", "type"=>"select",  "checktype" => "id"),
    ),
    ),
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
);
//------------------------------------------------

//Хранилище новостей  -------------  
SysStorage::$storage['news'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Новости', //Название на русском
    'eng_name' => 'News', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_news', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 205, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => false, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'custom_url' => true, //Если true, то на базе алиасов будут добавляться данные в хранилище для разбора URL
);
//------------------------------------------ 

//Хранилище статей  -------------  
SysStorage::$storage['articles'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Статьи', //Название на русском
    'eng_name' => 'Articles', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_articles', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 206, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => false, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'custom_url' => true, //Если true, то на базе алиасов будут добавляться данные в хранилище для разбора URL
);

SysStorage::$storage['articles']['view']['text'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>43,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>43,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
);

SysStorage::$storage['articles']['view']['params'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
            "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
            "list_sort" => array("name"=>"list_sort", "type"=>"select", "notset" =>true,"width"=>"100%","checktype" => "routeitem"),
            "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"thline", "string"=>"SEO"),
            "title" => array("name"=>"title", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "keywords" => array("name"=>"keywords", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "description" => array("name"=>"description", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        ),
    ),
);

//------------------------------------------ 

//Хранилище Производителей  -------------  
SysStorage::$storage['vendors'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Производители', //Название на русском
    'eng_name' => 'Vendors', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_vendors', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 210, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);

//Лимиты скидок
SysStorage::$storage['vendors']['stru']['discmaxpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['vendors']['stru']['discmaxval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['vendors']['stru']['discminmargpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['vendors']['stru']['discminmargval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");

SysStorage::$storage['vendors']['view']["main"] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "tags" => array("name"=>"tags", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>2,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>4,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear3" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"tdline", "string"=>""),
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear4" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Discount limits"),
    "discmaxpr" => array("name"=>"discmaxpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),     //Максимальное значение скидки, %
    "discmaxval" => array("name"=>"discmaxval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),    //Максимальное значение скидки, вал
    "discminmargpr" => array("name"=>"discminmargpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"), //Минимальное значение маржинальности для применнеия скидки, %
    "discminmargval" => array("name"=>"discminmargval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),//Минимальное значение маржинальности для применнеия скидки, вал
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
    "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
    "parentid" => array("name"=>"parentid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"folders", "checktype" => "id"),
    "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),   
);

//------------------------------------------ 

//Хранилище стран изготовления  -------------  
SysStorage::$storage['countries'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Страны', //Название на русском
    'eng_name' => 'Countries', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_countries', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 210, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);

//Лимиты скидок
SysStorage::$storage['countries']['stru']['discmaxpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['countries']['stru']['discmaxval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['countries']['stru']['discminmargpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['countries']['stru']['discminmargval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");

SysStorage::$storage['countries']['view']["main"] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "tags" => array("name"=>"tags", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>2,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>4,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear3" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"tdline", "string"=>""),
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear4" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Discount limits"),
    "discmaxpr" => array("name"=>"discmaxpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),     //Максимальное значение скидки, %
    "discmaxval" => array("name"=>"discmaxval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),    //Максимальное значение скидки, вал
    "discminmargpr" => array("name"=>"discminmargpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"), //Минимальное значение маржинальности для применнеия скидки, %
    "discminmargval" => array("name"=>"discminmargval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),//Минимальное значение маржинальности для применнеия скидки, вал
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
    "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
    "parentid" => array("name"=>"parentid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"folders", "checktype" => "id"),
    "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),   
);

//------------------------------------------ 

//Хранилище акций ------------------
SysStorage::$storage['actions'] = array( //Корневая таблица сайта
    'group' => 'site', //Группа хранилищ
    'ru_name' => 'Акции', //Название на русском
    'eng_name' => 'Actions', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_actions', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 210, // Доступ на редактирование
    //'accessv' => array("view" => 210), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 210), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'custom_url' => true, //Если true, то на базе алиасов будут добавляться данные в хранилище для разбора URL
);
//JSON массивы, содержащие объекты, на которые распространяется акция
SysStorage::$storage['actions']['stru']['products'] = array("type"=>"text", "creatval"=>"", "dbtype"=>"text"); 
SysStorage::$storage['actions']['stru']['folders'] = array("type"=>"text", "creatval"=>"", "dbtype"=>"text"); 
SysStorage::$storage['actions']['stru']['vendor'] = array("type"=>"text", "creatval"=>"", "dbtype"=>"text"); 
SysStorage::$storage['actions']['stru']['country'] = array("type"=>"text", "creatval"=>"", "dbtype"=>"text"); 
//Скидки
SysStorage::$storage['actions']['stru']['discpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['actions']['stru']['discval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
//Лимиты скидок
SysStorage::$storage['actions']['stru']['discmaxpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['actions']['stru']['discmaxval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['actions']['stru']['discminmargpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['actions']['stru']['discminmargval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");

SysStorage::$storage['actions']['view']['info'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Discount limits"),
    "discpr" => array("name"=>"discpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "discval" => array("name"=>"discval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "discmaxpr" => array("name"=>"discmaxpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),     //Максимальное значение скидки, %
    "discmaxval" => array("name"=>"discmaxval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),    //Максимальное значение скидки, вал
    "discminmargpr" => array("name"=>"discminmargpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"), //Минимальное значение маржинальности для применнеия скидки, %
    "discminmargval" => array("name"=>"discminmargval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),//Минимальное значение маржинальности для применнеия скидки, вал

    "products" => array("name"=>"products", "type"=>"textarea","editor"=>false,"rows"=>15,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
    "folders" => array("name"=>"folders", "type"=>"textarea","editor"=>false,"rows"=>15,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
    "vendor" => array("name"=>"vendor", "type"=>"textarea","editor"=>false,"rows"=>15,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
    "country" => array("name"=>"country", "type"=>"textarea","editor"=>false,"rows"=>15,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
);

//------------------------------------------ 

//Хранилище каталога товаров сайта ------------------
SysStorage::$storage['products'] = array( //Корневая таблица сайта
    'group' => 'site', //Группа хранилищ
    'ru_name' => 'Товары', //Название на русском
    'eng_name' => 'Products', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_products', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 210, // Доступ на редактирование
    //'accessv' => array("view" => 210), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 210), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => true, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'files_security' => false, //будет ли ограничение доступа к приложенным файлам объектов хранилища
    'files_types' => array('img'=>'all','att'=>'all'), //Допустимые для загрузки типы файлов, array('jpg','bmp',...) или 'all' для всех допустимых (можно единый на все, т.е. вообще без массивов). Если поле не указано, то считается all
    'img_max_size' => 'products', //Настройка для закачки изображений по-умолчанию default, если не заданы какие-нибудь элементы, то берутся из defailt
    'custom_url' => true, //Если true, то на базе алиасов будут добавляться данные в хранилище для разбора URL
);
SysStorage::$storage['products']['stru']['vendor'] = array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"vendors");
SysStorage::$storage['products']['stru']['country'] = array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"countries");
//Цена и себестоимость
SysStorage::$storage['products']['stru']['price'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['products']['stru']['oldprice'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['products']['stru']['cost'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
//Лимиты скидок
SysStorage::$storage['products']['stru']['discmaxpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['products']['stru']['discmaxval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['products']['stru']['discminmargpr'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");
SysStorage::$storage['products']['stru']['discminmargval'] = array("type"=>"decimal", "size"=>11, "creatval"=>"0.00", "dbtype"=>"decimal");

SysStorage::$storage['products']['view']["main"] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "tags" => array("name"=>"tags", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Prices"),
    "price" => array("name"=>"price", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "oldprice" => array("name"=>"oldprice", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "cost" => array("name"=>"cost", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "clear2" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "vendor" => array("name"=>"vendor", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    "country" => array("name"=>"country", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    "attrvals" => array("name"=>"attrvalsmini", "type"=>"attrvalsmini"), //Значения атрибутов для папки укороченный вариант
    "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>2,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>4,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear3" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"tdline", "string"=>""),
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear4" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Discount limits"),
    "discmaxpr" => array("name"=>"discmaxpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),     //Максимальное значение скидки, %
    "discmaxval" => array("name"=>"discmaxval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),    //Максимальное значение скидки, вал
    "discminmargpr" => array("name"=>"discminmargpr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"), //Минимальное значение маржинальности для применнеия скидки, %
    "discminmargval" => array("name"=>"discminmargval", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),//Минимальное значение маржинальности для применнеия скидки, вал
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
    "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
    "parentid" => array("name"=>"parentid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"folders", "checktype" => "id"),
    "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),   
);


SysStorage::$storage['products']['view']['seo'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"SEO"),
        "title" => array("name"=>"title", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "keywords" => array("name"=>"keywords", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "description" => array("name"=>"description", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    ),
    ),
);

SysStorage::$storage['products']['view']['attr'] = array(
    "viewonly" => "objects", //Неотображаемый элемент, определяющий видимость вкладки
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Object attributes"),
    "price" => array("name"=>"price", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "oldprice" => array("name"=>"oldprice", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "decimal"),
    "attrvals" => array("name"=>"attrvals", "type"=>"attrvals"),
);

SysStorage::$storage['products']['view']['attrconf'] = array(
    "viewonly" => "folders", //Неотображаемый элемент, определяющий видимость вкладки
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "all"), //Основной язык
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table"=>"thline", "string"=>"Folder object attributes config"),

    "attr" => array("name"=>"attr", "type"=>"attr", "view"=>array(
        "objid" => array("name"=>"objid", "type"=>"text", "active" => "print"), // Идентификатор объекта к которому привязан атрибут
        "attrid" => array("name"=>"attrid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"all", "filter_folder" => 1,  "checktype" => "id"), // Идентификатор атрибута
        "pozid" => array("name"=>"pozid", "type"=>"text", "size"=>11, "checktype" => "int"), // Позиция вывода
        "namedlang" => array("name"=>"namedlang", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"), // (строка) - Название объекта используется на основном языке, если не задано, используем name.
        "namelang" => array("name"=>"namelang", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"), // (строка) - Название объекта используется для альтернативного названия на другом языке.
        "dnuse" => array("name"=>"dnuse", "type"=>"checkbox", "table" =>"td", "checktype" => "on"), // Наследовать в нижестоящих разделах
        "inlist" => array("name"=>"inlist", "type"=>"checkbox", "table" =>"td", "checktype" => "on"), // Отображать в списках
        "inshort" => array("name"=>"inshort", "type"=>"checkbox", "table" =>"td", "checktype" => "on"), // Отображать в кратком наборе свойств
        "index" => array("name"=>"index", "type"=>"checkbox", "table" =>"td", "checktype" => "on"), // Использовать в индексе для фильтрации
        "delitem" => array("name"=>"delitem", "type"=>"checkbox", "table" =>"td", "checktype" => "on"), // Наследовать в нижестоящих разделах
    ),),

    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
);
//------------------------------------------

//Хранилище заказов  -------------  
SysStorage::$storage['orders'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Заказы', //Название на русском
    'eng_name' => 'Orders', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_orders', //Таблица
    'access' => 118, // Доступ на чтение
    'access2' => 118, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => false, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
	'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);
SysStorage::$storage['orders']['stru']['userid'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['orders']['stru']['phone'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 
SysStorage::$storage['orders']['stru']['email'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 
SysStorage::$storage['orders']['stru']['from_fio'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 

//UTM метки
SysStorage::$storage['orders']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['orders']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['orders']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['orders']['stru']['utm_term'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

//Метки партнерок типа адмитада и т.п.
SysStorage::$storage['orders']['stru']['partner_alias'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['orders']['stru']['partner_code'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

//------------------------------------------ 

//Хранилище входящих сообщений  -------------  
SysStorage::$storage['messages'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Сообщения', //Название на русском
    'eng_name' => 'Messages', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_messages', //Таблица
    'access' => 117, // Доступ на чтение
    'access2' => 117, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => false, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
	'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);
SysStorage::$storage['messages']['stru']['userid'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['messages']['stru']['phone'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 
SysStorage::$storage['messages']['stru']['email'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 
SysStorage::$storage['messages']['stru']['from_fio'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 

//UTM метки
SysStorage::$storage['messages']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['messages']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['messages']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['messages']['stru']['utm_term'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

//Метки партнерок типа адмитада и т.п.
SysStorage::$storage['messages']['stru']['partner_alias'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['messages']['stru']['partner_code'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

SysStorage::$storage['messages']['view']['main'] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime", "active" => "print"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text", "active" => "print"), //Основной язык
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters", "active" => "print"),
    "userid" => array("name"=>"userid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text", "active" => "print"), //Основной язык
    "from_fio" => array("name"=>"from_fio", "type"=>"text", "print_name"=>"name","size"=>255,"width"=>"100%","checktype" => "text", "active" => "print"), //Основной язык
    "phone" => array("name"=>"phone", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text", "active" => "print"),
    "email" => array("name"=>"email", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text", "active" => "print"),
    "text" => array("name"=>"text", "type"=>"textarea", "print_name"=>"Message","editor"=>false,"table" =>"tdline","checktype" => "text", "active" => "print"), //Основной язык
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
    "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id","active" => "print"),
);
//------------------------------------------ 

//Хранилище корзин пользователей  -------------  
SysStorage::$storage['carts'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Корзины', //Название на русском
    'eng_name' => 'Carts', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_carts', //Таблица
    'access' => 118, // Доступ на чтение
    'access2' => 118, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => false, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
	'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);
SysStorage::$storage['carts']['stru']['userid'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['carts']['stru']['phone'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 
SysStorage::$storage['carts']['stru']['email'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 
SysStorage::$storage['carts']['stru']['from_fio'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); 

//UTM метки
SysStorage::$storage['carts']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['carts']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['carts']['stru']['utm_source'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['carts']['stru']['utm_term'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

//Метки партнерок типа адмитада и т.п.
SysStorage::$storage['carts']['stru']['partner_alias'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['carts']['stru']['partner_code'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

//------------------------------------------ 

//Таблица групп пользователей  -------------  
SysStorage::$storage['usersgr'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Группы пользователей', //Название на русском
    'eng_name' => 'Users groups', //Название на английском
    'db' => 'array1', //База данных
    'table' => 'mnbv_users_groups', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 2, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);
//------------------------------------------ 

//Таблица пользователей администраторов ----
SysStorage::$storage['sysusers'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Системные Пользователи', //Название на русском
    'eng_name' => 'System Users', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_sysusers', //Таблица
    //'controller' => 'usersobj',//Контроллер для редактирования в модуле Intranet, если не задан, то используется дефолтовый
    'access' => 101, // Доступ на чтение
    'access2' => 110, // Доступ на редактирование
    'accessv' => array("root" => 2), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);

SysStorage::$storage['sysusers']['stru']['phone'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['sysusers']['stru']['email'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['sysusers']['stru']['login'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['sysusers']['stru']['passwd'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

SysStorage::$storage['sysusers']['stru']['vars']['list'] = array(
    //Из базовых
    "files" => array("type"=>"array"), // [array("id"=>"type",...)] приложенные файлы (изображения, документы и т.п. для возможного вывода их за рамки сервера)

    //Специальные
    "fio" => array("name"=>"fio", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "addr" => array("name"=>"addr", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "phone" => array("name"=>"phone", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "position" => array("name"=>"position", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "iflang" => array("name"=>"iflang", "type"=>"string", "size"=>20, "creatval"=>"lang", "dbtype"=>"varchar", "linkstorage" => array("ru" =>"Russian", "eng"=>"English")),
    "permissions" => array("name"=>"permissions", "type"=>"text", "creatval"=>"", "dbtype"=>"varchar", "linkstorage" => "usersgr"),
    "tablerows" => array("name"=>"tablerows", "type"=>"int", "size"=>3, "creatval"=>"21", "dbtype"=>"int"),
    "tplwidth" => array("name"=>"tplwidth", "type"=>"int", "size"=>4, "creatval"=>"", "dbtype"=>"int"),
    "root" => array("name"=>"root", "type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"),
    "viewlogs" => array("name"=>"viewlogs", "type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"),
    "discount" => array("name"=>"discount", "type"=>"text", "creatval"=>"", "dbtype"=>"varchar", "linkstorage" => "discounts"),
);

SysStorage::$storage['sysusers']['view']['main'] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
    "parentid" => array("name"=>"parentid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"folders", "checktype" => "id"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "email" => array("name"=>"email", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "login" => array("name"=>"login", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "login"),
    "passwd" => array("name"=>"passwd", "type"=>"passwdscr","size"=>255,"width"=>"100%","checktype" => "passwd"),
    "phone" => array("name"=>"phone", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
            "fio" => array("name"=>"fio", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "discount" => array("name"=>"discount", "type"=>"select","filter_folder"=>1,"filter_type"=>"objects", "notset" =>true),
            "addr" => array("name"=>"addr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "position" => array("name"=>"position", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "permissions" => array("name"=>"permissions", "type"=>"list","filter_folder"=>1,"filter_type"=>"objects","filter_vis"=>true,"delim"=>"<br>\n"),
            "iflang" => array("name"=>"iflang", "type"=>"select", "viewindex" =>false, "checktype" => "text"),
            "tablerows" => array("name"=>"tablerows", "type"=>"text","size"=>3,"width"=>"100%","checktype" => "int"),
            "tplwidth" => array("name"=>"tplwidth", "type"=>"select","width"=>"100%","checktype" => "int", "linkstorage" => array("1" =>"100%", "980"=>"980px", "1250"=>"1250px")),
        ),
    ),
    "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"tdline", "colspan"=>"", "string"=>""),
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
    "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
);

SysStorage::$storage['sysusers']['view']['root'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Root marker"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "root" => array("name"=>"root", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
        "viewlogs" => array("name"=>"viewlogs", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
    ),
    ),
    //"passwd" => array("name"=>"passwd", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "passwd", "active" => "print"),
);

//------------------------------------------

//Таблица пользователей администраторов ----
SysStorage::$storage['users'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Пользователи', //Название на русском
    'eng_name' => 'User', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_users', //Таблица
    //'controller' => 'usersobj',//Контроллер для редактирования в модуле Intranet, если не задан, то используется дефолтовый
    'access' => 101, // Доступ на чтение
    'access2' => 110, // Доступ на редактирование
    'accessv' => array("root" => 2), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);

SysStorage::$storage['users']['stru']['vars']['list'] = array(
    //Из базовых
    "files" => array("type"=>"array"), // [array("id"=>"type",...)] приложенные файлы (изображения, документы и т.п. для возможного вывода их за рамки сервера)

    //Специальные
    "fio" => array("name"=>"fio", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "addr" => array("name"=>"addr", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "phone" => array("name"=>"phone", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "position" => array("name"=>"position", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "iflang" => array("name"=>"iflang", "type"=>"string", "size"=>20, "creatval"=>"lang", "dbtype"=>"varchar", "linkstorage" => array("ru" =>"Russian", "eng"=>"English")),
    "permissions" => array("name"=>"permissions", "type"=>"text", "creatval"=>"", "dbtype"=>"varchar", "linkstorage" => "usersgr"),
    "tablerows" => array("name"=>"tablerows", "type"=>"int", "size"=>3, "creatval"=>"21", "dbtype"=>"int"),
    "tplwidth" => array("name"=>"tplwidth", "type"=>"int", "size"=>4, "creatval"=>"", "dbtype"=>"int"),
    "viewlogs" => array("name"=>"viewlogs", "type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"),
    "discount" => array("name"=>"discount", "type"=>"text", "creatval"=>"", "dbtype"=>"varchar", "linkstorage" => "discounts"),
);

SysStorage::$storage['users']['stru']['phone'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['users']['stru']['email'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['users']['stru']['login'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['users']['stru']['passwd'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");

SysStorage::$storage['users']['view']['main'] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
    "parentid" => array("name"=>"parentid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"folders", "checktype" => "id"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "email" => array("name"=>"email", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "login" => array("name"=>"login", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "login"),
    "passwd" => array("name"=>"passwd", "type"=>"passwdscr","size"=>255,"width"=>"100%","checktype" => "passwd"),
    "phone" => array("name"=>"phone", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "fio" => array("name"=>"fio", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "discount" => array("name"=>"discount", "type"=>"select","filter_folder"=>1,"filter_type"=>"objects", "notset" =>true),
        "addr" => array("name"=>"addr", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "position" => array("name"=>"position", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "permissions" => array("name"=>"permissions", "type"=>"list","filter_folder"=>1,"filter_type"=>"objects","filter_vis"=>true,"delim"=>"<br>\n"),
        "iflang" => array("name"=>"iflang", "type"=>"select", "viewindex" =>false, "checktype" => "text"),
        "tablerows" => array("name"=>"tablerows", "type"=>"text","size"=>3,"width"=>"100%","checktype" => "int"),
        "tplwidth" => array("name"=>"tplwidth", "type"=>"select","width"=>"100%","checktype" => "int", "linkstorage" => array("1" =>"100%", "980"=>"980px", "1250"=>"1250px")),
    ),
    ),
    "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"tdline", "colspan"=>"", "string"=>""),
    "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
    "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
);

//-------------------------------------------------------------------------------

//Таблица меню --------------------
SysStorage::$storage['menu'] = array(
    'group' => 'site', //Группа хранилищ
    'name' => 'Меню', //Название на русском
    'eng_name' => 'Menu', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_menu', //Таблица
    //'controller' => 'menuobj',//Контроллер для редактирования в модуле Intranet, если не задан, то используется дефолтовый
    'access' => 0, // Доступ на чтение
    'access2' => 104, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);
SysStorage::$storage['menu']['stru']['lang'] = array("name"=>"lang", "type"=>"string", "size"=>20, "creatval"=>"all", "dbtype"=>"varchar", "linkstorage" => array("all"=>"all", "ru" =>"Russian", "eng"=>"English"));
SysStorage::$storage['menu']['stru']['nologin'] = array("name"=>"nologin", "type"=>"int", "size"=>1, "creatval"=>"0", "dbtype"=>"int");

SysStorage::$storage['menu']['stru']['vars']['list'] = array(
    "url" => array("name"=>"url", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "controller" => array("name"=>"controller", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "action" => array("name"=>"action", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "objid" => array("name"=>"objid", "type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int"),
);

SysStorage::$storage['menu']["view"] = array(
    "main" => array(
        "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text"), //Основной язык
        "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text"), //Альтернативный язык
        "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false, "checktype" => "int"),
        "nologin" => array("name"=>"nologin", "type"=>"checkbox", "table" =>"td", "checktype" => "on"), // Отображать только для незарег пользователей
        "lang" => array("name"=>"lang", "type"=>"select", "viewindex" =>false, "checktype" => "text"),
        "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
            "url" => array("name"=>"url", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Active options:"),
            "controller" => array("name"=>"controller", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "action" => array("name"=>"action", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
            "objid" => array("name"=>"objid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "int"),
        )),
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
        "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    )
);
//------------------------------------------

//Таблица тегов  -------------
SysStorage::$storage['tags'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Тэги', //Название на русском
    'eng_name' => 'Tags', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_tags', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 2, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);
SysStorage::$storage['tags']['stru']['storage'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Базовое хранилище сайта
SysStorage::$storage['tags']['stru']['objid'] = array("type"=>"int", "size"=>11, "creatval"=>0, "autoinc"=>true, "dbtype"=>"int"); //Стартовый объект сайта
SysStorage::$storage['tags']['stru']['objtype'] = array("type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>SysStorage::$storageTypesOfObjects); //Стартовый объект сайта

SysStorage::$storage['tags']["view"] = array(
    "main" => array(
        "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
        "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"), //Основной язык
        "objtype" => array("name"=>"objtype", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
        "storage" => array("name"=>"storage", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "strictstr"), //Щаблон сайта
        "objid" => array("name"=>"objid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "int"), //Щаблон сайта
        "text" => array("name"=>"text", "type"=>"textarea","editor"=>false,"rows"=>30,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
        "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
        "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
        "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    )
);

//------------------------------------------

//Таблица сайтов  -------------
SysStorage::$storage['sites'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Сайты', //Название на русском
    'eng_name' => 'Sites', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_sites', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 2, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);
SysStorage::$storage['sites']['stru']['fullurl'] = array("type"=>"int", "size"=>1, "creatval"=>0, "autoinc"=>false, "dbtype"=>"int"); //Если 1, то используется URL с протоколом, доменом и т.п.
SysStorage::$storage['sites']['stru']['protocol'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Протокол по-умолчанию (без домена и протокола|http://|https://||//)
SysStorage::$storage['sites']['stru']['domain'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['sites']['stru']['maindomain'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar");
SysStorage::$storage['sites']['stru']['cookiedomain'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Та строка с доменом, которая будет использована при установки куки
SysStorage::$storage['sites']['stru']['filesdomain'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Базовый URL приложенных файлов и изображений
SysStorage::$storage['sites']['stru']['canonical'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Базовый URL канонической версии
SysStorage::$storage['sites']['stru']['mobile'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Базовый URL мобильной версии
SysStorage::$storage['sites']['stru']['counters_arr'] = array("type"=>"text", "creatval"=>"", "dbtype"=>"text"); //Массив параметров счетчиков и др. подключенных скриптов по-расписанию
SysStorage::$storage['sites']['stru']['template'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Щаблон сайта
SysStorage::$storage['sites']['stru']['storage'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Базовое хранилище сайта
SysStorage::$storage['sites']['stru']['startid'] = array("type"=>"int", "size"=>11, "creatval"=>0, "autoinc"=>false, "dbtype"=>"int"); //Стартовый объект сайта
SysStorage::$storage['sites']['stru']['amp_site'] = array("type"=>"domain", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Базовый URL AMP версии
SysStorage::$storage['sites']['stru']['sorturl'] = array("type"=>"int", "size"=>1, "creatval"=>0, "autoinc"=>false, "dbtype"=>"int"); //Если 1, то сортировка в URL, иначе в параметрах
SysStorage::$storage['sites']['stru']['pginurl'] = array("type"=>"int", "size"=>1, "creatval"=>0, "autoinc"=>false, "dbtype"=>"int"); //Если 1, то страница в URL, иначе в параметрах
SysStorage::$storage['sites']['stru']['noindex'] = array("type"=>"int", "size"=>1, "creatval"=>0, "autoinc"=>false, "dbtype"=>"int"); //Если 1, то запретить индексацию
SysStorage::$storage['sites']['stru']['module'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Имя стартового модуля, если не задано, то запуск из текущего

SysStorage::$storage['sites']["view"] = array(
"main" => array(
        "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
        "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
        "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
        "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
        "fullurl" => array("name"=>"fullurl", "type"=>"checkbox", "checktype" => "on"),
        "protocol" => array("name"=>"protocol", "type"=>"select","notset" =>true,"width"=>"100%","checktype" => "url", "linkstorage" => array("http://" =>"http://", "https://"=>"https://", "//"=>"//")), //Протокол по-умолчанию
        "domain" => array("name"=>"domain", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //домен сайта
        "maindomain" => array("name"=>"maindomain", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //Основное зеркало сайта (если задано, то будет авторедирект на него)
        "cookiedomain" => array("name"=>"cookiedomain", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //Та строка с доменом, которая будет использована при установки куки
        "filesdomain" => array("name"=>"filesdomain", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //Домен статики сайта (картинки, документы...)
        "canonical" => array("name"=>"canonical", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //Базовый URL канонической версии
        "mobile" => array("name"=>"mobile", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //Базовый URL мобильной версии
        "amp_site" => array("name"=>"amp_site", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "url"), //Базовый URL AMP версии
        "template" => array("name"=>"template", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "strictstr"), //Щаблон сайта
        "storage" => array("name"=>"storage", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "strictstr"), //Хранилище сайта
        "startid" => array("name"=>"startid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "int"), //Стартовая страница сайта
        "sorturl" => array("name"=>"sorturl", "type"=>"checkbox", "checktype" => "on"), //Если 1, то сортировка в URL, иначе в параметрах
        "noindex" => array("name"=>"noindex", "type"=>"checkbox", "checktype" => "on"), //Если 1, то страница в URL, иначе в параметрах
        "module" => array("name"=>"module", "type"=>"text","size"=>255,"width"=>"100%", "checktype" => "routeitem"), //Имя стартового модуля, если не задано, то запуск из текущего
    
        "attrvals" => array("name"=>"attrvalsmini", "type"=>"attrvalsmini"), //Значения атрибутов для папки укороченный вариант
        "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"tdline", "colspan"=>"", "string"=>""),
        "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>2,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
        "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>4,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "clear3" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"tdline", "string"=>""),
        "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
        "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
        "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
        "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
        "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    )
);

SysStorage::$storage['sites']['view']['counters_arr'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "counters_arr" => array("name"=>"counters_arr", "type"=>"textarea","editor"=>false,"rows"=>45,"width"=>"100%","table" =>"thline","checktype" => "text"), //Основной язык
);
//------------------------------------------

/*
//Таблица шаблонов  -------------
SysStorage::$storage['templates'] = array(
    'name' => 'Шаблоны', //Название на русском
    'eng_name' => 'Templates', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_templates', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 2, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);

SysStorage::$storage['templates']["view"] = array(
    "main" => array(
        //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
        "date" => array("name"=>"date", "type"=>"datetime","table" =>"thline","checktype" => "datetime"),
        "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
        "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
        "type" => array("name"=>"type", "type"=>"select", "viewindex" =>false,  "delim"=>" | ", "checktype" => "int"),
        "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
        "attrvals" => array("name"=>"attrvalsmini", "type"=>"attrvalsmini"), //Значения атрибутов для папки укороченный вариант
        "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"tdline", "colspan"=>"", "string"=>""),
        "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>2,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
        "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>4,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "clear3" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"tdline", "string"=>""),
        "text" => array("name"=>"text", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"textlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
        "textlang" => array("name"=>"textlang", "type"=>"textarea","editor"=>true,"rows"=>20,"width"=>"100%","langlink"=>"text","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
        "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
        "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
        "siteid" => array("name"=>"siteid", "type"=>"select", "viewindex" =>true, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    )
);
//------------------------------------------
*/


//Типы роботов (собирают статистику, ведут торговлю, и выполняют иные функции) -------------
SysStorage::$storage['robots'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Типы роботов', //Название на русском
    'eng_name' => 'Robots', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_robots', //Таблица
    'access' => 301, // Доступ на чтение
    'access2' => 2, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);

SysStorage::$storage['robots']['stru']['rbtype'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar", "linkstorage"=>array("worker"=>"rb_work", "info" =>"rb_info", "service"=>"rb_service"));

SysStorage::$storage['robots']['stru']['vars']['list'] = array(
    //Специальные
    "script" => array("name"=>"script", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "output" => array("name"=>"output", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "scriptvars" => array("type"=>"scriptvars", "creatval"=>"", "dbtype"=>"text"),
);

SysStorage::$storage['robots']['filter'] = array(
    "autosubmit" => true,
    //"fltr_method" => 'post',
    "view" => array(
        "name" => array("name"=>"name", "type"=>"like", "checktype" => "routeitem"),
        "rbtype" => array("name"=>"rbtype", "type"=>"select", "viewindex" =>false, "notset" =>true, "checktype" => "routeitem", "linkstorage"=>array("worker"=>"rb_work", "info" =>"rb_info", "service"=>"rb_service")),
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr", "string"=>"Filter"),
    ));

SysStorage::$storage['robots']['view']['main'] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "alias" => array("name"=>"alias", "type"=>"text","size"=>255,"width"=>"60%","checktype" => "text"),
    "rbtype" => array("name"=>"rbtype", "type"=>"select", "notset" =>true, "viewindex" =>false,  "delim"=>" | ", "checktype" => "routeitem"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "script" => array("name"=>"script", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "output" => array("name"=>"output", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    ),),
    "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>5,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>5,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "submitstr" => array("name"=>"submitstr", "type"=>"submitstr","table" =>"thline","string"=>"Edit"),
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
);
//------------------------------------------

//Задания на работу роботов с привязкой к бирже и паре или без привязки  -------------
SysStorage::$storage['robotsrun'] = array(
    'group' => 'system', //Группа хранилищ
    'name' => 'Задания роботов', //Название на русском
    'eng_name' => 'Robots run', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_robotsrun', //Таблица
    'access' => 301, // Доступ на чтение
    'access2' => 305, // Доступ на редактирование
    'stru' => $storageDefStruArr, //Структура данного хранилища
    'view' => $storageDefViewArr, //Формат вывода - редактирования
    'list' => $storageDefListArr, //Формат списка
    'filter' => $storageDefFilterArr, //Формат фильтра
    'listnotedit' => false, //Нет возможности редактирования в списке
    'varuse' => true, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
    'files_security' => true, //будет ли ограничение доступа к приложенным файлам объектов хранилища
);
SysStorage::$storage['robotsrun']['stru']['command'] = array("type"=>"string", "size"=>50, "creatval"=>"", "dbtype"=>"varchar"); //Команда роботу
SysStorage::$storage['robotsrun']['stru']['action'] = array("type"=>"string", "size"=>50, "creatval"=>"", "dbtype"=>"text"); //Команда роботу
SysStorage::$storage['robotsrun']['stru']['sid'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Идентификатор сессии робота
SysStorage::$storage['robotsrun']['stru']['pid'] = array("type"=>"int", "size"=>11, "creatval"=>100, "dbtype"=>"int"); // Pid процесса сессии робота
SysStorage::$storage['robotsrun']['stru']['status'] = array("type"=>"string", "size"=>50, "creatval"=>"", "dbtype"=>"varchar"); //Статус выполнения задачи
SysStorage::$storage['robotsrun']['stru']['message'] = array("type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"); //Сообщение при выполнении задачи
SysStorage::$storage['robotsrun']['stru']['robot'] = array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int", "linkstorage"=>"robots"); //Тип робота
SysStorage::$storage['robotsrun']['stru']['cronrun'] = array("type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"); // Необходимость запуска по крону
SysStorage::$storage['robotsrun']['stru']['rbtype'] = array("type"=>"string", "size"=>50, "creatval"=>"", "dbtype"=>"varchar", "linkstorage"=>array("workers"=>"workers", "info" =>"info", "service"=>"service")); //Тип робота

SysStorage::$storage['zbrobotsrun']['stru']['vars']['list'] = array(
    //Специальные
    "always" => array("name"=>"always", "type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"), // Запускать, даже если уже запущено

    "logsize1" => array("name"=>"logsize1", "type"=>"int", "size"=>11, "creatval"=>100, "dbtype"=>"int"),
    "logsize2" => array("name"=>"logsize2", "type"=>"int", "size"=>11, "creatval"=>150, "dbtype"=>"int"),

    "crmin" => array("name"=>"crmin", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "crhour" => array("name"=>"crhour", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "crday" => array("name"=>"crday", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "crmonth" => array("name"=>"crmonth", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "crweek" => array("name"=>"crweek", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),

    "script" => array("name"=>"script", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "output" => array("name"=>"output", "type"=>"string", "size"=>255, "creatval"=>"", "dbtype"=>"varchar"),
    "scriptvars" => array("type"=>"scriptvars", "creatval"=>"", "dbtype"=>"text"),
    
);

SysStorage::$storage['robotsrun']['list'] = array(
    "main" => array(
        //"target" => "_blank",
    )
);

SysStorage::$storage['robotsrun']['filter'] = array(
    "autosubmit" => true,
    //"fltr_method" => 'post',
    "view" => array(
        "name" => array("name"=>"name", "type"=>"like", "checktype" => "routeitem"),
        "rbtype" => array("name"=>"rbtype", "type"=>"select", "viewindex" =>false, "notset" =>true, "checktype" => "routeitem", "linkstorage"=>array("workers"=>"workers", "info" =>"info", "service"=>"service")),
        "status" => array("name"=>"status", "type"=>"select", "viewindex" =>false, "notset" =>true, "checktype" => "routeitem", "linkstorage"=>array("waighting" =>"Waight", "working"=>"Working", "noresponse"=>"No response", "paused"=>"Paused","killed"=>"Killed", "stopped"=>"Stopped", "success"=>"Success", "starterror"=>"Start Error", "error"=>"Error")),
        "submitstr" => array("name"=>"submitstr", "type"=>"submitstr", "string"=>"Filter"),
));

SysStorage::$storage['robotsrun']['view']['main'] = array(
    //"visfirstline" => array("name"=>"visfirstline", "type"=>"visfirstline", "table" =>"thline", "checktype" => "datetime"),
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang","active" => "print"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang","active" => "print"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Status"),
    "command" => array("name"=>"command", "type"=>"select", "viewindex" =>false, "notset" =>true, "linkstorage"=>array("run" =>"Run", "pause"=>"Pause","continue"=>"Continue", "stop"=>"Stop", "kill"=>"Kill"), "checktype" => "routeitem"), // Если 1, то выполнение до текста
    "status" => array("name"=>"status", "type"=>"select", "viewindex" =>false, "notset" =>false, "linkstorage"=>array("waighting" =>"Waight", "working"=>"Working", "noresponse"=>"No response", "paused"=>"Paused","killed"=>"Killed", "stopped"=>"Stopped", "success"=>"Success", "starterror"=>"Start Error", "error"=>"Error"), "checktype" => "routeitem","active" => "print"), // Если 1, то выполнение до текста
    "message" => array("name"=>"message", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"thline", "string"=>"Run parameters"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "script" => array("name"=>"script", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
        "output" => array("name"=>"output", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    ),),
    "sid" => array("name"=>"sid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "pid" => array("name"=>"pid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "clear3" => array("name"=>"clear3", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "robot" => array("name"=>"robot", "type"=>"select", "viewindex" =>false, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id","active" => "print"),
    "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>8,"width"=>"100%","langlink"=>"aboutlang","table" =>"tdline","checktype" => "text","lang" => "lang","active" => "print","pre"=>true), //Основной язык
    "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>8,"width"=>"100%","langlink"=>"about","table" =>"tdline","checktype" => "text","lang" => "altlang","active" => "print","pre"=>true), //Альтернативный язык
    "author" => array("name"=>"author", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "editdate" => array("name"=>"editdate", "type"=>"datetime","size"=>19, "active" => "print"),
);

SysStorage::$storage['robotsrun']['view']['status'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang","active" => "print", "style"=>"font-weight:bold; color:green;"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang","active" => "print"), //Альтернативный язык
    "command" => array("name"=>"command", "type"=>"select", "viewindex" =>false, "notset" =>true, "linkstorage"=>array("run" =>"Run", "pause"=>"Pause","continue"=>"Continue", "stop"=>"Stop", "kill"=>"Kill"), "checktype" => "routeitem"), // Если 1, то выполнение до текста
    "status" => array("name"=>"status", "type"=>"select", "viewindex" =>false, "notset" =>true, "linkstorage"=>array("waighting" =>"Waight", "working"=>"Working", "paused"=>"Paused","stopped"=>"Stopped", "success"=>"Success", "error"=>"Error"), "checktype" => "routeitem","active" => "print"), // Если 1, то выполнение до текста
    "message" => array("name"=>"message", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text","active" => "print"),
    "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"thline", "string"=>"Runing log"),
    "log" => array("name"=>"log", "type"=>"textarea","editor"=>true,"width"=>"100%","rows"=>25,"frfile"=>"data/storage_files/robotsrun/att/p[obj_id]_1.txt","timeout"=>1,"active" => "print","pre"=>true,"table" =>"tdline", "style"=>"background-color:#000; color:#ccc;"), //Основной язык
    //"clear1" => array("name"=>"clear1", "type"=>"refresh","timeout"=>5),
);

SysStorage::$storage['robotsrun']['view']['config'] = array(
    "name" => array("name"=>"name", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"namelang","checktype" => "text","lang" => "lang"), //Основной язык
    "namelang" => array("name"=>"namelang", "type"=>"text","size"=>255,"width"=>"100%","langlink"=>"name","checktype" => "text","lang" => "altlang"), //Альтернативный язык
    "comm" => array("name"=>"comm", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Parameters"),
    "robot" => array("name"=>"robot", "type"=>"select", "viewindex" =>false, "notset" =>true, "filter_type"=>"objects", "filter_folder"=>1, "checktype" => "id"),
    "rbtype" => array("name"=>"rbtype", "type"=>"select", "notset" =>true, "viewindex" =>false,  "delim"=>" | ", "checktype" => "routeitem"),
    "about" => array("name"=>"about", "type"=>"textarea","editor"=>false,"rows"=>8,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text","lang" => "lang"), //Основной язык
    "aboutlang" => array("name"=>"aboutlang", "type"=>"textarea","editor"=>false,"rows"=>8,"width"=>"100%","langlink"=>"about","table" =>"thline","checktype" => "text","lang" => "altlang"),
    "action" => array("name"=>"action", "type"=>"textarea","editor"=>false,"rows"=>5,"width"=>"100%","langlink"=>"aboutlang","table" =>"thline","checktype" => "text"), //Команды на выполнение
    "clear2" => array("name"=>"clear2", "type"=>"lineblock", "table" =>"thline", "string"=>"Run parameters"),
    "cronrun" => array("name"=>"cronrun", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
    "vars" => array("name"=>"vars", "type"=>"vars", "view"=>array(
        "always" => array("name"=>"always", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
        "logsize1" => array("name"=>"logsize1", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "logsize2" => array("name"=>"logsize2", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "crmin" => array("name"=>"crmin", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "crhour" => array("name"=>"crhour", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "crday" => array("name"=>"crday", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "crmonth" => array("name"=>"crmonth", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "crweek" => array("name"=>"crweek", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
        "scriptvars" => array("name"=>"scriptvars", "type"=>"textarea","editor"=>false,"rows"=>5,"width"=>"100%","table" =>"thline","checktype" => "text"),
    ),
    ),
    "sid" => array("name"=>"sid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
    "pid" => array("name"=>"pid", "type"=>"text","size"=>255,"width"=>"100%","checktype" => "text"),
);



//Алиасы для формирования URL ------------------
SysStorage::$storage['urlaliases'] = array( //Архив котировок и т.п.
    'group' => 'noview', //Группа хранилищ
    'ru_name' => 'Алиасы URL', //Название на русском
    'eng_name' => 'Trade info', //Название на английском
    'db' => 'mysql1', //База данных
    'table' => 'mnbv_urlaliases', //Таблица
    'access' => 0, // Доступ на чтение
    'access2' => 102, // Доступ на редактирование
    //'accessv' => array("view" => 202), //Доступы к различным вкладкам (если не задано, то также как и доступ к объекту)
    //'access_stru' => array("view" => 2), //Доступы к редактированию структуры (папок со всеми их настройками
    'stru' => array(
        //Общие данные
        "id" => array("type"=>"int", "size"=>11, "creatval"=>0, "autoinc"=>true, "dbtype"=>"int"), // Идентификатор записи
        "siteid" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int"), // Идентификатор сайта
        "urltype" => array("type"=>"int", "size"=>2, "creatval"=>0, "dbtype"=>"int"), // Идентификатор типа URL
        "alias" => array("type"=>"string", "size"=>100, "creatval"=>"", "dbtype"=>"varchar"), //алиас объекта
        "catalias" => array("type"=>"string", "size"=>100, "creatval"=>"", "dbtype"=>"varchar"), //алиас вышестоящей
        "idref" => array("type"=>"int", "size"=>11, "creatval"=>0, "dbtype"=>"int"), // Идентификатор объекта
        "objtype" => array("type"=>"int", "size"=>1, "creatval"=>0, "dbtype"=>"int"), // Идентификатор типа объекта
    ), //Структура данного хранилища
    'view' => array(), //Формат вывода - редактирования
    'list' => array(), //Формат списка
    'filter' => array(), //Формат фильтра
    'files_security' => false, //будет ли ограничение доступа к приложенным файлам объектов хранилища
    'varuse' => false, //разрешено ли использование элементов данного хранилища как значение поля
    'attruse' => false, //Есть ли у данного хранилища атрибуты, если не требуются, то для быстродействия лучше отключать.
);

//------------------------------------------
