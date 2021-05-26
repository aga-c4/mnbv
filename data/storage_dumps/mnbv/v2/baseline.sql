-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2021 г., 16:49
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
-- Структура таблицы `mnbv_articles`
--

DROP TABLE IF EXISTS `mnbv_articles`;
CREATE TABLE `mnbv_articles` (
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
-- Дамп данных таблицы `mnbv_articles`
--

INSERT INTO `mnbv_articles` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-19 14:09:52', 0, 100, 1, '', 1, 0, 206, 0, 'Статьи', 'Articles', '', '', 0, '', '', '<p>Описание корневой категории статей</p>', 'Root article folder text...', 1503137340, 0, 0, 2, 1503137392, 2, 1621326241, '127.0.0.1', 'Администратор', '{\"list_sort\":\"pozid\"}', '', '', '', '', '', 0, ''),
(2, '2017-08-19 14:10:06', 5, 100, 0, '', 1, 0, 206, 0, 'Статья 1', 'Article1', 'stat-ya-1', '', 0, 'Анонс и краткое описание статьи 1. Анонс и краткое описание статьи 1', '', '<p>Полное писание статьи 1</p>', '', 1502964600, 0, 0, 2, 1503137406, 2, 1621422801, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(3, '2017-08-19 14:10:13', 5, 100, 0, '', 1, 0, 206, 1, 'Статья 2 - интересно о разном', 'Article2', 'statya-2', '', 0, 'Анонс и краткое описание статьи 2. Анонс и краткое описание статьи 2. Анонс и краткое описание статьи 2.', 'Mini description of article 2.', '<p>Полное описание статьи 2</p>', '<p>Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1.</p>\r\n<p> Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1 .</p>', 1503051000, 0, 0, 2, 1503137413, 2, 1621326525, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1522001985,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(4, '2017-08-19 14:10:18', 5, 100, 0, '', 1, 0, 206, 1, 'Статья 3 - читайте и радуйтесь!', 'Article3', 'stat-ya-3', '', 0, 'Анонс и краткое описание статьи 3. Анонс и краткое описание статьи 3. Анонс и краткое описание статьи 3.', 'Mini description of article 3.', '<p>Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  </p>\r\n<p>Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  Полное описание статьи 3  </p>', '<p>Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1.</p>\r\n<p> Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1 .</p>', 1503915000, 0, 0, 2, 1503137418, 2, 1621326507, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/u48Izeg-5W8\",\"type\":null,\"edituser\":\"2\",\"editdate\":1619479845,\"editip\":\"127.0.0.1\"},\"2\":{\"url\":\"http:\\/\\/mnbv.ru\\/img\\/help_book.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1619479845,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(5, '2017-08-27 17:30:53', 1, 10, 1, '', 1, 0, 206, 0, 'Полезная информация', 'Useful info', 'poleznaya-informaciya', '', 0, 'Краткое описание данного раздела. Краткое описание данного раздела. Краткое описание данного раздела.', 'Short description of this foler. Short description of this foler. Short description of this foler.', '<p>Описание полезной информации</p>', '', 1503840600, 0, 0, 2, 1503840653, 2, 1621423104, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, ''),
(6, '2017-08-27 17:59:07', 1, 20, 1, '', 1, 0, 206, 0, 'Бесполезная информация', 'Unuseful info', 'bespoleznaya-informaciya', '', 0, 'Краткое описание данного раздела. Краткое описание данного раздела. Краткое описание данного раздела.', 'Short description of this foler. Short description of this foler. Short description of this foler.', '<p>Описание бесполезной информации</p>', '', 1503842340, 0, 0, 2, 1503842347, 2, 1621423094, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, ''),
(7, '2017-08-27 17:59:37', 6, 100, 0, '', 1, 0, 206, 0, 'Статья1', 'Article1', 'stat-ya1', '', 0, '', 'Mini description of article 1.', '', '<p>Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1.</p>\r\n<p> Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1 .</p>', 1503842340, 0, 0, 2, 1503842377, 2, 1621326568, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(8, '2017-08-27 17:59:43', 6, 100, 0, '', 1, 0, 206, 0, 'Статья2', 'Article2', '', '', 0, '', 'Mini description of article 2.', '', '<p>Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1.</p>\r\n<p> Full description of article1 full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1  full description of article1 .</p>', 1503842340, 0, 0, 2, 1503842383, 2, 1621326573, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

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
(2, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 103, 0, 'Страна', 'Country', '', '', 'Русское описание', 'Eng aboute', '<p>Русский текст</p>', '<p>Eng text</p>', 0, 0, 0, 2, 1468929743, 2, 1620502196, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"select\",\"linkstorage\":\"attributes\",\"filter_folder\":\"2\",\"filter_type\":\"objects\",\"checktype\":\"int\",\"lang\":\"all\",\"viewindex\":1,\"dbtype\":\"int\",\"notset\":1}', '', '', '', '', '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Вес,г', 'Weight,g', '', '', '', '', '', '', 0, 0, 0, 2, 1469004674, 2, 1622021574, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"width\":\"100%\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"dbtype\":\"int\"}', '', '', '', '', '', 0, ''),
(4, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 103, 0, 'Город', 'Town', '', '', '', '', '', '', 0, 0, 0, 2, 1469004787, 2, 1621005966, '127.0.0.1', 'Администратор', '{\"active\":\"update\",\"table\":\"td\",\"type\":\"select\",\"viewindex\":1,\"linkstorage\":\"attributes\",\"filter_folder\":\"4\",\"filter_type\":\"objects\",\"checktype\":\"int\",\"lang\":\"all\",\"dbtype\":\"int\",\"notset\":1}', '', '', '', '', '', 0, ''),
(5, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Длина,cм', 'Length,sm', '', '', '', '', '', '', 0, 0, 0, 2, 1469004857, 2, 1622013164, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"width\":\"100%\"}', '', '', '', '', '', 0, ''),
(6, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Ширина,cм', 'Width,sm', '', '', '', '', '', '', 0, 0, 0, 2, 1469004863, 2, 1622013187, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"width\":\"100%\"}', '', '', '', '', '', 0, ''),
(7, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 0, 103, 0, 'Высота,cм', 'Height,sm', '', '', '', '', '', '', 0, 0, 0, 2, 1469004867, 2, 1622013247, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\",\"width\":\"100%\"}', '', '', '', '', '', 0, ''),
(8, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 103, 0, 'Россия', 'Russia', '', '', '', '', '', '', 0, 0, 0, 2, 1469005123, 2, 1481636135, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(9, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 103, 0, 'Китай', 'China', '', '', '', '', '', '', 0, 0, 0, 2, 1469005129, 2, 1481636137, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(10, '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 103, 0, 'США', 'USA', '', '', '', '', '', '', 0, 0, 0, 2, 1469005151, 2, 1619767337, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(11, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Москва', 'Moscow', '', '', '', '', '', '', 0, 0, 0, 2, 1469005194, 2, 1481636118, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(12, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Санкт-Петербург', 'Sankt Petersburg', '', '', '', '', '', '', 0, 0, 0, 2, 1469005201, 2, 1481636121, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(13, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Пекин', 'Pekin', '', '', '', '', '', '', 0, 0, 0, 2, 1469005208, 2, 1481636123, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(14, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Нью-Йорк', 'New York', '', '', '', '', '', '', 0, 0, 0, 2, 1469005233, 2, 1481636126, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(15, '0000-00-00 00:00:00', 4, 100, 0, '', 1, 0, 103, 0, 'Сиэтл', 'Seattle', '', '', '', '', '', '', 0, 0, 0, 2, 1469005240, 2, 1481636128, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(16, '2021-04-30 10:18:38', 1, 100, 0, '', 1, 0, 103, 0, 'Резерв', 'Reserv', '', '', '', '', '', '', 1619767080, 0, 0, 2, 1619767118, 2, 1622012603, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"int\",\"lang\":\"all\"}', '', '', '', '', '', 0, ''),
(17, '2021-05-08 17:47:03', 1, 100, 1, '', 1, 0, 103, 0, 'Лист', 'List', 'list', 'List', '', '', '', '', 1620485220, 0, 0, 2, 1620485223, 2, 1620504022, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"list\",\"filter_type\":\"objects\",\"checktype\":\"no\",\"lang\":\"all\",\"delim\":\",\",\"linkstorage\":\"attributes\",\"filter_folder\":\"17\"}', '', '', '', '[\"1\"]', '', 0, ''),
(18, '2021-05-08 17:47:12', 1, 100, 1, '', 1, 0, 103, 0, 'Радио', 'Radio', 'radio', 'FrList', '', '', '', '', 1620485220, 0, 0, 2, 1620485232, 2, 1620504890, '127.0.0.1', 'Администратор', '{\"dbtype\":\"int\",\"active\":\"update\",\"table\":\"td\",\"type\":\"radio\",\"filter_type\":\"objects\",\"checktype\":\"no\",\"lang\":\"all\",\"linkstorage\":\"attributes\",\"delim\":\",\",\"filter_folder\":\"18\",\"notset\":1}', '', '', '', '[\"1\"]', '', 0, ''),
(19, '2021-05-08 17:50:15', 17, 100, 0, '', 1, 0, 103, 0, 'Пункт1', 'Item1', '', '', '', '', '', '', 1620485415, 0, 0, 2, 1620485415, 2, 1621324217, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(20, '2021-05-08 17:50:19', 17, 100, 0, '', 1, 0, 103, 0, 'Пункт2', 'Item2', '', '', '', '', '', '', 1620485419, 0, 0, 2, 1620485419, 2, 1621324223, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(21, '2021-05-08 17:50:22', 17, 100, 0, '', 1, 0, 103, 0, 'Пункт3', 'Item3', '', '', '', '', '', '', 1620485422, 0, 0, 2, 1620485422, 2, 1621324226, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(22, '2021-05-08 17:50:32', 18, 100, 0, '', 1, 0, 103, 0, 'ФПункт1', 'RItem1', '', '', '', '', '', '', 1620485432, 0, 0, 2, 1620485432, 2, 1621324239, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(23, '2021-05-08 17:50:39', 18, 100, 0, '', 1, 0, 103, 0, 'ФПункт2', 'RItem2', '', '', '', '', '', '', 1620485439, 0, 0, 2, 1620485439, 2, 1621324242, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(24, '2021-05-08 17:50:47', 18, 100, 0, '', 1, 0, 103, 0, 'ФПункт3', 'RItem3', '', '', '', '', '', '', 1620485447, 0, 0, 2, 1620485447, 2, 1621324245, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(25, '2021-05-10 00:24:05', 1, 100, 0, '', 1, 0, 103, 0, 'Коммент', 'Comment', 'comm', '', '', '', '', '', 1620595440, 0, 0, 2, 1620595445, 2, 1621324280, '127.0.0.1', 'Администратор', '{\"dbtype\":\"string\",\"active\":\"update\",\"table\":\"td\",\"type\":\"text\",\"filter_type\":\"all\",\"checktype\":\"no\",\"lang\":\"all\"}', '', '', '', '', '', 0, '');

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

--
-- Дамп данных таблицы `mnbv_attrvals`
--

INSERT INTO `mnbv_attrvals` (`id`, `objid`, `objparentid`, `attrid`, `vint`, `vstr`) VALUES
(10, 4, 2, 4, 12, ''),
(13, 4, 2, 18, 22, ''),
(32, 5, 2, 4, 13, ''),
(36, 5, 2, 18, 0, ''),
(73, 4, 2, 3, 25, ''),
(76, 5, 2, 3, 200, ''),
(83, 11, 10, 3, 550, ''),
(112, 12, 2, 4, 15, ''),
(114, 6, 3, 3, 3000, ''),
(141, 13, 2, 3, 150, ''),
(142, 13, 2, 4, 14, ''),
(144, 13, 2, 18, 0, ''),
(228, 14, 2, 3, 0, ''),
(229, 14, 2, 4, 0, ''),
(230, 14, 2, 18, 0, ''),
(248, 14, 2, 17, 19, ''),
(249, 15, 2, 3, 300, ''),
(250, 15, 2, 4, 0, ''),
(252, 15, 2, 18, 0, ''),
(253, 16, 2, 3, 0, ''),
(254, 16, 2, 4, 0, ''),
(255, 16, 2, 17, 19, ''),
(256, 16, 2, 18, 0, ''),
(257, 22, 2, 3, 0, ''),
(258, 22, 2, 4, 0, ''),
(259, 22, 2, 17, 21, ''),
(260, 22, 2, 18, 0, ''),
(261, 23, 2, 3, 0, ''),
(262, 23, 2, 4, 0, ''),
(264, 23, 2, 18, 0, ''),
(266, 23, 2, 17, 21, ''),
(269, 4, 2, 7, 200, ''),
(270, 4, 2, 6, 20, ''),
(271, 4, 2, 5, 40, ''),
(280, 5, 2, 7, 150, ''),
(281, 5, 2, 6, 35, ''),
(282, 5, 2, 5, 85, ''),
(292, 12, 2, 18, 0, ''),
(293, 12, 2, 3, 250, ''),
(294, 12, 2, 7, 20, ''),
(295, 12, 2, 6, 10, ''),
(296, 12, 2, 5, 10, ''),
(298, 13, 2, 7, 80, ''),
(299, 13, 2, 6, 30, ''),
(300, 13, 2, 5, 20, ''),
(308, 4, 2, 17, 19, ''),
(309, 4, 2, 17, 21, ''),
(310, 5, 2, 17, 20, ''),
(311, 5, 2, 17, 21, ''),
(312, 12, 2, 17, 19, ''),
(315, 13, 2, 17, 19, ''),
(316, 6, 3, 7, 30, ''),
(317, 6, 3, 6, 40, ''),
(318, 6, 3, 5, 50, ''),
(319, 11, 10, 7, 60, ''),
(320, 11, 10, 6, 60, ''),
(321, 11, 10, 5, 100, ''),
(323, 15, 2, 7, 50, ''),
(324, 15, 2, 6, 50, ''),
(325, 15, 2, 5, 50, ''),
(326, 15, 2, 17, 19, '');

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
  `discminmargval` decimal(10,2) NOT NULL DEFAULT 0.00
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
-- Структура таблицы `mnbv_menu`
--

DROP TABLE IF EXISTS `mnbv_menu`;
CREATE TABLE `mnbv_menu` (
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
  `lang` varchar(20) NOT NULL DEFAULT '',
  `nologin` tinyint(1) NOT NULL DEFAULT 0,
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_menu`
--

INSERT INTO `mnbv_menu` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `lang`, `nologin`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 0, 104, 0, 'Меню', 'Menu', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280944, 2, 1482151687, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, ''),
(2, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 2, 0, 'Интранет', 'Intranet', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280969, 2, 1504691818, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню1 (Основная навигация)', 'Site', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481281008, 2, 1502182934, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', 'all', 0, '', 2, ''),
(4, '2017-08-08 12:58:11', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню2 (Дополнительная навигация)', '', '', '', 0, '', '', '', '', 1502182691, 0, 0, 2, 1502182691, 2, 1618923438, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(5, '2017-08-08 12:58:31', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню3 (резерв)', '', '', '', 0, '', '', '', '', 1502182711, 0, 0, 2, 1502182711, 2, 1618923574, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(6, '2017-08-08 12:58:35', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню4 (резерв)', '', '', '', 0, '', '', '', '', 1502182715, 0, 0, 2, 1502182715, 2, 1502182729, '127.0.0.1', 'Администратор', '', '', '', '', '', 'all', 0, '', 0, ''),
(7, '2017-08-08 12:58:42', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню5 (резерв)', '', '', '', 0, '', '', '', '', 1502182722, 0, 0, 2, 1502182722, 2, 1502182722, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(8, '2017-08-08 12:58:56', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню6 (резерв)', '', '', '', 0, '', '', '', '', 1502182736, 0, 0, 2, 1502182736, 2, 1502182736, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(9, '2017-08-08 12:59:02', 1, 100, 1, '', 1, 0, 104, 0, 'Сайт - меню7 (резерв)', '', '', '', 0, '', '', '', '', 1502182742, 0, 0, 2, 1502182742, 2, 1502182742, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, ''),
(104, '0000-00-00 00:00:00', 2, 10, 0, '', 1, 200, 2, 0, 'Хранилища', 'Storages', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1482151565, 2, 1504691825, '127.0.0.1', 'Администратор', '{\"controller\":\"Storage\",\"url\":\"\\/intranet\\/storage\"}', '', '', '', '[\"1\",\"2\"]', 'all', 0, '', 0, ''),
(105, '0000-00-00 00:00:00', 2, 20, 0, '', 1, 200, 2, 0, 'Выход', 'Exit', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1482151572, 2, 1504691827, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\\/auth\\/?act=logout\",\"controller\":\"Auth\"}', '', '', '', '', 'all', 0, '', 0, ''),
(107, '0000-00-00 00:00:00', 3, 1000, 0, '', 0, 0, 104, 0, 'Интранет', 'Intranet', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1482152422, 2, 1621323070, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\"}', '', '', '', '', 'en', 0, '', 0, ''),
(108, '2017-08-07 16:35:45', 2, 30, 0, '', 1, 0, 2, 0, 'Авторизация', 'Login', '', '', 0, '', '', '', '', 1502109345, 0, 0, 2, 1502109345, 2, 1504691828, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\\/auth\",\"controller\":\"Auth\"}', '', '', '', '', 'all', 1, '', 0, ''),
(109, '2017-08-23 11:37:13', 3, 10, 0, '', 1, 0, 104, 0, 'О нас', 'About', '', '', 0, '', '', '', '', 1503473833, 0, 0, 2, 1503473833, 2, 1618783754, '127.0.0.1', 'Администратор', '{\"url\":\"\\/about\",\"objid\":2}', '', '', '', '', 'ru', 0, '', 0, ''),
(110, '2017-08-23 11:37:21', 4, 20, 0, '', 1, 0, 104, 0, 'Каталог', 'Catalog', '', '', 0, '', '', '', '', 1503473841, 0, 0, 2, 1503473841, 2, 1618944933, '127.0.0.1', 'Администратор', '{\"url\":\"\\/catalog\",\"objid\":5}', '', '', '', '', 'ru', 0, '', 0, ''),
(111, '2017-08-23 11:37:35', 3, 40, 0, '', 1, 0, 104, 0, 'Контакты', 'Contacts', '', '', 0, '', '', '', '', 1503473855, 0, 0, 2, 1503473855, 2, 1504202233, '127.0.0.1', 'Администратор', '{\"url\":\"\\/contacts\",\"objid\":6}', '', '', '', '', 'ru', 0, '', 0, ''),
(112, '2017-08-23 11:37:56', 3, 60, 0, '', 1, 0, 104, 0, 'Авторизация', 'Login', '', '', 0, '', '', '', '', 1503473876, 0, 0, 2, 1503473876, 2, 1504388360, '127.0.0.1', 'Администратор', '{\"url\":\"\\/auth\",\"objid\":7}', '', '', '', '', 'ru', 0, '', 0, ''),
(113, '2017-08-24 16:44:53', 3, 1001, 0, '', 0, 0, 104, 0, 'Intranet', 'Intranet', '', '', 0, '', '', '', '', 1503578693, 0, 0, 2, 1503578693, 2, 1621323110, '127.0.0.1', 'Администратор', '{\"url\":\"\\/intranet\",\"altlang\":1}', '', '', '', '', 'en', 0, '', 0, ''),
(114, '2017-08-24 16:44:59', 3, 11, 0, '', 1, 0, 104, 0, 'About', 'About', '', '', 0, '', '', '', '', 1503578699, 0, 0, 2, 1503578699, 2, 1621324814, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/about\",\"objid\":2}', '', '', '', '', 'en', 0, '', 0, ''),
(115, '2017-08-24 16:45:06', 4, 21, 0, '', 1, 0, 104, 0, 'Catalog', 'Catalog', '', '', 0, '', '', '', '', 1503578706, 0, 0, 2, 1503578706, 2, 1621324868, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/catalog\",\"objid\":5}', '', '', '', '', 'en', 0, '', 0, ''),
(116, '2017-08-24 16:45:11', 3, 41, 0, '', 1, 0, 104, 0, 'Contacts', 'Contacts', '', '', 0, '', '', '', '', 1503578711, 0, 0, 2, 1503578711, 2, 1621324820, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/contacts\",\"objid\":6}', '', '', '', '', 'en', 0, '', 0, ''),
(117, '2017-08-24 16:45:16', 3, 61, 0, '', 1, 0, 104, 0, 'Login', 'Login', '', '', 0, '', '', '', '', 1503578716, 0, 0, 2, 1503578716, 2, 1621324831, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/auth\",\"objid\":7}', '', '', '', '', 'en', 0, '', 0, ''),
(118, '2017-08-25 18:26:19', 3, 31, 0, '', 0, 0, 104, 0, 'Папка', 'Folder', '', '', 0, '', '', '', '', 1503671179, 0, 0, 2, 1503671179, 2, 1505506154, '127.0.0.1', 'Администратор', '{\"url\":\"\\/sitefolder\",\"objid\":8}', '', '', '', '', 'ru', 0, '', 0, ''),
(119, '2017-08-25 18:27:19', 3, 31, 0, '', 0, 0, 104, 0, 'Folder', 'Folder', '', '', 0, '', '', '', '', 1503671239, 0, 0, 2, 1503671239, 2, 1621324837, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/sitefolder\",\"objid\":8}', '', '', '', '', 'en', 0, '', 0, ''),
(120, '2017-09-02 21:29:44', 3, 50, 0, '', 0, 0, 104, 0, 'Корзина', 'Cart', '', '', 0, '', '', '', '', 1504373384, 0, 0, 2, 1504373384, 2, 1621323989, '127.0.0.1', 'Администратор', '{\"objid\":14,\"url\":\"\\/cart\"}', '', '', '', '', 'ru', 0, '', 0, ''),
(121, '2017-09-02 21:29:53', 3, 51, 0, '', 0, 0, 104, 0, 'Cart', 'Cart', '', '', 0, '', '', '', '', 1504373393, 0, 0, 2, 1504373393, 2, 1621324845, '127.0.0.1', 'Администратор', '{\"objid\":14,\"url\":\"\\/en\\/cart\"}', '', '', '', '', 'en', 0, '', 0, ''),
(130, '2017-09-16 00:08:16', 4, 30, 0, '', 1, 0, 104, 0, 'Акции', 'Actions', '', '', 0, '', '', '', '', 1505506096, 0, 0, 2, 1505506096, 2, 1621323923, '127.0.0.1', 'Администратор', '{\"url\":\"\\/actions\",\"objid\":15}', '', '', '', '', 'ru', 0, '', 2, ''),
(131, '2017-09-16 00:08:22', 4, 30, 0, '', 1, 0, 104, 0, 'Actions', 'Actions', '', '', 0, '', '', '', '', 1505506102, 0, 0, 2, 1505506102, 2, 1621324875, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/actions\",\"objid\":15}', '', '', '', '', 'en', 0, '', 2, ''),
(132, '2021-04-18 22:41:33', 3, 30, 0, '', 1, 0, 104, 0, 'Доставка', 'Delivery', '', '', 0, '', '', '', '', 1618774893, 0, 0, 2, 1618774893, 2, 1618924068, '127.0.0.1', 'Администратор', '{\"url\":\"\\/delivery\",\"objid\":17}', '', '', '', '', 'ru', 0, '', 2, ''),
(133, '2021-04-18 22:41:44', 3, 31, 0, '', 1, 0, 104, 0, 'Delivery', 'Delivery', '', '', 0, '', '', '', '', 1618774904, 0, 0, 2, 1618774904, 2, 1621324853, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/delivery\",\"objid\":17}', '', '', '', '', 'en', 0, '', 2, ''),
(134, '2021-04-19 16:29:58', 4, 100, 0, '', 1, 0, 104, 0, 'Новости', 'News', '', '', 0, '', '', '', '', 1618838998, 0, 0, 2, 1618838998, 2, 1618923990, '127.0.0.1', 'Администратор', '{\"url\":\"\\/news\",\"objid\":4}', '', '', '', '', 'ru', 0, '', 2, ''),
(135, '2021-04-19 16:30:11', 4, 100, 0, '', 1, 0, 104, 0, 'News', 'News', '', '', 0, '', '', '', '', 1618839011, 0, 0, 2, 1618839011, 2, 1621324882, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/news\",\"objid\":4}', '', '', '', '', 'en', 0, '', 2, ''),
(136, '2021-04-19 16:30:49', 4, 100, 0, '', 1, 0, 104, 0, 'Статьи', 'Articles', '', '', 0, '', '', '', '', 1618839049, 0, 0, 2, 1618839049, 2, 1618924001, '127.0.0.1', 'Администратор', '{\"url\":\"\\/articles\",\"objid\":3}', '', '', '', '', 'ru', 0, '', 2, ''),
(137, '2021-04-19 16:30:55', 4, 100, 0, '', 1, 0, 104, 0, 'Articles', 'Articles', '', '', 0, '', '', '', '', 1618839055, 0, 0, 2, 1618839055, 2, 1621324888, '127.0.0.1', 'Администратор', '{\"url\":\"\\/en\\/articles\",\"objid\":3}', '', '', '', '', 'en', 0, '', 2, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_messages`
--

DROP TABLE IF EXISTS `mnbv_messages`;
CREATE TABLE `mnbv_messages` (
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
  `userid` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL DEFAULT '',
  `from_fio` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_messages`
--

INSERT INTO `mnbv_messages` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `userid`, `email`, `from_fio`, `phone`) VALUES
(1, '2017-08-31 22:53:25', 0, 100, 1, '', 1, 117, 117, 0, 'Сообщения', '', '', '', 0, '', '', '', '', 1504205605, 0, 0, 2, 1504205605, 2, 1504205605, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', ''),
(2, '2017-08-31 22:53:36', 1, 100, 1, '', 1, 117, 117, 0, 'Контакты', '', '', '', 0, '', '', '', '', 1504205616, 0, 0, 2, 1504205616, 2, 1504205616, '127.0.0.1', 'Администратор', '', '', '', '', '[\"1\"]', '', 0, '', 0, '', '', '');

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
  `tags` varchar(255) NOT NULL DEFAULT ''
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
  `norm_partnumber` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_products`
--

INSERT INTO `mnbv_products` (`id`, `outid`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `price`, `oldprice`, `cost`, `ndspr`, `quantity`, `instock`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`, `vendor`, `prefix`, `prefixlang`, `model`, `partnumber`, `barcode`, `country`, `norm_search`, `norm_partnumber`) VALUES
(1, '', '1970-01-01 03:00:00', 0, 100, 1, '', 1, 0, 210, 0, 'Товары', 'Products', 'catalog', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005900, 2, 1622024047, '127.0.0.1', 'Администратор', '', '', '{\"1\":{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},\"2\":{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},\"3\":{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},\"4\":{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}}', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',1,,,,tovary,products,,', ''),
(2, '', '1970-01-01 03:00:00', 1, 10, 1, '', 1, 0, 210, 1, 'Категория1', 'Cat 1', 'folder1', '', 0, 'Тестовая категория с товарами. Тестовая категория с товарами.', 'Test product category. Test product category.', '<p>Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров.</p>\r\n<p>Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров. Статья, описывающая данную категорию товаров.</p>', '<p>About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. </p>\r\n<p>About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. About cat1. </p>', 0, 0, 0, 2, 1469005919, 2, 1622024083, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '[{\"attrid\":\"4\",\"pozid\":500,\"namelang\":\"Town\",\"namedlang\":\"\\u0413\\u043e\\u0440\\u043e\\u0434\",\"infilter\":1,\"name\":\"\\u0413\\u043e\\u0440\\u043e\\u0434\",\"dnuse\":1},{\"objid\":2,\"attrid\":\"17\",\"namedlang\":\"\\u041b\\u0438\\u0441\\u0442\",\"namelang\":\"List\",\"pozid\":500,\"infilter\":1,\"name\":\"\\u041b\\u0438\\u0441\\u0442\",\"dnuse\":1},{\"objid\":2,\"attrid\":\"18\",\"pozid\":700,\"namedlang\":\"\\u0420\\u0430\\u0434\\u0438\\u043e\",\"namelang\":\"Radio\",\"infilter\":1,\"name\":\"\\u0420\\u0430\\u0434\\u0438\\u043e\",\"dnuse\":1}]', '{\"attr3\":\"0.00\"}', '[\"1\"]', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/folder1.png\",\"type\":\"png\",\"edituser\":\"2\",\"editdate\":1618838392,\"editip\":\"127.0.0.1\"}}}', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, 'Товары синхрофазотроны', '', '', '', '', 0, ',2,,,,kategoriya1,cat 1,tovary sinhrofazotrony,', ''),
(3, '', '1970-01-01 03:00:00', 1, 20, 1, '', 1, 0, 210, 0, 'Категория2', 'Cat 2', 'folder2', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005940, 2, 1622011239, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/folder1.png\",\"type\":\"png\",\"edituser\":\"2\",\"editdate\":1618838309,\"editip\":\"127.0.0.1\"}}}', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, 'Товары плазматроны', '', '', '', '', 0, ',kategoriya2,cat 2,tovary plazmatrony,', ''),
(4, '', '1970-01-01 03:00:00', 2, 100, 0, '', 1, 0, 210, 1, 'Товар1_1', 'Prod1_1', 'tovar1_1', '', 0, 'краткое описание товара1', 'Mini product 1 description.', '<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>\r\n<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара. &nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>\r\n<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>', '<p>Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. </p>\r\n<p>Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. </p>\r\n<p>Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. </p>', 1502838000, 0, 0, 2, 1469005946, 2, 1622013425, '127.0.0.1', 'Администратор', '', '', '', '{\"attr2\":8,\"attr4\":12,\"attr3\":25,\"attr17\":\"[\\\"19\\\",\\\"21\\\"]\",\"attr18\":\"22\",\"attr25\":\"ddd\",\"attr7\":200,\"attr6\":20,\"attr5\":40}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":129,\"w\":600,\"h\":337,\"min\":{\"kb\":3,\"w\":40,\"h\":22},\"big\":{\"kb\":449,\"w\":1366,\"h\":768}},\"type\":\"jpg\",\"fname\":\"anypics.ru-1668.jpg\",\"edituser\":\"2\",\"editdate\":1618954393,\"upldate\":1618954393,\"editip\":\"127.0.0.1\"},\"2\":{\"size\":{\"kb\":196,\"w\":600,\"h\":375,\"min\":{\"kb\":3,\"w\":40,\"h\":25},\"big\":{\"kb\":975,\"w\":1638,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"art-loyvet-pierre-robot.jpg\",\"edituser\":\"2\",\"editdate\":1618954397,\"upldate\":1618954397,\"editip\":\"127.0.0.1\"},\"3\":{\"size\":{\"kb\":301,\"w\":600,\"h\":480,\"min\":{\"kb\":3,\"w\":37,\"h\":30},\"big\":{\"kb\":922,\"w\":1280,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"Many-strawberries-red-fruit-delicious_1280x1024.jpg\",\"edituser\":\"2\",\"editdate\":1618954406,\"upldate\":1618954406,\"editip\":\"127.0.0.1\"}}}', 0, '', '200.00', '250.00', '100.00', '0.00', 10, 1, '0.00', '0.00', '0.00', '0.00', 2, 'Синхрофазотрон', '', 'm11', 'PRD-4', '1234567890004', 3, ',4,1234567890004,prd4,m11,tovar11,prod11,sinhrofazotron,', 'prd4'),
(5, '', '0000-00-00 00:00:00', 2, 100, 0, '', 1, 0, 210, 1, 'Товар1_2', 'Prod1_2', 'tovar1_2', '', 0, 'Краткое описание товара 2', 'Mini product 2 description.', '<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>\r\n<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара. &nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>\r\n<p>Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.&nbsp;Текстовое описание товара.</p>', '<p>Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. </p>\r\n<p>Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. </p>\r\n<p>Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. Text about this product. </p>', 1501542000, 0, 0, 2, 1469005950, 2, 1622013443, '127.0.0.1', 'Администратор', '', '', '', '{\"attr2\":9,\"attr3\":200,\"attr4\":13,\"attr17\":\"[\\\"20\\\",\\\"21\\\"]\",\"attr25\":\"mmm\",\"attr7\":150,\"attr6\":35,\"attr5\":85}', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/pAgnJDJN4VA\",\"type\":null,\"edituser\":\"2\",\"editdate\":1506609585,\"editip\":\"127.0.0.1\"},\"2\":{\"size\":{\"kb\":196,\"w\":600,\"h\":375,\"min\":{\"kb\":3,\"w\":40,\"h\":25},\"big\":{\"kb\":975,\"w\":1638,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"art-loyvet-pierre-robot.jpg\",\"edituser\":\"2\",\"editdate\":1618954335,\"upldate\":1618954335,\"editip\":\"127.0.0.1\"},\"3\":{\"size\":{\"kb\":129,\"w\":600,\"h\":337,\"min\":{\"kb\":3,\"w\":40,\"h\":22},\"big\":{\"kb\":449,\"w\":1366,\"h\":768}},\"type\":\"jpg\",\"fname\":\"anypics.ru-1668.jpg\",\"edituser\":\"2\",\"editdate\":1618954345,\"upldate\":1618954345,\"editip\":\"127.0.0.1\"}}}', 0, '', '220.00', '0.00', '0.00', '0.00', 5, 3, '0.00', '0.00', '0.00', '0.00', 2, 'Гипердрайв', '', 'm2', 'PRD-5', '1234567890005', 3, ',5,1234567890005,prd5,m2,tovar12,prod12,giperdrayv,', 'prd5'),
(6, '', '0000-00-00 00:00:00', 3, 100, 0, '', 1, 0, 210, 0, 'Зеленый пирожок', 'Prod2_1', 'zelenyy-pirozhok', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005958, 2, 1622026211, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":3000,\"attr7\":30,\"attr6\":40,\"attr5\":50}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":231,\"w\":600,\"h\":397,\"min\":{\"kb\":3,\"w\":40,\"h\":26},\"big\":{\"kb\":682,\"w\":1280,\"h\":849}},\"type\":\"jpg\",\"fname\":\"1562069960_6.jpg\",\"edituser\":\"2\",\"editdate\":1621010702,\"upldate\":1621010702,\"editip\":\"127.0.0.1\"}}}', 0, '', '500.00', '600.00', '300.00', '0.00', 10, 1, '0.00', '0.00', '0.00', '0.00', 2, 'Плазматрон', '', 'm6', 'PRD-6', '1234567890006', 3, ',6,1234567890006,prd6,m6,zelenyy pirozhok,prod21,plazmatron,', 'prd6'),
(7, '', '0000-00-00 00:00:00', 3, 100, 0, '', 1, 0, 210, 0, 'Красный помидор огородный', 'Prod2_2', 'tovar2_2', '', 0, '', '', '', '', 0, 0, 0, 2, 1469005963, 2, 1621893650, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '470.00', '0.00', '0.00', '0.00', 0, 4, '0.00', '0.00', '0.00', '0.00', 0, 'Овощь', '', 'm7', 'PRD-7', '', 0, '7prd7,m7,krasnyy pomidor ogorodnyy,prod22,ovosch,', 'prd7'),
(8, '', '0000-00-00 00:00:00', 1, 30, 1, '', 1, 0, 210, 0, 'Категория3', 'Cat 3', 'folder3', '', 0, '', '', '', '', 0, 0, 0, 2, 1470732688, 2, 1622019297, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/folder1.png\",\"type\":\"png\",\"edituser\":\"2\",\"editdate\":1618838322,\"editip\":\"127.0.0.1\"}}}', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',8,,,,kategoriya3,cat 3,,', ''),
(9, '', '1970-01-01 03:00:00', 8, 100, 1, '', 1, 0, 210, 0, 'CatCat 3', '', 'folder3/catcat3', '', 0, '', '', '', '', 0, 0, 0, 2, 1470732716, 2, 1622011254, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\",\"8\"]', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/folder1.png\",\"type\":\"png\",\"edituser\":\"2\",\"editdate\":1618838332,\"editip\":\"127.0.0.1\"}}}', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',catcat 3,,,', ''),
(10, '', '0000-00-00 00:00:00', 9, 100, 1, '', 1, 0, 210, 0, 'CatCatCat3', '', 'folder3/catcat3/folder3/catcatcat3', '', 0, '', '', '', '', 0, 0, 0, 2, 1470833797, 2, 1622011263, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\",\"8\",\"9\"]', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/folder1.png\",\"type\":\"png\",\"edituser\":\"2\",\"editdate\":1618838341,\"editip\":\"127.0.0.1\"}}}', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',catcatcat3,,,', ''),
(11, '', '2021-03-17 20:10:49', 10, 100, 0, '', 1, 0, 210, 0, 'Дальний товар', 'Prodfar', '', '', 0, '', '', '', '', 1616001000, 0, 0, 2, 1616001049, 2, 1622024311, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":550,\"attr17\":\"[\\\"19\\\",\\\"20\\\"]\",\"attr7\":60,\"attr6\":60,\"attr5\":100}', '', '', 0, '', '100.00', '200.00', '50.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',11,,,,dalniy tovar,prodfar,,', ''),
(12, '', '2021-04-18 21:39:20', 2, 100, 0, '', 1, 0, 210, 1, 'Товар1_3', 'Prod1_3', 'tovar1_3', '', 0, 'ыыы', '', '<p>ыыыыыы</p>', '', 1618771140, 0, 0, 2, 1618771160, 2, 1622013470, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":250,\"attr4\":15,\"attr17\":\"[\\\"19\\\"]\",\"attr7\":20,\"attr6\":10,\"attr5\":10}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":196,\"w\":600,\"h\":375,\"min\":{\"kb\":3,\"w\":40,\"h\":25},\"big\":{\"kb\":975,\"w\":1638,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"art-loyvet-pierre-robot.jpg\",\"edituser\":\"2\",\"editdate\":1618771356,\"upldate\":1618771356,\"editip\":\"127.0.0.1\"}}}', 0, '', '300.00', '350.00', '150.00', '0.00', 0, 4, '0.00', '0.00', '0.00', '0.00', 2, '', '', 'm3', '', '', 3, ',12,,,m3,tovar13,prod13,,', ''),
(13, '', '2021-04-18 21:39:42', 2, 100, 0, '', 1, 0, 210, 1, 'Товар1_4', 'Prod1_4', 'tovar1_4', '', 0, '', '', '', '', 1618771140, 0, 0, 2, 1618771182, 2, 1622013656, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":150,\"attr4\":14,\"attr17\":\"[\\\"19\\\"]\",\"attr7\":80,\"attr6\":30,\"attr5\":20}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":116,\"w\":600,\"h\":337,\"min\":{\"kb\":2,\"w\":40,\"h\":22},\"big\":{\"kb\":817,\"w\":1820,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"298463-Sepik.jpg\",\"edituser\":\"2\",\"editdate\":1618772223,\"upldate\":1618772223,\"editip\":\"127.0.0.1\"}}}', 0, '', '500.00', '600.00', '300.00', '0.00', 1, 2, '0.00', '0.00', '0.00', '0.00', 2, '', '', '', '', '', 3, ',13,,,,tovar14,prod14,,', ''),
(14, '', '2021-04-18 21:39:45', 2, 100, 0, '', 1, 0, 210, 0, 'Товар1_5', 'Prod1_5', 'tovar1_5', '', 0, 'ddd', '', '<p>ddd</p>', '', 1618771140, 0, 0, 2, 1618771185, 2, 1621891418, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":\"0.00\",\"attr17\":\"[\\\"19\\\"]\"}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":156,\"w\":600,\"h\":449,\"min\":{\"kb\":3,\"w\":40,\"h\":29},\"big\":{\"kb\":567,\"w\":1365,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"beaverknife-grandpa.jpg\",\"edituser\":\"2\",\"editdate\":1618772280,\"upldate\":1618772280,\"editip\":\"127.0.0.1\"}}}', 0, '', '340.00', '400.00', '200.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 3, '', '', '', '', '', 2, '14,,tovar15,prod15,,', ''),
(15, '', '2021-04-18 21:39:48', 2, 100, 0, '', 1, 0, 210, 0, 'Товар1_6', 'Prod1_6', 'tovar1_6', '', 0, 'ddd', '', '<p>ddd</p>', '', 1618771140, 0, 0, 2, 1618771188, 2, 1622026184, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":300,\"attr17\":\"[\\\"19\\\"]\",\"attr7\":50,\"attr6\":50,\"attr5\":50}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":215,\"w\":351,\"h\":600,\"min\":{\"kb\":2,\"w\":17,\"h\":30},\"big\":{\"kb\":424,\"w\":564,\"h\":962}},\"type\":\"jpg\",\"fname\":\"18c705560fa84ee7d5b73bc598a2263a.jpg\",\"edituser\":\"2\",\"editdate\":1618772413,\"upldate\":1618772413,\"editip\":\"127.0.0.1\"}}}', 0, '', '245.00', '200.00', '120.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 4, '', '', '', '', '', 4, ',15,,,,tovar16,prod16,,', ''),
(16, '', '2021-04-18 21:59:40', 2, 100, 0, '', 1, 0, 210, 0, 'Товар1_7', 'Prod1_7', 'tovar1_7', '', 0, 'ccc', '', '<p>ccc</p>', '', 1618772340, 0, 0, 2, 1618772380, 2, 1621891434, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":\"0.00\",\"attr17\":\"[\\\"19\\\"]\"}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":183,\"w\":486,\"h\":600,\"min\":{\"kb\":2,\"w\":24,\"h\":30},\"big\":{\"kb\":102,\"w\":561,\"h\":692}},\"type\":\"png\",\"fname\":\"zamok.png\",\"edituser\":\"2\",\"editdate\":1618772401,\"upldate\":1618772401,\"editip\":\"127.0.0.1\"}}}', 0, '', '356.00', '333.00', '222.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 2, '', '', '', '', '', 3, '16,,tovar17,prod17,,', ''),
(17, '', '2021-04-19 09:12:17', 1, 40, 1, '', 1, 0, 210, 0, 'Категория4', 'Cat 4', 'folder4', '', 0, '', '', '', '', 1618812720, 0, 0, 2, 1618812737, 2, 1622011270, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '{\"img\":{\"1\":{\"url\":\"\\/src\\/bsdefsite2\\/img\\/folder1.png\",\"type\":\"png\",\"edituser\":\"2\",\"editdate\":1618838358,\"editip\":\"127.0.0.1\"}}}', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',kategoriya4,cat 4,,', ''),
(18, '', '2021-04-19 09:12:33', 1, 50, 1, '', 1, 0, 210, 0, 'Категория5', 'Cat 5', '', '', 0, '', '', '', '', 1618812720, 0, 0, 2, 1618812753, 2, 1622011278, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',kategoriya5,cat 5,,', ''),
(19, '', '2021-04-19 09:12:42', 1, 60, 1, '', 1, 0, 210, 0, 'Категория6', 'Cat 6', 'folder6', '', 0, '', '', '', '', 1618812720, 0, 0, 2, 1618812762, 2, 1622011288, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',kategoriya6,cat 6,,', ''),
(20, '', '2021-04-20 23:45:25', 1, 70, 1, '', 1, 0, 210, 0, 'Категория7', 'Cat 7', 'folder7', '', 0, '', '', '', '', 1618951500, 0, 0, 2, 1618951525, 2, 1622011290, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',kategoriya7,cat 7,,', ''),
(21, '', '2021-04-20 23:45:38', 1, 80, 1, '', 1, 0, 210, 0, 'Категория8', 'Cat 8', 'folder8', '', 0, '', '', '', '', 1618951500, 0, 0, 2, 1618951538, 2, 1622011292, '127.0.0.1', 'Администратор', '', '[{\"objid\":1,\"attrid\":\"3\",\"pozid\":10000,\"namelang\":\"Weight, g\",\"dnuse\":1,\"namedlang\":\"\\u0412\\u0435\\u0441\",\"infilter\":1,\"name\":\"\\u0412\\u0435\\u0441, \\u0433\"},{\"objid\":1,\"attrid\":\"7\",\"pozid\":10001,\"namedlang\":\"\\u041a\\u043e\\u043c\\u043c\\u0435\\u043d\\u0442\",\"namelang\":\"Height, sm\",\"name\":\"\\u0412\\u044b\\u0441\\u043e\\u0442\\u0430, \\u0441\\u043c\",\"dnuse\":1,\"infilter\":1},{\"objid\":1,\"attrid\":\"6\",\"name\":\"\\u0428\\u0438\\u0440\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Width, sm\",\"dnuse\":1,\"infilter\":1,\"pozid\":10002},{\"objid\":1,\"attrid\":\"5\",\"pozid\":10003,\"name\":\"\\u0414\\u043b\\u0438\\u043d\\u0430, \\u0441\\u043c\",\"namelang\":\"Length, sm\",\"dnuse\":1,\"infilter\":1}]', '', '', '[\"1\"]', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, ',kategoriya8,cat 8,,', ''),
(22, '', '2021-04-25 13:31:37', 2, 100, 0, '', 1, 0, 210, 0, 'Товар1_8', 'Prod1_8', 'tovar1_8', '', 0, '', '', '', '', 1619346660, 0, 0, 2, 1619346697, 2, 1621891451, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":\"0.00\",\"attr17\":\"[\\\"21\\\"]\"}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":231,\"w\":600,\"h\":397,\"min\":{\"kb\":3,\"w\":40,\"h\":26},\"big\":{\"kb\":682,\"w\":1280,\"h\":849}},\"type\":\"jpg\",\"fname\":\"1562069960_6.jpg\",\"edituser\":\"2\",\"editdate\":1619346732,\"upldate\":1619346732,\"editip\":\"127.0.0.1\"}}}', 0, '', '344.00', '566.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, '22,,tovar18,prod18,,', ''),
(23, '', '2021-04-25 13:34:50', 2, 100, 0, '', 1, 0, 210, 0, 'Товар1_9', 'Prod1_9', 'tovar1_9', '', 0, '', '', '', '', 1619346840, 0, 0, 2, 1619346890, 2, 1622012866, '127.0.0.1', 'Администратор', '', '', '', '{\"attr3\":\"0.00\",\"attr17\":\"[\\\"21\\\"]\"}', '', '{\"img\":{\"1\":{\"size\":{\"kb\":224,\"w\":600,\"h\":375,\"min\":{\"kb\":3,\"w\":40,\"h\":25},\"big\":{\"kb\":1336,\"w\":1638,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"wtkVBKz0M8-126.jpg\",\"edituser\":\"2\",\"editdate\":1619346909,\"upldate\":1619346909,\"editip\":\"127.0.0.1\"}}}', 0, '', '1000.00', '1200.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '1234567890023', 0, ',23,1234567890023,,,tovar19,prod19,,', ''),
(24, '', '2021-05-14 20:07:28', 17, 100, 0, '', 1, 0, 210, 0, 'Товар4_1', 'Prod4_1', '', '', 0, '', '', '', '', 1621012020, 0, 0, 2, 1621012048, 2, 1621891461, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '100.00', '0.00', '0.00', '0.00', 1, 2, '0.00', '0.00', '0.00', '0.00', 2, '', '', '', '', '', 3, '24,,tovar41,prod41,,', ''),
(25, '', '2021-05-16 16:50:36', 18, 100, 0, '', 1, 0, 210, 0, 'Товар5_1', 'Prod5_1', 'tovar5_1', '', 0, '', '', '', '', 1621173000, 0, 0, 2, 1621173036, 2, 1621891464, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00', 0, 0, '0.00', '0.00', '0.00', '0.00', 0, '', '', '', '', '', 0, '25,,tovar51,prod51,,', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_robots`
--

DROP TABLE IF EXISTS `mnbv_robots`;
CREATE TABLE `mnbv_robots` (
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
  `rbtype` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_robots`
--

INSERT INTO `mnbv_robots` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `rbtype`) VALUES
(1, '2017-09-21 17:54:27', 0, 100, 1, '', 1, 301, 2, 0, 'Роботы', 'Robots', '', '', 0, '', '', '', '', 1506002067, 0, 0, 2, 1506002067, 2, 1507725661, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', ''),
(2, '2017-09-28 21:19:58', 1, 10, 0, '', 1, 301, 2, 0, 'Таймер', 'Timer', 'timer', '', 0, '', '', '', '', 1506619198, 0, 0, 2, 1506619198, 2, 1525000946, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 'service'),
(3, '2017-10-03 23:43:54', 1, 10, 0, '', 1, 301, 2, 0, 'Тест крона', 'Cron test robot', 'crontest', '', 0, '', '', '', '', 1507059834, 0, 0, 2, 1507059834, 2, 1525000950, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 'service'),
(4, '2017-10-04 12:26:03', 1, 10, 0, '', 1, 301, 2, 0, 'Запуск кроновых скриптов', 'Start cron scripts', 'startcron', '', 0, '', '', '', '', 1507105563, 0, 0, 2, 1507105563, 2, 1525000953, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 'service'),
(5, '2017-10-04 17:21:14', 1, 10, 0, '', 1, 301, 2, 0, 'Мониторинг активных роботов', 'Robots activity monitor', 'robotsmonitor', '', 0, '', '', '', '', 1507123274, 0, 0, 2, 1507123274, 2, 1525000955, '127.0.0.1', 'Администратор', '{\"output\":\"\\/dev\\/null\"}', '', '', '', '', '', 0, '', 'service'),
(6, '2018-02-21 15:53:32', 1, 10, 0, '', 1, 301, 2, 0, 'Рестарт скриптов', 'Script restart', 'robotsrestart', '', 0, '', '', '', '', 1519217612, 0, 0, 2, 1519217612, 2, 1525000958, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 'service');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_robotsrun`
--

DROP TABLE IF EXISTS `mnbv_robotsrun`;
CREATE TABLE `mnbv_robotsrun` (
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
  `robot` int(11) NOT NULL DEFAULT 0,
  `runfile` varchar(255) NOT NULL DEFAULT '',
  `market` int(11) NOT NULL DEFAULT 0,
  `pair` int(11) NOT NULL DEFAULT 0,
  `marketkey` int(11) NOT NULL DEFAULT 0,
  `command` varchar(50) NOT NULL DEFAULT '',
  `status` varchar(50) NOT NULL DEFAULT '',
  `message` varchar(255) NOT NULL DEFAULT '',
  `sid` varchar(255) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT 0,
  `cronrun` int(1) NOT NULL DEFAULT 0,
  `rbtype` varchar(50) NOT NULL DEFAULT '',
  `pairslist` varchar(255) NOT NULL DEFAULT '',
  `action` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_robotsrun`
--

INSERT INTO `mnbv_robotsrun` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `robot`, `runfile`, `market`, `pair`, `marketkey`, `command`, `status`, `message`, `sid`, `pid`, `cronrun`, `rbtype`, `pairslist`, `action`) VALUES
(1, '2017-09-21 17:53:13', 0, 100, 1, '', 1, 301, 305, 0, 'Задания роботов', 'Robots run', '', '', 0, 'Cron записи\r\n* * * * * выполняемая команда\r\n- - - - -\r\n| | | | |\r\n| | | | ----- День недели (0 - 7) (Воскресенье =0 или =7)\r\n| | | ------- Месяц (1 - 12)\r\n| | --------- День (1 - 31)\r\n| ----------- Час (0 - 23)\r\n------------- Минута (0 - 59)', '', '', '', 1506001993, 0, 0, 2, 1506001993, 2, 1507725682, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', 0, 0, 0, '', '', '', '', 0, 0, '0', '', ''),
(2, '2017-09-28 21:20:59', 1, 100, 0, '', 1, 301, 305, 0, 'Таймер', 'Timer', '', '', 0, 'Это робот таймер.\r\nОн выводит строки времени в лог.\r\nНужен для тестирования работы системы.', 'It is timer robot.\r\nIt print time string to log.', '', '', 1506619259, 0, 0, 2, 1506619259, 2, 1525000474, '127.0.0.1', 'Администратор', '{\"script\":\"php start_robot.php robot=timer proc=5 rsid=143b8b0a4d0a997d85c9cd19c462ec3a\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p5_1.txt\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"output.txt\"}}}', 0, '', 2, '', 0, 0, 0, '', '', '', '', 0, 0, 'service', '', ''),
(3, '2017-10-03 23:44:28', 1, 100, 0, '', 1, 301, 305, 0, 'Тест крона', 'Cron test robot', '', '', 0, 'Запускается по крону в каждый запуск оболочки, служит для теста оболочки', '', '', '', 1507059868, 0, 0, 2, 1507059868, 2, 1525000486, '127.0.0.1', 'Администратор', '{\"crmin\":\"*\",\"crhour\":\"*\",\"crday\":\"*\",\"crmonth\":\"*\",\"crweek\":\"*\",\"script\":\"php start_robot.php robot=crontest proc=6 rsid=3fdf4d535915584b327f70598dac6c0f\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p6_1.txt\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"\\u0437\\u0430\\u043f\\u0440\\u0435\\u0449\\u0435\\u043d\\u043d\\u044b\\u0435 \\u043a \\u044f\\u043d\\u0434\\u0435\\u043a\\u0441\\u0443 \\u0442\\u043e\\u0432\\u0430\\u0440\\u044b.txt\",\"size\":{\"kb\":19},\"edituser\":\"2\",\"editdate\":1507117819,\"upldate\":1507117819,\"editip\":\"127.0.0.1\",\"kb\":19}}}', 0, '', 3, '', 0, 0, 0, '', '', '', '', 0, 1, 'service', '', ''),
(4, '2017-10-04 12:26:51', 1, 100, 0, '', 1, 301, 305, 0, 'Запуск кроновых скриптов', 'Start cron scripts', '', '', 0, 'Запускает кроновые скрипты', '', '', '', 1507105611, 0, 0, 2, 1507105611, 2, 1525000496, '127.0.0.1', 'Администратор', '{\"script\":\"php start_robot.php robot=startcron proc=7 rsid=60323eeefdbcbca15d1e5d77b1dbb313\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p7_1.txt\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"\\u0421\\u0442\\u0430\\u0442\\u0438\\u0441\\u0442\\u0438\\u043a\\u0430 \\u043f\\u043e \\u0432\\u044b\\u0442\\u044f\\u0436\\u043a\\u0430\\u043c.txt\",\"size\":{\"kb\":3},\"edituser\":\"2\",\"editdate\":1507119057,\"upldate\":1507119057,\"editip\":\"127.0.0.1\",\"kb\":3}}}', 0, '', 4, '', 0, 0, 0, '', '', '', '', 0, 0, 'service', '', ''),
(5, '2017-10-04 17:20:51', 1, 100, 0, '', 1, 301, 305, 0, 'Мониторинг активных роботов', 'Robots run monitor', '', '', 0, '', '', '', '', 1507123251, 0, 0, 2, 1507123251, 2, 1525000507, '127.0.0.1', 'Администратор', '{\"script\":\"php start_robot.php robot=robotsmonitor proc=8 rsid=4a100e66a2ec259303b3048c5515e331\",\"output\":\"\\/dev\\/null\"}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"output.txt\"}}}', 0, '', 5, '', 0, 0, 0, '', '', '', '', 0, 0, 'service', '', ''),
(6, '2018-02-21 16:04:50', 1, 100, 0, '', 1, 301, 305, 0, 'Рестарт умерших скриптов', 'Died scripts restart', '', '', 0, 'Некромант, оживляющий демонов)))', '', '', '', 1519218290, 0, 0, 2, 1519218290, 2, 1525000517, '127.0.0.1', 'Администратор', '{\"crmin\":\"*\",\"crhour\":\"*\",\"crday\":\"*\",\"crmonth\":\"*\",\"crweek\":\"*\",\"script\":\"php start_robot.php robot=robotsrestart proc=42 rsid=bd188f270e27cbcbde6b22d4839c6f6b\",\"output\":\"data\\/storage_files\\/zbrobotsrun\\/att\\/p42_1.txt\",\"always\":1}', '', '', '', '', '{\"att\":{\"1\":{\"type\":\"txt\",\"fname\":\"output.txt\"},\"2\":{\"type\":\"txt\",\"fname\":\"log.txt\"}}}', 0, '', 6, '', 0, 0, 0, '', '', '', '', 0, 1, 'service', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_site`
--

DROP TABLE IF EXISTS `mnbv_site`;
CREATE TABLE `mnbv_site` (
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
-- Дамп данных таблицы `mnbv_site`
--

INSERT INTO `mnbv_site` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '2017-08-08 12:49:06', 0, 100, 1, '', 1, 0, 102, 0, 'Демо интернет-магазин MNBV', 'MNBV demo online store', '', '', 0, '', '', '', '', 1502182140, 0, 0, 2, 1502182146, 2, 1621327137, '127.0.0.1', 'Администратор', '{\"tpl_file\":\"index.php\"}', '', '', '', '', '{\"img\":{\"2\":{\"size\":{\"kb\":225,\"w\":1288,\"h\":300},\"type\":\"jpg\",\"fname\":\"60-\\u0440\\u043e\\u043c\\u0430\\u0448\\u043a\\u0438-\\u043a\\u0430\\u0440\\u0442\\u0438\\u043d\\u043a\\u0438-\\u043a\\u0440\\u0430\\u0441\\u0438\\u0432\\u044b\\u0435.jpg\",\"edituser\":\"2\",\"editdate\":1618778526,\"upldate\":1618778526,\"editip\":\"127.0.0.1\"},\"3\":{\"size\":{\"kb\":301,\"w\":1288,\"h\":300,\"min\":{\"kb\":13,\"w\":100,\"h\":80},\"big\":{\"kb\":922,\"w\":1280,\"h\":1024}},\"type\":\"jpg\",\"fname\":\"Many-strawberries-red-fruit-delicious_1280x1024.jpg\",\"edituser\":\"2\",\"editdate\":1618778538,\"upldate\":1618778538,\"editip\":\"127.0.0.1\"},\"4\":{\"size\":{\"kb\":351,\"w\":1288,\"h\":300},\"type\":\"jpg\",\"fname\":\"beach-sea-coast-water-nature-outdoor-sand-ocean-shore-wave-summer-paradise-holiday-lifestyle-material-body-of-water-sunny-waves-happy-habitat-beach-sand-summer-fun-mudflat-wind-wave-646583.jpg\",\"edituser\":\"2\",\"editdate\":1618778556,\"upldate\":1618778556,\"editip\":\"127.0.0.1\"},\"5\":{\"size\":{\"kb\":346,\"w\":1288,\"h\":300},\"type\":\"jpg\",\"fname\":\"wtkVBKz0M8-126.jpg\",\"edituser\":\"2\",\"editdate\":1618778572,\"upldate\":1618778572,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(2, '2017-08-08 12:49:42', 1, 100, 0, '', 1, 0, 102, 0, 'О компании', 'About', 'about', '', 0, 'Информация о компании.', 'Put the information about your company here.', '<p>{{img-right:1}}</p>\r\n<h4>План по доработкам Интернет-Магазина:</h4>\r\n<ol>\r\n<li>Сделать поиск по товарам по нормализованному названию товара, акции, категории, идентификатору, коду товара (внутренний и учетный) сортировка по рейтингу. Фокус шаблона по-умолчанию - на поиске.</li>\r\n<li>Сделать добавление в корзину, оформление заказа. Отдельным трейтом сделать метод рассчета доставки. Коды товара (внутренний и учетный).</li>\r\n<li>Сделать формирование категорий, атрибутов, товаров, изображений из YML файла. Автоматическое определение типа атрибута для генерации фильтров.</li>\r\n<li>Сделать рейтинги полезности товаров по валовой прибыли, отклонению от центра. Сделать деление товаров на группы брендов от A- до C+, деление товаров по цене на 6 частей.</li>\r\n<li>Сделать рекомендательную систему: вы смотрели, похожие товары, сопутствующие товары, персональные рекомендации (на базе просмотренных товаров смотрим категории, которые смотрел пользователь, уровень бренда, квартиль цены и показываем ему пропорционально наиболее рейтинговые товары из этих категорий с коррекцией на уровень бренда +-1 и группы цены +-1. Сразу заложить аналитику CTR и влияние рекомендаций на продажи.</li>\r\n<li>Сделать отображение товаров в акциях, учет акционных скидок при формировании корзины и заказа. Отображение категории и товары, сделать брендзоны.</li>\r\n<li>Сделать баннерную систему.</li>\r\n<li>Аналитика, события, подключение счетчиков, в т.ч. отслеживание связи продаж товаров с переходами на соответствующие акции и баннеры в рамках сессии.</li>\r\n<li>Сделать обновление статусов наличия и цены из CSV или XML файла по крону. Заложить возможность дополнения каталога из YML файла поверх существующего.</li>\r\n<li>Доработать систему задач, интегрировать в нее прием заказов и входящие письма.</li>\r\n<li>Сделать онлайн оплату, интегрировать ее в систему задач, привязать к заказам.</li>\r\n<li>Ввести деление на регионы, статусы наличия и цены по ним, доработать вывод фидов с учетом регионов.</li>\r\n<li>Сделать механизм передачи заказов в учетную систему и механизм передачи пользователей со скидками из учетной системы на сайт.</li>\r\n<li>Сделать систему регистрации новых пользователей, подписку на рассылки разного рода и пуш уведомления.</li>\r\n<li>Внедрить КЛАДР и помощник ввода имен, валидацию имен и адресов.</li>\r\n<li>Внедрить автоматическое определение региона с автоустановкой (предварительно уточнив что правы).</li>\r\n<li>Доработать модуль SEO оптимизации (формирование метатегов по маскам для разных групп структурных элементов).</li>\r\n</ol>\r\n<p>&nbsp;</p>', '<p>{{img-right:1}}Hello! We are glad to sea you in this Demo Site!</p>\r\n<p>It cotsists of:</p>\r\n<ul>\r\n<li>structure of static pages,</li>\r\n<li>structure of news and articles,</li>\r\n<li>product catalog,</li>\r\n<li>contacts whith feedback  form,</li>\r\n<li>banners system,</li>\r\n<li>user login and personal account, </li>\r\n<li>discount system,</li>\r\n<li>events system,</li>\r\n<li>feeds generator,</li>\r\n<li>CMS,</li>\r\n<li>storage uploader</li>\r\n<li>catalog autocomplite.</li>\r\n</ul>\r\n<p>Select template and connect it to system.</p>\r\n<p>You can work whith multiple sites.</p>', 1502182140, 0, 0, 2, 1502182182, 2, 1621841692, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/mnbv\\/img\\/logo\\/smile.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1618779999,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(3, '2017-08-08 12:49:51', 1, 100, 0, '', 1, 0, 102, 0, 'Статьи', 'Articles', 'articles', '', 0, '', 'The articles list of the company.', '', '', 1502182140, 0, 0, 2, 1502182191, 2, 1621326393, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"list_sort\":\"date_desc\",\"script_storage\":\"articles\",\"script_folder\":\"1\",\"list_max_items\":2,\"script_tpl_file\":\"tpl_articleslist.php\",\"script_tpl2_file\":\"tpl_newsview.php\"}', '', '', '', '', '', 0, ''),
(4, '2017-08-08 12:50:05', 1, 100, 0, '', 1, 0, 102, 0, 'Новости', 'News', 'news', '', 0, 'Новинки компании - будте всегда в курсе!', 'The news list of the company. ', '<p>Новинки компании - будте всегда в курсе!</p>', '<p>The news list of the company.&nbsp;</p>', 1502182200, 0, 0, 2, 1502182205, 2, 1619479613, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"script_storage\":\"news\",\"script_folder\":\"1\",\"list_max_items\":6,\"list_sort\":\"date_desc\",\"script_tpl_file\":\"tpl_newslist.php\",\"script_tpl2_file\":\"tpl_newsview.php\"}', '', '', '', '', '', 0, ''),
(5, '2017-08-08 12:50:13', 1, 100, 0, '', 1, 0, 102, 0, 'Каталог', 'Catalog', 'catalog', '', 0, 'Каталог товаров, реализуемых компанией - найдите что-то полезное для себя!', 'Product catalog page.', '<p>Каталог товаров, реализуемых компанией - найдите что-то полезное для себя!</p>', '<p>Product catalog here.</p>', 1502182200, 0, 0, 2, 1502182213, 2, 1621342852, '127.0.0.1', 'Администратор', '{\"script\":\"products\",\"script_storage\":\"products\",\"script_folder\":\"1\",\"list_max_items\":8,\"scriptvalign\":1}', '', '', '', '', '', 0, ''),
(6, '2017-08-08 12:50:33', 1, 100, 0, '', 1, 0, 102, 0, 'Контакты', 'Contacts', 'contacts', '', 0, 'Контактная информация компании и форма обратной связи.', 'Contacts whith feedback  form.', '<p>Контакты для связи:</p>\r\n<ul>\r\n<li>Адрес ...,</li>\r\n<li>Телефон ...,</li>\r\n<li>E-mail ...,</li>\r\n<li>Skype ...</li>\r\n</ul>\r\n<p>Или оставьте сообщение ниже в форме обратной связи:</p>', '<p>Contacts:</p>\r\n<ul>\r\n<li>Address ...,</li>\r\n<li>Phone ...,</li>\r\n<li>E-mail ...,</li>\r\n<li>Skype ...</li>\r\n</ul>\r\n<p>You can send us the message by the feedback &nbsp;form on bottom.</p>', 1502182200, 0, 0, 2, 1502182233, 2, 1504212227, '127.0.0.1', 'Администратор', '{\"script\":\"contacts\",\"script_storage\":\"messages\",\"script_folder\":\"2\"}', '', '', '', '', '', 0, ''),
(7, '2017-08-08 12:52:12', 1, 100, 0, '', 1, 0, 102, 0, 'Авторизация', 'Login', 'auth', '', 0, 'Авторизация.', 'User ligin.', '', '', 1502182320, 0, 0, 2, 1502182332, 2, 1503590846, '127.0.0.1', 'Администратор', '{\"script\":\"auth\"}', '', '', '', '', '', 0, ''),
(8, '2017-08-24 23:04:47', 1, 100, 1, '', 1, 0, 102, 0, 'Раздел сайта', 'Site folder', 'sitefolder', '', 0, '', '', '<p>Описание папки</p>', '', 1503601440, 0, 0, 2, 1503601487, 2, 1503904025, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"site_tpl\":\"main\"}', '', '', '', '[\"1\"]', '', 0, ''),
(9, '2017-08-24 23:05:03', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 1 раздела сайта', 'Page1', 'folder_pg1', '', 0, 'Описание 1 страницы раздела', 'about pg1', '', '', 1503601500, 0, 0, 2, 1503601503, 2, 1522002373, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(10, '2017-08-24 23:05:11', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 2 раздела сайта', 'Page2', 'folder_pg2', '', 0, 'Описание 2 страницы раздела', 'about pg2', '', '', 1503601560, 0, 0, 2, 1503601511, 2, 1503752773, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/icdn.lenta.ru\\/images\\/2017\\/08\\/25\\/21\\/20170825214257584\\/pic_abb27da63dffc6fb1e6988663e41dd45.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1503688407,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(11, '2017-08-24 23:05:19', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 3 раздела сайта', 'Page3', '', '', 0, '', '', '<p>{{img-right:1}}</p>', '', 1503601620, 0, 0, 2, 1503601519, 2, 1503752778, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"https:\\/\\/youtu.be\\/xLDM32xJ6iY\",\"type\":null,\"edituser\":\"2\",\"editdate\":1503698049,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(12, '2017-08-25 23:24:56', 8, 100, 0, '', 1, 0, 102, 0, 'Страница 4 раздела сайта', 'Page4', '', '', 0, '', '', '', '', 1503688080, 0, 0, 2, 1503689096, 2, 1503845817, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(14, '2017-09-02 21:27:25', 1, 100, 0, '', 1, 0, 102, 0, 'Корзина', 'Cart', 'cart', '', 0, '', '', '', '', 1504373220, 0, 0, 2, 1504373245, 2, 1504373350, '127.0.0.1', 'Администратор', '{\"script\":\"cart\",\"script_folder\":\"1\"}', '', '', '', '', '', 0, ''),
(15, '2017-09-16 00:05:17', 1, 100, 0, '', 1, 0, 102, 0, 'Акции', 'Actions', 'actions', '', 0, '', '', '<p>Наши акции тут:</p>', '<p>Our actions is here:</p>', 1505505900, 0, 0, 2, 1505505917, 2, 1621590781, '127.0.0.1', 'Администратор', '{\"script\":\"pglist\",\"script_storage\":\"actions\",\"script_folder\":\"1\",\"list_sort\":\"pozid\",\"list_max_items\":8,\"script_tpl2_file\":\"tpl_actionview.php\",\"script_tpl_file\":\"tpl_actionslist.php\"}', '', '', '', '', '', 0, ''),
(16, '2021-04-18 22:40:26', 1, 100, 0, '', 1, 0, 102, 0, 'Поиск', 'Search', 'search', '', 0, '', '', '', '', 1618774800, 0, 0, 2, 1618774826, 2, 1621877879, '127.0.0.1', 'Администратор', '{\"script\":\"search\",\"list_max_items\":6,\"scriptvalign\":1,\"script_folder\":\"1\"}', '', '', '', '', '', 0, ''),
(17, '2021-04-18 22:55:13', 1, 100, 0, '', 1, 0, 102, 0, 'Доставка', 'Delivery', 'delivery', '', 0, '', '', '{{img-right:1}}<p>Условия доставки будут размещены тут. Условия доставки будут размещены тут.Условия доставки будут размещены тут.Условия доставки будут размещены тут.Условия доставки будут размещены тут.Условия доставки будут размещены тут.Условия доставки будут размещены тут.Условия доставки будут размещены тут.</p>\r\n<p>Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. </p>\r\n<p>Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. Описание разных вариантов доставки. </p>', '', 1618775700, 0, 0, 2, 1618775713, 2, 1619788941, '127.0.0.1', 'Администратор', '', '', '', '', '', '{\"img\":{\"1\":{\"url\":\"\\/src\\/mnbv\\/img\\/logo\\/smile.jpg\",\"type\":\"jpg\",\"edituser\":\"2\",\"editdate\":1618926476,\"editip\":\"127.0.0.1\"}}}', 0, ''),
(18, '2021-04-19 00:08:47', 0, 100, 1, '', 0, 0, 102, 0, 'Служебные объекты', 'Service objects', '', '', 0, '', '', '', '', 1618780127, 0, 0, 2, 1618780127, 2, 1621324613, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, ''),
(19, '2021-04-19 00:09:05', 18, 100, 0, '', 0, 0, 102, 0, 'Описание компании для футора', 'Footer site text', '', '', 0, '', '', '<p>Добро пожаловать на демонстрационную версию сайта компании. Она включает основные элементы, которые необходимы полноценному информационному ресурсу, а именно:</p>\r\n<ul>\r\n<li>структуру статических страниц, удобное управление контентом,</li>\r\n<li>новости и статьи,</li>\r\n<li>каталог товаров, акции, корзина с формированием заказа,</li>\r\n<li>контакты с формой обратной связи,</li>\r\n<li>баннерная система,</li>\r\n<li>авторизация, контроль доступа к ресурсам, личный кабинет пользователя, </li>\r\n<li>система скидок для каталога товаров,</li>\r\n<li>система обработки событий (нужна для установки счетчиков и др. скриптов партнерских программ),</li>\r\n<li>систему выгрузки товарных фидов различных видов,</li>\r\n<li>система загрузки и синхронизации данных в хранилищах</li>\r\n<li>система автоматического формирования каталогов, свойств товара и при необходимости группировки их значений из XML фида с параметрами товара.</li>\r\n<li>система аналитики, позволяющая подключать счетчики основных систем, а также вести расширенный учет электронной торговли и влияния акций, баннеров и рекомендаций на продаж.</li>\r\n</ul>\r\n<p>Вы можете подключить любой выбранный вами шаблон дизайна и использовать несколько вариантов шаблонов дизайна одновременно, переключаясь между ними.</p>\r\n<p>Система поддерживает работу с несколькими сайтами, а также позволяет подключать разные варианты шаблонов отображения на разные доменные имена.</p>', '<p>Hello! We are glad to sea you in this Demo Site!</p>\r\n<p>It cotsists of:</p>\r\n<ul>\r\n<li>structure of static pages,</li>\r\n<li>structure of news and articles,</li>\r\n<li>product catalog,</li>\r\n<li>contacts whith feedback  form,</li>\r\n<li>banners system,</li>\r\n<li>user login and personal account, </li>\r\n<li>discount system,</li>\r\n<li>events system,</li>\r\n<li>feeds generator,</li>\r\n<li>CMS,</li>\r\n<li>storage uploader</li>\r\n<li>catalog autocomplite.</li>\r\n</ul>\r\n<p>Select template and connect it to system.</p>\r\n<p>You can work whith multiple sites.</p>', 1618780140, 0, 0, 2, 1618780145, 2, 1621340095, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_sites`
--

DROP TABLE IF EXISTS `mnbv_sites`;
CREATE TABLE `mnbv_sites` (
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
  `fullurl` int(1) NOT NULL DEFAULT 0,
  `domain` varchar(255) NOT NULL DEFAULT '',
  `maindomain` varchar(255) NOT NULL DEFAULT '',
  `cookiedomain` varchar(255) NOT NULL DEFAULT '',
  `protocol` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(255) NOT NULL DEFAULT '',
  `counters_arr` text NOT NULL DEFAULT '',
  `storage` varchar(255) NOT NULL DEFAULT '',
  `startid` int(11) NOT NULL DEFAULT 0,
  `canonical` varchar(255) NOT NULL DEFAULT '',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `amp_site` varchar(255) NOT NULL DEFAULT '',
  `filesdomain` varchar(255) NOT NULL DEFAULT '',
  `sorturl` int(1) NOT NULL DEFAULT 0,
  `pginurl` int(1) NOT NULL DEFAULT 0,
  `noindex` int(1) NOT NULL DEFAULT 0,
  `module` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_sites`
--

INSERT INTO `mnbv_sites` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `fullurl`, `domain`, `maindomain`, `cookiedomain`, `protocol`, `template`, `counters_arr`, `storage`, `startid`, `canonical`, `mobile`, `amp_site`, `filesdomain`, `sorturl`, `pginurl`, `noindex`, `module`) VALUES
(1, '2017-08-02 14:05:23', 0, 100, 1, '', 1, 0, 2, 0, 'Сайты', 'Sites', '', '', 0, '', '', '', '', 1501668323, 0, 0, 2, 1501668323, 2, 1501669023, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', '', '', '', '', '', 0, '', '', '', '', 0, 0, 0, ''),
(2, '2017-08-02 14:05:38', 1, 100, 0, '', 1, 0, 2, 1, 'Сайт по-умолчанию', 'Default site', '', '', 0, '', '', '', '', 1501668300, 0, 0, 2, 1501668338, 2, 1621250470, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, '', '', '', '0', 'defsite', '', 'site', 1, '', '', '', '', 0, 1, 0, ''),
(3, '2017-08-03 18:04:46', 1, 100, 0, '2', 1, 0, 2, 0, 'Демо версия сайта', 'Demo site', '', '', 0, '', '', '', '', 1501769040, 0, 0, 2, 1501769086, 2, 1621250475, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', 0, 'www.mnbv.loc', 'mnbv.loc', 'mnbv.loc', '0', 'bsdefsite2', '', 'site', 1, '', '', '', '', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_sysusers`
--

DROP TABLE IF EXISTS `mnbv_sysusers`;
CREATE TABLE `mnbv_sysusers` (
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
  `email` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(255) NOT NULL DEFAULT '',
  `passwd` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_sysusers`
--

INSERT INTO `mnbv_sysusers` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `email`, `login`, `passwd`, `phone`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 110, 110, 0, 'Системные пользователи', 'System users', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280461, 2, 1504619715, '127.0.0.1', 'Администратор', '', '', '', '', '', '', '', '', '', '', 0, ''),
(2, '0000-00-00 00:00:00', 1, 100, 0, '', 1, 110, 110, 0, 'Администратор', 'Administrator', '', 'Главный администратор системы', 0, '', '', '<p>Описание админа</p>', '', 0, 0, 0, 2, 1481283239, 2, 1622010571, '127.0.0.1', 'Администратор', '{\"fio\":\"\\u0410\\u0434\\u043c\\u0438\\u043d\\u0438\\u0441\\u0442\\u0440\\u0430\\u0442\\u043e\\u0440\",\"addr\":\"\\u0421\\u0435\\u0440\\u0432\\u0435\\u0440\\u043d\\u0430\\u044f\",\"phone\":\"911\",\"position\":\"SysAmin\",\"root\":1,\"tablerows\":21,\"tplwidth\":1,\"iflang\":\"ru\",\"viewlogs\":1,\"discount\":\"4\"}', '', '', '', '', 'test@test.ru', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', 0, ''),
(3, '0000-00-00 00:00:00', 1, 100, 0, '', 0, 110, 110, 0, 'Демо пользователь', 'Demo', '', 'Демо пользователь', 0, '', '', '<p>Опис</p>', '', 0, 0, 0, 2, 1481283301, 2, 1521975737, '127.0.0.1', 'Администратор', '{\"fio\":\"\\u0414\\u0435\\u043c\\u043e \\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u0435\\u043b\\u044c\",\"addr\":\"\\u041e\\u0444\\u0444\\u0438\\u0441\",\"position\":\"Demo\",\"access\":\"[\\\"4\\\"]\",\"permissions\":\"[\\\"4\\\"]\",\"tplwidth\":1,\"iflang\":\"ru\",\"discount\":\"2\"}', '', '', '', '', '', 'demo', 'fb98a17d9eb8bfa3b2e9431c594bb732', '', '', 0, ''),
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
  `storage` varchar(20) NOT NULL DEFAULT '',
  `objid` int(11) NOT NULL DEFAULT 0,
  `objtype` int(1) NOT NULL DEFAULT 0
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
-- Дамп данных таблицы `mnbv_tickets`
--

INSERT INTO `mnbv_tickets` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 1, 1, '', 1, 0, 200, 0, 'Задачи', 'Tickets', '', '', 0, '', '', '', '', 0, 0, 0, 0, 0, 2, 1502182047, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_tmp`
--

DROP TABLE IF EXISTS `mnbv_tmp`;
CREATE TABLE `mnbv_tmp` (
  `id` varchar(100) NOT NULL DEFAULT '',
  `ts` int(11) NOT NULL DEFAULT 0,
  `tsto` int(11) NOT NULL DEFAULT 0,
  `val` varchar(20000) NOT NULL DEFAULT ''
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
  `alias` varchar(100) NOT NULL DEFAULT '',
  `idref` int(11) NOT NULL DEFAULT 0,
  `objtype` int(1) NOT NULL DEFAULT 0,
  `catalias` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_urlaliases`
--

INSERT INTO `mnbv_urlaliases` (`id`, `siteid`, `urltype`, `alias`, `idref`, `objtype`, `catalias`) VALUES
(1, 0, 1, 'folder1', 2, 1, ''),
(2, 0, 1, 'folder2', 3, 1, ''),
(3, 0, 1, 'folder3', 8, 1, ''),
(4, 0, 1, 'folder3/catcat3', 9, 1, ''),
(5, 0, 1, 'folder3/catcat3/folder3/catcatcat3', 10, 1, ''),
(7, 0, 1, 'tovar1_1', 4, 0, 'folder1'),
(8, 0, 1, 'tovar1_2', 5, 0, 'folder1'),
(9, 0, 1, 'zelenyy-pirozhok', 6, 0, 'folder2'),
(10, 0, 1, 'tovar2_2', 7, 0, 'folder2'),
(11, 0, 3, 'poleznaya-informaciya', 5, 1, ''),
(12, 0, 3, 'bespoleznaya-informaciya', 6, 1, ''),
(13, 0, 3, 'stat-ya-1', 2, 0, 'poleznaya-informaciya'),
(14, 0, 3, 'statya-2', 3, 0, 'poleznaya-informaciya'),
(15, 0, 3, 'stat-ya-3', 4, 0, 'poleznaya-informaciya'),
(16, 0, 3, 'stat-ya1', 7, 0, 'bespoleznaya-informaciya'),
(18, 0, 1, 'tovar1_3', 12, 0, 'folder1'),
(19, 0, 1, 'tovar1_4', 13, 0, 'folder1'),
(20, 0, 1, 'tovar1_5', 14, 0, 'folder1'),
(21, 0, 1, 'tovar1_6', 15, 0, 'folder1'),
(22, 0, 1, 'tovar1_7', 16, 0, 'folder1'),
(23, 0, 1, 'folder4', 17, 1, ''),
(24, 0, 1, 'folder7', 20, 1, ''),
(25, 0, 2, 'novost-4', 5, 0, ''),
(26, 0, 2, 'novost-5', 6, 0, ''),
(27, 0, 2, 'novost-6', 7, 0, ''),
(28, 0, 1, 'tovar1_8', 22, 0, 'folder1'),
(29, 0, 1, 'tovar1_9', 23, 0, 'folder1'),
(30, 0, 2, 'novost-7', 8, 0, ''),
(32, 0, 1, 'catalog', 1, 1, ''),
(34, 0, 1, 'folder6', 19, 1, ''),
(35, 0, 1, 'folder8', 21, 1, ''),
(37, 0, 1, 'tovar5_1', 25, 0, ''),
(38, 0, 2, 'novost-1', 2, 0, ''),
(39, 0, 2, 'novost-2', 3, 0, ''),
(41, 0, 5, 'bosch', 2, 0, ''),
(42, 0, 5, 'dexter', 3, 0, ''),
(43, 0, 5, 'atlant', 4, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `mnbv_users`
--

DROP TABLE IF EXISTS `mnbv_users`;
CREATE TABLE `mnbv_users` (
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
  `email` varchar(255) NOT NULL DEFAULT '',
  `login` varchar(255) NOT NULL DEFAULT '',
  `passwd` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `files` text NOT NULL DEFAULT '',
  `siteid` int(11) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_users`
--

INSERT INTO `mnbv_users` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `email`, `login`, `passwd`, `phone`, `files`, `siteid`, `tags`) VALUES
(1, '0000-00-00 00:00:00', 0, 100, 1, '', 1, 110, 110, 0, 'Пользователи', 'Users', '', '', 0, '', '', '', '', 0, 0, 0, 2, 1481280461, 2, 1501053426, '127.0.0.1', 'Администратор', '', '', '', '', '', '', '', '', '', '', 0, ''),
(1000, '2017-09-05 18:45:02', 1, 100, 0, '', 0, 110, 110, 0, 'Пользователь', 'User', '', '', 0, '', '', '', '', 1504622700, 0, 0, 2, 1504622702, 2, 1619442336, '127.0.0.1', 'Администратор', '{\"permissions\":\"[\\\"3\\\"]\",\"iflang\":\"ru\",\"tplwidth\":1,\"discount\":\"3\"}', '', '', '', '', 'user@user.ru', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '', '', 0, '');

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
  `discminmargval` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mnbv_vendors`
--

INSERT INTO `mnbv_vendors` (`id`, `datestr`, `parentid`, `pozid`, `type`, `typeval`, `visible`, `access`, `access2`, `first`, `name`, `namelang`, `alias`, `comm`, `preview`, `about`, `aboutlang`, `text`, `textlang`, `date`, `date1`, `date2`, `createuser`, `createdate`, `edituser`, `editdate`, `editip`, `author`, `vars`, `attrup`, `attr`, `attrvals`, `upfolders`, `files`, `siteid`, `tags`, `discmaxpr`, `discmaxval`, `discminmargpr`, `discminmargval`) VALUES
(1, '2017-09-15 18:20:38', 0, 100, 1, '', 1, 0, 210, 0, 'Производители', 'Vendors', '', '', 0, '', '', '', '', 1505485238, 0, 0, 2, 1505485238, 2, 1505485246, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(2, '2017-09-15 18:21:02', 1, 100, 0, '', 1, 0, 210, 0, 'Bosch', 'Bosch', 'bosch', '', 0, '', '', '', '', 1505485260, 0, 0, 2, 1505485262, 2, 1621636038, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(3, '2017-09-15 18:21:24', 1, 100, 0, '', 1, 0, 210, 0, 'Dexter', 'Dexter', 'dexter', '', 0, '', '', '', '', 1505485260, 0, 0, 2, 1505485284, 2, 1621625541, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00'),
(4, '2017-09-15 18:21:47', 1, 100, 0, '', 1, 0, 210, 0, 'Атлант', 'Atlant', 'atlant', '', 0, '', '', '', '', 1505485260, 0, 0, 2, 1505485307, 2, 1621636021, '127.0.0.1', 'Администратор', '', '', '', '', '', '', 0, '', '0.00', '0.00', '0.00', '0.00');

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
-- Индексы таблицы `mnbv_attrvals`
--
ALTER TABLE `mnbv_attrvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obtvint` (`objid`,`vint`),
  ADD KEY `attrfolder` (`attrid`,`objparentid`);

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
-- Индексы таблицы `mnbv_tmp`
--
ALTER TABLE `mnbv_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mnbv_urlaliases`
--
ALTER TABLE `mnbv_urlaliases`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `mnbv_articles`
--
ALTER TABLE `mnbv_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `mnbv_attributes`
--
ALTER TABLE `mnbv_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `mnbv_attrvals`
--
ALTER TABLE `mnbv_attrvals`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT для таблицы `mnbv_messages`
--
ALTER TABLE `mnbv_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `mnbv_news`
--
ALTER TABLE `mnbv_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `mnbv_orders`
--
ALTER TABLE `mnbv_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mnbv_products`
--
ALTER TABLE `mnbv_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `mnbv_robots`
--
ALTER TABLE `mnbv_robots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT для таблицы `mnbv_robotsrun`
--
ALTER TABLE `mnbv_robotsrun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT для таблицы `mnbv_site`
--
ALTER TABLE `mnbv_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=20;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mnbv_urlaliases`
--
ALTER TABLE `mnbv_urlaliases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `mnbv_users`
--
ALTER TABLE `mnbv_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT для таблицы `mnbv_vendors`
--
ALTER TABLE `mnbv_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
