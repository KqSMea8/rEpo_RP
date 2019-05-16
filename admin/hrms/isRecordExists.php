<?	session_start();
	date_default_timezone_set('America/New_York');
	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/candidate.class.php");
	require_once($Prefix."classes/performance.class.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/training.class.php");	
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/tax.class.php");
	require_once($Prefix."classes/vendor.class.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/role.class.php");
	$objConfig=new admin();	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	(empty($_GET['editID']))?($_GET['editID']=""):("");
	(empty($_GET['Type']))?($_GET['Type']=""):("");

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/


	/* Checking for Employee Email existance */
	if($_GET['Type'] == "Employee" && !empty($_GET['Email'])){
		$_GET['RefID'] = $_GET['editID'];
		$_GET['CmpID'] = $_SESSION['CmpID'];
		if($objConfig->isUserEmailDuplicate($_GET)){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}



	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	
	CleanGet();

	/* Checking for Employee existance 
	if($_GET['Type'] == "Employee" && !empty($_GET['Email'])){
		$objEmployee = new employee();
		if($_GET['Email']==$_SESSION['AdminEmail']){
			echo "1";
		}else if($objEmployee->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}*/

	

	/* Checking for Account Number existance */
	if(!empty($_GET['AccountNumber'])){
		$objPayroll=new payroll();
		if($objPayroll->isAccountNumberExists($_GET['AccountNumber'],$_GET['emp'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Candidate existance */
	if($_GET['Type'] == "Candidate" && !empty($_GET['Email'])){
		$objCandidate = new candidate();
		$objEmployee = new employee();
		if($objCandidate->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else if($objEmployee->isEmailExists($_GET['Email'],'')){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for KRA existance */
	if(!empty($_GET['KRATitle'])){
		$objPerformance=new performance(); 
		if($objPerformance->isKraExists($_GET['KRATitle'], $_GET['editID'])){
			echo "1";
		}else if($objPerformance->isKraJobTitleExists($_GET['JobTitle'], $_GET['editID'])){
			echo "2";
		}else{
			echo "0";
		}
		exit;
	}
	
	/* Checking for ComponentHeading existance */
	if(!empty($_GET['ComponentHeading'])){
		$objPerformance=new performance();
		if($objPerformance->isComponentExists($_GET['ComponentHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for ComponentCategory existance */
	if(!empty($_GET['ComponentCategory'])){
		$objPerformance=new performance();
		if($objPerformance->isCategoryExists($_GET['ComponentCategory'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for PayHeading existance */
	if(!empty($_GET['PayHeading'])){
		$objPayroll=new payroll();
		if($objPayroll->isHeadExists($_GET['PayHeading'],$_GET['catID'],$_GET['catEmp'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for DecHeading existance */
	if(!empty($_GET['DecHeading'])){
		$objPayroll=new payroll();
		if($objPayroll->isDecHeadExists($_GET['DecHeading'],$_GET['catID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Salary existance */
	if(!empty($_GET['SalaryEmpID'])){
		$objPayroll=new payroll();
		if($objPayroll->isSalaryExists($_GET['SalaryEmpID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for TrainingCourse existance */
	if(!empty($_GET['TrainingCourse'])){
		$objTraining=new training();
		if($objTraining->isCourseExists($_GET['TrainingCourse'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for DocumentHeading existance */
	if(!empty($_GET['DocumentHeading'])){
		$objCommon=new common();
		if($objCommon->isDocumentExists($_GET['DocumentHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for AnnouncementHeading existance */
	if(!empty($_GET['AnnouncementHeading'])){
		$objCommon=new common();
		if($objCommon->isNewsExists($_GET['AnnouncementHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for BenefitDocument existance */

 
	if(!empty($_GET['BenefitDocument'])){
		$objCommon=new common();
		if($objCommon->isBenefitExists($_GET['BenefitDocument'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for shiftName existance */ 
	if(!empty($_GET['shiftName'])){
		$objCommon=new common();
		if($objCommon->isShiftExists($_GET['shiftName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Department existance */ 
	if(!empty($_GET['Department'])){
		$objCommon=new common();
		if($objCommon->isDepartmentExists($_GET['Department'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Vacancy existance */ 
	if(!empty($_GET['VacancyName'])){
		$objCandidate = new candidate();
		if($objCandidate->isVacancyExists($_GET['VacancyName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for filingStatus existance */ 
	if(!empty($_GET['filingStatus'])){
		$objTax=new tax();
		if($objTax->isfilingStatusExists($_GET['filingStatus'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for PayPeriodName existance */ 
	if(!empty($_GET['PayPeriodName'])){
		$objTax=new tax();
		if($objTax->isPayPeriodStatusExists($_GET['PayPeriodName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for TaxBracket existance */ 
	if(!empty($_GET['periodID']) && !empty($_GET['Year']) && !empty($_GET['FilingStatus']) ){
		$objTax=new tax();
		if($objTax->isTaxBracketExists($_GET['periodID'],$_GET['Year'], $_GET['FilingStatus'] ,$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for DeductionHeading existance */ 
	if(!empty($_GET['DeductionHeading'])){
		$objTax=new tax();
		if($objTax->isDeductionHeadingExists($_GET['DeductionHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for DeductionRule existance */ 
	if(!empty($_GET['DeductionRule'])){
		$objTax=new tax();
		if($objTax->isDeductionRuleExists($_GET['DeductionRule'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for TaxDeductionHeading existance */ 
	if(!empty($_GET['TaxDeductionHeading'])){
		$objTax=new tax();
		if($objTax->isTaxDeductionExists($_GET['TaxDeductionHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Attribute existance */ 
	if(!empty($_GET['AttributeValue'])){
		$objCommon=new common();
		if($objCommon->isAttributeExists($_GET['AttributeValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Education existance */ 
	if(!empty($_GET['AttribValue'])){
		$objCommon=new common();
		if($objCommon->isAttribExists($_GET['AttribValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Holiday Name existance */ 
	if(!empty($_GET['HolidayName'])){
		$objLeave=new leave();
		if($objLeave->isHolidayExists($_GET['HolidayName'],$_GET['editID'])){
			echo "1";
		}else if($objLeave->isHolidayDateExists($_GET['holidayDate'], $_GET['editID'])){
			echo "2";
		}else{
			echo "0";
		}
		exit;
	}
	if(!empty($_GET['HolidayNameRange'])){
		$objLeave=new leave();
		if($objLeave->isHolidayExists($_GET['HolidayNameRange'],$_GET['editID'])){
			echo "1";
		}else if($objLeave->isHolidayDateRangeExists($_GET['holidayDate'], $_GET['holidayDateTo'], $_GET['editID'])){
			echo "2";
		
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Entitlement existance */ 
	if(!empty($_GET['EntitlementEmpID'])){
		$objLeave=new leave();
		if($objLeave->isEntitlementExists($_GET['EntitlementEmpID'],$_GET['LeaveType'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Declaration existance */ 
	if(!empty($_GET['DeclarationEmpID'])){
		$objPayroll=new payroll();
		if($objPayroll->isDeclarationExists($_GET['DeclarationEmpID'],$_GET['Year'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for VendorCode existance */ 
	if(!empty($_GET['VendorCode'])){
		$objVendor=new vendor();
		if($objVendor->isVendorCodeExists($_GET['VendorCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for VendorName existance */ 
	if(!empty($_GET['VendorName'])){
		$objVendor=new vendor();
		if($objVendor->isVendorNameExists($_GET['VendorName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for VendorEmail existance */
	if($_GET['Type'] == "Vendor" && !empty($_GET['Email'])){
		$objVendor=new vendor();
		if($objVendor->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	

	/* Checking for Asset TagID existance */ 
	if(!empty($_GET['TagID'])){
		$objAsset=new asset();
		if($objAsset->isTagIDExists($_GET['TagID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Asset SerialNumber existance */ 
	if(!empty($_GET['SerialNumber'])){
		$objAsset=new asset();
		if($objAsset->isSerialNumberExists($_GET['SerialNumber'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for LeaveCheckHeading existance */ 
	if(!empty($_GET['LeaveCheckHeading'])){
		$objCommon=new common();
		if($objCommon->isLeaveCheckNameExists($_GET['LeaveCheckHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for LeaveCheckValue existance */ 
	if(!empty($_GET['LeaveCheckValue'])){
		$objCommon=new common();
		if($objCommon->isLeaveCheckValueExists($_GET['LeaveCheckValue'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for LeaveRuleHeading existance */
	if(!empty($_GET['LeaveRuleHeading'])){
		$objLeave=new leave();
		if($objLeave->isCustomRuleNameExists($_GET['LeaveRuleHeading'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for LeaveRuleColumn existance */ 
	if(!empty($_GET['LeaveRuleColumn'])){
		$objLeave=new leave();
		if($objLeave->isCustomRuleExists($_GET)){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

 
	if(!empty($_GET['group_name'])){
		$objRole = new role();
		if($objRole->isGroupNameExists($_GET['group_name'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

 
	if(!empty($_GET['EmpCategoryName'])){
		$objCommon=new common();	
		if($objCommon->isEmployeeCategoryExists($_GET['EmpCategoryName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for PIN existance By Abid*/ 
	if(!empty($_GET['PIN'])){
		$objEmployee = new employee();
		if($objEmployee->isPINExists($_GET['PIN'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for EmpCode existance */
	if(!empty($_GET['EmpCode'])){
		$objEmployee = new employee();
		if($objEmployee->isEmpCodeExists($_GET['EmpCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
?>
