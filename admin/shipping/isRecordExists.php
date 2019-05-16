<?	session_start();
	$Prefix = "../../"; 
      		
    	require_once($Prefix."includes/config.php");
	require_once($Prefix . "includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php"); 
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	


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
