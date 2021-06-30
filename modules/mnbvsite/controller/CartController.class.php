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

        $cart = MNBVCart();
        
        if (SysBF::getFrArr(Glob::$vars['request'],'viewonlylistsize')) {
            $viewOnlyListSize = true;
        }
        
        //Действия в рамках данного контроллера
        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');
        $prodId = SysBF::getFrArr(Glob::$vars['request'],'prodid',0,'intval');
        $prodQty = SysBF::getFrArr(Glob::$vars['request'],'prodqty',1,'intval');
        $delivId = SysBF::getFrArr(Glob::$vars['request'],'delivid',0,'intval');
        $payId = SysBF::getFrArr(Glob::$vars['request'],'payid',0,'intval');
        
        if ($act==='add'){ //Добавление позиции
            $cart->addItem($prodId,$prodQty);
        }elseif($act==='upd'){ //Редактирование позиции
            $cart->updateItem($prodId,$prodQty);
        }elseif($act==='rem'){ //Удаление позиции
            $cart->remItem($prodId);
        }elseif($act==='clear'){ //Удаление позиции
            $cart->clearCart($prodId);
        }
        
        if (!empty($act)) { //Если были правки по корзине, пересчитаем и сохраним
            
            if(!empty($delivId)) $cart->setDeliv($delivId);
            if(!empty($payId)) $cart->setPay($payId);
        
            $cart->recount();
            $cart->save();
            
        }
        
        if (!empty($viewOnlyListSize)) { //Режим для аяксовых запросов или подтягивания корзины из шаблона
            $tpl_mode = 'json';
            $item = $cart->getQty();
        }else{
            
            $item['cart_items'] = $cart->getItemsList();
            $item['cart_delivery'] = $cart->getDeliveryList();
            $item['cart_pay'] = $cart->getPayList();
                    
            //Блок контента, который будет выводиться в шаблоне
            $item['page_sctpl'] = 'tpl_cart.php'; //Шаблон
        }

        //View------------------------
        MNBVf::render(Glob::$vars['mnbv_tpl_file'],$item,$tpl_mode);
        
        //Запишем конфиг и логи, если этого не произошлов в конце шаблона
        if (!SysLogs::$logComplete) MNBVf::putFinStatToLog();

    }

}
