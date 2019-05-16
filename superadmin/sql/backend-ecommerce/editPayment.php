<?php 
	/**************************************************/
	$ThisPageName = 'viewPayment.php'; $EditPage = 1;
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
                        $PaymentID = isset($_REQUEST['paymentId'])?$_REQUEST['paymentId']:"";	
                        $ModuleTitle = "Edit Payment Method";
                        $ModuleName = 'Payment method';
                        $ListTitle  = 'Payment method';
                        $ListUrl    = "viewPayment.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($PaymentID)) 
                    {
                        $arryPaymentMethod = $objPayment->getPaymentById($PaymentID);
                        $arryPaypalSettingFields = $objPayment->getPaypalPaymentFields($PaymentID);
                        //echo "<pre>";
                        //print_r($arryPaymentMethod);
                        if($arryPaymentMethod[0]['Status'] == "No"){
			$PaymentStatus = "No";
                            }else{
                                    $PaymentStatus = "Yes";
                            }
                    }

			
		 	 
                 if(!empty($_GET['active_id'])){
                    $_SESSION['mess_Payment'] = $ModuleName.STATUS;
                    $objPayment->changePaymentStatus($_REQUEST['active_id']);
                    header("location:".$ListUrl);
                 }
	

                if(!empty($_GET['del_id'])){

                       $_SESSION['mess_Payment'] = $ModuleName.REMOVED;
                       $objPayment->deletePaymentMethod($_GET['del_id']);
                       header("location:".$ListUrl);
                       exit;
               }
		


                if (is_object($objPayment)) {	

                         if ($_POST) {

                            if (!empty($PaymentID)) {
                                    $_SESSION['mess_Payment'] = $ModuleName.UPDATED;
                                    $objPayment->updatePaymentMethod($_POST);
                                    $objPayment->updatePaymentSettingsField($_POST);
                                    header("location:".$ListUrl);
                            } 

                            exit;

                        }
		
                 
}



 require_once("includes/footer.php"); 
 
 
 ?>
