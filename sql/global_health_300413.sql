-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 30, 2013 at 08:36 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `global_health`
--

-- --------------------------------------------------------

--
-- Table structure for table `gh_country`
--

DROP TABLE IF EXISTS `gh_country`;
CREATE TABLE IF NOT EXISTS `gh_country` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) NOT NULL DEFAULT '',
  `country_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `gh_country`
--

INSERT INTO `gh_country` VALUES(1, 'Australia', '61');
INSERT INTO `gh_country` VALUES(2, 'Austria', '43');
INSERT INTO `gh_country` VALUES(3, 'Bahrain', '973');
INSERT INTO `gh_country` VALUES(4, 'Belgium', '32');
INSERT INTO `gh_country` VALUES(5, 'Brazil', '55');
INSERT INTO `gh_country` VALUES(6, 'Canada', '1');
INSERT INTO `gh_country` VALUES(7, 'Czech Republic', '420');
INSERT INTO `gh_country` VALUES(8, 'Denmark', '45');
INSERT INTO `gh_country` VALUES(9, 'Egypt', '20');
INSERT INTO `gh_country` VALUES(10, 'England', '44');
INSERT INTO `gh_country` VALUES(11, 'Finland', '358');
INSERT INTO `gh_country` VALUES(12, 'France', '33');
INSERT INTO `gh_country` VALUES(13, 'Germany', '49');
INSERT INTO `gh_country` VALUES(14, 'Gibraltar', '350');
INSERT INTO `gh_country` VALUES(15, 'Greece', '30');
INSERT INTO `gh_country` VALUES(16, 'Hong Kong', '852');
INSERT INTO `gh_country` VALUES(17, 'Hungary', '36');
INSERT INTO `gh_country` VALUES(18, 'India', '91');
INSERT INTO `gh_country` VALUES(19, 'Iran', '98');
INSERT INTO `gh_country` VALUES(20, 'Iraq', '964');
INSERT INTO `gh_country` VALUES(21, 'Ireland', '353');
INSERT INTO `gh_country` VALUES(22, 'Israel', '972');
INSERT INTO `gh_country` VALUES(23, 'Italy', '39');
INSERT INTO `gh_country` VALUES(24, 'Japan', '81');
INSERT INTO `gh_country` VALUES(25, 'Kuwait', '965');
INSERT INTO `gh_country` VALUES(26, 'Latvia', '371');
INSERT INTO `gh_country` VALUES(27, 'Luxembourg', '352');
INSERT INTO `gh_country` VALUES(28, 'Macedonia', '389');
INSERT INTO `gh_country` VALUES(29, 'Malta', '356');
INSERT INTO `gh_country` VALUES(30, 'Mexico', '52');
INSERT INTO `gh_country` VALUES(31, 'Monaco', '3393');
INSERT INTO `gh_country` VALUES(32, 'Morocco', '212');
INSERT INTO `gh_country` VALUES(33, 'N Ireland', '44');
INSERT INTO `gh_country` VALUES(34, 'Netherlands', '31');
INSERT INTO `gh_country` VALUES(35, 'New Zealand', '64');
INSERT INTO `gh_country` VALUES(36, 'Norway', '47');
INSERT INTO `gh_country` VALUES(37, 'Poland', '48');
INSERT INTO `gh_country` VALUES(38, 'Portugal', '351');
INSERT INTO `gh_country` VALUES(39, 'Russia', '7');
INSERT INTO `gh_country` VALUES(40, 'Saudi Arabia', '966');
INSERT INTO `gh_country` VALUES(41, 'Scotland', '44');
INSERT INTO `gh_country` VALUES(42, 'Singapore', '65');
INSERT INTO `gh_country` VALUES(43, 'Slovakia', '421');
INSERT INTO `gh_country` VALUES(44, 'South Africa', '27');
INSERT INTO `gh_country` VALUES(45, 'Spain', '34');
INSERT INTO `gh_country` VALUES(46, 'Sweden', '46');
INSERT INTO `gh_country` VALUES(47, 'Switzerland', '41');
INSERT INTO `gh_country` VALUES(48, 'Taiwan', '886');
INSERT INTO `gh_country` VALUES(49, 'Trinidad', '1809');
INSERT INTO `gh_country` VALUES(50, 'Tunisia', '216');
INSERT INTO `gh_country` VALUES(51, 'Turkey', '90');
INSERT INTO `gh_country` VALUES(52, 'UAE', '971');
INSERT INTO `gh_country` VALUES(53, 'USA', '1');
INSERT INTO `gh_country` VALUES(54, 'Venezuela', '58');
INSERT INTO `gh_country` VALUES(55, 'Wales', '44');
INSERT INTO `gh_country` VALUES(56, 'Yugoslavia', '38');
INSERT INTO `gh_country` VALUES(57, 'Zimbabwe', '263');

-- --------------------------------------------------------

--
-- Table structure for table `gh_groups`
--

DROP TABLE IF EXISTS `gh_groups`;
CREATE TABLE IF NOT EXISTS `gh_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gh_groups`
--

INSERT INTO `gh_groups` VALUES(1, 'admin', '<p>User admin: create, edit, delete.</p>\r\n<p>Resource admin: create, edit, delete</p>\r\n<p>News admin');
INSERT INTO `gh_groups` VALUES(2, 'members', 'Resource view only - no write rights');
INSERT INTO `gh_groups` VALUES(3, 'contributor', '<p>Resource admin: create, edit</p>');

-- --------------------------------------------------------

--
-- Table structure for table `gh_institution`
--

DROP TABLE IF EXISTS `gh_institution`;
CREATE TABLE IF NOT EXISTS `gh_institution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `URL` varchar(255) NOT NULL DEFAULT '#',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Add1` varchar(255) DEFAULT NULL,
  `Add2` varchar(255) DEFAULT NULL,
  `Town` varchar(255) DEFAULT NULL,
  `County` varchar(255) DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL,
  `country_num` smallint(5) unsigned NOT NULL DEFAULT '10',
  `Tel` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `Institution type` varchar(50) DEFAULT NULL,
  `inst_type` smallint(5) unsigned NOT NULL COMMENT 'Foreign key from institution_type',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Name` (`Name`),
  KEY `inst_type` (`inst_type`),
  KEY `country_num` (`country_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gh_institution_type`
--

DROP TABLE IF EXISTS `gh_institution_type`;
CREATE TABLE IF NOT EXISTS `gh_institution_type` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Names and descriptions of institution types (eg UKHE, UKFE)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gh_keyword`
--

DROP TABLE IF EXISTS `gh_keyword`;
CREATE TABLE IF NOT EXISTS `gh_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Keyword/phrase used to describe resources',
  `acronym_expansion` varchar(255) DEFAULT NULL COMMENT 'If keyword is an acronym expand here.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Key words/phrases to tag resources' AUTO_INCREMENT=27 ;

--
-- Dumping data for table `gh_keyword`
--

INSERT INTO `gh_keyword` VALUES(1, 'Nutrition', NULL);
INSERT INTO `gh_keyword` VALUES(2, 'Sub-saharan Africa', NULL);
INSERT INTO `gh_keyword` VALUES(3, 'Child poverty', NULL);
INSERT INTO `gh_keyword` VALUES(4, 'Undernutrition', NULL);
INSERT INTO `gh_keyword` VALUES(5, 'Health inequalities', NULL);
INSERT INTO `gh_keyword` VALUES(6, 'Poverty', NULL);
INSERT INTO `gh_keyword` VALUES(7, 'Inequality', NULL);
INSERT INTO `gh_keyword` VALUES(8, 'Obesity', NULL);
INSERT INTO `gh_keyword` VALUES(9, 'Diarrhoea', NULL);
INSERT INTO `gh_keyword` VALUES(10, 'Pandemic.', NULL);
INSERT INTO `gh_keyword` VALUES(11, 'urbanisation', NULL);
INSERT INTO `gh_keyword` VALUES(12, 'sanitation', NULL);
INSERT INTO `gh_keyword` VALUES(13, 'housing', NULL);
INSERT INTO `gh_keyword` VALUES(14, 'gender', NULL);
INSERT INTO `gh_keyword` VALUES(16, 'slum', NULL);
INSERT INTO `gh_keyword` VALUES(17, 'infrastructure', NULL);
INSERT INTO `gh_keyword` VALUES(18, 'sociology', NULL);
INSERT INTO `gh_keyword` VALUES(19, 'child mortality', NULL);
INSERT INTO `gh_keyword` VALUES(20, 'demography', NULL);
INSERT INTO `gh_keyword` VALUES(21, 'india', NULL);
INSERT INTO `gh_keyword` VALUES(22, 'bangladesh', NULL);
INSERT INTO `gh_keyword` VALUES(23, 'cambodia', NULL);
INSERT INTO `gh_keyword` VALUES(24, 'service users', NULL);
INSERT INTO `gh_keyword` VALUES(25, 'service design', NULL);
INSERT INTO `gh_keyword` VALUES(26, 'NGO', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gh_key_area`
--

DROP TABLE IF EXISTS `gh_key_area`;
CREATE TABLE IF NOT EXISTS `gh_key_area` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `title` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Top-level categories above subjects' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `gh_key_area`
--

INSERT INTO `gh_key_area` VALUES(1, 'Globalisation, health and change', NULL);
INSERT INTO `gh_key_area` VALUES(2, 'Global health topics', '');
INSERT INTO `gh_key_area` VALUES(3, 'Health professions in a global context ', NULL);
INSERT INTO `gh_key_area` VALUES(4, 'Overseas electives', NULL);
INSERT INTO `gh_key_area` VALUES(5, 'Teaching global health', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gh_login_attempts`
--

DROP TABLE IF EXISTS `gh_login_attempts`;
CREATE TABLE IF NOT EXISTS `gh_login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gh_news`
--

DROP TABLE IF EXISTS `gh_news`;
CREATE TABLE IF NOT EXISTS `gh_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `posted` datetime NOT NULL COMMENT 'Date and time article posted',
  `edited` datetime NOT NULL COMMENT 'Date and time article edited',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `gh_news`
--

INSERT INTO `gh_news` VALUES(1, 'CALL@Hull site redesign', '<p>The <a href="http://www.fredriley.org.uk/callhull/">CALL@Hull</a> site has been radically redesigned, to bring its interface into the 21st century and make it easier to use and maintain. Content has been ''rationalised'', in particular in the General and Multilingual sections, but has otherwise remained the same. It also now has social networking presences on Facebook and Twitter. Added functionality includes a search engine and ''suggest a site'' form. Those interested in the technical details of the redesign can read the technical notes Redirections have been put in place so as not to break existing links. Note that the RSS feed has also been moved - the link in the footer has the up to date feed, so please amend your entry in your newsreader. I welcome comments on the redesign, good, bad or indifferent, via the contact form or by email. The main future development, when/if time allows, will be the moving of the collection into a proper resource repository and dynamic website.</p>', '2013-04-01 12:30:31', '2013-04-05 22:05:07');
INSERT INTO `gh_news` VALUES(5, 'CALL@Hull goes dynamic', 'This site has been converted from a static site, comprising HTML files, to a ''dynamic'' site, driven by server-side scripts using the PHP Codeigniter framework. Users won''t notice any substantial difference in design and functioning, although URLs will be snappier (eg languages/french rather than languages/french.html). However, the site will be easier to maintain and to scale, and will be ready to become a fully database-driven site when I get the time to put together a proper repository. Watch this space, and of course the Facebook and Twitter feeds. ', '2013-04-03 00:00:00', '2013-04-05 00:00:00');
INSERT INTO `gh_news` VALUES(6, 'Hamster herding', '<p>Hamsters are notoriously difficult to herd, being solitary creatures</p>', '0000-00-00 00:00:00', '2013-04-05 22:03:48');
INSERT INTO `gh_news` VALUES(7, 'Gerbil running', '<p>Loads of cute little gerbils around the place. <strong>Yee</strong>-<em>hah</em>!</p>', '2013-04-05 21:56:47', '2013-04-05 21:56:47');

-- --------------------------------------------------------

--
-- Table structure for table `gh_origin`
--

DROP TABLE IF EXISTS `gh_origin`;
CREATE TABLE IF NOT EXISTS `gh_origin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Origin of a resource' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `gh_origin`
--

INSERT INTO `gh_origin` VALUES(1, 'External source', 'Any origin outside the University of Nottingham');
INSERT INTO `gh_origin` VALUES(2, 'Clinical Skills Group', NULL);
INSERT INTO `gh_origin` VALUES(3, 'Practice Learning Team', NULL);
INSERT INTO `gh_origin` VALUES(4, 'SoN E-Learning Team', NULL);
INSERT INTO `gh_origin` VALUES(5, 'RLO-CETL', NULL);
INSERT INTO `gh_origin` VALUES(6, 'UCEL', NULL);
INSERT INTO `gh_origin` VALUES(7, 'UoN (non-Nursing)', 'University of Nottingham in general, outside SoN');
INSERT INTO `gh_origin` VALUES(8, 'SNMP (general)', 'Resource originates from the School of NMP in general, not any particular source.');
INSERT INTO `gh_origin` VALUES(10, 'Clinicalskills.net', '');

-- --------------------------------------------------------

--
-- Table structure for table `gh_resource`
--

DROP TABLE IF EXISTS `gh_resource`;
CREATE TABLE IF NOT EXISTS `gh_resource` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) DEFAULT NULL COMMENT 'Author(s) of the resource',
  `description` text,
  `modified` date DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `url` varchar(255) NOT NULL DEFAULT '',
  `source` int(11) NOT NULL DEFAULT '1',
  `rights` text,
  `ispartof` varchar(255) DEFAULT NULL,
  `metadata_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metadata_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metadata_author` smallint(6) NOT NULL DEFAULT '0',
  `restricted` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Resource restricted, eg for peer review',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Resource visible to world',
  `Notes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `source` (`source`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 51200 kB' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `gh_resource`
--

INSERT INTO `gh_resource` VALUES(1, 'Global tobacco control', 'Samet, J', '<p>Detailed and lengthy slide sets for 11 lectures including: The tobacco pandemic: An historical overview; Tobacco addiction by design: implications for public health and policy; The modern tobacco industry; National tobacco control strategies; Secondhand smoke; Tobacco control economics; Tracking tobacco industry advertising, marketing and promotion; Harm reduction; Cessastion; and The Framework Convention on Tobacco Control. These materials have been made available on an open source website but are subject to copywrite controls.</p>', NULL, 1, 'http://ocw.jhsph.edu/index.cfm/go/viewCourse/course/GlobalTobaccoControl/coursePage/lectureNotes/', 1, '', NULL, '2013-04-28 16:05:37', '2013-04-28 16:05:37', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(2, 'Health care and equity in India', 'Balarajan et al', 'Examines key challenges for the equity of service provision and access according to abiitity to pay and geography. Includes data on poverty, cost of individual health care expenditure, immunisation and child mortality in graph form.   Free registration is necessary for access to this article.  This paper is part of a Lancet series on India.', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(10)61894-6/fulltext', 1, '', NULL, '2013-01-31 23:59:57', '2013-01-31 23:59:57', 1, 0, 1, '');
INSERT INTO `gh_resource` VALUES(3, 'Diabetes saps health and wealth from China''s rise', 'Alcorn et al', 'This report examines the rise in diabetes fuelled by China''s economic change.', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60963-5/fulltext', 1, '', NULL, '2013-02-01 00:03:34', '2013-02-01 00:03:34', 1, 0, 1, '');
INSERT INTO `gh_resource` VALUES(4, 'Feeding cities', 'Brieger, W', 'Explores the various perspectives of global health held by different generations.', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec8_Brieger.pdf', 1, '', NULL, '2013-02-01 00:07:23', '2013-02-01 00:07:23', 1, 0, 1, '');
INSERT INTO `gh_resource` VALUES(5, 'The Millennium Development Goals: a cross-sectoral analysis and principles for goal setting after 2015', 'Waage et al', 'Reports on analysis by different sectoral experts on MDGs.  Also provides a history to the MDGs, progress, tables on obsticles to delivery and on reinforcing links different areas of social progress. Free registration is necessary to access this article.', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(10)61196-8/fulltext', 1, '', NULL, '2013-02-01 00:15:05', '2013-02-01 00:15:05', 1, 0, 1, '');
INSERT INTO `gh_resource` VALUES(7, 'Challenges in ameliorating hunger while preventing obesity', 'Gordon-Larsen et al', '<p>Examines trends in child nutrition in 141 countries. Despite substantial reductions in the prevalence of moderate and severe stunting and underweight in developing countries, about 30% of children younger than 5 years were moderately or severely stunted and 19% were moderately or severely underweight in 2011. For all countries, the predicted likelihood of achievement of the Millennium Development Goal (MDG) of halving hunger by 2015 was estimated at less than 5%. Access to Lancet subscribers only.</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60909-X/fulltext', 1, '', NULL, '2013-04-22 22:12:59', '2013-04-22 22:12:59', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(8, 'Hemorrhagic Fever Outbreak Investigation', 'Abdallah, S', 'Based on a kenyan case study this slide set provides information on the management and assessment of epidemics.', NULL, 26, 'http://ocw.jhsph.edu/courses/RefugeeHealthCare/PDFs/Lecture4.pdf', 1, '', NULL, '2013-02-01 00:34:25', '2013-02-01 00:34:25', 1, 0, 1, '');
INSERT INTO `gh_resource` VALUES(9, 'World Clock', '', 'Online calculator providing global statistics on population, mortality & morbidity, food consumption, energy consumption and environmental impact statistics.  Site also includes a life clock demonstrating behaviours and other factors that affect longevity.  This is an excellent test that entry level students can use to assess their own lives and assuming the identity of others.', NULL, 1, 'http://www.poodwaddle.com/clocks/worldclock/', 1, '', NULL, '2013-03-18 13:49:07', '2013-03-18 13:49:07', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(11, 'Global urbanisation: trends, patterns, determinants, and impacts', '', 'Over 40 slides examining the demography, causes and particular challenges of urbanisation in less developed countries.  ', NULL, 1, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec2_Baqui.pdf', 1, '', NULL, '2013-03-17 18:45:53', '2013-03-17 18:45:53', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(12, 'The urban environment and health in developing countries', 'Baqui, A et al', 'Over 40 slides examining the impact of rapid urbanisation, the health hazards related to urban physical environmental changes and the extent of inequity in physical environment and health within urban areas.', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec3_Baqui.pdf', 1, '', NULL, '2013-03-17 18:51:30', '2013-03-17 18:51:30', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(13, 'The burden of urban ill-health from road transport in developing countries', '', 'A long and detailed slide set examining the relationship between road transport and health in less developed nations.  Covering: air and noise pollution, road traffic accidents and the nature and distribution of road traffic induced morbidity.', NULL, 1, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec5_Hyder.pdf', 1, '', NULL, '2013-03-17 18:58:15', '2013-03-17 18:58:15', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(14, 'Urbanisation and the epidemiology of infectious diseases', 'Moss, W', 'Over 70 slides examining rates and types of infection in urban settings with a detailed focus on HIV, malaria, measles and yellow fever.', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec7_Moss.pdf', 1, '', NULL, '2013-03-17 19:04:44', '2013-03-17 19:04:44', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(15, 'Urban health in India', 'Moss, W', 'A long (90 slides) detailed examination of the features of urban health via two Indian case studies.  Includes: population trends, rural versus urban health provision, child mortality, and infrastructure issues and slum ''invisibility''.  Case studies include Agra and Indore.', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec10a_Agarwal.pdf', 1, '', NULL, '2013-03-17 19:08:00', '2013-03-17 19:08:00', 3, 0, 1, '');
INSERT INTO `gh_resource` VALUES(16, 'Selected strategies to improve access to and quality of urban primary health care', 'Moss, W', '<p>Over 60 slides on methods of improving health service mix and quality using Bangladeshi and Cambodian case studies. Includes: an outline of operation research methods, needs assessment, NGO versus government provision, and health care expenditure.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec11_Baqui.pdf', 1, '', NULL, '2013-04-22 15:53:40', '2013-04-22 15:53:40', 8, 0, 1, '');
INSERT INTO `gh_resource` VALUES(17, 'Lessons from developing nations on improving healthcare', '', '<p>Demonstrates, using examples from Russia and Peru, that health improvement need not involve increased use of resources.&nbsp; If not accessed via the link provided, subscription is usually needed for access to BMJ articles.</p>', NULL, 1, 'http://www.globalhealth.arizona.edu/sites/globalhealth.arizona.edu/files/Lessons_from_developing_nations.pdf', 1, '', NULL, '2013-04-22 22:22:34', '2013-04-22 22:22:34', 3, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `gh_resource_keyword`
--

DROP TABLE IF EXISTS `gh_resource_keyword`;
CREATE TABLE IF NOT EXISTS `gh_resource_keyword` (
  `resource_id` int(10) unsigned NOT NULL DEFAULT '0',
  `keyword_id` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `idx_resource_id` (`resource_id`),
  KEY `idx_keyword_num` (`keyword_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Junction table for keywords associated with resources.; Inno';

--
-- Dumping data for table `gh_resource_keyword`
--

INSERT INTO `gh_resource_keyword` VALUES(8, 9);
INSERT INTO `gh_resource_keyword` VALUES(8, 10);
INSERT INTO `gh_resource_keyword` VALUES(8, 6);
INSERT INTO `gh_resource_keyword` VALUES(12, 11);
INSERT INTO `gh_resource_keyword` VALUES(12, 12);
INSERT INTO `gh_resource_keyword` VALUES(12, 13);
INSERT INTO `gh_resource_keyword` VALUES(12, 14);
INSERT INTO `gh_resource_keyword` VALUES(15, 6);
INSERT INTO `gh_resource_keyword` VALUES(15, 14);
INSERT INTO `gh_resource_keyword` VALUES(15, 16);
INSERT INTO `gh_resource_keyword` VALUES(15, 17);
INSERT INTO `gh_resource_keyword` VALUES(15, 18);
INSERT INTO `gh_resource_keyword` VALUES(15, 19);
INSERT INTO `gh_resource_keyword` VALUES(15, 20);
INSERT INTO `gh_resource_keyword` VALUES(15, 21);
INSERT INTO `gh_resource_keyword` VALUES(16, 22);
INSERT INTO `gh_resource_keyword` VALUES(16, 23);
INSERT INTO `gh_resource_keyword` VALUES(16, 6);
INSERT INTO `gh_resource_keyword` VALUES(16, 24);
INSERT INTO `gh_resource_keyword` VALUES(16, 25);
INSERT INTO `gh_resource_keyword` VALUES(16, 26);

-- --------------------------------------------------------

--
-- Table structure for table `gh_resource_subject`
--

DROP TABLE IF EXISTS `gh_resource_subject`;
CREATE TABLE IF NOT EXISTS `gh_resource_subject` (
  `resource_id` int(10) unsigned NOT NULL DEFAULT '0',
  `subject_id` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `idx_resource` (`resource_id`),
  KEY `idx_subject` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Junction table between RESOURCE and SUBJECT';

--
-- Dumping data for table `gh_resource_subject`
--

INSERT INTO `gh_resource_subject` VALUES(8, 44);
INSERT INTO `gh_resource_subject` VALUES(7, 42);
INSERT INTO `gh_resource_subject` VALUES(9, 54);
INSERT INTO `gh_resource_subject` VALUES(12, 38);
INSERT INTO `gh_resource_subject` VALUES(13, 38);
INSERT INTO `gh_resource_subject` VALUES(16, 38);
INSERT INTO `gh_resource_subject` VALUES(17, 53);
INSERT INTO `gh_resource_subject` VALUES(1, 43);

-- --------------------------------------------------------

--
-- Table structure for table `gh_subject`
--

DROP TABLE IF EXISTS `gh_subject`;
CREATE TABLE IF NOT EXISTS `gh_subject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` text COMMENT 'Description of subject category',
  `key_area` tinyint(3) unsigned DEFAULT NULL COMMENT 'Foreign key from key_area table (top-level category)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `key_area` (`key_area`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `gh_subject`
--

INSERT INTO `gh_subject` VALUES(37, 'Research', NULL, NULL);
INSERT INTO `gh_subject` VALUES(38, 'Urbanisation', NULL, NULL);
INSERT INTO `gh_subject` VALUES(39, 'Climate change', NULL, 1);
INSERT INTO `gh_subject` VALUES(40, 'Political drivers', NULL, NULL);
INSERT INTO `gh_subject` VALUES(41, 'Economic drivers', 'policy, trade, aid and health', 1);
INSERT INTO `gh_subject` VALUES(42, 'Key policy targets', NULL, NULL);
INSERT INTO `gh_subject` VALUES(43, 'Globalisation', NULL, NULL);
INSERT INTO `gh_subject` VALUES(44, 'Communicable disease', '', 2);
INSERT INTO `gh_subject` VALUES(45, 'Pandemics', NULL, 1);
INSERT INTO `gh_subject` VALUES(46, 'Non-communicable disease', NULL, NULL);
INSERT INTO `gh_subject` VALUES(47, 'Poverty and inequality', NULL, NULL);
INSERT INTO `gh_subject` VALUES(48, 'Nursing', NULL, NULL);
INSERT INTO `gh_subject` VALUES(49, 'Teaching', NULL, NULL);
INSERT INTO `gh_subject` VALUES(50, 'Trade agreements', NULL, NULL);
INSERT INTO `gh_subject` VALUES(51, 'Health professionals migration', NULL, 1);
INSERT INTO `gh_subject` VALUES(52, 'Population change', NULL, NULL);
INSERT INTO `gh_subject` VALUES(53, 'Sustainable development', NULL, NULL);
INSERT INTO `gh_subject` VALUES(54, 'Introductions to global health', NULL, NULL);
INSERT INTO `gh_subject` VALUES(55, 'Global health issues', 'demographic & epidemiological transitions; trends and changing patterns of disease, related policies', 2);
INSERT INTO `gh_subject` VALUES(56, 'Determinants of health', 'poverty, equity and inequalities; related policies', 2);
INSERT INTO `gh_subject` VALUES(57, 'Millennium Development Goals', 'issues, policies, nursing practices, outcomes); i.e. primary health care and communicable diseases', 2);
INSERT INTO `gh_subject` VALUES(58, 'Non-communicable diseases', 'issues, policies, nursing practices, outcomes; i.e. chronic conditions', 2);
INSERT INTO `gh_subject` VALUES(59, 'Theories of globalisation', NULL, 1);
INSERT INTO `gh_subject` VALUES(60, 'Population migration', 'Population migration and refugees', 1);
INSERT INTO `gh_subject` VALUES(61, 'New technologies', 'New technologies and health', 1);
INSERT INTO `gh_subject` VALUES(62, 'Placements', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gh_type`
--

DROP TABLE IF EXISTS `gh_type`;
CREATE TABLE IF NOT EXISTS `gh_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Type of resource (website, image, video, etc)' AUTO_INCREMENT=27 ;

--
-- Dumping data for table `gh_type`
--

INSERT INTO `gh_type` VALUES(1, 'Website', NULL);
INSERT INTO `gh_type` VALUES(2, 'Image', 'Any digital image.');
INSERT INTO `gh_type` VALUES(3, 'Video', 'Streaming or standalone video clip');
INSERT INTO `gh_type` VALUES(4, 'Audio', 'Streaming or standalone audio clip');
INSERT INTO `gh_type` VALUES(5, 'Document', 'Any word-processed document (doc, rtf, pdf, etc)');
INSERT INTO `gh_type` VALUES(9, 'Database', 'Any online database');
INSERT INTO `gh_type` VALUES(10, 'Spreadsheet', NULL);
INSERT INTO `gh_type` VALUES(11, 'Forum', 'Any kind of online discussion board (WWW, Usenet, etc)');
INSERT INTO `gh_type` VALUES(15, 'Article', 'Online article (eg news item, blog post)');
INSERT INTO `gh_type` VALUES(16, 'Paper', 'Peer-reviewed academic paper (online)');
INSERT INTO `gh_type` VALUES(17, 'Organisation', '');
INSERT INTO `gh_type` VALUES(19, 'Journal', 'Academic and/or vocational journal');
INSERT INTO `gh_type` VALUES(21, 'Podcast', 'Audio or video recordings with a RSS newsfeed.');
INSERT INTO `gh_type` VALUES(24, 'Book', 'Online book');
INSERT INTO `gh_type` VALUES(25, 'Repository', 'Repository or collection of resources');
INSERT INTO `gh_type` VALUES(26, 'Presentation', 'Powerpoint or other type of electronic presentation');

-- --------------------------------------------------------

--
-- Table structure for table `gh_users`
--

DROP TABLE IF EXISTS `gh_users`;
CREATE TABLE IF NOT EXISTS `gh_users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `country` smallint(5) unsigned NOT NULL DEFAULT '10' COMMENT 'Foreign key from country table',
  `url` varchar(100) DEFAULT NULL COMMENT 'URL of personal page/website',
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `gh_users`
--

INSERT INTO `gh_users` VALUES(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1366134911, 1, 'Admin', 'istrator', 'ADMIN', '', 10, '');
INSERT INTO `gh_users` VALUES(2, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'harry hamster', '4c18bce31f25343ee51838f757d83f4eaaed1323', NULL, 'harry.hamster@rodents.com', NULL, NULL, NULL, NULL, 1359588280, 1365530945, 1, 'Harry', 'Hamster', '', '', 10, '');
INSERT INTO `gh_users` VALUES(3, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'fred riley', 'a9dcf30898b93990da05d22fd35292e6d11804dd', NULL, 'fred.riley@gmail.com', NULL, NULL, NULL, '0836a83566bb878e74129304eb15d3ee048d1649', 1362502100, 1367247226, 1, 'Fred', 'Riley', 'Self-employed', '', 10, '');
INSERT INTO `gh_users` VALUES(4, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'hamstair toilichte', 'e23a72bcf5759b190dd76fc87fffd2426b5c554f', NULL, 'hamstair.toilichte@gmail.com', NULL, NULL, NULL, NULL, 1363262193, 1365530263, 1, 'Hamstair', 'Toilichte', 'Rodent city', '01159258361', 10, '');
INSERT INTO `gh_users` VALUES(8, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'georgie porgy', 'aef131a756a9b7a803978e34594236f5e575c135', NULL, 'g.porgy@piggies.com', NULL, NULL, NULL, NULL, 1363274571, 1366638678, 1, 'Georgie', 'Porgy', 'Pudding and pies', '12312321', 17, 'http://www.piggies.com');

-- --------------------------------------------------------

--
-- Table structure for table `gh_users_groups`
--

DROP TABLE IF EXISTS `gh_users_groups`;
CREATE TABLE IF NOT EXISTS `gh_users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `gh_users_groups`
--

INSERT INTO `gh_users_groups` VALUES(39, 3, 1);
INSERT INTO `gh_users_groups` VALUES(40, 3, 2);
INSERT INTO `gh_users_groups` VALUES(41, 3, 3);
INSERT INTO `gh_users_groups` VALUES(49, 2, 2);
INSERT INTO `gh_users_groups` VALUES(52, 4, 2);
INSERT INTO `gh_users_groups` VALUES(53, 4, 3);
INSERT INTO `gh_users_groups` VALUES(54, 1, 1);
INSERT INTO `gh_users_groups` VALUES(55, 1, 2);
INSERT INTO `gh_users_groups` VALUES(56, 1, 3);
INSERT INTO `gh_users_groups` VALUES(57, 8, 2);
INSERT INTO `gh_users_groups` VALUES(58, 8, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gh_institution`
--
ALTER TABLE `gh_institution`
  ADD CONSTRAINT `gh_institution_ibfk_1` FOREIGN KEY (`inst_type`) REFERENCES `gh_institution_type` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `gh_resource`
--
ALTER TABLE `gh_resource`
  ADD CONSTRAINT `RESOURCE_ibfk_1` FOREIGN KEY (`type`) REFERENCES `gh_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `RESOURCE_ibfk_2` FOREIGN KEY (`source`) REFERENCES `gh_origin` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gh_resource_keyword`
--
ALTER TABLE `gh_resource_keyword`
  ADD CONSTRAINT `gh_resource_keyword_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `gh_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gh_resource_keyword_ibfk_2` FOREIGN KEY (`keyword_id`) REFERENCES `gh_keyword` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gh_resource_subject`
--
ALTER TABLE `gh_resource_subject`
  ADD CONSTRAINT `gh_resource_subject_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `gh_resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gh_resource_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `gh_subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gh_subject`
--
ALTER TABLE `gh_subject`
  ADD CONSTRAINT `gh_subject_ibfk_1` FOREIGN KEY (`key_area`) REFERENCES `gh_key_area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `gh_users`
--
ALTER TABLE `gh_users`
  ADD CONSTRAINT `gh_users_ibfk_1` FOREIGN KEY (`country`) REFERENCES `gh_country` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
