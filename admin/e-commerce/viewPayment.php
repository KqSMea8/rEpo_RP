<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/payment.class.php");
        
	  $objPayment=new payment();
          $ModuleName = "Manage Payment Methods";
	  
	 if (is_object($objPayment)) {
                    $arryPaymentMethods=$objPayment->getPaymentCofigureMethods();
                    $num=$objPayment->numRows();

                          }
  
  require_once("../includes/footer.php");
  
?>
