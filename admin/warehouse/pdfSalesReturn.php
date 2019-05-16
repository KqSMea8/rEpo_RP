<?	
    require_once("../includes/pdf_comman.php");
    require_once($Prefix . "classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	
	$objWarehouse=new warehouse();
        $objSale = new sale();
	$module = 'Receipt';

    $ModuleIDTitle = "Receipt Number"; $ModuleID = "ReceiptNo"; $PrefixSO = "RCPT";  $NotExist = NOT_EXIST_Return;
	$ModuleName = $module;

	if(!empty($_GET['RCPT'])){
		$arrySale = $objWarehouse->GetReceipt($_GET['RCPT'],'',$module);
               /* echo "<pre>";
                print_r($arrySale );
                exit;*/
		$OrderID   = $arrySale[0]['ReceiptID'];	
		if($OrderID>0){
			$arrySaleItem = $objWarehouse->GetSaleReceiptItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			//get payment history
			 //$arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
			
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

	/*******************************************/
	if(!empty($arrySale[0]['CreatedByEmail'])){
		$arryCompany[0]['Email']=$arrySale[0]['CreatedByEmail'];
	}
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = " Receipt Number# ".$arrySale[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/
        require_once("includes/pdf_sales_receipt.php");
	require_once("includes/pdf_sales_return.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Description</b>'; $Head3 = '<b>Qty Ordered</b>'; $Head4 = '<b>Qty Returned</b>'; $Head5 = '<b>Qty Receipt</b>'; $Head6 = '<b>Unit Price</b>'; $Head7 = '<b>Discount</b>'; $Head8 = '<b>Taxable</b>'; $Head9 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;$arryDef[$i][$Head8] = $Head8;$arryDef[$i][$Head9] = $Head9;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			//$total_received = $objSale->GetQtyReceived($arrySaleItem[$Count]["id"]);
			$ordered_qty = $arrySaleItem[$Count]["qty"];
			$qty_invoiced = $arrySaleItem[$Count]["qty_returned"];
			$qty_returned = $arrySaleItem[$Count]["qty_receipt"];
			
			if(!empty($arrySaleItem[$Count]["RateDescription"]))
				$Rate = $arrySaleItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arrySaleItem[$Count]["tax"],2);
                        
                        
                         if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                            $DropshipCheck = 'Yes';
                        }else{
                            $DropshipCheck = 'No';
                            $ds = 1;
                        }

			if(!empty($arrySaleItem[$Count]["SerialNumbers"])){
                           $arrySlNo[$sku] = $arrySaleItem[$Count]["SerialNumbers"];
                        }
                        
                        

            $arryDef[$i][$Head1] = stripslashes($arrySaleItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arrySaleItem[$Count]["description"]);
            $arryDef[$i][$Head3] = $arrySaleItem[$Count]["qty"];
            $arryDef[$i][$Head4] = number_format($qty_invoiced);
			$arryDef[$i][$Head5] = number_format($qty_returned);
            $arryDef[$i][$Head6] = number_format($arrySaleItem[$Count]["price"],2);
            $arryDef[$i][$Head7] = number_format($arrySaleItem[$Count]["discount"],2);
            $arryDef[$i][$Head8] = $arrySaleItem[$Count]['Taxable'];
            $arryDef[$i][$Head9] = number_format($arrySaleItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arrySaleItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'100'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'60'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'50'),$Head7=>array('justification'=>'left','width'=>'40'),$Head9=>array('justification'=>'right')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
		$Freight = number_format($arrySale[0]['Freight'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}



    }



    /********* payment history ***************/
	/*************************************/
	/*$pdf->ezText("<b>".PAYMENT_HISTORY."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,120,$YCordLine);
	$pdf->ezSetDy(-5);
    if(count($arryPaymentInvoice) > 0)
	{
	    $Head1 = '<b>ReturnID</b>'; $Head2 = '<b>Cust Code</b>'; $Head3 = '<b>Payment Method</b>'; $Head4 = '<b>Payment Date</b>'; $Head5 = '<b>Reference No.</b>'; $Head6 = '<b>Comment</b>'; $Head7 = '<b>Paid Amount </b>'; 
	    $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;
        $data[] = $arryDef[$i];
        $i++;
		$TotalAmount = 0;
		foreach($arryPaymentInvoice as $value) {
		
            $arryDef[$i][$Head1] = $value['InvoiceID'];
            $arryDef[$i][$Head2] = $value['CustCode'];
            $arryDef[$i][$Head3] = $value['PaidMethod'];
            $arryDef[$i][$Head4] = $value['PaidDate'];
            $arryDef[$i][$Head5] = $value['PaidReferenceNo'];
            $arryDef[$i][$Head6] = $value['PaidComment'];
            $arryDef[$i][$Head7] = $value['PaidAmount'];
            $data[] = $arryDef[$i];
            $i++;

			$TotalAmount += $value["PaidAmount"];
			 

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'60'),$Head3=>array('justification'=>'left','width'=>'80'),$Head4=>array('justification'=>'left','width'=>'60'),$Head5=>array('justification'=>'left','width'=>'80'),$Head6=>array('justification'=>'left'),$Head7=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		 
		$TotalAmount = number_format($TotalAmount,2);

		$TotalTxt =  "Grand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

	
	}*/






	/***********************************/
	//$pdf->ezStream();exit;

	// or write to a file
    
      /********* CODE FOR SERIAL NUMBER ***************/
    
    if(sizeof($arrySlNo)>0){
	$pdf->ezSetDy(-5);
        $SerialHead1 = '<b>SKU</b>'; $SerialHead2 = '<b>Serial NUmber</b>';
        $j=0;unset($Serialdata); unset($SerialarryDef);

        $SerialarryDef[$j][$SerialHead1] = $SerialHead1;$SerialarryDef[$j][$SerialHead2] = $SerialHead2;
        $Serialdata[] = $SerialarryDef[$j];
        $j++;
		$subtotal=0; 
		foreach($arrySlNo as $key=>$values){
			$Count=$Line-1;				
			$SerialNumbers = preg_replace('/\s+/', ' ', $values);

			$SerialarryDef[$j][$SerialHead1] = $key;
			$SerialarryDef[$j][$SerialHead2] = $SerialNumbers;

			$Serialdata[] = $SerialarryDef[$j];
			$j++;                         
			 

       		 }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
                $pdf->ezTable($Serialdata,'','',array('cols'=>array($SerialHead1=>array('justification'=>'left','width'=>'65'),$SerialHead2=>array('justification'=>'left','width'=>'502')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
                $pdf->setStrokeColor(0,0,0,1);

		

      }


    /********* END CODE FOR SERIAL NUMBER ***************/
    
    
    
    
    
    
    
    
	$file_path = 'upload/pdf/'.$arrySale[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>
