<?php  $FancyBox=1;
	include_once("../includes/header.php");
	include_once("language/en_lead.php");
    require_once($Prefix."classes/field.class.php");

	$_GET['mod'] = (isset($_GET['mod'])) ? (int)$_GET['mod'] : '';
	$_GET['head'] = (isset($_GET['head'])) ? (int)$_GET['head'] : '';

	$ModuleName = " custom field from CRM Setting"; //By chetan 13july//
	$RedirectURL = "CrmSetting.php?curP=".$_GET['curP']."&head=".$_GET['head']."&mod=".$_GET["mod"];
    
	$objField=new field();
	if($_GET['mod']>0){	
		$arryAtt=$objField->getAllCrmHead('',$_GET['mod'],'');
		$num=sizeof($arryAtt);
	 }	 
	

	if($_GET['head']>0){
	$arryField = $objField->getFormField('',$_GET['head'],'');
	$num=$objField->numRows();

	$pagerLink=$objPager->getPager($arryField,$RecordsPerPage,$_GET['curP']);
	(count($arryField)>0)?($arryField=$objPager->getPageRecords()):("");
	}

	 if(isset($_GET['display']) && !empty($_GET['display'])){
		$_SESSION['mess_field'] = FIELD_DISPLAY;
		$objField->changeFormFieldStatus($_GET['display']);
		header("Location:".$RedirectURL);
	}
	 if(isset($_GET['mand']) && !empty($_GET['mand'])){
		$_SESSION['mess_field'] = FIELD_DISPLAY;
		$objField->changeFieldMandatory($_GET['mand']);
		header("Location:".$RedirectURL);
	}


	require_once("../includes/footer.php"); 	 
?>


