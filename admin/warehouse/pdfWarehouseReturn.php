<?	
    require_once("../includes/pdf_comman.php");
    require_once($Prefix . "classes/rma.sales.class.php");
	require_once($Prefix."classes/warehouse.rma.class.php");
	
	$warehouserma=new warehouserma();
   $objrmasale = new rmasale();
	$module = 'Receipt';

    $ModuleIDTitle = "Receipt Number"; $ModuleID = "ReceiptNo"; $PrefixSO = "RCPT";  $NotExist = NOT_EXIST_Return;
	$ModuleName = $module;

	if(!empty($_GET['RTN'])){
		$arrySale = $warehouserma->GetReceiptRmaListing($_GET['RTN'],'',$module);
             /* echo "<pre>";
                print_r($arrySale );
                exit;*/
		
		$OrderID   = $arrySale[0]['ReceiptID'];	
		if($OrderID>0){
			$arrySaleItem = $warehouserma->GetSaleReceiptItem($OrderID);
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

	 $Title = " Receipt Number# ".$arrySale[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/
   require_once("includes/pdf_sales_receipt_rma_warehouse.php");
   require_once("includes/pdfwareReturnInfo.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Description</b>'; $Head3 = '<b>Condition</b>'; $Head4 = '<b>Qty RMA</b>'; $Head5 = '<b>Original Qty Returned</b>'; $Head6 = '<b>Qty Return</b>'; $Head7 = '<b>Unit Price</b>'; $Head8 = '<b>Discount</b>'; $Head9 = '<b>Taxable</b>'; $Head10 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;$arryDef[$i][$Head8] = $Head8;$arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			//$total_received = $objSale->GetQtyReceived($arrySaleItem[$Count]["id"]);
			
			//$total_returned = $warehouserma->GetQtyReturnedware($arrySaleItem[$Count]["ref_id"]);
			
			$valReceipt = $warehouserma->GetSumQtyReceipt($arrySaleItem[$Count]['OrderID'],$arrySaleItem[$Count]['item_id']);
			$sku= stripslashes($arrySaleItem[$Count]["sku"]);
			$ordered_qty = $arrySaleItem[$Count]["qty"];
			$qty_invoiced = $total_returned;
			$qty_returned = $arrySaleItem[$Count]["qty_receipt"];
			
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
                        
                        

            $arryDef[$i][$Head1] = $sku;
            $arryDef[$i][$Head2] = stripslashes($arrySaleItem[$Count]["description"]);
            $arryDef[$i][$Head3] = stripslashes($arrySaleItem[$Count]["Condition"]);
            $arryDef[$i][$Head4] = $arrySaleItem[$Count]["qty"];
            //$arryDef[$i][$Head4] = number_format($qty_invoiced);
             $arryDef[$i][$Head5] = number_format($valReceipt);
			$arryDef[$i][$Head6] = number_format($qty_returned);
            $arryDef[$i][$Head7] = number_format($arrySaleItem[$Count]["price"],2);
            $arryDef[$i][$Head8] = number_format($arrySaleItem[$Count]["discount"],2);
            $arryDef[$i][$Head9] = $arrySaleItem[$Count]['Taxable'];
            $arryDef[$i][$Head10] = number_format($arrySaleItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arrySaleItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'70'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'60'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'50'),$Head7=>array('justification'=>'left','width'=>'40'),$Head9=>array('justification'=>'right')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotaln = number_format($subtotal,2);
		$taxAmnt = number_format($arrySale[0]['wtaxAmnt'],2);
		$Freight = number_format($arrySale[0]['FreightAmt'],2);
		$ReStockingVal = number_format($arrySale[0]['ReStocking'],2);
	
		if($arrySale[0]['ReSt']==1){
			$ReS="\nReStocking Fee : ".$ReStockingVal;
		}
		


		$TotalAmountn = $subtotal+$arrySale[0]['wtaxAmnt']+$arrySale[0]['FreightAmt']+$arrySale[0]['ReStocking'];
		$TotalAmount = number_format($TotalAmountn,2,'.',',');

		$TotalTxt =  "Sub Total : ".$subtotaln."\nTax : ".$taxAmnt."\nFreight : ".$Freight.$ReS."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}



    }


    
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
    
    

	$file_path = 'upload/pdf/'.$arrySale[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;

?>
