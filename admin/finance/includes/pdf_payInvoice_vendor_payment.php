<?
	

	/******************vendor details*******************/
//if (!empty($_GET['vendorinfo'])) {
//		$arrySupplier = $objSupplier->GetSupplier('',$_GET['vendorinfo'],'');
//                //echo '<pre>'; print_r($arrySupplier);die('jfj');
//		$SuppID   = $_GET['view'];	
//		if(empty($arrySupplier[0]['SuppID'])){
//			$ErrorMSG = NOT_EXIST_SUPP;
//		}
//	}else{
//		$ErrorMSG = INVALID_REQUEST;
//	}
//
////	if(empty($ModuleID)){
////		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; 
////	}
//
//
//	
//	$Head1 = 'Left'; $Head2 = 'Right';
//	$data = array(
//		array($Head1 => "Vendor Code# :", $Head2 => $arrySupplier[0]["SuppCode"]),
//		array($Head1 => "Vendor Type :", $Head2 => $arrySupplier[0]["SuppType"]),
//		array($Head1 => "Company Name:", $Head2 => $arrySupplier[0]["CompanyName"]),
//		array($Head1 => "Contact Name:", $Head2 => $arrySupplier[0]["UserName"]),
//		array($Head1 => "Email :", $Head2 => $arrySupplier[0]["Email"]),
//		array($Head1 => "Mobile :", $Head2 => $arrySupplier[0]["Mobile"]),
//		array($Head1 => "Address :", $Head2 => $arrySupplier[0]["Address"].' '.$arrySupplier[0]["City"].' '.$arrySupplier[0]["State"].' '.$arrySupplier[0]["Country"].' '.$arrySupplier[0]["ZipCode"])
//	);
//	$pdf->ezSetDy(-10);
//	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
//	$pdf->setStrokeColor(0,0,0,1);

	
/**********vendor Details**********/
        
/***payment history table list**/
        /*************************************/
	$pdf->ezSetDy(-25);

	$pdf->ezText("<b>".Payment_History."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,120,$YCordLine);

	$pdf->ezSetDy(-5);
        $TotalAmount = 0;
	if(count($arryPaymentHistoryInvoice) > 0){
//    if($NumLine>0){
        $Head1 = '<b>InvoiceID</b>'; $Head2 = '<b>Payment Method</b>'; $Head3 = '<b>Payment Date</b>'; $Head4 = '<b>Reference No</b>'; $Head5 = '<b>Comment</b>';  $Head6 = '<b>Payment Status</b>'; $Head7 = '<b>Amount ('.$Config['Currency'].')</b>';
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;
        $data[] = $arryDef[$i];
        $i++;
		//$subtotal=0;
        /*************start code for payment history in pdf******/
        foreach($arryPaymentHistoryInvoice as $value) {
            
            if(!empty($value['CheckBankName'])){
                        
                        $CheckBankName = ' - ('.$value['CheckBankName'].'-'.$value['CheckFormat'].')';
                    }else{
                         $CheckBankName = '';
                    }
                    
                    
                    $arryDef[$i][$Head1] = $value['InvoiceID'];
                    $arryDef[$i][$Head2] = $value['Method'].''.$CheckBankName;
                    $arryDef[$i][$Head3] = date($Config['DateFormat'], strtotime($value['PaymentDate']));
                    $arryDef[$i][$Head4] = $value['ReferenceNo'];
                    $arryDef[$i][$Head5] = $value['Comment'];
                    /*code for payment status*/
                    
                                            if ($value['PaymentType'] == 'Other Expense') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                if ($value['InvoicePaid'] == 1) {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }
                                            }
                                            
                                            
                    /*code for payment status*/
                    $arryDef[$i][$Head6] = $InvoicePaid;
                    $arryDef[$i][$Head7] = number_format($value['CreditAmnt'],2,'.','');
                    
                  
                    $data[] = $arryDef[$i];
                    $TotalAmount += $value["CreditAmnt"];
                    $i++;
        }
        $TotalAmount = number_format($TotalAmount,2);
        /*************end code for payment history in pdf********/
                
		
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
                $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'80'),$Head3=>array('justification'=>'left'),$Head4=>array('justification'=>'left','width'=>'80'),$Head5=>array('justification'=>'left','width'=>'60') ,$Head7=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
                $pdf->setStrokeColor(0,0,0,1);


		

		$TotalTxt =  "Total Paid Amount : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		



    }

