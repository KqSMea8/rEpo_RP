<?	$HideNavigation = 1;
        include_once("../includes/header.php");
        require_once("../includes/pdf_comman.php");
	
        require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	//require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/supplier.class.php");

	$objSupplier=new supplier();
	$objCustomer = new Customer();
           
        (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	$objTax=new tax();
	$objBankAccount= new BankAccount();
        
	$ModuleName = "Vendor Invoice";
       
	if(!empty($_GET['o'])){
		$IncomeID = $_GET['o'];
			$_GET['ExpenseID'] = $_GET['o'];
                        //echo '<pre>'; print_r($_GET);die('klo');
			$arryOtherExpense=$objBankAccount->getOtherExpense($_GET);
			$arryTax = $objTax->getTaxById($arryOtherExpense[0]['TaxID']);
                        
			$OrderID   = $arryOtherExpense[0]['OrderID'];			
			$InvoiceID = $arryOtherExpense[0]['InvoiceID'];	
                        //Get Multi Account
                         
                         $arryMultiAccount=$objBankAccount->getMultiAccount($_GET['view']);
                   //    echo '<pre>'; print_r( $arryOtherExpense);
                        //End
			if($_GET['pay']==1) {
				$arryPaymentInvoice = $objBankAccount->GetPurchasesPaymentInvoice($OrderID,$InvoiceID);
                                //echo '<pre>'; print_r($arryPaymentInvoice);die;
                                $NumLine = sizeof($arryPaymentInvoice);
                                
			}
                
                
                
	}else{
		$ErrorMSG = NOT_EXIST_PAYMENT_HISTORY;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

	/*******************************************/
//	if(!empty($arrySale[0]['CreatedByEmail'])){
//		$arryCompany[0]['Email']=$arrySale[0]['CreatedByEmail'];
//	}
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 //$Title = $ModuleName." ID# ".$arryPaymentInvoice[0]["PaymentID"];
         $Title = $ModuleName." ID# ".$arryPaymentInvoice[0]['InvoiceID'];
         //echo date($Config['DateFormat']);die('date');
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/
        //die('kk');
	require_once("includes/pdf_vendorPayment.php");

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezSetDy(-10);
	$pdf->ezText("<b>".Payment_History."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,120,$YCordLine);

	$pdf->ezSetDy(-5);
        $TotalAmount = 0;
	if(count($arryPaymentInvoice) > 0){
//    if($NumLine>0){
        $Head1 = '<b>InvoiceID</b>';  $Head2 = '<b>Payment Method</b>'; $Head3 = '<b>Payment Date</b>'; $Head4 = '<b>Reference No.</b>'; $Head5 = '<b>Comment</b>';  $Head6 = '<b>Payment Status</b>'; $Head7 = '<b>Amount ('.$Config['Currency'].')</b>';
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;
        $data[] = $arryDef[$i];
        $i++;
		//$subtotal=0;
        /*************start code for payment history in pdf******/
        foreach($arryPaymentInvoice as $value) {
            
            if(!empty($value['CheckBankName'])){
                        
                        $CheckBankName = ' - ('.$value['CheckBankName'].'-'.$value['CheckFormat'].')';
                    }else{
                         $CheckBankName = '';
                    }
                    
                    
                    $arryDef[$i][$Head1] = $value['InvoiceID'];
                  
                 
                    $arryDef[$i][$Head2] = $value['Method'].''.$CheckBankName;
                    $arryDef[$i][$Head3] = date($Config['DateFormat'], strtotime($value['PaymentDate']));
                    $arryDef[$i][$Head4] = $value['ReferenceNo'];
                    $arryDef[$i][$Head5] = $value['Comment'];
                    /*code for payment status*/
                    
                                            if ($value['PaymentType'] == 'Other Expense') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                if ($value['InvoicePaid'] == 1) {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }
                                            }
                                            
                                            
                    /*code for payment status*/
                    $arryDef[$i][$Head6] = $InvoicePaid;
                    $arryDef[$i][$Head7] = number_format($value['CreditAmnt'],2,'.','');
                    
                  
                    $data[] = $arryDef[$i];
                    $TotalAmount += $value["CreditAmnt"];
                    $i++;
        }
        $TotalAmount = number_format($TotalAmount,2);
        /*************end code for payment history in pdf********/
                
		
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
                $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'50'),$Head2=>array('justification'=>'left','width'=>'80'),$Head3=>array('justification'=>'left'),$Head4=>array('justification'=>'left','width'=>'80'),$Head6=>array('justification'=>'left','width'=>'60'),$Head7=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
                $pdf->setStrokeColor(0,0,0,1);


		

		$TotalTxt =  "Total Paid Amount : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		/*if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(SO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		}*/



    }

	$file_path = 'upload/pdf/VendorPayment_'.$arryPaymentInvoice[0]['InvoiceID'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);
if($AttachFlag!=1){
	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
	exit;
}

?>
