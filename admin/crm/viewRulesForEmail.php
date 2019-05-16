<?php 
        
        //error_reporting(-1);
        $ThisPageName = 'viewRulesForEmail.php'; 
	include_once("../includes/header.php");
	//require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix . "classes/filter.class.php");
        require_once($Prefix . "classes/email.class.php");
        $objFilter = new filter();
        //(empty($_GET['module'])) ? ($_GET['module'] = "Email") : ("");
	$ModuleName = "Email";
	$objImportEmail=new email();
	$objCustomer=new Customer(); 
        
       

/* * **************************End Custom Filter*************************************** */
       
        
        //print_r($_SESSION);
        $activated_listData=$objImportEmail->GetEmailListId($_SESSION['AdminID'],$_SESSION['CmpID']);

	$Config['RecordsPerPage'] = $RecordsPerPage;
         /*********Get Email Data***********/
	$arryRuleList=$objImportEmail->ListEmailRules($activated_listData[0]["EmailId"],$_SESSION['AdminID'],$_SESSION['CmpID']);
        
        /*********Count Records************/
            $Config['GetNumRecords']=1;
            $arryCount = $objImportEmail->ListEmailRules($activated_listData[0]["EmailId"],$_SESSION['AdminID'],$_SESSION['CmpID']);
            $num=$arryCount[0]['NumCount'];
         $pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);

	require_once("../includes/footer.php"); 	 
?>


