<?php
	require_once("includes/header.php");
	if(!empty($_GET['changepwd_id'])){
	    $changepwd_id = $_GET['changepwd_id'];
		$objUser = new company();
		//$oldpwd = $objUser->getUser($_REQUEST['changepwd_id'],$changepwd_id);
		//$oldpwd->password; die(OLD_PASSWORD);
			//echo $changepwd_id;
	if (isset($_POST['Submit'])) {
		$changepwd_id = $_GET['changepwd_id'];
		//echo $changepwd_id;
		//print_r($_POST);
		$data= md5($_POST['Password']);
		
	 $pass =$objUser->ChangePassword($data,$changepwd_id);
//echo 'asasasa'.$pass;
			if($pass!=0){
				//$oldpwd->password = $_POST['Password'];					
				$_SESSION['mess_conf'] = "Your Password has been changed successfully.";
			} else{
				$_SESSION['mess_conf'] = "Password Not Updated.";
			}		
	
			
		header("location: changePassword.php");
		exit;
		
	}
	}
	require_once("includes/footer.php"); 
 ?>
