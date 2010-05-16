-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2010 at 12:30 AM
-- Server version: 5.0.83
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lynx`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` char(36) NOT NULL,
  `company_id` char(36) NOT NULL,
  `login` varchar(128) NOT NULL,
  `peaches` char(40) NOT NULL,
  PRIMARY KEY  (`user_id`),
  KEY `login` (`login`,`peaches`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `company_id`, `login`, `peaches`) VALUES
('b4764fae-3fc5-11df-bc54-001fe25a4467', 'e89f0bde-3fe5-11df-bc54-001fe25a4467', 'travis', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8');
