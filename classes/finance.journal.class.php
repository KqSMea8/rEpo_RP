<?php

class journal extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function journal(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}


                function ListGerenalJournal($arryDetails)
                {
                                 global $Config;
				extract($arryDetails);
				$strAddQuery = " where j.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				
				$strAddQuery .= (!empty($FromDate))?(" and j.JournalDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and j.JournalDate<='".$ToDate."'"):("");
					



				if($sortby != ''){

					if($sortby == 'j.TotalDebit' and !empty($SearchKey)){
						$strAddQuery .= " and DECODE(j.TotalDebit,'". $Config['EncryptKey']."') = '".$SearchKey."' "; 			}else if($sortby == 'j.TotalCredit' and !empty($SearchKey)){
						$strAddQuery .= " and DECODE(j.TotalCredit,'". $Config['EncryptKey']."') = '".$SearchKey."' "; 
					}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
					}
				} else{
				$strAddQuery .= (!empty($SearchKey))?(" and (j.JournalNo like '%".$SearchKey."%' or j.JournalMemo like '%".$SearchKey."%' or j.Currency like '%".$SearchKey."%' or  DECODE(j.TotalDebit,'". $Config['EncryptKey']."') = '".$SearchKey."' or DECODE(j.TotalCredit,'". $Config['EncryptKey']."') = '".$SearchKey."') "):("");
				}

					
                                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
							


					if($Config['GetNumRecords']==1){
						$Columns = " count(j.JournalID) as NumCount ";				
					}else{		
						$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by j.PostToGL desc,j.JournalDate desc,j.JournalID desc");
					
		
						$Columns = "  j.*,DECODE(j.TotalDebit,'". $Config['EncryptKey']."') as TotalDebit, DECODE(j.TotalCredit,'". $Config['EncryptKey']."') as TotalCredit,  if(j.AdminType='employee',e.UserName,'Administrator') as PostedBy  ";
						if($Config['RecordsPerPage']>0){
							$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
						}
	
					}

						   
				 $strSQLQuery = "select ".$Columns." from f_gerenal_journal j left outer join h_employee e on (j.AdminID=e.EmpID and j.AdminType='employee') ".$strAddQuery;
					
					return $this->query($strSQLQuery, 1);
                }

		
		function isJournalNoExists($JournalNo)
				{
					$strSQLQuery = "SELECT JournalID FROM f_gerenal_journal WHERE JournalNo ='".trim($JournalNo)."'";
					$arryRow = $this->query($strSQLQuery, 1);

					if (!empty($arryRow[0]['JournalID'])) {
						return true;
					} else {
						return false;
					}
				}


		function addJournal($arryDetails,$journalPrefix)
		{

			global $Config;

			$BankTransfer = '0';

			extract($arryDetails);

			$ipaddress = GetIPAddress();
                        
                         if(!empty($Config['CronEntry'])){ //cron entry
				$JournalType = 'one_time';
                                $JournalNo = '';
                                $JournalDate = $Config['TodayDate'];
                                $journalPrefix = $this->getSettingVariable('JOURNAL_NO_PREFIX');
                                
			}else{
				if($_SESSION['locationID']!=''){
				      $LocationID = $_SESSION['locationID'];
				}else{
				      $LocationID = $LocationID;
				}                            
                        }
		
			 
                         if($JournalType == 'one_time'){
				$JournalStartDate=0;$JournalDateFrom='';$JournalDateTo='';$JournalInterval='';$JournalMonth=''; $EntryWeekly = '';
			}
                        
                            if($JournalInterval == 'monthly'){$JournalMonth='';$EntryWeekly = '';}
                            if($JournalInterval == 'yearly'){$EntryWeekly = '';}
                            if($JournalInterval == 'weekly'){$JournalStartDate = 0;$JournalMonth = '';}
                            if($JournalInterval == 'semi_monthly'){$JournalStartDate = 0;$JournalMonth='';$EntryWeekly = '';}
                            #for sales order added by sanjiv
                            $ReferenceID = (!empty($ReferenceID))?$ReferenceID:'';

			if(empty($Currency)) $Currency = $Config['Currency'];

			$strSQLQuery = "INSERT INTO f_gerenal_journal SET BankTransfer = '".$BankTransfer."',JournalNo = '".$JournalNo."', JournalDate='".$JournalDate."',JournalType='".$JournalType."', JournalInterval='".$JournalInterval."', JournalMonth='".$JournalMonth."', EntryWeekly = '".$EntryWeekly."', JournalDateFrom = '".$JournalDateFrom."', JournalDateTo='".$JournalDateTo."', JournalStartDate='".$JournalStartDate."', JournalMemo='".$JournalMemo."', TotalDebit = ENCODE('".$TotalDebit."','".$Config['EncryptKey']."'), TotalCredit = ENCODE('".$TotalCredit."','".$Config['EncryptKey']."'), LocationID='".$LocationID."', Currency='".$Currency."', CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."', ReferenceID = '".$ReferenceID."', AdminID = '". $_SESSION['AdminID']."',AdminType = '". $_SESSION['AdminType']."',ConversionRate='". $ConversionRate."' ";
			//echo $strSQLQuery;die;
			$this->query($strSQLQuery,0);
			$JournalID = $this->lastInsertId();

			//update journal no
			
			if(empty($JournalNo)){

				$JournalNoValue = $journalPrefix.'000'.$JournalID;
				$strSQL = "update f_gerenal_journal set JournalNo = '".$JournalNoValue."' where JournalID='".$JournalID."'"; 
				$this->query($strSQL, 0);
			}

			//end

			return $JournalID;	
		}


		function updateJournal($arryDetails,$journalPrefix)
		{

			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
                        
		         if($JournalType == 'one_time'){
				$JournalStartDate=0;$JournalDateFrom='';$JournalDateTo='';$JournalInterval='';$JournalMonth=''; $EntryWeekly = '';
			}
                        
                            if($JournalInterval == 'monthly'){$JournalMonth='';$EntryWeekly = '';}
                            if($JournalInterval == 'yearly'){$EntryWeekly = '';}
                            if($JournalInterval == 'weekly'){$JournalStartDate = 0;$JournalMonth = '';}
                            if($JournalInterval == 'semi_monthly'){$JournalStartDate = 0;$JournalMonth='';$EntryWeekly = '';}
                        
			if(empty($Currency)) $Currency = $Config['Currency'];

			$strSQLQuery = "update f_gerenal_journal SET  JournalDate='".$JournalDate."',JournalType='".$JournalType."', JournalInterval='".$JournalInterval."', JournalMonth='".$JournalMonth."', EntryWeekly = '".$EntryWeekly."', JournalDateFrom = '".$JournalDateFrom."', JournalDateTo='".$JournalDateTo."', JournalStartDate='".$JournalStartDate."', JournalMemo='".$JournalMemo."', TotalDebit = ENCODE('".$TotalDebit."','".$Config['EncryptKey']."'), TotalCredit = ENCODE('".$TotalCredit."','".$Config['EncryptKey']."'), LocationID='".$_SESSION['locationID']."', Currency='". $Currency."', UpdatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."', ConversionRate='". $ConversionRate."' where JournalID='".$JournalID."'";
			 
			$this->query($strSQLQuery,0);
			 
 	
		}



		function AddUpdateJournalEntry($Journal_ID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
 
			$JournalID = $Journal_ID;

			if(!empty($DelItem)){
				$strSQLQuery = "delete from f_gerenal_journal_entry where JournalEntryID in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}	 

			//Get Journal No.
			$strSQL = "select JournalNo,JournalDate from f_gerenal_journal where JournalID='".$JournalID."'";
			$arryRow = $this->query($strSQL, 1);		 
			$JournalNo = $arryRow[0]['JournalNo'];
			$JournalDate = $arryRow[0]['JournalDate'];
			//end

			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['AccountID'.$i])){
					$AddSql = '';
					/******************/
					if(!empty($BankTransfer) && !empty($arryDetails['BankCurrency'.$i])){			 			$AddSql = ", BankCurrency='".addslashes($arryDetails['BankCurrency'.$i])."' , BankCurrencyRate='".addslashes($arryDetails['BankConversionRate'.$i])."' , ModuleCurrency='".addslashes($Config['Currency'])."' ";
					}
					/******************/ 
					
					if(!empty($arryDetails['JournalEntryID'.$i])){						
                                                  $sql = "update f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt= ENCODE('".$arryDetails['DebitAmnt'.$i]."','".$Config['EncryptKey']."'), CreditAmnt= ENCODE('".$arryDetails['CreditAmnt'.$i]."','".$Config['EncryptKey']."'), Comment='".addslashes($arryDetails['Comment'.$i])."' ".$AddSql."  where JournalEntryID='".$arryDetails['JournalEntryID'.$i]."'"; 
                                                  $this->query($sql, 0);
                                                       
					 }else{
                                            
                                            $sql = "insert into f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt= ENCODE('".$arryDetails['DebitAmnt'.$i]."','".$Config['EncryptKey']."'), CreditAmnt=ENCODE('".$arryDetails['CreditAmnt'.$i]."','".$Config['EncryptKey']."') , Comment='".addslashes($arryDetails['Comment'.$i])."' ".$AddSql;
                                            $this->query($sql, 0);	
                                                
					}
					
				}
			}
		       
			return true;

		}
                
             
		function PostJournalEntryToGL($arryDetails,$JournalID){
			global $Config;
			$ipaddress = GetIPAddress();
			$objBankAccount = new BankAccount();
			//$objConfigure=new configure();
			//$ApGainLoss = $objConfigure->getSettingVariable('ApGainLoss');

			$NumLine = sizeof($arryDetails);
			 
		  	if(empty($Config['PostToGLDate'])) $Config['PostToGLDate'] = $Config['TodayDate'];


			$TotalDebit = 0;
			$TotalCredit = 0;
			for($Line=1;$Line<=$NumLine;$Line++) { 	
				$i=$Line-1;					
				$TotalDebit += $arryDetails[$i]['DebitAmnt'];
				$TotalCredit += $arryDetails[$i]['CreditAmnt'];
			}

			$TotalDebit = round($TotalDebit,2);
			$TotalCredit = round($TotalCredit,2);
			/***********************/
			if(!empty($JournalID)){
				$strSQL = "select JournalNo,JournalDate, Currency, ConversionRate, BankTransfer from f_gerenal_journal where JournalID='".$JournalID."' and PostToGL != 'Yes' ";
				$arryRow = $this->query($strSQL, 1);	 
				$JournalNo = $arryRow[0]['JournalNo'];
				$JournalDate = $arryRow[0]['JournalDate'];
				$Currency = $arryRow[0]['Currency'];				
				if($Currency != $Config['Currency']){
					$ConversionRate = $arryRow[0]['ConversionRate'];
				}
				if(empty($ConversionRate))$ConversionRate = 1;
				if(empty($Currency)) $Currency = $Config['Currency'];
			}
			/***********************
			if(!empty($arryRow[0]['BankTransfer'])){
				$TotalDebit=$TotalCredit=1;
			} 
			/***********************/
 
		if($TotalDebit>0 && $TotalDebit==$TotalCredit && !empty($JournalNo) && !empty($JournalDate)){

 
	
                    for($Line=1;$Line<=$NumLine;$Line++) { 
			$i=$Line-1;	
		
			$AccountID = $arryDetails[$i]['AccountID'];

                        if(!empty($JournalNo) && !empty($AccountID)){                  
                           	
				if(!empty($arryRow[0]['BankTransfer'])){
					/**************** Not in Implemtation
					$BankCurrencySql='';
					$Currency = $Config['Currency'];				
					$DebitAmnt = $arryDetails[$i]['DebitAmnt'];
					$CreditAmnt = $arryDetails[$i]['CreditAmnt'];
					$OriginalDebitAmount = $DebitAmnt;
					$OriginalCreditAmount = $CreditAmnt;
					if($arryDetails[$i]['BankCurrency']!=$Config['Currency']){	
						$BankCurrencyRate = $arryDetails[$i]['BankCurrencyRate'];
						$DebitAmnt = round(GetConvertedAmount($BankCurrencyRate, $DebitAmnt) ,2);
						$CreditAmnt = round(GetConvertedAmount($BankCurrencyRate, $CreditAmnt) ,2);
						$Currency=$arryDetails[$i]['BankCurrency'];
						
					}

					if($i==0){
						$ModuleCurrency2 = $arryDetails[$i+1]['BankCurrency'];
					}else{
						$ModuleCurrency2 = $arryDetails[$i-1]['BankCurrency'];
					}

					$BankCurrencySql = " ,ModuleCurrency2 = '".$ModuleCurrency2."'";
					
					/****************/
				}else{
					/********************/	
					$BankCurrencySql='';
					$arryBankAccount = $objBankAccount->getBankAccountById($AccountID);	
					if($arryBankAccount[0]['BankFlag']=="1" && !empty($arryBankAccount[0]['BankCurrency'])){
						$BankCurrencyArray = explode(",",$arryBankAccount[0]['BankCurrency']);
						$BankCurrency = $BankCurrencyArray[0]; 
						if($BankCurrency!=$Config['Currency']){
							$BankCurrencyRate = CurrencyConvertor(1,$Config['Currency'], $BankCurrency, 'GL',$Config['PostToGLDate']);	
							$BankCurrencySql = " ,BankCurrency = '".$BankCurrency."',BankCurrencyRate='".$BankCurrencyRate."'";
						}
					} 		
				        /********************/	
	 				$DebitAmnt = $arryDetails[$i]['DebitAmnt'];
					$CreditAmnt = $arryDetails[$i]['CreditAmnt'];
					$OriginalDebitAmount = $DebitAmnt;
					$OriginalCreditAmount = $CreditAmnt;
					if($Currency != $Config['Currency']){
						$DebitAmnt = round(GetConvertedAmount($ConversionRate, $DebitAmnt) ,2);
						$CreditAmnt = round(GetConvertedAmount($ConversionRate, $CreditAmnt) ,2);
					}
		               		/********************/	
				}

 
				$strSQLQuery='';

		           	if($DebitAmnt > 0){
		                   $strSQLQuery = "INSERT INTO f_payments SET  AccountName ='".addslashes($arryDetails[$i]['AccountName'])."', JournalID='".$arryDetails[$i]['JournalID']."', AccountID='".addslashes($AccountID)."', DebitAmnt = ENCODE('".$DebitAmnt."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo = '".$JournalNo."', PaymentDate = '".$Config['PostToGLDate']."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Config['PostToGLDate']."',  CreatedDate = '".$Config['TodayDate']."' ,UpdatedDate='". $Config['TodayDate']."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."', ConversionRate = '".$ConversionRate."' , OriginalAmount=ENCODE('".$OriginalDebitAmount. "','".$Config['EncryptKey']."'), TransactionType='D' ".$BankCurrencySql;

					$DebitedAmount = $DebitAmnt;				

		                }

		                if($CreditAmnt > 0){
		                   $strSQLQuery = "INSERT INTO f_payments SET  AccountName ='".addslashes($arryDetails[$i]['AccountName'])."', JournalID='".$arryDetails[$i]['JournalID']."', AccountID='".addslashes($AccountID)."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$CreditAmnt."','".$Config['EncryptKey']."'),  ReferenceNo = '".$JournalNo."', PaymentDate = '".$Config['PostToGLDate']."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Config['PostToGLDate']."', CreatedDate = '".$Config['TodayDate']."',UpdatedDate='". $Config['TodayDate']."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Currency."' , ConversionRate = '".$ConversionRate."' , OriginalAmount=ENCODE('".$OriginalCreditAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ".$BankCurrencySql;
					$CreditedAmount = $CreditAmnt;
					
		                }

				if(!empty($strSQLQuery)){					 
					$this->query($strSQLQuery, 0);
				}
                        	
			 
			}

                       //End Payment Transaction
                    }
	

			/********Post to AP Gain Loss Account***Not in Implemtation***********
			if(!empty($arryRow[0]['BankTransfer'])){
				$Difference =  round(($DebitedAmount - $CreditedAmount),2);
				if(!empty($Difference) && !empty($ApGainLoss)){
					$Module='Journal Entry';
					if($Difference>0){
						$DebitGainLoss = 0;
						$CreditGainLoss = $Difference;
						$PaymentType = $Module.' Gain';	
					}else{
						$DebitGainLoss = str_replace("-","",$Difference);	
						$CreditGainLoss = 0;
						$PaymentType = $Module.' Loss';	
					}

					 $strSQLGainLoss = "INSERT INTO f_payments SET  JournalID='".$JournalID."', AccountID='".addslashes($ApGainLoss)."', DebitAmnt = ENCODE(".$DebitGainLoss.",'".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$CreditGainLoss."','".$Config['EncryptKey']."'),  ReferenceNo = '".$JournalNo."', PaymentDate = '".$Config['PostToGLDate']."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', PostToGL='Yes',PostToGLDate = '".$Config['PostToGLDate']."', CreatedDate = '".$Config['TodayDate']."',UpdatedDate='". $Config['TodayDate']."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";					
					$this->query($strSQLGainLoss, 0);

				} 
				 
			}
			/**********************/
			 

			$strSQLUpdate = "UPDATE f_gerenal_journal SET  PostToGL ='Yes', PostToGLDate='".$Config['PostToGLDate']."', PostToGLTime='".$Config['TodayDate']."' WHERE JournalID='".$JournalID."'";
			$this->query($strSQLUpdate, 0);
			return true; 
		}else{
			return false;
		}


		
        }
               
                

	function AddJournalAttachment($Journal_ID,$arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
			$JournalID = $Journal_ID;
			$strSQLQuery = "insert into f_gerenal_journal_attachment set JournalID='".$JournalID."', CmpID ='".$CmpID."', AttachmentNote='".addslashes($arryDetails['AttachmentNote'])."', CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."'";
		 

			$this->query($strSQLQuery,1);
			$AttachmentID = $this->lastInsertId();

			return $AttachmentID;

		}


		function UpdateJournalAttachment($AttachmentID,$AttachmentName,$arryDetails)
		{  
			 
			$strSQLQuery = "UPDATE f_gerenal_journal_attachment SET AttachmentFile='".addslashes($AttachmentName)."' WHERE AttachmentID = '".mysql_real_escape_string($AttachmentID)."'";
			 $this->query($strSQLQuery, 0);

		}


	function RemoveJournalEntry($JournalID)
		{
			global $Config;
			$objConfigure=new configure();	
			$objFunction=new functions();	
			/******************ARCHIVE RECORD*********************************
			
			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal SELECT * FROM f_gerenal_journal WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);


			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal_attachment SELECT * FROM f_gerenal_journal_attachment WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal_entry SELECT * FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);

			//$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			//$this->query($strSQLQuery, 0);


			/*************************************************/

			$strSQLQuery = "DELETE FROM f_gerenal_journal WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "select AttachmentID,AttachmentFile FROM f_gerenal_journal_attachment WHERE JournalID= '".mysql_real_escape_string($JournalID)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

 
			$AttachmentDir = $Config['FileUploadDir'].$Config['JournalDir'];
			/**************************************************************/
			$MainDir = $Config['FileUploadDir'].$Config['JournalArchiveDir'];

			if(!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}
			/**************************************************************************/

			for($i=0;$i<sizeof($arryRow);$i++) {
				if($arryRow[$i]['AttachmentFile'] !='' && file_exists($AttachmentDir.$arryRow[$i]['AttachmentFile']) ){

					$AttachmentDestination = $MainDir.$arryRow[$i]['AttachmentFile'];

					if (copy($AttachmentDir.$arryRow[$i]['AttachmentFile'],$AttachmentDestination)) {

						$objFunction->DeleteFileStorage($Config['JournalDir'],$arryRow[$i]['AttachmentFile']);
					}

                                 
				}

				
			}

			 

			$strSQLQuery = "DELETE FROM f_gerenal_journal_attachment WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "DELETE FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			//$strSQLQuery1 = "DELETE FROM f_payments WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			//$this->query($strSQLQuery1, 0);
			 
		}		


	function RemoveJournalAttachment($id)
		{
			global $Config;
			$objFunction=new functions();
			$strSQLQuery = "select AttachmentID,AttachmentFile FROM f_gerenal_journal_attachment WHERE AttachmentID= '".mysql_real_escape_string($id)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
 
			$AttachmentDir = $Config['FileUploadDir'].$Config['JournalDir'];
			if($arryRow[0]['AttachmentFile'] !=''  )
			{	
				$objFunction->DeleteFileStorage($Config['JournalDir'],$arryRow[0]['AttachmentFile']);
			}

			$strSQLQuery = "DELETE FROM f_gerenal_journal_attachment WHERE AttachmentID ='".mysql_real_escape_string($id)."'"; 
			$this->query($strSQLQuery, 0);
			return 1;
		}		



	function getJournalById($JournalID)
	{
                global $Config;
		$strSQLQuery = "Select j.*,DECODE(j.TotalDebit,'". $Config['EncryptKey']."') as TotalDebit, DECODE(j.TotalCredit,'". $Config['EncryptKey']."') as TotalCredit from f_gerenal_journal j where j.JournalID = '".mysql_real_escape_string($JournalID)."'";	
		return $this->query($strSQLQuery, 1);
		
	}
	
	function getJournalDt($JournalID)
	{
                global $Config;
		$strSQLQuery = "Select j.JournalID,j.BankTransfer  from f_gerenal_journal j where j.JournalID = '".mysql_real_escape_string($JournalID)."'";	
		return $this->query($strSQLQuery, 1);
		
	}	

