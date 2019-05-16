<?
class report extends dbClass
{
		//constructor
		function report()
		{
			$this->dbClass();
		} 
		
		
       

	 function getAccountTypeForProfitLossReport()
                {
        			
		    $strAddQuery .= " AccountTypeID  IN (13,15,17)"; 
                    $strSQLQuery = "select t.AccountType,t.AccountTypeID from f_accounttype t WHERE  ".$strAddQuery." Order By t.OrderBy";
		    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
                
                
                
	 function getAccountTypeForBalanceSheetReport()
                {
        			
		    $strAddQuery .= "  AccountTypeID  IN (16,12,8,11,9,19,14,6,7,5)"; 
                    $strSQLQuery = "select t.AccountType,t.AccountTypeID from f_accounttype t WHERE  ".$strAddQuery." Order By t.OrderBy";
		    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
               
                
		
                
                function  GetSubAccountTreeForReport($ParentID,$num,$arryDetails)
		     {
		           global $Config;
			 
		          
                 
			  $query = "SELECT * FROM f_account WHERE ParentAccountID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $num=$num+20;
                            while($values = mysql_fetch_array($result)) { 
				/*$ReceivedAmnt = $values['ReceivedAmnt'];
				$PaidAmnt = $values['PaidAmnt'];
				$Balance = $ReceivedAmnt-$PaidAmnt;*/
                                
                                $Balance = $this->getAccountBalance($values['BankAccountID'],$values['AccountType'],$arryDetails);
                                
                                //echo "=>".$Balance;
                                
                                $htmlAccount = '<tr align="left" bgcolor="#ffffff">
                                 <td width="250" height="20">&nbsp;&nbsp;&nbsp;';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= $values['AccountName'];

			 $htmlAccount .= '</td>';
                          $htmlAccount .= '<td width="200">---------------------------------------------------------------------------</td>';
                         $htmlAccount .= '<td align="right" width="50"><strong>'.number_format($Balance,2,'.','').'</strong></td>
                        </tr>';
                                  
                                  echo $htmlAccount;
                                  
                                  
                                  if($values['ParentAccountID'] > 0)
                                  {
                                    $this->GetSubAccountTreeForReport($values['BankAccountID'],$num,$arryDetails); 
                                  }
                                }  
             
		}


                
               function getTotalAmount($accountType,$arryDetails){
                   
                    global $Config;
                   extract($arryDetails);
                    
                    if($TransactionDate == "All")
                    {
                        $FromDate = '2014-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($TransactionDate == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($TransactionDate == "Last Three Month")
                    {
                       $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else{
                        
                       if(!empty($FromDate)){
                            
                            $FromDate = $FromDate;
                            $ToDate = $ToDate;
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                    
                    $strAddQuery .= (!empty($FromDate))?(" and f.AccountType = '".$accountType."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= " and p.PostToGL ='Yes'";
                     
                    $strSQLQuery = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.Status = 'Yes' ".$strAddQuery."";
                                     
                   //echo "=>".$strSQLQuery;
                    $arryRows = $this->query($strSQLQuery, 1);

                    $ReceivedAmnt = $arryRows[0]['ReceivedAmnt'];
                    $PaidAmnt = $arryRows[0]['PaidAmnt'];
                    
                    if($arryRows[0]['BankAccountID'] == 7 || $arryRows[0]['BankAccountID'] == 2){

                     $Balance = $PaidAmnt-$ReceivedAmnt;
                    }else{

                     $Balance = $ReceivedAmnt-$PaidAmnt;
                    }
                    
                   
                   return $Balance;
                   
               } 
               
            function getAccountBalanceForReport($accountid,$arryDetails)
            {
                global $Config;
                extract($arryDetails);
                
                if($TransactionDate == "All")
                    {
                        $FromDate = '2014-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($TransactionDate == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($TransactionDate == "Last Three Month")
                    {
                        $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else{
                        
                        if(!empty($FromDate)){
                            
                            $FromDate = $FromDate;
                            $ToDate = $ToDate;
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                    
                    $strAddQuery .= (!empty($FromDate))?(" WHERE f.BankAccountID = '".$accountid."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    $strAddQuery .= " and p.PostToGL ='Yes'";
                    
                    $strSQLQuery = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName from f_account f left outer join f_payments p on p.AccountID = f.BankAccountID
                         ".$strAddQuery."";
                    //echo "=>". $strSQLQuery;
                     $arryRows = $this->query($strSQLQuery, 1);

                    $ReceivedAmnt = $arryRows[0]['ReceivedAmnt'];
                    $PaidAmnt = $arryRows[0]['PaidAmnt'];
                    
                    if($accountid == 7 || $accountid == 2){

                     $Balance = $PaidAmnt-$ReceivedAmnt;
                    }else{

                    $Balance = $ReceivedAmnt-$PaidAmnt;
                    }
                    
                   
                   
                   return $Balance;
                    
            }
            
            function sendPLReport($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."email_pl_report.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				
				$contents = str_replace("[Message]",$Message,$contents);
				

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$SubjectEmail;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			

			return 1;
		}

             function sendBLReport($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."email_bl_report.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				
				$contents = str_replace("[Message]",$Message,$contents);
				

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$SubjectEmail;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			

			return 1;
		}
                
                
          /*********************CODE FOR DASHBOARD********************************************************************/
                
                function getIncomeBankAccount($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
                        global $Config;
                                $strAddQuery = "where f.AccountTYpe = '".$id."'";

                                            $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by f.OrderBy ");
                                            $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" ASC");

						   
							

                 $strSQLQuery = "select f.*,(select SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID) as ReceivedAmnt,(select SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID) as PaidAmnt from f_account f ".$strAddQuery;
		 //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
                
                function  GetIncomeExpByYear($FromDate,$ToDate)
		{
                    
                    global $Config;
                    $strAddQuery .= (!empty($FromDate))?(" and f.AccountType = '15'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    
                    $strSQLQuery = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.Status = 'Yes' ".$strAddQuery."";
                                     
                  // echo "=>".$strSQLQuery;exit;
                    $arryRows = $this->query($strSQLQuery, 1);

                    $ReceivedAmnt = $arryRows[0]['ReceivedAmnt'];
                    $PaidAmnt = $arryRows[0]['PaidAmnt'];
                    
                    $Balance['totalIncome'] = $ReceivedAmnt-$PaidAmnt;
                 
                    
                    
                    /*************************CODE FOR EXPENSES********/
                    
                    $strAddQuery1 .= (!empty($FromDate))?(" and f.AccountType = '13'"):("");
                    $strAddQuery1 .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery1 .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    
                    $strSQLQuery1 = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.Status = 'Yes' ".$strAddQuery1."";
                                     
                  // echo "=>".$strSQLQuery;exit;
                    $arryRows1 = $this->query($strSQLQuery1, 1);

                    $ReceivedAmnt1 = $arryRows1[0]['ReceivedAmnt'];
                    $PaidAmnt1 = $arryRows1[0]['PaidAmnt'];
                    
                    $Balance['totalExpense'] = $ReceivedAmnt1-$PaidAmnt1;
              
                    
                    
                    /*************************CODE FOR COST FOR GOOD SOLD********/
                    
                    $strAddQuery2 .= (!empty($FromDate))?(" and f.AccountType = '17'"):("");
                    $strAddQuery2 .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery2 .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    
                    $strSQLQuery1 = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_account f left outer join f_accounttype t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.Status = 'Yes' ".$strAddQuery2."";
                                     
                  // echo "=>".$strSQLQuery;exit;
                    $arryRows1 = $this->query($strSQLQuery1, 1);

                    $ReceivedAmnt2 = $arryRows1[0]['ReceivedAmnt'];
                    $PaidAmnt2 = $arryRows1[0]['PaidAmnt'];
                    
                    $Balance['totalCostOfGoodSold'] = $ReceivedAmnt2-$PaidAmnt2;
                
                    
                   /*echo "<pre>";
                   print_r($Balance);exit;*/
                   return $Balance;

			
		}
                
          /*********************END DASHBOARD CODE*********************************************************/      


function getAccountBalance($accountid,$AccountType,$arrDetails)
	{
                        global $Config;
                        extract($arrDetails);
                       
                    if($TransactionDate == "All")
                    {
                        $FromDate = '2014-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($TransactionDate == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($TransactionDate == "Last Three Month")
                    {
                        $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else{
                        
                        if(!empty($FromDate)){
                            
                            $FromDate = $FromDate;
                            $ToDate = $ToDate;
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                    
                  
                   
                        
			$strSQLQuery = "SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt,SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments WHERE AccountID ='".mysql_real_escape_string($accountid)."' AND PaymentDate>='".$FromDate."' AND PaymentDate<='".$ToDate."' AND PostToGL = 'Yes'";
                       // echo "=>".$strSQLQuery;
			$rows = $this->query($strSQLQuery, 1);
			$DbAmnt = $rows[0]['DbAmnt'];
			$CrAmnt = $rows[0]['CrAmnt'];
				
			
                        $Balance = 0;
                        if($AccountType == 19 || $AccountType == 14){

                         $Balance = floatval($CrAmnt)-floatval($DbAmnt);
                        }else{

                         $Balance = floatval($DbAmnt)-floatval($CrAmnt);
                        }
                        
                        
                        
			return $Balance; 	
	}
        
        
        function  SalesTaxReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{
                        global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");

			$strSQLQuery = "select o.OrderDate, o.PostedDate,o.InvoiceDate,o.InvoicePaid, o.OrderID, o.SaleID,o.CustID, o.CustCode, o.CustomerName, o.SalesPerson, o.InvoiceID,o.taxAmnt,  o.CustomerCurrency, o.ConversionRate,o.TotalAmount,o.TotalInvoiceAmount from s_order o  where o.module='Invoice' and o.taxAmnt > '0' and o.ReturnID='' ".$strAddQuery." order by o.InvoiceDate desc";
				//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
                function getCustomerTaxAmount($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{
			 global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");
			
			$strSQLQuery = "select SUM(taxAmnt) as totalTaxAmnt from s_order as o WHERE o.module='Invoice' and o.taxAmnt > '0' and o.ReturnID='' ".$strAddQuery;
			//echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalTaxAmnt'];	
		
		}
                
                function  PurchaseTaxReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$SuppCode,$Status)
		{
                         global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.PostedDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.PostedDate)='".$Month."' and YEAR(o.PostedDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			if($Status == 1){
			 $strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");
                        }
                        if($Status == 2){
                            $strAddQuery .= (!empty($Status))?(" and o.InvoicePaid=''"):("");
                        }

			$strSQLQuery = "select o.OrderDate, o.PostedDate,o.InvoicePaid,o.OrderID,o.PurchaseID,o.SuppCode,o.ConversionRate, o.Currency,  o.SuppCompany,o.InvoiceID,o.taxAmnt, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  from p_order o  left outer join p_supplier s on  o.SuppCode =  s.SuppCode where o.module='Invoice' and o.taxAmnt > '0' and o.ReturnID='' ".$strAddQuery." order by o.PostedDate desc";
			//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
                function getPurchaseTaxAmount($FilterBy,$FromDate,$ToDate,$Month,$Year,$SuppCode,$Status)
		{
			 global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.PostedDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.PostedDate)='".$Month."' and YEAR(o.PostedDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
                        if($Status == 1){
			$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");
                        }
                        if($Status == 2){
                            $strAddQuery .= (!empty($Status))?(" and o.InvoicePaid=''"):("");
                        }
			
			$strSQLQuery = "select SUM(taxAmnt) as totalTaxAmnt from p_order as o WHERE o.module='Invoice' and o.taxAmnt > '0' and o.ReturnID='' ".$strAddQuery;
			//echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalTaxAmnt'];	
		
		}
                
                function  arAgingReort($CustCode)
		{
                         global $Config;
			$strAddQuery = "";
			
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			
			$strSQLQuery = "select o.InvoicePaid, o.CustID, o.CustCode, o.CustomerName, o.InvoiceID,sum(o.TotalInvoiceAmount) as TotalInvoiceAmount ,(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.InvoiceID !='' and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt 
                            from s_order o  where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.CustID order by o.InvoiceDate desc";
			//echo "=>".$strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}
                

 		function  arAgingReportList($CustCode,$currencyArray)
		{
                         global $Config;
			$strAddQuery = "";
			if(!empty($CustCode)){
				$strAddQuery = " and o.CustCode='".$CustCode."'";
				$innerSql = " and p.CustCode='".$CustCode."'";
				$Asc = 'Desc';
			}else{
				$strAddQuery = '';
				$Asc = 'ASC';
				$innerSql = '';
			}

			$strAddQuery .= (!empty($_GET['From']))?(" and o.InvoiceDate>='".$_GET['From']."'"):("");
			$strAddQuery .= (!empty($_GET['To']))?(" and o.InvoiceDate<='".$_GET['To']."'"):("");
			$strAddQuery .= (!empty($_GET['os']))?(" and o.OrderSource='".$_GET['os']."'"):("");
			$strAddQuery .= (!empty($_GET['sp']))?(" and o.SalesPersonID='".$_GET['sp']."'"):("");

			//$strAddQuery .= " and o.PaymentTerm not in() ";

			 $currencyStr = '';
                        if(!empty($currencyArray[0])){
                               $currencyStr = " and o.CustomerCurrency in ( ";                      
                            foreach($currencyArray as $currencyVal){
                                $currencyStr .= "'".$currencyVal."', ";
                            }
                            $currencyStr = substr($currencyStr,0,  strlen($currencyStr)-2);
                            $currencyStr .= " ) ";   
                        }
                        
                        $strAddQuery .= $currencyStr;

		
		 
$ReceiveAmntSql = "
, IF(o.Module='Invoice',
(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.CustID>'0' and p.PostToGL ='Yes' and (p.InvoiceID=o.InvoiceID and p.InvoiceID !='') ".$innerSql." and  p.PaymentType in ('Sales','Other Income'))
,
(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.CustID>'0' and p.PostToGL ='Yes' and (p.CreditID=o.CreditID and p.CreditID !='') ".$innerSql." and p.PaymentType in ('Sales','Other Income'))
) as ReceiveAmnt";

/*
$ReceiveAmntSql = ",(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and (p.InvoiceID !='' OR p.CreditID !='') and p.PostToGL ='Yes' and ((p.InvoiceID=o.InvoiceID and o.Module='Invoice') OR (p.CreditID=o.CreditID and o.Module='Credit')) ".$innerSql." and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt ";
*/
 
			
			$strSQLQuery = "select distinct(o.OrderID) as OrderID, o.InvoiceDate, o.PostedDate, o.Module, c.Cid as CustID, o.PaymentTerm, c.CreditLimit, c.CreditLimitCurrency, c.Currency as CustCurrency, c.CreditAmount, c.Landline, o.CustCode, o.InvoiceID,   o.OrderSource, o.CreditID, o.OverPaid, o.InvoiceEntry, o.SaleID, o.MailSend, o.PdfFile, o.CustomerPO, o.TotalInvoiceAmount ,o.TotalAmount ,o.ConversionRate, o.CustomerCurrency, ab.FullName as ContactPerson,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as Customer 
".$ReceiveAmntSql."
from s_order o  left outer join s_customers c on  o.CustCode =  c.CustCode left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') where ((o.InvoicePaid!='Paid' and o.Module='Invoice') OR (o.Status!='Completed' and o.Module='Credit' and o.OrderPaid='0')) ".$strAddQuery." and o.PostToGL='1' having Customer!='' order by Customer asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END ".$Asc."  ,o.OrderID ".$Asc;


 

			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}

                function  apAgingReportList($SuppCode,$currencyArray)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($SuppCode)){
				$strAddQuery = " and o.SuppCode='".$SuppCode."'";
				$innerSql = " and p.SuppCode='".$SuppCode."'";
				$Asc = 'Desc';
			}else{
				$strAddQuery = '';
				$innerSql = '';
				$Asc = 'ASC';
			}
						
			$strAddQuery .= (!empty($_GET['From']))?(" and o.PostedDate>='".$_GET['From']."'"):("");
			$strAddQuery .= (!empty($_GET['To']))?(" and o.PostedDate<='".$_GET['To']."'"):("");			


			$InvDtType = (!empty($_GET['InvDtType']))?($_GET['InvDtType']):("");	
			 

			$DateColumnName = ($InvDtType=='v')?("o.VendorInvoiceDate"):("o.PostedDate");
			$strAddQuery .= (!empty($_GET['InvDt']))?(" and ".$DateColumnName."='".$_GET['InvDt']."'"):("");

			$currencyStr = '';
                        if(!empty($currencyArray[0])){
                               $currencyStr = " and o.Currency in ( ";                      
                            foreach($currencyArray as $currencyVal){
                                $currencyStr .= "'".$currencyVal."', ";
                            }
                            $currencyStr = substr($currencyStr,0,  strlen($currencyStr)-2);
                            $currencyStr .= " ) ";   
                        }
                        
                        $strAddQuery .= $currencyStr;


$PaidAmntSql = ",if(o.Module='Invoice',
(SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and p.SuppCode!='' and p.PostToGL ='Yes' and (p.InvoiceID=o.InvoiceID and p.InvoiceID!='') ".$innerSql." and p.PaymentType in ('Purchase' ,'Other Expense','Spiff Expense'))
,
(SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and p.SuppCode!='' and p.PostToGL ='Yes' and (p.CreditID=o.CreditID and o.Module='Credit' and p.CreditID!='') ".$innerSql." and p.PaymentType in ('Purchase' ,'Other Expense','Spiff Expense'))

) as PaidAmnt";
/*
$PaidAmntSql = ",(SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and (p.InvoiceID!='' OR p.CreditID !='') and p.PostToGL ='Yes' and ((p.InvoiceID=o.InvoiceID and o.Module='Invoice' and p.InvoiceID!='') OR (p.CreditID=o.CreditID and o.Module='Credit' and p.CreditID!='')) ".$innerSql." and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense')) as PaidAmnt";
*/

 

			$strSQLQuery = "select distinct(o.OrderID) as OrderID, o.PostedDate,o.SuppCode, o.SuppCompany, o.InvoiceID,   o.CreditID, o.Module,  o.InvoiceEntry, o.ExpenseID, o.PurchaseID,o.Currency, o.ConversionRate,o.PaymentTerm, s.Landline, s.CreditLimit,s.CreditAmount, o.OverPaid, o.ArInvoiceID, ab.Name as ContactPerson, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName, o.TotalAmount, o.TotalAmount as TotalInvoiceAmount  
".$PaidAmntSql."
                            from p_order o left outer join p_supplier s on  o.SuppCode =  s.SuppCode left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') where ((o.InvoicePaid!='1' and o.Module='Invoice') OR (o.Status!='Completed' and o.Module='Credit'))  ".$strAddQuery."  and o.PostToGL='1' order by o.SuppCompany asc,o.PostedDate ".$Asc.",o.OrderID ".$Asc;

			 //echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}


                 function  apAgingReort($SuppCode)
		{
                         global $Config;
			$strAddQuery = "";
			if(!empty($SuppCode)){
				$strAddQuery .= " and o.SuppCode='".$SuppCode."'";
				$innerSql = " and p.SuppCode='".$SuppCode."'";
			}
			
			$strSQLQuery = "select o.InvoicePaid,o.SuppCode, o.SuppCompany, o.InvoiceID,sum(o.TotalAmount) as TotalInvoiceAmount ,(SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and p.InvoiceID!='' ".$innerSql." and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense')) as PaidAmnt 
                            from p_order o  where o.module='Invoice' and o.InvoicePaid!='1' and o.ReturnID='' ".$strAddQuery." group by o.SuppCode order by o.PostedDate desc";
			 //echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                function getARUnpaidInvoiceByDays($FromDate,$ToDate,$InvoiceID)
                {
                    global $Config;
                                 
                     $strSQLQuery = "select o.TotalInvoiceAmount ,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as PaidAmnt  from s_order o left join f_payments p on (p.InvoiceID = '".$InvoiceID."'  and p.PostToGL = 'Yes' and p.InvoiceID = o.InvoiceID and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income') ) where o.Module='Invoice'  and o.InvoiceID='".$InvoiceID."' and o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."' order by o.InvoiceDate desc";
                    
                    //echo "=>".$strSQLQuery;
                     $row = $this->query($strSQLQuery, 1);
                     $totalInvoice = $row[0]['TotalInvoiceAmount'];
                     $PaidAmnt = $row[0]['PaidAmnt'];
                     if($PaidAmnt > 0)
                     {
                         $UnpaidInvoice = $totalInvoice-$PaidAmnt;
                     }else{
                         $UnpaidInvoice = $totalInvoice;
                     }
                    return $UnpaidInvoice;	
                }
                

		function getARUnpaidCreditByDays($FromDate,$ToDate,$CreditID)
                {
                    global $Config;
                                 
                     $strSQLQuery = "select o.TotalAmount ,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as PaidAmnt  from s_order o left join f_payments p on (p.CreditID = '".$CreditID."'  and p.PostToGL = 'Yes' and p.CreditID = o.CreditID and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income') ) where o.Module='Credit'  and o.CreditID='".$CreditID."' and o.PostedDate>='".$FromDate."' and o.PostedDate<='".$ToDate."' order by o.PostedDate desc";
                    
                    //echo "=>".$strSQLQuery;
                     $row = $this->query($strSQLQuery, 1);
                     $TotalAmount = $row[0]['TotalAmount'];
                     $PaidAmnt = -$row[0]['PaidAmnt'];
                     $UnpaidCredit = $TotalAmount-$PaidAmnt;

		    if($UnpaidCredit>0){
                    	return -$UnpaidCredit;	
		    }
                }


		function getAPUnpaidCreditByDays($FromDate,$ToDate,$CreditID)
                {
                    global $Config;
                                 
                     $strSQLQuery = "select o.TotalAmount ,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt  from p_order o left join f_payments p on (p.CreditID = '".$CreditID."'  and p.PostToGL = 'Yes' and p.CreditID = o.CreditID and  (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense') ) where o.Module='Credit'  and o.CreditID='".$CreditID."' and o.PostedDate>='".$FromDate."' and o.PostedDate<='".$ToDate."' order by o.PostedDate desc";
                    
                    //echo "=>".$strSQLQuery;
                     $row = $this->query($strSQLQuery, 1);
                     $TotalAmount = $row[0]['TotalAmount'];
                     $PaidAmnt = -$row[0]['PaidAmnt'];
                     $UnpaidCredit = $TotalAmount-$PaidAmnt;

		    if($UnpaidCredit>0){
                    	return -$UnpaidCredit;	
		    }
                }




                function getAPUnpaidInvoiceByDays($FromDate,$ToDate,$InvoiceID)
                {
                    global $Config;

                     $strSQLQuery = "select o.SuppCode, o.TotalAmount as TotalInvoiceAmount ,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt from p_order o left join f_payments p on  (p.InvoiceID = '".$InvoiceID."' and p.PostToGL = 'Yes' and p.InvoiceID = o.InvoiceID  and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense') ) where o.module='Invoice' and o.ReturnID='' and o.InvoiceID='".$InvoiceID."' and o.PostedDate>='".$FromDate."' and o.PostedDate<='".$ToDate."' order by o.PostedDate desc";
                 
                     $row = $this->query($strSQLQuery, 1);
                     $totalInvoice = $row[0]['TotalInvoiceAmount'];
                     $PaidAmnt = $row[0]['PaidAmnt'];
//echo "<br><br>".$strSQLQuery." # ".$totalInvoice." # ".$PaidAmnt;exit;
                     if($PaidAmnt > 0){
                         $UnpaidInvoice = $totalInvoice-$PaidAmnt;
                     }else{
                         $UnpaidInvoice = $totalInvoice;
                     }
                    return $UnpaidInvoice;	
                }
                     
              
		function getAPUnpaidInvoiceByDaysOld($FromDate,$ToDate,$SuppCode)
                {
                    global $Config;
                    $strAddQuery = "";
                    $strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
		    $strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
                    /*$strSQLQuery = "select sum(o.TotalAmount) as TotalInvoiceAmount ,(SELECT SUM(CreditAmnt) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and `InvoiceID`!='' and p.PaymentDate >= '".$FromDate."' and p.PaymentDate <= '".$ToDate."') as PaidAmnt 
                        from p_order o  where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.SuppCode order by o.PostedDate desc";*/
                    $strSQLQuery = "select o.SuppCode, sum(o.TotalAmount) as TotalInvoiceAmount ,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt from p_order o left join f_payments p on  (p.InvoiceID = o.InvoiceID  and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense') ) where o.module='Invoice' and o.ReturnID='' 
                            ".$strAddQuery." group by o.SuppCode order by o.PostedDate desc";
                 
                     $row = $this->query($strSQLQuery, 1);
                     $totalInvoice = $row[0]['TotalInvoiceAmount'];
                     $PaidAmnt = $row[0]['PaidAmnt'];
  //if($_GET['d']==1) echo "<br><br>".$strSQLQuery." # ".$totalInvoice." # ".$PaidAmnt;
                     if($PaidAmnt > 0)
                     {
                         $UnpaidInvoice = $totalInvoice-$PaidAmnt;
                     }else{
                         $UnpaidInvoice = $totalInvoice;
                     }
                    return $UnpaidInvoice;	
                }

  
               /***********************START CODE FOR PERIOD END SETTING************************************************/ 
                
                function AddUpdatePeriodSetting($arryDetails){  
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();                                               

			for($i=1;$i<=$NumLine;$i++){
                            
				if(!empty($arryDetails['PeriodYear'.$i]) && !empty($arryDetails['PeriodMonth'.$i]) && !empty($arryDetails['PeriodStatus'.$i])){
					
                                        //Get PeriodYear,PeriodMonth,PeriodModule
                                        $strSQL = "select PeriodID  from f_period_end where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$arryDetails['PeriodMonth'.$i]."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."'"; 
                                        $arryRow = $this->query($strSQL, 1);		 
                                        $PeriodID = $arryRow[0]['PeriodID'];
                                       
					
					if($PeriodID>0){						
                                                  $sql = "update f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodUpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."' where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$arryDetails['PeriodMonth'.$i]."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."'"; 
                                                  $this->query($sql, 0);
                                                       
					 }else{
                                             	//pk start
						 $sql = "insert into f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodCreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."'";
                                                   $this->query($sql, 0);
						//pk end                                            

					}
					
				}
			}
		       
			return true;

		}




		 function AddUpdatePeriodYear($PeriodYear,$PeriodStatus){  
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();                                               

			if(!empty($PeriodYear) && !empty($PeriodStatus)){			 
                                $strSQL = "select PId from f_period_year where PeriodYear='".$PeriodYear."' "; 
                                $arryRow = $this->query($strSQL, 1);		 
                                $PId = $arryRow[0]['PId'];                               
				
				if($PId>0){						
                                          $sql = "update f_period_year set PeriodStatus='".$PeriodStatus."', UpdateDate='".$Config['TodayDate']."' ,IPAddress='".$ipaddress."' where PId='".$PId."' "; 
                                }else{
					 $sql = "insert into f_period_year set PeriodYear='".$PeriodYear."', PeriodStatus='".$PeriodStatus."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."' ";
                                 }
				 $this->query($sql, 0);     
				
				/*********************************/
				//update fiscal year 		
				$FiscalYearStartDate = $this->getSettingVar('FiscalYearStartDate');
				$FiscalYearEndDate = $this->getSettingVar('FiscalYearEndDate');	
				$arryFiscalStart = explode("-",$FiscalYearStartDate); 	
				$arryFiscalEnd = explode("-",$FiscalYearEndDate); 	
				if($PeriodStatus=='Closed'){
					$FiscalYearStartDate = date('Y-m-d', mktime(0, 0, 0, $arryFiscalStart[1], 1, $PeriodYear+1)); 
					$FiscalYearEndDate = date('Y-m-d', mktime(0, 0, 0, $arryFiscalEnd[1], 31, $PeriodYear+1)); 
				}else{
					$FiscalYearStartDate = $PeriodYear.'-01-01';
					$FiscalYearEndDate = $PeriodYear.'-12-31';
				}
				
				 $sqlStart = "update settings set setting_value='".$FiscalYearStartDate."' where setting_key='FiscalYearStartDate' "; 
				 $this->query($sqlStart, 0);  

				 $sqlEnd = "update settings set setting_value='".$FiscalYearEndDate."' where setting_key='FiscalYearEndDate' "; 
				 $this->query($sqlEnd, 0);     
 				 /******************************/
				
			}
					       
			return true;

		}


		 function GetPeriodYearStatus($PeriodYear){ 
			if(!empty($PeriodYear)){			 
                                $strSQLQuery = "select PeriodStatus from f_period_year where PeriodYear='".$PeriodYear."' "; 				$arryRow = $this->query($strSQLQuery, 1);
                             	 
                                if(!empty($arryRow[0]['PeriodStatus'])){
					 return $arryRow[0]['PeriodStatus'];
				}
			}				       
			
		}

		 function getPeriodYear($PeriodYear){ 
			$addSql ='';	
			$addSql .= (!empty($PeriodYear))?(" and PeriodYear='".$PeriodYear."' "):('');					 
		        $strSQLQuery = "select * from f_period_year where 1  ".$addSql." order by PeriodYear asc";   	 
		        return $this->query($strSQLQuery, 1);							       
		}

                
                function getPeriodFields($arryDetails)
                {
                    extract($arryDetails);
                    $strAddQuery = " where 1 ";
                    $SearchKey   = strtolower(trim($_GET['search']));
                    
                    if(!empty($_GET['PeriodModule'])){
                        $strAddQuery .= " and p.PeriodModule = '".$_GET['PeriodModule']."'";
                    }
                     if(!empty($_GET['PeriodYear'])){
                        $strAddQuery .= " and p.PeriodYear = '".$_GET['PeriodYear']."'";
                    }
                    if(!empty($_GET['PeriodMonth'])){
                        $strAddQuery .= " and p.PeriodMonth = '".$_GET['PeriodMonth']."'";
                    }
                   
		    if(!empty($PeriodID)){                    
                        $strAddQuery .= " and p.PeriodID = '".$PeriodID."'";
                    }
                    
                    //$strAddQuery .= (!empty($SearchKey))?(" and (p.PeriodModule like '".$_GET['PeriodModule']."%' or p.PeriodYear = '".$_GET['PeriodYear']."' or p.PeriodMonth = '".$_GET['PeriodMonth']."') "):("");
                    $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p.PeriodModule asc,p.PeriodYear  asc,p.PeriodMonth asc ");
                    $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" ");
			   
                    $strSQLQuery = "select p.* from f_period_end p  ".$strAddQuery;
                      
                    return $this->query($strSQLQuery, 1);
                    
                }
                

		function isPeriodMonthExist($PeriodYear)
                {                   
			   
                   	$strSQLQuery = "SELECT PeriodID FROM f_period_end WHERE PeriodYear ='".$PeriodYear."' limit 0,1";
			$arryRow = $this->query($strSQLQuery, 1);

			if(!empty($arryRow[0]['PeriodID'])) {
				return true;
			}else {
				return false;
			}
                    
                }

		function isNextYearClosed($PeriodYear)
                {                   
			   
                   	$strSQLQuery = "SELECT PeriodYear FROM f_period_year WHERE PeriodYear >'".$PeriodYear."' and PeriodStatus='Closed' limit 0,1";
			$arryRow = $this->query($strSQLQuery, 1);

			if(!empty($arryRow[0]['PeriodYear'])) {
				$msg = str_replace("[YEAR]",$PeriodYear,PERIOD_YEAR_NOT_OPEN);
				$msg = str_replace("[NEXT]",$arryRow[0]['PeriodYear'],$msg);
				$_SESSION['mess_setting'] = $msg ;
				return true;
			}else {
				return false;
			}
                    
                }


                function changePeriodFieldStatus($arryDetails)
		{
                    global $Config;
                    extract($arryDetails);
                    $strSQLQuery = "UPDATE f_period_end SET PeriodStatus ='".$PeriodStatus."',PeriodUpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."' WHERE PeriodID ='".mysql_real_escape_string($active_id)."'"; 
                    $this->query($strSQLQuery,0);
                    return true;
				 			
		}


		function changePeriodStatus($PeriodID){
			if(!empty($PeriodID)){
				$sql="select PeriodID,PeriodStatus,PeriodYear from f_period_end where PeriodID='".$PeriodID."'";
				$rs = $this->query($sql);
				if(sizeof($rs)){					
					$PeriodYearStatus = $this->GetPeriodYearStatus($rs[0]['PeriodYear']);
					
					if($PeriodYearStatus=='Closed'){
						$_SESSION['mess_setting'] = str_replace('[YEAR]', $rs[0]['PeriodYear'], PERIOD_YEAR_CLOSED_MSG);
					}else{
						if($rs[0]['PeriodStatus']=='Closed'){
							$PeriodStatus='Open';
						}else{
							$PeriodStatus='Closed';
						}
						
						$sql="update f_period_end set PeriodStatus='".$PeriodStatus."' where PeriodID='".$PeriodID."'";
						$this->query($sql,0);	
						$_SESSION['mess_setting'] = PERIOD_STATUS_CHANGED;	
					}		

					return true;
				}	
			}
		}
                
                function RemovePeriodField($PeriodID){
		
			$strSQLQuery = "delete from f_period_end where PeriodID = '".$PeriodID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function getSettingVar($settingKey){
			$strSQLQuery = "select setting_value from settings where setting_key ='".trim($settingKey)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$settingValue = $arryRow[0]['setting_value'];	
			return $settingValue;
			
		}                

                function getCurrentPeriod($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and PeriodStatus='Closed' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 ";
                    $row = $this->query($strSQLQuery, 1);
                   
                    $lastMonth = $row[0]['PeriodMonth'];
                    
                    
                    if(empty($lastMonth)){
			$FiscalYearStartDate = $this->getSettingVar('FiscalYearStartDate');
			$currentPeriod = "Current Period ".date("F Y",strtotime($FiscalYearStartDate));
                    }else{
                    
                        if($lastMonth < 12){
                            $monthNum  = 1+$lastMonth;
                            $lastYear = $row[0]['PeriodYear'];
                        }else{
                            $monthNum  = 13-$lastMonth;
                            $lastYear = 1+$row[0]['PeriodYear'];
                        }
                        
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('F'); // March 
			$currentPeriod = "Current Period ".$monthName." ".$lastYear;
                    }
                    
                  
                    return $currentPeriod;
                    
                }
                

                 function getCurrentPeriodDate($PeriodModule){
                    $strSQL = "select PeriodYear,PeriodMonth from f_period_end where PeriodModule = '".$PeriodModule."' and PeriodStatus='Closed' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 "; 
                    $arryClose = $this->query($strSQL, 1);

                    $MonthClose = (!empty($arryClose[0]['PeriodMonth']))?($arryClose[0]['PeriodMonth']):("");
		    $YearClose = (!empty($arryClose[0]['PeriodYear']))?($arryClose[0]['PeriodYear']):("");
                    
		                       
                    
                    if(empty($MonthClose)){				
			$strSQL = "select PeriodYear,PeriodMonth from f_period_end where PeriodModule = '".$PeriodModule."' and PeriodStatus='Open' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 "; 
                    	$arryOpen = $this->query($strSQL, 1);	
			if(!empty($arryOpen[0]['PeriodMonth'])){
				$currentPeriod = $arryOpen[0]['PeriodYear']."-".$arryOpen[0]['PeriodMonth']."-01";
			}else{
                        	$FiscalYearStartDate = $this->getSettingVar('FiscalYearStartDate');
				$currentPeriod = $FiscalYearStartDate;
			}
                    }else{                    
                        if($MonthClose < 12){
                            $monthNum  = 1+$MonthClose;
                        }else{
                            $monthNum  = 13-$MonthClose;
                            $YearClose = $YearClose + 1;
                        }                   
			if($monthNum < 10)$monthNum = "0".$monthNum;
                    	$currentPeriod = $YearClose."-".$monthNum."-01";
                    }
                    
                   
                    
                    return $currentPeriod;
                    
                }
                
                 function getBackOpenMonth($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and PeriodStatus='Open'  ";
                    return $this->query($strSQLQuery, 1);
                   
                    
                    
                }
                
                function CheckPeriodSettings($PeriodYear,$PeriodMonth,$PeriodStatus,$PeriodModule)
                {  
                    if($PeriodMonth == "01" && $PeriodYear == date('Y'))
                    {
                         $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                         $row = $this->query($strSQLQuery, 1);
                         if(!empty($row[0]['PeriodID']))
                            {
                                $returnStr = "This month already closed for ".$PeriodModule.".";
                            }else{
                                $returnStr = 1;
                            }
                            return $returnStr;
                       
                    }
                    else{
                        
                         $strSQLQuery2 = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."'  and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                         $row2 = $this->query($strSQLQuery2, 1);

                         if(!empty($row2[0]['PeriodID']))
                            {
                                $returnStr = "This month already closed for ".$PeriodModule.".";
                            }else{
                        
                                    $PeriodMonth = $PeriodMonth-1;
                                    if($PeriodMonth < 10)$PeriodMonth = "0".$PeriodMonth;
                                    $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."'  and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                                   // echo "=>".$strSQLQuery;exit;
                                    $row = $this->query($strSQLQuery, 1);
                                    if(!empty($row[0]['PeriodID']))
                                    {
                                        $returnStr = 1;
                                    }else{
                                       // $returnStr = "Please closed all previous months for ".$PeriodModule.".";
					$returnStr = 1; //pk

                                    }
                                    
                          }  
                          
                          return $returnStr;
                        }
                  
			
                    
                }

            /***********************END CODE FOR PERIOD END SETTING************************************************/    
                
                function getReconciliationDepositOld($FromDate,$ToDate,$AccountID,$PaymentType)
             {
                     global $Config;   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");

		    if($Config['LastMonthReconcileID']>0){
				$strAddQuery .= " and p.PaymentID not in (SELECT r.PaymentID FROM `f_reconcile_transaction` r  where r.ReconcileID='".$Config['LastMonthReconcileID']."' ) ";
		     }
		   
                     $strAddQuery .= " and p.Method !='Check'  and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";
    	    		

                    $strSQLQuery = "SELECT p.TransactionID,p.PaymentID,p.PaymentDate, p.Method, p.CheckNumber, p.PaymentType,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID   WHERE 1 ".$strAddQuery."";
		        
                    return $this->query($strSQLQuery, 1);
             }
	   function getReconciliationCheckOld($FromDate,$ToDate,$AccountID,$PaymentType)
             {
                     global $Config;   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");

		     if($Config['LastMonthReconcileID']>0){
				$strAddQuery .= " and p.PaymentID not in (SELECT r.PaymentID FROM `f_reconcile_transaction` r  where r.ReconcileID='".$Config['LastMonthReconcileID']."' ) ";
		     }


                     $strAddQuery .= " and p.Method ='Check'  and p.PostToGL ='Yes' group by p.CheckNumber,p.PaymentType,p.PaymentDate order by PaymentDate desc,PaymentID desc";
                     
                    $strSQLQuery = "SELECT  GROUP_CONCAT(DISTINCT p.PaymentID SEPARATOR ',') AS PaymentID ,p.PaymentDate, p.Method, p.CheckNumber, p.PaymentType, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DebitAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID
                        WHERE 1 ".$strAddQuery."";
		       
                    return $this->query($strSQLQuery, 1);
             }
                
                
                
           /************************START CODE FOR BANK Reconciliation**************************************************************/  
                
             function getTransactionForReconciliation($FromDate,$ToDate,$AccountID,$PaymentType)
             {
                     global $Config;   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");
                     $strAddQuery .= " and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";
                     
                    $strSQLQuery = "SELECT f.BankAccountID,p.PaymentID,p.PaymentDate, p.Method, p.CheckNumber, p.PaymentType,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID
                        WHERE 1 ".$strAddQuery."";
		        
                    return $this->query($strSQLQuery, 1);
             }

	  function getReconciliationDeposit($FromDate,$ToDate,$AccountID,$PaymentType) //Not  By Transaction ID
             {
                     global $Config;   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");

		    if(!empty($Config['LastMonthReconcileID'])){
				$strAddQuery .= " and p.PaymentID not in (SELECT r.PaymentID FROM `f_reconcile_transaction` r  where r.ReconcileID in (".$Config['LastMonthReconcileID'].") ) ";
		     }
		   
                     #$strAddQuery .= " and (p.TransactionID='0' and p.PID='0') and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";

		     $strAddQuery .= " and p.TransactionID='0' and ( p2.TransactionID='0' or p2.TransactionID is null) and p.PostToGL ='Yes'   order by PaymentDate desc,PaymentID desc";
    	    		//having TransactionIDS<=0

                     $strSQLQuery = "SELECT  if(p.TransactionID>0,p.TransactionID,p2.TransactionID) as TransactionIDS,  p.PaymentID,p.PaymentDate, p.Method, p.CheckNumber, p.PaymentType,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID   left outer join f_payments p2 on (p.PID=p2.PaymentID and p.PID>'0')  WHERE 1 ".$strAddQuery."";
		        
                    return $this->query($strSQLQuery, 1);
             }

	 

	   function getReconciliationCheck($FromDate,$ToDate,$AccountID,$PaymentType) //Group By Transaction ID
             {
                     global $Config;   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");

		     if(!empty($Config['LastMonthReconcileID'])){
				$strAddQuery .= " and p.PaymentID not in (SELECT r.PaymentID FROM `f_reconcile_transaction` r  where r.ReconcileID in (".$Config['LastMonthReconcileID'].") ) ";
		     }


                     #$strAddQuery .= " and p.PostToGL ='Yes' group by TransactionIDS, p.CustID, p.SuppCode,p.PaymentType, p.PaymentDate having TransactionIDS>0  order by PaymentDate desc,PaymentID desc";
                     $strAddQuery .= " and p.PostToGL ='Yes' group by TransactionIDS, p.Method, p.CheckNumber, p.PaymentType, p.PaymentDate having TransactionIDS>'0'  order by PaymentDate desc,PaymentID desc";
                       $strSQLQuery = "SELECT  if(p.TransactionID>0,p.TransactionID,p2.TransactionID) as TransactionIDS, GROUP_CONCAT(DISTINCT p.PaymentID order by p.PaymentID asc SEPARATOR ',' )  AS PaymentID ,p.PaymentDate, p.Method, p.CheckNumber, p.PaymentType, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DebitAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID   left outer join f_payments p2 on (p.PID=p2.PaymentID and p.PID>'0') WHERE 1 ".$strAddQuery."";
		       
                    return $this->query($strSQLQuery, 1);
             }
             

	     function getUnReconcileLastMonth5555($FromDate,$ToDate,$AccountID,$PaymentType,$ReconcileID)
             {
                     global $Config;   
		   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");		   
                     $strAddQuery .= " and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";
    
                      $strSQLQuery = "SELECT p.PaymentID,p.PaymentDate, p.Method, p.CheckNumber, p.PaymentType,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID
                        WHERE p.PaymentID not in (SELECT r.PaymentID FROM `f_reconcile_transaction` r where r.ReconcileID='".$ReconcileID."' )".$strAddQuery."";
		        
                    return $this->query($strSQLQuery, 1);
		
             }

              function getTotalForReconciliation($FromDate,$ToDate,$AccountID,$PaymentType)
             {
                     global $Config;
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
		     $strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType in ".$PaymentType):("");
                     $strAddQuery .= " and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";
                     
                    $strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) AS totalDebit,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) AS totalCredit from f_account f inner join f_payments p on p.AccountID = f.BankAccountID
                        WHERE 1 ".$strAddQuery."";
                    
                    //echo "=>".$strSQLQuery;
                    return $this->query($strSQLQuery, 1);
             }
                
            function AddMonthReconciliation($arryDetails)
            {

	//echo '<pre>';print_r($arryDetails);exit;
                         extract($arryDetails); 
                         global $Config;
                         $ipaddress = GetIPAddress();
                         
                         $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID='".$AccountID."' and LocationID='".$_SESSION['locationID']."'";
                         $row = $this->query($strSQLQuery, 1);
			 
			 if($CompleteReconcile=='1' && $Status=='Reconciled'){
				$FinalStatus='1';
			 }else{
				$FinalStatus='0';
			 }
                       

                         if($row[0]['ReconcileID'] > 0){
                            $strAddQuery = "update f_reconcile set Year='".$Year."', Month='".$Month."',AccountID='".$AccountID."', Status='".$Status."', EndingBankBalance = '".$EndingBankBalance."',TotalDebitByCheck = '".$TotalDebitByCheck."',TotalCreditByCheck='".$TotalCreditByCheck."',TotalDebitCreditByCheck='".$TotalDebitCreditByCheck."',
                                UpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."',FinalStatus='".$FinalStatus."' WHERE ReconcileID ='".$row[0]['ReconcileID']."'";
                            $this->query($strAddQuery, 0);
                            $ReconcileID = $row[0]['ReconcileID'];
                             
                         }else{
                         
                            $strAddQuery = "insert into f_reconcile set Year='".$Year."', Month='".$Month."',AccountID='".$AccountID."', Status='".$Status."', EndingBankBalance = '".$EndingBankBalance."',TotalDebitByCheck = '".$TotalDebitByCheck."',TotalCreditByCheck='".$TotalCreditByCheck."',TotalDebitCreditByCheck='".$TotalDebitCreditByCheck."',
                                CreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."' ,FinalStatus='".$FinalStatus."',UnRecMonth='".$UnRecMonth."' ,AdminID = '". $_SESSION['AdminID']."',AdminType = '". $_SESSION['AdminType']."'";
                            $this->query($strAddQuery, 0);
                            $ReconcileID = $this->lastInsertId();
                         }
                         
                         return $ReconcileID;
            }
            
            function AddMonthReconciliationTransaction($arryDetails,$ReconcileID)
            {
                
                global $Config;
                extract($arryDetails);
                
		if(!empty($ReconcileID)){
			$strSQLQuery = "delete from f_reconcile_transaction WHERE ReconcileID ='".$ReconcileID."'";
			$this->query($strSQLQuery, 0);
		}

		for($i=1;$i<=$totalChecked;$i++){
			if($arryDetails['Reconcil_'.$i] > 0){
				$arryPaymentID = explode(",",$arryDetails['Reconcil_'.$i]);
				foreach($arryPaymentID as $PaymentID){
					if(!empty($PaymentID)){
				 	$strAddQuery = "insert into f_reconcile_transaction set ReconcileID='".$ReconcileID."', PaymentID='".trim($PaymentID)."'";
					$this->query($strAddQuery, 0);
					}
				}
				
			}
		}

                
            }
            
            function getReconciliationMonths5555($arryDetails)
            {
                
                extract($arryDetails);
                    $strAddQuery = " where 1 ";
                    $SearchKey   = strtolower(trim($_GET['search']));
               
                    if(!empty($RYear)){
                        $strAddQuery .= " and r.Year like '".$RYear."%'";
                    }
                    if(!empty($RMonth)){
                        $strAddQuery .= " and r.Month like '".$RMonth."%'";
                    }
                     if(!empty($RAccountID)){
                        $strAddQuery .= " and r.AccountID like '".$RAccountID."%'";
                    }
                   
                    if($ReconcileID >0 ){
                        $strAddQuery .= " and r.ReconcileID = '".$ReconcileID."'";
                    }
                    
                    //$strAddQuery .= (!empty($SearchKey))?(" and (p.PeriodModule like '".$_GET['PeriodModule']."%' or p.PeriodYear = '".$_GET['PeriodYear']."' or p.PeriodMonth = '".$_GET['PeriodMonth']."') "):("");
                    $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by r.ReconcileID ");
                    $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");
			   
                    $strSQLQuery = "select r.* from f_reconcile r  ".$strAddQuery;
                    //echo $strSQLQuery; 
                    return $this->query($strSQLQuery, 1);
                
            }
            

function getReconciliationMonths($arryDetails)
            {
                
                extract($arryDetails);
                    $strAddQuery = " where 1 ";
                    $SearchKey   = '';
		    if(!empty($search)){
                        $SearchKey   = strtolower(trim($_GET['search']));
                    }               


                    if(!empty($RYear)){
                        $strAddQuery .= " and r.Year = '".$RYear."'";
                    }
                    if(!empty($RMonth)){
                        $strAddQuery .= " and r.Month = '".$RMonth."'";
                    }
                     if(!empty($RAccountID)){
                        $strAddQuery .= " and r.AccountID = '".$RAccountID."'";
                    }
                   
                    
		    if(!empty($ReconcileID)){
                        $strAddQuery .= " and r.ReconcileID = '".$ReconcileID."'";
                    }
                    $strAddQuery .= (!empty($RStatus))?(" and r.Status = '".$RStatus."'"):("");

                    //$strAddQuery .= (!empty($SearchKey))?(" and (p.PeriodModule like '".$_GET['PeriodModule']."%' or p.PeriodYear = '".$_GET['PeriodYear']."' or p.PeriodMonth = '".$_GET['PeriodMonth']."') "):("");

			if($tr=='D'){
				$Type = "('Sales','Other Income')";
			}else if($tr=='C'){
				$Type = "('Purchase','Other Expense','Spiff Expense','Adjustment')"; 
			}

			if(!empty($Type)){
	  		    $strAddQuery .= " and p.PaymentType in ".$Type."  ";
			}
//Journal Other

		    $strAddQuery .= 'group by r.ReconcileID ';

                    $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by r.ReconcileID ");
                    $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");
			   
                    $strSQLQuery = "select r.*,p.PaymentType from f_reconcile r left outer join  f_reconcile_transaction t on r.ReconcileID=t.ReconcileID  left outer join f_payments p on t.PaymentID=p.PaymentID ".$strAddQuery." ";
                   // echo $strSQLQuery;
                    return $this->query($strSQLQuery, 1);
                
            }

            function CheckReconcilMonth($Year,$Month,$editID,$AccountID)
            {
                if($editID > 0){
                 $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."'  and Status='Reconciled' and ReconcileID != '".$editID."'";
                }else{
                    $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."' and Status='Reconciled'";
                }
               
                 $row = $this->query($strSQLQuery, 1);
                 if(!empty($row[0]['ReconcileID'])) return $row[0]['ReconcileID'];
            }
            
	 function isReconciledMonth($Year,$Month,$AccountID)
            {
                  $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."' "; 
		//and Status='Reconciled' and FinalStatus=1              
               
                 $row = $this->query($strSQLQuery, 1);
                if(!empty($row[0]['ReconcileID'])) return $row[0]['ReconcileID'];
            }

            function RemoveMonthReconciliation($ReconcileID)
            {
                $strSQLQuery = "delete from f_reconcile where ReconcileID = '".$ReconcileID."'"; 
                $this->query($strSQLQuery, 0);
                
               $strSQLQuery2 = "delete from f_reconcile_transaction where ReconcileID = '".$ReconcileID."'"; 
              $this->query($strSQLQuery2, 0);

               
            }
            
            function checkPaymentIDExist($ReconcileID, $PaymentID)
            {
                $strSQLQuery = "select PaymentID from f_reconcile_transaction where ReconcileID='".$ReconcileID."' and PaymentID='".$PaymentID."' ";
                $row = $this->query($strSQLQuery, 1);
               if(!empty( $row[0]['PaymentID'])) return $row[0]['PaymentID'];
            }

            function getMonthReconcil($ReconcileID)
            {
                 $strSQLQuery = "select * from f_reconcile where ReconcileID='".$ReconcileID."'";
                 return $this->query($strSQLQuery, 1);
                
            }

	    function getUnRecMonth($ReconcileID)
            {
                 $strSQLQuery = "select UnRecMonth from f_reconcile where ReconcileID='".$ReconcileID."'";
                 return $this->query($strSQLQuery, 1);
                
            }

	    function getLastReconcilledYear()
            {
                 $strSQLQuery = "select max(Year) as LastYear from f_reconcile where 1 ";
		 $row = $this->query($strSQLQuery, 1);
                 return $row[0]['LastYear'];    
            }
	    function getLastReconcilledMonth($Year)
            {
                 $strSQLQuery = "select max(Month) as LastMonth from f_reconcile where Year='".$Year."' ";
		 $row = $this->query($strSQLQuery, 1);
                 return $row[0]['LastMonth'];    
            }
	     function GetNumLastMonth($AccountID,$StartDate)
            {
		$NumLastMonth=0;
		if(!empty($AccountID) && !empty($StartDate)){
			$strSQLQuery = "select ReconcileID, concat(Year,'-',Month,'-','01') as FirstReconciledMonth from f_reconcile where  AccountID = '".$AccountID."' order by Year,Month asc limit 0,1 ";              	$row = $this->query($strSQLQuery, 1);
			if(!empty($row[0]['FirstReconciledMonth'])){ 
				$NumLastMonth =  round((strtotime($StartDate) - strtotime($row[0]['FirstReconciledMonth']))/(3600*24*30));
			}
		}
		if($NumLastMonth<24){
			$NumLastMonth=24;
		}
                return $NumLastMonth;
            }
           /***********************END CODE FOR Reconciliation****************************************************************/   

	 /****Start Code for Trial Balance By Shravan 23 july 2015 ***/
           
           
           function getAccountTypeForProfitLossReportNew()
                {
        			
		    $strAddQuery = " ReportType='PL'"; 
                    $strSQLQuery = "select t.AccountType,t.AccountTypeID,t.RangeFrom from f_accounttype t WHERE  ".$strAddQuery." Order By t.OrderBy";
		    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
                
          function getAccountTypeForBalanceSheetReportNew()
                {
        			
		    $strAddQuery .= "  AccountTypeID  NOT IN (13,15)"; 
                    $strSQLQuery = "select t.AccountType,t.AccountTypeID from f_accounttype t WHERE  ".$strAddQuery." Order By t.AccountType";
		    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }      
                      
           
           /****End Code for Trial Balance By Shravan 23 july 2015 ***/

	function GetCheckTemplate(){	
		 $strSQLQuery = "select * from f_check where locationID='".$_SESSION['locationID']."'";		
		return $this->query($strSQLQuery, 1);
	}

	function SaveCheckTemplate($arryDetails) {

	//echo '<pre>';print_r($arryDetails);exit;
                         extract($arryDetails); 
                         global $Config;
                         $ipaddress = GetIPAddress();
                         
                         $strSQLQuery = "select id from f_check where locationID='".$_SESSION['locationID']."'";
                         $row = $this->query($strSQLQuery, 1);
                         
			$unsetArray = array("action","r");
                        foreach($unsetArray as $arr){unset($arryDetails[$arr]);}

			foreach($arryDetails as $key=>$values){
				$str.= "$key='".$values."'".',';
			}

                         if($row[0]['id'] > 0) {
                            $strQuery = "update f_check set ".$str." UpdateDate='".$_SESSION['TodayDate']."', IPAddress='".$ipaddress."' WHERE id ='".$row[0]['id']."'";
                            $this->query($strQuery, 0);                              
                         }else{                         
                            $strQuery = "insert into f_check set ".$str." CreatedDate='".$_SESSION['TodayDate']."',locationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                            $this->query($strQuery, 0);
                         }
                       
                         return true;
            }



 	    function deleteVendorPayment($PaymentID){
		global $Config;
		if($PaymentID>0){
		 	$strSQLPay = " Select InvoiceID, CreditID, PurchaseID, PaymentID as PID, DECODE(CreditAmnt,'". $Config['EncryptKey']."') as PaymentAmount,Currency,AdjID from f_payments where PaymentID='".$PaymentID."'";
                	$arryPayment = $this->query($strSQLPay, 1);  


			$strSQLEx = "select ExpenseID from f_payments where PID='".$PaymentID."'";
                	$arryExpense = $this->query($strSQLEx, 1);
			
			if($arryExpense[0]['ExpenseID']>0){
			   $delSQLQuery = "delete from f_expense where ExpenseID = '".$arryExpense[0]['ExpenseID']."'"; 
			   $this->query($delSQLQuery, 0);
			}
			/*****************************/
			$delSQLPay = "delete from f_payments where PaymentID = '".$PaymentID."'";
			$this->query($delSQLPay, 0);

			$delSQLPay2 = "delete from f_payments where PID = '".$PaymentID."'";
			$this->query($delSQLPay2, 0);
			
			if($arryPayment[0]['AdjID']>0){
				$delSQLAdj = "delete from f_adjustment where AdjID = '".$arryPayment[0]['AdjID']."'";
				$this->query($delSQLAdj, 0);

				$delSQLAdj2 = "delete from f_multi_adjustment where AdjID = '".$arryPayment[0]['AdjID']."'";
				$this->query($delSQLAdj2, 0);
			}


			if(!empty($arryPayment[0]['InvoiceID'])){				
				$strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where InvoiceID='".$arryPayment[0]['InvoiceID']."' and PaymentID!='".$PaymentID."' and PaymentType='Purchase' ";
				$arryPaymentOther = $this->query($strSQLPayOther, 1); 
				if($arryPaymentOther[0]['NumPay']>0){
					$InvoicePaid = 2;
				}else{
					$InvoicePaid = 0;
				}


				$strQueryUp = "update p_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$arryPayment[0]['InvoiceID']."' and Module='Invoice'";
		                $this->query($strQueryUp, 0);
			}
			
			if(!empty($arryPayment[0]['PurchaseID'])){
	   			$strQueryUpd = "update p_order set InvoicePaid = '".$InvoicePaid."' where PurchaseID='".$arryPayment[0]['PurchaseID']."' and Module='Order'";
		                $this->query($strQueryUpd, 0);
			}

			if(!empty($arryPayment[0]['CreditID'])){				
				 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where CreditID='".$arryPayment[0]['CreditID']."' and PaymentID!='".$PaymentID."' and PaymentType='Purchase'  ";
				$arryPaymentOther = $this->query($strSQLPayOther, 1); 

				if($arryPaymentOther[0]['NumPay']>0){
					$Status = 'Part Applied';
				}else{
					$Status = 'Open';
				}


				$strQueryUp = "update p_order set Status = '".$Status."' where CreditID='".$arryPayment[0]['CreditID']."' and Module='Credit'";
		                $this->query($strQueryUp, 0);
			}

		}
		               
                return true;
            }

		function isTransactionSuppCodeExist($TransactionID){
			
			$strSQLQuery = "select t.SuppCode from f_transaction t where TransactionID='".$TransactionID."' limit 0,1"; 
			$arrTR = $this->query($strSQLQuery, 1); 	
			if(!empty($arrTR[0]['SuppCode'])){
				return true;
			}else{
				return false;
			}						

		}

 	    function deleteCustomerPayment($PaymentID){
		global $Config;

		if($PaymentID>0){
		 	 $strSQLPay = " Select InvoiceID, CreditID, OrderID,SaleID, PaymentID as PID, DECODE(DebitAmnt,'". $Config['EncryptKey']."') as PaymentAmount,Currency from f_payments where PaymentID='".$PaymentID."'";
                	$arryPayment = $this->query($strSQLPay, 1);  


			$strSQLIn = "select IncomeID from f_payments where PID='".$PaymentID."'";
                	$arryIncome = $this->query($strSQLIn, 1);
	
			if($arryIncome[0]['IncomeID']>0){
			   $delSQLQuery = "delete from f_income where IncomeID = '".$arryIncome[0]['IncomeID']."'"; 
			   $this->query($delSQLQuery, 0);
			}
			
			/*****************************/
			$delSQLPay = "delete from f_payments where PaymentID = '".$PaymentID."'";
			$this->query($delSQLPay, 0);

			$delSQLPay2 = "delete from f_payments where PID = '".$PaymentID."'";
			$this->query($delSQLPay2, 0);
			

			if(!empty($arryPayment[0]['InvoiceID'])){				
				 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where InvoiceID='".$arryPayment[0]['InvoiceID']."' and PaymentID!='".$PaymentID."' and PaymentType='Sales'  ";
				$arryPaymentOther = $this->query($strSQLPayOther, 1); 

				if($arryPaymentOther[0]['NumPay']>0){
					$InvoicePaid = 'Part Paid';
				}else{
					$InvoicePaid = 'Unpaid';
				}


				$strQueryUp = "update s_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$arryPayment[0]['InvoiceID']."' and Module='Invoice'";
		                $this->query($strQueryUp, 0);
			}
			
			if(!empty($arryPayment[0]['SaleID'])){
	   			$strQueryUpd = "update s_order set Status = 'Open' where SaleID='".$arryPayment[0]['SaleID']."' and Module='Order'";
		                $this->query($strQueryUpd, 0);
			}

			if(!empty($arryPayment[0]['CreditID'])){				
				 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where CreditID='".$arryPayment[0]['CreditID']."' and PaymentID!='".$PaymentID."' and PaymentType='Sales'  ";
				$arryPaymentOther = $this->query($strSQLPayOther, 1); 

				if($arryPaymentOther[0]['NumPay']>0){
					$Status = 'Part Applied';
				}else{
					$Status = 'Open';
				}


				$strQueryUp = "update s_order set Status = '".$Status."' where CreditID='".$arryPayment[0]['CreditID']."' and Module='Credit'";
		                $this->query($strQueryUp, 0);
			}

		}
		         
                return true;
            }



	  function RemoveTransaction($TransactionID){
		global $Config;

		if($TransactionID>0){
		 	 $strSQLPay = " Select InvoiceID, CreditID, OrderID,SaleID, PaymentID, DECODE(DebitAmnt,'". $Config['EncryptKey']."') as PaymentAmount,Currency from f_payments where TransactionID='".$TransactionID."'";
                	$arryPayment = $this->query($strSQLPay, 1);  

			foreach($arryPayment as $values){
				/*************************/
					$strSQLIn = "select IncomeID from f_payments where PID='".$values['PaymentID']."' and PostToGL != 'Yes' ";
					$arryIncome = $this->query($strSQLIn, 1);
	
					if($arryIncome[0]['IncomeID']>0){
					   $delSQLQuery = "delete from f_income where IncomeID = '".$arryIncome[0]['IncomeID']."'"; 
					   $this->query($delSQLQuery, 0);
					}
			
					 
					$delSQLPay = "delete from f_payments where PaymentID = '".$values['PaymentID']."' and PostToGL != 'Yes'";
					$this->query($delSQLPay, 0);

					$delSQLPay2 = "delete from f_payments where PID = '".$values['PaymentID']."' and PostToGL != 'Yes'";
					$this->query($delSQLPay2, 0);
			

					if(!empty($values['InvoiceID'])){				
						 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where InvoiceID='".$values['InvoiceID']."' and PaymentID!='".$values['PaymentID']."' and PaymentType='Sales'  ";
						$arryPaymentOther = $this->query($strSQLPayOther, 1); 

						if($arryPaymentOther[0]['NumPay']>0){
							$InvoicePaid = 'Part Paid';
						}else{
							$InvoicePaid = 'Unpaid';
						}

						$strQueryUp = "update s_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$values['InvoiceID']."' and Module='Invoice'";
						$this->query($strQueryUp, 0);

						/*******Generate PDF************/
						$objConfigure = new configure();			
						$PdfArray['ModuleDepName'] = "SalesInvoice";
						$PdfArray['Module'] = "Invoice";
						$PdfArray['ModuleID'] = "InvoiceID";
						$PdfArray['TableName'] =  "s_order";
						$PdfArray['OrderColumn'] =  "OrderID";
						$PdfArray['OrderID'] =  $values['OrderID'];					
						$objConfigure->GeneratePDF($PdfArray);
						/*******************************/


					}
			
					if(!empty($values['SaleID'])){
			   			$strQueryUpd = "update s_order set Status = 'Open' where SaleID='".$values['SaleID']."' and Module='Order'";
						$this->query($strQueryUpd, 0);
					}

					if(!empty($values['CreditID'])){				
						 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where CreditID='".$values['CreditID']."' and PaymentID!='".$values['PaymentID']."' and PaymentType='Sales'  ";
						$arryPaymentOther = $this->query($strSQLPayOther, 1); 

						if($arryPaymentOther[0]['NumPay']>0){
							$Status = 'Part Applied';
						}else{
							$Status = 'Open';
						}


						$strQueryUp = "update s_order set Status = '".$Status."' where CreditID='".$values['CreditID']."' and Module='Credit'";
						$this->query($strQueryUp, 0);
					}
			/*************************/
			}


			/*****Credit Customer Amount**********
			$strCrdAmount = "Select CustID, Amount from f_transaction_data where TransactionID='".$TransactionID."' and PaymentType='CreditAmount' ";
                	$arryCrdAmount = $this->query($strCrdAmount, 1);  
			foreach($arryCrdAmount as $values2){
				$Amount = -$values2['Amount']; //absolute
				$sql2="UPDATE s_customers SET CreditAmount='0' WHERE Cid='".$values2['CustID']."' and CreditAmount<0";
				$this->query($sql2,0);
			
				$sql="UPDATE s_customers SET CreditAmount=CreditAmount+".$Amount." WHERE Cid='".$values2['CustID']."' ";
				$this->query($sql,0);
			}
			/*************************************/

			$delSQLQuery = "delete from f_transaction where TransactionID = '".$TransactionID."'"; 
			$this->query($delSQLQuery, 0);

			$delSQLQuery2 = "delete from f_transaction_data where TransactionID = '".$TransactionID."'"; 
			$this->query($delSQLQuery2, 0);

			$delSQLQuery3 = "delete from s_order_card where TransactionID = '".$TransactionID."'"; 
			$this->query($delSQLQuery3, 0);

			$delSQLQuery4 = "delete from s_order_transaction where TransID = '".$TransactionID."'"; 
			$this->query($delSQLQuery4, 0);

		}
		         
                return true;
            }



	 function RemoveVendorTransaction($TransactionID){
		global $Config;

		if($TransactionID>0){
		 	 $strSQLPay = " Select InvoiceID, CreditID, OrderID,PurchaseID, PaymentID, DECODE(CreditAmnt,'". $Config['EncryptKey']."') as PaymentAmount,Currency,AdjID from f_payments where TransactionID='".$TransactionID."'";
                	$arryPayment = $this->query($strSQLPay, 1);  

			foreach($arryPayment as $values){
				/*************************/
					$strSQLIn = "select ExpenseID from f_payments where PID='".$values['PaymentID']."' and PostToGL != 'Yes' ";
					$arryExpense = $this->query($strSQLIn, 1);
	
					if($arryExpense[0]['ExpenseID']>0){
					   $delSQLQuery = "delete from f_expense where ExpenseID = '".$arryExpense[0]['ExpenseID']."'"; 
					   $this->query($delSQLQuery, 0);
					}
			
					 
					$delSQLPay = "delete from f_payments where PaymentID = '".$values['PaymentID']."' and PostToGL != 'Yes'";
					$this->query($delSQLPay, 0);

					$delSQLPay2 = "delete from f_payments where PID = '".$values['PaymentID']."' and PostToGL != 'Yes'";
					$this->query($delSQLPay2, 0);
			

					if($values['AdjID']>0){
						$delSQLAdj = "delete from f_adjustment where AdjID = '".$values['AdjID']."'";
						$this->query($delSQLAdj, 0);

						$delSQLAdj2 = "delete from f_multi_adjustment where AdjID = '".$values['AdjID']."'";
						$this->query($delSQLAdj2, 0);
					}



					if(!empty($values['InvoiceID'])){				
						 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where InvoiceID='".$values['InvoiceID']."' and PaymentID!='".$values['PaymentID']."' and PaymentType='Purchase'  ";
						$arryPaymentOther = $this->query($strSQLPayOther, 1); 

						if($arryPaymentOther[0]['NumPay']>0){
							$InvoicePaid = 2;
						}else{
							$InvoicePaid = 0;
						}

						$strQueryUp = "update p_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$values['InvoiceID']."' and Module='Invoice'";
		                		$this->query($strQueryUp, 0);
					}
			
					if(!empty($values['PurchaseID'])){
			   			$strQueryUpd = "update p_order set InvoicePaid = '".$InvoicePaid."' where PurchaseID='".$values['PurchaseID']."' and Module='Order'";
						$this->query($strQueryUpd, 0);
					}

					if(!empty($values['CreditID'])){				
						 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where CreditID='".$values['CreditID']."' and PaymentID!='".$values['PaymentID']."' and PaymentType='Purchase'  ";
						$arryPaymentOther = $this->query($strSQLPayOther, 1); 

						if($arryPaymentOther[0]['NumPay']>0){
							$Status = 'Part Applied';
						}else{
							$Status = 'Open';
						}


						$strQueryUp = "update p_order set Status = '".$Status."' where CreditID='".$values['CreditID']."' and Module='Credit'";
						$this->query($strQueryUp, 0);
					}
			/*************************/
			}


			/*****Credit Vendor Amount**********
			$strCrdAmount = "Select SuppCode, Amount from f_transaction_data where TransactionID='".$TransactionID."' and PaymentType='CreditAmount' ";
                	$arryCrdAmount = $this->query($strCrdAmount, 1);  
			foreach($arryCrdAmount as $values2){
				$Amount = -$values2['Amount']; //absolute
				$sql2="UPDATE p_supplier SET CreditAmount='0' WHERE SuppCode='".$values2['SuppCode']."' and CreditAmount<0";
				$this->query($sql2,0);
			
				$sql="UPDATE p_supplier SET CreditAmount=CreditAmount+".$Amount." WHERE SuppCode='".$values2['SuppCode']."' ";
				$this->query($sql,0);
			}
			/*************************************/


			$delSQLQuery = "delete from f_transaction where TransactionID = '".$TransactionID."'"; 
			$this->query($delSQLQuery, 0);

			$delSQLQuery = "delete from f_transaction_data where TransactionID = '".$TransactionID."'"; 
			$this->query($delSQLQuery, 0);

		}
		         
                return true;
            }


        function sendPaymentHistoryToVendor($arrDetails)
		{
			global $Config;	
			extract($arrDetails);
			$objBankAccount= new BankAccount();
			if($OrderID>0){
				$arryPaymentHistry = $objBankAccount->GetPaidPaymentInvoiceforSendPayments($OrderID);
                                //echo '<pre>'; print_r($arryPaymentHistry);die;
                                if ($arryPaymentHistry[0]['PaymentType'] == 'Other Expense') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                if ($arryPaymentHistry[0]['InvoicePaid'] == 1) {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }
                                            }
                                            
                                            /**PO Refrences*/
                                            if ($arryPaymentHistry[0]['InvoiceEntry'] == '1') {
                                                $poref=$arryPaymentHistry[0]['PurchaseID'];
                                            }else if ($arryPaymentHistry[0]['InvoiceEntry'] == '2' || $arryPaymentHistry[0]['InvoiceEntry'] == "3") 
                                            {
                                                if ($arryPaymentHistry[0]['InvoiceEntry'] == "3") { 
                                                $poref="Spiff";
                                                }else {
                                                    $poref=$arryPaymentHistry[0]['PurchaseID'];
                                                }
                                            }
                                            else{
                                                $poref=$arryPaymentHistry[0]['PurchaseID'];
                                                }
                                            /**PO refrences*/
  $poref = $arryPaymentHistry[0]['ReferenceNo'];
				//$module = $arryPurchase[0]['Module'];
                                $ModuleIDTitle = "Vendor Payment ID"; $ModuleID = "PaymentID"; $module = "Payment History";
				$CreatedBy = $OwnerEmailId;
				
				
				$CreatedDate = ($arryPaymentHistry[0]['CreatedDate']>0)?(date($Config['DateFormat'], strtotime($arryPaymentHistry[0]['CreatedDate']))):(NOT_SPECIFIED);
				
                                $postToGl=($arryPaymentHistry[0]['PostToGLDate']>0)?(date($Config['DateFormat'], strtotime($arryPaymentHistry[0]['PostToGLDate']))):(NOT_SPECIFIED);
				$PaymentDate = ($arryPaymentHistry[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryPaymentHistry[0]['PaymentDate']))):(NOT_SPECIFIED);

				$PaymentType = (!empty($arryPaymentHistry[0]['PaymentType']))? (stripslashes($arryPaymentHistry[0]['PaymentType'])): (NOT_SPECIFIED);
				$Method = (!empty($arryPaymentHistry[0]['Method']))?(stripslashes($arryPaymentHistry[0]['Method'])): (NOT_SPECIFIED);
				
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];
                               // echo $poref;die;
				//$contents = file_get_contents($htmlPrefix."vendor_payment.htm");
				$objConfigure = new configure();						
				$TemplateContent = $objConfigure->GetTemplateContent(76, 1);
               			$contents = $TemplateContent[0]['Content'];

				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[INVOICE_NUMBER]",$arryPaymentHistry[0]['InvoiceID'],$contents);
				$contents = str_replace("[CreatedDate]",$CreatedDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
                                $contents = str_replace("[PAYMENT_STATUS]",$InvoicePaid,$contents);
                                $contents = str_replace("[REFRENCE_NUMBER]",$poref,$contents);
				$contents = str_replace("[PostGLDate]",$postToGl,$contents);
				
				$contents = str_replace("[MESSAGE]",$Message,$contents);
				$contents = str_replace("[PAYMENT_DATE]",$PaymentDate,$contents);
				$contents = str_replace("[PaymentType]",$PaymentType,$contents);
				$contents = str_replace("[Method]",$Method,$contents);
				
				$contents = str_replace("[VENDOR_NAME]",stripslashes($arryPaymentHistry[0]['Suppvendor']),$contents);
                                $subject="Vendor ".$module." # ".$arryPaymentHistry[0][InvoiceID];
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  				
				//echo $TemplateContent[0]['subject'].'<br>'.$contents; exit;
				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
					$mail->Send();	
				}
				/**********************************/

				if($DefaultEmailConfig=='1') {
					$objImportEmail=new email();
					//echo $Attachment;die;
					if (!file_exists($output_dir)) {
						mkdir($output_dir, 0777);
					}
        
                                   	if(copy($Attachment,$output_dir.$ConvetFilename)) {
                                           chmod($output_dir.$ConvetFilename, 777);                                         
                                        }
                                        if(!empty($CCEmail)) {
                                            $CCEmaill=$CCEmail;
                                                    
                                        }
                                   $arrayForImportedEmail=array('OwnerEmailId'=>$_SESSION['AdminEmail'],'emaillistID'=>'','Subject'=>$Config['SiteName']." - ".$subject,'EmailContent'=>$Message,'Recipient'=>$ToEmail,'Cc'=>$CCEmaill,'Bcc'=>'','FromEmail'=>$OwnerEmailId,'TotalRecipient'=>'','MailType'=>'Sent','Action'=>'SendFromPurchage','ActionMailId'=>'','AdminId'=>$_SESSION['AdminID'],'ImportedDate'=>$_SESSION['TodayDate'],'FromDD'=>$Config["AdminEmail"],'AdminType'=>$_SESSION['AdminType'],'CompID'=>$_SESSION['CmpID'],'From_Email'=>$Config["AdminEmail"],'To_Email'=>$ToEmail,'composedDate'=>'','OrgMailType'=>'Sent','FileName'=>$ConvetFilename);
                                   $objImportEmail->SaveSentEmailForVendorCustomer($arrayForImportedEmail);
                               }

				/**********************************/



			}

			return 1;
		}
                
                
                
                function sendCaseReceiptToCustomer($arrDetails)
		{
			global $Config;	
			extract($arrDetails);
			$objBankAccount= new BankAccount();
			if($OrderID>0){
				$arryCaseReceipt = $objBankAccount->GetCaseRecipetReceivePaymentInvoice($OrderID);
                                //echo '<pre>'; print_r($arryCaseReceipt);die;
                               if ($arryCaseReceipt[0]['InvoicePaid'] == 'Paid') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                $StatusCls = 'red';
                                                $InvoicePaid = "Partially Paid";
                                            }
                                        
                                            /**PO Refrences*/
                                            if ($arryCaseReceipt[0]['InvoiceEntry'] == '1') {
                                                $poref=$arryCaseReceipt[0]['SaleID'];
                                            }else {
                                                $poref=$arryCaseReceipt[0]['SaleID'];
                                            }
                                                
                                            /**PO refrences*/
				//$module = $arryPurchase[0]['Module'];
                                $ModuleIDTitle = "Case Payment ID"; $ModuleID = "PaymentID"; $module = "Case Receipt";
				$CreatedBy = $arryCaseReceipt[0]['CreatedBy'];
				//echo $CreatedBy;die;
				
				$CreatedDate = ($arryCaseReceipt[0]['CreatedDate']>0)?(date($Config['DateFormat'], strtotime($arryCaseReceipt[0]['CreatedDate']))):(NOT_SPECIFIED);
				$postTOGL=($arryCaseReceipt[0]['PostToGLDate']>0)?(date($Config['DateFormat'], strtotime($arryCaseReceipt[0]['PostToGLDate']))):(NOT_SPECIFIED);
				$PaymentDate = ($arryCaseReceipt[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryCaseReceipt[0]['PaymentDate']))):(NOT_SPECIFIED);

				$PaymentType = (!empty($arryCaseReceipt[0]['PaymentType']))? (stripslashes($arryCaseReceipt[0]['PaymentType'])): (NOT_SPECIFIED);
				$Method = (!empty($arryCaseReceipt[0]['Method']))?(stripslashes($arryCaseReceipt[0]['Method'])): (NOT_SPECIFIED);
				
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];
                               // echo $poref;die;

				$objConfigure = new configure();						
				$TemplateContent = $objConfigure->GetTemplateContent(75, 1);
               			$contents = $TemplateContent[0]['Content'];

				//$contents = file_get_contents($htmlPrefix."case_receipt.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[INVOICE_NUMBER]",$arryCaseReceipt[0]['InvoiceID'],$contents);
				$contents = str_replace("[CreatedDate]",$CreatedDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
                                $contents = str_replace("[PAYMENT_STATUS]",$InvoicePaid,$contents);
                                $contents = str_replace("[REFRENCE_NUMBER]",$poref,$contents);
                                $contents = str_replace("[PostGLDate]",$postTOGL,$contents);
				
				
				$contents = str_replace("[MESSAGE]",$Message,$contents);
				$contents = str_replace("[PAYMENT_DATE]",$PaymentDate,$contents);
				$contents = str_replace("[PaymentType]",$PaymentType,$contents);
				$contents = str_replace("[Method]",$Method,$contents);
				
				$contents = str_replace("[CUSTOMER_NAME]",stripslashes($arryCaseReceipt[0]['CustomerName']),$contents);
                                $subject="Customer ".$module." # ".$arryCaseReceipt[0][InvoiceID];
				
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $TemplateContent[0]['subject'].'<br>'.$contents; exit;
				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
					$mail->Send();	
				}
				/**********************************/

				if($DefaultEmailConfig=='1') {
					$objImportEmail=new email();
					//echo $Attachment;die;
					if (!file_exists($output_dir)) {
						mkdir($output_dir, 0777);
					}
        
                                   	if(copy($Attachment,$output_dir.$ConvetFilename)) {
                                           chmod($output_dir.$ConvetFilename, 777);                                         
                                        }
                                        if(!empty($CCEmail)) {
                                            $CCEmaill=$CCEmail;
                                                    
                                        }
                                   $arrayForImportedEmail=array('OwnerEmailId'=>$_SESSION['AdminEmail'],'emaillistID'=>'','Subject'=>$Config['SiteName']." - ".$subject,'EmailContent'=>$Message,'Recipient'=>$ToEmail,'Cc'=>$CCEmaill,'Bcc'=>'','FromEmail'=>$OwnerEmailId,'TotalRecipient'=>'','MailType'=>'Sent','Action'=>'SendFromPurchage','ActionMailId'=>'','AdminId'=>$_SESSION['AdminID'],'ImportedDate'=>$_SESSION['TodayDate'],'FromDD'=>$Config["AdminEmail"],'AdminType'=>$_SESSION['AdminType'],'CompID'=>$_SESSION['CmpID'],'From_Email'=>$Config["AdminEmail"],'To_Email'=>$ToEmail,'composedDate'=>'','OrgMailType'=>'Sent','FileName'=>$ConvetFilename);
                                   $objImportEmail->SaveSentEmailForVendorCustomer($arrayForImportedEmail);
                               }

				/**********************************/



			}

			return 1;
		}

		/**********************************/
		function getPaymentTransaction($arryDetails){
			global $Config;
			extract($arryDetails);
			$strSQLQuery = "select t.*, DECODE(t.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, DECODE(t.OriginalAmount,'". $Config['EncryptKey']."') as OriginalAmount from f_transaction t where 1 ";
			$strSQLQuery .= (!empty($TransactionID))?(" and t.TransactionID='".$TransactionID."'"):("");
			$strSQLQuery .= (!empty($ContraID))?(" and t.ContraID='".$ContraID."'"):("");
			$strSQLQuery .= (!empty($PaymentType))?(" and t.PaymentType='".$PaymentType."'"):("");
			
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow;                    
                }

		function GetPaymentTransactionDetail($TransactionID,$InvoiceID,$PaymentType){
			global $Config;
			if(!empty($TransactionID)){ 
				$strAddQuery = '';
				$strAddQuery .= (!empty($TransactionID))?(" and p.TransactionID='".$TransactionID."'"):("");
				$strAddQuery .= (!empty($InvoiceID))?(" and p.InvoiceID='".$InvoiceID."'"):("");
				$strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType='".$PaymentType."'"):("");
				$strSQLQuery = "SELECT distinct(p.PaymentID), p.*, DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as  DebitAmnt, DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as  CreditAmnt,d.OriginalAmount, d2.OriginalAmount as OriginalAmountCr FROM f_payments p left outer join f_transaction_data d on (p.TransactionID=d.TransactionID and p.InvoiceID=d.InvoiceID and d.InvoiceID!='' ) left outer join f_transaction_data d2 on (p.TransactionID=d2.TransactionID and p.CreditID=d2.CreditID and d2.CreditID!='' )  WHERE p.PostToGL != 'Yes' ".$strAddQuery;	

				
	
				return $this->query($strSQLQuery, 1);
			}
		
		}

	function RemovePaymentTransaction($TransactionID){
		global $Config;
		if(!empty($TransactionID)){ 
			/*****Credit Vendor Amount**********
			$strCrdAmount = "Select SuppCode, Amount from f_transaction_data where TransactionID='".$TransactionID."' and PaymentType='CreditAmount' ";
	        	$arryCrdAmount = $this->query($strCrdAmount, 1);  
			foreach($arryCrdAmount as $values2){
				$Amount = -$values2['Amount']; //absolute
				$sql2="UPDATE p_supplier SET CreditAmount='0' WHERE SuppCode='".$values2['SuppCode']."' and CreditAmount<0";
				$this->query($sql2,0);
		
				$sql="UPDATE p_supplier SET CreditAmount=CreditAmount+".$Amount." WHERE SuppCode='".$values2['SuppCode']."' ";
				$this->query($sql,0);
			}
			/*************************************/




			 $delSQLQuery = "delete from f_transaction_data where Deleted = '1' and TransactionID = '".$TransactionID."'"; 
			 $this->query($delSQLQuery, 0);

			$arryTr['TransactionID']=$TransactionID;			
			$arryTransaction = $this->getPaymentTransaction($arryTr);


			if(!empty($arryTransaction[0]['TransactionID'])){
				$arryTransactionDetail = $this->GetPaymentTransactionDetail($TransactionID, '', 'Purchase');
 
				foreach($arryTransactionDetail as $key=>$values){
					$this->deleteVendorPayment($values['PaymentID']);
				}			
			}
		
		}	
	}


	function RemoveRecieptTransaction($TransactionID){
		global $Config;
		if(!empty($TransactionID)){ 
			/*****Credit Customer Amount**********
			$strCrdAmount = "Select CustID, Amount from f_transaction_data where TransactionID='".$TransactionID."' and PaymentType='CreditAmount' ";
	        	$arryCrdAmount = $this->query($strCrdAmount, 1);  
			foreach($arryCrdAmount as $values2){
				$Amount = -$values2['Amount']; //absolute
				$sql2="UPDATE s_customers SET CreditAmount='0' WHERE Cid='".$values2['CustID']."' and CreditAmount<0";
				$this->query($sql2,0);
		
				$sql="UPDATE s_customers SET CreditAmount=CreditAmount+".$Amount." WHERE Cid='".$values2['CustID']."' ";
				$this->query($sql,0);
			}
			/*************************************/


			 $delSQLQuery = "delete from f_transaction_data where Deleted = '1' and TransactionID = '".$TransactionID."'"; 
			 $this->query($delSQLQuery, 0);

			$arryTr['TransactionID']=$TransactionID;			
			$arryTransaction = $this->getPaymentTransaction($arryTr);
			if(!empty($arryTransaction[0]['TransactionID'])){
				$arryTransactionDetail = $this->GetPaymentTransactionDetail($TransactionID, '', 'Sales');
				foreach($arryTransactionDetail as $key=>$values){
					$this->deleteCustomerPayment($values['PaymentID']);
				}
		
			}
		
		}	
	}	

	

	function DeleteTransaction($PaymentID){
		global $Config;

		if($PaymentID>0){
		 	$strSQLPay = "Select p.TransactionID,p.InvoiceID,p.CreditID,p.GLID from f_payments p inner join f_transaction t on p.TransactionID=t.TransactionID where p.PaymentID='".$PaymentID."'";
                	$arryPayment = $this->query($strSQLPay, 1); 

	 		$TransactionID = $arryPayment[0]['TransactionID'];	
			$InvoiceID = $arryPayment[0]['InvoiceID'];
			$CreditID = $arryPayment[0]['CreditID'];
			$GLID = $arryPayment[0]['GLID'];
			if($TransactionID>0){
			   $strSQLPay2 = "Select count(PaymentID) as PaymentCount from f_payments p where TransactionID='".$TransactionID."' and PaymentID!='".$PaymentID."'";
                	    $arryPayment2 = $this->query($strSQLPay2, 1); 	

			    /**************/
			    if(!empty($InvoiceID)){
			    	$delQuery = "delete from f_transaction_data where InvoiceID = '".$InvoiceID."' and TransactionID = '".$TransactionID."'"; 
			    	$this->query($delQuery, 0);
			    }else if(!empty($GLID)){
			    	$delQuery = "delete from f_transaction_data where AccountID = '".$GLID."' and TransactionID = '".$TransactionID."'"; 
			    	$this->query($delQuery, 0);			
			    }else if(!empty($CreditID)){
			    	$delQuery = "delete from f_transaction_data where CreditID = '".$CreditID."' and TransactionID = '".$TransactionID."'"; 
			    	$this->query($delQuery, 0);
			    }
			     /**************/

			    if($arryPayment2[0]['PaymentCount']<=0){
				   $delSQLQuery = "delete from f_transaction where TransactionID = '".$TransactionID."'"; 
				   $this->query($delSQLQuery, 0);

				   $delSQLQuery = "delete from f_transaction_data where TransactionID = '".$TransactionID."'"; 
				   $this->query($delSQLQuery, 0);
			    }
			}			

		}
		         
                return true;
            }


function CreatePrepaidFreightInvoiceGL($arryOrder){
	extract($arryOrder);	
	global $Config;
 	$objBankAccount = new BankAccount();
	$objConfigure=new configure();
	$FreightExpense = $objConfigure->getSettingVariable('FreightExpense');

	$PrepaidAmount = GetConvertedAmount($ConversionRate, $PrepaidAmount);
	$PrepaidAmount = round($PrepaidAmount,2);

	$arryInvoiceData['EntryType'] = 'one_time';	
	$arryInvoiceData['GlEntryType'] = 'Single';
	$arryInvoiceData['InvoiceEntry'] = '2';
	$arryInvoiceData['PaidTo'] = $PrepaidVendor;		
	$arryInvoiceData['Amount'] = $PrepaidAmount;	
 	$arryInvoiceData['ReferenceNo'] = $PurchaseID;	 
	$arryInvoiceData['ExpenseTypeID'] = $FreightExpense;
	$arryInvoiceData['PaymentDate'] = $Config['TodayDate'];
	
 	//echo '<pre>';print_r($arryInvoiceData);exit;
	

	if($FreightExpense>0){		
		$objBankAccount->addOtherExpense($arryInvoiceData);	
	}
	
	return true;
}

function CreateCreditCardVendorInvoiceGL($arryOrder){
	extract($arryOrder);	
	global $Config;
//echo "<pre>";print_r($arryOrder);exit;
 	$objBankAccount = new BankAccount();
	$objConfigure=new configure();
	$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');

	$OriginalAmount = round($TotalAmount,2);
	$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount);
	$TotalAmount = round($TotalAmount,2);
	$Date = $PostToGLDate;
	$SessionID = session_id();	

	$arryInvoiceData['EntryType'] = 'one_time';	
	$arryInvoiceData['GlEntryType'] = 'Single';
	$arryInvoiceData['InvoiceEntry'] = '2';
	$arryInvoiceData['PaidTo'] = $CreditCardVendor;		
	$arryInvoiceData['Amount'] = $TotalAmount;	
 	$arryInvoiceData['ReferenceNo'] = $PurchaseID;	 
	$arryInvoiceData['ExpenseTypeID'] = $AccountPayable;
	$arryInvoiceData['PaymentDate'] = $Config['TodayDate'];
	
 	//echo '<pre>';print_r($arryInvoiceData);exit;
	
 
	if($AccountPayable>0){	
		/*if($GLOrderID>0){
			$NewOrderID = $GLOrderID;  //Data Updation
		}else{*/	
			$NewOrderID = $objBankAccount->addOtherExpense($arryInvoiceData);
		//}
 
		if($NewOrderID>0){		
			/*********Credit Card Transfer***************/			
			$sql = "INSERT INTO f_transaction SET  SuppCode = '".addslashes($CreditCardVendor)."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'),  AccountID = '".$AccountPayable."', ReferenceNo = '".addslashes($InvoiceID)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($PaymentTerm)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."', UpdatedDate='". $Config['TodayDate']."', OriginalAmount=ENCODE('".$OriginalAmount."','".$Config['EncryptKey']."'), ModuleCurrency='".$Currency."' , TransferOrderID='".$OrderID."' , TransferSuppCode='".addslashes($SuppCode)."' , CreatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , PostToGL = 'Yes', PostToGLDate='".$Date."' ";
			
                        $this->query($sql, 1);
                        $TransactionID = $this->lastInsertId();
			$ReceiptID = 'CRDTR000'.$TransactionID; 
			$sqlr = "UPDATE f_transaction set ReceiptID='".$ReceiptID."' where TransactionID='".$TransactionID."'";
			$this->query($sqlr, 1);	

			$sqldata = "INSERT INTO f_transaction_data  SET  TransactionID='".$TransactionID."', PaymentType = 'Invoice', Module = 'AP',  SuppCode = '".addslashes($CreditCardVendor)."', Amount = '".addslashes($TotalAmount)."', OriginalAmount = '".$OriginalAmount."', ConversionRate = '".addslashes($ConversionRate)."',InvoiceID= '".addslashes($InvoiceID)."', OrderID = '". $OrderID."', CreatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , IPAddress='".$ipaddress."' , SessionID='".$SessionID."', ModuleCurrency='".$Currency."',Method= '".addslashes($PaymentTerm)."', TransferFund=1 ";
                        $this->query($sqldata, 1);

			/*****Credit AP to Credit Card Vendor*****/
                        $strSQL = "INSERT INTO f_payments SET   TransactionID='".$TransactionID."', ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".addslashes($CreditCardVendor)."', PurchaseID = '".$PurchaseID."', InvoiceID='".$InvoiceID."', CreditAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', ReferenceNo = '".addslashes($InvoiceID)."', PaymentDate = '".$Date."' ,Method= '".addslashes($PaymentTerm)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' , PostToGL = 'Yes', PostToGLDate='".$Date."' ";
                        $this->query($strSQL, 1);
                        $PID = $this->lastInsertId();
                        
			/*****Debit AP to Main Vendor*****/
                        $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$ConversionRate."', DebitAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountPayable."', SuppCode = '".$SuppCode."', ReferenceNo = '".addslashes($InvoiceID)."',  PurchaseID = '".$PurchaseID."', InvoiceID='".$InvoiceID."' , Method= '".addslashes($PaymentTerm)."',  PaymentDate = '".$Date."',  Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D', PostToGL = 'Yes', PostToGLDate='".$Date."' ";
                        $this->query($strSQLQueryPay, 0);

			/******Make Original Invoice Paid**********/
			$strSQLQuery = "update p_order set InvoicePaid = '1' where InvoiceID='".$InvoiceID."' and Module='Invoice' ";
	   		$this->query($strSQLQuery, 0);	 
			/*********************************/
		}	
	}
	
	return true;
}

function CreatePrepaidFreightInvoice($arryOrder){
	extract($arryOrder);
	$objPurchase=new purchase();
	$arrySupplier = $objPurchase->GetSupplier('',$PrepaidVendor,'');
	
	$TotalAmount = ($TotalAmount - $Freight - $taxAmnt - $PrepaidAmount) + $PrepaidAmount;

	$arryInvoiceData['Approved'] = '1';
	$arryInvoiceData['SuppCode'] = $arrySupplier[0]['SuppCode'];
	$arryInvoiceData['SuppCompany'] = $arrySupplier[0]['CompanyName'];
	$arryInvoiceData['SuppContact'] = $arrySupplier[0]['UserName'];
	$arryInvoiceData['Address'] = $arrySupplier[0]['Address'];
	$arryInvoiceData['City'] = $arrySupplier[0]['City'];
	$arryInvoiceData['State'] = $arrySupplier[0]['State'];
	$arryInvoiceData['Country'] = $arrySupplier[0]['Country'];
	$arryInvoiceData['ZipCode'] = $arrySupplier[0]['ZipCode'];
	$arryInvoiceData['Mobile'] = $arrySupplier[0]['Mobile'];
	$arryInvoiceData['Landline'] = $arrySupplier[0]['Landline'];
	$arryInvoiceData['Email'] = $arrySupplier[0]['Email'];
	$arryInvoiceData['SuppCurrency'] = $arrySupplier[0]['Currency']; 
	$arryInvoiceData['Currency'] = $Currency;
	$arryInvoiceData['Freight'] = $PrepaidAmount;
	$arryInvoiceData['TotalAmount'] = $TotalAmount;
	$arryInvoiceData['taxAmnt'] = '';
	$arryInvoiceData['tax_auths'] = '';
	$arryInvoiceData['TaxRate'] = $TaxRate;
 	$arryInvoiceData['InvoiceComment'] = $PurchaseID;
	$arryInvoiceData['PaymentMethod'] = $PaymentMethod;
	$arryInvoiceData['ShippingMethod'] = $ShippingMethod;
	$arryInvoiceData['InvoiceComment'] = $PurchaseID;

	$strSQL = "SELECT i.* from p_order_item i where i.OrderID = '".trim($OrderID)."'";
	$arryItem = $this->query($strSQL, 1);
	$NumLine = sizeof($arryItem);
	$arryInvoiceData['NumLine'] = $NumLine;

	$count=0;
	foreach($arryItem as $arryitemdate){
		$count++;

		foreach($arryitemdate as $key=>$values){			
			$arryInvoiceData[$key.$count] = $values;
			
		}
		$arryInvoiceData['id'.$count] = '';
		$arryInvoiceData['qty'.$count] = $arryitemdate['qty_received'];
	}

	//echo '<pre>';print_r($arryInvoiceData);exit;
	$OrderID = $objPurchase->ReceiveOrderInvoiceEntry($arryInvoiceData);
	$objPurchase->AddItemForInvoiceEntry($OrderID, $arryInvoiceData); 
	return true;
}




/************************/
function PoInvoicePostToGL($OrderID,$arryPostData){
	global $Config;
	extract($arryPostData);
	
	if(empty($PostToGLDate)){
		$PostToGLDate=$Config['TodayDate'];
	}    
        $Date = $PostToGLDate;
	$ipaddress = GetIPAddress(); 

	$strSQLQuery = "SELECT distinct(p.OrderID), p2.OrderID as ReceiptOrderID, p2.ConversionRate as ReceiptConversionRate, p.*,  e.GlEntryType,e.ExpenseTypeID from p_order p left outer join f_expense e on p.ExpenseID=e.ExpenseID left outer join p_order p2 on (p.InvoiceEntry='0' and p.InvoiceID=p2.RefInvoiceID and p.PurchaseID=p2.PurchaseID and p2.Module='Receipt')  where p.OrderID = '".trim($OrderID)."' and p.PostToGL != '1' order by p.OrderID desc ";
	$arryRow = $this->query($strSQLQuery, 1);	
	$TotalAmount = $arryRow[0]['TotalAmount'];
	$OriginalAmount = $TotalAmount;
	$OrderType = $arryRow[0]['OrderType'];
	$InvoiceAmount = $arryRow[0]['TotalAmount'];
	$InvoiceConversionRate = $arryRow[0]['ConversionRate'];
	$ReceiptConversionRate = $arryRow[0]['ReceiptConversionRate'];
 	//echo $InvoiceConversionRate.'#'.$ReceiptConversionRate;exit;
	$Currency = $arryRow[0]['Currency'];	
	if(empty($Currency)) $Currency = $Config['Currency'];
 
	/************************/


	if($arryRow[0]['InvoiceEntry']==2 && !empty($TotalAmount)){ //FOR GL Account
		$GlEntryType = $arryRow[0]['GlEntryType'];		
					
		if($Currency != $Config['Currency']){
			$ConversionRate = $arryRow[0]['ConversionRate'];
		}
		if(empty($ConversionRate))$ConversionRate = 1;
		
		if($Currency != $Config['Currency']){
			$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount),2);
		}


 	      if($GlEntryType == "Single"){ //Start Single GL Account
		   $AccountID = $arryRow[0]['ExpenseTypeID'];
		   if($AccountID>0){
				$strSQLQuery = "INSERT INTO f_payments SET  ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountID."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D'  ";
				 
				$this->query($strSQLQuery, 1);
				$PID = $this->lastInsertId();


				$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$ConversionRate."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."',  AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
				$this->query($strSQLQueryPay, 0);

		}else{
		   $PID = 98898;	//vendor transfer
		}
		
		/********************/
	    }//End Single GL Account
	    else if($GlEntryType == "Multiple"){ //Start Multiple GL Account			
		$strSQL = "SELECT p.AccountID,DECODE(p.Amount,'". $Config['EncryptKey']."') as  Amount from f_multi_account_payment p inner join f_expense e on p.ExpenseID=e.ExpenseID where p.ExpenseID = '".$arryRow[0]['ExpenseID']."' and e.ExpenseID = '".$arryRow[0]['ExpenseID']."' ";
		$arryRowMulti = $this->query($strSQL, 1);
		foreach($arryRowMulti as $values){	
			$LineAmount = $values['Amount'];
			$OriginalLineAmount = $LineAmount;
			if($Currency != $Config['Currency']){
				$LineAmount = round(GetConvertedAmount($ConversionRate, $LineAmount),2);
			}
		
			$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$LineAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$values['AccountID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalLineAmount. "','".$Config['EncryptKey']."'), TransactionType='D' ";
			$this->query($strSQLQuery, 1);
			$PID = $this->lastInsertId();
		}

		$strSQLQueryPay = "INSERT INTO f_payments SET PID='0', ConversionRate = '".$ConversionRate."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
		$this->query($strSQLQueryPay, 0);

		
	    }


	}else if(!empty($TotalAmount) && ($arryRow[0]['InvoiceEntry']==0 || $arryRow[0]['InvoiceEntry']==1)){ //Start LINE ITEM	

		
	
		/**************************************/
		if(!empty($InventoryAP) && !empty($TotalAmount)){
			$Freight = $arryRow[0]['Freight'];			
			$OriginalFreight = $Freight;

			$PrepaidAmount = $arryRow[0]['PrepaidAmount'];			
			$OriginalPrepaidAmount = $PrepaidAmount;

			$taxAmnt = $arryRow[0]['taxAmnt'];			
			$ConversionRate=1;
			$OriginalSubTotal = $OriginalAmount - $Freight - $taxAmnt;
			if($arryRow[0]['Currency']!=$Config['Currency']){
				#$ConversionRate=CurrencyConvertor(1,$arryRow[0]['Currency'],$Config['Currency'],'AP',$Date);

				$ConversionRate = $arryRow[0]['ConversionRate'];

				$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount),2); 		 
				$Freight = round(GetConvertedAmount($ConversionRate, $Freight),2);
				$taxAmnt = round(GetConvertedAmount($ConversionRate, $taxAmnt),2);
				$PrepaidAmount = round(GetConvertedAmount($ConversionRate, $PrepaidAmount),2);
			}
			$SubTotal = $TotalAmount - $Freight - $taxAmnt;
			$arryRow[0]['ConversionRate'] = $ConversionRate;

			
			
			

			if($arryRow[0]['InvoiceEntry']==1){ //Invoice Entry

				if($OrderType=='Dropship'){
					$InvAccountID = $CostOfGoods;
				}else{
					$InvAccountID = $InventoryAP;
				}
				$DebitAccount = $InvAccountID;

			}else{ //Created from po receipt

				if($OrderType=='Dropship'){
					$DebitAccount = $CostOfGoods;
				}else{					 
					
					/****Calculate TwoStepFlag***********/
					$strSQL = "select p.PaymentID from p_order r inner join f_payments p on (p.ReferenceNo=r.ReceiptID and p.PostToGl='Yes' and p.PaymentType='PO Receipt') WHERE r.Module='Receipt' and r.RefInvoiceID='".$arryRow[0]['InvoiceID']."' order by PaymentID desc limit 0,1";
					$arryReceipt = $this->query($strSQL, 1);
					 
					/************************************/
					if(!empty($arryReceipt[0]['PaymentID'])){ //TwoStepFlag : first receipt posted then invoice
						$DebitAccount = $PurchaseClearing;
					}else{ //OneStepFlag
						$DebitAccount = $InventoryAP; 
					}

					$SubTotal = $TotalAmount - $taxAmnt;	
					$OriginalSubTotal = $OriginalAmount - $arryRow[0]['taxAmnt'];				
					$Freight = 0;
					$OriginalFreight = 0;


					if($PrepaidAmount>0 && $FreightExpense>0){
						$SubTotal = $SubTotal + $PrepaidAmount;			
						$OriginalSubTotal = $OriginalSubTotal + $OriginalPrepaidAmount;
					}

					

				}
				 

				/*************Post to gain loss****************/
				/**********************************************/
				if(!empty($arryReceipt[0]['PaymentID'])){ //TwoStepFlag 
				if($ApGainLoss>0 && $InvoiceConversionRate>0  && $ReceiptConversionRate>0  && $InvoiceConversionRate!='1' && $InvoiceConversionRate!=$ReceiptConversionRate && $arryRow[0]['Currency']!=$Config['Currency']){
					$TotalInvoiceAmount = GetConvertedAmount($InvoiceConversionRate, $InvoiceAmount); 
					$TotalReceiptAmount = GetConvertedAmount($ReceiptConversionRate, $InvoiceAmount); 
					$GainLoss = round(($TotalReceiptAmount - $TotalInvoiceAmount),2);
					/*$GLPaymentType = '';
					if($GainLoss>0){
						$GLPaymentType = 'AP Gain';	
					}else if($GainLoss<0){
						$GLPaymentType = 'AP Loss';	
					}*/


					if($GainLoss<0){ //negative
						$DebitAmnt = -$GainLoss;
						$CreditAmnt = '0.00';
						$SubTotal = $SubTotal - $DebitAmnt;						 
					}else if($GainLoss>0){ //positive
						$DebitAmnt = '0.00';
						$CreditAmnt = $GainLoss;
						$SubTotal = $SubTotal + $CreditAmnt;						 
					}

 
					if($DebitAmnt>0 || $CreditAmnt>0){						
						$strSQLQuery = "INSERT INTO f_payments SET CreditAmnt = ENCODE('".$CreditAmnt."', '".$Config['EncryptKey']."'),  DebitAmnt = ENCODE('".$DebitAmnt."','".$Config['EncryptKey']."'), AccountID = '".$ApGainLoss."', PurchaseID = '".$arryRow[0]['PurchaseID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."',   SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."'  "; 
						$this->query($strSQLQuery, 0);						
					}
				  }
				}
				/**********************************************/
				/**********************************************/
			}	


			
			$CreditAccount = $AccountPayable;

			/**********Debit Subtotal*********/				
			$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$SubTotal."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$DebitAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalSubTotal. "','".$Config['EncryptKey']."'), TransactionType='D' ";			
			$this->query($strSQLQuery, 1);
			$PID = $this->lastInsertId();	
			//Debit Freight					
			if($Freight>0 && $FreightExpense>0){
				$strSQLQuery2 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightExpense."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalFreight. "','".$Config['EncryptKey']."'), TransactionType='D'";
				$this->query($strSQLQuery2, 1);
			}
			//Debit Tax					
			if($taxAmnt>0 && $SalesTaxAccount>0){
				$strSQLQuery3 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$taxAmnt."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$arryRow[0]['taxAmnt']. "','".$Config['EncryptKey']."'), TransactionType='D' ";
				$this->query($strSQLQuery3, 1);
			}

			//Credit Prepaid Freight Amount
			if($PrepaidAmount>0 && $FreightExpense>0){
				//$TotalAmount = $TotalAmount - 	$PrepaidAmount;			
				//$OriginalAmount = $OriginalAmount - $OriginalPrepaidAmount;

				$strSQLQueryPr = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$PrepaidAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), InvoiceID='".$arryRow[0]['InvoiceID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$FreightExpense."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalPrepaidAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
				$this->query($strSQLQueryPr, 0);
			}
			/*********Credit Total to AP************/				
			$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), InvoiceID='".$arryRow[0]['InvoiceID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$CreditAccount."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['Currency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
			$this->query($strSQLQueryPay, 0);
			/**************************/


			 

		}
		/**************************************/
		
	}//End LINE ITEM


     		
		/************************/
		if($PID>0){

			$arryRow[0]['ConversionRate'] = $InvoiceConversionRate;
			$arryRow[0]['PostToGLDate'] = $PostToGLDate;
			$arryRow[0]['ipaddress'] = $ipaddress;
			/**********CreateVendorPayment*******/		 
			$CreateVendorPayment = 0;
			if(strtolower(trim($arryRow[0]['PaymentTerm']))=='prepayment' && $arryRow[0]['AccountID']>0){
				$CreateVendorPayment = 1;
				$arryRow[0]['PrePayment'] = 1;		
			}

			if($CreateVendorPayment==1){						
				$this->CreateVendorPaymentDirect($arryRow); 		 
			} 
			 


			$strSQLQuery = "update p_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."', PostToGLTime='".$Config['TodayDate']."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0);  
			
		}else{
			return $arryRow[0]['InvoiceID'];
		}
		/************************/


		/**********Create Invoice for Prepaid Freight************/
		if($arryRow[0]['PrepaidFreight']=='1' && $arryRow[0]['InvoiceEntry']==0 && $arryRow[0]['PurchaseID']!='' && $arryRow[0]['PrepaidVendor']!='' && $arryRow[0]['PrepaidAmount']>0){
			$this->CreatePrepaidFreightInvoiceGL($arryRow[0]);
		}
		 /**********Create Invoice for Credit Card Vendor************/
                if(strtolower(trim($arryRow[0]['PaymentTerm']))=='credit card' && $arryRow[0]['CreditCardVendor']!='' && $arryRow[0]['TotalAmount']>0 ){
			$this->CreateCreditCardVendorInvoiceGL($arryRow[0]);
		}
                /***************************/


		return true;
        	
        }


/***************************************************/	
    	function CreateVendorPaymentDirect($arryRow){ 
	 	global $Config;
		$objTransaction=new transaction();
		$objConfigure=new configure();
		
	 	if($arryRow[0]['PrePayment']==1){
			$PaidFrom = $arryRow[0]['AccountID'];
			$AccountPayable = $objConfigure->getSettingVariable('AccountPayable');			
		}

		if($PaidFrom>0 && $AccountPayable>0){	 
			$arryRow[0]['AutoReceipt'] = 1;	
			$arryRow[0]['PaidFrom'] = $PaidFrom;
			$arryRow[0]['AccountPayable'] = $AccountPayable;
			$arryRow[0]['PaymentMethod'] = $arryRow[0]['PaymentTerm']; 
			$arryRow[0]['OriginalAmount'] = round($arryRow[0]['TotalAmount'],2);
			$arryRow[0]['TotalOriginalAmount'] = round($arryRow[0]['TotalAmount'],2);
			$arryRow[0]['ModuleCurrency'] = $arryRow[0]['Currency'];

			$Amount = GetConvertedAmount($arryRow[0]['ConversionRate'], $arryRow[0]['TotalAmount']); 
			$arryRow[0]['Amount'] = round($Amount,2);
			/***********************/
			$arryRowData[0]['Module'] = 'AP';
			$arryRowData[0]['PaymentType'] = 'Invoice';
			$arryRowData[0]['Amount'] = $arryRow[0]['Amount'];
			$arryRowData[0]['OriginalAmount'] = round($arryRow[0]['TotalAmount'],2);
			$arryRowData[0]['ConversionRate'] = $arryRow[0]['ConversionRate'];	
			$arryRowData[0]['SuppCode'] = $arryRow[0]['SuppCode'];
			$arryRowData[0]['InvoiceID'] = $arryRow[0]['InvoiceID'];
			$arryRowData[0]['OrderID'] = $arryRow[0]['OrderID'];	
			$arryRowData[0]['Method'] = $arryRow[0]['PaymentTerm']; 	 
			$arryRow[0]['TrID'] = $objTransaction->AddUpdateTransaction($arryRowData[0]);	
			/***********************/
	 		$TransactionID = $objTransaction->addPayVendorTransaction($arryRow);  
		}
		return true;
	}



function GetCostofGoods($sku){
	global $Config;
	if(!empty($sku)){		
		$strSQLQuery = "select o.OrderID,o.Currency, i.sku, (i.amount/i.qty_received) as ItemCost from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.InvoicePaid='1' and o.Module='Invoice' and i.sku='" . $sku . "' order by o.PostedDate desc,o.OrderID desc  limit 0,1";
		$arryRow = $this->query($strSQLQuery, 1);
		//echo '<pre>';print_r($arryRow);exit;	
		$ItemCost = $arryRow[0]['ItemCost'];
		if($arryRow[0]['Currency']!=$Config['Currency']){
			$ConversionRate=CurrencyConvertor(1,$arryRow[0]['Currency'],$Config['Currency']);
			$ItemCost = GetConvertedAmount($ConversionRate, $ItemCost); 			
		}
		return $ItemCost;
	}
}



function GetAverageCost($sku){
	global $Config;
	$objItem=new items();
	$TotalCost=0;
	$averageCost=0;
	if(!empty($sku)){		
		$arryItemOrder = $objItem->GetPurchasedPriceItem($sku);
		$num = sizeof($arryItemOrder);
		foreach($arryItemOrder as $key => $values) {
			$ItemCost = round($values['ItemCost'],2);
			if($values['Currency']!=$Config['Currency']){
				$ConversionRate=$values['ConversionRate'];
				if(empty($ConversionRate)){
					$ConversionRate = 1;		
				}
			}else{
				$ConversionRate = 1;
			}


			$NetPrice = round(GetConvertedAmount($ConversionRate, $ItemCost) ,2);
			$TotalCost += $NetPrice;
			 
		}
		$averageCost = $TotalCost/$num ; 
		 
	}
	return $averageCost;
}





/********************************************************************/
function SoInvoicePostToGL($OrderID,$arryPostData){
	global $Config;
	extract($arryPostData);
	$objItem=new items();
	$objBankAccount = new BankAccount();
 	$objSale = new sale();
	$objConfigure=new configure();
	$objCommon = new common();
	if(empty($PostToGLDate)){
		$PostToGLDate=$Config['TodayDate'];
	}    
        $Date = $PostToGLDate;
	$ipaddress = GetIPAddress(); 	

	$strSQLQuery = "SELECT s.*,i.GlEntryType,i.IncomeTypeID from s_order s left outer join f_income i on s.IncomeID=i.IncomeID where s.OrderID = '".trim($OrderID)."' and PostToGL != '1' ";
	$arryRow = $this->query($strSQLQuery, 1);
	




	//echo '<pre>';print_r($arryRow);exit;
 

	$TotalAmount = $arryRow[0]['TotalInvoiceAmount'];
	$OriginalAmount = $TotalAmount ;
	$OrderSource = strtolower($arryRow[0]['OrderSource']);
	$IncomeID = $arryRow[0]['IncomeID'];
	$InvoiceConversionRate = $arryRow[0]['ConversionRate'];
	$EntryBy = $arryRow[0]['EntryBy']; //C for Cron
	if(empty($InvoiceConversionRate)) $InvoiceConversionRate=1;
	$PaymentType = ($arryRow[0]['InvoiceEntry']>=1)?('Customer Invoice Entry'):('Customer Invoice');
	$Currency = $arryRow[0]['CustomerCurrency'];
	if($Currency!=$Config['Currency']){		
		$ConversionRate=$arryRow[0]['ConversionRate'];		
	}
 	if(empty($ConversionRate))$ConversionRate = 1;

	/********Check to see invoice amount exceeds sales order amount*********/
	if(empty($_GET['d']) && $EcommFlag==1 && $EntryBy=='C' && !empty($arryRow[0]['SaleID']) && ($OrderSource=='amazon' || $OrderSource=='ebay')){

		$strSqlQuery = "select TotalAmount from s_order where SaleID =  '".$arryRow[0]['SaleID']."' and Module='Order' ";
		$resSal =  $this->query($strSqlQuery, 1);
		$SaleOrderAmount = round($resSal[0]['TotalAmount'],2);

		$strSql = "select sum(TotalInvoiceAmount) as TotalAmount from s_order where Module = 'Invoice' and SaleID =  '".$arryRow[0]['SaleID']."' ";
		$res =  $this->query($strSql, 1);
		$AllInvoiceTotal = round($res[0]['TotalAmount'],2);
	
	 	if($AllInvoiceTotal > $SaleOrderAmount && $SaleOrderAmount>0){
			$_SESSION['mess_post_error'] = str_replace("[INVOICE_ID]",$arryRow[0]['InvoiceID'], INVOICE_AMNT_NOT_POSTED);			 
			return true;die;
		}
	}
	 
	/********Check to see invoice amount exceeds credit card payment*********/
	if($arryRow[0]['PaymentTerm']=='Credit Card' && ($arryRow[0]['OrderPaid']=='1' || $arryRow[0]['OrderPaid']=='3' || $arryRow[0]['OrderPaid']=='4') ){
		if(!empty($arryRow[0]['SaleID'])){
			$arryCardTran = $objSale->GetTotalTransactionBySaleID($arryRow[0]['SaleID'],$arryRow[0]['PaymentTerm']);
		}else{
			$arryCardTran = $objSale->GetSalesTotalTransaction($OrderID,$arryRow[0]['PaymentTerm']);
		}
 
		if(!empty($arryCardTran[0]['TotalCharge']) || !empty($arryCardTran[0]['TotalVoid'])){
			$CardChargeAmount = $arryCardTran[0]['TotalCharge'] - $arryCardTran[0]['TotalVoid'];
			if($CardChargeAmount>$TotalAmount){
				$_SESSION['mess_post_error'] = str_replace("[INVOICE_ID]",$arryRow[0]['InvoiceID'], INVOICE_AMNT_NOT_POSTED_CHARGE);			 
				return true;die;
			}
		}
		#echo $CardChargeAmount.'<pre>'.$TotalAmount;print_r($arryCardTran); 
	}
	/**********************/
 

	if($arryRow[0]['InvoiceEntry']==2 && !empty($TotalAmount)  && $IncomeID>0){ //Start GL Account

		$GlEntryType = $arryRow[0]['GlEntryType'];		


		if($Currency!=$Config['Currency']){	
			$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount),2);
		}


		if($GlEntryType == "Single"){ //Start Single GL Account
			//Credit GL
			$AccountID = $arryRow[0]['IncomeTypeID'];
			$strSQLQuery = "INSERT INTO f_payments SET  ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountID."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
			$this->query($strSQLQuery, 1);
			$PID = $this->lastInsertId();
			 //Debit AR	
			$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$ConversionRate."', DebitAmnt  = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."',  AccountID = '".$AccountReceivable."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D' ";
			$this->query($strSQLQueryPay, 0);

		/********************/
	    }//End Single GL Account
	    else if($GlEntryType == "Multiple"){ //Start Multiple GL Account			
		$arryRowMulti=$objBankAccount->getMultiAccountgl($IncomeID);	

		foreach($arryRowMulti as $values){	
			//Credit GL		
			$AccountID = $values['AccountID'];

			$LineAmount = $values['Amount'];
			$OriginalLineAmount = $LineAmount;
			if($Currency != $Config['Currency']){
				$LineAmount = round(GetConvertedAmount($ConversionRate, $LineAmount),2);
			}			
			$strSQLQuery = "INSERT INTO f_payments SET  ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$LineAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountID."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalLineAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
			$this->query($strSQLQuery, 1);
			$PID = $this->lastInsertId();
		}

		 //Debit AR	
		$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', ConversionRate = '".$ConversionRate."', DebitAmnt  = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."',  AccountID = '".$AccountReceivable."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D' ";
		$this->query($strSQLQueryPay, 0);

		
	    }

	
		//End GL Account
	}else if(!empty($TotalAmount) && ($arryRow[0]['InvoiceEntry']==0 || $arryRow[0]['InvoiceEntry']==1)){ //Start LINE ITEM		
		/**************************************/
		/**************************************/
		if( !empty($AccountReceivable) && !empty($SalesAccount) ){
			/*****************/
				
				// Get Cost of Goods and Revenenue
				$strSQL = "SELECT i.sku,i.item_id,i.qty_invoiced,i.DropshipCheck,i.DropshipCost,(i.amount/i.qty_invoiced) as ItemSalePrice, i.amount, i.avgCost from s_order_item i where i.OrderID = '".trim($OrderID)."' and i.avgCost>0 and parent_item_id='0'";
				$arryItem = $this->query($strSQL, 1);
				//echo '<pre>';print_r($arryItem);exit;	
				$TotalCost = 0;$TotalRevenue = 0;
				
				foreach($arryItem as $values){	 
					/*if($values['DropshipCheck']=='1'){
						 $ItemCost = 0;//no cost for dropship/ no hitting to inventry and cost of good
					}else{
						 $ItemCost = $this->GetAverageCost($values['sku']); //hit inventry and cost of good
					}
					$ItemSalePrice = $values['ItemSalePrice'];
					if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){			
						$ItemSalePrice = GetConvertedAmount($ConversionRate, $ItemSalePrice); 		
					}
					*/

					if($values['DropshipCheck']=='1'){
						 $ItemCost = 0;//no cost for dropship/ no hitting to inventry and cost of good
					}else{
						 $ItemCost = $values['avgCost']; //hit inventry and cost of good
					}
									
					$TotalCost += ($ItemCost*$values['qty_invoiced']);
					
					/***Update Stock****/
					if($values['qty_invoiced']>0){
						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$values['qty_invoiced'] . "  where Sku='" .$values['sku']. "' ";
						$this->query($UpdateQtysql, 0);

						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$values['sku']. "' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);
					}
					/******************/
				}
				
			/*****************/
			$taxAmnt = $arryRow[0]['taxAmnt'];  
			$Freight = $arryRow[0]['Freight']; 
			//$TDiscount = $arryRow[0]['TDiscount'];   
			$SubTotal = $TotalAmount - $Freight - $taxAmnt;			
			$OriginalSubTotal = $SubTotal;
			$OriginalSalesAmount = $TotalAmount;
			$OriginalTotalCost = round($TotalCost,2);
			if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){				
				$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount);  
				$SubTotal = GetConvertedAmount($ConversionRate, $SubTotal);  
				$Freight = GetConvertedAmount($ConversionRate, $Freight);  
				//$TDiscount = $ConversionRate * $TDiscount;
				$taxAmnt = GetConvertedAmount($ConversionRate, $taxAmnt);
				$TotalCost = GetConvertedAmount($ConversionRate, $TotalCost);  	
			}	
			
			$TotalCost = round($TotalCost,2);  //can't get original cost as they are in different currency
			$TotalRevenue = round($SubTotal - $TotalCost,2); //store in a table 

			$SalesAmount = $TotalAmount;
			$ARAmount = $TotalAmount;
			
			/**************************************/
			if($OriginalTotalCost>0 || $TotalRevenue>0 || $TotalRevenue<0){//start TrackInventory
			#if($Config['TrackInventory']==1 && ($OriginalTotalCost>0 || $TotalRevenue>0 || $TotalRevenue<0)){

				//Debit Cost of goods and save Revenue in a separate table				 	
				if($OriginalTotalCost>0 && $InventoryAR>0 && $CostOfGoods>0){
					$ConversionRateCost=1;//not required for average cost
					//Credit Inventory
					$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRateCost."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$OriginalTotalCost."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAR."', ReferenceNo='".$arryRow[0]['InvoiceID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."'  , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='C' ";
					$this->query($strSQLQuery, 1);	

					 //Debit CostOfGoods
					$strSQLQueryCost = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRateCost."',  DebitAmnt = ENCODE('".$OriginalTotalCost."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', AccountID = '".$CostOfGoods."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='D' ";  
					$this->query($strSQLQueryCost, 0);
				}
				if($TotalRevenue!=''){	 		
					$strSQLQueryRev = "INSERT INTO f_profit SET ConversionRate = '".$ConversionRate."',  DebitAmnt = ENCODE('".$TotalRevenue."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."',  InvoiceID='".$arryRow[0]['InvoiceID']."',SaleID='".$arryRow[0]['SaleID']."', OrderID='".$arryRow[0]['OrderID']."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
					$this->query($strSQLQueryRev, 0);
				}
				///////////


				 $SalesAmount = $SubTotal;
				 $OriginalSalesAmount = $OriginalSubTotal;
				//Credit Tax and Freight				
				if($taxAmnt>0 && $SalesTaxAccount>0){
					$strSQLQ = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$taxAmnt."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."', ReferenceNo='".$arryRow[0]['InvoiceID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$arryRow[0]['taxAmnt']. "','".$Config['EncryptKey']."'), TransactionType='C' ";
					$this->query($strSQLQ, 1);
				}			
				if($Freight>0 && $FreightAR>0){
					$strSQLQuery2 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightAR."', ReferenceNo='".$arryRow[0]['InvoiceID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$arryRow[0]['Freight']. "','".$Config['EncryptKey']."'), TransactionType='C'";
					$this->query($strSQLQuery2, 1);
				}

				
			 
			}//end TrackInventory
			/**************************************/
			 //Credit Sales
			$strSQLQuerySales = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', CreditAmnt = ENCODE('".$SalesAmount."', '".$Config['EncryptKey']."'),  DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$SalesAccount."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalSalesAmount. "','".$Config['EncryptKey']."'), TransactionType='C'"; 
			$this->query($strSQLQuerySales, 0);
			$PID = $this->lastInsertId();

			 //Debit AR
			$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', DebitAmnt = ENCODE('".$ARAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$AccountReceivable."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalAmount. "','".$Config['EncryptKey']."'), TransactionType='D'";  
			$this->query($strSQLQueryPay, 0);

			/**************************************/

		}
		/**************************************/
		/**************************************/
		
	}//End LINE ITEM


	
     
		

		/************************/
		if($PID>0){
			/*******************/
			$CreateCashReceipt = 0;	$TransactionID = 0;
			if(strtolower(trim($arryRow[0]['PaymentTerm']))=='prepayment' && $arryRow[0]['AccountID']>0){
				$CreateCashReceipt = 1;
				$arryRow[0]['PrePayment'] = 1;		
			}else if($arryRow[0]['PaymentTerm']=='Credit Card' && ($arryRow[0]['OrderPaid']==1 || $arryRow[0]['OrderPaid']==3 || $arryRow[0]['OrderPaid']==4)){
				$CreateCashReceipt = 1;
				$arryRow[0]['CreditCardPayment'] = 1;		
			}else if($arryRow[0]['InvoiceEntry']=="0" && !empty($arryRow[0]['SaleID']) && $arryRow[0]['PaymentTerm']=='PayPal' && ($arryRow[0]['OrderPaid']==1 || $arryRow[0]['OrderPaid']==3)){
				$CreateCashReceipt = 1;
				$arryRow[0]['PayPalPayment'] = 1;		
			}else if($EcommFlag==1 && $EntryBy=='C' && ($OrderSource=='amazon' || $OrderSource=='ebay')){
				$CreateCashReceipt = 1;
			}else if($PosFlag==1 && $EntryBy=='C' && $OrderSource=='pos'){
				$CreateCashReceipt = 1;
			}else if($HostbillActive==1 && $EntryBy=='C' && $OrderSource=='hostbill'){
				$CreateCashReceipt = 1;
			}
			 
 
			if($CreateCashReceipt==1){
				$arryRow[0]['ConversionRate'] = $InvoiceConversionRate;
				$arryRow[0]['PostToGLDate'] = $PostToGLDate;		
				$TransactionID = $this->CreateCashReceiptDirect($arryRow); 
				if($arryRow[0]['Fee']>0){
					$this->CreateGeneralEntryDirect($arryRow);
			
				}
			}
	
			/******ActualFreight**********/
			if($arryRow[0]['InvoiceEntry']=="0" && !empty($arryRow[0]['ShippingMethod']) && !empty($arryRow[0]['SaleID'])){ 
				$arryRow[0]['PostToGLDate'] = $PostToGLDate;
		
				if($arryRow[0]['ActualFreight']>0){ //ActualFreight
					//echo 'a';die;
					 				
					$arryShippInfo = $objCommon->GetShippingInfoByInvoice('',$arryRow[0]['InvoiceID']);
  
			
					if(!empty($arryRow[0]['ShipAccountNumber'])){
						$this->CreateAPInvoiceForActualFreight($arryRow[0]);
					}else if(!empty($arryShippInfo[0]['ShipType'])){
						$arryRow[0]['ShippingMethod'] =$arryShippInfo[0]['ShipType'];
						$arryRow[0]['Freight'] = $arryRow[0]['ActualFreight'];
						$arryRow[0]['FreightAPInvoice'] =1;
						$this->CreateAPInvoiceForActualFreight($arryRow[0]);
					}else{
						/******Add Notification************/	
						$NotiMessage = '';
						if(empty($arryRow[0]['ShipAccountNumber'])){
							$NotiMessage .= 'ShipAccountNumber is missing# ';
						}						
						if(!empty($NotiMessage)){
							$arryNotification['refID'] = $arryRow[0]['InvoiceID'];
							$arryNotification['refType'] = "APInvoiceForActualFreight";
							$arryNotification['Name'] = "Actual Freight for ".$arryRow[0]['InvoiceID'];	
							$arryNotification['Subject'] = "AP Invoice For Actual Freight of Invoice: [".$arryRow[0]['InvoiceID']."] is not generated";
							$arryNotification['Message'] = $NotiMessage;
							$objConfigure->AddNotification($arryNotification);
						}
						/****************************/

					}

				}else if($arryRow[0]['Freight']>0 && !empty($ShippingCareerVal)){ //Freight
					$ShipCareerArray = explode(',', $ShippingCareerVal);
					foreach($ShipCareerArray as $ShipCareer){	
						$ShippingMethodArray[] = $ShipCareer;
					} 
					if(!in_array($arryRow[0]['ShippingMethod'], $ShippingMethodArray)){
						$arryRow[0]['FreightAPInvoice'] =1;
						$this->CreateAPInvoiceForActualFreight($arryRow[0]);
					}					
				}
			}			 
			/****************************/
		
			 

			$strSQLQuery = "update s_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."', PostToGLTime='".$Config['TodayDate']."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0); 	


			/***Ap Invoice for Vendor Commission if cash receipt is generated***/
           if($TransactionID>0 && !empty($arryRow[0]['VendorSalesPerson'])  && ($arryRow[0]['InvoiceEntry']=='0' || $arryRow[0]['InvoiceEntry']=='1') ){
                $arryRow[0]['PostToGLDate'] = $PostToGLDate;
                $this->CreateAPInvoiceForVendorCommission($arryRow[0]);      
            }  
			/**************************************/

	
			$_SESSION['NumPosted']++;
						
		}else{
			return $arryRow[0]['InvoiceID'];
		}
		/************************/
        	
        }


function CreateAPInvoiceForVendorCommission($arryOrder){
	extract($arryOrder);	
	global $Config;	 
 
	/*********************/
	$objConfigure=new configure();
	$CommissionAp = $objConfigure->getSettingVariable('CommissionAp');	
	$CommissionFeeAccount = $objConfigure->getSettingVariable('CommissionFeeAccount');
	$TotalCommission=0;
    if(!empty($VendorSalesPerson)){
    $vendorIds = explode(",",$VendorSalesPerson);
        foreach ($vendorIds as $value) {

	   if(!empty($OrderID) && !empty($value) && !empty($CommissionAp) && !empty($CommissionFeeAccount)){ 		
		 $strSQLComm = "SELECT c.SuppID, c.CommOn, c.CommType, p.SuppCode from h_commission c inner join p_supplier p on c.SuppID=p.SuppID where c.SuppID = '".$value."'   ";
		$arryComm = $this->query($strSQLComm, 1);


		if(!empty($arryComm[0]['SuppID']) && isset($arryComm[0]['CommOn'])){
			$Prefix = '../../';$SuppID = $arryComm[0]['SuppID']; $EmpID = 0;
			require_once($Prefix."classes/employee.class.php");
			$objEmployee=new employee();
 
			$strSQLPay = "select p.PaymentID from s_order o left outer join f_payments p on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') where o.Module='Invoice' and o.InvoiceID='".$InvoiceID."'  order by p.PaymentID asc limit 0,1 "; 
			$arryPay = $this->query($strSQLPay, 1);
			$PaymentID = $arryPay[0]['PaymentID'];
		  
			$IndividualOrderID=$OrderID;
		
			if($arryComm[0]['CommOn']=='1'){
				$CommType = $arryComm[0]['CommType'];				
				if($PaymentID>0 || $CommType=="Spiff"){
					include("../includes/html/box/commission_cal_per.php");
				}
			}else if($arryComm[0]['CommOn']=='2'){ 
				include("../includes/html/box/commission_cal_margin.php");
			}else{
				include("../includes/html/box/commission_cal.php");		
			}
		}
			
		
	}

	/*********************/
	if($TotalCommission>0){

	 	$objBankAccount = new BankAccount(); 

		$TotalAmount = $TotalCommission;
		$OriginalAmount = round($TotalAmount,2);
		$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount);
		$TotalAmount = round($TotalAmount,2);
 		$TotalAmount = number_format($TotalAmount,2,".",'');

		$SessionID = session_id();	

		if($PostToGLDate>0) $Date = $PostToGLDate;
		else $Date = $Config['TodayDate'];


		$arryInvoiceData['EntryType'] = 'one_time';	
		$arryInvoiceData['GlEntryType'] = 'Single';
		$arryInvoiceData['InvoiceEntry'] = '2';
		$arryInvoiceData['PaidTo'] = $arryComm[0]['SuppCode'];	
		$arryInvoiceData['Amount'] = $TotalAmount;	
		$arryInvoiceData['ReferenceNo'] = $InvoiceID;
		$arryInvoiceData['ExpenseTypeID'] = $CommissionFeeAccount;
		$arryInvoiceData['PaymentDate'] = $Date;
  		$arryInvoiceData['InvoiceComment'] = "Vendor Commission";	
		$arryInvoiceData['ArInvoiceID'] = $InvoiceID;

		//echo '<pre>';print_r($arryInvoiceData);exit;


		/****Check If AP Invoice Created********/
		$strSQLQuery2 = "SELECT p.InvoiceID as PoInvoiceID from p_order p inner join f_expense e on (p.ExpenseID=e.ExpenseID and p.ExpenseID>0) where p.PurchaseID='".$InvoiceID."'  and p.Module='Invoice' and p.InvoiceEntry='2' and p.SuppCode='".$arryComm[0]['SuppCode']."' and p.TotalAmount='".$TotalAmount."' and p.ArInvoiceID='".$InvoiceID."'  and e.ExpenseTypeID='".$CommissionFeeAccount."' and p.InvoiceComment='Vendor Commission'   order by p.OrderID asc ";
		$arryRow2 = $this->query($strSQLQuery2, 1);
		//if($_SESSION['CmpID']=="37") {echo $strSQLQuery2; pr($arryRow2,1); }	

		if(empty($arryRow2[0]['PoInvoiceID'])){			 			 
			$objBankAccount->addOtherExpense($arryInvoiceData);	
		}
		/************/

		
		
	}
   }

   
}
	/*********************/
	return true;
}



