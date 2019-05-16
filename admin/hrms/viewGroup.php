<?php  
	include_once("../includes/header.php");

	require_once($Prefix."classes/role.class.php");
	
	$ModuleName = "Role";
	$objRole=new role();
	
	$arryGroup=$objRole->ListRoleGroup('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objRole->numRows();

	$pagerLink=$objPager->getPager($arryGroup,$RecordsPerPage,$_GET['curP']);
	(count($arryGroup)>0)?($arryGroup=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


