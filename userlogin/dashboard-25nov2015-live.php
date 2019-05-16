<?php $NavText=1;  
$InnerPage=1;
require_once("includes/header.php");
require_once(_ROOT."/classes/dbfunction.class.php");
require_once(_ROOT."/classes/customer.supplier.class.php"); 
$permission = array();
$data=array();
$userPermission=array();  
 	$objCustomerSupplier= new CustomerSupplier();  	
	if($_SESSION['UserType']=="customer" OR $_SESSION['UserType']=='vendor'){
		$Customer_ID=$_SESSION['ref_id'];
		$arryDepartment= $objConfigure->GetDepartment();  // For Company	
			;
		$NumAllowedDepartment = sizeof($arryDepartment);
		/********** User Detail **********/	
		  	$Config['DbName'] = $Config['DbMain'];
		 	$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();		           
		    $userPermission =$objCustomerSupplier->getCustVenPermission($_SESSION['UserID'],$_SESSION['ref_id'],$_SESSION['CmpID']);
			$Config['DbName'] = $_SESSION['CmpDatabase'];
		 	$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			
			/********** User Detail **********/	
		
	}	
	$depids=array();
 	if(!empty($arryDepartment)){
 		foreach($arryDepartment as $arryDepartm){
 			$depids[]=$arryDepartm['depID'];
 			
 		}
 	}
 
 	

					$permission=array(	)	;	
					if($_SESSION['UserType']=='customer'){
						if(in_array(5,$depids)){															
						$permission['quote']='Quotes';
						$permission['document']='Documents';
						$permission['contact']='Contacts';
						$permission['bank']='Bank Details';
						}		
						if(in_array(6,$depids)){
						$permission['invoice']='Invoice';
						$permission['purchaseorder']='Purchase History';
						//$permission['salesorder']='Sales Orders';
						$permission['shipping']='Shipping Address';
						$permission['billing']='Billing Address';																
						}
					}
					if($_SESSION['UserType']=='vendor'){
							if(in_array(5,$depids)){	
								$permission['contact']='Contacts';
								$permission['bank']='Bank Details';
								}		
							if(in_array(6,$depids)){
								$permission['invoice']='Invoice';
								$permission['purchaseorder']='Purchase Order';
								//$permission['salesorder']='Sales Orders';
								$permission['shipping']='Shipping Address';
								$permission['billing']='Billing Address';																
								}
					}
		
			
			
		if(!empty($_GET['tab']) AND  $_GET['tab']!='general' AND (!array_key_exists($_GET['tab'],$permission)  OR !in_array($_GET['tab'],$userPermission))){
						
						//header('location:http://www.google.com');
			header('location:'._SiteUrl.'userlogin/dashboard.php?tab=general');
		}
					
	/****************************/
	/*
	if(empty($_SESSION["LoginUpdated"]) && $_SESSION['AdminType']!="admin"){
		$objConfigure->UpdateLoginTime();
		$_SESSION["LoginUpdated"] = 1;
	}*/

	$arryLocationMenu = $objConfigure->getLocation('',1); 
	$NumLocation = sizeof($arryLocationMenu); 
	if($_SESSION['UserType']=='customer')
	include("includes/html/box/v_customer.php");
	else
	include("includes/html/box/v_supplier.php");
	require_once("includes/footer.php"); 
?>
