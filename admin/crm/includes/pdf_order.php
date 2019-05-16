<?
	/********* Order Detail **************/
	/*************************************/
	if(empty($ModuleID)){
		$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; 
	}


	if($arryQuote[0]['validtill']>0)
		$ValidTillDate = date($_SESSION['DateFormat'], strtotime($arryQuote[0]['validtill']));
	

	if($arryQuote[0]['CustType']=='o'){
		$CustTitle = "Opportunity :";
		$CustVal = $OpportunityName;
	}else if($arryQuote[0]['CustType']=='c'){ 
		$CustTitle = "Customer :";
		$CustVal = $CustomerName;
	}

	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		//array($Head1 => $ModuleIDTitle."# :", $Head2 => $arryQuote[0][$ModuleID]),
		//array($Head1 => "Customer Code :", $Head2 => $arryQuote[0]['CustCode']),
		array($Head1 => "Subject :", $Head2 => $arryQuote[0]['subject']),
		array($Head1 => $CustTitle, $Head2 => $CustVal),
                array($Head1 => "Quote Stage:", $Head2 => $arryQuote[0]['quotestage']),
		array($Head1 => "Valid Till:", $Head2 => $ValidTillDate),
		array($Head1 => "Payment Term :", $Head2 =>  $arryQuote[0]['PaymentTerm']),
		array($Head1 => "Payment Method :", $Head2 => $arryQuote[0]['PaymentMethod']),
		array($Head1 => "Shipping Mode:", $Head2 => $arryQuote[0]['carrier']),
		array($Head1 => "Shipping  :", $Head2 => $arryQuote[0]['shipping'])
		//array($Head1 => "Assign To :", $Head2 => $arryQuote[0]['UserName'])
		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	/********* Billing/Shipping********/
	/*************************************/

	$Head1 = '<b>'.CUSTOMER_BILLING_ADDRESS.'</b>'; $Head2 = '<b>'.CUSTOMER_SHIPPING_ADDRESS.'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,115,$YCordLine);
	$pdf->line(325,$YCordLine,402,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['bill_street']));
	

	$ShippingAddress = str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['ship_street']));
	
	unset($data);
	
	if(!empty($Address))  $data[][$Head1] =  $Address.",";
	if(!empty($arryQuoteAdd[0]['bill_city']))  $data[][$Head1] =  stripslashes($arryQuoteAdd[0]['bill_city']).", ".stripslashes($arryQuoteAdd[0]['bill_state']).", ".stripslashes($arryQuoteAdd[0]['bill_country'])."-".stripslashes($arryQuoteAdd[0]['bill_code']);
	



	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	/***********************************/
	$Taxable = ($arryQuote[0]['tax_auths']=="Yes")?("Yes"):("No");
	$arrRate = explode(":",$arryQuote[0]['TaxRate']);
	if(!empty($arrRate[0])){
		$TaxVal = $arrRate[2].' %';
		$TaxName = '['.$arrRate[1].']';
	}else{
		$TaxVal = 'None';
	}


	 unset($data);
	
	
	if(!empty($arryQuoteAdd))  $data[][$Head2] =  $ShippingAddress." ,";
	if(!empty($arryQuoteAdd[0]['ship_city']))  $data[][$Head2] =  stripslashes($arryQuoteAdd[0]['ship_city']).", ".stripslashes($arryQuoteAdd[0]['ship_state']).", ".stripslashes($arryQuoteAdd[0]['ship_country'])."-".stripslashes($arryQuoteAdd[0]['ship_code']);
	


	if(sizeof($data)>3) $ItemY = '-50';
	else $ItemY = '-140';

	//echo '<pre>';print_r($data);exit;

	$pdf->ezSetDy($RightY);
	$pdf->ezTable($data,'','',array('cols'=>array($Head2=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>450, 'Pos' =>450 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);



	$pdf->ezSetDy($ItemY);
	$CurrencyInfo = str_replace("[Currency]",$arryQuote[0]['CustomerCurrency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);

	$pdf->ezText("Tax Rate ".$TaxName.": ".$TaxVal,8,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-10);
?>
