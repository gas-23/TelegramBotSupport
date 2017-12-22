-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 22 2017 г., 22:19
-- Версия сервера: 5.6.31-77.0
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cu31997_bot`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user or chat identifier',
  `type` enum('private','group','supergroup','channel') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Chat type, either private, group, supergroup or channel',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `favorites` int(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `type`, `created_at`, `favorites`) VALUES
(412595731, 'private', '2017-12-22 18:28:07', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique message identifier',
  `chat_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `date` timestamp NULL DEFAULT NULL COMMENT 'Date the message was sent in timestamp format',
  `text` text COLLATE utf8mb4_unicode_ci COMMENT 'For text messages, the actual UTF-8 text of the message max message length 4096 char utf8mb4',
  `read_msg` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `chat_id` (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=630 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `chat_id`, `user_id`, `date`, `text`, `read_msg`) VALUES
(619, 412595731, 412595731, '2017-12-22 18:29:03', 'Привет. У меня проблема с интернетом. Скорость соединения всего 1мб, не могу в танки играть!', 1),
(621, 412595731, 494807396, '2017-12-22 18:30:57', 'Мне необходимо несколько минут, чтобы разобраться в проблеме', 1),
(622, 412595731, 494807396, '2017-12-22 18:33:25', 'Я проверил настройки вашего соединения и выявил проблему на вашем роутере. Попробуйте перезагрузить устройство', 1),
(623, 412595731, 494807396, '2017-12-22 18:34:48', 'Проверьте скорость соединения после перезагрузки', 1),
(627, 412595731, 412595731, '2017-12-22 18:39:41', 'Спасибо. Перезагрузка помогла', 1),
(628, 412595731, 412595731, '2017-12-22 18:40:39', 'Теперь скорость 30 мб', 1),
(629, 412595731, 494807396, '2017-12-22 18:41:16', 'Рад был помочь', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user identifier',
  `is_bot` tinyint(1) DEFAULT '0' COMMENT 'True if this user is a bot',
  `first_name` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'User''s first name',
  `last_name` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User''s last name',
  `username` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User''s username',
  `language_code` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User''s system language',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `is_bot`, `first_name`, `last_name`, `username`, `language_code`, `created_at`, `updated_at`) VALUES
(412595731, 0, 'Alexandr', 'Grebenshchikov', NULL, NULL, '2017-12-22 18:28:07', NULL),
(494807396, 1, 'PHP Developers contest', NULL, 'phpDevContestBot', NULL, '2017-12-17 21:00:00', NULL);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `Chat_id` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`id`),
  ADD CONSTRAINT `User_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
