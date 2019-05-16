<?php
	/**************************************************/
	$ThisPageName = 'viewShipping.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/cartsettings.class.php");
	
	$objcartsettings=new Cartsettings();

                 $Ssid = isset($_GET['edit'])?$_GET['edit']:"";	
                  if (!empty($Ssid)) {$ModuleTitle = "Edit Shipping Method";}else{$ModuleTitle = "Add Shipping Method";}
                $ModuleName = 'Shipping Methods';
                $ListTitle  = 'Shipping Methods';
                $ListUrl    = "viewShipping.php?curP=".$_GET['curP'];
               
              	 
          if(!empty($_GET['active_id'])){
		$_SESSION['mess_ship'] = $ModuleName.STATUS;
		$objcartsettings->changeShippingMethodStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_ship'] = $ModuleName.REMOVED;
                                $objcartsettings->deleteShippingMethod($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		


		 
		 if ($_POST) {
		
                                            if (!empty($Ssid)) {
                                                    $_SESSION['mess_ship'] = $ModuleName.UPDATED;
                                                    $objcartsettings->updateShippingMethod($_POST);
                                                    header("location:".$ListUrl);
						    exit;
                                            } else {		
                                                    $_SESSION['mess_ship'] = $ModuleName.ADDED;
                                                    $lastShipId = $objcartsettings->addShippingMethod($_POST);	
                                                    $ListUrl = "shippingRates.php?curP=".$_GET['curP']."&Ssid=".$lastShipId."&MethodId=".$_POST['MethodId'];
                                                   header("location:".$ListUrl);
						   exit;
                                            }

			
		}
		
$ShippingStatus = "Yes";$MethodId ='';
	
	 if (!empty($Ssid)) 
                {
                    $arryShipping = $objcartsettings->getShippingMethodById($Ssid);
               
		
				if($arryShipping[0]['Status'] == "Yes"){
					$ShippingStatus = "Yes";
				}else{
					$ShippingStatus = "No";
				}
                
                                if($arryShipping[0]['MethodId'] == "flat"){
                                   	 $MethodId = "Flat (per item)";

                                    }
                                    if($arryShipping[0]['MethodId'] == "price"){
                                    	$MethodId = "Price-based";

                                    }
                                    if($arryShipping[0]['MethodId'] == "weight"){
                                   	 $MethodId = "Weight";

                                    }

		 }


 require_once("../includes/footer.php"); 
 
 
 ?>
