<?php
$HideNavigation = 1;
/**************************************************/
$ThisPageName = 'editShipment.php';
/**************************************************/
include_once("../includes/header.php");
require_once($Prefix."classes/warehouse.shipment.class.php");
require_once($Prefix."classes/warehouse.class.php");
// Require the main ups class and upsRate
require('classes/class.ups.php');
require('classes/class.upsRate.php');
require('classes/class.upsShip.php');

$objShipment = new shipment();
$objWarehouse=new warehouse();
$NumLine=$_POST['NumLine'];

?>

<script language="JavaScript1.2" type="text/javascript">
function SetShippingRate(TotalFrieght,InsureAmount,InsureValue){
	parent.$("#ShippingRateTr").show();
	parent.$("#ShippingRateVal").val(TotalFrieght);
	parent.$("#InsureAmount").val(InsureAmount);
	parent.$("#InsureValue").val(InsureValue);
	parent.jQuery.fancybox.close();	 
}
</script>


<?php
//////////////////bydefault value //////////////////

$objShipment->saveToandFromData($_POST);

$arryAddBookShFrom=$objShipment->addBookShFrom();

$arryAddBookShTo=$objShipment->addBookShTo();

$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");
$arryAddressTo = $objShipment->defaultAddressBook("ShippingTo");

if(empty($arryAddressFrom[0]['adbID'])){
	$arryListWareh=$objShipment->defaultAddress();
}

$arrayService=$objShipment->defaultUPSShippingMethod();
$arrayPackage=$objShipment->defaultUPSPack();

$arryApiACDetails=$objShipment->ListShipmentAPIDetailByName('UPS');

////////////////////////////////////

//echo "<pre>";print_r($arrayFdDfService);
////////////////////////////////////

// Get credentials from a form
/*$accessNumber = '2CF8EA8CA48FB215';
 $username = 'mkbtechnology';
 $password = 'mkbTech2014#';*/
/*
 $accessNumber = '3D0AAD3E8E63E378';
 $username = 'virtualstacks';
 $password = '84733Mkb#';

 */

/*
$Config['ups_account_number']= '2CF8EA8CA48FB215';
$Config['ups_key']= 'mkbtechnology';
$Config['ups_password']= 'mkbTech2014#';
*/

$Config['ups_account_number']= $arryApiACDetails[0]['api_account_number'];
$Config['ups_key']= $arryApiACDetails[0]['api_key'];
$Config['ups_password']= $arryApiACDetails[0]['api_password'];

$Config['ups_ShipperNumber'] = $arryApiACDetails[0]['api_meter_number'];

$upsConnect = new ups($Config['ups_account_number'],$Config['ups_key'],$Config['ups_password']);
$upsConnect->setTemplatePath('xml/');
$upsConnect->setTestingMode(0); // Change this to 0 for production

$upsShip = new upsShip($upsConnect);

