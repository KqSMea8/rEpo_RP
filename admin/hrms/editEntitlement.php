<?php
	/**************************************************/
	$ThisPageName = 'viewEntitlement.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objLeave=new leave();
	$objEmployee=new employee();
	$objCommon=new common();

	$RedirectUrl ="viewEntitlement.php?curP=".$_GET['curP'];

	$ModuleName = "Leave Entitlement";	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_entitlement'] = ENT_REMOVED;
		$objLeave->deleteEntitlement($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['EntID'])) {
			$objLeave->updateEntitlement($_POST);
			$_SESSION['mess_entitlement'] = ENT_UPDATED;
		} else {		
			$objLeave->addEntitlement($_POST);
			$_SESSION['mess_entitlement'] = ENT_ADDED;
		}
	
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryEntitlement = $objLeave->getEntitlement($_GET['edit']);
		$PageHeading = 'Edit Leave Entitlement for Employee: '.stripslashes($arryEntitlement[0]['UserName']);
		if($arryEntitlement[0]['LeaveStart']>0) $LeaveStart = $arryEntitlement[0]['LeaveStart'];
		if($arryEntitlement[0]['LeaveEnd']>0) $LeaveEnd = $arryEntitlement[0]['LeaveEnd'];
		$Width = '45%';
	}else{
		
		if(!empty($_GET['t'])){
			$_GET['JobType'] = $_GET['t']; 
			$_GET['FixedLeave'] = 1;
			$_GET['ExistingEmployee'] = '1';
			$arryEmployee = $objEmployee->GetEmployeeList($_GET);
			$numEmp = sizeof($arryEmployee);
		}

		$arryJobType = $objCommon->GetAttributeValue('JobType','');

		$arryLeavePeriod = $objLeave->GetLeavePeriod();
		if($arryLeavePeriod[0]['LeaveStart']>0) $LeaveStart = $arryLeavePeriod[0]['LeaveStart'];
		if($arryLeavePeriod[0]['LeaveEnd']>0) $LeaveEnd = $arryLeavePeriod[0]['LeaveEnd'];
		$Width = '20%';
	}


	$arryLeaveType = $objCommon->GetAttributeValue('LeaveType','');
	require_once("../includes/footer.php"); 

?>
