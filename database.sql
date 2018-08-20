CREATE DATABASE IF NOT EXISTS `corpa` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `corpa`;

DROP TABLE IF EXISTS `ca_categories`;
CREATE TABLE IF NOT EXISTS `ca_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `description` text,
  `created_by` varchar(60) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `ca_files`;
CREATE TABLE IF NOT EXISTS `ca_files` (
  `id` int(11) NOT NULL,
  `url` text NOT NULL,
  `original_url` text NOT NULL,
  `filename` text NOT NULL,
  `description` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploader` varchar(60) NOT NULL,
  `expires` int(1) NOT NULL DEFAULT '0',
  `expiry_date` timestamp NOT NULL DEFAULT '2018-12-31 13:00:00',
  `public_allow` int(1) NOT NULL DEFAULT '0',
  `public_token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `ca_files` (`id`, `url`, `original_url`, `filename`, `description`, `timestamp`, `uploader`, `expires`, `expiry_date`, `public_allow`, `public_token`) VALUES
(1, 'upload/video-image-icon-12.jpg', '', 'video-image-icon-12.jpg', 'Test File 01 Description.', '2018-08-20 12:30:33', 'admin', 0, '2018-12-31 13:00:00', 0, NULL),
(2, 'upload/Information Technology Subjects Offered in 2018 (3).pdf', '', 'Information Technology Subjects Offered in 2018 (3).pdf', 'Test File 02 Description: Document', '2018-08-20 12:36:55', 'admin', 0, '2018-12-31 13:00:00', 0, NULL);

DROP TABLE IF EXISTS `ca_folders`;
CREATE TABLE IF NOT EXISTS `ca_folders` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ca_groups`;
CREATE TABLE IF NOT EXISTS `ca_groups` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `public_token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ca_members`;
CREATE TABLE IF NOT EXISTS `ca_members` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(32) NOT NULL,
  `client_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `account_requested` tinyint(1) NOT NULL DEFAULT '0',
  `account_denied` tinyint(1) NOT NULL DEFAULT '0',
  `max_file_size` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `ca_users` (`id`, `user`, `password`, `name`, `email`, `level`, `timestamp`, `address`, `phone`, `notify`, `contact`, `created_by`, `active`, `account_requested`, `account_denied`, `max_file_size`) VALUES
(1, 'admin', '$2a$08$9zpy9Ebv6rXmeVV3M1v.f.dh/cVKPL8sG7H6UhC/Z/6qyNRB/UFOi', 'System Admin', 'admin@127.0.0.1', 9, '2018-08-12 05:30:11', NULL, NULL, 0, NULL, NULL, 1, 0, 0, 0);


ALTER TABLE `ca_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

ALTER TABLE `ca_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file_id` (`file_id`);

ALTER TABLE `ca_files`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ca_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `group_id` (`group_id`);

ALTER TABLE `ca_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ca_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `group_id` (`group_id`);

ALTER TABLE `ca_users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ca_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ca_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ca_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `ca_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ca_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ca_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ca_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

ALTER TABLE `ca_categories`
  ADD CONSTRAINT `ca_categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ca_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `ca_downloads`
  ADD CONSTRAINT `ca_downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ca_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_downloads_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `ca_files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ca_folders`
  ADD CONSTRAINT `ca_folders_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ca_folders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_folders_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `ca_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_folders_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `ca_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ca_members`
  ADD CONSTRAINT `ca_members_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `ca_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ca_members_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `ca_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;