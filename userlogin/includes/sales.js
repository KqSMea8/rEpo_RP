     $(document).ready(function(){   	       		



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
	
	function ChangeShipaddress(ShipId){
		var SendUrl = "&action=shippAddress&ShipId="+ShipId;
		
		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			dataType : "JSON",
			success: function (responseText) {
			
			  $("#ShippingName").val(responseText["FullName"]);
			  $("#ShippingCompany").val(responseText["Company"]);
			  $("#ShippingAddress").val(responseText["Address"]);
			  
			  $("#ShippingCity").val(responseText["CityName"] );
			  
			  $("#ShippingState").val(responseText["StateName"] );
			  $("#ShippingCountry").val(responseText["CountryName"] );
			  $("#ShippingZipCode").val( responseText["ZipCode"]);
			  
			  $("#ShippingMobile").val(responseText["Mobile"] );
			  $("#ShippingLandline").val(responseText["Landline"] );
			  $("#ShippingFax").val(responseText["Fax"] );
			  $("#ShippingEmail").val(responseText["Email"]);
			}

		   });
		
	}

	

            
