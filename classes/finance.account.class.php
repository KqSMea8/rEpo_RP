<?php

class BankAccount extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function BankAccount(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}


/*******************************Bank Account Functions Start********************************************************************/
                function getBankAccount($RangeFrom=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
                        global $Config;
				if(!empty($Config['pop'])){
					$Status='Yes';
				}
                         $strAddQuery = "where 1 ";
			(empty($Config['BankAccount']))?($Config['BankAccount']=''):(""); 
		(empty($Config['NormalAccount']))?($Config['NormalAccount']=''):(""); 
		(empty($Config['ExcludeAccount']))?($Config['ExcludeAccount']=''):(""); 
		(empty($Config['IncludeAccount']))?($Config['IncludeAccount']=''):(""); 


					$SearchKey   = strtolower(trim($SearchKey));
					$strAddQuery .= (!empty($Status))?(" AND f.Status='".$Status."'"):("");
					if($SearchKey=='active' && ($SortBy=='f.Status' || $SortBy=='') ){
						$strAddQuery .= " AND f.Status='Yes'"; 
					}else if($SearchKey=='inactive' && ($SortBy=='f.Status' || $SortBy=='') ){
						$strAddQuery .= " AND f.Status='No'";
					}else if($SortBy != '' && $SortBy!='f.CustCode'){
						$strAddQuery .= (!empty($SearchKey))?(" AND (".$SortBy." like '".$SearchKey."%')"):("");
					}			 
				   else{
						$strAddQuery .= (!empty($SearchKey))?(" AND (f.BankName like '".$SearchKey."%' or f.AccountName like '%".$SearchKey."%' or f.AccountNumber like '%".$SearchKey."%' or f.AccountCode like '%".$SearchKey."%' or f.AccountType like '%".$SearchKey."%') "):("");
					}

			 $InnerDateRange='';
			if(!empty($RangeFrom)){
				$strAddQuery .= ' AND f.RangeFrom = '.$RangeFrom.'';
				if($RangeFrom>=4000){ //P & L account
					$FromYear = date("Y");
					$FromDate = date($FromYear.'-01-01');
					$InnerDateRange = " and p.PaymentDate>='".$FromDate."'";
				}
			}
			 
                                        

                                      if(!empty($Config['RootAccount'])) $strAddQuery .= ' AND f.GroupID=0 ';  
				      if(!empty($Config['BankAccount'])) $strAddQuery .= ' AND f.BankFlag=1 ';  
				      if(!empty($Config['NormalAccount'])) $strAddQuery .= ' AND f.BankFlag=0 '; 

                                        
					$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by f.AccountNumber ");
					$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" ASC");

						  
							//$strSQLQuery = "select f.*,(select SUM(Amount)  from f_payments p WHERE p.PaidTo = f.BankAccountID) as ReceivedAmnt,(select SUM(Amount)  from f_payments p WHERE p.PaidFrom = f.BankAccountID) as PaidAmnt from f_account f ".$strAddQuery;

$strSQLQuery = "select f.*,(select SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID AND p.PostToGL = 'Yes' ".$InnerDateRange.") as ReceivedAmnt,(select SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID AND p.PostToGL = 'Yes' ".$InnerDateRange.") as PaidAmnt,t.AccountType as Type from f_account f left outer join f_accounttype t on t.RangeFrom = f.RangeFrom ".$strAddQuery;
					//echo $strSQLQuery;die;
                    return $this->query($strSQLQuery, 1);
                }
                
	        function getAccountByAccountNumber($AccountNumber)
                {
			$strSQLQuery = "select f.BankAccountID,f.AccountName,f.AccountNumber from f_account f where f.AccountNumber = '".$AccountNumber."'";		
			return $this->query($strSQLQuery, 1);			               
                }              

                function getBankAccountNameByID($id)
                {
                     $strSQLQuery = "select AccountName,AccountNumber from f_account where BankAccountID = '".mysql_real_escape_string($id)."'";
                     //echo $strSQLQuery;exit;
                    $arryRow = $this->query($strSQLQuery, 1);
                     return $arryRow[0]['AccountName'];
                    
                }

	   function getAccountNameByID($id)
                {
                     $strSQLQuery = "select AccountName,AccountNumber from f_account where BankAccountID = '".mysql_real_escape_string($id)."'";
                     //echo $strSQLQuery;exit;
                     return $this->query($strSQLQuery, 1);
                    
                }

	function getBankAccountWithAccountType()
		{
			global $Config;
		$strAddQuery=''; $strAddOR='';

		(empty($Config['BankAccount']))?($Config['BankAccount']=''):(""); 
		(empty($Config['NormalAccount']))?($Config['NormalAccount']=''):(""); 
		(empty($Config['ExcludeAccount']))?($Config['ExcludeAccount']=''):(""); 
		(empty($Config['IncludeAccount']))?($Config['IncludeAccount']=''):(""); 


		if($Config['BankAccount']==1) $strAddQuery .= " AND f.BankFlag='1' ";  
		if($Config['NormalAccount']==1) $strAddQuery .= " AND f.BankFlag='0' "; 
		if($Config['ExcludeAccount']!='') $strAddQuery .= " AND f.BankAccountID not in(".$Config['ExcludeAccount'].") "; 
			
		if($Config['IncludeAccount']!='') $strAddOR .= " OR f.BankAccountID in(".$Config['IncludeAccount'].") "; 

 
		    $strSQLQuery = "select distinct(f.BankAccountID), REPLACE(f.AccountName,'\'','') as AccountName,f.AccountNumber, f.DefaultAccount,f.BankFlag, f.BankCurrency, t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.RangeFrom = f.RangeFrom  WHERE ( f.Status = 'Yes' ".$strAddQuery." )  ".$strAddOR." order by f.AccountNumber";
		

		   
                    return $this->query($strSQLQuery, 1);
		}

