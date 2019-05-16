<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAttendence.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	$objTime=new time();


	$RedirectUrl ="punch.php?p=1";
	if($_GET['emp']>0)$RedirectUrl .= "&emp=".$_GET['emp'];
	if($_GET['depID']>0)$RedirectUrl .= "&depID=".$_GET['depID'];

	if(!empty($_POST["attDate"])) {   
		$attDate = explode("-",$_POST["attDate"]);
		$RedirectUrl = 'viewAttendence.php?y='.$attDate[0].'&m='.$attDate[1].'&emp='.$_POST["MainEmpID"].'&depID='.$_POST["Department"];

		$_POST['EmpID'] = $_POST['MainEmpID'];
		if($_POST['attID']>0) {
			$objTime->updateAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_OUT;
		} else {		
			$objTime->addAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_IN;
		}

		
		//header("location:".$RedirectUrl);
		echo '<script>window.parent.location.href="'.$RedirectUrl.'";</script>';
		exit;
	}



	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$Config['TodayDate']);
	$TodayDate = $arryTime[0];


	if($_GET['emp']>0){
		$arryToday = $objTime->getAttendence('','', $_GET['emp'],$TodayDate, '','');
		if(empty($arryToday[0]["attID"])){
			$PuchType = "In";
		}else if(empty($arryToday[0]["OutTime"]) && ($arryToday[0]["InComment"]!='OD' && $arryToday[0]["InComment"]!='L')){
			$PuchType = "Out";
		}else{
			$PuchType = "Done";
		}
	}

	require_once("../includes/footer.php"); 	 
?>