function CreateAPInvoiceForActualFreight($arryOrder){
	extract($arryOrder);	
	global $Config;
 
 	$objBankAccount = new BankAccount();
	$objConfigure=new configure();
	$FreightAR = $objConfigure->getSettingVariable('FreightAR');
 
	if(!empty($FreightAPInvoice)){
		$ActualFreight = $Freight;
		$SuppCode=$this->GetVendorByShippingMethod($ShippingMethod);
		$InvComment = "Freight for ".$InvoiceID;
	}else{
		$SuppCode=$this->GetVendorByShipAccountNumber($ShipAccountNumber,$ShippingMethod);
		$InvComment = "Actual Freight for ".$InvoiceID;
	}
 
	if(!empty($SuppCode) && $FreightAR>0){  
		$TotalAmount = $ActualFreight;
		$OriginalAmount = round($TotalAmount,2);
		$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount);
		$TotalAmount = round($TotalAmount,2);
		$SessionID = session_id();

		if($PostToGLDate>0) $Date = $PostToGLDate;
		else $Date = $Config['TodayDate'];
			

		$arryInvoiceData['EntryType'] = 'one_time';	
		$arryInvoiceData['GlEntryType'] = 'Single';
		$arryInvoiceData['InvoiceEntry'] = '2';
		$arryInvoiceData['PaidTo'] = $SuppCode;		
		$arryInvoiceData['Amount'] = $TotalAmount;	
		$arryInvoiceData['ReferenceNo'] = $SaleID;
		$arryInvoiceData['ExpenseTypeID'] = $FreightAR;
		$arryInvoiceData['PaymentDate'] = $Date;
  		if(!empty($InvoiceID) && $Module=='Invoice'){
  			$arryInvoiceData['InvoiceComment'] = $InvComment;
		}else{
			$arryInvoiceData['InvoiceComment'] = $InvoiceComment;
		}
		
		if(!empty($_GET['PK345453464364234324'])) {
			 pr($arryInvoiceData,1);die;
		}

		$objBankAccount->addOtherExpense($arryInvoiceData);

			
	}else{
		
		/******Add Notification************/	
		$NotiMessage = '';
		if(empty($SuppCode)){
			$NotiMessage .= 'SuppCode is missing# ';
		}
		if(empty($FreightAR)){
			$NotiMessage .= 'Freight is missing# ';
		}
		if(!empty($NotiMessage)){
			$arryNotification['refID'] = $InvoiceID;
			$arryNotification['refType'] = "APInvoiceForActualFreight";
			$arryNotification['Name'] = "Actual Freight for ".$InvoiceID;	
			$arryNotification['Subject'] = "AP Invoice For Actual Freight of Invoice: [".$InvoiceID."] is not generated";
			$arryNotification['Message'] = $NotiMessage;
			$objConfigure->AddNotification($arryNotification);
		}
		/****************************/
	}
	
	return true;
}




