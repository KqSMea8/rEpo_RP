<?php 


	/**************************************************/
	$ThisPageName = 'viewLead.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");
	

	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/company.class.php");

    $Module="Lead";
	$objLead=new lead();
	$objEmployee=new employee();
	$objContact=new contact();
	$objCommon=new common();
	$objCompany=new company();
	
	$ModuleName = "Lead";
	$RedirectURL = "viewLead.php?module=".$_GET["module"]."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Lead";

	$EditUrl = "editLead.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vLead.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	
	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";
			if($_GET['tab']=="Task" || $_GET['tab']=="Event"){
				$AddRef="editActivity.php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
			}else{

            $AddRef="edit".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
			$SelectRef="view".$_GET['tab'].".php?module=".$_GET['tab']."&parent_type=".$_GET['module']."&parentID=".$_GET['view']."&tabmode=".$_GET['tab']."&refrence=".$Module;
        $ViewUrl = "vLead.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
			}

	if($_POST){
	
          if($_POST['OpportunityName']!=''){

			  
                 $LastID = $objLead->AddOpportunity($_POST);
     		 if(!empty($LastID)){
                 $oppID = $objLead->ConvertLead($_POST['LeadID'],1);
				 }
				 
           header("location:viewOpportunity.php?module=Opportunity");
				 exit;

		  }else{
				 header("location:".$ViewUrl);
				exit;
				}
	}
				if($_GET['select_del_id'] && !empty($_GET['select_del_id'])){
						$_SESSION['mess_ticket'] = LEAD_REMOVE;
						$objLead->RemoveSelectCompaign($_REQUEST['select_del_id']);
						header("Location:".$ViewUrl.$_GET['tab']);
					}


					if (!empty($_GET['view'])) {
						$arryLead = $objLead->GetLead($_GET['view'],'');
						
					   /*****************************/
					   if($_GET['tab']=='Campaign'){
						$arryCampaign=$objLead->GetCompaignData($_GET['view'],$_GET['module'],$_GET['tab']);
						 $num=$objLead->numRows();
						$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
						(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
					   }

		/************************************/
		if($_GET['tab']=='Ticket'){
		$arryTicket=$objLead->GetTicketData($_GET['view'],$_GET['module'],$_GET['tab']);
		 $num=$objLead->numRows();
		$pagerLink=$objPager->getPager($arryTicket,$RecordsPerPage,$_GET['curP']);
		(count($arryCampaign)>0)?($arryTicket=$objPager->getPageRecords()):("");
		}

      
		$LeadID   = $_REQUEST['view'];	
		
		$arrySupervisor = $objEmployee->GetEmployeeBrief($arryLead[0]['AssignTo']);

		if($arryLead[0]['created_by']=='admin'){

	 /*******Connecting to main database********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
         if($arryLead[0]['created_id']>0){
		$createdEMP=$objCompany->GetCompany($arryLead[0]['created_id'],1);
		 }
		//print_r($createdEMP);
        
		}else{

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

        $createdEMP=  $objEmployee->GetEmployeeBrief($arryLead[0]['created_id']);
		}
		

		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

    $arryDepartment = $objConfigure->GetDepartment();
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	$arryIndustry = $objCommon->GetCrmAttribute('Industry','');
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


	require_once("../includes/footer.php"); 	 
?>


