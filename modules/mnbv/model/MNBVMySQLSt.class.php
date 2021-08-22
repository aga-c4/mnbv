<?php
/**
 * Библиотека MNBV для работы с хранилищем типа MySql
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVMySQLSt implements MNBVdefSt{
    
    /**
     * @var int максимальное количество уровней вложения при обработки массива where 
     */
    public static $maxFilterIterations = 10;

     /**
     * Преобразует строку, экранируя кавычки и др. символы, мешающие рабое с бд.
     * @param string $str - исходная строка
     * @param string $type - тип значения обычный '' (по-умолчанию) или 'like' для фильтрации поиска типа like 
     * @param mixed $dbLink - линк к базе данных для mysqli_real_escape_string, если не задан, то фильтруем addslashes
     * @return string результат операции
     */
    public static function codeStr($str,$type='',$dbLink=''){
        if (!is_string($str)) return $str;
        $res = $str;
        //$res=preg_replace("/`/u","&#96;",$res);
        //$res=preg_replace("/’/u","&#39;",$res);
        //$res=preg_replace("/'/u","&#39;",$res);
        
        if ($dbLink==='') {
            $res = addslashes($res);
        } else {
            $res = $dbLink->mysql_real_escape_string($res);
        }
        
        if ($type=='like') {
            $res = addCslashes($res, '\%_'); //преобразование для условия типа like
        }
        
        return $res;
    }
    
    /**
     * Приводит строку в нормальный вид
     * @param string $str - исходная строка
     * @return string результат операции
     */
    public static function decodeStr($str){
        $res = $str;
        //stripslashes($str);
        //$res=preg_replace('/&#96;/u',"`",$res);
        //$res=preg_replace('/&#39;/u',"'",$res);
        die (var_dump($res));
        return $res;
    }
    
    /**
     * Формирует строку WHERE
     * @staticvar int $numIterations текущая итерация
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      Если нужно отключить экранирование значения, то ставим перед ним "field::"
     * Примеры подзапросов для in или not in: 
     * array("select","objid","from",SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],"where",array("attrid","=","$key","and","vint","in",$value["vals"]))
     * array("select","objid","from",SysStorage::$storage[Glob::$vars['prod_storage']]['arrtindexuse'],"where",array("attrid","=","$key","and","vint",">=",$value["vals"][0],"and","vint","<=",$value["vals"][1]))  
     * @param mixed $dbLink - линк к базе данных для mysqli_real_escape_string, если не задан, то фильтруем addslashes
     * @return boolean|string
     */
    public static function createWhereStr($filter,$dbLink=''){

        if (!is_array($filter)) return $filter; //Можно напрямую строку мускула задать (вдальнейшем надо сделать парсер строки для работы в  других типах БД

        static $numIterations = 0; //Счетчик количества итераций
        $numIterations++;
        if ($numIterations > self::$maxFilterIterations) {
            SysLogs::addError('Error MNBVMySQLSt::createWhereStr to big iterations = ['.$numIterations.'>'.self::$maxFilterIterations.']!');
            $numIterations--;
            return false;
        }

        //Поправим ключи массива, чтоб убрать пробелы
        $filter2 = array();
        foreach ($filter as $value) $filter2[]=$value;
        $filter = $filter2;

        $whereStr = '';
        $filterArrSize = count($filter);
        $key = 0;
        while($key<$filterArrSize){

            if (!is_array($filter[$key])){
                $lop = strtolower(trim($filter[$key]));
                if (in_array($lop,array('and','&&','or','||','(',')'))) {
                    $whereStr .= " $lop"; $key++; 
                    continue;
                }
            }


            //проверим на массив
            if (is_array($filter[$key])){
                $res = self::createWhereStr($filter[$key],$dbLink);
                if ($res===false){
                    $numIterations--;
                    return false;
                }
                $whereStr .= " (".$res.")";
                $key++;
                continue;
            }

            $field = $filter[$key]; $wStr = " " . $field; $key++;

            $op = strtolower(trim($filter[$key]));
            if (in_array($op,array('=','!=','in','not in','>','<','>=','<=','like'))){//Корректный оператор
                $wStr .= " $op";
            }else{
                SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad operator['.$op.'] key=['.$key.'], Iteration = ['.$numIterations.']!');
                $numIterations--;
                return false;
            }
            $key++;

            //Должен идти массив перечислений
            if ($op=='in' || $op=='not in'){
                if (!is_array($filter[$key])){
                    SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad in array field=['.$field.'] key=['.$key.'], Iteration = ['.$numIterations.']!');
                    $numIterations--;
                    return false;
                }
                if (!count($filter[$key])){
                    $wStr = ' 1=0';
                }else{
                    $wStr .= " (";
                    $inStr = '';
                    if (strtolower(trim($filter[$key][0]))==='select'){ //Вариант с подзапросом
                        //Примеры подзапросов для in или not in: 
                        //array("select","objid","from","storage_alias","where",array("attrid","=","$key","and","vint","in",$value["vals"],"group","objid"))
                        //array("select","objid","from","storage_alias","where",array("attrid","=","$key","and","vint",">=",$value["vals"][0],"and","vint","<=",$value["vals"][1]))  
                        //select id,name from mnbv_products where
                        //id in (select objid from mnbv_attrvals where vint in (20,21) and attrid=17 group by objid) 
                        //and id in (select objid id from mnbv_attrvals where vint>30000 and vint<60000 and attrid=3 group by objid);   
                        if (strtolower($filter[$key][0])==='select'
                                && !empty($filter[$key][1]) 
                                && strtolower($filter[$key][2])==='from'
                                && !empty($filter[$key][3]) && !empty(SysStorage::$storage[strtolower($filter[$key][3])])
                                && is_array($filter[$key][5]) && count($filter[$key][5])
                                ){
                            
                            $inStr .= 'select '.$filter[$key][1].' from '.SysStorage::$storage[strtolower($filter[$key][3])]['table'].' where ';
                            
                            //проверим на массив
                            $res = self::createWhereStr($filter[$key][5],$dbLink);
                            if ($res!==false){
                                $inStr .= $res;
                            }
                        }else{//Выражение не сложилось, сделаем невыполнимое условие
                            $wStr = ' 1=0';
                        }
                    }else{ //Обычное перечисление
                        foreach($filter[$key] as $inArr) $inStr .= (($inStr!='')?', ':'')."'".self::codeStr($inArr,'',$dbLink)."'";
                    }
                    $wStr .= $inStr . ")";
                }
            }else{
                if (0===stripos($filter[$key],'field::')){ //Вариант без экранирования
                    $curVal = substr($filter[$key],7);
                    $wStr .= " " . $curVal;
                }else{ //Вариант с экранированием
                    $wStr .= " '".self::codeStr($filter[$key],'',$dbLink)."'";
                }
            }
            
            $whereStr .= $wStr;
            $key++;

        }

        $numIterations--;
        return $whereStr;
    }

    /**
     * Получить список объектов хранилища или объект, если задан его идентификатор
     * @param string $storage - хранилище. Если это строка, то выбор идет из конкретного хранилища, иначе хранилища задаются массивом 
     *                          типа array(array('join'=>['left'|'right'|'base'|''],'name'=>'название','alias'=>'алиас','on'=>array(аналог $filter)),...),
     *                          очередность влияет на размещение в запросе, первое хранилище join должен быть всегда пустым, т.к. к нему будем джойнить если что.
     *                          Если поле не задано, то оно считается равными ''. Обязательно задавать лишь 'name'.
     *                          Внимание!!! Джойнить можно только хранилища, находящиеся в той же БД, что и первое хранилище, иначе будет ошибка!!!
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас") или строка '*' - все
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     * @param array $conf - массив управляющих настроек
     *      $conf = array(
     *                  "group" => "поле", //поле для группировки
     *                  "countFoundRows" => false, //включить подсчет всех значений по-умолчанию false 
     *                  "sort" => array("key"=>"inc|desc"), //перечисляются ключи, последний может иметь маркер обратной сортировки
     *                  "limit" => array(первая_позиция , смещение), //массив содержащий позицию первого элемента и количество элементов
     *                  "connect" => "reconnect" - обновление соединения, "checkconnect" - проверить и если надо возобновить коннект., "nocheck" - не проверять реальный коннект, просто отдать линк (по-умолчанию)
     *              );
     * @return array массив, содержащий найденные объекты, 0 элемент массива всегда содержит колличество найденных объектов без учета ограничений limit!
     */
    public static function getObj($storage,$fields=array('*'),$filter=array(),$conf=array()){
        
        $colcol = 0; $result = array($colcol); //Результат операции
        
        if (!is_array($storage)) $storage = array(array('name'=> strval($storage))); //Приведем к универсальному виду

        $main_storage = ''; //Базовое хранилище к которому могут джойниться остальные, эта схема отработает с ошибкой, если остальные находятся в другой БД.
        $myDb = '';

        //Надо ли считать количество строк
        $sqlFlags = '';$connectStatus = "nocheck";
        if (!empty($conf["countFoundRows"])) $sqlFlags .= ' SQL_CALC_FOUND_ROWS';
        if (!empty($conf["connect"])) $connectStatus = $conf["connect"];

        $fromStr = ' FROM';
        foreach ($storage as $value) {

            //Построим строку таблиц
            if (empty($value['name'])) return array(0); //Нет названия таблицы, в первом элементе

            if (!empty(SysStorage::$storage[$value['name']]["table"])) $mysqlTable = SysStorage::$storage[$value['name']]["table"]; else return array(0); //Таблица

            if ($fromStr == ' FROM') {
                $main_storage = $value['name'];
                $myDb = SysStorage::getLink($main_storage,$connectStatus);
                if ($myDb===null) return array(0); //Если линка нет, то возвращаем пустой ответ
            }

            if (!empty($value['join'])) {
                if ($value['join']=='base') $fromStr .= ' JOIN';
                elseif ($value['join']=='left') $fromStr .= ' LEFT JOIN';
                elseif ($value['join']=='right') $fromStr .= ' RIGHT JOIN';
            }elseif($fromStr != ' FROM') $fromStr .= ',';
            
            $fromStr .= ' ' . $mysqlTable;
            if (!empty($value['alias'])) $fromStr .= ' ' . $value['alias'];
            
            if (isset($value['on'])&& is_array($value['on'])) {
                $onWhereStr = self::createWhereStr($value['on'],$myDb);
                if (false === $onWhereStr) {
                    SysLogs::addError('Error MNBVMySQLSt::createOnWhereStr - bad arr['.(implode(",",$filter)).']!');
                    return array(0); //Если ошибочное завершение, вернем пустой результат
                }else{ 
                    $fromStr .= ' ON (' . $onWhereStr . ')';
                }
            }
            
        }
        if (empty($main_storage)) return array(0); //Если линка нет, то возвращаем пустой ответ
        
        //Построим строку полей
        $fieldsStr = ''; $allFields = false;
        if (is_array($fields)){
            foreach ($fields as $key=>$value) {
                if (is_array($value)) //это поля с алиасами
                    $fieldsStr .= (($fieldsStr=='')?' ':', ')."".$value[0].' as '.$value[1];
                else //это просто поля
                    if ($value=='*') $fieldsStr = ' *';
                    else $fieldsStr .= (($fieldsStr=='')?' ':', ')."$value";
            }
        }   
                
        //Построим строку фильтров
        $whereStr = (is_array($filter))?(self::createWhereStr($filter,$myDb)):'';
        if (false === $whereStr) {
            SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad arr['.((is_array($filter))?(implode(",",$filter)):"NoArr=[$filter]").']!');
            return array(0); //Если ошибочное завершение, вернем пустой результат
        }else $whereStr = ' WHERE' . $whereStr;
        if (trim($whereStr) == 'WHERE') $whereStr = '';
        
        //Строка группировки
        $groupStr = '';
        if (!empty($conf["group"])) {
            $groupStr = ' GROUP BY ' . $conf["group"];
        }

        //Строка сортировки
        $orderStr = '';
        if (!empty($conf["sort"]) && is_array($conf["sort"])) {
            foreach ($conf["sort"] as $key => $value) $orderStr .= (($orderStr=='')?' ORDER BY ':', ') . $key . (($value=='desc')?' DESC':'');
        }
        
        //Строка ограничения выборки
        $LimitStr = '';
        if (isset($conf["limit"][0])&&!empty($conf["limit"][1])) $LimitStr = ' LIMIT ' . intval($conf["limit"][0]) . ',' . intval($conf["limit"][1]);
        
        $query = "SELECT$sqlFlags$fieldsStr$fromStr$whereStr$groupStr$orderStr$LimitStr;";
        $mysqlres = $myDb->query($query);
        while ($res=DBMysql::mysql_fetch_array($mysqlres)){
            $item = array(); //Массив, содержащий элементы 1 записи из базы

            reset($res);
            foreach($res as $key=>$value){
                $item["$key"] = $value;
            }
            
            $result[] = $item;
            $colcol++;
        }
        
        if(!empty($conf["countFoundRows"])) $colcol = $myDb->countFoundRows($myDb); //Если установлен данный маркер, возьмем количество из мускула
        $result[0] = $colcol;
        
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
     * @param bool $params - дополнительные параметры в частности тип добавления см потом в реализации мускула
     * @return mixed - если успешно, то id созданного объекта, иначе FALSE
     */
    public static function addObj($storage,$fields=array(''),$filter=array(),$params=array()){
        $result = false; //Результат операции
        //Получим данные по соединению
        if (!empty(SysStorage::$storage["$storage"]["table"])) $mysqlTable = SysStorage::$storage["$storage"]["table"]; else return false; //Таблица
        if (!empty(SysStorage::$storage["$storage"]["stru"])) $mysqlStru = SysStorage::$storage["$storage"]["stru"]; else return false; //Структура
        
        $myDb = SysStorage::getLink($storage);
        if ($myDb===null) return false; //Если линка нет, то возвращаем пустой ответ
        
        //Построим строку полей
        $fieldsStr = '';$valStr = '';
        if (is_array($fields)){
            foreach ($fields as $key=>$value) {
                $fieldsStr .= (($fieldsStr=='')?' ':', ')."$key";
                $valStr .= (($valStr=='')?' ':', ')."'".self::codeStr($value,'',$myDb)."'";
            }
        }   
        
        //Построим строку таблиц
        $fromStr = 'INSERT INTO ' . $mysqlTable;
        if (is_array($params) && !empty($params['type']) && $params['type']=='replace') $fromStr = 'REPLACE ' . $mysqlTable; 

        //Построим строку фильтров
        $whereStr = (is_array($filter))?(self::createWhereStr($filter,$myDb)):'';
        if (false === $whereStr) {
            SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad arr['.((is_array($filter))?(implode(",",$filter)):"NoArr=[$filter]").']!');
            return array(0); //Если ошибочное завершение, вернем пустой результат
        } else {
            $whereStr = ' WHERE ' . $whereStr;
        }
        if (trim($whereStr) == 'WHERE') $whereStr = '';
        
        $mysqlres = $myDb->query("$fromStr ($fieldsStr) VALUES ($valStr) $whereStr;");
        if ($mysqlres) return $myDb->mysql_insert_id();        
        return $mysqlres;
    }

    /**
     * Копирование объекта хранилища
     * @param string $storage - хранилище
     * @param array $id - идентификатор копируемого объекта (первичный ключ). Новый будет иметь следующее значение 
     * @param bool $params - дополнительные параметры в частности тип добавления см потом в реализации мускула
     * @return mixed - если успешно, то id созданного объекта, иначе FALSE
     */
    public static function copyObj($storage,$id='',$filter=array(),$params=array()){
        
        if (empty($id)) return false;
        
        $result = false; //Результат операции
        //Получим данные по соединению
        if (!empty(SysStorage::$storage["$storage"]["table"])) $mysqlTable = SysStorage::$storage["$storage"]["table"]; else return false; //Таблица
        if (!empty(SysStorage::$storage["$storage"]["stru"])) $mysqlStru = SysStorage::$storage["$storage"]["stru"]; else return false; //Структура
        
        $myDb = SysStorage::getLink($storage);
        if ($myDb===null) return false; //Если линка нет, то возвращаем пустой ответ  

        $mysqlres = $myDb->query("DROP TABLE IF EXISTS tmp".Glob::$vars['session']->sid.";");
        $mysqlres = $myDb->query("CREATE TEMPORARY TABLE tmp".Glob::$vars['session']->sid." SELECT * FROM `mnbv_products` WHERE id=$id;");
        $mysqlres = $myDb->query("UPDATE tmp".Glob::$vars['session']->sid." SET id=(SELECT MAX(ID)+1 FROM `".$mysqlTable."`);");
        $mysqlres = $myDb->query("INSERT INTO `mnbv_products` SELECT * FROM tmp".Glob::$vars['session']->sid.";");
        $mysqlres = $myDb->query("DROP TABLE IF EXISTS tmp".Glob::$vars['session']->sid.";");
        
        if ($mysqlres) return $myDb->mysql_insert_id();        
        return $mysqlres;
    }
    
    /**
     * Редактирование объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив полей и их значений для изменения в базе типа array('ключ'=>Значение)
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     * @return bool - результат операции
     */
    public static function setObj($storage,$fields=array(''),$filter=array()){
        $result = false; //Результат операции
        
        //Получим данные по соединению
        if (!empty(SysStorage::$storage["$storage"]["table"])) $mysqlTable = SysStorage::$storage["$storage"]["table"]; else return false; //Таблица
        if (!empty(SysStorage::$storage["$storage"]["stru"])) $mysqlStru = SysStorage::$storage["$storage"]["stru"]; else return false; //Структура
        
        $myDb = SysStorage::getLink($storage);
        if ($myDb===null) return false; //Если линка нет, то возвращаем пустой ответ
        
        //Построим строку полей
        $fieldsStr = '';
        if (is_array($fields)){
            foreach ($fields as $key=>$value) $fieldsStr .= (($fieldsStr=='')?' ':', ')."$key='".self::codeStr($value,'',$myDb)."'";
        }   
        
        //Построим строку таблиц
        $fromStr = ' ' . $mysqlTable . ' SET ';

        //Построим строку фильтров
        $whereStr = (is_array($filter))?(self::createWhereStr($filter,$myDb)):'';
        if (false === $whereStr) {
            SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad arr['.((is_array($filter))?(implode(",",$filter)):"NoArr=[$filter]").']!');
            return array(0); //Если ошибочное завершение, вернем пустой результат
        }else {
            $whereStr = ' WHERE ' . $whereStr;
        }
        if (trim($whereStr) == 'WHERE') $whereStr = '';
        
        $mysqlres = $myDb->query("UPDATE$fromStr$fieldsStr $whereStr;");        
        
        return $mysqlres;
    }
    
    /**
     * Удаляет из заданного хранилища объекты, соответствующие фильтру
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     * @return bool - результат операции
     */
    public static function delObj($storage,$filter=array()){
        $result = false; //Результат операции
        
        //Получим данные по соединению
        if (!empty(SysStorage::$storage["$storage"]["table"])) $mysqlTable = SysStorage::$storage["$storage"]["table"]; else return false; //Таблица
        if (!empty(SysStorage::$storage["$storage"]["stru"])) $mysqlStru = SysStorage::$storage["$storage"]["stru"]; else return false; //Структура
        
        $myDb = SysStorage::getLink($storage);
        if ($myDb===null) return false; //Если линка нет, то возвращаем пустой ответ
        
        //Построим строку таблиц
        $fromStr = 'FROM ' . $mysqlTable;

        //Построим строку фильтров
        $whereStr = (is_array($filter))?(self::createWhereStr($filter,$myDb)):'';
        if (false === $whereStr) {
            SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad arr['.((is_array($filter))?(implode(",",$filter)):"NoArr=[$filter]").']!');
            return array(0); //Если ошибочное завершение, вернем пустой результат
        }else {
            $whereStr = ' WHERE ' . $whereStr;
        }
        if (trim($whereStr) == 'WHERE') $whereStr = '';
        
        $mysqlres = $myDb->query("DELETE $fromStr $whereStr;");        
        
        return $mysqlres;
    }
    
    /**
     * Проверка существования данного хранилища
     * @param string $storage - хранилище
     * @return bool результат операции
     */
    public static function checkStorage($storage){
        return false;
    }
    
    /**
     * Создает хранилище, если оно не создано
     * @param string $storage - хранилище
     * @return bool результат операции
     */
    public static function createStorage($storage){
        return false;
    }
 
 }