function CreateAPForActualFreight345345($arryPostData){
	global $Config;
	extract($arryPostData);
	$objItem=new items();
	$objBankAccount = new BankAccount();
  	$objConfigure=new configure();
	$FreightAR = $objConfigure->getSettingVariable('FreightAR');

	if(empty($PostToGLDate)){
		$PostToGLDate=$Config['TodayDate'];
	}    
        $Date = $PostToGLDate;
	$ipaddress = GetIPAddress(); 	
 
	$ShippingMethod = 'Fedex';
	$SuppCode = 'Fedex';

	#$strSQLQuery = "SELECT s.*, p.PurchaseID, p.InvoiceID as PoInvoiceID from s_order s left outer join p_order p on (s.SaleID=p.PurchaseID  and s.SaleID!='' and p.PurchaseID like 'SO%' and p.Module='Invoice' and p.InvoiceEntry='2' and p.SuppCode='".$SuppCode."')  where s.ShippingMethod='".$ShippingMethod."' and s.ShipAccountNumber!='' and  s.ActualFreight>0 and s.Module='Invoice' and s.InvoiceEntry='0' and s.SaleID!='' and s.PostToGL='1' and s.InvoiceDate>'2018-06-01' and p.InvoiceID is NULL order by s.OrderID asc ";

	#$strSQLQuery = "select s.* from s_order s where Module='Invoice' and ShippingMethod='Fedex' and ActualFreight>0 and ShipAccountNumber!='' and s.PostToGL='1' and s.InvoiceDate>'2018-06-01' and s.SaleID!='' and s.InvoiceEntry='0' order by OrderID asc ";

#$OrderIDIN = "'16123', '16120', '16115', '16108', '16103', '16100', '16093', '16082', '16078', '16069', '16064', '16062', '16053', '16046', '16045', '16042', '16039', '16037', '16035', '16032', '16030', '16017', '16015', '16009', '16008', '16003', '15994', '15988', '15984', '15962', '15950', '15937', '15936', '15924', '15914', '15865', '15856', '15806', '15801', '15793', '15785', '15748', '15723', '15706', '15674', '15671', '15657', '15620', '15592', '15556', '15486', '15485', '15416', '15414', '15363', '15328', '15317', '15283', '15282', '15281', '15280', '15279', '15277', '15135', '15076', '15014', '15001', '14970', '14937', '14856'";


	$strSQLQuery = "select * from s_order where InvoiceID in ('INV1011014269') and PostToGL='1' and Module='Invoice' order by OrderID asc ";


	$arryRow = $this->query($strSQLQuery, 1);	
	//pr($arryRow);exit;
	
	
	foreach($arryRow as $key => $values) {  // Start foreach  

		$order[] = $values['OrderID'];
		/******ActualFreight**********/
		if(!empty($values['ShippingMethod'])  && !empty($values['ShipAccountNumber']) && $values['ActualFreight']>0){
			
			$strSQLQuery2 = "SELECT p.InvoiceID as PoInvoiceID from p_order p where p.PurchaseID='".$values['SaleID']."'  and p.Module='Invoice' and p.InvoiceEntry='2' and p.SuppCode='".$SuppCode."'    order by p.OrderID asc ";
			$arryRow2 = $this->query($strSQLQuery2, 1);	
			
			if(empty($arryRow2[0]['PoInvoiceID'])){
				echo "Not : ". $values['InvoiceID'].'<br>'; 				 
				$this->CreateAPInvoiceForActualFreight($values); 
			}else{
				/*echo "Yes : ". $values['InvoiceID'].'<br>'; 
				pr($values);*/
			}
		}			 
		/****************************/
	} // End foreach  
	/*$orders = "'".implode("', '",$order)."'";
	pr($orders);*/ 
	exit;
}

