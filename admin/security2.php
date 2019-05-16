<?php 
	$NavText=1; $SecurityPage=1;  $InnerPage = 1; $SetFullPage = 1;

	require_once("includes/header.php"); 
	require_once ("../classes/GoogleAuthenticator.class.php"); 
	require_once("../classes/user.class.php");	
	$ga = new PHPGangsta_GoogleAuthenticator();
	$objUser=new user();
	/****************************/		
	if($SecurityArray[0]==2 || $SecurityArray[1]==2){ //defined in includes/security.php
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
		 
		if(!empty($_POST['Barcode'])){
			 
			if($ga->verifyCode($_POST['secret'], $_POST['Barcode'], 2)){
 
				 /***************/
				 $objUser->UpdateAuthSecretKey($_POST['secret']);		
				 /***************/

				 if(empty($_SESSION['SecurityValidated'])) $_SESSION['SecurityValidated']='2';
				 else $_SESSION['SecurityValidated'] = $_SESSION['SecurityValidated'].',2';
				
				if(in_array(3,$SecurityArray)){
					$SecurityPageUrl = "security3.php";	
					header("location: ".$MainPrefix.$SecurityPageUrl);
					exit;
				}else{
					header("Location:dashboard.php");
					exit;
				}
			}else{
				$_SESSION['mess_Barcode'] = GOOGLE_AUTH_FAILED;
				header("Location:security2.php");
				exit;
			}
		}
	}
 
 
	/*************/
	if($_SESSION['AdminType'] == "admin"){ 
		$AuthSecretKey = $arryCompany[0]['AuthSecretKey'];
		$ToEmail = $_SESSION['AdminEmail'];
	}else{
		$AuthSecretKey = $ArryEmployeeBasic[0]['AuthSecretKey'];
		$ToEmail = $_SESSION['EmpEmail'];
	}

	if(empty($AuthSecretKey)){
		$secret = $ga->createSecret();
	}else{
		$secret = $AuthSecretKey;
	}
 
	$qrCodeUrl = $ga->getQRCodeGoogleUrl($ToEmail, $secret,"eZnet ERP");
	$oneCode = $ga->getCode($secret);
	/*************/
	

	if($SecurityArray[0]==2){ 
		$Step = 1;
		unset($_SESSION['SecurityValidated']);
	}else{
		$Step = 2;
	}

 	require_once("includes/footer.php"); 

?>
