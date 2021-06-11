-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 02 2021 г., 13:50
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mnbvshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_attributes`
--

DROP TABLE IF EXISTS `mnbv_attributes`;
CREATE TABLE `mnbv_attributes` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT 0,
  `pozid` int(11) NOT NULL DEFAULT 100,
  `type` int(1) NOT NULL DEFAULT 0,
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT 1,
  `access` int(11) NOT NULL DEFAULT 0,
  `access2` int(11) NOT NULL DEFAULT 0,
  `first` int(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `about` text NOT NULL DEFAULT '',
  `aboutlang` text NOT NULL DEFAULT '',
  `text` text NOT NULL DEFAULT '',
  `textlang` text NOT NULL DEFAULT '',
  `date` int(10) NOT NULL DEFAULT 0,
  `date1` int(10) NOT NULL DEFAULT 0,
  `date2` int(10) NOT NULL DEFAULT 0,
  `createuser` int(11) NOT NULL DEFAULT 0,
  `createdate` int(10) NOT NULL DEFAULT 0,
  `edituser` int(11) NOT NULL DEFAULT 0,
  `editdate` int(10) NOT NULL DEFAULT 0,
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL DEFAULT '',
  `attrup` text NOT NULL DEFAULT '',
  `attr` text NOT NULL DEFAULT '',
  `attrvals` text NOT NULL DEFAULT '',
  `upfolders` text NOT NULL DEFAULT '',
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_attributes`
--

