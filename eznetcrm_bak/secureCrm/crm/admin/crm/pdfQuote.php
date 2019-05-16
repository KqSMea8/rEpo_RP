<?	require_once("../includes/pdf_comman.php");
	if($AttachFlag!=1){
		require_once($Prefix."classes/quote.class.php");		
		
	}
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/sales.customer.class.php");

	$objQuote=new quote(); $objLead=new lead(); $objCustomer=new Customer(); 
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];



	$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; $PrefixSO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	
	$ModuleName = "Quote ";

	if(!empty($_GET['o'])){

	 	$arryQuote = $objQuote->GetQuote($_GET['o'],'','');


		if($arryQuote[0]['OpportunityID']>0){
			$arryOpp = $objLead->GetOpportunity($arryQuote[0]['OpportunityID'],'');
		}
		$OpportunityName = (!empty($arryOpp[0]['OpportunityName']))?(stripslashes($arryOpp[0]['OpportunityName'])):(stripslashes($arryQuote[0]['opportunityName']));


		if($arryQuote[0]['CustID']>0){
			$arryCustomer = $objCustomer->GetCustomer($arryQuote[0]['CustID'],'','');
		}
		$CustomerName = (!empty($arryCustomer[0]['FullName']))?(stripslashes($arryCustomer[0]['FullName'])):(stripslashes($arryQuote[0]['CustomerName']));



         	$arryQuoteAdd = $objQuote->GetQuoteAddress($arryQuote[0]['quoteid'],'');

		$OrderID   = $arryQuote[0]['quoteid'];	
		if($OrderID>0){
			$arryQuoteItem = $objQuote->GetQuoteItem($OrderID);

			
			$NumLine = sizeof($arryQuoteItem);
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
	if(!empty($arryQuote[0]['CreatedByEmail'])){
		$arryCompany[0]['Email']=$arryQuote[0]['CreatedByEmail'];
	}

	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = $ModuleName." # ".$arryQuote[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/

	require_once("includes/pdf_order.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>Line Item</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Description</b>'; $Head3 = '<b>Qty Ordered</b>'; 
//$Head4 = '<b>Total Qty Received</b>'; 
$Head5 = '<b>Unit Price</b>'; $Head6 = '<b>Discount</b>'; $Head7 = '<b>Taxable</b>'; $Head8 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; //$arryDef[$i][$Head4] = $Head4;
$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;$arryDef[$i][$Head8] = $Head8;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
                       $total_received = 0;
			//$total_received = $objSale->GetQtyReceived($arryQuoteItem[$Count]["id"]);
			$ordered_qty = $arryQuoteItem[$Count]["qty"];

			if(!empty($arryQuoteItem[$Count]["RateDescription"]))
				$Rate = $arryQuoteItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arryQuoteItem[$Count]["tax"],2);
		if(empty($arryQuoteItem[$Count]['Taxable'])) $arryQuoteItem[$Count]['Taxable']='No';


            $arryDef[$i][$Head1] = stripslashes($arryQuoteItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arryQuoteItem[$Count]["description"]);
            $arryDef[$i][$Head3] = $arryQuoteItem[$Count]["qty"];
            $arryDef[$i][$Head4] = number_format($total_received);
            $arryDef[$i][$Head5] = number_format($arryQuoteItem[$Count]["price"],2);
			$arryDef[$i][$Head6] = number_format($arryQuoteItem[$Count]["discount"],2);
            $arryDef[$i][$Head7] = $arryQuoteItem[$Count]['Taxable'];
            $arryDef[$i][$Head8] = number_format($arryQuoteItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryQuoteItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'60'),$Head2=>array('justification'=>'left'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'90'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'80'),$Head7=>array('justification'=>'left','width'=>'40'),$Head8=>array('justification'=>'right','width'=>'80')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryQuote[0]['Freight'],2);
		$taxAmnt = number_format($arryQuote[0]['taxAmnt'],2,'.','');
		$TotalAmount = number_format($arryQuote[0]['TotalAmount'],2);

		$TotalTxt =  "Sub Total : ".$subtotal."\nTax : ".$taxAmnt."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}



    }


	/***********************************/
	//$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'.$arryQuote[0][$ModuleID].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1){
		header("location:dwn.php?file=".$file_path);
		exit;
	}

?>
