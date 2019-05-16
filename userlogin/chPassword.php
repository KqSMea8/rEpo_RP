<?php $HideNavigation = 1;
	require_once("includes/header.php");

	require_once(_ROOT."/classes/dbfunction.class.php");
 	require_once(_ROOT."/classes/customer.supplier.class.php"); 
 	$objCustomerSupplier= new CustomerSupplier();
	//print_r($_SESSION);
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
		} else if (md5($_POST['OldPassword']) != $_SESSION['UserPassword']) {
			$_SESSION['mess_conf'] = WRONG_OLD_PASSWORD;
		} else{

			if($_SESSION['UserType']=="customer" OR $_SESSION['UserType']=="vendor"){  // Admin 
			 
				/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();				
				/*******************************************/
				if($objCustomerSupplier->CheckUserPassword($_SESSION['UserName'],$_POST['Password'])){
					if($objCustomerSupplier->ChangePassword($_SESSION['CmpID'],$_SESSION['UserID'],$_SESSION['ref_id'],$_POST['Password'])){
						$_SESSION['UserPassword'] = md5($_POST['Password']);					
						$_SESSION['mess_conf'] = PASSWORD_CHANGED;
					} else{
						$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED; 
					}	
				}else{
					$_SESSION['mess_conf'] = 'This Password Already Used To Other Account'; 
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
