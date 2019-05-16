<?
		require_once($Prefix."classes/sales.customer.class.php");
		require_once($Prefix."classes/sales.class.php");
		require_once($Prefix."classes/function.class.php"); 
		require_once($Prefix."classes/dbfunction.class.php"); 
		require_once($Prefix."classes/customer.supplier.class.php"); 
		require_once($Prefix."classes/field.class.php"); //By Chetan//
		require_once($Prefix."classes/finance.account.class.php");		
		require_once($Prefix."classes/finance.report.class.php");
		require_once($Prefix."classes/sales.quote.order.class.php");
		require_once($Prefix."classes/webcms.class.php"); //by karishma
		require_once($Prefix."classes/employee.class.php");
		require_once($Prefix."classes/inv_tax.class.php");
	
$objTax = new tax();
	$objEmployee=new employee();

    	$objCustomerSupplier= new CustomerSupplier();  
      	$objFunction=new functions();
        $objCustomer=new Customer();
        $objCommon=new common();          
        $objBankAccount= new BankAccount();
	$objSale = new sale();
	$objReport = new report();
	//By Chetan27Aug//
        $objField = new field();	
        $arryHead=$objField->getHead('','2015',1);
        //End//
        $webcmsObj=new webcms();//by karishma
        
 	$depids=array();
 	if(!empty($arryDepartment)){
 		foreach($arryDepartment as $arryDepartm){
 			$depids[]=$arryDepartm['depID'];
 			
 		}
 	}
		(empty($_GET['id']))?($_GET['id']=""):("");	

        $CustId = isset($_GET['edit'])?$_GET['edit']:"";
	$CustID =  $CustId;	
        $ListUrl = "viewCustomer.php?curP=".$_GET['curP'];
        $ModuleName = "Customer";
        $EditUrl = "editCustomer.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
            $ActionUrl = $EditUrl.$_GET["tab"];
        if(!empty($CustId)){
            $arryBillShipp = $objCustomer->GetShippingBilling($CustId,$_GET['tab']);
            $BillShipp = ucfirst($_GET["tab"]);
        }

	if(empty($arryBillShipp[0]['AddID'])){
		$arryBillShipp = $objConfigure->GetDefaultArrayValue('s_address_book');
	}
        
 
     
        if($_GET['tab']=='shipping'){
           $SubHeading = 'Edit Shipping Address'; $HideSubmit=1; //by karishma
        }else if($_GET['tab']=='billing'){
                $SubHeading = 'Edit Billing Address';
        }else if($_GET['tab']=='bank'){
		$SubHeading = 'Edit Bank Details';	
   	}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Edit Contacts'; $HideSubmit=1;	
        }elseif($_GET['tab']=='slaesPerson'){
		$SubHeading = 'Edit Sales Person'; 	
        }elseif($_GET['tab']=='LoginPermission'){
        	$SubHeading = 'Edit Login / Permission Detail';
	}elseif($_GET['tab']=='markup'){
        	$SubHeading = 'Edit Markup / Discount';
        }else if($_GET['tab']=='merge'){
		$SubHeading = 'Edit Merge Customer';
  	}else if($_GET['tab']=='linkvendor'){
		$SubHeading = 'Edit Link Vendor';
	}else if($_GET['tab']=='so'){
		$SubHeading = 'Sales Orders'; $HideSubmit=1;
		$IncludePage = 'customer_orders.php';
	}else if($_GET['tab']=='deposit'){
		$SubHeading = 'Deposits'; $HideSubmit=1;
		$IncludePage = 'customer_deposit.php';
	}else if($_GET['tab']=='sales'){
		$SubHeading = 'Sales History'; $HideSubmit=1;
		$IncludePage = 'customer_sales_history.php';
	}else if($_GET['tab']=='invoice'){
		$SubHeading = 'Invoices'; $HideSubmit=1;	
		$IncludePage = 'customer_invoice.php';
 	}else if($_GET['tab']=='credit'){
		$SubHeading = 'Credit Memo'; $HideSubmit=1;	
		$IncludePage = 'customer_credit_memo.php';
 	}else if($_GET['tab']=='card'){
		$SubHeading = 'Credit Cards'; $HideSubmit=1;	
		$IncludePage = 'customer_credit_card.php';
  	}else if($_GET['tab']=='ShippingAccount'){
		$SubHeading = 'Shipping Accounts'; $HideSubmit=1;	
		$IncludePage = 'customer_shipping_account.php';   
	}else{
                $SubHeading = 'Edit '.ucfirst($_GET["tab"])." Information";
        }

	

	if(!empty($_GET['del_card'])){
		$_SESSION['mess_cust'] = CARD_REMOVED;
		$objCustomer->RemoveCard($_GET['del_card'],$_GET['CustID']);
		$RedirectURL = "editCustomer.php?edit=".$_GET['CustID'].'&tab=card';
		header("location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['del_account'])){    
		$_SESSION['mess_cust'] = CUST_SHIP_ACCOUNT_REMOVED;
		$objCustomer->DeleteCustShipAccount($_GET['del_account']);
		$RedirectURL = "editCustomer.php?edit=".$_GET['CustID'].'&tab=ShippingAccount&type='.$_GET['type'];
		header("location:".$RedirectURL);
		exit;
		
		
	}


	if(!empty($_GET['del_contact'])){
		$_SESSION['mess_cust'] = ($_GET['tab']=='shipping')?CUST_ADDRESS_REMOVED:CUST_CONTACT_REMOVED;
		$objCustomer->RemoveCustomerContact($_GET['del_contact']);
		/*******************************/
		if($_GET['tab']=='contacts'){
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		
			$objCustomerSupplier->deleteUserNewLoginDetailByRef($_GET['del_contact']);
		
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		}
		/*******************************/
		$RedirectURL = "editCustomer.php?edit=".$_GET['CustID'].'&tab='.$_GET['tab'];
		header("location:".$RedirectURL);
		exit;
	}

	 if(!empty($_GET['del_id'])){
                    $_SESSION['mess_cust'] = CUSTOMER_REMOVED;
                    $objCustomer->RemoveCustomer($_GET['del_id']);
                    header("location:".$ListUrl);
                    exit;
	}
        
         if(!empty($_GET['active_id'])){
		$_SESSION['mess_cust'] = CUSTOMER_STATUS_CHANGED;
		$objCustomer->changeCustomerStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	}
	
		
 	if (is_object($objCustomer)) {
           
            if ($_POST) {


 //$_POST['SalesPersonID'] = implode(",",$_POST['SalesPerson']);
//For array to string conversion by niraj 10feb16
			array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
		      //End array to string conversion by niraj
                CleanPost();
 
						if($_POST['tab']=="image"){
						  $_POST['AddType'] = $_POST['tab'];

						}
                
                if (!empty($CustId)) {
                    
                     switch($_POST['AddType']){
				case 'general':

					/*************************/
					$ValidateData = array(  
						array("name" => "CustomerType", "label" => "Customer Type", "select" => "1"),      
						array("name" => "Email", "label" => "Email" , "type" => "email", "opt" => "1")
							
					);

					$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
					if(!empty($_POST['Email'])){	
						/********Connecting to main database*********/
						$Config['DbName'] = $Config['DbMain'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();
						/*******************************************/					
						$_GET['ref_id'] = $_POST['CustId'];
						$_GET['user_type'] = 'Customer';
						$_GET['CmpID'] = $_SESSION['CmpID'];
						$_GET['Email'] = $_POST['Email'];					
						if($objConfig->isUserEmailDuplicate($_GET)){	
							$ValidateErrorMsg .= '<br>'.EMAIL_ALREADY_REGISTERED;
						}								
					}
					if(!empty($ValidateErrorMsg)){							
						$_SESSION['mess_cust'] = $ValidateErrorMsg;			
						header("Location:".$ActionUrl);
						exit;
					}					
					/********Connecting to main database*********/
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/*******************************************/


                                        $_SESSION['mess_cust'] = GENERAL_UPDATED;
                                        $objCustomer->updateCustomerGeneralInfo($_POST);
                                        
                                        break;
										
												case 'contact':
												$_SESSION['mess_cust'] = CONTACT_UPDATED;
												$objCustomer->updateCustomerContact($_POST);
												/******************ADD COUNTRY/STATE/CITY NAME*****************/
												$Config['DbName'] = $Config['DbMain'];
												$objConfig->dbName = $Config['DbName'];
												$objConfig->connect();
												/***********************************/

												$arryCountry = $objRegion->GetCountryName($_POST['Country']);
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

												$objCustomer->UpdateCountyStateCity($arryRgn,$CustId);

												/**************END COUNTRY NAME*********************/
												break;
								 case 'bank':
									$_SESSION['mess_cust'] = BANK_UPDATED;
									$objCustomer->UpdateBankDetail($_POST);
									break;
                                case 'shipping':
                                        $_SESSION['mess_cust'] = SHIPPING_UPDATED;
                                        $AddID = $objCustomer->UpdateShippingBilling($_POST);
			/******************ADD COUNTRY/STATE/CITY NAME*****************/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************************/

			/*$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
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
			}*/


			/***********************************/
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();

			$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
	
			/**************END COUNTRY NAME*********************/
            break;
                case 'billing':
                                         $_SESSION['mess_cust'] = BILLING_UPDATED;
                                         $AddID = $objCustomer->UpdateShippingBilling($_POST);
										 
				 /******************ADD COUNTRY/STATE/CITY NAME*****************/
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
					$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
			
			       /**************END COUNTRY NAME*********************/
				break;	
			case 'slaesPerson':
				$_SESSION['mess_cust'] ="Sales Person has been updated successfully.";
				//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
				$objCustomer->UpdateSalesPerson($_POST);
				//added by nisha on 6sept2018
				$objCustomer->UpdateSalesPersonCommission($_POST);
				break;

			case 'markup':
				    //print_r($_POST);exit;
			    $_SESSION['mess_cust'] ="Markup/Discount has been updated successfully.";
			    //print_r($_POST);exit;
			    $objCustomer->Updatemarkup($_POST);

			    break;
 
			case 'merge':
				$objCustomer->MergeCustomer($_POST['CustId'],$_POST['CustIDMerge']);	
				$_SESSION['mess_cust'] = MERGING_CUSTOMER_DONE;
				$ActionUrl = "editCustomer.php?edit=".$_POST['CustIDMerge']."&tab=general";
				break;
 			case 'linkvendor':
				$objBankAccount->LinkCustomerVendor($_POST['CustId'],$_POST['SuppID'],'Customer');	
				$_SESSION['mess_cust'] = CUSTOMER_LINK_VENDOR;				
				break;
			case 'LoginPermission':
				$customerinfo=array();  $permissionArray=array();  
				$key = '';  $webmsg='';
				/************************** By Karishma********************/
				$allowedWebsite=$webcmsObj->totalAllowedSites();
				$assigndWebsite=$webcmsObj->totalAssignedSites();
				$assigndWebsiteByCust=$webcmsObj->totalAssignedSitesByCustomer($_POST['CustId']);   
				/********************************************End*************/           	
				$customerinfo=$objCustomer->getCustomerById($_POST['CustId']);  
				/************************** By Karishma********************/
				
				if(!empty($_POST['permission'])){
					$permissionArray = explode(",",$_POST['permission']);
					$key = array_search('website', $permissionArray); 
				}

				if($allowedWebsite >= $assigndWebsite && $allowedWebsite > $assigndWebsiteByCust && false !== $key ){
					$webcmsObj->assignCustomer($_POST);
				}
				elseif($allowedWebsite = $assigndWebsiteByCust && false !== $key){
					//unset($_POST['permission'][$key]);
					$webmsg='You can not assign more than '.$allowedWebsite.' Website';
				}else{
					$webcmsObj->unassignCustomerFromCRM($_POST['CustId']);
				}    
				/********************************************End*************/                	
				$customerinfo=$objCustomer->getCustomerById($_POST['CustId']);                	
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				$data=array();						
				if(!empty($_POST['AddType']) AND $_POST['AddType']=='LoginPermission'){
					$permission='';	

					if(!empty($_POST['ganeratelogin'])){  
						$data['ref_id'] = $_POST['CustId'];
						$data['comid']  = $_SESSION['CmpID'];
						$data['user_name']  = $customerinfo[0]['Email'];
						$data['name']  = $customerinfo[0]['FirstName'].' '.$customerinfo[0]['LastName'];								
						$data['password']  = rand(111111, 999999);;
						$data['user_type']  = 'customer';
						$objCustomerSupplier->AddUserLoginDetail($data);
						$_SESSION['mess_cust'] = 'Customer login details has been generated successfully.';
					}else if(!empty($_POST['permission'])){  
						$permission=serialize($_POST['permission']);							
						$where=array('id'=>$_POST['company_userid'] ,'ref_id'=>$_POST['CustId'] ,'comid'=>$_SESSION['CmpID']);
						$data['permission']=$permission;
						/********* By Karishma for MultiStore 22 Dec 2015******/
						$data['is_exclusive']=$_POST['is_exclusive'];
						/*****End By Karishma for MultiStore 22 Dec 2015**********/
					//echo '<pre>';print_r($where);exit;
						$objCustomerSupplier->update('company_user',$data,$where);
						$_SESSION['mess_cust'] = 'Permission has been saved  successfully.'.$webmsg;
					} 
					
				}


		break;


                
		}

		} 



				/************************************/
				/************************************/
				if(!empty($_FILES['Image']['name'])){
	
					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['CustomerDir'];
					$FileInfoArray['FileID'] =  $CustId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objCustomer->UpdateImage($ResponseArray['FileName'],$CustId);	 
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}


					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_cust'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_cust'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				/************************************/
				/************************************/
 

         
           	header("Location:".$ActionUrl);
	        exit;
            }
            
          
         }

	if(!empty($CustId)){
           $arryCustomer = $objCustomer->getCustomerById($CustId);
	   $CustCode = $arryCustomer[0]['CustCode'];
           $PageHeading = 'Edit Customer for: '.stripslashes($arryCustomer[0]['FullName']);
if($arryCustomer[0]['Taxable']=='Yes'){

$none ='style=""';


if($arryCustomer[0]['c_taxRate']!=''){
$arrRate = explode(":",$arryCustomer[0]['c_taxRate']);
}


}else{

$none ='style="display:none;"';
$arryCustomer[0]['c_taxRate'] ='';

}
//if($_GET['this']==1) echo "<pre>"; print_r($arryCustomer);
        }


//$none ='style = "display:none;"' ;

$arryPurchaseTax = $objTax->GetTaxAll(1,'','');
		
	if(empty($arryCustomer[0]['Cid'])) {
		header('location:'.$ListUrl);
		exit;
	}		

	/*****************/
	if($Config['vAllRecord']!=1){
		if($arryCustomer[0]['AdminID'] == $_SESSION['AdminID'] or $arryCustomer[0]['SalesID'] == $_SESSION['AdminID']){
			//continue
		}else{
			header('location:'.$ListUrl);
			exit;
		}
	}
	/*****************/




	
	/********** User Detail **********/	
  	$Config['DbName'] = $Config['DbMain'];
 	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	$data=array();
    $userlogindetail=array();             
    $userlogindetail=$objCustomerSupplier->GetCustomerLogindetail($_SESSION['CmpID'],stripslashes($arryCustomer[0]['Email']),'customer');
	$Config['DbName'] = $_SESSION['CmpDatabase'];
 	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	
	/********** User Detail **********/	

if(empty($Config['CmpDepartment']) || substr_count($Config['CmpDepartment'],1)==1){
		$_GET["dv"] = '5,6,7';
	}else if(substr_count($Config['CmpDepartment'],5)==1){
		$_GET["dv"] = '5';
	}else{
		$_GET["dv"] = '6';
	}


	//$PageHeading = 'Select Employee';

	unset($arryInDepartment);
	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
	if($_GET["dv"]>0){
		$arryDepartmentRec = $objConfigure->GetDepartmentInfo($_GET["dv"]);
		//$PageHeading .= ' from '.$arryDepartmentRec[0]['Department'];
	}



?>


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function(){

		 $("#UpdateContact").click(function(){
                    var FirstName = $.trim($("#FirstName").val());
                    var LastName = $.trim($("#LastName").val());
                    var Mobile = $.trim($("#Mobile").val());
		    var MobileLength = Mobile.length;
                    var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var gender = $.trim($("#Gender").val());
                    var CustID = $.trim($("#CustId").val());
                    var Address = $.trim($("#Address").val());
                    var main_state_id = $.trim($("#main_state_id").val());
                    var main_city_id = $.trim($("#main_city_id").val());
                    var OtherState = $.trim($("#OtherState").val());
                    var OtherCity = $.trim($("#OtherCity").val());
                    var ZipCode = $.trim($("#ZipCode").val());
               
                    if(FirstName == "")
                    {
                        alert("Please Enter First Name.");
                        $("#FirstName").focus();
                        return false;
                    }

                    if(LastName == "")
                    {
                        alert("Please Enter Last Name.");
                        $("#LastName").focus();
                        return false;
                    }
                    if(gender == "")
                    {
                        alert("Please Select Gender.");
                        $("#Gender").focus();
                        return false;
                    }
                    
                   
                   if(email == "")
                    {
                        alert("Please Enter Email Address.");
                        $("#Email").focus();
                        return false;

                    } 

                    if(!emailRegister.test(email))
                    {
                        alert("Please Enter Valid Email Address.");
                        $("#Email").focus();
                        return false;

                    } 
                    
                     DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	             if(DataExist==1)return false;
                     
                    if(Address == "")
                    {
                        alert("Please Enter Address.");
                        $("#Address").focus();
                        return false;
                    }
                    /*if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State.");
                        $("#OtherState").focus();
                        return false;
                    }*/

                    if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
                    {
                        alert("Please Enter City.");
                        $("#OtherCity").focus();
                        return false;
                    }

                    if(ZipCode == "")
                    {
                        alert("Please Enter Zip Code.");
                        $("#ZipCode").focus();
                        return false;
                    } 
                    
			/*if(Mobile == "")
			{
				alert("Please Enter Mobile Number.");
				$("#Mobile").focus();
				return false;
			}

			if(MobileLength > 10)
			{
				alert("Please Enter 10 Digits Mobile Number Only.");
				$("#Mobile").focus();
				return false;
			}*/

                    ShowHideLoader('1','S');
                });	
		
			
   		


	
                $("#updateBilling").click(function(){
                    var BName = $.trim($("#Name").val());
                    //var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var Address = $.trim($("#Address").val());
                    var main_state_id = $.trim($("#main_state_id").val());
                    var main_city_id = $.trim($("#main_city_id").val());
                    var OtherState = $.trim($("#OtherState").val());
                    var OtherCity = $.trim($("#OtherCity").val());
                    var ZipCode = $.trim($("#ZipCode").val());
                    var Mobile = $.trim($("#Mobile").val());
					var MobileLength = Mobile.length;
                   
                  /* if(BName == "")
                    {
                        alert("Please Enter Name.");
                        $("#Name").focus();
                        return false;
                    }*/
                    /*if(email == "")
                    {
                        alert("Please Enter Email Address.");
                        $("#Email").focus();
                        return false;

                    } 

                    if(!emailRegister.test(email))
                    {
                        alert("Please Enter Valid Email Address.");
                        $("#Email").focus();
                        return false;

                    } */
                    if(Address == "")
                    {
                        alert("Please Enter Address.");
                        $("#Address").focus();
                        return false;
                    }
                    

                  /*  if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State.");
                        $("#OtherState").focus();
                        return false;
                    }*/

                    if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
                    {
                        alert("Please Enter City.");
                        $("#OtherCity").focus();
                        return false;
                    }

                    if(ZipCode == "")
                    {
                        alert("Please Enter Zip Code.");
                        $("#ZipCode").focus();
                        return false;
                    }
//                   if(Mobile == "")
//                    {
//                        alert("Please Enter Mobile Number.");
//                        $("#Mobile").focus();
//                        return false;
//                    }
//					if(MobileLength > 10)
//					{
//						alert("Please Enter 10 Digits Mobile Number Only.");
//						$("#Mobile").focus();
//						return false;
//					}

                    ShowHideLoader('1','S');
			return true;
                });
			

	
		$("#UpdateVendor").click(function(){	
			var SuppID = $("#SuppID").val();
			var CustID = $("#CustId").val();
			$(".message").html("Processing.....");
			if(SuppID!=''){
				var sendParam='&action=VendorLinked&SuppID='+SuppID+'&CustID='+CustID+'&r='+Math.random();  
				
				$.ajax({
					type: "GET",
					async:false,
					url: '../isRecordExists.php',
					data: sendParam,
					success: function (responseText) {  
					   if(responseText==1){
						$(".message").html("This vendor is already linked with other customer.");
						
					   	return false;
					   }else{
						document.forms[0].submit();
						ShowHideLoader('1','S');
						
					   }
					}
				});
				return false;
			}else{			
		  		ShowHideLoader('1','S');
				return true;
			}
                });

		$("#UpdateMerge").click(function(){
			var msg = $("#mergemsg").html() + " Are you sure, you want to continue?";
			
			var CustIDMerge = $("#CustIDMerge").val();

			if(CustIDMerge == "")
			{
				alert("Please Select Customer.");
				$("#CustIDMerge").focus();
				return false;
			} 
			
			if(confirm(msg)){
				ShowHideLoader('1','P');
				return true;
			}else{
				return false;
			}
			return false;

			
		  ShowHideLoader('1','S');
                });


	
		$("#UpdateBank").click(function(){
                   
                    var BankName = $.trim($("#BankName").val());
                    var AccountName = $.trim($("#AccountName").val());
					var AccountNumber = $.trim($("#AccountNumber").val());
                    var IFSCCode = $.trim($("#IFSCCode").val());
               
					   if(BankName == "")
						{
							alert("Please Enter Bank Name.");
							$("#BankName").focus();
							return false;
						}
					   if(AccountName == "")
						{
							alert("Please Enter Account Name.");
							$("#AccountName").focus();
							return false;
						}
						if(AccountNumber == "")
						{
							alert("Please Enter Account Number.");
							$("#AccountNumber").focus();
							return false;
						}
						
						if(AccountNumber.length < 10 || AccountNumber.length >20)
						{
						    alert("Please Enter Valid Account Number.");
							$("#AccountNumber").focus();
						    return false;
						}
					   if(IFSCCode == "")
						{
							alert("Please Enter Routing Number.");
							$("#IFSCCode").focus();
							return false;
						}
                   
                    ShowHideLoader('1','S');
                });
                
                //Code for same billing and shipping

                 $("#sameBilling").click(function(){

                       if($("#sameBilling").prop('checked') == true)
                            {
                                  $("#ShippingName").val($("#CustomerName").val());
                                  $("#ShippingCompany").val($("#CustomerCompany").val());
                                  $("#ShippingAddress").val($("#Address").val());

                                  $("#ShippingCity").val($("#City").val());

                                  $("#ShippingState").val($("#State").val());
                                  $("#ShippingCountry").val($("#Country").val());
                                  $("#ShippingZipCode").val($("#ZipCode").val());

                                  $("#ShippingMobile").val($("#Mobile").val());
                                  $("#ShippingLandline").val($("#Landline").val());
                                  $("#ShippingFax").val($("#Fax").val());
                                  $("#ShippingEmail").val($("#Email").val());

                                }else{
                                  $("#ShippingName").val('');
                                  $("#ShippingCompany").val('');
                                  $("#ShippingAddress").val('');
                                  $("#ShippingCity").val('');

                                  $("#ShippingState").val('');
                                  $("#ShippingCountry").val('');
                                  $("#ShippingZipCode").val('');

                                  $("#ShippingMobile").val('');
                                  $("#ShippingLandline").val('');
                                  $("#ShippingFax").val('');
                                  $("#ShippingEmail").val('');
                                }

                 });


                //end code
				
//By Chetan 5Aug//

 //Company Hide Show 8Dec//
    $("#CustomerType").change(function(){

       var str = $(this).val(); 
       $('#Company').val('');
	$('#FirstName').val('');
       $('#LastName').val('');
       $("#Gender option").removeAttr("selected");
       showHideComp(str);

    });

 $("#Taxable").click(function(){

       var str = $(this).val(); 
       //$('#c_taxRate').val('');
	
//$('.coupon_question').is(":checked")
        if($(this).is(":checked")){
           $('#c_taxRate').closest('td').show().prev().show();
           
       }else{
           $('#c_taxRate').closest('td').hide().prev().hide();
          
       }
    });
    
    showHideComp($.trim($("#CustomerType").val()));
   
    function showHideComp(str)
    {
       if(str == "Company"){
           $('#Company').closest('td').show().prev().show();
           $('#FirstName').closest('td').hide().prev().hide();
           $('#LastName').closest('td').hide().prev().hide();
           $('#Gender').closest('td').hide().prev().hide();
 	$('#FirstName').attr('data-mand','n');
	   $('#LastName').attr('data-mand','n');
           $('#Gender').attr('data-mand','n');
       }else{
           $('#Company').closest('td').hide().prev().hide();
           $('#FirstName').closest('td').show().prev().show();
           $('#LastName').closest('td').show().prev().show();
           $('#Gender').closest('td').show().prev().show();
	$('#FirstName').attr('data-mand','y');
	$('#LastName').attr('data-mand','y');
           $('#Gender').attr('data-mand','y');
       }
    }
//End//
    $('#CustCode').closest('td').text($('#CustCode').val());
    $('#CustCode').remove();
    
    $("#form1 #UpdateGeneral").click(function(){
        var err;
        $('div.red').html('');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
						$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
			if($fldname == "Company" && ($.trim($('#CustomerType').val())=="" ||  $.trim($('#CustomerType').val())=="Individual") && $('#Company').closest('td').css('display')=="none")
			{}else{
                        if($fldname == "tel_ext"){  $input = 'Extension(Ext)'; } //by chetan 3Mar//
                        $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                        err = 1;
                }    
              }
              
             }/*else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            }  */
else{//by niraj for checkbox 11feb16
                if($('input[name^="'+$fldname+'"]').length == 1)
		{ 
			if($('#'+$fldname+':checked').length < 1)
			{
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}
		}else{
			if($('input[name^="'+$fldname+'"]:checked').length < 1)
			{  
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}

		}
              }  
            
            
            if($fldname == "Email" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
               
          });
          
        if(err == 1){ return false; }else{ 
                       
            var email = $.trim($("#Email").val());
            var CustID = $.trim($("#CustId").val());
            DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	    if(DataExist==1)return false;
        
            //return true;
            }
       });
    
        $farr = ['Landline','Mobile'];
          $('input').keypress(function(e){

             if($.inArray($(this).attr('name'),$farr ) != -1)
             {
                 return isNumberKey(e);        
             }
          });


	$dcarry = ['CreditLimit'];
          $('input').keypress(function(e){

             if($.inArray($(this).attr('name'),$dcarry ) != -1)
             {
                 return isDecimalKey(e);        
             }
          });

    
        if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').click(function(){
            
          fldname = $(this).attr('name');
          if(!$(this).is(':checked'))
          { 
                $('<input>').attr({
                        type: 'hidden',
                        id: fldname,
                        name: fldname,
                        value:''
                }).appendTo('#form1');
          }else{
                $('input[name="'+fldname+'"][type="hidden"]').remove();
          }
            
        });
          
      }  
    
