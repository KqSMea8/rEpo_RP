<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
        require_once($Prefix."classes/region.class.php");
		require_once($Prefix."classes/employee.class.php");
		require_once($Prefix."classes/crm.class.php");
	
	$objLead=new lead();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCommon=new common();
	/*************************/
	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){

		$arryLead=$objLead->LearReportByTerritory($_GET);

		$num=$objLead->numRows();

		$pagerLink=$objPager->getPager($arryLead,$RecordsPerPage,$_GET['curP']);
		(count($arryLead)>0)?($arryLead=$objPager->getPageRecords()):("");

		$ShowData = 1;
		//$MainModuleName="Sales Person Wise Rating  Reports";
	}
	/*************************/
//	$arryLeadValue = $objLead->GetLead($_GET['edit'],'');
	
	//$arryDepartment = $objConfigure->GetDepartment();
	//$arryEmployee = $objEmployee->GetEmployeeBrief('');
	//$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
	//$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	//$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry','');
	//$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');		
	require_once("../includes/footer.php"); 	
?>



