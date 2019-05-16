CREATE TABLE IF NOT EXISTS `admin_modules` (
  `ModuleID` int(10) NOT NULL,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Parent` int(10) NOT NULL DEFAULT '0',
  `Default` tinyint(4) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES
(1, 'Company Settings', '', 0, 0, 0, 1, 0),
(16, 'Security', '', 0, 0, 0, 1, 0),
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
(67, 'Leave Period', 'leavePeriod.php', 0, 15, 0, 0, 0),
(73, 'Holidays', 'viewHoliday.php', 0, 3, 0, 1, 0),
(74, 'Leave Entitlement', 'viewEntitlement.php', 0, 3, 0, 1, 0),
(75, 'Manage Leave', 'viewLeave.php', 0, 3, 0, 1, 1),
(31, 'Leave Report', 'viewLeaveReport.php', 0, 30, 0, 1, 0),
(77, 'Manage Candidates', 'viewCandidate.php?module=Manage', 0, 4, 0, 1, 0),
(78, 'Leave Applied to Me', 'leaveApplied.php', 0, 6, 1, 0, 0),
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
(132, 'Flagged Opportunity', 'viewOpportunity.php?module=flag', 0, 103, 0, 1, 0),
(135, 'Flagged Ticket', 'viewTicket.php?module=flag', 0, 104, 0, 1, 0),
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
(128, 'Junk Lead', 'viewLead.php?module=junk', 0, 102, 0, 1, 0),
(129, 'Flagged Lead', 'viewLead.php?module=flag', 0, 102, 0, 1, 0),
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
(86, 'Payroll Structure', 'viewPayStructure.php', 0, 12, 0, 0, 1),
(87, 'Employee Salary', 'viewSalary.php', 0, 12, 0, 1, 2),
(138, 'Manage Event / Task', 'viewActivity.php?module=Activity', 0, 136, 0, 1, 0),
(140, 'Lead Document', 'viewDocument.php?module=Lead', 0, 102, 0, 0, 0),
(141, 'Opportunity Document', 'viewDocument.php?module=Opportunity', 0, 103, 0, 0, 0),
(143, 'Campaign Type', 'viewAttribute.php?att=54', 0, 115, 0, 1, 0),
(144, 'Manage Quotes', 'viewQuote.php?module=Quote', 0, 108, 0, 1, 0),
(145, 'Ticket Document', 'viewDocument.php?module=Ticket', 0, 104, 0, 0, 0),
(146, 'Event Document', 'viewDocument.php?module=Event', 0, 136, 0, 0, 0),
(147, 'Expected Response', 'viewAttribute.php?att=55', 0, 115, 0, 1, 0),
(153, 'Activity Status', 'viewAttribute.php?att=18', 0, 115, 0, 1, 0),
(154, 'Activity Type', 'viewAttribute.php?att=19', 0, 115, 0, 1, 0),
(155, 'Manage Territory', 'viewTerritory.php', 0, 115, 0, 1, 0),
(156, 'Territory Rules', 'viewTerritoryRule.php', 0, 115, 0, 1, 0),
(157, 'Territory Customer Report', 'territoryCustomerReport.php', 0, 116, 0, 1, 0),
(158, 'Territory Lead Report', 'territoryLeadReport.php', 0, 116, 0, 1, 0),
(164, 'Mass Email', '', 5, 0, 0, 1, 11),
(165, 'MailChimp', 'mailchimp.php', 0, 164, 0, 1, 1),
(166, 'iContact', 'mailicontact.php', 0, 164, 0, 0, 2),
(167, 'Constant Contact', 'mailconstantcontact.php', 0, 164, 0, 0, 3),
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
(88, 'Generated Salary', 'viewGeneratedSalary.php', 0, 12, 0, 0, 3),
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
(602, 'Stock Adjustments', '', 6, 0, 0, 0, 0),
(603, 'Stock Transfers', '', 6, 0, 0, 0, 0),
(604, 'BOM', '', 6, 0, 0, 0, 0),
(610, 'Settings', '', 6, 0, 0, 0, 0),
(628, 'Manage Items', 'viewItem.php', 0, 601, 0, 1, 0),
(629, 'Manage Unit', 'viewAttribute.php?att=11', 0, 610, 0, 0, 0),
(630, 'Tax Rate', 'viewTax.php', 0, 610, 0, 0, 0),
(631, 'Tax Class', 'viewTaxClass.php', 0, 610, 0, 0, 0),
(632, 'Manage Variant', 'managevariant.php', 0, 610, 0, 0, 0),
(634, 'Manage Categories', 'viewCategory.php', 0, 601, 0, 1, 0),
(635, 'Item Type', 'viewAttribute.php?att=1', 0, 610, 0, 0, 0),
(636, 'Procurement', 'viewAttribute.php?att=2', 0, 610, 0, 0, 0),
(637, 'Valuation Type', 'viewAttribute.php?att=3', 0, 610, 0, 0, 0),
(638, 'Adjustments', 'viewAdjustment.php', 0, 602, 0, 0, 0),
(639, 'Adjustment Reason', 'viewAttribute.php?att=13', 0, 610, 0, 0, 0),
(640, 'Manage Stock Transfer', 'viewTransfer.php', 0, 603, 0, 0, 0),
(641, 'Manage BOM', 'viewBOM.php', 0, 604, 0, 0, 0),
(642, 'Manage Prefixes', 'editPrefixes.php', 0, 610, 0, 0, 0),
(648, 'Manage Model', 'viewModel.php', 0, 610, 0, 0, 0),
(649, 'Manage Generation', 'viewAttribute.php?att=5', 0, 610, 0, 0, 0),
(650, 'Manage Extended', 'viewAttribute.php?att=7', 0, 610, 0, 0, 0),
(651, 'Manage Manufacture', 'viewAttribute.php?att=8', 0, 610, 0, 0, 0),
(652, 'Manage Condition', 'viewCondition.php', 0, 610, 0, 0, 0),
(653, 'Reorder Method', 'viewAttribute.php?att=9', 0, 610, 0, 0, 0),
(654, 'Stock Search', 'searchItemStock.php', 0, 601, 0, 0, 0),
(655, 'Manage Disassembly', 'viewDisassembly.php', 0, 604, 0, 0, 0),
(403, 'Purchase Order', '', 4, 0, 0, 1, 3),
(404, 'Invoices', '', 4, 0, 0, 0, 4),
(405, 'RMA', '', 4, 0, 0, 1, 5),
(407, 'Credit Note', '', 4, 0, 0, 0, 0),
(409, 'Report', '', 4, 0, 0, 1, 0),
(410, 'Settings', '', 4, 0, 0, 0, 0),
(411, 'Purchase Quote', 'viewPO.php?module=Quote', 0, 402, 0, 1, 0),
(413, 'Purchase Order', 'viewPO.php?module=Order', 0, 403, 0, 1, 0),
(414, 'Invoices', 'viewPoInvoice.php', 0, 404, 0, 1, 0),
(415, 'Manage Vendor', 'viewSupplier.php', 0, 401, 0, 1, 0),
(416, 'Vendor Purchases', 'viewSuppPO.php', 0, 401, 0, 1, 0),
(417, 'Vendor Invoices', 'viewSuppInvoice.php', 0, 401, 0, 1, 0),
(418, 'RMA', 'viewRma.php', 0, 405, 0, 1, 0),
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
(721, 'RMA', 'viewRma.php', 0, 705, 0, 1, 0),
(643, 'Price List', 'viewPriceList.php', 0, 601, 0, 0, 0),
(644, 'Serial Number List', 'viewSerial.php', 0, 601, 0, 0, 0),
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
(705, 'RMA', '', 7, 0, 0, 1, 0),
(704, 'Invoices', '', 7, 0, 0, 0, 0),
(703, 'Sales Order', '', 7, 0, 0, 1, 0),
(702, 'Sales Quote', '', 7, 0, 0, 1, 0),
(701, 'Customer', '', 7, 0, 0, 0, 1),
(707, 'Credit Note', '', 7, 0, 0, 0, 0),
(726, 'Credit Note', 'viewCreditNote.php', 0, 707, 0, 1, 0),
(727, 'Payment History', 'viewPayReport.php', 0, 706, 0, 0, 0),
(645, 'Manage Assembly', 'viewAssemble.php', 0, 604, 0, 0, 0),
(605, 'Report', '', 6, 0, 0, 0, 0),
(646, 'Stock Transfer Report', 'viewTransferReport.php', 0, 605, 0, 0, 0),
(647, 'Stock Adjustment Report', 'viewAdjReport.php', 0, 605, 0, 0, 0),
(324, 'Stock Transfer', 'viewStockTransfer.php', 0, 302, 0, 0, 0),
(323, 'RMA', 'viewSalesReturn.php', 0, 302, 0, 1, 0),
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
(339, 'RMA Action', 'viewRmaAction.php', 0, 306, 0, 1, 0),
(340, 'RMA Reason', 'viewAttrib.php?att=7', 0, 306, 0, 1, 0),
(329, 'Stock Adjustment', 'viewStockAdjustment.php', 0, 302, 0, 0, 0),
(330, 'Manage Cargo', 'viewCargo.php', 0, 305, 0, 1, 1),
(331, 'Assemble Order', 'viewProduction.php', 0, 303, 0, 1, 0),
(332, 'Shipment', 'viewShipment.php', 0, 304, 0, 1, 0),
(115, 'Settings', '', 5, 0, 0, 1, 10),
(116, 'Report', '', 5, 0, 0, 1, 0),
(149, 'Lead Report', 'viewLeadReport.php', 0, 116, 0, 1, 0),
(1004, 'Loan', 'myLoan.php', 0, 9, 0, 1, 0),
(1005, 'Global Settings', 'globalSetting.php', 0, 15, 0, 1, 1),
(1006, 'Overtime', 'viewOvertime.php', 0, 5, 0, 1, 0),
(1003, 'Advance', 'myAdvance.php', 0, 9, 0, 1, 0),
(1002, 'Loan', 'viewLoan.php', 0, 12, 0, 1, 0),
(1001, 'Advance', 'viewAdvance.php', 0, 12, 0, 1, 0),
(1007, 'Bonus', 'viewBonus.php', 0, 12, 0, 1, 0),
(1008, 'Short Leave', 'viewShortLeave.php', 0, 3, 0, 1, 0),
(1009, 'Send Request', 'sendRequest.php', 0, 9, 0, 0, 0),
(1010, 'Employee Request', 'viewRequest.php', 0, 11, 0, 0, 0),
(1011, 'Comp-Off', 'viewComp.php', 0, 3, 0, 0, 0),
(1012, 'Compensation', 'myComp.php', 0, 6, 0, 0, 0),
(1013, 'Comp-Off Applied to Me', 'compApplied.php', 0, 6, 0, 0, 0),
(1015, 'Email Template', 'email_template.php', 0, 15, 0, 0, 0),
(1014, 'Events', 'viewEvent.php', 0, 11, 0, 0, 0),
(96, 'Manage Assets', 'viewAsset.php', 0, 14, 0, 1, 1),
(97, 'Manage Brand', 'viewAttrib.php?att=24', 0, 14, 0, 0, 0),
(98, 'Manage Category', 'viewAttrib.php?att=25', 0, 14, 0, 0, 0),
(99, 'Manage Vendor', 'viewVendor.php', 0, 14, 0, 0, 0),
(100, 'Assigned Assets', 'viewAssignAsset.php', 0, 14, 0, 1, 2),
(14, 'Assets', '', 1, 0, 0, 1, 0),
(1017, 'Attrition Report', 'attritionReport.php', 0, 30, 0, 0, 0),
(1018, 'Work Shift', 'viewShift.php', 0, 15, 0, 1, 2),
(1019, 'Expense Claim', 'viewExpenseClaim.php', 0, 12, 0, 0, 0),
(1020, 'Expense Claim', 'myExpenseClaim.php', 0, 9, 1, 0, 0),
(1021, 'Appraisal', 'viewAppraisal.php', 0, 12, 0, 0, 4),
(1022, 'Payroll Report', 'viewPayrollReport.php', 0, 12, 0, 1, 2),
(333, 'Ship Transfer Order', 'viewTransferOrder.php', 0, 304, 0, 0, 0),
(334, 'Purchase RMA', 'viewPoRma.php', 0, 304, 0, 1, 0),
(335, 'Released Production Orders', 'viewProductionOrder.php', 0, 304, 0, 0, 0),
(336, 'Manage Shipping', 'viewShipOrder.php', 0, 304, 0, 0, 0),
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
(2015, 'Customer', '', 5, 0, 0, 1, 9),
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
(822, 'Account Types', 'viewAccountType.php', 0, 801, 0, 1, 0),
(823, 'General Journal', 'viewGeneralJournal.php', 0, 804, 0, 1, 0),
(824, 'Other Income', 'viewOtherIncome.php', 0, 802, 0, 0, 0),
(825, 'Vendor Payments', 'viewPurchasePayments.php', 0, 803, 0, 1, 3),
(826, 'Invoice Entry', 'viewOtherExpense.php', 0, 803, 0, 0, 0),
(827, 'Transfer', 'viewTransfer.php', 0, 804, 0, 0, 0),
(828, 'Bank Deposit', 'viewDeposit.php', 0, 804, 0, 0, 0),
(829, 'Profit and Loss', 'reportProfitLoss.php', 0, 805, 0, 1, 1),
(830, 'Balance Sheet', 'reportBalanceSheet.php', 0, 805, 0, 1, 2),
(831, 'Period End', 'periodEndSetting.php', 0, 801, 0, 1, 0),
(832, 'Customer Tax', 'viewSalesTaxReport.php', 0, 805, 0, 1, 0),
(833, 'Vendor Tax', 'viewPurchaseTaxReport.php', 0, 805, 0, 1, 0),
(834, 'AR Aging', 'arAging.php', 0, 805, 0, 1, 0),
(835, 'AP Aging', 'apAging.php', 0, 805, 0, 1, 0),
(836, 'Bank Reconciliation', 'bankReconciliation.php', 0, 803, 0, 1, 6),
(837, 'Spiff Setting', 'spiffSetting.php', 0, 810, 0, 1, 2),
(838, 'Trial Balance', 'reportTrialBalance.php', 0, 805, 0, 1, 3),
(860, 'Manage Customer', 'viewCustomer.php', 0, 802, 0, 1, 0),
(861, 'Customer Order', 'viewCustomerOrderInvoice.php?module=Order', 0, 802, 0, 1, 0),
(862, 'Customer Invoice', 'viewCustomerOrderInvoice.php?module=Invoice', 0, 802, 0, 1, 0),
(863, 'Customer Return', 'viewCustomerReturn.php?module=Return', 0, 802, 0, 0, 0),
(865, 'Invoices', 'viewInvoice.php', 0, 802, 0, 1, 0),
(866, 'Credit Note', 'viewCreditNote.php', 0, 802, 0, 1, 0),
(870, 'Manage Vendor', 'viewSupplier.php', 0, 803, 0, 1, 1),
(871, 'Vendor Purchases', 'viewSuppPO.php', 0, 803, 0, 0, 0),
(872, 'Vendor Invoice Entry', 'viewVendorInvoiceEntry.php', 0, 803, 0, 1, 2),
(873, 'Vendor Returns', 'viewSuppReturn.php', 0, 803, 0, 0, 0),
(874, 'Vendor Price List', 'viewSuppPrice.php', 0, 803, 0, 0, 0),
(880, 'Vendor Invoices', 'viewPoInvoice.php', 0, 803, 0, 1, 5),
(881, 'Vendor Credit Memo', 'viewPoCredit.php', 0, 803, 0, 1, 4),
(882, 'Invoice Report', 'viewInvReport.php', 0, 803, 0, 1, 7),
(883, 'Payment History', 'viewPaymentReport.php', 0, 803, 0, 0, 0),
(885, 'Payment Term', 'viewTerm.php', 0, 810, 0, 1, 0),
(886, 'Sales Statistics', 'viewSalesStatistics.php', 0, 802, 0, 1, 0),
(887, 'Payment History', 'viewPayReport.php', 0, 802, 0, 1, 0),
(888, 'Sales Commission Report', 'viewSalesCommReport.php', 0, 802, 0, 1, 0),
(150, 'Activity Document', 'viewDocument.php?module=Activity', 0, 136, 0, 0, 0),
(170, 'Recurring Event / Task', 'viewRecurringActivity.php', 0, 136, 0, 1, 0),
(171, 'Recurring Quotes', 'viewRecurringQuote.php', 0, 108, 0, 1, 0),
(175, 'Create Lead Form', 'viewCreateLead.php', 0, 102, 0, 1, 0),
(731, 'Recurring', '', 7, 0, 0, 1, 0),
(732, 'Recurring Order', 'viewRecurringSO.php?module=Order', 0, 731, 0, 1, 0),
(733, 'Recurring Quote', 'viewRecurringSO.php?module=Quote', 0, 731, 0, 1, 0),
(890, 'Recurring Invoices', 'viewRecurringInvoice.php', 0, 802, 0, 1, 0),
(891, 'Sales by Reseller', 'viewSalesbyReseller.php', 0, 802, 0, 0, 0),
(892, 'Reseller - Sales Commission Report', 'viewRsSalesCommReport.php', 0, 802, 0, 0, 0),
(1050, 'Session Log', 'viewUserLog.php', 0, 16, 0, 1, 0),
(1051, 'Call Setting', 'viewcallsetting.php', 0, 1, 0, 1, 0),
('1052', 'User Profile Log', 'viewUserProfileLog.php', '0', '16', '0', '1', '0'),
('1053', 'IP Restriction', 'IpRestriction.php', '0', '16', '0', '1', '0'),
('2017', 'Leave Approval Check', 'viewLeaveCheck.php', '0', '15', '0', '0', '0'),
('2018', 'Benefits', 'viewBenefit.php', '0', '15', '0', '1', '0'),
('2019', 'Benefits', 'myBenefit.php', '0', '9', '0', '1', '0'),
('176', 'Phone', '0', '5', '0', '0', '0', '10'),
('177', 'Employee Connect', 'employeeConnect.php', '0', '176', '0', '1', '0'),
('178', 'Voicemail', 'ViewVoicemail.php', '0', '176', '0', '1', '0'),
('180', 'Call', 'call.php', '0', '176', '0', '1', '0'),
('181', 'Call List', 'call-list.php', '0', '176', '0', '1', '0'),
('2020', 'Leave Custom Rule', 'viewLeaveRule.php', '0', '3', '0', '1', '0'),
(2021, 'Custom Report Rule', 'viewReportRule.php', 0, 5, 0, 1, 0),
(2022, 'Custom Report', 'viewCustomReport.php', 0, 5, 0, 1, 0),
('2023', 'Filing Status', 'viewFiling.php', '0', '15', '0', '1', '0'),
('2024', 'Tax Bracket', 'viewTaxBracket.php', '0', '15', '0', '1', '0'),
(2025, 'Email', '', 5, 0, 0, 1, 0),
(2026, 'Email Setting', 'viewImportEmailId.php', 0, 2025, 0, 1, 0),
(2027, 'Compose Email', 'composeEmail.php', 0, 2025, 0, 1, 2),
(2028, 'Sent Emails', 'sentEmails.php', 0, 2025, 0, 1, 4),
(2029, 'Trash Emails', 'trashEmail.php', 0, 2025, 0, 1, 6),
(2031, 'Draft', 'draftList.php', 0, 2025, 0, 1, 3),
(2032, 'Inbox', 'viewImportedEmails.php', 0, 2025, 0, 1, 1),
(2033, 'Spam', 'spamEmail.php', 0, 2025, 0, 1, 5),
(2034, 'Flagged Emails', 'flaggedEmail.php', 0, 2025, 0, 1, 7),
(2035, 'Rule Setting', 'viewRulesForEmail.php', 0, 2025, 0, 1, 8),
('160', 'Social CRM', '0', '5', '0', '0', '1', '10'),
('161', 'Facebook', 'facebook.php', '0', '160', '0', '1', '0'),
('162', 'LinkedIn', 'Linkedin.php', '0', '160', '0', '1', '0'),
('163', 'Twitter', 'Twitter.php', '0', '160', '0', '1', '0'),
('179', 'Google Plus', 'google-plus.php', '0', '160', '0', '1', '0'),
('168', 'Instagram', 'instagram.php', '0', '160', '0', '1', '0'),
(2041, 'Lead Rating By Industry', 'leadReportByIndustry.php', 0, 116, 0, 1, 0),
(2042, 'Lead Rating By Sales Person', 'ratingReportBySalesPerson.php', 0, 116, 0, 1, 0),
(2043, 'Lead Rating By Annual Revenue', 'ratingReportbyAnnualRevenue.php', 0, 116, 0, 1, 0),
(2044, 'Lead Rating By Territory', 'ratingReportByTerritory.php', 0, 116, 0, 1, 0),
(2051, 'Payment Method', 'viewAttribF.php?att=1', 0, 115, 0, 1, 0),
(2052, 'Payment Term', 'viewTerm.php', 0, 115, 0, 1, 0),
(2053, 'Shipping Method', 'viewAttribW.php?att=6', 0, 115, 0, 1, 0),
(2054, 'Manage Taxes', 'viewTax.php', 0, 115, 0, 1, 0),
(2059, 'Payroll Period', 'viewPayPeriod.php', 0, 15, 0, 1, 0),
(2060, 'Deductions', 'viewDeduction.php', 0, 15, 0, 1, 0),
(2061, 'Deduction Rule', 'viewDeductionRule.php', 0, 15, 0, 1, 0),
(2062, 'Role Group', 'viewRoleGroup.php', 0, 15, 0, 1, 0),
(2063, 'Role Group', 'viewRoleGroup.php', 0, 115, 0, 1, 0),
(182, 'Chat', '', 5, 0, 0, 1, 0),
(183, 'Chat List', 'chatlist.php', 0, 182, 0, 1, 0),
(185, 'Offline Message', 'offline-message.php', 0, 182, 0, 1, 0),
(1054, 'Chat Setting', 'chatsetting.php', 0, 1, 0, 1, 0),
(1055, 'Inventory Setting', 'inventorySetting.php', 0, 1, 0, 0, 0),
(194, 'Manage Folder', 'viewDocumentFolder.php?module=Document', 0, 105, 0, 1, 0),
(195, 'Workspace', '', 5, 0, 0, 1, 0),
(196, 'My Workspace', 'workspace.php', 0, 195, 0, 1, 0),
(2099, 'Manage Headers', 'viewHeads.php', 0, 115, 0, 1, 0),
(3000, 'Custom Fields', 'CrmSetting.php', 0, 115, 0, 1, 0),
(3006, 'Menu', '', 9, 0, 0, 1, 1),
(3007, 'Manage Menu', 'viewMenus.php', 0, 3006, 0, 1, 0),
(3008, 'Page', '', 9, 0, 0, 1, 0),
(3009, 'Manage Page', 'viewContents.php', 0, 3008, 0, 1, 0),
(3010, 'Template', '', 9, 0, 0, 1, 0),
(3011, 'Manage Template', 'template.php', 0, 3010, 0, 1, 0),
(3012, 'Setting', '', 9, 0, 0, 1, 0),
(3013, 'Global Setting', 'setting.php', 0, 3012, 0, 1, 0),
(3015, 'Form', '', 9, 0, 0, 1, 3),
(3016, 'Custom Form', 'viewForms.php', 0, 3015, 0, 1, 0),
(3017, 'Form Fields', 'viewFormFields.php', 0, 3015, 0, 1, 0),
(3018, 'Customer Form Data', 'viewFormData.php', 0, 3015, 0, 1, 0),
(3019, 'Group Discount', 'groupDiscount.php', 0, 205, 0, 1, 0),
(3022, 'Template', '', 2, 0, 0, 1, 4),
(3023, 'Manage Template', 'template.php', 0, 3022, 0, 1, 0),
(3030, 'Manage Variant', 'managevariant.php', 0, 204, 0, 1, 0),
(3021, 'Social Links', 'socialLinks.php', 0, 204, 0, 1, 0),
(3029, 'Slider Banner', 'sliderBanners.php', 0, 204, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `blocksnew`
--

CREATE TABLE IF NOT EXISTS `blocksnew` (
  `BlockID` int(10) NOT NULL,
  `Block` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `BlockHeading` varchar(50) NOT NULL,
  `depID` int(10) NOT NULL,
  `OrderBy` int(5) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `ConfigID` int(11) NOT NULL,
  `RecordsPerPage` int(11) NOT NULL DEFAULT '10',
  `Tax` float(10,2) NOT NULL DEFAULT '5.00',
  `Shipping` float(10,2) NOT NULL DEFAULT '20.00',
  `PaypalID` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `MetaKeywords` text COLLATE latin1_general_ci NOT NULL,
  `MetaDescription` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
INSERT INTO `configuration` (`ConfigID`, `RecordsPerPage`, `Tax`, `Shipping`, `PaypalID`, `MetaKeywords`, `MetaDescription`) VALUES
(1, 20, 0.00, 0.00, 'test@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `c_activity`
--

CREATE TABLE IF NOT EXISTS `c_activity` (
  `activityID` int(15) NOT NULL,
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
  `add_date` date NOT NULL,
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
  `c4cfc4` varchar(100) DEFAULT NULL,
  `e5cfe5` varchar(50) DEFAULT NULL,
  `a8cfa8` varchar(50) DEFAULT NULL,
  `40cf40` varchar(100) DEFAULT NULL,
  `15cf15` varchar(100) DEFAULT NULL,
  `70cf70` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_quote_item_variant`
--

CREATE TABLE IF NOT EXISTS `c_quote_item_variant` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `quote_item_ID` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `variantID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_quote_item_variantOptionValues`
--

CREATE TABLE IF NOT EXISTS `c_quote_item_variantOptionValues` (
  `id` int(11) NOT NULL,
  `quote_item_ID` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `variantID` int(11) NOT NULL,
  `variantOPID` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_territory`
--

CREATE TABLE IF NOT EXISTS `c_territory` (
  `TerritoryID` int(11) NOT NULL,
  `Name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ParentID` int(100) NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  `NumSubTerritory` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(10) NOT NULL,
  `AddedDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_territory_assign`
--

CREATE TABLE IF NOT EXISTS `c_territory_assign` (
  `AssignID` int(20) NOT NULL,
  `TerritoryID` text NOT NULL,
  `AssignType` varchar(15) NOT NULL,
  `AssignTo` int(20) NOT NULL,
  `ManagerID` int(20) NOT NULL,
  `AddedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_territory_rule`
--

CREATE TABLE IF NOT EXISTS `c_territory_rule` (
  `TRID` int(11) NOT NULL,
  `TerritoryID` int(11) unsigned NOT NULL,
  `SalesPersonID` int(11) unsigned NOT NULL,
  `SalesPerson` varchar(100) NOT NULL,
  `CreatedDate` date NOT NULL,
  `IPAddress` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_territory_rule_location`
--

CREATE TABLE IF NOT EXISTS `c_territory_rule_location` (
  `TRLID` int(11) NOT NULL,
  `TRID` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_icon`
--

CREATE TABLE IF NOT EXISTS `dashboard_icon` (
  `IconID` int(10) NOT NULL,
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
  `Default` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
(99, 'Punch In/Out', 'punching.php', 5, 0, 'i', 1, 1, 1, 0, 4, 1),
(24, 'Report', 'viewLeaveReport.php', 30, 0, '', 1, 1, 1, 24, 3, 0),
(301, 'Warehouse', 'viewWarehouse.php', 301, 0, '', 3, 1, 1, 1, 0, 0),
(303, 'Bin', 'viewManageBin.php', 301, 0, '', 3, 1, 1, 2, 3, 0),
(307, 'Assemble Order', 'viewProduction.php', 303, 0, '', 3, 1, 1, 6, 0, 0),
(309, 'Pick & Put Qty', 'viewInternalBinOrder.php', 303, 0, '', 3, 1, 1, 7, 0, 0),
(311, 'Cargo', 'viewCargo.php', 305, 0, '', 3, 1, 1, 10, 0, 0),
(313, 'Ship Sales Order', 'viewShipment.php', 302, 0, '', 3, 1, 1, 4, 4, 0),
(314, 'Receive PO', 'viewPoInvoice.php', 302, 0, '', 3, 1, 1, 3, 3, 0),
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
(605, 'Price List', 'viewPriceList.php', 601, 0, '', 6, 0, 1, 0, 2, 0),
(606, 'Stock Adjustment', 'viewAdjustment.php', 602, 1, '', 6, 0, 1, 0, 0, 0),
(607, 'Stock Transfers', 'viewTransfer.php', 603, 0, '', 6, 0, 1, 0, 2, 0),
(608, 'BOM', 'viewBOM.php', 604, 1, '0', 6, 0, 1, 0, 0, 0),
(122, 'Add Customer', 'addCustomer.php', 2015, 1, '', 5, 1, 1, 22, 0, 0),
(120, 'Add Item', 'editItem.php', 2003, 1, '', 5, 1, 1, 20, 0, 0),
(121, 'Customer', 'viewCustomer.php', 2015, 0, '', 5, 1, 1, 21, 2, 0),
(119, 'Items', 'viewItem.php', 2003, 0, '', 5, 1, 1, 19, 2, 0),
(117, 'Users', 'viewUser.php', 2001, 0, '', 5, 1, 1, 17, 2, 0),
(118, 'Add User', 'editUser.php', 2001, 1, '', 5, 1, 1, 18, 0, 0),
(609, 'Users', 'viewUser.php', 2005, 0, '', 6, 1, 1, 0, 2, 0),
(610, 'Add User', 'editUser.php', 2005, 1, '', 6, 1, 1, 0, 0, 0),
(612, 'Stock Search', 'searchItemStock.php', 601, 1, '0', 6, 0, 1, 2, 0, 0),
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

-- --------------------------------------------------------

--
-- Table structure for table `default_screen`
--

CREATE TABLE IF NOT EXISTS `default_screen` (
  `id` bigint(20) NOT NULL,
  `ScreenID` int(10) NOT NULL,
  `OrderBy` int(5) NOT NULL DEFAULT '0',
  `UpdatedDate` datetime NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(10) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `depID` int(10) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `department` (`depID`, `Department`, `Status`) VALUES
(1, 'HRMS', 1),
(2, 'E-Commerce', 1),
(3, 'Warehouse', 1),
(4, 'Purchasing', 1),
(5, 'CRM', 1),
(6, 'Inventory', 1),
(7, 'Sales', 1),
(8, 'Finance', 1),
(9, 'Website', 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_cat`
--

CREATE TABLE IF NOT EXISTS `email_cat` (
  `CatID` int(10) NOT NULL,
  `department` int(15) NOT NULL,
  `Name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OrderLevel` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `email_cat` (`CatID`, `department`, `Name`, `OrderLevel`) VALUES
(1, 5, 'Lead Assign', 0),
(2, 5, 'New Lead', 0),
(3, 5, 'New Opportunity', 0),
(4, 5, 'Opportunity Assign', 0),
(5, 5, 'New Ticket', 0),
(6, 5, 'Ticket Assign', 0),
(7, 5, 'New Quote', 0),
(8, 5, 'Quote Assign', 0),
(9, 5, 'Ticket Notification', 0);

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `TemplateID` int(11) NOT NULL,
  `CatID` int(10) NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `arr_field` text NOT NULL,
  `Status` int(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `email_template` (`TemplateID`, `CatID`, `Title`, `subject`, `Content`, `arr_field`, `Status`) VALUES
(1, 1, NULL, 'New Lead  has been Assigned to You', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Lead  has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below Lead details : <br />\r\n            <br />\r\n            First Name:&nbsp;[FIRSTNAME]<br />\r\n            <br />\r\n            Last Name:&nbsp;[LASTNAME]<br />\r\n            <br />\r\n            Lead Name:&nbsp;[FIRSTNAME] [LASTNAME]<br />\r\n            <br />\r\n            Title:&nbsp;[TITLE]<br />\r\n            <br />\r\n            Primary Email:&nbsp;[PRIMARYEMAIL]<br />\r\n            <br />\r\n            Company:&nbsp;[COMPANY]<br />\r\n            <br />\r\n            Website:&nbsp;[WEBSITE]<br />\r\n            <br />\r\n            Sales Person:&nbsp;[ASSIGNEDTO]<br />\r\n            <br />\r\n            Product:&nbsp;[PRODUCT]<br />\r\n            <br />\r\n            Product Price:&nbsp;[PRODUCTPRICE]<br />\r\n            <br />\r\n            Annual Revenue:&nbsp;[ANNUALREVENUE]<br />\r\n            <br />\r\n            Number Of Employees:&nbsp;[NUMBEROFEMPLOYEES]<br />\r\n            <br />\r\n            Last Contact Date:&nbsp;[LASTCONTACTDATE]<br />\r\n            <br />\r\n            Lead Source:&nbsp;[LEADSOURCE]<br />\r\n            <br />\r\n            Lead Status:&nbsp;[LEADSTATUS]<br />\r\n            <br />\r\n            Lead Date: &nbsp;[LEADDATE]<br />\r\n            <br />\r\n            Description:&nbsp;[DESCRIPTION]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">Sakshay Web Technology Pvt Ltd.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(2, 2, NULL, 'New Lead  has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Lead  has been submitted on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below Lead details : <br />\r\n            <br />\r\n            Lead Name: [FIRSTNAME][LASTNAME]<br />\r\n            <br />\r\n            Title: [TITLE]<br />\r\n            <br />\r\n            Primary Email: [PRIMARYEMAIL]<br />\r\n            <br />\r\n            Sales Person: [ASSIGNEDTO]<br />\r\n            <br />\r\n            Company            : [COMPANY]   <br />\r\n            <br />\r\n            Product:&nbsp;[PRODUCT]<br />\r\n            <br />\r\n            Product Price:&nbsp;[PRODUCTPRICE]<br />\r\n            <br />\r\n            Lead Source:&nbsp;[LEADSOURCE]<br />\r\n            <br />\r\n            Lead Status:&nbsp;[LEADSTATUS]<br />\r\n            <br />\r\n            Lead Date:&nbsp;[LEADDATE]<br />\r\n            <br />\r\n            Description        : [DESCRIPTION]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">Sakshay Web Technology Pvt. Ltd.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(3, 3, NULL, 'New Opportunity  has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">Dear Administrator,<br />\r\n<table cellspacing="5" cellpadding="5" border="0" width="100%" class="tablenormal">\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">\r\n            <p><br />\r\n            New Opportunity  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n            <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Opportunity Name          : [OPPORTUNITYNAME]<br />\r\n            <br />\r\n            Organization&nbsp;&nbsp; : [ORGANIZATIONNAME]<br />\r\n            <br />\r\n            Expected Close Date    :[EXPECTEDCLOSEDATE]<br />\r\n            <br />\r\n            Amount      :[AMOUNT]<br />\r\n            <br />\r\n            Sale stage              : [SALESSTAGE]<br />\r\n            <br />\r\n            Assign To :[ASSIGNEDTO]<br />\r\n            <br />\r\n            Customer&nbsp; :[CUSTOMER]<br />\r\n            <br />\r\n            Lead Source :[LEADSOURCE]<br />\r\n            <br />\r\n            Industry : [INDUSTRY]<br />\r\n            <br />\r\n            Next Step :[NEXTSTEP]<br />\r\n            <br />\r\n            Opportunity Type :[OPPORTUNITYTYPE]<br />\r\n            <br />\r\n            Probability :[PROBABILITY]<br />\r\n            <br />\r\n            Campaign Source :[CAMPAIGNSOURCE]<br />\r\n            <br />\r\n            Forcast Amount:[FORECASTAMOUNT]<br />\r\n            <br />\r\n            Contact Name           :[CONTACTNAME]<br />\r\n            <br />\r\n            Website :[WEBSITE]<br />\r\n            <br />\r\n            Description :[DESCRIPTION]<br />\r\n            <br />\r\n            Sales Person       : [ASSIGNEDTO]<br />\r\n            &nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(4, 4, NULL, 'New Opportunity  has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Opportunity  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Opportunity Name          : [OPPORTUNITYNAME]<br />\r\n            <br />\r\n            Organization&nbsp;&nbsp; : [ORGANIZATIONNAME]<br />\r\n            <br />\r\n            Expected Close Date    :[EXPECTEDCLOSEDATE]<br />\r\n            <br />\r\n            Amount      :[AMOUNT]<br />\r\n            <br />\r\n            Sale stage              : [SALESSTAGE]<br />\r\n            <br />\r\n            Sales Person :[ASSIGNEDTO]<br />\r\n            <br />\r\n            Customer&nbsp; :[CUSTOMER]<br />\r\n            <br />\r\n            Lead Source :[LEADSOURCE]<br />\r\n            <br />\r\n            Industry :[INDUSTRY]<br />\r\n            <br />\r\n            Next Step :[NEXTSTEP]<br />\r\n            <br />\r\n            Opportunity Type :[OPPORTUNITYTYPE]<br />\r\n            <br />\r\n            Probability :[PROBABILITY]<br />\r\n            <br />\r\n            Campaign Source :[CAMPAIGNSOURCE]<br />\r\n            <br />\r\n            Forcast Amount:[FORECASTAMOUNT]<br />\r\n            <br />\r\n            Contact Name           :[CONTACTNAME]<br />\r\n            <br />\r\n            Website :[WEBSITE]<br />\r\n            <br />\r\n            Description :[DESCRIPTION]<br />\r\n            <br />\r\n            <br />\r\n            &nbsp;\r\n            <p>&nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(5, 5, NULL, 'New Ticket  has been Added', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket  has been Added with [PARENT] [[PARENTID]] on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE]    <br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Generate Date         : [CREATEDON]<br />\r\n            <br />\r\n            Priority             : [PRIORITY]   <br />\r\n            <br />\r\n            Description          :[DESCRIPTION]<br />\r\n            <br />\r\n            Status&nbsp;&nbsp; :[STATUS]<br />\r\n            <br />\r\n            Priority&nbsp; : [PRIORITY]<br />\r\n            <br />\r\n            Category&nbsp; :[CATEGORY]<br />\r\n            <br />\r\n            Days : [DAYS]<br />\r\n            <br />\r\n            Hours :[HOURS]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            Assign To:&nbsp;[ASSIGNEDTO]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[Sakshay Web Technology]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(6, 6, NULL, 'Ticket  has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE] <br />\r\n            <br />\r\n            Ticket Status:&nbsp;[STATUS]<br />\r\n            <br />\r\n            Ticket Priority:&nbsp;[PRIORITY]<br />\r\n            <br />\r\n            Sales Person:&nbsp;[ASSIGNEDTO]<br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Days:&nbsp;[DAYS]<br />\r\n            <br />\r\n            Hours:&nbsp;[HOURS]<br />\r\n            <br />\r\n            Description          : [DESCRIPTION]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            Created Date:&nbsp;[CREATEDON]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(8, 8, NULL, 'New Quote has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td width="339" class="blacknormal">New Quote  has been Assigned  on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below his Quote details : <br />\r\n            <br />\r\n            <br />\r\n            Quote Subject          :  [SUBJECT]<br />\r\n            <br />\r\n            Opportunity/Customer:&nbsp;[CUSTOMERTYPE]<br />\r\n            <br />\r\n            Quote Stage : [QUOTESTAGE]<br />\r\n            <br />\r\n            Carrier : [CARRIER]<br />\r\n            <br />\r\n            Sales Person : [ASSIGNEDTO]<br />\r\n            <br />\r\n            Valid till    :  [VALIDTILL]<br />\r\n            <br />\r\n            <br />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till', 1),
(7, 7, NULL, 'New quote has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td width="339" class="blacknormal">New quote  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below the quote details : <br />\r\n            <br />\r\n            Quote ID          :  [QUOTEID]<br />\r\n            <br />\r\n            Subject          :  [SUBJECT]<br />\r\n            <br />\r\n            Opportunity : [OPPORTUNITY]<br />\r\n            <br />\r\n            Type : [CUSTOMERTYPE]<br />\r\n            <br />\r\n            Quote Stage : [QUOTESTAGE]<br />\r\n            <br />\r\n            Carrier : [CARRIER]<br />\r\n            <br />\r\n            Valid Till : [VALIDTILL]<br />\r\n            <br />\r\n            Created By : [CREATED]<br />\r\n            <br />\r\n            Sales Person : [ASSIGNEDTO]<br />\r\n            <br />\r\n            Amount : [TOTALAMOUNT]<br />\r\n            <br />\r\n            Please <a href="[LINK_URL]">Click here</a> to see full detail of this quote.</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till,CREATED,Opportunity,Total Amount', 1),
(9, 9, NULL, 'Ticket Status', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket Status with [PARENT] [[PARENTID]] on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE]    <br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Generate Date         : [CREATEDON]<br />\r\n            <br />\r\n            Priority             : [PRIORITY]   <br />\r\n            <br />\r\n            Description          :[DESCRIPTION]<br />\r\n            <br />\r\n            Status&nbsp;&nbsp; :[STATUS]<br />\r\n            <br />\r\n            Priority&nbsp; : [PRIORITY]<br />\r\n            <br />\r\n            Category&nbsp; :[CATEGORY]<br />\r\n            <br />\r\n            Days : [DAYS]<br />\r\n            &nbsp;<br />\r\n            &nbsp;Hours :[HOURS]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            &nbsp;Assign To:&nbsp;[ASSIGNEDTO]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[Sakshay Web Technology]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1);

-- --------------------------------------------------------

--
-- Table structure for table `e_cart`
--

CREATE TABLE IF NOT EXISTS `e_cart` (
  `CartID` int(11) NOT NULL,
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
  `Variant_ID` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Variant_val_Id` text COLLATE latin1_general_ci NOT NULL,
  `AliasID` int(11) NOT NULL,
  `UploadedFile` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_catalog_attributes`
--

CREATE TABLE IF NOT EXISTS `e_catalog_attributes` (
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Gaid` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_categories`
--

CREATE TABLE IF NOT EXISTS `e_categories` (
  `CategoryID` int(11) NOT NULL,
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
  `item_categoryId` int(11) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_comments`
--

CREATE TABLE IF NOT EXISTS `e_comments` (
  `CommentID` int(11) NOT NULL,
  `StoreID` int(11) NOT NULL,
  `TopicID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `Comment` text COLLATE latin1_general_ci NOT NULL,
  `CommentDetail` text COLLATE latin1_general_ci NOT NULL,
  `AttachFile1` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `AttachFile2` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `CommentDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_courier`
--

CREATE TABLE IF NOT EXISTS `e_courier` (
  `courier_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `city_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `price` float(10,2) DEFAULT NULL,
  `detail` text COLLATE latin1_general_ci NOT NULL,
  `fixed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_customers`
--

CREATE TABLE IF NOT EXISTS `e_customers` (
  `Cid` int(10) unsigned NOT NULL,
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
  `FacebookId` varchar(128) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_customer_group`
--

CREATE TABLE IF NOT EXISTS `e_customer_group` (
  `GroupID` int(11) NOT NULL,
  `GroupName` varchar(255) NOT NULL,
  `GroupCreated` varchar(25) NOT NULL DEFAULT 'admin',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `e_customer_group` (`GroupID`, `GroupName`, `GroupCreated`, `Status`) VALUES
(1, 'General', 'default', 'Yes'),
(2, 'Wholesale', 'default', 'Yes'),
(5, 'Sakshay', 'admin', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `e_delhivery_status`
--

CREATE TABLE IF NOT EXISTS `e_delhivery_status` (
  `delhiveryID` int(11) NOT NULL,
  `DelhiveryStatus` varchar(255) NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `e_delhivery_status` (`delhiveryID`, `DelhiveryStatus`, `Status`) VALUES
(1, 'Pending', 'Yes'),
(2, 'Dispatched', 'Yes'),
(3, 'Delivered', 'Yes'),
(4, 'Returned', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `e_discounts`
--

CREATE TABLE IF NOT EXISTS `e_discounts` (
  `DID` int(10) unsigned NOT NULL,
  `Active` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Min` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Max` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Discount` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `Type` enum('amount','percent') NOT NULL DEFAULT 'amount'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_emails`
--

CREATE TABLE IF NOT EXISTS `e_emails` (
  `EmailId` int(10) unsigned NOT NULL,
  `Email` varchar(64) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Created_Date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_email_signup`
--

CREATE TABLE IF NOT EXISTS `e_email_signup` (
  `MemberID` int(11) NOT NULL,
  `Email` varchar(80) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_feedback`
--

CREATE TABLE IF NOT EXISTS `e_feedback` (
  `feedbackID` int(11) NOT NULL,
  `ProductID` int(10) NOT NULL,
  `Name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Comment` text COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `feedbackDate` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_global_attributes`
--

CREATE TABLE IF NOT EXISTS `e_global_attributes` (
  `Gaid` int(10) unsigned NOT NULL,
  `AttributeType` enum('select','radio','text','textarea') NOT NULL DEFAULT 'select',
  `IsGlobal` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Caption` varchar(255) NOT NULL DEFAULT '',
  `TextLength` int(10) unsigned NOT NULL DEFAULT '0',
  `Options` text,
  `required` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_global_optionList`
--

CREATE TABLE IF NOT EXISTS `e_global_optionList` (
  `Id` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `Gaid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `Price` varchar(50) NOT NULL,
  `PriceType` varchar(30) NOT NULL,
  `Weight` varchar(50) NOT NULL,
  `SortOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Global attributes option ';

-- --------------------------------------------------------

--
-- Table structure for table `e_group_discount`
--

CREATE TABLE IF NOT EXISTS `e_group_discount` (
  `Id` int(11) NOT NULL,
  `GroupDiscount` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_item_alias`
--

CREATE TABLE IF NOT EXISTS `e_item_alias` (
  `AliasID` int(20) NOT NULL,
  `ItemAliasCode` varchar(100) NOT NULL,
  `ProductSku` varchar(30) NOT NULL,
  `VendorCode` varchar(30) NOT NULL,
  `ProductID` int(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `AliasType` varchar(30) NOT NULL,
  `Manufacture` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_manufacturers`
--

CREATE TABLE IF NOT EXISTS `e_manufacturers` (
  `Mid` int(11) NOT NULL,
  `Mname` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Mcode` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Mdetail` text COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_members`
--

CREATE TABLE IF NOT EXISTS `e_members` (
  `MemberID` int(20) NOT NULL,
  `WebsiteStoreOption` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `Counter` int(20) NOT NULL,
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
  `AreaCode` varchar(20) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_membership`
--

CREATE TABLE IF NOT EXISTS `e_membership` (
  `MembershipID` int(11) NOT NULL,
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
  `sort_order` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_membership_history`
--

CREATE TABLE IF NOT EXISTS `e_membership_history` (
  `id` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `MembershipID` int(11) NOT NULL,
  `PackageName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Price` float(10,2) NOT NULL,
  `PaymentGateway` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Payment` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_newsletter_template`
--

CREATE TABLE IF NOT EXISTS `e_newsletter_template` (
  `Templapte_Id` int(11) NOT NULL,
  `Template_Subject` varchar(255) NOT NULL,
  `Template_Name` varchar(255) NOT NULL,
  `Template_Content` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Created_Date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_orderdetail`
--

CREATE TABLE IF NOT EXISTS `e_orderdetail` (
  `OrderDetailId` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ProductOptions` text COLLATE latin1_general_ci NOT NULL,
  `Quantity` int(20) NOT NULL,
  `Price` float(10,2) NOT NULL,
  `TaxRate` float(10,2) NOT NULL,
  `TaxDescription` text COLLATE latin1_general_ci NOT NULL,
  `Variant_ID` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Variant_val_Id` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `AliasID` int(11) NOT NULL,
  `UploadedFile` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_orders`
--

CREATE TABLE IF NOT EXISTS `e_orders` (
  `OrderID` int(11) NOT NULL,
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
  `SecurityId` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_package`
--

CREATE TABLE IF NOT EXISTS `e_package` (
  `PackageID` int(11) NOT NULL,
  `CatID` int(10) NOT NULL DEFAULT '1',
  `Type` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `Name` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Impression` int(10) NOT NULL,
  `Validity` int(10) NOT NULL,
  `Price` decimal(8,2) NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_package_category`
--

CREATE TABLE IF NOT EXISTS `e_package_category` (
  `CatID` int(11) NOT NULL,
  `Name` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_pages`
--

CREATE TABLE IF NOT EXISTS `e_pages` (
  `PageId` int(10) unsigned NOT NULL,
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
  `DisplayMenu` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `e_pages` (`PageId`, `Priority`, `Status`, `Options`, `UrlCustom`, `UrlHash`, `Name`, `MetaKeywords`, `MetaTitle`, `MetaDescription`, `Title`, `Content`) VALUES
(4, 1, 'Yes', 'top', 'about_us', '54b9a8865a965755ad90cdab15541375', 'About Us', 'About Us', 'About Us', 'About Us', 'About Us', '<span style="background-color: Yellow;"><strong>Lorem Ipsum</strong></span> is simply dummy text of the printing and  typesetting industry. Lorem Ipsum has been the industry''s standard dummy  text ever since the 1500s, when an unknown printer took a galley of  type and scrambled it to make a type specimen book. It has survived not  only five centuries, but also the leap into electronic typesetting,  remaining essentially unchanged. It was popularised in the 1960s with  the release of Letraset sheets containing Lorem Ipsum passages, and more  recently with desktop publishing software like Aldus PageMaker  including versions of Lorem Ipsum.  about us'),
(8, 4, 'Yes', 'top', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Specials', 'Specials', 'Specials', 'Specials', 'Specials', 'It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).'),
(6, 3, 'Yes', 'top', 'contact_us', '53a2c328fefc1efd85d75137a9d833ab', 'Contact Us', 'Contact Us', 'Contact Us', 'Contact Us', 'Contact Us', 'It is a long established fact that a reader will be distracted by the \r\nreadable content of a page when looking at its layout. The point of \r\nusing Lorem Ipsum is that it has a more-or-less normal distribution of \r\nletters, as opposed to using ''Content here, content here'', making it \r\nlook like readable English. Many desktop publishing packages and web \r\npage editors now use Lorem Ipsum as their default model text, and a \r\nsearch for ''lorem ipsum'' will uncover many web sites still in their \r\ninfancy. Various versions have evolved over the years, sometimes by \r\naccident, sometimes on purpose (injected humour and the like).'),
(7, 2, 'Yes', 'top', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '<strong>Lorem Ipsum</strong> is simply dummy text of the printing and \r\ntypesetting industry. Lorem Ipsum has been the industry''s standard dummy\r\n text ever since the 1500s, when an unknown printer took a galley of \r\ntype and scrambled it to make a type specimen book. It has survived not \r\nonly five centuries, but also the leap into electronic typesetting, \r\nremaining essentially unchanged. It was popularised in the 1960s with \r\nthe release of Letraset sheets containing Lorem Ipsum passages, and more\r\n recently with desktop publishing software like Aldus PageMaker \r\nincluding versions of Lorem Ipsum.'),
(9, 5, 'Yes', 'top', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Others', 'Others', 'Others', 'Others', 'Others', '<h2 class="where">&nbsp;</h2>\r\n<p>&Icirc;n ciuda opiniei publice, Lorem Ipsum nu e un  simplu text fÄƒrÄƒ sens. El &icirc;ÅŸi are rÄƒdÄƒcinile &icirc;ntr-o bucatÄƒ a literaturii  clasice latine din anul 45 &icirc;.e.n., fÄƒc&acirc;nd-o sÄƒ aibÄƒ mai bine de 2000  ani. Profesorul universitar de latinÄƒ de la colegiul Hampden-Sydney din  Virginia, Richard McClintock, a cÄƒutat &icirc;n bibliografie unul din cele mai  rar folosite cuvinte latine &quot;consectetur&quot;, &icirc;nt&acirc;lnit &icirc;n pasajul Lorem  Ipsum, ÅŸi cÄƒut&acirc;nd citate ale cuv&acirc;ntului respectiv &icirc;n literatura clasicÄƒ,  a descoperit la modul cel mai sigur sursa provenienÅ£ei textului. Lorem  Ipsum provine din secÅ£iunile 1.10.32 ÅŸi 1.10.33 din &quot;de Finibus Bonorum  et Malorum&quot; (Extremele Binelui ÅŸi ale RÄƒului) de Cicerone, scrisÄƒ &icirc;n  anul 45 &icirc;.e.n. AceastÄƒ carte este un tratat &icirc;n teoria eticii care a fost  foarte popular &icirc;n perioada Renasterii. Primul r&acirc;nd din Lorem Ipsum,  &quot;Lorem ipsum dolor sit amet...&quot;, a fost luat dintr-un r&acirc;nd din secÅ£iunea  1.10.32.</p>\r\n<p>Pasajul standard de Lorem Ipsum folosit &icirc;ncÄƒ din secolul  al XVI-lea este reprodus mai jos pentru cei interesaÅ£i. SecÅ£iunile  1.10.32 ÅŸi 1.10.33 din &quot;de Finibus Bonorum et Malorum&quot; de Cicerone sunt  de asemenea reproduse &icirc;n forma lor originalÄƒ, im</p>');
-- --------------------------------------------------------

--
-- Table structure for table `e_payment_gateway`
--

CREATE TABLE IF NOT EXISTS `e_payment_gateway` (
  `PaymentID` int(11) NOT NULL,
  `PaymentMethodName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymetMethodId` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymentMethodUrl` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymetMethodType` enum('cc','check','ipn','custom') COLLATE latin1_general_ci NOT NULL DEFAULT 'custom',
  `PaymentMethodTitle` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `PaymentMethodMessage` text COLLATE latin1_general_ci NOT NULL,
  `Priority` int(11) NOT NULL,
  `PaymentMethodDescription` text COLLATE latin1_general_ci NOT NULL,
  `Status` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No',
  `PaymentCofigure` enum('Yes','No') COLLATE latin1_general_ci NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `e_payment_gateway` (`PaymentID`, `PaymentMethodName`, `PaymetMethodId`, `PaymentMethodUrl`, `PaymetMethodType`, `PaymentMethodTitle`, `PaymentMethodMessage`, `Priority`, `PaymentMethodDescription`, `Status`, `PaymentCofigure`) VALUES
(6, 'Cash On Delivery', 'cashondelivary', '', 'custom', 'Cash On Delivery', 'Cash On Delivery Method<br />', 2, 'Cash On Delivery Method<br />', 'Yes', 'Yes'),
(7, 'PayPal Payments Standard', 'paypalipn', 'https://www.paypal.com/cgi-bin/webscr', 'ipn', 'PayPal Payments Standard', '<p><b>You have selected PayPal Website Payments Standard as your payment method.</b></p>\r\n<p>To complete this transaction, it is necessary to send you to PayPal.com.</p>\r\n<p>After the transaction is complete, you will be returned to our site.</p>', 2, 'PayPal Payments Standard:  Add a PayPal payment button to your site to accept Visa, MasterCardï¿½, American Express, Discover and PayPal payments securely. When your customers check out, they are redirected to PayPal to pay, then return to your site after theyï¿½re finished.', 'Yes', 'Yes');
-- --------------------------------------------------------

--
-- Table structure for table `e_payment_transactions`
--

CREATE TABLE IF NOT EXISTS `e_payment_transactions` (
  `TID` int(10) unsigned NOT NULL,
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
  `IsSuccess` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_price_refine`
--

CREATE TABLE IF NOT EXISTS `e_price_refine` (
  `id` int(10) NOT NULL,
  `range` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_products`
--

CREATE TABLE IF NOT EXISTS `e_products` (
  `ProductID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE latin1_general_ci NOT NULL,
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
  `label_txt` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_attributes`
--

CREATE TABLE IF NOT EXISTS `e_products_attributes` (
  `paid` int(10) unsigned NOT NULL,
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
  `required` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_categories`
--

CREATE TABLE IF NOT EXISTS `e_products_categories` (
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_images`
--

CREATE TABLE IF NOT EXISTS `e_products_images` (
  `Iid` int(11) unsigned NOT NULL,
  `ProductID` int(12) NOT NULL,
  `Image` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `alt_text` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_quantity_discounts`
--

CREATE TABLE IF NOT EXISTS `e_products_quantity_discounts` (
  `qd_id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `range_min` int(10) unsigned NOT NULL DEFAULT '0',
  `range_max` int(10) unsigned NOT NULL DEFAULT '0',
  `discount` double(10,5) NOT NULL DEFAULT '0.00000',
  `discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `customer_type` enum('customer','wholesale') NOT NULL DEFAULT 'customer'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_products_reviews`
--

CREATE TABLE IF NOT EXISTS `e_products_reviews` (
  `ReviewId` int(10) unsigned NOT NULL,
  `Pid` int(10) unsigned NOT NULL,
  `Cid` int(10) unsigned NOT NULL,
  `ReviewTitle` varchar(255) NOT NULL,
  `ReviewText` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No',
  `Rating` tinyint(1) NOT NULL,
  `DateCreated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_categories`
--

CREATE TABLE IF NOT EXISTS `e_promo_categories` (
  `PromoID` int(11) NOT NULL,
  `CID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_codes`
--

CREATE TABLE IF NOT EXISTS `e_promo_codes` (
  `PromoID` int(10) unsigned NOT NULL,
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
  `Global` enum('Yes','No') NOT NULL DEFAULT 'Yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_history`
--

CREATE TABLE IF NOT EXISTS `e_promo_history` (
  `PromoHistoryID` int(11) NOT NULL,
  `PromoID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `Cid` int(11) NOT NULL,
  `Amount` float(10,2) NOT NULL,
  `DateAdded` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_promo_products`
--

CREATE TABLE IF NOT EXISTS `e_promo_products` (
  `PromoID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_ranking`
--

CREATE TABLE IF NOT EXISTS `e_ranking` (
  `RankingID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `RaterID` int(11) NOT NULL,
  `Points` int(20) NOT NULL DEFAULT '0',
  `Message` text COLLATE latin1_general_ci NOT NULL,
  `Date` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_recommended_products`
--

CREATE TABLE IF NOT EXISTS `e_recommended_products` (
  `RecommendID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `RecommendedProductID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_report`
--

CREATE TABLE IF NOT EXISTS `e_report` (
  `reportID` int(11) NOT NULL,
  `Name` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Phone` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Website` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `Content` text COLLATE latin1_general_ci NOT NULL,
  `WhyOffensive` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `Date` date NOT NULL
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
  `Description` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- --------------------------------------------------------

--
-- Table structure for table `e_shipping_custom_rates`
--

CREATE TABLE IF NOT EXISTS `e_shipping_custom_rates` (
  `Srid` int(10) unsigned NOT NULL,
  `Ssid` int(10) unsigned NOT NULL DEFAULT '0',
  `RateMin` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `RateMax` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `Base` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `Price` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `PriceType` enum('amount','percentage') NOT NULL DEFAULT 'amount'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_shipping_selected`
--

CREATE TABLE IF NOT EXISTS `e_shipping_selected` (
  `Ssid` int(10) unsigned NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_slider_banner`
--

CREATE TABLE IF NOT EXISTS `e_slider_banner` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Slider_image` varchar(200) NOT NULL,
  `Content` text NOT NULL,
  `Status` enum('Yes','No') NOT NULL,
  `Priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_social_links`
--

CREATE TABLE IF NOT EXISTS `e_social_links` (
  `Id` int(11) NOT NULL,
  `Social_media_id` int(11) NOT NULL,
  `URL` varchar(200) NOT NULL,
  `Priority` int(11) NOT NULL,
  `Status` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_tax_classes`
--

CREATE TABLE IF NOT EXISTS `e_tax_classes` (
  `ClassId` int(10) unsigned NOT NULL,
  `ClassName` varchar(128) NOT NULL DEFAULT '',
  `ClassDescription` varchar(255) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `e_tax_classes` (`ClassId`, `ClassName`, `ClassDescription`, `Status`) VALUES
(1, 'General', 'General Desc', 'Yes'),
(4, 'Standard', 'Standard', 'Yes');
-- --------------------------------------------------------

--
-- Table structure for table `e_tax_rates`
--

CREATE TABLE IF NOT EXISTS `e_tax_rates` (
  `RateId` int(10) unsigned NOT NULL,
  `ClassId` int(10) unsigned NOT NULL DEFAULT '0',
  `Coid` int(11) unsigned NOT NULL,
  `Stid` int(11) unsigned NOT NULL,
  `TaxRate` decimal(20,5) unsigned NOT NULL DEFAULT '0.00000',
  `UserLevel` varchar(100) NOT NULL,
  `RateDescription` varchar(255) NOT NULL DEFAULT '',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_template`
--

CREATE TABLE IF NOT EXISTS `e_template` (
  `Id` int(11) NOT NULL,
  `TemplateId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `e_users_shipping_address`
--

CREATE TABLE IF NOT EXISTS `e_users_shipping_address` (
  `Csid` int(10) unsigned NOT NULL,
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
  `Country` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_users_wishlist`
--

CREATE TABLE IF NOT EXISTS `e_users_wishlist` (
  `Wlid` int(10) unsigned NOT NULL,
  `Cid` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(64) NOT NULL DEFAULT '',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UpdateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_users_wishlist_products`
--

CREATE TABLE IF NOT EXISTS `e_users_wishlist_products` (
  `Wlpid` int(10) unsigned NOT NULL,
  `Wlid` int(10) unsigned NOT NULL DEFAULT '0',
  `ProductId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttributeId` text,
  `Options` text,
  `Variant_ID` varchar(200) NOT NULL,
  `Variant_val_Id` varchar(500) NOT NULL,
  `AliasID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `e_voucher`
--

CREATE TABLE IF NOT EXISTS `e_voucher` (
  `voucherID` int(11) NOT NULL,
  `code` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `detail` text COLLATE latin1_general_ci NOT NULL,
  `DiscountOver` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Discount` float(10,2) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `StartDate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `EndDate` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `h_department`
--

CREATE TABLE IF NOT EXISTS `h_department` (
  `depID` int(11) NOT NULL,
  `Division` int(10) NOT NULL,
  `Department` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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
-- --------------------------------------------------------

--
-- Table structure for table `h_employee`
--

CREATE TABLE IF NOT EXISTS `h_employee` (
  `EmpID` int(20) NOT NULL,
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
  `SalesID` int(11) NOT NULL,
  `ProbationPeriod` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `EligibilityPeriod` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `LeaveAccrual` tinyint(1) NOT NULL,
  `Exempt` tinyint(1) DEFAULT NULL,
  `ProbationUnit` varchar(5) COLLATE latin1_general_ci NOT NULL DEFAULT 'Days',
  `EligibilityUnit` varchar(5) COLLATE latin1_general_ci NOT NULL DEFAULT 'Days',
  `ProbationEvent` int(20) NOT NULL,
  `YearlyReview` tinyint(1) NOT NULL,
  `YearlyReviewPeriod` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Overtime` tinyint(1) NOT NULL,
  `Benefit` tinyint(1) NOT NULL,
  `phone_country_id` int(11) NOT NULL,
  `ExistingEmployee` tinyint(1) NOT NULL DEFAULT '1',
  `GroupID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `importedemails`
--

CREATE TABLE IF NOT EXISTS `importedemails` (
  `autoId` bigint(20) NOT NULL,
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
  `MsgUdate` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `importemaillist`
--

CREATE TABLE IF NOT EXISTS `importemaillist` (
  `id` int(11) NOT NULL,
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
  `SmtpDetails` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_variant_manageOption`
--

CREATE TABLE IF NOT EXISTS `inv_variant_manageOption` (
  `id` int(11) NOT NULL,
  `variant_name_id` int(11) NOT NULL,
  `option_value` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inv_variant_type`
--

CREATE TABLE IF NOT EXISTS `inv_variant_type` (
  `id` int(11) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `inv_variant_type` (`id`, `field_name`, `status`) VALUES
(1, 'Text Field', 1),
(2, 'Text Area', 1),
(4, 'Multiple Select', 1),
(5, 'Dropdown', 1),
(6, 'Price', 1),
(7, 'Fixed Product Tax', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_variant_value`
--

CREATE TABLE IF NOT EXISTS `inv_variant_value` (
  `id` int(11) NOT NULL,
  `variant_type_id` int(11) NOT NULL,
  `variant_name` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `locationID` int(11) NOT NULL,
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
  `PayrollStart` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `PayCycle` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `PayMethod` enum('H','M') COLLATE latin1_general_ci NOT NULL DEFAULT 'H'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notifyID` bigint(20) NOT NULL,
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
  `Read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `UserID` int(20) NOT NULL,
  `ModuleID` int(10) NOT NULL,
  `ViewLabel` tinyint(1) NOT NULL,
  `ModifyLabel` tinyint(1) NOT NULL,
  `FullLabel` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_group`
--

CREATE TABLE IF NOT EXISTS `permission_group` (
  `GroupID` int(20) NOT NULL,
  `ModuleID` int(10) NOT NULL,
  `ViewLabel` tinyint(1) NOT NULL,
  `ModifyLabel` tinyint(1) NOT NULL,
  `FullLabel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission_vendor`
--

CREATE TABLE IF NOT EXISTS `permission_vendor` (
  `Id` int(20) NOT NULL,
  `EmpID` int(20) NOT NULL,
  `SuppCode` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `Rid` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Rname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rating` (`Rid`, `Rating`, `Rname`) VALUES
(1, 5, 'Excellent'),
(2, 4, 'Very Good'),
(3, 3, 'Good'),
(4, 2, 'Average'),
(5, 1, 'Poor'),
(8, 0, 'Very Poor');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
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
  `FixedCol` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `settings` (`visible`, `input_type`, `group_id`, `group_name`, `caption`, `setting_key`, `setting_value`, `options`, `validation`, `dep_id`, `priority`, `FixedCol`) VALUES
('Yes', 'text', 1, 'Global Settings', 'Journal Prefix', 'JOURNAL_NO_PREFIX', 'JN', '', 'No', 8, 1, 0),
('Yes', 'text', 1, 'Global Settings', 'Notification Email', 'Notification_Email', 'notifications@site.com', '', 'No', 8, 2, 0),
('Yes', 'text', 1, 'Global Settings', 'Fiscal Year', 'Chat_Ideal_Time', '30', '', 'No', 0, 0, 0),
('Yes', 'text', 1, 'Global Settings', 'Fiscal Year', 'FiscalYearStartDate', '2014-04-01', '', 'No', 8, 0, 1),
('Yes', 'text', 1, 'Global Settings', 'Fiscal Year', 'FiscalYearEndDate', '2015-03-31', '', 'No', 8, 0, 1),
('Yes', '', 1, 'Global Settings', 'Account Receivable', 'AccountReceivable', '30', '', 'No', 8, 6, 1),
('Yes', '', 1, 'Global Settings', 'Account Payable', 'AccountPayable', '2', '', 'No', 8, 7, 1),
('Yes', '', 1, 'Global Settings', 'Freight', 'FreightAR', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Cost Of Goods', 'CostOfGoods', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Sales', 'Sales', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Credit Card Clearing', 'CreditCardClearing', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Inventory', 'InventoryAR', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Sales Discount', 'SalesDiscount', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Inventory', 'InventoryAP', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Freight Expense (Discount)', 'FreightExpenseDiscount', '', '', 'No', 8, 8, 1),
('Yes', '', 1, 'Global Settings', 'Freight Expense', 'FreightExpense', '', '', 'No', 8, 8, 1);
-- --------------------------------------------------------

--
-- Table structure for table `social_media_list`
--

CREATE TABLE IF NOT EXISTS `social_media_list` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(40, 'Googleplus', 'googleplus.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserID` bigint(20) NOT NULL,
  `UserType` varchar(20) NOT NULL,
  `locationID` int(10) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Role` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_block`
--

CREATE TABLE IF NOT EXISTS `user_block` (
  `blockID` bigint(20) NOT NULL,
  `LoginTime` varchar(30) NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  `LoginType` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_email`
--

CREATE TABLE IF NOT EXISTS `user_email` (
  `ID` bigint(20) NOT NULL,
  `CmpID` int(20) NOT NULL,
  `RefID` int(20) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `GroupID` int(11) NOT NULL,
  `group_name` varchar(70) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `module` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `group_user` varchar(100) NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AdminType` varchar(100) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `AdminID` int(15) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(15) NOT NULL,
  `AddedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `loginID` bigint(20) NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `UserType` varchar(20) NOT NULL,
  `LoginTime` datetime NOT NULL,
  `LogoutTime` datetime NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  `Browser` varchar(50) NOT NULL,
  `Kicked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_page`
--

CREATE TABLE IF NOT EXISTS `user_login_page` (
  `pageID` bigint(20) NOT NULL,
  `loginID` bigint(20) NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `PageUrl` varchar(100) NOT NULL,
  `PageName` varchar(100) NOT NULL,
  `PageHeading` varchar(250) NOT NULL,
  `ViewTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_articles`
--

CREATE TABLE IF NOT EXISTS `web_articles` (
  `ArticleId` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Introtext` mediumtext,
  `Fulltext` mediumtext,
  `CatId` int(11) DEFAULT '0',
  `Status` enum('Yes','No') DEFAULT NULL,
  `Priority` int(11) DEFAULT '0',
  `Added_date` datetime DEFAULT NULL,
  `FormId` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_categories`
--

CREATE TABLE IF NOT EXISTS `web_categories` (
  `CatId` int(11) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Status` enum('Yes','No') DEFAULT NULL,
  `Added_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_forms`
--

CREATE TABLE IF NOT EXISTS `web_forms` (
  `FormId` int(11) NOT NULL,
  `FormName` varchar(200) NOT NULL,
  `Status` enum('Yes','No') NOT NULL,
  `Added_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `web_forms` (`FormId`, `FormName`, `Status`, `Added_Date`) VALUES
(1, 'Contact', 'Yes', '2015-06-30 15:14:26'),
(2, 'Career', 'Yes', '2015-06-30 15:14:33');
-- --------------------------------------------------------

--
-- Table structure for table `web_forms_fields`
--

CREATE TABLE IF NOT EXISTS `web_forms_fields` (
  `FieldId` int(11) NOT NULL,
  `FormId` int(11) NOT NULL,
  `FieldName` varchar(100) NOT NULL,
  `Fieldlabel` varchar(100) NOT NULL,
  `Fieldvalues` text NOT NULL,
  `FieldType` varchar(200) NOT NULL,
  `Manadatory` enum('Yes','No') NOT NULL,
  `Priority` int(11) NOT NULL DEFAULT '0',
  `Status` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `web_forms_fields` (`FieldId`, `FormId`, `FieldName`, `Fieldlabel`, `Fieldvalues`, `FieldType`, `Manadatory`, `Priority`, `Status`) VALUES
(1, 1, 'days', 'Days', 'Mon,Tues,Wed', 'checkbox', 'Yes', 5, 'Yes'),
(2, 1, 'email', 'Email', '', 'email', 'Yes', 2, 'Yes'),
(3, 1, 'contact_type', 'Contact Type', 'HR,Meeting,Product,Jobs,Official', 'dropdown', 'Yes', 2, 'Yes'),
(4, 1, 'sex', 'Sex', 'Male,Female', 'radio', 'Yes', 4, 'Yes'),
(6, 1, 'file', 'File', '', 'file', 'No', 6, 'Yes'),
(7, 1, 'comments', 'Comments', '', 'textarea', 'Yes', 7, 'Yes'),
(8, 1, 'name', 'Name', '', 'textbox', 'Yes', 1, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `web_form_data`
--

CREATE TABLE IF NOT EXISTS `web_form_data` (
  `Id` int(11) NOT NULL,
  `FormId` int(11) NOT NULL,
  `FieldId` int(11) NOT NULL,
  `FieldValue` text NOT NULL,
  `Added_date` datetime NOT NULL,
  `Added_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_menus`
--

CREATE TABLE IF NOT EXISTS `web_menus` (
  `MenuId` int(10) unsigned NOT NULL,
  `Priority` int(10) unsigned NOT NULL DEFAULT '0',
  `Status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Link` varchar(200) DEFAULT NULL,
  `MetaKeywords` text,
  `MetaTitle` text,
  `MetaDescription` text,
  `Alias` varchar(255) NOT NULL DEFAULT '',
  `ParentId` int(11) DEFAULT '0',
  `MenuTypeId` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
-- --------------------------------------------------------

--
-- Table structure for table `web_menutype`
--

CREATE TABLE IF NOT EXISTS `web_menutype` (
  `MenuTypeId` int(11) NOT NULL,
  `MenuType` varchar(200) DEFAULT NULL,
  `Status` enum('Yes','No') DEFAULT NULL,
  `Editable` enum('Yes','No') DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `web_menutype` (`MenuTypeId`, `MenuType`, `Status`, `Editable`) VALUES
(1, 'Header', 'Yes', 'No'),
(2, 'Footer', 'Yes', 'Yes'),
(3, 'Left', 'Yes', 'Yes'),
(4, 'Right', 'Yes', 'Yes');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_modules`
--
ALTER TABLE `admin_modules`
  ADD PRIMARY KEY (`ModuleID`);

--
-- Indexes for table `blocksnew`
--
ALTER TABLE `blocksnew`
  ADD PRIMARY KEY (`BlockID`),
  ADD KEY `depID` (`depID`);

--
-- Indexes for table `c_activity`
--
ALTER TABLE `c_activity`
  ADD PRIMARY KEY (`activityID`);

--
-- Indexes for table `c_quote_item_variant`
--
ALTER TABLE `c_quote_item_variant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_quote_item_variantOptionValues`
--
ALTER TABLE `c_quote_item_variantOptionValues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_territory`
--
ALTER TABLE `c_territory`
  ADD PRIMARY KEY (`TerritoryID`),
  ADD KEY `TerritoryID` (`Name`);

--
-- Indexes for table `c_territory_assign`
--
ALTER TABLE `c_territory_assign`
  ADD PRIMARY KEY (`AssignID`);

--
-- Indexes for table `c_territory_rule`
--
ALTER TABLE `c_territory_rule`
  ADD PRIMARY KEY (`TRID`);

--
-- Indexes for table `c_territory_rule_location`
--
ALTER TABLE `c_territory_rule_location`
  ADD PRIMARY KEY (`TRLID`);

--
-- Indexes for table `dashboard_icon`
--
ALTER TABLE `dashboard_icon`
  ADD PRIMARY KEY (`IconID`);

--
-- Indexes for table `default_screen`
--
ALTER TABLE `default_screen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AdminID` (`AdminID`,`AdminType`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`depID`);

--
-- Indexes for table `email_cat`
--
ALTER TABLE `email_cat`
  ADD PRIMARY KEY (`CatID`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`TemplateID`);

--
-- Indexes for table `e_cart`
--
ALTER TABLE `e_cart`
  ADD PRIMARY KEY (`CartID`);

--
-- Indexes for table `e_catalog_attributes`
--
ALTER TABLE `e_catalog_attributes`
  ADD KEY `cid` (`Cid`),
  ADD KEY `gaid` (`Gaid`);

--
-- Indexes for table `e_categories`
--
ALTER TABLE `e_categories`
  ADD PRIMARY KEY (`CategoryID`),
  ADD KEY `categoryID` (`Name`);

--
-- Indexes for table `e_comments`
--
ALTER TABLE `e_comments`
  ADD PRIMARY KEY (`CommentID`);

--
-- Indexes for table `e_courier`
--
ALTER TABLE `e_courier`
  ADD PRIMARY KEY (`courier_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `e_customers`
--
ALTER TABLE `e_customers`
  ADD PRIMARY KEY (`Cid`);

--
-- Indexes for table `e_customer_group`
--
ALTER TABLE `e_customer_group`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `e_delhivery_status`
--
ALTER TABLE `e_delhivery_status`
  ADD PRIMARY KEY (`delhiveryID`);

--
-- Indexes for table `e_discounts`
--
ALTER TABLE `e_discounts`
  ADD PRIMARY KEY (`DID`);

--
-- Indexes for table `e_emails`
--
ALTER TABLE `e_emails`
  ADD PRIMARY KEY (`EmailId`);

--
-- Indexes for table `e_email_signup`
--
ALTER TABLE `e_email_signup`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `e_feedback`
--
ALTER TABLE `e_feedback`
  ADD PRIMARY KEY (`feedbackID`);

--
-- Indexes for table `e_global_attributes`
--
ALTER TABLE `e_global_attributes`
  ADD PRIMARY KEY (`Gaid`);

--
-- Indexes for table `e_global_optionList`
--
ALTER TABLE `e_global_optionList`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `e_group_discount`
--
ALTER TABLE `e_group_discount`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `e_item_alias`
--
ALTER TABLE `e_item_alias`
  ADD PRIMARY KEY (`AliasID`),
  ADD KEY `ProductSku` (`ProductSku`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `e_manufacturers`
--
ALTER TABLE `e_manufacturers`
  ADD PRIMARY KEY (`Mid`);

--
-- Indexes for table `e_members`
--
ALTER TABLE `e_members`
  ADD PRIMARY KEY (`Counter`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `e_membership`
--
ALTER TABLE `e_membership`
  ADD PRIMARY KEY (`MembershipID`);

--
-- Indexes for table `e_membership_history`
--
ALTER TABLE `e_membership_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_newsletter_template`
--
ALTER TABLE `e_newsletter_template`
  ADD PRIMARY KEY (`Templapte_Id`);

--
-- Indexes for table `e_orderdetail`
--
ALTER TABLE `e_orderdetail`
  ADD PRIMARY KEY (`OrderDetailId`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `e_orders`
--
ALTER TABLE `e_orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `MemberID` (`Cid`);

--
-- Indexes for table `e_package`
--
ALTER TABLE `e_package`
  ADD PRIMARY KEY (`PackageID`);

--
-- Indexes for table `e_package_category`
--
ALTER TABLE `e_package_category`
  ADD PRIMARY KEY (`CatID`);

--
-- Indexes for table `e_pages`
--
ALTER TABLE `e_pages`
  ADD PRIMARY KEY (`PageId`);

--
-- Indexes for table `e_payment_gateway`
--
ALTER TABLE `e_payment_gateway`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `e_payment_transactions`
--
ALTER TABLE `e_payment_transactions`
  ADD PRIMARY KEY (`TID`),
  ADD KEY `oid` (`OrderId`),
  ADD KEY `uid` (`Cid`);

--
-- Indexes for table `e_price_refine`
--
ALTER TABLE `e_price_refine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_products`
--
ALTER TABLE `e_products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `e_products_attributes`
--
ALTER TABLE `e_products_attributes`
  ADD PRIMARY KEY (`paid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `e_products_categories`
--
ALTER TABLE `e_products_categories`
  ADD KEY `pid` (`pid`,`cid`),
  ADD KEY `cid` (`cid`,`pid`);

--
-- Indexes for table `e_products_images`
--
ALTER TABLE `e_products_images`
  ADD PRIMARY KEY (`Iid`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `e_products_quantity_discounts`
--
ALTER TABLE `e_products_quantity_discounts`
  ADD PRIMARY KEY (`qd_id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `e_products_reviews`
--
ALTER TABLE `e_products_reviews`
  ADD PRIMARY KEY (`ReviewId`),
  ADD KEY `user_id` (`Cid`),
  ADD KEY `product_id` (`Pid`);

--
-- Indexes for table `e_promo_categories`
--
ALTER TABLE `e_promo_categories`
  ADD PRIMARY KEY (`PromoID`,`CID`);

--
-- Indexes for table `e_promo_codes`
--
ALTER TABLE `e_promo_codes`
  ADD PRIMARY KEY (`PromoID`);

--
-- Indexes for table `e_promo_history`
--
ALTER TABLE `e_promo_history`
  ADD PRIMARY KEY (`PromoHistoryID`);

--
-- Indexes for table `e_promo_products`
--
ALTER TABLE `e_promo_products`
  ADD PRIMARY KEY (`PromoID`,`ProductID`);

--
-- Indexes for table `e_ranking`
--
ALTER TABLE `e_ranking`
  ADD PRIMARY KEY (`RankingID`);

--
-- Indexes for table `e_recommended_products`
--
ALTER TABLE `e_recommended_products`
  ADD PRIMARY KEY (`RecommendID`,`ProductID`);

--
-- Indexes for table `e_report`
--
ALTER TABLE `e_report`
  ADD PRIMARY KEY (`reportID`);

--
-- Indexes for table `e_settings`
--
ALTER TABLE `e_settings`
  ADD UNIQUE KEY `name` (`Name`);

--
-- Indexes for table `e_shipping_custom_rates`
--
ALTER TABLE `e_shipping_custom_rates`
  ADD PRIMARY KEY (`Srid`);

--
-- Indexes for table `e_shipping_selected`
--
ALTER TABLE `e_shipping_selected`
  ADD PRIMARY KEY (`Ssid`);

--
-- Indexes for table `e_slider_banner`
--
ALTER TABLE `e_slider_banner`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `e_social_links`
--
ALTER TABLE `e_social_links`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `e_tax_classes`
--
ALTER TABLE `e_tax_classes`
  ADD PRIMARY KEY (`ClassId`);

--
-- Indexes for table `e_tax_rates`
--
ALTER TABLE `e_tax_rates`
  ADD PRIMARY KEY (`RateId`),
  ADD KEY `class_id` (`ClassId`);

--
-- Indexes for table `e_template`
--
ALTER TABLE `e_template`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `e_users_shipping_address`
--
ALTER TABLE `e_users_shipping_address`
  ADD PRIMARY KEY (`Csid`),
  ADD KEY `uid` (`Cid`);

--
-- Indexes for table `e_users_wishlist`
--
ALTER TABLE `e_users_wishlist`
  ADD PRIMARY KEY (`Wlid`),
  ADD KEY `uid` (`Cid`);

--
-- Indexes for table `e_users_wishlist_products`
--
ALTER TABLE `e_users_wishlist_products`
  ADD PRIMARY KEY (`Wlpid`),
  ADD KEY `wlid` (`Wlid`);

--
-- Indexes for table `e_voucher`
--
ALTER TABLE `e_voucher`
  ADD PRIMARY KEY (`voucherID`);

--
-- Indexes for table `h_department`
--
ALTER TABLE `h_department`
  ADD PRIMARY KEY (`depID`);

--
-- Indexes for table `h_employee`
--
ALTER TABLE `h_employee`
  ADD PRIMARY KEY (`EmpID`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `importedemails`
--
ALTER TABLE `importedemails`
  ADD PRIMARY KEY (`autoId`),
  ADD KEY `MailType` (`MailType`,`OwnerEmailId`,`emaillistID`);

--
-- Indexes for table `importemaillist`
--
ALTER TABLE `importemaillist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `inv_variant_manageOption`
--
ALTER TABLE `inv_variant_manageOption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_variant_type`
--
ALTER TABLE `inv_variant_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_variant_value`
--
ALTER TABLE `inv_variant_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`locationID`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notifyID`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD UNIQUE KEY `EmpID` (`UserID`,`ModuleID`),
  ADD KEY `AdminID` (`UserID`);

--
-- Indexes for table `permission_group`
--
ALTER TABLE `permission_group`
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `permission_vendor`
--
ALTER TABLE `permission_vendor`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`Rid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `social_media_list`
--
ALTER TABLE `social_media_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`,`UserType`),
  ADD KEY `UserType` (`UserType`);

--
-- Indexes for table `user_block`
--
ALTER TABLE `user_block`
  ADD PRIMARY KEY (`blockID`),
  ADD KEY `LoginIP` (`LoginIP`);

--
-- Indexes for table `user_email`
--
ALTER TABLE `user_email`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `CmpID` (`CmpID`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`loginID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `UserType` (`UserType`);

--
-- Indexes for table `user_login_page`
--
ALTER TABLE `user_login_page`
  ADD PRIMARY KEY (`pageID`),
  ADD KEY `loginID` (`loginID`);

--
-- Indexes for table `web_articles`
--
ALTER TABLE `web_articles`
  ADD PRIMARY KEY (`ArticleId`);

--
-- Indexes for table `web_categories`
--
ALTER TABLE `web_categories`
  ADD PRIMARY KEY (`CatId`);

--
-- Indexes for table `web_forms`
--
ALTER TABLE `web_forms`
  ADD PRIMARY KEY (`FormId`);

--
-- Indexes for table `web_forms_fields`
--
ALTER TABLE `web_forms_fields`
  ADD PRIMARY KEY (`FieldId`);

--
-- Indexes for table `web_form_data`
--
ALTER TABLE `web_form_data`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `web_menus`
--
ALTER TABLE `web_menus`
  ADD PRIMARY KEY (`MenuId`);

--
-- Indexes for table `web_menutype`
--
ALTER TABLE `web_menutype`
  ADD PRIMARY KEY (`MenuTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_modules`
--
ALTER TABLE `admin_modules`
  MODIFY `ModuleID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blocksnew`
--
ALTER TABLE `blocksnew`
  MODIFY `BlockID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_activity`
--
ALTER TABLE `c_activity`
  MODIFY `activityID` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_quote_item_variant`
--
ALTER TABLE `c_quote_item_variant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_quote_item_variantOptionValues`
--
ALTER TABLE `c_quote_item_variantOptionValues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_territory`
--
ALTER TABLE `c_territory`
  MODIFY `TerritoryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_territory_assign`
--
ALTER TABLE `c_territory_assign`
  MODIFY `AssignID` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_territory_rule`
--
ALTER TABLE `c_territory_rule`
  MODIFY `TRID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `c_territory_rule_location`
--
ALTER TABLE `c_territory_rule_location`
  MODIFY `TRLID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dashboard_icon`
--
ALTER TABLE `dashboard_icon`
  MODIFY `IconID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `default_screen`
--
ALTER TABLE `default_screen`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `depID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_cat`
--
ALTER TABLE `email_cat`
  MODIFY `CatID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `TemplateID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_cart`
--
ALTER TABLE `e_cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_categories`
--
ALTER TABLE `e_categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_comments`
--
ALTER TABLE `e_comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_courier`
--
ALTER TABLE `e_courier`
  MODIFY `courier_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_customers`
--
ALTER TABLE `e_customers`
  MODIFY `Cid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_customer_group`
--
ALTER TABLE `e_customer_group`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_delhivery_status`
--
ALTER TABLE `e_delhivery_status`
  MODIFY `delhiveryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_discounts`
--
ALTER TABLE `e_discounts`
  MODIFY `DID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_emails`
--
ALTER TABLE `e_emails`
  MODIFY `EmailId` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_email_signup`
--
ALTER TABLE `e_email_signup`
  MODIFY `MemberID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_feedback`
--
ALTER TABLE `e_feedback`
  MODIFY `feedbackID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_global_attributes`
--
ALTER TABLE `e_global_attributes`
  MODIFY `Gaid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_global_optionList`
--
ALTER TABLE `e_global_optionList`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_group_discount`
--
ALTER TABLE `e_group_discount`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_item_alias`
--
ALTER TABLE `e_item_alias`
  MODIFY `AliasID` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_manufacturers`
--
ALTER TABLE `e_manufacturers`
  MODIFY `Mid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_members`
--
ALTER TABLE `e_members`
  MODIFY `Counter` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_membership`
--
ALTER TABLE `e_membership`
  MODIFY `MembershipID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_membership_history`
--
ALTER TABLE `e_membership_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_newsletter_template`
--
ALTER TABLE `e_newsletter_template`
  MODIFY `Templapte_Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_orderdetail`
--
ALTER TABLE `e_orderdetail`
  MODIFY `OrderDetailId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_orders`
--
ALTER TABLE `e_orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_package`
--
ALTER TABLE `e_package`
  MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_package_category`
--
ALTER TABLE `e_package_category`
  MODIFY `CatID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_pages`
--
ALTER TABLE `e_pages`
  MODIFY `PageId` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_payment_gateway`
--
ALTER TABLE `e_payment_gateway`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_payment_transactions`
--
ALTER TABLE `e_payment_transactions`
  MODIFY `TID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_price_refine`
--
ALTER TABLE `e_price_refine`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_products`
--
ALTER TABLE `e_products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_products_attributes`
--
ALTER TABLE `e_products_attributes`
  MODIFY `paid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_products_images`
--
ALTER TABLE `e_products_images`
  MODIFY `Iid` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_products_quantity_discounts`
--
ALTER TABLE `e_products_quantity_discounts`
  MODIFY `qd_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_products_reviews`
--
ALTER TABLE `e_products_reviews`
  MODIFY `ReviewId` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_promo_codes`
--
ALTER TABLE `e_promo_codes`
  MODIFY `PromoID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_promo_history`
--
ALTER TABLE `e_promo_history`
  MODIFY `PromoHistoryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_ranking`
--
ALTER TABLE `e_ranking`
  MODIFY `RankingID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_recommended_products`
--
ALTER TABLE `e_recommended_products`
  MODIFY `RecommendID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_report`
--
ALTER TABLE `e_report`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_shipping_custom_rates`
--
ALTER TABLE `e_shipping_custom_rates`
  MODIFY `Srid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_shipping_selected`
--
ALTER TABLE `e_shipping_selected`
  MODIFY `Ssid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_slider_banner`
--
ALTER TABLE `e_slider_banner`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_social_links`
--
ALTER TABLE `e_social_links`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_tax_classes`
--
ALTER TABLE `e_tax_classes`
  MODIFY `ClassId` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_tax_rates`
--
ALTER TABLE `e_tax_rates`
  MODIFY `RateId` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_template`
--
ALTER TABLE `e_template`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_users_shipping_address`
--
ALTER TABLE `e_users_shipping_address`
  MODIFY `Csid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_users_wishlist`
--
ALTER TABLE `e_users_wishlist`
  MODIFY `Wlid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_users_wishlist_products`
--
ALTER TABLE `e_users_wishlist_products`
  MODIFY `Wlpid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `e_voucher`
--
ALTER TABLE `e_voucher`
  MODIFY `voucherID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `h_employee`
--
ALTER TABLE `h_employee`;
--
-- AUTO_INCREMENT for table `inv_variant_manageOption`
--
ALTER TABLE `inv_variant_manageOption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inv_variant_value`
--
ALTER TABLE `inv_variant_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`;
--
-- AUTO_INCREMENT for table `permission_vendor`
--
ALTER TABLE `permission_vendor`;
--
-- AUTO_INCREMENT for table `user_email`
--
ALTER TABLE `user_email`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `loginID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `web_menus`
--
ALTER TABLE `web_menus`;

