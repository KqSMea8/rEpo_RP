<?
class agrinde extends dbClass
{ 

	var $tables;
	
	function agrinde(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}
	/*************update Email for Agrinde****************/
	function UpdateEmailAgrinde456456($CmpID){ 
		global $Config;
		
		/******Company OK*********/
		/***********************/
		$AdminEmail = str_replace("@","1@",$_SESSION['AdminEmail']);
		$SQLA1 = "update ".$Config['DbMain'].".user_email set Email = '".$AdminEmail."' where CmpID ='".$CmpID."' and RefID='0' and Email = '".$_SESSION['AdminEmail']."' ";
		$SQLA2 = "update ".$Config['DbMain'].".company set Email = '".$AdminEmail."' where CmpID ='".$CmpID."' and Email = '".$_SESSION['AdminEmail']."' ";	
		
		$this->query($SQLA1, 1);
		$this->query($SQLA2, 1);
		 
		/******Employee OK*********/
		/***********************/
		$SQL = "select e.EmpID,e.Email,e.UserID from h_employee e   order by e.EmpID asc"; 
		$ArryResData = $this->query($SQL, 1);
		//pr($ArryResData,1);
		foreach ($ArryResData as $key => $values) {
			$Email = $values['Email'];
			$EmpID = $values['EmpID'];
			$UserID = $values['UserID'];
			if(!empty($Email) && !empty($EmpID) && !empty($UserID)){				
				$NewEmail = str_replace("@","1@",$Email);
				
				$SQL1 = "update h_employee set Email = '".$NewEmail."' where EmpID ='".$EmpID."' ";			
				$SQL2 = "update user set Email = '".$NewEmail."' where UserID ='".$UserID."' ";
	
				$SQL3 = "update ".$Config['DbMain'].".user_email set Email = '".$NewEmail."' where RefID ='".$EmpID."' and CmpID='".$CmpID."' and Email = '".$Email."' ";				
				
				 

				$this->query($SQL1, 1);
				$this->query($SQL2, 1);
				$this->query($SQL3, 1);
			}
		}		
		/******Customer OK*********/
		/***********************/
		$SQLCust = "select Cid,Email from s_customers where Email !='' order by Cid asc"; 
		$ArryResCust = $this->query($SQLCust, 1);
		//pr($ArryResCust,1);
		foreach ($ArryResCust as $key => $val) {
			$Cid = $val['Cid'];
			$Email = $val['Email'];
			if(!empty($Email) && !empty($Cid)){
				$NewEmailCust = str_replace("@","1@",$Email);
				 $SQLC1 = "update s_customers set Email = '".$NewEmailCust."' where Cid ='".$Cid."' ";
				$SQLC2 = "update ".$Config['DbMain'].".company_user set user_name = '".$NewEmailCust."' where ref_id ='".$Cid."' and comId='".$CmpID."' and user_name = '".$Email."' ";
				//echo '<br><br>'.$SQLC1.'<br>'.$SQLC2; 
				$this->query($SQLC1, 1);
				$this->query($SQLC2, 1); 				
			}
		}

		 

	}
	/*********************************/

