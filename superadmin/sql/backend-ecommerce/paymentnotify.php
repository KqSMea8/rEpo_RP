<?php 
 	include_once("includes/header.php");
	require_once("classes/theme.class.php");
        
	 $themeObj=new theme();
	
	 if (is_object($themeObj)) {
	 	/*$array=array( 
'mc_gross'=>'2.00', 
'protection_eligibility'=>'Eligible',  
'address_status'=>'unconfirmed',  
'payer_id'=>'5MF9EQZSQJNU6', 
'tax'=>'0.00',  
'address_street'=>'dfhdfh dcfgdf',  
'payment_date'=>'02:23:02 May 06, 2016 PDT',  
'payment_status'=>'Completed',  
'charset'=>'windows-1252',  
'address_zip'=>'201301',  
'first_name'=>'Amit',  
'mc_fee'=>'0.36',  
'address_country_code'=>'IN ', 
'address_name'=>'PPpp PPpp',  
'notify_version'=>'3.8',  
'custom'=>'1', 
'payer_status'=>'unverified',  
'business'=>'pramod.vstacks1@gmail.com',  
'address_country'=>'India',  
'address_city'=>'Gautam Buddha Nagar',  
'quantity'=>'1',  
'payer_email'=>'testaggarwal1@gmail.com',  
'verify_sign'=>'AFcWxV21C7fd0v3bYYYRCpSSRl31Ajup3j0OZg0ATL7zV.JrzilQG3Gi',  
'txn_id'=>'80N58732Y25160113',  
'payment_type'=>'instant',  
'last_name'=>'Aggarwal',  
'address_state'=>'Uttar Pradesh',  
'receiver_email'=>'pramod.vstacks1@gmail.com',  
'payment_fee'=>'0.36',  
'receiver_id'=>'8HDWKXS2QEHX4',  
'txn_type'=>'web_accept',  
'item_name'=>'Templates',  
'mc_currency'=>'USD',  
'item_number'=>'', 
'residence_country'=>'US',  
'test_ipn'=>'1',  
'handling_amount'=>'0.00',  
'transaction_subject'=>'', 
'payment_gross'=>'2.00',  
'shipping'=>'0.00',  
'auth'=>'AeGw2QIxRKdtfoODjcNKuvb4N2oDgt813ZtBlbriGHhVy18NEp9JrSzzT9zGytt3XIHMOtB8cGWUqqKArLPxjgQ'
); */
	 	$post = $_POST;
		$themeObj->addpaymentresponse($post);
		$themeObj->updateOrderPayment($post);
		unset($_SESSION['orderId']);
		unset($_SESSION['amount']);
		unset($_SESSION['quantity']);
		$ListUrl    = "themes.php";
		header("location:".$ListUrl);
		exit;
       }
  
  require_once("includes/footer.php");
  
?>
