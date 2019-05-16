
	var httpObj = false;
		try {
			  httpObj = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj = false;
			}
	  }

	}


	var httpObj2 = false;
		try {
			  httpObj2 = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj2 = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj2 = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj2 = false;
			}
	  }
	}

	function SendExistRequest(Url,FieldName,Title){
		var SendUrl = Url+"&r="+Math.random(); 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function RecieveExistRequest(){
			if (httpObj.readyState == 4) {
				if(httpObj.responseText==1) {
					if(Title == 'Email'){
						alert("This "+Title+" Address is already registered with us. Please enter another "+Title+" Address.");
					}else{
						alert(Title + " already exists in database. Please enter another.");
					}
					document.getElementById(FieldName).select();
					return false;
				} else if(httpObj.responseText==0) {
					ShowHideLoader(1,'S');
					document.forms[0].submit();
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}
	
	function SendMultipleExistRequest(Url,FieldName,Title,FieldName2,Title2){
		var SendUrl = Url+"&Multiple=1&r="+Math.random(); 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function RecieveMultipleExistRequest(){
			if (httpObj.readyState == 4) {
				
				if(httpObj.responseText==1) {
					if(Title == 'Email'){
						alert("This "+Title+" Address is already registered with us. Please enter another "+Title+" Address.");
					}else{
						alert(Title + " already exists in database. Please enter another.");
					}
					document.getElementById(FieldName).select();
					return false;
				}else if(httpObj.responseText==2) {
					alert(Title2+" already exists in database. Please enter another.");
					document.getElementById(FieldName2).select();
					return false;
				} else if(httpObj.responseText==0) {
					ShowHideLoader(1,'S');
					document.forms[0].submit();
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}




	function CheckExistingData(SendUrl,Params,FieldName,Title){
		var SendParam = Params+"&r="+Math.random(); 
		var IsExist = 0;
		$.ajax({
			type: "GET",
			async:false,
			url: SendUrl,
			data: SendParam,
			success: function (responseText) {
				if(responseText==1) {
					alert(Title + " already exists in database. Please enter another.");
					document.getElementById(FieldName).select();
					IsExist = 1;
				}else if(responseText==0) {
					IsExist = 0;
				}else{
					alert("Error occur : " + responseText);
					IsExist = 1;
				}
				
			}
		});	
		return IsExist;
	}



	function ClearAvail(MSG_SPAN){
		document.getElementById(MSG_SPAN).innerHTML="";
	}


	function CheckAvail(MSG_SPAN,FieldType,editID){
	
		document.getElementById(MSG_SPAN).innerHTML="";

		if(document.getElementById("Email").value!=''){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
		   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		   var address = document.getElementById("Email").value;
		   if(reg.test(address) == false) {
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Invalid Email Address.</span>";
			document.getElementById("Email").select();
		   }else{
					var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+editID+"&Type="+FieldType;
					var SendUrl = Url+"&r="+Math.random(); 
	
					httpObj.open("GET", SendUrl, true);
					httpObj.onreadystatechange = function RecieveAvailRequest(){
						if (httpObj.readyState == 4) {
								if(httpObj.responseText==1) {	 
									document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Not Available!</span>";
								}else if(httpObj.responseText==0) {	 
									document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>Available!</span>";
								}else {
									alert("Error occur : " + httpObj.responseText);
								}
						}
					};
					httpObj.send(null);
		   }

		}

	}


	function CheckAvailField(MSG_SPAN,FieldName,editID){
	
		document.getElementById(MSG_SPAN).innerHTML="";

		FieldLength = document.getElementById(FieldName).value.length;

		if(FieldLength>=3){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
			var Url = "isRecordExists.php?"+FieldName+"="+escape(document.getElementById(FieldName).value)+"&editID="+editID;
			var SendUrl = Url+"&r="+Math.random(); 

			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function RecieveAvailFieldRequest(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Not Available!</span>";
					}else if(httpObj.responseText==0) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>Available!</span>";
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
				}
			};
			httpObj.send(null);

		}else if(FieldLength>0){
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>It should be minimum of 3 characters long.</span>";
		}

	}

	function SendMenuPositionExistRequest(Url,FieldName,Title){
		var SendUrl = Url+"&r="+Math.random(); 
		
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function PositionExistRequest(){
			if (httpObj.readyState == 4) {
				if(httpObj.responseText==1) {	 
					alert(Title + " already exists in database. Please enter another.");
					document.getElementById(FieldName).select();
					return false;
				} else if(httpObj.responseText==0) {	 
					var Url = "isRecordExists.php?PageHeading="+document.getElementById("title").value+"&editID="+ document.getElementById("editID").value;
					SendExistRequest(Url,"title","Page Title");
					return false;	
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}

	function LoginSend(Url){
		var SendUrl = Url+"&r="+Math.random(); 
		document.getElementById("ReturnValue").value = '';
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function LoginRecieve(){
			if (httpObj.readyState == 4) {
				//alert(httpObj.responseText);
				document.getElementById("ReturnValue").value = httpObj.responseText;
				//return false;
				/*
				if(document.getElementById("redUrl").value != ''){
					location.href = document.getElementById("redUrl").value;
					return false;
				}
				*/
				
				 if(httpObj.responseText==10) {	 
					alert("Someone is already logged in with this Email Address, Please try again later.");
					document.getElementById("Email").value='';
					document.getElementById("Password").value='';
					return false;
				 } else if(httpObj.responseText==1) {	 
					//location.href = 'index.php';
					document.forms[0].submit();
					return false;
				}  else if(httpObj.responseText==5) {	 
					//alert("Your account has been de-activated as you didn't upgraded your membership. Please contact the administrator.");
					//location.href = 'accountSucc.php';
					document.forms[0].submit();
					return false;
				}else if(httpObj.responseText==6) {	 
					//alert("Your account is expired, Please upgrade your membership.");
					//location.href = 'accountSucc.php';
					document.forms[0].submit();
					return false;
				}else if(httpObj.responseText==7) {	 
					//alert("Your account is about to expire, Please upgrade your membership within few days.");
					//location.href = 'accountSucc.php';
					document.forms[0].submit();
					return false;
				}else if(httpObj.responseText==0) {	 
					alert("Invalid Email/Password.");
					document.getElementById("Password").focus();
					return false;
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}
	
	

	function ForgotPasswordQuestion(frm){
		if( ValidateForEmail(frm.forgotEmail, "Email")
			&& isEmail(frm.forgotEmail)
		){
			var SendUrl = 'forgot.php?action=1&forgotEmail='+document.getElementById("forgotEmail").value+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ForgotQuestionRecieve(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==0) {	 
						alert("This Email Address is not registred with us.");
					}else {
						//alert("Error occur : " + httpObj.responseText);
						document.getElementById("QuestionTitle").innerHTML = httpObj.responseText+'?';
						document.getElementById("MainDiv").style.display = 'none';
						document.getElementById("QuestionDiv").style.display = 'inline';
						httpObj.responseText
					}
					return false;
				}
			};
			httpObj.send(null);
			return false;
		}else{
			return false;
		}
	}

	function ForgotPasswordSend(frm){
		if( ValidateForBlank(frm.Answer, "Answer to the Security Question")
		){
			var SendUrl = 'forgot.php?action=2&Answer='+document.getElementById("Answer").value+'&forgotEmail='+document.getElementById("forgotEmail").value+'&r='+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ForgotPasswordRecieve(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById("QuestionDiv").innerHTML = '<Div class="greentxt">Your new password has been sent successfully.</Div>';
					} else if(httpObj.responseText==0) {	 
						alert("Wrong Answer, Please Enter the Correct Answer.");
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
					return false;
				}
			};
			httpObj.send(null);
			return false;
		}else{
			return false;
		}
	}


	////////// Get StateList Functions ////////////////


	function StateListSend(opt){
		if(opt==1){
			document.getElementById("main_state_id").value='';
		}
		if(document.getElementById("city_td") != null){
			document.getElementById("MainCityTitleDiv").style.display = 'none';
			document.getElementById("city_td").innerHTML = '';
		}

		var OtherOption = '';
		if(document.getElementById("OtherState") != null){
			OtherOption = '&other=1';
		}
		var SelectOption = '';
		if(document.getElementById("SelectOption") != null){
			SelectOption = '&select=1';
		}

		if(document.getElementById("AllOption") != null){
			SelectOption = '&all=1';
		}

		if(document.getElementById("ListingRecords") != null){
			document.getElementById("ListingRecords").style.display = 'none';
		}

		
		ShowHideLoader('1','L');
		document.getElementById("state_td").innerHTML = '<select name="state_id" class="inputbox" id="state_id" ><option value="">Loading...</option></select>';
		var SendUrl = 'ajax.php?action=state&country_id='+document.getElementById("country_id").value+'&current_state='+document.getElementById("main_state_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1'; 
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				document.getElementById("state_td").innerHTML  = httpObj.responseText;
				ShowHideLoader('');
				if(document.getElementById("state_id").value != '' ){
					document.getElementById("main_state_id").value = document.getElementById("ajax_state_id").value;
					if(document.getElementById("city_td") != null){
						CityListSend(); 	

					}
				}else{
					document.getElementById("main_state_id").value   = '';
						
				}
				

			}
		};
		httpObj.send(null);
	}

	function SetMainStateId(){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
		if(document.getElementById("ListingRecords") != null){
			document.getElementById("ListingRecords").style.display = 'none';
		}

		if(document.getElementById("main_city_id") != null){
			CityListSend();
		}
	}

	////////// Get City Functions ////////////////

	function CityListSend(){
		var OtherOption = '';
		if(document.getElementById("OtherCity") != null){
			OtherOption = '&other=1';
		}
		var SelectOption = '';
		if(document.getElementById("SelectOption") != null){
			SelectOption = '&select=1';
		}

		document.getElementById("MainCityTitleDiv").style.display = 'inline';

		document.getElementById("city_td").innerHTML = '<select name="city_id" class="inputbox" id="city_id" ><option value="">Loading...</option></select>';
		if(document.getElementById("state_id") != null){
			
			ShowHideLoader('1','L');
			var SendUrl = 'ajax.php?action=city&state_id='+document.getElementById("state_id").value+'&current_city='+document.getElementById("main_city_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1';
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function CityListRecieve(){
				if (httpObj.readyState == 4) {
					ShowHideLoader('');
					document.getElementById("city_td").innerHTML  = httpObj.responseText;
					
					if(document.getElementById("city_id").value != '' ){
						document.getElementById("main_city_id").value = document.getElementById("ajax_city_id").value;
					
					}else{
						document.getElementById("main_city_id").value   = '';
					}		

					SetMainCityId();
				}
			};
			httpObj.send(null);
			
		}

	}

	function SetMainCityId(){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
		
		//LocalityListSend(); 	// use below instead of LocalityListSend
		
		if(document.getElementById("OtherState") != null){
			if(document.getElementById("state_id").value > 0 ){
				document.getElementById("StateTitleDiv").style.display = 'none';
				document.getElementById("StateValueDiv").style.display = 'none';
			}else{
				document.getElementById("StateTitleDiv").style.display = 'inline';
				document.getElementById("StateValueDiv").style.display = 'inline';

			}
		}


		if(document.getElementById("OtherCity") != null){
			if(document.getElementById("city_id").value > 0 ){
				document.getElementById("CityTitleDiv").style.display = 'none';
				document.getElementById("CityValueDiv").style.display = 'none';
			}else{
				document.getElementById("CityTitleDiv").style.display = 'inline';
				document.getElementById("CityValueDiv").style.display = 'inline';

			}
		}


	}



	////////// Get SubCategory Functions ////////////////

	function SubCategoryListSend(opt){
		if(document.getElementById("Category").value > 0){
			document.getElementById("SubCatTd").innerHTML = '<img src="images/loading.gif">';

			var OldCategoryID = document.getElementById("OldCategoryID").value;
			if(opt>0)
				OldCategoryID = '';

			var SendUrl = 'ajax.php?action=subcategory&Category='+document.getElementById("Category").value+'&OldCategoryID='+OldCategoryID+'&r='+Math.random(); 
			
			httpObj2.open("GET", SendUrl, true);
			httpObj2.onreadystatechange = function SubCategoryRecieve(){
				
				if (httpObj2.readyState == 4) {
					
					document.getElementById("SubCatTd").innerHTML  = httpObj2.responseText;
					if(document.getElementById("ajax_category_id").value > 0 ){
						document.getElementById("SubCatTitle").innerHTML = 'Sub Classification <span class="red">*</span> ';
						document.getElementById("CategoryID").value = document.getElementById("ajax_category_id").value;
					}else{
						document.getElementById("SubCatTitle").innerHTML = '';
						document.getElementById("CategoryID").value = document.getElementById("Category").value;
					}
					StoreCategoryListSend();
				}
			};
			httpObj2.send(null);
		}else{
			document.getElementById("CategoryID").value = '';
			document.getElementById("SubCatTd").innerHTML = '';
			document.getElementById("SubCatTitle").innerHTML = '';
			document.getElementById("StoreCatTd").innerHTML = '';
			document.getElementById("StoreCatTitle").innerHTML = '';
		}
	}

	function SetMainCategoryID(){
		document.getElementById("CategoryID").value = document.getElementById("SubCategory").value;
		if(document.getElementById("OldStoreCategoryID") != null){
			StoreCategoryListSend();
		}
	}


	function StoreCategoryListSend(){
		if(document.getElementById("CategoryID").value>0){

			var SendUrl = 'ajax.php?action=store_subcategory&CategoryID='+document.getElementById("CategoryID").value+'&PostedByID='+document.getElementById("PostedByID").value+'&OldStoreCategoryID='+document.getElementById("OldStoreCategoryID").value+'&r='+Math.random(); 
			
			
			httpObj2.open("GET", SendUrl, true);
			httpObj2.onreadystatechange = function StoreCategoryRecieve(){
				
				if (httpObj2.readyState == 4) {
					
					document.getElementById("StoreCatTd").innerHTML  = httpObj2.responseText;
					
					if(document.getElementById("ajax_store_category_id").value > 0 ){
						document.getElementById("StoreCatTitle").innerHTML = 'Product Category <span class="red">*</span> ';
						document.getElementById("MainStoreCategoryID").value = document.getElementById("ajax_store_category_id").value;
					}else{
						document.getElementById("StoreCatTd").innerHTML = '';
						document.getElementById("StoreCatTitle").innerHTML = '';
						document.getElementById("MainStoreCategoryID").value = '';
					}
				}
			};
			httpObj2.send(null);
		}else{
			document.getElementById("StoreCatTd").innerHTML = '';
			document.getElementById("StoreCatTitle").innerHTML = '';
		}
	}
	//////////////////////////////////////////

	function UnsubscribeSend(frm){
		if( ValidateForEmail(frm.UnsubscribeEmail, "Email")
			&& isEmail(frm.UnsubscribeEmail)
		){
			var S_Type = frm.S_Type.value;

			if(S_Type != '') {
				SubscriptionMsg = 'Your have been subscribed for newsletters successfully.';
			}else{
				SubscriptionMsg = 'Your have been unsubscribed successfully.';
			}

			var SendUrl = 'ajax_member.php?UnsubscribeEmail='+frm.UnsubscribeEmail.value+"&S_Type="+S_Type+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function UnsubscribeRecieve(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById("MainDiv").innerHTML = '<Div class="greentxt">'+SubscriptionMsg+'</Div>';
					} else if(httpObj.responseText==0) {	 
						alert("Invalid Email, Please Enter a registered Email Address.");
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
					return false;
				}
			};
			httpObj.send(null);
			return false;
		}else{
			return false;
		}
	}


	function SetDeliveryCurrency(){
		var SendUrl = "ajax.php?action=currency&currency_id="+document.getElementById("currency_id").value+"&r="+Math.random(); 
		var NumDeliveryOption = document.getElementById("currency_id").value;
		httpObj.open("GET", SendUrl, true);

		httpObj.onreadystatechange = function ListCurrencyRequest(){

			if (httpObj.readyState == 4) {
				for(var i=1;i<=document.getElementById('NumDeliveryOption').value;i++){
					document.getElementById("DeliverySpanCurrency"+i).innerHTML = httpObj.responseText;
				}
			}

		};

		httpObj.send(null);

}

/*****************************************/
	function GetLeaveBalance(){
		if(document.getElementById("EmpID").value>0){
			var SendUrl = "ajax.php?action=leave_balance&EmpID="+document.getElementById("EmpID").value+"&LeaveType="+document.getElementById("LeaveType").value+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ListLeaveBalance(){
				if (httpObj.readyState == 4) {
					document.getElementById("LeaveBalance").innerHTML = httpObj.responseText;
				}

			};

			httpObj.send(null);
		}else{
					document.getElementById("LeaveBalance").innerHTML = "0";
		}

}
/*****************************************/
	function GetLocalTime(){
		
		if(document.getElementById("Timezone").value!=''){
			var SendUrl = "ajax.php?action=local_time&Timezone="+document.getElementById("Timezone").value+"&TimezonePlusMinus="+document.getElementById("TimezonePlusMinus").value+"&r="+Math.random(); 
			httpObj2.open("GET", SendUrl, true);
			httpObj2.onreadystatechange = function ListLocalTime(){
				if (httpObj2.readyState == 4) {

					document.getElementById("LocalTimeDiv").innerHTML = httpObj2.responseText;
				}

			};

			httpObj2.send(null);
		}else{
			document.getElementById("LocalTimeDiv").innerHTML = "";
		}

}

/*****************************************/
function DeleteFile(file_path,file_div){


	var Url = "ajax.php?action=delete_file&file_path="+escape(file_path)+"&r="+Math.random(); 

	$("#dialog-modal").html("Are you sure you want to delete this file?");
    $("#dialog-modal").dialog(
    {
        title: "Remove File",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				 $(this).dialog("close");
				 ShowHideLoader(1,'P');

					httpObj.open("GET", Url, true);
					httpObj.onreadystatechange = function DeleteRecieve(){
						if (httpObj.readyState == 4) {
							if(httpObj.responseText == 1){
								document.getElementById(file_div).innerHTML = '';
								 ShowHideLoader(0,'');
							}else if(httpObj.responseText == 0){
								alert("Deletion failed. Please try again later.");
							}else {
								alert("Error:" + httpObj.responseText);
							}
						return false;	
						}
					};
					httpObj.send(null);

			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });



}

/*****************************************/
function DeleteFileReload(file_path,file_div){
	var Url = "ajax.php?action=delete_file&file_path="+escape(file_path)+"&r="+Math.random(); 

	$("#dialog-modal").html("Are you sure you want to delete?");
    $("#dialog-modal").dialog(
    {
        title: "Remove File",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				 $(this).dialog("close");
				 ShowHideLoader(1,'P');

					httpObj.open("GET", Url, true);
					httpObj.onreadystatechange = function DeleteFileRecieve(){
						if (httpObj.readyState == 4) {
							if(httpObj.responseText == 1){
								document.getElementById(file_div).innerHTML = '';
								location.reload(); 
							}else if(httpObj.responseText == 0){
								alert("Deletion failed. Please try again later.");
							}else {
								alert("Error:" + httpObj.responseText);
							}
						return false;	
						}
					};
					httpObj.send(null);

			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });


	
}


/*************Function Added By Rajeev************/

   function StateListSendShipping(opt){
		if(opt==1){
			document.getElementById("main_state_id").value='';
		}
		if(document.getElementById("city_td") != null){
			document.getElementById("MainCityTitleDiv").style.display = 'none';
			document.getElementById("city_td").innerHTML = '';
		}

		var OtherOption = '';
		if(document.getElementById("OtherState") != null){
			OtherOption = '&other=1';
		}
		var SelectOption = '';
		if(document.getElementById("SelectOption") != null){
			SelectOption = '&select=1';
		}

		if(document.getElementById("ListingRecords") != null){
			document.getElementById("ListingRecords").style.display = 'none';
		}


		document.getElementById("state_td").innerHTML = '<select name="state_id" class="inputbox" id="state_id" ><option value="">Loading...</option></select>';
		var SendUrl = 'ajax.php?action=shippingstate&country_id='+document.getElementById("country_id").value+'&current_state='+document.getElementById("main_state_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1'; 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				document.getElementById("state_td").innerHTML  = httpObj.responseText;

				if(document.getElementById("state_id").value != '' ){
					document.getElementById("main_state_id").value = document.getElementById("ajax_state_id").value;
					if(document.getElementById("city_td") != null){
						CityListSend(); 	

					}
				}else{
					document.getElementById("main_state_id").value   = '';
						
				}
				

			}
		};
		httpObj.send(null);
	}
        
        function GetStateListForTax(opt){
		if(opt==1){
			document.getElementById("main_state_id").value='';
		}
		

		var OtherOption = '';
		
		var SelectOption = '';
		if(document.getElementById("SelectOption") != null){
			SelectOption = '&select=1';
		}

		if(document.getElementById("ListingRecords") != null){
			document.getElementById("ListingRecords").style.display = 'none';
		}


		document.getElementById("state_td").innerHTML = '<select name="state_id" class="inputbox" id="state_id" ><option value="">Loading...</option></select>';
		var SendUrl = 'ajax.php?action=taxstate&country_id='+document.getElementById("country_id").value+'&current_state='+document.getElementById("main_state_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1'; 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				document.getElementById("state_td").innerHTML  = httpObj.responseText;

				if(document.getElementById("state_id").value != '' ){
					document.getElementById("main_state_id").value = document.getElementById("ajax_state_id").value;
					
				}else{
					document.getElementById("main_state_id").value   = '';
						
				}
				

			}
		};
		httpObj.send(null);
	}
         function GetStateId(){
                        document.getElementById("all_state_id").value = $("#state_td option:selected").map(function(){ return this.value }).get().join(", ");;
                     
	}
/*************End Function By Rajeev************/



//////////////////////////////////////////
function EmpListSend(All,OnChangeFlag){
	var Department = document.getElementById("Department").value;

	if(Department>0){
		 document.getElementById("EmpValue").innerHTML = '<select class="inputbox" name="EmpID" id="EmpID"><option value="">Loading.....</option></select>';
		document.getElementById("EmpTitle").style.display = 'inline';
		document.getElementById("EmpValue").style.display = 'inline';



		var EmpStatus=0;
		if(document.getElementById("EmpStatus") != null){
			EmpStatus = document.getElementById("EmpStatus").value;
		}

		var SendUrl = 'ajax.php?action=emp_list&Department='+Department+'&Status='+EmpStatus+'&All='+All+'&OnChangeFlag='+OnChangeFlag+'&OldEmpID='+document.getElementById("OldEmpID").value+'&r='+Math.random(); 
		ShowHideLoader(1,'L');
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function EmpRecieve(){
			if (httpObj.readyState == 4) {
				ShowHideLoader('');
				document.getElementById("EmpValue").innerHTML  = httpObj.responseText;
			}
		};
		httpObj.send(null);
	}else{
		document.getElementById("EmpTitle").style.display = 'none';
		document.getElementById("EmpValue").style.display = 'none';
	}
}



function DeptListSend(All,OnChangeFlag){
	var Division = document.getElementById("Division").value;

	if(Division>0){
		document.getElementById("DeptValue").innerHTML = '<select class="inputbox" name="depID" id="depID"><option value="">Loading.....</option></select>';
		document.getElementById("DeptTitle").style.display = 'inline';
		document.getElementById("DeptValue").style.display = 'inline';

		var SendUrl = 'ajax.php?action=dept_list&Division='+Division+'&OnChangeFlag='+OnChangeFlag+'&OldDeptID='+document.getElementById("OldDeptID").value+'&r='+Math.random(); 
		ShowHideLoader(1,'L');
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function DeptRecieve(){
			if (httpObj.readyState == 4) {
				ShowHideLoader('');
				document.getElementById("DeptValue").innerHTML  = httpObj.responseText;
			}
		};
		httpObj.send(null);
	}else{
		document.getElementById("DeptTitle").style.display = 'none';
		document.getElementById("DeptValue").style.display = 'none';
	}
}




function autozipcode(){
	var city_id = $("#main_city_id").val();
	if(city_id>0){
		var action = 'zipSearch';
		$('#ZipCode').attr('autocomplete', 'off');
		if(document.getElementById("zipcode_list") == null){
			var ZipTD = $('#ZipCode').closest("td");
			ZipTD.append('<img src="../images/loading.gif" id="zip_loader"><ul id="zipcode_list" class="zipcodelist"></ul>');			
			$("#zipcode_list").mouseleave(function(){
			  $('#zipcode_list').hide();
			});
		}
		$('#zip_loader').show();
		$.ajax({
			url: 'ajax.php',
			type: 'GET',
			data: {city_id:city_id,action:action},
			success:function(data){	
				$('#zip_loader').hide();
				if(data!=''){	
					$('#zipcode_list').show();
					$('#zipcode_list').html(data);
				}
			}
		});
	}
}


function set_zip(item) {
	$('#ZipCode').val(item);
	$('#zipcode_list').hide();
	$('#zip_loader').hide();
}

