-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2010 at 10:19 PM
-- Server version: 5.0.83
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lynx`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` char(36) NOT NULL,
  `permission_name` varchar(36) NOT NULL,
  PRIMARY KEY  (`permission_id`),
  UNIQUE KEY `permission_name` (`permission_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`) VALUES
('c8b476a6-66b4-11df-a574-001fe25a4467', 'skip_maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` char(36) NOT NULL,
  `role_name` varchar(36) NOT NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
('89e4f0d2-66b3-11df-a574-001fe25a4467', 'guest'),
('89e4f4f6-66b3-11df-a574-001fe25a4467', 'member'),
('9387d032-66b3-11df-a574-001fe25a4467', 'moderator'),
('9387d21c-66b3-11df-a574-001fe25a4467', 'administrator'),
('9ad9cd0e-66b3-11df-a574-001fe25a4467', 'developer');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `rp_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `permission_id` char(36) NOT NULL,
  PRIMARY KEY  (`rp_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`rp_id`, `role_id`, `permission_id`) VALUES
('ddc6ea56-66b4-11df-a574-001fe25a4467', '9ad9cd0e-66b3-11df-a574-001fe25a4467', 'c8b476a6-66b4-11df-a574-001fe25a4467'),
('ddc6ecfe-66b4-11df-a574-001fe25a4467', '9387d21c-66b3-11df-a574-001fe25a4467', 'c8b476a6-66b4-11df-a574-001fe25a4467');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` char(36) NOT NULL,
  `login` varchar(128) NOT NULL,
  `peaches` char(40) NOT NULL,
  PRIMARY KEY  (`user_id`),
  KEY `login` (`login`,`peaches`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `login`, `peaches`) VALUES
('b4764fae-3fc5-11df-bc54-001fe25a4467', 'travis', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
('b4764fae-3fc5-11df-bc54-001fe25a4467', '9ad9cd0e-66b3-11df-a574-001fe25a4467'),
('b4764fae-3fc5-11df-bc54-001fe25a4467', '9387d21c-66b3-11df-a574-001fe25a4467');