INSERT INTO `mnbv_attributes` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 0, 103, 0, 'Атрибуты хранилищ', 'Storage attributes', '', '', '', '1', '', '<p>1</p>', 0, 0, 0, 2, 1468929671, 2, 1481636094, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(2, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Страна', 'Country', '', '', 'Русское описание', 'Eng aboute', '<p>Русский текст</p>', '<p>Eng text</p>', 0, 0, 0, 2, 1468929743, 2, 1622042729, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"select\",\"linkstorage\":\"attributes\",\"filter_folder\":\"2\",\"filter_type\":\"objects\",\"checktype\":\"int\",\"lang\":\"all\",\"viewindex\":1,\"dbtype\":\"int\",\"notset\":1}', '', '', '', '', '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Вес (кг)', 'Weight (kg)', '', '', '', '', '', '', 0, 0, 0, 2, 1469004674, 2, 1623270601, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"width\":\"100%\",\"filter_type\":\"all\",\"checktype\":\"decimal\",\"lang\":\"all\",\"dbtype\":\"decimal\",\"size\":\"7\",\"dmsize\":\"3\"}', '', '', '', '', '', 0, ''),
(5, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Высота (cм)', 'Height (sm)', '', '', '', '', '', '', 0, 0, 0, 2, 1469004857, 2, 1623270606, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"width\":\"100%\",\"size\":\"10\"}', '', '', '', '', '', 0, ''),
(6, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Ширина (cм)', 'Width (sm)', '', '', '', '', '', '', 0, 0, 0, 2, 1469004863, 2, 1623270611, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"width\":\"100%\",\"size\":\"10\"}', '', '', '', '', '', 0, ''),
(7, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Длина (cм)', 'Length (sm)', '', '', '', '', '', '', 0, 0, 0, 2, 1469004867, 2, 1623270616, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"width\":\"100%\",\"size\":\"10\"}', '', '', '', '', '', 0, ''),
(8, '2021-06-09 17:42:31', 1, 100, 0, '', 1, 0, 103, 0, 'Брутто вес (кг)', 'Gross weight (kg)', '', '', '', '', '', '', 1623249720, 0, 0, 2, 1623249751, 2, 1623270622, '127.0.0.1', 'Администратор', '{\"dbtype\":\"decimal\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"decimal\",\"lang\":\"all\",\"size\":\"7\",\"dmsize\":\"3\"}', '', '', '', '', '', 0, ''),
(9, '2021-06-09 17:42:38', 1, 100, 0, '', 1, 0, 103, 0, 'Брутто высота (см)', 'Gross height (sm)', '', '', '', '', '', '', 1623249758, 0, 0, 2, 1623249758, 2, 1623270628, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"size\":\"10\"}', '', '', '', '', '', 0, ''),
(10, '2021-06-09 17:42:46', 1, 100, 0, '', 1, 0, 103, 0, 'Брутто ширина (см)', 'Gross width (sm)', '', '', '', '', '', '', 1623249766, 0, 0, 2, 1623249766, 2, 1623270633, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"size\":\"10\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\"}', '', '', '', '', '', 0, ''),
(11, '2021-06-09 17:43:00', 1, 100, 0, '', 1, 0, 103, 0, 'Брутто длина (см)', 'Gross length (sm)', '', '', '', '', '', '', 1623249780, 0, 0, 2, 1623249780, 2, 1623270638, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"size\":\"10\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\"}', '', '', '', '', '', 0, ''),
(12, '2021-06-09 23:36:39', 1, 100, 1, '', 1, 0, 103, 0, 'Цвет', 'Color', '', '', '', '', '', '', 1623270999, 0, 0, 2, 1623270999, 2, 1623271090, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"select\",\"size\":\"1\",\"linkstorage\":\"attributes\",\"filter_folder\":\"12\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"notset\":1}', '', '', '', '[\"1\"]', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_attrvals`
--

DROP TABLE IF EXISTS `mnbv_attrvals`;
CREATE TABLE `mnbv_attrvals` (
  `id` int(10) NOT NULL,
  `objid` int(10) NOT NULL DEFAULT 0,
  `objparentid` int(10) NOT NULL DEFAULT 0,
  `attrid` int(10) NOT NULL DEFAULT 0,
  `vint` int(10) NOT NULL DEFAULT 0,
  `vstr` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_countries`
--

DROP TABLE IF EXISTS `mnbv_countries`;
CREATE TABLE `mnbv_countries` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT 0,
  `pozid` int(11) NOT NULL DEFAULT 100,
  `type` int(1) NOT NULL DEFAULT 0,
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT 1,
  `access` int(11) NOT NULL DEFAULT 0,
  `access2` int(11) NOT NULL DEFAULT 0,
  `first` int(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT 0,
  `about` text NOT NULL DEFAULT '',
  `aboutlang` text NOT NULL DEFAULT '',
  `text` text NOT NULL DEFAULT '',
  `textlang` text NOT NULL DEFAULT '',
  `date` int(10) NOT NULL DEFAULT 0,
  `date1` int(10) NOT NULL DEFAULT 0,
  `date2` int(10) NOT NULL DEFAULT 0,
  `createuser` int(11) NOT NULL DEFAULT 0,
  `createdate` int(10) NOT NULL DEFAULT 0,
  `edituser` int(11) NOT NULL DEFAULT 0,
  `editdate` int(10) NOT NULL DEFAULT 0,
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL DEFAULT '',
  `attrup` text NOT NULL DEFAULT '',
  `attr` text NOT NULL DEFAULT '',
  `attrvals` text NOT NULL DEFAULT '',
  `upfolders` text NOT NULL DEFAULT '',
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT '',
  `discmaxpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discmaxval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `searchstr` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_countries`
--

INSERT INTO `mnbv_countries` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`, `searchstr`) VALUES
(1, '2017-09-15 18:19:07', 0, 100, 1, '', 1, 0, 210, 0, 'Страны', 'Countries', '', '', 0, '', '', '', '', 1505485140, 0, 0, 2, 1505485147, 2, 1505485196, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', ''),
(2, '2017-09-15 18:19:24', 1, 100, 0, '', 1, 0, 210, 0, 'Россия', 'Russia', '', '', 0, '', '', '', '', 1505485164, 0, 0, 2, 1505485164, 2, 1505485204, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', ''),
(3, '2017-09-15 18:19:29', 1, 100, 0, '', 1, 0, 210, 0, 'Китай', 'China', '', '', 0, '', '', '', '', 1505485169, 0, 0, 2, 1505485169, 2, 1505485209, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', ''),
(4, '2017-09-15 18:19:32', 1, 100, 0, '', 1, 0, 210, 0, 'США', 'USA', '', '', 0, '', '', '', '', 1505485172, 0, 0, 2, 1505485172, 2, 1505485216, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_products`
--

DROP TABLE IF EXISTS `mnbv_products`;
CREATE TABLE `mnbv_products` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `outid` varchar(255) NOT NULL DEFAULT '',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT 0,
  `pozid` int(11) NOT NULL DEFAULT 100,
  `type` int(1) NOT NULL DEFAULT 0,
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT 1,
  `access` int(11) NOT NULL DEFAULT 0,
  `access2` int(11) NOT NULL DEFAULT 0,
  `first` int(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT 0,
  `about` text NOT NULL DEFAULT '',
  `aboutlang` text NOT NULL DEFAULT '',
  `text` text NOT NULL DEFAULT '',
  `textlang` text NOT NULL DEFAULT '',
  `date` int(10) NOT NULL DEFAULT 0,
  `date1` int(10) NOT NULL DEFAULT 0,
  `date2` int(10) NOT NULL DEFAULT 0,
  `createuser` int(11) NOT NULL DEFAULT 0,
  `createdate` int(10) NOT NULL DEFAULT 0,
  `edituser` int(11) NOT NULL DEFAULT 0,
  `editdate` int(10) NOT NULL DEFAULT 0,
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL DEFAULT '',
  `attrup` text NOT NULL DEFAULT '',
  `attr` text NOT NULL DEFAULT '',
  `attrvals` text NOT NULL DEFAULT '',
  `upfolders` text NOT NULL DEFAULT '',
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `oldprice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ndspr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) NOT NULL DEFAULT 0,
  `instock` int(1) NOT NULL DEFAULT 0,
  `discmaxpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discmaxval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vendor` int(11) NOT NULL DEFAULT 0,
  `prefix` varchar(255) NOT NULL DEFAULT '',
  `prefixlang` varchar(255) NOT NULL DEFAULT '',
  `model` varchar(255) NOT NULL DEFAULT '',
  `partnumber` varchar(255) NOT NULL DEFAULT '',
  `barcode` varchar(255) NOT NULL DEFAULT '',
  `country` int(11) NOT NULL DEFAULT 0,
  `norm_search` varchar(512) NOT NULL DEFAULT '',
  `norm_partnumber` varchar(255) NOT NULL DEFAULT '',
  `donorurl` varchar(255) NOT NULL DEFAULT '',
  `donorimg` varchar(255) NOT NULL DEFAULT '',
  `searchstr` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_products`
--

INSERT INTO `mnbv_products` (`id`, `outid`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `price`, `oldprice`, `cost`, `ndspr`, `quantity`, `instock`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`, `vendor`, `prefix`, `prefixlang`, `model`, `partnumber`, `barcode`, `country`, `norm_search`, `norm_partnumber`, `donorurl`, `donorimg`, `searchstr`) VALUES
(1, '', '1970-01-01 03:00:00', 0, 100, 1, '', 1, 0, 210, 0, 'Товары', 'Products', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005900, 2, 1623312194, '127.0.0.1', 'Администратор', '', '', '{\"1\":{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight (kg)\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441 (\\u043a\\u0433)\"},\"2\":{\"objid\":1,\"attrid\":\"5\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height (sm)\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430 (\\u0441\\u043c)\",\"dnuse\":1,\"infilter\":1},\"3\":{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Width (sm)\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},\"4\":{\"objid\":1,\"attrid\":\"7\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Length (sm)\",\"dnuse\":1,\"infilter\":1},\"5\":{\"objid\":1,\"attrid\":\"8\",\"pozid\":10010,\"name\":\"\\u0411\\u0440\\u0443\\u0442\\u0442\\u043e \\u0432\\u0435\\u0441 (\\u043a\\u0433)\",\"namelang\":\"Gross weight (kg)\",\"dnuse\":1},\"6\":{\"objid\":1,\"attrid\":\"9\",\"pozid\":10011,\"name\":\"\\u0411\\u0440\\u0443\\u0442\\u0442\\u043e \\u0432\\u044b\\u0441\\u043e\\u0442\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Gross height (sm)\",\"dnuse\":1},\"7\":{\"objid\":1,\"attrid\":\"10\",\"pozid\":10012,\"name\":\"\\u0411\\u0440\\u0443\\u0442\\u0442\\u043e \\u0448\\u0438\\u0440\\u0438\\u043d\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Gross width (sm)\",\"dnuse\":1},\"8\":{\"objid\":1,\"attrid\":\"11\",\"pozid\":10013,\"name\":\"\\u0411\\u0440\\u0443\\u0442\\u0442\\u043e \\u0434\\u043b\\u0438\\u043d\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Gross length (sm)\",\"dnuse\":1}}', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',1,,,,tovary,products,,', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_tmp`
--

DROP TABLE IF EXISTS `mnbv_tmp`;
CREATE TABLE `mnbv_tmp` (
  `id` varchar(100) NOT NULL DEFAULT '',
  `ts` int(11) NOT NULL DEFAULT 0,
  `tsto` int(11) NOT NULL DEFAULT 0,
  `val` varchar(21000) NOT NULL DEFAULT ''
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_urlaliases`
--

DROP TABLE IF EXISTS `mnbv_urlaliases`;
CREATE TABLE `mnbv_urlaliases` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `urltype` int(2) NOT NULL DEFAULT 0,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `idref` int(11) NOT NULL DEFAULT 0,
  `objtype` int(1) NOT NULL DEFAULT 0,
  `catalias` varchar(512) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_urlaliases`
--

INSERT INTO `mnbv_urlaliases` (`id`, `siteid`, `urltype`, `alias`, `idref`, `objtype`, `catalias`) VALUES
(11, 0, 3, 'poleznaya-informaciya', 5, 1, ''),
(12, 0, 3, 'bespoleznaya-informaciya', 6, 1, ''),
(13, 0, 3, 'stat-ya-1', 2, 0, 'poleznaya-informaciya'),
(14, 0, 3, 'statya-2', 3, 0, 'poleznaya-informaciya'),
(15, 0, 3, 'stat-ya-3', 4, 0, 'poleznaya-informaciya'),
(16, 0, 3, 'stat-ya1', 7, 0, 'bespoleznaya-informaciya'),
(25, 0, 2, 'novost-4', 5, 0, ''),
(26, 0, 2, 'novost-5', 6, 0, ''),
(27, 0, 2, 'novost-6', 7, 0, ''),
(30, 0, 2, 'novost-7', 8, 0, ''),
(38, 0, 2, 'novost-1', 2, 0, ''),
(39, 0, 2, 'novost-2', 3, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_vendors`
--

DROP TABLE IF EXISTS `mnbv_vendors`;
CREATE TABLE `mnbv_vendors` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT 0,
  `pozid` int(11) NOT NULL DEFAULT 100,
  `type` int(1) NOT NULL DEFAULT 0,
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT 1,
  `access` int(11) NOT NULL DEFAULT 0,
  `access2` int(11) NOT NULL DEFAULT 0,
  `first` int(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT 0,
  `about` text NOT NULL DEFAULT '',
  `aboutlang` text NOT NULL DEFAULT '',
  `text` text NOT NULL DEFAULT '',
  `textlang` text NOT NULL DEFAULT '',
  `date` int(10) NOT NULL DEFAULT 0,
  `date1` int(10) NOT NULL DEFAULT 0,
  `date2` int(10) NOT NULL DEFAULT 0,
  `createuser` int(11) NOT NULL DEFAULT 0,
  `createdate` int(10) NOT NULL DEFAULT 0,
  `edituser` int(11) NOT NULL DEFAULT 0,
  `editdate` int(10) NOT NULL DEFAULT 0,
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL DEFAULT '',
  `attrup` text NOT NULL DEFAULT '',
  `attr` text NOT NULL DEFAULT '',
  `attrvals` text NOT NULL DEFAULT '',
  `upfolders` text NOT NULL DEFAULT '',
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT '',
  `discmaxpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discmaxval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `searchstr` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_vendors`
--

INSERT INTO `mnbv_vendors` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`, `searchstr`) VALUES
(1, '2017-09-15 18:20:38', 0, 100, 1, '', 1, 0, 210, 0, 'Производители', 'Vendors', '', '', 0, '', '', '', '', 1505485238, 0, 0, 2, 1505485238, 2, 1505485246, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mnbv_attributes`
--
ALTER TABLE `mnbv_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_attrvals`
--
ALTER TABLE `mnbv_attrvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obtvint` (`objid`,`vint`),
  ADD KEY `attrfolder` (`attrid`,`objparentid`);

--
-- Индексы таблицы `mnbv_countries`
--
ALTER TABLE `mnbv_countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_products`
--
ALTER TABLE `mnbv_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parentid` (`parentid`),
  ADD KEY `price_inc` (`price`),
  ADD KEY `pozid_name` (`pozid`,`name`),
  ADD KEY `vendor` (`vendor`);

--
-- Индексы таблицы `mnbv_tmp`
--
ALTER TABLE `mnbv_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_urlaliases`
--
ALTER TABLE `mnbv_urlaliases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `urltype_idref` (`idref`,`urltype`) USING BTREE,
  ADD KEY `alias` (`alias`);

--
-- Индексы таблицы `mnbv_vendors`
--
ALTER TABLE `mnbv_vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `mnbv_attributes`
--
ALTER TABLE `mnbv_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT для таблицы `mnbv_attrvals`
--
ALTER TABLE `mnbv_attrvals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mnbv_countries`
--
ALTER TABLE `mnbv_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT для таблицы `mnbv_products`
--
ALTER TABLE `mnbv_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT для таблицы `mnbv_urlaliases`
--
ALTER TABLE `mnbv_urlaliases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT для таблицы `mnbv_vendors`
--
ALTER TABLE `mnbv_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1;
  
--
-- Структура таблицы `mnbv_searchindex`
--

DROP TABLE IF EXISTS `mnbv_searchindex`;
CREATE TABLE `mnbv_searchindex` (
  `id` int(10) NOT NULL,
  `siteid` int(3) NOT NULL DEFAULT 0,
  `type` int(3) NOT NULL DEFAULT 0,
  `objid` int(10) NOT NULL DEFAULT 0,
  `objtype` int(1) NOT NULL DEFAULT 0,
  `normstr` varchar(255) NOT NULL DEFAULT '',
  `weight` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Поисковый индекс';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mnbv_searchindex`
--
ALTER TABLE `mnbv_searchindex`
  ADD PRIMARY KEY (`id`),
  ADD KEY `normstr` (`normstr`),
  ADD KEY `objid` (`objid`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `mnbv_searchindex`
--
ALTER TABLE `mnbv_searchindex`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
  
  
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
