-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 06 2024 г., 13:22
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `act`
--

-- --------------------------------------------------------

--
-- Структура таблицы `acts`
--

CREATE TABLE `acts` (
  `id` int(11) NOT NULL,
  `sent` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `comments` text DEFAULT NULL,
  `received` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `acts`
--

INSERT INTO `acts` (`id`, `sent`, `date`, `comments`, `received`) VALUES
(6, 'МАЙНИНГ СОЛЮШНС АО', '2024-08-06', 'По письму от 6.08.24', 'Норцев А.О.');

-- --------------------------------------------------------

--
-- Структура таблицы `act_items`
--

CREATE TABLE `act_items` (
  `id` int(11) NOT NULL,
  `act_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `received` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `act_items`
--

INSERT INTO `act_items` (`id`, `act_id`, `name`, `count`, `received`) VALUES
(10, 6, 'ABM DHD350 140 FF/SP 18*18 Буровая коронка 140мм', 2, ''),
(11, 6, 'Буровая коронка 152мм ABM-DHD350 152 FF/SP 18*18', 1, '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `acts`
--
ALTER TABLE `acts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `act_items`
--
ALTER TABLE `act_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `act_id` (`act_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `acts`
--
ALTER TABLE `acts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `act_items`
--
ALTER TABLE `act_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `act_items`
--
ALTER TABLE `act_items`
  ADD CONSTRAINT `act_items_ibfk_1` FOREIGN KEY (`act_id`) REFERENCES `acts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
