# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.3.10-MariaDB)
# Database: mujzavod
# Generation Time: 2019-03-07 09:45:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `edition_ID` int(10) unsigned NOT NULL,
  `categoryname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` int(11) DEFAULT NULL COMMENT 'Length in meters',
  `climb` int(11) DEFAULT NULL COMMENT 'Climb in meters',
  `entryfee` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Entry fee',
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CZK' COMMENT 'Currency od entry fee',
  `starttime` datetime DEFAULT NULL,
  `sinterval` int(10) unsigned NOT NULL DEFAULT 0,
  `timelimit` int(10) unsigned DEFAULT NULL COMMENT 'Time limit in minutes',
  `capacity` int(10) unsigned DEFAULT NULL COMMENT 'Maximum number of runners in the category',
  `checkage` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'If 1, check runners age',
  `birthfrom` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Year of birth allowed from',
  `birthto` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Year of birth allowed to',
  `lock` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Lock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_ID`),
  KEY `category_edition_id_foreign` (`edition_ID`),
  KEY `category_categoryname_index` (`categoryname`),
  CONSTRAINT `category_edition_id_foreign` FOREIGN KEY (`edition_ID`) REFERENCES `raceedition` (`edition_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records category of the race edition.';

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`category_ID`, `edition_ID`, `categoryname`, `gender`, `length`, `climb`, `entryfee`, `currency`, `starttime`, `sinterval`, `timelimit`, `capacity`, `checkage`, `birthfrom`, `birthto`, `lock`, `created_at`, `updated_at`)
VALUES
	(1,1,'MUŽI','male',4300,200,50.00,'CZK','2018-12-02 10:15:00',2,90,NULL,'0',NULL,NULL,1,'2018-11-05 10:32:33','2019-03-03 11:51:30'),
	(2,1,'ŽENY','female',4300,200,50.00,'CZK','2018-12-02 10:15:00',2,90,NULL,'0',NULL,NULL,1,'2018-11-05 10:33:09','2019-03-03 11:51:30'),
	(3,1,'ŽÁCI','male',4300,200,20.00,'CZK','2018-12-02 10:15:00',1,90,NULL,'1',NULL,'2004',1,'2018-12-11 21:45:01','2019-03-03 11:51:30'),
	(4,1,'ŽAKYNĚ','female',4300,200,20.00,'CZK','2012-12-02 10:15:00',1,90,NULL,'1',NULL,'2004',1,'2018-12-11 21:47:56','2019-03-03 11:51:30'),
	(5,1,'DOROSTENCI','male',4300,200,20.00,'CZK','2018-12-02 10:15:00',1,90,NULL,'1',NULL,'2000',1,'2018-12-11 21:49:01','2019-03-03 11:51:30'),
	(6,1,'DOROSTENKY','female',4300,200,20.00,'CZK','2018-12-02 10:15:00',1,90,NULL,'1',NULL,'2000',1,'2018-12-11 21:49:43','2019-03-03 11:51:30'),
	(7,1,'MUŽI40','male',4300,200,50.00,'CZK','2018-12-02 10:15:00',1,90,NULL,'1','1978',NULL,1,'2018-12-11 21:51:01','2019-03-03 11:51:30'),
	(8,1,'ŽENY40','female',4300,200,50.00,'CZK','2018-12-02 10:15:00',1,90,NULL,'1','1978',NULL,1,'2018-12-11 21:53:41','2019-03-03 11:51:30');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table club
# ------------------------------------------------------------

DROP TABLE IF EXISTS `club`;

