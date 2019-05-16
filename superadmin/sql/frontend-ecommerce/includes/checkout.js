jQuery(document).ready(function(){
	
	jQuery('.e-login').click(function(){
			var $this=		jQuery(this);
			$this.siblings('.e-loader').removeClass('hide');
		var emailrule=/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		var email	=jQuery('.login-panel .l-email').val();
		var password=jQuery('.login-panel .l-password').val();	
		
		if(email==''){
			alert('Please Enter Email');
		}else  if(!isValidEmail(email)){
			alert('Please Enter Valid Email');
		}else if(password==''){			
			alert('Please Enter Password');
		}else {
			
			jQuery.ajax({
				type:'POST',
				url:'ajax-checkout.php',
				data:{
				task:'login',
				email:email,
				password:password
				},
				success:function(data){
					
					var objdata=JSON.parse(data);
					console.log(objdata);	
					if(objdata.errorMsg == undefined || objdata.errorMsg=='' ){
						BillingDetail(objdata.userDetail);					
						step=2;
						currentstep=2;
						window.location='';
                        // ShippingDetail();
                                                
						// ShowSetp('billing');
					}else{
						
						alert(objdata.errorMsg);
					}
					$this.siblings('.e-loader').addClass('hide');
				}
				
			});
			
		}
	});
	jQuery('.e-billing-action').click(function(){
		
		var validation=BillingValidation();
		
		if(validation.Valid==false){
			alert('Please fill all required field');	
		}else{
			var $this=		jQuery(this);
			$this.siblings('.e-loader').removeClass('hide');
			if(jQuery('.ship-bill-address:checked').val()=='same'){ 
					ShippingDetail();	
					SaveAddress();
					
					
			}else{
                                        ShippingDetail();
					ShowSetp('shipping');
				
			}
			$this.siblings('.e-loader').addClass('hide');
			
		}
	});
	jQuery('.e-shipping-action').click(function(){
		var $this=		jQuery(this);
		$this.siblings('.e-loader').removeClass('hide');
		var validation=ShiipingValidation();
	
	
		if(validation.Valid==false){
			alert('Please fill all required field');	
		}else{	
			SaveAddress();
		}
		$this.siblings('.e-loader').addClass('hide');
	});
	
	jQuery('.e-shipping-method-action').click(function(){
		
		if(jQuery('.ship-method:checked').length==0){
			alert('Please select shipping method');	
		}else{	
			var $this=		jQuery(this);
			$this.siblings('.e-loader').removeClass('hide');
			 var request=jQuery.ajax({
				 type:'POST',
					url:'ajax-checkout.php',
					data:{
					task:'shippingmethod',
					method:jQuery('.ship-method:checked').val(),					
					},
					success:function(data){
						var html='';	
						var optionhtml='';
						var objdata=JSON.parse(data);
						console.log(objdata);
						if(objdata.paymentmethod != undefined && objdata.paymentmethod.length>0){
							for (var k in objdata.paymentmethod){
							html +='<div class="radio"><label><input type="radio" id="'+objdata.paymentmethod[k].PaymetMethodId+'" value="'+objdata.paymentmethod[k].PaymetMethodId+'" class="selectPaymentMethod"	name="payment_method" >'+objdata.paymentmethod[k].PaymentMethodTitle+'</label></div>';
							if(objdata.paymentmethod[k].PaymetMethodId=='cashondelivary'){
								optionhtml +='<div class="options-payemnt hide" data-payment="'+objdata.paymentmethod[k].PaymetMethodId+'"></div>';
							}else if(objdata.paymentmethod[k].PaymetMethodId=='paypalpro'){
								optionhtml +='<div class="options-payemnt hide" data-payment="'+objdata.paymentmethod[k].PaymetMethodId+'">';
								optionhtml +='<div class="form-group">';
								optionhtml +='<label>Card Type</label>';
								optionhtml +='<select class="form-control card-type"><option value="VISA">VISA</option><option value="MASTER">MASTER</option></select>';
								optionhtml +='</div>';								
								optionhtml +='<div class="form-group">';
								optionhtml +='<label>Card Number</label>';
								optionhtml +='<input type="text" class="form-control card-number">';
								optionhtml +='</div>';							
								optionhtml +='<div class="form-group">';
								optionhtml +='<label>exp. month</label>';
								optionhtml +='<select class="form-control card-exp-month"><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
								optionhtml +='</div>';
								optionhtml +='<div class="form-group">';
								optionhtml +='<label>exp. year</label>';
								optionhtml +='<select class="form-control card-exp-year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option></select>';
								optionhtml +='</div>';
								optionhtml +='<div class="form-group">';
								optionhtml +='<label>Card ccv.</label>';
								optionhtml +='<input type="text" class="form-control card-ccv">';
								optionhtml +='</div>';	
								optionhtml +='</div>';
								}else if(objdata.paymentmethod[k].PaymetMethodId=='paypalipn'){
									optionhtml +='<div class="options-payemnt hide" data-payment="'+objdata.paymentmethod[k].PaymetMethodId+'">';
									optionhtml +='</div>';
								}
							}
							jQuery('.all-payment-method').html(html);
							jQuery('.payment-option').html(optionhtml);
							
							html=orderconfirmHTML(objdata);
							jQuery('.table-confirm').html(html);
							
							
							ShowSetp('payment-method');			
						}
						$this.siblings('.e-loader').addClass('hide');
					
						}
				 
			 });
		}
	});
	
	jQuery('.e-payment-method-action').click(function(){
		
		if(jQuery('.selectPaymentMethod:checked').length==0){
			alert('Please select payment method');	
		}else{	
			var $this=		jQuery(this);
			$this.siblings('.e-loader').removeClass('hide');
			var optiondata={};
			if(jQuery('.selectPaymentMethod:checked').val()=='paypalpro'){
			optiondata.ct=jQuery('.card-type').val();
			optiondata.cn=jQuery('.card-number').val();
			optiondata.em=jQuery('.card-exp-month').val();
			optiondata.ey=jQuery('.card-exp-year').val();
			optiondata.cvv=jQuery('.card-ccv').val();
			}
			 var request=jQuery.ajax({
				 type:'POST',
					url:'ajax-checkout.php',
					data:{
					task:'paymentmethod',
					method:jQuery('.selectPaymentMethod:checked').val(),					
					optiondata:optiondata,
					},
					success:function(data){
						var html='';	
						var objdata=JSON.parse(data);
						
						if(objdata.errorMsg==undefined || objdata.errorMsg==''){
							if(jQuery('.selectPaymentMethod:checked').val()=='paypalipn'){
								window.location="payment_process.php";
								
							}else{
									window.location="completed.php?OrderID="+objdata.orderid+"&cid="+objdata.cid;
							}
						
						
						}else{
                                                 
							
							if(jQuery('.payment-option .error-payemnt').length==0){
								
								jQuery('.payment-option').prepend('<div class="error-payemnt">'+objdata.errordetail['L_LONGMESSAGE0']+'</div>');
							}else{
								
								jQuery('.error-payemnt').html(objdata.errordetail['L_LONGMESSAGE0']);
							}
						}
						ShowSetp('payment-method');		
					$this.siblings('.e-loader').addClass('hide');	
					}
				 
			 });
		}
		
	});
	
	
	jQuery('.guestlogin').click(function(){	
		var $this=		jQuery(this);
		$this.siblings('.e-loader').removeClass('hide');
			 var request=jQuery.ajax({
				 type:'POST',
					url:'ajax-checkout.php',
					data:{
					task:'guestLogin',									
					},
					success:function(data){
						var objdata=JSON.parse(data);
						console.log(objdata);	
						if(objdata.errorMsg == undefined || objdata.errorMsg=='' ){ 
							window.location='';
							BillingDetail(objdata.userDetail);					
							step=2;
							currentstep=2;
							
							ShowSetp('billing');						
						}else{
							
							alert(objdata.errorMsg);
						}
						$this.siblings('.e-loader').addClass('hide');
						}
				 
			 });
		
	});
	
	
	jQuery('body').on('click','.selectPaymentMethod',function(){
		var $this = jQuery(this);
		var val=jQuery(this).val();
		console.log(val+'--'+jQuery(this).data('payment'));
		jQuery('.payment-option .options-payemnt').each(function(){
			if(jQuery(this).data('payment')==val || jQuery(this).attr('data-payment')==val){				
				jQuery(this).removeClass('hide');
			}else{
				jQuery(this).addClass('hide');
			}
			
		});
		
	});
	
	jQuery('body').on('click','.confirm-action',function(){
		ShowSetp('confirm');
	// ShowSetp('billing');
	});
	
	
	
	
	function isValidEmail(thatemail) {		
		var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return re.test(thatemail);
	}
	
	function BillingValidation(){
		var valiVar={};
	
		var vali=true;
		var validationmessage={}
		valiVar.bFname=jQuery('.b-fname');
		valiVar.bLname=jQuery('.b-lname');	
		valiVar.baddress1=jQuery('.b-address1');
		//valiVar.bcountry=jQuery('#country_id');
		valiVar.bcountry=jQuery('.b-country');
		valiVar.bzip=jQuery('.b-zip');
		valiVar.bphone=jQuery('.b-phone');
		valiVar.bemail=jQuery('.b-email');
		
		for(var k in valiVar){
			
			if(valiVar[k].val()==''){
				vali=false;
				validationmessage[k]='Please Enter this field';
			}
			
		}
		
		var bstate=jQuery('#state_id').val();
		var bostate=jQuery('.b-o-state').val();
		var bcity=jQuery('#city_id').val();
		var bocity=jQuery('.b-o-city').val();
		
		valiVar.Valid=vali;		
		valiVar.validationmessage=validationmessage;
		return valiVar;
	}
	
	function ShiipingValidation(){
		var valiVar={};
	
		var vali=true;
		var validationmessage={}
                valiVar.cAddressType=jQuery('#AddressType');
		valiVar.cFname=jQuery('.c-fname');
		valiVar.cLname=jQuery('.c-lname');	
		valiVar.caddress1=jQuery('.c-address1');
		valiVar.ccountry=jQuery('#country_id_shipp');
		valiVar.czip=jQuery('.c-zip');
		valiVar.cphone=jQuery('.c-phone');
		valiVar.cemail=jQuery('.c-email');
		
		for(var k in valiVar){
			if(valiVar[k].val()==''){
				vali=false;
				validationmessage[k]='Please Enter this field';
			}
			
		}
		
		// var bstate=jQuery('#state_id').val();
		// var bostate=jQuery('.b-o-state').val();
		// var bcity=jQuery('#city_id').val();
		// var bocity=jQuery('.b-o-city').val();
		
		valiVar.Valid=vali;		
		valiVar.validationmessage=validationmessage;
		return valiVar;
	}
	
	function BillingDetail(data){		
		var fname=(typeof(data.FirstName)===undefined)?'':data.FirstName;
		var lname=(typeof(data.LastName)===undefined)?'':data.LastName;
		var address1=(typeof(data.Address1)===undefined)?'':data.Address1;
		var address2=(typeof(data.Address2)===undefined)?'':data.Address2;
		var City=(typeof(data.City)===undefined)?'':data.City;
		var oCity=(typeof(data.OtherCity)===undefined)?'':data.OtherCity;
		var Phone=(typeof(data.Phone)===undefined)?'':data.Phone;
		var ZipCode=(typeof(data.ZipCode)===undefined)?'':data.ZipCode;
		var Email=(typeof(data.Email)===undefined)?'':data.Email;
		var Country=(typeof(data.Country)===undefined)?'':data.Country;
		var State=(typeof(data.State)===undefined)?'':data.State;
		var City=(typeof(data.City)===undefined)?'':data.City;
		var OtherState=(typeof(data.OtherState)===undefined)?'':data.OtherState;
		var OtherCity=(typeof(data.OtherCity)===undefined)?'':data.OtherCity;
		var Company=(typeof(data.Company)===undefined)?'':data.Company;
		
		jQuery('.b-fname').val(fname);
		jQuery('.b-lname').val(lname);
		jQuery('.b-address1').val(address1);
		jQuery('.b-address2').val(address2);
		jQuery('.b-address2').val(address2);
		jQuery('#main_state_id').val(State);
		jQuery('#ajax_state_id').val(State);
		jQuery('#main_city_id').val(City);
		jQuery('#ajax_city_id').val(City);
		jQuery('#country_id').val(Country).trigger('change');	
		jQuery('.b-zip').val(ZipCode);
		jQuery('.b-phone').val(Phone);
		jQuery('.b-email').val(Email);
		jQuery('.b-o-state').val(OtherState);
		jQuery('.b-o-city').val(OtherCity);
		jQuery('.b-company').val(Company);
		// jQuery('#state_id').val(State).trigger('change');
		
	}
	function ShippingDetail(data){			
		jQuery('.c-fname').val(jQuery('.b-fname').val());
		jQuery('.c-lname').val(jQuery('.b-lname').val());
		jQuery('.c-address1').val(jQuery('.b-address1').val());
		jQuery('.c-address2').val(jQuery('.b-address2').val());
		jQuery('.c-address2').val(jQuery('.b-address2').val());
		jQuery('#main_state_id_shipp').val(jQuery('#main_state_id').val());	
		jQuery('#main_city_id_shipp').val(jQuery('#main_city_id').val());	
		jQuery('#country_id_shipp').val(jQuery('#country_id').val()).trigger('change');	
		jQuery('.c-zip').val(jQuery('.b-zip').val());
		jQuery('.c-phone').val(jQuery('.b-phone').val());
		jQuery('.c-email').val(jQuery('.b-email').val());
		jQuery('.c-o-state').val(jQuery('.b-o-state').val());
		jQuery('.c-o-city').val(jQuery('.b-o-city').val());
		jQuery('.c-company').val(jQuery('.b-company').val());
		
		// jQuery('#state_id').val(State).trigger('change');
		
	}
	
	
	function orderconfirmHTML(objdata){
		var html='';
		
		html+='<table class="table table-striped table-confirm"><thead> <tr><th>Item</th><th></th> <th>Qty</th><th>Price</th><th>Total</th></tr></thead>';
         
			html +='<tbody>';
			if(objdata.arryCart != undefined){			
				for (var k in objdata.arryCart){
					var Weight='';
					if(objdata.arryCart[k].Weight>0) Weight='<span>Weight(lbs):</span> '+objdata.arryCart[k].Weight;
					 html +='<tr><td>'+objdata.arryCart[k].Name+'<br>'+Weight+'<br>'+objdata.variantdata[k].Name+'</td><td>'+objdata.arryCart[k].DiplayAttribute+'</td><td>'+objdata.arryCart[k].Quantity+'</td><td>'+objdata.arryCart[k].ProductDisplayPrice+'</td><td>'+objdata.arryCart[k].ProductDisplayTotalPrice+'</td></tr>';
				}
			}
			
           html +='</tbody>';
           html +='</table><hr>';     
           html +='<dl class="dl-horizontal pull-right">';
           html +='<dt>Sub-total:</dt>';
           html +='<dd>'+objdata.orderdata.SubTotalPrice+'</dd>';
           html +='<dt>Shipping Cost:</dt>';
           html +='<dd>'+objdata.orderdata.Shipping+'</dd>';
           html +='<dt>Tax Charge:</dt>';
           html +='<dd>'+objdata.orderdata.TaxAmount+'</dd>';
           if(objdata.orderdata.discountAmount != undefined ){        	   
        	   html +='<dt>Discount:</dt>';
               html +='<dd>'+objdata.orderdata.discountAmount+'</dd>';
           }
           html +='<dt>Total:</dt>';
           html +='<dd>'+objdata.orderdata.TotalPrice+'</dd>';
           html +='</dl>';
           html +='<div class="clearfix"></div>';
		return html;
	}
	
	function SaveAddress(){
		var addressdata={};
		 
          addressdata.FirstName		=	jQuery('.b-fname').val();	
		  addressdata.LastName		=	jQuery('.b-lname').val();
		  addressdata.Address1		= 	jQuery('.b-address1').val();		
		  addressdata.Address2		=	jQuery('.b-address2').val();
		  addressdata.main_state_id	=	jQuery('#main_state_id').val();	
		  addressdata.main_city_id	=	jQuery('#main_city_id').val();
		  addressdata.Country		=	jQuery('#country_id').val();	
		  addressdata.ZipCode		=	jQuery('.b-zip').val();		
		  addressdata.Phone			=	jQuery('.b-phone').val();
		  addressdata.Email			=	jQuery('.b-email').val();		
		  addressdata.OtherState	=	jQuery('.b-o-state').val();		
		  addressdata.OtherCity		=	jQuery('.b-o-city').val();		
		  addressdata.Company		=	jQuery('.b-company').val();		
		  addressdata.DelivaryDate	=	jQuery('#DelivaryDate').val();	
		  addressdata.AddressType	=	'Residential';
			
		  addressdata.ShippingName			=	jQuery('.c-fname').val()+' '+jQuery('.c-lname').val(); 		
		  addressdata.ShippingAddress1		=	jQuery('.c-address1').val();
		  addressdata.ShippingAddress2		=	jQuery('.c-address2').val();		
		  addressdata.main_state_id_shipp	=	jQuery('#main_state_id_shipp').val();	
		  addressdata.main_city_id_shipp	=	jQuery('#main_city_id_shipp').val();
		  addressdata.country_id_shipp		=	jQuery('#country_id_shipp').val();	
		  addressdata.ShippingZip			=	jQuery('.c-zip').val();
		  addressdata.ShippingPhone		=	jQuery('.c-phone').val();			
		  addressdata.OtherState_shipp		=	jQuery('.c-o-state').val();
		  addressdata.ShippingCompany		=	jQuery('.c-company').val();
		  addressdata.OtherCity_shipp		=	jQuery('.c-o-city').val();
		  if(jQuery('#add_to_address_book' ).is(":checked")){
			  addressdata.add_to_address_book		=	jQuery('#add_to_address_book').val();
			}else{
				addressdata.add_to_address_book		=	'No';
			}
		  
		  addressdata.shipping_address_id		=	jQuery('input:radio[name=shipping_address_id]:checked').val();  
          
		var request=jQuery.ajax({
			type:'POST',
			url:'ajax-checkout.php',
			data:{
			task:'saveAddress',
			addressdata:addressdata,			
			},
			success:function(data){
				var html='';
				var objdata=JSON.parse(data);
				console.log(objdata);
				if(objdata.Shippingmethod != undefined){
				for (var k in objdata.Shippingmethod){					
					html +='<div class="radio">';
					html +='<label><input type="radio" class="ship-method" name="optionsRadios" id="optionsRadios1" value="'+objdata.Shippingmethod[k]['Ssid']+'" checked="">';
					html +=objdata.Shippingmethod[k]['CarrierName']+' '+objdata.Shippingmethod[k]['Fee'];
					html +='</label></div>';
					console.log(objdata.Shippingmethod[k]);
				}
					
				}
				jQuery('.all-shipping-method').html(html);
				ShowSetp('shipping-method');			
			}
		});
		
	}
	
	function ShowSetp(step){
	var step=(typeof(step)==='undefined')?'login':step;
	jQuery('.'+step+'-panel').find('.panel-title a.accordion-toggle.hide').trigger('click');
		
	}
});