function getBankAccountForReceivePayment()
		{
			//b.AccountType IN(8,16) and
			 $strSQLQuery = "select b.BankAccountID,b.AccountName,b.AccountNumber, b.DefaultAccount ,b.BankCurrency, t.AccountType,t.AccountTypeID from f_account	 b left outer join f_accounttype t on t.RangeFrom = b.RangeFrom  WHERE  b.Status = 'Yes' and b.BankFlag = '1' order by b.AccountName";
			//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

function getBankAccountForPaidPayment()
		{
			//b.AccountType IN(16,19) and
			 $strSQLQuery = "select b.BankAccountID,b.AccountName,b.AccountNumber,b.BankCurrency, b.DefaultAccount,t.AccountType,t.AccountTypeID from f_account b left outer join f_accounttype t on t.RangeFrom = b.RangeFrom  WHERE  b.Status = 'Yes' and b.BankFlag = '1'  order by b.AccountName";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

function getBankAccountForTransfer()
		{
			// b.AccountType IN(6,7,5,8,9,11,16,19) and 
			 $strSQLQuery = "select b.BankAccountID,b.AccountName,t.AccountType,t.AccountTypeID from f_account b left outer join f_accounttype t on t.RangeFrom = b.RangeFrom  WHERE b.Status = 'Yes' and b.BankFlag = '1'  order by b.AccountName";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

 function getBankAccountByAccountType($id)
                {
			$strAddQuery='';
		if(!empty($id)){$strAddQuery .= " where t.AccountTypeID = '".$id."'";}                    

		$strSQLQuery = "select t.AccountType,t.AccountTypeID from f_accounttype t  ".$strAddQuery." order by t.AccountTypeID ASC";
		
                
		return $this->query($strSQLQuery, 1);
                }

function  GetSubAccountTree($ParentID,$num)
		     {
		           global $Config;
			 
		           $edit = $Config['editImg'];
		           $delete = $Config['deleteImg'];
			   $view = $Config['viewImg'];
                           $history = $Config['history'];
                           
                           //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_account WHERE ParentAccountID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $num=$num+5;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				/*$ReceivedAmnt = $values['ReceivedAmnt'];
				$PaidAmnt = $values['PaidAmnt'];
				$Balance = $ReceivedAmnt-$PaidAmnt;*/
                                
                              $Balance = $this->getAccountBalance($values['BankAccountID'],$values['AccountType']);
                                
                                $htmlAccount = '<tr align="left" bgcolor="#ffffff">
                                 <td>';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= $values['AccountName'];

			 $htmlAccount .= '</td>';
                         $htmlAccount .= '<td>'.$values['AccountNumber'].'</td>
                            <!--<td>'.$values['AccountCode'].'</td>-->
                            <td align="right"><strong>'.number_format($Balance,2,'.','').'</strong></td>
                            <td align="center" >';  
                                if ($values['Status'] == "Yes") {
                                    $status = 'Active';
                                } else {
                                    $status = 'InActive';
                                }



                        $htmlAccount .= '<a href="editAccount.php?active_id=' . $values["BankAccountID"] . '&ParentID=' . $values['ParentAccountID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>
                        
                        </td>
                            <td height="26" align="center" class="head1_inner" valign="top">
                            
			        <a href="vAccount.php?view='.$values['BankAccountID'].'&curP='.$_GET['curP'].'">'.$view.'</a>';	
                                 if($Balance == 0 && $values['CashFlag'] != 1) {    
                                $htmlAccount .= '<a href="editAccount.php?edit='.$values['BankAccountID'].'&ParentID='.$values['ParentAccountID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlAccount .= '<a href="editAccount.php?del_id='.$values['BankAccountID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentAccountID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';
                                 }
                $htmlAccount .= '<a href="accountHistory.php?accountID='.$values['BankAccountID'].'&accountType='.$values['AccountType'].'" target="_blank">'.$history.'</a>';				
                                

                                $htmlAccount .= '&nbsp;</td>
                        </tr>';
                                  
                                  
                                
                                echo $htmlAccount;
                                  
                                  
                                  if($values['ParentAccountID'] > 0)
                                  {
                                    $this->GetSubAccountTree($values['BankAccountID'],$num); 
                                  }
                                }  
             
		}


function  GetSubChartAccountTree($AccountTypeID,$ParentID,$num)
		     {
		        global $Config;

			$edit = $Config['editImg'];
			$delete = $Config['deleteImg'];
			$view = $Config['viewImg'];
			$history = $Config['history'];

			$objBankAccount=new BankAccount();
			$groupAccountName=$objBankAccount->getGroupAccountByAccountType($AccountTypeID);

			foreach($groupAccountName as $key=>$values){
				echo $values['GroupName'].'<br>';
			}



                           
                           //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_account WHERE ParentAccountID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $num=$num+5;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				/*$ReceivedAmnt = $values['ReceivedAmnt'];
				$PaidAmnt = $values['PaidAmnt'];
				$Balance = $ReceivedAmnt-$PaidAmnt;*/
                                
                              $Balance = $this->getAccountBalance($values['BankAccountID'],$values['AccountType']);
                                
                                $htmlAccount = '<tr align="left" bgcolor="#ffffff">
                                 <td>';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= $values['AccountName'];

			 $htmlAccount .= '</td>';
                         $htmlAccount .= '<td>'.$values['AccountNumber'].'</td>
                            <!--<td>'.$values['AccountCode'].'</td>-->
                            <td align="right"><strong>'.number_format($Balance,2,'.','').'</strong></td>
                            <td align="center" >';  
                                if ($values['Status'] == "Yes") {
                                    $status = 'Active';
                                } else {
                                    $status = 'InActive';
                                }



                        $htmlAccount .= '<a href="editAccount.php?active_id=' . $values["BankAccountID"] . '&ParentID=' . $values['ParentAccountID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>
                        
                        </td>
                            <td height="26" align="center" class="head1_inner" valign="top">
                            
			        <a href="vAccount.php?view='.$values['BankAccountID'].'&curP='.$_GET['curP'].'">'.$view.'</a>';	
                                 if($Balance == 0 && $values['CashFlag'] != 1) {    
                                $htmlAccount .= '<a href="editAccount.php?edit='.$values['BankAccountID'].'&ParentID='.$values['ParentAccountID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlAccount .= '<a href="editAccount.php?del_id='.$values['BankAccountID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentAccountID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';
                                 }
                $htmlAccount .= '<a href="accountHistory.php?accountID='.$values['BankAccountID'].'&accountType='.$values['AccountType'].'" target="_blank">'.$history.'</a>';				
                                

                                $htmlAccount .= '&nbsp;</td>
                        </tr>';
                                  
                                  
                                
                                echo $htmlAccount;
                                  
                                  
                                  if($values['ParentAccountID'] > 0)
                                  {
                                    $this->GetSubAccountTree($values['BankAccountID'],$num); 
                                  }
                                }  
             
		}


		function getAccountByAccountType($accountType)
		{
			 
			$strAddQuery = " where AccountType = '".$accountType."' and LocationID='".$_SESSION['locationID']."' and Status = 'Yes'";
			$strSQLQuery = "select * from f_account ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}


		function isBankAccountExists($AccountNumber,$BankAccountID=0)
		{
		    $strSQLQuery = (!empty($BankAccountID))?(" and BankAccountID != '".$BankAccountID."'"):("");
			$strSQLQuery = "SELECT AccountNumber FROM f_account WHERE LCASE(AccountNumber)='".strtolower(trim($AccountNumber))."' ".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['AccountNumber'])) {
				return true;
			} else {
				return false;
			}
		}


		function isBankAccountNumberExists($BankAccountNumber,$BankAccountID=0)
		{
		    $strSQLQuery = (!empty($BankAccountID))?(" and BankAccountID != '".$BankAccountID."'"):("");
			$strSQLQuery = "SELECT BankAccountID FROM f_account WHERE BankFlag='1' and LCASE(BankAccountNumber)='".strtolower(trim($BankAccountNumber))."' ".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['BankAccountID'])) {
				return true;
			} else {
				return false;
			}
		}


		
		function getCashAccount($LocationID,$cashFlag)
		{
		    $strSQLQuery = (!empty($LocationID))?(" and LocationID = '".$LocationID."'"):("");
			$strSQLQuery = "SELECT AccountName FROM f_account WHERE LCASE(CashFlag)='".$cashFlag."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);
			//echo "=>".$strSQLQuery;exit;
			return $this->numRows();
			 
		}
              
                
                function addBankAccount($arryDetails)
                {

			 
                    
                       
			@extract($arryDetails);
			global $Config;

			if(empty($Status)) $Status="Yes";
			$ipaddress = GetIPAddress(); 

			if(empty($CashFlag)) $CashFlag=0;
                        
                        $strSQLQuery = "INSERT INTO f_account SET AccountName = '".$AccountName."', AccountNumber='".$AccountNumber."', AccountCode='".$AccountCode."', Currency='". $Config['Currency']."',Status = '".$Status."',  CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."',CashFlag='".$CashFlag."',GroupID='".$main_ParentGroupID."', RangeFrom='".$RangeFrom."', RangeTo='".$RangeTo."', AccountType='".$AccountType."', BankName='".$BankName."', Address='".$Address."', BankFlag='".$BankFlag."', DefaultAccount='".$DefaultAccount."' , BankAccountNumber='".$BankAccountNumber."' , NextCheckNumber='".$NextCheckNumber."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , BankCurrency='".$BankCurrency."', AccountGainLoss='".$AccountGainLoss."' ";
					 
                        $this->query($strSQLQuery,0);
                        $BankAccountID = $this->lastInsertId();

			if($DefaultAccount==1){                
			     $sql="update f_account set DefaultAccount='0' where BankAccountID!='".mysql_real_escape_string($BankAccountID)."'";
			     $this->query($sql,0);                    
			}


                        return $BankAccountID;
                   
                }

function updateBankAccount($arryDetails)
                {
			@extract($arryDetails);
			global $Config;

			if(empty($Status)) $Status="Yes";
			$ipaddress = GetIPAddress(); 
                        
                        $strSQLQuery = "UPDATE f_account SET AccountName = '".$AccountName."', AccountNumber='".$AccountNumber."', AccountCode='".$AccountCode."', Currency='". $Config['Currency']."',  Status = '".$Status."',  UpdateddDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."',CashFlag='".$CashFlag."',GroupID='".$main_ParentGroupID."', RangeFrom='".$RangeFrom."',RangeTo='".$RangeTo."', AccountType='".$AccountType."', BankName='".$BankName."', Address='".$Address."', BankAccountNumber='".$BankAccountNumber."' ,NextCheckNumber='".$NextCheckNumber."' ,DefaultAccount='".$DefaultAccount."', BankCurrency='".$BankCurrency."', AccountGainLoss='".$AccountGainLoss."' WHERE BankAccountID = '".$EditBankAccountID."'";
					 
                     $this->query($strSQLQuery,0);
                     

			if($DefaultAccount==1){                
			     $sql="update f_account set DefaultAccount='0' where BankAccountID!='".mysql_real_escape_string($EditBankAccountID)."'";
			     $this->query($sql,0);                    
			}



                   
                }
				
			 
		function RemovePaymentByID($PaymentID)
		{
	
			$strSQLQuery = "DELETE FROM f_payments WHERE PaymentID ='".$PaymentID."' "; 
			$this->query($strSQLQuery, 0);
			return 1;

		}	 
               
		function RemoveBankAccount($BankAccountID)
		{

			//$strSQLQuery = "INSERT INTO f_archive_bank_account SELECT * FROM f_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."' AND LocationID = '".$_SESSION['locationID']."'";
			//$this->query($strSQLQuery, 0);
	
			$strSQLQuery = "DELETE FROM f_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."' "; 
			$this->query($strSQLQuery, 0);
			return 1;

		}
                
		function changeBankAccountStatus($BankAccountID)
		{
				$strSQLQuery = "SELECT * FROM f_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'"; 
				$rs = $this->query($strSQLQuery);
				if(sizeof($rs))
				{
					if($rs[0]['Status']== "Yes")
							$Status="No";
					else
							$Status="Yes";

					$strSQLQuery = "UPDATE f_account SET Status ='".$Status."' WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'"; 
					$this->query($strSQLQuery,0);
					return true;
				}			
		}
		   function getGroupAccountById($GroupID)
			{
					$strSQLQuery = "SELECT * from f_group WHERE GroupID ='".mysql_real_escape_string($GroupID)."'";
					return $this->query($strSQLQuery, 1);
			}
	   function getBankAccountById($BankAccountID)
			{
					$strSQLQuery = "SELECT f.*, t.ReportType from f_account f left outer join f_accounttype t on f.RangeFrom=t.RangeFrom WHERE f.BankAccountID ='".mysql_real_escape_string($BankAccountID)."'";
					return $this->query($strSQLQuery, 1);
			}
                function getAccountTypeName($RangeFrom)
			{
				if(!empty($RangeFrom)){
					$strSQLQuery = "SELECT AccountType from f_accounttype WHERE RangeFrom ='".mysql_real_escape_string($RangeFrom)."'";
					$rows = $this->query($strSQLQuery, 1);
					$accountType = $rows[0]['AccountType'];
					return $accountType; 
				}
			}
             function getParentAccountName($ParentAccountID)
			{
					$strSQLQuery = "SELECT AccountName from f_account WHERE BankAccountID ='".mysql_real_escape_string($ParentAccountID)."'";
					$rows = $this->query($strSQLQuery, 1);
					$accountType = $rows[0]['AccountName'];
					return $accountType; 
			}
			
		function UpdateCountyStateCity($arryDetails,$BankAccountID){   
				extract($arryDetails);		

				$strSQLQuery = "UPDATE f_account SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'";
				$this->query($strSQLQuery, 0);
				return 1;
			}


		function getModuleCurrency($BankAccountID,$SearchKey,$FromDate,$ToDate)
		{               
                                global $Config;
				$strAddQuery = "where p.PostToGL = 'Yes' and p.ModuleCurrency!='' and p.ModuleCurrency!='".$Config['Currency']."' and p.ConversionRate>0 and p.TransactionType in ('C','D') ";
				$SearchKey   = strtolower(trim($SearchKey));
				$strAddQuery .= ($BankAccountID>0)?(" and (p.AccountID = '".$BankAccountID."')"):("");
				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			        $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");   
         			

				 
				$strAddQuery .= " order by p.PaymentDate ASC,p.PaymentID Asc";

				$strSQLQuery = "select distinct(p.ModuleCurrency) from f_payments p ".$strAddQuery;
				
				return $this->query($strSQLQuery, 1);
		}


		function getBankAccountHistory($BankAccountID,$SearchKey,$FromDate,$ToDate)
		{               
                                global $Config;
				$strAddQuery = "where p.PostToGL = 'Yes'";
				$SearchKey   = strtolower(trim($SearchKey));
				$strAddQuery .= ($BankAccountID>0)?(" and (p.AccountID = '".$BankAccountID."')"):("");
				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			        $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                                
				 $strAddQuery .= (!empty($Config['ModuleCurrencySel']))?(" and p.ModuleCurrency='".$Config['ModuleCurrencySel']."' and p.TransactionType in ('C','D')   "):("");
                                 
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FullName like '".$SearchKey."%' or p.ReferenceNo like '%".$SearchKey."%' or p.PaymentType like '%".$SearchKey."%') "):("");
				#$strAddQuery .= " order by p.PaymentDate ASC,p.PaymentID Asc";

				$strAddQuery .= " order by p.PaymentDate ASC,p.CustID asc,p.SuppCode, p.PaymentID Asc";

				 $strSQLQuery = "select  distinct(p.PaymentID), p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, DECODE(p.OriginalAmount,'". $Config['EncryptKey']."') as OriginalAmnt, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName, b.AccountName,CONCAT(s.FirstName,' ',s.LastName) as SupplierName, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName,p2.TransactionID as PidTransactionID from f_payments p left outer join f_payments p2 on (p.PID=p2.PaymentID and p.PID>0) left outer join s_customers c on (c.Cid = p.CustID) left outer join f_account b on b.BankAccountID = p.AccountID left outer join p_supplier s on   s.SuppCode =  p.SuppCode ".$strAddQuery;
				 
// or BINARY c.CustCode = BINARY p.CustCode
				
				return $this->query($strSQLQuery, 1);
		}

		function isAccountDataExist($FromDate,$ToDate)
		{               
                                global $Config;
				$strAddQuery = " ";				
				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			        $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                               
				$strSQLQuery = "select p.PaymentID from f_payments p where p.PostToGL = 'Yes' ".$strAddQuery." limit 0,1";
				$arryRow = $this->query($strSQLQuery,1);
				if($arryRow[0]['PaymentID']>0){
					return true;
				}
		}


		
		function getTransactionReceiptID($TransactionID)
		{               
                              $strSQLQuery = "select ReceiptID from f_transaction where TransactionID = '".$TransactionID."'  ";
				$arryRow = $this->query($strSQLQuery,1);
				 
				return $arryRow[0]['ReceiptID'];
				 
		}


		function getBeginningBalance($BankAccountID,$ToDate)
		{               
                        global $Config;

			$this->SetCashOnlySql();

			$strAddQuery = $Config["CashOnlyJoin"]. " where p.PostToGL = 'Yes' ".$Config["CashOnlyWhere"];
 
			$strAddQuery .= ($BankAccountID>0)?(" and p.AccountID = '".$BankAccountID."' "):("");


			if(!empty($Config['BegBalForCurrentYear'])){
				$FromYear = date("Y",strtotime($ToDate));

				$FromDate = date($FromYear.'-01-01');
				$strAddQuery .= " and p.PaymentDate>='".$FromDate."'";
			}

			 


		       $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<'".$ToDate."'"):("");
                     


			if(!empty($Config['ModuleCurrencySel'])){				
				$strAddQuery .= " and p.ModuleCurrency='".$Config['ModuleCurrencySel']."'";
				 
				$strSQLQuery = "select SUM(DECODE(p.OriginalAmount,'". $Config['EncryptKey']."')) as TotalDebit from f_payments p  ".$strAddQuery." and p.TransactionType='D'";
				$arryDebit = $this->query($strSQLQuery,1);
				$TotalDebit = $arryDebit[0]['TotalDebit'];

				$strSQLQuery2 = "select SUM(DECODE(p.OriginalAmount,'". $Config['EncryptKey']."')) as TotalCredit from f_payments p  ".$strAddQuery." and p.TransactionType='C'";
				$arryCredit = $this->query($strSQLQuery2,1);
				$TotalCredit = $arryCredit[0]['TotalCredit'];
			}else{
				$strSQLQuery = "select SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalDebit,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as TotalCredit  from f_payments p  ".$strAddQuery;
				$arryBal = $this->query($strSQLQuery,1);
				$TotalCredit = $arryBal[0]['TotalCredit'];
				$TotalDebit = $arryBal[0]['TotalDebit'];				
			}
			 
		 

			$TotalDebit = round($TotalDebit,2);
			$TotalCredit = round($TotalCredit,2);


			if(!empty($Config['CreditMinusDebit'])){
				$Bal = $TotalCredit - $TotalDebit;
			}else{
				$Bal = $TotalDebit - $TotalCredit;
			}

			return $Bal;
		}


		function addTransfer($arryDetails)
		{
                        global $Config;
			extract($arryDetails);
			
			$ipaddress = GetIPAddress(); 	
			
			$strSQLQuery = "INSERT INTO f_transfer SET  TransferAmount = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."'), TransferFrom = '".$TransferFrom."', TransferTo = '".$TransferTo."', ReferenceNo = '".addslashes($ReferenceNo)."',TransferDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);	
			$TransferID = $this->lastInsertId();

		if($TransferFrom > 0){
			$strSQLQuery = "INSERT INTO f_payments SET  CreditAmnt = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$TransferFrom."', TransferID = '".$TransferID."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Transfer',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			}

		if($TransferTo > 0){
			$strSQLQuery = "INSERT INTO f_payments SET  DebitAmnt = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$TransferTo."', TransferID = '".$TransferID."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Transfer',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			}
		
		}

		function getTransfer($arryDetails)
			{
                                global $Config;
				extract($arryDetails);
				
				$strAddQuery = " where 1 ";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($TransferID>0)?(" and t.TransferID = '".$TransferID."'"):("");
                                $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
				$strAddQuery .= (!empty($FromDate))?(" and t.TransferDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and t.TransferDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (t.ReferenceNo like '%".$SearchKey."%' or DECODE(t.TransferAmount,'". $Config['EncryptKey']."') like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by t.TransferID Desc";

				$strSQLQuery = "select t.*,DECODE(t.TransferAmount,'". $Config['EncryptKey']."') as TransferAmount, b.AccountName as TransferFrom,ba.AccountName as TransferTo from f_transfer t left outer join f_account b on b.BankAccountID = t.TransferFrom left outer join f_account ba on ba.BankAccountID = t.TransferTo ".$strAddQuery;
				//echo $strSQLQuery;
				return $this->query($strSQLQuery, 1);
			}

		function RemoveTransfer($TransferID)
		{
			
                    /******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_transfer SELECT * FROM f_transfer WHERE TransferID ='".mysql_real_escape_string($TransferID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE TransferID ='".mysql_real_escape_string($TransferID)."'";
			$this->query($strSQLQuery, 0);


			/*************************************************/
                    
			$strSQLQuery = "DELETE FROM f_transfer WHERE TransferID ='".mysql_real_escape_string($TransferID)."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery1 = "DELETE FROM f_payments WHERE TransferID ='".mysql_real_escape_string($TransferID)."'"; 
			$this->query($strSQLQuery1, 0);

		}


		function getDeposit($arryDetails)
		  {
                         global $Config;
			extract($arryDetails);
			
			$strAddQuery = " where 1 ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= ($DepositID>0)?(" and d.DepositID = '".$DepositID."'"):("");
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			$strAddQuery .= (!empty($FromDate))?(" and d.DepositDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and d.DepositDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SearchKey))?(" and (d.ReferenceNo like '%".$SearchKey."%' or DECODE(d.Amount,'". $Config['EncryptKey']."') like '%".$SearchKey."%') "):("");
			$strAddQuery .= " order by d.DepositID Desc";

			$strSQLQuery = "select d.*,DECODE(d.Amount,'". $Config['EncryptKey']."') as Amount, b.AccountName,CONCAT(c.FirstName,' ',c.LastName) as Customer  from f_deposit d left outer join f_account b on b.BankAccountID = d.AccountID left outer join s_customers c on c.Cid = d.ReceivedFrom ".$strAddQuery;
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		     }
		
		function addBankDeposit($arryDetails)
		{
			 extract($arryDetails);
			 global $Config;
			 $ipaddress = GetIPAddress(); 
			
		$strSQLQuery = "INSERT INTO f_deposit SET  AccountID = '".$AccountID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), ReferenceNo = '".$ReferenceNo."',DepositDate = '".$DepositDate."', ReceivedFrom = '".$ReceivedFrom."', PaymentMethod = '".$Method."', Comment = '".$Comment."', 
Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', CreatedDate='".$Config['TodayDate']."', IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			$DepositID = $this->lastInsertId();
			

			$strSQLQuery = "INSERT INTO f_payments SET  DebitAmnt = ENCODE('".$Amount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', DepositID = '".$DepositID."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', PaymentDate = '".$DepositDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Deposit',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
                        
                        $strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = ENCODE('".$Amount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '19', DepositID = '".$DepositID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', PaymentDate = '".$DepositDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income', Flag= '1', IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);	
			
		
		}


	function RemoveDeposit($DepositID)
		{
			
                         /******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_deposit SELECT * FROM f_deposit WHERE DepositID ='".mysql_real_escape_string($DepositID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE DepositID ='".mysql_real_escape_string($DepositID)."'";
			$this->query($strSQLQuery, 0);
                        
                      

			/*************************************************/
                        
			$strSQLQuery = "DELETE FROM f_deposit WHERE DepositID ='".mysql_real_escape_string($DepositID)."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery1 = "DELETE FROM f_payments WHERE DepositID ='".mysql_real_escape_string($DepositID)."'"; 
			$this->query($strSQLQuery1, 0);
                        
                       

		}

		
		function addOtherIncome($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$ipaddress = GetIPAddress(); 
			
			$TaxAmount = ($TaxRate*$Amount)/100;
			$TotalAmount = $Amount+$TaxAmount;
			 
			$strSQLQuery = "INSERT INTO f_income SET  Amount = '".$Amount."', TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = '".$TotalAmount."', BankAccount = '".$BankAccount."', ReceivedFrom = '".$ReceivedFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$IncomeTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);	
			$IncomeID = $this->lastInsertId();

			/****Add Payment Transaction******/
				
			$strSQLQueryPay = "INSERT INTO f_payments SET SaleID='".addslashes($ReferenceNo)."', DebitAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);
                        $PID = $this->lastInsertId();
                        
                        $strSQLQueryPay = "INSERT INTO f_payments SET  PID='".$PID."', DebitAmnt = '".$TotalAmount."', AccountID = '".$IncomeTypeID."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income', Flag= '1', IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);
                        
                         if(empty($InvoiceID)){
                                     $InvoiceID = 'INVE'.$PID;
                                }

                        $sql="UPDATE f_payments SET InvoiceID='".$InvoiceID."' WHERE PaymentID='".$PID."'";
                        $this->query($sql,0);	

                        $strSQLQuery = "update f_income SET PID='".$PID."',InvoiceID='".$InvoiceID."' where IncomeID = '".$IncomeID."'";
                        $this->query($strSQLQuery, 0);
		
		}
                
              
		function updateOtherIncome($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$ipaddress = GetIPAddress(); 
			
			$TaxAmount = ($TaxRate*$Amount)/100;
			$TotalAmount = $Amount+$TaxAmount;
			
			$strSQLQuery = "UPDATE f_income SET  Amount = '".$Amount."', TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = '".$TotalAmount."', BankAccount = '".$BankAccount."', ReceivedFrom = '".$ReceivedFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$IncomeTypeID."',UpdatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."' WHERE IncomeID = '".$IncomeID."'";
			$this->query($strSQLQuery, 0);	

			/********Update Payment Transaction******/		
			$strSQLQueryPay = "UPDATE f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."' WHERE IncomeID = '".$IncomeID."' AND Flag != '1'";
		
			$this->query($strSQLQueryPay, 0);
                        
                        $strSQLQueryPay = "UPDATE f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$IncomeTypeID."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."' WHERE IncomeID = '".$IncomeID."' AND Flag = '1'";
		
			$this->query($strSQLQueryPay, 0);
		
		}
		
		function RemoveOtherIncome($IncomeID)
		{
                    
                    
                     /******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_income SELECT * FROM f_income WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'";
			$this->query($strSQLQuery, 0);


			/*************************************************/
                        
			$strSQLQuery = "DELETE FROM f_income WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery1 = "DELETE FROM f_payments WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'"; 
			$this->query($strSQLQuery1, 0);

			return 1;
		}
		
		function getOtherIncome($arryDetails)
			{
                                global $Config;
				extract($arryDetails);
				
				$strAddQuery = " where f.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($IncomeID>0)?(" and f.IncomeID = '".$IncomeID."'"):("");
                                 $strAddQuery .= ($Flag>0)?(" and f.Flag = '1'"):(" and f.Flag != '1'");
				$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '".$SearchKey."%' or f.ReferenceNo like '%".$SearchKey."%' or f.TotalAmount like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by f.IncomeID Desc";

				$strSQLQuery = "select f.*,DECODE(f.Amount ,'". $Config['EncryptKey']."') as Amount,DECODE(f.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, c.Company,CONCAT(c.FirstName,' ',c.LastName) as Customer,b.AccountName  from f_income f left outer join s_customers c on c.Cid = f.ReceivedFrom left outer join f_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
			}

/************************End Bank Account Functions***************************************************************************************************/

/********************************Account Type Functions Start*****************************************************************************************/
		
				function getAccountType($arryDetails)
				{
 
					 @extract($arryDetails);
 
                                            $strAddQuery = " where 1";
 
                                           

					  $SearchKey = (!empty($key))?(strtolower(trim($key))):("");

                                            $strAddQuery .= (!empty($AccountTypeID))?(" and t.AccountTypeID = '".$AccountTypeID."'"):("");

                                            if($SearchKey=='active' && ($SortBy=='f.Status' || $SortBy=='') ){
                                                $strAddQuery .= " and t.Status='Yes'"; 
                                            }else if($SearchKey=='inactive' && ($SortBy=='f.Status' || $SortBy=='') ){
                                                $strAddQuery .= " and t.Status='No'";
                                            }else if(!empty($Status)){
                                                $strAddQuery .= " and t.Status = 'Yes'";
                                            }             
                                             else{
                                            $strAddQuery .= (!empty($SearchKey))?(" and (t.AccountType like '%".$SearchKey."%') "):("");
                                            }
                                            if(!empty($BalanceSheet)) $strAddQuery .= " AND ReportType='BS'"; 
                                            $strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by t.AccountTypeID ");
                                            $strAddQuery .= (!empty($asc))?($asc):(" ASC");
                                            $strSQLQuery = "select t.* from f_accounttype t ".$strAddQuery;
                                             
                                            return $this->query($strSQLQuery, 1);
				}
 

				function addAccountType($arryDetails)
				{
				     @extract($arryDetails);
				     global $Config;
				    
				     $strSQLQuery = "INSERT INTO f_accounttype SET AccountType = '".$AccountType."', Description = '".$Description."', LocationID='".$_SESSION['locationID']."',  Status = '".$Status."',  CreatedDate = '".$Config['TodayDate']."'";
							 
				     $this->query($strSQLQuery,0);
				     $AccountTypeID = $this->lastInsertId();
				     return $AccountTypeID;
				   
				}

				function updateAccountType($arryDetails)
				{
				     @extract($arryDetails);
				     global $Config;
				    
				     $strSQLQuery = "UPDATE f_accounttype SET AccountType = '".$AccountType."', Description = '".$Description."', LocationID='".$_SESSION['locationID']."',  Status = '".$Status."',  UpdatedDate = '".$Config['TodayDate']."' WHERE AccountTypeID = '".$AccountTypeID."'";
							 
				     $this->query($strSQLQuery,0);
				}

				function RemoveAccountType($AccountTypeID)
				{
                                    $strSQLQuery = "INSERT INTO f_archive_account_type SELECT * FROM f_accounttype WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."' AND LocationID = '".$_SESSION['locationID']."'";
                                    $this->query($strSQLQuery, 0);   
                                    $strSQLQuery = "DELETE FROM f_accounttype WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."' AND LocationID = '".$_SESSION['locationID']."'"; 
                                    $this->query($strSQLQuery, 0);
                                    return 1;

				}
                
			function changeAccountTypeStatus($AccountTypeID)
			{
				$strSQLQuery = "SELECT * FROM f_accounttype WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."'"; 
				$rs = $this->query($strSQLQuery);
				if(sizeof($rs))
				{
				if($rs[0]['Status']== "Yes")
					$Status="No";
				else
					$Status="Yes";

				$strSQLQuery = "UPDATE f_accounttype SET Status ='$Status' WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."'"; 
				$this->query($strSQLQuery,0);
				return true;
				}			
			}
/************************End Account Type Functions***********************************************************************************/		


/****************Sales/Purchases Function Start******************/	
                        
                             function getCustomerList($Cid=0)
                            {
				$strAddQuery='';
				$strAddQuery .= (!empty($Cid))?(" and c.Cid='".$Cid."'"):("");

				$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."') or c.SalesID='".$_SESSION['AdminID']."' "):("");

                                $strSQLQuery = "Select c.Cid as custID,c.CustCode,IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,c.CustomerType, c.customerHold, c.PaymentTerm from  s_customers c where c.Status = 'Yes' ".$strAddQuery." having CustomerName!='' ORDER BY CustomerName ASC";
				if(!empty($_GET['pk'])) echo $strSQLQuery;
                                return $this->query($strSQLQuery, 1);

                            }
                            
                             function getVendorList($SuppCode='')
                                {
				    $strAddQuery = (!empty($SuppCode))?(" and s.SuppCode='".$SuppCode."'"):("");
                                    $strSQLQuery = "Select s.SuppID,s.SuppCode,s.UserName,s.CompanyName, s.Currency , s.PaymentTerm, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  from  p_supplier s where s.Status = '1'  ".$strAddQuery." having VendorName!='' ORDER BY VendorName ASC";
                                    return $this->query($strSQLQuery, 1);

                                }
                                
                                function  ListUnpaidPurchaseInvoice($arryDetails)
                                {
                                        global $Config;
                                        extract($arryDetails);

                                        $ModuleID = "PurchaseID"; 
					$SearchKey   = strtolower(trim($key));
					$strAddQuery = " where o.Module='Invoice' and o.SuppCode = '".$SuppCode."'"; 
					

					$where1 = " o.PostToGL='1' and o.InvoiceID != '' and o.ReturnID = ''  and o.Approved='1' and o.InvoicePaid!='1'  ";			
					if(!empty($BankCurrency)){
                                           $BankCurrencySql = " and o.Currency = '".$BankCurrency."'  ";
                                        }		
                                                                             
					if(!empty($InvoiceIDP)){
                                           $strAddQuery .= " and ( o.InvoiceID in (".$InvoiceIDP.") or (".$where1.") ) ".$BankCurrencySql;
					   $groupby = ' group by o.InvoiceID' ;
                                        }else{
					   $strAddQuery .= " and ".$where1.$BankCurrencySql ;
					    $groupby ='';	
					}

					if(!empty($ExcludeInvoiceIDs)){
                                           $strAddQuery .= " and o.InvoiceID not in (".$ExcludeInvoiceIDs.")  ";
                                        }
					
					
					if(!empty($SearchKey)){
                                           $strAddQuery .= " and (o.InvoiceID like '%".$SearchKey."%' or o.PurchaseID like '%".$SearchKey."%')  ";
                                        }


					$strAddQuery .= $groupby ;


					if(!empty($Config['GetNumRecords'])){
						$Columns = " count(o.OrderID) as NumCount ";				
					}else{	
						$Columns = "  (SELECT SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) FROM f_payments p WHERE p.InvoiceID = o.InvoiceID and p.PaymentType='Purchase' and p.InvoiceID!='') AS paidAmnt, (SELECT SUM(tr.OriginalAmount) FROM f_transaction_data tr WHERE tr.InvoiceID = o.InvoiceID and tr.PaymentType in ('Invoice','Contra Invoice') and tr.Voided='0' and tr.InvoiceID!='') AS paidAmntTr, o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID,o.ExpenseID,  o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid,o.InvoiceEntry  ";

						$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.PostedDate Asc, o.OrderID Asc ");

 
						if(!empty($Config['RecordsPerPage'])){
							$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
						}
	
                                        	
					}
					
					
                                        $strSQLQuery = "select ".$Columns." from p_order o ".$strAddQuery." ";

                                       //if($Config['GetNumRecords']!=1){ echo "=>".$strSQLQuery; }
                                        return $this->query($strSQLQuery, 1);		

                                }
				
				function  ListReceivePaymentInvoice($arryDetails)
				{
					global $Config;
                                       extract($arryDetails);
					
					$strAddQuery = " where 1 ";
					$SearchKey   = strtolower(trim($key));
					

					$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
					$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                                      
                                        if($SearchKey == "partially paid"){$SearchKey = "part paid";}
					
				if($sortby != ''){
					if($sortby=='o.CustomerName' && !empty($SearchKey)){
						$strAddQuery .= " and ( c.Company like '%".$SearchKey."%' or c.FullName like '%".$SearchKey."%' )";
					}else if($sortby=='p.DebitAmnt' && !empty($SearchKey)){
						
						$strAddQuery .= " and ( DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') like '%".$SearchKey."%' )";
					}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
					}
				}else{
					
					$strAddQuery .= (!empty($SearchKey))?(" and (p.InvoiceID like '%".$SearchKey."%' or p.CreditID like '%".$SearchKey."%' or b.AccountNumber like '%".$SearchKey."%' or p.SaleID like '%".$SearchKey."%' or p.PaymentDate like '%".$SearchKey."%' or p.DebitAmnt like '%".$SearchKey."%' or  o.InvoicePaid = '".$SearchKey."'  or c.Company like '%".$SearchKey."%' or c.FullName like '%".$SearchKey."%'  or DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') like '%".$SearchKey."%' ) " ):("");
				}



	                                $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
					//$strAddQuery .= " and p.InvoiceID != '' and p.SaleID != '' and o.ReturnID='' and o.CreditID=''";
					$strAddQuery .= " and (p.InvoiceID != '' or p.CreditID!='' or p.GLID!='' ) and (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')";

					$strAddQuery .= (!empty($Status))?(" and p.Status='".$Status."'"):("");
					$strAddQuery .= (!empty($InvoicePaid))?(" and p.InvoicePaid='".$InvoicePaid."'"):("");
					$strAddQuery .= (!empty($PostToGL))?(" and p.PostToGL='".$PostToGL."'"):("");

					$strAddQuery .= (!empty($CustID))?(" and p.CustID='".$CustID."'"):("");
					$strAddQuery .= (!empty($InvoiceGL))?(" and (p.InvoiceID like '%".$InvoiceGL."%' or p.CreditID like '%".$InvoiceGL."%' or b.AccountNumber like '%".$InvoiceGL."%') "):("");

					$strAddQuery .= ($Status=='Open')?(" and p.Approved='1'"):("");

					#$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by p.PostToGL desc,p.OrderID desc, p.PaymentDate desc,p.PaymentID desc ");
					
					/*$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" ORDER BY p.PostToGL desc, 
  CASE WHEN p.PostToGL='Yes' THEN p.OrderID END DESC, 
  CASE WHEN p.PostToGL!='Yes' THEN p.PaymentID END DESC
, p.PaymentDate desc ");	*/

				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" ORDER BY p.PostToGL desc, CASE WHEN p.PostToGL = 'Yes' THEN p.OrderID ELSE 0 END DESC, p.PaymentDate desc,p.PaymentID desc ");



				if($Config['GetNumRecords']==1){
					$Columns = " count(p.PaymentID) as NumCount ";					
				}else{		
					if($Config['RecordsPerPage']>0){	
						$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
					}
					$Columns = "  p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, o.InvoicePaid, o.InvoiceEntry, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber  ";
				}



					#$strSQLQuery = "select p.,o.InvoicePaid,o.CustomerName,o.InvoiceEntry from f_payments p left outer join s_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
                                      $strSQLQuery = "select ".$Columns." from f_payments p left outer join s_order o on (o.InvoiceID = p.InvoiceID and o.Module='Invoice') left outer join s_customers c on p.CustID=c.Cid left outer join f_account b on b.BankAccountID = p.GLID   ".$strAddQuery;

					//if($Config['GetNumRecords']!=1){echo $strSQLQuery;}

					return $this->query($strSQLQuery, 1);		

				}

	
				
				function  ListSaleForPayment($arryDetails)
				{
					extract($arryDetails);

					$ModuleID = "SaleID"; 
				   
					$moduledd = 'Order';
					$strAddQuery = " where 1";
					$SearchKey   = strtolower(trim($key));
					$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
					
					if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
						$strAddQuery .= " and o.Approved='1'"; 
					}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
						$strAddQuery .= " and o.Approved='0'";
					}else if($sortby != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
					}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or SalesPerson like '%".$SearchKey."%' ) " ):("");	
					}

					$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
					$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
					
					$strAddQuery .= (" and o.SaleID != '' and o.ReturnID = ''");
					$strAddQuery .= (" group by SaleID");
					
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
					//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
					$strAddQuery .= (!empty($asc))?($asc):(" desc");
					$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");
					
					

					$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o ".$strAddQuery;
				
					//echo "=>".$strSQLQuery;
					return $this->query($strSQLQuery, 1);		
						
				}
				
				function  ListUnPaidInvoice($arryDetails)
				{
                                        global $Config;
					extract($arryDetails);

					$ModuleID = "SaleID"; 
					$SearchKey   = strtolower(trim($key));
                                        
					$moduledd = 'Invoice';
					$strAddQuery = " where o.Module='Invoice' ";

					if(!empty($OrderID)){
						$strAddQuery .= " and o.OrderID = '".$OrderID."' ";  
					}
					$BankCurrencySql='';

					/*if(!empty($CustCode)){
						$strAddQuery .= " and o.CustCode = '".$CustCode."' ";  
					}else{*/
						$strAddQuery .= " and o.CustID = '".$custID."' ";  
					//}
					
					$where1 = "  o.PostToGL='1' and o.InvoiceID != '' and o.ReturnID = '' and o.InvoicePaid != 'Paid' and o.Approved='1'";
					if(!empty($BankCurrency)){
                                           $BankCurrencySql = " and o.CustomerCurrency = '".$BankCurrency."'  ";
                                        }




                                        if(!empty($InvoiceIDS)){
                                           $strAddQuery .= " and ( o.InvoiceID in (".$InvoiceIDS.") or (".$where1.") ) ".$BankCurrencySql;
					   $groupby = ' group by o.InvoiceID' ; 
                                        }else{
					   $strAddQuery .= " and ".$where1.$BankCurrencySql ;
						$groupby = '';	
					}
					
					if(!empty($ExcludeInvoiceIDs)){
                                           $strAddQuery .= " and o.InvoiceID not in (".$ExcludeInvoiceIDs.")  ";
                                        }



					#$strAddQuery .= (!empty($SearchKey))?(" and ( o.InvoiceID like '%".$SearchKey."%' or o.CustomerName like '%".$SearchKey."%' or o.SalesPerson like '%".$SearchKey."%' or o.TotalInvoiceAmount like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");
					$strAddQuery .= (!empty($SearchKey))?(" and ( o.InvoiceID like '%".$SearchKey."%' or o.CustomerPO like '%".$SearchKey."%' or o.TotalInvoiceAmount like '%".$SearchKey."%' ) " ):("");

	
					$strAddQuery .= $groupby ;
					$strAddQuery .= " order by o.".$moduledd."Date asc, o.OrderID asc";
				

					$strSQLQuery = "select (SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) FROM f_payments p WHERE p.InvoiceID = o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') AS receivedAmnt , (SELECT SUM(tr.OriginalAmount) FROM f_transaction_data tr WHERE tr.InvoiceID = o.InvoiceID and tr.PaymentType in ('Invoice','Contra Invoice') and tr.Voided='0' and tr.InvoiceID!='') AS receivedAmntTr, o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode,o.CustID, o.CustomerName, o.SalesPerson, o.CustomerPO, o.CustomerCompany, o.TotalAmount, o.Status, o.Approved, o.CustomerCurrency, o.InvoiceID,o.InvoicePaid, o.TotalInvoiceAmount, o.Module, o.InvoiceEntry from s_order o ".$strAddQuery;
				
					//echo "=>".$strSQLQuery; 
					return $this->query($strSQLQuery, 1);		
						
				}


		function  InvoiceReportSales($FromDate,$ToDate,$CustCode,$InvoicePaid)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($InvoicePaid))?(" and o.InvoicePaid='".$InvoicePaid."'"):("");
			
			$strSQLQuery = "select o.* from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' ".$strAddQuery." order by o.InvoiceDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}		



                                
                  /* function  addIncomeInformation($arryDetails)
                    {
                            global $Config;
                            extract($arryDetails);
                            $ipaddress = GetIPAddress();
                            
                             if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }

                            $strSQLQuery = "INSERT INTO f_income SET  TotalAmount = '".$ReceivedAmount."', BankAccount = '".$PaidTo."', ReceivedFrom = '".$CustomerName."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='30',CreatedDate='".$Config['TodayDate']."', Flag ='1',IPAddress='".$ipaddress."'";
                            $this->query($strSQLQuery, 0);	
                            $IncomeID = $this->lastInsertId();
                            
                            return $IncomeID;
                    } */            

		function  addPaymentInformation($arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}

			/********************/
			if($totalInvoice>0 && $CustCode!='' && $ReceivedAmount>0){
				$addsql = " SET  CustID = '".$CustomerName."', CustCode = '".$CustCode."', TotalAmount = ENCODE('".$ReceivedAmount."','".$Config['EncryptKey']."'),  AccountID = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."' ";

				if($TransactionID>0){
					$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
					$this->query($sql, 1);
				}else{
				 	$sql = "INSERT INTO f_transaction ".$addsql." , CreatedDate='". $Config['TodayDate']."' ";
					$this->query($sql, 1);
					$TransactionID = $this->lastInsertId();
				}
		
				 
			}
			/********************/
                            
                        for($i=1;$i<=$totalInvoice;$i++){
                            if($arryDetails['invoice_check_'.$i] == 'on' && $arryDetails['payment_amnt_'.$i] > 0){
                                
                                $strSQLQuery = "INSERT INTO f_income SET  InvoiceID='".$arryDetails['InvoiceID_'.$i]."', Amount = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), TotalAmount = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), BankAccount = '".$PaidTo."', ReceivedFrom = '".$CustomerName."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',  EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$AccountReceivable."',CreatedDate='".$Config['TodayDate']."', Flag ='1',IPAddress='".$ipaddress."' ";
                                $this->query($strSQLQuery, 0);	
                                $incomeID = $this->lastInsertId();

                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$TransactionID."', ConversionRate = '".$arryDetails['ConversionRate_'.$i]."', OrderID = '".$arryDetails['OrderID_'.$i]."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', SaleID = '".$arryDetails['SaleID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', DebitAmnt = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."',  ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."'";
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 


                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  CreditAmnt = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountReceivable."', IncomeID = '".$incomeID."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQuery, 0);

                                $strSQLQuery = "update f_income SET PID='".$PID."' where IncomeID = '".$incomeID."'";
                                $this->query($strSQLQuery, 0);
                            }
                        
                        
                        }
                        
			return $TransactionID;
                         
		}
		
		function GetSalesPaymentInvoice($OrderID,$InvoiceID,$CustID=0)
		{
                        global $Config;
			
						
			/*$strSQLQuery = "select f.*,DECODE(f.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(f.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, b.AccountName, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber  from f_payments f left outer join f_account b on b.BankAccountID = f.AccountID where f.PaymentType='Sales' and f.CustID='".$CustID."' and ((f.OrderID='".$OrderID."' and f.InvoiceID='".$InvoiceID."') or f.GLID>0) order by PaymentDate desc,PaymentID asc";*/
			
			$strSQLQuery = "select f.*,DECODE(f.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(f.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, b.AccountName from f_payments f left outer join f_account b on b.BankAccountID = f.AccountID where f.PaymentType='Sales' and OrderID='".$OrderID."' and InvoiceID='".$InvoiceID."' order by PaymentDate desc,PaymentID asc";

	
	
			return $this->query($strSQLQuery, 1);
		}

		function GetGLPaymentByTransaction($TransactionID,$CustID)
		{
                        global $Config;
			
						
			$strSQLQuery = "select f.*,DECODE(f.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(f.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, b.AccountName, concat(b.AccountName,' [',b.AccountNumber,']') as AccountNameNumber  from f_payments f left outer join f_account b on b.BankAccountID = f.AccountID where f.PaymentType='Sales' and f.TransactionID='".$TransactionID."' and f.CustID='".$CustID."' and f.GLID>'0' order by PaymentDate desc,PaymentID asc";			
	
			return $this->query($strSQLQuery, 1);
		}
		
		function GetSalesTotalPaymentAmntForInvoice($InvoiceID)
		{
                        global $Config;
		        $strSQLQuery = "select sum(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as total from f_payments where InvoiceID='".$InvoiceID."' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}

		function GetTotalPaymentInvoice($InvoiceID,$PaymentType)
		{
                        global $Config;
		        $strSQLQuery = "select sum(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) as total from f_payments where InvoiceID='".$InvoiceID."' and PaymentType = '".$PaymentType."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}

		function GetTotalPaymentCredit($CreditID,$PaymentType)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) as total from f_payments where CreditID='".$CreditID."' and PaymentType = '".$PaymentType."'";
			$arryRow = $this->query($strSQLQuery, 1);
 
			if($arryRow[0]['total']!=''){
				$Total = -$arryRow[0]['total'];
				return $Total;
			}
		
		}
		
		function GetSalesTotalPaymentAmntForOrder($SaleID)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as total from f_payments where SaleID='".$SaleID."' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}

		function GetTotalPaymentSalesOrder($SaleID)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) as total from f_payments where SaleID='".$SaleID."' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}

		function GetSalesTotalPaymentAmntForCredit($CreditID)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as total from f_payments where CreditID='".$CreditID."' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
 
			if($arryRow[0]['total']!=''){
				$Total = -$arryRow[0]['total'];
				return $Total;
			}
		
		}

		

		function GetPaymentAmntForCredit($CreditID)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as total from f_payments where CreditID='".$CreditID."' and PaymentType = 'Purchase'";
			$arryRow = $this->query($strSQLQuery, 1);
 
			if($arryRow[0]['total']!=''){
				$Total = -$arryRow[0]['total'];
				return $Total;
			}
		
		}


		function GetTotalPaymentPurchaseCredit($CreditID)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) as total from f_payments where CreditID='".$CreditID."' and PaymentType = 'Purchase'";
			$arryRow = $this->query($strSQLQuery, 1);
 
			if($arryRow[0]['total']!=''){
				$Total = -$arryRow[0]['total'];
				return $Total;
			}
		
		}
               
	 
			function  ListPaidPaymentInvoice($arryDetails)
			{
                                global $Config;
				extract($arryDetails);

				 
			 

				$strAddQuery = " where 1 ";
				$SearchKey   = strtolower(trim($key));
				
				$sqlJoinAdd = '';

				if(!empty($SuppCode)){
					$strAddQuery .= " and p.SuppCode='".$SuppCode."' ";
					$sqlJoinAdd .= " and o.SuppCode='".$SuppCode."' " ;
				}


				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");

                                    if($SearchKey == 'paid')
                                    {
                                        $InvoicePaid = 1;
                                    }else if($SearchKey == "partially paid" || $SearchKey == 'part paid' )
                                    {
                                        $InvoicePaid = 2;
                                    }else{
                                        $InvoicePaid = 0;
                                    }
                                $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");


				if($sortby != ''){
					$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
				}else{
					$strAddQuery .= (!empty($SearchKey))?(" and (p.SaleID like '%".$SearchKey."%' or o.InvoicePaid = '".$InvoicePaid."' or p.ReferenceNo like '%".$SearchKey."%'  or p.PaymentDate like '%".$SearchKey."%' or p.CreditAmnt like '%".$SearchKey."%' or p.InvoiceID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%' ) " ):("");	
				}

				//$strAddQuery .= " and p.InvoiceID != '' and p.PurchaseID != ''";
                                $strAddQuery .= " and (p.InvoiceID != '' or p.CreditID!='' or p.GLID>0)  and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense'  or p.PaymentType = 'Adjustment')";

				
				$strAddQuery .= (!empty($PostToGL))?(" and p.PostToGL='".$PostToGL."'"):("");


				//$strAddQuery .= (!empty($InvoicePaid))?(" and p.InvoicePaid='".$InvoicePaid."'"):("");

				if(!empty($Status)){
					$strAddQuery .= " and p.Status='".$Status."'";
					$strAddQuery .= ($Status=='Open')?(" and p.Approved='1'"):("");
				}



				#$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by p.PaymentDate desc,p.PaymentID desc ");
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" ORDER BY p.PostToGL desc, CASE WHEN p.PostToGL = 'Yes' THEN p.OrderID ELSE 0 END DESC, p.PaymentDate desc,p.PaymentID desc ");


				if($Config['GetNumRecords']==1){
					$Columns = " count(p.PaymentID) as NumCount ";				
				}else{				
					$Columns = "  p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, t.PaymentDate, o.InvoiceEntry,o.InvoicePaid, o.SuppCompany, o.ExpenseID as ExpenseID,c.Status as CreditStatus, if(p.AdminType='employee',e.UserName,'Administrator') as PostedBy ,concat(ac.AccountName,' [',ac.AccountNumber,']') as PaymentAccount, t.Method as PaymentMethod, t.CheckNumber as PaymentCheckNo ";
					if($Config['RecordsPerPage']>0){
						$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
					}
				
				}




				#$strSQLQuery = "select p.PaymentID,p.PostToGL,p.PaymentType,p.ExpenseID, p.PaymentDate, p.OrderID,p.InvoiceID, p.PurchaseID,p.SuppCode,p.CreditAmnt, p.ReferenceNo,p.PaymentType,p.Currency,o.InvoiceEntry,o.InvoicePaid,o.SuppCompany from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
                                $strSQLQuery = "select ".$Columns." from f_payments p inner join f_transaction t on p.TransactionID=t.TransactionID left outer join f_account ac on (t.AccountID = ac.BankAccountID and ac.BankFlag = '1')   left outer join p_order o on (o.InvoiceID = p.InvoiceID and o.Module='Invoice' and p.InvoiceID!='' ".$sqlJoinAdd.") left outer join p_order c on (c.CreditID = p.CreditID and c.Module='Credit' and p.CreditID!='' ".$sqlJoinAdd.") left outer join h_employee e on (p.AdminID=e.EmpID and p.AdminType='employee') ".$strAddQuery;
		if(!empty($_GET['pk']))echo $strSQLQuery;
				return $this->query($strSQLQuery, 1);		

			}
		function GetPurchasesPaymentInvoice($oid,$inv)
		{
                    global $Config;
                    $strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,b.AccountName,b.AccountNumber from f_payments p left outer join f_account b on b.BankAccountID = p.AccountID where OrderID='".$oid."' and InvoiceID='".$inv."' and PaymentType='Purchase' order by PaymentID desc";

		    #$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,b.AccountName,b.AccountNumber from f_payments p left outer join f_account b on b.BankAccountID = p.AccountID where  ReferenceNo='".$inv."' and PaymentType='Purchase' order by PaymentID desc";

                    return $this->query($strSQLQuery, 1);
		}
		function GetPurchaseTotalPaymentAmntForInvoice($InvoiceID)
		{
                    global $Config;
		    $strSQLQuery = "select sum(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as total from f_payments where InvoiceID='".$InvoiceID."' and PaymentType='Purchase'";
			//echo "=>".$strSQLQuery;exit;
		    $arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function GetPurchaseTotalPaymentAmntForOrder($PurchaseID)
		{
                    	global $Config;
			if(!empty($PurchaseID)){
				$strSQLQuery = "select sum(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as total from f_payments where PurchaseID='".$PurchaseID."' AND PaymentType='Purchase'";
				//echo "=>".$strSQLQuery;exit;
				$arryRow = $this->query($strSQLQuery, 1);
				return $arryRow[0]['total'];
			}
		
		}
                
                function GetOrderTotalPaymentAmntForPurchase($PurchaseID)
		{
		    	if(!empty($PurchaseID)){
			    $strSQLQuery = "select sum(TotalAmount) as total from p_order where PurchaseID='".$PurchaseID."' AND Module = 'Order'";
			    $arryRow = $this->query($strSQLQuery, 1);
			    return $arryRow[0]['total'];
			}
		
		}
                
                function GetOrderTotalPaymentAmntForSale($SaleID)
		{
			if(!empty($SaleID)){
			    $strSQLQuery = "select sum(TotalAmount) as total from s_order where SaleID='".$SaleID."' AND Module = 'Order'";
			    $arryRow = $this->query($strSQLQuery, 1);
			    return $arryRow[0]['total'];
			}
		
		}
                
                function getSpiffData($SaleID)
		{
			if(!empty($SaleID)){
			    $strSQLQuery = "select Spiff,SpiffContact,SpiffAmount from s_order where SaleID='".$SaleID."' AND Module = 'Order'";
			    return $this->query($strSQLQuery, 1);
			}
		     
		
		}
                
                
                 /*function  addExpenseInformation($arryDetails)
                    {
                            global $Config;
                            extract($arryDetails);
                            $ipaddress = GetIPAddress();
                            
                            if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }

                            $strSQLQuery = "INSERT INTO f_expense SET  TotalAmount = '".$PaidAmount."', BankAccount = '".$PaidFrom."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='32',CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";
                            $this->query($strSQLQuery, 0);	
                            $ExpenseID = $this->lastInsertId();	
                            
                            return $ExpenseID;
                    }*/  

		function  addPurchasePaymentInformation($arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
                        
			if($Method == "Check"){
				$CheckBankName = $CheckBankName;
				$CheckFormat = $CheckFormat;
				if($Voided==1 && $CheckNumber!=''){
				$sttSql = "update f_payments SET Voided='1',DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'),CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."') where CheckNumber = '".$CheckNumber."'";
                                $this->query($sttSql, 0);	
				}
			}else{
				$CheckBankName = '';
				$CheckFormat = '';
			}
                       

			/********************/
			if($totalInvoice>0 && $SuppCode!='' && $PaidAmount>0){
				 $addsql = " SET  SuppCode = '".$SuppCode."', TotalAmount = ENCODE('".$PaidAmount."','".$Config['EncryptKey']."'),  AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."' ";
				if($TransactionID>0){
					$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
		                        $this->query($sql, 1);
				}else{
				 	$sql = "INSERT INTO f_transaction ".$addsql." , CreatedDate='". $Config['TodayDate']."' ";
		                        $this->query($sql, 1);
		                        $TransactionID = $this->lastInsertId();
				}
			}
			/********************/


                        for($i=1;$i<=$totalInvoice;$i++){
                          if($arryDetails['invoice_check_'.$i] == 'on' && $arryDetails['payment_amnt_'.$i] > 0){
                              	if(empty($ReferenceNo)) $ReferenceNo = 	$arryDetails['InvoiceID_'.$i];
                                
                                $strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$arryDetails['InvoiceID_'.$i]."', OrderID='".$arryDetails['OrderID_'.$i]."', Amount = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'), BankAccount = '".$PaidFrom."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '".$Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$AccountPayable."',CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);	
                                $ExpenseID = $this->lastInsertId();	
                              
                                $strSQLQuery = "INSERT INTO f_payments SET   TransactionID='".$TransactionID."', ConversionRate = '".$arryDetails['ConversionRate_'.$i]."', OrderID = '".$arryDetails['OrderID_'.$i]."', SuppCode = '".$SuppCode."', PurchaseID = '".$arryDetails['PurchaseID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', CreditAmnt = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                

                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', DebitAmnt = ENCODE('".$arryDetails['payment_amnt_'.$i]."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ExpenseID = '".$ExpenseID."', SuppCode = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQueryPay, 0);
                                
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);	
				
				
				



                          }
                        
                        }
                        
                        
                       return $TransactionID;

		}

		function updatePurchaseInvoiceStatus($InvoiceID,$chk)
			{
			   
                           
                            if($chk == 1){$InvoiceStatus = 2;}else{ $InvoiceStatus = 1;}
			  
			   $strSQLQuery = "update p_order set InvoicePaid = '".$InvoiceStatus."' where InvoiceID='".$InvoiceID."' and Module='Invoice' ";
			   $this->query($strSQLQuery, 0);
			}
                        
                        function updateOrderStatus($PurchaseID)
			{
			   if(!empty($PurchaseID)){
			     $strSQLQuery = "update p_order set InvoicePaid = '1' where PurchaseID='".$PurchaseID."' and Module='Order' ";
			    $this->query($strSQLQuery, 0);
			   }
			}

                        function  GetSupplier($SuppID,$SuppCode,$Status)
                        {
                            $strSQLQuery = "select s.* , IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName, ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ";

                            #$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".$SuppID."'"):(" and s.locationID=".$_SESSION['locationID']);
                            $strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
                            $strSQLQuery .= (!empty($SuppCode))?(" and s.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
                            $strSQLQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

                            return $this->query($strSQLQuery, 1);
                        }	

			function addOtherExpense($arryDetails)
			{
				extract($arryDetails);
				global $Config;
				$ipaddress = GetIPAddress(); 
                               
               
                                
                                if($Config['CronEntry']==1){ //cron entry
                                        $EntryType = 'one_time';
                                        $InvoiceID = '';	
                                      
                                        $PaymentDate = $Config['TodayDate'];
                                        $MultiPaymentData = $Config['arryGLAccountData'];
                                }else{

                                        $TaxAmount = ($TaxRate*$Amount)/100;
                                        if($TaxAmount > 0){
                                            $TotalAmount = $Amount+$TaxAmount;
                                        }else{
                                             $TotalAmount = $Amount;
                                        }
                                        
                                        
                                        
                                        $CreatedBy  = addslashes($_SESSION['UserName']);
                                        $AdminID  = $_SESSION['AdminID'];
                                        $AdminType  = $_SESSION['AdminType'];
                                        $LocationID = $_SESSION['locationID'];
                                
                             }
                                 
                                if(empty($Currency)) $Currency = $Config['Currency'];


                                 if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                                 
                                if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                                if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                                if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                                if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
                                 
                                 
                                $supplierData =  $this->GetSupplier('',$PaidTo,'');
                                
                                  if(!empty($InvoiceEntry)){$InvoiceEntry = $InvoiceEntry;}else{$InvoiceEntry = 2;}
                                      
                                  

                                   $strSQLQueryPO = "insert into p_order set Module='Invoice',
                                        PurchaseID = '".addslashes($ReferenceNo)."',
                                        InvoiceID  = '".$InvoiceID."',
                                        Approved  = '1',
                                        Comment  = '".addslashes(strip_tags($Comment))."',
                                        SuppCode  = '".addslashes($supplierData[0]['SuppCode'])."',
                                        SuppCompany  = '".addslashes($supplierData[0]['CompanyName'])."',  
                                        SuppContact  = '".addslashes($supplierData[0]['SuppContact'])."',   
                                        Address  = '".addslashes($supplierData[0]['Address'])."',   
                                        City  = '".addslashes($supplierData[0]['City'])."',
                                        State  = '".addslashes($supplierData[0]['State'])."',
                                        Country  = '".addslashes($supplierData[0]['Country'])."',
                                        ZipCode  = '".addslashes($supplierData[0]['ZipCode'])."',   
                                        Currency  = '".$Currency."',
                                        SuppCurrency  = '".addslashes($supplierData[0]['SuppCurrency'])."',
                                        Mobile  = '".addslashes($supplierData[0]['Mobile'])."',
                                        Landline  = '".addslashes($supplierData[0]['Landline'])."',
   					IPAddress='".$ipaddress."',
                                        Fax  = '".addslashes($supplierData[0]['Fax'])."',
                                        Email  = '".addslashes($supplierData[0]['Email'])."',
                                          ConversionRate  = '".addslashes($ConversionRate)."',
                                        TotalAmount  = '".addslashes($TotalAmount)."',
                                         TotalInvoiceAmount  = '".addslashes($TotalAmount)."',
                                        CreatedBy  = '".$CreatedBy."',
                                        AdminID  = '".$AdminID."', 
                                        AdminType  = '".$AdminType."',
                                        PostedDate  = '".$PaymentDate."',
					VendorInvoiceDate  = '".$VendorInvoiceDate."',
					 CreatedDate  = '".$Config['TodayDate']."',
                                        UpdatedDate  = '".$Config['TodayDate']."',
                                        InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
                                        PaymentMethod  = '".addslashes($PaymentMethod)."',
                                        ShippingMethod  = '".addslashes($ShippingMethod)."', 
                                        PaymentTerm  = '".addslashes($PaymentTerm)."',
                                        AssignedEmpID  = '".addslashes($EmpID)."',
                                        AssignedEmp  = '".addslashes($EmpName)."',
                                        Taxable  = '".addslashes($Taxable)."',
					 ArInvoiceID  = '".addslashes($ArInvoiceID)."',
                                        InvoiceEntry='".$InvoiceEntry."',InvoicePaid='0',EntryType='".$EntryType."',
                                        EntryInterval='".$EntryInterval."',
                                        EntryMonth='".$EntryMonth."',   
                                        EntryWeekly = '".$EntryWeekly."',      
                                        EntryFrom='".$EntryFrom."',
                                        EntryTo='".$EntryTo."',
                                        EntryDate='".$EntryDate."'";

                                  
                                    $this->query($strSQLQueryPO, 0);
                                    $OrderID = $this->lastInsertId();
                                 
                                  
				$strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$InvoiceID."', OrderID='".$OrderID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), BankAccount = '".$BankAccount."', PaidTo = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', ExpenseTypeID='".$ExpenseTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."',EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',GlEntryType='".$GlEntryType."'";
                                
                                
				$this->query($strSQLQuery, 0);	
				$ExpenseID = $this->lastInsertId();		

				/*********Add Payment Transaction**********/
                                
				/*$strSQLQueryPay = "INSERT INTO f_payments SET  InvoiceID  = '".$InvoiceID."', OrderID='".$OrderID."', PurchaseID='".addslashes($ReferenceNo)."', CreditAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$BankAccount."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Spiff Expense',IPAddress='".$ipaddress."'";
				$this->query($strSQLQueryPay, 0);*/ //pk
                                $PID = $this->lastInsertId();
                                
                                if($GlEntryType == "Single"){
                                    /*$strSQLQueryPay = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ExpenseTypeID."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Spiff Expense', Flag= '1', IPAddress='".$ipaddress."'";
                                    $this->query($strSQLQueryPay, 0);*/ //pk
                                }else{
                                    
                                   if($Config['CronEntry']==1){
                                       
                                       foreach($MultiPaymentData as $value){
                                           
                                           /*$strSQLQueryPayMul = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$value['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$value['AccountID']."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Other Expense', Flag= '1', IPAddress='".$ipaddress."'";
                                           $this->query($strSQLQueryPayMul, 0);*/ //pk

                                            $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account_payment SET  AccountID='".$value['AccountID']."', AccountName = '".$value['AccountName']."', Notes = '".$value['Notes']."', Amount = ENCODE('".$value['Amount']."','".$Config['EncryptKey']."'),  ExpenseID = '".$ExpenseID."'";
                                            $this->query($strSQLQueryPayMulAcc, 0);
                                           
                                       }
                                       
                                    
                                   }else{

                                            for($i=1;$i<=$NumLine1;$i++){
                                                if( $arryDetails['invoice_check_'.$i] ==1 && ($arryDetails['GlAmnt'.$i] > 0 || $arryDetails['GlAmnt'.$i] < 0) && !empty($arryDetails['AccountID'.$i])){
                                                    /*$strSQLQueryPayMul = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$arryDetails['GlAmnt'.$i]."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$arryDetails['AccountID'.$i]."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Other Expense', Flag= '1', IPAddress='".$ipaddress."'";
                                                    $this->query($strSQLQueryPayMul, 0);*/ //pk

                                                   $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account_payment SET  AccountID='".$arryDetails['AccountID'.$i]."', AccountName = '".$arryDetails['AccountName'.$i]."', Notes = '".$arryDetails['Notes'.$i]."', Amount = ENCODE('".$arryDetails['GlAmnt'.$i]."','".$Config['EncryptKey']."'),  ExpenseID = '".$ExpenseID."'";
                                                    $this->query($strSQLQueryPayMulAcc, 0);
						//echo $strSQLQueryPayMulAcc.'<br>';
                                                }
                                            }
                                    
                                   } 
                                }
                         
                                
                                
                                 $strSQLUp = "update p_order set ExpenseID ='".$ExpenseID."' where OrderID='".$OrderID."'"; 
				 $this->query($strSQLUp, 0);
                              

				
				$objConfigure = new configure();
				$objConfigure->UpdateModuleAutoID('p_order','Invoice',$OrderID,$InvoiceID);

				/*******************/
				if(empty($InvoiceID)){
					$sqlInvc = "select InvoiceID from p_order where OrderID='".$OrderID."'";
					$arrInvc = $this->query($sqlInvc, 1);
					$InvoiceID = $arrInvc[0]['InvoiceID'];

					$strSQLQuery = "update f_expense SET PID='".$PID."',InvoiceID='".$InvoiceID."' where ExpenseID = '".$ExpenseID."'";
					$this->query($strSQLQuery, 0);
                                }



				


                                return $OrderID;    
		}

		function updateOtherExpense($arryDetails){
			extract($arryDetails);
			global $Config;
			$ipaddress = GetIPAddress(); 
			$strSQLQuery = "SELECT * from p_order WHERE OrderID ='".$OrderID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			$ExpenseID = $arryRow[0]['ExpenseID'];
			if($ExpenseID>0){ //start $ExpenseID
                                 
                                $TotalAmount = $Amount;                       
                                                        
                                if(empty($Currency)) $Currency = $Config['Currency'];

                                if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                                 
                                if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                                if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                                if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                                if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
                                 
                                 
                                $supplierData =  $this->GetSupplier('',$PaidTo,'');                                     
                                 
 

                        	$strSQLQueryPO = "update p_order set 
				 PurchaseID = '".addslashes($ReferenceNo)."',
                                SuppCode  = '".addslashes($supplierData[0]['SuppCode'])."',
                                SuppCompany  = '".addslashes($supplierData[0]['CompanyName'])."',  
                                SuppContact  = '".addslashes($supplierData[0]['SuppContact'])."', 
                                Address  = '".addslashes($supplierData[0]['Address'])."',  
                                City  = '".addslashes($supplierData[0]['City'])."',
                                State  = '".addslashes($supplierData[0]['State'])."',
                                Country  = '".addslashes($supplierData[0]['Country'])."',
                                ZipCode  = '".addslashes($supplierData[0]['ZipCode'])."', 
                                SuppCurrency  = '".addslashes($supplierData[0]['SuppCurrency'])."',
			        Currency  = '".addslashes($Currency)."',
				ConversionRate  = '".addslashes($ConversionRate)."',
                                Mobile  = '".addslashes($supplierData[0]['Mobile'])."',
                                Landline  = '".addslashes($supplierData[0]['Landline'])."',
                                Fax  = '".addslashes($supplierData[0]['Fax'])."',
                                Email  = '".addslashes($supplierData[0]['Email'])."',                                         
                                TotalAmount  = '".addslashes($TotalAmount)."',
				TotalInvoiceAmount  = '".addslashes($TotalAmount)."',
				InvoiceComment  = '".addslashes($InvoiceComment)."',
                                UpdatedDate  = '".$Config['TodayDate']."',
                                PaymentMethod  = '".addslashes($PaymentMethod)."',
                                ShippingMethod  = '".addslashes($ShippingMethod)."', 
                                PaymentTerm  = '".addslashes($PaymentTerm)."',  
				EntryType='".$EntryType."',
                                EntryInterval='".$EntryInterval."',
				VendorInvoiceDate  = '".$VendorInvoiceDate."',
                                EntryMonth='".$EntryMonth."',   
                                EntryWeekly = '".$EntryWeekly."',      
                                EntryFrom='".$EntryFrom."',
                                EntryTo='".$EntryTo."',
                                EntryDate='".$EntryDate."',
				PostedDate = '".$PaymentDate."'
				where OrderID='".$OrderID."' "; 
                          
                            	$this->query($strSQLQueryPO, 0);                                   
                                 
                                  
				$strSQLQuery = "update f_expense SET  Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), BankAccount = '".$BankAccount."', PaidTo = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', ExpenseTypeID='".$ExpenseTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."',EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',GlEntryType='".$GlEntryType."' where ExpenseID='".$ExpenseID."' "; 
                                                              
				$this->query($strSQLQuery, 0);	
					                                
                                $strSQL = "delete from f_multi_account_payment where ExpenseID='".$ExpenseID."'"; 
				$this->query($strSQL, 0);

                                if($GlEntryType == "Multiple"){                                  
						
                                            for($i=1;$i<=$NumLine1;$i++){
                                                if( $arryDetails['invoice_check_'.$i] ==1 && ($arryDetails['GlAmnt'.$i] > 0 || $arryDetails['GlAmnt'.$i] < 0) && !empty($arryDetails['AccountID'.$i])){                                                 

                                                   $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account_payment SET  AccountID='".$arryDetails['AccountID'.$i]."', AccountName = '".$arryDetails['AccountName'.$i]."', Notes = '".$arryDetails['Notes'.$i]."', Amount = ENCODE('".$arryDetails['GlAmnt'.$i]."','".$Config['EncryptKey']."'),  ExpenseID = '".$ExpenseID."'";
                                                    $this->query($strSQLQueryPayMulAcc, 0);
						
                                                }
                                            }
                                    
                                    
                                }
                                                         
                               
			}//end $ExpenseID


			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('p_order','InvoiceID',$OrderID,$arryDetails["PoInvoiceIDGL"]);



		}


		function  GetPurchaseItem($OrderID){
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
		
			 $strSQLQuery = "select i.*,t.RateDescription,itm.evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID where 1".$strAddQuery." order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}



		function RemovePOInvoice($OrderID,$ExpenseID){
			global $Config;
			$objConfigure=new configure();
			$objFunction=new functions();
			$objConfig=new admin();	
			if(!empty($OrderID)){	
				/*******************/
				$strSQL= "select InvoiceID,ReceiptID, UploadDocuments from p_order where OrderID='".$OrderID."'"; 
				$arryPurchase = $this->query($strSQL, 1);

				if($arryPurchase[0]['ReceiptID']!=''){
						$strGetSQL= "select OrderID,ReceiptID from p_order where ReceiptID='".$arryPurchase[0]['ReceiptID']."' and Module='Receipt'"; 
						$arryReceipt = $this->query($strGetSQL, 1);
						if($arryReceipt[0]['OrderID']){
								$UpdateQtysql = "update p_order set GenrateInvoice = 0  where OrderID='" .$arryReceipt[0]['OrderID']. "' and Module='Receipt' ";
								$this->query($UpdateQtysql, 0);
						}
				}

				/*********Implemented on Post to Gl*******
				$arryPurchaseItem = $this->GetPurchaseItem($OrderID);

				foreach($arryPurchaseItem as $values){	
					
					if($values['qty_received']>0){						
						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-".$values['qty_received'] . "  where Sku='" .$values['sku']. "' and ItemID ='".$values['item_id']."' ";
						$this->query($UpdateQtysql, 0);

						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$values['sku']. "' and ItemID ='".$values['item_id']."' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);
						
						
					}
									
				}
				/******************/	

				/******Delete Document**********/
				 
				if($arryPurchase[0]['UploadDocuments'] !=''){ 
					$objFunction->DeleteFileStorage($Config['P_DocomentDir'],$arryPurchase[0]['UploadDocuments']);
				}

				/******Delete PDF**********/ 
				$PdfFile = 'PurchaseInvoice-'.$arryPurchase[0]['InvoiceID'].'.pdf';
				$objFunction->DeleteFileStorage($Config['P_Invoice'],$PdfFile);			
				
				$PdfTemplateArray = array('ModuleDepName' => 'PurchaseInvoice',  'PdfDir' => $Config['P_Invoice'], 'TableName' => 'p_order', 'OrderID' => $OrderID, 'ModuleID' => 'InvoiceID');
				$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);
 
				/**************************/



				$strSQLQuery = "delete from p_order where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery = "delete from p_order_item where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);	

				$strSQLQuery = "delete from f_expense where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);

				if($ExpenseID>0){
					$strSQLQuery = "delete from f_multi_account_payment where ExpenseID='".mysql_real_escape_string($ExpenseID)."'"; 
					$this->query($strSQLQuery, 0);	
				}

				/*******************/
				$strSQL= "select TransferID from f_fundtransfer where OrderID='".$OrderID."'"; 
				$arryTr = $this->query($strSQL, 1);
				if(!empty($arryTr[0]['TransferID'])){
					$strSQLQuery = "delete from f_fundtransfer where OrderID='".mysql_real_escape_string($OrderID)."'"; 
					$this->query($strSQLQuery, 0);
					$strSQLQuery = "delete from f_fundtransfer_payment where TransferID='".mysql_real_escape_string($arryTr[0]['TransferID'])."'"; 
					$this->query($strSQLQuery, 0);
				}
				/*******************/
				
				 
				

			}

			return 1;

		}


		function RemovePOAdjustment($AdjID){
			if(!empty($AdjID)){
				$strSQLQuery = "delete from f_adjustment where AdjID='".mysql_real_escape_string($AdjID)."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery = "delete from f_payments where AdjID='".mysql_real_escape_string($AdjID)."'"; 
				$this->query($strSQLQuery, 0);	

				$strSQLQuery = "delete from f_multi_adjustment where AdjID='".mysql_real_escape_string($AdjID)."'"; 
				$this->query($strSQLQuery, 0);				

			}

			return 1;

		}




			function getOtherExpense($arryDetails)
			{
				extract($arryDetails);
                                global $Config;
                                
				$strAddQuery = " where 1 ";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($ExpenseID>0)?(" and f.ExpenseID = '".$ExpenseID."'"):("");
                                //$strAddQuery .= ($Flag>0)?(" and f.Flag = 1"):(" and f.Flag != 1");
				$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (s.FirstName like '".$SearchKey."%' or s.CompanyName like '".$SearchKey."%' or f.ReferenceNo like '%".$SearchKey."%' or f.TotalAmount like '%".$SearchKey."%') "):("");
				//$strAddQuery .= " order by f.ExpenseID Desc";
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by f.ExpenseID Desc ");

				 $strSQLQuery = "select f.*,DECODE(f.Amount ,'". $Config['EncryptKey']."') as Amount,DECODE(f.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName,  b.AccountName,b.AccountNumber  from f_expense f left outer join p_supplier s on s.SuppCode = f.PaidTo left outer join f_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
				//echo $strSQLQuery;
				return $this->query($strSQLQuery, 1);
			}

			function RemoveOtherExpense($ExpenseID)
			{
                            
                                /******************ARCHIVE RECORD*********************************/

                                $strSQLQuery = "INSERT INTO f_archive_expense SELECT * FROM f_expense WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'";
                                $this->query($strSQLQuery, 0);

                                $strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'";
                                $this->query($strSQLQuery, 0);


                                /*************************************************/
				$strSQLQuery = "DELETE FROM f_expense WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery1 = "DELETE FROM f_payments WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'"; 
				$this->query($strSQLQuery1, 0);

				return 1;
			}


	 
