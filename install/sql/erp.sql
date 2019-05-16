-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2014 at 10:45 AM
-- Server version: 5.5.41-cll-lve
-- PHP Version: 5.4.35

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `AdminEmail` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Name` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`AdminID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `CmpID` int(20) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DisplayName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Password` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Description` text NOT NULL,
  `Image` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ContactPerson` varchar(40) NOT NULL,
  `Address` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AlternateEmail` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `JoiningDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `verification_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `TempPass` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PasswordUpdated` tinyint(4) NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Fax` varchar(30) NOT NULL,
  `Website` varchar(100) NOT NULL,
  `MaxUser` varchar(20) NOT NULL,
  `Department` varchar(30) NOT NULL,
  `Timezone` varchar(10) NOT NULL,
  `DateFormat` varchar(10) NOT NULL,
  `currency_id` int(10) NOT NULL DEFAULT '9',
  `RecordsPerPage` varchar(20) NOT NULL,
  `Banner` varchar(40) NOT NULL,
  `SessionTimeout` int(10) NOT NULL DEFAULT '1200',
  `PaymentPlan` varchar(40) NOT NULL,
  `StorageLimit` varchar(50) NOT NULL,
  `StorageLimitUnit` varchar(3) NOT NULL,
  `Storage` varchar(50) NOT NULL,
  `TrackInventory` tinyint(1) NOT NULL DEFAULT '1',
  `LicenseKey` varchar(255) NOT NULL,
  PRIMARY KEY (`CmpID`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `ConfigID` int(11) NOT NULL AUTO_INCREMENT,
  `SiteName` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'My Trade Spaces',
  `SiteTitle` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'My Trade Spaces',
  `SiteLogo` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `BodyBg` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `HomeImage` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `HomeFlash` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `FlashWidth` int(10) NOT NULL,
  `FlashHeight` int(10) NOT NULL,
  `RecordsPerPage` int(11) NOT NULL DEFAULT '10',
  `CartStatus` tinyint(1) NOT NULL DEFAULT '1',
  `RecieveSignEmail` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'n',
  `MemberApproval` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'Admin',
  `PostingApproval` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'Auto',
  `FeaturedStorePrice` float NOT NULL,
  `MaxPartnerLimit` int(10) NOT NULL,
  `Tax` float(10,2) NOT NULL DEFAULT '5.00',
  `Shipping` float(10,2) NOT NULL DEFAULT '20.00',
  `tutorial` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `BannerHome` int(11) NOT NULL DEFAULT '2',
  `BannerRight` int(11) NOT NULL DEFAULT '4',
  `MyGate_Mode` tinyint(1) NOT NULL DEFAULT '0',
  `MyGate_MerchantID` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `MyGate_ApplicationID` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `AccountHolder` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `AccountNumber` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `BankName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `BranchCode` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `SwiftNumber` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `MyGatePayment` tinyint(1) NOT NULL DEFAULT '0',
  `PaypalPayment` tinyint(1) NOT NULL DEFAULT '0',
  `EftPayment` tinyint(1) NOT NULL DEFAULT '0',
  `DepositPayment` tinyint(1) NOT NULL DEFAULT '0',
  `PaypalID` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `WebsitePrice` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `StorePrice` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `WebsiteStorePrice` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `BlogAbuseWords` text COLLATE latin1_general_ci NOT NULL,
  `MetaKeywords` text COLLATE latin1_general_ci NOT NULL,
  `MetaDescription` text COLLATE latin1_general_ci NOT NULL,
  `IpBlock` tinyint(4) NOT NULL,
  PRIMARY KEY (`ConfigID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `is_main` tinyint(4) NOT NULL DEFAULT '0',
  `continent_id` int(11) NOT NULL,
  `isd_code` int(10) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(120) COLLATE latin1_general_ci NOT NULL,
  `symbol_left` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `symbol_right` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `currency_value` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `updated_date` date NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `date_format`
--

CREATE TABLE IF NOT EXISTS `date_format` (
  `dateID` int(10) NOT NULL AUTO_INCREMENT,
  `DateFormat` varchar(20) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`dateID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `depID` int(10) NOT NULL AUTO_INCREMENT,
  `Department` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`depID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `det`
--

CREATE TABLE IF NOT EXISTS `det` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `allow` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ipAddress` (`allow`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `code` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`state_id`),
  KEY `name` (`name`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_block`
--

CREATE TABLE IF NOT EXISTS `user_block` (
  `blockID` bigint(20) NOT NULL AUTO_INCREMENT,
  `LoginTime` varchar(30) NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  PRIMARY KEY (`blockID`),
  KEY `LoginIP` (`LoginIP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_email`
--

CREATE TABLE IF NOT EXISTS `user_email` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CmpID` int(20) NOT NULL,
  `RefID` int(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `CmpID` (`CmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zipcode`
--

CREATE TABLE IF NOT EXISTS `zipcode` (
  `zipcode_id` int(12) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  PRIMARY KEY (`zipcode_id`),
  UNIQUE KEY `zip_code` (`zip_code`,`city_id`),
  KEY `city_id` (`city_id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
