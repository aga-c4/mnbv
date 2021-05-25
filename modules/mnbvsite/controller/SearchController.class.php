<?php
/**
 * Контроллер вывода результатов поиска
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 25.08.17
 * Time: 00:00
 */
class SearchController extends AbstractMnbvsiteController {
    
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
        $storage = (MNBVStorage::isStorage(Glob::$vars['prod_storage']))?Glob::$vars['prod_storage']:'';

        SysLogs::addLog('Select mnbv script storage: [' . $storage . ']');
        $item['img_max_size'] = MNBVf::getImgMaxSize($storage,Glob::$vars['img_max_size']);
  
        //Страницы
        $item['list_max_items'] = Glob::$vars['list_max_items'];
        if (!empty($item['obj']['vars']['list_max_items'])) $item['list_max_items'] = intval($item['obj']['vars']['list_max_items']);
        $item['list_page'] = (!empty(Glob::$vars['mnbv_listpg']))?Glob::$vars['mnbv_listpg']:1;
        $item['list_start_item'] = $item['list_max_items'] * ($item['list_page'] - 1);

        //Формирование настроек списка: фильтров, сортировки, номеров страниц
        $quFilterArr = array('visible','=',1); //Фильтры
        $quConfArr = array("countFoundRows"=>true, "sort"=>array(), "limit"=>array($item['list_start_item'],$item['list_max_items'])); //Сортировка
        
        //Фильтрация по атрибутам-----------------------------------------------
        //Формирование массива выбранных элементов фильтров и диапазонов
        $filterValsArr = (isset(Glob::$vars['mnbv_listfilter'])&&is_array(Glob::$vars['mnbv_listfilter']))?Glob::$vars['mnbv_listfilter']:array();
        $finFilterValsArr = false;
        
        $cache = new MNBVCache();
        $attr_filters = $cache->get("prodfilters:search",true);
        
        if ($attr_filters===null || !is_array($attr_filters) || !empty(Glob::$vars['no_cache'])){ //Необходимо перегенерить кеш
            $attr_filters = MNBVf::objFilterGenerator('attributes',0,array('limitparams'=>true)); //Специально без выделения пунктов, чтоб можно было закешировать.
            $cache->set("prodfilters:search",$attr_filters,Glob::$vars['prod_filters_cache_ttl']);
        }

