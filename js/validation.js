$(document).ready(function(){
    var GlobalSiteUrl = $("#homeCompleteUrl").val();
 $("#btnemailtofriend").click(function(){
    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var yname = $.trim($("#yname").val());
    var yemail = $.trim($("#yemail").val());
    var fname = $.trim($("#fname").val());
    var femail = $.trim($("#femail").val());
    
    
     if(yname == "") {
            alert("Please Enter Your Name");
            $("#yname").focus();
            return false;
        }
    if(yemail == "") {
            alert("Please Enter Your Email Address");
            $("#yemail").focus();
            return false;
        }
    
    if (!emailRegister.test(yemail)) {
            alert("Please Enter Your Valid Email Address");
            $("#yemail").focus();
            return false;
        }
        
      if(fname == "") {
            alert("Please Enter Your Friend's Name");
            $("#fname").focus();
            return false;
        }
    if(femail == "") {
            alert("Please Enter Your Friend's Email Address");
            $("#femail").focus();
            return false;
        }
    
    if (!emailRegister.test(femail)) {
            alert("Please Enter Your Friend's Valid Email Address");
            $("#femail").focus();
            return false;
        }  
        
        $.fancybox.close();
        ShowHideLoader('1','P');
     
 });
 
 
  $('.fancybox').fancybox();
  $('#mycarousel').jcarousel();
  
  $("#continueShopping").click(function(){
     
     window.location.href = GlobalSiteUrl+"/index.php";
      
  });
  
  $(".deleteProduct").click(function(){
      
      var dataVal = $(this).attr('alt');
      var splitData = dataVal.split("#"); 
      var Cid = splitData[0];
      var ProductId = splitData[1];
      var CartID = splitData[2];
      var numCart = $("#numCart").val();
      
      var data = '&Cid=' + Cid +'&ProductId='+ProductId+'&CartID='+CartID+'&numCart='+numCart+'&action=deleteProductFromCart';
      
        if (data) {
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                 window.location.href = msg;
                }
            });
        }
  });
  
  $("#SaveCustomer").click(function(){
            var FirstName = $.trim($("#FirstName").val());
            var LastName = $.trim($("#LastName").val());
            var Phone = $.trim($("#Phone").val());
            var Address1 = $.trim($("#Address1").val());
            var billcountryId = $.trim($("#billcountry_id").val());
            var main_state_id = $.trim($("#main_state_id").val());
            var main_city_id = $.trim($("#main_city_id").val());
            var OtherState = $.trim($("#OtherState").val());
            var OtherCity = $.trim($("#OtherCity").val());
            var ZipCode = $.trim($("#ZipCode").val());
            var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var Email = $.trim($("#Email").val());
            var data = '&Email=' + Email +'&action=checkEmail';
            var Password = $.trim($("#Password").val());
            var Confirm_Password = $.trim($("#Confirm_Password").val());
            
            var PasswordLength = $.trim($("#Password").val()).length;
           
                 
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
            if(Address1 == "")
            {
                alert("Please Enter Address1");
                $("#Address1").focus();
                return false;
            }
            
            if(billcountryId == "")
             {
                alert("Please Select Country");
                $("#country_id").focus();
                return false;
             }
            if(main_state_id == "")
             {
                alert("Please Select State");
                $("#state_id").focus();
                return false;
             }
             if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
             {
                alert("Please Enter State");
                $("#OtherState").focus();
                return false;
             }
             
             if(main_city_id == "")
             {
                alert("Please Select City");
                $("#city_id").focus();
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
            if(Phone == "")
            {
                alert("Please Enter Phone Number");
                $("#Phone").focus();
                return false;
            }
            if(Email == "")
            {
                alert("Please Enter Email Address");
                $("#Email").focus();
                return false;
            }
          if (!emailRegister.test(Email)) {
            alert("Please Enter Valid Email Address");
            $("#Email").focus();
            return false;
          }  
           
        if (data) {
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                    if(msg == "1")
                        {
                              alert("This Email Address Already Exists.");
                              $("#Email").focus();
                               return false;
                        }
                     else if(Password == "")
                       {
                         alert("Please Enter Your Password.");
                         $("#Password").focus();
                         return false;
                       }
                       
                  
                      else if(PasswordLength < 6)
                       {
                         alert("Password Should Be Minimum 6 Digits.");
                         $("#Password").focus();
                         return false;
                       }
                       
                       else if(PasswordLength >= 31)
                       {
                         alert("Password Should Be Maximum 30 Digits.");
                         $("#Password").focus();
                         return false;
                       }
                       
                       
                       else if(Confirm_Password == "")
                       {
                         alert("Please Enter Your Confirm Password.");
                         $("#Confirm_Password").focus();
                         return false;
                       }
                       
                       else if(Password != Confirm_Password)
                       {
                         alert("Password And Confirm Password Should Be Same.");
                         $("#Confirm_Password").focus();
                         return false;
                       }
                       else
                           {    ShowHideLoader('1','S');
                               $(".register_form").submit();
                           }
               
                }
            });
           }
            
            
                
        });
        
        
        $("#btnLOgin").click(function(){
            var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var LoginEmail = $.trim($("#LoginEmail").val());
            var LoginPassword = $.trim($("#LoginPassword").val());
            
            if(LoginEmail == "")
            {
                alert("Please Enter Your Email Address");
                $("#LoginEmail").focus();
                return false;
            }
           if (!emailRegister.test(LoginEmail)) {
                alert("Please Enter Valid Email Address");
                $("#LoginEmail").focus();
                return false;
            }  
           if(LoginPassword == "")
            {
                alert("Please Enter Your Password");
                $("#LoginPassword").focus();
                return false;
            }
            
            ShowHideLoader('1','P');
        });
        
      $("#shortprodduct").change(function(){
         ShowHideLoader('1','P');
         var CatID = $("#CatID").val();
         var Mfg = $("#Mfg").val();
         var search_str = $("#search_str").val();
         var shortVal = $(this).val();
         window.location.href = 'products.php?cat='+CatID+'&Mfg='+Mfg+'&search_str='+search_str+'&shortBy='+shortVal;
      
     
          
      }); 
      
       $("#manufacturerList").change(function(){
         ShowHideLoader('1','P');
         var CatID = $("#CatID").val();
         var shortBy = $("#shortBy").val();
         var shortVal = $(this).val();
         var search_str = $("#search_str").val();
         window.location.href = 'products.php?cat='+CatID+'&shortBy='+shortBy+'&Mfg='+shortVal+'&search_str'+search_str; 
          
      }); 
      
     $("#btnRegister").click(function(){
          var ContinueUrl = $("#ContinueUrl").val();
          if(ContinueUrl != "")
              {
                  window.location.href = 'register.php?ref='+ContinueUrl; 
              }else
                  {
                    window.location.href = 'register.php';   
                  }
         
      });
      
     $("#btnSendLogin").click(function(){
          
         window.location.href = 'login.php'; 
      });
     $("#btnChechout").click(function(){
          
         //window.location.href = 'checkout.php'; 
         $("#CartSubmitFromCheckOut").val('1');
      }); 
      
    $("#resetPassword").click(function(){
        var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var forgotEmail = $.trim($("#forgotEmail").val());
        
          if(forgotEmail == "")
            {
                alert("Please Enter Your Email Address");
                $("#forgotEmail").focus();
                return false;
            }
           if (!emailRegister.test(forgotEmail)) {
                alert("Please Enter valid Email Address");
                $("#forgotEmail").focus();
                return false;
            }  
         ShowHideLoader('1','P');
    });  
    
    	$('#product-rating').rater({
		'curvalue': $('#product-rating').attr('title'),
		'disable': true
	});
		
	$('#new-product-rating').rater({
		'sticky': true,
		'callback': function(value){
			$('#new-product-rating').data("rating", value);
		}
	});
	
	//  add the rater stars to each displayed review
	$('div.product-review-item-rating').each(function(){
		$(this).rater({
			'curvalue': this.title,
			'disable':true
		});
	});
    
    $("#btnSendReview").click(function(){
       
        var ReviewTitle = $.trim($("#ReviewTitle").val());
        var ReviewText = $.trim($("#ReviewText").val());
        var RatingVal = $('#new-product-rating').data("rating");
         $("#Rating").val($('#new-product-rating').data("rating"));
        
          if(ReviewTitle == "")
            {
                alert("Please Enter A Title.");
                $("#ReviewTitle").focus();
                return false;
            }
          if(ReviewText == "")
            {
                alert("Please Write A Review.");
                $("#ReviewText").focus();
                return false;
            }
           if($('#new-product-rating').data("rating")==null)
            {
                alert("Please Provide A Star Rating For Reviewed Product.");
                return false;
            }
        ShowHideLoader('1','P');
    });  
    
    
  $("#btnSaveWishlist").click(function(){
      
    var Cid = $("#Cid").val();
    var Name = $.trim($("#Name").val());
    var data = '&Cid=' + Cid +'&Name='+ Name +'&action=addwishlist';
    if(Name == "")
        {
            alert("Please Enter Your Wishlist Name.");
              $("#Name").focus();
                return false;
            
        }
       
        if (data) {
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                    if(msg == "1")
                        {
                              alert("This Wishlist Name Already Exists.");
                               $("#Name").focus();
                               return false;
                        }
                     else if(msg == "0")
                        {
                              
                              //alert("Product Added Successfully In Your Wishlist.");
                               $.fancybox.close();
                              ShowHideLoader('1','S');
                              $("#wishListId").submit();  
                             
                              
                        }
                    }
                }); 
        }
  }); 
  
  
    $("#btnUpdateWishlist").click(function(){
      
    var Name = $.trim($("#Name").val());
   
    if(Name == "")
        {
            alert("Please Enter Your Wishlist Name.");
              $("#Name").focus();
                return false;
        }
        else
            {
                ShowHideLoader('1','S');
                return true;
            }
       
  }); 
  
  $("#addToWishlsit").click(function(){
      
      var radio_button_val = $("input[name='Wlid']:checked").val();
      var Wlid = radio_button_val;
      var WhislistProductId = $("#WhislistProductId").val();
      var data = '&Wlid=' + Wlid +'&ProductId='+ WhislistProductId +'&action=checkProductInWishlist';
      
      if (!radio_button_val) {
            alert('Please Select Your Wishlist.');
            return false;
         }
         else {
                   if (data) {
                            $.ajax({
                                type: "POST",
                                url: "e_ajax.php",
                                data: data,
                                success: function (msg) {
                                    if(msg == "1")
                                        {
                                              alert("This Product Already In Your Wishlist.");
                                               return false;
                                        }
                                    
                                        else
                                            {
                                                //alert("Product Added Successfully In Your Wishlist.");
                                                 $.fancybox.close();
                                                 ShowHideLoader('1','S');
                                                $("#wishListFormId").submit();    
                                            }
                                    }
                                }); 
                        }
                      
                       
         }


      
  });
  
  
  $(".removeWishlist").click(function(){
      
      var StrVal = $(this).attr('alt');
      var StrValSplit = StrVal.split("#");
      var Wlid = StrValSplit[0];
      var Cid = StrValSplit[1];
     if(Wlid != "" && Cid != "")
         {
             var rConfirm = confirm("Are You Sure To Delete This Wishlist.");
             if(rConfirm == true)
                 {
                     window.location = 'myWishlist.php?action=manage_wishlist&Wlid='+ Wlid + '&Cid=' +Cid;
                 }
                 else
                     {
                         return false;
                     }
             
         }
      
  });
  
  
    $(".removeWishlistProduct").click(function(){
      
      var StrVal = $(this).attr('alt');
      var StrValSplit = StrVal.split("#");
      var Wlpid = StrValSplit[0];
      var WID = StrValSplit[1];
     if(Wlpid != "" && WID != "")
         {
             var rConfirm = confirm("Are You Sure To Delete This Product From Wishlist.");
             if(rConfirm == true)
                 {
                     window.location = 'myWishlist.php?Wlpid='+ Wlpid + '&WID=' +WID;
                 }
                 else
                     {
                         return false;
                     }
             
         }
      
  });
  
  $("#btnEmailWishlist").click(function(){
      
       var mail_subject = $.trim($("#mail_subject").val());
       var your_email = $.trim($("#your_email").val());
        var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
       
       if(mail_subject == "")
           {
               alert("Please Enter Subject");
               $("#mail_subject").focus();
               return false;
               
           }
           
           if(your_email == "")
           {
               alert("Please Enter Email Address");
               $("#your_email").focus();
               return false;
               
           } 
           
           if(!emailRegister.test(your_email))
           {
               alert("Please Enter Valid Email Address");
               $("#your_email").focus();
               return false;
               
           } 
           
      ShowHideLoader('1','P');
      
  });
  
  $("#btnSubcribe").click(function(){
      
        var Email = $.trim($("#SubCriberEmail").val());
        var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
         var data = '&Email=' + Email +'&action=checkSubcribeEmail';
         if(Email == "")
           {
               alert("Please Enter Email Address");
               $("#Email").focus();
               return false;
               
           } 
           
           if(!emailRegister.test(Email))
           {
               alert("Please Enter Valid Email Address");
               $("#Email").focus();
               return false;
               
           } 
           
           if (data) {
                            $.ajax({
                                type: "POST",
                                url: "e_ajax.php",
                                data: data,
                                success: function (msg) { 
                                    if(msg == "1")
                                        {
                                              alert("It Already Exists In Our Newsletter Subscribers List.");
                                               return false;
                                        }
                                    
                                        else
                                            { 
                                                ShowHideLoader('1','P');
                                                $("#SubscribeForm").submit();    
                                            }
                                    }
                                }); 
                        }
      
  });
  
  $("#UpdateMyProfile").click(function(){
            var FirstName = $.trim($("#FirstName").val());
            var LastName = $.trim($("#LastName").val());
            var Phone = $.trim($("#Phone").val());
            var Address1 = $.trim($("#Address1").val());
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
            if(Phone == "")
            {
                alert("Please Enter Phone Number");
                $("#Phone").focus();
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
           if(Phone == "")
            {
                alert("Please Enter Phone Number");
                $("#Phone").focus();
                return false;
            }
            
                 
                ShowHideLoader('1','S');
   
        });
        
         $("#ChangePassword").click(function(){
             
                    var Password = $.trim($("#Password").val());
                    var Con_Password = $.trim($("#Con_Password").val());
                    var PasswordLength = $.trim($("#Password").val()).length;
                    
                      if(Password == "")
                       {
                         alert("Please Enter Your Password.");
                         $("#Password").focus();
                         return false;
                       }
             
                     if(PasswordLength < 6)
                       {
                         alert("Password Should Be Minimum 6 Digits.");
                         $("#Password").focus();
                         return false;
                       }
                       
                       if(PasswordLength >= 31)
                       {
                         alert("Password Should Be Maximum 30 Digits.");
                         $("#Password").focus();
                         return false;
                       } 
                       
                    if(Password != Con_Password)
                       {
                            alert("Password And Confirm Password Should Be Same.");
                              $("#Con_Password").focus();
                              return false;
                       }
                    ShowHideLoader('1','S');
             
         });
        
       $("#SaveShippingAddress").click(function(){
           
            var AddressType = $.trim($("#AddressType").val());
            var Name = $.trim($("#Name").val());
            var Address1 = $.trim($("#Address1").val());
            var main_state_id = $.trim($("#main_state_id").val());
            var main_city_id = $.trim($("#main_city_id").val());
            var OtherState = $.trim($("#OtherState").val());
            var OtherCity = $.trim($("#OtherCity").val());
            var ZipCode = $.trim($("#Zip").val());
            var Phone = $.trim($("#Phone").val());
            
            if(AddressType == "")
            {
                alert("Please Select Address Type");
                $("#AddressType").focus();
                return false;
            }
            
            if(Name == "")
            {
                alert("Please Enter Name");
                $("#Name").focus();
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
                $("#Zip").focus();
                return false;
             }
             
            if(Phone == "")
             {
                alert("Please Enter Phone Number");
                $("#Phone").focus();
                return false;
             }
             
             ShowHideLoader('1','S');
           
       }); 
       
     $(".DeleteShippingAddress").click(function(){
           
           var StrUser = $(this).attr('alt');
           var SplitStrUser = StrUser.split("#"); 
           var Csid = SplitStrUser[0];
           var Cid = SplitStrUser[1];
        
            var Strconfirm = confirm("Do you really want to delete select address?");
            if(Strconfirm == true)
              {
                  window.location.href = "addressBook.php?CustId="+ Cid +"&Csid="+ Csid +"&action=delete_address";
              }
       
        });
        
      
      $(".advaceSearch").click(function(){
          
          ShowHideLoader('1','F');
          
      });
       
  $("#applyPromo").click(function(){
     var promo_code = $("#promo_code").val();
     var Cid = $("#Cid").val();
     var cartSubTotal = $("#cartSubTotal").val();
     
      if(promo_code == "")
          {
              alert("Please Eneter Coupon Code.");
              $("#promo_code").focus();
              return false;
          }
       
        var data = '&Cid=' + Cid +'&promo_code='+promo_code+'&cartSubTotal='+cartSubTotal+'&action=checkPromoCode';
     
        if (data) {
            $.ajax({
                type: "POST",
                url: "e_ajax.php",
                data: data,
                success: function (msg) {
                   
                 window.location.href = msg;
                }
            });
        }
          
     
      
  });
 
});



  function keyup(me)
    {
        if(isNaN(me.value))
        {
            me.value="";
        }
    }
    
   setTimeout(function() {
    $('.successMsg').fadeOut('fast');
}, 10000);

 setTimeout(function() {
    $('.warningMsg').fadeOut('fast');
}, 10000);


