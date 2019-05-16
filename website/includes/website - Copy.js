     $(document).ready(function(){

                $("#ToEmail").change(function(){
                    var Str = $(this).val();
                    if(Str == "selectedSubscriber")
                    {
                        $("#subscribeUserLists").show(1000);
                    }
                    if(Str == "allSubscriber")
                    {
                        $("#subscribeUserLists").hide(1000);
                    }

                });


                $('#save_template').click(function () {
                    $("#template_box").toggle(1000);
                });


                $(".chrEmail").hide();
                $(".chr").click(function() {
                    $(".chrEmail").hide();
                    $(".chr").removeClass("active");
                    $(this).addClass("active");
                    $(this).next(".chrEmail").show();
                    ShowHideLoader('1','F');
                    var divLength = $(this).next(".chrEmail").html().length;
                    var chrcode = $(this).text(); 
                    var data = '&chrcode=' + chrcode +'&action=getSubscriber';
                    if(divLength == "0")
                    { 
                        $.ajax({
                            type: "POST",
                            url: "e_ajax.php",
                            data: data,
                            success: function (msg) {
                                if(msg != "")
                                {    
                                    $("#chr_"+chrcode).html(msg);
                                    ShowHideLoader('');
                                }
                                else
                                {
                                    $("#chr_"+chrcode).html('No Subscriber Found!.');  

                                    ShowHideLoader('');
                                }
                            }
                        });


                    }
                    else{
                        ShowHideLoader('');
                    }

                });


                $("#Previous_Template").change(function(){

                    var TemplateId = $(this).val();
                    window.location.href = 'emailNewsletter.php?template_id='+TemplateId;
                /*var data = '&TemplateId=' + TemplateId +'&action=getNewsletterTemplate';
                    if(data)
                        { 
                            $.ajax({
                                type: "POST",
                                url: "e_ajax.php",
                                data: data,
                                success: function (msg) {
                                  if(msg != "")
                                   {
                                       var strContent = msg.split("##"); 
                                   }   
                                   if(strContent[0] != "")
                                    {    
                                      $("#Subject").val(strContent[0]);
                                    }
                                    if(strContent[1] != "")
                                    {   
                                       tinyMCE.activeEditor.setContent(strContent[1]);



                                    }

                               }
                             });


                        }*/

                });

                $("#UpdateSubscriber").click(function(){    
                    var Email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
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
                    
                    ShowHideLoader('1','S');

                }); 

                $("#UpdateNewsletterTemplate").click(function(){    

                    var Template_Subject = $.trim($("#Template_Subject").val());
                    var Template_Name = $.trim($("#Template_Name").val());


                    if(Template_Name == "")
                    {
                        alert("Please Enter Template Name");
                        $("#Template_Name").focus();
                        return false;

                    } 

                    if(Template_Subject == "")
                    {
                        alert("Please Enter Template Subject");
                        $("#Template_Subject").focus();
                        return false;

                    } 

                    ShowHideLoader('1','S');

                });  



                $("#SubmitTax").click(function(){

                    var RateDescription = $.trim($("#RateDescription").val());
                    var TaxRate = $.trim($("#TaxRate").val());


                    if(RateDescription == "")
                    {
                        alert("Please Enter Tax Name");
                        $("#RateDescription").focus();
                        return false;
                    }

                    if(TaxRate == "")
                    {
                        alert("Please Enter Tax Rate");
                        $("#TaxRate").focus();
                        return false;
                    }

                    ShowHideLoader('1','S');
                });

                $("#SubmitClass").click(function(){

                    var ClassName = $.trim($("#ClassName").val());


                    if(ClassName == "")
                    {
                        alert("Please Enter Class Name");
                        $("#ClassName").focus();
                        return false;
                    }

                    var data = '&ClassName=' + ClassName +'&action=checkTaxClass';
                    if(data)
                    { 
                        $.ajax({
                            type: "POST",
                            url: "e_ajax.php",
                            data: data,
                            success: function (msg) {
                                if(msg == "Yes")
                                {
                                    alert("Tax Class Already Exists");
                                    $("#ClassName").focus();
                                    return false;
                                }   

                                else{
                                     ShowHideLoader('1','S');
                                    $("#taxClassForm").submit();
                                }

                            }
                        });


                    }


                   


                });




                $("#SubmitPage").click(function(){

                    var Name = $.trim($("#Name").val());
                    


                    if(Name == "")
                    {
                        alert("Please Enter Page Name");
                        $("#Name").focus();
                        return false;
                    }

                   
                    
                    ShowHideLoader('1','S');

                });
				
				$("#SubmitCat").click(function(){

                    var Name = $.trim($("#Name").val());
                    


                    if(Name == "")
                    {
                        alert("Please Enter Category Name");
                        $("#Name").focus();
                        return false;
                    }

                   
                    
                    ShowHideLoader('1','S');

                });
				
                $("#UpdateCustomer").click(function(){
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

                    ShowHideLoader('1','S');
                });




                $("#SubmitManufacturer").click(function(){

                    var Mname = $.trim($("#Mname").val());
                    var Mcode = $.trim($("#Mcode").val());
                    var ext = $('#Image').val().split('.').pop().toLowerCase();
					var ImageName = $("#Image").val();

                    var data = '&Mcode=' + Mcode +'&action=checkManufacturer';

                    if(Mname == "")
                    {
                        alert("Please Enter Manufacturer Name.");
                        $("#Mname").focus();
                        return false;
                    }

                    if(Mcode == "")
                    {
                        alert("Please Enter Manufacturer Code.");
                        $("#Mcode").focus();
                        return false;
                    }

                    if(Mcode != "")
                    {
                        $.ajax({
                            type: "POST",
                            url: "e_ajax.php",
                            data: data,
                            success: function (msg) {
                                if(msg == "1")
                                {
                                    alert("Manufacturer Code Already Exists");
                                    $("#Mcode").focus();
                                    return false;
                                }

								else if(!ValidateImageUpload(ImageName, "Image")){
								   $("#Image").focus();
									 return false;
									} 
                                else
                                {
                                    $("#ManufacturerForm").submit();
                                    ShowHideLoader('1','S');
                                    return true;
                                }

                            }
                        });

                    }

                    
                });
				
				  $("#AddQuickManufacturer").click(function(){

                    var Mname = $.trim($("#Mname").val());
                    var Mcode = $.trim($("#Mcode").val());
                   
                    var data = '&Mcode=' + Mcode +'&action=checkManufacturer';

                    if(Mname == "")
                    {
                        alert("Please Enter Manufacturer Name.");
                        $("#Mname").focus();
                        return false;
                    }

                    if(Mcode == "")
                    {
                        alert("Please Enter Manufacturer Code.");
                        $("#Mcode").focus();
                        return false;
                    }

                    if(Mcode != "")
                    {
                        $.ajax({
                            type: "POST",
                            url: "e_ajax.php",
                            data: data,
                            success: function (msg) {
                                if(msg == "1")
                                {
                                    alert("Manufacturer Code Already Exists");
                                    $("#Mcode").focus();
                                    return false;
                                }

								
                                else
                                {
                                    $("#ManufacturerForm").submit();
                                    ShowHideLoader('1','S');
                                    return true;
                                }

                            }
                        });

                    }

                    
                });

                $("#UpdateManufacturer").click(function(){

                    var Mname = $.trim($("#Mname").val());
                    var ext = $('#Image').val().split('.').pop().toLowerCase();
					var ImageName = $("#Image").val();

                    if(Mname == "")
                    {
                        alert("Please Enter Manufacturer Name.");
                        $("#Mname").focus();
                        return false;
                    }

                  	if(!ValidateImageUpload(ImageName, "Image")){
					   $("#Image").focus();
						 return false;
					} 

                    else
                    {
                        $("#ManufacturerForm").submit();
                        ShowHideLoader('1','S');
                        return true;
                    }

                    


                });


                $(".readDescription").hover(function(){   

                    var readDescriptionId = $(this).attr('alt');
                    $("#showReview_"+readDescriptionId).slideToggle();


                });

                $("#SubmitShippingRate").click(function(){

                    var RateMin = $.trim($("#RateMin").val());
                    var RateMax = $.trim($("#RateMax").val());
                    var Price = $.trim($("#Price").val());


                    if(RateMin == "")
                    {
                        alert("Please Enter Min Range");
                        $("#RateMin").focus();
                        return false;
                    }

                    if(RateMin <= "0.0000001")
                    {
                        alert("Min Range Should Be Greater Than 0");
                        $("#RateMin").focus();
                        return false;
                    }
                    if(RateMax == "")
                    {
                        alert("Please Enter Max Range");
                        $("#RateMax").focus();
                        return false;
                    }

                    if(Price == "")
                    {
                        alert("Please Enter Price");
                        $("#Price").focus();
                        return false;
                    }
                    
                    ShowHideLoader('1','S');

                });

                $(".deleteShippingRate").click(function(){

                    var proVal = $(this).attr('alt');
                    var SplitVal = proVal.split("#")
                    var Ssid = SplitVal[0];
                    var Srid = SplitVal[1];
                    var MethodId = $("#MethodId").val();

                    if(confirm("Are You Sure You Want To Delete This ?"))
                    {
                        var data = '&Ssid=' + Ssid +  '&Srid=' + Srid +'&MethodId=' + MethodId +'&action=deleteShippingRate';

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
                    }
                    else{
                        return false;
                    }


                });

                $("#SubmitShipping").click(function(){

                    var CarrierName = $.trim($("#CarrierName").val());
                    var MethodId = $.trim($("#MethodId").val());


                    if(CarrierName == "")
                    {
                        alert("Please Enter Carrier Name");
                        $("#CarrierName").focus();
                        return false;
                    }

                    if(MethodId == "")
                    {
                        alert("Please Select Calculation Method");
                        $("#MethodId").focus();
                        return false;
                    }

                    ShowHideLoader('1','S');
                });

                $("#UpdateShipping").click(function(){

                    var CarrierName = $.trim($("#CarrierName").val());

                    if(CarrierName == "")
                    {
                        alert("Please Enter Carrier Name");
                        $("#CarrierName").focus();
                        return false;
                    }
                    
                    ShowHideLoader('1','S');
                });


                $("#addCategory").click(function(){

                    var Name = $.trim($("#Name").val());
					var ImageName = $("#Image").val();

                    if(Name == "")
                    {
                        alert("Please Enter Category Name");
                        $("#Name").focus();
                        return false;
                    }
					if(!ValidateImageUpload(ImageName, "Image")){
					        $("#Image").focus();
							  return false;
					}
                    
                    ShowHideLoader('1','S');

                });



                $("#SaveCartSettings_1").click(function(){

                    var StoreName = $.trim($("#StoreName").val());
                    var CompanyEmail = $.trim($("#CompanyEmail").val());
                    var StoreNotificationEmail = $.trim($("#NotificationEmail").val());
                    var StoreSupportEmail = $.trim($("#SupportEmail").val());

                    if(StoreName == "")
                    {
                        alert("Please Enter Store Name");
                        $("#StoreName").focus();
                        return false;
                    }

                    if(CompanyEmail == "")
                    {
                        alert("Please Enter Company Email");
                        $("#CompanyEmail").focus();
                        return false;
                    }
                    if(StoreNotificationEmail == "")
                    {
                        alert("Please Enter Store Notification Email");
                        $("#StoreNotificationEmail").focus();
                        return false;
                    }

                    if(StoreSupportEmail == "")
                    {
                        alert("Please Enter Store Support Email");
                        $("#StoreSupportEmail").focus();
                        return false;
                    }

                    ShowHideLoader('1','S');
                });
                
                
                $("#SaveCartSettings_2").click(function(){
                        ShowHideLoader('1','S');
                });
                
                $("#SaveCartSettings_3").click(function(){
                        ShowHideLoader('1','S');
                });
                
                $("#saveOrderdata").click(function(){
                        ShowHideLoader('1','S');
                });
                
                
                $("#btnActivatePayment").click(function(){
                    
                    var payment_method_id_dropdown = $("#payment_method_id_dropdown").val();
                    var checkPayment = payment_method_id_dropdown.split('##');
                    var checkPaymentActive = checkPayment[1];
                    var  PaymentId = checkPayment[0];
                  
                    if(payment_method_id_dropdown == "")
                        {
                            alert("Please Choose Your Payment Method.");
                            $("#payment_method_id_dropdown").focus();
                            return false;
                        }
                    else if(checkPaymentActive == "Yes")
                        {
                             alert("You Have Already Configured This Payment Method.");
                             $("#payment_method_id_dropdown").focus();
                             return false;
                        }
                        else{
                            ShowHideLoader('1','P');
                            window.location.href = 'editPayment.php?paymentId='+PaymentId;
                        }
                  
                });
                
                $("#UpdatePaymentSettings").click(function(){
                   
                   var PaymentID = $("#PaymentID").val();
                  
                   
                   if(PaymentID == "paypalipn")
                       {
                           
                           var PaymentMethodName = $("#PaymentMethodName").val();
                           var PaymentMethodTitle = $("#PaymentMethodTitle").val();
                           var paypalipn_business = $("#paypalipn_business").val();
                           
                           if(PaymentMethodName == "")
                            {
                                alert("Please Enter Payment Method Name.");
                                $("#PaymentMethodName").focus();
                                return false;
                            }
                            if(PaymentMethodTitle == "")
                            {
                                alert("Please Enter Payment Method Title.");
                                $("#PaymentMethodTitle").focus();
                                return false;
                            }
                            if(paypalipn_business == "")
                            {
                                alert("Please Enter Business Email Address.");
                                $("#paypalipn_business").focus();
                                return false;
                            }
                       }
                    ShowHideLoader('1','S');
                });
                
                
                 $("#SaveCoupon").click(function(){
                
                    var Name = $("#Name").val();
                    var PromoCode = $("#PromoCode").val();
                    var DateStart = $("#DateStart").val();
                    var DateStop = $("#DateStop").val();
                    var Discount = $("#Discount").val();
                    
                     if(Name == "")
                        {
                            alert("Please Enter Campaign Name.");
                            $("#Name").focus();
                            return false;
                        }
                        if(PromoCode == "")
                        {
                            alert("Please Enter Coupon Code.");
                            $("#PromoCode").focus();
                            return false;
                        }
                       
                       var data = '&PromoCode=' + PromoCode +'&action=checkPromoCode';
                        if(data)
                        { 
                            $.ajax({
                                type: "POST",
                                url: "e_ajax.php",
                                data: data,
                                success: function (msg) {
                                    if(msg == "Yes")
                                    {
                                        alert("Coupon Code is Already in Use!");
                                        $("#PromoCode").focus();
                                        return false;
                                    }  
                                    
                                    if(DateStart == "")
                                    {
                                        alert("Please Select Start Date.");
                                        $("#DateStart").focus();
                                        return false;
                                    }
                                    if(DateStop == "")
                                    {
                                        alert("Please Select End Date.");
                                        $("#DateStop").focus();
                                        return false;
                                    }
                                    if(Discount == "")
                                    {
                                        alert("Please Enter Discount.");
                                        $("#Discount").focus();
                                        return false;
                                    }

                                    else{
                                        ShowHideLoader('1','S');
                                        $("#PromoCodeForm").submit();
                                    }

                                }
                            });


                        }
                        
                      
                         
                
                });
                
                $("#SaveCustomerGroup").click(function(){

                    var GroupName = $.trim($("#GroupName").val());


                    if(GroupName == "")
                    {
                        alert("Please Enter Group Name");
                        $("#GroupName").focus();
                        return false;
                    }

                    var data = '&GroupName=' + GroupName +'&action=checkCustomerGroupName';
                    if(data)
                    { 
                        $.ajax({
                            type: "POST",
                            url: "e_ajax.php",
                            data: data,
                            success: function (msg) {
                                if(msg == "Yes")
                                {
                                    alert("Customer Group Already Exists");
                                    $("#GroupName").focus();
                                    return false;
                                }   

                                else{
                                    ShowHideLoader('1','S');
                                    $("#customerGroupForm").submit();
                                }

                            }
                        });


                    }


                    


                });
                
                 $("#UpdateCustomerGroup").click(function(){

                    var GroupName = $.trim($("#GroupName").val());
                    
                    if(GroupName == "")
                    {
                        alert("Please Enter Group Name");
                        $("#GroupName").focus();
                        return false;
                    }

                });
                
          
                $("#SaveGlobalAttribute").click(function(){
    
                        var attname = $.trim($("#attname").val());
                        //var caption = $.trim($("#caption").val());
                        var options = $.trim($("#options").val());

                        if(attname == "")
                        {
                            alert("Please Enter Attribute Name");
                            $("#attname").focus();
                            return false;
                        }

                     /* if(caption == "")
                        {
                            alert("Please Enter attribute caption");
                            $("#caption").focus();
                            return false;
                        }*/
                        if(options == "")
                        {
                            alert("Please Enter Attribute Options");
                            $("#options").focus();
                            return false;
                        }

                   });

            });

            function checkSubcriber()
            {

                var Str = document.getElementById('ToEmail').value;
                if(Str == "selectedSubscriber")
                {
                    $("#subscribeUserLists").show(1000);
                }
                if(Str == "allSubscriber")
                {
                    $("#subscribeUserLists").hide(1000);
                }
            }


            function ValidateForm(frm)
            {
                var Subject = $("#Subject").val();
                var Name = $("#Name").val();
                var From_Email = $.trim($("#From_Email").val());
                var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var isChecked = $('#save_template').is(':checked');

                if(Subject == "")
                {
                    alert("Please Enter Email Subject!");
                    $("#Subject").focus();
                    return false;

                } 

                if(Name == "")
                {
                    alert("Please Enter From Name!");
                    $("#Name").focus();
                    return false;

                } 

                if(From_Email == "")
                {
                    alert("Please Enter Email Address");
                    $("#From_Email").focus();
                    return false;

                } 

                if(!emailRegister.test(From_Email))
                {
                    alert("Please Enter Valid Email Address");
                    $("#From_Email").focus();
                    return false;

                } 

            /*if (!ew_ValidateFormNewsletter(frm,"Html_Content","Content for Email"))
                    {
                        return false;
                    }

                    if((isChecked == true) && ($("#Template_Name").val() == ""))
                        {
                             alert("Please Enter Template Name.");
                              $("#Template_Name").focus();
                              return false;
                        }*/
                ShowHideLoader('1','S');

            }

            function keyup(me)
            {
                if(isNaN(me.value))
                {
                    me.value="";
                }
            }
            
    function checkNumber(number){
    //check numbers in 123,123,122.23 or 123123123.123 or 123,123,123 or 123123123 format
    var rex = /^((\d{1,3},)?(\d{3},)?(\d{3})|(\d{1,}))((\.(\d{1,}))?)$/;
    return rex.test(number);
    }    
 
