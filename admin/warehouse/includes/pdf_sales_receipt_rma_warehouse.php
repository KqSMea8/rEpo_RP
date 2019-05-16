<?
	/********* Order Detail **************/
	/*************************************/
	if(empty($ModuleID)){
		$ModuleIDReceipt = "Receipt Number"; $ModuleReceiptID = "ReceiptNo"; 
	}


	$ReceiptDate = ($arrySale[0]['ReceiptDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['ReceiptDate']))):(NOT_MENTIONED);
	$ReceiptComment = (!empty($arrySale[0]['ReceiptComment']))? (stripslashes($arrySale[0]['ReceiptComment'])): (NOT_MENTIONED);
        
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		//array($Head1 => $ModuleIDReceipt."# :", $Head2 => $arrySale[0][$ModuleReceiptID]),
		array($Head1 => "Receipt Date :", $Head2 => $ReceiptDate),
		array($Head1 => "Warehouse # :", $Head2 => $arrySale[0]['wCode']),
		array($Head1 => "Mode of Transport :", $Head2 => $arrySale[0]['transport']),
		array($Head1 => "Package Count :", $Head2 => $arrySale[0]['packageCount']),
		array($Head1 => "Status :", $Head2 => $arrySale[0]['ReceiptStatus']),
		array($Head1 => "Package Type  :", $Head2 => $arrySale[0]['PackageType']),
               array($Head1 => "Weight :", $Head2 => $arrySale[0]['Weight']),
		array($Head1 => "Receipt Comment :", $Head2 => $ReceiptComment)
		/*array($Head1 => "Return Paid Date :", $Head2 => $ReturnPaidDate),
		array($Head1 => "Return Paid Method :", $Head2 => $arrySale[0]['ReturnPaidMethod']),
		array($Head1 => "Paid Reference No# :", $Head2 => $arrySale[0]['ReturnPaidReferenceNo']),
		array($Head1 => "Return Paid Comment :", $Head2 => $PaidComment)*/
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	

?>
