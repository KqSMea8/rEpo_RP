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
	#$CreatedBy = ($arryPurchase[0]['AdminType'] == 'admin')? ('Administrator'): ($arryPurchase[0]['CreatedBy']);


	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => $ModuleIDTitle."# :", $Head2 => $arryPurchase[0][$ModuleID]),
		array($Head1 => "Order Date :", $Head2 => $OrderDate),
		array($Head1 => "Approved :", $Head2 => $Approved),
		array($Head1 => "Order Status :", $Head2 => $arryPurchase[0]['Status']),
		array($Head1 => "Order Type :", $Head2 => $arryPurchase[0]['OrderType']), 
		array($Head1 => "Sales Order# :", $Head2 => $arryPurchase[0]['SaleID']), 
		array($Head1 => "Delivery Date :", $Head2 => $DeliveryDate),
		array($Head1 => "Payment Term :", $Head2 => $PaymentTerm),
		array($Head1 => "Payment Method :", $Head2 => $PaymentMethod),
		array($Head1 => "Shipping Carrier :", $Head2 => $ShippingMethod),
		array($Head1 => "Comments :", $Head2 => $Comment)
		#array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	/********* Vendor/Warehouse ********/
	/*************************************/

	$Head1 = '<b>'.SUPPLIER_ADDRESS.'</b>'; $Head2 = '<b>'.SHIP_TO_ADDRESS.'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,125,$YCordLine);
	$pdf->line(324,$YCordLine,396,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryPurchase[0]['Address']));
	$wAddress = str_replace("\n"," ",stripslashes($arryPurchase[0]['wAddress']));

	unset($data);
	if(!empty($arryPurchase[0]['SuppCompany']))  $data[][$Head1] = stripslashes($arryPurchase[0]['SuppCompany']);
	if(!empty($Address))  $data[][$Head1] =  $Address.",";
	if(!empty($arryPurchase[0]['City']))  $data[][$Head1] =  stripslashes($arryPurchase[0]['City']).", ".stripslashes($arryPurchase[0]['State']).", ".stripslashes($arryPurchase[0]['Country'])."-".stripslashes($arryPurchase[0]['ZipCode']);
	if(!empty($arryPurchase[0]['SuppContact']))  $data[][$Head1] = "Contact Name: ".stripslashes($arryPurchase[0]['SuppContact']);
	if(!empty($arryPurchase[0]['Mobile']))  $data[][$Head1] = "Mobile: ".stripslashes($arryPurchase[0]['Mobile']);
	if(!empty($arryPurchase[0]['Landline']))  $data[][$Head1] = "Landline: ".stripslashes($arryPurchase[0]['Landline']);
	if(!empty($arryPurchase[0]['Email']))  $data[][$Head1] = "Email: ".stripslashes($arryPurchase[0]['Email']);
	if(!empty($arryPurchase[0]['SuppCurrency']))  $data[][$Head1] = "Currency: ".stripslashes($arryPurchase[0]['SuppCurrency']);


	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	/***********************************/

	$Taxable = ($arryPurchase[0]['tax_auths']=="Yes")?("Yes"):("No");
	$arrRate = explode(":",$arryPurchase[0]['TaxRate']);
	if(!empty($arrRate[0])){
		$TaxVal = $arrRate[2].' %';
		$TaxName = '['.$arrRate[1].']';
	}else{
		$TaxVal = 'None';
	}


	unset($data);
	if(!empty($arryPurchase[0]['wName']))  $data[][$Head2] = stripslashes($arryPurchase[0]['wName']);
	if(!empty($wAddress))  $data[][$Head2] =  $wAddress.",";
	if(!empty($arryPurchase[0]['wCity']))  $data[][$Head2] =  stripslashes($arryPurchase[0]['wCity']).", ".stripslashes($arryPurchase[0]['wState']).", ".stripslashes($arryPurchase[0]['wCountry'])."-".stripslashes($arryPurchase[0]['wZipCode']);
	if(!empty($arryPurchase[0]['wContact']))  $data[][$Head2] = "Contact Name: ".stripslashes($arryPurchase[0]['wContact']);
	if(!empty($arryPurchase[0]['wMobile']))  $data[][$Head2] = "Mobile: ".stripslashes($arryPurchase[0]['wMobile']);
	if(!empty($arryPurchase[0]['wLandline']))  $data[][$Head2] = "Landline: ".stripslashes($arryPurchase[0]['wLandline']);
	if(!empty($arryPurchase[0]['wEmail']))  $data[][$Head2] = "Email: ".stripslashes($arryPurchase[0]['wEmail']);


	if(sizeof($data)>3) $ItemY = '-50';
	else $ItemY = '-140';

	
	if(sizeof($data)==0) $data[][$Head2] = NOT_MENTIONED;

	//echo '<pre>';print_r($data);exit;

	$pdf->ezSetDy($RightY);
	$pdf->ezTable($data,'','',array('cols'=>array($Head2=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>450, 'Pos' =>450 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);



	$pdf->ezSetDy($ItemY);
	$CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);


	$pdf->ezText("Tax Rate ".$TaxName.": ".$TaxVal,8,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-10);

?>