if($_POST['Action']){
	
	#echo "<pre>";print_r($_POST);

	for($i=1;$i<=$NumLine;$i++){ 
		$WeightLabel += $_POST['Weight'.$i];
		$LengthLabel += $_POST['Length'.$i];
		$WidthLabel += $_POST['Width'.$i];
		$HeightLabel += $_POST['Height'.$i];
	}
	
	$_POST['WeightLabel']=$WeightLabel;
	$_POST['LengthLabel']=$LengthLabel;
	$_POST['WidthLabel']=$WidthLabel;
	$_POST['HeightLabel']=$HeightLabel;
	
	$wtUnit = $_POST['wtUnit1'];
	$htUnit = $_POST['htUnit1'];
	
	include 'upsRate.php';

	/* Insure rate */
	/* less than 100 no charges and 100+ charges 2.70 and if amount greater than 300 charges 0.90 every 100+ 
 	* and insure value multiply by number of packages * */
	
		$numberPack = $_POST['NoOfPackages'];
		$InsureValue = 0;
		$InsureAmount = $_POST['InsureAmount'];

		if(!empty($InsureAmount)){
			$IV1=$IV2=0;
			if($InsureAmount>100) $IV1 = 2.70;
			if($InsureAmount>300){
				$IV2 = (ceil($InsureAmount/100)-3)*(.90);
			}
			$InsureValue = ($IV1 + $IV2)*($numberPack);
			$totalFreight += $InsureValue;
		}else{


$_POST['InsureAmount']= 100;
		}
		
	/*****/
	


	if($totalFreight>0 && $_POST['fedexLabel']=='Yes' && $_POST['Submit']){
		
	$upsShip->buildRequestXML();
	$responseArray = $upsShip->responseArray();
	
#echo "<pre>";print_r($responseArray['ShipmentConfirmResponse']['Response']['Error']);die;


	$error = $responseArray['ShipmentConfirmResponse']['Response']['Error']['ErrorDescription']['VALUE'];

	if(empty($error)){
			$ShipmentDigest = $responseArray['ShipmentConfirmResponse']['ShipmentDigest']['VALUE'];

	
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

			$error = $responseArray['ShipmentAcceptResponse']['Response']['Error']['ErrorDescription']['VALUE'];

			if(empty($error)){

				$TrackingID=$responseArray['ShipmentAcceptResponse']['ShipmentResults']['PackageResults']['TrackingNumber']['VALUE'];


				$file_name = 'UPS000_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.gif';
				file_put_contents($MainDir.$file_name, base64_decode($htmlImage));

					//include 'upsShipment.php';



				/*************COD***********/
				if($_POST['COD']==1){
					$Config['CodFlag'] = 1;
				
					$upsShip->buildRequestXML();
					$responseArray2 = $upsShip->responseArray();				
				
					$error = $responseArray2['ShipmentConfirmResponse']['Response']['Error']['ErrorDescription']['VALUE'];
				
				
					if(empty($error)){
						$ShipmentDigest2 = $responseArray2['ShipmentConfirmResponse']['ShipmentDigest']['VALUE'];				
						$upsShip->buildShipmentAcceptXML($ShipmentDigest2);				
						$responseArray2 = $upsShip->responseArray();
						//echo '<pre>';echo 'cod';print_r($responseArray2);exit;
						$htmlImage2 = $responseArray2['ShipmentAcceptResponse']['ShipmentResults']['PackageResults']['LabelImage']['GraphicImage']['VALUE'];
						//echo '<img src="data:image/gif;base64,'. $htmlImage. '"/>';
						$file_name1 = 'UPSCOD_'.$_POST['ShippingMethod'].'_'.$TrackingID.'.gif';
						file_put_contents($MainDir.$file_name1, base64_decode($htmlImage2));
					}
				}
				/******************************/

		

			}





			}
	}


if($_POST['Preview'] && empty($error)){?>
<SCRIPT TYPE="text/javascript">
$.fancybox({
	 'href' :'previewups.php?total=<?=$totalFreight;?>',
	 'type' : 'iframe',
	 'width': '500',
	 'height': '200'
	 });
</SCRIPT>

	<? }else if(empty($error)){


		
		
		$arr_freigh = (array) $freigh;
		$arr_totalFreight = (array) $totalFreight;
		$_SESSION['Shipping']['ShipType'] = 'UPS';
		$_SESSION['Shipping']['file_name'] = (!empty($file_name)) ? $file_name : 'No Label';
		$_SESSION['Shipping']['tracking_id'] = (!empty($TrackingID)) ? $TrackingID : '';
		$_SESSION['Shipping']['freigh'] = ($arr_freigh[0]>0) ? $arr_freigh[0] : 0;
		$_SESSION['Shipping']['totalFreight'] = ($arr_totalFreight[0]>0) ? $arr_totalFreight[0] : 0;
		$_SESSION['Shipping']['freightCurrency'] = $freightCurrency;

		if($_POST['COD']==1){
			$_SESSION['Shipping']['sendingLabel'] = $file_name1;
			$_SESSION['Shipping']['COD']=1;
		}else{
			$_SESSION['Shipping']['sendingLabel'] = '';
			$_SESSION['Shipping']['COD']=0;
		}

		$freightVal = ($_SESSION['Shipping']['freigh']>0)?($_SESSION['Shipping']['freigh']):($_SESSION['Shipping']['totalFreight']);

		$_SESSION['Shipping']['ZipFrom']=$_POST['ZipFrom'];
		$_SESSION['Shipping']['CityFrom']=$_POST['CityFrom'];
		$_SESSION['Shipping']['StateFrom']=$_POST['StateFrom'];
		$_SESSION['Shipping']['CountryFrom']=$_POST['CountryCgFrom'];
		$_SESSION['Shipping']['ZipTo']=$_POST['ZipTo'];
		$_SESSION['Shipping']['CityTo']=$_POST['CityTo'];
		$_SESSION['Shipping']['StateTo']=$_POST['StateTo'];
		$_SESSION['Shipping']['CountryTo']=$_POST['CountryCgTo'];
		$_SESSION['Shipping']['ShippingMethod']=$_POST['ShippingMethod'];
		$_SESSION['Shipping']['NoOfPackages']=$_POST['NoOfPackages'];
		$_SESSION['Shipping']['Weight']=$_POST['WPK'];
		$_SESSION['Shipping']['WeightUnit']=$_POST['WPK_Unit'];
		$_SESSION['Shipping']['PackageType']=$_POST['packageType'];
		$_SESSION['Shipping']['DeliveryDate']=$DeliveryDate;
		$_SESSION['Shipping']['LineItem'] = $LineItemDetail;
		
		echo "<script>SetShippingRate('".$freightVal."','".$InsureAmount."','".$InsureValue."');</script>";
		exit;

	}else{
		echo "<div class=redmsg align='center'>Please Enter Correct Information : <br>".$error.'</div><br>';
	}
	
}


require_once("../includes/footer.php");
?>


