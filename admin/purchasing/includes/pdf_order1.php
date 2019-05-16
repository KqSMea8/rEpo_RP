<?
	/********* Order Detail **************/
	/*************************************/
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
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => $ModuleIDTitle."# :", $Head2 => $arryPurchase[0][$ModuleID]),
		array($Head1 => "Order Date :", $Head2 => $OrderDate),
		array($Head1 => "Approved :", $Head2 => $Approved),
		array($Head1 => "Order Status :", $Head2 => $arryPurchase[0]['Status']),
		array($Head1 => "Order Type :", $Head2 => $arryPurchase[0]['OrderType']), 
		array($Head1 => "Delivery Date :", $Head2 => $DeliveryDate),
		array($Head1 => "Payment Term :", $Head2 => $PaymentTerm),
		array($Head1 => "Payment Method :", $Head2 => $PaymentMethod),
		array($Head1 => "Shipping Method :", $Head2 => $ShippingMethod),
		array($Head1 => "Comments :", $Head2 => $Comment),
		array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	/********* Vendor/Warehouse ********/
	/*************************************/

	$Head1 = '<b>'.SUPPLIER_ADDRESS.'</b>'; $Head2 = '<b>'.SHIP_TO_ADDRESS.'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,125,$YCordLine);
	$pdf->line(330,$YCordLine,402,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryPurchase[0]['Address']));

	$wAddress = str_replace("\n"," ",stripslashes($arryPurchase[0]['wAddress']));
	
	$data = array(
		array($Head1 => stripslashes($arryPurchase[0]['SuppCompany']), $Head2 => stripslashes($arryPurchase[0]['wName'])),
		array($Head1 => $Address.",", $Head2 => $wAddress.","),
		array($Head1 => stripslashes($arryPurchase[0]['City']).", ".stripslashes($arryPurchase[0]['State']).", ".stripslashes($arryPurchase[0]['Country'])."-".stripslashes($arryPurchase[0]['ZipCode']), $Head2 => stripslashes($arryPurchase[0]['wCity']).", ".stripslashes($arryPurchase[0]['wState']).", ".stripslashes($arryPurchase[0]['wCountry'])."-".stripslashes($arryPurchase[0]['wZipCode'])),
		array($Head1 => "Contact Name: ".stripslashes($arryPurchase[0]['SuppContact']), $Head2 =>"Contact Name: ".stripslashes($arryPurchase[0]['wContact'])),
		array($Head1 => "Mobile: ".stripslashes($arryPurchase[0]['Mobile']), $Head2 => "Mobile: ".stripslashes($arryPurchase[0]['wMobile'])),
		array($Head1 => "Landline: ".stripslashes($arryPurchase[0]['Landline']), $Head2 =>  "Landline: ".stripslashes($arryPurchase[0]['wLandline'])),
		array($Head1 => "Email: ".stripslashes($arryPurchase[0]['Email']), $Head2 => "Email: ".stripslashes($arryPurchase[0]['wEmail'])),
		array($Head1 => "Currency: ".$arryPurchase[0]['SuppCurrency'], $Head2 => "")
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'280')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	/***********************************/
	$pdf->ezSetDy(-10);
	$CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);

?>