<?php 
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
    require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");
	$ModuleName = "Company";
	$objphone = new phone();
	if(!empty($_REQUEST['del_id'])){
	  $objphone->DeleteServer($_REQUEST['del_id']);
	  header('Location: callServerList.php');
	  exit;
	}
	
	
	
    $callServer = $objphone->ListServer();

	//echo "<pre>";print_r($callServer);die;
	
	//ini_set('display_errors',1);
	$num =count($callServer);
	$pagerLink=$objPager->getPager($callServer,$RecordsPerPage,$_GET['curP']);
	(count($callServer)>0)?($callServer=$objPager->getPageRecords()):("");


	require_once("includes/footer.php"); 

?>


