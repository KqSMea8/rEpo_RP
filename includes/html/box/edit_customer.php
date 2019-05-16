<?
 	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/sales.class.php");
    	require_once($Prefix."classes/function.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php"); 
        require_once($Prefix."classes/customer.supplier.class.php"); 
        require_once($Prefix."classes/field.class.php"); //By Chetan//
        
        
        
    	$objCustomerSupplier= new CustomerSupplier();  
      	$objFunction=new functions();
        $objCustomer=new Customer();
        $objCommon=new common();          
        $objField = new field();	//By Chetan//
        
         //By Chetan//
        $ArrCustomFields = $objField->getAllCustomFieldByModule('Customer');
        $ArrField = array_map(function($a) {
                                                  return $a['fieldid'];
                                                }, $ArrCustomFields);
        $ArrFieldName = array_map(function($a) {
                                                  return $a['fieldname'];
                                                }, $ArrCustomFields);

        $StrField = join(',',  $ArrField);
        $StrFieldName = join(',',  $ArrFieldName);
        
        $arryHead=$objField->getHead('',$ModuleParentID,1);
        
        //End//
        
        
        
        
 	$depids=array();
 	if(!empty($arryDepartment)){
 		foreach($arryDepartment as $arryDepartm){
 			$depids[]=$arryDepartm['depID'];
 			
 		}
 	}


        $CustId = isset($_GET['edit'])?$_GET['edit']:"";	
        $ListUrl = "viewCustomer.php?curP=".$_GET['curP'];
        $ModuleName = "Customer";
        $EditUrl = "editCustomer.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
            $ActionUrl = $EditUrl.$_GET["tab"];
        if(!empty($CustId)){
            $arryBillShipp = $objCustomer->GetShippingBilling($CustId,$_GET['tab']);
            $BillShipp = ucfirst($_GET["tab"]);
        }
        

     
        if($_GET['tab']=='shipping'){
           $SubHeading = 'Shipping Address';
        }else if($_GET['tab']=='billing'){
                $SubHeading = 'Billing Address';
        }else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';	
   		}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Contacts'; $HideSubmit=1;	
        }elseif($_GET['tab']=='slaesPerson'){
		$SubHeading = 'Sales Person'; 	
        }elseif($_GET['tab']=='LoginPermission'){
        	$SubHeading = 'Login / Permission Detail';
	}elseif($_GET['tab']=='markup'){
        	$SubHeading = 'Markup / Discount';
        }else{
                $SubHeading = ucfirst($_GET["tab"])." Information";
        }

	

	if(!empty($_GET['del_contact'])){
		$_SESSION['mess_cust'] = CUST_CONTACT_REMOVED;
		$objCustomer->RemoveCustomerContact($_GET['del_contact']);
		$RedirectURL = "editCustomer.php?edit=".$_GET['CustID'].'&tab=contacts';
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
                                        
                                          //By Chetan//
                                        $fieldIDs = explode(',',$_POST['fieldIds']);
                                        $fieldNames = explode(',',$_POST['fields']);

                                        $objField->updateModuleForm($_POST,$CustId,$fieldIDs,$fieldNames);
                                        //End//
                                        
                                        
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
									$_SESSION['mess_cust'] = UPDATEDBANKDETAILS;
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
				$objCustomer->UpdateSalesPerson($_POST);
				break;

			case 'markup':
				    //print_r($_POST);exit;
			    $_SESSION['mess_cust'] ="Markup/Discount has been updated successfully.";
			    //print_r($_POST);exit;
			    $objCustomer->Updatemarkup($_POST);

			    break;
 



                case 'LoginPermission':
                	$customerinfo=array();                	
                	$customerinfo=$objCustomer->getCustomerById($_POST['CustId']);                	
                	$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					$data=array();						
					if(!empty($_POST['AddType']) AND $_POST['AddType']=='LoginPermission'){
						$permission='';		
						if(empty($_POST['ganeratelogin'])){
							if(!empty($_POST['permission']) AND is_array($_POST['permission']))
								$permission=serialize($_POST['permission']);							
								$where=array('id'=>$_POST['company_userid'] ,'ref_id'=>$_POST['CustId'] ,'comid'=>$_SESSION['CmpID']);
								$data['permission']=$permission;
								$objCustomerSupplier->update('company_user',$data,$where);
								 $_SESSION['mess_cust'] = 'Permission has been save  successfully';
							}else{
													
								$data['ref_id'] = $_POST['CustId'];
								$data['comid']  = $_SESSION['CmpID'];
								$data['user_name']  = $customerinfo[0]['Email'];
								$data['name']  = $customerinfo[0]['FirstName'].' '.$customerinfo[0]['LastName'];								
								$data['password']  = rand(111111, 999999);;
								$data['user_type']  = 'customer';
								$objCustomerSupplier->AddUserLoginDetail($data);
								$_SESSION['mess_cust'] = 'Customer Login detail Ganerate Successfully';
								
							}
						 }
	
                	
                break;
}
                        
                       } 
                       


				/************************************/
				/************************************/
				if($_FILES['Image']['name'] != ''){
					$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");

					if(empty($FileArray['ErrorMsg'])){
						$ImageExtension = $FileArray['Extension']; 
						$imageName = $CustId.".".$ImageExtension;
						$MainDir = "../upload/customer/".$_SESSION['CmpID']."/";					
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
							$objCustomer->UpdateImage($imageName,$CustId);
							$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
						}
					}else{
						$ErrorMsg = $FileArray['ErrorMsg'];
					}

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_cust'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_cust'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				/************************************/
				/************************************/



                        /*if($_FILES['Image']['name'] != ''){
                            $ImageExtension = GetExtension($_FILES['Image']['name']); 
                            
                            $imageName = $CustId.".".$ImageExtension;	
                            $MainDir = "../upload/customer/".$_SESSION['CmpID']."/";						
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}
				$ImageDestination = $MainDir.$imageName;						
                            if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
                                    $objCustomer->UpdateImage($imageName,$CustId);
                            }
		         } */






         
                   header("Location:".$ActionUrl);
	       exit;
            }
            
          
         }

	if(!empty($CustId)){
           $arryCustomer = $objCustomer->getCustomerById($CustId);
           $PageHeading = 'Edit Customer for: '.stripslashes($arryCustomer[0]['FullName']);
        }


		
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

	$arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');
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
                    if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State.");
                        $("#OtherState").focus();
                        return false;
                    }

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
				
				
		 $("#UpdateGeneral").click(function(){
                   	 var CustID = $.trim($("#CustId").val());
			var FirstName = $.trim($("#FirstName").val());
			var LastName = $.trim($("#LastName").val());
			var Mobile = $.trim($("#Mobile").val());
			var MobileLength = Mobile.length;
			var email = $.trim($("#Email").val());
			var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			var gender = $.trim($("#Gender").val());

			var CustomerType = $.trim($("#CustomerType").val());
			var Company = $.trim($("#Company").val());
               
			if(CustomerType == "")
			{
				alert("Please Select Customer Type.");
				$("#CustomerType").focus();
				return false;
			}
			if(Company == "" && CustomerType == "Company")
			{
				alert("Please Enter Company.");
				$("#Company").focus();
				return false;
			}
                   
			if(FirstName == "" && CustomerType == "Individual")
			{
				alert("Please Enter First Name.");
				$("#FirstName").focus();
				return false;
			}

			if(LastName == "" && CustomerType == "Individual")
			{
				alert("Please Enter Last Name.");
				$("#LastName").focus();
				return false;
			}
			


			if(email != "")		{
			
			if(!emailRegister.test(email))
			{
				alert("Please Enter Valid Email Address.");
				$("#Email").focus();
				return false;
			} 
                    
                     DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	             if(DataExist==1)return false;

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
                    var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var Address = $.trim($("#Address").val());
                    var main_state_id = $.trim($("#main_state_id").val());
                    var main_city_id = $.trim($("#main_city_id").val());
                    var OtherState = $.trim($("#OtherState").val());
                    var OtherCity = $.trim($("#OtherCity").val());
                    var ZipCode = $.trim($("#ZipCode").val());
                    var Mobile = $.trim($("#Mobile").val());
					var MobileLength = Mobile.length;
                   
                   if(BName == "")
                    {
                        alert("Please Enter Name.");
                        $("#Name").focus();
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
                    if(Address == "")
                    {
                        alert("Please Enter Address.");
                        $("#Address").focus();
                        return false;
                    }
                    

                    if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State.");
                        $("#OtherState").focus();
                        return false;
                    }

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
                  /*  if(Mobile == "")
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
                
              //Company Hide Show
 $("#CustomerType").change(function(){
    
    var str = $(this).val();
    if(str == "Company"){
        $("#showCompany").show();
		$("#Company").show();
		$("#fred").hide();  $("#lred").hide();
		$("#custnametr").show();
	 } else if(str == "Individual"){
		 $("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").show();
    }else{
        $("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").hide();
    }
     
 });
 
var custType = $("#CustomerType").val();
	if(custType == "Company"){
		$("#showCompany").show();
		$("#Company").show();
		$("#fred").hide();  $("#lred").hide();
		$("#custnametr").show();
	}else if(custType == "Individual"){
		 $("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").show();
    }else{
		$("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").hide();
	
    }
//End
                
				
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
				
				
				 
				



 });




</script>



<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>
    <span>&raquo;
	<?php 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
   </span>
</div>


 <div  align="center"  class="message"  >
          <?php if(!empty($_SESSION['mess_cust'])) {echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); }?>	
        </div>


              <form name="form1" action="" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="tab" value="<?=$_GET['tab']?>">
                <input type="hidden" name="AddType" value="<?=$_GET['tab']?>">
                
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                           
                                        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
										<?php if($_GET['tab'] == "general"){?>  
										<tr>
										 <td colspan="4" align="left" class="head"><?=$arryHead[0]['head_value']?></td>
										</tr>

										 <tr>
                                                <td  align="right" valign="top"  class="blackbold"> 
                                                    Customer Code : </td>
                                                <td align="left" valign="top" colspan="3">
                                                   <?= stripslashes($arryCustomer[0]['CustCode']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td width="25%" align="right" class="blackbold"> Customer Type  :<span class="red">*</span> </td>
                                            <td width="25%" align="left">
                                                     <select id="CustomerType" class="inputbox" name="CustomerType">
                                                        <option value="">--- Select ---</option>
                                                        <option value="Individual" <?php if($arryCustomer[0]['CustomerType'] == "Individual"){?> selected="selected" <?php }?>>Individual</option>
                                                        <option value="Company" <?php if($arryCustomer[0]['CustomerType'] == "Company"){?> selected="selected" <?php }?>>Company</option>
                                                     </select>
                                               </td>
                                         
                                                <td width="25%" align="right" valign="top"   class="blackbold"> 
                                                   <div style="display: none;" id="showCompany">Company : <span class="red">*</span></div> </td>
                                                <td  align="left" valign="top">
                                                    <input  name="Company" id="Company" value="<?= stripslashes($arryCustomer[0]['Company']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>



<tr id="custnametr" style="display:none">
                                                <td  align="right" valign="top"  class="blackbold"> 
                                                    First Name : <span class="red" id="fred">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input  name="FirstName" id="FirstName" value="<?= stripslashes($arryCustomer[0]['FirstName']) ?>" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                           
                                                <td align="right" valign="top"   class="blackbold"> 
                                                    Last Name :<span class="red" id="lred">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="LastName" id="LastName" value="<?= stripslashes($arryCustomer[0]['LastName']) ?>" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td align="right" valign="top"   class="blackbold"> 
                                                    Gender : </td>
                                                <td  align="left" valign="top"  class="blacknormal">
                                                    <select name="Gender" class="inputbox" id="Gender">
                                                        <option value="">---Select---</option>
                                                        <option value="Male" <?php if($arryCustomer[0]['Gender'] == "Male"){?> selected="selected" <?php }?>>Male</option>
                                                        <option value="Female" <?php if($arryCustomer[0]['Gender'] == "Female"){?> selected="selected" <?php }?>>Female</option>
                                                    </select>        
                                                </td>
                                           
                                                <td  align="right" valign="top" class="blackbold"> 
                                                    Email :  </td>
                                                <td  align="left" valign="top">
                                                    <input name="Email" id="Email"  value="<?= stripslashes($arryCustomer[0]['Email']) ?>" type="text" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Customer','<?=$_GET['edit']?>');" class="inputbox"  maxlength="80" />
                                                    <br> <span id="MsgSpan_Email"></span>
                                                </td>
                                            </tr>


<tr>
                                                <td align="right" valign="top" class="blackbold"> 
                                                    Mobile :  </td>
                                                <td  align="left" valign="top">
 <input  name="Mobile" id="Mobile" value="<?= stripslashes($arryCustomer[0]['Mobile']) ?>" type="text" class="inputbox"  maxlength="20"  onkeypress="return isNumberKey(event);"/>
                                                </td>
                                            
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Landline  : </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Landline" id="Landline" value="<?= stripslashes($arryCustomer[0]['Landline']) ?>" type="text"  class="inputbox"  maxlength="20"  onkeypress="return isNumberKey(event);"/>
                                                    
                                                </td>
                                            </tr>
                                            
                                          
                                           
                                         


 <tr style="display:none">
													<td  align="right"   class="blackbold"> Currency  :</td>
													<td   align="left" >
													<?
													$Config['DbName'] = $Config['DbMain'];
													$objConfig->dbName = $Config['DbName'];
													$objConfig->connect();
													$arryCurrency = $objRegion->getCurrency('',1);

													if(!empty($arryCustomer[0]['Currency'])){
														$CurrencySelected = $arryCustomer[0]['Currency']; 
													}else{
														$CurrencySelected = 'USD';
													}
													?>
														<select name="Currency" class="inputbox" id="Currency">
														  <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
														  <option value="<?=$arryCurrency[$i]['code']?>" <?  if($arryCurrency[$i]['code']==$CurrencySelected){echo "selected";}?>>
														  <?=$arryCurrency[$i]['name']?>
														  </option>
														  <? } ?>
														</select>       
													</td>
</tr>



                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Website :  </td>
                                                <td  align="left" valign="top">
                                                    <input  name="Website" id="Website" value="<?= stripslashes($arryCustomer[0]['Website']) ?>" type="text" class="inputbox"  maxlength="200" />
                                                </td>
                                           

											<? 	
											$CustomerSince = ($arryCustomer[0]['CustomerSince']>0)?($arryCustomer[0]['CustomerSince']):(""); 
											?>
											
												<td  align="right"   class="blackbold" >Customer Since :</td>
												<td   align="left" >

											<script type="text/javascript">
											$(function() {
											$('#CustomerSince').datepicker(
												{
												showOn: "both",
												yearRange: '<?=date("Y")-50?>:<?=date("Y")?>', 
												maxDate: "-1D", 
												dateFormat: 'yy-mm-dd',
												changeMonth: true,
												changeYear: true

												}
											);
											});
											</script>

											
											<input id="CustomerSince" name="CustomerSince" readonly="" class="datebox" value="<?=$CustomerSince?>"  type="text" > 


											</td>
										</tr>


									
									<tr>
											<td  align="right" class="blackbold">Payment Term  :</td>
											<td   align="left">
											  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
												<option value="">--- None ---</option>
													<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
															$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
													?>
														<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryCustomer[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
													<? } ?>
											</select> 
											</td>
									
											<td  align="right" class="blackbold">Payment Method  :</td>
											<td   align="left">
											  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
												<option value="">--- None ---</option>
													<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
														<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryCustomer[0]['PaymentMethod']){echo "selected";}?>>
														<?=$arryPaymentMethod[$i]['attribute_value']?>
												</option>
													<? } ?>
											</select> 
											</td>
									</tr>

									<tr>
											<td  align="right" class="blackbold">Shipping Method  :</td>
											<td   align="left">
											  <select name="ShippingMethod" class="inputbox" id="ShippingMethod">
												<option value="">--- None ---</option>
													<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
														<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryCustomer[0]['ShippingMethod']){echo "selected";}?>>
														<?=$arryShippingMethod[$i]['attribute_value']?>
												</option>
													<? } ?>
											</select> 
											</td>
									


		<td  align="right" class="blackbold">Taxable  :</td>
		<td   align="left">

<input type="checkbox" name="Taxable" id="Taxable" value="Yes" <?  if($arryCustomer[0]['Taxable']=='Yes'){echo "checked";}?>>
	
		</td>
</tr>




								    	<tr>
											<td  align="right"   class="blackbold">Status  : </td>
											<td   align="left"  >
											 <? 
												 $ActiveChecked = ' checked';
												 if($_GET['edit'] > 0){
													 if($arryCustomer[0]['Status'] == "Yes") {$ActiveChecked = ' checked'; $InActiveChecked ='';}
													 if($arryCustomer[0]['Status'] == "No") {$ActiveChecked = ''; $InActiveChecked = ' checked';}
												}
											  ?>
											  <input type="radio" name="Status" id="Status" value="Yes" <?=$ActiveChecked?> />
											  Active&nbsp;&nbsp;&nbsp;&nbsp;
											  <input type="radio" name="Status" id="Status" value="No" <?=$InActiveChecked?> />
											  InActive </td>
										</tr>
<?php
//By chetan//
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/******************** Code ****************************/
$arryField = $objField->getFormField('',$arryHead[0]['head_id'],'1'); 

include("includes/html/box/customfields.php");

//////////End ////////////////////////////
     
/******************** Code ****************************/

 for($head=1;$head<sizeof($arryHead);$head++){?>
                
                    <tr>
                        <td colspan="4" align="left" class="head"><?=$arryHead[$head]['head_value']?></td>
                    </tr>

<?php $arryField = $objField->getFormField('',$arryHead[$head]['head_id'],'1'); 


include("includes/html/box/customfields.php"); 

 }
//head close?>                                                                                 
                                                                                
                                                                                
										<?php }?>


<? if($_GET['tab'] == "contacts"){ ?>
<tr>
	<td colspan="4" align="left" class="head">Contacts </td>
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
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : <span class="red">*</span></td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State : <span class="red">*</span></div> </td>
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
                                        <?php if($_GET['tab'] == "billing" || $_GET['tab'] == "shipping"){?>    
                                            <tr>
                                                <td colspan="4" align="left" class="head"><?=$BillShipp;?> Information </td>
                                            </tr>
                                            <tr>
                                                <td align="right" valign="top" class="blackbold"> <?=$BillShipp?> Name :<span class="red">*</span> </td>
                                                <td  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?= stripslashes($arryBillShipp[0]['FullName']) ?>" type="text" class="inputbox"  maxlength="60" />
                                                </td>
                                            </tr>
                                           <tr>
                                            <td align="right"   class="blackbold"><?=$BillShipp;?> Email  : <span class="red">*</span></td>
                                            <td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=stripslashes($arryBillShipp[0]['Email'])?>"  maxlength="80" /> </td>
                                           </tr> 
                                            <tr>
                                                <td width="45%" align="right" valign="top" class="blackbold">  Address :<span class="red">*</span> </td>
                                                <td  align="left" valign="top">
												  <textarea id="Address" class="textarea" type="text" name="Address" maxlength="250"><?= stripslashes($arryBillShipp[0]['Address']) ?></textarea>
                                                </td>
                                            </tr>
                                          

                                            <tr>
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
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : <span class="red">*</span></td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State : <span class="red">*</span></div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryBillShipp[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : <span class="red">*</span></div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : <span class="red">*</span></div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryBillShipp[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
                                            </tr>
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
											  
											   <? if($_GET["tab"]=="slaesPerson"){ ?>  
												<tr>
												<td colspan="2" align="left" class="head"><?=$SubHeading?></td>
												</tr>
												<tr>
												<td  align="right"   class="blackbold">Sales Person : </td>
												<td   align="left" > 
												<input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arryCustomer[0]['sales_person']); ?>"  maxlength="40" readonly />
												<input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arryCustomer[0]['SalesID']); ?>" type="hidden">
												<a class="fancybox fancybox.iframe" href="/erp/admin/sales/EmpList.php?dv=7"  ><?=$search?></a>
												</td>
												</tr>

												
											  <? } ?>
											  <? 
									
											  
											  if($_GET["tab"]=="LoginPermission"){
													$permissionmenu=array(	)	;	
														if(in_array(5,$depids)){															
															$permissionmenu['quote']='Quotes';
															$permissionmenu['document']='Documents';
															$permissionmenu['contact']='Contacts';
															$permissionmenu['bank']='Bank Details';
														}		
														if(in_array(6,$depids)){
															$permissionmenu['invoice']='Invoice';
															$permissionmenu['purchaseorder']='Purchase History';
															//$permissionmenu['salesorder']='Sales Orders';
															$permissionmenu['shipping']='Shipping Address';
															$permissionmenu['billing']='Billing Address';																
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
													<td  align="right"   class="blackbold">Permission :<span class="red">*</span> </td>
													<td   align="left" >
													<?php
													$mypermision=array();
													if(!empty($userlogindetail->permission))
													$mypermision=unserialize($userlogindetail->permission);
													if(!empty($permissionmenu)){														
														foreach($permissionmenu as $k=>$permission){
															$chek='';
															if(in_array($k,$mypermision))
															$chek='checked="checked"';
															echo '<div class="permission-box"><span class="input check"><input type="checkbox" '.$chek.' value="'.$k.'" name="permission[]"/></span><label>'.$permission.'</label></div>';
														}	
													}?>
													<input type="hidden" name="company_userid" value="<?php echo $userlogindetail->id?>">
														 </td>
												  </tr>
												  <tr>
														 <td colspan="4">&nbsp;</td>
													</tr>
														
											  <? }else{
											  										  	
											  		echo _("<div style='font-size:15px'>Customer Have No User Login Detail</div> <div><input type='hidden' name='ganeratelogin' value='ganerate'> <input type='hidden' name='CustId' id='CustId' value='".$CustId."' /><input type='submit' name='ganerate' value='Ganerate' class='button'></div>");
											  		$HideSubmit=1;
											 	 }
											  } ?>
                                     
                                        </table>
                                   
                        </td>
                    </tr>


		 <? if($HideSubmit!=1){ ?>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <?php if(!empty($_GET['edit']) && $_GET['tab'] == "billing"){
                                    $CustomerID = "updateBilling"; 
                                }elseif(!empty($_GET['edit']) && $_GET['tab'] == "shipping"){
                                    $CustomerID = "updateBilling"; 
                                }elseif(!empty($_GET['edit']) && $_GET['tab'] == "general"){
                                    $CustomerID = "UpdateGeneral"; 
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
                            <input type="hidden" name="CustId" id="CustId" value="<?= $CustId; ?>" />
                            <?php if($_GET['tab'] == "billing" || $_GET['tab'] == "shipping"){ ?>
                            <input type="hidden" value="<?php echo $arryBillShipp[0]['state_id']; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryBillShipp[0]['city_id']; ?>" />
                             <?php }?>
                            <?php if($_GET['tab'] == "contact"){ ?>
                            <input type="hidden" value="<?php echo $arryCustomer[0]['State']; ?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustomer[0]['City']; ?>" />
                            <?php }?>
                            
                            <input name="Submit" type="submit" class="button" id="<?=$CustomerID?>" value="Update" />&nbsp;
                             <!--By Chetan-->
                                <input type="hidden" name="fieldIds" value="<?=$StrField?>">
                                <input type="hidden" name="fields" value="<?=$StrFieldName?>">
                          <!--End-->
                        </td>    
                    </tr>

		<? } ?>


                </table>
               </form>
           





