<?
class transaction extends dbClass
{
		//constructor
		function transaction()
		{
			$this->dbClass();
		} 
		
		function  AddUpdateTransaction($arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$IPAddress = GetIPAddress();			
			$SessionID = session_id();

			(empty($BankCurrency))?($BankCurrency=""):("");  
			(empty($SuppCode))?($SuppCode=""):("");  
			(empty($CustID))?($CustID=""):("");  
			(empty($AccountID))?($AccountID=""):("");
			(empty($CreditID))?($CreditID=""):("");
			(empty($TransferFund))?($TransferFund=""):("");
			(empty($Description))?($Description=""):("");
			(empty($OverPaid))?($OverPaid=""):("");
			(empty($InvoiceID))?($InvoiceID=""):("");
			(empty($OrderID))?($OrderID=""):("");
			/********************/
			if(!empty($Amount)){				
				if($PaymentType=='Credit' || $PaymentType=='CreditAmount') $Amount=-$Amount;

				$ModuleCurrency = $BankCurrency;

				/********Get Module Currency****/
				if(empty($ModuleCurrency)){
					$ModuleSection = '';  
					if($Module=='AR'){
						if($PaymentType=='Invoice' || $PaymentType=='Credit'){
							$ModuleSection = 'S';  
						}else if($PaymentType=='Contra Invoice'){
							$ModuleSection = 'P';  
						}
					}else if($Module=='AP'){
						if($PaymentType=='Invoice' || $PaymentType=='Credit'){
							$ModuleSection = 'P';  
						}else if($PaymentType=='Contra Invoice'){
							$ModuleSection = 'S';  
						}
					}

					if($ModuleSection=='S' && $OrderID>0){
						$sqlinv ="select CustomerCurrency as ModuleCurrency from s_order where OrderID ='".$OrderID."' ";
						$arryModule = $this->query($sqlinv, 1);	
						$ModuleCurrency = $arryModule[0]["ModuleCurrency"];
					}else if($ModuleSection=='P' && $OrderID>0){
						$sqlinv ="select Currency as ModuleCurrency from p_order where OrderID ='".$OrderID."' ";
						$arryModule = $this->query($sqlinv, 1);	
						$ModuleCurrency = $arryModule[0]["ModuleCurrency"];
					} 
				}

				if($ConversionRate>0 && !empty($ConversionRate)){$pk=1;}else{$ConversionRate=1;}


				/*******************************/
				if(empty($OriginalAmount)) $OriginalAmount = $Amount;
				if((!empty($FromVendorPayment) || !empty($FromCashReceipt)) && $ModuleCurrency!=$Config['Currency'] && $ConversionRate>0 && $ConversionRate!=1){
					$Amount = round(GetConvertedAmount($ConversionRate, $Amount),2); 
					 
				}
				/*******************************/
				if($Method!='Check')$CheckNumber='';
			
				if(!empty($TrID)){				 
					$sql = "UPDATE f_transaction_data SET Amount = '".$Amount."', ModuleCurrency = '".$ModuleCurrency."'  where TrID='".$TrID."'";
					$this->query($sql, 0);
				}else{ 
				 	$sql = "INSERT INTO f_transaction_data SET Amount = '".$Amount."', OriginalAmount = '".$OriginalAmount."', ConversionRate = '".$ConversionRate."', CreatedDate='". $_SESSION['TodayDate']."', AdminID='". $_SESSION['AdminID']."' , AdminType='". $_SESSION['AdminType']."' , IPAddress='". $IPAddress."' ,SessionID='". $SessionID ."', PaymentType = '".$PaymentType."',Module = '".$Module."',CustID = '".$CustID."',SuppCode = '".$SuppCode."', AccountID = '".$AccountID."', InvoiceID = '".$InvoiceID."', CreditID = '".$CreditID."', OrderID = '".$OrderID."', ModuleCurrency = '".$ModuleCurrency."' ,Method = '".addslashes($Method)."',CheckNumber = '".addslashes($CheckNumber)."' ,TransferFund = '".addslashes($TransferFund)."' ,Description = '".addslashes($Description)."' ,OverPaid = '".addslashes($OverPaid)."' ";
					 
					$this->query($sql, 0);
					$TrID = $this->lastInsertId();
				}
		
				 
			}
			/********************/                          
                       
                        
			return $TrID;
                         
		}	             
                
                

		function RemoveSessionTransaction($Module){
			global $Config;
			$IPAddress = GetIPAddress();			
			$SessionID = session_id();
			$arryTime = explode(" ",$Config['TodayDate']);
			$Today = $arryTime[0];
			if(empty($Config['TransferFund'])) $Config['TransferFund']=0;


			$sql = "delete from f_transaction_data where Module='".$Module."' and SessionID='".$SessionID."' and IPAddress='".$IPAddress."' and TransactionID='0' and TransferFund='".$Config['TransferFund']."'"; 
			$this->query($sql,0);

			$sql2 = "delete from f_transaction_data where CreatedDate<'".$Today."' and TransactionID='0' and TransferFund='".$Config['TransferFund']."'"; 
			$this->query($sql2,0);

			/*********Track Last Session Login************/
			$strSQLQuery = "select SessionID from user_login where UserID='".$_SESSION['UserID']."' and UserType='".$_SESSION['AdminType']."' and LoginIP='".$IPAddress."' order by loginID desc limit 0,2"; 

			$arrLogin = $this->query($strSQLQuery, 1); 
			if(!empty($arrLogin[0]['SessionID']) && $arrLogin[1]['SessionID']){
				if($SessionID==$arrLogin[0]['SessionID']){
					$sql = "delete from f_transaction_data where Module='".$Module."' and SessionID='".$arrLogin[1]['SessionID']."' and IPAddress='".$IPAddress."' and TransactionID='0' and TransferFund='".$Config['TransferFund']."'"; 
					$this->query($sql,0);
				}
			}
			/*****************************/

			return true;

		}

		function ListSessionTransaction($Module,$TransactionID=0,$PaymentType){
			global $Config;
			 
			$IPAddress = GetIPAddress();			
			$SessionID = session_id();
			$strAddQuery = '';

			if(!empty($PaymentType)) $strAddQuery .= " and t.PaymentType='".$PaymentType."' ";
			if($TransactionID!=''){
				$strAddQuery .= " and ( t.TransactionID in (".$TransactionID.") OR (t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' and t.TransactionID='0' )) ";
			}else{
				$strAddQuery .= " and t.TransactionID='0' and t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' ";
			}

			if(!empty($Module) && empty($TransactionID)) $strAddQuery .= " and t.Module='".$Module."' ";			

			if(empty($Config['TransferFund'])) $Config['TransferFund']=0;
 

			 $strSQLQuery = "select distinct(t.TrID), t.*,o.InvoiceDate,o.InvoiceEntry,o.CustCode, o.SaleID, o.TotalInvoiceAmount, o.CustomerCurrency, o.TotalAmount, p.TotalAmount as VendorTotalAmount, p.PostedDate,p.InvoiceEntry as PInvoiceEntry, p.ExpenseID,p.PurchaseID, p.Currency, b.RangeFrom, b.RangeTo, b.AccountNumber, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName from f_transaction_data t left outer join s_order o on (t.OrderID=o.OrderID and t.CustID=o.CustID and t.OrderID>'0') left outer join p_order p on (t.OrderID=p.OrderID and t.SuppCode=p.SuppCode and t.OrderID>'0') left outer join f_account b on b.BankAccountID = t.AccountID left outer join s_customers c on t.CustID=c.Cid left outer join p_supplier s on  t.SuppCode =  s.SuppCode where 1 ".$strAddQuery." and t.Deleted='0' and t.TransferFund='".$Config['TransferFund']."'  order by TrID Asc"; 

			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		

		}


		function getDeletedCreditAmount($Module,$TransactionID=0,$PaymentType){
			global $Config;
			 
			$IPAddress = GetIPAddress();			
			$SessionID = session_id();
			if(!empty($PaymentType)) $strAddQuery .= " and t.PaymentType='".$PaymentType."' ";
			if($TransactionID!=''){
				$strAddQuery .= " and ( t.TransactionID in (".$TransactionID.") OR (t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' and t.TransactionID='0' )) ";
			}else{
				$strAddQuery .= " and t.TransactionID='0' and t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' ";
			}

			if(!empty($Module)) $strAddQuery .= " and t.Module='".$Module."' ";			

			 $strSQLQuery = "select t.Amount from f_transaction_data t left outer join s_customers c on t.CustID=c.Cid where 1 ".$strAddQuery." and t.Deleted='1' order by TrID Asc"; 

			$arryRow = $this->query($strSQLQuery, 1);
                	if(!empty($arryRow[0]['Amount'])){
				return -$arryRow[0]['Amount'];	
			}
                	

		}

		function CheckGlTransaction($TransactionID,$CustID,$AccountID){
			global $Config;
			$IPAddress = GetIPAddress();			
			$SessionID = session_id();
			$strAddQuery .= " and t.PaymentType='GL' ";
			if($TransactionID!=''){
				$strAddQuery .= " and (t.TransactionID in (".$TransactionID.") or (t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' and t.TransactionID='0' )) ";
			}else{
				$strAddQuery .= " and t.TransactionID='0' and t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' ";
			}			

			$strSQLQuery = "select t.TrID from f_transaction_data t where CustID='".$CustID."' and AccountID='".$AccountID."' ".$strAddQuery." and t.Deleted='0' order by TrID Asc"; 

			$arrTR = $this->query($strSQLQuery, 1); 	
			if($arrTR[0]['TrID']>0){
				return true;
			}	

		}

		function CheckGlTransactionAP($TransactionID,$SuppCode,$AccountID){
			global $Config;
			$IPAddress = GetIPAddress();			
			$SessionID = session_id();
			$strAddQuery .= " and t.PaymentType='GL' ";
			if($TransactionID!=''){
				$strAddQuery .= " and (t.TransactionID in (".$TransactionID.") or (t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' and t.TransactionID='0' )) ";
			}else{
				$strAddQuery .= " and t.TransactionID='0' and t.SessionID='".$SessionID."' and t.IPAddress='".$IPAddress."' ";
			}			

			$strSQLQuery = "select t.TrID from f_transaction_data t where SuppCode='".$SuppCode."' and AccountID='".$AccountID."' ".$strAddQuery." and t.Deleted='0' order by TrID Asc"; 

			$arrTR = $this->query($strSQLQuery, 1); 	
			if($arrTR[0]['TrID']>0){
				return true;
			}	

		}

 



		function CheckTransaction($arryDetails){
			extract($arryDetails);	
			$strAddQuery='';					
			if(empty($TransactionID)) $TransactionID=0;
			if(!empty($CustID)) $strAddQuery .= " and t.CustID='".$CustID."' ";
			if(!empty($SuppCode)) $strAddQuery .= " and t.SuppCode='".$SuppCode."' ";

			$strSQLQuery = "select t.TrID from f_transaction_data t where t.PaymentType='".$PaymentType."' and Module='".$Module."' and OrderID='".$OrderID."' and t.TransactionID='".$TransactionID."' ".$strAddQuery." and t.Deleted='0' order by TrID Asc"; 
			//echo $strSQLQuery;exit;
			$arrTR = $this->query($strSQLQuery, 1); 	
			if(!empty($arrTR[0]['TrID'])){
				return true;
			}	

		}

	

		function isTransactionDataExist($TransactionID){
			
			$strSQLQuery = "select t.TrID from f_transaction_data t where TransactionID='".$TransactionID."' limit 0,1"; 
			$arrTR = $this->query($strSQLQuery, 1); 	
			if(!empty($arrTR[0]['TrID'])){
				return true;
			}else{
				return false;
			}						

		}

		function RemoveTransactionByID($TrID){	
			if($TrID>0){
				$strSQLQuery = "SELECT t.TransactionID from f_transaction_data t where t.TrID = '".trim($TrID)."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if(!empty($arryRow[0]['TransactionID'])){
					$sql = "update f_transaction_data set Deleted = '1' WHERE TrID ='".$TrID."' ";
					$this->query($sql, 0);  
				}else{
					$sql = "delete from f_transaction_data where TrID='".$TrID."' "; 
					$this->query($sql,0);
				}
				
			}
			return true;

		}


		function ResetDeletedFlag($TransactionID){	
			if($TransactionID>0){		
				$sql = "update f_transaction_data set Deleted = '0' WHERE TransactionID ='".$TransactionID."' ";
				$this->query($sql, 0);  				
			}
			return true;

		}

		

		/*********************************/
		/*********************************/
		function  addReceiptTransaction($arryDetails)
		{
			global $Config;
			
			$objBankAccount = new BankAccount();
			$objSale = new sale();
			$ipaddress = GetIPAddress();

			if($arryDetails[0]['AutoReceipt']>0){ //Auto Receipt				
				$arrySessTransaction = $arryDetails;
				extract($arryDetails[0]);
				
				$total_saved_payment = $Amount;
				$ReceivedAmount  = $Amount;
				$CustomerName = $CustID;
				//$ReferenceNo = $CustomerPO; //Need to pick InvoiceID			
				$Date = $PostToGLDate;//$InvoiceDate;				
				$Comment = $InvoiceComment;
				//$Method = $PaymentMethod;				 
				if($arryDetails[0]['AutoReceipt']==1){
					$AddPaymentSql = " ,PostToGL = 'Yes',PostToGLDate='".$PostToGLDate."'";
				}
			}else{  //Cash Receipt
				extract($arryDetails);
				$arrySessTransaction = $this->ListSessionTransaction('AR',$TransactionID,'Invoice');
				$AddPaymentSql = '';
				$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];
			}
			//echo '<pre>'; echo $$ModuleCurrency; print_r($arrySessTransaction);exit;			
			$totalNum = sizeof($arrySessTransaction);
			
			/*******************/
			$EntryType = 'Invoice';
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}		
						
			/********************/
			if($total_saved_payment!='' && $ReceivedAmount!='' ){
				/********************/
				$addsql = " SET  CustID = '".$CustomerName."', CustCode = '".$CustCode."',TotalAmount = ENCODE('".$total_saved_payment."','".$Config['EncryptKey']."'),  AccountID = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."', OriginalAmount=ENCODE('".$TotalOriginalAmount."','".$Config['EncryptKey']."'), ModuleCurrency='".$ModuleCurrency."' ";
				if($TransactionID>0){
					$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
					$this->query($sql, 0);					
				}else{
				 	$sql = "INSERT INTO f_transaction ".$addsql." , CreatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', OrderSource = '".$OrderSource."' ".$AddPaymentSql;		
					
					$this->query($sql, 0);
					$TransactionID = $this->lastInsertId();	

					/****/
					$ReceiptID = 'CSH000'.$TransactionID;
					$sqlr = "UPDATE f_transaction set ReceiptID='".$ReceiptID."' where TransactionID='".$TransactionID."'";
					$this->query($sqlr, 1);					
				}
		

			/********************/						
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AR',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	


                          foreach($arrySessTransaction as $key=>$values){
	
				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['InvoiceID']);
				
				
		
                            if($values['Amount'] !=''){                                
				 /*****Income********/				
	                       $strSQLQuery = "INSERT INTO f_income SET  InvoiceID='".$values['InvoiceID']."', Amount = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), TotalAmount = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), BankAccount = '".$PaidTo."', ReceivedFrom = '".$CustomerName."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentMethod= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',  EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$AccountReceivable."',CreatedDate='".$Config['TodayDate']."', Flag ='1',IPAddress='".$ipaddress."' ";
	                        $this->query($strSQLQuery, 0);	
	                        $incomeID = $this->lastInsertId();				
 				/*****Debit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$TransactionID."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."', SaleID = '".$values['SaleID']."', InvoiceID='".$values['InvoiceID']."', DebitAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$AddPaymentSql.$BankCurrencySql;
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."', CreditAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountReceivable."', IncomeID = '".$incomeID."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' " . $AddPaymentSql;
                                $this->query($strSQLQuery, 0);
				/*****Update IncomeID********/				
	                        $strSQLQuery = "update f_income SET PID='".$PID."' where IncomeID = '".$incomeID."'";
	                        $this->query($strSQLQuery, 0);				
				/*****Update TransactionID********/	
				if($values['TrID']>0){
					$strSQuery = "update f_transaction_data SET TransactionID='".$TransactionID."' where TrID = '".$values['TrID']."'";
		                	$this->query($strSQuery, 0);
				}				
				/*****Update Sales Status********/
				$arryStatusUpdate["OrderID"] = $values['OrderID'];
				$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
				$arryStatusUpdate["SaleID"] = $values["SaleID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];
				$arryStatusUpdate["TotalInvoiceAmount"] = $values["TotalInvoiceAmount"];
				$arryStatusUpdate["TotalOrderAmount"] = $values["TotalAmount"];
				$this->UpdateSalesInvoiceStatus($arryStatusUpdate);
							
				/*******************************/	

                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}

		/*********************************/
		/*********************************/
		function  addGlTransaction($transaction_id,$arryDetails)
		{
 
			global $Config;
			extract($arryDetails);		
			$objBankAccount = new BankAccount();	
			$ipaddress = GetIPAddress();
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}

			$arryInvTransaction = $this->ListSessionTransaction('AR',$transaction_id,'Invoice');
			$totalInvoice = sizeof($arryInvTransaction);

			$arrySessTransaction = $this->ListSessionTransaction('AR',$TransactionID,'GL');

			//echo '<pre>';print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);
			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];			
			/********************/			
    			if($totalNum>0 && $total_saved_payment!='' && $ReceivedAmount!=''){
		 

			if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}
			
			/********************/				 		
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AR',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	
		


                          foreach($arrySessTransaction as $key=>$values){
				 	

				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):('GL: '.$values['AccountNumber']);

		
                            if($values['Amount'] != ''){
				$Amount = $values['Amount'];
				/*******Change negative to positive for Expense & Other Expense Account*******
				if($Amount<0 && ($values['RangeFrom']=='6000' || $values['RangeFrom']=='8000')){
					$Amount = str_replace("-","",$Amount); 
				}
				/*****************/		
				 
				/*if($values['RangeFrom']=='2000' || $values['RangeFrom']=='3000' || $values['RangeFrom']=='4000' || $values['RangeFrom']=='7000'){
					$DebitAccountID = $PaidTo;
					$CreditAccountID = $values['AccountID'];				
				}else{
					$DebitAccountID = $values['AccountID'];
					$CreditAccountID = $PaidTo;
				}*/


				/*if($totalInvoice>0){
					$DebitAccountID = $values['AccountID'];
					$CreditAccountID = $PaidTo;
					$AddDebitSql = '';
					$AddCreditSql = $BankCurrencySql;
				}else{
					$DebitAccountID = $PaidTo;
					$CreditAccountID = $values['AccountID'];
					$AddDebitSql = $BankCurrencySql;
					$AddCreditSql = '';
				}*/

				/*$DebitAccountID = $PaidTo;
				$CreditAccountID = $values['AccountID'];
				$AddDebitSql = $BankCurrencySql;
				$AddCreditSql = '';*/


				if($Amount<0){
					$Amount = str_replace("-","",$Amount);
					$DebitAccountID = $values['AccountID'];
					$CreditAccountID = $PaidTo;
					$AddDebitSql = '';
					$AddCreditSql = $BankCurrencySql;
				}else{
					$DebitAccountID = $PaidTo;
					$CreditAccountID = $values['AccountID'];
					$AddDebitSql = $BankCurrencySql;
					$AddCreditSql = '';
				}



				

 
	
 				/*****Debit*****/
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$transaction_id."', ConversionRate = '".$values['ConversionRate']."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  DebitAmnt = ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccountID."',  GLID = '".$values['AccountID']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D'  ".$AddDebitSql;			
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  CreditAmnt = ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccountID."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C'  ".$AddCreditSql;
                                $this->query($strSQLQuery, 0);	

				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);								
				/*******************************/	
				
                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}

		/*********************************/
		/*********************************/
		function  addGlAPTransaction($transaction_id,$arryDetails)
		{
 
			global $Config;
			extract($arryDetails);	
			$objBankAccount=new BankAccount();		
			$ipaddress = GetIPAddress();
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}

			$arryInvTransaction = $this->ListSessionTransaction('AP',$transaction_id,'Invoice');
			$totalInvoice = sizeof($arryInvTransaction);

			$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'GL');

			//echo '<pre>';print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);			
			/********************/			
    			if($totalNum>0 && $total_saved_payment!='' && $PaidAmount!=''){


			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];

