-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Raèunalo: localhost
-- Vrijeme generiranja: Sij 19, 2014 u 06:42 PM
-- Verzija poslužitelja: 5.5.24-log
-- PHP verzija: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza podataka: `lop`
--
CREATE DATABASE IF NOT EXISTS `lop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `lop`;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `api_keys`
--

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int(11) NOT NULL,
  `key` varchar(32) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_api_keys_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Izbacivanje podataka za tablicu `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Default'),
(2, 'Contest'),
(3, 'LCS');

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `text` text,
  `date` timestamp NULL DEFAULT NULL,
  `publisher_name` varchar(80) DEFAULT 'Artikan',
  `active` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `news_comments`
--

CREATE TABLE IF NOT EXISTS `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `date` timestamp NULL DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `upvotes` int(11) DEFAULT '0',
  `downvotes` int(11) DEFAULT '0',
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_comments_news1_idx` (`news_id`),
  KEY `fk_news_comments_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) DEFAULT NULL,
  `type` varchar(80) DEFAULT 'PayPal' COMMENT '\n',
  `date` timestamp NULL DEFAULT NULL,
  `p_email` varchar(300) DEFAULT NULL COMMENT 'Can be different from user email, if he changes it later.',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payments_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `plays`
--

CREATE TABLE IF NOT EXISTS `plays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(300) DEFAULT NULL,
  `name` text,
  `description` text,
  `tags` text,
  `date` timestamp NULL DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `positive` int(11) DEFAULT '0',
  `negative` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '1' COMMENT 'Banned - 0, Normal - 1, Featured - 2',
  `active` int(11) DEFAULT '0',
  `data` varchar(500) DEFAULT NULL COMMENT 'Play Skin and other.',
  `champion` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plays_users_idx` (`user_id`),
  KEY `fk_plays_categories1_idx` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `plays_comments`
--

CREATE TABLE IF NOT EXISTS `plays_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `date` timestamp NULL DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  `upvotes` int(11) DEFAULT '0',
  `downvotes` int(11) DEFAULT '0',
  `play_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_plays1_idx` (`play_id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  KEY `fk_plays_comments_plays_comments1_idx` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=301 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `plays_votes`
--

CREATE TABLE IF NOT EXISTS `plays_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL COMMENT 'positive/negative',
  `date` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `play_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plays_votes_users1_idx` (`user_id`),
  KEY `fk_plays_votes_plays1_idx` (`play_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Tablièna struktura za tablicu `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Username ID',
  `username` varchar(80) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `p_email` varchar(300) DEFAULT 'Undefined' COMMENT 'Payment email (PayPal or others)',
  `user_type_id` int(11) NOT NULL DEFAULT '1',
  `display_name` varchar(80) DEFAULT 'Undefined',
  `last_ip` varchar(50) DEFAULT '0.0.0.0',
  `registration_date` timestamp NULL DEFAULT NULL,
  `data` text NOT NULL,
  `summoner_data` text COMMENT 'SummonerName:Region; Optional',
  `avatar` varchar(200) DEFAULT 'avatar/default' COMMENT 'User shouldn''t be able to upload his own, we will have our owns and just link them e.g. avatar/teemo',
  `last_login` timestamp NULL DEFAULT NULL,
  `donated` int(11) DEFAULT '0' COMMENT 'Total money spent on features.',
  `balance` int(11) DEFAULT '0' COMMENT 'For future development.',
  `coins` int(11) DEFAULT '0' COMMENT 'For future development.\n',
  `points` int(11) DEFAULT '0' COMMENT 'For future development.',
  `premium_till` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_users_user_types1_idx` (`user_type_id`),
  KEY `username` (`username`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text,
  `date` timestamp NULL DEFAULT NULL,
  `read` int(11) DEFAULT '0',
  `data` text,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_messages_users1_idx` (`sender`),
  KEY `fk_users_messages_users2_idx` (`receiver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `user_permissions`
--

CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_admin` int(11) DEFAULT '0',
  `payments_admin` int(11) DEFAULT '0',
  `premium_features` int(11) DEFAULT '0',
  `admin_panel` int(11) DEFAULT '0',
  `mod_panel` int(11) DEFAULT '0',
  `user_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_permissions_user_types1_idx` (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablièna struktura za tablicu `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `data` varchar(500) DEFAULT 'Undefined' COMMENT 'Optional, for future.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ogranièenja za izbaèene tablice
--

--
-- Ogranièenja za tablicu `api_keys`
--
ALTER TABLE `api_keys`
  ADD CONSTRAINT `fk_api_keys_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `news_comments`
--
ALTER TABLE `news_comments`
  ADD CONSTRAINT `fk_news_comments_news1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_news_comments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `plays`
--
ALTER TABLE `plays`
  ADD CONSTRAINT `fk_plays_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_plays_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `plays_comments`
--
ALTER TABLE `plays_comments`
  ADD CONSTRAINT `fk_comments_plays1` FOREIGN KEY (`play_id`) REFERENCES `plays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_plays_comments_plays_comments1` FOREIGN KEY (`parent_id`) REFERENCES `plays_comments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `plays_votes`
--
ALTER TABLE `plays_votes`
  ADD CONSTRAINT `fk_plays_votes_plays1` FOREIGN KEY (`play_id`) REFERENCES `plays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_plays_votes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `fk_users_messages_users1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_messages_users2` FOREIGN KEY (`receiver`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ogranièenja za tablicu `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `fk_user_permissions_user_types1` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
