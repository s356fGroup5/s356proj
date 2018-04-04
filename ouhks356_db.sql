-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2017 年 12 月 08 日 13:22
-- 伺服器版本: 5.5.54-MariaDB
-- PHP 版本： 5.4.45

DROP DATABASE IF EXISTS ouhks356_db;
CREATE DATABASE ouhks356_db;
USE ouhks356_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


/*TODO check Primary and Foreign keys*/
--
-- 資料庫： `ouhks356_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blacklist_user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `blacklist`
--

INSERT INTO `blacklist` (`id`, `user_id`, `blacklist_user_id`) VALUES
(3, 36, 5),
(4, 20, 18),
(5, 20, 5),
(8, 46, 5),
(9, 46, 20);

-- --------------------------------------------------------
--
-- 資料表結構 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`) VALUES
(1, 'normal', 'normal post'),
(2, 'vote', 'voting post (user story)');

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(8) NOT NULL,
  `comment` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(8) NOT NULL,
  `date` date NOT NULL,
  `post_id` int(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `user_id`, `date`, `post_id`) VALUES
(18, 'hii', 5, '2017-12-04', 48),
(31, 'cccc', 18, '2017-12-04', 51),
(33, '2', 5, '2017-12-04', 51),
(34, '3', 5, '2017-12-04', 51),
(35, 'asd', 18, '2017-12-04', 51),
(47, 'thx!~', 5, '2017-12-04', 53),
(48, 'asdfasdfasdfasdfasdgafdgadfadsfasdfasfasdfasdfas', 18, '2017-12-05', 53),
(52, 'sdfasdfadsf', 18, '2017-12-06', 53),
(53, 'sdfasdfadsfsdflkjakljeiofajwoifjaoiwejfiowafwaefaw', 18, '2017-12-06', 53),
(54, 'sdfasdfadsfsdflkjakljeiofajwoifjaoiwejfiowafwaefawdf', 18, '2017-12-06', 53),
(55, 'sdfasdfadsfsdflkjakljeiofajwoifjaoiwejfiowafwaefawdfdfsd', 18, '2017-12-06', 53),
(56, 'sdfasdfadsfsdflkjakljeiofajwoifjaoiwejfiowafwaefawdfdfsdsadfasdf', 18, '2017-12-06', 53),
(59, '56789', 5, '2017-12-06', 55),
(60, 'SELECT * FROM user u, user_type ut WHERE u.type_id = ut.type_id ORDER BY u.user_id DESC', 5, '2017-12-06', 56),
(61, 'testing for own comment.', 20, '2017-12-07', 55),
(62, 'hehe', 20, '2017-12-07', 48),
(67, 'testing', 20, '2017-12-07', 58),
(68, 'i am winner, u are loser', 5, '2017-12-07', 58),
(69, 'yoyoyoyoyoyoyoyoyooyoy', 5, '2017-12-07', 58),
(70, 'hahahahahahaha\r\n', 5, '2017-12-07', 58),
(72, 'testadmin', 35, '2017-12-07', 58),
(74, 'Hello', 5, '2017-12-07', 60),
(83, '123', 20, '2017-12-07', 54),
(137, 'hhhhhhhhhhhhhhhhhhhh', 5, '2017-12-07', 35),
(138, 'yyyyyyyyyyyyyy', 5, '2017-12-07', 34),
(139, 'hhhhhhhhhhhh', 5, '2017-12-07', 33),
(140, '555555555555', 5, '2017-12-07', 32),
(141, 'HI Testing testing\r\n', 47, '2017-12-08', 76),
(142, 'hello?', 47, '2017-12-08', 76),
(143, 'hehe', 37, '2017-12-08', 76),
(144, 'AVATAR;)', 37, '2017-12-08', 77),
(146, 'Ah ha', 47, '2017-12-08', 77),
(147, 'Hi, Nice to meet you guys', 51, '2017-12-08', 77),
(148, 'hi', 51, '2017-12-08', 77),
(152, 'Hi', 54, '2017-12-08', 77),
(153, 'HI', 55, '2017-12-08', 77);

-- --------------------------------------------------------

--
-- 資料表結構 `favoriteComment`
--

CREATE TABLE IF NOT EXISTS `favoriteComment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `favoriteComment`
--

INSERT INTO `favoriteComment` (`id`, `user_id`, `comment_id`, `post_id`) VALUES
(16, 20, 64, 57),
(17, 20, 59, 55),
(19, 20, 74, 60),
(20, 18, 75, 61),
(21, 43, 60, 56),
(23, 46, 47, 53),
(25, 46, 63, 22),
(27, 47, 74, 60),
(29, 5, 140, 32),
(31, 54, 147, 77);

-- --------------------------------------------------------

--
-- 資料表結構 `favoritelist`
--

CREATE TABLE IF NOT EXISTS `favoritelist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `favoritelist`
--

