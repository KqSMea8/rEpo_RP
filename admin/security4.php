<?php 
	$NavText=1; $SecurityPage=1;  $InnerPage = 1; $SetFullPage = 1;

	require_once("includes/header.php"); 
	 
	/****************************/		
	if($SecurityArray[0]==3 || $SecurityArray[1]==3 || $SecurityArray[2]==3 || $SecurityArray[3]==3){ //defined in includes/security.php
		//ok 
	}else{
		header("Location:dashboard.php");
		exit;
	}

	if($_SESSION['SecurityValidated'] == $CompanySecurityAllow){
		header("Location:dashboard.php");
		exit;
	}
	/****************************/	
	        
	 if($_POST){
		 
		if(!empty($_POST['SecurityCode'])){			 
			if($_POST['SecurityCode']==$_SESSION['SecurityCode']){
				 if(empty($_SESSION['SecurityValidated'])) $_SESSION['SecurityValidated']='4';
				 else $_SESSION['SecurityValidated'] = $_SESSION['SecurityValidated'].',4';
				 
				 
				header("Location:dashboard.php");
				exit;
			}else{
				$_SESSION['mess_sms'] = SMS_AUTH_FAILED;
				header("Location:security4.php");
				exit;
			}
		}
	}
 
 

	if($SecurityArray[0]==3){ 
		$Step = 1;
		unset($_SESSION['SecurityValidated']);
	}else if($SecurityArray[1]==3){ 
		$Step = 2;
	}else if($SecurityArray[2]==3){ 
		$Step = 3;
	}else{
		$Step = 4;
	}


	/********************/
	unset($_SESSION['SecurityCode']);
	unset($_SESSION['SecurityCodeTime']);
	$Number = rand(100,10000);
	$_SESSION['SecurityCode'] = substr(md5($Number),0,10);
	$_SESSION['SecurityCodeTime'] = time();	
	/********************/

 	require_once("includes/footer.php"); 

?>
