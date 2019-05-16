<?php 
 	include_once("includes/header.php");
	require_once("classes/customer.class.php");
        
	  $customerObj=new Customer();
	  
	 if (is_object($customerObj)) {
	 	$arrySubscribers=$customerObj->getSubscribers($id,$status,$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num=$customerObj->numRows();
	

                          }
  
  require_once("includes/footer.php");
  
?>
