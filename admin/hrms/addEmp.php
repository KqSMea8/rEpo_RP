<?php 
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; $EditPage = 1; $HideNavigation = 1;
	/**************************************************/

	include_once("../includes/header.php");

	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objCommon=new common();

	$objEmployee=new employee();
	$objUser=new user();

	$ModuleName = "Employee";
	$RedirectURL = "viewEmployee.php?curP=".$_GET['curP'];
	
	
    	if($_POST) {
		CleanPost();
		/*************************/
		$ValidateData = array(  
			array("name" => "EmpCode", "label" => "Employee Code" , "opt" => "1" ,"type" => "unique"),
			array("name" => "FirstName", "label" => "First Name" , "min" => "3"),			
			array("name" => "Email", "label" => "Email" , "type" => "email"),
			array("name" => "Password", "label" => "Password", "min" => "5"),
			array("name" => "ConfirmPassword", "label" => "Confirm Password")			
		);		

		$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);

		if(!empty($_POST['Password']) && $_POST['Password']!=$_POST['ConfirmPassword']){
			$ValidateErrorMsg .= '<br>'.CONFIRM_PASSWORD_NOT_MATCH;
		}

		if(!empty($ValidateErrorMsg)){
			$_SESSION['mess_emp'] = $ValidateErrorMsg;
			$ActionUrl = 'addEmp.php';			
			header("Location:".$ActionUrl);
			exit;
		}
		/*************************/

			$_POST['Email'] = strtolower($_POST['Email']);

			 

			 if(empty($_POST['Email']) && empty($_POST['EmpID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
					if($objEmployee->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_employee'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objEmployee->AddEmployee($_POST); 

						/****** Add To User Table******/
						/*******************************/
						$_POST['UserName'] = trim($_POST['FirstName'].' '.$_POST['LastName']);
						$_POST['UserType'] = "employee";
						$UserID = $objUser->AddUser($_POST);
						$objEmployee->query("update h_employee set UserID=".$UserID." where EmpID=".$LastInsertId, 0);
						$_POST['UserID'] = $UserID;
						/*******************************/
						/*******************************/

						$_SESSION['mess_employee'] = EMP_ADDED;
						//$RedirectURL = "editEmployee.php?edit=".$LastInsertId;

					}
				
				//header("Location:".$RedirectURL);
				echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;				
			}
		}
		


	/*******************************
	$arryNumEmp = $objEmployee->CountEmployee();
	if($arryNumEmp[0]['TotalEmployee']>=$MaxAllowedUser){
		$errMsg = LIMIT_USER_REACHED.$MaxAllowedUser;
		$HideForm = 1;
	}
	/*******************************/
	$arryJobTitle = $objCommon->GetAttributeValue('JobTitle','attribute_value');
	$arryJobType = $objCommon->GetAttributeValue('JobType','');
	$arryEmpCategory = $objCommon->GetEmpCategory();			
	require_once("../includes/footer.php"); 	 
?>


