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
	 require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/MyMailer.php");	
	require_once($Prefix."classes/supplier.class.php");	
        require_once($Prefix."classes/finance.report.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php"); 
require_once($Prefix."classes/sales.customer.class.php");        
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once("language/english.php");
	
require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/purchase.class.php");

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}
 
	(empty($_GET['action']))?($_GET['action']=""):("");
	(empty($_GET['actionn']))?($_GET['actionn']=""):("");
	(empty($_POST['Action']))?($_POST['Action']=""):("");
	(empty($_POST['action']))?($_POST['action']=""):("");

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
	include("../includes/common.php");
	 
        if($_SESSION['currency_id']>0){
			$arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'],'');
			$Config['Currency'] = $arrySelCurrency[0]['code'];
			$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
			$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
			$Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value'];
		}
        
 
	switch($_GET['action']){
		case 'delete_upload_file':
			if($_GET['file_dir']!='' && $_GET['file_name']!=''){
				$objFunction=new functions();
				$objFunction->DeleteFileStorage($_GET['file_dir'],$_GET['file_name']);
				echo "1";
			}else{
				echo "0";
			}
			break;
			exit;
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
			$NumState=0;
			if(!empty($_GET['country_id'])){ 
				$arryState = $objRegion->getStateByCountry($_GET['country_id']);
				$NumState = sizeof($arryState);
			}
			
				$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';
				
				if($_GET['select']==1 && $NumState>0){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);
				
				for($i=0;$i<sizeof($arryState);$i++) {
				
					$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
				}

				$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
				if($NumState<=0){
					$AjaxHtml  .= '<option value="">No state found.</option>';
				}else if(!empty($_GET['other'])){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				} 
				$AjaxHtml  .= '</select>';
			
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="'.$StateSelected.'">';
							
			break;
			
			
	case 'city':
			$objRegion=new region();
			$NumCity=0;
			if(!empty($_GET['country_id'])){ 
				if(!empty($_GET['ByCountry'])){
					$arryCity = $objRegion->getCityList('', $_GET['country_id']);
					$NumCity = sizeof($arryCity);
				}else if(!empty($_GET['state_id'])){   
					$arryCity = $objRegion->getCityList($_GET['state_id'], $_GET['country_id']);
					$NumCity = sizeof($arryCity);
				}
				$FirstCity = (!empty($arryCity[0]['city_id'])?($arryCity[0]['city_id']):(''));
				
			} 

				$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}


				$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($FirstCity);
				
				for($i=0;$i<$NumCity;$i++) {
				
					$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.htmlentities($arryCity[$i]['name'], ENT_IGNORE).'</option>';
					
				}

				$Selected = ($_GET['current_city'] == '0')?(" Selected"):("");
				if(!empty($_GET['other'])){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				}else if($NumCity<=0){
					$AjaxHtml  .= '<option value="">No city found.</option>';
				}

				$AjaxHtml  .= '</select>';
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_city_id" id="ajax_city_id" value="'.$CitySelected.'">';
							
			break;
	case 'zipSearch':		
		$objRegion=new region();
		$AjaxHtml='';
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

		case 'CancelRecurringJournal':
			$objJournal = new journal();
			if(!empty($_GET['id'])){
			 	$AjaxHtml = $objJournal->RemoveRecurringJournal($_GET['id']);						 
			}
			 break;
			 exit;

	  	case 'CancelAPRecurringInvoice':
			$objPurchase = new purchase();
			if(!empty($_GET['id'])){
				$AjaxHtml = $objPurchase->RemovePurchaseRecurring($_GET['id']);						 
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
			if(!empty($arrySupplier[0])){
				echo json_encode($arrySupplier[0]);exit;
			}

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
                      
                            if(!empty($_GET['EditID'])){
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

  		 case 'getCurrencyRate': 
			global $Config;	
			
			if($_GET['FromCurrency']!=$Config['Currency']){			
				$ConversionRate=CurrencyConvertor(1,$_GET['FromCurrency'],$Config['Currency']);
			}else{
				$ConversionRate=1;
			}
			$AjaxHtml = $ConversionRate;
		 	break;

         	 case 'getRealCurrencyRate': 
			global $Config;	
			$Config['RealTime']=1;
			if($_GET['FromCurrency']!=$Config['Currency']){			
				$ConversionRate=CurrencyConvertor(1,$_GET['FromCurrency'],$Config['Currency']);
			}else{
				$ConversionRate=1;
			}
			$AjaxHtml = $ConversionRate;
		 	break;	  
     	
                  case 'getCurrencyRateByModule': 
			global $Config;			
			if($_GET['Currency']!=$Config['Currency']){			
				$ConversionRate=CurrencyConvertor(1,$_GET['Currency'],$Config['Currency'],$_GET['Module'],$_GET['CurrencyDate']);		 
			}else{
				$ConversionRate=1;
			}
			   
			$AjaxHtml = $ConversionRate;
		 	break;
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
// By Rajan 16 feb	
	case 'SearchSalesCode':
		$objItem=new items(); 	
		$arryProduct=$objItem->checkItemSku($_GET['key']);


		echo json_encode($arryProduct[0]);exit;

		break;
		exit; 
		
	//end	
		 case 'Groupaccount':
                   $objBankAccount=new BankAccount();
                     	$DisabledBox='';
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
		$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency'],'AP');
		$TotalAmount= GetConvertedAmount($ConversionRate, $TotalAmount);  
		$TotalAmount = round($TotalAmount,2);
		
		$orderTotalAmount = round(GetConvertedAmount($ConversionRate, $orderTotalAmount), 2);		
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



	 case 'SaveCheckTemplate':
			$objReport = new report();
			$objReport->SaveCheckTemplate($_GET);  
			break;
			exit;

	case 'settingCaption':
			$objCommon = new common();
			$AjaxHtml = $objCommon->SaveSettingCaption($_GET);  
			break;
			
 
/************* By RAVI ***************/


case 'hostbillprocessCheck':	
					
			$arr = array();
				if(!empty($_SESSION['importPaymentProcess']) || !empty($_SESSION['importCustomerProcess']) || !empty($_SESSION['importProductProcess']) || !empty($_SESSION['importInvoiceProcess']) ){
					

					if(!empty($_SESSION['importPaymentProcess'])){
							$statusPID = $objConfig->isRunning($_SESSION['importPaymentProcess']);
						if($statusPID){
							$arr['importPaymentStatusmsgStsus'] = 2;
							$arr['importPaymentStatus'] = 1;
						}else{
							unset($_SESSION['importPaymentProcess']);
							$arr['importPaymentStatusmsgStsus'] = 1;
							$arr['importPaymentStatus']   = 0;
						}

					}else{
						$arr['importPaymentStatusmsgStsus'] = 0;
						$arr['importPaymentStatus']=0;
					}
					
					if(!empty($_SESSION['importCustomerProcess'])){
							$statusPID = $objConfig->isRunning($_SESSION['importCustomerProcess']);
						if($statusPID){
							$arr['importCustomerStatusmsgStsus'] = 2;
							$arr['importCustomerStatus'] = 1;
						}else{
							unset($_SESSION['importCustomerProcess']);
							$arr['importCustomerStatusmsgStsus'] = 1;
							$arr['importCustomerStatus']   = 0;
						}

					}else{
						$arr['importCustomerStatusmsgStsus'] = 0;
						$arr['importCustomerStatus']=0;
					}

					if(!empty($_SESSION['importProductProcess'])){
							$statusPID = $objConfig->isRunning($_SESSION['importProductProcess']);
						if($statusPID){
							$arr['importProductStatusmsgStsus'] = 2;
							$arr['importProductStatus'] = 1;
						}else{
							unset($_SESSION['importProductProcess']);
							$arr['importProductStatusmsgStsus'] = 1;
							$arr['importProductStatus']   = 0;
						}

					}else{
						$arr['importProductStatusmsgStsus'] = 0;
						$arr['importProductStatus']=0;
					}


					if(!empty($_SESSION['importInvoiceProcess'])){
							$statusPID = $objConfig->isRunning($_SESSION['importInvoiceProcess']);
						if($statusPID){
							$arr['importInvoiceStatusmsgStsus'] = 2;
							$arr['importInvoiceStatus'] = 1;
						}else{
							unset($_SESSION['importInvoiceProcess']);
							$arr['importInvoiceStatusmsgStsus'] = 1;
							$arr['importInvoiceStatus']   = 0;
						}

					}else{
						$arr['importInvoiceStatusmsgStsus'] = 0;
						$arr['importInvoiceStatus']=0;
					}


	
}else{

				$arr['msgStsus'] = 0;
				$arr['status']   = 0;
}
		echo json_encode($arr);
			exit();
		break;	



	}

	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	/*****14 august 2015 ***/  
        
        switch($_GET['actionn']){
		 
			
			case 'getAccountType':
                          
                           
			$objBankAccount=new BankAccount();
                     	
			if(!empty($_GET['Range'])){
                            
                           (empty($DisabledBox))?($DisabledBox=""):("");
			 $arryAccount = $objBankAccount->getAccountTypeByRange($_GET['Range']);
		 
			 $AjaxHtml  = $arryAccount[0]["AccountType"]."##";
                                
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
                                                    
                                                    $Selected1 = ($_GET['ParentID'] == $values["GroupID"])?(" Selected"):(" ");
                                                    $spaceVar.="";
                                                    $AjaxHtml  .= '<option value="'.$values["GroupID"].'"  '.$Selected1.'>'.$spaceVar.stripslashes($values["GroupName"]).'</option>';
                                                    $childOption33=$objBankAccount->GetSubGroupAccountTreeWithSelect1($values["GroupID"],0,'',$_GET['ParentID']);
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
                            
				(empty($DisabledBox))?($DisabledBox=""):("");
                                           
                                /***group account***/
                
			 $arryGroupAccount = $objBankAccount->getGroupByAccountType($_GET['AccountType']);
			
				$AjaxHtml  = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID" onchange="Javascript: SetMainGroupAccountId();" '.$DisabledBox.'>';
				
				
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				

				
				for($i=0;$i<sizeof($arryGroupAccount);$i++) {
				
					$Selected = ($_GET['ParentID'] == $arryGroupAccount[$i]['GroupID'])?(" Selected"):(" ");
					
					$AjaxHtml  .= '<option value="'.$arryGroupAccount[$i]['GroupID'].'" '.$Selected.'>'.stripslashes($arryGroupAccount[$i]['GroupName']).'</option>';
                                        
                                      
            
                                        $childOption=$objBankAccount->GetSubGroupAccountTreeWithSelect($arryGroupAccount[$i]['GroupID'],0);
                                        $spaceVar="&nbsp;&nbsp;&nbsp;";
                                        
                                        if(count($childOption)>0)
                                        {
                                                foreach($childOption as $values){
                                                    
                                                    $Selected1 = ($_GET['ParentID'] == $values["GroupID"])?(" Selected"):(" ");
                                                    $spaceVar.="";
                                                    $AjaxHtml  .= '<option value="'.$values['GroupID'].'"  '.$Selected1.'>'.$spaceVar.stripslashes($values["GroupName"]).'</option>';
                                                    $childOption33=$objBankAccount->GetSubGroupAccountTreeWithSelect1($values["GroupID"],0,'',$_GET['ParentID']);
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
        
        (empty($_POST['BackgroundExec']))?($_POST['BackgroundExec']=""):("");

        /***** end 14 august 2015 ***/  
	//For Importing Vendor Excel 21Sep. 2016//
	if($_POST['BackgroundExec']=='Vendor' || $_POST['BackgroundExec']=='Customer'){
		$_SESSION['process'] = 'temp';
        CleanPost();
        $arr = array(); 
	$objSupplier=new supplier();
$objCustomer=new Customer();
        if(isRunning($_POST['pid'])){
         	$arr['count'] = $objSupplier->CountForImport(); 
         	$arr['status'] = 1;
         	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],1);
        }else{
        	//$arr['count'] = $objSupplier->CountForImport(); 
					$arr['count'] = ($_POST['BackgroundExec']=='Vendor') ? $objSupplier->CountForImport() : $objCustomer->CountForImport();
        	
        	$arr['status'] = 0;
        	$arr['per'] = percentageCountForExcel($arr['count'],$_POST['totalCount'],0);
        }
	
		if($arr['count']==0 && $arr['status']==0 && $arr['per']==0){
			unset($_SESSION['TotalImport']);
			unset($_SESSION['EXCEL_TOTAL']);
			unset($_SESSION['process']);
			unset($_SESSION['pid']); 
		}
	
        echo json_encode($arr);
         exit;
	}
	
	function isRunning($pid){
	    try{
		$result = shell_exec(sprintf("ps %d", $pid));
		if( count(preg_split("/\n/", $result)) > 2){
		    return true;
		}
	    }catch(Exception $e){}

	    return false;
	}

	function percentageCountForExcel($count,$totalCount,$status){
	if($status){
		if($count==0) $perc = 11; 
		else if($totalCount==$count) $perc = 100; 
		else $perc = ceil(($count*100)/$totalCount);
	}else{
		if($count>0) $perc = 100;
		else $perc = 0;
	}
	return $perc;
	}
	//End//

	
	 //**************************Sanjiv Singh invoice Comments ******************************
        if($_POST['Action']=='AddComment'){
        		
        	if(empty($Config['TodayDate'])) $Config['TodayDate'] = $_SESSION['TodayDate'];
        		
        	$objBankAccount = new BankAccount();
        	
        /*----------------------Sales Invoice -------------------------------*/
        	if($_POST['invoice_type']=='sales'){
        		
        		if($_POST['module_type']>0) {
        			$_POST['master_comment_id'] = $_POST['module_type'];
        			echo $cmtID = $objBankAccount->AddComment($_POST);
        			if(!empty($_POST['order_id']) && $cmtID){
        				$comments = $_POST['MultiComment'].'##'.$cmtID;
        				$objBankAccount->updateSalesInvoiceComment($comments, $_POST['order_id']);
        			}
        			exit;
        		}else{
        			$_POST['module_type'] = 'sales';
        			$_POST['type'] = 'custom';
        			if($_POST['comment']){
        				$mstcmtID = $objBankAccount->AddMasterComment($_POST);
        				$_POST['master_comment_id'] = $mstcmtID;
        				$cmtID = $objBankAccount->AddComment($_POST);
        				if(!empty($_POST['order_id']) && $cmtID){
        					$comments = $_POST['MultiComment'].'##'.$cmtID;
        					$objBankAccount->updateSalesInvoiceComment($comments, $_POST['order_id']);
        				}
        				echo $cmtID;
        			}else
        				echo 0;
        		}
        		
        /*---------------------Purchase Invoice --------------------------------*/
        	}else if($_POST['invoice_type']=='purchases'){
        		
        		if($_POST['module_type']>0) {
        			$_POST['master_comment_id'] = $_POST['module_type'];
        			echo $cmtID = $objBankAccount->AddComment($_POST);
        			if(!empty($_POST['order_id']) && $cmtID){
        				$comments = $_POST['MultiComment'].'##'.$cmtID;
        				$objBankAccount->updatePurchasesInvoiceComment($comments, $_POST['order_id']);
        			}
        			exit;
        		}else{
        			$_POST['module_type'] = 'purchases';
        			$_POST['type'] = 'custom';
        			if($_POST['comment']){
        				$mstcmtID = $objBankAccount->AddMasterComment($_POST);
        				$_POST['master_comment_id'] = $mstcmtID;
        				$cmtID = $objBankAccount->AddComment($_POST);
        				if(!empty($_POST['order_id']) && $cmtID){
        					$comments = $_POST['MultiComment'].'##'.$cmtID;
        					$objBankAccount->updatePurchasesInvoiceComment($comments, $_POST['order_id']);
        				}
        				echo $cmtID;
        			}else
        				echo 0;
        		}
        		/*---------------------End Purchase Invoice --------------------------------*/
        	}
        	
        	exit;
        
        }
        
        if($_POST['Action']=='DeleteComment'){
        	if(!empty($_POST['commentID'])){
        		$objBankAccount = new BankAccount();
        		$objBankAccount->DeleteComment((int) $_POST['commentID'],(int) $_POST['masterCommentID']);
        		$comments = str_replace('##'.$_POST['commentID'],'', $_POST['MultiComment']);
        		if($_POST['invoice_type']=='sales'){
        			$objBankAccount->updateSalesInvoiceComment($comments, $_POST['order_id']);
        		}else if($_POST['invoice_type']=='purchases'){
        			$objBankAccount->updatePurchasesInvoiceComment($comments, $_POST['order_id']);
        		}
        		echo 1;
        	}else{
        		echo 0;
        	}
        	exit;
        }

	 
        // ali 3 july 2018//
        if($_POST['action']=='ShippingAccountCustomer'){
            $objCustomer = new Customer();
            $arryShipAccount=$objCustomer->ListCustShipAccount($_POST['Type'],$_POST['CustID']); 
		echo "<option>--- Select ---</option>";
		foreach($arryShipAccount as $key=>$values){
		    $sel = ($values['defaultVal']==1)?("selected"):(""); 
		    echo "<option value='".$values['api_account_number']."' ".$sel.">".$values['api_account_number']."</option>";
		    
		}
		echo "<option value='Add New'>Add New</option>";
        }
        // ali 3 july 2018//

        //*********************************************************************************************


?>
