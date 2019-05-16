<?php
if(empty($error)){
			$ShipmentDigest = $responseArray['ShipmentConfirmResponse']['ShipmentDigest']['VALUE'];

			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}

			////////echo $upsShip->buildShipmentAcceptXML($ShipmentDigest);
			$upsShip->buildShipmentAcceptXML($ShipmentDigest);
			// echo $upsShip->responseXML;
			$responseArray = $upsShip->responseArray();

			$htmlImage = $responseArray['ShipmentAcceptResponse']['ShipmentResults']['PackageResults']['LabelImage']['GraphicImage']['VALUE'];


			//echo '<img src="data:image/gif;base64,'. $htmlImage. '"/>';
			$errorType = $responseArray['ShipmentAcceptResponse']['Response']['Error']['ErrorSeverity']['VALUE'];

			$error = $responseArray['ShipmentAcceptResponse']['Response']['Error']['ErrorDescription']['VALUE'];
			
			if($errorType=='Warning'){
				unset($error);
			}

			if(empty($error)){

				$TrackingID=$responseArray['ShipmentAcceptResponse']['ShipmentResults']['PackageResults']['TrackingNumber']['VALUE'];


				$file_tracking = 'UPS000_'.$_POST['ShippingMethod'].'_'.$TrackingID;
				$file_name_gif = $file_tracking.".gif";
				$file_name = $file_tracking.".pdf";

				file_put_contents($MainDir.$file_name_gif, base64_decode($htmlImage));

				/***************/
				$path = $DocumentDir.$file_name_gif;
				$path2 = $DocumentDir.$file_name;
				$cmd = "convert '$path' '$path2'";
				exec($cmd, $output, $return_var);
				unlink($MainDir.$file_name_gif);
				/***************/

					/*****************/
if($Config['ObjectStorage']=="1"){
$ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name);
	if($ResponseArray['Success']=="1"){
		unlink($MainDir.$file_name);  	
	}
}
					/*****************/




				//include 'upsShipment.php';
				/*************COD***********/
				if($_POST['COD']==1){
					$Config['CodFlag'] = 1;
				
					$upsShip->buildRequestXML();
					$responseArray2 = $upsShip->responseArray();				
					$errorType = $responseArray2['ShipmentAcceptResponse']['Response']['Error']['ErrorSeverity']['VALUE'];
					$error = $responseArray2['ShipmentConfirmResponse']['Response']['Error']['ErrorDescription']['VALUE'];
				
if($errorType=='Warning'){
unset($error);
}
				
					if(empty($error)){
						$ShipmentDigest2 = $responseArray2['ShipmentConfirmResponse']['ShipmentDigest']['VALUE'];				
						$upsShip->buildShipmentAcceptXML($ShipmentDigest2);				
						$responseArray2 = $upsShip->responseArray();
						//echo '<pre>';echo 'cod';print_r($responseArray2);exit;
						$htmlImage2 = $responseArray2['ShipmentAcceptResponse']['ShipmentResults']['PackageResults']['LabelImage']['GraphicImage']['VALUE'];
						//echo '<img src="data:image/gif;base64,'. $htmlImage. '"/>';
						$file_name_gif1 = 'UPSCOD_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.gif';
$file_name1 = 'UPSCOD_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.pdf';
				file_put_contents($MainDir.$file_name_gif1, base64_decode($htmlImage2));


/***************/
$pathc = $DocumentDir.$file_name_gif1;
$path2c = $DocumentDir.$file_name1;
$cmd = "convert '$pathc' '$path2c'";
exec($cmd, $output, $return_var);
unlink($MainDir.$file_name_gif1);
/***************/



if($Config['ObjectStorage']=="1"){
$ResponseArray = $objFunction->MoveObjStorage($MainDir, $PdfFolder, $file_name1);
	if($ResponseArray['Success']=="1"){
		unlink($MainDir.$file_name1);  	
	}
}



					}
				}
				/******************************/

		

			}





			}

?>

