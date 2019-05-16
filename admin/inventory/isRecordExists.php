<?	session_start();
	$Prefix = "../../"; 
	require_once($Prefix."includes/config.php");
    	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");
	require_once($Prefix."classes/inv_category.class.php");
        require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/inv.class.php");
	require_once($Prefix."classes/employee.class.php");	
	require_once("../language/english.php");

	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}
		
	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
	$objConfig=new admin();	

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	CleanGet();

	(empty($_GET['Type'])) ? ($_GET['Type']='') : ("");  
	(empty($_GET['PostedByID'])) ? ($_GET['PostedByID']='') : (""); 
	(empty($_GET['editID']))?($_GET['editID']=""):("");

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




	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	/////////////////////////////////
	/////////////////////////////////

	/* Checking for Employee existance */
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


	

	/* Checking for Currency existance */ 
	if(!empty($_GET['Currency'])){ 
		$objRegion=new region();
		if($objRegion->isCurrencyExists($_GET['Currency'],$_GET['editID'])){
			echo "1";
		}else{
		
			if($objRegion->isCurrencyCodeExists($_GET['CurrencyCode'],$_GET['editID'])){
				echo "2";
			}else{
				echo "0";
			}
			
		}

		exit;
		
	}
	

	

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

/* Checking for Condition existance */
	if(!empty($_GET['ConditionName'])){
		$objCondition = new condition();
		if($objCondition->isConditionExists($_GET['ConditionName'],$_GET['editID'],$_GET['ParentID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	

	/* Checking for Product existance */
	if(!empty($_GET['ItemName'])){
		$objItem = new items();
		if($objItem->isProductExists($_GET['ItemName'],$_GET['ItemID'],$_GET['CategoryID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}


	/* Checking for Product Number existance */
	if(!empty($_GET['Sku'])){ 
		$objItem = new items();
		if($objItem->isItemNumberExists($_GET['Sku'],$_GET['editID'],$_GET['PostedByID'])){
			echo "1";
		}else{
			if($objItem->isItemAliasExists($_GET['Sku'],'')){
				echo "1";
			}else{
				echo "0";
			}
			
		}
		exit;
	}

	/* end */

/* Checking for Product Number existance */
	if(!empty($_GET['bom_Sku'])){
		$objBom = new bom();
		  if($objBom->isBomSkuExists($_GET['bom_Sku'],$_GET['editID'])){
		   echo "1";
		   }else{
		     echo "0";
		   }
		    exit;
	  }
	if(!empty($_GET['BOMSKU'])){
		$objBom = new bom();
		  if($objBom->isBomSkuExists($_GET['BOMSKU'],$_GET['editID'])){
		   echo "1";
		   }else{
		     echo "0";
		   }
		    exit;
	  }
if(!empty($_GET['OPTIONCODE'])){
		$objBom = new bom();
		  if($objBom->isOptionCodeExists($_GET['OPTIONCODE'],$_GET['editID'])){
		   echo "1";
		   }else{
		     echo "0";
		   }
		    exit;
	  }

	/* end */

/* Checking for Model Number existance */
if(!empty($_GET['ModelNo'])){
		$objItem = new items();
		  if($objItem->isModelExists($_GET['ModelNo'],$_GET['editID'])){
		   echo "1";
		   }else{
		    echo "0";
		   }
		    exit;
	  }

	/* end */



if(!empty($_GET['Serial_No'])){
		$objItem = new items();
		if($objItem->isSerialExists($_GET['Serial_No'],$_GET['edit'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
if(!empty($_GET['RateDes'])){
		$objTax = new tax();
		if($objTax->isTaxNameExists($_GET['RateDes'],$_GET['Class'],$_GET['country'],$_GET['state'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
                
                
                
	}
        
       
	
    if(!empty($_GET['checkItem'])){
		$objBom= new bom();
		if($objBom->isSkuNameExists($_GET['checkItem'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
                
                
                
	}

 if(!empty($_GET['checkMergeItem'])){
		$objBom= new bom();
		if($objBom->isMergeSkuExists($_GET['checkMergeItem'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;            
                
                
	}
 if(!empty($_GET['bom_code'])){
		$objBom= new bom();
		if($objBom->isBomCodeExists($_GET['bom_code'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
                
                
                
	}

/* Checking for ItemAliasCode existance */
	if(!empty($_GET['ItemAliasCode'])){ 
		$objItem = new items();
		if($objItem->isItemNumberExists($_GET['ItemAliasCode'],'','')){
			echo "1";
		}else{
			if($objItem->isItemAliasExists($_GET['ItemAliasCode'],$_GET['editID'],'')){
				echo "1";
			}else{
				echo "0";
			}
			
		}
		exit;
	}

	/* end */
	

?>
