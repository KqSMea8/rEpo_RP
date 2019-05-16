<?	
	require_once("../includes/pdf_comman.php");
	if($AttachFlag!=1){
		require_once($Prefix."classes/purchase.class.php");
	}
	

	$objPurchase=new purchase();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
	}
	$ModuleName = "Purchase ".$module;

	if(!empty($_GET['o'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['o'],'',$module);
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
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
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = $ModuleName." # ".$arryPurchase[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/

	require_once("includes/pdf_po_order.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
		$Head1 = '<b>SKU</b>'; $Head2 = '<b>Condition</b>';
		$Head3 = '<b>Description</b>'; 
		$Head4 = '<b>Qty Ordered</b>'; 
		$Head5 = '<b>Total Qty Received</b>'; 
		$Head6 = '<b>Unit Price</b>';
		$Head7 = '<b>Dropship</b>';
		$Head8 = '<b>Tax Rate</b>';
		$Head9 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

		$arryDef[$i][$Head1] = $Head1;
		$arryDef[$i][$Head2] = $Head2;
		$arryDef[$i][$Head3] = $Head3;
		if($module!='Quote'){$arryDef[$i][$Head4] = $Head4;}
		$arryDef[$i][$Head5] = $Head5;
		$arryDef[$i][$Head6] = $Head6;
		$arryDef[$i][$Head7] = $Head7;
		$arryDef[$i][$Head8] = $Head8;
		$arryDef[$i][$Head9] = $Head9;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["id"]);
			$ordered_qty = $arryPurchaseItem[$Count]["qty"];

			if(empty($arryPurchaseItem[$Count]['Taxable'])) $arryPurchaseItem[$Count]['Taxable']='No';

			if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				$Rate = $arryPurchaseItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arryPurchaseItem[$Count]["tax"],2);

  		$description = stripslashes($arryPurchaseItem[$Count]["description"]);
	    	if(!empty($arryPurchaseItem[$Count]["DesComment"]))  $description .= "\n<b>Comments: </b>".stripslashes($arryPurchaseItem[$Count]["DesComment"]);


            $arryDef[$i][$Head1] = stripslashes($arryPurchaseItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arryPurchaseItem[$Count]["Condition"]);
            $arryDef[$i][$Head3] = $description;
            $arryDef[$i][$Head4] = $arryPurchaseItem[$Count]["qty"];
           if($module!='Quote'){ $arryDef[$i][$Head5] = number_format($total_received);}
            $arryDef[$i][$Head6] = number_format($arryPurchaseItem[$Count]["price"],2);
	   if($arryPurchase[0]['OrderType']=='Dropship' ){ 
		//$DropshipCheck='';
		//if($arryPurchaseItem[$Count]['DropshipCheck'] ==1){  $DropshipCheck = "Yes"; }
		}
		$arryDef[$i][$Head7] = number_format($arryPurchaseItem[$Count]["DropshipCost"],2);
	  
            $arryDef[$i][$Head8] = $arryPurchaseItem[$Count]['Taxable'];
            $arryDef[$i][$Head9] = number_format($arryPurchaseItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryPurchaseItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			#$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'50'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'60'),$Head7=>array('justification'=>'left','width'=>'50'),$Head8=>array('justification'=>'right','width'=>'40'),$Head9=>array('justification'=>'right')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2));
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$taxAmnt = number_format($arryPurchase[0]['taxAmnt'],2);
		$PrepaidAmount = number_format($arryPurchase[0]['PrepaidAmount'],2); 
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		if($arryPurchase[0]['PrepaidFreight']=='1'){   
				$PrepaidAmountTxt = "\nPrepaid Freight : ".$PrepaidAmount;
		}		

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight Cost : ".$Freight.$PrepaidAmountTxt."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));


		if($module=="Order"){
			$TotalQtyLeft = $objPurchase->GetTotalQtyLeft($arryPurchase[0]['PurchaseID']);
			if($TotalQtyLeft<=0){
				$pdf->setColor(255,0,0,1);
				$pdf->ezSetDy(-20);
				$pdf->ezText(PO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
				$pdf->setColor(0,0,0,1);
			}
		}



    }











	/***********************************/
	//$pdf->ezStream(); exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arryPurchase[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);
	if($AttachFlag!=1){
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>
