-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2013 at 12:32 PM
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
-- Table structure for table `gh_comment`
--

DROP TABLE IF EXISTS `gh_comment`;
CREATE TABLE IF NOT EXISTS `gh_comment` (
  `resource_id` int(10) unsigned NOT NULL COMMENT 'Foreign key from RESOURCE',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `body` text NOT NULL COMMENT 'Comment text ',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT 'Comment author ID. Foreign key from users table',
  `date` datetime NOT NULL COMMENT 'Date and time comment posted',
  PRIMARY KEY (`id`),
  KEY `res_id` (`resource_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Comments on a resource' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gh_comment`
--

INSERT INTO `gh_comment` (`resource_id`, `id`, `body`, `user_id`, `date`) VALUES
(2, 1, 'Vah''re interesting', 1, '2013-02-08 13:28:12'),
(2, 2, 'Vah''re interesting', 1, '2013-02-08 13:28:51'),
(2, 3, 'Vah''re interesting', 1, '2013-02-08 13:29:13'),
(2, 4, 'Vah''re interesting', 1, '2013-02-08 13:56:40');

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

INSERT INTO `gh_country` (`id`, `country_name`, `country_code`) VALUES
(1, 'Australia', '61'),
(2, 'Austria', '43'),
(3, 'Bahrain', '973'),
(4, 'Belgium', '32'),
(5, 'Brazil', '55'),
(6, 'Canada', '1'),
(7, 'Czech Republic', '420'),
(8, 'Denmark', '45'),
(9, 'Egypt', '20'),
(10, 'England', '44'),
(11, 'Finland', '358'),
(12, 'France', '33'),
(13, 'Germany', '49'),
(14, 'Gibraltar', '350'),
(15, 'Greece', '30'),
(16, 'Hong Kong', '852'),
(17, 'Hungary', '36'),
(18, 'India', '91'),
(19, 'Iran', '98'),
(20, 'Iraq', '964'),
(21, 'Ireland', '353'),
(22, 'Israel', '972'),
(23, 'Italy', '39'),
(24, 'Japan', '81'),
(25, 'Kuwait', '965'),
(26, 'Latvia', '371'),
(27, 'Luxembourg', '352'),
(28, 'Macedonia', '389'),
(29, 'Malta', '356'),
(30, 'Mexico', '52'),
(31, 'Monaco', '3393'),
(32, 'Morocco', '212'),
(33, 'N Ireland', '44'),
(34, 'Netherlands', '31'),
(35, 'New Zealand', '64'),
(36, 'Norway', '47'),
(37, 'Poland', '48'),
(38, 'Portugal', '351'),
(39, 'Russia', '7'),
(40, 'Saudi Arabia', '966'),
(41, 'Scotland', '44'),
(42, 'Singapore', '65'),
(43, 'Slovakia', '421'),
(44, 'South Africa', '27'),
(45, 'Spain', '34'),
(46, 'Sweden', '46'),
(47, 'Switzerland', '41'),
(48, 'Taiwan', '886'),
(49, 'Trinidad', '1809'),
(50, 'Tunisia', '216'),
(51, 'Turkey', '90'),
(52, 'UAE', '971'),
(53, 'USA', '1'),
(54, 'Venezuela', '58'),
(55, 'Wales', '44'),
(56, 'Yugoslavia', '38'),
(57, 'Zimbabwe', '263');

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

INSERT INTO `gh_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', '<p>User admin: create, edit, delete.</p>\r\n<p>Resource admin: create, edit, delete</p>\r\n<p>News admin'),
(2, 'members', 'Resource view only - no write rights'),
(3, 'contributor', '<p>Resource admin: create, edit</p>');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Key words/phrases to tag resources' AUTO_INCREMENT=160 ;

--
-- Dumping data for table `gh_keyword`
--

INSERT INTO `gh_keyword` (`id`, `name`, `acronym_expansion`) VALUES
(1, 'Nutrition', NULL),
(2, 'Sub-saharan Africa', NULL),
(3, 'Child poverty', NULL),
(4, 'Undernutrition', NULL),
(5, 'Health inequalities', NULL),
(6, 'Poverty', NULL),
(7, 'Inequality', NULL),
(8, 'Obesity', NULL),
(9, 'Diarrhoea', NULL),
(10, 'Pandemic.', NULL),
(12, 'sanitation', NULL),
(13, 'housing', NULL),
(14, 'gender', NULL),
(16, 'slum', NULL),
(17, 'infrastructure', NULL),
(18, 'sociology', NULL),
(19, 'child mortality', NULL),
(20, 'demography', NULL),
(21, 'india', NULL),
(22, 'bangladesh', NULL),
(23, 'cambodia', NULL),
(24, 'service users', NULL),
(25, 'service design', NULL),
(26, 'NGO', NULL),
(34, 'population', NULL),
(35, 'urbanisation', NULL),
(36, 'family', NULL),
(37, 'social change', NULL),
(38, 'transport', NULL),
(39, 'pollution', NULL),
(40, 'road traffic accident', NULL),
(41, 'infection risk', NULL),
(42, 'epidemic', NULL),
(44, 'climate change', NULL),
(45, 'food', NULL),
(46, 'agriculture', NULL),
(47, 'aid', NULL),
(48, 'nigeria', NULL),
(49, 'health infrastructure', NULL),
(51, 'population change', NULL),
(53, 'economy', NULL),
(54, 'latin america', NULL),
(55, 'community participation', NULL),
(56, 'definition', NULL),
(57, 'international health', NULL),
(58, 'public health', NULL),
(59, 'wilmslow', NULL),
(60, 'hiv', NULL),
(61, 'handwashing', NULL),
(62, 'evidence', NULL),
(63, 'longevity', NULL),
(64, 'aids', NULL),
(65, 'oncology', NULL),
(66, 'tb', NULL),
(67, 'hepatitis', NULL),
(68, 'malaria', NULL),
(69, 'diabetes', NULL),
(70, 'chd', NULL),
(71, 'asthma', NULL),
(72, 'rta', NULL),
(73, 'stroke', NULL),
(74, 'healthcare costs', NULL),
(75, 'healthcare markets', NULL),
(76, 'china', NULL),
(77, 'diet', NULL),
(78, 'south africa', NULL),
(79, 'education', NULL),
(80, 'WHO', NULL),
(81, 'UNICEF', NULL),
(82, 'malawi', NULL),
(83, 'zambia', NULL),
(84, 'development', NULL),
(85, 'equity', NULL),
(86, 'thailand', NULL),
(87, 'sustainability', NULL),
(88, 'MDG', NULL),
(89, 'tobacco industry', NULL),
(90, 'tobacco control', NULL),
(91, 'secondhand smoke', NULL),
(92, 'tobacco advertising', NULL),
(93, 'harm reduction', NULL),
(94, 'cessation', NULL),
(95, 'pandemic', NULL),
(96, 'investment', NULL),
(97, 'disease', NULL),
(98, 'africa', NULL),
(99, 'health inequality', NULL),
(100, 'GDP', NULL),
(101, 'refugees', NULL),
(102, 'sequelae', NULL),
(103, 'infection control', NULL),
(104, 'measles', NULL),
(105, 'STI', NULL),
(106, 'meningitis', NULL),
(107, 'suicide', NULL),
(108, 'LAMICs', NULL),
(109, 'mental health', NULL),
(110, 'hypertension', NULL),
(111, 'russia', NULL),
(112, 'resource poor settings', NULL),
(113, 'social determinants of health', NULL),
(114, 'marmot', NULL),
(115, '', NULL),
(116, 'curriculum', NULL),
(117, 'ageing', NULL),
(118, 'work', NULL),
(119, 'caribbean', NULL),
(120, 'asia', NULL),
(121, 'france', NULL),
(122, 'sweden', NULL),
(123, 'australia', NULL),
(124, 'USA', NULL),
(125, 'Canada', NULL),
(126, 'Hungary', NULL),
(127, 'Poland', NULL),
(128, 'UK', NULL),
(129, 'Spain', NULL),
(130, 'Japan', NULL),
(131, 'Azerbaijan', NULL),
(132, 'Chile', NULL),
(133, 'Jamaica', NULL),
(134, 'Tunisia', NULL),
(135, 'Sri Lanka', NULL),
(136, 'Brazil', NULL),
(137, 'Columbia', NULL),
(138, 'Singapore', NULL),
(139, 'african', NULL),
(140, 'life expectancy', NULL),
(141, 'Italy', NULL),
(142, 'Germany', NULL),
(143, 'Greece', NULL),
(144, 'Bulgaria', NULL),
(145, 'Belgium', NULL),
(146, 'Portugal', NULL),
(147, 'Estonia', NULL),
(148, 'Latvia', NULL),
(149, 'Croatia', NULL),
(150, 'Finland. USA', NULL),
(151, 'Family planning', NULL),
(152, 'Vietnam', NULL),
(153, 'Egypt', NULL),
(154, 'Indonesia', NULL),
(155, 'Philippines', NULL),
(156, 'Kenya', NULL),
(157, 'Pakistan', NULL),
(158, 'DRC', NULL),
(159, 'refugee', NULL);

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

INSERT INTO `gh_key_area` (`id`, `title`, `description`) VALUES
(1, 'Globalisation and social change', ''),
(2, 'Global health topics', ''),
(3, 'Health professions in a global context ', NULL),
(4, 'Overseas electives', NULL),
(5, 'Teaching global health', NULL);

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

INSERT INTO `gh_news` (`id`, `title`, `text`, `posted`, `edited`) VALUES
(1, 'CALL@Hull site redesign', '<p>The <a href="http://www.fredriley.org.uk/callhull/">CALL@Hull</a> site has been radically redesigned, to bring its interface into the 21st century and make it easier to use and maintain. Content has been ''rationalised'', in particular in the General and Multilingual sections, but has otherwise remained the same. It also now has social networking presences on Facebook and Twitter. Added functionality includes a search engine and ''suggest a site'' form. Those interested in the technical details of the redesign can read the technical notes Redirections have been put in place so as not to break existing links. Note that the RSS feed has also been moved - the link in the footer has the up to date feed, so please amend your entry in your newsreader. I welcome comments on the redesign, good, bad or indifferent, via the contact form or by email. The main future development, when/if time allows, will be the moving of the collection into a proper resource repository and dynamic website.</p>', '2013-04-01 12:30:31', '2013-04-05 22:05:07'),
(5, 'CALL@Hull goes dynamic', 'This site has been converted from a static site, comprising HTML files, to a ''dynamic'' site, driven by server-side scripts using the PHP Codeigniter framework. Users won''t notice any substantial difference in design and functioning, although URLs will be snappier (eg languages/french rather than languages/french.html). However, the site will be easier to maintain and to scale, and will be ready to become a fully database-driven site when I get the time to put together a proper repository. Watch this space, and of course the Facebook and Twitter feeds. ', '2013-04-03 00:00:00', '2013-04-05 00:00:00'),
(6, 'Hamster herding', '<p>Hamsters are notoriously difficult to herd, being solitary creatures</p>', '0000-00-00 00:00:00', '2013-04-05 22:03:48'),
(7, 'Gerbil running', '<p>Loads of cute little gerbils around the place. <strong>Yee</strong>-<em>hah</em>!</p>', '2013-04-05 21:56:47', '2013-04-05 21:56:47');

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

INSERT INTO `gh_origin` (`id`, `title`, `description`) VALUES
(1, 'External source', 'Any origin outside the University of Nottingham'),
(2, 'Clinical Skills Group', NULL),
(3, 'Practice Learning Team', NULL),
(4, 'SoN E-Learning Team', NULL),
(5, 'RLO-CETL', NULL),
(6, 'UCEL', NULL),
(7, 'UoN (non-Nursing)', 'University of Nottingham in general, outside SoN'),
(8, 'SNMP (general)', 'Resource originates from the School of NMP in general, not any particular source.'),
(10, 'Clinicalskills.net', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 51200 kB' AUTO_INCREMENT=62 ;

--
-- Dumping data for table `gh_resource`
--

INSERT INTO `gh_resource` (`id`, `title`, `author`, `description`, `modified`, `type`, `url`, `source`, `rights`, `ispartof`, `metadata_created`, `metadata_modified`, `metadata_author`, `restricted`, `visible`, `Notes`) VALUES
(1, 'Global tobacco control', 'Samet, J', '<p>Detailed and lengthy slide sets for 11 lectures including: The tobacco pandemic: An historical overview; Tobacco addiction by design: implications for public health and policy; The modern tobacco industry; National tobacco control strategies; Secondhand smoke; Tobacco control economics; Tracking tobacco industry advertising, marketing and promotion; Harm reduction; Cessastion; and The Framework Convention on Tobacco Control. These materials have been made available on an open source website but are subject to copywrite controls.</p>', NULL, 26, 'http://ocw.jhsph.edu/index.cfm/go/viewCourse/course/GlobalTobaccoControl/coursePage/lectureNotes/', 1, '', NULL, '2013-05-19 20:49:04', '2013-05-10 23:30:40', 3, 0, 1, ''),
(2, 'Health care and equity in India', 'Balarajan et al', '<p>Examines key challenges for the equity of service provision and access according to ability to pay and geography. Includes data on poverty, cost of individual health care expenditure, immunisation and child mortality in graph form. Free registration is necessary for access to this article. This paper is part of a Lancet series on India.</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(10)61894-6/fulltext', 1, '', NULL, '2013-05-10 23:33:12', '2013-05-19 21:34:32', 3, 0, 1, ''),
(3, 'Diabetes saps health and wealth from China''s rise', 'Alcorn et al', '<p>This report examines the rise in diabetes fuelled by China''s economic change.</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60963-5/fulltext', 1, '', NULL, '2013-05-19 20:46:33', '2013-05-10 23:34:53', 3, 0, 1, ''),
(4, 'Feeding cities', 'Brieger, W', '<p>Explores the various perspectives of global health held by different generations.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec8_Brieger.pdf', 1, '', NULL, '2013-05-19 20:59:33', '2013-05-19 21:35:09', 3, 0, 1, ''),
(5, 'The Millennium Development Goals: a cross-sectoral analysis and principles for goal setting after 2015', 'Waage et al', '<p>Reports on analysis by different sectoral experts on MDGs. Also provides a history to the MDGs, progress, tables on obsticles to delivery and on reinforcing links different areas of social progress. Free registration is necessary to access this article.</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(10)61196-8/fulltext', 1, '', NULL, '2013-05-19 20:52:53', '2013-05-19 21:34:09', 3, 0, 1, ''),
(7, 'Challenges in ameliorating hunger while preventing obesity', 'Gordon-Larsen et al', '<p>Examines trends in child nutrition in 141 countries. Despite substantial reductions in the prevalence of moderate and severe stunting and underweight in developing countries, about 30% of children younger than 5 years were moderately or severely stunted and 19% were moderately or severely underweight in 2011. For all countries, the predicted likelihood of achievement of the Millennium Development Goal (MDG) of halving hunger by 2015 was estimated at less than 5%. Access to Lancet subscribers only.</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60909-X/fulltext', 1, '', NULL, '2013-05-17 17:07:03', '2013-04-22 22:12:59', 3, 0, 1, ''),
(8, 'Hemorrhagic Fever Outbreak Investigation', 'Abdallah, S', '<p>Based on a Kenyan case study this slide set provides information on the management and assessment of epidemics.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/RefugeeHealthCare/PDFs/Lecture4.pdf', 1, '', NULL, '2013-05-17 17:23:28', '2013-02-01 00:34:25', 3, 0, 1, ''),
(9, 'World Clock', '', '<p>Online calculator providing global statistics on population, mortality &amp; morbidity, food consumption, energy consumption and environmental impact statistics. Site also includes a life clock demonstrating behaviours and other factors that affect longevity. This is an excellent test that entry level students can use to assess their own lives and assuming the identity of others.</p>', NULL, 1, 'http://www.poodwaddle.com/clocks/worldclock/', 1, '', NULL, '2013-05-17 17:22:34', '2013-05-20 12:26:37', 3, 0, 1, ''),
(11, 'Global urbanisation: trends, patterns, determinants, and impacts', 'Baqui, A et al', '<p>Over 40 slides examining the demography, causes and particular challenges of urbanisation in less developed countries.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec2_Baqui.pdf', 1, '', NULL, '2013-05-08 21:05:18', '2013-05-08 21:05:18', 3, 0, 1, ''),
(12, 'The urban environment and health in developing countries', 'Baqui, A et al', '<p>Over 40 slides examining the impact of rapid urbanisation, the health hazards related to urban physical environmental changes and the extent of inequity in physical environment and health within urban areas.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec3_Baqui.pdf', 1, '', NULL, '2013-05-08 21:19:16', '2013-05-08 21:19:16', 3, 0, 1, ''),
(13, 'The burden of urban ill-health from road transport in developing countries', 'Hyder, A', '<p>A long and detailed slide set examining the relationship between road transport and health in less developed nations. Covering: air and noise pollution, road traffic accidents and the nature and distribution of road traffic induced morbidity.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec5_Hyder.pdf', 1, '', NULL, '2013-05-19 20:59:03', '2013-05-08 21:46:44', 3, 0, 1, ''),
(14, 'Urbanisation and the epidemiology of infectious diseases', 'Moss, W', '<p>Over 70 slides examining rates and types of infection in urban settings with a detailed focus on HIV, malaria, measles and yellow fever.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec7_Moss.pdf', 1, '', NULL, '2013-05-17 17:50:23', '2013-05-08 21:54:29', 3, 0, 1, ''),
(15, 'Urban health in India', 'Moss, W', '<p>A long (90 slides) detailed examination of the features of urban health via two Indian case studies. Includes: population trends, rural versus urban health provision, child mortality, and infrastructure issues and slum ''invisibility''. Case studies include Agra and Indore.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec10a_Agarwal.pdf', 1, '', NULL, '2013-05-09 18:48:02', '2013-05-09 18:48:02', 3, 0, 1, ''),
(16, 'Selected strategies to improve access to and quality of urban primary health care', 'Baqui, A', '<p>Over 60 slides on methods of improving health service mix and quality using Bangladeshi and Cambodian case studies. Includes: an outline of operation research methods, needs assessment, NGO versus government provision, and health care expenditure.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec11_Baqui.pdf', 1, '', NULL, '2013-05-09 18:49:01', '2013-05-09 18:49:01', 3, 0, 1, ''),
(17, 'Lessons from developing nations on improving healthcare', 'Berwick DM', '<p>Demonstrates, using examples from Russia and Peru, that health improvement need not involve increased use of resources.&nbsp; If not accessed via the link provided, subscription is usually needed for access to BMJ articles.</p>', NULL, 15, 'http://www.globalhealth.arizona.edu/sites/globalhealth.arizona.edu/files/Lessons_from_developing_nations.pdf', 1, '', NULL, '2013-05-19 20:57:55', '2013-04-22 22:22:34', 3, 0, 1, ''),
(18, 'A framework for the study of urban health', 'Baqui, A et al', '<p><span>&nbsp;</span></p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec1_Baqui.pdf', 1, '', NULL, '2013-05-09 19:13:29', '2013-05-09 19:13:29', 3, 0, 1, ''),
(19, 'The urban social environment', 'Brieger, W', '<p>A detailed and illustrated slide set examinging the features and impacts of social connectedness in families, neighbourhoods, NGOs and churches. It also examines urban governance and transneighbourhood and transregional associations.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec4_Brieger.pdf', 1, '', NULL, '2013-05-08 21:41:20', '2013-05-08 21:41:20', 3, 0, 1, ''),
(31, 'Community Health Coallitions in Urban Nigeria, 1994-2005', '', '<p>Approximately 70 slides covering definitions, characteristics and sustainability of coalitions and specifically Community Partners for Health in Nigeria. &nbsp;Also includes coalitions as tools of female empowerement.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec12_Brieger.pdf', 1, '', NULL, '2013-05-09 18:53:10', '2013-05-09 18:53:10', 3, 0, 1, ''),
(35, 'A case study on participatory budgeting in Latin America', 'Rice, M', '<p>Approximately 30 slides covering definitions, process, benefits and costs of participatory budgeting. &nbsp;</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/UrbanHealth/PDFs/Urban-sec12_Brieger.pdf', 1, '', NULL, '2013-05-19 21:22:59', '2013-05-19 21:28:29', 3, 0, 1, ''),
(36, 'Towards a common definition of global health', 'Koplan et al', '<p>Traces the history of attempts to define global approaches to health. &nbsp;Includes useful table distinguishing between global, international and public heath. &nbsp;Free registation necessary for access to this article.&nbsp;</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(09)60332-9/fulltext', 1, '', NULL, '2013-05-10 22:56:58', '2013-05-10 22:56:58', 3, 0, 1, ''),
(37, 'Evidenced-based global health', 'Buekens et al', '<p>A three-page introduction to global health research and the pitfalls of assuming that domestic evidence can be generalised to a resource poor setting. &nbsp;The link supplied offers free access but JAMA articles are accessed via subscription only.</p>', NULL, 15, 'http://www.globalhealth.arizona.edu/sites/globalhealth.arizona.edu/files/Evidence-based_Global_Health_0.pdf', 1, '', NULL, '2013-05-10 22:56:19', '2013-05-10 22:56:19', 3, 0, 1, ''),
(38, 'Global health is more important in a smaller world', 'Kanter, SL', '<p>Explores the various perspectives of global health held by different generations.</p>', NULL, 15, 'http://www.globalhealth.arizona.edu/sites/globalhealth.arizona.edu/files/Global_health_is_more_important.pdf', 1, '', NULL, '2013-05-10 22:58:20', '2013-05-10 22:58:20', 3, 0, 1, ''),
(39, 'Trends in mild, moderate, and severe stunting and underweight, and progress towards MDG 1 in 141 developing countries', 'Stevens et al', '<p>A systematic analysis of population representative data. Macroeconomic shocks, structural adjustment, and trade policy reforms in the 1980s and 1990s might have been responsible for worsening child nutritional status in sub-Saharan Africa. Further progress in the improvement of children''s growth and nutrition needs equitable economic growth and investment in pro-poor food and primary care programmes, especially relevant in the context of the global economic crisis. Access to Lancet subscribers only.&nbsp;</p>', NULL, 1, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60647-3/fulltext', 1, '', NULL, '2013-05-17 17:05:18', '2013-05-17 17:05:18', 3, 0, 1, ''),
(40, 'Cholera', 'Harris et al', '<p>This gives an entry level introduction to cholera for those with prescription access to The Lancet</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60436-X/fulltext', 1, '', NULL, '2013-05-17 17:16:29', '2013-05-17 17:16:29', 3, 0, 1, ''),
(41, 'Hepatitis E', 'Kamar et al', '<p>This gives an entry level introduction to Hepatitus E for those with prescription access to The Lancet</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(11)61849-7/fulltext', 1, '', NULL, '2013-05-17 17:19:56', '2013-05-17 17:19:56', 3, 0, 1, ''),
(42, 'Why rich countries should care about the world''s least healthy people', 'Gostin, LO', '<p>A four-page introduction to the medical (largely communicable disease focused) and ethical arguments for investment in global health by nations and individual health care workers.</p>', NULL, 15, 'http://www.globalhealth.arizona.edu/sites/globalhealth.arizona.edu/files/Why_Rich_Countries_Should_Care_0.pdf', 1, '', NULL, '2013-05-17 17:21:54', '2013-05-19 21:34:50', 3, 0, 1, ''),
(43, 'Control of communicable diseases', 'Burnham, G', '<p>With a particular focus on refugee populations this set of over one hundred slides provides information on a range of communicable diseases, infection risks, disease cycles and guidance for those &nbsp;planning a disease control program.</p>', NULL, 26, 'http://ocw.jhsph.edu/courses/RefugeeHealthCare/PDFs/Lecture9.pdf', 1, '', NULL, '2013-05-17 17:29:02', '2013-05-17 17:29:02', 3, 0, 1, ''),
(44, 'Suicide mortality in India: a nationally representative survey', 'V Patel et al', '<p>Examines quantative data suggesting that WHO suicide estimations underestimate prevalence in India. Suicide death rates in India are among the highest in the world. A large proportion of adult suicide deaths occur between the ages of 15 years and 29 years, especially in women. Public health interventions such as restrictions in access to pesticides might prevent many suicide deaths in India. This is not an analysis of the underlying socio-economic causes of suicide.</p>', NULL, 15, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(12)60606-0/fulltext', 1, '', NULL, '2013-05-17 17:57:54', '2013-05-17 17:57:54', 3, 0, 1, ''),
(45, 'Issues in mental health research in developing countries', 'Bass, J', '<p>Selection of slides and audio recordings covering: Issues in global mental health research; defining mental health disorders; mental health in complex emergencies; and culture and mental health</p>', NULL, 26, 'http://ocw.jhsph.edu/index.cfm/go/viewCourse/course/MHDevCo/coursePage/lectureNotes/', 1, '', NULL, '2013-05-19 20:51:57', '2013-05-19 20:51:57', 3, 0, 1, ''),
(46, 'Building of the global movement for health equity: from Santiago to Rio and beyond', 'Waage et al', '<p>Reports on developments subsequent to the publication of the Commission on social determinants of health, specifically emerging findings from WHO European Region. &nbsp;Free registation necessary for access to this article.&nbsp;</p>', NULL, 1, 'http://www.thelancet.com/journals/lancet/article/PIIS0140-6736(11)61506-7/fulltext', 1, '', NULL, '2013-05-19 21:04:29', '2013-05-19 21:31:18', 3, 0, 1, ''),
(47, 'The benefits and barriers of student involvement in the introduction of Global Health Education - Leicester', 'Dolphin and Drew', '<p>Conference presentation outlining the learning outcomes and process of introducing global health into the core curriculum of Leicester Medical School. Medical in focus but broad in scope.</p>', NULL, 26, 'http://www.asme.org.uk/images/ghe2011/Dolphin and Drew.pdf', 1, '', NULL, '2013-05-19 21:36:53', '2013-05-19 21:38:34', 3, 0, 1, ''),
(48, 'Age and Sex Structure of India', 'Population Reference Bureau (US)', '<p>Single power point side showing age and gender demographics for India</p>', NULL, 27, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:41:35', '2013-05-19 21:44:21', 3, 0, 1, ''),
(49, 'Aging in China 1950 - 2050', 'Population Reference Bureau (US)', '<p>Graph (line) and notes showing the percentage of China''s that have been and are and will be over 65 years of age.</p>', NULL, 1, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:46:46', '2013-05-19 21:46:46', 3, 0, 1, ''),
(50, 'Ratio of workers to dependents by region', 'Population Reference Bureau (US)', '<p>Graph (line) showing the ratio of workers to dependents in Asia, Africa and Latin America &amp; the Caribbean for between 1950 and 2050.</p>', NULL, 26, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:50:11', '2013-05-19 21:50:11', 3, 0, 1, ''),
(51, 'Speed of population aging in selected countries', 'Population Reference Bureau (US)', '<p>Graph (bar) and notes showing the span of years when percent of population age 65 or older rose (or is projected to rise) from 7 percent to 14 percent in a selection of developed and less developed countries.&nbsp;</p>', NULL, 26, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:52:27', '2013-05-19 21:52:27', 3, 0, 1, ''),
(52, 'Trends in life expectancy by region', 'Population Reference Bureau (US)', '<p>Graph (bar) and notes showing trends in life expectancy at birth between 2000-2005 and 2045-2050 across Africa, Asia, Latin America &amp; Caribbean, ''More developed'' regions and the total global population.</p>', NULL, 26, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:54:05', '2013-05-19 21:54:05', 3, 0, 1, ''),
(53, 'Trends in aging by world region', 'Population Reference Bureau (US)', '<p>Graph (bar) and notes showing percentage of population age 65 and over for 1980, 2010 and 2040 across Africa, Asia, Latin America &amp; the Caribbean, ''More Developed Regions'' and total global population.</p>', NULL, 26, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:56:11', '2013-05-19 21:56:11', 3, 0, 1, ''),
(54, 'The world''s ''oldest'' countries and the US', 'Population Reference Bureau (US)', '<p>Graph (bar) and notes showing percentage of population age 65 or over across Japan, Italy, Germany, Greece, Sweden, Bulgaria, Belgium, Portugal, Spain, Estonia, Latvia, Croatia, France, UK, Finland and US.</p>', NULL, 26, 'http://www.prb.org/Home/Publications/GraphicsBank/Aging.aspx', 1, '', NULL, '2013-05-19 21:58:09', '2013-05-19 21:58:09', 3, 0, 1, ''),
(55, 'Family planning use worldwide', 'Population Reference Bureau (US)', '<p>A range of graphs including: Increasing family planning use in developing countries, Male and Female Use of Contraception, Male and Female Use of Contraception,Male and Female Use of Contraception, Modern Contraceptive Use, Developing Countries, Use of Modern contraceptives.</p>', NULL, 26, 'http://www.prb.org/Publications/GraphicsBank/FamilyPlanning.aspx', 1, '', NULL, '2013-05-19 21:59:41', '2013-05-20 12:16:44', 3, 0, 1, ''),
(56, 'Contraceptive methods data', 'Population Reference Bureau (US)', '<p>A range of graphs including: Countries With High Rates of Condom Use, Countries With High Rates of Condom Use, Family Planning Methods in Developed Countries, Around 2007, Family Planning Methods in Sub-Saharan Africa, Family Planning Methods Worldwide, Modern Contraceptive Use in Less Developed vs. More Developed Countries, Top Five Countries in Use of Female Sterilization and Use of Injectables Rises With Increase in Family Planning Use.</p>', NULL, 26, 'http://www.prb.org/Publications/GraphicsBank/FamilyPlanning.aspx', 1, '', NULL, '2013-05-20 12:18:07', '2013-05-20 12:18:07', 3, 0, 1, ''),
(57, 'Family planning costs and demand', 'Population Reference Bureau (US)', '<p>A range of graphs including: Distribution of Women With an Unmet Need for Contraception by Region, 2008; Social Sector Savings and Family Planning Costs by 2015, Burkina Faso; Social Sector Savings and Family Planning Costs by 2015, Democratic Republic of Congo; Social Sector Savings and Family Planning Costs by 2015, Ethiopia; Social Sector Savings and Family Planning Costs by 2015, Ghana; Social Sector Savings and Family Planning Costs by 2015, Zambia; Total Potential Demand for Family Planning; Trend in Unmet Need for Modern Contraception; Unmet Need for Family Planning;Unmet Need for Family Planning by Wealth; and Unmet Need Exceeds Modern Contraception Use in Sub-Saharan Africa.&nbsp;</p>', NULL, 26, 'http://www.prb.org/Publications/GraphicsBank/FamilyPlanning.aspx', 1, '', NULL, '2013-05-20 12:19:20', '2013-05-20 12:20:12', 3, 0, 1, ''),
(58, 'Disparities in childbearing and contraceptive use', 'Population Reference Bureau (US)', '<p>A range of graphs including: Average Number of Children Among Poorest and Wealthiest Women: Dominican Republic and Colombia; Contraception and Childbearing, Populous Countries; Contraceptive Use Among Wealthiest and Poorest Women; Contraceptive Use and Childbearing, by Region; Discussion of Family Planning With Spouse, Senegal, 2005; Husbands'' Discussion of Family Planning With Their Wives, c. 2000-2007; Husbands'' Discussion of Family Planning With Their Wives, c. 2000-2007; Modern Contraceptive Use by Household Wealth in Developing Regions, Around 2006; Modern Contraceptive Use by Wealth: Sub-Saharan Africa; Total Fertility Rate by Mother''s Education; Total Fertility Rate by Mother''s Education; Unintended Births, Selected Countries and Wealth Disparities in Contraceptive Use.</p>', NULL, 26, 'http://www.prb.org/Publications/GraphicsBank/FamilyPlanning.aspx', 1, '', NULL, '2013-05-20 12:21:35', '2013-05-20 12:21:35', 3, 0, 1, ''),
(59, 'Reasons for not using contraception', 'Population Reference Bureau (US)', '<p>A range of graphs including: Discontinuation of Contraceptives by Reason, Selected Countries; Reasons for Not Using Contraception, Azerbaijan 2006; Reasons for Not Using Contraception, Bangladesh 2007; Reasons for Not Using Contraception, Benin, 2006; Reasons for Not Using Contraception, Cambodia, 2005; Reasons for Not Using Contraception, Colombia, 2005; Reasons for Not Using Contraception, Ethiopia; Reasons for Not Using Contraception, Jordan, 2007; and Reasons for Not Using Contraception, Ukraine 2007.&nbsp;</p>', NULL, 26, 'http://www.prb.org/Publications/GraphicsBank/FamilyPlanning.aspx', 1, '', NULL, '2013-05-20 12:23:22', '2013-05-20 12:23:22', 3, 0, 1, ''),
(60, 'Family size preferences', 'Population Reference Bureau (US)', '<p>A range of graphs including: Average Ideal Number of Children by Woman&rsquo;s Education, 2007; Average Number of Children Desired by Men and Women in Sub-Saharan Africa; Ideal Number of Children Among Married Men: Southern and Eastern Africa; Ideal Number of Children Among Married Men: Western and Middle Africa; Ideal Number of Children Among Married Women: Asia and North Africa; Ideal Number of Children Among Married Women: Eastern and Southern Africa; Ideal Number of Children Among Married Women: Latin America and the Caribbean; Ideal Number of Children Among Married Women: Western and Middle Africa; Mean Ideal Number of Children by Urban/Rural Residence; Percentage of Currently Married Men Who Want No More Children; Percentage of Married Women Who Want No More Children, 2007; Planning Status of Recent Births; Trends In Average Ideal Number of Children Among Young Single Women: Asia; Trends In Average Ideal Number of Children Among Young Single Women: Latin America and Caribbean; Trends In Average Ideal Number of Children Among Young Single Women: Western and Middle Africa; Trends In Average Ideal Number of Children for Married Men in Sub-Saharan Africa; Trends In Average Ideal Number of Children for Never-Married Women Under Age 25; Trends In Average Ideal Number of Children for Young Single Women: Southern and Eastern Africa; Trends In the Percentage of Married Men Who Want No More Children in Sub-Saharan Africa; Trends In the Percentage of Married Women With Three or Four Children Who Want No More Children; Trends In the Percentage of Married Women With Two or Three Children Who Want No More Children; Trends In Wanted, Unwanted, and Total Fertility Rate; and Wanted Total Fertility Rate by Wealth.</p>', NULL, 26, 'http://www.prb.org/Publications/GraphicsBank/FamilyPlanning.aspx', 1, '', NULL, '2013-05-20 12:25:51', '2013-05-20 12:25:51', 3, 0, 1, ''),
(61, 'Refugee health care', 'John Hopkins Bloomberg School of Public Health', '<p>Wide range of lecture slide sets entitled: Refugee and disaster definitions; causes of conflict and population displacement; Information and surveillance systems for refugee populations; Hemorrhagic fever outbreak investigation; Health needs of refugees; Assessing health needs; Establishing health services; Control of communicable diseases; The United Nations High Commissioner for Refugees; Mental illness amoung trauma-affected populations, Health and human rights principles for refugee health; and From disasters to development.</p>', NULL, 26, 'http://ocw.jhsph.edu/index.cfm/go/viewCourse/course/RefugeeHealthCare/coursePage/lectureNotes/', 1, '', NULL, '2013-05-20 12:28:11', '2013-05-20 12:28:11', 3, 0, 1, '');

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

INSERT INTO `gh_resource_keyword` (`resource_id`, `keyword_id`) VALUES
(8, 9),
(8, 10),
(8, 6),
(15, 6),
(15, 14),
(15, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20),
(15, 21),
(16, 22),
(16, 23),
(16, 6),
(16, 24),
(16, 25),
(16, 26),
(19, 34),
(19, 35),
(19, 20),
(19, 14),
(19, 36),
(19, 37),
(19, 6),
(13, 38),
(13, 35),
(13, 39),
(13, 40),
(14, 41),
(14, 35),
(14, 42),
(4, 44),
(4, 45),
(4, 6),
(4, 46),
(4, 1),
(4, 47),
(31, 14),
(31, 48),
(31, 49),
(18, 35),
(18, 51),
(18, 20),
(35, 53),
(35, 54),
(35, 55),
(36, 56),
(36, 57),
(36, 58),
(36, 59),
(37, 60),
(37, 9),
(37, 61),
(37, 62),
(9, 20),
(9, 63),
(9, 64),
(9, 65),
(9, 66),
(9, 67),
(9, 68),
(9, 69),
(9, 70),
(9, 71),
(9, 72),
(9, 73),
(2, 6),
(2, 21),
(2, 19),
(2, 74),
(2, 7),
(2, 75),
(2, 14),
(3, 76),
(3, 69),
(3, 53),
(3, 58),
(3, 77),
(5, 78),
(5, 21),
(5, 14),
(5, 79),
(5, 80),
(5, 81),
(5, 82),
(5, 83),
(5, 6),
(5, 84),
(5, 85),
(5, 86),
(5, 87),
(39, 1),
(39, 2),
(39, 3),
(39, 4),
(39, 5),
(7, 6),
(7, 7),
(7, 8),
(7, 1),
(7, 3),
(7, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(40, 9),
(40, 95),
(41, 9),
(42, 96),
(42, 97),
(42, 98),
(42, 99),
(42, 100),
(43, 101),
(43, 102),
(43, 103),
(43, 104),
(43, 105),
(43, 106),
(43, 66),
(43, 68),
(14, 68),
(44, 107),
(44, 21),
(44, 80),
(44, 108),
(45, 109),
(17, 110),
(17, 111),
(17, 112),
(17, 60),
(17, 64),
(46, 80),
(46, 7),
(46, 113),
(46, 114),
(47, 79),
(47, 116),
(48, 14),
(48, 34),
(48, 21),
(49, 76),
(49, 117),
(49, 34),
(50, 98),
(50, 118),
(50, 119),
(50, 54),
(50, 20),
(50, 120),
(51, 121),
(51, 34),
(51, 20),
(51, 117),
(51, 122),
(51, 123),
(51, 124),
(51, 125),
(51, 126),
(51, 127),
(51, 128),
(51, 129),
(51, 130),
(51, 131),
(51, 132),
(51, 76),
(51, 133),
(51, 134),
(51, 135),
(51, 86),
(51, 136),
(51, 137),
(51, 138),
(52, 139),
(52, 140),
(52, 120),
(52, 54),
(52, 119),
(53, 98),
(53, 117),
(53, 119),
(53, 54),
(53, 20),
(53, 120),
(54, 130),
(54, 141),
(54, 142),
(54, 143),
(54, 122),
(54, 144),
(54, 145),
(54, 146),
(54, 129),
(54, 147),
(54, 148),
(54, 149),
(54, 121),
(54, 128),
(54, 150),
(54, 117),
(55, 151),
(55, 14),
(55, 78),
(55, 137),
(55, 152),
(55, 153),
(55, 154),
(55, 22),
(55, 155),
(55, 156),
(55, 157),
(55, 48),
(55, 158),
(56, 151),
(56, 14),
(57, 151),
(57, 14),
(58, 151),
(58, 14),
(59, 151),
(59, 14),
(60, 151),
(60, 14),
(61, 159),
(61, 112),
(61, 34);

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

INSERT INTO `gh_resource_subject` (`resource_id`, `subject_id`) VALUES
(8, 44),
(12, 38),
(13, 38),
(16, 38),
(18, 38),
(11, 38),
(19, 38),
(14, 38),
(4, 38),
(15, 38),
(31, 38),
(35, 38),
(36, 55),
(37, 55),
(38, 55),
(9, 77),
(9, 55),
(9, 75),
(1, 55),
(2, 79),
(2, 81),
(2, 41),
(3, 41),
(4, 39),
(4, 41),
(5, 57),
(39, 57),
(7, 57),
(1, 41),
(40, 44),
(41, 44),
(42, 44),
(43, 44),
(14, 44),
(44, 58),
(3, 58),
(1, 58),
(45, 58),
(17, 78),
(13, 39),
(46, 74),
(46, 83),
(5, 83),
(2, 83),
(42, 83),
(4, 83),
(47, 70),
(48, 75),
(49, 75),
(50, 75),
(51, 75),
(52, 75),
(53, 75),
(54, 75),
(55, 75),
(56, 75),
(57, 75),
(58, 75),
(59, 75),
(60, 75),
(61, 75);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `gh_subject`
--

INSERT INTO `gh_subject` (`id`, `title`, `description`, `key_area`) VALUES
(38, 'Urbanisation', '', 1),
(39, 'Climate change and sustainability', '', 1),
(41, 'Global economy and health', 'policy, trade, aid and health', 1),
(44, 'Communicable diseases', '', 2),
(45, 'New and emerging infectious diseases', '', 1),
(51, 'Migration of health professionals', '', 3),
(55, 'Global health issues', 'demographic & epidemiological transitions; trends and changing patterns of disease, related policies', 2),
(56, 'Determinants of health', 'poverty, equity and inequalities; related policies', 2),
(57, 'Millennium Development Goals', 'issues, policies, nursing practices, outcomes); i.e. primary health care and communicable diseases', 2),
(58, 'Non-communicable diseases', 'issues, policies, nursing practices, outcomes; i.e. chronic conditions', 2),
(59, 'Theories of globalisation', NULL, 1),
(60, 'Population migration and health', 'Population migration and refugees', 1),
(61, 'Technology', 'New technologies and health', 1),
(63, 'Human resource status and policies', '', 3),
(64, 'Leadership', '', 3),
(65, 'Regulation and governance', '', 3),
(66, 'Education', '', 3),
(67, 'Global citizenship', '', 5),
(68, 'Cultural competence', '', 5),
(69, 'Global health course design', 'Global health course design and curricula', 5),
(70, 'Global health teaching', 'Global health teaching approaches and practices', 5),
(71, 'Supporting international students', '', 5),
(72, 'Planning a clinical placement  overseas', '', 4),
(73, 'Effective learning from an overseas placement', '', 4),
(74, 'Social justice, human rights and health', '', 1),
(75, 'Population growth', '', 1),
(76, 'Global health governance', '', 1),
(77, 'Epidemiology and burden of disease', '', 2),
(78, 'Health systems and models of service delivery', '', 2),
(79, 'Child health', '', 2),
(80, 'Maternal health', '', 2),
(81, 'Gender and health', '', 2),
(82, 'Unintentional injuries', '', 2),
(83, 'Poverty and inequality', '', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Type of resource (website, image, video, etc)' AUTO_INCREMENT=29 ;

--
-- Dumping data for table `gh_type`
--

INSERT INTO `gh_type` (`id`, `title`, `description`) VALUES
(1, 'Website', NULL),
(2, 'Image', 'Any digital image.'),
(3, 'Video', 'Streaming or standalone video clip'),
(4, 'Audio', 'Streaming or standalone audio clip'),
(5, 'Document', 'Any word-processed document (doc, rtf, pdf, etc)'),
(9, 'Database', 'Any online database'),
(10, 'Spreadsheet', NULL),
(11, 'Forum', 'Any kind of online discussion board (WWW, Usenet, etc)'),
(15, 'Article', 'Online article (eg news item, blog post)'),
(16, 'Paper', 'Peer-reviewed academic paper (online)'),
(17, 'Organisation', ''),
(19, 'Journal', 'Academic and/or vocational journal'),
(21, 'Podcast', 'Audio or video recordings with a RSS newsfeed.'),
(24, 'Book', 'Online book'),
(25, 'Repository', 'Repository or collection of resources'),
(26, 'Presentation', 'Powerpoint or other type of electronic presentation'),
(27, 'Bar chart', NULL),
(28, 'Bar chart', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `gh_users`
--

INSERT INTO `gh_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `country`, `url`) VALUES
(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1366134911, 1, 'Admin', 'istrator', 'ADMIN', '', 10, ''),
(2, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'harry hamster', '4c18bce31f25343ee51838f757d83f4eaaed1323', NULL, 'harry.hamster@rodents.com', NULL, NULL, NULL, NULL, 1359588280, 1365530945, 1, 'Harry', 'Hamster', '', '', 10, ''),
(3, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'fred riley', 'a9dcf30898b93990da05d22fd35292e6d11804dd', NULL, 'fred.riley@gmail.com', NULL, NULL, NULL, '0836a83566bb878e74129304eb15d3ee048d1649', 1362502100, 1369044823, 1, 'Fred', 'Riley', 'Self-employed', '', 10, ''),
(4, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'hamstair toilichte', 'e23a72bcf5759b190dd76fc87fffd2426b5c554f', NULL, 'hamstair.toilichte@gmail.com', NULL, NULL, NULL, NULL, 1363262193, 1365530263, 1, 'Hamstair', 'Toilichte', 'Rodent city', '01159258361', 10, ''),
(8, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'georgie porgy', 'aef131a756a9b7a803978e34594236f5e575c135', NULL, 'g.porgy@piggies.com', NULL, NULL, NULL, '78e7962d6dc90e0b88f6e4c039196df5e191fdfa', 1363274571, 1367772190, 1, 'Georgie', 'Porgy', 'Pudding and pies', '12312321', 17, 'http://www.piggies.com'),
(9, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'catrin evans', 'bd0f9ec8546eaf96c13fd691d1ce0fc8c382ce09', NULL, 'catrin.evans@nottingham.ac.uk', NULL, NULL, NULL, NULL, 1368029250, 1368029250, 1, 'Catrin', 'Evans', 'University of Nottingham', '01158230894', 10, 'https://www.nottingham.ac.uk/nmp/people/catrin.evans'),
(10, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'heather wharrad', '52fb59d9947a5204fcf76f918fbce09cef129c3d', NULL, 'heather.wharrad@nottingham.ac.uk', NULL, NULL, NULL, NULL, 1368032144, 1368032144, 1, 'Heather', 'Wharrad', 'University of Nottingham', '01158230909', 10, ''),
(11, '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', 'aaron fecowycz', 'd436c3767124833a59dbaa7b1499e3f9b1d4e49b', NULL, 'aaron.fecowycz@nottingham.ac.uk', NULL, NULL, NULL, NULL, 1368032301, 1368032301, 1, 'Aaron', 'Fecowycz', 'University of Nottingham', '', 10, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `gh_users_groups`
--

INSERT INTO `gh_users_groups` (`id`, `user_id`, `group_id`) VALUES
(39, 3, 1),
(40, 3, 2),
(41, 3, 3),
(49, 2, 2),
(52, 4, 2),
(53, 4, 3),
(54, 1, 1),
(55, 1, 2),
(56, 1, 3),
(57, 8, 2),
(58, 8, 3),
(60, 9, 1),
(61, 9, 2),
(62, 9, 3),
(64, 10, 1),
(65, 10, 2),
(66, 10, 3),
(68, 11, 1),
(69, 11, 2),
(70, 11, 3);

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
