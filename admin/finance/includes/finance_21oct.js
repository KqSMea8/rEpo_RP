   $(document).ready(function(){

	$("#ReceivedAmount" ).keyup(function() {
		var ReceivedAmount = $("#ReceivedAmount").val();
		var TotalPaidAmount = $("#TotalPaidAmount").val();
		if(parseFloat(ReceivedAmount) > parseFloat(TotalPaidAmount)){
		alert("Please Pay Only "+TotalPaidAmount);
		return false;

		}else{
		var DiffAmnt = parseFloat(TotalPaidAmount) - parseFloat(ReceivedAmount);
		DiffAmnt = Math.round(DiffAmnt);
		$("#DiffAmount").html(DiffAmnt);
		}

		});
	
//Code for Tax Calculation
	
    $("#TaxRateDesc").change(function(){
		
		var TaxRateVal = $(this).val();
		var TaxRateSplit = TaxRateVal.split(":");
		$("#TaxID").val(TaxRateSplit[0]);
		$("#TaxRate").val(TaxRateSplit[1]);
		var Amount = $("#Amount").val();
		if(TaxRateSplit[0] > 0 && Amount >0){
		 $("#totalAmnt").show(1000);
		 var TaxAmnt = Math.round(Amount*TaxRateSplit[1])/100;
		 var TotalAmntVal = parseFloat(Amount)+parseFloat(TaxAmnt);
		 $("#TotalAmount").val(TotalAmntVal);
		
		}else{
		 $("#totalAmnt").hide(1000);
		 $("#TotalAmount").val("");
		}
	});	  
	
	 $("#Amount").keyup(function(){
		
		var TaxRateVal = $("#TaxRateDesc").val();
		var TaxRateSplit = TaxRateVal.split(":");
		$("#TaxID").val(TaxRateSplit[0]);
		$("#TaxRate").val(TaxRateSplit[1]);
		var Amount = $(this).val();
		if(TaxRateSplit[0] > 0 && Amount >0){
		 $("#totalAmnt").show(1000);
		 var TaxAmnt = Math.round(Amount*TaxRateSplit[1])/100;
		 var TotalAmntVal = parseFloat(Amount)+parseFloat(TaxAmnt);
		 $("#TotalAmount").val(TotalAmntVal);
		
		}else{
			$("#totalAmnt").hide(1000);
			$("#TotalAmount").val("");
		}
	});

//End Code for Tax Calculation	
   

//Code for Journal
$("#JournalType").change(function(){

	var TypeVal = $(this).val();
	if(TypeVal == "recurring"){
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$("#dStart").show(1000);		
	}else{
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
		$("#dStart").hide(1000);
	}

});


	var TypeVal = $("#JournalType").val();
	if(TypeVal == "recurring"){
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$("#dStart").show(1000);		
	}else{
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
		$("#dStart").hide(1000);
	}


	$(".showEntityType").click(function(){

		var strval = $(this).attr('id');
		var numRow = strval.split("_");
		numRow = numRow[1];
		$("#EntityType"+numRow).show(1000);
		$("#EntityID"+numRow).show(1000);
		$("#hideEntityName"+numRow).hide(1000);
		$("#hideEntityType_"+numRow).show(1000);
		$(this).hide();

	});

	$(".showEntityData").click(function(){

		var strval = $(this).attr('id');
		var numRow = strval.split("_");
		numRow = numRow[1];
		$("#EntityType"+numRow).hide(1000);
		$("#EntityID"+numRow).hide(1000);
		$("#hideEntityName"+numRow).show(1000);
		$("#showName_"+numRow).show(1000);
		$(this).hide();

	});

//End Code for Journal


      
      
      $("#SaveSettings").click(function(){ 
          
           var FiscalYearStartDate = $("#FiscalYearStartDate").val();
           var FiscalYearEndDate = $("#FiscalYearEndDate").val();
          
            d1 = new Date(FiscalYearStartDate);
            d2 = new Date(FiscalYearEndDate);
            var mdiff = monthDiff(d1, d2);
            //alert(mdiff);
         if (mdiff != '10') {

                    alert("Please Set Valid Fiscal Year.");
                     $("#FiscalYearEndDate").focus();
                     return false;
              }
        
        });
    //End code for setting   
    
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
    

	  
});




	function keyup(me)
	{
		if(isNaN(me.value))
		{
		me.value="";
		}
	}

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

 
           
 function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth() + 1;
    months += d2.getMonth();
    return months <= 0 ? 0 : months;
}