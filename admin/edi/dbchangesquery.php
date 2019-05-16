/** 4 Dec 201**/

INSERT INTO `erp`.`department` (`depID`, `Department`, `Status`) VALUES (NULL, 'EDI', '1');

INSERT INTO `erp_MKB`.`department` (`depID`, `Department`, `Status`) VALUES (NULL, 'EDI', '1');

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES (NULL, 'Request For EDI', '', '10', '0', '0', '1', '0');

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES (NULL, 'Request For EDI', 'requestEDI.php', '0', '3035', '0', '1', '0');

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES (NULL, 'Requested EDI', 'requestEDI.php?type=Reqest', '0', '3035', '0', '1', '0');

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES (NULL, 'Accepted EDI', 'requestEDI.php?type=Accept', '0', '3035', '0', '1', '0');

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES (NULL, 'Rejected EDI', 'requestEDI.php?type=Reject', '0', '3035', '0', '1', '0');

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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `s_customers` ADD `EDICompId` INT NOT NULL AFTER `fbcffb`, ADD `EDICompName` VARCHAR(40) NOT NULL AFTER `EDICompId`;
ALTER TABLE `p_supplier` ADD `EDICompId` INT NOT NULL AFTER `EIN`, ADD `EDICompName` VARCHAR(40) NOT NULL AFTER `EDICompId`; 

ALTER TABLE `s_order` ADD `EDICompId` INT NOT NULL AFTER `PostToGLDate`, ADD `EDICompName` VARCHAR(40) NOT NULL AFTER `EDICompId`, ADD `EDIRefNo` VARCHAR(30) NOT NULL AFTER `EDICompName`; 
 
 ALTER TABLE `p_order` ADD `EDICompId` INT NOT NULL AFTER `PostToGLDate`, ADD `EDICompName` VARCHAR(40) NOT NULL AFTER `EDICompId`, ADD `EDIRefNo` VARCHAR(30) NOT NULL AFTER `EDICompName`; 
  
  
  
  
TRUNCATE table p_order;
TRUNCATE table p_order_item;
TRUNCATE table s_order_item;
TRUNCATE table s_order;
TRUNCATE TABLE `inv_item_transaction` 
TRUNCATE TABLE `edi_company` ;

 DELETE FROM `erp_sakshay`.`s_customers` WHERE `EDICompId` = 81
 
 DELETE FROM `erp_JheanelleS`.`p_supplier` WHERE `EDICompId` = 37


