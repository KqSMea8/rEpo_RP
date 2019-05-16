<? 

session_start();
$Prefix = "../../";

	date_default_timezone_set('America/New_York');

require_once($Prefix . "includes/config.php");
require_once($Prefix . "includes/function.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/admin.class.php");

require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
require_once($Prefix."classes/purchase.class.php");


	
         
$objConfig = new admin();
$objSale = new sale();
$objBankAccount = new BankAccount();
	$objReport = new report();
$objPurchase=new purchase();

if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}


if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

$Config['DateFormat'] = 'Y-m-d';
$Config['GetNumRecords'] = '';
$Config['RecordsPerPage']= '';

/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

CleanPost();

switch ($_POST['action']) {
   

  

case 'ArAging':
	/********************/

	(empty($_GET['CustCode']))?($_GET['CustCode']=""):("");
	$arrySelCurrency =  array();
	if(!empty($arryCompany[0]['AdditionalCurrency']))
		$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']); 

	if(!in_array($Config['Currency'],$arrySelCurrency)){
		$arrySelCurrency[] = $Config['Currency'];
	}
	sort($arrySelCurrency);


        $currencyArray = array();
        $query = explode("&",$_SERVER['QUERY_STRING']);
        foreach($query as $val){
            $valArrray =  explode("=",$val);
            if($valArrray[0] == 'Currency'){
                array_push($currencyArray, $valArrray[1]);
            }
        }

				$arryAging=$objReport->arAgingReportList($_GET['CustCode'],$currencyArray);
        /* END's HERE */
        
        
	$num=$objReport->numRows();
				/********************/
          
	$AjaxHtml = '<div>';
	 if(is_array($arryAging) && $num>0){
		$flag=true;
		$Line=0;
	$TotalOriginalAmount = 0;
	$TotalUnpaidInvoice = 0;
	$TotalCurrentBalance = 0;
	$TotalBalance30 = 0;
	$TotalBalance60 = 0;
	$TotalBalance90 = 0;
	$TotalBalance120 = 0;
	$CustomerOriginalAmount = 0;
	$CustomerUnpaidInvoice = 0;
	$CustomerCurrentBalance = 0;
	$CustomerBalance30 = 0;
	$CustomerBalance60 = 0;
	$CustomerBalance90 = 0;
	$CustomerBalance120 = 0;

	$TotalUnpaidInvoice3424=0;
	 $TotalCurrentBalance3234234=0;
	$NewCustCode=$CreditAmount='';
		foreach($arryAging as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;
                

		$ConversionRate=1;
		if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
			$ConversionRate = $values['ConversionRate'];			   
		}



		$CurrentBalance = 0;
		$Balance30 =  0;
		$Balance60 =  0;
		$Balance90 =  0;
		$Balance120 =  0;

		 /***********************/
		$ModuleDate=''; $ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			$ModuleDate=$values['InvoiceDate'];


		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];
			$ModuleDate=$values['PostedDate'];
			

		}
		
		
		
                $OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 
                $PaidAmnt = $values['ReceiveAmnt'];

		if(!empty($_GET['Currency']) && $values['CustomerCurrency']!=$BaseCurrency && $values['ConversionRate']>0){
			$PaidAmnt = GetConvertedAmountReverse($values['ConversionRate'], $PaidAmnt); 
		}


                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $orginalAmount;
                }
                /***********************/
		$AgingDay = GetAgingDay($ModuleDate); 
		switch($AgingDay){
			case '1': $CurrentBalance = $UnpaidInvoice; break;
			case '2': $Balance30 = $UnpaidInvoice; break;
			case '3': $Balance60 = $UnpaidInvoice; break;
			case '4': $Balance90 = $UnpaidInvoice; break;
			case '5': $Balance120 = $UnpaidInvoice; break;
		} 
		/***********************/
                $TotalUnpaidInvoice +=$UnpaidInvoice;
                $TotalUnpaidInvoice3424 +=$UnpaidInvoice;
                $TotalCurrentBalance +=$CurrentBalance;
 $TotalCurrentBalance3234234 +=$CurrentBalance;
                $TotalBalance30 +=$Balance30;
                $TotalBalance60 +=$Balance60;
                $TotalBalance90 +=$Balance90;
                $TotalBalance120 +=$Balance120;

		if(!empty($values["PaymentTerm"])){
			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$ModuleDate);
			list($year, $month, $day) = $arryDate;
			if(!empty($arryTerm[1])){
			$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
			$DueDate = date("Y-m-d",$TempDate);
			$DueDate = date($Config['DateFormat'], strtotime($DueDate));
			}
		}else{
			$DueDate = '';
		}
               
		 if(($NewCustCode != '' && $NewCustCode != $values['CustCode'])){ 

			$CustomerUnpaidInvoice += -$CreditAmount;
			$CustomerCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			//$TotalCurrentBalance += -$CreditAmount;

		
			$CustomerOriginalAmount=0;
			$CustomerUnpaidInvoice = 0;
			$CustomerCurrentBalance = 0;
			$CustomerBalance30 = 0;
			$CustomerBalance60 = 0;
			$CustomerBalance90 = 0;
			$CustomerBalance120 = 0;
		} 

 if($NewCustCode != $values['CustCode']){  
		 $CreditAmount = $values['CreditAmount']; 
		} 

			 
      $TotalOriginalAmount  +=$orginalAmount;
               

		$NewCustCode = $values['CustCode'];
		$Customer =  $values["Customer"];

		
		$CustomerOriginalAmount +=$orginalAmount;
		$CustomerUnpaidInvoice +=$UnpaidInvoice;
		//$CustomerCurrentBalance +=$CurrentBalance;
		$CustomerBalance30 +=$Balance30;
		$CustomerBalance60 +=$Balance60;
		$CustomerBalance90 +=$Balance90;
		$CustomerBalance120 +=$Balance120;

 } // foreach end //


		if(empty($_GET['CustCode'])){

			$CustomerUnpaidInvoice += -$CreditAmount;
			$CustomerCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			
			
		}else{
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
		}