function validateProductQuantity(frm){

        if(document.getElementById('Quantity').value == 0)
            {
                alert("Please Enter Valid Product Quantity.");
                document.getElementById('Quantity').focus();
                return false;
            }
 

	 if(parseInt(document.getElementById('Quantity').value) > parseInt(document.getElementById('AvailableQuantity').value)){
             if(document.getElementById('InventoryControl').value == "Yes")
                {
                    alert("Sorry, Only "+document.getElementById('AvailableQuantity').value+" Items Are Available For This Product.");
                    document.getElementById('Quantity').select();
                    return false;
               }
	}

	 ShowHideLoader('1','A');
}

function validateCart(frm){

	if(frm.numCart.value > 0 ){
             
		var flag = true;
               
		for(var i=1; i<=frm.numCart.value; i++){
                  
			if( ValidateMandNumField(document.getElementById('Quantity'+i), BLANK_QUANTITY,VALID_QUANTITY)
			){  
				if(parseInt(document.getElementById('Quantity'+i).value) > parseInt(document.getElementById('AvailableQuantity'+i).value)){
                                    if(document.getElementById('InventoryControl'+i).value == "Yes")
                                        {
                                            alert("Sorry, only "+ document.getElementById('AvailableQuantity'+i).value +" items are available for this product.");
                                            document.getElementById('Quantity'+i).select();
                                            flag = false;
                                            break;
                                        }
				}else{
					flag = true;
				}
			}else{
				flag = false;
				break;
			}
		}

		if(flag == false){
                    
			return false;	
		}
	}
        
        ShowHideLoader('1','P');
}