function GetVendorByShipAccountNumber($AccountNumber,$name){ 
	  
	      if(!empty($AccountNumber) && !empty($name)){

		     if(strtolower($name)=='ups'){
				$addsql = " and api_meter_number='".$AccountNumber."'"; 
		     }else{
				$addsql = " and api_account_number='".$AccountNumber."'"; 
		     }

		     $strSqlQuery="SELECT SuppCode FROM w_shipping_credential where LOWER(api_name)='".strtolower($name)."' ".$addsql;


			$results = $this->query($strSqlQuery,1);
			return $results[0]['SuppCode'];
	        }

	}

function GetVendorByShippingMethod($name){  
       if(!empty($name)){
	        $strSqlQuery="SELECT SuppCode FROM w_attribute_value where LOWER(attribute_value)='".strtolower(trim($name))."' and attribute_id='6'";
		$results = $this->query($strSqlQuery,1);
		if(!empty($results[0]['SuppCode'])) return $results[0]['SuppCode'];
        }

}

/********************************************************************/
	function CreditCardJournalPostToGL5555($arryPostData){
		global $Config;
		extract($arryPostData);		

		 
		$ipaddress = GetIPAddress(); 	

		/*******PK*******/
		$strSQL = "SELECT OrderID  from s_order where PostToGL = '1' and Module='Invoice' and PaymentTerm='Credit Card' and Fee>'0' and OrderPaid='1' order by OrderID Asc";
		$arrySale = $this->query($strSQL, 1);
		foreach($arrySale as $key => $val) {  // Start foreach  
			$OrderID = $val['OrderID'];
			if($_GET['test']>0)$OrderID = $_GET['test']; //test

		 	/******************/	
			$strSQLQuery = "SELECT s.* from s_order s where s.OrderID = '".trim($OrderID)."' and PostToGL = '1' ";
			$arryRow = $this->query($strSQLQuery, 1);	
			//echo '<pre>';print_r($arryRow);exit;
			

			$PostToGLDate = $arryRow[0]['PostToGLDate']; /*******PK*******/
			$Date = $PostToGLDate; /*******PK*******/

			$InvoiceConversionRate = $arryRow[0]['ConversionRate'];
			$EntryBy = $arryRow[0]['EntryBy']; //C for Cron
			if(empty($InvoiceConversionRate)) $InvoiceConversionRate=1;
			$PaymentType = ($arryRow[0]['InvoiceEntry']>=1)?('Customer Invoice Entry'):('Customer Invoice');
			$ConversionRate=1;
			if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){
				//$ConversionRate=CurrencyConvertor(1,$arryRow[0]['CustomerCurrency'],$Config['Currency'],'AR',$Date);	
				$ConversionRate=$arryRow[0]['ConversionRate'];		
			}
	 
			
		
			/*******************/
			$CreateCashReceipt = 0;
			if($arryRow[0]['PaymentTerm']=='Credit Card' && $arryRow[0]['OrderPaid']==1){
				$CreateCashReceipt = 1;
				$arryRow[0]['CreditCardPayment'] = 1;		
			}
			 

			if($CreateCashReceipt==1){
				$arryRow[0]['ConversionRate'] = $InvoiceConversionRate;
				$arryRow[0]['PostToGLDate'] = $PostToGLDate;		
			
				if($arryRow[0]['Fee']>0){
					$JournalMemo = 'Credit Card-'.$arryRow[0]['InvoiceID'];
					$strJrn= "select JournalID from f_gerenal_journal where JournalMemo='".$JournalMemo."'"; 
					$arryJrn = $this->query($strJrn, 1);
					$JournalID = $arryJrn[0]['JournalID'];
					if(empty($JournalID)){
						echo $JournalID.'#'.$arryRow[0]['InvoiceID'].'#'.$arryRow[0]['Fee'].'<br><br>';
						//$this->CreateGeneralEntryDirect($arryRow);
						exit;
					}
		
				}
			}	
		/*******************/
		}	
        	exit;
        }

