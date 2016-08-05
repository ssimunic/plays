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

--
-- Izbacivanje podataka za tablicu `api_keys`
--

INSERT INTO `api_keys` (`id`, `key`, `user_id`) VALUES
(1, 'NzgyM2Q3YTc2YTJhMzc1MThjMjk2MDY1', 1);

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

--
-- Izbacivanje podataka za tablicu `plays`
--

INSERT INTO `plays` (`id`, `link`, `name`, `description`, `tags`, `date`, `score`, `positive`, `negative`, `type`, `active`, `data`, `champion`, `user_id`, `category_id`) VALUES
(16, 'http://www.youtube.com/watch?v=uGRZ7d7BeVQ', 'ASHE SEASON ONE STRATS', 'None', 'Ashe, Season One', '2014-01-17 08:02:24', 1, 1, 0, 0, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 2),
(17, 'https://www.youtube.com/watch?v=_o3k2-tvW0c', 'Super Secret Backdoor Ninjas!', 'None', 'Backdoor', '2014-01-17 08:02:24', 1, 3, 2, 0, 0, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(18, 'http://www.youtube.com/watch?v=gYzts5_cJIA', 'Korean Blue Ezreal Pentakill 1vs5 [Highlight]', 'Killing machine.', 'Korea, Ezreal', '2014-01-13 08:02:24', 1, 5, 4, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 3),
(19, 'http://www.youtube.com/watch?v=oiOTeYEiyPQ', 'PENTAKILL - Livestream Highlight', 'None', 'Athene, Pentakill', '2014-01-14 08:02:24', 8, 11, 3, 1, 1, '{"comments":true,"passedvalidation":true}', 'Shaco', 1, 1),
(20, 'http://www.youtube.com/watch?v=zJ0q8ihwQKg&feature=youtu.be', 'Quinn, Blitz Hook Vault', '<font face="Arial Black">None<font size="5">90zz09z</font></font>', 'Quinn', '2014-01-17 08:02:24', 1, 4, 3, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(21, 'https://www.youtube.com/watch?v=9Xin64SVMd0', 'Sick Montage of TPA Bebe''s 2013 Plays', '<font face="Comic Sans MS" size="1">None</font>', 'Bebe', '2014-01-17 08:02:24', 5, 9, 4, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(22, 'http://www.youtube.com/watch?v=ogbtlm8bNA8', 'Yasuo "Ninja" Gank | A sneaky, unpredictable gank utilizing Wraiths', 'A <i>very "helpful trick</i> I found while playing <u>Yasuo in the Jungle</u>. Basically, you can charge up your q on any wraith camp, fly through the wall and kill whoever is in your way. This makes for a very sneaky and unpredictable gank in the mid lane. It''s kind of hard to get right, but once you do, it will suprise your opponent and hopefully grant you and your teammate the kill.', 'Yasuo', '2014-01-17 08:02:24', 15, 18, 3, 2, 1, '{"comments":true,"passedvalidation":true}', 'Darius', 1, 1),
(23, 'http://www.youtube.com/watch?v=NeE6kXVWsrQ&feature=youtu.be', 'One does not simply charm Xpecial.', 'None', 'Xpecial', '2014-01-17 08:02:24', 5, 9, 4, 1, 1, '{"comments":true,"passedvalidation":true}', 'Shaco', 1, 1),
(24, 'http://www.youtube.com/watch?v=X2Erb7Abm-k', 'Yasuo and Lee Sin Deadly Wombo Combo!', 'None', 'Lee Sin, Yasuo', '2014-01-17 08:02:24', 6, 8, 2, 0, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(25, 'https://www.youtube.com/watch?v=GFSXdVaUE1Q', 'Insane Flash juke from Curse Academy VS True Neutral', '<span style="font-family: arial, sans-serif; font-size: 13px; line-height: 17px;">JummyChu with some fancy mind games narrowly avoids certain death at the hands of Curse Academy</span><br style="font-family: arial, sans-serif; font-size: 13px; line-height: 17px;">', 'Flash, Juke', '2014-01-17 08:02:24', 6, 8, 2, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(26, 'http://www.youtube.com/watch?v=_NStnOAJox0&feature=youtu.be', 'Voyboy outplayed by Scarra''s Gragas', 'No desc', 'Voyboy', '2014-01-17 08:02:24', 1, 4, 3, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 7, 1),
(27, 'http://www.youtube.com/watch?v=6Q4w_rJG2Ko&feature=c4-overview&list=UUsvn_Po0SmunchJYOWpOxMg', 'League of Legends : Yasuo Story', '<span style="font-family: arial, sans-serif; font-size: 13px; line-height: 17px;">Based on the New York Times worst seller.</span>', 'Yasuo', '2014-01-17 08:02:24', 8, 8, 0, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(28, 'http://www.youtube.com/watch?v=X2Erb7Abm-k', 'Yasuo and Lee Sin Deadly Wombo Combo!', '<u>For</u> more <b>plays</b> visit <i>my profile</i>.', 'Lee Sin, Yasuo', '2014-01-17 08:02:24', 0, 1, 1, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(29, 'https://www.youtube.com/watch?v=inNT3dUJC8Y', 'The Hobbit: Desolation of Smaug Trailer - League of Legends version', '<span style="font-family: arial, sans-serif; font-size: 13px; line-height: 17px;"><i><b><u><strike>Hope you guys enjoy this just like first one.</strike></u></b></i></span>', 'Hobbit', '2014-01-17 08:02:24', 4, 4, 0, 1, 1, '{"comments":true,"passedvalidation":true}', NULL, 1, 1),
(30, 'http://www.youtube.com/watch?v=ZpopI2fqr14', 'athene video', '<font size="5" face="Arial Black">treatatar</font>', 'Athene, Pentakill', '2014-01-17 08:02:24', 1, 1, 0, 1, 0, '{"comments":true,"passedvalidation":"pending"}', NULL, 1, 1),
(31, 'http://www.youtube.com/watch?v=qAIrj_Vqdfc', '345', '3535', '353', '2014-01-17 08:02:24', 0, 2, 2, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(32, 'http://www.youtube.com/watch?v=qAIrj_Vqdfc', 'http://www.youtube.com/watch?v=qAIrj_Vqdfc', 'http://www.youtube.com/watch?v=qAIrj_Vqdfc', 'http://www.youtube.com/watch?v=qAIrj_Vqdfc', '2014-01-17 08:02:24', 1, 1, 0, 1, 0, '{"comments":true,"passedvalidation":"pending"}', NULL, 9, 1),
(33, 'http://www.youtube.com/watch?v=X2Erb7Abm-k', '5a35a', '4r5355', 'a5a5a', '2014-01-17 08:02:24', 1, 1, 0, 1, 0, '{"comments":false,"passedvalidation":"pending"}', NULL, 9, 1),
(34, 'http://www.youtube.com/watch?v=ogbtlm8bNA8', '45235', 't5a5taa', '45a35a35', '2014-01-17 08:02:24', 1, 2, 1, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(35, 'http://www.youtube.com/watch?v=Ozt_g9VuA2s', 'a5ta5', 'a45a5a5', '4a55a', '2014-01-17 08:02:24', 5, 5, 0, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(36, 'http://www.youtube.com/watch?v=dmERWWjCJl0', '34535435', '43535353', '3453543', '2014-01-18 23:21:53', 1, 1, 0, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(37, 'http://www.youtube.com/watch?v=_ovdm2yX4MA', '43535', '43535', '43535', '2014-01-18 23:22:45', 1, 1, 0, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(38, 'http://www.youtube.com/watch?v=KrVC5dm5fFc', '23333333333', '23', '34543', '2014-01-18 23:24:31', 1, 2, 1, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(39, 'http://www.youtube.com/watch?v=YJVmu6yttiw', 'a45a5a', '345353', '3453453', '2014-01-18 23:26:28', 0, 1, 1, 1, 1, '{"comments":true,"passedvalidation":"true"}', NULL, 1, 1),
(40, 'http://www.youtube.com/watch?v=xHRkHFxD-xY', 'atreata', 'aerteat', '34aa', '2014-01-18 23:27:22', 1, 1, 0, 1, 0, '{"comments":true,"passedvalidation":"pending"}', NULL, 9, 1),
(41, 'http://www.youtube.com/watch?v=Vhf5cuXiLTA', '234arar', 'aerara', 'reara', '2014-01-18 23:38:17', 1, 1, 0, 1, 0, '{"comments":true,"passedvalidation":"pending"}', NULL, 9, 1),
(42, 'http://www.youtube.com/watch?v=M97vR2V4vTs', 'a4a4a4a', '2342424', '4a4a4a', '2014-01-18 23:39:19', 1, 1, 0, 1, 0, '{"comments":true,"passedvalidation":"pending"}', NULL, 9, 1);

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

--
-- Izbacivanje podataka za tablicu `plays_comments`
--

INSERT INTO `plays_comments` (`id`, `text`, `date`, `score`, `upvotes`, `downvotes`, `play_id`, `user_id`, `parent_id`) VALUES
(261, 'test', '2014-01-08 11:23:58', 0, 0, 0, 22, 1, NULL),
(262, 'lol', '2014-01-08 11:24:08', 0, 0, 0, 22, 1, NULL),
(263, 'wtf', '2014-01-08 11:24:10', 0, 0, 0, 22, 1, NULL),
(264, 'test', '2014-01-08 11:24:21', 0, 0, 0, 22, 1, NULL),
(265, 'test', '2014-01-08 11:24:23', 0, 0, 0, 22, 1, NULL),
(266, 'test', '2014-01-08 11:24:35', 0, 0, 0, 22, 1, NULL),
(267, '123', '2014-01-08 17:09:22', 0, 0, 0, 22, 1, NULL),
(268, 'n1', '2014-01-08 18:37:45', 0, 0, 0, 21, 1, NULL),
(269, 'test', '2014-01-08 19:56:25', 0, 0, 0, 19, 1, NULL),
(270, 'nc', '2014-01-09 00:45:51', 0, 0, 0, 29, 1, NULL),
(271, '25', '2014-01-09 00:53:29', 0, 0, 0, 23, 1, NULL),
(272, '243', '2014-01-09 00:53:33', 0, 0, 0, 24, 1, NULL),
(273, 'hahaha', '2014-01-09 00:58:05', 0, 0, 0, 19, 1, NULL),
(274, 'A very "helpful trick I found while playing Yasuo in the Jungle. Basically, you can charge up your q on any wraith camp, fly through the wall and kill whoever is in your way. This makes for a very sneaky and unpredictable gank in the mid lane. It''s kind of hard to get right, but once you do, it will suprise your opponent and hopefully grant you and your teammate the kill. ...', '2014-01-09 01:17:35', 0, 0, 0, 22, 1, NULL),
(275, '0hšppokš', '2014-01-09 01:33:14', 0, 0, 0, 22, 1, NULL),
(276, '123', '2014-01-09 12:34:35', 0, 0, 0, 24, 9, NULL),
(277, 'lol', '2014-01-09 12:55:15', 0, 0, 0, 21, 9, 268),
(278, 'awesome!', '2014-01-09 23:30:31', 0, 0, 0, 29, 1, NULL),
(279, 'ty', '2014-01-09 23:30:36', 0, 0, 0, 29, 1, NULL),
(280, 'jiohèo', '2014-01-10 13:13:51', 0, 0, 0, 22, 1, 275),
(281, 'lol', '2014-01-10 14:50:54', 0, 0, 0, 21, 1, NULL),
(282, '123', '2014-01-10 16:51:19', 0, 0, 0, 22, 1, 280),
(283, '123', '2014-01-10 17:18:00', 0, 0, 0, 22, 1, NULL),
(285, '345353', '2014-01-10 18:13:34', 0, 0, 0, 19, 1, NULL),
(286, 'a545', '2014-01-10 18:13:41', 0, 0, 0, 19, 1, 285),
(289, 'lol', '2014-01-11 16:46:55', 0, 0, 0, 29, 1, 279),
(290, 't688', '2014-01-11 20:11:50', 0, 0, 0, 31, 1, NULL),
(291, 'lol', '2014-01-11 20:21:39', 0, 0, 0, 29, 9, NULL),
(292, 'uh', '2014-01-11 20:21:53', 0, 0, 0, 29, 1, 291),
(295, 'xxx', '2014-01-11 21:56:25', 0, 0, 0, 29, 1, NULL),
(296, 'stfu omg', '2014-01-12 01:02:58', 0, 0, 0, 29, 1, 291),
(297, 'lol', '2014-01-12 01:03:09', 0, 0, 0, 29, 1, 296),
(298, '6456464', '2014-01-17 19:14:47', 0, 0, 0, 19, 1, NULL),
(299, 'llooool', '2014-01-17 19:14:59', 0, 0, 0, 19, 1, NULL),
(300, 'lolt465', '2014-01-17 19:15:17', 0, 0, 0, 19, 1, NULL);

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
-- Izbacivanje podataka za tablicu `plays_votes`
--

INSERT INTO `plays_votes` (`id`, `type`, `date`, `user_id`, `play_id`) VALUES
(112, 'upvote', '2014-01-13 18:45:05', 1, 22),
(113, 'upvote', '2014-01-13 18:45:10', 1, 27),
(114, 'upvote', '2014-01-13 18:45:23', 1, 19),
(115, 'downvote', '2014-01-13 18:45:25', 1, 23),
(116, 'downvote', '2014-01-13 18:45:38', 1, 17),
(117, 'upvote', '2014-01-14 00:06:33', 1, 35),
(118, 'upvote', '2014-01-14 14:16:55', 1, 29),
(119, 'downvote', '2014-01-14 21:22:13', 1, 26),
(120, 'upvote', '2014-01-14 21:22:16', 1, 21),
(121, 'upvote', '2014-01-17 15:34:52', 1, 18),
(122, 'upvote', '2014-01-17 18:29:13', 1, 25),
(123, 'upvote', '2014-01-17 19:29:05', 9, 22),
(124, 'upvote', '2014-01-17 19:53:51', 9, 35),
(125, 'upvote', '2014-01-17 19:54:38', 9, 19),
(126, 'downvote', '2014-01-18 16:46:04', 1, 31),
(127, 'upvote', '2014-01-19 00:03:15', 9, 21),
(128, 'upvote', '2014-01-19 00:03:20', 9, 20),
(129, 'downvote', '2014-01-19 00:04:07', 9, 39),
(130, 'downvote', '2014-01-19 01:21:20', 9, 38),
(131, 'upvote', '2014-01-19 02:42:27', 1, 38);

-- --------------------------------------------------------

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

--
-- Izbacivanje podataka za tablicu `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `p_email`, `user_type_id`, `display_name`, `last_ip`, `registration_date`, `data`, `summoner_data`, `avatar`, `last_login`, `donated`, `balance`, `coins`, `points`, `premium_till`) VALUES
(1, 'artikan', '$2y$10$cp0Fq03sveKoDxO6aUNBt..eS8M.9bE3pjsG9seLCscJlcBwkeWzy', 'silvio.simunic@gmail.com', 'Undefined', 4, 'Undefined', '127.0.0.1', '2013-12-29 23:52:42', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":["2014-01-12 05:48:12"],"summoners":[{"Bosco":{"summonerid":30758529,"league":"Unknown","rank":0,"region":"eune","iconid":591,"level":30,"date":"2014-01-12 05:48:12","active":true}}]}', 'avatar/ironstylus/diana', '2014-01-19 01:21:42', 0, 0, 0, 0, '0000-00-00 00:00:00'),
(4, 'stjszrkjsdkj', '$2y$10$0GaNDt31ppzI4RP63lUCLu9RaAntGW8q.tLVKhG1ZrWO1ajqQnjtu', 'romoutak@fakeinbox.com', 'Undefined', 1, 'Undefined', '127.0.0.1', '2013-12-30 00:55:50', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(5, '123123a', '$2y$10$NifWAolCULiB15iicwzU8O.NNY1tmSmSjI3O5i0DVKIYAIA8y.zMS', '1silvio.simunic@gmail.com', 'Undefined', 1, 'Undefined', '127.0.0.1', '2013-12-30 19:30:39', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(6, 'bibbson', '$2y$10$.uvJ2MWXz4Ponv.MtpqSC.xqlilt1HzLBTtVv6qdWwGiutw/MSsnK', 'smoljko.ivan@gmail.com', 'Undefined', 2, 'Undefined', '127.0.0.1', '2014-01-01 21:58:42', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(7, '1qwe111', '$2y$10$3dAOCSL72s9Dtm.oYlN7Quz5xpby4VtJn1KjWCLaBovYHol3PqN0S', '1qwe111@net.hr', 'Undefined', 1, 'Undefined', '127.0.0.1', '2014-01-03 05:28:41', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(8, '12312312313', '$2y$10$/7sIRh2C3c5hUDgME7hRK.rxwHkO3YIkw//T.UWG1Ky2/tH/QNw3.', '12312312313@net.hr', 'Undefined', 1, 'Undefined', '127.0.0.1', '2014-01-03 06:45:57', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(9, 'test', '$2y$10$uvxjNqlbCMPDlkrqnrBHUu5gAknKOwko0BlPs5M5yLsppD4NogftO', 'test@net.hr', 'Undefined', 1, 'Undefined', '127.0.0.1', '2014-01-03 08:22:59', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/ironstylus/zed', '2014-01-18 23:27:03', 0, 0, 0, 0, '0000-00-00 00:00:00'),
(10, 'Marko', '$2y$10$GL3kdZ3WmI6TAuSD2M5DCuHZlAVslUQFGq3XDOLhrZq3ZryjQUonS', 'artikangames@gmail.com', 'Undefined', 1, 'Undefined', '127.0.0.1', '2013-12-29 23:40:35', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(11, '12313131', '$2y$10$ebK9buiV46DvVFgDLM7sv.s2tqZduw.BITaie2s.NUNBQ2JBZP5YG', '12313131@net.hr', 'Undefined', 1, 'Undefined', '127.0.0.1', '2014-01-11 23:21:34', '{"theme":"bootstrap","votehistory":true,"medals":[],"ignorelist":[]}', '{"last_request":[],"summoners":[]}', 'avatar/default', NULL, 0, 0, 0, 0, '0000-00-00 00:00:00');

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
