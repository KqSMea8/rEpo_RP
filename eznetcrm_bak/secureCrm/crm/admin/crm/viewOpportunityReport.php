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

		$arryOpportunity=$objLead->OpportunityReport($_GET);

		//echo "<pre>";
		//print_r($arryOpportunity);

		$num=$objLead->numRows();

		$pagerLink=$objPager->getPager($arryOpportunity,$RecordsPerPage,$_GET['curP']);
		(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");

		$ShowData = 1;
	}
	/*************************/
	$arryOpportunityValue = $objLead->GetOpportunity($_GET['edit'],'');
	
	
	$arryDepartment = $objConfigure->GetDepartment();
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus','');
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	$arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry','');
	$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');	
	$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');
	require_once("../includes/footer.php"); 	
?>