function CheckDiscountsForm(frm){
    
	var prex1 = /^min_values\[(\w{1,100})\]$/;
	var prex2 = /^max_values\[(\w{1,100})\]$/;
	var prex3 = /^discounts\[(\w{1,100})\]$/;
        var error_num = 
		"Accepted values are\n"+
		"numbers with (or without) period comma separators\n"+
		"and with . (dot) decimal separator. Examples:\n"+
		"12,199.90; 12.23; 8900; 23,179";
     	
	for(i=0; i<frm.elements.length; i++){
		if(prex1.test(frm.elements[i].name)){
			if(!checkNumber(frm.elements[i].value)){
				alert("Please enter valid min amount! " + error_num);
				frm.elements[i].focus();
				return false;
			}
		}
		if(prex2.test(frm.elements[i].name)){
			if(!checkNumber(frm.elements[i].value)){
				alert("Please enter valid max amount! " + error_num);
				frm.elements[i].focus();
				return false;
			}
		}
		if(prex3.test(frm.elements[i].name)){
			if(!checkNumber(frm.elements[i].value)){
				alert("Please enter valid discount! " + error_num);
				frm.elements[i].focus();
				return false;
			}
		}
	}
	return true;
}        



//promo code js
$(document).ready(function() {
	$("#searchStr").autocomplete({
		source: function(request, response) {
			$.ajax({
				url: 'auto_search_product.php',
				dataType: 'json',
				data: {
					q: request.term,
					l: '10'
				},
				success: function(data) {
                                    
					response($.map(data, function(item) {
						return {
							label: item.ProductSku + ' - ' + item.Name,
							value: item.ProductID
						}
					}));
				}
			});
		},
		select: function(event, ui) {
			if (ui.item) {
				addProduct(ui.item.value, ui.item.label);
			}
			event.preventDefault();
			event.stopPropagation();
		}
	});
});

