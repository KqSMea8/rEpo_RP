<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAttendence.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objTime=new time();
	$objEmployee=new employee();


	$RedirectUrl ="punchadmin.php?p=1";
	if($_GET['emp']>0)$RedirectUrl .= "&emp=".$_GET['emp'];
	if($_GET['depID']>0)$RedirectUrl .= "&depID=".$_GET['depID'];

	$PunchingTitle='Punch In/Out';
	$HideForBreak='';


	if(!empty($_POST["attDate"])) {   
		$attDate = explode("-",$_POST["attDate"]);
		$RedirectUrl = 'viewAttendence.php?y='.$attDate[0].'&m='.$attDate[1].'&emp='.$_POST["MainEmpID"].'&depID='.$_POST["Department"];

		$_POST['EmpID'] = $_POST['MainEmpID'];


		if(!empty($_POST['punchType'])){
			if($_POST['punchID']>0) {
				$objTime->updateAttPunching($_POST);
				$_SESSION['mess_att'] = PUNCHED_IN;
			}else{
				$objTime->addAttPunching($_POST);
				$_SESSION['mess_att'] = PUNCHED_OUT;
			}
		}else{
			if($_POST['attID']>0) {
				$objTime->updateAttendence($_POST);
				$_SESSION['mess_att'] = PUNCHED_OUT;
			} else {  	
				$objTime->addAttendence($_POST);
				$_SESSION['mess_att'] = PUNCHED_IN;
			}
		}

		
		//header("location:".$RedirectUrl);
		echo '<script>window.parent.location.href="'.$RedirectUrl.'";</script>';
		exit;
	}
	
	$arryTime = explode(" ",$Config['TodayDate']);

	if(!empty($_GET['dt'])){
		$TodayDate = $_GET['dt'];
	}else{	
		$TodayDate = $arryTime[0];
	}

	

	$InTimeHead = 'In Time';
	$OutTimeHead = 'Out Time';

	if($_GET['emp']>0){
		$arryToday = $objTime->getAttendence('','', $_GET['emp'],$TodayDate, '','');
		/***********************************/
		if(empty($arryToday[0]["attID"])){
			$PuchType = "In";
			$PunchingTitle = "Punch ".$PuchType; 
		}else if(empty($arryToday[0]["OutTime"]) && ($arryToday[0]["InComment"]!='OD' && $arryToday[0]["InComment"]!='L')){
			$PuchType = "Out";
			$PunchingTitle = "Punch ".$PuchType; 
			$arryPendingOut = $objTime->getPunchingOutPending($arryToday[0]["attID"], $_GET['emp']);
			if(!empty($arryPendingOut[0]['punchID'])){
				$PunchingTitle = $arryPendingOut[0]['punchType']." In"; 
				$arryToday[0]["InTime"] = $arryPendingOut[0]['InTime'];	
				$arryToday[0]["InComment"] = $arryPendingOut[0]['InComment'];
				$InTimeHead = 'Out Time';
				$OutTimeHead = 'In Time';
				$PuchType = "In";
				$HideForBreak = 'Style="display:none;"';
			}

			$TotalShortBreak = $objTime->getPunchingCount($arryToday[0]["attID"], $_GET['emp'],'Short Break');	

			$TotalLunch = $objTime->getPunchingCount($arryToday[0]["attID"], $_GET['emp'],'Lunch');	
		
		}else{
			$PuchType = "Done";
			$PunchingTitle = "Punch ".$PuchType; 
		}
	
	
		/***************************/
		$arryEmployee = $objEmployee->GetEmployee($_GET['emp'],'');
		if($_SESSION['AdminType'] == "employee" && $_SESSION['AdminID']==$arryEmployee[0]['EmpID']) { 
			$ErrorMSG = CANT_PUNCH_SELF;
		}
		/***************************/
		if($arryCurrentLocation[0]['UseShift']==1){ //from shift

			if($arryEmployee[0]['shiftID']>0){
				$arryShift = $objCommon->getShift($arryEmployee[0]['shiftID'],'1');			
				$ShortBreakLimit = $arryShift[0]['ShortBreakLimit'];		
				$LunchPunch = $arryShift[0]['LunchPunch'];
				$ShortBreakPunch = $arryShift[0]['ShortBreakPunch'];
			}
			
			if(empty($arryShift[0]['shiftID'])){
				$ErrorMSG = NO_SHIFT_ASSIGNED_EMP;
			}
		}else{ //from location 
			$ShortBreakLimit = $arryCurrentLocation[0]['ShortBreakLimit'];		
			$LunchPunch = $arryCurrentLocation[0]['LunchPunch'];
			$ShortBreakPunch = $arryCurrentLocation[0]['ShortBreakPunch'];
		}
		/***************************/	
		/***********************************/
	}

	require_once("../includes/footer.php"); 	 
?>


