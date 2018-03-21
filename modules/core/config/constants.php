<?php
/**
 * constants.php Основные константы системы TODO - Отредактируйте под свою конфигурацию, если не подходит дефолтовая
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */

if (!defined("APP_DEBUG_MODE")) 
/**
 * Режим отладки true - активирован, false - не используется
 */
define("APP_DEBUG_MODE",true);

if (!defined("APP_MODULESPATH"))
/**
 * Путь к директории с основными модулями системы
 */
define("APP_MODULESPATH",'modules/');

if (!defined("USER_MODULESPATH")) 
/**
 * Путь к директории с пользовательскими модулями системы
 */
define("USER_MODULESPATH",'app/modules/');

if (!defined("CORE_PATH")) 
/**
 * Путь к модулю ядра фреймворка
 */
define("CORE_PATH",APP_MODULESPATH . 'core/');

if (!defined("USER_TEMPLATES")) 
/**
 * Путь к директории с пользовательскими шаблонами
 */
define("USER_TEMPLATES",'app/templates/');

if (!defined("APP_WWWPATH")) 
/**
 * Путь к корневой директории Web сервера
 */
define("APP_WWWPATH",'www/');

if (!defined("APP_VENDORS")) 
/**
 * Путь к директории с кодом вендоров
 */
define("APP_VENDORS",'vendors/');

if (!defined("APP_SRCPATH")) 
/**
 * Путь к директории со статикой (файлами и т.п.) из соображений безопасности можете разместить ее в корне движка и сделать линк на нее или ее части из директории www
 */
define("APP_SRCPATH",'src/');

if (!defined("APP_DUMPPATH")) 
/**
 * Путь к директории tmp
 */
define("APP_DUMPPATH",'tmp/');

if (!defined("APP_CACHEPATH")) 
/**
 * Путь к директории кеша
 */
define("APP_CACHEPATH", APP_DUMPPATH.'cache/');

if (!defined("APP_LOGSPATH")) 
/**
 * Путь к директории логов
 */
define("APP_LOGSPATH", APP_DUMPPATH.'logs/');

if (!defined("APP_UPLPATH")) 
/**
 * Путь к директории загрузки
 */
define("APP_UPLPATH", APP_DUMPPATH.'upl/');

if (!defined("APP_DATAPATH")) 
/**
 * Путь к директории приложенных файлов хранилищ
 */
define("APP_DATAPATH", 'data/');

if (!defined("APP_STORAGEFILEPATH")) 
/**
 * Путь к директории хранилищ файлов
 */
define("APP_STORAGEFILEPATH", APP_DATAPATH.'storages/file/');

if (!defined("APP_STORAGEARRAYPATH")) 
/**
 * Путь к директории хранилищ массивов
 */
define("APP_STORAGEARRAYPATH", APP_DATAPATH.'storages/array/');

if (!defined("APP_STORAGEFILESPATH")) 
/**
 * Путь к директории по-умолчанию где хранятся приложенные к хранилищам файлы
 */
define("APP_STORAGEFILESPATH", APP_DATAPATH.'storage_files/');

if (!defined("MOD_CONFIGPATH")) 
/**
 * Универсальная директория конфигов модуля
 */
define("MOD_CONFIGPATH",'config/');

if (!defined("MOD_CONTROLLERSPATH")) 
/**
 * Универсальная директория контроллеров модуля
 */
define("MOD_CONTROLLERSPATH",'controller/');

if (!defined("MOD_MODELSPATH")) 
/**
 * Универсальная директория моделей модуля
 */
define("MOD_MODELSPATH",'model/');

if (!defined("MOD_VIEWPATH")) 
/**
 * Универсальная директория шаблонов модуля
 */
define("MOD_VIEWPATH",'view/');

if (!defined("MOD_WIDGETS_PATH"))
/**
 * Универсальная директория виджетов модуля
 */
define("MOD_WIDGETS_PATH",'widgets/');

if (!defined("PHPSESSID")) 
/**
 * Идентификатор сессии
 */
define("PHPSESSID",'PHPSESSID');

#################################################################
## Константы системы MNBV
#################################################################

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
