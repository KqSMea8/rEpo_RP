<?
	/********* Order Detail **************/
	/*************************************/
	if(empty($ModuleID)){
		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; 
	}


	$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_MENTIONED);
	$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

	$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_MENTIONED);

	$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_MENTIONED);
	$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_MENTIONED);
	$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_MENTIONED);
	$Comment = (!empty($arrySale[0]['Comment']))? (stripslashes($arrySale[0]['Comment'])): (NOT_MENTIONED);
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => $ModuleIDTitle."# :", $Head2 => $arrySale[0][$ModuleID]),
		array($Head1 => "Customer :", $Head2 => $arrySale[0]['CustomerName']),
		array($Head1 => "Sales Person :", $Head2 => $arrySale[0]['SalesPerson']),
		array($Head1 => "Order Date :", $Head2 => $OrderDate),
		array($Head1 => "Approved :", $Head2 => $Approved),
		array($Head1 => "Order Status :", $Head2 => $arrySale[0]['Status']),
		array($Head1 => "Delivery Date :", $Head2 => $DeliveryDate),
		array($Head1 => "Payment Term :", $Head2 => $PaymentTerm),
		array($Head1 => "Payment Method :", $Head2 => $PaymentMethod),
		array($Head1 => "Shipping Method :", $Head2 => $ShippingMethod),
		array($Head1 => "Comments :", $Head2 => $Comment)
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	/********* Billing/Shipping********/
	/*************************************/

	$Head1 = '<b>'.CUSTOMER_BILLING_ADDRESS.'</b>'; $Head2 = '<b>'.CUSTOMER_SHIPPING_ADDRESS.'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,125,$YCordLine);
	$pdf->line(325,$YCordLine,405,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arrySale[0]['Address1']));
	$Address2 = str_replace("\n"," ",stripslashes($arrySale[0]['Address2']));

	$ShippingAddress = str_replace("\n"," ",stripslashes($arrySale[0]['ShippingAddress1']));
	$ShippingAddress2 = str_replace("\n"," ",stripslashes($arrySale[0]['ShippingAddress2']));
	
	/*$data = array(
		array($Head1 => stripslashes($arrySale[0]['BillingName']), $Head2 => stripslashes($arrySale[0]['ShippingName'])),
		array($Head1 => stripslashes($arrySale[0]['CustomerCompany']), $Head2 => stripslashes($arrySale[0]['ShippingCompany'])),
		array($Head1 => $Address." ".$Address2.",", $Head2 => $ShippingAddress." ".$ShippingAddress2.","),
		array($Head1 => stripslashes($arrySale[0]['City']).", ".stripslashes($arrySale[0]['State']).", ".stripslashes($arrySale[0]['Country'])."-".stripslashes($arrySale[0]['ZipCode']), $Head2 => stripslashes($arrySale[0]['ShippingCity']).", ".stripslashes($arrySale[0]['ShippingState']).", ".stripslashes($arrySale[0]['ShippingCountry'])."-".stripslashes($arrySale[0]['ShippingZipCode'])),
		//array($Head1 => "Contact Name: ".stripslashes($arrySale[0]['SuppContact']), $Head2 =>"Contact Name: ".stripslashes($arrySale[0]['wContact'])),
		array($Head1 => "Mobile: ".stripslashes($arrySale[0]['Mobile']), $Head2 => "Mobile: ".stripslashes($arrySale[0]['ShippingMobile'])),
		array($Head1 => "Landline: ".stripslashes($arrySale[0]['Landline']), $Head2 =>  "Landline: ".stripslashes($arrySale[0]['ShippingLandline'])),
		array($Head1 => "Email: ".stripslashes($arrySale[0]['Email']), $Head2 => "Email: ".stripslashes($arrySale[0]['ShippingEmail'])),
		array($Head1 => "Currency: ".$arrySale[0]['CustomerCurrency'], $Head2 => "")
	);*/
	
   
	unset($data);
	//if(!empty($arrySale[0]['BillingName']))  $data[][$Head1] = stripslashes($arrySale[0]['BillingName']);
	if(!empty($arrySale[0]['CustomerCompany']))  $data[][$Head1] = stripslashes($arrySale[0]['CustomerCompany']);
	if(!empty($Address))  $data[][$Head1] =  $Address." ".$Address2.",";
	if(!empty($arrySale[0]['City']))  $data[][$Head1] =  stripslashes($arrySale[0]['City']).", ".stripslashes($arrySale[0]['State']).", ".stripslashes($arrySale[0]['Country'])."-".stripslashes($arrySale[0]['ZipCode']);
	if(!empty($arrySale[0]['Contact']))  $data[][$Head1] = "Contact Name: ".stripslashes($arrySale[0]['Contact']);
	if(!empty($arrySale[0]['Mobile']))  $data[][$Head1] = "Mobile: ".stripslashes($arrySale[0]['Mobile']);
	if(!empty($arrySale[0]['Landline']))  $data[][$Head1] = "Landline: ".stripslashes($arrySale[0]['Landline']);
	if(!empty($arrySale[0]['Email']))  $data[][$Head1] = "Email: ".stripslashes($arrySale[0]['Email']);
	if(!empty($arrySale[0]['CustomerCurrency']))  $data[][$Head1] = "Currency: ".stripslashes($arrySale[0]['CustomerCurrency']);



	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	/***********************************/
	$Taxable = ($arrySale[0]['tax_auths']=="Yes")?("Yes"):("No");
	$arrRate = explode(":",$arrySale[0]['TaxRate']);
	if(!empty($arrRate[0])){
		$TaxVal = $arrRate[2].' %';
		$TaxName = '['.$arrRate[1].']';
	}else{
		$TaxVal = 'None';
	}

	 unset($data);
	//if(!empty($arrySale[0]['ShippingName']))  $data[][$Head2] = stripslashes($arrySale[0]['ShippingName']);
	if(!empty($arrySale[0]['ShippingCompany']))  $data[][$Head2] = stripslashes($arrySale[0]['ShippingCompany']);
	if(!empty($ShippingAddress))  $data[][$Head2] =  $ShippingAddress." ".$ShippingAddress2.",";
	if(!empty($arrySale[0]['ShippingCity']))  $data[][$Head2] =  stripslashes($arrySale[0]['ShippingCity']).", ".stripslashes($arrySale[0]['ShippingState']).", ".stripslashes($arrySale[0]['ShippingCountry'])."-".stripslashes($arrySale[0]['ShippingZipCode']);
	if(!empty($arrySale[0]['ShippingMobile']))  $data[][$Head2] = "Mobile: ".stripslashes($arrySale[0]['ShippingMobile']);
	if(!empty($arrySale[0]['ShippingLandline']))  $data[][$Head2] = "Landline: ".stripslashes($arrySale[0]['ShippingLandline']);
	if(!empty($arrySale[0]['ShippingEmail']))  $data[][$Head2] = "Email: ".stripslashes($arrySale[0]['ShippingEmail']);
	//$data[][$Head2] = "Taxable: ".$Taxable;
	//$data[][$Head2] = "Tax Rate: ".$TaxRate;

	if(sizeof($data)>3) $ItemY = '-50';
	else $ItemY = '-140';

	//echo '<pre>';print_r($data);exit;

	$pdf->ezSetDy($RightY);
	$pdf->ezTable($data,'','',array('cols'=>array($Head2=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>450, 'Pos' =>450 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);



	$pdf->ezSetDy($ItemY);
	$CurrencyInfo = str_replace("[Currency]",$arrySale[0]['CustomerCurrency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);



	$pdf->ezText("Tax Rate ".$TaxName.": ".$TaxVal,8,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-10);


?>
