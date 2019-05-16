<?php
 $FancyBox=1; if($_GET['pop']==1)$HideNavigation = 1;
 /**************************************************/

    $ThisPageName = 'viewTicket.php';

 /**************************************************/
     
	require_once("../includes/header.php");
        require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/crm.class.php");
        require_once($Prefix."classes/region.class.php");
        require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	
	$ModuleName = "Ticket";
	//$RedirectURL = "viewTicket.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	if(empty($_GET['tab'])) $_GET['tab']="Information";

	

	//$EditUrl = "editTicket.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	//$ActionUrl = $EditUrl.$_GET["tab"];
	
	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
	$BackUrl = "viewTicket.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$RedirectURL = "viewTicket.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET['curP'];
	$EditUrl = "editTicket.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]; 
	
	$ActionUrl = $EditUrl.$_GET["tab"];
	}else{
	$RedirectURL = "viewTicket.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewTicket.php?curP=".$_GET['curP'];
	$EditUrl = "editTicket.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vTicket.php?view=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab=";
	
	
	$docUrl = "viewDocument.php?module=".$_GET["module"]."&tab=";
	if(empty($_GET['tab'])) $_GET['tab']="Information";

	$EditUrl = "editTicket.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];

   }
	
	$objLead = new lead();
	$objRegion = new region();
	$objEmployee = new employee();
	$objGroup = new group();
	$objActivity = new activity();
	$objCustomer = new Customer();
	$objCommon = new common();  
        /*******************/
	if($_SESSION['AdminType']=='admin'){
	$Admin=$_SESSION['AdminType'];
	}else{
	$Admin=$_SESSION['AdminID'];
	}
	/*******************/

	if($_GET['select_del_id'] && !empty($_GET['select_del_id'])){
		$_SESSION['mess_ticket'] = LEAD_REMOVE;
		$objLead->RemoveSelectCompaign($_REQUEST['select_del_id']);
		header("Location:".$ViewUrl."Campaign");
	}

	if (!empty($_GET['view'])) {

		$arryTicket = $objLead->GetTicket($_GET['view'],'');
		$TicketID   = $_REQUEST['view'];



		if(empty($arryTicket[0]['TicketID'])) {
			header('location:'.$RedirectURL);
			exit;
		}		
		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryTicket[0]['AssignedTo'] !=''){
				$arrAssigned = explode(",",$arryTicket[0]['AssignedTo']);
			}
			if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryTicket[0]['created_id'] != $_SESSION['AdminID']){				
				header('location:'.$RedirectURL);
				exit;
			}
		}
		/*****************/







		if($arryLead[0]['created_by']=='admin'){
			 $createdEMP[0]['UserName']="Administrator";
		}else{
			$createdEMP=  $objEmployee->GetEmployeeBrief($arryTicket[0]['created_id']);
		}

		if(!empty($arryTicket[0]['CustID'])){
			$arryCustomer = $objCustomer->GetCustomer($arryTicket[0]['CustID'],'','');
		}



/************************************************/
    if(!empty($arryTicket[0]['AssignedTo'])){ 
	if($arryTicket[0]['AssignType'] == 'Group'){ 
		$assignee = $arryTicket[0]['AssignedTo']; 
		$arryGrp = $objGroup->getGroup($arryTicket[0]['GroupID'],1);

		$AssignName = $arryGrp[0]['group_name'];
		$arryAssignee = $objLead->GetAssigneeUser($arryTicket[0]['AssignedTo']);
	} else{ 
		$assignee = $arryTicket[0]['AssignedTo'];
		$arryAssignee = $objLead->GetAssigneeUser($arryTicket[0]['AssignedTo']);
		$AssignName = $arryAssignee[0]['UserName'];
	}
     }
/************************************************/
if($_GET['tab'] == 'Campaign'){
        $arryCampaign=$objLead->GetCompaignData($_GET['view'],$_GET['module'],$_GET['tab']);
	$createdEMP= $objEmployee->GetEmployeeBrief($arryTicket[0]['created_id'] );
	$num=$objLead->numRows();
	$pagerLink=$objPager->getPager($arryCampaign,$RecordsPerPage,$_GET['curP']);
	(count($arryCampaign)>0)?($arryCampaign=$objPager->getPageRecords()):("");
}

         if($_GET['tab']=="Event"){

                if($_GET['act_id'] && !empty($_GET['act_id'])){
			$_SESSION['mess_Event'] =EVENT_REMOVE;
			$objActivity->deleteActivity($_GET['act_id']);
			header("Location:vTicket.php?view=".$_GET['view']."&module=".$_GET['module']."&tab=".$_GET['tab']);
		}


		$arryActivity=$objActivity->ListActivity('',$_GET['module'],$_GET['view'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num=$objActivity->numRows();
		$pagerLink=$objPager->getPager($arryActivity,$RecordsPerPage,$_GET['curP']);
		( count($arryActivity)>0)?($arryActivity=$objPager->getPageRecords()):("");

	}

/*************************************************/
        
	}
	

	require_once("../includes/footer.php"); 
?>
