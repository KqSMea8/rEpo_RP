<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer();

	(empty($_GET['view']))?($_GET['view']=""):("");
	(empty($_GET['CustID']))?($_GET['CustID']=""):("");
	$ErrorExist=0;

	if (!empty($_GET['view']) || !empty($_GET['CustID'])) {
		$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],$_GET['view'],'');
		$CustID   = $_GET['view'];	
		
		if(empty($arryCustomer[0]['Cid'])){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.CUSTOMER_NOT_EXIST.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}

	require_once("includes/footer.php");  

?>
