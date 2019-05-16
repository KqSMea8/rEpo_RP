<?php
	$ThisPageName = 'addCompany.php';
	require_once("includes/header.php");
	if(!empty($_GET['changepwd_id'])){
	    $changepwd_id = $_GET['changepwd_id'];
		$objUser = new user();
		$oldpwd = $objUser->getUser($_REQUEST['changepwd_id'],$changepwd_id);
		//$oldpwd->password; die(OLD_PASSWORD);
	 		
	if ($_POST) { 
		 
		$data= array('password' => $_POST['Password']);
		if (empty($_POST['OldPassword'])) {
			$_SESSION['mess_conf'] = "Please Enter Old Password.";
		}else if(empty($_POST['Password'])) {
			$_SESSION['mess_conf'] = "Please Enter New Password.";
		} else if (empty($_POST['ConfirmPassword'])) {
			$_SESSION['mess_conf'] = "Please Enter Confirm Password.";
		} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
			$_SESSION['mess_conf'] = "Confirm Password do not match.";
		} else if ($_POST['OldPassword'] != $oldpwd->password) {
			$_SESSION['mess_conf'] = "Wrong Old Password.";
		} else{
			if($objUser->ChangePassword($data,$changepwd_id)){
				$oldpwd->password = $_POST['Password'];					
				$_SESSION['mess_conf'] = "Your Password has been changed successfully.";
			} else{
				$_SESSION['mess_conf'] = "Password Not Updated.";
			}		
	
			}
		header("location: changePassword.php");
		exit;
		
	}
	}
	require_once("includes/footer.php"); 
 ?>