	/*************insert Email for Agrinde 1****************/
	function InsertEmailAgrindeCO555($CmpID){ 
		global $Config;

		/******Company OK*********/
		/***********************
		$AdminEmail = "mahir@agrinde.com";
		$SQLA1 = "update ".$Config['DbMain'].".user_email set Email = '".$AdminEmail."' where CmpID ='".$CmpID."' and RefID='0' and Email = '".$_SESSION['AdminEmail']."' ";
		$SQLA2 = "update ".$Config['DbMain'].".company set Email = '".$AdminEmail."' where CmpID ='".$CmpID."' and Email = '".$_SESSION['AdminEmail']."' ";		 
		$this->query($SQLA1, 1);
		$this->query($SQLA2, 1);
	 
		/******Employee OK*********/
		/***********************/
		$SQL = "select e.EmpID,e.Email,e.UserID from h_employee e   order by e.EmpID asc"; 
		$ArryResData = $this->query($SQL, 1);
		foreach ($ArryResData as $key => $values) {
			$Email = $values['Email'];
			$EmpID = $values['EmpID'];
			$UserID = $values['UserID'];
			if(!empty($Email) && !empty($EmpID) && !empty($UserID)){		
				$SQL1 = "insert into ".$Config['DbMain'].".user_email (CmpID,RefID,Email) values ('".$CmpID."','".$EmpID."','".$Email."')";
				
				$this->query($SQL1, 1);
			}
		}		 
		/******Customer OK*********/
		/***********************/
		$SQLCust = "select * from s_customers where Email !='' order by Cid asc"; 
		$ArryResCust = $this->query($SQLCust, 1);
		foreach ($ArryResCust as $key => $values) {
			$Email = $values['Email'];
			$Cid = $values['Cid'];
			if(!empty($Email) && !empty($Cid) ){		
				$SQL1 = "insert into ".$Config['DbMain'].".company_user (user_name,comId,gender,user_type,ref_id,date,status) values ('".$Email."','".$CmpID."','male','customer','".$Cid."','".$values['CreatedDate']."','1')";				
				$this->query($SQL1, 1);
				 
			}
		}
		/***********************/


	}
	/*********************************/
	/*********UpdateBaseCurrency******************/
	function UpdateBaseCurrency($CmpID){
		global $Config;
		$SQL1 = "UPDATE ".$Config['DbMain'].".`company` SET `currency_id` = '13', `AdditionalCurrency` = 'INR,USD' WHERE `CmpID` = ".$CmpID;
		$SQL2 = "UPDATE `location` SET `currency_id` = '13' WHERE `locationID` = 1; ";	
						
		$this->query($SQL1, 1);
		$this->query($SQL2, 1);	

	}
	/*********************************/
	/*********UpdateConversionRate******************/
	function UpdateConversionRate(){
		global $Config;
		$Table = "s_order"; // s_order  p_order  f_gerenal_journal
		$CurrencyCol = "CustomerCurrency"; //CustomerCurrency  Currency

		$SQL1 = "update ".$Table." SET ConversionRate ='".$Config['AedRate']."' where ".$CurrencyCol." = 'USD'";
		$SQL2 = "update ".$Table." SET ConversionRate ='1' where ".$CurrencyCol." = 'AED'";

		//echo '<br><br>'.$SQL1.'<br>'.$SQL2; die;

		$this->query($SQL1, 1);
		$this->query($SQL2, 1);
	}

