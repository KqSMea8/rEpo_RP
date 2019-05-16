<?	session_start();
    	require_once("../includes/config.php");
	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");
	require_once("../classes/region.class.php");
	require_once("../classes/company.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/hrms.class.php");	
	
	$objConfig=new admin();	

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();

	/* Checking for Company existance */
	if($_GET['Multiple'] == "1" && $_GET['DisplayName'] != ""){
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
	if($_GET['DisplayName'] != ""){
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
	if($_GET['tierName'] != ""){
		$objCommon=new common();
		if($objCommon->isTierNameExists($_GET['tierName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Tier Range existance */
	if($_GET['tierRangeFrom'] != "" && $_GET['tierRangeTo'] != ""){
		$objCommon=new common();
		if($objCommon->isTierFromToExists($_GET['tierRangeFrom'],$_GET['tierRangeTo'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Tier Range existance */
	if($_GET['tierRangeFrom'] != "" || $_GET['tierRangeTo'] != ""){
		$objCommon=new common();
		if($objCommon->isTierRangeExists($_GET['tierRangeFrom'],$_GET['tierRangeTo'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Commission Tier existance */
	if($_GET['CommissionTier'] != ""){
		$objCommon=new common();
		if($objCommon->isCommissionTierExists($_GET['CommissionTier'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Spiff Tier Name existance */
	if($_GET['spiffTierName'] != ""){
		$objCommon=new common();
		if($objCommon->isSpiffNameExists($_GET['spiffTierName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Spiff Sales Target existance */
	if($_GET['spiffSalesTarget'] != ""){
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
	if($_GET['LocationCountry'] != ""){
		$objConfigure=new configure(); 
		if($objConfigure->isLocationExists($_GET)){
			echo "1";
		}else{
			echo "0";
		}
		
		exit;
	}

?>
