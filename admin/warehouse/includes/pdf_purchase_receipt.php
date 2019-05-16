<?




	/********* Order Detail **************/
	/*************************************/

	if(empty($ModuleID)){
		$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; 
	}
	
	$arryInvoice = $objPurchase->GetPurchaseInvoice('', $arryPurchase[0]["InvoiceID"] ,'Invoice');

	$PostedDate = ($arryInvoice[0]['PostedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryInvoice[0]['PostedDate']))):(NOT_MENTIONED);
	
	
	$InvoiceComment = (!empty($arryInvoice[0]['InvoiceComment']))? (stripslashes($arryInvoice[0]['InvoiceComment'])): (NOT_MENTIONED);
	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Invoice # :", $Head2 => $arryInvoice[0]["InvoiceID"]),
		array($Head1 => "Invoice Date :", $Head2 => $PostedDate),		
		array($Head1 => "Comments :", $Head2 => $InvoiceComment)
		#array($Head1 => "Assigned To :", $Head2 => $AssignedEmp)
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

/********* Order Detail **************/

?>