//End//			 
				
$("#Department").change(function(){	
//alert("aaaa");
var Dep = $("#Department").val();

var dive = $("#dv").val();;
var selEmpID = $("#SalesPersonSelID").val();

if(dive!=''){

var sendParam='&action=SelectMultiEmp&d='+Dep+'&dv='+dive+'&selEmpID='+selEmpID+'&r='+Math.random(); 
//alert(sendParam);

$.ajax({
					type: "GET",
					async:false,
					url: '../ajax.php',
					data: sendParam,
					success: function (responseText) {  
					  $("#SaleP").html(responseText);
					}
				});
}
	
                });
$("#Department").trigger('change');



var BaseCurrency = '<?=$Config["Currency"]?>';
var CreditLimitCurrency = '<?=$arryCustomer[0]["CreditLimitCurrency"]?>';
 
$("#Currency").change(function(){
	var SelCurrency = $(this).val(); 	
	if(SelCurrency!='' && SelCurrency!=BaseCurrency && document.getElementById("CreditLimit") != null){			 
			jQuery('.creditlimittr').remove();			
			var html='<tr class="creditlimittr"><td align="right" class="blackbold">Credit Limit('+SelCurrency+'): </td><td class="creditlimittd"><input type="text" class="inputbox" name="CreditLimitCurrency" id="CreditLimitCurrency" maxlength="50" onkeypress="return isDecimalKey(event);" value="'+CreditLimitCurrency+'"></td></tr>';				 			
			jQuery(this).parent('td').parent('tr').after(html);
	}else{
		jQuery('.creditlimittr').remove();
	}
});

 $('#Currency').trigger('change');





 });