$AjaxHtml .= '<br><br><br> 
				<h1> <font size="20"><b>'.number_format($TotalUnpaidInvoice3424,2).' </b></font> <h1>
<br><h1> <font size="20"><b> '.$Config['Currency'].'</b></font> <h1></div>';
$AjaxHtml .= '<br><div align="right"><a href="arAging.php">More...</a></div>';

	/* $AjaxHtml .= '<tr class="oddbg">
<table>

<tr>
<td  align="left" ><b>Total Original Amount : </b></td> 
				<td><b>'.number_format($TotalOriginalAmount,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>Total Unpaid Invoices : </b></td> 
				<td><b>'.number_format($TotalUnpaidInvoice,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>Total Current Balance : </b></td> 
				<td><b>'.number_format($TotalCurrentBalance,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>30 Days : </b></td> 
				<td><b>'.number_format($TotalBalance30,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>60 Days : </b></td> 
				<td><b>'.number_format($TotalBalance60,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>90 Days : </b></td> 
				<td><b>'.number_format($TotalBalance90,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b> 120 Days : </b></td> 
				<td><b>'.number_format($TotalBalance120,2).' '.$Config['Currency'].'</b></td>
</tr></table>
		</tr>';*/
	 }else{
                    $AjaxHtml .= '<br><br><br> 
                          No record found.</div>
                           ';
             }
                           
             $AjaxHtml .= '</table>';
        break;

 

 case 'ApAging':
	/********************/
	(empty($_GET['s']))?($_GET['s']=""):(""); 
				$arryAging=$objReport->apAgingReportList($_GET['s'],'');

	$num=$objReport->numRows();
				/********************/
          
	//$AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$AjaxHtml = '<div>';
	 if(is_array($arryAging) && $num>0){
		$flag=true;
		$Line=0;
		$TotalOriginalAmount=0;
                $TotalUnpaidInvoice = 0;
                $TotalCurrentBalance = 0;
                $TotalBalance30 = 0;
                $TotalBalance60 = 0;
                $TotalBalance90 = 0;
		$TotalBalance120 = 0;

 
              $TotalUnpaidInvoice4533=0;
		$TotalUnpaidInvoice453=0;
     
                $VendorOriginalAmount = 0;
		$VendorUnpaidInvoice = 0;
		$VendorCurrentBalance = 0;
                $VendorBalance30 = 0;
                $VendorBalance60 = 0;
                $VendorBalance90 = 0;
		$VendorBalance120 = 0;
		$NewSuppCode=$CreditAmount='';
		foreach($arryAging as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;


		$ConversionRate=1;
		if($values['Currency']!=$Config['Currency'] && $values['ConversionRate']>0 ){				
			$ConversionRate = $values['ConversionRate'];	
		 
		}

		$CurrentBalance = 0;
		$Balance30 =  0;
		$Balance60 =  0;
		$Balance90 =  0;
		$Balance120 =  0;
	 	/***********************/
		$ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
	
		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];				

		}
	


         	$OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount);         
                $PaidAmnt = $values['PaidAmnt'];

		if(!empty($_GET['Currency']) && $values['Currency']!=$BaseCurrency && $values['ConversionRate']>0){
			$PaidAmnt = GetConvertedAmountReverse($values['ConversionRate'], $PaidAmnt); 
		}

                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $orginalAmount;
                }
                
		/***********************/
		$AgingDay = GetAgingDay($values['PostedDate']); 
		switch($AgingDay){
			case '1': $CurrentBalance = $UnpaidInvoice; break;
			case '2': $Balance30 = $UnpaidInvoice; break;
			case '3': $Balance60 = $UnpaidInvoice; break;
			case '4': $Balance90 = $UnpaidInvoice; break;
			case '5': $Balance120 = $UnpaidInvoice; break;
		} 
		/***********************/

                $TotalUnpaidInvoice +=$UnpaidInvoice;
                $TotalUnpaidInvoice4533 +=$UnpaidInvoice;
                $TotalCurrentBalance +=$CurrentBalance;
                $TotalBalance30 +=$Balance30;
                $TotalBalance60 +=$Balance60;
                $TotalBalance90 +=$Balance90;
                $TotalBalance120 +=$Balance120;

		

                if(!empty($values["VendorName"])){ 
                	$SupplierName = $values["VendorName"];
                }else{
                	$SupplierName = $values["SuppCompany"];
                }

		$DueDate = '';
		if(!empty($values["PaymentTerm"])){
			$PaymentTerm = strtolower(trim($values["PaymentTerm"]));

			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$values['PostedDate']);
			list($year, $month, $day) = $arryDate;
			
			if($PaymentTerm=='end of month'){				 
				$TempDate  = mktime(0, 0, 0, $month+1 , 1, $year);	
				$DueDate = date("Y-m-t",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDate));
			}else if(!empty($arryTerm[1])){//term
				$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
				$DueDate = date("Y-m-d",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDate));
			}
		} 
		 if(($NewSuppCode != '' && $NewSuppCode != $values['SuppCode'])){ 

			$VendorUnpaidInvoice += -$CreditAmount;
			$VendorCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b> Total : </b></td>
                        <td><b>'. number_format($VendorOriginalAmount,2).'</b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';
		 	//echo $VendorTotal;
			$VendorOriginalAmount=0;
			$VendorUnpaidInvoice = 0;
			$VendorCurrentBalance = 0;
			$VendorBalance30 = 0;
			$VendorBalance60 = 0;
			$VendorBalance90 = 0;
			$VendorBalance120 = 0;

                        


		}  if($NewSuppCode != $values['SuppCode']){   #$CreditAmount = $values['CreditAmount']; 
			if($CreditAmount>0){
		 } 
		} 
		$NewSuppCode = $values['SuppCode'];
		$Supplier = $SupplierName;

		$VendorOriginalAmount +=$orginalAmount;
		$VendorUnpaidInvoice +=$UnpaidInvoice;
   		$VendorCurrentBalance +=$CurrentBalance;
                $VendorBalance30 +=$Balance30;
                $VendorBalance60 +=$Balance60;
                $VendorBalance90 +=$Balance90;
                $VendorBalance120 +=$Balance120;

} // foreach end //


		if(empty($_GET['s'])){
			
			$VendorUnpaidInvoice += -$CreditAmount;
			$VendorCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b>Total : </b></td>
                        <td><b>'.number_format($VendorOriginalAmount,2).'</b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';
			//echo $VendorTotal;
		}else{
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
		}



 /*$AjaxHtml .= '<tr class="oddbg">
<table>

<tr>
<td  align="left" ><b>Total Original Amount : </b></td> 
				<td><b>'.number_format($VendorOriginalAmount,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>Total Unpaid Invoices : </b></td> 
				<td><b>'.number_format($VendorUnpaidInvoice,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>Total Current Balance : </b></td> 
				<td><b>'.number_format($VendorCurrentBalance,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>30 Days : </b></td> 
				<td><b>'.number_format($VendorBalance30,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>60 Days : </b></td> 
				<td><b>'.number_format($VendorBalance60,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b>90 Days : </b></td> 
				<td><b>'.number_format($VendorBalance90,2).' '.$Config['Currency'].'</b></td>
</tr>
<tr>
<td  align="left" ><b> 120 Days : </b></td> 
				<td><b>'.number_format($VendorBalance120,2).' '.$Config['Currency'].'</b></td>
</tr></table>
		</tr>';*/

