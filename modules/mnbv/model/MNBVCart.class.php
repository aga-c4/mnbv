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
     * @var type cуммарное количество единиц товара в корзине
     */
    private $qty = 0;
    
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
    private $remCartItems = null;
    
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
     * Добавляет в корзину товар $prodId или корректирует сведения по позиции с товаром.
     * @param type $prodId идентификатор добавляемого товара
     * @param type $qty количество единиц товара
     * @return boolean результат операции
     */
    public function addItem($prodId=0,$qty=0){
        return false;
    }
    
    /**
     * Редактирует позицию корзины
     * @param type $prodId идентификатор товара
     * @param type $qty количество единиц товара
     * @return boolean результат операции
     */
    public function updateItem($prodId=0,$qty=0){
        return false;
    }

    /**
     * Удаляет позицию с заданным идентификатором из корзины.
     * @param $prodId Идентификатор товара
     * @return mixed Результат операции
     */
    public function remItem($prodId){
        if ($this->remCartItems === mull) $this->remCartItems = array(); 
        $this->remCartItems[] = array();
        if (isset($this->cartItems[intval($id)])) unset($this->cartItems[intval($id)]);
    }
    
    /**
     * Пересчитывает корзину и заполняет служебные переменные.
     */
    public function recount(){
        ;
    }
    
    /**
     * Очищает корзину и дополнительные поля, если есть.
     */
    public function clearCart(){
        $this->remCartItems = array();
        $this->qty = 0;
    }
    
    
    /**
     * Количество товаров в корзине по всем позициям
     */
    public function getQty(){
        return $this->qty;
    }
    
    /**
     * Установить тип доставки
     * @param type $delivId
     */
    public function setDeliv($delivId){
        ;
    }
    
    /**
     * Установить тип оплаты
     * @param type $payId
     */
    public function setPay($payId){
        ;
    }
    
    public function getItemsList(){
        ;
    }
    
    public function getDeliveryList(){
        ;
    }
    
    public function getPayList(){
        ;
    }
    
    /*
    Glob::$vars['sizegr_types'] = array("1" => "Small", "2"=>"Normal", "3"=>"Medium", "4"=>"Big", "5"=>"Biggest");
    Glob::$vars['weightgr_types'] = array("1" =>"Light", "2"=>"Normal", "3"=>"Medium", "4"=>"Heavy", "5"=>"Very heavy");

    Glob::$vars['sizegr_types_levels'] = array( //Максимальный объем в куб.см и макс. измерение в см.
        "1" => array("v"=>200000, "h"=>200), //0,2 куба не более 1х1х0,2 курьер в руках или машине
        "2" => array("v"=>200000, "h"=>200), //2 куба до 2 метров (ларгус)
        "3" => array("v"=>1000000, "h"=>3000), //10 кубов до 3 метров (газель)
        "4" => array("v"=>4000000, "h"=>5000), //40 кубов до 6 метров (газон НЕКСТ)
        "5" => array("v"=>10000000, "h"=>12000), //Фура 100 кубов и 12 метров
    );

    Glob::$vars['weightgr_types_levels'] = array( //Максимальный вес, кг.
        "1" => 10, //Курьер
        "2" => 400, //Ларгус
        "3" => 1500, //Газель
        "4" => 6000, //Газон
        "5" => 20000, //Фура
    );

    Glob::$vars['prod_qty_limit'] 
    */
    
    /**
     * Сохранение текущей корзины в сессию
     */
    public function save(){
        Glob::$vars['session']->set('cart_info',$this->cart_info);
        Glob::$vars['session']->save(); //Сохраним данные сессии
    }
    
}