</script>

<?php //added by nisha
/*********************/
  /*********************/
  $_GET["module"] = $ModuleName;
  $FullName = stripslashes($arryCustomer[0]['CustomerName']);
  $NextID = $objCustomer->NextPrevCustomer($_GET['edit'],$FullName,1);
  $PrevID = $objCustomer->NextPrevCustomer($_GET['edit'],$FullName,2);
  $NextPrevUrl = "editCustomer.php?tab=general&curP=".$_GET["curP"];
  include("../includes/html/box/next_prev_edit.php");
  /*********************/
  /*********************/ 
?>

<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>
    <span>&raquo;
	<?php 	echo (!empty($_GET['edit']))?($SubHeading) :("Add ".$ModuleName); ?>
   </span>
</div>


 <div  align="center"  class="message"  >
          <?php if(!empty($_SESSION['mess_cust'])) {echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); }?>	
        </div>



<?
if(!empty($IncludePage)){
	$Config['vAllRecord']=1;	
	include("../includes/html/box/".$IncludePage);
}else{

?>

<form name="form1" id="form1" action="" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="tab" value="<?=$_GET['tab']?>">
                <input type="hidden" name="AddType" value="<?=$_GET['tab']?>">
                
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                           


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<?php if($_GET['tab'] == "general"){ ?>  
                                                                              
<?php
//By chetan27Aug//

$head=1;
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
for($h=0;$h<sizeof($arryHead);$h++){?>
                
                    <tr>
                        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
                    </tr>

<?php 
$arrayvalues = '';
$arrayvalues = $arryCustomer[0];
$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 

 //By Chetan 1Sep//
if($arryHead[$h]['head_value'] == 'General Information'){

if($arryCurrentLocation[0]['country_id']!='106' && $arryCurrentLocation[0]['country_id']!='234'){
$arryField = array_map(function($arr){
            if($arr['fieldname'] == 'CST' || $arr['fieldname'] == 'PAN' || $arr['fieldname'] == 'TRN')       
            {
                unset($arr);
            }else{
                return $arr;
            }
        },$arryField);	
	
}
$Narry = array_map(function($arr){
                if($arr['fieldname'] == 'Image')
                {
                    unset($arr);
                }else{
                    return $arr;
                }
            },$arryField);
$arryField = array_values(array_filter($Narry)); 
    
}
//End//

include("includes/html/box/CustomFieldsNew.php"); 



if($Config['CurrentDepID']==8){
	 if($arryCustomer[0]['CreditLimit']>0 || $arryCustomer[0]['CreditLimitCurrency']>0){
		echo '<tr id="CreditBalanceTr" style="display:none">
		<td align="right" >Current Credit Balance : </td>
		<td align="left" colspan="3" style="font-weight:bold"><span name="CreditBalance" id="CreditBalance" /></span>	 </td>
	</tr>';

 
	
	echo '<tr>		
		<td  colspan="4" ><div id="custOrderDiv" style="display:none;width:900px;"> ';
	$HideSearch=1;
	include("../includes/html/box/customer_orders.php");

	echo   '</div></td>
		</tr>

		<tr>
		<td align="right" >Open Sales Order Amount : </td>
		<td align="left" colspan="3" > 
<a class="fancyorder fancybox" href="#custOrderDiv">'.number_format($TotalOpenAmount,2).'</a>
<input type="hidden" name="TotalOpenAmount" id="TotalOpenAmount" value="'.$TotalOpenAmount.'" readonly>
</td>
	</tr>';

	


	}
	 
}







 }
//End//
?>                                                                                
                                                                                
		<?php }?>


<? if($_GET['tab'] == "contacts" || $_REQUEST['tab'] == "shipping"){ ?>
<tr>
	<td colspan="4" align="left" class="head"><?if($_GET['tab']=="shipping") echo "Shipping Address";else echo "Contacts";?> </td>
</tr>	
<tr>
	<td colspan="4" align="left">
<? 
$CustID = $_GET['edit'];
include("../includes/html/box/customer_contacts.php");
?>
</td>
</tr>	
<? } ?> 


<? if($_GET["tab"]=="merge"){ 

	 $arryCustomerMerge = $objCustomer->GetCustomerList('');

?>
			
		<tr>
       		 <td colspan="2" align="left" class="head">Merge Customer</td>
        </tr>
		
	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>	
	 <tr>
        <td  align="right"   class="blackbold" width="45%" valign="top"> Select Customer  :</td>
        <td   align="left" >
		
<select name="CustIDMerge" id="CustIDMerge" class="inputbox"  >
	<option value="">--- Select ---</option>
	<?php foreach($arryCustomerMerge as $values){
	if($values['Cid']!=$CustId){
	?>
	<option value="<?=$values['Cid']?>"> <?=stripslashes($values['FullName'])?></option>
	<?php }}?>
</select>

   </td>
      </tr>
 <tr>
		 <td>&nbsp;</td>
       		 <td class=redmsg>Note: <span id="mergemsg" ><?=MERGE_CUSTOMER_MSG?></span></td>
        </tr>

	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
              <? } ?>

<? if($_GET["tab"]=="linkvendor"){
	$arryLinkCustVen = $objBankAccount->GetCustomerVendor($CustId,'');
	$SuppID = (!empty($arryLinkCustVen[0]['SuppID']))?($arryLinkCustVen[0]['SuppID']):("");
	if($SuppID>0){
		$arryVendor = $objBankAccount->GetSupplier($SuppID,'','');
	}

	$clear = '<img src="'.$Config['Url'].'admin/images/clear.gif" border="0"  onMouseover="ddrivetip(\'<center>Clear</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';

	if(empty($arryVendor[0]['SuppCode'])){
		 $arryVendor[0]['SuppCode']='';
		 $arryVendor[0]['VendorName']='';
	}
	
 ?>
 			
	<tr>
       		<td colspan="2" align="left" class="head">Link Vendor</td>
        </tr>
		
	  <tr>
       		 <td colspan="2">&nbsp;</td>
          </tr>	

	
	<tr>
	<td align="right" width="45%" class="blackbold" > Vendor Code : </td>
	<td align="left" >
	<input name="SuppCode" type="text" readonly class="disabled" style="width:90px;" id="SuppCode" value="<?php echo stripslashes($arryVendor[0]['SuppCode']); ?>" maxlength="40" readonly />
<input name="SuppID" type="hidden" readonly class="disabled" id="SuppID" value="<?=$SuppID?>" maxlength="40" readonly />
	<a class="fancybox fancyvendor fancybox.iframe" href="../VendorList.php" ><?=$search?></a>
<a href="Javascript:ClearVendor();" ><?=$clear?></a>  
	</td>
	</tr>


	<tr>
	<td align="right" class="blackbold" > Vendor Name : </td>
	<td align="left" >
	<input name="SuppCompany" type="text" readonly class="disabled"  id="SuppCompany" value="<?php echo stripslashes($arryVendor[0]['VendorName']); ?>" maxlength="50" onkeypress="return isCharKey(event);"/> </td>
	</tr>
	


	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		
<SCRIPT LANGUAGE=JAVASCRIPT>
function ClearVendor(){
	document.getElementById("SuppCode").value='';
	document.getElementById("SuppID").value='';
	document.getElementById("SuppCompany").value='';
}


$(document).ready(function() {  
		$(".fancyvendor").fancybox({
			'width'         : 1000
		 });

});
</SCRIPT>


  <? } ?>


                                          <?php if($_GET['tab'] == "contact"){?>  
                                       
                                            <tr>
                                                <td colspan="4" align="left" class="head">Contact Information </td>
                                            </tr>
										
                                            <tr>
                                                <td width="45%" align="right" valign="top"  class="blackbold"> 
                                                    First Name : <span class="red">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input  name="FirstName" id="FirstName" value="<?= stripslashes($arryCustomer[0]['FirstName']) ?>" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right" valign="top"   class="blackbold"> 
                                                    Last Name :<span class="red">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="LastName" id="LastName" value="<?= stripslashes($arryCustomer[0]['LastName']) ?>" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td align="right" valign="top"   class="blackbold"> 
                                                    Gender :<span class="red">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <select name="Gender" class="inputbox" id="Gender">
                                                        <option value="">---Select---</option>
                                                        <option value="male" <?php if($arryCustomer[0]['Gender'] == "male"){?> selected="selected" <?php }?>>Male</option>
                                                        <option value="female" <?php if($arryCustomer[0]['Gender'] == "female"){?> selected="selected" <?php }?>>Female</option>
                                                    </select>        
                                                </td>
                                            </tr>
                                             <tr>
                                                <td  align="right" valign="top" class="blackbold"> 
                                                    Email : <span class="red">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input name="Email" id="Email"  value="<?= stripslashes($arryCustomer[0]['Email']) ?>" type="text" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Customer','<?=$_GET['edit']?>');" class="inputbox"  maxlength="80" />
                                                     <span id="MsgSpan_Email"></span>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td valign="top" align="right" class="blackbold">Address  :<span class="red">*</span></td>
                                                <td align="left">
                                                  <textarea id="Address" class="textarea" type="text" name="Address" maxlength="250"><?= stripslashes($arryCustomer[0]['Address']) ?></textarea></td>
                                             </tr>
                                              <tr>
                                                <td  align="right"   class="blackbold"> Country : <span class="red">*</span></td>
                                                <td   align="left" >
                                                    <?php
                                                    if ($arryCustomer[0]['Country']>0) {
                                                        $CountrySelected = $arryCustomer[0]['Country'];
                                                    } else {
                                                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
                                                    }
                                                    ?>
                                                    <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <?php for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <?php if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State :  </td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State :  </div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCustomer[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : <span class="red">*</span></div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : <span class="red">*</span></div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCustomer[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
                                            </tr>
                                            <tr>
                                                <td align="right" valign="top" class="blackbold">Zip Code : <span class="red">*</span> </td>
                                                <td align="left" valign="top">
                                                    <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($arryCustomer[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td align="right" valign="top" class="blackbold"> 
                                                    Mobile : </td>
                                                <td  align="left" valign="top">
 <input  name="Mobile" id="Mobile" value="<?= stripslashes($arryCustomer[0]['Mobile']) ?>" type="text" class="inputbox"  maxlength="20" onkeypress="return isNumberKey(event);" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Landline  : </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Landline" id="Landline" value="<?= stripslashes($arryCustomer[0]['Landline']) ?>" type="text"  class="inputbox"  maxlength="20" onkeypress="return isNumberKey(event);" />
                                                    
                                                </td>
                                            </tr>
                                            
                                           
                                             <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Fax :</td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Fax" id="Fax" value="<?= stripslashes($arryCustomer[0]['Fax']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
                                            </tr>
                                           
                                         
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Website :  </td>
                                                <td  align="left" valign="top">
                                                    <input  name="Website" id="Website" value="<?= stripslashes($arryCustomer[0]['Website']) ?>" type="text" class="inputbox"  maxlength="200" />
                                                </td>
                                            </tr>
                                          <?php }?>  
   <?php if($_GET['tab'] == "billing" ){?>    
                                            <tr>
                                                <td colspan="4" align="left" class="head"><?=$BillShipp;?> Information </td>
                                            </tr>

<?php if($_GET['tab'] == "shipping"){
	 $arryBillingAdd = $objCustomer->GetShippingBilling($CustId,'billing');
?>  

<script language="JavaScript1.2" type="text/javascript">
function CopyBillingAddress(){
	var n = $( "#CopyBilling:checked" ).length;
	//ShowHideLoader('1','P');
	if(n==1){
		$("#Name").val('<?=$arryBillingAdd[0]["FullName"]?>');
		//$("#Email").val('<?=$arryBillingAdd[0]["Email"]?>');
		$("#Address").val('<?=$arryBillingAdd[0]["Address"]?>');
		$("#country_id").val('<?=$arryBillingAdd[0]["country_id"]?>');
		$("#OtherState").val('<?=$arryBillingAdd[0]["OtherState"]?>');
		$("#OtherCity").val('<?=$arryBillingAdd[0]["OtherCity"]?>');
		$("#ZipCode").val('<?=$arryBillingAdd[0]["ZipCode"]?>');
		$("#Mobile").val('<?=$arryBillingAdd[0]["Mobile"]?>');
		$("#Landline").val('<?=$arryBillingAdd[0]["Landline"]?>');
		$("#Fax").val('<?=$arryBillingAdd[0]["Fax"]?>');

		$("#main_state_id").val('<?=$arryBillingAdd[0]["state_id"]?>');
		$("#main_city_id").val('<?=$arryBillingAdd[0]["city_id"]?>');
	}else{
		$("#Name").val('<?=$arryBillShipp[0]["FullName"]?>');
		//$("#Email").val('<?=$arryBillShipp[0]["Email"]?>');
		$("#Address").val('<?=$arryBillShipp[0]["Address"]?>');
		$("#country_id").val('<?=$arryBillShipp[0]["country_id"]?>');
		$("#OtherState").val('<?=$arryBillShipp[0]["OtherState"]?>');
		$("#OtherCity").val('<?=$arryBillShipp[0]["OtherCity"]?>');
		$("#ZipCode").val('<?=$arryBillShipp[0]["ZipCode"]?>');
		$("#Mobile").val('<?=$arryBillShipp[0]["Mobile"]?>');
		$("#Landline").val('<?=$arryBillShipp[0]["Landline"]?>');
		$("#Fax").val('<?=$arryBillShipp[0]["Fax"]?>');

		$("#main_state_id").val('<?=$arryBillShipp[0]["state_id"]?>');
		$("#main_city_id").val('<?=$arryBillShipp[0]["city_id"]?>');
	}
	StateListSend();
	
}


</script>
				<tr>
                                                <td align="right" valign="top" class="blackbold"></td>
                                                <td  align="left" valign="top" height="20">
                                <label><input  name="CopyBilling" id="CopyBilling" value="1" type="checkbox" onClick="Javascript:CopyBillingAddress();"  /> Copy Billing Address</label>
                                                </td>
                                            </tr>
				<?php }?>  
                                            <tr style="display:none;">
                                                <td align="right" valign="top" class="blackbold"> <?=$BillShipp?> Name :<span class="red">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?= stripslashes($arryBillShipp[0]['FullName']) ?>" type="text" class="inputbox"  maxlength="60" />
                                                </td>
                                            </tr>
                                          <tr style="display:none;">
                                            <td align="right"   class="blackbold"><?=$BillShipp;?> Email  : <span class="red">*</span></td>
                                            <td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=stripslashes($arryBillShipp[0]['Email'])?>"  maxlength="80" /> </td>
                                           </tr> 
                                            <tr>
                                                <td width="45%" align="right" valign="top" class="blackbold">  Address :<span class="red">*</span> </td>
                                                <td  align="left" valign="top">
												  <textarea id="Address" class="textarea" type="text" name="Address" maxlength="250"><?= stripslashes($arryBillShipp[0]['Address']) ?></textarea>
                                                </td>
                                            </tr>
                                          

                                          <!--  <tr>
                                                <td  align="right"   class="blackbold"> Country : <span class="red">*</span></td>
                                                <td   align="left" >
                                                    <?php
                                                    if ($arryBillShipp[0]['country_id'] >0) {
                                                        $CountrySelected = $arryBillShipp[0]['country_id'];
                                                    } else {
                                                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
                                                    }
                                                    ?>
                                                    <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <?php for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <?php if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State :  </td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State :  </div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryBillShipp[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : <span class="red">*</span></div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : <span class="red">*</span></div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryBillShipp[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
                                            </tr>-->
                                            
                                             <?/***********************************************/?>     
                                           
                                           <tr>
			<td  align="right"   class="blackbold" > Country  : </td>
			<td   align="left" >
		
	<input name="CountryName" type="text"  class="inputbox"  id="CountryName" value="<?php echo stripslashes($arryBillShipp[0]['CountryName']); ?>" onblur="SetCountryInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCountry(this);"/>
	
	<input name="country_id" type="hidden" class="inputbox"   value="<?php echo stripslashes($arryBillShipp[0]['country_id']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="country_id"/>
	
	
	
		</td>
		 </tr>
		 
		 	<?php 
		
		$Billstatedis='';
		$UsedState =0;
		 if(!empty($arryBillShipp[0]['state_id']) && $arryBillShipp[0]['StateName']!=''){
		 
		 $Billstatedis = '';
		 $UsedState =1;
		 }else{
		 
		 $Billstatedis = 'style="display:none;"';
		 }  ?>

	<tr id="state_tr" <?=$Billstatedis?>>
			<td  align="right"   class="blackbold" > State  : </td>
			<td   align="left" >
		
	<input name="StateName" type="text"  class="inputbox"  id="StateName" value="<?php echo stripslashes($arryBillShipp[0]['StateName']); ?>" onblur="SetSateInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteState(this);"/>
	
		<input name="state_id" type="hidden" class="inputbox"   value="<?php echo stripslashes($arryBillShipp[0]['state_id']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="state_id"/>
	
		</td>
		 </tr>
		 	<tr>
			<td  align="right"   class="blackbold" > City  : </td>
			<td   align="left" >
		
	<input name="CityName" type="text"  class="inputbox"  id="CityName" value="<?php echo stripslashes($arryBillShipp[0]['CityName']); ?>" onblur="SetCityInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCity(this);"/>
	
	<input name="city_id" type="hidden" class="inputbox"   value="<?php echo stripslashes($arryBillShipp[0]['city_id']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="city_id"/>
	
	<input name="UsedState" type="hidden"    value="<?php echo $UsedState; ?>"    id="UsedState"/>
	
	 
	
		</td>
		 </tr>
                                           
                                           
      <? /***********************************************/?>  
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            <tr>
                                                <td align="right" valign="top" class="blackbold">ZIP Code : <span class="red">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($arryBillShipp[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
                                            </tr>
                                            <tr>
                                            <td align="right"   class="blackbold" >Mobile  :</td>
                                            <td  align="left"  >
                                             <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryBillShipp[0]['Mobile'])?>"     maxlength="20" onkeypress="return isNumberKey(event);"/>	

                                             </td>
                                          </tr>

                                               <tr>
                                            <td  align="right"   class="blackbold">Landline  :</td>
                                            <td   align="left" >
                                             <input name="Landline" type="text" class="inputbox" id="Landline" value="<?=stripslashes($arryBillShipp[0]['Landline'])?>"  maxlength="20" onkeypress="return isNumberKey(event);"/>	

                                                            </td>
                                          </tr>

                                              <tr>
                                            <td align="right"   class="blackbold">Fax  : </td>
                                            <td  align="left" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arryBillShipp[0]['Fax'])?>"  maxlength="20" /> </td>
                                          </tr> 

                                         
                                        <?php }?>


<? if($_GET["tab"]=="markup"){ ?> 

<script language="JavaScript1.2" type="text/javascript">
window.onload=function()
{
    ShowTypeOption();
    if(document.getElementById("MDType").value=='Discount')
    {
    MakeDisableEnable();
    }
        
}

function ShowTypeOption()
{

    if(document.getElementById("MDType").value=='Discount')
        {
        
        
        document.getElementById('AmountTitle').style.display = 'block'; 
        document.getElementById('ValueType').style.display = 'block';
        if(document.getElementById("DiscountType").value=="Fixed")
        {
            document.getElementById('DisAmountValue').style.display = 'block';
        }
        
        document.getElementById('PercentageTitle').style.display = 'none'; 
        document.getElementById('PercentageValue').style.display = 'none'; 
        
    }
      else if(document.getElementById("MDType").value=='Markup')
        {
        
        document.getElementById('AmountTitle').style.display = 'none'; 
         
         document.getElementById('ValueType').style.display = 'none';
         document.getElementById('PercentageTitle').style.display = 'block'; 
         document.getElementById('PercentageValue').style.display = 'block'; 
             document.getElementById('FixedTitle').style.display = 'none'; 
            document.getElementById('DisPercentageValue').style.display = 'none'; 
            document.getElementById('PercentageTitle1').style.display = 'none'; 
            document.getElementById('DisAmountValue').style.display = 'none';
        
            
        
    }
    else if(document.getElementById("MDType").value=='None')
    {
    
        document.getElementById('AmountTitle').style.display = 'none'; 
        document.getElementById('ValueType').style.display = 'none';
        document.getElementById('PercentageTitle').style.display = 'none'; 
        document.getElementById('PercentageValue').style.display = 'none'; 
        document.getElementById('FixedTitle').style.display = 'none'; 
        document.getElementById('DisPercentageValue').style.display = 'none'; 
        document.getElementById('PercentageTitle1').style.display = 'none'; 
        document.getElementById('DisAmountValue').style.display = 'none';
    
	}
 
    
    
}

function MakeDisableEnable()
{
    //(document.getElementsByName('DiscountType').value);
    var Getvalue = document.getElementsByName('DiscountType');
    //alert(Getvalue);
    var Selected_value;
    for(var i = 0; i <Getvalue.length; i++){
        if(Getvalue[i].checked)
            {
            Selected_value = Getvalue[i].value;
           }
    }
     if(Selected_value=='Fixed')
     {
        
            document.getElementById('FixedTitle').style.display = 'block'; 
            document.getElementById('DisAmountValue').style.display = 'block';
            document.getElementById('DisPercentageValue').style.display = 'none'; 
            document.getElementById('PercentageTitle1').style.display = 'none'; 
            
            
        
    }
    else if(Selected_value=='Percentage')
    {
         document.getElementById('FixedTitle').style.display = 'none'; 
         document.getElementById('DisAmountValue').style.display = 'none';
         document.getElementById('DisPercentageValue').style.display = 'block';
            document.getElementById('PercentageTitle1').style.display = 'block'; 
             
            
            
        
    }
  
   
   
}



  


</SCRIPT>
 



<tr>
         <td colspan="4" align="left" class="head">Markup / Discount</td>
    </tr>
                                                    
         <tr>
                 <td colspan="4">&nbsp;</td>
            </tr>    




<tr>
                                                    <td  align="right"     width="45%">Markup / Discount: </td>
                                                    <td   align="left" ><input type="radio"  checked <?=($arryCustomer[0]['MDiscount']=="Sale")?("checked"):("");?>  name="MDiscount" id="MDiscount" value="Sale"   />Sale Price&nbsp;&nbsp;&nbsp;&nbsp;


	<? if($arryCompany[0]['Department']!='5'){ ?>
          <input type="radio" name="MDiscount" id="MDiscount"    value="Cost" <?=($arryCustomer[0]['MDiscount']=="Cost")?("checked"):("");?>  />
          Cost of good
	<? } ?>
                                                    
    </tr>    
                



                                    
                                                <tr>
                                                    <td  align="right"     width="45%">Select Type: </td>
                                                    <td   align="left" >
<select name="MDType" class="inputbox" id="MDType"     onChange="Javascript:ShowTypeOption();">
	<option <?  if($arryCustomer[0]['MDType']=="None"){echo "selected";}?>>None</option>
	<option <?  if($arryCustomer[0]['MDType']=="Discount"){echo "selected";}?>>Discount</option>
	<option <?  if($arryCustomer[0]['MDType']=="Markup"){echo "selected";}?>>Markup</option>
</select> 
                                                    
                                                    
                                              
        
                                                
                                                        </td>
                                                  </tr>    
            <tr id="perval" >
                <td align="right" class="blackbold" >
                <div id="PercentageTitle" style="display:none;">Markup Percentage :</div>
                <div id="AmountTitle" style="display:none;">Discount Type :</div>
                </td>
                <td  align="left" >
                <div id="PercentageValue" style="display:none;">
                
                
                    <input name="Percentage" type="text" class="textbox" id="Percentage"  size="3" value="<?php  if($arryCustomer[0]['MDType']=="Markup"){ echo stripslashes($arryCustomer[0]['MDAmount']);} else {echo '';} ?>" maxlength="2" onkeypress='return isNumberKey(event)'/> %     </div>    
                
                        <div  id="ValueType" style="display:none;">  <input type="radio" value="Fixed"  checked <?=($arryCustomer[0]['DiscountType']=="Fixed")?("checked"):("");?>  name="DiscountType" id="DiscountType"   onclick="MakeDisableEnable()"/>
          Fixed&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="DiscountType" id="DiscountType"    value="Percentage" <?=($arryCustomer[0]['DiscountType']=="Percentage")?("checked"):("");?>   onclick="MakeDisableEnable()"/>
          Percentage</div>
                        </td>
            </tr>    
                                                 
                                                  <tr>
                                                    <td  align="right"   class="blackbold"><div id="FixedTitle" style="display:none;">Fixed :</div>
                                                              <div id="PercentageTitle1" style="display:none;">Percentage : </div></td>
                                                    <td   align="left" >
                                                    <div id="DisPercentageValue" style="display:none;">
                <input name="PercentageDis" type="text" class="textbox" id="PercentageDis"  size="3" value="<?php if(($arryCustomer[0]['MDType']=="Discount") && ($arryCustomer[0]['DiscountType']=="Percentage")){echo stripslashes($arryCustomer[0]['MDAmount']);}else {echo '';} ?>" maxlength="2" onkeypress='return isNumberKey(event)'/> %    </div>    
                                                    
                                                    <div  id="DisAmountValue" style="display:none;"><input name="MDAmount" type="text" class="textbox"  id="MDAmount"  value="<?php if(($arryCustomer[0]['MDType']=="Discount")&& ($arryCustomer[0]['DiscountType']=="Fixed")){echo stripslashes($arryCustomer[0]['MDAmount']);}else {echo '';} ?>"    maxlength="10" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?></div>
                                                    
                                                    
                                                    
                                                         </td>
         </tr>
     
  <tr>
                 <td colspan="4">&nbsp;</td>
            </tr> 
                                            
 
 <?php }?>



										  <? if($_GET["tab"]=="bank"){ ?>  
												 <tr>
														 <td colspan="4" align="left" class="head">Bank Details</td>
													</tr>
													
												 <tr>
														 <td colspan="4">&nbsp;</td>
													</tr>	
													
												<tr>
													<td  align="right"   class="blackbold"  width="45%"> Bank Name :<span class="red">*</span> </td>
													<td   align="left" >
													 <input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="<?=stripslashes($arryCustomer[0]['BankName'])?>">
														</td>
												  </tr>	
												 <tr>
													<td  align="right"   class="blackbold"> Account Name  :<span class="red">*</span> </td>
													<td   align="left" >
														<input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="<?=stripslashes($arryCustomer[0]['AccountName'])?>">
														 </td>
												  </tr>	  
												  <tr>
													<td  align="right"   class="blackbold"> Account Number  :<span class="red">*</span> </td>
													<td   align="left" >
														<input type="text" name="AccountNumber" maxlength="30" class="inputbox" id="AccountNumber" value="<?=stripslashes($arryCustomer[0]['AccountNumber'])?>">
														 </td>
												  </tr>	
												   <tr>
													<td  align="right"   class="blackbold"> Routing Number :<span class="red">*</span> </td>
													<td   align="left" >
														<input type="text" name="IFSCCode" maxlength="30"  class="inputbox" id="IFSCCode" value="<?=stripslashes($arryCustomer[0]['IFSCCode'])?>">
														 </td>
												  </tr>	
												  
												  <tr>
														 <td colspan="4">&nbsp;</td>
													</tr>
													
											  <? } ?>
											 <!--modified by nisha on 18 sept-->
										<? if($_GET["tab"]=="slaesPerson"){
											   	if(!empty($arryCustomer[0]['SalesID'])){
											   	   	$empSalesPersonName = $objConfig->getSalesPersonName($arryCustomer[0]['SalesID'],0);
											   	   	$SalesPerson = $empSalesPersonName;
											   	}
											   	if(!empty($arryCustomer[0]['VendorSalesPerson'])){
											   	   	$vendorSalesPersonName = $objConfig->getSalesPersonName($arryCustomer[0]['VendorSalesPerson'],1);
											   	   		$SalesPerson = $vendorSalesPersonName;
											   	}

											   	if((!empty($empSalesPersonName)) && (!empty($vendorSalesPersonName))){
											   		$SalesPerson= $empSalesPersonName.",".$vendorSalesPersonName;
											   	}
                                                $arryCustomerSaleCommPer = $objCustomer->GetCustomerCommissionPercent($CustId);

                                                if($_SESSION['AdminType']=='admin'){
                                                     if(!empty($arryCustomer[0]['SalesID'])){
                                                     	$arryCustomer[0]['SalesPerson'] = $objConfig->getSalesPersonName($arryCustomer[0]['SalesID'],0);
                                                     	
                                                     }
                                                     
                                                }
											    ?>  
												<tr>
												<td colspan="2" align="left" class="head"><?=$SubHeading?></td>
												</tr>
												<tr>
												<td  align="right"   class="blackbold">Sales Person : </td>
												<td   align="left" > 
												<input name="SalesPerson" type="text" class="disabled"   id="SalesPerson" value="<?php echo stripslashes($SalesPerson); ?>"   readonly />
													<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arryCustomer[0]['SalesID']); ?>" type="hidden">
				                                <input name="SalesPersonName" id="SalesPersonName" value="<?php echo stripslashes($empSalesPersonName); ?>" type="hidden">
				                                <input name="vendorSalesPersonID" id="vendorSalesPersonID" value="<?php echo stripslashes($arryCustomer[0]['VendorSalesPerson']); ?>" type="hidden">
				                                 <input name="vendorSalesPersonName" id="vendorSalesPersonName" value="<?php echo stripslashes($vendorSalesPersonName); ?>" type="hidden">
												<a class="fancybox fancybox.iframe" href="/erp/admin/sales/SalesPersonList.php?dv=7"  ><?=$search?></a>
												</td>
												</tr>


<input type="hidden" name="d" id="d" value="<?=(isset($_GET['d'])) ? $_GET['d'] : '';?>" readonly><input type="hidden" name="id" value="<?=$_GET['id']?>" readonly><input type="hidden" name="dv" id="dv" value="<?=$_GET['dv']?>" readonly>


												
											  <? } ?>
											  <? 
									


/* menu rename start from here*/

  $arryRM8 = $objConfigure->getRightMenuByDepId(8,$MainModuleID,1);
  $arryRM0 = $objConfigure->getRightMenuByDepId(0,$MainModuleID,1);

function is_in_array($array, $key, $key_value){
      $within_array = 'no';
      foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if( $within_array == 'yes' ){
                break;
            }
        } else {
                if( $v == $key_value && $k == $key ){
                        $within_array = 'yes';
                        break;
                }
        }
      }
      return $within_array;
}


if(is_in_array($arryRM0, 'Link', 'contacts')=='yes'){
    $arr = $objConfigure->getRightMenuByLink('contacts');
     $vcontacts=$arr[0]['Module'];
}else{
     $vcontacts='Contacts';
}

if(is_in_array($arryRM0, 'Link', 'bank')=='yes'){
    $arr1 = $objConfigure->getRightMenuByLink('bank');
     $vbank=$arr1[0]['Module'];
}else{
     $vbank='Bank Details';
}

if(is_in_array($arryRM0, 'Link', 'billing')=='yes'){
    $arr2 = $objConfigure->getRightMenuByLink('billing');
     $vbilling=$arr2[0]['Module'];
}else{
     $vbilling='Billing Address';
}


if(is_in_array($arryRM0, 'Link', 'shipping')=='yes'){
    
    $arr3 = $objConfigure->getRightMenuByLink('shipping');
    $vshipping=$arr3[0]['Module'];
}else{
     $vshipping='Shipping Address';
}


if(is_in_array($arryRM0, 'Link', 'purchase')=='yes'){
    $arr6 = $objConfigure->getRightMenuByLink('contacts');
     $vpurchase=$arr6[0]['Module'];
}else{
     $vpurchase='Purchase History';
}


if(is_in_array($arryRM8, 'Link', 'so')=='yes'){
    $arr4 = $objConfigure->getRightMenuByLink('so');
     $vso=$arr4[0]['Module'];
}else{
     $vso='Sales Orders';
}


if(is_in_array($arryRM8, 'Link', 'invoice')=='yes'){
    $arr5 = $objConfigure->getRightMenuByLink('invoice');
     $vinvoice=$arr5[0]['Module'];
}else{
     $vinvoice='Invoice';
}



/* menu rename end here*/


											  
											  if($_GET["tab"]=="LoginPermission"){

													$permissionmenu=array(	)	;	
														if(in_array(5,$depids)){															
															$permissionmenu['quote']='Quotes';
															$permissionmenu['document']='Documents';
															$permissionmenu['contact']= $vcontacts;
															$permissionmenu['bank']= $vbank;


}		
	if(in_array(6,$depids)){
	$permissionmenu['invoice']= $vinvoice;
	$permissionmenu['purchaseorder']= $vpurchase;
	$permissionmenu['salesorder']= $vso;
	$permissionmenu['shipping']= $vshipping;
	$permissionmenu['billing']= $vbilling;		
$permissionmenu['items']='Items';														
	}
if(in_array(9,$depids) ){
$permissionmenu['website']='Website Management';

}



													if(!empty($userlogindetail)){
													?>  
												 <tr>
														 <td colspan="4" align="left" class="head">Login / Permission Detail</td>
													</tr>
													
												 <tr>
														 <td colspan="4">&nbsp;</td>
													</tr>	
													
												<tr>
													<td  align="right"   class="blackbold"  width="45%"> User Name :<span class="red">*</span> </td>
													<td   align="left" >
													<?php echo $userlogindetail->user_name;?>
														</td>
												  </tr>	
												 <tr>
													<td  align="right"   class="blackbold"> Password  :</td>
													<td   align="left" >
														<a href="../chCustomerVendorPass.php?custId=<?php echo $userlogindetail->ref_id;?>&custloginId=<?php echo $userlogindetail->id;?>" class="fancybox fancybox.iframe punch">Change Password</a>
														 </td>
												  </tr>	  
  <tr>
	<td  align="right"   class="blackbold" valign="top">Permission :<span class="red">*</span> </td>
	<td   align="left" >
	<?php
	$mypermision=$arryMypermision=array();

	if(!empty($userlogindetail->permission))
	$mypermision=unserialize($userlogindetail->permission);
	if(!empty($mypermision)){
		$arryMypermision = explode(",",$mypermision);
	}
	if(!empty($permissionmenu)){			
										
		foreach($permissionmenu as $k=>$permission){
			$chek='';

			if(in_array($k,$arryMypermision))
			$chek='checked="checked"';
			/**********Added by karishma for MultiStore 22 dec 2015**********/

					$exclusivehtml='';
									$onlickaction='';
									if($k=='items'){
										$onlickaction='onclick="showexclusive(this.checked);"';

										$displayExlusive='style="display:none;"';
										if($chek!='') $displayExlusive='';	
										$exclusivehtml='<div id="itemsType" '.$displayExlusive.'>
										<input type="radio" name="is_exclusive" value="Yes" ';
										 if($userlogindetail->is_exclusive=='Yes')
										 $exclusivehtml .='checked="checked"';
										$exclusivehtml .='> Exclusive
										<input type="radio" name="is_exclusive" value="No" ';
										 if($userlogindetail->is_exclusive=='No')
										 $exclusivehtml .='checked="checked"';
										$exclusivehtml .='> All
										</div>';
									}

						/**********End by karishma for MultiStore 22 dec 2015**********/
			echo '<div class="permission-box"><span class="input check"><input type="checkbox" '.$chek.' value="'.$k.'" name="permission[]" '.$onlickaction.'/></span><label>'.$permission.'</label>'.$exclusivehtml.'</div>';
		}	
	}?>
	<input type="hidden" name="company_userid" value="<?php echo $userlogindetail->id?>">
		 </td>
  </tr>
  <tr>
		 <td colspan="4">&nbsp;</td>
	</tr>
		
<? }else{
									  	
	echo _("<div style='font-size:15px'>Customer has no login account.</div> <div><input type='hidden' name='ganeratelogin' value='ganerate'><br> <input type='hidden' name='CustId' id='CustId' value='".$CustId."' /><input type='checkbox' name='sendEmail' value='1'> Send Email Notification<br><input type='submit' name='ganerate' value='Generate' class='button'></div>");
	$HideSubmit=1;
 }
} ?>

</table>

</td>
</tr>


		 <? if($HideSubmit!=1){ ?>
                    <tr>
                        <td align="center" height="40" valign="top"><br>
                           <?php if(!empty($_GET['edit']) && $_GET['tab'] == "billing"){
                                    $CustomerID = "updateBilling"; 
                                }elseif(!empty($_GET['edit']) && $_GET['tab'] == "shipping"){
                                    $CustomerID = "updateBilling"; 
                                }elseif(!empty($_GET['edit']) && $_GET['tab'] == "general"){
                                    $CustomerID = "UpdateGeneral"; 
				 }elseif(!empty($_GET['edit']) && $_GET['tab'] == "merge"){
                                    $CustomerID = "UpdateMerge"; 
				 }elseif(!empty($_GET['edit']) && $_GET['tab'] == "linkvendor"){
                                    $CustomerID = "UpdateVendor"; 
                                }elseif(!empty($_GET['edit']) && $_GET['tab'] == "bank"){
                                    $CustomerID = "UpdateBank"; 
				 }elseif(!empty($_GET['edit']) && $_GET['tab'] == "markup"){
                                    $CustomerID = "Markup"; 
                                }elseif(!empty($_GET['edit']) && $_GET['tab'] == "slaesPerson"){
                                    $CustomerID = "slaesPerson"; 
								
								}elseif(!empty($_GET['edit']) && $_GET['tab'] == "LoginPermission"){
                                    $CustomerID = "Updatepermission"; 
                                }else{
                                    $CustomerID = "UpdateContact"; 
                                }
                                
?>
                            <input type="hidden" name="CustId" id="CustId" value="<?= $CustId; ?>" readonly />
                            <?php if($_GET['tab'] == "billing" || $_GET['tab'] == "shipping"){ ?>
                            <input type="hidden" value="<?php echo $arryBillShipp[0]['state_id']; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryBillShipp[0]['city_id']; ?>" />
                             <?php }?>
                            <?php if($_GET['tab'] == "contact"){ ?>
                            <input type="hidden" value="<?php echo $arryCustomer[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustomer[0]['City']; ?>" />
                            <?php }?>
                            
                            <input name="Submit" type="submit" class="button" id="<?=$CustomerID?>" value="Update" />&nbsp;
                           
                        </td>    
                    </tr>

		<? } ?>


                </table>
               </form>
  <? } //end include ?> 

<? 
if($_GET["tab"]=="general" && $Config['CurrentDepID']==8){
	include("../includes/html/box/customer_aging.php");
}

//added by nisha on 6sept18
if(($_GET["tab"]=="slaesPerson") && (!empty($arryCustomerSaleCommPer))){
	include("../includes/html/box/customer_sale_commission.php");
}
?>


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});
/**********Added by karishma for MultiStore 22 dec 2015**********/
function showexclusive(isChecked){
	if(isChecked){
		$('#itemsType').show();
	}else{
		$('#itemsType').hide();
	}
}

/**********End by karishma for MultiStore 22 dec 2015**********/


	 
function AutoCompleteCountry(elm){		
jQuery('#city_id').val('');
					 jQuery('#CityName').val('');
					 jQuery('#main_city_id').val('');
					 
					 
					 jQuery('#state_id').val('');
					 jQuery('#StateName').val('');
					 jQuery('#main_state_id').val('');

	$(elm).autocomplete({
		source: "../jsonCountry.php",
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#country_id').val(ui.item.id);
					 jQuery('#CountryName').val(ui.item.label);
					 //alert(ui.item.used_state);
					 jQuery('#city_id').val('');
					 jQuery('#CityName').val('');
					 jQuery('#main_city_id').val('');
					 jQuery('#state_id').val('');
					 jQuery('#StateName').val('');
					 jQuery('#main_state_id').val('');
					 jQuery('#UsedState').val(ui.item.used_state);
					 if(ui.item.used_state=='1'){
					 document.getElementById("state_tr").style.display = ''; 
					
					 }else{
					 document.getElementById("state_tr").style.display = 'none';
					 
					 }
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
function AutoCompleteCity(elm){		
var state_id = jQuery('#state_id').val();
var country_id = jQuery('#country_id').val();
var stateName = jQuery('#StateName').val();
var countryname = jQuery('#CountryName').val();
var UsedState = jQuery('#UsedState').val();

     	jQuery('#city_id').val('');
					 jQuery('#CityName').val('');
					 jQuery('#main_city_id').val('');
//alert(stateName);
if(UsedState==1){
if(stateName=='' || state_id=='' ){

alert("Please select state first.");
//jQuery('#StateName').focus();
return false;
}
} if(countryname=='' || country_id==''){

alert("Please select country first.");
//jQuery('#StateName').focus();
return false;
}
	$(elm).autocomplete({
		source: "../jsonCity.php?state_id="+state_id+"&country_id="+country_id,
		minLength: 1,select: function( event, ui ) {
		 jQuery('#city_id').val('');
					 jQuery('#CityName').val('');
					 jQuery('#main_city_id').val('');
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#city_id').val(ui.item.id);
					 jQuery('#CityName').val(ui.item.label);
					 jQuery('#main_city_id').val(ui.item.id);
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});
	

}
function AutoCompleteState(elm){		
var country_id = jQuery('#country_id').val();
var countryname = jQuery('#CountryName').val();
       
       jQuery('#state_id').val('');
					 jQuery('#StateName').val('');
					 jQuery('#main_state_id').val('');
if(country_id=='' && countryname==''){
alert("Please select country first.");
//jQuery('#StateName').focus();
return false;
}
	$(elm).autocomplete({
		source: "../jsonState.php?country_id="+country_id,
		minLength: 1,select: function( event, ui ) {
		
	
		jQuery('#city_id').val('');
					 jQuery('#CityName').val('');
		console.log(ui.item.error);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#state_id').val(ui.item.id);
					 jQuery('#StateName').val(ui.item.label);
					 jQuery('#main_state_id').val(ui.item.id);
					 
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
function SetSateInfo(inf){
//alert(inf);
var st_id = jQuery('#state_id').val();

if(st_id == ''){
	jQuery('#state_id').val('');
					 jQuery('#StateName').val('');
					 jQuery('#main_state_id').val('');
		return false;
	}


}

function SetCityInfo(inf){

var st_id = jQuery('#city_id').val();
//alert(inf);

if(st_id == ''){
	     jQuery('#city_id').val('');
					 jQuery('#CityName').val('');
					 jQuery('#main_city_id').val('');
		return false;
	}


}

</script>