$AjaxHtml .= '<br><br><br> 
				<h1> <font size="20"><b>'.number_format($TotalUnpaidInvoice4533,2).' </b></font> <h1>
<br><h1> <font size="20"><b> '.$Config['Currency'].'</b></font> <h1>';
$AjaxHtml .= '<br><div align="right"><a href="apAging.php">More...</a></div>';



/*$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b>Total : </b></td>
                        <td><b>'.number_format($VendorOriginalAmount,2).'</b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';*/




 }else{
                    $AjaxHtml .= '
                          No record found.
                         ';
             }
                           
             $AjaxHtml .= '</div>';
        break;

 case 'SalesListing':

	(empty($Year))?($Year=""):(""); 
	(empty($FromDate))?($FromDate=""):(""); 
	(empty($ToDate))?($ToDate=""):(""); 
	(empty($CustCode))?($CustCode=""):("");
	(empty($SalesPID))?($SalesPID=""):(""); 

	 $arryCampaign=$objSale->GetTotalSO($Year,$FromDate,$ToDate,$CustCode,$SalesPID,'Open'); 
	        
	 $AjaxHtml = '<div>';  
	 if(sizeof($arryCampaign)>0){
	
		$flag=true;
		$Line=0;

		foreach($arryCampaign as $key=>$Campaign){
			$flag=!$flag;
			$Line++;
		
			/*$AjaxHtml .= '<tr class="even">
<td><b>Total Sales :</b> '.stripslashes($Campaign['TotalOrder']).'  '.stripslashes($Campaign['CustomerCurrency']).'</a></td>
			</tr>'; 
                          
                 }
                 $AjaxHtml .= '<tr>
                           <td  colspan="2">
                           <a href="viewSalesQuoteOrder.php?module=Order">More...</a>

                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No Sales found.
                           </td>

                           </tr>';
             }*/


$AjaxHtml .= '<br><br><br> 
				<h1> <font size="20"><b>'.number_format($Campaign['TotalOrder'],2).' </b></font> <h1>
<br><h1> <font size="20"><b> '.$Config['Currency'].'</b></font> <h1>';
}
$AjaxHtml .= '<br><div align="right"><a href="../sales/viewSalesQuoteOrder.php?module=Order">More...</a></div>';

           
              }else{
                    $AjaxHtml .= '
                          No Sales found.
                           ';
             }
                           
             $AjaxHtml .= '</div>';
        break;

