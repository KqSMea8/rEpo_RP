<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'myAttendence.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objTime=new time();
	$objEmployee=new employee();
        
	if($_SESSION['AdminType'] != "admin") {
		$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
		$PinPunch = $arryEmployee[0]['PinPunch'];
	}else{
		$PinPunch = 1;
	}
	/***************************/		
	if($arryCompany[0]['PunchingBlock']==1){
		$PunchingIP = explode(",",$arryCompany[0]['PunchingIP']);
		$Ipaddress = GetIPAddress();
		if(!in_array($Ipaddress,$PunchingIP)){
			$ErrorMSG = BLOCKED_MSG;
		}
	}
	/***************************/		
	if(empty($PinPunch)){
		$ErrorMSG = NOT_ALLOWED_PIN_PUNCH;
	}
	/***************************/	

	if(empty($ErrorMSG)){
		$TodayDate =  $Config['TodayDate']; 
		$arryTime = explode(" ",$Config['TodayDate']);
		$TodayDate = $arryTime[0];
	}
		
	require_once("../includes/footer.php"); 	 
?>


