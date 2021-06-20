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
    private $ordStorage = 'orders';
    
    /**
     * @var string алиас хранилища товаров
     */
    private $prStorage = 'products';
    
    /**
     * @var array общие данные по корзине (доставка, оплата, адреса, ...) 
     */
    private $cartInfo = array();
    
    /**
     * @var array элементы корзины 
     */
    private $cartItems = array();
    
    /**
     * @var array добавленные или удаленные позиции корзины для счетчиков
     */
    private $addCartItems = null;
    
    /**
     * @var array добавленные или удаленные позиции корзины для счетчиков
     */
    private $remCartItems = mull;
    
    public function __construct($prStorage='', $ordStorage='') {
        if (!empty($prStorage)) $this->prStorage = $prStorage;
        $this->ordStorage = $ordStorage;
        
        $this->cartItems = Glob::$vars['session']->get('cart_items');
        if (!is_array($this->cartItems)) $this->cartItems = array();
        
        $this->cart_info = Glob::$vars['session']->get('cart_info');
        if (!is_array($this->cart_info)) $this->cart_info = array();
    }
    
    /**
     * Создание свойства корзины
     * @param $key Название элемента
     * @param $value Значение элемента
     */
    public function set($key, $value)
    {
        $this->cart_info["$key"] = $value;
    }

    /**
     * Получение свойства корзины
     * @param $key Название элемента
     * @return mixed Результат операции
     */
    public function get($key)
    {
        return (isset($this->cart_info["$key"]))?$this->cart_info["$key"]:NULL;
    }

    /**
     * Уничтожает свойство корзины
     * @param $key Название элемента
     */
    public function del($key)
    {
        if (isset($this->cart_info["$key"])) unset($this->cart_info["$key"]);
    }
    
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
     * @param $prodId Идентификатор товара
     * @return mixed Результат операции
     */
    public function remItem($prodId)
    {
        if ($this->remCartItems === mull) $this->remCartItems = array(); 
        $this->remCartItems[] = array();
        if (isset($this->cartItems[intval($id)])) unset($this->cartItems[intval($id)]);
    }
    
    /**
     * Пересчитывает корзину и заполняет служебные переменные.
     */
    public function rcount()
    {
        ;
    }
    
    /**
     * Сохранение текущей корзины в сессию
     */
    public function save(){
        Glob::$vars['session']->set('cart_items',$this->cartItems);
        Glob::$vars['session']->set('cart_info',$this->cart_info);
        Glob::$vars['session']->save(); //Сохраним данные сессии
    }

    
}