/********************************************************************/
function CostOfGoodPostToGL34535($arryPostData){
	global $Config;
	extract($arryPostData);
	$objItem=new items();
	$objBankAccount = new BankAccount();
 	$ipaddress = GetIPAddress(); 

	/*******PK*******/
	$strAdd = " and InvoiceID in('INV114836079909')";
	$strSQL = "SELECT OrderID  from s_order where PostToGL = '1' and Module='Invoice' ".$strAdd." and InvoiceEntry in (0,1) order by OrderID Asc";
	$arrySale = $this->query($strSQL, 1);
	if(!empty($_GET['test'])) pr($arrySale);
	foreach($arrySale as $key => $val) {  // Start foreach  
	$OrderID = $val['OrderID'];
	 
	 /******************/	
       
		

	$strSQLQuery = "SELECT s.*,i.GlEntryType,i.IncomeTypeID from s_order s left outer join f_income i on s.IncomeID=i.IncomeID where s.OrderID = '".trim($OrderID)."' and PostToGL = '1' ";
	$arryRow = $this->query($strSQLQuery, 1);

	

	echo '<pre>';print_r($arryRow);exit;
	$PostToGLDate = $arryRow[0]['PostToGLDate']; /*******PK*******/
	$Date = $PostToGLDate; /*******PK*******/

	$TotalAmount = $arryRow[0]['TotalInvoiceAmount'];
	$OriginalAmount = $TotalAmount ;
	$OrderSource = strtolower($arryRow[0]['OrderSource']);
	$IncomeID = $arryRow[0]['IncomeID'];
	$InvoiceConversionRate = $arryRow[0]['ConversionRate'];
	$EntryBy = $arryRow[0]['EntryBy']; //C for Cron
	if(empty($InvoiceConversionRate)) $InvoiceConversionRate=1;
	$PaymentType = ($arryRow[0]['InvoiceEntry']>=1)?('Customer Invoice Entry'):('Customer Invoice');
	$ConversionRate=1;
	/*if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){ //not required for average cost		
		$ConversionRate=$arryRow[0]['ConversionRate'];		
	}*/
 

 	if($arryRow[0]['InvoiceEntry']==0 || $arryRow[0]['InvoiceEntry']==1){ //Start LINE ITEM		
		/**************************************/
		/**************************************/
		if(!empty($AccountReceivable) && !empty($SalesAccount) ){
			/*****************/
				//echo $arryRow[0]['InvoiceID'].'<br>';exit; 

				// Get Cost of Goods and Revenenue
				$strSQL = "SELECT i.sku,i.item_id,i.qty_invoiced,i.DropshipCheck,i.DropshipCost,(i.amount/i.qty_invoiced) as ItemSalePrice, i.amount, i.avgCost from s_order_item i where i.OrderID = '".trim($OrderID)."' and i.avgCost>'0' and parent_item_id='0'";
				$arryItem = $this->query($strSQL, 1);
				//echo '<pre>';print_r($arryItem);exit;	
				$TotalCost = 0;$TotalRevenue = 0;
				
				foreach($arryItem as $values){

					if($values['DropshipCheck']=='1'){
						 $ItemCost = 0;//no cost for dropship/ no hitting to inventry and cost of good
					}else{
						 $ItemCost = $values['avgCost']; //hit inventry and cost of good
					}
									
					$TotalCost += ($ItemCost*$values['qty_invoiced']);
					
					
				}
				
			/*****************/
			$taxAmnt = $arryRow[0]['taxAmnt'];  
			$Freight = $arryRow[0]['Freight']; 
			//$TDiscount = $arryRow[0]['TDiscount'];   
			$SubTotal = $TotalAmount - $Freight - $taxAmnt;			
			$OriginalSubTotal = $SubTotal;
			$OriginalSalesAmount = $TotalAmount;
			$OriginalTotalCost = round($TotalCost,2);
			if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){				
				$TotalAmount = GetConvertedAmount($ConversionRate, $TotalAmount);  
				$SubTotal = GetConvertedAmount($ConversionRate, $SubTotal);  
				$Freight = GetConvertedAmount($ConversionRate, $Freight);  
				//$TDiscount = $ConversionRate * $TDiscount;
				$taxAmnt = GetConvertedAmount($ConversionRate, $taxAmnt);
				$TotalCost = GetConvertedAmount($ConversionRate, $TotalCost);  	
			}	
			
			$TotalCost = round($TotalCost,2);  //can't get original cost as they are in different currency
			$TotalRevenue = round($SubTotal - $TotalCost,2); //store in a table 

			$SalesAmount = $TotalAmount;
			$ARAmount = $TotalAmount;
		//echo $TotalCost.'#'.$TotalRevenue;exit;	

	 
			/**************************************/
			if($TotalCost>0 || $TotalRevenue>0 || $TotalRevenue<0){//start TrackInventory			
				
				$strInv= "select p.PaymentID from f_payments p where InvoiceID='".$arryRow[0]['InvoiceID']."' and ReferenceNo='".$arryRow[0]['InvoiceID']."' and  CustID = '".$arryRow[0]['CustID']."' and PaymentType='".$PaymentType."' and AccountID = '".$InventoryAR."' "; 
				$arryInv = $this->query($strInv, 1);
				$InvPaymentID = $arryInv[0]['PaymentID'];
				if(!empty($InvPaymentID)){					
					$strCost= "select p.PaymentID, DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as OldCost from f_payments p where InvoiceID='".$arryRow[0]['InvoiceID']."' and ReferenceNo='".$arryRow[0]['InvoiceID']."' and  CustID = '".$arryRow[0]['CustID']."' and PaymentType='".$PaymentType."' and AccountID = '".$CostOfGoods."' "; 
					$arryCost = $this->query($strCost, 1);
					$CostPaymentID = $arryCost[0]['PaymentID'];
					$OldCost = $arryCost[0]['OldCost'];

		

					if(!empty($CostPaymentID) && $TotalCost!=$OldCost){  
						 	
						 
						if($TotalCost>0){ //update

							#echo 'UPDATE : ';
	
							//Credit Inventory
							$strSQLInv = "update f_payments set CreditAmnt  = ENCODE('".$TotalCost."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='C'  WHERE PaymentID ='".$InvPaymentID."' ";
							if(empty($_GET['test']))$this->query($strSQLInv, 0);  

							//Debit CostOfGoods
							$strSQLCost = "update f_payments set DebitAmnt = ENCODE('".$TotalCost."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='D' WHERE PaymentID ='".$CostPaymentID."' ";
							if(empty($_GET['test']))$this->query($strSQLCost, 0);  
			
						}else{//delete
							#echo 'DELETE : ';
							$strSQLInv = "Delete FROM `f_payments` where  `PaymentID` in (".$InvPaymentID.",".$CostPaymentID.")";
							if(empty($_GET['test']))$this->query($strSQLInv, 0); 						
							$strSQLCost = "";
							
							
						}


						#echo $arryRow[0]['InvoiceID'].'----- # ----New:'.$TotalCost.'---- # -----Old:'.$OldCost.'<br><br>'; 
					}



					$strPrf= "select p.ProfitID from f_profit p where InvoiceID='".$arryRow[0]['InvoiceID']."' and ReferenceNo='".$arryRow[0]['InvoiceID']."' and  CustID = '".$arryRow[0]['CustID']."' and PaymentType='".$PaymentType."'   "; 
					$arryPrf = $this->query($strPrf, 1);
					$ProfitID = $arryPrf[0]['ProfitID'];
					if(!empty($ProfitID)){
						$strSQLRev = "update f_profit set DebitAmnt = ENCODE('".$TotalRevenue."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."') WHERE ProfitID ='".$ProfitID."' ";
						if(empty($_GET['test']))$this->query($strSQLRev, 0);  
					}
					 
					if(!empty($_GET['test']))echo $strSQLInv.'==<br><br>'.$strSQLCost.'==<br><br>'.$strSQLRev.'==<br><br>';
					
			
				}else{
					////////Debit Cost of goods and save Revenue in a separate table			 	
					

					if($TotalCost>0 && $InventoryAR>0 && $CostOfGoods>0){


						#echo 'INSERT : '.$arryRow[0]['InvoiceID'].'----- # ----New:'.$TotalCost.'---- # ----<br><br>'; 

						//Credit Inventory
						$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$TotalCost."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAR."', ReferenceNo='".$arryRow[0]['InvoiceID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."'  , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='C' ";
						if(empty($_GET['test']))$this->query($strSQLQuery, 1);	

						 //Debit CostOfGoods
						$strSQLQueryCost = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',  DebitAmnt = ENCODE('".$TotalCost."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', AccountID = '".$CostOfGoods."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= '1', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes', AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$arryRow[0]['CustomerCurrency']."' , OriginalAmount=ENCODE('".$OriginalTotalCost. "','".$Config['EncryptKey']."'), TransactionType='D' ";  
						if(empty($_GET['test']))$this->query($strSQLQueryCost, 0);


						if($TotalRevenue!=''){	 		
							$strSQLQueryRev = "INSERT INTO f_profit SET ConversionRate = '".$ConversionRate."',  DebitAmnt = ENCODE('".$TotalRevenue."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."',  InvoiceID='".$arryRow[0]['InvoiceID']."',SaleID='".$arryRow[0]['SaleID']."', OrderID='".$arryRow[0]['OrderID']."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."' ";
							if(empty($_GET['test']))$this->query($strSQLQueryRev, 0);
						}
						if(empty($_GET['test']))echo $strSQLQuery.'==<br><br>'.$strSQLQueryCost.'==<br><br>'.$strSQLQueryRev.'==<br><br>';
					}
				}
				
				/////////// 				
			 
			}//end TrackInventory
			/**************************************/
			

		}
		/**************************************/
		/**************************************/
		
	}//End LINE ITEM

  		 
		//exit;
			
		 
		}  // End foreach  
        	
        }


	/********************************************************************/

	function TaxPostToGL555($arryPostData){
		global $Config;
		extract($arryPostData);
		
		if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		}    
		$Date = $PostToGLDate;
		$ipaddress = GetIPAddress(); 

		$strSQL = "select p.PaymentID,p.OrderID,p.InvoiceID,p.CustID,p.CustCode,p.SaleID,p.PaymentType, p.PaymentDate,o.CustomerCurrency, o.ConversionRate, DECODE(p.CreditAmnt,'25091983') as PayAmount,o.taxAmnt from f_payments p inner join s_order o on p.OrderID=o.OrderID where p.AccountID='".$InventoryAR."' and p.PaymentType In ('Customer Invoice Entry','Customer Invoice') and o.taxAmnt>0 and o.PostToGL='1'"; 
		$arryP = $this->query($strSQL, 1);
		echo '<pre>';print_r($arryP[0]);exit;
		foreach ($arryP as $key => $values) {	
			// check if tax already exist
			$strS = "select p.PaymentID from f_payments p where OrderID='".$values['OrderID']."' and CustID = '".$values['CustID']."' and PaymentType='".$values['PaymentType']."' and AccountID = '".$SalesTaxAccount."' "; 
			$arryTax = $this->query($strS, 1);
			//echo $arryTax[0]['PaymentID'];exit;
			

			if(!empty($values['PaymentID'])){
				$InvItem = $values['PayAmount'] - $values['taxAmnt'];
				$strSQLQuery = "update f_payments set CreditAmnt = ENCODE($InvItem,'".$Config['EncryptKey']."') WHERE PaymentID ='".$values['PaymentID']."' ";
				$this->query($strSQLQuery, 0);  
			
				$strSQLQ = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$values['OrderID']."', CustID = '".$values['CustID']."', CustCode = '".$values['CustCode']."',  SaleID = '".$values['SaleID']."', InvoiceID='".$values['InvoiceID']."', ReferenceNo='".$values['InvoiceID']."', CreditAmnt  = ENCODE('".$values['taxAmnt']."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$SalesTaxAccount."',  PaymentDate = '".$values['PaymentDate']."', Currency = '". $values['CustomerCurrency']."', LocationID='1', PaymentType='".$values['PaymentType']."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
				$this->query($strSQLQ, 1);
				
			}
		}
	}


	function CostPostToGL($arryPostData){
		global $Config;
		extract($arryPostData);
		
		if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		}    
		$Date = $PostToGLDate;
		$ipaddress = GetIPAddress(); 

		$strSQL = "select p.PaymentID,o.OrderID,o.InvoiceID,p.CustID,p.CustCode,o.SaleID,p.PaymentType, p.PaymentDate,o.CustomerCurrency,  DECODE(p.DebitAmnt,'25091983') as PayAmount,o.taxAmnt,o.Freight  from f_payments p inner join s_order o on (p.ReferenceNo=o.InvoiceID and o.Module='Invoice' ) where p.AccountID='".$CostOfGoods."' and p.PaymentType In ('Customer Invoice Entry','Customer Invoice') and (o.taxAmnt>'0' or o.Freight>'0') order by p.PaymentDate Asc"; 
		$arryP = $this->query($strSQL, 1);
		echo '<pre>';print_r($arryP);exit;
		foreach ($arryP as $key => $values) {					

			if(!empty($values['PaymentID'])){
				$TotalCost = $values['PayAmount'] - $values['taxAmnt']  - $values['Freight'];
				if($TotalCost<0) $TotalCost=0;
				if($TotalCost>0){
					$strSQLQuery = "update f_payments set DebitAmnt = ENCODE($TotalCost,'".$Config['EncryptKey']."') WHERE PaymentID ='".$values['PaymentID']."' ";
				}else{
					$strSQLQuery = "DELETE FROM f_payments WHERE PaymentID ='".$values['PaymentID']."' "; 
				}


				//echo $values['PayAmount'].' - '.$values['taxAmnt'].'  - '.$values['Freight'].' = '.$strSQLQuery;
				//$this->query($strSQLQuery, 0);
				//echo '<br><br>'; 
			}
		}
	}


	function SalesPostToGL555($arryPostData){
		global $Config;
		extract($arryPostData);
		
		if(empty($PostToGLDate)){
			$PostToGLDate=$Config['TodayDate'];
		}    
		$Date = $PostToGLDate;
		$ipaddress = GetIPAddress(); 

		$strSQL = "select p.PaymentID,p.IPAddress, o.OrderID,o.InvoiceID,o.InvoiceEntry,p.CustID,p.CustCode,o.SaleID,p.PaymentType, p.PaymentDate,o.CustomerCurrency,  DECODE(p.CreditAmnt,'25091983') as PayAmount, o.TotalInvoiceAmount from f_payments p inner join s_order o on (p.ReferenceNo=o.InvoiceID and o.Module='Invoice' ) where p.AccountID='".$SalesAccount."' and p.PaymentType In ('Customer Invoice Entry','Customer Invoice') order by p.PaymentDate Asc,p.PaymentID asc"; 
		$arryP = $this->query($strSQL, 1);
		//echo '<pre>';print_r($arryP);exit;
		foreach ($arryP as $key => $values) {					

			if(!empty($values['PaymentID'])){
				
				if($values['PayAmount']==$values['TotalInvoiceAmount'] && $values['IPAddress']=='115.160.246.202'){			

					$TotalAmount = $values['TotalInvoiceAmount'];
					$strSQLQuery = "Del from f_payments WHERE PaymentID ='".$values['PaymentID']."' ";

					echo $values['InvoiceID'].' # '.$values['PaymentID'].' = '.$strSQLQuery;
					//$this->query($strSQLQuery, 0);
					echo '<br><br>'; 
					$Count++;
					
				}
	


				
			}
		}
		echo $Count;
		
	}


	function APCostPostToGL($arryPostData){
		global $Config;
		extract($arryPostData);
		//print_R($arryPostData);exit;
		   
		
		$ipaddress = GetIPAddress(); 
		#$strSQLQuery = "SELECT o.* from p_order o where o.PostToGL = '1' and o.Module='Invoice' and (o.InvoiceEntry=0 or o.InvoiceEntry=1) order by o.PostToGL asc,o.PostedDate desc,o.OrderID desc";
		$strSQLQuery = "SELECT o.* from p_order o where o.PostToGL = '1' and o.Module='Invoice' and (o.InvoiceEntry='0' or o.InvoiceEntry='1') and o.OrderDate!=o.PostToGLDate and o.OrderDate<'2016-03-01' and o.PostToGLDate>='2016-03-01' order by o.OrderDate desc     ";
		$arryRow = $this->query($strSQLQuery, 1);	
		//echo sizeof($arryRow);exit;	
		//echo '<pre>';print_r($arryRow[0]);exit;
		foreach ($arryRow as $key => $values) {	
			if($values['InvoiceEntry']==0 || $values['InvoiceEntry']==1){
				/*$strS = "select p.PaymentID from f_payments p where OrderID='".$values['OrderID']."' and InvoiceID='".$values['InvoiceID']."' and SuppCode = '".$values['SuppCode']."' and PaymentType in ('Vendor Invoice','Vendor Invoice Entry') and AccountID = '".$InventoryAP."' "; 
				$arryData = $this->query($strS, 1);
				$PaymentID = $arryData[0]['PaymentID'];*/
				//if($PaymentID>0){
					$TotalAmount = $values['TotalAmount'];
					$OrderType = $values['OrderType'];
					$OrderID = $values['OrderID'];
					$Freight = $values['Freight'] + $values['PrepaidAmount'];
					$SubTotal = $TotalAmount - $Freight;
					$PaymentDate = $values['OrderDate'];
					$PostToGLDate = $values['PostToGLDate'];

					/*if($OrderType=='Dropship'){						
						$strSQLQuery = "update f_payments set AccountID ='".$CostOfGoods."' WHERE PaymentID ='".$PaymentID."' ";
						$this->query($strSQLQuery, 1);
						echo $values['InvoiceID'].'#'.$strSQLQuery.'<br><br>';
						$Count++;
					}*/
 
					$strSQLQuery = "update f_payments set PaymentDate ='".$PaymentDate."' where  ReferenceNo='".$values['InvoiceID']."' and SuppCode = '".$values['SuppCode']."' and PaymentType in ('Vendor Invoice','Vendor Invoice Entry') and PaymentDate='".$PostToGLDate."'";
					$this->query($strSQLQuery, 1);
					
					$strSQLInv = "update p_order set PostedDate ='".$PaymentDate."',PostToGLDate ='".$PaymentDate."' where OrderID='".$values['OrderID']."' and InvoiceID='".$values['InvoiceID']."'  and Module='Invoice'";
					$this->query($strSQLInv, 1);
					//echo $strSQLQuery.'<br><br>';
				//}

			}
			
		}
		echo $Count;
	}



	function  SalesReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status){ 
		global $Config;

		$strAddQuery = "";


		if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
		}else{
			$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
		}
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
		$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");

		$strSQLQuery = "select o.CustCode,o.InvoiceDate,o.CustID,o.InvoiceID,o.PaymentTerm,o.SaleID,o.OrderID,o.taxAmnt, o.CustomerCurrency, o.ConversionRate,o.TotalAmount,o.TotalInvoiceAmount,o.Mobile,o.ReturnID,o.taxAmnt ,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName  from s_order o  left outer join s_customers c on o.CustCode = c.CustCode  where o.Module='Invoice'  and o.taxAmnt > '0' and o.ReturnID='' ".$strAddQuery." order by o.InvoiceDate desc";	
		return $this->query($strSQLQuery, 1);		
	}

	function  GrossSalesTotal($FilterBy,$FromDate,$ToDate,$Month,$Year,$Type,$Module){ 
		global $Config;
		$strAddQuery = "";
		if($FilterBy=='Year'){
			$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
		}else if($FilterBy=='Month'){
			$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
		}else{
			$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
		}

		if($Module=='Invoice'){
			$Col = 'o.TotalInvoiceAmount';
		}else if($Module=='Credit'){
			$Col = 'o.TotalAmount';
		}


		if($Type=='Gross'){
			$selectCol = $Col;
		}else if($Type=='Exempt'){
			$selectCol = $Col;
			$strAddQuery .=  " and o.taxAmnt <= '0' ";
		}else if($Type=='Taxabale'){
			$selectCol = 'o.taxAmnt';
			$strAddQuery .=  " and o.taxAmnt > '0' ";
		}else if($Type=='TaxCol'){
			$selectCol = 'o.taxAmnt';
			$strAddQuery .=  " and o.taxAmnt > '0' and o.PostToGL='1' ";
		}
		
	 		$strSQLQuery = "select sum(if(o.CustomerCurrency!='".$Config['Currency']."' AND o.ConversionRate>0,".$selectCol."*o.ConversionRate, ".$selectCol.")) as TotalAmount  from s_order o  where o.Module='".$Module."'  ".$strAddQuery."  ";	
		$arryRow =  $this->query($strSQLQuery, 1);

		//echo $strSQLQuery.'<br><br>';
		return $arryRow[0]['TotalAmount'];
	}
                
	/***************************************************/	
	function getAccountForProvider($SaleID,$PaymentTerm,$TransactionType){
		$strSQLQuery = "select t.ID, p.ProviderID, p.glAccount, p.AccountPaypal, p.AccountPaypalFee , p.AccountCardFee from f_payment_provider p inner join s_order_transaction t on p.ProviderID=t.ProviderID inner join s_order o on t.OrderID=o.OrderID where t.PaymentTerm='".$PaymentTerm."' and t.TransactionType='".$TransactionType."' and o.SaleID ='".trim($SaleID)."' and o.Module='Order'  order by t.ID desc limit 0,1";

		#$strSQLQuery = "select ProviderID from s_order_transaction t inner join s_order o on t.OrderID=o.OrderID where t.PaymentTerm='".$PaymentTerm."' and t.TransactionType='".$TransactionType."' and o.SaleID ='".trim($SaleID)."' and o.Module='Order' order by t.ID desc limit 0,1"; 

		return $this->query($strSQLQuery, 1);
	
	}
	/***************************************************/	
	function getCreditCardAccountForProvider($OrderID,$SaleID,$PaymentTerm,$TransactionType){

		if(!empty($SaleID)){
			$strAddQry = " and o.SaleID ='".trim($SaleID)."'  and Module='Order' ";
		}else if(!empty($OrderID)){
			$strAddQry = " and o.OrderID ='".trim($OrderID)."' ";
		}

		 $strSQLQuery = "select t.ID, p.ProviderID, p.AccountPaypal, p.AccountPaypalFee , p.AccountCardFee, p.VisaGL , p.MasterCardGL, p.DiscoverGL, p.AmexGL, t.CardType from f_payment_provider p inner join s_order_transaction t on p.ProviderID=t.ProviderID inner join s_order o on t.OrderID=o.OrderID  where t.PaymentTerm='".$PaymentTerm."' and t.TransactionType='".$TransactionType."' ".$strAddQry." order by t.ID desc limit 0,1";		 
		$arryRow = $this->query($strSQLQuery, 1);

		/*********************/
		if(!empty($SaleID) && empty($arryRow[0]['ID'])){
			unset($arryRow);
			 $strSQLQuery = "select t.ID, p.ProviderID, p.AccountPaypal, p.AccountPaypalFee , p.AccountCardFee , p.VisaGL , p.MasterCardGL, p.DiscoverGL, p.AmexGL, t.CardType from f_payment_provider p inner join s_order_transaction t on p.ProviderID=t.ProviderID inner join s_order o on t.OrderID=o.OrderID  where t.PaymentTerm='".$PaymentTerm."' and t.TransactionType='".$TransactionType."' and o.OrderID ='".trim($OrderID)."' order by t.ID desc limit 0,1";		 
			$arryRow = $this->query($strSQLQuery, 1);
		}
		
		/*********************/


		$arryRow[0]['glAccount']=0;
		if(!empty($arryRow[0]['ID']) && !empty($arryRow[0]['CardType'])){	
			switch($arryRow[0]['CardType']){
				case 'Visa': $arryRow[0]['glAccount'] = $arryRow[0]['VisaGL'];  break;
				case 'MasterCard': $arryRow[0]['glAccount'] = $arryRow[0]['MasterCardGL'];  break;
				case 'Discover': $arryRow[0]['glAccount'] = $arryRow[0]['DiscoverGL'];  break;
				case 'Amex': $arryRow[0]['glAccount'] = $arryRow[0]['AmexGL'];  break;
			}
		}	
		return $arryRow;
	
	}
	/***************************************************/	
    	function CreateCashReceiptDirect($arryRow){ 
	 	global $Config;
		$objTransaction=new transaction();
		$objConfigure=new configure();
		
		$OrderSource = strtolower($arryRow[0]['OrderSource']);
 
		if($arryRow[0]['PrePayment']==1){			
			$PaidTo = $arryRow[0]['AccountID'];
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');			
		}else if($arryRow[0]['PayPalPayment']==1){
			$arryProvider = $this->getAccountForProvider($arryRow[0]['SaleID'],'PayPal','Invoice Payment');
			$PaidTo = $arryProvider[0]['AccountPaypal'];	
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');			
		}else if($arryRow[0]['CreditCardPayment']==1){
			$arryProvider = $this->getCreditCardAccountForProvider($arryRow[0]['OrderID'],$arryRow[0]['SaleID'],'Credit Card','Charge');
			$PaidTo = $arryProvider[0]['glAccount'];	
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');			
		}else if($OrderSource=='amazon'){	
			$PaidTo = $objConfigure->getSettingVariable('AmazonAccount');
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');	
		}else if($OrderSource=='ebay'){
			$PaidTo = $objConfigure->getSettingVariable('EbayAccount');
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
		}else if($OrderSource=='hostbill'){
			$PaidTo = $objConfigure->getDefaultAccount(); //$objConfigure->getSettingVariable('HostbillFee');
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
		}else if($OrderSource=='pos'){
			$PaidTo = $objConfigure->getSettingVariable('PosAccount');
			$AccountReceivable = $objConfigure->getSettingVariable('AccountReceivable');
		}

		 
		//echo $PaidTo.'#'.$AccountReceivable;exit;
		

		if($PaidTo>0 && $AccountReceivable>0){
 
			if(!empty($arryRow[0]['AmountToCharge']) && $arryRow[0]['AmountToCharge']>0){
				$MainAmount = $arryRow[0]['AmountToCharge'];
			}else{
				$MainAmount = $arryRow[0]['TotalInvoiceAmount'];
			}

			$arryRow[0]['AutoReceipt'] = 1;	
			$arryRow[0]['PaidTo'] = $PaidTo;
			$arryRow[0]['PaymentMethod'] = $arryRow[0]['PaymentTerm']; 
			$arryRow[0]['Method'] = $arryRow[0]['PaymentTerm']; 
			$arryRow[0]['AccountReceivable'] = $AccountReceivable;
			$arryRow[0]['OriginalAmount'] = round($MainAmount ,2);
			$arryRow[0]['TotalOriginalAmount'] = round($MainAmount ,2);
			$arryRow[0]['ModuleCurrency'] = $arryRow[0]['CustomerCurrency'];
			$Amount = GetConvertedAmount($arryRow[0]['ConversionRate'], $MainAmount ); 
			$arryRow[0]['Amount'] = round($Amount,2);
			/***********************/
			$arryRowData[0]['Module'] = 'AR';
			$arryRowData[0]['PaymentType'] = 'Invoice';
			$arryRowData[0]['OriginalAmount'] = round($MainAmount,2);
			$arryRowData[0]['Amount'] = $arryRow[0]['Amount'];
			$arryRowData[0]['ConversionRate'] = $arryRow[0]['ConversionRate'];	
			$arryRowData[0]['CustID'] = $arryRow[0]['CustID'];
			$arryRowData[0]['InvoiceID'] = $arryRow[0]['InvoiceID'];
			$arryRowData[0]['OrderID'] = $arryRow[0]['OrderID'];
			$arryRowData[0]['Method'] = $arryRow[0]['PaymentTerm']; 
 

			$arryRow[0]['TrID'] = $objTransaction->AddUpdateTransaction($arryRowData[0]);	
			/***********************/
	 		$TransactionID = $objTransaction->addReceiptTransaction($arryRow);  
		}
		return $TransactionID;
	}


  	/***************************************************/	
	function CreateGeneralEntryDirect($arryRow){
		global $Config;		
	  	$objJournal = new journal();
		$objBankAccount = new BankAccount();
		$OrderSource = strtolower($arryRow[0]['OrderSource']);
		$ReferenceID = $arryRow[0]['SaleID'];
		$glDate = $arryRow[0]['PostToGLDate'];
		$Config['PostToGLDate'] = $glDate;
 
		if($arryRow[0]['PayPalPayment']==1){
			$arryProvider = $this->getAccountForProvider($arryRow[0]['SaleID'],'PayPal','Invoice Payment');
			$AccountID1 = $arryProvider[0]['AccountPaypal']; //credit
			$AccountID2 = $arryProvider[0]['AccountPaypalFee']; //debit 
			$OrderSource = $arryRow[0]['PaymentTerm'];		
		}else if($arryRow[0]['CreditCardPayment']==1){
			$arryProvider = $this->getCreditCardAccountForProvider($arryRow[0]['OrderID'],$arryRow[0]['SaleID'],'Credit Card','Charge');	
			$AccountID1 = $arryProvider[0]['glAccount'];	//credit
			$AccountID2 = $arryProvider[0]['AccountCardFee']; //$objJournal->getSettingVariable('CreditCardFee');//debit
			$OrderSource = $arryRow[0]['PaymentTerm'];			
		}else if($OrderSource=='amazon'){
			$AccountID1 = $objJournal->getSettingVariable('AmazonAccount');	
			$AccountID2 = $objJournal->getSettingVariable('AmazonEbayFee');
		}else if($OrderSource=='ebay'){
			$AccountID1 = $objJournal->getSettingVariable('EbayAccount');
			$AccountID2 = $objJournal->getSettingVariable('AmazonEbayFee');
		}else if($OrderSource=='hostbill'){
			$ReferenceID = $arryRow[0]['InvoiceID'];
			$AccountID1 = $objJournal->getSettingVariable('AccountReceivable');//credit
			$AccountID2 = $objJournal->getSettingVariable('HostbillFee');//debit
		}else if($OrderSource=='pos'){
			$AccountID1 = $objJournal->getSettingVariable('PosAccount');
			$AccountID2 = $objJournal->getSettingVariable('PosFee');
		}
		$AccDeatail1 = $objBankAccount->getAccountNameByID($AccountID1);
	
		# for Credit
		
		$AccDeatail2 = $objBankAccount->getAccountNameByID($AccountID2);

		if(!empty($AccDeatail1[0]['AccountNumber']) && !empty($AccDeatail2[0]['AccountNumber'])){
			$Fee = GetConvertedAmount($arryRow[0]['ConversionRate'], $arryRow[0]['Fee']); 
			$arryRow[0]['Fee'] = round($Fee,2);

			$arryDetails = array(
				'JournalMemo'=>$OrderSource.'-'.$arryRow[0]['InvoiceID'],
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



 

  function  InvoiceMarginReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{ 
                         global $Config;
                        
			    $strAddQuery = "";
		   
		  
		 if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			}
				
			
 					
		   $strSQLQuery = "select o.InvoiceDate,o.InvoiceID,o.SaleID,o.OrderID, o.CustomerCurrency,o.SalesPersonID, o.ConversionRate,o.TotalAmount,o.TotalInvoiceAmount,o.Freight, o.TDiscount,  o.Fee,o.TrackingNo,p.PurchaseID,p.OrderID as PID , (SELECT SUM(od.amount) FROM s_order_item od WHERE o.OrderID = od.OrderID and o.Module='Invoice' and od.OrderID>'0' and od.amount>'0') AS SubTotal   from s_order o left join p_order p on p.SaleID = o.SaleID  where o.Module='Invoice'   ".$strAddQuery." group by o.InvoiceID order by o.InvoiceDate desc";	
			             return $this->query($strSQLQuery, 1);		
		}



function InvoiceSubTotal($OrderID){


 $strSQL = "select SUM(TotalAmount) as amount from s_order where OrderID = '".$OrderID."' and Module='Invoice' ";
$rs = $this->query($strSQL, 1);

return $rs[0]['amount'];
}


function InvoiceCostTotal($OrderID){


$strSQL = "SELECT IF(i.avgCost!='',SUM(i.avgCost*i.qty_invoiced), SUM(i.DropshipCost*i.qty_invoiced)) as Cost,SUM(i.qty_invoiced) as inv_qty from s_order_item i where i.OrderID = '".trim($OrderID)."' ";


return $this->query($strSQL, 1);
}

	function GetFeeOrder($OrderID){

	$strSQLQuery = "SELECT s.OrderID,s.Fee from s_order s where s.OrderID = '".trim($OrderID)."' and s.PostToGL != '1' ";
		return $this->query($strSQLQuery, 1);
	}






	/******************************Abbas********************/
     
 		function  statementReportList($CustCode,$OrderID)
		{ 
             		global $Config;
			$strAddQuery = $innerSql="";
			if(!empty($CustCode)){
				$strAddQuery .= " and o.CustCode='".$CustCode."'";
				$innerSql = " and p.CustCode='".$CustCode."'";
				$Asc = 'Desc';
			}else{
				$Asc = 'ASC';
			}
			if(!empty($OrderID)){
				$strAddQuery .= " and o.OrderID in ('".$OrderID."')";	
			}
		 

$ReceiveAmntSql = ",if(o.Module='Invoice',
(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.CustID>'0' and p.PostToGL ='Yes' and (p.InvoiceID=o.InvoiceID and p.InvoiceID !='') ".$innerSql." and  p.PaymentType in('Sales','Other Income'))
,
(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.CustID>'0' and p.PostToGL ='Yes' and (p.CreditID=o.CreditID and p.CreditID !='') ".$innerSql." and  p.PaymentType in('Sales','Other Income'))
) as ReceiveAmnt";


$ReceiveAmntSql .= ",if(o.Module='Invoice',
(SELECT SUM(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.CustID>'0' and p.PostToGL ='Yes' and (p.InvoiceID=o.InvoiceID and p.InvoiceID !='') ".$innerSql." and  p.PaymentType in('Sales','Other Income'))
,
(SELECT SUM(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.CustID>'0' and p.PostToGL ='Yes' and (p.CreditID=o.CreditID and p.CreditID !='') ".$innerSql." and  p.PaymentType in('Sales','Other Income'))
) as ReceiveOrigAmnt";

/************
$ReceiveAmntSql = ",(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.PostToGL ='Yes' and ((p.InvoiceID=o.InvoiceID and o.Module='Invoice' and p.InvoiceID !='') OR (p.CreditID=o.CreditID and o.Module='Credit' and p.CreditID !='')) ".$innerSql." and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt ";

$ReceiveAmntSql .= ",(SELECT SUM(DECODE(OriginalAmount,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID  and p.PostToGL ='Yes' and ((p.InvoiceID=o.InvoiceID and o.Module='Invoice' and p.InvoiceID !='') OR (p.CreditID=o.CreditID and o.Module='Credit' and p.CreditID !='')) ".$innerSql." and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveOrigAmnt ";
/************/
			  $strSQLQuery = "select distinct(o.OrderID) as OrderID, o.InvoiceDate, o.PostedDate, o.Module, c.Cid as CustID, o.PaymentTerm, c.CreditLimit, c.Landline, c.CreditLimitCurrency, c.Currency as CustCurrency,  o.CustCode, o.InvoiceID,  o.CreditID, o.InvoiceEntry, o.SaleID, o.InvoicePaid , o.ConversionRate, o.OverPaid, o.CustomerCurrency,o.PdfFile,  o.TotalInvoiceAmount ,o.TotalAmount ,ab.FullName as ContactPerson,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as Customer ".$ReceiveAmntSql." from s_order o  left outer join s_customers c on  o.CustCode =  c.CustCode left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1' ) where ((o.InvoicePaid!='Paid' and o.Module='Invoice') OR (o.Status!='Completed' and o.Module='Credit' and o.OrderPaid='0')) and o.PostToGL='1' ".$strAddQuery." having Customer!='' order by Customer asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END ".$Asc."  ,o.OrderID ".$Asc;
			return $this->query($strSQLQuery, 1);		
		}
		
		
		function GetStatementContactEmail($id){
	    
		    $sql="SELECT Email FROM `s_address_book` WHERE `CustID` = '".$id."' && `AddType`='contact' &&  Statement='1'";
		    return $this->query($sql, 1);	
		}

		function statementEmail($arryDetails,$CustID,$OrderIDArray,$CC)
		{     
			global $Config;				
			extract($arryDetails);
			$objBankAccount = new BankAccount();

			 if($CustID>0){
				/************************/
				$arryContactEmail = $this->GetStatementContactEmail($CustID);
				$ToEmail = $arryContactEmail[0]['Email'];				
				
				$arryCustEmail = $objBankAccount->GetCustomer($CustID,'','');
				$CustCode = $arryCustEmail[0]['CustCode'];
				if(empty($ToEmail)){
					$ToEmail = $arryCustEmail[0]['Email'];
				}
				/************************/
				if(!empty($CustCode)){

				 

				$OrderIDVal = implode("','",$OrderIDArray);
				
				#$arryStatement = $this->statementReportList('',$OrderIDVal);
				$arryStatement = $this->statementReportList($CustCode,'');

 
				$InvoiceData = '<table border="1" cellspacing="1" cellpadding="1" width="700">
					    	<tr align="left">
						    <td width="25%" class="head1">Invoice Date</td>
						    <td width="20%" class="head1">Invoice/Credit Memo #</td>
						  
						    <td width="20%" class="head1">Balance in Customer Currency</td>
						    <td class="head1">Balance ['.$Config['Currency'].']</td>
						</tr>';

 				unset($AttachArray);
				foreach($arryStatement as $key=>$values){	

					$ConversionRate=1;
					if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
						$ConversionRate = $values['ConversionRate'];			   
					}

					$ModuleDate=''; $ModuleLink='';$orginalAmount=0;
					if($values['Module']=='Invoice'){
						$orginalAmount = $values['TotalInvoiceAmount'];
						$ModuleDate=$values['InvoiceDate'];
						if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
							$ModuleLink=$values["InvoiceID"];
						}else{
							$ModuleLink=$values["InvoiceID"];
						}
					}else if($values['Module']=='Credit'){
						$orginalAmount = -$values['TotalAmount'];
						$ModuleDate=$values['PostedDate'];
						if($values['OverPaid']=='1'){
						 	$ModuleLink=$values["InvoiceID"];
						}else{
							$ModuleLink=$values["CreditID"];
						}
					} 
					$OrderAmount = $orginalAmount;
					$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 
 
					$PaidAmnt = $values['ReceiveAmnt']; 				

					if($PaidAmnt !=''){
					    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
					    
					}else{
					    $UnpaidInvoice = $orginalAmount;  
					}
					
					/********CC: Customer Currency************/		
					$PaidAmntCC = $values['ReceiveOrigAmnt']; 
					if($PaidAmntCC !='' ){
					    $BalanceCC = $OrderAmount-$PaidAmntCC;                    
					}else{
					    $BalanceCC = $OrderAmount;  
					}
					/********************/
					if($values['CustomerCurrency']!=$Config['Currency']){
						$BalanceCC_Html = number_format($BalanceCC,2).' '.$values['CustomerCurrency'];
					}else{
						$BalanceCC_Html = '';
					}


			 		$TotalUnpaidInvoice +=$UnpaidInvoice;
					
					$InvoiceData .= '<tr align="left">
							<td>'.date($Config['DateFormat'], strtotime($ModuleDate)).'</td>    
							<td>'.$ModuleLink.'</td> 
							 
							<td>'.$BalanceCC_Html.'</td>  
							<td>'.number_format($UnpaidInvoice,2).' '.$Config['Currency'].'</td>  
						</tr>';
					
					
					if($_POST['AttachPdf']==1 && in_array($values['OrderID'], $OrderIDArray)){
						$Module = $values['Module'];
						$InvoiceEntry = $values['InvoiceEntry'];
						 
						
	if($Module=='Invoice'){
		$PdfFolder = $Config['S_Invoice'];
		$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
		if($InvoiceEntry == "2" || $InvoiceEntry == "3"){
			$file_name = "SalesInvoiceGl-".$values["InvoiceID"].".pdf";	 
		}else{
			$file_name = "SalesInvoice-".$values["InvoiceID"].".pdf";			
		}		
	}else if($Module=='Credit'){
		$PdfFolder = $Config['S_Credit'];
		$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
		$file_name = "SalesCreditMemo-".$values["CreditID"].".pdf"; 
	}	
	$file_path = $PdfDir.$file_name;
	/**************/
	if($Config['ObjectStorage']=="1"){
		copy($Config['OsUploadUrl'].$Config['OsDir']."/".$PdfFolder.$file_name, $file_path);
	}
	/**************/
	$AttachArray[] = $file_path;
	
					}
				 }

 #pr($AttachArray,1);
				$InvoiceData .= ' <tr class="oddbg">
					    <td align="right" colspan="3"><b>Total : </b></td>
					    <td align="left">'.number_format($TotalUnpaidInvoice,2).' '.$Config['Currency'].'</td>
					</tr>
				    </tbody>
				</table>';
				 
			 	//if($_GET['pk']==1){echo $ToEmail.'<pre>';echo $InvoiceData;exit;}
		 	        $objConfigure = new configure();
				$TemplateContent = $objConfigure->GetTemplateContent(77, 1);
        			$contents = $TemplateContent[0]['Content'];

				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[CUSTOMER_NAME]",stripslashes($arryStatement[0]["Customer"]), $contents);
				$contents = str_replace("[INVOICE_DATA]",$InvoiceData,$contents);					
		               	
				if($_SESSION['AdminType']=='employee'){
					$SenderName = $_SESSION['UserName'];
					$SenderEmail = $_SESSION['EmpEmail'];
				}else{
					$SenderName = $Config['SiteName'];
					$SenderEmail = $Config['AdminEmail'];
				}
			 
									
				//$ToEmail = 'parwez.khan@vstacks.in';
 
				if(!empty($ToEmail)){
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($ToEmail);
					if(!empty($CC)) $mail->AddAddress($CC);
					$mail->sender($SenderName, $SenderEmail);   
					$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
					foreach($AttachArray as $Attachment){
						$mail->AddAttachment($Attachment);				 
					}		
					$mail->IsHTML(true);
					$mail->Body = $contents;			 
				    
					if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
						$mail->Send();						
					}
					$_SESSION['EmailSentList'][] = $ToEmail;
				}else{
					 
					$_SESSION['Email_Not_Exist'][] = stripslashes($arryStatement[0]["Customer"]);

				}	



			    }
				
				
			 }
			return 1;
		}
		
		
		

 

	 function  GetStatementPdf($OrderID,$result)
		{    //	echo $OrderID;die;
			 //$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			//$strAddQuery .= (!empty($CustID))?(" and o.CustID='".$CustID."'"):("");
			//$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			  $strSQLQuery = "select o.*,e.Email as CreatedByEmail,c.Email as CustomerEmail from s_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') left outer join s_customers c on o.CustCode=c.CustCode where o.OrderID='".$OrderID."'  order by o.OrderID desc";
			//echo $strSQLQuery;die;
			
			$data = $this->query($strSQLQuery, 1);
			
			return $this->query($strSQLQuery, 1);
		}	

	/***************************End******************************/


	function UpdateTransactionPosttogl(){
			global $Config;			
		 	$strSQLPay = " select t.* from f_transaction t inner join f_transaction_data d on (t.TransactionID=d.TransactionID) inner join f_payments p on t.TransactionID=p.TransactionID where t.PaymentType = 'Purchase' and t.PostToGL != 'Yes' ORDER BY t.PostToGL desc, t.PaymentDate desc,t.TransactionID desc";
                	$arryPayment = $this->query($strSQLPay, 1);  
	//echo '<pre>';print_r($arryPayment);exit;
			foreach($arryPayment as $values){
				/*************************/
					$strSQLIn = "select ExpenseID from f_payments where PID='".$values['PaymentID']."' and PostToGL != 'Yes' ";
					$arryExpense = $this->query($strSQLIn, 1);
	
					if($arryExpense[0]['ExpenseID']>0){
					   $delSQLQuery = "delete from f_expense where ExpenseID = '".$arryExpense[0]['ExpenseID']."'"; 
					   $this->query($delSQLQuery, 0);
					}
			
					 
					$delSQLPay = "delete from f_payments where PaymentID = '".$values['PaymentID']."' and PostToGL != 'Yes'";
					$this->query($delSQLPay, 0);

					$delSQLPay2 = "delete from f_payments where PID = '".$values['PaymentID']."' and PostToGL != 'Yes'";
					$this->query($delSQLPay2, 0);
			

					if($values['AdjID']>0){
						$delSQLAdj = "delete from f_adjustment where AdjID = '".$values['AdjID']."'";
						$this->query($delSQLAdj, 0);

						$delSQLAdj2 = "delete from f_multi_adjustment where AdjID = '".$values['AdjID']."'";
						$this->query($delSQLAdj2, 0);
					}



					if(!empty($values['InvoiceID'])){				
						 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where InvoiceID='".$values['InvoiceID']."' and PaymentID!='".$values['PaymentID']."' and PaymentType='Purchase'  ";
						$arryPaymentOther = $this->query($strSQLPayOther, 1); 

						if($arryPaymentOther[0]['NumPay']>0){
							$InvoicePaid = 2;
						}else{
							$InvoicePaid = 0;
						}

						$strQueryUp = "update p_order set InvoicePaid = '".$InvoicePaid."' where InvoiceID='".$values['InvoiceID']."' and Module='Invoice'";
		                		$this->query($strQueryUp, 0);
					}
			
					if(!empty($values['PurchaseID'])){
			   			$strQueryUpd = "update p_order set InvoicePaid = '".$InvoicePaid."' where PurchaseID='".$values['PurchaseID']."' and Module='Order'";
						$this->query($strQueryUpd, 0);
					}

					if(!empty($values['CreditID'])){				
						 $strSQLPayOther = " Select count(PaymentID) as NumPay from f_payments where CreditID='".$values['CreditID']."' and PaymentID!='".$values['PaymentID']."' and PaymentType='Purchase'  ";
						$arryPaymentOther = $this->query($strSQLPayOther, 1); 

						if($arryPaymentOther[0]['NumPay']>0){
							$Status = 'Part Applied';
						}else{
							$Status = 'Open';
						}


						$strQueryUp = "update p_order set Status = '".$Status."' where CreditID='".$values['CreditID']."' and Module='Credit'";
						$this->query($strQueryUp, 0);
					}
			/*************************/
			}

			 $strSQLQue = "update f_transaction set PostToGL = 'Yes',PostToGLDate='".$gldate."' WHERE TransactionID in(".$TransactionID.") and PostToGL != 'Yes'";		 
    			$this->query($strSQLQue, 0);

	
		         
                	return true;
            }



	

