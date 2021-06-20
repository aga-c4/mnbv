<?php
/**
 * Контроллер вывода списка объектов
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 25.08.17
 * Time: 00:00
 */
class ProductsController extends AbstractMnbvsiteController {
    
    /**
     * Метод по-умолчанию
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){
        if (!empty(Glob::$vars['mnbv_site']['sub_id'])){//Вывод объекта
            return self::action_object($item,$tpl_mode,$console);
        }else{ //В остальных случаях - вывод списка
            return self::action_list($item,$tpl_mode,$console);
        }
    }
    
    
    /**
     * Отображение списка объектов
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_list($item=array(),$tpl_mode='html', $console=false){
        
        if (SysBF::getFrArr(Glob::$vars['request'],'viewonlylistsize')) {
            $viewOnlyListSize = true;
        }
        
        //Хранилище и папка по-умолчанию
        $storage = Glob::$vars['mnbv_site']['storage']; //Текущее хранилище
        $item['obj']['use_other_storage'] = '';
        $item['obj']['page_main_alias'] = ''; //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
        $item['obj']['folder_start_id'] = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):1;
        $item['obj']['folderid'] = $folderId = $item['id'];
        $item['obj']['folder_name'] = $item['obj']['parent_name'];
        $item['obj']['folder_alias'] = $item['obj']['alias'];
        $realFolder = $item['obj'];
        
        //Выбор хранилища и при необходимости перечитаем сведения о папке, которую выводим
        if (!empty($item['obj']['vars']['script_storage']) and (MNBVStorage::isStorage($item['obj']['vars']['script_storage']))) {
            //Привязанное хранилище существует
            $storage2 = $item['obj']['vars']['script_storage'];
            
            if (!empty(Glob::$vars['mnbv_site']['sub_list_id'])){//Есть номера субобъектов (папка каталога товаров)
                $folderId2 = intval(Glob::$vars['mnbv_site']['sub_list_id']);
            } elseif (!empty($item['obj']['vars']['script_folder'])){ //Попробуем найти корневой объект для вывода
                $folderId2 = intval($item['obj']['vars']['script_folder']);
            }

            if (!empty($folderId2) && $realFolder = MNBVf::getStorageObject($storage2,$folderId2,array('altlang'=>$item['mnbv_altlang'],'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден
                $storage = $storage2;
                $folderId = $folderId2;
                $item['obj']['parent']['use_other_storage'] = $item['obj']['use_other_storage'] = $storage; //Маркер, что работаем с другим хранилищем
                $item['obj']['page_main_alias'] = (!empty($item['obj']['alias']))?('/'.$item['obj']['alias']):('/id'.$item['obj']['id']); //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
                $realFolder['page_main_alias'] = $realFolder['parent']['page_main_alias'] = $item['obj']['page_main_alias'];
                $realFolder['use_other_storage'] = $realFolder['parent']['use_other_storage'] = $item['obj']['use_other_storage'];
                $item['obj']['folder'] = $realFolder;
                $item['obj']['folderid'] = $realFolder['id'];
                $item['obj']['folder_name'] = $realFolder['name'];
                $item['obj']['folder_alias'] = (!empty($realFolder['alias']))?$realFolder['alias']:'';
                
                if (!Lang::isDefLang()){
                    if (!empty($realFolder['namelang'])) $realFolder['name'] = $realFolder['namelang'];
                    if (!empty($realFolder['aboutlang'])) $realFolder['about'] = $realFolder['aboutlang'];
                    if (!empty($realFolder['textlang'])) $realFolder['text'] = $realFolder['textlang'];
                }
                
                $item['obj']['name'] = $realFolder['name'];
                $item['obj']['about'] = $realFolder['about'];
                $item['obj']['text'] = $realFolder['text'];
                
                //Метатеги----------------------------------------------------------------------
                Glob::$vars['page_title'] = (!empty($realFolder['vars']['title']))?$realFolder['vars']['title']:((!empty($realFolder['name']))?$realFolder['name']:'');
                Glob::$vars['page_keywords'] = (!empty($realFolder['vars']['keywords']))?$realFolder['vars']['keywords']:'';
                Glob::$vars['page_description'] = (!empty($realFolder['vars']['description']))?$realFolder['vars']['description']:'';
                $item['page_h1'] = (!empty($realFolder['name']))?$realFolder['name']:'';
                //------------------------------------------------------------------------------
                
            }else{
                //Объект не найден, отдадим 404 ошибку
                SysLogs::addError('Error: subObject not found ['.$storage2.':'.$folderId2.'] not found');
                MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], '404.php'),$item,$tpl_mode);
                return false;
            }
        }
        
        SysLogs::addLog('Select mnbv script storage: [' . $storage . '] page_main_alias=['.$item['obj']['page_main_alias'].']');
        SysLogs::addLog('Select mnbv script storage folder: [' . $folderId . ']');
        $item['img_max_size'] = MNBVf::getImgMaxSize($storage,Glob::$vars['img_max_size']);
        
        //Страницы
        $item['list_max_items'] = Glob::$vars['list_max_items'];
        if (!empty($item['obj']['vars']['list_max_items'])) $item['list_max_items'] = intval($item['obj']['vars']['list_max_items']);
        $item['list_page'] = (!empty(Glob::$vars['mnbv_listpg']))?Glob::$vars['mnbv_listpg']:1;
        $item['list_start_item'] = $item['list_max_items'] * ($item['list_page'] - 1);

        //Формирование настроек списка: фильтров, сортировки, номеров страниц
        $quFilterArr = array("parentid",'=',$folderId,'and','visible','=',1); //Фильтры
        $quConfArr = array("countFoundRows"=>true, "sort"=>array(), "limit"=>array($item['list_start_item'],$item['list_max_items'])); //Сортировка

        //Фильтры списка
        foreach(Glob::$vars['mnbv_route_arr'] as $key=>$value) {
            ;// Виды фильтров:
            // /ff_ПОЛЕ_1_123/ - ПОЛЕ>123
            // /ff_ПОЛЕ_2_123/ - ПОЛЕ<123
            // /ff_ПОЛЕ_123/ - ПОЛЕ=123 если параметр строковый или текстовый, то поиск по like '%строка%'
            // /ff_ПОЛЕ_123_not/ - ПОЛЕ!=123
        }
        
        //Фильтрация по атрибутам-----------------------------------------------
        //Формирование массива выбранных элементов фильтров и диапазонов
        $filterValsArr = (isset(Glob::$vars['mnbv_listfilter'])&&is_array(Glob::$vars['mnbv_listfilter']))?Glob::$vars['mnbv_listfilter']:array();
        $finFilterValsArr = false;
        
        if (empty($folderId) || $folderId!=Glob::$vars['prod_storage_rootid']){ //Фильтры только для заданной категории, кроме случая с указанием конкретных товаров, в таком случае делаем фильтры корневой категории каталога
            $cache = new MNBVCache('longtmp');
            $attr_filters = $cache->get("prodfilters:$folderId",true);
            //echo "(prodfilters:$folderId=>[$attrFiltersCacheStr])";
            if ($attr_filters===null || !is_array($attr_filters) || !empty(Glob::$vars['no_cache'])){ //Необходимо перегенерить кеш
                $attr_filters = MNBVf::objFilterGenerator('attributes',$realFolder,array('folderid'=>(!empty($folderId))?$folderId:Glob::$vars['prod_storage_rootid'])); //Специально без выделения пунктов, чтоб можно было закешировать.
                $cache->set("prodfilters:$folderId",$attr_filters,Glob::$vars['prod_filters_cache_ttl']);
            }
  
            //Если фильтры найдены, подготовим элементы для их вывода в шаблоне
            if (is_array($attr_filters) && isset($attr_filters['list'])) {
                $attr_filters = MNBVf::selectFilterItems($attr_filters,$filterValsArr);
                $item['attr_filters'] = $attr_filters['list'];
                $item['attr_filters_selected_nums'] = $attr_filters['selected'];
                if (isset($attr_filters['selected_items']) && is_array($attr_filters['selected_items'])) {
                    $finFilterValsArr = $attr_filters['selected_items'];
                }elseif (!empty(Glob::$vars['mnbv_site']['sub_vendid'])){
                    $finFilterValsArr = array('vendor'=>array(
                        "id"=>"vendor",
                        "type"=>"list",
                        "vals"=>Array(Glob::$vars['mnbv_site']['sub_vendid'])));
                }
            }
        }
        
        //Доработаем условие фильтрации списка 
        if (is_array($finFilterValsArr) 
                && !empty(SysStorage::$storage[Glob::$vars['prod_storage']])
                && isset(SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'])
                && isset(SysStorage::$storage[SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse']])){
            //Есть хранилище значений атрибутов, добавим условия выбора из него
            
            foreach($finFilterValsArr as $key=>$value){
                if (empty($value["id"])) continue;
                $value["id"] = intval($value["id"]);
                if (false!==strpos($key,'attr')){//Это атрибуты
                    if ($value["type"]==='list'){
                        if (is_array($value["vals"]) && count($value["vals"])) {
                            array_push($quFilterArr, "and","id","in",array("select","objid","from",SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],"where",array("attrid","=",$value["id"],"and","vint","in",$value["vals"])));
                        }
                    }if ($value["type"]==='range'){
                        if (is_array($value["vals"]) && count($value["vals"])) {
                            array_push($quFilterArr, "and","id","in",array("select","objid","from",SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],"where",array("attrid","=",$value["id"],"and","vint",">=",$value["vals"][0],"and","vint","<=",$value["vals"][1])));
                        }
                    }
                }else{//Это поля таблицы товаров
                    if ($value["type"]==='list'){
                        if (is_array($value["vals"]) && count($value["vals"])) {
                            array_push($quFilterArr, "and",$key,"in",$value["vals"]);
                        }
                    }if ($value["type"]==='range'){
                        if (is_array($value["vals"]) && count($value["vals"])) {
                            array_push($quFilterArr, "and",$key,">=",$value["vals"][0],"and",$key,"<=",$value["vals"][1]);
                        }
                    }
                }
            }
        }
        //----------------------------------------------------------------------

        
        //Сортировка списка------------------------------------------------------------
        $quConfArr["sort"] = array();
        $item['list_sort'] = '';
        if (empty($viewOnlyListSize)) {
            $item['real_list_sort'] = (!empty($item['obj']['vars']['list_sort']))?$item['obj']['vars']['list_sort']:''; //Если задано на странице, берем от туда или ''
            if (!empty($realFolder['vars']['list_sort'])) $item['real_list_sort'] = $realFolder['vars']['list_sort']; //Приоритет у сортировки конечной папки
            if (!empty(Glob::$vars['mnbv_listsort'])) {//Самый высокий приоритет у ручной установке через маршрутизатор
                $item['list_sort'] = $item['real_list_sort'] = (MNBVf::validateSortType(Glob::$vars['mnbv_listsort']))?Glob::$vars['mnbv_listsort']:'';
            }
            if (!Lang::isDefLang()){ //Если требуется, то будем сортировать по имени на альтернативном языке
                if ($item['real_list_sort'] == 'name') $item['real_list_sort'] = 'namelang';
                elseif ($item['real_list_sort'] == 'name_desc') $item['real_list_sort'] = 'namelang_desc';
            }
            if (!MNBVf::validateSortType($item['real_list_sort'])) $item['real_list_sort'] = '';

            $quConfArr["sort"] = MNBVf::getSortArr($item['real_list_sort']); //Сформируем массив для сортировки
            SysLogs::addLog('Select mnbv script real_list_sort: [' . $item['real_list_sort'] . ']');
        }
        //------------------------------------------------------------------------------       
        
        //Список объектов
        $item['list'] = MNBVStorage::getObjAcc($storage,
                array("id","parentid","pozid","type","typeval","visible","access","access2","first","name","namelang","about","aboutlang","vars","files","siteid","date","alias",'oldprice','price','cost','discmaxpr','discmaxval','discminmargpr','discminmargval'),
                $quFilterArr,$quConfArr);
        $item['list_size'] = (int)$item['list'][0]; unset($item['list'][0]); //Вынесем размер списка из массива 
        foreach ($item['list'] as $key=>$value) if ($key>0) {
            if (!empty($value["id"])) {
                $value["obj_storage"] = $storage;
                $value['use_other_storage'] = $storage;
                if (!empty($item['obj']['use_other_storage']) && isset($item['obj']['page_main_alias'])) {
                    $value['page_main_alias'] = $item['obj']['page_main_alias'];
                    $value['folder_start_id'] = $item['obj']['folder_start_id'];
                    $value['folderid'] = $item['obj']['folderid'];
                    $value['folder_alias'] = $item['obj']['folder_alias'];
                }
                $item['list'][strval($key)]['files'] = (!empty($value['files']))?MNBVf::updateFilesArr($storage,$value["id"],$value['files']):array();
                
                $params = array();
                if (!Lang::isDefLang()) {
                    $params['altlang'] = array('altlang'=>true);
                    if (!empty($value['namelang'])) $item['list'][strval($key)]['name'] = $value['namelang'];
                    $item['list'][strval($key)]['about'] = SysBF::getFrArr($value,'aboutlang','');
                }
                
                if ($value['type']!=1){ //Это объект, передадим внутрь фильтрацию, сортировку и пагинацию
                    if (!empty(Glob::$vars['mnbv_listfilterstr'])) $params['filters'] = Glob::$vars['mnbv_listfilterstr'];
                    if (!empty(Glob::$vars['mnbv_listsort'])) $params['sort'] = Glob::$vars['mnbv_listsort'];
                    if (!empty(Glob::$vars['mnbv_listpg'])) $params['pg'] = Glob::$vars['mnbv_listpg'];
                    $params['getonly'] = true;
                }
                $item['list'][strval($key)]['url'] = MNBVf::generateObjUrl($value,$params); //Формирование URL из текущего адреса
                
                //Расчитаем цену со скидкой для конкретного пользовтеля с учетом ограничений
                //TODO - необходимо доработать алгоритм с учетом макс скидок по вендорам, категориям и товарам. 
                //возможно на первом этапе это будет установка в категории этих порогов с перекрытием в отдельных товарах.
                //в таком случае работа будет вестись на уровне отдельных товаров, а категории и вендоры будут использоваться
                //для фильтрации при массовом назначении этого параметра. Видимо пока это оптимальный вариант.
                //discmaxpr - максимальная скидка в процентах
                //discmaxval - максимальная скидка в валюте
                //discminmargpr - порог маржи в процентах, ниже которого скидка не может быть
                //discminmargval - порог маржи в рублях, ниже которого скидка не может быть
                $discountParamsArr = array('user' => 'current','discmaxpr'=>$value["discmaxpr"],'discmaxval'=>$value["discmaxval"],'discminmargpr'=>$value["discminmargpr"],'discminmargval'=>$value["discminmargval"]);
                $item['list'][strval($key)]['discount_price'] = MNBVDiscount::getPrice($value["id"], $value["price"], $value["cost"],$discountParamsArr);
            }else{ //Косячная запись, удалим
                unset($item['list'][strval($key)]);
            }
        }
        //if (empty($item['list_size']) && $folderId!=Glob::$vars['prod_storage_rootid']) unset($item['attr_filters']);
        
        //Подготовим описание категории-----------------------------------------
        $item['page_content'] = $item['page_content2'] = '';
        if (empty(Glob::$vars['mnbv_listpg']) || Glob::$vars['mnbv_listpg']<2){ //Описание только на 1 странице
            $PgHtml = (!empty($item['obj']['text']))?$realFolder['text']:'';
            //Автозамена приложенных изображений и файлов img и att 
            $PgHtml = MNBVf::updateTxt($PgHtml,$realFolder['files'],Glob::$vars['mnbv_site'],array(400,300));
            //Размещение контента и скрипта
            $item['page_content'] = $item['page_content2'] = '';
            if (!empty($item['obj']['vars']['scriptvalign'])&&$item['obj']['vars']['scriptvalign']=2) $item['page_content2'] = $PgHtml;
            else $item['page_content'] = $PgHtml;
        }
        //----------------------------------------------------------------------

        //Шаблон вывода списка объектов
        $item['page_sctpl'] = 'tpl_prodlist.php'; //По-умолчанию
        if (!empty($item['obj']['vars']['script_tpl_file'])) $item['page_sctpl'] = $item['obj']['vars']['script_tpl_file']; //Если задан в Переменных скрипта в объекте
        SysLogs::addLog('Select mnbv script tpl file: [' . $item['page_sctpl'] . ']');

        //Настройки сортировки--------------------------------------------------
        $item['list_sort_types'] = array(
            'price' => 'price', //сортировка по цене
            'price_desc' => 'price_desc', //сортировка по цене по убыванию
            //'id' => 'id', //сортировка по id объекта
            //'id_desc' => 'id_desc', //сортировка по id объекта по убыванию
            //'date' => 'date', //сортировка по date объекта
            //'date_desc' => 'date_desc', //сортировка по date объекта по убыванию
            //'pozid' => 'pozid', //сортировка по позиции объекта, названию
            'name' => 'name', //сортировка по полю name не важно включен альтернативный язык или нет
            //'name_desc' => 'name_desc', //сортировка по полю name не важно включен альтернативный язык или нет
        );
        //----------------------------------------------------------------------
        
        //Базовые URL для шаблона
        $item['page_list_url'] = MNBVf::generateObjUrl($realFolder,array('altlang'=>Lang::isAltLang(),'vendor'=>true)); //Чистый URL
        SysLogs::addLog('page_list_url: [' . $item['page_list_url'] . ']');
        
        $item['page_list_url_novend'] = MNBVf::generateObjUrl($realFolder,array('altlang'=>Lang::isAltLang())); //Чистый URL
        SysLogs::addLog('page_list_url_novend: [' . $item['page_list_url_novend'] . ']');
        
        $params = array('vendor'=>true);
        if (!Lang::isDefLang()) $params['altlang'] = array('altlang'=>true);
        if (!empty(Glob::$vars['mnbv_listfilterstr'])) $params['filters'] = Glob::$vars['mnbv_listfilterstr'];
        if (!empty(Glob::$vars['mnbv_listsort'])) $params['sort'] = Glob::$vars['mnbv_listsort'];
        $item['page_list_paginationurl'] = MNBVf::generateObjUrl($realFolder,$params); //URL для пагинации
        SysLogs::addLog('page_list_paginationurl: [' . $item['page_list_paginationurl'] . ']');
        
        $params = array('vendor'=>true);
        if (!Lang::isDefLang()) $params['altlang'] = array('altlang'=>true);
        if (!empty(Glob::$vars['mnbv_listfilterstr'])) $params['filters'] = Glob::$vars['mnbv_listfilterstr'];
        $params['fingetpref'] = true; //В конце URL добавить префикс Get параметра
        $item['page_list_filters_url'] = MNBVf::generateObjUrl($realFolder,$params); //URL для формы сортировки с сохранением фильтров
        SysLogs::addLog('page_list_filters_url: [' . $item['page_list_filters_url'] . ']');
        
        $params = array('vendor'=>true);
        if (!Lang::isDefLang()) $params['altlang'] = array('altlang'=>true);
        if (!empty(Glob::$vars['mnbv_listsort'])) $params['sort'] = Glob::$vars['mnbv_listsort'];
        $params['fingetpref'] = true; //В конце URL добавить префикс Get параметра
        $item['page_list_sort_url'] = MNBVf::generateObjUrl($realFolder,$params); //URL для формы фильтров с сохранением сортировки
        SysLogs::addLog('page_list_sort_url: [' . $item['page_list_sort_url'] . ']');
        
        //Настройки номеров страниц---------------------------------------------            
        $item['page_list_num_conf'] = array(
            'page_list_url' => $item['page_list_paginationurl'],
            'list_size' => $item['list_size'],
            'list_max_items' => $item['list_max_items'],
            'list_sort' => $item['list_sort'],
            'list_page' => $item['list_page'],
            'centre_bl' => 5);
        //----------------------------------------------------------------------
        
        //Уберем фильтр по вендору, если он идет как папка в урле
        if (!empty(Glob::$vars['mnbv_site']['sub_vendid']) && is_array($attr_filters) && isset($attr_filters['list']) && isset($attr_filters['list']['vendor'])){
            if (isset($attr_filters['list']['vendor'])) { //Если вендор задан жестко, то фильтр по нему не требуется
                //Подправим метатеги
                if (isset($attr_filters['list']['vendor']['vals']) && isset($attr_filters['list']['vendor']['vals'][Glob::$vars['mnbv_site']['sub_vendid']])){
                    $curVendNAme = $attr_filters['list']['vendor']['vals'][Glob::$vars['mnbv_site']['sub_vendid']]['name'];
                    if (Lang::isAltLang() && !empty($attr_filters['list']['vendor']['vals'][Glob::$vars['mnbv_site']['sub_vendid']]['namelang'])){
                        $curVendNAme = $attr_filters['list']['vendor']['vals'][Glob::$vars['mnbv_site']['sub_vendid']]['namelang'];
                    }
                    Glob::$vars['page_title'] .= ' ' . $curVendNAme;
                    $item['page_h1'] .= ' ' . $curVendNAme;
                }
                unset($attr_filters['list']['vendor']);
                $item['attr_filters'] = $attr_filters['list'];
            }
            //print_r($attr_filters);
        }
              
        //Хлебные крошки--------------------------------------------------------
        /*
        Хлебные крошки. Идея такова - есть массив на текущем языке где поля:
        0 => array('name'=>'Главная','url'=>'/') - Формируется в основном контроллере сайта
        1 => array('name'=>'Категория текущего уровня','url'=>'...') - Формируется в основном контроллере сайта, если не совпадает с главной страницей
        2 => array('name'=>'Название текущей страницы','url'=>'URL текущей страницы') - Формируется в основном контроллере сайта 
        3 => array('name'=>'Категория влолженного хранилища 1 уровня','url'=>'...') - Формируется в субконтроллере сайта  если не совпадает с категорией текущего уровня или со стартовой
        4 => array('name'=>'Категория влолженного хранилища текущего уровня','url'=>'...') - Формируется в субконтроллере
        5 => array('name'=>'Название текущего объекта влолженного хранилища ','url'=>'...') - Формируется в субконтроллере сайта

        При этом размещение этих элементов массива четко предопределено, чтоб при необходимости не выводить часть из них. смещая начало обработки массива к концу.
         */        
        if (!empty($item['obj']['use_other_storage'])) {
            //Папка
            SysLogs::addLog('parent=[' . $realFolder['parent']['id'] . '] <=> folder_start_id=[' . $item['obj']['folder_start_id'] . ']');
            
            if (!empty($realFolder['id']) && $realFolder['id']!=$item['obj']['folder_start_id']) {
                if (!empty($realFolder['parent']['id']) && $realFolder['parent']['id']!=$item['obj']['folder_start_id']) {
                    $item['obj']['up_folder_url'] = MNBVf::generateObjUrl($realFolder['parent'],array('altlang'=>!Lang::isDefLang()));
                    $currName = MNBVf::getItemName($realFolder['parent'],!Lang::isDefLang());
                    $item['obj']['nav_arr'][4] = array('name'=>$currName,'url'=>$item['obj']['up_folder_url']); //Текущая папка
                }
                if (!empty(Glob::$vars['mnbv_site']['sub_vendid'])){
                    $currName = MNBVf::getItemName($item['obj'],!Lang::isDefLang());
                    $item['obj']['nav_arr'][4] = array('name'=>$currName,'url'=>$item['page_list_url_novend']);
                }
                //Текущий объект
                $currName = MNBVf::getItemName($realFolder,!Lang::isDefLang());
                $item['obj']['nav_arr'][5] = array('name'=>$currName,'url'=>$item['page_list_url']);
            }
        }
        //Конец обработки хлебных крошек ---------------------------------------

