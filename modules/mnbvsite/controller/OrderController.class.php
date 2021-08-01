<?php
/**
 * Контроллер корзины
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 24.08.17
 * Time: 00:00
 */
class OrderController extends AbstractMnbvsiteController {

    /**
     * @var string идентификатор текущего используемого хранилища
     */
    private $storage = 'orders';
    
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
     * Метод по-умолчанию
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        $thisTime = time();
        $thisDateTime = date("Y-m-d H:i:s",$thisTime);
        //$this->setStorage('carts');
        
        //Действия в рамках данного контроллера
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'routeitem');
        $delivId = SysBF::getFrArr(Glob::$vars['request'],'delivid',null,'intval',false);
        $payId = SysBF::getFrArr(Glob::$vars['request'],'payid',null,'intval',false);
        
        $instockSess0 = $instockSess = Glob::$vars['session']->get('order_instock');
        if ($instockSess !== true) $instockSess = false;
        if (isset(Glob::$vars['request']['instock']) && Glob::$vars['request']['instock'] === 'true') $instockSess = true;
        if (isset(Glob::$vars['request']['instock']) && Glob::$vars['request']['instock'] === 'false') $instockSess = false;
        if ($instockSess !== $instockSess0) {
            Glob::$vars['session']->set('order_instock',$instockSess);
            Glob::$vars['session']->save(); //Сохраним данные сессии        
        }
        
        $params = array("qty_type" => ($instockSess)?'instock':'' );
        if ($act==='upd'){
            if ($delivId!==null) $params["deliv_type_id"] = $delivId;
            if ($payId!==null) $params["pay_type_id"] = $payId;            
        }
        
        $cart = new MNBVCart($params);
        $item['cart_qty'] = $cart->getQty();
        $item['cart_items'] = $cart->getItemsList();
        $item['cart_instock_status'] = $instockSess;
        
        $item['ordcond_ok'] = $ordcond = SysBF::getFrArr(Glob::$vars['request'],'ordcond',$cart->get('ordcond_ok'));
        $item['ordconfirm_ok'] = $ordconfirm = SysBF::getFrArr(Glob::$vars['request'],'ordconfirm',$cart->get('ordconfirm_ok'));
        
        //Получим текущие значения информационных полей заказа
        $item['sub_obj'] = $updateArr = $cart->get('update_arr',array());
        $item['sub_obj']['vars'] = $varsArr = $cart->get('vars_arr',array());
        $item['sub_obj']['attr'] = $attrValsArr = $cart->get('attr_vals_arr',array());
        
        $storage = $this->getStorage();
        $folderId = (!empty($item['obj']['vars']['script_folder']))?intval($item['obj']['vars']['script_folder']):1;   
        
        //Структура формы работы с данными важно определить ее до операций над объектом
        $form_folder = array(
            "surname" => array("name"=>"surname", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "firstname" => array("name"=>"firstname", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "patronymic" => array("name"=>"patronymic", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "email" => array("name"=>"email", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "subscribe" => array("name"=>"subscribe", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
            "phone" => array("name"=>"phone", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "adress" => array("name"=>"adress", "type"=>"textarea", "print_name"=>"Delivery adress", "editor"=>false,"rows"=>4,"width"=>"100%","table" =>"thline","checktype" => "text"),            
            "text" => array("name"=>"text", "type"=>"textarea", "print_name"=>"Message", "editor"=>false,"rows"=>4,"width"=>"100%","table" =>"thline","checktype" => "text"),            
            "clear1" => array("name"=>"clear1", "type"=>"lineblock", "table" =>"thline", "string"=>"Receiver info"),
            "receiverpay" => array("name"=>"receiverpay", "type"=>"checkbox", "table" =>"td", "checktype" => "on"),
            "rsurname" => array("name"=>"rsurname", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "rfirstname" => array("name"=>"rfirstname", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),
            "rpatronymic" => array("name"=>"rpatronymic", "type"=>"text", "size"=>255,"width"=>"100%","checktype" => "text"),       
        );

        
        //$item['sub_obj'] = MNBVf::createStorageObject($this->getStorage(),$folderId,array('altlang'=>Glob::$vars['mnbv_altlang']));//Объект для редактирования найден
        $item['sub_obj']['sub_obj_storage'] = $storage; 
        $item['sub_obj']['folderid'] = $folderId;   
        $item['sub_obj']['form_folder'] = $form_folder;

        SysLogs::addLog('Select mnbv script storage: [' . $storage . ']');
        SysLogs::addLog('Select mnbv script storage folder: [' . $folderId . ']');
        
        
        $orderSend = false;
        if ($act==='upd'){
            $cart->save();
        } elseif ($act==='updinfo' || $act==='send'){
                        
            $mainUpd = $varsArrUpd = $attrValsArrUpd = false; //Маркеры необходимости редактирования
            foreach(Glob::$vars['request'] as $key=>$value){
                if (preg_match("/^ob_/",$key) && $key!='ob_visible' && $key!='ob_first' && $key!='ob_id') {
                    $realKey = preg_replace("/^ob_/","",$key);
                    if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["$realKey"]))continue;
                    $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["$realKey"];
                    if ($realKey=='typeval') $realKeyView = array("name"=>"typeval", "type"=>"text", "size"=>255,"width"=>"70%","checktype" => "url");
                    else $realKeyView = $item['sub_obj']['form_folder']["$realKey"];                            
                    $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                    $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';
                    $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='ob_',$prefKey='obk_', $prefUpd='obd_');
                    if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                    $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';
                    $updateArr["$realKey"] = SysBF::checkStr($value,$checkType);    
                    $mainUpd = true;
                }elseif (preg_match("/^obv_/",$key)) {
                    $realKey = preg_replace("/^obv_/","",$key);
                    if (!isset(SysStorage::$storage[$this->getStorage()]["stru"]["vars"]["list"]["$realKey"]))continue;
                    $realKeyStru = SysStorage::$storage[$this->getStorage()]["stru"]["vars"]["list"]["$realKey"];
                    $realKeyView = $item['sub_obj']["vars"]["view"]["$realKey"];
                    $keyType = ($realKeyStru["dbtype"])?$realKeyStru["dbtype"]:'';
                    $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';                            
                    $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='obv_',$prefKey='obvk_', $prefUpd='obvd_');
                    if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                    $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';                            
                    if (!empty($value)) $varsArr["$realKey"] = SysBF::checkStr($value,$checkType); 
                    elseif(isset($varsArr["$realKey"]))unset($varsArr["$realKey"]);
                    $varsArrUpd = true;
                }elseif (preg_match("/^obav_/",$key)) {                           
                    $realKey = preg_replace("/^obav_/","",$key);
                    if (!isset($item["sub_obj"]["attrview"]["$realKey"]))continue;
                    $realKeyView = $item["sub_obj"]["attrview"]["$realKey"];
                    $keyType = ($realKeyView["dbtype"])?$realKeyView["dbtype"]:'';
                    $keyViewType = ($realKeyView["type"])?$realKeyView["type"]:'';                            
                    $value = MNBVf::updateValsByType($realKey,$keyType,$keyViewType,$value,$prefView='obav_',$prefKey='obavk_', $prefUpd='obavd_');
                    if ($realKey=='passwd'&&$value=='')continue; //Исключение - если пароль пустой, то не меняем его
                    $checkType = (isset($realKeyView["checktype"]))?$realKeyView["checktype"]:'';                           
                    if (!empty($value)) $attrValsArr["$realKey"] = SysBF::checkStr($value,$checkType); 
                    elseif(isset($attrValsArr["$realKey"]))unset($attrValsArr["$realKey"]);
                    $attrValsArrUpd = true;                              
                }

            }
            
            //Сохраним информацию о клиенте и заказе
            if ($mainUpd) {
                $cart->set('update_arr',$updateArr);
                $item['sub_obj'] = $updateArr;
                $item['sub_obj']['sub_obj_storage'] = $storage; 
                $item['sub_obj']['folderid'] = $folderId;   
                $item['sub_obj']['form_folder'] = $form_folder;
            }
            if ($varsArrUpd) {
                $cart->set('vars_arr',$varsArr);
                $item['sub_obj']['vars'] = $varsArr;
            }
            if ($attrValsArrUpd) {
                $cart->set('attr_vals_arr',$attrValsArr);
                $item['sub_obj']['attr'] = $attrValsArr;
            }
            
            $cart->set('ordcond_ok',$ordcond);
            $cart->set('ordconfirm_ok',$ordconfirm);
            
            $item['ordcond_ok'] = $ordcond;
            $item['ordconfirm_ok'] = $ordconfirm;
        
            $cart->save();
                
        }
        
        
        if ($act==='send'){
            //Создадим заказ
            $updateArr["parentid"] = $folderId; 
            $updateArr["visible"] = 1; 
            $updateArr["first"] = 0;
            $updateArr["type"] = 0;
            
            if (count($varsArr)>0) $updateArr["vars"] = json_encode($varsArr); else $updateArr["vars"] = '';
            if (count($attrValsArr)>0) $updateArr["attrvals"] = json_encode($attrValsArr); else $updateArr["attrvals"] = '';
            $updateArr["attr"] = '';
            
            $cartInfo = $cart->getCartInfo();
            if (count($cartInfo)>0) $updateArr["cart_info"] = json_encode($cartInfo); else $updateArr["cart_info"] = '';
            if (count($item['cart_items'])>0) $updateArr["cart_items"] = json_encode($item['cart_items']); else $updateArr["cart_items"] = '';
            
            //Сформируем HTML отображение заказа, чтоб пока не морочиться
            $prod_currency_suf = Glob::$vars['prod_currency_suf'];
            $ret_str = '
<style>
table, tr, td, th, tbody{
    width:100%;
    display:block;
}

thead{
    display:none;
}
    
@media (min-width:768px){
    table{
        display:table;
        width:auto;
    }
    tbody, thead{
        display:table-row-group;
        width:auto;
    }
    tr{
        display:table-row;
        width:auto;
    }
    td, th{
        display:table-cell;
        width:auto;
    }
}
</style>

<table class="table table-striped w-100">
    <thead class="table-light">
        <tr class="tblhead">

                <th>
                <th  class="tlbhead" width="100%">Товар</th>
                <th style="min-width:100px;">Цена, '.$prod_currency_suf.'</th>
                <th style="min-width:50px;">Кол.</th>
                <th style="min-width:100px;">Сумма, '.$prod_currency_suf.'</th>
            </tr>
        </thead>
        
        <tbody>
';
            $counter = 0;
            foreach($item['cart_items']['list'] as $value) {
                $counter++;
$ret_str .= '
            <tr>
                <th>'.$counter.'</th>
                <td><a href="'.SysBF::getFrArr($value,'url','').'">'.SysBF::getFrArr($value,'name','').'</a>'; 
                if (!empty($value["deficit"])){
                    $ret_str .= '<br>'.((!empty($value["instock"]))?('<b>В наличии '.$value["instock"].' ед.</b> / '):'')
                        .'<b class="text-danger">Под заказ '.$value["deficit"].' ед.</b>';    
                } else  {
                    $ret_str .= '<br><b>Есть в наличии</b>';
                } $ret_str .= '</td>';
$ret_str .= '
                <td>'.SysBF::getFrArr($value,'price','').'</td>
                <td>'.SysBF::getFrArr($value,'qty',0).'</td>
                <td>'.SysBF::getFrArr($value,'itemsum','').'</td>
            </tr>
';
            }
            
$ret_str .= '            
        </tbody>
    </table>
';
            
            $ret_str .= '
<div class="mt-3">
    Стоимость товаров: '.SysBF::getFrArr($item['cart_items'],'prsum',0).' '.Glob::$vars['prod_currency_suf'].'<br>
    Включая скидку: '.SysBF::getFrArr($item['cart_items'],'prdisc',0).' '.Glob::$vars['prod_currency_suf'].'<br>
    Масса товара: '.SysBF::getFrArr($item['cart_items'],'weight',0).' кг<br>
    Количество товара: '.SysBF::getFrArr($item['cart_items'],'qty',0).' шт<br>
    Объем товара: '.SysBF::getFrArr($item['cart_items'],'volume',0).' м3<br>
    Высота: '.SysBF::getFrArr($item['cart_items'],'height',0).' cм<br>
    Мин. ширина/глубина: '.SysBF::getFrArr($item['cart_items'],'minw',0).' см<br>
    Макc. ширина/глубина: '.SysBF::getFrArr($item['cart_items'],'maxw',0).' см<br>
</div>

<div class="mt-3"><br><br>
';

            foreach ($form_folder as $key => $value) {
                if (false!== strpos($key, "clear")) continue;
                $itemName = Lang::get($key,"sysBaseObj","","ru");
                $itemVal = SysBF::getFrArr($updateArr,$key,'');
                $ret_str .= "<b>$itemName:</b> $itemVal<br>\n";            
            }
$ret_str .= '</div>';      
            $updateArr["htmlview"] = $ret_str;

            $updateArr["author"] = Glob::$vars['user']->get('name');
            $updateArr["edituser"] = Glob::$vars['user']->get('userid');
            $updateArr["editdate"] = $thisTime;
            $updateArr["editip"] = GetEnv('REMOTE_ADDR');
            
            $updateArr['name'] = date("Y-m-d H:i").' '.MNBVf::substr($updateArr["surname"].' '.$updateArr["firstname"].' '.$updateArr["patronymic"],0,255,true);
            //$updateArr["text"] = preg_replace("/\r\n/","<br>",$updateArr["text"]);
            //$updateArr["text"] = preg_replace("/\n/","<br>",$updateArr["text"]);
            $updateArr["userid"] = Glob::$vars['user']->get('userid');

            if ($counter>0){
                $res = MNBVStorage::addObj($this->getStorage(), $updateArr,'',false);
                SysLogs::addLog("Create order /".$this->getStorage()."/" . (($res)?($res.'/ successful!'):' error!'));

                //Очистим корзину
                $cart->clearCart();

                //Сохраним остатки корзины в сессию если надо
                $cart->save();            

                //Передадим в форму идентификатор заказа и все данные по нему.
                if ($res) $item['order_id'] = $res;
                $orderSend = true;
            }
        }
        
        //Шаблон вывода списка объектов
        if (!empty($orderSend)) {
            $item['page_sctpl'] = 'tpl_ordersend.php'; //По-умолчанию
        } else {
            $item['page_sctpl'] = 'tpl_orderedit.php'; //По-умолчанию
        }
        //$item['page_sctpl'] = 'tpl_ordersend.php'; //По-умолчанию
        if (!empty($item['obj']['vars']['script_tpl_file'])) $item['page_sctpl'] = $item['obj']['vars']['script_tpl_file']; //Если задан в Переменных скрипта в объекте
        SysLogs::addLog('Select mnbv script tpl file: [' . $item['page_sctpl'] . ']');

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();
        
    }
    
}
