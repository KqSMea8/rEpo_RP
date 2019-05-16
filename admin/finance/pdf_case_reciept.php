<?	$HideNavigation = 1;
        include_once("../includes/header.php");
        require_once("../includes/pdf_comman.php"); 
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase=new purchase();
        require_once($Prefix . "classes/sales.quote.order.class.php");
        require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	//require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/supplier.class.php");
        $objSale = new sale();
	$objSupplier=new supplier();
	$objCustomer = new Customer();
           
        (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	$objTax=new tax();
	$objBankAccount= new BankAccount();


	
        $module = 'Invoice';
	$ModuleName = "Customer Invoice";
        
        /****code for payment history****/
       
        if(!empty($_GET['o'])){
            
        $arrySale = $objSale->GetSale($_GET['o'],'',$module);
		
		$arryBankAccount=$objBankAccount->getBankAccountForReceivePayment();
	
		
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID   = $arrySale[0]['SaleID'];
		$InvoiceID = $arrySale[0]['InvoiceID'];
		$CustID = $arrySale[0]['CustID'];
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			//get payment history
			 
			$arryPaymentInvoice = $objBankAccount->GetSalesPaymentInvoice($_GET['o'],$_GET['InvoiceID'],$CustID);
			//echo '<pre>'; print_r($arryPaymentInvoice);die;
			 
			
		}else{
			$ErrorMSG = $NotExist;
		}
        }
        //echo '<pre>';print_r($arrySale); die('kk');
        /****code for payment history***/
        /*******************************************/
	/*******************************************/

	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = $ModuleName." # ".$InvoiceID;
	 HeaderTextBox($pdf,$Title,$arryCompany);

         require_once("includes/pdf_ar_case_recierp.php");

	

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>".LINE_ITEM."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,90,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>';$Head2 = '<b>Condition</b>'; $Head3 = '<b>Description</b>'; $Head4 = '<b>Comments</b>'; $Head5 = '<b>Qty Ordered</b>'; $Head6 = '<b>Qty Invoiced</b>';  $Head7 = '<b>Unit Price</b>'; $Head8 = '<b>Dropship</b>'; $Head9 = '<b>Cost</b>'; $Head10 = '<b>Discount</b>';  $Head11 = '<b>Taxable</b>'; $Head12 = '<b>Amount</b>';
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6; $arryDef[$i][$Head7] = $Head7; $arryDef[$i][$Head8] = $Head8; $arryDef[$i][$Head9] = $Head9;$arryDef[$i][$Head10] = $Head10;$arryDef[$i][$Head11] = $Head11;$arryDef[$i][$Head12] = $Head12;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;$TotalQtyReceived=0;$TotalQtyOrdered=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		$total_received = $objSale->GetQtyInvoiced($arrySaleItem[$Count]["id"]);
		$total_received = $total_received[0]['QtyInvoiced'];
		$ordered_qty = $arrySaleItem[$Count]["qty"];

		#if($arrySale[0]['Taxable']=='Yes' && $arrySale[0]['Reseller']!='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
			$TaxShowHide = 'inline';
		}else{
			$TaxShowHide = 'none';
		}

		$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');
                
                if($arrySaleItem[$Count]["DropshipCheck"] == 1){
                    $DropshipCheck = 'Yes';
                }else{
                    $DropshipCheck = 'No';
                }


		if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';


            $arryDef[$i][$Head1] = stripslashes($arrySaleItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arrySaleItem[$Count]["Condition"]);
            $arryDef[$i][$Head3] = stripslashes($arrySaleItem[$Count]["description"]);
            $arryDef[$i][$Head4] = stripslashes($arrySaleItem[$Count]["DesComment"]);
            $arryDef[$i][$Head5] = $arrySaleItem[$Count]["qty"];
            $arryDef[$i][$Head6] = ($module!='Quote')?($arrySaleItem[$Count]["qty_invoiced"]):('');
            
            $arryDef[$i][$Head7] = number_format($arrySaleItem[$Count]["price"],2);
            $arryDef[$i][$Head8] = $DropshipCheck;
	   
	    $arryDef[$i][$Head9] = number_format($arrySaleItem[$Count]["DropshipCost"],2);
	    
            $arryDef[$i][$Head10] = number_format($arrySaleItem[$Count]["discount"],2);
            $arryDef[$i][$Head11] = $arrySaleItem[$Count]['Taxable'];
            $arryDef[$i][$Head12] = number_format($arrySaleItem[$Count]["amount"],2);
            
            $data[] = $arryDef[$i];
            $i++;

		$subtotal += $arrySaleItem[$Count]["amount"];

		$TotalQtyReceived += $total_received;
		$TotalQtyOrdered += $ordered_qty;
        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'50'),$Head3=>array('justification'=>'left','width'=>'50'),$Head4=>array('justification'=>'left','width'=>'50'),$Head5=>array('justification'=>'left','width'=>'50'),$Head6=>array('justification'=>'left','width'=>'40'),$Head7=>array('justification'=>'left','width'=>'40'),$Head8=>array('justification'=>'left','width'=>'40'),$Head9=>array('justification'=>'right','width'=>'40'),$Head10=>array('justification'=>'right','width'=>'40'),$Head11=>array('justification'=>'right','width'=>'40'),$Head12=>array('justification'=>'right','width'=>'40')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);

        /**code for total*/
                
                /***/
                $subtotal = number_format($subtotal,2);
                if($arrySale[0]['MDType']!=''){
                $Mdtype="MDType :";
                $mdtype=$arrySale[0]['MDType'].' : '.$arrySale[0]['CustDisAmt'];
                }
		$Freight = number_format($arrySale[0]['Freight'],2);
		$taxAmnt = number_format($arrySale[0]['taxAmnt'],2);
		$TotalAmount = number_format($arrySale[0]['TotalAmount'],2);
                
		

		$TotalTxt =  "Sub Total : ".$subtotal."\n".$Mdtype."".$mdtype."\nTax : ".$taxAmnt."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));



    }





  /********* CODE FOR SERIAL NUMBER ***************/
    
    if(sizeof($arrySlNo)>0){
	$pdf->ezSetDy(-5);
        $SerialHead1 = '<b>SKU</b>'; $SerialHead2 = '<b>Serial Number</b>';
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
                $pdf->ezTable($Serialdata,'','',array('cols'=>array($SerialHead1=>array('justification'=>'left','width'=>'65'),$SerialHead2=>array('justification'=>'left','width'=>'435')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
                $pdf->setStrokeColor(0,0,0,1);

		

      }


    /********* END CODE FOR SERIAL NUMBER ***************/





	/***********************************/
	//$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/CashReceipt_'.$arryPaymentInvoice[0]['InvoiceID'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);
        if($AttachFlag!=1){
	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;
        }
?>
