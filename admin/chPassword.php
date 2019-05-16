<?php $HideNavigation = 1;
	require_once("includes/header.php");

	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	$objEmployee=new employee();
	$objUser=new user();
	
	if ($_POST) {
		CleanPost();

		if (empty($_POST['OldPassword'])) {
			$_SESSION['mess_conf'] = ENTER_OLD_PASSWORD;
		}else if(empty($_POST['Password'])) {
			$_SESSION['mess_conf'] = ENTER_NEW_PASSWORD;
		} else if (empty($_POST['ConfirmPassword'])) {
			$_SESSION['mess_conf'] = ENTER_CONFIRM_PASSWORD;
		} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
			$_SESSION['mess_conf'] = CONFIRM_PASSWORD_NOT_MATCH;
		} else if (md5($_POST['OldPassword']) != $_SESSION['AdminPassword']) {
			$_SESSION['mess_conf'] = WRONG_OLD_PASSWORD;
		} else{

			if($_SESSION['AdminType']=="admin"){  // Admin 
			 
				/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/
				if($objCompany->ChangePassword($_SESSION['AdminID'],$_POST['Password'])){
					$_SESSION['AdminPassword'] = md5($_POST['Password']);					
					$_SESSION['mess_conf'] = PASSWORD_CHANGED;
				} else{
					$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED; 
				}	
			}else if($_SESSION['AdminType']=="employee"){  // Employee 
				/********Connecting to main database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/
				if($objEmployee->ChangePassword($_SESSION['AdminID'],$_POST['Password'])){

					$objUser->ChangePassword($_SESSION['UserID'],$_POST['Password']);

					$_SESSION['AdminPassword'] = md5($_POST['Password']);					
					$_SESSION['mess_conf'] = PASSWORD_CHANGED;
				} else{
					$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED; 
				}	
			}else{
				$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED; 
			}

		}

		header("location: chPassword.php");
		exit;
		
	}

	require_once("includes/footer.php"); 
 ?>
