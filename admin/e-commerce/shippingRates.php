<?php
	/**************************************************/
	$ThisPageName = 'viewShipping.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/cartsettings.class.php");
	
	$objcartsettings=new Cartsettings();

                $Ssid = isset($_GET['Ssid'])?$_GET['Ssid']:"";
                $MethodId = isset($_GET['MethodId'])?$_GET['MethodId']:"";
                $Srid = isset($_GET['Srid'])?$_GET['Srid']:"";
               if (!empty($Srid)) {$shipHeading  = "Edit Shipping Rate";}  else {$shipHeading  = "Add New Shipping Rate";}
                $ModuleName = 'Shipping Rates';
                $ListTitle  = 'Shipping';
                $ListUrl = "shippingRates.php?curP=".$_GET['curP']."&Ssid=".$Ssid."&MethodId=".$MethodId;
                $ParentID = 0;
                $BlankMessage  = $MSG[11];
                $InsertMessage = $MSG[12];
                $UpdateMessage = $MSG[13];
                $DeleteMessage = $MSG[14];
       

            
                
		 	 

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_ship'] = $ModuleName.$MSG[104];
		$objcartsettings->changeManufacturerStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	}
	

	

	 if(!empty($_GET['del_id'])){
	 
	  
                                $_SESSION['mess_ship'] = $ModuleName.$MSG[103];
                                $objcartsettings->deleteManufacturer($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		
	
		 
		 if ($_POST) {
		
                                            if (!empty($Srid)) {
                                              
                                                    $_SESSION['mess_ship'] = $ModuleName.$MSG[102];
                                                    $objcartsettings->updateShippingRate($_POST);
                                                   
                                            } else {		
                                                    $_SESSION['mess_ship'] = $ModuleName.$MSG[101];
                                                    $lastShipId = $objcartsettings->addShippingRate($_POST);	
                                                    
                                                   
                                            }

                                
                                         header("location:".$ListUrl);
                                            exit;
			
		}
		

	
		if (!empty($Ssid)) 
                {
                    $ShippingRatesArr = $objcartsettings->getShippingRatesById($Ssid);
                    $ShippingRateArr = $objcartsettings->getShippingRateById($Srid);
                }

		
		
		if(!empty($arryManufacturer[0]['Status'])){
			$ManufacturerStatus = $arryManufacturer[0]['Status'];
		}else{
			$ManufacturerStatus = 1;
		}


		if(empty($ShippingRateArr)){
			$ShippingRateArr = $objConfigure->GetDefaultArrayValue('e_shipping_custom_rates');
		}

 require_once("../includes/footer.php"); 
 
 
 ?>
