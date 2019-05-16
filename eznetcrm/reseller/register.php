<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'User account '; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;
include ('includes/header.php');

IsCrmSession(); 
require_once("../../classes/region.class.php");
require_once("../../classes/company.class.php");
require_once("../../classes/rsl.class.php");
require_once("../../classes/admin.class.php");

$objConfig=new admin();
$objCompany=new company();
$objRegion=new region();
$objReseller=new rs();
$arryCountry = $objRegion->getCountry('','');


if ($_POST){

	$_POST['CmpID'] = $objReseller->getDefaultCompany();

	if(!empty($_POST['CmpID'])){
	
	if($objReseller->isEmailExists($_POST['Email'],$_POST['CmpID'])){ 
		$_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
	}else{ 
		$_POST['Status']=1;
		$_POST["JoiningDate"]= date('Y-m-d');
		$_POST["UpdatedDate"]= date("Y-m-d");
		
		$RsID=$objReseller->InsertSeller($_POST);
		if($RsID>0){
			$_SESSION['mess_company'] = 'Account has been created successfully. Check your mail for account activation.';
			 $objReseller->SendActivationMail($RsID);
			
		}
	}
	header("Location:register.php");
		exit;
		
	}else{
		
		$_SESSION['mess_company'] = 'Default company dose not exist.';
		
	}
 
}

include ('includes/footer.php');
?>

