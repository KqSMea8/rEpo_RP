<?	require_once("../includes/pdf_comman.php");
		require_once($Prefix."classes/sales.quote.order.class.php");
	

	$objSale=new sale();
	
	$module = 'Invoice';

    $ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSO = "IN";  $NotExist = NOT_EXIST_INVOICE;
	$ModuleName = $module;

	if(!empty($_GET['IN'])){
		$arrySale = $objSale->GetSale($_GET['IN'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			//get payment history
			 $arryPaymentInvoice = $objSale->GetPaymentInvoice($OrderID);
			
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

	 $Title = $ModuleName." Number# ".$arrySale[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/

	require_once("includes/pdf_invoice.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
		$Head1 = '<b>SKU</b>';
		$Head2 = '<b>Condition</b>'; 
		$Head3 = '<b>Description</b>'; 
		$Head4 = '<b>Qty Ordered</b>'; 
		$Head5 = '<b>Qty Invoiced</b>';
		$Head6 = '<b>Unit Price</b>'; 
		$Head7 = '<b>Discount</b>';
		$Head8 = '<b>Tax Rate</b>'; 
		$Head9 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;$arryDef[$i][$Head8] = $Head8;$arryDef[$i][$Head9] = $Head9;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			$total_received = $objSale->GetQtyInvoiced($arrySaleItem[$Count]["id"]);
			$ordered_qty = $arrySaleItem[$Count]["qty"];

			if(!empty($arrySaleItem[$Count]["RateDescription"]))
				$Rate = $arrySaleItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arrySaleItem[$Count]["tax"],2);

			    $arryDef[$i][$Head1] = stripslashes($arrySaleItem[$Count]["sku"]);
			    $arryDef[$i][$Head2] = stripslashes($arrySaleItem[$Count]["Condition"]);
			    $arryDef[$i][$Head3] = stripslashes($arrySaleItem[$Count]["description"]);
			    $arryDef[$i][$Head4] = $arrySaleItem[$Count]["qty"];
			    $arryDef[$i][$Head5] = $arrySaleItem[$Count]["qty_invoiced"];
			    $arryDef[$i][$Head6] = number_format($arrySaleItem[$Count]["price"],2);
			    $arryDef[$i][$Head7] = number_format($arrySaleItem[$Count]["discount"],2);
			    $arryDef[$i][$Head8] = $TaxRate;
			    $arryDef[$i][$Head9] = number_format($arrySaleItem[$Count]["amount"],2);
			    $data[] = $arryDef[$i];
			    $i++;

			$subtotal += $arrySaleItem[$Count]["amount"];
			//$TotalQtyReceived += $total_received;
			//$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'50'),$Head3=>array('justification'=>'left'),$Head4=>array('justification'=>'left','width'=>'60'),$Head5=>array('justification'=>'left','width'=>'90'),$Head6=>array('justification'=>'left','width'=>'60'),$Head7=>array('justification'=>'left','width'=>'80'),$Head8=>array('justification'=>'right','width'=>'60'),$Head9=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


	/*	$Freight = number_format($arrySale[0]['Freight'],2);
		$subtotal = number_format($subtotal,2);
	
		if($Freight > 0){
		 $TotalAmount = $subtotal+$Freight;	
		 }
		 else{$TotalAmount = $subtotal;
		 }
		 $TotalAmount = number_format($TotalAmount,2,'.',',');

		$TotalTxt =  "Sub Total : ".$subtotal."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;

             */

                $Freight = number_format($arrySale[0]['Freight'],2);
		$subtotal = number_format($subtotal,2);
		$CustDisAmt = number_format($arrySale[0]['CustDisAmt'],2);
		if($Freight > 0){
		 $TotalAmount = $subtotal+$Freight;	
		 }
		 else{$TotalAmount = $subtotal;
		 }
	
		 $TotalAmount = $subtotal+$taxAmnt+$Freight-$CustDisAmt;
		 $TotalAmount = number_format($TotalAmount,2,'.',',');

		$TotalTxt .=  "Sub Total : ".$subtotal;
		$TotalTxt .= "\nTax : ".$taxAmnt;
		if($arrySale[0]['MDType'])$TotalTxt .="\n".$arrySale[0]['MDType'].":".$CustDisAmt;
		$TotalTxt .= "\nFreight : ".$Freight;
		$TotalTxt .= "\nGrand Total : ".$TotalAmount;



		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		/*if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}*/



    }



    /********* payment history ***************/
	/*************************************
	$pdf->ezText("<b>".PAYMENT_HISTORY."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,120,$YCordLine);
	$pdf->ezSetDy(-5);
    if(count($arryPaymentInvoice) > 0)
	{
	    $Head1 = '<b>InvoiceID</b>'; $Head2 = '<b>Cust Code</b>'; $Head3 = '<b>Payment Method</b>'; $Head4 = '<b>Payment Date</b>'; $Head5 = '<b>Reference No.</b>'; $Head6 = '<b>Comment</b>'; $Head7 = '<b>Paid Amount </b>'; 
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

	
	}
	*/





	/***********************************/
	//$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arrySale[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>
