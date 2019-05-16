<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix . "classes/inv_category.class.php");
	$objCategory = new category();
 	$objCustomer = new Customer();  

	(empty($_GET['CatID']))?($_GET['CatID']=""):("");
	(empty($_GET['rtype']))?($_GET['rtype']=""):("");
        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
        	  
	 
	/*************/
	unset($_SESSION['CatIDs']);unset($_GET['CategoryID']);
	if(!empty($_GET['CatID'])){			
		$objCategory->GetCatIDByParent($_GET['CatID']);
		$ArrayCatID = array_unique($_SESSION['CatIDs']);
		 $_GET['CategoryID'] = implode(",",$ArrayCatID);		
	}
	/*************/


	$arryData=$objCustomer->GetSalesProductByCategory($_GET);
	
	$num = sizeof($arryData);
	 
	require_once("../includes/footer.php"); 	
?>


