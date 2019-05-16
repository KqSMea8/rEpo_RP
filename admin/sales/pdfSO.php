<?	require_once("../includes/pdf_comman.php");
	if($AttachFlag!=1){
		require_once($Prefix."classes/sales.quote.order.class.php");
	}
	

	$objSale=new sale();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixSO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; $PrefixSO = "SO";  $NotExist = NOT_EXIST_ORDER;
	}
	$ModuleName = "Sale ".$module;

	if(!empty($_GET['o'])){
		$arrySale = $objSale->GetSale($_GET['o'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
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

	 $Title = $ModuleName." # ".$arrySale[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/

	require_once("includes/pdf_order.php");

 

	/********* Item Detail ***************/
	/*************************************/

	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
        
	$YCordLine = $pdf->y-5; 
      
	$pdf->line(50,$YCordLine,92,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>';$Head2 = '<b>Condition</b>'; $Head3 = '<b>Description</b>'; $Head4 = '<b>Qty Ordered</b>'; if($module!='Quote'){ $Head5 = '<b>Qty Invoiced</b>'; } $Head6 = '<b>Unit Price</b>';$Head7 = '<b>Dropship</b>';$Head8 = '<b>Cost</b>';  $Head9 = '<b>Discount</b>'; $Head10 = '<b>Taxable</b>'; $Head11 = '<b>Amount</b>'; 
        
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3;  if($module!='Quote'){$arryDef[$i][$Head4] = $Head4;}$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7; $arryDef[$i][$Head8] = $Head8;$arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;$arryDef[$i][$Head11] = $Head11;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
 
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			//$total_received = $objSale->GetQtyInvoiced($arrySaleItem[$Count]["id"]);
			//$QtyInvoiced = $total_received[0]['QtyInvoiced'];
			//$ordered_qty = $arrySaleItem[$Count]["qty"];
                        
                         if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                            $DropshipCheck = 'Yes';
                        }else{
                            $DropshipCheck = 'No';
                        }
			if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';


			if(!empty($arrySaleItem[$Count]["RateDescription"]))
				$Rate = $arrySaleItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arrySaleItem[$Count]["tax"],2);



			$description = stripslashes($arrySaleItem[$Count]["description"]);
			if(!empty($arrySaleItem[$Count]["DesComment"]))  $description .= "\n<b>Comments: </b>".stripslashes($arrySaleItem[$Count]["DesComment"]);


			$arryDef[$i][$Head1] = stripslashes($arrySaleItem[$Count]["sku"]);
			$arryDef[$i][$Head2] = stripslashes($arrySaleItem[$Count]["Condition"]);
			$arryDef[$i][$Head3] = $description;
			$arryDef[$i][$Head4] = $arrySaleItem[$Count]["qty"];
			if($module!='Quote'){
			$arryDef[$i][$Head5] = $arrySaleItem[$Count]["qty_invoiced"];
			}
			$arryDef[$i][$Head6] = number_format($arrySaleItem[$Count]["price"],2);
                        $arryDef[$i][$Head7] = $DropshipCheck;
                        $arryDef[$i][$Head8] = number_format($arrySaleItem[$Count]["DropshipCost"],2);
			$arryDef[$i][$Head9] = number_format($arrySaleItem[$Count]["discount"],2);
			$arryDef[$i][$Head10] = $arrySaleItem[$Count]['Taxable'];
			$arryDef[$i][$Head11] = number_format($arrySaleItem[$Count]["amount"],2);
                       
			$data[] = $arryDef[$i];
           		 $i++;

			$subtotal += $arrySaleItem[$Count]["amount"];
			//$TotalQtyReceived += $total_received;
			//$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'50'),$Head3=>array('justification'=>'left','width'=>'50'),$Head4=>array('justification'=>'left','width'=>'60'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'50'),$Head7=>array('justification'=>'left','width'=>'45'),$Head8=>array('justification'=>'left','width'=>'50'),$Head9=>array('justification'=>'left','width'=>'45'),$Head10=>array('justification'=>'right','width'=>'40'),$Head10=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);	
		$Freight = number_format($arrySale[0]['Freight'],2);
		$CustDisAmt = number_format($arrySale[0]['CustDisAmt'],2);
		$subtotal = number_format($subtotal,2);
	
		$TotalAmount = $subtotal+$taxAmnt+$Freight;

		if($arrySale[0]['MDType']=='Markup'){
			$TotalAmount = $TotalAmount + $CustDisAmt;
		}else if($arrySale[0]['MDType']=='Discount'){
			$TotalAmount = $TotalAmount - $CustDisAmt;
		}


		 $TotalAmount = number_format($TotalAmount,2,'.',',');

		$TotalTxt .=  "Sub Total : ".$subtotal;
		$TotalTxt .= "\nTax : ".$taxAmnt;
		if($arrySale[0]['MDType'])$TotalTxt .="\n".$arrySale[0]['MDType'].":".$CustDisAmt;
		$TotalTxt .= "\nFreight : ".$Freight;
		$TotalTxt .= "\nGrand Total : ".$TotalAmount;
		if($module!='Quote'){
                $pdf->ezSetMargins(0,0,0,14);
		}
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		/*if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}*/



    }











	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arrySale[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1){
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>
