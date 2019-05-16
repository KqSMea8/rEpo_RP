<?php
	require_once("includes/header.php");

	if(!empty($_GET['changepwd_id'])){

	    $changepwd_id = $_GET['changepwd_id'];
		$objUser = new user();

		$oldpwd = $objUser->getUser($_REQUEST['changepwd_id'],$changepwd_id);

		//echo $oldpwd->Password; die('asasasa');
			
	if ($_POST) { 
		print_r($_POST);
		$data= array('Password' =>md5($_POST['Password']));
		if (empty($_POST['OldPassword'])) {
			$_SESSION['mess_conf'] = "Please Enter Old Password.";
		}else if(empty($_POST['Password'])) {
			$_SESSION['mess_conf'] = "Please Enter New Password.";
		} else if (empty($_POST['ConfirmPassword'])) {
			$_SESSION['mess_conf'] = "Please Enter Confirm Password.";
		} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
			$_SESSION['mess_conf'] = "Confirm Password do not match.";
		} else if (md5($_POST['OldPassword']) != $oldpwd->Password) {
			$_SESSION['mess_conf'] = "Wrong Old Password.";
		} else{
			if($objUser->ChangePassword($data,$changepwd_id)){
				$oldpwd->Password = $_POST['Password'];					
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
