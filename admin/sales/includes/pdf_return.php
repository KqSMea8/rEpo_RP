<?
	/********* Order Detail **************/
	/*************************************/
	if(empty($ModuleID)){
		$ModuleIDTitle = "Return Number"; $ModuleID = "ReturnID"; 
	}


	$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_MENTIONED);
	$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

	$ReturnDate = ($arrySale[0]['ReturnDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['ReturnDate']))):(NOT_MENTIONED);
	$ShippedDate = ($arrySale[0]['ShippedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['ShippedDate']))):(NOT_MENTIONED);
	$ReturnPaidDate = ($arrySale[0]['ReturnPaidDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['ReturnPaidDate']))):(NOT_MENTIONED);
	$ReturnComment = (!empty($arrySale[0]['ReturnComment']))? (stripslashes($arrySale[0]['ReturnComment'])): (NOT_MENTIONED);
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => $ModuleIDTitle."# :", $Head2 => $arrySale[0][$ModuleID]),
		array($Head1 => "Return Date :", $Head2 => $ReturnDate),
		array($Head1 => "Invoice Number# :", $Head2 => $arrySale[0]['InvoiceID']),
		//array($Head1 => "SO Number# :", $Head2 => $arrySale[0]['SaleID']),
		array($Head1 => "Customer :", $Head2 => $arrySale[0]['CustomerName']),
		array($Head1 => "Comments :", $Head2 => $ReturnComment)
		/*array($Head1 => "Sales Person :", $Head2 => $arrySale[0]['SalesPerson'])
		array($Head1 => "Return Amount Paid :", $Head2 => $arrySale[0]['ReturnPaid']),
		array($Head1 => "Return Paid Comment :", $Head2 => $ReturnComment)
		array($Head1 => "Return Paid Date :", $Head2 => $ReturnPaidDate),
		array($Head1 => "Return Paid Method :", $Head2 => $arrySale[0]['ReturnPaidMethod']),
		array($Head1 => "Paid Reference No# :", $Head2 => $arrySale[0]['ReturnPaidReferenceNo'])*/
		
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