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

	/*
	$RedirectUrl ="puching.php";

	if(!empty($_POST["attDate"])) {
		if($_POST['attID']>0) {
			$objTime->updateAttendence($_POST);
			$_SESSION['mess_punch'] = PUNCHED_OUT;
		} else {		
			$objTime->addAttendence($_POST);
			$_SESSION['mess_punch'] = PUNCHED_IN;
		}
		header("location:".$RedirectUrl);
		exit;
	}*/



	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$Config['TodayDate']);
	$TodayDate = $arryTime[0];


	$InTimeHead = 'In Time';
	$OutTimeHead = 'Out Time';

	$arryToday = $objTime->getAttendence('','', $_SESSION['AdminID'],$TodayDate, '','');
	if(empty($arryToday[0]["attID"])){
		$PuchType = "In";
		$PunchingTitle = "Punching ".$PuchType; 
	}else if(empty($arryToday[0]["OutTime"])){
		$PuchType = "Out";
		$PunchingTitle = "Punching ".$PuchType; 
		$arryPendingOut = $objTime->getPunchingOutPending($arryToday[0]["attID"], $_SESSION['AdminID']);
		if(!empty($arryPendingOut[0]['punchID'])){
			$PunchingTitle = $arryPendingOut[0]['punchType']." In"; 
			$arryToday[0]["InTime"] = $arryPendingOut[0]['InTime'];	
			$arryToday[0]["InComment"] = $arryPendingOut[0]['InComment'];
			$InTimeHead = 'Out Time';
			$OutTimeHead = 'In Time';
			$PuchType = "In";
		}

		$TotalShortBreak = $objTime->getPunchingCount($arryToday[0]["attID"], $_SESSION['AdminID'],'Short Break');	

		$TotalLunch = $objTime->getPunchingCount($arryToday[0]["attID"], $_SESSION['AdminID'],'Lunch');	
		
	}else{
		$PuchType = "Done";
		$PunchingTitle = "Punching ".$PuchType; 
	}

	
	/***************************/
	$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
	/***************************/
	if($arryCurrentLocation[0]['UseShift']==1){ //from shift 
		if($arryEmployee[0]['shiftID']>0){
			$arryShift = $objCommon->getShift($arryEmployee[0]['shiftID'],'1');
			$ShortBreakLimit = $arryShift[0]['ShortBreakLimit'];
			$WorkingHourStart = $arryShift[0]['WorkingHourStart'];
			$WorkingHourEnd = $arryShift[0]['WorkingHourEnd'];
			$FlexTime = $arryShift[0]['FlexTime'];
			$LunchTime = $arryShift[0]['LunchTime'];
			$LunchPunch = $arryShift[0]['LunchPunch'];
			$ShortBreakPunch = $arryShift[0]['ShortBreakPunch'];
			$ShortBreakTime = $arryShift[0]['ShortBreakTime'];
		}
			
		if(empty($arryShift[0]['shiftID'])){
			$ErrorMSG = NO_SHIFT_ASSIGNED;
		}
	}else{ //from location 
		$ShortBreakLimit = $arryCurrentLocation[0]['ShortBreakLimit'];
		$WorkingHourStart = $arryCurrentLocation[0]['WorkingHourStart'];
		$WorkingHourEnd = $arryCurrentLocation[0]['WorkingHourEnd'];
		$FlexTime = $arryCurrentLocation[0]['FlexTime'];
		$LunchTime = $arryCurrentLocation[0]['LunchTime'];
		$LunchPunch = $arryCurrentLocation[0]['LunchPunch'];
		$ShortBreakPunch = $arryCurrentLocation[0]['ShortBreakPunch'];
		$ShortBreakTime = $arryCurrentLocation[0]['ShortBreakTime'];
	}
	/***************************/		
	if(!empty($LunchTime)){
		$arryLunchTime = explode(":",$LunchTime);
		$LunchTime = $arryLunchTime[0].' hrs '.$arryLunchTime[1].' min';
	}
	
	$Config['TimeFormat'] = str_replace(":s","",$Config['TimeFormat']);

	require_once("../includes/footer.php"); 	 
?>


