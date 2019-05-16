<?php
	/**************************************************/
	$ThisPageName = 'viewDecStructure.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objPayroll=new payroll();

	$ModuleName = "Head";
	$RedirectURL ="viewDecStructure.php?cat=".$_GET['cat'];

	if(empty($_GET['cat'])){
		header("location: viewDecStructure.php");
		exit;
	}

	$arryDecCategory=$objPayroll->getDecCategory($_GET['cat'],'');
	$PayCategory = $arryDecCategory[0]['catName'];
	if(empty($PayCategory)){
		header("location: viewDecStructure.php");
		exit;
	}
	/*************************/


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_dechead'] = HEAD_REMOVED;
		$objPayroll->deleteDecHead($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_dechead'] = HEAD_STATUS_CHANGED;
		$objPayroll->changeDecHeadStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['headID'])) {
			$objPayroll->updateDecHead($_POST);
			$headID = $_POST['headID'];
			$_SESSION['mess_dechead'] = HEAD_UPDATED;
		}else{		
			$headID = $objPayroll->addDecHead($_POST);
			$_SESSION['mess_dechead'] = HEAD_ADDED;
		}
		$RedirectURL ="viewDecStructure.php?cat=".$_POST['catID'];
		header("Location:".$RedirectURL);
		exit;
		
	}
	$Status=1;
	if($_GET['edit']>0)
	{
		$arryHead = $objPayroll->getDecHead($_GET['edit'],'','');
		$Status = $arryHead[0]['Status']; 
	}

    require_once("../includes/footer.php"); 
?>

