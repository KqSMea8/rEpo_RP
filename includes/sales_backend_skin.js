     $(document).ready(function(){
               $("#SaveCustomer").click(function(){
                    var FirstName = $.trim($("#FirstName").val());
                    var LastName = $.trim($("#LastName").val());
                    var Mobile = $.trim($("#Mobile").val());
                    var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var gender = $.trim($("#Gender").val());
                    var CustomerType = $.trim($("#CustomerType").val());
                    var Company = $.trim($("#Company").val());
                    var CustID = $.trim($("#CustId").val());
                    var Address = $.trim($("#Address").val());
                    var main_state_id = $.trim($("#main_state_id").val());
                    var main_city_id = $.trim($("#main_city_id").val());
                    var OtherState = $.trim($("#OtherState").val());
                    var OtherCity = $.trim($("#OtherCity").val());
                    var ZipCode = $.trim($("#ZipCode").val());
                    var CustCode = $.trim($("#CustCode").val());
					if(CustCode!=''){
						if(!ValidateMandRange(document.getElementById("CustCode"), "Customer Code",3,20)){
							return false;
						}
						DataExist = CheckExistingData("isRecordExists.php","&CustCode="+escape(CustCode), "CustCode","Customer Code");
						if(DataExist==1)  return false;

					}
	
                   if(CustomerType == "")
                    {
                        alert("Please Select Customer Type");
                        $("#CustomerType").focus();
                        return false;
                    }
				   if(Company == "" && CustomerType == "Company")
                    {
                        alert("Please Enter Company");
                        $("#Company").focus();
                        return false;
                    }
                    if(FirstName == "")
                    {
                        alert("Please Enter First Name");
                        $("#FirstName").focus();
                        return false;
                    }

                    if(LastName == "")
                    {
                        alert("Please Enter Last Name");
                        $("#LastName").focus();
                        return false;
                    }
                    if(gender == "")
                    {
                        alert("Please Select Gender");
                        $("#Gender").focus();
                        return false;
                    }
                    
                   
                   if(email == "")
                    {
                        alert("Please Enter Email Address");
                        $("#Email").focus();
                        return false;

                    } 

                    if(!emailRegister.test(email))
                    {
                        alert("Please Enter Valid Email Address");
                        $("#Email").focus();
                        return false;

                    } 
                    
                     DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	             if(DataExist==1)return false;
                     
                    if(Address == "")
                    {
                        alert("Please Enter Address");
                        $("#Address").focus();
                        return false;
                    }
                    if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State");
                        $("#OtherState").focus();
                        return false;
                    }

                    if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
                    {
                        alert("Please Enter City");
                        $("#OtherCity").focus();
                        return false;
                    }

                    if(ZipCode == "")
                    {
                        alert("Please Enter Zip Code");
                        $("#ZipCode").focus();
                        return false;
                    } 
                    
                   if(Mobile == "")
                    {
                        alert("Please Enter Mobile Number");
                        $("#Mobile").focus();
                        return false;
                    }
                  
             

                    ShowHideLoader('1','S');
                });
                
				 $("#UpdateContact").click(function(){
                    var FirstName = $.trim($("#FirstName").val());
                    var LastName = $.trim($("#LastName").val());
                    var Mobile = $.trim($("#Mobile").val());
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
                        alert("Please Enter First Name");
                        $("#FirstName").focus();
                        return false;
                    }

                    if(LastName == "")
                    {
                        alert("Please Enter Last Name");
                        $("#LastName").focus();
                        return false;
                    }
                    if(gender == "")
                    {
                        alert("Please Select Gender");
                        $("#Gender").focus();
                        return false;
                    }
                    
                   
                   if(email == "")
                    {
                        alert("Please Enter Email Address");
                        $("#Email").focus();
                        return false;

                    } 

                    if(!emailRegister.test(email))
                    {
                        alert("Please Enter Valid Email Address");
                        $("#Email").focus();
                        return false;

                    } 
                    
                     DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	             if(DataExist==1)return false;
                     
                    if(Address == "")
                    {
                        alert("Please Enter Address");
                        $("#Address").focus();
                        return false;
                    }
                    if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State");
                        $("#OtherState").focus();
                        return false;
                    }

                    if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
                    {
                        alert("Please Enter City");
                        $("#OtherCity").focus();
                        return false;
                    }

                    if(ZipCode == "")
                    {
                        alert("Please Enter Zip Code");
                        $("#ZipCode").focus();
                        return false;
                    } 
                    
                   if(Mobile == "")
                    {
                        alert("Please Enter Mobile Number");
                        $("#Mobile").focus();
                        return false;
                    }
                  
             

                    ShowHideLoader('1','S');
                });
				
				
				  $("#UpdateGeneral").click(function(){
                   
                    var CustomerType = $.trim($("#CustomerType").val());
                    var Company = $.trim($("#Company").val());
               
					   if(CustomerType == "")
						{
							alert("Please Select Customer Type");
							$("#CustomerType").focus();
							return false;
						}
					   if(Company == "" && CustomerType == "Company")
						{
							alert("Please Enter Company");
							$("#Company").focus();
							return false;
						}
                   
                    ShowHideLoader('1','S');
                });
				
               $("#updateBilling").click(function(){
                    var BName = $.trim($("#Name").val());
                    var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var Address1 = $.trim($("#Address1").val());
                    var main_state_id = $.trim($("#main_state_id").val());
                    var main_city_id = $.trim($("#main_city_id").val());
                    var OtherState = $.trim($("#OtherState").val());
                    var OtherCity = $.trim($("#OtherCity").val());
                    var ZipCode = $.trim($("#ZipCode").val());
                    var Mobile = $.trim($("#Mobile").val());
                   
                   if(BName == "")
                    {
                        alert("Please Enter Name");
                        $("#Name").focus();
                        return false;
                    }
                    if(email == "")
                    {
                        alert("Please Enter Email Address");
                        $("#Email").focus();
                        return false;

                    } 

                    if(!emailRegister.test(email))
                    {
                        alert("Please Enter Valid Email Address");
                        $("#Email").focus();
                        return false;

                    } 
                    if(Address1 == "")
                    {
                        alert("Please Enter Address1");
                        $("#Address1").focus();
                        return false;
                    }
                    if(Address1 == "")
                    {
                        alert("Please Enter Address1");
                        $("#Address1").focus();
                        return false;
                    }

                    if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State");
                        $("#OtherState").focus();
                        return false;
                    }

                    if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
                    {
                        alert("Please Enter City");
                        $("#OtherCity").focus();
                        return false;
                    }

                    if(ZipCode == "")
                    {
                        alert("Please Enter Zip Code");
                        $("#ZipCode").focus();
                        return false;
                    }
                    if(Mobile == "")
                    {
                        alert("Please Enter Mobile Number");
                        $("#Mobile").focus();
                        return false;
                    }

                    ShowHideLoader('1','S');
                });
				
				
				$("#UpdateBank").click(function(){
                   
                    var BankName = $.trim($("#BankName").val());
                    var AccountName = $.trim($("#AccountName").val());
					var AccountNumber = $.trim($("#AccountNumber").val());
                    var IFSCCode = $.trim($("#IFSCCode").val());
               
					   if(BankName == "")
						{
							alert("Please Enter Bank Name");
							$("#BankName").focus();
							return false;
						}
					   if(AccountName == "")
						{
							alert("Please Enter Account Name");
							$("#AccountName").focus();
							return false;
						}
						if(AccountNumber == "")
						{
							alert("Please Enter Account Number");
							$("#AccountNumber").focus();
							return false;
						}
						
						if(AccountNumber.length < 10 || AccountNumber.length >20)
						{
						    alert("Please Enter Valid Account Number");
							$("#AccountNumber").focus();
						    return false;
						}
					   if(IFSCCode == "")
						{
							alert("Please Enter IFSC Code");
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
                    }else{
                        $("#showCompany").hide();
                    }
                     
                 });
                 
                $custType = $("#CustomerType").val();
                if($custType == "Company"){
                        $("#showCompany").show();
                    }else{
                        $("#showCompany").hide();
                    }
                //End
                
				
				//Code for same billing and shipping
				
				 $("#sameBilling").click(function(){
				 
				       if($("#sameBilling").prop('checked') == true)
					    {
						  $("#ShippingName").val($("#CustomerName").val());
						  $("#ShippingCompany").val($("#CustomerCompany").val());
						  $("#ShippingAddress1").val($("#Address1").val());
						  $("#ShippingAddress2").val($("#Address2").val());
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
						  $("#ShippingAddress1").val('');
						  $("#ShippingAddress2").val('');
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




            function keyup(me)
            {
                if(isNaN(me.value))
                {
                    me.value="";
                }
            }
            