-- MySQL dump 10.10
--
-- Host: localhost    Database: kkk
-- ------------------------------------------------------
-- Server version	5.0.22-Debian_0ubuntu6.06.3-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jump_page`
--

DROP TABLE IF EXISTS `jump_page`;
CREATE TABLE `jump_page` (
  `jump_page_id` int(10) unsigned NOT NULL auto_increment,
  `page_title` varchar(50) NOT NULL default '',
  `page_html_title` varchar(255) NOT NULL default '',
  `layout_type` enum('basic','deep') NOT NULL default 'deep',
  `page_slug` varchar(25) NOT NULL default '',
  `access_level` enum('admin','mod','user','public') NOT NULL default 'user',
  `php_script` varchar(100) NOT NULL default '',
  `active` enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (`jump_page_id`),
  UNIQUE KEY `page_slug` (`page_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pet_specie`
--

DROP TABLE IF EXISTS `pet_specie`;
CREATE TABLE `pet_specie` (
  `pet_specie_id` int(11) NOT NULL auto_increment,
  `specie_name` varchar(50) NOT NULL,
  `specie_descr` text NOT NULL,
  `relative_image_dir` varchar(200) NOT NULL,
  `max_hunger` tinyint(3) unsigned NOT NULL,
  `max_happiness` tinyint(3) unsigned NOT NULL,
  `available` enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (`pet_specie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pet_specie_color`
--

DROP TABLE IF EXISTS `pet_specie_color`;
CREATE TABLE `pet_specie_color` (
  `pet_specie_color_id` int(11) NOT NULL auto_increment,
  `color_name` varchar(30) NOT NULL,
  `color_img` varchar(200) NOT NULL,
  `base_color` enum('N','Y') NOT NULL default 'N',
  PRIMARY KEY  (`pet_specie_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pet_specie_pet_specie_color`
--

DROP TABLE IF EXISTS `pet_specie_pet_specie_color`;
CREATE TABLE `pet_specie_pet_specie_color` (
  `pet_specie_pet_specie_color_id` int(11) NOT NULL auto_increment,
  `pet_specie_id` int(11) NOT NULL,
  `pet_specie_color_id` int(11) NOT NULL,
  PRIMARY KEY  (`pet_specie_pet_specie_color_id`),
  UNIQUE KEY `pet_specie_id` (`pet_specie_id`,`pet_specie_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Links a color to a specie. Without entry, specie cannot beco';

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `currency` bigint(20) unsigned NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `password_hash` varchar(32) default NULL,
  `registered_ip_addr` varchar(16) default NULL,
  `last_ip_addr` varchar(16) default NULL,
  `last_activity` datetime default NULL,
  `access_level` enum('banned','user','mod','admin') NOT NULL default 'user',
  `email` varchar(255) NOT NULL default '',
  `age` smallint(3) unsigned NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `profile` text NOT NULL,
  `datetime_created` datetime default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_pet`
--

DROP TABLE IF EXISTS `user_pet`;
CREATE TABLE `user_pet` (
  `user_pet_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `pet_specie_id` int(11) NOT NULL,
  `pet_specie_color_id` int(11) NOT NULL,
  `pet_name` varchar(25) NOT NULL,
  `hunger` tinyint(3) unsigned NOT NULL,
  `happiness` tinyint(3) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`user_pet_id`),
  KEY `user_id` (`user_id`),
  KEY `pet_specie_id` (`pet_specie_id`,`pet_specie_color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Pets = specie + user + color.';
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
