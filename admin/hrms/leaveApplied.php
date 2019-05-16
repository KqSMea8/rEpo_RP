<?php 
	/**************************************************/
	$ThisPageName = 'myLeave.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objLeave=new leave();
	$objEmployee=new employee();

	//if($arryCurrentLocation[0]['Advance']==1){
	foreach($arryCurrentLocation[0] as $key=>$values){
		$Config[$key] = $values;
	}
	

	$RedirectUrl = "leaveApplied.php";

	if($_GET['action']=='edit'){
		if(!empty($_GET['Approve'])){
			$_SESSION['mess_leave'] = LV_APPROVED;
			$objLeave->AuthorizeLeave($_GET['Approve'],1);		
			header("Location:".$RedirectUrl);
			exit;
		}else if(!empty($_GET['Reject'])){
			$_SESSION['mess_leave'] = LV_REJECTED;
			$objLeave->AuthorizeLeave($_GET['Reject'],2);
			header("Location:".$RedirectUrl);
			exit;

		}
	}



	/*
	$arryLeave=$objLeave->LeaveApplied($_GET['key'],$_GET['sortby'],$_GET['FromDate'],$_GET['ToDate'],$_GET['asc']);
	$num=sizeof($arryLeave);*/


	if($_SESSION['AdminType'] == "employee") { 
		$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');

		/************************/	
		if(empty($arryEmployee[0]['EmpID'])){
			$ErrorMSG = EMP_NOT_EXIST;
		}else if(empty($arryEmployee[0]['ExistingEmployee'])){
			$ErrorMSG = NOT_EXIST_EMPLOYEE;
		}
		/************************/

		$Config['LeaveApplyToMe'] = 1;
		if($arryEmployee[0]['Department']>0 && ($arryEmployee[0]['DeptHead']=='1' || $arryEmployee[0]['OtherHead']=='1')){
			$arryLeave=$objLeave->GetLeaveByDepartment($arryEmployee[0]['Department']);
			$num=sizeof($arryLeave);
		}




	}

	$EditUrl = "leaveApplied.php?action=edit";

	$pagerLink=$objPager->getPager($arryLeave,$RecordsPerPage,$_GET['curP']);
	(count($arryLeave)>0)?($arryLeave=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php");
?>

