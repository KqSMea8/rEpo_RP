<?php
// Approve the label
$approve = strtolower($_POST['approve']);

$ShipmentDigest = $_POST['ShipmentDigest'];
$upsShip = new upsShip($upsConnect);

if ($approve == 'approve shipment') {

	$MainDir = "upload/ups/".$_SESSION['CmpID']."/";
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

	$TrackingID=$responseArray['ShipmentAcceptResponse']['ShipmentResults']['PackageResults']['TrackingNumber']['VALUE'];


	file_put_contents($MainDir.$TrackingID.'.gif', base64_decode($htmlImage));




} else {
	#echo '<pre>'; print_r($upsShip->buildRequestXML()); echo '</pre>';
	$responseArray = $upsShip->responseArray();
}
?>

<?php if($_POST['UPSLabel']=='Yes'){?>

<!-- form action="" method="POST"><input type="submit" class="button"
	name="approve" value="approve shipment" /> <input type="hidden"
	name="accessNumber" value="<?php echo $Config['ups_account_number'];?>" />
<input type="hidden" name="username"
	value="<?php echo $Config['ups_key'];?>" /> <input type="hidden"
	name="password" value="<?php echo $Config['ups_password'];?>" /> <input
	type="hidden" name="ShipmentDigest"
	value="<?php echo $responseArray['ShipmentConfirmResponse']['ShipmentDigest']['VALUE']; ?>" />
</form-->

<?php }?>


