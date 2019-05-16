<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	(empty($_GET['ed']))?($_GET['ed']=""):("");		

	$_GET['ed'] = (int)$_GET['ed'];
	
	 if($_GET['ed']>0){	
			$arryAtt=$objCommon->getAttrib('',$_GET['ed'],'');
			$num=sizeof($arryAtt);
	 }	 
	 $arryAttribute=$objCommon->AllAttributes('3,4,5,6,7');  
	 require_once("../includes/footer.php");
?>

