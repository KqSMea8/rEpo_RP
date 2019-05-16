
CREATE TABLE IF NOT EXISTS `admin_modules` (
  `ModuleID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Parent` int(10) NOT NULL DEFAULT '0',
  `Default` tinyint(4) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  PRIMARY KEY (`ModuleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `ConfigID` int(11) NOT NULL AUTO_INCREMENT,
  `RecordsPerPage` int(11) NOT NULL DEFAULT '10',
  `Tax` float(10,2) NOT NULL DEFAULT '5.00',
  `Shipping` float(10,2) NOT NULL DEFAULT '20.00',
  `PaypalID` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `MetaKeywords` text COLLATE latin1_general_ci NOT NULL,
  `MetaDescription` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ConfigID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field`
--

CREATE TABLE IF NOT EXISTS `custom_field` (
  `FieldID` int(10) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `depID` int(10) NOT NULL,
  `FieldTitle` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FieldName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FieldInfo` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Module` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Tab` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Parent` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  PRIMARY KEY (`FieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_activity`
--


CREATE TABLE IF NOT EXISTS `c_activity` (
  `activityID` int(15) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `created_by` varchar(36) DEFAULT NULL,
  `created_id` int(15) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `assignedTo` varchar(80) DEFAULT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` int(18) NOT NULL,
  `startDate` date DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `closeDate` date DEFAULT NULL,
  `closeTime` time DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parentID` char(36) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `activityType` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  `visibility` varchar(50) DEFAULT NULL,
  `Notification` tinyint(1) DEFAULT '0',
  `reminder` tinyint(1) NOT NULL DEFAULT '0',
  `RelatedType` varchar(100) NOT NULL,
  `LeadID` int(15) NOT NULL,
  `OpprtunityID` int(15) NOT NULL,
  `CampaignID` int(15) NOT NULL,
  `TicketID` int(15) NOT NULL,
  `QuoteID` int(15) NOT NULL,
  `add_date` date DEFAULT NULL,
  `CustID` int(11) NOT NULL,
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  PRIMARY KEY (`activityID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `c_column` (
 `cvid` int(19) NOT NULL,
 `colindex` int(11) NOT NULL,
 `colname` varchar(250) NOT NULL,
 `colvalue` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `c_customview` (
  `cvid` int(19) NOT NULL AUTO_INCREMENT,
  `viewname` varchar(150) NOT NULL DEFAULT '0',
  `setdefault` tinyint(1) NOT NULL DEFAULT '0',
  `setmetrics` tinyint(1) NOT NULL,
  `entitytype` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `userid` int(19) NOT NULL,
  `locationID` int(15) NOT NULL,
  `ModuleType` varchar(50) NOT NULL,
  `department` int(10) NOT NULL,
  PRIMARY KEY (`cvid`),
  KEY `department` (`department`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `c_advfilter` (
 `cvid` int(19) NOT NULL,
 `columnindex` int(11) NOT NULL,
 `columnname` varchar(250) NOT NULL,
 `comparator` varchar(20) NOT NULL,
 `value` varchar(200) NOT NULL,
 `groupid` int(19) NOT NULL,
 `column_condition` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------





--
-- Table structure for table `c_activity_emp`
--

CREATE TABLE IF NOT EXISTS `c_activity_emp` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `activityID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `parent_type` varchar(30) NOT NULL,
  `parentID` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `eventID` (`activityID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_attribute`
--

CREATE TABLE IF NOT EXISTS `c_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `c_attribute_value`
--

CREATE TABLE IF NOT EXISTS `c_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_campaign`
--

CREATE TABLE IF NOT EXISTS `c_campaign` (
  `campaignID` int(15) NOT NULL AUTO_INCREMENT,
  `campaignname` varchar(255) DEFAULT NULL,
  `campaign_no` varchar(36) DEFAULT NULL,
  `assignedTo` int(15) DEFAULT NULL,
  `campaignstatus` varchar(50) DEFAULT NULL,
  `campaigntype` varchar(50) DEFAULT NULL,
  `product` int(20) DEFAULT NULL,
  `targetaudience` varchar(100) DEFAULT NULL,
  `closingdate` date DEFAULT NULL,
  `sponsor` varchar(100) DEFAULT NULL,
  `targetsize` varchar(100) DEFAULT NULL,
  `numsent` int(20) DEFAULT NULL,
  `budgetcost` decimal(10,2) DEFAULT NULL,
  `actualcost` decimal(10,2) DEFAULT NULL,
  `expectedresponse` varchar(50) DEFAULT NULL,
  `expectedrevenue` decimal(10,2) DEFAULT NULL,
  `expectedsalescount` int(20) DEFAULT NULL,
  `actualsalescount` int(20) DEFAULT NULL,
  `expectedresponsecount` int(20) DEFAULT NULL,
  `actualresponsecount` int(20) DEFAULT NULL,
  `expectedroi` int(20) DEFAULT NULL,
  `actualroi` int(20) DEFAULT NULL,
  `description` text,
  `created_by` varchar(36) DEFAULT NULL,
  `created_id` int(15) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `parent_type` varchar(255) DEFAULT NULL,
  `parentID` char(36) DEFAULT NULL,
  `created_time` datetime NOT NULL,
  PRIMARY KEY (`campaignID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_comments`
--

CREATE TABLE IF NOT EXISTS `c_comments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(12) NOT NULL,
  `commented_by` varchar(12) NOT NULL,
  `commented_id` int(15) NOT NULL,
  `parent_type` varchar(12) NOT NULL,
  `parentID` int(12) NOT NULL,
  `Comment` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CommentDate` datetime NOT NULL,
  `timestamp` int(20) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CommentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_compaign_sel`
--

CREATE TABLE IF NOT EXISTS `c_compaign_sel` (
  `sid` int(15) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) DEFAULT '0',
  `compaignID` varchar(36) DEFAULT NULL,
  `parent_type` varchar(36) DEFAULT NULL,
  `parentID` int(15) DEFAULT NULL,
  `mode_type` varchar(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_comp_assign`
--

CREATE TABLE IF NOT EXISTS `c_comp_assign` (
  `assignID` int(15) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) DEFAULT '0',
  `documentID` int(15) NOT NULL,
  `EmpID` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`assignID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_contact`
--

CREATE TABLE IF NOT EXISTS `c_contact` (
  `ContactID` int(20) NOT NULL AUTO_INCREMENT,
  `LeadID` int(15) NOT NULL,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `FirstName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FullName` varchar(90) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Organization` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `title` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `lead_source` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date_of_birth` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ReportsTo` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CustID` int(15) NOT NULL,
  `AssignTo` int(20) NOT NULL,
  `reference` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Department` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `do_not_call` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `notify_owner` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email_opt_out` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'no',
  `PortalUser` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'no',
  `Supp_start_date` datetime NOT NULL,
  `Supp_end_date` datetime NOT NULL,
  `Image` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PersonalEmail` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ContactID`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_document`
--


CREATE TABLE IF NOT EXISTS `c_document` (
  `documentID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `module` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `linkId` int(15) NOT NULL,
  `AssignTo` varchar(100) NOT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` varchar(50) NOT NULL,
  `FileName` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FilePath` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DownloadType` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `AddedDate` datetime NOT NULL,
  `AddedBy` int(10) NOT NULL,
  `parent_type` varchar(50) NOT NULL,
  `parentID` int(15) NOT NULL,
 `CustID` int(11) NOT NULL,
  PRIMARY KEY (`documentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `c_doc_assign`
--

CREATE TABLE IF NOT EXISTS `c_doc_assign` (
  `assignID` int(15) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) DEFAULT '0',
  `documentID` int(15) NOT NULL,
  `EmpID` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`assignID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_doc_lead`
--

CREATE TABLE IF NOT EXISTS `c_doc_lead` (
  `LID` int(15) NOT NULL AUTO_INCREMENT,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `documentid` varchar(36) DEFAULT NULL,
  `LeadID` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`LID`),
  KEY `docu_lead_oppo_id` (`LeadID`,`documentid`),
  KEY `docu_lead_docu_id` (`documentid`,`LeadID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_doc_opportunities`
--

CREATE TABLE IF NOT EXISTS `c_doc_opportunities` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `documentid` varchar(36) DEFAULT NULL,
  `OpportunityID` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docu_opps_oppo_id` (`OpportunityID`,`documentid`),
  KEY `docu_oppo_docu_id` (`documentid`,`OpportunityID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_lead`
--

CREATE TABLE IF NOT EXISTS `c_lead` (
  `leadID` int(20) NOT NULL AUTO_INCREMENT,
  `ProductID` varchar(50) NOT NULL,
  `product_price` float(10,2) NOT NULL,
  `type` varchar(50) NOT NULL,
  `FirstName` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LeadName` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `primary_email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `designation` varchar(100) NOT NULL,
  `company` varchar(50) NOT NULL,
  `Website` varchar(100) NOT NULL,
  `Address` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PersonalEmail` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignTo` text NOT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `Industry` varchar(50) NOT NULL,
  `AnnualRevenue` INT(20) NOT NULL,
  `NumEmployee` INT(10) NOT NULL,
  `lead_source` varchar(50) NOT NULL,
  `lead_status` varchar(50) NOT NULL,
  `Opportunity` varchar(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `JoiningDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `verification_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `LeadDate` date NOT NULL,
  `LastContactDate` date NOT NULL,
  `description` text NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  PRIMARY KEY (`leadID`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_opportunity`
--

CREATE TABLE IF NOT EXISTS `c_opportunity` (
  `OpportunityID` int(20) NOT NULL AUTO_INCREMENT,
  `LeadID` int(15) NOT NULL,
  `OpportunityName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Amount` int(15) NOT NULL,
  `OrgName` varchar(100) NOT NULL,
  `AssignTo` text NOT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` varchar(50) NOT NULL,
  `CustID` int(15) NOT NULL,
  `CloseDate` datetime NOT NULL,
  `lead_source` varchar(50) NOT NULL,
  `Status` varchar(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `SalesStage` varchar(50) NOT NULL,
  `OpportunityType` varchar(50) NOT NULL,
  `NextStep` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `Probability` int(15) NOT NULL,
  `Campaign_Source` varchar(255) NOT NULL,
  `campaignID` int(15) NOT NULL,
  `ContactName` varchar(50) NOT NULL,
  `forecast_amount` int(15) NOT NULL,
  `oppsite` varchar(100) NOT NULL,
  `AddedDate` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  PRIMARY KEY (`OpportunityID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_quotes`
--

CREATE TABLE IF NOT EXISTS `c_quotes` (
  `quoteid` int(19) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) DEFAULT NULL,
  `CustType` char(1) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `CustID` varchar(10) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `CustomerCompany` varchar(50) NOT NULL,
  `ShippingName` varchar(50) NOT NULL,
  `ShippingCompany` varchar(50) NOT NULL,
  `opportunityName` varchar(200) NOT NULL,
  `OpportunityID` int(19) DEFAULT NULL,
  `quotestage` varchar(200) DEFAULT NULL,
  `validtill` date DEFAULT NULL,
  `contactid` varchar(40) DEFAULT NULL,
  `quote_no` varchar(100) DEFAULT NULL,
  `carrier` varchar(200) DEFAULT NULL,
  `shipping` varchar(100) DEFAULT NULL,
  `assignTo` varchar(100) DEFAULT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `accountid` int(19) DEFAULT NULL,
  `description` text NOT NULL,
  `Freight` decimal(20,2) NOT NULL,
  `discountAmnt` decimal(20,2) NOT NULL,
  `terms` varchar(32) NOT NULL,
  `taxAmnt` decimal(20,2) NOT NULL,
  `TotalAmount` decimal(20,2) NOT NULL,
  `currency_id` int(19) NOT NULL DEFAULT '1',
  `conversion_rate` decimal(10,3) NOT NULL DEFAULT '1.000',
  `created_date` date NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `AdminID` int(18) NOT NULL,
  `AdminType` varchar(40) NOT NULL,
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Taxable` varchar(5) NOT NULL,
  `Reseller` varchar(5) NOT NULL,
  `ResellerNo` varchar(50) NOT NULL,
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `tax_auths` varchar(10) NOT NULL,
  `TaxRate` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  PRIMARY KEY (`quoteid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `c_quote_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_invoiced` int(11) NOT NULL,
  `qty_returned` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit_amount` double DEFAULT '0',
  `credit_amount` double DEFAULT '0',
  `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_id` int(10) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(20,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Taxable` varchar(5) NOT NULL,
  `req_item` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `quoteId` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Table structure for table `c_quotesbillads`
--


CREATE TABLE IF NOT EXISTS `c_assign_emp` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `activityID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `parent_type` varchar(30) NOT NULL,
  `parentID` int(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `eventID` (`activityID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `c_quotesbillads` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `quoteid` int(15) DEFAULT NULL,
  `bill_city` varchar(30) DEFAULT NULL,
  `bill_code` varchar(30) DEFAULT NULL,
  `bill_country` varchar(30) DEFAULT NULL,
  `bill_state` varchar(30) DEFAULT NULL,
  `bill_street` text,
  `bill_pobox` varchar(30) DEFAULT NULL,
  `ship_city` varchar(50) NOT NULL,
  `ship_code` varchar(30) NOT NULL,
  `ship_country` varchar(50) NOT NULL,
  `ship_state` varchar(50) NOT NULL,
  `ship_street` text NOT NULL,
  `ship_pobox` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `c_quotes_products`
--

CREATE TABLE IF NOT EXISTS `c_quotes_products` (
  `qtpid` int(11) NOT NULL AUTO_INCREMENT,
  `quoteId` int(11) DEFAULT NULL,
  `productName` varchar(100) NOT NULL,
  `hdnProductId` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `comment` varchar(255) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `listPrice` decimal(18,2) DEFAULT '0.00',
  `discount_type` varchar(100) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `discount_percentage` varchar(100) DEFAULT NULL,
  `discount_amount` varchar(50) DEFAULT NULL,
  `qty_in_stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`qtpid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_quote_opp`
--

CREATE TABLE IF NOT EXISTS `c_quote_opp` (
  `qid` int(15) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) DEFAULT '0',
  `quoteID` varchar(36) DEFAULT NULL,
  `opportunityName` varchar(36) DEFAULT NULL,
  `opportunityID` int(15) DEFAULT NULL,
  `mode_type` varchar(50) NOT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_ticket`
--

CREATE TABLE IF NOT EXISTS `c_ticket` (
  `TicketID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(15) NOT NULL,
  `title` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignedTo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignType` varchar(30) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `category` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `day` int(15) NOT NULL,
  `hours` int(15) NOT NULL,
  `priority` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` text NOT NULL,
  `solution` text NOT NULL,
  `Status` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `parent_type` varchar(50) NOT NULL,
  `parentID` int(15) NOT NULL,
  `ticketDate` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `CustID` int(11) NOT NULL,
  PRIMARY KEY (`TicketID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `c_territory` (
 `TerritoryID` int(11) NOT NULL AUTO_INCREMENT,
 `Name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `ParentID` int(100) NOT NULL DEFAULT '0',
 `Level` int(10) unsigned NOT NULL,
 `Status` int(1) NOT NULL DEFAULT '1',
 `NumSubTerritory` int(11) NOT NULL DEFAULT '0',
 `sort_order` int(10) NOT NULL,
 `AddedDate` date NOT NULL,
 PRIMARY KEY (`TerritoryID`),
 KEY `TerritoryID` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `c_territory_assign` (
  `AssignID` int(20) NOT NULL AUTO_INCREMENT,
  `TerritoryID` text NOT NULL,
  `AssignType` varchar(15) NOT NULL,
  `AssignTo` int(20) NOT NULL,
  `ManagerID` int(20) NOT NULL,
  `AddedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`AssignID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `c_territory_rule` (
 `TRID` int(11) NOT NULL AUTO_INCREMENT,
 `TerritoryID` int(11) unsigned NOT NULL,
 `SalesPersonID` int(11) unsigned NOT NULL,
 `SalesPerson` varchar(100) NOT NULL,
 `CreatedDate` date NOT NULL,
 `IPAddress` varchar(100) NOT NULL,
 PRIMARY KEY (`TRID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `c_territory_rule_location` (
 `TRLID` int(11) NOT NULL AUTO_INCREMENT,
 `TRID` int(11) NOT NULL,
 `country` int(11) NOT NULL,
 `state` text NOT NULL,
 `city` text NOT NULL,
 PRIMARY KEY (`TRLID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
-- --------------------------------------------------------

--
-- Table structure for table `dashboard_icon`
--

CREATE TABLE IF NOT EXISTS `dashboard_icon` (
  `IconID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ModuleID` int(10) NOT NULL,
  `EditPage` tinyint(1) NOT NULL DEFAULT '0',
  `IframeFancy` char(1) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Display` tinyint(1) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  `IconType` tinyint(1) NOT NULL,
  `Default` tinyint(1) NOT NULL,
  PRIMARY KEY (`IconID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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

CREATE TABLE IF NOT EXISTS `emails` (
  `templateID` int(11) NOT NULL AUTO_INCREMENT,
  `depID` int(10) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `Note` varchar(255) NOT NULL,
  `Important` text NOT NULL,
  `Subject` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `OrderBy` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`templateID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



--
-- Table structure for table `email_cat`
--


CREATE TABLE IF NOT EXISTS `email_cat` (
  `CatID` int(10) NOT NULL AUTO_INCREMENT,
  `department` int(15) NOT NULL,
  `Name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OrderLevel` int(15) NOT NULL,
  PRIMARY KEY (`CatID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `TemplateID` int(11) NOT NULL AUTO_INCREMENT,
  `CatID` int(10) NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `arr_field` text NOT NULL,
  `Status` int(1) DEFAULT '1',
  PRIMARY KEY (`TemplateID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_cart`
--

CREATE TABLE IF NOT EXISTS `e_cart` (
  `CartID` int(11) NOT NULL AUTO_INCREMENT,
  `Cid` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `PriceBeforeQuantityDiscount` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `Quantity` int(20) NOT NULL,
  `IsTaxable` enum('Yes','No') COLLATE latin1_general_ci NOT NULL,
  `TaxClassId` int(11) unsigned NOT NULL,
  `TaxRate` float(10,2) NOT NULL,
  `TaxDescription` text COLLATE latin1_general_ci NOT NULL,
  `FreeShipping` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `Options` text COLLATE latin1_general_ci NOT NULL,
  `Weight` decimal(10,2) unsigned NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`CartID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_catalog_attributes`
--

CREATE TABLE IF NOT EXISTS `e_catalog_attributes` (
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Gaid` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `cid` (`Cid`),
  KEY `gaid` (`Gaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_categories`
--

CREATE TABLE IF NOT EXISTS `e_categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `MetaTitle` text NOT NULL,
  `MetaKeyword` text NOT NULL,
  `MetaDescription` text NOT NULL,
  `CategoryDescription` text NOT NULL,
  `Image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ParentID` int(100) NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  `NumSubcategory` int(11) NOT NULL DEFAULT '0',
  `NumProducts` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(10) NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `categoryID` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_comments`
--

CREATE TABLE IF NOT EXISTS `e_comments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `StoreID` int(11) NOT NULL,
  `TopicID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Comment` text COLLATE latin1_general_ci NOT NULL,
  `CommentDetail` text COLLATE latin1_general_ci NOT NULL,
  `AttachFile1` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `AttachFile2` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `CommentDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CommentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_courier`
--

CREATE TABLE IF NOT EXISTS `e_courier` (
  `courier_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `price` float(10,2) DEFAULT NULL,
  `detail` text COLLATE latin1_general_ci NOT NULL,
  `fixed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`courier_id`),
  KEY `country_id` (`country_id`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_customers`
--

CREATE TABLE IF NOT EXISTS `e_customers` (
  `Cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SessionId` varchar(48) NOT NULL DEFAULT '',
  `SessionDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Removed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Newsletters` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `FirstName` varchar(24) NOT NULL DEFAULT '',
  `LastName` varchar(36) NOT NULL DEFAULT '',
  `Login` varchar(24) NOT NULL DEFAULT '',
  `Password` varchar(64) NOT NULL DEFAULT '',
  `Company` varchar(64) NOT NULL DEFAULT '',
  `Address1` varchar(225) NOT NULL DEFAULT '',
  `Address2` varchar(225) NOT NULL DEFAULT '',
  `City` varchar(48) NOT NULL DEFAULT '',
  `OtherCity` varchar(255) NOT NULL,
  `State` int(10) unsigned NOT NULL DEFAULT '3',
  `OtherState` varchar(48) NOT NULL DEFAULT '',
  `ZipCode` varchar(16) NOT NULL DEFAULT '',
  `Country` int(10) unsigned NOT NULL DEFAULT '1',
  `Email` varchar(64) NOT NULL DEFAULT '',
  `Phone` varchar(32) NOT NULL DEFAULT '',
  `ShippingName` varchar(255) NOT NULL,
  `ShippingCompany` varchar(255) NOT NULL,
  `ShippingAddress1` varchar(255) NOT NULL,
  `ShippingAddress2` varchar(100) NOT NULL,
  `ShippingCity` varchar(100) NOT NULL,
  `OtherShippingCity` varchar(100) NOT NULL,
  `ShippingState` varchar(100) NOT NULL,
  `OtherShippingState` varchar(100) NOT NULL,
  `ShippingCountry` varchar(100) NOT NULL,
  `ShippingZip` varchar(100) NOT NULL,
  `ShippingPhone` varchar(100) NOT NULL,
  `LastUpdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `FacebookUser` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `FacebookId` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`Cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_customer_group`
--

CREATE TABLE IF NOT EXISTS `e_customer_group` (
  `GroupID` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(255) NOT NULL,
  `GroupCreated` varchar(25) NOT NULL DEFAULT 'admin',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`GroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_delhivery_status`
--

CREATE TABLE IF NOT EXISTS `e_delhivery_status` (
  `delhiveryID` int(11) NOT NULL AUTO_INCREMENT,
  `DelhiveryStatus` varchar(255) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`delhiveryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_discounts`
--

CREATE TABLE IF NOT EXISTS `e_discounts` (
  `DID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Active` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Min` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Max` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Discount` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Type` enum('amount','percent') NOT NULL DEFAULT 'amount',
  PRIMARY KEY (`DID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_emails`
--

CREATE TABLE IF NOT EXISTS `e_emails` (
  `EmailId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Email` varchar(64) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Created_Date` datetime NOT NULL,
  PRIMARY KEY (`EmailId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_email_signup`
--

CREATE TABLE IF NOT EXISTS `e_email_signup` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(80) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`MemberID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_feedback`
--

CREATE TABLE IF NOT EXISTS `e_feedback` (
  `feedbackID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(10) NOT NULL,
  `Name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Comment` text COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `feedbackDate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`feedbackID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_global_attributes`
--

CREATE TABLE IF NOT EXISTS `e_global_attributes` (
  `Gaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AttributeType` enum('select','radio','text','textarea') NOT NULL DEFAULT 'select',
  `IsGlobal` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Caption` varchar(255) NOT NULL DEFAULT '',
  `TextLength` int(10) unsigned NOT NULL DEFAULT '0',
  `Options` text,
  PRIMARY KEY (`Gaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_manufacturers`
--

CREATE TABLE IF NOT EXISTS `e_manufacturers` (
  `Mid` int(11) NOT NULL AUTO_INCREMENT,
  `Mname` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Mcode` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Mdetail` text COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_members`
--

CREATE TABLE IF NOT EXISTS `e_members` (
  `MemberID` int(20) NOT NULL,
  `WebsiteStoreOption` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `Counter` int(20) NOT NULL AUTO_INCREMENT,
  `Type` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT 'Buyer',
  `templateID` tinyint(12) NOT NULL,
  `templatePage` int(10) NOT NULL DEFAULT '1',
  `MembershipID` int(11) NOT NULL DEFAULT '1',
  `UserName` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `FirstName` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Password` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `CompanyName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ContactPerson` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `Position` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `RegistrationNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `VatNumber` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `VatPercentage` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `TaxType` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ContactNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `TagLine` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Ranking` int(20) NOT NULL,
  `Fax` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) COLLATE latin1_general_ci NOT NULL,
  `Banner` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `PostCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `isd_code` int(10) NOT NULL,
  `Phone` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `IDNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `SkypeAddress` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `AlternateEmail` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `JoiningDate` datetime NOT NULL,
  `ExpiryDate` datetime NOT NULL,
  `SecurityQuestion` text COLLATE latin1_general_ci NOT NULL,
  `Answer` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Featured` varchar(3) COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `FeaturedWeb` varchar(3) COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `verification_code` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ExpiryMailSent` int(1) NOT NULL,
  `payment_gateway` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PaidMember` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'n',
  `amount_recived` float(10,2) NOT NULL,
  `FeaturedAmount` float(10,2) NOT NULL,
  `Impression` int(20) NOT NULL,
  `ImpressionCount` int(20) NOT NULL,
  `FeaturedStart` date NOT NULL,
  `FeaturedEnd` date NOT NULL,
  `FeaturedType` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `EmailSubscribe` tinyint(1) NOT NULL DEFAULT '0',
  `SmsSubscribe` tinyint(1) NOT NULL DEFAULT '0',
  `BillingFirstName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `BillingLastName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `BillingCompany` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `BillingAddress` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `BillingLandline` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `BillingEmail` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `PostingApproval` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `CreditCard` varchar(5) COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `MaxEmail` int(10) NOT NULL DEFAULT '0',
  `MaxSms` int(10) NOT NULL DEFAULT '0',
  `FeaturedWebType` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `WebImpression` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `WebImpressionCount` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `FeaturedWebStart` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `FeaturedWebEnd` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `FeaturedWebAmount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `AreaCode` varchar(20) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`Counter`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_membership`
--

CREATE TABLE IF NOT EXISTS `e_membership` (
  `MembershipID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Description` text COLLATE latin1_general_ci NOT NULL,
  `Validity` int(2) NOT NULL,
  `Price` decimal(8,2) NOT NULL,
  `ReferralAmount` float(10,2) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `MaxProduct` int(10) NOT NULL DEFAULT '5',
  `MaxProductImage` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `MaxEmail` int(10) NOT NULL DEFAULT '0',
  `MaxSms` int(10) NOT NULL DEFAULT '0',
  `sort_order` int(10) NOT NULL,
  PRIMARY KEY (`MembershipID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_membership_history`
--

CREATE TABLE IF NOT EXISTS `e_membership_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `MembershipID` int(11) NOT NULL,
  `PackageName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Price` float(10,2) NOT NULL,
  `PaymentGateway` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Payment` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_newsletter_template`
--

CREATE TABLE IF NOT EXISTS `e_newsletter_template` (
  `Templapte_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Template_Subject` varchar(255) NOT NULL,
  `Template_Name` varchar(255) NOT NULL,
  `Template_Content` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Created_Date` datetime NOT NULL,
  PRIMARY KEY (`Templapte_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_orderdetail`
--

CREATE TABLE IF NOT EXISTS `e_orderdetail` (
  `OrderDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ProductOptions` text COLLATE latin1_general_ci NOT NULL,
  `Quantity` int(20) NOT NULL,
  `Price` float(10,2) NOT NULL,
  `TaxRate` float(10,2) NOT NULL,
  `TaxDescription` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`OrderDetailId`),
  KEY `OrderID` (`OrderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_orders`
--

CREATE TABLE IF NOT EXISTS `e_orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Cid` int(11) NOT NULL,
  `ProductIDs` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `currency_id` int(10) NOT NULL DEFAULT '11',
  `Currency` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `CurrencySymbol` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `OrderDate` datetime NOT NULL,
  `OrderComplatedDate` datetime NOT NULL,
  `SubTotalPrice` float(10,2) NOT NULL,
  `TotalPrice` float(10,2) NOT NULL,
  `TotalQuantity` int(20) NOT NULL,
  `Tax` float(10,2) NOT NULL,
  `Shipping` float(10,2) NOT NULL,
  `ShippingMethod` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Weight` float(10,2) NOT NULL,
  `WeightUnit` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `DiscountAmount` float(10,2) NOT NULL,
  `DiscountValue` float(10,2) NOT NULL,
  `DiscountType` enum('percent','amount','none') COLLATE latin1_general_ci NOT NULL DEFAULT 'none',
  `PromoCampaignID` int(10) NOT NULL,
  `PromoDiscountAmount` float(10,2) NOT NULL,
  `BillingName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `BillingCompany` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `BillingAddress` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `BillingCity` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `BillingState` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `BillingCountry` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `BillingZip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Phone` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `ShippingName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ShippingCompany` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ShippingAddress` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `ShippingCity` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ShippingState` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ShippingCountry` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ShippingZip` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ShippingPhone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ShippingAddressType` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ShippingStatus` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymentStatus` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `OrderStatus` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymentGateway` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PaymentGatewayID` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `DelivaryDate` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `TrackNumber` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `TrackMsg` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `TrackMsgDate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `SecurityId` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `MemberID` (`Cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_package`
--

CREATE TABLE IF NOT EXISTS `e_package` (
  `PackageID` int(11) NOT NULL AUTO_INCREMENT,
  `CatID` int(10) NOT NULL DEFAULT '1',
  `Type` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `Name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Impression` int(10) NOT NULL,
  `Validity` int(10) NOT NULL,
  `Price` decimal(8,2) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PackageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_package_category`
--

CREATE TABLE IF NOT EXISTS `e_package_category` (
  `CatID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`CatID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_pages`
--

CREATE TABLE IF NOT EXISTS `e_pages` (
  `PageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Options` set('top','bottom','left','right') NOT NULL DEFAULT 'top',
  `UrlCustom` varchar(128) NOT NULL DEFAULT '',
  `UrlHash` varchar(32) NOT NULL,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `MetaKeywords` text,
  `MetaTitle` text,
  `MetaDescription` text,
  `Title` varchar(255) NOT NULL DEFAULT '',
  `Content` text,
  PRIMARY KEY (`PageId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_payment_gateway`
--

CREATE TABLE IF NOT EXISTS `e_payment_gateway` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `PaymentMethodName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymetMethodId` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymentMethodUrl` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymetMethodType` enum('cc','check','ipn','custom') COLLATE latin1_general_ci NOT NULL DEFAULT 'custom',
  `PaymentMethodTitle` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymentMethodMessage` text COLLATE latin1_general_ci NOT NULL,
  `Priority` int(11) NOT NULL,
  `PaymentMethodDescription` text COLLATE latin1_general_ci NOT NULL,
  `Status` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `PaymentCofigure` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`PaymentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_payment_transactions`
--

CREATE TABLE IF NOT EXISTS `e_payment_transactions` (
  `TID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OrderId` int(10) unsigned NOT NULL DEFAULT '0',
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Completed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Extra` text,
  `PaymentType` varchar(100) NOT NULL DEFAULT '',
  `PaymentGateway` varchar(100) NOT NULL DEFAULT '',
  `PaymentResponse` text,
  `OrderSubtotalAmount` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `OrderTotalAmount` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `ShippingMethod` varchar(100) NOT NULL DEFAULT '0',
  `ShippingSubmethod` varchar(100) NOT NULL DEFAULT '',
  `ShippingAmount` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `TaxAmount` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `IsSuccess` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`TID`),
  KEY `oid` (`OrderId`),
  KEY `uid` (`Cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_price_refine`
--

CREATE TABLE IF NOT EXISTS `e_price_refine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `range` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_products`
--

CREATE TABLE IF NOT EXISTS `e_products` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `ProductSku` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Detail` text COLLATE latin1_general_ci NOT NULL,
  `ShortDetail` text COLLATE latin1_general_ci NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Mid` int(11) NOT NULL,
  `Image` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Price` decimal(20,5) NOT NULL,
  `Price2` decimal(20,5) NOT NULL,
  `Quantity` int(20) NOT NULL,
  `InventoryControl` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `InventoryRule` enum('Hide','OutOfStock') COLLATE latin1_general_ci NOT NULL DEFAULT 'Hide',
  `StockWarning` int(10) unsigned NOT NULL,
  `Featured` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `Status` tinyint(1) NOT NULL,
  `IsTaxable` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `TaxClassId` int(11) unsigned NOT NULL DEFAULT '0',
  `TaxRate` decimal(20,5) NOT NULL DEFAULT '-1.00000',
  `Weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `FreeShipping` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `ShippingPrice` decimal(20,5) NOT NULL,
  `AttributesCount` int(11) NOT NULL DEFAULT '0',
  `MetaTitle` text COLLATE latin1_general_ci NOT NULL,
  `MetaKeywords` text COLLATE latin1_general_ci NOT NULL,
  `MetaDescription` text COLLATE latin1_general_ci NOT NULL,
  `UrlCustom` text COLLATE latin1_general_ci NOT NULL,
  `AddedDate` date NOT NULL,
  `ViewedDate` date NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_attributes`
--

CREATE TABLE IF NOT EXISTS `e_products_attributes` (
  `paid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_type` enum('select','radio','text','textarea') NOT NULL DEFAULT 'select',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `gaid` int(10) unsigned NOT NULL DEFAULT '0',
  `is_modifier` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `track_inventory` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `caption` varchar(255) NOT NULL DEFAULT '',
  `text_length` int(10) unsigned NOT NULL DEFAULT '0',
  `options` text,
  PRIMARY KEY (`paid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_categories`
--

CREATE TABLE IF NOT EXISTS `e_products_categories` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `pid` (`pid`,`cid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_images`
--

CREATE TABLE IF NOT EXISTS `e_products_images` (
  `Iid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ProductID` int(12) NOT NULL,
  `Image` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `alt_text` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`Iid`),
  KEY `ProductID` (`ProductID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_quantity_discounts`
--

CREATE TABLE IF NOT EXISTS `e_products_quantity_discounts` (
  `qd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `range_min` int(10) unsigned NOT NULL DEFAULT '0',
  `range_max` int(10) unsigned NOT NULL DEFAULT '0',
  `discount` double(10,5) NOT NULL DEFAULT '0.00000',
  `discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `customer_type` enum('customer','wholesale') NOT NULL DEFAULT 'customer',
  PRIMARY KEY (`qd_id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_reviews`
--

CREATE TABLE IF NOT EXISTS `e_products_reviews` (
  `ReviewId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Pid` int(10) unsigned NOT NULL,
  `Cid` int(10) unsigned NOT NULL,
  `ReviewTitle` varchar(255) NOT NULL,
  `ReviewText` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Rating` tinyint(1) NOT NULL,
  `DateCreated` datetime DEFAULT NULL,
  PRIMARY KEY (`ReviewId`),
  KEY `user_id` (`Cid`),
  KEY `product_id` (`Pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_categories`
--

CREATE TABLE IF NOT EXISTS `e_promo_categories` (
  `PromoID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  PRIMARY KEY (`PromoID`,`CID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_codes`
--

CREATE TABLE IF NOT EXISTS `e_promo_codes` (
  `PromoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL DEFAULT '',
  `PromoCode` varchar(250) NOT NULL DEFAULT '',
  `PromoType` enum('Global','Product') NOT NULL DEFAULT 'Global',
  `CustomerGroupID` varchar(255) NOT NULL,
  `DateStart` date NOT NULL DEFAULT '0000-00-00',
  `DateStop` date NOT NULL DEFAULT '0000-00-00',
  `UsesTotal` int(10) NOT NULL,
  `UsesCustomer` int(10) NOT NULL,
  `Active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `MinAmount` float(10,2) NOT NULL,
  `Discount` float(10,2) NOT NULL,
  `DiscountType` enum('amount','percent') NOT NULL DEFAULT 'amount',
  `Global` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`PromoID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_history`
--

CREATE TABLE IF NOT EXISTS `e_promo_history` (
  `PromoHistoryID` int(11) NOT NULL AUTO_INCREMENT,
  `PromoID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `Cid` int(11) NOT NULL,
  `Amount` float(10,2) NOT NULL,
  `DateAdded` date NOT NULL,
  PRIMARY KEY (`PromoHistoryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_products`
--

CREATE TABLE IF NOT EXISTS `e_promo_products` (
  `PromoID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  PRIMARY KEY (`PromoID`,`ProductID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_ranking`
--

CREATE TABLE IF NOT EXISTS `e_ranking` (
  `RankingID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `RaterID` int(11) NOT NULL,
  `Points` int(20) NOT NULL DEFAULT '0',
  `Message` text COLLATE latin1_general_ci NOT NULL,
  `Date` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`RankingID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_recommended_products`
--

CREATE TABLE IF NOT EXISTS `e_recommended_products` (
  `RecommendID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `RecommendedProductID` int(10) NOT NULL,
  PRIMARY KEY (`RecommendID`,`ProductID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_report`
--

CREATE TABLE IF NOT EXISTS `e_report` (
  `reportID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Phone` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `Content` text COLLATE latin1_general_ci NOT NULL,
  `WhyOffensive` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`reportID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_settings`
--

CREATE TABLE IF NOT EXISTS `e_settings` (
  `visible` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `input_type` varchar(100) NOT NULL DEFAULT '',
  `GroupID` int(10) unsigned NOT NULL DEFAULT '0',
  `GroupName` varchar(100) NOT NULL DEFAULT '',
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Value` text,
  `Options` text NOT NULL,
  `DefaultValue` varchar(100) NOT NULL DEFAULT '',
  `Validation` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Caption` varchar(100) DEFAULT NULL,
  `Description` text,
  UNIQUE KEY `name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_shipping_custom_rates`
--

CREATE TABLE IF NOT EXISTS `e_shipping_custom_rates` (
  `Srid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Ssid` int(10) unsigned NOT NULL DEFAULT '0',
  `RateMin` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `RateMax` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `Base` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `Price` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `PriceType` enum('amount','percentage') NOT NULL DEFAULT 'amount',
  PRIMARY KEY (`Srid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_shipping_selected`
--

CREATE TABLE IF NOT EXISTS `e_shipping_selected` (
  `Ssid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CarrierId` varchar(100) NOT NULL DEFAULT 'custom',
  `CarrierName` varchar(100) NOT NULL DEFAULT '',
  `MethodId` varchar(100) NOT NULL DEFAULT '',
  `MethodName` varchar(100) NOT NULL DEFAULT '',
  `Priority` tinyint(4) NOT NULL DEFAULT '0',
  `Country` text,
  `State` text,
  `WeightMin` decimal(10,2) NOT NULL DEFAULT '0.00',
  `WeightMax` decimal(10,2) NOT NULL DEFAULT '1000.00',
  `Fee` decimal(20,5) NOT NULL DEFAULT '0.00000',
  `FeeType` enum('amount','percent') NOT NULL DEFAULT 'amount',
  `Exclude` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Notes` text,
  PRIMARY KEY (`Ssid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_tax_classes`
--

CREATE TABLE IF NOT EXISTS `e_tax_classes` (
  `ClassId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(128) NOT NULL DEFAULT '',
  `ClassDescription` varchar(255) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`ClassId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_tax_rates`
--

CREATE TABLE IF NOT EXISTS `e_tax_rates` (
  `RateId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClassId` int(10) unsigned NOT NULL DEFAULT '0',
  `Coid` int(11) unsigned NOT NULL,
  `Stid` int(11) unsigned NOT NULL,
  `TaxRate` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `UserLevel` varchar(100) NOT NULL,
  `RateDescription` varchar(255) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`RateId`),
  KEY `class_id` (`ClassId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_users_shipping_address`
--

CREATE TABLE IF NOT EXISTS `e_users_shipping_address` (
  `Csid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `IsPrimary` enum('Yes','No') NOT NULL DEFAULT 'No',
  `AddressType` enum('Business','Residential') NOT NULL DEFAULT 'Residential',
  `Name` varchar(64) NOT NULL DEFAULT '',
  `Company` varchar(64) NOT NULL DEFAULT '',
  `Address1` varchar(225) NOT NULL DEFAULT '',
  `Address2` varchar(225) NOT NULL DEFAULT '',
  `City` varchar(48) NOT NULL DEFAULT '',
  `OtherCity` varchar(255) NOT NULL,
  `State` int(10) unsigned NOT NULL DEFAULT '0',
  `OtherState` varchar(255) NOT NULL DEFAULT '',
  `Zip` varchar(16) NOT NULL DEFAULT '',
  `Phone` varchar(255) NOT NULL,
  `Country` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Csid`),
  KEY `uid` (`Cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_users_wishlist`
--

CREATE TABLE IF NOT EXISTS `e_users_wishlist` (
  `Wlid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(64) NOT NULL DEFAULT '',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UpdateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Wlid`),
  KEY `uid` (`Cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_users_wishlist_products`
--

CREATE TABLE IF NOT EXISTS `e_users_wishlist_products` (
  `Wlpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Wlid` int(10) unsigned NOT NULL DEFAULT '0',
  `ProductId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttributeId` text,
  `Options` text,
  PRIMARY KEY (`Wlpid`),
  KEY `wlid` (`Wlid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_voucher`
--

CREATE TABLE IF NOT EXISTS `e_voucher` (
  `voucherID` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `detail` text COLLATE latin1_general_ci NOT NULL,
  `DiscountOver` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Discount` float(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `StartDate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `EndDate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`voucherID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `f_reconcile` (
  `ReconcileID` int(11) NOT NULL AUTO_INCREMENT,
  `Year` varchar(10) NOT NULL,
  `Month` varchar(10) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `Status` varchar(25) NOT NULL,
  `EndingBankBalance` float(10,2) NOT NULL,
  `TotalDebitByCheck` float(10,2) NOT NULL,
  `TotalCreditByCheck` float(10,2) NOT NULL,
  `TotalDebitCreditByCheck` float(10,2) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdateDate` date NOT NULL,
  `LocationID` int(11) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  PRIMARY KEY (`ReconcileID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `f_reconcile_transaction` (
 `TransactionID` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `ReconcileID` int(11) NOT NULL,
 `PaymentID` int(11) NOT NULL,
 PRIMARY KEY (`TransactionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `f_archive_account_type` (
  `AccountTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `LocationID` int(11) unsigned NOT NULL,
  `AccountType` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `flag` tinyint(2) NOT NULL DEFAULT '0',
  `CreatedDate` date NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`AccountTypeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Table structure for table `f_archive_bank_account`
--

CREATE TABLE IF NOT EXISTS `f_archive_bank_account` (
  `BankAccountID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentAccountID` int(11) unsigned NOT NULL,
  `BankName` varchar(100) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `AccountNumber` varchar(100) NOT NULL,
  `AccountType` int(11) unsigned NOT NULL,
  `AccountCode` varchar(30) NOT NULL,
  `Address` text NOT NULL,
  `LocationID` int(11) NOT NULL,
  `Balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(100) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `OrderBy` int(11) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdateddDate` date NOT NULL,
  `CashFlag` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`BankAccountID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_deposit`
--

CREATE TABLE IF NOT EXISTS `f_archive_deposit` (
  `DepositID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) unsigned NOT NULL,
  `Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `DepositDate` date NOT NULL,
  `ReceivedFrom` int(11) unsigned NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `ReferenceNo` varchar(150) NOT NULL,
  `Comment` text NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`DepositID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_expense`
--

CREATE TABLE IF NOT EXISTS `f_archive_expense` (
  `ExpenseID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `ExpenseTypeID` int(11) unsigned NOT NULL,
  `PaymentDate` date NOT NULL,
  `BankAccount` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `PaidTo` varchar(30) NOT NULL,
  `ReferenceNo` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `IPAddress` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`ExpenseID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_gerenal_journal`
--

CREATE TABLE IF NOT EXISTS `f_archive_gerenal_journal` (
  `JournalID` int(11) NOT NULL AUTO_INCREMENT,
  `JournalNo` varchar(30) NOT NULL,
  `JournalDate` date NOT NULL,
  `JournalType` varchar(30) NOT NULL,
  `JournalInterval` varchar(30) NOT NULL,
  `JournalMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  `JournalDateFrom` date NOT NULL,
  `JournalDateTo` date NOT NULL,
  `JournalStartDate` varchar(4) NOT NULL,
  `JournalMemo` text NOT NULL,
  `TotalDebit` float(10,2) NOT NULL DEFAULT '0.00',
  `TotalCredit` float(10,2) NOT NULL DEFAULT '0.00',
  `LocationID` int(11) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`JournalID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_gerenal_journal_attachment`
--

CREATE TABLE IF NOT EXISTS `f_archive_gerenal_journal_attachment` (
  `AttachmentID` int(11) NOT NULL AUTO_INCREMENT,
  `JournalID` int(11) NOT NULL,
  `CmpID` int(11) NOT NULL,
  `AttachmentNote` text NOT NULL,
  `AttachmentFile` varchar(255) NOT NULL,
  `CreatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`AttachmentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_gerenal_journal_entry`
--

CREATE TABLE IF NOT EXISTS `f_archive_gerenal_journal_entry` (
  `JournalEntryID` int(11) NOT NULL AUTO_INCREMENT,
  `JournalID` int(11) NOT NULL,
  `AccountType` varchar(100) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `DebitAmnt` float(10,2) NOT NULL DEFAULT '0.00',
  `CreditAmnt` float(10,2) NOT NULL DEFAULT '0.00',
  `EntityType` varchar(30) NOT NULL,
  `EntityName` varchar(100) NOT NULL,
  `EntityID` varchar(50) NOT NULL,
  PRIMARY KEY (`JournalEntryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_income`
--

CREATE TABLE IF NOT EXISTS `f_archive_income` (
  `IncomeID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `EntryType` varchar(50) NOT NULL,
  `GLCode` varchar(100) NOT NULL,
  `IncomeTypeID` int(11) unsigned NOT NULL,
  `PaymentDate` date NOT NULL,
  `BankAccount` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `ReceivedFrom` int(11) NOT NULL,
  `ReferenceNo` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `IPAddress` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`IncomeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_payments`
--

CREATE TABLE IF NOT EXISTS `f_archive_payments` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustCode` varchar(50) NOT NULL,
  `SuppCode` varchar(50) NOT NULL,
  `EmployeeID` int(11) unsigned NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `PurchaseID` varchar(100) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `DebitAmnt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `CreditAmnt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `AccountID` int(11) NOT NULL,
  `JournalID` int(11) unsigned NOT NULL,
  `IncomeID` int(11) unsigned NOT NULL,
  `ExpenseID` int(11) unsigned NOT NULL,
  `TransferID` int(11) unsigned NOT NULL,
  `DepositID` int(11) unsigned NOT NULL,
  `Method` varchar(250) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `EntryType` varchar(50) NOT NULL,
  `GLCode` varchar(100) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Comment` text NOT NULL,
  `PaymentType` varchar(100) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`PaymentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_transfer`
--

CREATE TABLE IF NOT EXISTS `f_archive_transfer` (
  `TransferID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TransferFrom` int(11) unsigned NOT NULL,
  `TransferTo` int(11) unsigned NOT NULL,
  `TransferAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TransferDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`TransferID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_deposit`
--

CREATE TABLE IF NOT EXISTS `f_deposit` (
  `DepositID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) unsigned NOT NULL,
  `Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `DepositDate` date NOT NULL,
  `ReceivedFrom` int(11) unsigned NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `ReferenceNo` varchar(150) NOT NULL,
  `Comment` text NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`DepositID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_expense`
--

CREATE TABLE IF NOT EXISTS `f_expense` (
  `ExpenseID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `ExpenseTypeID` int(11) unsigned NOT NULL,
  `PaymentDate` date NOT NULL,
  `BankAccount` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `PaidTo` varchar(30) NOT NULL,
  `ReferenceNo` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `IPAddress` varchar(100) NOT NULL DEFAULT '',
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `GlEntryType` varchar(50) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  PRIMARY KEY (`ExpenseID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_gerenal_journal`
--

CREATE TABLE IF NOT EXISTS `f_gerenal_journal` (
  `JournalID` int(11) NOT NULL AUTO_INCREMENT,
  `JournalNo` varchar(30) NOT NULL,
  `JournalDate` date NOT NULL,
  `JournalType` varchar(30) NOT NULL,
  `JournalDateFrom` date NOT NULL,
  `JournalDateTo` date NOT NULL,
  `JournalStartDate` varchar(4) NOT NULL,
  `JournalInterval` varchar(30) NOT NULL,
  `JournalMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  `JournalMemo` text NOT NULL,
  `TotalDebit` float(10,2) NOT NULL DEFAULT '0.00',
  `TotalCredit` float(10,2) NOT NULL DEFAULT '0.00',
  `LocationID` int(11) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`JournalID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_gerenal_journal_attachment`
--

CREATE TABLE IF NOT EXISTS `f_gerenal_journal_attachment` (
  `AttachmentID` int(11) NOT NULL AUTO_INCREMENT,
  `JournalID` int(11) NOT NULL,
  `CmpID` int(11) NOT NULL,
  `AttachmentNote` text NOT NULL,
  `AttachmentFile` varchar(255) NOT NULL,
  `CreatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`AttachmentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_gerenal_journal_entry`
--

CREATE TABLE IF NOT EXISTS `f_gerenal_journal_entry` (
  `JournalEntryID` int(11) NOT NULL AUTO_INCREMENT,
  `JournalID` int(11) NOT NULL,
  `AccountType` varchar(100) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `DebitAmnt` float(10,2) NOT NULL DEFAULT '0.00',
  `CreditAmnt` float(10,2) NOT NULL DEFAULT '0.00',
  `EntityType` varchar(30) NOT NULL,
  `EntityName` varchar(100) NOT NULL,
  `EntityID` varchar(50) NOT NULL,
  PRIMARY KEY (`JournalEntryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_income`
--

CREATE TABLE IF NOT EXISTS `f_income` (
  `IncomeID` int(11) NOT NULL AUTO_INCREMENT,
  `InvoiceID` varchar(30) NOT NULL,
  `PID` int(11) unsigned NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `EntryType` varchar(50) NOT NULL,
  `GLCode` varchar(100) NOT NULL,
  `IncomeTypeID` int(11) unsigned NOT NULL,
  `PaymentDate` date NOT NULL,
  `BankAccount` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `ReceivedFrom` int(11) NOT NULL,
  `ReferenceNo` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `IPAddress` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`IncomeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_payments`
--

CREATE TABLE IF NOT EXISTS `f_payments` (
  `PaymentID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustCode` varchar(50) NOT NULL,
  `SuppCode` varchar(50) NOT NULL,
  `EmployeeID` int(11) unsigned NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `PurchaseID` varchar(100) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `DebitAmnt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `CreditAmnt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `AccountID` int(11) NOT NULL,
  `JournalID` int(11) unsigned NOT NULL,
  `IncomeID` int(11) unsigned NOT NULL,
  `ExpenseID` int(11) unsigned NOT NULL,
  `TransferID` int(11) unsigned NOT NULL,
  `DepositID` int(11) unsigned NOT NULL,
  `Method` varchar(250) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `EntryType` varchar(50) NOT NULL,
  `GLCode` varchar(100) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Comment` text NOT NULL,
  `PaymentType` varchar(100) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`PaymentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_tax`
--

CREATE TABLE IF NOT EXISTS `f_tax` (
  `TaxID` int(11) NOT NULL AUTO_INCREMENT,
  `TaxName` varchar(100) NOT NULL,
  `TaxRate` float NOT NULL DEFAULT '0',
  `locationID` int(10) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`TaxID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_transfer`
--

CREATE TABLE IF NOT EXISTS `f_transfer` (
  `TransferID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TransferFrom` int(11) unsigned NOT NULL,
  `TransferTo` int(11) unsigned NOT NULL,
  `TransferAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TransferDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`TransferID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


--
-- Table structure for table `f_account_type`
--

CREATE TABLE IF NOT EXISTS `f_account_type` (
  `AccountTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `LocationID` int(11) unsigned NOT NULL,
  `AccountType` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `flag` tinyint(2) NOT NULL DEFAULT '0',
  `CreatedDate` date NOT NULL,
  `OrderBy` int(11) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`AccountTypeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `f_attribute`
--

CREATE TABLE IF NOT EXISTS `f_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) NOT NULL,
  `attribute` varchar(50) NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


--
-- Table structure for table `f_attribute_value`
--

CREATE TABLE IF NOT EXISTS `f_attribute_value` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1  ;



--
-- Table structure for table `f_bank_account`
--

CREATE TABLE IF NOT EXISTS `f_bank_account` (
  `BankAccountID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentAccountID` int(11) unsigned NOT NULL,
  `BankName` varchar(100) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `AccountNumber` varchar(100) NOT NULL,
  `AccountType` int(11) unsigned NOT NULL,
  `AccountCode` varchar(30) NOT NULL,
  `Address` text NOT NULL,
  `LocationID` int(11) NOT NULL,
  `Balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(100) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `OrderBy` int(11) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdateddDate` date NOT NULL,
  `CashFlag` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`BankAccountID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1  ;


CREATE TABLE IF NOT EXISTS `f_term` (
 `termID` int(20) NOT NULL AUTO_INCREMENT,
 `termName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `termDate` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `Day` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `Due` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `CreditLimit` decimal(10,2) NOT NULL,
 `Status` tinyint(1) NOT NULL,
 `UpdatedDate` date NOT NULL,
 PRIMARY KEY (`termID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `f_period_end` (
 `PeriodID` int(11) NOT NULL AUTO_INCREMENT,
 `PeriodYear` varchar(10) NOT NULL,
 `PeriodMonth` varchar(10) NOT NULL,
 `PeriodModule` varchar(50) NOT NULL,
 `PeriodStatus` varchar(10) NOT NULL,
 `PeriodCreatedDate` date NOT NULL,
 `PeriodUpdateDate` date NOT NULL,
 `LocationID` int(11) NOT NULL,
 `IPAddress` varchar(100) NOT NULL,
 PRIMARY KEY (`PeriodID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `f_multi_account_payment` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
`AccountID` int(11) NOT NULL,
`ExpenseID` int(11) NOT NULL,
`AccountName` varchar(250) NOT NULL,
`Amount` float(10,2) NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Dumping data for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `visible` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `input_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` int(10) NOT NULL,
  `group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_value` text COLLATE utf8_unicode_ci,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  `validation` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `dep_id` tinyint(2) NOT NULL,
  `priority` int(10) NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- --------------------------------------------------------






--
-- Table structure for table `h_advance`
--

CREATE TABLE IF NOT EXISTS `h_advance` (
  `AdvID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `Amount` varchar(30) NOT NULL,
  `IssueDate` date NOT NULL,
  `ApplyDate` date NOT NULL,
  `Status` varchar(15) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `AmountReturned` varchar(30) NOT NULL,
  `ReturnType` tinyint(1) NOT NULL,
  `ReturnDate` date NOT NULL,
  `ReturnPeriod` varchar(10) NOT NULL,
  `Returned` tinyint(1) NOT NULL,
  `Approved` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`AdvID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_advance_return`
--

CREATE TABLE IF NOT EXISTS `h_advance_return` (
  `ReturnID` int(20) NOT NULL AUTO_INCREMENT,
  `AdvID` int(21) NOT NULL,
  `ReturnAmount` varchar(30) NOT NULL,
  `ReturnDate` date NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`ReturnID`),
  KEY `AdvID` (`AdvID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_appraisal`
--

CREATE TABLE IF NOT EXISTS `h_appraisal` (
  `appraisalID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `CTC` varchar(30) NOT NULL,
  `Gross` varchar(30) NOT NULL,
  `NetSalary` varchar(30) NOT NULL,
  `AppraisalAmount` varchar(30) NOT NULL,
  `FromDate` date NOT NULL,
  `CTC_Old` varchar(30) NOT NULL,
  `Gross_Old` varchar(30) NOT NULL,
  `NetSalary_Old` varchar(30) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`appraisalID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_asset`
--

CREATE TABLE IF NOT EXISTS `h_asset` (
  `AssetID` int(20) NOT NULL AUTO_INCREMENT,
  `TagID` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `locationID` int(10) NOT NULL,
  `AssignID` int(10) NOT NULL,
  `RFID` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssetName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `SerialNumber` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Location` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Vendor` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Acquired` date NOT NULL,
  `Category` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Brand` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Model` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `WrStart` date NOT NULL,
  `WrEnd` date NOT NULL,
  `Status` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`AssetID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_asset_assign`
--

CREATE TABLE IF NOT EXISTS `h_asset_assign` (
  `AssignID` int(20) NOT NULL AUTO_INCREMENT,
  `AssetID` int(20) NOT NULL,
  `TagID` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssetName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `EmpID` int(10) NOT NULL,
  `EmpName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ExpectedReturnDate` date NOT NULL,
  `AssignedBy` int(10) NOT NULL,
  `AssignedByName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignDate` date NOT NULL,
  `ReturnDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`AssignID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_attendence`
--

CREATE TABLE IF NOT EXISTS `h_attendence` (
  `attID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `attDate` date NOT NULL,
  `InTime` varchar(20) NOT NULL,
  `OutTime` varchar(20) NOT NULL,
  `InComment` varchar(250) NOT NULL,
  `OutComment` varchar(250) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  PRIMARY KEY (`attID`),
  KEY `EmpID` (`EmpID`),
  KEY `attDate` (`attDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_attribute`
--

CREATE TABLE IF NOT EXISTS `h_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `h_attribute_value`
--

CREATE TABLE IF NOT EXISTS `h_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_bonus`
--

CREATE TABLE IF NOT EXISTS `h_bonus` (
  `BonusID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `IssueDate` date NOT NULL,
  `Year` varchar(4) NOT NULL,
  `Month` varchar(2) NOT NULL,
  `Paid` tinyint(1) NOT NULL,
  `Approved` tinyint(1) NOT NULL,
  `Status` varchar(15) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `Amount` varchar(10) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`BonusID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_candidate`
--

CREATE TABLE IF NOT EXISTS `h_candidate` (
  `CanID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `FirstName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UserName` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Gender` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date_of_birth` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Vacancy` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Salary` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `SalaryFrequency` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ExperienceYear` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ExperienceMonth` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Resume` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `InterviewStatus` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `TestTaken` varchar(250) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `JoiningDate` date NOT NULL,
  `OfferedDate` date NOT NULL,
  `ApplyDate` date NOT NULL,
  `Skill` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `EmpID1` int(11) NOT NULL,
  `EmpID2` int(11) NOT NULL,
  `EmpID3` int(11) NOT NULL,
  `EmpName1` varchar(80) NOT NULL,
  `EmpName2` varchar(80) NOT NULL,
  `EmpName3` varchar(80) NOT NULL,
  PRIMARY KEY (`CanID`),
  KEY `country_id` (`country_id`),
  KEY `locationID` (`locationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `h_commission` (
  `comID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `CommType` varchar(30) NOT NULL,
  `tierID` int(10) NOT NULL,
  `spiffID` int(10) NOT NULL,
  `SalesPersonType` varchar(30) NOT NULL,
  `Accelerator` varchar(3) NOT NULL,
  `AcceleratorPer` varchar(6) NOT NULL,
  PRIMARY KEY (`comID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;



--
-- Table structure for table `h_compensation`
--

CREATE TABLE IF NOT EXISTS `h_compensation` (
  `CompID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `WorkingDate` date NOT NULL,
  `Hours` decimal(10,2) NOT NULL,
  `ApplyDate` date NOT NULL,
  `Status` varchar(15) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `SupApproval` tinyint(1) NOT NULL,
  `Approved` tinyint(1) NOT NULL,
  `Compensated` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`CompID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_component`
--

CREATE TABLE IF NOT EXISTS `h_component` (
  `compID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `detail` text NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`compID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_component_cat`
--

CREATE TABLE IF NOT EXISTS `h_component_cat` (
  `catID` int(20) NOT NULL AUTO_INCREMENT,
  `catName` varchar(40) NOT NULL,
  `catGrade` varchar(40) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `Weightage1` int(3) NOT NULL,
  `Weightage2` int(3) NOT NULL,
  `Weightage3` int(3) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_declaration`
--

CREATE TABLE IF NOT EXISTS `h_declaration` (
  `decID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `Year` varchar(30) NOT NULL,
  `document` varchar(100) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`decID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_dec_cat`
--

CREATE TABLE IF NOT EXISTS `h_dec_cat` (
  `catID` int(20) NOT NULL AUTO_INCREMENT,
  `catName` varchar(40) NOT NULL,
  `catGrade` varchar(40) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_dec_head`
--

CREATE TABLE IF NOT EXISTS `h_dec_head` (
  `headID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(11) NOT NULL,
  `catID` int(11) NOT NULL,
  `heading` varchar(100) NOT NULL,
  `subheading` varchar(100) NOT NULL,
  `Default` tinyint(1) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`headID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_department`
--

CREATE TABLE IF NOT EXISTS `h_department` (
  `depID` int(11) NOT NULL AUTO_INCREMENT,
  `Division` int(10) NOT NULL,
  `Department` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`depID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_document`
--

CREATE TABLE IF NOT EXISTS `h_document` (
  `documentID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `document` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `docDate` date NOT NULL,
  `AdminID` int(20) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  PRIMARY KEY (`documentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_emergency`
--

CREATE TABLE IF NOT EXISTS `h_emergency` (
  `contactID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Relation` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Mobile` varchar(30) NOT NULL,
  `HomePhone` varchar(30) NOT NULL,
  `WorkPhone` varchar(30) NOT NULL,
  PRIMARY KEY (`contactID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_employee`
--

CREATE TABLE IF NOT EXISTS `h_employee` (
  `EmpID` int(20) NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) NOT NULL,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `EmpCode` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `FirstName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `UserName` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `Gender` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `Role` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `vUserInfo` tinyint(1) NOT NULL,
  `vAllRecord` tinyint(1) NOT NULL,
  `date_of_birth` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Nationality` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `MaritalStatus` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `catID` int(3) NOT NULL,
  `shiftID` int(10) NOT NULL,
  `Division` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Department` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `DeptHead` tinyint(1) NOT NULL,
  `JobTitle` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `JobType` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Salary` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `SalaryFrequency` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `ExperienceYear` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `ExperienceMonth` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) COLLATE latin1_general_ci NOT NULL,
  `Resume` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `PersonalEmail` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `JoiningDate` date NOT NULL,
  `ExitDate` date NOT NULL,
  `ExitDesc` text COLLATE latin1_general_ci NOT NULL,
  `ExitType` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ExitReason` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ExitClearence` tinyint(1) NOT NULL,
  `LastWorking` date NOT NULL,
  `FullFinal` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `verification_code` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Skill` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Graduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `PostGraduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Doctorate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `OtherGraduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `OtherPostGraduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `OtherDoctorate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Certification` text COLLATE latin1_general_ci NOT NULL,
  `UnderGraduate` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ProfessionalCourse` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherUnderGraduate` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherProfessionalCourse` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `TempPass` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PasswordUpdated` tinyint(4) NOT NULL,
  `ipaddress` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Supervisor` int(11) NOT NULL,
  `ReportingMethod` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ImmigrationType` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ImmigrationNo` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ImmigrationExp` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `IdProof` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `BloodGroup` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `SSN` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `BankName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `AccountName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `AccountNumber` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `IFSCCode` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `LastLogin` datetime NOT NULL,
  `CurrentLogin` datetime NOT NULL,
  `OrderBy` int(10) NOT NULL,
  `AddressProof1` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `AddressProof2` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`EmpID`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `h_employee_doc`
--

CREATE TABLE IF NOT EXISTS `h_employee_doc` (
  `DocID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `EmpID` int(10) NOT NULL,
  `DocType` varchar(20) NOT NULL,
  `DocumentTitle` varchar(50) NOT NULL,
  `Document` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`DocID`),
  KEY `DocID` (`EmpID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_employment`
--

CREATE TABLE IF NOT EXISTS `h_employment` (
  `employmentID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `EmployerName` varchar(50) NOT NULL,
  `Designation` varchar(40) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `JobProfile` varchar(250) NOT NULL,
  PRIMARY KEY (`employmentID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_entitlement`
--

CREATE TABLE IF NOT EXISTS `h_entitlement` (
  `EntID` int(10) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `LeaveType` varchar(30) NOT NULL,
  `Days` varchar(10) NOT NULL,
  `LeaveStart` date NOT NULL,
  `LeaveEnd` date NOT NULL,
  PRIMARY KEY (`EntID`),
  KEY `EmpID` (`EmpID`),
  KEY `LeaveType` (`LeaveType`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_expense_claim`
--

CREATE TABLE IF NOT EXISTS `h_expense_claim` (
  `ClaimID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `ClaimAmount` varchar(30) NOT NULL,
  `ExpenseReason` varchar(40) NOT NULL,
  `SancAmount` varchar(30) NOT NULL,
  `IssueDate` date NOT NULL,
  `ExpenseDate` date NOT NULL,
  `ApplyDate` date NOT NULL,
  `Status` varchar(15) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `ReturnDate` date NOT NULL,
  `Returned` tinyint(1) NOT NULL,
  `Approved` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  `document` varchar(50) NOT NULL,
  PRIMARY KEY (`ClaimID`),
  KEY `EmpID` (`EmpID`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `h_family`
--

CREATE TABLE IF NOT EXISTS `h_family` (
  `familyID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Relation` varchar(30) NOT NULL,
  `Age` varchar(10) NOT NULL,
  `Dependent` varchar(5) NOT NULL,
  PRIMARY KEY (`familyID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_holiday`
--

CREATE TABLE IF NOT EXISTS `h_holiday` (
  `holidayID` int(10) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `heading` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `holidayDate` date NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`holidayID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_kra`
--

CREATE TABLE IF NOT EXISTS `h_kra` (
  `kraID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(11) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `JobTitle` varchar(50) NOT NULL,
  `MinRating` varchar(5) NOT NULL,
  `MaxRating` varchar(5) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`kraID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_leave`
--

CREATE TABLE IF NOT EXISTS `h_leave` (
  `LeaveID` int(10) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `LeaveType` varchar(30) NOT NULL,
  `LeaveStart` date NOT NULL,
  `LeaveEnd` date NOT NULL,
  `Days` varchar(10) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `FromDateHalf` tinyint(1) NOT NULL,
  `ToDateHalf` tinyint(1) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `ApplyDate` date NOT NULL,
  PRIMARY KEY (`LeaveID`),
  KEY `EmpID` (`EmpID`),
  KEY `LeaveType` (`LeaveType`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_loan`
--

CREATE TABLE IF NOT EXISTS `h_loan` (
  `LoanID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `Amount` varchar(30) NOT NULL,
  `Rate` decimal(10,2) NOT NULL,
  `IssueDate` date NOT NULL,
  `ApplyDate` date NOT NULL,
  `Status` varchar(15) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `AmountReturned` varchar(30) NOT NULL,
  `ReturnType` tinyint(1) NOT NULL,
  `ReturnDate` date NOT NULL,
  `ReturnPeriod` varchar(10) NOT NULL,
  `Returned` tinyint(1) NOT NULL,
  `Approved` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`LoanID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_loan_return`
--

CREATE TABLE IF NOT EXISTS `h_loan_return` (
  `ReturnID` int(20) NOT NULL AUTO_INCREMENT,
  `LoanID` int(21) NOT NULL,
  `ReturnAmount` varchar(30) NOT NULL,
  `ReturnDate` date NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`ReturnID`),
  KEY `LoanID` (`LoanID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_news`
--

CREATE TABLE IF NOT EXISTS `h_news` (
  `newsID` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `newsDate` date NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`newsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_overtime`
--

CREATE TABLE IF NOT EXISTS `h_overtime` (
  `OvID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `attID` varchar(10) NOT NULL,
  `InTime` varchar(10) NOT NULL,
  `OutTime` varchar(10) NOT NULL,
  `OvDate` date NOT NULL,
  `WorkingHourStart` varchar(10) NOT NULL,
  `WorkingHourEnd` varchar(10) NOT NULL,
  `Hours` varchar(10) NOT NULL,
  `OvRate` varchar(5) NOT NULL,
  `HoursRate` varchar(10) NOT NULL,
  `updatedDate` datetime NOT NULL,
  PRIMARY KEY (`OvID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_participant`
--

CREATE TABLE IF NOT EXISTS `h_participant` (
  `partID` int(10) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `trainingID` int(10) NOT NULL,
  `AddedDate` varchar(30) NOT NULL,
  `Feedback` text NOT NULL,
  PRIMARY KEY (`partID`),
  UNIQUE KEY `EmpID` (`EmpID`,`trainingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_pay_cat`
--

CREATE TABLE IF NOT EXISTS `h_pay_cat` (
  `catID` int(20) NOT NULL AUTO_INCREMENT,
  `catName` varchar(40) NOT NULL,
  `catGrade` varchar(40) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_pay_head`
--

CREATE TABLE IF NOT EXISTS `h_pay_head` (
  `headID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(11) NOT NULL,
  `catID` int(11) NOT NULL,
  `catEmp` int(10) NOT NULL,
  `HeadType` varchar(20) NOT NULL,
  `heading` varchar(40) NOT NULL,
  `subheading` varchar(50) NOT NULL,
  `Percentage` int(3) NOT NULL,
  `Amount` varchar(30) NOT NULL,
  `Default` tinyint(1) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`headID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_pay_salary`
--


CREATE TABLE IF NOT EXISTS `h_pay_salary` (
  `payID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `catEmp` int(10) NOT NULL,
  `Year` varchar(10) NOT NULL,
  `Month` varchar(10) NOT NULL,
  `CTC` varchar(30) NOT NULL,
  `Gross` varchar(30) NOT NULL,
  `NetSalary` varchar(30) NOT NULL,
  `CurrentSalary` varchar(30) NOT NULL,
  `SubTotalA` varchar(30) NOT NULL,
  `SubTotalB` varchar(30) NOT NULL,
  `SubTotalC` varchar(30) NOT NULL,
  `SubTotalD` varchar(30) NOT NULL,
  `LeaveTaken` varchar(10) NOT NULL,
  `LeaveDeducted` varchar(10) NOT NULL,
  `LeaveDeduction` varchar(30) NOT NULL,
  `Advance` varchar(30) NOT NULL,
  `Loan` varchar(30) NOT NULL,
  `Overtime` varchar(30) NOT NULL,
  `Bonus` varchar(30) NOT NULL,
  `Arrear` varchar(30) NOT NULL,
  `Commission` varchar(30) NOT NULL,
  `SalaryData` text NOT NULL,
  `addedDate` date NOT NULL,
  `updatedDate` date NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`payID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `h_request`
--

CREATE TABLE IF NOT EXISTS `h_request` (
  `RequestID` int(11) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `EmpCode` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `Message` text NOT NULL,
  `RequestDate` date NOT NULL,
  `Moved` tinyint(1) NOT NULL,
  PRIMARY KEY (`RequestID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_review`
--

CREATE TABLE IF NOT EXISTS `h_review` (
  `reviewID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `Rating1` varchar(10) NOT NULL,
  `Rating2` varchar(10) NOT NULL,
  `Rating3` varchar(10) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `ReviewDate` date NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`reviewID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_salary`
--

CREATE TABLE IF NOT EXISTS `h_salary` (
  `salaryID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `catEmp` int(10) NOT NULL,
  `CTC` varchar(30) NOT NULL,
  `Gross` varchar(30) NOT NULL,
  `NetSalary` varchar(30) NOT NULL,
  `SalaryData` text NOT NULL,
  `updatedDate` date NOT NULL,
  `BankName` varchar(40) NOT NULL,
  `AccountName` varchar(40) NOT NULL,
  `AccountNumber` varchar(40) NOT NULL,
  `IFSCCode` varchar(40) NOT NULL,
  PRIMARY KEY (`salaryID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_shift`
--

CREATE TABLE IF NOT EXISTS `h_shift` (
  `shiftID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `shiftName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `WorkingHourStart` varchar(6) NOT NULL,
  `WorkingHourEnd` varchar(6) NOT NULL,
  `SL_Coming` varchar(6) NOT NULL,
  `SL_Leaving` varchar(6) NOT NULL,
  PRIMARY KEY (`shiftID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `h_tier` (
  `tierID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `tierName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `RangeFrom` int(30) NOT NULL,
  `RangeTo` int(30) NOT NULL,
  `Percentage` varchar(6) NOT NULL,
  PRIMARY KEY (`tierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


--
-- Table structure for table `h_shortleave`
--

CREATE TABLE IF NOT EXISTS `h_shortleave` (
  `StID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `attID` varchar(10) NOT NULL,
  `InTime` varchar(10) NOT NULL,
  `OutTime` varchar(10) NOT NULL,
  `attDate` date NOT NULL,
  `WorkingHourStart` varchar(10) NOT NULL,
  `WorkingHourEnd` varchar(10) NOT NULL,
  `updatedDate` datetime NOT NULL,
  PRIMARY KEY (`StID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_tax_form`
--

CREATE TABLE IF NOT EXISTS `h_tax_form` (
  `documentID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `document` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `docDate` date NOT NULL,
  `AdminID` int(20) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  PRIMARY KEY (`documentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_timesheet`
--

CREATE TABLE IF NOT EXISTS `h_timesheet` (
  `tmID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `tmDate` date NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  PRIMARY KEY (`tmID`),
  KEY `EmpID` (`EmpID`),
  KEY `tDate` (`tmDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_timesheet_detail`
--


CREATE TABLE IF NOT EXISTS `h_spiff` (
  `spiffID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `tierName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `SalesTarget` int(30) NOT NULL,
  `SpiffAmount` varchar(30) NOT NULL,
  PRIMARY KEY (`spiffID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `h_timesheet_detail` (
  `detID` int(20) NOT NULL AUTO_INCREMENT,
  `tmID` int(20) NOT NULL,
  `Project` varchar(40) NOT NULL,
  `Activity` varchar(40) NOT NULL,
  `Time1` varchar(10) NOT NULL,
  `Time2` varchar(10) NOT NULL,
  `Time3` varchar(10) NOT NULL,
  `Time4` varchar(10) NOT NULL,
  `Time5` varchar(10) NOT NULL,
  `Time6` varchar(10) NOT NULL,
  `Time7` varchar(10) NOT NULL,
  PRIMARY KEY (`detID`),
  KEY `tmID` (`tmID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_training`
--

CREATE TABLE IF NOT EXISTS `h_training` (
  `trainingID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `CourseName` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Company` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `trainingDate` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `trainingTime` varchar(30) NOT NULL,
  `Coordinator` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Cost` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Topic` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `document` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`trainingID`),
  KEY `locationID` (`locationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_vacancy`
--

CREATE TABLE IF NOT EXISTS `h_vacancy` (
  `vacancyID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(11) NOT NULL,
  `Department` int(3) NOT NULL,
  `JobTitle` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `HiringManager` int(11) NOT NULL,
  `Qualification` varchar(50) NOT NULL,
  `OtherQualification` varchar(40) NOT NULL,
  `Skill` varchar(50) NOT NULL,
  `NumPosition` int(3) NOT NULL,
  `Hired` int(10) NOT NULL,
  `MinAge` varchar(5) NOT NULL,
  `MaxAge` varchar(5) NOT NULL,
  `MinExp` varchar(5) NOT NULL,
  `MaxExp` varchar(5) NOT NULL,
  `MinSalary` varchar(5) NOT NULL,
  `MaxSalary` varchar(5) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Exceptional` tinyint(1) NOT NULL,
  `PostedDate` date NOT NULL,
  PRIMARY KEY (`vacancyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_vendor`
--

CREATE TABLE IF NOT EXISTS `h_vendor` (
  `VendorID` int(20) NOT NULL AUTO_INCREMENT,
  `VendorCode` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `VendorName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Country` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `State` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `City` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Mobile` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `Landline` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Fax` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`VendorID`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_adjustment`
--

CREATE TABLE IF NOT EXISTS `inv_adjustment` (
  `adjID` int(20) NOT NULL AUTO_INCREMENT,
  `adjustNo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `WID` int(20) NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `total_adjust_qty` int(20) NOT NULL,
  `total_adjust_value` decimal(10,2) NOT NULL,
  `adjust_reason` varchar(200) NOT NULL,
  `adjDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`adjID`),
  KEY `warehouse_code` (`warehouse_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `inv_bom_cat` (
  `optionID` int(20) NOT NULL AUTO_INCREMENT,
  `bomID` int(15) NOT NULL,
  `option_cat` varchar(50) NOT NULL,
  `option_code` varchar(50) NOT NULL,
  `req_status` tinyint(1) NOT NULL DEFAULT '0',
  `qty` int(20) NOT NULL,
  `option_price` decimal(10,2) NOT NULL,
  `TotalValue` decimal(10,2) NOT NULL,
  `description1` varchar(200) NOT NULL,
  `description2` varchar(200) NOT NULL,
  PRIMARY KEY (`optionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


--
-- Table structure for table `inv_assembly`
--

CREATE TABLE IF NOT EXISTS `inv_assembly` (
  `asmID` int(20) NOT NULL AUTO_INCREMENT,
  `asm_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `bomID` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `on_hand_qty` int(20) NOT NULL,
  `assembly_qty` int(20) NOT NULL,
  `asmDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `serial_name` text NOT NULL,
  `serial_qty` text NOT NULL,
  PRIMARY KEY (`asmID`),
  KEY `Sku` (`Sku`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_attribute`
--

CREATE TABLE IF NOT EXISTS `inv_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_attribute_value`
--

CREATE TABLE IF NOT EXISTS `inv_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_bill_of_material`
--

CREATE TABLE IF NOT EXISTS `inv_bill_of_material` (
  `bomID` int(20) NOT NULL AUTO_INCREMENT,
  `bom_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `item_id` int(20) NOT NULL,
  `bill_option` varchar(5) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `on_hand_qty` varchar(200) NOT NULL,
  `bomDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bomID`),
  KEY `Sku` (`Sku`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `inv_item_alias` (
`AliasID` int(20) NOT NULL AUTO_INCREMENT,
`ItemAliasCode` varchar(100) NOT NULL,
`sku` varchar(30) NOT NULL,
`VendorCode` varchar(30) NOT NULL,
`item_id` int(20) NOT NULL,
`description` varchar(255) NOT NULL,
`AliasType` varchar(30) NOT NULL,
PRIMARY KEY (`AliasID`),
KEY `sku` (`sku`),
KEY `ItemID` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_item_required` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ItemID` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `qty` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ItemID` (`ItemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Table structure for table `inv_categories`
--

CREATE TABLE IF NOT EXISTS `inv_categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `MetaTitle` text NOT NULL,
  `MetaKeyword` text NOT NULL,
  `MetaDescription` text NOT NULL,
  `CategoryDescription` text NOT NULL,
  `Image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ParentID` int(100) NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  `NumSubcategory` int(11) NOT NULL DEFAULT '0',
  `NumProducts` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(10) NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `categoryID` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_items`
--

CREATE TABLE IF NOT EXISTS `inv_items` (
  `ItemID` int(11) NOT NULL AUTO_INCREMENT,
  `Sku` varchar(30) NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `long_description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `procurement_method` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Model` varchar(255) NOT NULL,
  `Generation` varchar(255) NOT NULL,
  `Condition` varchar(50) NOT NULL,
  `Extended` varchar(50) NOT NULL,
  `Manufacture` varchar(50) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `itemType` varchar(50) NOT NULL,
  `non_inventory` varchar(5) NOT NULL,
  `UnitMeasure` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `evaluationType` varchar(100) NOT NULL,
  `ReorderLevel` varchar(50) NOT NULL,
  `min_stock_alert_level` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `max_stock_alert_level` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `qty_on_hand` int(10) NOT NULL,
  `allocated_qty` int(20) NOT NULL,
  `qty_on_demand` int(20) NOT NULL,
  `value` int(10) NOT NULL,
  `purchase_tax_rate` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sale_tax_rate` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `average_cost` decimal(10,2) NOT NULL,
  `last_cost` decimal(10,2) NOT NULL,
  `purchase_cost` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `supplier_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `supplier_currency` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pack_size` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `width` decimal(10,2) NOT NULL DEFAULT '0.00',
  `height` decimal(10,2) NOT NULL DEFAULT '0.00',
  `depth` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_alias` varchar(100) NOT NULL,
  `Image` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `AddedDate` date NOT NULL,
  `ViewedDate` date NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `LastAdminType` varchar(30) NOT NULL,
  `LastCreatedBy` varchar(50) NOT NULL,
  `Taxable` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`ItemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_assembly`
--

CREATE TABLE IF NOT EXISTS `inv_ModelGen` (
 `id` int(20) NOT NULL AUTO_INCREMENT,
 `Model` varchar(50) NOT NULL,
 `item_id` int(20) NOT NULL,
 `Sku` varchar(50) NOT NULL,
 `Generation` varchar(200) NOT NULL,
 `Status` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`id`),
 KEY `Sku` (`Sku`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_item_assembly` (
 `id` int(20) NOT NULL AUTO_INCREMENT,
 `asmID` int(20) NOT NULL,
 `bomID` int(20) NOT NULL,
 `bom_refID` int(20) NOT NULL,
 `sku` varchar(30) NOT NULL,
 `item_id` int(20) NOT NULL,
 `description` varchar(255) NOT NULL,
 `valuationType` varchar(50) NOT NULL,
 `available_qty` int(20) NOT NULL,
 `qty` int(20) NOT NULL,
 `wastageQty` int(20) NOT NULL,
 `unit_cost` decimal(10,2) NOT NULL,
 `total_bom_cost` decimal(10,2) NOT NULL,
 `serial` varchar(200) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `sku` (`sku`),
 KEY `ItemID` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_disassembly` (
  `DsmID` int(20) NOT NULL AUTO_INCREMENT,
  `DsmCode` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `WarehouseCode` varchar(50) NOT NULL,
  `bomID` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `on_hand_qty` int(20) NOT NULL,
  `disassembly_qty` int(20) NOT NULL,
  `disassemblyDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `serial_Num` text NOT NULL,
  PRIMARY KEY (`DsmID`),
  KEY `Sku` (`Sku`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_item_disassembly` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `dsmID` int(20) NOT NULL,
  `bomID` int(20) NOT NULL,
  `bom_refID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `item_id` int(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valuationType` varchar(50) NOT NULL,
  `serial_value` text NOT NULL,
  `available_qty` int(20) NOT NULL,
  `qty` int(20) NOT NULL,
  `wastageQty` int(20) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_bom_cost` decimal(10,2) NOT NULL,
  `serial` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sku` (`sku`),
  KEY `ItemID` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `inv_item_bom`
--

CREATE TABLE IF NOT EXISTS `inv_item_bom` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `bomID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `bom_code` varchar(50) NOT NULL,
  `optionID` int(15) NOT NULL,
  `item_id` int(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `bom_qty` int(20) NOT NULL,
  `wastageQty` int(20) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_bom_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sku` (`sku`),
  KEY `ItemID` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_item_images`
--

CREATE TABLE IF NOT EXISTS `inv_item_images` (
  `Iid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ItemID` int(12) NOT NULL,
  `Image` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `alt_text` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`Iid`),
  KEY `ProductID` (`ItemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_prefix`
--

CREATE TABLE IF NOT EXISTS `inv_prefix` (
  `prefixID` int(20) NOT NULL AUTO_INCREMENT,
  `adjustmentPrefix` varchar(50) NOT NULL,
  `adjustPrefixNum` varchar(50) NOT NULL,
  `ToP` varchar(50) NOT NULL,
  `ToN` varchar(50) NOT NULL,
  `bom_prefix` varchar(50) NOT NULL,
  `bom_number` varchar(50) NOT NULL,
  `updateDate` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`prefixID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_serial_item`
--

CREATE TABLE IF NOT EXISTS `inv_serial_item` (
  `serialID` int(20) NOT NULL AUTO_INCREMENT,
  `warehouse` varchar(50) NOT NULL,
  `serialNumber` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `adjustment_no` varchar(30) NOT NULL,
  `disassembly` int(15) NOT NULL,
  `Sku` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `UsedSerial` tinyint(1) NOT NULL,
  `ReceiveOrderID` int(11) NOT NULL,
  PRIMARY KEY (`serialID`),
  KEY `adjustment_no` (`adjustment_no`),
  KEY `Sku` (`Sku`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_stock_adjustment`
--

CREATE TABLE IF NOT EXISTS `inv_stock_adjustment` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `adjID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `adjustNo` varchar(50) NOT NULL,
  `item_id` int(20) NOT NULL,
  `on_hand_qty` int(20) NOT NULL,
  `qty` int(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valuationType` varchar(50) NOT NULL,
  `serial_value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Sku` (`sku`),
  KEY `ItemID` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_stock_transfer`
--

CREATE TABLE IF NOT EXISTS `inv_stock_transfer` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `transferID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `transferNo` varchar(50) NOT NULL,
  `item_id` int(20) NOT NULL,
  `on_hand_qty` int(20) NOT NULL,
  `qty` int(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valuationType` varchar(50) NOT NULL,
  `serial_value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Sku` (`sku`),
  KEY `ItemID` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_tax_classes`
--

CREATE TABLE IF NOT EXISTS `inv_tax_classes` (
  `ClassId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(128) NOT NULL DEFAULT '',
  `ClassDescription` varchar(255) NOT NULL DEFAULT '',
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ClassId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_tax_rates`
--

CREATE TABLE IF NOT EXISTS `inv_bin_stock` (
 `id` int(20) NOT NULL AUTO_INCREMENT,
 `Wcode` varchar(5) NOT NULL DEFAULT '',
 `Sku` varchar(20) NOT NULL DEFAULT '',
 `quantity` double NOT NULL DEFAULT '0',
 `purchase_qty` double NOT NULL DEFAULT '0',
 `sales_qty` double NOT NULL DEFAULT '0',
 `allocated_qty` double NOT NULL DEFAULT '0',
 `demand_qty` double NOT NULL DEFAULT '0',
 `reorderlevel` bigint(20) NOT NULL DEFAULT '0',
 `bin` varchar(10) NOT NULL DEFAULT '',
 `bin_code` varchar(50) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `StockID` (`Sku`),
 KEY `bin` (`bin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `inv_tax_rates` (
  `RateId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClassId` varchar(80) NOT NULL DEFAULT '',
  `Coid` int(11) NOT NULL,
  `Stid` int(11) NOT NULL,
  `locationID` int(11) unsigned NOT NULL,
  `TaxRate` decimal(10,2) unsigned NOT NULL,
  `RateDescription` varchar(255) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`RateId`),
  KEY `class_id` (`ClassId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_transfer`
--

CREATE TABLE IF NOT EXISTS `inv_transfer` (
  `transferID` int(20) NOT NULL AUTO_INCREMENT,
  `transferNo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `to_WID` int(20) NOT NULL,
  `from_WID` int(20) NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `total_transfer_qty` int(20) NOT NULL,
  `total_transfer_value` decimal(10,2) NOT NULL,
  `transfer_reason` varchar(200) NOT NULL,
  `transferDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`transferID`),
  KEY `to_WID` (`to_WID`),
  KEY `from_WID` (`from_WID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `Address` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `Country` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `State` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `City` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `LeaveStart` date NOT NULL,
  `LeaveEnd` date NOT NULL,
  `Timezone` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `currency_id` int(10) NOT NULL,
  `WorkingHourStart` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `WorkingHourEnd` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `Overtime` tinyint(1) NOT NULL,
  `OvertimeFrom` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `OvertimeRate` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `HalfDayHour` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `FullDayHour` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `MaxLeaveMonth` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `MaxShortLeave` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `WeekStart` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `WeekEnd` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `WeekEndOff` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `SalaryDate` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `LableLeave` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'L',
  `LableHalfDay` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'HD',
  `Advance` tinyint(1) NOT NULL,
  `Loan` tinyint(1) NOT NULL,
  `Bonus` tinyint(1) NOT NULL,
  `SL_Coming` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `SL_Leaving` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `SL_Deduct` tinyint(1) NOT NULL,
  `ExpenseClaim` tinyint(1) NOT NULL,
  PRIMARY KEY (`locationID`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notifyID` bigint(20) NOT NULL AUTO_INCREMENT,
  `depID` int(11) NOT NULL,
  `locationID` int(10) NOT NULL,
  `refID` varchar(50) NOT NULL,
  `refType` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Message` text NOT NULL,
  `oldValue` varchar(30) NOT NULL,
  `newValue` varchar(30) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(15) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `notifyDate` datetime NOT NULL,
  `Read` tinyint(1) NOT NULL,
  PRIMARY KEY (`notifyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `UserID` int(20) NOT NULL,
  `ModuleID` int(10) NOT NULL,
  `ViewLabel` tinyint(1) NOT NULL,
  `ModifyLabel` tinyint(1) NOT NULL,
  `FullLabel` tinyint(1) NOT NULL,
  UNIQUE KEY `EmpID` (`UserID`,`ModuleID`),
  KEY `AdminID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p_address_book`
--

CREATE TABLE IF NOT EXISTS `p_address_book` (
  `AddID` int(20) NOT NULL AUTO_INCREMENT,
  `SuppID` int(20) NOT NULL,
  `AddType` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PrimaryContact` tinyint(1) NOT NULL,
  `Name` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Country` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Landline` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Fax` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`AddID`),
  KEY `SuppID` (`SuppID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_attribute`
--

CREATE TABLE IF NOT EXISTS `p_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p_attribute_value`
--

CREATE TABLE IF NOT EXISTS `p_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_configuration`
--

CREATE TABLE IF NOT EXISTS `p_configuration` (
  `configuration_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `configuration_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`configuration_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p_order`
--


CREATE TABLE IF NOT EXISTS `p_order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Module` varchar(20) NOT NULL,
  `OrderDate` date NOT NULL DEFAULT '0000-00-00',
  `OrderType` varchar(30) NOT NULL,
  `PurchaseID` varchar(30) NOT NULL,
  `QuoteID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `ReturnID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `wID` int(11) DEFAULT '0',
  `Comment` varchar(250) NOT NULL,
  `InvoiceComment` varchar(100) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `SuppCompany` varchar(50) NOT NULL,
  `SuppContact` varchar(40) NOT NULL,
  `SuppCurrency` varchar(10) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `City` varchar(40) NOT NULL,
  `State` varchar(40) NOT NULL,
  `Country` varchar(40) NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
  `Mobile` varchar(20) NOT NULL,
  `Landline` varchar(20) NOT NULL,
  `Fax` varchar(30) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ReceivedDate` date NOT NULL,
  `InvoicePaid` enum('0','1','2') NOT NULL DEFAULT '0',
  `PaymentTerm` varchar(50) NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `Freight` decimal(20,2) DEFAULT '0.00',
  `discount` double NOT NULL DEFAULT '0',
  `shipper_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `terms` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `taxAmnt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `tax_auths` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `TotalAmount` decimal(20,2) DEFAULT '0.00',
  `Currency` varchar(20) NOT NULL,
  `recur_id` int(11) DEFAULT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `AssignedEmpID` int(11) NOT NULL,
  `AssignedEmp` varchar(70) NOT NULL,
  `rep_id` int(11) NOT NULL DEFAULT '0',
  `waiting` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `gl_acct_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `terminal_date` date DEFAULT NULL,
  `wCode` varchar(20) NOT NULL,
  `wName` varchar(40) NOT NULL,
  `wAddress` varchar(250) NOT NULL,
  `wCity` varchar(40) NOT NULL,
  `wState` varchar(40) NOT NULL,
  `wCountry` varchar(40) NOT NULL,
  `wZipCode` varchar(30) NOT NULL,
  `wContact` varchar(40) NOT NULL,
  `wMobile` varchar(20) NOT NULL,
  `wLandline` varchar(20) NOT NULL,
  `wEmail` varchar(80) NOT NULL,
  `DropShip` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `PaymentDate` date NOT NULL,
  `InvPaymentMethod` varchar(30) NOT NULL,
  `PaymentRef` varchar(30) NOT NULL,
  `Taxable` varchar(5) NOT NULL,
  `InvoiceEntry` tinyint(1) NOT NULL DEFAULT '0',
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `ExpenseID` int(11) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `TaxRate` varchar(100) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `post_date` (`OrderDate`),
  KEY `PurchaseID` (`PurchaseID`),
  KEY `Module` (`Module`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `p_order_item`
--

CREATE TABLE IF NOT EXISTS `p_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_returned` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit_amount` double DEFAULT '0',
  `credit_amount` double DEFAULT '0',
  `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_id` int(10) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(20,2) DEFAULT '0.00',
  `amount` decimal(20,2) DEFAULT '0.00',
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Taxable` varchar(5) NOT NULL,
  `DropshipCheck` tinyint(1) NOT NULL,
  `DropshipCost` decimal(10,2) NOT NULL,
  `SerialNumbers` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `p_supplier`
--

CREATE TABLE IF NOT EXISTS `p_supplier` (
  `SuppID` int(20) NOT NULL AUTO_INCREMENT,
  `SuppCode` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `FirstName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `UserName` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `CompanyName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `SupplierSince` date NOT NULL,
  `PaymentTerm` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PaymentMethod` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ShippingMethod` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `TaxNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Role` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Country` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `State` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `City` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Mobile` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `Landline` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Fax` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `UpdatedDate` date NOT NULL,
  `TempPass` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PasswordUpdated` tinyint(4) NOT NULL,
  `ipaddress` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `BankName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `AccountName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `AccountNumber` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `IFSCCode` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Currency` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `CustomerVendor` tinyint(1) NOT NULL,
  PRIMARY KEY (`SuppID`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p_term`
--

CREATE TABLE IF NOT EXISTS `p_term` (
  `termID` int(20) NOT NULL AUTO_INCREMENT,
  `termName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `termDate` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Day` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Due` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CreditLimit` decimal(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`termID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `s_address_book`
--

CREATE TABLE IF NOT EXISTS `s_address_book` (
  `AddID` int(20) NOT NULL AUTO_INCREMENT,
  `CustID` int(20) NOT NULL,
  `AddType` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PrimaryContact` tinyint(1) NOT NULL,
  `CrmContact` tinyint(1) NOT NULL,
  `FirstName` varchar(40) NOT NULL,
  `LastName` varchar(40) NOT NULL,
  `FullName` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Company` varchar(80) NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `CountryName` varchar(50) NOT NULL,
  `StateName` varchar(50) NOT NULL,
  `CityName` varchar(50) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Landline` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Fax` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PersonalEmail` varchar(80) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `AdminID` int(10) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `Title` varchar(40) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `LeadSource` varchar(30) NOT NULL,
  `AssignTo` varchar(100) NOT NULL,
  `Reference` varchar(10) NOT NULL,
  `DoNotCall` varchar(10) NOT NULL,
  `NotifyOwner` varchar(10) NOT NULL,
  `EmailOptOut` varchar(10) NOT NULL,
  `Image` varchar(80) NOT NULL,
  `Description` text NOT NULL,
  `IpAddress` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`AddID`),
  KEY `CustID` (`CustID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Table structure for table `s_attribute`
--

CREATE TABLE IF NOT EXISTS `s_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `s_attribute_value`
--

CREATE TABLE IF NOT EXISTS `s_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `s_customers`
--

CREATE TABLE IF NOT EXISTS `s_customers` (
  `Cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CustCode` varchar(250) NOT NULL,
  `CustomerType` varchar(20) NOT NULL,
  `Company` varchar(60) NOT NULL,
  `CustomerSince` date NOT NULL,
  `PaymentTerm` varchar(40) NOT NULL,
  `PaymentMethod` varchar(40) NOT NULL,
  `ShippingMethod` varchar(40) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `FirstName` varchar(40) NOT NULL DEFAULT '',
  `LastName` varchar(40) NOT NULL DEFAULT '',
  `FullName` varchar(80) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Landline` varchar(30) NOT NULL,
  `Mobile` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Website` varchar(250) NOT NULL,
  `Image` varchar(100) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `ipaddress` varchar(30) NOT NULL,
  `BankName` varchar(50) NOT NULL,
  `AccountName` varchar(50) NOT NULL,
  `AccountNumber` varchar(30) NOT NULL,
  `IFSCCode` varchar(30) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Taxable` enum('Yes','No') NOT NULL DEFAULT 'No',
  `AdminID` int(10) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  PRIMARY KEY (`Cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `s_invoice_payment`
--

CREATE TABLE IF NOT EXISTS `s_invoice_payment` (
  `InvoicePayID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `PaidAmount` decimal(10,2) NOT NULL,
  `PaidMethod` varchar(250) NOT NULL,
  `PaidDate` date NOT NULL,
  `PaidReferenceNo` varchar(250) NOT NULL,
  `PaidComment` text NOT NULL,
  PRIMARY KEY (`InvoicePayID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `s_order`
--

CREATE TABLE IF NOT EXISTS `s_order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderDate` date NOT NULL,
  `Module` varchar(20) NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `QuoteID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `ReturnID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `CustID` int(11) unsigned NOT NULL,
  `SalesPersonID` int(11) unsigned NOT NULL,
  `SalesPerson` varchar(250) NOT NULL,
  `CustomerCurrency` varchar(10) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Approved` enum('0','1') NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ShippedDate` date NOT NULL,
  `wCode` varchar(100) NOT NULL,
  `wName` varchar(100) NOT NULL,
  `OrderType` varchar(100) NOT NULL,
  `PaymentTerm` varchar(50) NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `Freight` decimal(20,2) DEFAULT '0.00',
  `discountAmnt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `shipper_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `terms` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `taxAmnt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `TotalInvoiceAmount` decimal(20,2) NOT NULL,
  `TotalAmount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `recur_id` int(11) DEFAULT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `AssignedTo` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `CustomerCompany` varchar(250) NOT NULL,
  `BillingName` varchar(80) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `ZipCode` varchar(100) NOT NULL,
  `Mobile` varchar(100) NOT NULL,
  `Landline` varchar(100) NOT NULL,
  `Fax` varchar(100) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `ShippingName` varchar(100) NOT NULL,
  `ShippingCompany` varchar(250) NOT NULL,
  `ShippingAddress` varchar(250) NOT NULL,
  `ShippingCity` varchar(100) NOT NULL,
  `ShippingState` varchar(100) NOT NULL,
  `ShippingCountry` varchar(100) NOT NULL,
  `ShippingZipCode` varchar(100) NOT NULL,
  `ShippingMobile` varchar(100) NOT NULL,
  `ShippingLandline` varchar(100) NOT NULL,
  `ShippingFax` varchar(100) NOT NULL,
  `ShippingEmail` varchar(250) NOT NULL,
  `rep_id` int(11) NOT NULL DEFAULT '0',
  `waiting` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `PaymentDate` date NOT NULL,
  `InvPaymentMethod` varchar(30) NOT NULL,
  `PaymentRef` varchar(30) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `InvoiceComment` varchar(250) NOT NULL,
  `InvoicePaid` enum('Unpaid','Paid','Part Paid') NOT NULL DEFAULT 'Unpaid',
  `ReturnDate` date NOT NULL,
  `ReturnPaid` enum('Yes','No') NOT NULL,
  `ReturnComment` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `CustType` char(1) NOT NULL,
  `opportunityName` varchar(100) NOT NULL,
  `OpportunityID` int(20) NOT NULL,
  `assignTo` varchar(100) NOT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `Taxable` varchar(5) NOT NULL,
  `Reseller` varchar(5) NOT NULL,
  `ResellerNo` varchar(50) NOT NULL,
  `tax_auths` varchar(16) NOT NULL,
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `InvoiceEntry` tinyint(1) NOT NULL DEFAULT '0',
  `Spiff` varchar(3) NOT NULL,
  `SpiffContact` text NOT NULL,
  `SpiffAmount` varchar(30) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `TaxRate` varchar(100) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  `PONumber` varchar(30) NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `PurchaseID` (`SaleID`),
  KEY `Module` (`Module`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `s_order_item`
--

CREATE TABLE IF NOT EXISTS `s_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_invoiced` int(11) NOT NULL,
  `qty_returned` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit_amount` double DEFAULT '0',
  `credit_amount` double DEFAULT '0',
  `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_id` int(10) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(20,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Taxable` varchar(5) NOT NULL,
  `req_item` text NOT NULL,
  `DropshipCheck` tinyint(1) NOT NULL,
  `DropshipCost` decimal(10,2) NOT NULL,
  `SerialNumbers` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `s_term`
--

CREATE TABLE IF NOT EXISTS `s_term` (
  `termID` int(20) NOT NULL AUTO_INCREMENT,
  `termName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `termDate` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Day` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Due` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CreditLimit` decimal(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`termID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserType` varchar(20) NOT NULL,
  `locationID` int(10) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Role` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`,`UserType`),
  KEY `UserType` (`UserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `loginID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) NOT NULL,
  `UserType` varchar(20) NOT NULL,
  `LoginTime` datetime NOT NULL,
  `LogoutTime` datetime NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  PRIMARY KEY (`loginID`),
  KEY `UserID` (`UserID`),
  KEY `UserType` (`UserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_adjustment`
--

CREATE TABLE IF NOT EXISTS `w_adjustment` (
  `adjustmentID` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_code` varchar(20) NOT NULL,
  `adjDate` date NOT NULL DEFAULT '0000-00-00',
  `transaction_ref` varchar(30) NOT NULL,
  `adjID` varchar(30) NOT NULL,
  `adjustNo` varchar(30) NOT NULL,
  `packageCount` int(15) NOT NULL,
  `RecieveID` varchar(30) NOT NULL,
  `WID` int(11) DEFAULT '0',
  `transport` varchar(50) NOT NULL,
  `PackageType` varchar(50) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `Description` text NOT NULL,
  `apply_to` varchar(50) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PaidAs` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `ReceivedDate` date NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(20) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `AssignedEmpID` int(11) NOT NULL,
  `AssignedEmp` varchar(70) NOT NULL,
  PRIMARY KEY (`adjustmentID`),
  KEY `post_date` (`adjDate`),
  KEY `adjID` (`adjID`),
  KEY `Module` (`warehouse_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_adjustment_item`
--

CREATE TABLE IF NOT EXISTS `w_adjustment_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjID` int(11) NOT NULL DEFAULT '0',
  `adjust_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_id` int(10) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adjID` (`adjID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_attribute`
--

CREATE TABLE IF NOT EXISTS `w_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `w_attribute_value`
--

CREATE TABLE IF NOT EXISTS `w_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_binlocation`
--

CREATE TABLE IF NOT EXISTS `w_binlocation` (
  `binid` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) NOT NULL,
  `binlocation_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `description` text NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `warehouse_code` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  PRIMARY KEY (`binid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_inbound_order`
--

CREATE TABLE IF NOT EXISTS `w_inbound_order` (
  `InboundID` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse` varchar(20) NOT NULL,
  `RecieveDate` date NOT NULL DEFAULT '0000-00-00',
  `transaction_ref` varchar(30) NOT NULL,
  `PurchaseID` varchar(30) NOT NULL,
  `packageCount` int(15) NOT NULL,
  `RecieveID` varchar(30) NOT NULL,
  `wID` int(11) DEFAULT '0',
  `transport` varchar(50) NOT NULL,
  `PackageType` varchar(50) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `Description` text NOT NULL,
  `apply_to` varchar(50) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PaidAs` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `RecieveStatus` varchar(20) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ReceivedDate` date NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(20) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `AssignedEmpID` int(11) NOT NULL,
  `AssignedEmp` varchar(70) NOT NULL,
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`InboundID`),
  KEY `post_date` (`RecieveDate`),
  KEY `PurchaseID` (`PurchaseID`),
  KEY `Module` (`warehouse`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_order`
--

CREATE TABLE IF NOT EXISTS `w_order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Module` varchar(20) NOT NULL,
  `OrderDate` date NOT NULL DEFAULT '0000-00-00',
  `OrderType` varchar(30) NOT NULL,
  `PurchaseID` varchar(30) NOT NULL,
  `InboundID` int(20) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `RecieveID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `wID` int(11) DEFAULT '0',
  `Comment` varchar(250) NOT NULL,
  `InvoiceComment` varchar(100) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `SuppCompany` varchar(50) NOT NULL,
  `SuppContact` varchar(40) NOT NULL,
  `SuppCurrency` varchar(10) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `City` varchar(40) NOT NULL,
  `State` varchar(40) NOT NULL,
  `Country` varchar(40) NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
  `Mobile` varchar(20) NOT NULL,
  `Landline` varchar(20) NOT NULL,
  `Fax` varchar(30) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ReceivedDate` date NOT NULL,
  `InvoicePaid` enum('0','1') NOT NULL DEFAULT '0',
  `PaymentTerm` varchar(50) NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `Freight` decimal(10,2) DEFAULT '0.00',
  `discount` double NOT NULL DEFAULT '0',
  `shipper_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `terms` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `sales_tax` double NOT NULL DEFAULT '0',
  `tax_auths` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(20) NOT NULL,
  `recur_id` int(11) DEFAULT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `AssignedEmpID` int(11) NOT NULL,
  `AssignedEmp` varchar(70) NOT NULL,
  `rep_id` int(11) NOT NULL DEFAULT '0',
  `waiting` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `gl_acct_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `terminal_date` date DEFAULT NULL,
  `wCode` varchar(20) NOT NULL,
  `wName` varchar(40) NOT NULL,
  `wAddress` varchar(250) NOT NULL,
  `wCity` varchar(40) NOT NULL,
  `wState` varchar(40) NOT NULL,
  `wCountry` varchar(40) NOT NULL,
  `wZipCode` varchar(30) NOT NULL,
  `wContact` varchar(40) NOT NULL,
  `wMobile` varchar(20) NOT NULL,
  `wLandline` varchar(20) NOT NULL,
  `wEmail` varchar(80) NOT NULL,
  `DropShip` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `PaymentDate` date NOT NULL,
  `InvPaymentMethod` varchar(30) NOT NULL,
  `PaymentRef` varchar(30) NOT NULL,
  `RecieveStatus` varchar(15) NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `post_date` (`OrderDate`),
  KEY `PurchaseID` (`PurchaseID`),
  KEY `Module` (`Module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_order_item`
--

CREATE TABLE IF NOT EXISTS `w_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_wRecieved` int(20) NOT NULL,
  `qty_returned` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit_amount` double DEFAULT '0',
  `credit_amount` double DEFAULT '0',
  `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_id` int(10) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_order_recieve`
--

CREATE TABLE IF NOT EXISTS `w_order_recieve` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderDate` date NOT NULL,
  `Module` varchar(20) NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `QuoteID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `RecieveID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `CustID` int(11) unsigned NOT NULL,
  `SalesPersonID` int(11) unsigned NOT NULL,
  `SalesPerson` varchar(250) NOT NULL,
  `CustomerCurrency` varchar(10) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Approved` enum('0','1') NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ShippedDate` date NOT NULL,
  `wCode` varchar(100) NOT NULL,
  `wName` varchar(100) NOT NULL,
  `OrderType` varchar(100) NOT NULL,
  `PaymentTerm` varchar(50) NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `Freight` decimal(10,2) DEFAULT '0.00',
  `discountAmnt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipper_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `terms` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `taxAmnt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalInvoiceAmount` decimal(10,2) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `recur_id` int(11) DEFAULT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `AssignedTo` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `CustomerCompany` varchar(250) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `ZipCode` varchar(100) NOT NULL,
  `Mobile` varchar(100) NOT NULL,
  `Landline` varchar(100) NOT NULL,
  `Fax` varchar(100) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `ShippingName` varchar(100) NOT NULL,
  `ShippingCompany` varchar(250) NOT NULL,
  `ShippingAddress` varchar(250) NOT NULL,
  `ShippingCity` varchar(100) NOT NULL,
  `ShippingState` varchar(100) NOT NULL,
  `ShippingCountry` varchar(100) NOT NULL,
  `ShippingZipCode` varchar(100) NOT NULL,
  `ShippingMobile` varchar(100) NOT NULL,
  `ShippingLandline` varchar(100) NOT NULL,
  `ShippingFax` varchar(100) NOT NULL,
  `ShippingEmail` varchar(250) NOT NULL,
  `rep_id` int(11) NOT NULL DEFAULT '0',
  `waiting` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `PaymentDate` date NOT NULL,
  `InvPaymentMethod` varchar(30) NOT NULL,
  `PaymentRef` varchar(30) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `InvoiceComment` varchar(250) NOT NULL,
  `InvoicePaid` enum('Open','Paid') NOT NULL DEFAULT 'Open',
  `RecieveDate` date NOT NULL,
  `RecievePaid` enum('Yes','No') NOT NULL,
  `RecieveComment` text NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `PurchaseID` (`SaleID`),
  KEY `Module` (`Module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_outbound`
--

CREATE TABLE IF NOT EXISTS `w_outbound` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `shipID` varchar(36) DEFAULT NULL,
  `RefID` varchar(50) NOT NULL,
  `OrderID` varchar(36) DEFAULT NULL,
  `order_id` int(20) NOT NULL,
  `OrderType` varchar(40) DEFAULT NULL,
  `shipping` varchar(50) NOT NULL,
  `ShipDate` date NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `AdminID` int(15) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  `createDate` date NOT NULL,
  `from_warehouse` int(15) NOT NULL,
  `to_warehouse` int(15) NOT NULL,
  `transport` varchar(80) NOT NULL,
  `packageCount` varchar(80) NOT NULL,
  `PackageType` varchar(80) NOT NULL,
  `Weight` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_outbound_item`
--

CREATE TABLE IF NOT EXISTS `w_outbound_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `shipID` varchar(20) NOT NULL DEFAULT '0',
  `InvoiceID` varchar(20) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(30) NOT NULL,
  `ref_id` int(10) NOT NULL,
  `binid` int(15) NOT NULL,
  `pickQty` int(10) NOT NULL,
  `qty_invoiced` int(11) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `OrderID` (`OrderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_receipt` (
 `ReceiptID` int(11) NOT NULL AUTO_INCREMENT,
 `Module` varchar(20) NOT NULL,
 `ModuleType` varchar(20) NOT NULL,
 `ReceiptNo` varchar(50) NOT NULL,
 `OrderID` int(11) NOT NULL,
 `PurchaseID` varchar(30) NOT NULL,
 `SaleID` varchar(30) NOT NULL,
 `QuoteID` varchar(30) NOT NULL,
 `InvoiceID` varchar(30) NOT NULL,
 `ReturnID` varchar(30) NOT NULL,
 `packageCount` varchar(50) NOT NULL,
 `transport` varchar(50) NOT NULL,
 `PackageType` varchar(50) NOT NULL,
 `Weight` varchar(50) NOT NULL,
 `ReceiptStatus` varchar(20) NOT NULL,
 `ReceiptComment` varchar(100) NOT NULL,
 `ReceiptDate` date NOT NULL DEFAULT '0000-00-00',
 `wCode` varchar(100) NOT NULL,
 `wName` varchar(100) NOT NULL,
 `OrderType` varchar(100) NOT NULL,
 `TotalReceiptAmount` decimal(20,2) NOT NULL DEFAULT '0.00',
 `CreatedBy` varchar(100) NOT NULL,
 `AdminID` int(11) NOT NULL DEFAULT '0',
 `AdminType` varchar(10) NOT NULL,
 `PostedDate` date NOT NULL,
 `UpdatedDate` date NOT NULL,
 PRIMARY KEY (`ReceiptID`),
 KEY `SaleID` (`SaleID`),
 KEY `Module` (`Module`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_receipt_item` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `ReceiptID` int(11) NOT NULL DEFAULT '0',
 `OrderID` int(11) NOT NULL DEFAULT '0',
 `item_id` int(11) NOT NULL DEFAULT '0',
 `ref_id` int(10) NOT NULL,
 `reconciled` tinyint(1) NOT NULL DEFAULT '0',
 `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
 `on_hand_qty` int(10) NOT NULL DEFAULT '0',
 `qty` float NOT NULL DEFAULT '0',
 `qty_received` int(10) NOT NULL,
 `qty_invoiced` int(11) NOT NULL,
 `qty_returned` int(10) NOT NULL,
 `qty_receipt` int(10) NOT NULL,
 `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
 `debit_amount` double DEFAULT '0',
 `credit_amount` double DEFAULT '0',
 `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
 `tax_id` int(10) NOT NULL,
 `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
 `price` decimal(20,2) NOT NULL DEFAULT '0.00',
 `amount` decimal(20,2) NOT NULL,
 `discount` decimal(10,2) NOT NULL,
 `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
 `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
 `Taxable` varchar(5) NOT NULL,
 `req_item` text NOT NULL,
 `DropshipCheck` tinyint(1) NOT NULL,
 `DropshipCost` decimal(10,2) NOT NULL,
 `SerialNumbers` text NOT NULL,
 PRIMARY KEY (`id`),
 KEY `reconciled` (`reconciled`),
 KEY `OrderID` (`OrderID`),
 KEY `ReceiptID` (`ReceiptID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;








-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `user_group` (
  `GroupID` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `module` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `group_user` varchar(100) NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AdminType` varchar(100) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `AdminID` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(15) NOT NULL,
  `AddedDate` datetime NOT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Table structure for table `w_recieve_item`
--

CREATE TABLE IF NOT EXISTS `w_recieve_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_invoiced` int(11) NOT NULL,
  `qty_returned` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit_amount` double DEFAULT '0',
  `credit_amount` double DEFAULT '0',
  `gl_account` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tax_id` int(10) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_sale_item_ship`
--

CREATE TABLE IF NOT EXISTS `w_sale_item_ship` (
  `shipID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(15) NOT NULL,
  `warehouse` varchar(20) NOT NULL,
  `RecievedDate` date NOT NULL DEFAULT '0000-00-00',
  `transaction_ref` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `packageCount` int(15) NOT NULL,
  `RecieveID` varchar(30) NOT NULL,
  `wID` int(11) DEFAULT '0',
  `transport` varchar(50) NOT NULL,
  `PackageType` varchar(50) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `Description` text NOT NULL,
  `apply_to` varchar(50) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PaidAs` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ReceivedDate` date NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(20) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `AssignedEmpID` int(11) NOT NULL,
  `AssignedEmp` varchar(70) NOT NULL,
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`shipID`),
  KEY `post_date` (`RecievedDate`),
  KEY `PurchaseID` (`InvoiceID`),
  KEY `Module` (`warehouse`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_stock_in`
--

CREATE TABLE IF NOT EXISTS `w_stock_in` (
  `stockin_id` int(11) NOT NULL AUTO_INCREMENT,
  `receiving_number` varchar(255) NOT NULL,
  `receiving_date` date NOT NULL,
  `purchase_id` varchar(255) NOT NULL,
  `mode_of_trasport` varchar(255) NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `package_id` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `charges` decimal(11,2) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `po_number` int(11) NOT NULL,
  PRIMARY KEY (`stockin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_term`
--

CREATE TABLE IF NOT EXISTS `w_term` (
  `termID` int(20) NOT NULL AUTO_INCREMENT,
  `termName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `termDate` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Day` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Due` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CreditLimit` decimal(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`termID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_transfer`
--

CREATE TABLE IF NOT EXISTS `w_transfer` (
  `transferID` int(20) NOT NULL AUTO_INCREMENT,
  `transferNo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `refID` int(20) NOT NULL,
  `refNumber` int(20) NOT NULL,
  `to_WID` int(20) NOT NULL,
  `from_WID` int(20) NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `total_transfer_qty` int(20) NOT NULL,
  `total_transfer_value` decimal(10,2) NOT NULL,
  `transfer_reason` varchar(200) NOT NULL,
  `transferDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` varchar(20) NOT NULL,
  PRIMARY KEY (`transferID`),
  KEY `to_WID` (`to_WID`),
  KEY `from_WID` (`from_WID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_transfer_item`
--

CREATE TABLE IF NOT EXISTS `w_transfer_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `transferID` int(20) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_transfer` int(10) NOT NULL,
  `qty_received` int(10) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(10,2) NOT NULL,
  `serialize` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `serialize_number` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `OrderID` (`OrderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_transfer_recieve`
--

CREATE TABLE IF NOT EXISTS `w_transfer_recieve` (
  `shipID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(15) NOT NULL,
  `warehouse` varchar(20) NOT NULL,
  `RecievedDate` date NOT NULL DEFAULT '0000-00-00',
  `transaction_ref` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `packageCount` int(15) NOT NULL,
  `RecieveID` varchar(30) NOT NULL,
  `wID` int(11) DEFAULT '0',
  `transport` varchar(50) NOT NULL,
  `PackageType` varchar(50) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `Description` text NOT NULL,
  `apply_to` varchar(50) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PaidAs` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `ClosedDate` date NOT NULL DEFAULT '0000-00-00',
  `DeliveryDate` date NOT NULL,
  `ReceivedDate` date NOT NULL,
  `PaymentMethod` varchar(30) NOT NULL,
  `ShippingMethod` varchar(30) NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `TotalAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(20) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `AssignedEmpID` int(11) NOT NULL,
  `AssignedEmp` varchar(70) NOT NULL,
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`shipID`),
  KEY `post_date` (`RecievedDate`),
  KEY `PurchaseID` (`InvoiceID`),
  KEY `Module` (`warehouse`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_warehouse`
--

CREATE TABLE IF NOT EXISTS `w_warehouse` (
  `WID` int(20) NOT NULL AUTO_INCREMENT,
  `location` int(20) NOT NULL,
  `warehouse_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `warehouse_code` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(80) NOT NULL,
  `ContactName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `Default` tinyint(1) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `CreateDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`WID`),
  KEY `warehouse_name` (`warehouse_name`),
  KEY `warehouse_code` (`warehouse_code`),
  KEY `warehouse_code_2` (`warehouse_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_warehouse_location`
--

CREATE TABLE IF NOT EXISTS `w_warehouse_location` (
  `WID` int(20) NOT NULL,
  `Address` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `City` varchar(50) NOT NULL,
  `state_id` int(12) NOT NULL,
  `State` varchar(50) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Country` varchar(50) NOT NULL,
  KEY `country_id` (`country_id`),
  KEY `WID` (`WID`),
  KEY `city_id` (`city_id`),
  KEY `country_id_2` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `w_production` (
 `WP_id` int(20) NOT NULL AUTO_INCREMENT,
 `asmID` int(20) NOT NULL,
 `asm_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `RecieveNo` varchar(45) NOT NULL,
 `warehouse_code` varchar(50) NOT NULL,
 `bomID` int(20) NOT NULL,
 `item_id` int(20) NOT NULL,
 `Sku` varchar(50) NOT NULL,
 `description` varchar(200) NOT NULL,
 `unit_cost` decimal(10,2) NOT NULL,
 `total_cost` decimal(10,2) NOT NULL,
 `on_hand_qty` int(20) NOT NULL,
 `assembly_qty` int(20) NOT NULL,
 `warehouse_qty` int(20) NOT NULL,
 `packageCount` int(15) NOT NULL,
 `PackageType` varchar(50) NOT NULL,
 `Weight` varchar(50) NOT NULL,
 `asmDate` date NOT NULL,
 `UpdatedDate` date NOT NULL,
 `created_by` varchar(50) NOT NULL,
 `created_id` int(15) NOT NULL,
 `Status_name` varchar(45) NOT NULL,
 `Status` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`WP_id`),
 KEY `Sku` (`Sku`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_production_item` (
 `WPI_id` int(20) NOT NULL AUTO_INCREMENT,
 `WP_id` int(23) NOT NULL,
 `id` int(12) NOT NULL,
 `asmID` int(20) NOT NULL,
 `bomID` int(20) NOT NULL,
 `bom_refID` int(20) NOT NULL,
 `sku` varchar(30) NOT NULL,
 `item_id` int(20) NOT NULL,
 `description` varchar(255) NOT NULL,
 `valuationType` varchar(50) NOT NULL,
 `available_qty` int(20) NOT NULL,
 `qty` int(20) NOT NULL,
 `warehouse_qty` int(30) NOT NULL,
 `wastageQty` int(20) NOT NULL,
 `unit_cost` decimal(10,2) NOT NULL,
 `total_bom_cost` decimal(10,2) NOT NULL,
 `serial` varchar(200) NOT NULL,
 PRIMARY KEY (`WPI_id`),
 KEY `sku` (`sku`),
 KEY `ItemID` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `w_bin` (
 `id` int(24) NOT NULL AUTO_INCREMENT,
 `WP_id` int(24) NOT NULL,
 `warehouse_id` int(25) NOT NULL,
 `bin_id` int(24) NOT NULL,
 `bin_qty` int(11) NOT NULL,
 `Status` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_cargo` (
 `cargo_id` int(24) NOT NULL AUTO_INCREMENT,
 `SuppCode` varchar(41) NOT NULL,
 `ReleaseDate` date NOT NULL,
 `ReleaseBy` varchar(41) NOT NULL,
 `SalesPersonID` int(25) NOT NULL,
 `ReleaseTo` varchar(41) NOT NULL,
 `CustCode` varchar(43) NOT NULL,
 `CustID` int(24) NOT NULL,
 `CarrierName` varchar(38) NOT NULL,
 `TransactionRef` varchar(28) NOT NULL,
 `TransportMode` varchar(35) NOT NULL,
 `PackageMode` varchar(37) NOT NULL,
 `ShipmentNo` varchar(41) NOT NULL,
 `PackageLoad` int(26) NOT NULL,
 `FirstName` varchar(42) NOT NULL,
 `LastName` varchar(41) NOT NULL,
 `LicenseNo` varchar(32) NOT NULL,
 `Address` varchar(41) NOT NULL,
 `Mobile` varchar(41) NOT NULL,
 `Status` int(21) NOT NULL,
 PRIMARY KEY (`cargo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_status_attribute` (
 `id` int(25) NOT NULL AUTO_INCREMENT,
 `Status` int(21) NOT NULL,
 `Status_Name` varchar(44) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



--
-- Dumping data for table `admin_modules`
--

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES
(1, 'Company Settings', '', 0, 0, 0, 1, 0),
(49, 'Manage Skill', 'viewAttribute.php?att=23', 0, 15, 0, 1, 3),
(3, 'Leave Management', '', 1, 0, 0, 1, 2),
(2, 'Employee', '', 1, 0, 0, 1, 1),
(50, 'Other Modules', '', 0, 0, 0, 0, 0),
(51, 'Edit Company Profile', 'editCompany.php', 0, 1, 0, 1, 0),
(52, 'Manage Employee', 'viewEmployee.php', 0, 2, 0, 1, 1),
(57, 'Dashboard Icon', 'mngDashboard.php', 0, 1, 0, 1, 0),
(54, 'Manage Countries', 'viewCountries.php', 0, 1, 0, 0, 0),
(55, 'Manage States', 'viewStates.php', 0, 1, 0, 0, 0),
(56, 'Manage Cities', 'viewCities.php', 0, 1, 0, 0, 0),
(53, 'Company Location', 'viewLocation.php', 0, 1, 0, 1, 0),
(58, 'My Leaves', 'myLeave.php', 0, 6, 1, 1, 0),
(59, 'My Timesheet', 'myTimesheet.php', 0, 7, 0, 0, 0),
(60, 'My Attendance', 'myAttendence.php', 0, 7, 0, 1, 0),
(61, 'Timesheet', 'viewTimesheet.php', 0, 5, 0, 0, 0),
(62, 'Attendance List', 'viewAttendence.php', 0, 5, 0, 1, 0),
(63, 'Job Type', 'viewAttribute.php?att=1', 0, 15, 0, 1, 0),
(64, 'Salary Frequency', 'viewAttribute.php?att=2', 0, 15, 0, 0, 0),
(65, 'Job Title', 'viewAttribute.php?att=11', 0, 15, 0, 1, 0),
(66, 'Manage Education', 'viewEducation.php', 0, 15, 0, 1, 0),
(68, 'Leave Type', 'viewAttribute.php?att=9', 0, 15, 0, 1, 0),
(67, 'Leave Period', 'leavePeriod.php', 0, 15, 0, 1, 0),
(73, 'Holidays', 'viewHoliday.php', 0, 3, 0, 1, 0),
(74, 'Leave Entitlement', 'viewEntitlement.php', 0, 3, 0, 1, 0),
(75, 'Manage Leave', 'viewLeave.php', 0, 3, 0, 1, 1),
(31, 'Leave Report', 'viewLeaveReport.php', 0, 30, 0, 1, 0),
(77, 'Manage Candidates', 'viewCandidate.php?module=Manage', 0, 4, 0, 1, 0),
(78, 'Leave Applied to Me', 'leaveApplied.php', 0, 6, 1, 1, 0),
(69, 'Manage Vacancies', 'viewVacancy.php', 0, 4, 0, 1, 0),
(70, 'Apply For Leave', 'applyLeave.php', 0, 6, 1, 1, 0),
(6, 'My Leaves', '', 1, 0, 1, 1, 0),
(4, 'Recruitment', '', 1, 0, 0, 1, 3),
(7, 'Time', '', 1, 0, 1, 1, 0),
(5, 'Time Management', '', 1, 0, 0, 1, 4),
(137, 'Calendar View', 'calender.php?module=calender', 0, 136, 0, 1, 0),
(134, 'Lead Industry', 'viewAttribute.php?att=51', 0, 115, 0, 1, 0),
(133, 'Manage Contact', 'viewContact.php?module=contact', 0, 107, 0, 1, 0),
(131, 'Sales Stage', 'viewAttribute.php?att=16', 0, 115, 0, 1, 0),
(130, 'Ticket Category', 'viewAttribute.php?att=15', 0, 115, 0, 1, 0),
(127, 'Manage Campaign', 'viewCampaign.php?module=Campaign', 0, 106, 0, 1, 0),
(126, 'Manage Document', 'viewDocument.php?module=Document', 0, 105, 0, 1, 0),
(124, 'Lead Source', 'viewAttribute.php?att=11', 0, 115, 0, 1, 0),
(10, 'Directory', '', 1, 0, 0, 1, 10),
(11, 'Announcements', '', 1, 0, 0, 1, 9),
(8, 'Performance', '', 1, 0, 0, 1, 6),
(71, 'Documents', 'viewDocument.php', 0, 11, 0, 1, 2),
(72, 'Announcements', 'viewNews.php', 0, 11, 0, 1, 1),
(12, 'Payroll', '', 1, 0, 0, 1, 5),
(79, 'Shortlisted Candidates', 'viewCandidate.php?module=Shortlisted', 0, 4, 0, 1, 0),
(136, 'Calendar', '', 5, 0, 0, 1, 7),
(123, 'Manage Ticket', 'viewTicket.php?module=Ticket', 0, 104, 0, 1, 0),
(122, 'Manage Opportunity ', 'viewOpportunity.php?module=Opportunity', 0, 103, 0, 1, 0),
(121, 'Manage Lead', 'viewLead.php?module=lead', 0, 102, 0, 1, 0),
(80, 'Offered Candidates', 'viewCandidate.php?module=Offered', 0, 4, 0, 1, 0),
(81, 'Interview Test', 'viewAttrib.php?att=12', 0, 4, 0, 1, 0),
(108, 'Quotes', '', 5, 0, 0, 1, 6),
(107, 'Contact', '', 5, 0, 0, 1, 5),
(106, 'Campaign', '', 5, 0, 0, 1, 9),
(105, 'Document', '', 5, 0, 0, 1, 8),
(104, 'Ticket', '', 5, 0, 0, 1, 4),
(103, 'Opportunity', '', 5, 0, 0, 1, 3),
(102, 'Lead', '', 5, 0, 0, 1, 2),
(82, 'Components', 'viewComponent.php', 0, 8, 0, 1, 0),
(83, 'Weightages', 'viewWeightage.php', 0, 8, 0, 1, 0),
(84, 'KRA', 'viewKra.php', 0, 8, 0, 1, 0),
(85, 'Reviews', 'viewReview.php', 0, 8, 0, 1, 0),
(86, 'Payroll Structure', 'viewPayStructure.php', 0, 12, 0, 1, 1),
(87, 'Employee Salary', 'viewSalary.php', 0, 12, 0, 1, 2),
(138, 'Manage Event / Task', 'viewActivity.php?module=Activity', 0, 136, 0, 1, 0),
(140, 'Lead Document', 'viewDocument.php?module=Lead', 0, 102, 0, 0, 0),
(141, 'Opportunity Document', 'viewDocument.php?module=Opportunity', 0, 103, 0, 0, 0),
(143, 'Campaign Type', 'viewAttribute.php?att=54', 0, 115, 0, 1, 0),
(144, 'Manage Quote ', 'viewQuote.php?module=Quote', 0, 108, 0, 1, 0),
(145, 'Ticket Document', 'viewDocument.php?module=Ticket', 0, 104, 0, 0, 0),
(146, 'Event Document', 'viewDocument.php?module=Event', 0, 136, 0, 0, 0),
(147, 'Expected Response', 'viewAttribute.php?att=55', 0, 115, 0, 1, 0),
(153, 'Activity Status', 'viewAttribute.php?att=18', 0, 115, 0, 1, 0),
(154, 'Activity Type', 'viewAttribute.php?att=19', 0, 115, 0, 1, 0),
(155, 'Manage Territory', 'viewTerritory.php', 0, 115, 0, 1, 0),
(156, 'Territory Rules', 'viewTerritoryRule.php', 0, 115, 0, 1, 0),
(157, 'Territory Customer Report', 'territoryCustomerReport.php', 0, 116, 0, 1, 0),
(158, 'Territory Lead Report', 'territoryLeadReport.php', 0, 116, 0, 1, 0),
(201, 'Products & Categories', '', 2, 0, 0, 1, 1),
(204, 'Settings', '', 2, 0, 0, 1, 5),
(205, 'Orders & Customers', '', 2, 0, 0, 1, 2),
(211, 'Manage Products', 'viewProduct.php', 0, 201, 0, 1, 0),
(212, 'Manage Categories', 'viewCategory.php', 0, 201, 0, 1, 0),
(213, 'Manage Manufacturers', 'viewManufacturer.php', 0, 201, 0, 1, 0),
(215, 'Store Settings', 'cartSetting.php?module=1', 0, 204, 0, 1, 0),
(216, 'Manage Shipping', 'viewShipping.php', 0, 202, 0, 1, 0),
(217, 'Manage Tax', 'viewTax.php', 0, 202, 0, 1, 0),
(218, 'Manage Tax Class', 'viewTaxClass.php', 0, 202, 0, 1, 0),
(219, 'Manage Orders', 'viewOrder.php', 0, 205, 0, 1, 0),
(220, 'Manage Customers', 'viewCustomer.php', 0, 205, 0, 1, 0),
(148, 'Document', 'viewDocument.php?module=Quote', 0, 108, 0, 0, 0),
(228, 'Manage Pages', 'viewPages.php', 0, 204, 0, 1, 0),
(206, 'Marketing', '', 2, 0, 0, 1, 7),
(221, 'Global Attributes', 'viewGlobalAttribute.php', 0, 201, 0, 1, 0),
(9, 'My Profile', '', 1, 0, 1, 1, 0),
(89, 'My Profile', 'myProfile.php', 0, 9, 0, 1, 0),
(90, 'Salary Details', 'mySalary.php', 0, 9, 0, 1, 0),
(91, 'My Declaration', 'myDeclaration.php', 0, 9, 0, 1, 0),
(92, 'Tax Declaration Form', 'taxDeclarationForm.php', 0, 12, 0, 1, 0),
(93, 'Employee Declaration', 'viewDeclaration.php', 0, 12, 0, 1, 0),
(13, 'Training', '', 1, 0, 0, 1, 7),
(94, 'Manage Training', 'viewTraining.php', 0, 13, 0, 1, 0),
(95, 'Manage Participants', 'viewParticipant.php', 0, 13, 0, 1, 0),
(88, 'Generated Salary', 'viewGeneratedSalary.php', 0, 12, 0, 1, 3),
(223, 'Manage Subscribers Email', 'viewSubscriber.php', 0, 206, 0, 1, 0),
(224, 'Manage Reviews', 'viewProductReview.php', 0, 201, 0, 1, 0),
(225, 'Send Newsletter', 'emailNewsletter.php', 0, 206, 0, 1, 0),
(226, 'Newsletter Templates', 'viewNewsletterTemplate.php', 0, 206, 0, 1, 0),
(227, 'Social Settings', 'cartSetting.php?module=2', 0, 204, 0, 1, 0),
(30, 'Report', '', 1, 0, 0, 1, 8),
(32, 'Employee Turn Over', 'viewEmpturnover.php', 0, 30, 0, 1, 0),
(33, 'Employee Exit Report', 'terminationReport.php', 0, 30, 0, 1, 0),
(34, 'Vacancy Succession Report', 'vacancyReport.php', 0, 30, 0, 1, 0),
(35, 'Employee Hiring Report', 'hiringReport.php', 0, 30, 0, 1, 0),
(37, 'Directory', 'viewDirectory.php', 0, 10, 0, 1, 0),
(202, 'Shipping & Taxes', '', 2, 0, 0, 1, 3),
(222, 'Bestseller Settings', 'cartSetting.php?module=3', 0, 204, 0, 1, 0),
(203, 'Payment Methods', '', 2, 0, 0, 1, 4),
(229, 'Manage Payment Methods', 'viewPayment.php', 0, 203, 0, 1, 0),
(230, 'Payment Method Configure', 'paymentConfigure.php', 0, 203, 0, 1, 0),
(207, 'Discounts & Coupon', '', 2, 0, 0, 1, 6),
(231, 'Global Discounts', 'viewDiscount.php', 0, 207, 0, 1, 0),
(232, 'Coupon Codes', 'viewCoupon.php', 0, 207, 0, 1, 0),
(15, 'Settings', '', 1, 0, 0, 1, 5),
(233, 'Customer Groups', 'viewCustomerGroup.php', 0, 205, 0, 1, 0),
(601, 'Item Master', '', 6, 0, 0, 1, 0),
(602, 'Stock Adjustments', '', 6, 0, 0, 1, 0),
(603, 'Stock Transfers', '', 6, 0, 0, 1, 0),
(604, 'BOM', '', 6, 0, 0, 1, 0),
(610, 'Settings', '', 6, 0, 0, 1, 0),
(628, 'Manage Items', 'viewItem.php', 0, 601, 0, 1, 0),
(629, 'Manage Unit', 'viewAttribute.php?att=11', 0, 610, 0, 1, 0),
(630, 'Tax Rate', 'viewTax.php', 0, 610, 0, 0, 0),
(631, 'Tax Class', 'viewTaxClass.php', 0, 610, 0, 0, 0),
(634, 'Manage Categories', 'viewCategory.php', 0, 601, 0, 1, 0),
(635, 'Item Type', 'viewAttribute.php?att=1', 0, 610, 0, 1, 0),
(636, 'Procurement', 'viewAttribute.php?att=2', 0, 610, 0, 1, 0),
(637, 'Valuation Type', 'viewAttribute.php?att=3', 0, 610, 0, 1, 0),
(638, 'Adjustments', 'viewAdjustment.php', 0, 602, 0, 1, 0),
(639, 'Adjustment Reason', 'viewAttribute.php?att=13', 0, 610, 0, 1, 0),
(640, 'Manage Stock Transfer', 'viewTransfer.php', 0, 603, 0, 1, 0),
(641, 'Manage BOM', 'viewBOM.php', 0, 604, 0, 1, 0),
(642, 'Manage Prefixes', 'editPrefixes.php', 0, 610, 0, 1, 0),
(648, 'Manage Model', 'viewModel.php', 0, 610, 0, 1, 0),
(649, 'Manage Generation', 'viewAttribute.php?att=5', 0, 610, 0, 1, 0),
(650, 'Manage Extended', 'viewAttribute.php?att=7', 0, 610, 0, 1, 0),
(651, 'Manage Manufacture', 'viewAttribute.php?att=8', 0, 610, 0, 1, 0),
(652, 'Manage Condition', 'viewAttribute.php?att=6', 0, 610, 0, 1, 0),
(653, 'Reorder Method', 'viewAttribute.php?att=9', 0, 610, 0, 1, 0),
(654, 'Stock Search', 'searchItemStock.php', 0, 601, 0, 1, 0),
(655, 'Manage Disassembly', 'viewDisassembly.php', 0, 604, 0, 1, 0),
(403, 'Purchase Order', '', 4, 0, 0, 1, 3),
(404, 'Invoices', '', 4, 0, 0, 0, 4),
(405, 'Returns', '', 4, 0, 0, 1, 5),
(407, 'Credit Note', '', 4, 0, 0, 0, 0),
(409, 'Report', '', 4, 0, 0, 1, 0),
(410, 'Settings', '', 4, 0, 0, 0, 0),
(411, 'Purchase Quote', 'viewPO.php?module=Quote', 0, 402, 0, 1, 0),
(413, 'Purchase Order', 'viewPO.php?module=Order', 0, 403, 0, 1, 0),
(414, 'Invoices', 'viewPoInvoice.php', 0, 404, 0, 1, 0),
(415, 'Manage Vendor', 'viewSupplier.php', 0, 401, 0, 1, 0),
(416, 'Vendor Purchases', 'viewSuppPO.php', 0, 401, 0, 1, 0),
(417, 'Vendor Invoices', 'viewSuppInvoice.php', 0, 401, 0, 1, 0),
(418, 'Returns', 'viewReturn.php', 0, 405, 0, 1, 0),
(419, 'Vendor Returns', 'viewSuppReturn.php', 0, 401, 0, 1, 0),
(420, 'Credit Note', 'viewPoCreditNote.php', 0, 407, 0, 1, 0),
(421, 'Vendor Price List', 'viewSuppPrice.php', 0, 401, 0, 1, 0),
(430, 'Customize Fields', 'customizeField.php', 0, 410, 0, 0, 0),
(431, 'Payment Method', 'viewAttrib.php?att=1', 0, 410, 0, 0, 0),
(76, 'Manage Department', 'viewDepartment.php', 0, 15, 0, 1, 2),
(718, 'Customer Order', 'viewCustomerOrderInvoice.php?module=Order', 0, 701, 0, 1, 0),
(717, 'Sales Order', 'viewSalesQuoteOrder.php?module=Order', 0, 703, 0, 1, 0),
(716, 'Shipping Method', 'viewAttrib.php?att=2', 0, 710, 0, 0, 0),
(715, 'Payment Term', 'viewTerm.php', 0, 710, 0, 0, 0),
(714, 'Payment Method', 'viewAttrib.php?att=1', 0, 710, 0, 0, 0),
(713, 'Sales Quote', 'viewSalesQuoteOrder.php?module=Quote', 0, 702, 0, 1, 0),
(432, 'Payment Term', 'viewTerm.php', 0, 410, 0, 0, 0),
(433, 'Shipping Method', 'viewAttrib.php?att=2', 0, 410, 0, 0, 0),
(441, 'PO Report', 'viewPoReport.php', 0, 409, 0, 1, 0),
(442, 'Invoice Report', 'viewInvReport.php', 0, 409, 0, 0, 0),
(719, 'Customer Invoice', 'viewCustomerOrderInvoice.php?module=Invoice', 0, 701, 0, 1, 0),
(720, 'Invoices', 'viewInvoice.php', 0, 704, 0, 1, 0),
(721, 'Returns', 'viewReturn.php', 0, 705, 0, 1, 0),
(643, 'Price List', 'viewPriceList.php', 0, 601, 0, 1, 0),
(644, 'Serial Number List', 'viewSerial.php', 0, 601, 0, 1, 0),
(402, 'Purchase Quote', '', 4, 0, 0, 1, 2),
(401, 'Vendor', '', 4, 0, 0, 0, 1),
(443, 'Payment History', 'viewPaymentReport.php', 0, 409, 0, 0, 0),
(722, 'Customer Return', 'viewCustomerReturn.php?module=Return', 0, 701, 0, 1, 0),
(723, 'Sales by Customer', 'viewSalesbyCustomer.php', 0, 706, 0, 1, 0),
(724, 'Sales by Sales Person', 'viewSalesbySalesPerson.php', 0, 706, 0, 1, 0),
(725, 'Sales Statistics', 'viewSalesStatistics.php', 0, 706, 0, 0, 0),
(712, 'Manage Customer', 'viewCustomer.php', 0, 701, 0, 1, 2),
(710, 'Settings', '', 7, 0, 0, 0, 0),
(706, 'Reports', '', 7, 0, 0, 1, 0),
(705, 'Returns', '', 7, 0, 0, 1, 0),
(704, 'Invoices', '', 7, 0, 0, 0, 0),
(703, 'Sales Order', '', 7, 0, 0, 1, 0),
(702, 'Sales Quote', '', 7, 0, 0, 1, 0),
(701, 'Customer', '', 7, 0, 0, 0, 1),
(707, 'Credit Note', '', 7, 0, 0, 0, 0),
(726, 'Credit Note', 'viewCreditNote.php', 0, 707, 0, 1, 0),
(727, 'Payment History', 'viewPayReport.php', 0, 706, 0, 0, 0),
(645, 'Manage Assembly', 'viewAssemble.php', 0, 604, 0, 1, 0),
(605, 'Report', '', 6, 0, 0, 1, 0),
(646, 'Stock Transfer Report', 'viewTransferReport.php', 0, 605, 0, 1, 0),
(647, 'Stock Adjustment Report', 'viewAdjReport.php', 0, 605, 0, 1, 0),
(324, 'Stock Transfer', 'viewStockTransfer.php', 0, 302, 0, 1, 0),
(323, ' Sales Return ', 'viewSalesReturn.php', 0, 302, 0, 1, 0),
(322, 'PO Receipt Invoices', 'viewPoInvoice.php', 0, 302, 0, 1, 0),
(321, 'Manage Bin', 'viewManageBin.php', 0, 301, 0, 1, 0),
(320, 'Manage Warehouse', 'viewWarehouse.php', 0, 301, 0, 1, 0),
(306, 'Settings', '', 3, 0, 0, 1, 0),
(305, 'Transportation', '', 3, 0, 0, 0, 0),
(304, 'Outbound Order', '', 3, 0, 0, 1, 0),
(303, 'Internal Order', '', 3, 0, 0, 0, 0),
(302, 'Inbound Order', '', 3, 0, 0, 1, 0),
(301, 'Warehouse', '', 3, 0, 0, 1, 0),
(325, 'Manage Transport', 'viewAttrib.php?att=1', 0, 306, 0, 1, 1),
(326, 'Package Type', 'viewAttrib.php?att=2', 0, 306, 0, 1, 0),
(327, 'Manage Charge', 'viewAttrib.php?att=3', 0, 306, 0, 1, 0),
(328, 'Manage Paid', 'viewAttrib.php?att=4', 0, 306, 0, 1, 0),
(329, 'Stock Adjustment', 'viewStockAdjustment.php', 0, 302, 0, 0, 0),
(330, 'Manage Cargo', 'viewCargo.php', 0, 305, 0, 1, 1),
(331, 'Assemble Order', 'viewProduction.php', 0, 303, 0, 1, 0),
(332, 'Ship Sales Order', 'viewSale.php', 0, 304, 0, 1, 0),
(115, 'Settings', '', 5, 0, 0, 1, 10),
(109, 'Report', '', 5, 0, 0, 1, 0),
(149, 'Lead Report', 'viewLeadReport.php', 0, 109, 0, 1, 0),
(150, 'Opportunity Report', 'viewOpportunityReport.php', 0, 109, 0, 1, 0),
(1004, 'Loan', 'myLoan.php', 0, 9, 0, 1, 0),
(1005, 'Global Settings', 'globalSetting.php', 0, 15, 0, 1, 1),
(1006, 'Overtime', 'viewOvertime.php', 0, 5, 0, 1, 0),
(1003, 'Advance', 'myAdvance.php', 0, 9, 0, 1, 0),
(1002, 'Loan', 'viewLoan.php', 0, 12, 0, 1, 0),
(1001, 'Advance', 'viewAdvance.php', 0, 12, 0, 1, 0),
(1007, 'Bonus', 'viewBonus.php', 0, 12, 0, 1, 0),
(1008, 'Short Leave', 'viewShortLeave.php', 0, 3, 0, 0, 0),
(1009, 'Send Request', 'sendRequest.php', 0, 9, 0, 0, 0),
(1010, 'Employee Request', 'viewRequest.php', 0, 11, 0, 0, 0),
(1011, 'Comp-Off', 'viewComp.php', 0, 3, 0, 0, 0),
(1012, 'Compensation', 'myComp.php', 0, 6, 0, 0, 0),
(1013, 'Comp-Off Applied to Me', 'compApplied.php', 0, 6, 0, 0, 0),
(1015, 'Email Template', 'email_template.php', 0, 15, 0, 0, 0),
(1014, 'Events', 'viewEvent.php', 0, 11, 0, 0, 0),
(96, 'Manage Assets', 'viewAsset.php', 0, 14, 0, 1, 1),
(97, 'Manage Brand', 'viewAttrib.php?att=24', 0, 14, 0, 1, 0),
(98, 'Manage Category', 'viewAttrib.php?att=25', 0, 14, 0, 1, 0),
(99, 'Manage Vendor', 'viewVendor.php', 0, 14, 0, 1, 0),
(100, 'Assigned Assets', 'viewAssignAsset.php', 0, 14, 0, 1, 2),
(14, 'Assets', '', 1, 0, 0, 0, 0),
(1017, 'Attrition Report', 'attritionReport.php', 0, 30, 0, 0, 0),
(1018, 'Work Shift', 'viewShift.php', 0, 15, 0, 1, 2),
(1019, 'Expense Claim', 'viewExpenseClaim.php', 0, 12, 0, 0, 0),
(1020, 'Expense Claim', 'myExpenseClaim.php', 0, 9, 1, 0, 0),
(1021, 'Appraisal', 'viewAppraisal.php', 0, 12, 0, 0, 4),
(333, 'Ship Transfer Order', 'viewTransferOrder.php', 0, 304, 0, 1, 0),
(334, 'Purchase Return Order', 'viewPurchaseReturnOrder.php', 0, 304, 0, 0, 0),
(335, 'Released Production Orders', 'viewProductionOrder.php', 0, 304, 0, 0, 0),
(336, 'Manage Shipping', 'viewShipOrder.php', 0, 304, 0, 1, 0),
(337, 'Shipping Method', 'viewAttrib.php?att=6', 0, 306, 0, 1, 0),
(338, 'Pick & Put Qty', 'viewInternalBinOrder.php', 0, 303, 0, 1, 0),
(2001, 'Users', '', 5, 0, 0, 0, 0),
(2002, 'Manage Users', 'viewUser.php', 0, 2001, 0, 1, 0),
(2003, 'Item Master', '', 5, 0, 0, 0, 0),
(2004, 'Manage Items', 'viewItem.php', 0, 2003, 0, 1, 0),
(2005, 'Users', '', 6, 0, 0, 0, 0),
(2006, 'Manage Users', 'viewUser.php', 0, 2005, 0, 1, 0),
(151, 'Manage Group', 'viewGroup.php', 0, 115, 0, 1, 1),
(152, 'Email Template', 'email_template.php', 0, 115, 0, 1, 0),
('728', 'Sales Commission Report', 'viewSalesCommReport.php', '0', '706', '0', '0', '0'),
(729, 'Sales by Territory ', 'salesTerritory.php', 0, 706, 0, 1, 0),
(2007, 'Sales Commission Tier', 'viewTier.php', 0, 15, 0, 1, 0),
(2008, 'Sales Commission Tier', 'viewTier.php', 0, 115, 0, 0, 0),
(2009, 'Sales Commission Tier', 'viewTier.php', 0, 610, 0, 0, 0),
(2010, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 15, 0, 1, 0),
(2011, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 115, 0, 0, 0),
(2012, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 610, 0, 0, 0),
(2015, 'Customer', '', 5, 0, 0, 1, 0),
(2016, 'Manage Customer', 'viewCustomer.php', 0, 2015, 0, 1, 0),
(801, 'Chart of Accounts', '', 8, 0, 0, 1, 0),
(802, 'AR', '', 8, 0, 0, 1, 0),
(803, 'AP', '', 8, 0, 0, 1, 0),
(804, 'Journal Entry', '', 8, 0, 0, 1, 0),
(805, 'Reports', '', 8, 0, 0, 1, 0),
(810, 'Settings', '', 8, 0, 0, 1, 0),
(816, 'Chart of Accounts', 'viewAccount.php', 0, 801, 0, 1, 0),
(817, 'Cash Receipt', 'viewSalesPayments.php', 0, 802, 0, 1, 0),
(818, 'Payment Method', 'viewAttrib.php?att=1', 0, 810, 0, 1, 0),
(819, 'Manage Tax', 'viewTax.php', 0, 810, 0, 1, 0),
(820, 'Global Setting', 'globalSetting.php', 0, 810, 0, 1, 1),
(821, 'Tax Class', 'viewTaxClass.php', 0, 810, 0, 1, 0),
(822, 'Manage Account Types', 'viewAccountType.php', 0, 801, 0, 1, 0),
(823, 'General Journal', 'viewGeneralJournal.php', 0, 804, 0, 1, 0),
(824, 'Other Income', 'viewOtherIncome.php', 0, 802, 0, 0, 0),
(825, 'Payments', 'viewPurchasePayments.php', 0, 803, 0, 1, 0),
(826, 'Invoice Entry', 'viewOtherExpense.php', 0, 803, 0, 0, 0),
(827, 'Transfer', 'viewTransfer.php', 0, 804, 0, 1, 0),
(828, 'Bank Deposit', 'viewDeposit.php', 0, 804, 0, 1, 0),
(829, 'Profit and Loss', 'reportProfitLoss.php', 0, 805, 0, 1, 0),
(830, 'Balance Sheet', 'reportBalanceSheet.php', 0, 805, 0, 0, 0),
(831, 'Period End', 'periodEndSetting.php', 0, 801, 0, 1, 0),
(832, 'Customer Tax', 'viewSalesTaxReport.php', 0, 805, 0, 1, 0),
(833, 'Vendor Tax', 'viewPurchaseTaxReport.php', 0, 805, 0, 1, 0),
(834, 'AR Aging', 'arAging.php', 0, 805, 0, 1, 0),
(835, 'AP Aging', 'apAging.php', 0, 805, 0, 1, 0),
(836, 'Bank Reconciliation', 'bankReconciliation.php', 0, 801, 0, 1, 0),
(837, 'Spiff Setting', 'spiffSetting.php', 0, 810, 0, 1, 2),
(860, 'Manage Customer', 'viewCustomer.php', 0, 802, 0, 1, 0),
(861, 'Customer Order', 'viewCustomerOrderInvoice.php?module=Order', 0, 802, 0, 1, 0),
(862, 'Customer Invoice', 'viewCustomerOrderInvoice.php?module=Invoice', 0, 802, 0, 1, 0),
(863, 'Customer Return', 'viewCustomerReturn.php?module=Return', 0, 802, 0, 1, 0),
(865, 'Invoices', 'viewInvoice.php', 0, 802, 0, 1, 0),
(866, 'Credit Note', 'viewCreditNote.php', 0, 802, 0, 1, 0),
(870, 'Manage Vendor', 'viewSupplier.php', 0, 803, 0, 1, 0),
(871, 'Vendor Purchases', 'viewSuppPO.php', 0, 803, 0, 1, 0),
(872, 'Vendor Invoices', 'viewSuppInvoice.php', 0, 803, 0, 1, 0),
(873, 'Vendor Returns', 'viewSuppReturn.php', 0, 803, 0, 1, 0),
(874, 'Vendor Price List', 'viewSuppPrice.php', 0, 803, 0, 1, 0),
(880, 'Invoices', 'viewPoInvoice.php', 0, 803, 0, 1, 0),
(881, 'Credit Note', 'viewPoCreditNote.php', 0, 803, 0, 1, 0),
(882, 'Invoice Report', 'viewInvReport.php', 0, 803, 0, 1, 0),
(883, 'Payment History', 'viewPaymentReport.php', 0, 803, 0, 1, 0),
(885, 'Payment Term', 'viewTerm.php', 0, 810, 0, 1, 0),
(886, 'Sales Statistics', 'viewSalesStatistics.php', 0, 802, 0, 1, 0),
(887, 'Payment History', 'viewPayReport.php', 0, 802, 0, 1, 0),
(888, 'Sales Commission Report', 'viewSalesCommReport.php', 0, 802, 0, 1, 0);

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`ConfigID`, `RecordsPerPage`, `Tax`, `Shipping`, `PaypalID`, `MetaKeywords`, `MetaDescription`) VALUES
(1, 20, 0.00, 0.00, 'test@gmail.com', '', '');

--
-- Dumping data for table `custom_field`
--

INSERT INTO `custom_field` (`FieldID`, `locationID`, `depID`, `FieldTitle`, `FieldName`, `FieldInfo`, `Module`, `Tab`, `Parent`, `Status`, `OrderBy`) VALUES
(1, 1, 4, 'Tax Number', 'TaxNumber', 'VAT Number', 'Vendor', '', 0, 0, 0);

--
-- Dumping data for table `c_attribute`
--

INSERT INTO `c_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(11, 'LeadSource', 'Lead Source'),
(12, 'LeadStatus', 'Lead Status'),
(13, 'TicketStatus', 'Ticket Status'),
(14, 'Priority', 'Priority'),
(15, 'TicketCategory', 'Ticket Category'),
(16, 'SalesStage', 'Sales Stage'),
(17, 'Type', 'Type'),
(18, 'ActivityStatus', 'Activity Status'),
(19, 'ActivityType', 'Activity Type'),
(51, 'LeadIndustry', 'Lead Industry'),
(52, 'LeadRating', 'Lead Rating'),
(53, 'campaignstatus', 'Campaign Status'),
(54, 'campaigntype', 'Campaign Type'),
(55, 'expectedresponse', 'Expected Response');

--
-- Dumping data for table `c_attribute_value`
--

INSERT INTO `c_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(80, 'Pending', 10, 1, 0),
(81, 'Approved', 10, 1, 0),
(82, 'Taken', 10, 1, 0),
(83, 'Rejected', 10, 1, 0),
(84, 'Cold call', 11, 1, 0),
(86, 'Hot', 12, 1, 0),
(91, 'Entertainment', 18, 1, 1),
(92, 'test rate', 19, 1, 1),
(94, 'Open', 13, 1, 1),
(95, 'In progress', 13, 1, 1),
(96, 'Wait for Response', 13, 1, 1),
(97, 'Low', 14, 1, 1),
(98, 'Normal', 14, 1, 1),
(99, 'High', 14, 1, 1),
(100, 'Urgent', 14, 1, 1),
(101, 'Big Problem', 15, 1, 1),
(102, 'Small Problem', 15, 1, 1),
(103, 'Other Problem', 15, 1, 1),
(104, 'Cold', 12, 1, 2),
(105, 'Warm', 12, 1, 2),
(106, 'Conference', 54, 1, 1),
(107, 'Webinar', 54, 0, 1),
(108, 'Trade Show', 54, 1, 1),
(109, 'Public Relations', 54, 1, 1),
(110, 'Partners', 54, 1, 1),
(111, 'Referral Program', 54, 1, 1),
(112, 'Advertisement', 54, 1, 1),
(113, 'Banner Ads', 54, 1, 1),
(114, 'Direct Mail', 54, 1, 1),
(115, 'Email', 54, 1, 1),
(116, 'Telemarketing', 54, 1, 1),
(117, 'Others', 54, 1, 1),
(118, 'Planning', 53, 1, 1),
(119, 'Active', 53, 1, 1),
(120, 'Inactive', 53, 1, 1),
(121, 'Completed', 53, 1, 1),
(122, 'Cancelled', 53, 1, 1),
(123, 'Excellent', 55, 1, 1),
(124, 'Good', 55, 1, 1),
(125, 'Average', 55, 1, 1),
(126, 'Poor', 55, 1, 1),
(135, 'IT', 51, 1, 1),
(136, 'Bakery & biscuit manufacturer', 51, 0, 1),
(163, 'Retail', 51, 1, 2),
(165, 'Word of Mouth', 11, 1, 1),
(166, 'Website', 11, 1, 1),
(167, 'Tradeshow', 11, 1, 1),
(168, 'Conference', 11, 1, 1),
(169, 'Direct Mail', 11, 1, 1),
(170, 'Public Relation', 11, 1, 1),
(171, 'Partner', 11, 1, 1),
(172, 'Employee', 11, 1, 1),
(173, 'Other', 11, 1, 1),
(174, 'Contacted', 12, 1, 1),
(175, 'Contact in Future', 12, 1, 1),
(176, 'Junk Lead', 12, 1, 1),
(177, 'Lost Lead', 12, 1, 1),
(178, 'Not Contacted', 12, 1, 1),
(179, 'Attempted to Contact', 12, 1, 1),
(180, 'Hospitality', 51, 1, 1),
(181, 'Insurance', 51, 1, 1),
(182, 'Media', 51, 1, 1),
(183, 'Telecommunication', 51, 1, 1),
(184, 'Other', 51, 1, 1),
(185, 'Prospecting', 16, 1, 1),
(186, 'Closed Won', 16, 1, 1),
(187, 'Negotiation or Review', 16, 1, 1),
(188, 'Proposal Or Price Quote', 16, 1, 1),
(189, 'Identify decision maker', 16, 1, 1),
(190, 'Qualification', 16, 1, 1),
(191, 'Closed Lost', 16, 1, 1),
(192, 'Existing Business', 17, 1, 1),
(193, 'New Business', 17, 1, 1),
(194, 'Closed', 13, 1, 1),
(196, 'Planned', 18, 1, 1),
(197, 'Held', 18, 1, 1),
(198, 'Not Held', 18, 1, 1),
(199, 'Call', 19, 1, 1),
(200, 'Meeting', 19, 1, 1);
--
-- Dumping data for table `dashboard_icon`
--

INSERT INTO `dashboard_icon` (`IconID`, `Module`, `Link`, `ModuleID`, `EditPage`, `IframeFancy`, `depID`, `Display`, `Status`, `OrderBy`, `IconType`, `Default`) VALUES
(1, 'Employee', 'viewEmployee.php', 2, 0, '', 1, 1, 1, 1, 2, 0),
(21, 'My Leaves', 'myLeave.php', 3, 0, '', 1, 1, 1, 21, 3, 1),
(11, 'My Timesheet', 'myTimesheet.php', 5, 0, '', 1, 1, 0, 11, 4, 1),
(13, 'My Attendance', 'myAttendence.php', 5, 0, '', 1, 1, 1, 13, 4, 1),
(2, 'Add Employee', 'editEmployee.php', 2, 1, '', 1, 1, 1, 2, 0, 0),
(12, 'Attendance', 'viewAttendence.php', 5, 0, '', 1, 1, 1, 12, 4, 0),
(98, 'Holidays', '#holiday_div', 3, 0, 'f', 1, 1, 1, 0, 3, 1),
(10, 'Timesheet', 'viewTimesheet.php', 5, 0, '', 1, 1, 0, 10, 4, 0),
(4, 'Manage Leave', 'viewLeave.php', 3, 0, '', 1, 1, 1, 4, 5, 0),
(16, 'KRA', 'viewKra.php', 8, 0, '', 1, 1, 1, 16, 5, 0),
(3, 'Apply For Leave', 'applyLeave.php', 3, 0, '', 1, 1, 1, 3, 1, 1),
(116, 'Add Task', 'editActivity.php?module=Activity&mode=Task', 136, 1, '', 5, 0, 0, 16, 0, 0),
(115, 'Add Event', 'editActivity.php?module=Activity&mode=Event', 136, 1, '', 5, 0, 0, 15, 0, 0),
(114, 'Events / Tasks', 'viewActivity.php?module=Activity', 136, 0, '', 5, 1, 1, 14, 4, 0),
(113, 'Calendar', 'calender.php?module=calender', 136, 0, '', 5, 1, 1, 13, 3, 0),
(112, 'Add Quote', 'editQuote.php?module=Quote', 108, 1, '', 5, 1, 1, 12, 0, 0),
(111, 'Quotes', 'viewQuote.php?module=Quote', 108, 0, '', 5, 1, 1, 11, 5, 0),
(110, 'Add Campaign', 'editCampaign.php?module=Campaign', 106, 1, '', 5, 1, 1, 10, 0, 0),
(109, 'Campaign', 'viewCampaign.php?module=Campaign', 106, 0, '', 5, 1, 1, 9, 3, 0),
(108, 'Add Document', 'editDocument.php?module=Document', 105, 1, '', 5, 1, 1, 8, 0, 0),
(107, 'Documents', 'viewDocument.php?module=Document', 105, 0, '', 5, 1, 1, 7, 5, 0),
(106, 'Add Ticket', 'editTicket.php?module=Ticket', 104, 1, '', 5, 1, 1, 6, 0, 0),
(105, 'Tickets', 'viewTicket.php?module=Ticket', 104, 0, '', 5, 1, 1, 5, 5, 0),
(104, 'Add Opportunity', 'editOpportunity.php?module=Opportunity', 103, 1, '', 5, 1, 1, 4, 0, 0),
(5, 'Assign Leave', 'assignLeave.php', 3, 1, '', 1, 1, 1, 5, 1, 0),
(15, 'Generate Salary', 'generateSalary.php', 12, 1, '', 1, 1, 1, 15, 1, 0),
(103, 'Opportunities', 'viewOpportunity.php?module=Opportunity', 103, 0, '', 5, 1, 1, 3, 5, 0),
(102, 'Add Lead', 'editLead.php?module=lead', 102, 1, '', 5, 1, 1, 2, 0, 0),
(101, 'Lead', 'viewLead.php?module=lead', 102, 0, '', 5, 1, 1, 1, 5, 0),
(18, 'Training', 'viewTraining.php', 13, 0, '', 1, 1, 1, 18, 5, 0),
(210, 'Add Product', 'editProduct.php', 201, 1, '', 2, 1, 1, 1, 0, 0),
(201, 'Products', 'viewProduct.php', 201, 0, '', 2, 1, 1, 1, 5, 0),
(202, 'Categories', 'viewCategory.php', 201, 0, '', 2, 1, 1, 2, 5, 0),
(206, 'Manufacturers', 'viewManufacturer.php', 201, 0, '', 2, 1, 1, 6, 5, 0),
(203, 'Store Settings', 'cartSetting.php?module=1', 204, 0, '', 2, 1, 1, 3, 1, 0),
(207, 'Send Newsletter', 'emailNewsletter.php', 206, 1, '', 2, 1, 1, 7, 1, 0),
(208, 'Manage Pages', 'viewPages.php', 204, 0, '', 2, 1, 1, 8, 5, 0),
(209, 'Tax Class', 'viewTaxClass.php', 202, 0, '', 2, 1, 1, 0, 1, 0),
(204, 'Orders', 'viewOrder.php', 205, 0, '', 2, 1, 1, 4, 3, 0),
(205, 'Customers', 'viewCustomer.php', 205, 0, '', 2, 1, 1, 5, 2, 0),
(14, 'Payroll', 'viewSalary.php', 12, 0, '', 1, 1, 1, 14, 3, 0),
(22, 'My Profile', 'myProfile.php', 2, 0, '', 1, 1, 1, 22, 2, 1),
(17, 'Review', 'viewReview.php', 8, 0, '', 1, 1, 1, 17, 3, 0),
(23, 'My Declaration', 'myDeclaration.php', 12, 0, '', 1, 1, 1, 23, 1, 1),
(9, 'Add Candidate', 'editCandidate.php?module=Manage', 4, 1, '', 1, 1, 1, 9, 0, 0),
(8, 'Candidates', 'viewCandidate.php?module=Manage', 4, 0, '', 1, 1, 1, 8, 2, 0),
(7, 'Add Vacancy', 'editVacancy.php', 4, 1, '', 1, 1, 1, 7, 0, 0),
(6, 'Vacancies', 'viewVacancy.php', 4, 0, '', 1, 1, 1, 6, 5, 0),
(97, 'Directory', 'viewDirectory.php?pop=1', 10, 0, 'i', 1, 1, 1, 0, 3, 0),
(99, 'Punch In/Out', 'puching.php', 5, 0, 'i', 1, 1, 1, 0, 4, 1),
(24, 'Report', 'viewLeaveReport.php', 30, 0, '', 1, 1, 1, 24, 3, 0),
(301, 'Warehouse', 'viewWarehouse.php', 301, 0, '', 3, 1, 1, 1, 0, 0),
(303, 'Bin', 'viewManageBin.php', 301, 0, '', 3, 1, 1, 2, 3, 0),
(305, 'Ship Transfer Order', 'viewTransferOrder.php', 304, 0, '', 3, 1, 1, 9, 1, 0),
(307, 'Assemble Order', 'viewProduction.php', 303, 0, '', 3, 1, 1, 6, 0, 0),
(309, 'Pick & Put Qty', 'viewInternalBinOrder.php', 303, 0, '', 3, 1, 1, 7, 0, 0),
(311, 'Cargo', 'viewCargo.php', 305, 0, '', 3, 1, 1, 10, 0, 0),
(313, 'Ship Sales Order', 'viewSale.php', 302, 0, '', 3, 1, 1, 4, 4, 0),
(314, 'Receive PO', 'viewPoInvoice.php', 302, 0, '', 3, 1, 1, 3, 3, 0),
(315, 'Stock Transfer', 'viewStockTransfer.php', 302, 0, '', 3, 1, 1, 5, 3, 0),
(401, 'Vendor', 'viewSupplier.php', 401, 0, '', 4, 1, 1, 0, 2, 0),
(402, 'Add Vendor', 'editSupplier.php', 401, 1, '', 4, 1, 1, 0, 0, 0),
(403, 'Purchase Quote', 'viewPO.php?module=Quote', 402, 0, '', 4, 1, 1, 0, 2, 0),
(404, 'Add Quote', 'editPO.php?module=Quote', 402, 1, '', 4, 1, 1, 0, 0, 0),
(405, 'Purchase Order', 'viewPO.php?module=Order', 403, 0, '', 4, 1, 1, 0, 2, 0),
(406, 'Add PO', 'editPO.php?module=Order', 403, 1, '', 4, 1, 1, 0, 0, 0),
(407, 'Invoices', 'viewPoInvoice.php', 404, 0, '', 4, 1, 1, 0, 2, 0),
(408, 'Receive Order', 'PoList.php?link=recieveOrder.php', 404, 1, 'i', 4, 1, 1, 0, 0, 0),
(409, 'Returns', 'viewReturn.php', 405, 0, '', 4, 1, 1, 0, 2, 0),
(410, 'Add Return', 'PoList.php?link=editReturn.php', 405, 1, 'i', 4, 1, 1, 0, 0, 0),
(411, 'Credit Note', 'viewPoCreditNote.php', 407, 0, '', 4, 1, 1, 0, 2, 0),
(412, 'Add Credit Note', 'editPoCreditNote.php', 407, 1, '', 4, 1, 1, 0, 0, 0),
(413, 'PO Report', 'viewPoReport.php', 409, 0, '', 4, 1, 1, 0, 2, 0),
(414, 'Invoice Report', 'viewInvReport.php', 409, 0, '', 4, 1, 0, 0, 0, 0),
(415, 'Payment History', 'viewPayReport.php', 409, 0, '', 4, 1, 0, 0, 2, 0),
(701, 'Customer', 'viewCustomer.php', 701, 0, '', 7, 1, 1, 0, 2, 0),
(702, 'Add Customer', 'addCustomer.php', 701, 1, '', 7, 1, 1, 0, 0, 0),
(703, 'Sales Quote', 'viewSalesQuoteOrder.php?module=Quote', 702, 0, '', 7, 1, 1, 0, 2, 0),
(704, 'Add Quote', 'editSalesQuoteOrder.php?module=Quote', 702, 1, '', 7, 1, 1, 0, 0, 0),
(705, 'Sales Order', 'viewSalesQuoteOrder.php?module=Order', 703, 0, '', 7, 1, 1, 0, 2, 0),
(706, 'Add SO', 'editSalesQuoteOrder.php?module=Order', 703, 1, '', 7, 1, 1, 0, 0, 0),
(707, 'Invoices', 'viewInvoice.php', 704, 0, '', 7, 1, 1, 0, 2, 0),
(709, 'Returns', 'viewReturn.php', 705, 0, '', 7, 1, 1, 0, 2, 0),
(710, 'Add Return', 'SoList.php', 705, 1, 'i', 7, 1, 1, 0, 0, 0),
(715, 'Report', 'viewSalesbyCustomer.php', 706, 0, '', 7, 1, 1, 0, 2, 0),
(716, 'Sales Statistics', 'viewSalesStatistics.php', 706, 0, '', 7, 1, 0, 0, 2, 0),
(601, 'Items', 'viewItem.php', 601, 0, '', 6, 1, 1, 1, 2, 0),
(602, 'Add Item', 'editItem.php', 601, 1, '', 6, 1, 1, 0, 0, 0),
(603, 'Categories', 'viewCategory.php', 601, 0, '', 6, 1, 1, 0, 2, 0),
(604, 'Add Category', 'editCategory.php', 601, 1, '', 6, 1, 1, 0, 0, 0),
(605, 'Price List', 'viewPriceList.php', 601, 0, '', 6, 1, 1, 0, 2, 0),
(606, 'Stock Adjustment', 'viewAdjustment.php', 602, 1, '', 6, 1, 1, 0, 0, 0),
(607, 'Stock Transfers', 'viewTransfer.php', 603, 0, '', 6, 1, 1, 0, 2, 0),
(608, 'BOM', 'viewBOM.php', 604, 1, '0', 6, 1, 1, 0, 0, 0),
(122, 'Add Customer', 'addCustomer.php', 2015, 1, '', 5, 1, 1, 22, 0, 0),
(120, 'Add Item', 'editItem.php', 2003, 1, '', 5, 1, 1, 20, 0, 0),
(121, 'Customer', 'viewCustomer.php', 2015, 0, '', 5, 1, 1, 21, 2, 0),
(119, 'Items', 'viewItem.php', 2003, 0, '', 5, 1, 1, 19, 2, 0),
(117, 'Users', 'viewUser.php', 2001, 0, '', 5, 1, 1, 17, 2, 0),
(118, 'Add User', 'editUser.php', 2001, 1, '', 5, 1, 1, 18, 0, 0),
(609, 'Users', 'viewUser.php', 2005, 0, '', 6, 1, 1, 0, 2, 0),
(610, 'Add User', 'editUser.php', 2005, 1, '', 6, 1, 1, 0, 0, 0),
(612, 'Stock Search', 'searchItemStock.php', 601, 1, '0', 6, 1, 1, 2, 0, 0),
(801, 'Chart of Accounts', 'viewAccount.php', 801, 0, '', 8, 1, 1, 1, 2, 0),
(802, 'AR Cash Receipt', 'viewSalesPayments.php', 802, 0, '', 8, 1, 1, 2, 2, 0),
(803, 'AP Payments', 'viewPurchasePayments.php', 803, 0, '', 8, 1, 1, 3, 2, 0),
(804, 'Journal Entry', 'viewGeneralJournal.php', 804, 0, '', 8, 1, 1, 4, 2, 0),
(805, 'Profit and Loss', 'reportProfitLoss.php', 805, 0, '', 8, 1, 1, 5, 2, 0),
(806, 'Balance Sheet', 'reportBalanceSheet.php', 805, 0, '', 8, 1, 1, 6, 2, 0),
(807, 'Customer', 'viewCustomer.php', 802, 0, '', 8, 1, 1, 7, 2, 0),
(808, 'AR Invoices', 'viewInvoice.php', 802, 0, '', 8, 1, 1, 8, 2, 0),
(809, 'Sales Commission', 'viewSalesCommReport.php', 802, 0, '', 8, 1, 1, 9, 2, 0),
(810, 'Vendor', 'viewSupplier.php', 803, 0, '', 8, 1, 1, 10, 2, 0),
(811, 'AP Invoices', 'viewPoInvoice.php', 803, 0, '', 8, 1, 1, 11, 2, 0),
(812, 'Receive Payment', 'receivePayment.php', 802, 0, '', 8, 1, 1, 2, 2, 0),
(813, 'Pay Vendor', 'payVendor.php', 803, 0, '', 8, 1, 1, 3, 2, 0);


--
-- Dumping data for table `department`
--

INSERT INTO `department` (`depID`, `Department`, `Status`) VALUES
(1, 'HRMS', 1),
(2, 'E-Commerce', 1),
(3, 'Warehouse', 1),
(4, 'Purchasing', 1),
(5, 'CRM', 1),
(6, 'Inventory', 1),
(7, 'Sales', 1),
(8, 'Finance', 1);

--
-- Dumping data for table `email_cat`
--

INSERT INTO `email_cat` (`CatID`, `department`, `Name`, `OrderLevel`) VALUES
(1, 5, 'Lead Assign', 0),
(2, 5, 'New Lead', 0),
(3, 5, 'New Opportunity', 0),
(4, 5, 'Opportunity Assign', 0),
(5, 5, 'New Ticket', 0),
(6, 5, 'Ticket Assign', 0),
(7, 5, 'New Quote', 0),
(8, 5, 'Quote Assign', 0);

--
-- Dumping data for table `email_template`
--


INSERT INTO `email_template` (`TemplateID`, `CatID`, `Title`, `subject`, `Content`, `arr_field`, `Status`) VALUES
(1, 1, NULL, 'New Lead  has been Assigned to You', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Lead  has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below Lead details : <br />\r\n            <br />\r\n            First Name:&nbsp;[FIRSTNAME]<br />\r\n            <br />\r\n            Last Name:&nbsp;[LASTNAME]<br />\r\n            <br />\r\n            Lead Name:&nbsp;[FIRSTNAME] [LASTNAME]<br />\r\n            <br />\r\n            Title:&nbsp;[TITLE]<br />\r\n            <br />\r\n            Primary Email:&nbsp;[PRIMARYEMAIL]<br />\r\n            <br />\r\n            Company:&nbsp;[COMPANY]<br />\r\n            <br />\r\n            Website:&nbsp;[WEBSITE]<br />\r\n            <br />\r\n            Sales Person:&nbsp;[ASSIGNEDTO]<br />\r\n            <br />\r\n            Product:&nbsp;[PRODUCT]<br />\r\n            <br />\r\n            Product Price:&nbsp;[PRODUCTPRICE]<br />\r\n            <br />\r\n            Annual Revenue:&nbsp;[ANNUALREVENUE]<br />\r\n            <br />\r\n            Number Of Employees:&nbsp;[NUMBEROFEMPLOYEES]<br />\r\n            <br />\r\n            Last Contact Date:&nbsp;[LASTCONTACTDATE]<br />\r\n            <br />\r\n            Lead Source:&nbsp;[LEADSOURCE]<br />\r\n            <br />\r\n            Lead Status:&nbsp;[LEADSTATUS]<br />\r\n            <br />\r\n            Lead Date: &nbsp;[LEADDATE]<br />\r\n            <br />\r\n            Description:&nbsp;[DESCRIPTION]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">Sakshay Web Technology Pvt Ltd.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(2, 2, NULL, 'New Lead  has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Lead  has been submitted on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below Lead details : <br />\r\n            <br />\r\n            Lead Name: [FIRSTNAME][LASTNAME]<br />\r\n            <br />\r\n            Title: [TITLE]<br />\r\n            <br />\r\n            Primary Email: [PRIMARYEMAIL]<br />\r\n            <br />\r\n            Sales Person: [ASSIGNEDTO]<br />\r\n            <br />\r\n            Company            : [COMPANY]   <br />\r\n            <br />\r\n            Product:&nbsp;[PRODUCT]<br />\r\n            <br />\r\n            Product Price:&nbsp;[PRODUCTPRICE]<br />\r\n            <br />\r\n            Lead Source:&nbsp;[LEADSOURCE]<br />\r\n            <br />\r\n            Lead Status:&nbsp;[LEADSTATUS]<br />\r\n            <br />\r\n            Lead Date:&nbsp;[LEADDATE]<br />\r\n            <br />\r\n            Description        : [DESCRIPTION]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">Sakshay Web Technology Pvt. Ltd.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(3, 3, NULL, 'New Opportunity  has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">Dear Administrator,<br />\r\n<table cellspacing="5" cellpadding="5" border="0" width="100%" class="tablenormal">\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">\r\n            <p><br />\r\n            New Opportunity  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n            <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Opportunity Name          : [OPPORTUNITYNAME]<br />\r\n            <br />\r\n            Organization&nbsp;&nbsp; : [ORGANIZATIONNAME]<br />\r\n            <br />\r\n            Expected Close Date    :[EXPECTEDCLOSEDATE]<br />\r\n            <br />\r\n            Amount      :[AMOUNT]<br />\r\n            <br />\r\n            Sale stage              : [SALESSTAGE]<br />\r\n            <br />\r\n            Assign To :[ASSIGNEDTO]<br />\r\n            <br />\r\n            Customer&nbsp; :[CUSTOMER]<br />\r\n            <br />\r\n            Lead Source :[LEADSOURCE]<br />\r\n            <br />\r\n            Industry : [INDUSTRY]<br />\r\n            <br />\r\n            Next Step :[NEXTSTEP]<br />\r\n            <br />\r\n            Opportunity Type :[OPPORTUNITYTYPE]<br />\r\n            <br />\r\n            Probability :[PROBABILITY]<br />\r\n            <br />\r\n            Campaign Source :[CAMPAIGNSOURCE]<br />\r\n            <br />\r\n            Forcast Amount:[FORECASTAMOUNT]<br />\r\n            <br />\r\n            Contact Name           :[CONTACTNAME]<br />\r\n            <br />\r\n            Website :[WEBSITE]<br />\r\n            <br />\r\n            Description :[DESCRIPTION]<br />\r\n            <br />\r\n            Sales Person       : [ASSIGNEDTO]<br />\r\n            &nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(4, 4, NULL, 'New Opportunity  has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Opportunity  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Opportunity Name          : [OPPORTUNITYNAME]<br />\r\n            <br />\r\n            Organization&nbsp;&nbsp; : [ORGANIZATIONNAME]<br />\r\n            <br />\r\n            Expected Close Date    :[EXPECTEDCLOSEDATE]<br />\r\n            <br />\r\n            Amount      :[AMOUNT]<br />\r\n            <br />\r\n            Sale stage              : [SALESSTAGE]<br />\r\n            <br />\r\n            Sales Person :[ASSIGNEDTO]<br />\r\n            <br />\r\n            Customer&nbsp; :[CUSTOMER]<br />\r\n            <br />\r\n            Lead Source :[LEADSOURCE]<br />\r\n            <br />\r\n            Industry :[INDUSTRY]<br />\r\n            <br />\r\n            Next Step :[NEXTSTEP]<br />\r\n            <br />\r\n            Opportunity Type :[OPPORTUNITYTYPE]<br />\r\n            <br />\r\n            Probability :[PROBABILITY]<br />\r\n            <br />\r\n            Campaign Source :[CAMPAIGNSOURCE]<br />\r\n            <br />\r\n            Forcast Amount:[FORECASTAMOUNT]<br />\r\n            <br />\r\n            Contact Name           :[CONTACTNAME]<br />\r\n            <br />\r\n            Website :[WEBSITE]<br />\r\n            <br />\r\n            Description :[DESCRIPTION]<br />\r\n            <br />\r\n            <br />\r\n            &nbsp;\r\n            <p>&nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(5, 5, NULL, 'New Ticket  has been Added', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket  has been Added with [PARENT] [[PARENTID]] on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE]    <br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Generate Date         : [CREATEDON]<br />\r\n            <br />\r\n            Priority             : [PRIORITY]   <br />\r\n            <br />\r\n            Description          :[DESCRIPTION]<br />\r\n            <br />\r\n            Status&nbsp;&nbsp; :[STATUS]<br />\r\n            <br />\r\n            Priority&nbsp; : [PRIORITY]<br />\r\n            <br />\r\n            Category&nbsp; :[CATEGORY]<br />\r\n            <br />\r\n            Days : [DAYS]<br />\r\n            <br />\r\n            Hours :[HOURS]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            Assign To:&nbsp;[ASSIGNEDTO]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[Sakshay Web Technology]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(6, 6, NULL, 'Ticket  has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE] <br />\r\n            <br />\r\n            Ticket Status:&nbsp;[STATUS]<br />\r\n            <br />\r\n            Ticket Priority:&nbsp;[PRIORITY]<br />\r\n            <br />\r\n            Sales Person:&nbsp;[ASSIGNEDTO]<br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Days:&nbsp;[DAYS]<br />\r\n            <br />\r\n            Hours:&nbsp;[HOURS]<br />\r\n            <br />\r\n            Description          : [DESCRIPTION]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            Created Date:&nbsp;[CREATEDON]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(8, 8, NULL, 'New Quote has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td width="339" class="blacknormal">New Quote  has been Assigned  on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below his Quote details : <br />\r\n            <br />\r\n            <br />\r\n            Quote Subject          :  [SUBJECT]<br />\r\n            <br />\r\n            Opportunity/Customer:&nbsp;[CUSTOMERTYPE]<br />\r\n            <br />\r\n            Quote Stage : [QUOTESTAGE]<br />\r\n            <br />\r\n            Carrier : [CARRIER]<br />\r\n            <br />\r\n            Sales Person : [ASSIGNEDTO]<br />\r\n            <br />\r\n            Valid till    :  [VALIDTILL]<br />\r\n            <br />\r\n            <br />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till', 1),
(7, 7, NULL, 'New quote has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td width="339" class="blacknormal">New quote  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below the quote details : <br />\r\n            <br />\r\n            Quote ID          :  [QUOTEID]<br />\r\n            <br />\r\n            Subject          :  [SUBJECT]<br />\r\n            <br />\r\n            Opportunity : [OPPORTUNITY]<br />\r\n            <br />\r\n            Type : [CUSTOMERTYPE]<br />\r\n            <br />\r\n            Quote Stage : [QUOTESTAGE]<br />\r\n            <br />\r\n            Carrier : [CARRIER]<br />\r\n            <br />\r\n            Valid Till : [VALIDTILL]<br />\r\n            <br />\r\n            Created By : [CREATED]<br />\r\n            <br />\r\n            Sales Person : [ASSIGNEDTO]<br />\r\n            <br />\r\n            Amount : [TOTALAMOUNT]<br />\r\n            <br />\r\n            Please <a href="[LINK_URL]">Click here</a> to see full detail of this quote.</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till,CREATED,Opportunity,Total Amount', 1);




--
-- Dumping data for table `e_customer_group`
--

INSERT INTO `e_customer_group` (`GroupID`, `GroupName`, `GroupCreated`, `Status`) VALUES
(1, 'General', 'default', 'Yes'),
(2, 'Wholesale', 'default', 'Yes'),
(5, 'Sakshay', 'admin', 'Yes');

--
-- Dumping data for table `e_delhivery_status`
--

INSERT INTO `e_delhivery_status` (`delhiveryID`, `DelhiveryStatus`, `Status`) VALUES
(1, 'Pending', 'Yes'),
(2, 'Dispatched', 'Yes'),
(3, 'Delivered', 'Yes'),
(4, 'Returned', 'Yes');

--
-- Dumping data for table `e_pages`
--

INSERT INTO `e_pages` (`PageId`, `Priority`, `Status`, `Options`, `UrlCustom`, `UrlHash`, `Name`, `MetaKeywords`, `MetaTitle`, `MetaDescription`, `Title`, `Content`) VALUES
(4, 1, 'Yes', 'top', 'about_us', '54b9a8865a965755ad90cdab15541375', 'About Us', 'About Us', 'About Us', 'About Us', 'About Us', '<span style="background-color: Yellow;"><strong>Lorem Ipsum</strong></span> is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not  only five centuries, but also the leap into electronic typesetting,  remaining essentially unchanged. It was popularised in the 1960s with  the release of Letraset sheets containing Lorem Ipsum passages, and more  recently with desktop publishing software like Aldus PageMaker  including versions of Lorem Ipsum.  about us'),
(8, 4, 'Yes', 'top', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Specials', 'Specials', 'Specials', 'Specials', 'Specials', 'It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).'),
(6, 3, 'Yes', 'top', 'contact_us', '53a2c328fefc1efd85d75137a9d833ab', 'Contact Us', 'Contact Us', 'Contact Us', 'Contact Us', 'Contact Us', 'It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).'),
(7, 2, 'Yes', 'top', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '<strong>Lorem Ipsum</strong> is simply dummy text of the printing and \r\ntypesetting industry. Lorem Ipsum has been the industry''s standard dummy\r\n text ever since the 1500s, when an unknown printer took a galley of \r\ntype and scrambled it to make a type specimen book. It has survived not \r\nonly five centuries, but also the leap into electronic typesetting, \r\nremaining essentially unchanged. It was popularised in the 1960s with \r\nthe release of Letraset sheets containing Lorem Ipsum passages, and more\r\n recently with desktop publishing software like Aldus PageMaker \r\nincluding versions of Lorem Ipsum.'),
(9, 5, 'Yes', 'top', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Others', 'Others', 'Others', 'Others', 'Others', '<h2 class="where">&nbsp;</h2>\r\n<p>&Icirc;n ciuda opiniei publice, Lorem Ipsum nu e un  simplu text fÄƒrÄƒ sens. El &icirc;ÅŸi are rÄƒdÄƒcinile &icirc;ntr-o bucatÄƒ a literaturii  clasice latine din anul 45 &icirc;.e.n., fÄƒc&acirc;nd-o sÄƒ aibÄƒ mai bine de 2000  ani. Profesorul universitar de latinÄƒ de la colegiul Hampden-Sydney din  Virginia, Richard McClintock, a cÄƒutat &icirc;n bibliografie unul din cele mai  rar folosite cuvinte latine &quot;consectetur&quot;, &icirc;nt&acirc;lnit &icirc;n pasajul Lorem  Ipsum, ÅŸi cÄƒut&acirc;nd citate ale cuv&acirc;ntului respectiv &icirc;n literatura clasicÄƒ,  a descoperit la modul cel mai sigur sursa provenienÅ£ei textului. Lorem  Ipsum provine din secÅ£iunile 1.10.32 ÅŸi 1.10.33 din &quot;de Finibus Bonorum  et Malorum&quot; (Extremele Binelui ÅŸi ale RÄƒului) de Cicerone, scrisÄƒ &icirc;n  anul 45 &icirc;.e.n. AceastÄƒ carte este un tratat &icirc;n teoria eticii care a fost  foarte popular &icirc;n perioada Renasterii. Primul r&acirc;nd din Lorem Ipsum,  &quot;Lorem ipsum dolor sit amet...&quot;, a fost luat dintr-un r&acirc;nd din secÅ£iunea  1.10.32.</p>\r\n<p>Pasajul standard de Lorem Ipsum folosit &icirc;ncÄƒ din secolul  al XVI-lea este reprodus mai jos pentru cei interesaÅ£i. SecÅ£iunile  1.10.32 ÅŸi 1.10.33 din &quot;de Finibus Bonorum et Malorum&quot; de Cicerone sunt  de asemenea reproduse &icirc;n forma lor originalÄƒ, im</p>');

--
-- Dumping data for table `e_payment_gateway`
--

INSERT INTO `e_payment_gateway` (`PaymentID`, `PaymentMethodName`, `PaymetMethodId`, `PaymentMethodUrl`, `PaymetMethodType`, `PaymentMethodTitle`, `PaymentMethodMessage`, `Priority`, `PaymentMethodDescription`, `Status`, `PaymentCofigure`) VALUES
(6, 'Cash On Delivery', 'cashondelivary', '', 'custom', 'Cash On Delivery', 'Cash On Delivery Method<br />', 2, 'Cash On Delivery Method<br />', 'Yes', 'Yes'),
(7, 'PayPal Payments Standard', 'paypalipn', 'https://www.paypal.com/cgi-bin/webscr', 'ipn', 'PayPal Payments Standard', '<p><b>You have selected PayPal Website Payments Standard as your payment method.</b></p>\r\n<p>To complete this transaction, it is necessary to send you to PayPal.com.</p>\r\n<p>After the transaction is complete, you will be returned to our site.</p>', 2, 'PayPal Payments Standard:  Add a PayPal payment button to your site to accept Visa, MasterCardï¿½, American Express, Discover and PayPal payments securely. When your customers check out, they are redirected to PayPal to pay, then return to your site after theyï¿½re finished.', 'Yes', 'Yes');

--
-- Dumping data for table `e_settings`
--

INSERT INTO `e_settings` (`visible`, `input_type`, `GroupID`, `GroupName`, `Priority`, `Name`, `Value`, `Options`, `DefaultValue`, `Validation`, `Caption`, `Description`) VALUES
('Yes', 'select', 3, 'Bestsellers Settings', 1, 'BestsellersAvailable', 'Yes', 'Yes, No', 'No', 'No', 'Bestsellers Available', 'Do you want the Bestsellers box to be displayed?'),
('Yes', 'select', 3, 'Bestsellers Settings', 2, 'BestsellersCount', '5', '1, 2, 3, 4, 5, 6, 7,8,9,10', '10', '', 'Bestsellers Count', 'Number of Bestsellers to be displayed in Bestsellers box.'),
('Yes', 'select', 3, 'Bestsellers Settings', 3, 'BestsellersPeriod', 'Month', 'Month, 2 \r\nMonths, 3\r\nMonths, 6 \r\nMonths, Year', '2 Months', '', 'Bestsellers Period', 'Bestseller Period'),
('Yes', 'text', 1, 'Store Settings', 1, 'StoreName', 'MKB Web Solution', '', '', 'Yes', 'Store Name', NULL),
('Yes', 'text', 1, 'Store Settings', 3, 'NotificationEmail', 'suruchi.bisht@sakshay.in', '', '', 'Yes', 'Notification Email', 'Email address for Administrator emails.'),
('Yes', 'text', 1, 'Store Settings', 4, 'SupportEmail', 'support@site.com', '', '', 'Yes', 'Support Email', 'Email address for your customer service department.'),
('Yes', 'select', 1, 'Store Settings', 5, 'HttpsUrlEnable', 'No', 'Yes,No', 'No', 'No', 'Https Url Enable', 'Enable Https Url For Checkout Page.'),
('Yes', 'select', 1, 'Store Settings', 6, 'StoreClosed', 'No', 'Yes,No', 'No', 'No', 'Store Down', 'If this is Yes, the store will display a page saying that the store is closed'),
('Yes', 'text', 1, 'Store Settings', 7, 'StoreClosedMessage', 'The store is closed.', '', 'The store is closed', 'No', 'Store Down Message', NULL),
('Yes', 'select', 2, 'Social Settings', 1, 'facebookLikeButtonProduct', 'Yes', 'Yes,No', 'No', 'No', 'Facebook Like Button on a product page', 'The Like button lets users share product pages from your site back to their Facebook profile with one click.'),
('Yes', 'text', 2, 'Social Settings', 2, 'TwitterAccount', '', '', '', 'No', 'Twitter account', 'Twitter account for users to follow after they share content from your website.'),
('Yes', 'select', 2, 'Social Settings', 3, 'TwitterTweetButton', 'Yes', 'Yes,No', 'No', 'No', 'Tweet button on a product page', 'Add this button to your website to let people share content on Twitter without having to leave the page. Promote strategic Twitter accounts at the same time while driving traffic to your website'),
('Yes', 'select', 2, 'Social Settings', 4, 'GooglePlusButton', 'Yes', 'Yes,No', 'No', 'No', ' Post to Google Plus from a product page ', 'Help people share stuff from your website in Google Plus.'),
('Yes', 'test', 1, 'Store Settings', 2, 'CompanyEmail', 'nitin.sharma@sakshay.in', '', '', 'Yes', 'Company Email', NULL),
('Yes', 'text', 4, 'payment_paypalipn', 1, 'paypalipn_business', 'rajeev@sakshay.in', '', '', 'Yes', 'Email address for PayPal', 'PayPal Account ID'),
('Yes', 'select', 1, 'Store Settings', 8, 'AfterProductAddedGoTo', 'Cart Page', 'Current Page, Cart Page', 'Current Page', 'No', 'After Product Added Go To', 'What page do you want your users to be on after they have added a product to the shopping cart?'),
('Yes', 'select', 1, 'Store Settings', 9, 'EnableWishList', 'Yes', 'Yes,No', 'No', 'No', 'Enable WishList', 'Would you like your customers to use wish list feature?'),
('Yes', 'select', 1, 'Store Settings', 10, 'EnableEmailToFriend', 'Yes', 'Yes,No', 'No', 'No', 'Enable Email To Friend', NULL),
('Yes', 'select', 1, 'Store Settings', 11, 'InventoryStockUpdateAt', 'Order Placed', 'Order Completed,Payment Received,Order Placed', 'Order Completed', 'No', 'Inventory Stock Update At', 'When do you want to update stock count?'),
('Yes', 'select', 1, 'Store Settings', 12, 'ClearCartOnLogout', 'No', 'Yes,No', 'No', 'No', 'Clear Cart On Logout', 'Remove items from a cart when user logs out?'),
('Yes', 'select', 1, 'Store Settings', 13, 'EnableGuestCheckout', 'Yes', 'Yes,No', 'No', 'No', 'Enable Guest Checkout', NULL),
('Yes', 'select', 4, 'payment_paypalipn', 3, 'paypalipn_Currency_Code', 'USD', 'AUD, BRL, CAD, CHF, CZK, DKK, EUR, GBP, HKD, HUF, ILS, JPY, MXN, MYR, NOK, NZD, PHP, PLN, SEK, SGD, THB, TRY, TWD, USD', 'USD', 'No', 'Paypal  Currency Code ', 'PayPal-Supported Currencies and Max Amount || \r\n AUD- Australian Dollar - 12,500 AUD || \r\n CAD- Canadian Dollar-12,500 CAD ||\r\n EUR- Euro - 8,000 EUR || \r\n GBP- Pound Sterling - 5,500 GBP || \r\nJPY- Japanese Yen - 1,000,000 JPY || \r\nUSD- U.S. Dollar - 10,000 USD\r\n'),
('Yes', 'select', 4, 'payment_paypalipn', 2, 'paypalipn_Mode', 'TEST', 'LIVE, TEST', '', 'No', 'Payment Mode', 'PayPal Mode'),
('Yes', 'hidden', 0, 'Discounts', 0, 'DiscountsActive', 'Yes', '', '', 'No', NULL, NULL),
('Yes', 'select', 1, 'Store Settings', 14, 'FeaturedProductsCount', '9', '3,6,9,12,15,18,21,24,27,30', '12', 'No', 'Featured Products Count', 'Number of Featured Products to be displayed on home page.'),
('Yes', 'select', 3, 'Bestsellers Settings', 1, 'BestsellersDisplay', 'left', 'left,top', 'left', 'No', 'Bestsellers Display', NULL),
('Yes', 'hidden', 0, 'Discounts', 0, 'DiscountsPromo', 'Yes', '', 'No', 'No', NULL, NULL);

--
-- Dumping data for table `e_tax_classes`
--

INSERT INTO `e_tax_classes` (`ClassId`, `ClassName`, `ClassDescription`, `Status`) VALUES
(1, 'General', 'General Desc', 'Yes'),
(4, 'Standard', 'Standard', 'Yes');

-- --------------------------------------------------------

--
-- Dumping data for table `f_attribute`
--

INSERT INTO `f_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(2, 'AccountType', 'Account Type'),
(1, 'PaymentMethod', 'Payment Method'),
(3, 'Expenses', 'Expenses'),
(4, 'Income', 'Income');

--
-- Dumping data for table `f_attribute_value`
--

INSERT INTO `f_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(1, 'Current', 2, 1, 1),
(2, 'Savings', 2, 1, 1),
(3, 'Credit Card', 2, 1, 1),
(4, 'Loan', 2, 1, 1),
(13, 'Other', 2, 1, 2),
(31, 'NetBanking', 1, 1, 1),
(7, 'Cash', 1, 1, 1),
(8, 'Direct Debit', 1, 1, 1),
(9, 'Credit Card', 1, 1, 1),
(10, 'Electronic Transfer', 1, 1, 1),
(17, 'General expenses', 3, 1, 1),
(14, 'Bank charges & interest', 4, 1, 1),
(15, 'Other Income', 4, 1, 1),
(16, 'Sales', 4, 1, 1),
(18, 'Marketing', 3, 1, 1),
(19, 'Rent &amp; Rates', 3, 1, 1),
(20, 'Travel and Entertainment', 3, 1, 1),
(21, 'Insurance', 3, 1, 1),
(22, 'Office costs', 3, 1, 1),
(23, 'Repairs and renewals', 3, 1, 1),
(30, 'Check', 1, 1, 1);


CREATE TABLE IF NOT EXISTS `f_spiff` (
 `SpiffID` int(11) NOT NULL AUTO_INCREMENT,
 `GLAccountTo` int(11) NOT NULL,
 `GLAccountFrom` int(11) NOT NULL,
 `PaymentTerm` varchar(100) NOT NULL,
 `PaymentMethod` varchar(100) NOT NULL,
 PRIMARY KEY (`SpiffID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`visible`, `input_type`, `group_id`, `group_name`, `caption`, `setting_key`, `setting_value`, `options`, `validation`, `dep_id`, `priority`) VALUES
('Yes', 'text', 1, 'Global Settings', 'Notification Email', 'Notification_Email', 'notifications@site.com', '', 'No', 8, 2),
('Yes', 'text', 1, 'Global Settings', 'Journal Prefix', 'JOURNAL_NO_PREFIX', 'JN', '', 'No', 8, 1),
('Yes', 'text', '1', 'Global Settings', 'Fiscal Year', 'FiscalYearStartDate', NULL, '', 'No', '8', '0'),
 ('Yes', 'text', '1', 'Global Settings', 'Fiscal Year', 'FiscalYearEndDate', NULL, '', 'No', '8', '0')
;


--
-- Dumping data for table `f_bank_account`
--

INSERT INTO `f_bank_account` (`BankAccountID`, `ParentAccountID`, `BankName`, `AccountName`, `AccountNumber`, `AccountType`, `AccountCode`, `Address`, `LocationID`, `Balance`, `Currency`, `Status`, `OrderBy`, `IPAddress`, `CreatedDate`, `UpdateddDate`, `CashFlag`) VALUES
(2, 0, '', 'Accounts Payable', '843056905343', 14, '001', 'test', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-19', '0000-00-00', 1),
(3, 0, '', 'Accounts Receivable', '8430569053437', 12, '002', 'test', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-19', '0000-00-00', 1),
(4, 0, '', 'Cash on hand', '8430569053434', 16, '003', 'test', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-19', '0000-00-00', 1),
(5, 0, '', 'Savings', '9383883883', 16, '0003', 'test', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-19', '0000-00-00', 1),
(6, 0, '', 'Current', '9843056905343', 16, '11001', 'test', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-19', '0000-00-00', 1),
(7, 0, '', 'Credit Card', '865865757565', 19, '888', '', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-19', '2014-07-19', 1),
(8, 0, '', 'Undeposited Funds', '7890879877877', 8, '78089', 'test', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-07-22', '0000-00-00', 0),
(30, 0, '', 'Sales', '9967865856757', 15, '67866', 'Sales', 1, '0.00', 'USD', 'Yes', 1, '::1', '2014-08-14', '0000-00-00', 1),
(32, 0, '', 'Purchases', '768768768768', 13, '7976', 'Purchases', 1, '0.00', 'USD', 'Yes', 1, '::1', '2014-08-14', '0000-00-00', 1),
(17, 0, '', 'Service Income', '8430569053438', 15, '9087878', 'Use Service income to track income from services you perform or ordinary usage fees you charge.', 1, '0.00', 'USD', 'Yes', 2, '::1', '2014-08-11', '2014-08-11', 0),
(18, 0, '', 'Processing Fee', '547575474', 15, '9787', 'Processing Fee', 1, '0.00', 'USD', 'Yes', 3, '::1', '2014-08-11', '0000-00-00', 0),
(19, 0, '', 'Other Income', '756755555555', 15, '466', 'Other Income', 1, '0.00', 'USD', 'Yes', 4, '::1', '2014-08-11', '2014-08-11', 1),
(20, 0, '', 'Advertising and Promotion', '76867876876', 13, '999', 'advertising and promotion', 1, '0.00', 'USD', 'Yes', 2, '::1', '2014-08-11', '2014-08-14', 0),
(21, 0, '', 'Agent Commission', '86786788878768', 13, '777', 'Agent Commission', 1, '0.00', 'USD', 'Yes', 3, '::1', '2014-08-11', '0000-00-00', 0),
(22, 0, '', 'Building Maintenance', '658767686787', 13, '56765', 'building maintenance', 1, '0.00', 'USD', 'Yes', 4, '::1', '2014-08-11', '2014-08-14', 0),
(23, 0, '', 'Office Expense', '54654654444444', 13, '8884', 'Office Expense', 1, '0.00', 'USD', 'Yes', 5, '::1', '2014-08-11', '0000-00-00', 0),
(24, 0, '', 'Other Expense', '43543535434', 13, '6456', 'Other Expense', 1, '0.00', 'USD', 'Yes', 6, '::1', '2014-08-11', '0000-00-00', 1),
(26, 0, '', 'Freight and delivery', '575675765765', 17, '7775', 'Use Freight and delivery - COS to track the cost of shipping/delivery of obtaining raw materials and producing finished goods for resale.', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-08-11', '0000-00-00', 0),
(27, 0, '', 'Other costs of sales', '555555577777', 17, '56765', 'Use Other costs of sales - COS to track costs related to services or sales that you provide that do not fall into another Cost of Sales type.', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-08-11', '0000-00-00', 0),
(28, 0, '', 'Salaries and Wages', '46546546456546', 17, '4455', 'Use Salaries and Wages to track the cost of paying employees to produce products or supply services.', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-08-11', '0000-00-00', 0),
(29, 0, '', 'Supplies and materials', '45645645654666', 17, '46663', 'Use Supplies and materials - COS to track the cost of raw goods and parts used or consumed when producing a product or providing a service.', 1, '0.00', 'USD', 'Yes', 0, '::1', '2014-08-11', '0000-00-00', 0),
(34, 24, '', 'freight', '6220', 13, '6220', '', 1, '0.00', 'INR', 'Yes', 0, '66.192.143.66', '2014-08-26', '0000-00-00', 0),
(35, 0, '', 'Building', '77665545', 11, '00098988', '', 1, '0.00', 'INR', 'Yes', 0, '66.192.143.66', '2014-08-28', '0000-00-00', 0);

--
-- Dumping data for table `f_account_type`
--

INSERT INTO `f_account_type` (`AccountTypeID`, `LocationID`, `AccountType`, `Description`, `Status`, `flag`, `CreatedDate`, `OrderBy`, `UpdatedDate`) VALUES
(6, 1, 'OTHER CURRENT LIABILITIES', '', 'Yes', 1, '2014-07-09', 15, '2014-07-10'),
(7, 1, 'LONG TERM LIABILITIES', '', 'Yes', 1, '2014-07-09', 16, '0000-00-00'),
(5, 1, 'EQUITY', '', 'No', 1, '2014-07-09', 17, '0000-00-00'),
(8, 1, 'OTHER CURRENT ASSETS', '', 'Yes', 1, '2014-07-09', 4, '2014-07-22'),
(9, 1, 'OTHER ASSETS', '', 'Yes', 1, '2014-07-09', 12, '0000-00-00'),
(11, 1, 'FIXED ASSETS', '', 'Yes', 1, '2014-07-09', 6, '0000-00-00'),
(12, 1, 'ACCOUNT RECEIVABLES', 'Accounts receivable (Debtors) tracks money that customers owe you for products or services, and payments customers make.', 'Yes', 1, '2014-07-09', 2, '2014-07-21'),
(13, 1, 'EXPENSES', '', 'Yes', 1, '2014-07-09', 10, '0000-00-00'),
(14, 1, 'ACCOUNT PAYABLES', 'Accounts payable (Creditors) tracks amounts you owe to your vendors.', 'Yes', 1, '2014-07-09', 14, '2014-07-21'),
(15, 1, 'INCOME', '', 'Yes', 1, '2014-07-09', 8, '0000-00-00'),
(16, 1, 'BANK ACCOUNT', '', 'Yes', 1, '2014-07-09', 1, '0000-00-00'),
(17, 1, 'COST OF GOODS SOLD', '', 'Yes', 1, '2014-07-09', 9, '0000-00-00'),
(19, 1, 'CREDIT CARD', 'Credit card accounts track the balance due on your business credit cards.', 'Yes', 1, '2014-07-19', 13, '0000-00-00');


INSERT INTO `f_term` (`termID`, `termName`, `termDate`, `Day`, `Due`, `CreditLimit`, `Status`, `UpdatedDate`) VALUES
(1, 'Direct Debit', '', '30', '', '0.00', 1, '2014-02-06'),
(2, 'Cash', '', '52', '22', '2222.00', 1, '2014-02-06'),
(3, 'Electronic Transfer', '', '12', '', '0.00', 1, '2014-02-06'),
(4, 'Transfer', '', '34', '50', '5600.00', 1, '2014-02-07'),
(5, 'Immediate Payment', '', '1', '', '0.00', 1, '2014-03-06');

--
-- Dumping data for table `h_attribute`
--

INSERT INTO `h_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(1, 'JobType', 'Job Type'),
(2, 'SalaryFrequency', 'Salary Frequency'),
(3, 'UnderGraduate', 'Under Graduate'),
(4, 'Graduation', 'Graduation'),
(5, 'PostGraduation', 'Post Graduation'),
(6, 'Doctorate', 'Doctorate'),
(7, 'ProfessionalCourse', 'Professional Course'),
(8, 'ImmigrationType', 'Immigration Type'),
(9, 'LeaveType', 'Leave Type'),
(10, 'LeaveStatus', 'Leave Status'),
(11, 'JobTitle', 'Job Title'),
(12, 'InterviewTest', 'Interview Test'),
(18, 'InterviewStatus', 'Interview Status'),
(19, 'VacancyStatus', 'Vacancy Status'),
(20, 'BloodGroup', 'Blood Group'),
(21, 'HeadType', 'Pay Head Type'),
(22, 'ExitType', 'Exit Type'),
(23, 'Skill', 'Skill'),
(24, 'AssetBrand', 'Brand'),
(25, 'AssetCat', 'Category');

--
-- Dumping data for table `h_attribute_value`
--

INSERT INTO `h_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(3, 'Fixed Term Contract', 1, 0, 1),
(8, 'Monthly', 2, 1, 1),
(9, 'Weekly', 2, 1, 1),
(10, 'Daily', 2, 1, 1),
(11, 'Yearly', 2, 1, 1),
(50, 'Software Engineer', 11, 1, 1),
(51, 'Sr. Software Engineer', 11, 1, 1),
(52, 'UI Developer', 11, 1, 1),
(53, 'Sr. UI Developer', 11, 1, 1),
(54, 'QA', 11, 1, 1),
(55, 'Sr. QA', 11, 1, 1),
(56, 'Project Manager', 11, 1, 1),
(57, 'Team Leader', 11, 1, 1),
(68, 'Passport', 8, 1, 1),
(69, 'Voter ID', 8, 1, 1),
(70, 'Pan Card', 8, 1, 1),
(71, 'Driving License', 8, 1, 1),
(80, 'Pending', 10, 1, 1),
(81, 'Approved', 10, 1, 1),
(82, 'Taken', 10, 1, 1),
(83, 'Rejected', 10, 1, 1),
(84, 'Contract', 1, 0, 1),
(85, 'Contract', 1, 1, 2),
(86, 'Monthly', 2, 1, 2),
(91, 'CL', 9, 1, 2),
(200, 'A +', 20, 1, 0),
(201, 'A -', 20, 1, 0),
(202, 'A', 20, 1, 0),
(203, 'B +', 20, 1, 0),
(204, 'B -', 20, 1, 0),
(205, 'B', 20, 1, 0),
(206, 'AB +', 20, 1, 0),
(207, 'AB -', 20, 1, 0),
(208, 'AB', 20, 1, 0),
(209, 'O +', 20, 1, 0),
(210, 'O -', 20, 1, 0),
(211, 'O', 20, 1, 0),
(212, 'Unknown', 20, 1, 0),
(213, 'Scheduled', 18, 1, 1),
(214, 'Taken', 18, 1, 1),
(215, 'Rejected', 18, 1, 1),
(216, 'Failed', 18, 1, 1),
(217, 'Passed', 18, 1, 1),
(225, 'On Hold', 19, 1, 1),
(226, 'Rejected', 19, 1, 1),
(227, 'Approved', 19, 1, 1),
(228, 'Fixed', 21, 1, 0),
(229, 'Percentage', 21, 1, 0),
(230, 'Other', 21, 1, 0),
(232, 'Casual', 9, 1, 1),
(233, 'Planned', 9, 1, 1),
(234, 'Medical', 9, 1, 1),
(235, 'Unplanned', 9, 1, 1),
(238, 'Sick', 9, 1, 1),
(246, 'Marketing', 11, 1, 2),
(247, 'Hourly', 2, 1, 1),
(251, 'Secondary', 3, 1, 1),
(252, 'Higher Secondary', 3, 1, 1),
(253, 'Not Pursuing Graduation', 4, 1, 1),
(254, 'B.A', 4, 1, 1),
(255, 'B.Arch', 4, 1, 1),
(256, 'BCA', 4, 1, 1),
(257, 'B.B.A', 4, 1, 1),
(258, 'B.Com', 4, 1, 1),
(259, 'B.Ed', 4, 1, 1),
(260, 'BDS', 4, 1, 1),
(261, 'BHM', 4, 1, 1),
(262, 'B.Pharma', 4, 1, 1),
(263, 'B.Sc', 4, 1, 1),
(264, 'B.Tech/B.E', 4, 1, 1),
(265, 'LLB', 4, 1, 1),
(266, 'MBBS', 4, 1, 1),
(267, 'Diploma', 4, 1, 1),
(268, 'BVSC', 4, 1, 1),
(269, 'CA', 5, 1, 1),
(270, 'CS', 5, 1, 1),
(271, 'ICWA', 5, 1, 1),
(272, 'Integrated PG', 5, 1, 1),
(273, 'LLM', 5, 1, 1),
(274, 'M.A', 5, 1, 1),
(275, 'M.Arch', 5, 1, 1),
(276, 'M.Com', 5, 1, 1),
(277, 'M.Ed', 5, 1, 1),
(278, 'M.Pharma', 5, 1, 1),
(279, 'M.Sc', 5, 1, 1),
(280, 'M.Tech', 5, 1, 1),
(281, 'MBA/PGDM', 5, 1, 1),
(282, 'MCA', 5, 1, 1),
(283, 'MS', 5, 1, 1),
(284, 'PG Diploma', 5, 1, 1),
(285, 'MVSC', 5, 1, 1),
(286, 'MCM', 5, 1, 1),
(287, 'Ph.D/Doctorate', 6, 1, 1),
(288, 'MPHIL', 6, 1, 1),
(289, 'Banking', 7, 1, 1),
(290, 'Insurance', 7, 1, 1),
(291, 'Fashion', 7, 1, 1),
(292, 'Tourism', 7, 1, 1),
(293, 'Real Estate', 7, 1, 1),
(294, 'Retail', 7, 1, 1),
(295, 'Oral Test', 12, 1, 1),
(296, 'Written Test', 12, 0, 1),
(297, 'HR Round', 12, 1, 1),
(299, 'Resignation', 22, 1, 1),
(300, 'Termination', 22, 1, 1),
(301, 'Asked to leave', 22, 1, 1),
(302, 'Absconding', 22, 1, 1),
(303, 'Zend', 23, 1, 1),
(304, 'Joomla', 23, 1, 1),
(305, 'Magento', 23, 1, 1),
(306, 'E-commerce', 23, 1, 1),
(307, 'Wordpress', 23, 1, 1),
(310, 'Trainee', 1, 1, 1),
(311, 'Permanent', 1, 1, 1),
(312, 'Probation', 1, 1, 1),
(313, 'IT', 25, 1, 1),
(314, 'Canteen', 25, 1, 1),
(315, 'Nokia', 24, 1, 1);

--
-- Dumping data for table `h_component`
--

INSERT INTO `h_component` (`compID`, `locationID`, `heading`, `detail`, `Status`, `updatedDate`) VALUES
(1, 1, 'Basic Job Responsibility (BJR)', '<div>&bull;These are key and Primary responsibility of the position</div>\r\n<div>&bull;They are divided into five categories which are 1) Quantity 2) Quality&nbsp; 3) Customer Care 4) Planning 5) Process Adherence &amp; Improvement 6) Others / Support / Secondary Roles &amp; Responsibilities</div>\r\n<div>&bull;Measurement criteria and targets assigned against each</div>\r\n<div>&bull;They are reviewed annually</div>', 1, '2014-04-09'),
(2, 1, 'Performance Excellence (PE)', '<div>&bull; It is an approach to  doing things in a simple quick and accurate manner.</div>\r\n<div>&bull; It involves  following steps &ndash; Plan, Do, Check and Act.</div>\r\n<div>&bull; Performance Excellence Projects are assigned to cross  functional teams</div>\r\n<div>&bull; It is reviewed annually and ratings are assigned</div>', 1, '2013-10-03'),
(3, 1, 'Competencies', '<div>&bull;  These are a set of factors,  that include key behaviors. There are 20 competencies.</div>\r\n<div>&bull; They are divided into 4 categories  1) Strategic Leadership 2) Organizational&nbsp; Leadership 3) Managing Self &amp;  Others 4) Knowledge Base.</div>\r\n<div>&bull; They are reviewed annually</div>', 1, '2013-10-03');

--
-- Dumping data for table `h_component_cat`
--

INSERT INTO `h_component_cat` (`catID`, `catName`, `catGrade`, `Status`, `Weightage1`, `Weightage2`, `Weightage3`, `updatedDate`) VALUES
(1, 'Top Management', 'UC', 1, 25, 75, 0, '2013-12-26'),
(2, 'Senior Management', 'G', 1, 20, 20, 60, '2013-10-03'),
(3, 'Middle Management', 'M/G', 1, 99, 1, 0, '2013-11-29'),
(4, 'Executives', 'E1-E3', 1, 40, 0, 20, '2013-11-28');

--
-- Dumping data for table `h_dec_cat`
--

INSERT INTO `h_dec_cat` (`catID`, `catName`, `catGrade`, `Status`, `updatedDate`) VALUES
(1, 'Rent Receipts', 'A', 1, '0000-00-00'),
(2, 'Loss / Income', 'B', 1, '0000-00-00'),
(3, 'Deduction', 'C', 1, '0000-00-00'),
(4, 'Investments', 'D', 1, '0000-00-00');

--
-- Dumping data for table `h_department`
--

INSERT INTO `h_department` (`depID`, `Division`, `Department`, `Status`) VALUES
(1, 1, 'HR', 1),
(2, 1, 'Reception', 1),
(3, 1, 'Account', 1),
(4, 2, 'Sale', 1),
(5, 3, 'Production', 1),
(6, 3, 'Manufacturing', 1),
(7, 3, 'Receiving', 1),
(8, 4, 'Purchase', 1),
(10, 4, 'Invoice', 1),
(13, 6, 'Stock Keeper', 1),
(14, 7, 'Sales D', 1),
(15, 5, 'Marketting', 1),
(16, 4, 'Receiving PO', 1),
(17, 7, 'Sales Person', 1);

--
-- Dumping data for table `h_pay_cat`
--

INSERT INTO `h_pay_cat` (`catID`, `catName`, `catGrade`, `Status`, `updatedDate`) VALUES
(1, 'FIXED - A', 'A', 1, '0000-00-00'),
(2, 'Flexi Benefit Plan - B', 'B', 1, '0000-00-00'),
(3, 'Retirals - C', 'C', 1, '0000-00-00'),
(4, 'Deductions - D', 'D', 0, '0000-00-00');

--
-- Dumping data for table `h_pay_head`
--

INSERT INTO `h_pay_head` (`headID`, `locationID`, `catID`, `catEmp`, `HeadType`, `heading`, `subheading`, `Percentage`, `Amount`, `Default`, `Status`, `updatedDate`) VALUES
(1, 1, 1, 0, 'Percentage', 'Basic Salary', '', 40, '', 1, 1, '2014-06-21'),
(2, 1, 1, 0, 'Percentage', 'HRA', '', 40, '', 0, 1, '2014-06-20'),
(4, 2, 1, 0, 'Percentage', 'Basic Salary', '', 40, '', 1, 1, '2014-01-30'),
(5, 1, 1, 0, 'Percentage', 'Conveyance', '', 10, '', 0, 1, '2014-03-29'),
(7, 1, 2, 0, 'Other', 'Medical', 'Max 15000', 50, '0', 0, 1, '2014-06-20'),
(9, 1, 2, 0, 'Other', 'LTA', 'Flexi - Any Reasonable Amt', 20, '', 0, 1, '2014-03-28'),
(10, 1, 2, 0, 'Other', 'Special Allowance', 'Any Unallocated Amt', 50, '', 0, 1, '2014-03-29'),
(11, 1, 3, 0, 'Percentage', 'PF', '', 12, '', 0, 1, '2014-03-28'),
(12, 1, 3, 0, 'Percentage', 'Gratuity', '', 15, '', 0, 1, '2014-03-28'),
(13, 1, 4, 0, 'Other', 'TDS', '', 20, '', 0, 1, '2014-03-28'),
(17, 1, 3, 0, 'Percentage', 'ESI', '', 10, '', 0, 1, '2014-03-29'),
(19, 1, 1, 1, 'Percentage', 'Basic Salary', '', 40, '', 1, 1, '2014-06-21'),
(20, 1, 1, 2, 'Percentage', 'Basic Salary', '', 40, '', 1, 1, '2014-06-21'),
(21, 1, 1, 3, 'Percentage', 'Basic Salary', '', 50, '', 1, 1, '2014-06-21'),
(22, 1, 1, 4, 'Percentage', 'Basic Salary', '', 50, '', 1, 1, '2014-06-21'),
(23, 1, 1, 1, 'Percentage', 'HRA', '', 40, '', 0, 1, '2014-06-21'),
(24, 1, 1, 1, 'Percentage', 'Conveyance', '', 20, '', 0, 1, '2014-06-21'),
(25, 1, 2, 1, 'Other', 'Medical', 'Max 15000', 0, '', 0, 1, '2014-06-21'),
(26, 1, 2, 1, 'Other', 'LTA', 'Flexi - Any Reasonable Amt', 0, '', 0, 1, '2014-06-21'),
(27, 1, 2, 1, 'Other', 'Special Allowance', 'Any Unallocated Amt', 0, '', 0, 1, '2014-06-21'),
(28, 1, 3, 1, 'Percentage', 'PF', '', 20, '', 0, 1, '2014-06-21'),
(29, 1, 3, 1, 'Percentage', 'Gratuity', '', 15, '', 0, 1, '2014-06-21'),
(30, 1, 3, 1, 'Percentage', 'ESI', '', 10, '', 0, 1, '2014-06-21'),
(31, 1, 4, 1, 'Other', 'TDS', '', 0, '', 0, 1, '2014-06-21'),
(32, 1, 1, 2, 'Percentage', 'HRA', '', 40, '', 0, 1, '2014-06-21'),
(33, 1, 2, 2, 'Other', 'Medical', 'Max 15000', 0, '0', 0, 1, '2014-06-21'),
(34, 1, 2, 2, 'Other', 'LTA', 'Flexi - Any Reasonable Amt', 0, '0', 0, 1, '2014-06-21'),
(35, 1, 3, 2, 'Percentage', 'PF', '', 15, '', 0, 1, '2014-06-21'),
(36, 1, 4, 2, 'Other', 'TDS', '', 0, '', 0, 1, '2014-06-21'),
(37, 1, 1, 3, 'Percentage', 'HRA', '', 40, '', 0, 1, '2014-06-21'),
(38, 1, 2, 3, 'Other', 'Medical', 'Max 15000', 0, '0', 0, 1, '2014-06-21'),
(40, 1, 4, 3, 'Other', 'TDS', '', 0, '', 0, 1, '2014-06-21'),
(41, 1, 1, 4, 'Percentage', 'Conveyance', '', 10, '', 0, 1, '2014-06-21'),
(42, 1, 2, 4, 'Other', 'Special Allowence', 'Any Unallocated Amt', 0, '0', 0, 1, '2014-06-21'),
(43, 1, 1, 2, 'Percentage', 'Conveyance', '', 20, '', 0, 1, '2014-06-21'),
(44, 1, 2, 2, 'Other', 'Special Allowance', 'Any Unallocated Amt', 0, '', 0, 1, '2014-06-21'),
(45, 1, 3, 2, 'Percentage', 'Gratuity', '', 10, '', 0, 1, '2014-06-21'),
(46, 1, 3, 2, 'Percentage', 'ESI', '', 5, '', 0, 1, '2014-06-21'),
(47, 1, 1, 3, 'Percentage', 'Conveyance', '', 15, '', 0, 1, '2014-06-21'),
(48, 1, 2, 3, 'Other', 'Special Allowance', 'Any Unallocated Amt', 0, '0', 0, 1, '2014-06-21'),
(49, 1, 3, 3, 'Percentage', 'PF', '', 15, '', 0, 1, '2014-06-21'),
(50, 1, 3, 3, 'Percentage', 'Gratuity', '', 10, '', 0, 1, '2014-06-21'),
(51, 1, 3, 4, 'Percentage', 'PF', '', 10, '', 0, 1, '2014-06-21');

--
-- Dumping data for table `inv_attribute`
--


INSERT INTO `inv_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(1, 'ItemType', 'Item Type'),
(2, 'Procurement', 'Procurement'),
(3, 'EvaluationType', 'Valuation Type'),
(4, 'Model', 'Model'),
(5, 'Generation', 'Generation'),
(6, 'Condition', 'Condition'),
(7, 'Extended', 'Extended'),
(8, 'Manufacture', 'Manufacture'),
(9, 'Reorder', 'Reorder Method'),
(11, 'Unit', 'Unit'),
(13, 'AdjReason', 'Adjustment Reason');

--
-- Dumping data for table `inv_attribute_value`
--

INSERT INTO `inv_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `editable`, `Status`, `locationID`) VALUES
(6, 'LBS', 11, 1, 0, 1),
(7, 'Non Kit', 1, 0, 1, 1),
(8, 'Kit', 1, 0, 1, 1),
(10, 'SALE', 2, 0, 1, 1),
(11, 'MAKE', 2, 0, 1, 1),
(12, 'FIFO', 3, 0, 1, 1),
(13, 'LIFO', 3, 0, 1, 1),
(14, 'Serialized', 3, 0, 1, 1),
(15, 'EA', 11, 1, 1, 1),
(17, 'Customer Return', 13, 1, 1, 1),
(20, 'Box', 11, 1, 1, 1),
(21, 'Damaged', 13, 1, 1, 1),
(22, 'Outdated', 13, 1, 1, 1),
(23, 'Missing', 13, 1, 1, 1),
(24, 'PURCHASE', 2, 0, 1, 1),
(28, 'Lost', 13, 1, 1, 2);

--
-- Dumping data for table `inv_prefix`
--

INSERT INTO `inv_prefix` (`prefixID`, `adjustmentPrefix`, `adjustPrefixNum`, `ToP`, `ToN`, `bom_prefix`, `bom_number`, `updateDate`, `created_by`, `created_id`, `Status`) VALUES
(1, 'SA', '2', 'TX', '3', 'BOM', '2', '2014-04-04', 'admin', 31, 1);

--
-- Dumping data for table `inv_tax_classes`
--

INSERT INTO `inv_tax_classes` (`ClassId`, `ClassName`, `ClassDescription`, `Status`) VALUES
(1, 'Sales', 'Sales', 1),
(2, 'Purchase', 'Purchase Order', 1);


--
-- Dumping data for table `p_attribute`
--

INSERT INTO `p_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(1, 'PaymentMethod', 'Payment Method'),
(2, 'ShippingMethod', 'Shipping Method'),
(3, 'OrderStatus', 'Order Status'),
(4, 'OrderType', 'Order Type'),
(5, 'OrdStatus', 'Ord Status');

--
-- Dumping data for table `p_attribute_value`
--

INSERT INTO `p_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(1, 'Check', 1, 1, 1),
(2, 'Cash', 1, 1, 1),
(3, 'Direct Debit', 1, 1, 1),
(4, 'Credit Card', 1, 1, 1),
(5, 'DHL', 2, 1, 1),
(6, 'UPS', 2, 1, 1),
(7, 'USPS', 2, 1, 1),
(8, 'Draft', 3, 1, 1),
(9, 'Printed', 3, 1, 1),
(10, 'Email Sent', 3, 1, 1),
(11, 'Ready to Receive', 3, 1, 1),
(12, 'Invoicing', 3, 1, 1),
(13, 'Received', 3, 1, 1),
(14, 'Standard', 4, 1, 1),
(15, 'Dropship', 4, 1, 1),
(16, 'Online Bank Transfer', 1, 1, 1),
(20, 'Open', 5, 1, 1),
(21, 'Closed', 5, 1, 1),
(22, 'Cancelled', 5, 1, 1),
(23, 'FedEx', 2, 1, 1);

--
-- Dumping data for table `p_term`
--

INSERT INTO `p_term` (`termID`, `termName`, `termDate`, `Day`, `Due`, `CreditLimit`, `Status`, `UpdatedDate`) VALUES
(4, 'Direct Debit', '', '30', '', '0.00', 1, '2014-02-06'),
(3, 'Cash', '', '52', '22', '2222.00', 1, '2014-02-06'),
(5, 'Electronic Transfer', '', '12', '', '0.00', 1, '2014-02-06'),
(6, 'Transfer', '', '34', '50', '5600.00', 0, '2014-02-07'),
(8, '20th Month Following', '', '20', '20', '50000.00', 1, '2014-04-03');

--
-- Dumping data for table `s_attribute`
--

INSERT INTO `s_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(1, 'PaymentMethod', 'Payment Method'),
(2, 'ShippingMethod', 'Shipping Method'),
(3, 'OrderStatus', 'Order Status'),
(4, 'OrderType', 'Order Type');

--
-- Dumping data for table `s_attribute_value`
--

INSERT INTO `s_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(1, 'Check', 1, 1, 1),
(2, 'Cash', 1, 1, 1),
(3, 'Direct Debit', 1, 1, 1),
(4, 'Credit Card', 1, 1, 1),
(5, 'DHL', 2, 1, 1),
(6, 'UPS', 2, 1, 1),
(7, 'USPS', 2, 1, 1),
(8, 'Open', 3, 1, 1),
(10, 'Cancelled', 3, 1, 1),
(11, 'Standard', 4, 1, 1),
(12, 'Dropship', 4, 1, 1),
(13, 'Electronic Transfer', 1, 1, 1),
(14, 'ASOS', 2, 1, 1),
(17, 'Online Bank Transfer', 1, 1, 1);

--
-- Dumping data for table `s_term`
--

INSERT INTO `s_term` (`termID`, `termName`, `termDate`, `Day`, `Due`, `CreditLimit`, `Status`, `UpdatedDate`) VALUES
(4, 'Direct Debit', '', '30', '', '0.00', 1, '2014-02-06'),
(3, 'Cash', '', '52', '22', '2222.00', 1, '2014-02-06'),
(5, 'Electronic Transfer', '', '12', '', '0.00', 1, '2014-02-06'),
(6, 'Transfer', '', '34', '50', '5600.00', 1, '2014-02-07'),
(10, 'Immediate Payment', '', '1', '', '0.00', 1, '2014-03-06');

--
-- Dumping data for table `w_attribute`
--

INSERT INTO `w_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(1, 'Transport', 'Transport'),
(2, 'PackageType', 'Package Type'),
(3, 'Charge', 'Charge'),
(4, 'Paid ', 'Paid '),
(5, 'OrdStatus', 'Ord Status'),
(6, 'ShippingMethod', 'Shipping Method');

--
-- Dumping data for table `w_attribute_value`
--

INSERT INTO `w_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(1, 'Postpaid', 4, 1, 1),
(2, 'Prepaid', 4, 1, 1),
(3, 'Truck', 1, 1, 1),
(4, 'Car', 1, 1, 1),
(5, 'Pallet', 2, 1, 1),
(6, 'Case', 2, 1, 1),
(7, '100', 3, 1, 1),
(8, '200', 3, 1, 1),
(9, 'Train', 1, 1, 1),
(10, 'Cartton', 2, 1, 1),
(11, 'DHL', 6, 1, 1),
(12, 'UPS', 6, 1, 1),
(13, 'USPS', 6, 1, 1),
(14, 'ASOS', 6, 1, 1),
(15, 'Fedex', 6, 1, 1);

INSERT INTO `w_status_attribute` (`id`, `Status`, `Status_Name`) VALUES
(1, 0, 'parked'),
(2, 1, 'cancelled'),
(5, 2, 'completed');


INSERT INTO `emails` (`templateID`, `depID`, `Type`, `Title`, `Note`, `Important`, `Subject`, `Content`, `UpdatedDate`, `OrderBy`, `Status`) VALUES
(1, 1, 'BIRTHDAY', 'Birthday Anniversary', 'This template will be used to send email for Birthday Anniversaries.', '[NAME]', 'Wishing you a Very Happy Birthday11', '<div style="text-align: center;"><span style="color: rgb(255, 102, 0);"><span style="font-size: x-large;"><span style="color: rgb(255, 0, 255);">Dear [NAME],<br />\r\n<br />\r\nWishing you a very Happy Birthday !!!<br />\r\n<br />\r\n<img src="http://www.designsnext.com/wp-content/uploads/2014/04/happy-birthday-best-chocolate-cakes-for-wishes.jpg" alt="" /> &nbsp;<br />\r\n<br />\r\nWith lots of wishes<br />\r\nTEAM SAKSHAY</span></span><br />\r\n</span></div>', '2014-06-30 08:53:10', 0, 1),
(2, 1, 'JOINING', 'Joining Anniversary', 'This template will be used to send email for Joining Anniversaries.', '[NAME]', 'Wishing you a Happy Joining Anniversary', '<span style="font-size: xx-large;"><span style="color: rgb(128, 0, 0);">Dear [NAME],<br />\r\n<br />\r\nWishing you a very happy and warm joining anniversary!!!<br />\r\n<br />\r\n<img alt="" src="http://www.pictures88.com/p/anniversary/anniversary_069.jpg" /> <br />\r\n<br />\r\nWith Best Wishes<br />\r\nTeam Sakshay</span></span><br />', '2014-06-27 17:10:13', 0, 1),
(3, 1, 'MARRIAGE', 'Marriage Anniversary', 'This template will be used to send email for Marriage Anniversaries.', '[NAME]', 'Wishing you a Happy Marriage Anniversary', '<span style="color: rgb(255, 0, 0);"><span style="font-size: xx-large;">Dear [NAME],  Wishing you a very Happy Marriage Anniversary !!!  </span></span><span style="font-size: xx-large;"><span style="color: rgb(51, 153, 102);"><br />\r\n<br />\r\n</span></span><img src="http://www.indusladies.com/forums/attachments/anniversary/109101d1297932231-happy-1st-wedding-anniversary-raga-103033.gif" alt="http://www.indusladies.com/forums/attachments/anniversary/109101d1297932231-happy-1st-wedding-anniversary-raga-103033.gif" class="decoded" /><br />\r\n<br />\r\n<br />\r\n<span style="font-size: xx-large;"><span style="color: rgb(255, 0, 0);">With lots of wishes  TEAM SAKSHAY</span></span>', '0000-00-00 00:00:00', 0, 0);