        //Если фильтры найдены, подготовим элементы для их вывода в шаблоне
        if (is_array($attr_filters) && isset($attr_filters['list'])) {
            $attr_filters = MNBVf::selectFilterItems($attr_filters,$filterValsArr);
            $item['attr_filters'] = $attr_filters['list'];
            $item['attr_filters_selected_nums'] = $attr_filters['selected'];
            if (isset($attr_filters['selected_items']) && is_array($attr_filters['selected_items'])) {
                $finFilterValsArr = $attr_filters['selected_items'];
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
                            array_push($quFilterArr, "and","id","in",array("select","objid","from",SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],"where",array("attrid","=","$key","and","vint",">=",$value["vals"][0],"and","vint","<=",$value["vals"][1])));
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
        
        //Обработка строки поиска
        $stemmer = new StemmerRu();
        $search = SysBF::getFrArr(Glob::$vars['request'],'search','');      
        $search = $item['search_str'] = SysBF::prepareSearchSth($search);
        SysLogs::addLog('Search str: [' . $item['search_str'] . ']'); 
        
        $searchArr0 = preg_split("/ /",$search);
        $searchNormStr = '';
        $searchArr = array();
        foreach($searchArr0 as $key=>$value){
            $searchArr[$key] = SysBF::strNormalize($stemmer->getWordBase($value));
            $searchNormStr .= ((!empty($searchNormStr))?' ':'') . $searchArr[$key];
        }

        $slov_v_stroke=count($searchArr);
        if ($slov_v_stroke>4){$slov_v_stroke=3;}//Ограничение на количество слов     
        SysLogs::addLog('Search norm str: [' . $searchNormStr . '] slov_v_stroke=['.$slov_v_stroke.']');

        foreach($searchArr as $value){
            array_push($quFilterArr, "and","norm_search","like",'%'.$value.'%');
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
        $quFilterArr2 = $quFilterArr;
        array_push($quFilterArr2, 'and','type','!=',ST_FOLDER);
        $item['list'] = MNBVStorage::getObjAcc($storage,
                array("id","parentid","pozid","type","typeval","visible","access","access2","first","name","namelang","about","aboutlang","vars","files","siteid","date","alias",'oldprice','price','cost','discmaxpr','discmaxval','discminmargpr','discminmargval'),
                $quFilterArr2,$quConfArr);
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
        
        //Список категорий
        $quConfArr["sort"] = array("pozid"=>"inc","name"=>"inc");
        $quConfArr["limit"] = array(0,3);
        array_push($quFilterArr, 'and','type','=',ST_FOLDER,"and","id","!=",Glob::$vars['prod_storage_rootid']);
        $item['cat_list'] = MNBVStorage::getObjAcc($storage,
                array("id","parentid","pozid","type","typeval","visible","access","access2","first","name","namelang","about","aboutlang","vars","files","siteid","date","alias",'oldprice','price','cost','discmaxpr','discmaxval','discminmargpr','discminmargval'),
                $quFilterArr,$quConfArr);
        $item['cat_list_size'] = (int)$item['cat_list'][0]; unset($item['cat_list'][0]); //Вынесем размер списка из массива 
        foreach ($item['cat_list'] as $key=>$value) if ($key>0) {
            if (!empty($value["id"])) {
                $value["obj_storage"] = $storage;
                $value['use_other_storage'] = $storage;
                if (!empty($item['obj']['use_other_storage']) && isset($item['obj']['page_main_alias'])) {
                    $value['page_main_alias'] = $item['obj']['page_main_alias'];
                    $value['folder_start_id'] = $item['obj']['folder_start_id'];
                    $value['folderid'] = $item['obj']['folderid'];
                    $value['folder_alias'] = $item['obj']['folder_alias'];
                }
                $item['cat_list'][strval($key)]['files'] = (!empty($value['files']))?MNBVf::updateFilesArr($storage,$value["id"],$value['files']):array();
                
                $params = array();
                if (!Lang::isDefLang()) {
                    $params['altlang'] = array('altlang'=>true);
                    if (!empty($value['namelang'])) $item['cat_list'][strval($key)]['name'] = $value['namelang'];
                    $item['cat_list'][strval($key)]['about'] = SysBF::getFrArr($value,'aboutlang','');
                }
                
                $item['cat_list'][strval($key)]['url'] = MNBVf::generateObjUrl($value,$params); //Формирование URL из текущего адреса

            }else{ //Косячная запись, удалим
                unset($item['cat_list'][strval($key)]);
            }
        }

        //Шаблон вывода списка объектов
        $item['page_sctpl'] = 'tpl_searchlist.php'; //По-умолчанию
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
        $page_list_url = Glob::$vars['mnbv_cur_master_uri'].'?search='.$search;
        $params = array('altlang'=>Lang::isAltLang(), 'page_list_url'=>$page_list_url);
        $item['page_list_url'] = MNBVf::generateObjUrl($item['obj'],$params); //Чистый URL
        SysLogs::addLog('page_list_url: [' . $item['page_list_url'] . ']');
        
        $params = array('altlang'=>Lang::isAltLang(), 'page_list_url'=>$page_list_url);
        if (!empty(Glob::$vars['mnbv_listfilterstr'])) $params['filters'] = Glob::$vars['mnbv_listfilterstr'];
        if (!empty(Glob::$vars['mnbv_listsort'])) $params['sort'] = Glob::$vars['mnbv_listsort'];
        $item['page_list_paginationurl'] = MNBVf::generateObjUrl($item['obj'],$params); //URL для пагинации
        SysLogs::addLog('page_list_paginationurl: [' . $item['page_list_paginationurl'] . ']');
        
        $params = array('altlang'=>Lang::isAltLang(), 'page_list_url'=>$page_list_url);
        if (!empty(Glob::$vars['mnbv_listfilterstr'])) $params['filters'] = Glob::$vars['mnbv_listfilterstr'];
        $params['fingetpref'] = true; //В конце URL добавить префикс Get параметра
        $item['page_list_filters_url'] = MNBVf::generateObjUrl($item['obj'],$params); //URL для формы сортировки с сохранением фильтров
        SysLogs::addLog('page_list_filters_url: [' . $item['page_list_filters_url'] . ']');
        
        $params = array('altlang'=>Lang::isAltLang(), 'page_list_url'=>$page_list_url);
        if (!empty(Glob::$vars['mnbv_listsort'])) $params['sort'] = Glob::$vars['mnbv_listsort'];
        $params['fingetpref'] = true; //В конце URL добавить префикс Get параметра
        $item['page_list_sort_url'] = MNBVf::generateObjUrl($item['obj'],$params); //URL для формы фильтров с сохранением сортировки
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

        if (!empty($viewOnlyListSize)) {
            $tpl_mode = 'json';
            $item = $item['list_size'];
        }
        
        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
        
}
