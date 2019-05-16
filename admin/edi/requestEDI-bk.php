<?php
include_once("../includes/header.php");
require_once($Prefix."classes/edi.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/supplier.class.php");


$ediObj=new edi();
 
 if(empty($_GET['mod'])){ $_GET['mod'] ='';}
if (is_object($ediObj)) {
	
	$arryCompanies = array();
	if(!empty($_GET['module'])){
		 
		$arryCompanies=$ediObj->getEDICompaniesByStatus($_GET['module']);
		$num=count($arryCompanies);
		$ListUrl    = "requestEDI.php?module=".$_GET['module'];
		 
	}else if(isset($_POST['search_str']) && $_POST["search_str"] != '') {
		 
		$arryCompanies=$ediObj->getEDICompanies($_POST['search_str']);
		$num=count($arryCompanies);
		$ListUrl    = "requestEDI.php";
	}
	
	
	
	$ModuleName = 'Request For EDI ';
	if(!empty($_POST['request_CmpID']) && $_POST['mod']=='Request' ){
	
	
		$ListUrl    = "requestEDI.php"; 
		$_SESSION['mess_Page'] = $ModuleName.' Request Send Successfully.';
		$ediObj->sendRequestforedi($_POST);
		header("location:".$ListUrl);
		exit;
		 
	}
	if($_GET['mod']=='Reject' ){
	
	$_POST['mod'] = $_GET['mod'];
	$_POST['request_CmpID'] = $_GET['ID'];
		$ListUrl    = "requestEDI.php"; 
		$_SESSION['mess_Page'] = $ModuleName.' '.$_POST['mod'].' Successfully.';
		$ediObj->acceptrejectEDI($_POST);
		header("location:".$ListUrl);
		exit;
		 
	}
	if(!empty($_POST['request_CmpID']) && $_POST['mod']=='Accept' ){
	
	
		$ListUrl    = "requestEDI.php"; 
		$_SESSION['mess_Page'] = $ModuleName.' '.$_POST['mod'].' Successfully.';
		$ediObj->acceptrejectEDI($_POST);
		header("location:".$ListUrl);
		exit;
		 
	}

}

require_once("../includes/footer.php");

?>
