<?php
	/**************************************************/
	$ThisPageName = 'viewCustomer.php';
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/customer.class.php");
        
                $objCustomer=new Customer();
            
                       $CustId = isset($_GET['view'])?$_GET['view']:"";	
                       $ListUrl = "viewCustomer.php?curP=".$_GET['curP'];
                       $ListTitle = "Customers";
                       $ModuleTitle = "View Customer";
                       $ModuleName = "Customer";
                       
                     if(!empty($CustId)){  
                      $arryCustomer = $objCustomer->getCustomerById($CustId);
                      $CustomerGroup = $objCustomer->getCustomerGroupName($arryCustomer[0]['GroupID']);
                     }
                      
                      
            
  


 require_once("../includes/footer.php"); 
 
 
 ?>
