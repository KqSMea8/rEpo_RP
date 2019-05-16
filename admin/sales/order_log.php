<?php 
	/**************************************************/
	//$ThisPageName = 'viewSalesQuoteOrder.php'; $EditPage = 1;  //$SetFullPage = 1;
	/**************************************************/
if(!empty($_GET['OrderID'])){
	$OrderID = $_GET['OrderID'];
	$HideNavigation = 1;
}else{
	$OrderID ='';	
}

include_once("../includes/header.php");
$module = 'SalesOrder';
$objAdmin = new admin();

	/*********************Delete Row start **********************/
				
				
				if(!empty($_POST['logID'])){
					$objAdmin->deleteLogs($_POST['logID']);
					$_SESSION['mess_profile'] = "Log has been deleted.";
					
				}
		
				/******Get Log Records***********/
				$RecordsPerPage = 10;
				
				if(!empty($_GET['module'])) $module = $_GET['module'];
				
				$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;	
				$Config['RecordsPerPage'] = $RecordsPerPage;

				$arryUserProfileLog=$objAdmin->GetLogs($module, $OrderID);


				/**********Count Records**************/
				$Config['GetNumRecords'] = 1;
				$arryCount=$objAdmin->GetLogs($module, $OrderID);
				$num=$arryCount[0]['NumCount'];	
				$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
				/*************************************/
	
	require_once("../includes/footer.php"); 	 
?>


