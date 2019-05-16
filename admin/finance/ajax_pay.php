<?php	session_start();
	$Prefix = "../../"; 

	date_default_timezone_set('America/New_York');

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
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/pager.ajax.php");
	require_once("../language/english.php");
	require_once("language/english.php");

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}
	


	$objConfig=new admin();
        $objRegion=new region();
	$objPager=new pager();
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

	 
	if(!empty($_SESSION['currency_id'])){
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
			$objTransaction=new transaction();
			$HideUnwanted = ' width="1%" style="display:none"';
			$TransactionID='';
			$AjaxHtml ='';
			$ErrorMsg ='';
			$arryTr = array();
			/*****************/			
			if($_GET['TransactionID']>0){
				$_GET['PaymentType'] = 'Purchase';
				$arryTransaction = $objReport->getPaymentTransaction($_GET);
				if(!empty($arryTransaction[0]['TransactionID'])){
					$TransactionID = $arryTransaction[0]['TransactionID'];
					$arryPaymentDetail = $objReport->GetPaymentTransactionDetail($TransactionID,'','Purchase'); 	$EditInvoiceIDs=''; $EditCreditIDs='';
					//echo '<pre>';print_r($arryPaymentDetail);exit;
					foreach($arryPaymentDetail as $keyinv=>$valuesinv){
						if(!empty($valuesinv['InvoiceID'])){
							$Inv = $valuesinv['InvoiceID'];
							$arryTr[$Inv]["InvoiceID"] = $Inv; 
							$arryTr[$Inv]["CreditAmnt"] = $valuesinv['CreditAmnt'];
							$arryTr[$Inv]["ConversionRate"] = $valuesinv['ConversionRate'];
							$arryTr[$Inv]["PayAmount"] = $valuesinv['OriginalAmount'];
							$EditInvoiceIDs .= "'".$Inv."',";
						}else if(!empty($valuesinv['CreditID'])){
							$Crd = $valuesinv['CreditID'];
							$arryTr[$Crd]["CreditID"] = $Crd; 
							$arryTr[$Crd]["CreditAmnt"] = $valuesinv['CreditAmnt'];
							$arryTr[$Crd]["ConversionRate"] = $valuesinv['ConversionRate'];
							$arryTr[$Crd]["PayAmount"] = $valuesinv['OriginalAmountCr'];
							$EditCreditIDs .= "'".$Crd."',";
						}
					}
					$_GET['InvoiceIDP'] = rtrim($EditInvoiceIDs,",");
					$_GET['CreditIDS'] = rtrim($EditCreditIDs,",");
					/*****Contra********/	
					unset($_GET['TransactionID']);
					if(!empty($arryTransaction[0]['ContraID'])){
						$_GET['TransactionID'] = $arryTransaction[0]['ContraID'];
					}else{
						$_GET['ContraID'] = $TransactionID;				
					}
					$_GET['PaymentType'] = 'Sales';							
					$arryContraTr = $objReport->getPaymentTransaction($_GET);
					if(!empty($arryContraTr[0]['TransactionID'])){
						$ContraTransactionID = $arryContraTr[0]['TransactionID'];
						$arryPaymentContra = $objReport->GetPaymentTransactionDetail($ContraTransactionID,'','Sales'); 		$EditInvoiceIDs='';
						foreach($arryPaymentContra as $keyinv2=>$valuesinv2){
							$Inv = $valuesinv2['InvoiceID'];
							$arryTrC[$Inv]["InvoiceID"] = $Inv; 
							$arryTrC[$Inv]["DebitAmnt"] = $valuesinv2['DebitAmnt'];
							$arryTrC[$Inv]["ConversionRate"] = $valuesinv2['ConversionRate'];
							$arryTrC[$Inv]["PayAmount"] = $valuesinv2['OriginalAmount'];
							$EditInvoiceIDs .= "'".$Inv."',";
						}
						$_GET['InvoiceIDS'] = rtrim($EditInvoiceIDs,",");
					}
					/*****Contra********/
				}
			}
			/*****************/	
			if(!empty($_GET['transferVendorFund'])){$Config['TransferFund'] = 1;}
			/*******Exclude Session Transaction********/
			unset($_GET['ExcludeInvoiceIDs']);			
			$arrySessionTransaction = $objTransaction->ListSessionTransaction('AP',$TransactionID,'Invoice');
			$SessInvoiceIDs='';
			foreach($arrySessionTransaction as $kinv=>$valinv){
				if(!empty($valinv['InvoiceID'])){
					$SessInvoiceIDs .= "'".$valinv['InvoiceID']."',";
				}
			}
			$_GET['ExcludeInvoiceIDs'] = rtrim($SessInvoiceIDs,",");
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
		
	    if(empty($ErrorMsg)){   
		if(!empty($_GET['SuppCode'])){  
			    $SearchKey   = trim($_GET['key']);
			    (!$_GET['curP'])?($_GET['curP']=1):(""); 
			    $Config['RecordsPerPage'] = 50;
			    $Config['StartPage'] = ($_GET['curP']-1)*$Config['RecordsPerPage'];
                            $arryInvoice=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
                            $num=$objBankAccount->numRows();
			    /***********Count Records****************/	
			    $Config['GetNumRecords'] = 1;
			    $arryCount=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
			    $numCount=$arryCount[0]['NumCount'];	
	 		    $pagerLink=$objPager->getPaging($numCount,$Config['RecordsPerPage'],$_GET['curP'],'');	

              
				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	<tr>
				<td  class="head"> AP Invoice </td>';
				$PagingHtml ='';
				if($numCount>$num) $PagingHtml = '&nbsp;&nbsp;&nbsp;&nbsp;Page: '.$pagerLink;

				$AjaxHtml  .= '<td  class="head" align="right"><input type="text" name="SearchKey" id="SearchKey" class="inputbox" maxlength="20" placeholder="Search Invoice/Reference No." value="'.$SearchKey.'" onkeypress="return SearchInvoiceEnter(event);">&nbsp;<input name="search" type="button" class="search_button" value="Go" onclick="Javascript:SearchInvoice();">  '.$PagingHtml.'</td>';

				$AjaxHtml  .= '</tr>					
						<tr>
						<td><a href="Javascript:AddAllToTransaction();" id="addallrow" class="add" style="float:left; display:none">Add</a></td>
						</tr>

                                               <tr>
                                               <td valign="top" colspan="2">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
                                                   <tr align="left">
                                                               <td class="head1" align="center" width="1%">Select</td>
                                                               <td width="15%"  class="head1">Invoice Date</td>
                                                               <td width="10%" class="head1">Invoice #</td>
                                                               <td width="12%" class="head1">Reference No.</td>
                                                               <td width="15%" class="head1" >Invoice Amount</td>
<td '.$HideUnwanted.' class="head1" >Conversion Rate</td>
                                                               <td '.$HideUnwanted.'  class="head1" >Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" align="left" class="head1">Open Balance</td>
                                                               <td  align="right" class="head1">Payment</td>

                                                   </tr>';
   
	
	if(is_array($arryInvoice) && $num>0){
	$flag=true;
	$Line=0;
        $openBalance = 0;
	$sumPayAmount=0;
        $totalOpenBalance = 0;
	$Flag='';
	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
	$TotalAmount = $values['TotalAmount'];
	$Inv = $values["InvoiceID"];	
	$idPay=0;$PayAmount=0; $checked = '';
	$ConversionRate=""; $DisplayConvers = 'style="display:none"';
	$values['paidAmnt'] = round($values['paidAmnt'],2);
	/****************/	
	if($values['Currency']!=$Config['Currency']){
		if(!empty($arryTr[$Inv]["InvoiceID"])){ 
			$ConversionRate = $arryTr[$Inv]["ConversionRate"];
		}else{ 	
			
			if(empty($arryCurrencyVal[$values['Currency']])){
				$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency'],'AP',$_GET['PaymentDate']);
				$arryCurrencyVal[$values['Currency']]=$ConversionRate;
			}else{
				$ConversionRate=$arryCurrencyVal[$values['Currency']];
			}
		}

		#$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount),2); 
		#$orderTotalAmount = round(GetConvertedAmount($ConversionRate, $orderTotalAmount),2);			
		$DisplayConvers = '';	
		if(!empty($values['paidAmntTr'])){
			$values['paidAmnt'] = $values['paidAmntTr'];
		}else{
			
			$values['paidAmnt'] = round(GetConvertedAmountReverse($ConversionRate, $values['paidAmnt']),2);	
		}
	}
	/****************/
	if(!empty($arryTr[$Inv]["InvoiceID"])){	
		if($Inv==$arryTr[$Inv]["InvoiceID"]){
			$checked = 'checked';
			$PayAmount = $arryTr[$Inv]["PayAmount"];	 //CreditAmnt
			$sumPayAmount += $PayAmount;	
			$values['paidAmnt'] = $values['paidAmnt']-$PayAmount;
		}
	}
	/****************/	
        if(!empty($values['paidAmnt'])){ 
		$openBalance =  $TotalAmount-$values['paidAmnt']; 
        }else{  
            $openBalance =  $TotalAmount; 
        }

        $openBalance = round($openBalance,'2');
        if($openBalance>0) $totalOpenBalance += $openBalance;
        
        $openBalance2 = round(($openBalance - $PayAmount),2);
        
	$TrShowHide ='';
	if($values['TotalAmount']>0){
		$TrShowHide = ($openBalance2>0)?(''):('style="display:none2"');
	}else if($values['TotalAmount']<0){
		
	}



	if(!empty($checked)) $TrShowHide ='';


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
     
	



        
		$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.' '.$TrShowHide.'>
		<td align="center">   <input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')" '.$checked.'>  
		<input name="InvoiceID_'.$Line.'" type="hidden" readonly id="InvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
		<input name="PurchaseID_'.$Line.'" type="hidden" readonly id="PurchaseID_'.$Line.'" value="'.$values['PurchaseID'].'"  />
		<input type="hidden" readonly  name="OrderID_'.$Line.'" id="OrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
		<input type="hidden" readonly  name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$orderTotalAmount.'">
		<input type="hidden" readonly  name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'">    
		</td>';

		$AjaxHtml .='<td>'.$values['PostedDate'].'</td>';    
		$AjaxHtml .='<td>'.$InvoiceID.'</td>';

		$AjaxHtml .='<td>'.$PONumber.'</td>';

		$AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['Currency'].'<input type="hidden" readonly  name="TotalAmountOld_'.$Line.'" id="TotalAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"></td>';

		$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate_'.$Line.'" id="ConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox disabled" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

		$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" class="normal" size="10" readonly name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalAmount.'"></td>';

		$AjaxHtml .= '<td align="left"><input type="hidden" readonly  class="normal" size="10" name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="openBalance_'.$Line.'" id="openBalance_'.$Line.'" value="'.$openBalance2.'"><input type="hidden"  readonly name="paidAmnt_'.$Line.'" id="paidAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';

		$AjaxHtml .= '<td align="right"><a href="Javascript:AddToTransaction('.$Line.');" id="addrow_'.$Line.'" class="add" style="float:left;display:none">Add</a><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKeyNeg(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }

	if($_GET['BankCurrency']!=$Config['Currency']){			
		$ConversionRateGL = CurrencyConvertor(1,$_GET['BankCurrency'],$Config['Currency'],'AP',$_GET['PaymentDate']);
	}else{
		$ConversionRateGL = 1;
	}
  
	$AjaxHtml .= '<input type="hidden" readonly name="ConversionRateGL" id="ConversionRateGL" value="'.$ConversionRateGL.'" readonly>';

            if(is_array($arryInvoice) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right"  ><strong>Total Payment : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly name="total_payment" id="total_payment" value="'.$sumPayAmount.'"></strong></td>
                     </tr>
              </table>
                <input type="hidden" readonly  name="totalInvoice" id="totalInvoice" value="'.$num.'">
		<input type="hidden" readonly  name="curPage" id="curPage" value="'.$_GET['curP'].'">
                    <input type="hidden" readonly  name="ContraAcnt" id="ContraAcnt" value="'.$_GET['confirm'].'">
		

                    <input type="hidden" readonly  name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">
                 <input type="hidden" readonly  name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
            </td>
            </tr>
            </table> ';
            }

          } 




	/**************Vendor Credit Note****************/
	/**************************************************/
	 

	/*******Exclude Session Transaction********/
	unset($_GET['ExcludeCreditIDs']);
	$arrySessionTransaction = $objTransaction->ListSessionTransaction('AP',$TransactionID,'Credit');
	$SessCreditIDs='';
	foreach($arrySessionTransaction as $kinv=>$valinv){
		if(!empty($valinv['CreditID'])){
			$SessCreditIDs .= "'".$valinv['CreditID']."',";
		}
	}
	$_GET['ExcludeCreditIDs'] = rtrim($SessCreditIDs,",");
	/*****************/


	$arryCredit=$objTransaction->ListOpenAPCreditNote($_GET);
	$numCredit=$objTransaction->numRows();
	if($numCredit>0){
		$AjaxHtml  .= '<br><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>
				<td  class="head">Vendor Credit Memo / Overpaid Invoices</td>
			</tr>
			<tr>
						<td><a href="Javascript:AddAllToTransactionCr();" id="addallrowcr" class="add" style="float:left; display:none">Add</a></td>
						</tr>
			<tr>

                               <td valign="top">
	                       <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
	                           <tr align="left">
	                                       <td width="1%" class="head1" align="center">Select</td>

	                                       <td width="15%"  class="head1">Posted Date</td>
	                                      <td width="20%" class="head1">Credit Memo#/ Invoice#</td>
	                                 
						<td width="12%" class="head1" >Total Amount</td>
						<td '.$HideUnwanted.' class="head1" >Conversion Rate</td>


	                                       <td '.$HideUnwanted.'  class="head1" >Original Amount&nbsp;('.$Config['Currency'].')</td>
	                                       <td width="15%" class="head1">Open Balance</td>
	                                       <td  class="head1" align="right">Applied Amount</td>

	                           </tr> ';

	/**********************/    
	
		$flag=true;
		$Line=0;
		$openBalanceCr = 0;
		$sumPayAmountCr=0;
		$totalOpenBalanceCr = 0;
		foreach($arryCredit as $key=>$values){
			$flag=!$flag;
			
			

			$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
			$Line++;
			$Crd = $values["CreditID"];	
			$idPay=0;$PayAmount=0; $checked = '';	
			

			$TotalCreditAmount = $values['TotalAmount'];
			$ConversionRate=""; $DisplayConvers = 'style="display:none"';  
			   
			if($values['Currency']!=$Config['Currency']){
				if(!empty($arryTr[$Crd]["CreditID"])){ 
					$ConversionRate = $arryTr[$Crd]["ConversionRate"];
				}else{
					if(empty($arryCurrencyVal[$values['Currency']])){
						$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency'],'AP',$_GET['PaymentDate']);
						$arryCurrencyVal[$values['Currency']]=$ConversionRate;
					}else{
						$ConversionRate=$arryCurrencyVal[$values['Currency']];
					}
				}

				#$TotalCreditAmount= GetConvertedAmount($ConversionRate, $TotalCreditAmount); 
				#$TotalCreditAmount = round($TotalCreditAmount,2);
				$DisplayConvers = ''; 

				if(!empty($values['paidAmntTr'])){
					$values['paidAmntCr'] = $values['paidAmntTr'];
				}else{
			
					$values['paidAmntCr'] = round(GetConvertedAmountReverse($ConversionRate, $values['paidAmntCr']),2);	
				}   
			}
			if($values['paidAmntCr']!='')$values['paidAmntCr']=-$values['paidAmntCr'];

			 
			/***************/
			if(!empty($arryTr[$Crd]["CreditID"])){
			if($Crd==$arryTr[$Crd]["CreditID"]){
				$checked = 'checked';
				$PayAmount = $arryTr[$Crd]["PayAmount"];	//CreditAmnt
				if($PayAmount!='')$PayAmount=-$PayAmount;
				$sumPayAmountCr += $PayAmount;	
				$values['paidAmntCr'] = $values['paidAmntCr']-$PayAmount;
			}
			}
			/***************/
		 
		 
			if($values['paidAmntCr'] > 0){
			     $openBalanceCr =  $TotalCreditAmount-$values['paidAmntCr']; 
			}else{
			    $openBalanceCr =  $TotalCreditAmount; 
			}
		        $openBalanceCr = round($openBalanceCr,'2');
			if($openBalanceCr>0)$totalOpenBalanceCr += $openBalanceCr;
		
			$openBalanceCr2 = round(($openBalanceCr - $PayAmount),2);

			if($values['OverPaid']=="1"){
				$CreditID = '<a href="vPoInvoice.php?pop=1&amp;inv='.$values['InvoiceID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
			}else{
			 	$CreditID = '<a href="vPoCreditNote.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['CreditID'].'</a>';
			}
			
			$TrShowHide = ($openBalanceCr2>0)?(''):('style="display:none"');
		
			$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.' '.$TrShowHide.'>
			<td align="center"><input type="checkbox" '.$checked.' name="credit_check_'.$Line.'" id="credit_check_'.$Line.'" onClick="SetPayAmntByCheckCr('.$Line.')">
			<input name="CreditID_'.$Line.'" type="hidden" readonly  id="CreditID_'.$Line.'" value="'.$values['CreditID'].'"  />

			<input name="CrdInvoiceID_'.$Line.'" type="hidden" readonly id="CrdInvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
			<input name="CrdOverPaid_'.$Line.'" type="hidden" readonly id="CrdOverPaid_'.$Line.'" value="'.$values['OverPaid'].'"  />
			
			<input type="hidden"  readonly name="OrderIDCr_'.$Line.'" id="OrderIDCr_'.$Line.'" value="'.$values['OrderID'].'"  />    
			<input type="hidden"  readonly name="TotalAmountCr_'.$Line.'" id="TotalAmountCr_'.$Line.'" value="'.$values['TotalAmount'].'"> 			
			</td>';
			$AjaxHtml .='<td >'.$values['PostedDate'].'</td>';    
			$AjaxHtml .='<td>'.$CreditID.'</td>'; 
			 

			$AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['Currency'].'<input type="hidden" readonly  name="TotalCreditAmountOld_'.$Line.'" id="TotalCreditAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"><input type="hidden" readonly  name="CreditCurrency_'.$Line.'" id="CreditCurrency_'.$Line.'" value="'. $values['Currency'].'"></td>';

			$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" onchange="Javascript:ChangeConversionrateCr('.$Line.');" name="ConversionRateCr_'.$Line.'" id="ConversionRateCr_'.$Line.'" value="'.$ConversionRate.'" class="textbox disabled" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

			$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" class="normal" size="10" readonly name="TotalCreditAmount_'.$Line.'" id="TotalCreditAmount_'.$Line.'" value="'.$TotalCreditAmount.'"></td>';

			$AjaxHtml .= '<td><input type="hidden" readonly  class="normal" size="10" name="credit_amnt_'.$Line.'" id="credit_amnt_'.$Line.'" value="'.$openBalanceCr.'"><input type="text" class="normal" size="10" readonly name="openBalanceCr_'.$Line.'" id="openBalanceCr_'.$Line.'" value="'.$openBalanceCr2.'"><input type="hidden" readonly  name="paidAmnt_'.$Line.'" id="paidAmnt_'.$Line.'" value="'. $values['paidAmntCr'].'"></td>';

			$AjaxHtml .= '<td align="right"><a href="Javascript:AddCreditToTransaction('.$Line.');" id="addrowcr_'.$Line.'" class="add" style="float:left;display:none">Apply</a> <input type="text" name="payment_amntcr_'.$Line.'" id="payment_amntcr_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmntCr()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'" ></td></tr>';
				       
			    
		     } 
		  
	   
		  
		$AjaxHtml .= '	 </table>
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>  
			<td align="right" colspan="9"><strong>Total Applied Amount : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly name="total_paymentcr" id="total_paymentcr" value="'.$sumPayAmountCr.'"></strong></td>
			</tr>
			 <input type="hidden"  readonly name="totalCredit" id="totalCredit" value="'.$numCredit.'">			
			
			<input type="hidden"  readonly name="totalOpenBalanceCr" id="totalOpenBalanceCr" value="'.$totalOpenBalanceCr.'">
			</table>

			</td></tr></table>';
		}
	  
 

	/**************Vendor Credit Amount****************/
	/**************************************************/
 	$num55555='';
	if(empty($_GET['transferVendorFund']) && $num55555>0 && $_GET['BankCurrency']==$Config['Currency']){ //num invoice
	   $arrySessionCreditAmount = $objTransaction->ListSessionTransaction('AP',$TransactionID,'CreditAmount');
 	   if(sizeof($arrySessionCreditAmount)<=0){
		$VendorCreditAmount = $objBankAccount->getVendorCredit($_GET['SuppCode']);
	 	/*$DeletedCreditAmount = $objTransaction->getDeletedCreditAmount('AP',$TransactionID,'CreditAmount'); 
		if($DeletedCreditAmount>0){
			$VendorCreditAmount = $VendorCreditAmount + $DeletedCreditAmount;
		}*/
	   if($VendorCreditAmount>0){
		$OpenCreditAmount = $VendorCreditAmount;

		$AjaxHtml  .= '<br><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>
				<td  class="head"> Vendor Credit Amount</td>
				</tr>
			 
			<tr>

                               <td valign="top">
	                       <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
	                           <tr align="left">
	                                       <td width="1%" class="head1" align="center">Select</td>

						<td width="20%" class="head1" >Credit Amount&nbsp;('.$Config['Currency'].')</td>
						
	                                       <td width="20%" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
	                                       <td  class="head1" align="right">Applied Amount&nbsp;('.$Config['Currency'].')</td>

	                           </tr> 

				  <tr align="left" bgcolor="#ffffff">
	                                       <td align="center"><input type="checkbox" '.$checked.' name="credit_amount_check" id="credit_amount_check" onClick="SetPayCreditAmount(1)"></td>

						<td>'.$VendorCreditAmount.'<input type="hidden" readonly  name="VendorCreditAmount" id="VendorCreditAmount" value="'. $VendorCreditAmount .'"> </td>
						
	                                       <td> <input type="text" class="normal" size="10" readonly name="openBalanceCredit" id="openBalanceCredit" value="'.$OpenCreditAmount.'"></td>
	                                       <td align="right"> <a href="Javascript:ApplyCreditAmountToTransaction();" id="addrowcredit" class="add" style="float:left;display:none">Apply</a><input type="text" name="payment_credit_amount" id="payment_credit_amount" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayCreditAmount()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayCreditAmount.'" ></td>
				  </tr>
			</table> ';
			
		  
		 
		}
	  }
	}
	/**********************************************************/
	/**********************************************************/



if($_GET['confirm'] ==1){
	if(!empty($_GET['SuppCode'])){
		$arryVendor = $objBankAccount->GetSupplier('',$_GET['SuppCode'],'');
		$arryLinkCustVen = $objBankAccount->GetCustomerVendor('',$arryVendor[0]['SuppID']);
		$_GET['custID'] = $arryLinkCustVen[0]['CustID'];
	}

	if(!empty($_GET['custID'])){


			/*******Exclude Session Transaction********/
			unset($_GET['ExcludeInvoiceIDs']);
			$arrySessionTransaction = $objTransaction->ListSessionTransaction('AP',$TransactionID,'Contra Invoice');
			$SessInvoiceIDs='';
			foreach($arrySessionTransaction as $kinv=>$valinv){
				if(!empty($valinv['InvoiceID'])){
					$SessInvoiceIDs .= "'".$valinv['InvoiceID']."',";
				}
			}
			$_GET['ExcludeInvoiceIDs'] = rtrim($SessInvoiceIDs,",");
			/*****************/



			$CustomerName = $objBankAccount->getCustName($_GET['custID']);
                            	$_GET['InvoicePaid'] = 'Paid';
			    $arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
                            $num=$objBankAccount->numRows();
                      
				$AjaxHtml  .= '<br><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	<tr>
				<td  class="head"> AR Invoice</td>
				</tr>
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
                                                   <tr align="left">
                                                               <td width="1%" class="head1" align="center">Select</td>
                                                               <td width="12%"  class="head1">Invoice Date</td>
                                                               <td width="12%" class="head1">Invoice#</td>
                                                               <td width="13%" class="head1">Sales Person</td>
								<td width="13%" class="head1" >Invoice Amount</td>
								<td '.$HideUnwanted.'  class="head1" >Conversion Rate</td>


                                                               <td '.$HideUnwanted.' class="head1" >Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="12%" class="head1">Open Balance</td>
                                                               <td  align="right" class="head1">Payment</td>

                                                   </tr>';
   
	unset($arryCurrencyVal);   
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
	
	$TotalInvoiceAmount = $values['TotalInvoiceAmount'];
	$ConversionRate=""; $DisplayConvers = 'style="display:none"';	
	/****************/
	if($values['CustomerCurrency']!=$Config['Currency']){
		if(!empty($arryTrC[$Inv]["InvoiceID"])){ 
			$ConversionRate = $arryTrC[$Inv]["ConversionRate"];
		}else{ 
			if(empty($arryCurrencyVal[$values['CustomerCurrency']])){
				$ConversionRate=CurrencyConvertor(1,$values['CustomerCurrency'],$Config['Currency'],'AR',$_GET['PaymentDate']);
				$arryCurrencyVal[$values['CustomerCurrency']]=$ConversionRate;
			}else{
				$ConversionRate=$arryCurrencyVal[$values['CustomerCurrency']];
			}			
		}
		
		#$TotalInvoiceAmount = round(GetConvertedAmount($ConversionRate, $TotalInvoiceAmount),2); 		 
		$DisplayConvers = '';	
		if(!empty($values['receivedAmntTr'])){
			$values['receivedAmnt'] = $values['receivedAmntTr'];
		}else{
			
			$values['receivedAmnt'] = round(GetConvertedAmountReverse($ConversionRate, $values['receivedAmnt']),2);	
		}
	}
	/****************/
	if(!empty($arryTrC[$Inv]["InvoiceID"])){
	if($Inv==$arryTrC[$Inv]["InvoiceID"]){
		$checked = 'checked';
		$PayAmount = $arryTrC[$Inv]["DebitAmnt"];	
		$sumPayAmount += $PayAmount;	
		$values['receivedAmnt'] = $values['receivedAmnt']-$PayAmount;
	}
	}
	/****************/



        if($values['receivedAmnt'] > 0){
         	$openBalance =  $TotalInvoiceAmount-$values['receivedAmnt']; 
        }else{
            $openBalance =  $TotalInvoiceAmount; 
        }
        $openBalance = round($openBalance,'2');
        if($openBalance>0)$totalOpenBalance += $openBalance;
        
	$openBalance2 = round(($openBalance - $PayAmount),'2');  ;
	
	$TrShowHide = ($openBalance2>0)?(''):('style="display:none"');

        if(!empty($values["SalesPerson"])){
            $salesPerson = stripslashes($values["SalesPerson"]);
        }else{
            $salesPerson = '-';
        }
	
        if($values['InvoiceEntry'] == 1){
            	$InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
        }else{
         	$InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
        }
        
	$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.' '.$TrShowHide.'>
                        <td align="center"><input  type="checkbox" '.$checked.' name="Arinvoice_check_'.$Line2.'" id="Arinvoice_check_'.$Line2.'" onClick="SetArPayAmntByCheck('.$Line2.')">
                            <input name="ArInvoiceID_'.$Line2.'" type="hidden" readonly  id="ArInvoiceID_'.$Line2.'" value="'.$values['InvoiceID'].'"  />
		      <input name="SaleID_'.$Line2.'" type="hidden" readonly  id="SaleID_'.$Line2.'" value="'.$values['SaleID'].'"  />
                            <input type="hidden" readonly  name="ArOrderID_'.$Line2.'" id="ArOrderID_'.$Line2.'" value="'.$values['OrderID'].'"  />    
                            <input type="hidden" readonly  name="ArTotalAmount_'.$Line2.'" id="ArTotalAmount_'.$Line2.'" value="'.$values['TotalAmount'].'"> 
                            <input type="hidden" readonly name="ArInvoiceEntry_'.$Line2.'" id="ArInvoiceEntry_'.$Line2.'" value="'.$values['InvoiceEntry'].'"> 
                             </td>';
                         $AjaxHtml .='<td >'.$values['InvoiceDate'].'</td>';    
			 $AjaxHtml .='<td>'.$InvoiceID.'</td>'; 
                         $AjaxHtml .= '<td>'.$salesPerson.'</td>';

			$AjaxHtml .= '<td>'.$values['TotalInvoiceAmount'].' '.$values['CustomerCurrency'].'<input type="hidden" readonly  name="ArTotalInvoiceAmountOld_'.$Line2.'" id="ArTotalInvoiceAmountOld_'.$Line2.'" value="'. $values['TotalInvoiceAmount'].'"></td>';
			$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" onchange="Javascript:ChangeArConversionrate('.$Line2.');" name="ArConversionRate_'.$Line2.'" id="ArConversionRate_'.$Line2.'" value="'.$ConversionRate.'" class="textbox disabled" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

                         $AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" class="normal" size="10" readonly name="ArTotalInvoiceAmount_'.$Line2.'" id="ArTotalInvoiceAmount_'.$Line2.'" value="'.$TotalInvoiceAmount.'"></td>';

                         $AjaxHtml .= '<td><input type="hidden" readonly  class="normal" size="10"  name="Arinvoice_amnt_'.$Line2.'" id="Arinvoice_amnt_'.$Line2.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="AropenBalance_amnt_'.$Line2.'" id="AropenBalance_amnt_'.$Line2.'" value="'.$openBalance2.'"><input type="hidden" readonly  name="ArreceivedAmnt_'.$Line2.'" id="ArreceivedAmnt_'.$Line2.'" value="'. $values['receivedAmnt'].'"></td>';

                         $AjaxHtml .= '<td align="right"><a href="Javascript:AddContraToTransaction('.$Line2.');" id="addrov_'.$Line2.'" class="add" style="float:left;display:none">Add</a><input type="text" name="Arpayment_amnt_'.$Line2.'" id="Arpayment_amnt_'.$Line2.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetArPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arrySale) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right" ><strong>Total Payment :  <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly name="Artotal_payment" id="Artotal_payment" value="'.$sumPayAmount.'"></strong></td>
                     </tr>
              </table>
                <input type="hidden"  readonly name="ArtotalInvoice" id="ArtotalInvoice" value="'.$num.'">
                    
		<input type="hidden"  readonly name="CustomerName" id="CustomerName" value="'.$_GET['custID'].'">
                    <input type="hidden"  readonly name="ArtotalOpenBalance" id="ArtotalOpenBalance" value="'.$totalOpenBalance.'">
                 <input type="hidden"  readonly name="ArsavePaymentInfo" id="ArsavePaymentInfo" value="Yes">   
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
			if(!empty($_GET['SuppCode'])){
				$objBankAccount=new BankAccount();
				$arryVendor = $objBankAccount->GetSupplier('',$_GET['SuppCode'],'');
 
				if(!empty($arryVendor[0]['SuppID'])){
				$arryLinkCustVen = $objBankAccount->GetCustomerVendor('',$arryVendor[0]['SuppID']);
				if(!empty($arryLinkCustVen[0]['CustID']))
					$AjaxHtml = $arryLinkCustVen[0]['CustID'];
				}
			}
			break;	

	case 'DefaultCheckNumberOld':
			$objBankAccount=new BankAccount();
			$arryBankAccount = $objBankAccount->getBankAccountById($_GET['BankAccountID']);	
			$arryLastCheck = $objBankAccount->GetMaxCheckNumber($_GET['BankAccountID'], 'Purchase'); 

			$arryLastCheck[0]['OrigCheckNumber'].' - '.$arryLastCheck[0]['MaxCheckNumber'];

			$LastCheckNumber = stripslashes($arryBankAccount[0]['NextCheckNumber']);
			$BankName = stripslashes($arryBankAccount[0]['BankName']);
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

	case 'DefaultCheckNumber':
			$objBankAccount=new BankAccount();
			$arryBankAccount = $objBankAccount->getBankAccountById($_GET['BankAccountID']);	
			$arryLastCheck = $objBankAccount->GetMaxCheckNumber($_GET['BankAccountID'], 'Purchase'); 

			//$arryLastCheck[0]['OrigCheckNumber'].' - '.$arryLastCheck[0]['MaxCheckNumber'];

			$NextCheckNumber=''; 		
			

			if(!empty($arryBankAccount[0]['NextCheckNumber'])){
				$NextCheckNumber = $objBankAccount->GetNextCheckNumber($arryBankAccount[0]['NextCheckNumber']); 
			}else{
				
				if(!empty($arryLastCheck[0]['OrigCheckNumber'])){
					$LastCheckNumber = $arryLastCheck[0]['OrigCheckNumber'];
					$OrigLen = strlen($LastCheckNumber);
					$IntLen = strlen((int)$LastCheckNumber);
					$padding0 = $OrigLen - 	$IntLen;
					$NextCheckNumber = $LastCheckNumber + 1;

					$FinalLen = strlen($NextCheckNumber) + $padding0;
					if($padding0>0) $NextCheckNumber = str_pad($NextCheckNumber, $FinalLen, '0', STR_PAD_LEFT);
					
				}
			}
			
			$arryBankData['NextCheckNumber'] = $NextCheckNumber;
			$arryBankData['BankName'] = stripslashes($arryBankAccount[0]['BankName']);
			 
			echo json_encode($arryBankData);exit;

			break;

	 case 'TransactionByCheckNumber':  
			if(!empty($_GET['CheckNumber'])){
				$objBankAccount = new BankAccount();					 
				$arryTr = $objBankAccount->TransactionByCheckNumber($_GET['CheckNumber'], 'Purchase'); 
				echo json_encode($arryTr[0]);exit;
			}
			break; 


	 case 'AddToTransaction':  
			if($_GET['SuppCode']!='' && !empty($_GET['Amount'])){
				$objTransaction=new transaction();			
				$_GET['Module'] = 'AP';
				
				$AjaxHtml = $objTransaction->AddUpdateTransaction($_GET);				
			}
			break;

	case 'getCurrencyRate': 
			global $Config;	
			if($_GET['Currency']!=$Config['Currency']){			
				$ConversionRate=CurrencyConvertor(1,$_GET['Currency'],$Config['Currency'],'AP');
			}else{
				$ConversionRate=1;
			}
			$AjaxHtml = $ConversionRate;
		 	break;	

	 case 'CheckGlTransaction':  
			if($_GET['SuppCode']!='' && $_GET['AccountID']>0){
				$objTransaction=new transaction();				
				$AjaxHtml = $objTransaction->CheckGlTransactionAP($_GET['TransactionID'],$_GET['SuppCode'],$_GET['AccountID']);				
			}
			break; 

	case 'CheckTransaction':  
			if($_GET['SuppCode']!='' && ($_GET['OrderID']>0 || $_GET['PaymentType'] == 'CreditAmount')){
				$objTransaction=new transaction();
				$_GET['Module'] = 'AP';								
				$AjaxHtml = $objTransaction->CheckTransaction($_GET);				
			}
			break;


	case 'RemoveTransaction':  
			if($_GET['TrID']>0){
				$objTransaction=new transaction();
				$AjaxHtml = $objTransaction->RemoveTransactionByID($_GET['TrID']);				
			}
			break;   

	case 'ListTransaction':  
			$objTransaction=new transaction();
			 
			$TransactionID = $_GET['TransactionID'];
			/*if($TransactionID>0 && $_GET['ContraTransactionID']>0){
				$TransactionID = $TransactionID.','.$_GET['ContraTransactionID'];
			}*/

			if(!empty($_GET['transferVendorFund'])){$Config['TransferFund'] = 1;}


			$arryTransaction = $objTransaction->ListSessionTransaction('AP',$TransactionID ,'');
			//echo '<pre>';print_r($arryTransaction);exit;
			$AjaxHtml = '<table width="100%" id="list_table" border="0" align="center" cellpadding="3" cellspacing="1" >  <tr>
				<td class="head1" colspan="11"> Saved Payment Data</td>
				</tr>
				<tr align="left">  
					<td width="1%"  class="head1"> </td> 
					<td width="6%"  class="head1">Type</td>
					<td width="11%"  class="head1">Vendor</td>';

			if(empty($_GET['transferVendorFund'])) $AjaxHtml .= '<td width="11%"  class="head1">Customer</td>';
					
			$AjaxHtml .= '<td width="10%"  class="head1">Invoice Date</td>   
					<td width="8%" class="head1">Invoice # </td>	
					<td width="8%" class="head1">Reference # </td>					
					<td width="15%" class="head1">GL Account</td>
					<td width="10%" class="head1">Credit Memo #</td>';	
		 

			if(!empty($_GET['transferVendorFund'])) $AjaxHtml .= '<td width="9%" class="head1">Description</td>';


			 $ModuleCurrency = (!empty($arryTransaction[0]['ModuleCurrency'])) ? ("(".$arryTransaction[0]['ModuleCurrency'].")") : ("");

			$AjaxHtml .= '<td align="right"    class="head1">Payment Amount '.$ModuleCurrency.'</td>
					<td  align="right" class="head1" style="display:none">Payment Amount ('.$Config['Currency'].')</td>
				</tr>';
			$sumPayAmount=0;$TotalOriginalAmount=0;
			$Line=0;$flag=$Flag='';
			foreach($arryTransaction as $key=>$values){
				$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
				$sumPayAmount += $values['Amount'];
				$TotalOriginalAmount += $values['OriginalAmount']; 
				$Line++;
				
				if(!empty($values['CustomerName'])){
					$CustomerName = '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" >'.stripslashes($values['CustomerName']).'</a>';
				}else{
					$CustomerName = '';
				}

				if(!empty($values['VendorName'])){
					$VendorName = '<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$values['SuppCode'].'" >'.stripslashes($values['VendorName']).'</a>';
				}else{
					$VendorName = '';
				}

				$InvoiceDate ='';$InvoiceID='';	$InvoiceDate='';$CredetID=''; 
				$PaymentType = $values['PaymentType'];
				if($PaymentType=='Invoice'){				 
					$InvoiceDate = $values['PostedDate'];					
					if($values['PInvoiceEntry'] == '2' || $values['PInvoiceEntry'] == '3'){
						$InvoiceID = '<a href="vOtherExpense.php?pop=1&amp;Flag='.$Flag.'&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';
					 	
					}else  if($values['PInvoiceEntry'] == 1){
						$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;IE=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';

					}else{
						$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
						
					}

				}else if($PaymentType=='Contra Invoice'){					 
					$InvoiceDate = $values['InvoiceDate'];
					 
					if($values['InvoiceEntry'] == 1){
				    		$InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
					}else{
				 		$InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
					}
				}else if($PaymentType=='Credit'){	
					$InvoiceDate = $values['PostedDate'];					 
					$CredetID = '<a href="vPoCreditNote.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['CreditID'].'</a>';
					if($values['OverPaid']=='1'){	
						$PaymentType = 'Invoice';
						$CredetID ='';
						$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;inv='.$values['InvoiceID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
					}

				}

				$TotalOriginalAmount = round($TotalOriginalAmount,2);			
				if($TotalOriginalAmount=='-0'){
					$TotalOriginalAmount = '0';
				}


				$AjaxHtml .= '<tr align="left" bgcolor="'.$bgcolor.'" id="savedrow_'.$Line.'"> 
					 <td><a href="Javascript:RemoveTransaction('.$values['TrID'].','.$Line.');" ><img src="../images/delete.png" border="0"></a></td>            
				         <td>'.$PaymentType.'</td>
					  <td>'.$VendorName.'</td>';

				if(empty($_GET['transferVendorFund'])) $AjaxHtml .= '<td>'.$CustomerName.'</td>';
					
				$AjaxHtml .= '<td>'.$InvoiceDate.'</td>
				         <td>'.$InvoiceID.'</td>
					 <td>'.$values['PurchaseID'].'</td>	
				         <td>'.$values['AccountNameNumber'].'</td>
					<td>'.$CredetID.'</td>';

				if(!empty($_GET['transferVendorFund'])) $AjaxHtml .= '<td>'.stripslashes($values['Description']).'</td>';	

				 

				$AjaxHtml .= '<td align="right"><input type="text" name="original_amount_'.$Line.'" id="original_amount_'.$Line.'" maxlength="30" onkeypress="return isDecimalKey(event);"  style="width:90px;text-align: right;" class="textbox disabled" readonly  value="'.$values['OriginalAmount'].'" ></td>		      
				         <td align="right" style="display:none"><input type="text" name="saved_amnt_'.$Line.'" id="saved_amnt_'.$Line.'" maxlength="30" onkeypress="return isDecimalKey(event);"  style="width:90px;text-align: right;" class="textbox disabled" readonly  value="'.$values['Amount'].'" ></td>
				 </tr>';
			}
			
			$AjaxHtml .= '</table>';
			  

			$sumPayAmount = round($sumPayAmount,2);			
			if($sumPayAmount=='-0'){
				$sumPayAmount = '0';
			}


			$AjaxHtml .= '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>  
			<td align="right"  ><strong>Total Payment : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="TotalOriginalAmount" id="TotalOriginalAmount" value="'.$TotalOriginalAmount.'"> <input type="hidden" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_saved_payment" id="total_saved_payment" value="'.$sumPayAmount.'"><input type="hidden" class="disabled" readonly="" name="num_saved" id="num_saved" value="'.$Line.'"></strong></td>
			</tr>
			</table>
			';
			  




			break; 


		case 'GetVendorList':  
			$objBankAccount = new BankAccount();
			 
			$arryVendorList=$objBankAccount->getVendorList();
			
			$AjaxHtml = '<option value="">---All Vendors---</option>';
			
			foreach($arryVendorList as $values){		
				$sel =($_GET['SuppCode']==$values['SuppCode'])?('selected'):('');		 
				$AjaxHtml .= '<option value="'.$values['SuppCode'].'" '.$sel.'>'.stripslashes($values['VendorName']).'</option>';
			}

			break;  
  


	}	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	



?>
