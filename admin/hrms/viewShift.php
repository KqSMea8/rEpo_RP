<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();

	if($arryCurrentLocation[0]['UseShift']==1){
		$arryShift=$objCommon->getShift('','');
		$num=$objCommon->numRows();
	}else{
		$ErrorMSG = MODULE_INACTIVE_SETTING;
	}

	require_once("../includes/footer.php");
?>


