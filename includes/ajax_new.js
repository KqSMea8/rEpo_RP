
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
						alert(GLOBAL_EMAIL_EXIST);
					}else{
						alert(Title + " already exists in database. Please enter another.");
					}
					document.getElementById(FieldName).select();
					return false;
				} else if(httpObj.responseText==0) {	 
					document.forms[1].submit();
				}else {
					alert(ERROR + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}
	
	function SendMultipleExistRequest(Url,FieldName,Title,FieldName2,Title2){
		var SendUrl = Url+"&r="+Math.random(); 
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
				}else if(httpObj.responseText=='Buyer' || httpObj.responseText=='Seller') {
					alert("There is already a "+httpObj.responseText+" account with this "+Title+". Please enter another.");
					document.getElementById(FieldName).select();
					return false;
				}else if(httpObj.responseText=='EmailBuyer' || httpObj.responseText=='EmailSeller') {
					var tt = httpObj.responseText.replace("Email","");
					alert("There is already a "+tt+" account with this Email Address. Please enter another Email Address!!");
					document.getElementById(FieldName2).select();
					return false;
				}else if(httpObj.responseText==2) {
					alert(Title2+" already exists in database. Please enter another.");
					document.getElementById(FieldName2).select();
					return false;
				} else if(httpObj.responseText==0) {	 
					document.forms[1].submit();
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
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
					alert(ERROR + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}


	function SendAbuseExistRequest(Url,FieldName,Title,FieldName2,Title2){
		var SendUrl = Url+"&r="+Math.random(); 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function AbuseExistRequest(){
			if (httpObj.readyState == 4) {
				//alert(httpObj.responseText);
				if(httpObj.responseText==1) {
					alert(Title+" already exists in database. Please enter another.");
					document.getElementById(FieldName).select();
					return false;
				}else if(httpObj.responseText==2) {
					alert(Title+" has abuse words in it. Please remove them.");
					document.getElementById(FieldName).select();
					return false;
				}else if(httpObj.responseText==3) {
					alert(Title2+" has abuse words in it. Please remove them.");
					document.getElementById(FieldName2).select();
					return false;
				}else if(httpObj.responseText==0) {	 
					document.forms[1].submit();
				}else {
					alert("Error : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}


	
	function ValidateForgotPassword(frm){
		if(  ValidateForEmail(frm.forgotEmail)
			&& isEmail(frm.forgotEmail)
		){
			var SendUrl = "ajax.php?action=forgot&case=1&forgotEmail="+document.getElementById("forgotEmail").value+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ForgotRecieve(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==0) {	 
						alert(GLOBAL_EMAIL_NOT_EXIST);
						document.getElementById("forgotEmail").value = '';
					}else {
						//alert("Error occur : " + httpObj.responseText);
						document.getElementById("QuestionTitle").innerHTML = httpObj.responseText+'?';
						document.getElementById("MainDiv").style.display = 'none';
						document.getElementById("QuestionDiv").style.display = 'inline';
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
		if(  ValidateForEmail(frm.forgotEmail)
			&& isEmail(frm.forgotEmail)
		){
			
			document.getElementById("MsgDiv").innerHTML = SENDING_REQUEST;
			var SendUrl = 'ajax.php?action=forgot&case=2&forgotEmail='+document.getElementById("forgotEmail").value+'&r='+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ForgotPasswordRecieve(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById("MainDiv").innerHTML = '<Div id="MsgDiv" class="redtxt" align="center">'+PASSWORD_SENT+'</Div>';
						document.getElementById("MsgDiv").innerHTML = '';
					} else if(httpObj.responseText==0) {	 
						document.getElementById("MsgDiv").innerHTML = GLOBAL_EMAIL_NOT_EXIST;
					}else {
						alert(ERROR + httpObj.responseText);
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


function SignupEmailSend(frm){
		if(  ValidateForEmail(frm.forgotEmail)
			&& isEmail(frm.forgotEmail)
		){
			
			document.getElementById("MsgDiv").innerHTML = SENDING_REQUEST;
			var SendUrl = 'ajax.php?action=signup&case=2&forgotEmail='+document.getElementById("forgotEmail").value+'&r='+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ForgotPasswordRecieve(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById("MainDiv").innerHTML = '<Div id="MsgDiv" class="redtxt" align="center">You email has been signed up with us successfully.</Div>';
						document.getElementById("MsgDiv").innerHTML = '';
					} else if(httpObj.responseText==0) {	 
						document.getElementById("MsgDiv").innerHTML = 'This email is already signed up with us.';
					}else {
						alert(ERROR + httpObj.responseText);
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
		
			if(document.getElementById("city_td") != null){
				document.getElementById("city_td").innerHTML = '';
			}
		
		document.getElementById("SubmitButton").disabled = false;
		//document.getElementById("state_td").innerHTML = '<img src="'+GlobalSiteUrl+'images/loading.gif">';
		
		var SendUrl = GlobalSiteUrl+'ajax.php?action=state&country_id='+document.getElementById("country_id").value+'&current_state='+document.getElementById("main_state_id").value+'&r='+Math.random(); 

	
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				
				document.getElementById("state_td").innerHTML  = httpObj.responseText;
				
				if(document.getElementById("ajax_state_id").value > 0 ){
					document.getElementById("main_state_id").value = document.getElementById("ajax_state_id").value;
					CityListSend();
				}else{
					document.getElementById("SubmitButton").disabled = true;
					document.getElementById("main_state_id").value   = '';
				}
			}
		};
		httpObj.send(null);
	}

	function SetMainStateId(){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
		if(document.getElementById("main_city_id") != null){
			CityListSend();
		}
		
	}

	////////// Get City Functions ////////////////

	function CityListSend(){
		document.getElementById("SubmitButton").disabled = false;
		//document.getElementById("city_td").innerHTML = '<img src="'+GlobalSiteUrl+'images/loading.gif">';

		if(document.getElementById("state_id") != null){
			var SendUrl = GlobalSiteUrl+'ajax.php?action=city&state_id='+document.getElementById("state_id").value+'&current_city='+document.getElementById("main_city_id").value+'&r='+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function CityListRecieve(){
				if (httpObj.readyState == 4) {
					document.getElementById("city_td").innerHTML  = httpObj.responseText;
					if(document.getElementById("ajax_city_id").value > 0 ){
						document.getElementById("main_city_id").value = document.getElementById("ajax_city_id").value;
					}else{
						document.getElementById("SubmitButton").disabled = true;
						document.getElementById("main_city_id").value   = '';
					}
				}
			};
			httpObj.send(null);
		}

	}

	function SetMainCityId(){
		//alert('dsf');
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}





	////////// Get SubCategory Functions ////////////////

	function SubCategoryListSend(opt){

			document.getElementById("CategoryID").value = '';
			document.getElementById("SubCatTd").innerHTML = '';
			document.getElementById("SubCatTitle").innerHTML = '';
			document.getElementById("StoreCatTd").innerHTML = '';
			document.getElementById("StoreCatTitle").innerHTML = '';
			document.getElementById("StoreCatTd2").innerHTML = '';
			document.getElementById("StoreCatTitle2").innerHTML = '';


		if(document.getElementById("Category").value > 0){
			document.getElementById("SubCatTd").innerHTML = '<img src="images/loading.gif">';

			var OldCategoryID = document.getElementById("OldCategoryID").value;
			if(opt>0)
				OldCategoryID = '';

			var SendUrl = 'ajax.php?action=subcategory&Category='+document.getElementById("Category").value+'&OldCategoryID='+OldCategoryID+'&r='+Math.random(); 
			
			if(document.getElementById("HideSubCategoryMsg") != null){
				SendUrl += "&HideSubCategoryMsg=1";
			}


			httpObj2.open("GET", SendUrl, true);
			httpObj2.onreadystatechange = function SubCategoryRecieve(){
				
				if (httpObj2.readyState == 4) {
					
					document.getElementById("SubCatTd").innerHTML  = httpObj2.responseText;
					
					if(document.getElementById("ajax_category_id").value > 0 ){
						document.getElementById("SubCatTitle").innerHTML = 'Sub Category ';
						document.getElementById("CategoryID").value = document.getElementById("ajax_category_id").value;
						
					}else{
						document.getElementById("SubCatTitle").innerHTML = '';
						document.getElementById("CategoryID").value = document.getElementById("Category").value;
					}
					StoreCategoryListSend();
				}
			};
			httpObj2.send(null);
		}
	}

	function SetMainCategoryID(){
		document.getElementById("CategoryID").value = document.getElementById("SubCategory").value;
		
		if(document.getElementById("OldStoreCategoryID") != null){
			StoreCategoryListSend();
		}


	}

	function SetMainCategoryID2(){
		document.getElementById("CategoryID").value = document.getElementById("StoreCategoryID").value;
		
		if(document.getElementById("OldStoreCategoryID") != null){
			StoreCategoryListSend2();
		}


	}


	function StoreCategoryListSend(){
		
		if(document.getElementById("SubCategory").value>0){

			document.getElementById("StoreCatTd").innerHTML = '<img src="images/loading.gif">';

			var SendUrl = 'ajax.php?action=store_subcategory&Category='+document.getElementById("SubCategory").value+'&r='+Math.random(); 
			
			
			httpObj2.open("GET", SendUrl, true);
			httpObj2.onreadystatechange = function StoreCategoryRecieve(){
				
				if (httpObj2.readyState == 4) {
					
					document.getElementById("StoreCatTd").innerHTML  = httpObj2.responseText;
					
					if(document.getElementById("ajax_store_category_id").value > 0 ){
						document.getElementById("StoreCatTitle").innerHTML = 'Sub Sub Category';
						document.getElementById("MainStoreCategoryID").value = document.getElementById("ajax_store_category_id").value;
					}else{
						document.getElementById("StoreCatTd").innerHTML = '';
						document.getElementById("StoreCatTitle").innerHTML = '';
						document.getElementById("MainStoreCategoryID").value = '';
					}
					StoreCategoryListSend2();
				}
			};
			httpObj2.send(null);
		}else{
			document.getElementById("StoreCatTd").innerHTML = '';
			document.getElementById("StoreCatTitle").innerHTML = '';
			document.getElementById("StoreCatTd2").innerHTML = '';
			document.getElementById("StoreCatTitle2").innerHTML = '';
		}
	}


function StoreCategoryListSend2(){
		
		if(document.getElementById("StoreCategoryID").value>0){
			document.getElementById("StoreCatTd2").innerHTML = '<img src="images/loading.gif">';

			var SendUrl = 'ajax.php?action=store_sub_subcategory&Category='+document.getElementById("StoreCategoryID").value+'&r='+Math.random(); 
			
			
			httpObj2.open("GET", SendUrl, true);
			httpObj2.onreadystatechange = function StoreCategoryRecieve(){
				
				if (httpObj2.readyState == 4) {
					
					document.getElementById("StoreCatTd2").innerHTML  = httpObj2.responseText;
					
					if(document.getElementById("ajax_store_category_id2").value > 0 ){
						document.getElementById("StoreCatTitle2").innerHTML = 'Sub Sub Sub Category';
					}else{
						document.getElementById("StoreCatTd2").innerHTML = '';
						document.getElementById("StoreCatTitle2").innerHTML = '';
					}
					
				}
			};
			httpObj2.send(null);
		}else{
			document.getElementById("StoreCatTd2").innerHTML = '';
			document.getElementById("StoreCatTitle2").innerHTML = '';
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
						alert(ERROR + httpObj.responseText);
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


	
	function CheckAvailability(){
		if(Trim(document.getElementById("UserName")).value != ''){
			if(isUserName(document.getElementById("UserName"))){
				document.getElementById("CheckAvailabilityDiv").style.display = 'none';
				document.getElementById("MsgAvailability").innerHTML = '<img src="images/loading.gif"> Checking....';
						
				var SendUrl = 'ajax.php?action=check_availability&UserName='+escape(document.getElementById("UserName").value)+'&r='+Math.random(); 
				httpObj.open("GET",SendUrl, true);
				httpObj.onreadystatechange = function CheckAvailabilityRecieve(){
					if (httpObj.readyState == 4) {
						if(httpObj.responseText==1) {	 
							document.getElementById("MsgAvailability").innerHTML = '<span class=red12>'+USER_NAME_TAKEN+'</span>';
						} else if(httpObj.responseText==0) {	 
							document.getElementById("MsgAvailability").innerHTML = '<span class=greentxt>'+USER_NAME_AVAILABLE+'</span>';
						}else {
							alert(ERROR + httpObj.responseText);
						}
						return false;
					}
				};
				httpObj.send(null);
			}

		}else{
			alert(BLANK_USER_NAME);
			document.getElementById("UserName").focus();
		}

	}




	function ResetAvailability(){
			document.getElementById("CheckAvailabilityDiv").style.display = 'inline';
			document.getElementById("MsgAvailability").innerHTML = '';
	}


	function PlayVideo(videoID){
		
		
		var bigger = '';
		
		if(videoID>0){
			bigger=1;
		}
		
		if(document.getElementById("AvailableVideo") != null){
			videoID = document.getElementById("AvailableVideo").value;

		}
		
		if(videoID>0){
			var SendUrl = "ajax.php?action=video&videoID="+videoID+"&bigger="+bigger+"&r="+Math.random(); 

			document.getElementById("VideoPlayDiv").innerHTML = '<Div class="redtxt"  align=center><br><br><br><img src="images/load.gif">&nbsp;Loading video....</Div>';

			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function ListVideoRequest(){

				if (httpObj.readyState == 4) {

					document.getElementById("VideoPlayDiv").innerHTML = httpObj.responseText;

				}

			};

			httpObj.send(null);
		}else{
			alert("Please select a video to play.");
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


	function set_tax_price(){
		var SendUrl = "ajax.php?action=total_price&Quantity="+document.getElementById("Quantity").value+"&ProductID="+document.getElementById("ProductID").value+"&r="+Math.random(); 
		
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function ListPriceRequest(){
			if (httpObj.readyState == 4) {
					document.getElementById("TotalPriceDiv").innerHTML = httpObj.responseText;
			}

		};

		httpObj.send(null);
	}



function ChooseCategory(){
	document.getElementById("light").innerHTML = '<div class="generaltxt"><strong>Loading category.........</strong></div>';
	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
	
	var SendUrl = "ajax_category.php?r="+Math.random(); 
	httpObj.open("GET", SendUrl, true);
	httpObj.onreadystatechange = function ChooseCategoryRequest(){
		if (httpObj.readyState == 4) {
			document.getElementById("light").innerHTML = httpObj.responseText;
		}
	};

	httpObj.send(null);
}

function SearchCategory(){
	if(document.getElementById("Category").value>0){
		document.getElementById("light").innerHTML = '<div class="generaltxt"><strong>Loading category.........</strong></div>';
		document.getElementById('light').style.display='block';
		document.getElementById('fade').style.display='block';
		
		var SendUrl = "ajax_search_category.php?CategoryID="+document.getElementById("Category").value+"&r="+Math.random(); 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function ChooseCategoryRequest(){
			if (httpObj.readyState == 4) {
				document.getElementById("light").innerHTML = httpObj.responseText;
			}
		};

		httpObj.send(null);
	}else{
		document.getElementById('light').style.display='none';
		document.getElementById('fade').style.display='none';
	}

}

function CloseAlert(){
	document.getElementById('light').style.display='none';
	document.getElementById('fade').style.display='none';
}