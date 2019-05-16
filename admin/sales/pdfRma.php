<?	
    require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/rma.sales.class.php");
	$objSale=new sale();
	$objrmasale = new rmasale();
    $ModuleIDTitle = "RMA Number"; $ModuleID = "ReturnID"; $PrefixSO = "RTN";  $NotExist = NOT_EXIST_Return;

	if(!empty($_GET['RTN'])){
		$arrySale = $objSale->GetSale($_GET['RTN'],'','');
		$OrderID   = $arrySale[0]['OrderID'];	
		$ModuleName = $arrySale[0]['Module'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
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

	 $Title = $ModuleName." Number# ".$arrySale[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/

	require_once("includes/pdf_return.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Condition</b>'; $Head3 = '<b>Description</b>';
	$Head4 = '<b>Type</b>'; $Head5 = '<b>Action</b>'; $Head6 = '<b>Reason</b>';	

 $Head7 = '<b>Qty Invoiced</b>'; $Head8 = '<b>Total RMA Qty</b>'; $Head9 = '<b>Qty RMA</b>';  $Head10 = '<b>Unit Price</b>'; $Head11 = '<b>Discount</b>'; $Head12 = '<b>Taxable</b>'; $Head13 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5; $arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7; $arryDef[$i][$Head8] = $Head8;$arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;
$arryDef[$i][$Head11] = $Head11; $arryDef[$i][$Head12] = $Head12; $arryDef[$i][$Head13] = $Head13;

        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			$total_received = $objrmasale->GetQtyInvoicedRma($arrySaleItem[$Count]["ref_id"]);
			$ordered_qty = $arrySaleItem[$Count]["qty"];
			$qty_invoiced = $arrySaleItem[$Count]["qty_invoiced"];
			$qty_returned = $arrySaleItem[$Count]["qty_returned"];
			
			$totalRmaQty = $objrmasale->GetQtyRma($arrySaleItem[$Count]["ref_id"]);

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
                        
                        $Type = $objrmasale->RmaTypeValue($arrySaleItem[$Count]["Type"]);

		    $arryDef[$i][$Head1] = stripslashes($arrySaleItem[$Count]["sku"]);
		    $arryDef[$i][$Head2] = stripslashes($arrySaleItem[$Count]["Condition"]);
		    $arryDef[$i][$Head3] = stripslashes($arrySaleItem[$Count]["description"]);

		    $arryDef[$i][$Head4] = $Type;
		    $arryDef[$i][$Head5] = stripslashes($arrySaleItem[$Count]["Action"]);
		    $arryDef[$i][$Head6] = stripslashes($arrySaleItem[$Count]["Reason"]);

		    $arryDef[$i][$Head7] = $total_received;
		    $arryDef[$i][$Head8] = $totalRmaQty[0]['QtyRma'];
		    $arryDef[$i][$Head9] = $arrySaleItem[$Count]["qty"];
		    $arryDef[$i][$Head10] = number_format($arrySaleItem[$Count]["price"],2);
		    $arryDef[$i][$Head11] = number_format($arrySaleItem[$Count]["discount"],2);
		    $arryDef[$i][$Head12] = $arrySaleItem[$Count]['Taxable'];
		    $arryDef[$i][$Head13] = number_format($arrySaleItem[$Count]["amount"],2);
		    $data[] = $arryDef[$i];
		    $i++;

			$subtotal += $arrySaleItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'50'),$Head3=>array('justification'=>'left','width'=>'50'),$Head4=>array('justification'=>'left','width'=>'40'),$Head5=>array('justification'=>'left','width'=>'40'),$Head6=>array('justification'=>'left','width'=>'40'),$Head7=>array('justification'=>'left','width'=>'50'),$Head8=>array('justification'=>'left','width'=>'40'),$Head13=>array('justification'=>'right')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>580,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
		$ReStocking = number_format($arrySale[0]['ReStocking'],2);
		$Freight = number_format($arrySale[0]['Freight'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);
		
		if($arrySale[0]['ReSt']==1){
			$ReStVal= "\nRe-Stocking Fee : ".$ReStocking;
			
		}

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight : ".$Freight.$ReStVal."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		/*if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}*/



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
    
    
    
    
  // $pdf->ezStream();exit;
    
    
    
	$file_path = 'upload/pdf/'.$arrySale[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>
