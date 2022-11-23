-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2022 at 11:34 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memories`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `followerid` int(11) NOT NULL AUTO_INCREMENT,
  `followedUserid` int(11) NOT NULL,
  `followerUserid` int(11) NOT NULL,
  PRIMARY KEY (`followerid`),
  KEY `followedUserid` (`followedUserid`),
  KEY `followerUserid` (`followerUserid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`followerid`, `followedUserid`, `followerUserid`) VALUES
(26, 2, 1),
(29, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `likeid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  PRIMARY KEY (`likeid`),
  KEY `userid` (`userid`),
  KEY `postid` (`postid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likeid`, `userid`, `postid`) VALUES
(5, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `postid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `postImage` text,
  `caption` varchar(255) DEFAULT NULL,
  `postDate` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`postid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `userid`, `postImage`, `caption`, `postDate`, `location`) VALUES
(10, 2, './uploads/about-image-2.jpg', 'Wow', '2022-11-17', 'Moorabbin'),
(11, 2, './uploads/dan-meyers-IQVFVH0ajag-unsplash 1.png', 'This is pretty cool', '2022-11-17', 'Moorabbin'),
(12, 2, './uploads/kym-ellis-aF1NPSnDQLw-unsplash 1.png', 'This is a post', '2022-11-17', 'Melbourne'),
(13, 2, './uploads/thesmith.jpg', 'Another test', '2022-11-17', 'Moorabbin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `firstname`, `lastname`, `email`, `username`, `password`, `profilePic`, `bio`) VALUES
(1, 'Katrina', 'Gill', 'katrinafgill@gmail.com', 'TheBestTest', '$2y$10$UJSCbf2j09gWY.iVCCcvLu0cq/rM7Oo5LAIQGfzuRXhnpkSFq4Fpq', './profileImages/memories-profile-pic.jpg', 'Hey'),
(2, 'Test', 'Tester', 'test@test.com', 'FriendlyTester', '$2y$10$Yus18826DU.gl257ttkipeFBDswAL.GGhKlBGcvC7/bCaynplORn.', './profileImages/memories-profile-pic.jpg', 'Hello There'),
(3, 'Katrina', 'Gill', 'katrinafgill@gmail.com', 'HelloThere', '$2y$10$0M8Qyj4nMPzUw2uXXIDQI.7ejfGuO1sINuwTAbA90se9dNAXf5z8q', './profileImages/eye-fillet.jpg', 'Hello there'),
(4, 'Test', 'Test', 'anotherTest@gmail.com', 'Tester', '$2y$10$VO95AfrJJTbzdomO6ksb0.jYERb21OLLJG9.9xhHPRKkDGJrbJKp6', './profileImages/seafood-linguine.jpg', 'Tester'),
(5, 'Angus', 'Gill', 'agill@gmail.com', 'Gilly9', '$2y$10$5McVY2mNjHSZlbSNNxZJ8eqhENNlms02Hal6eFMRmrThy.PTwWX6G', './profileImages/kym-ellis-aF1NPSnDQLw-unsplash 1.png', 'Carlton Flaggers #2023');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`followedUserid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`followerUserid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `posts` (`postid`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
