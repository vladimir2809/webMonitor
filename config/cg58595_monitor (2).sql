-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 13 2019 г., 10:27
-- Версия сервера: 5.6.39-83.1
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cg58595_monitor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `data_servis`
--

CREATE TABLE IF NOT EXISTS `data_servis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submit_sms_balance` tinyint(1) NOT NULL DEFAULT '0',
  `check_all_time` int(11) NOT NULL DEFAULT '0',
  `time_for_check_all` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `data_servis`
--

INSERT INTO `data_servis` (`id`, `submit_sms_balance`, `check_all_time`, `time_for_check_all`) VALUES
(1, 1, 2, 300);

-- --------------------------------------------------------

--
-- Структура таблицы `for_check`
--

CREATE TABLE IF NOT EXISTS `for_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `state_pause` int(11) NOT NULL,
  `size_page` int(11) NOT NULL,
  `deviation_size` int(11) NOT NULL,
  `h1` text,
  `title` text,
  `keywords` text,
  `description` text,
  `time_add` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `for_check`
--

INSERT INTO `for_check` (`id`, `url`, `state_pause`, `size_page`, `deviation_size`, `h1`, `title`, `keywords`, `description`, `time_add`) VALUES
(87, 'http://art-fenshui.ru/', 0, 55126, 2000, 'Есть разные способы выбирать даты.. какой лучше?', 'Фэн-шуй - Искусство фен-шуй - как улучшить удачу', 'фэн-шуй, фен-шуй, выбор дат, бацзы, энергия ци, Пять элементов, Летящие Звезды, элемент личности, столпы судьбы, Ци Мень', 'Информационный сайт о китайской метафизике - фен-шуй, бацзы, выбор дат, ци мень дун цзя. Фэн-шуй  прогнозы, рекомендации, статьи, обучающие материалы. ', '2019-10-04 12:20:09'),
(89, 'http://homegame.cg58595.tmweb.ru/', 1, 12608, 2000, ' HOME GAME ', ' HomeGame ', '', '', '2019-10-04 13:49:36');

-- --------------------------------------------------------

--
-- Структура таблицы `journal`
--

CREATE TABLE IF NOT EXISTS `journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `response` int(11) NOT NULL,
  `code_check` varchar(6) NOT NULL,
  `time_check` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `journal`
--