function addProduct(pid, title){
	var s = document.getElementById('select_products');
	if(s){
		code = pid;
		exists = false;
		for(i=0; i < s.options.length; i++){
			var _pid = s.options[i].value;
			if(_pid.substring(0, pid.length) == pid){
				exists = i+1;
				break;
			}
		}
		var nm = title;
		if(exists){
			alert("This Product Is Already In The List.");
			s.options[exists-1] = new Option(nm, code);
			return false;
		}
		else{
			var k = s.options.length;
			s.options[k] = new Option(nm, code);
		}
	}
}

function removeProducts(){
	var s = document.getElementById('select_products');
	var a = Array();
	var isSelected = false;
	for(i = 0; i<s.options.length; i++){
		if(!s.options[i].selected){
			a[a.length] = s.options[i];
		}
		else{
			isSelected = true;
		}
	}
	if(isSelected && confirm("Do You Really Want To Remove Products?")){
		s.options.length = 0;
		for(i=0; i<a.length; i++){
			s.options[s.length] = a[i];
		}
	}
}

function CheckPromoForm(frm){
	var pg = document.getElementById("select_products");
	if(pg){
		var s = "";
		for(i = 0; i < pg.options.length; i++){
			if(i > 0)
				s = s + ",";
			s = s + pg.options[i].value ;
		}
		frm.elements["promo_products"].value = s;
	}
	return true;
}

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for( var i=0; i < 6; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
        document.getElementById('PromoCode').value=text;
    //return text;
}
//end promo code js
function ValidateImageUpload(p_Field,p_FieldName){
		 
		if(p_Field !=''){
			var FileExtension = p_Field.substr(p_Field.length-3,p_Field.length);
			switch(FileExtension.toLowerCase()){
			case 'jpg':
			return true;
			case 'gif':
			return true;
			case 'png':
			return true;
			default:
			alert('Only following filetypes are supported:\n1) jpg\n2) gif\n3) png');
			//p_Field.select();
			return false;
			}
			}else{
			return true;
			}
	}