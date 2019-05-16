<?php
	/**************************************************/
	$ThisPageName = 'viewGeneralJournal.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/function.class.php");
         require_once($Prefix."classes/finance.report.class.php");
	
	 
        $objReport = new report();

	$objJournal = new journal();
	$objCommon = new common();
	$objBankAccount = new BankAccount();
	$objFunction = new functions();
		

	$JournalID = isset($_GET['edit'])?$_GET['edit']:"";	
	$ListUrl = "viewGeneralJournal.php?curP=".$_GET['curP'];
	$ModuleName = "Journal Entry";
	$MainModuleName = "General Journal";
        
        //GET FISCAL YEAR
        
         $FiscalYearStartDate = $objCommon->getSettingVariable('FiscalYearStartDate');
         $FiscalYearEndDate = $objCommon->getSettingVariable('FiscalYearEndDate');
         
        
        //GET CURRENT PERIOD
         
       
         $currentDate = date('Y-m-d');
         $CurrentPeriodDate = $objReport->getCurrentPeriodDate('GL');
      	 $GLCurrentPeriod = 'Current Period : '.date("F Y",strtotime($CurrentPeriodDate));

         //GET BACK OPEN MONTH
         $arryBackMonth = $objReport->getBackOpenMonth('GL');
         
         $strBackDate = '';
         for($i=0;$i<count($arryBackMonth);$i++)
         {
            
             $strBackDate .= $arryBackMonth[$i]['PeriodYear'].'-'.$arryBackMonth[$i]['PeriodMonth'].',';
         }
        
        $strBackDate = rtrim($strBackDate,",");
        
		 
                
		if(!empty($JournalID)){

			$arryJournal = $objJournal->getJournalById($JournalID);
			$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);
			$NumLine = sizeof($arryJournalEntry);

			$arryJournalAttachment = $objJournal->GetJournalAttachment($JournalID);
			$num=$objJournal->numRows();	

			if(empty($arryJournal[0]["JournalID"])) {
				header("Location:".$ListUrl);
				exit;
			}else if($arryJournal[0]["PostToGL"]=="Yes") {
				header("Location:".$ListUrl);
				exit;
			}	
		
		}
                
 
		

            

		if(!empty($_GET['del_id'])){
			$_SESSION['mess_journal'] = $ModuleName.REMOVED;
			$objJournal->RemoveJournalEntry($_GET['del_id']);
			header("location:".$ListUrl);
			exit;
		}

		if(!empty($_GET['del_attach_id'])){
			$_SESSION['mess_journal'] = ATTACHMENT_REMOVED;
			$objJournal->RemoveJournalAttachment($_GET['del_attach_id']);
			header("location:editGeneralJournal.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."");
			exit;
		}

		//$NumLine = sizeof($arrySaleItem);
		if(empty($NumLine)) $NumLine = 2;	
        
		
		//get setting variables
			
		$journalPrefix = $objCommon->getSettingVariable('JOURNAL_NO_PREFIX');	
		
	
		

            
            if (!empty($_POST)) {

			CleanPost();
 			$ErrorValidate = '';
			if(empty($_POST['BankTransfer']) &&  empty($_POST['ConversionRate']) && !empty($_POST['Currency']) && $_POST['Currency']!=$Config['Currency']){
				$_POST['ConversionRate'] = CurrencyConvertor(1,$_POST['Currency'],$Config['Currency'],'GL',$_POST['JournalDate']);
			}
 
			if(!empty($_POST['BankTransfer'])){
				$TotalDebit = $TotalCredit = 0;				
				if(empty($_POST['DebitAmnt2']) || empty($_POST['CreditAmnt1'])){
					$ErrorValidate = INVALID_FORM_ENTRY;
				}

				$_POST['TotalDebit'] =  round($_POST['DebitAmnt2'],2);
				$_POST['TotalCredit'] = round($_POST['CreditAmnt1'],2);
				$_POST['ConversionRate'] = 1; //$_POST['BankConversionRate1'];
				$_POST['Currency'] = $_POST['BankCurrency1'].",".$_POST['BankCurrency2'];
			}else{
				$TotalDebit = round($_POST['TotalDebit'],2);
				$TotalCredit = round($_POST['TotalCredit'],2);
			}

			/*************/			
			if(empty($_POST['JournalDate']) || empty($_POST['JournalType']) || empty($_POST['AccountID1']) || empty($_POST['AccountID2']) || ($TotalDebit != $TotalCredit)) {
				$ErrorValidate = INVALID_FORM_ENTRY;
			}
 
			if(!empty($ErrorValidate)){
				$_SESSION['mess_journal'] = $ErrorValidate;
				header("Location:editGeneralJournal.php?edit=".$JournalID);
				exit;
			}
			/*************/
			//pr($_POST,1);die;

			if(!empty($JournalID)) {				 
				$_SESSION['mess_journal'] = $ModuleName.UPDATED;
				$objJournal->updateJournal($_POST); 
			}else{
				$_SESSION['mess_journal'] = $ModuleName.ADDED;
				$JournalID = $objJournal->addJournal($_POST,$journalPrefix);
			}

			if(!empty($JournalID)){				

			    $objJournal->AddUpdateJournalEntry($JournalID, $_POST); 
			
 
			    if($_FILES['AttachmentFile']['name'] != ''){


				$AttachmentID = $objJournal->AddJournalAttachment($JournalID,$_POST);

				$heading = escapeSpecial($_FILES['AttachmentFile']['name']);		

				$FileInfoArray['FileType'] = "Document";
				$FileInfoArray['FileDir'] = $Config['JournalDir'];
				$FileInfoArray['FileID'] =  $heading."_".$AttachmentID;
				//$FileInfoArray['OldFile'] = $_POST['OldImage'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['AttachmentFile'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){  
					 $objJournal->UpdateJournalAttachment($AttachmentID,$ResponseArray['FileName']);
				 
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}
							
				if(!empty($ErrorMsg)){
					if(!empty($_SESSION['mess_journal'])) $ErrorPrefix = '<br><br>';
					$_SESSION['mess_journal'] .= $ErrorPrefix.$ErrorMsg;
				}		
							  
			}          
		 }
                       
                       
		header("Location:".$ListUrl);
		exit;
				
            }

  
		
    

	/*$RetainedEarning = $objCommon->getSettingVariable('RetainedEarning');
	if($RetainedEarning>0){
		$Config['ExcludeAccount'] = $RetainedEarning;
	}*/
        $arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();

	
   	require_once("../includes/footer.php"); 
 
 ?>
