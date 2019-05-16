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
         }
      
  });

});



