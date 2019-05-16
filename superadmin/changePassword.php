<?php
	require_once("includes/header.php");



	if ($_POST) {
		if (empty($_POST['OldPassword'])) {
			$_SESSION['mess_conf'] = "Please Enter Old Password.";
		}else if(empty($_POST['Password'])) {
			$_SESSION['mess_conf'] = "Please Enter New Password.";
		} else if (empty($_POST['ConfirmPassword'])) {
			$_SESSION['mess_conf'] = "Please Enter Confirm Password.";
		} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
			$_SESSION['mess_conf'] = "Confirm Password do not match.";
		} else if (md5($_POST['OldPassword']) != $_SESSION['AdminPassword']) {
			$_SESSION['mess_conf'] = "Wrong Old Password.";
		} else{
			if($objConfig->ChangePassword($_SESSION['AdminID'],$_POST['Password'])){
				$_SESSION['AdminPassword'] = md5($_POST['Password']);					
				$_SESSION['mess_conf'] = "Your Password has been changed successfully.";
			} else{
				$_SESSION['mess_conf'] = "Password Not Updated.";
			}		
	}

		header("location: changePassword.php");
		exit;
		
	}

	require_once("includes/footer.php"); 
 ?>
