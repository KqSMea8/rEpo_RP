<?php
	require_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/user.class.php");
	/*require_once($Prefix."classes/time.class.php");
	$objTime=new time();*/
	$objCommon=new common();
	$objEmployee=new employee();
	$objLeave=new leave();
	$objUser=new user();



	/*
	if(!empty($_POST["attDate"])) {
		if($_POST['attID']>0) {
			$objTime->updateAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_OUT;
		} else {		
			$objTime->addAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_IN;
		}
		header("location:home.php");
		exit;
	}*/


	/*****************************/
	$LastLoginTime = $objUser->GetLastLogin($_SESSION['AdminID'],$_SESSION['AdminType']);

	
	
	$PinPunch=0;
	$ShowDashboard = 0;
	if($_SESSION['AdminType'] != "admin") {   //Login Employee
		$ShowEmp = 1;
		$_GET['emp'] = $_SESSION['AdminID'];
		$arryEmployee = $objEmployee->GetEmployee($_GET['emp'],'');

		$EmpID   = $_GET['view'];	
		if($arryEmployee[0]['Supervisor']>0){
			$arrySupervisor = $objEmployee->GetEmployeeBrief($arryEmployee[0]['Supervisor']);
		}
		$arryLeave = $objCommon->GetAttributeByValue('','LeaveType');
		
		$IsDeptHead = $objCommon->IsDeptHead($_SESSION['AdminID']);

		/********************/		
		$NumDeptModules = sizeof($arrayDeptModules) +  3;   // +3 for ESS
		sizeof($arryMainMenu) .'=='. $NumDeptModules;
		if(sizeof($arryMainMenu) >= $NumDeptModules){
			$Config['FullPermission'] = 1;
		}		
		/********************/

		if(!empty($arryEmployee[0]['ExistingEmployee'])){
			$ShowDashboard = 1;
		}else{
			$Config['HideDefaultIcon'] = 1;
		}

		$PinPunch = $arryEmployee[0]['PinPunch'];
		

	}else{		//Login Superadmin
		$ShowEmp = 0;
		/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		$arryCompany = $objCompany->GetCompany($_SESSION['CmpID'],'');
		$ShowDashboard = 1;
	}
	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	/********/
	if($PinPunch==1){
		$arryExtraIcon[0]["IconID"] = 0; 
		$arryExtraIcon[0]["Module"] = "PIN Punch"; 
		$arryExtraIcon[0]["Link"] = "pinpunching.php"; 
		$arryExtraIcon[0]["IframeFancy"] = 'i'; 
		$arryExtraIcon[0]["depID"] = 1; 
		$arryExtraIcon[0]["EditPage"] = 0; 
		$arryExtraIcon[0]["IconType"] = 4; 
	}	 
	/********/
	require_once("../includes/footer.php"); 
?>
