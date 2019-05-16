<?php 
	/**************************************************/
	$ThisPageName = 'viewSupplier.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	#require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once(_ROOT."/classes/dbfunction.class.php");
 	require_once(_ROOT."/classes/customer.supplier.class.php"); 
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/purchase.class.php");
require_once($Prefix."classes/inv_tax.class.php");
 	$objCustomerSupplier= new CustomerSupplier();
	$objFunction=new functions();
	$objCommon=new common();
	$objTax =new tax();
	$objSupplier=new supplier();
	#$objUser=new user();
	$objBankAccount=new BankAccount();
	$objReport = new report();
	$objPurchase = new purchase();
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
	

	
	 if ($_POST) {
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
					$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");

					if(empty($FileArray['ErrorMsg'])){
						$ImageExtension = $FileArray['Extension']; 
						$imageName = $LastInsertId.".".$ImageExtension;
                                                $MainDir = "upload/supplier/".$_SESSION['CmpID']."/";						
						if (!is_dir($MainDir)) {
							mkdir($MainDir);
							chmod($MainDir,0777);
						}
						$ImageDestination = $MainDir.$imageName;

if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
	$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
	unlink($_POST['OldImage']);		
}

						
						if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
							$objSupplier->UpdateImage($imageName,$LastInsertId);
							$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
						}
					}else{
						$ErrorMsg = $FileArray['ErrorMsg'];
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
		

	if(!empty($_GET['edit'])) {
		$arrySupplier = $objSupplier->GetSupplier($_GET['edit'],'','');
		$SuppID   = $_GET['edit'];
		$SuppCode = $arrySupplier[0]['SuppCode'];	
		if($_GET["tab"]=="general"){
			$Config['NormalAccount']=1;
			$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
		}


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


	}else{

		/*$arryNumEmp = $objSupplier->CountSupplier();
		if($arryNumEmp[0]['TotalSupplier']>=$MaxAllowedUser){
			$errMsg = LIMIT_USER_REACHED.$MaxAllowedUser;
			$HideForm = 1;
		}*/
	}
				
	if($arrySupplier[0]['Status'] != ''){
		$SupplierStatus = $arrySupplier[0]['Status'];
	}else{
		$SupplierStatus = 1;
	}	

	
	
	
		
	
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
		$SubHeading = 'Deposits'; $HideSubmit=1;
	}else{
		$SubHeading = 'Edit '.ucfirst($_GET["tab"])." Information";
	}


	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');

	$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Supplier','');

$arryPurchaseTax = $objTax->GetTaxAll(2,'','');

if($_GET['DO']==1){

echo "<pre>";
print_r($arryCurrentLocation);
echo "</pre>";
}


	require_once("../includes/footer.php"); 	 
?>


