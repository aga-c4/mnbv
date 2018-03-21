<?php
/**
 * Корневой файл модуля
 *
 * Created by Konstantin Khachaturyan (AGA-C4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Glob::$vars['mnbv_tpl'] = 'default'; //Название текущего дизайна
require_once MNBVf::getRealFileName(MNBV_MAINMODULE, 'modules_index.php'); //Дефолтовый инит модуля
Glob::$vars['session']->save(); //Сохраним данные сессии
