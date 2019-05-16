<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	$objPayroll=new payroll();

	$ModuleName = "Head";
	
	$RedirectURL ="viewDecStructure.php";

	if($_GET['cat']>0){
		$arryHead=$objPayroll->ListDecHead('',$_GET['cat'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num=$objPayroll->numRows();
	}

	$arryDecCategory=$objPayroll->getDecCategory('','');

	require_once("../includes/footer.php");  
?>



