<?php $NavText=1;  
$InnerPage=1;
require_once("includes/header.php");
require_once(_ROOT."/classes/dbfunction.class.php");
require_once(_ROOT."/classes/customer.supplier.class.php"); 

$permission = array();
$data=array();


/************************/
if($_GET['CmpID']>0){
	$_SESSION['CmpID'] = $_GET['CmpID'];
	require_once("includes/select_cmp.php");
	header("location:dashboard.php");
	exit;
}
/************************/

$userPermission=array();  
 	$objCustomerSupplier= new CustomerSupplier();  	
	if($_SESSION['UserType']=="customer" OR $_SESSION['UserType']=='vendor' || $_SESSION['UserType']=="customerContact"){
		$Customer_ID=$_SESSION['ref_id'];
		$arryDepartment= $objConfigure->GetDepartment();  // For Company	
			;
		$NumAllowedDepartment = sizeof($arryDepartment);
		/********** User Detail **********/	
		  	$Config['DbName'] = $Config['DbMain'];
		 	$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();		           
		    $userPermission =$objCustomerSupplier->getCustVenPermission($_SESSION['CompanyUserID'],$_SESSION['ref_id'],$_SESSION['CmpID']);
			if(!is_array($userPermission)){
			$userPermission=explode(',',$userPermission);
			}
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
 
 	

/* menu rename start from here*/

  $arryRM8 = $objConfigure->getRightMenuByDepId(8,'2016',1);
  $arryRM0 = $objConfigure->getRightMenuByDepId(0,'2016',1);


function is_in_array($array, $key, $key_value){
      $within_array = 'no';
      foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if( $within_array == 'yes' ){
                break;
            }
        } else {
                if( $v == $key_value && $k == $key ){
                        $within_array = 'yes';
                        break;
                }
        }
      }
      return $within_array;
}


if(is_in_array($arryRM0, 'Link', 'contacts')=='yes'){
    $arr = $objConfigure->getRightMenuByLink('contacts');
     $vcontacts=$arr[0]['Module'];
}else{
     $vcontacts='Contacts';
}

if(is_in_array($arryRM0, 'Link', 'bank')=='yes'){
    $arr1 = $objConfigure->getRightMenuByLink('bank');
     $vbank=$arr1[0]['Module'];
}else{
     $vbank='Bank Details';
}

if(is_in_array($arryRM0, 'Link', 'billing')=='yes'){
    $arr2 = $objConfigure->getRightMenuByLink('billing');
     $vbilling=$arr2[0]['Module'];
}else{
     $vbilling='Billing Address';
}


if(is_in_array($arryRM0, 'Link', 'shipping')=='yes'){
    
    $arr3 = $objConfigure->getRightMenuByLink('shipping');
    $vshipping=$arr3[0]['Module'];
}else{
     $vshipping='Shipping Address';
}


if(is_in_array($arryRM0, 'Link', 'purchase')=='yes'){
    $arr6 = $objConfigure->getRightMenuByLink('contacts');
     $vpurchase=$arr6[0]['Module'];
}else{
     $vpurchase='Purchase History';
}


if(is_in_array($arryRM8, 'Link', 'so')=='yes'){
    $arr4 = $objConfigure->getRightMenuByLink('so');
     $vso=$arr4[0]['Module'];
}else{
     $vso='Sales Orders';
}


if(is_in_array($arryRM8, 'Link', 'invoice')=='yes'){
    $arr5 = $objConfigure->getRightMenuByLink('invoice');
     $vinvoice=$arr5[0]['Module'];
}else{
     $vinvoice='Invoice';
}

if(is_in_array($arryRM0, 'Link', 'general')=='yes'){
    $arr7 = $objConfigure->getRightMenuByLink('general');
     $vgeneral=$arr7[0]['Module'];
}else{
     $vgeneral='General Information';
} 

/* menu rename start from here*/


					$permission=array();
					
					if($_SESSION['UserType']=='customer'){
						if(in_array(5,$depids)){															
						$permission['quote']='Quotes';
						$permission['document']='Documents';
						$permission['contact']= $vcontacts;
						$permission['bank']= $vbank;
						}		
						if(in_array(6,$depids)){
						$permission['invoice']= $vinvoice;
						$permission['purchaseorder']= $vpurchase;
						$permission['salesorder']= $vso;
						$permission['shipping']= $vshipping;
						$permission['billing']= $vbilling;
						$permission['items']='Products';	
						 																
						}
					////added by karishma
					if(in_array(9,$depids) ){
					    $permission['website']='Website Management';
					}
					//////
					}

					if($_SESSION['UserType']=='customerContact'){
						if(in_array(5,$depids)){
							$permission['quote']='Quotes';
							$permission['document']='Documents';
							$permission['contact']= $vcontacts;
							$permission['bank']= $vbank;
						}
						if(in_array(6,$depids)){
							$permission['invoice']= $vinvoice;
							$permission['purchaseorder']= $vpurchase;
							$permission['salesorder']= $vso;
							$permission['shipping']= $vshipping;
							$permission['billing']= $vbilling;
							$permission['items']='Products';
								
						}
						////added by karishma
						if(in_array(9,$depids) ){
							$permission['website']='Website Management';
						}
						//////
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
	else if($_SESSION['UserType']=='customerContact')
	include("includes/html/box/v_customerContact.php");
	else
	include("includes/html/box/v_supplier.php");
	require_once("includes/footer.php"); 
?>
