$(document).ready(function(){
var GlobalSiteUrl = $("#homeCompleteUrl").val();
    
 $("#ContinueWithOrder").click(function(){
            var FirstName = $.trim($("#FirstName").val());
            var LastName = $.trim($("#LastName").val());
            var Phone = $.trim($("#Phone").val());
            var Address1 = $.trim($("#Address1").val());
            var main_state_id = $.trim($("#main_state_id").val());
            var main_city_id = $.trim($("#main_city_id").val());
            var OtherState = $.trim($("#OtherState").val());
            var OtherCity = $.trim($("#OtherCity").val());
            var ZipCode = $.trim($("#ZipCode").val());
            var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var Email = $.trim($("#Email").val());
                 
            if(FirstName == "")
            {
                alert("Please Enter Billing First Name");
                $("#FirstName").focus();
                return false;
            }
       
            if(LastName == "")
            {
                alert("Please Enter Billing Last Name");
                $("#LastName").focus();
                return false;
            }
            if(Address1 == "")
            {
                alert("Please Enter Billing Address1");
                $("#Address1").focus();
                return false;
            }
             if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
             {
                alert("Please Enter Billing State");
                $("#OtherState").focus();
                return false;
             }
             
             if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
             {
                alert("Please Enter Billing City");
                $("#OtherCity").focus();
                return false;
             }
             
            if(ZipCode == "")
             {
                alert("Please Enter Billing Zip Code");
                $("#ZipCode").focus();
                return false;
             }
            if(Phone == "")
            {
                alert("Please Enter Billing Phone Number");
                $("#Phone").focus();
                return false;
            }
            if(Email == "")
            {
                alert("Please Enter Billing Email Address");
                $("#Email").focus();
                return false;
            }
          if (!emailRegister.test(Email)) {
            alert("Please Enter Valid Email Address");
            $("#Email").focus();
            return false;
          }  
          
          //Validation For Shipping Address
         
       
         var sa_new = $("input[name='shipping_address_id']:checked").val();
        
          if(sa_new == "new")
              {
                    var ShippingName = $.trim($("#ShippingName").val());
                    var ShippingAddress1 = $.trim($("#ShippingAddress1").val());
                    var ShippingPhone = $.trim($("#ShippingPhone").val());
                    var main_state_id_shipp = $.trim($("#main_state_id_shipp").val());
                    var main_city_id_shipp = $.trim($("#main_city_id_shipp").val());
                    var OtherState_shipp = $.trim($("#OtherState_shipp").val());
                    var OtherCity_shipp = $.trim($("#OtherCity_shipp").val());
                    var ShippingZip = $.trim($("#ShippingZip").val());
                    
                    var AddressType = $("input[name='AddressType']:checked").length;
                  
                    if(AddressType == "0")
                        {
                            alert("Please Select Address Type");
                            return false;
                        }
                  
                   if(ShippingName == "")
                        {
                            alert("Please Enter Shipping Name");
                            $("#ShippingName").focus();
                            return false;
                        }

                      
                        if(ShippingAddress1 == "")
                        {
                            alert("Please Enter Shipping Address1");
                            $("#ShippingAddress1").focus();
                            return false;
                        }
                         if((main_state_id_shipp == "" || main_state_id_shipp == "0") && (OtherState_shipp == ""))
                         {
                            alert("Please Enter Shipping State");
                            $("#OtherState_shipp").focus();
                            return false;
                         }

                         if((main_city_id_shipp == "" || main_city_id_shipp== "0") && (OtherCity_shipp == ""))
                         {
                            alert("Please Enter Shipping City");
                            $("#OtherCity_shipp").focus();
                            return false;
                         }

                        if(ShippingZip == "")
                         {
                            alert("Please Enter Shipping Zip Code");
                            $("#ShippingZip").focus();
                            return false;
                         }
                        if(ShippingPhone == "")
                        {
                            alert("Please Enter Shipping Phone Number");
                            $("#ShippingPhone").focus();
                            return false;
                        }
                         
              }
              
           ShowHideLoader('1','P'); 
     
 });
 
 
 $(".ShippingAddress").click(function(){
     
     var RadioVal = $(this).val();
     $("#div_new_shipping_address").hide();
     
 });
 
 $("#shipping_address_id").click(function(){
     
      $("#div_new_shipping_address").show();
     
 });
 

 var CheckVal = $("input[name='shipping_address_id']:checked").val();
 if(CheckVal != "new")
     {
        $("#div_new_shipping_address").hide();
     }
     else{
          $("#div_new_shipping_address").show();
     }
     
     
     $("#btnPurchase30").click(function(){
    	
    var checked = $("#PaymentProcess input:checked").length > 0;
    if (!checked){
        alert("Please Choose Payment Method.");
        return false;
    }
    else{
    	var selectedMethod = $("#PaymentProcess input:checked").val();
    	$('#cardtbl').hide();
    	if(selectedMethod=='paypalpro'){
    		$('#cardtbl').show();
    		var currentYear = (new Date).getFullYear();
    		var currentMonth =("0" + ((new Date).getMonth() + 1)).slice(-2);

    		
    		
    		if($("#creditCardType").val()==''){
    			alert("Please Select Card Type.");
    			return false;
    		}
    		else if($("#creditCardNumber").val()==''){
    			alert("Please Enter Card Number.");
    			return false;
    		}
    		else if($("#expDateMonth").val()==''){
    			alert("Please Select Month.");
    			return false;
    		}
    		else if($("#expDateYear").val()==''){
    			alert("Please Select Year.");
    			return false;
    		}
    		else if($("#cvv2Number").val()==''){
    			alert("Please enter cvv number.");
    			return false;
    		}
    		
    		else if( ($("#expDateYear").val()==currentYear) && ($("#expDateMonth").val() < currentMonth )  ){
    			alert("Please enter a valid card expire year");
    			return false;
    		}
    	}
        ShowHideLoader('1','P');
        return true;
        
    }
  });


  $("#CheckShippingMetod").click(function(){
    var checked = $("#ShippingMethodForm input:checked").length > 0;
    if (!checked){
        alert("Please Choose Your Delivery Option.");
        return false;
    }
    else{
        ShowHideLoader('1','P');
        return true;
        
    }
  });


  $(".selectPaymentMethod").click(function(){
      
     var paymentID = $(this).attr('id');
      $(".paymentDescription").hide();
      if($(this).attr('checked', true))
         {
           $("#paymentDescription_"+paymentID).show();
           $('#cardtbl').hide();
           if(paymentID=='paypalpro'){
        	 $("#paymentDescription_"+paymentID).show();
        	
       		if ($("#carddiv_"+paymentID).html().length == 0) {      			
       			createFormSend(paymentID);
       			
        	   } 
       		
       		$('#cardtbl').show();	 
       		
       	}
         }
      
  });

});

