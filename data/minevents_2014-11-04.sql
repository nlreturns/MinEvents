-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2014 at 05:07 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `minevents`
--

-- --------------------------------------------------------

--
-- Table structure for table `afdeling`
--

CREATE TABLE IF NOT EXISTS `afdeling` (
  `afdeling_id` int(11) NOT NULL AUTO_INCREMENT,
  `afdeling_naam` varchar(50) NOT NULL,
  `afdeling_beschrijving` varchar(255) NOT NULL,
  PRIMARY KEY (`afdeling_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `afdeling`
--

INSERT INTO `afdeling` (`afdeling_id`, `afdeling_naam`, `afdeling_beschrijving`) VALUES
(1, 'Bowlingbaan', ''),
(2, 'Bar', ''),
(3, 'Lasergamen', 'Lasers'),
(4, 'Test Afdeling', 'Test beschrijving van ''Test Afdeling''');

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker`
--

CREATE TABLE IF NOT EXISTS `gebruiker` (
  `gebruiker_id` int(11) NOT NULL AUTO_INCREMENT,
  `gebruiker_naam` varchar(45) NOT NULL,
  `gebruiker_tijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gebruiker_recht` varchar(2048) NOT NULL,
  `sessie_id` int(10) NOT NULL,
  `gebruiker_wachtwoord` varchar(1024) NOT NULL,
  PRIMARY KEY (`gebruiker_id`),
  UNIQUE KEY `gebruiker_naam` (`gebruiker_naam`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `gebruiker`
--

INSERT INTO `gebruiker` (`gebruiker_id`, `gebruiker_naam`, `gebruiker_tijd`, `gebruiker_recht`, `sessie_id`, `gebruiker_wachtwoord`) VALUES
(43, 'Bjorn', '2013-12-15 22:20:15', '1', 2, 'ff67694a8c31c618252f9a8c1cce6f6c'),
(44, 'Arti', '2013-12-15 22:12:53', '1', 2, 'ff67694a8c31c618252f9a8c1cce6f6c'),
(87, 'Recluster', '2013-12-19 19:31:55', '1', 2, '1282733e4f4e13422f360c7931ae4869'),
(90, 'test', '2014-01-21 09:40:54', '1', 0, 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3'),
(91, 'Gebruikersnaam', '2014-01-30 08:23:12', '1', 2, '701f33b8d1366cde9cb3822256a62c01'),
(92, 'gebruker2', '2014-04-02 07:53:12', '2', 2, '701f33b8d1366cde9cb3822256a62c01'),
(99, 'Donny', '2014-09-23 07:02:44', 'O:13:"RechtBitfield":1:{s:29:"\\0RechtBitfield\\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\\0Bitfield\\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\\0Bitfield\\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\\0Bitfield\\0bitfield";i:4;}}}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(107, 'test_data2', '2014-09-23 07:28:01', 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:1:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:0;}}}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(108, 'admin', '2014-11-04 14:05:26', 'a:5:{i:0;s:1:"1";i:1;s:1:"8";i:2;s:2:"16";i:3;s:3:"128";i:4;s:3:"256";}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(109, 'test_data5', '2014-09-23 07:43:56', 'a:9:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"8";i:4;s:2:"16";i:5;s:2:"32";i:6;s:2:"64";i:7;s:3:"128";i:8;s:3:"256";}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(110, 'serdar', '2014-10-03 09:42:05', 'a:1:{i:0;s:2:"64";}', 2, 'acb630328c03ff814694a44e7cc7d083'),
(111, 'test_data12', '2014-10-27 13:40:35', 'a:2:{i:0;s:1:"1";i:1;s:3:"128";}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(112, 'TestGebruiker', '2014-11-03 13:57:47', 'a:2:{i:0;s:1:"1";i:1;s:2:"64";}', 2, '05a671c66aefea124cc08b76ea6d30bb'),
(113, 'nat', '2014-11-04 14:06:02', 'a:9:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"8";i:4;s:2:"16";i:5;s:2:"32";i:6;s:2:"64";i:7;s:3:"128";i:8;s:3:"256";}', 2, '05a671c66aefea124cc08b76ea6d30bb');

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker_has_afdeling`
--

CREATE TABLE IF NOT EXISTS `gebruiker_has_afdeling` (
  `gebruiker_id` int(11) NOT NULL,
  `afdeling_id` int(11) NOT NULL,
  PRIMARY KEY (`gebruiker_id`,`afdeling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marketing`
--

CREATE TABLE IF NOT EXISTS `marketing` (
  `marketing_klant_id` int(10) NOT NULL AUTO_INCREMENT,
  `marketing_voornaam` varchar(32) NOT NULL,
  `marketing_achternaam` varchar(32) NOT NULL,
  `marketing_postcode` varchar(32) NOT NULL,
  `marketing_voorkeuren` int(10) NOT NULL,
  `marketing_geboortedatum` varchar(10) NOT NULL,
  `marketing_create_tijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`marketing_klant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_email`
--

CREATE TABLE IF NOT EXISTS `marketing_email` (
  `marketing_klant_id` int(10) NOT NULL AUTO_INCREMENT,
  `marketing_emailadres` varchar(32) NOT NULL,
  `marketing_beschrijving` varchar(256) NOT NULL,
  PRIMARY KEY (`marketing_klant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_telefoonlijst`
--

CREATE TABLE IF NOT EXISTS `marketing_telefoonlijst` (
  `marketing_klant_id` int(10) NOT NULL,
  `marketing_nummer` int(15) NOT NULL,
  `marketing_Type` int(10) NOT NULL,
  `marketing_marketing_klant_id` int(11) NOT NULL,
  PRIMARY KEY (`marketing_klant_id`,`marketing_marketing_klant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messageboard`
--

CREATE TABLE IF NOT EXISTS `messageboard` (
  `msg_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_beschrijving` varchar(2048) COLLATE latin1_general_cs NOT NULL,
  `msg_to_persoon` bigint(10) NOT NULL,
  `msg_create_tijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_link` varchar(256) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `idx_msg_to_persoon` (`msg_to_persoon`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs AUTO_INCREMENT=114 ;

--
-- Dumping data for table `messageboard`
--

INSERT INTO `messageboard` (`msg_id`, `msg_beschrijving`, `msg_to_persoon`, `msg_create_tijd`, `msg_link`) VALUES
(112, 'Ticket heeft goedkeuring nodig: baan2', 0, '2014-11-04 14:33:54', '13'),
(113, 'Er is een ticket aan u toegewezen: Dit is de titel van een ticket op het ticketformulier blah blah', 90, '2014-11-04 14:44:30', '?page=tickets&subpage=toegewezentickets'),
(111, 'Er is een ticket aan u toegewezen: baan2', 113, '2014-11-04 14:33:50', '?page=tickets&subpage=toegewezentickets'),
(110, 'Ticket heeft goedkeuring nodig: Kapot', 0, '2014-11-04 14:33:44', '12'),
(109, 'Ticket heeft goedkeuring nodig: Kapot', 0, '2014-11-04 14:32:13', ''),
(107, 'Ticket heeft goedkeuring nodig: ', 0, '2014-11-04 14:31:48', ''),
(108, 'Er is een ticket aan u toegewezen: Kapot', 113, '2014-11-04 14:32:08', '?page=tickets&subpage=toegewezentickets'),
(106, 'Er is een ticket aan u toegewezen: ', 113, '2014-11-04 14:24:23', '?page=tickets&subpage=toegewezentickets'),
(105, 'Er is een ticket aan u toegewezen: ', 92, '2014-11-04 14:23:56', '?page=tickets&subpage=toegewezentickets'),
(104, 'Er is een ticket aan u toegewezen: ', 92, '2014-11-04 14:23:48', '?page=tickets&subpage=toegewezentickets'),
(103, 'Er is een ticket aan u toegewezen: ', 44, '2014-11-04 14:22:23', '?page=tickets&subpage=toegewezentickets'),
(102, 'Er is een ticket aan u toegewezen: Kapot', 108, '2014-11-04 14:06:34', '?page=tickets&subpage=toegewezentickets'),
(101, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:04:07', '?page=tickets&subpage=toegewezentickets'),
(100, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:03:57', '?page=tickets&subpage=toegewezentickets'),
(99, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:03:22', '?page=tickets&subpage=toegewezentickets'),
(98, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:02:47', '?page=tickets&subpage=toegewezentickets'),
(97, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:01:54', '?page=tickets&subpage=toegewezentickets'),
(96, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:01:43', '?page=tickets&subpage=toegewezentickets'),
(95, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:01:34', '?page=tickets&subpage=toegewezentickets'),
(94, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 14:01:18', '?page=tickets&subpage=toegewezentickets'),
(93, 'Er is een ticket aan u toegewezen: Kapot', 43, '2014-11-04 13:58:24', '?page=tickets&subpage=toegewezentickets'),
(92, 'Ticket heeft goedkeuring nodig: ', 0, '2014-11-04 13:48:36', ''),
(90, 'Ticket heeft goedkeuring nodig: Lekt', 0, '2014-11-04 13:39:55', ''),
(91, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:45:58', '?page=tickets&subpage=toegewezentickets'),
(89, 'Ticket heeft goedkeuring nodig: Lekt', 0, '2014-11-04 13:39:54', ''),
(87, 'Ticket heeft goedkeuring nodig: Belichten is stuk', 0, '2014-11-04 13:39:26', ''),
(88, 'Ticket heeft goedkeuring nodig: Belichten is stuk', 0, '2014-11-04 13:39:51', ''),
(86, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:11:09', '?page=tickets&subpage=toegewezentickets'),
(85, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:10:52', '?page=tickets&subpage=toegewezentickets'),
(84, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:10:36', '?page=tickets&subpage=toegewezentickets'),
(82, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:07:23', '?page=tickets&subpage=toegewezentickets'),
(83, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:10:20', '?page=tickets&subpage=toegewezentickets'),
(81, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 13:06:49', '?page=tickets&subpage=toegewezentickets'),
(80, 'Er is een ticket aan u toegewezen: ', 91, '2014-11-04 13:00:08', '?page=tickets&subpage=toegewezentickets'),
(79, 'Er is een ticket aan u toegewezen: ', 43, '2014-11-04 12:59:57', '?page=tickets&subpage=toegewezentickets'),
(78, 'Er is een ticket aan u toegewezen: ', 43, '2014-11-04 12:58:25', '?page=tickets&subpage=toegewezentickets'),
(77, 'Er is een ticket aan u toegewezen: ', 108, '2014-11-04 12:57:16', '?page=tickets&subpage=toegewezentickets');

-- --------------------------------------------------------

--
-- Table structure for table `message_change_history`
--

CREATE TABLE IF NOT EXISTS `message_change_history` (
  `msg_change_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_id` bigint(10) NOT NULL,
  `pers_id` bigint(10) NOT NULL,
  `msg_change_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_change_beschrijving` varchar(1024) NOT NULL,
  PRIMARY KEY (`msg_change_id`),
  KEY `idx_msg_id` (`msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_prio`
--

CREATE TABLE IF NOT EXISTS `message_prio` (
  `msg_prio_level` varchar(16) NOT NULL,
  `msg_prio_beschrijving` varchar(1024) NOT NULL,
  PRIMARY KEY (`msg_prio_level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message_status`
--

CREATE TABLE IF NOT EXISTS `message_status` (
  `msg_status_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_status_label` varchar(32) NOT NULL,
  `msg_status_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`msg_status_id`),
  UNIQUE KEY `msg_status_label` (`msg_status_label`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `message_status`
--

INSERT INTO `message_status` (`msg_status_id`, `msg_status_label`, `msg_status_beschrijving`) VALUES
(1, '1', 'TXT_MSG_STATUS_NEW'),
(2, '2', 'TXT_MSG_STATUS_PROGRESS'),
(3, '3', 'TXT_MSG_STATUS_CLOSED');

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE IF NOT EXISTS `message_type` (
  `msg_type_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_type_name` varchar(32) NOT NULL,
  `msg_type_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`msg_type_id`),
  UNIQUE KEY `msg_type_name` (`msg_type_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`msg_type_id`, `msg_type_name`, `msg_type_beschrijving`) VALUES
(1, '2', 'TXT_MSG_TYPE_DESCRIPTION_PERSON'),
(2, '1', 'TXT_MSG_TYPE_DESCRIPTION_MODULE');

-- --------------------------------------------------------

--
-- Table structure for table `object`
--

CREATE TABLE IF NOT EXISTS `object` (
  `object_id` int(10) NOT NULL AUTO_INCREMENT,
  `object_naam` varchar(50) NOT NULL,
  `afdeling_id` int(10) NOT NULL,
  PRIMARY KEY (`object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `object`
--

INSERT INTO `object` (`object_id`, `object_naam`, `afdeling_id`) VALUES
(1, 'Baan 1', 1),
(2, 'Baan 2', 1),
(3, 'Bar', 1),
(4, 'Kraan', 0),
(5, 'Kraan', 0),
(6, 'Kraan', 0),
(7, 'Kraan', 0),
(8, 'Kraan', 0),
(9, 'Kraan', 0),
(10, 'Kraan', 0),
(11, '', 0),
(12, '', 0),
(13, '', 0),
(14, '', 0),
(15, 'objectje', 1),
(16, '', 0),
(17, '', 1),
(18, 'naam', 0),
(19, '', 0),
(20, 'Jillz', 4),
(21, 'Jillz', 4);

-- --------------------------------------------------------

--
-- Table structure for table `persoon`
--

CREATE TABLE IF NOT EXISTS `persoon` (
  `persoon_id` int(11) NOT NULL AUTO_INCREMENT,
  `persoon_voornaam` varchar(128) NOT NULL,
  `persoon_achternaam` varchar(64) NOT NULL,
  `persoon_email` varchar(256) NOT NULL,
  `persoon_land` varchar(128) NOT NULL,
  `persoon_functie` varchar(64) NOT NULL,
  `persoon_straat` varchar(128) NOT NULL,
  `persoon_stad` varchar(128) NOT NULL,
  `persoon_telnummer` varchar(20) NOT NULL,
  PRIMARY KEY (`persoon_id`),
  UNIQUE KEY `persoon_telnummer` (`persoon_telnummer`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `persoon`
--

INSERT INTO `persoon` (`persoon_id`, `persoon_voornaam`, `persoon_achternaam`, `persoon_email`, `persoon_land`, `persoon_functie`, `persoon_straat`, `persoon_stad`, `persoon_telnummer`) VALUES
(1, 'Thierrie', 'Geldofjeleven', 'afwasboi44@gmail.com', 'België', 'Afwasser', 'et hiem', 'Bresjes', '061234567'),
(2, 'Donny', 'van Walsem', 'donnyvw@hotmail.nl', 'Nederland', '', 'Zandstraat 32a', 'Hulst', '06-0548625');

-- --------------------------------------------------------

--
-- Table structure for table `recht`
--

CREATE TABLE IF NOT EXISTS `recht` (
  `recht_id` int(11) NOT NULL AUTO_INCREMENT,
  `recht_positie` int(20) NOT NULL,
  `recht_beschrijving` varchar(300) NOT NULL,
  `recht_onderdeel` char(50) NOT NULL,
  `recht_groep_id` int(11) NOT NULL,
  PRIMARY KEY (`recht_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recht_groep`
--

CREATE TABLE IF NOT EXISTS `recht_groep` (
  `recht_groep_id` int(11) NOT NULL AUTO_INCREMENT,
  `recht_bitfield` varchar(2048) NOT NULL,
  `recht_groep_beschrijving` longtext NOT NULL,
  `recht_groep_naam` varchar(255) NOT NULL,
  PRIMARY KEY (`recht_groep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `recht_groep`
--

INSERT INTO `recht_groep` (`recht_groep_id`, `recht_bitfield`, `recht_groep_beschrijving`, `recht_groep_naam`) VALUES
(1, '0', 'Admin', ''),
(2, '12', 'gebruiker', ''),
(4, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(5, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(6, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(7, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(8, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(9, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(10, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test'),
(32, 'O:13:"RechtBitfield":1:{s:29:"\0RechtBitfield\0bitfield_array";a:3:{i:0;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}i:1;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:256;}i:2;O:8:"Bitfield":1:{s:18:"\0Bitfield\0bitfield";i:4;}}}', 'Een Test groep', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `rooster`
--

CREATE TABLE IF NOT EXISTS `rooster` (
  `rooster_id` int(10) NOT NULL AUTO_INCREMENT,
  `tekst` varchar(132) NOT NULL,
  `creatietijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aanmaakpersoon` varchar(64) NOT NULL,
  `dag_id` int(11) NOT NULL,
  `week_id` int(11) NOT NULL,
  `rooster_status_id` int(10) NOT NULL,
  `taak_id` int(10) NOT NULL,
  `tijd_id` int(10) NOT NULL,
  PRIMARY KEY (`rooster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooster_dag`
--

CREATE TABLE IF NOT EXISTS `rooster_dag` (
  `dag_id` varchar(20) NOT NULL,
  `dag` varchar(20) NOT NULL,
  PRIMARY KEY (`dag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rooster_status`
--

CREATE TABLE IF NOT EXISTS `rooster_status` (
  `rooster_status_id` int(10) NOT NULL AUTO_INCREMENT,
  `rooster_status_label` varchar(32) NOT NULL,
  `rooster_status_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`rooster_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooster_taak`
--

CREATE TABLE IF NOT EXISTS `rooster_taak` (
  `taak_id` int(10) NOT NULL AUTO_INCREMENT,
  `tijd_id` int(10) NOT NULL,
  `taak_bechrijving` varchar(64) NOT NULL,
  PRIMARY KEY (`taak_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooster_tijdblok`
--

CREATE TABLE IF NOT EXISTS `rooster_tijdblok` (
  `tijd_id` int(10) NOT NULL AUTO_INCREMENT,
  `begintijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `eindtijd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tijd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooster_tijdblok_taak`
--

CREATE TABLE IF NOT EXISTS `rooster_tijdblok_taak` (
  `taak_id` int(10) NOT NULL,
  `tijd_id` int(10) NOT NULL,
  PRIMARY KEY (`taak_id`,`tijd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessie`
--

CREATE TABLE IF NOT EXISTS `sessie` (
  `sessie_id` int(11) NOT NULL,
  `sessie` longtext NOT NULL,
  `sessie_datetime` datetime NOT NULL,
  PRIMARY KEY (`sessie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessie`
--

INSERT INTO `sessie` (`sessie_id`, `sessie`, `sessie_datetime`) VALUES
(1, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2013-03-25 01:15:44'),
(7, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-10-01 03:11:21'),
(8, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-10-01 03:11:23'),
(9, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-11-09 12:19:27'),
(10, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-11-09 12:42:26'),
(11, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-11-09 12:43:45'),
(12, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-11-09 12:45:28'),
(13, 'a:4:{s:12:"gebruiker_id";s:1:"1";s:8:"voornaam";s:6:"Sander";s:10:"achternaam";s:18:"van&nbsp;Belleghem";s:9:"sessie_id";s:1:"1";}', '2012-11-12 12:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `cat_id` int(2) NOT NULL,
  `subcategory` varchar(25) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticketsysteem`
--

CREATE TABLE IF NOT EXISTS `ticketsysteem` (
  `ticket_id` int(10) NOT NULL AUTO_INCREMENT,
  `pers_id` int(10) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `ticket_status_id` int(10) NOT NULL,
  `ticket_titel` varchar(64) NOT NULL,
  `ticket_beschrijving` text NOT NULL,
  `ticket_progress` varchar(2048) NOT NULL,
  `ticket_create_tijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ticket_end_tijd` varchar(255) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `afdeling_id` int(11) NOT NULL,
  `object_id` int(10) NOT NULL,
  `ticket_prio_id` int(10) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `ticketsysteem`
--

INSERT INTO `ticketsysteem` (`ticket_id`, `pers_id`, `creator_id`, `ticket_status_id`, `ticket_titel`, `ticket_beschrijving`, `ticket_progress`, `ticket_create_tijd`, `ticket_end_tijd`, `afdeling_id`, `object_id`, `ticket_prio_id`) VALUES
(1, 90, 0, 0, 'Kegels hangen vast.', 'Kegels gaan niet naar links boven', 'open', '2014-02-27 12:42:42', '0000-00-00 00:00:00', 1, 1, 1),
(2, 108, 0, 2, '', 'a', 'Verholpen', '2014-11-04 13:48:36', '0000-00-00 00:00:00', 0, 0, 0),
(3, 113, 0, 2, '', '', 'Verholpen', '2014-11-04 14:31:48', '0000-00-00 00:00:00', 0, 0, 0),
(4, 90, 0, 3, 'Tap defect', 'Kraantje is kapoet.', 'Afgerond', '2014-07-07 23:09:25', '2014-07-08 1:09:25', 1, 3, 2),
(5, 108, 0, 2, 'Belichten is stuk', 'Een aantal lampjes werken niet meer naar behoren.', 'Verholpen', '2014-11-04 13:39:25', '0000-00-00 00:00:00', 1, 2, 0),
(7, 90, 0, 3, 'glas kapot', '', 'Afgerond', '2014-07-10 00:55:15', '2014-07-10 2:55:15', 2, 0, 0),
(9, 108, 90, 2, 'Lekt', 'Bij het dichtdraaien van de kraan, druipt er nog steeds water uit.', 'Verholpen', '2014-11-04 13:39:54', '0000-00-00 00:00:00', 2, 4, 2),
(10, 90, 90, 3, 'Bar hout is versleten', 'Poleisten???', 'Afgerond', '2014-11-04 13:39:18', '2014-10-06 15:01:36', 2, 3, 3),
(12, 113, 90, 2, 'Kapot', 'LL', 'Verholpen', '2014-11-04 14:32:13', '0000-00-00 00:00:00', 2, 10, 2),
(13, 113, 90, 2, 'baan2', 'baan2', 'Verholpen', '2014-11-04 14:33:54', '0000-00-00 00:00:00', 2, 2, 1),
(14, 90, 90, 1, 'Bar hout is versleten', '', 'In behandeling', '2014-07-08 16:44:47', '0000-00-00 00:00:00', 1, 4, 0),
(15, 90, 90, 1, 'Dit is de titel van een ticket op het ticketformulier blah blah', 'Dit is de titel van een ticket op het ticketformulier blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah', 'In behandeling', '2014-07-08 16:57:35', '0000-00-00 00:00:00', 1, 2, 0),
(16, 90, 90, 1, 'Moet opnieuw geschilderd worden', 'Er is witte verf gemorst op de bar.', 'In behandeling', '2014-07-08 17:13:01', '0000-00-00 00:00:00', 2, 3, 0),
(17, 99, 99, 1, 'Werkt nie', 'abcdefghijklmnopqrstuvwwxyz', 'In behandeling', '2014-10-06 07:01:53', '0000-00-00 00:00:00', 1, 2, 1),
(18, 90, 90, 1, 'Vaatwasser kapot', 'woeps', 'In behandeling', '2014-07-08 17:15:07', '0000-00-00 00:00:00', 2, 3, 0),
(19, 90, 90, 1, 'vaswasser', '', 'In behandeling', '2014-07-08 17:15:49', '0000-00-00 00:00:00', 2, 3, 0),
(20, 90, 90, 1, '" DROP TABLE"', '', 'In behandeling', '2014-07-08 17:16:53', '0000-00-00 00:00:00', 2, 3, 0),
(21, 90, 90, 1, 'rekerino', '', 'In behandeling', '2014-07-08 17:19:55', '0000-00-00 00:00:00', 2, 3, 0),
(22, 43, 90, 1, 'baan problemen', '', 'In behandeling', '2014-10-06 07:03:00', '0000-00-00 00:00:00', 2, 3, 0),
(23, 43, 108, 1, 'geweer schiet niet', 'rambo', 'In behandeling', '2014-10-06 07:45:41', '0000-00-00 00:00:00', 3, 2, 0),
(25, 99, 108, 1, 'Yo', 'Beschrijving', 'In behandeling', '2014-11-03 14:23:07', '0000-00-00 00:00:00', 2, 5, 0),
(26, 91, 108, 1, 'woop', 'woopwoop', 'In behandeling', '2014-11-03 14:33:51', '0000-00-00 00:00:00', 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_loc`
--

CREATE TABLE IF NOT EXISTS `ticket_loc` (
  `ticket_loc_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `ticket_loc_label` varchar(32) NOT NULL,
  `ticket_loc_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`ticket_loc_id`),
  UNIQUE KEY `ticket_loc_label` (`ticket_loc_label`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ticket_loc`
--

INSERT INTO `ticket_loc` (`ticket_loc_id`, `ticket_loc_label`, `ticket_loc_beschrijving`) VALUES
(1, '1', 'Receptie'),
(2, '2', 'Brasserie/Bar'),
(3, '3', 'Bowling'),
(4, '4', 'Toiletten'),
(5, '5', 'Keuken'),
(6, '6', 'Feestzaal'),
(7, '7', 'Speelzaal/Counter'),
(8, '8', 'Terras/Buiten'),
(9, '9', 'Lasergame'),
(10, '10', 'Kantoor'),
(11, '11', 'Overig');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_prio`
--

CREATE TABLE IF NOT EXISTS `ticket_prio` (
  `ticket_prio_id` int(10) NOT NULL AUTO_INCREMENT,
  `ticket_prio_label` varchar(32) NOT NULL,
  `ticket_prio_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`ticket_prio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ticket_prio`
--

INSERT INTO `ticket_prio` (`ticket_prio_id`, `ticket_prio_label`, `ticket_prio_beschrijving`) VALUES
(1, 'Laag', 'Prioriteit is laag.'),
(2, 'Matig', 'Prioriteit is matig.'),
(3, 'Hoog', 'Prioriteit is hoog.');

-- --------------------------------------------------------

--
-- Table structure for table `weeknr`
--

CREATE TABLE IF NOT EXISTS `weeknr` (
  `weeknr` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