if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}

			/********************/				 		
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	


                          foreach($arrySessTransaction as $key=>$values){
				 	

				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):('GL: '.$values['AccountNumber']);

		
                            if($values['Amount'] != ''){
				$Amount = $values['Amount'];
				


				/*if($totalInvoice>0){
					$DebitAccountID = $PaidFrom; 
					$CreditAccountID = $values['AccountID'];
				}else{
					$DebitAccountID = $values['AccountID'];
					$CreditAccountID =  $PaidFrom; 
				}*/


				$DebitAccountID = $values['AccountID'];
				$CreditAccountID =  $PaidFrom; 
							
	
 				/*****Debit*****/
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$transaction_id."', ConversionRate = '".$values['ConversionRate']."',  SuppCode = '".$values['SuppCode']."',  DebitAmnt = ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccountID."',  GLID = '".$values['AccountID']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D'";			
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  CreditAmnt = ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), SuppCode = '".$values['SuppCode']."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccountID."',   ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$BankCurrencySql;
                                $this->query($strSQLQuery, 0);	

				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);								
				/*******************************/	
				
                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}

/*********************************/
		/*********************************/
		function  addGlAPTransfer($transaction_id,$arryDetails)
		{
 
			global $Config;
			extract($arryDetails);	
			$objBankAccount=new BankAccount();		
			$ipaddress = GetIPAddress();
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}

			$arryInvTransaction = $this->ListSessionTransaction('AP',$transaction_id,'Invoice');
			$totalInvoice = sizeof($arryInvTransaction);

			$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'GL');

			//echo '<pre>';print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);			
			/********************/			
    			if($totalNum>0 && $total_saved_payment!='' && $PaidAmount!=''){


			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];

if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}

			/********************/				 		
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	


                          foreach($arrySessTransaction as $key=>$values){
				 	

				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):('GL: '.$values['AccountNumber']);

		
                            if($values['Amount'] != ''){
				$Amount = $values['Amount'];
				


				/*if($totalInvoice>0){
					$DebitAccountID = $PaidFrom; 
					$CreditAccountID = $values['AccountID'];
				}else{
					$DebitAccountID = $values['AccountID'];
					$CreditAccountID =  $PaidFrom; 
				}*/


				$DebitAccountID = $values['AccountID'];
				//$CreditAccountID =  $PaidFrom; 
				$CreditAccountID =  $AccountPayable;
							
	
 				/*****Debit*****/
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$transaction_id."', ConversionRate = '".$values['ConversionRate']."',  SuppCode = '".$values['SuppCode']."',  DebitAmnt = ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccountID."',  GLID = '".$values['AccountID']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D'";			
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  CreditAmnt = ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), SuppCode = '".$values['SuppCode']."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccountID."',   ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$BankCurrencySql;
                                $this->query($strSQLQuery, 0);	

				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);								
				/*******************************/	
				
                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}
	/*********************************/
	/*********************************/
	function  addCreditTransaction($transaction_id,$arryDetails){

		global $Config;
		
		$objBankAccount = new BankAccount();
		$objSale = new sale();
		$ipaddress = GetIPAddress();			
		
		if($arryDetails[0]['AutoReceipt']>0){ //Auto Receipt				
			$arrySessTransaction = $arryDetails;
			extract($arryDetails[0]);
			
			$total_saved_payment = $Amount;
			$ReceivedAmount  = $Amount;
			$CustomerName = $CustID;
			//$ReferenceNo = $CustomerPO; //Need to pick InvoiceID			
			$Date = $PostToGLDate;//$InvoiceDate;				
			$Comment = $InvoiceComment;
			$Method = $PaymentMethod;
			if($arryDetails[0]['AutoReceipt']==1){
				$AddPaymentSql = " ,PostToGL = 'Yes',PostToGLDate='".$PostToGLDate."'";
			}
		}else{  //Cash Receipt
			extract($arryDetails);
			$arrySessTransaction = $this->ListSessionTransaction('AR',$TransactionID,'Credit');
			$AddPaymentSql = '';
			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];
		}
		
		//echo '<pre>'; print_r($arrySessTransaction);exit;
		$totalNum = sizeof($arrySessTransaction);			
		/********************/
		if($totalNum>0 && $total_saved_payment!='' && $ReceivedAmount!=''){
			
			if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}	


	
			/********************/				 		
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AR',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	
		
			
                          foreach($arrySessTransaction as $key=>$values){
	
				if(!empty($ReferenceNo)){
					$ReferenceNoVal = $ReferenceNo;
				}else if($values['OverPaid']=='1'){	
					$ReferenceNoVal = $values['InvoiceID'];
				}else{	
					$ReferenceNoVal = $values['CreditID'];
				}

		
		
                          if($values['Amount'] != ''){                        
				 				
 				/*****Debit Payment*****/
                                 $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$transaction_id."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  CreditID='".$values['CreditID']."', DebitAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."', OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$AddPaymentSql.$BankCurrencySql;
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."' , ConversionRate = '".$values['ConversionRate']."',  CreditAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountReceivable."', IncomeID = '".$incomeID."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."', OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$AddPaymentSql;

                                $this->query($strSQLQuery, 0);							
				/*****Update TransactionID********/
				if($transaction_id>0){	
					$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		               	   	$this->query($strSQuery, 0);
				}				
				/*****Update Credit Status********/	
				$arryStatusUpdate["OrderID"] = $values['OrderID'];				
				$arryStatusUpdate["CreditID"] = $values["CreditID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];	
				$arryStatusUpdate["TotalAmount"] = $values["TotalAmount"];
				$this->UpdateCreditMemoStatus($arryStatusUpdate);		 			
				/*******************************/	

                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}


	/*********************************/
	/*********************************/

	function  addReceiptContraTransaction($arryDetails){

		global $Config;
		$objBankAccount = new BankAccount();
		extract($arryDetails);
		$ipaddress = GetIPAddress();
		$EntryType = 'Invoice';
		if($Method == "Check"){
			$CheckBankName = $CheckBankName;
			$CheckFormat = $CheckFormat;
		}else{
			$CheckBankName = '';
			$CheckFormat = '';
		}

		$arrySessTransaction = $this->ListSessionTransaction('AR',$TransactionID,'Contra Invoice');
		//print_r($arrySessTransaction);exit;
		$totalNum = sizeof($arrySessTransaction);
		$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];			
		/********************/		
		if($totalNum>0 && $total_saved_payment!='' && $ReceivedAmount!=''){
		
			  $addsql = "  SET  SuppCode = '".$SuppCode."',TotalAmount = ENCODE('".$total_saved_payment."','".$Config['EncryptKey']."'),  AccountID = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',  EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."' , OriginalAmount=ENCODE('".$TotalOriginalAmount."','".$Config['EncryptKey']."'), ModuleCurrency='".$ModuleCurrency."' ";

			if($ContraTransactionID>0){
				$TransactionID = $ContraTransactionID;
				$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";

				$this->query($sql, 0);
			}else{
			 	$sql = "INSERT INTO f_transaction ".$addsql." ,  ContraID = '".$ContraID."', CreatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
				$this->query($sql, 0);
				$TransactionID = $this->lastInsertId();


				/****/
				$ReceiptID = 'PV000'.$TransactionID;
				$sqlr = "UPDATE f_transaction set ReceiptID='".$ReceiptID."' where TransactionID='".$TransactionID."'";
				$this->query($sqlr, 1);	



			}

		}
		/********************/

              /********************/		 		
		if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
			$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
			$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
		}			
                /********************/	        

 
	
		$TotalContraAmount = 0;  
		$TotalContraOriginal = 0;  
         	foreach($arrySessTransaction as $key=>$values){				
                    if($values['Amount'] !=''){      
                     
                      		$TotalContraAmount += $values['Amount'];
				$TotalContraOriginal += $values['OriginalAmount'];

			 	/*****Expense********/				
                                $strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$values['InvoiceID']."', OrderID='".$values['OrderID']."', Amount = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), BankAccount = '".$PaidTo."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceCoNo)."', PaymentMethod= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '".$Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$AccountPayable."', CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";				
                                $this->query($strSQLQuery, 0);    
                                $ExpenseID = $this->lastInsertId();    
                                /*****Credit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$TransactionID."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."', PurchaseID = '".$values['PurchaseID']."', InvoiceID='".$values['InvoiceID']."', CreditAmnt = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceCoNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckNumber= '".addslashes($values['CheckNumber'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."', OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$BankCurrencySql;
				
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                /*****Debit Payment*****/
                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."', DebitAmnt = ENCODE('".$values['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ApContraAccount."', ExpenseID = '".$ExpenseID."', SuppCode = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceCoNo)."', Method= '".addslashes($values['Method'])."', CheckNumber= '".addslashes($values['CheckNumber'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ";				
                                $this->query($strSQLQueryPay, 0);
                                /*****Update ExpenseID********/
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0); 
				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$TransactionID."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);
				/*****Update Purchase Status********/
				$arryStatusUpdate["OrderID"] = $values["OrderID"];
				$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];						 
				$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
				$this->UpdatePoInvoiceStatus($arryStatusUpdate);				 	
				/**********************************/   
                          }
                        
                        }

		   /******Update Total Amount 3July PK******/
		   $TotalContraAmount = round($TotalContraAmount,2);
		   $TotalContraOriginal = round($TotalContraOriginal,2);

		  $TotalMainAmount = round(($total_saved_payment - $TotalContraAmount),2);
		   $TotalMainOriginal = round(($TotalOriginalAmount - $TotalContraOriginal),2);

		   $sqlm = "UPDATE f_transaction set TotalAmount = ENCODE('".$TotalMainAmount."','".$Config['EncryptKey']."'), OriginalAmount = ENCODE('".$TotalMainOriginal."','".$Config['EncryptKey']."') where TransactionID='".$ContraID."'"; //main
		   $this->query($sqlm, 1);


		   $sqlc = "UPDATE f_transaction set TotalAmount = ENCODE('".$TotalContraAmount."','".$Config['EncryptKey']."'), OriginalAmount = ENCODE('".$TotalContraOriginal."','".$Config['EncryptKey']."') where TransactionID='".$TransactionID."'"; //contra
		   $this->query($sqlc, 1);
		   /******************************/
                        
                  return $TransactionID;      
                       
        }

	/*********************************/
	/*********************************/

	function  ListOpenARCreditNote($arryDetails)
	{
                global $Config;
		extract($arryDetails);

		$arryTime = explode(" ",$_SESSION['TodayDate']);
		$CurrentDate = $arryTime[0];

		$strAddQuery = " where o.CustCode = '".$CustCode."' and o.Module='Credit' and OrderPaid='0' "; //and OverPaid='0'
		
		/*$where1 = "  o.PostToGL='1' and o.CreditID != '' and o.Status in ('Open','Part Applied') and CASE WHEN o.ClosedDate>0 THEN  o.ClosedDate>='".$CurrentDate."' ELSE 1 END = 1 ";*/

		$where1 = "  o.PostToGL='1' and o.CreditID != '' and o.Status in ('Open','Part Applied') ";

		if(!empty($BankCurrency)){
                   $strAddQuery .= " and o.CustomerCurrency = '".$BankCurrency."'  ";
                }

                if(!empty($CreditIDS)){
                   $strAddQuery .= " and ( o.CreditID in (".$CreditIDS.") or (".$where1.") ) ";
		   $groupby = ' group by o.CreditID' ; 
                }else{
		   $strAddQuery .= " and ".$where1 ;	
			$groupby = '';
		}
		
		if(!empty($ExcludeCreditIDs)){
                   $strAddQuery .= " and o.CreditID not in (".$ExcludeCreditIDs.")  ";
                }
	
		$strAddQuery .= $groupby ;
		$strAddQuery .= " order by o.PostedDate desc, o.OrderID desc";
	

		$strSQLQuery = "select (SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) FROM f_payments p WHERE p.CreditID = o.CreditID and p.PaymentType='Sales' and p.CreditID!='') AS receivedAmntCr, (SELECT SUM(tr.OriginalAmount) FROM f_transaction_data tr WHERE tr.CreditID = o.CreditID and tr.Module='AR' and tr.PaymentType='Credit' and tr.Voided='0' and tr.CreditID!='') AS receivedAmntTr, o.PostedDate,o.CreditID, o.OverPaid, o.InvoiceID, o.OrderID, o.CustCode,o.CustID, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency from s_order o ".$strAddQuery;
	
		///echo "=>".$strSQLQuery; 
		return $this->query($strSQLQuery, 1);		
			
	}
	
	function  ListOpenAPCreditNote($arryDetails)
	{
                global $Config;
		extract($arryDetails);

		$arryTime = explode(" ",$_SESSION['TodayDate']);
		$CurrentDate = $arryTime[0];

		$strAddQuery = " where o.SuppCode = '".$SuppCode."' and o.Module='Credit' "; // and o.OverPaid='0'
		if(!empty($BankCurrency)){
                   $strAddQuery .= " and o.Currency = '".$BankCurrency."'  ";
                }

		/*$where1 = "  o.PostToGL='1' and o.CreditID != '' and o.Status in ('Open','Part Applied') and CASE WHEN o.ClosedDate>0 THEN  o.ClosedDate>='".$CurrentDate."' ELSE 1 END = 1 ";*/

		$where1 = "  o.PostToGL='1' and o.CreditID != '' and o.Status in ('Open','Part Applied') ";


                if(!empty($CreditIDS)){
                   $strAddQuery .= " and ( o.CreditID in (".$CreditIDS.") or (".$where1.") ) ";
		   $groupby = ' group by o.CreditID' ; 
                }else{
		   $strAddQuery .= " and ".$where1 ;	
			$groupby='';
		}
		
		if(!empty($ExcludeCreditIDs)){
                   $strAddQuery .= " and o.CreditID not in (".$ExcludeCreditIDs.")  ";
                }
	
		$strAddQuery .= $groupby ;
		$strAddQuery .= " order by o.PostedDate desc, o.OrderID desc";
	

		$strSQLQuery = "select (SELECT SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) FROM f_payments p WHERE p.CreditID = o.CreditID and p.PaymentType='Purchase' and p.CreditID!='') AS paidAmntCr, (SELECT SUM(tr.OriginalAmount) FROM f_transaction_data tr WHERE tr.CreditID = o.CreditID and tr.Module='AP' and tr.PaymentType='Credit'  and tr.Voided='0'  and tr.CreditID!='') AS paidAmntTr, o.PostedDate,o.CreditID, o.InvoiceID, o.OverPaid, o.OrderID, o.SuppCode,   o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency from p_order o ".$strAddQuery;
	
		//echo "=>".$strSQLQuery; 
		return $this->query($strSQLQuery, 1);		
			
	}

	/********************************************************************/
	function ARCreditMemoPostToGL($OrderID,$arryPostData){
		global $Config;
		extract($arryPostData);		 
 
		if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		}    
		$Date = $PostToGLDate;
		$ipaddress = GetIPAddress(); 

		$strSQLQuery = "SELECT s.*, inv.OrderID as InvOrderID from s_order s left outer join s_order inv on (s.InvoiceID=inv.InvoiceID and inv.Module='Invoice' and s.InvoiceID!='') where s.OrderID = '".trim($OrderID)."' and s.PostToGL != '1' ";
		$arryRow = $this->query($strSQLQuery, 1);
		//echo '<pre>';print_r($arryRow);exit;
		$InvOrderID = $arryRow[0]['InvOrderID'];
		$TotalAmount = $arryRow[0]['TotalAmount'];
		$OriginalAmount = $TotalAmount ;
		$AccountID = $arryRow[0]['AccountID'];
		$EntryBy = $arryRow[0]['EntryBy']; //C for Cron
		$OrderSource = strtolower($arryRow[0]['OrderSource']);
		$PaymentType = 'Customer Credit Memo';
		if($TotalAmount>0 && $arryRow[0]['CustomerCurrency']!=$Config['Currency']){
			$ConversionRate=$arryRow[0]['ConversionRate'];		
		}
		if(empty($ConversionRate)) $ConversionRate=1;
	
			

 

		/**************************************/
		/**************************************/
		if(!empty($AccountReceivable) && !empty($SalesReturn) && $TotalAmount>0){
			/*****************/
				
			$TotalCost = 0;$TotalRevenue = 0;

			if(empty($AccountID) && $InvOrderID>0){ //Invoice must exist to calculate Total Cost
				// Get Cost of Goods and Revenenue
				$strSQL = "SELECT i.sku, i.qty, i.item_id, i.SerialNumbers, i.`Condition`,i.DropshipCheck  from s_order_item i where i.OrderID = '".trim($OrderID)."' "; //credit memo
				$arryItem = $this->query($strSQL, 1);
				

				foreach($arryItem as $values){	
					$ItemCost = 0; 
					 
					/***************/
					if($values['DropshipCheck']=='1'){ //dropship
						 $ItemCost = 0; 
					}else if(!empty($values['sku']) && !empty($values['Condition']) && empty($values['SerialNumbers'])){ //avgCost from invoice
						$strS = "SELECT avgCost from s_order_item  where OrderID = '".trim($InvOrderID)."' and `sku` = '".$values['sku']."' and `Condition`='".$values['Condition']."' and avgCost>'0' and parent_item_id='0' ";
						$arryInvItem = $this->query($strS, 1);
						$ItemCost = $arryInvItem[0]['avgCost'];
					}else if(!empty($values['sku']) && !empty($values['Condition']) && !empty($values['SerialNumbers'])){ //UnitCost from inv_serial_item	
						$SerialNumberArray = explode(",", $values['SerialNumbers']);
						$NumSL = sizeof($SerialNumberArray);						
						$TotalUnitCost=0;	
						foreach($SerialNumberArray as $Slno){	
							$SerialNo = trim($Slno);	
							if(!empty($SerialNo)){			
								$strS = "SELECT UnitCost FROM `inv_serial_item` WHERE `serialNumber` = '".$SerialNo."' AND `Sku` = '".$values['sku']."' AND `Condition`='".$values['Condition']."' and OrderID='".$InvOrderID."' ";
								$arrySerial = $this->query($strS, 1); 
						
								$TotalUnitCost += $arrySerial[0]['UnitCost'];
							}	
						}

						$ItemCost = round(($TotalUnitCost/$NumSL),2);					
					}
					/***************/
					$TotalCost += ($ItemCost*$values['qty']);
			
					/***Update Stock****/
					if($values['qty']>0){
						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$values['sku']. "' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);

						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$values['qty'] . "  where Sku='" .$values['sku']. "' ";
						$this->query($UpdateQtysql, 0);

					
					}
					/******************/
				}
			}
			
				/*****************/
				$taxAmnt = $arryRow[0]['taxAmnt'];  
				$Freight = $arryRow[0]['Freight']; 
				
				$ReStocking=0;
				if($arryRow[0]['ReSt'] == 1 && $arryRow[0]['ReStocking']>0) {
					$ReStocking = $arryRow[0]['ReStocking']; 
				}


				//$TDiscount = $arryRow[0]['TDiscount'];   
				$SubTotal = ($TotalAmount - $Freight - $taxAmnt) + $ReStocking;				
				$OriginalSubTotal = $SubTotal;
				$OriginalTotalCost = round($TotalCost,2);
				if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){				
					$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount); 
					$SubTotal = GetConvertedAmount($ConversionRate, $SubTotal);  
					$Freight = GetConvertedAmount($ConversionRate, $Freight);  
					$ReStocking = GetConvertedAmount($ConversionRate, $ReStocking);   
					//$TDiscount = $ConversionRate * $TDiscount;
					$taxAmnt = GetConvertedAmount($ConversionRate, $taxAmnt);
					$TotalCost = GetConvertedAmount($ConversionRate, $TotalCost);  
				}	
			
				$TotalCost = round($TotalCost,2);
				 

				$SalesReturnAmount = $TotalAmount;
				$ARAmount = $TotalAmount;
			
				 



				/**************************************/
				if($Config['TrackInventory']==1 && empty($AccountID)){//start TrackInventory
					 $SalesReturnAmount = $SubTotal;
					 $OriginalAmount = $OriginalSubTotal;					
					

					if($OriginalTotalCost>0){
						//Debit Total Cost to Inventory
						$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', CreditID='".$arryRow[0]['CreditID']."',   DebitAmnt = ENCODE('".$OriginalTotalCost."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAR."', ReferenceNo='".$arryRow[0]['CreditID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='D' ";
						$this->query($strSQLQuery, 1);	

						//Credit  Total Cost to Cost of goods					 
						$strSQLQueryCost = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',  CreditAmnt = ENCODE('".$OriginalTotalCost."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['CreditID']."', CreditID='".$arryRow[0]['CreditID']."', AccountID = '".$CostOfGoods."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."', OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='C'  ";  
						$this->query($strSQLQueryCost, 0); 
					}



					if($taxAmnt>0){ //Debit Tax
						$strSQLQ = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', CreditID='".$arryRow[0]['CreditID']."', DebitAmnt  = ENCODE('".$taxAmnt."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."', ReferenceNo='".$arryRow[0]['CreditID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."', OriginalAmount=ENCODE('".$arryRow[0]['taxAmnt']. "','".$Config['EncryptKey']."'), TransactionType='D' ";
						$this->query($strSQLQ, 1);
					}			
					if($Freight>0){  //Debit Freight
						$strSQLQuery2 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', CreditID='".$arryRow[0]['CreditID']."', DebitAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightAR."', ReferenceNo='".$arryRow[0]['CreditID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."', OriginalAmount=ENCODE('".$arryRow[0]['Freight']. "','".$Config['EncryptKey']."'), TransactionType='D' ";
						$this->query($strSQLQuery2, 1);
					}

					if($ReStocking>0){  //Credit ReStocking
						$strSQLQuery3 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', CreditID='".$arryRow[0]['CreditID']."', DebitAmnt  = ENCODE('0.00','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$ReStocking."','".$Config['EncryptKey']."'), AccountID = '".$ArRestocking."', ReferenceNo='".$arryRow[0]['CreditID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."', OriginalAmount=ENCODE('".$arryRow[0]['ReStocking']. "','".$Config['EncryptKey']."'), TransactionType='C' ";
						$this->query($strSQLQuery3, 1);
					}
					
					
				 
				}//end TrackInventory
				/**************************************/

				$DebitAccount = (!empty($AccountID))?($AccountID):($SalesReturn);
				if($DebitAccount>0 &&  $AccountReceivable>0){
				 //Debit Sales Return
				$strSQLQuerySales = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', DebitAmnt = ENCODE('".$SalesReturnAmount."', '".$Config['EncryptKey']."'),  CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['CreditID']."', CreditID='".$arryRow[0]['CreditID']."', AccountID = '".$DebitAccount."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."', OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D'"; 
				$this->query($strSQLQuerySales, 0);
				$PID = $this->lastInsertId();

				 //Credit AR
				$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$ARAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['CreditID']."', CreditID='".$arryRow[0]['CreditID']."',AccountID = '".$AccountReceivable."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."', OriginalAmount=ENCODE('".$arryRow[0]['TotalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C'";  
				$this->query($strSQLQueryPay, 0);
				}
				/**************************************/

			}
			/**************************************/
			/**************************************/
			
		 

			/************************/
			if($PID>0){
				/*******************/
				$CreateCashReceipt = 0;
				if($PosFlag==1 && $EntryBy=='C' && $OrderSource=='pos'){
					$CreateCashReceipt = 1;
				}
				if($CreateCashReceipt==1){
					$arryRow[0]['ConversionRate'] = $ConversionRate;
					$arryRow[0]['PostToGLDate'] = $PostToGLDate;		
					$this->CreateCashReceiptCredit($arryRow); 
					if($arryRow[0]['Fee']>0){
						$this->CreateGeneralEntryCredit($arryRow);

					}
				} 
				/*******************/

				$strSQLQuery = "update s_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."', PostToGLTime='".$Config['TodayDate']."' WHERE OrderID ='".$OrderID."' ";
				$this->query($strSQLQuery, 0); 
 
			}else{
				return $arryRow[0]['CreditID'];
			}
			/************************/
			
		}

	/***************************************************/	
    	function CreateCashReceiptCredit($arryRow){ 
	 	global $Config;
 
		$objConfigure=new configure();		
		$OrderSource = strtolower($arryRow[0]['OrderSource']);
 
		if($OrderSource=='pos'){
			$PaidTo = $objConfigure->getSettingVariable('AccountReceivable');
			$AccountReceivable = $objConfigure->getSettingVariable('PosAccount');
		}

		 
		//echo $PaidTo.'#'.$AccountReceivable;exit;
		

		if($PaidTo>0 && $AccountReceivable>0){
			$arryRow[0]['TotalAmount'] = -$arryRow[0]['TotalAmount'];//negative for credit memo
			$arryRow[0]['AutoReceipt'] = 1;	
			$arryRow[0]['PaidTo'] = $PaidTo;
			$arryRow[0]['PaymentMethod'] = $arryRow[0]['PaymentTerm']; 
			$arryRow[0]['Method'] = $arryRow[0]['PaymentTerm']; 
			$arryRow[0]['AccountReceivable'] = $AccountReceivable;
			$arryRow[0]['OriginalAmount'] = round($arryRow[0]['TotalAmount'],2);
			$arryRow[0]['TotalOriginalAmount'] = round($arryRow[0]['TotalAmount'],2);
			$arryRow[0]['ModuleCurrency'] = $arryRow[0]['CustomerCurrency'];
			$Amount = GetConvertedAmount($arryRow[0]['ConversionRate'], $arryRow[0]['TotalAmount']); 
			$arryRow[0]['Amount'] = round($Amount,2);
			/***********************/
			$arryRowData[0]['Module'] = 'AR';
			$arryRowData[0]['PaymentType'] = 'Credit';
			$arryRowData[0]['OriginalAmount'] = round($arryRow[0]['TotalAmount'],2);
			$arryRowData[0]['Amount'] = $arryRow[0]['Amount'];
			$arryRowData[0]['ConversionRate'] = $arryRow[0]['ConversionRate'];	
			$arryRowData[0]['CustID'] = $arryRow[0]['CustID'];
			$arryRowData[0]['CreditID'] = $arryRow[0]['CreditID'];
			$arryRowData[0]['OrderID'] = $arryRow[0]['OrderID'];
			$arryRowData[0]['Method'] = $arryRow[0]['PaymentTerm']; 
 
			#$arryRow[0]['TrID'] = $this->AddUpdateTransaction($arryRowData[0]);//not needed for credit memo	
			/***********************/
	 		$TransactionID = $this->addCreditTransaction('',$arryRow);  
		}
		return true;
	}


/***************************************************/	
	function CreateGeneralEntryCredit($arryRow){
		global $Config;		
	  	$objJournal = new journal();
		$objBankAccount = new BankAccount();
		$OrderSource = strtolower($arryRow[0]['OrderSource']);
		$ReferenceID = $arryRow[0]['SaleID'];
		$glDate = $arryRow[0]['PostToGLDate'];
		$Config['PostToGLDate'] = $glDate;
 
		if($OrderSource=='pos'){
			$AccountID1 = $objJournal->getSettingVariable('PosFee');
			$AccountID2 = $objJournal->getSettingVariable('PosAccount');
		}
		$AccDeatail1 = $objBankAccount->getAccountNameByID($AccountID1);
	
		# for Credit
		
		$AccDeatail2 = $objBankAccount->getAccountNameByID($AccountID2);

		if(!empty($AccDeatail1[0]['AccountNumber']) && !empty($AccDeatail2[0]['AccountNumber'])){
			$Fee = GetConvertedAmount($arryRow[0]['ConversionRate'], $arryRow[0]['Fee']); 
			$arryRow[0]['Fee'] = round($Fee,2);

			$arryDetails = array(
				'JournalMemo'=>$OrderSource.'-'.$arryRow[0]['CreditID'].'-'.$arryRow[0]['InvoiceID'],
				'TotalDebit'=>$arryRow[0]['Fee'],
				'TotalCredit'=>$arryRow[0]['Fee'],
				'NumLine'=>'2',
				'AccountID1'=>$AccountID1,
				'AccountID2'=>$AccountID2,
				'AccountName1'=>$AccDeatail1[0]['AccountName'].'['.$AccDeatail1[0]['AccountNumber'].']',
				'AccountName2'=>$AccDeatail2[0]['AccountName'].'['.$AccDeatail2[0]['AccountNumber'].']',
				'DebitAmnt1'=>'0.00',
				'DebitAmnt2'=>$arryRow[0]['Fee'],
				'CreditAmnt1'=>$arryRow[0]['Fee'],
				'CreditAmnt2'=>'0.00',
				'Comment1'=>$OrderSource,
				'Comment2'=>$OrderSource,
				'LocationID'=>1,
				'ReferenceID'=>$ReferenceID,
				'JournalType'=>'one_time',
				'JournalNo'=>'',
				'JournalDate'=>$glDate,
				'journalPrefix'=>$objJournal->getSettingVariable('JOURNAL_NO_PREFIX')
			);
		 
			$JournalID = $objJournal->addJournal($arryDetails,$journalPrefix);
			if(!empty($JournalID)){				
				$objJournal->AddUpdateJournalEntry($JournalID, $arryDetails);
				$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);
				//if($_GET['pk']){print_r($arryJournalEntry);}
				$objJournal->PostJournalEntryToGL($arryJournalEntry,$JournalID);
			}
		}
		return true;
	}




	/************************/