case 'openpo':

/********************/
		$AjaxHtml = '';
				$_GET['key']=''; 
				$_GET['sortby']=''; 
				$_GET['module']='Order'; 
				$_GET['Status'] = 'Open';
				$TotalAmount=0;
				$arryOpenPO=$objPurchase->ListPurchase($_GET);
if(sizeof($arryOpenPO)>0){ 
foreach($arryOpenPO as $key=>$tot){
$TotalAmount +=$tot['TotalAmount'];
                        

}


$AjaxHtml = '<br><br><br> 
				<h1> <font size="20"><b>'.number_format($TotalAmount,2).' </b></font> <h1>
<br><h1> <font size="20"><b> '.$Config['Currency'].'</b></font> <h1>';

$AjaxHtml .= '<br><div align="right"> <a href="../purchasing/viewPO.php?module=Order">More...</a></div>';

           
              }else{
                    $AjaxHtml .= '
                          No record found.
                           ';
             }
                           
             $AjaxHtml .= '</div>';
/*$AjaxHtml = '<table>';
$AjaxHtml .= '<tr><td><b>Total Amount</b></td><td>'.$TotalAmount.'</td><tr>';
$AjaxHtml .= '</table>';

	
				$AjaxHtml .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	

			 foreach($arryOpenPO as $key=>$values){

				if(!empty($values["VendorName"])){
					$VendorName = $values["VendorName"];
				}else{
					$VendorName = $values["SuppCompany"];
				}
$AjaxHtml .= '<tr>';
			$AjaxHtml .= '<td>
			<a class="fancybox fancybox.iframe"  href="vPO.php?module=Order&view='.$values['OrderID'].'&module=Order&pop=1">'.stripslashes($values['PurchaseID']).'</a>
			</td>';

$AjaxHtml .= '<td>';

if($values['OrderDate']>0) {
		$AjaxHtml .=''.date($Config['DateFormat'], strtotime($values['OrderDate'])).'';
}
$AjaxHtml .= '</td>';

$AjaxHtml .= '<td>
			'.stripslashes($VendorName).'
			</td>';
$AjaxHtml .= '<td>
			'.$values['TotalAmount'].' '.$values['Currency'].'
			</td>';

$AjaxHtml .='<td width="8%" style="text-align:right"><a  style="color:white;" class="action_bt" href="../warehouse/receiptOrder.php?po='.$values['OrderID'].'" target="_blank" >Receive</a></td>';

$AjaxHtml .='</tr>'; 
$TotalAmount +=$values['TotalAmount'];
                        
                 }
                 $AjaxHtml .= '<tr>
                           <td >
                           <a href="viewPO.php?module=Order">More...</a>

                           </td>
                           </tr>'; 
						   
                         
              }else{
                    $AjaxHtml .= '<tr>
                                <td  colspan="2" class="blockmsg" >
                          No quote found.
                           </td>

                           </tr>';
             }
                           
             $AjaxHtml .= '</table>';*/




        break;



 case 'VendorRm':
	/********************/
				/********************/
				
				$arryOpenPO=$objPurchase->OpenRma();
	/********************/
				$AjaxHtml = '<div>';
	if(sizeof($arryOpenPO)>0){ 
$TotalAmount=0;
			 foreach($arryOpenPO as $key=>$values){

			


$TotalAmount += $values['TotalAmount'];
}

$AjaxHtml .= '<br><br><br> 
				<h1> <font size="20"><b>'.number_format($TotalAmount,2).' </b></font> <h1>
<br><h1> <font size="20"><b> '.$Config['Currency'].'</b></font> <h1>';

$AjaxHtml .= '<br><div align="right"> <a href="../purchasing/viewRma.php">More...</a></div>';

           
              }else{
                    $AjaxHtml .= '
                          No record found.
                           ';
             }
                           
             $AjaxHtml .= '</div>';
        break;

 
