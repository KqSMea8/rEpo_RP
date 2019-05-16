<?	session_start();
	$Prefix = "../../"; 
      
    	require_once($Prefix."includes/config.php");
	require_once($Prefix . "includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/category.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/inbound.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.class.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.rma.class.php");	
	
	
	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
	$objConfig=new admin();	

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();
	
 
 
	(empty($_GET['editID']))?($_GET['editID']=""):("");
	(empty($_POST['action']))?($_POST['action']=""):("");

		/* Checking for Attribute existance */
	if(!empty($_GET['AttributeValue'])){
		$objCommon=new common();
		if($objCommon->isAttributeExists($_GET['AttributeValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

			/* Checking for Attribute existance */
	if(!empty($_GET['WAttribValue'])){
		$objCommon=new common();
		if($objCommon->isWAttributeExists($_GET['WAttribValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	if(!empty($_GET['binlocation_name'])){

		$objWarehouse=new warehouse();
		if($objWarehouse->isBinExists($_GET['binlocation_name'],$_GET['binid'],$_GET['warehouse_id'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
                

	}
        
	if(!empty($_GET['warehouse_code'])){
		$objWarehouse=new warehouse();
		if($objWarehouse->isCodeExists($_GET['warehouse_code'],$_GET['editID'])){
			echo "1";
		}else if($objWarehouse->isWarehouseNameExists($_GET['warehouse_name'],$_GET['editID'])){
			echo "2";
		}else{
			echo "0";
		}
		exit;
	}
 
	if(!empty($_GET['checkWorkOrder'])){

	$objBom = new bom();
		if($objBom->isWoNumberExists($_GET['checkWorkOrder'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
		exit;
	}
	if(!empty($_GET['WON'])){

		$objBom = new bom();
		if($objBom->isWoNumberExists($_GET['WON'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
		exit;
	}
/* Checking for PoInvoiceID existance */
	if(!empty($_GET['PoInvoiceID'])){
		$objPurchase=new purchase();
		if($objPurchase->isInvoiceExists($_GET['PoInvoiceID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for PoReceiptID existance */
	if(!empty($_GET['PoReceiptID'])){
		$objPurchase=new purchase();
		if($objPurchase->isReceiptIDExists($_GET['PoReceiptID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	



	/* Checking for Sale Invoice number existance */
	if(!empty($_GET['SaleInvoiceID'])){
		$objSale = new sale();
		if($objSale->isInvoiceNumberExists($_GET['SaleInvoiceID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for ShippedID existance */
	if(!empty($_GET['ShippedID'])){
		$objShipment = new shipment();
		if($objShipment->isShipmentNumberExists($_GET['ShippedID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Currency existance */ 
	if(!empty($_GET['Currency'])){
		$objRegion=new region();
		if($objRegion->isCurrencyExists($_GET['Currency'],$_GET['editID'])){
			echo "1";
		}else{
		
			if($objRegion->isCurrencyCodeExists($_GET['CurrencyCode'],$_GET['editID'])){
				echo "2";
			}else{
				echo "0";
			}
			
		}

		exit;
		
	}
	

	

	/* Checking for category existance */
	if(!empty($_GET['CategoryName'])){
		$objCategory = new category();
		if($objCategory->isCategoryExists($_GET['CategoryName'],$_GET['editID'],$_GET['ParentID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	

	/* Checking for Product existance */
	if(!empty($_GET['ItemName'])){
		$objItem = new item();
		if($objItem->isProductExists($_GET['ItemName'],$_GET['ItemID'],$_GET['CategoryID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Product Number existance */
	if(!empty($_GET['ProductNumber'])){
		$objItem = new item();
		if($objItem->isProductNumberExists($_GET['ProductNumber'],$_GET['ProductID'],$_GET['PostedByID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


/* Checking for ReturnID existance */
	if(!empty($_GET['ReturnID'])){
		$objInbound=new inbound();
		if($objInbound->isRecieveExists($_GET['ReturnID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for ReceiptNo existance */
	if(!empty($_GET['ReceiptNo'])){
          	$objWarehouseRma = new warehouserma(); 
		if($objWarehouseRma->ReceiptNo($_GET['ReceiptNo'],'')){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	
	/* Checking for VReceiptNo existance */
	if(!empty($_GET['VReceiptNo'])){
          	$objWarehouse=new warehouse(); 
		if($objWarehouse->VendorReceiptNo($_GET['VReceiptNo'],'')){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for ReturnID existance */
	if($_POST['action'] == "ShippingFrom"){
		$objShipment = new shipment();
		if($objShipment->ListAddBookByID($_POST['adbID'])){
			$arryAddBook=$objShipment->ListAddBookByID($_POST['adbID']);
			if(!empty($arryAddBook[0]['State']) && !empty($arryAddBook[0]['country_id'])){
				if(strlen($arryAddBook[0]['State'])>3){
					$arryState=$objShipment->GetStateCode($arryAddBook[0]['State'],$arryAddBook[0]['country_id']);
					$arryAddBook[0]['State'] = $arryState[0]['StateCode'];
				}
			}
			 echo json_encode($arryAddBook[0]);exit;
			//print_r($arryAddBook[0]);
			exit;
			
		}else{
			echo "0";
		}
		exit;
	}
	
		/* Shiping api */
	if($_POST['action'] == "ShippingTo"){
		$objShipment = new shipment();
		if($objShipment->ListAddBookByID($_POST['adbID'])){
			$arryAddBookTo=$objShipment->ListAddBookByID($_POST['adbID']);
			if(!empty($arryAddBookTo[0]['State']) && !empty($arryAddBookTo[0]['country_id'])){
				if(strlen($arryAddBookTo[0]['State'])>3){
					$arryState=$objShipment->GetStateCode($arryAddBookTo[0]['State'],$arryAddBookTo[0]['country_id']);
					$arryAddBookTo[0]['State'] = $arryState[0]['StateCode'];
				}
			}
			 echo json_encode($arryAddBookTo[0]);exit;
			//print_r($arryAddBook[0]);
			exit;
			
		}else{
			echo "0";
		}
		exit;
	}

	
	if(!empty($_GET['AccountNumber'])){
		$objShipment = new shipment();
		if($objShipment->isShippingAccountExists($_GET['AccountNumber'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
		
	}


	/* Shiping api */
	if($_POST['action'] == "ShipFromCountry"){
		$objShipment = new shipment();
		if($objShipment->ShipFromC($_POST['countryCode'])){
			$arryCCODE=$objShipment->ShipFromC($_POST['countryCode']);
			
			$arry1=$objShipment->fedexPackageType($arryCCODE[0]['packageType']);
			$arry2=$objShipment->fedexServiceType($arryCCODE[0]['serviceType']);

			   $arrayFedex = array();
			  //$results=array_merge($arry1,$arry2);
			  //echo $results;
			  $arrayFedex['pk']= $arry1;
			  $arrayFedex['st']= $arry2;
			  echo json_encode($arrayFedex);exit;

			//return $results;

			exit;
			
		}else{
			//echo "0";
			
			  $arry3=$objShipment->fedexPackageTypeAll();
			  $arry4=$objShipment->fedexServiceTypeAll();
			  $arrayFedex = array();
			  $arrayFedex['pk']= $arry3;
			  $arrayFedex['st']= $arry4;
			  echo json_encode($arrayFedex);exit;
			
		}
		exit;
	}
	

	/* ups shipment */
	
	if($_POST['action'] == "UpsShipFromCountry")
	{
	//echo $_POST['action'] ;exit;
	
		
		$objShipment = new shipment();
		if($objShipment->UpsShipFromC($_POST['countryCode']))
		{
			$arryCCOD=$objShipment->UpsShipFromC($_POST['countryCode']);
			
			$arryups1=$objShipment->upsPackageType($arryCCOD[0]['packageType']);
			$arryups2=$objShipment->upsServiceType($arryCCOD[0]['serviceType']);

			   $arrayUPS = array();
			  //$results=array_merge($arry1,$arry2);
			  //echo $results;
			  $arrayUPS['pack']= $arryups1;
			  $arrayUPS['service']= $arryups2;
			  
			  //print_r($arrayUPS);
			  echo json_encode($arrayUPS);exit;

			//return $results;
			
		}
else{
			//echo "0";
			  $arryups3=$objShipment->upsPackageTypeAll();
			  $arryups4=$objShipment->upsServiceTypeAll();
			  $arrayUPS = array();
			  $arrayUPS['pack']= $arryups3;
			  $arrayUPS['service']= $arryups4;
			  echo json_encode($arrayUPS);exit;
			
		}
		exit;
	}
	
	
	
		/* ups shipment end */

	

?>
