<?php 
	/**************************************************/
	//$ThisPageName = 'viewPayment.php'; 
         $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/payment.class.php");
	
 
       $objPayment=new payment();         
	$ModuleTitle = "Payment Configuration";
	$ListUrl    = "viewPayment.php?curP=".$_GET['curP'];

	$arryPaymentMethods = $objPayment->getPaymentMethods();
                        



 require_once("../includes/footer.php"); 
 
 
 ?>
