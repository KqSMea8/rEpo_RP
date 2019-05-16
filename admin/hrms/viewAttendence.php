<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objTime=new time();
	$objEmployee=new employee();


	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryYearMonth = explode("-",$arryTime[0]);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];


	/****************************/
	$RedirectUrl ="viewAttendence.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['depID']))?("&depID=".$_GET['depID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = ATT_REMOVED;
		$objTime->deleteAttendence($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	


	if($_POST){
		CleanPost();
		if(sizeof($_POST['attID']>0)){
			$att = implode(",",$_POST['attID']);
			$_SESSION['mess_att'] = ATT_REMOVED;
			$objTime->deleteAttendence($att);
			header("location:".$RedirectUrl);
			exit;
		}
		
	}








	/*
	if($_POST) {
		if($_POST['attID']>0) {
			$objTime->updateAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_OUT;
		} else {		
			$objTime->addAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_IN;
		}
	
		header("location:".$RedirectUrl);
		exit;
		
	}
	*/

	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){

		/******Get Employee Records***********/	
		$RecordsPerPage = 100;
		$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;
		$Config['RecordsPerPage'] = $RecordsPerPage;
		$arryAttendence=$objTime->getAttendence($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		/**********Count Records**************/	
		$Config['GetNumRecords'] = 1;
		$arryCount=$objTime->getAttendence($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
		/*************************/	

		$ShowList = 1;
	}

	#$arryEmployee = $objEmployee->GetEmployeeBrief('');


	/*********************/
	if($arryCurrentLocation[0]['UseShift']==1){
		$LunchPaidMain = 1;
		$ShortBreakPaidMain = 1;
	}else{
		$LunchPaidMain = $arryCurrentLocation[0]['LunchPaid'];
		$ShortBreakPaidMain = $arryCurrentLocation[0]['ShortBreakPaid'];
	}
	/*********************/


	require_once("../includes/footer.php");
?>

