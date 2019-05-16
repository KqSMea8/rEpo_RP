<?php
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

require_once("../../classes/region.class.php");
require_once("../../classes/rsl.class.php");
		
		/*$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
		$objConfig->connect();*/
		
$objRegion=new region();
$objCmp=new rs();
$arryCountry = $objRegion->getCountry('','');
$CrmRsID=$_SESSION['CrmRsID'];
$arryCompany= $objCmp->getCompanyById($CrmRsID);

//print_r($arryCompany);
if(isset($_POST['submit'])){

	$cidMsg=$objCmp->UpdateProfile($_POST,$CrmRsID);
	
		$_SESSION['mess_company_success']=PROFILE_UPDATED;
		header("location: myprofile.php");
	    exit;
	
}

include ('includes/footer.php');
?>