/********************************************************************/
function CronInvoicePostToGL55555555($arryPostData){
	global $Config;
	extract($arryPostData);
	$objItem=new items();
	$objBankAccount = new BankAccount();
 	$objConfigure=new configure();
	$ipaddress = GetIPAddress(); 	

	$PosFeePercentage = $objConfigure->getSettingVariable('POS_PROVIDER_FEE');
 

	//$addSql = " and InvoiceID='INV3591'";  

	//Posted but Unpaid
	$strSQL = "select OrderID,InvoiceID,TotalInvoiceAmount,InvoiceDate  from s_order where Module='Invoice' and OrderSource in('POS') and EntryBy = 'C' and PostToGL='1' and InvoiceID!='' and InvoicePaid='Unpaid' and InvoiceDate<'2017-07-14' ".$addSql." order by InvoiceDate ASC, OrderID ASC  ";
	
	//Posted but Paid for fee only
	#$strSQL = "select OrderID,InvoiceID,TotalInvoiceAmount,InvoiceDate  from s_order where Module='Invoice' and OrderSource in('POS') and EntryBy = 'C' and PostToGL='1' and InvoiceID!='' and InvoicePaid='Paid' and Fee<=0 and InvoiceDate>'2017-07-13' and InvoiceDate<'2017-07-20' ".$addSql." order by InvoiceDate ASC, OrderID ASC  ";

	//UNPosted but Unpaid for fee only
	#$strSQL = "select OrderID,InvoiceID,TotalInvoiceAmount,InvoiceDate  from s_order where Module='Invoice' and OrderSource in('POS') and EntryBy = 'C' and PostToGL!='1' and InvoiceID!='' and InvoicePaid='Unpaid' and Fee<=0 and InvoiceDate<'2017-07-14' ".$addSql." order by InvoiceDate ASC, OrderID ASC  ";



	$arryTop = $this->query($strSQL, 1);
	//echo '<pre>';print_r($arryTop);exit;
	foreach ($arryTop as $key => $values) {
		$OrderID = $values['OrderID'];
		$InvoiceID = $values['InvoiceID'];
		$TotalInvoiceAmount =  $values['TotalInvoiceAmount'];
		/*$Fee = round((($TotalInvoiceAmount*$PosFeePercentage)/100),2);
 
		$strSQLQue = "update s_order set Fee='".$Fee."' WHERE OrderID=".$OrderID." and Fee<=0" ;		 
		$this->query($strSQLQue, 0);*/
		 
		
					$strSQLQuery = "SELECT s.*,i.GlEntryType,i.IncomeTypeID from s_order s left outer join f_income i on s.IncomeID=i.IncomeID where s.OrderID = '".trim($OrderID)."'  ";
					$arryRow = $this->query($strSQLQuery, 1);
 
					 

					$TotalAmount = $arryRow[0]['TotalInvoiceAmount'];
					$OrderSource = strtolower($arryRow[0]['OrderSource']);
					$IncomeID = $arryRow[0]['IncomeID'];
					$InvoiceConversionRate = $arryRow[0]['ConversionRate'];
					$EntryBy = $arryRow[0]['EntryBy']; //C for Cron
					 
					if(empty($InvoiceConversionRate)) $InvoiceConversionRate=1;
					$PaymentType = ($arryRow[0]['InvoiceEntry']>=1)?('Customer Invoice Entry'):('Customer Invoice');
					$ConversionRate=1;
					if($TotalAmount>0 && $arryRow[0]['CustomerCurrency']!=$Config['Currency']){
						$ConversionRate=CurrencyConvertor(1,$arryRow[0]['CustomerCurrency'],$Config['Currency'],'AR');	
						//$ConversionRate=$arryRow[0]['ConversionRate'];		
					}
				 

					
					/*******************/
					$CreateCashReceipt = 0;
					if($PosFlag==1 && $EntryBy=='C' && $OrderSource=='pos'){
						$CreateCashReceipt = 1;
					}
 
					if($CreateCashReceipt==1){
						$arryRow[0]['ConversionRate'] = $InvoiceConversionRate;	
						 
						$this->CreateCashReceiptDirect($arryRow); 
						if($arryRow[0]['Fee']>0){
							$this->CreateGeneralEntryDirect($arryRow);
	
						}
					}	
					/*******************/
					echo '<br><br>Done for : '.$InvoiceID;die;  

		}//end foreach 
        	exit;
        }


 function  licenseeReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{ 
                         global $Config;
                        
			    $strAddQuery = "";
		   
		  
		 if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			}
				
			
 					
		   $strSQLQuery = "select o.InvoiceDate,o.InvoiceID,o.SaleID,o.OrderID, o.CustomerCurrency,o.SalesPersonID, o.ConversionRate,o.TotalAmount,o.TotalInvoiceAmount,o.Fee,o.TrackingNo,o.CustomerPO,o.CustomerName from s_order o   where o.module='Invoice'   ".$strAddQuery." group by o.InvoiceID order by o.InvoiceDate desc";	
			             return $this->query($strSQLQuery, 1);		
		}


		
 	function GetSalesTaxRate($Type){
		$strAddQuery=''; 
		if($Type=='Tax') $strAddQuery .= " and ReturnID=''  "; //and taxAmnt > 0
		 $strSQLQuery = "select distinct(TaxRate) AS TaxRateValue from s_order where Module='Invoice' and TaxRate!='' ".$strAddQuery." order by TaxRate Asc";
		return $this->query($strSQLQuery, 1);		
	
	 }
	function GetPurchaseTaxRate($Type){  
		$strAddQuery=''; 
		if($Type=='Tax') $strAddQuery .= " and ReturnID=''  "; //and taxAmnt > 0
		 $strSQLQuery = "select distinct(TaxRate) AS TaxRateValue from p_order where Module='Invoice' and TaxRate!='' ".$strAddQuery." order by TaxRate Asc";
		return $this->query($strSQLQuery, 1);		
	
	 }

	function  SalesTaxReportLocation($arryDetails){ 
		global $Config;
		
		extract($arryDetails);
		 

		$strAddQuery = "";

		if($fby=='Year'){
			#$strAddQuery .= " and YEAR(o.InvoiceDate)='".$y."'";
			
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE  ( YEAR(o.InvoiceDate)='".$y."') END ";
		}else if($fby=='Month'){
			#$strAddQuery .= " and MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."'";

			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE  (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";

		}else{
			#$strAddQuery .= (!empty($f))?(" and o.InvoiceDate>='".$f."'"):("");
			#$strAddQuery .= (!empty($t))?(" and o.InvoiceDate<='".$t."'"):("");
			
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE  (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";
			

		}
		$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");

		if($st=='1'){			 
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status in ('Completed') ) ELSE  (o.InvoicePaid in ('Paid') ) END ";
			
		}else if($st=='2'){
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status not in ('Completed') ) ELSE  (o.InvoicePaid not in ('Paid') ) END ";
		}



		if($rby=='L'){
			#$strAddQuery .= (!empty($Location))?(" and LCASE(o.ShippingCountry)='".strtolower(trim($Location))."'"):("");
			#$OrderBy = ' order by o.ShippingCountry asc, o.InvoiceDate Desc ,o.OrderID Desc';
			if(!empty($Tax)){
				$arrTx = explode(":",$Tax);
				$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
				$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
			}
			$OrderBy = " order by o.TaxRate asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END ,o.OrderID Asc";

		}else{
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$OrderBy = " order by CustomerName asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END ,o.OrderID Asc ";
		}
		

		  $strSQLQuery = "select o.CustCode,o.InvoiceDate, o.Module, o.PostedDate, o.CustID,o.InvoiceID, o.CreditID,o.AccountID, o.TaxRate, o.PaymentTerm, o.SaleID,o.OrderID, o.CustomerCurrency as InvoiceCurrency, o.ConversionRate,o.TotalAmount, o.TotalInvoiceAmount, c.Mobile, c.Landline, o.ReturnID, o.taxAmnt , o.Freight, o.ShipFreight, o.TDiscount, o.freightTxSet, IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName, (SELECT SUM(od.amount) FROM s_order_item od WHERE o.OverPaid='0' and o.OrderID = od.OrderID and o.Module in ('Invoice','Credit') and od.OrderID>'0' and od.amount>'0' and od.Taxable='Yes' and o.taxAmnt>'0') AS TaxableSalesLine  from s_order o  left outer join s_customers c on  o.CustCode =  c.CustCode  where o.OverPaid='0' and o.Module in ('Invoice', 'Credit') ".$strAddQuery.$OrderBy;   //and o.TaxRate>0 

		//and o.taxAmnt > 0

		if(!empty($_GET['pk'])) {echo $strSQLQuery;}
		return $this->query($strSQLQuery, 1);		
	}

	function  GrossSalesTaxLocation($arryDetails,$Type,$Module){ 
		global $Config;
		extract($arryDetails);
		
		$strAddQuery = "";
		
		if($fby=='Year'){
			#$strAddQuery .= " and YEAR(o.InvoiceDate)='".$y."'";
			
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE  ( YEAR(o.InvoiceDate)='".$y."') END ";
		}else if($fby=='Month'){
			#$strAddQuery .= " and MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."'";

			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE  (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";

		}else{
			#$strAddQuery .= (!empty($f))?(" and o.InvoiceDate>='".$f."'"):("");
			#$strAddQuery .= (!empty($t))?(" and o.InvoiceDate<='".$t."'"):("");
			
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE  (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";
			

		}

		if($st=='1'){			 
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status in ('Completed') ) ELSE  (o.InvoicePaid in ('Paid') ) END ";
			
		}else if($st=='2'){
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status not in ('Completed') ) ELSE  (o.InvoicePaid not in ('Paid') ) END ";
		}

		if($rby=='L'){
			#$strAddQuery .= (!empty($Location))?(" and LCASE(o.ShippingCountry)='".strtolower(trim($Location))."'"):("");		 
			 
			if(!empty($Tax)){
				$arrTx = explode(":",$Tax);
				$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
				$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
			}

		}else{
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
		}
		
		if($Module=="Invoice"){
			$col = 'o.TotalInvoiceAmount';
		}else{
			$col = 'o.TotalAmount';
		}	
		
		if($Type=='Gross'){			
			$selectCol = "(".$col."-o.taxAmnt-o.Freight-o.ShipFreight+o.TDiscount)";
			#$strAddQuery .=  " and o.TaxRate > '0' ";
			$strAddQuery .=  " and o.taxAmnt > '0' ";
		}else if($Type=='Exempt'){			
			$selectCol = "(".$col."-o.taxAmnt-o.Freight-o.ShipFreight+o.TDiscount)";
			$strAddQuery .=  " and o.taxAmnt <= '0' ";
			//$strAddQuery .=  " and o.TaxRate <= '0' ";
		}else if($Type=='Taxabale'){
			$selectCol = 'o.taxAmnt';
			//$strAddQuery .=  " and o.TaxRate>'0' ";  //and o.taxAmnt > 0 
		}else if($Type=='TaxCol'){
			$selectCol = 'o.taxAmnt';
			//$strAddQuery .=  " and o.TaxRate>'0' and o.PostToGL='1' ";  // and o.taxAmnt > 0 
			$strAddQuery .=  " and o.PostToGL='1' ";  // and o.taxAmnt > 0 
		}
		
			
		if($Config['ConversionType']==1){
			$ConvertedAmount =  $selectCol."/o.ConversionRate" ;
		}else{
			$ConvertedAmount = $selectCol."*o.ConversionRate";
		}


 		$strSQLQuery = "select sum(if(o.CustomerCurrency!='".$Config['Currency']."' ,".$ConvertedAmount.", ".$selectCol.")) as TotalAmount  from s_order o  where o.OverPaid='0' and o.Module='".$Module."'  ".$strAddQuery."  ";	
		$arryRow =  $this->query($strSQLQuery, 1);

		//if($Type=='Exempt'){echo $strSQLQuery.'<br><br>';}
		return $arryRow[0]['TotalAmount'];
	}


	function  PurchaseTaxReportLocation($arryDetails){ 
		global $Config;
		
		extract($arryDetails);
		 

		$strAddQuery = "";

		if($fby=='Year'){
			$strAddQuery .= " and YEAR(o.PostedDate)='".$y."'";
		}else if($fby=='Month'){
			$strAddQuery .= " and MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."'";
		}else{
			$strAddQuery .= (!empty($f))?(" and o.PostedDate>='".$f."'"):("");
			$strAddQuery .= (!empty($t))?(" and o.PostedDate<='".$t."'"):("");
		}
		
		if($st=='1'){			 
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status in ('Completed') ) ELSE  (o.InvoicePaid in ('1') ) END ";
			
		}else if($st=='2'){
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status not in ('Completed') ) ELSE  (o.InvoicePaid not in ('1') ) END ";
		}

		if($rby=='L'){
			#$strAddQuery .= (!empty($Location))?(" and LCASE(o.ShippingCountry)='".strtolower(trim($Location))."'"):("");
			#$OrderBy = ' order by o.ShippingCountry asc, o.PostedDate Desc ,o.OrderID Desc';
			if(!empty($Tax)){
				$arrTx = explode(":",$Tax);
				$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
				$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
			}
			$OrderBy = ' order by o.TaxRate asc, o.PostedDate Asc ,o.OrderID Asc';

		}else{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$OrderBy = ' order by CustomerName asc, o.PostedDate Asc ,o.OrderID Asc';
		}
		 

		$strSQLQuery = "select o.SuppCode, o.SuppCode as CustCode, o.PostedDate, o.PostedDate as InvoiceDate,o.InvoiceID, o.CreditID, o.AccountID, o.Module , o.TaxRate, o.PaymentTerm, o.PurchaseID,o.OrderID, o.Currency as InvoiceCurrency, o.ConversionRate,o.TotalAmount ,o.TotalAmount as TotalInvoiceAmount, s.Mobile, s.Landline, o.ReturnID, o.taxAmnt , o.Freight, o.PrepaidAmount as ShipFreight, o.AdjustmentAmount, o.freightTxSet,IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as CustomerName, (SELECT SUM(od.amount) FROM p_order_item od WHERE o.OrderID = od.OrderID and o.OverPaid='0' and o.Module in ('Invoice','Credit') and od.OrderID>'0' and od.amount>'0' and od.Taxable='Yes' and o.TaxRate>'0') AS TaxableSalesLine  from p_order o  left outer join p_supplier s on  o.SuppCode =  s.SuppCode  where o.OverPaid='0'  and o.Module in ('Invoice','Credit')  ".$strAddQuery.$OrderBy;  //and o.TaxRate>0 

		 //and o.taxAmnt > 0

		return $this->query($strSQLQuery, 1);		
	}


	function  GrossPurchaseTaxLocation($arryDetails,$Type,$Module){ 
		global $Config;
		extract($arryDetails);
		
		$strAddQuery = "";
		
		if($fby=='Year'){
			$strAddQuery .= " and YEAR(o.PostedDate)='".$y."'";
		}else if($fby=='Month'){
			$strAddQuery .= " and MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."'";
		}else{
			$strAddQuery .= (!empty($f))?(" and o.PostedDate>='".$f."'"):("");
			$strAddQuery .= (!empty($t))?(" and o.PostedDate<='".$t."'"):("");
		}

		if($st=='1'){			 
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status in ('Completed') ) ELSE  (o.InvoicePaid in ('1') ) END ";
			
		}else if($st=='2'){
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.Status not in ('Completed') ) ELSE  (o.InvoicePaid not in ('1') ) END ";
		}

		if($rby=='L'){
			#$strAddQuery .= (!empty($Location))?(" and LCASE(o.ShippingCountry)='".strtolower(trim($Location))."'"):("");		 
			 
			if(!empty($Tax)){
				$arrTx = explode(":",$Tax);
				$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
				$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
			}

		}else{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
		}
		

		$Col = 'o.TotalAmount';


		if($Type=='Gross'){
			//$selectCol = $Col;
			$selectCol = "(o.TotalAmount-o.taxAmnt-o.Freight-o.PrepaidAmount-o.AdjustmentAmount)";
			$strAddQuery .=  " and o.TaxRate > '0' ";
		}else if($Type=='Exempt'){
			//$selectCol = $Col;
			$selectCol = "(o.TotalAmount-o.taxAmnt-o.Freight-o.PrepaidAmount-o.AdjustmentAmount)";
			//$strAddQuery .=  " and o.taxAmnt <= '0' ";
			$strAddQuery .=  " and o.TaxRate <= '0' ";
		}else if($Type=='Taxabale'){
			$selectCol = 'o.taxAmnt';
			$strAddQuery .=  " and o.TaxRate>'0' ";  //and o.taxAmnt > 0 
		}else if($Type=='TaxCol'){
			$selectCol = 'o.taxAmnt';
			$strAddQuery .=  " and o.TaxRate>'0' and o.PostToGL='1' ";  // and o.taxAmnt > 0 
		}
		
			
		if($Config['ConversionType']==1){
			$ConvertedAmount =  $selectCol."/o.ConversionRate" ;
		}else{
			$ConvertedAmount = $selectCol."*o.ConversionRate";
		}


 		$strSQLQuery = "select sum(if(o.Currency!='".$Config['Currency']."' ,".$ConvertedAmount.", ".$selectCol.")) as TotalAmount  from p_order o  where o.OverPaid='0' and o.Module='".$Module."'  ".$strAddQuery."  ";	
		$arryRow =  $this->query($strSQLQuery, 1);

		//if($Type=='Exempt'){echo $strSQLQuery.'<br><br>';}
		return $arryRow[0]['TotalAmount'];
	}



	function PrepaidFreightAmountUpdate555($arryPostData){
		global $Config;
		extract($arryPostData);
		 $ipaddress = GetIPAddress(); 
		$Module='Invoice';
		$strSQL = "SELECT o.*, (SELECT SUM(od.amount) FROM p_order_item od WHERE o.OrderID = od.OrderID and o.Module='".$Module."' and od.OrderID>'0' and od.amount>'0') AS Subtotal  FROM `p_order` o WHERE o.Module='".$Module."' AND o.PrepaidFreight = '1' and  o.PurchaseID !='' AND o.PrepaidAmount > '0' and o.PostToGL = '1' order by OrderID desc "; 
		$arryP = $this->query($strSQL, 1);
		$updateCount=0;
		$PaymentType = 'Vendor Invoice';
		
		foreach($arryP as $key => $values) {
			if(!empty($values['OrderID'])){
				$PrepaidAmount = $values['PrepaidAmount'];
				
				$TotalAmount = $values['Subtotal'] + $values['Freight'] + $values['taxAmnt'];
				#$TotalAmount2 = $values['TotalAmount'] - $values['PrepaidAmount'];
				$SubTotal = ($TotalAmount - $values['taxAmnt']) + $PrepaidAmount;	

				//echo $values['InvoiceID'].'<br><br>';

				//&& round($values['TotalAmount'],2) != round($TotalAmount,2)

				if($TotalAmount>0 && $PrepaidAmount>0){

					/*$strSQLQuery = "update p_order set TotalAmount = '".$TotalAmount."' WHERE OrderID ='".$values['OrderID']."' ";
					$this->query($strSQLQuery, 0);
					/*****************/
					$strAp= "select p.PaymentID,p.PaymentDate from f_payments p where ReferenceNo='".$values['InvoiceID']."' and  SuppCode = '".$values['SuppCode']."' and PaymentType='".$PaymentType."' and AccountID = '".$AccountPayable."' "; 
					$arryAp = $this->query($strAp, 1);
					$apPaymentID = $arryAp[0]['PaymentID'];


					$strInv= "select p.PaymentID,p.PaymentDate from f_payments p where ReferenceNo='".$values['InvoiceID']."' and  SuppCode = '".$values['SuppCode']."' and PaymentType='".$PaymentType."' and AccountID = '".$InventoryAP."' "; 
					$arryInv = $this->query($strInv, 1);
					$invPaymentID = $arryInv[0]['PaymentID'];
					$Date = $arryInv[0]['PaymentDate'];

					/*****************/
					if($apPaymentID>0 && $invPaymentID>0){
						$ConversionRate=1;
						$ApAmount = $TotalAmount;	
						
						$PID = $invPaymentID;
						/******Update Inventory***********/
						$strSQLinv = "update f_payments set DebitAmnt  = ENCODE('".$SubTotal."','".$Config['EncryptKey']."'), OriginalAmount=ENCODE('".$SubTotal. "','".$Config['EncryptKey']."')  WHERE PaymentID ='".$invPaymentID."' ";
						$this->query($strSQLinv, 0);  

						/******Update AP***********/
						$strSQLAP = "update f_payments set CreditAmnt  = ENCODE('".$ApAmount."','".$Config['EncryptKey']."'), OriginalAmount=ENCODE('".$ApAmount. "','".$Config['EncryptKey']."')  WHERE PaymentID ='".$apPaymentID."' ";
						$this->query($strSQLAP, 0);  

						/******Insert Prepaid Freight***********/
												
						/*$strSQLQueryPr = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$PrepaidAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), InvoiceID='".$values['InvoiceID']."', ReferenceNo='".$values['InvoiceID']."', AccountID = '".$FreightExpense."',  SuppCode = '".$values['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."', ModuleCurrency = '".$values['Currency']."' , OriginalAmount=ENCODE('".$PrepaidAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
						$this->query($strSQLQueryPr, 0);*/

							
						echo $values['InvoiceID'].' :<br>'.$strSQLinv.' <br><br> '.$strSQLAP.'<br><br>';
						$updateCount++;
					}
				}
			}
		}

		echo $updateCount.' records are updated.';exit;
		
	}







	function CreditCardVendorPaidInvoice45656($arryPostData){
		global $Config;
		extract($arryPostData);
		$ipaddress = GetIPAddress(); 
		
		//$strAdd .= " and OrderID='2257' "; //comment this

		$strSQL = "select * from p_order where Module='Invoice' and PostToGL = '1' and PaymentTerm='Credit Card' and CreditCardVendor!='' and TotalAmount>0 and InvoicePaid not in (1,2) and InvoiceEntry in  (0,1) ".$strAdd." order by PostedDate asc "; //line item 

		

		$arryRow = $this->query($strSQL, 1);
		$updateCount=0;
		$PaymentType = 'Vendor Invoice';		
				
		pr($arryRow);exit;

		foreach($arryRow as $key => $values) {
			$values['ipaddress'] = $ipaddress;
			if(!empty($values['OrderID555'])){
				//check if credit card vendor gl invoice is created or not
				$strGL= "select o.OrderID, o.InvoiceID from p_order o inner join f_expense e on o.ExpenseID=e.ExpenseID where o.Module='Invoice' and o.InvoiceEntry='2' and o.SuppCode='".$values['CreditCardVendor']."' and o.TotalAmount='".$values['TotalAmount']."' and o.PurchaseID='".$values['PurchaseID']."' and e.ExpenseTypeID='".$AccountPayable."'  "; 
				
				$arryGL = $this->query($strGL, 1);
				$GLOrderID = $arryGL[0]['OrderID'];				
				if($GLOrderID>0){
					$values['GLOrderID'] = $GLOrderID;					
				}else{
					$values['GLOrderID'] = '';
				}
				 
				//$this->CreateCreditCardVendorInvoiceGL($values);

				echo '<br>'. $values['InvoiceID'].' = '. $values['PurchaseID'];exit; 
				$updateCount++;

			}
		}

		echo '<br>'.$updateCount.' records are updated.';exit;
		
	}



	function RemovePrepaidFreightAmount05646456($arryPostData){
		global $Config;
		extract($arryPostData);
		$ipaddress = GetIPAddress(); 
		
		//$strAdd .= " and OrderID='2257' "; //comment this

		$strSQL = 'select * from p_order where Module="Invoice" and TotalAmount<=0  and InvoiceEntry="2" order by OrderID Asc '; //line item 

		$arryRow = $this->query($strSQL, 1);
		$updateCount=0;
		if(empty($_GET['exc'])){ 				
			pr($arryRow);exit;
		}

		foreach($arryRow555 as $key => $values) {			 
			if(!empty($values['ExpenseID'])){
				$strSQLExp = "delete from f_expense where ExpenseID = '".$values['ExpenseID']."'"; 
				$this->query($strSQLExp, 0);	
			}
			$strSQLOrder = "delete from p_order where OrderID = '".$values['OrderID']."'"; 
			$this->query($strSQLOrder, 0);


			$strSQLPay = "delete from f_payments where ReferenceNo = '".$values['InvoiceID']."' and PaymentType='Vendor Invoice' "; 
			$this->query($strSQLPay, 0);	


			echo '<br><br>'. $values['InvoiceID'].' = '. $strSQLExp.' <br>'.$strSQLOrder.' <br>'.$strSQLPay;exit; 
			$updateCount++;
		}

		echo '<br>'.$updateCount.' records are updated.';exit;
		
	}



	
