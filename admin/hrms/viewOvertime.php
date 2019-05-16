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

	$RedirectUrl ="viewOvertime.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");
	$RedirectUrl .= (!empty($_GET['depID']))?("&depID=".$_GET['depID']):("");
	$RedirectUrl .= (!empty($_GET['emp']))?("&emp=".$_GET['emp']):("");



	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
		$arryOvertime=$objTime->getOvertime($_GET['depID'],'', $_GET['emp'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryOvertime);
		$ShowList = 1;
		
		$RecordsPerPage = 100;
		$pagerLink=$objPager->getPager($arryOvertime,$RecordsPerPage,$_GET['curP']);
		(count($arryOvertime)>0)?($arryOvertime=$objPager->getPageRecords()):("");
		
	}

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