INSERT INTO `journal` (`id`, `url`, `response`, `code_check`, `time_check`) VALUES
(425, 'http://art-fenshui.ru/', 200, '111111', '2019-10-04 12:20:10'),
(427, 'http://art-fenshui.ru/', 200, '101111', '2019-10-04 13:40:03'),
(428, 'http://art-fenshui.ru/', 200, '111111', '2019-10-04 13:45:03'),
(429, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 13:49:36'),
(430, 'http://art-fenshui.ru/', 200, '101111', '2019-10-04 14:15:02'),
(431, 'http://art-fenshui.ru/', 200, '111111', '2019-10-04 14:20:04'),
(432, 'http://art-fenshui.ru/', 200, '101111', '2019-10-04 15:55:02'),
(433, 'http://art-fenshui.ru/', 200, '111111', '2019-10-04 16:00:03'),
(434, 'http://art-fenshui.ru/', 200, '101111', '2019-10-04 16:35:02'),
(435, 'http://art-fenshui.ru/', 200, '111111', '2019-10-04 16:38:52'),
(436, 'http://homegame.cg58595.tmweb.ru/', 502, '000000', '2019-10-05 00:05:04'),
(437, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-05 00:10:03'),
(438, 'http://art-fenshui.ru/', 200, '110111', '2019-10-06 15:40:04'),
(439, 'http://art-fenshui.ru/', 200, '100111', '2019-10-07 02:05:03'),
(440, 'http://homegame.cg58595.tmweb.ru/', 502, '000000', '2019-10-07 04:30:03'),
(441, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-07 04:40:03'),
(442, 'http://homegame.cg58595.tmweb.ru/', 502, '000000', '2019-10-07 17:05:03'),
(443, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-07 17:10:03'),
(444, 'http://art-fenshui.ru/', 0, '000000', '2019-10-09 14:15:03'),
(445, 'http://art-fenshui.ru/', 200, '111111', '2019-10-10 12:41:17'),
(446, 'http://homegame.cg58595.tmweb.ru/', 0, '000000', '2019-10-10 13:20:03'),
(447, 'http://art-fenshui.ru/', 200, '101111', '2019-10-10 13:30:04'),
(448, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-10 13:30:04'),
(449, 'http://art-fenshui.ru/', 200, '111111', '2019-10-10 13:35:03'),
(450, 'http://homegame.cg58595.tmweb.ru/', 0, '000000', '2019-10-10 13:55:03'),
(451, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-10 14:10:03'),
(452, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 09:00:02'),
(453, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 09:05:05'),
(454, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 11:15:02'),
(455, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 11:20:03'),
(456, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 15:15:02'),
(457, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 15:20:03'),
(458, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 16:00:02'),
(459, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 16:05:02'),
(460, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 18:30:03'),
(461, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 18:35:04'),
(462, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 19:55:04'),
(463, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 20:00:03'),
(464, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 21:00:02'),
(465, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 21:05:03'),
(466, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 21:45:03'),
(467, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 21:50:03'),
(468, 'http://art-fenshui.ru/', 200, '101111', '2019-10-11 23:40:02'),
(469, 'http://art-fenshui.ru/', 200, '111111', '2019-10-11 23:45:03'),
(470, 'http://art-fenshui.ru/', 200, '101111', '2019-10-12 01:45:02'),
(471, 'http://art-fenshui.ru/', 200, '111111', '2019-10-12 01:50:02'),
(472, 'http://art-fenshui.ru/', 200, '110111', '2019-10-12 02:15:02'),
(473, 'http://art-fenshui.ru/', 200, '100111', '2019-10-12 19:20:02');

-- --------------------------------------------------------

--
-- Структура таблицы `result_check`
--

CREATE TABLE IF NOT EXISTS `result_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `response` int(11) NOT NULL,
  `size` tinyint(1) NOT NULL,
  `h1` tinyint(1) NOT NULL,
  `title` tinyint(1) NOT NULL,
  `keywords` tinyint(1) NOT NULL,
  `description` tinyint(1) NOT NULL,
  `time_upload` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `result_check`
--

INSERT INTO `result_check` (`id`, `url`, `response`, `size`, `h1`, `title`, `keywords`, `description`, `time_upload`) VALUES
(91, 'http://art-fenshui.ru/', 200, 1, 0, 1, 1, 1, '2019-10-13 10:25:03'),
(93, 'http://homegame.cg58595.tmweb.ru/', 200, 1, 1, 1, 1, 1, '2019-10-11 11:25:04');

-- --------------------------------------------------------

--
-- Структура таблицы `user_option`
--

CREATE TABLE IF NOT EXISTS `user_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `sms_submit` tinyint(1) NOT NULL,
  `login_smsfeedback` text NOT NULL,
  `password_smsfeedback` text NOT NULL,
  `telephone` varchar(11) NOT NULL,
  `sms_size` tinyint(1) NOT NULL DEFAULT '1',
  `sms_meta` tinyint(1) NOT NULL DEFAULT '1',
  `sms_normal` tinyint(1) NOT NULL DEFAULT '0',
  `sms_balance` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_option`
--

INSERT INTO `user_option` (`id`, `name`, `surname`, `login`, `password`, `sms_submit`, `login_smsfeedback`, `password_smsfeedback`, `telephone`, `sms_size`, `sms_meta`, `sms_normal`, `sms_balance`) VALUES
(17, 'ввв', 'ввв', 'ввы', '_J9..rasmVQDzmKXj.Dg', 1, 'Valdimir2809', 'a6ab8183d7a66586f76de617aeecb28b', '79090006714', 1, 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
