<?php
include_once("includes/header.php");
require_once("classes/webcms.class.php");
require_once("classes/theme.class.php");

$themeObj=new theme();
if (is_object($themeObj)) {
	$arryTemplates=$themeObj->getEcomTemplates('e',$Config['ecomType']);

	$num=$themeObj->numRows();


if ($_POST) {
		
		$ModuleName = 'Template';

		
		$orderId=$themeObj->makeOrder($_POST);
		$_SESSION['orderId']=$orderId;
		$_SESSION['quantity']=count($_POST['templateId']);
		$orderdata=$themeObj->getOrder($orderId);
		if($orderdata[0]['amount']>0){
			$ListUrl    = "payment.php";
			header("location:".$ListUrl);
			exit;
		}else{
			$post['custom']=$orderId;
			$post['payment_status']='Completed';
			$themeObj->updateOrderPayment($post);
			unset($_SESSION['orderId']);
			unset($_SESSION['amount']);
			unset($_SESSION['quantity']);
			$ListUrl    = "themes.php";
			header("location:".$ListUrl);
			exit;
		}
		

	}

}

require_once("includes/footer.php");

?>
