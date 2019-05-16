<?php
        /**************************************************/
	
	/**************************************************/
	require_once("../includes/header.php");
	require_once("../../classes/item.class.php");
	
	
	
	$objItem = new items();
	
	
	if (!empty($_POST)&&($_GET['active_id'])=='add')
	{
		$arryEbayCredentials= $objItem->Getdata();
		if(sizeof($arryEbayCredentials)<=0)
	{
		$objItem->Addebaycredentials($_POST);
		
		$_SESSION['CRE_Update'] =CRE_ADD;
		
		
	}
	else
	{
		
		$arrydata=$objItem->UpdateCredentials($_POST);	
		
	
	
	if($arrydata=="1")
	{
	$arryEbayCredentials= $objItem->Getdata();	
	
	//echo "<pre>";print_r($arryEbayCredentials);exit;
	$_SESSION['CRE_Update'] =CRE_Update;
	}
	}
		
	}
	
	else if($_POST['ebayid']>0)
	{
		//echo 'abbbb';exit;
	    $arrydata=$objItem->UpdateCredentials($_POST);	
		
	
	
	if($arrydata=="1")
	{
	$arryEbayCredentials= $objItem->Getdata();	
	//echo "<pre>";print_r($arryEbayCredentials);exit;
	$_SESSION['CRE_Update'] =CRE_Update;
	}
	

	}
	else
	{
	$arryEbayCredentials= $objItem->Getdata();

	}
		
	if (!empty($_GET['edit']))
		{
		
			//18002580918
			
		}
	
	
	require_once("../includes/footer.php"); 
	
?>
