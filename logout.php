<?php ob_start();
	session_start();	
	require_once("includes/settings.php");
        
        if($settings['ClearCartOnLogout'] == "Yes"){
         
           $objOrder->RemoveCart($Cid);
            
          //Unset CheckOut Varaiables
          unset($_SESSION['DelivaryDate']);
          unset($_SESSION['shipping_address_id']);
          unset($_SESSION['add_to_address_book']);
          unset($_SESSION['OrderID']);
          unset($_SESSION['Amount']);
          unset($_SESSION['ProductIDs']);
          unset($_SESSION['Ssid']);
          unset($_SESSION['shipping_address_id']);
          unset($_SESSION['AddressType']);
          
         
          
        }
	
	unset($_SESSION['Email']);
	unset($_SESSION['Password']);
	unset($_SESSION['Email']);
	unset($_SESSION['Cid']);
	unset($_SESSION['Name']);
        unset($_SESSION['Level']);
        unset($_SESSION['CompanyName']);
        
	setcookie("RememberUserName", '');
	setcookie("RememberPassword", '');


	if (isset($_COOKIE[session_name()])) {
	  setcookie(session_name(), '', time()-42000, '/');
	}
        
	session_destroy();
        header("location:login.php?logout=1"); 
	ob_end_flush();
?>