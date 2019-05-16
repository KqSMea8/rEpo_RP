
CREATE TABLE IF NOT EXISTS `admin_modules` (
  `ModuleID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Parent` int(10) NOT NULL DEFAULT '0',
  `Default` tinyint(4) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  `Restricted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ModuleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `admin_right_modules` (
  `ModuleID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Parent` int(10) NOT NULL DEFAULT '0',
  `Default` tinyint(4) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  `EditView` tinyint(1) NOT NULL,
  PRIMARY KEY (`ModuleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


INSERT INTO `admin_right_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`, `EditView`) VALUES
(1, 'General Information', 'general', 0, 860, 0, 1, 0, 0),
(2, 'Contacts', 'contacts', 0, 860, 0, 1, 0, 0),
(3, 'Bank Details', 'bank', 0, 860, 0, 1, 0, 0),
(4, 'Credit Cards', 'card', 0, 860, 0, 1, 0, 0),
(5, 'Billing Address', 'billing', 0, 860, 0, 1, 0, 0),
(6, 'Shipping Address', 'shipping', 0, 860, 0, 1, 0, 0),
(7, 'Sales Person', 'slaesPerson', 0, 860, 0, 1, 0, 1),
(8, 'Markup/Discount', 'markup', 0, 860, 0, 1, 0, 1),
(9, 'Login/Permission Detail', 'LoginPermission', 0, 860, 0, 1, 0, 1),
(10, 'Merge Customer', 'merge', 0, 860, 0, 1, 0, 1),
(11, 'Sales Orders', 'so', 8, 860, 0, 1, 0, 0),
(12, 'Invoices', 'invoice', 8, 860, 0, 1, 0, 0),
(13, 'Link Vendor', 'linkvendor', 8, 860, 0, 1, 0, 0),
(14, 'Social Information', 'social', 0, 860, 0, 1, 0, 2),
(15, 'Purchase History', 'purchase', 0, 860, 0, 1, 0, 2),
(16, 'Deposits', 'deposit', 8, 860, 0, 1, 0, 0),
(17, 'Shipping Accounts', 'ShippingAccount', 8, 860, 0, 1, 0, 0),
(18, 'Sales History', 'sales', 8, 860, 0, 1, 0, 0);

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `blocks` (
  `BlockID` int(10) NOT NULL AUTO_INCREMENT,
  `Block` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `BlockHeading` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `OrderBy` int(5) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`BlockID`),
  KEY `depID` (`depID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `blocks` (`BlockID`, `Block`, `BlockHeading`, `depID`, `OrderBy`, `Status`) VALUES
(1, 'home_lead_b.php', 'New Lead', 5, 1, 1),
(2, 'home_call_quota_b.php', 'Phone', 5, 2, 1),
(3, 'home_ticket_open_b.php', 'Open and In progress Ticket', 5, 2, 1),
(4, 'commission_dashboard_b.php', 'Sales Commission', 5, 3, 1),
(5, 'home_task_chart_b.php', '# of Task and Activities', 5, 3, 1),
(6, 'home_opp_b.php', 'Opportunities', 5, 4, 1),
(7, 'home_task_b.php', 'Task and Activities', 5, 8, 1),
(8, 'home_comm_report_b.php', 'Sales Commission Report', 5, 6, 1),
(9, 'home_ticket_priority_b.php', '# of Ticket by Priority', 5, 6, 1),
(10, 'home_created_quote_b.php', 'Quotes', 5, 5, 1),
(11, 'home_campaign_b.php', 'Active Campaign', 5, 7, 1),
(12, 'home_quote_b.php', '# of Quotes', 5, 9, 1),
(13, 'home_sales_comm_chart_admin_b.php', 'Sales Commission Report', 5, 10, 1),
(14, 'home_call_quota_admin_b.php', 'Calls Dashboard', 5, 11, 1),
(15, 'home_clock_b.php', 'Clock', 5, 2, 1),
(16, 'home_calendar_b.php', 'Calendar', 5, 4, 1),
(17, 'home_email_b.php', 'Emails', 5, 5, 1),
(18, 'home_Total_sale_b.php', 'Total Sales', 8, 2, 1),
(19, 'home_saleorder_b.php', 'Sales Order', 8, 3, 1),
(20, 'home_SO_Report_b.php', 'SO Report', 8, 3, 1),
(21, 'home_araging_b.php', 'Ar Aging', 8, 3, 1),
(22, 'home_apaging_b.php', 'Ap Aging', 8, 3, 1),
(24, 'home_openpo_b.php', 'Open PO', 8, 3, 1),
(25, 'home_VendorRma_b.php', 'Open Rma', 8, 3, 1);

CREATE TABLE IF NOT EXISTS `blocks_view` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `BlockID` int(10) NOT NULL,
  `OrderBy` int(5) NOT NULL DEFAULT '0',
  `UpdatedDate` datetime NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Width` varchar(4) NOT NULL,
  `Height` varchar(4) NOT NULL,
  `Top` varchar(10) NOT NULL,
  `Left` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `AdminID` (`AdminID`,`AdminType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `default_screen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ScreenID` int(10) NOT NULL,
  `OrderBy` int(5) NOT NULL DEFAULT '0',
  `UpdatedDate` datetime NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `AdminID` (`AdminID`,`AdminType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `RowColor` varchar(10) NOT NULL,
  `ReferenceID` int(11) NOT NULL,
  PRIMARY KEY (`activityID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `c_column` (
 `cvid` int(19) NOT NULL,
 `colindex` int(11) NOT NULL,
 `colname` varchar(250) NOT NULL,
 `colvalue` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `c_customreport` (
  `report_ID` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(55) NOT NULL,
  `report_desc` text NOT NULL,
  `moduleID` int(11) NOT NULL,
  `columns` varchar(100) NOT NULL,
  `groupby` varchar(100) NOT NULL,
  `sortby` varchar(55) NOT NULL,
  `filters` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `AdminModuleID` int(11) NOT NULL,
  PRIMARY KEY (`report_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `MassEmailCampaigntype` varchar(250) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
 `type` varchar(20) NOT NULL,
 `subject` varchar(100) NOT NULL,
 `callPurpuse` varchar(30) NOT NULL,
 `calltype` varchar(30) NOT NULL,
 `callduration` varchar(50) NOT NULL,
  PRIMARY KEY (`CommentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `c_all_comments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(12) NOT NULL,
  `commented_by` varchar(12) NOT NULL,
  `commented_id` int(15) NOT NULL,
  `parent_type` varchar(12) NOT NULL,
  `module_type` varchar(10) NOT NULL,
  `parentID` int(12) NOT NULL,
  `Comment` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CommentDate` datetime NOT NULL,
  `timestamp` int(20) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`CommentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1; 


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
  `massmail_type` varchar(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_document`
--


CREATE TABLE IF NOT EXISTS `c_document` (
  `documentID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(70) NOT NULL,
  `module` varchar(50) NOT NULL,
  `linkId` int(15) NOT NULL,
  `AssignTo` varchar(100) NOT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` varchar(50) NOT NULL,
  `FileName` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FilePath` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DownloadType` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FileExist` tinyint(1) NOT NULL DEFAULT '0',
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `AddedDate` datetime NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `AddedBy` int(10) NOT NULL,
  `parent_type` varchar(50) NOT NULL,
  `parentID` int(15) NOT NULL,
 `CustID` int(11) NOT NULL,
 `FolderID` int(11) NOT NULL,
  PRIMARY KEY (`documentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `c_document_folder` (
  `FolderID` int(11) NOT NULL AUTO_INCREMENT,
  `FolderName` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`FolderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `c_folder` (
`FolderId` int(11) NOT NULL AUTO_INCREMENT,
`FolderName` varchar(100) NOT NULL,
`AdminID` int(11) NOT NULL,
`AdminType` varchar(20) NOT NULL,
`Status` int(1) NOT NULL,
`CompID` int(11) NOT NULL,
`moduleID` int(5) NOT NULL,
`IsPublic` tinyint(1) NOT NULL,
PRIMARY KEY (`FolderId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `c_chatpermission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission` text,
  `type` enum('chat','zoom') DEFAULT 'chat',
  `user_type` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `c_chatuserroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `rolename` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

--
-- Table structure for table `c_lead`
--

CREATE TABLE IF NOT EXISTS `c_lead` (
  `leadID` int(20) NOT NULL AUTO_INCREMENT,
  `ProductID` varchar(50) NOT NULL,
  `product_price` float(10,2) NOT NULL,
  `type` varchar(50) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `LeadName` varchar(80) NOT NULL,
  `primary_email` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `company` varchar(50) NOT NULL,
  `Website` varchar(100) NOT NULL,
  `Address` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `CountryName` varchar(50) NOT NULL,
  `StateName` varchar(50) NOT NULL,
  `CityName` varchar(50) NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `PersonalEmail` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignTo` text NOT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `Industry` varchar(50) NOT NULL,
  `AnnualRevenue` varchar(50) NOT NULL,
  `NumEmployee` int(10) NOT NULL,
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
  `Currency` varchar(6) NOT NULL,
  `Rating` varchar(3) NOT NULL,
  `Junk` tinyint(1) NOT NULL,
  `IsLeadForm` tinyint(2) NOT NULL,
  `RowColor` varchar(10) NOT NULL,
  `FlagType` varchar(5) NOT NULL,
  `FolderID` int(11) NOT NULL,
  PRIMARY KEY (`leadID`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `c_lead_form` (
  `formID` int(11) NOT NULL AUTO_INCREMENT,
  `HtmlForm` text NOT NULL,
  `LeadColumn` text NOT NULL,
  `FormTitle` varchar(50) NOT NULL,
  `Subtitle` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `AssignTo` varchar(100) NOT NULL,
  `ExtraInfo` varchar(50) NOT NULL,
  `Campaign` varchar(50) NOT NULL,
  `ActionUrl` varchar(200) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `RoleGroup` varchar(50) NOT NULL,
  `RoleGroupNew` varchar(255) NOT NULL,
  `FormType` varchar(50) NOT NULL,
  PRIMARY KEY (`formID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `c_lead_import` (
  `leadID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(3) NOT NULL,
  `LastName` varchar(3) NOT NULL,
  `company` varchar(3) NOT NULL,
  `primary_email` varchar(3) NOT NULL,
  `LandlineNumber` varchar(3) NOT NULL,
  `designation` varchar(3) NOT NULL,
  `ProductID` varchar(3) NOT NULL,
  `product_price` varchar(3) NOT NULL,
  `Website` varchar(3) NOT NULL,
  `Address` varchar(3) NOT NULL,
  `ZipCode` varchar(3) NOT NULL,
  `OtherCity` varchar(3) NOT NULL,
  `OtherState` varchar(3) NOT NULL,
  `Country` varchar(3) NOT NULL,
  `Mobile` varchar(3) NOT NULL,
  `Industry` varchar(3) NOT NULL,
  `AnnualRevenue` varchar(3) NOT NULL,
  `NumEmployee` varchar(3) NOT NULL,
  `lead_source` varchar(3) NOT NULL,
  `lead_status` varchar(3) NOT NULL,
  `description` varchar(3) NOT NULL,
  `AdminType` varchar(30) NOT NULL,
  `AdminID` int(4) NOT NULL,
  PRIMARY KEY (`leadID`),
  KEY `AdminID` (`AdminID`,`AdminType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `c_opportunity`
--

CREATE TABLE IF NOT EXISTS `c_opportunity` (
  `OpportunityID` int(20) NOT NULL AUTO_INCREMENT,
  `LeadID` int(15) NOT NULL,
  `OpportunityName` varchar(100) NOT NULL,
  `Amount` varchar(50) NOT NULL,
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
  `forecast_amount` varchar(50) NOT NULL,
  `oppsite` varchar(100) NOT NULL,
  `AddedDate` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Currency` varchar(6) NOT NULL,
  `RowColor` varchar(10) NOT NULL,
  `FlagType` varchar(5) NOT NULL,
  `convertToCus` varchar(2) NOT NULL,
  `Address` varchar(250) DEFAULT NULL,
  `city_id` int(12) DEFAULT NULL,
  `state_id` int(12) DEFAULT NULL,
  `OtherState` varchar(40) DEFAULT NULL,
  `OtherCity` varchar(40) DEFAULT NULL,
  `CountryName` varchar(50) DEFAULT NULL,
  `StateName` varchar(50) DEFAULT NULL,
  `CityName` varchar(50) DEFAULT NULL,
  `ZipCode` varchar(15) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `Mobile` varchar(25) DEFAULT NULL,
  `LandlineNumber` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`OpportunityID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `CustomerCurrency` varchar(5) NOT NULL,
  `CustDisType` varchar(20) NOT NULL,
  `CustDisAmt` int(10) NOT NULL,
  `MDType` varchar(20) NOT NULL,
  `MDAmount` varchar(30) NOT NULL,
  `PaymentTerm` varchar(40) NOT NULL,
  `PaymentMethod` varchar(40) NOT NULL,
  `MDiscount` varchar(10) NOT NULL,
  `RowColor` varchar(10) NOT NULL,
  `PdfFile` varchar(200) NOT NULL,
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
  `DesComment` varchar(250) NOT NULL,
  `CustDiscount` varchar(50) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `quoteid` (`quoteid`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_ticket`
--

CREATE TABLE IF NOT EXISTS `c_ticket` (
  `TicketID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(15) NOT NULL,
  `title` varchar(200) NOT NULL,
  `AssignedTo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignType` varchar(30) NOT NULL,
  `GroupID` int(10) NOT NULL,
  `category` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `day` varchar(15) NOT NULL,
  `hours` varchar(15) NOT NULL,
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
  `contact_id` int(11) NOT NULL,
  `RelatedType` varchar(30) NOT NULL,
  `RelatedTo` varchar(30) NOT NULL,
  `RowColor` varchar(10) NOT NULL,
  `sendnotification` varchar(4) NOT NULL,
  `notifications` varchar(40) NOT NULL,
  `FlagType` varchar(5) NOT NULL,
  `IsTicketForm` tinyint(1) NOT NULL DEFAULT '0',
  `Email` varchar(100) NOT NULL,
  `Cmp` text NOT NULL,
  PRIMARY KEY (`TicketID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `c_territory_assign` (
  `AssignID` int(20) NOT NULL AUTO_INCREMENT,
  `TerritoryID` text NOT NULL,
  `AssignType` varchar(15) NOT NULL,
  `AssignTo` int(20) NOT NULL,
  `ManagerID` int(20) NOT NULL,
  `AddedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`AssignID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `c_territory_rule` (
 `TRID` int(11) NOT NULL AUTO_INCREMENT,
 `TerritoryID` int(11) unsigned NOT NULL,
 `SalesPersonID` int(11) unsigned NOT NULL,
 `SalesPerson` varchar(100) NOT NULL,
 `CreatedDate` date NOT NULL,
 `IPAddress` varchar(100) NOT NULL,
 PRIMARY KEY (`TRID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `c_territory_rule_location` (
 `TRLID` int(11) NOT NULL AUTO_INCREMENT,
 `TRID` int(11) NOT NULL,
 `country` int(11) NOT NULL,
 `state` text NOT NULL,
 `city` text NOT NULL,
 PRIMARY KEY (`TRLID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `c_socialuserconnect` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `social_type` enum('twitter','facebook','linkedin','') NOT NULL ,
  `social_id` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `location` text,
  `image` text,
  `user_token` text,
  `user_token_secret` text,
  `user_data` longtext,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY ( id )
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `c_socialpost` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `social_type` enum('twitter','facebook','linkedin','') NOT NULL,
  `post_id` varchar(250) DEFAULT NULL,
  `post` text,
  `media` text,
  `description` text,
  `caption` text,
  `link` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY ( id )
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `c_socialuserlead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `social_type` enum('twitter','facebook','linkedin','') NOT NULL,
  `social_id` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `location` text,
  `image` text,
  `user_data` longtext,
  `status` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `c_customsearch` (
  `search_ID` int(11) NOT NULL AUTO_INCREMENT,
  `search_name` varchar(55) NOT NULL,
  `moduleID` int(11) NOT NULL,
  `AdminModuleID` int(11) NOT NULL,
  `columns` varchar(255) NOT NULL,
  `displayCol` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `checkboxes` varchar(55) NOT NULL,
  `saleduration` varchar(55) NOT NULL,
  `purduration` varchar(55) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `showsopopop` varchar(55) NOT NULL,
  `userids` varchar(255) NOT NULL,
  `recordInsertedBy` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
    PRIMARY KEY (`search_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `c_field` (
  `headid` int(19) NOT NULL,
  `fieldid` int(19) NOT NULL  AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `fieldname` varchar(50) NOT NULL,
  `fieldlabel` varchar(50) NOT NULL,
  `readonly` int(1) NOT NULL,
  `defaultvalue` text,
  `maximumlength` int(19) DEFAULT NULL,
  `sequence` int(19) DEFAULT NULL,
  `block` int(19) DEFAULT NULL,
  `displaytype` int(19) DEFAULT NULL,
  `mandatory` tinyint(1) DEFAULT '0',
  `info_type` varchar(20) DEFAULT NULL,
  `dropvalue` varchar(255) NOT NULL,
  `editable` int(10) NOT NULL DEFAULT '1',
  `RadioValue` text,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `view_field_type` varchar(100) NOT NULL,
   PRIMARY KEY (`fieldid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 


INSERT INTO `c_field` (`headid`,  `type`, `fieldname`, `fieldlabel`, `readonly`, `defaultvalue`, `maximumlength`, `sequence`, `block`, `displaytype`, `mandatory`, `info_type`, `dropvalue`, `editable`, `RadioValue`, `Status`) VALUES
(1,  'select', 'type', 'Lead Type', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'Individual,Company', 0, '', 1),
(1,  'text', 'company', 'Company Name', 0, NULL, 100, NULL, NULL, NULL, 1, NULL, '0', 0, '', 1),
(1,  'text', 'FirstName', 'First Name', 0, NULL, 100, NULL, NULL, NULL, 1, NULL, '0', 0, '', 1),
(1,  'text', 'LastName', 'Last Name', 0, NULL, 100, NULL, NULL, NULL, 1, NULL, '', 0, '', 1),
(1,  'text', 'primary_email', 'Primary Email', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'text', 'designation', 'Title', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'text', 'ProductID', 'Product', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'text', 'product_price', 'Product Price', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'text', 'Website', 'Website', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'select', 'Industry', 'Industry', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'text', 'AnnualRevenue', 'Annual Revenue', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'text', 'NumEmployee', 'Number of Employees', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'select', 'lead_source', 'Lead Source', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'select', 'lead_status', 'Lead Status', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(1,  'date', 'LeadDate', 'Lead Date', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(1,  'date', 'LastContactDate', 'Last Contact Date', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'select', 'Currency', 'Currency', 0, NULL, 100, 2, 0, 0, 0, NULL, '', 0, '', 1),
(1,  'radio', 'assign', 'Assigned To', 0, NULL, 100, 1, 0, 0, 0, NULL, '', 0, 'Users Group', 1),
(1,  'hidden', 'Rating', 'Rating', 0, NULL, NULL, 3, 0, 0, 0, NULL, '', 0, 1, ''),
(2,  'textarea', 'Address', 'Street Address', 0, NULL, 50, 0, 0, 0, 1, NULL, '', 0, '', 1),
(2, 'select', 'country_id', 'Country', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(2,  'text', 'ZipCode', 'Zip Code', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(2,  'text', 'LandlineNumber', 'Landline', 0, '', 10, 0, 0, 0, 0, NULL, '', 0, '', 1),
(2,  'text', 'Mobile', 'Mobile', 0, NULL, 10, 0, 0, 0, 0, NULL, '', 0, '', 1),
(3,  'textarea', 'description', 'Description', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, '', 1),
(4, 'text', 'OpportunityName', 'Opportunity Name', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(4,  'text', 'OrgName', 'Organization Name', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'text', 'Amount', 'Amount', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'date', 'CloseDate', 'Expected Close Date', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(4,  'select', 'SalesStage', 'Sales Stage', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(4,  'select', 'CustID', 'Customer', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'select', 'lead_source', 'Lead Source', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(4,  'text', 'NextStep', 'Next Step', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'select', 'OpportunityType', 'Opportunity Type', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'text', 'Probability', 'Probability (%)', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'text', 'Campaign_Source', 'Campaign Source', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'text', 'forecast_amount', 'Forecast Amount', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'text', 'ContactName', 'Contact Name', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'text', 'oppsite', 'Website', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'radio', 'Status', 'Status', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'select', 'Currency', 'Currency', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(4,  'radio', 'assign', 'Assigned To', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(5,  'textarea', 'description', 'Description', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(7,  'textarea', 'description', 'Description', 0, NULL, 500, 0, 0, 0, 1, NULL, '', 0, '', 1),
(6,  'select', 'CustID', 'Customer', 0, NULL, 100, 8, 0, 0, 0, NULL, '', 0, '', 1),
(6,  'text', 'hours', 'Hours Worked', 0, NULL, 100, 6, 0, 0, 0, NULL, '', 0, '', 1),
(6,  'text', 'day', 'Days Worked', 0, NULL, 100, 5, 0, 0, 0, NULL, '', 0, '', 1),
(6,  'select', 'category', 'Ticket Category', 0, NULL, 100, 4, 0, 0, 1, NULL, '', 0, '', 1),
(6,  'select', 'priority', 'Priority', 0, NULL, 100, 3, 0, 0, 1, NULL, '', 0, '', 1),
(6,  'select', 'Status', 'Ticket Status', 0, NULL, 100, 2, 0, 0, 1, NULL, '', 0, '', 1),
(6,  'radio', 'assign', 'Assigned To', 0, NULL, 100, 7, 0, 0, 1, NULL, '', 0, '', 1),
(6,  'textarea', 'title', 'Title', 0, NULL, 500, 1, 0, 0, 1, NULL, '', 0, '', 1),
(6,  'checkbox', 'sendnotification', 'Email Notification', 0, '1', NULL, 9, NULL, NULL, 0, NULL, '', 0, '1', 1),
(8,  'textarea', 'solution', 'Solution', 0, NULL, 500, 0, 0, 0, 0, NULL, '', 0, '', 1),
(9,  'text', 'title', 'Title', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(9,  'radio', 'assign', 'Assigned To', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(9,  'select', 'CustID', 'Customer', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(9,  'radio', 'Status', 'Status', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(9,  'select', 'FolderID', 'Folder', 0, '', NULL, 0, NULL, NULL, 0, NULL, '', 0, 1, ''),
(10,  'Image', 'FileName', 'Upload Document', 0, '', NULL, 0, NULL, NULL, 0, NULL, '', 0, 1, 1),
(11, 'textarea', 'description', 'Description', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(15, 'radio', 'Status', 'Status', 0, '', 100, 14, 0, 0, 1, NULL, '', 0, 'Active Inactive', 1),
(15, 'select', 'CustID', 'Customer', 0, '', 100, 13, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'checkbox', 'EmailOptOut', 'Email Opt Out', 0, 'Yes', 100, 12, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'checkbox', 'DoNotCall', 'Do Not Call', 0, 'Yes', 100, 10, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'select', 'AssignTo', 'Assigned To', 0, NULL, 100, 8, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'select', 'LeadSource', 'Lead Source', 0, NULL, 100, 7, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'text', 'Department', 'Department', 0, NULL, 100, 6, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'text', 'Title', 'Title', 0, NULL, 100, 5, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'text', 'PersonalEmail', 'Personal Email', 0, NULL, 100, 4, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'text', 'Email', 'Email', 0, NULL, 100, 3, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'text', 'LastName', 'Last Name', 0, NULL, 100, 2, 0, 0, 1, NULL, '', 0, '', 1),
(15, 'text', 'FirstName', 'First Name', 0, NULL, 100, 1, 0, 0, 1, NULL, '', 0, '', 1),
(16, 'text', 'Landline', 'Landline', 0, '', 10, 5, 0, 0, 1, NULL, '', 0, '', 1),
(16, 'text', 'Mobile', 'Mobile', 0, NULL, 10, 4, 0, 0, 1, NULL, '', 0, '', 1),
(16, 'text', 'ZipCode', 'Zip Code', 0, NULL, 8, 3, 0, 0, 1, NULL, '', 0, '', 1),
(16, 'select', 'country_id', 'Country', 0, NULL, 100, 2, 0, 0, 1, NULL, '', 0, '', 1),
(16, 'textarea', 'Address', 'Address', 0, NULL, 50, 1, 0, 0, 1, NULL, '', 0, '', 1),
(17, 'textarea', 'Description', 'Description', 0, NULL, 50, 0, 0, 0, 1, NULL, '', 0, '', 1),
(18, 'text', 'subject', 'Subject', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(18, 'radio', 'assign', 'Assigned To', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(18, 'date', 'startDate', 'Start Date & Time', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(18, 'date', 'closeDate', 'End Date & Time', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(18, 'select', 'status', 'Status', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(18, 'select', 'priority', 'Priority', 0, NULL, 100, 0, 0, 0, 0, NULL, 'High,Medium,Low', 0, '1', 1),
(18, 'select', 'activityType', 'Activity Type', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '1', 1),
(18, 'checkbox', 'Notification', 'Send Notification', 0, '1', 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(18, 'text', 'location', 'Location', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(18, 'select', 'visibility', 'Visibility', 0, NULL, 100, 0, 0, 0, 0, NULL, 'Private,Public', 0, '1', 1),
(18, 'select', 'CustID', 'Customer', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(19, 'checkbox', 'reminder', 'Send Reminder', 0, '1', 100, 0, 0, NULL, 0, NULL, '', 0, '1', 1),
(20, 'textarea', 'description', 'Description', 0, NULL, 500, 0, 0, NULL, 0, NULL, '', 0, '1', 1),
(22, 'text', 'subject', 'Subject', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(22, 'select', 'CustType', 'Type', 0, NULL, 100, 0, 0, 0, 1, NULL, 'Opportunity,Customer', 0, '', 1),
(22, 'select', 'quotestage', 'Quote Stage', 0, NULL, 100, 0, 0, 0, 1, NULL, 'Created,Delivered,Reviewed,Accepted,Rejected', 0, '', 1),
(22, 'date', 'validtill', 'Valid Till', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(22, 'select', 'PaymentTerm', 'Payment Term', 0, NULL, 100, 0, 0, 0, 0, '0', '', 0, '', 1),
(22, 'select', 'PaymentMethod', 'Payment Method', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 0),
(22, 'select', 'carrier', 'Shipping Mode', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(22, 'text', 'shipping', 'Shipping', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(22, 'radio', 'assign', 'Assigned To', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(22, 'textarea', 'Comment', 'Notes', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(22, 'select', 'CustomerCurrency', 'Currency', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(23, 'textarea', 'bill_street', 'Billing Address', 0, NULL, 50, 0, 0, 0, 1, NULL, '', 0, '', 1),
(23, 'text', 'bill_city', 'Billing City', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(23, 'text', 'bill_state', 'Billing State', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(23, 'text', 'bill_country', 'Billing Country', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(23, 'text', 'bill_code', 'Billing Postal Code', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(24, 'textarea', 'ship_street', 'Shipping Address', 0, NULL, 50, 0, 0, 0, 1, NULL, '', 0, '', 1),
(24, 'text', 'ship_city', 'Shipping City', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(24, 'text', 'ship_state', 'Shipping State', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(24, 'text', 'ship_country', 'Shipping Country', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(24, 'text', 'ship_code', 'Shipping Postal Code', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(24, 'radio', 'Reseller', 'Reseller', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, 'Yes No', 1),
(24, 'text', 'ResellerNo', 'Reseller No', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(24, 'select', 'tax_auths', 'Taxable', 0, NULL, 100, 0, 0, 0, 0, NULL, 'No,Yes', 0, '', 1),
(24, 'hidden', 'TaxRate', 'Tax Rate', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'text', 'CustCode', 'Customer Code', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'select', 'CustomerType', 'Customer Type', 0, NULL, 100, 0, 0, 0, 1, NULL, 'Individual,Company', 0, '', 1),
(21, 'text', 'Company', 'Company', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(21, 'text', 'FirstName', 'First Name', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(21, 'text', 'LastName', 'Last Name', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(21, 'select', 'Gender', 'Gender', 0, NULL, 100, 0, 0, 0, 1, NULL, 'Male,Female', 0, '', 1),
(21, 'text', 'Email', 'Email', 0, NULL, 100, 0, 0, 0, 1, NULL, '', 0, '', 1),
(21, 'text', 'Mobile', 'Mobile', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'text', 'Landline', 'Landline', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'text', 'Website', 'Website', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'date', 'CustomerSince', 'Customer Since', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'select', 'PaymentTerm', 'Payment Term', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'select', 'PaymentMethod', 'Payment Method', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 0),
(21, 'select', 'ShippingMethod', 'Shipping Carrier', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'checkbox', 'Taxable', 'Taxable', 0, 'Yes', 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(21, 'radio', 'Status', 'Status', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, 'Active Inactive', 1),
(12, 'text', 'campaignname', 'Campaign Name', 0, '', 100, 1, NULL, NULL, 1, NULL, '', 0, '1', 1),
(12, 'select', 'assignedTo', 'Assigned To', 0, '', 2, 2, NULL, NULL, 0, NULL, '', 0, '1', 1),
(12, 'select', 'campaignstatus', 'Campaign Status', 0, '', 3, 3, NULL, NULL, 1, NULL, '', 0, '1', 1),
(12, 'select', 'campaigntype', 'Campaign Type', 0, '', 4, 4, NULL, NULL, 1, NULL, '', 0, '1', 1),
(12, 'select', 'product', 'Product', 0, '', 5, 5, NULL, NULL, 1, NULL, '', 0, '1', 0),
(12, 'text', 'targetaudience', 'Target Audience', 0, '', 6, 7, NULL, NULL, 1, NULL, '', 0, '1', 1),
(12, 'date', 'closingdate', 'Expected Close Date', 0, '', 7, 6, NULL, NULL, 1, NULL, '', 0, '1', 1),
(12, 'text', 'targetsize', 'Target Size', 0, '', 8, 8, NULL, NULL, 1, NULL, '', 0, '1', 1),
(12, 'text', 'sponsor', 'Sponsor', 0, '', 9, 9, NULL, NULL, 0, NULL, '', 0, '1', 0),
(13, 'text', 'budgetcost', 'Budget Cost', 0, '', 10, 1, NULL, NULL, 1, NULL, '', 0, '1', 1),
(13, 'text', 'actualcost', 'Actual Cost', 0, '', 11, 2, NULL, NULL, 1, NULL, '', 0, '1', 0),
(13, 'select', 'expectedresponse', 'Expected Response', 0, '', 12, 3, NULL, NULL, 0, NULL, '', 0, '1', 1),
(13, 'text', 'expectedrevenue', 'Expected Revenue', 0, '', 13, 4, NULL, NULL, 1, NULL, '', 0, '1', 1),
(13, 'text', 'expectedsalescount', 'Expected Sales Count', 0, '', 14, 5, NULL, NULL, 1, NULL, '', 0, '1', 1),
(13, 'text', 'actualsalescount', 'Actual Sales Count', 0, '', 15, 6, NULL, NULL, 0, NULL, '', 0, '1', 1),
(13, 'text', 'expectedresponsecount', 'Expected Response Count', 0, '', 16, 7, NULL, NULL, 1, NULL, '', 0, '1', 1),
(13, 'text', 'actualresponsecount', 'Actual Response Count', 0, '', 17, 8, NULL, NULL, 1, NULL, '', 0, '1', 1),
(13, 'text', 'expectedroi', 'Expected ROI', 0, '', 18, 9, NULL, NULL, 1, NULL, '', 0, '1', 1),
(13, 'text', 'actualroi', 'Actual ROI', 0, '', 19, 10, NULL, NULL, 1, NULL, '', 0, '1', 1),
(14, 'textarea', 'description', 'Description', 0, '20', 100, 0, 0, 0, 0, NULL, '', 0, '1', 1),
(25, 'select', 'RelatedType', 'Related Type', 0, '', NULL, 0, NULL, NULL, 0, NULL, '', 0, '', 1),
(26, 'select', 'RelatedType', 'Related Type', 0, '', NULL, 0, NULL, NULL, 0, NULL, '', 0, '', 1),
(27, 'text', 'Sku', 'SKU', 0, NULL, 50, 0, 0, 0, 1, NULL, '', 0, 1, ''),
(27, 'text', 'description', 'Item Name', 0, NULL, 50, 0, 0, 0, 1, NULL, '', 0, 1, 1),
(27, 'text', 'sell_price', 'Price', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, 1, 1),
(27, 'text', 'qty_on_hand', 'Qty on Hand', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, 1, 1),
(27, 'Image', 'Image', 'Item Image', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, 1, 1),
(27, 'radio', 'Status', 'Status', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, 1, 1),
(27, 'textarea', 'long_description', 'Description', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, 1, 1),
('28','checkbox', 'PaymentInfo', 'Payment Info', '0', 1, '50', '0', '0', '0', '0', NULL, '', '0', '1', '1'), 
('28','checkbox', 'SoDelivery', 'Sales Order Delivery', '0', 1, '50', '0', '0', '0', '0', NULL, '', '0', '1', '1'),
('28','checkbox', 'CreditDelivery', 'Credit Memo Delivery', '0', 1, '50', '0', '0', '0', '0', NULL, '', '0', '1', '1'), 
('28','checkbox', 'InvoiceDelivery', 'Invoice Delivery', '0', 1, '50', '0', '0', '0', '0', NULL, '', '0', '1', '1'), 
('28','checkbox', 'ReturnDelivery', 'Return Order Delivery', '0', 1, '50', '0', '0', '0', '0', NULL, '', '0', '1', '1'),
('28','checkbox', 'Statement', 'Statement Delivery', '0', 1, '50', '0', '0', '1', '0', NULL, '', '0', '1', '1'),
(21, 'text', 'CreditLimit', 'Credit Limit', 0, '', NULL, 0, NULL, NULL, 0, NULL, '', 0, '', 1),
(16, 'text', 'contact', 'Contact', 0, NULL , 20, 3, 0, 0, 0, NULL , '', 0, 1, '' ) ,
(15, 'text', 'FullName', 'Name', 0, NULL , 20, 0, 0, 0, 1, NULL , '', 0, 1, '' ),
('21', 'select', 'Currency','Currency', '0', NULL, NULL, '0', '0', '0', '0', NULL, '', '0', '1', '1'),
('21', 'text', 'tel_ext','Ext', '0', NULL, '6', '0', '0', '0', '0', NULL, '', '1', '1', ''),
(21, 'select', 'DefaultAccount', 'Default Account', '0', NULL, '0', '20', '0', '0', '0', NULL, '', '0', '', '0'),
(21, 'select', 'c_taxRate', 'Tax Rate', 0, NULL, NULL, NULL, 18, NULL, 0, NULL, '', 1, '', 1),
(21, 'checkbox', 'customerHold', 'Customer Hold', '', 1, NULL, NULL, NULL, NULL, '0', NULL, '', '0', '', '1'),
(21, 'text', 'VAT', 'VAT', 0, NULL, NULL, 32, NULL, NULL, 0, NULL, '', 0, '', 1 ),
(21, 'text', 'TRN', 'TRN No', 0, NULL, NULL, 32, NULL, NULL, 0, NULL, '', 0, '', 1 ),
(6,  'text', 'Email', 'Email', 0, NULL, 100, '7', NULL, NULL, 1, NULL, '0', 0, '', 1),
(29,  'textarea', 'Address', 'Street Address', 0, NULL, 50, 0, 0, 0, 0, NULL, '', 0, '', 1),
(29,  'select', 'country_id', 'Country', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(29,  'text', 'ZipCode', 'Zip Code', 0, NULL, 100, 0, 0, 0, 0, NULL, '', 0, '', 1),
(29,  'text', 'LandlineNumber', 'Landline', 0, '', 10, 0, 0, 0, 0, NULL, '', 0, '', 1),
(29,  'text', 'Mobile', 'Mobile', 0, NULL, 10, 0, 0, 0, 0, NULL, '', 0, '', 1),
('21', 'checkbox', 'DefaultCustomer', 'Default Customer', '1', '1', '100', '30', NULL, NULL, '0', NULL, '', '1', '', '1');


CREATE TABLE IF NOT EXISTS `c_head_value` (
  `head_id` int(10) NOT NULL AUTO_INCREMENT,
  `head_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `module` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `edittable` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(18) NOT NULL,
  `module_id` int(11) NOT NULL COMMENT 'Like CRM',
  `sequence` int(15) NOT NULL,
   PRIMARY KEY (`head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `c_head_value` (`head_id`, `head_value`, `module`, `Status`, `edittable`, `locationID`, `module_id`, `sequence`) VALUES
(1, 'Lead Details', 102, 1, 0, 1, 0, 0),
(2, 'Address Details', 102, 1, 0, 1, 0, 1),
(3, 'Description', 102, 1, 0, 1, 0, 3),
(4, 'Opportunity', 103, 1, 0, 1, 0, 0),
(5, 'Description', 103, 1, 0, 0, 0, 1),
(6, 'Ticket Information', 104, 1, 0, 1, 0, 0),
(7, 'Description Details', 104, 1, 0, 1, 0, 3),
(8, 'Ticket Resolution', 104, 1, 0, 1, 0, 4),
(9, 'Basic Information', 105, 1, 0, 1, 5, 1),
(10, 'File Details', 105, 1, 0, 1, 5, 2),
(11, 'Description', 105, 1, 0, 1, 5, 3),
(12, 'Campaign Information', 106, 1, 0, 1, 0, 0),
(13, 'Expectations & Actuals', 106, 1, 0, 1, 0, 1),
(14, 'Description', 106, 1, 0, 1, 0, 2),
(15, 'Basic Information', 107, 1, 0, 1, 0, 0),
(16, 'Address Details', 107, 1, 0, 1, 0, 1),
(17, 'Description Details', 107, 1, 0, 1, 0, 2),
(18, 'Details', 136, 1, 0, 0, 0, 0),
(19, 'Reminder Details', 136, 1, 0, 0, 0, 0),
(20, 'Description', 136, 1, 0, 0, 0, 0),
(21, 'General Information', 2015, 1, 0, 0, 0, 0),
(22, 'Quote Information', 108, 1, 0, 1, 5, 1),
(23, 'Bill Address Information', 108, 1, 0, 1, 5, 2),
(24, 'Ship Address Information', 108, 1, 0, 1, 5, 3),
(25, 'Related To', 136, 1, 0, 1, 0, 0),
(26, 'Related To', 104, 1, 0, 1, 0, 6),
(27, 'Basic Information', 2003, 1, 0, 1, 0, 0),
(28, 'Assign Role', 107, 1, 0, 1, 5, 4),
(29, 'Address Details', 103, 1, 0, 0, 0, 0),
(44, 'Related To', 136, 1, 0, 0, 0, 0),
(45, 'Related To', 104, 1, 0, 0, 0, 6),
(46, 'Basic Information', 2003, 1, 0, 1, 0, 0);

CREATE TABLE IF NOT EXISTS `c_custom_field_value` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `PID` int(10) NOT NULL,
  `fieldid` int(10) NOT NULL,
  `custom_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `module_type` varchar(50) NOT NULL,
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `leadID` (`PID`),
  KEY `fieldid` (`fieldid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------



CREATE TABLE IF NOT EXISTS `c_mail_chimp_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `campaign_id` varchar(255) NOT NULL,
  `segment_id` varchar(255) NOT NULL,
  `template_id` varchar(255) NOT NULL,
  `status` enum('send','unsend') NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) NOT NULL,
  `parent_Id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

CREATE TABLE IF NOT EXISTS `c_mail_chimp_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `campaign_id` varchar(255) NOT NULL,
  `status` enum('sent','unsent') NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `send_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

CREATE TABLE IF NOT EXISTS `c_mail_chimp_segment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `segment_id` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

CREATE TABLE IF NOT EXISTS `c_mail_chimp_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_chimp_cmpId` varchar(50) NOT NULL,
  `mail_chimp_Api_Key` varchar(100) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `groupId` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `c_mail_chimp_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `template_foder_id` varchar(100) NOT NULL,
  `campaign_folder_id` varchar(100) NOT NULL,
  `group_id` varchar(100) NOT NULL,
  `list_id` varchar(100) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `c_mail_chimp_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `template_id` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;


CREATE TABLE IF NOT EXISTS `c_mail_chimp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('subscribed','unsubscribed') NOT NULL,
  `euid` varchar(100) NOT NULL,
  `leid` varchar(100) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;













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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `Status` tinyint(1) NOT NULL DEFAULT '1',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
  `OptionsAttribute` text COLLATE latin1_general_ci NOT NULL,
  `Weight` decimal(10,2) unsigned NOT NULL,
  `AddedDate` date NOT NULL,
  `Variant_ID` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Variant_val_Id` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `AliasID` int(11) NOT NULL,
  `UploadedFile` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`CartID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_catalog_attributes`
--

CREATE TABLE IF NOT EXISTS `e_catalog_attributes` (
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Gaid` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `cid` (`Cid`),
  KEY `gaid` (`Gaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `ebay_settings` (
  `ebay_ID` int(11) NOT NULL AUTO_INCREMENT,
  `s_devID` varchar(200) NOT NULL,
  `s_appID` varchar(200) NOT NULL,
  `s_certID` varchar(200) NOT NULL,
  `s_userToken` text NOT NULL,
  `s_paypalEmailAddress` varchar(200) NOT NULL,
  `p_devID` varchar(200) NOT NULL,
  `p_appID` varchar(200) NOT NULL,
  `p_certID` varchar(200) NOT NULL,
  `p_userToken` text NOT NULL,
  `p_paypalEmailAddress` varchar(200) NOT NULL,
  `credential_Type` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `syncOders` varchar(10) NOT NULL,
  `last_orders_sync` datetime NOT NULL,
  `from_date` date NOT NULL,
  `s_payment_method` varchar(200) NOT NULL,
  `s_return_policy` text NOT NULL,
  `s_shipping_details` text NOT NULL,
  `p_payment_method` varchar(200) NOT NULL,
  `p_return_policy` text NOT NULL,
  `p_shipping_details` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `sync_product` tinyint(4) NOT NULL,
  `site_id` int(5) NOT NULL,
  `set_desc` tinyint(4) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `listing_duration` varchar(50) NOT NULL,
  `item_condition` varchar(50) NOT NULL,
  `condition_note` varchar(255) NOT NULL,
  `Fee` tinyint(1) NOT NULL,
  `FeeRate` float(10,2) NOT NULL,
  PRIMARY KEY (`ebay_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  KEY `Name` (`Name`),
  KEY `ParentID` (`ParentID`)
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `custType` enum('general','dealer','vendorpos','chef','server','seniorserver','poscustomer') DEFAULT 'general',
  `AssignedCategories` text NOT NULL,
  `WalletLimit` float(10,2) NOT NULL DEFAULT '0.00',
  `WalletBalance` float(10,2) NOT NULL DEFAULT '0.00',
  `Parent` int(11) DEFAULT '0',
  `passcode` varchar(10) NOT NULL,
  `tableLayout` int(11) NOT NULL,
  `serviceType` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `image` varchar(255) NOT NULL,
  `JobTitle` int(11) NOT NULL,
  `AssignedLocation` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  `shift_id` int(11) NOT NULL,
  PRIMARY KEY (`Cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_delhivery_status`
--

CREATE TABLE IF NOT EXISTS `e_delhivery_status` (
  `delhiveryID` int(11) NOT NULL AUTO_INCREMENT,
  `DelhiveryStatus` varchar(255) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`delhiveryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_email_signup`
--

CREATE TABLE IF NOT EXISTS `e_email_signup` (
  `MemberID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(80) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
 `required` varchar(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Gaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `OptionsAttribute` text COLLATE latin1_general_ci NOT NULL,
  `Quantity` int(20) NOT NULL,
  `Weight` decimal(10,2) NOT NULL,
  `Price` float(10,2) NOT NULL,
  `TaxRate` float(10,2) NOT NULL,
  `TaxDescription` text COLLATE latin1_general_ci NOT NULL,
  `Variant_ID` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Variant_val_Id` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `AliasID` int(11) NOT NULL,
  `UploadedFile` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `AmazonSku` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `ASIN` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `OrderItemId` varchar(70) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`OrderDetailId`),
  KEY `OrderID` (`OrderID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `CurrencyValue` varchar(50) COLLATE latin1_general_ci NOT NULL,
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
  `GroupDiscount` decimal(10,2) NOT NULL,
  `GroupDiscountSetting` text COLLATE latin1_general_ci NOT NULL,
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
  `DelivaryDate` date NOT NULL,
  `TrackNumber` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `TrackMsg` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `TrackMsgDate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `SecurityId` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ShipDate` datetime NOT NULL,
  `AmazonOrderId` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `AmazonAccountID` int(5) NOT NULL,
  `OrderType` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `SellerChannel` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Fee` decimal(10,2) NOT NULL,
  `RowColor` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `isPrime` tinyint(1) NOT NULL DEFAULT '0',
  `isCustom` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`OrderID`),
  KEY `MemberID` (`Cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;




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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_package_category`
--

CREATE TABLE IF NOT EXISTS `e_package_category` (
  `CatID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`CatID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `DisplayMenu` varchar(30) NOT NULL DEFAULT '',
  `Banner_image` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_price_refine`
--

CREATE TABLE IF NOT EXISTS `e_price_refine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `range` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `variant_id` varchar(55) COLLATE latin1_general_ci NOT NULL,
  `is_upld` tinyint(1) NOT NULL DEFAULT '0',
  `label_txt` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `product_type` enum('Physical','Virtual','','') COLLATE latin1_general_ci NOT NULL,
  `secure_type` enum('Secure','Unsecure','','') COLLATE latin1_general_ci NOT NULL,
  `virtual_file` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ProductID`),
  KEY `CategoryID` (`CategoryID`),
  KEY `Featured` (`Featured`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `required` varchar(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_categories`
--

CREATE TABLE IF NOT EXISTS `e_products_categories` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `pid` (`pid`,`cid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_categories`
--

CREATE TABLE IF NOT EXISTS `e_promo_categories` (
  `PromoID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  PRIMARY KEY (`PromoID`,`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_products`
--

CREATE TABLE IF NOT EXISTS `e_promo_products` (
  `PromoID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  PRIMARY KEY (`PromoID`,`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_recommended_products`
--

CREATE TABLE IF NOT EXISTS `e_recommended_products` (
  `RecommendID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `RecommendedProductID` int(10) NOT NULL,
  PRIMARY KEY (`RecommendID`,`ProductID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
  `Variant_ID` varchar(200) NOT NULL,
  `Variant_val_Id` varchar(500) NOT NULL,
  `AliasID` int(11) NOT NULL,
  PRIMARY KEY (`Wlpid`),
  KEY `wlid` (`Wlid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `e_global_optionList` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `paid` int(11) NOT NULL,	
  `Gaid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PriceType` varchar(30) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `SortOrder` int(11) NOT NULL,
 PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;




CREATE TABLE IF NOT EXISTS `amazon_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `merchant_id` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `marketplace_id` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mws_auth_token` varchar(100) NOT NULL,
  `market_id` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `sync_orders` int(11) DEFAULT NULL,
  `sync_products` int(11) DEFAULT NULL,
  `last_orders_sync` datetime DEFAULT NULL,
  `from_date` datetime NOT NULL,
  `set_desc` int(2) NOT NULL,
  `sync_product` int(2) NOT NULL,
  `fulfilled_by` varchar(20) NOT NULL,
  `Default_cat` varchar(150) NOT NULL,
  `condition_note` text NOT NULL,
  `set_default` tinyint(4) NOT NULL,
  `set_condition` varchar(100) NOT NULL,
  `brand` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `amazon_items` (
  `pid` int(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(150) NOT NULL,
  `ProductSku` varchar(50) NOT NULL,
  `itemID` varchar(50) NOT NULL,
  `Cat` varchar(70) NOT NULL,
  `browserNode` varchar(50) NOT NULL COMMENT 'For Ebay = SiteID',
  `MfrPartNumber` varchar(50) NOT NULL,
  `Brand` varchar(80) NOT NULL,
  `ProductType` varchar(20) NOT NULL DEFAULT 'ASIN' COMMENT 'For Ebay = ListingTypeCodeType',
  `ProductCode` varchar(20) NOT NULL COMMENT 'For Ebay = ItemID',
  `ProductTypeName` varchar(200) NOT NULL COMMENT 'For Ebay = ListingDuration',
  `Quantity` int(4) NOT NULL,
  `Price` double(8,2) NOT NULL,
  `ItemCondition` varchar(20) NOT NULL,
  `ItemConditionNote` text NOT NULL,
  `ShortDetail` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `LaunchDate` date NOT NULL,
  `SaleStartDate` date NOT NULL,
  `SaleEndDate` date NOT NULL,
  `GiftMessage` tinyint(1) NOT NULL,
  `GiftWrap` tinyint(1) NOT NULL,
  `Price2` double(8,2) NOT NULL,
  `RestockDate` date NOT NULL,
  `FeedSubmissionId` varchar(50) NOT NULL,
  `FeedProcessingStatus` varchar(50) NOT NULL,
  `FeedProcessingSMsg` text NOT NULL,
  `Status` int(2) NOT NULL,
  `LastUpdateDate` datetime NOT NULL,
  `AmazonAccountID` int(5) NOT NULL,
  `Features` text NOT NULL,
  `Keywords` text NOT NULL,
  `TaxCode` varchar(300) NOT NULL,
  `FulfilledBy` varchar(200) NOT NULL COMMENT 'For Ebay = ViewItemURL',
  `Channel` varchar(20) NOT NULL,
  `ListingPrice` decimal(10,2) NOT NULL COMMENT 'lowest price = ListingPrice+Shipping',
  `Shipping` decimal(10,2) NOT NULL,
  `CatHierarchy` varchar(300) NOT NULL,
  `AliasID` int(20) NOT NULL,
 `PQIUpdate` tinyint(4) NOT NULL,
    PRIMARY KEY (`pid`),
    KEY `itemID` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `amazon_markets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `developer_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `enabled` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sort_order` int(11) unsigned NOT NULL DEFAULT '0',
  `group_title` varchar(255) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `amazon_markets` (`id`, `developer_id`, `title`, `code`, `url`, `enabled`, `sort_order`, `group_title`) VALUES
(24, '', 'Canada', 'CA', 'amazon.ca', 1, 3, 'America'),
(25, '', 'Germany', 'DE', 'amazon.de', 1, 4, 'Europe'),
(26, '', 'France', 'FR', 'amazon.fr', 1, 5, 'Europe'),
(27, '', 'Japan', 'JP', 'amazon.co.jp', 1, 9, 'Asia / Pacific'),
(28, '', 'United Kingdom', 'UK', 'amazon.co.uk', 1, 2, 'Europe'),
(29, '', 'United States', 'US', 'amazon.com', 1, 1, 'America'),
(30, '', 'Spain', 'ES', 'amazon.es', 1, 8, 'Europe'),
(31, '', 'Italy', 'IT', 'amazon.it', 1, 6, 'Europe'),
(32, '', 'China', 'CN', 'amazon.cn', 0, 10, 'Asia / Pacific'),
(33, '', 'Mexico', 'MX', 'amazon.com.mx', 1, 7, 'America');

CREATE TABLE IF NOT EXISTS `amazon_submit_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProductSku` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FeedSubmissionId` varchar(50) NOT NULL,
  `FeedProcessingSMsg` text NOT NULL,
  `FeedProcessingStatus` varchar(20) NOT NULL,
  `Status` int(2) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `amazonAccountID` int(5) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `f_reconcile` (
  `ReconcileID` int(11) NOT NULL AUTO_INCREMENT,
  `Year` varchar(10) NOT NULL,
  `Month` varchar(10) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `Status` varchar(25) NOT NULL,
  `FinalStatus` tinyint(1) NOT NULL,
  `EndingBankBalance` float(10,2) NOT NULL,
  `TotalDebitByCheck` float(10,2) NOT NULL,
  `TotalCreditByCheck` float(10,2) NOT NULL,
  `TotalDebitCreditByCheck` float(10,2) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdateDate` date NOT NULL,
  `LocationID` int(11) NOT NULL,
  `IPAddress` varchar(50) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(30) NOT NULL,
  `UnRecMonth` varchar(10) NOT NULL,
  PRIMARY KEY (`ReconcileID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `f_reconcile_transaction` (
 `TransactionID` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `ReconcileID` int(11) NOT NULL,
 `PaymentID` int(11) NOT NULL,
 PRIMARY KEY (`TransactionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `GroupID` int(11) NOT NULL,
  PRIMARY KEY (`BankAccountID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_deposit`
--

CREATE TABLE IF NOT EXISTS `f_archive_deposit` (
  `DepositID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) unsigned NOT NULL,
  `Amount` varchar(50) NOT NULL DEFAULT '0.00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `Amount` varchar(50) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
 `TotalAmount` varchar(50) NOT NULL DEFAULT '0.00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `TotalDebit` varchar(50) NOT NULL DEFAULT '0.00',
  `TotalCredit` varchar(50) NOT NULL DEFAULT '0.00',
  `LocationID` int(11) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`JournalID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `DebitAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `CreditAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `EntityType` varchar(30) NOT NULL,
  `EntityName` varchar(100) NOT NULL,
  `EntityID` varchar(50) NOT NULL,
  PRIMARY KEY (`JournalEntryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `Amount` varchar(50) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalAmount` varchar(50) NOT NULL DEFAULT '0.00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `DebitAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `CreditAmnt` varchar(50) NOT NULL DEFAULT '0.00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_archive_transfer`
--

CREATE TABLE IF NOT EXISTS `f_archive_transfer` (
  `TransferID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TransferFrom` int(11) unsigned NOT NULL,
  `TransferTo` int(11) unsigned NOT NULL,
  `TransferAmount` varchar(50) NOT NULL DEFAULT '0.00',
  `TransferDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`TransferID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_deposit`
--

CREATE TABLE IF NOT EXISTS `f_deposit` (
  `DepositID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) unsigned NOT NULL,
  `Amount` varchar(50) NOT NULL DEFAULT '0.00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
  `Amount` varchar(50) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `TotalAmount` varchar(50) NOT NULL DEFAULT '0.00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
  `TotalDebit` varchar(50) NOT NULL DEFAULT '0.00',
  `TotalCredit` varchar(50) NOT NULL DEFAULT '0.00',
  `LocationID` int(11) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `PostToGLTime` varchar(20) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `ReferenceID` varchar(80) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `ConversionRate` varchar(30) NOT NULL,
  `RowColor` varchar(50) NOT NULL,
  `BankTransfer` tinyint(1) NOT NULL,
  PRIMARY KEY (`JournalID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
  `DebitAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `CreditAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `EntityType` varchar(30) NOT NULL,
  `EntityName` varchar(100) NOT NULL,
  `EntityID` varchar(50) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `BankCurrency` varchar(6) NOT NULL,
  `BankCurrencyRate` varchar(20) NOT NULL,
  `ModuleCurrency` varchar(6) NOT NULL,
  PRIMARY KEY (`JournalEntryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `f_group` (
  `GroupID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentGroupID` int(11) NOT NULL,
  `GroupName` varchar(40) NOT NULL,
  `GroupNumber` varchar(10) NOT NULL,
  `AccountType` int(11) NOT NULL,
  `RangeFrom` int(5) NOT NULL,
  `RangeTo` int(5) NOT NULL,
  `Status` varchar(5) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
   PRIMARY KEY (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `f_group` (`GroupID`, `ParentGroupID`, `GroupName`, `GroupNumber`, `AccountType`, `RangeFrom`, `RangeTo`, `Status`, `CreatedDate`, `UpdatedDate`) VALUES
(1, 0, 'Current Assets', '', 1, 0, 0, 'Yes', '2015-09-04 02:48:28', '2015-09-04 02:49:35'),
(2, 0, 'Fixed Assets', '', 1, 0, 0, 'Yes', '2015-09-04 02:49:55', '0000-00-00 00:00:00'),
(3, 0, 'Other Assets', '', 1, 0, 0, 'Yes', '2015-09-04 02:50:05', '0000-00-00 00:00:00'),
(4, 0, 'Current Liabilities', '', 2, 0, 0, 'Yes', '2015-09-04 02:50:15', '2015-09-04 02:50:37'),
(5, 0, 'Long Term Liabilities', '', 2, 0, 0, 'Yes', '2015-09-04 02:50:28', '0000-00-00 00:00:00');


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
  `GlEntryType` varchar(10) NOT NULL,
  `IncomeTypeID` int(11) unsigned NOT NULL,
  `PaymentDate` date NOT NULL,
  `BankAccount` int(11) NOT NULL,
   `Amount` varchar(50) NOT NULL DEFAULT '0.00',
  `TaxID` int(11) NOT NULL,
  `TaxRate` decimal(10,2) NOT NULL DEFAULT '0.00',
   `TotalAmount` varchar(50) NOT NULL DEFAULT '0.00',
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `ReceivedFrom` int(11) NOT NULL,
  `ReferenceNo` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`IncomeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `f_payments`
--

CREATE TABLE IF NOT EXISTS `f_payments` (
  `PaymentID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `EmployeeID` int(11) unsigned NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `PurchaseID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `TransactionID` int(11) NOT NULL,
  `GLID` int(11) NOT NULL,
  `ConversionRate` varchar(20) NOT NULL,
  `AccountName` varchar(50) NOT NULL,
  `DebitAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `CreditAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `AccountID` int(11) NOT NULL,
  `JournalID` int(11) unsigned NOT NULL,
  `IncomeID` int(11) unsigned NOT NULL,
  `ExpenseID` int(11) unsigned NOT NULL,
  `TransferID` int(11) unsigned NOT NULL,
  `DepositID` int(11) unsigned NOT NULL,
  `Method` varchar(50) NOT NULL,
  `CheckBankName` varchar(40) NOT NULL,
  `CheckFormat` varchar(40) NOT NULL,
  `EntryType` varchar(50) NOT NULL,
  `GLCode` varchar(40) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ReferenceNo` varchar(50) NOT NULL,
  `Comment` text NOT NULL,
  `PaymentType` varchar(40) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `Flag` tinyint(2) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `PostToGLDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `AdjID` int(11) NOT NULL,
  `CheckNumber` varchar(30) NOT NULL,
  `Voided` tinyint(1) NOT NULL,
  `NegativeFlag` tinyint(1) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `BankCurrency` varchar(6) NOT NULL,
  `BankCurrencyRate` varchar(20) NOT NULL,
  `ModuleCurrency` varchar(6) NOT NULL,
  `ModuleCurrency2` varchar(6) NOT NULL,
  `OriginalAmount` varchar(50) NOT NULL,
  `TransactionType` varchar(6) NOT NULL,
  PRIMARY KEY (`PaymentID`),
  KEY `TransactionID` (`TransactionID`),
  KEY `PaymentType` (`PaymentType`),
  KEY `CustID` (`CustID`),
  KEY `CustCode` (`CustCode`),
  KEY `SuppCode` (`SuppCode`),
  KEY `InvoiceID` (`InvoiceID`),
  KEY `CreditID` (`CreditID`),
  KEY `AccountID` (`AccountID`),
  KEY `ReferenceNo` (`ReferenceNo`),
  KEY `PostToGL` (`PostToGL`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `f_profit` (
  `ProfitID` bigint(20) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `PurchaseID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `ConversionRate` varchar(20) NOT NULL,
  `DebitAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `CreditAmnt` varchar(50) NOT NULL DEFAULT '0.00',
  `AccountID` int(11) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ReferenceNo` varchar(50) NOT NULL,
  `PaymentType` varchar(40) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`ProfitID`),
  KEY `PaymentType` (`PaymentType`),
  KEY `CustID` (`CustID`),
  KEY `CustCode` (`CustCode`),
  KEY `SuppCode` (`SuppCode`),
  KEY `InvoiceID` (`InvoiceID`),
  KEY `AccountID` (`AccountID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `f_transaction` (
  `TransactionID` int(11) NOT NULL AUTO_INCREMENT,
  `ReceiptID` varchar(30) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(30) NOT NULL,
  `PostToGLDate` date NOT NULL,
  `PostToGLTime` varchar(20) NOT NULL,
  `PostToGL` enum('Yes','No') NOT NULL DEFAULT 'No',
  `ContraID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `TotalAmount` varchar(50) NOT NULL DEFAULT '0.00',
  `AccountID` int(11) NOT NULL,
  `Method` varchar(50) NOT NULL,
  `CheckBankName` varchar(40) NOT NULL,
  `CheckFormat` varchar(40) NOT NULL,
  `EntryType` varchar(50) NOT NULL,
  `GLCode` varchar(40) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Comment` text NOT NULL,
  `PaymentType` varchar(40) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `CheckNumber` varchar(30) NOT NULL,
  `BatchID` int(11) NOT NULL,
  `OrderSource` varchar(20) NOT NULL,
  `Voided` tinyint(1) NOT NULL,
  `OriginalAmount` varchar(50) NOT NULL,
  `ModuleCurrency` varchar(6) NOT NULL,
  `TransferOrderID` int(11) NOT NULL,
  `TransferSuppCode` varchar(40) NOT NULL,
  `Fee` decimal(10,2) DEFAULT '0.00',
  `OrderPaid` tinyint(1) NOT NULL,
  `StatusMsg` varchar(500) NOT NULL,
  PRIMARY KEY (`TransactionID`),
  KEY `AccountID` (`AccountID`),
  KEY `TransferOrderID` (`TransferOrderID`),
  KEY `PaymentType` (`PaymentType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `f_transaction_data` (
  `TrID` int(20) NOT NULL AUTO_INCREMENT,
  `PaymentType` varchar(40) NOT NULL,
  `Module` varchar(10) NOT NULL,
  `TransactionID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `Amount` varchar(50) NOT NULL,
  `OriginalAmount` varchar(50) NOT NULL,
  `ConversionRate` varchar(20) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `InvoiceID` varchar(40) NOT NULL,
  `CreditID` varchar(40) NOT NULL,
  `OrderID` varchar(40) NOT NULL,
  `CreatedDate` date NOT NULL,
  `AdminID` int(20) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `SessionID` varchar(50) NOT NULL,
  `Deleted` tinyint(1) NOT NULL,
  `ModuleCurrency` varchar(6) NOT NULL,
  `Voided` tinyint(1) NOT NULL,
  `Method` varchar(50) NOT NULL,
  `CheckNumber` varchar(30) NOT NULL,
  `TransferFund` tinyint(1) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `OverPaid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TrID`),
  KEY `TransactionID` (`TransactionID`),
  KEY `InvoiceID` (`InvoiceID`),
  KEY `AccountID` (`AccountID`),
  KEY `CreditID` (`CreditID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f_transfer`
--

CREATE TABLE IF NOT EXISTS `f_transfer` (
  `TransferID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `TransferFrom` int(11) unsigned NOT NULL,
  `TransferTo` int(11) unsigned NOT NULL,
  `TransferAmount` varchar(50) NOT NULL DEFAULT '0.00',
  `TransferDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`TransferID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `f_fundtransfer` (
  `TransferID` int(11) NOT NULL AUTO_INCREMENT,
  `TransferType` enum('V','C') NOT NULL DEFAULT 'V',
  `OrderID` int(11) unsigned NOT NULL,
  `TransferFrom` varchar(20) NOT NULL,
  `TransferTo` varchar(20) NOT NULL,
  `TransferAmount` varchar(50) NOT NULL DEFAULT '0.00',
  `GLAccount` int(11) unsigned NOT NULL,
  `TransferDate` date NOT NULL,
  `ReferenceNo` varchar(50) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL,
  PRIMARY KEY (`TransferID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `f_fundtransfer_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TransferID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `SuppCode` varchar(50) NOT NULL,
  `PurchaseID` varchar(100) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `PaymentAmount` varchar(50) NOT NULL DEFAULT '0.00',
  `AccountID` int(11) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `PaymentDate` date NOT NULL,
  `ReferenceNo` varchar(250) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `PaymentType` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

--
-- Table structure for table `f_accounttype`
--

CREATE TABLE IF NOT EXISTS `f_accounttype` (
  `AccountTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountType` varchar(50) NOT NULL,
  `RangeFrom` int(5) NOT NULL,
  `RangeTo` int(5) NOT NULL,
  `ReportType` varchar(20) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `flag` tinyint(2) NOT NULL DEFAULT '0',
  `CreatedDate` date NOT NULL,
  `OrderBy` int(3) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`AccountTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `f_attribute`
--

CREATE TABLE IF NOT EXISTS `f_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) NOT NULL,
  `attribute` varchar(50) NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


--
-- Table structure for table `f_attribute_value`
--

CREATE TABLE IF NOT EXISTS `f_attribute_value` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `locationID` int(11) NOT NULL,
  `FixedCol` tinyint(1) NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;



--
-- Table structure for table `f_account`
--

CREATE TABLE IF NOT EXISTS `f_account` (
  `BankAccountID` int(11) NOT NULL AUTO_INCREMENT,
  `BankName` varchar(100) NOT NULL,
  `AccountName` varchar(100) NOT NULL,
  `AccountNumber` varchar(100) NOT NULL,
  `AccountCode` varchar(30) NOT NULL,
  `AccountType` varchar(50) NOT NULL,
  `RangeFrom` int(5) NOT NULL,
  `RangeTo` int(5) NOT NULL,
  `BankAccountNumber` varchar(30) NOT NULL,
  `BankFlag` tinyint(1) NOT NULL,
  `NextCheckNumber` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `Currency` varchar(100) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `OrderBy` int(11) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdateddDate` date NOT NULL,
  `CashFlag` tinyint(1) unsigned NOT NULL,
  `GroupID` int(11) NOT NULL,
  `DefaultAccount` tinyint(1) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `BankCurrency` varchar(100) NOT NULL,
  `AccountGainLoss` int(11) NOT NULL,
  PRIMARY KEY (`BankAccountID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;



CREATE TABLE IF NOT EXISTS `f_term` (
  `termID` int(11) NOT NULL AUTO_INCREMENT,
  `termName` varchar(40) NOT NULL,
  `termDate` varchar(30) NOT NULL,
  `Day` varchar(10) NOT NULL,
  `Due` varchar(10) NOT NULL,
  `CreditLimit` decimal(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  `termType` tinyint(1) NOT NULL,
  `paymentType` varchar(50) NOT NULL,
  `glAccount` int(11) NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `Deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`termID`),
  UNIQUE KEY `termName` (`termName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 CREATE TABLE IF NOT EXISTS `f_method` (
  `methodID` int(11) NOT NULL AUTO_INCREMENT,
  `methodName` varchar(40) NOT NULL,
  `methodDate` varchar(30) NOT NULL,
  `Day` varchar(10) NOT NULL,
  `Due` varchar(10) NOT NULL,
  `CreditLimit` decimal(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  `methodType` tinyint(1) NOT NULL,
  `paymentType` varchar(50) NOT NULL,
  `glAccount` int(11) NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  PRIMARY KEY (`methodID`),
  UNIQUE KEY `methodName` (`methodName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `f_method` (`methodID`, `methodName`, `Status`, `methodType`, `fixed`) VALUES
(1, 'Electronic Transfer', 1, 0, 1),
(2, 'Credit Card', 1, 1, 1),
(3, 'Check', 1, 1, 0),
(4, 'PayPal', 1, 1, 1),
(5, 'Amazon', 1, 0, 1);


CREATE TABLE IF NOT EXISTS `f_customer_vendor` (
  `relID` int(11) NOT NULL AUTO_INCREMENT,
  `CustID` int(11) NOT NULL,
  `SuppID` int(11) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  PRIMARY KEY (`relID`),
  KEY `CustID` (`CustID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
 `AdminID` varchar(10) NOT NULL,
 `AdminType` varchar(20) NOT NULL,
 PRIMARY KEY (`PeriodID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `f_period_year` (
 `PId` int(11) NOT NULL AUTO_INCREMENT,
 `PeriodYear` varchar(5) NOT NULL, 
 `PeriodStatus` varchar(10) NOT NULL,
 `CreatedDate` date NOT NULL,
 `UpdateDate` date NOT NULL, 
 `IPAddress` varchar(30) NOT NULL,
 PRIMARY KEY (`PId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `f_multi_account_payment` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
`AccountID` int(11) NOT NULL,
`ExpenseID` int(11) NOT NULL,
`AccountName` varchar(250) NOT NULL,
`Amount` varchar(50) NOT NULL,
`Notes` varchar(250) NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `f_multi_account` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
`AccountID` int(11) NOT NULL,
`IncomeID` int(11) NOT NULL,
`AccountName` varchar(250) NOT NULL,
`Amount` varchar(50) NOT NULL,
`Notes` varchar(250) NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `f_multi_adjustment` (
`ID` int(11) NOT NULL AUTO_INCREMENT,
`AccountID` int(11) NOT NULL,
`AdjID` int(11) NOT NULL,
`AccountName` varchar(250) NOT NULL,
`Amount` varchar(50) NOT NULL,
`Notes` varchar(250) NOT NULL,
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `f_adjustment` (
  `AdjID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) unsigned NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PaymentMethod` varchar(100) NOT NULL,
  `CheckBankName` varchar(100) NOT NULL,
  `CheckFormat` varchar(100) NOT NULL,
  `PaymentDate` date NOT NULL,
  `BankAccount` int(11) NOT NULL,
  `Amount` varchar(50) NOT NULL DEFAULT '0.00',
  `Currency` varchar(30) NOT NULL,
  `PaidTo` varchar(30) NOT NULL,
  `SuppCompany` varchar(50) NOT NULL,
  `ReferenceNo` varchar(100) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL DEFAULT '',
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `GlEntryType` varchar(50) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `ExpenseTypeID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`AdjID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `f_batch` (
  `BatchID` int(11) NOT NULL AUTO_INCREMENT,
  `BatchName` varchar(40) NOT NULL,
  `BatchType` varchar(20) NOT NULL,
  `Description` text NOT NULL, 
  `Status` tinyint(1) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  PRIMARY KEY (`BatchID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `f_check` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `cmpStyle` text NOT NULL,
  `checknumberStyle` text NOT NULL,
  `dateStyle` text NOT NULL,
  `payStyle` text NOT NULL,
  `wordStyle` text NOT NULL,
  `currencyStyle` text NOT NULL,
  `memoStyle` text NOT NULL,
  `cmpStubStyle` text NOT NULL,
  `checknumberStubStyle` text NOT NULL,
  `dateStubStyle` text NOT NULL,
  `payStubStyle` text NOT NULL,
  `currencyStubStyle` text NOT NULL,
  `invoiceStubStyle` text NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdateDate` datetime NOT NULL,
  `LabelDateStyle` varchar(100) NOT NULL,
  `LabelPayStyle` varchar(100) NOT NULL,
  `LabelMemoStyle` varchar(100) NOT NULL,
  `LabelDateStubStyle` varchar(100) NOT NULL,
  `LabelPayStubStyle` varchar(100) NOT NULL,
  `BoxStyle` varchar(100) NOT NULL,
  `VendorAddressStyle` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `locationID` (`locationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `f_payment_provider` (
  `ProviderID` int(10) NOT NULL AUTO_INCREMENT,
  `ProviderName` varchar(40) NOT NULL,
  `CardType` varchar(100) NOT NULL,
  `ProviderFee` varchar(10) NOT NULL, 
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL, 
  `paypalID` varchar(100) NOT NULL,
  `ppfPartnerId` varchar(100) NOT NULL,
  `ppfPassword` varchar(100) NOT NULL,
  `ppfVendor` varchar(100) NOT NULL,
  `ppfUserId` varchar(100) NOT NULL, 
  `anApiLoginId` varchar(100) NOT NULL,
  `anTransactionKey` varchar(100) NOT NULL,
  `glAccount` int(11) NOT NULL,
  `paypalUsername` varchar(100) NOT NULL,
  `paypalPassword` varchar(40) NOT NULL,
  `paypalSignature` varchar(100) NOT NULL,
  `PaypalToken` text,
  `paypalAppid` varchar(100) NOT NULL,
  `AccountPaypal` int(11) NOT NULL,
  `AccountPaypalFee` int(11) NOT NULL,
  `AccountCardFee` int(11) NOT NULL,
  `VisaGL` int(11) NOT NULL,
  `MasterCardGL` int(11) NOT NULL,
  `DiscoverGL` int(11) NOT NULL,
  `AmexGL` int(11) NOT NULL,
  `NabMerchantID` varchar(100) NOT NULL,
  `NabApplicationID` varchar(50) NOT NULL,
  `NabIndustry` varchar(50) NOT NULL,
  `NabServiceID` varchar(100) NOT NULL,
  `NabToken` text,
  PRIMARY KEY (`ProviderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `f_payment_provider` (`ProviderID`, `ProviderName`, `Status`,`NabIndustry`) VALUES
(1, 'PayPal Standard', 1, ''),
(2, 'PayPal Payflow', 1, ''),
(3, 'Authorize.Net', 1, ''),
(4, 'NAB Velocity', 0, 'Ecommerce');


CREATE TABLE IF NOT EXISTS `f_cron_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EntryType` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `EntryType` (`EntryType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `f_cron_setting` (`id`, `EntryType`) VALUES 
('1', 'EmailStatement');

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
  `FixedCol` tinyint(1) NOT NULL,
  `InfoText` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `currency_setting` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(5) NOT NULL DEFAULT 'INV',
  `FromCurrency` varchar(10) NOT NULL,
  `ToCurrency` varchar(10) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `ConversionRate` varchar(30) NOT NULL,	
  `IPAddress` varchar(30) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `currency_log` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Module` varchar(5) NOT NULL DEFAULT 'INV',
  `FromCurrency` varchar(10) NOT NULL,
  `ToCurrency` varchar(10) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `ConversionRate` varchar(30) NOT NULL,	
  `IPAddress` varchar(30) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `WorkingHourStart` varchar(6) NOT NULL,
  `WorkingHourEnd` varchar(6) NOT NULL,
  `shiftID` int(10) NOT NULL,
  `SL_Coming` varchar(8) NOT NULL,
  `SL_Leaving` varchar(8) NOT NULL,
  `FlexTime` tinyint(1) NOT NULL,
  `ipaddress` varchar(30) NOT NULL,
  PRIMARY KEY (`attID`),
  KEY `EmpID` (`EmpID`),
  KEY `attDate` (`attDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `h_att_punching` (
  `punchID` int(20) NOT NULL AUTO_INCREMENT,
  `attID` int(20) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `punchType` varchar(20) NOT NULL,
  `punchDate` date NOT NULL,
  `InTime` varchar(20) NOT NULL,
  `OutTime` varchar(20) NOT NULL,
  `InComment` varchar(250) NOT NULL,
  `OutComment` varchar(250) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  PRIMARY KEY (`punchID`),
  KEY `attID` (`attID`,`EmpID`,`punchDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `h_commission` (
  `comID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `SuppID` int(20) NOT NULL,
  `CommType` varchar(30) NOT NULL,
  `tierID` int(10) NOT NULL,
  `spiffID` int(10) NOT NULL,
  `SalesStructureType` tinyint(1) NOT NULL,
  `SalesPersonType` varchar(30) NOT NULL,
  `Accelerator` varchar(3) NOT NULL,
  `AcceleratorPer` varchar(6) NOT NULL,
  `TargetFrom` varchar(30) NOT NULL,
  `TargetTo` varchar(30) NOT NULL,
  `CommPercentage` varchar(6) NOT NULL,
  `SpiffTarget` varchar(30) NOT NULL,
  `SpiffEmp` varchar(30) NOT NULL,
  `SpiffType` varchar(20) NOT NULL DEFAULT 'one',
  `spiffBasedOn` varchar(30) NOT NULL,
  `CommOn` tinyint(1) NOT NULL,
  `CommissionType` varchar(20) NOT NULL,
  `CommPaidOn` varchar(10) NOT NULL,
  `amountType` varchar(20) NOT NULL,
  `SpiffOn` tinyint(1) NOT NULL,
  PRIMARY KEY (`comID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `CountryName` varchar(40) NOT NULL,
  `StateName` varchar(40) NOT NULL,
  `CityName` varchar(40) NOT NULL,
  `OtherState` varchar(40) NOT NULL,
  `OtherCity` varchar(40) NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
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
  `OtherHead` tinyint(1) NOT NULL,
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
  `ProbationPeriod` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `EligibilityPeriod` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `LeaveAccrual` tinyint(1) NOT NULL,
  `Exempt` tinyint(1) NOT NULL,
  `ProbationUnit` varchar(5) COLLATE latin1_general_ci NOT NULL DEFAULT 'Days',
  `EligibilityUnit` varchar(5) COLLATE latin1_general_ci NOT NULL DEFAULT 'Days',
  `ProbationEvent` int(20) NOT NULL,
  `YearlyReview` tinyint(1) NOT NULL,
  `YearlyReviewPeriod` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Overtime` tinyint(1) NOT NULL,
  `Benefit` tinyint(1) NOT NULL,
  `ExistingEmployee` tinyint(1) NOT NULL DEFAULT '1',
  `phone_country_id` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `empSignature` text COLLATE latin1_general_ci NOT NULL,
  `PIN` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PinPunch` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`EmpID`),
  KEY `country_id` (`country_id`),
KEY `Department` (`Department`),
KEY `shiftID` (`shiftID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `h_news_doc` (
  `DocID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `EmpID` int(10) NOT NULL,
  `DocType` varchar(20) NOT NULL,
  `DocumentTitle` varchar(50) NOT NULL,
  `Document` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`DocID`),
  KEY `DocID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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




CREATE TABLE IF NOT EXISTS `h_reimbursement` (
	`ReimID` int(11) NOT NULL AUTO_INCREMENT,
	`EmpID` int(11) NOT NULL,
	`ExReason` varchar(30) NOT NULL,
	`SancAmount` varchar(30) NOT NULL,
	`IssueDate` date NOT NULL,
	`Approved` tinyint(1) NOT NULL,
	`ApplyDate` date NOT NULL,
	`CreatedDate` date NOT NULL,
	`UpdatedDate` date NOT NULL,
	`Status` varchar(15) NOT NULL,
	`Comment` varchar(255) NOT NULL,
	`ReturnDate` date NOT NULL,
	`Returned` tinyint(1) NOT NULL,
	`document` varchar(30) NOT NULL,
	`TotalAmount` decimal(20,2) DEFAULT '0.00',
	`Currency` varchar(30) NOT NULL,
	`AdminID` int(11) NOT NULL,
	`AdminType` varchar(15) NOT NULL,
	`IPAddress` varchar(30) NOT NULL,
	PRIMARY KEY (`ReimID`),
	KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `h_reimbursement_item` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Type` varchar(30) NOT NULL,
	`ReimID` int(11) NOT NULL,
	`FromZip` varchar(10) NOT NULL,
	`ToZip` varchar(10) NOT NULL,
	`MileageRate` decimal(20,2) NOT NULL,
	`TotalMiles` decimal(20,2) NOT NULL,
	`Reference` varchar(30) NOT NULL,
	`ReimComment` varchar(30) NOT NULL,
	`TotalRate` decimal(20,2) NOT NULL,
	 PRIMARY KEY (`id`),
	 KEY `ReimID` (`ReimID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
 

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


CREATE TABLE IF NOT EXISTS `h_bank` (
  `BankID` int(11) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `BankName` varchar(40) NOT NULL,
  `AccountName` varchar(40) NOT NULL,
  `AccountNumber` varchar(40) NOT NULL,
  `IFSCCode` varchar(40) NOT NULL,
  `DefaultAccount` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`BankID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `h_deduction` (
  `dedID` int(10) NOT NULL AUTO_INCREMENT,
  `Type` tinyint(1) NOT NULL,
  `Heading` varchar(50) NOT NULL,
  `AccountID` varchar(15) NOT NULL,
  `Mandatory` tinyint(1) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`dedID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `h_taxdeduction` (
  `dedID` int(10) NOT NULL AUTO_INCREMENT,
  `Heading` varchar(50) NOT NULL,
  `SocialSecurity` varchar(30) NOT NULL,
  `Medicare` varchar(30) NOT NULL,
  `FUTA` varchar(30) NOT NULL,
  `SUTA` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` varchar(30) NOT NULL,
  `CountryName` varchar(40) NOT NULL,
  `StateName` varchar(30) NOT NULL,
  `TaxRate` varchar(30) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`dedID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `h_deduction_rule` (
  `ruleID` int(10) NOT NULL AUTO_INCREMENT,
  `Heading` varchar(50) NOT NULL,
  `Year` int(4) NOT NULL,
  `filingID` int(10) NOT NULL,
  `dedID` int(10) NOT NULL,
  `bracketID` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ruleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `h_filing` (
  `filingID` int(3) NOT NULL AUTO_INCREMENT,
  `filingStatus` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`filingID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


INSERT INTO `h_filing` (`filingID`, `filingStatus`, `Status`) VALUES
(1, 'Single', 1),
(2, 'Married/Joint & Widow(er)', 1),
(3, 'Married/Separate', 1),
(4, 'Head of Household', 1),
(5, 'Qualifying widow(er) with dependent child', 0);



CREATE TABLE IF NOT EXISTS `h_tax_bracket` (
  `bracketID` int(10) NOT NULL AUTO_INCREMENT,
  `Year` int(4) NOT NULL,
  `periodID` int(4) NOT NULL,
  `FilingStatus` varchar(10) NOT NULL,
  PRIMARY KEY (`bracketID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `h_tax_bracket_line` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `bracketID` int(10) NOT NULL,
  `FromAmount` varchar(15) NOT NULL,
  `ToAmount` varchar(15) NOT NULL,
  `TaxAmount` decimal(10,2) NOT NULL,
  `TaxPercentage` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bracketID` (`bracketID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `h_pay_period` (
  `periodID` int(3) NOT NULL AUTO_INCREMENT,
  `periodName` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`periodID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

INSERT INTO `h_pay_period` (`periodID`, `periodName`, `Status`) VALUES
(1, 'Weekly', 1),
(2, 'Biweekly', 1),
(3, 'Semimonthly', 1),
(4, 'Monthly', 1),
(5, 'Quaterly', 1),
(6, 'Semiannual', 1),
(7, 'Annual', 1);



CREATE TABLE IF NOT EXISTS `h_role_group` (
  `GroupID` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `AddedDate` datetime NOT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `permission_group` (
  `GroupID` int(20) NOT NULL AUTO_INCREMENT,
  `ModuleID` int(10) NOT NULL,
  `ViewLabel` tinyint(1) NOT NULL,
  `ViewAllLabel` tinyint(1) NOT NULL,
  `ModifyLabel` tinyint(1) NOT NULL,
  `FullLabel` tinyint(1) NOT NULL,
  `AddLabel` tinyint(1) NOT NULL,
  `EditLabel` tinyint(1) NOT NULL,
  `DeleteLabel` tinyint(1) NOT NULL,
  `AssignLabel` tinyint(1) NOT NULL,
  `ApproveLabel` tinyint(1) NOT NULL,
  UNIQUE KEY `ModuleID` (`GroupID`,`ModuleID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


-- --------------------------------------------------------

--
-- Table structure for table `h_holiday`
--

CREATE TABLE IF NOT EXISTS `h_holiday` (
  `holidayID` int(10) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `heading` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `holidayDate` date NOT NULL,
  `holidayDateTo` date NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `Recurring` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`holidayID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `LeaveID` int(20) NOT NULL AUTO_INCREMENT,
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
  `LastBalance` varchar(10) NOT NULL,
  PRIMARY KEY (`LeaveID`),
  KEY `EmpID` (`EmpID`),
  KEY `LeaveType` (`LeaveType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `h_leave_approval` (
  `appID` int(20) NOT NULL AUTO_INCREMENT,
  `LeaveID` int(20) NOT NULL,
  `EmpID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  PRIMARY KEY (`appID`),
  KEY `appID` (`LeaveID`,`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `h_leave_rule` (
  `RuleID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `Heading` varchar(50) NOT NULL,
  `Detail` text NOT NULL,
  `JobType` varchar(50) NOT NULL,
  `RuleOn` text NOT NULL,
  `RuleOpp` text NOT NULL,
  `RuleValue` text NOT NULL,
  `RuleUnit` text NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Date` date NOT NULL,
  `LeaveAllowed` text NOT NULL,
  PRIMARY KEY (`RuleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `h_leaverule_deny` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RuleID` int(11) NOT NULL,
  `EmpID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `h_employee_log_history` (
  `logID` int(20) NOT NULL AUTO_INCREMENT,
  `empID` int(20) NOT NULL,
  `updated` datetime NOT NULL,
  `tab` varchar(40) NOT NULL,
  `ColName` text NOT NULL,
  `ColOldValue` text NOT NULL,
  `ColNewValue` text NOT NULL,
  PRIMARY KEY (`logID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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


CREATE TABLE IF NOT EXISTS `h_news_doc` (
  `DocID` int(11) NOT NULL AUTO_INCREMENT,
  `newsID` int(10) NOT NULL,
  `DocType` varchar(20) NOT NULL,
  `DocumentTitle` varchar(50) NOT NULL,
  `Document` varchar(60) NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`DocID`),
  KEY `newsID` (`newsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `h_benefit` (
  `Bid` int(11) NOT NULL AUTO_INCREMENT,
  `Heading` varchar(100) NOT NULL,
  `Detail` text NOT NULL,
  `Document` varchar(100) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Date` date NOT NULL,
  `ApplyAll` tinyint(1) NOT NULL,
  PRIMARY KEY (`Bid`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `SubTotalE` varchar(30) NOT NULL,
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

CREATE TABLE IF NOT EXISTS `h_report_rule` (
  `reportID` int(15) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `ReportRule` text NOT NULL,
  `reportAllColumn` text NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `DurationCheck` varchar(4) NOT NULL DEFAULT 'No',
  `BreakCheck` varchar(4) NOT NULL DEFAULT 'NO',
  `PunchCheck` varchar(4) NOT NULL DEFAULT 'NO',
  `DurationFormat` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reportID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `PayRate` char(1) NOT NULL,
  `HourRate` decimal(10,2) NOT NULL,
  `PayCycle` varchar(20) NOT NULL,
  `PayCycleRate` decimal(10,2) NOT NULL,
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
  `FlexTime` tinyint(1) NOT NULL,
  `LunchPunch` tinyint(1) NOT NULL,
  `LunchTime` varchar(6) NOT NULL,
  `ShortBreakPunch` tinyint(1) NOT NULL,
  `ShortBreakLimit` tinyint(1) NOT NULL,
  `ShortBreakTime` varchar(50) NOT NULL,
  `LunchPaid` tinyint(1) NOT NULL,
  `ShortBreakPaid` tinyint(1) NOT NULL,
  `WeekStart` varchar(15) NOT NULL,
  `WeekEnd` varchar(15) NOT NULL,
  `WeekendCount` tinyint(1) NOT NULL,
  `OvertimePeriod` char(1) NOT NULL DEFAULT 'D',
  `OvertimeHourWeek` varchar(10) NOT NULL,
  `PayrollStart` varchar(10) NOT NULL,
  `PayCycle` varchar(15) NOT NULL,
  `EarlyPunchRestrict` tinyint(1) NOT NULL,
  `EarlyBreakRestrict` tinyint(1) NOT NULL,
  `EarlyLunchRestrict` tinyint(1) NOT NULL,
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



-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `h_leave_check` (
  `checkID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `Heading` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `Value` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`checkID`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `amountType` varchar(20) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `h_users_signature` ( 
`id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` int(11) NOT NULL, 
`Title` varchar(100) NOT NULL,
 `Content` text NOT NULL,
 `AdminType` varchar(50) NOT NULL,
 `setDefautTem` tinyint(1) NOT NULL DEFAULT '0', 
`ModuleId` int(11) NOT NULL, 
`ModuleName` varchar(30) NOT NULL, 
`Module` varchar(30) NOT NULL,
 PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_adjustment`
--

CREATE TABLE IF NOT EXISTS `inv_adjustment` (
  `adjID` int(20) NOT NULL AUTO_INCREMENT,
  `adjustNo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `WID` int(20) NOT NULL,
  `binloc` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_writedown` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemID` int(11) NOT NULL,
  `Sku` varchar(30) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Inv_Writedown` varchar(30) NOT NULL,
  `Total_Items` int(20) NOT NULL,
  `Total_Qty` int(20) NOT NULL,
  `Total_Cost` decimal(10,2) NOT NULL,
  `avg_Cost` decimal(10,2) NOT NULL,
  `Market_cost` decimal(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Condition` varchar(50) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


--
-- Table structure for table `inv_assembly`
--

CREATE TABLE IF NOT EXISTS `inv_assembly` (
  `asmID` int(20) NOT NULL AUTO_INCREMENT,
  `asm_code` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `bomID` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `binlocation` int(20) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `bomCondition` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `Comment` text NOT NULL,
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
  `serial_Price` text NOT NULL,
  `serial_desc` text NOT NULL,
  PRIMARY KEY (`asmID`),
  KEY `Sku` (`Sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `description` text,
  `bill_option` varchar(5) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `bomCondition` varchar(100) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `on_hand_qty` varchar(200) NOT NULL,
  `bomDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `AsmCount` int(11) NOT NULL,
  `DsmCount` int(11) NOT NULL,
  PRIMARY KEY (`bomID`),
  KEY `Sku` (`Sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `inv_item_alias` (
`AliasID` int(20) NOT NULL AUTO_INCREMENT,
`ItemAliasCode` varchar(100) NOT NULL,
`sku` varchar(30) NOT NULL,
`VendorCode` varchar(30) NOT NULL,
`item_id` int(20) NOT NULL,
`description` varchar(255) NOT NULL,
`AliasType` varchar(30) NOT NULL,
`Manufacture` varchar(50) NOT NULL,
PRIMARY KEY (`AliasID`),
KEY `sku` (`sku`),
KEY `ItemID` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_item_required` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ItemID` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `qty` int(20) NOT NULL,
  `Type` varchar(10) NOT NULL,
  `aliasID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ItemID` (`ItemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_item_transaction` (
 `TransactionID` int(11) NOT NULL AUTO_INCREMENT,
 `TransactionOrderID` int(11) NOT NULL,
 `TransactionInvoiceID` varchar(30) NOT NULL,
 `TransactionDate` date NOT NULL,
 `TransactionType` varchar(30) NOT NULL,
 `TransactionSku` varchar(30) NOT NULL,
 `TransactionItemID` int(11) NOT NULL,
 `TransactionDescription` text NOT NULL,
 `TransactionUnitPrice` decimal(10,2) NOT NULL,
 `TransactionCurrency` varchar(30) NOT NULL,
 `TransactionQty` int(10) NOT NULL,
  `TotalAmount` varchar(50) NOT NULL,
  `TranCondition` varchar(100) NOT NULL,
  `ConvertAmt` float(10,2) NOT NULL,
  `freight_cost` float(10,2) NOT NULL,
  `WID` int(10) NOT NULL DEFAULT '1',
  `binid` int(11) NOT NULL DEFAULT '0',
  `valuationType` varchar(50) NOT NULL,
 PRIMARY KEY (`TransactionID`),
  KEY `TransactionSku` (`TransactionSku`),
  KEY `TransactionType` (`TransactionType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `inv_item_attributes` (
  `paid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_type` enum('select','radio','text','textarea') NOT NULL DEFAULT 'select',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `gaid` int(10) unsigned NOT NULL DEFAULT '0',
  `is_modifier` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `track_inventory` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `caption` varchar(50) NOT NULL DEFAULT '',
  `text_length` int(10) unsigned NOT NULL DEFAULT '0',
  `options` text,
  `required2` varchar(5) NOT NULL DEFAULT '0',
  `required` varchar(5) NOT NULL,
   PRIMARY KEY (`paid`),
   KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `inv_item_quanity_condition` ( 
	`ID` int(11) NOT NULL AUTO_INCREMENT, 
	`ItemID` int(11) NOT NULL, 
	`WID` int(11) NOT NULL DEFAULT '1', 
	`binid` int(11) NOT NULL DEFAULT '0', 
	`condition` varchar(100) NOT NULL, 
	`Sku` varchar(30) NOT NULL,
	`type` varchar(50) NOT NULL, 
	`condition_qty` int(11) NOT NULL, 
	`AvgCost` FLOAT(10,2) NOT NULL, 
	`SalePrice` FLOAT(10,2) NOT NULL, 
	`LastPrice` FLOAT(10,2) NOT NULL, 
	`SaleQty` int(11) NOT NULL, 
	`AvlQty` int(11) NOT NULL, 
	`pricetype` varchar(11) NOT NULL, 
	`fprice` FLOAT(10,2) NOT NULL, 
	`prpercent` varchar(100) NOT NULL, 
	`qtyfrom` varchar(100) NOT NULL, 
	`qtyto` varchar(100) NOT NULL, 
	PRIMARY KEY (`ID`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_catalog_attributes` (
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Gaid` int(10) unsigned NOT NULL DEFAULT '0',
 	KEY `cid` (`Cid`),
 	KEY `gaid` (`Gaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `inv_item_modelGen` (
`ID` int(20) NOT NULL AUTO_INCREMENT,
`item_id` int(20) NOT NULL,
`genration` varchar(200) NOT NULL,
`model` int(20) NOT NULL,
PRIMARY KEY (`ID`),
KEY `ItemID` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_global_optionList` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `paid` int(11) NOT NULL,
  `Gaid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PriceType` varchar(30) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `SortOrder` int(11) NOT NULL,
   PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Global attributes option ';



CREATE TABLE IF NOT EXISTS `inv_global_attributes` (
  `Gaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AttributeType` enum('select','radio','text','textarea') NOT NULL DEFAULT 'select',
  `IsGlobal` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Caption` varchar(50) NOT NULL DEFAULT '',
  `TextLength` int(10) unsigned NOT NULL DEFAULT '0',
  `Options` text,
  `required` varchar(5) NOT NULL,
  PRIMARY KEY (`Gaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
  `e_categoryId` int(10) NOT NULL,
  `code` varchar(5) NOT NULL,
  `valuationType` varchar(50) NOT NULL,
  `Spiff` tinyint(1) NOT NULL DEFAULT '0',
  `spiffType` varchar(2) NOT NULL,
  `spiffAmt` float(10,2) NOT NULL,
`OverrideItem` tinyint(1) NOT NULL DEFAULT '0',
  `ItemIDs` text NOT NULL,
  `OverspiffAmt` float(10,2) NOT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `categoryID` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `Condition` text NOT NULL,
  `Extended` varchar(50) NOT NULL,
  `Manufacture` varchar(50) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
  `itemType` varchar(50) NOT NULL,
  `non_inventory` varchar(5) NOT NULL,
  `UnitMeasure` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `evaluationType` varchar(100) NOT NULL,
  `ReorderLevel` varchar(50) NOT NULL,
  `Reorderlabelbox` varchar(50) NOT NULL,
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
  `wt_Unit` varchar(10) NOT NULL,
  `wd_Unit` varchar(10) NOT NULL,
  `ht_Unit` varchar(10) NOT NULL,
  `ln_Unit` varchar(10) NOT NULL,
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
  `showcomponent` TINYINT(1) NOT NULL,
  `variant_id` varchar(100) NOT NULL,
  `is_upld` tinyint(1) NOT NULL DEFAULT '0',
  `label_txt` varchar(100) NOT NULL,
  `is_exclusive` enum('Yes','No') NOT NULL DEFAULT 'No',
  `AttributesCount` int(11) NOT NULL,
  `product_source` enum('inventory','hostbill','amazon','ebay','pos') DEFAULT 'inventory' COMMENT 'resource',
  `ref_id` varchar(30) NOT NULL,
  `GenOrder` tinyint(1) NOT NULL,
  `Spiff` tinyint(1) NOT NULL DEFAULT '0',
  `spiffType` varchar(2) NOT NULL,
  `spiffAmt` float(10,2) NOT NULL,
  `OverrideItem` tinyint(1) NOT NULL DEFAULT '0',
  `OverspiffAmt` float(10,2) NOT NULL,
  PRIMARY KEY (`ItemID`),
  KEY `CategoryID` (`CategoryID`),
  KEY `Sku` (`Sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_customer_items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `inv_ModelGen` (
 `id` int(20) NOT NULL AUTO_INCREMENT,
 `Model` varchar(50) NOT NULL,
 `item_id` int(20) NOT NULL,
 `Sku` varchar(50) NOT NULL,
 `Generation` varchar(200) NOT NULL,
 `Status` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`id`),
 KEY `Sku` (`Sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_item_assembly` (
 `id` int(20) NOT NULL AUTO_INCREMENT,
 `asmID` int(20) NOT NULL,
 `bomID` int(20) NOT NULL,
 `bom_refID` int(20) NOT NULL,
 `sku` varchar(30) NOT NULL,
 `Condition` varchar(100) NOT NULL,
 `item_id` int(20) NOT NULL,
 `WID` int(20) NOT NULL,
 `binloc` int(20) NOT NULL,
 `description` varchar(255) NOT NULL,
 `valuationType` varchar(50) NOT NULL,
 `available_qty` int(20) NOT NULL,
 `qty` int(20) NOT NULL,
 `wastageQty` int(20) NOT NULL,
 `unit_cost` decimal(10,2) NOT NULL,
 `total_bom_cost` decimal(10,2) NOT NULL,
 `serial` text NOT NULL,
  `serialdesc` text NOT NULL,
 `req_item` text NOT NULL,
 `serialPrice` text NOT NULL,
 PRIMARY KEY (`id`),
 KEY `sku` (`sku`),
 KEY `ItemID` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_disassembly` (
  `DsmID` int(20) NOT NULL AUTO_INCREMENT,
  `DsmCode` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `WarehouseCode` varchar(50) NOT NULL,
  `bomID` int(20) NOT NULL,
  `item_id` int(20) NOT NULL,
  `binlocation` int(20) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `bomCondition` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `total_dis_cost` decimal(10,2) NOT NULL,
  `on_hand_qty` int(20) NOT NULL,
  `disassembly_qty` int(20) NOT NULL,
  `disassemblyDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_id` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `serial_Num` text NOT NULL,
  `serial_Price` text NOT NULL,
  `serial_desc` text NOT NULL,
  PRIMARY KEY (`DsmID`),
  KEY `Sku` (`Sku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `inv_item_disassembly` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `dsmID` int(20) NOT NULL,
  `bomID` int(20) NOT NULL,
  `bom_refID` int(20) NOT NULL,
  `WID` int(20) NOT NULL,
  `binloc` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `Condition` varchar(100) NOT NULL,
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
  `req_item` text NOT NULL,
  `serialdesc` text NOT NULL,
  `serialPrice` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sku` (`sku`),
  KEY `ItemID` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `inv_item_bom`
--

CREATE TABLE IF NOT EXISTS `inv_item_bom` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `bomID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
 `Condition` varchar(100) NOT NULL,
  `Primary` tinyint(1) NOT NULL DEFAULT '0',
  `bom_code` varchar(50) NOT NULL,
  `optionID` int(15) NOT NULL,
  `item_id` int(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `bom_qty` int(20) NOT NULL,
  `wastageQty` int(20) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `total_bom_cost` decimal(10,2) NOT NULL,
  `req_item` text NOT NULL,
  `orderby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sku` (`sku`),
  KEY `ItemID` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_serial_item`
--

CREATE TABLE IF NOT EXISTS `inv_serial_item` (
  `serialID` int(20) NOT NULL AUTO_INCREMENT,
  `warehouse` INT(11) NOT NULL DEFAULT '1',
  `binid` int(11) NOT NULL,
  `serialNumber` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` text NOT NULL,
  `adjustment_no` varchar(30) NOT NULL,
  `disassembly` int(15) NOT NULL,
  `assembleID` int(11) NOT NULL,
  `Sku` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `UsedSerial` tinyint(1) NOT NULL,
  `UsedMergeItem` tinyint(1) NOT NULL,
  `ReceiveOrderID` int(11) NOT NULL,
  `Condition` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `UnitCost` float(10,2) NOT NULL DEFAULT '0.00',
  `ReceiptDate` date NOT NULL,
  `LineID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `SelectType` varchar(50) NOT NULL,
  `CustRma` int(11) NOT NULL,
  `VendRma` int(11) NOT NULL,
  PRIMARY KEY (`serialID`),
  KEY `adjustment_no` (`adjustment_no`),
  KEY `serialNumber` (`serialNumber`),
  KEY `Sku` (`Sku`),
  KEY `warehouse` (`warehouse`),
  KEY `OrderID` (`OrderID`),
  KEY `ReceiveOrderID` (`ReceiveOrderID`),
  KEY `serialID` (`serialID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inv_stock_adjustment`
--

CREATE TABLE IF NOT EXISTS `inv_stock_adjustment` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `adjID` int(20) NOT NULL,
  `WID` int(20) NOT NULL,
  `binlocID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `Condition` varchar(100) NOT NULL,
  `adjustNo` varchar(50) NOT NULL,
  `item_id` int(20) NOT NULL,
  `on_hand_qty` int(20) NOT NULL,
  `qty` int(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valuationType` varchar(50) NOT NULL,
  `serial_value` text NOT NULL,
  `serialdesc` text NOT NULL,
 `serialPrice` text NOT NULL,
  `QtyType` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Sku` (`sku`),
  KEY `ItemID` (`item_id`),
  KEY `binId` (`binlocID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_stock_transfer`
--

CREATE TABLE IF NOT EXISTS `inv_stock_transfer` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `transferID` int(20) NOT NULL,
  `sku` varchar(30) NOT NULL,
  `Condition` varchar(100) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
 `QTID` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `StockID` (`Sku`),
 KEY `bin` (`bin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_tax_rates` (
  `RateId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClassId` varchar(80) NOT NULL DEFAULT '',
  `Coid` int(11) NOT NULL,
  `Stid` int(11) NOT NULL,
  `locationID` int(11) unsigned NOT NULL,
  `TaxRate` decimal(10,2) unsigned NOT NULL,
  `RateDescription` varchar(255) NOT NULL DEFAULT '',
  `FreightTax` varchar(5) NOT NULL DEFAULT 'No',
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
  `binlocFrom` int(20) NOT NULL,
  `binlocTo` int(20) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_condition` (
  `ConditionID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ConditionDescription` text NOT NULL,
  `Image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ParentID` int(100) NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  `NumSubcondition` int(11) NOT NULL DEFAULT '0',
  `NumProducts` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(10) NOT NULL,
  `AddedDate` date NOT NULL,
   PRIMARY KEY (`ConditionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `inv_setting` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `Link` varchar(50) NOT NULL,
  `Heading` varchar(30) NOT NULL,
  `Status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `inv_setting` (`id`, `Link`, `Heading`, `Status`) VALUES
(1, 'Alias', 'Item Alias', 0),
(3, 'alterimages', 'Alternative Images', 1),
(5, 'binlocation', 'Warehouse/Bin', 0),
(6, 'Price', 'Item Price', 1),
(7, 'Quantity', 'Quantity', 1),
(8, 'Supplier', 'Vendor', 1),
(9, 'Dimensions', 'Dimensions', 1),
(10, 'Transaction', 'Transaction', 0),
(11, 'Required', 'Required Items', 0),
(12, 'Model', 'Model / Generation', 0),
(13, 'Variant', 'Variant', 1);


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
  `FlexTime` tinyint(1) NOT NULL,
  `ProbationTime` tinyint(1) NOT NULL,
  `LeaveApprovalCheck` tinyint(1) NOT NULL,
  `LunchPunch` tinyint(1) NOT NULL,
  `LunchTime` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `ShortBreakPunch` tinyint(1) NOT NULL,
  `ShortBreakLimit` tinyint(1) NOT NULL,
  `ShortBreakTime` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `UseShift` tinyint(1) NOT NULL,
  `LunchPaid` tinyint(1) NOT NULL,
  `ShortBreakPaid` tinyint(1) NOT NULL,
  `WeekendCount` tinyint(1) NOT NULL,
  `LeavePeriod` tinyint(1) NOT NULL,
  `PayrollStart` varchar(10) NOT NULL,
  `PayCycle` varchar(15) NOT NULL,
  `PayMethod` enum('H','M') COLLATE latin1_general_ci NOT NULL DEFAULT 'H',
  `ReimRate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ReimMileageGL` int(11) NOT NULL,
  `ReimMissGL` int(11) NOT NULL,
  `VAT` varchar(30) NOT NULL,
  `EIN` varchar(30) NOT NULL,
  `CST` varchar(30) NOT NULL,
  `TRN` varchar(30) NOT NULL,
  `EarlyPunchRestrict` tinyint(1) NOT NULL,
  `EarlyBreakRestrict` tinyint(1) NOT NULL,
  `EarlyLunchRestrict` tinyint(1) NOT NULL,
  PRIMARY KEY (`locationID`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
  `ViewAllLabel` tinyint(1) NOT NULL,
  `ModifyLabel` tinyint(1) NOT NULL,
  `FullLabel` tinyint(1) NOT NULL,
  `AddLabel` tinyint(1) NOT NULL,
  `EditLabel` tinyint(1) NOT NULL,
  `DeleteLabel` tinyint(1) NOT NULL,
  `AssignLabel` tinyint(1) NOT NULL,
  `ApproveLabel` tinyint(1) NOT NULL,
  UNIQUE KEY `EmpID` (`UserID`,`ModuleID`),
  KEY `AdminID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE IF NOT EXISTS `permission_vendor` (
  `Id` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `SuppCode` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
 KEY `EmpID` (`EmpID`),
 KEY `SuppCode` (`SuppCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
  `ref_id` int(11) DEFAULT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `PaymentInfo` tinyint(1) NOT NULL,
  `PoDelivery` tinyint(1) NOT NULL,
  `CreditDelivery` tinyint(1) NOT NULL,
  `ReturnDelivery` tinyint(1) NOT NULL,
   `InvoiceDelivery` tinyint(1) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `p_order`
--


CREATE TABLE IF NOT EXISTS `p_order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `Module` varchar(20) NOT NULL,
  `AutoID` bigint(40) NOT NULL,
  `Parent` int(11) NOT NULL,
  `ConversionRate` varchar(20) NOT NULL,
  `OrderDate` date NOT NULL DEFAULT '0000-00-00',
  `OrderType` varchar(30) NOT NULL,
  `PurchaseID` varchar(30) NOT NULL,
  `QuoteID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `ReturnID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `SaleID` varchar(30) NOT NULL,
  `ReceiptID` varchar(30) NOT NULL,
  `GenrateInvoice` tinyint(1) NOT NULL,
  `ReceiptEntry` tinyint(1) NOT NULL,
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
  `TotalInvoiceAmount` decimal(20,2) NOT NULL,
  `AdjustmentAmount` decimal(20,2) NOT NULL,
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
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
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
  `ReceiptStatus` varchar(20) NOT NULL,
  `PostToGL` tinyint(1) NOT NULL DEFAULT '0',
  `PostToGLDate` date NOT NULL,
  `PostToGLTime` varchar(20) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `PrepaidFreight` tinyint(1) NOT NULL,
  `PrepaidVendor` varchar(20) NOT NULL,
  `PrepaidAmount` decimal(10,2) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `Restocking_fee` decimal(10,2) NOT NULL,
  `Restocking` varchar(5) NOT NULL,
  `RefInvoiceID` varchar(50) NOT NULL,
  `ShippingMethodVal` varchar(100) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `MailSend` tinyint(1) NOT NULL DEFAULT '0',
  `VendorInvoiceDate` date NOT NULL,
  `freightTxSet` varchar(5) DEFAULT NULL,
  `UploadDocuments` varchar(50) NOT NULL,
  `TrackingNo` varchar(250) NOT NULL,
  `close_status` tinyint(1) NOT NULL DEFAULT '0',
  `CreditCardVendor` varchar(30) NOT NULL,
  `OrderPaid` tinyint(1) NOT NULL DEFAULT '0',
  `OverPaid` tinyint(1) NOT NULL DEFAULT '0',
  `RecurringAmount` decimal(20,2) DEFAULT '0.00',
  `RowColor` varchar(50) NOT NULL,
  `ArInvoiceID` varchar(50) NOT NULL,
  `PdfFile` varchar(200) NOT NULL,
  `EDICompId` int(11) NOT NULL,
  `EDICompName` varchar(40) NOT NULL,
  `EDIRefNo` text NOT NULL,
  `EdiRefInvoiceID` varchar(100) NOT NULL,
  `EdiSoID` int(11) NOT NULL,
  `ShippingAccountVendor` tinyint(1) NOT NULL DEFAULT '0',
  `ShippingAccountNumber` varchar(50) NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `post_date` (`OrderDate`),
  KEY `PurchaseID` (`PurchaseID`),
  KEY `Module` (`Module`),
  KEY `SuppCode` (`SuppCode`),
  KEY `InvoiceID` (`InvoiceID`),
  KEY `CreditID` (`CreditID`),
  KEY `ReceiptID` (`ReceiptID`),
  KEY `RefInvoiceID` (`RefInvoiceID`),
  KEY `ExpenseID` (`ExpenseID`),
  KEY `EdiSoID` (`EdiSoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `p_order_item`
--

CREATE TABLE IF NOT EXISTS `p_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(10) NOT NULL,
  `WID` int(11) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(30) NOT NULL,
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_returned` int(10) NOT NULL,
	`SaleQty` int(10) NOT NULL,
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
  `SerialNumbers` longtext NOT NULL,
  `Condition` varchar(50) NOT NULL,
  `DesComment` varchar(250) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `Reason` varchar(50) NOT NULL,
  `freight_cost` varchar(20) NOT NULL,
  `binid` int(11) NOT NULL,
  `bin` varchar(100) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `Org_Qty` int(11) NOT NULL,
  `req_item` text NOT NULL,
  `parent_item_id` int(11) NOT NULL,
  `parent_line_id` int(11) NOT NULL,
  `child_line_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`),
  KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `p_supplier`
--

CREATE TABLE IF NOT EXISTS `p_supplier` (
  `SuppID` int(20) NOT NULL AUTO_INCREMENT,
  `SuppCode` varchar(30) NOT NULL,
  `SuppType` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT 'Business',
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
  `SSN` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `AccountID` int(11) NOT NULL,
  `TenNine` tinyint(1) NOT NULL,
 `CreditCard` tinyint(1) NOT NULL,
 `HoldPayment` tinyint(1) NOT NULL,
  `EIN` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `Taxable` varchar(3) NOT NULL,
  `TaxRate` varchar(100) NOT NULL,
  `CreditLimit` varchar(30) NOT NULL,
  `primaryVendor` int(12) NOT NULL,
  `PID` tinyint(1) NOT NULL,
  `AdminID` varchar(10) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreditAmount` decimal(20,2) NOT NULL,
  `VAT` varchar(50) NOT NULL,
  `EIN` varchar(50) NOT NULL,
  `CST` varchar(50) NOT NULL,
  `TRN` varchar(50) NOT NULL,
  `RowColor` varchar(50) NOT NULL,
  `EDICompId` int(11) NOT NULL,
  `EDICompName` varchar(40) NOT NULL,
  `defaultVendor` tinyint(1) NOT NULL,
  PRIMARY KEY (`SuppID`),
  KEY `country_id` (`country_id`),
  KEY `SuppCode` (`SuppCode`),
  UNIQUE KEY `SuppCodeUniq` (`SuppCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `p_supplier_bank` (
  `BankID` int(11) NOT NULL AUTO_INCREMENT,
  `SuppID` int(11) NOT NULL,
  `BankName` varchar(40) NOT NULL,
  `AccountName` varchar(50) NOT NULL,
  `AccountNumber` varchar(40) NOT NULL,
  `RoutingNumber` varchar(40) NOT NULL,
  `SwiftCode` varchar(40) NOT NULL,
  `DefaultAccount` tinyint(1) NOT NULL,
  `UpdatedDate` date NOT NULL,
  PRIMARY KEY (`BankID`),
  KEY `SuppID` (`SuppID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
  `FullName` varchar(80) NOT NULL,
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
  `RigisterType` enum('crm','facebook','twitter','google','linkedin') NOT NULL DEFAULT 'crm',
  `RigisterTypeID` varchar(100) NOT NULL,
  `FacebookID` varchar(100) NOT NULL,
  `TwitterID` varchar(100) NOT NULL,
  `LinkedinID` varchar(100) NOT NULL,
  `GoogleID` varchar(100) NOT NULL,
  `InstagramID` varchar(100) NOT NULL,
  `FacebookInfo` text NOT NULL,
  `TwitterInfo` text NOT NULL,
  `LinkedinInfo` text NOT NULL,
  `ref_id` int(11) NOT NULL,
  `NickName` varchar(80) NOT NULL,
  `RowColor` varchar(10) NOT NULL,
  `PaymentInfo` tinyint(1) NOT NULL,
  `SoDelivery` tinyint(1) NOT NULL,
  `CreditDelivery` tinyint(1) NOT NULL,
  `ReturnDelivery` tinyint(1) NOT NULL,
  `InvoiceDelivery` tinyint(1) NOT NULL,
  `Statement` tinyint(1) NOT NULL,
  `contact` varchar(100) NOT NULL,
  PRIMARY KEY (`AddID`),
  KEY `CustID` (`CustID`),
  KEY `AddType` (`AddType`),
  KEY `PrimaryContact` (`PrimaryContact`)
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
CREATE TABLE IF NOT EXISTS `s_comments` ( 
	`CommentID` int(11) NOT NULL AUTO_INCREMENT, 
	`order_id` varchar(20) NOT NULL COMMENT 'SO/PO number',
	`user_id` int(15) NOT NULL, 
	`master_comment_id` int(11) NOT NULL,
	`view_type` enum('public','private') NOT NULL,
	`comment_date` datetime NOT NULL,
	PRIMARY KEY (`CommentID`), 
	KEY `order_id` (`order_id`), 
	KEY `user_id` (`user_id`),
	KEY `comment_date` (`comment_date`),
	KEY `view_type` (`view_type`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `s_master_comments` (
  `MasterCommentID` int(11) NOT NULL AUTO_INCREMENT,
  `module_type` enum('sales','purchases','both') NOT NULL,
  `commented_by` varchar(12) NOT NULL,
  `user_id` int(15) NOT NULL,
  `comment` varchar(300) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `comment_date` datetime NOT NULL,
  `view_type` enum('public','private') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` enum('premade','custom') NOT NULL DEFAULT 'custom',
   PRIMARY KEY (`MasterCommentID`),
   KEY `commented_id` (`user_id`),
   KEY `commented_by` (`commented_by`),
   KEY `Status` (`status`),
   KEY `display type` (`view_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `s_customers`
--

CREATE TABLE IF NOT EXISTS `s_customers` (
  `Cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL,
  `CustCode` varchar(40) NOT NULL,
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
  `Department` int(11) NOT NULL,
  `SalesID` varchar(100) NOT NULL,
  `RigisterType` enum( 'crm',  'facebook',  'twitter',  'google',  'linkedin', 'hostbill') NOT NULL DEFAULT 'crm',
  `RigisterTypeID` varchar(255) NOT NULL,
  `FacebookID` varchar(100) NOT NULL,
  `TwitterID` varchar(100) NOT NULL,
  `LinkedinID` varchar(100) NOT NULL,
  `GoogleID` varchar(100) NOT NULL,
  `InstagramID` varchar(100) NOT NULL,
  `FacebookInfo` text NOT NULL,
  `TwitterInfo` text NOT NULL,
  `LinkedinInfo` text NOT NULL,
  `MDType` varchar(15) NOT NULL,
  `DiscountType` varchar(15) NOT NULL,
  `MDAmount` varchar(30) NOT NULL,
  `MDiscount` varchar(10) NOT NULL,
  `RowColor` varchar(10) NOT NULL,
  `CreditLimit` varchar(100) NOT NULL,
  `tel_ext` int(11) NOT NULL,
  `VAT` varchar(50) NOT NULL,
  `CST` varchar(50) NOT NULL,
  `PAN` varchar(50) NOT NULL,
  `TRN` varchar(50) NOT NULL,
  `DefaultAccount` varchar(10) NOT NULL,
  `Statement` varchar(50) NOT NULL,
  `CreditAmount` decimal(20,2) NOT NULL,
  `customerHold` tinyint(1) NOT NULL,
  `SalesPerson` varchar(200) NOT NULL,
  `SalesPersonType` int(10) NOT NULL,
  `EDICompId` int(11) NOT NULL,
  `EDICompName` varchar(40) NOT NULL,
  `VendorSalesPerson` varchar(250) NOT NULL,
  `DefaultCustomer` tinyint(1) NOT NULL,
  PRIMARY KEY (`Cid`),
  KEY `CustCode` (`CustCode`),
  UNIQUE KEY `CustCodeUni` (`CustCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `s_order`
--

CREATE TABLE IF NOT EXISTS `s_order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderDate` date NOT NULL,
  `Module` varchar(20) NOT NULL,
  `ConversionRate` varchar(20) NOT NULL,
  `AutoID` bigint(40) NOT NULL,
  `Parent` int(11) NOT NULL,
  `SaleID` varchar(255) NOT NULL,
  `QuoteID` varchar(30) NOT NULL,
  `InvoiceID` varchar(30) NOT NULL,
  `ReturnID` varchar(30) NOT NULL,
  `CreditID` varchar(30) NOT NULL,
  `ShippedID` varchar(30) NOT NULL,
  `CustCode` varchar(40) NOT NULL,
  `CustID` int(11) unsigned NOT NULL,
  `SalesPersonID` varchar(255) NOT NULL,
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
  `ShipFreight` decimal(20,2) DEFAULT '0.00',
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
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `PaymentDate` date NOT NULL,
  `InvPaymentMethod` varchar(30) NOT NULL,
  `PaymentRef` varchar(30) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `InvoiceComment` varchar(250) NOT NULL,
  `InvoicePaid` enum('Unpaid','Paid','Part Paid') NOT NULL DEFAULT 'Unpaid',
  `ReturnDate` date NOT NULL,
  `ShipDate` date NOT NULL,
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
  `CustDisType` varchar(20) NOT NULL,
  `CustDisAmt` varchar(20) NOT NULL,
  `MDType` varchar(20) NOT NULL,
  `RsID` int(11) NOT NULL,
  `ecom_order_id` int(11) NOT NULL,
  `MDAmount` varchar(30) NOT NULL,
  `MDiscount` varchar(10) NOT NULL,
  `PostToGL` tinyint(1) NOT NULL DEFAULT '0',
  `PostToGLDate` date NOT NULL,
  `PostToGLTime` varchar(20) NOT NULL,
  `AccountID` int(11) NOT NULL,
  `StatusMsg` varchar(500) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `ReStocking` decimal(10,2) NOT NULL,
  `ReSt` varchar(5) NOT NULL,
  `CustomerPO` varchar(50) NOT NULL,
  `TDiscount` decimal(20,2) NOT NULL,
  `TrackingNo` text NOT NULL,
  `ShipAccount` varchar(200) NOT NULL,
  `OrderSource` varchar(100) NOT NULL,
  `ShippingMethodVal` varchar(100) NOT NULL,
  `Fee` decimal(10,2) DEFAULT '0.00',
  `IncomeID` int(20) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `paypalEmail` varchar(150) DEFAULT NULL,
  `paypalInvoiceId` varchar(150) DEFAULT NULL,
  `paypalInvoiceNumber` varchar(150) DEFAULT NULL,
  `batchId` int(11) NOT NULL,
  `MailSend` tinyint(1) NOT NULL DEFAULT '0',
  `freightTxSet` varchar(5) DEFAULT NULL,
  `OrderPaid` tinyint(1) NOT NULL DEFAULT '0',
  `RowColor` varchar(50) NOT NULL,
  `EntryBy` varchar(1) DEFAULT NULL,
  `VendorID` int(11) NOT NULL,
  `UploadDocuments` varchar(50) NOT NULL,
  `RecurringOption` varchar(20) NOT NULL,
  `RecurringDate` date NOT NULL,
  `BillingPeriod` varchar(30) NOT NULL,
  `BillingFrequency` varchar(30) NOT NULL,
  `NextBillingFrequency` int(10) NOT NULL,
  `LastEntry` date NOT NULL,
  `FileName` text NOT NULL,
  `OverPaid` tinyint(1) NOT NULL DEFAULT '0',
  `BalanceAmount` decimal(10,2) DEFAULT '0.00',
  `CardCharge` tinyint(1) NOT NULL,
  `PickID` varchar(100) NOT NULL,
  `PickDate` date NOT NULL,
  `PickStatus` varchar(50) NOT NULL,
  `ShipAccountNumber` varchar(50) NOT NULL,
  `ActualFreight` varchar(30) NOT NULL,
  `reference_id` varchar(30) NOT NULL,
  `NoUse` tinyint(1) NOT NULL,
  `SalesPersonType` tinyint(1) NOT NULL,
  `CountryId` int(11) NOT NULL,
  `StateID` int(11) NOT NULL,
  `CityID` int(11) NOT NULL,
  `ShippingCountryID` int(11) NOT NULL,
  `ShippingStateID` int(11) NOT NULL,
  `ShippingCityID` int(11) NOT NULL,
  `PdfFile` varchar(200) NOT NULL,
  `EDICompId` int(11) NOT NULL,
  `EDICompName` varchar(40) NOT NULL,
  `EDIRefNo` text NOT NULL,
  `EdiRefInvoiceID` varchar(100) NOT NULL,
  `ShippingAccountCustomer` tinyint(1) NOT NULL,
  `ShippingAccountNumber` varchar(50) NOT NULL,
  `FreightDiscounted` tinyint(1) NOT NULL,
  `FreightDiscount` decimal(10,2) DEFAULT '0.00',
  `VendorSalesPerson` varchar(250) NOT NULL,
  `CanReqest` tinyint(1) NOT NULL,
  `EdiPoID` int(11) NOT NULL,
  `setSpiffamt` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`OrderID`),
  KEY `SaleID` (`SaleID`),
  KEY `Module` (`Module`),
  KEY `CustCode` (`CustCode`),
  KEY `SalesPersonID` (`SalesPersonID`),
  KEY `CustID` (`CustID`),
  KEY `InvoiceID` (`InvoiceID`),
  KEY `CreditID` (`CreditID`),
  KEY `IncomeID` (`IncomeID`),
  KEY `batchId` (`batchId`),  
  KEY `EdiPoID` (`EdiPoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `s_customers_paypalEmail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `isDefault` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `s_order_item`
--
 
CREATE TABLE IF NOT EXISTS `s_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL DEFAULT '0',
  `item_id` bigint(20) NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `reconciled` tinyint(1) NOT NULL DEFAULT '0',
  `sku` varchar(30) NOT NULL,
  `Org_Qty` int(11) NOT NULL DEFAULT '0',
  `on_hand_qty` int(10) NOT NULL DEFAULT '0',
  `WID` int(11) NOT NULL DEFAULT '1',
  `bin` varchar(50) NOT NULL,
  `qty` float NOT NULL DEFAULT '0',
  `qty_received` int(10) NOT NULL,
  `qty_invoiced` int(11) NOT NULL,
  `qty_returned` int(10) NOT NULL,
  `qty_picked` int(11) NOT NULL,
  `qty_shipped` int(11) NOT NULL,
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
  `DropshipUsed` tinyint(1) NOT NULL,
  `SerialNumbers` text NOT NULL,
  `Condition` varchar(50) NOT NULL,
  `CustDiscount` varchar(50) NOT NULL,
  `DesComment` varchar(250) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `Reason` varchar(50) NOT NULL,
  `UploadedFile` varchar(100) NOT NULL,
  `RecurringCheck` varchar(5) NOT NULL DEFAULT 'off',
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` varchar(5) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  `attributes` text NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `parent_item_id` int(11) NOT NULL,
  `avgCost` decimal(10,2) NOT NULL,
  `CardCharge` tinyint(1) NOT NULL,
  `CardChargeDate` varchar(5) NOT NULL,
  `RecurringAmount` decimal(20,2) NOT NULL,
  `parent_line_id` int(11) NOT NULL,
  `child_line_id` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `RecEdiSerial` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`),
  KEY `sku` (`sku`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `s_order_spiff` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `SuppCode` varchar(50) NOT NULL,
  `Amount` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS `s_cart_sales` (
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
  `OptionsAttribute` text COLLATE latin1_general_ci NOT NULL,
  `Weight` decimal(10,2) unsigned NOT NULL,
  `AddedDate` date NOT NULL,
  `Variant_ID` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Variant_val_Id` varchar(500) COLLATE latin1_general_ci NOT NULL,
  `AliasID` int(11) NOT NULL,
  `UploadedFile` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `DesComment` varchar(250) COLLATE latin1_general_ci NOT NULL,
 PRIMARY KEY (`CartID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE IF NOT EXISTS `s_customer_card` (
  `CardID` int(11) NOT NULL AUTO_INCREMENT,
  `CustID` int(11) NOT NULL,
  `CardNumber` varchar(30) NOT NULL,
  `CardType` varchar(30) NOT NULL,
  `CardHolderName` varchar(50) NOT NULL,
  `ExpiryMonth` varchar(2) NOT NULL,
  `ExpiryYear` varchar(4) NOT NULL,
  `DefaultCard` tinyint(1) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `UpdatedDate` date NOT NULL,
  `country_id` int(20) NOT NULL,
  `state_id` int(20) NOT NULL,
  `city_id` int(20) NOT NULL,
  `OtherState` varchar(50) NOT NULL,
  `OtherCity` varchar(50) NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
  `SecurityCode` varchar(10) NOT NULL,
  PRIMARY KEY (`CardID`),
  KEY `CustID` (`CustID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `s_customer_shipping` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CustID` int(11) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `api_password` varchar(200) NOT NULL,
  `api_account_number` varchar(200) NOT NULL,
  `api_meter_number` varchar(200) NOT NULL,
  `api_name` varchar(200) NOT NULL,
  `SourceZipcode` varchar(20) NOT NULL,
  `live` tinyint(1) NOT NULL,
  `defaultVal` tinyint(4) NOT NULL,
  `fixed` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CustID` (`CustID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `s_order_card` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `TransactionID` int(20) NOT NULL,
  `CardID` int(11) NOT NULL,
  `CardNumber` varchar(30) NOT NULL,
  `CardType` varchar(30) NOT NULL,
  `CardHolderName` varchar(50) NOT NULL,
  `ExpiryMonth` varchar(2) NOT NULL,
  `ExpiryYear` varchar(4) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `State` varchar(30) NOT NULL,
  `City` varchar(30) NOT NULL, 
  `ZipCode` varchar(20) NOT NULL,
  `SecurityCode` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `s_order_transaction` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `TransID` int(11) NOT NULL,
  `ProviderID` int(11) NOT NULL,
  `PaymentTerm` varchar(50) NOT NULL,
  `TransactionID` varchar(100) NOT NULL,
  `TransactionIDOther` varchar(100) NOT NULL,
  `TransactionType` varchar(30) NOT NULL,
  `TransactionDate` datetime NOT NULL,
  `CardNumber` varchar(30) NOT NULL,
  `CardType` varchar(30) NOT NULL,
  `CardHolderName` varchar(50) NOT NULL,
  `ExpiryMonth` varchar(2) NOT NULL,
  `ExpiryYear` varchar(4) NOT NULL,
  `TotalAmount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `RefundedAmount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Currency` varchar(10) NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `Recurring` tinyint(1) NOT NULL,
  `CreditOrderID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `s_rma_form` (
  `formID` int(11) NOT NULL AUTO_INCREMENT,
  `HtmlForm` text NOT NULL,
  `LeadColumn` text NOT NULL,
  `FormTitle` varchar(50) NOT NULL,
  `Subtitle` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `AssignTo` varchar(100) NOT NULL,
  `ExtraInfo` varchar(50) NOT NULL,
  `Campaign` varchar(50) NOT NULL,
  `ActionUrl` varchar(200) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
PRIMARY KEY (`formID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
  `UserSecurity` tinyint(1) NOT NULL,
  `AllowSecurityUser` varchar(10) NOT NULL,
  `AuthSecretKey` varchar(30) NOT NULL,
  `SecurityPriority` tinyint(1) NOT NULL,
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
  `LoginType` tinyint(1) NOT NULL,	
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
  `LastViewTime` datetime NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  `Browser` varchar(50) NOT NULL,
  `Kicked` tinyint(1) NOT NULL,
  `SessionID` varchar(50) NOT NULL,
  PRIMARY KEY (`loginID`),
  KEY `UserID` (`UserID`),
  KEY `UserType` (`UserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `user_login_page` (
  `pageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `loginID` bigint(20) NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `PageUrl` varchar(100) NOT NULL,
  `PageName` varchar(100) NOT NULL,
  `PageHeading` varchar(250) NOT NULL,
  `ViewTime` datetime NOT NULL,
  PRIMARY KEY (`pageID`),
  KEY `loginID` (`loginID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_secure` (
`ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `RefID` int(20) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `Question1` int(11) NOT NULL,
  `Answer1` varchar(50) NOT NULL,
  `Question2` int(11) NOT NULL,
  `Answer2` varchar(50) NOT NULL,
  `Question3` int(11) NOT NULL,
  `Answer3` varchar(50) NOT NULL,
  `Question4` int(11) NOT NULL,
  `Answer4` varchar(50) NOT NULL,
  `Question5` int(11) NOT NULL,
  `Answer5` varchar(50) NOT NULL,
   PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_addressbook` (
  `adbID` int(11) NOT NULL AUTO_INCREMENT,
  `Country` varchar(100) NOT NULL,
  `Company` varchar(150) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `ContactName` varchar(100) NOT NULL,
  `Address1` text NOT NULL,
  `Zip` varchar(20) NOT NULL,
  `Address2` text NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `PhoneNo` varchar(20) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `FaxNo` varchar(20) NOT NULL,
  `addType` varchar(25) NOT NULL,
  PRIMARY KEY (`adbID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_shipment_profile` (
  `profileID` int(11) NOT NULL AUTO_INCREMENT,
  `Nickname` varchar(150) NOT NULL,
  `Company` varchar(150) NOT NULL,
  `ContactName` varchar(150) NOT NULL,
  `ServiceType` varchar(200) NOT NULL,
  `Weight` int(10) NOT NULL,
  `wtUnit` varchar(15) NOT NULL,
  `PackagingType` varchar(100) NOT NULL,
  `PackageDiscriptions` text NOT NULL,
  PRIMARY KEY (`profileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `w_global_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FedExAccount` int(50) NOT NULL,
  `UPSAccount` int(50) NOT NULL,
  `DHLAccount` int(50) NOT NULL,
  `USPSAccount` int(50) NOT NULL,
  `SourceZipcode` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `w_global_setting` (`id`, `FedExAccount`, `UPSAccount`, `DHLAccount`, `USPSAccount`, `SourceZipcode`) VALUES
(1, 2147483647, 2147483647, 3453443, 5565, 94040);

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
  `FixedCol` tinyint(1) NOT NULL,
  `SuppCode` varchar(30) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_receipt` (
  `ReceiptID` int(11) NOT NULL AUTO_INCREMENT,
  `AutoID` bigint(40) NOT NULL,
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
  `Freight` decimal(20,2) NOT NULL DEFAULT '0.00',
  `taxAmnt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `CreatedBy` varchar(100) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `SalesPerson` varchar(250) NOT NULL,
  `SalesPersonID` int(11) NOT NULL DEFAULT '0',
  `InvoiceDate` varchar(250) NOT NULL,
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
  `tax_auths` varchar(16) NOT NULL,
  `TaxRate` varchar(100) NOT NULL,
  `ReturnDate` date NOT NULL,
  `ReturnComment` text NOT NULL,
  `CustomerCurrency` varchar(5) NOT NULL,
 `CustCode` varchar(20) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `ReStocking` decimal(10,2) NOT NULL,
  `ReSt` varchar(5) NOT NULL,
 `IPAddress` varchar(20) NOT NULL,
  `PdfFile` varchar(200) NOT NULL,
  PRIMARY KEY (`ReceiptID`),
  KEY `OrderID` (`OrderID`),
  KEY `Module` (`Module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `w_shipping_credential` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(200) NOT NULL,
  `api_password` varchar(200) NOT NULL,
  `api_account_number` varchar(200) NOT NULL,
  `api_meter_number` varchar(200) NOT NULL,
  `api_name` varchar(200) NOT NULL,  
  `SourceZipcode` varchar(20) NOT NULL,  
  `live` tinyint(1) NOT NULL,
  `fixed` tinyint(1) NOT NULL DEFAULT '1',
  `defaultVal` tinyint(1) NOT NULL DEFAULT '1',
  `SuppCode` varchar(30) NOT NULL,  
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `w_shipping_credential` (`id`, `api_key`, `api_password`, `api_account_number`, `api_meter_number`, `api_name`, `SourceZipcode`,`fixed`,`defaultVal`) VALUES
(1, '', '', '268412263', '', 'FedEx', '94040','1','1'),
(2, '', '', '2CF8EA8CA48FB215', '', 'UPS', '94040','1','1'),
(3, '', '', '214748', '', 'USPS', '94040','1','1'),
(4, '', '', '214748', '', 'DHL', '94040','1','1');


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
 `avgCost` decimal(10,2) NOT NULL,
 `Type` varchar(50) NOT NULL,
 `Action` varchar(50) NOT NULL,
 `Reason` varchar(50) NOT NULL,
 `Condition` varchar(50) NOT NULL,
 `WID` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `reconciled` (`reconciled`),
 KEY `OrderID` (`OrderID`),
 KEY `ReceiptID` (`ReceiptID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `w_shipment` (
 `ShipmentID` int(15) NOT NULL AUTO_INCREMENT,
 `ModuleType` varchar(40) NOT NULL,
 `deleted` tinyint(1) DEFAULT '0',
 `ShippedID` varchar(36) DEFAULT NULL,
 `RefID` varchar(50) NOT NULL,
 `OrderID` varchar(36) DEFAULT NULL,
 `ShipComment` varchar(255) NOT NULL,
 `ShipmentDate` date NOT NULL,
 `ShipmentMethod` varchar(100) NOT NULL,
 `ShipmentStatus` varchar(30) NOT NULL,
 `CreatedBy` varchar(50) NOT NULL,
 `AdminID` int(15) NOT NULL,
 `AdminType` varchar(10) NOT NULL,
 `ShipCreateDate` date NOT NULL,
 `WID` int(15) NOT NULL,
 `WarehouseName` varchar(100) NOT NULL,
 `WarehouseCode` varchar(50) NOT NULL,
 `transport` varchar(80) NOT NULL,
 `packageCount` varchar(80) NOT NULL,
 `PackageType` varchar(80) NOT NULL,
 `Weight` varchar(80) NOT NULL,
 `label` varchar(100) NOT NULL,
 `trackingId` text NOT NULL,
 `totalFreight` varchar(100) NOT NULL,
 `COD` varchar(20) NOT NULL,
 `sendingLabel` varchar(100) NOT NULL,
 `ShipType` varchar(100) NOT NULL,
 `createdDate` datetime NOT NULL,
 `GenrateShipInvoice` tinyint(1) DEFAULT '0',
 `IPAddress` varchar(30) NOT NULL,
 `InsureAmount` varchar(30) NOT NULL,
 `InsureValue` varchar(30) NOT NULL,
 `ZipFrom` int(11) NOT NULL,
  `CityFrom` varchar(40) NOT NULL,
  `StateFrom` varchar(40) NOT NULL,
  `CountryFrom` varchar(40) NOT NULL,
  `ZipTo` varchar(40) NOT NULL,
  `CityTo` varchar(40) NOT NULL,
  `StateTo` varchar(40) NOT NULL,
  `CountryTo` varchar(40) NOT NULL,
  `ShippingMethod` varchar(60) NOT NULL,
  `NoOfPackages` varchar(10) NOT NULL,
  `WeightUnit` varchar(10) NOT NULL,
  `LineItem` text NOT NULL,
  `LabelChild` text NOT NULL,
  `DeliveryDate` varchar(30) NOT NULL,
 `Multiple` tinyint(1) DEFAULT '0',
 `MultipleOrderID` text NOT NULL,
 `CompanyFrom` VARCHAR(70) NOT NULL,
 `FirstnameFrom` VARCHAR(40) NOT NULL, 
 `LastnameFrom` VARCHAR(40) NOT NULL, 
 `Contactname` VARCHAR(40) NOT NULL,
 `CompanyTo` VARCHAR(70) NOT NULL,
 `FirstnameTo` VARCHAR(40) NOT NULL, 
 `LastnameTo` VARCHAR(40) NOT NULL, 
 `ContactNameTo` VARCHAR(40) NOT NULL,
 `Address1From` VARCHAR(250) NOT NULL,
 `Address1To` VARCHAR(250) NOT NULL,
 `Address2From` VARCHAR(250) NOT NULL,
 `Address2To` VARCHAR(250) NOT NULL,
 `AccountType` VARCHAR(50) NOT NULL, 
 `AccountNumber` VARCHAR(50) NOT NULL, 
 `AesNumber` VARCHAR(80) NOT NULL, 
 `PickupNo` VARCHAR(200) NOT NULL, 
 `PickupFrom` VARCHAR(200) NOT NULL, 
 PRIMARY KEY (`ShipmentID`),
  KEY `ShippedID` (`ShippedID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `w_shipment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(200) NOT NULL,
  `trackingId` varchar(200) NOT NULL,
  `totalFreight` varchar(100) NOT NULL,
  `createdDate` datetime NOT NULL,
  `ShippedID` int(12) NOT NULL,
  PRIMARY KEY (`id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `w_warehouse`
--

CREATE TABLE IF NOT EXISTS `w_warehouse` (
  `WID` int(20) NOT NULL AUTO_INCREMENT,
  `location` int(20) NOT NULL,
  `warehouse_name` varchar(30) NOT NULL,
  `warehouse_code` varchar(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `ContactName` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `Default` tinyint(1) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `CreateDate` date NOT NULL,
  `ipaddress` varchar(30) NOT NULL,
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
 `asm_code` varchar(50)  NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



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




CREATE TABLE IF NOT EXISTS `w_workorder` (
  `Oid` int(11) NOT NULL AUTO_INCREMENT,
  `AutoID` bigint(40) NOT NULL,
  `WON` varchar(50) NOT NULL,
  `OrderType` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `SchDate` date NOT NULL,
  `ItemID` int(11) NOT NULL,
  `warehouse` int(11) NOT NULL,
  `WoQty` int(11) NOT NULL,
  `SaleID` varchar(50) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `CustCode` varchar(50) NOT NULL,
  `Priroty` varchar(50) NOT NULL,
  `CustID` int(11) NOT NULL,
  `AssignedUser` varchar(100) NOT NULL,
  `NumLine` int(10) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Parked',
  `BOM` varchar(50) NOT NULL,
  `req_item` varchar(50) NOT NULL,
  `woCondition` varchar(50) NOT NULL,
  `asmID` int(11) NOT NULL,
  `DsmID` int(11) NOT NULL,
  `RowColor` varchar(50) NOT NULL,
PRIMARY KEY (`Oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `w_workorder_bom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Oid` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `req_item` text NOT NULL,
  `old_req_item` text NOT NULL,
  `add_req_flag` tinyint(1) NOT NULL DEFAULT '0',
  `parent_ItemID` int(11) NOT NULL,
  `Req_ItemID` int(11) NOT NULL,
  `sku` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Condition` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bomID` int(10) NOT NULL,
  `BomDate` date NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `importedemailrules` (
  `RuleID` bigint(20) NOT NULL AUTO_INCREMENT,
  `RuleForEmail` varchar(100) NOT NULL,
  `EmailListName` varchar(100) NOT NULL,
  `EmailListId` int(11) NOT NULL,
  `OwnerEmail` varchar(100) NOT NULL,
  `AdminID` int(3) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `CompID` int(11) NOT NULL,
  `RuleStatus` int(2) NOT NULL,
  `ReadEmail` int(1) NOT NULL,
  `FlaggedEmail` int(1) NOT NULL,
  `MoveToFolder` int(1) NOT NULL,
  `FolderName` varchar(100) NOT NULL,
  `FolderID` int(11) NOT NULL,
  PRIMARY KEY (`RuleID`),
  KEY `AdminID` (`AdminID`,`AdminType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `importedemails` (
  `autoId` bigint(20) NOT NULL AUTO_INCREMENT,
  `From_Email` varchar(100) NOT NULL,
  `To_Email` varchar(100) NOT NULL,
  `OwnerEmailId` varchar(50) NOT NULL,
  `emaillistID` int(11) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `EmailContent` text NOT NULL,
  `Recipient` text NOT NULL,
  `Cc` text NOT NULL,
  `Bcc` text NOT NULL,
  `FromDD` varchar(100) NOT NULL,
  `FromEmail` varchar(100) NOT NULL,
  `TotalRecipient` text NOT NULL,
  `MailType` varchar(50) NOT NULL,
  `OrgMailType` varchar(50) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `ActionMailId` int(11) NOT NULL,
  `AdminId` int(11) NOT NULL,
  `AdminType` varchar(50) NOT NULL,
  `CompID` int(11) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  `ImportedDate` datetime NOT NULL,
  `composedDate` datetime NOT NULL,
  `importFromServer` varchar(50) NOT NULL,
  `importFromEmailID` varchar(100) NOT NULL,
  `msgID` int(11) NOT NULL,
  `OrgDate` varchar(100) NOT NULL,
  `FlagStatus` tinyint(1) NOT NULL,
  `FolderId` int(11) NOT NULL,
  `UniqueMsgID` varchar(100) NOT NULL,
  `MsgUdate` varchar(20) NOT NULL,
  PRIMARY KEY (`autoId`),
  KEY `MailType` (`MailType`,`OwnerEmailId`,`emaillistID`),
  KEY `From_Email` (`From_Email`),
  KEY `To_Email` (`To_Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `importemailattachments` (
  `AutoId` bigint(20) NOT NULL AUTO_INCREMENT,
  `EmailRefId` bigint(20) NOT NULL,
  `FileName` varchar(200) NOT NULL,
   PRIMARY KEY (`AutoId`),
   KEY `RefId` (`EmailRefId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `importemaillist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EmailId` varchar(50) NOT NULL,
  `EmailPassw` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `usrname` varchar(50) NOT NULL,
  `EmailServer` varchar(11) NOT NULL,
  `AdminID` int(2) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `DefalultEmail` int(2) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `CompID` int(11) NOT NULL,
  `ImapDetails` varchar(255) NOT NULL,
  `SmtpDetails` varchar(255) NOT NULL,
   PRIMARY KEY (`id`),
  KEY `AdminID` (`AdminID`),
 KEY `EmailId` (`EmailId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `importedemailfolder` (
  `FolderId` int(11) NOT NULL AUTO_INCREMENT,
  `FolderName` varchar(100) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `Status` int(1) NOT NULL,
  `CompID` int(11) NOT NULL,
  `EmailListId` int(11) NOT NULL,
  `EmailListName` varchar(100) NOT NULL,
  PRIMARY KEY (`FolderId`),
  KEY `AdminID` (`AdminID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `rating` (
  `Rid` int(11) NOT NULL AUTO_INCREMENT,
  `Rating` int(11) NOT NULL,
  `Rname` varchar(50) NOT NULL,
   PRIMARY KEY (`Rid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `rating` (`Rid`, `Rating`, `Rname`) VALUES
(1, 5, 'Excellent'),
(2, 4, 'Very Good'),
(3, 3, 'Good'),
(4, 2, 'Average'),
(5, 1, 'Poor'),
(8, 0, 'Very Poor');


--
-- Dumping data for table `admin_modules`
--


INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`, `Restricted`) VALUES
(1, 'Settings', '', 10, 0, 0, 1, 0, 0),
(2, 'Employee', '', 1, 0, 0, 1, 1, 0),
(3, 'Leave Management', '', 1, 0, 0, 1, 2, 0),
(4, 'Recruitment', '', 1, 0, 0, 1, 3, 0),
(5, 'Time Management', '', 1, 0, 0, 1, 4, 0),
(6, 'My Leaves', '', 1, 0, 1, 1, 0, 0),
(7, 'Time', '', 1, 0, 1, 1, 0, 0),
(8, 'Performance', '', 1, 0, 0, 1, 6, 0),
(9, 'My Profile', '', 1, 0, 1, 1, 0, 0),
(10, 'Directory', '', 1, 0, 0, 1, 10, 0),
(11, 'Announcements', '', 1, 0, 0, 1, 9, 0),
(12, 'Payroll', '', 1, 0, 0, 1, 5, 0),
(13, 'Training', '', 1, 0, 0, 1, 7, 0),
(14, 'Assets', '', 1, 0, 0, 1, 0, 0),
(15, 'Settings', '', 1, 0, 0, 1, 5, 0),
(16, 'Security', '', 11, 0, 0, 1, 0, 0),
(30, 'Report', '', 1, 0, 0, 1, 8, 0),
(31, 'Leave Report', 'viewLeaveReport.php', 0, 30, 0, 1, 0, 0),
(32, 'Employee Turn Over', 'viewEmpturnover.php', 0, 30, 0, 1, 0, 0),
(33, 'Employee Exit Report', 'terminationReport.php', 0, 30, 0, 1, 0, 0),
(34, 'Vacancy Succession Report', 'vacancyReport.php', 0, 30, 0, 1, 0, 0),
(35, 'Employee Hiring Report', 'hiringReport.php', 0, 30, 0, 1, 0, 0),
(37, 'Directory', 'viewDirectory.php', 0, 10, 0, 1, 0, 0),
(49, 'Manage Skill', 'viewAttribute.php?att=23', 0, 15, 0, 1, 3, 0),
(50, 'Other Modules', '', 0, 0, 0, 0, 0, 0),
(51, 'Edit Company Profile', 'editCompany.php', 0, 1, 0, 1, 0, 0),
(52, 'Manage Employee', 'viewEmployee.php', 0, 2, 0, 1, 1, 0),
(53, 'Company Location', 'viewLocation.php', 0, 1, 0, 1, 0, 0),
(54, 'Manage Countries', 'viewCountries.php', 0, 1, 0, 0, 0, 0),
(55, 'Manage States', 'viewStates.php', 0, 1, 0, 0, 0, 0),
(56, 'Manage Cities', 'viewCities.php', 0, 1, 0, 0, 0, 0),
(57, 'Dashboard Icon', 'mngDashboard.php', 0, 1, 0, 1, 0, 0),
(58, 'My Leaves', 'myLeave.php', 0, 6, 1, 1, 0, 0),
(59, 'My Timesheet', 'myTimesheet.php', 0, 7, 0, 0, 0, 0),
(60, 'My Attendance', 'myAttendence.php', 0, 7, 0, 1, 0, 0),
(61, 'Timesheet', 'viewTimesheet.php', 0, 5, 0, 0, 0, 0),
(62, 'Attendance List', 'viewAttendence.php', 0, 5, 0, 1, 0, 0),
(63, 'Job Type', 'viewAttribute.php?att=1', 0, 15, 0, 1, 0, 0),
(64, 'Salary Frequency', 'viewAttribute.php?att=2', 0, 15, 0, 0, 0, 0),
(65, 'Job Title', 'viewAttribute.php?att=11', 0, 15, 0, 1, 0, 0),
(66, 'Manage Education', 'viewEducation.php', 0, 15, 0, 1, 0, 0),
(67, 'Leave Period', 'leavePeriod.php', 0, 15, 0, 0, 0, 0),
(68, 'Leave Type', 'viewAttribute.php?att=9', 0, 15, 0, 1, 0, 0),
(69, 'Manage Vacancies', 'viewVacancy.php', 0, 4, 0, 1, 0, 0),
(70, 'Apply For Leave', 'applyLeave.php', 0, 6, 1, 1, 0, 0),
(71, 'Documents', 'viewDocument.php', 0, 11, 0, 1, 2, 0),
(72, 'Announcements', 'viewNews.php', 0, 11, 0, 1, 1, 0),
(73, 'Holidays', 'viewHoliday.php', 0, 3, 0, 1, 0, 0),
(74, 'Leave Entitlement', 'viewEntitlement.php', 0, 3, 0, 1, 0, 0),
(75, 'Manage Leave', 'viewLeave.php', 0, 3, 0, 1, 1, 0),
(76, 'Manage Department', 'viewDepartment.php', 0, 15, 0, 1, 2, 0),
(77, 'Manage Candidates', 'viewCandidate.php?module=Manage', 0, 4, 0, 1, 0, 0),
(78, 'Leave Applied to Me', 'leaveApplied.php', 0, 6, 1, 0, 0, 0),
(79, 'Shortlisted Candidates', 'viewCandidate.php?module=Shortlisted', 0, 4, 0, 1, 0, 0),
(80, 'Offered Candidates', 'viewCandidate.php?module=Offered', 0, 4, 0, 1, 0, 0),
(81, 'Interview Test', 'viewAttrib.php?att=12', 0, 4, 0, 1, 0, 0),
(82, 'Components', 'viewComponent.php', 0, 8, 0, 1, 0, 0),
(83, 'Weightages', 'viewWeightage.php', 0, 8, 0, 1, 0, 0),
(84, 'KRA', 'viewKra.php', 0, 8, 0, 1, 0, 0),
(85, 'Reviews', 'viewReview.php', 0, 8, 0, 1, 0, 0),
(86, 'Payroll Structure', 'viewPayStructure.php', 0, 12, 0, 0, 1, 0),
(87, 'Employee Salary', 'viewSalary.php', 0, 12, 0, 1, 2, 0),
(88, 'Generated Salary', 'viewGeneratedSalary.php', 0, 12, 0, 0, 3, 0),
(89, 'My Profile', 'myProfile.php', 0, 9, 0, 1, 0, 0),
(90, 'Salary Details', 'mySalary.php', 0, 9, 0, 1, 0, 0),
(91, 'My Declaration', 'myDeclaration.php', 0, 9, 0, 1, 0, 0),
(92, 'Tax Declaration Form', 'taxDeclarationForm.php', 0, 12, 0, 1, 0, 0),
(93, 'Employee Declaration', 'viewDeclaration.php', 0, 12, 0, 1, 0, 0),
(94, 'Manage Training', 'viewTraining.php', 0, 13, 0, 1, 0, 0),
(95, 'Manage Participants', 'viewParticipant.php', 0, 13, 0, 1, 0, 0),
(96, 'Manage Assets', 'viewAsset.php', 0, 14, 0, 1, 1, 0),
(97, 'Manage Brand', 'viewAttrib.php?att=24', 0, 14, 0, 0, 0, 0),
(98, 'Manage Category', 'viewAttrib.php?att=25', 0, 14, 0, 0, 0, 0),
(99, 'Manage Vendor', 'viewVendor.php', 0, 14, 0, 0, 0, 0),
(100, 'Assigned Assets', 'viewAssignAsset.php', 0, 14, 0, 1, 2, 0),
(102, 'Lead', '', 5, 0, 0, 1, 2, 0),
(103, 'Opportunity', '', 5, 0, 0, 1, 3, 0),
(104, 'Ticket', '', 5, 0, 0, 1, 4, 0),
(105, 'Document', '', 5, 0, 0, 1, 8, 0),
(106, 'Campaign', '', 5, 0, 0, 1, 9, 0),
(107, 'Contact', '', 5, 0, 0, 1, 5, 0),
(108, 'Quotes', '', 5, 0, 0, 1, 6, 0),
(115, 'Settings', '', 5, 0, 0, 1, 10, 0),
(116, 'Report', '', 5, 0, 0, 1, 0, 0),
(121, 'Manage Lead', 'viewLead.php?module=lead', 0, 102, 0, 1, 0, 0),
(122, 'Manage Opportunity ', 'viewOpportunity.php?module=Opportunity', 0, 103, 0, 1, 0, 0),
(123, 'Manage Ticket', 'viewTicket.php?module=Ticket', 0, 104, 0, 1, 0, 0),
(124, 'Lead Source', 'viewAttribute.php?att=11', 0, 115, 0, 1, 0, 0),
(126, 'Manage Document', 'viewDocument.php?module=Document', 0, 105, 0, 1, 0, 0),
(127, 'Manage Campaign', 'viewCampaign.php?module=Campaign', 0, 106, 0, 1, 0, 0),
(128, 'Junk Lead', 'viewLead.php?module=junk', 0, 102, 0, 1, 0, 0),
(129, 'Flagged Lead', 'viewLead.php?module=flag', 0, 102, 0, 1, 0, 0),
(130, 'Ticket Category', 'viewAttribute.php?att=15', 0, 115, 0, 1, 0, 0),
(131, 'Sales Stage', 'viewAttribute.php?att=16', 0, 115, 0, 1, 0, 0),
(132, 'Flagged Opportunity', 'viewOpportunity.php?module=flag', 0, 103, 0, 1, 0, 0),
(133, 'Manage Contact', 'viewContact.php?module=contact', 0, 107, 0, 1, 0, 0),
(134, 'Lead Industry', 'viewAttribute.php?att=51', 0, 115, 0, 1, 0, 0),
(135, 'Flagged Ticket', 'viewTicket.php?module=flag', 0, 104, 0, 1, 0, 0),
(136, 'Calendar', '', 5, 0, 0, 1, 7, 0),
(137, 'Calendar View', 'calender.php?module=calender', 0, 136, 0, 1, 0, 0),
(138, 'Manage Event / Task', 'viewActivity.php?module=Activity', 0, 136, 0, 1, 0, 0),
(140, 'Lead Document', 'viewDocument.php?module=Lead', 0, 102, 0, 0, 0, 0),
(141, 'Opportunity Document', 'viewDocument.php?module=Opportunity', 0, 103, 0, 0, 0, 0),
(143, 'Campaign Type', 'viewAttribute.php?att=54', 0, 115, 0, 1, 0, 0),
(144, 'Manage Quotes', 'viewQuote.php?module=Quote', 0, 108, 0, 1, 0, 0),
(145, 'Ticket Document', 'viewDocument.php?module=Ticket', 0, 104, 0, 0, 0, 0),
(146, 'Event Document', 'viewDocument.php?module=Event', 0, 136, 0, 0, 0, 0),
(147, 'Expected Response', 'viewAttribute.php?att=55', 0, 115, 0, 1, 0, 0),
(148, 'Document', 'viewDocument.php?module=Quote', 0, 108, 0, 0, 0, 0),
(149, 'Lead Report', 'viewLeadReport.php', 0, 116, 0, 1, 0, 0),
(150, 'Activity Document', 'viewDocument.php?module=Activity', 0, 136, 0, 0, 0, 0),
(151, 'Manage Group', 'viewGroup.php', 0, 115, 0, 1, 1, 0),
(152, 'Email Template', 'emailTemplate.php', 0, 115, 0, 1, 0, 0),
(153, 'Activity Status', 'viewAttribute.php?att=18', 0, 115, 0, 1, 0, 0),
(154, 'Activity Type', 'viewAttribute.php?att=19', 0, 115, 0, 1, 0, 0),
(155, 'Manage Territory', 'viewTerritory.php', 0, 115, 0, 1, 0, 0),
(156, 'Territory Rules', 'viewTerritoryRule.php', 0, 115, 0, 1, 0, 0),
(157, 'Territory Customer Report', 'territoryCustomerReport.php', 0, 116, 0, 1, 0, 0),
(158, 'Territory Lead Report', 'territoryLeadReport.php', 0, 116, 0, 1, 0, 0),
(160, 'Social CRM', '0', 5, 0, 0, 1, 10, 0),
(161, 'Facebook', 'facebook.php', 0, 160, 0, 1, 0, 0),
(162, 'LinkedIn', 'Linkedin.php', 0, 160, 0, 1, 0, 0),
(163, 'Twitter', 'Twitter.php', 0, 160, 0, 1, 0, 0),
(164, 'Mass Email', '', 5, 0, 0, 1, 11, 0),
(165, 'MailChimp', 'mailchimp.php', 0, 164, 0, 1, 1, 0),
(166, 'iContact', 'mailicontact.php', 0, 164, 0, 0, 2, 0),
(167, 'Constant Contact', 'mailconstantcontact.php', 0, 164, 0, 0, 3, 0),
(168, 'Instagram', 'instagram.php', 0, 160, 0, 1, 0, 0),
(169, 'Mass Mail Setting', 'massmailSetting.php', 0, 164, 0, 1, 1, 0),
(170, 'Recurring Event / Task', 'viewRecurringActivity.php', 0, 136, 0, 1, 0, 0),
(171, 'Recurring Quotes', 'viewRecurringQuote.php', 0, 108, 0, 1, 0, 0),
(175, 'Create Lead Form', 'viewCreateLead.php', 0, 102, 0, 1, 0, 0),
(176, 'Phone', '0', 5, 0, 0, 0, 10, 0),
(177, 'Employee Connect', 'employeeConnect.php', 0, 176, 0, 1, 0, 0),
(178, 'Voicemail', 'ViewVoicemail.php', 0, 176, 0, 1, 0, 0),
(179, 'Google Plus', 'google-plus.php', 0, 160, 0, 1, 0, 0),
(180, 'Call', 'call.php', 0, 176, 0, 1, 0, 0),
(181, 'Call List', 'call-list.php', 0, 176, 0, 1, 0, 0),
(182, 'Chat', '', 5, 0, 0, 0, 0, 0),
(183, 'Chat List', 'chatlist.php', 0, 182, 0, 1, 0, 0),
(184, 'Zoom Meeting', 'meeting.php', 0, 136, 0, 0, 0, 0),
(185, 'Offline Message', 'offline-message.php', 0, 182, 0, 1, 0, 0),
(194, 'Manage Folder', 'viewDocumentFolder.php?module=Document', 0, 105, 0, 1, 0, 0),
(195, 'Workspace', '', 5, 0, 1, 1, 0, 0),
(196, 'My Workspace', 'workspace.php', 0, 195, 0, 1, 0, 0),
(201, 'Products & Categories', '', 2, 0, 0, 1, 1, 0),
(202, 'Shipping & Taxes', '', 2, 0, 0, 1, 3, 0),
(203, 'Payment Methods', '', 2, 0, 0, 1, 4, 0),
(204, 'Settings', '', 2, 0, 0, 1, 5, 0),
(205, 'Orders & Customers', '', 2, 0, 0, 1, 2, 0),
(206, 'Marketing', '', 2, 0, 0, 1, 7, 0),
(207, 'Discounts & Coupon', '', 2, 0, 0, 1, 6, 0),
(211, 'Manage Products', 'viewProduct.php', 0, 201, 0, 1, 0, 0),
(212, 'Manage Categories', 'viewCategory.php', 0, 201, 0, 1, 0, 0),
(213, 'Manage Manufacturers', 'viewManufacturer.php', 0, 201, 0, 1, 0, 0),
(215, 'Store Settings', 'cartSetting.php?module=1', 0, 204, 0, 1, 0, 0),
(216, 'Manage Shipping', 'viewShipping.php', 0, 202, 0, 1, 0, 0),
(217, 'Manage Tax', 'viewTax.php', 0, 202, 0, 1, 0, 0),
(218, 'Manage Tax Class', 'viewTaxClass.php', 0, 202, 0, 1, 0, 0),
(219, 'Manage Orders', 'viewOrder.php', 0, 205, 0, 1, 0, 0),
(220, 'Manage Customers', 'viewCustomer.php', 0, 205, 0, 1, 0, 0),
(221, 'Global Attributes', 'viewGlobalAttribute.php', 0, 201, 0, 1, 0, 0),
(222, 'Bestseller Settings', 'cartSetting.php?module=3', 0, 204, 0, 1, 0, 0),
(223, 'Manage Subscribers Email', 'viewSubscriber.php', 0, 206, 0, 1, 0, 0),
(224, 'Manage Reviews', 'viewProductReview.php', 0, 201, 0, 1, 0, 0),
(225, 'Send Newsletter', 'emailNewsletter.php', 0, 206, 0, 1, 0, 0),
(226, 'Newsletter Templates', 'viewNewsletterTemplate.php', 0, 206, 0, 1, 0, 0),
(227, 'Social Settings', 'cartSetting.php?module=2', 0, 204, 0, 1, 0, 0),
(228, 'Manage Pages', 'viewPages.php', 0, 204, 0, 1, 0, 0),
(229, 'Manage Payment Methods', 'viewPayment.php', 0, 203, 0, 1, 0, 0),
(230, 'Payment Method Configure', 'paymentConfigure.php', 0, 203, 0, 1, 0, 0),
(231, 'Global Discounts', 'viewDiscount.php', 0, 207, 0, 1, 0, 0),
(232, 'Coupon Codes', 'viewCoupon.php', 0, 207, 0, 1, 0, 0),
(233, 'Customer Groups', 'viewCustomerGroup.php', 0, 205, 0, 1, 0, 0),
(241, 'Amazon Settings', 'AmazonCredentials.php', 0, 204, 0, 1, 0, 0),
(242, 'Amazon Items', 'AmazonEditProduct.php', 0, 204, 0, 1, 0, 0),
(243, 'Ebay Settings', 'EbaySetting.php', 0, 204, 0, 1, 0, 0),
(244, 'Ebay  Items', 'viewEbayCredentials.php', 0, 204, 0, 0, 0, 0),
(301, 'Warehouse', '', 3, 0, 0, 1, 0, 0),
(302, 'Inbound Order', '', 3, 0, 0, 1, 0, 0),
(304, 'Outbound Order', '', 3, 0, 0, 1, 0, 0),
(306, 'Settings', '', 3, 0, 0, 1, 0, 0),
(319, 'PO Receipt', 'viewPoReceipt.php', 0, 302, 0, 1, 0, 0),
(320, 'Manage Warehouse', 'viewWarehouse.php', 0, 301, 0, 1, 0, 0),
(321, 'Manage Bin', 'viewManageBin.php', 0, 301, 0, 1, 0, 0),
(322, 'PO Receipt Invoices', 'viewPoInvoice.php', 0, 302, 0, 0, 0, 0),
(323, 'Customer RMA', 'viewSalesReturn.php', 0, 302, 0, 1, 0, 0),
(324, 'Stock Transfer', 'viewStockTransfer.php', 0, 302, 0, 0, 0, 0),
(325, 'Manage Transport', 'viewAttrib.php?att=1', 0, 306, 0, 1, 1, 0),
(326, 'Package Type', 'viewAttrib.php?att=2', 0, 306, 0, 1, 0, 0),
(327, 'Manage Charge', 'viewAttrib.php?att=3', 0, 306, 0, 0, 0, 0),
(328, 'Manage Paid', 'viewAttrib.php?att=4', 0, 306, 0, 0, 0, 0),
(329, 'Stock Adjustment', 'viewStockAdjustment.php', 0, 302, 0, 0, 0, 0),
(330, 'Email Template', 'emailTemplate.php', 0, 306, 0, 1, 0, 0),
(332, 'Shipment', 'viewShipment.php', 0, 304, 0, 1, 0, 0),
(333, 'Ship Transfer Order', 'viewTransferOrder.php', 0, 304, 0, 0, 3, 0),
(334, 'Vendor RMA', 'viewPoRma.php', 0, 304, 0, 1, 2, 0),
(335, 'Released Production Orders', 'viewProductionOrder.php', 0, 304, 0, 0, 0, 0),
(336, 'Manage Shipping', 'viewShipOrder.php', 0, 304, 0, 0, 1, 0),
(337, 'Shipping Carrier', 'viewAttrib.php?att=6', 0, 306, 0, 1, 0, 0),
(339, 'RMA Action', 'viewRmaAction.php', 0, 306, 0, 1, 0, 0),
(340, 'RMA Reason', 'viewAttrib.php?att=7', 0, 306, 0, 1, 0, 0),
(341, 'Shipping Accounts', 'viewShippingAccount.php', 0, 306, 0, 1, 0, 0),
(342, 'Shipment Profile', 'viewShipmentProfile.php', 0, 306, 0, 1, 0, 0),
(343, 'Address Book', 'addressBook.php', 0, 306, 0, 1, 0, 0),
(402, 'Purchase Quote', '', 4, 0, 0, 1, 2, 0),
(403, 'Purchase Order', '', 4, 0, 0, 1, 3, 0),
(405, 'RMA', '', 4, 0, 0, 1, 5, 0),
(409, 'Report', '', 4, 0, 0, 1, 0, 0),
(411, 'Purchase Quote', 'viewPO.php?module=Quote', 0, 402, 0, 1, 0, 0),
(413, 'Purchase Order', 'viewPO.php?module=Order', 0, 403, 0, 1, 0, 0),
(418, 'RMA', 'viewRma.php', 0, 405, 0, 1, 0, 0),
(441, 'PO Report', 'viewPoReport.php', 0, 409, 0, 1, 0, 0),
(442, 'Invoice Report', 'viewInvReport.php', 0, 409, 0, 0, 0, 0),
(443, 'Payment History', 'viewPaymentReport.php', 0, 409, 0, 0, 0, 0),
(601, 'Item Master', '', 6, 0, 0, 1, 0, 0),
(602, 'Stock Adjustments', '', 6, 0, 0, 0, 0, 0),
(603, 'Stock Transfers', '', 6, 0, 0, 0, 0, 0),
(604, 'BOM', '', 6, 0, 0, 0, 0, 0),
(605, 'Report', '', 6, 0, 0, 0, 0, 0),
(610, 'Settings', '', 6, 0, 0, 1, 0, 0),
(628, 'Manage Items', 'viewItem.php', 0, 601, 0, 1, 0, 0),
(629, 'Manage Unit', 'viewAttribute.php?att=11', 0, 610, 0, 0, 0, 0),
(630, 'Tax Rate', 'viewTax.php', 0, 610, 0, 0, 0, 0),
(631, 'Tax Class', 'viewTaxClass.php', 0, 610, 0, 0, 0, 0),
(632, 'Global Attributes', 'viewGlobalAttribute.php', 0, 610, 0, 1, 0, 0),
(633, 'Create Custom Report', 'viewCustomSearch.php', 0, 605, 0, 1, 0, 0),
(634, 'Manage Categories', 'viewCategory.php', 0, 601, 0, 1, 0, 0),
(635, 'Item Type', 'viewAttribute.php?att=1', 0, 610, 0, 0, 0, 0),
(636, 'Procurement', 'viewAttribute.php?att=2', 0, 610, 0, 0, 0, 0),
(637, 'Valuation Type', 'viewAttribute.php?att=3', 0, 610, 0, 0, 0, 0),
(638, 'Adjustments', 'viewAdjustment.php', 0, 602, 0, 0, 0, 0),
(639, 'Adjustment Reason', 'viewAttribute.php?att=13', 0, 610, 0, 0, 0, 0),
(640, 'Manage Stock Transfer', 'viewTransfer.php', 0, 603, 0, 0, 0, 0),
(641, 'Manage BOM', 'viewBOM.php', 0, 604, 0, 0, 0, 0),
(642, 'Manage Prefixes', 'editPrefixes.php', 0, 610, 0, 0, 0, 0),
(643, 'Price List', 'viewPriceList.php', 0, 601, 0, 0, 0, 0),
(644, 'Serial Number List', 'viewSerial.php', 0, 601, 0, 0, 0, 0),
(645, 'Manage Assembly', 'viewAssemble.php', 0, 604, 0, 0, 0, 0),
(646, 'Stock Transfer Report', 'viewTransferReport.php', 0, 605, 0, 0, 0, 0),
(647, 'Stock Adjustment Report', 'viewAdjReport.php', 0, 605, 0, 0, 0, 0),
(648, 'Manage Model', 'viewModel.php', 0, 610, 0, 0, 0, 0),
(649, 'Manage Generation', 'viewAttribute.php?att=5', 0, 610, 0, 0, 0, 0),
(650, 'Manage Extended', 'viewAttribute.php?att=7', 0, 610, 0, 0, 0, 0),
(651, 'Manage Manufacture', 'viewAttribute.php?att=8', 0, 610, 0, 0, 0, 0),
(652, 'Manage Condition', 'viewCondition.php', 0, 610, 0, 0, 0, 0),
(653, 'Reorder Method', 'viewAttribute.php?att=9', 0, 610, 0, 0, 0, 0),
(654, 'Stock Search', 'searchItemStock.php', 0, 601, 0, 0, 0, 0),
(655, 'Manage Disassembly', 'viewDisassembly.php', 0, 604, 0, 0, 0, 0),
(656, 'Inventory Writedown', 'ViewInventorywritedown.php', 0, 610, 0, 1, 0, 0),
(657, 'Valuation Reports', 'viewValuationReport.php', 0, 605, 0, 1, 0, 0),
(702, 'Sales Quote', '', 7, 0, 0, 1, 0, 0),
(703, 'Sales Order', '', 7, 0, 0, 1, 0, 0),
(705, 'RMA', '', 7, 0, 0, 1, 0, 0),
(706, 'Reports', '', 7, 0, 0, 1, 0, 0),
(707, 'Recurring', '', 7, 0, 0, 1, 0, 0),
(713, 'Sales Quote', 'viewSalesQuoteOrder.php?module=Quote', 0, 702, 0, 1, 0, 0),
(715, 'Payment Term', 'viewTerm.php', 0, 710, 0, 0, 0, 0),
(716, 'Shipping Method', 'viewAttrib.php?att=2', 0, 710, 0, 0, 0, 0),
(717, 'Sales Order', 'viewSalesQuoteOrder.php?module=Order', 0, 703, 0, 1, 0, 0),
(721, 'RMA', 'viewRma.php', 0, 705, 0, 1, 0, 0),
(723, 'Sales by Customer', 'viewSalesbyCustomer.php', 0, 706, 0, 1, 0, 0),
(724, 'Sales by Sales Person', 'viewSalesbySalesPerson.php', 0, 706, 0, 1, 0, 0),
(725, 'Sales Statistics', 'viewSalesStatistics.php', 0, 706, 0, 0, 0, 0),
(727, 'Payment History', 'viewPayReport.php', 0, 706, 0, 0, 0, 0),
(728, 'Sales Commission Report', 'viewSalesCommReport.php', 0, 706, 0, 0, 0, 0),
(729, 'Sales by Territory ', 'salesTerritory.php', 0, 706, 0, 1, 0, 0),
(732, 'Recurring Order', 'viewRecurringSO.php?module=Order', 0, 707, 0, 1, 0, 0),
(733, 'Recurring Quote', 'viewRecurringSO.php?module=Quote', 0, 707, 0, 1, 0, 0),
(801, 'Chart of Accounts', '', 8, 0, 0, 1, 0, 0),
(802, 'AR', '', 8, 0, 0, 1, 0, 0),
(803, 'AP', '', 8, 0, 0, 1, 0, 0),
(804, 'Journal Entry', '', 8, 0, 0, 1, 0, 0),
(805, 'Reports', '', 8, 0, 0, 1, 0, 0),
(810, 'Settings', '', 8, 0, 0, 1, 0, 0),
(816, 'Chart of Accounts', 'viewAccount.php', 0, 801, 0, 1, 0, 0),
(817, 'Cash Receipt', 'viewCashReceipt.php', 0, 802, 0, 1, 2, 0),
(818, 'Payment Method', 'viewMethod.php', 0, 810, 0, 0, 3, 0),
(819, 'Manage Tax', 'viewTax.php', 0, 810, 0, 1, 0, 0),
(820, 'Global Setting', 'globalSetting.php', 0, 810, 0, 1, 1, 0),
(821, 'Tax Class', 'viewTaxClass.php', 0, 810, 0, 1, 0, 0),
(822, 'Account Types', 'viewAccountType.php', 0, 801, 0, 1, 0, 0),
(823, 'General Journal', 'viewGeneralJournal.php', 0, 804, 0, 1, 0, 0),
(824, 'Other Income', 'viewOtherIncome.php', 0, 802, 0, 0, 0, 0),
(825, 'Vendor Payments', 'viewVendorPayment.php', 0, 803, 0, 1, 3, 0),
(826, 'Invoice Entry', 'viewOtherExpense.php', 0, 803, 0, 0, 0, 0),
(827, 'Transfer', 'viewTransfer.php', 0, 804, 0, 0, 0, 0),
(828, 'Bank Deposit', 'viewDeposit.php', 0, 804, 0, 0, 0, 0),
(829, 'Profit and Loss', 'ProfitLoss.php', 0, 805, 0, 1, 3, 0),
(830, 'Balance Sheet', 'BalanceSheet.php', 0, 805, 0, 1, 4, 0),
(831, 'Period End', 'periodEndSetting.php', 0, 801, 0, 1, 0, 0),
(832, 'Customer Tax', 'viewSalesTaxReport.php', 0, 805, 0, 1, 0, 0),
(833, 'Vendor Tax', 'viewPurchaseTaxReport.php', 0, 805, 0, 1, 0, 0),
(834, 'AR Aging', 'arAging.php', 0, 805, 0, 1, 1, 0),
(835, 'AP Aging', 'apAging.php', 0, 805, 0, 1, 2, 0),
(836, 'Bank Reconciliation', 'bankReconciliation.php', 0, 803, 0, 1, 6, 0),
(837, 'Spiff Setting', 'spiffSetting.php', 0, 810, 0, 0, 2, 0),
(838, 'Trial Balance', 'TrialBalance.php', 0, 805, 0, 1, 5, 0),
(839, 'Recurring Journal', 'viewRecurringJournal.php', 0, 804, 0, 1, 0, 0),
(860, 'Manage Customer', 'viewCustomer.php', 0, 802, 0, 1, 1, 0),
(861, 'Customer Order', 'viewCustomerOrderInvoice.php?module=Order', 0, 802, 0, 0, 0, 0),
(862, 'Customer Invoice', 'viewCustomerOrderInvoice.php?module=Invoice', 0, 802, 0, 0, 0, 0),
(863, 'Customer Return', 'viewCustomerReturn.php?module=Return', 0, 802, 0, 0, 0, 0),
(865, 'Invoices', 'viewInvoice.php', 0, 802, 0, 1, 0, 0),
(866, 'Credit Memo', 'viewCreditNote.php', 0, 802, 0, 1, 3, 0),
(867, 'Recurring Invoices', 'viewRecurringInvoice.php', 0, 802, 0, 0, 0, 0),
(870, 'Manage Vendor', 'viewSupplier.php', 0, 803, 0, 1, 1, 0),
(871, 'Vendor Purchases', 'viewSuppPO.php', 0, 803, 0, 0, 0, 0),
(872, 'Vendor Invoice Entry', 'viewVendorInvoiceEntry.php', 0, 803, 0, 0, 2, 0),
(873, 'Vendor Returns', 'viewSuppReturn.php', 0, 803, 0, 0, 0, 0),
(874, 'Vendor Price List', 'viewSuppPrice.php', 0, 803, 0, 0, 0, 0),
(876, 'Batch Management', 'viewBatch.php', 0, 803, 0, 1, 4, 0),
(877, 'Email Statement', 'arStatement.php', 0, 802, 0, 1, 0, 0),
(878, 'Hostbill Customer', 'hostbillCustomer.php', 0, 802, 0, 0, 0, 0),
(879, 'Hostbill Product', 'hostbillProduct.php', 0, 802, 0, 0, 0, 0),
(880, 'Vendor Invoices', 'viewPoInvoice.php', 0, 803, 0, 1, 5, 0),
(881, 'Vendor Credit Memo', 'viewPoCreditNote.php', 0, 803, 0, 1, 4, 0),
(882, 'Invoice Report', 'viewInvReport.php', 0, 803, 0, 1, 7, 0),
(883, 'Payment History', 'viewPaymentReport.php', 0, 803, 0, 0, 0, 0),
(884, 'Recurring Invoices', 'viewPoRecurringInvoice.php', 0, 803, 0, 1, 5, 0),
(885, 'Payment Term', 'viewTerm.php', 0, 810, 0, 1, 4, 0),
(886, 'Sales Statistics', 'viewSalesStatistics.php', 0, 805, 0, 1, 0, 0),
(887, 'Payment History', 'viewPayReport.php', 0, 802, 0, 0, 0, 0),
(888, 'Sales Commission Report', 'viewSalesCommReport.php', 0, 802, 0, 1, 4, 0),
(889, 'Gl Account Report', 'viewGLReport.php', 0, 805, 0, 1, 0, 0),
(890, 'Order Source', 'viewOrderSource.php', 0, 810, 0, 1, 0, 0),
(891, 'Sales by Reseller', 'viewSalesbyReseller.php', 0, 802, 0, 0, 0, 0),
(892, 'Reseller - Sales Commission Report', 'viewRsSalesCommReport.php', 0, 802, 0, 0, 0, 0),
(893, 'Payment Providers', 'viewPaymentProvider.php', 0, 810, 0, 1, 0, 0),
(894, 'Tax Report', 'TaxReport.php', 0, 805, 0, 1, 0, 0),
(895, 'Invoice Margin', 'viewInvoiceMarginReport.php', 0, 805, 0, 1, 0, 0),
(896, 'Customer By Sales Person', 'customerBySalesPerson.php', 0, 805, 0, 1, 0, 0),
(897, 'Customer By Tax Rate', 'customerByTaxRate.php', 0, 805, 0, 1, 0, 0),
(898, 'Customer Tax By Product', 'CustomerTaxByProduct.php', 0, 805, 0, 1, 0, 0),
(899, 'Intrastat Report', 'IntrastatReport.php', 0, 805, 0, 1, 0, 0),
(900, 'Tracking Report', 'TrackingReport.php', 0, 805, 0, 1, 0, 0),
(901, 'Sales By Customer', 'SalesByCustomer.php', 0, '805', 0, 1, 0, 0);
(1001, 'Advance', 'viewAdvance.php', 0, 12, 0, 1, 0, 0),
(1002, 'Loan', 'viewLoan.php', 0, 12, 0, 1, 0, 0),
(1003, 'Advance', 'myAdvance.php', 0, 9, 0, 1, 0, 0),
(1004, 'Loan', 'myLoan.php', 0, 9, 0, 1, 0, 0),
(1005, 'Global Settings', 'globalSetting.php', 0, 15, 0, 1, 1, 0),
(1006, 'Overtime', 'viewOvertime.php', 0, 5, 0, 1, 0, 0),
(1007, 'Bonus', 'viewBonus.php', 0, 12, 0, 1, 0, 0),
(1008, 'Short Leave', 'viewShortLeave.php', 0, 3, 0, 1, 0, 0),
(1009, 'Send Request', 'sendRequest.php', 0, 9, 0, 0, 0, 0),
(1010, 'Employee Request', 'viewRequest.php', 0, 11, 0, 0, 0, 0),
(1011, 'Comp-Off', 'viewComp.php', 0, 3, 0, 0, 0, 0),
(1012, 'Compensation', 'myComp.php', 0, 6, 0, 0, 0, 0),
(1013, 'Comp-Off Applied to Me', 'compApplied.php', 0, 6, 0, 0, 0, 0),
(1014, 'Events', 'viewEvent.php', 0, 11, 0, 0, 0, 0),
(1015, 'Email Template', 'email_template.php', 0, 15, 0, 0, 0, 0),
(1017, 'Attrition Report', 'attritionReport.php', 0, 30, 0, 0, 0, 0),
(1018, 'Work Shift', 'viewShift.php', 0, 15, 0, 1, 2, 0),
(1019, 'Reimbursement', 'viewReimbursement.php', 0, 12, 0, 0, 0, 0),
(1020, 'Reimbursement', 'myReimbursement.php', 0, 9, 1, 0, 0, 0),
(1021, 'Appraisal', 'viewAppraisal.php', 0, 12, 0, 0, 4, 0),
(1022, 'Payroll Report', 'viewPayrollReport.php', 0, 12, 0, 1, 2, 0),
(1050, 'Session Log', 'viewUserLog.php', 0, 16, 0, 1, 0, 0),
(1051, 'Call Setting', 'viewcallsetting.php', 0, 1, 0, 0, 0, 0),
(1052, 'User Profile Log', 'viewUserProfileLog.php', 0, 16, 0, 1, 0, 0),
(1053, 'IP Restriction', 'IpRestriction.php', 0, 16, 0, 1, 0, 0),
(1054, 'Chat Setting', 'chatsetting.php', 0, 1, 0, 0, 0, 0),
(1055, 'Inventory Setting', 'inventorySetting.php', 0, 1, 0, 0, 0, 0),
(1056, 'Hostbill Setting', 'hostbillsetting.php', 0, 810, 0, 0, 0, 0),
(2001, 'Users', '', 5, 0, 0, 0, 0, 0),
(2002, 'Manage Users', 'viewUser.php', 0, 2001, 0, 1, 0, 0),
(2003, 'Item Master', '', 5, 0, 0, 0, 0, 0),
(2004, 'Manage Items', 'viewItem.php', 0, 2003, 0, 1, 0, 0),
(2005, 'Manage Users', 'viewUsers.php', 0, 1, 0, 0, 0, 0),
(2007, 'Sales Commission Tier', 'viewTier.php', 0, 15, 0, 1, 0, 0),
(2008, 'Sales Commission Tier', 'viewTier.php', 0, 115, 0, 0, 0, 0),
(2009, 'Sales Commission Tier', 'viewTier.php', 0, 610, 0, 0, 0, 0),
(2010, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 15, 0, 1, 0, 0),
(2011, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 115, 0, 0, 0, 0),
(2012, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 610, 0, 0, 0, 0),
(2015, 'Customer', '', 5, 0, 0, 1, 9, 0),
(2016, 'Manage Customer', 'viewCustomer.php', 0, 2015, 0, 1, 0, 0),
(2017, 'Leave Approval Check', 'viewLeaveCheck.php', 0, 15, 0, 0, 0, 0),
(2018, 'Benefits', 'viewBenefit.php', 0, 15, 0, 1, 0, 0),
(2019, 'Benefits', 'myBenefit.php', 0, 9, 0, 1, 0, 0),
(2020, 'Leave Custom Rule', 'viewLeaveRule.php', 0, 3, 0, 1, 0, 0),
(2021, 'Custom Report Rule', 'viewReportRule.php', 0, 5, 0, 1, 0, 0),
(2022, 'Custom Report', 'viewCustomReport.php', 0, 5, 0, 1, 0, 0),
(2023, 'Filing Status', 'viewFiling.php', 0, 15, 0, 1, 0, 0),
(2024, 'Tax Bracket', 'viewTaxBracket.php', 0, 15, 0, 1, 0, 0),
(2025, 'Email', '', 5, 0, 0, 0, 0, 0),
(2026, 'Email Setting', 'viewImportEmailId.php', 0, 2025, 0, 1, 0, 0),
(2027, 'Compose Email', 'composeEmail.php', 0, 2025, 0, 1, 2, 0),
(2028, 'Sent Emails', 'sentEmails.php', 0, 2025, 0, 1, 4, 0),
(2029, 'Trash Emails', 'trashEmail.php', 0, 2025, 0, 1, 6, 0),
(2031, 'Draft', 'draftList.php', 0, 2025, 0, 1, 3, 0),
(2032, 'Inbox', 'viewImportedEmails.php', 0, 2025, 0, 1, 1, 0),
(2033, 'Spam', 'spamEmail.php', 0, 2025, 0, 1, 5, 0),
(2034, 'Flagged Emails', 'flaggedEmail.php', 0, 2025, 0, 1, 7, 0),
(2035, 'Rule Setting', 'viewRulesForEmail.php', 0, 2025, 0, 1, 8, 0),
(2041, 'Lead Rating By Industry', 'leadReportByIndustry.php', 0, 116, 0, 1, 0, 0),
(2042, 'Lead Rating By Sales Person', 'ratingReportBySalesPerson.php', 0, 116, 0, 1, 0, 0),
(2043, 'Lead Rating By Annual Revenue', 'ratingReportbyAnnualRevenue.php', 0, 116, 0, 1, 0, 0),
(2044, 'Lead Rating By Territory', 'ratingReportByTerritory.php', 0, 116, 0, 1, 0, 0),
(2045, 'Custom Reports', 'viewCustomReports.php', 0, 116, 0, 1, 0, 0),
(2051, 'Payment Method', 'viewMethod.php', 0, 115, 0, 0, 0, 0),
(2052, 'Payment Term', 'viewTerm.php', 0, 115, 0, 1, 0, 0),
(2054, 'Manage Taxes', 'viewTax.php', 0, 115, 0, 1, 0, 0),
(2059, 'Payroll Period', 'viewPayPeriod.php', 0, 15, 0, 1, 0, 0),
(2060, 'Deductions', 'viewDeduction.php', 0, 15, 0, 1, 0, 0),
(2061, 'Deduction Rule', 'viewDeductionRule.php', 0, 15, 0, 1, 0, 0),
(2062, 'Role Group', 'viewRoleGroup.php', 0, 15, 0, 1, 0, 0),
(2063, 'Role Group', 'viewRoleGroup.php', 0, 115, 0, 1, 0, 0),
(2064, 'Role Group', 'viewRoleGroups.php', 0, 1, 0, 0, 0, 0),
(2065, 'Employee Category', 'viewEmpCategory.php', 0, 15, 0, 1, 2, 0),
(2099, 'Manage Headers', 'viewHeads.php', 0, 115, 0, 1, 0, 0),
(3000, 'Custom Fields', 'CrmSetting.php', 0, 115, 0, 1, 0, 0),
(3006, 'Menu', '', 9, 0, 0, 1, 1, 0),
(3007, 'Manage Menu', 'viewMenus.php', 0, 3006, 0, 1, 0, 0),
(3008, 'Page', '', 9, 0, 0, 1, 0, 0),
(3009, 'Manage Page', 'viewContents.php', 0, 3008, 0, 1, 0, 0),
(3010, 'Template', '', 9, 0, 0, 1, 0, 0),
(3011, 'Manage Template', 'template.php', 0, 3010, 0, 1, 0, 0),
(3012, 'Setting', '', 9, 0, 0, 1, 0, 0),
(3013, 'Global Setting', 'setting.php', 0, 3012, 0, 1, 0, 0),
(3015, 'Form', '', 9, 0, 0, 1, 3, 0),
(3016, 'Custom Form', 'viewForms.php', 0, 3015, 0, 1, 0, 0),
(3017, 'Form Fields', 'viewFormFields.php', 0, 3015, 0, 1, 0, 0),
(3018, 'Customer Form Data', 'viewFormData.php', 0, 3015, 0, 1, 0, 0),
(3019, 'Group Discount', 'groupDiscount.php', 0, 205, 0, 1, 0, 0),
(3021, 'Social Links', 'socialLinks.php', 0, 204, 0, 1, 0, 0),
(3022, 'Template', '', 2, 0, 0, 1, 4, 0),
(3023, 'Manage Template', 'template.php', 0, 3022, 0, 1, 0, 0),
(3029, 'Slider Banner', 'sliderBanners.php', 0, 204, 0, 1, 0, 0),
(3030, 'Manage Variant', 'managevariant.php', 0, 204, 0, 1, 0, 0),
(3033, 'Assign Website', '', 9, 0, 0, 1, 0, 0),
(3034, 'Assign Website', 'viewassignWebsite.php', 0, 3033, 0, 1, 0, 0),
(3044, 'Ebay  Items', 'EbayEditProduct.php', 0, 204, 0, 1, 0, 0),
(3090, 'Widgets', '', 2, 0, 0, 1, 4, 0),
(3091, 'Widgets', 'widgets.php', 0, 3090, 0, 1, 4, 0),
(3092, 'Purchased Templates', '', 2, 0, 0, 1, 4, 0),
(3093, 'Purchased Templates', 'themes.php', 0, 3092, 0, 1, 4, 0),
(4000, 'Batch Management', 'viewbatchmgmt.php', 0, 304, 0, 0, 1, 0),
(4050, 'Merge Item', 'viewMergeItem.php', 0, 604, 0, 1, 0, 0),
(4055, 'Exclusive Items', 'viewItem.php?module=exclusive', 0, 601, 0, 1, 0, 0),
(4060, 'Create RMA Form', 'viewCreateRMA.php', 0, 705, 0, 1, 0, 0),
(4061, 'Sales Order Logs', 'order_log.php', 0, 703, 0, 1, 0, 0),
(5001, 'Vendor', '', 12, 0, 0, 1, 1, 0),
(5002, 'Report', '', 12, 0, 0, 1, 2, 0),
(5003, 'Manage Vendor', 'vendor.php', 0, 5001, 0, 1, 0, 0),
(5004, 'Sales by Order Id', 'report.php', 0, 5002, 0, 1, 1, 0),
(5005, 'Sales by Order Type', 'reportordertype.php', 0, 5002, 0, 1, 2, 0),
(5006, 'Sales by Order Server', 'reportorderserver.php', 0, 5002, 0, 1, 3, 0),
(5007, 'Sales by Order Item', 'reportorderitem.php', 0, 5002, 0, 1, 3, 0),
(5009, 'PO/SO Comments', 'viewMasterComments.php', 0, 810, 0, 1, 0, 0),
(5500, 'Picking', '', 3, 0, 0, 1, 4, 0),
(5501, 'Picking', 'viewPicking.php', 0, 5500, 0, 1, 0, 0),
(5503, 'Work Order', 'viewWorkOrder.php', 0, 5502, 0, 1, 0, 0),
(5502, 'Work Order', '', 3, 0, 0, 1, 0, 0),
(5504, 'Ticket Form', 'viewCreateTicket.php', '0', '104', '0', '1', '0', '0'),
(6002, 'My Workspace', 'workspacefin.php', 0, 6001, 0, 1, 0, 0),
(6001, 'Workspace', '', 8, 0, 0, 1, 0, 0),
(6020, 'Request For EDI', '', '13', '0', '0', '1', '0', '0'),
(6021, 'Request For EDI', 'requestEDI.php', '0', '6020', '0', '1', '0', '0'),
(6022, 'Requested EDI', 'requestEDI.php?type=Reqest', '0', '6020', '0', '1', '0', '0'),
(6023, 'Accepted EDI', 'requestEDI.php?type=Accept', '0', '6020', '0', '1', '0', '0'),
(6024, 'Rejected EDI', 'requestEDI.php?type=Reject', '0', '6020', '0', '1', '0', '0'),
(6030, 'Edi SO records', 'viewSalesRecod.php?module=PO', '0', '6020', '0', '1', '0', '0'),
(6031, 'Edi PO records', 'viewSalesRecod.php?module=SO', '0', '6020', '0', '1', '0', '0');
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
(92, 'Task', 19, 1, 1),
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
(200, 'Meeting', 19, 1, 1),
(225, 'Zoom Webinar', 19, 1, 1);
--
-- Dumping data for table `dashboard_icon`
--


INSERT INTO `dashboard_icon` (`IconID`, `Module`, `Link`, `ModuleID`, `EditPage`, `IframeFancy`, `depID`, `Display`, `Status`, `OrderBy`, `IconType`, `Default`) VALUES
(1, 'Employee', 'viewEmployee.php', 52, 0, '', 1, 1, 1, 1, 2, 0),
(21, 'My Leaves', 'myLeave.php', 58, 0, '', 1, 1, 1, 21, 3, 1),
(11, 'My Timesheet', 'myTimesheet.php', 59, 0, '', 1, 1, 0, 11, 4, 1),
(13, 'My Attendance', 'myAttendence.php', 60, 0, '', 1, 1, 1, 13, 4, 1),
(2, 'Add Employee', 'editEmployee.php', 52, 1, '', 1, 1, 1, 2, 0, 0),
(12, 'Attendance', 'viewAttendence.php', 62, 0, '', 1, 1, 1, 12, 4, 0),
(98, 'Holidays', '#holiday_div', 73, 0, 'f', 1, 1, 1, 0, 3, 1),
(10, 'Timesheet', 'viewTimesheet.php', 61, 0, '', 1, 1, 0, 10, 4, 0),
(4, 'Manage Leave', 'viewLeave.php', 75, 0, '', 1, 1, 1, 4, 5, 0),
(16, 'KRA', 'viewKra.php', 84, 0, '', 1, 1, 1, 16, 5, 0),
(3, 'Apply For Leave', 'applyLeave.php', 70, 0, '', 1, 1, 1, 3, 1, 1),
(116, 'Add Task', 'editActivity.php?module=Activity&mode=Task', 138, 1, '', 5, 0, 0, 16, 0, 0),
(115, 'Add Event', 'editActivity.php?module=Activity&mode=Event', 138, 1, '', 5, 0, 0, 15, 0, 0),
(114, 'Events / Tasks', 'viewActivity.php?module=Activity', 138, 0, '', 5, 1, 1, 14, 4, 0),
(113, 'Calendar', 'calender.php?module=calender', 137, 0, '', 5, 1, 1, 13, 3, 0),
(112, 'Add Quote', 'editQuote.php?module=Quote', 144, 1, '', 5, 1, 1, 12, 0, 0),
(111, 'Quotes', 'viewQuote.php?module=Quote', 144, 0, '', 5, 1, 1, 11, 5, 0),
(110, 'Add Campaign', 'editCampaign.php?module=Campaign', 127, 1, '', 5, 1, 1, 10, 0, 0),
(109, 'Campaign', 'viewCampaign.php?module=Campaign', 127, 0, '', 5, 1, 1, 9, 3, 0),
(108, 'Add Document', 'editDocument.php?module=Document', 126, 1, '', 5, 1, 1, 8, 0, 0),
(107, 'Documents', 'viewDocument.php?module=Document', 126, 0, '', 5, 1, 1, 7, 5, 0),
(106, 'Add Ticket', 'editTicket.php?module=Ticket', 123, 1, '', 5, 1, 1, 6, 0, 0),
(105, 'Tickets', 'viewTicket.php?module=Ticket', 123, 0, '', 5, 1, 1, 5, 5, 0),
(104, 'Add Opportunity', 'editOpportunity.php?module=Opportunity', 122, 1, '', 5, 1, 1, 4, 0, 0),
(5, 'Assign Leave', 'assignLeave.php', 75, 1, '', 1, 1, 1, 5, 1, 0),
(15, 'Generate Salary', 'generateSalary.php', 88, 1, '', 1, 1, 1, 15, 1, 0),
(103, 'Opportunities', 'viewOpportunity.php?module=Opportunity', 122, 0, '', 5, 1, 1, 3, 5, 0),
(102, 'Add Lead', 'editLead.php?module=lead', 121, 1, '', 5, 1, 1, 2, 0, 0),
(101, 'Lead', 'viewLead.php?module=lead', 121, 0, '', 5, 1, 1, 1, 5, 0),
(18, 'Training', 'viewTraining.php', 94, 0, '', 1, 1, 1, 18, 5, 0),
(210, 'Add Product', 'editProduct.php', 211, 1, '', 2, 1, 1, 1, 0, 0),
(201, 'Products', 'viewProduct.php', 211, 0, '', 2, 1, 1, 1, 5, 0),
(202, 'Categories', 'viewCategory.php', 212, 0, '', 2, 1, 1, 2, 5, 0),
(206, 'Manufacturers', 'viewManufacturer.php', 213, 0, '', 2, 1, 1, 6, 5, 0),
(203, 'Store Settings', 'cartSetting.php?module=1', 215, 0, '', 2, 1, 1, 3, 1, 0),
(207, 'Send Newsletter', 'emailNewsletter.php', 225, 1, '', 2, 1, 1, 7, 1, 0),
(208, 'Manage Pages', 'viewPages.php', 228, 0, '', 2, 1, 1, 8, 5, 0),
(209, 'Tax Class', 'viewTaxClass.php', 821, 0, '', 2, 1, 1, 0, 1, 0),
(204, 'Orders', 'viewOrder.php', 219, 0, '', 2, 1, 1, 4, 3, 0),
(205, 'Customers', 'viewCustomer.php', 220, 0, '', 2, 1, 1, 5, 2, 0),
(14, 'Payroll', 'viewSalary.php', 87, 0, '', 1, 1, 1, 14, 3, 0),
(22, 'My Profile', 'myProfile.php', 89, 0, '', 1, 1, 1, 22, 2, 1),
(17, 'Review', 'viewReview.php', 85, 0, '', 1, 1, 1, 17, 3, 0),
(23, 'My Declaration', 'myDeclaration.php', 91, 0, '', 1, 1, 1, 23, 1, 1),
(9, 'Add Candidate', 'editCandidate.php?module=Manage', 77, 1, '', 1, 1, 1, 9, 0, 0),
(8, 'Candidates', 'viewCandidate.php?module=Manage', 77, 0, '', 1, 1, 1, 8, 2, 0),
(7, 'Add Vacancy', 'editVacancy.php', 69, 1, '', 1, 1, 1, 7, 0, 0),
(6, 'Vacancies', 'viewVacancy.php', 69, 0, '', 1, 1, 1, 6, 5, 0),
(97, 'Directory', 'viewDirectory.php?pop=1', 37, 0, 'i', 1, 1, 1, 0, 3, 0),
(99, 'Punch In/Out', 'punching.php', 62, 0, 'i', 1, 1, 1, 0, 4, 1),
(24, 'Report', 'viewLeaveReport.php', 31, 0, '', 1, 1, 1, 24, 3, 0),
(301, 'Warehouse', 'viewWarehouse.php', 320, 0, '', 3, 1, 1, 1, 0, 0),
(303, 'Bin', 'viewManageBin.php', 321, 0, '', 3, 1, 1, 2, 3, 0),
(313, 'Ship Sales Order', 'viewShipment.php', 332, 0, '', 3, 1, 1, 4, 4, 0),
(314, 'Receive PO', 'viewPoReceipt.php', 319, 0, '', 3, 1, 1, 3, 3, 0),
(403, 'Purchase Quote', 'viewPO.php?module=Quote', 411, 0, '', 4, 1, 1, 0, 2, 0),
(404, 'Add Quote', 'editPO.php?module=Quote', 411, 1, '', 4, 1, 1, 0, 0, 0),
(405, 'Purchase Order', 'viewPO.php?module=Order', 413, 0, '', 4, 1, 1, 0, 2, 0),
(406, 'Add PO', 'editPO.php?module=Order', 413, 1, '', 4, 1, 1, 0, 0, 0),
(409, 'RMA', 'viewRma.php', 418, 0, '', 4, 1, 1, 0, 2, 0),
(413, 'PO Report', 'viewPoReport.php', 441, 0, '', 4, 1, 1, 0, 2, 0),
(414, 'Invoice Report', 'viewInvReport.php', 442, 0, '', 4, 1, 0, 0, 0, 0),
(415, 'Payment History', 'viewPayReport.php', 727, 0, '', 4, 1, 0, 0, 2, 0),
(703, 'Sales Quote', 'viewSalesQuoteOrder.php?module=Quote', 713, 0, '', 7, 1, 1, 0, 2, 0),
(704, 'Add Quote', 'editSalesQuoteOrder.php?module=Quote', 713, 1, '', 7, 1, 1, 0, 0, 0),
(705, 'Sales Order', 'viewSalesQuoteOrder.php?module=Order', 717, 0, '', 7, 1, 1, 0, 2, 0),
(706, 'Add SO', 'editSalesQuoteOrder.php?module=Order', 717, 1, '', 7, 1, 1, 0, 0, 0),
(709, 'RMA', 'viewRma.php', 418, 0, '', 7, 1, 1, 0, 2, 0),
(715, 'Report', 'viewSalesbyCustomer.php', 723, 0, '', 7, 1, 1, 0, 2, 0),
(716, 'Sales Statistics', 'viewSalesStatistics.php', 725, 0, '', 7, 1, 0, 0, 2, 0),
(601, 'Items', 'viewItem.php', 628, 0, '', 6, 1, 1, 1, 2, 0),
(602, 'Add Item', 'editItem.php', 628, 1, '', 6, 1, 1, 0, 0, 0),
(603, 'Categories', 'viewCategory.php', 212, 0, '', 6, 1, 1, 0, 2, 0),
(604, 'Add Category', 'editCategory.php', 212, 1, '', 6, 1, 1, 0, 0, 0),
(605, 'Price List', 'viewPriceList.php', 643, 0, '', 6, 0, 1, 0, 2, 0),
(606, 'Stock Adjustment', 'viewAdjustment.php', 638, 1, '', 6, 0, 1, 0, 0, 0),
(607, 'Stock Transfers', 'viewTransfer.php', 640, 0, '', 6, 0, 1, 0, 2, 0),
(608, 'BOM', 'viewBOM.php', 641, 1, '0', 6, 0, 1, 0, 0, 0),
(122, 'Add Customer', 'addCustomer.php', 2016, 1, '', 5, 1, 1, 22, 0, 0),
(120, 'Add Item', 'editItem.php', 2004, 1, '', 5, 1, 1, 20, 0, 0),
(121, 'Customer', 'viewCustomer.php', 2016, 0, '', 5, 1, 1, 21, 2, 0),
(119, 'Items', 'viewItem.php', 628, 0, '', 5, 1, 1, 19, 2, 0),
(117, 'Users', 'viewUser.php', 2002, 0, '', 5, 1, 1, 17, 2, 0),
(118, 'Add User', 'editUser.php', 2002, 1, '', 5, 1, 1, 18, 0, 0),
(612, 'Stock Search', 'searchItemStock.php', 654, 1, '0', 6, 0, 0, 2, 0, 0),
(801, 'Chart of Accounts', 'viewAccount.php', 816, 0, '', 8, 1, 1, 1, 2, 0),
(802, 'AR Cash Receipt', 'receivePayment.php', 817, 0, '', 8, 1, 1, 2, 2, 0),
(803, 'AP Payments', 'viewVendorPayment.php', 825, 0, '', 8, 1, 1, 3, 2, 0),
(804, 'Journal Entry', 'viewGeneralJournal.php', 823, 0, '', 8, 1, 1, 4, 2, 0),
(805, 'Profit and Loss', 'ProfitLoss.php', 829, 0, '', 8, 1, 1, 5, 2, 0),
(806, 'Balance Sheet', 'BalanceSheet.php', 830, 0, '', 8, 1, 1, 6, 2, 0),
(807, 'Customer', 'viewCustomer.php', 860, 0, '', 8, 1, 1, 7, 2, 0),
(808, 'AR Invoices', 'viewInvoice.php', 865, 0, '', 8, 1, 1, 8, 2, 0),
(809, 'Sales Commission', 'viewSalesCommReport.php', 728, 0, '', 8, 1, 1, 9, 2, 0),
(810, 'Vendor', 'viewSupplier.php', 870, 0, '', 8, 1, 1, 10, 2, 0),
(811, 'AP Invoices', 'viewPoInvoice.php', 322, 0, '', 8, 1, 1, 11, 2, 0),
(813, 'Pay Vendor', 'payVendor.php', 825, 0, '', 8, 1, 1, 3, 2, 0),
(815, 'Vendor', 'vendor.php', 5001, 0, '', 12, 1, 1, 1, 2, 0),
(816, 'Report', 'report.php', 5002, 0, '', 12, 1, 1, 3, 2, 0);


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
(8, 'Finance', 1),
(9, 'Website', 1),
(10, 'Settings', 0),
(11, 'Security', 0),
(12, 'POS', 1),
(13, 'EDI', 1);

--
-- Dumping data for table `email_cat`
--


INSERT INTO `email_cat` (`CatID`, `department`, `Name`, `OrderLevel`, `Status`) VALUES
(1, 5, 'Lead Assign', 0, 1),
(2, 5, 'New Lead', 0, 1),
(3, 5, 'New Opportunity', 0, 1),
(4, 5, 'Opportunity Assign', 0, 1),
(5, 5, 'New Ticket', 0, 1),
(6, 5, 'Ticket Assign', 0, 1),
(7, 5, 'New Quote', 0, 1),
(8, 5, 'Quote Assign', 0, 1),
(9, 5, 'Ticket Notification', 0, 1),
(10, 5, 'Import Lead Assign', 0, 1),
(11, 5, 'Import New Lead', 0, 1),
(57, 3, 'Send Sales Quote', 0, 1),
(56, 3, 'New Sales Order', 0, 1),
(55, 3, 'New Sales Quote', 0, 1),
(54, 3, 'Sale Order Assign', 0, 1),
(52, 3, 'Sale Order Approval', 0, 1),
(53, 3, 'Sale Quote Assign', 0, 1),
(51, 3, 'Sale Quote Approval', 0, 1),
(72, 3, 'Vendor RMA Close', 0, 1),
(71, 3, 'Customer RMA Close', 0, 1),
(58, 3, 'Send Sales Order', 0, 1),
(59, 3, 'Send Sales Credit Memo', 0, 1),
(60, 3, 'Send Sales Invoice', 0, 1),
(61, 3, 'Purchase Quote Approval', 0, 1),
(62, 3, 'Purchase Order Approval', 0, 1),
(63, 3, 'New Purchase Quote', 0, 1),
(64, 3, 'New Purchase Order', 0, 1),
(65, 3, 'Purchase Quote Assign', 0, 0),
(66, 3, 'Purchase Order Assign', 0, 0),
(67, 3, 'Send Purchase Quote', 0, 1),
(68, 3, 'Send Purchase Order', 0, 1),
(69, 3, 'Send Purchase Credit Memo', 0, 1),
(70, 3, 'Send Purchase Invoice', 0, 1),
(75, 3, 'Send AR Cash Receipt', 0, 1),
(76, 3, 'Send AP Vendor Payment', 0, 1),
(77, 3, 'Send AR Statement', 0, 1),
(78, 3, 'Send Purchase Rma', 0, 1), 
(79, 3, 'Send Sales Rma', 0, 1),
(80, 3, 'Credit Card Authorize', 0, 1),
(81, 3, 'Credit Card Void', 0, 1);


--
-- Dumping data for table `email_template`
--


INSERT INTO `email_template` (`TemplateID`, `CatID`, `Title`, `subject`, `Content`, `arr_field`, `Status`) VALUES
(1, 1, NULL, 'New Lead  has been Assigned to You', 'New Lead  has been assigned to you on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\nPlease see below Lead details : <br />\r\n<br />\r\nFirst Name :&nbsp; [FIRSTNAME]<br />\r\n<br />\r\nLast Name :&nbsp; [LASTNAME]<br />\r\n<br />\r\nLead Name :&nbsp; [FIRSTNAME] [LASTNAME]<br />\r\n<br />\r\nTitle :&nbsp; [TITLE]<br />\r\n<br />\r\nPrimary Email :&nbsp; [PRIMARYEMAIL]<br />\r\n<br />\r\nCompany :&nbsp; [COMPANY]<br />\r\n<br />\r\nWebsite :&nbsp; [WEBSITE]<br />\r\n<br />\r\nSales Person :&nbsp; [ASSIGNEDTO]<br />\r\n<br />\r\nProduct :&nbsp; [PRODUCT]<br />\r\n<br />\r\nProduct Price :&nbsp; [PRODUCTPRICE]<br />\r\n<br />\r\nAnnual Revenue :&nbsp; [ANNUALREVENUE]<br />\r\n<br />\r\nNumber Of Employees :&nbsp; [NUMBEROFEMPLOYEES]<br />\r\n<br />\r\nLast Contact Date :&nbsp; [LASTCONTACTDATE]<br />\r\n<br />\r\nLead Source :&nbsp; [LEADSOURCE]<br />\r\n<br />\r\nLead Status :&nbsp; [LEADSTATUS]<br />\r\n<br />\r\nLead Date : &nbsp; [LEADDATE]<br />\r\n<br />\r\nDescription :&nbsp; [DESCRIPTION]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br />\r\n<br />', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(2, 2, NULL, 'New Lead  has been created', 'New Lead  has been submitted on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\nPlease see below Lead details : <br />\r\n<br />\r\nLead Name :&nbsp; [FIRSTNAME][LASTNAME]<br />\r\n<br />\r\nTitle :&nbsp; [TITLE]<br />\r\n<br />\r\nPrimary Email :&nbsp; [PRIMARYEMAIL]<br />\r\n<br />\r\nSales Person :&nbsp; [ASSIGNEDTO]<br />\r\n<br />\r\nCompany&nbsp;            :&nbsp; [COMPANY]   <br />\r\n<br />\r\nProduct :&nbsp; [PRODUCT]<br />\r\n<br />\r\nProduct Price :&nbsp; [PRODUCTPRICE]<br />\r\n<br />\r\nLead Source :&nbsp; [LEADSOURCE]<br />\r\n<br />\r\nLead Status :&nbsp; [LEADSTATUS]<br />\r\n<br />\r\nLead Date :&nbsp; [LEADDATE]<br />\r\n<br />\r\nDescription&nbsp;        :&nbsp; [DESCRIPTION]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(3, 3, NULL, 'New Opportunity  has been created', 'Dear Administrator,<br />\r\n<p><br />\r\nNew Opportunity  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n<br />\r\nPlease see below  Opportunity details : <br />\r\n<br />\r\nOpportunity Name          : [OPPORTUNITYNAME]<br />\r\n<br />\r\nOrganization :&nbsp; [ORGANIZATIONNAME]<br />\r\n<br />\r\nExpected Close Date : [EXPECTEDCLOSEDATE]<br />\r\n<br />\r\nAmount&nbsp;      : [AMOUNT]<br />\r\n<br />\r\nSale stage              : [SALESSTAGE]<br />\r\n<br />\r\nAssign To : [ASSIGNEDTO]<br />\r\n<br />\r\nCustomer&nbsp; : [CUSTOMER]<br />\r\n<br />\r\nLead Source : LEADSOURCE]<br />\r\n<br />\r\nIndustry :&nbsp; [INDUSTRY]<br />\r\n<br />\r\nNext Step : [NEXTSTEP]<br />\r\n<br />\r\nOpportunity Type : [OPPORTUNITYTYPE]<br />\r\n<br />\r\nProbability : [PROBABILITY]<br />\r\n<br />\r\nCampaign Source : [CAMPAIGNSOURCE]<br />\r\n<br />\r\nForcast Amount : [FORECASTAMOUNT]<br />\r\n<br />\r\nContact Name           : [CONTACTNAME]<br />\r\n<br />\r\nWebsite : [WEBSITE]<br />\r\n<br />\r\nDescription : [DESCRIPTION]<br />\r\n<br />\r\nSales Person       : [ASSIGNEDTO]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]</p>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(4, 4, NULL, 'New Opportunity  has been Assigned to You', 'New Opportunity  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\nPlease see below  Opportunity details : <br />\r\n<br />\r\nPlease see below  Opportunity details : <br />\r\n<br />\r\nOpportunity Name          : [OPPORTUNITYNAME]<br />\r\n<br />\r\nOrganization&nbsp;&nbsp; :&nbsp;&nbsp; [ORGANIZATIONNAME]<br />\r\n<br />\r\nExpected Close Date    : [EXPECTEDCLOSEDATE]<br />\r\n<br />\r\nAmount&nbsp;      : [AMOUNT]<br />\r\n<br />\r\nSale stage              : [SALESSTAGE]<br />\r\n<br />\r\nSales Person : [ASSIGNEDTO]<br />\r\n<br />\r\nCustomer&nbsp; : [CUSTOMER]<br />\r\n<br />\r\nLead Source : [LEADSOURCE]<br />\r\n<br />\r\nIndustry : [INDUSTRY]<br />\r\n<br />\r\nNext Step : [NEXTSTEP]<br />\r\n<br />\r\nOpportunity Type : [OPPORTUNITYTYPE]<br />\r\n<br />\r\nProbability : [PROBABILITY]<br />\r\n<br />\r\nCampaign Source : [CAMPAIGNSOURCE]<br />\r\n<br />\r\nForcast Amount : [FORECASTAMOUNT]<br />\r\n<br />\r\nContact Name           : [CONTACTNAME]<br />\r\n<br />\r\nWebsite : [WEBSITE]<br />\r\n<br />\r\nDescription : [DESCRIPTION]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(5, 5, NULL, 'New Ticket  has been Added', 'Ticket  has been Added with [PARENT] [[PARENTID]] on <a class="normallink" target="_blank" href="http://www.eznetcrm.com/erp/admin/">[SITENAME]</a>. <br />\r\nPlease see below  Ticket details : <br />\r\n<br />\r\n<br />\r\nTicket Title            :  [TITLE]    <br />\r\n<br />\r\nTicket Category      : [CATEGORY]   <br />\r\n<br />\r\nGenerate Date         : [CREATEDON]<br />\r\n<br />\r\nPriority             : [PRIORITY]   <br />\r\n<br />\r\nDescription          : [DESCRIPTION]<br />\r\n<br />\r\nStatus&nbsp;&nbsp; : [STATUS]<br />\r\n<br />\r\nPriority&nbsp; :&nbsp; [PRIORITY]<br />\r\n<br />\r\nCategory&nbsp; : [CATEGORY]<br />\r\n<br />\r\nDays : [DAYS]<br />\r\n<br />\r\nHours : [HOURS]<br />\r\n<br />\r\nSolution : [SOLUTION]<br />\r\n<br />\r\nAssign To :&nbsp; [ASSIGNEDTO]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(6, 6, NULL, 'Ticket  has been Assigned to You', 'Ticket  has been Assigned to You on <a class="normallink" target="_blank" href="http://www.eznetcrm.com/erp/admin/">[SITENAME]</a>. <br />\r\nPlease see below  Ticket details : <br />\r\n<br />\r\n<br />\r\nTicket Title            :  [TITLE] <br />\r\n<br />\r\nTicket Status :&nbsp;[STATUS]<br />\r\n<br />\r\nTicket Priority :&nbsp;[PRIORITY]<br />\r\n<br />\r\nSales Person :&nbsp;[ASSIGNEDTO]<br />\r\n<br />\r\nTicket Category      : [CATEGORY]   <br />\r\n<br />\r\nDays :&nbsp;[DAYS]<br />\r\n<br />\r\nHours :&nbsp;[HOURS]<br />\r\n<br />\r\nDescription          : [DESCRIPTION]<br />\r\n<br />\r\nSolution : [SOLUTION]<br />\r\n<br />\r\nCreated Date :&nbsp;[CREATEDON]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(8, 8, NULL, 'New Quote has been Assigned to You', 'New Quote  has been Assigned  on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\nPlease see below his Quote details : <br />\r\n<br />\r\n<br />\r\nQuote Subject          :  [SUBJECT]<br />\r\n<br />\r\nOpportunity/Customer :&nbsp;[CUSTOMERTYPE]<br />\r\n<br />\r\nQuote Stage : [QUOTESTAGE]<br />\r\n<br />\r\nCarrier : [CARRIER]<br />\r\n<br />\r\nSales Person : [ASSIGNEDTO]<br />\r\n<br />\r\nValid till    :  [VALIDTILL]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till', 1),
(7, 7, NULL, 'New quote has been created', 'New quote  has been created on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\nPlease see below the quote details : <br />\r\n<br />\r\nQuote ID          :  [QUOTEID]<br />\r\n<br />\r\nSubject          :  [SUBJECT]<br />\r\n<br />\r\nOpportunity : [OPPORTUNITY]<br />\r\n<br />\r\nType : [CUSTOMERTYPE]<br />\r\n<br />\r\nQuote Stage : [QUOTESTAGE]<br />\r\n<br />\r\nCarrier : [CARRIER]<br />\r\n<br />\r\nValid Till : [VALIDTILL]<br />\r\n<br />\r\nCreated By : [CREATED]<br />\r\n<br />\r\nSales Person : [ASSIGNEDTO]<br />\r\n<br />\r\nAmount : [TOTALAMOUNT]<br />\r\n<br />\r\nPlease <a href="[LINK_URL]">Click here</a> to see full detail of this quote.<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till,CREATED,Opportunity,Total Amount', 1),
(9, 9, NULL, 'Ticket Status', 'Ticket Status with [PARENT] [[PARENTID]] on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\nPlease see below  Ticket details : <br />\r\n<br />\r\n<br />\r\nTicket Title            :  [TITLE]    <br />\r\n<br />\r\nTicket Category      : [CATEGORY]   <br />\r\n<br />\r\nGenerate Date         : [CREATEDON]<br />\r\n<br />\r\nPriority             : [PRIORITY]   <br />\r\n<br />\r\nDescription          : [DESCRIPTION]<br />\r\n<br />\r\nStatus&nbsp;&nbsp; : [STATUS]<br />\r\n<br />\r\nPriority&nbsp; :&nbsp; [PRIORITY]<br />\r\n<br />\r\nCategory&nbsp; : [CATEGORY]<br />\r\n<br />\r\nDays : [DAYS]<br />\r\n&nbsp;<br />\r\n&nbsp;Hours : [HOURS]<br />\r\n<br />\r\nSolution : [SOLUTION]<br />\r\n<br />\r\n&nbsp;Assign To :&nbsp;[ASSIGNEDTO]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(10, 10, NULL, 'New Lead  has been Assigned to You', '[TOTALLEADS] New Lead(s) has been assigned to you on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\nPlease see below Lead details : <br />\r\n<br />\r\nFolder Name :&nbsp;[FOLDERNAME]<br />\r\n<br />\r\n&nbsp;[FOOTER_MESSAGE]', 'Company,Website,Title,Lead Date,Last Contact Date,description,Total Leads,Folder Name', 1),
(11, 11, NULL, 'New Lead  has been created', '[TOTALLEADS] New Lead(s) &nbsp;has been submitted on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\nPlease see below Lead details : <br />\r\n<br />\r\nFolder Name:&nbsp;[FOLDERNAME]<br />\r\n<br />\r\n&nbsp;[FOOTER_MESSAGE]', 'Company,Website,Title,Lead Date,Last Contact Date,description,Total Leads,Folder Name', 1),
(52, 52, NULL, 'Sale Order Approval Status', 'Sales Order has been [ACTION] on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n<br />\r\nPlease see below the Sale Order details : <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nSales Person : [SALES_PERSON]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'ORDER_NUMBER,ACTION,ORDER_DATE,CREATED_BY,ORDER_STATUS,SALES_PERSON', 1),
(51, 51, NULL, 'Sale Quote Approval Status', 'Sales Quote has been [ACTION] on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br /><br />Please see below the Sale Quote details : <br /><br />Quote Number :&nbsp; [QUOTE_NUMBER]<br /><br />Order Date :&nbsp; [ORDER_DATE]<br /><br />Created By : [CREATED_BY]<br /><br />Sales Person : [SALES_PERSON]<br /><br />Order Status :&nbsp; [ORDER_STATUS]<br /><br /><br />[FOOTER_MESSAGE]', 'QUOTE_NUMBER,ACTION,ORDER_DATE,CREATED_BY,ORDER_STATUS,SALES_PERSON', 1),
(53, 53, NULL, 'Sales Quote has been assigned to you on', 'Hi [SALES_PERSON],<br />\r\n<br />\r\nFollowing Sales Quote has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'SALES_PERSON,QUOTE_NUMBER,ORDER_DATE,CREATED_BY,ORDER_STATUS', 1),
(54, 54, NULL, 'Sales Order has been assigned to you', 'Hi [SALES_PERSON],<br />\r\n<br />\r\nFollowing Sales Order has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'SALES_PERSON,ORDER_NUMBER,ORDER_DATE,CREATED_BY,ORDER_STATUS', 1),
(55, 55, NULL, 'New Sales Quote Created', 'New Sales Quote has been created on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By :&nbsp; [CREATED_BY]<br />\r\n<br />\r\nSales Person : [SALES_PERSON]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nComments :&nbsp; [COMMENT]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'QUOTE_NUMBER,ORDER_DATE,CREATED_BY,SALES_PERSON,ORDER_STATUS,COMMENT', 1),
(56, 56, NULL, 'New Sales Order Created', 'New Sales Order has been created on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By :&nbsp; [CREATED_BY]<br />\r\n<br />\r\nSales Person : [SALES_PERSON]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nComments :&nbsp; [COMMENT]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'ORDER_NUMBER,ORDER_DATE,CREATED_BY,SALES_PERSON,ORDER_STATUS,COMMENT', 1),
(57, 57, NULL, 'Sales Quote', 'Hi [CUSTOMER_NAME],<br />\r\n<br />\r\nPlease find the attached Sales Quote send by <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nApproved : [APPROVED]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'CUSTOMER_NAME,QUOTE_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', 1),
(58, 58, NULL, 'Sales Order', 'Hi [CUSTOMER_NAME],<br />\r\n<br />\r\nPlease find the attached Sales Order send by <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nApproved : [APPROVED]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'CUSTOMER_NAME,ORDER_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', 1),
(59, 59, NULL, 'Credit Memo', 'Hi [CUSTOMER_NAME],<br />\r\n<br />\r\nPlease find the attached Credit Memo send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nCredit Memo Number :&nbsp; [CREDIT_MEMO_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nApproved : [APPROVED]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'CUSTOMER_NAME,CREDIT_MEMO_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', 1),
(64, 64, NULL, 'New Purchase Order Created', 'New Purchase Order has been created on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By :&nbsp; [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nComments :&nbsp; [COMMENT]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'ORDER_NUMBER,ORDER_DATE,CREATED_BY,ORDER_STATUS,COMMENT', 1),
(69, 69, NULL, 'Credit Memo', 'Hi [VENDOR_NAME],<br />\r\n<br />\r\nPlease find the attached Credit Memo send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nCredit Memo Number :&nbsp; [CREDIT_MEMO_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nApproved : [APPROVED]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,CREDIT_MEMO_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', 1),
(67, 67, NULL, 'Purchase Quote', 'Hi [VENDOR_NAME],<br />\r\n<br />\r\nPlease find the attached Purchase Quote send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nApproved : [APPROVED]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,QUOTE_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', 1),
(68, 68, NULL, 'Purchase Order', 'Hi [VENDOR_NAME],<br />\r\n<br />\r\nPlease find the attached Purchase Order send by <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nApproved : [APPROVED]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,ORDER_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', 1),
(66, 66, NULL, 'Purchase Order has been assigned to you', 'Hi [USER_NAME],<br />\r\n<br />\r\nFollowing Purchase Order has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'USER_NAME,ORDER_NUMBER,ORDER_DATE,CREATED_BY,ORDER_STATUS', 1),
(65, 65, NULL, 'Purchase Quote has been assigned to you', 'Hi [USER_NAME],<br />\r\n<br />\r\nFollowing Purchase Quote has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'USER_NAME,QUOTE_NUMBER,ORDER_DATE,CREATED_BY,ORDER_STATUS', 1),
(61, 61, NULL, 'Purchase Quote Approval Status', 'Purchase Quote has been [ACTION] on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'QUOTE_NUMBER,ACTION,ORDER_DATE,CREATED_BY,ORDER_STATUS', 1),
(62, 62, NULL, 'Purchase Order Approval Status', 'Purchase Order has been [ACTION] on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n<br />\r\nOrder Number :&nbsp; [ORDER_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By : [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'ORDER_NUMBER,ACTION,ORDER_DATE,CREATED_BY,ORDER_STATUS', 1),
(63, 63, NULL, 'New Purchase Quote Created', 'New Purchase Quote has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n<br />\r\nQuote Number :&nbsp; [QUOTE_NUMBER]<br />\r\n<br />\r\nOrder Date :&nbsp; [ORDER_DATE]<br />\r\n<br />\r\nCreated By :&nbsp; [CREATED_BY]<br />\r\n<br />\r\nOrder Status :&nbsp; [ORDER_STATUS]<br />\r\n<br />\r\nComments :&nbsp; [COMMENT]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'QUOTE_NUMBER,ORDER_DATE,CREATED_BY,ORDER_STATUS,COMMENT', 1),
(71, 71, 'RMA Close', 'RMA has been closed', 'Dear [CUSTOMER], <br />\r\n<br />\r\n<br />\r\nYour RMA# [RMA_NUMBER] has been closed on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nRMA Number# :[RMA_NUMBER]<br />\r\n<br />\r\nExpiry Date : [EXPIRY_DATE]<br />\r\n<br />\r\nRMA Date : [RMA_DATE]<br />\r\n<br />\r\nInvoice Number# : [INVOICE_NUMBER]<br />\r\n<br />\r\nInvoice Date : [INVOICE_DATE]<br />\r\n<br />\r\nCustomer : [CUSTOMER]<br />\r\n<br />\r\nAmount : [AMOUNT]<br />\r\n<br />\r\nCurrency : [CURRENCY]<br />\r\n<br />\r\nRMA Status : [RMA_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'CUSTOMER_NAME,RMA_NUMBER,EXPIRY_DATE,RMA_DATE,INVOICE_NUMBER,INVOICE_DATE,CUSTOMER,AMOUNT,CURRENCY,RMA_STATUS', 1),
(72, 72, 'RMA Close', 'RMA has been closed', 'Dear [VENDOR_NAME], <br />\r\n<br />\r\n<br />\r\nYour RMA# [RMA_NUMBER] has been closed on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nRMA Number# : [RMA_NUMBER]<br />\r\n<br />\r\nExpiry Date : [EXPIRY_DATE]<br />\r\n<br />\r\nRMA Date : [RMA_DATE]<br />\r\n<br />\r\nInvoice Number# : [INVOICE_NUMBER]<br />\r\n<br />\r\nInvoice Date : [INVOICE_DATE]<br />\r\n<br />\r\nVendor : [VENDOR]<br />\r\n<br />\r\nAmount : [AMOUNT]<br />\r\n<br />\r\nCurrency : [CURRENCY]<br />\r\n<br />\r\nRMA Status : [RMA_STATUS]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'VENDOR_NAME,RMA_NUMBER,EXPIRY_DATE,RMA_DATE,INVOICE_NUMBER,INVOICE_DATE,VENDOR,AMOUNT,CURRENCY,RMA_STATUS', 1),
(75, 75, NULL, 'Customer Cash Receipt', 'Hi [CUSTOMER_NAME],<br /><br />Please find the attached cash receipt send by <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br /><br />Invoice Number  # : [INVOICE_NUMBER] <br /><br />Payment Date :&nbsp; [PAYMENT_DATE] <br /><br />Payment Status :&nbsp; [PAYMENT_STATUS] <br /><br />SO/Reference Number :&nbsp; [REFRENCE_NUMBER] <br /><br />Message : [MESSAGE] <br /><br /><br />[FOOTER_MESSAGE]', 'CUSTOMER_NAME,INVOICE_NUMBER,PAYMENT_DATE,PAYMENT_STATUS,REFRENCE_NUMBER,MESSAGE', 1),
(76, 76, NULL, 'Vendor Payment Receipt', 'Hi [VENDOR_NAME],<br />\r\n<br />\r\nPlease find the attached payment receipt send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nInvoice Number  # : [INVOICE_NUMBER] <br />\r\n<br />\r\nPayment Date :&nbsp; [PAYMENT_DATE] <br />\r\n<br />\r\nPayment Status :&nbsp; [PAYMENT_STATUS] <br />\r\n<br />\r\nPO/Reference Number :&nbsp; [REFRENCE_NUMBER] <br />\r\n<br />\r\nMessage : [MESSAGE] <br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]', 'VENDOR_NAME,INVOICE_NUMBER,PAYMENT_DATE,PAYMENT_STATUS,REFRENCE_NUMBER,MESSAGE', 1),
(60, 60, NULL, 'Invoice', 'Hi [CUSTOMER_NAME],<br />\r\n<br />\r\nPlease find the attached Invoice send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nInvoice Number :&nbsp; [INVOICE_NUMBER]<br />\r\n<br />\r\nInvoice Date :&nbsp; [INVOICE_DATE]<br />\r\n<br />\r\n<br />\r\nInvoice Status :&nbsp; [INVOICE_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'CUSTOMER_NAME,INVOICE_NUMBER,INVOICE_DATE,INVOICE_STATUS,MESSAGE', 1),
(77, 77, NULL, 'Invoice Statement', 'Hi [CUSTOMER_NAME],<br />\r\n<br />\r\nPlease find the Invoice Statement send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\n[INVOICE_DATA]  <br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'CUSTOMER_NAME, INVOICE_DATA', 1),
(78, '78', NULL, 'Purchase RMA', 'Hi [VENDOR_NAME],<br /> <br /> Please find the attached Purchase RMA send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br /> <br /> RMA Number :&nbsp; [ORDER_NUMBER]<br /> <br /> Order Date :&nbsp; [ORDER_DATE]<br /> <br /> Message :&nbsp; [MESSAGE]<br /> <br /> <br /> [FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,ORDER_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', '1'),
 (79, '79', NULL, 'Sales RMA', 'Hi [VENDOR_NAME],<br /> <br /> Please find the attached Sales RMA send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br /> <br /> RMA Number :&nbsp; [ORDER_NUMBER]<br /> <br /> Order Date :&nbsp; [ORDER_DATE]<br /> <br /> Message :&nbsp; [MESSAGE]<br /> <br /> <br /> [FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,ORDER_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', '1'),
 
(70, 70, NULL, 'Purchase Invoice', 'Hi [VENDOR_NAME],<br />\r\n<br />\r\nPlease find the attached invoice send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nInvoice Number :&nbsp; [INVOICE_NUMBER]<br />\r\n<br />\r\nInvoice Date :&nbsp; [INVOICE_DATE]<br /><br />\r\n\r\nInvoice Status :&nbsp; [INVOICE_STATUS]<br />\r\n<br />\r\nMessage :&nbsp; [MESSAGE]<br />\r\n<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,INVOICE_NUMBER,INVOICE_DATE,INVOICE_STATUS,MESSAGE', 1),

(78, '78', NULL, 'Purchase RMA', 'Hi [VENDOR_NAME],<br /> <br /> Please find the attached Purchase RMA send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br /> <br /> RMA Number :&nbsp; [ORDER_NUMBER]<br /> <br /> Order Date :&nbsp; [ORDER_DATE]<br /> <br /> Message :&nbsp; [MESSAGE]<br /> <br /> <br /> [FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,ORDER_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', '1'),

(79, '79', NULL, 'Sales RMA', 'Hi [VENDOR_NAME],<br /> <br /> Please find the attached Sales RMA send by <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br /> <br /> RMA Number :&nbsp; [ORDER_NUMBER]<br /> <br /> Order Date :&nbsp; [ORDER_DATE]<br /> <br /> Message :&nbsp; [MESSAGE]<br /> <br /> <br /> [FOOTER_MESSAGE]<br type="_moz" />', 'VENDOR_NAME,ORDER_NUMBER,ORDER_DATE,APPROVED,ORDER_STATUS,MESSAGE', '1'),

(80, 80, 'Credit Card Authorize', 'Credit card charge', 'Hi [CARD_HOLDER_NAME],<br />\r\n<br />\r\nAn amount of&nbsp; <b>[TOTAL_AMOUNT]</b>&nbsp; has been charged on your credit card&nbsp;<b> [CARD_NUMBER]&nbsp; </b>for&nbsp;<b> [ORDER_ID] </b>on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n<br />\r\nTransaction ID :&nbsp;  [TRANSACTION_ID]<br />\r\n<br />\r\nTransaction Date :&nbsp;  [TRANSACTION_DATE]<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br />', 'CARD_HOLDER_NAME,TOTAL_AMOUNT,CARD_NUMBER,ORDER_ID,TRANSACTION_ID,TRANSACTION_DATE', 1),

(81, 81, 'Credit Card Void', 'Credit card refund', 'Hi [CARD_HOLDER_NAME],<br />\r\n<br />\r\nAn amount of&nbsp; <b>[TOTAL_AMOUNT]</b>&nbsp; has been refunded on your credit card&nbsp;<b> [CARD_NUMBER]&nbsp; </b>for&nbsp;<b> [ORDER_ID] </b>on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>: <br />\r\n<br />\r\nTransaction ID :&nbsp;  [TRANSACTION_ID]<br />\r\n<br />\r\nTransaction Date :&nbsp;  [TRANSACTION_DATE]<br />\r\n<br />\r\n[FOOTER_MESSAGE]<br />', 'CARD_HOLDER_NAME,TOTAL_AMOUNT,CARD_NUMBER,ORDER_ID,TRANSACTION_ID,TRANSACTION_DATE', 1);



--
-- Dumping data for table `e_customer_group`
--

INSERT INTO `e_customer_group` (`GroupID`, `GroupName`, `GroupCreated`, `Status`) VALUES
(1, 'General', 'default', 'Yes'),
(2, 'Wholesale', 'default', 'Yes');

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
('Yes', 'text', 1, 'Store Settings', 1, 'StoreName', 'EznetStore', '', '', 'Yes', 'Store Name', NULL),
('Yes', 'text', 1, 'Store Settings', 3, 'NotificationEmail', 'info@site.com', '', '', 'Yes', 'Notification Email', 'Email address for Administrator emails.'),
('Yes', 'text', 1, 'Store Settings', 4, 'SupportEmail', 'support@site.com', '', '', 'Yes', 'Support Email', 'Email address for your customer service department.'),
('Yes', 'select', 1, 'Store Settings', 5, 'HttpsUrlEnable', 'No', 'Yes,No', 'No', 'No', 'Https Url Enable', 'Enable Https Url For Checkout Page.'),
('Yes', 'select', 1, 'Store Settings', 6, 'StoreClosed', 'No', 'Yes,No', 'No', 'No', 'Store Down', 'If this is Yes, the store will display a page saying that the store is closed'),
('Yes', 'text', 1, 'Store Settings', 7, 'StoreClosedMessage', 'The store is closed.', '', 'The store is closed', 'No', 'Store Down Message', NULL),
('Yes', 'select', 2, 'Social Settings', 1, 'facebookLikeButtonProduct', 'Yes', 'Yes,No', 'No', 'No', 'Facebook Like Button on a product page', 'The Like button lets users share product pages from your site back to their Facebook profile with one click.'),
('Yes', 'text', 2, 'Social Settings', 2, 'TwitterAccount', '', '', '', 'No', 'Twitter account', 'Twitter account for users to follow after they share content from your website.'),
('Yes', 'select', 2, 'Social Settings', 3, 'TwitterTweetButton', 'Yes', 'Yes,No', 'No', 'No', 'Tweet button on a product page', 'Add this button to your website to let people share content on Twitter without having to leave the page. Promote strategic Twitter accounts at the same time while driving traffic to your website'),
('Yes', 'select', 2, 'Social Settings', 4, 'GooglePlusButton', 'Yes', 'Yes,No', 'No', 'No', ' Post to Google Plus from a product page ', 'Help people share stuff from your website in Google Plus.'),
('Yes', 'test', 1, 'Store Settings', 2, 'CompanyEmail', 'info@site.com', '', '', 'Yes', 'Company Email', NULL),
('Yes', 'text', 4, 'payment_paypalipn', 1, 'paypalipn_business', 'info@site.com', '', '', 'Yes', 'Email address for PayPal', 'PayPal Account ID'),
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
('Yes', 'hidden', 0, 'Discounts', 0, 'DiscountsPromo', 'Yes', '', 'No', 'No', NULL, NULL),
('Yes', 'select', '1', 'Store Settings', '13', 'EnableCurrency', 'Yes', 'Yes,No', 'No', 'No', 'Enable Currency', NULL),
('Yes', 'text', '1', 'Store Settings', '4', 'SupportNumber', '', '', '', 'Yes', 'Support Number', 'Support Number for your customer service department.'),
('Yes', 'json', 6, 'AmazonFilter', 0, 'AmazonFilter', '{"ItemCondition":null,"QuantityFrom":null,"QuantityTo":null,"PriceFrom":null,"PriceTo":null}', '', '', 'No', NULL, 'this is used for amzon listing filter');
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

INSERT INTO `f_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`, `FixedCol`) VALUES
(1, 'Current', 2, 1, 1, 0),
(2, 'Savings', 2, 1, 1, 0),
(3, 'Credit Card', 2, 1, 1, 0),
(4, 'Loan', 2, 1, 1, 0),
(9, 'Other', 2, 1, 2, 0),
(5, 'Cash', 1, 1, 1, 0),
(6, 'Direct Debit', 1, 1, 1, 0),
(7, 'Credit Card', 1, 1, 1, 0),
(8, 'Electronic Transfer', 1, 1, 1, 0),
(13, 'General expenses', 3, 1, 1, 0),
(10, 'Bank charges & interest', 4, 1, 1, 0),
(11, 'Other Income', 4, 1, 1, 0),
(12, 'Sales', 4, 1, 1, 0),
(14, 'Marketing', 3, 1, 1, 0),
(15, 'Rent &amp; Rates', 3, 1, 1, 0),
(16, 'Travel and Entertainment', 3, 1, 1, 0),
(17, 'Insurance', 3, 1, 1, 0),
(18, 'Office costs', 3, 1, 1, 0),
(19, 'Repairs and renewals', 3, 1, 1, 0),
(20, 'Check', 1, 1, 1, 1),
(21, 'Net Banking', 1, 1, 1, 0),
(32, 'Paypal', 1, 1, 1, 1), 
(33, 'Amazon', 1, 1, 1, 1);


CREATE TABLE IF NOT EXISTS `f_spiff` (
 `SpiffID` int(11) NOT NULL AUTO_INCREMENT,
 `GLAccountTo` int(11) NOT NULL,
 `GLAccountFrom` int(11) NOT NULL,
 `PaymentTerm` varchar(100) NOT NULL,
 `PaymentMethod` varchar(100) NOT NULL,
 PRIMARY KEY (`SpiffID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

--
-- Dumping data for table `settings`
--




INSERT INTO `settings` (`visible`, `input_type`, `group_id`, `group_name`, `caption`, `setting_key`, `setting_value`, `options`, `validation`, `dep_id`, `priority`, `FixedCol`) VALUES
('Yes', '', 1, 'Global Settings', 'Account Payable', 'AccountPayable', '', '', 'No', 8, 51, 1),
('Yes', '', 1, 'Global Settings', 'Account Receivable', 'AccountReceivable', '', '', 'No', 8, 16, 1),
('Yes', 'select', 1, 'Global Settings', 'Landed Cost Allocation Method', 'ALLOC_METHOD_P', 'Cost', 'Cost,Weight,Quantity,Volume', 'No', 4, 13, 0),
('Yes', '', 1, 'Global Settings', 'Amazon Account', 'AmazonAccount', '', '', 'No', 8, 26, 1),
('Yes', '', 1, 'Global Settings', 'Amazon / Ebay Fee', 'AmazonEbayFee', '', '', 'No', 8, 28, 1),
('Yes', '', 1, 'Global Settings', 'Contra Account', 'ApContraAccount', '', '', 'No', 8, 55, 1),
('Yes', '', 1, 'Global Settings', 'Gains and Losses', 'ApGainLoss', '', '', 'No', 8, 54, 1),
('Yes', '', 1, 'Global Settings', 'Purchase Returns & Allowances', 'ApReturn', '', '', 'No', 8, 53, 1),
('Yes', '', 1, 'Global Settings', 'Contra Account', 'ArContraAccount', '', '', 'No', 8, 23, 1),
('Yes', '', 1, 'Global Settings', 'Gains and Losses', 'ArGainLoss', '', '', 'No', 8, 22, 1),
('Yes', '', 1, 'Global Settings', 'Sales Returns & Allowances', 'ArReturn', '', '', 'No', 8, 21, 1),
('Yes', 'text', 1, 'Global Settings', 'Calendar Year', 'CalendarYearEndDate', '', '', 'No', 8, 0, 1),
('Yes', 'text', 1, 'Global Settings', 'Calendar Year', 'CalendarYearStartDate', '', '', 'No', 8, 0, 1),
('Yes', 'text', 1, 'Global Settings', 'Fiscal Year', 'Chat_Ideal_Time', '30', '', 'No', 0, 0, 0),
('Yes', '', 1, 'Global Settings', 'Clearing Account', 'ClearingAccountP', '', '', 'No', 4, 1, 1),
('Yes', '', 1, 'Global Settings', 'Cost Of Goods', 'CostOfGoods', '', '', 'No', 8, 12, 1),
('Yes', 'text', 1, 'Global Settings', 'Credit Memo Prefix', 'CRD_P_PREFIX', 'CRD', 'maxlength=10', 'No', 4, 5, 0),
('Yes', 'text', 1, 'Global Settings', 'Credit Start Number', 'CRD_P_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 4, 9, 0),
('Yes', 'text', 1, 'Global Settings', 'Credit Memo Prefix', 'CRD_S_PREFIX', 'CRD', 'maxlength=10', 'No', 7, 5, 0),
('Yes', 'text', 1, 'Global Settings', 'Credit Start Number', 'CRD_S_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 7, 9, 0),
('No', '', 1, 'Global Settings', 'Credit Card Clearing', 'CreditCardFee', '', '', 'No', 8, 13, 1),
('Yes', '', 1, 'Global Settings', 'Ebay Account', 'EbayAccount', '', '', 'No', 8, 27, 1),
('Yes', 'text', 1, 'Global Settings', 'Fiscal Year', 'FiscalYearEndDate', '2016-12-31', '', 'No', 8, 0, 1),
('Yes', 'text', 1, 'Global Settings', 'Fiscal Year', 'FiscalYearStartDate', '2016-01-01', '', 'No', 8, 0, 1),
('Yes', '', 1, 'Global Settings', 'Freight', 'FreightAR', '', '', 'No', 8, 19, 1),
('Yes', '', 1, 'Global Settings', 'Freight Expense', 'FreightExpense', '', '', 'No', 8, 52, 1),
('Yes', '', 1, 'Global Settings', 'Hostbill Fee', 'HostbillFee', '', '', 'No', 8, 29, 1),
('Yes', 'text', 1, 'Global Settings', 'Invoice Prefix', 'INV_P_PREFIX', 'INV', 'maxlength=10', 'No', 4, 4, 0),
('Yes', 'text', 1, 'Global Settings', 'Invoice Start Number', 'INV_P_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 4, 8, 0),
('Yes', 'text', 1, 'Global Settings', 'Invoice Prefix', 'INV_S_PREFIX', 'INV', 'maxlength=10', 'No', 7, 4, 0),
('Yes', 'text', 1, 'Global Settings', 'Invoice Start Number', 'INV_S_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 7, 8, 0),
('Yes', '', 1, 'Global Settings', 'Inventory', 'InventoryAR', '', '', 'No', 8, 11, 1),
('Yes', 'text', 1, 'Global Settings', 'Journal Prefix', 'JOURNAL_NO_PREFIX', 'JN', '', 'No', 8, 1, 0),
('Yes', 'text', 1, 'Global Settings', 'Notification Email', 'Notification_Email', 'notifications@eznetcrm.com', '', 'No', 8, 2, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Automatic Order Approval', 'PO_APPROVE', '0', '', 'No', 4, 1, 0),
('Yes', 'text', 1, 'Global Settings', 'Purchase Order Prefix', 'PO_PREFIX', 'PO', 'maxlength=10', 'No', 4, 3, 0),
('Yes', 'text', 1, 'Global Settings', 'Purchase Order Start Number', 'PO_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 4, 7, 0),
('Yes', '', 1, 'Global Settings', 'POS Account', 'PosAccount', '', '', 'No', 8, 24, 1),
('Yes', '', 1, 'Global Settings', 'POS Fee', 'PosFee', '', '', 'No', 8, 25, 1),
('Yes', 'text', 1, 'Global Settings', 'Purchase Quote Prefix', 'PQ_PREFIX', 'PQ', 'maxlength=10', 'No', 4, 2, 0),
('Yes', 'text', 1, 'Global Settings', 'Purchase Quote Start Number', 'PQ_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 4, 6, 0),
('Yes', '', 1, 'Global Settings', 'Purchase Clearing', 'PurchaseClearing', '', '', 'No', 8, 14, 1),
('Yes', 'text', 1, 'Global Settings', 'PO Receipt Prefix', 'REC_P_PREFIX', 'RECEIPT', 'maxlength=10', 'No', 3, 4, 0),
('Yes', 'text', 1, 'Global Settings', 'PO Receipt Start Number', 'REC_P_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 3, 8, 0),
('Yes', 'text', 1, 'Global Settings', 'Restocking Fee (%)', 'RES_FEE_P', '10', 'maxlength=5 onkeypress="return isDecimalKey(event);"', 'No', 4, 12, 0),
('Yes', 'text', 1, 'Global Settings', 'Restocking Fee (%)', 'RES_FEE_S', '10', 'maxlength=5 onkeypress="return isDecimalKey(event);"', 'No', 7, 12, 0),
('Yes', '', 1, 'Global Settings', 'Retained Earnings', 'RetainedEarning', '', '', 'No', 8, 15, 1),
('Yes', 'text', 1, 'Global Settings', 'RMA Prefix', 'RMA_P_PREFIX', 'RMA', 'maxlength=10', 'No', 4, 5, 0),
('Yes', 'text', 1, 'Global Settings', 'RMA Start Number', 'RMA_P_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 4, 9, 0),
('Yes', 'text', 1, 'Global Settings', 'RMA Prefix', 'RMA_S_PREFIX', 'RMA', 'maxlength=10', 'No', 7, 5, 0),
('Yes', 'text', 1, 'Global Settings', 'RMA Start Number', 'RMA_S_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 7, 9, 0),
('Yes', '', 1, 'Global Settings', 'Sales', 'Sales', '', '', 'No', 8, 17, 1),
('Yes', '', 1, 'Global Settings', 'Sales Discount', 'SalesDiscount', '', '', 'No', 8, 18, 1),
('Yes', '', 1, 'Global Settings', 'Sales Tax Account', 'SalesTaxAccount', '', '', 'No', 8, 20, 1),
('Yes', 'checkbox', 1, 'Global Settings', 'Automatic Order Approval', 'SO_APPROVE', '0', '', 'No', 7, 1, 0),
('Yes', 'text', 1, 'Global Settings', 'Sales Order Prefix', 'SO_PREFIX', 'SO', 'maxlength=10', 'No', 7, 3, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Order Source', 'SO_SOURCE', '0', '', 'No', 7, 13, 0),
('Yes', 'text', 1, 'Global Settings', 'Sales Order Start Number', 'SO_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 7, 7, 0),
('Yes', 'text', 1, 'Global Settings', 'Sales Quote Prefix', 'SQ_PREFIX', 'QT', 'maxlength=10', 'No', 7, 2, 0),
('Yes', 'text', 1, 'Global Settings', 'Sales Quote Start Number', 'SQ_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 7, 6, 0),
('Yes', 'text', 1, 'Global Settings', 'Transfer Payment Prefix', 'TRANSFER_PAYMENT_PREFIX', 'TF', '', 'No', 8, 1, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Opening Stock', 'OpeningStock', '0', '', 'No', 8, 13, 0),
('Yes', '', 1, 'Global Settings', 'Inventory Adjustment', 'InventoryAdjustment', '', '', 'No', 8, 11, 1),
('Yes', 'select', 1, 'Global Settings', 'Default Items Purchase Tax', 'Item_Purchase_Tax', 'yes', 'yes,no', 'No', 6, 8, 0), ('Yes', 'select', 1, 'Global Settings', 'Default Items Sales Tax', 'Item_Sale_Tax', 'yes', 'yes,no', 'No', 6, 8, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Auto Post to GL [Invoice]', 'AutoPostToGlAr', '0', '', 'No', 8, 17, 1),
('Yes', 'checkbox', 1, 'Global Settings', 'Auto Post to GL [Invoice]', 'AutoPostToGlAp', '0', '', 'No', 8, 52, 1),
('Yes', '', 1, 'Global Settings', 'Restocking', 'ArRestocking', '', '', 'No', 8, 24, 1),
('Yes', '', 1, 'Global Settings', 'Restocking', 'ApRestocking', '', '', 'No', 8, 56, 1),
('No', 'hidden', '0', 'Zoom Webinar Settings', 'CRM Zoom Webinar', 'ZOOM_WEBINAR', '0', '', 'No', 5, 1, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Auto Post to GL [Credit Memo]', 'AutoPostToGlArCredit', '0', '', 'No', 8, 17, 1),
('Yes', 'checkbox', 1, 'Global Settings', 'Auto Post to GL [Credit Memo]', 'AutoPostToGlApCredit', '0', '', 'No', 8, 52, 1),
('Yes', 'text', 1, 'Global Settings', 'SO Shipment Prefix', 'SHIP_PREFIX', 'SHIP', 'maxlength=10', 'No', 3, 3, 0),
('Yes', 'text', 1, 'Global Settings', 'SO Shipment Start Number', 'SHIP_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 3, 4, 0),
('Yes', 'text', 1, 'Global Settings', 'Customer RMA Reciept Prefix', 'RMA_C_PREFIX', 'CRMA', 'maxlength=10', 'No', 3, 5, 0),
('Yes', 'text', 1, 'Global Settings', 'Customer RMA Reciept Start Number', 'RMA_C_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 3, 6, 0),
('Yes', 'text', 1, 'Global Settings', 'Vendor RMA Reciept Prefix', 'RMA_V_PREFIX', 'VRMA', 'maxlength=10', 'No', 3, 7, 0),
('Yes', 'text', 1, 'Global Settings', 'Vendor RMA Reciept Start Number', 'RMA_V_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 3, 8, 0),
('Yes', 'text', 1, 'Global Settings', 'Provider Fee (%)', 'POS_PROVIDER_FEE', '10', 'maxlength=3 onkeypress="return isDecimalKey(event);"', 'No', 12, 1, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Auto Freight Billing', 'AutoFreightBilling', '0', '', 'No', 7, 52, 0),
('Yes', 'text', 1, 'Global Settings', 'Work Order Prefix', 'WO_PREFIX', 'WRK', 'maxlength=10', 'No', 3, 9, 0), 
('Yes', 'text', 1, 'Global Settings', 'Work Order Start Number', 'WO_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 3, 10, 0),
('Yes', 'text', 1, 'Global Settings', 'Picking Prefix', 'PICK_PREFIX', 'PCK', 'maxlength=10', 'No', 3, 11, 0),
('Yes', 'text', 1, 'Global Settings', 'Picking Start Number', 'PICK_START', '1', 'maxlength=10 onkeypress="return isNumberKey(event);"', 'No', 3, 12, 0),
('Yes', 'text', '1', 'Global Settings', 'Tax Caption', 'TAX_CAPTION', 'Tax', 'maxlength=20', 'No', '8', '3', '0'),
('Yes', 'checkbox', 1, 'Global Settings', 'Commission', 'CommissionAp', '0', '', 'No', 8, 64, 1),
('Yes', '', 1, 'Global Settings', 'Commissions & Fees Expense', 'CommissionFeeAccount', '', '', 'No', 8, 65, 1),
('Yes', 'select', 1, 'Global Settings', 'Unreconciled Listing From', 'UN_REC_FROM', '6', '', 'No', 8, 13, 0),
('Yes', 'select', 1, 'Global Settings', 'Allow Po from so (EDI)', 'EDI_PO_SO', 'no', 'yes,no', 'No', 4, 8, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Taxable On', 'TaxableBilling', '0', '', 'No', 7, 55, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Taxable On', 'TaxableBillingAp', '0', '', 'No', 4, 20, 0),
('Yes', 'checkbox', 1, 'Global Settings', 'Spiff Display', 'SpiffDisplay', '0', '', 'No', 7, 60, 0);

--
-- Dumping data for table `f_account`
--


INSERT INTO `f_account` (`BankAccountID`, `BankName`, `AccountName`, `AccountNumber`, `AccountCode`, `AccountType`, `RangeFrom`, `RangeTo`, `BankAccountNumber`, `BankFlag`, `NextCheckNumber`, `Address`, `Currency`, `Status`, `OrderBy`, `IPAddress`, `CreatedDate`, `UpdateddDate`, `CashFlag`, `GroupID`, `DefaultAccount`, `AdminID`, `AdminType`, `BankCurrency`, `AccountGainLoss`) VALUES
(2, '', 'Accounts Payable', '2000-00', '', 'Liability Account', 2000, 2999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 4, 0, '', '', '', 0),
(3, '', 'Accounts Receivable', '1200-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(4, '', 'Cash On Hand', '1010-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(5, '', 'Savings', '1023-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(6, 'Regions', 'Current', '1022-00', '', 'Asset Account', 1000, 1999, '0171148655', 1, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(7, '', 'Credit Card', '1030-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(8, '', 'Inventory', '1400-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(9, '', 'Cost Of Goods', '5000-00', '', 'Cost Of Goods', 5000, 5999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(10, '', 'Purchase Clearing', '2001-00', '', 'Liability Account', 2000, 2999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 4, 0, '', '', '', 0),
(11, '', 'Credit Card Clearing', '1800-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(12, '', 'Sales Discount', '4700-00', '', 'Revenue Account', 4000, 4999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(13, '', 'Sales Tax Account', '2400-00', '', 'Liability Account', 2000, 2999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 4, 0, '', '', '', 0),
(14, '', 'Contra Account', '1000-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(15, '', 'Sales Returns & Allowances', '5000-01', '', 'Cost Of Goods', 5000, 5999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(16, '', 'Purchase Returns & Allowances', '5000-02', '', 'Cost Of Goods', 5000, 5999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(17, '', 'Freight Expense', '6220-01', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(19, '', 'Other Income', '7010-00', '', 'Other Revenue', 7000, 7999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(24, '', 'Other Expense', '8000-00', '', 'Other Expense', 8000, 8999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-02', '2015-09-03', 0, 0, 0, '', '', '', 0),
(26, '', 'Freight', '6220-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(30, '', 'Sales', '4000-00', '', 'Revenue Account', 4000, 4999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(35, '', 'Building', '1520-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(36, '', 'Paypal', '1051-00', '', 'Asset Account', 1000, 1999, '', 1, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(37, '', 'Paypal Fees', '6375-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(38, '', 'Computer', '1510-00', '', 'Asset Account', 1000, 1999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 1, 0, '', '', '', 0),
(40, '', 'Capital Stock', '3000-00', '', 'Equity Account', 3000, 3999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(41, '', 'Advertising Expense', '6020-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(42, '', 'Office Expense', '6040-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(43, '', 'Credit Card Service Expense', '6140-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(44, '', 'Internet Expense', '6280-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(45, '', 'License & Reg Exp', '6330-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(46, '', 'Merchant Account Fee', '6370-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(47, '', 'Penalties & Fines Exp', '6400-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(48, '', 'Computer Supplies', '6520-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(49, '', 'Computer Software Exp', '6525-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(50, '', 'Tech Room Expense', '6540-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(51, '', 'Telephone & Cellular Exp', '6550-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(53, '', 'Retained Earnings', '3200-00', '', 'Equity Account', 3000, 3999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0),
(55, '', 'Commissions & Fees Expense', '6130-00', '', 'Expense Account', 6000, 6999, '', 0, '', '', 'USD', 'Yes', 0, '127.0.0.1', '2015-09-01', '2015-09-03', 0, 0, 0, '', '', '', 0);


--
-- Dumping data for table `f_accounttype`
--

INSERT INTO `f_accounttype` (`AccountTypeID`, `AccountType`, `RangeFrom`, `RangeTo`, `ReportType`, `Description`, `Status`, `flag`, `CreatedDate`, `OrderBy`, `UpdatedDate`) VALUES (1, 'Asset Account', 1000, 1999, 'BS', '', 'Yes', 0, '2015-08-12', 0, '2015-08-12'), (2, 'Liability Account', 2000, 2999, 'BS', '', 'Yes', 0, '2015-08-12', 0, '2015-08-12'), (3, 'Equity Account', 3000, 3999, 'BS', '', 'Yes', 0, '2015-08-12', 0, '2015-08-12'), (4, 'Revenue Account', 4000, 4999, 'PL', '', 'Yes', 0, '2015-08-12', 1, '2015-08-12'), (5, 'Cost Of Goods', 5000, 5999, 'PL', '', 'Yes', 0, '2015-08-12', 3, '2015-08-12'), (6, 'Expense Account', 6000, 6999, 'PL', '', 'Yes', 0, '2015-08-12', 0, '2015-08-12'), (7, 'Other Revenue', 7000, 7999, 'PL', '', 'Yes', 0, '2015-08-12', 2, '2015-08-12'), (8, 'Other Expense', 8000, 8999, 'PL', '', 'Yes', 0, '2015-08-12', 0, '2015-08-12');



INSERT INTO `f_term` (`termID`, `termName`, `Status`, `termType`, `fixed`) VALUES
(1, 'Electronic Transfer', 1, 0, 0),
(2, 'Credit Card',1, 1, 1),
(3, 'PayPal', 1, 1, 1),
(4, 'Amazon', 1, 1, 1),
(5, 'PrePayment', 1, 1, 1),
(6, 'Check', 1, 1, 1),
(7, 'End of Month', 1, 1, 1);

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
(4, 'Deductions - D', 'D', 0, '0000-00-00'),
(5, 'Additions - E', 'E', 0, '0000-00-00');

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

INSERT INTO `inv_attribute_value` (`attribute_value`, `attribute_id`, `editable`, `Status`, `locationID`) VALUES
('LBS', 11, 1, 0, 1),
('Non Kit', 1, 0, 1, 1),
('Kit', 1, 0, 1, 1),
('SALE', 2, 0, 1, 1),
('MAKE', 2, 0, 1, 1),
('FIFO', 3, 0, 1, 1),
('LIFO', 3, 0, 1, 1),
('Serialized', 3, 0, 1, 1),
('EA', 11, 1, 1, 1),
('Customer Return', 13, 1, 1, 1),
('Box', 11, 1, 1, 1),
('Damaged', 13, 1, 1, 1),
('Outdated', 13, 1, 1, 1),
('Missing', 13, 1, 1, 1),
('PURCHASE', 2, 0, 1, 1),
('Lost', 13, 1, 1, 2),
('Average', 3, 0, 1, 1),
('Serialized Average', 3, 0, 1, 1),
( 'Economic qty', 9, 1, 1, 1),
( 'Max qty', 9, 1, 1, 1),
( 'Reorder Level', 9, 1, 1, 1);

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
(21, 'Closed', 5, 0, 1),
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
(4, 'OrderType', 'Order Type'),
(5, 'OrderSource', 'Order Source');

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
(17, 'Online Bank Transfer', 1, 1, 1),
(18, 'Amazon', 5, 1, 1),
(19, 'Ebay', 5, 1, 1);

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
(5, 'OrdStatus', 'Order Status'),
(6, 'ShippingMethod', 'Shipping Carrier'),
(7, 'RMAReason', 'RMA Reason');

--
-- Dumping data for table `w_attribute_value`
--

INSERT INTO `w_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`, `FixedCol`) VALUES
(1, 'Postpaid', 4, 1, 1, 0),
(2, 'Prepaid', 4, 1, 1, 0),
(3, 'Truck', 1, 1, 1, 0),
(4, 'Car', 1, 1, 1, 0),
(5, 'Pallet', 2, 1, 1, 0),
(6, 'Case', 2, 1, 1, 0),
(7, '100', 3, 1, 1, 0),
(8, '200', 3, 1, 1, 0),
(9, 'Train', 1, 1, 1, 0),
(10, 'Cartton', 2, 1, 1, 0),
(11, 'DHL', 6, 1, 1, 1),
(12, 'UPS', 6, 1, 1, 1),
(13, 'USPS', 6, 1, 1, 1),
(14, 'Fedex', 6, 1, 1, 1),
(15, 'Customer Pickup', 6, 0, 1, 1);

INSERT INTO `w_status_attribute` (`id`, `Status`, `Status_Name`) VALUES
(1, 0, 'parked'),
(2, 1, 'cancelled'),
(5, 2, 'completed');

INSERT ignore INTO `w_warehouse` (`WID`, `warehouse_name`, `warehouse_code`, `Status`) VALUES ('1', 'Default Warehouse', 'W00001', '1');

INSERT ignore INTO `w_binlocation` (`binid`, `warehouse_id`, `binlocation_name`, `status`) VALUES ('1', '1', 'Default Bin', '1');


 
CREATE TABLE IF NOT EXISTS `w_receiptpo` (
  `ReceiptID` int(11) NOT NULL AUTO_INCREMENT,
  `AutoID` bigint(40) NOT NULL,
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
  `SuppCode` varchar(50) NOT NULL,
  `SuppCompany` varchar(50) NOT NULL,
  `SuppContact` varchar(50) NOT NULL,
  `SuppCurrency` varchar(10) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `City` varchar(40) NOT NULL,
  `State` varchar(40) NOT NULL,
  `Country` varchar(40) NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
  `Mobile` varchar(20) NOT NULL,
  `Landline` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `wCode` varchar(250) NOT NULL,
  `wName` varchar(100) NOT NULL,
  `wAddress` varchar(250) NOT NULL,
  `wCity` varchar(40) NOT NULL,
  `wState` varchar(40) NOT NULL,
  `wCountry` varchar(40) NOT NULL,
  `wZipCode` varchar(20) NOT NULL,
  `wContact` varchar(20) NOT NULL,
  `wMobile` varchar(20) NOT NULL,
  `wLandline` varchar(20) NOT NULL,
  `wEmail` varchar(50) NOT NULL,
  `Taxable` varchar(250) NOT NULL,
  `TaxRate` varchar(250) NOT NULL,
  `OrderType` varchar(100) NOT NULL,
  `TotalReceiptAmount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Freight` decimal(20,2) NOT NULL DEFAULT '0.00',
  `taxAmnt` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Restocking_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ReStocking` varchar(5) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `AdminID` int(11) NOT NULL DEFAULT '0',
  `AdminType` varchar(10) NOT NULL,
  `PostedDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
 `IPAddress` varchar(20) NOT NULL,
  `PdfFile` varchar(200) NOT NULL,
  PRIMARY KEY (`ReceiptID`),
  KEY `SaleID` (`SaleID`),
  KEY `Module` (`Module`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



CREATE TABLE IF NOT EXISTS `w_receiptpo_item` (
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
  `Type` varchar(50) NOT NULL,
  `Action` varchar(50) NOT NULL,
  `Reason` varchar(50) NOT NULL,
  `Condition` varchar(50) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `Restocking_fee` decimal(10,2) NOT NULL,
  `Restocking` varchar(5) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reconciled` (`reconciled`),
  KEY `OrderID` (`OrderID`),
  KEY `ReceiptID` (`ReceiptID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;


CREATE TABLE IF NOT EXISTS `w_rma_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `w_rma_action_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(100) NOT NULL,
  `name_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `w_rma_action_value` (`id`, `action`, `name_id`) VALUES
(2, 'Scrap', 7),
(8, 'Return', 15),
(9, 'Repair', 7);


CREATE TABLE IF NOT EXISTS `w_picking` (
  `pid`  int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  `CreatDate` date NOT NULL,
   PRIMARY KEY (`pid`),
  KEY `AdminID` (`AdminID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `emails` (`templateID`, `depID`, `Type`, `Title`, `Note`, `Important`, `Subject`, `Content`, `UpdatedDate`, `OrderBy`, `Status`) VALUES
(1, 1, 'BIRTHDAY', 'Birthday Anniversary', 'This template will be used to send email for Birthday Anniversaries.', '[NAME]', 'Wishing you a Very Happy Birthday11', '<div style="text-align: center;"><span style="color: rgb(255, 102, 0);"><span style="font-size: x-large;"><span style="color: rgb(255, 0, 255);">Dear [NAME],<br />\r\n<br />\r\nWishing you a very Happy Birthday !!!<br />\r\n<br />\r\n<img src="http://www.designsnext.com/wp-content/uploads/2014/04/happy-birthday-best-chocolate-cakes-for-wishes.jpg" alt="" /> &nbsp;<br />\r\n<br />\r\nWith lots of wishes<br />\r\nTEAM ERP</span></span><br />\r\n</span></div>', '2014-06-30 08:53:10', 0, 1),
(2, 1, 'JOINING', 'Joining Anniversary', 'This template will be used to send email for Joining Anniversaries.', '[NAME]', 'Wishing you a Happy Joining Anniversary', '<span style="font-size: xx-large;"><span style="color: rgb(128, 0, 0);">Dear [NAME],<br />\r\n<br />\r\nWishing you a very happy and warm joining anniversary!!!<br />\r\n<br />\r\n<img alt="" src="http://www.pictures88.com/p/anniversary/anniversary_069.jpg" /> <br />\r\n<br />\r\nWith Best Wishes<br />\r\nTeam ERP</span></span><br />', '2014-06-27 17:10:13', 0, 1),
(3, 1, 'MARRIAGE', 'Marriage Anniversary', 'This template will be used to send email for Marriage Anniversaries.', '[NAME]', 'Wishing you a Happy Marriage Anniversary', '<span style="color: rgb(255, 0, 0);"><span style="font-size: xx-large;">Dear [NAME],  Wishing you a very Happy Marriage Anniversary !!!  </span></span><span style="font-size: xx-large;"><span style="color: rgb(51, 153, 102);"><br />\r\n<br />\r\n</span></span><img src="http://www.indusladies.com/forums/attachments/anniversary/109101d1297932231-happy-1st-wedding-anniversary-raga-103033.gif" alt="http://www.indusladies.com/forums/attachments/anniversary/109101d1297932231-happy-1st-wedding-anniversary-raga-103033.gif" class="decoded" /><br />\r\n<br />\r\n<br />\r\n<span style="font-size: xx-large;"><span style="color: rgb(255, 0, 0);">With lots of wishes  TEAM ERP</span></span>', '0000-00-00 00:00:00', 0, 0);




CREATE TABLE IF NOT EXISTS `c_callquota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) DEFAULT '1',
  `user_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `duration` enum('month','quarter','year','day','week') NOT NULL DEFAULT 'month',
  `q_time` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','pendding','complete') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `c_callUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL COMMENT 'elastix user',
  `password` varchar(255) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `type` enum('employee','admin') NOT NULL DEFAULT 'employee',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_site` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

CREATE TABLE IF NOT EXISTS `c_call_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1  ;



CREATE TABLE IF NOT EXISTS `inv_variant_manageOption` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `variant_name_id` int(11) NOT NULL,
  `option_value` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `inv_variant_type` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `field_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `inv_variant_type` (`id`, `field_name`, `status`) VALUES
(1, 'Text Field', 1),
(2, 'Text Area', 1),
(4, 'Multiple Select', 1),
(5, 'Dropdown', 1),
(6, 'Price', 1),
(7, 'Fixed Product Tax', 1);


CREATE TABLE IF NOT EXISTS `inv_variant_value` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `variant_type_id` int(11) NOT NULL,
  `variant_name` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `c_quote_item_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `quote_item_ID` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `variantID` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `inv_mergeitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ItemID` int(11) NOT NULL,
  `Sku` varchar(50) NOT NULL,
  `ParentCondition` varchar(100) NOT NULL,
  `ParentPrice` float(10,2) NOT NULL,
  `AvgCost` float(10,2) NOT NULL,
  `TotalCost` float(10,2) NOT NULL,
  `ParentValuationType` varchar(100) NOT NULL,
  `serial_Num` text NOT NULL,
  `CreateDate` date NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_id` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
CREATE TABLE IF NOT EXISTS `inv_mergesubitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `RefID` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `SubCondition` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float(10,2) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `serial` text NOT NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `c_quote_item_variantOptionValues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_item_ID` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `variantID` int(11) NOT NULL,
  `variantOPID` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `e_template` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TemplateId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `e_template` (`Id`, `TemplateId`) VALUES ('1', '2');

CREATE TABLE IF NOT EXISTS `e_slider_banner` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Slider_image` varchar(200) NOT NULL,
  `Content` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL,
  `Priority` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `e_social_links` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Social_media_id` int(11) NOT NULL,
  `URL` varchar(200) NOT NULL,
  `Priority` int(11) NOT NULL,
  `Status` enum('Yes','No') NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `social_media_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `social_media_list` (`id`, `name`, `icon`) VALUES
(1, 'Facebook', 'facebook.png'),
(2, 'Myspace', 'myspace.png'),
(3, 'Twitter', 'twitter.png'),
(4, 'LinkedIn', 'linkedin.png'),
(5, 'Bebo', 'bebo.png'),
(6, 'Friendster', 'friendster.png'),
(7, 'Hi5', 'hi5.png'),
(8, 'Habbo', 'habbo.png'),
(9, 'Ning', 'ning.png'),
(10, 'Classmates', 'classmates.png'),
(11, 'Tagged', 'tagged.png'),
(12, 'myYearbook', 'myyearbook.png'),
(13, 'Meetup', 'meetup.png'),
(14, 'MyLife', 'mylife.png'),
(15, 'Flixster', 'flixster.png'),
(16, 'MyHeritage', 'myheritage.png'),
(17, 'Multiply', 'multiply.png'),
(18, 'Orkut', 'orkut.png'),
(19, 'Badoo', 'badoo.png'),
(20, 'Gaia Online', 'gaiaonline.png'),
(21, 'BlackPlanet', 'blackplanet.png'),
(22, 'SkyRock', 'skyrock.png'),
(23, 'PerfSpot', 'perfspot.png'),
(24, 'Zorpia', 'zorpia.png'),
(25, 'Netlog', 'netlog.png'),
(26, 'Tuenti', 'tuenti.png'),
(27, 'Nasza-Klasapl', 'nk.png'),
(28, 'IRC Gallery', 'iRCgallery.png'),
(29, 'StudiVZ', 'studiVZ.png'),
(30, 'Xing', 'xing.png'),
(31, 'Renren', 'renren.png'),
(32, 'Kaixin001', 'kaixin001.png'),
(33, 'Hyves', 'hyves.png'),
(34, 'Ibibo', 'ibibo.png'),
(35, 'Sonico', 'sonico.png'),
(36, 'Wer-kennt-wen', 'wkw.png'),
(37, 'Cyworld', 'cyworld.png'),
(38, 'Mixi', 'mixi.png'),
(39, 'iWiW', 'iWiW.png'),
(40, 'Googleplus', 'googleplus.png'),
(41, 'Tumbler', 'tumblr.png'),
(42, 'Reddit', 'reddit.png'),
(43, 'VK', 'vkontakte.png'),
(44, 'Flickr', 'flickr.png'),
(45, 'Vine', 'vinevimeo.png'),
(46, 'Meetup', 'meetup.png'),
(47, 'Ask.fm', 'ask.fm.png');


CREATE TABLE IF NOT EXISTS `e_group_discount` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `GroupDiscount` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `e_item_alias` (
  `AliasID` int(20)  NOT NULL AUTO_INCREMENT ,
  `ItemAliasCode` varchar(100) NOT NULL,
  `ProductSku` varchar(30) NOT NULL,
  `VendorCode` varchar(30) NOT NULL,
  `ProductID` int(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `AliasType` varchar(30) NOT NULL,
  `Manufacture` varchar(50) NOT NULL,
    PRIMARY KEY (`AliasID`),
 KEY `ProductSku` (`ProductSku`),
 KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `e_settings` (`visible`, `input_type`, `GroupID`, `GroupName`, `Priority`, `Name`, `Value`, `Options`, `DefaultValue`, `Validation`, `Caption`, `Description`) VALUES
('Yes', 'textarea', 1, 'Google Analytics', 16, 'GoogleAnalytics', '', '', '', 'No', 'Google Analytics', NULL),
('Yes', 'stextarea', 1, 'Domain Redirection', 15, 'DRedirect', '', '', '', 'No', 'Domain Redirection', NULL),
('Yes', 'text', 1, 'Default Quantity ', 16, 'DefaultOQantity', '8', '', '', 'No', 'Default Quantity ', NULL),
('Yes', 'text', 4, 'payment_paypalpro', 3, 'paypalpro_Username', 'sdk-three_api1.sdk.com', '', '', 'No', 'Username', NULL),
('Yes', 'text', 4, 'payment_paypalpro', 4, 'paypalpro_APIPassword', 'QFZCWN5HZM8VBG7Q', '', '', 'No', 'API Password', NULL),
('Yes', 'text', 4, 'payment_paypalpro', 5, 'paypalpro_APISignature', 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI', '', '', 'No', 'API Signature', NULL),
('Yes', 'select', 4, 'payment_paypalpro', 1, 'paypalpro_Mode', 'TEST', 'LIVE, TEST', '', 'No', 'Payment Mode', NULL),
('Yes', 'select', 4, 'payment_paypalpro', 2, 'paypalpro_Currency_Code', 'USD', 'AUD, BRL, CAD, CHF, CZK, DKK, EUR, GBP, HKD, HUF, ILS, JPY, MXN, MYR, NOK, NZD, PHP, PLN, SEK, SGD, THB, TRY, TWD, USD', 'USD', 'No', 'Currency Code ', NULL);


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `e_payment_gateway` (`PaymentID`, `PaymentMethodName`, `PaymetMethodId`, `PaymentMethodUrl`, `PaymetMethodType`, `PaymentMethodTitle`, `PaymentMethodMessage`, `Priority`, `PaymentMethodDescription`, `Status`, `PaymentCofigure`) VALUES
(10, 'PayPal Pro', 'paypalpro', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=', '', 'Paypal Pro', '&nbsp;', 4, '&nbsp;', 'Yes', 'Yes');



CREATE TABLE IF NOT EXISTS `web_articles` (
  `ArticleId` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `Introtext` mediumtext,
  `Fulltext` mediumtext,
  `CatId` int(11) DEFAULT '0',
  `Status` enum('Yes','No') DEFAULT NULL,
  `Priority` int(11) DEFAULT '0',
  `Added_date` datetime DEFAULT NULL,
  `FormId` varchar(45) DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`ArticleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;




CREATE TABLE IF NOT EXISTS `web_categories` (
  `CatId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `Status` enum('Yes','No') DEFAULT NULL,
  `Added_date` datetime DEFAULT NULL,
  PRIMARY KEY (`CatId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;



CREATE TABLE IF NOT EXISTS `web_forms` (
  `FormId` int(11) NOT NULL AUTO_INCREMENT,
  `FormName` varchar(200) NOT NULL,
  `Status` enum('Yes','No') NOT NULL,
  `Added_Date` datetime NOT NULL,
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`FormId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `web_forms` (`FormId`, `FormName`, `Status`, `Added_Date`) VALUES
(1, 'Contact', 'Yes', '2015-06-30 15:14:26'),
(2, 'Career', 'Yes', '2015-06-30 15:14:33');



CREATE TABLE IF NOT EXISTS `web_forms_fields` (
  `FieldId` int(11) NOT NULL AUTO_INCREMENT,
  `FormId` int(11) NOT NULL,
  `FieldName` varchar(100) NOT NULL,
  `Fieldlabel` varchar(100) NOT NULL,
  `Fieldvalues` text NOT NULL,
  `FieldType` varchar(200) NOT NULL,
  `Manadatory` enum('Yes','No') NOT NULL,
  `Priority` int(11) NOT NULL DEFAULT '0',
  `Status` enum('Yes','No') NOT NULL,
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`FieldId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



INSERT INTO `web_forms_fields` (`FieldId`, `FormId`, `FieldName`, `Fieldlabel`, `Fieldvalues`, `FieldType`, `Manadatory`, `Priority`, `Status`) VALUES
(1, 1, 'days', 'Days', 'Mon,Tues,Wed', 'checkbox', 'Yes', 5, 'Yes'),
(2, 1, 'email', 'Email', '', 'email', 'Yes', 2, 'Yes'),
(3, 1, 'contact_type', 'Contact Type', 'HR,Meeting,Product,Jobs,Official', 'dropdown', 'Yes', 2, 'Yes'),
(4, 1, 'sex', 'Sex', 'Male,Female', 'radio', 'Yes', 4, 'Yes'),
(6, 1, 'file', 'File', '', 'file', 'No', 6, 'Yes'),
(7, 1, 'comments', 'Comments', '', 'textarea', 'Yes', 7, 'Yes'),
(8, 1, 'name', 'Name', '', 'textbox', 'Yes', 1, 'Yes');





CREATE TABLE IF NOT EXISTS `web_form_data` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FormId` int(11) NOT NULL,
  `FieldId` int(11) NOT NULL,
  `FieldValue` text NOT NULL,
  `Added_date` datetime NOT NULL,
  `Added_no` int(11) DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;




CREATE TABLE IF NOT EXISTS `web_menus` (
  `MenuId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Link` varchar(200) DEFAULT NULL,
  `MetaKeywords` text,
  `MetaTitle` text,
  `MetaDescription` text,
  `Alias` varchar(255) NOT NULL DEFAULT '',
  `ParentId` int(11) DEFAULT '0',
  `MenuTypeId` int(11) DEFAULT '1',
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`MenuId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



INSERT INTO `web_menus` (`MenuId`, `Priority`, `Status`, `Name`, `Link`, `MetaKeywords`, `MetaTitle`, `MetaDescription`, `Alias`, `ParentId`, `MenuTypeId`) VALUES
(1, 1, 'Yes', 'About Us', '1', 'About Us', 'About Us', 'About Us', 'about_us', 0, 1),
(2, 2, 'Yes', 'Services', '2', 'Services', 'Services', 'Services', 'services', 0, 3),
(3, 0, 'Yes', 'Website Design', '2', 'Website Design', 'Website Design', 'Website Design', 'website_design', 2, 3),
(4, 0, 'Yes', 'Web Development', '2', 'Web Development', 'Web Development', 'Web Development', 'web_development', 2, 3),
(5, 3, 'Yes', 'Products', '2', 'Products', 'Products', 'Products', 'products', 0, 1),
(6, 0, 'Yes', ' Support', '2', ' Support', ' Support', ' Support', '_support', 0, 1),
(7, 1, 'Yes', 'Our Service', '2', 'Our Service', 'Our Service', 'Our Service', 'our_service', 0, 2),
(8, 0, 'Yes', 'Contact', '3', 'Contact ', 'Contact ', 'Contact ', 'contact', 0, 2),
(9, 0, 'Yes', 'News', '3', 'News', 'News', 'News', 'events1', 0, 3),
(10, 0, 'Yes', 'Events', '3', 'Events', 'Events', 'Events', 'events', 0, 3);



CREATE TABLE IF NOT EXISTS `web_menutype` (
  `MenuTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `MenuType` varchar(200) DEFAULT NULL,
  `Status` enum('Yes','No') DEFAULT NULL,
  `Editable` enum('Yes','No') DEFAULT 'Yes',
  PRIMARY KEY (`MenuTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;



INSERT INTO `web_menutype` (`MenuTypeId`, `MenuType`, `Status`, `Editable`) VALUES
(1, 'Header', 'Yes', 'No'),
(2, 'Footer', 'Yes', 'Yes'),
(3, 'Left', 'Yes', 'Yes'),
(4, 'Right', 'Yes', 'Yes');



CREATE TABLE IF NOT EXISTS `web_setting` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Header` enum('Yes','No') DEFAULT 'No',
  `Footer` enum('Yes','No') DEFAULT 'No',
  `Left` enum('Yes','No') DEFAULT 'No',
  `Right` enum('Yes','No') DEFAULT 'No',
  `Logo` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `TemplateId` int(11) DEFAULT '1',
  `Sitename` varchar(255) DEFAULT NULL,
  `Facebook` enum('Yes','No') DEFAULT NULL,
  `FacebookLink` varchar(200) DEFAULT NULL,
  `Twitter` enum('Yes','No') DEFAULT 'No',
  `TwitterLink` varchar(200) DEFAULT NULL,
  `LinkedIn` enum('Yes','No') DEFAULT 'No',
  `LinkedInLink` varchar(200) DEFAULT NULL,
  `GooglePlus` enum('Yes','No') DEFAULT 'No',
  `GooglePlusLink` varchar(200) DEFAULT NULL,
  `GoogleAnalytics` text,
  `HomeContent` text,
  `DRedirect` text,
  `CustomerID` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


CREATE TABLE IF NOT EXISTS `web_assign_customer` (
`Id` int( 11 ) NOT NULL AUTO_INCREMENT ,
`CustomerId` int( 11 ) NOT NULL ,
`IsCompany` enum( '1', '0' ) NOT NULL DEFAULT '0',
PRIMARY KEY (`Id`)
) ENGINE = InnoDB  DEFAULT CHARSET = latin1;


INSERT INTO `web_setting` (`Id`, `Header`, `Footer`, `Left`, `Right`, `Logo`, `copyright`, `TemplateId`, `Sitename`, `Facebook`, `FacebookLink`, `Twitter`, `TwitterLink`, `LinkedIn`, `LinkedInLink`, `GooglePlus`, `GooglePlusLink`, `GoogleAnalytics`) VALUES
(1, 'Yes', 'Yes', 'Yes', 'Yes', '37.jpeg', 'Copyright ï¿½ Cloud Based ERP System. All Rights Reserved. ss', 17, 'zxczxczxc', 'Yes', 'https://www.google.co.in/', 'Yes', 'https://www.google.co.in/', 'Yes', 'https://www.google.co.in/', 'Yes', 'https://www.google.co.in/', '<script>\r\n\r\n  (function(i,s,o,g,r,a,m){i[''GoogleAnalyticsObject'']=r;i[r]=i[r]||function(){\r\n\r\n  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\r\n\r\n  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\r\n\r\n  })(window,document,''script'',''//www.google-analytics.com/analytics.js'',''ga'');\r\n\r\n \r\n\r\n  ga(''create'', ''UA-60276873-1'', ''auto'');\r\n\r\n  ga(''send'', ''pageview'');\r\n\r\n \r\n\r\n</script>');


CREATE TABLE IF NOT EXISTS `dynamic_pdf_template` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleId` int(11) NOT NULL,
  `ModuleName` varchar(30) NOT NULL,
  `Module` varchar(30) NOT NULL,
  `TemplateName` varchar(50) NOT NULL,
  `InformationFieldFontSize` varchar(10) NOT NULL,
  `InformationFieldAlign` varchar(10) NOT NULL,
  `InformationColor` varchar(10) NOT NULL,
  `BillAddHeading` varchar(10) NOT NULL,
  `BillAdd_Heading_FieldFontSize` varchar(10) NOT NULL,
  `BillAdd_Heading_FieldAlign` varchar(10) NOT NULL,
  `BillAddColor` varchar(10) NOT NULL,
  `BillHeadColor` varchar(10) NOT NULL,
  `BillHeadbackgroundColor` varchar(10) NOT NULL,
  `ShippAddColor` varchar(10) NOT NULL,
  `ShippAddHeading` varchar(10) NOT NULL,
  `ShippAdd_Heading_FieldFontSize` varchar(10) NOT NULL,
  `ShippAdd_Heading_FieldAlign` varchar(10) NOT NULL,
  `ShippHeadColor` varchar(10) NOT NULL,
  `ShippHeadbackgroundColor` varchar(10) NOT NULL,
  `LineItemHeadingFontSize` varchar(10) NOT NULL,
  `LineColor` varchar(10) NOT NULL,
  `LineHeadColor` varchar(10) NOT NULL,
  `LineHeadbackgroundColor` varchar(10) NOT NULL,
  `LineHeading` varchar(10) NOT NULL,
  `CompanyFieldFontSize` varchar(10) NOT NULL,
  `CompanyFieldAlign` varchar(10) NOT NULL,
  `CompanyColor` varchar(10) NOT NULL,
  `CompanyHeadingFontSize` varchar(10) NOT NULL,
  `CompanyHeadColor` varchar(10) NOT NULL,
  `TitleFontSize` varchar(10) NOT NULL,
  `Title` varchar(10) NOT NULL,
  `TitleColor` varchar(10) NOT NULL,
  `LogoSize` int(11) NOT NULL,
  `SpecialHeadColor` varchar(10) NOT NULL,
  `SpecialHeadbackgroundColor` varchar(10) NOT NULL,
  `SpecialHeadingFontSize` varchar(10) NOT NULL,
  `SpecialFieldColor` varchar(10) NOT NULL,
  `SpecialHeading` varchar(10) NOT NULL,
  `SpecialSigned` varchar(10) NOT NULL,
  `FooterContent` varchar(255) NOT NULL,
  `DiscountDisplay` varchar(10) NOT NULL,
  `PublicPvt` TINYINT(1) NOT NULL DEFAULT '0',
  `AdminID` INT(11) NOT NULL,
  `UserType` VARCHAR(15) NOT NULL,
  `defaultFor` VARCHAR(255) NOT NULL,
  `ConditionDisplay` varchar(10) NOT NULL,
  `setDefautTem` tinyint(1) NOT NULL,
  `LogoDisplay` varchar(10) NOT NULL,
  `AddressDisplay` varchar(10) NOT NULL,
  `SalesPersonD` VARCHAR(10) NOT NULL,
  `CreatedByD` VARCHAR(10) NOT NULL,
  `PdfFile` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ModuleName` (`ModuleName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


  
 
  

CREATE TABLE IF NOT EXISTS `s_hostbill_Account_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manual` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `billingcycle` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `total` float NOT NULL,
  `next_due` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `paytype` varchar(255) NOT NULL,
  `account_id` int(11) NOT NULL COMMENT 'hostbillaccountid',
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `s_hostbill_customer_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostbill_userid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `services` varchar(255) NOT NULL,
  `datecreated` date NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `s_hostbill_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(255) NOT NULL,
  `meta_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `s_hostbill_setting` (`id`, `meta_key`, `meta_value`, `meta_date`) VALUES
(1, 'customer_temp_import', '0', NULL),
(2, 'inventory_import_page', '0', NULL),
(4, 'order_import_page', '0', NULL),
(5, 'account_temp_import', '0', NULL),
(6, 'api_id', '', NULL),
(7, 'api_key', '', NULL),
(8, 'ip', '', NULL),
(9, 'api_url', '', NULL),
(10, 'sycnInvoice', 'all', NULL),
(11, 'fromdate', '', NULL);

CREATE TABLE IF NOT EXISTS `s_hostbill_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostbill_in` varchar(25) DEFAULT NULL,
  `hostbill_out` varchar(25) DEFAULT NULL,
  `ref_id` varchar(25) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `currency_id` varchar(255) DEFAULT NULL,
  `description` text,
  `fee` varchar(25) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `trans_id` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(100) DEFAULT NULL,
  `PPREF` varchar(255) DEFAULT NULL,
  `PNREF` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `s_hostbill_product_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `ref_id` varchar(25) NOT NULL,
  `group_id` varchar(25) NOT NULL,
  `price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `theme_order` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `templateDetail` text NOT NULL,
  `orderdate` datetime NOT NULL,
  `paymentResponce` text NOT NULL,
  `status` enum('Process','Success','Fail') NOT NULL DEFAULT 'Process',
	PRIMARY KEY (`orderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `theme_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(100) NOT NULL,
  `pageDisplayName` varchar(100) NOT NULL,
  `themeId` int(11) NOT NULL,
  `setting` text NOT NULL,
  `layoutType` enum('withoutsidebar','leftsidebar','rightsidebar','bothsidebar') NOT NULL DEFAULT 'withoutsidebar',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `theme_payment_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `theme_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `themeName` varchar(100) NOT NULL,
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `left` text NOT NULL,
  `right` text NOT NULL,
  `thumb_image` varchar(200) NOT NULL,
  `themeUploadedName` varchar(100) NOT NULL COMMENT 'for finth this named template wi',
		PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `theme_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widgets_name` varchar(100) NOT NULL,
  `widgets_identity` varchar(100) NOT NULL,
  `function_name` varchar(200) NOT NULL,
  `style` varchar(200) NOT NULL,
  `status` tinyint(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

INSERT INTO `theme_widgets` (`id`, `widgets_name`, `widgets_identity`, `function_name`, `style`) VALUES
(1, 'Search', 'search_widget', 'getSearchWidget', '{"width":"242px;","height":"242px;"}'),
(2, 'SignIN', 'signin_widget', 'getSignInWidget', '{"width":"242px;","height":"242px;"}'),
(3, 'Logo', 'logo_widget', 'getLogoWidget', '{"width":"242px;","height":"242px;"}'),
(4, 'Currency', 'currency_widget', 'getCurrencyWidget', '{"width":"242px;","height":"242px;"}'),
(5, 'Top Menu', 'topmenu_widget', 'getTopMenuWidget', '{"width":"242px;","height":"242px;"}'),
(6, 'Social Link', 'social_widget', 'getSocialWidget', '{"width":"242px;","height":"242px;"}'),
(7, 'Slider Banner', 'slider_banner_widget', 'getSliderBannerWidget', '{"width":"242px;","height":"242px;"}'),
(8, 'Featured Products', 'featured_products_widget', 'getFeaturedProductsWidget', '{"width":"242px;","height":"242px;"}'),
(9, 'Best Seller Products', 'best_seller_products_widget', 'getBestSellerProductsWidget', '{"width":"242px;","height":"242px;"}'),
(10, 'Support', 'support_widget', 'getSupportWidget', '{"width":"242px;","height":"242px;"}'),
(11, 'Footer Shop Menu', 'footer_shop_menu_widget', 'getFooterShopMenuWidget', '{"width":"242px;","height":"242px;"}'),
(12, 'Footer Information Menu', 'footer_information_menu_widget', 'getFooterInformationMenuWidget', '{"width":"242px;","height":"242px;"}'),
(13, 'Footer My Account', 'footer_my_account_widget', 'getFooterMyAccountWidget', '{"width":"242px;","height":"242px;"}'),
(14, 'Footer Subscriber', 'footer_subscriber_widget', 'getFooterSubscriberWidget', '{"width":"242px;","height":"242px;"}'),
(15, 'Left Category Menu', 'left_category_menu_widget', 'getLeftCategoryMenuWidget', '{"width":"242px;","height":"242px;"}'),
(16, 'Left Price Filter', 'left_price_filter_widget', 'getLeftPriceFilterWidget', '{"width":"242px;","height":"242px;"}'),
(17, 'Left Manufacturer Filter', 'left_manufacturer_filter_widget', 'getLeftManufacturerFilterWidget', '{"width":"242px;","height":"242px;"}');


CREATE TABLE IF NOT EXISTS `batchmgmt` (
  `batchId` int(11) NOT NULL AUTO_INCREMENT,
  `batchname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `salesEntries` int(11) NOT NULL DEFAULT '0',
  `invoiceEntries` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL,
  `createdby` varchar(255) NOT NULL,
  `modifiedby` varchar(255) NOT NULL,
  `createdon` datetime NOT NULL,
  `modifiedon` datetime NOT NULL,
  `createdId` int(11) NOT NULL,
  `modifiedId` int(11) NOT NULL,
  `admintype` varchar(20) NOT NULL,
  `RowColor` varchar(50) NOT NULL,
   PRIMARY KEY (`batchId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `batchmgmt_schedule` (
  `batchId` int(11) NOT NULL AUTO_INCREMENT,
  `modifiedby` varchar(50) NOT NULL,
  `modifiedon` datetime NOT NULL,
  `createdId` int(11) NOT NULL,
  `modifiedId` int(11) NOT NULL,
  `admintype` varchar(20) NOT NULL,
    KEY `batchId` (`batchId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `processList` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(50) NOT NULL,
  `Task` varchar(50) NOT NULL,
  `PID` varchar(10) NOT NULL,
  `LastUpdatedID` int(10) NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `PID` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `update_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updID` int(11) NOT NULL,
  `ModuleType` varchar(50) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(50) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `IpAdd` varchar(50) NOT NULL,
  `UpdateDate` datetime NOT NULL,
  `Changes` text NOT NULL,
  `ChangesNew` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `pos_dealer_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plandata` text NOT NULL,
  `amount` double(10,2) NOT NULL,
  `txnId` varchar(50) NOT NULL,
  `paymentDate` datetime NOT NULL,
  `payment_status` enum('Inprocess','Failed','Completed','Pending') NOT NULL,
  `paypalData` text NOT NULL,
  `subscr_id` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `suspendData` text NOT NULL,
  `renewDate` datetime NOT NULL,
  `expireDate` datetime NOT NULL,
  `currency_code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_discounttype`
--

CREATE TABLE IF NOT EXISTS `pos_discounttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `discount_type` enum('Standard') NOT NULL DEFAULT 'Standard',
  `button_title` varchar(255) NOT NULL,
  `receipt_label` varchar(255) NOT NULL,
  `calculation_type` enum('Percentage','Amount') NOT NULL DEFAULT 'Percentage',
  `discount` decimal(19,2) NOT NULL,
  `apply_to` enum('items','checks','both') NOT NULL,
  `access_level` enum('server','seniorserver','vendorpos') NOT NULL,
  `prompt_reason` varchar(255) NOT NULL,
  `status` enum('Active','Inactive','Deleted') NOT NULL,
  `discount_code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `pos_floor`
--

CREATE TABLE IF NOT EXISTS `pos_floor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `width` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_floor_table`
--

CREATE TABLE IF NOT EXISTS `pos_floor_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `leftpostion` varchar(20) NOT NULL,
  `topposition` varchar(20) NOT NULL,
  `width` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_floor_table_images`
--

CREATE TABLE IF NOT EXISTS `pos_floor_table_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_happy_hours`
--

CREATE TABLE IF NOT EXISTS `pos_happy_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `weekDays` text NOT NULL,
  `property` enum('Price','Availability') NOT NULL DEFAULT 'Price',
  `propertyAvailability` enum('Available','Not Available') NOT NULL,
  `priceRule` varchar(10) NOT NULL,
  `priceAmount` double(10,2) NOT NULL,
  `priceUnit` enum('%','$') NOT NULL DEFAULT '%',
  `effectOnModifire` enum('none','forced','optional','both') NOT NULL DEFAULT 'none',
  `vendor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_inventory_item`
--

CREATE TABLE IF NOT EXISTS `pos_inventory_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `high` varchar(100) NOT NULL,
  `low` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `pos_menu_category`
--

CREATE TABLE IF NOT EXISTS `pos_menu_items_printer` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`itemId` int(11) NOT NULL,
`location_id` int(11) NOT NULL,
`printer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `pos_menu_category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  `categoryType` tinyint(4) NOT NULL COMMENT 'as defined in pos_menu_category_master ',
  `groupId` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `forceCatType` enum('choice','checklist') NOT NULL,
  `locationId` VARCHAR(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pos_menu_category` (`categoryId`, `categoryName`, `categoryType`, `groupId`, `vendor_id`, `is_deleted`, `is_default`, `forceCatType`) VALUES
(1, 'Courses', 3, 0, 0, 1, 1, 'choice'),
(2, 'Gift Card', 3, 0, 0, 1, 1, 'choice'),
(3, 'Loyalty Card', 3, 0, 0, 1, 1, 'choice'),
(4, 'Quantity', 3, 0, 0, 0, 1, 'choice'),
(5, 'Seat', 3, 0, 0, 1, 1, 'choice');

--
-- Table structure for table `pos_menu_category_details`
--

CREATE TABLE IF NOT EXISTS `pos_menu_category_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuCatId` int(11) NOT NULL,
  `optionModId` int(11) NOT NULL,
  `forceModId` int(11) NOT NULL,
  `catImage` varchar(50) NOT NULL,
  `app_display` tinyint(1) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `tax_profile_id` int(11) NOT NULL,
  `tax_inclusion` tinyint(1) NOT NULL DEFAULT '0',
  `no_discount` tinyint(1) NOT NULL DEFAULT '0',
  `super_group_id` int(11) NOT NULL,
  `happyhour_enable` tinyint(1) NOT NULL DEFAULT '0',
  `print` tinyint(1) NOT NULL DEFAULT '0',
  `printer` int(11) NOT NULL,
  `taxable` enum('Yes','No') NOT NULL,
  `custcatImage` varchar(255) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `pos_menu_category_master`
--

CREATE TABLE IF NOT EXISTS `pos_menu_category_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `catkey` varchar(50) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_menu_category_master`
--

INSERT INTO `pos_menu_category_master` (`id`, `name`, `catkey`) VALUES
(1, 'Menu Category', 'menucat'),
(2, 'Optional Modifire Category', 'optionmodcat'),
(3, 'Force Modifire Category', 'forcemodcat'),
(4, 'Modifire Group Category', 'modgroup'),
(5, 'Super Group Category', 'supergroup'),
(6, 'Inventory Category', 'inventorycat');


--
-- Table structure for table `pos_menu_group`
--

CREATE TABLE IF NOT EXISTS `pos_menu_group` (
  `groupId` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `ordering` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_menu_items`
--

CREATE TABLE IF NOT EXISTS `pos_menu_items` (
  `itemId` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `modcatID` int(11) DEFAULT '0' COMMENT 'use for force modifire',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_menu_items_details`
--

CREATE TABLE IF NOT EXISTS `pos_menu_items_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) NOT NULL,
  `optionModId` int(11) NOT NULL,
  `forceModId` int(11) NOT NULL,
  `app_display` tinyint(1) NOT NULL DEFAULT '1',
  `itemImage` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `UPC` varchar(50) NOT NULL,
  `quick_item` tinyint(1) NOT NULL DEFAULT '0',
  `tax_profile_id` int(11) NOT NULL,
  `tax_inclusion` tinyint(1) NOT NULL DEFAULT '0',
  `discount` tinyint(1) NOT NULL DEFAULT '0',
  `allow_deposit` tinyint(1) NOT NULL DEFAULT '0',
  `open_item` tinyint(1) NOT NULL COMMENT '0=>''no'',1=>Name/price,2=>Price only',
  `happyhour_enable` tinyint(1) NOT NULL DEFAULT '0',
  `happyhour_setting` text NOT NULL,
  `print` tinyint(1) NOT NULL DEFAULT '0',
  `printer` int(11) NOT NULL,
  `taxable` enum('Yes','No') NOT NULL,
  `priced` enum('default','unit') NOT NULL,
  `assignedLocation` varchar(250) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `custitemImage` varchar(50) NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `viewedDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `pos_menu_items_ingredients`
--

CREATE TABLE IF NOT EXISTS `pos_menu_items_ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) NOT NULL,
  `ingredientsId` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_modifire_group_item`
--

CREATE TABLE IF NOT EXISTS `pos_modifire_group_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modCatId` int(11) NOT NULL,
  `forceCatId` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_order`
--

CREATE TABLE IF NOT EXISTS `pos_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `location_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `order_type` enum('Dine In','Carry Out','Pick Up','Delivery') NOT NULL DEFAULT 'Dine In',
  `order_status` enum('ordered', 'processing', 'accepted', 'deposit', 'cancelled', 'ontheway', 'cancelledbydriver', 'completed') NOT NULL,
  `open_order_date` datetime NOT NULL,
  `close_order_date` datetime NOT NULL,
  `date_order` datetime NOT NULL,
  `customer_type` enum('customer','guest') NOT NULL DEFAULT 'guest',
  `customer_guest_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `payment_type` enum('paypal','cash','gift certificate','card') NOT NULL,
  `currency_code` varchar(20) NOT NULL,
  `deposit_first_time_amount` decimal(19,2) NOT NULL,
  `deposit_second_time_amount` decimal(19,2) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `floor_name` varchar(255) NOT NULL,
  `order_discount_type` enum('percentage','amount','global') NOT NULL,
  `order_discount_price` decimal(19,4) NOT NULL,
  `order_discount_code` varchar(100) NOT NULL,
  `order_discount_reason` varchar(255) NOT NULL,
  `order_discount_price_off` decimal(19,4) NOT NULL,
  `order_total_tax_price` decimal(19,2) NOT NULL,
  `order_total_include_tax_price` decimal(19,2) NOT NULL,
  `order_tax_descrption` text NOT NULL,
  `is_split` enum('Yes','No') NOT NULL DEFAULT 'No',
  `split_count_user` varchar(20) NOT NULL,
  `payment_transaction_id` varchar(100) NOT NULL,
  `is_invoice_created` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `order_sn` int(11) NOT NULL,
  `refund_amount` decimal(19,2) NOT NULL,
  `refund_reason` decimal(19,2) NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `order_total` FLOAT(19,4) NOT NULL,
  `payment_status` enum('processing','failed','completed','authorized','COD') NOT NULL,
  `quantity` int(5) NOT NULL,
  `Shipping` float(10,2) NOT NULL,
  `ShippingMethod` varchar(255) NOT NULL,
  `total_order_gratuity` DECIMAL(19,2) NOT NULL,
  `total_order_change` DECIMAL(19,2) NOT NULL,
  `total_cash_given` DECIMAL(19,2) NOT NULL,
  `build_version` varchar(255) NOT NULL,
  `unit_type` varchar(20) NOT NULL,
  `pickup_time` datetime NOT NULL,
  `driver_id` int(11) NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `estimated_delivery_time` datetime NOT NULL,
  `redeem_point_dollar` DECIMAL(19,2) NOT NULL,
  `redeem_point` varchar(20) NOT NULL,
   PRIMARY KEY (`id`),
   KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_order_item`
--

CREATE TABLE IF NOT EXISTS `pos_order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(19,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `is_happy_hour` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_happy_hour_amount` varchar(20) NOT NULL,
  `item_discount_type` enum('percentage','amount','global') NOT NULL,
  `item_discount_price` decimal(19,2) NOT NULL,
  `item_discount_code` varchar(100) NOT NULL,
  `item_discount_reason` varchar(255) NOT NULL,
  `item_discount_price_off` decimal(19,2) NOT NULL,
  `item_total_tax_price` decimal(19,2) NOT NULL,
  `item_total_include_tax_price` decimal(19,2) NOT NULL,
  `item_tax_descrption` text NOT NULL,
  `unit_type` varchar(20) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `order_item_id` (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_order_item_modifiers`
--

CREATE TABLE IF NOT EXISTS `pos_order_item_modifiers` (
  `modifiers_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_item_id` int(11) NOT NULL,
  `modifiers_product_id` int(11) NOT NULL,
  `modifiers_product_name` varchar(255) NOT NULL,
  `modifiers_product_price` decimal(19,2) NOT NULL,
  `modifiers_product_quantity` int(11) NOT NULL,
   PRIMARY KEY (`modifiers_id`),
   KEY `order_item_id` (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_order_timestamp_history`
--

CREATE TABLE IF NOT EXISTS `pos_order_timestamp_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(20) NOT NULL,
  `action` varchar(255) NOT NULL,
  `server_id` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `pos_order_shipping_address` (
`address_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`order_id` varchar(20) NOT NULL,
`user_id` int(11) NOT NULL,
`name` varchar(50) NOT NULL,
`phone` varchar(20) NOT NULL,
`land_mark` varchar(50) NOT NULL,
`zip` varchar(20) NOT NULL,
`address` varchar(100) NOT NULL,
`city` varchar(50) NOT NULL,
`state` varchar(50) NOT NULL,
`country` varchar(50) NOT NULL,
`lat` varchar(20) NOT NULL,
`lng` varchar(20) NOT NULL,
`created_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;


--
-- Table structure for table `pos_schedule`
--

CREATE TABLE IF NOT EXISTS `pos_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
   `status` enum('Worked Shifts','Accept Shifts','Request Coverage') NOT NULL,
  `reason` text NOT NULL,
  `parentId` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Table structure for table `pos_settings`
--
CREATE TABLE IF NOT EXISTS `pos_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `data` text NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_taxprofile`
--

CREATE TABLE IF NOT EXISTS `pos_taxprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `tax_profile_name` varchar(255) NOT NULL,
  `tax_name` varchar(255) NOT NULL,
  `base_rate` decimal(19,2) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `tax_type` enum('percentage','amount') NOT NULL DEFAULT 'amount',
  `location_id` int(11) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


 
--
-- Table structure for table `pos_device`
--

CREATE TABLE IF NOT EXISTS `pos_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sn` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pos_module`
--

CREATE TABLE IF NOT EXISTS `pos_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  `parent_module` int(11) NOT NULL,
  `order_module` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_module`
--

INSERT INTO `pos_module` (`id`, `module_name`, `parent_module`, `order_module`, `page`, `icon`, `status`) VALUES
(1, 'Dashboard', 0, 1, 'dashboard.php', 'wb-dashboard', 'Yes'),
(2, 'Layouts', 0, 2, 'layout.php', 'wb-layout', 'Yes'),
(3, 'Menu', 0, 3, '', 'wb-grid-4', 'Yes'),
(4, 'Inventory', 0, 4, 'edit_inventory_ingredients.php', 'wb-table', 'Yes'),
(5, 'Settings', 0, 5, '', 'wb-settings', 'Yes'),
(6, 'Report', 0, 6, '', 'wb-pie-chart', 'Yes'),
(7, 'Menu Item', 3, 1, 'edit_menu.php', '', 'Yes'),
(8, 'Optional Modifiers', 3, 2, 'edit_optional_modifiers.php', '', 'Yes'),
(9, 'Forced Modifiers', 3, 3, 'edit_forced_modifiers.php', '', 'Yes'),
(10, 'Modifier Groups', 3, 4, 'edit_modifier_groups.php', '', 'Yes'),
(11, 'Super Groups', 3, 5, 'edit_super_groups.php', '', 'Yes'),
(12, 'Happy Hours', 3, 6, 'edit_happy_hours.php', '', 'Yes'),
(13, 'Location Settings', 5, 1, '', '', 'Yes'),
(14, 'Payment Settings', 5, 2, '', '', 'Yes'),
(15, 'Users/Customers', 5, 3, '', '', 'Yes'),
(16, 'Printers/Technical', 5, 4, '', '', 'Yes'),
(17, 'Company Settings', 13, 1, 'companysetting.php', '', 'Yes'),
(18, 'Basic Location Settings', 13, 2, 'locationlisting.php', '', 'Yes'),
(19, 'Tax Profiles', 14, 1, 'taxprofile.php', '', 'Yes'),
(20, 'Discount Types', 14, 2, 'discounttype.php', '', 'Yes'),
(21, 'Users/Customers', 15, 1, 'user.php', '', 'Yes'),
(22, 'Shift Notification Settings', 15, 2, 'notification.php', '', 'Yes'),
(23, 'Overtime Settings', 15, 3, 'overtimesetting.php', '', 'Yes'),
(25, 'Sales', 6, 1, '', '', 'Yes'),
(26, 'Order by Id', 25, 1, 'reportorder.php', '', 'Yes'),
(27, 'Order by Type', 25, 2, 'reportordertype.php', '', 'Yes'),
(28, 'Order by Server', 25, 3, 'reportorderserver.php', '', 'Yes'),
(29, 'Order by Item', 25, 4, 'reportorderitem.php', '', 'Yes'),
(30, 'Plan', 0, 7, '', 'wb-payment', 'Yes'),
(31, 'Upgrade Plan', 30, 1, 'upgrade.php', '', 'Yes'),
(32, 'Current Plan & Payments', 30, 2, 'paymentHistory.php', '', 'Yes'),
(33, 'Device', 16, 1, 'device.php', '', 'Yes'),
(34, 'Time Cards', 6, 2, 'timecard.php', '', 'Yes'),
(35, 'Paypal Setting', 14, 1, 'paypalsetting.php', '', 'Yes'),
(36, 'Job Title Management', 5, 5, 'addTitle.php', '', 'Yes'),
(37, 'Notification', 6, 2, 'allnotification.php', '', 'Yes'),
(38, 'Location listing', '5', '2', 'locationlisting.php', '', 'Yes'),
(39, 'Shift Management', 5, 6, 'schedulingweek.php', '', 'Yes'),
(40, 'Cash Receipt Register', 6, 4, 'receiptregister.php', '', 'Yes'),
(41, 'Velocity Setting', '14', '1', 'velocitysetting.php', '', 'Yes'),
(42, 'Manage Printer', '16', '1', 'viewprinter.php', '', 'Yes'),
(43, 'E-Commerce Settings', 0, 8, '', 'wb-library', 'Yes'),
(44, 'Templates', 43, 1, 'template.php', '', 'Yes'),
(45, 'Purchased Templates', 43, 2, 'themes.php', '', 'Yes'),
(46, 'store Settings', 43, 3, 'cartSetting.php?module=1', '', 'Yes'),
(47, 'Social Settings', 43, 6, 'cartSetting.php?module=2', '', 'Yes'),
(48, 'Manage Pages', 43, 7, 'viewPages.php', '', 'Yes'),
(49, 'Social Links', 43, 8, 'socialLinks.php', '', 'Yes'),
(50, 'Slider Banner', 43, 9, 'sliderBanners.php', '', 'Yes'),
(51, 'Bestseller Settings', 43, 5, 'cartSetting.php?module=3', '', 'Yes'),
(52, 'Shipping Methods', 43, 9, 'viewShipping.php', '', 'Yes'),
(53, 'Marketing', 43, 10, '', '', 'Yes'),
(54, 'Manage Subscriber Email', 53, 1, 'viewSubscriber.php', '', 'Yes'),
(55, 'Send Newsletter', 53, 2, 'emailNewsletter.php', '', 'Yes'),
(56, 'Newsletter Templates', 53, 2, 'viewNewsletterTemplate.php', '', 'Yes'),
(57, 'Item Reviews', 43, 5, 'viewProductReview.php', '', 'Yes'),
(58, 'Print & Tip Settings', '5', '0', 'setting.php', '', 'Yes'),
(59, 'Delivery Rate Settings', '5', '0', 'deliveryrate.php', '', 'Yes'),
(60, 'Location Summary', '25', '1', 'reportlocation.php', '', 'Yes');
--
-- Table structure for table `pos_module_action`
--

CREATE TABLE IF NOT EXISTS `pos_module_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `action_name` varchar(255) NOT NULL,
  `action_page` varchar(255) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


INSERT INTO `pos_module_action` (`id`, `module_id`, `action_name`, `action_page`) VALUES
(1, 1, 'Dashboard', 'dashboard.php'),
(2, 2, 'Layout', 'layout.php'),
(3, 3, 'Menu Item', 'edit_menu.php'),
(4, 3, 'Optional Modifiers', 'edit_optional_modifiers.php'),
(5, 3, 'Forced Modifiers', 'edit_forced_modifiers.php'),
(6, 3, 'Modifier Groups', 'edit_modifier_groups.php'),
(7, 3, 'Super Groups', 'edit_super_groups.php'),
(8, 3, 'Happy Hours', 'edit_happy_hours.php'),
(9, 4, 'Inventory Ingredients', 'edit_inventory_ingredients.php'),
(10, 5, 'Company Settings', 'companysetting.php'),
(11, 5, 'Basic Location Settings', 'locationsetting.php'),
(12, 5, 'Tax Profiles', 'taxprofile.php'),
(13, 5, 'Discount Types', 'discounttype.php'),
(14, 5, 'Servers/Customers', 'user.php'),
(15, 5, 'Add Users', 'adduser.php'),
(16, 5, 'Schedule', 'schedulingweek.php'),
(17, 6, 'Order Id', 'reportorder.php'),
(18, 6, 'Order Type', 'reportordertype.php'),
(19, 6, 'Order Server', 'reportorderserver.php'),
(20, 6, 'Order Item', 'reportorderitem.php'),
(21, 30, 'POS Packages', 'upgrade.php'),
(22, 30, 'Payment History', 'paymentHistory.php'),
(23, 5, 'Over time Setting', 'overtimesetting.php'),
(24, 5, 'Notification', 'notification.php'),
(25, 5, 'Device', 'device.php'),
(26, 5, 'Add Discount Types', 'adddiscount.php'),
(27, 6, 'Time Card', 'timecard.php'),
(28, 6, 'update plan', 'paypal.php'),
(29, 6, 'thanks', 'thank.php'),
(30, 5, 'Paypal setting', 'paypalsetting.php'),
(31, 5, 'Job Title Management', 'addTitle.php'),
(32, 6, 'Notification', 'allnotification.php'),
(33, '5', 'Location listing', 'locationlisting.php'),
(34, 5, 'Shift Management', 'schedulingweek.php'),
(35, 5, 'Add Shift', 'addshift.php'),
(36, 6, 'Cash Receipt Register', 'receiptregister.php'),
(37, 5, 'Velocity setting', 'velocitysetting.php'),
(38, 5, 'Manage Printer', 'viewprinter.php'),
(39, 5, 'Manage Printer', 'addprinter.php'),
(40, 44, 'web settings', 'themes.php'),
(41, 44, 'web settings', 'cartSetting.php'),
(42, 44, 'web settings', 'editTheme.php'),
(43, 44, 'web settings', 'viewPages.php'),
(44, 44, 'web settings', 'editPage.php'),
(45, 44, 'web settings', 'socialLinks.php'),
(46, 44, 'web settings', 'editSocialLink.php'),
(47, 44, 'web settings', 'sliderBanners.php'),
(48, 44, 'web settings', 'editSliderBanner.php'),
(49, 44, 'web settings', 'viewShipping.php'),
(50, 44, 'web settings', 'editShipping.php'),
(51, 44, 'web settings', 'shippingRates.php'),
(52, 44, 'web settings', 'viewProductReview.php'),
(53, 44, 'web settings', 'template.php'),
(54, 55, 'Web Marketing', 'viewSubscriber.php'),
(55, 55, 'Web Marketing', 'editSubscriber.php'),
(56, 55, 'Web Marketing', 'emailNewsletter.php'),
(57, 55, 'Web Marketing', 'viewNewsletterTemplate.php'),
(58, 55, 'Web Marketing', 'editNewsletterTemplate.php'),
(59, '5', 'Settings', 'setting.php'),
(60, '5', 'Delivery Rate Settings', 'deliveryrate.php'),
(61, '6', 'Location Summary', 'reportlocation.php');
--
-- Table structure for table `pos_module_user`
--
CREATE TABLE IF NOT EXISTS `pos_module_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `pos_seat_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `number_seat` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `status` enum('Canceled','On hold','Confirmed','Completed') NOT NULL,
  `booking_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

 
CREATE TABLE IF NOT EXISTS `pos_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `notification_type` enum('order','custom') NOT NULL,
  `custome_message` text NOT NULL,
  `created_date` datetime NOT NULL,
  `status` enum('read','unread') NOT NULL DEFAULT 'unread',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pos_jobtitle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tname` varchar(50) DEFAULT NULL,
  `status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
   PRIMARY KEY (`id`)
)  ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `pos_currency_master` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(40) NOT NULL,
   PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `pos_currency_master` (`currency_id`, `currency_name`) VALUES
(1, '100.00'),
(2, '50.00'),
(3, '20.00'),
(4, '10.00'),
(5, '5.00'),
(6, '1.00'),
(7, '0.25'),
(8, '0.10'),
(9, '0.05'),
(10, '0.01'),
(11, '25c roll'),
(12, '10c roll'),
(13, '5c roll'),
(14, '1c roll');


CREATE TABLE IF NOT EXISTS `pos_cash_register` (
  `cash_register_id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `register_datetime` datetime NOT NULL,
  PRIMARY KEY (`cash_register_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `pos_cash_inventory` (
  `cash_inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `currency_value` int(11) NOT NULL,
  `entry_type` enum('opening','closing') NOT NULL,
  `cash_register_id` int(11) NOT NULL,
  PRIMARY KEY (`cash_inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `pos_cash_card_check_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjust_returns` decimal(10,2) NOT NULL,
  `adjust_paid` decimal(10,2) NOT NULL,
  `adjust_void` decimal(10,2) NOT NULL,
  `adjust_other` decimal(10,2) NOT NULL,
  `card_master` decimal(10,2) NOT NULL,
  `card_debit` decimal(10,2) NOT NULL,
  `card_visa` decimal(10,2) NOT NULL,
  `card_amex` decimal(10,2) NOT NULL,
  `card_discover` decimal(10,2) NOT NULL,
  `check_state_tax` decimal(10,2) NOT NULL,
  `cash_register_id` int(11) NOT NULL,
  `net_sale` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `over` decimal(10,2) NOT NULL,
  `comment` text NOT NULL,
  `starting_cash_total` decimal(10,2) NOT NULL,
  `closing_machine_total` decimal(10,2) NOT NULL,
  `closing_machine_counted` decimal(10,2) NOT NULL,
  `adjust_paidin` decimal(10,2) NOT NULL,
  `adjust_paidout` decimal(10,2) NOT NULL,
  `card_machine_total` decimal(10,2) NOT NULL,
  `check_total` decimal(10,2) NOT NULL,
  `comment_reason` tinytext NOT NULL,
  `comment_short` tinytext NOT NULL,
  `total_sale` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `pos_schedule_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(255) NOT NULL,
  `working_hour_start` time NOT NULL,
  `working_hour_end` time NOT NULL,
  `short_leave_late_coming` varchar(50) NOT NULL,
  `short_leave_early_leaving` varchar(50) NOT NULL,
  `week_start` varchar(50) NOT NULL,
  `week_end` varchar(50) NOT NULL,
  `weekend_count_leave` varchar(50) NOT NULL,
  `lunch_time` time NOT NULL,
  `short_break_limit` varchar(20) NOT NULL,
  `overtime_eligibility` varchar(50) NOT NULL,
  `overtime_period` varchar(50) NOT NULL,
  `lunch_paid` varchar(50) NOT NULL,
  `lunch_punch_allowed` varchar(50) NOT NULL,
  `short_break_paid` varchar(50) NOT NULL,
  `flex_time` varchar(50) NOT NULL,
  `short_break_time` varchar(50) NOT NULL,
  `short_break_allowed` varchar(50) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pos_attendance` (
	`attendance_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` int(11) NOT NULL,
	`vendor_id` int(11) NOT NULL,
	`attendance_comment` mediumtext NOT NULL,
	`date` date NOT NULL,
	`punchIn` datetime NOT NULL,
	`punchOut` datetime NOT NULL,
	`lunchOut` datetime NOT NULL,
	`lunchIn` datetime NOT NULL,
	`break` longtext NOT NULL,
	`locationId` int(11) NOT NULL,
	`lastAction` varchar(50)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `pos_e_cart` (
  `CartID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Cid` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `PriceBeforeQuantityDiscount` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `Quantity` int(20) NOT NULL,
  `IsTaxable` enum('Yes','No') COLLATE latin1_general_ci NOT NULL,
  `TaxClassId` int(11) UNSIGNED NOT NULL,
  `TaxRate` float(10,2) NOT NULL,
  `TaxDescription` text COLLATE latin1_general_ci NOT NULL,
  `FreeShipping` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `Options` text COLLATE latin1_general_ci NOT NULL,
  `OptionsAttribute` text COLLATE latin1_general_ci NOT NULL,
  `Weight` decimal(10,2) UNSIGNED NOT NULL,
  `AddedDate` date NOT NULL,
  `Variant_ID` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Variant_val_Id` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `AliasID` int(11) NOT NULL,
  `UploadedFile` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ItemPriceWithTax` decimal(10,3) NOT NULL,
  `ItemType` enum('main','forceModifier','optionalModifier') COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;



CREATE TABLE `pos_e_emails` (
  `EmailId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Email` varchar(64) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Created_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pos_e_products_reviews` (
  `ReviewId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Pid` int(10) UNSIGNED NOT NULL,
  `Cid` int(10) UNSIGNED NOT NULL,
  `ReviewTitle` varchar(255) NOT NULL,
  `ReviewText` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Rating` tinyint(1) NOT NULL,
  `DateCreated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pos_e_shipping_custom_rates` (
  `Srid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Ssid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `RateMin` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `RateMax` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `Base` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `Price` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `PriceType` enum('amount','percentage') NOT NULL DEFAULT 'amount'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pos_e_shipping_selected` (
  `Ssid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
  `Notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `pos_e_users_wishlist` (
  `Wlid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Cid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `Name` varchar(64) NOT NULL DEFAULT '',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UpdateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pos_e_users_wishlist_products` (
  `Wlpid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Wlid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `ProductId` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `AttributeId` text,
  `Options` text,
  `Variant_ID` varchar(200) NOT NULL,
  `Variant_val_Id` varchar(500) NOT NULL,
  `AliasID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `pos_newsletter_template` (
  `Templapte_Id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Template_Subject` varchar(255) NOT NULL,
  `Template_Name` varchar(255) NOT NULL,
  `Template_Content` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Created_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `pos_payment_transactions` (
  `TID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `OrderId` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `Cid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `Completed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Extra` text,
  `PaymentType` varchar(100) NOT NULL DEFAULT '',
  `PaymentGateway` varchar(100) NOT NULL DEFAULT '',
  `PaymentResponse` text,
  `OrderSubtotalAmount` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `OrderTotalAmount` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `ShippingMethod` varchar(100) NOT NULL DEFAULT '0',
  `ShippingSubmethod` varchar(100) NOT NULL DEFAULT '',
  `ShippingAmount` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `TaxAmount` decimal(20,5) UNSIGNED NOT NULL DEFAULT '0.00000',
  `IsSuccess` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `pos_products_quantity_discounts` (
  `qd_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `range_min` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `range_max` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `discount` double(10,5) NOT NULL DEFAULT '0.00000',
  `discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `customer_type` enum('customer','wholesale') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `edi_company` ( 
`ID` int(11) NOT NULL AUTO_INCREMENT, 
`EDICompId` int(11) NOT NULL, 
`RequestedCompID` int(11) NOT NULL, 
`Status` enum('Reqest','Accept','Reject') NOT NULL, 
`Added_Date` date NOT NULL, 
`AcceptRejectDate` date NOT NULL, 
`EDICompName` varchar(100) NOT NULL,
`RequestedCompName` varchar(100) NOT NULL,
`EDIType` enum('Customer','Vendor','Both') NOT NULL, 
`EdiCustID` varchar(100) NOT NULL,
`EdiReqCustID` varchar(100) NOT NULL,
`EdiVendorID` varchar(100) NOT NULL,
`EdiReqVendorID` varchar(100) NOT NULL,
PRIMARY KEY (`ID`) ,
   KEY `EdiCustID` (`EdiCustID`),
   KEY `EdiReqCustID` (`EdiReqCustID`),
   KEY `EdiVendorID` (`EdiVendorID`),
   KEY `EdiReqVendorID` (`EdiReqVendorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1  ;

CREATE TABLE IF NOT EXISTS `edi_request` ( 
  `reqID` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseID` varchar(100) NOT NULL,
  `Amount` float(10,2) NOT NULL,
  `ReqDate` date NOT NULL,
  `SalesID` varchar(100) NOT NULL,
  `AdminType` varchar(50) NOT NULL,
  `AdminID` varchar(50) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `SuppCompany` varchar(100) NOT NULL,
  `SuppCode` varchar(50) NOT NULL,
  `CustCode` varchar(30) NOT NULL,
  `CustID` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `DeleteDate` date NOT NULL,
  PRIMARY KEY (`reqID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `meeting_meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) COLLATE utf8_bin NOT NULL,
  `meeting_id` int(15) NOT NULL,
  `user_id` varchar(100) COLLATE utf8_bin NOT NULL,
  `topic` varchar(150) COLLATE utf8_bin NOT NULL,
  `password_check` tinyint(1) NOT NULL,
  `password` varchar(20) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL,
  `option_jbh` tinyint(1) NOT NULL,
  `option_start_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `option_host_video` tinyint(1) NOT NULL,
  `option_participants_video` tinyint(1) NOT NULL,
  `option_enforce_login` tinyint(1) NOT NULL,
  `option_in_meeting` tinyint(1) NOT NULL,
  `option_audio` varchar(15) COLLATE utf8_bin NOT NULL,
  `type` int(2) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration` int(5) NOT NULL,
  `timezone` varchar(50) COLLATE utf8_bin NOT NULL,
  `start_url` text COLLATE utf8_bin NOT NULL,
  `join_url` varchar(300) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `original_start_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_id` (`meeting_id`) USING BTREE,
   KEY `host_id` (`user_id`),
   KEY `uuid` (`uuid`),
  KEY `join_url` (`join_url`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `meeting_recordings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(35) NOT NULL,
  `meeting_number` int(11) NOT NULL,
  `host_id` varchar(30) NOT NULL,
  `topic` varchar(300) NOT NULL,
  `start_time` datetime NOT NULL,
  `timezone` varchar(50) NOT NULL,
  `duration` int(10) NOT NULL,
  `total_size` int(15) NOT NULL,
  `recording_count` int(5) NOT NULL,
   PRIMARY KEY (`id`),
   KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `meeting_recording_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` varchar(80) NOT NULL,
  `recording_uuid_id` varchar(50) NOT NULL,
  `recording_start` datetime NOT NULL,
  `recording_end` datetime NOT NULL,
  `file_type` varchar(15) NOT NULL,
  `file_size` int(15) NOT NULL,
  `play_url` text NOT NULL,
  `download_url` text NOT NULL,
  `original_play_url` text NOT NULL,
  `original_download_url` text NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `meeting_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(5) NOT NULL,
  `dept` varchar(25) NOT NULL,
  `enable_webinar` tinyint(1) NOT NULL,
  `enable_cmr` tinyint(1) NOT NULL,
  `enable_large` tinyint(1) NOT NULL,
  `enable_silent_mode` tinyint(1) NOT NULL,
  `enable_breakout_room` tinyint(1) NOT NULL,
  `enable_auto_recording` tinyint(1) NOT NULL,
  `enable_cloud_auto_recording` tinyint(1) NOT NULL,
  `disable_chat` tinyint(1) NOT NULL,
  `disable_private_chat` tinyint(4) NOT NULL,
  `disable_jbh_reminder` tinyint(1) NOT NULL,
  `enable_annotation` tinyint(1) NOT NULL,
  `enable_auto_saving_chats` tinyint(4) NOT NULL,
  `enable_file_transfer` tinyint(4) NOT NULL,
  `enable_share_dual_camera` tinyint(4) NOT NULL,
  `enable_far_end_camera_control` tinyint(4) NOT NULL,
  `pmi` varchar(30) NOT NULL,
  `zpk` text NOT NULL,
  `account_type` varchar(10) NOT NULL DEFAULT 'customer',
  `group_id` varchar(100) NOT NULL,
  `track_id` varchar(50) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `cust_type` varchar(15) NOT NULL,
  `timezone` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `meeting_webinars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `webinar_id` int(15) NOT NULL,
  `user_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `topic` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `agenda` varchar(256) NOT NULL,
  `password_check` tinyint(1) NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `approval_type` tinyint(4) NOT NULL,
  `registration_type` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `panelists` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `option_start_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `option_host_video` tinyint(1) NOT NULL,
  `option_panelist_video` tinyint(1) NOT NULL,
  `option_enforce_login` tinyint(1) NOT NULL,
  `option_practice_session` tinyint(1) NOT NULL,
  `option_audio` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` int(2) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration` int(5) NOT NULL,
  `timezone` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start_url` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `join_url` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `original_start_time` datetime NOT NULL,
   PRIMARY KEY (`id`),
   KEY `uuid` (`uuid`),
   KEY `meeting_id` (`webinar_id`),
   KEY `user_id` (`user_id`),
   KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `order_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `ModuleName` varchar(30) NOT NULL,
  `Module` varchar(30) NOT NULL,
  `FileName` text NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `standalone_shipment` (
  `ShipmentID` int(15) NOT NULL AUTO_INCREMENT,
  `ModuleType` enum('SalesRMA','PurchaseRMA','CustomerRMA','VendorRMA','VendorPayment') NOT NULL,
  `RefID` varchar(50) NOT NULL,
  `AdminID` int(15) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ShippingCarrier` varchar(100) NOT NULL,
  `ShippingMethod` varchar(60) NOT NULL,
  `PackageType` varchar(80) NOT NULL,
  `TrackingID` varchar(100) NOT NULL,
  `TotalFreight` varchar(10) NOT NULL,
  `COD` varchar(20) NOT NULL,
  `InsureAmount` varchar(10) NOT NULL,
  `InsureValue` varchar(30) NOT NULL,
  `FromAddress` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ToAddress` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `OtherDetails` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `NoOfPackages` varchar(10) NOT NULL,
  `Weight` varchar(80) NOT NULL,
  `WeightUnit` varchar(10) NOT NULL,
  `LineItem` text NOT NULL,
  `Label` varchar(100) NOT NULL,
  `SendingLabel` varchar(100) NOT NULL,
  `LabelChild` text NOT NULL,
  `Deleted` tinyint(1) NOT NULL,
  `DeliveryDate` varchar(15) NOT NULL,
  `ipaddress` varchar(40) NOT NULL,
  PRIMARY KEY (`ShipmentID`),
  KEY `ModuleType` (`ModuleType`),
  KEY `RefID` (`RefID`),
  KEY `ShippingCarrier` (`ShippingCarrier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `customer_sales_commission` (
  `ID` INT NOT NULL AUTO_INCREMENT , 
  `CustomerId` INT NOT NULL , 
  `EmpSpId` INT NOT NULL , 
  `VenSpId` INT NOT NULL , 
  `CommPercentage` FLOAT NOT NULL , 
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




CREATE TABLE `archive_s_order` LIKE `s_order`;  
ALTER TABLE `archive_s_order` MODIFY `OrderID` INT;
ALTER TABLE `archive_s_order` DROP PRIMARY KEY;
ALTER TABLE `archive_s_order` ADD `ArchiveID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE `archive_s_order` ADD `ArchiveDate` DATETIME NOT NULL AFTER `ArchiveID`;

CREATE TABLE `archive_s_order_item` LIKE `s_order_item`;
ALTER TABLE `archive_s_order_item` MODIFY `id` INT;	
ALTER TABLE `archive_s_order_item` DROP PRIMARY KEY;	
ALTER TABLE `archive_s_order_item` ADD `ArchiveID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST; 

CREATE TABLE `archive_s_order_card` LIKE `s_order_card`;
ALTER TABLE `archive_s_order_card` MODIFY `ID` INT;
ALTER TABLE `archive_s_order_card` DROP PRIMARY KEY;
ALTER TABLE `archive_s_order_card` ADD `ArchiveID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST; 

CREATE TABLE `archive_f_income` LIKE `f_income`;
ALTER TABLE `archive_f_income` MODIFY `IncomeID` INT;
ALTER TABLE `archive_f_income` DROP PRIMARY KEY;
ALTER TABLE `archive_f_income` ADD `ArchiveID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST; 

CREATE TABLE `archive_f_multi_account` LIKE `f_multi_account`;
ALTER TABLE `archive_f_multi_account` MODIFY `ID` INT;
ALTER TABLE `archive_f_multi_account` DROP PRIMARY KEY;
ALTER TABLE `archive_f_multi_account` ADD `ArchiveID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST; 

CREATE TABLE `archive_w_shipment` LIKE `w_shipment`;
ALTER TABLE `archive_w_shipment` MODIFY `ShipmentID` INT;
ALTER TABLE `archive_w_shipment` DROP PRIMARY KEY;
ALTER TABLE `archive_w_shipment` ADD `ArchiveID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST; 


