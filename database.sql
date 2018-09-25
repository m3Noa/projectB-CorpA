-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 25, 2018 at 03:39 AM
-- Server version: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `corpa`
--

-- --------------------------------------------------------

--
-- Table structure for table `ca_actions_log`
--

DROP TABLE IF EXISTS `ca_actions_log`;
CREATE TABLE IF NOT EXISTS `ca_actions_log` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action_id` int(2) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_user` text,
  `affected_file` int(11) DEFAULT NULL,
  `affected_account` int(11) DEFAULT NULL,
  `affected_file_name` text,
  `affected_account_name` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_categories`
--

DROP TABLE IF EXISTS `ca_categories`;
CREATE TABLE IF NOT EXISTS `ca_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `description` text,
  `created_by` varchar(60) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_corps`
--

DROP TABLE IF EXISTS `ca_corps`;
CREATE TABLE IF NOT EXISTS `ca_corps` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `public_token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_downloads`
--

DROP TABLE IF EXISTS `ca_downloads`;
CREATE TABLE IF NOT EXISTS `ca_downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remote_ip` varchar(45) DEFAULT NULL,
  `remote_host` text,
  `anonymous` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_files`
--

DROP TABLE IF EXISTS `ca_files`;
CREATE TABLE IF NOT EXISTS `ca_files` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `original_url` text NOT NULL,
  `filename` text NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploader` varchar(60) NOT NULL,
  `corp_id` int(11) DEFAULT NULL,
  `expires` int(1) NOT NULL DEFAULT '0',
  `expiry_date` timestamp NOT NULL DEFAULT '2018-12-31 13:00:00',
  `public_allow` int(1) NOT NULL DEFAULT '0',
  `public_token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_files`
--

INSERT INTO `ca_files` (`id`, `url`, `original_url`, `filename`, `description`, `timestamp`, `uploader`, `corp_id`, `expires`, `expiry_date`, `public_allow`, `public_token`) VALUES
(1, 'upload/male-shadow-fill-circle-512.png', '', 'video-image-icon-12.jpg', 'Test File 01 Description. Test Change2', '2018-08-20 12:30:33', 'admin', NULL, 0, '2018-12-31 13:00:00', 0, NULL),
(2, 'upload/Information Technology Subjects Offered in 2018 (3).pdf', '', 'Information Technology Subjects Offered in 2018 (3).pdf', 'Test File 02 Description: Document', '2018-08-20 12:36:55', 'admin', NULL, 0, '2018-12-31 13:00:00', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ca_folders`
--

DROP TABLE IF EXISTS `ca_folders`;
CREATE TABLE IF NOT EXISTS `ca_folders` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_members`
--

DROP TABLE IF EXISTS `ca_members`;
CREATE TABLE IF NOT EXISTS `ca_members` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `corp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_users`
--

DROP TABLE IF EXISTS `ca_users`;
CREATE TABLE IF NOT EXISTS `ca_users` (
  `id` int(11) NOT NULL,
  `user` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(60) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` text,
  `phone` varchar(32) DEFAULT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `contact` text,
  `created_by` varchar(60) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `corp_id` int(11) DEFAULT NULL,
  `max_file_size` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_users`
--

INSERT INTO `ca_users` (`id`, `user`, `password`, `name`, `email`, `level`, `timestamp`, `address`, `phone`, `notify`, `contact`, `created_by`, `active`, `corp_id`, `max_file_size`) VALUES
(1, 'admin', '$2a$08$9zpy9Ebv6rXmeVV3M1v.f.dh/cVKPL8sG7H6UhC/Z/6qyNRB/UFOi', 'System Admin', 'admin@127.0.0.1', 9, '2018-08-12 05:30:11', NULL, NULL, 0, NULL, NULL, 1, 0, 0),
(2, 'corpuser1', '$2y$10$3dsqi3lEiVPnsJzUAG/tCucd3FWMmbCkLtKCSBseqqfQ2XFslzNpW', 'Corporation-A Manager', '', 8, '2018-08-27 12:36:16', NULL, NULL, 0, NULL, NULL, 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ca_actions_log`
--
ALTER TABLE `ca_actions_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ca_categories`
--
ALTER TABLE `ca_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `ca_corps`
--
ALTER TABLE `ca_corps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ca_downloads`
--
ALTER TABLE `ca_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `ca_files`
--
ALTER TABLE `ca_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ca_folders`
--
ALTER TABLE `ca_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `ca_members`
--
ALTER TABLE `ca_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`user_id`),
  ADD KEY `group_id` (`corp_id`);

--
-- Indexes for table `ca_users`
--
ALTER TABLE `ca_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ca_actions_log`
--
ALTER TABLE `ca_actions_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ca_categories`
--
ALTER TABLE `ca_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ca_corps`
--
ALTER TABLE `ca_corps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ca_downloads`
--
ALTER TABLE `ca_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ca_files`
--
ALTER TABLE `ca_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ca_folders`
--
ALTER TABLE `ca_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ca_members`
--
ALTER TABLE `ca_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ca_users`
--
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ca_categories`
--
ALTER TABLE `ca_categories`
  ADD CONSTRAINT `ca_categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ca_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ca_downloads`
--
ALTER TABLE `ca_downloads`
  ADD CONSTRAINT `ca_downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ca_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_downloads_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `ca_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ca_folders`
--
ALTER TABLE `ca_folders`
  ADD CONSTRAINT `ca_folders_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ca_folders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_folders_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `ca_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_folders_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `ca_corps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ca_members`
--
ALTER TABLE `ca_members`
  ADD CONSTRAINT `ca_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ca_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_members_ibfk_2` FOREIGN KEY (`corp_id`) REFERENCES `ca_corps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