function APCreditMemoPostToGL($OrderID,$arryPostData){ //new
	global $Config;
	extract($arryPostData);
	
	if(empty($PostToGLDate)){
		$PostToGLDate=$Config['TodayDate'];
	}    
        $Date = $PostToGLDate;
	$ipaddress = GetIPAddress(); 
	
	$strSQLQuery = "SELECT p.*,p2.OrderType as InvOrderType,p2.OrderID as InvOrderID,p2.PaymentTerm as InvPaymentTerm,p2.CreditCardVendor as InvCreditCardVendor,p2.TotalAmount as InvTotalAmount from p_order p  left outer join p_order p2 on (p.InvoiceID=p2.InvoiceID and p2.Module='Invoice' and p.InvoiceID!='')  where p.OrderID = '".trim($OrderID)."' and p.Module='Credit' and p.PostToGL != '1' "; 	
	$arryRow = $this->query($strSQLQuery, 1);

	


	//echo '<pre>';print_r($arryRow);exit;		
	$TotalAmount = $arryRow[0]['TotalAmount'];
	$OriginalAmount = $TotalAmount;
	$AccountID = $arryRow[0]['AccountID'];
	$OrderType = $arryRow[0]['OrderType'];
	$InvOrderType = $arryRow[0]['InvOrderType'];
	$PaymentType = 'Vendor Credit Memo';
		 
	if($arryRow[0]['Currency']!=$Config['Currency']){				
		$ConversionRate = $arryRow[0]['ConversionRate'];
	} 
	if(empty($ConversionRate)) $ConversionRate=1;

		/**************************************/
		if(!empty($AccountPayable) && !empty($TotalAmount)){
			

			$Freight=0;				
			$OriginalFreight=0;
			$taxAmnt=0;
			$OriginalTax=0;
			$ReStocking=0; 
			$OriginalReStocking=0;
			/*****************/	
			if(!empty($AccountID)){ //GL Credit Memo
				$CreditAccount = $AccountID;

				$FreightExpense=0;
				$SalesTaxAccount=0;
				
			}else{ //Line Item Credit Memo

				if($InvOrderType=='Dropship'){
					$CreditAccount = $CostOfGoods;

					$FreightExpense=0;
					$SalesTaxAccount=0;
				}else{
					$CreditAccount = $InventoryAP;

					$Freight = $arryRow[0]['Freight'];			
					$OriginalFreight = $Freight;
					$taxAmnt = $arryRow[0]['taxAmnt'];
					$OriginalTax = $taxAmnt;

					
					if($arryRow[0]['Restocking'] == 1 && $arryRow[0]['Restocking_fee']>0) {
						$ReStocking = $arryRow[0]['Restocking_fee']; 
						$OriginalReStocking = $ReStocking;
					}


				}								
			}
			/*****************/			
			if($arryRow[0]['Currency']!=$Config['Currency']){
				$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount) ,2);
				$Freight = round(GetConvertedAmount($ConversionRate, $Freight),2);
				$ReStocking = round(GetConvertedAmount($ConversionRate, $ReStocking),2);
				$taxAmnt = round(GetConvertedAmount($ConversionRate, $taxAmnt),2);
			}
			/*****************/	
			$SubTotal = ($TotalAmount - $Freight - $taxAmnt) + $ReStocking;
			$OriginalSubTotal = ($OriginalAmount - $OriginalFreight - $OriginalTax) + $OriginalReStocking;

			if(!empty($CreditAccount)){
				//Debit Total to AP
				$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', DebitAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D'";
				$this->query($strSQLQueryPay, 0);
				$PID = $this->lastInsertId();

				//Debit Freight					
				if($ReStocking>0 && $ApRestocking>0){ 
					$strSQLQueryRe = "INSERT INTO f_payments SET  PID='".$PID."', ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."',  CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', DebitAmnt  = ENCODE('".$ReStocking."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ApRestocking."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalReStocking. "','".$Config['EncryptKey']."'), TransactionType='D'";			
					$this->query($strSQLQueryRe, 1);
				}


				//Credit Freight					
				if($Freight>0 && $FreightExpense>0){ 
					$strSQLQueryFr = "INSERT INTO f_payments SET  PID='".$PID."', ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."',  CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', CreditAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightExpense."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalFreight. "','".$Config['EncryptKey']."'), TransactionType='C'";			
					$this->query($strSQLQueryFr, 1);
				}

				//Credit Tax					
				if($taxAmnt>0 && $SalesTaxAccount>0){					
					$strSQLQueryT = "INSERT INTO f_payments SET  PID='".$PID."', ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."',  CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', CreditAmnt  = ENCODE('".$taxAmnt."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalTax. "','".$Config['EncryptKey']."'), TransactionType='C'";			
					$this->query($strSQLQueryT, 1);
				}

				//Credit  CreditAccount
				$strSQLQueryC = "INSERT INTO f_payments SET  PID='".$PID."', ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."',  CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', CreditAmnt  = ENCODE('".$SubTotal."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalSubTotal. "','".$Config['EncryptKey']."'), TransactionType='C'";			
				$this->query($strSQLQueryC, 1);
				 

				
			}

		}
		/**************************************/
		
	     
		

		/************************/
		if($PID>0){
			$strSQLQuery = "update p_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."' , PostToGLTime='".$Config['TodayDate']."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0); 


			 /**********Create Credit Memo for Credit Card Vendor************/
			if($arryRow[0]['InvOrderID']>0 && strtolower(trim($arryRow[0]['InvPaymentTerm']))=='credit card' && $arryRow[0]['InvCreditCardVendor']!='' && $TotalAmount>0 ){
				$this->CreditCardVendorCreditMemoGL($OrderID,$arryRow[0]['InvOrderID'],$Date,$TotalAmount);
			}
			/***************************/

 
			
		}else{
			return $arryRow[0]['CreditID'];
		}
		/************************/


		return true;
        	
        }


 function getSupplierName($SuppCode)
        {
                $strSQLQuery = "Select SuppID,UserName,CompanyName, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  from p_supplier s where SuppCode = '".mysql_real_escape_string($SuppCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
              
                $SupplierName = $arryRow[0]['VendorName'];
		return $SupplierName;
            
        }

/************************/

function CreditCardVendorCreditMemoGL($OrderIDCredit, $OrderID,$Date,$TotalAmount){
	extract($arryOrder);	
	global $Config;

	$strSQLQuery = "SELECT p.* from p_order p where p.OrderID = '".trim($OrderID)."' order by p.OrderID desc ";
	$arryRow = $this->query($strSQLQuery, 1);	
	
	$arryRow[0]['TotalAmount'] = $TotalAmount;
	 
	$objConfigure=new configure();
	$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
		
	if($TotalAmount>0 && $AccountPayable>0 && !empty($arryRow[0]["CreditCardVendor"])){	
		$VendorName =  $this->getSupplierName($arryRow[0]["CreditCardVendor"]);

		$arryRow[0]["OrderID"] = '';
		$arryRow[0]["AutoID"] = '';
		$arryRow[0]["Parent"] = $OrderIDCredit;
		$arryRow[0]["PaymentTerm"] = '';
		$arryRow[0]["OrderDate"] = '';	
		$arryRow[0]["OrderType"] = '';	
		$arryRow[0]["PurchaseID"] = '';	
		$arryRow[0]["QuoteID"] = '';	
		$arryRow[0]["Comment"] = $arryRow[0]['InvoiceID'];
		$arryRow[0]["InvoiceID"] = '';
		$arryRow[0]['EntryType'] = 'one_time';	
		$arryRow[0]['Module'] = 'Credit';	
		$arryRow[0]['Approved'] = '1';	
		$arryRow[0]['Status'] = 'Open';			
		$arryRow[0]["AccountID"] = $AccountPayable;
		$arryRow[0]["PostedDate"] = $Date;	
		$arryRow[0]["CustID"] = '';
		$arryRow[0]["CustCode"] = ''; 
		$arryRow[0]["SuppCode"] = $arryRow[0]["CreditCardVendor"];
		$arryRow[0]["CreditCardVendor"] = '';
		$arryRow[0]["SuppCompany"] = $VendorName;
		$arryRow[0]["PostToGL"] = '0';
		$arryRow[0]["OverPaid"] = '0';	
		$arryRow[0]["TotalInvoiceAmount"] = '';
  
		

		$NewOrderID = $order_id = $this->AddPurchaseForCredit($arryRow[0]); 
		
	}
	
	return true;
}

function AddPurchaseForCredit($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			$IPAddress = GetIPAddress();

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($PostedDate)) $PostedDate = $Config['TodayDate'];
			if(empty($ReceivedDate)) $ReceivedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
                       
			if($Currency != $Config['Currency']){  
				if($Module=='Invoice' || $Module=='Credit'){
					$CurrencyDate = $PostedDate;	
				}else{
					$CurrencyDate = $OrderDate;	
				}
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$CurrencyDate);
			}else{   
				$ConversionRate=1;
			} 
//trackb
if(is_array($TrackingNo)){
$TrackingNo =implode(':',$TrackingNo);
}
			$strSQLQuery = "insert into p_order(Module, ConversionRate, OrderType, OrderDate,  PurchaseID, QuoteID,ReceiptID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, TotalInvoiceAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate, CustCode, AccountID, PrepaidFreight, PrepaidVendor, PrepaidAmount, GenrateInvoice, ReceiptStatus, RefInvoiceID, ShippingMethodVal,IPAddress, freightTxSet, TrackingNo, CreditCardVendor, CreatedDate, Parent) values('".$Module."', '".$ConversionRate."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."','".$ReceiptID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$PostedDate."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."', '".addslashes($AccountID)."', '".addslashes($PrepaidFreight)."', '".addslashes($PrepaidVendor)."', '".addslashes($PrepaidAmount)."','".addslashes($GenrateInvoice)."','".$ReceiptStatus."','".$RefInvoiceID."' ,'".addslashes($ShippingMethodVal)."', '".addslashes($IPAddress)."', '".addslashes($freightTxSet)."', '".addslashes($TrackingNo)."', '".addslashes($CreditCardVendor)."' , '".$Config['TodayDate']."', '".$Parent."')";
			
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			/*if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}*/
			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order',$Module,$OrderID,$arryDetails[$ModuleID]);  

			return $OrderID;

		}

