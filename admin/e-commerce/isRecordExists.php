<?php
	session_start();
	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/category.class.php");
	require_once($Prefix."classes/product.class.php");
	require_once($Prefix."classes/manufacturer.class.php");
		
	$objConfig=new admin();	
	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();

	(empty($_GET['editID']))?($_GET['editID']=""):("");
	(empty($_GET['ParentID']))?($_GET['ParentID']=""):("");
	(empty($_GET['ProductID']))?($_GET['ProductID']=""):("");

	/* Checking for category existance */
	if(!empty($_GET['CategoryName'])){
		$objCategory = new category();
		if($objCategory->isCategoryExists($_GET['CategoryName'],$_GET['editID'],$_GET['ParentID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	

	/* Checking for Product Number existance */
	if(!empty($_GET['ProductSku'])){
		$objProduct = new product();
		if($objProduct->isProductNumberExists($_GET['ProductSku'],$_GET['ProductID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Manufacturer Code existance */
	if(!empty($_GET['Mcode'])){
		(empty($_GET['Mid']))?($_GET['Mid']=""):("");

		$objManufacturer=new manufacturer();
		if($objManufacturer->isManufacturerNumberExists($_GET['Mcode'],$_GET['Mid'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}



?>
