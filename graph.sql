-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 09 2019 г., 20:58
-- Версия сервера: 5.6.43
-- Версия PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `graph`
--

-- --------------------------------------------------------

--
-- Структура таблицы `edge`
--

CREATE TABLE `edge` (
  `id` int(11) NOT NULL,
  `vertex_1` varchar(32) NOT NULL,
  `vertex_2` varchar(32) NOT NULL,
  `weight` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `edge`
--

INSERT INTO `edge` (`id`, `vertex_1`, `vertex_2`, `weight`) VALUES
(1, '1', '2', '2'),
(2, '2', '3', '5'),
(3, '1', '3', '10'),
(4, '2', '4', '2'),
(5, '4', '3', '2'),
(25, '9', '3', '3');

-- --------------------------------------------------------

--
-- Структура таблицы `vertex`
--

CREATE TABLE `vertex` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vertex`
--

INSERT INTO `vertex` (`id`, `name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(9, '12'),
(11, 'gggg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `edge`
--
ALTER TABLE `edge`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vertex`
--
ALTER TABLE `vertex`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `edge`
--
ALTER TABLE `edge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `vertex`
--
ALTER TABLE `vertex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
