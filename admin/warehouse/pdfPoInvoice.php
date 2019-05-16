<?	require_once("../includes/pdf_comman.php"); 
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase=new purchase();


	

	$ModuleName = "Invoice";

	if(!empty($_GET['o'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['o'],'','Invoice');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);

			/****************************
			$arryOrder = $objPurchase->GetPurchase('',$arryPurchase[0]['PurchaseID'],'Order');
			$arryPurchase[0]['Status'] = $arryOrder[0]['Status'];
			/////////*/

		}else{
			$ErrorMSG = NOT_EXIST_INVOICE;
		}
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}


	/*******************************************/
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = $ModuleName." # ".$arryPurchase[0]["InvoiceID"];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/********* Invoice Detail **************/
	/*************************************/
	$Head1 = 'Left'; $Head2 = 'Right';

	$TotalAmount = $arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'];

	$InvoiceDate = ($arryPurchase[0]['PostedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_MENTIONED);
	$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_MENTIONED);
	$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_MENTIONED);
	$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1)?('Yes'):('No');
	$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment']))? (stripslashes($arryPurchase[0]['InvoiceComment'])): (NOT_MENTIONED);
	$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod']))? (stripslashes($arryPurchase[0]['InvPaymentMethod'])): (NOT_MENTIONED);
	$PaymentRef = (!empty($arryPurchase[0]['PaymentRef']))? (stripslashes($arryPurchase[0]['PaymentRef'])): (NOT_MENTIONED);

	$data = array(
		array($Head1 => "Invoice # :", $Head2 => $arryPurchase[0]["InvoiceID"]),
		array($Head1 => "Invoice Date :", $Head2 => $InvoiceDate),
		array($Head1 => "Item Received Date :", $Head2 => $ReceivedDate),
		array($Head1 => "Comments :", $Head2 => $InvoiceComment)
		/*array($Head1 => "Total Amount :", $Head2 => $TotalAmount),
		array($Head1 => "Invoice Paid :", $Head2 => $InvoicePaid),
		array($Head1 => "Payment Date :", $Head2 => $PaymentDate),
		array($Head1 => "Payment Method :", $Head2 => $InvPaymentMethod),
		array($Head1 => "Payment Ref # :", $Head2 => $PaymentRef)*/
	);
	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);


	/********* Order Detail **************/
	/*************************************/
	if($arryPurchase[0]['InvoiceEntry'] == 0){ 
		$pdf->ezSetDy(-10);
		$pdf->ezText("<b>Order Information</b>",9,array('justification'=>'left', 'spacing'=>'1'));
		$YCordLine = $pdf->y-5; 
		$pdf->line(50,$YCordLine,126,$YCordLine);
	}
	require_once("includes/pdf_po_order.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".RECEIVED_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,115,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>';$Head2 = '<b>Condition</b>'; $Head3 = '<b>Description</b>'; $Head4 = '<b>Qty Ordered</b>'; $Head5 = '<b>Total Qty Received</b>'; $Head6 = '<b>Qty Received</b>'; $Head7 = '<b>Unit Price</b>'; $Head8 = '<b>Dropship Cost</b>'; $Head9 = '<b>Taxable</b>'; $Head10 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6; $arryDef[$i][$Head7] = $Head7; $arryDef[$i][$Head8] = $Head8; $arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);	
			$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["ref_id"]);	
                        $sku = stripslashes($arryPurchaseItem[$Count]["sku"]);
                        
			if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				$Rate = $arryPurchaseItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arryPurchaseItem[$Count]["tax"],2);

 		if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';
                
                if(!empty($arryPurchaseItem[$Count]["SerialNumbers"])){
                           $arrySlNo[$sku] = $arryPurchaseItem[$Count]["SerialNumbers"];
                        }


            $arryDef[$i][$Head1] = stripslashes($arryPurchaseItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arryPurchaseItem[$Count]["Condition"]);
	    $arryDef[$i][$Head3] = stripslashes($arryPurchaseItem[$Count]["description"]);
            $arryDef[$i][$Head4] = $qty_ordered;
            $arryDef[$i][$Head5] = $total_received;
            $arryDef[$i][$Head6] = $arryPurchaseItem[$Count]["qty_received"];
            $arryDef[$i][$Head7] = number_format($arryPurchaseItem[$Count]["price"],2);
	    if($arryPurchase[0]['OrderType']=='Dropship' ){ 
	    $arryDef[$i][$Head8] = number_format($arryPurchaseItem[$Count]["DropshipCost"],2);
	    }
            $arryDef[$i][$Head9] = $arryPurchaseItem[$Count]['Taxable'];
            $arryDef[$i][$Head10] = number_format($arryPurchaseItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryPurchaseItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'50'),$Head3=>array('justification'=>'left',),$Head4=>array('justification'=>'left','width'=>'40'),$Head5=>array('justification'=>'left','width'=>'50'),$Head6=>array('justification'=>'left','width'=>'50'),$Head7=>array('justification'=>'left','width'=>'50'),$Head8=>array('justification'=>'left','width'=>'60'),$Head9=>array('justification'=>'right','width'=>'40'),$Head10=>array('justification'=>'right','width'=>'70')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);	
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));



    }





  /********* CODE FOR SERIAL NUMBER ***************/
    
    if(sizeof($arrySlNo)>0){
	$pdf->ezSetDy(-5);
        $SerialHead1 = '<b>SKU</b>'; $SerialHead2 = '<b>Serial Number</b>';
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
                $pdf->ezTable($Serialdata,'','',array('cols'=>array($SerialHead1=>array('justification'=>'left','width'=>'65'),$SerialHead2=>array('justification'=>'left','width'=>'435')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
                $pdf->setStrokeColor(0,0,0,1);

		

      }


    /********* END CODE FOR SERIAL NUMBER ***************/





	/***********************************/
	//$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arryPurchase[0]["InvoiceID"].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;
?>
