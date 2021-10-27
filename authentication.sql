-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: Št 29.Apr 2021, 21:02
-- Verzia serveru: 8.0.23-0ubuntu0.20.04.1
-- Verzia PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `authentication`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `account`
--

CREATE TABLE `account` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `secret` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `account`
--

INSERT INTO `account` (`id`, `user_id`, `secret`) VALUES
(1, 1, 'NF3DXM6PA2WRE7BL');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `approaches`
--

CREATE TABLE `approaches` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` enum('Ldap','Google','2fa') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `approaches`
--

INSERT INTO `approaches` (`id`, `login`, `time`, `type`) VALUES
(12, 'gasparovicboris97@gmail.com', '29-04-2021 10:01:18pm', 'Google'),
(13, 'xgasparovicb@stuba.sk', '29-04-2021 10:13:57pm', 'Google'),
(14, 'xgasparovicb', '29-04-2021 10:26:12pm', 'Ldap'),
(15, 'gasparovicboris97@gmail.com', '29-04-2021 10:35:23pm', 'Google'),
(16, 'xgasparovicb', '29-04-2021 10:35:56pm', 'Ldap');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `login` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `login`, `password`) VALUES
(1, 'Boris', 'Gašparovič', 'boetfly@gmail.com', 'boris', '$2y$10$gmF04EA3y4nlnsWq0cjwv.HHaKYtFNelAxA6UZ0q9ppsnjxeIl/.q');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pre tabuľku `approaches`
--
ALTER TABLE `approaches`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `account`
--
ALTER TABLE `account`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pre tabuľku `approaches`
--
ALTER TABLE `approaches`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
