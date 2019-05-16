<?php 
	/**************************************************/
	//$ThisPageName = 'viewPayment.php'; 
         $EditPage = 1;
	/**************************************************/
 	include_once("includes/header.php");
         
	require_once("classes/payment.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
             if (class_exists(payment)) {
	  	$objPayment=new payment();
	} else {
  		echo "Class Not Found Error !! Payment Class Not Found !";
		exit;
  	}
                       
                        $ModuleTitle = "Payment Configuration";
                        $ListUrl    = "viewPayment.php?curP=".$_GET['curP'];
               
                        $arryPaymentMethods = $objPayment->getPaymentMethods();
                        



 require_once("includes/footer.php"); 
 
 
 ?>