/************************/
function APCreditMemoPostToGLOld($OrderID,$arryPostData){ //old
	global $Config;
	extract($arryPostData);
	
	if(empty($PostToGLDate)){
		$PostToGLDate=$Config['TodayDate'];
	}    
        $Date = $PostToGLDate;
	$ipaddress = GetIPAddress(); 
	
	$strSQLQuery = "SELECT p.* from p_order p where p.OrderID = '".trim($OrderID)."'  ";
	$arryRow = $this->query($strSQLQuery, 1);	
	$TotalAmount = $arryRow[0]['TotalAmount'];
	$OriginalAmount = $TotalAmount;
	$AccountID = $arryRow[0]['AccountID'];
	$OrderType = $arryRow[0]['OrderType'];
	$PaymentType = 'Vendor Credit Memo';
	//echo '<pre>';print_r($arryRow);exit;

		 
		/**************************************/
		if(!empty($InventoryAP) && !empty($AccountPayable) && !empty($TotalAmount)){
			
			//$Freight = $arryRow[0]['Freight'] + $arryRow[0]['PrepaidAmount'];
			//$SubTotal = $TotalAmount - $Freight;

			if($arryRow[0]['Currency']!=$Config['Currency']){
				//$ConversionRate=CurrencyConvertor(1,$arryRow[0]['Currency'],$Config['Currency'],'AP',$Date);
				$ConversionRate = $arryRow[0]['ConversionRate'];

				$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount) ,2);
				//$SubTotal = round(GetConvertedAmount($ConversionRate, $SubTotal) ,2);
				//$Freight = round(GetConvertedAmount($ConversionRate, $Freight) ,2);
			}


			$CreditAccount = (!empty($AccountID))?($AccountID):($PurchaseReturn);

			//Credit Total to Purchase Return
			$strSQLQuery1 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."',  CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', CreditAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C'";			
			$this->query($strSQLQuery1, 1);
			$PID = $this->lastInsertId();

			
			
			if($Config['TrackInventory']==1 && empty($AccountID)){
				//Credit Total to Inventory 
				$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', CreditAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAP."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";			
				$this->query($strSQLQuery, 1);
				

				//Debit Total to COG 
				$strSQLQuery2 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."',  ReferenceNo='".$arryRow[0]['CreditID']."', CreditID='".$arryRow[0]['CreditID']."', DebitAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CostOfGoods."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D'";
				$this->query($strSQLQuery2, 1);
			}

			//Debit Total to AP
			$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', PID='".$PID."', DebitAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), CreditID='".$arryRow[0]['CreditID']."', ReferenceNo='".$arryRow[0]['CreditID']."', AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D'";
			$this->query($strSQLQueryPay, 0);

		}
		/**************************************/
		
	     


		/************************/
		if($PID>0){
			$strSQLQuery = "update p_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0);  
			
		}else{
			return $arryRow[0]['CreditID'];
		}
		/************************/


		return true;
        	
        }


	function  addCreditPaymentInformation($transaction_id, $arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
			$objBankAccount=new BankAccount();


			$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'Credit');
			//print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);
			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];

			if($totalNum>0 && $total_saved_payment!='' && $PaidAmount!=''){


			/********************/				 		
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	


			if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}


                       	     foreach($arrySessTransaction as $key=>$values){
                          
				 if($values['Amount'] != ''){ 
                              		 
                                         
				if(!empty($ReferenceNo)){
					$ReferenceNoVal = $ReferenceNo;
				}else if($values['OverPaid']=='1'){	
					$ReferenceNoVal = $values['InvoiceID'];
				}else{	
					$ReferenceNoVal = $values['CreditID'];
				}
                   
                            
                                $strSQLQuery = "INSERT INTO f_payments SET   TransactionID='".$transaction_id."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."', CreditID='".$values['CreditID']."', CreditAmnt = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$BankCurrencySql;
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                
                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."', DebitAmnt = ENCODE('".$values['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."',  SuppCode = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceNoVal)."', Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ";
                                $this->query($strSQLQueryPay, 0);

				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);				
			
				/*****Update Credit Status********/	
				$arryStatusUpdate["OrderID"] = $values["OrderID"];				
				$arryStatusUpdate["CreditID"] = $values["CreditID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];	
				$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
				$this->UpdateCreditMemoAPStatus($arryStatusUpdate);			
				/*******************************/
                                                            

                          }
                        
                        }
			}
                        
                        
                       return $TransactionID;

		}


	/****************************************/
	/****************************************/
	function  addPayVendorTransaction($arryDetails){
			global $Config;			
			$objBankAccount = new BankAccount();
			$ipaddress = GetIPAddress();

			/********************/
			if($arryDetails[0]['AutoReceipt']>0){ //Auto Receipt				
				$arrySessTransaction = $arryDetails;
				extract($arryDetails[0]);
				
				$total_saved_payment = $Amount;
				$PaidAmount  = $Amount;				
						
				$Date = $PostToGLDate; 
				$Comment = $InvoiceComment;
				$Method = $PaymentMethod;
				if($arryDetails[0]['AutoReceipt']==1){
					$AddPaymentSql = " ,PostToGL = 'Yes',PostToGLDate='".$PostToGLDate."' ";
				}
			}else{  //Vendor Payment Receipt
				extract($arryDetails);
				$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'Invoice');
				$AddPaymentSql = '';
				$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];
			}
                       	/********************/
			//echo $CheckNumber;exit;
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
				if($Voided==1 && $CheckNumber!=''){ //done below
					/*$sttSql = "update f_payments SET Voided='1',DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."') where CheckNumber = '".$CheckNumber."'";
                                $this->query($sttSql, 0);*/	
				}
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}
                       /********************/
			
			//echo '<pre>';print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);	
			/********************/
			if($total_saved_payment!='' && $PaidAmount!=''){
				 $addsql = " SET  SuppCode = '".$SuppCode."', TotalAmount = ENCODE('".$total_saved_payment."','".$Config['EncryptKey']."'),  AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."', OriginalAmount=ENCODE('".$TotalOriginalAmount."','".$Config['EncryptKey']."'), ModuleCurrency='".$ModuleCurrency."' , TransferOrderID='".$TransferOrderID."' , TransferSuppCode='".addslashes($TransferSuppCode)."' ";

				if($TransactionID>0){
					$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
		                        $this->query($sql, 0);
				}else{
				 	$sql = "INSERT INTO f_transaction ".$addsql." , CreatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ".$AddPaymentSql;
		                        $this->query($sql, 0);
		                        $TransactionID = $this->lastInsertId();

					/****/
					$ReceiptID = 'PV000'.$TransactionID;
					$sqlr = "UPDATE f_transaction set ReceiptID='".$ReceiptID."' where TransactionID='".$TransactionID."'";
					$this->query($sqlr, 1);	
				}
			}
			/********************/
			//echo $sql;exit;


			/********************/				 	
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."' ";
			}			
                        /********************/	

                        foreach($arrySessTransaction as $key=>$values){
                          if($values['Amount'] != '' ){ 
                               
				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['InvoiceID']);


                                 /*****Expense********/	
                                $strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$values['InvoiceID']."', OrderID='".$values['OrderID']."', Amount = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), BankAccount = '".$PaidFrom."', PaidTo = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentMethod= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '".$Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$AccountPayable."',CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);	
                                $ExpenseID = $this->lastInsertId();	
                                /*****Credit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET   TransactionID='".$TransactionID."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."', PurchaseID = '".$values['PurchaseID']."', InvoiceID='".$values['InvoiceID']."', CreditAmnt = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$AddPaymentSql.$BankCurrencySql;
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                
				/*****Debit Payment*****/
                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."', DebitAmnt = ENCODE('".$values['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ExpenseID = '".$ExpenseID."', SuppCode = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceNoVal)."', Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$AddPaymentSql;
                                $this->query($strSQLQueryPay, 0);
                                /*****Update ExpenseID********/	
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);	
				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$TransactionID."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);			
				/*****Update Purchase Status********/
				$arryStatusUpdate["OrderID"] = $values["OrderID"];
 				$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];						 
				$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
				$this->UpdatePoInvoiceStatus($arryStatusUpdate);

				 	
                          }
                        
                        }
                        
                        
                       return $TransactionID;

		}

	/****************************************/
	/****************************************/
	function  addPayVendorTransfer($arryDetails){
			global $Config;			
			$objBankAccount = new BankAccount();
			$ipaddress = GetIPAddress();

			/********************/
			//Vendor Payment Receipt
			extract($arryDetails);
			$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'Invoice');
			$AddPaymentSql = '';
			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];		 
                        /********************/
			
			//echo '<pre>';print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);	
			/********************/
			if($total_saved_payment!='' && $PaidAmount!=''){
				 $addsql = " SET  SuppCode = '".$SuppCode."', TotalAmount = ENCODE('".$total_saved_payment."','".$Config['EncryptKey']."'),  AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."', OriginalAmount=ENCODE('".$TotalOriginalAmount."','".$Config['EncryptKey']."'), ModuleCurrency='".$ModuleCurrency."' , TransferOrderID='".$TransferOrderID."' , TransferSuppCode='".addslashes($TransferSuppCode)."' ";

				if($TransactionID>0){
					$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
		                        $this->query($sql, 0);
				}else{
				 	$sql = "INSERT INTO f_transaction ".$addsql." , CreatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ".$AddPaymentSql;
		                        $this->query($sql, 0);
		                        $TransactionID = $this->lastInsertId();

					/****/
					$ReceiptID = 'TR000'.$TransactionID;
					$sqlr = "UPDATE f_transaction set ReceiptID='".$ReceiptID."' where TransactionID='".$TransactionID."'";
					$this->query($sqlr, 1);	
				}
			}
			/********************/
			//echo $sql;exit;


			/********************/				 	
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."' ";
			}			
                        /********************/	

                        foreach($arrySessTransaction as $key=>$values){
                          if($values['Amount'] != '' ){ 
                               
				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['InvoiceID']);


                                 /*****Expense********/
                                $strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$values['InvoiceID']."', OrderID='".$values['OrderID']."', Amount = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), BankAccount = '".$PaidFrom."', PaidTo = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentMethod= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '".$Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$AccountPayable."',CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);	
                                $ExpenseID = $this->lastInsertId();	
                                /*****Credit Payment*****/
				//$PaidFrom
                                $strSQLQuery = "INSERT INTO f_payments SET   TransactionID='".$TransactionID."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."', PurchaseID = '".$values['PurchaseID']."', InvoiceID='".$values['InvoiceID']."', CreditAmnt = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$AddPaymentSql.$BankCurrencySql;
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                
				/*****Debit Payment*****/
                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."', DebitAmnt = ENCODE('".$values['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ExpenseID = '".$ExpenseID."', SuppCode = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceNoVal)."', Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$AddPaymentSql;
                                $this->query($strSQLQueryPay, 0);
                                /*****Update ExpenseID********/
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);	
				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$TransactionID."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);			
				/*****Update Purchase Status********/
				$arryStatusUpdate["OrderID"] = $values["OrderID"];
 				$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];						 
				$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
				//$arryStatusUpdate["VendorTransfer"] = 1;
				$this->UpdatePoInvoiceStatus($arryStatusUpdate);

				 	
                          }
                        
                        }
                        
                        
                       return $TransactionID;

		}


	function  addCreditVendorTransfer($transaction_id, $arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
			$objBankAccount=new BankAccount();


			$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'Credit');
			//print_r($arrySessTransaction);exit;
			$totalNum = sizeof($arrySessTransaction);
			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];

			if($totalNum>0 && $total_saved_payment!='' && $PaidAmount!=''){


			/********************/				 		
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AP',$Date);	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	


			if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}


                       	     foreach($arrySessTransaction as $key=>$values){
                          
				 if($values['Amount'] != ''){ 
                              		 
                                         
				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['CreditID']);
                   		//$PaidFrom
                            
                                $strSQLQuery = "INSERT INTO f_payments SET   TransactionID='".$transaction_id."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."', CreditID='".$values['CreditID']."', CreditAmnt = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$BankCurrencySql;
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                
                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."', DebitAmnt = ENCODE('".$values['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."',  SuppCode = '".$values['SuppCode']."', ReferenceNo = '".addslashes($ReferenceNoVal)."', Method= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".addslashes($values['CheckNumber'])."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ";
                                $this->query($strSQLQueryPay, 0);

				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);				
			
				/*****Update Credit Status********/	
				$arryStatusUpdate["OrderID"] = $values["OrderID"];							
				$arryStatusUpdate["CreditID"] = $values["CreditID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];	
				$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
				$this->UpdateCreditMemoAPStatus($arryStatusUpdate);			
				/*******************************/
                                                            

                          }
                        
                        }
			}
                        
                        
                       return $TransactionID;

		}
	
	function  addPayVendorContraTransaction($arryDetails) {
            global $Config;
 
            extract($arryDetails);
	    $objBankAccount = new BankAccount();
	    $objSale = new sale();	
            $ipaddress = GetIPAddress();
            if($Method == "Check"){
                $CheckBankName = $CheckBankName;
                $CheckFormat = $CheckFormat;
            }else{
                $CheckBankName = '';
                $CheckFormat = '';
            }
		 
		$arrySessTransaction = $this->ListSessionTransaction('AP',$ContraTransactionID,'Contra Invoice');
		 
		 $totalNum = sizeof($arrySessTransaction);      
		$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];
		/********************/
		if($totalNum>0 && $total_saved_payment!='' && $PaidAmount!=''){ 	
			$addsql = " SET CustID = '".$CustomerName."', CustCode = '".$CustCode."', TotalAmount = ENCODE('".$total_saved_payment."','".$Config['EncryptKey']."'),  AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."',  EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."' , OriginalAmount=ENCODE('".$TotalOriginalAmount."','".$Config['EncryptKey']."'), ModuleCurrency='".$ModuleCurrency."' ";
		if($ContraTransactionID>0){
			$TransactionID = $ContraTransactionID;
			$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
			$this->query($sql, 0);
		}else{
			$sql = "INSERT INTO f_transaction ".$addsql." ,  ContraID = '".$ContraID."', CreatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
			$this->query($sql, 0);
			$TransactionID = $this->lastInsertId();

			/****/
			$ReceiptID = 'CSH000'.$TransactionID;
			$sqlr = "UPDATE f_transaction set ReceiptID='".$ReceiptID."' where TransactionID='".$TransactionID."'";
			$this->query($sqlr, 1);	


		}


		}
		/********************/


		
 
		/********************/			 	
		if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
			$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AR',$Date);	
			$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
		}			
                /********************/	
		$TotalContraAmount = 0;  
		$TotalContraOriginal = 0;
                foreach($arrySessTransaction as $key=>$values){				
                    if($values['Amount'] > 0){     
				 $TotalContraAmount += $values['Amount'];
				$TotalContraOriginal += $values['OriginalAmount'];

				//$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['InvoiceID']);

				/*****Income********/	                            
                                 $strSQLQuery = "INSERT INTO f_income SET  InvoiceID='".$values['InvoiceID']."', Amount = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), TotalAmount = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), BankAccount = '".$PaidFrom."', ReceivedFrom = '".$values['CustID']."', ReferenceNo = '".addslashes($ReferenceTFNo)."', PaymentMethod= '".addslashes($values['Method'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$AccountReceivable."',CreatedDate='".$Config['TodayDate']."', Flag ='1',IPAddress='".$ipaddress."'"; 
                                $this->query($strSQLQuery, 0);    
                                $incomeID = $this->lastInsertId();
				/*****Debit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$TransactionID."', ConversionRate = '".$values['ConversionRate']."', OrderID = '".$values['OrderID']."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."', SaleID = '".$values['SaleID']."', InvoiceID='".$values['InvoiceID']."', DebitAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."',  ReferenceNo = '".addslashes($ReferenceTFNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckNumber='".addslashes($values['CheckNumber'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$BankCurrencySql;
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit Payment*****/
                         	$strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$values['ConversionRate']."',  CreditAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ArContraAccount."', IncomeID = '".$incomeID."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."', ReferenceNo = '".addslashes($ReferenceTFNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($values['Method'])."', CheckNumber='".addslashes($values['CheckNumber'])."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."', OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ";
                                $this->query($strSQLQuery, 0);
				/*****Update IncomeID********/
                                $strSQLQuery = "update f_income SET PID='".$PID."' where IncomeID = '".$incomeID."'";
                                $this->query($strSQLQuery, 0);
				/*****Update TransactionID********/	
				$AddContraSql = '';
				if($values['PaymentType']=='Contra Invoice'){
					//$AddContraSql = " , PaymentType='Invoice', Module='AR' ";
				}
				$strSQuery = "update f_transaction_data SET TransactionID='".$TransactionID."' ".$AddContraSql." where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);
				/*****Update Sales Status********/				
				$arryStatusUpdate["OrderID"] = $values['OrderID'];	
				$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
				$arryStatusUpdate["SaleID"] = $values["SaleID"];
				$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
				$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];
				$arryStatusUpdate["TotalInvoiceAmount"] = $values["TotalInvoiceAmount"];
				$arryStatusUpdate["TotalOrderAmount"] = $values["TotalAmount"];
				$this->UpdateSalesInvoiceStatus($arryStatusUpdate);				
				/*******************************/


                            }
                        
                        
                        }


		   /******Update Total Amount 3July PK******/
		   $TotalContraAmount = round($TotalContraAmount,2);
		   $TotalContraOriginal = round($TotalContraOriginal,2);

		   $TotalMainAmount = round(($total_saved_payment - $TotalContraAmount),2);
		   $TotalMainOriginal = round(($TotalOriginalAmount - $TotalContraOriginal),2);

		   $sqlm = "UPDATE f_transaction set TotalAmount = ENCODE('".$TotalMainAmount."','".$Config['EncryptKey']."'), OriginalAmount = ENCODE('".$TotalMainOriginal."','".$Config['EncryptKey']."') where TransactionID='".$ContraID."'"; //main
		   $this->query($sqlm, 1);


		   $sqlc = "UPDATE f_transaction set TotalAmount = ENCODE('".$TotalContraAmount."','".$Config['EncryptKey']."'), OriginalAmount = ENCODE('".$TotalContraOriginal."','".$Config['EncryptKey']."') where TransactionID='".$TransactionID."'"; //contra
		   $this->query($sqlc, 1);
		   /******************************/
                        
                         
        }

  	/****************************************/
	/****************************************/

	function GLReport($arryDetails){               
                global $Config;
		extract($arryDetails);
		 
		$strAddQuery=$sourceJoin='';
		$SearchKey   = strtolower(trim($key));
		$strAddQuery .= ($AccountID>0)?(" and (p.AccountID = '".$AccountID."')"):("");
		
		if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(p.PaymentDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(p.PaymentDate)='".$Month."' and YEAR(p.PaymentDate)='".$Year."'";
		}else if($FilterBy=='Reference'){
			$strAddQuery .= (!empty($SearchKey))?(" and p.ReferenceNo like '%".$SearchKey."%' "):("");
		}else if($FilterBy=='Source'){
			$arrKey = explode(":",$SearchKey);
			if(!empty($arrKey[1]))$SearchKey = trim($arrKey[1]);
			$strAddQuery .= (!empty($SearchKey))?(" and (so.SaleID like '%".$SearchKey."%' or po.PurchaseID like '%".$SearchKey."%' or pr.PurchaseID like '%".$SearchKey."%')"):("");
		}else if($FilterBy=='Name'){
			$strAddQuery .= (!empty($SearchKey))?(" and (c.Company like '%".$SearchKey."%' or c.FullName like '%".$SearchKey."%' or  s.CompanyName  like '%".$SearchKey."%' )"):("");
		}else{
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
	        	$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                }

		$strAddQuery .= (!empty($Config['ModuleCurrencySel']))?(" and (p.ModuleCurrency='".$Config['ModuleCurrencySel']."' OR p.ModuleCurrency2='".$Config['ModuleCurrencySel']."'  ) and p.TransactionType in ('C','D')   "):("");
                 
		#$strAddQuery .= (!empty($SearchKey))?(" and (c.FullName like '".$SearchKey."%' or p.ReferenceNo like '%".$SearchKey."%' or p.PaymentType like '%".$SearchKey."%') "):("");
		#$strAddQuery .= " order by p.PaymentDate ASC,p.PaymentType Asc,p.ReferenceNo ASC,p.PaymentID Asc";
		

		if($GetModuleCurrency==1){
			$Cols = " distinct(p.ModuleCurrency) ";
			$strAddQuery .= " and p.ModuleCurrency!='' and p.ModuleCurrency!='".$Config['Currency']."' and p.ConversionRate>'0' and p.TransactionType in ('C','D') ";
		}else{
			$Cols = " distinct(p.PaymentID), p.*, DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, DECODE(p.OriginalAmount,'". $Config['EncryptKey']."') as OriginalAmount, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName, b.AccountName,CONCAT(s.FirstName,' ',s.LastName) as SupplierName, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName, so.SaleID, po.PurchaseID, pr.PurchaseID as RecPurchaseID  "; 
		}


		$strAddQuery .= " order by p.PaymentDate Desc,p.PaymentType Desc,p.PaymentID Desc,p.ReferenceNo Asc,p.PaymentType Asc";
		

		$sourceJoin .= " left outer join s_order so on (p.ReferenceNo=so.InvoiceID and p.ReferenceNo!='' and so.Module='Invoice' and p.PaymentType in('Sales','Customer Invoice','Customer Invoice Entry','AR Gain','AR Loss') ) ";
		$sourceJoin .= " left outer join p_order po on (p.ReferenceNo=po.InvoiceID and p.ReferenceNo!='' and po.Module='Invoice' and p.PaymentType in('Purchase','Vendor Invoice','Vendor Invoice Entry', 'AP Gain','AP Loss') ) ";
		$sourceJoin .= " left outer join p_order pr on (p.ReferenceNo=pr.ReceiptID and p.ReferenceNo!='' and pr.Module='Receipt' and p.PaymentType in('PO Receipt') ) ";
		

		$strSQLQuery = "select ".$Cols." from f_payments p left outer join s_customers c on (c.Cid = p.CustID and p.CustID>'0') inner join f_account b on (b.BankAccountID = p.AccountID and p.AccountID>'0') left outer join p_supplier s on   (s.SuppCode =  p.SuppCode and p.SuppCode!='' ) ".$sourceJoin." where p.PostToGL = 'Yes' ".$strAddQuery;

		if(!empty($_GET['pk1'])){
			echo $strSQLQuery.'<br><br>';  
 		}

		return $this->query($strSQLQuery, 1);
	}

	
	/****************************************/
	/****************************************/
	function PoReceiptPostToGL($OrderID, $arryPostData){
		global $Config;
		extract($arryPostData);
	
		/*if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		} 
		$Date = $PostToGLDate;*/   
		$ipaddress = GetIPAddress(); 

		$strSQLQuery = "SELECT p.* from p_order p where p.OrderID = '".trim($OrderID)."' and PostToGL != '1' ";
		$arryRow = $this->query($strSQLQuery, 1);	
		$TotalAmount = $arryRow[0]['TotalAmount'] - $arryRow[0]['taxAmnt'];
		$OriginalAmount = $TotalAmount ;		 
		$Date = $arryRow[0]['ReceivedDate'];
		$OrderType = $arryRow[0]['OrderType'];
		//echo '<pre>';print_r($arryRow);exit;
	
			/**************************************/
			if(!empty($PurchaseClearing) && !empty($InventoryAP) && !empty($CostOfGoods) && !empty($AccountPayable) && !empty($TotalAmount)){			 
				$ConversionRate=1;
				if($arryRow[0]['Currency']!=$Config['Currency']){
					#$ConversionRate=CurrencyConvertor(1,$arryRow[0]['Currency'],$Config['Currency'],'AP',$Date);
					$ConversionRate = $arryRow[0]['ConversionRate'];
					$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount) ,2); 	 
				}
								 
				/*if($InvoiceGenerated=='1'){
					$DebitAccount = $PurchaseClearing;
					$CreditAccount = $AccountPayable;
				}else{
					$DebitAccount = $InventoryAP;
					$CreditAccount = $PurchaseClearing;
				}*/	


				if($OrderType=='Dropship'){
					$InvAccountID = $CostOfGoods;
				}else{
					$InvAccountID = $InventoryAP;
				}


				$DebitAccount = $InvAccountID;
				$CreditAccount = $PurchaseClearing;

	 
				//Debit Inventory
				$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', InvoiceID='".$InvoiceID."', ReferenceNo='".$arryRow[0]['ReceiptID']."', DebitAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D' ";		
				$this->query($strSQLQuery, 1);
				$PID = $this->lastInsertId();
				//Credit Purchase Clearing
				$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),  ReferenceNo='".$arryRow[0]['ReceiptID']."', AccountID = '".$CreditAccount."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C'";
				$this->query($strSQLQueryPay, 0);
				
			}
			/**************************************/
	 

	     
		/************************/
		if($PID>0){
			$strSQLQuery = "update p_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."', PostToGLTime='".$Config['TodayDate']."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0);  
		
		} 
		/************************/
 


		return true;
			
	}

	/****************************************/
	/****************************************/
	function StockAdjustmentPostToGL($adjID, $arryPostData){
		global $Config;
		extract($arryPostData);
		/*if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		} 
		$Date = $PostToGLDate;*/   
		$ipaddress = GetIPAddress(); 
					

		$strSQLQuery = "SELECT a.* from inv_adjustment a where a.adjID = '".trim($adjID)."' and a.Status = '2' ";
		$arryRow = $this->query($strSQLQuery, 1);	
		$TotalAmount = $arryRow[0]['total_adjust_value'];	 
		$Date = $arryRow[0]['adjDate'];		 
		//echo '<pre>';print_r($arryRow);exit;	
		 
		/**************************************/
		if($arryRow[0]['adjID']>0){
			$strSQL = "SELECT s.* from inv_stock_adjustment s where s.adjID = '".trim($adjID)."' ";
			$arryItem = $this->query($strSQL, 1);
			foreach($arryItem as $key=>$values){//Start Item Loop

				/*if($values["QtyType"]=='Subtract'){
					$DebitAccount = $InventoryGL;
					$CreditAccount = $InventoryAdjustment;	
				}else{//add					
					$DebitAccount = $InventoryAdjustment;
					$CreditAccount = $InventoryGL;			
				}*/


				if($OpeningStock=='1'){
					$DebitAccount = $InventoryGL;
					$CreditAccount = $InventoryAdjustment;	
				}else{
					if($values["QtyType"]=='Subtract'){
						$DebitAccount = $InventoryAdjustment;
						$CreditAccount = $InventoryGL;	
					}else{//add					
						$DebitAccount = $InventoryGL;
						$CreditAccount = $InventoryAdjustment;				
					}
					
				}

	 
				$ReferenceNo = $arryRow[0]['adjustNo'].' ['.$values["sku"].']';
				$Amount = $values["amount"];
				if($Amount>0){
					//Debit 
					$strSQLQuery = "INSERT INTO f_payments SET ReferenceNo='".addslashes($ReferenceNo)."', DebitAmnt  = ENCODE('".$Amount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";		
					$this->query($strSQLQuery, 1);
					$PID = $this->lastInsertId();
					//Credit 
					$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', CreditAmnt = ENCODE('".$Amount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),  ReferenceNo='".addslashes($ReferenceNo)."', AccountID = '".$CreditAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
					$this->query($strSQLQueryPay, 0);
				}

			}
		}
		/**************************************/
		
		return true;
			
	}



	/****************************************/
	/****************************************/
	function AllStockAdjustmentPostToGL(){
		global $Config;		
		$ipaddress = GetIPAddress(); 
		$objConfigure = new configure();
		$InventoryGL = $objConfigure->getSettingVariable('InventoryAR');
		$InventoryAdjustment = $objConfigure->getSettingVariable('InventoryAdjustment');		

		if($InventoryGL>0 && $InventoryAdjustment>0){
			//$strAdd = " and a.adjID = '76'  ";
			$strSQLQuery = "SELECT a.adjID,a.adjust_reason,a.adjustNo,a.adjDate from inv_adjustment a where a.Status = '2' ".$strAdd." order by adjID asc";
			$arryRow = $this->query($strSQLQuery, 1);
				 
			//echo '<pre>';print_r($arryRow);exit;	
		 
		/**************************************/
		foreach($arryRow as $k=>$val){

			$adjust_reason = $val["adjust_reason"];
			$Date = $val['adjDate'];	
			$PaymentType = 'Stock Adjustment ('.$val["adjust_reason"].')';

			$strSQL = "SELECT s.* from inv_stock_adjustment s where s.adjID = '".$val["adjID"]."' ";		
			$arryItem = $this->query($strSQL, 1);
			
			foreach($arryItem as $key=>$values){//Start Item Loop
				 

				if($adjust_reason=='Opening Stock'){
					//echo '<br>a';
					$DebitAccount = $InventoryGL;
					$CreditAccount = $InventoryAdjustment;	
				}else{
					//echo '<br>b';
					if($values["QtyType"]=='Subtract'){
						$DebitAccount = $InventoryAdjustment;
						$CreditAccount = $InventoryGL;	
					}else{//add					
						$DebitAccount = $InventoryGL;
						$CreditAccount = $InventoryAdjustment;				
					}
					
				}

	 
				$ReferenceNo = $val['adjustNo'].' ['.$values["sku"].']';
				$Amount = $values["amount"];
				if($Amount>0){
					//Debit 
					$strSQLQuery = "INSERT INTO f_payments SET ReferenceNo='".addslashes($ReferenceNo)."', DebitAmnt  = ENCODE('".$Amount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";		
					$this->query($strSQLQuery, 1);
					$PID = $this->lastInsertId();
					//Credit 
					$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', CreditAmnt = ENCODE('".$Amount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),  ReferenceNo='".addslashes($ReferenceNo)."', AccountID = '".$CreditAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
					$this->query($strSQLQueryPay, 0);
				}

			}
		}
		/**************************************/
		}
		return true;
			
	}

	/****************************************/
	/****************************************/
	function AssemblyPostToGL($asmID, $arryPostData){
		global $Config;
		extract($arryPostData);
		/*if(empty($PostToGLDate)){ 
			$PostToGLDate=$Config['TodayDate'];
		} 
		$Date = $PostToGLDate;*/   
		$ipaddress = GetIPAddress(); 
					

		$strSQLQuery = "SELECT a.* from inv_assembly a where a.asmID = '".trim($asmID)."' and a.Status = '2' ";
		$arryRow = $this->query($strSQLQuery, 1);	
		$TotalAmount = $arryRow[0]['total_cost'];	 
		$Date = $arryRow[0]['asmDate'];	
		$ReferenceNo = $arryRow[0]['asm_code'].' ['.$arryRow[0]["Sku"].']';	 
		//echo '<pre>';print_r($arryRow);exit;	
		/**************************************/
		if($arryRow[0]['asmID']>0 && $InventoryGL>0){	
				$DebitAccount = $InventoryGL;
				$CreditAccount = $InventoryGL;		 			
				
				if($TotalAmount>0){
					//Debit 
					$strSQLQuery = "INSERT INTO f_payments SET ReferenceNo='".addslashes($ReferenceNo)."', DebitAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";		
					$this->query($strSQLQuery, 1);
					$PID = $this->lastInsertId();
					//Credit 
					$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),  ReferenceNo='".addslashes($ReferenceNo)."', AccountID = '".$CreditAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
					$this->query($strSQLQueryPay, 0);
				}

			
		}
		/**************************************/
		
		return true;
			
	}
	/****************************************/
	/****************************************/
	function DisassemblyPostToGL($DsmID, $arryPostData){
		global $Config;
		extract($arryPostData);
		/*if(empty($PostToGLDate)){ 
			$PostToGLDate=$Config['TodayDate'];
		} 
		$Date = $PostToGLDate;*/   
		$ipaddress = GetIPAddress(); 
					

		$strSQLQuery = "SELECT a.* from inv_disassembly a where a.DsmID = '".trim($DsmID)."' and a.Status = '2' ";
		$arryRow = $this->query($strSQLQuery, 1);	
		$TotalAmount = $arryRow[0]['total_cost'];	 
		$Date = $arryRow[0]['disassemblyDate'];	
		$ReferenceNo = $arryRow[0]['DsmCode'].' ['.$arryRow[0]["Sku"].']';	 
		//echo '<pre>';print_r($arryRow);exit;	
		/**************************************/
		if($arryRow[0]['DsmID']>0 && $InventoryGL>0){	
				$DebitAccount = $InventoryGL;
				$CreditAccount = $InventoryGL;		 			
				
				/***Duplicacy check******/
				$strSQL = "SELECT PaymentID from f_payments where ReferenceNo = '".$ReferenceNo."' and PaymentType = '".$PaymentType."' order by PaymentID Asc limit 0,1 ";
				$arryPay = $this->query($strSQL, 1);
				/************************/

				if($TotalAmount>0 && empty($arryPay[0]["PaymentID"])){
					//Debit 
					$strSQLQuery = "INSERT INTO f_payments SET ReferenceNo='".addslashes($ReferenceNo)."', DebitAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";		
					$this->query($strSQLQuery, 1);
					$PID = $this->lastInsertId();
					//Credit 
					$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),  ReferenceNo='".addslashes($ReferenceNo)."', AccountID = '".$CreditAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
					$this->query($strSQLQueryPay, 0);


					if(!empty($_GET['PK3453463463'])) {
						echo '<br>'.$ReferenceNo; 
					}

				}

			
		}
		/**************************************/
		
		return true;
			
	}
 
	/****************************************/
	/****************************************/ 
	
    	function CreateCashReceiptFromRMA($OrderIDRma, $ReceiptFlag){  
		//amazon,ebay refund
	 	global $Config;
		$objConfigure=new configure();

		if($ReceiptFlag==1){
			$str = "SELECT OrderID from w_receipt where ReceiptID = '".trim($OrderIDRma)."' ";
			$arryRc = $this->query($str, 1);
			$OrderIDRma = $arryRc[0]['OrderID'];
		}
		 

		if($OrderIDRma>0){
			$strSQlRma = "SELECT s.ReturnID,s.InvoiceID from s_order s where s.OrderID = '".trim($OrderIDRma)."' and Module='RMA' ";
			$arryRma = $this->query($strSQlRma, 1);
			if(!empty($arryRma[0]['ReturnID'])){ //credit
				$strSQlCredit = "SELECT s.* from s_order s where s.ReturnID = '".$arryRma[0]['ReturnID']."' and Module='Credit' order by OrderID desc limit 0,1 ";
				$arryCredit = $this->query($strSQlCredit, 1);				 
			}
			if(!empty($arryCredit[0]['InvoiceID']) && !empty($arryRma[0]['InvoiceID'])){ //invoice
				$strSQlInv = "SELECT s.* from s_order s where s.InvoiceID = '".$arryRma[0]['InvoiceID']."' and Module='Invoice' and OrderSource In ('Amazon','Ebay')";
				$arryRow = $this->query($strSQlInv, 1);
			}
			
		}

		//echo $arryCredit[0]['CreditID'].'#'.$arryRow[0]["InvoiceID"];exit;
		 
		if(!empty($arryCredit[0]["CreditID"]) && !empty($arryRow[0]["InvoiceID"]) && $arryCredit[0]["InvoiceID"]==$arryRow[0]["InvoiceID"]){
		 
			$OrderSource = strtolower($arryRow[0]['OrderSource']);
		 			
			if($OrderSource=='amazon'){	
				$PaidTo = $objConfigure->getSettingVariable('AmazonAccount');
				$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');	
			}else if($OrderSource=='ebay'){
				$PaidTo = $objConfigure->getSettingVariable('EbayAccount');
				$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
			}			 		
		
			if($PaidTo>0 && $AccountReceivable>0){
				$InvAmount = round(GetConvertedAmount($arryRow[0]['ConversionRate'], $arryRow[0]['TotalInvoiceAmount']),2); 
				$CrdAmount = round(GetConvertedAmount($arryCredit[0]['ConversionRate'], $arryCredit[0]['TotalAmount']),2); 
				$TransactionAmount = round(($InvAmount - $CrdAmount),2);				
				/********Invoice**********/
				$arryRow[0]['AutoReceipt'] = 2;	 
				$arryRow[0]['PaidTo'] = $PaidTo;
				$arryRow[0]['AccountReceivable'] = $AccountReceivable;

				$arryRow[0]['OriginalAmount'] = round($arryRow[0]['TotalInvoiceAmount'],2);
				$arryRow[0]['TotalOriginalAmount'] = round($arryRow[0]['TotalInvoiceAmount'],2);
				$arryRow[0]['ModuleCurrency'] = $arryRow[0]['CustomerCurrency'];

				$arryRow[0]['Amount'] = $TransactionAmount;
				$arryRow[0]['PostToGLDate'] = $Config['TodayDate'];

				$arryRowData[0]['Module'] = 'AR';
				$arryRowData[0]['PaymentType'] = 'Invoice';
				$arryRowData[0]['Amount'] = $InvAmount ;
				$arryRowData[0]['OriginalAmount'] = round($arryRow[0]['TotalInvoiceAmount'],2);
				$arryRowData[0]['ConversionRate'] = $arryRow[0]['ConversionRate'];	
				$arryRowData[0]['CustID'] = $arryRow[0]['CustID'];
				$arryRowData[0]['InvoiceID'] = $arryRow[0]['InvoiceID'];
				$arryRowData[0]['OrderID'] = $arryRow[0]['OrderID'];
 				$arryRowData[0]['Method'] = $arryRow[0]['PaymentTerm']; 	
				$arryRow[0]['TrID'] = $this->AddUpdateTransaction($arryRowData[0]);
				$TransactionID = $this->addReceiptTransaction($arryRow);
				 
				/********Credit**********/
				$arryCredit[0]['AutoReceipt'] = 2;	 
				$arryCredit[0]['PaidTo'] = $PaidTo;
				$arryCredit[0]['AccountReceivable'] = $AccountReceivable;
				
				$arryCredit[0]['Amount'] = $CrdAmount; 
				$arryCredit[0]['PostToGLDate'] = $Config['TodayDate'];

				$arryCrdData[0]['Module'] = 'AR';
				$arryCrdData[0]['PaymentType'] = 'Credit';
				$arryCrdData[0]['Amount'] = $CrdAmount; 
				$arryCrdData[0]['ConversionRate'] = $arryCredit[0]['ConversionRate'];	
				$arryCrdData[0]['CustID'] = $arryRow[0]['CustID'];
				$arryCrdData[0]['CreditID'] = $arryCredit[0]['CreditID'];
				$arryCrdData[0]['OrderID'] = $arryCredit[0]['OrderID'];
 				$arryRowData[0]['Method'] = $arryRow[0]['PaymentTerm']; 	
				$arryCredit[0]['TrID'] = $this->AddUpdateTransaction($arryCrdData[0]);
				$this->addCreditTransaction($TransactionID,$arryCredit);
		 		/************************/
			}

			//exit;
		
		}
		return true;
	}


	/****************************************/
	/****************************************/ 

	function GetTransactionDataByID($Module,$TransactionID,$PaymentType){			

			if(!empty($TransactionID)){
				$arryTransactionID = explode(",",$TransactionID);
				if(sizeof($arryTransactionID)>1) $Module='';//contra
			}
			$strAddQuery='';
			if(!empty($Module)) $strAddQuery .= " and t.Module='".$Module."' ";	 	 	
			if(!empty($TransactionID)) $strAddQuery .= " and t.TransactionID in (".$TransactionID.") ";
			if(!empty($PaymentType)) $strAddQuery .= " and t.PaymentType='".$PaymentType."' ";

			if(!empty($_GET['CustID'])) $strAddQuery .= " and t.CustID='".$_GET['CustID']."' ";
			if(!empty($_GET['SuppCode'])) $strAddQuery .= " and t.SuppCode='".$_GET['SuppCode']."' ";
			
			 $strSQLQuery = "select t.*,o.InvoiceDate,o.InvoiceEntry,o.CustCode, o.SaleID, o.TotalInvoiceAmount, o.CustomerCurrency, o.TotalAmount, o.OrderSource, o.CustomerPO, p.TotalAmount as VendorTotalAmount, p.PostedDate,p.InvoiceEntry as PInvoiceEntry, p.ExpenseID,p.PurchaseID, p.Currency, b.RangeFrom, b.RangeTo, b.AccountNumber, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName from f_transaction_data t left outer join s_order o on (t.OrderID=o.OrderID and t.CustID=o.CustID and t.OrderID>'0') left outer join p_order p on (t.OrderID=p.OrderID and t.SuppCode=p.SuppCode and t.OrderID>'0') left outer join f_account b on b.BankAccountID = t.AccountID left outer join s_customers c on t.CustID=c.Cid left outer join p_supplier s on  t.SuppCode =  s.SuppCode where 1 ".$strAddQuery." and t.Deleted='0' order by TrID Asc"; 

			if(!empty($_GET['pk']))echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		

	}
	/****************************************/
	/****************************************/ 
	function RefundOnAmazonEbay($Prefix, $TransactionID, $gldate){ 
		global $Config;		
		 
	        $objProduct=new product();
		//echo '<pre>';
		
	 	$arryTransactionInvoice = $this->GetTransactionDataByID('AR',$TransactionID ,'Invoice'); 
		$arryTransactionCredit = $this->GetTransactionDataByID('AR',$TransactionID ,'Credit');  
		if(!empty($arryTransactionInvoice[0]['InvoiceID']) && !empty($arryTransactionCredit[0]['CreditID'])){ 
			foreach($arryTransactionInvoice as $key=>$values){//Start Invoice Loop
				$OrderSource = strtolower($values['OrderSource']);
				$InvoiceID = $values['InvoiceID'];
				
				if($OrderSource=='amazon' || $OrderSource=='ebay'){ 
					foreach($arryTransactionCredit as $key2=>$values2){ //Start Credit Loop 
						$CreditID = $values2['CreditID'];
						//echo $InvoiceID.'#'.$CreditID;exit;

						$strSQlCredit = "SELECT s.OrderID from s_order s where s.CreditID = '".$CreditID."' and s.InvoiceID = '".$InvoiceID."' and Module='Credit' and ReturnID!='' "; //checking rma
						$arryCredit = $this->query($strSQlCredit, 1);	

						if(!empty($arryCredit[0]["OrderID"])){ //credit matched with invoice

							//print_r($values); print_r($values2); exit;

							switch($OrderSource){
								case 'amazon';
									/*********************/
									//echo 'amazon api'; die;
									//$values['CustomerPO'] = '106-3161343-2263435';//'104-0526129-1465009';
									//$values2['Amount'] = '360.00';
									
									$strSQlECom = "SELECT e.AmazonAccountID, ed.OrderItemId, (ed.quantity*ed.price) as totalItemPrice from e_orders e left join e_orderdetail ed on(e.OrderID=ed.OrderID) where e.AmazonOrderID = '".$values['CustomerPO']."' and OrderType='Amazon' "; 
 									$arryECom = $this->query($strSQlECom, 1);
								 	if($arryECom[0]['AmazonAccountID']>0){
										$objProduct->AccountID = $arryECom[0]['AmazonAccountID'];
										$Rdata = array('AmazonOrderId'=> $values['CustomerPO'], 'AmazonOrderItemCode'=>$arryECom, 'SubTotalPrice'=>abs($values2['Amount']), 'RefundReason'=>'GeneralAdjustment', 'Currency'=>$Config['Currency']);
										$Amazonservice = $objProduct->AmazonSettings($Prefix,true,$arryECom[0]['AmazonAccountID']);
										if($Amazonservice)
										$objProduct->RefundAmazonOrderItems($Amazonservice,$Rdata);
									}

									/*********************/	
									break;

								case 'ebay';
									/*********************/
									echo 'ebay api';
									/*********************/
									break;
							}
							/*********************/
						}


					}//End Credit Loop
				}
			}//End Invoice Loop
		}
		return true;
	}

	/****************************************/
	/****************************************/ 
	function PostToGainLoss($TransactionID,$Date,$Module){
		global $Config;
		$objConfigure=new configure();
		$objBankAccount = new BankAccount();
		$ipaddress = GetIPAddress(); 
		$ApGainLoss = $objConfigure->getSettingVariable('ApGainLoss');
		$ArGainLoss = $objConfigure->getSettingVariable('ArGainLoss');
		$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');
		$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');

		$strSQL = "select t.TransactionID, t.AccountID, t.ModuleCurrency, a.AccountGainLoss,a.BankFlag from f_transaction t left outer join f_account a on t.AccountID=a.BankAccountID WHERE t.TransactionID in(".$TransactionID.")";
		$arryTransaction = $this->query($strSQL, 1);
		$ModuleCurrency =  $arryTransaction[0]['ModuleCurrency'];
		if($arryTransaction[0]['AccountID']>0){
			$sql = "select t.Module, t.Amount, t.InvoiceID, t.ModuleCurrency, t.OrderID, t.CustID, t.SuppCode, o.InvoicePaid, o.TotalInvoiceAmount, o.CustCode, p.InvoicePaid as PInvoicePaid, p.TotalAmount as PTotalAmount,p.SuppCompany from f_transaction_data t left outer join s_order o on (t.OrderID=o.OrderID and t.CustID=o.CustID and t.OrderID>'0') left outer join p_order p on (t.OrderID=p.OrderID and t.SuppCode=p.SuppCode and t.OrderID>'0') WHERE t.TransactionID = '".$arryTransaction[0]['TransactionID']."' and t.PaymentType='Invoice' and t.Module='".$Module."' and t.InvoiceID!='' ";
			$arryInvData = $this->query($sql, 1);


			/********************/	
			$BankCurrencySql='';			 			
			if($arryTransaction[0]['BankFlag']=="1" && !empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'GL');	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
	                /********************/	

		//echo '<pre>'; print_r($arryInvData);exit;
		foreach($arryInvData as $key=>$values){//Start foreach
			$PostToGLAmount=0; $OrigPostToGLAmount=0;
			$PaidAmnt=0; $OrigPaidAmnt=0;
			$Gain=0;
			$Loss=0;
			$ProcessFlag=0;
			/********************************/
			if($values["Module"]=="AR" && $values["InvoicePaid"]=="Paid"){ //Sales Invoice
				$ProcessFlag = 1;
				$PaymentTypeIn = "'Customer Invoice','Customer Invoice Entry'";
				$InvoiceAmount = $values["TotalInvoiceAmount"];
				$PaymentType = 'Sales';
			}else if($values["Module"]=="AP" && $values["PInvoicePaid"]=="1"){ //Purchase Invoice
				$ProcessFlag = 1;
				$PaymentTypeIn = "'Vendor Invoice','Vendor Invoice Entry'";
				$InvoiceAmount = $values["PTotalAmount"];
				$PaymentType = 'Purchase';
			}

			/********************************/
			if($ProcessFlag==1){
				//Get post to gl data
				$strInv = "select p.PaymentID, p.ConversionRate from f_payments p WHERE p.PaymentType in(".$PaymentTypeIn.") and p.ReferenceNo='".$values["InvoiceID"]."' and PostToGL='Yes' order by PaymentID Desc limit 0,1"; 
				$arryPostToGL = $this->query($strInv, 1);

				$OrigPostToGLAmount = $InvoiceAmount;
				if($arryPostToGL[0]['ConversionRate']>0){
					$PostToGLAmount = GetConvertedAmount($arryPostToGL[0]['ConversionRate'], $InvoiceAmount);
				}else if($arryPostToGL[0]['PaymentID']>0){
					$PostToGLAmount =  $InvoiceAmount;
				}
			
				//Get paid amount
				$strSQLQuery = "SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as DbtAmnt, SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as CrdAmnt,  SUM(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) as OriginalAmnt  from f_payments p WHERE p.PaymentType='".$PaymentType."' and p.OrderID='".$values["OrderID"]."' and p.InvoiceID='".$values["InvoiceID"]."' and p.TransactionID<='".$TransactionID."' "; 
				$arryPaid = $this->query($strSQLQuery, 1);


				$OrigPaidAmnt = $arryPaid[0]['OriginalAmnt'];
				if($values["Module"]=="AR"){
					$PaidAmnt = $arryPaid[0]['DbtAmnt'];
				}else{
					$PaidAmnt = $arryPaid[0]['CrdAmnt'];
				}
 
				$PostToGLAmount = round($PostToGLAmount,2);
				$OrigPostToGLAmount = round($OrigPostToGLAmount,2);
				$PaidAmnt = round($PaidAmnt,2);
				$OrigPaidAmnt = round($OrigPaidAmnt,2);		
			}
			//echo '<br>'.$PostToGLAmount.'#'.$PaidAmnt; 
			/********************************/				 
			if($PostToGLAmount>0 && $PaidAmnt>0 && $PostToGLAmount!=$PaidAmnt){
				$AccountGainLoss = $ArGainLoss;
				$ReceivablePayable = $AccountReceivable;
				if($values["Module"]=="AP"){//Swap Variables
					$a = $PostToGLAmount;
					$PostToGLAmount = $PaidAmnt;
					$PaidAmnt = $a;

					$b = $OrigPostToGLAmount;
					$OrigPostToGLAmount = $OrigPaidAmnt;
					$OrigPaidAmnt = $b;

					$AccountGainLoss = $ApGainLoss;
					$ReceivablePayable = $AccountPayable;
				}
				

				if($PaidAmnt>$PostToGLAmount){
					$GainLoss = $PaidAmnt - $PostToGLAmount;
					$OrigGainLoss =  $OrigPaidAmnt - $OrigPostToGLAmount;	
					$PaymentType = $Module.' Gain';	
								
					$CreditAccount = $AccountGainLoss;  // Credit Gain
 					$DebitAccount = $ReceivablePayable; //$arryTransaction[0]['AccountID'];  //Debit bank account
				}else{
					$GainLoss = $PostToGLAmount - $PaidAmnt;
					$OrigGainLoss = $OrigPostToGLAmount - $OrigPaidAmnt;
					$PaymentType = $Module.' Loss';	
					
					$DebitAccount = $AccountGainLoss;  //Debit Loss
					$CreditAccount = $ReceivablePayable;// $arryTransaction[0]['AccountID'];  // Credit bank account 
				}

			
				if($CreditAccount>0 && $DebitAccount>0 && $values['ModuleCurrency']!=$Config['Currency']){
					//Credit
					$strSQLQuery = "INSERT INTO f_payments SET CreditAmnt = ENCODE('".$GainLoss."', '".$Config['EncryptKey']."'),  DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccount."', ReferenceNo='".$values['InvoiceID']."',  CustID = '".$values['CustID']."', SuppCode = '".$values['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$OrigGainLoss. "','".$Config['EncryptKey']."'), TransactionType='C'  "; 
					$this->query($strSQLQuery, 0);
					$PID = $this->lastInsertId();
					//Debit
					$strSQLQuery2 = "INSERT INTO f_payments SET PID='".$PID."', DebitAmnt = ENCODE('".$GainLoss."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."', ReferenceNo='".$values['InvoiceID']."',  CustID = '".$values['CustID']."', SuppCode = '".$values['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$OrigGainLoss. "','".$Config['EncryptKey']."'), TransactionType='D' ".$BankCurrencySql; 
					$this->query($strSQLQuery2, 0);
					 
				}




				unset($arryCredit);
				$arryCredit["InvoiceID"] = $values["InvoiceID"];
				$arryCredit["TotalAmount"] = $OrigGainLoss;				
				$arryCredit["ModuleCurrency"] = $values['ModuleCurrency'];
				$arryCredit["AccountID"] = $arryTransaction[0]['AccountID'];
				$arryCredit["PostedDate"] = $Date;
				$arryCredit["Comment"] = $PaymentType;
				$arryCredit["CustID"] = $values['CustID'];
				$arryCredit["CustCode"] = $values['CustCode'];
				$arryCredit["SuppCode"] = $values['SuppCode'];
				$arryCredit["SuppCompany"] = $values['SuppCompany'];
 				if($values['ModuleCurrency']!=$Config['Currency']){
					$arryCredit["ConversionRate"] = $arryPostToGL[0]['ConversionRate'];
				}
				/***************************************************************/
				/***************************************************************/			
				if($PaymentType=="AR Gain"){
					//Credit Customer
					/*$sql2="UPDATE s_customers SET CreditAmount='0' WHERE Cid='".$values['CustID']."' and CreditAmount<0";
					$this->query($sql2,0);

					 $sql="UPDATE s_customers SET CreditAmount=CreditAmount+".$GainLoss." WHERE Cid='".$values['CustID']."' ";
					$this->query($sql,0);*/
					
					$this->AddSaleCredit($arryCredit);

				}else if($PaymentType=="AP Loss"){
					//Credit Vendor
					/*$sql2="UPDATE p_supplier SET CreditAmount='0' WHERE SuppCode='".$values['SuppCode']."' and CreditAmount<0";
					$this->query($sql2,0);

					 $sql="UPDATE p_supplier SET CreditAmount=CreditAmount+".$GainLoss." WHERE SuppCode='".$values['SuppCode']."' ";
					$this->query($sql,0);*/
					
					$this->AddPurchaseCredit($arryCredit);
				}
				/***************************************************************/
				/***************************************************************/

			}
			/********************************/
			 
			
		}//End foreach

		
		
		}		  
		return true;
	}



	/****************************************/
	/****************************************/ 
	function AddSaleCredit($arryDetails){
		global $Config;
		extract($arryDetails);
		$IPAddress = GetIPAddress();

		$strSQLQuery = "INSERT INTO s_order SET Module = 'Credit', InvoiceID = '".addslashes($InvoiceID)."',
			Approved = '1', Status = 'Open', Comment = '".addslashes($Comment)."', AccountID = '".addslashes($AccountID)."', CustCode='".addslashes($CustCode)."', CustID = '".addslashes($CustID)."', CustomerCurrency = '".addslashes($ModuleCurrency)."', TotalAmount = '".$TotalAmount."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$PostedDate."',UpdatedDate='".$Config['TodayDate']."', ConversionRate='".addslashes($ConversionRate)."',IPAddress = '". $IPAddress."', PostToGL='1', OverPaid='1' ";		
		$this->query($strSQLQuery, 0);
		$CrID = $this->lastInsertId();		

		/*$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('s_order','Credit',$CrID,'');*/ 
		
		$CreditIDValue = 'OverPaid'.$CrID;
		$strSQL = "update s_order set CreditID='".$CreditIDValue."' where OrderID='".$CrID."'"; 
		$this->query($strSQL, 0);	

		/*********CreditLimit Updation***********/
		$strSQlCust = "select PaymentTerm from s_customers c WHERE CustCode='".$CustCode."'";
		$arrCust = $this->query($strSQlCust, 1);			
		if(!empty($arrCust[0]['PaymentTerm'])){
			$arryTerm = explode("-",$arrCust[0]['PaymentTerm']);
			$TermDays = (int)trim($arryTerm[1]);
			if($TermDays > 0){
				$sql="UPDATE s_customers SET CreditLimit=CreditLimit-".$totalAmountForCredit." WHERE CustCode='".$CustCode."' and CreditLimit>0";
				$this->query($sql,0);
				$sql2="UPDATE s_customers SET CreditLimit='0' WHERE CustCode='".$CustCode."' and CreditLimit<0";
				$this->query($sql2,0);
			}
		}
		/*****************************************/		 

		return $CrID;
	}

	/****************************************/
	/****************************************/ 
	function AddPurchaseCredit($arryDetails){
		global $Config;
		extract($arryDetails);
		$IPAddress = GetIPAddress();

		$strSQLQuery = "INSERT INTO p_order SET Module = 'Credit', InvoiceID = '".addslashes($InvoiceID)."',
			Approved = '1', Status = 'Open', Comment = '".addslashes($Comment)."', AccountID = '".addslashes($AccountID)."', SuppCode='".addslashes($SuppCode)."', SuppCompany='".addslashes($SuppCompany)."',  Currency = '".addslashes($ModuleCurrency)."', TotalAmount = '".$TotalAmount."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$PostedDate."',UpdatedDate='".$Config['TodayDate']."', ConversionRate='".addslashes($ConversionRate)."',IPAddress = '". $IPAddress."', PostToGL='1', OverPaid='1' ";		
		$this->query($strSQLQuery, 0);
		$CrID = $this->lastInsertId();		

		/*$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('p_order','Credit',$CrID,'');*/
				
		$CreditIDValue = 'OverPaid'.$CrID;
		$strSQL = "update p_order set CreditID='".$CreditIDValue."' where OrderID='".$CrID."'"; 
		$this->query($strSQL, 0);

		/*********CreditLimit Updation***********/
		$strSQl = "select PaymentTerm from p_supplier WHERE SuppCode='".$SuppCode."'";
		$arrSupp = $this->query($strSQl, 1);			
		if(!empty($arrSupp[0]['PaymentTerm'])){
			$arryTerm = explode("-",$arrSupp[0]['PaymentTerm']);
			$TermDays = (int)trim($arryTerm[1]);
			if($TermDays > 0){
				$sql="UPDATE p_supplier SET CreditLimit=CreditLimit-".$TotalAmount." WHERE SuppCode='".$SuppCode."' and CreditLimit>0";
				$this->query($sql,0);
				$sql2="UPDATE p_supplier SET CreditLimit='0' WHERE SuppCode='".$SuppCode."' and CreditLimit<0";
				$this->query($sql2,0);
			}
		}
		/*****************************************/	 

		return $CrID;
	}


	/****************************************/
	/****************************************/ 
	function VoidTransactionCashReceipt($TransactionID){
		global $Config;	
		$Module = 'AR';	
		$objBankAccount = new BankAccount();
		$ipaddress = GetIPAddress(); 

		if(!empty($TransactionID)){ 			
			/*******ContraTransactionID**********
			$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
			if(empty($ContraTransactionID)){
				$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
			}
			if($ContraTransactionID>0){
				$TransactionID = $TransactionID.','.$ContraTransactionID;
			}
			/**********************************/			 
			$arryTransaction = $this->GetTransactionDataByID('', $TransactionID , '');
			//echo '<pre>';print_r($arryTransaction);exit;
			foreach($arryTransaction as $key=>$values){ //Start foreach					 
				$PaymentModule='';$strInv=''; $strGainLoss='';  $PaymentType='';
				 
				if($values['PaymentType']=='Invoice' && $values['Module']=='AR'){					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Sales'";
					$strInv = " and p.InvoiceID='".$values["InvoiceID"]."' "; 
					$strGainLoss = " and PaymentType in ('AR Gain', 'AR Loss') "; 
				}else if($values['PaymentType']=='Credit' && $values['Module']=='AR'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Sales'";
					$strInv = " and p.CreditID='".$values["CreditID"]."'"; 
				}else if($values['PaymentType']=='CreditAmount' && $values['Module']=='AR'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Sales'";	
					$strInv = " and 1 "; 
				}else if($values['PaymentType']=='GL' && $values['Module']=='AR'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Sales'";	
					$strInv = " and p.GLID='".$values["AccountID"]."'"; 
				}else if($values['PaymentType']=='Contra Invoice' && $values['Module']=='AR'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Purchase'";
					$strInv = " and p.InvoiceID='".$values["InvoiceID"]."' "; 
					$strGainLoss = " and PaymentType in ('AP Gain', 'AP Loss')";
				}else if($values['PaymentType']=='Contra Invoice' && $values['Module']=='AP'){		
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Sales'";
					$strInv = " and p.InvoiceID='".$values["InvoiceID"]."' "; 
					$strGainLoss = " and PaymentType in ('AR Gain', 'AR Loss') ";
				}		 
				/**********************************************/
				if(!empty($PaymentModule) && !empty($PaymentTypeIn) && !empty($strInv)){
					$strSql = "select p.PaymentID from f_payments p WHERE p.PaymentType in(".$PaymentTypeIn.") ".$strInv." and p.PostToGL='Yes' and p.TransactionID in (".$TransactionID.") order by PaymentID Desc limit 0,1"; 					
					$arryPayment = $this->query($strSql, 1);				
					
					 if(!empty($arryPayment[0]['PaymentID'])){
						$PaymentID = $arryPayment[0]['PaymentID'];

						/***********/	
						$strSQLIn = "select IncomeID,ExpenseID from f_payments where PID='".$PaymentID."'";
		        			$arryIncomeExp = $this->query($strSQLIn, 1);			
						if(!empty($arryIncomeExp[0]['IncomeID'])){
						   $delSQLQuery = "delete from f_income where IncomeID = '".$arryIncomeExp[0]['IncomeID']."'"; 
						   $this->query($delSQLQuery, 0);
						}
						if(!empty($arryIncomeExp[0]['ExpenseID'])){
						   $delSQLQuery = "delete from f_expense where ExpenseID = '".$arryIncomeExp[0]['ExpenseID']."'"; 
						   $this->query($delSQLQuery, 0);
						}
						$delSQLPay = "delete from f_payments where PaymentID = '".$PaymentID."' OR PID = '".$PaymentID."'";
						$this->query($delSQLPay, 0);

						if(!empty($strGainLoss)){
						$delSQLLoss = "delete from f_payments where ReferenceNo='".$values["InvoiceID"]."' and PostToGL='Yes' ".$strGainLoss; 
						$this->query($delSQLLoss, 0);
						}
						/***********/	
						switch($PaymentModule){ //update invoice status
							case 'Invoice':							
								$arryStatusUpdate["OrderID"] = $values['OrderID'];	
								$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
								$arryStatusUpdate["SaleID"] = $values["SaleID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];
								$arryStatusUpdate["TotalInvoiceAmount"] = $values["TotalInvoiceAmount"];
								$arryStatusUpdate["TotalOrderAmount"] = $values["TotalAmount"];
								$this->UpdateSalesInvoiceStatus($arryStatusUpdate);
								break;
							case 'Credit':
								$arryStatusUpdate["OrderID"] = $values["OrderID"];
								$arryStatusUpdate["CreditID"] = $values["CreditID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];	
								$arryStatusUpdate["TotalAmount"] = $values["TotalAmount"];
								$this->UpdateCreditMemoStatus($arryStatusUpdate);
								break;

							case 'Contra Invoice':
								$arryStatusUpdate["OrderID"] = $values["OrderID"];
								$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];						 
								$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
								$this->UpdatePoInvoiceStatus($arryStatusUpdate);

								break;
						}
						/***********/	


					}

				}
				/**********************************************/
				$strSQuery = "update f_transaction_data SET Voided='1' where TrID = '".$values['TrID']."'";
                		$this->query($strSQuery, 0);

			}//end foreach

			$strSQLuery = "update f_transaction SET Voided='1' where TransactionID in (".$TransactionID.")";
        		$this->query($strSQLuery, 0);	
		}
		  
		return true;
	}


	/*********************************/
	/*********************************/
 	function UpdateSalesInvoiceStatus($arryStatusUpdate){
		global $Config;
		extract($arryStatusUpdate);
		$objBankAccount = new BankAccount();			
		/*$ConversionRate=1;
		if($ModuleCurrency!=$Config['Currency']){
			$ConversionRate = $ConversionRateTr;
		}*/
		$TotalInvoicePaid = $objBankAccount->GetTotalPaymentInvoice($InvoiceID,'Sales');  
		$TotalInvoicePaid = round($TotalInvoicePaid,2);
		$TotalInvoiceAmount  = round($TotalInvoiceAmount,2); //round(GetConvertedAmount($ConversionRate, $TotalInvoiceAmount),2);
		
 		if($TotalInvoicePaid<=0){
			$InvoicePaid = 'Unpaid';
		}else if($TotalInvoicePaid>=$TotalInvoiceAmount){
			$InvoicePaid = 'Paid';
		}else{
			$InvoicePaid = 'Part Paid';
		}
		

		$strSQLQuery = "update s_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$InvoiceID."' and Module='Invoice' ";
	   	$this->query($strSQLQuery, 0);

		if(!empty($SaleID)){
			$paidOrderAmnt = $objBankAccount->GetTotalPaymentSalesOrder($SaleID);     
			$paidOrderAmnt = round($paidOrderAmnt,2);

			//
			$strSQLSl = "select TotalAmount from s_order where Module='Order' and SaleID='".$SaleID."'";
			$arrySaleAmount = $this->query($strSQLSl, 1);
			$TotalOrderAmount = $arrySaleAmount[0]['TotalAmount'];
			//


			$TotalOrderedAmount  = round($TotalOrderAmount,2);  //round(GetConvertedAmount($ConversionRate, $TotalOrderAmount),2);  
 
			if($paidOrderAmnt >= $TotalOrderedAmount){
				$strSQLQuery = "update s_order set Status = 'Completed' where SaleID='".$SaleID."' and Module='Order' ";
			   	$this->query($strSQLQuery, 0);
			}
		}			
		
		/*******Generate PDF************/
		$objConfigure = new configure();			
		$PdfArray['ModuleDepName'] = "SalesInvoice";
		$PdfArray['Module'] = "Invoice";
		$PdfArray['ModuleID'] = "InvoiceID";
		$PdfArray['TableName'] =  "s_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;					
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/
				 
		return true;
	}
	/*********************************/
	/*********************************/
 	function UpdateCreditMemoStatus($arryStatusUpdate){
		global $Config;
		extract($arryStatusUpdate);
		$objBankAccount = new BankAccount();		
		/*$ConversionRate=1;
		if($ModuleCurrency!=$Config['Currency']){
			$ConversionRate = $ConversionRateTr;
		}*/		                
		 $paidOrderAmnt = $objBankAccount->GetTotalPaymentCredit($CreditID,"Sales");     
		$paidOrderAmnt = round($paidOrderAmnt,2); 	
		$TotalOrderedAmount  = round($TotalAmount,2); //round(GetConvertedAmount($ConversionRate, $TotalAmount),2); 
		
	
		if($paidOrderAmnt<=0){
			$Status = 'Open';
		}else if($paidOrderAmnt >= $TotalOrderedAmount){
			 $Status = 'Completed';
		}else{
			 $Status = 'Part Applied';			
		}			
			
		$strSQL = "update s_order set Status = '". $Status."' where CreditID='".$CreditID."' and Module='Credit' ";
		$this->query($strSQL, 0);


		/*******Generate PDF************/
		$objConfigure = new configure();				
		$PdfArray['ModuleDepName'] = "SalesCreditMemo";
		$PdfArray['Module'] = "Credit";
		$PdfArray['ModuleID'] = "CreditID";
		$PdfArray['TableName'] =  "s_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;	
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/


	 
		return true;
	}
	/*********************************/
	/*********************************/
 	function UpdateCreditMemoAPStatus($arryStatusUpdate){
		global $Config;
		extract($arryStatusUpdate);
		$objBankAccount = new BankAccount();		
		/*$ConversionRate=1;
		if($ModuleCurrency!=$Config['Currency']){
			$ConversionRate = $ConversionRateTr;
		}*/
		                
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentCredit($CreditID,"Purchase");         
		$paidOrderAmnt = round($paidOrderAmnt,2); 	
		$TotalOrderedAmount  = round($VendorTotalAmount,2); //round(GetConvertedAmount($ConversionRate, $VendorTotalAmount),2); 
	
 
		if($paidOrderAmnt<=0){
			$Status = 'Open';
		}else if($paidOrderAmnt >= $TotalOrderedAmount){
			 $Status = 'Completed';
		}else{
			 $Status = 'Part Applied';			
		}			
			
		$strSQL = "update p_order set Status = '". $Status."' where CreditID='".$CreditID."' and Module='Credit' ";
		$this->query($strSQL, 0);	


		/*******Generate PDF************/
		$objConfigure = new configure();			
		$PdfArray['ModuleDepName'] = "PurchaseCreditMemo";
		$PdfArray['Module'] = "Credit";
		$PdfArray['ModuleID'] = "CreditID";
		$PdfArray['TableName'] =  "p_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/

 
		return true;
	}
	/*********************************/
	/*********************************/
 	function UpdatePoInvoiceStatus($arryStatusUpdate){
		global $Config;
		extract($arryStatusUpdate);
		$objBankAccount = new BankAccount();		
		/*$ConversionRate=1;
		if($ModuleCurrency!=$Config['Currency']){
			$ConversionRate = $ConversionRateTr;
		}*/	

		/*if($VendorTransfer == "1" ){
			 $strSQLQuery = "select sum(OriginalAmount) as total from f_transaction_data where InvoiceID='".$InvoiceID."' and PaymentType = 'Invoice' and Module='AP' ";
			$arryRow = $this->query($strSQLQuery, 1);
			$TotalAmountPaid = $arryRow[0]['total'];
		}else{*/	                
			$TotalAmountPaid = $objBankAccount->GetTotalPaymentInvoice($InvoiceID,'Purchase');  
		//}


		$TotalAmountPaid = round($TotalAmountPaid,2); 	
		$TotalInvoiceAmount  = round($VendorTotalAmount,2); 	//round(GetConvertedAmount($ConversionRate, $VendorTotalAmount),2);				 
		
		/******Negative Invoice Amount*********/
		if($TotalInvoiceAmount<0){
			$TotalInvoiceAmount = abs($TotalInvoiceAmount);
			$TotalAmountPaid = abs($TotalAmountPaid);
		}
		/******************/

		if($TotalAmountPaid<=0){
			$InvoicePaid = 0;
		}else if($TotalAmountPaid>=$TotalInvoiceAmount){
			$InvoicePaid = 1;
		}else{
			$InvoicePaid = 2;
		}

		$strSQLQuery = "update p_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$InvoiceID."' and Module='Invoice' ";
	   	$this->query($strSQLQuery, 0);	

		/*******Generate PDF************/
		$objConfigure = new configure();			
		$PdfArray['ModuleDepName'] = "PurchaseInvoice";
		$PdfArray['Module'] = 'Invoice';
		$PdfArray['ModuleID'] = 'InvoiceID';
		$PdfArray['TableName'] =  "p_order";
		$PdfArray['OrderColumn'] =  "OrderID";
		$PdfArray['OrderID'] =  $OrderID;		 	
		$objConfigure->GeneratePDF($PdfArray);
		/*******************************/ 
 
		return true;
	}


	/****************************************/
	/****************************************/ 
	function VoidTransactionVendorPayment($TransactionID){
		global $Config;	
		$Module = 'AP';	
		$objBankAccount = new BankAccount();
		$ipaddress = GetIPAddress(); 

		if($TransactionID>0){ 			
			/*******ContraTransactionID**********
			$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
			if(empty($ContraTransactionID)){
				$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
			}
			if($ContraTransactionID>0){
				$TransactionID = $TransactionID.','.$ContraTransactionID;
			}
			/**********************************/			 
			$arryTransaction = $this->GetTransactionDataByID('', $TransactionID , '');
			//echo '<pre>';print_r($arryTransaction);exit;
			foreach($arryTransaction as $key=>$values){ //Start foreach					 
				$PaymentModule='';$strInv=''; $strGainLoss='';  $PaymentType='';
				 
				if($values['PaymentType']=='Invoice' && $values['Module']=='AP'){					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Purchase'";
					$strInv = " and p.InvoiceID='".$values["InvoiceID"]."' "; 
					$strGainLoss = " and PaymentType in ('AP Gain', 'AP Loss') "; 
				}else if($values['PaymentType']=='Credit' && $values['Module']=='AP'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Purchase'";
					$strInv = " and p.CreditID='".$values["CreditID"]."'"; 
				}else if($values['PaymentType']=='CreditAmount' && $values['Module']=='AP'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Purchase'";	
					$strInv = " and 1 "; 
				}else if($values['PaymentType']=='GL' && $values['Module']=='AP'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Purchase'";	
					$strInv = " and p.GLID='".$values["AccountID"]."'"; 
				}else if($values['PaymentType']=='Contra Invoice' && $values['Module']=='AP'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Sales'";
					$strInv = " and p.InvoiceID='".$values["InvoiceID"]."' "; 
					$strGainLoss = " and PaymentType in ('AR Gain', 'AR Loss')";
				}else if($values['PaymentType']=='Contra Invoice' && $values['Module']=='AR'){
					$PaymentModule = $values['PaymentType'];
					$PaymentTypeIn = "'Purchase'";
					$strInv = " and p.InvoiceID='".$values["InvoiceID"]."' "; 
					$strGainLoss = " and PaymentType in ('AP Gain', 'AP Loss') "; 
				}				 
				/**********************************************/
				if(!empty($PaymentModule) && !empty($PaymentTypeIn) && !empty($strInv)){
					$strSql = "select p.PaymentID from f_payments p WHERE p.PaymentType in(".$PaymentTypeIn.") ".$strInv." and p.PostToGL='Yes' and p.TransactionID in (".$TransactionID.") order by PaymentID Desc limit 0,1"; 					$arryPayment = $this->query($strSql, 1);				
					$PaymentID = $arryPayment[0]['PaymentID'];
					 if($PaymentID>0){
						/***********/	
						$strSQLIn = "select IncomeID,ExpenseID from f_payments where PID='".$PaymentID."'";
		        			$arryIncomeExp = $this->query($strSQLIn, 1);			
						if($arryIncomeExp[0]['IncomeID']>0){
						   $delSQLQuery = "delete from f_income where IncomeID = '".$arryIncomeExp[0]['IncomeID']."'"; 
						   $this->query($delSQLQuery, 0);
						}
						if($arryIncomeExp[0]['ExpenseID']>0){
						   $delSQLQuery = "delete from f_expense where ExpenseID = '".$arryIncomeExp[0]['ExpenseID']."'"; 
						   $this->query($delSQLQuery, 0);
						}
						$delSQLPay = "delete from f_payments where PaymentID = '".$PaymentID."' OR PID = '".$PaymentID."'";
						$this->query($delSQLPay, 0);

						if(!empty($strGainLoss)){
						$delSQLLoss = "delete from f_payments where ReferenceNo='".$values["InvoiceID"]."' and PostToGL='Yes' ".$strGainLoss; 
						$this->query($delSQLLoss, 0);
						}
						/***********/	
						switch($PaymentModule){ //update invoice status
							case 'Invoice':	
								$arryStatusUpdate["OrderID"] = $values["OrderID"];
								$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];						 
								$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
								$this->UpdatePoInvoiceStatus($arryStatusUpdate);
   								break;
							case 'Credit':
								$arryStatusUpdate["OrderID"] = $values["OrderID"];			
								$arryStatusUpdate["CreditID"] = $values["CreditID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];	
								$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
								$this->UpdateCreditMemoAPStatus($arryStatusUpdate);
								break;

							case 'Contra Invoice':
								$arryStatusUpdate["OrderID"] = $values['OrderID'];
								$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
								$arryStatusUpdate["SaleID"] = $values["SaleID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["ModuleCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];
								$arryStatusUpdate["TotalInvoiceAmount"] = $values["TotalInvoiceAmount"];
								$arryStatusUpdate["TotalOrderAmount"] = $values["TotalAmount"];
								$this->UpdateSalesInvoiceStatus($arryStatusUpdate);
								break;
						}
						/***********/	


					}

				}
				/**********************************************/
				$strSQuery = "update f_transaction_data SET Voided='1' where TrID = '".$values['TrID']."'";
                		$this->query($strSQuery, 0);

			}//end foreach

			$strSQLuery = "update f_transaction SET Voided='1' where TransactionID in (".$TransactionID.")";
        		$this->query($strSQLuery, 0);	
		}
		 
		return true;
	}
	/*********************************/
	/*********************************/
	function  addCreditAmountTransaction($transaction_id,$arryDetails){

		global $Config;		
		$objBankAccount = new BankAccount();		 
		$ipaddress = GetIPAddress();			
		
		if($arryDetails[0]['AutoReceipt']>0){ //Auto Receipt				
			$arrySessTransaction = $arryDetails;
			extract($arryDetails[0]);
			
			$total_saved_payment = $Amount;
			$ReceivedAmount  = $Amount;
			$CustomerName = $CustID;
			//$ReferenceNo = $CustomerPO; //Need to pick InvoiceID			
			$Date = $PostToGLDate;//$InvoiceDate;				
			$Comment = $InvoiceComment;
			$Method = $PaymentMethod;
			if($arryDetails[0]['AutoReceipt']==1){
				$AddPaymentSql = " ,PostToGL = 'Yes',PostToGLDate='".$PostToGLDate."'";
			}
		}else{  //Cash Receipt
			extract($arryDetails);
			$arrySessTransaction = $this->ListSessionTransaction('AR',$TransactionID,'CreditAmount');
			$AddPaymentSql = '';
			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];
		}
	 
		//echo '<pre>'; print_r($arrySessTransaction);exit;
		$totalNum = sizeof($arrySessTransaction);			
		/********************/
		if($totalNum>0 && $total_saved_payment!='' && $ReceivedAmount!=''){
				
			if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}

			/********************/				 			
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AR');	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	
		
			
                          foreach($arrySessTransaction as $key=>$values){
	
				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['CustID'].'#Credit');

		
		
                          if($values['Amount'] != ''){                        
				 				
 				/*****Debit Payment*****/
                                 $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$transaction_id."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  DebitAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',   Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$AddPaymentSql.$BankCurrencySql;
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Credit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  CreditAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountReceivable."',  CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C'".$AddPaymentSql;

                                $this->query($strSQLQuery, 0);							
				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);	

			
				/*****Update Credit Status********/
				$Amount = -$values['Amount'];
				$sql="UPDATE s_customers SET CreditAmount=CreditAmount-".$Amount." WHERE Cid='".$values['CustID']."' ";
				$this->query($sql,0);
				$sql2="UPDATE s_customers SET CreditAmount='0' WHERE Cid='".$values['CustID']."' and CreditAmount<0";
				$this->query($sql2,0);
								
				/*******************************/	

                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}


	 
	/*********************************/
	/*********************************/
	function  addAPCreditAmountTransaction($transaction_id,$arryDetails){

		global $Config;		
		$objBankAccount = new BankAccount();		 
		$ipaddress = GetIPAddress();			
			 
		extract($arryDetails);
		$arrySessTransaction = $this->ListSessionTransaction('AP',$TransactionID,'CreditAmount');
		$AddPaymentSql = '';
		 
		
		//echo '<pre>'; print_r($arrySessTransaction);exit;
		$totalNum = sizeof($arrySessTransaction);			
		/********************/
		if($totalNum>0 && $total_saved_payment!='' && $PaidAmount!=''){
				

			$ModuleCurrency = $arrySessTransaction[0]['ModuleCurrency'];

if($transaction_id>0 && $ModuleCurrency!=''){
				$strSQuery = "update f_transaction SET ModuleCurrency='".$ModuleCurrency."' where TransactionID = '".$transaction_id."'";
	                	$this->query($strSQuery, 0);
			}

			/********************/				 			
			if(!empty($ModuleCurrency) && $ModuleCurrency!=$Config['Currency']){
				$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $ModuleCurrency, 'AR');	
				$BankCurrencySql = " ,BankCurrency = '".$ModuleCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
			}			
                        /********************/	
		
			
                          foreach($arrySessTransaction as $key=>$values){
	
				$ReferenceNoVal = (!empty($ReferenceNo))?($ReferenceNo):($values['SuppCode'].'#Credit');

		
		
                          if($values['Amount'] != ''){                        
				 				
 				/*****Credit  Payment*****/
                                 $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$transaction_id."', SuppCode = '".$values['SuppCode']."',   CreditAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',  Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['ModuleCurrency']."' , OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='C' ".$AddPaymentSql.$BankCurrencySql;
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 
				/*****Debit Payment*****/
                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  DebitAmnt = ENCODE('" .$values['Amount']. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."',  SuppCode = '".$values['SuppCode']."',  ReferenceNo = '".addslashes($ReferenceNoVal)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',  Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['ModuleCurrency']."', OriginalAmount=ENCODE('".$values['OriginalAmount']. "','".$Config['EncryptKey']."'), TransactionType='D' ".$AddPaymentSql;

                                $this->query($strSQLQuery, 0);							
				/*****Update TransactionID********/	
				$strSQuery = "update f_transaction_data SET TransactionID='".$transaction_id."' where TrID = '".$values['TrID']."'";
		                $this->query($strSQuery, 0);	

			
				/*****Update Credit Status********/
				$Amount = -$values['Amount'];
				$sql="UPDATE p_supplier SET CreditAmount=CreditAmount-".$Amount." WHERE SuppCode='".$values['SuppCode']."' ";
				$this->query($sql,0);
				$sql2="UPDATE p_supplier SET CreditAmount='0' WHERE SuppCode='".$values['SuppCode']."' and CreditAmount<0";
				$this->query($sql2,0);
								
				/*******************************/	

                            }
                        
                        
                        }//end foreach

		   }//end if
                        
			return $TransactionID;
                         
		}


	/*********************************/
	/*********************************/
	function GetPaymentDataByID($TransactionID,$CheckNumber,$PaymentType){			
 	 	
			if(!empty($TransactionID)) $strAddQuery .= " and pt.TransactionID in (".$TransactionID.") ";
			if(!empty($PaymentType)) $strAddQuery .= " and pt.PaymentType='".$PaymentType."' ";
			if(!empty($CheckNumber)) $strAddQuery .= " and pt.CheckNumber='".$CheckNumber."' ";
			
			 #$strSQLQuery = "select t.*,o.InvoiceDate,o.InvoiceEntry,o.CustCode, o.SaleID, o.TotalInvoiceAmount, o.CustomerCurrency, o.TotalAmount, o.OrderSource, o.CustomerPO, p.TotalAmount as VendorTotalAmount, p.PostedDate,p.InvoiceEntry as PInvoiceEntry, p.ExpenseID,p.PurchaseID, p.Currency, b.RangeFrom, b.RangeTo, b.AccountNumber, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,s.CompanyName as VendorName from f_transaction_data t left outer join s_order o on (t.OrderID=o.OrderID and t.CustID=o.CustID) left outer join p_order p on (t.OrderID=p.OrderID and t.SuppCode=p.SuppCode ) left outer join f_account b on b.BankAccountID = t.AccountID left outer join s_customers c on t.CustID=c.Cid left outer join p_supplier s on  t.SuppCode =  s.SuppCode where 1 ".$strAddQuery." and t.Deleted='0' order by TrID Asc"; 

			 $strSQLQuery = "select distinct(pt.PaymentID), pt.*, o.Currency as OrderCurrency , o.TotalAmount as VendorTotalAmount from f_payments pt left outer join p_order o on (pt.OrderID=o.OrderID and pt.SuppCode=o.SuppCode ) where 1 ".$strAddQuery." order by PaymentID Asc"; 

			
			return $this->query($strSQLQuery, 1);		

	}
	/****************************************/
	/****************************************/ 
	function VoidCheckVendorPayment55555($TransactionID,$CheckNumber){
		global $Config;	
		$Module = 'AP';	
		$objBankAccount = new BankAccount();
		$ipaddress = GetIPAddress(); 

		if($TransactionID>0 && !empty($CheckNumber)){ 			
			/*******ContraTransactionID**********/
			$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
			if(empty($ContraTransactionID)){
				$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
			}
			if($ContraTransactionID>0){
				$TransactionID = $TransactionID.','.$ContraTransactionID;
			}
			/**********************************/	
			 //echo $TransactionID.'#'.$CheckNumber;exit;
			$arryTransaction = $this->GetPaymentDataByID($TransactionID , $CheckNumber, 'Purchase');
			//echo '<pre>';print_r($arryTransaction);exit;	
			foreach($arryTransaction as $key=>$values){ //Start foreach					 
				$PaymentModule='';$strInv=''; $strGainLoss='';  $PaymentType='';
				$CreditAmountRef = $values['SuppCode'].'#Credit';
				$PaymentID = $values['PaymentID'];
				if(!empty($values['InvoiceID'])){
					$PaymentModule = 'Invoice';
					$strGainLoss = " and PaymentType in ('AP Gain', 'AP Loss') "; 
				}else if(!empty($values['CreditID'])){
					$PaymentModule = 'Credit';
				}else if($values['ReferenceNo']==$CreditAmountRef){
					$PaymentModule = 'CreditAmount';					 
				}elseif(!empty($values['GLID'])){
					$PaymentModule = 'GL';			
					 
				} 				 
				/**********************************************/
				if(!empty($PaymentModule)){									
					
					 if($PaymentID>0){
						/***********/	
						$strSQLIn = "select IncomeID,ExpenseID from f_payments where PID='".$PaymentID."'";
		        			$arryIncomeExp = $this->query($strSQLIn, 1);			
						if($arryIncomeExp[0]['IncomeID']>0){
						   $delSQLQuery1 = "delete from f_income where IncomeID = '".$arryIncomeExp[0]['IncomeID']."'"; 
						   $this->query($delSQLQuery1, 0);
						}
						if($arryIncomeExp[0]['ExpenseID']>0){
						   $delSQLQuery2 = "delete from f_expense where ExpenseID = '".$arryIncomeExp[0]['ExpenseID']."'"; 
						   $this->query($delSQLQuery2, 0);
						}
						$delSQLQuery3 = "delete from f_payments where PaymentID = '".$PaymentID."' OR PID = '".$PaymentID."'";
						$this->query($delSQLQuery3, 0);

						if(!empty($strGainLoss) && $PaymentModule=='Invoice'){
						$delSQLQuery4 = "delete from f_payments where ReferenceNo='".$values["InvoiceID"]."' and PostToGL='Yes' ".$strGainLoss; 
						$this->query($delSQLQuery4, 0);
						}
						/***********/	
						switch($PaymentModule){ //update invoice status
							case 'Invoice':	
								$arryStatusUpdate["InvoiceID"] = $values["InvoiceID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["OrderCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];						 
								$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
								$this->UpdatePoInvoiceStatus($arryStatusUpdate);
   								break;
							case 'Credit':
								$arryStatusUpdate["OrderID"] = $values["OrderID"];			
								$arryStatusUpdate["CreditID"] = $values["CreditID"];
								$arryStatusUpdate["ModuleCurrency"] = $values["OrderCurrency"];
								$arryStatusUpdate["ConversionRateTr"] = $values["ConversionRate"];	
								$arryStatusUpdate["VendorTotalAmount"] = $values["VendorTotalAmount"];
								$this->UpdateCreditMemoAPStatus($arryStatusUpdate);
								break;
 
						}
						/***********/	


					}

				}
				/**********************************************/
				if($values['TrID']>0){
					$strSQuery = "update f_transaction_data SET Voided='1' where TrID = '".$values['TrID']."'";
                			$this->query($strSQuery, 0);
				}

				print_r($arryStatusUpdate).'-----------<br>';
				#echo '<br>'.$delSQLQuery1.'<br>'.$delSQLQuery2.'<br>'.$delSQLQuery3.'<br>'.$delSQLQuery4.'<br>==============================<br>';
				


			}//end foreach

			$strSQLuery = "update f_transaction SET Voided='1' where TransactionID in (".$TransactionID.")";
        		$this->query($strSQLuery, 0);	
			exit;
		}
		 
		return true;
	}


	/*****************************************/	
	function  UpdateDataGLCashReceipt5555(){
		global $Config;		
 		 
	 	$PaymentDate = '2017-01-01';
		/********Void Amount Reverse for ***********/
		$strSql = "select p.PaymentID, p.AccountID,p.TransactionID, DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmount, td.Amount as TDAmount from f_payments p inner join f_transaction_data td on (p.TransactionID = td.TransactionID and td.PaymentType='GL' and td.Module='AR' and td.AccountID>'0' and p.GLID=td.AccountID) inner join f_account b on b.BankAccountID = p.AccountID where p.TransactionID>'0' and p.AccountID>'0' and p.GLID>'0' and  p.PaymentDate>='".$PaymentDate."' and p.PaymentType='Sales'  and p.PostToGL='Yes' and b.BankFlag='1' and td.Amount<0 having DebitAmount!='0' order by p.PaymentID asc"; //check for bank account for negative debit amount
		$arryDebit = $this->query($strSql, 1);
		if($_GET['d']==1){pr($arryDebit);exit;	}
		exit;

		foreach($arryDebit as $key=>$values){ //Start
			if(!empty($values['AccountID'])){					
				#$strSql2 = "select p.* from f_payments p inner join f_account b on b.BankAccountID = p.AccountID where p.PID='".$values["PaymentID"]."' and b.BankFlag!=1 and RangeFrom in ('6000','8000') ";  //check for expnse account credit

				$strSql2 = "select p.PaymentID, DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmount from f_payments p inner join f_account b on b.BankAccountID = p.AccountID where p.PID='".$values["PaymentID"]."' and b.BankFlag!='1' ";  //check for negative credit amount
				$arryCredit = $this->query($strSql2, 1);
				$DebitAccount = $values['PaymentID'];
				$CreditAccount = $arryCredit[0]['PaymentID'];
		
			 	
				if($DebitAccount>0 && $CreditAccount>0){
					$TotalAmount = $values['TDAmount'];
					$TotalAmount = str_replace("-","",$TotalAmount);

					/*****Debit Payment*****/
					$strSQLQuery = "update f_payments set DebitAmnt = ENCODE($TotalAmount,'".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."') WHERE PaymentID ='".$CreditAccount."' ";
					$this->query($strSQLQuery, 0);
					/*****Credit Payment*****/
					$strSQLQuery2 = "update f_payments set CreditAmnt = ENCODE($TotalAmount,'".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."') WHERE PaymentID ='".$DebitAccount."' ";
					$this->query($strSQLQuery2, 0);

					echo '<br>'.$DebitAccount.'#'.$CreditAccount.' : '.$values['TransactionID']; exit;	
			       		
					 
				}
			
			   /*****************************/
			}

		} 
		
	}
	/*****************************************/
	/********************************************************************/
	/**************************************/