/************************End Sales/Purchases Functions***********************************************************************************/			
						
                

 

/**************************Set Account Balance************************************************************/
			
		function setAccountBalance($accountid,$amount,$set)			
		 {
			$Balance = 0;
			$strSQLQuery = "SELECT Balance from f_account WHERE BankAccountID ='".mysql_real_escape_string($accountid)."'";
			$rows = $this->query($strSQLQuery, 1);
			$Balance = $rows[0]['Balance'];
			 	

		    	if($set == 1)	
                         {
				$Balance = $Balance+$amount;	
				$strSQLQuery = "update f_account set Balance = '".$Balance."' WHERE BankAccountID ='".mysql_real_escape_string($accountid)."'";
				$this->query($strSQLQuery, 0);
			 }
			if($set == 2)	
                         {
				$Balance = $Balance-$amount;	
				$strSQLQuery = "update f_account set Balance = '".$Balance."' WHERE BankAccountID ='".mysql_real_escape_string($accountid)."'";
				$this->query($strSQLQuery, 0);
			 }
			

		 }
			

	function getAccountBalance($accountid,$AccountType)
	{
			$strSQLQuery = "SELECT SUM(DebitAmnt) as DbAmnt,SUM(CreditAmnt) as CrAmnt from f_payments WHERE AccountID ='".mysql_real_escape_string($accountid)."' AND PostToGL = 'Yes'";
                        //echo "=>".$strSQLQuery;exit;
			$rows = $this->query($strSQLQuery, 1);
			$DbAmnt = $rows[0]['DbAmnt'];
			$CrAmnt = $rows[0]['CrAmnt'];
				
			
                        $Balance = 0;
                        $Balance = floatval($DbAmnt)-floatval($CrAmnt);
                        
                        
                        
			return $Balance; 	
	}
