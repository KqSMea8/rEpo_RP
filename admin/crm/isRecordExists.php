<?	session_start();
	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/item.class.php");
        require_once($Prefix."classes/contact.class.php");
        require_once($Prefix."classes/filter.class.php");
	require_once($Prefix."classes/sales.customer.class.php");	
	require_once($Prefix."classes/field.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");	
	require_once($Prefix."classes/role.class.php");
require_once($Prefix."classes/webcms.class.php"); //By Karishma 28Oct 2015.//
	$objConfig=new admin();	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	CleanGet();

	(empty($_GET['editID']))?($_GET['editID']=""):("");
	(empty($_GET['Type']))?($_GET['Type']=""):("");


	/* Checking for Employee Email existance */
	if($_GET['Type'] == "Employee" && !empty($_GET['Email'])){
		$_GET['RefID'] = $_GET['editID'];
		$_GET['CmpID'] = $_SESSION['CmpID'];
		if($objConfig->isUserEmailDuplicate($_GET)){		
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Customer Login existance */
	if($_GET['Type'] == "Customer" && !empty($_GET['Email'])){
		$_GET['ref_id'] = $_GET['editID'];
		$_GET['user_type'] = $_GET['Type'];
		$_GET['CmpID'] = $_SESSION['CmpID'];
		if($objConfig->isUserEmailDuplicate($_GET)){	
			echo "1";exit;
		}
		
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();
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

	/* Checking for Customer existance */
	if($_GET['Type'] == "Customer" && !empty($_GET['Email'])){
		$objCustomer = new Customer();
		if($objCustomer->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	
	
	/* Checking for CustCode existance */
	if(!empty($_GET['CustCode'])){
		$objCustomer = new Customer();
		if($objCustomer->isCustCodeExists($_GET['CustCode'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

       if($_GET['Type'] == "Ticket" && !empty($_GET['FilterName'])){
		$objFilter = new filter();
		if($objFilter->isFilterExists($_GET['FilterName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	



	/* Checking for SKU Number existance */
	if(!empty($_GET['Sku'])){
		$objItem = new items();
		if($objItem->isItemNumberExists($_GET['Sku'],$_GET['editID'],$_GET['PostedByID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Employee existance 
	if($_GET['Type'] == "Employee" && !empty($_GET['Email'])){
		$objEmployee = new employee();
		if($_GET['Email']==$_SESSION['AdminEmail']){
			echo "1";
		}else if($objEmployee->isEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}*/

	


/* Checking for Lead existance */
	if($_GET['Type'] == "Lead" && !empty($_GET['primary_email'])){
		$objLead = new lead();
		if($objLead->isprimary_emailExists($_GET['primary_email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

/* Checking for Opportunity Name existance */
	if(!empty($_GET['QuoteSubject'])){
		$objQuote=new quote();
		if($objQuote->isQuoteExists($_GET['QuoteSubject'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Event Subject existance */
	if(!empty($_GET['EventSubject'])){
		$objActivity=new activity();
		if($objActivity->isEventExists($_GET['EventSubject'],$_GET['editID'],$_GET['Type'])){
			echo "1";
		}else if($objActivity->isEventDateExists($_GET['startDate'],$_GET['closeDate'],$_GET['closeTime'],$_GET['startTime'],$_GET['editID'],$_GET['Type'])){
			echo "2";
		}else{
			echo "0";
		}
		exit;
	}
/* Checking for Opportunity Name existance */
	if(!empty($_GET['OpportunityName'])){
		$objLead=new lead();
		if($objLead->isOpportunityNameExists($_GET['OpportunityName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

/* Checking for Opportunity Name existance */
	if(!empty($_GET['TicketTitle'])){
		$objLead=new lead();
		if($objLead->isTicketTitleExists($_GET['TicketTitle'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	
	
	/* Checking for Attribute existance */
	if(!empty($_GET['HeadValue'])){
		$objField=new field();
		if($objField->isHeadExists($_GET['HeadValue'],$_GET['module'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Attribute existance */
/*	if(!empty($_GET['AttributeValue'])){
		$objCommon=new common();
		if($objCommon->isAttributeExists($_GET['AttributeValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}*/

	

	/* Checking for DocumentTitle existance */
	if(!empty($_GET['DocumentTitle'])){
		$objLead = new lead();
		if($objLead->isDocumentExists($_GET['DocumentTitle'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for Fixed Attribute existance */
	if(!empty($_GET['FAttribValue'])){
		$objCommon=new common();	
		if($objCommon->isFAttribExists($_GET['FAttribValue'],$_GET['attribute_id'],$_GET['editID'])){
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
	/* Checking for Attribute existance */
	if(!empty($_GET['WAttribValue'])){
		$objCommon=new common();
		if($objCommon->isWAttributeExists($_GET['WAttribValue'],$_GET['attribute_id'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	if(!empty($_GET['group_name'])){
		$objRole = new role();
		if($objRole->isGroupNameExists($_GET['group_name'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	if(!empty($_GET['FolderName'])){
		$objLead = new lead();
		if($objLead->CheckDocumentFolderName($_GET['FolderName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
/* Checking for EmpCode existance //By Chetan3July//*/
	if(!empty($_GET['fieldname'])){
		$objField = new field();
		if($objField->isFieldExists($_GET['fieldname'],$_GET['editID'],$_GET['mod'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

// 28 oct 2015 check site name avialbilty
if(!empty($_GET['Sitename']) && $_GET['editID']!=''){
	$webcmsObj=new webcms();
	if($webcmsObj->isSitenameExists($_GET['Sitename'],$_GET['editID'])){
		echo "1";
	}else{
		echo "0";
	}
	exit;
}

	 /* Checking for methodName existance */
	if(!empty($_GET['methodName'])){
		$objCommon=new common();
		if($objCommon->isMethodExists($_GET['methodName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

	/* Checking for EmpCode existance */
	if(!empty($_GET['EmpCode'])){
		$objEmployee = new employee();
		if($objEmployee->isEmpCodeExists($_GET['EmpCode'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

?>
