<?php
/**
 * Auth Controller - контроллер авторизации
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class CartController extends AbstractMnbvsiteController {

    /**
     * Метод по-умолчанию
     * @param $item массив $item, сформированный в родительском контроллере
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($item=array(),$tpl_mode='html', $console=false){

        if (SysBF::getFrArr(Glob::$vars['request'],'onlyqty')) {
            
            $cart = new MNBVCart(array("qty_type"=>'qty'));
            $tpl_mode = 'json';
            $item = $cart->getQty();
            
        }else{
            
            //Действия в рамках данного контроллера
            $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'routeitem');
            $prodId = SysBF::getFrArr(Glob::$vars['request'],'prodid',0,'intval');
            $itemId = SysBF::getFrArr(Glob::$vars['request'],'itemid',0,'intval');
            $prodQty = SysBF::getFrArr(Glob::$vars['request'],'prodqty',1,'intval');
        
            $cart = new MNBVCart();
            $cart_items = $cart->getItemsList();
        
            $res = false;
            if ($act==='add'){ //Добавление позиции
                $res = $cart->addItem($prodId,$prodQty);
            }elseif($act==='upd'){ //Редактирование позиции
                $crtitemArr = SysBF::getFrArr(Glob::$vars['request'],'crtitem',array());
                foreach ($crtitemArr as $itemId){
                    $curItemQty = SysBF::getFrArr(Glob::$vars['request'],'qty'.$itemId,'not-set');
                    if ($curItemQty === 'not-set') continue;
                    $curItemQty = intval($curItemQty);
                    if (!empty($cart_items["list"]["$itemId"]) && $cart_items["list"]["$itemId"]["qty"]!==$curItemQty){
                        $res2 = $cart->updateItem($itemId,$curItemQty);
                        if ($res2) $res = true; //Есть хоть какие-то изменения - будем обновлять список
                    }
                }
            }elseif($act==='rem'){ //Удаление позиции
                $res = $cart->remItem($itemId);
            }elseif($act==='clear'){ //Удаление позиции
                $res = $cart->clearCart($prodId);
            }

            if (!empty($act) && $res) { //Если были правки по корзине, пересчитаем и сохраним
                $cart->recount(); //Пересчет корзины
                $cart->save();
            }

            $item['cart_qty'] = $cart->getQty();
            $item['cart_items'] = $cart->getItemsList();

            //Блок контента, который будет выводиться в шаблоне
            $item['page_sctpl'] = 'tpl_cart.php'; //Шаблон
        
        }

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }

}
