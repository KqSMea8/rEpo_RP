<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAttendence.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	$objTime=new time();

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


	if($_GET['emp']>0){
		$arryToday = $objTime->getAttendence('','', $_GET['emp'],$TodayDate, '','');
		if(empty($arryToday[0]["attID"])){
			$PuchType = "In";
		}else if(empty($arryToday[0]["OutTime"])){
			$PuchType = "Out";
		}else{
			$PuchType = "Done";
		}
	}

	require_once("../includes/footer.php"); 	 
?>


