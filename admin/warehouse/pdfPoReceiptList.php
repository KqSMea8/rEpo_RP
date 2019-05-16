<?php	

 
require_once($Prefix."classes/purchase.class.php");
$objPurchase=new purchase();

(empty($addlength2))?($addlength2=""):(""); 


$ModuleName = "Receipt";

if(!empty($_GET['o'])){
	$arryPurchase = $objPurchase->GetPurchase($_GET['o'],'','Receipt');

	$OrderID   = $arryPurchase[0]['OrderID'];	
	if($OrderID>0){
 		$ModulePDFID = $arryPurchase[0]["ReceiptID"];

		$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
		$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			/////////*/

		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

//PR($arryPurchase);die;
	
	//$Title = $ModuleName." # ".$arryPurchase[0]["ReceiptID"];
	$Title="PO Receipt";

	$TotalAmount = $arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'];

	$InvoiceDate = ($arryPurchase[0]['PostedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_MENTIONED);
	$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_MENTIONED);
	$GenerateInvoice = ($arryPurchase[0]['GenrateInvoice']=='1')?("Yes"):("No");
	$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_MENTIONED);
	$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1)?('Yes'):('No');
	$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment']))? (stripslashes($arryPurchase[0]['InvoiceComment'])): (NOT_MENTIONED);
	$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod']))? (stripslashes($arryPurchase[0]['InvPaymentMethod'])): (NOT_MENTIONED);
	$PaymentRef = (!empty($arryPurchase[0]['PaymentRef']))? (stripslashes($arryPurchase[0]['PaymentRef'])): (NOT_MENTIONED);

	$Receipt = (!empty($arryPurchase[0]['ReceiptID']))? (stripslashes($arryPurchase[0]['ReceiptID'])): (NOT_MENTIONED);
	$ReceiptStatus = (!empty($arryPurchase[0]['ReceiptStatus']))? (stripslashes($arryPurchase[0]['ReceiptStatus'])): (NOT_MENTIONED);



	if(empty($ModuleID)){
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; 
	}


	$OrderDate = ($arryPurchase[0]['OrderDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_MENTIONED);
	$Approved = ($arryPurchase[0]['Approved'] == 1)?('Yes'):('No');

	$DeliveryDate = ($arryPurchase[0]['DeliveryDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_MENTIONED);

	$PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm']))? (stripslashes($arryPurchase[0]['PaymentTerm'])): (NOT_MENTIONED);
	$PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod']))? (stripslashes($arryPurchase[0]['PaymentMethod'])): (NOT_MENTIONED);
	$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethod']))? (stripslashes($arryPurchase[0]['ShippingMethod'])): (NOT_MENTIONED);
	$Comment = (!empty($arryPurchase[0]['Comment']))? (stripslashes($arryPurchase[0]['Comment'])): (NOT_MENTIONED);
	$AssignedEmp = (!empty($arryPurchase[0]['AssignedEmp']))? (stripslashes($arryPurchase[0]['AssignedEmp'])): (NOT_MENTIONED);
	#$CreatedBy = ($arryPurchase[0]['AdminType'] == 'admin')? ('Administrator'): ($arryPurchase[0]['CreatedBy']);
	$Status = (!empty($arryPurchase[0]['Status']))? (stripslashes($arryPurchase[0]['Status'])): (NOT_MENTIONED);
	$OrderType = (!empty($arryPurchase[0]['OrderType']))? (stripslashes($arryPurchase[0]['OrderType'])): (NOT_MENTIONED);
	$SaleID = (!empty($arryPurchase[0]['SaleID']))? (stripslashes($arryPurchase[0]['SaleID'])): (NOT_MENTIONED);


	 

	$service_type ='';
	if(!empty($arryPurchase[0]['ShippingMethodVal'])){		
		$arryShipMethodName = $objConfigure->GetShipMethodName($arryPurchase[0]['ShippingMethod'],$arryPurchase[0]['ShippingMethodVal']);
		$service_type = (!empty($arryShipMethodName[0]['service_type']))?($arryShipMethodName[0]['service_type']):('');
	}

   $Infodata = array('Order Date' => $OrderDate, 'Receipt #'=>$Receipt);

   $PaydataArry = array('Customer PO#' => $arryPurchase[0][$ModuleID], 'Ship VIA' => $service_type, 'TERMS' => $PaymentTerm);



//billing address
$Address = (!empty($arryPurchase[0]['Address'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['Address']))) : ('');
$addlength1 = strlen($Address);
$Address = wordwrap($Address, 45, "<br />", true);
$VenCompany = (!empty($arryPurchase[0]['SuppCompany'])) ? (stripslashes($arryPurchase[0]['SuppCompany'])) : ('');
$Vencity = (!empty($arryPurchase[0]['City'])) ? (stripslashes($arryPurchase[0]['City'])) : ('');
$VenState = (!empty($arryPurchase[0]['State'])) ? (stripslashes($arryPurchase[0]['State'])) : ('');
$VenCountry = (!empty($arryPurchase[0]['Country'])) ? (stripslashes($arryPurchase[0]['Country'])) : ('');
$VenZipCode = (!empty($arryPurchase[0]['ZipCode'])) ? (stripslashes($arryPurchase[0]['ZipCode'])) : ('');
$VenMobile = (!empty($arryPurchase[0]['Mobile'])) ? (stripslashes($arryPurchase[0]['Mobile'])) : ('');
$VenLandline = (!empty($arryPurchase[0]['Landline'])) ? (stripslashes($arryPurchase[0]['Landline'])) : ('&nbsp;');
$VenEmail = (!empty($arryPurchase[0]['Email'])) ? (stripslashes($arryPurchase[0]['Email'])) : ('');
$VenCurrency = (!empty($arryPurchase[0]['Currency'])) ? (stripslashes($arryPurchase[0]['Currency'])) : ('');
/* * *Billing Address for sale** */
$AddressHead1 = "VENDOR";
$AddressHead2 = "SHIP TO";



$VenCompany=(!empty($VenCompany)) ? ($VenCompany.',<br>') : ('');
$Address=(!empty($Address)) ? ($Address.',<br>') : ('&nbsp;<br>');
$VenCountry=(!empty($VenCountry)) ? ($VenCountry.',<br>') : ('&nbsp;<br>');
$VenMobile=(!empty($VenMobile)) ? ($VenMobile.',<br>'.$VenLandline) : ($VenLandline.'<br>&nbsp;');
$Vencity=(!empty($Vencity)) ? ($Vencity.',') : ('');
$VenState=(!empty($VenState)) ? ($VenState.'-') : ('');
//$BillMobile=(!empty($BillMobile)) ? ($BillMobile.',<br>')) : ('');
if ($addlength2 > 45 && $addlength1 < 45) {$Address1 = array('' => $VenCompany.$Address.'&nbsp;<br>'.$Vencity.$VenState.$VenZipCode.'<br>'.$VenCountry.$VenMobile);}
else{$Address1 = array('' => $VenCompany.$Address.$Vencity.$VenState.$VenZipCode.'<br>'.$VenCountry.$VenMobile);}



//shipping address
$ShippingAddress = (!empty($arryPurchase[0]['wAddress'])) ? (str_replace("\n", " ", stripslashes($arryPurchase[0]['wAddress']))) : ('');
$addlength2 = strlen($ShippingAddress);
$ShippingAddress = wordwrap($ShippingAddress, 45, "<br />", true);
$ShippCustomerCompany = (!empty($arryPurchase[0]['wName'])) ? (stripslashes($arryPurchase[0]['wName'])) : ('');
$Shippcity = (!empty($arryPurchase[0]['wCity'])) ? (stripslashes($arryPurchase[0]['wCity'])) : ('');
$ShippState = (!empty($arryPurchase[0]['wState'])) ? (stripslashes($arryPurchase[0]['wState'])) : ('');
$ShippCountry = (!empty($arryPurchase[0]['wCountry'])) ? (stripslashes($arryPurchase[0]['wCountry'])) : ('');
$ShippZipCode = (!empty($arryPurchase[0]['wZipCode'])) ? (stripslashes($arryPurchase[0]['wZipCode'])) : ('');
$ShippMobile = (!empty($arryPurchase[0]['wMobile'])) ? (stripslashes($arryPurchase[0]['wMobile'])) : ('');
$ShippLandline = (!empty($arryPurchase[0]['wLandline'])) ? (stripslashes($arryPurchase[0]['wLandline'])) : ('&nbsp;');
$ShippEmail = (!empty($arryPurchase[0]['wEmail'])) ? (stripslashes($arryPurchase[0]['wEmail'])) : ('');







$ShippCustomerCompany=(!empty($ShippCustomerCompany)) ? ($ShippCustomerCompany.',<br>') : ('');
$ShippingAddress=(!empty($ShippingAddress)) ? ($ShippingAddress.',<br>') : ('&nbsp;<br>');
$ShippCountry=(!empty($ShippCountry)) ? ($ShippCountry.',<br>') : ('&nbsp;<br>');
$ShippMobile=(!empty($ShippMobile)) ? ($ShippMobile.',<br>'.$ShippLandline) : ($ShippLandline.'<br>&nbsp;');
$Shippcity=(!empty($Shippcity)) ? ($Shippcity.',') : ('');
$ShippState=(!empty($ShippState)) ? ($ShippState.'-') : ('');
if ($addlength2 < 45 && $addlength1 > 45) {
    $Address2 = array('' => $ShippCustomerCompany.$ShippingAddress.'<br>&nbsp;<br>'.$Shippcity.$ShippState.$ShippZipCode.'<br>'.$ShippCountry.$ShippMobile);
} else {
$Address2 = array('' => $ShippCustomerCompany.$ShippingAddress.$Shippcity.$ShippState.$ShippZipCode.'<br>'.$ShippCountry.$ShippMobile);
}




   //die('dffd');
	
	?>
