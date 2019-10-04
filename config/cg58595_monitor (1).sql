-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 04 2019 г., 12:09
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
(1, 0, 6, 300);

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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `for_check`
--

INSERT INTO `for_check` (`id`, `url`, `state_pause`, `size_page`, `deviation_size`, `h1`, `title`, `keywords`, `description`, `time_add`) VALUES
(6, 'http://art-fenshui.ru/', 0, 65442, 1000, 'Расчет благоприятных секторов по Гуа дома, секторов Шен Ван.', 'Фэн-шуй - Искусство фен-шуй - как улучшить удачу', 'фэн-шуй, фен-шуй, выбор дат, бацзы, энергия ци, Пять элементов, Летящие Звезды, элемент личности, столпы судьбы, Ци Мень', 'Информационный сайт о китайской метафизике - фен-шуй, бацзы, выбор дат, ци мень дун цзя. Фэн-шуй  прогнозы, рекомендации, статьи, обучающие материалы. ', '0000-00-00 00:00:00'),
(7, 'http://www.ushu-academy.ru/', 0, 621000, 9000, '<script> alert (\"hello\");</script>', 'ушк это круто!', 'ушу для детей в екатеринбурге,\r\nакадемия ушу екатеринбург,\r\nушу саньда,\r\nушу екатеринбург,\r\nакадемия ушу,\r\nушу для детей,\r\nйога айенгара екатеринбург,\r\nцигун екатеринбург,\r\nцигун для начинающих,\r\nцигун гимнастика,\r\nзанятия цигун в екатеринбурге,\r\nгимнастика цигун в екатеринбурге,\r\nпилатес для начинающих,\r\nпилатес екатеринбург,\r\nзанятие пилатесом,\r\nпилатес в екатеринбурге центр', 'ушу боевое искутсво без резких движеий', '0000-00-00 00:00:00'),
(45, 'https://www.radiorecord.ru/player/', 0, 238930, 2000, '2123', 'Radio Record', '', '', '0000-00-00 00:00:00'),
(76, 'http://homegame/', 0, 12608, 2000, ' HOME GAME ', ' HomeGame ', '', '', '2019-09-10 12:17:10'),
(78, 'https://vk.com/', 0, 0, 2000, ' ', 'Мобильная версия ВКонтакте', '', '', '2019-09-11 16:25:18'),
(81, 'https://mail.ru', 0, 300330, 2000, '(function logo (w) {\r\n						var images = [\r\n								\'//limg.imgsmail.ru/splash/v/i/logo_2018-fp-2c405036fe.png\',\r\n								\'//limg.imgsmail.ru/splash/v/i/logo_2018_wide@2x-fp-1413002770.png\',\r\n								\'//limg.imgsmail.ru/splash/v/i/logo_2018@2x-fp-402042f2c7.png\',\r\n								\'//limg.imgsmail.ru/splash/v/i/logo_2018_wide-fp-5c90598255.png\'\r\n							],\r\n							width = [84,95],\r\n							height = [28,32];var i=0,l=null,span=null,logo=mr.id(\"logo\"),spans=logo.getElementsByTagName(\"span\");for(l=spans.length;i<l;i++)if(span=spans[i],\"none\"!==(span.currentStyle||window.getComputedStyle(span,null)).display)document.write(\'<img src=\"\'+images[mr.retina?i+2:i]+\'\" class=\"logo__link__img logo__link__img_\'+(i?\"wide\":\"medium\")+\'\" width=\"\'+(i?width[1]:width[0])+\'\" height=\"\'+(i?height[1]:height[0])+\'\" />\');else{var image=document.createElement(\"img\");image.className=\"logo__link__img logo__link__img_\"+(i?\"wide\":\"medium\"),image.width=i?width[1]:width[0],image.height=i?height[1]:height[0],logo.appendChild(image),imagesPreloader.add(images[mr.retina?i+2:i],image)}logo.removeChild(spans[0]);})(window);', 'Mail.Ru: почта, поиск в интернете, новости, игры', 'почта, создать почту, почтовый ящик, почта для телефона, регистрация в почте, бесплатная электронная почта, новости, поиск в интернете, авто, спорт, игры, знакомства, погода, работа', 'Почта Mail.Ru — крупнейшая бесплатная почта, быстрый и удобный интерфейс, неограниченный объем ящика, надежная защита от спама и вирусов, мобильная версия и приложения для смартфонов. Доступ по IMAP, SMS-уведомления, интерфейс на разных языках и темы оформления Почты. Также на Mail.Ru: новости, поиск в интернете, авто, спорт, игры, знакомства, погода, работа.', '2019-09-27 12:22:25'),
(83, 'https://timeweb.com/ru/', 0, 87311, 2000, 'Преимущества хостинга Timeweb', 'Timeweb - лучший хостинг-провайдер, регистратор доменов', '', 'Дешевый хостинг, облачные VDS/VPS и выделенные серверы в аренду. Продажа SSL-сертификатов, лицензий 1С-Битрикс, готовых шаблонов для сайтов. Регистрация и продление доменов.', '2019-09-30 13:10:00'),
(86, 'http://homegame.cg58595.tmweb.ru/', 0, 12608, 2000, ' HOME GAME ', ' HomeGame ', '', '', '2019-10-04 10:32:12');

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
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `journal`
--

