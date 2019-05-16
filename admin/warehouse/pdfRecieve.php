<?	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/inbound.class.php");
	

	$objInbound=new inbound();

	$ModuleName = "Recieve";

	if(!empty($_GET['o'])){
		$arryPurchase = $objInbound->GetWOrder($_GET['o'],'','');
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objInbound->GetWarehouseItem($OrderID);
			
			$NumLine = sizeof($arryPurchaseItem);
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
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

	 $Title = $ModuleName." # ".$arryPurchase[0]["RecieveID"];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/********* Return Detail **************/
	/*************************************/
	$Head1 = 'Left'; $Head2 = 'Right';

	$TotalAmount = $arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'];

	$ReturnDate = ($arryPurchase[0]['PostedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_MENTIONED);
	$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_MENTIONED);
	$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1)?('Yes'):('No');
	$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment']))? (stripslashes($arryPurchase[0]['InvoiceComment'])): (NOT_MENTIONED);
	$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_MENTIONED);
	$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod']))? (stripslashes($arryPurchase[0]['InvPaymentMethod'])): (NOT_MENTIONED);
	$PaymentRef = (!empty($arryPurchase[0]['PaymentRef']))? (stripslashes($arryPurchase[0]['PaymentRef'])): (NOT_MENTIONED);

	$data = array(
		array($Head1 => "Recieve No# :", $Head2 => $arryPurchase[0]["RecieveID"]),
		array($Head1 => "Recieve Date :", $Head2 => $ReturnDate),
		array($Head1 => "Item Recieve Date :", $Head2 => $ReceivedDate),
		array($Head1 => "Comments :", $Head2 => $InvoiceComment),

		array($Head1 => "Total Amount :", $Head2 => $TotalAmount),
		array($Head1 => "Recieve Amount Paid :", $Head2 => $InvoicePaid),
		array($Head1 => "Payment Date :", $Head2 => $PaymentDate),
		array($Head1 => "Payment Method :", $Head2 => $InvPaymentMethod),
		array($Head1 => "Payment Ref # :", $Head2 => $PaymentRef)
	);

	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);


	/********* Order Detail **************/
	/*************************************/
	$pdf->ezSetDy(-10);
	$pdf->ezText("<b>Order Information</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,126,$YCordLine);

	require_once("includes/pdf_order.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".RETURN_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,105,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>';$Head2 = '<b>Condition</b>'; $Head3 = '<b>Description</b>'; $Head4 = '<b>Qty Ordered</b>'; $Head5 = '<b>PO Qty Received</b>'; $Head6 = '<b>Total Qty Returned</b>'; $Head7 = '<b>Qty Recieved</b>'; $Head8 = '<b>Unit Price</b>'; $Head9 = '<b>Tax Rate</b>'; $Head10 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6; $arryDef[$i][$Head7] = $Head7; $arryDef[$i][$Head8] = $Head8; $arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			$qty_ordered = $objInbound->GetQtyOrderdedInWarehouse($arryPurchaseItem[$Count]["ref_id"]);	
			$total_received = $objInbound->GetQtyReceivedInWarehouse($arryPurchaseItem[$Count]["ref_id"]);	
			$total_returned = $objInbound->GetQtyReturnedInWarehouse($arryPurchaseItem[$Count]["ref_id"]);

			if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				$Rate = $arryPurchaseItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arryPurchaseItem[$Count]["tax"],2);

            $arryDef[$i][$Head1] = stripslashes($arryPurchaseItem[$Count]["sku"]);
	    $arryDef[$i][$Head2] = stripslashes($arryPurchaseItem[$Count]["Condition"]);
            $arryDef[$i][$Head3] = stripslashes($arryPurchaseItem[$Count]["description"]);
            $arryDef[$i][$Head4] = $arryPurchaseItem[$Count]["qty"];
            $arryDef[$i][$Head5] = $arryPurchaseItem[$Count]["qty_received"];
            $arryDef[$i][$Head6] = $total_returned;
            $arryDef[$i][$Head7] = $arryPurchaseItem[$Count]["qty_wRecieved"];
            $arryDef[$i][$Head8] = number_format($arryPurchaseItem[$Count]["price"],2);
            $arryDef[$i][$Head9] = $TaxRate;
            $arryDef[$i][$Head10] = number_format($arryPurchaseItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryPurchaseItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'45'),$Head2=>array('justification'=>'left','width'=>'45'),$Head3=>array('justification'=>'left'),$Head4=>array('justification'=>'left','width'=>'45'),$Head5=>array('justification'=>'left','width'=>'55'),$Head6=>array('justification'=>'left','width'=>'55'),$Head7=>array('justification'=>'left','width'=>'45'),$Head8=>array('justification'=>'left','width'=>'55'),$Head9=>array('justification'=>'right','width'=>'60'),$Head10=>array('justification'=>'right','width'=>'55')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		$TotalTxt =  "Sub Total : ".$subtotal."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));



    }











	/***********************************/
	#$pdf->ezStream(); exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arryPurchase[0]["RecieveID"].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>