/**************************************/
function ARCreditMemoPostToGLDummy555($OrderID,$arryPostData){
		global $Config;
		extract($arryPostData);		 

		if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		}    
		$Date = $PostToGLDate;
		$ipaddress = GetIPAddress(); 

		$addsql = " and s.CreditID='CRD114188' ";

		$strSQLQuery = "SELECT s.*, inv.OrderID as InvOrderID from s_order s inner join s_order inv on (s.InvoiceID=inv.InvoiceID and inv.Module='Invoice' and s.InvoiceID!='') where s.Module='Credit' and inv.OrderID>'0' and s.PostToGL = '1' ".$addsql." order by s.OrderID asc";
		$arryRow = $this->query($strSQLQuery, 1);
		//echo '<pre>';print_r($arryRow);exit;
		foreach($arryRow as $key => $values) {
			$Date = $values['PostToGLDate'];
			$OrderID = $values['OrderID'];
			$InvOrderID = $values['InvOrderID'];
			$TotalAmount = $values['TotalAmount'];
			$OriginalAmount = $TotalAmount ;
			$AccountID = $values['AccountID'];
			$EntryBy = $values['EntryBy']; //C for Cron
			$OrderSource = strtolower($values['OrderSource']);
			$PaymentType = 'Customer Credit Memo';
			if($TotalAmount>0 && $values['CustomerCurrency']!=$Config['Currency']){
				$ConversionRate=$values['ConversionRate'];		
			}
			if(empty($ConversionRate)) $ConversionRate=1;
	
			

 

		/**************************************/
		/**************************************/
		if(!empty($AccountReceivable) && !empty($SalesReturn) && $TotalAmount>0){
			/*****************/
				
			$TotalCost = 0;$TotalRevenue = 0;

			if(empty($AccountID) && $InvOrderID>0){ //Invoice must exist to calculate Total Cost
				// Get Cost of Goods and Revenenue
				$strSQL = "SELECT i.sku, i.qty, i.item_id, i.SerialNumbers, i.`Condition`,i.DropshipCheck  from s_order_item i where i.OrderID = '".trim($OrderID)."' "; //credit memo
				$arryItem = $this->query($strSQL, 1);
		//pr($arryItem);die;
				foreach($arryItem as $valuesitem){	
					$ItemCost = 0; 
					 
					/***************/
					if($valuesitem['DropshipCheck']=='1'){ //dropship
						 $ItemCost = 0; 
					}else if(!empty($valuesitem['sku']) && !empty($valuesitem['Condition']) && empty($valuesitem['SerialNumbers'])){ //avgCost from invoice
						$strS = "SELECT avgCost from s_order_item  where OrderID = '".trim($InvOrderID)."' and `sku` = '".$valuesitem['sku']."' and `Condition`='".$valuesitem['Condition']."' and avgCost>'0' and parent_item_id='0' ";
						$arryInvItem = $this->query($strS, 1);
						$ItemCost = $arryInvItem[0]['avgCost'];
					}else if(!empty($valuesitem['sku']) && !empty($valuesitem['Condition']) && !empty($valuesitem['SerialNumbers'])){ //UnitCost from inv_serial_item	
						$SerialNumberArray = explode(",", $valuesitem['SerialNumbers']);
						$NumSL = sizeof($SerialNumberArray);						
						$TotalUnitCost=0;	
						foreach($SerialNumberArray as $Slno){	
							$SerialNo = trim($Slno);	
							if(!empty($SerialNo)){			
								 $strS = "SELECT UnitCost FROM `inv_serial_item` WHERE `serialNumber` = '".$SerialNo."' AND `Sku` = '".$valuesitem['sku']."' AND `Condition`='".$valuesitem['Condition']."' and OrderID='".$InvOrderID."' ";
								$arrySerial = $this->query($strS, 1); 
						
								$TotalUnitCost += $arrySerial[0]['UnitCost'];
							}	
						}

						$ItemCost = round(($TotalUnitCost/$NumSL),2);					
					}
					/***************/
					$TotalCost += ($ItemCost*$valuesitem['qty']);
			
					/***Update Stock****/
					if($valuesitem['qty']>0){
						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$valuesitem['sku']. "' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);

						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$valuesitem['qty'] . "  where Sku='" .$valuesitem['sku']. "' ";
						$this->query($UpdateQtysql, 0);

					
					}
					/******************/
				}





			}
			
				/*****************/
				$taxAmnt = $values['taxAmnt'];  
				$Freight = $values['Freight']; 
				//$TDiscount = $values['TDiscount'];   
				$SubTotal = $TotalAmount - $Freight - $taxAmnt;				
				$OriginalSubTotal = $SubTotal;
				$OriginalTotalCost = round($TotalCost,2);
				if($values['CustomerCurrency']!=$Config['Currency']){				
					$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount); 
					$SubTotal = GetConvertedAmount($ConversionRate, $SubTotal);  
					$Freight = GetConvertedAmount($ConversionRate, $Freight);   
					//$TDiscount = $ConversionRate * $TDiscount;
					$taxAmnt = GetConvertedAmount($ConversionRate, $taxAmnt);
					$TotalCost = GetConvertedAmount($ConversionRate, $TotalCost);  
				}	
			
				$TotalCost = round($TotalCost,2);
				 

				$SalesReturnAmount = $TotalAmount;
				$ARAmount = $TotalAmount;
			
				 



				/**************************************/
				if($Config['TrackInventory']==1 && empty($AccountID)){//start TrackInventory
					 $SalesReturnAmount = $SubTotal;
					 $OriginalAmount = $OriginalSubTotal;					
					

					if($OriginalTotalCost>0){

$strInv= "select p.PaymentID,p.PaymentDate from f_payments p where ReferenceNo='".$values['CreditID']."' and  CustCode = '".$values['CustCode']."' and PaymentType='".$PaymentType."' and AccountID = '".$InventoryAR."' "; 
$arryInv = $this->query($strInv, 1);
$invPaymentID = $arryInv[0]['PaymentID'];

$strCost= "select p.PaymentID,p.PaymentDate from f_payments p where ReferenceNo='".$values['CreditID']."' and  CustCode = '".$values['CustCode']."' and PaymentType='".$PaymentType."' and AccountID = '".$CostOfGoods."' "; 
$arryCost = $this->query($strCost, 1);
$costPaymentID = $arryCost[0]['PaymentID'];

	
				
	if(empty($invPaymentID) && empty($costPaymentID)){
echo $values['CreditID'].'#<br>';
						//Debit Total Cost to Inventory
						$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  SaleID = '".$values['SaleID']."', CreditID='".$values['CreditID']."',   DebitAmnt = ENCODE('".$OriginalTotalCost."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAR."', ReferenceNo='".$values['CreditID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='D' ";

						if($_GET['ab']==1)$this->query($strSQLQuery, 1);	

						//Credit  Total Cost to Cost of goods					 
						$strSQLQueryCost = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',  CreditAmnt = ENCODE('".$OriginalTotalCost."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$values['CreditID']."', CreditID='".$values['CreditID']."', AccountID = '".$CostOfGoods."',  CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['CustomerCurrency']."', OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='C'  ";  

						
						if($_GET['ab']==1) $this->query($strSQLQueryCost, 0); 

						echo $strSQLQuery.'<br>'.$strSQLQueryCost; die;
	}else{
		#echo $invPaymentID.'<br>'.$costPaymentID; die;
	}



					}

		
					
				 
				}//end TrackInventory
				/**************************************/
 

			}
			 
			
		 
			}
			 
			
		}


