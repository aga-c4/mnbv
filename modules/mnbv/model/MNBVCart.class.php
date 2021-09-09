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
     * @var type учитывать только позиции в рамках наличия (работает при формировании заказа) 
     */
    private $instock = false;
    
    /**
     * @var array общие данные по корзине (доставка, оплата, адреса, ...) 
     */
    private $cartInfo = array();
    
    /**
     * @var array элементы корзины 
     */
    private $cartItems = array();
    
    /**
     * @var array элементы корзины, которых нет в наличии
     */
    private $cartItemsNST = array();
    
    /**
     * @var array допустимые варианты оплаты 
     */
    private $cartPayTypes = array();
    
    /**
     * @var array допустимые варианты доставки 
     */
    private $cartDelivTypes = array();
    
    /**
     * @var array индекс элементов корзины по товарам 
     */
    private $cartProdItemIds = array();    
    
    /**
     * @var array добавленные или удаленные позиции корзины для счетчиков
     */
    private $addCartItems = null;
    
    /**
     * @var type идентификатор сайта для данной корзины 
     */
    private $siteid = 0;
    
    /**
     * @var type параметры инициализации корзины
     */
    private $params = array();
    
    /**
     * @var array добавленные или удаленные позиции корзины для счетчиков
     */
    private $remCartItems = null;
    
    public function __construct($params=array()){
        
        if (!is_array($params)) $params = array();
        $this->params = $params;
        
        $qtyType = SysBF::getFrArr($params,'qty_type','');
        $prStorage = SysBF::getFrArr($params,'pr_storage','');
        $ordStorage = SysBF::getFrArr($params,'ord_storage','');
        
        $this->siteid = Glob::$vars['mnbv_site']['id'];
        if (!empty($prStorage)) $this->prStorage = $prStorage;
        if (!empty($ordStorage)) $this->ordStorage = $ordStorage;

        
        if ($qtyType==='qty'){ //Только количество
            
            $this->qty = 0;

            $quFilterArr = array(); //Фильтры

            if (Glob::$vars['user']->get('userid')){ //Авторизованный пользователь
                $quFilterArr = array("userid","=",Glob::$vars['user']->get('userid'));
            }else{
                $quFilterArr = array("sessid","=",Glob::$vars['session']->sid);
            }
            if (!empty($this->siteid)){
                array_push($quFilterArr, "and",array("siteid","=",$this->siteid,"or","siteid","=",0));
            }
            
            $stRes = MNBVStorage::getObj(
                'cartitems',
                array(array("sum(qty)","qty")),
                $quFilterArr);
            $this->qty = (!empty($stRes[0])&&isset($stRes[1])&&isset($stRes[1]['qty']))?intval($stRes[1]['qty']):0;

        }else{
            
            if ($qtyType==='instock') $this->instock = true;
        
            $this->cart_info = Glob::$vars['session']->get('cart_info');
            if (!is_array($this->cart_info)) $this->cart_info = array();

            $this->recount();
            
        }
        
    }
    
    /**
     * Получение позиций заказов из БД обогащенные данными по товарам
     * @return array
     */
    public function getItemsFrDb(){
        $result = array();
        //if (Glob::$vars['prod_qty_limit'] && $qty>$prodObj->quantity) $qty = $prodObj->quantity; 
            
        
        $quFilterArr = array(); //Фильтры
        
        if (Glob::$vars['user']->get('userid')){ //Авторизованный пользователь
            $quFilterArr = array("userid","=",Glob::$vars['user']->get('userid'));
        }else{
            $quFilterArr = array("sessid","=",Glob::$vars['session']->sid);
        }
        if (!empty($this->siteid)){
            array_push($quFilterArr, "and",array("prd.siteid","=",$this->siteid,"or","prd.siteid","=",0));
            array_push($quFilterArr, "and",array("ci.siteid","=",$this->siteid,"or","ci.siteid","=",0));
        }
        array_push($quFilterArr, 
            "and","visible","=",1,
            "and","prd.type","=",0);
        
        $this->qty = 0;
        
        $item['list'] = MNBVStorage::getObjAcc(
            array(
                array('name'=>'cartitems','alias'=>'ci'),
                array('join'=>'left','name'=>'products', 'alias'=>'prd','on'=>array("prd.id","=","field::ci.prodid"))),
                
            array(array("ci.id","id"),"prodid","files","qty",array("ci.price","price"),"discval","discpr","promocode","ts","region",
                array("ci.brweight","brweight"),array("ci.brheight","brheight"),array("ci.brminw","brminw"),array("ci.brmaxw","brmaxw"),array("ci.brvolume","brvolume"),
                "name","namelang","alias",array("prd.price","prdprice"),"cost","discmaxpr","discmaxval","discminmargpr","discminmargval",array("prd.quantity","prdqty")),
            
            $quFilterArr,
            array("sort"=>array("ts"=>"inc"))
        );

        $item['list_size'] = (int)$item['list'][0]; unset($item['list'][0]); //Вынесем размер списка из массива 
        
        $result["list"] = array();
        //Размеры и вес
        $result["prsum"] = 0;
        $result["prdisc"] = 0;
        $result["weight"] = 0;
        $result["qty"] = 0;
        $result["volume"] = 0;
        $result["height"] = 0;
        $result["minw"] = 0;
        $result["maxw"] = 0;
        $result["deficit"] = 0;
        
        $this->cartProdItemIds = array();
        $urlmaster = new MNBVURL(2,Glob::$vars['url_types']); 
        
        $cartProdsQty = array();
        foreach ($item['list'] as $key=>$value) if ($key>0) {
            $itemId = $value["id"];
            $prodidStr = strval($value["prodid"]);
            
            $itemFiles = (!empty($value['files']))?MNBVf::updateFilesArr("products",$value["prodid"],$value['files']):array();
            
            $value["img"] = '';
            
            if (isset($itemFiles["img"])){
                if (isset($itemFiles["img"]["1"]) && $tecObjTxtCode = MNBVf::getObjCodeByURL(SysBF::getFrArr($itemFiles["img"]["1"],'src',''))){//Нашли специфический объект (видео, ютуб.....), выводим его 
                    $yuScrArr = MNBVf::getYoutubeScreenByURL(SysBF::getFrArr($itemFiles["img"]["1"],'src',''));
                    $value["img"] = SysBF::getFrArr($yuScrArr,'default','');
                } else {//Никакого специфического объекта не нашли, выводим изображения по стандартной схеме
                    if (isset($itemFiles['img']["1"])){ 
                        $value["img"] = SysBF::getFrArr($itemFiles["img"]["1"],'src_min','');
                        if (empty($value["img"])) $value["img"] = SysBF::getFrArr($itemFiles["img"]["1"],'url','');
                    }
                } 
            }
            
            if (!isset($cartProdsQty[$prodidStr])) $cartProdsQty[$prodidStr] = 0;
            $cartProdsQty[$prodidStr] += $value["qty"];
            $value["deficit"] = 0;
            if (Glob::$vars['prod_qty_limit'] && $cartProdsQty[$prodidStr]>$value["prdqty"]) {
                $value["deficit"] = $cartProdsQty[$prodidStr] - $value["prdqty"]; 
                $value["instock"] = $value["qty"] - $value["deficit"];
                $result["deficit"] += $value["deficit"];
                
                if (!empty($this->instock)){
                    if (empty($value["instock"])) continue;
                    $value["deficit"] = 0;
                    $value["qty"] = $value["instock"];
                }
            }
            
            if (!isset($this->cartProdItemIds[$prodidStr])) $this->cartProdItemIds[$prodidStr] = array();
            $this->cartProdItemIds[$prodidStr][] = $itemId;
            $this->qty += $value["qty"];
            
            //Расчитаем цену со скидкой для конкретного пользовтеля с учетом ограничений
            //TODO - необходимо доработать алгоритм с учетом макс скидок по вендорам, категориям и товарам. 
            //возможно на первом этапе это будет установка в категории этих порогов с перекрытием в отдельных товарах.
            //в таком случае работа будет вестись на уровне отдельных товаров, а категории и вендоры будут использоваться
            //для фильтрации при массовом назначении этого параметра. Видимо пока это оптимальный вариант.
            //discmaxpr - максимальная скидка в процентах
            //discmaxval - максимальная скидка в валюте
            //discminmargpr - порог маржи в процентах, ниже которого скидка не может быть
            //discminmargval - порог маржи в рублях, ниже которого скидка не может быть
            $discountParamsArr = array('user' => 'current','discmaxpr'=>$value["discmaxpr"],'discmaxval'=>$value["discmaxval"], 'discminmargpr'=>$value["discminmargpr"], 'discminmargval'=>$value["discminmargval"]);
            $value['discount_price'] = MNBVDiscount::getPrice($value["prodid"], $value["prdprice"], $value["cost"], $discountParamsArr);
            $value['itemsum'] = round($value['discount_price'] * $value["qty"],2);
            
            //Размеры и вес
            $result["prsum"] += $value['itemsum']; //Стоимость товаров 
            $result["prdisc"] += ($value["prdprice"] - $value['discount_price']) * $value["qty"]; //Включая скидку
            $result["weight"] += $value["brweight"] * $value["qty"]; //Масса товара
            $result["qty"] += $value["qty"]; //Количество товара
            $result["volume"] += $value["brvolume"] * $value["qty"]; //Объем товара
            if ($value["brheight"]>$result["height"]) $result["height"] = $value["brheight"]; //Высота
            if ($value["brminw"]>$result["minw"]) $result["minw"] = $value["brminw"]; //Мин. ширина/глубина
            if ($value["brmaxw"]>$result["maxw"]) $result["maxw"] = $value["brmaxw"]; //Мак. ширина/глубина
            
            //Формирование URL
            $value["url"] = $urlmaster->getURLById($value["prodid"],"products"); //Формирование URL из текущего адреса
        
            $result["list"]["$itemId"] = $value;
        }
        
        //Рассчет размеров, веса и допустимых вариантов доставки
        //Размерная категория
        $sizegr = 0;
        foreach(Glob::$vars['sizegr_types_levels'] as $key=>$vval) {
            if ($result["volume"]>$vval["v"]) continue;
            if (!empty($result["height"]) && $result["height"]>$vval["h"]) continue;
            if (!empty($result["maxw"]) && $result["maxw"]>$vval["l"]) continue;
            $sizegr = $key;
            break;
        }
        $result["sizegr"] = $sizegr;
        
        //Весовая категория
        $weightgr = 0;
        if (!empty($result["weight"])){
            foreach(Glob::$vars['weightgr_types_levels'] as $key=>$vval) {
                if ($result["weight"]>$vval) continue;
                $weightgr = $key;
                break;
            }
        }
        $result["weightgr"] = $weightgr;
        
        
        //Выбранный вариант доставки, если есть и если он присутствует в перечне допустимых
        $deliv_type_id = intval(SysBF::getFrArr($this->params,'deliv_type_id',$this->get('deliv_type_id')));
        $this->cartDelivTypes = MNBVStorage::getObj(
            'delivery',
            array("id","name","namelang","price","region","weightgr","sizegr","days","orderbefore"),
            array("type","=",0,"and","visible","=",1,
                "and",array("region","=",0,"or","region","=",Glob::$vars['mnbv_region']),
                "and",array("sizegr","=",0,"or","sizegr",">=",$sizegr),
                "and",array("weightgr","=",0,"or","weightgr",">=",$weightgr),
                "and",array("minprice","=",0,"or","minprice","<=",$result['prsum']),
                "and",array("maxprice","=",0,"or","maxprice",">=",$result['prsum']),
            //    "and",array("siteid","=",0,"or","siteid","=",$this->siteid)
            ),
            array("sort"=>array("parentid"=>"inc","price"=>"inc"),"group"=>"parentid")
        );
        $deliv_list_size = (int)$this->cartDelivTypes[0]; unset($this->cartDelivTypes[0]); //Вынесем размер списка из массива 
        $delivTypeFound = false;
        $delivPrice = 0;
        $delivDays = 0;
        $delivOrderbefore = 12;
        if (!empty($deliv_list_size)){
            foreach ($this->cartDelivTypes as $key=>$value) {
                if ($deliv_type_id===intval($value["id"])) {
                    $delivTypeFound = true;
                    $delivPrice = $value["price"];
                    $delivDays = $value["days"];
                    $delivOrderbefore = $value["orderbefore"];
                    $this->cartDelivTypes[$key]["selected"] = true; 
                }
            }
        }
        $old_deliv_type_id = $this->get('deliv_type_id');
        $this->set('old_deliv_type_id',$old_deliv_type_id);
        if ($delivTypeFound){
            $result["delivdays"] = $delivDays;
            $result["delivorderbefore"] = $delivOrderbefore;
            $result["delivsum"] = $delivPrice;
            $this->set('deliv_type_id',$deliv_type_id);
        }else{
            $deliv_type_id = 0;
            $this->set('deliv_type_id',$deliv_type_id);
            $result["delivsum"] = 0;
        }
        $result["deliv_type_id"] = $deliv_type_id;          
        $result["deliv_list"] = $this->cartDelivTypes;
        
        
        //Допустимые варианты оплаты исходя из цены корзины
        $pay_type_id = intval(SysBF::getFrArr($this->params,'pay_type_id',$this->get('pay_type_id')));
        $this->cartPayTypes = MNBVStorage::getObj(
            'payment',
            array("id","name","namelang","discpr","discpr","discval"),
            array("type","=",0,"and","visible","=",1,
                "and",array("minprice","=",0,"or","minprice","<=",$result['prsum']),
                "and",array("maxprice","=",0,"or","maxprice",">=",$result['prsum']),
            //    "and",array("siteid","=",0,"or","siteid","=",$this->siteid)
            ),
            array("sort"=>array("pozid"=>"inc","name"=>"inc"))
        );
        $pay_list_size = (int)$this->cartPayTypes[0]; unset($this->cartPayTypes[0]); //Вынесем размер списка из массива 
        $payTypeFound = false;
        $payDiscpr = 0;
        $payDiscval = 0;
        if (!empty($pay_list_size)){
            foreach ($this->cartPayTypes as $key=>$value) {
                if ($pay_type_id===intval($value["id"])) {
                    $payTypeFound = true;
                    $payDiscpr = $value["discpr"];
                    $payDiscval = $value["discval"];
                    $this->cartPayTypes[$key]["selected"] = true; 
                }
            }
        }
        $old_pay_type_id = $this->get('pay_type_id');
        $this->set('old_pay_type_id',$old_pay_type_id);
        if ($payTypeFound){
            //Проверка по скидке в валюте
            $price = $result['prsum'] + $result["delivsum"];
            $curPrice = $result['prsum'] + $result["delivsum"] - $payDiscval;
            if ($curPrice<$price) $price = $curPrice;
            
            //Проверка по скидке в процентах
            $curPrice = ($result['prsum'] + $result["delivsum"]) * (100-$payDiscpr)/100;
            if ($curPrice<$price) $price = $curPrice;
            $this->set('pay_type_id',$pay_type_id);
            $result["finsum"] = $price; //Стоимость товаров             
        }else{
            $pay_type_id = 0;
            $this->set('pay_type_id',$pay_type_id);
            $result["finsum"] = $result['prsum']; //Стоимость товаров             
        }
        $result["pay_type_id"] = $pay_type_id;
        $result["pay_list"] = $this->cartPayTypes;
        
        return $result;
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
     * @param $def Значение, если элемент не найден
     * @return mixed Результат операции
     */
    public function get($key,$def=null)
    {
        return (isset($this->cart_info["$key"]))?$this->cart_info["$key"]:(($def!==NULL)?$def:NULL);
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
        
        $qty = intval($qty);
        if (empty($qty)) $qty = 1;
        $prodId = intval($prodId);
        if (!empty($prodId) && $prodObj = MNBVf::getStorageObject(Glob::$vars['prod_storage'],$prodId,array('altlang'=>Lang::isAltLang(),'visible'=>true,'access'=>true,'site'=>true))){//Объект для редактирования найден
            $discountParamsArr = array('user' => 'current','discmaxpr'=>$prodObj["discmaxpr"],'discmaxval'=>$prodObj["discmaxval"],'discminmargpr'=>$prodObj["discminmargpr"],'discminmargval'=>$prodObj["discminmargval"]);
            $price = MNBVDiscount::getPrice($prodObj["id"], $prodObj["price"], $prodObj["cost"],$discountParamsArr);
        }else{
            return false;
        }
        
        $prodIdStr = strval($prodId);
        
        if (isset($this->cartProdItemIds[$prodIdStr])){ //Позиция найдена, добавим в последний элемент
        
            //TODO - впоследствии добавить сюда добавление новой позиции, если промокод старой не предполагает в ней добавления количества + проверку на мин колич по промокоду.

            $foundQty = 0;
            $summQty = $qty;
            $curItemId = 0;
            foreach ($this->cartProdItemIds[$prodIdStr] as $itemId){
                $foundQty = $this->cartItems["list"]["$itemId"]["qty"];
                $summQty = $foundQty + $qty;
                $curItemId = $itemId;
            }
            if (!empty($curItemId)) {
                MNBVStorage::setObj('cartitems', array("qty"=>$summQty), array("id",'=',$curItemId),false);
            }
            
        }else{ //Позиция НЕ найдена, добавим элемент            
            $updateArr = array(
                "sessid" => Glob::$vars['session']->sid,
                "userid" => (Glob::$vars['user']->get('userid'))?(Glob::$vars['user']->get('userid')):0,
                "prodid" => $prodId,
                "qty" => $qty,        
                "price" => $price,
                "discval" => round($prodObj["price"] - $price,2),
                "discpr" => round(1 - $price/$prodObj["price"],2),
                "promocode" => '',
                "ts" => time(),
                "region" => Glob::$vars['mnbv_region'],
                "brweight" => $prodObj["brweight"],
                "brheight" => $prodObj["brheight"],
                "brminw" => $prodObj["brminw"],
                "brmaxw" => $prodObj["brmaxw"],
                "brvolume" => $prodObj["brvolume"],
                "siteid" => $this->siteid,
            );
            
            $addItemId = MNBVStorage::addObj('cartitems', $updateArr,'',false);
        }

        return true;
    }
    
    /**
     * Удаляет позицию с заданным идентификатором из корзины.
     * @param $itemId Идентификатор удаляемой позиции корзину
     * @return mixed Результат операции
     */
    public function remItem($itemId){
        $itemId = intval($itemId);
        if (empty($itemId)) return false;
        
        if (isset($this->cartItems["list"]["$itemId"])){
            MNBVStorage::delObj('cartitems', array("id","=",$itemId),false);
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Удаляет позицию с заданным идентификатором из корзины.
     * @param $itemId Идентификатор удаляемой позиции корзину
     * @return mixed Результат операции
     */
    public function updateItem($itemId,$curItemQty){
        $itemId = intval($itemId);
        $curItemQty = intval($curItemQty);
        if (empty($itemId)) return false;
        if (empty($curItemQty)) {
            $this->remItem($itemId);
            return false;
        }
        
        if (isset($this->cartItems["list"]["$itemId"])){
            MNBVStorage::setObj('cartitems', array("qty"=>$curItemQty), array("id",'=',$itemId),false);
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * Очищает корзину и дополнительные поля, если есть.
     */
    public function clearCart(){
        if (!empty(Glob::$vars['user']->get('userid'))){ //Авторизованный пользователь
            MNBVStorage::delObj('cartitems', array("userid","=",Glob::$vars['user']->get('userid')),false);
        }else{
            MNBVStorage::delObj('cartitems', array("sessid","=",strval(Glob::$vars['session']->sid)),false);
        }
        $this->qty = 0;
        
        $this->set('deliv_type_id',0);
        $this->set('pay_type_id',0);            
        
        return true;
    }
    
    /**
     * Пересчитывает корзину и заполняет служебные переменные.
     */
    public function recount(){
        $this->cartItems = $this->getItemsFrDb();
        if (!is_array($this->cartItems)) $this->cartItems = array();
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
        return $this->cartItems;
    }
    
    public function getItemsListNST(){
        return $this->cartItemsNST;
    }
    
    public function setItemsList($lstArr){
        $this->cartItems = $lstArr;
    }
    
    public function getDeliveryList(){
        return $this->cartDelivTypes;
    }
    
    public function getPayList(){
        return $this->cartPayTypes;
    }
    
    public function getCartInfo(){
        return $this->cart_info;
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
