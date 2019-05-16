<?	session_start();
    	require_once("../includes/config.php");
	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");
	require_once("../classes/region.class.php");
	require_once("../classes/company.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/hrms.class.php");	
	require_once("../classes/finance.account.class.php");	
	require_once("../classes/sales.customer.class.php");
	require_once("../classes/employee.class.php");	
	require_once("../classes/role.class.php"); 
	$objConfig=new admin();	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	(empty($_GET['Type']))?($_GET['Type']=""):("");
	(empty($_GET['action']))?($_GET['action']=""):("");

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();
	

	/* Checking for Company existance */
	if(!empty($_GET['Multiple']) && $_GET['DisplayName'] != ""){
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "2";
		}else{
			if($_GET['Email'] != ""){
				if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}

	/* Checking for Company existance */
	if(!empty($_GET['DisplayName'])){ 
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Company Email existance */
	if($_GET['Type'] == "Company" && $_GET['Email'] != ""){
		$objCompany = new company();
		if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Employee Email existance */
	if($_GET['Type'] == "Employee" && $_GET['Email'] != ""){
		$_GET['RefID'] = $_GET['editID'];
		$_GET['CmpID'] = $_SESSION['CmpID'];
		if($objConfig->isUserEmailDuplicate($_GET)){	
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/////////////////////////////////
	/////////////////////////////////

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	/////////////////////////////////
	/////////////////////////////////

	/* Checking for Tier Name existance */
	 
	if(!empty($_GET['tierName'])){ 
		$objCommon=new common();
		if($objCommon->isTierNameExists($_GET['tierName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Tier Range existance */
	if(!empty($_GET['tierRangeFrom']) && !empty($_GET['tierRangeTo'])){
 		$objCommon=new common();
		if($objCommon->isTierFromToExists($_GET['tierRangeFrom'],$_GET['tierRangeTo'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Tier Range existance */
	if(!empty($_GET['tierRangeFrom']) || !empty($_GET['tierRangeTo'])){
		$objCommon=new common();
		if($objCommon->isTierRangeExists($_GET['tierRangeFrom'],$_GET['tierRangeTo'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Commission Tier existance */
	 
	if(!empty($_GET['CommissionTier'])){ 
		$objCommon=new common();
		if($objCommon->isCommissionTierExists($_GET['CommissionTier'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Spiff Tier Name existance */	 
	if(!empty($_GET['spiffTierName'])){ 
		$objCommon=new common();
		if($objCommon->isSpiffNameExists($_GET['spiffTierName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Spiff Sales Target existance */
	 
	if(!empty($_GET['spiffSalesTarget'])){ 
		$objCommon=new common();
		if($objCommon->isSpiffTargetExists($_GET['spiffSalesTarget'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	



	/* Checking for AdminUsername existance 
	if($_GET['AdminUsername'] != ""){
		$objAdmin = new admin();
		if($objAdmin->isAdminExists($_GET['AdminUsername'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}		

	
	if($_GET['Country'] != ""){
		$objRegion=new region();
		if($objRegion->isCountryExists($_GET['Country'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	
	if($_GET['State'] != "" && $_GET['CountryID']>0){
		$objRegion=new region();
		if($objRegion->isStateExists($_GET['State'],$_GET['CountryID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}	
			
		exit;

	}

	
	if($_GET['City'] != "" && $_GET['StateID']>0){
		
		$objRegion=new region();
		if($objRegion->isCityExists($_GET['City'],$_GET['StateID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}*/

	/* Checking for Location existance */
	 
	if(!empty($_GET['LocationCountry'])){ 
		$objConfigure=new configure(); 
		if($objConfigure->isLocationExists($_GET)){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}
	/* Checking for VendorLinked existance */
	if($_GET['action'] == "VendorLinked"){
		$objBankAccount= new BankAccount();
		if($objBankAccount->isVendorLinked($_GET['SuppID'], $_GET['CustID'])){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}

	/* Checking for CustomerLinked existance */
	if($_GET['action'] == "CustomerLinked"){
		$objBankAccount= new BankAccount();
		if($objBankAccount->isCustomerLinked($_GET['SuppID'], $_GET['CustID'])){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}
	/* Checking for CustCardNumber existance */
	if(!empty($_GET['CustCardNumber']) && !empty($_GET['CustID'])){
		$objCustomer=new Customer();
		if($objCustomer->isCustCardExist($_GET['CustCardNumber'], $_GET['CustID'], $_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}

	/* Checking for Employee existance */
	if($_GET['Type'] == "Employee" && $_GET['Email'] != ""){

		$objEmployee = new employee();
		if($_GET['Email']==$_SESSION['AdminEmail']){
			echo "1";
		}else if($objEmployee->isEmailExists($_GET['Email'],$_GET['editID'])){
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

	/* Checking for group existance */
	if(!empty($_GET['group_name'])){ 	 
		$objRole = new role();
		if($objRole->isGroupNameExists($_GET['group_name'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for CustCardNumber existance */ 
	if(!empty($_GET['CustShipAccountNumber']) && !empty($_GET['CustID'])){
		$objCustomer=new Customer();
		if($objCustomer->isCustShippingAccountExists($_GET['CustShipAccountNumber'], $_GET['CustID'], $_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}
?>
