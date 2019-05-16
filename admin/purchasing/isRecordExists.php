<?	session_start();
	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/supplier.class.php");	
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	
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
	(empty($_GET['Multiple']))?($_GET['Multiple']=""):("");
	(empty($_GET['editID']))?($_GET['editID']=""):("");


	/* Checking for Company existance */
	if($_GET['Multiple'] == "1" && !empty($_GET['CompanyName'])){
		$objSupplier = new supplier();
		if($objSupplier->isCompanyExists($_GET['CompanyName'],$_GET['editID'])){
			echo "2";
		}else{
			if(!empty($_GET['Email'])){
				if($objSupplier->isEmailExists($_GET['Email'],$_GET['editID'])){
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}


	/* Checking for Supplier existance */
	if($_GET['Type'] == "Supplier" && !empty($_GET['Email'])){
		$objSupplier = new supplier();
		if($objSupplier->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	

	/* Checking for SuppCode existance */
	if(!empty($_GET['SuppCode'])){
		$objSupplier = new supplier();
		if($objSupplier->isSuppCodeExists($_GET['SuppCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Company existance */
	if(!empty($_GET['CompanyName'])){
		$objSupplier = new supplier();
		if($objSupplier->isCompanyExists($_GET['CompanyName'],$_GET['editID'])){
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
	
	/* Checking for QuoteID existance */
	if(!empty($_GET['QuoteID'])){
		$objPurchase=new purchase();
		if($objPurchase->isQuoteExists($_GET['QuoteID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for PurchaseID existance */
	if(!empty($_GET['PurchaseID'])){
		$objPurchase=new purchase();
		if($objPurchase->isPurchaseExists($_GET['PurchaseID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for PoInvoiceID existance */
	if(!empty($_GET['PoInvoiceID'])){
		$objPurchase=new purchase();
		if($objPurchase->isInvoiceExists($_GET['PoInvoiceID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for PoCreditID existance */
	if(!empty($_GET['PoCreditID'])){
		$objPurchase=new purchase();
		if($objPurchase->isCreditIDExists($_GET['PoCreditID'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for ReturnID existance */
	if(!empty($_GET['ReturnID'])){
		$objPurchase=new purchase();
		if($objPurchase->isReturnExists($_GET['ReturnID'],$_GET['editID'])){
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

	/* Checking for termName existance */
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
