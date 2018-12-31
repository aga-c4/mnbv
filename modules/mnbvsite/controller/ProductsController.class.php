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
        
        //Хранилище и папка по-умолчанию
        $storage = Glob::$vars['mnbv_site']['storage']; //Текущее хранилище
        $realFolder = $item['obj'];
        $item['obj']['use_other_storage'] = '';
        $item['obj']['page_main_alias'] = ''; //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
        $item['obj']['folder_start_id'] = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):1;
        $item['obj']['folderid'] = $folderId = $item['id'];
        $item['obj']['folder_alias'] = $item['obj']['alias'];

        //Выбор хранилища и при необходимости перечитаем сведения о папке, которую выводим
        if (!empty($item['obj']['vars']['script_storage']) and (MNBVStorage::isStorage($item['obj']['vars']['script_storage']))) {
            //Привязанное хранилище существует
            $storage2 = $item['obj']['vars']['script_storage'];
            
            if (!empty(Glob::$vars['mnbv_site']['sub_list_id'])){//Есть номера субобъектов
                $folderId2 = intval(Glob::$vars['mnbv_site']['sub_list_id']);
            } elseif (!empty($item['obj']['vars']['script_folder'])){ //Попробуем найти корневой объект для вывода
                $folderId2 = intval($item['obj']['vars']['script_folder']);
            }

            if (!empty($folderId2) && $realFolder = MNBVf::getStorageObject($storage2,$folderId2,array('altlang'=>$item['mnbv_altlang'],'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден
                $storage = $storage2;
                $folderId = $folderId2;
                $realFolder['parent']['use_other_storage'] = $storage;
                $item['obj']['use_other_storage'] = $storage; //Маркер, что работаем с другим хранилищем
                $item['obj']['page_main_alias'] = (!empty($item['obj']['alias']))?('/'.$item['obj']['alias']):('/id'.$item['obj']['id']); //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
                $item['obj']['folder'] = $realFolder;
                $item['obj']['folderid'] = $realFolder['id'];
                $item['obj']['folder_alias'] = (!empty($realFolder['alias']))?$realFolder['alias']:'';
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

        //Сортировка списка------------------------------------------------------------
        $quConfArr["sort"] = array();
        $item['list_sort'] = '';
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
        //------------------------------------------------------------------------------

        
        //Список объектов
        $item['list'] = MNBVStorage::getObjAcc($storage,
                array("id","parentid","pozid","type","typeval","visible","access","access2","first","name","namelang","about","aboutlang","vars","files","siteid","date","alias",'oldprice','price'),
                $quFilterArr,$quConfArr);
        $item['list_size'] = (int)$item['list'][0]; unset($item['list'][0]); //Вынесем размер списка из массива 
        foreach ($item['list'] as $key=>$value) if ($key>0) {
            if (!empty($value["id"])) {
                if (!empty($item['obj']['use_other_storage']) && isset($item['obj']['page_main_alias'])) {
                    $value['use_other_storage'] = $storage;
                    $value['page_main_alias'] = $item['obj']['page_main_alias'];
                    $value['folder_start_id'] = $item['obj']['folder_start_id'];
                    $value['folderid'] = $item['obj']['folderid'];
                    $value['folder_alias'] = $item['obj']['folder_alias'];
                }
                $item['list'][strval($key)]['files'] = (!empty($value['files']))?MNBVf::updateFilesArr($storage,$value["id"],$value['files']):array();
                if (Lang::isDefLang()){//Дефолтовый язык
                    $item['list'][strval($key)]['url'] = MNBVf::generateObjUrl($value); //Формирование URL из текущего адреса
                }else{//Альтернативный язык
                    $item['list'][strval($key)]['url'] = MNBVf::generateObjUrl($value,array('altlang'=>true)); //Формирование URL из текущего адреса
                    //Поправим имя, описание и текст в соответствии с altlang
                    if (!empty($value['namelang'])) $item['list'][strval($key)]['name'] = $value['namelang'];
                    $item['list'][strval($key)]['about'] = SysBF::getFrArr($value,'aboutlang','');
                }
                //Расчитаем цену со скидкой. У жестко забитого oldprice - приоритет.
                $item['list'][strval($key)]['discount_price'] = MNBVDiscount::getPrice($value["id"], $value["price"]);
            }else{ //Косячная запись, удалим
                unset($item['list'][strval($key)]);
            }
        }
        
        $item['page_list_url'] = MNBVf::generateObjUrl($item['obj'],array('altlang'=>Lang::isAltLang(),'type'=>'list'));
        
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
            if (!empty($item['obj']['folderid']) && $item['obj']['folderid']!=$item['obj']['folder_start_id']) {
                $item['obj']['up_folder_url'] = MNBVf::generateObjUrl($realFolder['parent'],array('altlang'=>Lang::isDefLang()));
                $item['obj']['nav_arr'][4] = array('name'=>$item['obj']['folder_name'],'url'=>$item['obj']['up_folder_url']); //Текущая папка
                SysLogs::addLog("Product controller: nav4=[".$item['obj']['folder_name']."]");
            }
            //Текущий объект
            $item['obj']['nav_arr'][5] = array('name'=>$realFolder['name'],'url'=>$item['page_url']);
            SysLogs::addLog("Product controller: nav5=[".$realFolder['name']."]");
        }
        //Конец обработки хлебных крошек ---------------------------------------
        
        
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
            'id' => 'id', //сортировка по id объекта
            'id_desc' => 'id_desc', //сортировка по id объекта по убыванию
            'date' => 'date', //сортировка по date объекта
            'date_desc' => 'date_desc', //сортировка по date объекта по убыванию
            'pozid' => 'pozid', //сортировка по позиции объекта, названию
            'name' => 'name', //сортировка по полю name не важно включен альтернативный язык или нет
            'name_desc' => 'name_desc', //сортировка по полю name не важно включен альтернативный язык или нет
        );
        //----------------------------------------------------------------------


        //Настройки номеров страниц---------------------------------------------
        $item['page_list_num_conf'] = array(
        'list_size' => $item['list_size'],
        'list_max_items' => $item['list_max_items'],
        'list_sort' => $item['list_sort'],
        'list_page' => $item['list_page'],
        'centre_bl' => 5);
        //----------------------------------------------------------------------
        

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
        $realObject = $item['obj'];
        $realObjectId = $item['id'];
        $item['obj']['use_other_storage'] = '';
        $item['obj']['page_main_alias'] = ''; //Задается только если производится вывод из неосновного хранилища для правильного формирования URL
        $item['obj']['folder_start_id'] = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):1;
        $item['obj']['folderid'] = $item['obj']['parent_id'];
        $item['obj']['folder_name'] = $item['obj']['parent_name'];
        $item['obj']['folder_alias'] = (!empty($item['obj']['parent']['alias']))?$item['obj']['parent']['alias']:'';

        //Выбор хранилища и при необходимости перечитаем сведения о папке, которую выводим-------------
        if (!empty($item['obj']['vars']['script_storage']) and (MNBVStorage::isStorage($item['obj']['vars']['script_storage']))) {
            //Привязанное хранилище существует
            $storage2 = $item['obj']['vars']['script_storage'];
            $objectId2 = (!empty(Glob::$vars['mnbv_site']['sub_id']))?intval(Glob::$vars['mnbv_site']['sub_id']):0;

            if (!empty($objectId2) && $realObject = MNBVf::getStorageObject($storage2,$objectId2,array('altlang'=>$item['mnbv_altlang'],'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден
                $storage = $storage2;
                $realObjectId = $objectId2;
                $realObject['parent']['use_other_storage'] = $storage;
                $item['obj']['use_other_storage'] = $storage; //Маркер, что работаем с другим хранилищем
                $item['obj']['folderid'] = $realObject['parent_id'];
                $item['obj']['folder_name'] = $realObject['parent_name'];
                $item['obj']['folder_alias'] = (!empty($realObject['parent']['alias']))?$realObject['parent']['alias']:'';
                $item['obj']['page_main_alias'] = (!empty($item['obj']['alias']))?('/'.$item['obj']['alias']):('/id'.$item['obj']['id']); //Задается только если производится вывод из неосновного хранилища для правильного формирования URL       
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

        //Поправим имя, описание и текст в соответствии с altlang
        if (!Lang::isDefLang()){
            if (!empty($realObject['namelang'])) $realObject['name'] = $realObject['namelang'];
            if (!empty($realObject['aboutlang'])) $realObject['about'] = $realObject['aboutlang'];
            if (!empty($realObject['textlang'])) $realObject['text'] = $realObject['textlang'];
        }
        //------------------------------------------------------------------------------
        
        //Расчитаем цену со скидкой-----------------------------------------------------
        $realObject['discount_price'] = MNBVDiscount::getPrice($realObject["id"], $realObject["price"]);  
        //------------------------------------------------------------------------------

        //Метатеги----------------------------------------------------------------------
        Glob::$vars['page_title'] = (!empty($realObject['vars']['title']))?$realObject['vars']['title']:((!empty($realObject['name']))?$realObject['name']:'');
        Glob::$vars['page_keywords'] = (!empty($realObject['vars']['title']))?$realObject['vars']['keywords']:'';
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
                $item['obj']['up_folder_url'] = MNBVf::generateObjUrl($realObject['parent'],array('altlang'=>Lang::isDefLang()));
                $item['obj']['nav_arr'][4] = array('name'=>$item['obj']['folder_name'],'url'=>$item['obj']['up_folder_url']); //Текущая папка
            }
            //Текущий объект
            $item['obj']['nav_arr'][5] = array('name'=>$realObject['name'],'url'=>$item['page_url']);
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

        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl2_file'],$item,$tpl_mode);
        
    }
        
}
