<?php 
$FancyBox = 1;
if($_GET['pop']=='Yes')$HideNavigation = 1;

/**************************************************************/
$ThisPageName = 'viewRulesForEmail.php'; $EditPage = 1;
/**************************************************************/
        
	include_once("../includes/header.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	//$objContact=new contact();
	$objEmployee=new employee();
	$objCustomer=new Customer();  


	$_GET['edit'] = (int)$_GET['edit'];
	$_GET['emailNo'] = (int)$_GET['emailNo'];

	$ModuleName = "Rule";
	$RedirectURL = "viewRulesForEmail.php?module=".$_GET['module']."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="basic";

	$EditUrl = "editImportEmailRule.php?edit=".$_GET["edit"]."&module=".$_GET['module']."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
        
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
             
	     $_SESSION['mess_contact1'] = 'Email Rule has been deleted successfully';
             
             $objImportEmail->RemoveRuleId($_GET['del_id']);
             $RedirectURL = "viewRulesForEmail.php?curP=".$_GET['curP'];  
             header("Location:".$RedirectURL);
	}
        
        if($_GET['active_id'] && !empty($_GET['active_id'])){
             
	     $_SESSION['mess_contact1'] = 'Email Rule Status has been changed successfully';
             
             $objImportEmail->UpdateStatusRuleId($_GET['active_id']);
             $RedirectURL = "viewRulesForEmail.php?curP=".$_GET['curP'];  
             header("Location:".$RedirectURL);
	}
        
        
        
        
        
        

        $FolderList=$objImportEmail->ListFolderName('',$_SESSION[AdminID],$_SESSION[CmpID]);
                               
        $EmailListData=$objImportEmail->GetEmailListId($_SESSION[AdminID], $_SESSION[CmpID]);	
        if($_SESSION['AdminType']!='admin')
        {
           $OwnerEmailId=$_SESSION['EmpEmail'];
        }else {
            $OwnerEmailId=$_SESSION['AdminEmail'];
        } 
        
        
        if($_GET['emailNo']> 0)
        {
            $emailInfo=$objImportEmail->GetEmailInfoById($_GET['emailNo']);

            $emailInfo[0]["From_Email"]=$emailInfo[0]["From_Email"];

            $RuleDataArray=$objImportEmail->CheckExistRule($emailInfo[0]["From_Email"],$EmailListData[0]['EmailId'],$_SESSION[AdminID],$_SESSION[CmpID]);
            
        }
        if($_GET['edit']> 0){
            
            $RulesDetails=$objImportEmail->GetEmailRuleDetails($_GET['edit']);
            $emailInfo[0]["From_Email"]=$RulesDetails[0]["RuleForEmail"];  
        }
        
        
        
        
	 if ($_POST) {
             
             
             CleanPost(); 
             
             	  
               if(empty($_POST["RuleID"]))
               {
                   
                  
                  
                  if($_POST['FirstTimeAdded']=='Yes')
                  {
                     $_POST['RuleForEmail']= $_POST['RuleEmail']; 
                  }
                  
                  $TotalRuleData=$objImportEmail->CheckExistRule($_POST['RuleForEmail'],$EmailListData[0]['EmailId'],$_SESSION[AdminID],$_SESSION[CmpID]);
                  if(sizeof($TotalRuleData) < 1){
                  $objImportEmail->AddEmailRule($_POST);
                  $_SESSION['mess_contact1']="Rule is added successfully.";
                  }else {
                      
                      $_SESSION['mess_contact1']="Already Exist.";
                  }
                  if($_GET['pop']=='Yes')
                   {
               ?>  
                  <script>
                      //$.fancybox.close();
                   $('.message', window.parent.document).html('Rule is added successfully.');
                   parent.jQuery.fancybox.close();
                   //window.parent.refresh();
                   //$.fancybox.close();
                 </script>                      
               <?php
                   } else {
                       header('Location: viewRulesForEmail.php');
                   }
                 //header('Location: viewRulesForEmail.php');
               }
               else if(!empty($_POST["RuleID"]) && ($_POST["RuleID"] > 0)){
                   
                   
                   $objImportEmail->UpdateEmailRule($_POST);
                   $_SESSION['mess_contact1']="Rule is updated successfully.";
                   
                   if($_GET['pop']=='Yes')
                   {
                 ?> 
                 <script>
                     //$.fancybox.close();
                   $('.message', window.parent.document).html('Rule is updated successfully.');
                   parent.jQuery.fancybox.close();
                   //$.fancybox.close();
                   //window.parent.refresh();
                   
                   
                 </script>
                <?php 
                   }else {
                       header('Location: viewRulesForEmail.php');
                   }
                  
               } 
             
		//header('Location:viewRulesForEmail.php');
	      //echo '<script>parent.location.reload(true);</script>';
              //echo '<script>window.location.href="https://www.google.co.in";</script>';
	
         }	
					
	
	$_GET['Status']=1;$_GET['Division']=5;

	require_once("../includes/footer.php"); 	 
?>
<script>
                                      //  $('.message', window.parent.document).html('Email already exist.');
                                       // parent.jQuery.fancybox.close();
                                       // $.fancybox.close();
         
                   </script>
                  
				
