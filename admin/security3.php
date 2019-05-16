<?php 
	$NavText=1; $SecurityPage=1;  $InnerPage = 1; $SetFullPage = 1;

	require_once("includes/header.php"); 
	 
	/****************************/		
	if($SecurityArray[0]==3 || $SecurityArray[1]==3 || $SecurityArray[2]==3){ //defined in includes/security.php
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
		 
		if(!empty($_POST['EmailSecurityCode'])){
			$_SESSION['mess_sms']='';

			if(!empty($_SESSION['EmailSecurityCodeTime'])){ //EMAIL_AUTH_EXPIRED	 			
				$TimeDiffMin = round((time() - $_SESSION['EmailSecurityCodeTime'])/60);

				if($TimeDiffMin>5){ //5 minutes
				 	$_SESSION['mess_sms'] = EMAIL_AUTH_EXPIRED.'<br>';
					unset($_SESSION['EmailSecurityCode']);
					unset($_SESSION['EmailSecurityCodeTime']);	
					 
				}
			}

			if($_POST['EmailSecurityCode']==$_SESSION['EmailSecurityCode'] && !empty($_SESSION['EmailSecurityCode'])){
				 if(empty($_SESSION['SecurityValidated'])) $_SESSION['SecurityValidated']='3';
				 else $_SESSION['SecurityValidated'] = $_SESSION['SecurityValidated'].',3';
				 
				 
				header("Location:dashboard.php");
				exit;
			}else{
				$_SESSION['mess_sms'] .= EMAIL_AUTH_FAILED;
				header("Location:security3.php");
				exit;
			}
		}
	}
 
 

	if($SecurityArray[0]==3){ 
		$Step = 1;
		unset($_SESSION['SecurityValidated']);
	}else if($SecurityArray[1]==3){ 
		$Step = 2;
	}else{
		$Step = 3;
	}


 	require_once("includes/footer.php"); 

?>
