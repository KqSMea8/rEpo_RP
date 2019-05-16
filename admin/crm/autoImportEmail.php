<?php

session_start();
set_time_limit(20);

$Prefix = "../../";
require_once($Prefix . "includes/config.php");
require_once($Prefix . "includes/function.php");
require_once($Prefix . "classes/dbClass.php");
require_once($Prefix . "classes/admin.class.php");
require_once($Prefix."classes/email.class.php");

$objConfig = new admin();
(empty($_GET["action"])) ?($_GET["action"]="") :("");

if(empty($_SERVER['HTTP_REFERER'])){
	//echo 'Protected.';exit;
}

/* * ******Connecting to main database******** */
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */
 
CleanGet();

if($_GET['action']=='autoImportEmail'){       
	$objImportEmail=new email();                
        $EmailListId=$objImportEmail->GetEmailListId($_SESSION['AdminID'],$_SESSION['CmpID']);
 
	if(!empty($EmailListId[0]['id'])){
		$countExist=$objImportEmail->GetInboxEmailCount($EmailListId[0]['id']);		 
		//echo $EmailListId[0][id].'---'.$countExist[0]['TotalRecords'];exit;
		if(!empty($countExist[0]['TotalRecords']) ){		    
		    echo $objImportEmail->fetchEmailsFromServer($EmailListId[0]['id'],'UNSEEN','');      
		}
	}
 
}

?>
