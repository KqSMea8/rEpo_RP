<?

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
	$CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['SuppCurrency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);


	$pdf->ezText("Tax Rate ".$TaxName.": ".$TaxVal,8,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-10);	
	
	
	/********* Order Detail **************/
	/*************************************/
	
?>
