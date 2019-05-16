<?php
	/**************************************************/
	$ThisPageName = 'viewShift.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	
	$ModuleName = "Shift";
	
	$RedirectUrl = "viewShift.php?curP=".$_GET['curP'];
	$EditUrl = "editShift.php?edit=".$_GET['view']."&curP=".$_GET['curP'];
	if($_GET['view']>0){
		$arryShift = $objCommon->getShift($_GET['view'],'');		
	}
 
	
	require_once("../includes/footer.php"); 
  ?>