/**************************End Account Balance************************************************************/
		 
		
        function getCustomerPaymentMethod($custID)
        {
                $strSQLQuery = "Select PaymentMethod from s_customers where Cid = '".mysql_real_escape_string($custID)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['PaymentMethod'];
            
        }
        
        function getVendorPaymentMethod($SuppCode)
        {
                $strSQLQuery = "Select PaymentMethod from p_supplier where SuppCode = '".mysql_real_escape_string($SuppCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['PaymentMethod'];
            
        }
        
        function getSupplierName($SuppCode)
        {
                $strSQLQuery = "Select SuppID,UserName,CompanyName, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  from p_supplier s where SuppCode = '".mysql_real_escape_string($SuppCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
               /* if(!empty($arryRow[0]['CompanyName']))
                {
                    $SupplierName = $arryRow[0]['CompanyName'];
                }else{
                   $SupplierName = $arryRow[0]['UserName'];
                }*/
                $SupplierName = $arryRow[0]['VendorName'];
		return $SupplierName;
            
        }
        
         function getCustomerName($CustCode)
        {
                $strSQLQuery = "Select FullName from s_customers where CustCode = '".mysql_real_escape_string($CustCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
                $FullName = $arryRow[0]['FullName'];
                
		return $FullName;
            
        }

	   function getCustomerCode($Cid)
        {
                $strSQLQuery = "Select CustCode from s_customers where Cid = '".mysql_real_escape_string($Cid)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
                return $arryRow[0]['CustCode'];
                	 
            
        }

	   function getCustomerCredit($Cid)
        {
                $strSQLQuery = "Select CreditAmount from s_customers where Cid = '".mysql_real_escape_string($Cid)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
                return $arryRow[0]['CreditAmount'];
                	 
            
        }

	 function getVendorCredit($SuppCode)
        {
                $strSQLQuery = "Select CreditAmount from p_supplier where SuppCode = '".mysql_real_escape_string($SuppCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
                return $arryRow[0]['CreditAmount'];
                	 
            
        }

	function  GetCustomer($CustID,$CustCode,$Status)
		{
			global $Config;


			$strSQLQuery = "SELECT c.*,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName,concat(e.FirstName,' ',e.LastName) as sales_person FROM s_customers c left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') left outer join h_employee e on c.SalesID =e.EmpID  ";
			$strSQLQuery .= (!empty($CustID))?(" WHERE c.Cid='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($CustCode))?(" and c.CustCode='".$CustCode."'"):("");
			$strSQLQuery .= ($Status!='')?(" AND c.Status='".$Status."'"):("");

			
			$strSQLQuery .= ' order by CustomerName asc ';
			return $this->query($strSQLQuery, 1);

		}

        
        function GetSalesTotalPaymentAmntForOrderAfterPostGL($SaleID)
		{
			if(!empty($SaleID)){
				$strSQLQuery = "select sum(DebitAmnt) as total from f_payments where SaleID='".$SaleID."' and PostToGL = 'Yes' and PaymentType = 'Sales'";
				$arryRow = $this->query($strSQLQuery, 1);
				return $arryRow[0]['total'];
			}
		
		}
        
        


 function commonPostToGL($paymentID,$SaleID,$InvoiceEntry,$gldate)
        {
		global $Config;
        	if(!empty($gldate))
        	{
        		$posttogldate=$gldate;
        	}
        	else 
        	{
        		$posttogldate=$Config['TodayDate'];
        	}
        	
		/*******for expense & other expense GL from cash receipt********/
		$strSQLQuery = "select p.GLID,a.RangeFrom, DECODE(DebitAmnt,'". $Config['EncryptKey']."') as DbtAmnt from f_payments p  inner join f_account a on p.GLID=a.BankAccountID WHERE (p.PaymentID ='".$paymentID."' OR p.PID = '".$paymentID."') and p.GLID>'0' having DbtAmnt<'0' and a.RangeFrom in (6000,8000)"; 
		$arryAcc = $this->query($strSQLQuery, 1);
		
		if(!empty($arryAcc[0]['GLID'])){  //Not Needed as negative has been hidden from reports already

			/*$FinalAmnt = str_replace("-","",$arryAcc[0]['DbtAmnt']); 		 

			$strSQLQuery1 = "update f_payments set DebitAmnt=ENCODE('".$FinalAmnt."','". $Config['EncryptKey']."'), NegativeFlag='1' WHERE PaymentID ='".$paymentID."'";		 
            		$this->query($strSQLQuery1, 0);

			$strSQLQuery2 = "update f_payments set CreditAmnt=ENCODE('".$FinalAmnt."','". $Config['EncryptKey']."'), NegativeFlag='1' WHERE PID = '".$paymentID."'";		 
            		$this->query($strSQLQuery2, 0);*/
		}
		/*********************/
		

		/********This is for pay vendor now, need to remove later************
		$strSQLQ = "select TransactionID from f_payments  WHERE PaymentID ='".$paymentID."'";
		$arryTr = $this->query($strSQLQ, 1);
		if(!empty($arryTr[0]['TransactionID'])){
			 $strSQLQue = "update f_transaction set PostToGL = 'Yes',PostToGLDate='".$posttogldate."' WHERE TransactionID ='".$arryTr[0]['TransactionID']."' and PostToGL != 'Yes'";		 
            		$this->query($strSQLQue, 0);
		}
		/***************************/

            if($Config['TransactionPosting']==1){
		$AddSQLQuery = ",PaymentDate='".$posttogldate."' ";
	    }
            $strSQLQuery = "update f_payments set PostToGL = 'Yes',PostToGLDate='".$posttogldate."' ".$AddSQLQuery." WHERE PaymentID ='".$paymentID."' OR PID = '".$paymentID."'";			
	 
            $this->query($strSQLQuery, 0);
            
		 

            if($InvoiceEntry != 1){
                $postGLOrderAmnt = $this->GetSalesTotalPaymentAmntForOrderAfterPostGL($SaleID);

                return $postGLOrderAmnt;
            }
            
        }

	
	function GetContraID($TransactionID){
		$strSQL = "select TransactionID from f_transaction  WHERE ContraID ='".$TransactionID."' ";
		$arryTransaction = $this->query($strSQL, 1);
		return $arryTransaction[0]['TransactionID'];
	}

	function GetContraIDReverse($TransactionID){
		$strSQL = "select ContraID from f_transaction  WHERE TransactionID ='".$TransactionID."' ";
		$arryTransaction = $this->query($strSQL, 1);
		return $arryTransaction[0]['ContraID'];
	}

	function TransactionPostToGL($TransactionID,$gldate){
		global $Config;
		$strSQL = "select PaymentID,SaleID,InvoiceID,GLID, CreditID from f_payments  WHERE TransactionID in(".$TransactionID.") order by PaymentID asc";
		$arryTransaction = $this->query($strSQL, 1);		
		//echo '<pre>';print_r($arryTransaction);exit;
		
		
		$Config['TransactionPosting'] = 1;
		foreach($arryTransaction as $key=>$values){	
			if($Config['VendorTransfer']==1){
				if(!empty($values['GLID'])){
					$this->commonPostToGL($values['PaymentID'],'','',$gldate);
				}
			}else{		
				$this->commonPostToGL($values['PaymentID'],$values['SaleID'],'',$gldate);
			}
		}
		 
		 $strSQLQue = "update f_transaction set PostToGL = 'Yes',PostToGLDate='".$gldate."', PostToGLTime='".$Config['TodayDate']."' WHERE TransactionID in(".$TransactionID.") and PostToGL != 'Yes'";		 
    		$this->query($strSQLQue, 0);
		

		return true;
	}

	

    	function NegativeGLforExpense()
        {
		global $Config;
                	
		/*******for expense & other expense GL from cash receipt********/
		$strSQLQuery = "select p.PaymentID, p.GLID,a.RangeFrom, DECODE(DebitAmnt,'". $Config['EncryptKey']."') as DbtAmnt from f_payments p  inner join f_account a on p.GLID=a.BankAccountID WHERE p.GLID>'0' having DbtAmnt<'0' and a.RangeFrom in (6000,8000)"; 
		$arryAccPay = $this->query($strSQLQuery, 1);

		foreach($arryAccPay as $key => $values) {
			if(!empty($values['GLID'])){
				$FinalAmnt = str_replace("-","",$values['DbtAmnt']); 		 

				$strSQLQuery1 = "update f_payments set DebitAmnt=ENCODE('".$FinalAmnt."','". $Config['EncryptKey']."'), NegativeFlag='1' WHERE PaymentID ='".$values['PaymentID']."'";
		    		$this->query($strSQLQuery1, 0);

				$strSQLQuery2 = "update f_payments set CreditAmnt=ENCODE('".$FinalAmnt."','". $Config['EncryptKey']."'), NegativeFlag='1' WHERE PID = '".$values['PaymentID']."'";		 
		    		$this->query($strSQLQuery2, 0);
			}
		}
		/*********************/            
        }
     

        function isInvoiceNumberExists($InvoiceID)
		{
			
			$strSQLQuery = "SELECT ExpenseID from f_expense where InvoiceID = '".trim($InvoiceID)."'";

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['ExpenseID'])) {
				return true;
			} else {
				return false;
			}
		}	
                
            function isInvoiceNumberExistsForIncome($InvoiceID)
		{
			
			$strSQLQuery = "SELECT IncomeID from f_income where InvoiceID = '".trim($InvoiceID)."'";

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['IncomeID'])) {
				return true;
			} else {
				return false;
			}
		}	     
                
                function getMultiAccount($ExpenseID)
                {
                       global $Config;
                       $strSQLQuery = "SELECT f.*,DECODE(f.Amount,'". $Config['EncryptKey']."') as Amount,a.AccountName,a.AccountNumber from f_multi_account_payment f left outer join f_account a on f.AccountID=a.BankAccountID where f.ExpenseID = '".trim($ExpenseID)."'";
                      
		       $arryRow = $this->query($strSQLQuery, 1);
                    return $arryRow;
                }

		function getInvoiceMultiTotal($ExpenseID)
                {
                       global $Config;
                      $strSQLQuery = "SELECT sum(DECODE(f.Amount,'". $Config['EncryptKey']."')) as TotalAmount from f_multi_account_payment f inner join f_account a on f.AccountID=a.BankAccountID where f.ExpenseID = '".trim($ExpenseID)."'";
                    
		       $arryRow = $this->query($strSQLQuery, 1);
			
                    return number_format($arryRow[0]['TotalAmount'],2);
                }
		
		function sendSalesPaymentEmail($arryDetails)
		{
		   extract($arryDetails);
			global $Config;	
	
			if($OrderID>0){
				
				$PaymentDate = ($PaymentDate>0)?(date($Config['DateFormat'], strtotime($PaymentDate))):(NOT_SPECIFIED);
				$ReferenceNo = (!empty($ReferenceNo))? (stripslashes($ReferenceNo)): (NOT_SPECIFIED);

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_invoice_paid.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[InvoiceID]",$InvoiceID,$contents);
				$contents = str_replace("[Amount]",$ReceivedAmount,$contents);
				$contents = str_replace("[CustomerName]",$CustomerName,$contents);
				$contents = str_replace("[Method]",$Method,$contents);
				$contents = str_replace("[Date]",$PaymentDate,$contents);
				$contents = str_replace("[ReferenceNo]",$ReferenceNo,$contents);
				$contents = str_replace("[Currency]",$Currency,$contents);
				
				//$CC = "rajeev@sakshay.in";
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				//if(!empty($CC)) $mail->AddCC($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Payment paid for Invoice Number ".$InvoiceID;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}
                
                
    /****************Recurring Function Satrt************************************/  
       function RecurringGlAccount(){       
          global $Config;
	  $Config['CronEntry']=1;
	 
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);

	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));


	/**************/
	$TodayDate = $arryDate[0];
	$Year = $arryDay[0];	
	$YearMonth = $arryDay[0].'-'.$arryDay[1];
	/**************/	

	
	  $strSQLQuery = "select o.*,e.ExpenseID,e.ExpenseTypeID,e.BankAccount,e.Amount,e.TaxID,e.TaxRate,e.LocationID,e.PaidTo,e.ReferenceNo,e.Comment,e.Flag,e.GlEntryType
              from p_order o left outer join f_expense e on (o.OrderID = e.OrderID and o.ExpenseID=e.ExpenseID) where o.InvoiceEntry='2' and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."'  and CASE WHEN o.EntryTo>'0' THEN  o.EntryTo>='".$arryDate[0]."' ELSE 1 END = 1";
          $arryInvoice = $this->myquery($strSQLQuery, 1);
                  
       
        // pr($arryInvoice);   exit;
	
	  foreach($arryInvoice as $value){

		/**************/
		$ModuleDate = $value['PostedDate'];
		$arryDt = explode("-", $ModuleDate);
		$YearOrder = $arryDt[0]; 
		$YearMonthOrder = $arryDt[0].'-'.$arryDt[1];
		/**************/



		$OrderFlag=0;
               if($ModuleDate!=$TodayDate){ 
		switch($value['EntryInterval']){
			case 'biweekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($value['EntryDate']==$Day && $YearMonthOrder!=$YearMonth){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month && $YearOrder!=$Year){
					$OrderFlag=1;
				}
				break;		
		
		}
		}


		 #echo $value['InvoiceID'].'<br>'.$OrderFlag;exit;

		if($OrderFlag==1){
			
                       
			/*$NumLine = 0;
                        
                        if($value['GlEntryType'] == "Single"){
                           $arryPayments = $this->GetPaymentEntry($value['OrderID']);
                        }
			$NumLine = sizeof($arryPayments);*/
                        
                        if($value['ExpenseID'] > 0){
                            $arryGLAccountData = $this->GetMultiGLAccount($value['ExpenseID']);
                         }
                        
                         $Config['arryGLAccountData']=$arryGLAccountData;
                        
                        
                        
			if($value['OrderID'] > 0){                            	
                           	
				/******Set Recurring Amount*********/
				if($value['PostToGL']=="1" && $value['RecurringAmount']>0 && ($value['InvoiceEntry']=="2" || $value['InvoiceEntry']=="3") ){
					$value['TotalAmount'] = $value['RecurringAmount'];
					$value['TotalInvoiceAmount'] = $value['RecurringAmount'];
				} 				
				/***************************/
				$order_id = $this->addOtherExpense($value);
                                
				$strSQL = "update p_order set LastRecurringEntry ='" . $Config['TodayDate'] . "' where OrderID='" . $value['OrderID'] . "'";
				$this->myquery($strSQL, 0);
				 
			}


		}


	  }
       	  return true;
   }
   
   
    function GetMultiGLAccount($ExpenseID){
       
          $strSQLQuery = "select m.* from f_multi_account_payment m where m.ExpenseID = '".$ExpenseID."'";
          return $this->myquery($strSQLQuery, 1);

       
   }
   
   function GetPaymentEntry($OrderID){
       
          $strSQLQuery = "select p.* from f_payments p where p.OrderID = '".$OrderID."'";
          $arryRow =  $this->myquery($strSQLQuery, 1);
          
          if(sizeof($arryRow) > 0){
             foreach($arryRow as $value){ 
                $strSQLQuery = "select p.* from f_payments p where p.PID = '".$value['PaymentID']."'";
                $arryRowNew =  $this->myquery($strSQLQuery, 1);
             }
          }
          
          return array_merge($arryRow,$arryRowNew);
       
   }
   

	/************* 31 July *************/
	 function getGroupByAccountType($AccountType)
		{
			$strSQLQuery = "select * from f_group where AccountType = '".$AccountType."'  and Status = 'Yes' and ParentGroupID='0'";
			return $this->query($strSQLQuery, 1);
		}


	 function getGroupAccountByAccountType($RangeFrom)
		{
			
			$strAddQuery = " where RangeFrom = '".$RangeFrom."'  and Status = 'Yes' and ParentGroupID='0'";
		        $strSQLQuery = "select * from f_group ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

	function isGroupAccountExists($GroupName,$AccountTypeID,$ParentGroupID,$GroupID=0)
	{
		$strSQLQuery = (!empty($GroupID))?(" and GroupID != '".$GroupID."'"):("");
		$strSQLQuery = "SELECT GroupID FROM f_group WHERE GroupName='".mysql_real_escape_string(trim($GroupName))."' AND AccountTypeID = '".$AccountTypeID."' AND ParentGroupID = '".$ParentGroupID."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['GroupID'])) {
			return true;
		} else {
			return false;
		}
	} 



   function addGroupAccount($arryDetails)
                {

			 
			@extract($arryDetails);
			global $Config;

			if(empty($Status)) $Status="Yes";
			
 
                     $strSQLQuery = "INSERT INTO f_group SET GroupNumber='".$GroupNumber."',GroupName = '".mysql_real_escape_string($GroupName)."', ParentGroupID='".$main_ParentGroupID."',AccountType='".mysql_real_escape_string($AccountType)."',Status = '".$Status."',RangeFrom='".$RangeFrom."',RangeTo='".$RangeTo."',CreatedDate = '".$Config['TodayDate']."'";
					 
                     $this->query($strSQLQuery,0);
                     $GroupID = $this->lastInsertId();
                     return $GroupID;
                   
                }
                
                function getBankAccountWithRoot($RangeFrom)
		{
		
			 $strSQLQuery = "select f.BankAccountID,f.AccountName,f.AccountNumber,f.RangeFrom,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.RangeFrom = f.RangeFrom  WHERE f.Status = 'Yes' and f.GroupID='0' and f.RangeFrom='".$RangeFrom."' order by f.AccountNumber asc";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}
                
                function getBankAccountWithGroupID($GroupID,$RangeFrom='')
		{
			global $Config;
			$InnerDateRange='';
			 if(!empty($RangeFrom)){				
				if($RangeFrom>=4000){ //P & L account
					$FromYear = date("Y");
					$FromDate = date($FromYear.'-01-01');
					$InnerDateRange = " and p.PaymentDate>='".$FromDate."'";
				}
			}
				
			$strSQLQuery = "select f.*, (select SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID AND p.PostToGL = 'Yes' ".$InnerDateRange.") as ReceivedAmnt,(select SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID AND p.PostToGL = 'Yes' ".$InnerDateRange.") as PaidAmnt from f_account f WHERE f.GroupID='".$GroupID."' order by f.AccountNumber"; 
			 


                    return $this->query($strSQLQuery, 1);
		}
                


                function getTotalDebitCreditAmount($accountid,$AccountType,$FromDate,$ToDate)
                {
			global $Config;

			$this->SetCashOnlySql();

		 #$strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments p WHERE  p.PostToGL = 'Yes' AND p.AccountID ='".mysql_real_escape_string($accountid)."' and p.PaymentDate between '".$FromDate."' and '".$ToDate."'"; 
		
                     $strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments p ".$Config["CashOnlyJoin"]." WHERE  p.PostToGL = 'Yes' AND p.AccountID ='".mysql_real_escape_string($accountid)."' and p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."' ".$Config["CashOnlyWhere"]; 
       
			 
			 
                                return $this->query($strSQLQuery, 1);

                }

		 function getBeginningBalanceRange($accountid,$AccountType,$FromDate,$ToDate)
                {
			global $Config;

			 $this->SetCashOnlySql();
		 #$strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments p WHERE  p.PostToGL = 'Yes' AND p.AccountID ='".mysql_real_escape_string($accountid)."' and p.PaymentDate between '".$FromDate."' and '".$ToDate."'"; 
		
                      $strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments p ".$Config["CashOnlyJoin"]." WHERE  p.PostToGL = 'Yes' AND p.AccountID ='".mysql_real_escape_string($accountid)."' and p.PaymentDate>='".$FromDate."' and p.PaymentDate<'".$ToDate."' ".$Config["CashOnlyWhere"]; 
       
			 

                                return $this->query($strSQLQuery, 1);

                }

                
                function TotalDebitCreditByGroup($GroupID,$FromDate,$ToDate)
                {
                                $strSQLQuery = "SELECT BankAccountID from f_account WHERE  Status='Yes' and GroupID='".mysql_real_escape_string($GroupID)."'";
                                
                                $BankAccoutDetail=$this->query($strSQLQuery, 1);
                                
                                $DbtCrdArr=array();
                                foreach($BankAccoutDetail as $BankDetails)
                                {
                                    $Total_Sum=$this->getTotalDebitCreditAmount($BankDetails["BankAccountID"],'',$FromDate,$ToDate);
                                    //$Total_Dbt+=$Total_Sum[0]["DbAmnt"];
                                    //$Total_Crd+=$Total_Sum[0]["CrAmnt"];
                                    if( $Total_Sum[0]["DbAmnt"]> $Total_Sum[0]["CrAmnt"])
                                    {
                                         $Total_Dbt+=($Total_Sum[0]["DbAmnt"] - $Total_Sum[0]["CrAmnt"]);
                                    }
                                    else {
                                       $Total_Crd+= ($Total_Sum[0]["CrAmnt"] - $Total_Sum[0]["DbAmnt"]);
                                    }
                                }
                                $DbtCrdArr["DbAmnt"]=$Total_Dbt;
                                $DbtCrdArr["CrAmnt"]=$Total_Crd;
                                return $DbtCrdArr;

                }
                function NetDebitCreditByGroup($GroupID,$FromDate,$ToDate)
                {
                                $strSQLQuery = "SELECT BankAccountID from f_account WHERE  Status='Yes' and GroupID='".mysql_real_escape_string($GroupID)."'";
                                
                                $BankAccoutDetail=$this->query($strSQLQuery, 1);
                                
                                $DbtCrdArr=array();
				$Total_Dbt=$Total_Crd=0;
                                foreach($BankAccoutDetail as $BankDetails)
                                {
                                    $Total_Sum=$this->getTotalDebitCreditAmount($BankDetails["BankAccountID"],'',$FromDate,$ToDate);
                                    //$Total_Dbt+=$Total_Sum[0]["DbAmnt"];
                                    //$Total_Crd+=$Total_Sum[0]["CrAmnt"];
                                    if( $Total_Sum[0]["DbAmnt"]> $Total_Sum[0]["CrAmnt"])
                                    {
                                         $Total_Dbt+=($Total_Sum[0]["DbAmnt"] - $Total_Sum[0]["CrAmnt"]);
                                    }
                                    else {
                                       $Total_Crd+= ($Total_Sum[0]["CrAmnt"] - $Total_Sum[0]["DbAmnt"]);
                                    }
                                }
                                $DbtCrdArr["DbAmnt"]=$Total_Dbt;
                                $DbtCrdArr["CrAmnt"]=$Total_Crd;
                                
                                
                                $strSQLQuery1 = "SELECT GroupID from f_group WHERE  Status='Yes' and ParentGroupID='".mysql_real_escape_string($GroupID)."'";
                                
                                $BankAccoutDetail1=$this->query($strSQLQuery1, 1);
                                
                                foreach($BankAccoutDetail1 as $BankDetails1)
                                {
                                  
            
                                   $AmountSum=$this->NetDebitCreditByGroup($BankDetails1["GroupID"],$FromDate,$ToDate);
                                   
                                   if( $AmountSum["DbAmnt"]> $AmountSum["CrAmnt"])
                                    {
                                         $Total_Dbt+=($AmountSum["DbAmnt"] - $AmountSum["CrAmnt"]);
                                    }
                                    else {
                                       $Total_Crd+= ($AmountSum["CrAmnt"] - $AmountSum["DbAmnt"]);
                                    }
                                }
                                    
                                   
                               
                                $DbtCrdArr["DbAmnt"]= $Total_Dbt;
                                $DbtCrdArr["CrAmnt"]= $Total_Crd;
                                return $DbtCrdArr;
                                

                }
                function TotalDebitCreditByAccountType($AccountTypeID,$FromDate,$ToDate)
                {
                                $strSQLQuery = "SELECT BankAccountID from f_account WHERE  Status='Yes' and AccountType='".mysql_real_escape_string($AccountTypeID)."'";
                                
                                $BankAccoutDetail=$this->query($strSQLQuery, 1);
                                
                                $DbtCrdArr=array();
                                foreach($BankAccoutDetail as $BankDetails)
                                {
                                    $Total_Sum=$this->getTotalDebitCreditAmount($BankDetails["BankAccountID"],'',$FromDate,$ToDate);
                                    $Total_Dbt+=$Total_Sum[0]["DbAmnt"];
                                    $Total_Crd+=$Total_Sum[0]["CrAmnt"];
                                }
                                $DbtCrdArr["DbAmnt"]=$Total_Dbt;
                                $DbtCrdArr["CrAmnt"]=$Total_Crd;
                                return $DbtCrdArr;

                }
                function NetDebitCreditByAccountType($RangeFrom,$FromDate,$ToDate)
                {
                                $strSQLQuery = "SELECT BankAccountID from f_account WHERE  Status='Yes' and RangeFrom='".mysql_real_escape_string($RangeFrom)."'";
                                
                                $BankAccoutDetail=$this->query($strSQLQuery, 1);
                                
                                $DbtCrdArr=array();
				$Total_Crd=$Total_Dbt=0;
                                foreach($BankAccoutDetail as $BankDetails)
                                {
                                    $Total_Sum=$this->getTotalDebitCreditAmount($BankDetails["BankAccountID"],'',$FromDate,$ToDate);
                                    //$Total_Dbt+=$Total_Sum[0]["DbAmnt"];
                                    //$Total_Crd+=$Total_Sum[0]["CrAmnt"];
                                    if( $Total_Sum[0]["DbAmnt"]> $Total_Sum[0]["CrAmnt"])
                                    {
                                         $Total_Dbt+=($Total_Sum[0]["DbAmnt"] - $Total_Sum[0]["CrAmnt"]);
                                    }
                                    else {
                                       $Total_Crd+= ($Total_Sum[0]["CrAmnt"] - $Total_Sum[0]["DbAmnt"]);
                                    }
                                    
                                }
                                $DbtCrdArr["DbAmnt"]=$Total_Dbt;
                                $DbtCrdArr["CrAmnt"]=$Total_Crd;
                                return $DbtCrdArr;

                }
		function NetDebitCreditByAccountTypeTrial($RangeFrom,$FromDate,$ToDate)
                {
			global $Config;

			$Total_Crd=$Total_Dbt=0;

                        $strSQLQuery = "SELECT BankAccountID from f_account WHERE  Status='Yes' and RangeFrom='".mysql_real_escape_string($RangeFrom)."'";
                        
                        $BankAccoutDetail=$this->query($strSQLQuery, 1);
                        
                        $DbtCrdArr=array();

			$Config['CreditMinusDebit']=0;
			if($RangeFrom=='2000' || $RangeFrom=='3000' || $RangeFrom=='4000' || $RangeFrom=='7000'){
				$Config['CreditMinusDebit']=1;
			} 


                        foreach($BankAccoutDetail as $BankDetails)
                        {
                            $Total_Sum=$this->getTotalDebitCreditAmount($BankDetails["BankAccountID"],'',$FromDate,$ToDate);
                            

			
			/*if($RangeFrom<4000){
				$BeginningBalance=$this->getBeginningBalance($BankDetails["BankAccountID"],$FromDate);
			}*/

			$NettBalance=0; 
			$BeginningBalance=0;

			/*******************/
			$Config['BegBalForCurrentYear']=0;
			if($RangeFrom>3000){ //P&L
				$Config['BegBalForCurrentYear'] = 1;
			}
			$BeginningBalance=$this->getBeginningBalance($BankDetails["BankAccountID"],$FromDate);		$Config['BegBalForCurrentYear']=0;
			/*******************/

			if($Config['TransactionType']=="B"){
				$NettBalance = round($BeginningBalance,2);
				$Total_Sum[0]["CrAmnt"]=0;
				$Total_Sum[0]["DbAmnt"]=0;
			}else if($Config['TransactionType']=="A"){
				$NettBalance=0;
				$BeginningBalance=0; 
			}else{
				$NettBalance = round($BeginningBalance,2);
			}
			/*******************/
		 

			if($Config['CreditMinusDebit']==1){
				$Total_Crd+= $NettBalance + round(($Total_Sum[0]["CrAmnt"] - $Total_Sum[0]["DbAmnt"]),2);
			}else {
				$Total_Dbt+= $NettBalance + round(($Total_Sum[0]["DbAmnt"] - $Total_Sum[0]["CrAmnt"]),2);
			}



                            
                        }

                        $DbtCrdArr["DbAmnt"]=round($Total_Dbt,2);
                        $DbtCrdArr["CrAmnt"]=round($Total_Crd,2);

			

                        return $DbtCrdArr;

                }
                
                function getSubGroupAccount($ParentGroupID,$num,$FromDate,$ToDate)
                {
                    
                    //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				
                                
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10">';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= ucwords($values['GroupName']);

                                $htmlAccount .= '</td>';
                                $htmlAccount .= '<td align="right" ></td>';      //$htmlAccount .= '<td align="right" >'.number_format($TotalDbtCrdwithGroup["DbAmnt"],2,'.','').'</td>';
                                 

                                 $htmlAccount .= '<td align="right" ></td>
                        </tr>';
//$htmlAccount .= '<td align="right" >'.number_format($TotalDbtCrdwithGroup["CrAmnt"],2,'.','').'</td> </tr>';
   
                                $htmlAccount;  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                            
                                    if(($account_data[0]['DbAmnt']) > ($account_data[0]['CrAmnt']))
                                    {
                                        $DbtAmt1=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
                                        $CrdAmt1=0;
                                       
                                    }else if(($account_data[0]['CrAmnt']) > ($account_data[0]['DbAmnt'])) {
                                        $CrdAmt1=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                        $DbtAmt1=0;
                                        
                                    }else if(($account_data[0]['DbAmnt'])==($account_data[0]['CrAmnt']))
                                    {
                                        $CrdAmt1=0;
                                        $DbtAmt1=0;
                                        
                                    }
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10">';
				$htmlAccount1 .= str_repeat("&nbsp;",$spacenum);
                                $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="right" width="">'.number_format($DbtAmt1,2,'.','').'</td>';
                                 

                                $htmlAccount1 .= '<td align="right" >'.number_format($CrdAmt1,2,'.','').'</td>
                        </tr>';
                        
                                }
                                 
                                echo $htmlAccount;
                                echo $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccount($values['GroupID'],$num,$FromDate,$ToDate); 
                                  }
                                }  
                 
                }
                

		function getSubGroupAccountTrial($ParentGroupID,$num,$FromDate,$ToDate)
                {
                    global $Config;

                    //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				
                                
                               #$TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr>
                                 <td  align="left" height="20" colspan="3">';
				$htmlAccount .= str_repeat($Config['AccPrefix'],$num);
                                $htmlAccount .= ucwords($values['GroupName']);
                                $htmlAccount .= '</td>';
				
                                  
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
				/****pk***********/
				$arrayDC=$this->GetDebitCreditTrail($AccountNamee['BankAccountID'], $AccountNamee['RangeFrom'] ,$FromDate,$ToDate);	
				/***************/
                                   
                                 $spacenum=$num+2;
                                    
                            
                                     
            			if($arrayDC['DebitAmt'] != "0.00" || $arrayDC['CreditAmt'] != "0.00" ){
		                        $htmlAccount1 .= '<tr align="left">
		                        <td height="10">';
					$htmlAccount1 .= str_repeat($Config['AccPrefix'],$spacenum);
		                        $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

		                        $htmlAccount1 .= '</td>';
		                        $htmlAccount1 .= '<td align="right" width="">'.$arrayDC['DebitAmt'].'</td>';
		                         

		                        $htmlAccount1 .= '<td align="right" >'.$arrayDC['CreditAmt'].'</td>
		                </tr>';
					}
                        
                                }
                                 
                                /*echo $htmlAccount;
                                echo $htmlAccount1;*/
				 $Config['ExportContent'] .= $htmlAccount;
				$Config['ExportContent'] .= $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccountTrial($values['GroupID'],$num,$FromDate,$ToDate); 
                                  }
                                }  
                 
                }
                


                function getSubGroupAccount4Excel($ParentGroupID,$num,$FromDate,$ToDate)
                {
                    
                    //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				
                                
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount.='<tr align="left">
                                 <td height="10">';
				$htmlAccount.=str_repeat("-",$num);
                                $htmlAccount.=strtoupper($values['GroupName']);

			 $htmlAccount.= '</td>';
                         $htmlAccount.= '<td align="right" width="">'.number_format($TotalDbtCrdwithGroup["DbAmnt"],2,'.','').'</td>';
                                 

                                $htmlAccount.= '<td align="right" >'.number_format($TotalDbtCrdwithGroup["CrAmnt"],2,'.','').'</td>
                        </tr>';
                                
                                
                                  
                                $htmlAccount;  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                                     if(($account_data[0]['DbAmnt']) > ($account_data[0]['CrAmnt']))
                                    {
                                        $DbtAmt1=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
                                        $CrdAmt1=0;
                                         //$test="DBT";
                                       
                                    }else if(($account_data[0]['CrAmnt']) > ($account_data[0]['DbAmnt'])) {
                                        $CrdAmt1=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                        $DbtAmt1=0;
                                        //$test="cBT";
                                        
                                    }else if(($account_data[0]['DbAmnt'])==($account_data[0]['CrAmnt']))
                                    {
                                          $CrdAmt1=0;
                                          $DbtAmt1=0;
                                        //$test="equal";
                                        
                                    }

                                    $htmlAccount1.= '<tr align="left">
                                 <td>';
				$htmlAccount1.= str_repeat("-",$spacenum);
                                $htmlAccount1.= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1.= '</td>';
                                $htmlAccount1.= '<td align="right">'.number_format($DbtAmt1,2,'.','').'</td>';
                                 

                                $htmlAccount1.= '<td align="right" >'.number_format($CrdAmt1,2,'.','').'</td>
                        </tr>';
                                $htmlAccount=$htmlAccount.$htmlAccount1;
                        
                                }
                                 $htmlAccount1='';
                                
                                
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccount4Excel($values['GroupID'],$num,$FromDate,$ToDate); 
                                  }
                                  
                                  
                                  
                                  
                                } 
                                
                                return $htmlAccount;
                 
                }
                
                function getSubGroupAccount4ProftLoss($ParentGroupID,$num,$FromDate,$ToDate,$AccountType)
                {
                    
                    //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				
                               if($AccountType=='INCOME')
                               {
                               $AccountType = $values['AccountType'];
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10">';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= strtoupper($values['GroupName']);

                                $htmlAccount .= '</td>';
                                $htmlAccount .= '<td align="right" width=""></td>';
                                $htmlAccount .= '<td align="right" ></td>
                        </tr>';
   
                                $htmlAccount;  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                            
                                    
                                        $CrdAmt1=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                        
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10">';
				$htmlAccount1 .= str_repeat("&nbsp;",$spacenum);
                                $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="right" width="">'.number_format($CrdAmt1,2).'</td>';
                                 

                                $htmlAccount1 .= '<td align="right" ></td></tr>';
                        
                                }
                                 
                                echo $htmlAccount;
                                echo $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccount4ProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountType); 
                                  }
                                  
                                  } //if income end
                                  
                                  if($AccountType=='EXPENSES')
                               {
                                
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10">';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= strtoupper($values['GroupName']);

                                $htmlAccount .= '</td>';
                                $htmlAccount .= '<td align="right" width=""></td>';
                                 

                                $htmlAccount .= '<td align="right" ></td></tr>';
   
                                $htmlAccount;  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                            
                                   
                                        $DbtAmt1=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
                                        
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10">';
				$htmlAccount1 .= str_repeat("&nbsp;",$spacenum);
                                $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="right" width="">'.number_format($DbtAmt1,2).'</td>';
                                 

                                $htmlAccount1 .= '<td align="right" ></td></tr>';
                        
                                }
                                 
                                echo $htmlAccount;
                                echo $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccount4ProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountType); 
                                  }
                                  
                                  } //if expenses end
                                  
                                  
                                  
                                }  
                 
                }
                

	function getSubGroupProftLoss($ParentGroupID,$num,$FromDate,$ToDate,$AccountTypeVal)
                {
                    
                   global $Config;

			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                       	  
                          $result = mysql_query($query);
			 
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				 
				/*********************/
                               if($AccountTypeVal=='INCOME')
                               { 
                               $AccountType = $values['AccountType'];
                               #$TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10" colspan="3"><b>';
				$htmlAccount .= str_repeat($Config['AccPrefix'],$num);
                                $htmlAccount .= strtoupper($values['GroupName']);
                                $htmlAccount .= '</b></td></tr>';
                               
                                  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                            
                                    
                                $CrdAmt1=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                   
				 if(!empty($CrdAmt1)){ //start row     
		                        $htmlAccount1 .= '<tr align="left">
		                        <td height="10">';
					$htmlAccount1 .= str_repeat($Config['AccPrefix'],$spacenum);
		                        $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

		                        $htmlAccount1 .= '</td>';
		                        $htmlAccount1 .= '<td align="right" width="">'.number_format($CrdAmt1,2).'</td>';
		                        $htmlAccount1 .= '<td align="right" ></td></tr>';
				 }
                        
                                }
                                 
                                $Config['ExportContent'] .= $htmlAccount;
				$Config['ExportContent'] .= $htmlAccount1;
                                  
                                 if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountTypeVal); 
                                  }
                                  
                             }  
                              /*******income end*********/	   
				
				/*********************/	
                                if($AccountTypeVal=='EXPENSES'){
                                
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10" colspan="3"><b>';
				$htmlAccount .= str_repeat($Config['AccPrefix'],$num);
                                $htmlAccount .= strtoupper($values['GroupName']);
                                $htmlAccount .= '</b></td></tr>';
                                
                               
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                                                       
					$account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
					$spacenum=$num+2;



					$DbtAmt1=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));

					 if(!empty($DbtAmt1)){ //start row    
					$htmlAccount1 .= '<tr align="left">
					<td height="10">';
					$htmlAccount1 .= str_repeat($Config['AccPrefix'],$spacenum);
					$htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

					$htmlAccount1 .= '</td>';
					$htmlAccount1 .= '<td align="right" width="">'.number_format($DbtAmt1,2).'</td>';


					$htmlAccount1 .= '<td align="right" ></td></tr>';
                        		}
                                }
                                 
                                $Config['ExportContent'] .= $htmlAccount;
				$Config['ExportContent'] .= $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountTypeVal); 
                                  }
                                  
                                 }  
                                  
				/*********expenses end************/	
                                  
                                  
                                }  
                 
                }
                  function TotalSubGroupAccount4ProftLoss($ParentGroupID,$num,$FromDate,$ToDate,$AccountType,$NetSubAmount)
                {
                    
                    //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				
                               if($AccountType=='INCOME')
                               {
                                    
                                $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                        
                                        $NetAmt=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                        
                                        $NetSubAmount+=$NetAmt;

                                }
                                 
                                return $NetSubAmount;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->TotalSubGroupAccount4ProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountType,$NetSubAmount); 
                                  }
                                  
                                  } //if income end
                                  
                                  if($AccountType=='EXPENSES')
                               {
                                      
                                      
                                
                                $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
   
                                        $NetAmt=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt'])); 
                                        $NetSubAmount+=$NetAmt;
       
                                }
                                 
                                return $NetSubAmount;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->TotalSubGroupAccount4ProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountType,$NetSubAmount); 
                                  }
                                  
                                  } //if expenses end
                                  
                                  
                                  
                                }  
                 
                }
                
                
                
                function PreviousDebtCrdAmount($ThresholdDate){
                    
                    $strSQLQuery="SELECT SUM(GE.DebitAmnt) as DbAmnt,SUM(GE.CreditAmnt) as CrAmnt from f_gerenal_journal_entry GE inner join f_gerenal_journal GJ on GE.JournalID=GJ.JournalID WHERE GJ.JournalDate < '".$ThresholdDate."'";
                    return $this->query($strSQLQuery, 1);
                    
                    
                }

		  function  GetSubGroupAccountTreeWithSelect($ParentID,$num)
		     {
		           global $Config;
                           //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentID."'";
                          return $this->query($query, 1);
             
		}
		 function  GetSubGroupAccountTreeWithSelect1($ParentID,$num,$optionHtml,$selParent)
		     {
		           
                           //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentID."'";
                          $dataa=$this->query($query, 1);
                          $num=$num+5;
                          //$optionHtml='';
                          foreach($dataa as $GroupNameData){
				$Selected1 = ($selParent == $GroupNameData["GroupID"])?(" Selected"):(" ");
                              $spaceNum=$num+2;
                              $spaceNum=str_repeat("&nbsp;",$spaceNum);
                              $optionHtml.="<option value='".$GroupNameData["GroupID"]."' ".$Selected1.">".$spaceNum.($GroupNameData["GroupName"])."</option>"; 
                              //$optionHtml.=$this->GetSubGroupAccountTreeWithSelect1($GroupNameData["GroupID"],0,$optionHtml);
                          }
                          
                         return $optionHtml;
             
		}
                
                function RecursiveOptionValue($GroupID){
                   
                    $this->GetSubGroupAccountTreeWithSelect1($GroupID,$num);
                }

		 function getChartSubGroupAccount($ParentGroupID,$num,$FromDate,$ToDate)
                {	
			global $Config;
                    
                 
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 

				$AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);

                                $htmlAccount = '<tr align="left">
                                 <td height="10">';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= strtoupper($values['GroupName']).' [Group]';

                                $htmlAccount .= '</td>';
                              
				$htmlAccount .= '<td colspan="3"></td>';
                                $htmlAccount .= '<td align="center" ><a href="editGroup.php?edit='.$values['GroupID'].'" >'.$Config['editImg'].'</a> ';


				if(sizeof($AccountwithGroup)<=0){
				#$htmlAccount .= ' <a href="editGroup.php?del_id='.$values['GroupID'].'" >'.$Config['deleteImg'].'</a>';
				} 

                       		 $htmlAccount .= '</td></tr>';
   
                                $htmlAccount;  
                                
                                
                                
                                
                                $htmlAccount1='';
				 $Balance=0;
                                foreach($AccountwithGroup as $AccountNamee)
                                {
					$ReceivedAmnt = $AccountNamee['ReceivedAmnt'];
					$PaidAmnt = $AccountNamee['PaidAmnt'];

					$Balance = $ReceivedAmnt-$PaidAmnt;
                                  
                                    $spacenum=$num+2;
                                    
                            
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10">';
				$htmlAccount1 .= str_repeat("&nbsp;",$spacenum);
                                $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="left" >'.$AccountNamee['AccountNumber'].' </td>';
                                 

                                $htmlAccount1 .= '<td align="right" ><strong>'.number_format($Balance,2,'.',',').' </strong></td>';

				 $htmlAccount1 .= '<td align="center" >';

				if ($AccountNamee['Status'] == 'Yes') {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}
				if($Balance == 0 && $AccountNamee['CashFlag'] != 1) {                  

				$statusLink = 'editAccount.php?active_id=' . $AccountNamee["BankAccountID"] . '&curP=' . $_GET["curP"] . '';
				}else{
				$statusLink = "javascript:void();";
				}

				 $htmlAccount1 .= '<a href="'.$statusLink.'" class="'.$status.'">' . $status . '</a>';

				$htmlAccount1 .= ' </td><td align="center" class="head1_inner">';


				
                               $htmlAccount1 .= ' <a href="vAccount.php?view='.$AccountNamee['BankAccountID'].'">'.$Config['viewImg'].'</a>';

                              if($Balance == 0 && $AccountNamee['CashFlag'] != 1) {
                                $htmlAccount1 .= ' <a href="editAccount.php?edit='.$AccountNamee['BankAccountID'].'&curP='.$_GET['curP'].'" class="Blue">'.$Config['editImg'].'</a>

                                   <a href="editAccount.php?del_id='.$AccountNamee['BankAccountID'].'&curP='.$_GET['curP'].'" onclick="return confDel(\'Account\')" class="Blue" >'.$Config['deleteImg'].'</a>';

                               }

				 $htmlAccount1 .= '<a href="accountHistory.php?accountID='.$AccountNamee['BankAccountID'].'&accountType='.$AccountNamee['AccountType'].'" target="_blank">'.$Config['history'].'</a>';								   
                             
                            








                         	$htmlAccount1 .= '</td></tr>';
                        
                                }
                                 
                                echo $htmlAccount;
                                echo $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getChartSubGroupAccount($values['GroupID'],$num,$FromDate,$ToDate); 
                                  }
                                }  
                 
                }


	function updateGroupAccount($arryDetails)
                {
                    
                    @extract($arryDetails);
		    global $Config;
                    
                    $strSQLQuery = "update f_group SET GroupNumber='".$GroupNumber."',GroupName = '".mysql_real_escape_string($GroupName)."', ParentGroupID='".$main_ParentGroupID."',AccountType='".mysql_real_escape_string($AccountType)."',Status = '".$Status."',RangeFrom='".$RangeFrom."',RangeTo='".$RangeTo."',UpdatedDate = '".$Config['TodayDate']."' where GroupID='".$GroupID."'";
                    
                    $this->query($strSQLQuery,0);
                     
                    return 1;
                }

                function RemoveGroupAccount($DelID)
                {
                        $strSQLQuery = "DELETE FROM f_group WHERE GroupID ='".mysql_real_escape_string($DelID)."'"; 
			$this->query($strSQLQuery, 0);
			return 1;     
                }

	    function getBankAccountWithAccountTypeID($AccountTypeID)
	    {
	       
		$strSQLQuery = "select f.BankAccountID,f.AccountName,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.AccountTypeID = f.AccountType  WHERE f.LocationID = '" . $_SESSION['locationID'] . "' and f.Status = 'Yes' and f.AccountType='" . $AccountTypeID . "' order by f.AccountName";
		
		return $this->query($strSQLQuery, 1);
	    }
            
            /**** function added on 11 august 2015 ***/
                function getSubGroupAccount4ExcelProftLoss($ParentGroupID,$num,$FromDate,$ToDate,$AccountType)
                {
                    
                    //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				
                               if($AccountType=='INCOME')
                               {
                                
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10">';
				$htmlAccount .= str_repeat("-",$num);
                                $htmlAccount .= strtoupper($values['GroupName']);

                                $htmlAccount .= '</td>';
                                $htmlAccount .= '<td align="right" width=""></td>';
                                $htmlAccount .= '<td align="right" ></td>
                        </tr>';
   
                                $htmlAccount;  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                            
                                    if(($account_data[0]['DbAmnt']) > ($account_data[0]['CrAmnt']))
                                    {
                                        $DbtAmt1=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
                                        $CrdAmt1=0;
                                        
                                       
                                    }else if(($account_data[0]['CrAmnt']) > ($account_data[0]['DbAmnt'])) {
                                        $CrdAmt1=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                        $DbtAmt1=0;
                                        
                                    }else if(($account_data[0]['DbAmnt'])==($account_data[0]['CrAmnt']))
                                    {
                                        $CrdAmt1=0;
                                        $DbtAmt1=0;
                                        
                                    }
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10">';
				$htmlAccount1 .= str_repeat("-",$spacenum);
                                $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="right" width="">'.number_format($DbtAmt1,2,'.','').'</td>';
                                 

                                $htmlAccount1 .= '<td align="right" ></td></tr>';
                                
                                $htmlAccount=$htmlAccount.$htmlAccount1;
                        
                                }
                                 $htmlAccount1='';
                                
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccount4ProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountType); 
                                  }
                                  
                                  
                                  return $htmlAccount; 
                                  } //if income end
                                  
                                  if($AccountType=='EXPENSES')
                               {
                                
                               $TotalDbtCrdwithGroup=$this->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
                                
                                $htmlAccount = '<tr align="left">
                                 <td height="10">';
				$htmlAccount .= str_repeat("-",$num);
                                $htmlAccount .= strtoupper($values['GroupName']);

                                $htmlAccount .= '</td>';
                                $htmlAccount .= '<td align="right" width=""></td>';
                                 

                                $htmlAccount .= '<td align="right" ></td></tr>';
   
                                $htmlAccount;  
                                
                                $AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID']);
                                
                                
                                $htmlAccount1='';
                                foreach($AccountwithGroup as $AccountNamee)
                                {
                                    
                                    
                                    $account_data=$this->getTotalDebitCreditAmount($AccountNamee['BankAccountID'],'',$FromDate,$ToDate);
                                    $spacenum=$num+2;
                                    
                            
                                    if(($account_data[0]['DbAmnt']) > ($account_data[0]['CrAmnt']))
                                    {
                                        $DbtAmt1=(($account_data[0]['DbAmnt']) - ($account_data[0]['CrAmnt']));
                                        $CrdAmt1=0;
                                       
                                    }else if(($account_data[0]['CrAmnt']) > ($account_data[0]['DbAmnt'])) {
                                        $CrdAmt1=(($account_data[0]['CrAmnt']) - ($account_data[0]['DbAmnt']));
                                        $DbtAmt1=0;
                                        
                                    }else if(($account_data[0]['DbAmnt'])==($account_data[0]['CrAmnt']))
                                    {
                                        $CrdAmt1=0;
                                        $DbtAmt1=0;
                                        
                                    }
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10">';
				$htmlAccount1 .= str_repeat("-",$spacenum);
                                $htmlAccount1 .= strtoupper($AccountNamee['AccountName']);

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="right" width="">'.number_format($DbtAmt1,2,'.','').'</td>';
                                 

                                $htmlAccount1 .= '<td align="right" ></td></tr>';
                                $htmlAccount=$htmlAccount.$htmlAccount1;
                                }
                              
                                $htmlAccount1='';
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getSubGroupAccount4ProftLoss($values['GroupID'],$num,$FromDate,$ToDate,$AccountType); 
                                  }
                                  
                                  return $htmlAccount;
                                  } //if expenses end
                                  
                                  
                                  
                                }  
                 
                }
                
                
               /* end of function 11 august 2015 ***/ 
                
                
                
             /**********start 14 august 2015****************/
                
                
                function getAccountTypeByRange($RangeVal)
		{
			 
			 $strAddQuery = " where Status = 'Yes' and ('".$RangeVal."' between RangeFrom and RangeTo)";
			 $strSQLQuery = "select * from f_accounttype ".$strAddQuery;
			 return $this->query($strSQLQuery, 1);
		}

                function getGroupAccountByRange($RangeVal)
		{
			
			$strAddQuery = " where ParentGroupID='0' and Status = 'Yes' and ('".$RangeVal."' between RangeFrom and RangeTo)";
		        $strSQLQuery = "select * from f_group ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}
                
                
             /**********end 14 august 2015******************/ 
                
        function isGroupNumberExists($GroupNumber,$GroupID=0)
	{
		$strSQLQuery = (!empty($GroupID))?(" and GroupID != '".$GroupID."'"):("");
		$strSQLQuery = "SELECT GroupID FROM f_group WHERE GroupNumber='".mysql_real_escape_string(trim($GroupNumber))."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['GroupID'])) {
			return true;
		} else {
			return false;
		}
	} 

	 function isGroupNameExists($GroupName,$GroupID=0)
	{
		$strSQLQuery = (!empty($GroupID))?(" and GroupID != '".$GroupID."'"):("");
		$strSQLQuery = "SELECT GroupID FROM f_group WHERE GroupName='".mysql_real_escape_string(trim($GroupName))."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['GroupID'])) {
			return true;
		} else {
			return false;
		}
	} 
        
         function getAccountTypeByID($ID)
		{
			 
			 $strAddQuery = " where Status = 'Yes' and AccountTypeID='".$ID."'";
			 $strSQLQuery = "select * from f_accounttype ".$strAddQuery;
			 return $this->query($strSQLQuery, 1);
		}
                
                function getRootGroupAccountByRange($RangeFrom)
		{
			
			$strAddQuery = " where RangeFrom = '".$RangeFrom."'  and Status = 'Yes' and ParentGroupID='0'";
		        $strSQLQuery = "select * from f_group ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}
                
                function getChartSubGroupAccountNew($ParentGroupID,$num,$FromDate,$ToDate,$RangeFrom='')
                {	
			global $Config;
                    
                 
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          #echo "=>".$query."<br>";exit;
                                  $result = mysql_query($query);

                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
				$AccountTypeID='';
                            while($values = mysql_fetch_array($result)) { 
 
				if(!empty($values['AccountTypeID']))$AccountTypeID = $values['AccountTypeID'];
				$AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID'],$RangeFrom);
				$padd = $num+20;
                                $htmlAccount = '<tr align="left">
                                 <td height="10" style="padding-left:'.$padd.'px">';
				//$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= ucfirst($values['GroupName']).' [Group]';

                                $htmlAccount .= '</td>';
                              
				$htmlAccount .= '<td colspan="2"></td>';
				$htmlAccount .= '<td '.$Config['HideUnwanted'].'></td>';
                                $htmlAccount .= '<td align="center" '.$Config['HideUnwanted'].'><a href="editGroup.php?edit='.$values['GroupID'].'" >'.$Config['editImg'].'</a> ';


				if(sizeof($AccountwithGroup)<=0){
				#$htmlAccount .= ' <a href="editGroup.php?del_id='.$values['GroupID'].'" >'.$Config['deleteImg'].'</a>';
				} 

                       		 $htmlAccount .= '</td></tr>';
   
                                $htmlAccount;  
                                
                                
                                
                                
                                $htmlAccount1='';
				 $Balance=0;
                                foreach($AccountwithGroup as $AccountNamee)
                                {
					$ReceivedAmnt = $AccountNamee['ReceivedAmnt'];
					$PaidAmnt = $AccountNamee['PaidAmnt'];


					if($AccountTypeID==2 || $AccountTypeID==3 || $AccountTypeID==4 || $AccountTypeID==7){
						$Balance = $PaidAmnt-$ReceivedAmnt;
					}else{
						$Balance = $ReceivedAmnt-$PaidAmnt;
					}
					 
                                  



                                    $spacenum=$num+2;
                                    
                            	    $padd = $num+30;
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10" style="padding-left:'.$padd.'px">';
				//$htmlAccount1 .= str_repeat("&nbsp;",$spacenum);


				if($Config['pop']==1){
					$htmlAccount1 .= '<a href="Javascript:void(0)" onclick="Javascript:SetAccount(\''.$AccountNamee["BankAccountID"].'\',\''.ucwords($AccountNamee["AccountName"]).'\',\''.$AccountNamee["AccountNumber"].'\');" onMouseover="ddrivetip(\''.CLICK_TO_SELECT.'\', \'\',\'\')"; onMouseout="hideddrivetip()"><b>'.ucwords($AccountNamee["AccountName"]).'</b></a>';
				}else{
					$htmlAccount1 .= ucfirst($AccountNamee['AccountName']);
				}


                                

				if($AccountNamee['BankFlag'] == 1){
					$htmlAccount1 .= '<br>[ Bank Acc No: '.$AccountNamee['BankAccountNumber'].' ]';
				}

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="left" >'.$AccountNamee['AccountNumber'].' </td>';
                                 

				
				$NettBalanceVal = number_format($Balance,2);
				


                                $htmlAccount1 .= '<td align="right" '.$Config['HideUnwanted'].'><strong>'.$NettBalanceVal.' </strong></td>';

				 $htmlAccount1 .= '<td align="center" '.$Config['HideUnwanted'].'>';

				if ($AccountNamee['Status'] == 'Yes') {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}
				if($Balance == 0 && $AccountNamee['CashFlag'] != 1) {                  

				$statusLink = 'editAccount.php?active_id=' . $AccountNamee["BankAccountID"] . '&curP=' . $_GET["curP"] . '';
				}else{
				$statusLink = "javascript:void();";
				}

				 $htmlAccount1 .= '<a href="'.$statusLink.'" class="'.$status.'">' . $status . '</a>';

				$htmlAccount1 .= ' </td><td align="center" class="head1_inner" '.$Config['HideUnwanted'].'>';


				
                               //$htmlAccount1 .= ' <a href="vAccount.php?view='.$AccountNamee['BankAccountID'].'">'.$Config['viewImg'].'</a>';
				 $htmlAccount1 .= '  <a href="editAccount.php?edit='.$AccountNamee['BankAccountID'].'&curP='.$_GET['curP'].'" class="Blue">'.$Config['editImg'].'</a>  ';


                             if(!$this->isAccountTransactionExist($AccountNamee['BankAccountID'])){
                                $htmlAccount1 .= '
                                   <a href="editAccount.php?del_id='.$AccountNamee['BankAccountID'].'&curP='.$_GET['curP'].'" onclick="return confDel(\'Account\')" class="Blue" >'.$Config['deleteImg'].'</a>';

                               }

				 $htmlAccount1 .= '<a href="accountHistory.php?accountID='.$AccountNamee['BankAccountID'].'" target="_blank">'.$Config['history'].'</a>';								   
                             
                            








                         	$htmlAccount1 .= '</td></tr>';
                        
                                }
                                 
                                echo $htmlAccount;
                                echo $htmlAccount1;
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getChartSubGroupAccountNew($values['GroupID'],$num,$FromDate,$ToDate,$RangeFrom); 
                                  }
                                }  
                 
                }
                
                /****** 21 august 2015 *****/
                function getAllBankAccountWithRange($RangeFrom)
		{
		
			 $strSQLQuery = "select f.BankAccountID,f.AccountName,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.RangeFrom = f.RangeFrom  WHERE f.Status = 'Yes' and f.RangeFrom='".$RangeFrom."' order by f.AccountName";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}
                
                function getAccountTypePLIncome()
                {
                   $strSQLQuery = "select * from f_accounttype WHERE Status = 'Yes' and ReportType='PL' and RangeFrom IN(4000,7000,5000) order by OrderBy ASC";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);     
                    
                }
                
                function getAccountTypePLExpense()
                {
                   $strSQLQuery = "select * from f_accounttype WHERE Status = 'Yes' and ReportType='PL' and RangeFrom IN(6000,8000) order by OrderBy ASC";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);     
                    
                }
           /******end 21 august 2015 *****/

	   function isVendorLinked($SuppID,$CustID){
			$strSQLQuery = "select relID from f_customer_vendor where SuppID='".$SuppID."' and CustID != '".$CustID."'";
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['relID'])) {
				return true;
			} else {
				return false;
			}
	    }

	   function isCustomerLinked($SuppID,$CustID){
			$strSQLQuery = "select relID from f_customer_vendor where CustID='".$CustID."' and SuppID != '".$SuppID."'";
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['relID'])) {
				return true;
			} else {
				return false;
			}
	    }


	function  GetCustomerVendor($CustID,$SuppID){
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($CustID))?(" and CustID='".$CustID."'"):("");
		$strAddQuery .= (!empty($SuppID))?(" and SuppID='".$SuppID."'"):("");
		$strSQLQuery = "select * from f_customer_vendor ".$strAddQuery;
		return $this->query($strSQLQuery, 1);
	}                

          function LinkCustomerVendor($CustID, $SuppID, $UpdateFrom){  
		global $Config;
		//echo $CustID .'-'. $SuppID;exit;
		if(!empty($CustID) && !empty($SuppID)){ 
			if($UpdateFrom=='Customer'){
				$sql = "select relID from f_customer_vendor where CustID='".$CustID."' ";
				$arryRow = $this->query($sql, 1);
				if(!empty($arryRow[0]['relID'])) {
					 $strSQLQuery =  "UPDATE f_customer_vendor SET SuppID='".$SuppID."', UpdatedDate='".$Config['TodayDate']."'  WHERE relID = '".$arryRow[0]['relID']."'";
				} else {
					$strSQLQuery =  "INSERT INTO f_customer_vendor SET CustID='".$CustID."', SuppID='".$SuppID."', UpdatedDate='".$Config['TodayDate']."' ";
                              
				}	
			}else{ //vendor entry
				$sql = "select relID from f_customer_vendor where SuppID='".$SuppID."' ";
				$arryRow = $this->query($sql, 1);
				if(!empty($arryRow[0]['relID'])) {
					 $strSQLQuery =  "UPDATE f_customer_vendor SET CustID='".$CustID."', UpdatedDate='".$Config['TodayDate']."'  WHERE relID = '".$arryRow[0]['relID']."'";
				} else {
					$strSQLQuery =  "INSERT INTO f_customer_vendor SET CustID='".$CustID."', SuppID='".$SuppID."', UpdatedDate='".$Config['TodayDate']."' ";
                              
				}	
			}
			
		}else if(!empty($CustID)){
			$strSQLQuery = "delete from f_customer_vendor where CustID ='".$CustID."'";			
		}else if(!empty($SuppID)){
			$strSQLQuery = "delete from f_customer_vendor where SuppID ='".$SuppID."'";			;
		}

		$this->query($strSQLQuery,0);

		return true;
	}     

