<?php	session_start();
	$Prefix = "../../"; 
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/finance.account.class.php");
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
				 if($_GET['AccountID'] == 7){
				  $AjaxHtml  = "<b>Billed</b> ".$Config['Currency'].' '.$AccountBalance."";
                                 }else{
                                     $AjaxHtml  = "<b>Balance</b> ".$Config['Currency'].' '.$AccountBalance."";
                                     
                                 }
				}
			 break;
			 exit;
                         
                         
           case 'getCustomerInvoice':
			 $objBankAccount=new BankAccount();
                     	Global $Config;
			if(!empty($_GET['custID'])){
                            $_GET['InvoicePaid'] = 'Paid';
			    $arrySale=$objBankAccount->ListUnPaidInvoice($_GET);
			    
                            $num=$objBankAccount->numRows();
                      
				$AjaxHtml  = '<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">	
                                               <tr>
                                               <td valign="top">
                                               <table cellspacing="1" cellpadding="3" width="100%" align="left" id="list_table">
                                                   <tr align="left">
                                                               <td class="head1" align="center">Select</td>
                                                               <td width="12%"  class="head1">Invoice Date</td>
                                                               <td width="14%" class="head1">Invoice Number</td>
                                                               <td class="head1">Sales Person</td>
                                                                 <td width="20%" align="center" class="head1">Conversion Rate</td>
                                                               <td width="20%" align="center" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" align="center" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="10%" align="center" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

                             </tr>';
   
	
	if(is_array($arrySale) && $num>0)
	{
	$flag=true;
	$Line=0;
        $openBalance = 0;
        $totalOpenBalance = 0;
	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$TotalInvoiceAmount = $values['TotalInvoiceAmount'];
	/****************/
	if($values['CustomerCurrency']!=$Config['Currency']){
		$ConversionRate=CurrencyConvertor(1,$values['CustomerCurrency'],$Config['Currency']);
		$TotalInvoiceAmount=$ConversionRate * $TotalInvoiceAmount;
		
		//$ConversionRate=round($ConversionRate,2);
		$TotalInvoiceAmount = round($TotalInvoiceAmount,2);
	}
	
	else 
	{
	$ConversionRate="";	
	}
	
	
	/****************/





        if($values['receivedAmnt'] > 0){
         $openBalance =  $TotalInvoiceAmount-$values['receivedAmnt']; 
        }else{
            $openBalance =  $TotalInvoiceAmount; 
        }
       // $openBalance = number_format($openBalance,'2','.','');
        $totalOpenBalance += $openBalance;
        
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
                            <input type="text" name="TotalAmount_'.$Line.'" id="TotalAmount_'.$Line.'" value="'.$values['TotalAmount'].'"> 
                            <input type="hidden" name="InvoiceEntry_'.$Line.'" id="InvoiceEntry_'.$Line.'" value="'.$values['InvoiceEntry'].'"> 
                             </td>';
                         $AjaxHtml .='<td>'.$values['InvoiceDate'].'</td>';    
			 $AjaxHtml .='<td>'.$InvoiceID.'</td>'; 
                         $AjaxHtml .= '<td>'.$salesPerson.'</td>';
                             $AjaxHtml .= '<td align="left">'.$values['CustomerCurrency'].' '.$values['TotalInvoiceAmount'].'<input type="text" onchange="Javascript:ChangeConversionrate('.$Line.');" name="ConversionRate'.$Line.'" id="ConversionRate'.$Line.'" value="'.$ConversionRate.'"></td>';

                             
                             $AjaxHtml .= '<td align="left"><input type="text" name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalInvoiceAmount.'">
                             <input type="hidden" name="TotalInvoiceAmountOld_'.$Line.'" id="TotalInvoiceAmountOld_'.$Line.'" value="'. $values['TotalInvoiceAmount'].'">
                             
                             </td>';
                         $AjaxHtml .= '<td align="left">'.$openBalance.'<input type="hidden" name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"></td>';
                         $AjaxHtml .= '<td align="left"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="7" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
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
                        
                         case 'getVendorInvoice':
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
                                                               <td class="head1" align="center" width="5%">Select</td>
                                                               <td width="12%"  class="head1">Invoice Date</td>
                                                               <td width="14%" class="head1">Invoice Number</td>
                                                               <td width="14%" class="head1">PO/Reference Number</td>
                                                                <td width="14%" class="head1">Conversion Rate</td>
                                                               <td width="15%" align="center" class="head1">Original Amount&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="15%" align="center" class="head1">Open Balance&nbsp;('.$Config['Currency'].')</td>
                                                               <td width="10%" align="center" class="head1">Payment&nbsp;('.$Config['Currency'].')</td>

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
	/****************/
	if($values['Currency']!=$Config['Currency']){
		$TotalAmount=CurrencyConvertor($TotalAmount,$values['Currency'],$Config['Currency']);
		$TotalAmount = round($TotalAmount,2);

		$orderTotalAmount=CurrencyConvertor($orderTotalAmount,$values['Currency'],$Config['Currency']);
		$orderTotalAmount = round($orderTotalAmount,2);
		
		$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
	}
	/****************/



        if($values['paidAmnt'] > 0){
         $openBalance =  $TotalAmount-$values['paidAmnt']; 
        }else{
            $openBalance =  $TotalAmount; 
        }
        $openBalance = number_format($openBalance,'2','.','');
        $totalOpenBalance += $openBalance;
        
        
        
      
	
     $InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values['InvoiceID'].'</a>';
     
       if($values['InvoiceEntry'] == 1)
        {
            $PONumber = '<a href="vPoInvoice.php?pop=1&amp;view='.$values['OrderID'].'&IE=1" class="fancybox po fancybox.iframe">'.$values['PurchaseID'].'</a>';
        }else{
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
                         
                          $AjaxHtml .= '<td align="center">'.$values['Currency'].' '.$values['TotalAmount'].'<input type="text" name="$ConversionRate_'.$Line.'" id="$ConversionRate_'.$Line.'" value="'.$ConversionRate.'"></td>';
                         
                         $AjaxHtml .= '<td align="center">'.$TotalAmount.'<input type="hidden" name="TotalInvoiceAmount_'.$Line.'" id="TotalInvoiceAmount_'.$Line.'" value="'.$TotalAmount.'"></td>';
                         $AjaxHtml .= '<td align="center">'.$openBalance.'<input type="hidden" name="invoice_amnt_'.$Line.'" id="invoice_amnt_'.$Line.'" value="'.$openBalance.'"></td>';
                         $AjaxHtml .= '<td align="center"><input type="text" name="payment_amnt_'.$Line.'" id="payment_amnt_'.$Line.'" maxlength="50" onkeypress="return isDecimalKey(event);" onblur="SetPayAmnt()" style="width:90px;text-align: right;" class="textbox setPrice"></td></tr>';
                       
			

     } 
  
     }else{
    $AjaxHtml .= '<tr align="center">
      <td  colspan="7" class="no_record">'.NO_INVOICE.'</td></tr></table>';
     
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


	}

		




	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
