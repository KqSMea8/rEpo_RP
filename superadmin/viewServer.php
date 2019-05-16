<?php  
	include_once("includes/header.php");
	require_once("../classes/server.class.php");
	$Config['StartPage']=0;
	$Config['RecordsPerPage'] = $RecordsPerPage;
	
	//$ThisPageName='viewServer.php';
	

   //echo '<pre>';print_r($Config);die;
	$objServer = new server();
	$arryServer=$objServer->ListServer();
    //echo '<pre>';print_r($arryServer);die;
	//$pagerLink=$objPager->getPaging((int)$arryServer[0]['TOTAL_RECORD'],$RecordsPerPage,$_GET['curP']);		

	require_once("includes/footer.php"); 	 
?>


