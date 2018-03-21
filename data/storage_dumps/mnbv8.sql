-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 21 2018 г., 17:06
-- Версия сервера: 5.6.38
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mnbv8`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_actions`
--

DROP TABLE IF EXISTS `mnbv_actions`;
CREATE TABLE `mnbv_actions` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `products` text NOT NULL,
  `folders` text NOT NULL,
  `vendor` text NOT NULL,
  `country` text NOT NULL,
  `discpr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discval` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discmaxpr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discmaxval` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discminmargpr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discminmargval` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_actions`
--

INSERT INTO `mnbv_actions` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `products`, `folders`, `vendor`, `country`, `discpr`, `discval`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`) VALUES
(1, '2017-09-15 23:56:49', 0, 100, 1, '', 1, 0, 210, 0, 'Акции', '', '', '', 0, '', '', '', '', 1505505360, 0, 0, 2, 1505505409, 2, 1505505415, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2, '2017-09-15 23:57:11', 1, 100, 0, '', 1, 0, 210, 0, 'Покупайте веселей!', 'Let\'s bay', '', '', 0, '', '', '<p>Описание текущей акции</p>', '<p>About this action!</p>', 1505505420, 0, 0, 2, 1505505431, 2, 1505506559, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/icdn.lenta.ru\\/images\\/2017\\/09\\/15\\/18\\/20170915185029441\\/top7_8f17d1d43da5820edc04278ecdda0b75.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1505505822,\"editip\":\"127.0.0.1\"}}}', 0, '', '', '', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_articles`
--

DROP TABLE IF EXISTS `mnbv_articles`;
CREATE TABLE `mnbv_articles` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_articles`
--

INSERT INTO `mnbv_articles` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-19 14:09:52', 0, 100, 1, '', 1, 0, 206, 0, 'Статьи', '', '', '', 0, '', '', '<p>Описание корневой категории статей</p>', '', 1503137340, 0, 0, 2, 1503137392, 2, 1503925487, '127.0.0.1', 'Администратор', '{\"list_sort\":\"pozid\"}', '', '', '', '', '', 0, ''),
(2, '2017-08-19 14:10:06', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 1', 'Article1', 'test/test2/statya-1', '', 0, 'Краткое описание статьи 1', '', '<p>Полное писание статьи 1</p>', '', 1502964600, 0, 0, 2, 1503137406, 2, 1503924975, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":157,\"w\":600,\"h\":401,\"min\":{\"kb\":7,\"w\":100,\"h\":66},\"big\":{\"kb\":782,\"w\":1529,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"iceberg.jpg\",\"edituser\":\"2\",\"editdate\":1503915126,\"upldate\":1503915126,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(3, '2017-08-19 14:10:13', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 2', 'Article2', 'statya-2', '', 0, 'Краткое описание статьи 2', '', '<p>Полное описание статьи 2</p>', '', 1503051000, 0, 0, 2, 1503137413, 2, 1503842888, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":159,\"w\":600,\"h\":337,\"min\":{\"kb\":7,\"w\":100,\"h\":56},\"big\":{\"kb\":1301,\"w\":1820,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"20160820_160653.jpg\",\"edituser\":\"2\",\"editdate\":1503138974,\"upldate\":1503138974,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(4, '2017-08-19 14:10:18', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 3', 'Aarticle3', 'stat-ya-3', '', 0, 'Краткое описание статьи 3', 'Mini description of article 1.', '<p>Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;</p>\r\n<p>Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;</p>', '<p>Full description of article1&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1.</p>\r\n<p>&nbsp;Full description of article1&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1 .</p>', 1503915000, 0, 0, 2, 1503137418, 2, 1504094899, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/u48Izeg-5W8\",\"type\":null,\"edituser\":\"2\",\"editdate\":1503843331,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(5, '2017-08-27 17:30:53', 1, 10, 1, '', 1, 0, 206, 0, 'Полезная информация', 'Useful info', 'testggggg', '', 0, '', '', '<p>Описание полезной информации</p>', '', 1503840600, 0, 0, 2, 1503840653, 2, 1503868777, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, ''),
(6, '2017-08-27 17:59:07', 1, 20, 1, '', 1, 0, 206, 0, 'Бесполезная информация', 'Unuseful info', '', '', 0, '', '', '<p>Описание бесполезной информации</p>', '', 1503842340, 0, 0, 2, 1503842347, 2, 1503868791, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, ''),
(7, '2017-08-27 17:59:37', 6, 100, 0, '', 1, 0, 206, 0, 'Статья1', 'Article1', '', '', 0, '', '', '', '', 1503842377, 0, 0, 2, 1503842377, 2, 1503852005, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(8, '2017-08-27 17:59:43', 6, 100, 0, '', 1, 0, 206, 0, 'Статья2', 'Article2', '', '', 0, '', '', '', '', 1503842383, 0, 0, 2, 1503842383, 2, 1503852009, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_attributes`
--

DROP TABLE IF EXISTS `mnbv_attributes`;
CREATE TABLE `mnbv_attributes` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_attributes`
--

INSERT INTO `mnbv_attributes` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 0, 103, 0, 'Атрибуты хранилищ', 'Storage attributes', '', '', '', '1', '', '<p>1</p>', 0, 0, 0, 2, 1468929671, 2, 1481636094, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(2, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 103, 0, 'Страна', 'Country', '', '', 'Русское описание', 'Eng aboute', '<p>Русский текст</p>', '<p>Eng text</p>', 0, 0, 0, 2, 1468929743, 2, 1481636100, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"select\",\"linkstorage\":\"attributes\",\"filter_folder\":\"2\",\"filter_type\":\"objects\",\"checktype\":\"int\",\"lang\":\"all\",\"viewindex\":1,\"dbtype\":\"int\"}', '', '', '', '', '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Вес,кг', 'Weight,kg', '', '', '', '', '', '', 0, 0, 0, 2, 1469004674, 2, 1481636103, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"width\":\"100%\",\"filter_type\":\"all\",\"checktype\":\"decimal\",\"lang\":\"all\",\"size\":\"11\",\"dbtype\":\"decimal\"}', '', '', '', '', '', 0, ''),
(4, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 103, 0, 'Город', 'Town', '', '', '', '', '', '', 0, 0, 0, 2, 1469004787, 2, 1481636106, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"select\",\"viewindex\":1,\"linkstorage\":\"attributes\",\"filter_folder\":\"4\",\"filter_type\":\"objects\",\"checktype\":\"int\",\"lang\":\"all\",\"dbtype\":\"int\"}', '', '', '', '', '', 0, ''),
(5, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Длина,м', 'Length,m', '', '', '', '', '', '', 0, 0, 0, 2, 1469004857, 2, 1481636108, '127.0.0.1', 'Администратор', '{\"dbtype\":\"decimal\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"no\",\"lang\":\"all\"}', '', '', '', '', '', 0, ''),
(6, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Ширина,м', 'Width,m', '', '', '', '', '', '', 0, 0, 0, 2, 1469004863, 2, 1481636111, '127.0.0.1', 'Администратор', '{\"dbtype\":\"decimal\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"no\",\"lang\":\"all\"}', '', '', '', '', '', 0, ''),
(7, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Высота,м', 'Height,m', '', '', '', '', '', '', 0, 0, 0, 2, 1469004867, 2, 1481636113, '127.0.0.1', 'Администратор', '{\"dbtype\":\"decimal\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"no\",\"lang\":\"all\"}', '', '', '', '', '', 0, ''),
(8, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 103, 0, 'Россия', 'Russia', '', '', '', '', '', '', 0, 0, 0, 2, 1469005123, 2, 1481636135, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(9, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 103, 0, 'Китай', 'China', '', '', '', '', '', '', 0, 0, 0, 2, 1469005129, 2, 1481636137, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(10, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 103, 0, 'Пендостан', 'USA', '', '', '', '', '', '', 0, 0, 0, 2, 1469005151, 2, 1481636140, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(11, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Москва', 'Moscow', '', '', '', '', '', '', 0, 0, 0, 2, 1469005194, 2, 1481636118, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(12, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Санкт-Петербург', 'Sankt Petersburg', '', '', '', '', '', '', 0, 0, 0, 2, 1469005201, 2, 1481636121, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(13, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Пекин', 'Pekin', '', '', '', '', '', '', 0, 0, 0, 2, 1469005208, 2, 1481636123, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(14, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Нью-Йорк', 'New York', '', '', '', '', '', '', 0, 0, 0, 2, 1469005233, 2, 1481636126, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(15, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Сиэтл', 'Seattle', '', '', '', '', '', '', 0, 0, 0, 2, 1469005240, 2, 1481636128, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_carts`
--

DROP TABLE IF EXISTS `mnbv_carts`;
CREATE TABLE `mnbv_carts` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `orders` int(11) NOT NULL,
  `utm_source` varchar(255) NOT NULL,
  `utm_medium` varchar(255) NOT NULL,
  `utm_campaign` varchar(255) NOT NULL,
  `utm_term` varchar(255) NOT NULL,
  `find_keys` varchar(255) NOT NULL,
  `partner_id` varchar(255) NOT NULL,
  `partner_code` varchar(255) NOT NULL,
  `utm_history` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_carts`
--

INSERT INTO `mnbv_carts` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `orders`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `find_keys`, `partner_id`, `partner_code`, `utm_history`) VALUES
(1, '2017-09-02 21:43:39', 0, 100, 1, '', 1, 118, 118, 0, 'Корзины пользователей', '', '', '', 0, '', '', '', '', 1504374180, 0, 0, 2, 1504374219, 2, 1504374227, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_countries`
--

DROP TABLE IF EXISTS `mnbv_countries`;
CREATE TABLE `mnbv_countries` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `discmaxpr` decimal(10,2) NOT NULL,
  `discmaxval` decimal(10,2) NOT NULL,
  `discminmargpr` decimal(10,2) NOT NULL,
  `discminmargval` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_countries`
--

INSERT INTO `mnbv_countries` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`) VALUES
(1, '2017-09-15 18:19:07', 0, 100, 1, '', 1, 0, 210, 0, 'Страны', 'Countries', '', '', 0, '', '', '', '', 1505485140, 0, 0, 2, 1505485147, 2, 1505485196, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(2, '2017-09-15 18:19:24', 1, 100, 0, '', 1, 0, 210, 0, 'Россия', 'Russia', '', '', 0, '', '', '', '', 1505485164, 0, 0, 2, 1505485164, 2, 1505485204, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(3, '2017-09-15 18:19:29', 1, 100, 0, '', 1, 0, 210, 0, 'Китай', 'China', '', '', 0, '', '', '', '', 1505485169, 0, 0, 2, 1505485169, 2, 1505485209, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(4, '2017-09-15 18:19:32', 1, 100, 0, '', 1, 0, 210, 0, 'США', 'USA', '', '', 0, '', '', '', '', 1505485172, 0, 0, 2, 1505485172, 2, 1505485216, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_discounts`
--

DROP TABLE IF EXISTS `mnbv_discounts`;
CREATE TABLE `mnbv_discounts` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `discpr` decimal(10,2) NOT NULL,
  `discval` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_discounts`
--

INSERT INTO `mnbv_discounts` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discpr`, `discval`) VALUES
(1, '2017-09-15 14:03:09', 0, 100, 1, '', 1, 0, 210, 0, 'Базовые типы скидок', 'Discount types', '', '', 0, '', '', '', '', 1505469789, 0, 0, 2, 1505469789, 2, 1505469819, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00'),
(2, '2017-09-15 14:03:52', 1, 10, 0, '', 1, 0, 210, 0, 'Первая скидка жесткая', 'Discount1', '', '', 0, '', '', '', '', 1505469832, 0, 0, 2, 1505469832, 2, 1505470482, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '100.00'),
(3, '2017-09-15 14:04:01', 1, 20, 0, '', 1, 0, 210, 0, 'Вторая скидка', 'Discount2', '', '', 0, '', '', '', '', 1505469841, 0, 0, 2, 1505469841, 2, 1505470485, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '10.00', '0.00'),
(4, '2017-09-15 14:04:09', 1, 30, 0, '', 1, 0, 210, 0, 'Третья скидка', 'Discount3', '', '', 0, '', '', '', '', 1505469849, 0, 0, 2, 1505469849, 2, 1505470456, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '20.00', '0.00');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_menu`
--

DROP TABLE IF EXISTS `mnbv_menu`;
CREATE TABLE `mnbv_menu` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `lang` varchar(20) NOT NULL,
  `nologin` tinyint(1) NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_menu`
--

INSERT INTO `mnbv_menu` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `lang`, `nologin`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 0, 104, 0, 'Меню', 'Menu', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280944, 2, 1482151687, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, ''),
(2, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 2, 0, 'Интранет', 'Intranet', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280969, 2, 1504691818, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню1 (Основная навигация)', 'Site', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481281008, 2, 1502182934, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', 'all', 0, '', 2, ''),
(4, '2017-08-08 12:58:11', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню2 (резерв)', '', '', '', 0, '', '', '', '', 1502182691, 0, 0, 2, 1502182691, 2, 1502182702, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(5, '2017-08-08 12:58:31', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню3 (резерв)', '', '', '', 0, '', '', '', '', 1502182711, 0, 0, 2, 1502182711, 2, 1502182711, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(6, '2017-08-08 12:58:35', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню4 (резерв)', '', '', '', 0, '', '', '', '', 1502182715, 0, 0, 2, 1502182715, 2, 1502182729, '127.0.0.1', 'Администратор', '', '', '', '', '', 'all', 0, '', 0, ''),
(7, '2017-08-08 12:58:42', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню5 (резерв)', '', '', '', 0, '', '', '', '', 1502182722, 0, 0, 2, 1502182722, 2, 1502182722, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(8, '2017-08-08 12:58:56', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню6 (резерв)', '', '', '', 0, '', '', '', '', 1502182736, 0, 0, 2, 1502182736, 2, 1502182736, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(9, '2017-08-08 12:59:02', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню7 (резерв)', '', '', '', 0, '', '', '', '', 1502182742, 0, 0, 2, 1502182742, 2, 1502182742, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(104, '0000-00-00 00:00:00', 2, 10, 0, '', 1, 200, 2, 0, 'Хранилища', 'Storages', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1482151565, 2, 1504691825, '127.0.0.1', 'Администратор', '{\"controller\":\"Storage\",\"url\":\"\\/intranet\\/storage\"}', '', '', '', '[\"1\",\"2\"]', 'all', 0, '', 0, ''),
(105, '0000-00-00 00:00:00', 2, 20, 0, '', 1, 200, 2, 0, 'Выход', 'Exit', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1482151572, 2, 1504691827, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\\/auth\\/?act=logout\",\"controller\":\"Auth\"}', '', '', '', '', 'all', 0, '', 0, ''),
(107, '0000-00-00 00:00:00', 3, 1000, 0, '', 0, 0, 104, 0, 'Интранет', 'Intranet', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1482152422, 2, 1503601128, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\"}', '', '', '', '', 'ru', 0, '', 0, ''),
(108, '2017-08-07 16:35:45', 2, 30, 0, '', 1, 0, 2, 0, 'Авторизация', 'Login', '', '', 0, '', '', '', '', 1502109345, 0, 0, 2, 1502109345, 2, 1504691828, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\\/auth\",\"controller\":\"Auth\"}', '', '', '', '', 'all', 1, '', 0, ''),
(109, '2017-08-23 11:37:13', 3, 10, 0, '', 1, 0, 104, 0, 'О компании', 'About', '', '', 0, '', '', '', '', 1503473833, 0, 0, 2, 1503473833, 2, 1503578830, '127.0.0.1', 'Администратор', '{\"url\":\"\\/about\",\"objid\":2}', '', '', '', '', 'ru', 0, '', 0, ''),
(110, '2017-08-23 11:37:21', 3, 20, 0, '', 1, 0, 104, 0, 'Каталог', 'Catalog', '', '', 0, '', '', '', '', 1503473841, 0, 0, 2, 1503473841, 2, 1503578844, '127.0.0.1', 'Администратор', '{\"url\":\"\\/catalog\",\"objid\":5}', '', '', '', '', 'ru', 0, '', 0, ''),
(111, '2017-08-23 11:37:35', 3, 40, 0, '', 1, 0, 104, 0, 'Контакты', 'Contacts', '', '', 0, '', '', '', '', 1503473855, 0, 0, 2, 1503473855, 2, 1504202233, '127.0.0.1', 'Администратор', '{\"url\":\"\\/contacts\",\"objid\":6}', '', '', '', '', 'ru', 0, '', 0, ''),
(112, '2017-08-23 11:37:56', 3, 60, 0, '', 1, 0, 104, 0, 'Авторизация', 'Login', '', '', 0, '', '', '', '', 1503473876, 0, 0, 2, 1503473876, 2, 1504388360, '127.0.0.1', 'Администратор', '{\"url\":\"\\/auth\",\"objid\":7}', '', '', '', '', 'ru', 0, '', 0, ''),
(113, '2017-08-24 16:44:53', 3, 1001, 0, '', 0, 0, 104, 0, 'Intranet', 'Intranet', '', '', 0, '', '', '', '', 1503578693, 0, 0, 2, 1503578693, 2, 1503601133, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\",\"altlang\":1}', '', '', '', '', 'eng', 0, '', 0, ''),
(114, '2017-08-24 16:44:59', 3, 11, 0, '', 1, 0, 104, 0, 'About', 'About', '', '', 0, '', '', '', '', 1503578699, 0, 0, 2, 1503578699, 2, 1503579643, '127.0.0.1', 'Администратор', '{\"url\":\"\\/eng\\/about\",\"objid\":2}', '', '', '', '', 'eng', 0, '', 0, ''),
(115, '2017-08-24 16:45:06', 3, 21, 0, '', 1, 0, 104, 0, 'Catalog', 'Catalog', '', '', 0, '', '', '', '', 1503578706, 0, 0, 2, 1503578706, 2, 1503579652, '127.0.0.1', 'Администратор', '{\"url\":\"\\/eng\\/catalog\",\"objid\":5}', '', '', '', '', 'eng', 0, '', 0, ''),
(116, '2017-08-24 16:45:11', 3, 41, 0, '', 1, 0, 104, 0, 'Contacts', 'Contacts', '', '', 0, '', '', '', '', 1503578711, 0, 0, 2, 1503578711, 2, 1504202247, '127.0.0.1', 'Администратор', '{\"url\":\"\\/eng\\/contacts\",\"objid\":6}', '', '', '', '', 'eng', 0, '', 0, ''),
(117, '2017-08-24 16:45:16', 3, 61, 0, '', 1, 0, 104, 0, 'Login', 'Login', '', '', 0, '', '', '', '', 1503578716, 0, 0, 2, 1503578716, 2, 1504388321, '127.0.0.1', 'Администратор', '{\"url\":\"\\/eng\\/auth\",\"objid\":7}', '', '', '', '', 'eng', 0, '', 0, ''),
(118, '2017-08-25 18:26:19', 3, 31, 0, '', 0, 0, 104, 0, 'Папка', 'Folder', '', '', 0, '', '', '', '', 1503671179, 0, 0, 2, 1503671179, 2, 1505506154, '127.0.0.1', 'Администратор', '{\"url\":\"\\/sitefolder\",\"objid\":8}', '', '', '', '', 'ru', 0, '', 0, ''),
(119, '2017-08-25 18:27:19', 3, 31, 0, '', 0, 0, 104, 0, 'Folder', 'Folder', '', '', 0, '', '', '', '', 1503671239, 0, 0, 2, 1503671239, 2, 1505506123, '127.0.0.1', 'Администратор', '{\"url\":\"\\/eng\\/sitefolder\",\"objid\":8}', '', '', '', '', 'eng', 0, '', 0, ''),
(120, '2017-09-02 21:29:44', 3, 50, 0, '', 1, 0, 104, 0, 'Корзина', '', '', '', 0, '', '', '', '', 1504373384, 0, 0, 2, 1504373384, 2, 1504390726, '127.0.0.1', 'Администратор', '{\"objid\":14,\"url\":\"\\/cart\"}', '', '', '', '', 'ru', 0, '', 0, ''),
(121, '2017-09-02 21:29:53', 3, 51, 0, '', 1, 0, 104, 0, 'Cart', 'Cart', '', '', 0, '', '', '', '', 1504373393, 0, 0, 2, 1504373393, 2, 1504565342, '127.0.0.1', 'Администратор', '{\"objid\":14,\"url\":\"\\/eng\\/cart\"}', '', '', '', '', 'eng', 0, '', 0, ''),
(130, '2017-09-16 00:08:16', 3, 30, 0, '', 1, 0, 104, 0, 'Акции', '', '', '', 0, '', '', '', '', 1505506096, 0, 0, 2, 1505506096, 2, 1505506192, '127.0.0.1', 'Администратор', '{\"url\":\"\\/actions\",\"objid\":15}', '', '', '', '', 'ru', 0, '', 2, ''),
(131, '2017-09-16 00:08:22', 3, 30, 0, '', 1, 0, 104, 0, 'Actions', 'Actions', '', '', 0, '', '', '', '', 1505506102, 0, 0, 2, 1505506102, 2, 1505506269, '127.0.0.1', 'Администратор', '{\"url\":\"\\/eng\\/actions\",\"objid\":15}', '', '', '', '', 'eng', 0, '', 2, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_messages`
--

DROP TABLE IF EXISTS `mnbv_messages`;
CREATE TABLE `mnbv_messages` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `from_fio` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_messages`
--

INSERT INTO `mnbv_messages` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `userid`, `email`, `from_fio`, `phone`) VALUES
(1, '2017-08-31 22:53:25', 0, 100, 1, '', 1, 117, 117, 0, 'Сообщения', '', '', '', 0, '', '', '', '', 1504205605, 0, 0, 2, 1504205605, 2, 1504205605, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', ''),
(2, '2017-08-31 22:53:36', 1, 100, 1, '', 1, 117, 117, 0, 'Контакты', '', '', '', 0, '', '', '', '', 1504205616, 0, 0, 2, 1504205616, 2, 1504205616, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, '', '', ''),
(25, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Тест формы в юзере Тест формы в юзере Тест формы в...', '', '', '', 0, '', '', 'Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере <br><br>Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере Тест формы в юзере ', '', 0, 0, 0, 0, 0, 0, 1504349057, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, '', '', ''),
(26, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'ывафывафываф фыв афыв фвы фыв фвы фыв фывфывфывф ы...', '', '', '', 0, '', '', 'ывафывафываф фыв афыв фвы фыв фвы фыв фывфывфывф ы ыфв фыв фыв ывф вы фыв фыв фыв фыв ы ', '', 0, 0, 0, 0, 0, 0, 1504363247, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, '', '', ''),
(27, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Тест сообщение Тест сообщение Тест сообщение Тест ...', '', '', '', 0, '', '', 'Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение <br><br>Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение Тест сообщение ', '', 0, 0, 0, 0, 0, 2, 1504375158, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '123@123.ru', 'Костя', '+7(915)111-11-11'),
(28, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://0daymusic.org/premium.php \r\n \r\nPrivate FTP ...', '', '', '', 0, '', '', 'http://0daymusic.org/premium.php <br> <br>Private FTP Music/Albums/mp3 1990-2018: <br>Plan A: 20 EUR - 200GB - 30 Days <br>Plan B: 45 EUR - 600GB - 90 Days <br>Plan C: 80 EUR - 1500GB - 180 Days', '', 0, 0, 0, 0, 0, 0, 1518845091, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'serverftp2018@mail.ru', 'JacksTusNV', '88885978964'),
(29, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2CBPbLJ золотой час часы купить \r\n \r...', '', '', '', 0, '', '', 'http://bit.ly/2CBPbLJ золотой час часы купить <br> <br>=Trade Mark=', '', 0, 0, 0, 0, 0, 0, 1519617374, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'coarse1993@mail.ru', 'AndrewspoofWQ', '82456639682'),
(30, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Со мной произошло тоже самое + мне не заплатили за...', '', '', '', 0, '', '', 'Со мной произошло тоже самое + мне не заплатили за последний месяц... <br>=== <br>Проходите мимо этой компании! <br>Вся зарплата, которая обещается вам на собеседовании - все обман, платят 20 000 руб! <br>Нужно из кожи вон выпрыгнуть, чтобы заработать на процентах что то большее. <br>Крупный проект сразу вам никто не даст! <br>Текучка ужасная, посмотрите хотя бы количество просмотров вакансии. <br>Люди приходят - поработают день-два - неделю - 2 месяца и уходят, поняв, что делать там нечего! <br>На зарплату при этом сильно не рассчитывайте, директор жадный до жути!!! <br>Найдут тысячу и одну причину чтобы не платить. <br>По трудовой устроить могут, если ты будешь приносить доход компании, но они сначала месяца 3-4 на тебя посмотрят, а не понравишься - хлопнут по крышке ноутбука - Пиши заявление на увольнение! <br>Трудовой договор с работниками не подписывают, поэтому даже в суд на них подавать бесполезно! <br>Сложно доказать что ты вообще в компании работал! <br>ИСТОЧНИК: http://antijob.net/black_list/ooo_centr_metrologicheskogo_obsluzhivaniya__zelpribor/ <br>=== <br>Делайте выводы Господа, следует ли работать с такой компанией, если у них такое отношение к собственному персоналу...', '', 0, 0, 0, 0, 0, 0, 1519704286, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'info@zelpribor.ru', 'Сотруднк', '+7 (495) 984-76-27'),
(31, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Уникальные очки Adlens с регулируемыми диоптриями,...', '', '', '', 0, '', '', 'Уникальные очки Adlens с регулируемыми диоптриями, производятся в Англии, теперь доступны и в России! <br>Благодаря запатентованной технологии ClearGlass, разработанной в Стэнфорде, Вы можете сами настроить <br>диоптрии под свое зрение для каждого глаза индивидуально, просто повернув колесико регулировки. <br>Очки обеспечивают комфортное зрение вблизи и на расстоянии. <br>http://bit.ly/2CNJwTa универсальные очки adlens купить', '', 0, 0, 0, 0, 0, 0, 1519933299, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'lurid-1987@mail.ru', 'DavidsmiffCQ', '89435227735'),
(32, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Уникальная отбеливающая маска, разработанная ведущ...', '', '', '', 0, '', '', 'Уникальная отбеливающая маска, разработанная ведущими косметологами для ухода за кожей лица с избыточной пигментацией. <br>http://bit.ly/2FilncD отбеливающая маска для лица клубника', '', 0, 0, 0, 0, 0, 0, 1520101543, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'stadium_84@mail.ru', 'AaronSteafME', '85919388995'),
(33, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2CBPbLJ купить часы оригинал \r\n \r\n=T...', '', '', '', 0, '', '', 'http://bit.ly/2CBPbLJ купить часы оригинал <br> <br>=Trade Mark=', '', 0, 0, 0, 0, 0, 0, 1520142331, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'coarse1993@mail.ru', 'AndrewspoofWQ', '87186433128'),
(34, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, ' \r\nПродажа баз для продвижения в интернете. Сбор т...', '', '', '', 0, '', '', ' <br>Продажа баз для продвижения в интернете. Сбор тематическийх баз. <br>Обращаться ICQ 726166382', '', 0, 0, 0, 0, 0, 0, 1520165344, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'ustin.samaranch.91@mail.ru', 'BobbyhoxMB', '87364317496'),
(35, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'купить настенные часы\r\n  http://bit.ly/2BT3gYu \r\n ...', '', '', '', 0, '', '', 'купить настенные часы<br>  http://bit.ly/2BT3gYu <br> <br>=time=', '', 0, 0, 0, 0, 0, 0, 1520203730, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'lika.pozhidaeva.1980@mail.ru', 'RobertKnispEM', '84755287152'),
(36, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Ярилин Варфоломей \r\n \r\n \r\nhttps://drive.google.com...', '', '', '', 0, '', '', 'Ярилин Варфоломей <br> <br> <br>https://drive.google.com/open?id=1t8W7S3lyE-ZSfzAiYXQ1PIUn4vnuJmGs', '', 0, 0, 0, 0, 0, 0, 1520244969, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'vitaus19621962@mail.ru', 'Язынина Марфа', '89034273295'),
(37, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Уникальная отбеливающая маска, разработанная ведущ...', '', '', '', 0, '', '', 'Уникальная отбеливающая маска, разработанная ведущими косметологами для ухода за кожей лица с избыточной пигментацией. <br>http://bit.ly/2FilncD отбеливающая маска для сухой кожи лица в домашних условиях', '', 0, 0, 0, 0, 0, 0, 1520247901, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'stadium_84@mail.ru', 'AaronSteafME', '85786629947'),
(38, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'https://drive.google.com/open?id=1NqlrQ8m-o6yuu3wQ...', '', '', '', 0, '', '', 'https://drive.google.com/open?id=1NqlrQ8m-o6yuu3wQLKAY6N12fCgGyiLk <br>Щепкина Эвелина', '', 0, 0, 0, 0, 0, 0, 1520269800, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, '2266660@mail.ru', 'Селидов Дмитрий', '89910000519'),
(39, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Лелух Юрий \r\nhttps://drive.google.com/file/d/1KbGR...', '', '', '', 0, '', '', 'Лелух Юрий <br>https://drive.google.com/file/d/1KbGRnxWGkag5Wdwzr5vDBEmkZZoa8HHx/preview', '', 0, 0, 0, 0, 0, 0, 1520350718, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'nickeagle@mail.ru', 'Будникова Мирослава', '89910000691'),
(40, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Сезонная распродажа Ray-Ban по ценам производителя...', '', '', '', 0, '', '', 'Сезонная распродажа Ray-Ban по ценам производителя <br>http://bit.ly/2F23Wh1 ', '', 0, 0, 0, 0, 0, 0, 1520388307, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'poluektova.anelya@mail.ru', 'WilliamgokRP', '85582231375'),
(41, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Козарь Платон \r\n \r\nhttps://drive.google.com/file/d...', '', '', '', 0, '', '', 'Козарь Платон <br> <br>https://drive.google.com/file/d/1A_-r0U_gNE0yU1azh-Ha8KzDlejmSRNL/preview', '', 0, 0, 0, 0, 0, 0, 1520454160, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'olga_astra2@mail.ru', 'Смагина Доминика', '89910000419'),
(42, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Прибыльнова Алла \r\nhttps://drive.google.com/file/d...', '', '', '', 0, '', '', 'Прибыльнова Алла <br>https://drive.google.com/file/d/19NCLdCemAgaJ5DQhynmsKEXO-iPnppPO/preview', '', 0, 0, 0, 0, 0, 0, 1520515651, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'bagorfiles@mail.ru', 'Борисюка Ариадна', '89910000976'),
(43, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Яндашевский Константин \r\n \r\nhttps://drive.google.c...', '', '', '', 0, '', '', 'Яндашевский Константин <br> <br>https://drive.google.com/file/d/1-PYEd8T3HwIBuD5n4w7y4cl8dNSCcBB8/preview', '', 0, 0, 0, 0, 0, 0, 1520541120, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'polyianowa.l@mail.ru', 'Молодцова Алиса', '89910000278'),
(44, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Севостьянов Валерьян \r\n \r\nhttps://drive.google.com...', '', '', '', 0, '', '', 'Севостьянов Валерьян <br> <br>https://drive.google.com/file/d/113VrSXGThLv1lmwsCKVOnH7s7ekp_h0C/preview', '', 0, 0, 0, 0, 0, 0, 1520595656, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'barsdshi@mail.ru', 'Балановский Феликс', '89910000237'),
(45, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Сусталайф - полностью натуральные капсулы. Их сост...', '', '', '', 0, '', '', 'Сусталайф - полностью натуральные капсулы. Их состав невозможно воспроизвести синтетически. Ученые еще не смогли создать аналогов этого препарата. <br>http://bit.ly/2FhZ5b3 сусталайф цена отзывы в новосибирске', '', 0, 0, 0, 0, 0, 0, 1520610918, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'vitya.pay.yusufov@mail.ru', 'SammieTepFI', '87969188526'),
(46, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'интернет магазин брендовых часов\r\n  http://bit.ly/...', '', '', '', 0, '', '', 'интернет магазин брендовых часов<br>  http://bit.ly/2GOGjF7 <br> <br>=time=', '', 0, 0, 0, 0, 0, 0, 1520611862, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'poluektova.anelya@mail.ru', 'RobertKnispEM', '88756735263'),
(47, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Предлагаем рассмотреть наше встречное предложение:...', '', '', '', 0, '', '', 'Предлагаем рассмотреть наше встречное предложение: <br> <br>Базы юр.лиц и физ. лиц для рекламы Ваших товаров и услуг <br>Только до 13 марта - 50% на все базы! <br> <br>Указаны с учётом 50% обновление март 2018 <br> <br>База по всей России(много источников-разбита по видам деятельности -3млн)  - 2000р <br>База Яндекс Карт ВСЯ РОССИЯ(разбита по регионам 3млн)    - 1500р <br>База 2 GIS 2018 СНГ + Россия (разбита по регионам 3млн)     - 1500р <br>База по городу или виду деятельности      - 750р <br>База поставщиков государственных закупок(1.2 млн) - 2000р <br>База заказчиков государственных закупок(400тыс)  - 2500р <br>База e-mail физических лиц(активных пользователй сети Интернет 3млн)- 1750р <br>База емайлов юр.лиц(более 1.5 млн) - 1500р <br>База сайтов России(6.3млн)- 700р <br> <br>Все базы из списка - 7000р <br> <br>Заявки только сюда: base.all @ bk.ru (убрать пробелы)', '', 0, 0, 0, 0, 0, 0, 1520688481, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'tarasowa1981@mail.ru', 'Энгельгардта Инесса', '89910000967'),
(48, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Кизюрина Христина \r\nhttps://drive.google.com/file/...', '', '', '', 0, '', '', 'Кизюрина Христина <br>https://drive.google.com/file/d/1X9z7mz7wKwTn2UoV2J-LxoSLZtT35kGc/preview', '', 0, 0, 0, 0, 0, 0, 1520816370, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'nikolaev78.78@mail.ru', 'Новичкова Юнона', '89910000193'),
(49, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Oкажу помощь в подборе пaроля к чужому почтовомy а...', '', '', '', 0, '', '', 'Oкажу помощь в подборе пaроля к чужому почтовомy аккаунту <br>Время исполнения: от 3x часов до 3 дней <br> <br>Пaрoль НЕ изменяется, т.е. остаётся тем же, что использует владелец ящика. <br>Предоплату НЕ беру, оплата производится только по факту выполнения работы. <br> <br>Доказательства выполнения работы: Фото почты ( писем ) / читаю и цитирую вам ваше письмо посланное на почту. <br>Расценки Мaил/лиcт/бк/инбoкс: 4000 рублей/ Яндекс 12 000р. + Корпоративные. <br> <br>Так же пробив данных/детализация звонков/доступ в личный кабинет  билайн мтс ТЕЛЕ2 Мегафон + блокировка номеров. <br>Для связи писать:  uslugiopen5 @ gmail. com  ( пробелы стереть )', '', 0, 0, 0, 0, 0, 0, 1520827856, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'open.1qper@mail.ru', 'GeorgeItach', '386257258'),
(50, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2FH2zUE BioGrow Plus – биоактиватор ...', '', '', '', 0, '', '', 'http://bit.ly/2FH2zUE BioGrow Plus – биоактиватор роста растений и рассады (99 руб) <br>Инновационное биоудобрение, позволяющее в разы увеличить всхожесть, урожайность <br>и устойчивость растений всего за несколько применений. Можно получить хороший урожай даже на низкоплодородных почвах и в неблагоприятных климатических условиях. Абсолютно безопасно.', '', 0, 0, 0, 0, 0, 0, 1520953794, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 't-aladyshkin@mail.ru', 'MichaelLenTX', '88185434532'),
(51, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Со мной произошло тоже самое + мне не заплатили за...', '', '', '', 0, '', '', 'Со мной произошло тоже самое + мне не заплатили за последний месяц... <br>=== <br>Проходите мимо этой компании! <br>Вся зарплата, которая обещается вам на собеседовании - все обман, платят 20 000 руб! <br>Нужно из кожи вон выпрыгнуть, чтобы заработать на процентах что то большее. <br>Крупный проект сразу вам никто не даст! <br>Текучка ужасная, посмотрите хотя бы количество просмотров вакансии. <br>Люди приходят - поработают день-два - неделю - 2 месяца и уходят, поняв, что делать там нечего! <br>На зарплату при этом сильно не рассчитывайте, директор жадный до жути!!! <br>Найдут тысячу и одну причину чтобы не платить. <br>По трудовой устроить могут, если ты будешь приносить доход компании, но они сначала месяца 3-4 на тебя посмотрят, а не понравишься - хлопнут по крышке ноутбука - Пиши заявление на увольнение! <br>Трудовой договор с работниками не подписывают, поэтому даже в суд на них подавать бесполезно! <br>Сложно доказать что ты вообще в компании работал! <br>ИСТОЧНИК: http://antijob.net/black_list/ooo_centr_metrologicheskogo_obsluzhivaniya__zelpribor/ <br>=== <br>Делайте выводы Господа, следует ли работать с такой компанией, если у них такое отношение к собственному персоналу...', '', 0, 0, 0, 0, 0, 0, 1520957660, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'info@zelpribor.ru', 'Сотруднк', '+7 (495) 984-76-27'),
(52, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2FH2zUE BioGrow Plus – биоактиватор ...', '', '', '', 0, '', '', 'http://bit.ly/2FH2zUE BioGrow Plus – биоактиватор роста растений и рассады (99 руб) <br>Инновационное биоудобрение, позволяющее в разы увеличить всхожесть, урожайность <br>и устойчивость растений всего за несколько применений. Можно получить хороший урожай даже на низкоплодородных почвах и в неблагоприятных климатических условиях. Абсолютно безопасно.', '', 0, 0, 0, 0, 0, 0, 1520964324, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 't-aladyshkin@mail.ru', 'MichaelVopTX', '88952769863'),
(53, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Спартак \r\nhttps://drive.google.com/file/d/1XIN-aUa...', '', '', '', 0, '', '', 'Спартак <br>https://drive.google.com/file/d/1XIN-aUa7nNjBDeZmFK5d7Km183EeawN3/preview', '', 0, 0, 0, 0, 0, 0, 1520996182, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, '0268zhenya@mail.ru', 'Барбара', '89910000739'),
(54, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2t9Dwo3 InFit Drive - предтренировоч...', '', '', '', 0, '', '', 'http://bit.ly/2t9Dwo3 InFit Drive - предтренировочный массажный крем, содержащий активные растительные компоненты, для повышения эффективности занятий спортом и фитнесом. <br>Биокомпоненты крема InFit Drive способствуют подготовке организма к физическим нагрузкам, защищают мышцы от растяжения и микротравм, <br>помогают улучшить силовые показатели, выносливость, создают условия для наращивания мышечной массы за счет усиления кровоснабжения мышечных волокон. <br>Препятствует возникновению растяжек. <br> <br>InFit Up - послетренировочный массажный крем, содержащий активные растительные компоненты, для эффективного восстановления организма после интенсивных физических нагрузок. <br>Биокомпоненты крема InFit Up стимулируют белковый синтез, а также выработку необходимых аминокислот, ферментов, восстановление водно-электролитного баланса, что способствует наращиванию сухой мышечной массы. <br>Препятствует возникновению растяжек. Улучшает тонус кожи и мышц. <br> <br>http://bit.ly/2t9Dwo3 InFit - Шикарные фигуры девушек видео', '', 0, 0, 0, 0, 0, 0, 1521054595, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'ellada.sarycheva.1980@mail.ru', 'GenaroFlurlNW', '82826768351'),
(55, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2t9Dwo3 InFit Drive - предтренировоч...', '', '', '', 0, '', '', 'http://bit.ly/2t9Dwo3 InFit Drive - предтренировочный массажный крем, содержащий активные растительные компоненты, для повышения эффективности занятий спортом и фитнесом. <br>Биокомпоненты крема InFit Drive способствуют подготовке организма к физическим нагрузкам, защищают мышцы от растяжения и микротравм, <br>помогают улучшить силовые показатели, выносливость, создают условия для наращивания мышечной массы за счет усиления кровоснабжения мышечных волокон. <br>Препятствует возникновению растяжек. <br> <br>InFit Up - послетренировочный массажный крем, содержащий активные растительные компоненты, для эффективного восстановления организма после интенсивных физических нагрузок. <br>Биокомпоненты крема InFit Up стимулируют белковый синтез, а также выработку необходимых аминокислот, ферментов, восстановление водно-электролитного баланса, что способствует наращиванию сухой мышечной массы. <br>Препятствует возникновению растяжек. Улучшает тонус кожи и мышц. <br> <br>http://bit.ly/2t9Dwo3 InFit - Стройная шикарная фигура фото', '', 0, 0, 0, 0, 0, 0, 1521069842, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'ellada.sarycheva.1980@mail.ru', 'GenaroHieseNW', '87527875661'),
(56, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'http://bit.ly/2t9Dwo3 InFit Drive - предтренировоч...', '', '', '', 0, '', '', 'http://bit.ly/2t9Dwo3 InFit Drive - предтренировочный массажный крем, содержащий активные растительные компоненты, для повышения эффективности занятий спортом и фитнесом. <br>Биокомпоненты крема InFit Drive способствуют подготовке организма к физическим нагрузкам, защищают мышцы от растяжения и микротравм, <br>помогают улучшить силовые показатели, выносливость, создают условия для наращивания мышечной массы за счет усиления кровоснабжения мышечных волокон. <br>Препятствует возникновению растяжек. <br> <br>InFit Up - послетренировочный массажный крем, содержащий активные растительные компоненты, для эффективного восстановления организма после интенсивных физических нагрузок. <br>Биокомпоненты крема InFit Up стимулируют белковый синтез, а также выработку необходимых аминокислот, ферментов, восстановление водно-электролитного баланса, что способствует наращиванию сухой мышечной массы. <br>Препятствует возникновению растяжек. Улучшает тонус кожи и мышц. <br> <br>http://bit.ly/2t9Dwo3 InFit - Женщины с шикарной фигурой', '', 0, 0, 0, 0, 0, 0, 1521080819, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'ellada.sarycheva.1980@mail.ru', 'GenaroSitNW', '82324697852'),
(57, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Тошик \r\nhttps://drive.google.com/file/d/11PT7ms_OE...', '', '', '', 0, '', '', 'Тошик <br>https://drive.google.com/file/d/11PT7ms_OErdx-nHMzQ18giea3jAMTEz0/preview <br>damala1@mail.ru', '', 0, 0, 0, 0, 0, 0, 1521111746, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'mari_28.92@mail.ru', 'Маратик', '89910000214'),
(58, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Євгеній \r\n \r\n \r\nhttps://drive.google.com/file/d/1e...', '', '', '', 0, '', '', 'Євгеній <br> <br> <br>https://drive.google.com/file/d/1eVMA7xLtpMQd2u47wJhTM4rEGCheZXu9/preview', '', 0, 0, 0, 0, 0, 0, 1521136996, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'kovtunova_valentina@mail.ru', 'Акиф', '89910000174'),
(59, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Галечка \r\n \r\n \r\nhttps://drive.google.com/file/d/18...', '', '', '', 0, '', '', 'Галечка <br> <br> <br>https://drive.google.com/file/d/18yk1XTEnpR4Cm2tP395UvUPr9567MEeq/preview', '', 0, 0, 0, 0, 0, 0, 1521177831, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'kisyu23@mail.ru', 'Айгюль', '89910000430'),
(60, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Разрешите Вас приветствовать  Овсеп \r\n \r\nhttps://d...', '', '', '', 0, '', '', 'Разрешите Вас приветствовать  Овсеп <br> <br>https://drive.google.com/file/d/15MtVuOaifMAF2Wd3Eytaf-bpjMvdyp6n/preview', '', 0, 0, 0, 0, 0, 0, 1521311666, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'nat_katasheva@mail.ru', 'Назерке', '89910000341'),
(61, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Приветствую Вас  Стивен \r\n \r\nhttps://drive.google....', '', '', '', 0, '', '', 'Приветствую Вас  Стивен <br> <br>https://drive.google.com/file/d/1B5b6EeU-8juKdy8kjw4eBhpVm4GE0HsV/preview', '', 0, 0, 0, 0, 0, 0, 1521329362, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'hramov_s91@mail.ru', 'Данила', '89910000758'),
(62, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Здравия желаю  Ліда \r\n \r\nhttps://drive.google.com/...', '', '', '', 0, '', '', 'Здравия желаю  Ліда <br> <br>https://drive.google.com/file/d/1cOg2paI6tC-r2Cs9Ylj7l3_HNp-8nfEj/preview', '', 0, 0, 0, 0, 0, 0, 1521353326, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'galia.ivanova6@mail.ru', 'Асхаб', '89910000241'),
(63, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Со мной произошло тоже самое + мне не заплатили за...', '', '', '', 0, '', '', 'Со мной произошло тоже самое + мне не заплатили за последний месяц... <br>=== <br>Проходите мимо этой компании! <br>Вся зарплата, которая обещается вам на собеседовании - все обман, платят 20 000 руб! <br>Нужно из кожи вон выпрыгнуть, чтобы заработать на процентах что то большее. <br>Крупный проект сразу вам никто не даст! <br>Текучка ужасная, посмотрите хотя бы количество просмотров вакансии. <br>Люди приходят - поработают день-два - неделю - 2 месяца и уходят, поняв, что делать там нечего! <br>На зарплату при этом сильно не рассчитывайте, директор жадный до жути!!! <br>Найдут тысячу и одну причину чтобы не платить. <br>По трудовой устроить могут, если ты будешь приносить доход компании, но они сначала месяца 3-4 на тебя посмотрят, а не понравишься - хлопнут по крышке ноутбука - Пиши заявление на увольнение! <br>Трудовой договор с работниками не подписывают, поэтому даже в суд на них подавать бесполезно! <br>Сложно доказать что ты вообще в компании работал! <br>ИСТОЧНИК: http://antijob.net/black_list/ooo_centr_metrologicheskogo_obsluzhivaniya__zelpribor/ <br>=== <br>Делайте выводы Господа, следует ли работать с такой компанией, если у них такое отношение к собственному персоналу...', '', 0, 0, 0, 0, 0, 0, 1521368844, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'info@zelpribor.ru', 'Сотруднк', '+7 (495) 984-76-27'),
(64, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Доброе утро!  Крис \r\n \r\nhttps://drive.google.com/f...', '', '', '', 0, '', '', 'Доброе утро!  Крис <br> <br>https://drive.google.com/file/d/1ll_ugS87jkZ7IwzXJy7eCYVqnaMrbB0j/preview', '', 0, 0, 0, 0, 0, 0, 1521381266, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'mbd0803@mail.ru', 'Ан', '89910000738'),
(65, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Здравия желаю  Стефани \r\n \r\nhttps://drive.google.c...', '', '', '', 0, '', '', 'Здравия желаю  Стефани <br> <br>https://drive.google.com/file/d/1GEzdlDOty6AVijeCbZDwVtsityx-FR3Q/preview', '', 0, 0, 0, 0, 0, 0, 1521403616, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'kuzmina_tanya@list.ru', 'Нурай', '89910000291'),
(66, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Сердечно приветствую Вас! \r\nПапина \r\nhttps://drive...', '', '', '', 0, '', '', 'Сердечно приветствую Вас! <br>Папина <br>https://drive.google.com/file/d/1sdzY8rXicdIWLaHTEMt8BFLFJgawK2SO/preview', '', 0, 0, 0, 0, 0, 0, 1521416892, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'krasnjkowa-galin@mail.ru', 'Ліля', '89910000625'),
(67, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Какая встреча! \r\nФекла \r\nhttps://drive.google.com/...', '', '', '', 0, '', '', 'Какая встреча! <br>Фекла <br>https://drive.google.com/file/d/1ZOjLLa2ecYMyXA7eUQFQd7gDUD4BgSpy/preview', '', 0, 0, 0, 0, 0, 0, 1521435663, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'n-reznik@list.ru', 'Региша', '89910000685'),
(68, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Здравствуйте!  Татка \r\nhttps://drive.google.com/fi...', '', '', '', 0, '', '', 'Здравствуйте!  Татка <br>https://drive.google.com/file/d/1OGqMIaQHtvrBXA1eeG_TasI0O2xm5rDz/preview', '', 0, 0, 0, 0, 0, 0, 1521460512, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'guzi_91-kz@mail.ru', 'Катюнчик', '89910000882'),
(69, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Рад Вас слышать  Нурзида \r\nhttps://drive.google.co...', '', '', '', 0, '', '', 'Рад Вас слышать  Нурзида <br>https://drive.google.com/file/d/1_HDdqBHuS8FEYDc-32TtHPnl8_R962ur/preview', '', 0, 0, 0, 0, 0, 0, 1521490581, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'landysh_azn@mail.ru', 'Фуркат', '89910000546'),
(70, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Рад Вас слышать  Віка \r\nhttps://drive.google.com/f...', '', '', '', 0, '', '', 'Рад Вас слышать  Віка <br>https://drive.google.com/file/d/1kO3Q8dIW__EUS0MtcMaSh4QStPIZhA2N/preview', '', 0, 0, 0, 0, 0, 0, 1521514937, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'ku-mis@mail.ru', 'Мээрим', '89910000500'),
(71, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 0, 0, 'Ляйсян \r\nГорячо приветствую \r\nhttps://drive.google...', '', '', '', 0, '', '', 'Ляйсян <br>Горячо приветствую <br>https://drive.google.com/file/d/1YvM8tc-93TGsrah1RSrmhcOIQoCEHF7Q/preview', '', 0, 0, 0, 0, 0, 0, 1521548854, '127.0.0.1', '', '', '', '', '', '', '', 0, '', 0, 'natalia1973@inbox.ru', 'Айаал', '89910000610');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_news`
--

DROP TABLE IF EXISTS `mnbv_news`;
CREATE TABLE `mnbv_news` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_news`
--

INSERT INTO `mnbv_news` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-19 14:09:37', 0, 100, 1, '', 1, 0, 205, 0, 'Новости', '', '', '', 0, '', '', '', '', 1503137377, 0, 0, 2, 1503137377, 2, 1503137377, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(2, '2017-08-19 14:10:30', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 1', 'News1', 'novost-1', '', 0, 'краткое описание новости 1', '', '<p>Полное описание новости 1.</p>', '', 1503137400, 0, 0, 2, 1503137430, 2, 1504005137, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":159,\"w\":600,\"h\":337,\"min\":{\"kb\":7,\"w\":100,\"h\":56},\"big\":{\"kb\":1301,\"w\":1820,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"20160820_160653.jpg\",\"edituser\":\"2\",\"editdate\":1503138995,\"upldate\":1503138995,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(3, '2017-08-19 14:10:36', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 2', 'News2', 'novost-2', '', 0, 'краткое описание новости 2', '', '<p>Полное описание новости 2</p>', '', 1503223800, 0, 0, 2, 1503137436, 2, 1504005135, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":128,\"w\":600,\"h\":337,\"min\":{\"kb\":7,\"w\":100,\"h\":56},\"big\":{\"kb\":1037,\"w\":1820,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"20160820_160717.jpg\",\"edituser\":\"2\",\"editdate\":1503139031,\"upldate\":1503139031,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(4, '2017-08-19 14:10:42', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 3', 'News3', 'News3', '', 0, 'краткое описание новости 3.', 'mini description of news3.', '<p>Полное описание новости 3 полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3.</p>\r\n<p>&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3&nbsp;полное описание новости 3.</p>', '<p>Full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3.</p>\r\n<p>&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3.</p>\r\n<p>{{img:2}}</p>', 1503310200, 0, 0, 2, 1503137442, 2, 1504006326, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":218,\"w\":600,\"h\":402,\"min\":{\"kb\":10,\"w\":100,\"h\":67},\"big\":{\"kb\":427,\"w\":940,\"h\":630}},\"type\":\"jpg\",\"fname\":\"preview_b416ff7b8703f44e434ee67abacadad4.jpg\",\"edituser\":\"2\",\"editdate\":1504006326,\"upldate\":1504004681,\"editip\":\"127.0.0.1\",\"name\":\"\\u0413\\u043e\\u0440\\u0430\"},\"2\":{\"url\":\"https:\\/\\/youtu.be\\/u48Izeg-5W8\",\"type\":null,\"edituser\":\"2\",\"editdate\":1504006326,\"editip\":\"127.0.0.1\"},\"3\":{\"size\":{\"kb\":157,\"w\":600,\"h\":401,\"min\":{\"kb\":7,\"w\":100,\"h\":66},\"big\":{\"kb\":782,\"w\":1529,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"iceberg.jpg\",\"edituser\":\"2\",\"editdate\":1504006326,\"upldate\":1504005376,\"editip\":\"127.0.0.1\",\"name\":\"\\u0410\\u0439\\u0441\\u0431\\u0435\\u0440\\u0433\"},\"4\":{\"size\":{\"kb\":231,\"w\":600,\"h\":450,\"min\":{\"kb\":9,\"w\":100,\"h\":75},\"big\":{\"kb\":657,\"w\":1024,\"h\":768}},\"type\":\"jpg\",\"fname\":\"Desert.jpg\",\"edituser\":\"2\",\"editdate\":1504006326,\"upldate\":1504005386,\"editip\":\"127.0.0.1\",\"name\":\"\\u041f\\u0443\\u0441\\u0442\\u044b\\u043d\\u044f\"},\"5\":{\"size\":{\"kb\":250,\"w\":600,\"h\":450,\"min\":{\"kb\":10,\"w\":100,\"h\":75},\"big\":{\"kb\":677,\"w\":1024,\"h\":768}},\"type\":\"jpg\",\"fname\":\"Koala.jpg\",\"edituser\":\"2\",\"editdate\":1504006326,\"upldate\":1504005395,\"editip\":\"127.0.0.1\",\"name\":\"\\u0416\\u0438\\u0432\\u043e\\u0442\\u043d\\u043e\\u0435\"}}}', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_orders`
--

DROP TABLE IF EXISTS `mnbv_orders`;
CREATE TABLE `mnbv_orders` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `userid` int(11) NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_orders`
--

INSERT INTO `mnbv_orders` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `userid`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-31 22:51:39', 0, 100, 1, '', 1, 118, 118, 0, 'Заказы', '', '', '', 0, '', '', '', '', 1504205499, 0, 0, 2, 1504205499, 2, 1504205499, '127.0.0.1', 'Администратор', '', '', '', '', '', 0, '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_products`
--

DROP TABLE IF EXISTS `mnbv_products`;
CREATE TABLE `mnbv_products` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `oldprice` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `discmaxpr` decimal(10,2) NOT NULL,
  `discmaxval` decimal(10,2) NOT NULL,
  `discminmargpr` decimal(10,2) NOT NULL,
  `discminmargval` decimal(10,2) NOT NULL,
  `vendor` int(11) NOT NULL,
  `country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_products`
--

INSERT INTO `mnbv_products` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `price`, `oldprice`, `cost`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`, `vendor`, `country`) VALUES
(1, '1970-01-01 03:00:00', 0, 100, 1, '', 1, 0, 210, 0, 'Товары', 'Products', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005900, 2, 1505484433, '127.0.0.1', 'Администратор', '{\"title\":\"Title\"}', '', '{\"1\":{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}}', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(2, '1970-01-01 03:00:00', 1, 100, 1, '', 1, 0, 210, 0, 'Категория товаров 1', 'Cat 1', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005919, 2, 1502526851, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '[{\"attrid\":\"4\",\"pozid\":500,\"namelang\":\"Town\"}]', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(3, '1970-01-01 03:00:00', 1, 100, 1, '', 1, 0, 210, 0, 'Категория товаров 2', 'Cat 2', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005940, 2, 1502526858, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(4, '1970-01-01 03:00:00', 2, 100, 0, '', 1, 0, 210, 1, 'Товар1', 'Prod 1', 'tovar1', '', 0, 'краткое описание товара1', 'Mini product 1 description.', '<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>\r\n<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара. &nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>\r\n<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>', '<p>Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;</p>\r\n<p>Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;</p>\r\n<p>Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;</p>', 1502838000, 0, 0, 2, 1469005946, 2, 1518714339, '127.0.0.1', 'Администратор', '', '', '', '{\"attr2\":8,\"attr4\":12,\"attr3\":\"25.33\"}', '', '{\"img\":{\"1\":{\"edituser\":\"2\",\"editdate\":1502526822,\"upldate\":\"\",\"editip\":\"127.0.0.1\",\"url\":\"https:\\/\\/icdn.lenta.ru\\/images\\/2017\\/08\\/03\\/19\\/20170803190811589\\/detail_d0d936dab749ff4db97d121605a776f8.jpg\",\"type\":\"jpg\",\"name\":\"\\u0412\\u043d\\u0435\\u0448\\u043d\\u044f\\u044f \\u043a\\u0430\\u0440\\u0442\\u0438\\u043d\\u043a\\u0430\"},\"2\":{\"size\":{\"kb\":157,\"w\":600,\"h\":401,\"min\":{\"kb\":2,\"w\":40,\"h\":26},\"big\":{\"kb\":775,\"w\":1529,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"iceberg.jpg\",\"edituser\":\"2\",\"editdate\":1518686454,\"upldate\":1518686454,\"editip\":\"127.0.0.1\"},\"3\":{\"size\":{\"kb\":218,\"w\":600,\"h\":402,\"min\":{\"kb\":3,\"w\":40,\"h\":26},\"big\":{\"kb\":427,\"w\":940,\"h\":630}},\"type\":\"jpg\",\"fname\":\"preview_b416ff7b8703f44e434ee67abacadad4.jpg\",\"edituser\":\"2\",\"editdate\":1518686860,\"upldate\":1518686860,\"editip\":\"127.0.0.1\"}}}', 0, '', '150.27', '250.00', '100.00', '0.00', '0.00', '0.00', '0.00', 2, 3),
(5, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 210, 1, 'Товар2', 'Prod 2', '', '', 0, 'Краткое описание товара 2', 'Mini product 2 description.', '', '', 1501542000, 0, 0, 2, 1469005950, 2, 1521585574, '127.0.0.1', 'Администратор', '', '', '', '{\"attr2\":9,\"attr3\":\"0.00\"}', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/pAgnJDJN4VA\",\"type\":null,\"edituser\":\"2\",\"editdate\":1506609585,\"editip\":\"127.0.0.1\"}}}', 0, '', '220.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(6, '0000-00-00 00:00:00', 3, 100, 0, '', 1, 0, 210, 0, 'Товар3', 'Prod 3', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005958, 2, 1481469644, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(7, '0000-00-00 00:00:00', 3, 100, 0, '', 1, 0, 210, 0, 'Товар4', 'Prod 4', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005963, 2, 1481469649, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(8, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 210, 0, 'Категория товаров 3', 'Cat 3', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1470732688, 2, 1502526870, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(9, '1970-01-01 03:00:00', 8, 100, 1, '', 1, 0, 210, 0, 'CatCat 3', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1470732716, 2, 1481469661, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\",\"8\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(10, '0000-00-00 00:00:00', 9, 100, 1, '', 1, 0, 210, 0, 'CatCatCat3', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1470833797, 2, 1481469675, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\",\"8\",\"9\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_robots`
--

DROP TABLE IF EXISTS `mnbv_robots`;
CREATE TABLE `mnbv_robots` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_robots`
--

INSERT INTO `mnbv_robots` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-09-21 17:54:27', 0, 100, 1, '', 1, 301, 2, 0, 'Роботы', 'Robots', '', '', 0, '', '', '', '', 1506002067, 0, 0, 2, 1506002067, 2, 1507725661, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(7, '2017-09-28 21:19:58', 1, 100, 0, '', 1, 301, 2, 0, 'Таймер', 'Timer', 'timer', '', 0, '', '', '', '', 1506619198, 0, 0, 2, 1506619198, 2, 1506954935, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(8, '2017-10-03 23:43:54', 1, 100, 0, '', 1, 301, 2, 0, 'Тест крона', 'Cron test robot', 'crontest', '', 0, '', '', '', '', 1507059834, 0, 0, 2, 1507059834, 2, 1507105728, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(9, '2017-10-04 12:26:03', 1, 100, 0, '', 1, 301, 2, 0, 'Запуск кроновых скриптов', 'Start cron scripts', 'startcron', '', 0, '', '', '', '', 1507105563, 0, 0, 2, 1507105563, 2, 1507105744, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(10, '2017-10-04 17:21:14', 1, 100, 0, '', 1, 301, 2, 0, 'Мониторинг активных роботов', 'Robots activity monitor', 'robotsmonitor', '', 0, '', '', '', '', 1507123274, 0, 0, 2, 1507123274, 2, 1509441929, '127.0.0.1', 'Администратор', '{\"output\":\"\\/dev\\/null\"}', '', '', '', '', '', 0, ''),
(19, '2018-02-21 15:53:32', 1, 100, 0, '', 1, 301, 2, 0, 'Рестарт скриптов', 'Script restart', 'robotsrestart', '', 0, '', '', '', '', 1519217612, 0, 0, 2, 1519217612, 2, 1519217650, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_robotsrun`
--

DROP TABLE IF EXISTS `mnbv_robotsrun`;
CREATE TABLE `mnbv_robotsrun` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `robot` int(11) NOT NULL,
  `runfile` varchar(255) NOT NULL,
  `market` int(11) NOT NULL DEFAULT '0',
  `pair` int(11) NOT NULL DEFAULT '0',
  `marketkey` int(11) NOT NULL,
  `command` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `cronrun` int(1) NOT NULL DEFAULT '0',
  `rbtype` varchar(50) NOT NULL,
  `pairslist` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_robotsrun`
--

INSERT INTO `mnbv_robotsrun` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `robot`, `runfile`, `market`, `pair`, `marketkey`, `command`, `status`, `message`, `sid`, `pid`, `cronrun`, `rbtype`, `pairslist`) VALUES
(1, '2017-09-21 17:53:13', 0, 100, 1, '', 1, 301, 305, 0, 'Задания роботов', 'Robots run', '', '', 0, 'Cron записи\r\n* * * * * выполняемая команда\r\n- - - - -\r\n| | | | |\r\n| | | | ----- День недели (0 - 7) (Воскресенье =0 или =7)\r\n| | | ------- Месяц (1 - 12)\r\n| | --------- День (1 - 31)\r\n| ----------- Час (0 - 23)\r\n------------- Минута (0 - 59)', '', '', '', 1506001993, 0, 0, 2, 1506001993, 2, 1507725682, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', 0, 0, 0, '0', '', '', '', 0, 0, '0', ''),
(5, '2017-09-28 21:20:59', 1, 100, 0, '', 1, 301, 305, 0, 'Таймер', 'Timer', '', '', 0, 'Это робот таймер.\r\nОн выводит строки времени в лог.\r\nНужен для тестирования работы системы.', 'It is timer robot.\r\nIt print time string to log.', '', '', 1506619259, 0, 0, 2, 1506619259, 2, 1521556072, '127.0.0.1', 'Администратор', '{\"script\":\"php start_robot.php robot=timer proc=5 rsid=143b8b0a4d0a997d85c9cd19c462ec3a\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p5_1.txt\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"output.txt\"}}}', 0, '', 7, '', 0, 0, 0, '', 'stopped', 'In 2018-03-20 17:27:52', '', 0, 0, 'service', ''),
(6, '2017-10-03 23:44:28', 1, 100, 0, '', 1, 301, 305, 0, 'Тест крона', 'Cron test robot', '', '', 0, 'Запускается по крону в каждый запуск оболочки, служит для теста оболочки', '', '', '', 1507059868, 0, 0, 2, 1507059868, 2, 1519655971, '127.0.0.1', 'Администратор', '{\"crmin\":\"*\",\"crhour\":\"*\",\"crday\":\"*\",\"crmonth\":\"*\",\"crweek\":\"*\",\"script\":\"php start_robot.php robot=crontest proc=6 rsid=3fdf4d535915584b327f70598dac6c0f\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p6_1.txt\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"\\u0437\\u0430\\u043f\\u0440\\u0435\\u0449\\u0435\\u043d\\u043d\\u044b\\u0435 \\u043a \\u044f\\u043d\\u0434\\u0435\\u043a\\u0441\\u0443 \\u0442\\u043e\\u0432\\u0430\\u0440\\u044b.txt\",\"size\":{\"kb\":19},\"edituser\":\"2\",\"editdate\":1507117819,\"upldate\":1507117819,\"editip\":\"127.0.0.1\",\"kb\":19}}}', 0, '', 8, '', 0, 0, 0, '0', '', '', '', 0, 1, 'service', ''),
(7, '2017-10-04 12:26:51', 1, 100, 0, '', 1, 301, 305, 0, 'Запуск кроновых скриптов', 'Start cron scripts', '', '', 0, 'Запускает кроновые скрипты', '', '', '', 1507105611, 0, 0, 2, 1507105611, 2, 1519218170, '127.0.0.1', 'Администратор', '{\"script\":\"php start_robot.php robot=startcron proc=7 rsid=60323eeefdbcbca15d1e5d77b1dbb313\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p7_1.txt\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"\\u0421\\u0442\\u0430\\u0442\\u0438\\u0441\\u0442\\u0438\\u043a\\u0430 \\u043f\\u043e \\u0432\\u044b\\u0442\\u044f\\u0436\\u043a\\u0430\\u043c.txt\",\"size\":{\"kb\":3},\"edituser\":\"2\",\"editdate\":1507119057,\"upldate\":1507119057,\"editip\":\"127.0.0.1\",\"kb\":3}}}', 0, '', 9, '', 0, 0, 0, '', '', '', '', 0, 0, 'service', ''),
(8, '2017-10-04 17:20:51', 1, 100, 0, '', 1, 301, 305, 0, 'Мониторинг активных роботов', 'Robots run monitor', '', '', 0, '', '', '', '', 1507123251, 0, 0, 2, 1507123251, 2, 1519742906, '127.0.0.1', 'Администратор', '{\"script\":\"php start_robot.php robot=robotsmonitor proc=8 rsid=4a100e66a2ec259303b3048c5515e331\",\"output\":\"\\/dev\\/null\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"output.txt\"}}}', 0, '', 10, '', 0, 0, 0, '', 'working', 'Restart in 2018-03-10 12:25:03', '4a100e66a2ec259303b3048c5515e331', 1491, 0, 'service', ''),
(42, '2018-02-21 16:04:50', 1, 100, 0, '', 1, 301, 305, 0, 'Рестарт умерших скриптов', 'Died scripts restart', '', '', 0, 'Некромант, оживляющий демонов)))', '', '', '', 1519218290, 0, 0, 2, 1519218290, 2, 1521585087, '127.0.0.1', 'Администратор', '{\"crmin\":\"*\",\"crhour\":\"*\",\"crday\":\"*\",\"crmonth\":\"*\",\"crweek\":\"*\",\"script\":\"php start_robot.php robot=robotsrestart proc=42 rsid=bd188f270e27cbcbde6b22d4839c6f6b\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p42_1.txt\",\"always\":1}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"output.txt\"},\"2\":{\"type\":\"txt\",\"fname\":\"log.txt\"}}}', 0, '', 19, '', 0, 0, 0, '0', '', '', '', 0, 1, 'service', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_site`
--

DROP TABLE IF EXISTS `mnbv_site`;
CREATE TABLE `mnbv_site` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_site`
--

INSERT INTO `mnbv_site` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-08 12:49:06', 0, 100, 1, '', 1, 0, 102, 0, 'Демо сайт MNBV', 'MNBV demonstration site', '', '', 0, 'Главная страница сайта', '', '<p>{{img-right:1}}Добро пожайловать на демонстрационную версию сайта компании. Она включает основные элементы, которые необходимы полноценному информационному ресурсу, а именно:</p>\r\n<ul>\r\n<li>структуру статических страниц,</li>\r\n<li>новости и статьи,</li>\r\n<li>каталог товаров,</li>\r\n<li>контакты с формой обратной связи,</li>\r\n<li>баннерная система,</li>\r\n<li>авторизация, личный кабинет пользователя,&nbsp;</li>\r\n<li>система скидок для каталога товаров,</li>\r\n<li>система обработки событий (нужна для установки счетчиков и др. скриптов партнерских программ),</li>\r\n<li>систему выгрузки товарных фидов различных видов,</li>\r\n<li>систему управления контентом,</li>\r\n<li>система загрузки и синхронизации данных в хранилищах</li>\r\n<li>система автоматического формирования каталогов, свойств товара и при необходимости группировки их значений из XML фида с параметрами товара.</li>\r\n</ul>\r\n<p>Вы можете подключить любой выбранный вами шаблон дизайна и использовать несколько вариантов шаблонов дизайна одновременно, переключаясь между ними.</p>\r\n<p>Система поддерживает работу с несколькими сайтами, а также позволяет подключать разные варианты шаблонов отображения на разные доменные имена.</p>\r\n<p>{{att:1}} - описание дизельного котла</p>', '<p>{{img-right:1}}Hello! We are glad to sea you in this Demo Site!</p>\r\n<p>It cotsists of:</p>\r\n<ul>\r\n<li>structure of static pages,</li>\r\n<li>structure of news and articles,</li>\r\n<li>product catalog,</li>\r\n<li>contacts whith feedback &nbsp;form,</li>\r\n<li>banners system,</li>\r\n<li>user login and personal account,&nbsp;</li>\r\n<li>discount system,</li>\r\n<li>events system,</li>\r\n<li>feeds generator,</li>\r\n<li>CMS,</li>\r\n<li>storage uploader</li>\r\n<li>catalog autocomplite.</li>\r\n</ul>\r\n<p>Select template and connect it to system.</p>\r\n<p>You can work whith&nbsp;multiple sites.</p>\r\n<p>{{att:1}} - Document.</p>', 1502182140, 0, 0, 2, 1502182146, 2, 1504094703, '127.0.0.1', 'Администратор', '{\"script\":\"mainpage\",\"tpl_file\":\"index.php\"}', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":156,\"w\":551,\"h\":600,\"min\":{\"kb\":9,\"w\":91,\"h\":100},\"big\":{\"kb\":123,\"w\":555,\"h\":604}},\"type\":\"jpg\",\"fname\":\"smile.jpg\",\"edituser\":\"2\",\"editdate\":1503601442,\"upldate\":1503220297,\"editip\":\"127.0.0.1\",\"name\":\"\\u041b\\u043e\\u0433\\u043e \\u0441\\u0430\\u0439\\u0442\\u0430\"},\"2\":{\"url\":\"https:\\/\\/youtu.be\\/xLDM32xJ6iY\",\"type\":null,\"edituser\":\"2\",\"editdate\":1503601442,\"editip\":\"127.0.0.1\"},\"3\":{\"url\":\"https:\\/\\/icdn.lenta.ru\\/images\\/2017\\/08\\/22\\/09\\/20170822095723613\\/pic_305c99237e3ab4c9f48b99909ab46156.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1503601442,\"editip\":\"127.0.0.1\",\"link\":\"http:\\/\\/yandex.ru\",\"name\":\"\\u041f\\u0435\\u0440\\u0435\\u0445\\u043e\\u0434 \\u043d\\u0430 \\u0441\\u0430\\u0439\\u0442\\u0430 \\u042f\\u043d\\u0434\\u0435\\u043a\\u0441\\u0430\"}},\"att\":{\"1\":{\"type\":\"pdf\",\"fname\":\"Pasport_Turbo.pdf\",\"size\":{\"kb\":1091},\"edituser\":\"2\",\"editdate\":1503601442,\"upldate\":1503442319,\"editip\":\"127.0.0.1\",\"kb\":1091}}}', 0, ''),
(2, '2017-08-08 12:49:42', 1, 100, 0, '', 1, 0, 102, 0, 'О компании', 'About', 'about', '', 0, 'Информация о компании.', 'Put the information about your company here.', '<p>Здесь вы можете разместить информацию о вашей компании. Воспользуйтесь удобным текстовым и графическим редакторами для наполнения&nbsp; страниц.</p>', '<p>Put the information about your company here. It may be text, images or another&nbsp;attentions. You can use text or grafical editor.</p>', 1502182140, 0, 0, 2, 1502182182, 2, 1521286688, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(3, '2017-08-08 12:49:51', 1, 100, 0, '', 1, 0, 102, 0, 'Статьи', 'Articles', 'articles', '', 0, '', 'The articles list of the company.', '', '<p>The articles list of the company.</p>', 1502182140, 0, 0, 2, 1502182191, 2, 1504012101, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"list_sort\":\"date_desc\",\"script_storage\":\"articles\",\"script_folder\":\"1\",\"list_max_items\":2}', '', '', '', '', '', 0, ''),
(4, '2017-08-08 12:50:05', 1, 100, 0, '', 1, 0, 102, 0, 'Новости', 'News', 'news', '', 0, 'Новинки компании - будте всегда в курсе!', 'The news list of the company. ', '<p>Новинки компании - будте всегда в курсе!</p>', '<p>The news list of the company.&nbsp;</p>', 1502182200, 0, 0, 2, 1502182205, 2, 1504004650, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"script_storage\":\"news\",\"script_folder\":\"1\",\"list_max_items\":2,\"list_sort\":\"date_desc\"}', '', '', '', '', '', 0, ''),
(5, '2017-08-08 12:50:13', 1, 100, 0, '', 1, 0, 102, 0, 'Каталог', 'Catalog', 'catalog', '', 0, 'Каталог товаров, реализуемых компанией - найдите что-то полезное для себя!', 'Product catalog page.', '<p>Каталог товаров, реализуемых компанией - найдите что-то полезное для себя!</p>', '<p>Product catalog here.</p>', 1502182200, 0, 0, 2, 1502182213, 2, 1504012091, '127.0.0.1', 'Администратор', '{\"script\":\"products\",\"script_storage\":\"products\",\"script_folder\":\"1\",\"list_max_items\":2}', '', '', '', '', '', 0, ''),
(6, '2017-08-08 12:50:33', 1, 100, 0, '', 1, 0, 102, 0, 'Контакты', 'Contacts', 'contacts', '', 0, 'Контактная информация компании и форма обратной связи.', 'Contacts whith feedback  form.', '<p>Контакты для связи:</p>\r\n<ul>\r\n<li>Адрес ...,</li>\r\n<li>Телефон ...,</li>\r\n<li>E-mail ...,</li>\r\n<li>Skype ...</li>\r\n</ul>\r\n<p>Или оставьте сообщение ниже в форме обратной связи:</p>', '<p>Contacts:</p>\r\n<ul>\r\n<li>Address ...,</li>\r\n<li>Phone ...,</li>\r\n<li>E-mail ...,</li>\r\n<li>Skype ...</li>\r\n</ul>\r\n<p>You can send us the message by the feedback &nbsp;form on bottom.</p>', 1502182200, 0, 0, 2, 1502182233, 2, 1504212227, '127.0.0.1', 'Администратор', '{\"script\":\"contacts\",\"script_storage\":\"messages\",\"script_folder\":\"2\"}', '', '', '', '', '', 0, ''),
(7, '2017-08-08 12:52:12', 1, 100, 0, '', 1, 0, 102, 0, 'Авторизация', 'Login', 'auth', '', 0, 'Авторизация.', 'User ligin.', '', '', 1502182320, 0, 0, 2, 1502182332, 2, 1503590846, '127.0.0.1', 'Администратор', '{\"script\":\"auth\"}', '', '', '', '', '', 0, ''),
(8, '2017-08-24 23:04:47', 1, 100, 1, '', 1, 0, 102, 0, 'Раздел сайта', 'Site folder', 'sitefolder', '', 0, '', '', '<p>Описание папки</p>', '', 1503601440, 0, 0, 2, 1503601487, 2, 1503904025, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"site_tpl\":\"main\"}', '', '', '', '[\"1\"]', '', 0, ''),
(9, '2017-08-24 23:05:03', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 1 раздела сайта', 'Page1', 'folder_pg1', '', 0, 'Описание 1 страницы раздела', 'about pg1', '', '', 1503601500, 0, 0, 2, 1503601503, 2, 1503818289, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"size\":{\"kb\":168,\"w\":600,\"h\":399,\"min\":{\"kb\":8,\"w\":100,\"h\":66},\"big\":{\"kb\":233,\"w\":850,\"h\":566}},\"type\":\"jpg\",\"fname\":\"original.jpg\",\"edituser\":\"2\",\"editdate\":1503688333,\"upldate\":1503688333,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(10, '2017-08-24 23:05:11', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 2 раздела сайта', 'Page2', 'folder_pg2', '', 0, 'Описание 2 страницы раздела', 'about pg2', '', '', 1503601560, 0, 0, 2, 1503601511, 2, 1503752773, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/icdn.lenta.ru\\/images\\/2017\\/08\\/25\\/21\\/20170825214257584\\/pic_abb27da63dffc6fb1e6988663e41dd45.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1503688407,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(11, '2017-08-24 23:05:19', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 3 раздела сайта', 'Page3', '', '', 0, '', '', '<p>{{img-right:1}}</p>', '', 1503601620, 0, 0, 2, 1503601519, 2, 1503752778, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/xLDM32xJ6iY\",\"type\":null,\"edituser\":\"2\",\"editdate\":1503698049,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(12, '2017-08-25 23:24:56', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 4 раздела сайта', 'Page4', '', '', 0, '', '', '', '', 1503688080, 0, 0, 2, 1503689096, 2, 1503845817, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(14, '2017-09-02 21:27:25', 1, 100, 0, '', 1, 0, 102, 0, 'Корзина', 'Cart', 'cart', '', 0, '', '', '', '', 1504373220, 0, 0, 2, 1504373245, 2, 1504373350, '127.0.0.1', 'Администратор', '{\"script\":\"cart\",\"script_folder\":\"1\"}', '', '', '', '', '', 0, ''),
(15, '2017-09-16 00:05:17', 1, 100, 0, '', 1, 0, 102, 0, 'Акции', 'Actions', 'actions', '', 0, '', '', '<p>Наши акции тут:</p>', '<p>Our actions is here:</p>', 1505505900, 0, 0, 2, 1505505917, 2, 1505506336, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"script_storage\":\"actions\",\"script_folder\":\"1\",\"list_sort\":\"pozid\"}', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_sites`
--

DROP TABLE IF EXISTS `mnbv_sites`;
CREATE TABLE `mnbv_sites` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `fullurl` int(1) NOT NULL DEFAULT '0',
  `domain` varchar(255) NOT NULL,
  `maindomain` varchar(255) NOT NULL,
  `cookiedomain` varchar(255) NOT NULL,
  `protocol` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `counters_arr` text NOT NULL,
  `storage` varchar(255) NOT NULL,
  `startid` int(11) NOT NULL,
  `canonical` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `amp_site` varchar(255) NOT NULL,
  `filesdomain` varchar(255) NOT NULL,
  `sorturl` int(1) NOT NULL DEFAULT '0',
  `pginurl` int(1) NOT NULL DEFAULT '0',
  `noindex` int(1) NOT NULL,
  `module` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_sites`
--

INSERT INTO `mnbv_sites` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `fullurl`, `domain`, `maindomain`, `cookiedomain`, `protocol`, `template`, `counters_arr`, `storage`, `startid`, `canonical`, `mobile`, `amp_site`, `filesdomain`, `sorturl`, `pginurl`, `noindex`, `module`) VALUES
(1, '2017-08-02 14:05:23', 0, 100, 1, '', 1, 0, 2, 0, 'Сайты', 'Sites', '', '', 0, '', '', '', '', 1501668323, 0, 0, 2, 1501668323, 2, 1501669023, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, ''),
(2, '2017-08-02 14:05:38', 1, 100, 0, '', 1, 0, 2, 1, 'Сайт по-умолчанию', 'Default site', '', '', 0, '', '', '', '', 1501668300, 0, 0, 2, 1501668338, 2, 1521584097, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, 'www.mnbv.loc', 'mnbv.loc', 'mnbv.loc', '0', 'defsite', '', 'site', 1, 'http://www.mnbv.loc', '', '', '', 1, 1, 0, ''),
(3, '2017-08-03 18:04:46', 1, 100, 3, '2', 0, 0, 2, 0, 'Демо версия сайта', 'Demo site', '', '', 0, '', '', '', '', 1501769040, 0, 0, 2, 1501769086, 2, 1521584060, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, 'www.rab.loc', 'rab.loc', 'rab.loc', '0', 'defsite', '', 'site', 1, '', '', '', '', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_sysusers`
--

DROP TABLE IF EXISTS `mnbv_sysusers`;
CREATE TABLE `mnbv_sysusers` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(255) NOT NULL DEFAULT '',
  `passwd` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_sysusers`
--

INSERT INTO `mnbv_sysusers` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `email`, `login`, `passwd`, `phone`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 110, 110, 0, 'Системные пользователи', 'System users', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280461, 2, 1504619715, '127.0.0.1', 'Администратор', '', '', '', '', '', '', '', '', '', '', 0, ''),
(2, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 110, 110, 0, 'Администратор', 'Administrator', '', 'Главный администратор системы', 0, '', '', '<p>Описание админа</p>', '', 0, 0, 0, 2, 1481283239, 2, 1505898815, '127.0.0.1', 'Администратор', '{\"fio\":\"\\u0414\\u0435\\u043c\\u043e \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u044c\",\"addr\":\"\\u041e\\u0444\\u0444\\u0438\\u0441\",\"position\":\"Demo\",\"access\":\"[\\\"4\\\"]\",\"permissions\":\"[\\\"4\\\"]\",\"tplwidth\":1,\"iflang\":\"ru\",\"discount\":\"2\"}', '', '', '', '', 'test@test.ru', 'admin', 'e262f8a127be0dfd3c6a3651dc21148e', '', '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 0, '', 0, 110, 110, 0, 'Демо пользователь', 'Demo', '', 'Демо пользователь', 0, '', '', '<p>Опис</p>', '', 0, 0, 0, 2, 1481283301, 2, 1505898795, '127.0.0.1', 'Администратор', '{\"fio\":\"\\u0414\\u0435\\u043c\\u043e \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u044c\",\"addr\":\"\\u041e\\u0444\\u0444\\u0438\\u0441\",\"position\":\"Demo\",\"access\":\"[\\\"4\\\"]\",\"permissions\":\"[\\\"4\\\"]\",\"tplwidth\":1,\"iflang\":\"ru\",\"discount\":\"2\"}', '', '', '', '', '', 'demo', 'fb98a17d9eb8bfa3b2e9431c594bb732', '', '', 0, ''),
(4, '0000-00-00 00:00:00', 1, 100, 0, '', 0, 110, 110, 0, 'Пользователь сайта', 'Site user', '', 'Самозарегистрированные пользователи', 0, '', '', '', '', 0, 0, 0, 2, 1481283314, 2, 1518714857, '127.0.0.1', 'Администратор', '{\"fio\":\"\\u0421\\u0430\\u043c\\u043e\\u0437\\u0430\\u0440\\u0435\\u0433\\u0438\\u0441\\u0442\\u0440\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u043d\\u044b\\u0439 \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u044c\",\"access\":\"[\\\"3\\\"]\",\"permissions\":\"[\\\"3\\\"]\",\"tplwidth\":1,\"iflang\":\"ru\"}', '', '', '', '', '', '', '', '', '', 0, ''),
(5, '0000-00-00 00:00:00', 1, 100, 0, '', 0, 110, 110, 0, 'Админ Английский', 'EnglAdmin', '', '', 0, '', '', '<p>Админ Английский</p>', '<p>EnglAdmin</p>', 0, 0, 0, 2, 1481293254, 2, 1505898801, '127.0.0.1', 'Администратор', '{\"fio\":\"EnglAdmin\",\"lang\":1,\"root\":1,\"iflang\":\"eng\",\"tplwidth\":980,\"tablerows\":7}', '', '', '', '', '', 'eadmin', '1f4ca71c5b3b2be902a5ed34e61ec4d7', '', '', 0, ''),
(6, '0000-00-00 00:00:00', 1, 100, 0, '', 0, 110, 110, 0, 'Контент менеджер', 'Content Manager', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481719045, 2, 1505898803, '127.0.0.1', 'Администратор', '{\"fio\":\"Content manager\",\"permissions\":\"[\\\"101\\\",\\\"102\\\",\\\"105\\\",\\\"106\\\",\\\"200\\\"]\",\"iflang\":\"ru\",\"tplwidth\":1}', '', '', '', '', '', 'content', '9a0364b9e99bb480dd25e1f0284c8555', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_tags`
--

DROP TABLE IF EXISTS `mnbv_tags`;
CREATE TABLE `mnbv_tags` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `storage` varchar(20) NOT NULL,
  `objid` int(11) NOT NULL,
  `objtype` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_tags`
--

INSERT INTO `mnbv_tags` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `storage`, `objid`, `objtype`) VALUES
(1, '2017-08-02 14:16:28', 0, 100, 1, '', 1, 0, 2, 0, 'Тэги', 'Tags', '', '', 0, '', '', '', '', 1501668988, 0, 0, 2, 1501668988, 2, 1501669013, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '', 0, 0),
(2, '2017-08-02 14:29:10', 1, 100, 0, '', 1, 0, 2, 0, 'главная, main', '', '', '', 0, '', '', 'главн, main, cайт, site', '', 1501669740, 0, 0, 2, 1501669750, 2, 1502104054, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 'main', 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_templates`
--

DROP TABLE IF EXISTS `mnbv_templates`;
CREATE TABLE `mnbv_templates` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_templates`
--

INSERT INTO `mnbv_templates` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-03 18:29:21', 0, 100, 1, '', 1, 0, 2, 0, 'Шаблоны', 'Templates', '', '', 0, '', '', '', '', 1501770540, 0, 0, 2, 1501770561, 2, 1501771168, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(2, '2017-08-03 18:32:33', 1, 100, 0, '', 1, 0, 2, 0, 'Шаблон по-умолчанию', 'Default template', 'default', '', 0, '', '', '', '', 1501770720, 0, 0, 2, 1501770753, 2, 1502962382, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(3, '2017-08-03 18:32:41', 1, 100, 0, '', 1, 0, 2, 0, 'Демо шаблон', 'Demo template', 'demo', '', 0, '', '', '', '', 1501770720, 0, 0, 2, 1501770761, 2, 1501770846, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(4, '2017-08-03 18:33:08', 1, 100, 0, '', 1, 0, 2, 0, 'AMP шаблон', 'AMP template', 'amp', '', 0, '', '', '', '', 1501770780, 0, 0, 2, 1501770788, 2, 1501770856, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_tickets`
--

DROP TABLE IF EXISTS `mnbv_tickets`;
CREATE TABLE `mnbv_tickets` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_tickets`
--

INSERT INTO `mnbv_tickets` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(7, '0000-00-00 00:00:00', 0, 1, 1, '', 1, 0, 200, 0, 'Задачи', 'Tickets', '', '', 0, '', '', '', '', 0, 0, 0, 0, 0, 2, 1502182047, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(31, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Создание панели просмотра объектов (список и объекты) ', '', 'sozdanie-paneli-prosmotra-ob-ektov', '', 0, '', '', '<p>Создать панель в которой можно было бы просматривать заданный объект сайта.</p>', '', 0, 0, 0, 2, 1481356605, 2, 1501500913, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(32, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Вывод каталога товаров (категория и товар)', '', 'sozdanie-paneli-prosmotra-spiska-ob-ekta', '', 0, '', '', '<p>Создать панель в которой можно было бы смотреть список объектов заданного раздела сайта</p>', '', 0, 0, 0, 2, 1481356632, 2, 1501500909, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(33, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Создание внутреннего индекса атрибутов для фильтрации в виде MySQL таблицы', '', 'sozdanie-vnutrennego-indeksa-atributov', '', 0, '', '', '<p>Создать индекс для фильтрации, включающий внутренние атрибуты объектов</p>', '', 0, 0, 0, 2, 1481358211, 2, 1501500839, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(34, '0000-00-00 00:00:00', 36, 180, 0, '', 1, 0, 102, 0, 'Создание настраиваемой формы фильтров для списков', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481358248, 2, 1501497175, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(36, '0000-00-00 00:00:00', 7, 10, 1, '', 1, 0, 102, 0, 'Надо сделать', '', 'nado-sdelat', '', 0, '', '', '', '', 0, 0, 0, 2, 1501496978, 2, 1502182061, '127.0.0.1', 'Администратор', '', '', '', '', '[\"7\"]', '', 0, ''),
(39, '0000-00-00 00:00:00', 50, 100, 0, '', 1, 0, 102, 0, 'Выделения функционала в модули', '', '', '', 0, '', '', '<p>В системе функционал можно выделять как модуль, так и реализовывать в рамках какого-то иного модуля как например Интранет, сайт и т.п.</p>\r\n<p>Базовые модули мы выделяем отдельно.</p>\r\n<p><strong>Базовые модули</strong>:</p>\r\n<ul>\r\n<li>core - ядро системы</li>\r\n<li>mnbv - основной модуль CMS MNBV, содержащий основные библиотеки</li>\r\n<li>api - модуль API системы MNBV</li>\r\n<li>sdata - модуль вывода статики с контролем доступа /sdata/...</li>\r\n<li>imgeditor - графический редактор</li>\r\n<li>intranet - модуль авторизации, управления хранилищами и др. базовые функции</li>\r\n<li>site - модуль вывода сайта (фронтенд части)</li>\r\n</ul>\r\n<p><strong>Контроллеры в рамках модуля сайт</strong>:</p>\r\n<ul>\r\n<li>auth - авторизация</li>\r\n<li>list - вывод списка раздела</li>\r\n<li>pg - вывод страницы</li>\r\n<li>photos - вывод фотоальбома</li>\r\n<li>contacts - вывод формы контактов</li>\r\n<li>catalog - каталог товаров</li>\r\n<li>news - новости</li>\r\n<li>articles - статьи</li>\r\n<li>links - полезные ссылки со структурой ссылкой и описанием</li>\r\n</ul>', '', 0, 0, 0, 2, 1501498242, 2, 1501502372, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(40, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Баннерная система', '', '', '', 0, '', '', '<ul>\r\n<li>Есть хранилище, содержащее сами баннеры со всей приложенной к ним статикой, линками, тегами, настройками и т.п.&nbsp;</li>\r\n<li>Баннеры в хранилище баннеров могут группироваться в разделы, в таком случае раздел будет цепочкой баннеров,&nbsp;</li>\r\n<li>Есть хранилище, содержащее статистику по открытию и кликам по баннеров</li>\r\n<li>В шаблонах и при настройке страниц (массив баннеров в attr) могут выбираться как баннеры так и цепочки баннеров.</li>\r\n</ul>\r\n<p>Есть понятие типа баннера, могут быть:</p>\r\n<ol>\r\n<li>цепочка баннеров,</li>\r\n<li>случайное отображение баннеров по тегам (базовым нормализованным ключевым словам),</li>\r\n<li>изображение,</li>\r\n<li>слайдер изображений,</li>\r\n<li>ютуб,</li>\r\n<li>флеш,</li>\r\n<li>произвольный HTML код.</li>\r\n</ol>\r\n<p>&nbsp;</p>', '', 0, 0, 0, 2, 1501499407, 2, 1501502348, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(41, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Система обработки событий', '', '', '', 0, '', '', '<p>Система запуска скриптов по событиям</p>', '', 0, 0, 0, 2, 1501500508, 2, 1501500528, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(42, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Система генерации выгрузок в разных форматах', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501500542, 2, 1501500542, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(43, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Система загрузки информации из разных форматов', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501500556, 2, 1501500556, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(44, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Система запуска скриптов по расписанию', '', '', '', 0, '', '', '<p>Система запуска скриптов по расписанию с учетом имени текущего сервера из реестра имен серверов.&nbsp;</p>\r\n<p>Функционал:</p>\r\n<ul>\r\n<li>запуск&nbsp;</li>\r\n<li>логирование исполнения</li>\r\n<li>управление настройками и вариантами запуска</li>\r\n</ul>', '', 0, 0, 0, 2, 1501500619, 2, 1501500703, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(45, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Система выдачи фидов на базе api', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501500714, 2, 1501500714, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(46, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Система распознавания имен и пола людей на базе API + автокомплит', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501500750, 2, 1503316072, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(47, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'КЛАДР + автокомплит', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501500787, 2, 1503314796, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(48, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Поиск в отдельном окне средствами js как сделано на zara.com', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501500806, 2, 1501500806, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(50, '0000-00-00 00:00:00', 7, 20, 1, '', 1, 0, 102, 0, 'Общие принципы', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501502366, 2, 1501502385, '127.0.0.1', 'Администратор', '', '', '', '', '[\"7\"]', '', 0, ''),
(51, '0000-00-00 00:00:00', 7, 100, 1, '', 1, 0, 102, 0, 'Сделано', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501502505, 2, 1501502505, '127.0.0.1', 'Администратор', '', '', '', '', '[\"7\"]', '', 0, ''),
(52, '0000-00-00 00:00:00', 36, 100, 0, '', 1, 0, 102, 0, 'Работа с хранилищем - дамп базы, если это мускул.', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501502544, 2, 1503311755, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(53, '0000-00-00 00:00:00', 7, 100, 0, '', 1, 0, 102, 0, 'Шаблоны bootstrap', '', '', '', 0, '', '', '<p>{{img-left:1}}Полезные ссылки:</p>\r\n<ol>\r\n<li><a href=\"http://mybootstrap.ru/\">http://mybootstrap.ru/</a>&nbsp;</li>\r\n<li><a href=\"http://ktonanovenkogo.ru/html/bootstrap/bootstrap-3-otzyvchivyj-frejmvork-sozdaniya-dizajna-sajtov.html\">http://ktonanovenkogo.ru/html/bootstrap/bootstrap-3-otzyvchivyj-frejmvork-sozdaniya-dizajna-sajtov.html</a>&nbsp;</li>\r\n<li><a href=\"https://habrahabr.ru/post/156425/\">https://habrahabr.ru/post/156425/</a>&nbsp;- сравнение</li>\r\n<li><a href=\"https://www.keycdn.com/blog/bootstrap-vs-foundation/\">https://www.keycdn.com/blog/bootstrap-vs-foundation/</a>&nbsp;- сравнение</li>\r\n<li><a href=\"https://webformyself.com/category/premium/framework-premium/bootstrappremium/\">https://webformyself.com/category/premium/framework-premium/bootstrappremium/</a>&nbsp;- видеоуроки</li>\r\n<li><a href=\"https://www.youtube.com/watch?v=siJoY2hzqqM\">https://www.youtube.com/watch?v=siJoY2hzqqM</a>&nbsp;- сравнение видео</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p>Ссылки по уроку:</p>\r\n<ul>\r\n<li><a href=\"https://www.youtube.com/watch?v=46q2eB7xvXA\">https://www.youtube.com/watch?v=46q2eB7xvXA</a></li>\r\n<li><a href=\"http://getbootstrap.com/getting-started/\">http://getbootstrap.com/getting-started/</a>&nbsp;</li>\r\n<li><a href=\"http://fontawesome.io/\">http://fontawesome.io/</a>&nbsp;</li>\r\n<li><a href=\"https://fonts.google.com/\">https://fonts.google.com/</a></li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>{{img-right:2}}Бесплатные шаблоны для бутстрапа:</p>\r\n<ul>\r\n<li><a href=\"http://seo-design.net/templates/free-responsive-bootstrap-html-templates\">http://seo-design.net/templates/free-responsive-bootstrap-html-templates</a>&nbsp;</li>\r\n<li><a href=\"http://bootstraptema.ru/stuff/templates_bootstrap/1\">http://bootstraptema.ru/stuff/templates_bootstrap/1</a>&nbsp;</li>\r\n<li><a href=\"http://beloweb.ru/shablonyi/luchshie-i-besplatnyie-bootstrap-shablonyi.html\">http://beloweb.ru/shablonyi/luchshie-i-besplatnyie-bootstrap-shablonyi.html</a>&nbsp;</li>\r\n<li><a href=\"http://internet-pages.blogspot.ru/2015/08/50-bootstrap-html.html\">http://internet-pages.blogspot.ru/2015/08/50-bootstrap-html.html</a>&nbsp;</li>\r\n<li><a href=\"https://ruseller.com/lessons.php?rub=1&amp;id=2392\">https://ruseller.com/lessons.php?rub=1&amp;id=2392</a>&nbsp;</li>\r\n<li><a href=\"http://bayguzin.ru/main/shablonyi/shablonyi-dlya-biznesa/beetle.html\">http://bayguzin.ru/main/shablonyi/shablonyi-dlya-biznesa/beetle.html</a>&nbsp;</li>\r\n<li><a href=\"http://bootstrap-v4.ru/examples/\">http://bootstrap-v4.ru/examples/</a>&nbsp;</li>\r\n<li><a href=\"http://bootstraptema.ru/stuff/templates_bootstrap/\">http://bootstraptema.ru/stuff/templates_bootstrap/</a></li>\r\n<li><a href=\"http://ofitsialniy-sait.ru/e-shop\">http://ofitsialniy-sait.ru/e-shop</a>&nbsp;</li>\r\n<li><a href=\"http://design-secrets.ru/44-besplatnyx-adaptivnyx-html5-shablonov.html\">http://design-secrets.ru/44-besplatnyx-adaptivnyx-html5-shablonov.html</a>&nbsp;</li>\r\n</ul>\r\n<p>Шаблоны интернет-магазинов:</p>\r\n<ul>\r\n<li><a href=\"http://bootstraptema.ru/stuff/templates_bootstrap/shop/7-1\">http://bootstraptema.ru/stuff/templates_bootstrap/shop/7-1</a>&nbsp;</li>\r\n<li><a href=\"https://p.w3layouts.com/demos/mattress/web/\">https://p.w3layouts.com/demos/mattress/web/</a>&nbsp;</li>\r\n<li><a href=\"http://ofitsialniy-sait.ru/template/e_shop-web/contact.html\">http://ofitsialniy-sait.ru/template/e_shop-web/contact.html</a>&nbsp; - прикольный шаблон</li>\r\n<li><a href=\"http://ofitsialniy-sait.ru/templates-bootstrap\">http://ofitsialniy-sait.ru/templates-bootstrap</a>&nbsp;&nbsp; - и много разных других шаблонов бесплатно</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>Особенно понравились:</p>\r\n<ul>\r\n<li><a href=\"http://ofitsialniy-sait.ru/templates-bootstrap\">http://ofitsialniy-sait.ru/templates-bootstrap</a>&nbsp;</li>\r\n</ul>\r\n<p>&nbsp;{{img:3}}</p>\r\n<p>&nbsp;</p>', '', 0, 0, 0, 2, 1501577876, 2, 1502180711, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(55, '0000-00-00 00:00:00', 7, 100, 0, '', 1, 0, 102, 0, 'Косяки', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501583255, 2, 1501598348, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(56, '2017-08-02 11:42:12', 7, 100, 0, '', 1, 0, 102, 0, 'В работе', '', '', '', 0, '', '', '<p><strong>Доработки по админке:</strong></p>\r\n<ul>\r\n<li>добавить ко всем объектам теги (доп поле строковое, теги через запятую), при этом система должна хранить нормализованные теги + те что заводили пользователи. Вдальнейшем теги будут участвовать в поиске и рекомендательной системе. В строке тегов в нормализованном виде также должны храниться сгенерированные из названия теги. Они ставятся вначале.&nbsp;</li>\r\n<li>добавить ко всем объектам идентификатор сайта (если не задан, то объект отображается на всех сайтах) и отдельное хранилище с этими идентификаторами и сведениями по ним. В режиме администратора пользователь может выбрать данные по всем сайтам он видит или только по конкретному.&nbsp;</li>\r\n<li>при создании объекта он наследует настройки сайта и маркер отображения у родительской папки.</li>\r\n<li>сделать панель текущих настроек сессии в режими работы админки (вывод логов для тех кто имеет право их смотреть, переключатель текущего сайта или показ всех сайтов). Данные из панели хранятся в текущей сессии.</li>\r\n<li>В хранилище сайтов должны содержаться сведения: <br />+ id, <br />+ домен, <br />+ Название сайта, <br />+ Иконка сайта (лого), <br />- protocol - дефолтовый протокол (http|https|universal Если не задано, то universal (//)),&nbsp;<br />- counters_arr - массив с идентификаторами счетчиков разного рода и их настройками (в виде текстового блока в json), <br />- template - шаблон дизайна (из хранилища шаблонов)</li>\r\n<li>Сделать хранилище шаблонов дизайна (размещаются в модуле site):<br />+ id<br />+ Название<br />+ Алиас<br />+ Краткое описание<br />+ Полное описание, если надо рассказать о каких-то подробностях шаблона<br />+ тип объекта<br />+ превьюшка<br />+ архив с файлами шаблона, который при необходимости можно развернуть в файловой системе<br />+ версия&nbsp;(для обновления если придется в комменте)</li>\r\n<li>\r\n<p>В хранилище тегов надо:<br />+ id<br />+ storage - хранилище <br />+ objid - объект<br />+ тип объекта<br />+ название - список тегов объекта (как в объекте)<br />+ text - нормализованный список тегов объекта, разделенный запятыми<br />+ сайт</p>\r\n</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>Создание сайта:</strong></p>\r\n<ul>\r\n<li>Создать шаблон вывода страницы из корневого раздела с автозаменой {{}}</li>\r\n<li>Разработать систему подключения дополнительных контроллеров с view (хранение с версией, управление, возможность загрузить) при этом в рамках применения конкретного контроллера ему могут соответствовать разные view (к примеру вывод страницы и списка из неосновного хранилища для Новостей, Статей и т.п.).</li>\r\n<li>Разработать систему подключения виджетов c view (хранение с версией, управление, возможность загрузить)</li>\r\n<li>Сделать форму обратной связи с отправкой сообщений в хранилище входных данных. Далее уже будет отдельно сделан перенос этих данных в задачи. Таким образом мы изолируем хранилище с входными данными и делаем возможность разделить фронтенды и бекенды. Отдельно будет реализован механизм чистки хранилища входных данных.</li>\r\n<li>баннерная система</li>\r\n<li>событийная система</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>Схема работы шаблонов сайта:</p>\r\n<p>Все файлы, связанные с шаблонами сайта группируются в папки шаблонов сайта,</p>\r\n<p>Внутри папки шаблонов сайта есть папки шаблонов: страницы (main, universal,...), контроллеров(contacts,catalog,news...), виджетов(fnews,fadmin...),</p>\r\n<p>&nbsp;</p>\r\n<p>Схема генерации страницы:</p>\r\n<p>Открывается модуль Site, выбирается требуемый объект,</p>\r\n<p>Выбирается требуемый контроллер, происходит обработка данных,</p>\r\n<p>Выбирается требуемый шаблон, привязанный к объекту, тип выдачи всегда html.&nbsp;</p>\r\n<p>В шаблоне есть ссылки на виджеты типа {{vidget-alias}} где alias - алиас виджета. Такая ссылка приводит к запуску контроллера виджета, обработку результатов во view виджета и вставку их вместо шаблона&nbsp;{{vidget-alias}}. Контроллеры виджетов изначально ищутся в текущем шаблоне, если не найдены, то ищутся в дефолтовом шаблоне сайта. View виджетов берутся из текущего шаблона сайта, если такового не обнаружено, то виджет не выводится совсем. View контроллера запускается как обычный виджет.</p>\r\n<p>&nbsp;</p>', '', 1501659720, 0, 0, 2, 1501659732, 2, 1502114102, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(57, '2017-08-02 16:24:27', 7, 100, 0, '', 1, 0, 102, 0, 'Идея', '', '', '', 0, '', '', '<p><span style=\"font-size: x-large;\">Управление сайтами клиентов</span></p>\r\n<p><strong>Миссия:</strong></p>\r\n<ul>\r\n<li>полное избавление бизнеса от необходимости технической работы с сайтом,</li>\r\n<li>удешевление обслуживания сайтов компании (сколько потребуется)</li>\r\n<li>единое управление сайтами компании</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>Преимущества системы:</strong></p>\r\n<ul>\r\n<li>минимальная стоимость старта полноценного интернет магазина или корпоративного портала. Никакой дополнительной рекламы на вашем сайте,</li>\r\n<li>удобный интерфейс работы с информацией на сайте, контактами, заказами и иными поступающими данными,</li>\r\n<li>реализация всех основных элементов корпоративного сайта и интернет-магазина,</li>\r\n<li>возможность автоматического импорта первичных данных из 1с или других системы на базе XML выгрузок, а также синхронизации даннх между сайтом и 1с или иными первичными системами,</li>\r\n<li>подключение к счетчикам основных систем статистики без каких либо работ по программированию со стороны заказчика (регистрация + ввод идентификатора счетчика и все),</li>\r\n<li>изначальная адаптация сайта к требованиям поисковых систем: микроразметка, SEO, адаптивность, AMP версия,</li>\r\n<li>возможность генерации товарных фидов для различных партнерских программ (выбор из списка и максимум ввод идентификатора партнерки),</li>\r\n<li>возможность подключения своего шаблона дизайна сайта, если не подходит один из стандартных</li>\r\n<li>система персонализации + рекомендательная система,</li>\r\n<li>гибкая и удобная поисковая система по объектам сайта,</li>\r\n<li>система автозаполнения имен, адресов, автоматического определения пола пользователя при вводе данных,</li>\r\n<li>формирование выгрузок E-mail базы в ExpertSender или иные системы рассылок с возможностью сегментирования,</li>\r\n<li>стоимость обслуживания зависит от количества подключенных сайтов, объема данных в БД и файловой системе и интенсивности работы с панелью управления сайтами со стороны клиента. Посещаемость сайтов не влияет на стоимость обслуживания.</li>\r\n<li>сайт клиента размещается на хостинге клиента, контролируется клиентом, домен зарегистрирован на клиента. Управление сайтом ведется с использованием сервиса нашей компании.&nbsp;</li>\r\n<li>поддержка дополнительных языков, 2 языка каталога товаров (русский и английский)</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>Возможности развития системы:</strong></p>\r\n<ul>\r\n<li>сайты клиентов находятся на их хостингах под нашим или под их собственным управлением, можно договориться с площадками и иметь от них отдельный бонус за подключение к их услугам. Нагрузка от внешних пользователей таким образом не приходится на нашу систему, за исключением ее аналитического, рекомендательного и поискового блока,</li>\r\n<li>сервис управления данными клиентов находится на наших серверах, при этом мы можем группировать клиентов в рамках разных серверов, перебрасывая их при необходимости между ними, таким образом есть неограниченная возможность масштабирования системы,</li>\r\n<li>клиенты, заказавшие сайты как правило не особо разбираются в тонкостях ведения рекламных компаний, таким образом мы можем их получить как клиентов нашей рекламной компании, имея в том числе комиссию от рекламных площадок,</li>\r\n<li>клиенты, заказавшие сайты могут дополнительно подписаться на иные услуги, которые мы можем оказывать (бухгалтерское, юридическое и какое угодно иное обслуживание),</li>\r\n<li>клиенты постоянно работают в рамках нашего сервиса, у нас есть выход на лояльную аудиторию, которой мы можем показывать рекламу как наших, так и чужих акций,</li>\r\n<li>система мультиязычная мы можем с легкостью сделать версию для иностранного рынка и работать там по той же схеме</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><strong>Варианты экономного старта с Димой. Ежемесячные расходы:</strong></p>\r\n<p><em>Рекламный бюджет начинается с суммы - <strong>100 т.р.</strong> в месяц, далее растет до 5% от оборота.&nbsp;<br /><br />Сотрудники 1й очереди (1й этап реализации проекта):</em><br />- 1 технический директор (Я). Задачи руководство проектом, PHP разработка (150 т.р. на 1й очереди, 200 тысяч после перехода на 2 очередь и 300 тысяч по достижению прибыльности проекта).<br />- 1 js программист. Задачи - доработка имеющихся и создание новых шаблонов дизайна (80 т.р.),<br />- 1 менеджер по работе с клиентами. Задачи - привлечение и работа с клиентами и партнерами (40 т.р. + бонусы если перевыполнит план продаж до 60 тысяч в месяц),<br />Итого <strong>280 т.р.</strong></p>\r\n<p><em>Сотрудники 2й очереди (2й этап реализации проекта):</em><br />- 1 системный администратор. Задачи - сисадминство (60 т.р.),&nbsp;<br />- 1 интернет маркетолог. Задачи - ведение нашей рекламной компании, и компаний наших клиентов (60 т.р.),<br />- 1 секретарь. Задачи - входящие звонки, первоначальная консультация, работы по офису. (40 т.р.)<br />Итого по 1+2 очередям <strong>440 т.р.</strong></p>\r\n<p>При минимальной стоимости услуги 3000 рублей и среднем чеке 5000 руб в месяц для выхода на самоокупаемость потребуется:<br />- 50 стабильных клиентов в рамках 1го этапа (3-6 месяцев работы расход 400 т.р. в месяц)&nbsp;<br />- 90 стабильных клиентов в рамках 2го этапа (6-9 месяцев работы расход 600 т.р. в месяц)</p>\r\n<p>Переход с 1 на 2 очереди по персоналу происходит по мере роста доходов, которые бы покрывали расширение штата.<br /><br /><strong>Вложения сторон при расчете долей в проекте 50х50 (решения принимаются единогласно собственниками на собрании):</strong><br /><span style=\"color: #339966;\"><strong>Дмитрий</strong></span> - <strong>2млн.р.</strong> за первые 6 месяцев + регистрация компании + офис + бухгалтер (небольшое количество операций).<br /><span style=\"color: #339966;\"><strong>Константин</strong></span> - <strong>полностью функциональный программный комплекс</strong>, который позволит запустить проект и начать работать силами менеджеров и верстальщика, который будет добавлять шаблоны. Юридически вклад оформляется как лицензия на произвольное использование программного комплекса в рамках проекта с ппавом модификацией кода. Передача исключительных авторских прав на разработку возможна на 1 этапе, но это уже на порядок большая оценка, на этапе когда мы уже начнем получать прибыль это уже не будет возможно, т.к. не будет иметь для меня экономического смысла. Однако в рамках этого проекта исключительных авторских прав на базовую конфигурацию не требуется, а что косается доработок системы в рамках проекта, то на них исключительные авторские права будут переданы общей компании в дополнение к лицензии на базовую конфигурацию.</p>\r\n<p><strong>Касательно зарплаты Константина</strong> в рамках проекта - это цена php программиста среднего уровня по Москве, и нижний порог руководителя разработки. Если ты считаешь нужным, то на данную должность мы можем пригласить стороннего разработчика или ты можешь занять ее сам, но в таком случае мое участие в проекте будет заключаться в предоставлении обновленной версии системы + консультации сотрудников по возможностям системы. На первых порах (в рамках 1го этапа) технический директор будет:<br />- php разработчиком (устранение косяков, допиливание функционала),<br />- системным администратором (работа с площадками клиентов + наша площадка),<br />- интернет маркетологом (SEO, платный тарфик из разных источников),<br />- представителем компании на внешних мероприятиях по продвижению продукта (конференции, выставки...).</p>\r\n<p><strong>Расчетная прибыльность:<br /></strong>- На 1 этапе - задача - выйти на самоокупаемость в т.ч. в составе сотрудников 2 очереди, При достижении порога 90 стабильных клиентов полный переход на 2 этап в режиме самоокупаемости.<br />- На 2 этапе - задача 50% расходы 50% прибыль. При достижении порога в 200 клиентов ежемесячная прибыль составит около <strong>500 т.р. (12 млн. р. в год.)</strong><br />- На 3 этапе - задача выход на 500 клиентов с увеличением количества менеджеров по клиентам расчетный суммарный расход в месяц 800 т.р. доход 2,5 млн.р. прибыль <strong>1,5 млн в месяц (18 млн.р. в год)</strong><br />- На 4 этапе - задача формирование оптимального штата и выход на 1000 клиентов суммарный расход в месяц 1,2 млн, расчетный доход <strong>5 млн.р. в мес. (40 млн.р. в год)</strong>.<br />Думаю технически переход на 3 этап (начало реализации) достижим после первого года работы проекта, 4 этап - после 2 года работы проекта.&nbsp;<br /><br /><br /><strong>Также можно добавить еще пару бонусов:</strong><br />- у нас сформируется команда, которая может делать сайты как наши, так и на заказ, принося нам доп прибыль,<br />- мы получим дополнительные бонусы от хостинговых площадок, доменных регистраторов и Яндекса с гуглем, если через нас пойдет реклама,<br />- у нас будет технология быстрого запуска уже наших торговых проектов (скажем за 1 неделю с минимальными затратами).</p>\r\n<p>&nbsp;</p>', '', 1501676667, 0, 0, 2, 1501676667, 2, 1502114013, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(58, '2017-08-12 12:31:39', 7, 100, 0, '', 1, 0, 200, 0, 'Полезные мысли', '', '', '', 0, '', '', '<p>&nbsp;</p>\r\n<p>Умные мысли:</p>\r\n<ul>\r\n<li>В логе ошибок и событий, если это какой то внутренний метод, то сначала пишем название класса и метода.</li>\r\n<li>Метод если совершает действие, то отдает результат или false</li>\r\n<li>Метод если получает данные (возможно с преобразованием) отдает результат или null</li>\r\n<li>Надо стараться избегать цепочек файлов длиннее чем 3-4 вложения от точки входа в систему</li>\r\n<li>Надо стараться всегда все делать максимально следуя общепринятым стандартам и максимально хорошо и даже лучше, иначе впоследствии мы получим результат, который мы не сможем использовать в других системах без серьезны доработок.</li>\r\n<li>Не оставляйте ничего напотом, сделайте сразу и лучшим образом</li>\r\n<li>Старайтесь при разработке моделировать варианты использования вашего кода и учитывать потенциальное развитие системы</li>\r\n<li>Изолированность объектов системы - не панацея, разработчик впоследствии запутается в ваших интерфейсах. Сильно связанные системы - тоже плохо, т.к. их элементы привязаны как минимум к общему ядру системы и еще хуже, когда друг к другу. Старайтесь находить золотую середину.</li>\r\n<li>Старайтесь не использовать join на фронтендах. Текущая реализация системы предполагает возможность использования для хранилищ разных типов БД, при этом основной функционал сохраняется. Помните что join не на всех БД доступен, а реализация его средствами php может быть весьма тяжеловесной.</li>\r\n</ul>\r\n<p>&nbsp;</p>', '', 1502526660, 0, 0, 2, 1502526699, 2, 1502526744, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_users`
--

DROP TABLE IF EXISTS `mnbv_users`;
CREATE TABLE `mnbv_users` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(255) NOT NULL DEFAULT '',
  `passwd` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_users`
--

INSERT INTO `mnbv_users` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `email`, `login`, `passwd`, `phone`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 110, 110, 0, 'Пользователи', 'Users', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280461, 2, 1501053426, '127.0.0.1', 'Администратор', '', '', '', '', '', '', '', '', '', '', 0, ''),
(1000, '2017-09-05 18:45:02', 1, 100, 0, '', 0, 110, 110, 0, 'Пользователь', 'User', '', '', 0, '', '', '', '', 1504622700, 0, 0, 2, 1504622702, 2, 1508536607, '127.0.0.1', 'Администратор', '{\"permissions\":\"[\\\"3\\\"]\",\"iflang\":\"ru\",\"tplwidth\":1}', '', '', '', '', 'user@user.ru', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_vendors`
--

DROP TABLE IF EXISTS `mnbv_vendors`;
CREATE TABLE `mnbv_vendors` (
  `id` int(11) NOT NULL COMMENT 'Id',
  `datestr` varchar(19) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `pozid` int(11) NOT NULL DEFAULT '100',
  `type` int(1) NOT NULL DEFAULT '0',
  `typeval` varchar(255) NOT NULL DEFAULT '',
  `visible` int(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '0',
  `access2` int(11) NOT NULL DEFAULT '0',
  `first` int(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `namelang` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `comm` varchar(255) NOT NULL DEFAULT '',
  `preview` int(1) NOT NULL DEFAULT '0',
  `about` text NOT NULL,
  `aboutlang` text NOT NULL,
  `text` text NOT NULL,
  `textlang` text NOT NULL,
  `date` int(10) NOT NULL DEFAULT '0',
  `date1` int(10) NOT NULL DEFAULT '0',
  `date2` int(10) NOT NULL DEFAULT '0',
  `createuser` int(11) NOT NULL DEFAULT '0',
  `createdate` int(10) NOT NULL DEFAULT '0',
  `edituser` int(11) NOT NULL DEFAULT '0',
  `editdate` int(10) NOT NULL DEFAULT '0',
  `editip` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `vars` text NOT NULL,
  `attrup` text NOT NULL,
  `attr` text NOT NULL,
  `attrvals` text NOT NULL,
  `upfolders` text NOT NULL,
  `files` text NOT NULL,
  `siteid` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `discmaxpr` decimal(10,2) NOT NULL,
  `discmaxval` decimal(10,2) NOT NULL,
  `discminmargpr` decimal(10,2) NOT NULL,
  `discminmargval` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_vendors`
--

INSERT INTO `mnbv_vendors` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`) VALUES
(1, '2017-09-15 18:20:38', 0, 100, 1, '', 1, 0, 210, 0, 'Производители', 'Vendors', '', '', 0, '', '', '', '', 1505485238, 0, 0, 2, 1505485238, 2, 1505485246, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(2, '2017-09-15 18:21:02', 1, 100, 0, '', 1, 0, 210, 0, 'Bosh', 'Bosh', '', '', 0, '', '', '', '', 1505485262, 0, 0, 2, 1505485262, 2, 1505485294, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(3, '2017-09-15 18:21:24', 1, 100, 0, '', 1, 0, 210, 0, 'Dexter', 'Dexter', '', '', 0, '', '', '', '', 1505485284, 0, 0, 2, 1505485284, 2, 1505485295, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(4, '2017-09-15 18:21:47', 1, 100, 0, '', 1, 0, 210, 0, 'Атлант', '', '', '', 0, '', '', '', '', 1505485307, 0, 0, 2, 1505485307, 2, 1505485316, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mnbv_actions`
--
ALTER TABLE `mnbv_actions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_articles`
--
ALTER TABLE `mnbv_articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_attributes`
--
ALTER TABLE `mnbv_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_carts`
--
ALTER TABLE `mnbv_carts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_countries`
--
ALTER TABLE `mnbv_countries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_discounts`
--
ALTER TABLE `mnbv_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_menu`
--
ALTER TABLE `mnbv_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_messages`
--
ALTER TABLE `mnbv_messages`
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
-- Индексы таблицы `mnbv_products`
--
ALTER TABLE `mnbv_products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_robots`
--
ALTER TABLE `mnbv_robots`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_robotsrun`
--
ALTER TABLE `mnbv_robotsrun`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_site`
--
ALTER TABLE `mnbv_site`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_sites`
--
ALTER TABLE `mnbv_sites`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_sysusers`
--
ALTER TABLE `mnbv_sysusers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_tags`
--
ALTER TABLE `mnbv_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_templates`
--
ALTER TABLE `mnbv_templates`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_tickets`
--
ALTER TABLE `mnbv_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_users`
--
ALTER TABLE `mnbv_users`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mnbv_articles`
--
ALTER TABLE `mnbv_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `mnbv_attributes`
--
ALTER TABLE `mnbv_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `mnbv_carts`
--
ALTER TABLE `mnbv_carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mnbv_countries`
--
ALTER TABLE `mnbv_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mnbv_discounts`
--
ALTER TABLE `mnbv_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mnbv_menu`
--
ALTER TABLE `mnbv_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT для таблицы `mnbv_messages`
--
ALTER TABLE `mnbv_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT для таблицы `mnbv_news`
--
ALTER TABLE `mnbv_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mnbv_orders`
--
ALTER TABLE `mnbv_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mnbv_products`
--
ALTER TABLE `mnbv_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `mnbv_robots`
--
ALTER TABLE `mnbv_robots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `mnbv_robotsrun`
--
ALTER TABLE `mnbv_robotsrun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `mnbv_site`
--
ALTER TABLE `mnbv_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `mnbv_sites`
--
ALTER TABLE `mnbv_sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `mnbv_sysusers`
--
ALTER TABLE `mnbv_sysusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `mnbv_tags`
--
ALTER TABLE `mnbv_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mnbv_templates`
--
ALTER TABLE `mnbv_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mnbv_tickets`
--
ALTER TABLE `mnbv_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `mnbv_users`
--
ALTER TABLE `mnbv_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT для таблицы `mnbv_vendors`
--
ALTER TABLE `mnbv_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
