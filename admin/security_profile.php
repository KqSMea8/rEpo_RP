<?php   
	$NavText=1; $SecurityPage=1;  $InnerPage = 1; $SetFullPage = 1;

	require_once("includes/header.php"); 
	//require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/question.class.php");
	//$objCommon=new common();
	$questionObj=new question();			

	/****************************/	
	if($SecurityArray[0]!=1){ //defined in includes/security.php
		header("Location:dashboard.php");
		exit;
	}
 
	if($_SESSION['SecurityValidated'] == $CompanySecurityAllow){
		header("Location:dashboard.php");
		exit;
	} 
	if($questionObj->IsSecurityProfileExist()){
		header("Location:security1.php");
		exit;
	}
	/****************************/					
	if($_POST){ 
		CleanPost(); 
		$questionObj->AddUpdateSecurityProfile($_POST);	
		$_SESSION['mess_question'] = SECURE_PROFILE_SAVED;
		header("Location:security_profile.php");
		exit;
	}
			

	unset($_SESSION['SecurityValidated']);
	 
	/****************************/		 
	$arryQuestion = $questionObj->GetSecurityQuestionRandom();
	$numQuestion = sizeof($arryQuestion);
	if($numQuestion<5){
		$MaxQuestion = $numQuestion;
	}else{
		$MaxQuestion = 5;
	}

	if(empty($numQuestion)){
		$_SESSION['SecurityValidated']=$CompanySecurityAllow;
		header("location: dashboard.php");
		exit;
	}
	/****************************/	
	require_once("includes/footer.php"); 
?>
