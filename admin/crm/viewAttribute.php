<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/crm.class.php");
	$objCommon=new common();
	$_GET['att'] = (int)$_GET['att'];
	if($_GET['att']>0){	
		$arryAtt=$objCommon->getAllCrmAttribute('',$_GET['att'],'');
		$num=sizeof($arryAtt);

		$arryAttribute=$objCommon->AllAttributes($_GET['att']);
	 }	 
	
	if($_GET['att']==17){
      $ModuleName = "Opportunity Type";
	}else{
	  $ModuleName = $arryAttribute[0]["attribute"];
	}
	require_once("../includes/footer.php");
?>

