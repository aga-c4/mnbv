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
     * @param type $productId - идентификатор товара
     * @param $price - базовая цена, на базе которой высчитывается цена со скидкой
     * @param array $params array:
     * 'user' = 'current' - считается цена со скидкой для текущего пользователя (по-умолчанию), если там идентификатор, то считается для выбранного пользователя, если не задано, то без учета пользователя
     */
    public static function getPrice ($productId, $price = 0, array $params = array('user' => 'current')){
        $productId = intval($productId);
        
        if (empty($params['user'])) {
            return $price;
        }elseif ($params['user']=='current') { //Посчитаем базовую скидку для текущего пользователя
            $discount = Glob::$vars['user']->get("discount");
            $discpr = Glob::$vars['user']->get("discpr");
            $discval = Glob::$vars['user']->get("discval");
            if (empty($discount)){
                return $price;
            }else{
                if ($discpr!==null){
                    $dprice = sprintf ("%01.2f", $price*(100-$discpr)/100);
                    return $dprice;
                }elseif($discval!==null){
                    $dprice = sprintf ("%01.2f", $price - $discval);
                    return $dprice;
                }
            }
        }
        return $price;
     
    }
    

}
