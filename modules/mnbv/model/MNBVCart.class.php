<?php
/**
 * Class MNBVCart - класс работы с корзиной MNBV
 * 
 * Корзины хранятся отдельно от сессий. 
 * Корзины к пользователю, если в момент формирования корзины он был авторизован. 
 * В сессии хранится идентификатор корзины. 
 * При авторизации если у пользователя есть корзина, то она привязывается к текущей сессии по id корзины. 
 * Если до авторизации к сессии была привязана корзина, то она удаляется в случае привязке сессии к корзине пользователя.
 * У пользователя и у сессии может быть только 1 корзина, поэтому при авторизации производится проверка и удаление более старых корзин.
 * После оформления заказа в текущей корзине очищается список продуктов, однако остаются все остальные настройки для удобства последующего заказа
 * 
 * У корзины и у позиции есть свойства по ластклику, а также есть массив истории по данным свойствам для корзины вцелом:
 * - utm_source
 * - utm_medium
 * - utm_campaign
 * - utm_term
 * - find_keys - ключевое слово по которому искали и перешли, если возможно его получить
 * - partner_id - идентификатор партнера в нашей системе
 * - partner_code - хеши, которые партнер передает нам обычно для идентификации своих источников трафика.
 * Если в корзине не осталось ни одной позиции с заданным свойством, то оно удаляется и из истории.
 * Свойства корзины хранятся в отдельных полях, чтоб можно было организовать фильтрацию, история свойств, хранится единым массивом (utm_history).
 * 
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVCart{
    
    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = 'carts';
    
    /**
     * Установка текущего хранилища для контроллера
     * @param $storage - алиас хранилища
     */
    public function setStorage($storage){
        $this->storage = $storage;
    }

    /**
     * Получение текущего хранилища для контроллера
     * @param $storage - алиас хранилища
     */
    public function getStorage(){
        return $this->storage;
    }
    
    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $pr_storage = 'products';
    
    /**
     * Установка хранилища каталога товаров
     * @param $storage - алиас хранилища
     */
    public function setPrStorage($storage){
        $this->$pr_storage = $storage;
    }

    /**
     * Получение хранилища каталога товаров
     * @param $storage - алиас хранилища
     */
    public function getPrStorage(){
        return $this->$pr_storage;
    }
    
    /**
     * @var type array массив свойств корзины
     */
    private $container = array();
    
    /**
     * Создание элемента в контейнере корзины
     * @param $key Название элемента
     * @param $value Значение элемента
     */
    public function set($key, $value)
    {
        $this->container["$key"] = $value;
    }

    /**
     * Получение элемента контейнера корзины
     * @param $key Название элемента
     * @return mixed Результат операции
     */
    public function get($key)
    {
        return (isset($this->container["$key"]))?$this->container["$key"]:NULL;
    }

    /**
     * Уничтожает элемент контейнера корзины
     * @param $key Название элемента
     */
    public function del($key)
    {
        if (isset($this->container["$key"])) unset($this->container["$key"]);
    }
    
        
    /**
     * @var type array массив, содержащий сведения о товарах в корзине 
     */
    public $items = array();
    
    /**
     * Добавляет в корзину товар $productId или корректирует сведения по позиции с товаром.
     * @param type $productId идентификатор добавляемого товара
     * @param type $qty количество единиц товара
     * @param type $price цена товара по позиции
     * @param type $params если массив, то это массив параметров, содержащий:
     * 'id' - идентификатор позиции (на один товар можно завести несколько позиций в корзине при необходимости скажем дать разную скидку), если не задан, 
     *        то работа ведется с последней позицией, привязанной к идентификатору товара, а если таковой нет, то создается новая позиция
     * 'price' - цена,
     * 'nds' - %НДС,
     * 'discount_pr' - скидка, %
     * 'discount_val' - скидка в валюте, если задана, то имеет приоритет перед %
     * 'qty' - количество добавляемого товара
     * 'real_qty' - установить количество по позиции в заданное, если 0, то удаляет позицию
     * 'utm_source' - метки трафика
     * 'utm_medium' - метки трафика
     * 'utm_campaign' - метки трафика
     * 'find_keys' - ключевое слово по которому искали и перешли, если возможно его получить
     * 'partner_id' - идентификатор партнера в нашей системе
     * 'partner_code' - хеши, которые партнер передает нам обычно для идентификации своих источников трафика.
     * @return boolean результат операции
     */
    public function updateItem($productId=0,$params=array())
    {
        return false;
    }

    /**
     * Удаляет позицию с заданным идентификатором из корзины.
     * @param $key Название элемента
     * @return mixed Результат операции
     */
    public function remItem($id)
    {
        if (isset($this->items[intval($id)])) unset($this->items[intval($id)]);
    }
    
    /**
     * Пересчитывает корзину и заполняет служебные переменные.
     */
    public function rcount()
    {
        ;
    }

    
}
