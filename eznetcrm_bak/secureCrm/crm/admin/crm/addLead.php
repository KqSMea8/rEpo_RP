<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewLead.php?module=lead'; $EditPage = 1; $HideNavigation = 1;
    /**************************************************/
   
	  require_once("../includes/header.php");
        require_once($Prefix."classes/lead.class.php");
        require_once($Prefix."classes/region.class.php");
		require_once($Prefix."classes/employee.class.php");
		require_once($Prefix."classes/crm.class.php");
	
	
	$ModuleName = "Lead";
	$RedirectURL = "viewLead.php?curP=".$_GET['curP']."&module=lead";
	
	


	$objLead=new lead();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCommon=new common();
	
	
	
	
	
	           if ($_POST) {
						$ImageId = $objLead->AddLead($_POST); 
						$_SESSION['mess_lead'] = LEAD_ADDED;
						if(!empty($ImageId)){

							$objLead->UpdateCreater($_POST,"c_lead","leadID",$ImageId);

						}
					
					//header("Location:".$RedirectURL);
					echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;
			
		}
		

	
		$LeadStatus = 1;
				
		
	
    $arryDepartment = $objConfigure->GetDepartment();
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry','');
	$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');

  /*******Connecting to main database********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
if($arryLead[0]['country_id']>0){
$arryCountryName = $objRegion->GetCountryName($arryLead[0]['country_id']);
$CountryName = stripslashes($arryCountryName[0]["name"]);
}

if(!empty($arryLead[0]['state_id'])) {
$arryState = $objRegion->getStateName($arryLead[0]['state_id']);
$StateName = stripslashes($arryState[0]["name"]);
}else if(!empty($arryLead[0]['OtherState'])){
$StateName = stripslashes($arryLead[0]['OtherState']);
}

if(!empty($arryLead[0]['city_id'])) {
$arryCity = $objRegion->getCityName($arryLead[0]['city_id']);
$CityName = stripslashes($arryCity[0]["name"]);
}else if(!empty($arryLead[0]['OtherCity'])){
$CityName = stripslashes($arryEmployee[0]['OtherCity']);
}

/*******************************************/

	//$arryCountry = $objRegion->getCountry('','');

	require_once("../includes/footer.php"); 
?>

