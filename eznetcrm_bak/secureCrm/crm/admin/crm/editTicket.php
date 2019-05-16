<?php

    /**************************************************/
    $ThisPageName = 'viewTicket.php'; $EditPage = 1;
    /**************************************************/
    $FancyBox=1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/sales.customer.class.php");			
			
	
	
	$ModuleName = "Ticket";
	
	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
	$BackUrl = "viewTicket.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$RedirectURL = "viewTicket.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET['curP'];
	$EditUrl = "editTicket.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]; 
	
	$ActionUrl = $EditUrl.$_GET["tab"];
	}else{
	$RedirectURL = "viewTicket.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewTicket.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Information";

	$EditUrl = "editTicket.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
   }
	
	
	


	$objLead=new lead();
	$objGroup=new group();
	$objEmployee=new employee();
	$objCommon=new common();
	$objCustomer=new Customer();  
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objLead->RemoveTicket($del_id);
					}
					$_SESSION['mess_ticket'] = TICKET_REMOVED;
					break;
			case 'active':
					$objLead->MultipleTicketStatus($multiple_action_id,1);
					$_SESSION['mess_ticket'] = TICKET_REMOVED;
					break;
			case 'inactive':
					$objLead->MultipleTicketStatus($multiple_action_id,0);
					$_SESSION['mess_ticket'] = TICKET_REMOVED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/	
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_ticket'] = TICKET_REMOVED;
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
					switch($_GET['tab']){
						case 'Information':
							$objLead->UpdateTicketDetail($_POST);
							$_SESSION['mess_ticket'] = TICKET_INFO_UPDATED;
							break;
						case 'Description':
							$objLead->UpdateDescription($_POST);
							$_SESSION['mess_ticket'] = TICKET_DES_UPDATED; 
							break;
						case 'Resolution':
							$objLead->UpdateResolution($_POST);
							$_SESSION['mess_ticket'] = TICKET_RES_UPDATED;
							break;
						
					}
					/***************************/
				} else {	
					/*if($objLead->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_ticket'] = $MSG[105];
					}else{*/	
						$ImageId = $objLead->AddTicket($_POST); 
						$_SESSION['mess_ticket'] = TICKET_ADDED;
					//}
				}
				
				$_POST['TicketID'] = $ImageId;

				

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






			if($arryTicket[0]['AssignType'] == "User" || $arryTicket[0]['AssignType'] =='' ){

				$classUser = 'style="display:block;"';
				$classGroup = 'style="display:none;"';
if($arryTicket[0]['AssignedTo'] !=''){
				$arryEmp=$objLead->GetAssigneeUser($arryTicket[0]['AssignedTo']); }
				$return_array = array();
				for ($i=0;$i<sizeof($arryEmp);$i++) {


					$row_array2['id'] = $arryEmp[$i]['EmpID'];
					$row_array2['name'] =$arryEmp[$i]['UserName'];
					$row_array2['department'] =$arryEmp[$i]['emp_dep'];
					$row_array2['designation'] = $arryEmp[$i]['JobTitle'];
				if($arryEmp[$i]['Image']==''){
				 $row_array2['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
				}else{
				 $row_array2['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$arryEmp[$i]['Image']."";
				}

				array_push($return_array,$row_array2);


			}
 $json_response2= json_encode($return_array); 

				
				      }elseif($arryTicket[0]['AssignType'] == "Group"){
						$classUser = 'style="display:none;"';
						$classGroup = 'style="display:block;"';
				}else{
					$classUser = 'style="display:block;"';
					$classGroup = 'style="display:none;"';
				}
		/*  if($arryTicket[0]['AssignType'] == 'Group'){ 
		$assignee = $arryTicket[0]['assignTo']; 
		} else{ 
		$assignee = $arryTicket[0]['assignTo'];
		}*/			
		}else{

		$classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';
		}
	/*************************/			
	$arryGroup = $objGroup->getGroup("",1);
	
	$arryTicketStatus = $objCommon->GetCrmAttribute('TicketStatus','');
	$arryPriority = $objCommon->GetCrmAttribute('Priority','');
	$arryTicketCategory = $objCommon->GetCrmAttribute('TicketCategory','');
	$_GET['Status']=1;$_GET['Division']=5;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryCustomer = $objCustomer->GetCustomer('','','Yes');
	/*************************/	

	require_once("../includes/footer.php"); 
?>
