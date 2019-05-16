<?php
        /**************************************************/
	
	/**************************************************/
	require_once("../includes/header.php");
	require_once("../../classes/product.class.php");
	
	
	
	$objProduct = new product();
	$ListUrl = 'AmazonCredentials.php';
	
	if (isset($_POST['save_account']))
	{	
		CleanPost($_POST);
		$objProduct->addAmazonAccount($_POST);
		$_SESSION['amazon_Update'] ='New account is added successfully!';
		header("location:".$ListUrl);
	}
	
	if (isset($_POST['update_account']))
	{	
		CleanPost($_POST);
		$objProduct->updateAmazonAccount($_POST); 
		$_SESSION['amazon_Update'] ="Account has been updated successfully!";
		header("location:".$ListUrl);
	}
	
	if (!empty($_GET['active_id']))
	{	
		$_GET['active_id'] = (int) $_GET['active_id'];
		$objProduct->updateAmazonAccountStatus($_GET['active_id'],$_GET['status']); 
		$_SESSION['amazon_Update'] ="Account status has been changed successfully!";
	}
	
	if (!empty($_GET['default_id']))
	{
		$_GET['active_id'] = (int) $_GET['default_id'];
		if($_GET['sync_product']){
			$objProduct->updateAmazonAccountSetDefault($_GET['default_id'],$_GET['status']);
			$_SESSION['amazon_Update'] ="Set default for this account is updated successfully!";
		}else{ 
			$_SESSION['amazon_Update'] ="Lowest price for Set defaults is set as NO.Please edit and save as YES first!!";
		}
	}
	
	$id = (!empty($_GET['edit'])) ? (int)$_GET['edit'] : '';
	$arryAmazons = $objProduct->GetAmazonAccount($id);	
	require_once("../includes/footer.php"); 
	
?>
