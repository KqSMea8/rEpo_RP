<?php
        /**************************************************/
	
	/**************************************************/
	require_once("../includes/header.php");
	require_once("../../classes/item.class.php");
	require_once("../../classes/product.class.php");
	
	
	
	$objItem = new items();
	$objProduct = new product();
	
	if($_POST) { 
		$arryEbayCredentials= $objItem->Getdata();
		if(sizeof($arryEbayCredentials)<=0)
		{
			$objItem->Addebaycredentials($_POST);
			$_SESSION['CRE_Update'] =CRE_ADD;
		}
		else if($_POST['ebayid']>0)
		{
		   $arrydata=$objItem->UpdateCredentials($_POST);	
		   $_SESSION['CRE_Update'] =CRE_Update;
		}
	
	}	
	
	$arryEbayCredentials= $objItem->Getdata();
	
	
	require_once("../includes/footer.php"); 
	
?>