function GetJournalEntry($JournalID)
	{       
                global $Config;
		$strSQLQuery = "Select j.*,DECODE(j.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt, DECODE(j.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountNumber from f_gerenal_journal_entry j left outer join f_account f on j.AccountID=f.BankAccountID where j.JournalID = '".mysql_real_escape_string($JournalID)."' order by j.JournalEntryID asc";	
		return $this->query($strSQLQuery, 1);
		
	}		

	function GetJournalAttachment($JournalID)
	{
		$strSQLQuery = "Select * from f_gerenal_journal_attachment where JournalID = '".mysql_real_escape_string($JournalID)."'";	
		return $this->query($strSQLQuery, 1);
		
	}	


		
	function getCustomerList()
	{
		$strSQLQuery = "Select c.Cid as EntityID,CONCAT(c.FirstName,' ', c.LastName) as EntityName from  s_customers c where c.Status = 'Yes'";
				
		return $this->query($strSQLQuery, 1);
		
	}

	function getSupplierList()
	{
		$strSQLQuery = "Select s.SuppCode as EntityID,CONCAT(s.FirstName,' ',s.LastName) as EntityName from  p_supplier s where s.Status = '1'";
				
		return $this->query($strSQLQuery, 1);
		
	}
	
	function getEmployeeList()
	{
		$strSQLQuery = "Select e.EmpID as EntityID,CONCAT(e.FirstName,' ',e.LastName) as EntityName from h_employee e where e.Status = '1'";
				
		return $this->query($strSQLQuery, 1);
		
	}

	function getEntityName($EntityID,$EntityType)
	{

		if($EntityType == "customer"){
	         $strSQLQuery = "Select CONCAT(c.FirstName,' ', c.LastName) as EntityName from  s_customers c where c.Cid = '".$EntityID."'";
		}else if($EntityType == "supplier"){
		 $strSQLQuery = "Select CONCAT(s.FirstName,' ',s.LastName) as EntityName from  p_supplier s where s.SuppCode = '".$EntityID."'";
		}else{
		 $strSQLQuery = "Select CONCAT(e.FirstName,' ',e.LastName) as EntityName from h_employee e where e.EmpID = '".$EntityID."'";
		}
		
		 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['EntityName'];
		
	}

	function getAccountName($AccountID)
	{

		$strSQLQuery = "Select b.AccountName as AccountName from f_account b where b.BankAccountID = '".$AccountID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
				
		if(!empty($arryRow[0]['AccountName'])) return $arryRow[0]['AccountName'];
		
	}
        
        
        function checkJournalDocFile($AttachmentFl,$CmpID)
        {

            $strSQLQuery = "Select AttachmentID from f_gerenal_journal_attachment where AttachmentFile = '".mysql_real_escape_string($AttachmentFl)."' and CmpID = '".mysql_real_escape_string($CmpID)."'"; 
            $arryRow = $this->query($strSQLQuery, 1);
            return $arryRow[0]['AttachmentID'];

        }
        
        /****************Recurring Function Satrt************************************/  
       function RecurringGeneralJournal(){       
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

	  $strSQLQuery = "select j.*,DECODE(j.TotalDebit,'". $Config['EncryptKey']."') as TotalDebit, DECODE(j.TotalCredit,'". $Config['EncryptKey']."') as TotalCredit from f_gerenal_journal as j where j.JournalType ='recurring' and j.JournalDateFrom<='".$arryDate[0]."' and CASE WHEN j.JournalDateTo>0 THEN  j.JournalDateTo>='".$arryDate[0]."' ELSE 1 END = 1  ";
          $arryJournal = $this->query($strSQLQuery, 1);
                                  
       	 // pr($arryJournal); exit;
         
	
	  foreach($arryJournal as $value){

		/**************/
		$ModuleDate = $value['JournalDateTo'];
		$arryDt = explode("-", $ModuleDate);
		$YearOrder = $arryDt[0]; 
		$YearMonthOrder = $arryDt[0].'-'.$arryDt[1];
		/**************/


		$OrderFlag=0;
                if($ModuleDate!=$TodayDate){ 
		switch($value['JournalInterval']){
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
				if($value['JournalStartDate']==$Day && $YearMonthOrder!=$YearMonth){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['JournalStartDate']==$Day && $value['JournalMonth']==$Month && $YearOrder!=$Year){
					$OrderFlag=1;
				}
				break;		
		
		}
		}

		//echo $value['JournalNo'].'<br>'.$OrderFlag;exit;
		if($OrderFlag==1){
			//echo $value['JournalID'].'<br>';die;
	
			$NumLine = 0;
                        
                        $arryJournalEntry = $this->GetJournalEntry($value['JournalID']);
			$NumLine = sizeof($arryJournalEntry);	
                        //print_r($arryJournalEntry);die;
			if($NumLine>0){		
                            
                           
				$JournalID = $this->addJournal($value);
                                
				$this->AddUpdateJournalRecurringEntry($JournalID,$arryJournalEntry);
				
				$strSQL = "update f_gerenal_journal set LastRecurringEntry ='" . $Config['TodayDate'] . "' where JournalID='" . $value['JournalID'] . "'";
				$this->myquery($strSQL, 0);
				 
			}


		}


	  }
       	  return true;
   }
   
   
   
		function AddUpdateJournalRecurringEntry($JournalID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = GetIPAddress();
                        
                         foreach($arryDetails as $values){

                            if(!empty($values['JournalID'])) {			          


                                    $sql = "insert into f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($values['AccountID'])."', AccountName='".addslashes($values['AccountName'])."',  DebitAmnt = ENCODE('".$values['DebitAmnt']."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$values['CreditAmnt']."','".$Config['EncryptKey']."') ";
                                   
                                    $this->query($sql, 0);
					 

                            }
                        }

                      
		       
			return true;

		}
                
                function getSettingVariable($settingKey)
		{
			$strSQLQuery = "select setting_value from settings where setting_key ='".trim($settingKey)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$settingValue = $arryRow[0]['setting_value'];	
			return $settingValue;
			
		}
 
		function setRowColorJournal($JournalID,$RowColor)
		{
			$sql = "update f_gerenal_journal set RowColor='".$RowColor."' where JournalID in ( $JournalID)"; 
			$this->query($sql, 0);
			return true;	
		}

		/********************** Recurring Journal ********************/
		function  ListRecurringJournal($arryDetails)
		{
			global $Config;
			extract($arryDetails);
 			
			$strAddQuery = " where j.JournalType='recurring' ";
			$SearchKey   = strtolower(trim($key));
					
			$strAddQuery .= (!empty($EntryInterval))?(" and j.JournalInterval='".$EntryInterval."'"):("");
			 $strAddQuery .= (!empty($JournalDateFrom))?(" and j.JournalDateFrom>='".$JournalDateFrom."'"):("");
			$strAddQuery .= (!empty($JournalDateTo))?(" and j.JournalDateTo<='".$JournalDateTo."'"):(""); 		 

			$todate = explode(" ", $Config['TodayDate']);
			if($status == 'Active'){				
				$strAddQuery .=  " and (year(j.JournalDateTo) = '0' or  j.JournalDateTo >= '".$todate[0]."') ";
			}else{				 
				$strAddQuery .=  " and (j.JournalDateTo < '".$todate[0]."' and year(j.JournalDateTo) > '0' ) ";
			} 

			if($Config['GetNumRecords']==1){
				$Columns = " count(j.JournalID) as NumCount ";				
			}else{		
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by j.JournalDate desc,j.JournalID desc");

				$Columns = " j.*,DECODE(j.TotalDebit,'". $Config['EncryptKey']."') as TotalDebit, DECODE(j.TotalCredit,'". $Config['EncryptKey']."') as TotalCredit ";
		
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			 $strSQLQuery = "select ".$Columns."  from f_gerenal_journal j  ".$strAddQuery; 
			return $this->query($strSQLQuery, 1);		
				
		}
		
		
	function RemoveRecurringJournal($JournalID){	
 		if(!empty($JournalID)){
			$strSQL = "update f_gerenal_journal set JournalType ='one_time' where JournalID='".$JournalID."'"; 
			$this->query($strSQL, 0);
			
		}
		return true;
	}	
	
	function UpdateJournalRecurring($arryDetails){	
		extract($arryDetails);
		if(!empty($JournalID)){	 
			$strSQL = "update f_gerenal_journal set JournalType='".$JournalType."',  JournalInterval='".$JournalInterval."',  JournalMonth='".$JournalMonth."', EntryWeekly = '".$EntryWeekly."', JournalDateFrom='".$JournalDateFrom."',JournalDateTo='".$JournalDateTo."',JournalStartDate='".$JournalStartDate."' where JournalID='".$JournalID."'"; 
			$this->query($strSQL, 0);			
		}
		return true;
	}
	
	/**********************End Recurring Journal ********************/

	function VoidJournalEntry($JournalID){				

		$strSQL = "SELECT * FROM f_gerenal_journal  WHERE  JournalID='".$JournalID."' and  PostToGL='Yes' ";		
		$arryRow = $this->query($strSQL, 1);
		 
		if(!empty($arryRow[0]['JournalNo'])){
			/*$strSQL2 = "SELECT * FROM f_payments  WHERE  ReferenceNo='".$arryRow[0]['JournalNo']."'  ";		
			$arryRow2 = $this->query($strSQL2, 1);*/
			 			

			$strSQLQuery1 = "DELETE FROM f_payments WHERE ReferenceNo ='".mysql_real_escape_string($arryRow[0]['JournalNo'])."'";  
			$this->query($strSQLQuery1, 0);	

			$strSQLQuery = "UPDATE f_gerenal_journal SET  PostToGL = 'No', PostToGLDate='' where JournalID='".$arryRow[0]['JournalID']."'  ";
			$this->query($strSQLQuery, 0);				

			}		
		}

	/********************************/
	function CreditCardFeeAccountChange(){
		global $Config;
		$ipaddress = GetIPAddress();
		$AccountID = '32';
		$NewAccountID = '18'; 
		$NewAccountName = 'Credit Card Service Expense';
		 

		 $strSQLQuery = "Select j.JournalID, j.JournalMemo, j.JournalNo, j.JournalDate, j.PostToGLDate,  p.PaymentID, je.JournalEntryID, je.AccountID, DECODE(je.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt, DECODE(je.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.BankAccountID, f.AccountNumber from f_gerenal_journal_entry je inner join f_gerenal_journal j on je.JournalID=j.JournalID inner join f_account f on je.AccountID=f.BankAccountID inner join f_payments p on (j.JournalID=p.JournalID and p.AccountID='".$AccountID."')  where j.PostToGL='Yes' and j.PostToGLDate>='2018-".$_GET["f"]."-01' and j.PostToGLDate<'2018-".$_GET["t"]."-01' and je.AccountID='".$AccountID."' and j.JournalMemo like 'Credit Card-INV%' order by j.JournalID asc";

		#$strSQLQuery = "Select p.PaymentDate,  p.PaymentID, p.AccountID, p.JournalID, p.ReferenceNo from f_payments p  where p.AccountID='".$AccountID."' and p.JournalID>0 and p.PaymentDate>='2018-01-01' and p.ReferenceNo like '%[Void]' order by p.PaymentID asc";

		$arryRow = $this->query($strSQLQuery, 1);
		if(empty($_GET['run']))pr($arryRow,1);           
                foreach($arryRow as $values){
			if(!empty($values['JournalEntryID'])){
				$strSQLQuery1 = "UPDATE f_gerenal_journal_entry SET  AccountID = '".$NewAccountID."', AccountName='".$NewAccountName."' where JournalEntryID='".$values['JournalEntryID']."'  ";
				$this->query($strSQLQuery1, 0);	
			}

			if(!empty($values['PaymentID'])){
				$strSQLQuery2 = "UPDATE f_payments SET AccountID = '".$NewAccountID."' where PaymentID='".$values['PaymentID']."'  ";
				$this->query($strSQLQuery2, 0);	
			}
			echo "<br>". $values['JournalNo']."<br>".$values['JournalMemo']."<br>".$strSQLQuery1."<br>".$strSQLQuery2."<br><br>"; 
		}
		
	}
	/********************************/


	function PostBankTransferToGL($arryDetails,$JournalID){
			global $Config;
			$ipaddress = GetIPAddress();
			$objBankAccount = new BankAccount();
			$objConfigure=new configure();
			$ApGainLoss = $objConfigure->getSettingVariable('ApGainLoss');

			$NumLine = sizeof($arryDetails);
			 
		  	if(empty($Config['PostToGLDate'])) $Config['PostToGLDate'] = $Config['TodayDate'];
 
			$TotalDebit = 0;
			$TotalCredit = 0;
			for($Line=1;$Line<=$NumLine;$Line++) { 	
				$i=$Line-1;					
				$TotalDebit += $arryDetails[$i]['DebitAmnt'];
				$TotalCredit += $arryDetails[$i]['CreditAmnt'];
			}
			$TotalDebit = round($TotalDebit,2);
			$TotalCredit = round($TotalCredit,2);

			/***********************/
			if(!empty($JournalID)){
				$strSQL = "select JournalNo,JournalDate, Currency, ConversionRate, BankTransfer from f_gerenal_journal where JournalID='".$JournalID."' and PostToGL != 'Yes' ";
				$arryRow = $this->query($strSQL, 1);	 
				$JournalNo = $arryRow[0]['JournalNo'];
				$JournalDate = $arryRow[0]['JournalDate'];  
				$ConversionRate = 1; 
			}
			  

		if($TotalDebit>0 &&  $TotalCredit>0 && !empty($JournalNo) && !empty($arryDetails[0]['AccountID']) && !empty($arryDetails[1]['AccountID'])){
                                       	

		/****************/ 
		$DebitAmnt = $arryDetails[1]['DebitAmnt'];
		$CreditAmnt = $arryDetails[0]['CreditAmnt'];
		/****************/
		$BankCurrency1 = $arryDetails[0]['BankCurrency'];
		$BankCurrency2 = $arryDetails[1]['BankCurrency'];

		if($BankCurrency1 != $Config['Currency'] && $BankCurrency2 != $Config['Currency'] && $BankCurrency1 != $BankCurrency2){
			$CreditAmnt = round(GetConvertedAmount($arryDetails[0]['BankCurrencyRate'], $CreditAmnt) ,2);
			$OriginalCreditAmount = $CreditAmnt;
		}

		$OriginalDebitAmount = $DebitAmnt;
		$OriginalCreditAmount = $CreditAmnt;
		$Difference =  round(($DebitAmnt - $CreditAmnt),2);

  		/********Post to AP Gain Loss Account***********/  
		$strSQLGainLoss='';
		if(!empty($Difference) && $DebitAmnt!=$CreditAmnt){			 
			if(empty($ApGainLoss)){
				$_SESSION['mess_journal_error'] =  SELECT_GL_AP_ALL;
				return false; die;
			}
			$Module='Journal Entry';
			if($Difference>0){
				$DebitGainLoss = 0;
				$CreditGainLoss = $Difference;
				$PaymentType = $Module.' Gain';	
			}else{
				$DebitGainLoss = str_replace("-","",$Difference);	
				$CreditGainLoss = 0;
				$PaymentType = $Module.' Loss';	
			}

			$strSQLGainLoss = "INSERT INTO f_payments SET  JournalID='".$JournalID."', AccountID='".addslashes($ApGainLoss)."', DebitAmnt = ENCODE(".$DebitGainLoss.",'".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$CreditGainLoss."','".$Config['EncryptKey']."'),  ReferenceNo = '".$JournalNo."', PaymentDate = '".$Config['PostToGLDate']."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='".$PaymentType."', PostToGL='Yes',PostToGLDate = '".$Config['PostToGLDate']."', CreatedDate = '".$Config['TodayDate']."',UpdatedDate='". $Config['TodayDate']."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' ";			 

		} 		 
		/**********************/

		
           	if($DebitAmnt > 0 && $CreditAmnt > 0){
                   	$strSQLQuery = "INSERT INTO f_payments SET  AccountName ='".addslashes($arryDetails[1]['AccountName'])."', JournalID='".$JournalID."', AccountID='".addslashes($arryDetails[1]['AccountID'])."', DebitAmnt = ENCODE('".$DebitAmnt."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo = '".$JournalNo."', PaymentDate = '".$Config['PostToGLDate']."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Config['PostToGLDate']."',  CreatedDate = '".$Config['TodayDate']."' ,UpdatedDate='". $Config['TodayDate']."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Config['Currency']."', ConversionRate = '".$ConversionRate."' , OriginalAmount=ENCODE('".$OriginalDebitAmount. "','".$Config['EncryptKey']."'), TransactionType='D' "; 
			$this->query($strSQLQuery, 0);				

              
                   	$strSQLQuery2 = "INSERT INTO f_payments SET  AccountName ='".addslashes($arryDetails[$i]['AccountName'])."', JournalID='".$JournalID."', AccountID='".addslashes($arryDetails[0]['AccountID'])."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$CreditAmnt."','".$Config['EncryptKey']."'),  ReferenceNo = '".$JournalNo."', PaymentDate = '".$Config['PostToGLDate']."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Config['PostToGLDate']."', CreatedDate = '".$Config['TodayDate']."',UpdatedDate='". $Config['TodayDate']."', IPAddress='".$ipaddress."'  , AdminID = '". $_SESSION['AdminID']."', AdminType = '". $_SESSION['AdminType']."' , ModuleCurrency = '".$Config['Currency']."' , ConversionRate = '".$ConversionRate."' , OriginalAmount=ENCODE('".$OriginalCreditAmount. "','".$Config['EncryptKey']."'), TransactionType='C' ";
			$this->query($strSQLQuery2, 0);

			if(!empty($strSQLGainLoss)){
				$this->query($strSQLGainLoss, 0);
			}
			
                }		 
		
			 

			$strSQLUpdate = "UPDATE f_gerenal_journal SET  PostToGL ='Yes', PostToGLDate='".$Config['PostToGLDate']."', PostToGLTime='".$Config['TodayDate']."' WHERE JournalID='".$JournalID."'";
			$this->query($strSQLUpdate, 0); 
			return true; 
		}else{
			return false;
		}


		
        }
               
}
?>
