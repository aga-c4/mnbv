<?php
/**
 * Description of WidgetPglistController
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class WidgetPglistController extends AbstractWidgetControllerController {
    
    /**
     * @var string алиас текущего виджета
     */
    public $thisWidgetName = '';
    
    /**
     * @var type параметры текущего виджета
     */
    public $param = NULL;

    /**
     * @var string хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
     */
    public $storage = '';

    /**
     * @var int папка из которой будут выбираться объекты. Если не задано, то виджет не выводит ничего
     */
    public $folder = 0;

    /**
     * @var string алиас папки из которой будут выбираться объекты. Если не задано, то виджет не выводит ничего
     */
    public $folder_alias = '';

    /**
     * @var string идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
     */
    public $folder_start_id = 1;

    /**
     * @var string количество выводимых элементов
     */
    public $list_max_items = 3;

    /**
     * @var string основная часть URL на базе которой будет формироваться URL элемента списка хранилища
     */
    public $list_main_alias = '/';

    /**
     * @var string ссылка на полный список объектов
     */
    public $list_link = '';

    /**
     * @var string сортировка списка
     */
    public $list_sort = '';

    /**
     * @var string анкор ссылки на полный список объектов, если требуется
     */
    public $list_link_name = '';

    /**
     * @var string ('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
     */
    public $filter_type = '';

    /**
     * @var $bool true|false выводить только объекты, выделенные свойством First (Гл)
     */
    public $only_first = false;

    /**
     * @var array Массив конфигурации вывода параметров объекта
     */
    public $obj_prop_conf = 'no_conf';
    
    /**
     * @var type текущий шаблон вывода виджета
     */
    public $tpl = '';
    
    public function __construct($widget) {
        $this->thisWidgetName = $widget;
    }
    
    /**
     * Вывод виджета
     * @param type $item - массив данных шаблона, который приходит из контроллера модуля. Если не хотите передавать, можно не задавать, либо задать ''
     * @param type $param входные параметры (может быть массивом, либо переменной), если не задано, то запускается виджет без параметров. В параметрах может быть:
     * 'storage' - хранилище из которого будут забираться объекты, если не задано, то виджет не выводит ничего
     * 'folderid' - папка из которой будут выбираться объекты. Если не задано, то 1
     * 'list_main_alias' - основная часть URL на базе которой будет формироваться URL элемента списка хранилища добавляя туда язык, идентификатор и алиас
     * 'folder_start_id' - идентификатор корневой папки списка в хранилище (нужно чтоб корректно URL формировать)
     * 'list_max_items' - количество выводимых элементов, 0 - без ограничения
     * 'list_sort' - сортировка списка
     * 'only_first' - true|false выводить только объекты, выделенные свойством First (Гл)
     * 'filter_type' - ('objects'|'folders'|'all') - типы объектов связей (по-умолчанию objects), если не задано, то без фильтра ('all')
     * 'list_link' - ссылка на полный список объектов, если требуется
     * 'list_link_name' - анкор ссылки на полный список объектов, если требуется
     * 'altlang' - вывод на альтернативном языке
     * 'obj_prop_conf' - Массив конфигурации вывода параметров объекта. По-умолчанию строка 'no_conf' - параметры не выводятся
     * @param type $vidget_tpl название файла шаблона для вывода, если не задан, то используется текущий шаблон Glob::$vars['mnbv_tpl']/units/wdg_ВИДЖЕТ.php
     * @return string результат выполнения виджета
     */
    public function action_index($item=array(),$param=NULL,$vidget_tpl=''){
        if (empty($param)) return;

        if (!is_array($item)) $item = array();
        $this->param = $param;

        //Формирование массива параметров виджета-----------------------------------------
        if (!is_array($param)) return;
        if (empty($param['storage']) || !MNBVStorage::isStorage($param['storage'])) return; else $this->storage = $param['storage'];
        if (!empty($param['folderid'])) $this->folder = intval($param['folderid']);
        if (!empty($param['folder_start_id'])) $this->folder_start_id = intval($param['folder_start_id']);
        if (isset($param['list_max_items'])) $this->list_max_items = intval($param['list_max_items']);
        if (!empty($param['list_sort'])) $this->list_sort = $param['list_sort'];
        if (!empty($param['filter_type'])) $this->filter_type = $param['filter_type'];
        if (!empty($param['list_main_alias'])) $this->list_main_alias = $param['list_main_alias'];
        if (!empty($param['list_link'])) $this->list_link = $param['list_link'];
        $data_mode_light = false;
        if (!empty($param['data_mode']) && $param['data_mode']==='light') $data_mode_light = true;
        if (!empty($param['list_link_name'])) $this->list_link_name = $param['list_link_name'];
        if (isset($param['only_first'])) $this->only_first = (!empty($param['only_first']))?true:false;
        if (isset($param['obj_prop_conf']) && is_array($param['obj_prop_conf'])) $this->obj_prop_conf = $param['obj_prop_conf'];
        $vidget_alias = (!empty($param['vidget_alias']))?$param['vidget_alias']:'';

        $tplFile = MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'units/'.((!empty($vidget_tpl))?$vidget_tpl:'wdg_'.$this->thisWidgetName.'.php'));
        if(!file_exists($tplFile)) {
            SysLogs::addError('Error: Wrong widget template [' . $tplFile . ']');
            return;
        }
        $this->tpl = $tplFile;
        
        //Сведения о папке, которую выводим
        if ($folder = MNBVf::getStorageObject($this->storage,$this->folder,array('altlang'=>$item['mnbv_altlang'],'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден
            $this->folder_alias = SysBF::getFrArr($folder,'alias','');
            $folder['vars']['list_sort'] = $this->list_sort; //Принудительная установка типа сортировки
        } else {
            $folder['vars']['list_sort'] = $this->list_sort; //Принудительная установка типа сортировки
        }

        //Массив максимальных размеров приложенных изображений и роликов
        $item['img_max_size'] = MNBVf::getImgMaxSize($this->storage,Glob::$vars['img_max_size']);

        //Диапазон вывода
        $item['list_start_item'] = 0;
        $item['list_max_items'] = $this->list_max_items;

        //Формирование настроек списка: фильтров, сортировки, номеров страниц
        $quFilterArr = array('visible','=',1); //Фильтры
        if (!empty($this->folder)) array_push($quFilterArr,'and','parentid','=',intval($this->folder));
        if ($this->filter_type=='objects') array_push($quFilterArr,'and','type','!=',1);
        elseif ($this->filter_type=='folders') array_push($quFilterArr,'and','type','=',1);
        if (!empty($this->only_first)) array_push($quFilterArr,'and','first','=',1);

        $quConfArr = array();
        if (!empty($item['list_max_items'])) $quConfArr["limit"] = array($item['list_start_item'], $item['list_max_items']);

        //Сортировка списка------------------------------------------------------------
        $quConfArr["sort"] = array();
        $item['list_sort'] = '';
        $item['real_list_sort'] = (!empty($folder['vars']['list_sort']))?$folder['vars']['list_sort']:''; //Если задано на странице, берем от туда или ''
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
        //------------------------------------------------------------------------------

        //Список объектов
        if ($vidget_alias==='gormenucatalog' || $data_mode_light) {
            $cache = new MNBVCache();
            $item['list'] = $cache->get("gormenucatalog",true);
            if (!is_array($item['list']) || !empty(Glob::$vars['no_cache'])){ //Необходимо перегенерить кеш
                $item['list'] = MNBVStorage::getObjAcc($this->storage,
                    array("id","name","namelang","alias","type"),
                    $quFilterArr,$quConfArr);
                $item['list_size'] = (int)$item['list'][0]; unset($item['list'][0]); //Вынесем размер списка из массива
                $cache->set("gormenucatalog",$item['list'],Glob::$vars['gormenu_cache_ttl']);
            }else{
                $item['list_size'] = count($item['list']);
            }
        }else{
            $item['list'] = MNBVStorage::getObjAcc($this->storage,
                array("*"),
                $quFilterArr,$quConfArr);
            $item['list_size'] = (int)$item['list'][0]; unset($item['list'][0]); //Вынесем размер списка из массива
        }
        
        foreach ($item['list'] as $key=>$value) if ($key>0) {
            if (!empty($value["id"])) {

                //Формирование полей vars,attr объекта --------------------------------------------------------------------------
                $value['vars'] = (!empty($value['vars']))?SysBF::json_decode($value['vars']):array();
                $value['attr'] = (!empty($value['attr']))?SysBF::json_decode($value['attr']):array();
                $value['attrup'] = (!empty($value['attrup']))?SysBF::json_decode($value['attrup']):array();
                $value['attrvals'] = (!empty($value['attrvals']))?SysBF::json_decode($value['attrvals']):array();

                $value['folderid'] = $this->folder;
                $value["obj_storage"] = $this->storage;
                $value['use_other_storage'] = $this->storage;
                $value['page_main_alias'] = $this->list_main_alias;
                $value['folder_start_id'] = $this->folder_start_id;
                $value['folder_alias'] = $this->folder_alias;
                $item['list'][strval($key)]['files'] = (!empty($value['files']))?MNBVf::updateFilesArr($this->storage,$value["id"],$value['files']):array();
                if (Lang::isDefLang()){//Дефолтовый язык
                    $item['list'][strval($key)]['url'] = MNBVf::generateObjUrl($value); //Формирование URL из текущего адреса
                }else{//Альтернативный язык
                    $item['list'][strval($key)]['url'] = MNBVf::generateObjUrl($value,array('altlang'=>true)); //Формирование URL из текущего адреса
                    //Поправим имя, описание и текст в соответствии с altlang
                    if (!empty($value['namelang'])) $item['list'][strval($key)]['name'] = $value['namelang'];
                    $item['list'][strval($key)]['about'] = SysBF::getFrArr($value,'aboutlang','');
                }
                $item['list'][strval($key)]['obj_prop_arr'] = MNBVf::objPropGenerator($this->storage, $value, $this->obj_prop_conf, Lang::isAltLang(),'array');
                
                if ($this->storage==='products' && $vidget_alias!=='gormenucatalog' && !$data_mode_light){ //Для хранилища товаров посчитаем скидку подробнее в ProductsController.php
                    $discountParamsArr = array('user' => 'current','discmaxpr'=>$value["discmaxpr"],'discmaxval'=>$value["discmaxval"],'discminmargpr'=>$value["discminmargpr"],'discminmargval'=>$value["discminmargval"]);
                    $item['list'][strval($key)]['discount_price'] = MNBVDiscount::getPrice($value["id"], $value["price"],$value["cost"],$discountParamsArr);
                }
                
            }else{ //Косячная запись, удалим
                unset($item['list'][strval($key)]);
            }
        }

        $item['list_storage'] = $this->storage;
        $item['list_link'] = MNBVf::requestUrl(!Lang::isDefLang()?'altlang':'',$this->list_link);
        $item['list_link_name'] = $this->list_link_name;

        require $tplFile;
        
    }
    
}
