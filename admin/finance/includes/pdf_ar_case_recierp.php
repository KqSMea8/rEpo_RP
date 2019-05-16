<?

        
/***payment history table list**/
        /*************************************/
	$pdf->ezSetDy(-25);
	$pdf->ezText("<b>".Payment_History."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,120,$YCordLine);

	$pdf->ezSetDy(-5);
        $TotalAmount = 0;
	if(count($arryPaymentInvoice) > 0){
//    if($NumLine>0){
        $Head1 = '<b>Invoice/GL #</b>'; $Head2 = '<b>Payment Date</b>';   $Head3 = '<b>Paid To</b>'; $Head4 = '<b>Payment Method</b>'; $Head5 = '<b>Reference No.</b>';  $Head6 = '<b>Comment</b>'; $Head7 = '<b>Amount ('.$Config['Currency'].')</b>';
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;
        $data[] = $arryDef[$i];
        $i++;
		//$subtotal=0;
        /*************start code for payment history in pdf******/
        foreach($arryPaymentInvoice as $value) {
            //echo $value['InvoiceID'];die;
            
            if(!empty($value['CheckBankName'])){
                        
                        $CheckBankName = ' - ('.$value['CheckBankName'].'-'.$value['CheckFormat'].')';
                    }else{
                         $CheckBankName = '';
                    }
                    /**gl code*/
                    if(!empty($value['GLCode']) && $value['EntryType']=='GL Account'){ 
		$arryBankAccount = $objBankAccount->getBankAccountById($value['GLCode']);
		if(!empty($arryBankAccount[0]['AccountNumber'])){
			$AccountVal = ' : '.stripslashes($arryBankAccount[0]['AccountName']).' ['.$arryBankAccount[0]['AccountNumber'].']';
		}
                    }
                    /**gl code*/
                    $InvoiceGL='';
		if(!empty($value["InvoiceID"])){
			$InvoiceGL =  $value["InvoiceID"]; 
		}else if(!empty($value["GLID"])){ 
			$InvoiceGL =  $value["AccountNameNumber"];
		}


                    $arryDef[$i][$Head1] = $InvoiceGL;
                    
                    $arryDef[$i][$Head2] =  date($Config['DateFormat'], strtotime($value['PaymentDate']));
                   
                    
                    $arryDef[$i][$Head3] = $value['AccountName'];
                    $arryDef[$i][$Head4] = $value['Method'].''.$CheckBankName;
                    $arryDef[$i][$Head5] = $value['ReferenceNo'];
                    
                    $arryDef[$i][$Head6] = $value['Comment'];
                    $arryDef[$i][$Head7] = number_format($value['DebitAmnt'],2,'.','');
                    
                    
                    $data[] = $arryDef[$i];
                     $TotalAmount += $value["DebitAmnt"];
                    $i++;
        
        }
        $TotalAmount = number_format($TotalAmount,2);
        /*************end code for payment history in pdf********/
                
		
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
                $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'100'),$Head2=>array('justification'=>'left','width'=>'70'),$Head3=>array('justification'=>'left','width'=>'90'),$Head4=>array('justification'=>'left','width'=>'60'),$Head5=>array('justification'=>'left','width'=>'60'),$Head7=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
                $pdf->setStrokeColor(0,0,0,1);


		

		$TotalTxt =  "Total Received Amount : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		



    }
        