INSERT INTO `favoritelist` (`id`, `user_id`, `post_id`) VALUES
(53, 18, 53),
(55, 18, 54),
(56, 18, 35),
(61, 20, 56),
(62, 20, 53),
(63, 20, 54),
(64, 20, 52),
(65, 18, 56),
(68, 20, 58),
(69, 18, 60),
(70, 38, 61),
(71, 43, 56),
(72, 43, 66),
(73, 46, 74),
(74, 46, 22),
(75, 47, 76),
(76, 47, 55),
(77, 5, 76);

-- --------------------------------------------------------

--
-- 資料表結構 `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `poll_id` int(8) NOT NULL AUTO_INCREMENT,
  `poll_description` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `poll_count` int(8) NOT NULL,
  `post_id` int(8) NOT NULL,
 PRIMARY KEY (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `poll`
--

INSERT INTO `poll` (`poll_description`, `poll_count`, `post_id`) VALUES
("I like this vote", 5, 78),
("I DON'T like this vote", 2, 78),
("This forum is excellent", 20, 79),
("This forum has to improve", 5, 79);
-- --------------------------------------------------------

--
-- 資料表結構 `poll_record`
--

CREATE TABLE IF NOT EXISTS `poll_record` ( /*category 0(like), category 1(dislike), category 2(voting post)*/
  `poll_record_id` int(8) NOT NULL AUTO_INCREMENT,
  `poll_id` int(8), /* NULL = record of like or dislike */
  `comment_id` int(8), /* NULL = record of voting post */
  `user_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL,
  `date` date,
  `post_id` int(11) NOT NULL,
 PRIMARY KEY (`poll_record_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `poll_record`
--

/*INSERT INTO `poll_record` (`poll_record_id`, `poll_id`, `user_id`, category_id, date, post_id) VALUES
(1, 78, 38)*/

-- --------------------------------------------------------

--
-- 資料表結構 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(8) NOT NULL,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `category_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `post`
--

INSERT INTO `post` (`post_id`, `title`, `date`, `category_id`, `user_id`) VALUES
(32, 'Trump veers past gua', '2017-11-30', 1, 18),
(33, '234123', '2017-12-01', 1, 18),
(34, 'Tesla mega-battery', '2017-12-01', 1, 18),
(35, 'Tesla mega-battery', '2017-12-01', 1, 18),
(48, 'hii', '2017-12-04', 1, 5),
(51, 'c', '2017-12-04', 1, 18),
(53, 'icon 要轉path', '2017-12-04', 1, 5),
(54, '1234567890', '2017-12-06', 1, 5),
(55, '56789', '2017-12-06', 1, 5),
(56, 'Post List SQL', '2017-12-06', 1, 5),
(58, 'testsetsetset', '2017-12-07', 1, 20),
(60, 'Testing del fav', '2017-12-07', 1, 5),
(76, 'testing', '2017-12-08', 1, 47),
(77, 'I love Avatar', '2017-12-08', 1, 37),
(78, 'First vote', '2017-12-10', 2, 9),
(79, 'Second vote', '2017-12-11', 2, 9);

-- --------------------------------------------------------

--
-- 資料表結構 `reportlist`
--

CREATE TABLE IF NOT EXISTS `reportlist` (
  `id` int(8) NOT NULL,
  `type` int(8) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `reason` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `reportlist`
--

INSERT INTO `reportlist` (`id`, `type`, `reporter_id`, `user_id`, `post_id`, `comment_id`, `reason`, `date`) VALUES
(20, 2, 36, 5, 56, 60, 'wertwetwetw', '2017-12-07'),
(21, 1, 18, 5, 58, NULL, 'EWREWRQWE', '2017-12-07'),
(25, 3, 18, 18, NULL, NULL, 'sadfasdf', '2017-12-07'),
(27, 3, 20, 18, NULL, NULL, 'too handsome', '2017-12-07'),
(28, 1, 20, 5, 55, NULL, 'gesg', '2017-12-07'),
(29, 3, 20, 18, NULL, NULL, 'too good', '2017-12-07'),
(30, 3, 20, 18, NULL, NULL, 'asfdsad', '2017-12-07'),
(31, 3, 20, 5, NULL, NULL, 'gsdgsd', '2017-12-07'),
(32, 3, 18, 5, NULL, NULL, '89798798', '2017-12-07'),
(33, 2, 54, 51, 77, 148, '1', '2017-12-08');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(8) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `reg_date` date NOT NULL,
  `type_id` int(2) NOT NULL DEFAULT '1',
  `icon` varchar(50) NOT NULL DEFAULT 'default.png',
  `email` varchar(50) NOT NULL,
  `forgot_pwd_code` varchar(240) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `reg_date`, `type_id`, `icon`, `email`, `forgot_pwd_code`) VALUES
(1, 'test', 'test', '2017-10-11', 2, '1.png', 'test@test.com', NULL),
(5, 'test1', 'test1', '2017-10-11', 3, '5.png', 'hello', NULL),
(7, '12345678', '12345678', '2017-11-26', 4, 'default.png', '3', NULL),
(8, 'lets', 'lets', '2017-11-26', 4, 'default.png', '4', NULL),
(9, '123', '123', '2017-11-26', 1, 'default.png', '5', NULL),
(11, '12345', '12345', '2017-11-26', 1, 'default.png', '12345678@', NULL),
(12, '123456', '123456', '2017-11-26', 1, 'default.png', '12', NULL),
(13, 'test123', 'test123', '2017-11-29', 1, '13.png', 'max@g.com', NULL),
(14, 'hello123', 'hello123', '2017-11-30', 1, 'default.png', 'hello@hello.com', '21421'),
(15, 'hello', 'hello', '2017-11-30', 1, 'default.png', 'hello1@hello.com', NULL),
(16, 'hello1234', 'hello1234', '2017-11-30', 1, 'default.png', 'hello1234@123.com', NULL),
(17, 'hellohello', 'hellohello', '2017-11-30', 1, 'default.png', '123456789@', NULL),
(18, 'max', '321', '2017-11-30', 3, '18.png', 'maxcheung96@gmail.com', ''),
(19, 'lolol', 'lololo', '2017-12-01', 1, 'default.png', '1234567', NULL),
(20, 'testFavourite', 'test', '2017-12-05', 1, '20.png', 'abcdef', 'test'),
(21, 'abc123', '12', '2017-12-06', 1, 'default.png', 'asdas@aq.com', NULL),
(22, 'm123', '123', '2017-12-06', 1, 'default.png', 'M@123.c', NULL),
(23, 'testing', 'testing', '2017-12-06', 1, 'default.png', 'testingitem@testingitem.com', NULL),
(25, 'letmetry', '123', '2017-12-06', 3, 'default.png', 'letsplaykc@gmail.com', NULL),
(33, 'letmecheck', '123', '2017-12-07', 4, '33.png', 'letmecheck@cc.com', NULL),
(34, 'peter', 'peter', '2017-12-07', 1, 'default.png', 'peter@gmail.com', NULL),
(36, 'aaa', 'aaa', '2017-12-07', 4, 'default.png', 'asdas@ff.com', NULL),
(37, 'letmecc', '123', '2017-12-07', 1, '37.png', 'letmecc@cc.com', NULL),
(38, 'admin', 'admin', '2017-12-07', 3, '38.png', 'admin@admin.com', NULL),
(41, 'superadmintest', 'superadmintest', '2017-12-07', 3, 'default.png', '123456780', NULL),
(42, 'admintest', 'admintest', '2017-12-07', 2, 'default.png', '098877654322', NULL),
(43, 'bbc', '123', '2017-12-07', 1, 'default.png', 'bbc@cc.cc', NULL),
(44, '1234', '1234', '2017-12-07', 1, 'default.png', 'dhaj@google.com', NULL),
(45, '789', '789', '2017-12-07', 1, 'default.png', 'hihi@gmail.com', NULL),
(46, '556', '123', '2017-12-07', 3, '46.png', 'tamwaikit95@gmail.com', ''),
(47, 'letmeccc', '123', '2017-12-08', 1, '47.png', 'letmeccc@cc.com', NULL),
(48, 'ytlau', '123', '2017-12-08', 1, 'default.png', '123@gg.com', ''),
(50, 'ytlau05', '123', '2017-12-08', 1, 'default.png', '123@123.com', ''),
(51, 'ytlau0503', '123', '2017-12-08', 1, '51.png', '123@123456.com', ''),
(52, 'ytlau97', '123', '2017-12-08', 1, 'default.png', '123@444.com', ''),
(53, 'ytl', '123', '2017-12-08', 1, 'default.png', '456@789.com', '74181'),
(54, 'lyt', '123', '2017-12-08', 1, '54.png', '789@111.com', ''),
(55, 'lyt1', '123', '2017-12-08', 1, '55.png', 'ytlau0503@gmail.com', '');

-- --------------------------------------------------------

--
-- 資料表結構 `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `type_id` int(2) NOT NULL,
  `type` varchar(20) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `user_type`
--

INSERT INTO `user_type` (`type_id`, `type`, `permission`) VALUES
(1, 'Member', 80),
(2, 'Admin', 140),
(3, 'Super Admin', 255),
(4, 'Blocked User', 0),
(5, 'God', 256),
(6,  'Guest', 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`);

--
-- 資料表索引 `favoriteComment`
--
ALTER TABLE `favoriteComment`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `favoritelist`
--
ALTER TABLE `favoritelist`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `category_id_2` (`category_id`);

--
-- 資料表索引 `reportlist`
--
ALTER TABLE `reportlist`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `type_id` (`type_id`);

--
-- 資料表索引 `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `type_id` (`type_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- 使用資料表 AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=154;
--
-- 使用資料表 AUTO_INCREMENT `favoriteComment`
--
ALTER TABLE `favoriteComment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- 使用資料表 AUTO_INCREMENT `favoritelist`
--
ALTER TABLE `favoritelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- 使用資料表 AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- 使用資料表 AUTO_INCREMENT `reportlist`
--
ALTER TABLE `reportlist`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- 使用資料表 AUTO_INCREMENT `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 資料表的 Constraints `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
