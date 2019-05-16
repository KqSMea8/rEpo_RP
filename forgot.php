<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");

	
    if (!empty($_SESSION['Email']) && !empty($_SESSION['Cid'])) {
                    header('location: account.php');
                    exit;
    }

    if (!empty($_POST['forgotEmail'])) {

           $arryMember = $objCustomer->ValidateCustomerByEmail($_POST['forgotEmail']);
           if($_POST['forgotEmail'] != $arryMember[0]['Email']){
                           $_SESSION['errorMsg'] = RESET_ERROR; 
                   }else{
                       $objCustomer->ForgotPassword($_POST['forgotEmail']);
                       $_SESSION['successMsg'] = RESET_PASSWORD_SUCCESSFULLY; 
                       header('location:login.php');
                       exit;
                   }

    }
  
	 
		 
        

require_once("includes/footer.php"); 
 ?>

