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
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/MyMailer.php");  
	require_once($Prefix."classes/configure.class.php");
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
		case 'getCustomerInvoice': 
			global $Config;
			$objBankAccount=new BankAccount();
			$objCommon=new common();
	             	$objReport = new report();  
			$objTransaction=new transaction();
			$HideUnwanted = ' width="1%" style="display:none"';
			$TransactionID='';
			$AjaxHtml ='';
			$arryTr = array();
			/*******Edit Transaction Mode********/			
			if($_GET['TransactionID']>0){
				$_GET['PaymentType'] = 'Sales';
				$arryTransaction = $objReport->getPaymentTransaction($_GET);
				if(!empty($arryTransaction[0]['TransactionID'])){
					$TransactionID = $arryTransaction[0]['TransactionID'];
					$arryPaymentDetail = $objReport->GetPaymentTransactionDetail($TransactionID,'','Sales'); 						$EditInvoiceIDs=''; $EditCreditIDs='';
					foreach($arryPaymentDetail as $keyinv=>$valuesinv){
						if(!empty($valuesinv['InvoiceID'])){
							$Inv = $valuesinv['InvoiceID'];
							$arryTr[$Inv]["InvoiceID"] = $Inv; 
							$arryTr[$Inv]["DebitAmnt"] = $valuesinv['DebitAmnt'];
							$arryTr[$Inv]["ConversionRate"] = $valuesinv['ConversionRate'];
							$arryTr[$Inv]["PayAmount"] = $valuesinv['OriginalAmount'];
							$EditInvoiceIDs .= "'".$Inv."',";
						}else if(!empty($valuesinv['CreditID'])){
							$Crd = $valuesinv['CreditID'];
							$arryTr[$Crd]["CreditID"] = $Crd; 
							$arryTr[$Crd]["DebitAmnt"] = $valuesinv['DebitAmnt'];
							$arryTr[$Crd]["ConversionRate"] = $valuesinv['ConversionRate'];
							$arryTr[$Crd]["PayAmount"] = $valuesinv['OriginalAmountCr'];
							$EditCreditIDs .= "'".$Crd."',";
						}
					}
					$_GET['InvoiceIDS'] = rtrim($EditInvoiceIDs,",");
					$_GET['CreditIDS'] = rtrim($EditCreditIDs,",");
					/*****Contra********/	
					unset($_GET['TransactionID']);
					if(!empty($arryTransaction[0]['ContraID'])){
						$_GET['TransactionID'] = $arryTransaction[0]['ContraID'];
					}else{
						$_GET['ContraID'] = $TransactionID;				
					}
					$_GET['PaymentType'] = 'Purchase';	                           						
					$arryContraTr = $objReport->getPaymentTransaction($_GET);
					if(!empty($arryContraTr[0]['TransactionID'])){
						$ContraTransactionID = $arryContraTr[0]['TransactionID'];
						$arryPaymentContra = $objReport->GetPaymentTransactionDetail($ContraTransactionID,'','Purchase'); 		$EditInvoiceIDs='';
						foreach($arryPaymentContra as $keyinv2=>$valuesinv2){
							$Inv = $valuesinv2['InvoiceID'];
							$arryTrC[$Inv]["InvoiceID"] = $Inv; 
							$arryTrC[$Inv]["CreditAmnt"] = $valuesinv2['CreditAmnt'];
							$arryTrC[$Inv]["ConversionRate"] = $valuesinv2['ConversionRate'];
							$arryTrC[$Inv]["PayAmount"] = $valuesinv2['OriginalAmount'];
							$EditInvoiceIDs .= "'".$Inv."',";
						}
						$_GET['InvoiceIDP'] = rtrim($EditInvoiceIDs,",");
					}
					/*****Contra********/
				}
			}
			/*****************/


			/*******Exclude Session Transaction********/
			unset($_GET['ExcludeInvoiceIDs']);
			$arrySessionTransaction = $objTransaction->ListSessionTransaction('AR',$TransactionID,'Invoice');
			$SessInvoiceIDs='';
			foreach($arrySessionTransaction as $kinv=>$valinv){
				if(!empty($valinv['InvoiceID'])){
					$SessInvoiceIDs .= "'".$valinv['InvoiceID']."',";
				}
			}
			$_GET['ExcludeInvoiceIDs'] = rtrim($SessInvoiceIDs,",");
			/*****************/
			$ErrorMsgCust='';

		   	if(!empty($_GET['custID'])){
				$_GET['CustCode'] = $objBankAccount->getCustomerCode($_GET['custID']);
				$arryLinkCustVen = $objBankAccount->GetCustomerVendor($_GET['custID'],'');
				$SearchKey   = trim(stripslashes($_GET['key']));
				$_GET['InvoicePaid'] = 'Paid';
				$arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
				$num=$objBankAccount->numRows();
				
				
				if($_GET['confirm'] == 1){
					$ApContraAccount = $objCommon->getSettingVariable('ApContraAccount');
					if (empty($ApContraAccount)) {
						$ErrorMsgCust  = SELECT_CON_AP; 
					}
					$AjaxHtml  .='<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tbody>
					<tr>
					<td class="message" align="center"> '.$ErrorMsgCust.' </td>
					</tr></tbody></table>';

				}              
				
				$AjaxHtml  .= '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
				<tr>
					<td  class="head"> AR Invoice</td> ';

				$AjaxHtml  .= '<td class="head" align="right" ><input type="text" name="SearchKey" id="SearchKey" class="inputbox" maxlength="20" placeholder="Search Invoice No/ PO /Amount." value="'.$SearchKey.'" onkeypress="return SearchInvoiceEnter(event);">&nbsp;<input name="search" type="button" class="search_button" value="Go" onclick="Javascript:SearchInvoice();"> </td>';

				$AjaxHtml  .= '</tr><tr>
				<td><a href="Javascript:AddAllToTransaction();" id="addallrow" class="add" style="float:left; display:none">Add</a></td>
				</tr>
                               <tr>
                               <td valign="top" colspan="2">
                               <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
                                   <tr align="left">
                                               <td width="1%" class="head1" align="center">Select</td>
                                               <td width="12%"  class="head1">Invoice Date</td>
                                               <td width="10%" class="head1">Invoice#</td>
						<td width="10%" class="head1">PO#</td>
                                               <td class="head1" width="12%">Sales Person</td>
<td width="13%" class="head1" >Invoice Amount</td>
<td '.$HideUnwanted.' class="head1" >Conversion Rate</td>

                                               <td '.$HideUnwanted.' class="head1" >Original Amount&nbsp;('.$Config['Currency'].')</td>
                                               <td width="15%" class="head1">Open Balance</td>
                                               <td  class="head1" align="right">Payment</td>
                                   </tr>';
		   
		/**********************/    
	if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		$openBalance = 0;
		$sumPayAmount=0;
		$totalOpenBalance = 0;
		foreach($arrySale as $key=>$values){
			$flag=!$flag;
			$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
			$Line++;
			$Inv = $values["InvoiceID"];	
			$idPay=0;$PayAmount=0; $checked = '';	
			
			$TotalInvoiceAmount = $values['TotalInvoiceAmount'];
			$ConversionRate=""; $DisplayConvers = 'style="display:none"';  
			   
			if($values['CustomerCurrency']!=$Config['Currency']){
				if(!empty($arryTr[$Inv]["InvoiceID"])){ 
					$ConversionRate = $arryTr[$Inv]["ConversionRate"];
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
			if(!empty($arryTr[$Inv]["InvoiceID"])){
				if($Inv==$arryTr[$Inv]["InvoiceID"]){
					$checked = 'checked';
					$PayAmount = $arryTr[$Inv]["PayAmount"];	//DebitAmnt
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
		
			$openBalance2 = round(($openBalance - $PayAmount),2);

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
		
			$TrShowHide = ($openBalance2>0)?(''):('style="display:none"');

			$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.' '.$TrShowHide.'>
			<td align="center"><input type="checkbox" '.$checked.' name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')">
			<input name="InvoiceID_'.$Line.'" type="hidden" readonly id="InvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
			<input name="SaleID_'.$Line.'" type="hidden" readonly id="SaleID_'.$Line.'" value="'.$values['SaleID'].'"  />
			<input type="hidden" readonly name="OrderID_'.$Line.'" id="OrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
			<input type="hidden" readonly name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$values['TotalAmount'].'"> 
			<input type="hidden" readonly name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'"> 
			 
			</td>';
			$AjaxHtml .='<td >'.$values['InvoiceDate'].'</td>';    
			$AjaxHtml .='<td>'.$InvoiceID.'</td>'; 
			$AjaxHtml .='<td >'.$values['CustomerPO'].'</td>';    
			$AjaxHtml .= '<td>'.$salesPerson.'</td>';

			$AjaxHtml .= '<td>'.$values['TotalInvoiceAmount'].' '.$values['CustomerCurrency'].'<input type="hidden" readonly name="TotalInvoiceAmountOld_'.$Line.'" id="TotalInvoiceAmountOld_'.$Line.'" value="'. $values['TotalInvoiceAmount'].'"></td>';

			$AjaxHtml .= '<td '.$HideUnwanted.'><input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate_'.$Line.'" id="ConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox disabled" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

			$AjaxHtml .= '<td  '.$HideUnwanted.' ><input type="text" class="normal" size="10" readonly name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalInvoiceAmount.'"></td>';

			$AjaxHtml .= '<td><input type="hidden" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="openBalance_'.$Line.'" id="openBalance_'.$Line.'" value="'.$openBalance2.'"><input type="hidden" readonly name="receivedAmnt_'.$Line.'" id="receivedAmnt_'.$Line.'" value="'. $values['receivedAmnt'].'"></td>';

			$AjaxHtml .= '<td align="right"><a href="Javascript:AddToTransaction('.$Line.');" id="addrow_'.$Line.'" class="add" style="float:left;display:none">Add</a><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'" ></td></tr>';
				       
			    
		     } 
		  
	     }else{
	    	$AjaxHtml .= '<tr align="center">
	      <td  colspan="10" class="no_record">'.NO_INVOICE.'</td></tr></table>';		     
	     }
		  
		if($_GET['BankCurrency']!=$Config['Currency']){			
			$ConversionRateGL = CurrencyConvertor(1,$_GET['BankCurrency'],$Config['Currency'],'AR',$_GET['PaymentDate']);
		}else{
			$ConversionRateGL = 1;
		}

		$AjaxHtml .= '<input type="hidden" readonly name="totalInvoice" id="totalInvoice" value="'.$num.'" readonly>
			   <input type="hidden" readonly name="ConversionRateGL" id="ConversionRateGL" value="'.$ConversionRateGL.'" readonly>';
		if(is_array($arrySale) && $num>0){     
			$AjaxHtml .= ' 
			<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>  
			<td align="right" ><strong>Total Amount : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment" id="total_payment" value="'.$sumPayAmount.'"></strong></td>
			</tr>
			</table>
			
			<input type="hidden" readonly name="ContraAcnt" id="ContraAcnt" value="'.$_GET['confirm'].'">
			<input type="hidden" readonly name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">
			<input type="hidden" readonly name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
			</td>
			</tr>
			</table> </div>';
		}



	/**************Customer Credit Note****************/
	/**************************************************/
	//if($num>0){
	/*******Exclude Session Transaction********/
	unset($_GET['ExcludeCreditIDs']);
	$arrySessionTransaction = $objTransaction->ListSessionTransaction('AR',$TransactionID,'Credit');
	$SessCreditIDs='';
	foreach($arrySessionTransaction as $kinv=>$valinv){
		if(!empty($valinv['CreditID'])){
			$SessCreditIDs .= "'".$valinv['CreditID']."',";
		}
	}
	$_GET['ExcludeCreditIDs'] = rtrim($SessCreditIDs,",");
	/*****************/

	
	$arryCredit=$objTransaction->ListOpenARCreditNote($_GET);
	$numCredit=$objTransaction->numRows();
	if($numCredit>0){
		$AjaxHtml  .= '<br><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>
				<td  class="head"> Customer Credit Memo / Overpaid Invoices</td>
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


	                                       <td '.$HideUnwanted.' class="head1" >Original Amount&nbsp;('.$Config['Currency'].')</td>
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
			   
			if($values['CustomerCurrency']!=$Config['Currency']){
				if(!empty($arryTr[$Crd]["CreditID"])){ 
					$ConversionRate = $arryTr[$Crd]["ConversionRate"];
				}else{
					if(empty($arryCurrencyVal[$values['CustomerCurrency']])){
						$ConversionRate=CurrencyConvertor(1,$values['CustomerCurrency'],$Config['Currency'],'AR',$_GET['PaymentDate']);
						$arryCurrencyVal[$values['CustomerCurrency']]=$ConversionRate;
					}else{
						$ConversionRate=$arryCurrencyVal[$values['CustomerCurrency']];
					}
				}

				#$TotalCreditAmount=round(GetConvertedAmount($ConversionRate, $TotalCreditAmount),2); 				 	
				$DisplayConvers = '';    
				if(!empty($values['receivedAmntTr'])){
					$values['receivedAmntCr'] = $values['receivedAmntTr'];
				}else{
			
					$values['receivedAmntCr'] = round(GetConvertedAmountReverse($ConversionRate, $values['receivedAmntCr']),2);	
				}  

			}
			if($values['receivedAmntCr']!='')$values['receivedAmntCr']=-$values['receivedAmntCr'];
		 	/**************/
			if(!empty($arryTr[$Crd]["CreditID"])){
			if($Crd==$arryTr[$Crd]["CreditID"]){
				$checked = 'checked';
				$PayAmount = $arryTr[$Crd]["PayAmount"];  //DebitAmnt
				if($PayAmount!='')$PayAmount=-$PayAmount;	
				$sumPayAmountCr += $PayAmount;	
				$values['receivedAmntCr'] = $values['receivedAmntCr']-$PayAmount;
			}
			}
			/**************/
		 

			if($values['receivedAmntCr'] > 0){
			     $openBalanceCr =  $TotalCreditAmount-$values['receivedAmntCr']; 
			}else{
			    $openBalanceCr =  $TotalCreditAmount; 
			}
		        $openBalanceCr = round($openBalanceCr,'2');
			if($openBalanceCr>0)$totalOpenBalanceCr += $openBalanceCr;
		
			
			$openBalanceCr2 = round(($openBalanceCr - $PayAmount),2);

			if($values['OverPaid']=="1"){
				$CreditID = '<a href="vInvoice.php?pop=1&amp;inv='.$values['InvoiceID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
			}else{
				$CreditID = '<a href="vCreditNote.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['CreditID'].'</a>';
			}
			
			$TrShowHide = ($openBalanceCr2>0)?(''):('style="display:none"');

		
			$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.' '.$TrShowHide.'>
			<td align="center"><input type="checkbox" '.$checked.' name="credit_check_'.$Line.'" id="credit_check_'.$Line.'" onClick="SetPayAmntByCheckCr('.$Line.')">
			<input name="CreditID_'.$Line.'" type="hidden" readonly id="CreditID_'.$Line.'" value="'.$values['CreditID'].'"  />
			<input name="CrdInvoiceID_'.$Line.'" type="hidden" readonly id="CrdInvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
			<input name="CrdOverPaid_'.$Line.'" type="hidden" readonly id="CrdOverPaid_'.$Line.'" value="'.$values['OverPaid'].'"  />
			<input type="hidden" readonly name="OrderIDCr_'.$Line.'" id="OrderIDCr_'.$Line.'" value="'.$values['OrderID'].'"  />    
			<input type="hidden" readonly name="TotalAmountCr_'.$Line.'" id="TotalAmountCr_'.$Line.'" value="'.$values['TotalAmount'].'"> 			
			</td>';
			$AjaxHtml .='<td >'.$values['PostedDate'].'</td>';    
			$AjaxHtml .='<td>'.$CreditID.'</td>'; 
			 

			$AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['CustomerCurrency'].'<input type="hidden" readonly name="TotalCreditAmountOld_'.$Line.'" id="TotalCreditAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"></td>';

			$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" onchange="Javascript:ChangeConversionrateCr('.$Line.');" name="ConversionRateCr_'.$Line.'" id="ConversionRateCr_'.$Line.'" value="'.$ConversionRate.'" class="textbox disabled" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

			$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" class="normal" size="10" readonly name="TotalCreditAmount_'.$Line.'" id="TotalCreditAmount_'.$Line.'" value="'.$TotalCreditAmount.'"></td>';

			$AjaxHtml .= '<td><input type="hidden" readonly class="normal" size="10" name="credit_amnt_'.$Line.'" id="credit_amnt_'.$Line.'" value="'.$openBalanceCr.'"><input type="text" class="normal" size="10" readonly name="openBalanceCr_'.$Line.'" id="openBalanceCr_'.$Line.'" value="'.$openBalanceCr2.'"><input type="hidden" name="receivedAmntCr_'.$Line.'" id="receivedAmntCr_'.$Line.'" value="'. $values['receivedAmntCr'].'"></td>';

			$AjaxHtml .= '<td align="right"><a href="Javascript:AddCreditToTransaction('.$Line.');" id="addrowcr_'.$Line.'" class="add" style="float:left;display:none">Apply</a><input type="text" name="payment_amntcr_'.$Line.'" id="payment_amntcr_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmntCr()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'" ></td></tr>';
				       
			    
		     } 
		  
	   
		  
		$AjaxHtml .= '	 </table>
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>  
			<td align="right" colspan="9"><strong>Total Amount : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_paymentcr" id="total_paymentcr" value="'.$sumPayAmountCr.'"></strong></td>
			</tr>
			 <input type="hidden" readonly name="totalCredit" id="totalCredit" value="'.$numCredit.'">			
			
			<input type="hidden" readonly name="totalOpenBalanceCr" id="totalOpenBalanceCr" value="'.$totalOpenBalanceCr.'">
			</table>

			</td></tr></table>';
		}
	// }  
	/**********************************************************/
	/**********************************************************/



	/**************Customer Credit Amount****************/
	/**************************************************/
 	$num5555555='';
	if($num5555555>0 && $_GET['BankCurrency']==$Config['Currency']){ //num invoice

	   $arrySessionCreditAmount = $objTransaction->ListSessionTransaction('AR',$TransactionID,'CreditAmount');
 	   if(sizeof($arrySessionCreditAmount)<=0){
		$CustomerCreditAmount = $objBankAccount->getCustomerCredit($_GET['custID']);
	 	/*$DeletedCreditAmount = $objTransaction->getDeletedCreditAmount('AR',$TransactionID,'CreditAmount'); 
		if($DeletedCreditAmount>0){
			$CustomerCreditAmount = $CustomerCreditAmount + $DeletedCreditAmount;
		}*/
	   if($CustomerCreditAmount>0){
		$OpenCreditAmount = $CustomerCreditAmount;

		$AjaxHtml  .= '<br><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>
				<td  class="head"> Customer Credit Amount</td>
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

						<td>'.$CustomerCreditAmount.'<input type="hidden" readonly  name="CustomerCreditAmount" id="CustomerCreditAmount" value="'. $CustomerCreditAmount .'"> </td>
						
	                                       <td> <input type="text" class="normal" size="10" readonly name="openBalanceCredit" id="openBalanceCredit" value="'.$OpenCreditAmount.'"></td>
	                                       <td align="right"> <a href="Javascript:ApplyCreditAmountToTransaction();" id="addrowcredit" class="add" style="float:left;display:none">Apply</a><input type="text" name="payment_credit_amount" id="payment_credit_amount" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayCreditAmount()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayCreditAmount.'" ></td>
				  </tr>
			</table> ';
			
		  
		 
		}
	  }
	}
	/**********************************************************/
	/**********************************************************/



  /**********************/
   if($_GET['confirm'] ==1 && $num>0){
	$SuppID = $arryLinkCustVen[0]['SuppID'];
	if($SuppID>0){
		$arryVendor = $objBankAccount->GetSupplier($SuppID,'','');
	}

	$_GET['SuppCode'] = $arryVendor[0]['SuppCode']; 
			if($ErrorMsgCust ==''){	


			/*******Exclude Session Transaction********/
			unset($_GET['ExcludeInvoiceIDs']);
			$arrySessionTransaction = $objTransaction->ListSessionTransaction('AR',$TransactionID,'Contra Invoice');
			$SessInvoiceIDs='';
			foreach($arrySessionTransaction as $kinv=>$valinv){
				if(!empty($valinv['InvoiceID'])){
					$SessInvoiceIDs .= "'".$valinv['InvoiceID']."',";
				}
			}
			$_GET['ExcludeInvoiceIDs'] = rtrim($SessInvoiceIDs,",");
			/*****************/



			if(!empty($_GET['SuppCode'])){
				$arryVendorInvoice=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
				$num=$objBankAccount->numRows();
				      
				$AjaxHtml  .= '<br><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    <tr>
				<td valign="top" class="head1"> AP Invoice</td>
				</tr>
                               <tr>
                               <td valign="top">
                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
                                   <tr align="left">
                                               <td class="head1" align="center" width="1%">Select</td>
                                               <td width="15%"  class="head1">Invoice Date</td>
                                               <td width="10%" class="head1">Invoice #</td>
                                               <td width="12%" class="head1">Reference #</td>
                                               <td width="12%" class="head1" >Invoice Amount</td>
<td '.$HideUnwanted.'  class="head1" >Conversion Rate</td>
                                               <td '.$HideUnwanted.' " class="head1" >Original Amount&nbsp;('.$Config['Currency'].')</td>
                                               <td width="12%" align="left" class="head1">Open Balance</td>
                                               <td align="right" class="head1">Payment</td>
                                   </tr>';
		   
		unset($arryCurrencyVal);    
	 if(is_array($arryVendorInvoice) && $num>0){
	    	$flag=true;
	    	$Line=0;
		$openBalance = 0;
		$totalOpenBalance = 0;
		$sumPayAmount=0;
	    foreach($arryVendorInvoice as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;
		$Inv = $values["InvoiceID"];
		$idPay=0;$PayAmount=0; $checked = '';			

		$orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
		$TotalAmount = $values['TotalAmount'];
		   
		    
		$ConversionRate=""; $DisplayConvers = 'style="display:none"';    
		    /****************/
		    if($values['Currency']!=$Config['Currency']){

			if($arryTrC[$Inv]["InvoiceID"]!=''){ 
				$ConversionRate = $arryTrC[$Inv]["ConversionRate"];
			}else{ 
				if(empty($arryCurrencyVal[$values['Currency']])){
					$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency'],'AP',$_GET['PaymentDate']);
					$arryCurrencyVal[$values['Currency']]=$ConversionRate;
				}else{
					$ConversionRate=$arryCurrencyVal[$values['Currency']];
				}
			}

			#$TotalAmount= round(GetConvertedAmount($ConversionRate, $TotalAmount),2);  		
			#$orderTotalAmount = round(GetConvertedAmount($ConversionRate, $orderTotalAmount), 2);        
			$DisplayConvers = '';   
			if(!empty($values['paidAmntTr'])){
				$values['paidAmnt'] = $values['paidAmntTr'];
			}else{
			
				$values['paidAmnt'] = round(GetConvertedAmountReverse($ConversionRate, $values['paidAmnt']),2);	
			} 
		    }
		 /********************/
		if(!empty($arryTrC[$Inv]["InvoiceID"]) && $Inv==$arryTrC[$Inv]["InvoiceID"]){
			$checked = 'checked';
			$PayAmount = $arryTrC[$Inv]["PayAmount"];	 //CreditAmnt
			$sumPayAmount += $PayAmount;	
			$values['paidAmnt'] = $values['paidAmnt']-$PayAmount;
		}
	 	 /********************/
		 
		if($values['paidAmnt'] > 0){
			$openBalance =  $TotalAmount-$values['paidAmnt']; 
		}else{
			$openBalance =  $TotalAmount; 
		}
		$openBalance = round($openBalance,'2');
		if($openBalance>0) $totalOpenBalance += $openBalance;

		$openBalance2 = round(($openBalance - $PayAmount),2);
		
		$TrShowHide = ($openBalance2>0)?(''):('style="display:none"');


		      
		    
	if($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3'){
		$InvoiceID = '<a href="vOtherExpense.php?pop=1&amp;Flag=&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';

	 	$PONumber = $values['PurchaseID'];
	}else  if($values['InvoiceEntry'] == 1){
		$InvoiceID = $InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;IE=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';

		$PONumber = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }else{
		$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
		$PONumber = '<a href="../purchasing/vPO.php?pop=1&amp;module=order&amp;po='.$values['PurchaseID'].'" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }
		     
		     
		
		$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.' '.$TrShowHide.'>
		<td align="center"><input type="checkbox" name="Vendor_invoice_check_'.$Line.'" id="Vendor_invoice_check_'.$Line.'" onClick="SetApPayAmntByCheck('.$Line.')" '.$checked.'>
		<input name="VendorInvoiceID_'.$Line.'" type="hidden" readonly id="VendorInvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
		<input name="PurchaseID_'.$Line.'" type="hidden" readonly id="PurchaseID_'.$Line.'" value="'.$values['PurchaseID'].'"  />
		<input type="hidden" readonly name="VendorOrderID_'.$Line.'" id="VendorOrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
		<input type="hidden" readonly name="VendorTotalAmount_'.$Line.'" id="VendorTotalAmount_'.$Line.'" value="'.$orderTotalAmount.'">
		<input type="hidden" readonly name="VendorInvoiceEntry_'.$Line.'" id="VendorInvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'">    
		</td>';
		$AjaxHtml .='<td>'.$values['PostedDate'].'</td>';    
		$AjaxHtml .='<td>'.$InvoiceID.'</td>';

		$AjaxHtml .='<td>'.$PONumber.'</td>';

		$AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['Currency'].'<input type="hidden" readonly name="TotalVendorAmountOld_'.$Line.'" id="TotalVendorAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"></td>';

		$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" onchange="Javascript:ChangeVendorConversionrate('.$Line.');" name="VendorConversionRate_'.$Line.'" id="VendorConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox disabled" readonly size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

		$AjaxHtml .= '<td '.$HideUnwanted.' ><input type="text" class="normal" size="10" readonly name="TotalVendorInvoiceAmount_'.$Line.'" id="TotalVendorInvoiceAmount_'.$Line.'" value="'.$TotalAmount.'"></td>';

		$AjaxHtml .= '<td align="left"><input type="hidden"  class="normal" size="10" readonly name="vendorinvoice_amnt_'.$Line.'" id="vendorinvoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="vendoropenBalance_'.$Line.'" id="vendoropenBalance_'.$Line.'" value="'.$openBalance2.'"><input type="hidden" readonly name="paidVendorAmnt_'.$Line.'" id="paidVendorAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';
		$AjaxHtml .= '<td align="right"><a href="Javascript:AddContraToTransaction('.$Line.');" id="addrov_'.$Line.'" class="add" style="float:left;display:none">Add</a><input type="text" name="payment_vendor_amnt_'.$Line.'" id="payment_vendor_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAPAmnt()" style="width:90px;text-align: right;" class="textbox setPrice" value="'.$PayAmount.'"></td></tr>';
				       
			    
		     } 
		  
	     }else{
	    $AjaxHtml .= '<tr align="center">
	      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
	     
	     }
		  
			    if(is_array($arryVendorInvoice) && $num>0){     
			     $AjaxHtml .= ' 
			    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
				 <tr>  
				     <td align="right"  ><strong>Total Amount : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly name="total_payment_ventor" id="total_payment_ventor" value="'.$sumPayAmount.'"></strong></td>
				     </tr>
			      </table>
				<input type="hidden" readonly name="totalInvoiceVendor" id="totalInvoiceVendor" value="'.$num.'">
				    
				    <input type="hidden" readonly name="totalOpenBalanceVendor" id="totalOpenBalanceVendor" value="'.$totalOpenBalance.'">
				 <input type="hidden" readonly name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
		<input type="hidden" name="SuppCode" id="SuppCode" value="'.$_GET['SuppCode'].'" readonly> 
			    </td>
			    </tr>
			    </table> ';
			    }
		  }
		} 
	}            
			    
		      

	}


		break;
		exit;
                   
               
		case 'CheckContraAR':  
			if(!empty($_GET['custID'])){
				$objBankAccount=new BankAccount();
				$arryLinkCustVen = $objBankAccount->GetCustomerVendor($_GET['custID'],'');
				if(!empty($arryLinkCustVen[0]['SuppID'])){
					$AjaxHtml = $arryLinkCustVen[0]['SuppID'];
				}
			}
			break;   
                         
              
   		case 'getCustomerPaymentMethod':
			 $objBankAccount=new BankAccount();
                            global $Config;

			if(!empty($_GET['custID'])){

			 $paymentMethod = $objBankAccount->getCustomerPaymentMethod($_GET['custID']);
			 
			 $AjaxHtml  = $paymentMethod;
			}
			 break;
			 exit;   
   

		case 'getCurrencyRate': 
			global $Config;	
			if($_GET['CustomerCurrency']!=$Config['Currency']){			
				$ConversionRate=CurrencyConvertor(1,$_GET['CustomerCurrency'],$Config['Currency'],'AR');
			}else{
				$ConversionRate=1;
			}
			$AjaxHtml = $ConversionRate;
		 	break;	

		 case 'CheckGlTransaction':  
			if($_GET['CustID']>0 && $_GET['AccountID']>0){
				$objTransaction=new transaction();				
				$AjaxHtml = $objTransaction->CheckGlTransaction($_GET['TransactionID'],$_GET['CustID'],$_GET['AccountID']);				
			}
			break; 

		case 'CheckTransaction':  
			if($_GET['CustID']>0 && ($_GET['OrderID']>0 || $_GET['PaymentType'] == 'CreditAmount')){
				$objTransaction=new transaction();
				$_GET['Module'] = 'AR';							
				$AjaxHtml = $objTransaction->CheckTransaction($_GET);				
			}
			break; 

		 case 'AddToTransaction':  
			if($_GET['CustID']>0 && !empty($_GET['Amount'])){
				$objTransaction=new transaction();			
				$_GET['Module'] = 'AR';
				$AjaxHtml = $objTransaction->AddUpdateTransaction($_GET);				
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
			$arryTransaction = $objTransaction->ListSessionTransaction('AR',$TransactionID ,'');
			
			 $ModuleCurrency = (!empty($arryTransaction[0]['ModuleCurrency'])) ? ("(".$arryTransaction[0]['ModuleCurrency'].")") : ("");


			$AjaxHtml = '<table width="100%" id="list_table" border="0" align="center" cellpadding="3" cellspacing="1" >  <tr>
				<td class="head1" colspan="10">Saved Payment Data</td>
				</tr>
				<tr align="left">  
					<td width="1%"  class="head1"> </td> 
					<td width="6%"  class="head1">Type</td>
					<td width="12%"  class="head1">Customer</td>
					<td width="12%"  class="head1">Vendor</td>
					<td width="12%"  class="head1">Invoice Date</td>   
					<td width="10%" class="head1">Invoice # </td>					
					<td width="18%" class="head1">GL Account</td>
					<td width="13%" class="head1">Credit Memo #</td>
					<td align="right"    class="head1">Payment Amount '.$ModuleCurrency.'</td>
					<td  align="right" class="head1" style="display:none">Payment Amount ('.$Config['Currency'].')</td>
				</tr>';
			$sumPayAmount=0;$TotalOriginalAmount=0;
			$Line=0;$flag='';
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
				if($PaymentType=='Contra Invoice'){				 
					$InvoiceDate = $values['PostedDate'];
					 
					if($values['PInvoiceEntry'] == '2' || $values['PInvoiceEntry'] == '3'){
						$InvoiceID = '<a href="vOtherExpense.php?pop=1&amp;Flag='.$Flag.'&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';
					 	
					}else  if($values['PInvoiceEntry'] == 1){
						$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;IE=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';

					}else{
						$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
						
					}

				}else if($PaymentType=='Invoice'){					 
					$InvoiceDate = $values['InvoiceDate'];
					 
					if($values['InvoiceEntry'] == 1){
				    		$InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
					}else{
				 		$InvoiceID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
					}
				}else if($PaymentType=='Credit'){					 
					$CredetID = '<a href="vCreditNote.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['CreditID'].'</a>';
					if($values['OverPaid']=='1'){	
						$PaymentType = 'Invoice';
						$CredetID ='';
						$InvoiceID = '<a href="vInvoice.php?pop=1&amp;inv='.$values['InvoiceID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
					}
				}


				 

				$AjaxHtml .= '<tr align="left" bgcolor="'.$bgcolor.'" id="savedrow_'.$Line.'"> 
					 <td><a href="Javascript:RemoveTransaction('.$values['TrID'].','.$Line.');" ><img src="../images/delete.png" border="0"></a></td>            
				         <td>'.$PaymentType.'</td>
					 <td>'.$CustomerName.'</td>
					  <td>'.$VendorName.'</td>
				         <td>'.$InvoiceDate.'</td>
				         <td>'.$InvoiceID.'</td>
				         <td>'.$values['AccountNameNumber'].'</td>	
					 <td>'.$CredetID.'</td>	
					 <td align="right"><input type="text" name="original_amount_'.$Line.'" id="original_amount_'.$Line.'" maxlength="30" onkeypress="return isDecimalKey(event);"  style="width:90px;text-align: right;" class="textbox disabled" readonly  value="'.$values['OriginalAmount'].'" ></td>			      
				         <td align="right" style="display:none"><input type="text" name="saved_amnt_'.$Line.'" id="saved_amnt_'.$Line.'" maxlength="30" onkeypress="return isDecimalKey(event);"  style="width:90px;text-align: right;" class="textbox disabled" readonly  value="'.$values['Amount'].'" ></td>
				 </tr>';
			}
			
			$AjaxHtml .= '</table>';
			  
			
			$sumPayAmount = round($sumPayAmount,2);			
			if($sumPayAmount=='-0'){
				$sumPayAmount = '0';
			}
			$TotalOriginalAmount = round($TotalOriginalAmount,2);			
			if($TotalOriginalAmount=='-0'){
				$TotalOriginalAmount = '0';
			}

			$AjaxHtml .= '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
			<tr>  
			<td align="right"  ><strong>Total Payment :  <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="TotalOriginalAmount" id="TotalOriginalAmount" value="'.$TotalOriginalAmount.'"> <input type="hidden" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_saved_payment" id="total_saved_payment" value="'.$sumPayAmount.'"><input type="hidden" class="disabled" readonly="" name="num_saved" id="num_saved" value="'.$Line.'"></strong></td>
			</tr>
			</table>
			';
			  




			break;   

		case 'GetCustomerList':  
			$objBankAccount = new BankAccount();
			 
			$arryCustomerList=$objBankAccount->getCustomerList();
			
			$AjaxHtml = '<option value="">---All Customers---</option>';
			
			foreach($arryCustomerList as $values){		
				$sel =($_GET['CustID']==$values['custID'])?('selected'):('');		 
				$AjaxHtml .= '<option value="'.$values['custID'].'" '.$sel.'>'.stripslashes($values['CustomerName']).'</option>';
			}

			break;  


	}	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	



?>