/********************************************************************/
function SoInvoiceAlreadyPostToGL($OrderID,$arryPostData){
	global $Config;
	extract($arryPostData);
	$objBankAccount = new BankAccount();
 
	$ipaddress = GetIPAddress(); 	
	if(!empty($AmountToCharge) && $AmountToCharge>0){
		$OrderPaid = ($BalanceAmount>0)?(4):(1);
		$strSQLQuery = "update s_order set PaymentTerm = '".$Config['PaymentTerm']."',OrderPaid = '".$OrderPaid."',BalanceAmount = '".$BalanceAmount."' WHERE OrderID ='".$OrderID."' ";
		$this->query($strSQLQuery, 0);
	}else{
		$strSQLQuery = "update s_order set PaymentTerm = '".$Config['PaymentTerm']."',BalanceAmount='0' WHERE OrderID ='".$OrderID."' ";
		$this->query($strSQLQuery, 0);
	}


	$strSQLQuery = "SELECT s.*,i.GlEntryType,i.IncomeTypeID from s_order s left outer join f_income i on s.IncomeID=i.IncomeID where s.OrderID = '".trim($OrderID)."' and PostToGL = '1' ";
	$arryRow = $this->query($strSQLQuery, 1);
	
	//echo '<pre>';print_r($arryRow);exit;
	
	$InvoiceConversionRate = $arryRow[0]['ConversionRate'];
	$EntryBy = $arryRow[0]['EntryBy']; //C for Cron
	if(empty($InvoiceConversionRate)) $InvoiceConversionRate=1;
	$Currency = $arryRow[0]['CustomerCurrency'];
	if($Currency!=$Config['Currency']){		
		$ConversionRate=$arryRow[0]['ConversionRate'];		
	}
 	if(empty($ConversionRate))$ConversionRate = 1;
			
	$CreateCashReceipt = 0;

	if($arryRow[0]['PaymentTerm']=='Credit Card' && ($arryRow[0]['OrderPaid']=="1" || $arryRow[0]['OrderPaid']=="4")){
		$CreateCashReceipt = 1;
		$arryRow[0]['CreditCardPayment'] = 1;		
	}

	if($CreateCashReceipt==1){
		$arryRow[0]['ConversionRate'] = $InvoiceConversionRate;
		$arryRow[0]['PostToGLDate'] = $PostToGLDate;
		/*****AmountToCharge from payInvoice.php*******/
		if(!empty($AmountToCharge) && $AmountToCharge>0){			
			$arryRow[0]['AmountToCharge'] = $AmountToCharge;
			$arryRow[0]['Fee'] = $Fee;		
		}
		/*****************************/
		$this->CreateCashReceiptDirect($arryRow); 
		if($arryRow[0]['Fee']>0){
			$this->CreateGeneralEntryDirect($arryRow);	
		}
	}	
		
	return true;
  }