INSERT INTO `journal` (`id`, `url`, `response`, `code_check`, `time_check`) VALUES
(390, 'http://art-fenshui.ru/', 200, '110111', '2019-10-03 09:35:27'),
(391, 'http://www.ushu-academy.ru/', 200, '100010', '2019-10-03 09:35:27'),
(392, 'https://www.radiorecord.ru/player/', 200, '100111', '2019-10-03 09:35:27'),
(393, 'http://homegame/', 0, '000000', '2019-10-03 09:35:27'),
(394, 'https://vk.com/', 302, '000000', '2019-10-03 09:35:27'),
(395, 'https://mail.ru', 200, '100111', '2019-10-03 09:35:27'),
(396, 'https://timeweb.com/ru/', 200, '111011', '2019-10-03 09:35:27'),
(399, 'http://art-fenshui.ru/', 200, '100111', '2019-10-03 11:35:35'),
(400, 'https://mail.ru', 200, '111111', '2019-10-04 10:17:45'),
(401, 'https://mail.ru', 200, '101111', '2019-10-04 10:27:54'),
(402, 'https://timeweb.com/ru/', 200, '110011', '2019-10-04 10:27:54'),
(403, 'https://timeweb.com/ru/', 200, '111111', '2019-10-04 10:31:00'),
(404, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 10:32:12'),
(405, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 10:47:56'),
(406, 'http://homegame.cg58595.tmweb.ru/', 200, '101111', '2019-10-04 10:51:54'),
(407, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 10:52:41'),
(408, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 10:53:42'),
(409, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 10:54:03'),
(410, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 10:55:26'),
(411, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 10:56:35'),
(412, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 10:58:07'),
(413, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 10:59:05'),
(414, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 11:00:13'),
(415, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 11:01:21'),
(416, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 11:03:51'),
(417, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 11:05:26'),
(418, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 11:08:48'),
(419, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 11:09:12'),
(420, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 11:24:17'),
(421, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 11:27:07'),
(422, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 11:45:51'),
(423, 'http://homegame.cg58595.tmweb.ru/', 200, '111111', '2019-10-04 11:46:29'),
(424, 'http://homegame.cg58595.tmweb.ru/', 500, '000000', '2019-10-04 12:05:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `result_check`
--

INSERT INTO `result_check` (`id`, `url`, `response`, `size`, `h1`, `title`, `keywords`, `description`, `time_upload`) VALUES
(78, 'http://art-fenshui.ru/', 200, 1, 0, 1, 1, 1, '2019-10-04 12:06:58'),
(79, 'http://www.ushu-academy.ru/', 200, 0, 0, 0, 1, 0, '2019-10-04 12:06:58'),
(80, 'https://www.radiorecord.ru/player/', 200, 0, 0, 1, 1, 1, '2019-10-04 12:06:58'),
(81, 'http://homegame/', 0, 0, 0, 0, 0, 0, '2019-10-04 12:06:58'),
(82, 'https://vk.com/', 302, 0, 0, 0, 0, 0, '2019-10-04 12:06:58'),
(85, 'https://mail.ru', 200, 0, 1, 1, 1, 1, '2019-10-04 12:06:58'),
(87, 'https://timeweb.com/ru/', 200, 1, 1, 1, 1, 1, '2019-10-04 12:06:58'),
(90, 'http://homegame.cg58595.tmweb.ru/', 500, 0, 0, 0, 0, 0, '2019-10-04 12:06:58');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_option`
--

INSERT INTO `user_option` (`id`, `name`, `surname`, `login`, `password`, `sms_submit`, `login_smsfeedback`, `password_smsfeedback`, `telephone`, `sms_size`, `sms_meta`, `sms_normal`, `sms_balance`) VALUES
(10, 'Vladimir', 'Kostenko', 'vladimir2809', '_J9..rasmVQDzmKXj.Dg', 1, 'Valdimir2809', 'a6ab8183d7a66586f76de617aeecb28b', '79090067149', 1, 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
