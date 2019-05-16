<?php
/**************************************************/
$HideNavigation = 1;
/**************************************************/
include_once("includes/header.php");
require_once($Prefix."classes/sales.customer.class.php"); 
$objCustomer=new Customer();


if(empty($_GET['type'])){
	$ShipCareers = explode(',', $arryCompany[0]['ShippingCareerVal']); 
	$_GET['type'] = $ShipCareers[0];
}
 

/****************Validation******************/
if(!empty($_POST['Check'])) {
	CleanPost();
	$wPrefix = 'warehouse/';
	$ApiName = strtolower($_POST['api_name']);
	
	if($ApiName == strtolower('Fedex')){          
		include_once $wPrefix.'fedex_crediantial_validate.php';		
	}else if($ApiName=='UPS'){		
		include_once $wPrefix.'ups_crediantial_validate.php';	
	}else if($ApiName== strtolower('USPS')){		
		include_once $wPrefix.'usps_crediantial_validate.php';
	}else if($ApiName== strtolower('DHL')){
		include_once $wPrefix.'dhl_crediantial_validate.php';
	}

	if($_SESSION['mess_ship']==1){			
		 $_SESSION['mess_ship_msg'] = 'Authentication Validated Successfully.';
	}else{
	 	$_SESSION['mess_ship_msg'] = 'Authentication Failed.';
	} 

 	$RedirectURL = "editCustShippingAccount.php?edit=".$edit."&CustID=".$_GET['CustID']."&type=".$_GET['type']."";
 	
	header("Location:" . $RedirectURL);
	exit; 
}
/**********************************/


 	 if(!empty($_POST['CustID'])){
	
		CleanPost();
		if(!empty($_POST['api_name']) && !empty($_POST['api_account_number'])) {
			$_POST['live']=1;
			 
			if(!empty($_POST['defaultVal'])){
				$_POST['fixed']=0;
			}else{
				$_POST['fixed']=1;
			}
			 
			if(!empty($_POST['ID'])){ 	
				$_SESSION['mess_cust'] = CUST_SHIP_ACCOUNT_UPDATED;
				$objCustomer->UpdateCustShipAcount($_POST,$_POST['ID']);
			}else{
				$_SESSION['mess_cust'] = CUST_SHIP_ACCOUNT_ADDED;
				$objCustomer->AddCustShipAcount($_POST); 
			} 
			$RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustID'].'&tab=ShippingAccount&tp='.$_GET['type'];
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
			exit;	
		}		 
         }
             
 

/***************************/
$_GET['CustID'] = (int)$_GET['CustID']; 

if(!empty($_GET['CustID'])) {
	$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],'','');
			
	if($arryCustomer[0]['Cid']<=0){
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.CUSTOMER_NOT_EXIST.'</div>';
	}
}else{
	$ErrorExist=1;
	echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
}
/***************************/	




if(!empty($_GET['edit'])){
	$edit = $_GET['edit'];
	$Action='Edit';	
	$ShipAcoountDetails = $objCustomer->GetCustShipAcountById($_GET['edit']);
}else{	
	$Action='Add';
	$ShipAcoountDetails = $objConfigure->GetDefaultArrayValue('s_customer_shipping');
}


 
require_once("includes/footer.php");


?>
