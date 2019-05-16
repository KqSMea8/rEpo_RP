<?php 
	/**************************************************/
	$ThisPageName = 'viewCampaign.php';  

	if(!empty($_GET['pop'])){  
		$HideNavigation = 1;  
	} 
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/item.class.php");
	 /*mass mail code */
        require_once(_ROOT . "/lib/mailchamp/src/config.php");
        
        $Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
        $Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
        $Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
        $Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);
        $Mailchimp_Reports = new Mailchimp_Reports($MailChimp);
        $Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];
        
        /*mass mail code */
        
         //By Chetan3Aug//
        require_once($Prefix."classes/field.class.php");
        
        $objField = new field();
        $arryHead=$objField->getHead('',$ModuleParentID,1);
        //End//
        
        
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
		$arryEmployee = $objEmployee->GetEmployeeBrief($arryCampaign[0]['assignedTo']); //By Chetan 3Aug//
		//print_r($arryEmp);
		}

		
	}

	

	if(empty($arryCampaign[0]['campaignID'])) {
		header('location:'.$RedirectURL);
		exit;
	}		
	/*****************/
	if($Config['vAllRecord']!=1){
		if($arryCampaign[0]['assignedTo'] != $_SESSION['AdminID'] && $arryCampaign[0]['created_id'] != $_SESSION['AdminID']){
		header('location:'.$RedirectURL);
		exit;
		}
	}
	/*****************/

               if($arryCampaign[0]['created_by']=='admin'){
			 $createdEMP[0]['UserName']="Administrator";
		}else{
			$createdEMP=  $objEmployee->GetEmployeeBrief($arryCampaign[0]['created_id']);
		}


	require_once("../includes/footer.php"); 	 
?>


