<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objTime=new time();
	$objEmployee=new employee();


	/*
	$Config['WorkingHour'] = 9;
	$InTime = '09:59';
	$OutTime = '19:00';
	$EmpWorkingHour = $objTime->GetTimeDifference($InTime,$OutTime,1);
	if($EmpWorkingHour > $Config['WorkingHour']){
		$Hours = $EmpWorkingHour - $Config['WorkingHour'];
	}*/

	/****************************/

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryYearMonth = explode("-",$arryTime[0]);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];


	/****************************/

	$RedirectUrl ="viewOvertime.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['depID']))?("&depID=".$_GET['depID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_ov'] = OVN_REMOVED;
		$objTime->deleteOvertime($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	


	if($_POST){
		
		if(sizeof($_POST['OvID']>0)){
			$att = implode(",",$_POST['OvID']);
			$_SESSION['mess_ov'] = OVN_REMOVED;
			$objTime->deleteOvertime($att);
			header("location:".$RedirectUrl);
			exit;
		}
		
	}



	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
		$arryOvertime=$objTime->getOvertime($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryOvertime);
		$ShowList = 1;
		
		$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryOvertime,$RecordsPerPage,$_GET['curP']);
		(count($arryOvertime)>0)?($arryOvertime=$objPager->getPageRecords()):("");

		/*****************************
		foreach($arryOvertime as $key=>$values){
			$empID = $values['EmpID'];
			$arryList[$empID]['EmpID'] = $values['EmpID'];
			$arryList[$empID]['EmpCode'] = $values['EmpCode'];
			$arryList[$empID]['UserName'] = $values['UserName'];

		}
		/*****************************/

		//echo '<pre>';print_r($arryList);echo '</pre>';

		
	}


	/*********************/
	if($arryCurrentLocation[0]['UseShift']==1){
		$LunchPaidMain = 1;
		$ShortBreakPaidMain = 1;
	}else{
		$LunchPaidMain = $arryCurrentLocation[0]['LunchPaid'];
		$ShortBreakPaidMain = $arryCurrentLocation[0]['ShortBreakPaid'];
	}

	/*********************
	$WeekStart = $arryCurrentLocation[0]['WeekStart'];
	echo $WeekEnd = $arryCurrentLocation[0]['WeekEnd'];
	echo $WeekEndVal = date('N', strtotime($WeekEnd));
	if($WeekEndNo==7 ) $WeekEndNo=0;
	if($WeekStart!='' && $WeekEnd!=''){
		$WeekEndArry = GetWeekEndNum($WeekStart,$WeekEnd);
	}
	//print_r($WeekEndArry);
	/******************/



	require_once("../includes/footer.php");
?>