CREATE TABLE `club` (
  `club_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clubabbr` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clubname` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clubname2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxid` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vatid` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` char(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`club_ID`),
  UNIQUE KEY `club_clubabbr_unique` (`clubabbr`),
  KEY `club_country_foreign` (`country`),
  KEY `club_clubname_clubabbr_index` (`clubname`,`clubabbr`),
  CONSTRAINT `club_country_foreign` FOREIGN KEY (`country`) REFERENCES `country` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records registered clubs.';

LOCK TABLES `club` WRITE;
/*!40000 ALTER TABLE `club` DISABLE KEYS */;

INSERT INTO `club` (`club_ID`, `clubabbr`, `clubname`, `clubname2`, `taxid`, `vatid`, `street`, `city`, `postalcode`, `country`, `web`, `email`, `phone`, `deleted`, `created_at`, `updated_at`)
VALUES
	(1,'CHC','K.O.B. Choceň','z.s.','15030237',NULL,'Vostelčická 256','Choceň','56501','CZ','http://www.kobchocen.cz','info@kobchocen.cz',NULL,0,'2018-11-05 10:21:14','2018-11-05 10:21:14');

/*!40000 ALTER TABLE `club` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `country_ID` int(10) unsigned NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`country_code`),
  UNIQUE KEY `country_country_id_unique` (`country_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records countries of the world.';

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;

INSERT INTO `country` (`country_ID`, `country_code`, `name`, `created_at`, `updated_at`)
VALUES
	(5,'AD','Andorra',NULL,NULL),
	(228,'AE','United Arab Emirates',NULL,NULL),
	(1,'AF','Afghanistan',NULL,NULL),
	(9,'AG','Antigua and Barbuda',NULL,NULL),
	(7,'AI','Anguilla',NULL,NULL),
	(2,'AL','Albania',NULL,NULL),
	(11,'AM','Armenia',NULL,NULL),
	(156,'AN','Netherlands Antilles',NULL,NULL),
	(6,'AO','Angola',NULL,NULL),
	(8,'AQ','Antarctica',NULL,NULL),
	(10,'AR','Argentina',NULL,NULL),
	(14,'AT','Austria',NULL,NULL),
	(13,'AU','Australia',NULL,NULL),
	(12,'AW','Aruba',NULL,NULL),
	(15,'AZ','Azerbaijan',NULL,NULL),
	(27,'BA','Bosnia and Herzegovina',NULL,NULL),
	(19,'BB','Barbados',NULL,NULL),
	(18,'BD','Bangladesh',NULL,NULL),
	(21,'BE','Belgium',NULL,NULL),
	(34,'BF','Burkina Faso',NULL,NULL),
	(33,'BG','Bulgaria',NULL,NULL),
	(17,'BH','Bahrain',NULL,NULL),
	(35,'BI','Burundi',NULL,NULL),
	(23,'BJ','Benin',NULL,NULL),
	(24,'BM','Bermuda',NULL,NULL),
	(32,'BN','Brunei Darussalam',NULL,NULL),
	(26,'BO','Bolivia',NULL,NULL),
	(30,'BR','Brazil',NULL,NULL),
	(16,'BS','Bahamas',NULL,NULL),
	(25,'BT','Bhutan',NULL,NULL),
	(29,'BV','Bouvet Island',NULL,NULL),
	(28,'BW','Botswana',NULL,NULL),
	(20,'BY','Belarus',NULL,NULL),
	(22,'BZ','Belize',NULL,NULL),
	(38,'CA','Canada',NULL,NULL),
	(46,'CC','Cocos (Keeling) Islands',NULL,NULL),
	(41,'CF','Central African Republic',NULL,NULL),
	(49,'CG','Congo',NULL,NULL),
	(211,'CH','Switzerland',NULL,NULL),
	(107,'CI','Ivory Coast',NULL,NULL),
	(50,'CK','Cook Islands',NULL,NULL),
	(43,'CL','Chile',NULL,NULL),
	(37,'CM','Cameroon',NULL,NULL),
	(44,'CN','China',NULL,NULL),
	(47,'CO','Colombia',NULL,NULL),
	(51,'CR','Costa Rica',NULL,NULL),
	(53,'CU','Cuba',NULL,NULL),
	(39,'CV','Cape Verde',NULL,NULL),
	(45,'CX','Christmas Island',NULL,NULL),
	(54,'CY','Cyprus',NULL,NULL),
	(55,'CZ','Czech Republic',NULL,NULL),
	(80,'DE','Germany',NULL,NULL),
	(57,'DJ','Djibouti',NULL,NULL),
	(56,'DK','Denmark',NULL,NULL),
	(58,'DM','Dominica',NULL,NULL),
	(59,'DO','Dominican Republic',NULL,NULL),
	(4,'DS','American Samoa',NULL,NULL),
	(3,'DZ','Algeria',NULL,NULL),
	(61,'EC','Ecuador',NULL,NULL),
	(66,'EE','Estonia',NULL,NULL),
	(62,'EG','Egypt',NULL,NULL),
	(241,'EH','Western Sahara',NULL,NULL),
	(65,'ER','Eritrea',NULL,NULL),
	(202,'ES','Spain',NULL,NULL),
	(67,'ET','Ethiopia',NULL,NULL),
	(71,'FI','Finland',NULL,NULL),
	(70,'FJ','Fiji',NULL,NULL),
	(68,'FK','Falkland Islands (Malvinas)',NULL,NULL),
	(143,'FM','Micronesia, Federated States of',NULL,NULL),
	(69,'FO','Faroe Islands',NULL,NULL),
	(72,'FR','France',NULL,NULL),
	(73,'FX','France, Metropolitan',NULL,NULL),
	(77,'GA','Gabon',NULL,NULL),
	(229,'GB','United Kingdom',NULL,NULL),
	(86,'GD','Grenada',NULL,NULL),
	(79,'GE','Georgia',NULL,NULL),
	(74,'GF','French Guiana',NULL,NULL),
	(81,'GH','Ghana',NULL,NULL),
	(82,'GI','Gibraltar',NULL,NULL),
	(83,'GK','Guernsey',NULL,NULL),
	(85,'GL','Greenland',NULL,NULL),
	(78,'GM','Gambia',NULL,NULL),
	(90,'GN','Guinea',NULL,NULL),
	(87,'GP','Guadeloupe',NULL,NULL),
	(64,'GQ','Equatorial Guinea',NULL,NULL),
	(84,'GR','Greece',NULL,NULL),
	(201,'GS','South Georgia South Sandwich Islands',NULL,NULL),
	(89,'GT','Guatemala',NULL,NULL),
	(88,'GU','Guam',NULL,NULL),
	(91,'GW','Guinea-Bissau',NULL,NULL),
	(92,'GY','Guyana',NULL,NULL),
	(96,'HK','Hong Kong',NULL,NULL),
	(94,'HM','Heard and Mc Donald Islands',NULL,NULL),
	(95,'HN','Honduras',NULL,NULL),
	(52,'HR','Croatia (Hrvatska)',NULL,NULL),
	(93,'HT','Haiti',NULL,NULL),
	(97,'HU','Hungary',NULL,NULL),
	(101,'ID','Indonesia',NULL,NULL),
	(104,'IE','Ireland',NULL,NULL),
	(105,'IL','Israel',NULL,NULL),
	(100,'IM','Isle of Man',NULL,NULL),
	(99,'IN','India',NULL,NULL),
	(31,'IO','British Indian Ocean Territory',NULL,NULL),
	(103,'IQ','Iraq',NULL,NULL),
	(102,'IR','Iran (Islamic Republic of)',NULL,NULL),
	(98,'IS','Iceland',NULL,NULL),
	(106,'IT','Italy',NULL,NULL),
	(108,'JE','Jersey',NULL,NULL),
	(109,'JM','Jamaica',NULL,NULL),
	(111,'JO','Jordan',NULL,NULL),
	(110,'JP','Japan',NULL,NULL),
	(113,'KE','Kenya',NULL,NULL),
	(119,'KG','Kyrgyzstan',NULL,NULL),
	(36,'KH','Cambodia',NULL,NULL),
	(114,'KI','Kiribati',NULL,NULL),
	(48,'KM','Comoros',NULL,NULL),
	(184,'KN','Saint Kitts and Nevis',NULL,NULL),
	(115,'KP','Korea, Democratic People\'s Republic of',NULL,NULL),
	(116,'KR','Korea, Republic of',NULL,NULL),
	(118,'KW','Kuwait',NULL,NULL),
	(40,'KY','Cayman Islands',NULL,NULL),
	(112,'KZ','Kazakhstan',NULL,NULL),
	(120,'LA','Lao People\'s Democratic Republic',NULL,NULL),
	(122,'LB','Lebanon',NULL,NULL),
	(185,'LC','Saint Lucia',NULL,NULL),
	(126,'LI','Liechtenstein',NULL,NULL),
	(203,'LK','Sri Lanka',NULL,NULL),
	(124,'LR','Liberia',NULL,NULL),
	(123,'LS','Lesotho',NULL,NULL),
	(127,'LT','Lithuania',NULL,NULL),
	(128,'LU','Luxembourg',NULL,NULL),
	(121,'LV','Latvia',NULL,NULL),
	(125,'LY','Libyan Arab Jamahiriya',NULL,NULL),
	(149,'MA','Morocco',NULL,NULL),
	(145,'MC','Monaco',NULL,NULL),
	(144,'MD','Moldova, Republic of',NULL,NULL),
	(147,'ME','Montenegro',NULL,NULL),
	(131,'MG','Madagascar',NULL,NULL),
	(137,'MH','Marshall Islands',NULL,NULL),
	(130,'MK','Macedonia',NULL,NULL),
	(135,'ML','Mali',NULL,NULL),
	(151,'MM','Myanmar',NULL,NULL),
	(146,'MN','Mongolia',NULL,NULL),
	(129,'MO','Macau',NULL,NULL),
	(164,'MP','Northern Mariana Islands',NULL,NULL),
	(138,'MQ','Martinique',NULL,NULL),
	(139,'MR','Mauritania',NULL,NULL),
	(148,'MS','Montserrat',NULL,NULL),
	(136,'MT','Malta',NULL,NULL),
	(140,'MU','Mauritius',NULL,NULL),
	(134,'MV','Maldives',NULL,NULL),
	(132,'MW','Malawi',NULL,NULL),
	(142,'MX','Mexico',NULL,NULL),
	(133,'MY','Malaysia',NULL,NULL),
	(150,'MZ','Mozambique',NULL,NULL),
	(152,'NA','Namibia',NULL,NULL),
	(157,'NC','New Caledonia',NULL,NULL),
	(160,'NE','Niger',NULL,NULL),
	(163,'NF','Norfolk Island',NULL,NULL),
	(161,'NG','Nigeria',NULL,NULL),
	(159,'NI','Nicaragua',NULL,NULL),
	(155,'NL','Netherlands',NULL,NULL),
	(165,'NO','Norway',NULL,NULL),
	(154,'NP','Nepal',NULL,NULL),
	(153,'NR','Nauru',NULL,NULL),
	(162,'NU','Niue',NULL,NULL),
	(158,'NZ','New Zealand',NULL,NULL),
	(166,'OM','Oman',NULL,NULL),
	(170,'PA','Panama',NULL,NULL),
	(173,'PE','Peru',NULL,NULL),
	(75,'PF','French Polynesia',NULL,NULL),
	(171,'PG','Papua New Guinea',NULL,NULL),
	(174,'PH','Philippines',NULL,NULL),
	(167,'PK','Pakistan',NULL,NULL),
	(176,'PL','Poland',NULL,NULL),
	(205,'PM','St. Pierre and Miquelon',NULL,NULL),
	(175,'PN','Pitcairn',NULL,NULL),
	(178,'PR','Puerto Rico',NULL,NULL),
	(169,'PS','Palestine',NULL,NULL),
	(177,'PT','Portugal',NULL,NULL),
	(168,'PW','Palau',NULL,NULL),
	(172,'PY','Paraguay',NULL,NULL),
	(179,'QA','Qatar',NULL,NULL),
	(180,'RE','Reunion',NULL,NULL),
	(181,'RO','Romania',NULL,NULL),
	(192,'RS','Serbia',NULL,NULL),
	(182,'RU','Russian Federation',NULL,NULL),
	(183,'RW','Rwanda',NULL,NULL),
	(190,'SA','Saudi Arabia',NULL,NULL),
	(198,'SB','Solomon Islands',NULL,NULL),
	(193,'SC','Seychelles',NULL,NULL),
	(206,'SD','Sudan',NULL,NULL),
	(210,'SE','Sweden',NULL,NULL),
	(195,'SG','Singapore',NULL,NULL),
	(204,'SH','St. Helena',NULL,NULL),
	(197,'SI','Slovenia',NULL,NULL),
	(208,'SJ','Svalbard and Jan Mayen Islands',NULL,NULL),
	(196,'SK','Slovakia',NULL,NULL),
	(194,'SL','Sierra Leone',NULL,NULL),
	(188,'SM','San Marino',NULL,NULL),
	(191,'SN','Senegal',NULL,NULL),
	(199,'SO','Somalia',NULL,NULL),
	(207,'SR','Suriname',NULL,NULL),
	(189,'ST','Sao Tome and Principe',NULL,NULL),
	(63,'SV','El Salvador',NULL,NULL),
	(212,'SY','Syrian Arab Republic',NULL,NULL),
	(209,'SZ','Swaziland',NULL,NULL),
	(224,'TC','Turks and Caicos Islands',NULL,NULL),
	(42,'TD','Chad',NULL,NULL),
	(76,'TF','French Southern Territories',NULL,NULL),
	(217,'TG','Togo',NULL,NULL),
	(216,'TH','Thailand',NULL,NULL),
	(214,'TJ','Tajikistan',NULL,NULL),
	(218,'TK','Tokelau',NULL,NULL),
	(223,'TM','Turkmenistan',NULL,NULL),
	(221,'TN','Tunisia',NULL,NULL),
	(219,'TO','Tonga',NULL,NULL),
	(60,'TP','East Timor',NULL,NULL),
	(222,'TR','Turkey',NULL,NULL),
	(220,'TT','Trinidad and Tobago',NULL,NULL),
	(225,'TV','Tuvalu',NULL,NULL),
	(213,'TW','Taiwan',NULL,NULL),
	(141,'TY','Mayotte',NULL,NULL),
	(215,'TZ','Tanzania, United Republic of',NULL,NULL),
	(227,'UA','Ukraine',NULL,NULL),
	(226,'UG','Uganda',NULL,NULL),
	(231,'UM','United States minor outlying islands',NULL,NULL),
	(230,'US','United States',NULL,NULL),
	(232,'UY','Uruguay',NULL,NULL),
	(233,'UZ','Uzbekistan',NULL,NULL),
	(235,'VA','Vatican City State',NULL,NULL),
	(186,'VC','Saint Vincent and the Grenadines',NULL,NULL),
	(236,'VE','Venezuela',NULL,NULL),
	(238,'VG','Virgin Islands (British)',NULL,NULL),
	(239,'VI','Virgin Islands (U.S.)',NULL,NULL),
	(237,'VN','Vietnam',NULL,NULL),
	(234,'VU','Vanuatu',NULL,NULL),
	(240,'WF','Wallis and Futuna Islands',NULL,NULL),
	(187,'WS','Samoa',NULL,NULL),
	(117,'XK','Kosovo',NULL,NULL),
	(242,'YE','Yemen',NULL,NULL),
	(200,'ZA','South Africa',NULL,NULL),
	(244,'ZM','Zambia',NULL,NULL),
	(243,'ZR','Zaire',NULL,NULL),
	(245,'ZW','Zimbabwe',NULL,NULL);

/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `history`;

CREATE TABLE `history` (
  `history_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `edition_ID` int(10) unsigned NOT NULL,
  `registration_ID` int(10) unsigned DEFAULT NULL,
  `type` enum('registration','update','deregistration') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Description of event',
  `creator_ID` int(10) unsigned NOT NULL COMMENT 'Autor',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`history_ID`),
  KEY `history_registration_id_foreign` (`registration_ID`),
  KEY `history_creator_id_foreign` (`creator_ID`),
  KEY `history_edition_id_foreign` (`edition_ID`),
  CONSTRAINT `history_creator_id_foreign` FOREIGN KEY (`creator_ID`) REFERENCES `users` (`id`),
  CONSTRAINT `history_edition_id_foreign` FOREIGN KEY (`edition_ID`) REFERENCES `raceedition` (`edition_ID`),
  CONSTRAINT `history_registration_id_foreign` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records registrations history.';

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;

INSERT INTO `history` (`history_ID`, `edition_ID`, `registration_ID`, `type`, `description`, `creator_ID`, `created_at`, `updated_at`)
VALUES
	(1,1,50,'registration','Registration (50) Novák Michal was created successfully',1,'2019-02-05 12:43:32','2019-02-05 12:43:32'),
	(2,1,51,'registration','Registration (51) Prokop Pavel was created successfully',1,'2019-02-05 12:44:37','2019-02-05 12:44:37'),
	(3,1,52,'registration','Registration (52) Malá Anežka was created successfully',1,'2019-02-05 12:45:28','2019-02-05 12:45:28'),
	(4,1,NULL,'registration','Registration (53) Novotný Michal was created successfully',1,'2019-02-05 12:46:56','2019-02-05 12:46:56'),
	(5,1,NULL,'deregistration','Registration (53) Novotný Michal was deleted successfully',1,'2019-02-05 14:57:11','2019-02-05 14:57:11'),
	(6,1,71,'registration','Registration (71) Lakatoš George was created successfully',1,'2019-02-17 11:31:37','2019-02-17 11:31:37'),
	(7,1,72,'registration','Registration (72) Křivda Martin was created successfully',1,'2019-02-17 12:36:00','2019-02-17 12:36:00'),
	(8,1,73,'registration','Registration (73) Křivda Martin was created successfully',1,'2019-02-17 12:50:55','2019-02-17 12:50:55'),
	(9,1,74,'registration','Registration (74) Křivda Martin was created successfully',1,'2019-02-17 12:52:39','2019-02-17 12:52:39'),
	(10,1,75,'registration','Registration (75) Křivda Martin was created successfully',1,'2019-02-17 13:01:59','2019-02-17 13:01:59'),
	(11,1,76,'registration','Registration (76) Jan Petr was created successfully',1,'2019-02-17 13:04:08','2019-02-17 13:04:08'),
	(12,1,77,'registration','Registration (77) Majer Kudla was created successfully',1,'2019-02-17 13:04:41','2019-02-17 13:04:41'),
	(13,1,82,'registration','Registration (82) Pipek Tomáš was created successfully',1,'2019-02-17 14:21:24','2019-02-17 14:21:24'),
	(14,1,NULL,'registration','Registration (85) Voráček Lukáš was created successfully',1,'2019-02-17 17:41:17','2019-02-17 17:41:17'),
	(15,1,88,'registration','Registration (88) Vetchý Ondřej was created successfully',1,'2019-02-17 17:48:12','2019-02-17 17:48:12'),
	(16,1,89,'registration','Registration (89) Sháněl Karel was created successfully',1,'2019-02-18 09:34:57','2019-02-18 09:34:57'),
	(17,1,90,'registration','Registration (90) Sháněl Karel was created successfully',1,'2019-02-18 09:35:03','2019-02-18 09:35:03'),
	(18,1,91,'registration','Registration (91) Chaloupková Veronika was created successfully',1,'2019-02-18 11:32:39','2019-02-18 11:32:39'),
	(19,1,92,'registration','Registration (92) Novotná Gizela was created successfully',1,'2019-02-18 11:35:07','2019-02-18 11:35:07'),
	(20,1,NULL,'registration','Registration (93) Procházková Elizabeth was created successfully',1,'2019-02-18 11:37:25','2019-02-18 11:37:25'),
	(21,1,NULL,'registration','Registration (94) Hájek Adam was created successfully',1,'2019-02-18 11:38:26','2019-02-18 11:38:26'),
	(22,1,NULL,'registration','Registration (95) Kettner Vojtěch was created successfully',1,'2019-02-18 11:41:21','2019-02-18 11:41:21'),
	(23,1,NULL,'registration','Registration (96) Kettner Lukáš was created successfully',1,'2019-02-18 11:41:46','2019-02-18 11:41:46'),
	(24,1,NULL,'registration','Registration (97) Sladký Petr was created successfully',1,'2019-02-18 11:42:28','2019-02-18 11:42:28'),
	(25,1,NULL,'registration','Registration (98) Sirová Kudla was created successfully',1,'2019-02-18 11:42:50','2019-02-18 11:42:50'),
	(26,1,NULL,'registration','Registration (99) Smith Caroline was created successfully',1,'2019-02-18 11:43:37','2019-02-18 11:43:37'),
	(27,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 12:31:46','2019-02-18 12:31:46'),
	(28,1,NULL,'update','Registration (99) Smith Caroline was updated successfully',1,'2019-02-18 12:35:17','2019-02-18 12:35:17'),
	(29,1,NULL,'update','Registration (99) Smith Caroline was updated successfully',1,'2019-02-18 12:36:11','2019-02-18 12:36:11'),
	(30,1,NULL,'update','Registration (99) Smith Caroline was updated successfully',1,'2019-02-18 12:36:42','2019-02-18 12:36:42'),
	(31,1,NULL,'update','Registration (99) Smith Caroline was updated successfully',1,'2019-02-18 12:38:17','2019-02-18 12:38:17'),
	(32,1,NULL,'update','Registration (99) Smith Caroline was updated successfully',1,'2019-02-18 12:38:44','2019-02-18 12:38:44'),
	(33,1,NULL,'update','Registration (98) Sirová Kudla was updated successfully',1,'2019-02-18 12:39:50','2019-02-18 12:39:50'),
	(34,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 12:42:11','2019-02-18 12:42:11'),
	(35,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 12:45:27','2019-02-18 12:45:27'),
	(36,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 12:45:33','2019-02-18 12:45:33'),
	(37,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 12:45:38','2019-02-18 12:45:38'),
	(40,1,NULL,'deregistration','Registration (95) Kettner Vojtěch was deleted successfully',1,'2019-02-18 16:27:54','2019-02-18 16:27:54'),
	(41,1,NULL,'deregistration','Registration (94) Hájek Adam was deleted successfully',1,'2019-02-18 16:29:20','2019-02-18 16:29:20'),
	(42,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 16:45:58','2019-02-18 16:45:58'),
	(43,1,1,'update','Registration (1) Křivda Martin was updated successfully',1,'2019-02-18 16:46:05','2019-02-18 16:46:05'),
	(44,1,5,'update','Registration (5) Semrád Ladislav was updated successfully',1,'2019-02-18 16:46:12','2019-02-18 16:46:12'),
	(45,1,5,'update','Registration (5) Semrád Ladislav was updated successfully',1,'2019-02-18 16:46:18','2019-02-18 16:46:18'),
	(46,1,NULL,'deregistration','Registration (93) Procházková Elizabeth was deleted successfully',1,'2019-02-27 12:21:04','2019-02-27 12:21:04'),
	(47,1,92,'update','Registration (92) Novotná Gizela was updated successfully',1,'2019-02-27 16:10:39','2019-02-27 16:10:39'),
	(48,1,92,'update','Registration (92) Novotná Gizela was updated successfully',1,'2019-02-27 16:11:09','2019-02-27 16:11:09'),
	(49,1,5,'update','Registration (5) Semrád Ladislav was updated successfully',1,'2019-03-04 16:18:32','2019-03-04 16:18:32'),
	(50,1,5,'update','Registration (5) Semrád Ladislav was updated successfully',1,'2019-03-04 16:19:03','2019-03-04 16:19:03'),
	(51,1,29,'update','Registration (29) Bavor Martin was updated successfully',1,'2019-03-05 21:41:46','2019-03-05 21:41:46'),
	(52,1,30,'update','Registration (30) Zeman Miloš was updated successfully',1,'2019-03-05 21:42:00','2019-03-05 21:42:00'),
	(53,1,30,'update','Registration (30) Zeman Miloš was updated successfully',1,'2019-03-05 21:42:14','2019-03-05 21:42:14');

/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2014_10_12_200000_add_username_to_users_table',1),
	(4,'2018_08_05_204033_create_country_table',1),
	(5,'2018_08_22_080313_create_runner_table',1),
	(6,'2018_08_30_112105_add_club_to_runner_table',1),
	(7,'2018_09_05_203648_create_club_table',1),
	(8,'2018_09_06_211655_add_foreignkey_club_to_runner_table',1),
	(9,'2018_09_18_083727_create_organiser_table',1),
	(10,'2018_09_26_144549_create_race_table',1),
	(11,'2018_10_02_104039_create_raceedition_table',1),
	(12,'2018_10_09_203843_create_category_table',1),
	(13,'2018_11_03_214229_create_tag_table',1),
	(14,'2018_11_03_224900_create_reader_table',1),
	(15,'2018_11_03_232249_create_starttime_table',1),
	(16,'2018_11_04_213240_create_registration_table',1),
	(17,'2019_01_02_114414_create_notification_table',1),
	(18,'2019_01_02_134353_add_admin_to_users_table',1),
	(19,'2019_02_03_110102_create_registrationsum_table',2),
	(20,'2019_02_03_135924_create_history_table',3),
	(21,'2019_02_03_144143_add_regsummary_to_registration_table',4),
	(22,'2019_02_07_143542_create_role_table',5),
	(23,'2019_02_07_143847_create_user_role_table',5),
	(24,'2019_02_07_144234_create_permission_table',5),
	(26,'2019_03_02_092024_add_edition_to_starttime_table',6),
	(28,'2019_03_02_115533_add_lock_to_category_table',7),
	(29,'2019_03_03_110037_add_active_to_tag_table',8),
	(30,'2019_03_03_211532_add_editionid_to_history_table',9),
	(32,'2019_03_04_091738_add_timems_to_registration_table',10);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notification
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `notification_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registration_ID` int(10) unsigned NOT NULL,
  `type` enum('finish','registration','starttime') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` char(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`notification_ID`),
  KEY `notification_registration_id_foreign` (`registration_ID`),
  CONSTRAINT `notification_registration_id_foreign` FOREIGN KEY (`registration_ID`) REFERENCES `registration` (`registration_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;

INSERT INTO `notification` (`notification_ID`, `registration_ID`, `type`, `kind`, `text`, `email`, `phone`, `created_at`, `updated_at`)
VALUES
	(1,1,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Ladislav Semrád','ladislavsemrad@seznam.cz',NULL,'2019-01-02 16:51:03','2019-01-02 16:51:03'),
	(2,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-03 23:26:21','2019-01-03 23:26:21'),
	(4,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 16:24:25','2019-01-04 16:24:25'),
	(5,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 16:51:44','2019-01-04 16:51:44'),
	(6,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 17:30:17','2019-01-04 17:30:17'),
	(9,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 17:46:37','2019-01-04 17:46:37'),
	(10,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 17:47:33','2019-01-04 17:47:33'),
	(11,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 17:49:17','2019-01-04 17:49:17'),
	(12,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-04 18:01:15','2019-01-04 18:01:15'),
	(13,5,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Ladislav Semrád','ladislav.semrad@seznam.cz',NULL,'2019-01-04 18:02:28','2019-01-04 18:02:28'),
	(14,5,'registration','S','Registration with runner: Ladislav Semrád created for race 26. ročník Malé ceny Velké Verandy.',NULL,'+420608765432','2019-01-04 18:02:28','2019-01-04 18:02:28'),
	(15,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-04 20:56:09','2019-01-04 20:56:09'),
	(16,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-04 20:56:50','2019-01-04 20:56:50'),
	(17,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-04 20:57:05','2019-01-04 20:57:05'),
	(18,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-04 21:38:11','2019-01-04 21:38:11'),
	(28,5,'registration','E','Registration with runner: Ladislavka Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-07 13:06:08','2019-01-07 13:06:08'),
	(29,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-07 13:06:42','2019-01-07 13:06:42'),
	(30,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-07 13:06:54','2019-01-07 13:06:54'),
	(31,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-07 17:04:06','2019-01-07 17:04:06'),
	(32,8,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Tomáš Křivda','krivda.tomasek@gmail.com',NULL,'2019-01-07 17:04:22','2019-01-07 17:04:22'),
	(33,8,'registration','S','Registration with runner: Tomáš Křivda created for race 26. ročník Malé ceny Velké Verandy.',NULL,'+42034567890','2019-01-07 17:04:22','2019-01-07 17:04:22'),
	(41,8,'registration','E','Registration with runner: Tomáš Křivda updated for race 26. ročník Malé ceny Velké Verandy.','krivda.tomasek@gmail.com',NULL,'2019-01-17 23:54:53','2019-01-17 23:54:53'),
	(42,8,'registration','E','Registration with runner: Tomáš Křivda updated for race 26. ročník Malé ceny Velké Verandy.','krivda.tomasek@gmail.com',NULL,'2019-01-17 23:54:58','2019-01-17 23:54:58'),
	(43,1,'registration','E','Registration with runner: Martinf Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-22 14:53:18','2019-01-22 14:53:18'),
	(44,20,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Martin Křivda','martin.krivda@kobchocen.cz',NULL,'2019-01-22 17:36:59','2019-01-22 17:36:59'),
	(45,20,'registration','S','Registration with runner: Martin Křivda created for race 26. ročník Malé ceny Velké Verandy.',NULL,'+420774177641','2019-01-22 17:36:59','2019-01-22 17:36:59'),
	(46,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-22 18:36:51','2019-01-22 18:36:51'),
	(47,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-22 19:47:56','2019-01-22 19:47:56'),
	(48,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-22 19:58:27','2019-01-22 19:58:27'),
	(49,5,'registration','E','Registration with runner: Ladislav Semrád updated for race 26. ročník Malé ceny Velké Verandy.','ladislav.semrad@seznam.cz',NULL,'2019-01-22 19:59:01','2019-01-22 19:59:01'),
	(50,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-23 14:51:27','2019-01-23 14:51:27'),
	(51,1,'registration','E','Registration with runner: Martin Křivda updated for race 26. ročník Malé ceny Velké Verandy.','martin.krivda@kobchocen.cz',NULL,'2019-01-23 14:51:39','2019-01-23 14:51:39'),
	(52,8,'registration','E','Registration with runner: Tomáš Křivda updated for race 26. ročník Malé ceny Velké Verandy.','krivda.tomasek@gmail.com',NULL,'2019-01-23 21:42:06','2019-01-23 21:42:06'),
	(53,47,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Jana Peterová','janapeterova@seznam.cz',NULL,'2019-02-04 23:14:40','2019-02-04 23:14:40'),
	(54,48,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Andrea Mánková','andreamankova@seznam.cz',NULL,'2019-02-04 23:26:01','2019-02-04 23:26:01'),
	(55,49,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Karolína Šiková','sikovak@seznam.cz',NULL,'2019-02-04 23:26:37','2019-02-04 23:26:37'),
	(56,50,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Michal Novák','michal@novak.cz',NULL,'2019-02-05 12:43:32','2019-02-05 12:43:32'),
	(57,51,'registration','E','Registration for race 26. ročník Malé ceny Velké Verandy created successfully. Runner: Pavel Prokop','pavel@prokop.cz',NULL,'2019-02-05 12:44:37','2019-02-05 12:44:37'),
	(58,79,'registration','E','Registration with runner: Borůvka Krteček created for race 26. ročník Malé ceny Velké Verandy.','krtek@seznam.cz',NULL,'2019-02-17 14:09:44','2019-02-17 14:09:44'),
	(59,80,'registration','E','Registration with runner: Voborníková Melanie created for race 26. ročník Malé ceny Velké Verandy.','vobornikova@seznam.cz',NULL,'2019-02-17 14:10:24','2019-02-17 14:10:24'),
	(60,81,'registration','E','Registration with runner: Mohamed Ahmed created for race 26. ročník Malé ceny Velké Verandy.','mohamed@gmail.com',NULL,'2019-02-17 14:16:17','2019-02-17 14:16:17'),
	(61,83,'registration','E','Registration with runner: Voráček Lukáš created for race 26. ročník Malé ceny Velké Verandy.','voracek@gmail.com',NULL,'2019-02-17 17:34:29','2019-02-17 17:34:29'),
	(62,84,'registration','E','Registration with runner: Voráček Lukáš created for race 26. ročník Malé ceny Velké Verandy.','voracek@gmail.com',NULL,'2019-02-17 17:35:05','2019-02-17 17:35:05'),
	(64,86,'registration','E','Registration with runner: Jurášek Jan created for race 26. ročník Malé ceny Velké Verandy.','jurasek@seznam.cz',NULL,'2019-02-17 17:46:56','2019-02-17 17:46:56'),
	(65,87,'registration','E','Registration with runner: Jurášek Jan created for race 26. ročník Malé ceny Velké Verandy.','jurasek@seznam.cz',NULL,'2019-02-17 17:47:07','2019-02-17 17:47:07'),
	(66,88,'registration','E','Registration with runner: Vetchý Ondřej created for race 26. ročník Malé ceny Velké Verandy.','vetchy@gmail.com',NULL,'2019-02-17 17:48:11','2019-02-17 17:48:11'),
	(67,89,'registration','E','Registration with runner: Sháněl Karel created for race 26. ročník Malé ceny Velké Verandy.','jan.smolik@gmail.com',NULL,'2019-02-18 09:34:55','2019-02-18 09:34:55'),
	(68,90,'registration','E','Registration with runner: Sháněl Karel created for race 26. ročník Malé ceny Velké Verandy.','jan.smolik@gmail.com',NULL,'2019-02-18 09:35:02','2019-02-18 09:35:02'),
	(69,91,'registration','E','Registration with runner: Chaloupková Veronika created for race 26. ročník Malé ceny Velké Verandy.','veronika@chaloupkova.cz',NULL,'2019-02-18 11:32:37','2019-02-18 11:32:37');

/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table organiser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `organiser`;

CREATE TABLE `organiser` (
  `organiser_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organiser_abbr` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orgname` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orgname2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxid` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vatid` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankaccount` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankcode` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`organiser_ID`),
  UNIQUE KEY `organiser_organiser_abbr_unique` (`organiser_abbr`),
  KEY `organiser_country_foreign` (`country`),
  CONSTRAINT `organiser_country_foreign` FOREIGN KEY (`country`) REFERENCES `country` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records organizer`s information.';

LOCK TABLES `organiser` WRITE;
/*!40000 ALTER TABLE `organiser` DISABLE KEYS */;

INSERT INTO `organiser` (`organiser_ID`, `organiser_abbr`, `orgname`, `orgname2`, `taxid`, `vatid`, `street`, `city`, `postalcode`, `country`, `web`, `bankaccount`, `bankcode`, `created_at`, `updated_at`)
VALUES
	(1,'CHC','K.O.B. Choceň','z.s.','15030237',NULL,'Vostelčická 256','Choceň','56501','CZ','http://www.kobchocen.cz',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `organiser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records password resets of users.';

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;

INSERT INTO `password_resets` (`email`, `token`, `created_at`)
VALUES
	('MKrivda@outlook.com','$2y$10$IJaLLApH21XoNmAmpnU0YOSGXARDCGdEceJhe8PNq1OaUzaYSwvTK','2019-02-17 17:14:26');

/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `permission_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `for` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`permission_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;

INSERT INTO `permission` (`permission_ID`, `name`, `for`, `created_at`, `updated_at`)
VALUES
	(1,'Registration-Create','registration','2019-02-07 15:59:14','2019-02-07 15:59:14'),
	(2,'Registration-Update','registration','2019-02-07 15:59:14','2019-02-07 15:59:14'),
	(3,'Registration-Delete','registration','2019-02-07 15:59:14','2019-02-07 15:59:14'),
	(4,'Registration-View','registration','2019-02-22 13:55:10','2019-02-22 13:55:10'),
	(5,'StartTime-View','starttime','2019-02-22 13:55:10','2019-02-22 13:55:10'),
	(6,'StartTime-Generate','starttime','2019-02-22 13:55:10','2019-02-22 13:55:10'),
	(7,'Registration-Audit','registration','2019-02-22 13:55:10','2019-02-22 13:55:10'),
	(8,'ResultList-View','results','2019-02-22 13:55:10','2019-02-22 13:55:10');

/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permission_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `role_ID` int(10) unsigned NOT NULL,
  `permission_ID` int(10) unsigned NOT NULL,
  KEY `permission_role_role_id_foreign` (`role_ID`),
  KEY `permission_role_permission_id_foreign` (`permission_ID`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_ID`) REFERENCES `permission` (`permission_ID`),
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_ID`) REFERENCES `role` (`role_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;

INSERT INTO `permission_role` (`role_ID`, `permission_ID`)
VALUES
	(1,1),
	(1,2),
	(1,3),
	(1,4),
	(1,5),
	(1,6),
	(1,7),
	(1,8);

/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table race
# ------------------------------------------------------------

DROP TABLE IF EXISTS `race`;

CREATE TABLE `race` (
  `race_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `racename` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `race_abbr` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organiser_ID` int(10) unsigned NOT NULL,
  `web` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` char(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator_ID` int(10) unsigned NOT NULL,
  `deleted` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`race_ID`),
  UNIQUE KEY `race_racename_unique` (`racename`),
  UNIQUE KEY `race_race_abbr_unique` (`race_abbr`),
  KEY `race_organiser_id_foreign` (`organiser_ID`),
  KEY `race_creator_id_foreign` (`creator_ID`),
  CONSTRAINT `race_creator_id_foreign` FOREIGN KEY (`creator_ID`) REFERENCES `users` (`id`),
  CONSTRAINT `race_organiser_id_foreign` FOREIGN KEY (`organiser_ID`) REFERENCES `organiser` (`organiser_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records races.';

LOCK TABLES `race` WRITE;
/*!40000 ALTER TABLE `race` DISABLE KEYS */;

INSERT INTO `race` (`race_ID`, `racename`, `race_abbr`, `location`, `organiser_ID`, `web`, `email`, `phone`, `creator_ID`, `deleted`, `created_at`, `updated_at`)
VALUES
	(1,'Malá cena Velké Verandy','MCVV','Choceň',1,'http://www.mcvv.org','mcvv@mcvv.org',NULL,1,'0','2018-11-05 10:23:46','2018-11-05 10:23:46');

/*!40000 ALTER TABLE `race` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table raceedition
# ------------------------------------------------------------

DROP TABLE IF EXISTS `raceedition`;

CREATE TABLE `raceedition` (
  `edition_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `race_ID` int(10) unsigned NOT NULL,
  `editionname` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edition_nr` int(10) unsigned NOT NULL DEFAULT 1 COMMENT 'Number of race edition.',
  `date` date NOT NULL,
  `firststart` time NOT NULL,
  `eventoffice` datetime NOT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gps` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entrydate1` datetime DEFAULT NULL,
  `competition` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eventdirector` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mainreferee` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entriesmanager` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jury1` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jury2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jury3` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `cancelreason` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `protocol` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`edition_ID`),
  UNIQUE KEY `raceedition_editionname_unique` (`editionname`),
  KEY `raceedition_race_id_foreign` (`race_ID`),
  KEY `raceedition_editionname_index` (`editionname`),
  CONSTRAINT `raceedition_race_id_foreign` FOREIGN KEY (`race_ID`) REFERENCES `race` (`race_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records year edition of the races.';

LOCK TABLES `raceedition` WRITE;
/*!40000 ALTER TABLE `raceedition` DISABLE KEYS */;

INSERT INTO `raceedition` (`edition_ID`, `race_ID`, `editionname`, `edition_nr`, `date`, `firststart`, `eventoffice`, `location`, `gps`, `web`, `entrydate1`, `competition`, `eventdirector`, `mainreferee`, `entriesmanager`, `jury1`, `jury2`, `jury3`, `cancelled`, `cancelreason`, `protocol`, `created_at`, `updated_at`)
VALUES
	(1,1,'26. ročník Malé ceny Velké Verandy',26,'2018-12-02','10:15:00','2018-12-02 09:45:00','Choceň','49.9958283N, 16.2025778E','http://www.mcvv.org','2018-11-28 23:59:00','Zimní hradubická liga','Pavel Švadlena','Michal Pátek','Martin Křivda',NULL,NULL,NULL,'0',NULL,NULL,'2018-11-05 10:30:51','2018-11-05 10:30:51'),
	(2,1,'Test',27,'2018-12-02','10:15:00','2018-12-02 09:45:00','Choceň','49.9958283N, 16.2025778E','http://www.mcvv.org','2018-11-28 23:59:00','Zimní hradubická liga','Pavel Švadlena','Michal Pátek','Martin Křivda',NULL,NULL,NULL,'0',NULL,NULL,'2018-11-05 10:30:51','2018-11-05 10:30:51');

/*!40000 ALTER TABLE `raceedition` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reader
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reader`;

CREATE TABLE `reader` (
  `read_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `edition_ID` int(10) unsigned NOT NULL,
  `gateway` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfid_adress` varbinary(16) DEFAULT NULL,
  `EPC` bigint(20) unsigned NOT NULL,
  `year` year(4) NOT NULL,
  `time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`read_ID`),
  KEY `reader_edition_id_foreign` (`edition_ID`),
  KEY `reader_epc_index` (`EPC`),
  CONSTRAINT `reader_edition_id_foreign` FOREIGN KEY (`edition_ID`) REFERENCES `raceedition` (`edition_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records dats from RFID reader.';

LOCK TABLES `reader` WRITE;
/*!40000 ALTER TABLE `reader` DISABLE KEYS */;

INSERT INTO `reader` (`read_ID`, `edition_ID`, `gateway`, `rfid_adress`, `EPC`, `year`, `time`, `created_at`, `updated_at`)
VALUES
	(1,1,'F',X'3132372E302E302E31',38993854,'2019','2018-12-02 11:50:35','2019-03-04 10:50:35','2019-03-04 10:50:35'),
	(2,1,'F',X'3132372E302E302E31',38993854,'2019','2019-02-01 11:50:44','2019-03-04 10:50:44','2019-03-04 10:50:44');

/*!40000 ALTER TABLE `reader` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table registration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registration`;

CREATE TABLE `registration` (
  `registration_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `regsummary_ID` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Index to registrations summary',
  `edition_ID` int(10) unsigned NOT NULL,
  `runner_ID` int(10) unsigned NOT NULL,
  `club_ID` int(10) unsigned DEFAULT NULL,
  `category_ID` int(10) unsigned NOT NULL,
  `stime_ID` int(10) unsigned DEFAULT NULL,
  `start_nr` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yearofbirth` year(4) NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `club` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entryfee` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Entry fee',
  `payref` char(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Payment reference',
  `timems` int(10) unsigned DEFAULT NULL COMMENT 'Total time in miliseconds',
  `paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Registration is paid',
  `NC` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Not compenting',
  `DNS` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Did not start',
  `DNF` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Did not finish',
  `DSQ` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Disqualified',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Note',
  `creator_ID` int(10) unsigned NOT NULL COMMENT 'Autor',
  `version` int(10) unsigned NOT NULL DEFAULT 1 COMMENT 'Version number',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`registration_ID`),
  KEY `registration_creator_id_foreign` (`creator_ID`),
  KEY `registration_edition_id_foreign` (`edition_ID`),
  KEY `registration_runner_id_foreign` (`runner_ID`),
  KEY `registration_club_id_foreign` (`club_ID`),
  KEY `registration_category_id_foreign` (`category_ID`),
  KEY `registration_stime_id_foreign` (`stime_ID`),
  KEY `registration_firstname_lastname_index` (`firstname`,`lastname`),
  KEY `registration_regsummary_id_foreign` (`regsummary_ID`),
  CONSTRAINT `registration_category_id_foreign` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`),
  CONSTRAINT `registration_club_id_foreign` FOREIGN KEY (`club_ID`) REFERENCES `club` (`club_ID`),
  CONSTRAINT `registration_creator_id_foreign` FOREIGN KEY (`creator_ID`) REFERENCES `users` (`id`),
  CONSTRAINT `registration_edition_id_foreign` FOREIGN KEY (`edition_ID`) REFERENCES `raceedition` (`edition_ID`),
  CONSTRAINT `registration_regsummary_id_foreign` FOREIGN KEY (`regsummary_ID`) REFERENCES `registrationsum` (`regsummary_ID`),
  CONSTRAINT `registration_runner_id_foreign` FOREIGN KEY (`runner_ID`) REFERENCES `runner` (`runner_ID`),
  CONSTRAINT `registration_stime_id_foreign` FOREIGN KEY (`stime_ID`) REFERENCES `starttime` (`stime_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records registration .';

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;

INSERT INTO `registration` (`registration_ID`, `regsummary_ID`, `edition_ID`, `runner_ID`, `club_ID`, `category_ID`, `stime_ID`, `start_nr`, `firstname`, `lastname`, `yearofbirth`, `gender`, `club`, `entryfee`, `payref`, `timems`, `paid`, `NC`, `DNS`, `DNF`, `DSQ`, `note`, `creator_ID`, `version`, `created_at`, `updated_at`)
VALUES
	(1,0,1,1,1,1,7,'1','Martin','Křivda','1995','male','K.O.B. Choceň',50.00,'2018010234',NULL,1,0,0,0,0,NULL,1,16,'2018-01-02 15:25:00','2019-03-04 20:30:49'),
	(5,0,1,3,NULL,1,5,'2','Ladislav','Semrád','1997','male','',50.00,'2031',NULL,1,0,0,0,0,NULL,1,13,'2019-01-04 18:02:28','2019-03-04 20:30:49'),
	(8,0,1,6,NULL,1,1,'3','Tomáš','Křivda','1999','male',NULL,50.00,'20031',NULL,1,0,0,0,0,NULL,1,3,'2019-01-07 17:04:22','2019-03-04 20:30:49'),
	(9,0,1,7,NULL,5,NULL,NULL,'Karel','Novotný','1996','male',NULL,20.00,'20032',NULL,1,0,0,0,0,NULL,1,1,'2019-01-07 17:05:44','2019-01-07 17:05:51'),
	(10,0,1,8,NULL,4,NULL,NULL,'Anička','Karlová','2008','female',NULL,20.00,'20033',NULL,1,0,0,0,0,NULL,1,22,'2019-01-07 17:06:20','2019-01-22 17:51:17'),
	(20,0,1,1,NULL,1,4,NULL,'Martin','Křivda','1995','male',NULL,50.00,'20078',NULL,1,0,0,0,0,NULL,1,0,'2019-01-22 17:36:59','2019-03-04 20:30:49'),
	(21,0,1,18,1,1,8,NULL,'Pavel','Švadlena','1976','male',NULL,50.00,'20086',NULL,1,0,0,0,0,NULL,1,5,'2019-01-22 17:44:11','2019-03-04 20:30:49'),
	(22,0,1,19,NULL,1,3,NULL,'Malenie','Picková','1996','male',NULL,50.00,'201920031',NULL,1,0,0,0,0,'	',1,13,'2019-01-22 19:08:49','2019-03-04 20:30:49'),
	(23,0,1,20,1,1,10,NULL,'Bejbanek','Švadlena','1976','male',NULL,50.00,'201920069',NULL,1,0,0,0,0,'',1,2,'2019-01-22 19:46:43','2019-03-04 20:30:49'),
	(24,0,1,21,NULL,1,2,NULL,'Valley','Miloš','1998','male',NULL,50.00,'201911051',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 10:27:03','2019-03-04 20:30:49'),
	(25,0,1,22,NULL,1,6,NULL,'Václav','Vadlejch','1992','male',NULL,50.00,'201911051',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 10:27:35','2019-03-04 20:30:49'),
	(27,0,1,24,NULL,1,11,NULL,'Mirslav','Kalousek','1975','male',NULL,50.00,'201911058',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 10:34:34','2019-03-04 20:30:49'),
	(28,0,1,25,NULL,1,9,NULL,'Tomáš','Novotný','1998','male',NULL,50.00,'201911059',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 10:35:49','2019-03-04 20:30:49'),
	(29,0,1,26,1,1,12,'12','Martin','Bavor','2003','male',NULL,50.00,'201911077',NULL,1,0,0,0,0,NULL,1,1,'2019-01-23 10:53:08','2019-03-05 21:41:46'),
	(30,0,1,27,NULL,2,NULL,'300','Miloš','Zeman','1940','male',NULL,50.00,'201912040',NULL,1,0,0,0,0,NULL,1,2,'2019-01-23 11:16:24','2019-03-05 21:42:14'),
	(31,0,1,28,NULL,3,NULL,NULL,'Melani','Horníková','1998','male',NULL,20.00,'201912049',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 11:25:41','2019-01-23 11:25:41'),
	(32,0,1,29,NULL,2,NULL,NULL,'Melanie','Horníková','1995','male',NULL,50.00,'201912050',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 11:26:50','2019-01-23 11:26:50'),
	(33,0,1,30,NULL,2,NULL,NULL,'Jan','Hintner','1996','male',NULL,50.00,'201912055',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 11:31:45','2019-01-23 11:31:45'),
	(34,0,1,31,NULL,1,NULL,NULL,'Miroslav','Kalousek','1997','male',NULL,50.00,'201914079',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 13:55:02','2019-01-23 13:55:02'),
	(35,0,1,32,NULL,3,NULL,'129','Bohumír','Sýkora','1987','male',NULL,20.00,'201914080',NULL,1,0,0,0,0,NULL,1,1,'2019-01-23 13:56:09','2019-01-23 14:59:27'),
	(36,0,1,33,NULL,1,NULL,NULL,'Marek','Jalůvka','1997','male',NULL,50.00,'201923030',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 22:06:06','2019-01-23 22:06:06'),
	(37,0,1,34,NULL,2,NULL,NULL,'Berenika','Držková','1996','female',NULL,50.00,'201923034',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 22:10:05','2019-01-23 22:10:05'),
	(39,0,1,36,NULL,2,NULL,NULL,'Bůžková','Katarzyna','1996','male',NULL,50.00,'201923049',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 22:25:37','2019-01-23 22:25:37'),
	(40,0,1,37,NULL,3,NULL,NULL,'Selina','Havrdová','2004','female',NULL,20.00,'201923051',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 22:27:31','2019-01-23 22:27:31'),
	(41,0,1,38,NULL,2,NULL,NULL,'Hůlková','Pavlína','1996','female',NULL,50.00,'201923061',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 22:37:39','2019-01-23 22:37:39'),
	(42,0,1,39,1,8,NULL,NULL,'Lenka','Křivdová','1972','female',NULL,50.00,'201923076',NULL,1,0,0,0,0,NULL,1,0,'2019-01-23 22:52:16','2019-01-23 22:52:16'),
	(43,0,1,40,NULL,1,NULL,NULL,'Patrik','Horák','1998','male',NULL,50.00,'201911052',NULL,1,0,0,0,0,NULL,1,0,'2019-01-24 10:27:27','2019-01-24 10:27:27'),
	(44,0,1,41,NULL,1,NULL,NULL,'Michal','Novotný','1998','male',NULL,50.00,'201911054',NULL,1,0,0,0,0,NULL,1,0,'2019-01-24 10:29:17','2019-01-24 10:29:17'),
	(45,0,1,42,NULL,1,NULL,NULL,'Pavel','Košárek','1997','male',NULL,50.00,'201912055',NULL,1,0,0,0,0,NULL,1,0,'2019-01-24 11:30:13','2019-01-24 11:30:13'),
	(46,0,1,43,NULL,1,NULL,NULL,'Karel','Jonák','1998','male',NULL,50.00,'201912058',NULL,1,0,0,0,0,'pozdní start',1,0,'2019-01-24 11:33:57','2019-01-24 11:33:57'),
	(47,2,1,44,NULL,2,NULL,NULL,'Jana','Peterová','1999','female',NULL,50.00,'201921',NULL,1,0,0,0,0,NULL,1,0,'2019-02-04 23:14:40','2019-02-04 23:14:40'),
	(48,3,1,45,NULL,2,NULL,NULL,'Andrea','Mánková','1993','female',NULL,50.00,'201933',NULL,1,0,0,0,0,NULL,1,0,'2019-02-04 23:26:01','2019-02-04 23:26:01'),
	(49,3,1,46,NULL,2,NULL,NULL,'Karolína','Šiková','1996','female',NULL,50.00,'201933',NULL,1,0,0,0,0,NULL,1,0,'2019-02-04 23:26:37','2019-02-04 23:26:37'),
	(50,4,1,47,NULL,1,NULL,NULL,'Michal','Novák','1993','male',NULL,50.00,'201913050',NULL,1,0,0,0,0,NULL,1,0,'2019-02-05 12:43:32','2019-02-05 12:43:32'),
	(51,4,1,48,NULL,7,NULL,NULL,'Pavel','Prokop','1980','male',NULL,50.00,'201913051',NULL,1,1,0,0,0,NULL,1,0,'2019-02-05 12:44:37','2019-02-05 12:44:37'),
	(52,4,1,49,NULL,6,NULL,NULL,'Anežka','Malá','1997','female',NULL,20.00,'201913052',NULL,1,0,0,0,0,NULL,1,0,'2019-02-05 12:45:28','2019-02-05 12:45:28'),
	(54,12,1,5,1,1,NULL,NULL,'Jan','Sháněl','1994','male',NULL,50.00,'20192619',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 00:14:58','2019-02-17 00:14:58'),
	(55,13,1,5,1,1,NULL,NULL,'Jan','Sháněl','1994','male',NULL,50.00,'20192719',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 00:15:23','2019-02-17 00:15:23'),
	(56,14,1,53,NULL,1,NULL,NULL,'Jaromír','Soukup','1997','male',NULL,50.00,'201928019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 00:16:53','2019-02-17 00:16:53'),
	(57,15,1,30,NULL,1,NULL,NULL,'Jan','Hintner','1996','male',NULL,50.00,'201931019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 00:19:53','2019-02-17 00:19:53'),
	(59,17,1,39,1,8,NULL,NULL,'Lenka','Křivdová','1972','female',NULL,50.00,'201934019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 09:25:06','2019-02-17 09:25:06'),
	(60,18,1,39,1,8,NULL,NULL,'Lenka','Křivdová','1972','female',NULL,50.00,'201934019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 09:25:29','2019-02-17 09:25:29'),
	(62,20,1,61,NULL,1,NULL,'2','Karel','Sháněl','1998','male',NULL,50.00,'201953019',NULL,0,1,0,0,0,NULL,1,1,'2019-02-17 10:43:31','2019-02-17 10:43:31'),
	(63,21,1,7,NULL,1,NULL,NULL,'Karel','Novotný','1996','male',NULL,50.00,'201955019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 10:45:08','2019-02-17 10:45:08'),
	(64,20,1,30,NULL,1,NULL,NULL,'Jan','Hintner','1996','male',NULL,50.00,'201955019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 10:45:43','2019-02-17 10:45:43'),
	(65,21,1,8,NULL,6,NULL,NULL,'Anička','Karlová','2008','female',NULL,20.00,'201957019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 10:47:51','2019-02-17 10:47:51'),
	(66,22,1,46,NULL,2,NULL,NULL,'Karolína','Šiková','1996','female',NULL,50.00,'201963019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 10:53:09','2019-02-17 10:53:09'),
	(67,23,1,8,NULL,6,NULL,NULL,'Anička','Karlová','2008','female',NULL,20.00,'201966019',NULL,0,0,0,0,0,'gfgf',1,1,'2019-02-17 10:56:26','2019-02-17 10:56:26'),
	(68,24,1,51,1,1,NULL,NULL,'Anička','Karlová','1996','male',NULL,50.00,'201966019',NULL,0,0,0,0,0,'ahoj',1,1,'2019-02-17 10:56:56','2019-02-17 10:56:56'),
	(69,23,1,19,NULL,1,NULL,NULL,'Malenie','Picková','1996','male',NULL,50.00,'201967019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 10:57:19','2019-02-17 10:57:19'),
	(70,24,1,5,1,1,NULL,NULL,'Jan','Sháněl','1994','male',NULL,50.00,'201968019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 10:58:03','2019-02-17 10:58:03'),
	(71,25,1,62,NULL,1,NULL,NULL,'George','Lakatoš','1998','male',NULL,50.00,'201942019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 11:31:37','2019-02-17 11:31:37'),
	(72,26,1,1,1,1,NULL,NULL,'Martin','Křivda','1995','male',NULL,50.00,'201948019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 12:36:00','2019-02-17 12:36:00'),
	(73,27,1,1,1,1,NULL,NULL,'Martin','Křivda','1995','male',NULL,50.00,'201962019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 12:50:55','2019-02-17 12:50:55'),
	(74,28,1,1,1,1,NULL,NULL,'Martin','Křivda','1995','male',NULL,50.00,'201964019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 12:52:39','2019-02-17 12:52:39'),
	(75,29,1,1,1,1,NULL,NULL,'Martin','Křivda','1995','male',NULL,50.00,'20192019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 13:01:59','2019-02-17 13:01:59'),
	(76,30,1,63,NULL,1,NULL,NULL,'Petr','Jan','1986','male',NULL,50.00,'20195019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 13:04:08','2019-02-17 13:04:08'),
	(77,31,1,64,NULL,7,NULL,NULL,'Kudla','Majer','1975','male',NULL,50.00,'20195019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 13:04:41','2019-02-17 13:04:41'),
	(78,32,1,65,NULL,1,NULL,NULL,'Krteček','Borůvka','1996','male',NULL,50.00,'201911019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 14:09:22','2019-02-17 14:09:22'),
	(79,33,1,66,NULL,1,NULL,NULL,'Krteček','Borůvka','1996','male',NULL,50.00,'201911019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 14:09:44','2019-02-17 14:09:44'),
	(80,34,1,67,NULL,1,NULL,NULL,'Melanie','Voborníková','1998','male',NULL,50.00,'201912019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 14:10:24','2019-02-17 14:10:24'),
	(81,35,1,68,NULL,1,NULL,NULL,'Ahmed','Mohamed','1998','male',NULL,50.00,'201918019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 14:16:17','2019-02-17 14:16:17'),
	(82,36,1,69,NULL,1,NULL,NULL,'Tomáš','Pipek','1998','male',NULL,50.00,'201923019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 14:21:24','2019-02-17 14:21:24'),
	(83,37,1,70,NULL,1,NULL,NULL,'Lukáš','Voráček','1998','male',NULL,50.00,'201939019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 17:34:29','2019-02-17 17:34:29'),
	(84,38,1,71,NULL,1,NULL,NULL,'Lukáš','Voráček','1998','male',NULL,50.00,'201940019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 17:35:05','2019-02-17 17:35:05'),
	(86,40,1,73,NULL,1,NULL,NULL,'Jan','Jurášek','1987','male',NULL,50.00,'201951019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 17:46:56','2019-02-17 17:46:56'),
	(87,41,1,74,NULL,1,NULL,NULL,'Jan','Jurášek','1987','male',NULL,50.00,'201952019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 17:47:07','2019-02-17 17:47:07'),
	(88,42,1,75,NULL,7,NULL,NULL,'Ondřej','Vetchý','1975','male',NULL,50.00,'201953019',NULL,0,0,0,0,0,NULL,1,1,'2019-02-17 17:48:11','2019-02-17 17:48:11'),
	(89,20,1,61,NULL,1,NULL,'2','Karel','Sháněl','1998','male',NULL,50.00,'201943020',NULL,0,1,0,0,0,NULL,1,1,'2019-02-18 09:34:55','2019-02-18 09:34:55'),
	(90,20,1,61,NULL,1,NULL,'2','Karel','Sháněl','1998','male',NULL,50.00,'201944020',NULL,0,1,0,0,0,NULL,1,1,'2019-02-18 09:35:02','2019-02-18 09:35:02'),
	(91,43,1,76,1,2,NULL,NULL,'Veronika','Chaloupková','1998','female',NULL,50.00,'201943020',NULL,0,0,0,0,0,NULL,1,1,'2019-02-18 11:32:37','2019-02-18 11:32:37'),
	(92,43,1,77,NULL,8,NULL,NULL,'Gizela','Novotná','1965','female',NULL,50.00,'201946020',NULL,0,0,0,0,0,NULL,1,3,'2019-02-18 11:35:07','2019-02-27 16:11:09');

/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table registrationsum
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registrationsum`;

CREATE TABLE `registrationsum` (
  `regsummary_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `edition_ID` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Sum of entry fees',
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Discount to registration',
  `totalprice` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Total price for registrations',
  `payref` char(13) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Payment reference',
  `status` smallint(6) NOT NULL DEFAULT 0,
  `creator_ID` int(10) unsigned NOT NULL COMMENT 'Autor',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`regsummary_ID`),
  KEY `registrationsum_creator_id_foreign` (`creator_ID`),
  KEY `registrationsum_edition_id_foreign` (`edition_ID`),
  CONSTRAINT `registrationsum_creator_id_foreign` FOREIGN KEY (`creator_ID`) REFERENCES `users` (`id`),
  CONSTRAINT `registrationsum_edition_id_foreign` FOREIGN KEY (`edition_ID`) REFERENCES `raceedition` (`edition_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records registrations summary.';

LOCK TABLES `registrationsum` WRITE;
/*!40000 ALTER TABLE `registrationsum` DISABLE KEYS */;

INSERT INTO `registrationsum` (`regsummary_ID`, `edition_ID`, `name`, `email`, `price`, `discount`, `totalprice`, `payref`, `status`, `creator_ID`, `created_at`, `updated_at`)
VALUES
	(0,1,'Not grouped','martin.krivda@kobchocen.cz',0.00,0.00,0.00,'1902041703',3,1,'2019-02-03 17:03:06','2019-02-03 17:03:06'),
	(2,1,'JanaPeterová','janapeterova@seznam.cz',50.00,0.00,50.00,'201925105',0,1,'2019-02-04 23:14:40','2019-02-04 23:14:40'),
	(3,1,'AndreaMánková','andreamankova@seznam.cz',100.00,0.00,100.00,'20192583',0,1,'2019-02-04 23:26:01','2019-02-04 23:26:37'),
	(4,1,'NOVÁK MICHAL','michal@novak.cz',120.00,0.00,120.00,'201925193',0,1,'2019-02-05 12:43:32','2019-02-05 12:45:28'),
	(5,1,'NOVOTNÝ MICHAL','',20.00,0.00,20.00,'201925201',0,1,'2019-02-05 12:46:56','2019-02-05 12:46:56'),
	(6,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190216713',0,1,'2019-02-16 22:53:57','2019-02-16 22:53:57'),
	(7,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190216705',0,1,'2019-02-16 22:54:22','2019-02-16 22:54:22'),
	(8,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190217295',0,1,'2019-02-17 00:10:45','2019-02-17 00:10:45'),
	(9,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190217255',0,1,'2019-02-17 00:11:29','2019-02-17 00:11:29'),
	(10,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190217308',0,1,'2019-02-17 00:12:19','2019-02-17 00:12:19'),
	(11,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190217317',0,1,'2019-02-17 00:13:10','2019-02-17 00:13:10'),
	(12,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190217354',0,1,'2019-02-17 00:14:58','2019-02-17 00:14:58'),
	(13,1,'SHÁNĚL JAN','janmain@seznam.cz',50.00,0.00,50.00,'20190217305',0,1,'2019-02-17 00:15:23','2019-02-17 00:15:23'),
	(14,1,'SOUKUP JAROMÍR','soukup@prima.cz',50.00,0.00,50.00,'20190217341',0,1,'2019-02-17 00:16:53','2019-02-17 00:16:53'),
	(15,1,'HINTNER JAN',NULL,50.00,0.00,50.00,'20190217398',0,1,'2019-02-17 00:19:53','2019-02-17 00:19:53'),
	(16,1,'KUBIČIKOVÁ KATEŘINA',NULL,50.00,0.00,50.00,'20190217412',0,1,'2019-02-17 00:21:40','2019-02-17 00:21:40'),
	(17,1,'KŘIVDOVÁ LENKA','lenka.krivdova@gmail.com',50.00,0.00,50.00,'20190217356',0,1,'2019-02-17 09:25:06','2019-02-17 09:25:06'),
	(18,1,'KŘIVDOVÁ LENKA','jan.smolik@gmail.com',50.00,0.00,50.00,'20190217370',0,1,'2019-02-17 09:25:29','2019-02-17 09:25:29'),
	(19,1,'KUBIČIKOVÁ KATEŘINA',NULL,50.00,0.00,50.00,'20190217572',0,1,'2019-02-17 09:41:22','2019-02-17 09:41:22'),
	(20,1,'SHÁNĚL KAREL','jan.smolik@gmail.com',200.00,0.00,200.00,'20190217559',0,1,'2019-02-17 10:43:31','2019-02-18 09:35:02'),
	(21,1,'NOVOTNÝ KAREL',NULL,70.00,0.00,50.00,'20190217614',0,1,'2019-02-17 10:45:08','2019-02-17 10:47:51'),
	(22,1,'ŠIKOVÁ KAROLÍNA','sikovak@seznam.cz',50.00,0.00,50.00,'20190217650',0,1,'2019-02-17 10:53:09','2019-02-17 10:53:09'),
	(23,1,'KARLOVÁ ANIČKA',NULL,70.00,0.00,70.00,'20190217710',0,1,'2019-02-17 10:56:26','2019-02-17 10:57:19'),
	(24,1,'KARLOVÁ ANIČKA','MKrivda@outlook.com',100.00,0.00,100.00,'20190217705',0,1,'2019-02-17 10:56:56','2019-02-17 10:58:03'),
	(25,1,'LAKATOŠ GEORGE','karlikovaL@penam.cz',50.00,0.00,50.00,'20190217478',0,1,'2019-02-17 11:31:37','2019-02-17 11:31:37'),
	(26,1,'KŘIVDA MARTIN','martin.krivda@kobchocen.cz',50.00,0.00,50.00,'20190217571',0,1,'2019-02-17 12:36:00','2019-02-17 12:36:00'),
	(27,1,'KŘIVDA MARTIN','martin.krivda@kobchocen.cz',50.00,0.00,50.00,'20190217622',0,1,'2019-02-17 12:50:55','2019-02-17 12:50:55'),
	(28,1,'KŘIVDA MARTIN','martin.krivda@kobchocen.cz',50.00,0.00,50.00,'20190217691',0,1,'2019-02-17 12:52:39','2019-02-17 12:52:39'),
	(29,1,'KŘIVDA MARTIN','martin.krivda@kobchocen.cz',50.00,0.00,50.00,'2019021759',0,1,'2019-02-17 13:01:59','2019-02-17 13:01:59'),
	(30,1,'JAN PETR',NULL,50.00,0.00,50.00,'2019021762',0,1,'2019-02-17 13:04:08','2019-02-17 13:04:08'),
	(31,1,'MAJER KUDLA',NULL,50.00,0.00,50.00,'20190217129',0,1,'2019-02-17 13:04:41','2019-02-17 13:04:41'),
	(32,1,'BORŮVKA KRTEČEK','krtek@seznam.cz',50.00,0.00,50.00,'20190217140',0,1,'2019-02-17 14:09:22','2019-02-17 14:09:22'),
	(33,1,'BORŮVKA KRTEČEK','krtek@seznam.cz',50.00,0.00,50.00,'20190217111',0,1,'2019-02-17 14:09:44','2019-02-17 14:09:44'),
	(34,1,'VOBORNÍKOVÁ MELANIE','vobornikova@seznam.cz',50.00,0.00,50.00,'20190217151',0,1,'2019-02-17 14:10:24','2019-02-17 14:10:24'),
	(35,1,'MOHAMED AHMED','mohamed@gmail.com',50.00,0.00,50.00,'20190217234',0,1,'2019-02-17 14:16:17','2019-02-17 14:16:17'),
	(36,1,'PIPEK TOMÁŠ',NULL,50.00,0.00,50.00,'20190217281',0,1,'2019-02-17 14:21:24','2019-02-17 14:21:24'),
	(37,1,'VORÁČEK LUKÁŠ','voracek@gmail.com',50.00,0.00,50.00,'20190217411',0,1,'2019-02-17 17:34:29','2019-02-17 17:34:29'),
	(38,1,'VORÁČEK LUKÁŠ','voracek@gmail.com',50.00,0.00,50.00,'20190217486',0,1,'2019-02-17 17:35:05','2019-02-17 17:35:05'),
	(39,1,'VORÁČEK LUKÁŠ','voracek@gmail.com',0.00,0.00,0.00,'20190217547',0,1,'2019-02-17 17:41:15','2019-02-18 16:25:23'),
	(40,1,'JURÁŠEK JAN','jurasek@seznam.cz',50.00,0.00,50.00,'20190217531',0,1,'2019-02-17 17:46:56','2019-02-17 17:46:56'),
	(41,1,'JURÁŠEK JAN','jurasek@seznam.cz',50.00,0.00,50.00,'20190217601',0,1,'2019-02-17 17:47:07','2019-02-17 17:47:07'),
	(42,1,'VETCHÝ ONDŘEJ','vetchy@gmail.com',50.00,0.00,50.00,'20190217536',0,1,'2019-02-17 17:48:11','2019-02-17 17:48:11'),
	(43,1,'CHALOUPKOVÁ VERONIKA','veronika@chaloupkova.cz',100.00,0.00,100.00,'20190218485',0,1,'2019-02-18 11:32:37','2019-02-27 12:21:04'),
	(44,1,'HÁJEK ADAM','adam@hajek.com',0.00,30.00,0.00,'20190218532',0,1,'2019-02-18 11:38:25','2019-02-18 16:29:20'),
	(45,1,'KETTNER VOJTĚCH','vojta@kettneru.com',0.00,0.00,0.00,'20190218521',0,1,'2019-02-18 11:41:19','2019-02-18 16:27:54'),
	(46,1,'KETTNER LUKÁŠ',NULL,0.00,0.00,0.00,'20190218619',0,1,'2019-02-18 11:41:46','2019-02-18 16:26:59'),
	(47,1,'SLADKÝ PETR',NULL,0.00,0.00,0.00,'20190218611',0,1,'2019-02-18 11:42:28','2019-02-18 16:17:32'),
	(48,1,'SIROVÁ KUDLA',NULL,0.00,0.00,0.00,'20190218609',0,1,'2019-02-18 11:42:50','2019-02-18 12:39:50'),
	(49,1,'SMITH CAROLINE',NULL,20.00,0.00,20.00,'20190218570',0,1,'2019-02-18 11:43:37','2019-02-18 12:36:11'),
	(50,1,'SMITH CAROLINE',NULL,50.00,0.00,50.00,'20190218525',0,1,'2019-02-18 12:36:42','2019-02-18 15:56:59'),
	(51,1,'SMITH CAROLINE',NULL,0.00,0.00,0.00,'20190218543',0,1,'2019-02-18 12:38:17','2019-02-18 16:17:15');

/*!40000 ALTER TABLE `registrationsum` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `role_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;

INSERT INTO `role` (`role_ID`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'Administrator','2019-02-07 15:39:40','2019-02-07 15:39:40'),
	(2,'Editor','2019-02-07 15:39:40','2019-02-07 15:39:40'),
	(3,'Speaker','2019-02-07 15:39:40','2019-02-07 15:39:40');

/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table runner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `runner`;

CREATE TABLE `runner` (
  `runner_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yearofbirth` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` char(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club_ID` int(10) unsigned DEFAULT NULL,
  `club` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`runner_ID`),
  KEY `runner_country_foreign` (`country`),
  KEY `runner_firstname_lastname_index` (`firstname`,`lastname`),
  KEY `runner_club_id_foreign` (`club_ID`),
  CONSTRAINT `runner_club_id_foreign` FOREIGN KEY (`club_ID`) REFERENCES `club` (`club_ID`),
  CONSTRAINT `runner_country_foreign` FOREIGN KEY (`country`) REFERENCES `country` (`country_code`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records registered runners.';

LOCK TABLES `runner` WRITE;
/*!40000 ALTER TABLE `runner` DISABLE KEYS */;

INSERT INTO `runner` (`runner_ID`, `firstname`, `lastname`, `yearofbirth`, `gender`, `email`, `phone`, `country`, `club_ID`, `club`, `deleted`, `created_at`, `updated_at`)
VALUES
	(1,'Martin','Křivda','1995','male','martin.krivda@kobchocen.cz','+420774177641','CZ',1,NULL,'0','2019-01-02 14:23:34','2019-02-18 12:42:11'),
	(3,'Ladislav','Semrád','1997','male','ladislav.semrad@seznam.cz','+420608765432','CZ',NULL,'K.O.B. Choceň','0','2019-01-03 23:32:25','2019-01-07 17:04:06'),
	(4,'Tomáš','Křivda','1999','male','krivda.tomasek@gmail.com','+42034567890','CZ',NULL,'K.O.B. Choceň','0','2019-01-04 21:43:16','2019-01-04 21:43:16'),
	(5,'Jan','Sháněl','1994','male','janmain@seznam.cz','','CZ',1,NULL,'0','2019-01-04 22:03:33','2019-01-04 22:03:33'),
	(6,'Tomáš','Křivda','1999','male','krivda.tomasek@gmail.com','+42034567890','CZ',NULL,NULL,'0','2019-01-07 17:04:22','2019-01-17 23:54:58'),
	(7,'Karel','Novotný','1996','male','','','AO',NULL,NULL,'0','2019-01-07 17:05:44','2019-01-07 17:05:51'),
	(8,'Anička','Karlová','2008','female','','','CZ',NULL,NULL,'0','2019-01-07 17:06:20','2019-01-22 15:14:22'),
	(9,'Luděk','Semrád','1997','male','ladislav.semrad@seznam.cz','','CZ',NULL,NULL,'0','2019-01-07 18:17:25','2019-01-07 18:19:37'),
	(18,'Pavel','Švadlena','1976','male','','','DK',NULL,NULL,'0','2019-01-22 17:44:11','2019-01-22 17:44:11'),
	(19,'Malenie','Picková','1996','male','','','DK',NULL,NULL,'0','2019-01-22 19:08:49','2019-01-22 19:08:49'),
	(20,'Bejbanek','Švadlena','1976','male','','','DZ',1,NULL,'0','2019-01-22 19:46:43','2019-01-22 19:46:43'),
	(21,'Valley','Miloš','1998','male','','','DK',NULL,NULL,'0','2019-01-23 10:27:03','2019-01-23 10:27:03'),
	(22,'Václav','Vadlejch','1992','male','','','DK',NULL,NULL,'0','2019-01-23 10:27:35','2019-01-23 10:27:35'),
	(23,'Vadlejch','Miroslav','1998','male','','','DJ',NULL,NULL,'0','2019-01-23 10:28:51','2019-01-23 10:28:51'),
	(24,'Mirslav','Kalousek','1975','male','','','DK',NULL,NULL,'0','2019-01-23 10:34:34','2019-01-23 10:34:34'),
	(25,'Tomáš','Novotný','1998','male','','','DJ',NULL,NULL,'0','2019-01-23 10:35:49','2019-01-23 10:35:49'),
	(26,'Martin','Bavor','2003','male',NULL,NULL,'DK',1,NULL,'0','2019-01-23 10:53:08','2019-03-05 21:41:46'),
	(27,'Miloš','Zeman','1940','male',NULL,NULL,'DO',NULL,NULL,'0','2019-01-23 11:16:24','2019-03-05 21:42:00'),
	(28,'Melani','Horníková','1998','male','','','DO',NULL,NULL,'0','2019-01-23 11:25:41','2019-01-23 11:25:41'),
	(29,'Melanie','Horníková','1995','male','','','DJ',NULL,NULL,'0','2019-01-23 11:26:50','2019-01-23 11:26:50'),
	(30,'Jan','Hintner','1996','male','','','DJ',NULL,NULL,'0','2019-01-23 11:31:45','2019-01-23 11:31:45'),
	(31,'Miroslav','Kalousek','1997','male','','','DJ',NULL,NULL,'0','2019-01-23 13:55:02','2019-01-23 13:55:02'),
	(32,'Bohumír','Sýkora','1987','male','','','DK',NULL,NULL,'0','2019-01-23 13:56:09','2019-01-23 13:56:09'),
	(33,'Marek','Jalůvka','1997','male','','','DK',NULL,NULL,'0','2019-01-23 22:06:06','2019-01-23 22:06:06'),
	(34,'Berenika','Držková','1996','female','','','DJ',NULL,NULL,'0','2019-01-23 22:10:05','2019-01-23 22:10:05'),
	(35,'Kateřina','Kubičiková','1996','female','','','TP',NULL,NULL,'0','2019-01-23 22:13:06','2019-01-23 22:13:06'),
	(36,'Bůžková','Katarzyna','1996','male','','','DM',NULL,NULL,'0','2019-01-23 22:25:37','2019-01-23 22:25:37'),
	(37,'Selina','Havrdová','2004','female','','','DJ',NULL,NULL,'0','2019-01-23 22:27:31','2019-01-23 22:27:31'),
	(38,'Hůlková','Pavlína','1996','female','','','DM',NULL,NULL,'0','2019-01-23 22:37:39','2019-01-23 22:37:39'),
	(39,'Lenka','Křivdová','1972','female','','','AD',1,NULL,'0','2019-01-23 22:52:16','2019-01-23 22:52:16'),
	(40,'Patrik','Horák','1998','male','','','DJ',NULL,NULL,'0','2019-01-24 10:27:27','2019-01-24 10:27:27'),
	(41,'Michal','Novotný','1998','male','','','TP',NULL,NULL,'0','2019-01-24 10:29:17','2019-01-24 10:29:17'),
	(42,'Pavel','Košárek','1997','male','','','DK',NULL,NULL,'0','2019-01-24 11:30:13','2019-01-24 11:30:13'),
	(43,'Karel','Jonák','1998','male','','','DJ',NULL,NULL,'0','2019-01-24 11:33:57','2019-01-24 11:33:57'),
	(44,'Jana','Peterová','1999','female','janapeterova@seznam.cz','','DO',NULL,NULL,'0','2019-02-04 23:14:40','2019-02-04 23:14:40'),
	(45,'Andrea','Mánková','1993','female','andreamankova@seznam.cz','','DJ',NULL,NULL,'0','2019-02-04 23:26:01','2019-02-04 23:26:01'),
	(46,'Karolína','Šiková','1996','female','sikovak@seznam.cz','','DJ',NULL,NULL,'0','2019-02-04 23:26:37','2019-02-04 23:26:37'),
	(47,'Michal','Novák','1993','male','michal@novak.cz','','FX',NULL,NULL,'0','2019-02-05 12:43:32','2019-02-05 12:43:32'),
	(48,'Pavel','Prokop','1980','male','pavel@prokop.cz','','DM',NULL,NULL,'0','2019-02-05 12:44:37','2019-02-05 12:44:37'),
	(49,'Anežka','Malá','1997','female','','','DM',NULL,NULL,'0','2019-02-05 12:45:28','2019-02-05 12:45:28'),
	(50,'Michal','Novotný','1993','male','','','DJ',NULL,NULL,'0','2019-02-05 12:46:56','2019-02-05 12:46:56'),
	(51,'Anička','Karlová','1996','male','MKrivda@outlook.com',NULL,'AZ',1,NULL,'0','2019-02-16 13:37:06','2019-02-16 13:37:06'),
	(52,'Jan','Šmolík','1998','male',NULL,NULL,'AO',NULL,NULL,'0','2019-02-16 17:31:41','2019-02-16 17:31:41'),
	(53,'Jaromír','Soukup','1997','male','soukup@prima.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 00:16:53','2019-02-17 00:16:53'),
	(61,'Karel','Sháněl','1998','male','jan.smolik@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-17 10:43:31','2019-02-17 10:43:31'),
	(62,'George','Lakatoš','1998','male','karlikovaL@penam.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 11:31:37','2019-02-17 11:31:37'),
	(63,'Petr','Jan','1986','male',NULL,NULL,'CZ',NULL,NULL,'0','2019-02-17 13:04:08','2019-02-17 13:04:08'),
	(64,'Kudla','Majer','1975','male',NULL,NULL,'CZ',NULL,NULL,'0','2019-02-17 13:04:41','2019-02-17 13:04:41'),
	(65,'Krteček','Borůvka','1996','male','krtek@seznam.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 14:09:22','2019-02-17 14:09:22'),
	(66,'Krteček','Borůvka','1996','male','krtek@seznam.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 14:09:44','2019-02-17 14:09:44'),
	(67,'Melanie','Voborníková','1998','male','vobornikova@seznam.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 14:10:24','2019-02-17 14:10:24'),
	(68,'Ahmed','Mohamed','1998','male','mohamed@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-17 14:16:17','2019-02-17 14:16:17'),
	(69,'Tomáš','Pipek','1998','male',NULL,NULL,'CZ',NULL,NULL,'0','2019-02-17 14:21:24','2019-02-17 14:21:24'),
	(70,'Lukáš','Voráček','1998','male','voracek@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-17 17:34:29','2019-02-17 17:34:29'),
	(71,'Lukáš','Voráček','1998','male','voracek@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-17 17:35:05','2019-02-17 17:35:05'),
	(72,'Lukáš','Voráček','1998','male','voracek@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-17 17:41:15','2019-02-17 17:41:15'),
	(73,'Jan','Jurášek','1987','male','jurasek@seznam.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 17:46:56','2019-02-17 17:46:56'),
	(74,'Jan','Jurášek','1987','male','jurasek@seznam.cz',NULL,'CZ',NULL,NULL,'0','2019-02-17 17:47:07','2019-02-17 17:47:07'),
	(75,'Ondřej','Vetchý','1975','male','vetchy@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-17 17:48:11','2019-02-17 17:48:11'),
	(76,'Veronika','Chaloupková','1998','female','veronika@chaloupkova.cz','+420765987098','CZ',1,NULL,'0','2019-02-18 11:32:37','2019-02-18 11:32:37'),
	(77,'Gizela','Novotná','1965','female',NULL,NULL,'CZ',NULL,NULL,'0','2019-02-18 11:35:07','2019-02-18 11:35:07'),
	(78,'Elizabeth','Procházková','1998','female','elizabeth@gmail.com',NULL,'CZ',NULL,NULL,'0','2019-02-18 11:37:24','2019-02-18 11:37:24'),
	(79,'Adam','Hájek','1993','male','adam@hajek.com',NULL,'CZ',NULL,NULL,'0','2019-02-18 11:38:25','2019-02-18 11:38:25'),
	(80,'Vojtěch','Kettner','1996','male','vojta@kettneru.com',NULL,'CZ',NULL,NULL,'0','2019-02-18 11:41:19','2019-02-18 11:41:19'),
	(81,'Lukáš','Kettner','1993','male',NULL,NULL,'CZ',NULL,NULL,'0','2019-02-18 11:41:46','2019-02-18 11:41:46'),
	(82,'Petr','Sladký','1956','male',NULL,NULL,'CZ',NULL,NULL,'0','2019-02-18 11:42:28','2019-02-18 11:42:28'),
	(83,'Kudla','Sirová','1956','male',NULL,NULL,'AD',NULL,NULL,'0','2019-02-18 11:42:50','2019-02-18 12:39:50'),
	(84,'Caroline','Smith','1998','female',NULL,NULL,'AD',NULL,NULL,'0','2019-02-18 11:43:37','2019-02-18 12:38:44');

/*!40000 ALTER TABLE `runner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table starttime
# ------------------------------------------------------------

DROP TABLE IF EXISTS `starttime`;

CREATE TABLE `starttime` (
  `stime_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `edition_ID` int(10) unsigned NOT NULL,
  `category_ID` int(10) unsigned NOT NULL,
  `start_nr` char(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_ID` int(10) unsigned DEFAULT NULL,
  `stime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stime_ID`),
  KEY `starttime_tag_id_foreign` (`tag_ID`),
  KEY `starttime_start_nr_index` (`start_nr`),
  KEY `starttime_edition_id_foreign` (`edition_ID`),
  KEY `starttime_category_id_foreign` (`category_ID`),
  CONSTRAINT `starttime_category_id_foreign` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`),
  CONSTRAINT `starttime_edition_id_foreign` FOREIGN KEY (`edition_ID`) REFERENCES `raceedition` (`edition_ID`),
  CONSTRAINT `starttime_tag_id_foreign` FOREIGN KEY (`tag_ID`) REFERENCES `tag` (`tag_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records start times for the race.';

LOCK TABLES `starttime` WRITE;
/*!40000 ALTER TABLE `starttime` DISABLE KEYS */;

INSERT INTO `starttime` (`stime_ID`, `edition_ID`, `category_ID`, `start_nr`, `tag_ID`, `stime`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'1',1,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(2,1,1,'2',2,'2018-12-02 10:15:02','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(3,1,1,'3',3,'2018-12-02 10:15:04','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(4,1,1,'4',4,'2018-12-02 10:15:06','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(5,1,1,'5',5,'2018-12-02 10:15:08','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(6,1,1,'6',7,'2018-12-02 10:15:10','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(7,1,1,'7',9,'2018-12-02 10:15:12','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(8,1,1,'8',11,'2018-12-02 10:15:14','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(9,1,1,'9',12,'2018-12-02 10:15:16','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(10,1,1,'10',13,'2018-12-02 10:15:18','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(11,1,1,'11',14,'2018-12-02 10:15:20','2019-03-03 11:51:30','2019-03-03 11:51:32'),
	(12,1,1,'12',NULL,'2018-12-02 10:15:22','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(13,1,1,'13',NULL,'2018-12-02 10:15:24','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(14,1,1,'14',NULL,'2018-12-02 10:15:26','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(15,1,1,'15',NULL,'2018-12-02 10:15:28','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(16,1,1,'16',NULL,'2018-12-02 10:15:30','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(17,1,1,'17',NULL,'2018-12-02 10:15:32','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(18,1,1,'18',NULL,'2018-12-02 10:15:34','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(19,1,1,'19',NULL,'2018-12-02 10:15:36','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(20,1,1,'20',NULL,'2018-12-02 10:15:38','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(21,1,1,'21',NULL,'2018-12-02 10:15:40','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(22,1,1,'22',NULL,'2018-12-02 10:15:42','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(23,1,1,'23',NULL,'2018-12-02 10:15:44','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(24,1,1,'24',NULL,'2018-12-02 10:15:46','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(25,1,1,'25',NULL,'2018-12-02 10:15:48','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(26,1,1,'26',NULL,'2018-12-02 10:15:50','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(27,1,1,'27',NULL,'2018-12-02 10:15:52','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(28,1,1,'28',NULL,'2018-12-02 10:15:54','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(29,1,1,'29',NULL,'2018-12-02 10:15:56','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(30,1,1,'30',NULL,'2018-12-02 10:15:58','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(31,1,1,'31',NULL,'2018-12-02 10:16:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(32,1,1,'32',NULL,'2018-12-02 10:16:02','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(33,1,1,'33',NULL,'2018-12-02 10:16:04','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(34,1,1,'34',NULL,'2018-12-02 10:16:06','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(35,1,1,'35',NULL,'2018-12-02 10:16:08','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(36,1,1,'36',NULL,'2018-12-02 10:16:10','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(37,1,1,'37',NULL,'2018-12-02 10:16:12','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(38,1,1,'38',NULL,'2018-12-02 10:16:14','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(39,1,1,'39',NULL,'2018-12-02 10:16:16','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(40,1,1,'40',NULL,'2018-12-02 10:16:18','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(41,1,1,'41',NULL,'2018-12-02 10:16:20','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(42,1,1,'42',NULL,'2018-12-02 10:16:22','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(43,1,1,'43',NULL,'2018-12-02 10:16:24','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(44,1,1,'44',NULL,'2018-12-02 10:16:26','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(45,1,1,'45',NULL,'2018-12-02 10:16:28','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(46,1,1,'46',NULL,'2018-12-02 10:16:30','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(47,1,2,'47',NULL,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(48,1,2,'48',NULL,'2018-12-02 10:15:02','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(49,1,2,'49',NULL,'2018-12-02 10:15:04','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(50,1,2,'50',NULL,'2018-12-02 10:15:06','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(51,1,2,'51',NULL,'2018-12-02 10:15:08','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(52,1,2,'52',NULL,'2018-12-02 10:15:10','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(53,1,2,'53',NULL,'2018-12-02 10:15:12','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(54,1,2,'54',NULL,'2018-12-02 10:15:14','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(55,1,2,'55',NULL,'2018-12-02 10:15:16','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(56,1,2,'56',NULL,'2018-12-02 10:15:18','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(57,1,2,'57',NULL,'2018-12-02 10:15:20','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(58,1,3,'58',NULL,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(59,1,3,'59',NULL,'2018-12-02 10:15:01','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(60,1,3,'60',NULL,'2018-12-02 10:15:02','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(61,1,4,'61',NULL,'2012-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(62,1,5,'62',NULL,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(63,1,6,'63',NULL,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(64,1,6,'64',NULL,'2018-12-02 10:15:01','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(65,1,6,'65',NULL,'2018-12-02 10:15:02','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(66,1,7,'66',NULL,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(67,1,7,'67',NULL,'2018-12-02 10:15:01','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(68,1,7,'68',NULL,'2018-12-02 10:15:02','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(69,1,8,'69',NULL,'2018-12-02 10:15:00','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(70,1,8,'70',NULL,'2018-12-02 10:15:01','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(71,1,8,'71',NULL,'2018-12-02 10:15:02','2019-03-03 11:51:30','2019-03-03 11:51:30'),
	(72,1,8,'72',NULL,'2018-12-02 10:15:03','2019-03-03 11:51:30','2019-03-03 11:51:30');

/*!40000 ALTER TABLE `starttime` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `tag_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EPC` bigint(20) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tag_ID`),
  UNIQUE KEY `tag_epc_unique` (`EPC`),
  KEY `tag_epc_index` (`EPC`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records registered RFID tags.';

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;

INSERT INTO `tag` (`tag_ID`, `EPC`, `active`, `created_at`, `updated_at`)
VALUES
	(1,10223847,1,'2018-11-05 13:09:00','2018-11-05 13:09:00'),
	(2,12345,1,'2018-11-06 16:04:05','2018-11-06 16:04:05'),
	(3,8787,1,'2018-11-06 16:05:37','2018-11-06 16:05:37'),
	(4,12346,1,'2018-11-06 16:07:17','2018-11-06 16:07:17'),
	(5,78237823,1,'2018-11-06 16:08:45','2018-11-06 16:08:45'),
	(7,27456,1,'2018-11-06 16:13:00','2018-11-06 16:13:00'),
	(9,493535,1,'2018-11-06 16:13:50','2018-11-06 16:13:50'),
	(11,93428372,1,'2018-11-06 16:15:31','2018-11-06 16:15:31'),
	(12,85983535,1,'2018-11-06 19:59:00','2018-11-06 19:59:00'),
	(13,583943,1,'2018-11-06 19:59:06','2018-11-06 19:59:06'),
	(14,38993854,1,'2018-11-06 19:59:12','2018-11-06 19:59:12');

/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `userrole_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_ID` int(10) unsigned NOT NULL,
  `role_ID` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userrole_ID`),
  KEY `user_role_user_id_foreign` (`user_ID`),
  KEY `user_role_role_id_foreign` (`role_ID`),
  CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_ID`) REFERENCES `role` (`role_ID`),
  CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_ID`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;

INSERT INTO `user_role` (`userrole_ID`, `user_ID`, `role_ID`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'2019-02-07 17:22:44','2019-02-07 17:22:44');

/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` blob DEFAULT NULL,
  `google_ID` char(21) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `lastlogin` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table records users of the application.';

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `name`, `email`, `password`, `remember_token`, `hash`, `avatar`, `google_ID`, `active`, `lastlogin`, `created_at`, `updated_at`)
VALUES
	(1,'martin.krivda','Martin','Křivda',NULL,'MKrivda@outlook.com','$2y$10$QP9nwVvNGqZNwJDR2XlfneTnm2VSfwd55h0r7mwVS9AqLBymMkKFu','K35i0tVO8FaHwfnT09SCsCTNJUfBLqZgPBSdCja5JfEezfbrwpWAWnAHh2W1','bc6dc48b743dc5d013b1abaebd2faed2',NULL,'107613669691724355107',1,'2019-03-07 08:54:28','2019-01-02 14:14:55','2019-03-07 08:54:28'),
	(2,'jan.smolik','Jan','Šmolík',NULL,'jan.smolik@gmail.com','$2y$10$neZFiEUO.kS2Ybc4Tg8EU.KkJ5MrZ4dvwmjXdVrbxwbDyOb.TSY0.',NULL,'94f6d7e04a4d452035300f18b984988c',NULL,NULL,0,'2018-12-30 15:16:25','2018-12-30 14:14:51','2018-12-30 14:14:51');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
