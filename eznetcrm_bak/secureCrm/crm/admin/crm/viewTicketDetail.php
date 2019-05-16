<?php
 /**************************************************/
    $ThisPageName = 'viewTicket.php'; $EditPage = 1;
    /**************************************************/
$FancyBox=1;
	require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/region.class.php");
	
	
	$ModuleName = "Ticket";
	//$RedirectURL = "viewTicket.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Information";

	//$EditUrl = "editTicket.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	//$ActionUrl = $EditUrl.$_GET["tab"];


	$objLead=new lead();
	$objRegion=new region();

    /*******************/
	if($_SESSION['AdminType']=='admin'){
      $Admin=$_SESSION['AdminType'];
	}else{
    $Admin=$_SESSION['AdminID'];
	}
	/*******************/


	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){


       //$multiple_action_id=rtrim($_GET['multiple_action_id']);

	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objLead->RemoveTicket($del_id);
					}
					$_SESSION['mess_ticket'] = $ModuleName.'(s) '.$MSG[103];
					break;
			case 'active':
					$objLead->MultipleTicketStatus($multiple_action_id,1);
					$_SESSION['mess_ticket'] = $ModuleName.'(s) '.$MSG[107];
					break;
			case 'inactive':
					$objLead->MultipleTicketStatus($multiple_action_id,0);
					$_SESSION['mess_ticket'] = $ModuleName.'(s) '.$MSG[108];
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/	
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_ticket'] = $ModuleName.$MSG[103];
		$objLead->RemoveTicket($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}
/* if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_ticket'] = $ModuleName.$MSG[104];
		$objLead->changeContactStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}*/
 if ($_POST) {
			/*if (empty($_POST['Email']) && empty($_POST['TicketID'])) {
				$errMsg = $MSG[10];
			 } else {*/
				if (!empty($_POST['TicketID'])) {
					$ImageId = $_POST['TicketID'];
					/*
					$objLead->UpdateContact($_POST);
					$_SESSION['mess_ticket'] = $ModuleName.$MSG[102];
					*/
					/***************************/
					/* switch($_GET['tab']){
						case 'Information':
							$objLead->UpdateTicketDetail($_POST);
							$_SESSION['mess_ticket'] = 'Ticket Information has been updated successfully.';
							break;
						case 'Description':
							$objLead->UpdateDescription($_POST);
							$_SESSION['mess_ticket'] = 'Ticket Description details has been updated successfully.';
							break;
						case 'Resolution':
							$objLead->UpdateResolution($_POST);
							$_SESSION['mess_ticket'] = 'Ticket Solution details has been updated successfully.';
							break;
						
					}*/
					/***************************/
				} else {	
					/*if($objLead->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_ticket'] = $MSG[105];
					}else{*/	
						$ImageId = $objLead->AddTicket($_POST); 
						$_SESSION['mess_ticket'] = $ModuleName.$MSG[101];
					//}
				}
				
				$_POST['TicketID'] = $ImageId;

				if($_POST['TicketID']>0 || $_GET['tab']=="account"){
					$objConfig->UpdateAdminModules($_POST['Modules'],$_POST['TicketID'],$_POST['Role']);
				}

				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			//}
		}
		

	if (!empty($_GET['edit'])) {
		$arryTicket = $objLead->GetTicket($_GET['edit'],'');
		$TicketID   = $_REQUEST['edit'];
		$arryCmtUser = $objLead->GetCommentUser($_GET['edit'],'');
		//print_r($arryCmtUser);
	}
	/*************************/		
	//$arryDepartment = $objConfig->GetDepartment();
	/*$arryGraduation = $objConfig->GetAttributeValue('Graduation','');
	$arryPostGraduation = $objConfig->GetAttributeValue('PostGraduation','');
	$arryDoctorate = $objConfig->GetAttributeValue('Doctorate','');
	$arryJobTitle = $objConfig->GetAttributeValue('JobTitle','');
	$arryJobType = $objConfig->GetAttributeValue('JobType','');
	$arrySalaryFrequency = $objConfig->GetAttributeValue('SalaryFrequency','');
	$arryCountry = $objRegion->getCountry('','');*/
	/*************************/	

	require_once("../includes/footer.php"); 
?>