/********************************************************************/
function UpdateRefNoForActualFreight(){
	global $Config;
	extract($arryPostData);
 
  	$objConfigure=new configure();
 
	$FreightAR = $objConfigure->getSettingVariable('FreightAR');
 
	//$addSql = " and InvoiceID='INV3591'";  
 
	echo $strSQL = "select o.InvoiceID,o.SaleID, o.InvoiceDate,o.ActualFreight, p.InvoiceID as ApInvoiceID,p.TotalAmount as PTotalAmount,p.OrderID as POrderID, p.ExpenseID  from s_order o inner join p_order p on (o.ActualFreight=p.TotalAmount) inner join f_expense e on (p.ExpenseID=e.ExpenseID and e.ExpenseTypeID='".$FreightAR."') where o.Module='Invoice' and o.InvoiceID!='' and o.ShippingMethod!='' and o.ShipAccountNumber!='' and o.SaleID!='' and o.ActualFreight>'0' and o.PostToGl='1' and o.InvoiceDate>'2017-07-25' and p.PostedDate>'2017-07-25' and p.PurchaseID='' ".$addSql." order by o.InvoiceDate ASC, o.OrderID ASC  ";
	$arryTop = $this->query($strSQL, 1);
	echo '<pre>';print_r($arryTop);exit;


		foreach ($arryTop as $key => $values) {
			$InvoiceID = $values['InvoiceID'];
			$ApInvoiceID = $values['ApInvoiceID'];

			$OrderID = $values['POrderID'];
			$ExpenseID = $values['ExpenseID'];
			$ReferenceNo = $values['SaleID'];
			 
	 
			$strSQLQue = "update p_order set PurchaseID='".$ReferenceNo."' WHERE OrderID=".$OrderID."" ;		 
			$this->query($strSQLQue, 0);

			$strSQLQue2 = "update f_expense set ReferenceNo='".$ReferenceNo."' WHERE ExpenseID=".$ExpenseID."" ;		 
			$this->query($strSQLQue2, 0);
			 		
						 
			echo '<br><br>Done for : '.$InvoiceID .' for P :'.$ApInvoiceID;  

		}//end foreach 
        	exit;
        }

	function getArInvoiceIDStatus($InvoiceID)
		{			
			 $strSQLQuery = "select InvoicePaid from s_order WHERE Module='Invoice' and InvoiceID='".$InvoiceID."' ";
			$rs = $this->query($strSQLQuery, 1);
			if(!empty($rs[0]['InvoicePaid'])) 
				return $rs[0]['InvoicePaid'];			
		}

	/*************************/
	 
    function TransactionPostForVendorCommission($TransactionID,$Date){
        global $Config;
        $objConfigure=new configure();
        $CommissionAp = $objConfigure->getSettingVariable('CommissionAp');  
        $CommissionFeeAccount = $objConfigure->getSettingVariable('CommissionFeeAccount');

        if($TransactionID>0 && !empty($CommissionAp) && !empty($CommissionFeeAccount)){ 
            $sql = "select o.OrderID, o.InvoiceID, o.ConversionRate, o.SalesPersonID, o.SalesPersonType, o.InvoiceEntry,o.VendorSalesPerson from s_order o inner join f_transaction_data t on (t.OrderID=o.OrderID and t.CustID=o.CustID and t.OrderID>'0' ) inner join p_supplier p on (o.VendorSalesPerson=p.SuppID ) inner join h_commission c on (c.SuppID=p.SuppID and c.SuppID>'0') WHERE t.TransactionID = '".$TransactionID."' and t.PaymentType='Invoice' and t.Module='AR' and t.InvoiceID!='' and o.VendorSalesPerson>'0'  and o.InvoiceEntry in ('0','1')  ";
            $arryInvData = $this->query($sql, 1);
            //pr($arryInvData,1);

            foreach($arryInvData as $key=>$values){//Start foreach
                if(!empty($values['VendorSalesPerson'])  && ($values['InvoiceEntry']=='0' || $values['InvoiceEntry']=='1') ){
                    $values['PostToGLDate'] = $Date;
                    $this->CreateAPInvoiceForVendorCommission($values);      
                }
            }//End foreach
        }
        return true;
         
    }
		 
	
	/*************************/

		
	/**********************VAT Collection ********************/
		  function  VatCollectionReportSales($arryDetails)
				{ 
					global $Config;
					extract($arryDetails);		        			        	
					$strAddQuery ='';
					
					$arryCountryName = $this->GetCountryName($arryDetails['country_id']);	
									
					$arryStateName = $this->GetStateName($arryDetails['state_id'],$arryDetails['country_id']);	
					
					if(!empty($arryDetails['country_id'] && $arryDetails['state_id'])){					
					         $strAddQuery .= 'and s.country="'.$arryCountryName[0]['name'].'" and s.state="'.$arryStateName[0]['name'].'"';
					}
							        	
					if($fby=='Year'){
						$strAddQuery .= " and YEAR(s.InvoiceDate)='".$y."'";

					}else if($fby=='Month'){
						$strAddQuery .= " and MONTH(s.InvoiceDate)='".$m."' and YEAR(s.InvoiceDate)='".$y."'";
					}else{
						$strAddQuery .= (!empty($f))?(" and s.InvoiceDate>='".$f."'"):("");
						$strAddQuery .= (!empty($t))?(" and s.InvoiceDate<='".$t."'"):("");	
					}     
					
					
					                  				 	
					    $strSQLQuery = "select '' as PONumber,'' as SaleID, s.InvoiceID as SalesInvoice,s.TaxRate as SalesTax,s.CustomerCurrency as SalesCurrency , '' as PurchaseCurrency, s.ConversionRate as SalesConversionRate,'' as PurchaseConversionRate,i.sku as SalesSku,i.qty_received as SaleQty,i.price as Saleprice, '' as PurchaseID,'' as PurchaseTax,'' as PurchaseSku,'' as PurchaseQty,'' as Purchaseprice, '' as PurchaseInvoice from s_order s inner join s_order_item  i on i.OrderID = s.OrderID where Module='Invoice' and s.TaxRate >'0' and i.Taxable ='Yes' and i.qty_received > '0' and s.PoNumber ='' and s.PostToGL ='1'   ".$strAddQuery." order by s.OrderID asc";
					 #echo $strSQLQuery;die;		    	
					     return $this->query($strSQLQuery, 1);		
				}
				
				  function  VatCollectionReportPurchase($arryDetails)
				{ 
					global $Config;
					extract($arryDetails);		        			        	
					$strAddQuery ='';
					
					$arryCountryName = $this->GetCountryName($arryDetails['country_id']);					
					$arryStateName = $this->GetStateName($arryDetails['state_id'],$arryDetails['country_id']);	
					
					if(!empty($arryDetails['country_id'] && $arryDetails['state_id'])){					
					         $strAddQuery .= 'and p.wCountry="'.$arryCountryName[0]['name'].'" and p.state="'.$arryStateName[0]['name'].'"';
					}
							        	
					if($fby=='Year'){
						$strAddQuery .= " and YEAR(p.PostedDate)='".$y."'";

					}else if($fby=='Month'){
						$strAddQuery .= " and MONTH(p.PostedDate)='".$m."' and YEAR(p.PostedDate)='".$y."'";
					}else{
						$strAddQuery .= (!empty($f))?(" and p.PostedDate>='".$f."'"):("");
						$strAddQuery .= (!empty($t))?(" and p.PostedDate<='".$t."'"):("");	
					}   
					
								 	
					    $strSQLQuery = "select '' as PONumber, '' as SaleID, '' as SalesTax, '' as SalesSku, '' as SaleQty, p.Currency as PurchaseCurrency,'' as SalesCurrency,p.ConversionRate as PurchaseConversionRate,'' as SalesConversionRate,'' as Saleprice, '' as PurchaseID, p.InvoiceID as PurchaseInvoice,p.TaxRate as PurchaseTax,pi.sku as PurchaseSku ,pi.qty_received as PurchaseQty,pi.price  as Purchaseprice, '' as SalesInvoice from p_order p inner join p_order_item  pi on pi.OrderID = p.OrderID left outer join s_order s on s.PONumber = p.PurchaseID where p.Module='Invoice' and p.TaxRate >'0' and s.PoNumber is NULL and pi.Taxable ='Yes' and pi.qty_received > '0' and p.PostToGL ='1'   ".$strAddQuery." order by p.OrderID asc";
					 #echo $strSQLQuery;die;	    	
					     return $this->query($strSQLQuery, 1);		
				}
				
				
				function GetCountryName($country_id){
					global $Config;
					$strSQLQuery = "select name from ".$Config['DbMain'].".country  where country_id='".$country_id."'";
					$results=$this->query($strSQLQuery,1);
					return $results;
			
				}
				
				function GetStateName($state_id,$country_id){
					global $Config;
					$strSQLQuery = "select name from ".$Config['DbMain'].".state  where state_id='".$state_id."' and country_id='".$country_id."'";
					$results=$this->query($strSQLQuery,1);
					return $results;
			
				}	
				
				
						
		
			function  VatCollectionReport($arryDetails)
				{ 
					global $Config;
					extract($arryDetails);	
					$strAddQuery ='';
					
					$arryCountryName = $this->GetCountryName($arryDetails['country_id']);	
									
					$arryStateName = $this->GetStateName($arryDetails['state_id'],$arryDetails['country_id']);	
					
					if(!empty($arryDetails['country_id'] && $arryDetails['state_id'])){					
					         $strAddQuery .= 'and s.country="'.$arryCountryName[0]['name'].'" and s.state="'.$arryStateName[0]['name'].'"';
					}
							        	
					if($fby=='Year'){
						$strAddQuery .= " and YEAR(s.InvoiceDate)='".$y."'";

					}else if($fby=='Month'){
						$strAddQuery .= " and MONTH(s.InvoiceDate)='".$m."' and YEAR(s.InvoiceDate)='".$y."'";
					}else{
						$strAddQuery .= (!empty($f))?(" and s.InvoiceDate>='".$f."'"):("");
						$strAddQuery .= (!empty($t))?(" and s.InvoiceDate<='".$t."'"):("");	
					}    	        			        					
						 	
					

					$strSQLQuery = "select s.PONumber ,s.CustomerCurrency as SalesCurrency,p.Currency as PurchaseCurrency, s.ConversionRate as SalesConversionRate,p.ConversionRate as PurchaseConversionRate,s.InvoiceID as SalesInvoice,p.InvoiceID as PurchaseInvoice, s.SaleID ,s.TaxRate as SalesTax,i.sku as SalesSku,i.qty_received as SaleQty,i.price as Saleprice,p.PurchaseID,p.TaxRate as PurchaseTax,pi.sku as PurchaseSku ,pi.qty_received as PurchaseQty , pi.price as Purchaseprice  from s_order s left outer join s_order_item i on (i.OrderID = s.OrderID and s.Module='Invoice' and i.Taxable ='Yes' and s.TaxRate !='' and i.qty_received > '0') inner join  p_order p on (p.PurchaseID = s.PoNumber and s.PoNumber !='') left outer join p_order_item pi on (pi.OrderID = p.OrderID and p.Module='Invoice' and pi.Taxable ='Yes' and p.TaxRate >'0' and pi.qty_received > '0') where i.sku = pi.sku ".$strAddQuery." ";
				        #echo $strSQLQuery;die;		    	
					     return $this->query($strSQLQuery, 1);		
				}
				
				
				
		
			
	
	/**********************End VAT Collection ********************/	
	
}

?>