/*****************************************/
/*****************************************/
  function getMultiAdjustment($AdjID)  {
	global $Config;
	$strSQLQuery = "SELECT f.*,DECODE(f.Amount,'". $Config['EncryptKey']."') as Amount, a.AccountName ,a.AccountNumber,concat(a.AccountName,' [',a.AccountNumber,']') as AccountNameNumber from  f_multi_adjustment f left outer join f_account a on f.AccountID=a.BankAccountID where f.AdjID = '".trim($AdjID)."'";

	return $this->query($strSQLQuery, 1);
  }
   function GetPaymentByID($PID, $PaymentID){       
	$addSql .= (!empty($PID))?(" and PID = '".$PID."'"):("");
	$addSql .= (!empty($PaymentID))?(" and PaymentID = '".$PaymentID."'"):("");
	$strSQLQuery = "select p.*,concat(a.AccountName,' [',a.AccountNumber,']') as AccountNameNumber from f_payments p inner join f_account a on p.AccountID=a.BankAccountID where 1 ".$addSql;
	return $this->query($strSQLQuery, 1);       
   }


function addAdjustmentPO($arryDetails)	{
	extract($arryDetails);
	global $Config;

	$ipaddress = GetIPAddress(); 
        $Currency = $Config['Currency'];
        $LocationID = $_SESSION['locationID'];
	$TotalAmount = $Amount;
        $CreatedBy  = addslashes($_SESSION['UserName']);
        $AdminID  = $_SESSION['AdminID'];
        $AdminType  = $_SESSION['AdminType'];
	$PaymentType = 'Adjustment';

	$strPO = "select OrderID from p_order where Module='Invoice' and InvoiceID='".trim($InvoiceID)."'";
	$arryPO = $this->query($strPO, 1);
	$OrderID = $arryPO[0]['OrderID'];
                               
	$supplierData =  $this->GetSupplier('',$PaidTo,'');	
	$SuppCompany  = $supplierData[0]['CompanyName'];
                 
	$strSQLQuery = "INSERT INTO f_adjustment SET   InvoiceID  = '".$InvoiceID."', OrderID='".$OrderID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), BankAccount = '".$BankAccount."', PaidTo = '".$PaidTo."', SuppCompany = '".addslashes($SuppCompany)."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."',EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',GlEntryType='".$GlEntryType."', ExpenseTypeID = '".$ExpenseTypeID."'";
               
	$this->query($strSQLQuery, 0);	
	$AdjID = $this->lastInsertId();		

	/*********Add Payment Transaction**********/
        if(empty($ReferenceNo)) $ReferenceNo = $InvoiceID;

	$strSQLQueryPay = "INSERT INTO f_payments SET  InvoiceID  = '".$InvoiceID."', OrderID='".$OrderID."', PurchaseID='".addslashes($ReferenceNo)."', CreditAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$BankAccount."', AdjID = '".$AdjID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='".$PaymentType."',IPAddress='".$ipaddress."'";
	$this->query($strSQLQueryPay, 0);
        $PID = $this->lastInsertId();
                                
        if($GlEntryType == "Single"){
            $strSQLQueryPay = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ExpenseTypeID."', AdjID = '".$AdjID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."'";
            $this->query($strSQLQueryPay, 0);
        }else{
      

                    for($i=1;$i<=$NumLine1;$i++){
                        if( $arryDetails['invoice_check_'.$i] ==1 && ($arryDetails['GlAmnt'.$i] > 0 || $arryDetails['GlAmnt'.$i] < 0) && !empty($arryDetails['AccountID'.$i])){
                            $strSQLQueryPayMul = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$arryDetails['GlAmnt'.$i]."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$arryDetails['AccountID'.$i]."', AdjID = '".$AdjID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."'";
                            $this->query($strSQLQueryPayMul, 0);

                           $strSQLQueryPayMulAcc = "INSERT INTO f_multi_adjustment SET  AccountID='".$arryDetails['AccountID'.$i]."', AccountName = '".$arryDetails['AccountName'.$i]."', Notes = '".$arryDetails['Notes'.$i]."', Amount = ENCODE('".$arryDetails['GlAmnt'.$i]."','".$Config['EncryptKey']."'),  AdjID = '".$AdjID."'";
                            $this->query($strSQLQueryPayMulAcc, 0);
			//echo $strSQLQueryPayMulAcc.'<br>';
                        }
                    }
          
        }
                         


		  $strSQLQuery = "update f_adjustment SET PID='".$PID."'  where AdjID = '".$AdjID."'";
                  $this->query($strSQLQuery, 0);

                  return true;            
                              
                                    
}



	 function AdjustmentPostToGL($OrderID,$PostToGLDate){
		$strSQLQuery = "SELECT AdjID FROM f_adjustment WHERE OrderID='".mysql_real_escape_string(trim($OrderID))."' "; 
		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['AdjID'])) {
			foreach($arryRow as $values){	
				 $strSQL = "update f_payments SET PostToGL='Yes',PaymentDate='".$PostToGLDate."',PostToGLDate='".$PostToGLDate."'  where AdjID = '".$values['AdjID']."'";
                  		 $this->query($strSQL, 0);
			}
			
		}
		return true;
	} 


	 function AdjustmentPost($AdjID,$PostToGLDate){
		global $Config;
		if(!empty($AdjID)) {
			$strSQLQuery = "SELECT a.AdjID, o.OrderID, DECODE(a.Amount,'". $Config['EncryptKey']."') as AdjustmentAmount, a.ExpenseTypeID as AdjGlAccount, a.GlEntryType as AdjGlEntryType, a.Currency as AdjCurrency, o.Currency as InvoiceCurrency, o.TotalAmount, e.ExpenseID, e.GlEntryType as InvGlEntryType FROM f_adjustment a inner join p_order o on (a.OrderID=o.OrderID and o.Module='Invoice') left outer join f_expense e on o.ExpenseID=e.ExpenseID WHERE a.AdjID='".$AdjID."' "; 
			$arryRow = $this->query($strSQLQuery, 1);
			//print_r($arryRow);
			if($arryRow[0]['OrderID']>0){
				if($arryRow[0]['AdjCurrency'] != $arryRow[0]['InvoiceCurrency']){  
					$ConversionRate = CurrencyConvertor(1,$arryRow[0]['AdjCurrency'],$arryRow[0]['InvoiceCurrency'],'AP');
				}else{   
					$ConversionRate=1;
				}	
									
				$AdjustmentAmount = GetConvertedAmount($ConversionRate, $arryRow[0]['AdjustmentAmount']);  
				$FinalInvoiceAmount = $arryRow[0]['TotalAmount']+$AdjustmentAmount;
			 	

				/*****************************/				
				if($arryRow[0]['InvGlEntryType']=='Multiple'){ 
					if($arryRow[0]['AdjGlEntryType']=='Single' && $arryRow[0]['AdjGlAccount']>0){ 
						$strSQS = "update f_multi_account_payment SET Amount = ENCODE(DECODE(Amount,'".$Config['EncryptKey']."')+".$AdjustmentAmount." , '".$Config['EncryptKey']."')   where AccountID = '".$arryRow[0]['AdjGlAccount']."' and ExpenseID='".$arryRow[0]['ExpenseID']."'";
						$this->query($strSQS, 0);
					}else if($arryRow[0]['AdjGlEntryType']=='Multiple' && $arryRow[0]['AdjID']>0){ 
						$arryMultiAccount=$this->getMultiAdjustment($arryRow[0]['AdjID']);

						foreach($arryMultiAccount as $keym=>$valuesm){
							$strSQS = "update f_multi_account_payment SET Amount = ENCODE(DECODE(Amount,'".$Config['EncryptKey']."')+".$valuesm['Amount']." , '".$Config['EncryptKey']."')   where AccountID = '".$valuesm['AccountID']."' and ExpenseID='".$arryRow[0]['ExpenseID']."'";
							$this->query($strSQS, 0);
						}
					}
				}
				/*****************************/
				

				$strSQ = "update p_order SET TotalAmount='".$FinalInvoiceAmount."',AdjustmentAmount=AdjustmentAmount+".$AdjustmentAmount.", UpdatedDate  = '".$Config['TodayDate']."'  where OrderID = '".$arryRow[0]['OrderID']."'";
				$this->query($strSQ, 0);

				$strSQ = "update f_expense SET Amount = ENCODE('".$FinalInvoiceAmount."','".$Config['EncryptKey']."'), UpdatedDate  = '".$Config['TodayDate']."'  where OrderID = '".$arryRow[0]['OrderID']."'";
				$this->query($strSQ, 0);
			}
			

			$strSQL = "update f_payments SET PostToGL='Yes',PaymentDate='".$PostToGLDate."',PostToGLDate='".$PostToGLDate."'  where AdjID = '".$AdjID."'";
			$this->query($strSQL, 0);			
		}
		return true;
	} 


	 function isAdjustmentExist($InvoiceID){
		if(!empty($InvoiceID)) {
			$strSQLQuery = "SELECT AdjID FROM f_adjustment WHERE InvoiceID='".mysql_real_escape_string(trim($InvoiceID))."' limit 0,1";
			$arryRow = $this->query($strSQLQuery, 1);

			if(!empty($arryRow[0]['AdjID'])) {
				return true;
			} else {
				return false;
			}
		}
	} 

	function GetAdjustmentList($InvoiceID){
		global $Config;
		if(!empty($InvoiceID)){
			 $strSQLQuery = "SELECT a.*,DECODE(a.Amount,'". $Config['EncryptKey']."') as AdjustmentAmount, s.CompanyName,concat(ac.AccountName,' [',ac.AccountNumber,']') as PaidFromAC FROM f_adjustment a left outer join p_supplier s on a.PaidTo = s.SuppCode left outer join f_account ac on a.BankAccount = ac.BankAccountID  WHERE a.InvoiceID='".mysql_real_escape_string(trim($InvoiceID))."' order by a.PaymentDate desc,a.AdjID desc";		
			return $this->query($strSQLQuery, 1);
		}
		
	}

	function GetAdjustment($InvoiceID){
		global $Config;
		if(!empty($InvoiceID)){
			 $strSQLQuery = "SELECT a.AdjID,a.SuppCompany,a.PaidTo,a.Currency,DECODE(a.Amount,'". $Config['EncryptKey']."') as AdjustmentAmount, s.CompanyName, p.PostToGL,p.PostToGLDate FROM f_adjustment a inner join f_payments p on (a.AdjID = p.AdjID and p.InvoiceID='".$InvoiceID."' and p.PostToGL='No') left outer join p_supplier s on a.PaidTo = s.SuppCode WHERE a.InvoiceID='".mysql_real_escape_string(trim($InvoiceID))."' order by a.PaymentDate desc,a.AdjID desc";		
			return $this->query($strSQLQuery, 1);
		}
		
	}

	function GetPoInvoice($InvoiceID){
		$strSQLQuery = "SELECT * FROM p_order WHERE InvoiceID='".mysql_real_escape_string(trim($InvoiceID))."' and Module='Invoice'";		
		return $this->query($strSQLQuery, 1);
		
	}

	function  addVendorTransferInfo($arryDetails){
		global $Config;
		extract($arryDetails);
		$ipaddress = GetIPAddress();
                if($totalInvoice>0){     

			$strSQLQuery = "INSERT INTO f_fundtransfer SET  TransferType  = 'V', OrderID='".$OrderID."', TransferAmount = ENCODE('".$PaidAmount."','".$Config['EncryptKey']."'), TransferFrom = '".$TransferFrom."', TransferTo = '".$TransferTo."', ReferenceNo = '".$ReferenceNo."', GLAccount='".$GLAccount."', TransferDate = '".$Config['TodayDate']."', Comment = '".$Comment."', Currency = '".$Config['Currency']."', CreatedDate='".$Config['TodayDate']."', UpdatedDate='".$Config['TodayDate']."', IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);	
			$TransferID = $this->lastInsertId();	
			/************************/
		        for($i=1;$i<=$totalInvoice;$i++){
		          if($arryDetails['invoice_check_'.$i] == 'on' && $arryDetails['payment_amnt_'.$i] > 0){
		             		              
		                $strSQLQuery = "INSERT INTO f_fundtransfer_payment SET  TransferID = '".$TransferID."', OrderID = '".$arryDetails['OrderID_'.$i]."', SuppCode = '".$SuppCode."', PurchaseID = '".$arryDetails['PurchaseID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', PaymentAmount = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'), AccountID = '".$GLAccount."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Config['TodayDate']."', Comment = '".$Comment."', Currency = '". $Config['Currency']."', PaymentType='Purchase' ";
		                $this->query($strSQLQuery, 1);           
		              		

		          }
		        
		        }
			/************************/
                                          
                }       

	}


	function  UpdateVendorTransferInfo($arryDetails){
		global $Config;
		extract($arryDetails);

                if($totalInvoice>0 && $TransferID>0){     

			$strSQLQuery = "UPDATE f_fundtransfer SET  TransferAmount = ENCODE('".$PaidAmount."','".$Config['EncryptKey']."'),  TransferTo = '".$TransferTo."',  GLAccount='".$GLAccount."',  Comment = '".$Comment."', UpdatedDate='".$Config['TodayDate']."' where TransferID='".$TransferID."'";
			$this->query($strSQLQuery, 0);	
		
			$strSQL = "delete from f_fundtransfer_payment where TransferID='".$TransferID."'"; 
			$this->query($strSQL, 0);
				
			/************************/
		        for($i=1;$i<=$totalInvoice;$i++){
		          if($arryDetails['invoice_check_'.$i] == 'on' && $arryDetails['payment_amnt_'.$i] > 0){
		             		              
		                $strSQLQuery = "INSERT INTO f_fundtransfer_payment SET  TransferID = '".$TransferID."', OrderID = '".$arryDetails['OrderID_'.$i]."', SuppCode = '".$SuppCode."', PurchaseID = '".$arryDetails['PurchaseID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', PaymentAmount = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'), AccountID = '".$GLAccount."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Config['TodayDate']."', Comment = '".$Comment."', Currency = '". $Config['Currency']."', PaymentType='Purchase' ";
		                $this->query($strSQLQuery, 1);           
		              		

		          }
		        
		        }
			/************************/
                                          
                }       

	}

	function GetTransferTransactionID($TransferOrderID){		
		if(!empty($TransferOrderID)){			 
			$strSQLQuery = "SELECT TransactionID FROM f_transaction  WHERE  TransferOrderID='".$TransferOrderID."'";		
			$arryRow = $this->query($strSQLQuery, 1);
			if(!empty($arryRow[0]["TransactionID"]))return $arryRow[0]["TransactionID"];
		}
		
	}

	function GetTransferTransactionIDRef($ReferenceNo){		
		if(!empty($ReferenceNo)){			 
			$strSQLQuery = "SELECT TransactionID FROM f_transaction  WHERE  ReferenceNo='".$ReferenceNo."'";		
			$arryRow = $this->query($strSQLQuery, 1);
			if(!empty($arryRow[0]["TransactionID"])) return $arryRow[0]["TransactionID"];
		}
		
	}

	function GetVendorTransfer($TransferID,$OrderID,$ReferenceNo){
		global $Config;
		if(!empty($TransferID) || !empty($OrderID) || !empty($ReferenceNo)){
			$strAddQuery .= (!empty($TransferID))?(" and f.TransferID='".$TransferID."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and f.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($ReferenceNo))?(" and f.ReferenceNo='".$ReferenceNo."'"):("");
			$strSQLQuery = "SELECT f.*, DECODE(TransferAmount,'". $Config['EncryptKey']."') as  TransferAmount FROM f_fundtransfer f WHERE 1 ".$strAddQuery;		
			return $this->query($strSQLQuery, 1);
		}
		
	}

	function GetFundTransferDetail($TransferID,$InvoiceID,$PaymentType){
		global $Config;
		if(!empty($TransferID)){ 
			$strAddQuery .= (!empty($TransferID))?(" and ft.TransferID='".$TransferID."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and ft.InvoiceID='".$InvoiceID."'"):("");
			$strAddQuery .= (!empty($PaymentType))?(" and ft.PaymentType='".$PaymentType."'"):("");
			$strSQLQuery = "SELECT ft.*, DECODE(PaymentAmount,'". $Config['EncryptKey']."') as  PaymentAmount FROM f_fundtransfer_payment ft WHERE 1 ".$strAddQuery;		
			return $this->query($strSQLQuery, 1);
		}
		
	}


	function RemoveBlankTransfer(){
		$strSQL= "select TransferID from f_fundtransfer where OrderID='0' and CreatedDate<'".date('Y-m-d')."'"; 
		$arryTr = $this->query($strSQL, 1);
		foreach($arryTr as $key=>$values){
			$strSQLQuery = "delete from f_fundtransfer where TransferID='".$values['TransferID']."'"; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from f_fundtransfer_payment where TransferID='".$values['TransferID']."'"; 
			$this->query($strSQLQuery, 0);						
		}
		
	}


	function updateOrderIDforTransfer($OrderID,$ReferenceNo){
		$strSQLQuery = "UPDATE f_fundtransfer SET  OrderID = '".$OrderID."' where ReferenceNo='".$ReferenceNo."'";
		$this->query($strSQLQuery, 0);	
			
		
	}

	function updateOrderIDforTransaction($OrderID,$ReferenceNo){
		$strSQLQuery = "UPDATE f_transaction SET  TransferOrderID = '".$OrderID."' where ReferenceNo='".$ReferenceNo."'";
		$this->query($strSQLQuery, 0);	
			
		
	}	

	function TransferFundPost($OrderID,$AccountPayable){
		global $Config;
		$ipaddress = GetIPAddress();
		if($OrderID>0){ 
			$strSQLstr= "select * from f_fundtransfer where OrderID='".$OrderID."'"; 
			$arryRow = $this->query($strSQLstr, 1);
			if(!empty($arryRow[0]['TransferID'])) {
				$strSQL= "select t.*,DECODE(t.PaymentAmount,'". $Config['EncryptKey']."') as payment_amnt, o.InvoiceEntry,o.TotalAmount from f_fundtransfer_payment t left outer join p_order o on t.OrderID=o.OrderID where t.TransferID='".$arryRow[0]['TransferID']."'"; 
				$arryTr = $this->query($strSQL, 1);


				foreach($arryTr as $key=>$values){
					$strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$values['InvoiceID']."', OrderID='".$values['OrderID']."', Amount = '".$values['PaymentAmount']."', TotalAmount = '".$values['PaymentAmount']."', BankAccount = '".$arryRow[0]['GLAccount']."', PaidTo = '".$arryRow[0]['TransferTo']."', ReferenceNo = '".$arryRow[0]['ReferenceNo']."', PaymentDate = '".$arryRow[0]['TransferDate']."', Comment = '".$arryRow[0]['Comment']."', Currency = '".$arryRow[0]['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$AccountPayable."',CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);	
                                $ExpenseID = $this->lastInsertId();	
                               
                               $strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$values['OrderID']."', SuppCode = '".$arryRow[0]['TransferTo']."', PurchaseID = '".$values['PurchaseID']."', InvoiceID='".$values['InvoiceID']."', CreditAmnt = '".$values['PaymentAmount']."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$arryRow[0]['GLAccount']."', ReferenceNo = '".$arryRow[0]['ReferenceNo']."', PaymentDate = '".$arryRow[0]['TransferDate']."', Comment = '".$arryRow[0]['Comment']."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $arryRow[0]['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                

                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', DebitAmnt = '".$values['PaymentAmount']."', CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ExpenseID = '".$ExpenseID."', SuppCode = '".$arryRow[0]['TransferTo']."', ReferenceNo = '".$arryRow[0]['ReferenceNo']."', Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$arryRow[0]['TransferDate']."', Comment = '".$arryRow[0]['Comment']."', Currency = '". $arryRow[0]['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."'";
                                $this->query($strSQLQueryPay, 0);
                                
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);	


				/***********Update Order Status********/
				$paidAmnt = $this->GetPurchaseTotalPaymentAmntForInvoice($values['InvoiceID']);
				if($_POST['InvoiceEntry'] == 1){
				   $paidOrderAmnt = $values['payment_amnt'];
				   $TotalOrderedAmount  = $values['TotalAmount'];				   
				}else{				    
				     $paidOrderAmnt = $this->GetPurchaseTotalPaymentAmntForOrder($values['PurchaseID']);		     $TotalOrderedAmount  = $values['TotalAmount'];
				}
				$InvoiceAmount  = $values['TotalAmount'];	
				$Chk=0;
				if(intval($paidAmnt) >= intval($InvoiceAmount)){
					$Chk = 2;
				}else if(intval($paidAmnt) > 0){
					$Chk = 1;
				}

				$this->updatePurchaseInvoiceStatus($values['InvoiceID'],$Chk);

				if(intval($paidOrderAmnt) >= intval($TotalOrderedAmount) && intval($TotalOrderedAmount) > 0){					$this->updateOrderStatus($values['PurchaseID']);
				}




				/**************************************/


				}
			}
		}
		
		return true;
	}

	 function isVendorCheckNumberExists($CheckNumber,$TransactionID)
	{
		$strSQLQuery = "SELECT PaymentID FROM f_payments WHERE CheckNumber='".mysql_real_escape_string(trim($CheckNumber))."' and PaymentType='Purchase' and Voided='0' and PID='0'";
		$strSQLQuery .= (!empty($TransactionID))?(" and TransactionID != '".$TransactionID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['PaymentID'])) {
			return true;
		} else {
			return false;
		}
	} 

	 function TransactionByCheckNumber($CheckNumber,$PaymentType){
		$strSQLQuery = "SELECT TransactionID, SuppCode FROM f_transaction WHERE CheckNumber='".mysql_real_escape_string(trim($CheckNumber))."' and PaymentType='".$PaymentType."' order by TransactionID desc limit 0,1";		

		return $this->query($strSQLQuery, 1);
	} 


	 function GetMaxCheckNumber($AccountID,$PaymentType){
		$strSQLQuery = "SELECT CheckNumber as OrigCheckNumber, CAST(CheckNumber AS UNSIGNED) as MaxCheckNumber FROM f_payments WHERE AccountID='".mysql_real_escape_string(trim($AccountID))."' and PaymentType='Purchase' order by MaxCheckNumber desc limit 0,1";		

		return $this->query($strSQLQuery, 1);
	} 


	 function GetNextCheckNumber($NextCheckNumber){			
		if($this->isVendorCheckNumberExists($NextCheckNumber,'')){			
			$NextCheckNumber = $NextCheckNumber + 1;
			return $this->GetNextCheckNumber($NextCheckNumber); 		
		}else{ 
			return $NextCheckNumber;
		}		 
	} 

/**********Bhoodev*******************/
 
function  GetVendorCode($SuppID){
        $strAddQuery = " where 1 ";
        
        $strAddQuery .= ($SuppID>0)?(" and SuppID='".$SuppID."'"):("");
        $strSQLQuery = "select SuppCode,SuppType  from p_supplier ".$strAddQuery;
        return $this->query($strSQLQuery, 1);
    }
 
//add by bhoodev for Ar payment
  function getCustName($CustID)
                            {
                                $strSQLQuery = "Select c.Cid as custID,IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,c.CustomerType from  s_customers c where c.Cid ='".mysql_real_escape_string($CustID)."' and c.Status = 'Yes' having CustomerName!='' ORDER BY CustomerName ASC";
            $arryRow = $this->query($strSQLQuery, 1);
            $CustomerName = $arryRow[0]['CustomerName'];    
            return $CustomerName;
                            }
                     //end  
function  addPoPaymentFromAr($arryDetails)
{
	global $Config;

	extract($arryDetails);
	$ipaddress = GetIPAddress();

	if($Method == "Check"){
		$CheckBankName = $CheckBankName;
		$CheckFormat = $CheckFormat;
	}else{
		$CheckBankName = '';
		$CheckFormat = '';
	}

	/********************/
	if($totalInvoiceVendor>0 && $SuppCode!='' && $ReceivedAmount>0){
		  $addsql = "  SET SuppCode = '".$SuppCode."', TotalAmount = ENCODE('".$ReceivedAmount."','".$Config['EncryptKey']."'),  AccountID = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',  EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."' ";

		if($ContraTransactionID>0){
			$TransactionID = $ContraTransactionID;
			$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";

			$this->query($sql, 1);
		}else{
		 	$sql = "INSERT INTO f_transaction ".$addsql." ,  ContraID = '".$ContraID."', CreatedDate='". $Config['TodayDate']."' ";
			$this->query($sql, 1);
			$TransactionID = $this->lastInsertId();
		}

	}
	/********************/

                      
        for($i=1;$i<=$totalInvoiceVendor;$i++){
          if($arryDetails['Vendor_invoice_check_'.$i] == 'on' && $arryDetails['payment_vendor_amnt_'.$i] > 0){
                              
                               
                                $strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$arryDetails['VendorInvoiceID_'.$i]."', OrderID='".$arryDetails['VendorOrderID_'.$i]."', Amount = ENCODE('".$arryDetails['payment_vendor_amnt_'.$i]."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$arryDetails['payment_vendor_amnt_'.$i]."','".$Config['EncryptKey']."'), BankAccount = '".$PaidTo."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceCoNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '".$Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$AccountPayable."',CreatedDate='".$Config['TodayDate']."', Flag ='1', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);    
                                $ExpenseID = $this->lastInsertId();    
                              
                                $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$TransactionID."', ConversionRate = '".$arryDetails['VendorConversionRate_'.$i]."', OrderID = '".$arryDetails['VendorOrderID_'.$i]."', SuppCode = '".$SuppCode."', PurchaseID = '".$arryDetails['PurchaseID_'.$i]."', InvoiceID='".$arryDetails['VendorInvoiceID_'.$i]."', CreditAmnt = ENCODE('".$arryDetails['payment_vendor_amnt_'.$i]."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceCoNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                
                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', DebitAmnt = ENCODE('".$arryDetails['payment_vendor_amnt_'.$i]."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ApContraAccount."', ExpenseID = '".$ExpenseID."', SuppCode = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceCoNo)."', Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQueryPay, 0);
                                
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);    
                          }
                        
                        }
                        
                        
                       
        }

