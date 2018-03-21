<?php
/**
 * Системный реестр Хранилище - вариант реализации паттерна Register с блокировкой элементов
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class Registry {
    
    /**
     * @var array Хранилище
     */
    private static $container = array();

    /**
     * @var array Массив ключей, изменение которых не возможно
     */
    private static $lock = array();

    /**
     * Блокировка элемента
     * @param $key Название элемента
     */
    public static function lock($key)
    {
        self::$lock["$key"] = true;
    }

    /**
     * Разблокировка элемента
     * @param $key Название элемента
     */
    public static function unlock($key)
    {
        if (isset(self::$lock["$key"])) unset(self::$lock["$key"]);
    }

    /**
     * Создание элемента контейнера с проверкой наличия подобного элемента в контейнере
     * @param $key Название элемента
     * @param $value Значение элемента
     * @return bool Результат операции
     */
    public static function set($key, $value)
    {
        if(!isset(self::$container["$key"]))
            self::$container["$key"] = $value;
        else {
            //trigger_error('Variable Registry['. $key .'] already defined', E_USER_WARNING); //Можно заменить trigger_error на SysLogs::addError
            return false;
        }
        return true;
    }

    /**
     * Изменение элемента контейнера, если он не заблокирован
     * @param $key Название элемента
     * @param $value Значение элемента
     * @return bool Результат операции
     */
    public static function change($key, $value)
    {
        if(!isset(self::$lock["$key"]))
            self::$container["$key"] = $value;
        else {
            //trigger_error('Variable Registry['. $key .'] is locked', E_USER_WARNING); //Можно заменить trigger_error на SysLogs::addError
            return false;
        }
        return true;
    }

    /**
     * Получение элемента контейнера
     * @param $key Название элемента
     * @return mixed Результат операции
     */
    public static function get($key)
    {
        return (isset(self::$container["$key"]))?self::$container["$key"]:NULL;
    }

    /**
     * Уничтожает элемент контейнера
     * @param $key Название элемента
     */
    public static function del($key)
    {
        if (isset(self::$container["$key"])) unset(self::$container["$key"]);
        if (isset(self::$lock["$key"])) unset(self::$lock["$key"]);
    }

    private function __construct(){}
    private function __clone(){}
    
}
