<?php 
	$NavText=1; $SecurityPage=1;  $InnerPage = 1; $SetFullPage = 1;

	require_once("includes/header.php"); 
	require_once($Prefix."classes/hrms.class.php");
	require_once("../classes/question.class.php");
	$objCommon=new common();
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

	if(!$questionObj->IsSecurityProfileExist()){
		header("Location:security_profile.php");
		exit;
	}
	/****************************/					
	if($_POST){ 
		CleanPost(); 
		$Validated=0;
		for($i=1;$i<=$_POST['NumLine'];$i++){
			$QuestionID = $_POST['QuestionID'.$i];
			$Answer = $_POST['Answer'.$i];
			if($QuestionID>0 && !empty($Answer)){
				if($questionObj->ValidateAnswer($QuestionID,$Answer)){
					$Validated=1;
				}else{
					$Validated=0;
					break;
				}
			}
		}
		 
		if($Validated==1){
			$_SESSION['SecurityValidated']='1';
			if(!empty($SecurityArray[1])){
				$SecurityPageUrl = "security".$SecurityArray[1].'.php';	
				header("location: ".$MainPrefix.$SecurityPageUrl);
				exit;
			}else{
				header("Location:dashboard.php");
				exit;
			}			
		}else{
			$_SESSION['mess_question'] = AUTHENTICATION_FAILED;
			header("Location:security1.php");
			exit;
		} 
		
		
	}
			

	unset($_SESSION['SecurityValidated']);
	 
	/****************************/		 
	$arryQuestion = $questionObj->GetSecurityQuestionRandom();
	$numQuestion = sizeof($arryQuestion);
	if(empty($numQuestion)){
		$_SESSION['SecurityValidated']=$CompanySecurityAllow;
		header("location: dashboard.php");
		exit;
	}
	$arryBloodGroup = $objCommon->GetFixedAttribute('BloodGroup','');
	$arryUnderGraduate = $objCommon->GetAttribValue('UnderGraduate','');
	$arryImmigrationType = $objCommon->GetFixedAttribute('ImmigrationType','');
	/****************************/	
	require_once("includes/footer.php"); 
?>
