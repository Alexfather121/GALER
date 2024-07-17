-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 17 2024 г., 23:41
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `galary_bd`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `category` tinytext NOT NULL,
  `description` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `category`, `description`) VALUES
(1, 'hedgehogs', 'Все фото с ёжиками'),
(2, 'bears', 'Медведи в живой природе'),
(3, 'foxes', 'Лисы в живой природе, фото'),
(7, 'Медведи', 'Очень крутой альбом'),
(9, 'Котики', 'Альбом с котиками');

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `img_num` int NOT NULL,
  `comment` text NOT NULL,
  `comment_num` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`img_num`, `comment`, `comment_num`) VALUES
(1, 'Очень красивый медведь', 1),
(19, 'Подождите, это же не медведь!', 2),
(13, 'Красавчик!', 4),
(9, 'Классный ёжик', 11),
(19, 'Где кнопка \"Удалить фото?\"', 13);

-- --------------------------------------------------------

--
-- Структура таблицы `img`
--

CREATE TABLE `img` (
  `id` int NOT NULL,
  `img_num` int NOT NULL,
  `img_desc` tinytext NOT NULL,
  `link` tinytext NOT NULL,
  `like` int UNSIGNED NOT NULL,
  `dislike` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `img`
--

INSERT INTO `img` (`id`, `img_num`, `img_desc`, `link`, `like`, `dislike`) VALUES
(2, 1, 'Мишка-топтыжка', 'bears/bear_1.jpg', 124, 32),
(2, 2, 'Белый медведь', 'bears/bear_2.jpg', 13, 3),
(2, 3, 'Пушистый мишка', 'bears/bear_3.jpg', 124, 1),
(3, 4, 'Мокрый лис', 'foxes/fox_1.jpg', 124, 2),
(3, 5, 'Уставшая лиса', 'foxes/fox_2.jpg', 24, 2),
(3, 6, 'Лисята', 'foxes/fox_3.jpg', 2, 0),
(3, 7, 'Лиса грустит', 'foxes/fox_4.jpg', 10, 3),
(3, 8, 'Белая лиса', 'foxes/fox_5.jpg', 5, 2),
(1, 9, 'Белый ёжик', 'hedgehogs/hedgehog_1.jpg', 12, 2),
(1, 10, 'Чёрный ёжик', 'hedgehogs/hedgehog_2.jpg', 26, 1),
(1, 11, 'Ёжик на природе', 'hedgehogs/hedgehog_3.jpg', 23, 3),
(1, 12, 'ёжик в воде', 'hedgehogs/hedgehog_4.jpg', 3, 0),
(1, 13, 'ёжик за деревом', 'hedgehogs/hedgehog_5.jpg', 8, 3),
(3, 18, 'Степная лиса', 'foxes/foxes_6.jpg', 1, 1),
(2, 19, 'Это котик', 'bears/bears_6.jpg', 0, 0),
(9, 20, 'Это котик Васька', 'Котики/Котики_1.jpg', 0, 0),
(9, 21, 'Это котики-друзья', 'Котики/Котики_2.jpg', 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_num`),
  ADD KEY `img_num` (`img_num`);

--
-- Индексы таблицы `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`img_num`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_num` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `img`
--
ALTER TABLE `img`
  MODIFY `img_num` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`img_num`) REFERENCES `img` (`img_num`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `img`
--
ALTER TABLE `img`
  ADD CONSTRAINT `img_ibfk_1` FOREIGN KEY (`id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
