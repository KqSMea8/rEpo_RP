<?php
session_start();
require_once("includes/header.php");
 
include_once("includes/header_menu.php");
	

	$_SESSION['SUCC_TITLE'] = PAYMENT;
	$_SESSION['mess_account'] = PAYMENT_DECLINED; 
        $_SESSION['Paymet_Failure'] = "1"; 
        $Cid = isset($_GET['cid'])?base64_decode($_GET['cid']):"";
        if(!empty($Cid)){
	 $objOrder->RemoveCart($Cid);
        }


	header('location: account_succ.php');
	exit;

	
?>