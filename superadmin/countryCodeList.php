<?php 

     $ThisPageName = 'callServerList.php'; 

	include_once("includes/header.php");
	require_once("../classes/company.class.php");
    require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");
	$ModuleName = "Company";
	$objphone = new phone();
		(empty($_GET['ch']))?($_GET['ch']='A'):(""); 


	if(!empty($_GET['del_id'])){
	  $objphone->DeleteServer($_GET['del_id']);
	  header('Location: callServerList.php');
	  exit;
	}
	
	$data = array();
 
	$data['name'] =  $_GET['ch'];
    $CountryCode = $objphone->ListCountryCode($data,'search');

	//echo "<pre>";print_r($CountryCode );die;
	
	//ini_set('display_errors',1);
	$num =count($CountryCode);
	$pagerLink=$objPager->getPager($CountryCode,$RecordsPerPage,$_GET['curP']);
	(count($CountryCode)>0)?($CountryCode=$objPager->getPageRecords()):("");


	require_once("includes/footer.php"); 

?>


