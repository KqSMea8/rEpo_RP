<?php
	session_start();
	date_default_timezone_set('America/New_York');

    	require_once("../includes/config.php");
    	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/item.class.php");	
	require_once("../classes/admin.class.php");	
	require_once("../classes/user.class.php");	
	require_once("../classes/question.class.php");	
	require_once("../classes/configure.class.php");	

	$objConfig=new admin();
	

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	
	(empty($_POST['action']))?($_POST['action']=""):("");

switch($_POST['action']){
	case 'SecurityLevel':  
		$objUser=new user();
		$questionObj=new question();	
		$objConfigure=new configure();
	 
		$objUser->UpdateSecurityLevel($_POST);		
	 
		if($_POST['EnableSecurity'] != $_POST['UserSecurity']){ //onchange
			$questionObj->DeleteSecurityProfile($_SESSION['UserID'],$_SESSION['AdminType']);
			$objConfigure->ResetAuthSecretKey($_SESSION['UserID'],$_SESSION['AdminType']);			
		} 
	 	break;
		exit;

	case 'RemoveSecurityQuestion':  
		$questionObj=new question();
		$questionObj->DeleteSecurityProfile($_POST["UserID"],"employee");			 
		 
	 	break;
		exit;

	case 'EmpSecurityLevel':  
		$objUser=new user();
		$questionObj=new question();	
		$objConfigure=new configure();
	 	$AdminType = "employee";	
		$objUser->UpdateEmpSecurityLevel($_POST);		
 
		if($_POST['EnableSecurityUser'] != $_POST['UserSecurity']){ //onchange
			$questionObj->DeleteSecurityProfile($_POST["UserID"],$AdminType);
			$objConfigure->ResetAuthSecretKey($_POST["UserID"],$AdminType);			
		} 
	 	break;
		exit;


case 'itemAdd':
$errors         = array();      
$data           = array();      

    if (empty($_POST['Sku']))
        $errors['Sku'] = 'Sku is required.';

   
if($_POST['Sku'] != ""){ 
		$objItem = new items();
		if($objItem->isItemNumberExists($_POST['Sku'],'','')){
			$errors['Sku_ex'] = 'Sku is already exist.';
		}else{
			if($objItem->isItemAliasExists($_POST['Sku'],'')){
				$errors['Sku_ex'] = 'Sku is already exist.';
			}else{
				$Item_Id = $objItem->AddItem($_POST);
					if($Item_Id>0){
							$_GET['ItemID'] = $Item_Id;
							$_GET['Status'] = 1;
							$arryItem = $objItem->GetItemsView($_GET);
								
					} else{
								$errors['Sku_ex'] = "Item add again.";
					}
			}
			
		}
	
	}





// return a response ===========================================================

   
    if ( ! empty($errors)) {

        
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

       
        $data['Sku'] = $arryItem[0]['Sku'];
				$data['ItemID'] = $arryItem[0]['ItemID'];
        $data['description'] = $arryItem[0]['description'];
				$data['Taxable'] = $arryItem[0]['Taxable'];
				$data['success'] = true;
        $data['message'] = 'Success';
    }

    // return all our data to an AJAX call
	if(!empty($arryItem[0])) { echo json_encode($arryItem[0]);exit;}
    //echo json_encode($data);
			break;
			exit;	

}