case 'SalesOrder':
	define("ST_CLR_CREDIT","Clear Credit");
define("ST_TAX_APP_HOLD","Tax Approval Hold");
define("ST_CREDIT_HOLD","Credit Hold");
define("ST_CREDIT_APP","Credit Approved");
	/********************/
				$_GET['key']=''; 
				$_GET['sortby']=''; 
				$_GET['module']='Order'; 
				$_GET['Status'] = 'Open';
				$_GET['Limit'] = '10';
				$arryOpenSO=$objSale->ListSale($_GET);
				/********************/
          
	$AjaxHtml = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	 if(sizeof($arryOpenSO)>0){
	

		$flag=true;
		$Line=0;$TotalAmount=0;
		foreach($arryOpenSO as $key=>$values){
			$flag=!$flag;			
			$Line++;
		

$TotalAmount +=$values['TotalAmount'];

/*$AjaxHtml .= '<tr>';
			$AjaxHtml .= '<td>
			<a class="fancybox fancybox.iframe"  href="vSalesQuoteOrder.php?module=Order&view='.$values['OrderID'].'&module=Order&pop=1">'.stripslashes($values['SaleID']).'</a>
			</td>';

$AjaxHtml .= '<td>';

if($values['OrderDate']>0) {
		$AjaxHtml .=''.date($Config['DateFormat'], strtotime($values['OrderDate'])).'';
}
$AjaxHtml .= '</td>';

$AjaxHtml .= '<td>
			'.stripslashes($values["CustomerName"]).'
			</td>';
$AjaxHtml .= '<td>
			'.$values['TotalAmount'].' '.$values['CustomerCurrency'].'
			</td>';

$AjaxHtml .='</tr>'; */
                        
                 }

$AjaxHtml .= '<br><br><br> 
				<h1> <font size="20"><b>'.number_format($TotalAmount,2).' </b></font> <h1>
<br><h1> <font size="20"><b> '.$Config['Currency'].'</b></font> <h1>';

$AjaxHtml .= '<br><div align="right"> <a href="../sales/viewSalesQuoteOrder.php?module=Order">More...</a></div>';

           
              }else{
                    $AjaxHtml .= '
                          No record found.
                           ';
             }
                           
             $AjaxHtml .= '</div>';




            
        break;

 



}


if (!empty($AjaxHtml)) {
    echo $AjaxHtml;
    exit;
}


?>