/***payment history table list**/
/*********Order Detail vendor address**************/
	/*************************************/
	if(empty($ModuleID)){
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; 
	}


	
        $pdf->ezText("<b>".Invoice_Information."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
         $YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,133,$YCordLine);
        $pdf->ezSetDy(-5);
        /**code for add new heading***/
        
	if(count($arrySale)>0){
            /**code for Invoice Information comman data**/
              
                    $InvoiceDate=($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):(NOT_SPECIFIED_PDF);
                    $shipdate=($arrySale[0]['ShippedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ShippedDate']))):(NOT_SPECIFIED_PDF);
                    $salesperson=(!empty($arrySale[0]['SalesPerson']))?(stripslashes($arrySale[0]['SalesPerson'])):(NOT_SPECIFIED_PDF);
                    $salesstatus=(!empty($arrySale[0]['InvoicePaid']))?(stripslashes($arrySale[0]['InvoicePaid'])):(NOT_SPECIFIED_PDF);
                    if($arrySale[0]['AdminType'] == 'admin'){
                               $CreatedBy = 'Administrator';
                       }else{
                               $CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
                       }
                       $shipformw=(!empty($arrySale[0]['wName']))?(stripslashes($arrySale[0]['wName'])):(NOT_SPECIFIED_PDF);
                /**code for Invoice Information comman data**/
            if($_GET['IE'] == 1){
                
                $paymentterm=(!empty($arrySale[0]['PaymentTerm']))?(stripslashes($arrySale[0]['PaymentTerm'])):(NOT_SPECIFIED_PDF);
                $paymentmethod=(!empty($arrySale[0]['PaymentMethod']))?(stripslashes($arrySale[0]['PaymentMethod'])):(NOT_SPECIFIED_PDF);
                $shoppedmethod=(!empty($arrySale[0]['ShippingMethod']))?(stripslashes($arrySale[0]['ShippingMethod'])):(NOT_SPECIFIED_PDF);
                $invoicecomment=(!empty($arrySale[0]['InvoiceComment']))?(stripslashes($arrySale[0]['InvoiceComment'])):(NOT_SPECIFIED_PDF);
                $Head1 = 'Left'; $Head2 = 'Right';
		$data = array(
			
			array($Head1 => "Customer :", $Head2 => stripslashes($arrySale[0]["CustomerName"])),
			array($Head1 => "Payment Term :", $Head2 => $paymentterm),
			array($Head1 => "Ship Date :", $Head2 => $shipdate), 
			array($Head1 => "SO/Reference Number :", $Head2 => stripslashes($arrySale[0]['SaleID'])), 

			array($Head1 => "Invoice Date :", $Head2 => $InvoiceDate),
			array($Head1 => "Payment Method :", $Head2 => $paymentmethod),
                        array($Head1 => "Shipping Method :", $Head2 => $shoppedmethod),
                        array($Head1 => "ShipFrom(Warehouse):", $Head2 => $shipformw),
                         array($Head1 => "Invoice Status:", $Head2 => $salesstatus),
                        array($Head1 => "Invoice Comment:", $Head2 => $invoicecomment)
                         
			
			#array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
		);
		$pdf->ezSetDy(-10);
		$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'110')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
		$pdf->setStrokeColor(0,0,0,1);
                
            }
            else{
            /**code for invoice information*/
                
                if($arrySale[0]['Spiff']=="Yes"){
                    $CustomerContact=str_replace("|","",stripslashes($arrySale[0]['SpiffContact']));
                    $CustomerContact=str_replace("<br>"," ",$CustomerContact);
                    $SpiffAmount =stripslashes($arrySale[0]['SpiffAmount']);
                }
                
                       $Spiff=($arrySale[0]['Spiff']=="Yes")?("Yes"):("No");
        /**code for invoice information**/
		$Head1 = 'Left'; $Head2 = 'Right';
		$data = array(
			
			array($Head1 => "Customer :", $Head2 => stripslashes($arrySale[0]["CustomerName"])),
			
			array($Head1 => "Ship Date :", $Head2 => $shipdate), 
			array($Head1 => "SO/Reference Number :", $Head2 => stripslashes($arrySale[0]['SaleID'])), 			
			array($Head1 => "Invoice Date :", $Head2 => $InvoiceDate),
			array($Head1 => "Spiff :", $Head2 => $Spiff),
                        array($Head1 => "Spiff Amount (INR) :", $Head2 => $SpiffAmount),
                        array($Head1 => "Ship From(Warehouse) :", $Head2 => stripslashes($arrySale[0]['wName'])),
                        array($Head1 => "Sales Person :", $Head2 => $salesperson),
                        array($Head1 => "Invoice Status:", $Head2 => $salesstatus)
                         
			
			#array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
		);
		$pdf->ezSetDy(-10);
		$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'150')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
		$pdf->setStrokeColor(0,0,0,1);
        }
        }
	/********* Vendor/Warehouse ********/
	/*************************************/

	$Head1 = '<b>'.BILLING_ADDRESS.'</b>'; $Head2 = '<b>'.SHIPPING_ADDRESS.'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,120,$YCordLine);
	$pdf->line(324,$YCordLine,402,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arrySale[0]['Address']));
	$wAddress = str_replace("\n"," ",stripslashes($arrySale[0]['wAddress']));

	unset($data);
        //$data[][$Head1]="Company Name: ".stripslashes($arrySale[0]['CustomerCompany']);
	if(!empty($arrySale[0]['CustomerCompany']))  $data[][$Head1] = "Company Name: ".stripslashes($arrySale[0]['CustomerCompany']);
	if(!empty($arrySale[0]['Address']))  $data[][$Head1] =  "Address :".stripslashes($arrySale[0]['Address']).",";
	if(!empty($arrySale[0]['City']))  $data[][$Head1] =  "City :".stripslashes($arrySale[0]['City']);
	if(!empty($arrySale[0]['State']))  $data[][$Head1] = "State : ".stripslashes($arrySale[0]['State']);
	if(!empty($arrySale[0]['Country']))  $data[][$Head1] = "Country : ".stripslashes($arrySale[0]['Country']);
	if(!empty($arrySale[0]['ZipCode']))  $data[][$Head1] = "ZipCode : ".stripslashes($arrySale[0]['ZipCode']);
        if(!empty($arrySale[0]['Landline']))  $data[][$Head1] = "Landline : ".stripslashes($arrySale[0]['Landline']);
        if(!empty($arrySale[0]['Fax']))  $data[][$Head1] = "Fax : ".stripslashes($arrySale[0]['Fax']);
	if(!empty($arrySale[0]['Email']))  $data[][$Head1] = "Email : ".stripslashes($arrySale[0]['Email']);
	


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
                $TaxName = '[ '.$arrRate[1].' ]';

        }else{
                $TaxVal = 'None';
        }



	unset($data);
	if(!empty($arrySale[0]['ShippingName']))  $data[][$Head2] = "Shipping Name :".stripslashes($arrySale[0]['ShippingName']);
	if(!empty($arrySale[0]['ShippingCompany']))  $data[][$Head2] =  "Company Name :".stripslashes($arrySale[0]['ShippingCompany']).",";
	if(!empty($arrySale[0]['ShippingAddress']))  $data[][$Head2] =  "Address :".stripslashes($arrySale[0]['ShippingAddress']);
	if(!empty($arrySale[0]['ShippingCity']))  $data[][$Head2] = "City: ".stripslashes($arrySale[0]['ShippingCity']);
	if(!empty($arrySale[0]['ShippingState']))  $data[][$Head2] = "State: ".stripslashes($arrySale[0]['ShippingState']);
	if(!empty($arrySale[0]['ShippingCountry']))  $data[][$Head2] = "Country: ".stripslashes($arrySale[0]['ShippingCountry']);
	if(!empty($arrySale[0]['ShippingZipCode']))  $data[][$Head2] = "ZipCode: ".stripslashes($arrySale[0]['ShippingZipCode']);
        if(!empty($arrySale[0]['ShippingMobile']))  $data[][$Head2] = "Mobile: ".stripslashes($arrySale[0]['ShippingMobile']);
        if(!empty($arrySale[0]['ShippingLandline']))  $data[][$Head2] = "Landline: ".stripslashes($arrySale[0]['ShippingLandline']);
        if(!empty($arrySale[0]['ShippingFax']))  $data[][$Head2] = "Fax: ".stripslashes($arrySale[0]['ShippingFax']);
        if(!empty($arrySale[0]['ShippingEmail']))  $data[][$Head2] = "Email: ".stripslashes($arrySale[0]['ShippingEmail']);
        if(!empty($arrySale[0]['ResellerNo']))  $data[][$Head2] = "Email: ".stripslashes($arrySale[0]['ResellerNo']);
        if(!empty($Taxable))  $data[][$Head2] = "Email: ".$Taxable;
        if(!empty($TaxVal))  $data[][$Head2] = "Tax Rate".$TaxName.": ".$TaxVal;
        
        

	if(sizeof($data)>3) $ItemY = '-50';
	else $ItemY = '-140';

	
	if(sizeof($data)==0) $data[][$Head2] = NOT_MENTIONED;

	//echo '<pre>';print_r($data);exit;

	$pdf->ezSetDy($RightY);
	$pdf->ezTable($data,'','',array('cols'=>array($Head2=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>450, 'Pos' =>450 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

$pdf->ezNewPage();

	$pdf->ezSetDy($ItemY);
	$CurrencyInfo = str_replace("[Currency]",$arrySale[0]['CustomerCurrency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);


	$pdf->ezText("Tax Rate ".$TaxName.": ".$TaxVal,8,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-10);	

?>
