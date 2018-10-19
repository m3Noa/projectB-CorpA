-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 19, 2018 at 12:40 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.26
--
-- Database: `id6863564_corpa`
--

-- --------------------------------------------------------

--
-- Table structure for table `ca_action_logs`
--

DROP TABLE IF EXISTS `ca_action_logs`;
CREATE TABLE `ca_action_logs` (
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

--
-- Dumping data for table `ca_action_logs`
--

INSERT INTO `ca_action_logs` (`id`, `timestamp`, `action_id`, `owner_id`, `owner_user`, `affected_file`, `affected_account`, `affected_file_name`, `affected_account_name`) VALUES
(1, '2018-10-18 04:18:55', 1, 1, 'admin', 0, 0, '', ''),
(2, '2018-10-18 04:28:39', 12, 1, 'admin', 0, 0, '', ''),
(3, '2018-10-18 04:31:12', 12, 1, 'admin', 2, 0, '', ''),
(4, '2018-10-18 04:35:24', 12, 1, 'admin', 2, 0, 'Information Technology Subjects Offered in 2018 (3).pdf', ''),
(5, '2018-10-18 06:14:33', 1, 1, 'admin', 0, 0, '', ''),
(6, '2018-10-18 06:17:25', 1, 1, 'admin', 0, 0, '', ''),
(7, '2018-10-18 06:24:52', 1, 1, 'admin', 0, 0, '', ''),
(8, '2018-10-18 06:43:02', 1, 1, 'admin', 0, 0, '', ''),
(9, '2018-10-18 07:03:57', 1, 1, 'admin', 0, 0, '', ''),
(10, '2018-10-18 07:05:30', 1, 1, 'admin', 0, 0, '', ''),
(11, '2018-10-18 07:06:31', 1, 1, 'admin', 0, 0, '', ''),
(12, '2018-10-18 07:12:37', 1, 1, 'admin', 0, 0, '', ''),
(13, '2018-10-18 07:17:48', 1, 7, 'user04', 0, 0, '', ''),
(14, '2018-10-18 07:19:40', 1, 1, 'admin', 0, 0, '', ''),
(15, '2018-10-18 07:26:41', 1, 1, 'admin', 0, 0, '', ''),
(16, '2018-10-18 07:29:51', 19, 1, 'admin', 2, 0, 'Information Technology Subjects Offered in 2018 (3).pdf', ''),
(17, '2018-10-18 07:50:54', 1, 1, 'admin', 0, 0, '', ''),
(18, '2018-10-18 08:01:54', 1, 1, 'admin', 0, 0, '', ''),
(19, '2018-10-18 08:11:15', 3, 1, 'admin', 0, 0, 'test file 05', ''),
(20, '2018-10-18 08:27:06', 1, 8, 'user05', 0, 0, '', ''),
(21, '2018-10-18 08:29:55', 1, 1, 'admin', 0, 0, '', ''),
(22, '2018-10-18 08:34:31', 2, 1, 'admin', 0, 0, '', 'manager03'),
(23, '2018-10-18 08:35:44', 2, 1, 'admin', 0, 0, '', 'managerCo01'),
(24, '2018-10-18 08:36:09', 1, 1, 'admin', 0, 0, '', ''),
(25, '2018-10-18 08:36:24', 1, 11, 'managerCo01', 0, 0, '', ''),
(26, '2018-10-18 08:44:54', 1, 8, 'user05', 0, 0, '', ''),
(27, '2018-10-18 08:53:20', 4, 8, 'user05', 2, 0, '', ''),
(28, '2018-10-18 08:54:05', 12, 8, 'user05', 1, 0, 'video-image-icon-12', ''),
(29, '2018-10-18 08:54:20', 12, 8, 'user05', 1, 0, 'video-image-icon-12', ''),
(30, '2018-10-18 08:54:49', 12, 8, 'user05', 1, 0, 'video-image-icon-12', ''),
(31, '2018-10-18 08:55:00', 12, 8, 'user05', 1, 0, 'video-image-icon-12', ''),
(32, '2018-10-18 08:55:11', 12, 8, 'user05', 1, 0, 'video-image-icon-12', ''),
(33, '2018-10-18 08:55:20', 1, 1, 'admin', 0, 0, '', ''),
(34, '2018-10-18 09:15:52', 1, 1, 'admin', 0, 0, '', ''),
(35, '2018-10-18 09:16:51', 1, 8, 'user05', 0, 0, '', ''),
(36, '2018-10-18 09:21:40', 12, 8, 'user05', 4, 0, 'test file 05', ''),
(37, '2018-10-18 09:22:41', 1, 11, 'managerCo01', 0, 0, '', ''),
(38, '2018-10-18 09:27:14', 12, 1, 'admin', 2, 0, 'Information Technology Subjects Offered in 2018 (3).pdf', ''),
(39, '2018-10-18 11:15:12', 1, 1, 'admin', 0, 0, '', ''),
(40, '2018-10-18 11:16:32', 2, 0, 'haphung', 0, 0, '', ''),
(41, '2018-10-18 11:16:52', 1, 12, 'haphung', 0, 0, '', ''),
(42, '2018-10-18 11:24:42', 1, 1, 'admin', 0, 0, '', ''),
(43, '2018-10-18 11:27:47', 14, 1, 'admin', 0, 0, '', 'admin'),
(44, '2018-10-18 11:30:07', 2, 1, 'admin', 0, 0, '', 'hamalun'),
(45, '2018-10-18 11:30:25', 1, 13, 'hamalun', 0, 0, '', ''),
(46, '2018-10-18 11:34:38', 1, 12, 'haphung', 0, 0, '', ''),
(47, '2018-10-18 11:40:20', 1, 1, 'admin', 0, 0, '', ''),
(48, '2018-10-18 11:48:49', 1, 7, 'user04', 0, 0, '', ''),
(49, '2018-10-18 11:51:05', 1, 1, 'admin', 0, 0, '', ''),
(50, '2018-10-18 12:02:18', 1, 1, 'admin', 0, 0, '', ''),
(51, '2018-10-18 12:03:36', 1, 1, 'admin', 0, 0, '', ''),
(52, '2018-10-19 07:14:48', 1, 1, 'admin', 0, 0, '', ''),
(53, '2018-10-19 09:09:54', 1, 1, 'admin', 0, 0, '', ''),
(54, '2018-10-19 09:11:16', 2, 1, 'admin', 0, 0, '', 'newUser01'),
(55, '2018-10-19 09:46:11', 1, 1, 'admin', 0, 0, '', ''),
(56, '2018-10-19 09:48:03', 2, 0, 'Chris', 0, 0, '', ''),
(57, '2018-10-19 09:48:13', 1, 15, 'Chris', 0, 0, '', ''),
(58, '2018-10-19 09:58:30', 14, 1, 'admin', 0, 0, '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `ca_categories`
--

DROP TABLE IF EXISTS `ca_categories`;
CREATE TABLE `ca_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `description` text,
  `created_by` varchar(60) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_comments`
--

DROP TABLE IF EXISTS `ca_comments`;
CREATE TABLE `ca_comments` (
  `id` int(11) NOT NULL,
  `user` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` tinyint(1) DEFAULT NULL,
  `comment` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ca_comments`
--

INSERT INTO `ca_comments` (`id`, `user`, `file_id`, `timestamp`, `rating`, `comment`) VALUES
(1, 'admin', 2, '2018-10-18 03:16:43', 3, 'A sample comment for file ID 2.'),
(2, 'admin', 2, '2018-10-18 03:17:46', 3, 'A simple comment for file is 2'),
(3, 'admin', 2, '2018-10-18 03:18:58', 0, 'A simple comment for file 2'),
(4, 'admin', 2, '2018-10-18 03:21:53', 0, 'A simple comment'),
(5, 'admin', 0, '2018-10-18 03:35:57', 5, 'A new comment'),
(6, 'admin', 0, '2018-10-18 03:37:59', 1, 'Another comment'),
(7, 'admin', 2, '2018-10-18 03:40:36', 0, 'Another comment....'),
(8, 'admin', 2, '2018-10-18 04:28:39', 0, 'A new new comment with action log.'),
(9, 'admin', 2, '2018-10-18 04:31:12', 0, 'Another new new comment with action log.'),
(10, 'admin', 2, '2018-10-18 04:35:23', 0, 'Another new comment with action log.'),
(11, 'user05', 1, '2018-10-18 08:54:05', 0, '<br />\r\n<b>Notice</b>:  Undefined variable: comt_content in <b>/storage/ssd1/564/6863564/public_html/includes/post-comment.php</b> on line <b>13</b><br />\r\n'),
(12, 'user05', 1, '2018-10-18 08:54:20', 0, 'hahaha is one is goood\r\n'),
(13, 'user05', 1, '2018-10-18 08:54:49', 0, 'the world is mine now'),
(14, 'user05', 1, '2018-10-18 08:55:00', 0, 'the world is mine now'),
(15, 'user05', 1, '2018-10-18 08:55:11', 0, 'the world is mine now'),
(16, 'user05', 4, '2018-10-18 09:21:40', 3, 'A test comment'),
(17, 'admin', 2, '2018-10-18 09:27:14', 0, 'Admin Test comment\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `ca_corps`
--

DROP TABLE IF EXISTS `ca_corps`;
CREATE TABLE `ca_corps` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_photo` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_corps`
--

INSERT INTO `ca_corps` (`id`, `timestamp`, `created_by`, `name`, `address`, `phone`, `description`, `active`, `profile_photo`) VALUES
(1, '2018-10-17 22:46:44', 'user01', 'Corp A', NULL, NULL, 'A test profile.', 1, ''),
(2, '2018-10-17 23:33:32', 'admin', 'Corp B', NULL, NULL, 'A Simple Description.', 1, ''),
(3, '2018-10-18 11:27:47', 'admin', 'latrobe', NULL, NULL, 'uni', 1, ''),
(4, '2018-10-19 09:58:30', 'admin', 'Corp C', '574, Barkly St', '1435200470', 'Corp C Description.', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ca_downloads`
--

DROP TABLE IF EXISTS `ca_downloads`;
CREATE TABLE `ca_downloads` (
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
CREATE TABLE `ca_files` (
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
  `public_allow` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_files`
--

INSERT INTO `ca_files` (`id`, `url`, `original_url`, `filename`, `description`, `timestamp`, `uploader`, `corp_id`, `expires`, `expiry_date`, `public_allow`) VALUES
(1, 'upload/male-shadow-fill-circle-512.png', '', 'video-image-icon-12', 'Test File 01 Description. Test Change3', '2018-08-20 12:30:33', 'admin', 1, 0, '2018-12-31 13:00:00', 0),
(2, 'upload/Information Technology Subjects Offered in 2018 (3).pdf', '', 'Information Technology Subjects Offered in 2018 (3).pdf', 'Test File 02 Description: Document.\r\nTest File 02 Description: Document.\r\nTest File 02 Description: Document.\r\nTest File 02 Description: Document.\r\nTest File 02 Description: Document.\r\nTest File 02 Description: Document.\r\nTest File 02 Description: Document.\r\n\r\nTest File 02 Description: Document.\r\nTest File 02 Description: Document.', '2018-08-20 12:36:55', 'admin', 0, 0, '2018-12-31 13:00:00', 0),
(4, 'upload/what-does-it-mean-when-cat-wags-tail.jpg', '', 'test file 05', 'File Description.', '2018-10-18 08:11:15', 'admin', 0, 0, '2018-12-31 13:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ca_folders`
--

DROP TABLE IF EXISTS `ca_folders`;
CREATE TABLE `ca_folders` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ca_users`
--

DROP TABLE IF EXISTS `ca_users`;
CREATE TABLE `ca_users` (
  `id` int(11) NOT NULL,
  `user` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` text NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ca_users`
--

INSERT INTO `ca_users` (`id`, `user`, `password`, `name`, `avatar`, `email`, `level`, `timestamp`, `address`, `phone`, `notify`, `contact`, `created_by`, `active`, `corp_id`, `max_file_size`) VALUES
(1, 'admin', '$2a$08$9zpy9Ebv6rXmeVV3M1v.f.dh/cVKPL8sG7H6UhC/Z/6qyNRB/UFOi', 'System Admin', NULL, 'admin@127.0.0.1', 9, '2018-08-12 05:30:11', NULL, NULL, 0, NULL, NULL, 1, 0, 0),
(2, 'manager', '$2y$10$t9odJ.b8oAUBKg9fDDIWY.ASsCgXNiuXxe7nJHGxIAlckywiC8EX6', 'Corporation-A Manager 01', NULL, 'test@email.com', 8, '2018-08-27 12:36:16', NULL, NULL, 0, NULL, NULL, 1, 1, 0),
(3, 'user02', '$2y$10$geLX5ZjE7AG0W/glxqGb1efEOqVajMPmdJQd0kIWzFyBhfViFSXHy', 'Corporation-A User', NULL, '', 7, '2018-09-25 06:31:53', NULL, NULL, 0, NULL, NULL, 1, 1, 0),
(4, 'user03', '$2y$10$.zGGvzoS8GkFIjD6du8fc.oeo8McOCAP9s7wHMYtZXoJnyO3tRjC2', 'Corporation-A Manager 2', NULL, '', 8, '2018-09-25 07:23:31', NULL, NULL, 0, NULL, 'admin', 1, 1, 0),
(7, 'user04', '$2y$10$PM9X3MgCYCxYadE62Pdb.uuTxWD5vuE6Cp0Gp/c5Ggjhw9qDk8hkK', 'Normal User 04', NULL, '', 7, '2018-10-18 01:27:51', NULL, NULL, 0, NULL, 'admin', 1, 2, 0),
(8, 'user05', '$2y$10$JZA7cL96JXpSgniKSn7thuIjFfO6PJ3MrRyjEA6S5k5c4m.L0nat6', 'The Vu Pham', NULL, '', 7, '2018-10-18 08:22:35', NULL, NULL, 0, NULL, 'admin', 1, 2, 0),
(9, 'manager01', '$2y$10$oYDAMLPwEQ0kZyUnVOxbDuyrMQkZIVv9s6J3llqg6ARdC0oROaVKe', 'Pham The Vu', NULL, '', 8, '2018-10-18 08:31:41', NULL, NULL, 0, NULL, NULL, 1, NULL, 0),
(10, 'manager03', '$2y$10$O/Qy4ZnmQQgO7nkj79iwxOzLFSd2mp3OxN.pEK2YtJoo7KUBn58ze', 'The Vu Pham', NULL, '', 8, '2018-10-18 08:34:31', NULL, NULL, 0, NULL, 'admin', 1, 2, 0),
(11, 'managerCo01', '$2y$10$1NnJf5zp9gsgcNwUAAqmuuDzbK.AwhiNrNLmm0..DLKWcAMPjPQG6', 'Tran Ngoc Ha', NULL, '', 8, '2018-10-18 08:35:44', NULL, NULL, 0, NULL, 'admin', 1, 1, 0),
(12, 'haphung', '$2y$10$XVDLv7WgpkXNXPZjIJz9G.tRVoDGIz4xyCksnBcCRT0bgY1DnjgT.', '', NULL, '', 7, '2018-10-18 11:16:32', NULL, NULL, 0, NULL, NULL, 1, NULL, 0),
(13, 'hamalun', '$2y$10$7BLBYZ2LLTZeNwCNDsyQWObwJq8VzXh2vBs.Grt041SesgUgA5rhG', '', NULL, '', 8, '2018-10-18 11:30:07', NULL, NULL, 0, NULL, 'admin', 1, 1, 0),
(14, 'newUser01', '$2y$10$5sGttJy15IZZRE5hhMUamuUEzsIL2p4BJb/dn2hcwB8IgFMrvFqJy', 'General user', NULL, '', 8, '2018-10-19 09:11:16', NULL, NULL, 0, NULL, 'admin', 1, 2, 0),
(15, 'Chris', '$2y$10$SxRSr1Bw5TfBEEClEnQfi.igKdKSfI87eRfKIb2MofnFNoMLiBwNW', 'Li', NULL, '', 7, '2018-10-19 09:48:03', NULL, NULL, 0, NULL, NULL, 1, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ca_action_logs`
--
ALTER TABLE `ca_action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ca_categories`
--
ALTER TABLE `ca_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `ca_comments`
--
ALTER TABLE `ca_comments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `ca_users`
--
ALTER TABLE `ca_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ca_action_logs`
--
ALTER TABLE `ca_action_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `ca_categories`
--
ALTER TABLE `ca_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ca_comments`
--
ALTER TABLE `ca_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ca_corps`
--
ALTER TABLE `ca_corps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ca_downloads`
--
ALTER TABLE `ca_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ca_files`
--
ALTER TABLE `ca_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ca_folders`
--
ALTER TABLE `ca_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ca_users`
--
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
COMMIT;
