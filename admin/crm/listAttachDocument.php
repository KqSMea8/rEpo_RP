<?php  $FancyBox=1;
       $HideNavigation=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	
	$ModuleName = "Document";
	$objLead=new lead();
	
	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
	

	$AddUrl = "editDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$ViewUrl = "viewDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	//$AddUrl = "editDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	
		//echo $AddUrl;  exit;
	}else{
	$AddUrl = "editDocument.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	$ViewUrl = "viewDocument.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	}
	
	//$EditUrl = "editDocument.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&curP=".$_GET["curP"];
	$arryDocument=$objLead->ListDocument('',$_GET['parent_type'],$_GET['parentID'],'active',$_GET['sortby'],$_GET['asc']);
	$num=$objLead->numRows();

	$pagerLink=$objPager->getPager($arryDocument,$RecordsPerPage,$_GET['curP']);
	(count($arryDocument)>0)?($arryDocument=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


