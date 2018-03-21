<?php
/**
 * main.php Файл инициализации основного модуля системы
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//Базовая инициализация MNBV
SysLogs::addLog('Start module ['.Glob::$vars['module'].']');
require_once MNBV_PATH . MOD_MODELSPATH . 'Lang.class.php';  //Класс работы со словарями
require_once CORE_PATH . MOD_MODELSPATH . 'DbMysql.class.php'; //Класс MySql
require_once CORE_PATH . MOD_MODELSPATH . 'SysStorage.class.php'; //Класс хранилищ данных
require_once MNBV_PATH . MOD_MODELSPATH . 'MNBVf.class.php'; //Класс базовых функций системы MNBV

//Инициализация текущего модуля
require_once MNBV_PATH . 'config/config.php';    //Базовый конфиг модуля
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/config.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/config.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового

require_once MNBV_PATH . 'config/storage.php'; //Настройки хранилищ
if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/config/storage.php')) require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/config/storage.php');  //Если есть пользовательский конфиг, то перечитаем его поверх дефолтового

if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/init.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/init.php'); //Пользовательский init, если есть
else require_once MNBV_PATH . 'init.php'; //Дефолтовый init, если нет пользовательского

if(file_exists(USER_MODULESPATH . MNBV_MAINMODULE . '/router.php'))  require_once (USER_MODULESPATH . MNBV_MAINMODULE . '/router.php'); //Пользовательский маршрутизатор, если есть
else require_once MNBV_PATH . 'router.php'; //Дефолтовый марщрутизатор, если нет пользовательского

require_once MNBVf::getRealFileName(MNBV_MAINMODULE,  MOD_MODELSPATH . 'MNBVDiscount.class.php'); //Класс работы со скидками. Можно убрать, если не используете каталог товаров.

$moduleFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], Glob::$vars['mnbv_module'] . '.php');
if(file_exists($moduleFile)) require_once ($moduleFile);
else { //Действие при ошибочном модуле - попробуем открыть модуль по-умолчанию
    Glob::$vars['mnbv_module'] = Glob::$vars['mnbv_def_module'];
    $moduleFile =  MNBVf::getRealFileName(Glob::$vars['mnbv_module'], Glob::$vars['mnbv_module'] . '.php');
    if(file_exists($moduleFile)) require_once ($moduleFile);
    else { //Действие при ошибочном модуле
        SysLogs::addError('Error: Wrong module ['.$moduleFile.']');
        MNBVf::render(MNBVf::getRealTplName(MNBV_DEF_TPL,'404.php'),array(),Glob::$vars['tpl_mode']);
    }
}
