<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'Request Password '; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;
include ('includes/header.php');

IsCrmSession();
	require_once("../../classes/rsl.class.php");

	$objReseller=new rs();

	if($_POST) { 

		if (empty($_POST['Email'])) {
			$_SESSION['mess_forgot'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objReseller->CheckResellerEmail($Email); 

			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['RsID']); 
	

			if(empty($mess) && $CmpID>0){  // Admin 

				/********Connecting to main database*********/
				$UserType = "admin";				
				/*******************************************/
				if($objReseller->ForgotPassword($Email,$CmpID)){
					$_SESSION['mess_forgot'] = FORGOT_SUCC;
					$ValidLogin = 1;
				} else{
					$_SESSION['mess_forgot'] = INVALID_EMAIL; 
				}	
			}else{
				$_SESSION['mess_forgot'] = INVALID_EMAIL; 
			}

		}

		
	}

include ('includes/footer.php');


 ?>