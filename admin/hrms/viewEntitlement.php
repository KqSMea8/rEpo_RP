<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	include_once("includes/FieldArray.php");
	$objLeave=new leave();
	$objEmployee=new employee();

	$ModuleName = "Leave Entitlement";	

	$RedirectUrl ="viewEntitlement.php?curP=".$_GET['curP'];


	if($_POST){
		CleanPost();
		if(sizeof($_POST['EntID']>0)){
			$Ent = implode(",",$_POST['EntID']);
			$_SESSION['mess_entitlement'] = ENT_REMOVED;
			$objLeave->deleteEntitlementMulti($Ent);
			header("location:".$RedirectUrl);
			exit;
		}
		
	}

	
	/******Get Entitlement Records***********/	
	$RecordsPerPage = 100;
	$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryEntitlement=$objLeave->ListEntitlement($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objLeave->ListEntitlement($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	

	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	require_once("../includes/footer.php");
?>

