-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 02 nov 2014 om 23:59
-- Serverversie: 5.5.32
-- PHP-versie: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `minevents`
--
CREATE DATABASE IF NOT EXISTS `minevents` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `minevents`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `afdeling`
--

CREATE TABLE IF NOT EXISTS `afdeling` (
  `afdeling_id` int(11) NOT NULL AUTO_INCREMENT,
  `afdeling_naam` varchar(50) NOT NULL,
  `afdeling_beschrijving` varchar(255) NOT NULL,
  PRIMARY KEY (`afdeling_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `afdeling`
--

INSERT INTO `afdeling` (`afdeling_id`, `afdeling_naam`, `afdeling_beschrijving`) VALUES
(1, 'Bowlingbaan', ''),
(2, 'Bar', ''),
(3, 'Lasergamen', 'Lasers');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruiker`
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
(108, 'admin', '2014-10-09 06:39:10', 'a:3:{i:0;s:2:"16";i:1;s:3:"128";i:2;s:3:"256";}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(109, 'test_data5', '2014-09-23 07:43:56', 'a:9:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"8";i:4;s:2:"16";i:5;s:2:"32";i:6;s:2:"64";i:7;s:3:"128";i:8;s:3:"256";}', 2, 'ef654c40ab4f1747fc699915d4f70902'),
(110, 'serdar', '2014-10-03 09:42:05', 'a:1:{i:0;s:2:"64";}', 2, 'acb630328c03ff814694a44e7cc7d083'),
(111, 'test_data12', '2014-10-27 13:40:35', 'a:2:{i:0;s:1:"1";i:1;s:3:"128";}', 2, 'ef654c40ab4f1747fc699915d4f70902');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker_has_afdeling`
--

CREATE TABLE IF NOT EXISTS `gebruiker_has_afdeling` (
  `gebruiker_id` int(11) NOT NULL,
  `afdeling_id` int(11) NOT NULL,
  PRIMARY KEY (`gebruiker_id`,`afdeling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `marketing`
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
-- Tabelstructuur voor tabel `marketing_email`
--

CREATE TABLE IF NOT EXISTS `marketing_email` (
  `marketing_klant_id` int(10) NOT NULL AUTO_INCREMENT,
  `marketing_emailadres` varchar(32) NOT NULL,
  `marketing_beschrijving` varchar(256) NOT NULL,
  PRIMARY KEY (`marketing_klant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `marketing_telefoonlijst`
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
-- Tabelstructuur voor tabel `messageboard`
--

CREATE TABLE IF NOT EXISTS `messageboard` (
  `msg_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_beschrijving` varchar(2048) COLLATE latin1_general_cs NOT NULL,
  `msg_to_persoon` bigint(10) NOT NULL,
  `msg_create_tijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_link` varchar(256) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `idx_msg_to_persoon` (`msg_to_persoon`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs AUTO_INCREMENT=40 ;

--
-- Gegevens worden uitgevoerd voor tabel `messageboard`
--

INSERT INTO `messageboard` (`msg_id`, `msg_beschrijving`, `msg_to_persoon`, `msg_create_tijd`, `msg_link`) VALUES
(1, 'dit is de beschrijving', 0, '2011-12-13 10:20:06', 'linkto?id=1234543'),
(2, 'Wil je dit mailtje controleren?', 2, '2011-12-13 10:20:06', 'messageboard?id=1234'),
(3, 'Nieuwe beschrijving', 2, '2011-12-13 10:20:07', 'messageboard?id=4321'),
(4, 'dit is de beschrijving', 1, '2011-12-13 10:21:43', 'linkto?id=1234543'),
(5, 'Wil je dit mailtje controleren?', 2, '2011-12-13 10:21:43', 'messageboard?id=1234'),
(6, 'Nieuwe beschrijving', 2, '2011-12-13 10:21:43', 'messageboard?id=4321'),
(7, 'dit is de beschrijving', 1, '2011-12-14 08:46:22', 'linkto?id=1234543'),
(8, 'Wil je dit mailtje controleren?', 2, '2011-12-14 08:46:22', 'messageboard?id=1234'),
(9, 'Nieuwe beschrijving', 2, '2011-12-14 08:46:22', 'messageboard?id=4321'),
(10, 'Nieuw ticket toegevoegt: rekerino', 0, '2014-07-08 16:11:39', '21'),
(11, 'Nieuw ticket toegevoegt: baan problemen', 0, '2014-07-08 16:15:14', '22'),
(12, 'Er is een ticket aan u toegewezen: Bar hout is versleten', 90, '2014-07-08 16:44:48', ''),
(13, 'Er is een ticket aan u toegewezen: baan2', 90, '2014-07-08 16:52:27', '13'),
(14, 'Er is een ticket aan u toegewezen: Dit is de titel van een ticket op het ticketformulier blah blah', 90, '2014-07-08 16:57:36', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(15, 'Er is een ticket aan u toegewezen: Moet opnieuw geschilderd worden', 90, '2014-07-08 17:13:02', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(16, 'Er is een ticket aan u toegewezen: Vaatwasser kapot', 90, '2014-07-08 17:15:09', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(17, 'Er is een ticket aan u toegewezen: vaswasser', 90, '2014-07-08 17:15:50', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(18, 'Er is een ticket aan u toegewezen: " DROP TABLE"', 90, '2014-07-08 17:16:54', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(19, 'Er is een ticket aan u toegewezen: rekerino', 90, '2014-07-08 17:19:56', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(20, 'Ticket heeft goedkeuring nodig: Bar hout is versleten', 0, '2014-07-10 00:20:11', ''),
(21, 'Ticket heeft goedkeuring nodig: glas kapot', 0, '2014-07-10 00:23:06', '7'),
(22, 'Ticket heeft goedkeuring nodig: Bar hout is versleten', 0, '2014-07-10 01:07:24', '10'),
(23, 'Ticket heeft goedkeuring nodig: Bar hout is versleten', 0, '2014-07-10 01:08:28', '10'),
(24, 'Ticket heeft goedkeuring nodig: Werkt nie', 0, '2014-07-10 01:16:04', '17'),
(25, 'Er is een ticket aan u toegewezen: Werkt nie', 99, '2014-10-06 07:01:54', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(26, 'Er is een ticket aan u toegewezen: baan problemen', 43, '2014-10-06 07:03:01', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(27, 'Er is een ticket aan u toegewezen: Werkt nie', 99, '2014-10-06 07:03:06', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(28, 'Er is een ticket aan u toegewezen: ', 87, '2014-10-06 07:03:58', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(29, 'Er is een ticket aan u toegewezen: Werkt nie', 99, '2014-10-06 07:04:03', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(30, 'Er is een ticket aan u toegewezen: ', 43, '2014-10-06 07:05:08', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(31, 'Er is een ticket aan u toegewezen: ', 91, '2014-10-06 07:06:28', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(32, 'Nieuw ticket toegevoegt: geweer schiet niet', 0, '2014-10-06 07:10:07', '0'),
(33, 'Nieuw ticket toegevoegt: geweer schiet niet', 0, '2014-10-06 07:14:10', '0'),
(34, 'Nieuw ticket toegevoegt: geweer schiet niet', 0, '2014-10-06 07:17:51', '23'),
(35, 'Er is een ticket aan u toegewezen: geweer schiet niet', 43, '2014-10-06 07:45:42', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(36, 'Er is een ticket aan u toegewezen: ', 91, '2014-10-06 07:52:36', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(37, 'Er is een ticket aan u toegewezen: ', 43, '2014-10-06 12:51:27', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets'),
(38, 'Er is een ticket aan u toegewezen: ', 91, '2014-10-06 13:00:21', 'http://localhost/minevents/index.php?page=tickets&subpage=toegewezentickets');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `message_change_history`
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
-- Tabelstructuur voor tabel `message_prio`
--

CREATE TABLE IF NOT EXISTS `message_prio` (
  `msg_prio_level` varchar(16) NOT NULL,
  `msg_prio_beschrijving` varchar(1024) NOT NULL,
  PRIMARY KEY (`msg_prio_level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `message_status`
--

CREATE TABLE IF NOT EXISTS `message_status` (
  `msg_status_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_status_label` varchar(32) NOT NULL,
  `msg_status_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`msg_status_id`),
  UNIQUE KEY `msg_status_label` (`msg_status_label`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `message_status`
--

INSERT INTO `message_status` (`msg_status_id`, `msg_status_label`, `msg_status_beschrijving`) VALUES
(1, '1', 'TXT_MSG_STATUS_NEW'),
(2, '2', 'TXT_MSG_STATUS_PROGRESS'),
(3, '3', 'TXT_MSG_STATUS_CLOSED');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `message_type`
--

CREATE TABLE IF NOT EXISTS `message_type` (
  `msg_type_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `msg_type_name` varchar(32) NOT NULL,
  `msg_type_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`msg_type_id`),
  UNIQUE KEY `msg_type_name` (`msg_type_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `message_type`
--

INSERT INTO `message_type` (`msg_type_id`, `msg_type_name`, `msg_type_beschrijving`) VALUES
(1, '2', 'TXT_MSG_TYPE_DESCRIPTION_PERSON'),
(2, '1', 'TXT_MSG_TYPE_DESCRIPTION_MODULE');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `object`
--

CREATE TABLE IF NOT EXISTS `object` (
  `object_id` int(10) NOT NULL AUTO_INCREMENT,
  `object_naam` varchar(50) NOT NULL,
  `afdeling_id` int(10) NOT NULL,
  PRIMARY KEY (`object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Gegevens worden uitgevoerd voor tabel `object`
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
(19, '', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `persoon`
--

CREATE TABLE IF NOT EXISTS `persoon` (
  `persoon_id` int(11) NOT NULL,
  `persoon_voornaam` varchar(128) NOT NULL,
  `persoon_achternaam` varchar(64) NOT NULL,
  `persoon_email` varchar(256) NOT NULL,
  `persoon_land` varchar(128) NOT NULL,
  `persoon_functie` varchar(64) NOT NULL,
  `persoon_straat` varchar(128) NOT NULL,
  `persoon_stad` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `persoon`
--

INSERT INTO `persoon` (`persoon_id`, `persoon_voornaam`, `persoon_achternaam`, `persoon_email`, `persoon_land`, `persoon_functie`, `persoon_straat`, `persoon_stad`) VALUES
(0, 'Voornaam1', 'Achternaam1', 'Email1', 'Land1', 'Functie1', 'Straat1', 'Stad1'),
(0, 'Voornaam2', 'Achternaam2', 'Email2', 'Land2', 'Functie2', 'Straat2', 'Stad2');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recht`
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
-- Tabelstructuur voor tabel `recht_groep`
--

CREATE TABLE IF NOT EXISTS `recht_groep` (
  `recht_groep_id` int(11) NOT NULL AUTO_INCREMENT,
  `recht_bitfield` varchar(2048) NOT NULL,
  `recht_groep_beschrijving` longtext NOT NULL,
  `recht_groep_naam` varchar(255) NOT NULL,
  PRIMARY KEY (`recht_groep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Gegevens worden uitgevoerd voor tabel `recht_groep`
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
-- Tabelstructuur voor tabel `rooster`
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
-- Tabelstructuur voor tabel `rooster_dag`
--

CREATE TABLE IF NOT EXISTS `rooster_dag` (
  `dag_id` varchar(20) NOT NULL,
  `dag` varchar(20) NOT NULL,
  PRIMARY KEY (`dag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rooster_status`
--

CREATE TABLE IF NOT EXISTS `rooster_status` (
  `rooster_status_id` int(10) NOT NULL AUTO_INCREMENT,
  `rooster_status_label` varchar(32) NOT NULL,
  `rooster_status_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`rooster_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rooster_taak`
--

CREATE TABLE IF NOT EXISTS `rooster_taak` (
  `taak_id` int(10) NOT NULL AUTO_INCREMENT,
  `tijd_id` int(10) NOT NULL,
  `taak_bechrijving` varchar(64) NOT NULL,
  PRIMARY KEY (`taak_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rooster_tijdblok`
--

CREATE TABLE IF NOT EXISTS `rooster_tijdblok` (
  `tijd_id` int(10) NOT NULL AUTO_INCREMENT,
  `begintijd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `eindtijd` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tijd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rooster_tijdblok_taak`
--

CREATE TABLE IF NOT EXISTS `rooster_tijdblok_taak` (
  `taak_id` int(10) NOT NULL,
  `tijd_id` int(10) NOT NULL,
  PRIMARY KEY (`taak_id`,`tijd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sessie`
--

CREATE TABLE IF NOT EXISTS `sessie` (
  `sessie_id` int(11) NOT NULL,
  `sessie` longtext NOT NULL,
  `sessie_datetime` datetime NOT NULL,
  PRIMARY KEY (`sessie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `sessie`
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
-- Tabelstructuur voor tabel `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
  `cat_id` int(2) NOT NULL,
  `subcategory` varchar(25) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ticketsysteem`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Gegevens worden uitgevoerd voor tabel `ticketsysteem`
--

INSERT INTO `ticketsysteem` (`ticket_id`, `pers_id`, `creator_id`, `ticket_status_id`, `ticket_titel`, `ticket_beschrijving`, `ticket_progress`, `ticket_create_tijd`, `ticket_end_tijd`, `afdeling_id`, `object_id`, `ticket_prio_id`) VALUES
(1, 90, 0, 0, 'Kegels hangen vast.', 'Kegels gaan niet naar links boven', 'open', '2014-02-27 12:42:42', '0000-00-00 00:00:00', 1, 1, 1),
(2, 91, 0, 1, '', 'a', 'In behandeling', '2014-10-06 07:06:27', '0000-00-00 00:00:00', 0, 0, 0),
(3, 43, 0, 1, '', '', 'In behandeling', '2014-02-28 09:52:16', '0000-00-00 00:00:00', 0, 0, 0),
(4, 90, 0, 3, 'Tap defect', 'Kraantje is kapoet.', 'Afgerond', '2014-07-07 23:09:25', '2014-07-08 1:09:25', 1, 3, 2),
(5, 44, 0, 1, 'Belichten is stuk', 'Een aantal lampjes werken niet meer naar behoren.', 'In behandeling', '2014-02-28 09:54:58', '0000-00-00 00:00:00', 1, 2, 0),
(7, 90, 0, 3, 'glas kapot', '', 'Afgerond', '2014-07-10 00:55:15', '2014-07-10 2:55:15', 2, 0, 0),
(9, 44, 90, 1, 'Lekt', 'Bij het dichtdraaien van de kraan, druipt er nog steeds water uit.', 'In behandeling', '2014-05-16 09:08:41', '0000-00-00 00:00:00', 2, 4, 2),
(10, 90, 90, 3, 'Bar hout is versleten', 'Poleisten?', 'Afgerond', '2014-10-06 13:01:36', '2014-10-06 15:01:36', 2, 3, 3),
(12, 88, 90, 1, 'Kapot', 'LL', 'In behandeling', '2014-06-12 14:07:18', '0000-00-00 00:00:00', 2, 10, 2),
(13, 90, 90, 1, 'baan2', 'baan2', 'In behandeling', '2014-07-08 16:52:26', '0000-00-00 00:00:00', 2, 2, 1),
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
(24, 0, 108, 0, 'asf''fdsafdsfdfffffffffffffffffffffffffffffffffffffffffffffffffff', 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'open', '2014-10-09 07:32:26', '0000-00-00 00:00:00', 1, 5, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ticket_loc`
--

CREATE TABLE IF NOT EXISTS `ticket_loc` (
  `ticket_loc_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `ticket_loc_label` varchar(32) NOT NULL,
  `ticket_loc_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`ticket_loc_id`),
  UNIQUE KEY `ticket_loc_label` (`ticket_loc_label`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `ticket_loc`
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
-- Tabelstructuur voor tabel `ticket_prio`
--

CREATE TABLE IF NOT EXISTS `ticket_prio` (
  `ticket_prio_id` int(10) NOT NULL AUTO_INCREMENT,
  `ticket_prio_label` varchar(32) NOT NULL,
  `ticket_prio_beschrijving` varchar(128) NOT NULL,
  PRIMARY KEY (`ticket_prio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `ticket_prio`
--

INSERT INTO `ticket_prio` (`ticket_prio_id`, `ticket_prio_label`, `ticket_prio_beschrijving`) VALUES
(1, 'Laag', 'Prioriteit is laag.'),
(2, 'Matig', 'Prioriteit is matig.'),
(3, 'Hoog', 'Prioriteit is hoog.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `weeknr`
--

CREATE TABLE IF NOT EXISTS `weeknr` (
  `weeknr` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
