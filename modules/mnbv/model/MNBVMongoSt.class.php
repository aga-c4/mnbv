<?php
/**
 * Библиотека MNBV для работы с хранилищем типа MongoDB
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVMongoSt implements MNBVdefSt{
    
    /**
     * Получить список объектов системы или объект
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров
     * @param array $fields - массив требуемых полей
     * @return array массив, содержащий найденные объекты или пустой, если не найдено ничего
     */
    public static function getObj($storage,$fields=array('*'),$filter=array(),$conf=array()){
        return array();
    }
    
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
    public static function addObj($storage,$fields=array('')){
        return false;
    }
    
    /**
     * Устанавливает поля объекта(ов) системы в заданные значения
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров
     * @param array $fields - массив требуемых полей
     * @return bool результат операции
     */
    public static function setObj($storage='default',$filter=array(),$fields=array('')){
        return false;
    }
    
    /**
     * Создает новый объекта системы в заданные значения
     * @param string $storage - хранилище
     * @param array $filter - массив фильтров
     * @return bool результат операции
     */
    public static function delObj($storage='default',$filter=array()){
        return false;
    }
    
    /**
     * Проверка существования данного хранилища
     * @param string $storage - хранилище
     * @return bool результат операции
     */
    public static function checkStorage($storage='default'){
        return false;
    }
    
    /**
     * Создает хранилище, если оно не создано
     * @param string $storage - хранилище
     * @return bool результат операции
     */
    public static function createStorage($storage='default'){
        return false;
    }
 
 }
