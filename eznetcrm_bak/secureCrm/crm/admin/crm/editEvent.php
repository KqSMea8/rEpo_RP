<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewEvent.php'; $EditPage = 1;
    /**************************************************/
   
	  require_once("../includes/header.php");
        require_once($Prefix."classes/event.class.php");
        require_once($Prefix."classes/region.class.php");
		require_once($Prefix."classes/employee.class.php");
	     require_once($Prefix."classes/lead.class.php");
	
	       $objLead=new lead();
	
	$ModuleName = "Event";
	$RedirectURL = "viewEvent.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	if(empty($_GET['tab'])) $_GET['tab']="Summary";

	$EditUrl = "editEvent.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&module=".$_GET["module"]."&tab=Event"; 
	


	$objEvent=new event();
	$objRegion=new region();
	$objEmployee=new employee();
	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objEvent->RemoveEvent($del_id);
					}
					$_SESSION['mess_event'] = $ModuleName.'(s) '.$MSG[103];
					break;
			case 'active':
					$objEvent->MultipleEventStatus($multiple_action_id,1);
					$_SESSION['mess_event'] = $ModuleName.'(s) '.$MSG[107];
					break;
			case 'inactive':
					$objEvent->MultipleEventStatus($multiple_action_id,0);
					$_SESSION['mess_event'] = $ModuleName.'(s) '.$MSG[108];
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/************************  End Multiple Actions ***************/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_event'] = $ModuleName.$MSG[103];
		$objEvent->RemoveEvent($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_event'] = $ModuleName.$MSG[104];
		$objEvent->changeEventStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}
	
	/***************************************************************/
	
	 if ($_POST) {
			 
				if (!empty($_POST['eventID'])) {
					$ImageId = $_POST['eventID'];
					
					/***************************/
					switch($_GET['tab']){
						case 'Event':
							$objEvent->UpdateEvent($_POST);
							$_SESSION['mess_event'] = 'Event details has been updated successfully.';
							header("Location:".$RedirectURL);
							exit;
							break;
						
						
					}
					/***************************/
				} else {	
					//if($objEvent->isEmailExists($_POST['Email'],'')){
						//$_SESSION['mess_event'] = $MSG[105];
					//}else{	
						$ImageId = $objEvent->AddEvent($_POST); 
						$_SESSION['mess_event'] = $ModuleName.$MSG[101];
					//}
				}
				
				$_POST['eventID'] = $ImageId;

				
				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			
		}
		

	if (!empty($_GET['edit'])) {
		$arryEvent = $objEvent->GetEvent($_GET['edit'],'');
        $arryEventDetail=$objEvent->GetEventDetail($_GET['edit'],'');

		$eventID   = $_REQUEST['edit'];			
	}
				
	if($arryEvent[0]['Status'] != ''){
		$EventStatus = $arryEvent[0]['Status'];
	}else{
		$EventStatus = 1;
	}				
		
	
    $arryDepartment = $objConfigure->GetDepartment();
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryEventStatus = $objConfigure->GetCrmAttribute('EventStatus','');
	$arryEventSource = $objConfigure->GetCrmAttribute('EventSource','');
	$arryIndustry = $objConfigure->GetCrmAttribute('EventIndustry','');
	$arrySalesStage = $objConfigure->GetCrmAttribute('SalesStage','');

 

/*******************************************/

	//$arryCountry = $objRegion->getCountry('','');

	require_once("../includes/footer.php"); 
?>


