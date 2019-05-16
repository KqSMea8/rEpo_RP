<?php 
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	#require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/supplier.class.php");
require_once($Prefix."classes/hrms.class.php"); // added by nisha for sales commission
	//require_once($Prefix."classes/purchasing.class.php"); // conflicting  with hrms class for sales commission
	require_once($Prefix."classes/function.class.php");
	//require_once(_ROOT."/classes/dbfunction.class.php"); 
 	//require_once(_ROOT."/classes/customer.supplier.class.php"); 
	require_once($Prefix."/classes/dbfunction.class.php");
 	require_once($Prefix."/classes/customer.supplier.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
  require_once($Prefix."classes/employee.class.php"); // added by nisha for sales commission
	require_once($Prefix."classes/sales.customer.class.php");//by suneel 7 Dec//
	$objCustomerViewList=new Customer();			//by suneel 7 Dec//


 	$objCustomerSupplier= new CustomerSupplier();
	$objFunction=new functions();
	$objCommon=new common();
	$objTax =new tax();
	$objSupplier=new supplier();
	#$objUser=new user();
	$objBankAccount=new BankAccount();
	$objReport = new report();
	$objPurchase = new purchase();
   $objEmployee=new employee();
	$ModuleName = "Vendor";
	$RedirectURL = "viewSupplier.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "editSupplier.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];



	if(!empty($_GET['del_bank'])){
            $_SESSION['mess_supplier'] = BANK_REMOVED;
            $objSupplier->RemoveBank($_GET['del_bank'],$_GET['edit']);
            header("location:".$ActionUrl);
            exit;
	}

	if(!empty($_GET['del_contact'])){
		$_SESSION['mess_supplier'] = SUPP_CONTACT_REMOVED;
		$objSupplier->RemoveSupplierContact($_GET['del_contact']);
		$RedirectURL = "editSupplier.php?edit=".$_GET['SuppID'].'&tab=contacts';
		header("location:".$RedirectURL);
		exit;
	}



	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_supplier'] = SUPP_REMOVED;
		$objSupplier->RemoveSupplier($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_supplier'] = SUPP_STATUS_CHANGED;
		$objSupplier->changeSupplierStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if (!empty($_POST)) {
			 CleanPost();
			 if($_POST['tab']=="image"){
				$_GET['tab'] = $_POST['tab'];
				$LastInsertId = $_GET['edit']; 
				$_POST['SuppID'] = $LastInsertId;
			 }
			
			 if(empty($_POST['CompanyName']) && empty($_POST['FirstName']) && empty($_POST['SuppID'])) {
				$errMsg = "Please Enter Company Name or First Name.";
			 } else {


				if (!empty($_POST['SuppID'])) {
					$LastInsertId = $_POST['SuppID'];
					/*
					$objSupplier->UpdateSupplier($_POST);
					$_SESSION['mess_supplier'] = SUPP_UPDATED;
					*/
					/***************************/
					
					switch($_GET['tab']){
						case 'general':
							$objSupplier->UpdateGeneral($_POST);
							$_SESSION['mess_supplier'] = GENERAL_UPDATED;
							break;
						case 'contact':
							$objSupplier->UpdateContact($_POST);
							$_SESSION['mess_supplier'] = CONTACT_UPDATED;
							break;
						case 'shipping':
							$AddID = $objSupplier->UpdateShippingBilling($_POST,$_GET['tab']);
							$_SESSION['mess_supplier'] = SHIPPING_UPDATED;
							break;
						case 'billing':
							$AddID = $objSupplier->UpdateShippingBilling($_POST,$_GET['tab']);
							$_SESSION['mess_supplier'] = BILLING_UPDATED;
							break;
						/*case 'currency':
							$objSupplier->UpdateCurrency($_POST);
							$_SESSION['mess_supplier'] = CURRENCY_UPDATED;
							break;*/
						case 'bank':
							$objSupplier->UpdateBankDetail($_POST);	
							$_SESSION['mess_supplier'] = BANK_UPDATED;
							break;
						case 'merge':
							$objSupplier->MergeVendor($_POST['SuppID'],$_POST['SuppIDMerge']);	
							$_SESSION['mess_supplier'] = MERGING_DONE;
							$ActionUrl = "editSupplier.php?edit=".$_POST['SuppIDMerge']."&tab=general";
							break;

			 			case 'linkcustomer':
							$objBankAccount->LinkCustomerVendor($_POST['CustID'],$_POST['SuppID'],'Vendor');	
							$_SESSION['mess_supplier'] = VENDOR_LINK_CUSTOMER;				
							break;



						case 'LoginPermission':							
		                	$customerinfo=array();                	
		                	$customerinfo =$objSupplier->GetSupplier($_POST['SuppID'],'','');                	
		                	$Config['DbName'] = $Config['DbMain'];
							$objConfig->dbName = $Config['DbName'];
							$objConfig->connect();
							$data=array();						
							if(!empty($_POST['AddType']) AND $_POST['AddType']=='LoginPermission'){
								$permission='';									
									if(empty($_POST['ganeratelogin'])){
										if(!empty($_POST['permission']) AND is_array($_POST['permission']))
										$permission=serialize($_POST['permission']);							
										$where=array('id'=>$_POST['company_userid'] ,'ref_id'=>$_POST['SuppID'] ,'comid'=>$_SESSION['CmpID']);
										$data['permission']=$permission;
										$objCustomerSupplier->update('company_user',$data,$where);
										 $_SESSION['mess_supplier'] = 'Permission has been save  successfully';
									}else{													
										$data['ref_id'] = $_POST['SuppID'];
										$data['comid']  = $_SESSION['CmpID'];
										$data['user_name']  = $customerinfo[0]['Email'];
										$data['name']  = $customerinfo[0]['FirstName'].' '.$customerinfo[0]['LastName'];								
										$data['password']  = rand(111111, 999999);;
										$data['user_type']  = 'vendor';
										$objCustomerSupplier->AddUserLoginDetail($data);
										$_SESSION['mess_supplier'] = 'Vendor login details has been generated successfully.';	
									}
							 }
	
                	
              		  break;
					
//added by nisha for sales commission		
					case 'sales':
							
							$objEmployee->UpdateSalesCommission($_POST);	
							$_SESSION['mess_user'] = SALE_COMM_UPDATED;
							break;
					}
					/***************************/
				} else {	 
					if($objSupplier->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_supplier'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objSupplier->AddSupplier($_POST); 

		$_POST['PrimaryContact']=1;
		$AddID = $objSupplier->addSupplierAddress($_POST,$LastInsertId,'contact');

		$_POST['PrimaryContact']=0;
		$billingID = $objSupplier->addSupplierAddress($_POST,$LastInsertId,'billing');	
	 	$shippingID = $objSupplier->addSupplierAddress($_POST,$LastInsertId,'shipping');	


						/****** Add To User Table******/
						/*******************************
						$_POST['UserName'] = trim($_POST['FirstName'].' '.$_POST['LastName']);
						$_POST['UserType'] = "supplier";
						$UserID = $objUser->AddUser($_POST);
						$objSupplier->query("update p_supplier set UserID=".$UserID." where SuppID=".$LastInsertId, 0);
						$_POST['UserID'] = $UserID;
						/*******************************/
						/*******************************/


						$_SESSION['mess_supplier'] = SUPP_ADDED;
						$_GET['tab']="contact";
						#$RedirectURL = "editSupplier.php?edit=".$LastInsertId."&tab=contact";

					}
				}
				
				if($LastInsertId>0)$_POST['SuppID'] = $LastInsertId; 


				/****** Add To User Table******/
				/*******************************
				if($_POST['UserID']>0 && $_GET['tab']=="role"){
					$objSupplier->query("update p_supplier set Role='".$_POST['Role']."' where SuppID=".$_POST['SuppID'], 0);
					$objUser->UpdateRolePermission($_POST);
				}
				/***********************************/

				if($_FILES['Image']['name'] != ''){

					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['VendorDir'];
					$FileInfoArray['FileID'] =  $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objSupplier->UpdateImage($ResponseArray['FileName'],$LastInsertId);	 
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					} 

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_supplier'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_supplier'] .= $ErrorPrefix.$ErrorMsg;
					}

				}

			


				/***********************************/
				if($AddID>0){
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************************/
					$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
					$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);
					if(!empty($_POST['main_state_id'])) {
						$arryState = $objRegion->getStateName($_POST['main_state_id']);
						$arryRgn['State']= stripslashes($arryState[0]["name"]);
					}else if(!empty($_POST['OtherState'])){
						 $arryRgn['State']=$_POST['OtherState'];
					}

					if(!empty($_POST['main_city_id'])) {
						$arryCity = $objRegion->getCityName($_POST['main_city_id']);
						$arryRgn['City']= stripslashes($arryCity[0]["name"]);
					}else if(!empty($_POST['OtherCity'])){
						 $arryRgn['City']=$_POST['OtherCity'];
					}
					/***********************************/
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();

					$objSupplier->UpdateAddCountryStateCity($arryRgn,$AddID);

					if($billingID>0){			
					  $objSupplier->UpdateAddCountryStateCity($arryRgn,$billingID);
					}
					if($shippingID>0){
					  $objSupplier->UpdateAddCountryStateCity($arryRgn,$shippingID);
					}


				}
				/***********************************/	
				




				/***********************************/
				/***********************************
				if($_POST['SuppID']>0 && $_GET['tab']=="contact"){
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************************

					$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
					$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

					if(!empty($_POST['main_state_id'])) {
						$arryState = $objRegion->getStateName($_POST['main_state_id']);
						$arryRgn['State']= stripslashes($arryState[0]["name"]);
					}else if(!empty($_POST['OtherState'])){
						 $arryRgn['State']=$_POST['OtherState'];
					}

					if(!empty($_POST['main_city_id'])) {
						$arryCity = $objRegion->getCityName($_POST['main_city_id']);
						$arryRgn['City']= stripslashes($arryCity[0]["name"]);
					}else if(!empty($_POST['OtherCity'])){
						 $arryRgn['City']=$_POST['OtherCity'];
					}


					/***********************************
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();

					$objSupplier->UpdateCountyStateCity($arryRgn,$_POST['SuppID']);

				}
				/***********************************/
				/***********************************/





	

				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					if(!empty($LastInsertId))				
					$RedirectURL='editSupplier.php?edit='.$LastInsertId.'&curP=1&tab=LoginPermission';
					$_SESSION['mess_supplier'] .= ' Create Login Detail Here';
					header("Location:".$RedirectURL);
					exit;
				}


				
			}
		}
		
	$SupplierStatus = 1;

	if(!empty($_GET['edit'])) {
		$arrySupplier = $objSupplier->GetSupplier($_GET['edit'],'','');
		$SuppID   = $_GET['edit'];	

		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}else{			
			$SuppCode = $arrySupplier[0]['SuppCode'];		 
			$SupplierStatus = $arrySupplier[0]['Status'];

			/********** User Detail **********/	
		  	$Config['DbName'] = $Config['DbMain'];
		 	$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			$arryCurrency = $objRegion->getCurrency('',1);
			$data=array();
		    $userlogindetail=array();             
		    $userlogindetail=$objCustomerSupplier->GetCustomerLogindetail($_SESSION['CmpID'],stripslashes($arrySupplier[0]['Email']),'vendor');
			$Config['DbName'] = $_SESSION['CmpDatabase'];
		 	$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
	
			/********** User Detail **********/	
		}

	}else{

		/*$arryNumEmp = $objSupplier->CountSupplier();
		if($arryNumEmp[0]['TotalSupplier']>=$MaxAllowedUser){
			$errMsg = LIMIT_USER_REACHED.$MaxAllowedUser;
			$HideForm = 1;
		}*/
	}
		
	if($_GET["tab"]=="general" || empty($_GET['edit'])){
		$Config['NormalAccount']=1;
		$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
	}


	/**by suneel 7 desc//updated  by chetan 22Feb2017//**/
	if(!empty($_GET['customer'])) {
		$arryCustomerlistView = $objCustomerViewList->GetCustomerforVenderList($_GET['customer'],'','');
		//$arrySupplier[0]['SuppCode']=$arryCustomerlistView[0]['CustCode'];
		  if($arryCustomerlistView[0]['CustomerType']=="Company"){
			$arrySupplier[0]['SuppType'] = 'Business';
		    }
		  if($arryCustomerlistView[0]['CustomerType']=="Individual"){
			$arrySupplier[0]['SuppType'] = 'Individual';
		}
		$arrySupplier[0]['TenNine']		= "";
		$arrySupplier[0]['SSN']			= "";
		$arrySupplier[0]['EIN']			= "";
		$arrySupplier[0]['CompanyName']		= $arryCustomerlistView[0]['Company'];
		$arrySupplier[0]['Currency'] 		= $arryCustomerlistView[0]['Currency'];
		$arrySupplier[0]['PaymentTerm']		= $arryCustomerlistView[0]['PaymentTerm'];
		$arrySupplier[0]['PaymentMethod']	= $arryCustomerlistView[0]['PaymentMethod'];
		$arrySupplier[0]['CreditLimit'] 	= $arryCustomerlistView[0]['CreditLimit'];
		$arrySupplier[0]['SupplierSince'] 	= date('Y-m-d',strtotime($arryCustomerlistView[0]['CustomerSince']));
		if($arryCustomerlistView[0]['Status']	=='Yes'){
			$arrySupplier[0]['Status'] 	= "1";
			} else {
			$arrySupplier[0]['Status'] 	= "0";
			}
		$arrySupplier[0]['FirstName']		= $arryCustomerlistView[0]['FirstName'];
		$arrySupplier[0]['LastName']		= $arryCustomerlistView[0]['LastName'];
		$arrySupplier[0]['Email']		= $arryCustomerlistView[0]['Email'];
		$arrySupplier[0]['Address']		= $arryCustomerlistView[0]['Address'];
		$arrySupplier[0]['country_id']		= $arryCustomerlistView[0]['country_id'];
		$arrySupplier[0]['OtherState']		= $arryCustomerlistView[0]['OtherState'];
		$arrySupplier[0]['OtherCity']		= $arryCustomerlistView[0]['OtherCity'];
		$arrySupplier[0]['ZipCode']		= $arryCustomerlistView[0]['ZipCode'];
		$arrySupplier[0]['Mobile']		= $arryCustomerlistView[0]['Mobile'];
		$arrySupplier[0]['Landline']		= $arryCustomerlistView[0]['Landline'];
		$arrySupplier[0]['Fax']			= $arryCustomerlistView[0]['Fax'];
		$arrySupplier[0]['state_id']		= $arryCustomerlistView[0]['state_id'];
		$arrySupplier[0]['city_id']		= $arryCustomerlistView[0]['city_id'];
		$arrySupplier[0]['Website']		= $arryCustomerlistView[0]['Website'];

	}
	/*end here*/	

 
	
	
	
		
	
	if($_GET['tab']=='shipping'){
		$SubHeading = 'Edit Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Edit Billing Address';
	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Edit Bank Details'; $HideSubmit=1;
	}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Edit Contacts'; $HideSubmit=1;
	}else if($_GET['tab']=='merge'){
		$SubHeading = 'Merge Vendor';
        }else if($_GET['tab']=='linkcustomer'){
		$SubHeading = 'Link Customer';
	}else if($_GET['tab']=='LoginPermission'){
		$SubHeading = 'Edit Login / Permission Detail';
	}else if($_GET['tab']=='invoice'){
		$SubHeading = 'Invoices'; $HideSubmit=1;
	}else if($_GET['tab']=='payment'){
		$SubHeading = 'Payment History'; $HideSubmit=1;
	}else if($_GET['tab']=='deposit'){
		//$SubHeading = 'Deposits'; 
		$SubHeading = 'Payment History'; $HideSubmit=1;
	}else if($_GET['tab']=='purchase'){
		$SubHeading = 'Purchase History'; $HideSubmit=1;
	}else if($_GET['tab']=='sales'){  //added by nisha For sales commission
		$SubHeading = 'Edit Sales Commission';  $HideSubmit=1; 
	}else{
		$SubHeading = 'Edit '.ucfirst($_GET["tab"])." Information";
	}


	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');

	$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Supplier','');

$arryPurchaseTax = $objTax->GetTaxAll(2,'','');

 


	require_once("../includes/footer.php"); 	 
?>


