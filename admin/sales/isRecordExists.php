<?php	session_start();
		$Prefix = "../../"; 
		require_once($Prefix."includes/config.php");
		require_once($Prefix."includes/function.php");
		require_once($Prefix."classes/dbClass.php");
		require_once($Prefix."classes/admin.class.php");
		require_once($Prefix."classes/sales.customer.class.php");	
		require_once($Prefix."classes/sales.class.php");
		require_once($Prefix."classes/sales.quote.order.class.php");

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

	(empty($_GET['Type']))?($_GET['Type']=""):("");
	(empty($_GET['editID']))?($_GET['editID']=""):("");

	/* Checking for Customer existance */
	if($_GET['Type'] == "Customer" && $_GET['Email'] != ""){
		$objCustomer = new Customer();
		if($objCustomer->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	/* Checking for ReturnID existance */
	if(!empty($_GET['CustCode'])){
		$objCustomer = new Customer();
		if($objCustomer->isCustCodeExists($_GET['CustCode'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
/* Checking for Sale Order existance */
	 
	if(!empty($_GET['SaleID'])){
		$objSale = new sale();
		if($objSale->isSaleExists($_GET['SaleID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

/* Checking for QuoteID existance */
	 
	if(!empty($_GET['QuoteID'])){
		$objSale = new sale();
		if($objSale->isQuoteExists($_GET['QuoteID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	
	/* Checking for Sale Invoice number existance */
	 
	if(!empty($_GET['SaleInvoiceID'])){
		$objSale = new sale();
		if($objSale->isInvoiceNumberExists($_GET['SaleInvoiceID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for ReturnID existance */
	if(!empty($_GET['ReturnID'])){	 
		$objSale = new sale();
		if($objSale->isReturnExists($_GET['ReturnID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	
	/* Checking for SaleCreditID existance */
	 
	if(!empty($_GET['SaleCreditID'])){	 
		$objSale=new sale();
		if($objSale->isCreditIDExists($_GET['SaleCreditID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	
	/* Checking for Attribute existance */
	if(!empty($_GET['AttributeValue'])){
	  	$objCommon=new common();
		if($objCommon->isAttributeExists($_GET['AttributeValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Fixed Attribute existance */	 
	if(!empty($_GET['AttribValue'])){
		$objCommon=new common();
		if($objCommon->isAttribExists($_GET['AttribValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for ReturnID existance */	 
	if(!empty($_GET['termName'])){
		$objCommon=new common();
		if($objCommon->isTermExists($_GET['termName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

?>