/**************************************/
/*************CreditCard*****************/
	function SaveTransactionCreditCard($transaction_id, $arryDetails){  
			global $Config;
			extract($arryDetails);

			if(isset($Method)){
				if($Method=='Credit Card' && $CardCharge=='1' && !empty($CardNumber) && !empty($CardType)){
					$arryCard = $this->GetTransactionCreditCard($transaction_id);

					$addsql = " SET CardID='".$CreditCardID."', CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."'), CardType='".$CardType."', CardHolderName='".$CardHolderName."', ExpiryMonth='".$ExpiryMonth."', ExpiryYear='".$ExpiryYear."', Address='".$CreditAddress."' ,  City = '".$CreditCity."', Country = '".$CreditCountry."', State = '".$CreditState."', ZipCode = '".$CreditZipCode."',  SecurityCode = '".$SecurityCode."'  ";

				
					if(!empty($arryCard[0]['ID'])){
						$sql = "UPDATE s_order_card ".$addsql." where ID='".$arryCard[0]['ID']."'";				$this->query($sql, 0);
					}else{
						$sql = "INSERT INTO s_order_card ".$addsql." , TransactionID='".$transaction_id."' ";
						$this->query($sql, 0);
						$ID = $this->lastInsertId();
					}
					 
				}else{
					$this->RemoveTransactionCreditCard($transaction_id);
				}
			}
			return true;

		}
		function  GetTransactionCreditCard($TransactionID){
			global $Config;
			if(!empty($TransactionID)){
				$strSQLQuery = "select c.*, DECODE(c.CardNumber,'". $Config['EncryptKey']."') as CardNumber  from s_order_card c where c.TransactionID='".$TransactionID."' and c.CardNumber!='' and c.CardType!=''";			
				return $this->query($strSQLQuery, 1);
			}
		}	
		function  RemoveTransactionCreditCard($TransactionID){
			if(!empty($TransactionID)){
				$strSQLQuery = "delete from s_order_card  where TransactionID='".$TransactionID."'";			
				return $this->query($strSQLQuery, 0);
			}
		}
		function  GetTransactionByID($TransactionID){
			global $Config;
			if(!empty($TransactionID)){
				$strSQLQuery = "select t.*, DECODE(t.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, DECODE(t.OriginalAmount,'". $Config['EncryptKey']."') as OriginalAmount from f_transaction t where  t.TransactionID='".$TransactionID."' "; 
				return $this->query($strSQLQuery, 1);
			}
		}

		function isCardTransactionExist($TransID,$PaymentTerm=''){
			if(!empty($PaymentTerm)) $AddSql = " and PaymentTerm='".$PaymentTerm."' ";
			 $strSQLQuery = "select ID from s_order_transaction where TransID='".$TransID."' ".$AddSql." limit 0,1 "; 
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ID'])) {
				return true;
			} else {
				return false;
			}
		}

		function GetCardTransaction($TransID,$PaymentTerm=''){
			 
			if(!empty($TransID)){		 
			 $strSQLQuery = "select t.*,p.ProviderName from s_order_transaction t inner join f_transaction o on t.TransID=o.TransactionID left outer join f_payment_provider p on t.ProviderID=p.ProviderID where t.TransID='".$TransID."' and t.PaymentTerm='".$PaymentTerm."'  order by ID desc"; 
			return $this->query($strSQLQuery, 1);
			}			 
		}	

		function GetUnrefundCardTransaction($TransID,$TransactionType,$PaymentTerm){
			global $Config;
			if(!empty($TransID)){		 
		 		$strSQLQuery = "select t.*, DECODE(t.CardNumber,'". $Config['EncryptKey']."') as CardNumber from s_order_transaction t   where t.TransID='".$TransID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."' and RefundedAmount<TotalAmount order by t.ID asc "; 
				return $this->query($strSQLQuery, 1);
			}
		
		}

		function GetCardTransactionTotal($TransID,$TransactionType,$PaymentTerm){			 
		if(!empty($TransID)){		 
		 $strSQLQuery = "select sum(TotalAmount) as FullAmount from s_order_transaction t   where t.TransID='".$TransID."' and t.TransactionType='".$TransactionType."'  and t.PaymentTerm='".$PaymentTerm."' "; 
		$arryRow =  $this->query($strSQLQuery, 1);
		return $arryRow[0]['FullAmount'];
		}
		
	}


