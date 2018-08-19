-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.dashboard.topular.in
-- Generation Time: Feb 29, 2016 at 11:55 AM
-- Server version: 5.6.25
-- PHP Version: 5.5.32

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `topular`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `bitly_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `image_url` varchar(2083) COLLATE utf8_unicode_ci NOT NULL,
  `image_width` smallint(6) NOT NULL,
  `image_height` smallint(6) NOT NULL,
  `word_count` int(11) NOT NULL,
  `date_published` datetime NOT NULL,
  `source_id` int(10) unsigned NOT NULL,
  `fb_likes` int(10) unsigned NOT NULL,
  `fb_shares` int(10) unsigned NOT NULL,
  `retweets` int(10) unsigned NOT NULL,
  `linkedin_shares` int(10) unsigned NOT NULL,
  `score` int(10) unsigned NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  `category_rank` int(10) unsigned NOT NULL,
  `movement_day` int(11) NOT NULL,
  `movement_week` int(11) NOT NULL,
  `movement_month` int(11) NOT NULL,
  `trend` int(11) NOT NULL,
  `age` smallint(6) NOT NULL,
  `hidden` binary(1) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `date_published` (`date_published`),
  KEY `fk_article_source_idx` (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=204541 ;

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL,
  `fb_likes` int(10) unsigned NOT NULL,
  `fb_shares` int(10) unsigned NOT NULL,
  `retweets` int(10) unsigned NOT NULL,
  `linkedin_shares` int(10) unsigned NOT NULL,
  `score` int(10) unsigned NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  `age` smallint(5) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1009300 ;
