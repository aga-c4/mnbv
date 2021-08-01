-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 01 2021 г., 23:54
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
-- Структура таблицы `mnbv_actions`
--

DROP TABLE IF EXISTS `mnbv_actions`;
CREATE TABLE `mnbv_actions` (
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
  `products` text NOT NULL DEFAULT '',
  `folders` text NOT NULL DEFAULT '',
  `vendor` text NOT NULL DEFAULT '',
  `country` text NOT NULL DEFAULT '',
  `discpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discmaxpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discmaxval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discminmargval` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_actions`
--

INSERT INTO `mnbv_actions` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `products`, `folders`, `vendor`, `country`, `discpr`, `discval`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`) VALUES
(1, '2017-09-15 23:56:49', 0, 100, 1, '', 1, 0, 210, 0, 'Акции', '', '', '', 0, '', '', '', '', 1505505360, 0, 0, 2, 1505505409, 2, 1505505415, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2, '2017-09-15 23:57:11', 1, 100, 0, '', 1, 0, 210, 1, 'Интересный заголовок акции1!', 'Long title of action1!', 'pokupayte-veseley', '', 0, 'Краткое описание данной акции, краткое описание данной акции!', 'Short description of this action, short description of this action!', '<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>', '<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>', 1505505420, 1609459200, 2051222400, 2, 1505505431, 2, 1621589822, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/p1_2.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1621586972,\"editip\":\"127.0.0.1\"}}}', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, '2021-05-21 11:47:22', 1, 100, 0, '', 1, 0, 210, 1, 'Интересный заголовок акции2!', 'Long title of action2!', '', '', 0, 'Краткое описание данной акции, краткое описание данной акции!', 'Short description of this action, short description of this action!', '<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>', '<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>', 1621586820, 0, 2051222400, 2, 1621586842, 2, 1621588090, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/p1_3.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1621586990,\"editip\":\"127.0.0.1\"}}}', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, '2021-05-21 11:47:28', 1, 100, 0, '', 1, 0, 210, 1, 'Интересный заголовок акции3!', 'Long title of action3!', '', '', 0, 'Краткое описание данной акции, краткое описание данной акции!', 'Short description of this action, short description of this action!', '<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>', '<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>', 1621586820, 0, 2051222400, 2, 1621586848, 2, 1621588099, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/p1_4.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1621587469,\"editip\":\"127.0.0.1\"}}}', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, '2021-05-21 11:47:33', 1, 100, 0, '', 1, 0, 210, 0, 'Интересный заголовок акции4!', 'Long title of action4!', '', '', 0, 'Краткое описание данной акции, краткое описание данной акции!', 'Short description of this action, short description of this action!', '<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>\r\n<p>Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции. Полное описание данной акции.</p>', '<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>\r\n<p>Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action! Full description of this action, full description of this action!</p>', 1621586820, 0, 0, 2, 1621586853, 2, 1621589770, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/p1_5.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1621587479,\"editip\":\"127.0.0.1\"}}}', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
-- Структура таблицы `mnbv_cartitems`
--

DROP TABLE IF EXISTS `mnbv_cartitems`;
CREATE TABLE `mnbv_cartitems` (
  `id` int(10) NOT NULL,
  `sessid` varchar(64) NOT NULL DEFAULT '',
  `userid` int(10) NOT NULL DEFAULT 0,
  `prodid` int(10) NOT NULL DEFAULT 0,
  `qty` int(5) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `promocode` varchar(64) NOT NULL DEFAULT '',
  `ts` int(10) NOT NULL DEFAULT 0,
  `region` int(10) NOT NULL DEFAULT 0,
  `brweight` int(10) NOT NULL DEFAULT 0,
  `brheight` int(10) NOT NULL DEFAULT 0,
  `brminw` int(10) NOT NULL DEFAULT 0,
  `brmaxw` int(10) NOT NULL DEFAULT 0,
  `brvolume` decimal(10,3) NOT NULL DEFAULT 0.000,
  `siteid` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_carts`
--

DROP TABLE IF EXISTS `mnbv_carts`;
CREATE TABLE `mnbv_carts` (
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
  `orders` int(11) NOT NULL DEFAULT 0,
  `utm_source` varchar(255) NOT NULL DEFAULT '',
  `utm_medium` varchar(255) NOT NULL DEFAULT '',
  `utm_campaign` varchar(255) NOT NULL DEFAULT '',
  `utm_term` varchar(255) NOT NULL DEFAULT '',
  `find_keys` varchar(255) NOT NULL DEFAULT '',
  `partner_id` varchar(255) NOT NULL DEFAULT '',
  `partner_code` varchar(255) NOT NULL DEFAULT '',
  `utm_history` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_carts`
--

INSERT INTO `mnbv_carts` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `orders`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `find_keys`, `partner_id`, `partner_code`, `utm_history`) VALUES
(1, '2017-09-02 21:43:39', 0, 100, 1, '', 1, 118, 118, 0, 'Корзины пользователей', '', '', '', 0, '', '', '', '', 1504374180, 0, 0, 2, 1504374219, 2, 1504374227, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_delivery`
--

DROP TABLE IF EXISTS `mnbv_delivery`;
CREATE TABLE `mnbv_delivery` (
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
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `region` int(10) NOT NULL DEFAULT 0,
  `weightgr` int(4) NOT NULL DEFAULT 0,
  `sizegr` int(4) NOT NULL DEFAULT 0,
  `days` int(5) NOT NULL DEFAULT 0,
  `minprice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `maxprice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `orderbefore` int(2) NOT NULL DEFAULT 12
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_delivery`
--

INSERT INTO `mnbv_delivery` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `price`, `region`, `weightgr`, `sizegr`, `days`, `minprice`, `maxprice`, `orderbefore`) VALUES
(1, '2017-09-15 14:03:09', 0, 100, 1, '', 1, 0, 210, 0, 'Варианты доставки', 'Delivery types', '', '', 0, '', '', '', '', 1505469789, 0, 0, 2, 1505469789, 2, 1505469819, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(2, '2021-06-13 23:01:28', 1, 100, 1, '', 1, 0, 210, 0, 'Москва и область', 'Moscow region', '', '', 0, '', '', '', '', 1623614488, 0, 0, 2, 1623614488, 2, 1623614578, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(3, '2021-06-13 23:01:42', 1, 100, 1, '', 1, 0, 210, 0, 'Регионы России', 'Russian regions', '', '', 0, '', '', '', '', 1623614502, 0, 0, 2, 1623614502, 2, 1623614587, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(4, '2021-06-13 23:03:43', 2, 100, 1, '', 1, 0, 210, 0, 'Курьерская доставка', '', '', '', 0, '', '', '', '', 1623614623, 0, 0, 2, 1623614623, 2, 1623615313, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(5, '2021-06-13 23:04:12', 4, 100, 0, '', 1, 0, 210, 0, 'Курьерская доставка по Москве в пределах МКАД', '', '', '', 0, '', '', '', '', 1623614652, 0, 0, 2, 1623614652, 2, 1623620866, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '600.00', 2, 1, 1, 1, '0.00', '0.00', 12),
(6, '2021-06-13 23:05:10', 4, 100, 0, '', 1, 0, 210, 0, 'Курьерская доставка по Московской области (до 15 км от МКАД)', '', '', '', 0, '', '', '', '', 1623614710, 0, 0, 2, 1623614710, 2, 1623620872, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '1000.00', 2, 1, 1, 1, '0.00', '0.00', 12),
(7, '2021-06-13 23:05:32', 2, 100, 1, '', 1, 0, 210, 0, 'Доставка транспортной компанией', '', '', '', 0, '', '', '', '', 1623614732, 0, 0, 2, 1623614732, 2, 1623615315, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(8, '2021-06-13 23:08:08', 19, 10, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по Москве', '', '', '', 0, '', '', '', '', 1623614888, 0, 0, 2, 1623614888, 2, 1627312177, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '600.00', 2, 3, 3, 2, '0.00', '0.00', 12),
(9, '2021-06-13 23:08:30', 20, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по Московской обл. до 60 км от МКАД', '', '', '', 0, '', '', '', '', 1623614910, 0, 0, 2, 1623614910, 2, 1627312281, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '1000.00', 2, 3, 3, 2, '0.00', '0.00', 12),
(10, '2021-06-13 23:10:13', 20, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по Московской обл. до 60 км от МКАД (тяжелый или габаритный груз)', 'Доставка транспортной компанией по Московской обл. до 60 км от МКАД (габаритный груз)', '', '', 0, '', '', '', '', 1623615013, 0, 0, 2, 1623615013, 2, 1627312295, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '4000.00', 2, 4, 4, 2, '0.00', '0.00', 12),
(11, '2021-06-13 23:12:05', 21, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по Московской обл. свыше 60 км от МКАД', '', '', '', 0, '', '', '', '', 1623615125, 0, 0, 2, 1623615125, 2, 1627312319, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '1200.00', 2, 3, 3, 2, '0.00', '0.00', 12),
(12, '2021-06-13 23:12:20', 21, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по Московской обл. свыше 60 км от МКАД (тяжелый или габаритный груз)', '', '', '', 0, '', '', '', '', 1623615140, 0, 0, 2, 1623615140, 2, 1627312332, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '6000.00', 2, 4, 4, 2, '0.00', '0.00', 12),
(13, '2021-06-13 23:14:22', 3, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по России', '', '', '', 0, '', '', '', '', 1623615262, 0, 0, 2, 1623615262, 2, 1623620965, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '2000.00', 3, 3, 3, 21, '0.00', '0.00', 12),
(14, '2021-06-13 23:14:32', 3, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по России (тяжелый или габаритный груз)', '', '', '', 0, '', '', '', '', 1623615272, 0, 0, 2, 1623615272, 2, 1623620972, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '8000.00', 3, 4, 4, 21, '0.00', '0.00', 12),
(15, '2021-06-13 23:15:43', 22, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по России', '', '', '', 0, '', '', '', '', 1623615343, 0, 0, 2, 1623615343, 2, 1627312346, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '2000.00', 2, 3, 3, 21, '0.00', '0.00', 12),
(16, '2021-06-13 23:15:56', 22, 100, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по России (тяжелый или габаритный груз)', '', '', '', 0, '', '', '', '', 1623615356, 0, 0, 2, 1623615356, 2, 1627312358, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '8000.00', 2, 4, 4, 21, '0.00', '0.00', 12),
(18, '2021-06-14 00:33:01', 19, 20, 0, '', 1, 0, 210, 0, 'Доставка транспортной компанией по Москве  (тяжелый или габаритный груз)', '', '', '', 0, '', '', '', '', 1623619981, 0, 0, 2, 1623619981, 2, 1627312140, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '5000.00', 2, 4, 4, 2, '0.00', '0.00', 12),
(19, '2021-07-26 18:05:30', 7, 100, 1, '', 1, 0, 210, 0, 'Транспортной компанией по Москве', '', '', '', 0, '', '', '', '', 1627311930, 0, 0, 2, 1627311930, 2, 1627312213, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\",\"7\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(20, '2021-07-26 18:05:44', 7, 100, 1, '', 1, 0, 210, 0, 'Транспортной компанией по МО до 60 км от МКАД', '', '', '', 0, '', '', '', '', 1627311944, 0, 0, 2, 1627311944, 2, 1627312263, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\",\"7\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(21, '2021-07-26 18:06:00', 7, 100, 1, '', 1, 0, 210, 0, 'Транспортной компанией по МО  свыше 60 км от МКАД', '', '', '', 0, '', '', '', '', 1627311960, 0, 0, 2, 1627311960, 2, 1627312266, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\",\"7\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(22, '2021-07-26 18:06:20', 7, 100, 1, '', 1, 0, 210, 0, 'Транспортной компанией  по России', '', '', '', 0, '', '', '', '', 1627311980, 0, 0, 2, 1627311980, 2, 1627312234, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\",\"7\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(23, '2021-07-27 00:28:48', 2, 100, 1, '', 1, 0, 210, 0, 'Самовывоз', '', '', '', 0, '', '', '', '', 1627334928, 0, 0, 2, 1627334928, 2, 1627334928, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\",\"2\"]', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12),
(24, '2021-07-27 00:28:57', 23, 10, 0, '', 1, 0, 210, 0, 'Самовывоз - бесплатно', 'Pickup free', '', '', 0, '', '', '', '', 1627334937, 0, 0, 2, 1627334937, 2, 1627335027, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', 0, 0, 0, 0, '0.00', '0.00', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_discounts`
--

DROP TABLE IF EXISTS `mnbv_discounts`;
CREATE TABLE `mnbv_discounts` (
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
  `discpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discval` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_discounts`
--

INSERT INTO `mnbv_discounts` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discpr`, `discval`) VALUES
(1, '2017-09-15 14:03:09', 0, 100, 1, '', 1, 0, 210, 0, 'Базовые типы скидок', 'Discount types', '', '', 0, '', '', '', '', 1505469789, 0, 0, 2, 1505469789, 2, 1505469819, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00'),
(2, '2017-09-15 14:03:52', 1, 10, 0, '', 1, 0, 210, 0, 'Первая скидка жесткая', 'Discount 1', '', '', 0, '', '', '', '', 1505469832, 0, 0, 2, 1505469832, 2, 1621585965, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '5.00', '1000.00'),
(3, '2017-09-15 14:04:01', 1, 20, 0, '', 1, 0, 210, 0, 'Вторая скидка', 'Discount 2', '', '', 0, '', '', '', '', 1505469841, 0, 0, 2, 1505469841, 2, 1621585967, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '10.00', '2000.00'),
(4, '2017-09-15 14:04:09', 1, 30, 0, '', 1, 0, 210, 0, 'Третья скидка', 'Discount 3', '', '', 0, '', '', '', '', 1505469849, 0, 0, 2, 1505469849, 2, 1621585975, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '20.00', '4000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_longtmp`
--

DROP TABLE IF EXISTS `mnbv_longtmp`;
CREATE TABLE `mnbv_longtmp` (
  `id` varchar(100) NOT NULL DEFAULT '',
  `ts` int(11) NOT NULL DEFAULT 0,
  `tsto` int(11) NOT NULL DEFAULT 0,
  `val` longtext NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_news`
--

DROP TABLE IF EXISTS `mnbv_news`;
CREATE TABLE `mnbv_news` (
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
  `tags` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_news`
--

INSERT INTO `mnbv_news` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-19 14:09:37', 0, 100, 1, '', 1, 0, 205, 0, 'Новости', 'News', '', '', 0, '', '', '', '', 1503137377, 0, 0, 2, 1503137377, 2, 1621325813, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(2, '2017-08-19 14:10:30', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 1', 'News1', 'novost-1', '', 0, 'краткое описание новости 1', 'Short news1 text. Short news1 text. Short news1 text.', '<p>Полное описание новости 1.</p>', '<p>Full description of curent news full description of curent news full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3.</p>\r\n<p> full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3 full description of news3.</p>\r\n<p>{{img:2}}</p>', 1503137400, 0, 0, 2, 1503137430, 2, 1621326043, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002027,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(3, '2017-08-19 14:10:36', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 2', 'News2', 'novost-2', '', 0, 'краткое описание новости 2', 'Short news2 text. Short news2 text. Short news2 text.', '<p>Полное описание новости 2</p>', '<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>', 1503223800, 0, 0, 2, 1503137436, 2, 1621326085, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002033,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(4, '2017-08-19 14:10:42', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 3', 'News3', 'News3', '', 0, 'краткое описание новости 3.', 'mini description of news3.', '<p>Полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>\r\n<p> полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>', '<p>Full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3.</p>\r\n<p>&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3.</p>\r\n<p>{{img:2}}</p>', 1503310200, 0, 0, 2, 1503137442, 2, 1522002048, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"2\":{\"url\":\"https:\\/\\/youtu.be\\/u48Izeg-5W8\",\"type\":null,\"edituser\":\"2\",\"editdate\":1522002048,\"editip\":\"127.0.0.1\"},\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002048,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(5, '2021-04-24 11:48:15', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 4', 'News4', 'novost-4', '', 0, 'Краткое описание новости 4.', 'Short news4 text. Short news4 text. Short news4 text.', '<p>Полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>\r\n<p> полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>', '<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>', 1619254080, 0, 0, 2, 1619254095, 2, 1621326093, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1619254170,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(6, '2021-04-24 11:48:20', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 5', 'News5', 'novost-5', '', 0, 'Краткое описание новости 5.', 'Short news5 text. Short news5 text. Short news5 text.', '<p>Полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>\r\n<p> полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>', '<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>', 1619167680, 0, 0, 2, 1619254100, 2, 1621326096, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1619254177,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(7, '2021-04-24 11:48:25', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 6', 'News6', 'novost-6', '', 0, 'Краткое описание новости 6. Краткое описание новости 6', 'Short news7 text. Short news7 text. Short news7 text.', '<p>Полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>\r\n<p> полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>', '<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>\r\n<p>Full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news, full description of curent news</p>', 1619340480, 0, 0, 2, 1619254105, 2, 1621326100, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1619254181,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(8, '2021-04-25 14:24:36', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 7', 'News7', 'novost-7', '', 0, 'Краткое описание новости без полного текста и ссылки. Краткое описание новости 7. Краткое описание новости 7', 'Short news7 text. Short news7 text. Short news7 text.', '', '', 1619349840, 0, 0, 2, 1619349876, 2, 1621325913, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1619350006,\"editip\":\"127.0.0.1\"}}}', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_orders`
--

DROP TABLE IF EXISTS `mnbv_orders`;
CREATE TABLE `mnbv_orders` (
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
  `userid` int(11) NOT NULL DEFAULT 0,
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,2) DEFAULT 0.00,
  `items` int(10) NOT NULL DEFAULT 0,
  `qty` int(10) NOT NULL DEFAULT 0,
  `phone` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `utm_source` varchar(255) NOT NULL DEFAULT '',
  `utm_medium` varchar(255) NOT NULL DEFAULT '',
  `utm_campaign` varchar(255) NOT NULL DEFAULT '',
  `utm_term` varchar(255) NOT NULL DEFAULT '',
  `partner_alias` varchar(100) NOT NULL DEFAULT '',
  `partner_code` int(10) NOT NULL DEFAULT 0,
  `surname` varchar(100) NOT NULL DEFAULT '',
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `patronymic` varchar(100) NOT NULL DEFAULT '',
  `subscribe` int(1) NOT NULL DEFAULT 0,
  `adress` text NOT NULL DEFAULT '\'\'',
  `receiverpay` int(1) NOT NULL DEFAULT 0,
  `rfirstname` varchar(100) NOT NULL DEFAULT '',
  `rsurname` varchar(100) NOT NULL DEFAULT '',
  `rpatronymic` varchar(100) NOT NULL DEFAULT '',
  `cart_info` text NOT NULL DEFAULT '',
  `cart_items` text NOT NULL DEFAULT '',
  `htmlview` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_orders`
--

INSERT INTO `mnbv_orders` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `userid`, `files`, `siteid`, `tags`, `price`, `items`, `qty`, `phone`, `email`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `partner_alias`, `partner_code`, `surname`, `firstname`, `patronymic`, `subscribe`, `adress`, `receiverpay`, `rfirstname`, `rsurname`, `rpatronymic`, `cart_info`, `cart_items`, `htmlview`) VALUES
(1, '2017-08-31 22:51:39', 0, 100, 1, '', 1, 118, 118, 0, 'Входящие заказы', '', '', '', 0, '', '', '', '', 1504205499, 0, 0, 2, 1504205499, 2, 1627765693, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', 0, '', 0, '', '', '', '', '', ''),
(2, '2021-08-01 00:09:37', 0, 100, 1, '', 1, 118, 118, 0, 'Заказы в работе', '', '', '', 0, '', '', '', '', 1627765777, 0, 0, 2, 1627765777, 2, 1627765786, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', 0, '\'\'', 0, '', '', '', '', '', ''),
(3, '2021-08-01 00:08:22', 0, 100, 1, '', 1, 118, 118, 0, 'Выполненные заказы', '', '', '', 0, '', '', '', '', 1627765702, 0, 0, 2, 1627765702, 2, 1627765702, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', 0, '\'\'', 0, '', '', '', '', '', ''),
(4, '2021-08-01 00:09:05', 0, 100, 1, '', 1, 118, 118, 0, 'Отложенные заказы', '', '', '', 0, '', '', '', '', 1627765745, 0, 0, 2, 1627765745, 2, 1627765745, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', 0, '\'\'', 0, '', '', '', '', '', ''),
(5, '2021-08-01 00:08:48', 0, 100, 1, '', 1, 118, 118, 0, 'Отмененные заказы', '', '', '', 0, '', '', '', '', 1627765728, 0, 0, 2, 1627765728, 2, 1627765728, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', 0, 0, '', '', '', '', '', '', '', 0, '', '', '', 0, '\'\'', 0, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_payment`
--

DROP TABLE IF EXISTS `mnbv_payment`;
CREATE TABLE `mnbv_payment` (
  `id` int(10) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(10) NOT NULL DEFAULT 0,
  `pozid` int(10) NOT NULL DEFAULT 100,
  `type` int(1) NOT NULL DEFAULT 0,
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT 1,
  `access` int(10) NOT NULL DEFAULT 0,
  `access2` int(10) NOT NULL DEFAULT 0,
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
  `createuser` int(10) NOT NULL DEFAULT 0,
  `createdate` int(10) NOT NULL DEFAULT 0,
  `edituser` int(10) NOT NULL DEFAULT 0,
  `editdate` int(10) NOT NULL DEFAULT 0,
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL DEFAULT '',
  `attrup` text NOT NULL DEFAULT '',
  `attr` text NOT NULL DEFAULT '',
  `attrvals` text NOT NULL DEFAULT '',
  `upfolders` text NOT NULL DEFAULT '',
  `userid` int(10) NOT NULL DEFAULT 0,
  `files` text NOT NULL DEFAULT '',
  `siteid` int(10) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT '',
  `discpr` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discval` decimal(10,2) NOT NULL DEFAULT 0.00,
  `minprice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `maxprice` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_payment`
--

INSERT INTO `mnbv_payment` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `userid`, `files`, `siteid`, `tags`, `discpr`, `discval`, `minprice`, `maxprice`) VALUES
(1, '2021-07-26 15:56:17', 0, 100, 1, '', 1, 0, 200, 0, 'Варианты оплаты', '', '', '', 0, '', '', '', '', 1627304177, 0, 0, 2, 1627304177, 2, 1627304227, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(2, '2021-07-26 15:57:34', 1, 30, 0, '', 1, 0, 200, 0, 'Наличными при приеме товара (скидка 5%)', 'Cash (5% discount)', '', '', 0, '', '', '', '', 1627304254, 0, 0, 2, 1627304254, 2, 1627334213, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '5.00', '0.00', '0.00', '20000.00'),
(3, '2021-07-26 15:58:05', 1, 10, 0, '', 1, 0, 200, 0, 'Картой банка', 'Bank card', '', '', 0, '', '', '', '', 1627304285, 0, 0, 2, 1627304285, 2, 1627334400, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', '0.00', '10000.00', '0.00'),
(4, '2021-07-26 15:58:29', 1, 20, 0, '', 1, 0, 200, 0, 'Безналичный платеж', 'Bank transfer', '', '', 0, '', '', '', '', 1627304309, 0, 0, 2, 1627304309, 2, 1627334210, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_prinstock`
--

DROP TABLE IF EXISTS `mnbv_prinstock`;
CREATE TABLE `mnbv_prinstock` (
  `id` int(10) NOT NULL,
  `region` int(10) NOT NULL DEFAULT 0,
  `prodid` int(10) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `instock` int(1) NOT NULL DEFAULT 0,
  `qty` int(10) NOT NULL DEFAULT 0,
  `ts` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `searchstr` varchar(255) NOT NULL DEFAULT '',
  `weightgr` int(4) NOT NULL DEFAULT 0,
  `sizegr` int(4) NOT NULL DEFAULT 0,
  `onlyvert` int(1) NOT NULL DEFAULT 0,
  `brweight` int(10) NOT NULL DEFAULT 0,
  `brheight` int(10) NOT NULL DEFAULT 0,
  `brwidth` int(10) NOT NULL DEFAULT 0,
  `brlength` int(10) NOT NULL DEFAULT 0,
  `brminw` int(10) NOT NULL DEFAULT 0,
  `brmaxw` int(10) NOT NULL DEFAULT 0,
  `brvolume` decimal(10,3) NOT NULL DEFAULT 0.000,
  `supplier` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_products`
--

INSERT INTO `mnbv_products` (`id`, `outid`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `price`, `oldprice`, `cost`, `ndspr`, `quantity`, `instock`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`, `vendor`, `prefix`, `prefixlang`, `model`, `partnumber`, `barcode`, `country`, `norm_search`, `norm_partnumber`, `donorurl`, `donorimg`, `searchstr`, `weightgr`, `sizegr`, `onlyvert`, `brweight`, `brheight`, `brwidth`, `brlength`, `brminw`, `brmaxw`, `brvolume`, `supplier`) VALUES
(1, '', '1970-01-01 03:00:00', 0, 100, 1, '', 1, 0, 210, 0, 'Товары', 'Products', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005900, 2, 1624633998, '127.0.0.1', 'Администратор', '', '', '{\"1\":{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight (kg)\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441 (\\u043a\\u0433)\"},\"2\":{\"objid\":1,\"attrid\":\"5\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height (sm)\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430 (\\u0441\\u043c)\",\"dnuse\":1,\"infilter\":1},\"3\":{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Width (sm)\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},\"4\":{\"objid\":1,\"attrid\":\"7\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430 (\\u0441\\u043c)\",\"namelang\":\"Length (sm)\",\"dnuse\":1,\"infilter\":1}}', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',1,,,,tovary,products,,', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '0.000', 0);

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_suppliers`
--

DROP TABLE IF EXISTS `mnbv_suppliers`;
CREATE TABLE `mnbv_suppliers` (
  `id` int(10) NOT NULL COMMENT 'Id',
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
  `tags` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_suppliers`
--

INSERT INTO `mnbv_suppliers` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 1, 1, '', 1, 0, 200, 0, 'Поставщики', 'Suppliers', '', '', 0, '', '', '', '', 0, 0, 0, 0, 0, 2, 1624442600, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(2, '2021-06-23 13:03:35', 1, 100, 0, '', 1, 0, 200, 0, 'Поставщик1', 'Supplier1', '', '', 0, '', '', '', '', 1624442615, 0, 0, 2, 1624442615, 2, 1624442626, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

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
-- Индексы таблицы `mnbv_actions`
--
ALTER TABLE `mnbv_actions`
  ADD PRIMARY KEY (`id`);

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
-- Индексы таблицы `mnbv_cartitems`
--
ALTER TABLE `mnbv_cartitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `sessid` (`sessid`);

--
-- Индексы таблицы `mnbv_carts`
--
ALTER TABLE `mnbv_carts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_delivery`
--
ALTER TABLE `mnbv_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_discounts`
--
ALTER TABLE `mnbv_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_longtmp`
--
ALTER TABLE `mnbv_longtmp`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_news`
--
ALTER TABLE `mnbv_news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_orders`
--
ALTER TABLE `mnbv_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_payment`
--
ALTER TABLE `mnbv_payment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_prinstock`
--
ALTER TABLE `mnbv_prinstock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodid` (`prodid`);

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
-- Индексы таблицы `mnbv_searchindex`
--
ALTER TABLE `mnbv_searchindex`
  ADD PRIMARY KEY (`id`),
  ADD KEY `normstr` (`normstr`),
  ADD KEY `objid` (`objid`) USING BTREE;

--
-- Индексы таблицы `mnbv_suppliers`
--
ALTER TABLE `mnbv_suppliers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT для таблицы `mnbv_actions`
--
ALTER TABLE `mnbv_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `mnbv_attributes`
--
ALTER TABLE `mnbv_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `mnbv_attrvals`
--
ALTER TABLE `mnbv_attrvals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mnbv_cartitems`
--
ALTER TABLE `mnbv_cartitems`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mnbv_carts`
--
ALTER TABLE `mnbv_carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mnbv_delivery`
--
ALTER TABLE `mnbv_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `mnbv_discounts`
--
ALTER TABLE `mnbv_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mnbv_news`
--
ALTER TABLE `mnbv_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `mnbv_orders`
--
ALTER TABLE `mnbv_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT для таблицы `mnbv_payment`
--
ALTER TABLE `mnbv_payment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mnbv_prinstock`
--
ALTER TABLE `mnbv_prinstock`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mnbv_products`
--
ALTER TABLE `mnbv_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mnbv_searchindex`
--
ALTER TABLE `mnbv_searchindex`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mnbv_suppliers`
--
ALTER TABLE `mnbv_suppliers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mnbv_urlaliases`
--
ALTER TABLE `mnbv_urlaliases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `mnbv_vendors`
--
ALTER TABLE `mnbv_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