        if (!empty($viewOnlyListSize)) {
            $tpl_mode = 'json';
            $item = $item['list_size'];
        }

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
    /**
     * Отображение объекта
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_object($item=array(),$tpl_mode='html', $console=false){

        //Хранилище и папка по-умолчанию
        $storage = Glob::$vars['mnbv_site']['storage']; //Текущее хранилище
        $item['obj']['use_other_storage'] = '';
        $item['obj']['page_main_alias'] = ''; //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
        $item['obj']['folder_start_id'] = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):1;
        $item['obj']['folderid'] = $item['obj']['parent_id'];
        $item['obj']['folder_name'] = $item['obj']['parent_name'];
        $item['obj']['folder_alias'] = (!empty($item['obj']['parent']['alias']))?$item['obj']['parent']['alias']:'';
        $realObject = $item['obj'];
        $realObjectId = $item['id'];

        //Выбор хранилища и при необходимости перечитаем сведения о папке, которую выводим-------------
        if (!empty($item['obj']['vars']['script_storage']) and (MNBVStorage::isStorage($item['obj']['vars']['script_storage']))) {
            //Привязанное хранилище существует
            $storage2 = $item['obj']['vars']['script_storage'];
            $objectId2 = (!empty(Glob::$vars['mnbv_site']['sub_id']))?intval(Glob::$vars['mnbv_site']['sub_id']):0;

            if (!empty($objectId2) && $realObject = MNBVf::getStorageObject($storage2,$objectId2,array('altlang'=>$item['mnbv_altlang'],'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден
                $storage = $storage2;
                $realObjectId = $objectId2;
                $item['obj']['parent']['use_other_storage'] = $item['obj']['use_other_storage'] = $storage; //Маркер, что работаем с другим хранилищем
                $item['obj']['page_main_alias'] = (!empty($item['obj']['alias']))?('/'.$item['obj']['alias']):('/id'.$item['obj']['id']); //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
                $realObject['page_main_alias'] = $realObject['parent']['page_main_alias'] = $item['obj']['page_main_alias'];
                $item['obj']['folder'] = $realObject;
                $item['obj']['folderid'] = $realObject['parent_id'];
                $item['obj']['folder_name'] = $realObject['parent_name'];
                $item['obj']['folder_alias'] = (!empty($realObject['parent']['alias']))?$realObject['parent']['alias']:'';
            }else{
                //Объект не найден, отдадим 404 ошибку
                SysLogs::addError('Error: subObject not found ['.$storage2.':'.$objectId2.'] not found');
                MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], '404.php'),$item,$tpl_mode);
                return false;
            }

        }
        SysLogs::addLog('Select mnbv script storage: [' . $storage . '] page_main_alias=['.$item['obj']['page_main_alias'].']');
        SysLogs::addLog('Select mnbv script storage object: [' . $realObjectId . ']');
        $item['img_max_size'] = MNBVf::getImgMaxSize($storage,Glob::$vars['img_max_size']);

        //Подготовим переменные скрипта, если есть
        $realObject['vars']['scriptvars'] = (!empty($item['obj']['vars']['scriptvars']))?SysBF::json_decode($item['obj']['vars']['scriptvars']):array();

        //Расчитаем цену со скидкой для конкретного пользовтеля с учетом ограничений
        //TODO - необходимо доработать алгоритм с учетом макс скидок по вендорам, категориям и товарам. 
        //возможно на первом этапе это будет установка в категории этих порогов с перекрытием в отдельных товарах.
        //в таком случае работа будет вестись на уровне отдельных товаров, а категории и вендоры будут использоваться
        //для фильтрации при массовом назначении этого параметра. Видимо пока это оптимальный вариант.
        //discmaxpr - максимальная скидка в процентах
        //discmaxval - максимальная скидка в валюте
        //discminmargpr - порог маржи в процентах, ниже которого скидка не может быть
        //discminmargval - порог маржи в рублях, ниже которого скидка не может быть
        $discountParamsArr = array('user' => 'current','discmaxpr'=>$realObject["discmaxpr"],'discmaxval'=>$realObject["discmaxval"],'discminmargpr'=>$realObject["discminmargpr"],'discminmargval'=>$realObject["discminmargval"]);
        $realObject['discount_price'] = MNBVDiscount::getPrice($realObject["id"], $realObject["price"], $realObject["cost"],$discountParamsArr);
        
        //Поправим имя, описание и текст в соответствии с altlang
        if (!Lang::isDefLang()){
            if (!empty($realObject['namelang'])) $realObject['name'] = $realObject['namelang'];
            if (!empty($realObject['aboutlang'])) $realObject['about'] = $realObject['aboutlang'];
            if (!empty($realObject['textlang'])) $realObject['text'] = $realObject['textlang'];
        }
        //------------------------------------------------------------------------------

        //Метатеги----------------------------------------------------------------------
        Glob::$vars['page_title'] = (!empty($realObject['vars']['title']))?$realObject['vars']['title']:((!empty($realObject['name']))?$realObject['name']:'');
        Glob::$vars['page_keywords'] = (!empty($realObject['vars']['keywords']))?$realObject['vars']['keywords']:'';
        Glob::$vars['page_description'] = (!empty($realObject['vars']['description']))?$realObject['vars']['description']:'';
        $item['page_h1'] = (!empty($realObject['name']))?$realObject['name']:'';
        //------------------------------------------------------------------------------

        //Страницы---------------------------------------------------------------------
        $item['list_max_items'] = Glob::$vars['list_max_items'];
        if (!empty($item['obj']['vars']['list_max_items'])) $item['list_max_items'] = intval($item['obj']['vars']['list_max_items']);
        $item['list_page'] = (!empty(Glob::$vars['mnbv_listpg']))?Glob::$vars['mnbv_listpg']:1;
        $item['list_start_item'] = $item['list_max_items'] * ($item['list_page'] - 1);
        //------------------------------------------------------------------------------

        //Фильтры списка----------------------------------------------------------------
        foreach(Glob::$vars['mnbv_route_arr'] as $key=>$value) {
            ;// Виды фильтров:
            // /ff_ПОЛЕ_1_123/ - ПОЛЕ>123
            // /ff_ПОЛЕ_2_123/ - ПОЛЕ<123
            // /ff_ПОЛЕ_123/ - ПОЛЕ=123 если параметр строковый или текстовый, то поиск по like '%строка%'
            // /ff_ПОЛЕ_123_not/ - ПОЛЕ!=123
        }
        //------------------------------------------------------------------------------

        //Сортировка списка------------------------------------------------------------
        $item['list_sort'] = (!empty(Glob::$vars['mnbv_listsort']))?Glob::$vars['mnbv_listsort']:'';
        if (!empty(Glob::$vars['mnbv_listsort'])) {//Самый высокий приоритет у ручной установке через маршрутизатор
            $item['list_sort'] = $item['real_list_sort'] = MNBVf::validateSortType(Glob::$vars['mnbv_listsort'])?Glob::$vars['mnbv_listsort']:'';
        }
        //------------------------------------------------------------------------------

        $item['obj']['folder_url'] = MNBVf::generateObjUrl($item['obj'],array('altlang'=>Lang::isAltLang(),'type'=>'list','sort'=>$item['list_sort'],'pg'=>SysBF::getFrArr(Glob::$vars,'mnbv_listpg',1))); //Формирование URL из текущего адреса

        /*----------------------------------------------------------------------
        Хлебные крошки. Идея такова - есть массив на текущем языке где поля:
        0 => array('name'=>'Главная','url'=>'/') - Формируется в основном контроллере сайта
        1 => array('name'=>'Категория текущего уровня','url'=>'...') - Формируется в основном контроллере сайта, если не совпадает с главной страницей
        2 => array('name'=>'Название текущей страницы','url'=>'URL текущей страницы') - Формируется в основном контроллере сайта
        3 => array('name'=>'Категория влолженного хранилища 1 уровня','url'=>'...') - Формируется в субконтроллере сайта  если не совпадает с категорией текущего уровня или со стартовой
        4 => array('name'=>'Категория влолженного хранилища текущего уровня','url'=>'...') - Формируется в субконтроллере
        5 => array('name'=>'Название текущего объекта влолженного хранилища ','url'=>'...') - Формируется в субконтроллере сайта

        При этом размещение этих элементов массива четко предопределено, чтоб при необходимости не выводить часть из них. смещая начало обработки массива к концу.
         */
        if (!empty($item['obj']['use_other_storage'])) {
            //Папка
            if (!empty($item['obj']['folderid']) && $item['obj']['folderid']!=$item['obj']['folder_start_id']) {
                $params = array();
                if (!Lang::isDefLang()) $params['altlang'] = array('altlang'=>true);
                if (!empty(Glob::$vars['mnbv_listfilterstr'])) $params['filters'] = Glob::$vars['mnbv_listfilterstr'];
                if (!empty(Glob::$vars['mnbv_listsort'])) $params['sort'] = Glob::$vars['mnbv_listsort'];
                if (!empty(Glob::$vars['mnbv_listpg'])) $params['pg'] = Glob::$vars['mnbv_listpg'];
                $item['obj']['up_folder_url'] = MNBVf::generateObjUrl($realObject['parent'],$params);
                $currName = MNBVf::getItemName($realObject['parent'],!Lang::isDefLang());
                $item['obj']['nav_arr'][4] = array('name'=>$currName,'url'=>$item['obj']['up_folder_url']); //Текущая папка
                SysLogs::addLog('Back folder URL: [' . $item['obj']['up_folder_url'] . ']');
                
                if (!empty($realObject['vendor'])){
                    Glob::$vars['mnbv_site']['sub_vendid'] = $realObject['vendor'];
                    //Получим из базы название и алиас вендора
                    $res = MNBVStorage::getObjAcc(Glob::$vars['vend_storage'],
                        array('id','alias','name','namelang'),
                        array('id','=',Glob::$vars['mnbv_site']['sub_vendid']));
                    $resval = ($res[0]>0)?$res[1]:null;
                    if ($resval!==null && is_array($resval) && !empty($resval['alias'])){
                        Glob::$vars['mnbv_site']['sub_vend'] = $resval['alias'];
                        $item['obj']['nav_arr'][2] = $item['obj']['nav_arr'][3];
                        $item['obj']['nav_arr'][3] = $item['obj']['nav_arr'][4];
                        $params['vendor'] = true;
                        $item['obj']['folder_url_vendor'] = MNBVf::generateObjUrl($realObject['parent'],$params);
                        $currName = ' '.MNBVf::getItemName($resval,Lang::isAltLang());
                        $item['obj']['nav_arr'][4] = array('name'=>$currName,'url'=>$item['obj']['folder_url_vendor']);
                        SysLogs::addLog('Back folder vend URL: [' . $item['obj']['folder_url_vendor'] . ']');
                        ksort($item['obj']['nav_arr']);
                    }
                }
            }
            //Текущий объект
            $currName = MNBVf::getItemName($realObject,!Lang::isDefLang());
            $item['obj']['nav_arr'][5] = array('name'=>$currName,'url'=>$item['page_url']);
        }
        //Конец обработки хлебных крошек ---------------------------------------

        //Для передачи в шаблон
        $item['sub_obj'] = $realObject;
        $item['page_content'] = $item['page_content2'] = '';
        //Автозамена шаблонов на приложенные файлы
        $item['sub_obj']['text'] = MNBVf::updateTxt($item['sub_obj']['text'],$item['sub_obj']['files'],Glob::$vars['mnbv_site'],array(400,300));

        $item['sub_obj']['sub_obj_storage'] = $storage;

        $item['sub_obj']['form_folder'] = array(
            "attrvals" => array("name"=>"attrvalsmini", "type"=>"attrvalsmini", "active"=>'print', "viewindex" =>false), //Значения атрибутов для папки укороченный вариант
        );

        //Шаблон вывода объекта
        $item['page_sctpl'] = 'tpl_prodview.php'; //По-умолчанию
        if (!empty($item['obj']['vars']['script_tpl2_file'])) $item['page_sctpl'] = $item['obj']['vars']['script_tpl2_file']; //Если задан в Переменных скрипта в объекте
        SysLogs::addLog('Select mnbv script tpl2 file: [' . $item['page_sctpl'] . ']');

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl2_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
        
}
