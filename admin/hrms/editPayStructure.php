<?php
	/**************************************************/
	$ThisPageName = 'viewPayStructure.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objPayroll=new payroll();

	$ModuleName = "Head";
	$RedirectURL ="viewPayStructure.php?cat=".$_GET['cat']."&catEmp=".$_GET['catEmp'];

	if(empty($_GET['cat'])){
		header("location: viewPayStructure.php");
		exit;
	}

	$arryPayCategory = $objPayroll->getPayCategory($_GET['cat'],'');
	$PayCategory = $arryPayCategory[0]['catName'];

	$arryEmpCategory = $objCommon->GetEmpCategoryName($_GET['catEmp']);
	$EmpCategory = $arryEmpCategory[0]['catName'];
	if($_GET['catEmp']==0){
		$EmpCategory = 'Other';
	}


	if(empty($PayCategory) || empty($EmpCategory)){
		header("location: viewPayStructure.php");
		exit;
	}
	/*************************/


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_payhead'] = HEAD_REMOVED;
		$objPayroll->deleteHead($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_payhead'] = HEAD_STATUS_CHANGED;
		$objPayroll->changeHeadStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['headID'])) {
			$objPayroll->updateHead($_POST);
			$headID = $_POST['headID'];
			$_SESSION['mess_payhead'] = HEAD_UPDATED;
		}else{		
			$headID = $objPayroll->addHead($_POST);
			$_SESSION['mess_payhead'] = HEAD_ADDED;
		}
		$RedirectURL ="viewPayStructure.php?cat=".$_POST['catID']."&catEmp=".$_POST['catEmp'];
		header("Location:".$RedirectURL);
		exit;
		
	}
	$Status=1;
	if($_GET['edit']>0)
	{
		$arryHead = $objPayroll->getHead($_GET['edit'],'','','');
		$PageHeading = 'Edit Payroll Structure for Heading: '.stripslashes($arryHead[0]['heading']);
		$Status = $arryHead[0]['Status']; 
	}
	$arryDefaultHead = $objPayroll->getDefaultHead('',1,$_GET['catEmp'],'');
	$BasicTitle = stripslashes($arryDefaultHead[0]['heading']);




	$arryHeadType = $objCommon->GetFixedAttribute('HeadType','');

    require_once("../includes/footer.php"); 
?>

