<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/theme.class.php");
        
	 $themeObj=new theme();
	
	 if (is_object($themeObj)) {
	 	define('BUSSINESS_NAME','pramod.vstacks1@gmail.com');
		define('PAYMENT_URL','https://www.sandbox.paypal.com/cgi-bin/webscr');
		$returnURL='http://'.$_SERVER['SERVER_NAME'].'/erp_old/erp/admin/e-commerce/paymentnotify.php';
		$notifyURL='http://'.$_SERVER['SERVER_NAME'].'/erp_old/erp/admin/e-commerce/paymentnotify.php';
		$cancelURL='http://'.$_SERVER['SERVER_NAME'].'/erp_old/erp/admin/e-commerce/template.php';
		$orderId=$_SESSION['orderId'];
		unset($_SESSION['orderId']);
		if($orderId!=''){
			$orderdata=$themeObj->getOrder($orderId);
			 $_SESSION['orderId']=$orderdata[0]['orderid'];
			 $_SESSION['amount']=$orderdata[0]['amount'];
			 
		}
		
		//$pagerLink=$objPager->getPager($arryWidgets,$RecordsPerPage,$_GET['curP']);
		//(count($arryWidgets)>0)?($arryWidgets=$objPager->getPageRecords()):(""); 
       }
  
  require_once("../includes/footer.php");
  
?>
