<?php 
/**************************************************************/
$ThisPageName = ''; 
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();
        $objImportEmail=new email();

	
	

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
	$RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

	$EditUrl = "sentEmails.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 


        /*
	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
         * 
         */
        
        
        if(isset($_POST['DeleteButton']))
        {
		CleanPost(); 
             foreach($_POST['emailID'] as $key=>$emailuniqueId){
                 if($emailuniqueId > 0){
                      $objImportEmail->DeletePermanentEmail($emailuniqueId);  
                 }
                $_session['TrashCanMsg']="Email deleted Successfully";
             }

             $RedirectURL = "draftList.php?curP=".$_GET['curP'];
             header('location:'.$RedirectURL);
		exit;
        }
        
        //start checking ownerEmailId and their active email id
        if($_SESSION['AdminType']!='admin')
        {
           //$empEmailId=$objImportEmail->GetAdminEmailId($_SESSION['AdminID'],$_SESSION['CmpID']);
           $OwnerEmailId=$_SESSION['EmpEmail'];
           
              $activeData=mysql_query("select * from importemaillist where DefalultEmail=1 and status=1 and AdminID='".$_SESSION['AdminID']."'");
              $count_num=mysql_num_rows($activeData);
              if($count_num > 0)
              {
                 $activeDataEmailID=mysql_fetch_array($activeData);
                 $activeDataEmailID[EmailId]; 
              }
                        
        }
        
        else {
              $OwnerEmailId=$_SESSION['AdminEmail'];
              
              
              $activeData=mysql_query("select * from importemaillist where DefalultEmail=1 and status=1 and AdminID='".$_SESSION['AdminID']."'");
              $count_num=mysql_num_rows($activeData);
              if($count_num > 0)
              {
                 $activeDataEmailID=mysql_fetch_array($activeData);
                 $activeDataEmailID[EmailId]; 
              }
              
        } 
        //end checking ownerEmailId and their active email id
        
        
        if(isset($_GET['flag_id']) && !empty($_GET['flag_id']) && ($_GET['flag_id']> 0))
        {
            
            $objImportEmail->ChangeFlagStatus($_GET['flag_id']);
            $RedirectURL = "draftList.php?curP=".$_GET['curP'];
            header('location:'.$RedirectURL);
            exit;
        }
        $arrySentItems = $objImportEmail->draftItems($OwnerEmailId,'',$activeDataEmailID[EmailId]);

        
        $Config['RecordsPerPage'] = $RecordsPerPage;
        //echo $Config['RecordsPerPage'];die('hhh');
        if(empty($_GET['sortby']) && empty($_GET['key']))
        {
          /*********Get Email Data***********/
            $arrySentItems = $objImportEmail->draftItems($OwnerEmailId,'',$activeDataEmailID[EmailId]);
          /*********Count Records************/
            $Config['GetNumRecords']=1;
            $arryCount = $objImportEmail->draftItems($OwnerEmailId,'',$activeDataEmailID[EmailId]);
            $num=$arryCount[0]['NumCount'];
        
        }else {
         /*********Get Email Data***********/
         $arrySentItems = $objImportEmail->draftEmailWithSearch($OwnerEmailId,'',$activeDataEmailID[EmailId],$_GET['sortby'],$_GET['key']);
         
         /*********Count Records************/
            $Config['GetNumRecords']=1;
            $arryCount = $objImportEmail->draftEmailWithSearch($OwnerEmailId,'',$activeDataEmailID[EmailId],$_GET['sortby'],$_GET['key']);
            $num=$arryCount[0]['NumCount'];
         
        }
        $pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
 
	require_once("../includes/footer.php"); 	 
?>
