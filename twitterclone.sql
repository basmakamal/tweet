-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 23, 2018 at 08:57 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitterclone`
--

-- --------------------------------------------------------

--
-- Table structure for table `gig_user`
--

CREATE TABLE `gig_user` (
  `id` int(11) NOT NULL,
  `user_add` int(11) DEFAULT NULL,
  `user_upd` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gig_user`
--

INSERT INTO `gig_user` (`id`, `user_add`, `user_upd`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `facebook_id`, `google_id`, `date_add`, `date_upd`) VALUES
(1, NULL, NULL, 'basmakjkjkjkjkjk', 'basmakjkjkjkjkjk', 'shbdgshadga@yahoo.com', 'shbdgshadga@yahoo.com', 1, '926pv2f3h44kw00k4wsw04g84kc44wc', '$2y$13$926pv2f3h44kw00k4wsw0uP8dk99.iypeuvBjcVRBV1o2a.RvC7k6', '2018-05-20 15:56:03', NULL, NULL, 'a:0:{}', NULL, NULL, '2018-05-20 15:56:03', '2018-05-20 15:56:03'),
(2, NULL, NULL, 'testtest', 'testtest', 'basmabasma@yahoo.com', 'basmabasma@yahoo.com', 1, NULL, '$2y$13$VZ3ntPzeC1QYdAA2ZZF4ku87b0TrLrMmOMf3ob5ljad8aEm4ZfXGi', '2018-05-21 12:56:15', NULL, NULL, 'a:0:{}', NULL, NULL, '2018-05-21 12:56:15', '2018-05-21 12:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_follow`
--

CREATE TABLE `user_follow` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_follow_id` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tweets`
--

CREATE TABLE `user_tweets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tweets_like`
--

CREATE TABLE `user_tweets_like` (
  `id` int(11) NOT NULL,
  `user_tweets_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gig_user`
--
ALTER TABLE `gig_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A247115092FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_A2471150A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_A2471150C05FB297` (`confirmation_token`),
  ADD KEY `IDX_A2471150160C126C` (`user_add`),
  ADD KEY `IDX_A2471150238DCE95` (`user_upd`);

--
-- Indexes for table `user_follow`
--
ALTER TABLE `user_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D665F4DA76ED395` (`user_id`),
  ADD KEY `IDX_D665F4D87F15E58` (`user_follow_id`);

--
-- Indexes for table `user_tweets`
--
ALTER TABLE `user_tweets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CF6A5B18A76ED395` (`user_id`);

--
-- Indexes for table `user_tweets_like`
--
ALTER TABLE `user_tweets_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B4F8E13F805C3BEE` (`user_tweets_id`),
  ADD KEY `IDX_B4F8E13FA76ED395` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gig_user`
--
ALTER TABLE `gig_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_follow`
--
ALTER TABLE `user_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_tweets`
--
ALTER TABLE `user_tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_tweets_like`
--
ALTER TABLE `user_tweets_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `gig_user`
--
ALTER TABLE `gig_user`
  ADD CONSTRAINT `FK_A2471150160C126C` FOREIGN KEY (`user_add`) REFERENCES `gig_user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_A2471150238DCE95` FOREIGN KEY (`user_upd`) REFERENCES `gig_user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_follow`
--
ALTER TABLE `user_follow`
  ADD CONSTRAINT `FK_D665F4D87F15E58` FOREIGN KEY (`user_follow_id`) REFERENCES `gig_user` (`id`),
  ADD CONSTRAINT `FK_D665F4DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `gig_user` (`id`);

--
-- Constraints for table `user_tweets`
--
ALTER TABLE `user_tweets`
  ADD CONSTRAINT `FK_CF6A5B18A76ED395` FOREIGN KEY (`user_id`) REFERENCES `gig_user` (`id`);

--
-- Constraints for table `user_tweets_like`
--
ALTER TABLE `user_tweets_like`
  ADD CONSTRAINT `FK_B4F8E13F805C3BEE` FOREIGN KEY (`user_tweets_id`) REFERENCES `user_tweets` (`id`),
  ADD CONSTRAINT `FK_B4F8E13FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `gig_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
