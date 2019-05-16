<?php
	/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once("includes/FieldArray.php");
	$objCommon=new common();
	$objBankAccount=new BankAccount();

	$RedirectUrl = "globalSetting.php";

	if($_POST){
		CleanPost();
		$objConfigure->updateGlobalLocation($_POST);
		$_SESSION['mess_global'] = GLOBAL_UPDATED;
		header("location:".$RedirectUrl);
		exit;
	}

	$arryGlobal = $objConfigure->GetLocation($_SESSION['locationID'],'');
	$arryBankAccount = $objBankAccount->getBankAccountWithAccountType();

	//echo $arryGlobal[0]['WeekStart'].' '.$arryGlobal[0]['WeekEnd'];



//$TodayDate = '2015-03-18'; $weekDay = date('l w', strtotime($TodayDate));

//$WeekEndArry = GetWeekEndNum($arryGlobal[0]['WeekStart'],$arryGlobal[0]['WeekEnd']);
//print_r($WeekEndArry);

	/***********************************
	$arryLeaveCheck=$objCommon->getLeaveCheck('','');
	$numLeaveCheck=$objCommon->numRows();

	$TodayDate = $Config['TodayDate'];
	$arryDate = explode("-",$TodayDate);
	$arryDay = explode(" ",$arryDate[2]);

	$today  = date("m-d", strtotime($TodayDate));
	$tomorrow  = date("m-d", mktime(0, 0, 0, $arryDate[1] , $arryDay[0]+1, $arryDate[0]));

	$sql = "SELECT EmpID,UserName FROM `h_employee` WHERE Status=1 and (`date_of_birth` LIKE '%".$today."' or `date_of_birth` LIKE '%".$tomorrow."') ";
	$arryDB = $objConfigure->query($sql,1);

	$sql = "SELECT EmpID,UserName FROM `h_employee` WHERE Status=1 and (JoiningDate LIKE '%".$today."' or JoiningDate LIKE '%".$tomorrow."') ";
	$arryJoining = $objConfigure->query($sql,1);
	
	$arryEvent = array_merge($arryDB,$arryJoining );
	/***********************************/

	

	require_once("../includes/footer.php");  
?>
