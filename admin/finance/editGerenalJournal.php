<?php
	/**************************************************/
	$ThisPageName = 'viewGerenalJournal.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/function.class.php");

	$objJournal = new journal();
	$objCommon = new common();
	$objBankAccount = new BankAccount();
	$objFunction = new functions();
		

	$JournalID = isset($_GET['edit'])?$_GET['edit']:"";	
	$ListUrl = "viewGerenalJournal.php?curP=".$_GET['curP'];
	$ModuleName = "Journal Entry";
	$MainModuleName = "General Journal";	
		 
                
		if(!empty($JournalID)){

			$arryJournal = $objJournal->getJournalById($JournalID);
			$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);
			$NumLine = sizeof($arryJournalEntry);

			$arryJournalAttachment = $objJournal->GetJournalAttachment($JournalID);
			$num=$objJournal->numRows();
 
		
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
			header("location:editGerenalJournal.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."");
			exit;
		}

		//$NumLine = sizeof($arrySaleItem);
		if(empty($NumLine)) $NumLine = 1;	
        
		
		//get setting variables
			
		$journalPrefix = $objCommon->getSettingVariable('JOURNAL_NO_PREFIX');	
		
	
		
 	if (is_object($objJournal)) {
            
            if ($_POST) {
			    CleanPost();
	 	 
               		  if (!empty($JournalID)) {
				  if(empty($_POST['JournalDate']) || empty($_POST['JournalType']) || ($_POST['TotalDebit'] != $_POST['TotalCredit'])) {
						$_SESSION['mess_journal'] = INVALID_FORM_ENTRY;
						header("Location:editGerenalJournal.php?edit=".$JournalID."&curP=".$_GET['curP']."");
						exit;
					}else{
						$_SESSION['mess_journal'] = $ModuleName.UPDATED;
						/******************************/
						 CleanPost();
						/******************************/
						$objJournal->updateJournal($_POST);
						 
					    }

                                 }else{
					   
					   if(empty($_POST['JournalDate']) || empty($_POST['JournalType']) || ($_POST['TotalDebit'] != $_POST['TotalCredit'])) {
							 $errMsg = FILL_ALL_MANDANTRY_FIELDS;
							 $_SESSION['mess_journal'] = INVALID_FORM_ENTRY;
							 header("Location:editGerenalJournal.php");
	                                                 exit;
							
						}else{
					  
							/******************************/
							 CleanPost();
							/******************************/
							$_SESSION['mess_journal'] = $ModuleName.ADDED;
							$JournalID = $objJournal->addJournal($_POST,$journalPrefix);
						
							 
					      }
				  }

				if(!empty($JournalID)){				

				  $objJournal->AddUpdateJournalEntry($JournalID, $_POST); 
				

				 if($_FILES['AttachmentFile']['name'] != ''){

						
								
						$FileArray = $objFunction->CheckUploadedFile($_FILES['AttachmentFile'],"Document");
						
				                if(empty($FileArray['ErrorMsg'])){
                                                    
                                                      $AttachmentID = $objJournal->AddJournalAttachment($JournalID,$_POST);

							$AttachmentExtension = GetExtension($_FILES['AttachmentFile']['name']); 

							//$AttachmentName = $AttachmentID.".".$AttachmentExtension;
                                                       
                                                        $revfile=strrev($_FILES['AttachmentFile']['name']);		// Reverse the string for getting the extension
                                                        $arr_t=explode(".",$revfile);
                                                        $file_name=$arr_t[1];
                                                        $AttachmentName = strrev($file_name);
                                                        $AttachmentName = str_replace(' ', '_', $AttachmentName);
							$AttachmentName = $AttachmentName.'_'.$AttachmentID.".".$AttachmentExtension;		
							$MainDir = "upload/journal/".$_SESSION['CmpID']."/";	
					
							if (!is_dir($MainDir)) {
								mkdir($MainDir);
								chmod($MainDir,0777);
							}
							$AttachmentDestination = $MainDir.$AttachmentName;
							
					
							if(@move_uploaded_file($_FILES['AttachmentFile']['tmp_name'], $AttachmentDestination)){
								$objJournal->UpdateJournalAttachment($AttachmentID,$AttachmentName);
							}
						    }
					      else{
							$ErrorMsg = $FileArray['ErrorMsg'];
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

         }
		
    
	 //$_GET['Status'] = 'Yes';
         //$arryAccountType = $objBankAccount->getAccountType($_GET);

        $arryBankAccountList = $objBankAccount->getBankAccountWithAccountType();

   require_once("../includes/footer.php"); 
 
 
 ?>
