<?	
    require_once("../includes/pdf_comman.php");
    require_once($Prefix . "classes/rma.purchase.class.php");
 require_once($Prefix."classes/warehouse.purchase.rma.class.php");

	$objWarehouse=new warehouse();
        $objPurchase = new purchase();
	$module = 'Receipt';

    $ModuleIDTitle = "Receipt Number"; $ModuleID = "ReceiptNo"; $PrefixSO = "RCPT";  $NotExist = NOT_EXIST_Return;
	$ModuleName = $module;

	if(!empty($_GET['RCPT'])){
				
		$arryPurchase = $objWarehouse->GetPurchaseReceipt($_GET['RCPT'],'','');
               //echo "<pre>";
               // print_r($arryPurchase);
                //exit;
		$ReturnID   = $arryPurchase[0]['ReturnID'];	
		$InvoiceID = $arryPurchase[0]["InvoiceID"];
		
		//echo "==========>".$ReturnID;
		
	    if($ReturnID!=''){
			$arryRMA = $objWarehouse->GetPORma('',$ReturnID,'RMA');
			//echo "<br>";
			//echo "<br>";
			// echo "<pre>";
               // print_r($arryRMA);
               // exit;
		}
		$OrderID   = $arryPurchase[0]['ReceiptID'];	
		if($OrderID>0){
			//echo "hi";
			$arryPurchaseItem = $objWarehouse->GetPurchaseReceiptItem($OrderID,'');
			$NumLine = sizeof($arryPurchaseItem);
			
			//$ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($arryPurchaseItem[0]["OrderID"],$arryPurchaseItem[0]["item_id"]);
			
			//get payment history
			 //$arryPaymentInvoice = $objPurchase->GetPaymentInvoice($OrderID);
			
		}else{
			//echo "hi";
			$ErrorMSG = $NotExist;
		}
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

	/*******************************************/
	if(!empty($arryPurchase[0]['CreatedByEmail'])){
		$arryCompany[0]['Email']=$arryPurchase[0]['CreatedByEmail'];
	}
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = " Receipt Number# ".$arryPurchase[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/
	 
	 /********* Return Detail **************/
	/*************************************/
	$Head1 = 'Left'; $Head2 = 'Right';

	///$TotalAmount = $arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'];

	$ReturnDate = ($arryPurchase[0]['PostedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_MENTIONED);
	$ReceivedDate = ($arryPurchase[0]['ReceiptDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['ReceiptDate']))):(NOT_MENTIONED);
	$InvoicePaid = ($arryPurchase[0]['InvoicePaid'] == 1)?('Yes'):('No');
	$InvoiceComment = (!empty($arryPurchase[0]['ReceiptComment']))? (stripslashes($arryPurchase[0]['ReceiptComment'])): (NOT_MENTIONED);
    $ReceiptStatus = $arryPurchase[0]['ReceiptStatus'];
$ReStocking = ($arryRMA[0]['Restocking'] == 1)?('Yes'):('No');
	$data = array(
		array($Head1 => "RMA No# :", $Head2 => $arryPurchase[0]["ReturnID"]),
		array($Head1 => "RMA Date :", $Head2 => $ReturnDate),
		array($Head1 => "Item RMA Date :", $Head2 => $ReceivedDate),
		array($Head1 => "Comments :", $Head2 => $InvoiceComment),
		array($Head1 => "Receipt Status :", $Head2 => $ReceiptStatus),
		array($Head1 => "Re-Stocking :", $Head2 => $ReStocking)
	);

	$pdf->ezSetDy(-5);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	 
    require_once("includes/pdf_purchase_receipt.php");
	require_once("includes/pdf_purchase_rma.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",14,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Condition</b>';$Head3 = '<b>Description</b>'; $Head4 = '<b>Serial Number</b>'; $Head5 = '<b>Type</b>'; $Head6 = '<b>Action</b>'; $Head7 = '<b>Reason</b>'; $Head8 = '<b>Qty RMA</b>'; $Head9 = '<b>Total Qty Returned</b>'; $Head10 = '<b>Qty Returned</b>'; $Head11 = '<b>Unit Price</b>';  $Head12 = '<b>Taxable</b>'; $Head13 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;$arryDef[$i][$Head8] = $Head8;$arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;$arryDef[$i][$Head11] = $Head11;$arryDef[$i][$Head12] = $Head12;$arryDef[$i][$Head13] = $Head13; 
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			//$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["id"]);
			$ordered_qty = $arryPurchaseItem[$Count]["qty"];
			$qty_invoiced = $arryPurchaseItem[$Count]["qty_invoiced"];
			$qty_returned = $arryPurchaseItem[$Count]["qty_receipt"];

			$Type = $objWarehouse->WHRmaTypeValue($arryPurchaseItem[$Count]["Type"]);
			$ValReciept = $objWarehouse->GetPurchaseSumQtyReceipt($arryPurchaseItem[$Count]["OrderID"],$arryPurchaseItem[$Count]["item_id"]);
			
			 
			$Action = $arryPurchaseItem[$Count]["Action"];
			$Reason = $arryPurchaseItem[$Count]["Reason"];
			
			if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				$Rate = $arryPurchaseItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arryPurchaseItem[$Count]["tax"],2);
                        
                        
                         if($arryPurchaseItem[$Count]["DropshipCheck"] == 1){
                            $DropshipCheck = 'Yes';
                        }else{
                            $DropshipCheck = 'No';
                            $ds = 1;
                        }
                        
                        

            $arryDef[$i][$Head1] = stripslashes($arryPurchaseItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arryPurchaseItem[$Count]["Condition"]);
            $arryDef[$i][$Head3] = stripslashes($arryPurchaseItem[$Count]["description"]);
            $arryDef[$i][$Head4] = $arryPurchaseItem[$Count]["SerialNumbers"];
            $arryDef[$i][$Head5] = $Type;
            $arryDef[$i][$Head6] = $Action;
            $arryDef[$i][$Head7] = $Reason;
            $arryDef[$i][$Head8] = number_format($ordered_qty);
			$arryDef[$i][$Head9] = number_format($ValReciept);
			$arryDef[$i][$Head10] = number_format($qty_returned);
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
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),
        $Head2=>array('justification'=>'left','width'=>'50'),
        $Head3=>array('justification'=>'left','width'=>'60'),
        $Head4=>array('justification'=>'left','width'=>'40'),
        $Head5=>array('justification'=>'left','width'=>'40'),
        $Head6=>array('justification'=>'left','width'=>'40'),
        $Head7=>array('justification'=>'left','width'=>'40'),
        $Head8=>array('justification'=>'left','width'=>'40'),
        $Head9=>array('justification'=>'left','width'=>'40'),
        $Head10=>array('justification'=>'left','width'=>'40'),
        $Head11=>array('justification'=>'left','width'=>'40'),
        $Head12=>array('justification'=>'left','width'=>'40'),
        $Head13=>array('justification'=>'right')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalReceiptAmount'],2);
		if($arryRMA[0]['Restocking'] == 1){
			$Restock = "\nRe-Stocking Fee : ". number_format($arryPurchase[0]['Restocking_fee'],2);
		}

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight : ".$Freight.$Restock."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}



    }

    
    
	$file_path = 'upload/pdf/'.$arryPurchase[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>
