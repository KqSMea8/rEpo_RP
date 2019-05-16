<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	include_once("includes/FieldArray.php");
	$objTime=new time();



	/****************************/
	function time_diff_total($s){
		$m=0;$hr=0;$d=0; $td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			//$td = "$d day"; 
			if($d>1) $td .= "s";
			if($d<3){
				//if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		//if($s>0) $td .=  " $s sec";

		return $td;
	} 
	/****************************/



	CleanGet();


	if(empty($_GET['dt']) && empty($_GET['y'])){
		$attDate = date($Config['DateFormatForm'], strtotime($Config['TodayDate']));  
		$_GET['dt'] = $attDate;
	}

	$RedirectUrl ="myAttendence.php?s=1";
	$RedirectUrl .= (!empty($_GET['dt']))?("&dt=".$_GET['dt']):("");
	$RedirectUrl .= (!empty($_GET['y']))?("&y=".$_GET['y']):("");
	$RedirectUrl .= (!empty($_GET['m']))?("&m=".$_GET['m']):("");

	/*
	if(!empty($_POST["attDate"])) {
		CleanPost();
		if($_POST['attID']>0) {
			$objTime->updateAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_OUT;
		} else {		
			$objTime->addAttendence($_POST);
			$_SESSION['mess_att'] = PUNCHED_IN;
		}
		header("location:".$RedirectUrl);
		exit;
	}*/

	if(!empty($_GET['dt']) || (!empty($_GET['y']) && !empty($_GET['m']) ) ){
		$arryAttendence=$objTime->getAttendence('','', $_SESSION['AdminID'], $_GET['dt'], $_GET['y'], $_GET['m']);
		$num=sizeof($arryAttendence);
		$ShowList = 1;
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