function  addArPaymentInfo($arryDetails)
        {
            global $Config;
            extract($arryDetails);
            $ipaddress = GetIPAddress();
                         if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }
                            
			/********************/
			if($ArtotalInvoice>0 && $CustomerName!='' && $PaidAmount>0){ 	
				$addsql = " SET CustID = '".$CustomerName."', CustCode = '".$CustCode."', TotalAmount = ENCODE('".$PaidAmount."','".$Config['EncryptKey']."'),  AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', CheckNumber='".$CheckNumber."',  EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."' ";
				if($ContraTransactionID>0){
					$TransactionID = $ContraTransactionID;
					$sql = "UPDATE f_transaction ".$addsql." where TransactionID='".$TransactionID."'";
					$this->query($sql, 1);
				}else{
				 	$sql = "INSERT INTO f_transaction ".$addsql." ,  ContraID = '".$ContraID."', CreatedDate='". $Config['TodayDate']."' ";
					$this->query($sql, 1);
					$TransactionID = $this->lastInsertId();
				}


			}
			/********************/




                        for($i=1;$i<=$ArtotalInvoice;$i++){
                            if($arryDetails['Arinvoice_check_'.$i] == 'on' && $arryDetails['Arpayment_amnt_'.$i] > 0){
                                
                                 $strSQLQuery = "INSERT INTO f_income SET  InvoiceID='".$arryDetails['ArInvoiceID_'.$i]."', Amount = ENCODE('" .$arryDetails['Arpayment_amnt_'.$i]. "','".$Config['EncryptKey']."'), TotalAmount = ENCODE('" .$arryDetails['Arpayment_amnt_'.$i]. "','".$Config['EncryptKey']."'), BankAccount = '".$PaidFrom."', ReceivedFrom = '".$CustomerName."', ReferenceNo = '".addslashes($ReferenceTFNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$AccountReceivable."',CreatedDate='".$Config['TodayDate']."', Flag ='1',IPAddress='".$ipaddress."'"; 
                                $this->query($strSQLQuery, 0);    
                                $incomeID = $this->lastInsertId();
                                 $strSQLQuery = "INSERT INTO f_payments SET  TransactionID='".$TransactionID."', ConversionRate = '".$arryDetails['ArConversionRate_'.$i]."', OrderID = '".$arryDetails['ArOrderID_'.$i]."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', SaleID = '".$arryDetails['SaleID_'.$i]."', InvoiceID='".$arryDetails['ArInvoiceID_'.$i]."', DebitAmnt = ENCODE('" .$arryDetails['Arpayment_amnt_'.$i]. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."',  ReferenceNo = '".addslashes($ReferenceTFNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."', CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 

                                 $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  CreditAmnt = ENCODE('" .$arryDetails['Arpayment_amnt_'.$i]. "','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ArContraAccount."', IncomeID = '".$incomeID."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceTFNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag ='1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
                                $this->query($strSQLQuery, 0);
                                $strSQLQuery = "update f_income SET PID='".$PID."' where IncomeID = '".$incomeID."'";
                                $this->query($strSQLQuery, 0);
                            }
                        
                        
                        }
                        
                         
        }
/**********Bhoodev*******************/



 /*function by start sachin */
                        function  GetPaidPaymentInvoiceforSendPayments($id)
			{
                                global $Config;
				extract($arryDetails);

				

				$strAddQuery = " where 1 ";
                                $strAddQuery .=(!empty($id))?(" and PaymentID = '".$id."'"):("");
				
				#$strSQLQuery = "select p.PaymentID,p.PostToGL,p.PaymentType,p.ExpenseID, p.PaymentDate, p.OrderID,p.InvoiceID, p.PurchaseID,p.SuppCode,p.CreditAmnt, p.ReferenceNo,p.PaymentType,p.Currency,o.InvoiceEntry,o.InvoicePaid,o.SuppCompany from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
                                $strSQLQuery = "select p.*,s.Email,o.SuppCompany as Suppvendor from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID left outer join p_supplier s  on s.SuppCode = p.SuppCode".$strAddQuery;
			//echo "=>".$strSQLQuery;
                                //echo $strSQLQuery;die;
				return $this->query($strSQLQuery, 1);		

			}
                        
                        function  GetCaseRecipetReceivePaymentInvoice($id)
				{
					global $Config;
                                       extract($arryDetails);

					
					
					$strAddQuery = " where 1 ";
					$strAddQuery .=(!empty($id))?(" and PaymentID = '".$id."'"):("");
					
                                        $strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, o.InvoicePaid,o.CustomerName,o.InvoiceEntry,c.Email,o.CreatedBy from f_payments p left outer join s_order o on p.OrderID = o.OrderID left outer join s_customers c on o.CustCode=c.CustCode ".$strAddQuery;
                                        //echo $strSQLQuery;die;

					return $this->query($strSQLQuery, 1);		

				}
                        /* function end by sachin */



	 	function getDebitCreditForPNL($FromDate,$ToDate){
			global $Config;
		 	 $strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments p inner join f_account f on p.AccountID = f.BankAccountID WHERE  p.PostToGL = 'Yes' and f.RangeFrom IN(4000,5000,6000,7000,8000)"; 			

			#$strSQLQuery = "SELECT f.BankAccountID,f.AccountName from f_payments p inner join f_account f on p.AccountID = f.BankAccountID WHERE  p.PostToGL = 'Yes' and f.RangeFrom IN(4000,5000,7000)"; 

			 if(!empty($FromDate) && !empty($ToDate)){
			 	$strSQLQuery .= " and p.PaymentDate between '".$FromDate."' and '".$ToDate."' ";                                       
			}else if(!empty($ToDate)){
				$strSQLQuery .= " and p.PaymentDate<'".$ToDate."' ";                               
			}
			//echo $strSQLQuery.'<br>';
                        return $this->query($strSQLQuery, 1);

                }

		function getDebitCreditForPNLAmount($FromDate,$ToDate){
			global $Config;
		 		
			 $this->SetCashOnlySql();
						 
		 	 $strSQLQuery = "SELECT f.BankAccountID,f.AccountNumber,f.RangeFrom, f.AccountName, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments p inner join f_account f on p.AccountID = f.BankAccountID ".$Config["CashOnlyJoin"]." WHERE  p.PostToGL = 'Yes' and f.Status = 'Yes' and f.RangeFrom IN(4000,5000,6000,7000,8000) ".$Config["CashOnlyWhere"];

			

			if(!empty($FromDate) && !empty($ToDate)){
			 	$strSQLQuery .= " and p.PaymentDate between '".$FromDate."' and '".$ToDate."' ";                                       
			}else if(!empty($ToDate)){
				$strSQLQuery .= " and p.PaymentDate<'".$ToDate."' ";                               
			}
			 $strSQLQuery .= "  group by f.BankAccountID  order by f.RangeFrom,AccountNumber asc "; 
			
			$arryRow = $this->query($strSQLQuery, 1);
			 
			 

			$IncomeAmount = 0 ;
			$ExpenseAmount = 0;
			$CostOfGood = 0;	
			foreach($arryRow as $key => $values) {
				$BeginningBalance = 0 ;
				$Config['CreditMinusDebit'] = 0;
				if($values["RangeFrom"]=='2000' || $values["RangeFrom"]=='3000' || $values["RangeFrom"]=='4000' || $values["RangeFrom"]=='7000'){
					$Config['CreditMinusDebit'] = 1;
				}
				if(!empty($FromDate) && $values["RangeFrom"]<4000){					
					$BeginningBalance=$this->getBeginningBalance($values['BankAccountID'],$FromDate); //pk	
				}

				if($values["RangeFrom"] == '6000' || $values["RangeFrom"] == '8000') {//expense
					$NetAmt = $values["DbAmnt"] - $values["CrAmnt"];
					 
					$ExpenseAmount += round($NetAmt,2) + round($BeginningBalance,2);
				}else{
					if($Config['CreditMinusDebit']==1){
						$NetAmt = $values["CrAmnt"] - $values["DbAmnt"];
					}else{
						$NetAmt = $values["DbAmnt"] - $values["CrAmnt"];
					}
					if($values["RangeFrom"] == '5000'){
						$CostOfGood += round($NetAmt,2) + round($BeginningBalance,2);
					}else{
						$IncomeAmount += round($NetAmt,2) + round($BeginningBalance,2);
					}
				}
				
				
				#echo $values["AccountName"].'#'.$NetAmt.'<br><br>'; 
				 
			}
			
			 
			$GrossProfit = $IncomeAmount - $CostOfGood;
			//echo $ExpenseAmount;exit;
			$PnLAmount = $GrossProfit - $ExpenseAmount;
                        return $PnLAmount;

                }

	/**********************************/
		
	function addInvoiceGL($arryDetails){
		extract($arryDetails);
		
		global $Config;
		$ipaddress = GetIPAddress(); 
               
		if($Config['CronEntry']==1){ //cron entry
                        $EntryType = 'one_time';
                        $InvoiceID = '';	
                      
                        $PaymentDate = $Config['TodayDate'];
                        $MultiPaymentData = $Config['arryGLAccountData'];

			if(!empty($ReceivedFrom)){ 
                		$arryCustomer = $this->getCustomer($ReceivedFrom,'','');
			} 
			$Currency = $CustomerCurrency;
			$Amount = $TotalAmount;
                }else{
			$TotalAmount = $Amount;

			$CreatedBy  = addslashes($_SESSION['UserName']);
		        $AdminID  = $_SESSION['AdminID'];
		        $AdminType  = $_SESSION['AdminType'];
		        $LocationID = $_SESSION['locationID']; 

			 if(!empty($CustCodeGL)){ 
                		$arryCustomer = $this->getCustomer('',$CustCodeGL,'');
			} 
		}
  		
                        
                if(empty($Currency))$Currency = $Config['Currency'];
                
                
		  if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
		if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
		if($EntryInterval == 'yearly'){$EntryWeekly = '';}
		if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
		if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
                 
                              
                if(!empty($InvoiceEntry)){$InvoiceEntry = $InvoiceEntry;}else{$InvoiceEntry = 2;}
                                      
                           
                $strSQLQuerySO = "insert into s_order set Module='Invoice',
                SaleID = '".addslashes($ReferenceNo)."',
                InvoiceID  = '".$InvoiceID."',
                Approved  = '1',
                Comment  = '".addslashes(strip_tags($Comment))."',
		CustID  = '".addslashes($arryCustomer[0]['Cid'])."',
                CustCode  = '".addslashes($arryCustomer[0]['CustCode'])."',
                CustomerName = '".addslashes($arryCustomer[0]['CustomerName'])."',
                SpiffContact  = '".addslashes($arryCustomer[0]['SpiffContact'])."',   
                Address  = '".addslashes($arryCustomer[0]['Address'])."',   
                City  = '".addslashes($arryCustomer[0]['City'])."',
                State  = '".addslashes($arryCustomer[0]['State'])."',
                Country  = '".addslashes($arryCustomer[0]['Country'])."',
                ZipCode  = '".addslashes($arryCustomer[0]['ZipCode'])."',                 
                CustomerCurrency  = '".addslashes($Currency)."',
	        ConversionRate  = '".addslashes($ConversionRate)."',
                Mobile  = '".addslashes($arryCustomer[0]['Mobile'])."',
                Landline  = '".addslashes($arryCustomer[0]['Landline'])."',                
                Fax  = '".addslashes($arryCustomer[0]['Fax'])."',
                Email  = '".addslashes($arryCustomer[0]['Email'])."',                 
                TotalAmount  = '".addslashes($TotalAmount)."',
		TotalInvoiceAmount  = '".addslashes($TotalAmount)."',             
                CreatedBy  = '".$CreatedBy."',
                AdminID  = '".$AdminID."', 
                AdminType  = '".$AdminType."',
                PostedDate  = '".$PaymentDate."',
		  CreatedDate  = '".$Config['TodayDate']."',
                UpdatedDate  = '".$Config['TodayDate']."',
                InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
                PaymentMethod  = '".addslashes($PaymentMethod)."',
                ShippingMethod  = '".addslashes($ShippingMethod)."', 
                PaymentTerm  = '".addslashes($PaymentTerm)."',
                InvoiceDate   = '".addslashes($PaymentDate)."',         
              
                InvoiceEntry='".$InvoiceEntry."',EntryType='".$EntryType."',
                EntryInterval='".$EntryInterval."',
                EntryMonth='".$EntryMonth."',   
                EntryWeekly = '".$EntryWeekly."',      
                EntryFrom='".$EntryFrom."',
                EntryTo='".$EntryTo."',
                EntryDate='".$EntryDate."',
		IPAddress='".$ipaddress."'
		";
   		
		$this->query($strSQLQuerySO, 0);
		$OrderID = $this->lastInsertId(); 
                                                              
		$strSQLQuery = "INSERT INTO f_income SET  InvoiceID  = '".$InvoiceID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), BankAccount = '".$BankAccount."', ReceivedFrom = '".$arryCustomer[0]['Cid']."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', IncomeTypeID='".$IncomeTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."',GlEntryType='".$GlEntryType."' ";		

		$this->query($strSQLQuery, 0);	
		$IncomeID = $this->lastInsertId();	 
         
		/*********Add Payment Transaction**********/
                   if($GlEntryType == "Multiple"){      
			 if($Config['CronEntry']==1){                                       
		               foreach($MultiPaymentData as $value){                                         
		                     $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account SET  AccountID='".$value['AccountID']."', AccountName = '".$value['AccountName']."', Notes = '".$value['Notes']."', Amount = ENCODE('".$value['Amount']."','".$Config['EncryptKey']."'),  IncomeID = '".$IncomeID."'";
		                    $this->query($strSQLQueryPayMulAcc, 0);
		                   
		               }         
		            
		           }else{

				    for($i=1;$i<=$NumLine1;$i++){
				        if( $arryDetails['invoice_check_'.$i] ==1 && ($arryDetails['GlAmnt'.$i] > 0 || $arryDetails['GlAmnt'.$i] < 0) && !empty($arryDetails['AccountID'.$i])){                      

				          $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account SET  AccountID='".$arryDetails['AccountID'.$i]."', AccountName = '".$arryDetails['AccountName'.$i]."', Notes = '".$arryDetails['Notes'.$i]."', Amount = ENCODE('".$arryDetails['GlAmnt'.$i]."','".$Config['EncryptKey']."'),  IncomeID = '".$IncomeID."'";
				            $this->query($strSQLQueryPayMulAcc, 0);
			
				        }
				    }

			}
                                    
                 }          
                             
                $strSQLQuery = "update f_income SET InvoiceID='".$InvoiceID."' where IncomeID = '".$IncomeID."'";
                $this->query($strSQLQuery, 0);
              
                $strSQLUp = "update s_order set IncomeID ='".$IncomeID."' where OrderID='".$OrderID."'"; 
		$this->query($strSQLUp, 0);
              
		$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('s_order','Invoice',$OrderID,$InvoiceID); 


		/*******************/
		if(empty($InvoiceID)){
			$sqlInvc = "select InvoiceID from s_order where OrderID='".$OrderID."'";
			$arrInvc = $this->query($sqlInvc, 1);
			$InvoiceID = $arrInvc[0]['InvoiceID'];

			$strSQLQuery = "update f_income SET InvoiceID='".$InvoiceID."' where IncomeID = '".$IncomeID."'";
			$this->query($strSQLQuery, 0);
                }


                return $OrderID;    
	}
		
		
	function updateInvoiceGL($arryDetails){
		extract($arryDetails);

		global $Config;
		$ipaddress = GetIPAddress(); 
		$strSQLQuery = "SELECT * from s_order WHERE OrderID ='".$OrderID."'";
		$arryRow = $this->query($strSQLQuery, 1);
		$IncomeID = $arryRow[0]['IncomeID'];

		if($IncomeID>0){  
                                 
			$TotalAmount = $Amount;                       
		
			if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
			if($EntryInterval == 'yearly'){$EntryWeekly = '';}
			if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
			if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
	 	  	if(!empty($CustCodeGL)){ 
        			$arryCustomer = $this->getCustomer('',$CustCodeGL,'');
			}  
			if(empty($Currency))$Currency = $Config['Currency'];                           
                                 
			$strSQLQuery = "update s_order set 
			SaleID = '".addslashes($ReferenceNo)."',			
			Comment  = '".addslashes(strip_tags($Comment))."',
			CustID  = '".addslashes($arryCustomer[0]['Cid'])."',
			CustCode  = '".addslashes($arryCustomer[0]['CustCode'])."',
			CustomerName = '".addslashes($arryCustomer[0]['CustomerName'])."',
			SpiffContact  = '".addslashes($arryCustomer[0]['SpiffContact'])."',   
			Address  = '".addslashes($arryCustomer[0]['Address'])."',   
			City  = '".addslashes($arryCustomer[0]['City'])."',
			State  = '".addslashes($arryCustomer[0]['State'])."',
			Country  = '".addslashes($arryCustomer[0]['Country'])."',
			ZipCode  = '".addslashes($arryCustomer[0]['ZipCode'])."',                 
			CustomerCurrency  = '".addslashes($Currency)."',
			ConversionRate  = '".addslashes($ConversionRate)."',
			Mobile  = '".addslashes($arryCustomer[0]['Mobile'])."',
			Landline  = '".addslashes($arryCustomer[0]['Landline'])."',
			Fax  = '".addslashes($arryCustomer[0]['Fax'])."',
			Email  = '".addslashes($arryCustomer[0]['Email'])."',
			TotalAmount  = '".addslashes($TotalAmount)."',
			TotalInvoiceAmount  = '".addslashes($TotalAmount)."',
			UpdatedDate  = '".$Config['TodayDate']."',
			InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
			PaymentMethod  = '".addslashes($PaymentMethod)."',
			ShippingMethod  = '".addslashes($ShippingMethod)."', 
			PaymentTerm  = '".addslashes($PaymentTerm)."',
			InvoiceDate   = '".addslashes($PaymentDate)."', 
			EntryType='".$EntryType."',
			EntryInterval='".$EntryInterval."',
			EntryMonth='".$EntryMonth."',   
			EntryWeekly = '".$EntryWeekly."',      
			EntryFrom='".$EntryFrom."',
			EntryTo='".$EntryTo."',
			EntryDate='".$EntryDate."'
			where OrderID='".$OrderID."' "; 

			$this->query($strSQLQuery, 0);     	
                    	
			$strSQLQuery = "update f_income SET  InvoiceID  = '".$InvoiceID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), BankAccount = '".$BankAccount."', ReceivedFrom = '".$arryCustomer[0]['Cid']."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', GlEntryType='".$GlEntryType."' , IncomeTypeID='".$IncomeTypeID."' where IncomeID='".$IncomeID."'";                                                               
			$this->query($strSQLQuery, 0);	
					                                
			$strSQL = "delete from f_multi_account where IncomeID='".$IncomeID."'"; 
			$this->query($strSQL, 0);
                             
                                if($GlEntryType == "Multiple"){                                  
						
                                            for($i=1;$i<=$NumLine1;$i++){
                                                if( $arryDetails['invoice_check_'.$i] ==1 && ($arryDetails['GlAmnt'.$i] > 0 || $arryDetails['GlAmnt'.$i] < 0) && !empty($arryDetails['AccountID'.$i])){                                                 

                                                   $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account SET  AccountID='".$arryDetails['AccountID'.$i]."', AccountName = '".$arryDetails['AccountName'.$i]."', Notes = '".$arryDetails['Notes'.$i]."', Amount = ENCODE('".$arryDetails['GlAmnt'.$i]."','".$Config['EncryptKey']."'),  IncomeID = '".$IncomeID."'";
                                                    $this->query($strSQLQueryPayMulAcc, 0);
						
                                                }
                                            }
                                    
                                    
                                }
                                                         
                               
			}

			 
			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('s_order','InvoiceID',$OrderID,$SoInvoiceIDGL); 

			return true;
		}
		


				
		function getOtherIncomeGL($arryDetails){ 
				extract($arryDetails);
                    		global $Config;
                             
				$strAddQuery = " where 1 ";
				$SearchKey   = strtolower(trim($key));				 
				$strAddQuery .= ($IncomeID>0)?(" and f.IncomeID = '".$IncomeID."'"):("");
              			$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				 
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by f.IncomeID Desc ");

				$strSQLQuery = "select f.*,DECODE(f.Amount ,'". $Config['EncryptKey']."') as Amount,DECODE(f.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount,b.AccountName,b.AccountNumber  from f_income f left outer join f_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
				//echo $strSQLQuery;
				return $this->query($strSQLQuery, 1);
			}


		 function getMultiAccountgl($IncomeID)
                {   
                       global $Config;
                        $strSQLQuery = "SELECT f.*,DECODE(f.Amount,'". $Config['EncryptKey']."') as Amount,a.AccountName,a.AccountNumber from f_multi_account f left outer join f_account a on f.AccountID=a.BankAccountID where f.IncomeID = '".trim($IncomeID)."'";
                     
		       $arryRow = $this->query($strSQLQuery, 1);
                    return $arryRow;
                }
		/*********************************/
		function updateGLAR5555()
                {   
                       global $Config;
                        $strSQLQuery = "SELECT p2.TransactionID as MainTransactionID, t.AccountID as BankAccount, p1.* FROM `f_payments` p1 inner join `f_payments` p2 on p2.PaymentID=p1.PID inner join f_transaction t on p2.TransactionID=t.TransactionID WHERE p1.PID>'0' and p1.`AccountID` = '3' and p1.PaymentType='Sales' and t.AccountID>'0' and p2.TransactionID>'0' and p1.ReferenceNo='6080-00' order by p1.PaymentID  ";
                    // echo $strSQLQuery;exit;
		      // $arryRow = $this->query($strSQLQuery, 1);
			foreach($arryRow as $key=>$values){
				$sql = "update f_payments set AccountID='".$values['BankAccount']."' where PaymentID='".$values['PaymentID']."'";
				//$this->query($sql, 1);
				//echo $sql.'<br>';
			}

			exit;
                    

			return $arryRow;
                }


	function  ListCashReceipt($arryDetails){
		global $Config;
		extract($arryDetails);

		$strAddQuery = "  ";
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= (!empty($FromDate))?(" and t.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and t.PaymentDate<='".$ToDate."'"):("");

		if($sortby != ''){
			if($sortby=='t.TotalAmount' && !empty($SearchKey)){
				$AmountArry = explode(".",$SearchKey);
				if($AmountArry[1]<=0) $SearchKey = $AmountArry[0];
				$strAddQuery .= " and ( DECODE(t.TotalAmount,'". $Config['EncryptKey']."') like '".$SearchKey."%' )";
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}
		}else{
			$strAddQuery .= "";
			$strAddQuery .= (!empty($SearchKey))?(" and (t.ReceiptID like '%".$SearchKey."%' or t.CheckNumber like '%".$SearchKey."%' or  DECODE(t.TotalAmount,'". $Config['EncryptKey']."') like '".$SearchKey."%' ) " ):("");
		}


		if(!empty($fby)){ //search
			$DateColumn = "t.PaymentDate";
			if($fby=='Year'){
				$strAddQuery .= " and YEAR(".$DateColumn.")='".$y."'";
			}else if($fby=='Month'){
				$strAddQuery .= " and MONTH(".$DateColumn.")='".$m."' and YEAR(".$DateColumn.")='".$y."'";
			}else{
				$strAddQuery .= (!empty($f))?(" and ".$DateColumn.">='".$f."'"):("");
				$strAddQuery .= (!empty($t))?(" and ".$DateColumn."<='".$t."'"):("");
			}
		}

		$strAddQuery .= (!empty($TransactionID))?(" and t.TransactionID='".$TransactionID."'"):("");			
		$strAddQuery .= (!empty($PostToGL))?(" and t.PostToGL='".$PostToGL."'"):("");
		$strAddQuery .= (!empty($CustID))?(" and d.CustID='".$CustID."'"):("");	
		$strAddQuery .= (!empty($AccountID))?(" and t.AccountID='".$AccountID."'"):("");	
		$strAddQuery .= (!empty($InvoiceGL))?(" and (d.InvoiceID like '%".$InvoiceGL."%' or d.CreditID like '%".$InvoiceGL."%' or b.AccountNumber like '%".$InvoiceGL."%') "):("");
		$strAddQuery .= " and t.TransferOrderID='0' ";

		if($Config['GetNumRecords']==1){
			$Columns = " count(distinct(t.TransactionID)) as NumCount ";					
		}else{		
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" ORDER BY t.PostToGL desc, t.PaymentDate desc,t.TransactionID desc ");

			if($Config['RecordsPerPage']>0){			 
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
			$Columns = " distinct(t.TransactionID), t.OrderPaid, t.ReferenceNo, t.Fee, t.ReceiptID,t.StatusMsg,t.Method, t.PaymentDate, t.PostToGLDate, t.AdminID, t.AdminType, t.PaymentType, t.AccountID, t.Voided, t.PostToGL, DECODE(t.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, DECODE(t.OriginalAmount,'". $Config['EncryptKey']."') as OriginalAmount,t.ModuleCurrency, if(t.AdminType='employee',e.UserName,'Administrator') as PostedBy, t.AccountID, concat(ac.AccountName,' [',ac.AccountNumber,']') as PaidToAccount  ";
		}

		  $strSQLQuery = "select ".$Columns." from f_transaction t inner join f_transaction_data d on (t.TransactionID=d.TransactionID) left outer join f_account ac on (t.AccountID = ac.BankAccountID and ac.BankFlag = '1')  left outer join f_payments p on t.TransactionID=p.TransactionID  left outer join h_employee e on (t.AdminID=e.EmpID and t.AdminType='employee') left outer join f_account b on b.BankAccountID = d.AccountID where t.PaymentType = 'Sales' and CASE WHEN t.Voided=0 THEN p.TransactionID>0 ELSE 1 END = 1 ".$strAddQuery;    
              
               
          	return $this->query($strSQLQuery, 1);		

	} 

	function  ListVendorPayment($arryDetails){
		global $Config;
		extract($arryDetails);

		$strAddQuery = "  ";
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= (!empty($FromDate))?(" and t.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and t.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($Method))?(" and t.Method='".$Method."'"):("");
		$strAddQuery .= (!empty($BatchID))?(" and t.BatchID='".$BatchID."'"):(""); 

		if($sortby != ''){
			if($sortby=='t.TotalAmount' && !empty($SearchKey)){
				$AmountArry = explode(".",$SearchKey);
				if($AmountArry[1]<=0) $SearchKey = $AmountArry[0];
				 
				$strAddQuery .= " and ( DECODE(t.TotalAmount,'". $Config['EncryptKey']."') like '".$SearchKey."%' )";
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}
		}else{
			$strAddQuery .= "";
			$strAddQuery .= (!empty($SearchKey))?(" and (t.ReceiptID like '%".$SearchKey."%' or t.CheckNumber like '%".$SearchKey."%' or DECODE(t.TotalAmount,'". $Config['EncryptKey']."') like '".$SearchKey."%' ) " ):("");
		}



		if(!empty($fby)){ //search
			$DateColumn = "t.PaymentDate";
			if($fby=='Year'){
				$strAddQuery .= " and YEAR(".$DateColumn.")='".$y."'";
			}else if($fby=='Month'){
				$strAddQuery .= " and MONTH(".$DateColumn.")='".$m."' and YEAR(".$DateColumn.")='".$y."'";
			}else{
				$strAddQuery .= (!empty($f))?(" and ".$DateColumn.">='".$f."'"):("");
				$strAddQuery .= (!empty($t))?(" and ".$DateColumn."<='".$t."'"):("");
			}
		}

		$strAddQuery .= (!empty($TransactionID))?(" and t.TransactionID='".$TransactionID."'"):("");			
		$strAddQuery .= (!empty($PostToGL))?(" and t.PostToGL='".$PostToGL."'"):("");
		$strAddQuery .= (!empty($SuppCode))?(" and d.SuppCode='".$SuppCode."'"):("");	
		$strAddQuery .= (!empty($AccountID))?(" and t.AccountID='".$AccountID."'"):("");	
		$strAddQuery .= (!empty($InvoiceGL))?(" and (d.InvoiceID like '%".$InvoiceGL."%' or d.CreditID like '%".$InvoiceGL."%' or b.AccountNumber like '%".$InvoiceGL."%' ) "):("");
		

		#$strAddQuery .= " and CASE WHEN t.TransferOrderID>0 THEN t.PostToGL='Yes' ELSE 1 END = 1 ";
		$strAddQuery .= " and t.TransferOrderID=0 and TransferSuppCode='' ";


		if($Config['GetNumRecords']==1){
			$Columns = " count(distinct(t.TransactionID)) as NumCount ";					
		}else{	
			$strAddQuery .= " Group by t.TransactionID ";
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" ORDER BY t.PostToGL desc, t.PaymentDate desc,t.TransactionID desc ");

			if($Config['RecordsPerPage']>0){			 
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
			$Columns = " t.TransactionID, t.ReceiptID, t.ReferenceNo, t.Method, t.CheckFormat,t.CheckBankName, t.CheckNumber,t.BatchID,t.AccountID, t.PaymentDate, t.PostToGLDate, t.AdminID, t.AdminType, t.PaymentType, t.PostToGL, t.Voided, DECODE(t.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount,  DECODE(t.OriginalAmount,'". $Config['EncryptKey']."') as OriginalAmount, t.ModuleCurrency, if(t.AdminType='employee',e.UserName,'Administrator') as PostedBy, concat(ac.AccountName,' [',ac.AccountNumber,']') as PaymentAccount    ";
		}

		 $strSQLQuery = "select ".$Columns." from f_transaction t inner join f_transaction_data d on (t.TransactionID=d.TransactionID) left outer join f_account ac on (t.AccountID = ac.BankAccountID and ac.BankFlag = '1' and t.AccountID>'0')   left outer join f_payments p on (t.TransactionID=p.TransactionID and p.TransactionID>'0')  left outer join h_employee e on (t.AdminID>'0' and t.AdminID=e.EmpID and t.AdminType='employee') left outer join f_account b on (b.BankAccountID = d.AccountID and d.AccountID>'0') where t.PaymentType = 'Purchase' and CASE WHEN t.Voided=0 THEN p.TransactionID>0 ELSE 1 END = 1   ".$strAddQuery;   
              

              if(!empty($_GET['pk'])){ echo  $strSQLQuery.'<br><br>';  }
          	return $this->query($strSQLQuery, 1);		

	} 

   function isPaymentDataExist($AccountID){
	$sql = "select count(p.PaymentID) as NumRecord from f_payments p inner join f_account a on p.AccountID=a.BankAccountID where p.AccountID='".$AccountID."' limit 0,1";      
	$arryRow = $this->query($sql, 1);
	if($arryRow[0]['NumRecord']>0) return true;
	else return false;
    }
	

	/*     * ********** Comment Section Added By Sanjiv********** */
    
    function AddMasterComment($arrydetail) {
    	global $Config;
    
    	extract($arrydetail);
    
    	$commented_by = ($_SESSION['AdminType'] =='admin') ? 'admin' : 'employee';
    	$user_id = $_SESSION['AdminID'];
    	
    	$type = (!empty($type)) ? $type : 'premade';
    	
    	if(!empty($MasterCommentID))
    	{
    		$strSQLQuery = "update s_master_comments set module_type = '" . addslashes($module_type) . "' , comment = '" . addslashes($comment) . "' , view_type = '" . addslashes($view_type) . "' , comment_date = '" . $Config['TodayDate'] . "' where MasterCommentID = '" . $MasterCommentID . "'";
    
    		$this->query($strSQLQuery, 0);
    		return '1';
    
    	}else{
    		$strSQLQuery = "insert into s_master_comments (module_type,commented_by,user_id,comment,comment_date,view_type,type ) values( '" .$module_type. "', '" .$commented_by. "', '" .$user_id. "', '" . addslashes($comment) . "', '" . $Config['TodayDate'] . "', '" .$view_type. "', '".$type."' )";
    
    		$this->query($strSQLQuery, 0);
    
    		$cmtID = $this->lastInsertId();
    		return $cmtID;
    	}
    }
    
    function getMasterComment($user_id, $MasterCommentID , $in=false) {
    
    	$strAddQuery = "where type='premade'";
    	//if($_SESSION['AdminType']!='admin' && empty($MasterCommentID)) $strAddQuery .= " and user_id = '".$user_id."' ";
    	if(!empty($MasterCommentID) && !empty($in)) $strAddQuery .= " and MasterCommentID IN ($MasterCommentID) ";
    	else if(!empty($MasterCommentID)) $strAddQuery .= " and MasterCommentID = '".$MasterCommentID."' ";
    
    	$strSQLQuery = "select s.*,e.UserName from s_master_comments s left outer join h_employee e  on e.EmpID=s.user_id  " . $strAddQuery;
    	return $this->query($strSQLQuery, 1);
    	
    }
    
    function getMasterCommentList($user_id, $module_type) {
    	
    	$commented_by = ($_SESSION['AdminType'] =='admin') ? 'admin' : 'employee';
    	//echo $strSQLQuery = "SELECT * FROM `s_master_comments` where (module_type='".$module_type."' or module_type='both') and (user_id='".$user_id."' or user_id IN (select user_id from s_master_comments where view_type='public' )) and type='premade' ";
    	$strSQLQuery = "(SELECT * FROM `s_master_comments` where (module_type='".$module_type."' or module_type='both') and user_id='".$user_id."' and type='premade' and commented_by='".$commented_by."' order by comment_date desc)
						UNION
						(select * from s_master_comments where view_type='public' and (module_type='".$module_type."' or module_type='both') and type='premade' order by comment_date desc)";
    	return $this->query($strSQLQuery, 1);
    	 
    }
    
    function deleteMasterComment($commentID) {
    
    	$strSQLQuery = "delete from s_master_comments where MasterCommentID='" . $commentID . "'";
    	$this->query($strSQLQuery, 0);
    
    	return 1;
    }
    
    
    function AddComment($arrydetail) {
    	global $Config;
    
    	extract($arrydetail);
    
    	$user_id = $_SESSION['AdminID'];
    	
    	$strSQLQuery = "insert into s_comments (order_id,user_id,master_comment_id,view_type,comment_date) values( '" .$order_id. "', '" .$user_id. "', '" .$master_comment_id. "', '" .$view_type . "', '" . $Config['TodayDate'] . "' )";    
        $this->query($strSQLQuery, 0);
    
        $cmtID = $this->lastInsertId();
    	return $cmtID;
    }
    
    function getComment($CommentID , $in=false) {
    	$strAddQuery = "where 1";
    	if($in) {
    		if(empty($CommentID)) return ;
    		$strAddQuery .= " and s.CommentID IN ($CommentID) ";
    	}
    
    	$strSQLQuery = "select s.*,m.comment, m.MasterCommentID, m.type from s_comments s inner join s_master_comments m  on m.MasterCommentID=s.master_comment_id  " . $strAddQuery;
	//if($_GET['pp']==1) echo $strSQLQuery;
    	return $this->query($strSQLQuery, 1);
    	 
    }
    
     function DeleteComment($CommentID,$MasterCommentID){	
    	
    	if(empty($MasterCommentID)){
    		$sql1 = "select master_comment_id from s_comments where CommentID='".$CommentID."' ";
    		$mstID = $this->query($sql1,1);
    		$MasterCommentID = $mstID[0]['master_comment_id'];
    	}
    	
    	$sql = "delete from s_comments where CommentID='".$CommentID."' ";
    	$this->query($sql,0);
    	
	if(!empty($MasterCommentID)){
	    	$sql = "delete from s_master_comments where MasterCommentID='".$MasterCommentID."' and type='custom' ";
	    	$this->query($sql,0);
	}
    }
    
    function updateSalesOrderComment($Comments, $OrderID){
    	$sql = "update s_order set Comment='".$Comments."' where OrderID='".$OrderID."' ";
    	$this->query($sql,0);
    }
    
    function updatePurchasesOrderComment($Comments, $OrderID){
    	$sql = "update p_order set Comment='".$Comments."' where OrderID='".$OrderID."' ";
    	$this->query($sql,0);
    }

	function changeCommentStatus($MasterCommentID){
    	$sql="select * from s_master_comments where MasterCommentID='".$MasterCommentID."'";
    	$rs = $this->query($sql,1);
    	if(sizeof($rs))
    	{
    		if($rs[0]['status']==1)
    			$Status=0;
    			else
    				$Status=1;
    
    				$sql="update s_master_comments set status='$Status' where MasterCommentID='".$MasterCommentID."'";
    				$this->query($sql,0);
    				return true;
    	} 
    }
    
   function CopyingComments($commentData){ 
    	$multiComment = $cmtID = '';
    	foreach ($commentData as $values){
    		$data['order_id'] = $values['order_id']; 
    		$data['user_id'] = $values['user_id'];
    		$data['view_type'] = $values['view_type'];
    		if($values['type'] == 'custom'){ 
	    	$sql = "insert into s_master_comments (module_type, commented_by, user_id, comment, comment_date, view_type, status, type) select module_type, commented_by, user_id, comment, comment_date, view_type, status, type from s_master_comments where MasterCommentID ='".$values['MasterCommentID']."' "; 
	    		$this->query($sql,0);
	    		
	    		$data['master_comment_id'] = $this->lastInsertId();
	    		
	    		$cmtID = $this->AddComment($data);
    		}else if($values['type'] == 'premade'){
    			$data['master_comment_id'] = $values['master_comment_id'];
    			$cmtID = $this->AddComment($data);
    		}
				if(!empty($cmtID))
    		$multiComment .= "##".$cmtID;
    	}
    	return $multiComment;
    }

		 function updateSalesInvoiceComment($Comments, $OrderID){
    	$sql = "update s_order set InvoiceComment='".$Comments."' where OrderID='".$OrderID."' ";
    	$this->query($sql);
    }
    
    function updatePurchasesInvoiceComment($Comments, $OrderID){
    	$sql = "update p_order set InvoiceComment='".$Comments."' where OrderID='".$OrderID."' ";
    	$this->query($sql);
    }

		function viewComments($cmt){
    	$cmtData = '';
    	$arrComments = explode("##",$cmt);
    	if(empty($arrComments[1]) && !empty($arrComments[0])){
    		$cmtData = stripslashes($cmt);
    	}else{
    		if(!empty($arrComments)){
    			$cmtIDS = array_filter($arrComments);
    			$cmtIDS = implode(',', $cmtIDS);
    			$CommentData = $this->getComment($cmtIDS, true);
			if(!empty($CommentData)){
    				foreach ($CommentData as $cmt){
    					$cmtData .= stripslashes($cmt['comment']).' ';
    				}
			}
    		}
    	}
    	
    	return $cmtData;
    }


    /*     * ********** End of Comment Section ********** */

	function GetTransactionDataAmount($TransactionID, $CustID, $SuppCode) {    
		if($TransactionID>0){	
			$strAddQuery = (!empty($CustID))?(" and CustID='".$CustID."'"):("");	
			$strAddQuery .= (!empty($SuppCode))?(" and SuppCode='".$SuppCode."'"):("");	

	    		$strSQLQuery = "select sum(Amount) as AmountTotal, sum(OriginalAmount) as OriginalAmountTotal from f_transaction_data where TransactionID='".$TransactionID."' " . $strAddQuery;
	    		return $this->query($strSQLQuery, 1);
		}    	 
    	}


	 function getChartSubGroupAccountExport($ParentGroupID,$num,$FromDate,$ToDate,$RangeFrom='')
                {	
			global $Config;
                    
                 
			  $query = "SELECT * FROM f_group WHERE ParentGroupID ='".$ParentGroupID."'";
                          
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $htmlAccount1='';
                                 $num=$num+9;
                                 $Balance =0;
				$AccountTypeID='';
                            while($values = mysql_fetch_array($result)) { 
				if(!empty($values['AccountTypeID']))$AccountTypeID = $values['AccountTypeID'];
				$AccountwithGroup=$this->getBankAccountWithGroupID($values['GroupID'],$RangeFrom);
				$padd = $num+20;
                                $htmlAccount = '<tr align="left">
                                 <td height="10" style="padding-left:'.$padd.'px">';
				//$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= ucfirst($values['GroupName']).' [Group]';

                                $htmlAccount .= '</td>';                             
				
				$htmlAccount .= '<td></td></tr>';                          
                     		  
                                
                                $htmlAccount1='';
				 $Balance=0;
                                foreach($AccountwithGroup as $AccountNamee)
                                {
					$ReceivedAmnt = $AccountNamee['ReceivedAmnt'];
					$PaidAmnt = $AccountNamee['PaidAmnt'];


					if($AccountTypeID==2 || $AccountTypeID==3 || $AccountTypeID==4 || $AccountTypeID==7){
						$Balance = $PaidAmnt-$ReceivedAmnt;
					}else{
						$Balance = $ReceivedAmnt-$PaidAmnt;
					}
					 
                                  



                                    $spacenum=$num+2;
                                    
                            	    $padd = $num+30;
            
                                $htmlAccount1 .= '<tr align="left">
                                <td height="10" style="padding-left:'.$padd.'px">';
				 
				$htmlAccount1 .= ucfirst($AccountNamee['AccountName']);
                               

				if($AccountNamee['BankFlag'] == 1){
					$htmlAccount1 .= '<br>[ Bank Acc No: '.$AccountNamee['BankAccountNumber'].' ]';
				}

                                $htmlAccount1 .= '</td>';
                                $htmlAccount1 .= '<td align="left" >'.$AccountNamee['AccountNumber'].' </td>';
                                 

				
				$NettBalanceVal = number_format($Balance,2);
				


                                $htmlAccount1 .= '<td align="right" >'.$NettBalanceVal.'</td>';

				 $htmlAccount1 .= '<td align="center" >';

				if ($AccountNamee['Status'] == 'Yes') {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}
				
				 $htmlAccount1 .= $status;

				$htmlAccount1 .= ' </td></tr>';
                        
                                }
                                 
                                $Config['ExportContent'] .= $htmlAccount;
				$Config['ExportContent'] .= $htmlAccount1;
                              
                                  
                                  if($values['GroupID'] > 0)
                                  {
                                    $this->getChartSubGroupAccountExport($values['GroupID'],$num,$FromDate,$ToDate,$RangeFrom); 
                                  }
                                }  
                 
                }


	 /****************Recurring Function Satrt************************************/  
       function RecurringGLInvoiceAR(){       
          global $Config;
	  $Config['CronEntry']=1;
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);

	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));

	/**************/
	$TodayDate = $arryDate[0];
	$Year = $arryDay[0];	
	$YearMonth = $arryDay[0].'-'.$arryDay[1];
	/**************/

	  $strSQLQuery = "select o.*,e.IncomeID,e.IncomeTypeID,e.BankAccount,e.Amount,e.TaxID,e.TaxRate,e.LocationID,e.ReceivedFrom,e.ReferenceNo,e.Comment,e.Flag,e.GlEntryType
              from s_order o left outer join f_income e on (o.IncomeID=e.IncomeID) where o.InvoiceEntry in(2,3) and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."'  and CASE WHEN o.EntryTo>0 THEN  o.EntryTo>='".$arryDate[0]."' ELSE 1 END = 1  ";
          $arryInvoice = $this->query($strSQLQuery, 1);
                  
       
         //pr($arryInvoice);   exit;
	
	  foreach($arryInvoice as $value){

		/**************/
		$ModuleDate = $value['InvoiceDate'];		
		$arryDt = explode("-", $ModuleDate);
		$YearOrder = $arryDt[0]; 
		$YearMonthOrder = $arryDt[0].'-'.$arryDt[1];
		/**************/
		


		$OrderFlag=0;
               if($ModuleDate!=$TodayDate){ 
		switch($value['EntryInterval']){
			case 'biweekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($value['EntryDate']==$Day && $YearMonthOrder!=$YearMonth){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month && $YearOrder!=$Year){
					$OrderFlag=1;
				}
				break;		
		
		  }
		
		}

		//echo $value['InvoiceID'].'<br>'.$OrderFlag;exit;

		if($OrderFlag==1){			
                      // echo $value['IncomeID'];exit;
                        if($value['IncomeID'] > 0){
                            $arryGLAccountData = $this->getMultiAccountgl($value['IncomeID']);
                         }
                        
			 //pr($arryGLAccountData);   exit;

                         $Config['arryGLAccountData']=$arryGLAccountData;
                        
                        
                        
			if($value['OrderID'] > 0){		
                            
                           
				$order_id = $this->addInvoiceGL($value);
                                
				$strSQL = "update s_order set LastRecurringEntry ='" . $Config['TodayDate'] . "' where OrderID='" . $value['OrderID'] . "'";
				$this->query($strSQL, 0);
				 
		
			}


		}


	  }
       	  return true;
   }


	function GetDebitCreditTrail($BankAccountID,$RangeFrom,$FromDate,$ToDate){
		global $Config;
		

		$account_data=$this->getTotalDebitCreditAmount($BankAccountID,'',$FromDate,$ToDate);

		$Config['CreditMinusDebit']=0;
		if($RangeFrom=='2000' || $RangeFrom=='3000' || $RangeFrom=='4000' || $RangeFrom=='7000'){
			$Config['CreditMinusDebit']=1;
		} 
		
		/*if($RangeFrom<4000){
			$BeginningBalance=$this->getBeginningBalance($BankAccountID,$FromDate);
		}*/
		$NettBalance=0;
		$BeginningBalance=0;

		/*******************/
		$Config['BegBalForCurrentYear']=0;
		if($RangeFrom>3000){ //P&L
			$Config['BegBalForCurrentYear'] = 1;
		}
		$BeginningBalance=$this->getBeginningBalance($BankAccountID,$FromDate);		
		$Config['BegBalForCurrentYear']=0;
		/*******************/
		if($Config['TransactionType']=="B"){
			$NettBalance = round($BeginningBalance,2);
			$account_data[0]['CrAmnt']=0;
			$account_data[0]['DbAmnt']=0;
		}else if($Config['TransactionType']=="A"){
			$NettBalance=0;
			$BeginningBalance=0; 
		}else{
			$NettBalance = round($BeginningBalance,2);
		}
		/*******************/

		if($Config['CreditMinusDebit']==1){
			$NettBalance+=round(($account_data[0]['CrAmnt']-$account_data[0]['DbAmnt']),2);
			$arrayDC['DebitAmtVal'] = 0;
			$arrayDC['CreditAmtVal'] = $NettBalance;
		}else{
			$NettBalance+=round(($account_data[0]['DbAmnt']-$account_data[0]['CrAmnt']),2);
			$arrayDC['DebitAmtVal'] = $NettBalance;
			$arrayDC['CreditAmtVal'] = 0;
		}
		if($NettBalance<0){
			$NettBalanceVal = str_replace("-","",$NettBalance);	 
			$NettBalanceVal = "(".number_format($NettBalanceVal, 2).")";	 	
		}else{
			$NettBalanceVal = number_format($NettBalance, 2);
		}

		if($Config['CreditMinusDebit']==1){
			$arrayDC['DebitAmt'] = '0.00';
			$arrayDC['CreditAmt'] = $NettBalanceVal;
		}else{
			$arrayDC['DebitAmt'] = $NettBalanceVal;
			$arrayDC['CreditAmt'] = '0.00';
		}
		
		return $arrayDC;
	}
   

	function SetCashOnlySql(){
		global $Config;
		$Config["CashOnlyJoin"]=$Config["CashOnlyWhere"]='';

		if(!empty($_GET['InvStatus'])){
			$Config["CashOnlyWhere"] = " and p.PaymentType in('Sales','Purchase')";



			/*
			$Config["CashOnlyJoin"] = " left outer join s_order so on (p.ReferenceNo=so.InvoiceID and so.Module='Invoice' and so.InvoiceID!='' and so.PostToGl='1') 

	left outer join s_order sc on (p.ReferenceNo=sc.CreditID and sc.Module='Credit' and sc.CreditID!='' and sc.PostToGl='1') 

	left outer join p_order po on (p.ReferenceNo=po.InvoiceID and po.Module='Invoice' and po.InvoiceID!='' and po.PostToGl='1') 

	left outer join p_order pc on (p.ReferenceNo=pc.CreditID and pc.Module='Credit' and pc.CreditID!='' and pc.PostToGl='1')  ";	

			$Config["CashOnlyWhere"] = " and ( 
			p.PaymentType in('Sales','Purchase')
				OR 
			(p.PaymentType in ('Customer Invoice','Customer Invoice Entry') and so.InvoicePaid='Paid')
				OR 
			(p.PaymentType in ('Vendor Invoice','Vendor Invoice Entry') and po.InvoicePaid='1')
				OR 
			(p.PaymentType in ('Customer Credit Memo') and sc.Status='Completed')
				OR 
			(p.PaymentType in ('Vendor Credit Memo') and pc.Status='Completed')
			)";*/

			
		}

	}


	function isAccountTransactionExist($AccountID){		
		$strSQLQuery = "select AccountID from f_payments where AccountID = '".$AccountID."' limit 0,1";	 
		$arryRow = $this->query($strSQLQuery, 1);
		 
		if(!empty($arryRow[0]['AccountID'])) {
			return true;
		} 
	}


	 
	function VoidVendorTransfer($OrderID){
		if(!empty($OrderID)){
			$strSQLQuery = "SELECT * FROM f_transaction  WHERE  TransferOrderID='".$OrderID."'";		
			$arryRow = $this->query($strSQLQuery, 1);
			
			if(!empty($arryRow[0]['ReferenceNo'])){
				 $strSQLQuery1 = "UPDATE f_payments SET  PostToGL = 'No', PostToGLDate='' where ReferenceNo='".$arryRow[0]['ReferenceNo']."' and PaymentType='Purchase' ";
				$this->query($strSQLQuery1, 0);
			}

			if(!empty($arryRow[0]['TransactionID'])){
				 $strSQLQuery2 = "UPDATE f_transaction SET  PostToGL = 'No', PostToGLDate='' where TransactionID='".$arryRow[0]['TransactionID']."'  ";
				$this->query($strSQLQuery2, 0);
			}			
			
			if(!empty($arryRow[0]['TransferOrderID'])){
				$strSQLQuery3 = "UPDATE p_order SET  PostToGL = '0', PostToGLDate='' where OrderID='".$arryRow[0]['TransferOrderID']."' ";
				 $this->query($strSQLQuery3, 0);
			}
		}
		
	}

	/*****Balance for Part Paid, Not Needed********/
	function  GetCreditMemoPayment($OrderID, $CreditID)
	{                                   
		global $Config;
		if(!empty($OrderID) && !empty($CreditID)){	
			$strSQLQuery = "SELECT o.OrderID, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) AS receivedAmntCr, (SELECT SUM(tr.OriginalAmount) FROM f_transaction_data tr WHERE tr.CreditID = o.CreditID and tr.Module='AR' and tr.PaymentType='Credit' and tr.Voided='0' and tr.CreditID!='') AS receivedAmntTr FROM s_order o  left outer join f_payments p  on (o.CreditID = p.CreditID and o.CreditID!='' and p.CreditID = '".$CreditID."' and p.PaymentType='Sales') where o.OrderID='".$OrderID."' ";
			return $this->query($strSQLQuery, 1);		
		}
			
	}


	function  GetPoCreditMemoPayment($OrderID, $CreditID)
	{                                   
		global $Config;
		if(!empty($OrderID) && !empty($CreditID)){	
			$strSQLQuery = "SELECT o.OrderID, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) AS receivedAmntCr, (SELECT SUM(tr.OriginalAmount) FROM f_transaction_data tr WHERE tr.CreditID = o.CreditID and tr.Module='AP' and tr.PaymentType='Credit' and tr.Voided='0' and tr.CreditID!='') AS receivedAmntTr FROM p_order o  left outer join f_payments p  on (o.CreditID = p.CreditID and o.CreditID!='' and p.CreditID = '".$CreditID."' and p.PaymentType='Purchase') where o.OrderID='".$OrderID."' ";
			return $this->query($strSQLQuery, 1);		
		}
			
	}
	/*************/
	 

}
?>
