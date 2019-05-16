<?php	session_start();
	$Prefix = "../../"; 

	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/finance.account.class.php");
	 require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/MyMailer.php");	
	require_once($Prefix."classes/supplier.class.php");	
        require_once($Prefix."classes/finance.report.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");        
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
        
 
	switch($_GET['action']){
		case 'delete_file':
			if($_GET['file_path']!=''){
				$objConfigure=new configure();
				$objConfigure->UpdateStorage($_GET['file_path'],0,1);
				unlink($_GET['file_path']);
				echo "1";
			}else{
				echo "0";
			}
			break;
			exit;
	case 'currency':
			$objRegion=new region();
			$arryCurrency = $objRegion->getCurrency($_GET['currency_id'],'');
			echo $StoreCurrency = $arryCurrency[0]['symbol_left'].$arryCurrency[0]['symbol_right'];
			break;
			exit;
                        
          case 'state':
			$objRegion=new region();
                     
			$arryState = $objRegion->getStateByCountry($_GET['country_id']);
			
				$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';
				
				if($_GET['all']==1){
					$AjaxHtml  .= '<option value="">--- All ---</option>';
				}else{
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);
				
				for($i=0;$i<sizeof($arryState);$i++) {
				
					$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
				}

				$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
				if($_GET['other']==1){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				}else if(sizeof($arryState)<=0){
					$AjaxHtml  .= '<option value="">No state found.</option>';
				}

				$AjaxHtml  .= '</select>';
			
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="'.$StateSelected.'">';
							
			break;
			
			
	case 'city':
			$objRegion=new region();
			$arryCity = $objRegion->getCityByState($_GET['state_id']);

				$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

                                                        
				$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);
				
				for($i=0;$i<sizeof($arryCity);$i++) {
				
					$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.htmlentities($arryCity[$i]['name'], ENT_IGNORE).'</option>';
					
				}

				$Selected = ($_GET['current_city'] == '0')?(" Selected"):("");
				if($_GET['other']==1){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				}else if(sizeof($arryCity)<=0){
					$AjaxHtml  .= '<option value="">No city found.</option>';
				}

				$AjaxHtml  .= '</select>';
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_city_id" id="ajax_city_id" value="'.$CitySelected.'">';
							
			break;
	case 'zipSearch':		
		$objRegion=new region();
		if(!empty($_GET['city_id'])){
			$arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
			for($i=0;$i<sizeof($arryZipcode);$i++) {
				$AjaxHtml .= '<li onclick="set_zip(\''.stripslashes($arryZipcode[$i]['zip_code']).'\')">'.stripslashes($arryZipcode[$i]['zip_code']).'</li>';
			}

		}
		break;
	

					
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
	
	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/



	switch($_GET['action']){
		 
			

		      case 'account':
			$objBankAccount=new BankAccount();
                     	
			if(!empty($_GET['AccountType'])){
			 $arryAccount = $objBankAccount->getAccountByAccountType($_GET['AccountType']);
			 
				$AjaxHtml  = '<select name="BankAccountID" class="inputbox" id="BankAccountID" onchange="Javascript: SetMainAccountId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				//$StateSelected = (!empty($_GET['current_account']))?($_GET['current_account']):($arryAccount[0]['ParentAccountID']);
				
				for($i=0;$i<sizeof($arryAccount);$i++) {
				
					$Selected = ($_GET['current_account'] == $arryAccount[$i]['BankAccountID'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryAccount[$i]['BankAccountID'].'" '.$Selected.'>'.stripslashes($arryAccount[$i]['AccountName']).'</option>';
					
				}

				$Selected = ($_GET['current_account'] == '0')?(" Selected"):("");
				if(sizeof($arryAccount)<=0){
					$AjaxHtml  .= '<option value="">No account found.</option>';
				}
				$AjaxHtml  .= '</select>';
			
			}else{

				$AjaxHtml  = '<select name="ParentAccountID" class="inputbox" id="ParentAccountID">';
				$AjaxHtml  .= '<option value="">--- Select ---</option>';
				$AjaxHtml  .= '</select>';
				 
			}
				
			
							
			break;
			exit;

		case 'Entitylist':
			$objJournal = new journal();
                     	 

			if(!empty($_GET['EntityType'])){

				if($_GET['EntityType'] == "customer"){
			         $arryEntityList = $objJournal->getCustomerList();
				}else if($_GET['EntityType'] == "supplier"){
   				 $arryEntityList = $objJournal->getSupplierList();	
				}else{
				  $arryEntityList = $objJournal->getEmployeeList();
				}
			 
				//$AjaxHtml  = '<select name="EntityName" class="inputbox" id="EntityName" onchange="Javascript: SetMainAccountId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				
				
				for($i=0;$i<sizeof($arryEntityList);$i++) {
				
					$Selected = ($_GET['current_account'] == $arryEntityList[$i]['EntityName'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryEntityList[$i]['EntityID'].'" '.$Selected.'>'.stripslashes($arryEntityList[$i]['EntityName']).'</option>';
					
				}

				$Selected = ($_GET['current_account'] == '0')?(" Selected"):("");
				if(sizeof($arryEntityList)<=0){
					$AjaxHtml  .= '<option value="">No account found.</option>';
				}
				//$AjaxHtml  .= '</select>';
			
			}else{

				//$AjaxHtml  = '<select name="EntityName" class="inputbox" id="EntityName">';
				$AjaxHtml  .= '<option value="">--- Select ---</option>';
				//$AjaxHtml  .= '</select>';
				 
			}
				
			 
							
			break;
			exit;

		case 'EntityName':
			$objJournal = new journal();

			if(!empty($_GET['EntityID'])){

			 $EntityName = $objJournal->getEntityName($_GET['EntityID'],$_GET['EntityType']);
			 
			 $AjaxHtml  = $EntityName;
			}
			 break;
			 exit;

		case 'SetAccountName':

			$objJournal = new journal();

			if(!empty($_GET['AccountID'])){

			 $AccountName = $objJournal->getAccountName($_GET['AccountID']);
			 
			 $AjaxHtml  = $AccountName;
			}
			 break;
			 exit;

		case 'checkBalance':

			$objBankAccount=new BankAccount();
				 
				if(!empty($_GET['AccountID'])){

				  $AccountBalance = $objBankAccount->getAccountBalance($_GET['AccountID']);
				   $AjaxHtml  = "<b>Balance</b> ".$Config['Currency'].' '.$AccountBalance."";
				 /*if($_GET['AccountID'] == 7){
				  $AjaxHtml  = "<b>Billed</b> ".$Config['Currency'].' '.$AccountBalance."";
                                 }else{
                                     $AjaxHtml  = "<b>Balance</b> ".$Config['Currency'].' '.$AccountBalance."";
                                     
                                 }*/
				}
			 break;
			 exit;
                         
                         
                        case 'getCustomerInvoice29October':
			 $objBankAccount=new BankAccount();
                     	Global $Config;
			if(!empty($_GET['custID'])){
                            $_GET['InvoicePaid'] = 'Paid';
			    $arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
                            $num=$objBankAccount->numRows();
                      
				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
                                                   <tr align="left">
                                                               <td class="head1" align="center">Select</td>
                                                               <td width="10%"  class="head1">Invoice Date</td>
                                                               <td width="8%" class="head1">Invoice#</td>
                                                               <td class="head1">Sales Person</td>
<td width="10%" class="head1" >Invoice Amount</td>
<td width="10%" class="head1" >Conversion Rate</td>


                                                               <td width="15%" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="10%" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

                                                   </tr>';
   
	
	if(is_array($arrySale) && $num>0){
	$flag=true;
	$Line=0;
        $openBalance = 0;
        $totalOpenBalance = 0;
	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

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
                        <td align="center"><input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')">
                            <input name="InvoiceID_'.$Line.'" type="hidden" id="InvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
		            <input name="SaleID_'.$Line.'" type="hidden" id="SaleID_'.$Line.'" value="'.$values['SaleID'].'"  />
                            <input type="hidden" name="OrderID_'.$Line.'" id="OrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
                            <input type="hidden" name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$values['TotalAmount'].'"> 
                            <input type="hidden" name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'"> 
                             </td>';
                         $AjaxHtml .='<td >'.$values['InvoiceDate'].'</td>';    
			 $AjaxHtml .='<td>'.$InvoiceID.'</td>'; 
                         $AjaxHtml .= '<td>'.$salesPerson.'</td>';

			$AjaxHtml .= '<td>'.$values['TotalInvoiceAmount'].' '.$values['CustomerCurrency'].'<input type="hidden" name="TotalInvoiceAmountOld_'.$Line.'" id="TotalInvoiceAmountOld_'.$Line.'" value="'. $values['TotalInvoiceAmount'].'"></td>';
			$AjaxHtml .= '<td><input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate_'.$Line.'" id="ConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';

                         $AjaxHtml .= '<td><input type="text" class="normal" size="10" readonly name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalInvoiceAmount.'"></td>';
                         $AjaxHtml .= '<td><input type="text" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="hidden" name="receivedAmnt_'.$Line.'" id="receivedAmnt_'.$Line.'" value="'. $values['receivedAmnt'].'"></td>';
                         $AjaxHtml .= '<td align="center"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arrySale) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right" style="padding-right: 5px;"><strong>Total Payment <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment" id="total_payment" value="0.00"></strong></td>
                     </tr>
              </table>
                <input type="hidden" name="totalInvoice" id="totalInvoice" value="'.$num.'">
                    
                    <input type="hidden" name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">
                 <input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
            </td>
            </tr>
            </table> ';
            }

          } 
				
			
							
			break;
			exit;
                  case 'getVendorInvoiceCodeByParwezBak':
                            $objBankAccount=new BankAccount();
                            Global $Config;
			if(!empty($_GET['SuppCode'])){
                            $arryInvoice=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
                            $num=$objBankAccount->numRows();
                      
				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
                                                   <tr align="left">
                                                               <td class="head1" align="center" width="3%">Select</td>
                                                               <td width="7%"  class="head1">Invoice Date</td>
                                                               <td width="9%" class="head1">Invoice Number</td>
                                                               <td width="12%" class="head1">PO/Reference Number</td>
                                                               <td width="10%" class="head1" >Invoice Amount</td>
<td width="10%" class="head1" >Conversion Rate</td>
                                                               <td width="15%" align="left" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" align="left" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="10%" align="left" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

                                                   </tr>';
   
	
	if(is_array($arryInvoice) && $num>0){
	$flag=true;
	$Line=0;
        $openBalance = 0;
        $totalOpenBalance = 0;
	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
	$TotalAmount = $values['TotalAmount'];
	
	

	$ConversionRate=""; $DisplayConvers = 'style="display:none"';	
	/****************/
	if($values['Currency']!=$Config['Currency'])
	{
		$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
		$TotalAmount=$ConversionRate * $TotalAmount;
		$TotalAmount = round($TotalAmount,2);
		
		$orderTotalAmount = round($orderTotalAmount*$ConversionRate,2);		
		$DisplayConvers = '';	
	}
	/****************/
	//if($values['Currency']!=$Config['Currency']){
		//$TotalAmount=CurrencyConvertor($TotalAmount,$values['Currency'],$Config['Currency']);
		//$TotalAmount = round($TotalAmount,2);

		//$orderTotalAmount=CurrencyConvertor($orderTotalAmount,$values['Currency'],$Config['Currency']);
		//$orderTotalAmount = round($orderTotalAmount,2);
	//}
	/****************/



        if($values['paidAmnt'] > 0){
         $openBalance =  $TotalAmount-$values['paidAmnt']; 
        }else{
            $openBalance =  $TotalAmount; 
        }
        $openBalance = number_format($openBalance,'2','.','');
        if($openBalance>0) $totalOpenBalance += $openBalance;
        
        
        
      
	
     $InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
     
       if($values['InvoiceEntry'] == 1)
        {
            $PONumber = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }else{
           $PONumber = '<a href="../purchasing/vPO.php?pop=1&amp;module=order&amp;po='.$values['PurchaseID'].'" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }
     
     
        
	$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.'>
                        <td align="left"><input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')">
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
                         $AjaxHtml .= '<td align="left"><input type="text" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="hidden" name="paidAmnt_'.$Line.'" id="paidAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';
                         $AjaxHtml .= '<td align="left"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arryInvoice) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right" style="padding-right: 11px;"><strong>Total Payment <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment" id="total_payment" value="0.00"></strong></td>
                     </tr>
              </table>
                <input type="hidden" name="totalInvoice" id="totalInvoice" value="'.$num.'">
                    
                    <input type="hidden" name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">
                 <input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
            </td>
            </tr>
            </table> ';
            }

          } 
				
			
							
			break;
			exit;      
                         case 'getVendorInvoice':
                            $objBankAccount=new BankAccount();
		      $objCommon=new common();
                            Global $Config;

		/**************Code for contra account check******************/
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
		/*******************************End***********************************/  
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
                                                               <td width="10%" class="head1">Invoice Number</td>
                                                               <td width="15%" class="head1">Reference No.</td>
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
        $totalOpenBalance = 0;
	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
	$TotalAmount = $values['TotalAmount'];
	
	

	$ConversionRate=""; $DisplayConvers = 'style="display:none"';	
	/****************/
	if($values['Currency']!=$Config['Currency'])
	{
		$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
		$TotalAmount=$ConversionRate * $TotalAmount;
		$TotalAmount = round($TotalAmount,2);
		
		$orderTotalAmount = round($orderTotalAmount*$ConversionRate,2);		
		$DisplayConvers = '';	
	}
	/****************/
	//if($values['Currency']!=$Config['Currency']){
		//$TotalAmount=CurrencyConvertor($TotalAmount,$values['Currency'],$Config['Currency']);
		//$TotalAmount = round($TotalAmount,2);

		//$orderTotalAmount=CurrencyConvertor($orderTotalAmount,$values['Currency'],$Config['Currency']);
		//$orderTotalAmount = round($orderTotalAmount,2);
	//}
	/****************/



        if($values['paidAmnt'] > 0){
         $openBalance =  $TotalAmount-$values['paidAmnt']; 
        }else{
            $openBalance =  $TotalAmount; 
        }
        $openBalance = number_format($openBalance,'2','.','');
        if($openBalance>0) $totalOpenBalance += $openBalance;
        
        
        
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
                        <td align="center"><input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')">
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
                         $AjaxHtml .= '<td align="left"><input type="hidden" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="openBalance_'.$Line.'" id="openBalance_'.$Line.'" value="'.$openBalance.'"><input type="hidden" name="paidAmnt_'.$Line.'" id="paidAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';
                         $AjaxHtml .= '<td align="right"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arryInvoice) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right"  ><strong>Total Payment : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment" id="total_payment" value="0.00"></strong></td>
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
                                                               <td width="12%"  class="head1">Invoice Date</td>
                                                               <td width="12%" class="head1">Invoice#</td>
                                                               <td width="10%" class="head1">Sales Person</td>
<td width="10%" class="head1" >Invoice Amount</td>
<td width="12%" class="head1" >Conversion Rate</td>


                                                               <td width="15%" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td  align="right" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

                                                   </tr>';
   
	
	if(is_array($arrySale) && $num>0){
	$flag=true;
	$Line2=0;
           $openBalance = 0;
           $totalOpenBalance = 0;
	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line2++;

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
                        <td align="center"><input type="checkbox" name="Arinvoice_check_'.$Line2.'" id="Arinvoice_check_'.$Line2.'" onClick="SetArPayAmntByCheck('.$Line2.')">
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
                         $AjaxHtml .= '<td align="right"><input type="text" name="Arpayment_amnt_'.$Line2.'" id="Arpayment_amnt_'.$Line2.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetArPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
     }
  
            if(is_array($arrySale) && $num>0){	 
             $AjaxHtml .= ' 
            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                 <tr>  
                     <td align="right" ><strong>Total Payment :  <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="Artotal_payment" id="Artotal_payment" value="0.00"></strong></td>
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
                        
             case 'getCustomerPaymentMethod':
			 $objBankAccount=new BankAccount();
                            Global $Config;

			if(!empty($_GET['custID'])){

			 $paymentMethod = $objBankAccount->getCustomerPaymentMethod($_GET['custID']);
			 
			 $AjaxHtml  = $paymentMethod;
			}
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
                         
                   case 'checkJournalDocFile':
			$objJournal = new journal();
                         Global $Config;

			if(!empty($_GET['AttachmentFl'])){

			 $AttachmentID = $objJournal->checkJournalDocFile($_GET['AttachmentFl'],$_GET['CmpID']);
			 
			 $AjaxHtml  = $AttachmentID;
			}
			 break;
			 exit;          
		
		case 'SupplierInfo':
			$objSupplier=new supplier();
			$arrySupplier = $objSupplier->GetSupplier('',$_GET['SuppCode'],'');	
			echo json_encode($arrySupplier[0]);exit;

			break;
			exit;		

		case 'SupplierAddress':
			$objSupplier=new supplier();
			$arrySupplier = $objSupplier->GetSupplierAddressBook($_GET['SuppID'],$_GET['AddID']);	
			echo json_encode($arrySupplier[0]);exit;

			break;
			exit;
                        
                        
                case 'CheckReconcilMonth':
			$objReport = new report();

			if(!empty($_GET['Year']) && !empty($_GET['Month']) && !empty($_GET['AccountID'])){
                      
                            if($_GET['EditID'] > 0){
                               $editID = $_GET['EditID'];
                            }else{
                                $editID = 0;
                            }
                            
                                    
			 $ReconcileID = $objReport->CheckReconcilMonth($_GET['Year'],$_GET['Month'],$editID,$_GET['AccountID']);
			 
			 $AjaxHtml  = $ReconcileID;
			}
			 break;
			 exit;        
                         
               case 'CheckPeriodSettings':
			$objReport = new report();

			if(!empty($_GET['PeriodYear']) && !empty($_GET['PeriodMonth']) && !empty($_GET['PeriodStatus'])){

			 $PeriodID = $objReport->CheckPeriodSettings($_GET['PeriodYear'],$_GET['PeriodMonth'],$_GET['PeriodStatus'],$_GET['PeriodModule']);
			 
			 $AjaxHtml  = $PeriodID;
			}
			 break;
			 exit;     
                         
                         
                 case 'zipSearch555':
			$objRegion=new region();
                      
			if(!empty($_GET['city_id'])){

			 $arryZipcode = $objRegion->getZipCode($_GET['city_id']);
			 
                         
                         for($i=0;$i<sizeof($arryZipcode);$i++) {
                                               
					$AjaxHtml .=  '<li onclick="set_item(\''.htmlentities($arryZipcode[$i]['zip_code']).'\')">'.htmlentities($arryZipcode[$i]['zip_code']).'</li>';
				}
			
			}
			 break;
			 exit; 
                         
                  case 'checkSerialNumber':
			$objSale = new sale();
                      
			if(!empty($_GET['allSerialNo'])){
                            $allSerialNo = $_GET['allSerialNo'];
                      
                            $explodeSerialNo = explode("\n",$allSerialNo);
                            $explodeSerialNo = array_filter($explodeSerialNo);
                            //echo "<pre>";
                            //print_r($explodeSerialNo);exit;
                            foreach ($explodeSerialNo as $serialNumber){ 
                               
                                $SkuID = $objSale->checkSerializedItem($serialNumber);
                                if(!empty($SkuID)){
                                   $strSkuID .= $serialNumber.",";
                                }
                            }
			 
                      
                        $AjaxHtml = rtrim($strSkuID,",");
			
			}
			 break;
			 exit;  

		 case 'Groupaccount':
                   $objBankAccount=new BankAccount();
                     	
			if($_GET['GroupID']>0){
				$DisabledBox = 'disabled';
			}

			if(!empty($_GET['AccountType'])){
			 $arryAccount = $objBankAccount->getGroupAccountByAccountType($_GET['AccountType']);
			 
				$AjaxHtml  = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID" onchange="Javascript: SetMainGroupAccountId();" '.$DisabledBox.'>';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				//$StateSelected = (!empty($_GET['current_account']))?($_GET['current_account']):($arryAccount[0]['ParentAccountID']);
				
				for($i=0;$i<sizeof($arryAccount);$i++) {
				
					$Selected = ($_GET['ParentID'] == $arryAccount[$i]['GroupID'])?(" Selected"):(" ");
					
					$AjaxHtml  .= '<option value="'.$arryAccount[$i]['GroupID'].'" '.$Selected.'>'.stripslashes($arryAccount[$i]['GroupName']).'</option>';
                                        
                                        
                                        //$AjaxHtml .= $objBankAccount->GetSubAccountTreeWithSelect($arryAccount[$i]['BankAccountID'],0);
            
                                        $childOption=$objBankAccount->GetSubGroupAccountTreeWithSelect($arryAccount[$i]['GroupID'],0);
                                        $spaceVar="&nbsp;&nbsp;&nbsp;";
                                        
                                        if(count($childOption)>0)
                                        {
                                                foreach($childOption as $values){
                                                    
                                                    $Selected1 = ($_GET['ParentID'] == $values[GroupID])?(" Selected"):(" ");
                                                    $spaceVar.="";
                                                    $AjaxHtml  .= '<option value="'.$values[GroupID].'"  '.$Selected1.'>'.$spaceVar.stripslashes($values[GroupName]).'</option>';
                                                    $childOption33=$objBankAccount->GetSubGroupAccountTreeWithSelect1($values[GroupID],0,'');
                                                    $AjaxHtml;
                                                    
                                                    if(!empty($childOption33)){
                                                       $AjaxHtml.=$childOption33;
                                                       //echo $childOption33;
                                                    }else {
                                                       $AjaxHtml;
                                                    }
                                                }
                                        }
					
				}

				$Selected = ($_GET['ParentID'] == '0')?(" Selected"):("");
				if(sizeof($arryAccount)<=0){
					$AjaxHtml  .= '<option value="">No account found.</option>';
				}
				$AjaxHtml  .= '</select>';
			
			}else{

				$AjaxHtml  = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID">';
				$AjaxHtml  .= '<option value="">--- Select ---</option>';
				$AjaxHtml  .= '</select>';
				 
			}
				
			
							
			break;
			exit;

            case 'VendorDefaultAccount':
			$objSupplier=new supplier();
			$arrySupplier = $objSupplier->GetSupplier('',$_GET['SuppCode'],'');	
			$AjaxHtml = $arrySupplier[0]['AccountID'];

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

 	    case 'getVendorInvoiceForTransfer':
                            $objBankAccount=new BankAccount();
                            global $Config;
			if(!empty($_GET['SuppCode'])){
                            $arryInvoice=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
                            $num=$objBankAccount->numRows();
                      
				



				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >	
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
                                                   <tr align="left">
                                                               <td class="head1" align="center" width="3%">Select</td>
                                                               <td width="7%"  class="head1">Invoice Date</td>
                                                               <td width="9%" class="head1">Invoice Number</td>
                                                             
                                                               <td width="10%" class="head1" >Invoice Amount</td>
<td width="10%" class="head1" >Conversion Rate</td>
                                                               <td width="15%" align="left" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>

                                                               <td width="15%" align="left" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="10%" align="right" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>


                                                   </tr>';
   
	
	if(is_array($arryInvoice) && $num>0){
	$flag=true;
	$Line=0;
	$sumPayAmount=0;
        $openBalance = 0;
        $totalOpenBalance = 0;
	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
	$TotalAmount = $values['TotalAmount'];
	
	

	$ConversionRate=""; $DisplayConvers = 'style="display:none"';	
	/****************/
	if($values['Currency']!=$Config['Currency'])
	{
		$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
		$TotalAmount=$ConversionRate * $TotalAmount;
		$TotalAmount = round($TotalAmount,2);
		
		$orderTotalAmount = round($orderTotalAmount*$ConversionRate,2);		
		$DisplayConvers = '';	
	}
	/****************/
	//if($values['Currency']!=$Config['Currency']){
		//$TotalAmount=CurrencyConvertor($TotalAmount,$values['Currency'],$Config['Currency']);
		//$TotalAmount = round($TotalAmount,2);

		//$orderTotalAmount=CurrencyConvertor($orderTotalAmount,$values['Currency'],$Config['Currency']);
		//$orderTotalAmount = round($orderTotalAmount,2);
	//}
	/****************/



        if($values['paidAmnt'] > 0){
         $openBalance =  $TotalAmount-$values['paidAmnt']; 
        }else{
            $openBalance =  $TotalAmount; 
        }
        $openBalance = number_format($openBalance,'2','.','');
        if($openBalance>0) $totalOpenBalance += $openBalance;
        
        
        
      if(!empty($_GET['TransferID'])){		
		$PayAmount=0; $idTrans=0;
		$arryTransferDetail = $objBankAccount->GetFundTransferDetail($_GET['TransferID'],$values['InvoiceID'],'Purchase'); 			$PayAmount = $arryTransferDetail[0]['PaymentAmount'];
		$idTrans = $arryTransferDetail[0]['id'];
		$sumPayAmount += $PayAmount;
      }


	
     $InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
     
       if($values['InvoiceEntry'] == 1)
        {
            $PONumber = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }else{
           $PONumber = '<a href="../purchasing/vPO.php?pop=1&amp;module=order&amp;po='.$values['PurchaseID'].'" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }
     
      

	$checked = ($idTrans>0)?("checked"):("");

        
	$AjaxHtml .= '<tr align="left" bgcolor='.$bgcolor.'>
                        <td align="left"><input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')" '.$checked.'>

                            <input name="InvoiceID_'.$Line.'" type="hidden" id="InvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
		            <input name="PurchaseID_'.$Line.'" type="hidden" id="PurchaseID_'.$Line.'" value="'.$values['PurchaseID'].'"  />

                            <input type="hidden" name="OrderID_'.$Line.'" id="OrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
                            <input type="hidden" name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$orderTotalAmount.'">
                            <input type="hidden" name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'">    
                             </td>';
                         $AjaxHtml .='<td>'.$values['PostedDate'].'</td>';    
			 $AjaxHtml .='<td>'.$InvoiceID.'</td>';
			 
                  
                         
                           $AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['Currency'].'<input type="hidden" name="TotalAmountOld_'.$Line.'" id="TotalAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"></td>';
			$AjaxHtml .= '<td><input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate_'.$Line.'" id="ConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';
                         $AjaxHtml .= '<td align="left"><input type="text" class="normal" size="10" readonly name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalAmount.'"></td>';
                         $AjaxHtml .= '<td align="left"><input type="text" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="hidden" name="paidAmnt_'.$Line.'" id="paidAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';
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
                    
                    <input type="hidden" name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">

                 <input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
            </td>
            </tr>
            </table> ';
            }

          } 
				
			
							
			break;
			exit;

	 case 'getReconciliationList':
	
		$objReport = new report();
		$objBankAccount= new BankAccount();
		
		$arryReconciliationMonths = $objReport->getReconciliationMonths($_GET);  
		$num=$objReport->numRows();
		$ListUrl = "bankReconciliation.php";
		$AjaxHtml = '<table '.$table_bg.'>   
				<tr align="left">
					<td  align="left" class="head1">GL Account</td>
					<td width="15%" align="center" class="head1">Ending Balance</td>
					<td width="15%" align="center" class="head1">Year</td>
					<td width="15%" align="center" class="head1">Month</td>
					<td width="15%" align="center" class="head1">Status</td>
					<td width="10%" class="head1" align="center">Action</td>
				</tr>';

 if(is_array($arryReconciliationMonths) && $num>0){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($arryReconciliationMonths as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;
	       
            $monthNum  = $values['Month'];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
            
            if($values['Status'] == "NotReconciled")
            {
                $Status = "Not Reconciled";
		$StatusCls = "red";
            }else{
                $Status = "Reconciled";
		$StatusCls = "green";
            }
	$AccountName = $objBankAccount->getBankAccountById($values['AccountID']);


 	$AjaxHtml .= '<tr align="left"  bgcolor="'.$bgcolor.'">
       
      <td align="left">'.ucwords($AccountName[0]['AccountName']).' ['.$AccountName[0]['AccountNumber'].']</td>
       <td align="center">'.number_format($values['EndingBankBalance'],2).'</td>
      <td align="center">'.$values['Year'].'</td>
      <td align="center">'.$monthName.'</td>
      <td align="center" class="'.$StatusCls.'">'.$Status.'</td>
      <td align="center" class="head1_inner">';

  $AjaxHtml .= '<a class="fancybox fancybig fancybox.iframe"  href="vReconciliation.php?view='.$values['ReconcileID'].'">'.$view.'</a> ';

	if($values['FinalStatus']!='1'){ //Not Complete
		$AjaxHtml .= '<a href="'.$ListUrl.'?edit='.$values['ReconcileID'].'&Year='.$values['Year'].'&Month='.$values['Month'].'&AccountID='.$values['AccountID'].'&Status='.$values['Status'].'&tr='.$_GET['tr'].'">'.$edit.'</a> 
		<a href="'.$ListUrl.'?del_id='.$values['ReconcileID'].'&AccountID='.$values['AccountID'].'&tr='.$_GET['tr'].'" onclick="return confDel(\'reconciled month\')"  >'.$delete.'</a>';
	}

       $AjaxHtml .= '</td>

    </tr>';
	

	
        	} // foreach end
		
  
	}else{
		$AjaxHtml .= '<tr align="center" >
		<td  colspan="6" class="no_record">No record found.</td>
		</tr>';
	} 
  
	$AjaxHtml .= '<tr>  <td  colspan="6"  id="td_pager">Total Record(s) : &nbsp;'. $num.'</td>
	  </tr>
	  </table>';



			break;
			exit;


	case 'CheckContraAR':  
			if($_GET['custID']>0){
				$objBankAccount=new BankAccount();
				$arryLinkCustVen = $objBankAccount->GetCustomerVendor($_GET['custID'],'');
				$AjaxHtml = $arryLinkCustVen[0]['SuppID'];
			}
			break;
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

	case 'getCustomerInvoice':  //Bhoodev
			//echo '<pre>';print_r($_GET);exit;
		  $objBankAccount=new BankAccount();
				             Global $Config;
			    if(!empty($_GET['custID'])){
			    $arryLinkCustVen = $objBankAccount->GetCustomerVendor($_GET['custID'],'');
			    
				                $_GET['InvoicePaid'] = 'Paid';
				$arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
				            $num=$objBankAccount->numRows();
				$objCommon=new common();

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
				if($ErrorMsgCust ==''){	      



				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    <tr>
				<td  class="head"> AR Invoice</td>
				</tr>
				                               <tr>
				                               <td valign="top">
				                               <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
				                                   <tr align="left">
				                                               <td width="1%" class="head1" align="center">Select</td>
				                                               <td width="10%"  class="head1">Invoice Date</td>
				                                               <td width="8%" class="head1">Invoice#</td>
				                                               <td class="head1">Sales Person</td>
		<td width="10%" class="head1" >Invoice Amount</td>
		<td width="10%" class="head1" >Conversion Rate</td>

				                                               <td width="15%" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
				                                               <td width="15%" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
				                                               <td  class="head1" align="right">Payment&nbsp;('.$Config['Currency'].')</td>
				                                   </tr>';
		   
		    
		    if(is_array($arrySale) && $num>0){
		    $flag=true;
		    $Line=0;
			$openBalance = 0;
			$totalOpenBalance = 0;
		    foreach($arrySale as $key=>$values){
		    $flag=!$flag;
		    $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		    $Line++;
		    $TotalInvoiceAmount = $values['TotalInvoiceAmount'];
		    $ConversionRate=""; $DisplayConvers = 'style="display:none"';    
		    /****************/
		    if($values['CustomerCurrency']!=$Config['Currency']){

			if(empty($arryCurrencyVal[$values['CustomerCurrency']])){
				$ConversionRate=CurrencyConvertor(1,$values['CustomerCurrency'],$Config['Currency']);
				$arryCurrencyVal[$values['CustomerCurrency']]=$ConversionRate;
			}else{
				$ConversionRate=$arryCurrencyVal[$values['CustomerCurrency']];
			}			


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
				        <td align="center"><input type="checkbox" name="invoice_check_'.$Line.'" id="invoice_check_'.$Line.'" onClick="SetPayAmntByCheck('.$Line.')">
				            <input name="InvoiceID_'.$Line.'" type="hidden" id="InvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
				    <input name="SaleID_'.$Line.'" type="hidden" id="SaleID_'.$Line.'" value="'.$values['SaleID'].'"  />
				            <input type="hidden" name="OrderID_'.$Line.'" id="OrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
				            <input type="hidden" name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$values['TotalAmount'].'"> 
				            <input type="hidden" name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'"> 
				             </td>';
				         $AjaxHtml .='<td >'.$values['InvoiceDate'].'</td>';    
			     $AjaxHtml .='<td>'.$InvoiceID.'</td>'; 
				         $AjaxHtml .= '<td>'.$salesPerson.'</td>';
			    $AjaxHtml .= '<td>'.$values['TotalInvoiceAmount'].' '.$values['CustomerCurrency'].'<input type="hidden" name="TotalInvoiceAmountOld_'.$Line.'" id="TotalInvoiceAmountOld_'.$Line.'" value="'. $values['TotalInvoiceAmount'].'"></td>';
			    $AjaxHtml .= '<td><input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate_'.$Line.'" id="ConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';
				         $AjaxHtml .= '<td><input type="text" class="normal" size="10" readonly name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalInvoiceAmount.'"></td>';
				         $AjaxHtml .= '<td><input type="hidden" class="normal" size="10" readonly name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="openBalance_'.$Line.'" id="openBalance_'.$Line.'" value="'.$openBalance.'"><input type="hidden" name="receivedAmnt_'.$Line.'" id="receivedAmnt_'.$Line.'" value="'. $values['receivedAmnt'].'"></td>';
				         $AjaxHtml .= '<td align="right"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
				       
			    
		     } 
		  
		     }else{
		    $AjaxHtml .= '<tr align="center">
		      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
		     
		     }
		  
			    if(is_array($arrySale) && $num>0){     
			     $AjaxHtml .= ' 
			    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
				 <tr>  
				     <td align="right" ><strong>Total Payment : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment" id="total_payment" value="0.00"></strong></td>
				     </tr>
			      </table>
				<input type="hidden" name="totalInvoice" id="totalInvoice" value="'.$num.'">
				    <input type="hidden" name="ContraAcnt" id="ContraAcnt" value="'.$_GET['confirm'].'">
				    <input type="hidden" name="totalOpenBalance" id="totalOpenBalance" value="'.$totalOpenBalance.'">
				 <input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
			    </td>
			    </tr>
			    </table> </div>';
			    }
			  } 
		if($_GET['confirm'] ==1){
		    $SuppID = $arryLinkCustVen[0]['SuppID'];
		    if($SuppID>0){
			$arryVendor = $objBankAccount->GetSupplier($SuppID,'','');
		    }
		    
				             $_GET['SuppCode'] = $arryVendor[0]['SuppCode']; 
			    if(!empty($_GET['SuppCode'])){
				            $arryVendorInvoice=$objBankAccount->ListUnpaidPurchaseInvoice($_GET);
				            $num=$objBankAccount->numRows();
				      
				$AjaxHtml  .= '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    <tr>
				<td valign="top" class="head1"> AP Invoice</td>
				</tr>
				                               <tr>
				                               <td valign="top">
				                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
				                                   <tr align="left">
				                                               <td class="head1" align="center" width="1%">Select</td>
				                                               <td width="10%"  class="head1">Invoice Date</td>
				                                               <td width="9%" class="head1">Invoice Number</td>
				                                               <td width="17%" class="head1">PO/Reference Number</td>
				                                               <td width="10%" class="head1" >Invoice Amount</td>
		<td width="10%" class="head1" >Conversion Rate</td>
				                                               <td width="15%" align="left" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
				                                               <td width="15%" align="left" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
				                                               <td   align="right" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>
				                                   </tr>';
		   
		    
		    if(is_array($arryVendorInvoice) && $num>0){
		    $flag=true;
		    $Line=0;
			$openBalance = 0;
			$totalOpenBalance = 0;
		    foreach($arryVendorInvoice as $key=>$values){
		    $flag=!$flag;
		    $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		    $Line++;
		    $orderTotalAmount = $objBankAccount->GetOrderTotalPaymentAmntForPurchase($values['PurchaseID']);
		    $TotalAmount = $values['TotalAmount'];
		    
		    
		    $ConversionRate=""; $DisplayConvers = 'style="display:none"';    
		    /****************/
		    if($values['Currency']!=$Config['Currency'])
		    {

			if(empty($arryCurrencyVal[$values['Currency']])){
				$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
				$arryCurrencyVal[$values['Currency']]=$ConversionRate;
			}else{
				$ConversionRate=$arryCurrencyVal[$values['Currency']];
			}


			$TotalAmount=$ConversionRate * $TotalAmount;
			$TotalAmount = round($TotalAmount,2);
		
			$orderTotalAmount = round($orderTotalAmount*$ConversionRate,2);        
			$DisplayConvers = '';    
		    }
		    /****************/
		    //if($values['Currency']!=$Config['Currency']){
			//$TotalAmount=CurrencyConvertor($TotalAmount,$values['Currency'],$Config['Currency']);
			//$TotalAmount = round($TotalAmount,2);
			//$orderTotalAmount=CurrencyConvertor($orderTotalAmount,$values['Currency'],$Config['Currency']);
			//$orderTotalAmount = round($orderTotalAmount,2);
		    //}
		    /****************/
		 
			if($values['paidAmnt'] > 0){
			 $openBalance =  $TotalAmount-$values['paidAmnt']; 
			}else{
			    $openBalance =  $TotalAmount; 
			}
			$openBalance = number_format($openBalance,'2','.','');
			if($openBalance>0) $totalOpenBalance += $openBalance;
		
		
		
		      
		    
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
				        <td align="center"><input type="checkbox" name="Vendor_invoice_check_'.$Line.'" id="Vendor_invoice_check_'.$Line.'" onClick="SetApPayAmntByCheck('.$Line.')">
				            <input name="VendorInvoiceID_'.$Line.'" type="hidden" id="VendorInvoiceID_'.$Line.'" value="'.$values['InvoiceID'].'"  />
				    <input name="PurchaseID_'.$Line.'" type="hidden" id="PurchaseID_'.$Line.'" value="'.$values['PurchaseID'].'"  />
				            <input type="hidden" name="VendorOrderID_'.$Line.'" id="VendorOrderID_'.$Line.'" value="'.$values['OrderID'].'"  />    
				            <input type="hidden" name="VendorTotalAmount_'.$Line.'" id="VendorTotalAmount_'.$Line.'" value="'.$orderTotalAmount.'">
				            <input type="hidden" name="VendorInvoiceEntry_'.$Line.'" id="VendorInvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'">    
				             </td>';
				         $AjaxHtml .='<td>'.$values['PostedDate'].'</td>';    
			     $AjaxHtml .='<td>'.$InvoiceID.'</td>';
			     
				         $AjaxHtml .='<td>'.$PONumber.'</td>';
				         
				           $AjaxHtml .= '<td>'.$values['TotalAmount'].' '.$values['Currency'].'<input type="hidden" name="TotalVendorAmountOld_'.$Line.'" id="TotalVendorAmountOld_'.$Line.'" value="'. $values['TotalAmount'].'"></td>';
			    $AjaxHtml .= '<td><input type="text" onchange="Javascript:ChangeVendorConversionrate('.$Line.');" name="VendorConversionRate_'.$Line.'" id="VendorConversionRate_'.$Line.'" value="'.$ConversionRate.'" class="textbox" size="5" maxlength="10" onkeypress="return isDecimalKey(event);" '.$DisplayConvers.'></td>';
				         $AjaxHtml .= '<td align="left"><input type="text" class="normal" size="10" readonly name="TotalVendorInvoiceAmount_'.$Line.'" id="TotalVendorInvoiceAmount_'.$Line.'" value="'.$TotalAmount.'"></td>';
				         $AjaxHtml .= '<td align="left"><input type="hidden" class="normal" size="10" readonly name="vendorinvoice_amnt_'.$Line.'" id="vendorinvoice_amnt_'.$Line.'" value="'.$openBalance.'"><input type="text" class="normal" size="10" readonly name="vendoropenBalance_'.$Line.'" id="vendoropenBalance_'.$Line.'" value="'.$openBalance.'"><input type="hidden" name="paidVendorAmnt_'.$Line.'" id="paidVendorAmnt_'.$Line.'" value="'. $values['paidAmnt'].'"></td>';
				         $AjaxHtml .= '<td align="right"><input type="text" name="payment_vendor_amnt_'.$Line.'" id="payment_vendor_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAPAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
				       
			    
		     } 
		  
		     }else{
		    $AjaxHtml .= '<tr align="center">
		      <td  colspan="9" class="no_record">'.NO_INVOICE.'</td></tr></table>';
		     
		     }
		  
			    if(is_array($arryVendorInvoice) && $num>0){     
			     $AjaxHtml .= ' 
			    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >    
				 <tr>  
				     <td align="right"  ><strong>Total Payment : <input type="textbox" class="disabled" style="width: 90px;text-align: right;" readonly="" name="total_payment_ventor" id="total_payment_ventor" value="0.00"></strong></td>
				     </tr>
			      </table>
				<input type="hidden" name="totalInvoiceVendor" id="totalInvoiceVendor" value="'.$num.'">
				    
				    <input type="hidden" name="totalOpenBalanceVendor" id="totalOpenBalanceVendor" value="'.$totalOpenBalance.'">
				 <input type="hidden" name="savePaymentInfo" id="savePaymentInfo" value="Yes">   
		<input type="hidden" name="SuppCode" id="SuppCode" value="'.$_GET['SuppCode'].'"> 
			    </td>
			    </tr>
			    </table> ';
			    }
			  } 
		}            
			    
		      

			}
			break;
			exit;


	 case 'SaveCheckTemplate':
			$objReport = new report();
			$objReport->SaveCheckTemplate($_GET);  
			break;
			exit;

 




	}

	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	/*****14 august 2015 ***/  
        
        switch($_GET['actionn']){
		 
			
			case 'getAccountType':
                          
                           
			$objBankAccount=new BankAccount();
                     	
			if(!empty($_GET['Range'])){
                            
                           
			 $arryAccount = $objBankAccount->getAccountTypeByRange($_GET['Range']);
		 
			 $AjaxHtml  .= $arryAccount[0]["AccountType"]."##";
                                
                                /***group account***/
                	 $arryGroupAccount = $objBankAccount->getGroupByAccountType($arryAccount[0]["AccountTypeID"]);
			// $arryGroupAccount = $objBankAccount->getGroupAccountByRange($_GET['Range']);
			//print_r($arryGroupAccount);exit;
				$AjaxHtml  .= '<select name="ParentGroupID" class="inputbox" id="ParentGroupID" onchange="Javascript: SetMainGroupAccountId();" '.$DisabledBox.'>';
				
				
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				

				//$StateSelected = (!empty($_GET['current_account']))?($_GET['current_account']):($arryAccount[0]['ParentAccountID']);
				
				for($i=0;$i<sizeof($arryGroupAccount);$i++) {
				
					$Selected = ($_GET['ParentID'] == $arryGroupAccount[$i]['GroupID'])?(" Selected"):(" ");
					
					$AjaxHtml  .= '<option value="'.$arryGroupAccount[$i]['GroupID'].'" '.$Selected.'>'.stripslashes($arryGroupAccount[$i]['GroupName']).'</option>';
                                        
                                        
                                        //$AjaxHtml .= $objBankAccount->GetSubAccountTreeWithSelect($arryAccount[$i]['BankAccountID'],0);
            
                                        $childOption=$objBankAccount->GetSubGroupAccountTreeWithSelect($arryGroupAccount[$i]['GroupID'],0);
                                        $spaceVar="&nbsp;&nbsp;&nbsp;";
                                        
                                        if(count($childOption)>0)
                                        {
                                                foreach($childOption as $values){
                                                    
                                                    $Selected1 = ($_GET['ParentID'] == $values[GroupID])?(" Selected"):(" ");
                                                    $spaceVar.="";
                                                    $AjaxHtml  .= '<option value="'.$values[GroupID].'"  '.$Selected1.'>'.$spaceVar.stripslashes($values[GroupName]).'</option>';
                                                    $childOption33=$objBankAccount->GetSubGroupAccountTreeWithSelect1($values[GroupID],0,'',$_GET['ParentID']);
                                                    $AjaxHtml;
                                                    
                                                    if(!empty($childOption33)){
                                                       $AjaxHtml.=$childOption33;
                                                       //echo $childOption33;
                                                    }else {
                                                       $AjaxHtml;
                                                    }
                                                }
                                        }
					
				}

				$Selected = ($_GET['ParentID'] == '0')?(" Selected"):("");
				if(sizeof($arryGroupAccount)<=0){
					$AjaxHtml  .= '<option value="">No account found.</option>';
				}
				$AjaxHtml  .= '</select>';
                                
                                $AjaxHtml  .= '##'.$arryAccount[0]["RangeFrom"]."##".$arryAccount[0]["RangeTo"];
                                
			  
                                /***group account end****/
			}				
			break;
			exit;

                      
		      case 'getAccountTypeGroup':
                       
                           
			$objBankAccount=new BankAccount();
                     	
			if(!empty($_GET['AccountType'])){
                            
                                           
                                /***group account***/
                
			 $arryGroupAccount = $objBankAccount->getGroupByAccountType($_GET['AccountType']);
			
				$AjaxHtml  .= '<select name="ParentGroupID" class="inputbox" id="ParentGroupID" onchange="Javascript: SetMainGroupAccountId();" '.$DisabledBox.'>';
				
				
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				

				
				for($i=0;$i<sizeof($arryGroupAccount);$i++) {
				
					$Selected = ($_GET['ParentID'] == $arryGroupAccount[$i]['GroupID'])?(" Selected"):(" ");
					
					$AjaxHtml  .= '<option value="'.$arryGroupAccount[$i]['GroupID'].'" '.$Selected.'>'.stripslashes($arryGroupAccount[$i]['GroupName']).'</option>';
                                        
                                      
            
                                        $childOption=$objBankAccount->GetSubGroupAccountTreeWithSelect($arryGroupAccount[$i]['GroupID'],0);
                                        $spaceVar="&nbsp;&nbsp;&nbsp;";
                                        
                                        if(count($childOption)>0)
                                        {
                                                foreach($childOption as $values){
                                                    
                                                    $Selected1 = ($_GET['ParentID'] == $values[GroupID])?(" Selected"):(" ");
                                                    $spaceVar.="";
                                                    $AjaxHtml  .= '<option value="'.$values['GroupID'].'"  '.$Selected1.'>'.$spaceVar.stripslashes($values[GroupName]).'</option>';
                                                    $childOption33=$objBankAccount->GetSubGroupAccountTreeWithSelect1($values[GroupID],0,'',$_GET['ParentID']);
                                                    $AjaxHtml;
                                                    
                                                    if(!empty($childOption33)){
                                                       $AjaxHtml.=$childOption33;
                                                      
                                                    }else {
                                                       $AjaxHtml;
                                                    }
                                                }
                                        }
					
				}

				$Selected = ($_GET['ParentID'] == '0')?(" Selected"):("");
				if(sizeof($arryGroupAccount)<=0){
					$AjaxHtml  .= '<option value="">No group found.</option>';
				}
				$AjaxHtml  .= '</select>';
                                
                               
                                
			  
                                /***group account end****/
			}				
			break;
			exit;
        }        

        if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
        
        
        /***** end 14 august 2015 ***/  



?>
