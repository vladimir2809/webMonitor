-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 23 2019 г., 11:34
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
-- База данных: `webMonitor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `for_check`
--

CREATE TABLE `for_check` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `state_pause` int(11) NOT NULL,
  `size_page` int(11) NOT NULL,
  `deviation_size` int(11) NOT NULL,
  `h1` text,
  `title` text,
  `keywords` text,
  `description` text,
  `time_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `for_check`
--

INSERT INTO `for_check` (`id`, `url`, `state_pause`, `size_page`, `deviation_size`, `h1`, `title`, `keywords`, `description`, `time_add`) VALUES
(6, 'http://art-fenshui.ru/', 0, 62100, 9000, 'Как будет чувствовать себя Свинья в \"своем\" году?', 'Фэн-шуй - Искусство фен-шуй - как улучшить удачу', 'фэн-шуй, фен-шуй, выбор дат, бацзы, энергия ци, Пять элементов, Летящие Звезды, символы фен-шуй, элемент личности, столпы судьбы, Ци Мень', 'Информационный сайт о китайской метафизике - фен-шуй, астрология Бацзы, выбор дат, ци мень дун цзя. Фэн-шуй  прогнозы, рекомендации, статьи, обучающие материалы. ', '0000-00-00 00:00:00'),
(7, 'http://www.ushu-academy.ru/', 0, 621000, 9000, '<script> alert (\"hello\");</script>', 'ушк это круто!', 'ушу для детей в екатеринбурге,\r\nакадемия ушу екатеринбург,\r\nушу саньда,\r\nушу екатеринбург,\r\nакадемия ушу,\r\nушу для детей,\r\nйога айенгара екатеринбург,\r\nцигун екатеринбург,\r\nцигун для начинающих,\r\nцигун гимнастика,\r\nзанятия цигун в екатеринбурге,\r\nгимнастика цигун в екатеринбурге,\r\nпилатес для начинающих,\r\nпилатес екатеринбург,\r\nзанятие пилатесом,\r\nпилатес в екатеринбурге центр', 'ушу боевое искутсво без резких движеий', '0000-00-00 00:00:00'),
(45, 'https://www.radiorecord.ru/player/', 0, 23893, 2000, '', 'Radio Record', '', '', '0000-00-00 00:00:00'),
(76, 'http://homegame/', 0, 12608, 2000, ' HOME GAME ', ' HomeGame ', '', '', '2019-09-10 12:17:10'),
(78, 'https://vk.com/', 0, 0, 2000, ' ', 'Мобильная версия ВКонтакте', '', '', '2019-09-11 16:25:18');

-- --------------------------------------------------------

--
-- Структура таблицы `journal`
--

CREATE TABLE `journal` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `response` int(11) NOT NULL,
  `code_check` varchar(6) NOT NULL,
  `time_check` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `journal`
--

INSERT INTO `journal` (`id`, `url`, `response`, `code_check`, `time_check`) VALUES
(50, 'http://art-fenshui.ru/', 0, '110100', '2019-09-11 16:36:37'),
(51, 'http://www.ushu-academy.ru/', 0, '100010', '2019-09-11 16:36:37'),
(52, 'https://www.radiorecord.ru/player/', 0, '111101', '2019-09-12 14:19:39'),
(53, 'http://homegame/', 0, '111101', '2019-09-11 16:36:37'),
(54, 'https://vk.com/', 0, '000000', '2019-09-11 16:36:37'),
(74, 'https://www.radiorecord.ru/player/', 0, '111111', '2019-09-12 14:27:13'),
(75, 'http://homegame/', 0, '111100', '2019-09-12 14:43:35'),
(76, 'https://www.radiorecord.ru/player/', 0, '111101', '2019-09-13 11:28:41'),
(77, 'https://www.radiorecord.ru/player/', 0, '111111', '2019-09-13 12:02:44'),
(78, 'https://www.radiorecord.ru/player/', 0, '110111', '2019-09-13 12:03:36'),
(79, 'https://www.radiorecord.ru/player/', 0, '110101', '2019-09-13 12:04:24'),
(80, 'https://www.radiorecord.ru/player/', 0, '111101', '2019-09-13 12:05:53'),
(81, 'https://www.radiorecord.ru/player/', 0, '111111', '2019-09-13 12:06:40'),
(82, 'https://www.radiorecord.ru/player/', 0, '110101', '2019-09-13 12:07:28'),
(83, 'https://www.radiorecord.ru/player/', 0, '111111', '2019-09-13 12:08:18'),
(84, 'http://homegame/', 0, '111111', '2019-09-17 14:01:09');

-- --------------------------------------------------------

--
-- Структура таблицы `result_check`
--

CREATE TABLE `result_check` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `response` int(11) NOT NULL,
  `size` tinyint(1) NOT NULL,
  `h1` tinyint(1) NOT NULL,
  `title` tinyint(1) NOT NULL,
  `keywords` tinyint(1) NOT NULL,
  `description` tinyint(1) NOT NULL,
  `time_upload` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `result_check`
--

INSERT INTO `result_check` (`id`, `url`, `response`, `size`, `h1`, `title`, `keywords`, `description`, `time_upload`) VALUES
(78, 'http://art-fenshui.ru/', 200, 1, 0, 1, 0, 0, '2019-09-17 13:03:20'),
(79, 'http://www.ushu-academy.ru/', 200, 0, 0, 0, 1, 0, '2019-09-11 16:36:37'),
(80, 'https://www.radiorecord.ru/player/', 200, 1, 1, 1, 1, 1, '2019-09-13 12:08:18'),
(81, 'http://homegame/', 200, 1, 1, 1, 1, 1, '2019-09-17 14:01:09'),
(82, 'https://vk.com/', 302, 0, 0, 0, 0, 0, '2019-09-20 11:02:43');

-- --------------------------------------------------------

--
-- Структура таблицы `user_option`
--

CREATE TABLE `user_option` (
  `id` int(11) NOT NULL,
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
  `sms_balance` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_option`
--

INSERT INTO `user_option` (`id`, `name`, `surname`, `login`, `password`, `sms_submit`, `login_smsfeedback`, `password_smsfeedback`, `telephone`, `sms_size`, `sms_meta`, `sms_normal`, `sms_balance`) VALUES
(7, 'Vladimir', 'Kostenko', 'vladimir2809', '_J9..rasmVQDzmKXj.Dg', 1, 'Valdimir2809', 'a6ab8183d7a66586f76de617aeecb28b', '79505582918', 0, 0, 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `for_check`
--
ALTER TABLE `for_check`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `result_check`
--
ALTER TABLE `result_check`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_option`
--
ALTER TABLE `user_option`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `for_check`
--
ALTER TABLE `for_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT для таблицы `journal`
--
ALTER TABLE `journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT для таблицы `result_check`
--
ALTER TABLE `result_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT для таблицы `user_option`
--
ALTER TABLE `user_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
