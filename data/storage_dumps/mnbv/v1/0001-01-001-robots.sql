-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 29 2018 г., 16:25
-- Версия сервера: 5.6.38
-- Версия PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `j2i`
--

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
  `tags` varchar(255) NOT NULL,
  `rbtype` varchar(50) NOT NULL
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
  `pairslist` varchar(255) NOT NULL,
  `action` text NOT NULL
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

--
-- Индексы сохранённых таблиц
--

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
-- AUTO_INCREMENT для сохранённых таблиц
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
