<?php	session_start();
	$Prefix = "../../"; 

	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/MyMailer.php");  
	require_once($Prefix."classes/configure.class.php");
	require_once("language/english.php");

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}


	$objConfig=new admin();
        $objRegion=new region();
	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	CleanGet();

	$objCompany=new company(); 
	$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
	$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
	$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
	$Config['AdminEmail'] = $arryCompany[0]['Email'];
	$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';

	 
	if($_SESSION['currency_id']>0){
		$arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'],'');
		$Config['Currency'] = $arrySelCurrency[0]['code'];
		$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
		$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
		$Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value'];
	}
        
 

	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
	
	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	switch($_GET['action']){			   
		case 'getVendorInvoice':
			global $Config;
			$objBankAccount=new BankAccount();
			$objCommon=new common();
			$objReport = new report();  	
			/*****************/			
			if($_GET['TransactionID']>0){
				$arryTransaction = $objReport->getPaymentTransaction($_GET);
				if(!empty($arryTransaction[0]['TransactionID'])){
					$TransactionID = $arryTransaction[0]['TransactionID'];
					$arryPaymentDetail = $objReport->GetPaymentTransactionDetail($TransactionID,'','Purchase'); 	$EditInvoiceIDs='';
					foreach($arryPaymentDetail as $keyinv=>$valuesinv){
						$Inv = $valuesinv['InvoiceID'];
						$arryTr[$Inv]["InvoiceID"] = $Inv; 
						$arryTr[$Inv]["CreditAmnt"] = $valuesinv['CreditAmnt'];
						$arryTr[$Inv]["ConversionRate"] = $valuesinv['ConversionRate'];
						$EditInvoiceIDs .= "'".$Inv."',";
					}
					$_GET['InvoiceIDP'] = rtrim($EditInvoiceIDs,",");
					/*****Contra********/	
					unset($_GET['TransactionID']);
					$_GET['ContraID'] = $TransactionID;
					$arryContraTr = $objReport->getPaymentTransaction($_GET);
					if(!empty($arryContraTr[0]['TransactionID'])){
						$ContraTransactionID = $arryContraTr[0]['TransactionID'];
						$_GET['confirm']=1;
						$arryPaymentContra = $objReport->GetPaymentTransactionDetail($ContraTransactionID,'','Sales'); 		$EditInvoiceIDs='';
						foreach($arryPaymentContra as $keyinv2=>$valuesinv2){
							$Inv = $valuesinv2['InvoiceID'];
							$arryTrC[$Inv]["InvoiceID"] = $Inv; 
							$arryTrC[$Inv]["DebitAmnt"] = $valuesinv2['DebitAmnt'];
							$arryTrC[$Inv]["ConversionRate"] = $valuesinv2['ConversionRate'];
							$EditInvoiceIDs .= "'".$Inv."',";
						}
						$_GET['InvoiceIDS'] = rtrim($EditInvoiceIDs,",");
					}
					/*****Contra********/
				}
			}
			/*****************/	

			if($_GET['confirm'] == 1){
				$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');

				$ArContraAccount = $objCommon->getSettingVariable('ArContraAccount');
				$ApContraAccount = $objCommon->getSettingVariable('ApContraAccount');
				 if (empty($ArContraAccount)) {
				$ErrorMsg  = SELECT_CON_AR;
				}
				$AjaxHtml  .='<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tbody>
				<tr>
				<td class="message" align="center"> '.$ErrorMsg.' </td>
				</tr></tbody></table>';

			}   
		
	    if(empty($ErrorMsg)){    //check error  by bhoodev   
		if(!empty($_GET['SuppCode'])){
                            $arryInvoice=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
                            $num=$objBankAccount->numRows();
                      
				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
                                                   <tr align="left">
                                                               <td class="head1" align="center" width="1%">Select</td>
                                                               <td width="10%"  class="head1">Invoice Date</td>
                                                               <td width="10%" class="head1">Invoice #</td>
                                                               <td width="12%" class="head1">Reference No.</td>
                                                               <td width="12%" class="head1" >Invoice Amount</td>
<td width="10%" class="head1" >Conversion Rate</td>
                                                               <td width="15%" align="left" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" align="left" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td  align="right" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

                                                   </tr>';
   
	
	if(is_array($arryInvoice) && $num>0){
	$flag=true;
	$Line=0;
        $openBalance = 0;
	$sumPayAmount=0;
        $totalOpenBalance = 0;
	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
	$TotalAmount = $values['TotalAmount'];
	$Inv = $values["InvoiceID"];
	
	$idPay=0;$PayAmount=0; $checked = '';	
	if($Inv==$arryTr[$Inv]["InvoiceID"]){
		$checked = 'checked';
		$PayAmount = $arryTr[$Inv]["CreditAmnt"];	
		$sumPayAmount += $PayAmount;	
		$values['paidAmnt'] = $values['paidAmnt']-$PayAmount;
	}

	$ConversionRate=""; $DisplayConvers = 'style="display:none"';	
	/****************/	
	if($values['Currency']!=$Config['Currency']){
		if($arryTr[$Inv]["InvoiceID"]!=''){ 
			$ConversionRate = $arryTr[$Inv]["ConversionRate"];
		}else{ 
			$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
		}

		$TotalAmount=$ConversionRate * $TotalAmount;
		$TotalAmount = round($TotalAmount,2);
		
		$orderTotalAmount = round($orderTotalAmount*$ConversionRate,2);		
		$DisplayConvers = '';	
	}
	
        if($values['paidAmnt'] > 0){ 
		$openBalance =  $TotalAmount-$values['paidAmnt']; 
        }else{  
            $openBalance =  $TotalAmount; 
        }

        $openBalance = number_format($openBalance,'2','.','');
        if($openBalance>0) $totalOpenBalance += $openBalance;
        
        $openBalance2 = $openBalance - $PayAmount;
        
        if($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3'){
		$InvoiceID = '<a href="vOtherExpense.php?pop=1&amp;Flag='.$Flag.'&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';

	 	$PONumber = $values['PurchaseID'];
	}else  if($values['InvoiceEntry'] == 1){
		$InvoiceID = $InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;IE=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';

		$PONumber = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }else{
		$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
		$PONumber = '<a href="../purchasing/vPO.php?pop=1&amp;module=order&amp;po='.$values['PurchaseID'].'" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }
     
	



        
	$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.'>
                        <td align="center"><input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')" '.$checked.'>
                            <input name="InvoiceID_'.$Line.'" type="hidden" id="InvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
		            <input name="PurchaseID_'.$Line.'" type="hidden" id="PurchaseID_'.$Line.'" value="'.$values['PurchaseID'].'"  />
                            <input type="hidden" name="OrderID_'.$Line.'" id="OrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
                            <input type="hidden" name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$orderTotalAmount.'">
                            <input type="hidden" name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'">    
                             </td>';
                         $AjaxHtml .='<td>'.$values['PostedDate'].'</td>';    
			 $AjaxHtml .='<td>'.$InvoiceID.'</td>';
			 
                         $AjaxHtml .='<td>'.$PONumber.'</td>';
                         
                           $AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['Currency'].'<input type="hidden" name="TotalAmountOld_'.$Line.'" id="TotalAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"></td>';
			$AjaxHtml .= '<td><input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate_'.$Line.'" id="ConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';
                         $AjaxHtml .= '<td align="left"><input type="text" class="normal" size="10" readonly name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalAmount.'"></td>';
                         $AjaxHtml .= '<td align="left"><input type="hidden" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="openBalance_'.$Line.'" id="openBalance_'.$Line.'" value="'.$openBalance2.'"><input type="hidden" name="paidAmnt_'.$Line.'" id="paidAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';
                         $AjaxHtml .= '<td align="right"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arryInvoice) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right"  ><strong>Total Payment : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment" id="total_payment" value="'.$sumPayAmount.'"></strong></td>
                     </tr>
              </table>
                <input type="hidden" name="totalInvoice" id="totalInvoice" value="'.$num.'">
                    <input type="hidden" name="ContraAcnt" id="ContraAcnt" value="'.$_GET['confirm'].'">
                    <input type="hidden" name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">
                 <input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
            </td>
            </tr>
            </table> ';
            }

          } 
if($_GET['confirm'] ==1){
	if(!empty($_GET['SuppCode'])){
		$arryVendor = $objBankAccount->GetSupplier('',$_GET['SuppCode'],'');
		$arryLinkCustVen = $objBankAccount->GetCustomerVendor('',$arryVendor[0]['SuppID']);
		$_GET['custID'] = $arryLinkCustVen[0]['CustID'];
	}

	if(!empty($_GET['custID'])){

			$CustomerName = $objBankAccount->getCustName($_GET['custID']);
                            	$_GET['InvoicePaid'] = 'Paid';
			    $arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
                            $num=$objBankAccount->numRows();
                      
				$AjaxHtml  .= '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	<tr>
				<td  class="head"> AR Invoice</td>
				</tr>
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
                                                   <tr align="left">
                                                               <td width="1%" class="head1" align="center">Select</td>
                                                               <td width="10%"  class="head1">Invoice Date</td>
                                                               <td width="10%" class="head1">Invoice#</td>
                                                               <td width="12%" class="head1">Sales Person</td>
<td width="10%" class="head1" >Invoice Amount</td>
<td width="12%" class="head1" >Conversion Rate</td>


                                                               <td width="15%" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="13%" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td  align="right" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

                                                   </tr>';
   
	
	if(is_array($arrySale) && $num>0){
	$flag=true;
	$Line2=0;
	$openBalance = 0;
	$totalOpenBalance = 0;
	$sumPayAmount=0;
	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line2++;

	$Inv = $values["InvoiceID"];
	
	$idPay=0;$PayAmount=0; $checked = '';	
	if($Inv==$arryTrC[$Inv]["InvoiceID"]){
		$checked = 'checked';
		$PayAmount = $arryTrC[$Inv]["DebitAmnt"];	
		$sumPayAmount += $PayAmount;	
		//$values['paidAmnt'] = $values['paidAmnt']-$PayAmount;
	}




	$TotalInvoiceAmount = $values['TotalInvoiceAmount'];
	$ConversionRate=""; $DisplayConvers = 'style="display:none"';	
	/****************/
	if($values['CustomerCurrency']!=$Config['Currency']){
		$ConversionRate=CurrencyConvertor(1,$values['CustomerCurrency'],$Config['Currency']);
		$TotalInvoiceAmount=$ConversionRate * $TotalInvoiceAmount;

		$TotalInvoiceAmount = round($TotalInvoiceAmount,2);
		$DisplayConvers = '';	
	}
	/****************/





        if($values['receivedAmnt'] > 0){
         	$openBalance =  $TotalInvoiceAmount-$values['receivedAmnt']; 
        }else{
            $openBalance =  $TotalInvoiceAmount; 
        }
       // $openBalance = number_format($openBalance,'2','.','');
        if($openBalance>0)$totalOpenBalance += $openBalance;
        
        if(!empty($values["SalesPerson"]))
        {
            $salesPerson = stripslashes($values["SalesPerson"]);
        }else{
            $salesPerson = '-';
        }
	
        if($values['InvoiceEntry'] == 1)
        {
            $InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
        }else{
         $InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
        }
        
	$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.'>
                        <td align="center"><input '.$checked.' type="checkbox" name="Arinvoice_check_'.$Line2.'" id="Arinvoice_check_'.$Line2.'" onClick="SetArPayAmntByCheck('.$Line2.')">
                            <input name="ArInvoiceID_'.$Line2.'" type="hidden" id="ArInvoiceID_'.$Line2.'" value="'.$values['InvoiceID'].'"  />
		      <input name="SaleID_'.$Line2.'" type="hidden" id="SaleID_'.$Line2.'" value="'.$values['SaleID'].'"  />
                            <input type="hidden" name="ArOrderID_'.$Line2.'" id="ArOrderID_'.$Line2.'" value="'.$values['OrderID'].'"  />    
                            <input type="hidden" name="ArTotalAmount_'.$Line2.'" id="ArTotalAmount_'.$Line2.'" value="'.$values['TotalAmount'].'"> 
                            <input type="hidden" name="ArInvoiceEntry_'.$Line2.'" id="ArInvoiceEntry_'.$Line2.'" value="'.$values['InvoiceEntry'].'"> 
                             </td>';
                         $AjaxHtml .='<td >'.$values['InvoiceDate'].'</td>';    
			 $AjaxHtml .='<td>'.$InvoiceID.'</td>'; 
                         $AjaxHtml .= '<td>'.$salesPerson.'</td>';

			$AjaxHtml .= '<td>'.$values['TotalInvoiceAmount'].' '.$values['CustomerCurrency'].'<input type="hidden" name="ArTotalInvoiceAmountOld_'.$Line2.'" id="ArTotalInvoiceAmountOld_'.$Line2.'" value="'. $values['TotalInvoiceAmount'].'"></td>';
			$AjaxHtml .= '<td><input type="text" onchange="Javascript:ChangeConversionrate('.$Line2.');" name="ArConversionRate_'.$Line.'" id="ArConversionRate_'.$Line2.'" value="'.$ConversionRate.'" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

                         $AjaxHtml .= '<td><input type="text" class="normal" size="10" readonly name="ArTotalInvoiceAmount_'.$Line.'" id="ArTotalInvoiceAmount_'.$Line.'" value="'.$TotalInvoiceAmount.'"></td>';
                         $AjaxHtml .= '<td><input type="hidden" class="normal" size="10" readonly name="Arinvoice_amnt_'.$Line2.'" id="Arinvoice_amnt_'.$Line2.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="AropenBalance_amnt_'.$Line2.'" id="AropenBalance_amnt_'.$Line2.'" value="'.$openBalance.'"><input type="hidden" name="ArreceivedAmnt_'.$Line2.'" id="ArreceivedAmnt_'.$Line2.'" value="'. $values['receivedAmnt'].'"></td>';
                         $AjaxHtml .= '<td align="right"><input type="text" name="Arpayment_amnt_'.$Line2.'" id="Arpayment_amnt_'.$Line2.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetArPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arrySale) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right" ><strong>Total Payment :  <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="Artotal_payment" id="Artotal_payment" value="'.$sumPayAmount.'"></strong></td>
                     </tr>
              </table>
                <input type="hidden" name="ArtotalInvoice" id="ArtotalInvoice" value="'.$num.'">
                    
		<input type="hidden" name="CustomerName" id="CustomerName" value="'.$_GET['custID'].'">
                    <input type="hidden" name="ArtotalOpenBalance" id="ArtotalOpenBalance" value="'.$totalOpenBalance.'">
                 <input type="hidden" name="ArsavePaymentInfo" id="ArsavePaymentInfo" value="Yes">   
            </td>
            </tr>
            </table> </div>';
            }

          } else{
 $AjaxHtml  .='<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tbody>
<tr>
<td class="message" align="center"> There is no customer link with vendor. </td>
</tr></tbody></table>';

} // end check custID
} //end check contra 
}//end error check			
			
							
			break;
			exit;                       
               
                         
                         
               case 'getVendorPaymentMethod':
			 $objBankAccount=new BankAccount();
                            Global $Config;

			if(!empty($_GET['SuppCode'])){

			 $paymentMethod = $objBankAccount->getVendorPaymentMethod($_GET['SuppCode']);
			 
			 $AjaxHtml  = $paymentMethod;
			}
			 break;
			 exit;         
                           


	case 'CheckContraAP':  
			if($_GET['SuppCode']!=''){
				$objBankAccount=new BankAccount();
				$arryVendor = $objBankAccount->GetSupplier('',$_GET['SuppCode'],'');
				if($arryVendor[0]['SuppID']>0){
				$arryLinkCustVen = $objBankAccount->GetCustomerVendor('',$arryVendor[0]['SuppID']);
				$AjaxHtml = $arryLinkCustVen[0]['CustID'];
				}
			}
			break;	
	
	case 'DefaultCheckNumber':
			$objBankAccount=new BankAccount();
			$arryBankAccount = $objBankAccount->getBankAccountById($_GET['BankAccountID']);	
			$arryLastCheck = $objBankAccount->GetMaxCheckNumber($_GET['BankAccountID'], 'Purchase'); 

			$arryLastCheck[0]['OrigCheckNumber'].' - '.$arryLastCheck[0]['MaxCheckNumber'];

			$LastCheckNumber = $arryBankAccount[0]['NextCheckNumber'];
			$BankName = $arryBankAccount[0]['BankName'];
			$arryBankData['BankName'] = $BankName;
			if(!empty($LastCheckNumber)){
				if($arryLastCheck[0]['MaxCheckNumber']>$LastCheckNumber){
					$LastCheckNumber = $arryLastCheck[0]['OrigCheckNumber'];
				}
	   
				$OrigLen = strlen($LastCheckNumber);
				$IntLen = strlen((int)$LastCheckNumber);
				$padding0 = $OrigLen - 	$IntLen;
				$NextCheckNumber = $LastCheckNumber + 1;

				$FinalLen = strlen($NextCheckNumber) + $padding0;
				if($padding0>0) $NextCheckNumber = str_pad($NextCheckNumber, $FinalLen, '0', STR_PAD_LEFT);

				$arryBankData['NextCheckNumber'] = $NextCheckNumber;
			}
			echo json_encode($arryBankData);exit;

			break;



	}	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	



?>
