-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Окт 25 2021 г., 12:00
-- Версия сервера: 5.7.24
-- Версия PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `adress_user`
--

CREATE TABLE `adress_user` (
  `id` int(11) NOT NULL,
  `userhasgift_id` int(11) NOT NULL,
  `id_gift` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `address` varchar(512) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `adress_user`
--

INSERT INTO `adress_user` (`id`, `userhasgift_id`, `id_gift`, `id_user`, `address`) VALUES
(18, 67, 6, 5, 'Lkheng الخنك, Drâa-Tafilalet ⴷⴰⵔⵄⴰ-ⵜⴰⴼⵉⵍⴰⵍⵜ درعة-تافيلالت, Марокко');

-- --------------------------------------------------------

--
-- Структура таблицы `gift`
--

CREATE TABLE `gift` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `gift`
--

INSERT INTO `gift` (`id`, `type`, `name`, `img`, `quantity`) VALUES
(1, 1, 'Money', 'https://rusidea.org/picts/economic/packs-money.jpg', 96),
(2, 2, 'Points', 'https://services.google.com/fh/files/helpcenter/points-badges_level_five.png', 999),
(3, 3, 'iPhone 11, 128 ГБ, жёлтый - Apple (RU)', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone11-yellow-select-2019_GEO_EMEA?wid=834&hei=1000&fmt=jpeg&qlt=95&.v=1567021770273https://iphoriya.ru/wp-content/uploads/iphone-11-yellow.jpg', 2),
(4, 3, 'Lamborghini SC20 ', 'https://cdn.motor1.com/images/mgl/01yvV/s1/lamborghini-sc20.webp', 1),
(5, 3, 'MacBook Pro 14 дюймов - Apple (RU)', 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/macbook-pro-13-og-202011?wid=1200&hei=630&fmt=jpeg&qlt=95&.v=1604347427000', 1),
(6, 3, 'TU7200 4K Smart Crystal UHD TV', 'https://images.samsung.com/is/image/samsung/in-uhd-tv-tu7200-ua43tu7200kxxl-fronttitangray-226701449?$720_576_PNG$', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1558536452),
('m130524_201442_init', 1558536482),
('m190124_110200_add_verification_token_column_to_user_table', 1558536482);

-- --------------------------------------------------------

--
-- Структура таблицы `transaction_bank`
--

CREATE TABLE `transaction_bank` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `transaction_bank`
--

INSERT INTO `transaction_bank` (`id`, `id_user`, `name`, `money`, `status`) VALUES
(3, 5, 'test', '10', 1),
(4, 5, 'test', '90', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` varchar(55) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `avatar` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?size=338&ext=jpg',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cash` float NOT NULL DEFAULT '0',
  `Points` float NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `type`, `avatar`, `username`, `cash`, `Points`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(5, 'admin', 'https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?size=338&ext=jpg\r\n', 'test', 100, 700, 'TaV-06w1JsPYZyxZ4nzmLY2aOlvpUE8G', '$2y$13$BZc7pY34Qb6AJRT7NvUgkukactKEiMBJlvzZ5SsJxE9L3QSJ68IQe', NULL, 'test@mail.rus', 10, 1558538841, 1558538841, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_has_gift`
--

CREATE TABLE `user_has_gift` (
  `id` int(11) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `send` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_has_gift`
--

INSERT INTO `user_has_gift` (`id`, `gift_id`, `user_id`, `send`, `quantity`) VALUES
(67, 6, 5, 1, 1),
(66, 2, 5, 1, 80),
(65, 1, 5, 1, 91);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `adress_user`
--
ALTER TABLE `adress_user`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `gift`
--
ALTER TABLE `gift`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `transaction_bank`
--
ALTER TABLE `transaction_bank`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Индексы таблицы `user_has_gift`
--
ALTER TABLE `user_has_gift`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `adress_user`
--
ALTER TABLE `adress_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `gift`
--
ALTER TABLE `gift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `transaction_bank`
--
ALTER TABLE `transaction_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user_has_gift`
--
ALTER TABLE `user_has_gift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
