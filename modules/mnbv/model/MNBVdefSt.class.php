<?php
/**
 * Дефолтовый класс статических функций работы с БД 
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
interface MNBVdefSt {
    
    /**
     * Получить список объектов хранилища или объект, если задан его идентификатор
     * @param string $storage - хранилище
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас")
     *                        или если это поля nd,ch,dt, то массив (номер1,номер2) или строка '*' - все
     * @param array $filter - массив фильтров ("key"=>"value"), где если value - не массив то условие равенства, иначе: 
     *     "value"=array(( "=" , "!=" , "in", "not in", ">" , ">=", "<" , "<=" , "like" ) , "значение");
     *      Пример filter = array("id" => array("in"=>"11,23,45")); 
     * @param array $conf - массив управляющих настроек
     *      $conf = array(
     *                  "countFoundRows" => false, //включить подсчет всех значений по-умолчанию false 
     *                  "sort" => "строка сортировки", //перечисляются ключи, последний может иметь маркер обратной сортировки
     *                  "limit" => array(первая_позиция , смещение), //массив содержащий позицию первого элемента и количество элементов
     *              );
     * @return array массив, содержащий найденные объекты, 0 элемент массива всегда содержит колличество найденных объектов без учета ограничений limit!
     */
    public static function getObj($storage,$fields=array('*'),$filter=array(),$conf=array());

    /**
     * Добавление объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас")
     *                        или если это поля nd,ch,dt, то массив (номер1,номер2) или строка '*' - все
     * @param array $filter - массив фильтров ("key"=>"value"), где если value - не массив то условие равенства, иначе: 
     *     "value"=array(( "=" , "!=" , "in", "not in", ">" , ">=", "<" , "<=" , "like" ) , "значение");
     *      Пример filter = array("id" => array("in"=>"11,23,45")); 
     * @return mixed - если успешно, то id созданного объекта, иначе FALSE
     */
    public static function addObj($storage,$fields=array(''));
    
    /**
     * Редактирование объекта хранилища
     * @param string $storage - хранилище
     * @param array $fields - массив требуемых полей, значения могут быть строками или массивом ("поле","алиас")
     *                        или если это поля nd,ch,dt, то массив (номер1,номер2) или строка '*' - все
     * @param array $filter - массив фильтров ("key"=>"value"), где если value - не массив то условие равенства, иначе: 
     *     "value"=array(( "=" , "!=" , "in", "not in", ">" , ">=", "<" , "<=" , "like" ) , "значение");
     *      Пример filter = array("id" => array("in"=>"11,23,45")); 
     * @return bool - результат операции
     */
    public static function setObj($storage,$fields=array(''),$filter=array());
    
    /**
     * Удаляет из заданного хранилища объекты, соответствующие фильтру
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров ("key"=>"value"), где если value - не массив то условие равенства, иначе: 
     *     "value"=array(( "=" , "!=" , "in", "not in", ">" , ">=", "<" , "<=" , "like" ) , "значение");
     *      Пример filter = array("id" => array("in"=>"11,23,45")); 
     * @return bool - результат операции
     */
    public static function delObj($storage,$filter=array());

    /**
     * Проверка существования данного хранилища
     * @param string $storage - хранилище
     * @return bool - результат операции
     */
    public static function checkStorage($storage);

    /**
     * Создает хранилище, если оно не создано
     * @param string $storage - хранилище
     * @return bool - результат операции
     */
    public static function createStorage($storage);
    
}
