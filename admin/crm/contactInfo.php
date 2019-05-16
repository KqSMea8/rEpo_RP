<?php 
$HideNavigation = 1;
/**************************************************************/
$ThisPageName = 'viewContact.php'; 
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	 require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	 	$objCommon=new common();

	
	

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Contact";
	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
	$BackUrl = "viewContact.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$RedirectURL = "viewContact.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET['curP'];
	$EditUrl = "editContact.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]; 
	$ViewUrl="vContact.php?view=".$_GET["view"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]."&tab=";

	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";
	
	$ActionUrl = $EditUrl.$_GET["tab"];
	}else{
	$RedirectURL = "viewContact.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="contact";
	$ViewUrl="vContact.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=";
	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";

	$EditUrl = "editContact.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
   }



	if (!empty($_GET['view'])) {
		$arryContact = $objCustomer->GetContactAddress($_GET['view'],'');
                $PageHeading = 'View Contact detail for: '.stripslashes($arryContact[0]['FirstName']);


		$ContactID   = $_GET['view'];
		if(!empty($arryContact[0]['AssignTo'])){	
			$arryEmployee = $objEmployee->GetEmployeeBrief($arryContact[0]['AssignTo']);
		}

		if(!empty($arryContact[0]['CustID'])){
			$arryCustomer = $objCustomer->GetCustomer($arryContact[0]['CustID'],'','');
		}


	}

			

	require_once("../includes/footer.php"); 	 
?>