	/*********************************/
	/*********UpdateFpayment******************/
	function UpdateFpayment555(){
		global $Config;
		$objCommon = new common();		 
		//$PaymentType = "'Customer Invoice Entry','Customer Invoice'";
		//$PaymentType = "'Customer Credit Memo'";
		//$PaymentType = "'Vendor Invoice Entry','Vendor Invoice'";
		//$PaymentType = "'Vendor Credit Memo'";
		//$PaymentType = "'PO Receipt'";
		//$PaymentType = "'Journal Entry'";
		//$PaymentType = "'Sales'";
		//$PaymentType = "'Purchase'";

		//$ModuleCurrency = "USD";  //AED USD

		if($ModuleCurrency == "AED"){
			$addSql = " and ModuleCurrency in ('AED') and TransactionType in ('C','D')";   
		}else{
			$addSql = " and ModuleCurrency not in ('AED')"; 
		}

		//$addSql .= " and ReferenceNo='payment November 3'"; //Temp

		$strSQL = "select *, DECODE(DebitAmnt,'". $Config['EncryptKey']."') as  DebitAmnt, DECODE(CreditAmnt,'". $Config['EncryptKey']."') as  CreditAmnt , DECODE(OriginalAmount,'". $Config['EncryptKey']."') as  OriginalAmount from f_payments where PaymentType in (".$PaymentType.") and Currency='USD' ".$addSql." order by PaymentID Asc ";
		$arryPayment = $this->query($strSQL, 1);

		$Count=0;
		foreach ($arryPayment as $key => $values) {
			$Count++;
			$stUpdate=$OriginalAmount=$TransactionType='';
			/***************/ 
			echo '<br>'.$values['ReferenceNo'];
			if($values['ModuleCurrency']=="AED"){	
				//AED
				if($values['TransactionType']=="D"){
			  		$stUpdate = ", DebitAmnt = OriginalAmount";		
				}else{				
					$stUpdate = ", CreditAmnt = OriginalAmount ";	
				}
				$strpayUpdate = "update f_payments set ConversionRate = '1',Currency = '". $Config['Currency']."' ".$stUpdate." where PaymentID='".$values['PaymentID']."' ";	

				echo '<br>'.$strpayUpdate.'<br>';
				if(!empty($_GET['run']))$this->query($strpayUpdate, 0);	 			  
			}else{ 
				//USD
				 
				$DebitAmnt = round(GetConvertedAmount($Config['AedRate'], $values['DebitAmnt']),2);
				$CreditAmnt = round(GetConvertedAmount($Config['AedRate'], $values['CreditAmnt']),2);


				if(empty($DebitAmnt) && empty($CreditAmnt) ){
					//echo '   DIEEEEEEEE EMPTY';die;
				}
				if($DebitAmnt<0 || $CreditAmnt<0 ){
					//echo '   DIEEEEEEEE NEGATIVE';die;
				}

				if(empty($values['ModuleCurrency']) || empty($values['TransactionType'])){					
					if(!empty($DebitAmnt)){
						$OriginalAmount = $values['DebitAmnt'];
						$TransactionType = 'D';
					}else{
						$OriginalAmount = $values['CreditAmnt'];
						$TransactionType = 'C';
					}	
					$stUpdate = ", ModuleCurrency = 'USD', TransactionType = '".$TransactionType."', OriginalAmount  = ENCODE('".$OriginalAmount."','".$Config['EncryptKey']."') ";
					 	
				}

				if($DebitAmnt=='0') $DebitAmnt='0.00';
				if($CreditAmnt=='0') $CreditAmnt='0.00';

				 
				
				$strpayUpdate = "update f_payments set ConversionRate = '".$Config['AedRate']."',Currency = '". $Config['Currency']."' , CreditAmnt  = ENCODE('".$CreditAmnt."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('".$DebitAmnt."','".$Config['EncryptKey']."') ".$stUpdate."  where PaymentID='".$values['PaymentID']."' ";	

				echo '<br>'.$strpayUpdate.'<br>';
				if(!empty($_GET['run']))$this->query($strpayUpdate, 0);
				
 				
			}
			/***************/

			//if($Count==100) break;
		}
	}


