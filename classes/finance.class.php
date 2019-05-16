<?
class common extends dbClass
{
		//constructor
		function common()
		{
			$this->dbClass();
		} 
		
		///////  Attribute Management //////

		function  GetAttributeValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' and locationID='".$_SESSION['locationID']."'"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID='".$_SESSION['locationID']."'"):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	



		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id ='".$id."'"):("");
		
			$strSQLQuery = "select * from f_attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
			
		function addAttribute($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into f_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function updateAttribute($arryAtt)
		{
			@extract($arryAtt);	
			$sql = "update f_attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',Status = '".$Status."'  where value_id = '".$value_id."'"; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from f_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from f_attribute_value where Status=1" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			$sql="select * from f_attribute_value where value_id = '".$value_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update f_attribute_value set Status='$Status' where value_id = '".$value_id."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteAttribute($id)
		{
			$sql = "delete from f_attribute_value where value_id = '".$id."'";
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from f_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and locationID='".$_SESSION['locationID']."'";

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}

		////////////Fixed Attribute Start ///// 
		function  GetAttribMultiple($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name in(".$attribute_name.") and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}



		function  GetAttribValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}
		function getAttrib($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from f_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}

		 

		function isAttribExists($attribute_value,$attribute_id,$value_id)
		{

				$strSQLQuery ="select value_id from f_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' ";

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}

		/********************************************/
		/*************Payment Term Start ************/

		function  ListTerm($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where Deleted='0' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" and termID='".$id."'"):("");

			if($SearchKey=='active' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (termName like '%".$SearchKey."%' or Day like '%".$SearchKey."%' or Due like '%".$SearchKey."%' or CreditLimit like '%".$SearchKey."%') " ):("");		
			}
			$strAddQuery .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by termName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			$strSQLQuery = "select * from f_term  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function  GetTerm($termID,$Status)
		{

			$strAddQuery = " where 1 ";
			$strAddQuery .= (!empty($termID))?(" and termID='".$termID."'"):("");
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from f_term  ".$strAddQuery." order by termID Asc";

			return $this->query($strSQLQuery, 1);
		}		
			
		
		function AddTerm($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into f_term (termType, termName, termDate, Due, Status, Day, CreditLimit, paymentType, UpdatedDate ) values( '".$termType."', '".$termName."', '".$termDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."',  '".addslashes($CreditLimit)."', '".addslashes($paymentType)."',  '".$Config['TodayDate']."')";

			$this->query($strSQLQuery, 0);

			$termID = $this->lastInsertId();
			
			return $termID;

		}

		function AddTermPP($arryDetails){                 
			
			global $Config;
			extract($arryDetails);
                        if($glAccountStatus == 0){
                            $glAccount = 0;
                        }
			//$strSQLQuery = "insert into f_term (termType, termName, termDate, Due, Status, Day, CreditLimit, UpdatedDate ) values( '".$termType."', '".$termName."', '".$termDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."', '".addslashes($CreditLimit)."',  '".$Config['TodayDate']."')";
                        $strSQLQuery = "insert into f_term (termType, termName, termDate, Due, Status, Day, CreditLimit, UpdatedDate , `ppfPartnerId`, `ppfPassword`, `ppfVendor`, `ppfUserId`, `cardNumber`, `cvv`, `expiryDate`, `cardType`, `billingAddress`, `billingCity`, `billingState`, `billingZipCode`, `billingCountry`, `anApiLoginId`, `anTransactionKey`, `glAccount`, `paymentType`, `rate`) values( '".$termType."', '".$termName."', '".$termDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."', '".addslashes($CreditLimit)."',  '".$Config['TodayDate']."','".$ppfPartnerId."',  '".$ppfPassword."',  '".$ppfVendor."',  '".$ppfUserId."',  '".$cardNumber."',  '".$cvv."',  '".$expiryDate."',  '".$cardType."',  '".$billingAddress."',  '".$billingCity."',  '".$billingState."',  '".$billingZipCode."',  '".$billingCountry."',  '".$anApiLoginId."',  '".$anTransactionKey."',  '".$glAccount."',  '".$paymentType."',  '".$rate."')";

			$this->query($strSQLQuery, 0);

			$termID = $this->lastInsertId();
			
			return $termID;

		}

		function UpdateTerm($arryDetails){
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update f_term set termType='".$termType."', termName='".$termName."', termDate='".$termDate."',  Due='".addslashes($Due)."',  Status='".$Status."'  ,Day='".addslashes($Day)."'	,CreditLimit='".addslashes($CreditLimit)."' ,paymentType='".addslashes($paymentType)."'	, UpdatedDate = '".$Config['TodayDate']."' where termID='".$termID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

		function UpdateTermPP($arryDetails){                   
			global $Config;
			extract($arryDetails);
                        if($glAccountStatus == 0){
                            $glAccount = 0;
                        }
			$strSQLQuery = "update f_term set termType='".$termType."', termName='".$termName."', termDate='".$termDate."',  Due='".addslashes($Due)."',  Status='".$Status."'  ,Day='".addslashes($Day)."'	,CreditLimit='".addslashes($CreditLimit)."' , UpdatedDate = '".$Config['TodayDate']."',ppfPartnerId = '".$ppfPartnerId."' ,ppfPassword = '".$ppfPassword."', ppfVendor =  '".$ppfVendor."', ppfUserId = '".$ppfUserId."', cardNumber = '".$cardNumber."', cvv =  '".$cvv."', expiryDate = '".$expiryDate."', cardType = '".$cardType."', billingAddress = '".$billingAddress."', billingCity = '".$billingCity."', billingState = '".$billingState."', billingZipCode =  '".$billingZipCode."', billingCountry = '".$billingCountry."', anApiLoginId = '".$anApiLoginId."', anTransactionKey =  '".$anTransactionKey."', glAccount =  '".$glAccount."', paymentType =  '".$paymentType."', rate =  '".$rate."'  where termID='".$termID."' and fixed='0'"; 
			$this->query($strSQLQuery, 0);

			return 1;
		}			
		
		function RemoveTerm($termID)
		{
		
			$strSQLQuery = "delete from f_term where termID='".$termID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function changeTermStatus($termID)
		{
			$sql="select * from f_term where termID='".$termID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update f_term set Status='$Status' where termID='".$termID."'";
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleTermStatus($termIDs,$Status)
		{
			$sql="select termID from f_term where termID in (".$termIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update f_term set Status='".$Status."' where termID in (".$termIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		

		function isTermExists($termName,$termID=0)
		{
			$strSQLQuery = (!empty($termID))?(" and termID != '".$termID."'"):("");
			$strSQLQuery = "select termID from f_term where LCASE(termName)='".strtolower(trim($termName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['termID'])) {
				return true;
			} else {
				return false;
			}
		}


		/*************Payment Term End ************/

		/*************Payment Method Start ************/

               	function  ListMethod($arryDetails)
		{  
			extract($arryDetails);

			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" and methodID='".$id."'"):("");

			if($SearchKey=='active' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (methodName like '%".$SearchKey."%' or Day like '%".$SearchKey."%' or Due like '%".$SearchKey."%' or CreditLimit like '%".$SearchKey."%') " ):("");		
			}
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by methodName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			  $strSQLQuery = "select * from f_method  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

                function  GetMethod($methodID,$Status)
		{

			$strAddQuery = " where 1 ";
			$strAddQuery .= (!empty($methodID))?(" and methodID='".$methodID."'"):("");
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from f_method  ".$strAddQuery." order by methodID Asc";

			return $this->query($strSQLQuery, 1);
		}

                function AddMethod($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into f_method (methodType, methodName, methodDate, Due, Status, Day, CreditLimit,glAccount , UpdatedDate ) values( '".$methodType."', '".$methodName."', '".$methodDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."', '".addslashes($CreditLimit)."', '".addslashes($glAccount)."',  '".$Config['TodayDate']."')";

			$this->query($strSQLQuery, 0);

			$methodID = $this->lastInsertId();
			
			return $methodID;

		}

                function UpdateMethod($arryDetails){
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update f_method set methodType='".$methodType."', methodName='".$methodName."', methodDate='".$methodDate."',  Due='".addslashes($Due)."',  Status='".$Status."'  ,Day='".addslashes($Day)."'	,CreditLimit='".addslashes($CreditLimit)."' ,glAccount='".addslashes($glAccount)."'	, UpdatedDate = '".$Config['TodayDate']."' where methodID='".$methodID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

                function RemoveMethod($methodID)
		{
		
			$strSQLQuery = "delete from f_method where methodID='".$methodID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function changeMethodStatus($methodID)
		{
			$sql="select * from f_method where methodID='".$methodID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update f_method set Status='$Status' where methodID='".$methodID."'";
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleMethodStatus($methodIDs,$Status)
		{
			$sql="select methodID from f_method where methodID in (".$methodIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update f_method set Status='".$Status."' where methodID in (".$methodIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		

		function isMethodExists($methodName,$methodID=0)
		{
			$strSQLQuery = (!empty($methodID))?(" and methodID != '".$methodID."'"):("");
			$strSQLQuery = "select methodID from f_method where LCASE(methodName)='".strtolower(trim($methodName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['methodID'])) {
				return true;
			} else {
				return false;
			}
		}
      
          
                 /*************Payment Method End ************/

		function getSettingVariable($settingKey)
		{
			$strSQLQuery = "select setting_value from settings where setting_key ='".trim($settingKey)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$settingValue = $arryRow[0]['setting_value'];	
			return $settingValue;
			
		}
		function getCustomerCode($CustID)
		{
			$strSQLQuery = "select CustCode from s_customers where Cid ='".mysql_real_escape_string($CustID)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$CustCode = $arryRow[0]['CustCode'];	
			return $CustCode;
			
		}
		
		function getDefaultAccount()
		{
			$strSQLQuery = "select BankAccountID from f_account where DefaultAccount ='1' and Status='Yes' order by BankAccountID desc limit 0,1"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$BankAccountID = $arryRow[0]['BankAccountID'];	
			return $BankAccountID;
			
		}

                
              /**************************FUNCTION STARTED FOR SETTINGS******************************************** */

        
               function getSettingsFields($depID,$group_id)
               {
                     $strSQLQuery =  "SELECT * FROM settings WHERE visible='Yes' AND group_id = '".$group_id."' and dep_id='".$depID."' ORDER BY priority";
                    return $this->query($strSQLQuery, 1);
               }

               function updateSettingsFields($arrayFields){
			global $Config;
			/*for($i=0;$i<sizeof($arrayFields['FromCurrency']);$i++){  
				$strSQLQuery = "select ID from currency_setting where FromCurrency='".$arrayFields['FromCurrency'][$i]."' and  ToCurrency='".$Config['Currency']."' "; 
				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['ID'])) {
					$strSQLQuery =  "UPDATE currency_setting SET ConversionRate='".$arrayFields['ConversionRate'][$i]."', FromCurrency='".$arrayFields['FromCurrency'][$i]."',ToCurrency='".$Config['Currency']."', FromDate='".$arrayFields['CurrencyFromDate']."',ToDate='".$arrayFields['CurrencyToDate']."' WHERE ID= '".$arryRow[0]['ID']."'";
					
				} else {
					 $strSQLQuery =  "INSERT into currency_setting SET ConversionRate='".$arrayFields['ConversionRate'][$i]."', FromCurrency='".$arrayFields['FromCurrency'][$i]."', ToCurrency='".$Config['Currency']."', FromDate='".$arrayFields['CurrencyFromDate']."', ToDate='".$arrayFields['CurrencyToDate']."' ";
					
				}				
				$this->query($strSQLQuery, 0);
			}*/


	
			foreach ($arrayFields as $key=>$value){                         
				$strSQLQuery =  "UPDATE settings SET setting_value='".$value."' WHERE setting_key LIKE '".trim($key)."'";
				$this->query($strSQLQuery, 0);
			}
		   
			return true;
               }



	       function updateCurrencySetting($arrayFields,$arrayModule,$arrySelCurrency){
			global $Config;			
			//print_r($arrayFields);exit;
			$IPAddress = GetIPAddress();

			$ToCurrency = $Config['Currency'];
		   	for($i=0;$i<sizeof($arrayModule);$i++){// For Module 		
			 $Module = $arrayFields['Module'.$i];				
				for($j=0;$j<sizeof($arrySelCurrency);$j++){  // For Currency
				   if($arrySelCurrency[$j]!=$Config['Currency']){				    
				    $FromCurrency = $arrayFields['FromCurrency'.$i.'_'.$j];
				   
				    $ConversionRate = $arrayFields['ConversionRate'.$i.'_'.$j];
				    $CurrencyFromDate = $arrayFields['CurrencyFromDate'.$i.'_'.$j];
				    $CurrencyToDate = $arrayFields['CurrencyToDate'.$i.'_'.$j];
				    $DateRange = $arrayFields['DateRange'.$i.'_'.$j];				  
				  
				    $strSQLQuery = "select ID,ConversionRate,FromDate,ToDate from currency_setting where Module='".$Module."' and FromCurrency='".$FromCurrency."' and  ToCurrency='".$ToCurrency."' "; 
			 	    $arrayID = $this->query($strSQLQuery, 1);
				   // echo "<pre>";print_r($arrayID);die;
				    $ID=$arrayID[0]['ID'];
				    $FromDate = ($arrayID[0]['FromDate']>0)?($arrayID[0]['FromDate']):('');
				    $ToDate = ($arrayID[0]['ToDate']>0)?($arrayID[0]['ToDate']):('');



				    if($DateRange==0){ //Open
	   	 			unset($CurrencyFromDate);
					unset($CurrencyToDate);
				    }else if($DateRange==1){ //Date
	   	 			unset($CurrencyToDate);
				    }else if($DateRange==2){ //Range
	   	 			if(empty($CurrencyFromDate)){
						 $CurrencyFromDate=$CurrencyToDate;
						  unset($CurrencyToDate);
					}
				    }


				    $CreateLog = 0; $InsertLog = 0; $UpdateLog = 0;

				    if($ID>0){
 
					if($ConversionRate!=$arrayID[0]['ConversionRate'] || $CurrencyFromDate!=$FromDate || $CurrencyToDate!=$ToDate){
						$CreateLog = 1;
					}
					 

				    	$strSQLQuery =  "UPDATE currency_setting SET ConversionRate='".$ConversionRate."', FromDate='".$CurrencyFromDate."', ToDate='".$CurrencyToDate."', UpdatedDate = '".$Config['TodayDate']."' WHERE ID= '".$ID."'";
				    }else{
					$strSQLQuery =  "INSERT into currency_setting SET Module='".$Module."', FromCurrency='".$FromCurrency."', ToCurrency='".$ToCurrency."',ConversionRate='".$ConversionRate."', FromDate='".$CurrencyFromDate."', ToDate='".$CurrencyToDate."', IPAddress = '". $IPAddress."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', CreatedDate='". $Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."' ";	
					
					$CreateLog = 1;
				    }
					
				    $this->query($strSQLQuery, 0);
	
				    /*********************/
				    /*********************/
				    if($CreateLog == 1){

					$strSQLL = "select ID,UpdatedDate,TIMEDIFF('".$Config['TodayDate']."', UpdatedDate) as TimeDiff from currency_log where Module='".$Module."' and FromCurrency='".$FromCurrency."' and  ToCurrency='".$ToCurrency."' and  IPAddress='".$IPAddress."' and  AdminID='".$_SESSION['AdminID']."' and  AdminType='".$_SESSION['AdminType']."' order by ID desc limit 0,1 "; 
			 	    	$arrayLogID = $this->query($strSQLL, 1);
					if(!empty($arrayLogID[0]["ID"])){
						$arryTime = explode(":",$arrayLogID[0]["TimeDiff"]); 
 
						if($arryTime[0]>0){
							$InsertLog = 1;
						}else{
							$UpdateLog = 1;
						}
					}else{
						$InsertLog = 1;
					}

					if($InsertLog==1){
						$strSQLLog =  "INSERT into currency_log SET Module='".$Module."', FromCurrency='".$FromCurrency."', ToCurrency='".$ToCurrency."',ConversionRate='".$ConversionRate."', FromDate='".$CurrencyFromDate."', ToDate='".$CurrencyToDate."', IPAddress = '". $IPAddress."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', CreatedDate='". $Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."' ";	
					}else{
						$strSQLLog =  "UPDATE currency_log SET ConversionRate='".$ConversionRate."', FromDate='".$CurrencyFromDate."', ToDate='".$CurrencyToDate."', UpdatedDate = '".$Config['TodayDate']."' WHERE ID= '".$arrayLogID[0]["ID"]."'";

					}
					 
					 $this->query($strSQLLog, 0);
				    }
				    /*********************/
  				    /*********************/
					  
				}
			   }
			}
			return true;
               }

	

	
               
	     	function getCurrencySetting(){
                     $strSQLQuery =  "SELECT * FROM currency_setting";
                    return $this->query($strSQLQuery, 1);
               }


		function getCurrencyLog($Module,$FromCurrency,$ToCurrency){
			$strAddQuery = '';
			$strAddQuery .= (!empty($Module))?(" and l.Module='".$Module."'"):("");
			$strAddQuery .= (!empty($FromCurrency))?(" and l.FromCurrency='".$FromCurrency."'"):("");
			$strAddQuery .= (!empty($ToCurrency))?(" and l.ToCurrency='".$ToCurrency."'"):("");
			 $strSQLQuery = "select l.*, if(l.AdminType='employee',e.UserName,'Administrator') as PostedBy  from currency_log l left outer join h_employee e on (l.AdminID=e.EmpID and l.AdminType='employee') where 1 ".$strAddQuery." order by l.UpdatedDate desc, l.ID desc";
			return $this->query($strSQLQuery, 1);
		}

                function getSpiffSettings()
               {
                    $strSQLQuery =  "SELECT * FROM f_spiff";
                    return $this->query($strSQLQuery, 1);
               }

               function updateSpiffSettings($arryDetails)
               {
                        global $Config;
			extract($arryDetails);
                        $strSQLQuery = "select SpiffID from f_spiff"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$SpiffID = $arryRow[0]['SpiffID'];
                        
                        
                        if($SpiffID > 0)
                        {
                              $strSQLQuery =  "UPDATE f_spiff SET GLAccountTo='".$GLAccountTo."',GLAccountFrom='".$GLAccountFrom."',PaymentTerm='".addslashes($PaymentTerm)."',PaymentMethod='".addslashes($PaymentMethod)."' WHERE SpiffID = '".$SpiffID."'";
                              $this->query($strSQLQuery, 0);
                            
                        }else{
                            
                              $strSQLQuery =  "INSERT INTO f_spiff SET GLAccountTo='".$GLAccountTo."',GLAccountFrom='".$GLAccountFrom."',PaymentTerm='".addslashes($PaymentTerm)."',PaymentMethod='".addslashes($PaymentMethod)."'";
                              $this->query($strSQLQuery, 0);
                        }
                    
               }

              
    
    	/**************************FUNCTION ENDED FOR SETTINGS******* */
	function isSalesExist($Module){
		$strSQLQuery = "select OrderID from s_order where Module ='".$Module."' limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['OrderID'])){
			return true;
		}			
	}

	function isPurchaseExist($Module){
		$strSQLQuery = "select OrderID from p_order where Module ='".$Module."' limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['OrderID'])){
			return true;
		}			
	}

	function isCustomerRmaExist($Module){
		$strSQLQuery = "select ReceiptID from w_receipt where Module ='".$Module."' limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['ReceiptID'])){
			return true;
		}			
	}

	function isVendorRmaExist($Module){
		$strSQLQuery = "select ReceiptID from w_receiptpo where Module ='".$Module."' limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['ReceiptID'])){
			return true;
		}			
	}
	function isWorkOrderExist(){
		$strSQLQuery = "select Oid from w_workorder   limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['Oid'])){
			return true;
		}			
	}

	function isPickingExist(){
		$strSQLQuery = "select OrderID from s_order where Module ='Order' and PickID!='' limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['OrderID'])){
			return true;
		}			
	}

	/*************Payment Provider Start ************/
	function  ListPaymentProvider($arryDetails){
		extract($arryDetails);
		$strAddQuery = " where 1";
		$strAddQuery .= (!empty($ProviderID))?(" and p.ProviderID='".$ProviderID."'"):("");
		$strAddQuery .= (!empty($Status))?(" and p.Status='".$Status."'"):("");
		$strSQLQuery = "select p.*,concat(a.AccountName,' [',a.AccountNumber,']') as AccountNameNumber from f_payment_provider p left outer join f_account a on p.glAccount = a.BankAccountID ".$strAddQuery." order by p.ProviderID Asc";
		
		return $this->query($strSQLQuery, 1);		
			
	}
	function GetPaymentProvider($ProviderID,$Status){
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($ProviderID))?(" and ProviderID='".$ProviderID."'"):("");
		$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

		$strSQLQuery = "select * from f_payment_provider  ".$strAddQuery." order by ProviderName desc";

		return $this->query($strSQLQuery, 1);
	}
	function UpdatePaymentProvider($arryDetails){                   
			global $Config;
			extract($arryDetails);
                        $CardTypeVal = implode(", ",$CardType);

			if(!in_array("Visa", $CardType)){
				$VisaGL=0;
			}
			if(!in_array("MasterCard", $CardType)){
				$MasterCardGL=0;
			}
			if(!in_array("Discover", $CardType)){
				$DiscoverGL=0;
			}
			if(!in_array("Amex", $CardType)){
				$AmexGL=0;
			}
			 
			 
			$strSQLQuery = "update f_payment_provider set  CardType = '".$CardTypeVal."', Status='".$Status."' , UpdatedDate = '".$Config['TodayDate']."',paypalID = '".$paypalID."' ,ppfPartnerId = '".$ppfPartnerId."' ,ppfPassword = '".$ppfPassword."', ppfVendor =  '".$ppfVendor."', ppfUserId = '".$ppfUserId."', anApiLoginId = '".$anApiLoginId."', anTransactionKey =  '".$anTransactionKey."', glAccount =  '".$glAccount."', AccountPaypal =  '".$AccountPaypal."', AccountPaypalFee =  '".$AccountPaypalFee."', ProviderFee =  '".$ProviderFee."', paypalUsername =  '".$paypalUsername."', paypalPassword =  '".$paypalPassword."', paypalSignature =  '".$paypalSignature."', paypalAppid =  '".$paypalAppid."', VisaGL = '".$VisaGL."', MasterCardGL = '".$MasterCardGL."', DiscoverGL = '".$DiscoverGL."',AmexGL = '".$AmexGL."' ,NabMerchantID = '".$NabMerchantID."',NabApplicationID = '".$NabApplicationID."',NabIndustry = '".$NabIndustry."',NabServiceID = '".$NabServiceID."',NabToken = '".$NabToken."', AccountCardFee =  '".$AccountCardFee."'  where ProviderID='".$ProviderID."' ";  
			$this->query($strSQLQuery, 0);

			return 1;
	} 

	function changeProviderStatus($ProviderID){
		$sql="select * from f_payment_provider where ProviderID='".$ProviderID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update f_payment_provider set Status='$Status' where ProviderID='".$ProviderID."'";
			$this->query($sql,0);				

			return true;
		}			
	}
	function getExistingCardType($NotProviderID){
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($NotProviderID))?(" and ProviderID!='".$NotProviderID."'"):("");
		$strSQLQuery = "select CardType from f_payment_provider  ".$strAddQuery." ";
		$arryRow = $this->query($strSQLQuery);
		
		return $arryRow;
	}
	/*************Payment Provider End ************/

	function GetConversionValue($Module){
		$strSQLQuery = "select * from currency_setting where Module='".$Module."'";
		return $this->query($strSQLQuery, 1);
   	}

	/********************************************/
	/*************Batch Start ************/

	function  ListBatch($arryDetails)
	{
		extract($arryDetails);

		$strAddQuery = " where b.BatchType='".$BatchType."'";
		$SearchKey   = strtolower(trim($key));
		$strAddQuery .= (!empty($id))?(" and b.BatchID='".$id."'"):("");

		if($SearchKey=='open' && ($sortby=='Status' || $sortby=='') ){
			$strAddQuery .= " and b.Status='1'"; 
		}else if($SearchKey=='closed' && ($sortby=='Status' || $sortby=='') ){
			$strAddQuery .= " and b.Status='0'";
		}else if($sortby != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (b.BatchName like '%".$SearchKey."%' or b.Description like '%".$SearchKey."%'  ) " ):("");		
		}
		$strAddQuery .= (!empty($Status))?(" and Status='".$Status."'"):("");

		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by b.BatchName ");
		$strAddQuery .= (!empty($asc))?($asc):(" Asc");

		$strSQLQuery = "select b.*,if(b.AdminType='employee',e.UserName,'Administrator') as PostedBy  from f_batch b left outer join h_employee e on (b.AdminID=e.EmpID and b.AdminType='employee') ".$strAddQuery;
	
	
		return $this->query($strSQLQuery, 1);		
			
	}

	function  GetBatch($BatchID,$Status)
	{

		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($BatchID))?(" and BatchID='".$BatchID."'"):("");
		$strAddQuery .= ($Status!='')?(" and Status='".$Status."'"):("");

		$strSQLQuery = "select * from f_batch  ".$strAddQuery." order by BatchName Asc";

		return $this->query($strSQLQuery, 1);
	}		
		
	
	function AddBatch($arryDetails)
	{  
		
		global $Config;
		extract($arryDetails);

		$strSQLQuery = "insert into f_batch (BatchType, BatchName, Description, Status, AdminID, AdminType, CreatedDate, UpdatedDate ) values( '".$BatchType."', '".$BatchName."', '".$Description."',  '".$Status."', '".$_SESSION['AdminID']."',  '".$_SESSION['AdminType']."', '".$Config['TodayDate']."',  '".$Config['TodayDate']."')";

		$this->query($strSQLQuery, 0);

		$BatchID = $this->lastInsertId();
		
		return $BatchID;

	}
	

	function UpdateBatch($arryDetails){
		global $Config;
		extract($arryDetails);

		$strSQLQuery = "update f_batch set  BatchName='".$BatchName."', Description='".$Description."' ,  Status='".$Status."'  , UpdatedDate = '".$Config['TodayDate']."' where BatchID='".$BatchID."'"; 

		$this->query($strSQLQuery, 0);

		return 1;
	}
	 				
	function RemoveBatch($BatchID){		
		$strSQLQuery = "delete from f_batch where BatchID='".$BatchID."'"; 
		$this->query($strSQLQuery, 0);	

		return 1;
	}

	function changeBatchStatus($BatchID){
		$sql="select * from f_batch where BatchID='".$BatchID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))	{
			if($rs[0]['Status']==1){
				$Status=0;
				$_SESSION['mess_batch'] = BATCH_OPENED;
			}else{
				$Status=1;
				$_SESSION['mess_batch'] = BATCH_CLOSED;
			}
				
			$sql="update f_batch set Status='".$Status."' where BatchID='".$BatchID."'";
			$this->query($sql,0);				

			return true;
		}			
	}	


	function isBatchExists($BatchName,$BatchType,$BatchID=0)
	{
		$strAddQuery = (!empty($BatchID))?(" and BatchID != '".$BatchID."'"):("");
		$strAddQuery .= (!empty($BatchType))?(" and BatchType = '".$BatchType."'"):("");
		$strSQLQuery = "select BatchID from f_batch where LCASE(BatchName)='".strtolower(trim($BatchName))."'".$strAddQuery; 
		 
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['BatchID'])) {
			return true;
		} else {
			return false;
		}
	}

	function  CountCheckInBatch($BatchID){	
		if(!empty($BatchID)){	 
			$strSQLQuery = "select count(BatchID) as TotalCheck from f_transaction  where BatchID='".$BatchID."' and Method='Check'";
			$arryRow = $this->query($strSQLQuery, 1);
		}
		return $arryRow[0]['TotalCheck'];
	}

	function  GetCheckInBatch($BatchID){	
		if(!empty($BatchID)){	 
			$strSQLQuery = "select TransactionID from f_transaction t  where t.BatchID='".$BatchID."' and t.Method='Check' ORDER BY t.PostToGL desc, t.PaymentDate desc,t.TransactionID desc ";
			return $this->query($strSQLQuery, 1);
		}		
	}

	function CheckToBatch($BatchID,$TransactionIDarry){ 
		if(!empty($BatchID)){	
			$TransactionIDs	= implode(",",$TransactionIDarry);
			$sql="update f_transaction set BatchID='0' where BatchID='".$BatchID."'"; 
			$this->query($sql,0);

			$sql2="update f_transaction set BatchID='".$BatchID."' where TransactionID in (".$TransactionIDs.") and Method='Check'"; 
			$this->query($sql2,0);
		}
		return true;		 		
	}

	function MoveCheckToBatch($BatchID,$TransactionIDarry){ 
		if(!empty($BatchID)){	
			$TransactionIDs	= implode(",",$TransactionIDarry);
			$sql="update f_transaction set BatchID='".$BatchID."' where TransactionID in (".$TransactionIDs.") and Method='Check'"; 
			$this->query($sql,0);
		}
		return true;		 		
	}
	function RemoveFromBatch($BatchID,$TransactionIDarry){ 
		if(!empty($BatchID)){	
			$TransactionIDs	= implode(",",$TransactionIDarry);
			$sql="update f_transaction set BatchID='0' where TransactionID in (".$TransactionIDs.") and BatchID='".$BatchID."'"; 
			$this->query($sql,0);
		}
		return true;		 		
	}
	/************* Batch End ************/
	function SaveSettingCaption($arryData){ 
		extract($arryData);
		if(!empty($caption) && !empty($setting_key)){				
			$sql="update settings set caption='".$caption."' where setting_key='".$setting_key."'"; 
			$this->query($sql,0);
			return true;	
		}
			 		
	}



	function APCreditPostUpdate55556568($arryPostData){
		global $Config;
		extract($arryPostData);
		$ipaddress = GetIPAddress(); 
		
		$strAdd = " and p.CreditID='CRD000558' ";
		$strAdd .= " and p.AccountID<=0 ";

		//$strAdd .= " and (p.taxAmnt>0 || p.Freight>0)";

		$strSQL = "SELECT p.* ,p2.OrderType as InvOrderType from p_order p  left outer join p_order p2 on (p.InvoiceID=p2.InvoiceID and p2.Module='Invoice' and p.InvoiceID!='')  where p.Module='Credit' and p.PostToGL = '1' ".$strAdd." order by p.PostToGLDate asc"; 		
		$arryP = $this->query($strSQL, 1);
		echo '<pre>'; echo sizeof($arryP).'<br>'; print_r($arryP);exit;	
		$PaymentType = 'Vendor Credit Memo';
		
		foreach($arryP as $key => $values) {
			if(!empty($values['OrderID'])){
				echo $values['CreditID'].' = <br>';exit;
				$Date = $values['PostToGLDate'];
				$TotalAmount = $values['TotalAmount'];
				$OriginalAmount = $TotalAmount;
 
				$Freight=0;				
				$OriginalFreight=0;
				$taxAmnt=0;
				$OriginalTax=0;

				if($values['Currency']!=$Config['Currency']){				
					$ConversionRate = $values['ConversionRate'];
				} 
				if(empty($ConversionRate)) $ConversionRate=1;


				if(!empty($values['AccountID'])){ //GL Credit Memo
					//SKIP					
				}else{
					$InvOrderType = $values['InvOrderType']; 
					if($InvOrderType=='Dropship'){
						$CreditAccount = $CostOfGoods;
					}else{
						$CreditAccount = $InventoryAP;

						$Freight = $values['Freight'];			
						$OriginalFreight = $Freight;
						$taxAmnt = $values['taxAmnt'];
						$OriginalTax = $taxAmnt;
					}

					/*****************/			
					if($values['Currency']!=$Config['Currency']){
						$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount) ,2);
						$Freight = round(GetConvertedAmount($ConversionRate, $Freight),2);
						$taxAmnt = round(GetConvertedAmount($ConversionRate, $taxAmnt),2);
					}
					/*****************/	
					$SubTotal = $TotalAmount - $Freight - $taxAmnt;
					$OriginalSubTotal = $OriginalAmount - $OriginalFreight - $OriginalTax;
 
				

				if($TotalAmount>0 && $CreditAccount>0){	

					$strAp= "select p.PaymentID,p.PID, p.PaymentDate from f_payments p where ReferenceNo='".$values['CreditID']."' and  SuppCode = '".$values['SuppCode']."' and PaymentType='".$PaymentType."' and AccountID = '".$AccountPayable."' and p.PID>'0' order by p.PaymentID desc limit 0,1"; 
					$arryAp = $this->query($strAp, 1);
					$apPaymentID = $arryAp[0]['PaymentID']; //AP ID
					$PID = $arryAp[0]['PID']; //First ID
					//echo $apPaymentID.'#'.$PID; exit;
				 
					 
					if($PID>0 && $apPaymentID>0 ){
						$strSQLinv = "update f_payments set  CreditAmnt  = ENCODE('".$SubTotal."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$CreditAccount."', ModuleCurrency = '".$values['Currency']."' , OriginalAmount=ENCODE('".$OriginalSubTotal. "','".$Config['EncryptKey']."'), TransactionType='C' , UpdatedDate='". $Config['TodayDate']."'   WHERE PaymentID ='".$PID."' ";
						//$this->query($strSQLinv, 0);
								

						$str2= "select p.PaymentID,p.PaymentDate from f_payments p where ReferenceNo='".$values['CreditID']."' and  SuppCode = '".$values['SuppCode']."' and PaymentType='".$PaymentType."' and p.PaymentID not in ($PID,$apPaymentID) order by p.PaymentID asc "; 
						$arrySecond = $this->query($str2, 1);

						$SecondID = $arrySecond[0]['PaymentID'];
						$ThirdID = $arrySecond[1]['PaymentID'];

						//echo $SecondID.'#'.$ThirdID; exit;

						$DeleteSecond = 0;
						$DeleteThird = 0;
						if($InvOrderType=='Dropship'){
							/**************************/
							$DeleteSecond = 1;
							$DeleteThird = 1;
							/**************************/
						}else{
							/**********Freight****************/
							if($Freight>0 && $FreightExpense>0){ 
								if($SecondID>0){
									$strSQLQueryFr = "update f_payments set   PID='".$PID."', CreditAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightExpense."', ModuleCurrency = '".$values['Currency']."' , OriginalAmount=ENCODE('".$OriginalFreight. "','".$Config['EncryptKey']."'), TransactionType='C' , UpdatedDate='". $Config['TodayDate']."'   WHERE PaymentID ='".$SecondID."' ";								
								}else{
									$strSQLQueryFr = "INSERT INTO f_payments SET  PID='".$PID."', ConversionRate = '".$ConversionRate."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."',  CreditID='".$values['CreditID']."', ReferenceNo='".$values['CreditID']."', CreditAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightExpense."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['Currency']."' , OriginalAmount=ENCODE('".$OriginalFreight. "','".$Config['EncryptKey']."'), TransactionType='C'";						}
										
								//$this->query($strSQLQueryFr, 0);
							}else{
								$DeleteSecond = 1;
							}
							/**************************/
							
							/*******TAX************/
							if($taxAmnt>0 && $SalesTaxAccount>0){	
								if($ThirdID>0){
									$strSQLQueryT = "update f_payments set   PID='".$PID."', CreditAmnt  = ENCODE('".$taxAmnt."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."', ModuleCurrency = '".$values['Currency']."' , OriginalAmount=ENCODE('".$OriginalTax. "','".$Config['EncryptKey']."'), TransactionType='C' , UpdatedDate='". $Config['TodayDate']."'   WHERE PaymentID ='".$ThirdID."' ";								
								}else{
									$strSQLQueryT = "INSERT INTO f_payments SET  PID='".$PID."', ConversionRate = '".$ConversionRate."', OrderID = '".$values['OrderID']."', SuppCode = '".$values['SuppCode']."',  CreditID='".$values['CreditID']."', ReferenceNo='".$values['CreditID']."', CreditAmnt  = ENCODE('".$taxAmnt."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$values['Currency']."' , OriginalAmount=ENCODE('".$OriginalTax. "','".$Config['EncryptKey']."'), TransactionType='C'";						}										
								//$this->query($strSQLQueryT, 0);
							}else{
								$DeleteThird = 1;
							}
							/**************************/



				
						}


						if($DeleteSecond==1 && $SecondID>0){
							$strSQL2 = "delete from f_payments where PaymentID = '".$SecondID."'"; 
							//$this->query($strSQL2, 0);	
						}

						if($DeleteThird==1 && $ThirdID>0){
							$strSQL3 = "delete from f_payments where PaymentID = '".$ThirdID."'"; 
							//$this->query($strSQL3, 0);
						}


						echo 'Done<br><br>';exit;   

						$updateCount++;

				  }
					 
				}
			  }
			}
		}

		echo $updateCount.' records are updated.';exit;
		
	}



	/************* Email Statement Setting ************/
	function GetCronSettings($EntryType){
		if(!empty($EntryType)){		 	
			$strSQLQuery ="select * from f_cron_setting where EntryType = '".$EntryType."'";
			return $this->query($strSQLQuery, 1);
		}
	}

		
	function UpdateCronSettings($arryDetails,$EntryType){ 
                   global $Config;
		   extract($arryDetails);

                   if($EntryInterval == 'daily'){$EntryMonth='';$EntryWeekly = '';$EntryDate = '0';} 
                   if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';} 
                   if($EntryInterval == 'biweekly'){$EntryMonth='';$EntryDate = '0';}  
                   if($EntryInterval == 'semi_monthly'){$EntryMonth='';$EntryWeekly = '';$EntryDate = '0';}   
                   if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                   if($EntryInterval == 'quaterly'){$EntryMonth='';$EntryWeekly = '';}
                   if($EntryInterval == 'half-yearly'){$EntryMonth='';$EntryWeekly = '';}
                   if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                   if($Status != '1'){$EntryInterval = '';}   
		if(!empty($EntryType)){	
			$strSQLQuery = "UPDATE f_cron_setting SET  EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', 
		EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' , Status = '".$Status."' where EntryType = '".$EntryType."' ";

			$this->query($strSQLQuery, 0);
			return 1;
		} 
	}

	function GetShippingInfoByInvoice($trackingId,$InvoiceID){
			
			 if(!empty($trackingId)){
				$addsql = " and trackingId = '".$trackingId."'";
			 }else{
				$addsql = " and RefID = '".$InvoiceID."'";
			 }

		         $strSQLQuery = "select * from w_shipment where 1 ".$addsql." order by ShipmentID desc limit 0,1";
			 $results=$this->query($strSQLQuery,1);
			 return $results;
			
		}
	
	/************* Email Statement End ************/

}

?>
