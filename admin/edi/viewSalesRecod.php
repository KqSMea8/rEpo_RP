<?php
include_once("../includes/header.php");
require_once($Prefix."classes/edi.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require_once($Prefix."classes/supplier.class.php");


$ediObj=new edi();

$module = $_GET['module'];
	$ModuleDepName="edi";
	$ModuleName = $_GET['module'];
	
	if($_GET['module']=='SO'){	
		$ModuleIDTitle = "SO Number"; $ModuleID = "SalesID"; $NameAgent = "Vendor";
	}elseif($_GET['module']=='PO'){	
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $NameAgent = "Customer";
	}else{
		$ModuleIDTitle = "SO Number"; $ModuleID = "SalesID";
	}
 
if (is_object($ediObj)) {
	
	$arryCompanies = array();
	if(!empty($_GET['module'])){
		 
		$arryCompanies=$ediObj->GetRequestList($_GET);
	
		
		$num=count($arryCompanies);
		$ListUrl    = "requestEDI.php?module=".$_GET['module'];
		 
	}
	
	

	
	
}

require_once("../includes/footer.php");

?>
