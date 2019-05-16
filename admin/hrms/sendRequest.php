<?php
	/**************************************************/
	$ThisPageName = 'sendRequest.php'; 
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	
	$RedirectUrl ="sendRequest.php";
	$ModuleName = "Send Request";	
	
	$EmpID = $_SESSION["AdminID"];

	if($_POST) {
			/********************************/
			CleanPost();
			/********************************/

			if(!empty($_POST["request_subject"]) && !empty($_POST["request_message"])){
			
			    $objCommon->addRequest($_POST); 
				$objCommon->sendRequestEmail($_POST); 
			}

			$_SESSION['mess_send_request'] = SEND_EMPLOYE_REQUEST;

		
		
		header("location:".$RedirectUrl);
		exit;		
	}


	require_once("../includes/footer.php"); 
?>
