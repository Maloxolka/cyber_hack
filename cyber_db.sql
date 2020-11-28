-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 28 2020 г., 20:26
-- Версия сервера: 10.4.13-MariaDB
-- Версия PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cyber_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id_country` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id_country`, `name`) VALUES
(1, 'Russia'),
(2, 'Ukraine');

-- --------------------------------------------------------

--
-- Структура таблицы `disciplines`
--

CREATE TABLE `disciplines` (
  `id_discipline` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `disciplines`
--

INSERT INTO `disciplines` (`id_discipline`, `name`) VALUES
(1, 'Dota 2'),
(2, 'CS:GO');

-- --------------------------------------------------------

--
-- Структура таблицы `drafts`
--

CREATE TABLE `drafts` (
  `id_team` int(10) UNSIGNED NOT NULL,
  `id_player` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `drafts`
--

INSERT INTO `drafts` (`id_team`, `id_player`) VALUES
(5, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `drafts_log`
--

CREATE TABLE `drafts_log` (
  `id_player` int(10) UNSIGNED NOT NULL,
  `id_team` int(10) UNSIGNED NOT NULL,
  `state` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `matches`
--

CREATE TABLE `matches` (
  `id_match` int(10) UNSIGNED NOT NULL,
  `id_tournament` int(10) UNSIGNED NOT NULL,
  `first_team` int(10) UNSIGNED NOT NULL,
  `second_team` int(10) UNSIGNED NOT NULL,
  `first_score` int(10) UNSIGNED NOT NULL,
  `second_score` int(10) UNSIGNED NOT NULL,
  `format` text NOT NULL,
  `ladder` text NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `matches`
--

INSERT INTO `matches` (`id_match`, `id_tournament`, `first_team`, `second_team`, `first_score`, `second_score`, `format`, `ladder`, `state`) VALUES
(1, 1, 3, 4, 2, 3, 'Bo5', '1/4', 3),
(2, 1, 4, 5, 2, 3, 'Bo5', '1/4', 3),
(3, 1, 5, 3, 2, 3, 'Bo5', '1/4', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `id_tournament` int(10) UNSIGNED NOT NULL,
  `id_team` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`id_tournament`, `id_team`) VALUES
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `players`
--

CREATE TABLE `players` (
  `id_player` int(10) UNSIGNED NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `nickname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `players`
--

INSERT INTO `players` (`id_player`, `first_name`, `last_name`, `nickname`) VALUES
(1, 'Fedor', 'Ugly', 'Bazinga'),
(2, 'Misha', 'Turk', 'OwO');

-- --------------------------------------------------------

--
-- Структура таблицы `teams`
--

CREATE TABLE `teams` (
  `id_team` int(10) UNSIGNED NOT NULL,
  `id_discipline` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `id_country` int(10) UNSIGNED NOT NULL,
  `full_winrate` decimal(4,2) NOT NULL,
  `local_winrate` decimal(4,2) NOT NULL,
  `winstreak` int(11) NOT NULL,
  `current_position` int(10) UNSIGNED NOT NULL,
  `last_position` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `teams`
--

INSERT INTO `teams` (`id_team`, `id_discipline`, `name`, `id_country`, `full_winrate`, `local_winrate`, `winstreak`, `current_position`, `last_position`) VALUES
(1, 1, 'OG', 1, '40.00', '99.99', 10, 3, 3),
(2, 1, 'OG', 1, '40.00', '10.00', 10, 3, 3),
(3, 1, 'OG', 1, '40.00', '10.00', 10, 3, 3),
(4, 1, 'HG', 2, '40.00', '10.00', 10, 3, 3),
(5, 1, 'EG', 1, '40.00', '10.00', 10, 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `tournaments`
--

CREATE TABLE `tournaments` (
  `id_tournament` int(10) UNSIGNED NOT NULL,
  `id_discipline` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `fund` int(11) NOT NULL,
  `id_country` int(10) UNSIGNED NOT NULL,
  `city` text NOT NULL,
  `tier` int(10) UNSIGNED NOT NULL,
  `format` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tournaments`
--

INSERT INTO `tournaments` (`id_tournament`, `id_discipline`, `name`, `fund`, `id_country`, `city`, `tier`, `format`, `start_date`, `end_date`) VALUES
(1, 1, 'The Kiev Major', 100000, 2, 'г. Киев', 1, 'TBD', '2017-11-27', '2017-12-19');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(8) UNSIGNED ZEROFILL NOT NULL,
  `balance` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `post_adress` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id_country`);

--
-- Индексы таблицы `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id_discipline`);

--
-- Индексы таблицы `drafts`
--
ALTER TABLE `drafts`
  ADD UNIQUE KEY `id_team` (`id_team`,`id_player`),
  ADD KEY `id_player` (`id_player`);

--
-- Индексы таблицы `drafts_log`
--
ALTER TABLE `drafts_log`
  ADD UNIQUE KEY `id_player` (`id_player`,`id_team`,`state`,`date`);

--
-- Индексы таблицы `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `id_tournament` (`id_tournament`),
  ADD KEY `first_team` (`first_team`),
  ADD KEY `second_team` (`second_team`);

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD UNIQUE KEY `id_tournament` (`id_tournament`,`id_team`),
  ADD KEY `id_team` (`id_team`);

--
-- Индексы таблицы `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id_player`);

--
-- Индексы таблицы `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id_team`),
  ADD KEY `id_discipline` (`id_discipline`),
  ADD KEY `id_country` (`id_country`);

--
-- Индексы таблицы `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id_tournament`),
  ADD KEY `id_discipline` (`id_discipline`),
  ADD KEY `id_country` (`id_country`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id_country` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id_discipline` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `matches`
--
ALTER TABLE `matches`
  MODIFY `id_match` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `players`
--
ALTER TABLE `players`
  MODIFY `id_player` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `teams`
--
ALTER TABLE `teams`
  MODIFY `id_team` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id_tournament` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `drafts`
--
ALTER TABLE `drafts`
  ADD CONSTRAINT `drafts_ibfk_1` FOREIGN KEY (`id_player`) REFERENCES `players` (`id_player`),
  ADD CONSTRAINT `drafts_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id_team`);

--
-- Ограничения внешнего ключа таблицы `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`id_tournament`) REFERENCES `tournaments` (`id_tournament`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`first_team`) REFERENCES `teams` (`id_team`),
  ADD CONSTRAINT `matches_ibfk_3` FOREIGN KEY (`second_team`) REFERENCES `teams` (`id_team`);

--
-- Ограничения внешнего ключа таблицы `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id_team`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`id_tournament`) REFERENCES `tournaments` (`id_tournament`);

--
-- Ограничения внешнего ключа таблицы `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`id_discipline`) REFERENCES `disciplines` (`id_discipline`),
  ADD CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`id_country`) REFERENCES `countries` (`id_country`);

--
-- Ограничения внешнего ключа таблицы `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `tournaments_ibfk_1` FOREIGN KEY (`id_discipline`) REFERENCES `disciplines` (`id_discipline`),
  ADD CONSTRAINT `tournaments_ibfk_2` FOREIGN KEY (`id_country`) REFERENCES `countries` (`id_country`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
