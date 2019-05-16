<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objTime=new time();
	$objEmployee=new employee();

	/****************************/

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryYearMonth = explode("-",$arryTime[0]);
	if(empty($_GET['y'])) $_GET['y']=$arryYearMonth[0];
	if(empty($_GET['m'])) $_GET['m']=$arryYearMonth[1];


	/****************************/
	$RedirectUrl ="viewShortLeave.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['depID']))?("&depID=".$_GET['depID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_sl'] = SHORT_LEAVE_REMOVED;
		$objTime->deleteShortLeave($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	$Config['FullDayHour'] = $arryCurrentLocation[0]['FullDayHour'];		

	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
		$arryShortLeave=$objTime->getShortLeave($_GET['depID'], $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryShortLeave);
		$ShowList = 1;
		
		/*$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryShortLeave,$RecordsPerPage,$_GET['curP']);
		(count($arryShortLeave)>0)?($arryShortLeave=$objPager->getPageRecords()):("");*/

		
	}

	#$arryEmployee = $objEmployee->GetEmployeeBrief('');

	

	require_once("../includes/footer.php");
?>

