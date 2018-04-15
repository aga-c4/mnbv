<?php
/**
 * constants.php Основные константы MNBV TODO - Отредактируйте под свою конфигурацию, если не подходит дефолтовая
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

//define("MNBV_TEST_CONST",true);

#################################################################
## Константы системы MNBV
#################################################################

if (!defined("MNBV_MAINMODULE")) 
/**
 * Путь к модулю ядра CMS.MNBV, если установлена и используется
 */
define("MNBV_MAINMODULE",'mnbv');

if (!defined("MNBVSID")) 
/**
 * Идентификатор технической стабильной сессии на MNBVSID_TTL секунд если нет основного идентификатора PHPSESSID, то он заберется из этого
 */
define("MNBVSID",'MNBVSID');

if (!defined("MNBVSID_TTL")) 
/**
 * Время жизни куки MNBVSID в секундах
 */
define("MNBVSID_TTL",2592000); //30 дней

if (!defined("MNBVSIDSHORT")) 
/**
 * Идентификатор технической стабильной сессии, которая живет только во время текущей сессии
 */
define("MNBVSIDSHORT",'MNBVSIDSHORT');

if (!defined("MNBVSIDLONG")) 
/**
 * Идентификатор сессии персонализации, которая живет максимально долго (до конца эпохи Unix)
 */
define("MNBVSIDLONG",'MNBVSIDLONG');

if (!defined("MNBVSIDLV")) 
/**
 * Дата последнего захода Unix метка времени
 */
define("MNBVSIDLV",'MNBVSIDLV');

if (!defined("MNBVSID_TO_PHPSESSID")) 
/**
 * Если нет идентификатора сессии, а кука MNBVSID существует, то взять идентификатор из этой куки (true/false)
 */
define("MNBVSID_TO_PHPSESSID",true);

if (!defined("MNBV_MAINMODULE")) 
/**
 * Путь к модулю ядра MNBV
 */
define("MNBV_MAINMODULE",'mnbv');

if (!defined("MNBV_PATH")) 
/**
 * Путь к модулю ядра MNBV
 */
define("MNBV_PATH",'modules/mnbv/');

if (!defined("MNBV_DEF_TPL_FOLDER")) 
/**
* Путь к основной папке с шаблонами MNBV 
*/
define("MNBV_DEF_TPL_FOLDER",'templates/');

if (!defined("MNBV_TPL_FOLDER")) 
/**
* Путь к папке с пользовательскими шаблонами MNBV - имеют приоритет перед дефолтовыми. Если идентична основной папке, то работаем без пользовательских шаблонов.
*/
define("MNBV_TPL_FOLDER",MNBV_DEF_TPL_FOLDER);

if (!defined("MNBV_DEF_TPL")) 
/**
 * Шаблон MNBV по-умолчанию
 */
define("MNBV_DEF_TPL",'default');

if (!defined("MNBV_DEF_TPL_PATH")) 
/**
 * Путь к папке с шаблоном по-умолчанию MNBV
 */
define("MNBV_DEF_TPL_PATH", MNBV_TPL_FOLDER . MNBV_DEF_TPL . '/');

if (!defined("MNBV_DEF_SITE_STORAGE")) 
/**
 * Стартовое хранилище сайта MNBV по-умолчанию
 */
define("MNBV_DEF_SITE_STORAGE",'site');

if (!defined("MNBV_DEF_SITE_OBJ")) 
/**
 * Стартовая страница сайта MNBV по-умолчанию
 */
define("MNBV_DEF_SITE_OBJ",1);

//Пути к WWW папкам ---------------------------------------------

if (!defined("WWW_SRCPATH")) 
/**
 * Путь к директории со статикой модулей
 */
define("WWW_SRCPATH",'/src/');

if (!defined("WWW_IMGPATH")) 
/**
 * Путь к директории img модуля mnbv
 */
define("WWW_IMGPATH",WWW_SRCPATH.'mnbv/img/');

if (!defined("WWW_DUMPPATH")) 
/**
 * Путь к директории tmp
 */
define("WWW_DUMPPATH",'/tmp/');

if (!defined("MNBV_WWW_DATAPATH")) 
/**
 * Путь к директории приложенных файлов хранилищ через http
 */
define("MNBV_WWW_DATAPATH", '/data/');

if (!defined("MNBV_WWW_DATAPATH_SEC")) 
/**
 * Путь к закрытой директории приложенных файлов хранилищ через http
 */
define("MNBV_WWW_DATAPATH_SEC", '/sdata/');