/***payment history table list**/
/*********Order Detail vendor address**************/
	/*************************************/
	if(empty($ModuleID)){
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; 
	}


	
        /**code for add new heading***/ 
        $pdf->ezText("<b>".Invoice_Information."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
         $YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,133,$YCordLine);
        $pdf->ezSetDy(-5);
        /**code for add new heading***/
        
	if($arryPurchase[0]['InvoiceEntry'] == 1){
            /**code for invoice information*/
                $arryTime = explode(" ",$Config['TodayDate']);
                $invoicedate=date($Config['DateFormat'], strtotime($arryTime[0]));
                $ItemReceivedDate=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED_PDF);
                $PaymentTerm=(!empty($arryPurchase[0]['PaymentTerm']))?(stripslashes($arryPurchase[0]['PaymentTerm'])):(NOT_SPECIFIED_PDF);
                $PaymentMethod=(!empty($arryPurchase[0]['PaymentMethod']))?(stripslashes($arryPurchase[0]['PaymentMethod'])):(NOT_SPECIFIED_PDF);
                $ShippingMethod=(!empty($arryPurchase[0]['ShippingMethod']))?(stripslashes($arryPurchase[0]['ShippingMethod'])):(NOT_SPECIFIED_PDF);
                $AssignedTo=(!empty($arryPurchase[0]['AssignedEmp']))?(stripslashes($arryPurchase[0]['AssignedEmp'])):(NOT_SPECIFIED_PDF);
                $referenceno=stripslashes($arryPurchase[0]['PurchaseID']);
                $comments=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED_PDF);
        /**code for invoice information**/
		$Head1 = 'Left'; $Head2 = 'Right';
		$data = array(
			array($Head1 => "Invoice # :", $Head2 => stripslashes($arryPurchase[0]["InvoiceID"])),
			array($Head1 => "Invoice Date :", $Head2 => $invoicedate),
			array($Head1 => "Item Received Date :", $Head2 => $ItemReceivedDate),
			array($Head1 => "Payment Term :", $Head2 => $PaymentTerm),
			array($Head1 => "Payment Method :", $Head2 => $PaymentMethod), 
			array($Head1 => "Shipping Method :", $Head2 => $ShippingMethod), 
			array($Head1 => "Assigned To : ", $Head2 => $AssignedTo),
			//array($Head1 => "Reference No# :", $Head2 => $arryPurchase[0]["ReferenceNo"]),
			array($Head1 => "Comments :", $Head2 => $comments)
			
			#array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
		);
		$pdf->ezSetDy(-10);
		$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
		$pdf->setStrokeColor(0,0,0,1);
        } else {
            $invoicedate=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED_PDF);
            $ItemReceivedDate=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED_PDF);
            $PaymentDetails='';
            $invoicePaid=($arryPurchase[0]['InvoicePaid'] == 1)?('Yes'):('No');
            $paymentDate=($arryPurchase[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_SPECIFIED_PDF);
            $PaymentMethod=(!empty($arryPurchase[0]['InvPaymentMethod']))?(stripslashes($arryPurchase[0]['InvPaymentMethod'])):(NOT_SPECIFIED_PDF);
            $paymentref=(!empty($arryPurchase[0]['PaymentRef']))?(stripslashes($arryPurchase[0]['PaymentRef'])):(NOT_SPECIFIED_PDF);
            $data = array(
			array($Head1 => "Invoice # :", $Head2 => stripslashes($arryPurchase[0]["InvoiceID"])),
			array($Head1 => "Invoice Date :", $Head2 => $invoicedate),
			array($Head1 => "Item Received Date :", $Head2 => $ItemReceivedDate),
			array($Head1 => "Payment Details:", $Head2 => $PaymentDetails),
			array($Head1 => "Total Amount:", $Head2 => $arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency']), 
			array($Head1 => "Invoice Paid:", $Head2 => $invoicePaid), 
			array($Head1 => "Payment Date:", $Head2 => $paymentDate),
			array($Head1 => "Payment Method :", $Head2 => $PaymentMethod),
			array($Head1 => "Reference No#  :", $Head2 => $arryPaymentHistoryInvoice[0]["ReferenceNo"])
			
			#array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
		);
		$pdf->ezSetDy(-10);
		$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
		$pdf->setStrokeColor(0,0,0,1);
            
            }

	/********* Vendor/Warehouse ********/
	/*************************************/

	$Head1 = '<b>'.SUPPLIER_ADDRESS.'</b>'; $Head2 = '<b>'.SHIP_TO_ADDRESS.'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,125,$YCordLine);
	$pdf->line(324,$YCordLine,396,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryPurchase[0]['Address']));
	$wAddress = str_replace("\n"," ",stripslashes($arryPurchase[0]['wAddress']));

	unset($data);
        $data[][$Head1]="Vendor Code: ".stripslashes($arryPurchase[0]['SuppCode']);
	if(!empty($arryPurchase[0]['SuppCompany']))  $data[][$Head1] = "Company Name: ".stripslashes($arryPurchase[0]['SuppCompany']);
	if(!empty($Address))  $data[][$Head1] =  "Address :".$Address.",";
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

//$pdf->ezNewPage();

	$pdf->ezSetDy($ItemY);
	$CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);


	$pdf->ezText("Tax Rate ".$TaxName.": ".$TaxVal,8,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-10);	

?>
