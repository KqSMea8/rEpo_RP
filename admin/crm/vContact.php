<?php 
/**************************************************************/
$ThisPageName = 'viewContact.php'; 
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	 require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	 require_once($Prefix."classes/field.class.php");//By Chetan//
	
        $objCommon=new common();
        $objField=new field();//By Chetan//

	$arryHead=$objField->getHead('',$ModuleParentID,1);//By Chetan//

	
	$_GET['view'] = (int)$_GET['view'];

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = $callfor = "Contact";
	if((isset($_GET['parent_type']) && $_GET['parent_type']!='') &&  (isset($_GET['parentID']) && $_GET['parentID']!='')){
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


		$ContactID   = $_REQUEST['view'];	
		$arryEmployee = $objEmployee->GetEmployeeBrief($arryContact[0]['AssignTo']);

		if(!empty($arryContact[0]['CustID'])){
			$arryCustomer = $objCustomer->GetCustomer($arryContact[0]['CustID'],'','');
		}


	}


	if(empty($arryContact[0]['AddID'])) {
		header('location:'.$RedirectURL);
		exit;
	}		
	/*****************/
	if($Config['vAllRecord']!=1){
		if($arryContact[0]['AssignTo'] != $_SESSION['AdminID'] && $arryContact[0]['AdminID'] != $_SESSION['AdminID']){
		header('location:'.$RedirectURL);
		exit;
		}
	}
	/*****************/



                //open by chetan3July//
		/*******Connecting to main database********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		if($arryContact[0]['country_id']>0){
		$arryCountryName = $objRegion->GetCountryName($arryContact[0]['country_id']);
		$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

			if(!empty($arryContact[0]['state_id'])) {
			   $arryState = $objRegion->getStateName($arryContact[0]['state_id']);
			   $StateName = stripslashes($arryState[0]["name"]);
			}else if(!empty($arryContact[0]['OtherState'])){
			   $StateName = stripslashes($arryContact[0]['OtherState']);
			}

				if(!empty($arryContact[0]['city_id'])) {
				  $arryCity = $objRegion->getCityName($arryContact[0]['city_id']);
				  $CityName = stripslashes($arryCity[0]["name"]);
				}else if(!empty($arryContact[0]['OtherCity'])){
				  $CityName = stripslashes($arryContact[0]['OtherCity']);
				}
	       /********Connecting to main database*********/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
                    
			

	require_once("../includes/footer.php"); 	 
?>
