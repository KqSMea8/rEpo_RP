<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
	$objBankAccount = new BankAccount();
	$ModuleName = "PO/SO Comments";
		
		if($_SESSION['AdminType']=='admin'){
			$user_id = $_SESSION['AdminID'];
		}else{
			$user_id = $_SESSION['AdminID'];
		}
		
		$arryComments=$objBankAccount->getMasterComment($user_id,'','');
		$num=sizeof($arryComments);

	require_once("../includes/footer.php");
?>

