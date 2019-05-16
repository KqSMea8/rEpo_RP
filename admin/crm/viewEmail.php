<?php 
/**************************************************************/
if($_GET['type']=='sent')
   {
     $ThisPageName = "sentEmails.php"; 
   }else if($_GET['type']=='trash')
   {
     $ThisPageName = "trashEmail.php";   
   }
   else if($_GET['type']=='Draft')
   {
     $ThisPageName = "draftList.php";   
   }
   else if($_GET['type']=='inbox')
   {
     $ThisPageName = "viewImportedEmails.php";   
   }
   else if($_GET['type']=='spam')
   {
     $ThisPageName = "spamEmail.php";   
   }
   
   else {
        $ThisPageName = "sentEmails.php";
   }
   
   
   
   if(($_GET['flagged']=='Yes'))
       {
          $ThisPageName = "flaggedEmail.php";
       }
   
   $ViewPage = 1; if(!empty($_GET['pop']))$HideNavigation = 1;
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	
	$_GET['ViewId'] = (int)$_GET['ViewId'];

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
        if($_GET[type]=='sent')
        {
         
         $Type='sent';
	 $RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
        }else if($_GET[type]=='trash')
        {
           $Type='trash';  
           $RedirectURL = "trashEmail.php?curP=".$_GET['curP']."&module=".$_GET["module"];   
        }
        else if($_GET[type]=='inbox')
        {
           $Type='inbox'; 
           $RedirectURL = "viewImportedEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];   
        }else if($_GET['type']=='spam')
        {
           $Type='spam'; 
           $RedirectURL = "spamEmail.php?curP=".$_GET['curP']."&module=".$_GET["module"];
             
        }
        else if($_GET['type']=='Draft')
        {
           $Type='Draft'; 
           $RedirectURL = "draftList.php?curP=".$_GET['curP']."&module=".$_GET["module"];
             
        }
        else {
           $Type='sent';
           $RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
       }
       
       if(!empty($_GET['FolderId']))
       {
          $RedirectURL = "viewFolderEmails.php?FolderId=".$_GET['FolderId'];  
       }
       
      
       if(($_GET['flagged']=='Yes'))
       {
          $RedirectURL = "flaggedEmail.php";  
       }
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

        /*
	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
        */
       
        if(isset($_POST))
        {
	    CleanPost();

            if(!empty($_POST['ViewId']))
            {
              if(($_POST['Type']=='sent') || ($_POST['Type']=='inbox'))
              {
                  $objImportEmail->GoToTrashCan($_POST['ViewId']);
                  //$RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
				  if($_GET['pop']!=1){
                  header('Location: '.$RedirectURL);
				  }
                  $_SESSION['TrashCanMsg']="The conversation has been moved to the Trash.";
              }
              if(($_POST['Type']=='trash') || ($_POST['Type']=='Draft') || ($_POST['Type']=='spam'))
              {
                  
                  $objImportEmail->DeletePermanentEmail($_POST['ViewId']);
                  //$RedirectURL = "trashEmail.php?curP=".$_GET['curP']."&module=".$_GET["module"];
                  header('Location: '.$RedirectURL);
                  $_SESSION['TrashCanMsg']="The conversation deleted Successfully";
                   
              }
            }   
        }
        
        
         //start checking ownerEmailId and their active email id
        if($_SESSION['AdminType']!='admin')
        {
           //$empEmailId=$objImportEmail->GetAdminEmailId($_SESSION['AdminID'],$_SESSION['CmpID']);
           $OwnerEmailId=$_SESSION['EmpEmail'];
           
              $activeData=mysql_query("select * from importemaillist where DefalultEmail=1 and status=1 and AdminID=".$_SESSION['AdminID']);
              $count_num=mysql_num_rows($activeData);
              if($count_num > 0)
              {
                 $activeDataEmailID=mysql_fetch_array($activeData);
                 $activeDataEmailID[EmailId]; 
              }
                        
        }
        
        else {
              $OwnerEmailId=$_SESSION['AdminEmail'];
              
              
              $activeData=mysql_query("select * from importemaillist where DefalultEmail=1 and status=1 and AdminID=".$_SESSION['AdminID']);
              $count_num=mysql_num_rows($activeData);
              if($count_num > 0)
              {
                 $activeDataEmailID=mysql_fetch_array($activeData);
                 $activeDataEmailID[EmailId]; 
              }
              
        } 
        //end checking ownerEmailId and their active email id
        
        
        
        if(isset($_GET['ViewId']) && !empty($_GET['ViewId']))
        {
              
           $arrySentItems = $objImportEmail->ViewEmail($OwnerEmailId,$_GET['ViewId']);
           $num=$objImportEmail->numRows();
	   $objImportEmail->updateSendMailStatus($_GET['ViewId']);
		
        }
		
 
	require_once("../includes/footer.php"); 	 
?>
