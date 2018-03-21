<?php
/**
 * Корневой файл модуля
 */

//Glob::$vars['mnbv_tpl'] = 'default'; //Название текущего дизайна
require_once MNBVf::getRealFileName(MNBV_MAINMODULE, 'modules_index.php'); //Дефолтовый инит модуля
Glob::$vars['session']->save(); //Сохраним данные сессии
