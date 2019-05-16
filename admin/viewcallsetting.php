<?php 
	include_once("includes/header.php");
	//ini_set('display_errors',1);
	//require_once("define.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objphone=new phone();
	
	$callSetting = $objphone->GetcallSetting();
	$num=count($callSetting);	 
	
	if(!empty($_REQUEST['del_id'])){
		$del_group_msg= $objphone->DeleteGroup($_REQUEST['del_id']);
		$_SESSION['mess_call']=$del_group_msg;
		header('Location: viewcallsetting.php');
		exit;
		
	}

	require_once("includes/footer.php");	


	
?>



