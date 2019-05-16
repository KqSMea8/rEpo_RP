     $(document).ready(function(){   	       		



		//Code for same billing and shipping
				
				 $("#sameBilling").click(function(){
				 
				       if($("#sameBilling").prop('checked') == true)
					    {
						  $("#ShippingName").val($("#CustomerName").val());
						  $("#ShippingCompany").val($("#CustomerCompany").val());
						  $("#ShippingAddress").val($("#Address").val());
							$("#ShippingCountry").val($("#Country").val());
							$("#ShippingCountryName").val($("#CountryName").val());
							loadState($("#CountryName").val(),$("#StateName").val());
							$("#ShippingState").val($("#State").val());
							loadCity($("#StateName").val(),$("#CityName").val());
							$("#ShippingCity").val($("#City").val());
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












		$( "#PaidAmount" ).keyup(function() {
		var PaidAmount = $("#PaidAmount").val();
			var TotalPaidAmount = $("#TotalPaidAmount").val();
			if(parseFloat(PaidAmount) > parseFloat(TotalPaidAmount)){
			 alert("Please Pay Only "+TotalPaidAmount);
			 return false;
			 
			}else{
				var DiffAmnt = parseFloat(TotalPaidAmount) - parseFloat(PaidAmount);
				DiffAmnt = Math.round(DiffAmnt);
				$("#DiffAmount").html(DiffAmnt);
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

	

            
