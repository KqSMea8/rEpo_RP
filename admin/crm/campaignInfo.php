<?php 
	$HideNavigation = 1;
	
	/**************************************************/
	$ThisPageName = 'viewCampaign.php';  
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/item.class.php");
	
	$objLead=new lead();
	$objItems=new items();
	$objEmployee=new employee();
	$Module = "Campaign";
	$RedirectURL = "viewCampaign.php?module=".$_GET["module"]."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Campaign";

	$EditUrl = "editCampaign.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vCampaign.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 

	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";


	if (!empty($_GET['view'])) {
		$arryCampaign = $objLead->GetCampaign($_GET['view'],'');
                $PageHeading = 'View Campaign for: '.stripslashes($arryCampaign[0]['campaignname']);

		$CampaignID   = $_GET['view'];	
			if(!empty($arryCampaign[0]['product'])){
					$arryProduct=$objItems->GetItems($arryCampaign[0]['product'],'',1,'');
			}
		if(!empty($arryCampaign[0]['assignedTo'])){
		$arryEmp = $objEmployee->GetEmployeeBrief($arryCampaign[0]['assignedTo']);
		//print_r($arryEmp);
		}

		
	}

	
	/*****************/

	/*****************/

               if($arryCampaign[0]['created_by']=='admin'){
			 $createdEMP[0]['UserName']="Administrator";
		}else{
			$createdEMP=  $objEmployee->GetEmployeeBrief($arryCampaign[0]['created_id']);
		}


	require_once("../includes/footer.php"); 	 
?>


