<?php

$FancyBox=1;
$ThisPageName = 'callAddGroup.php';
require_once("../../define.php");
require_once("../includes/header.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/dbfunction.class.php");
//ini_set('display_errors',1);
require_once($Prefix."classes/phone.class.php");
$objphone=new phone();

$callSetting = $objphone->GetcallSetting();

if(count($callSetting)>0){
	header('Location: employeeConnect.php');
	exit;
}


if($_POST){
		CleanPost(); 
		$addfolder_response = $objphone->CreateGroup($_POST['name']);
		$_SESSION['mess_phone']=$addfolder_response;
		header('Location: employeeConnect.php');
		exit;

}



require_once("../includes/footer.php"); 
?>






