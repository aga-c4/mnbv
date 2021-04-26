<?php
/**
 * MNBVf.class.php Библиотека функций скидок
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class MNBVDiscount {

    /**
     * Расчитывает цену товара с учетом пользовательских скидок и акций. Скидки поглощаются и используется максимальная скидка. В настоящий момент применяет только скидку пользователя
     * если надо, то можно сделать более гибкий механизм работы со скидками, в задачи базовой конфигурации это не входит, однако лимиты для скидок заложены во всех объектах.
     * Скидки пользователей - это верхние уровни скидок, применяется тот из них, который более строго регулирует цену. К примеру может быть задано скидка 10%, но не более 10 тысяч рублей.
     * @param type $productId - идентификатор товара
     * @param $price - базовая цена, на базе которой высчитывается цена со скидкой
     * @param $cost - расходы на единицу товара (нужны для расчета органичения по марже)
     * @param array $params array:
     * 'user' = 'current' - считается цена со скидкой для текущего пользователя (по-умолчанию), если там идентификатор, то считается для выбранного пользователя, если не задано, то без учета пользователя
     * 'discmaxpr' - максимальная скидка в % - передается из свойств товара. Если 0, то без ограничений! ограничивайте каким-то минимальным процентом.
     * 'discmaxval' - максимальная скидка от маржи в валюте - передается из свойств товара. Если 0, то без ограничений! ограничивайте каким-то минимальным процентом.
     * 'minmargpr' - порог маржи в процентах, ниже которого скидка не может быть
     * 'minmargval' - порог маржи в рублях, ниже которого скидка не может быть
     * Максимальная скидка в валюте и % устанавливаются в категори/товаре и копируются во все объекты ниже до товара.
     * Соответственно прямо из товара мы всегда можем получить максимальные скидки обоих видов в том же запросе что и сведения о товаре.
     * Передадим эти максимальные скидки сюда через параметры.
     */
    public static function getPrice ($productId, $price = 0, $cost=0, array $params = array('user' => 'current','discmaxpr'=>0,'discmaxval'=>0,'discminmargpr'=>0,'discminmargval'=>0)){
        if (!is_array($params)||empty($params['user'])) return $price;
        
        $productId = intval($productId);
        $finPrice = 0;
        if (isset($params['user']) && $params['user']=='current') { //Посчитаем базовую скидку для текущего пользователя

            $discount = Glob::$vars['user']->get("discount");
            $discpr = floatval(Glob::$vars['user']->get("discpr"));
            $discval = floatval(Glob::$vars['user']->get("discval"));
                 
            if (empty($discount) || $discpr==0 || $discval==0) return $price; //Одно из ограничений не позволяет делать скидки.
            
            //Проверка по скидке в валюте
            $curPrice = $price - $discval;
            if ($curPrice>$finPrice) $finPrice = $curPrice;
            
            //Проверка по скидке в процентах
            $curPrice = $price*(100-$discpr)/100;
            if ($curPrice>$finPrice) $finPrice = $curPrice;
            
        } else {
            $finPrice = $price;
        }
        
        //Общие проверки по максимальным порогам, связанным с товаром.
        $discmaxpr = SysBF::getFrArr($params,'discmaxpr',0,'floatval');
        $discmaxval = SysBF::getFrArr($params,'discmaxval',0,'floatval');
        $discminmargpr = SysBF::getFrArr($params,'discminmargpr',0,'floatval');
        $discminmargval = SysBF::getFrArr($params,'discminmargval',0,'floatval');
        
        //Проверка по макс скидке на товар в валюте
        if ($discmaxval>0){
            $curPrice = $price - $discmaxval;
            if ($curPrice>$finPrice) $finPrice = $curPrice;
        }

        //Проверка по макс скидке на товар в процентах
        if ($discmaxpr>0){
            $curPrice = $price*(100-$discmaxpr)/100;
            if ($curPrice>$finPrice) $finPrice = $curPrice;
        }

        //Проверка по минимальной марже на товар в валюте
        if ($discminmargval){
            $curPrice = $cost + $discminmargval;
            if ($curPrice>$finPrice) $finPrice = $curPrice;
        }

        //Проверка по минимальной марже на товар в процентах
        if ($discminmargpr){
            $curPrice = $cost + $price*$discminmargpr/100;
            if ($curPrice>$finPrice) $finPrice = $curPrice;
        }

        if ($finPrice>$price) $finPrice = $price;
        
        return sprintf ("%01.2f", $finPrice);
     
    }
    

}