/**************************************/
/**************************************/

	/************************/
	function CreditCardGLVendorDataUpdate($arryPostData){ 
		global $Config;	
		extract($arryPostData);	 
		$p3select = ",p3.OrderID as ChildOrderID,p3.CreditID as ChildCreditID,p3.TotalAmount as ChildTotalAmount, p3.PostToGL ,p3.Status,p3.SuppCode as ChildSuppCode,p3.PostToGlDate";
		$p3sql = "inner join p_order p3 on (p.InvoiceID=p3.Comment and p3.Comment!='' and p3.Module='Credit' and p2.CreditCardVendor=p3.SuppCode and p3.PaymentTerm='Credit Card' and p3.Parent='0' and p3.AccountID='1')";

		$whereSql = " and p3.CreditID='CRD3421' ";
		 

		$strSQLQuery = "SELECT p.OrderID, p.CreditID, p.TotalAmount, p2.OrderID as InvOrderID,p2.PaymentTerm as InvPaymentTerm,p2.CreditCardVendor as InvCreditCardVendor,p2.TotalAmount as InvTotalAmount ".$p3select." from p_order p  inner join p_order p2 on (p.InvoiceID=p2.InvoiceID and p2.Module='Invoice' and p.InvoiceID!='' and p2.PaymentTerm='Credit Card' and p2.CreditCardVendor!='') ".$p3sql." where p.Module='Credit' and p.PostToGL = '1' and p.PurchaseID != '1' and p.ReturnID!='' ".$whereSql." order by p.OrderID asc "; 	
		$arryRow = $this->query($strSQLQuery, 1);

		//update payment term, parent and TotalAmount
		echo '<pre>';print_r($arryRow);exit;
		foreach($arryRow as $key => $values) {
			 
			if($values["Status"]=="Open" && round($values["TotalAmount"],2)!=round($values["ChildTotalAmount"],2)){ //Open and credit amount is wrong
				//pr($values);				
				/***************/
				$sqlDebit = "select PaymentID from f_payments where OrderID='".$values["ChildOrderID"]."' and PaymentType='Vendor Credit Memo' and SuppCode='".$values["ChildSuppCode"]."' and AccountID='".$AccountPayable."' order by PaymentID desc limit 0,1";				 
				$arryDebit = $this->query($sqlDebit, 1);
				if($arryDebit[0]["PaymentID"]>0){
					$sqlCredit = "select PaymentID from f_payments where OrderID='".$values["ChildOrderID"]."' and PaymentType='Vendor Credit Memo' and SuppCode='".$values["ChildSuppCode"]."' and PID='".$arryDebit[0]["PaymentID"]."' order by PaymentID desc limit 0,1";				 
					$arryCredit = $this->query($sqlCredit, 1);
					if($arryCredit[0]["PaymentID"]>0){
						/******Debit AP***********/
						$strSQLDb = "update f_payments set DebitAmnt  = ENCODE('".$values["TotalAmount"]."','".$Config['EncryptKey']."'), OriginalAmount=ENCODE('".$values["TotalAmount"]. "','".$Config['EncryptKey']."'), ReferenceNo='".$values["ChildCreditID"]."', CreditID='".$values["ChildCreditID"]."'  WHERE PaymentID ='".$arryDebit[0]["PaymentID"]."' ";
						$this->query($strSQLDb, 0);  

						/******Credit AP***********/
						$strSQLCr = "update f_payments set CreditAmnt  = ENCODE('".$values["TotalAmount"]."','".$Config['EncryptKey']."'), OriginalAmount=ENCODE('".$values["TotalAmount"]. "','".$Config['EncryptKey']."'), ReferenceNo='".$values["ChildCreditID"]."', CreditID='".$values["ChildCreditID"]."',AccountID='".$AccountPayable."'  WHERE PaymentID ='".$arryCredit[0]["PaymentID"]."' ";
						$this->query($strSQLCr, 0);
						 
					}
					 
				}
				/***************/				
				$strSql = "update p_order set PaymentTerm='', Parent='".$values["OrderID"]."',TotalAmount='".$values["TotalAmount"]."' where OrderID='".$values["ChildOrderID"]."'";			
				$this->query($strSql, 0); 
				/***************/

				echo $strSql.'<br>'.$strSQLDb.'<br>'.$strSQLCr.'<br><br><br><br>';die;
			}else{
				#echo 'No';
			}
		}
	
	}



}

?>
