<?php	
	
	require_once("../includes/pdf_comman.php");

	require_once($Prefix."classes/rma.purchase.class.php");
	$objPurchase=new purchase();
	
	

	if(!empty($_GET['o'])){
		//die('cbh');
		//$arryPurchase = $objPurchase->GetPurchase($_GET['o'],'','');
		$arryPurchase = $objPurchase->GetPurchaserma($_GET['o'],'','');
		
		$OrderID   = $arryPurchase[0]['OrderID'];	
		$ModuleName = $arryPurchase[0]['Module'];
		if($OrderID>0){
			//$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$arryPurchaseItem = $objPurchase->GetPurchaseItemRMA($OrderID);
			//echo '<pre>'; print_r($arryPurchaseItem); die('testdata');
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

	 $Title = $ModuleName." # ".$arryPurchase[0]["ReturnID"];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/********* Return Detail **************/
	/*************************************/
	$Head1 = 'Left'; $Head2 = 'Right';

	$TotalAmount = $arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'];

	$ReturnDate = ($arryPurchase[0]['PostedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_MENTIONED);
	$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_MENTIONED);
	$ExpiryDate = ($arryPurchase[0]['ExpiryDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ExpiryDate']))):(NOT_MENTIONED);
	$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1)?('Yes'):('No');
	$InvoiceComment = (!empty($arryPurchase[0]['InvoiceComment']))? (stripslashes($arryPurchase[0]['InvoiceComment'])): (NOT_MENTIONED);
	$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_MENTIONED);
	$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod']))? (stripslashes($arryPurchase[0]['InvPaymentMethod'])): (NOT_MENTIONED);
	$PaymentRef = (!empty($arryPurchase[0]['PaymentRef']))? (stripslashes($arryPurchase[0]['PaymentRef'])): (NOT_MENTIONED);
	 $ReStocking = ($arryPurchase[0]['Restocking'] == 1)?('Yes'):('No');

	$data = array(
		array($Head1 => "RMA No# :", $Head2 => $arryPurchase[0]["ReturnID"]),
		array($Head1 => "RMA Date :", $Head2 => $ReturnDate),
		array($Head1 => "Item RMA Date :", $Head2 => $ReceivedDate),
		array($Head1 => "RMA Expiry Date :", $Head2 => $ExpiryDate),
		array($Head1 => "Comments :", $Head2 => $InvoiceComment),
		array($Head1 => "Total Amount :", $Head2 => $TotalAmount),
		array($Head1 => "Re-Stocking :", $Head2 => $ReStocking)
		/*array($Head1 => "RMA Amount Paid :", $Head2 => $InvoicePaid),
		array($Head1 => "Payment Date :", $Head2 => $PaymentDate),
		array($Head1 => "Payment Method :", $Head2 => $InvPaymentMethod),
		array($Head1 => "Payment Ref # :", $Head2 => $PaymentRef)*/
	);

	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);


	/********* Order Detail **************/
	/*************************************/


	require_once("includes/pdf_invoice_order_rma.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>Line Item</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,90,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
	$Head1 = '<b>SKU</b>';
	$Head2 = '<b>Condition</b>';
	$Head3 = '<b>Description</b>';
	$Head4 = '<b>Serial Number</b>';
	$Head5 = '<b>Type</b>';
	$Head6 = '<b>Action</b>'; 
	$Head7 = '<b>Reason</b>';
	$Head8 = '<b>Total Qty Invoiced</b>';
	$Head9 = '<b>Total Qty RMA</b>';
	$Head10 = '<b>Qty RMA</b>';
	$Head11 = '<b>Unit Price</b>';
	$Head12 = '<b>Taxable</b>';
	$Head13 = '<b>Amount</b>';

        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6; $arryDef[$i][$Head7] = $Head7; $arryDef[$i][$Head8] = $Head8; $arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;$arryDef[$i][$Head11] = $Head11;$arryDef[$i][$Head12] = $Head12;$arryDef[$i][$Head13] = $Head13;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
		$qty_ordered = $objPurchase->GetQtyOrderded($arryPurchaseItem[$Count]["ref_id"]);	
		$total_invoiced = $objPurchase->GetQtyInvoiced($arryPurchaseItem[$Count]["ref_id"]);	

		$total_returned = $objPurchase->GetQtyReturned($arryPurchaseItem[$Count]["ref_id"]);
		
		$total_rma = $objPurchase->GetQtyRma($arryPurchaseItem[$Count]["ref_id"]);

		$comment=(!empty($arryPurchaseItem[$Count]["PurchaseComment"]))?("\r\n"."<b>Comment: </b>".stripslashes($arryPurchaseItem[$Count]["PurchaseComment"])):("");
	if($arryPurchase[0]['tax_auths']=='Yes' && $arryPurchaseItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';

            $arryDef[$i][$Head1] = stripslashes($arryPurchaseItem[$Count]["sku"]);
	    $arryDef[$i][$Head2] = stripslashes($arryPurchaseItem[$Count]["Condition"]);
            $arryDef[$i][$Head3] = stripslashes($arryPurchaseItem[$Count]["description"]).$comment;
            $arryDef[$i][$Head4] = $arryPurchaseItem[$Count]["SerialNumbers"];
            $arryDef[$i][$Head5] = stripslashes($arryPurchaseItem[$Count]["Type"]);
            $arryDef[$i][$Head6] = stripslashes($arryPurchaseItem[$Count]["Action"]);
            $arryDef[$i][$Head7] = stripslashes($arryPurchaseItem[$Count]["Reason"]);
            $arryDef[$i][$Head8] = $total_invoiced;
            $arryDef[$i][$Head9] = number_format($total_rma);
            $arryDef[$i][$Head10] = $arryPurchaseItem[$Count]["qty"];
		$arryDef[$i][$Head11] = number_format($arryPurchaseItem[$Count]["price"],2);
		$arryDef[$i][$Head12] = $arryPurchaseItem[$Count]['Taxable'];
		$arryDef[$i][$Head13] = number_format($arryPurchaseItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryPurchaseItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'35'),$Head2=>array('justification'=>'left', 'width'=>'40'),$Head3=>array('justification'=>'left','width'=>'40'),$Head4=>array('justification'=>'left','width'=>'40'),$Head5=>array('justification'=>'left','width'=>'45'),$Head6=>array('justification'=>'left','width'=>'40'),$Head7=>array('justification'=>'left','width'=>'50'),$Head8=>array('justification'=>'left','width'=>'50'),$Head9=>array('justification'=>'right','width'=>'40'),$Head10=>array('justification'=>'right','width'=>'40'),$Head11=>array('justification'=>'right','width'=>'40'),$Head12=>array('justification'=>'right','width'=>'40'),$Head13=>array('justification'=>'right','width'=>'40')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );

        $pdf->setStrokeColor(0,0,0,1);




		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);
		if($arryPurchase[0]['Restocking'] == 1){
			$Restock = "\nRe-Stocking Fee : ". number_format($arryPurchase[0]['Restocking_fee'],2);
		}

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight : ".$Freight.$Restock."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));



    }











	/***********************************/
	//$pdf->ezStream(); exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arryPurchase[0]["ReturnID"].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>
