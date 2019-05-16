<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();
	$objPayroll=new payroll();

	$ModuleName = "Head";
	
	$RedirectURL = "viewPayStructure.php";

	(empty($_GET['cat']))?($_GET['cat']=""):("");
	(empty($_GET['catEmp']))?($_GET['catEmp']=""):("");
	$showList='';
	 if($_GET['cat']>0 && $_GET['catEmp']!=''){
	 //if($_GET['cat']>0){
		/*****************************/
		if($_GET['cat']=='1'){	/* Default Entry for Fixed Plan A */
			$arryHead=$objPayroll->getHead('',1,$_GET['catEmp'],'');
			$num=$objPayroll->numRows();
			if($num<=0){
				$_POST['catID'] =  '1';
				$_POST['catEmp'] =  $_GET['catEmp'];
				$_POST['heading'] = 'Basic Salary';
				$_POST['HeadType'] = 'Percentage';
				$_POST['Percentage'] = '40';
				$_POST['Default'] = '1';
				$_POST['Status'] = '1';
				
				$objPayroll->addHead($_POST);
				#header("Location:".$RedirectURL);exit;				
			}
		}		
		/*****************************/

		$arryHead=$objPayroll->ListHead($_GET);
		$num=$objPayroll->numRows();
		$showList=1;
	 }

	$arryPayCategory=$objPayroll->getPayCategory('','');
	$arryEmpCategory = $objCommon->GetEmpCategory();			

	require_once("../includes/footer.php");  
?>



