<?php
/**************************************************/
$ThisPageName = 'viewShippingAccount.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/supplier.class.php");

$objShipment = new shipment();
$objSupplier = new supplier();

if(empty($_GET['type'])){$_GET['type']='Fedex';}


if(!empty($_GET['edit'])){
	$edit = $_GET['edit'];
	$Action='Edit';
	$ActionType=$_GET['type'];
}else{
	$Action='Add';
	$ActionType=$_GET['type'];
	if(empty($ActionType)){$ActionType='Fedex';};
}


if(empty($_GET['curP'])){
	$cp = 1;
}else{
	$cp = $_GET['curP'];
}


CleanPost();



/****************Validation******************/
if(!empty($_POST['Check'])) {

	 $ApiName = strtolower($_POST['api_name']); 
	
	if($ApiName == strtolower('Fedex')){
          	include_once 'fedex_crediantial_validate.php';
		
	}else if($ApiName=='UPS'){
		
		include_once 'ups_crediantial_validate.php';
	
	}else if($ApiName== strtolower('USPS')){
		
		include_once 'usps_crediantial_validate.php';

	}else if($ApiName== strtolower('DHL')){

		include_once 'dhl_crediantial_validate.php';
	}



	if($_SESSION['mess_ship']==1){
			
		 $_SESSION['mess_ship_msg'] = 'Authentication Validated Successfully';

	}else{
	 	$_SESSION['mess_ship_msg'] = 'Authentication Failed';
	} 

 	$RedirectURL = "editShippingAccount.php?edit=".$edit."&curP=".$cp."&type=".$ActionType."";
 	
	header("Location:" . $RedirectURL);
	exit; 
}
/**********************************/


 if(!empty($_POST) && empty($_GET['edit']))
             {
	
             $_POST['live']=1;
             if($_POST['defaultVal']==1){
             $_POST['fixed']=0;
             }else{
             $_POST['fixed']=1;
             }

                $_SESSION['mess_ship_account'] = SHIP_ACCOUNT_ADD;
 				$objShipment->AddShipAcoount($_POST); //by madhu
 				$RedirectURL = "viewShippingAccount.php?&curP=1&type=".$ActionType.""; 
                header("location:".$RedirectURL);
                exit;
         }
             
   

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_ship_account'] = SHIP_ACCOUNT_REMOVE;
		$objShipment->DeleteShipAcoount($_GET['del_id']);
		$RedirectURL = "viewShippingAccount.php?&curP=1&type=".$ActionType.""; 
		header("Location:".$RedirectURL);
		exit;
		
	}

	if(!empty($_GET['edit']) && !empty($_POST['id'])){
		$_SESSION['mess_ship_account'] = SHIP_ACCOUNT_UPDATE;
		$objShipment->UpdateShipAcoount($_POST,$_POST['id']);
		$RedirectURL1 = "editShippingAccount.php?edit=".$edit."&curP=".$cp."&type=".$ActionType."";
		header("Location:".$RedirectURL1);
		exit;
		
		}

   $_GET['Status'] = '1';
   $arryVendor = $objSupplier->GetSupplierList($_GET);
   $ShipAcoountDetails = $objShipment->GetShipAcoountById($_GET['edit']);
   


require_once("../includes/footer.php");


?>
