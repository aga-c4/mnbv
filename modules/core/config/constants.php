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
define("APP_DEBUG_MODE",false);

if (!defined("DIRECTORY_SEPARATOR")) 
/**
 * Разделитель при указании путей
 */
define("DIRECTORY_SEPARATOR","/");

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
define("APP_VENDORS",'vendor/');

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

