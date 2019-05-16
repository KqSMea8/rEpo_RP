<?php 
	/**************************************************/
	$ThisPageName = 'viewPayment.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/payment.class.php");
	
 	$objPayment=new payment();

                $PaymentID = isset($_GET['paymentId'])?$_GET['paymentId']:"";	
                $ModuleTitle = "Edit Payment Method";
                $ModuleName = 'Payment method';
                $ListTitle  = 'Payment method';
                $ListUrl    = "viewPayment.php?curP=".$_GET['curP'];
                       
               

			
		 	 
                 if(!empty($_GET['active_id'])){
                    $_SESSION['mess_Payment'] = $ModuleName.STATUS;
                    $objPayment->changePaymentStatus($_REQUEST['active_id']);
                    header("location:".$ListUrl);
			exit;
                 }
	

               /* if(!empty($_GET['del_id'])){

                       $_SESSION['mess_Payment'] = $ModuleName.REMOVED;
                       $objPayment->deletePaymentMethod($_GET['del_id']);
                       header("location:".$ListUrl);
                       exit;
               }*/
		


               

                         if ($_POST) {

                            if (!empty($PaymentID)) {
                                    $_SESSION['mess_Payment'] = $ModuleName.UPDATED;
                                    $objPayment->updatePaymentMethod($_POST);
                                    $objPayment->updatePaymentSettingsField($_POST);
                                    header("location:".$ListUrl);
					exit;
                            } 

                            

                        }
		
                 
 		$PaymentStatus = "Yes";
                    if (!empty($PaymentID)) 
                    {
                        $arryPaymentMethod = $objPayment->getPaymentById($PaymentID);
                        $arryPaypalSettingFields = $objPayment->getPaypalPaymentFields($PaymentID);
                      
               	 	if($arryPaymentMethod[0]['Status'] == "No"){
					$PaymentStatus = "No";
                            }else{
                                    $PaymentStatus = "Yes";
                            }
                    }


 require_once("../includes/footer.php"); 
 
 
 ?>
