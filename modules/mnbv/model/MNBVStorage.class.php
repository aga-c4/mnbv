<?php
/**
 * Class MNBVStorage - класс работы с хранилищами MNBV
 * Хранилище - это контейнер для хранения объектов, который может быть реализован на различных типах баз данных
 * Для каждого типа БД может быть создано несколько хранилищ, по необходимости.
 * Важно использовать механизм хранилищ для работы с БД, т.к. здесь можно централизованно задать названия таблиц,
 * префиксы таблиц и др параметры структуры БД.
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVStorage{
    
    /**
     * @var type массив счетчиков количества и времени изполнения запросов разного вида. 
     */
    private static $stat = array(
        'all' => array(
            'add' => array('qty'=>0,'time'=>0),
            'set' => array('qty'=>0,'time'=>0),
            'get' => array('qty'=>0,'time'=>0),
            'del' => array('qty'=>0,'time'=>0),
        ),
        'mysql' => array(
            'add' => array('qty'=>0,'time'=>0),
            'set' => array('qty'=>0,'time'=>0),
            'get' => array('qty'=>0,'time'=>0),
            'del' => array('qty'=>0,'time'=>0),
        ),
        'mongodb' => array(
            'add' => array('qty'=>0,'time'=>0),
            'set' => array('qty'=>0,'time'=>0),
            'get' => array('qty'=>0,'time'=>0),
            'del' => array('qty'=>0,'time'=>0),
        ),
        'redis' => array(
            'add' => array('qty'=>0,'time'=>0),
            'set' => array('qty'=>0,'time'=>0),
            'get' => array('qty'=>0,'time'=>0),
            'del' => array('qty'=>0,'time'=>0),
        ),
        'file' => array(
            'add' => array('qty'=>0,'time'=>0),
            'set' => array('qty'=>0,'time'=>0),
            'get' => array('qty'=>0,'time'=>0),
            'del' => array('qty'=>0,'time'=>0),
        ),
        'array' => array(
            'add' => array('qty'=>0,'time'=>0),
            'set' => array('qty'=>0,'time'=>0),
            'get' => array('qty'=>0,'time'=>0),
            'del' => array('qty'=>0,'time'=>0),
        ),
    );
    
    /**
     * Возвращает массив статистики использования хранилищ
     * @return array массив со статистикой
     */
    public static function getStat(){
        return self::$stat;
    }

    /**
     * Получить список объектов системы или объект. Для того же действия с проверкой авторизации используем MNBVStorage::getObjAcc()
     * @param string $storage - хранилище. Если это строка, то выбор идет из конкретного хранилища, иначе хранилища задаются массивом 
     *                          типа array(array('join'=>['left'|'right'|''],'name'=>'название','alias'=>'алиас','on'=>array(аналог $filter)),...),
     *                          очередность влияет на размещение в запросе, первое хранилище join всегда пустой, т.к. к нему будем джойнить если что.
     *                          Если поле не задано, то оно считается равными ''. Обязательно задавать лишь 'name'.
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас") или строка '*' - вывести все поля.
     *                        поле может быть задано с алиасом хранилища "алиас.поле" в случае если мы будем использовать join или иной вывод из нескольких хранилищ.
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      'key' - название поля может задаваться как 'алиас.key' для указания поля из конкретного хранилища из запроса.
     *      Если нужно отключить экранирование значения, то ставим перед ним "field::"
     * @param array $conf - массив управляющих настроек
     *      $conf = array(
     *                  "group" => "поле", //поле для группировки
     *                  "countFoundRows" => false, //включить подсчет всех значений по-умолчанию false 
     *                  "sort" => array("key"=>"inc|desc"), //перечисляются ключи, последний может иметь маркер обратной сортировки
     *                  "limit" => array(первая_позиция , смещение), //массив содержащий позицию первого элемента и количество элементов
     *                  "connect" => "reconnect" - обновление соединения, "checkconnect" - проверить и если надо возобновить коннект., "nocheck" - не проверять реальный коннект, просто отдать линк (по-умолчанию)
     *              );
     * @param string $cache - если стоит 'cache', то включить кеширование (парамерты кеширования берем из настройки хранилища)
     * @param bool $accVal - маркер необходимости проводить проверку прав доступа из Glob::$vars['user']->get('permstr')
     * @return array массив, содержащий найденные объекты, 0 элемент массива всегда содержит колличество найденных объектов без учета ограничений limit!
     */
    public static function getObj($storage,$fields=array('*'),$filter=array(),$conf=array(),$cache='no-cache',$accVal=false){
        
        $timeStartFunct = SysBF::getmicrotime();
        
        //Выберем подходящий тип хранилища
        if (is_array($storage)){
            $mainStorage = strtolower($storage[0]['name']);
        }else{
            $mainStorage = strtolower($storage);
        }

        if (!empty(SysStorage::$storage["$mainStorage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $dbtype = SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'];
        }else{SysLogs::addError("No storage: $mainStorage");return array(0);}

        $cache = ($cache==='cache')?true:false; //Включить кеширование TODO - доработать систему кеширования запроса из базы.
        if (!is_array($filter)) $filter = array();
        if (!is_array($fields)) $fields = array('*');

        //В фильтры при необходимости добавим условие на проверку прав доступа
        if ($accVal && !Glob::$vars['user']->get('root')) array_push($filter,'and','access','in',MNBVf::getPermArr());

        $result = array(0);
        if     ($dbtype === 'mysql') $result =  MNBVMySQLSt::getObj($storage,$fields,$filter,$conf);
        elseif ($dbtype === 'mongodb') $result =  MNBVMongoSt::getObj($storage,$fields,$filter,$conf);
        elseif ($dbtype === 'redis') $result =  MNBVRedisSt::getObj($storage,$fields,$filter,$conf);
        elseif ($dbtype === 'file') $result =  MNBVFileSt::getObj($storage,$fields,$filter,$conf);
        elseif ($dbtype === 'array') $result =  MNBVArraySt::getObj($storage,$fields,$filter,$conf);
        
        if (SysLogs::$logsEnable) {
            $timeRunFunct = SysBF::getmicrotime()-$timeStartFunct;
            if (isset(self::$stat[$dbtype])) {
                self::$stat[$dbtype]['get']['qty']++;
                self::$stat[$dbtype]['get']['time'] += $timeRunFunct;
            }
        }
        
        return $result;

    }

    /**
     * То же что и getObj(), только с установленным ммаркером $accVal=true
     */
    public static function getObjAcc($storage,$fields=array('*'),$filter=array(),$conf=array(),$cache='no-cache'){
        return self::getObj($storage,$fields,$filter,$conf,$cache,true);
    }

    /**
     * Редактирование объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив полей и их значений для изменения в базе типа array('ключ'=>Значение)
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      Если нужно отключить экранирование значения, то ставим перед ним "field::"
     * @param bool $accVal - маркер необходимости проводить проверку прав доступа из Glob::$vars['user']->get('permstr')
     * @return bool - результат операции
     */
    public static function setObj($storage,$fields=array(),$filter=array(),$accVal=true){

        $timeStartFunct = SysBF::getmicrotime();

        //Выберем подходящий тип хранилища
        if (is_array($storage)){
            $mainStorage = strtolower($storage[0]['name']);
        }else{
            $mainStorage = strtolower($storage);
        }

        if (!empty(SysStorage::$storage["$mainStorage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $dbtype = SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'];
        }else{SysLogs::addError("No storage: $mainStorage");return array(0);}

        if (!is_array($filter))$filter = array();
        if (!is_array($fields))$fields = array();

        //В фильтры при необходимости добавим условие на проверку прав доступа
        if ($accVal && !Glob::$vars['user']->get('root')) array_push($filter,'and','access2','in',MNBVf::getPermArr());

        $result = array(0);
        if     ($dbtype === 'mysql') $result =  MNBVMySQLSt::setObj($storage,$fields,$filter);
        elseif ($dbtype === 'mongodb') $result =  MNBVMongoSt::setObj($storage,$fields,$filter);
        elseif ($dbtype === 'redis') $result =  MNBVRedisSt::setObj($storage,$fields,$filter);
        elseif ($dbtype === 'file') $result =  MNBVFileSt::setObj($storage,$fields,$filter);
        elseif ($dbtype === 'array') $result =  MNBVArraySt::setObj($storage,$fields,$filter);
        
        if (SysLogs::$logsEnable) {
            $timeRunFunct = SysBF::getmicrotime()-$timeStartFunct;
            if (isset(self::$stat[$dbtype])) {
                self::$stat[$dbtype]['set']['qty']++;
                self::$stat[$dbtype]['set']['time'] += $timeRunFunct;
            }
        }
        
        return $result;

    }

    /**
     * Добавление объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив полей и их значений для добавления в базу типа array('ключ'=>Значение)
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      Если нужно отключить экранирование значения, то ставим перед ним "field::"
     * @param bool $accVal - маркер необходимости проводить проверку прав доступа из Glob::$vars['user']->get('permstr')
     * @param bool $params - дополнительные параметры в частности тип добавления см потом в реализации мускула
     * @return mixed - если успешно, то id созданного объекта, иначе FALSE
     */
    public static function addObj($storage,$fields=array(),$filter=array(),$accVal=true,$params=array()){

        $timeStartFunct = SysBF::getmicrotime();

        //Выберем подходящий тип хранилища
        if (is_array($storage)){
            $mainStorage = strtolower($storage[0]['name']);
        }else{
            $mainStorage = strtolower($storage);
        }

        if (!empty(SysStorage::$storage["$mainStorage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $dbtype = SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'];
        }else{SysLogs::addError("No storage: $mainStorage");return array(0);}

        if (!is_array($filter))$filter = array();
        if (!is_array($fields))$fields = array();

        //В фильтры при необходимости добавим условие на проверку прав доступа
        if ($accVal && !Glob::$vars['user']->get('root') && !in_array(SysStorage::$storage["$storage"]["access2"],Glob::$vars['user']->get('permarr'))) return false;

        $result = array(0);
        if     ($dbtype === 'mysql') $result =  MNBVMySQLSt::addObj($storage,$fields,$filter,$params);
        elseif ($dbtype === 'mongodb') $result =  MNBVMongoSt::addObj($storage,$fields,$filter);
        elseif ($dbtype === 'redis') $result =  MNBVRedisSt::addObj($storage,$fields,$filter);
        elseif ($dbtype === 'file') $result =  MNBVFileSt::addObj($storage,$fields,$filter);
        elseif ($dbtype === 'array') $result =  MNBVArraySt::addObj($storage,$fields,$filter);
        
        if (SysLogs::$logsEnable) {
            $timeRunFunct = SysBF::getmicrotime()-$timeStartFunct;
            if (isset(self::$stat[$dbtype])) {
                self::$stat[$dbtype]['add']['qty']++;
                self::$stat[$dbtype]['add']['time'] += $timeRunFunct;
            }
        }
        
        return $result;
    }


    /**
     * Удаляет из заданного хранилища объекты, соответствующие фильтру
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      Если нужно отключить экранирование значения, то ставим перед ним "field::"
     * @param bool $accVal - маркер необходимости проводить проверку прав доступа из Glob::$vars['user']->get('permstr')
     * @return bool - результат операции
     */
    public static function delObj($storage,$filter=array(),$accVal=true){

        $timeStartFunct = SysBF::getmicrotime();

        //Выберем подходящий тип хранилища
        if (is_array($storage)){
            $mainStorage = strtolower($storage[0]['name']);
        }else{
            $mainStorage = strtolower($storage);
        }

        if (!empty(SysStorage::$storage["$mainStorage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $dbtype = SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'];
        }else{SysLogs::addError("No storage: $mainStorage");return array(0);}

        if (!is_array($filter))$filter = array();

        //В фильтры при необходимости добавим условие на проверку прав доступа
        if ($accVal && !Glob::$vars['user']->get('root')) array_push($filter,'and','access2','in',MNBVf::getPermArr());

        $result = array(0);
        if     ($dbtype === 'mysql') $result =  MNBVMySQLSt::delObj($storage,$filter);
        elseif ($dbtype === 'mongodb') $result =  MNBVMongoSt::delObj($storage,$filter);
        elseif ($dbtype === 'redis') $result =  MNBVRedisSt::delObj($storage,$filter);
        elseif ($dbtype === 'file') $result =  MNBVFileSt::delObj($storage,$filter);
        elseif ($dbtype === 'array') $result =  MNBVArraySt::delObj($storage,$filter);
        
        if (SysLogs::$logsEnable) {
            $timeRunFunct = SysBF::getmicrotime()-$timeStartFunct;
            if (isset(self::$stat[$dbtype])) {
                self::$stat[$dbtype]['del']['qty']++;
                self::$stat[$dbtype]['del']['time'] += $timeRunFunct;
            }
        }
        
        return $result;
    }

    /**
     * Проверка существования данного хранилища
     * @param string $storage - хранилище
     * @return bool - результат операции
     */
    public static function checkStorage($storage){

        //Выберем подходящий тип хранилища
        if (is_array($storage)){
            $mainStorage = strtolower($storage[0]['name']);
        }else{
            $mainStorage = strtolower($storage);
        }

        if (!empty(SysStorage::$storage["$mainStorage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $dbtype = SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'];
        }else{SysLogs::addError("No storage: $mainStorage");return array(0);}

        if     ($dbtype === 'mysql') return MNBVMySQLSt::checkStorage($storage);
        elseif ($dbtype === 'mongodb') return MNBVMongoSt::checkStorage($storage);
        elseif ($dbtype === 'redis') return MNBVRedisSt::checkStorage($storage);
        elseif ($dbtype === 'file') return MNBVFileSt::checkStorage($storage);
        elseif ($dbtype === 'array') return MNBVArraySt::checkStorage($storage);
        else return false;
    }
    
    /**
     * Проверка наличия данного хранилища в массиве хранилищ
     * @param string $storage - алиас хранилища
     * @return bool - результат операции
     */
    public static function isStorage($storage){
        if (isset(SysStorage::$storage[strtolower($storage)])) return true;
        return false;
    }

    /**
     * Создает хранилище, если оно не создано
     * @param string $storage - хранилище
     * @return bool - результат операции
     */
    public static function createStorage($storage){

        //Выберем подходящий тип хранилища
        if (is_array($storage)){
            $mainStorage = strtolower($storage[0]['name']);
        }else{
            $mainStorage = strtolower($storage);
        }

        if (!empty(SysStorage::$storage["$mainStorage"]["db"])&&!empty(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'])&&in_array(SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'],SysStorage::$dbtypes)){
            $dbtype = SysStorage::$db[SysStorage::$storage["$mainStorage"]["db"]]['dbtype'];
        }else{SysLogs::addError("No storage: $mainStorage");return array(0);}

        if     ($dbtype === 'mysql') return MNBVMySQLSt::createStorage($storage);
        elseif ($dbtype === 'mongodb') return MNBVMongoSt::createStorage($storage);
        elseif ($dbtype === 'redis') return MNBVRedisSt::createStorage($storage);
        elseif ($dbtype === 'file') return MNBVFileSt::createStorage($storage);
        elseif ($dbtype === 'array') return MNBVArraySt::createStorage($storage);
        else return false;
    }
    
    /**
     * Подготавливает служебные массивы, определяющие вывод атрибутов
     * @param type $attrup данные из $item["attrup"] список полей атрибутов вышестоящего раздела.
     * @return array ("attrview"=> array(),"attrviewmini" => array(),);
     */
    public static function getAttrViewArr ($attrup){
        /*
        $cache = new MNBVCache();
        $attrFiltersCacheStr = $cache->get("prodfilters:$folderId");
        //echo "(prodfilters:$folderId=>[$attrFiltersCacheStr])";
        if ($attrFiltersCacheStr!==null && empty(Glob::$vars['no_cache'])){ //Кеш приемлем, используем и нет жесткой блокировки его работы
            $attr_filters = json_decode($attrFiltersCacheStr,TRUE);
        } else{ //Кеш протух или не существует
            $attr_filters = MNBVf::objFilterGenerator('attributes',$realFolder,array('folderid'=>(!empty($folderId))?$folderId:Glob::$vars['prod_storage_rootid'])); //Специально без выделения пунктов, чтоб можно было закешировать.
            $attr_filtersstr = json_encode($attr_filters,TRUE);
            $cache->set("prodfilters:$folderId",$attr_filtersstr,Glob::$vars['prod_filters_cache_ttl']);
        }
        */  
        $result = array(
            "attrview" => array(),
            "attrviewmini" => array(),
        );

        if (!is_array($attrup)) return $result;

        $sortArr = $resultAttrview = $resultAttrviewmini = array();
        foreach($attrup as $attrStru){
            if (is_array($attrStru)){
                $storageRes = MNBVStorage::getObj('attributes',
                    array("id","vars","name","namelang"),
                    array("id",'=',$attrStru["attrid"]));
                $avarr = ($storageRes[0]>0)?$storageRes[1]:null;
                if ($avarr===null)continue;

                if (!empty($avarr['vars'])) $avarr['vars'] = SysBF::json_decode($avarr['vars']);
                $avarr['vars'] = SysStorage::updateViewArr($avarr['vars']);

                $avarr['vars']["pozid"] = $attrStru["pozid"]; //Заберем позицию сюда
                $avarr['vars']["inshort"] = (!empty($attrStru["inshort"]))?true:false;
                $avarr['vars']["name"] = "attr".$avarr["id"]; //Техническое название
                $avarr['vars']["namedef"] = (!empty($avarr["name"]))?$avarr["name"]:$avarr['vars']["name"]; //Название на дефолтовом языке
                $avarr['vars']["namelang"] = (!empty($avarr["namelang"]))?$avarr["namelang"]:$avarr['vars']["namedef"]; //Название на альтернативном языке

                $sortArr[$avarr['vars']["name"]] = $avarr['vars']["pozid"]; //Массив для последующей сортировки по позиции
                $resultAttrview[$avarr['vars']["name"]] = $avarr['vars']; //Массив с полями атрибутов
                if ($avarr['vars']["inshort"]) $resultAttrviewmini[$avarr['vars']["name"]] = $avarr['vars'];
            }
        }
        
        //Отсортируем выдачу по позциям
        asort($sortArr);
        foreach ($sortArr as $key=>$value) {
            $result["attrview"]["$key"] = $resultAttrview["$key"];
            if ($resultAttrview["$key"]["inshort"]) $result["attrviewmini"]["$key"] = $resultAttrviewmini["$key"];
        }
        
        
        
        return $result;

    }

    /**
     * Возвращает истинное размещение директории приложенных файлов относительно корня проекта
     * @param string $storage - хранилище
     * @param $obj_id - идентификатор объекта
     * @param $slot_type - тип слота (img/att)
     * @param $slot_id - номер слота (int)
     * @param $type - тип файла (расширение)
     * @param $size - размер файла main - основная / min - превью / big - большая картинка
     * @return bool|string - путь к файлу или false, если ошибка.
     */
    public static function getRealFileName($storage,$obj_id,$slot_type,$slot_id,$type,$size='main'){
        //Подготовим данные:
        $storage = strtolower($storage);
        $obj_id = intval($obj_id);
        $slot_type = ($slot_type=='img'||$slot_type=='att')?$slot_type:'';
        $slot_id = intval($slot_id);
        $type = (!empty(Glob::$vars['file_types']["$type"]))?$type:'';
        if ($size=='min' || $size=='big') $sizeTxt = '_'.$size; else $sizeTxt = '';

        if (!empty(SysStorage::$storage["$storage"]["db"]) && !empty($obj_id) && !empty($slot_type) && !empty($slot_id) && !empty($type))
            return APP_STORAGEFILESPATH.$storage.'/'.$slot_type.'/p'.$obj_id.'_'.$slot_id.$sizeTxt.'.'.$type;
        else
            SysLogs::addError("MNBVStorage::getRealFileName Error: storage=".$storage.'/slot_type='.$slot_type.'/obj_id='.$obj_id.'/slot_id='.$slot_id.'/type='.$type);return null;
    }

    /**
     * Возвращает размещение директории приложенных файлов для отображения на сайте
     * @param string $storage - хранилище
     * @param $obj_id - идентификатор объекта (int)
     * @param $slot_type - тип слота (img/att)
     * @param $slot_id - номер слота (int)
     * @param $type - тип файла (расширение)
     * @param $size - размер файла файла (normal|min|big) normal по-умолчанию
     * @param $upldate - (строка) вывести юникс дату, чтоб обновилось изображение
     * @return bool|string - путь к файлу или false, если ошибка.
     */
    public static function getFileName($storage,$obj_id,$slot_type,$slot_id,$type,$size='normal',$upldate=''){
        //Подготовим данные:
        $storage = strtolower($storage);
        $obj_id = intval($obj_id);
        $slot_type = ($slot_type=='img'||$slot_type=='att')?$slot_type:'';
        $slot_id = intval($slot_id);
        $type = (!empty(Glob::$vars['file_types']["$type"]))?$type:'';
        $sizeStr = '';
        if (empty($size)) $size = 'normal';
        if ($size=='min') $sizeStr = '_min';
        elseif ($size=='big') $sizeStr = '_big';

        if (!empty(SysStorage::$storage["$storage"]["db"]) && !empty($obj_id) && !empty($slot_type) && !empty($slot_id) && !empty($type)){
            $res = ((!empty(Glob::$vars['mnbv_site']['filesdomain']))?Glob::$vars['mnbv_site']['filesdomain']:'') . ((!empty(SysStorage::$storage["$storage"]["files_security"]))?MNBV_WWW_DATAPATH_SEC:MNBV_WWW_DATAPATH) . $storage . '/' . $slot_type . '/p' . $obj_id . '_' . $slot_id . $sizeStr . '.' . $type;
            if (!empty($upldate)) $res .= '?ud='.$upldate;
            return $res;
        }
        
        SysLogs::addError("MNBVStorage::getFileName Error: storage=".$storage.'/slot_type='.$slot_type.'/obj_id='.$obj_id.'/slot_id='.$slot_id.'/type='.$type);
        return null;

    }

    /**
     * Берет URL любой. отрезает от него все лишнее и выделяет расширение файла
     * @param string $url
     * @return mixed
     */
    public function validateFileType($storage,$type='',$slot_type=''){
        if (SysBF::getFrArr(Glob::$vars['file_types'],"$type")===null) return false;
        $result = false;
        if (!isset(SysStorage::$storage["$storage"]["files_types"]) || SysStorage::$storage["$storage"]["files_types"]=='all') $result = true;
        if (!$result && (!isset(SysStorage::$storage["$storage"]["files_types"]["$slot_type"]) || SysStorage::$storage["$storage"]["files_types"]["$slot_type"]=='all' || in_array($type,SysStorage::$storage["$storage"]["files_types"]["$slot_type"]))) $result = true;
        return $result;
    }
    
    /**
     * Выгружает файл на другой сервер идентификатор сервера определяется по настройкам хранилища или еще как нибудь.
     * @param $source - путь к файлу
     * @param string $storage - хранилище
     * @param $obj_id - идентификатор объекта
     * @param $slot_type - тип слота (img/att)
     * @param $slot_id - номер слота (int)
     * @return bool - результат операции.
     */
    public static function sendFile($source,$storage,$obj_id,$slot_type,$slot_id){
        return true;
    }
    
    /**
     * Сообщает другому серверу, что ему надо удалить файл. Идентификатор сервера определяется по настройкам хранилища или еще как нибудь.
     * @param string $storage - хранилище
     * @param $obj_id - идентификатор объекта
     * @param $slot_type - тип слота (img/att)
     * @param $slot_id - номер слота (int)
     * @return bool - результат операции.
     */
    public static function sendRemoveFile($storage,$obj_id,$slot_type,$slot_id){
        return true;
    }
    
    /**
     * Получение данных по вышестоящему объекту
     * @param $objArr {"id"=>int/string, "upfolders"=>string, "attrup"=>string, "attr"=>string}
     * @param $typeinp - строка содержащая тип входных данных('string' - строка (по-умолчанию), 'array' - массив). Необязательный параметр
     * @param $typeout - строка содержащая тип выходных данных('string' - строка (по-умолчанию), 'array' - массив). Необязательный параметр
     * @param $dnuse - включать в атрибуты только те, у которых есть метка dnuse по-умолчанию true.
     * @return array
     */
    public static function upObjInfo($objArr,$typeinp='string',$typeout='string',$dnuse=true){

        $result = array("upfolders"=>array(),"attrup"=>array());

        //Если не задан id объекта, то выводим пустые значения
        if (empty($objArr["id"])) {
            if ($typeout==='string') return array("upfolders"=>"","attrup"=>"");
            else return $result;
        }
        
        $result["id"] = $objArr['id'];

        if (!empty($objArr['upfolders'])){
            if ($typeinp==='string') $upfolders = json_decode($objArr['upfolders'],true);
            else $upfolders = $objArr['upfolders'];
        }
        if (empty($upfolders)) $upfolders = array();
        $upfolders[] = $objArr["id"];
        if ($typeout==='string') $result["upfolders"] = json_encode($upfolders);
        else $result["upfolders"] = $upfolders;

        if (!empty($objArr['attr'])){
            if ($typeinp==='string') $attr = json_decode($objArr['attr'],true);
            else $attr = $objArr['attr'];
        }
        if (empty($attr)) $attr = array();

        if (!empty($objArr['attrup'])){
            if ($typeinp==='string') $attrup = json_decode($objArr['attrup'],true);
            else $attrup = $objArr['attrup'];
        }
        if (empty($attrup)) $attrup = array();

        foreach($attr as $value) if (!$dnuse || !empty($value["dnuse"])) $attrup[] = $value;
        
        if ($typeout==='string') $result["attrup"] = (count($attrup)>0)?json_encode($attrup):'';
        else $result["attrup"] = $attrup;
        
        if (isset($objArr["alias"])) $result["alias"] = $objArr["alias"];        
        //SysLogs::addLog("------------>objArr={'alias':'{$objArr["alias"]}', 'id':'{$objArr["id"]}'}");
        //SysLogs::addLog("------------>objArr=[".print_r($objArr)."]");
        
        return $result;
    }

} 