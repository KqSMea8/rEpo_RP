<?php

include_once("../includes/header.php");
require_once($Prefix . "classes/finance.journal.class.php");
require_once($Prefix . "classes/finance.account.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("includes/FieldArray.php");
$objJournal = new journal();
$objFilter = new filter();

(empty($_GET['module'])) ? ($_GET['module'] = "Journal") : ("");

$objBankAccount = new BankAccount();

$ModuleName = "General Journal";

$ViewUrl = "viewGeneralJournal.php";
$AddUrl = "editGeneralJournal.php";
$EditUrl = "editGeneralJournal.php?curP=" . $_GET['curP'];
$ViewUrl = "vGeneralJournal.php?curP=" . $_GET['curP'];
$RedirectURL = "viewGeneralJournal.php?curP=" . $_GET['curP'];

if(!empty($_GET['PK564575686796554'])){
	#$objJournal->CreditCardFeeAccountChange();die;
}

/*************Void Journal Entry***********/
	if(!empty($_GET['void_id'])) { 
		$_SESSION['mess_journal'] = "Journal voided";	
		$objJournal->VoidJournalEntry($_GET['void_id']);
		header("location:" . $RedirectURL);
		exit;
	}
/******************************************/
/* * *******CODE FOR POST TO GL************************************* */

if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {
	
	   CleanPost();
	$Config['PostToGLDate'] = $_POST['PostToGLDate'];

	foreach ($_POST['posttogl'] as $JournalID) {
		$arryJournal = $objJournal->getJournalDt($JournalID);

		$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);

		if(!empty($arryJournal[0]["BankTransfer"])){        	
			$resp = $objJournal->PostBankTransferToGL($arryJournalEntry,$JournalID);
		}else{
			$resp = $objJournal->PostJournalEntryToGL($arryJournalEntry,$JournalID);
		}

	}

	if($resp==1){
		 $_SESSION['mess_journal'] = POSTED_TO_GL_AACOUNT;
	}else if(!empty($_SESSION['mess_journal_error'])){
		$_SESSION['mess_journal'] = $_SESSION['mess_journal_error'];
		unset($_SESSION['mess_journal_error']);
	}
   
    header("Location:" . $RedirectURL);
    exit;
}

/* * *******END CODE*********************************** */

/**************Row color functionality by nisha************************/       
 if(!empty($_POST['posttogl']) && !empty($_POST['RowColor'])) {
	CleanPost();
        $JournalID = implode(",", $_POST['posttogl']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
						if($_POST['RowColor']=='None') $_POST['RowColor']='';
						$objJournal->setRowColorJournal($JournalID,$_POST['RowColor']);
                      $_SESSION['mess_journal'] = ROW_HIGHLIGHTED;
header("location:".$RedirectURL);
 
       //exit;
        }
      
       
    
}       
/***************end row color code************************/
/*********************Custom Filter ************/        
  if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}
        
        
/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if(!empty($arryDefult[0]['setdefault']) && $_GET['customview'] == "" ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
    
    
    
if (!empty($_GET["customview"]) ) {
    #$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
   

    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
	$colValue=$colRule='';
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");
       

        foreach ($arryQuery as $colRul) {
            
            
            //CODE EDIT FOR DECODE
            
                if($colRul['columnname'] == 'TotalDebit')
                  {
                      $colRul['columnname'] = "DECODE(j.TotalDebit,'". $Config['EncryptKey']."')";


                  }
                  
                  else if($colRul['columnname'] == 'TotalCredit')
                  {
                      $colRul['columnname'] = "DECODE(j.TotalCredit,'". $Config['EncryptKey']."')";


                  }

                  else{

                      $colRul['columnname'] = 'j.'.$colRul['columnname'];
                  }
            
             //END CODE DECODE
            
                if ($colRul['columnname'] == 'Status') {

                        if (strtolower($colRul['value']) == strtolower(ST_CLR_CREDIT)) {
                        
                               $colRul['value'] = 'Completed';
                        } else if (strtolower($colRul['value'])== strtolower(ST_TAX_APP_HOLD)) {
                               $colRul['value'] = 'Open';
                                if ($colRul['comparator'] == 'e') {
                                $colRule  .= " and o.tax_auths = 'Yes'  ";
                                }else{
                                    
                                    $colRule  .= " and o.tax_auths != 'Yes'  ";
                                }
                        } else if (strtolower($colRul['value'])== strtolower(ST_CREDIT_HOLD)) {
                               $colRul['value'] = 'Open';
                               
                                if ($colRul['comparator'] == 'n') {
                                $colRule  .= " and o.tax_auths != 'No'";
                                }else{
                                    
                                    $colRule  .= " and o.tax_auths  = 'No'";
                                }
                               
                               
                        }
                 }elseif($colRul['columnname'] == 'EntryType'){
                     
                     $colRul['value'] = str_replace(" ", "_", strtolower($colRul['value']));
                     
                 }

            if ($colRul['comparator'] == 'e') {
               
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'in') {
                $comparator = 'in';

                $arrVal = explode(",", $colRul['value']);

                $FinalVal = '';
                foreach ($arrVal as $tempVal) {
                    $FinalVal .= "'" . trim($tempVal) . "',";
                }
                $FinalVal = rtrim($FinalVal, ",");
                $setValue = trim($FinalVal);

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        
        $_GET['rule'] = $colRule;
       // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/****************************End Custom Filter****************************************/
  
/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryGerenalJournal = $objJournal->ListGerenalJournal($_GET);
 
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objJournal->ListGerenalJournal($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	




require_once("../includes/footer.php");
?>


