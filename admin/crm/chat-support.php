<?php 	/**************************************************/
	$ThisPageName = 'chat-support.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");	
	require_once($Prefix."classes/user.class.php");
	$ModuleName = "Chat Support";
	$objEmployee=new employee();
	$objUser=new user();
		/*************************/
			$arryEmployee=$objEmployee->ListEmployee($_GET);
		
			$num=$objEmployee->numRows();
		
			$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
			(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
		/*************************/
	
	?>
<?php require_once("../includes/footer.php"); 	
?>
