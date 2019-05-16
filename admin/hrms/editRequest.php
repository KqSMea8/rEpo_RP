<?php
	session_start();
	/**************************************************/
	$ThisPageName = 'viewRequest.php';	$EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();

	$RedirectUrl = "viewRequest.php?curP=".$_GET['curP'];
	$ModuleName = "Request";	

	if($_POST) {
			CleanPost(); 

			if(!empty($_POST["request_subject"]) && !empty($_POST["request_message"])){
			    $objCommon->moveRequest($_POST); 
			}
			$_SESSION['mess_request'] = REQUEST_MOVED;
		
			header("location:".$RedirectUrl);
			exit;		
	}




	if(isset($_GET['req_id']) && $_GET['req_id'] >0){
		$arryRequest = $objCommon->getRequest($_GET['req_id']);
	}
	
	
	if(empty($arryRequest[0]['RequestID']) || $arryRequest[0]['Moved']==1){
		header('location:'.$RedirectUrl);
		exit;
	}

	require_once("../includes/footer.php"); 
?>
