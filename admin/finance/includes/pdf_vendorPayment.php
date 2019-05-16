<?
	/********* Order Detail **************/
	/******************vendor details*******************/
if (!empty($_GET['vendorinfo'])) {
		$arrySupplier = $objSupplier->GetSupplier('',$_GET['vendorinfo'],'');
                //echo '<pre>'; print_r($arrySupplier);die('jfj');
		$SuppID   = $_GET['view'];	
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}
	}else{
		$ErrorMSG = INVALID_REQUEST;
	}
/********************vendor details*****************/
//	if(empty($ModuleID)){
//		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; 
//	}


	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Vendor Code# :", $Head2 => $arrySupplier[0]["SuppCode"]),
		array($Head1 => "Vendor Type :", $Head2 => $arrySupplier[0]["SuppType"]),
		array($Head1 => "Company Name:", $Head2 => $arrySupplier[0]["CompanyName"]),
		array($Head1 => "Contact Name:", $Head2 => $arrySupplier[0]["UserName"]),
		array($Head1 => "Email :", $Head2 => $arrySupplier[0]["Email"]),
		array($Head1 => "Mobile :", $Head2 => $arrySupplier[0]["Mobile"]),
		array($Head1 => "Address :", $Head2 => $arrySupplier[0]["Address"].' '.$arrySupplier[0]["City"].' '.$arrySupplier[0]["State"].' '.$arrySupplier[0]["Country"].' '.$arrySupplier[0]["ZipCode"])
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	
?>
