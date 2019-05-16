<?php
$FancyBox=1;
 
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/event.class.php");
require_once($Prefix."classes/group.class.php");
require_once($Prefix."classes/crm.class.php");

$objLead=new lead();
$objGroup=new group();
$objCommon=new common();
$objActivity=new activity();
$objRegion=new region();
$objEmployee=new employee();

	if($_POST){
		/*******************/
		$description = $_POST['description'];
		CleanPost(); 
		$_POST['description'] = $description;
		/*******************/

		$objActivity->AddActivity($_POST);
		header("location:calender.php?module=calender");
		exit;
	}
$_GET['Status']=1;$_GET['Division']=5;
$arryEmployee = $objEmployee->GetEmployeeList($_GET);
$arryGroup = $objGroup->getGroup("",1);

$arryActivityStatus = $objCommon->GetCrmAttribute('ActivityStatus', '');
$arryActivityType = $objCommon->GetCrmAttribute('ActivityType', '');
require_once("../includes/footer.php"); 
?>






