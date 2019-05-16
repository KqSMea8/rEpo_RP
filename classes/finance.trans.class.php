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

			$strSQLQuery = "select o.OrderDate, o.PostedDate,o.InvoiceDate,o.InvoicePaid, o.OrderID, o.SaleID,o.CustID, o.CustCode, o.CustomerName, o.SalesPerson, o.InvoiceID,o.taxAmnt, o.TotalAmount from s_order o  where o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery." order by o.InvoiceDate desc";
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
			
			$strSQLQuery = "select SUM(taxAmnt) as totalTaxAmnt from s_order as o WHERE o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery;
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

			$strSQLQuery = "select o.OrderDate, o.PostedDate,o.InvoicePaid,o.OrderID,o.PurchaseID,o.SuppCode,o.SuppCompany,o.InvoiceID,o.taxAmnt from p_order o  where o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery." order by o.PostedDate desc";
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
			
			$strSQLQuery = "select SUM(taxAmnt) as totalTaxAmnt from p_order as o WHERE o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery;
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
                

 		function  arAgingReportList($CustCode)
		{
                         global $Config;
			$strAddQuery = "";
			if(!empty($CustCode)){
				$strAddQuery .= " and o.CustCode='".$CustCode."'";
				$innerSql = " and p.CustCode='".$CustCode."'";
			}
		
			/**************************
			$strSQLQuery = "select o.InvoiceDate, o.CustID, o.PaymentTerm, c.CreditLimit, c.Landline, o.CustCode, o.InvoiceID, o.SaleID, o.TotalInvoiceAmount ,ab.Address,ab.CityName,ab.StateName, ab.CountryName, ab.ZipCode,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as Customer ,(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.InvoiceID !='' and p.InvoiceID=o.InvoiceID ".$innerSql." and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt from s_order o  left outer join s_customers c on BINARY o.CustCode = BINARY c.CustCode left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') where o.InvoicePaid!='Paid' and o.module='Invoice' and o.ReturnID='' ".$strAddQuery." having Customer!='' order by Customer asc,o.InvoiceDate desc,o.OrderID desc";
			/**************************/
			$strSQLQuery = "select o.InvoiceDate, o.CustID, o.PaymentTerm, c.CreditLimit, c.Landline, o.CustCode, o.InvoiceID, o.OrderID, o.OrderID, o.InvoiceEntry, o.SaleID, o.TotalInvoiceAmount ,ab.FullName as ContactPerson,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as Customer ,(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.InvoiceID !='' and p.PostToGL ='Yes' and p.InvoiceID=o.InvoiceID ".$innerSql." and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt from s_order o  left outer join s_customers c on BINARY o.CustCode = BINARY c.CustCode left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PaymentInfo='1') where o.InvoicePaid!='Paid' and o.module='Invoice' and o.ReturnID='' ".$strAddQuery." having Customer!='' order by Customer asc,o.InvoiceDate desc,o.OrderID desc";


			//echo "=>".$strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}

                function  apAgingReportList($SuppCode)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($SuppCode)){
				$strAddQuery .= " and o.SuppCode='".$SuppCode."'";
				$innerSql = " and p.SuppCode='".$SuppCode."'";
			}
			
			$strSQLQuery = "select o.PostedDate,o.SuppCode, o.SuppCompany, o.InvoiceID,  o.OrderID, o.InvoiceEntry, o.ExpenseID, o.PurchaseID, o.PaymentTerm, s.Landline, s.CreditLimit, ab.Name as ContactPerson, o.TotalAmount as TotalInvoiceAmount ,(SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and p.InvoiceID!='' and p.PostToGL ='Yes' and p.InvoiceID=o.InvoiceID ".$innerSql." and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense')) as PaidAmnt 
                            from p_order o left outer join p_supplier s on BINARY o.SuppCode = BINARY s.SuppCode left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PaymentInfo='1') where o.InvoicePaid!='1' and o.module='Invoice' and o.ReturnID='' ".$strAddQuery." order by o.SuppCompany asc,o.PostedDate desc,o.OrderID desc";
			 //echo "=>".$strSQLQuery;
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
                                 
                     $strSQLQuery = "select o.TotalInvoiceAmount ,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as PaidAmnt  from s_order o left join f_payments p on (p.InvoiceID = '".$InvoiceID."'  and p.PostToGL = 'Yes' and p.InvoiceID = o.InvoiceID and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income') ) where o.module='Invoice' and o.ReturnID=''  and o.InvoiceID='".$InvoiceID."' and o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."' order by o.InvoiceDate desc";
                    
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
                    $strSQLQuery = "select o.SuppCode, sum(o.TotalAmount) as TotalInvoiceAmount ,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt from p_order o left join f_payments p on  (p.InvoiceID = o.InvoiceID  and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense') )where o.module='Invoice' and o.ReturnID='' 
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
                
                function AddUpdatePeriodSetting($arryDetails)
		{  
			global $Config;
//echo '<pre>';print_r($arryDetails);exit;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
                        
                        

			for($i=1;$i<=$NumLine;$i++){
                            
				if(!empty($arryDetails['PeriodYear'.$i]) && !empty($arryDetails['PeriodStatus'.$i])){
					
                                        //Get PeriodYear,PeriodMonth,PeriodModule
                                        $strSQL = "select PeriodID  from f_period_end where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$arryDetails['PeriodMonth'.$i]."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."'"; 
                                        $arryRow = $this->query($strSQL, 1);		 
                                        $PeriodID = $arryRow[0]['PeriodID'];
                                         //echo "=>".$PeriodID;exit;
                                        //end
					
					if($PeriodID>0){
						
                                                  $sql = "update f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodUpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."' where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$arryDetails['PeriodMonth'.$i]."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."'"; 
                                                  $this->query($sql, 0);
                                                       
					 }else{
                                             	//pk start
						 $sql = "insert into f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodCreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                                                   $this->query($sql, 0);
						//pk end
                                             /*******************************************************
                                            if($arryDetails['PeriodMonth'.$i] == "01")
                                            {
                                                    $sql = "insert into f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodCreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                                                    $this->query($sql, 0);

                                            }
                                            else{
                                                    $PeriodMonth = $arryDetails['PeriodMonth'.$i]-1;
                                                    if($PeriodMonth < 10)$PeriodMonth = "0".$PeriodMonth;
                                                    $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."' and PeriodStatus='Closed'";
                                                    //echo "=>".$strSQLQuery;exit;
                                                    $row = $this->query($strSQLQuery, 1);
                                                    if($row[0]['PeriodID'] > 0)
                                                    {
                                                    

                                                        $sql = "insert into f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodCreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                                                        $this->query($sql, 0);	
                                                    //$PeriodID = $this->lastInsertId();
                                                    //return $PeriodID;
                                                    }
                                            } 
					/*******************************************************/

					}
					
				}
			}
		       
			return true;

		}
                
                function getPeriodFields($arryDetails)
                {
                    extract($arryDetails);
                    $strAddQuery = " where p.LocationID = '".$_SESSION['locationID']."'";
                    $SearchKey   = strtolower(trim($_GET['search']));
                    
                    if(!empty($_GET['PeriodModule'])){
                        $strAddQuery .= " and p.PeriodModule like '".$_GET['PeriodModule']."%'";
                    }
                     if(!empty($_GET['PeriodYear'])){
                        $strAddQuery .= " and p.PeriodYear like '".$_GET['PeriodYear']."%'";
                    }
                    if(!empty($_GET['PeriodMonth'])){
                        $strAddQuery .= " and p.PeriodMonth like '".$_GET['PeriodMonth']."%'";
                    }
                   
                    if($PeriodID >0 ){
                        $strAddQuery .= " and p.PeriodID = '".$PeriodID."'";
                    }
                    
                    //$strAddQuery .= (!empty($SearchKey))?(" and (p.PeriodModule like '".$_GET['PeriodModule']."%' or p.PeriodYear = '".$_GET['PeriodYear']."' or p.PeriodMonth = '".$_GET['PeriodMonth']."') "):("");
                    $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p.PeriodModule asc,p.PeriodYear  asc,p.PeriodMonth asc ");
                    $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" ");
			   
                    $strSQLQuery = "select p.* from f_period_end p  ".$strAddQuery;
                      //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                    
                }
                
                function changePeriodFieldStatus($arryDetails)
		{
                    global $Config;
                    extract($arryDetails);
                    $strSQLQuery = "UPDATE f_period_end SET PeriodStatus ='".$PeriodStatus."',PeriodUpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."' WHERE PeriodID ='".mysql_real_escape_string($active_id)."'"; 
                    $this->query($strSQLQuery,0);
                    return true;
				 			
		}
                
                function RemovePeriodField($PeriodID)
		{
		
			$strSQLQuery = "delete from f_period_end where PeriodID = '".$PeriodID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}
                
                function getCurrentPeriod($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and  LocationID='".$_SESSION['locationID']."' and PeriodStatus='Closed' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 ";
                    $row = $this->query($strSQLQuery, 1);
                   
                    $lastMonth = $row[0]['PeriodMonth'];
                    
                    
                    if(empty($lastMonth)){
                        $monthName = "January";
                        $lastYear = date('Y');
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
                    }
                    
                   
                    
                    $currentPeriod = "Current Period ".$monthName." ".$lastYear;
                    return $currentPeriod;
                    
                }
                
                 function getCurrentPeriodDate($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and LocationID='".$_SESSION['locationID']."' and PeriodStatus='Closed' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 ";
                    $row = $this->query($strSQLQuery, 1);
                   
                    $lastMonth = $row[0]['PeriodMonth'];
                    
                    
                    if(empty($lastMonth)){
                        $monthNum = 01;
                        $lastYear = date('Y');
                    }else{
                    
                        if($lastMonth < 12){
                            $monthNum  = 1+$lastMonth;
                            $lastYear = $row[0]['PeriodYear'];
                        }else{
                            $monthNum  = 13-$lastMonth;
                            $lastYear = 1+$row[0]['PeriodYear'];
                        }
                        
                       // $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        //$monthName = $dateObj->format('F'); // March 
                    }
                    
                   
                    if($monthNum < 10)$monthNum = "0".$monthNum;
                    $currentPeriod = $lastYear."-".$monthNum."-01";
                    return $currentPeriod;
                    
                }
                
                 function getBackOpenMonth($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and PeriodStatus='Open' and LocationID='".$_SESSION['locationID']."'";
                    return $this->query($strSQLQuery, 1);
                   
                    
                    
                }
                
                function CheckPeriodSettings($PeriodYear,$PeriodMonth,$PeriodStatus,$PeriodModule)
                {
                    if($PeriodMonth == "01" && $PeriodYear == date('Y'))
                    {
                         $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                         $row = $this->query($strSQLQuery, 1);
                         if($row[0]['PeriodID'] > 0)
                            {
                                $returnStr = "This month already closed for ".$PeriodModule.".";
                            }else{
                                $returnStr = 1;
                            }
                            return $returnStr;
                       
                    }
                    else{
                        
                         $strSQLQuery2 = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                         $row2 = $this->query($strSQLQuery2, 1);

                         if($row2[0]['PeriodID'] > 0)
                            {
                                $returnStr = "This month already closed for ".$PeriodModule.".";
                            }else{
                        
                                    $PeriodMonth = $PeriodMonth-1;
                                    if($PeriodMonth < 10)$PeriodMonth = "0".$PeriodMonth;
                                    $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                                   // echo "=>".$strSQLQuery;exit;
                                    $row = $this->query($strSQLQuery, 1);
                                    if($row[0]['PeriodID'] > 0)
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
                     
                    $strSQLQuery = "SELECT f.BankAccountID,p.PaymentID,p.PaymentDate, p.Method, p.PaymentType,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountName,f.AccountNumber from f_account f inner join f_payments p on p.AccountID = f.BankAccountID
                        WHERE 1 ".$strAddQuery."";
                    
   	           // echo "=>".$strSQLQuery;
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
                                CreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."' ,FinalStatus='".$FinalStatus."' ";
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
                            $strAddQuery = "insert into f_reconcile_transaction set ReconcileID='".$ReconcileID."', PaymentID='".$arryDetails['Reconcil_'.$i]."'";
                            $this->query($strAddQuery, 0);
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
                    $SearchKey   = strtolower(trim($_GET['search']));
               
                    if(!empty($RYear)){
                        $strAddQuery .= " and r.Year = '".$RYear."'";
                    }
                    if(!empty($RMonth)){
                        $strAddQuery .= " and r.Month = '".$RMonth."'";
                    }
                     if(!empty($RAccountID)){
                        $strAddQuery .= " and r.AccountID = '".$RAccountID."'";
                    }
                   
                    if($ReconcileID >0 ){
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
                 $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."' and LocationID='".$_SESSION['locationID']."' and Status='Reconciled' and ReconcileID != '".$editID."'";
                }else{
                    $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."' and LocationID='".$_SESSION['locationID']."' and Status='Reconciled'";
                }
               
                 $row = $this->query($strSQLQuery, 1);
                 return $row[0]['ReconcileID'];
            }
            
            function RemoveMonthReconciliation($ReconcileID)
            {
                $strSQLQuery = "delete from f_reconcile where ReconcileID = '".$ReconcileID."'"; 
                $this->query($strSQLQuery, 0);
                
               $strSQLQuery2 = "delete from f_reconcile_transaction where ReconcileID = '".$ReconcileID."'"; 
              $this->query($strSQLQuery2, 0);

               
            }
            
            function checkPaymentIDExist($PaymentID)
            {
                $strSQLQuery = "select PaymentID from f_reconcile_transaction where PaymentID='".$PaymentID."'";
                $row = $this->query($strSQLQuery, 1);
                return $row[0]['PaymentID'];
            }

            function getMonthReconcil($ReconcileID)
            {
                 $strSQLQuery = "select * from f_reconcile where ReconcileID='".$ReconcileID."'";
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
           /***********************END CODE FOR Reconciliation****************************************************************/   

	 /****Start Code for Trial Balance By Shravan 23 july 2015 ***/
           
           
           function getAccountTypeForProfitLossReportNew()
                {
        			
		    $strAddQuery .= " ReportType='PL'"; 
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
		 	$strSQLPay = " Select InvoiceID, PurchaseID, PaymentID as PID, DECODE(CreditAmnt,'". $Config['EncryptKey']."') as PaymentAmount,Currency,AdjID from f_payments where PaymentID='".$PaymentID."'";
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

		}
		               
                return true;
            }



 	    function deleteCustomerPayment($PaymentID){
		global $Config;

		if($PaymentID>0){
		 	 $strSQLPay = " Select InvoiceID, OrderID,SaleID, PaymentID as PID, DECODE(DebitAmnt,'". $Config['EncryptKey']."') as PaymentAmount,Currency from f_payments where PaymentID='".$PaymentID."'";
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
				$contents = file_get_contents($htmlPrefix."vendor_payment.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arryPaymentHistry[0][InvoiceID],$contents);
				$contents = str_replace("[CreatedDate]",$CreatedDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
                                $contents = str_replace("[vendorstatus]",$InvoicePaid,$contents);
                                $contents = str_replace("[POREFRENCES]",$poref,$contents);
				$contents = str_replace("[PostGLDate]",$postToGl,$contents);
				
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[PaymentDate]",$PaymentDate,$contents);
				$contents = str_replace("[PaymentType]",$PaymentType,$contents);
				$contents = str_replace("[Method]",$Method,$contents);
				
				$contents = str_replace("[Suppvendor]",stripslashes($arryPaymentHistry[0]['Suppvendor']),$contents);
                                $subject="Vendor ".$module." # ".$arryPaymentHistry[0][InvoiceID];
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
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
				$contents = file_get_contents($htmlPrefix."case_receipt.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arryCaseReceipt[0][InvoiceID],$contents);
				$contents = str_replace("[CreatedDate]",$CreatedDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
                                $contents = str_replace("[vendorstatus]",$InvoicePaid,$contents);
                                $contents = str_replace("[POREFRENCES]",$poref,$contents);
                                $contents = str_replace("[PostGLDate]",$postTOGL,$contents);
				
				
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[PaymentDate]",$PaymentDate,$contents);
				$contents = str_replace("[PaymentType]",$PaymentType,$contents);
				$contents = str_replace("[Method]",$Method,$contents);
				
				$contents = str_replace("[CustomerName]",stripslashes($arryCaseReceipt[0]['CustomerName']),$contents);
                                $subject="Customer ".$module." # ".$arryCaseReceipt[0][InvoiceID];
				
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
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
			$strSQLQuery = "select t.*, DECODE(t.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount from f_transaction t where 1 ";
			$strSQLQuery .= (!empty($TransactionID))?(" and t.TransactionID='".$TransactionID."'"):("");
			$strSQLQuery .= (!empty($ContraID))?(" and t.ContraID='".$ContraID."'"):("");
			$strSQLQuery .= (!empty($PaymentType))?(" and t.PaymentType='".$PaymentType."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow;                    
                }

		function GetPaymentTransactionDetail($TransactionID,$InvoiceID,$PaymentType){
			global $Config;
			if(!empty($TransactionID)){ 
				$strAddQuery .= (!empty($TransactionID))?(" and p.TransactionID='".$TransactionID."'"):("");
				$strAddQuery .= (!empty($InvoiceID))?(" and p.InvoiceID='".$InvoiceID."'"):("");
				$strAddQuery .= (!empty($PaymentType))?(" and p.PaymentType='".$PaymentType."'"):("");
				$strSQLQuery = "SELECT p.*, DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as  DebitAmnt, DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as  CreditAmnt FROM f_payments p WHERE PostToGL != 'Yes' ".$strAddQuery;		
				return $this->query($strSQLQuery, 1);
			}
		
		}

	function RemovePaymentTransaction($TransactionID){
		global $Config;
		if(!empty($TransactionID)){ 
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
		 	$strSQLPay = "Select p.TransactionID from f_payments p inner join f_transaction t on p.TransactionID=t.TransactionID where p.PaymentID='".$PaymentID."'";
                	$arryPayment = $this->query($strSQLPay, 1);  
	 		$TransactionID = $arryPayment[0]['TransactionID'];
			if($TransactionID>0){
			   $strSQLPay2 = "Select count(PaymentID) as PaymentCount from f_payments p where TransactionID='".$TransactionID."' and PaymentID!='".$PaymentID."'";
                	    $arryPayment2 = $this->query($strSQLPay2, 1); 	

			    if($arryPayment2[0]['PaymentCount']<=0){
				   $delSQLQuery = "delete from f_transaction where TransactionID = '".$TransactionID."'"; 
				   $this->query($delSQLQuery, 0);
			    }
			}			

		}
		         
                return true;
            }




function CreatePrepaidFreightInvoice($arryOrder){
	extract($arryOrder);
	$objPurchase=new purchase();
	$arrySupplier = $objPurchase->GetSupplier('',$PrepaidVendor,'');
	
	$TotalAmount = ($TotalAmount - $Freight - $taxAmnt) + $PrepaidAmount;

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

	$strSQLQuery = "SELECT p.*,e.GlEntryType,e.ExpenseTypeID from p_order p left outer join f_expense e on p.ExpenseID=e.ExpenseID where p.OrderID = '".trim($OrderID)."' and PostToGL != '1'";
	$arryRow = $this->query($strSQLQuery, 1);	
	$TotalAmount = $arryRow[0]['TotalAmount'];

	//echo '<pre>';print_r($arryRow);exit;

	if($arryRow[0]['InvoiceEntry']==2 && !empty($TotalAmount)){ //FOR GL Account
	      $GlEntryType = $arryRow[0]['GlEntryType'];		

 	      if($GlEntryType == "Single"){ //Start Single GL Account
		$AccountID = $arryRow[0]['ExpenseTypeID'];
		   
		$strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountID."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
		$this->query($strSQLQuery, 1);
		$PID = $this->lastInsertId();


		$strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."',  AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
		$this->query($strSQLQueryPay, 0);

		/********************/
	    }//End Single GL Account
	    else if($GlEntryType == "Multiple"){ //Start Multiple GL Account			
		$strSQL = "SELECT p.AccountID,DECODE(p.Amount,'". $Config['EncryptKey']."') as  Amount from f_multi_account_payment p inner join f_expense e on p.ExpenseID=e.ExpenseID where p.ExpenseID = '".$arryRow[0]['ExpenseID']."' and e.ExpenseID = '".$arryRow[0]['ExpenseID']."' ";
		$arryRowMulti = $this->query($strSQL, 1);
		foreach($arryRowMulti as $values){			
			$strSQLQuery = "INSERT INTO f_payments SET OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$values['Amount']."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$values['AccountID']."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
			$this->query($strSQLQuery, 1);
			$PID = $this->lastInsertId();
		}

		$strSQLQueryPay = "INSERT INTO f_payments SET PID='0', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
		$this->query($strSQLQueryPay, 0);

		
	    }


	}else if($arryRow[0]['InvoiceEntry']==0 || $arryRow[0]['InvoiceEntry']==1){ //Start LINE ITEM	


	
		/**************************************/
		if(!empty($InventoryAP) && !empty($FreightExpense) && !empty($TotalAmount)){
			
			$Freight = $arryRow[0]['Freight'];
			$SubTotal = $TotalAmount - $Freight;

			if($arryRow[0]['Currency']!=$Config['Currency']){
				$ConversionRate=CurrencyConvertor(1,$arryRow[0]['Currency'],$Config['Currency']);

				$TotalAmount = round(GetConvertedAmount($ConversionRate, $TotalAmount) ,2);
				$SubTotal = round(GetConvertedAmount($ConversionRate, $SubTotal) ,2);
				$Freight = round(GetConvertedAmount($ConversionRate, $Freight) ,2);
			}


			/***Update Stock****/
			$strSQL = "SELECT i.sku,i.item_id,i.qty_received from p_order_item i where i.OrderID = '".trim($OrderID)."'";
			$arryItem = $this->query($strSQL, 1);
			//echo '<pre>';print_r($arryItem);exit;	
			foreach($arryItem as $values){		
				if($values['qty_received']>0){
					$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$values['sku']. "'  and qty_on_hand<0";
					$this->query($UpdateQtysql2, 0);

					$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$values['qty_received'] . "  where Sku='" .$values['sku']. "'  ";
					$this->query($UpdateQtysql, 0);					
				}
			}
			/******************/


			$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$SubTotal."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAP."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
			$this->query($strSQLQuery, 1);
			$PID = $this->lastInsertId();
			if($Freight>0){
				$strSQLQuery2 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',OrderID = '".$OrderID."', SuppCode = '".$arryRow[0]['SuppCode']."', PurchaseID = '".$arryRow[0]['PurchaseID']."', ReferenceNo='".$arryRow[0]['InvoiceID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', DebitAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightExpense."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
				$this->query($strSQLQuery2, 1);
			}
			$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$AccountPayable."',  SuppCode = '".$arryRow[0]['SuppCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
		$this->query($strSQLQueryPay, 0);

		}
		/**************************************/
		
	}//End LINE ITEM


     


		/************************/
		if($PID>0){
			$strSQLQuery = "update p_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0);  
			
		}else{
			return $arryRow[0]['InvoiceID'];
		}
		/************************/


		/**********Create Invoice for Prepaid Freight************/
		if($arryRow[0]['PrepaidFreight']=='1' && $arryRow[0]['InvoiceEntry']==0 && $arryRow[0]['PurchaseID']!='' && $arryRow[0]['PrepaidVendor']!='' && $arryRow[0]['PrepaidAmount']!=''){
			$this->CreatePrepaidFreightInvoice($arryRow[0]);
		}
		/***************************/


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



/********************************************************************/
function SoInvoicePostToGL($OrderID,$arryPostData){
	global $Config;
	extract($arryPostData);
	$objItem=new items();

	if(empty($PostToGLDate)){
		$PostToGLDate=$Config['TodayDate'];
	}    
        $Date = $PostToGLDate;
	$ipaddress = GetIPAddress(); 

	$strSQLQuery = "SELECT s.* from s_order s where s.OrderID = '".trim($OrderID)."' and PostToGL != '1' ";
	$arryRow = $this->query($strSQLQuery, 1);
	//echo '<pre>';print_r($arryRow);exit;	
	$TotalAmount = $arryRow[0]['TotalInvoiceAmount'];
	$PaymentType = ($arryRow[0]['InvoiceEntry']==1)?('Customer Invoice Entry'):('Customer Invoice');
	if($TotalAmount>0 && $arryRow[0]['CustomerCurrency']!=$Config['Currency']){
		$ConversionRate=CurrencyConvertor(1,$arryRow[0]['CustomerCurrency'],$Config['Currency']);	
	}
	
	
	
	if($arryRow[0]['InvoiceEntry']==0 || $arryRow[0]['InvoiceEntry']==1){ //Start LINE ITEM		
		/**************************************/
		/**************************************/
		if(!empty($AccountReceivable) && !empty($SalesAccount) && $TotalAmount>0){
			/*****************/
				
				// Get Cost of Goods and Revenenue
				$strSQL = "SELECT i.sku,i.item_id,i.qty_invoiced,(i.amount/i.qty_invoiced) as ItemSalePrice from s_order_item i where i.OrderID = '".trim($OrderID)."'";
				$arryItem = $this->query($strSQL, 1);
				//echo '<pre>';print_r($arryItem);exit;	
				$TotalCost = 0;$TotalRevenue = 0;
				foreach($arryItem as $values){			
					//$ItemCost = $this->GetCostofGoods($values['sku']); //pk
					$ItemCostArry = $objItem->GetCostofGood($values['sku'],2); //inventory class
					$ItemCost = $ItemCostArry['CostOfGood'];

					$ItemSalePrice = $values['ItemSalePrice'];
					if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){			
						$ItemSalePrice = $ConversionRate * $ItemSalePrice;		
					}
					$Revenue = $ItemSalePrice - $ItemCost;
					//echo $values['sku'].' : '.$ItemCost.' # '.$ItemSalePrice.' $ '.$Revenue.'<br>';
					$TotalCost += ($ItemCost*$values['qty_invoiced']);
					$TotalRevenue += ($Revenue*$values['qty_invoiced']);


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
			$SubTotal = $TotalAmount - $Freight;

			if($arryRow[0]['CustomerCurrency']!=$Config['Currency']){				
				$TotalAmount = $ConversionRate * $TotalAmount;
				$SubTotal = $ConversionRate * $SubTotal;
				$Freight = $ConversionRate * $Freight;
				$taxAmnt = $ConversionRate * $taxAmnt;
			}
			//echo $TotalAmount.'#'.$SubTotal.'#'.$Freight;exit;
			$TotalCost = $TotalCost+$Freight+$taxAmnt; //temp for frieght & tax

			$FinalCostRevenue = round($TotalCost+$TotalRevenue);
			
			//echo $TotalCost.' + '. $TotalRevenue.' = '.$FinalCostRevenue.'='.round($TotalAmount);exit;
			/**************************************/
			if($Config['TrackInventory']==1){//start TrackInventory

				if($FinalCostRevenue==round($TotalAmount)){

				//Credit Inventory and Freight
				$strSQLQuery = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$SubTotal."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$InventoryAR."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
				$this->query($strSQLQuery, 1);				
				if($Freight>0){
					$strSQLQuery2 = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', OrderID = '".$OrderID."', CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."',  SaleID = '".$arryRow[0]['SaleID']."', InvoiceID='".$arryRow[0]['InvoiceID']."', CreditAmnt  = ENCODE('".$Freight."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$FreightAR."',  PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";
					$this->query($strSQLQuery2, 1);
				}


				//Debit Cost of goods and Revenue
				if($TotalCost>0){
					$strSQLQueryCost = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',  DebitAmnt = ENCODE('".$TotalCost."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$CostOfGoods."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";  
					$this->query($strSQLQueryCost, 0);
				}
				if($TotalRevenue!=''){
					$strSQLQueryRev = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."',  DebitAmnt = ENCODE('".$TotalRevenue."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$RevenueAccount."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";  
					$this->query($strSQLQueryRev, 0);
				}
			    }
			}//end TrackInventory
			/**************************************/
			 //Credit Sales
			$strSQLQuerySales = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', CreditAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'),  DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$SalesAccount."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' "; 
			$this->query($strSQLQuerySales, 0);
			$PID = $this->lastInsertId();

			 //Debit AR
			$strSQLQueryPay = "INSERT INTO f_payments SET ConversionRate = '".$ConversionRate."', PID='".$PID."', DebitAmnt = ENCODE('".$TotalAmount."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo='".$arryRow[0]['InvoiceID']."', AccountID = '".$AccountReceivable."',  CustID = '".$arryRow[0]['CustID']."', CustCode = '".$arryRow[0]['CustCode']."', PaymentDate = '".$Date."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', Flag= 1, IPAddress='".$ipaddress."' , CreatedDate='". $Config['TodayDate']."', UpdatedDate='". $Config['TodayDate']."',PostToGL='Yes' ";  
			$this->query($strSQLQueryPay, 0);

			/**************************************/

		}
		/**************************************/
		/**************************************/
		
	}//End LINE ITEM


	
     
		//exit;

		/************************/
		if($PID>0){
			$strSQLQuery = "update s_order set PostToGL = '1',PostToGLDate='".$PostToGLDate."' WHERE OrderID ='".$OrderID."' ";
			$this->query($strSQLQuery, 0);  
			
		}else{
			return $arryRow[0]['InvoiceID'];
		}
		/************************/
        	
        }




  
}

?>
