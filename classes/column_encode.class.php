<?
class encode extends dbClass
{
		//constructor
		function encode()
		{
			$this->dbClass();
		} 
		
		

        function ListLead() {
                    global $Config;
                    $strSQLQuery = "select l.leadID,l.AnnualRevenue from c_lead l ";
                    return $this->query($strSQLQuery, 1);


               }
       
           function UpdateLeadColumn($leadID,$AnnualRevenue){
                 global $Config;
                $strSQLQuery = "UPDATE c_lead SET AnnualRevenue= ENCODE('" .$AnnualRevenue. "','".$Config['EncryptKey']."')  WHERE leadID = '".$leadID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }
            
            
           function ListOpportunity() {
                    global $Config;
                    $strSQLQuery = "select o.OpportunityID,o.Amount,o.forecast_amount from c_opportunity o ";
                    return $this->query($strSQLQuery, 1);


               }
               
            function UpdateOpportunityColumn($OpportunityID,$Amount,$forecast_amount){
                global $Config;
                $strSQLQuery = "UPDATE c_opportunity SET Amount= ENCODE('" .$Amount. "','".$Config['EncryptKey']."'), forecast_amount= ENCODE('" .$forecast_amount. "','".$Config['EncryptKey']."')  WHERE OpportunityID = '".$OpportunityID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }
            
            
            function  ListSalary(){
                        global $Config;
                        $strSQLQuery = "select s.salaryID,s.EmpID,s.CTC,s.Gross,s.NetSalary from h_salary s";		
                        return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateSalaryColumn($salaryID,$CTC,$Gross,$NetSalary){
                global $Config;
                $strSQLQuery = "UPDATE h_salary SET CTC= ENCODE('".$CTC."','".$Config['EncryptKey']."'), Gross= ENCODE('".$Gross."','".$Config['EncryptKey']."'), NetSalary= ENCODE('" .$NetSalary. "','".$Config['EncryptKey']."')  WHERE salaryID = '".$salaryID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }
            
            
            function  ListPaySalary(){
                    
                        global $Config;
			$strSQLQuery = "select p.payID,p.EmpID,p.CTC,p.Gross,p.NetSalary,p.CurrentSalary from h_pay_salary p ";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdatePaySalaryColumn($payID,$CTC,$Gross,$NetSalary,$CurrentSalary){
                global $Config;
                $strSQLQuery = "UPDATE h_pay_salary SET CTC= ENCODE('".$CTC."','".$Config['EncryptKey']."'), Gross= ENCODE('".$Gross."','".$Config['EncryptKey']."'), NetSalary= ENCODE('" .$NetSalary. "','".$Config['EncryptKey']."'), CurrentSalary= ENCODE('" .$CurrentSalary. "','".$Config['EncryptKey']."')  WHERE payID = '".$payID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
            
            /*function  ListAdvance($arryDetails){
                        global $Config;
			$strSQLQuery = "select a.AdvID,a.EmpID,a.Amount,a.AmountReturned from h_advance a ";
                        return $this->query($strSQLQuery, 1);	
					
		}
                
           function UpdateAdvanceColumn($AdvID,$Amount,$AmountReturned){
                global $Config;
                $strSQLQuery = "UPDATE h_advance SET Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), AmountReturned= ENCODE('".$AmountReturned."','".$Config['EncryptKey']."')  WHERE AdvID = '".$AdvID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                
                if($AdvID > 0){
                    
                    $strSQLQuery2 = "select ar.AdvID,ar.ReturnID,ar.ReturnAmount from h_advance_return ar WHERE ar.AdvID = '".$AdvID."'";
                    $rows = $this->query($strSQLQuery2, 1);
                    
                    foreach($rows as $val){
                        
                        $sql = "UPDATE h_advance_return SET ReturnAmount = ENCODE('".$val['ReturnAmount']."','".$Config['EncryptKey']."') WHERE ReturnID = '".$val['ReturnID']."' and AdvID = '".$val['AdvID']."'";
                        //echo "=>".$sql;exit;
                        $this->query($sql, 0);
                    }
                    
                  
                    
                }
                
                return 1;
            }     */ 
            
            
             function  ListPayments(){
                    
                        global $Config;
			$strSQLQuery = "select p.PaymentID,p.DebitAmnt,p.CreditAmnt from f_payments p ";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdatePaymentsColumn($PaymentID,$DebitAmnt,$CreditAmnt){
                global $Config;
                $strSQLQuery = "UPDATE f_payments SET DebitAmnt= ENCODE('".$DebitAmnt."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$CreditAmnt."','".$Config['EncryptKey']."') WHERE PaymentID = '".$PaymentID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
             function  ListIncome(){
                    
                        global $Config;
			$strSQLQuery = "select i.IncomeID,i.Amount,i.TotalAmount from f_income i ";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateIncomeColumn($IncomeID,$Amount,$TotalAmount){
                global $Config;
                $strSQLQuery = "UPDATE f_income SET Amount= ENCODE('".$Amount."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."') WHERE IncomeID = '".$IncomeID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
       
            
             function  ListExpense(){
                    
                        global $Config;
			$strSQLQuery = "select e.ExpenseID,e.Amount,e.TotalAmount from f_expense e ";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateExpenseColumn($ExpenseID,$Amount,$TotalAmount){
                global $Config;
                $strSQLQuery = "UPDATE f_expense SET Amount= ENCODE('".$Amount."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."') WHERE ExpenseID = '".$ExpenseID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
            
             function  ListMultiAccountPayment(){
                    
                        global $Config;
			$strSQLQuery = "select a.ID,a.Amount from f_multi_account_payment a ";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateMultiAccountPaymentColumn($ID,$Amount){
                global $Config;
                $strSQLQuery = "UPDATE f_multi_account_payment SET Amount= ENCODE('".$Amount."','".$Config['EncryptKey']."') WHERE ID = '".$ID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
            
             function  ListGeneral(){
                    
                        global $Config;
			$strSQLQuery = "select j.JournalID,j.TotalDebit,j.TotalCredit from f_gerenal_journal j ";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateGeneralColumn($JournalID,$TotalDebit,$TotalCredit){
                global $Config;
                $strSQLQuery = "UPDATE f_gerenal_journal SET TotalDebit= ENCODE('".$TotalDebit."','".$Config['EncryptKey']."'),TotalCredit= ENCODE('".$TotalCredit."','".$Config['EncryptKey']."') WHERE JournalID = '".$JournalID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
            
             function  ListGeneralEntry(){
                    
                        global $Config;
			$strSQLQuery = "select j.JournalEntryID,j.DebitAmnt,j.CreditAmnt from f_gerenal_journal_entry j order by j.JournalEntryID asc";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateGeneralEntryColumn($JournalEntryID,$DebitAmnt,$CreditAmnt){
                global $Config;
                $strSQLQuery = "UPDATE f_gerenal_journal_entry SET DebitAmnt= ENCODE('".$DebitAmnt."','".$Config['EncryptKey']."'), CreditAmnt= ENCODE('".$CreditAmnt."','".$Config['EncryptKey']."') WHERE JournalEntryID = '".$JournalEntryID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
            
            function  ListTransfer(){
                    
                        global $Config;
			$strSQLQuery = "select TransferID,TransferAmount from f_transfer";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateTransferColumn($TransferID,$TransferAmount){
                 
                global $Config;
                $strSQLQuery = "UPDATE f_transfer SET TransferAmount = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."')  WHERE TransferID = '".$TransferID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
             function  ListDeposit(){
                    
                        global $Config;
			$strSQLQuery = "select DepositID,Amount from f_deposit";
			return $this->query($strSQLQuery, 1);	
					
		}
                
             function UpdateDepositColumn($DepositID,$Amount){
                 
                global $Config;
                $strSQLQuery = "UPDATE f_deposit SET Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."')  WHERE DepositID = '".$DepositID."'";
                //echo "=>".$strSQLQuery;exit;
                $this->query($strSQLQuery, 0);
                return 1;
            }  
            
       



}

?>
