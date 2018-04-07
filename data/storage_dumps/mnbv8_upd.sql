-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 07 2018 г., 22:24
-- Версия сервера: 5.6.38
-- Версия PHP: 5.5.38

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
(2, '2017-08-19 14:10:06', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 1', 'Article1', 'test/test2/statya-1', '', 0, 'Краткое описание статьи 1', '', '<p>Полное писание статьи 1</p>', '', 1502964600, 0, 0, 2, 1503137406, 2, 1522001965, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522001964,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(3, '2017-08-19 14:10:13', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 2', 'Article2', 'statya-2', '', 0, 'Краткое описание статьи 2', '', '<p>Полное описание статьи 2</p>', '', 1503051000, 0, 0, 2, 1503137413, 2, 1522001985, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522001985,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(4, '2017-08-19 14:10:18', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 3', 'Aarticle3', 'stat-ya-3', '', 0, 'Краткое описание статьи 3', 'Mini description of article 1.', '<p>Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;</p>\r\n<p>Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;Полное описание статьи 3 &nbsp;</p>', '<p>Full description of article1&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1.</p>\r\n<p>&nbsp;Full description of article1&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1&nbsp;&nbsp;full description of article1 .</p>', 1503915000, 0, 0, 2, 1503137418, 2, 1504094899, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/u48Izeg-5W8\",\"type\":null,\"edituser\":\"2\",\"editdate\":1503843331,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(5, '2017-08-27 17:30:53', 1, 10, 1, '', 1, 0, 206, 0, 'Полезная информация', 'Useful info', 'testggggg', '', 0, '', '', '<p>Описание полезной информации</p>', '', 1503840600, 0, 0, 2, 1503840653, 2, 1503868777, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, ''),
(6, '2017-08-27 17:59:07', 1, 20, 1, '', 1, 0, 206, 0, 'Бесполезная информация', 'Unuseful info', '', '', 0, '', '', '<p>Описание бесполезной информации</p>', '', 1503842340, 0, 0, 2, 1503842347, 2, 1503868791, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, ''),
(7, '2017-08-27 17:59:37', 6, 100, 0, '', 1, 0, 206, 0, 'Статья1', 'Article1', '', '', 0, '', '', '', '', 1503842377, 0, 0, 2, 1503842377, 2, 1503852005, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(8, '2017-08-27 17:59:43', 6, 100, 0, '', 1, 0, 206, 0, 'Статья2', 'Article2', '', '', 0, '', '', '', '', 1503842383, 0, 0, 2, 1503842383, 2, 1503852009, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

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
(2, '2017-08-19 14:10:30', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 1', 'News1', 'novost-1', '', 0, 'краткое описание новости 1', '', '<p>Полное описание новости 1.</p>', '', 1503137400, 0, 0, 2, 1503137430, 2, 1522002027, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002027,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(3, '2017-08-19 14:10:36', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 2', 'News2', 'novost-2', '', 0, 'краткое описание новости 2', '', '<p>Полное описание новости 2</p>', '', 1503223800, 0, 0, 2, 1503137436, 2, 1522002033, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002033,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(4, '2017-08-19 14:10:42', 1, 100, 0, '', 1, 0, 205, 0, 'Новость 3', 'News3', 'News3', '', 0, 'краткое описание новости 3.', 'mini description of news3.', '<p>Полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>\r\n<p> полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3 полное описание новости 3.</p>', '<p>Full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3.</p>\r\n<p>&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3&nbsp;full description of news3.</p>\r\n<p>{{img:2}}</p>', 1503310200, 0, 0, 2, 1503137442, 2, 1522002048, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"2\":{\"url\":\"https:\\/\\/youtu.be\\/u48Izeg-5W8\",\"type\":null,\"edituser\":\"2\",\"editdate\":1522002048,\"editip\":\"127.0.0.1\"},\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002048,\"editip\":\"127.0.0.1\"}}}', 0, '');

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
(4, '1970-01-01 03:00:00', 2, 100, 0, '', 1, 0, 210, 1, 'Товар1', 'Prod 1', 'tovar1', '', 0, 'краткое описание товара1', 'Mini product 1 description.', '<p>Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара.</p>\r\n<p>Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара.  Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара.</p>\r\n<p>Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара. Текстовое описание товара.</p>', '<p>Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;</p>\r\n<p>Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;</p>\r\n<p>Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;Text about this product.&nbsp;</p>', 1502838000, 0, 0, 2, 1469005946, 2, 1522002092, '127.0.0.1', 'Администратор', '', '', '', '{\"attr2\":8,\"attr4\":12,\"attr3\":\"25.33\"}', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002092,\"editip\":\"127.0.0.1\"}}}', 0, '', '150.27', '250.00', '100.00', '0.00', '0.00', '0.00', '0.00', 2, 3),
(5, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 210, 1, 'Товар2', 'Prod 2', '', '', 0, 'Краткое описание товара 2', 'Mini product 2 description.', '', '', 1501542000, 0, 0, 2, 1469005950, 2, 1521655062, '127.0.0.1', 'Администратор', '', '', '', '{\"attr2\":9,\"attr3\":\"0.00\"}', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/pAgnJDJN4VA\",\"type\":null,\"edituser\":\"2\",\"editdate\":1506609585,\"editip\":\"127.0.0.1\"}}}', 0, '', '220.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(6, '0000-00-00 00:00:00', 3, 100, 0, '', 1, 0, 210, 0, 'Товар3', 'Prod 3', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005958, 2, 1481469644, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(7, '0000-00-00 00:00:00', 3, 100, 0, '', 1, 0, 210, 0, 'Товар4', 'Prod 4', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005963, 2, 1481469649, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(8, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 210, 0, 'Категория товаров 3', 'Cat 3', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1470732688, 2, 1502526870, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(9, '1970-01-01 03:00:00', 8, 100, 1, '', 1, 0, 210, 0, 'CatCat 3', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1470732716, 2, 1481469661, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\",\"8\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0),
(10, '0000-00-00 00:00:00', 9, 100, 1, '', 1, 0, 210, 0, 'CatCatCat3', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1470833797, 2, 1481469675, '127.0.0.1', 'Администратор', '', '[{\"attrid\":\"3\",\"pozid\":300,\"namelang\":\"Weight\",\"dnuse\":1,\"inshort\":1}]', '', '', '[\"1\",\"8\",\"9\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, 0);

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
(1, '2017-08-08 12:49:06', 0, 100, 1, '', 1, 0, 102, 0, 'Демо сайт MNBV', 'MNBV demonstration site', '', '', 0, 'Главная страница сайта', '', '<p>{{img-right:1}}Добро пожайловать на демонстрационную версию сайта компании. Она включает основные элементы, которые необходимы полноценному информационному ресурсу, а именно:</p>\r\n<ul>\r\n<li>структуру статических страниц,</li>\r\n<li>новости и статьи,</li>\r\n<li>каталог товаров,</li>\r\n<li>контакты с формой обратной связи,</li>\r\n</ul>\r\n<p>В разработке:</p>\r\n<ul>\r\n<li>баннерная система,</li>\r\n<li>авторизация, личный кабинет пользователя, </li>\r\n<li>система скидок для каталога товаров,</li>\r\n<li>система обработки событий (нужна для установки счетчиков и др. скриптов партнерских программ),</li>\r\n<li>систему выгрузки товарных фидов различных видов,</li>\r\n<li>систему управления контентом,</li>\r\n<li>система загрузки и синхронизации данных в хранилищах</li>\r\n<li>система автоматического формирования каталогов, свойств товара и при необходимости группировки их значений из XML фида с параметрами товара.</li>\r\n</ul>\r\n<p>Вы можете подключить любой выбранный вами шаблон дизайна и использовать несколько вариантов шаблонов дизайна одновременно, переключаясь между ними.</p>\r\n<p>Система поддерживает работу с несколькими сайтами, а также позволяет подключать разные варианты шаблонов отображения на разные доменные имена.</p>', '<p>{{img-right:1}}Hello! We are glad to sea you in this Demo Site!</p>\r\n<p>It cotsists of:</p>\r\n<ul>\r\n<li>structure of static pages,</li>\r\n<li>structure of news and articles,</li>\r\n<li>product catalog,</li>\r\n<li>contacts whith feedback &nbsp;form,</li>\r\n<li>banners system,</li>\r\n<li>user login and personal account,&nbsp;</li>\r\n<li>discount system,</li>\r\n<li>events system,</li>\r\n<li>feeds generator,</li>\r\n<li>CMS,</li>\r\n<li>storage uploader</li>\r\n<li>catalog autocomplite.</li>\r\n</ul>\r\n<p>Select template and connect it to system.</p>\r\n<p>You can work whith&nbsp;multiple sites.</p>\r\n<p>{{att:1}} - Document.</p>', 1502182140, 0, 0, 2, 1502182146, 2, 1522002311, '127.0.0.1', 'Администратор', '{\"script\":\"mainpage\",\"tpl_file\":\"index.php\"}', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/mnbv\\/img\\/logo\\/smile.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522002311,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(2, '2017-08-08 12:49:42', 1, 100, 0, '', 1, 0, 102, 0, 'О компании', 'About', 'about', '', 0, 'Информация о компании.', 'Put the information about your company here.', '<p>Здесь вы можете разместить информацию о вашей компании. Воспользуйтесь удобным текстовым и графическим редакторами для наполнения&nbsp; страниц.</p>', '<p>Put the information about your company here. It may be text, images or another&nbsp;attentions. You can use text or grafical editor.</p>', 1502182140, 0, 0, 2, 1502182182, 2, 1521286688, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(3, '2017-08-08 12:49:51', 1, 100, 0, '', 1, 0, 102, 0, 'Статьи', 'Articles', 'articles', '', 0, '', 'The articles list of the company.', '', '<p>The articles list of the company.</p>', 1502182140, 0, 0, 2, 1502182191, 2, 1504012101, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"list_sort\":\"date_desc\",\"script_storage\":\"articles\",\"script_folder\":\"1\",\"list_max_items\":2}', '', '', '', '', '', 0, ''),
(4, '2017-08-08 12:50:05', 1, 100, 0, '', 1, 0, 102, 0, 'Новости', 'News', 'news', '', 0, 'Новинки компании - будте всегда в курсе!', 'The news list of the company. ', '<p>Новинки компании - будте всегда в курсе!</p>', '<p>The news list of the company.&nbsp;</p>', 1502182200, 0, 0, 2, 1502182205, 2, 1504004650, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"script_storage\":\"news\",\"script_folder\":\"1\",\"list_max_items\":2,\"list_sort\":\"date_desc\"}', '', '', '', '', '', 0, ''),
(5, '2017-08-08 12:50:13', 1, 100, 0, '', 1, 0, 102, 0, 'Каталог', 'Catalog', 'catalog', '', 0, 'Каталог товаров, реализуемых компанией - найдите что-то полезное для себя!', 'Product catalog page.', '<p>Каталог товаров, реализуемых компанией - найдите что-то полезное для себя!</p>', '<p>Product catalog here.</p>', 1502182200, 0, 0, 2, 1502182213, 2, 1504012091, '127.0.0.1', 'Администратор', '{\"script\":\"products\",\"script_storage\":\"products\",\"script_folder\":\"1\",\"list_max_items\":2}', '', '', '', '', '', 0, ''),
(6, '2017-08-08 12:50:33', 1, 100, 0, '', 1, 0, 102, 0, 'Контакты', 'Contacts', 'contacts', '', 0, 'Контактная информация компании и форма обратной связи.', 'Contacts whith feedback  form.', '<p>Контакты для связи:</p>\r\n<ul>\r\n<li>Адрес ...,</li>\r\n<li>Телефон ...,</li>\r\n<li>E-mail ...,</li>\r\n<li>Skype ...</li>\r\n</ul>\r\n<p>Или оставьте сообщение ниже в форме обратной связи:</p>', '<p>Contacts:</p>\r\n<ul>\r\n<li>Address ...,</li>\r\n<li>Phone ...,</li>\r\n<li>E-mail ...,</li>\r\n<li>Skype ...</li>\r\n</ul>\r\n<p>You can send us the message by the feedback &nbsp;form on bottom.</p>', 1502182200, 0, 0, 2, 1502182233, 2, 1504212227, '127.0.0.1', 'Администратор', '{\"script\":\"contacts\",\"script_storage\":\"messages\",\"script_folder\":\"2\"}', '', '', '', '', '', 0, ''),
(7, '2017-08-08 12:52:12', 1, 100, 0, '', 1, 0, 102, 0, 'Авторизация', 'Login', 'auth', '', 0, 'Авторизация.', 'User ligin.', '', '', 1502182320, 0, 0, 2, 1502182332, 2, 1503590846, '127.0.0.1', 'Администратор', '{\"script\":\"auth\"}', '', '', '', '', '', 0, ''),
(8, '2017-08-24 23:04:47', 1, 100, 1, '', 1, 0, 102, 0, 'Раздел сайта', 'Site folder', 'sitefolder', '', 0, '', '', '<p>Описание папки</p>', '', 1503601440, 0, 0, 2, 1503601487, 2, 1503904025, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"site_tpl\":\"main\"}', '', '', '', '[\"1\"]', '', 0, ''),
(9, '2017-08-24 23:05:03', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 1 раздела сайта', 'Page1', 'folder_pg1', '', 0, 'Описание 1 страницы раздела', 'about pg1', '', '', 1503601500, 0, 0, 2, 1503601503, 2, 1522002373, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(10, '2017-08-24 23:05:11', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 2 раздела сайта', 'Page2', 'folder_pg2', '', 0, 'Описание 2 страницы раздела', 'about pg2', '', '', 1503601560, 0, 0, 2, 1503601511, 2, 1503752773, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/icdn.lenta.ru\\/images\\/2017\\/08\\/25\\/21\\/20170825214257584\\/pic_abb27da63dffc6fb1e6988663e41dd45.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1503688407,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(11, '2017-08-24 23:05:19', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 3 раздела сайта', 'Page3', '', '', 0, '', '', '<p>{{img-right:1}}</p>', '', 1503601620, 0, 0, 2, 1503601519, 2, 1503752778, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/xLDM32xJ6iY\",\"type\":null,\"edituser\":\"2\",\"editdate\":1503698049,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(12, '2017-08-25 23:24:56', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 4 раздела сайта', 'Page4', '', '', 0, '', '', '', '', 1503688080, 0, 0, 2, 1503689096, 2, 1503845817, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(14, '2017-09-02 21:27:25', 1, 100, 0, '', 1, 0, 102, 0, 'Корзина', 'Cart', 'cart', '', 0, '', '', '', '', 1504373220, 0, 0, 2, 1504373245, 2, 1504373350, '127.0.0.1', 'Администратор', '{\"script\":\"cart\",\"script_folder\":\"1\"}', '', '', '', '', '', 0, ''),
(15, '2017-09-16 00:05:17', 1, 100, 0, '', 1, 0, 102, 0, 'Акции', 'Actions', 'actions', '', 0, '', '', '<p>Наши акции тут:</p>', '<p>Our actions is here:</p>', 1505505900, 0, 0, 2, 1505505917, 2, 1505506336, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"script_storage\":\"actions\",\"script_folder\":\"1\",\"list_sort\":\"pozid\"}', '', '', '', '', '', 0, '');

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
(36, '0000-00-00 00:00:00', 7, 10, 1, '', 1, 0, 102, 0, 'Надо сделать', '', 'nado-sdelat', '', 0, '', '', '', '', 0, 0, 0, 2, 1501496978, 2, 1502182061, '127.0.0.1', 'Администратор', '', '', '', '', '[\"7\"]', '', 0, ''),
(39, '0000-00-00 00:00:00', 50, 100, 0, '', 1, 0, 102, 0, 'Выделения функционала в модули', '', '', '', 0, '', '', '<p>В системе функционал можно выделять как модуль, так и реализовывать в рамках какого-то иного модуля как например Интранет, сайт и т.п.</p>\r\n<p>Базовые модули мы выделяем отдельно.</p>\r\n<p><strong>Базовые модули</strong>:</p>\r\n<ul>\r\n<li>core - ядро системы</li>\r\n<li>mnbv - основной модуль CMS MNBV, содержащий основные библиотеки</li>\r\n<li>api - модуль API системы MNBV</li>\r\n<li>sdata - модуль вывода статики с контролем доступа /sdata/...</li>\r\n<li>imgeditor - графический редактор</li>\r\n<li>intranet - модуль авторизации, управления хранилищами и др. базовые функции</li>\r\n<li>site - модуль вывода сайта (фронтенд части)</li>\r\n</ul>\r\n<p><strong>Контроллеры в рамках модуля сайт</strong>:</p>\r\n<ul>\r\n<li>auth - авторизация</li>\r\n<li>list - вывод списка раздела</li>\r\n<li>pg - вывод страницы</li>\r\n<li>photos - вывод фотоальбома</li>\r\n<li>contacts - вывод формы контактов</li>\r\n<li>catalog - каталог товаров</li>\r\n<li>news - новости</li>\r\n<li>articles - статьи</li>\r\n<li>links - полезные ссылки со структурой ссылкой и описанием</li>\r\n</ul>', '', 0, 0, 0, 2, 1501498242, 2, 1521656117, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
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
(53, '0000-00-00 00:00:00', 7, 100, 0, '', 1, 0, 102, 0, 'Шаблоны bootstrap', '', '', '', 0, '', '', '<p>Полезные ссылки:</p>\r\n<ol>\r\n<li><a href=\"http://mybootstrap.ru/\">http://mybootstrap.ru/</a> </li>\r\n<li><a href=\"http://ktonanovenkogo.ru/html/bootstrap/bootstrap-3-otzyvchivyj-frejmvork-sozdaniya-dizajna-sajtov.html\">http://ktonanovenkogo.ru/html/bootstrap/bootstrap-3-otzyvchivyj-frejmvork-sozdaniya-dizajna-sajtov.html</a> </li>\r\n<li><a href=\"https://habrahabr.ru/post/156425/\">https://habrahabr.ru/post/156425/</a> - сравнение</li>\r\n<li><a href=\"https://www.keycdn.com/blog/bootstrap-vs-foundation/\">https://www.keycdn.com/blog/bootstrap-vs-foundation/</a> - сравнение</li>\r\n<li><a href=\"https://webformyself.com/category/premium/framework-premium/bootstrappremium/\">https://webformyself.com/category/premium/framework-premium/bootstrappremium/</a> - видеоуроки</li>\r\n<li><a href=\"https://www.youtube.com/watch?v=siJoY2hzqqM\">https://www.youtube.com/watch?v=siJoY2hzqqM</a> - сравнение видео</li>\r\n</ol>\r\n<p> </p>\r\n<p>Ссылки по уроку:</p>\r\n<ul>\r\n<li><a href=\"https://www.youtube.com/watch?v=46q2eB7xvXA\">https://www.youtube.com/watch?v=46q2eB7xvXA</a></li>\r\n<li><a href=\"http://getbootstrap.com/getting-started/\">http://getbootstrap.com/getting-started/</a> </li>\r\n<li><a href=\"http://fontawesome.io/\">http://fontawesome.io/</a> </li>\r\n<li><a href=\"https://fonts.google.com/\">https://fonts.google.com/</a></li>\r\n</ul>\r\n<p> </p>\r\n<p>{{img-right:2}}Бесплатные шаблоны для бутстрапа:</p>\r\n<ul>\r\n<li><a href=\"http://seo-design.net/templates/free-responsive-bootstrap-html-templates\">http://seo-design.net/templates/free-responsive-bootstrap-html-templates</a> </li>\r\n<li><a href=\"http://bootstraptema.ru/stuff/templates_bootstrap/1\">http://bootstraptema.ru/stuff/templates_bootstrap/1</a> </li>\r\n<li><a href=\"http://beloweb.ru/shablonyi/luchshie-i-besplatnyie-bootstrap-shablonyi.html\">http://beloweb.ru/shablonyi/luchshie-i-besplatnyie-bootstrap-shablonyi.html</a> </li>\r\n<li><a href=\"http://internet-pages.blogspot.ru/2015/08/50-bootstrap-html.html\">http://internet-pages.blogspot.ru/2015/08/50-bootstrap-html.html</a> </li>\r\n<li><a href=\"https://ruseller.com/lessons.php?rub=1&id=2392\">https://ruseller.com/lessons.php?rub=1&id=2392</a> </li>\r\n<li><a href=\"http://bayguzin.ru/main/shablonyi/shablonyi-dlya-biznesa/beetle.html\">http://bayguzin.ru/main/shablonyi/shablonyi-dlya-biznesa/beetle.html</a> </li>\r\n<li><a href=\"http://bootstrap-v4.ru/examples/\">http://bootstrap-v4.ru/examples/</a> </li>\r\n<li><a href=\"http://bootstraptema.ru/stuff/templates_bootstrap/\">http://bootstraptema.ru/stuff/templates_bootstrap/</a></li>\r\n<li><a href=\"http://ofitsialniy-sait.ru/e-shop\">http://ofitsialniy-sait.ru/e-shop</a> </li>\r\n<li><a href=\"http://design-secrets.ru/44-besplatnyx-adaptivnyx-html5-shablonov.html\">http://design-secrets.ru/44-besplatnyx-adaptivnyx-html5-shablonov.html</a> </li>\r\n</ul>\r\n<p>Шаблоны интернет-магазинов:</p>\r\n<ul>\r\n<li><a href=\"http://bootstraptema.ru/stuff/templates_bootstrap/shop/7-1\">http://bootstraptema.ru/stuff/templates_bootstrap/shop/7-1</a> </li>\r\n<li><a href=\"https://p.w3layouts.com/demos/mattress/web/\">https://p.w3layouts.com/demos/mattress/web/</a> </li>\r\n<li><a href=\"http://ofitsialniy-sait.ru/template/e_shop-web/contact.html\">http://ofitsialniy-sait.ru/template/e_shop-web/contact.html</a>  - прикольный шаблон</li>\r\n<li><a href=\"http://ofitsialniy-sait.ru/templates-bootstrap\">http://ofitsialniy-sait.ru/templates-bootstrap</a>   - и много разных других шаблонов бесплатно</li>\r\n</ul>\r\n<p> </p>\r\n<p>Особенно понравились:</p>\r\n<ul>\r\n<li><a href=\"http://ofitsialniy-sait.ru/templates-bootstrap\">http://ofitsialniy-sait.ru/templates-bootstrap</a> </li>\r\n</ul>', '', 0, 0, 0, 2, 1501577876, 2, 1521656157, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(55, '0000-00-00 00:00:00', 7, 100, 0, '', 1, 0, 102, 0, 'Косяки', '', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1501583255, 2, 1501598348, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(56, '2017-08-02 11:42:12', 7, 100, 0, '', 1, 0, 102, 0, 'В работе', '', '', '', 0, '', '', '<p><strong>Доработки по админке:</strong></p>\r\n', '', 1501659720, 0, 0, 2, 1501659732, 2, 1521656271, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(58, '2017-08-12 12:31:39', 7, 100, 0, '', 1, 0, 200, 0, 'Полезные мысли', '', '', '', 0, '', '', '<p>&nbsp;</p>\r\n<p>Умные мысли:</p>\r\n<ul>\r\n<li>В логе ошибок и событий, если это какой то внутренний метод, то сначала пишем название класса и метода.</li>\r\n<li>Метод если совершает действие, то отдает результат или false</li>\r\n<li>Метод если получает данные (возможно с преобразованием) отдает результат или null</li>\r\n<li>Надо стараться избегать цепочек файлов длиннее чем 3-4 вложения от точки входа в систему</li>\r\n<li>Надо стараться всегда все делать максимально следуя общепринятым стандартам и максимально хорошо и даже лучше, иначе впоследствии мы получим результат, который мы не сможем использовать в других системах без серьезны доработок.</li>\r\n<li>Не оставляйте ничего напотом, сделайте сразу и лучшим образом</li>\r\n<li>Старайтесь при разработке моделировать варианты использования вашего кода и учитывать потенциальное развитие системы</li>\r\n<li>Изолированность объектов системы - не панацея, разработчик впоследствии запутается в ваших интерфейсах. Сильно связанные системы - тоже плохо, т.к. их элементы привязаны как минимум к общему ядру системы и еще хуже, когда друг к другу. Старайтесь находить золотую середину.</li>\r\n<li>Старайтесь не использовать join на фронтендах. Текущая реализация системы предполагает возможность использования для хранилищ разных типов БД, при этом основной функционал сохраняется. Помните что join не на всех БД доступен, а реализация его средствами php может быть весьма тяжеловесной.</li>\r\n</ul>\r\n<p>&nbsp;</p>', '', 1502526660, 0, 0, 2, 1502526699, 2, 1502526744, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

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
-- Индексы таблицы `mnbv_site`
--
ALTER TABLE `mnbv_site`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_tags`
--
ALTER TABLE `mnbv_tags`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_tickets`
--
ALTER TABLE `mnbv_tickets`
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
-- AUTO_INCREMENT для таблицы `mnbv_site`
--
ALTER TABLE `mnbv_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `mnbv_tags`
--
ALTER TABLE `mnbv_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mnbv_tickets`
--
ALTER TABLE `mnbv_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `mnbv_vendors`
--
ALTER TABLE `mnbv_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