	/*************************************/
	/*********UpdateFtransaction******************/
	function UpdateFtransaction(){
		global $Config;
		$PaymentType = "Purchase"; //Sales Purchase
  		$ModuleCurrency = "USD";  //AED USD

		if($ModuleCurrency == "AED"){
			$addSql = " and ModuleCurrency in ('AED') ";   
		}else{
			$addSql = " and ModuleCurrency not in ('AED')"; 
		}

		//$addSql .= " and TransactionID='10'"; //Temp

		$strSQL = "select *, DECODE(TotalAmount,'". $Config['EncryptKey']."') as  TotalAmount, DECODE(OriginalAmount,'". $Config['EncryptKey']."') as  OriginalAmount from f_transaction where PaymentType in ('".$PaymentType."') and Currency='USD' ".$addSql." order by TransactionID Asc ";
		$arryPayment = $this->query($strSQL, 1);
		//pr($arryPayment,0);
		$Count=0;
		foreach ($arryPayment as $key => $values) {
			$Count++;
			$stUpdate=$OriginalAmount='';
			$stUpdateD=$OriginalAmountD='';
			/***************/ 
			echo '<br>'.$values['ReceiptID'];
			if($values['ModuleCurrency']=="AED"){	
				//AED			 
				$strpayUpdate = "update f_transaction set Currency = '". $Config['Currency']."' , TotalAmount = OriginalAmount  where TransactionID='".$values['TransactionID']."' ";					
				$strpayUpdateD = "update f_transaction_data set ConversionRate = '1' , Amount = OriginalAmount  where TransactionID='".$values['TransactionID']."' ";	

				echo '<br>'.$strpayUpdate.'<br>'.$strpayUpdateD.'<br>';
				if(!empty($_GET['run'])){
					$this->query($strpayUpdate, 0);	 
					$this->query($strpayUpdateD, 0);	 
				}			  
			}else{ 	
				//USD		
				//pr($values,1);		 
				$TotalAmount = round(GetConvertedAmount($Config['AedRate'], $values['TotalAmount']),2);		
				if(empty($TotalAmount)){
					//echo '   DIEEEEEEEE EMPTY';die;
				}
				if($TotalAmount<0){
					//echo '   DIEEEEEEEE NEGATIVE';die;
				}

				if(empty($values['ModuleCurrency'])){					
					$OriginalAmount = $values['TotalAmount'];	
					$stUpdate = ", ModuleCurrency = 'USD', OriginalAmount  = ENCODE('".$OriginalAmount."','".$Config['EncryptKey']."') ";	
					$stUpdateD = ", ModuleCurrency = 'USD' , OriginalAmount  = Amount ";					 	
				}

				if($TotalAmount=='0') $TotalAmount='0.00';
								
				$strpayUpdate = "update f_transaction set Currency = '". $Config['Currency']."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."') ".$stUpdate."  where TransactionID='".$values['TransactionID']."' ";
				$strpayUpdateD = "update f_transaction_data set ConversionRate = '".$Config['AedRate']."' ".$stUpdateD." , Amount = ROUND((Amount*".$Config['AedRate']."),2)    where TransactionID='".$values['TransactionID']."' ";	


				echo '<br>'.$strpayUpdate.'<br>'.$strpayUpdateD.'<br>';
				if(!empty($_GET['run'])){
					$this->query($strpayUpdate, 0);	 
					$this->query($strpayUpdateD, 0);	 
				}
 				
			}
			/***************/

			//if($Count==100) break;

			/*********************/

			/*********************/	
		}
	}
	 
 
 

	 
	function UpdateSoItemCost(){
		global $Config;
		
		//$addSql = "  and o.OrderID = '8' "; //Temp
 		$strSQLQuery = "select o.OrderID,o.InvoiceID,o.ConversionRate,o.CustomerCurrency,i.id,i.sku,i.DropshipCost,i.avgCost from s_order_item  i inner join s_order o on (o.OrderID = i.OrderID and o.OrderID>0 and o.Module='Invoice') where o.CustomerCurrency='USD' and (i.`DropshipCost` > 0 or i.avgCost>0) ".$addSql."  order by o.OrderID asc";
		$arryRow = $this->query($strSQLQuery, 1);
		//pr($arryRow,1);
		foreach($arryRow as $key=>$values){
			echo '<br>'.$values['InvoiceID'].' : '.$values['sku'];
			$DropshipCost = $values['DropshipCost'];
			$avgCost = $values['avgCost'];
					
			if(!empty($DropshipCost)) $DropshipCost= round(GetConvertedAmount($Config['AedRate'], $DropshipCost),2);
			if(!empty($avgCost)) $avgCost= round(GetConvertedAmount($Config['AedRate'], $avgCost),2);
			$strSQLQuery = "update s_order_item set DropshipCost='".$DropshipCost."', avgCost='".$avgCost."' where OrderID='".$values['OrderID']."' and id='".$values['id']."'";
 			//echo "<br>".$strSQLQuery."<br>";	

			if(!empty($_GET['run'])){
				$this->query($strSQLQuery, 0);	
			}			
			
		}

	}
	 


}
?>
