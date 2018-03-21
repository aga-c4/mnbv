<?php
/**
 * Библиотека MNBV для работы с хранилищем типа Array
 * Хранилища этого типа реализованы как обычные php файлы в которых определены массивы.
 * названия файлов совпадают с названиями массивов.
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVArraySt implements MNBVdefSt{

    /**
     * @var int максимальное количество уровней вложения при обработки массива where
     */
    public static $maxFilterIterations = 10;

    /**
     * Подключает массив из файла
     * @param $storage
     * @return array|bool
     */
    private static function stOpen($storage){
        if (!isset(SysStorage::$arraySt["$storage"]) || !is_array(SysStorage::$arraySt["$storage"])){ //Массив еще не загружен, надо попробовать загрузить скрипт, который сформирует массив в классе SysStorage
            if (!empty(SysStorage::$storage["$storage"]["table"])) $table = SysStorage::$storage["$storage"]["table"]; else return array(); //Таблица
            $storageFileName = APP_STORAGEARRAYPATH.$table.".php";
            MNBVF::requireFile($storageFileName);
            if (!isset(SysStorage::$arraySt["$storage"]) || !is_array(SysStorage::$arraySt["$storage"])) SysStorage::$arraySt["$storage"] = array();
        }
        return true;
    }

    /**
     * На входе принимает массив со значениями элемента и массив с условиями, на выходе дает ответ - проходит этот элемент под условия или нет
     * @param array $item - массив со значениями элемента хранилища
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      ВНИМАНИЕ!!! не поддерживается строка MySQL, операции выполняются последовательно, не учиываются скобки, поддерживается только and, если даже написано or, все равно будет использовано and
     * @return boolean результат операции
     */
    public static function useWhereStr(array $item, $filter = ''){

        if (!is_array($filter)) return false; //Можно напрямую строку мускула задать (вдальнейшем надо сделать парсер строки для работы в  других типах БД

        static $numIterations = 0; //Счетчик количества итерацийэ
        $numIterations++;
        if ($numIterations > self::$maxFilterIterations) {
            SysLogs::addError('Error MNBVArraySt::createWhereStr to big iterations = ['.$numIterations.'>'.self::$maxFilterIterations.']!');
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
        $filterOk = true;
        while($key<$filterArrSize){

            //Временно не обрабатываемые варианты -----------------------------------------
            if (!is_array($filter[$key])){
                $lop = strtolower(trim($filter[$key]));
                if (in_array($lop,array('and','&&','or','||','(',')'))) {
                    $key++;
                    continue;
                }
            }

            //проверим на массив
            if (is_array($filter[$key])){
                if (false == self::useWhereStr($item,$filter[$key])) $filterOk = false;
                $key++;
                continue;
            }
            //------------------------------------------------------------------------------

            $field = strval($filter[$key]); $key++;
            $op = $filter[$key]; $key++;
            $val = $filter[$key];

            if (($op=='in' || $op=='not in')){ 

                if (is_array($val)){
                    foreach ($val as $inVal) {
                        if (!isset($item[strval("$field")]) && ($op=='in' && $val!=$item[strval("$field")] || $op=='not in' && $val==$item[strval("$field")])) $filterOk = false;
                    }
                }else{
                    SysLogs::addError('Error MNBVMySQLSt::createWhereStr - bad in array field=['.$field.']!');
                    $filterOk = false;
                    break;
                }
                $key++;
                continue;

            }else{ 
                if (!isset($item[$field])) $item[$field] = null;
                if ($op=="=" && $item[$field] != $val) $filterOk = false;
                elseif ($op=="!=" && $item[$field] = $val) $filterOk = false;
                elseif ($op==">" && $item[$field] <= $val)$filterOk = false;
                elseif ($op==">=" && $item[$field] < $val)$filterOk = false;
                elseif ($op=="<" && $item[$field] >= $val)$filterOk = false;
                elseif ($op=="<=" && $item[$field] > $val)$filterOk = false;
                elseif ($op=="like" && preg_match("/".preg_replace("/%/","",$val)."/",$item[$field])) $filterOk = false;
                $key++;
                continue;

            }

        }
        $numIterations--;
        return $filterOk;

    }

    /**
     * Получить список объектов хранилища или объект, если задан его идентификатор
     * @param string $storage - хранилище
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас")
     *                        или если это поля nd,ch,dt, то массив (номер1,номер2) или строка '*' - все
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      ВНИМАНИЕ!!! пока в фильтре нельзя использовать скобки (массивы определения 'in')
     *      ВНИМАНИЕ!!! пока реализованы фильтры только по AND!!!
     * @param array $conf - массив управляющих настроек
     *      $conf = array(
     *                  "countFoundRows" => false, //включить подсчет всех значений по-умолчанию false
     *                  "sort" => array("key"=>"inc|desc"), //перечисляются ключи, последний может иметь маркер обратной сортировки
     *                  "limit" => array(первая_позиция , смещение), //массив содержащий позицию первого элемента и количество элементов
     *              );
     * @return array массив, содержащий найденные объекты, 0 элемент массива всегда содержит колличество найденных объектов без учета ограничений limit!
     */
    public static function getObj($storage,$fields=array('*'),$filter=array(),$conf=array()){
        self::stOpen($storage); //Откроем при необходимости файл с массивом
        
        //Маркер необходимости подсчета количества записей без учета лимита
        $countFoundRows = (!empty($conf["countFoundRows"]))?true:false;

        //Сортировка
        $orderArr = 'no'; $noSort = true;
        if (!empty($conf["sort"]) && is_array($conf["sort"])) {
            foreach ($conf["sort"] as $key => $value) {
                $orderArr = array("key"=>"$key", "desc" => (($value=='desc')?true:false));
                $noSort = false;
                break;
            }
        }
        //Построим массив полей
        $fieldsArr = array();
        if (is_array($fields)){
            foreach ($fields as $key=>$value) {
                if (is_array($value)) //это поля с алиасами
                    $fieldsArr [$value[0]] = $value[1];
                else //это просто поля
                    if ($value=='*') {$fieldsArr = 'all'; break;}
                    else $fieldsArr [$value] = $value;
            }
        }

        //Ограничение выборки
        $limitArr = 'no';
        if (isset($conf["limit"][0])&&!empty($conf["limit"][1])) {
            $limit = array(intval($conf["limit"][0]),intval($conf["limit"][1]));
            $limitArr = 'yes';
        }

        //Обработак фильтров
        //Фильтр по ID - единственный объект - сразу возвращаем результат
        if (!is_array($filter)){
            $keyCol = count($filter);
            if ($keyCol==3 && $filter[0]=='id'){//есть 3 элемента и поле 'id', возможно это поиск по единственному ключу - идентификатору в т.ч. по схеме in (1,2,3...)
                $field = $filter[0];
                $op = $filter[1];
                $val = $filter[2];
                if (($op=='in' || $op=='not in') && is_array($val)){ //Вывод списка по первичному ключу id

                    if (is_array($val)){
                        $counter = 0;
                        $result = array(0);
                        foreach ($val as $inVal) {
                            if (isset(SysStorage::$arraySt["$storage"][strval($val)])) {
                                if ($fieldsArr == 'all') $result[] = SysStorage::$arraySt["$storage"][strval($val)];
                                else{
                                    $itemArr = array();
                                    foreach ($fieldsArr as $key=>$value) {
                                        if (isset(SysStorage::$arraySt["$storage"][strval($val)][$key]))$itemArr[$key] = SysStorage::$arraySt["$storage"][$filter["id"]][$key];
                                    }
                                    $result[] = $itemArr;
                                }
                                $counter++;
                            }
                        }
                        $result[0] = $counter;
                        return $result;
                    }else{
                        SysLogs::addError('Error MNBVArraySt::createWhereStr - bad in array field=['.$field.']!');
                        return array(0);
                    }

                }else{ //Это поиск по значению первичного ключа id

                    if ($fieldsArr == 'all')
                        return array(1,SysStorage::$arraySt["$storage"][strval($val)]);
                    else{
                        $itemArr = array();
                        foreach ($fieldsArr as $key=>$value) {
                            if (isset(SysStorage::$arraySt["$storage"][strval($val)][$key]))$itemArr[$key] = SysStorage::$arraySt["$storage"][$filter["id"]][$key];
                        }
                        return array(1,$itemArr);
                    }

                }
            }
        }

        //Если дошли до сюда, то это не поиск по первичному ключу id

        $existFilters = (count($filter)>0)?true:false;

        $allcolcol = 0; //Количество записей, прошедших фильтр без учета лимитов
        $colcol = 0; //Количество записей, прошедших фильтр с учетом лимитов
        $farr = array(); //Массив, содержащий все результаты без сортировки
        $sortArr = array(); //Массив индексов для сортировки
        $result = array(0); //Массив результата       
        foreach(SysStorage::$arraySt["$storage"] as $res=>$resval){

            //Сформируем текущий элемент выходного массива
            if ($fieldsArr == 'all')
                $itemArr = $resval;
            else{
                $itemArr = array();
                foreach ($fieldsArr as $key=>$value) {
                    if (isset($resval[$key])) $itemArr[$key] = $resval[$key];
                }
            }

            //При необходимости обработаем фильтры
            if ($existFilters && !self::useWhereStr($resval, $filter)) continue;

            //Обработаем позиции, прошедшие фильтр
            $allcolcol++;
            if (!$noSort&&isset($resval[$orderArr["key"]])) {//Вариант с сортировкой
                //Сформируем индекс для сортировки
                $sortArr["$colcol"] = $resval[$orderArr["key"]];
                $farr["$colcol"] = $itemArr;
            }else{//Вариант без сортировки
                //SysLogs::addLog('LIMIT: allcolcol=['.($allcolcol-1).']<['.$limit[0].']colcol=['.$colcol.']>=['.$limit[1].']');
                if (($limitArr != 'no' && (($allcolcol-1)<$limit[0] || $colcol>=$limit[1]))) continue; //Обработаем при необходимости лимиты
                $result[] = $itemArr;
            }
            $colcol++;

        }

        $colcol = ($countFoundRows)?$allcolcol:$colcol;

        if ($noSort||!isset($resval[$orderArr["key"]])) {//Вывод результата без сортировки
            $result[0] = $colcol;
            return $result;
        }else{//При необходимости проведем сортировку с лимитами
            $result = array($colcol); //Массив результата
            if ($orderArr["desc"]) arsort($sortArr);
            else asort($sortArr);
            reset($sortArr);
            $farr2 = array();
            $counter = $colcol = 0;
            foreach($sortArr as $key=>$value){
                $counter++;
                if ($limitArr != 'no' && (($counter-1)<$limit[0] || $colcol>=$limit[1])) continue; //Обработаем при необходимости лимиты
                $result[] = $farr["$key"];
                $colcol++;
            }
            $result[0] = $counter;
            return $result;
        }

    }

    /**
     * Добавление объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас")
     *                        или если это поля nd,ch,dt, то массив (номер1,номер2) или строка '*' - все
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     * ВНИМАНИЕ!!! пока в фильтре нельзя использовать скобки (массивы определения 'in')
     * @return mixed - если успешно, то id созданного объекта, иначе FALSE
     */
    public static function addObj($storage,$fields=array('')){
        return false;
    }

    /**
     * Редактирование объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас")
     *                        или если это поля nd,ch,dt, то массив (номер1,номер2) или строка '*' - все
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      ВНИМАНИЕ!!! пока в фильтре нельзя использовать скобки (массивы определения 'in')
     * @return bool - результат операции
     */
    public static function setObj($storage,$fields=array(''),$filter=array()){
        return false;
    }

    /**
     * Удаляет из заданного хранилища объекты, соответствующие фильтру
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров ('key','=','value','and','key2','!=','value2','&&','key3','<','value3','or',array('key4','>','value4','||','key5','in',array('11,23,45')))
     *      Т.е. обычный sql синтаксис, побитый по элементам, если скобка, то используем array(). Если используется конструкция in, то значения передаем в массиве.
     *      Допустимый уровень вложений задается в настройках класса конкретной БД.
     *      В случае выхода за допустимые уровни вложений должна выдаваться ошибка.
     *      ВНИМАНИЕ!!! пока в фильтре нельзя использовать скобки (массивы определения 'in')
     * @return bool - результат операции
     */
    public static function delObj($storage,$filter=array()){
        return false;
    }

    /**
     * Проверка существования данного хранилища
     * @param string $storage - хранилище
     * @return bool результат операции
     */
    public static function checkStorage($storage){
        return true;
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