function createFormSend(paymentID){
	ShowHideLoader('1','L');
	var SendUrl = 'ajax.php?action=cardform';
	httpObj.open("GET", SendUrl, true);
	httpObj.onreadystatechange = function createFormRecieve(){
		if (httpObj.readyState == 4) {
			ShowHideLoader('');
			
			
       		if ($("#carddiv_"+paymentID).html().length == 0) {      			
       			
       			document.getElementById("carddiv_"+paymentID).innerHTML  = httpObj.responseText; 	
       			
       	   } 
			
			
		}
	};
	httpObj.send(null);
}
function generateCC(){
	var cc_number = new Array(16);
	var cc_len = 16;
	var start = 0;
	var rand_number = Math.random();

	switch(document.PaymentProcess.creditCardType.value)
    {
		case "Visa":
			cc_number[start++] = 4;
			break;
		case "Discover":
			cc_number[start++] = 6;
			cc_number[start++] = 0;
			cc_number[start++] = 1;
			cc_number[start++] = 1;
			break;
		case "MasterCard":
			cc_number[start++] = 5;
			cc_number[start++] = Math.floor(Math.random() * 5) + 1;
			break;
		case "Amex":
			cc_number[start++] = 3;
			cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
			cc_len = 15;
			break;
    }

    for (var i = start; i < (cc_len - 1); i++) {
		cc_number[i] = Math.floor(Math.random() * 10);
    }

	var sum = 0;
	for (var j = 0; j < (cc_len - 1); j++) {
		var digit = cc_number[j];
		if ((j & 1) == (cc_len & 1)) digit *= 2;
		if (digit > 9) digit -= 9;
		sum += digit;
	}

	var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
	cc_number[cc_len - 1] = check_digit[sum % 10];

	document.PaymentProcess.creditCardNumber.value = "";
	for (var k = 0; k < cc_len; k++) {
		document.PaymentProcess.creditCardNumber.value += cc_number[k];
	}
}
function checkMethodType_2(){
	

	

	document.getElementById("city_td").innerHTML = '<select name="city_id" class="inputbox" id="city_id" ><option value="">Loading...</option></select>';
	if(document.getElementById("state_id") != null){
		
		ShowHideLoader('1','L');
		var SendUrl = 'ajax.php?action=city&state_id='+document.getElementById("state_id").value+'&current_city='+document.getElementById("main_city_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1';
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function CityListRecieve(){
			if (httpObj.readyState == 4) {
				ShowHideLoader('');
				document.getElementById("city_td").innerHTML  = httpObj.responseText;
				
				
				
			}
		};
		httpObj.send(null);
		
	}

}
function checkMethodType(){
	var selectedMethod = $('input:radio[name=payment_method]:checked').val();
	$('#cardtbl').hide();
	if(selectedMethod=='paypalpro'){
		$('#paymentDescription_'+selectedMethod).show();
		$('#cardtbl').show();
	}
}


