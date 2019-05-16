<?php $HideNavigation = 1;

	require_once("includes/header.php");
	require_once(_ROOT."/classes/dbfunction.class.php");
 	require_once(_ROOT."/classes/customer.supplier.class.php"); 
 	$objCustomerSupplier= new CustomerSupplier();
	if (!empty($_POST)) {
		CleanPost();		
		$custId=$_POST['custId'];
		$custloginId=$_POST['custloginId'];
		if(empty($_POST['Password'])) {
			$_SESSION['mess_conf'] = ENTER_NEW_PASSWORD;
		} else if (empty($_POST['ConfirmPassword'])) {
			$_SESSION['mess_conf'] = ENTER_CONFIRM_PASSWORD;
		} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
			$_SESSION['mess_conf'] = CONFIRM_PASSWORD_NOT_MATCH;
		} elseif(empty($custId) OR empty($custloginId)){
			$_SESSION['mess_conf']='Some Technical Problem';
		}else{
			

			
			 
				/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/	
			
				if($objCustomerSupplier->ChangePassword($_SESSION['CmpID'],$custloginId,$custId,$_POST['Password'])){
					$_SESSION['mess_conf'] = PASSWORD_CHANGED;
				} else{
					$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED; 
				}			

		}
		$qq=$_SERVER['QUERY_STRING'];
		header("location: chCustomerVendorPass.php?".$qq);
		exit;
		
	}
	

	require_once("includes/footer.php"); 
 ?>
