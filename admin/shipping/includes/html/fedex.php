<?
if(!empty($_POST)){
	extract($_POST);

	$DeliverySignature=(!empty($_POST['DeliverySignature']))?($_POST['DeliverySignature']):('');
	$COD=(!empty($_POST['COD']))?($_POST['COD']):('');

}else{
	/******************************/
	$ShippingToData=$ContactNameTo=$CompanyTo=$CountryTo=$CountryCgTo=$FirstnameTo=$LastnameTo=$Address1To=$Address2To=$ZipTo=$PhoneNoTo=$CityTo=$StateTo=$DepartmentTo=$FaxNoTo='';


	/********FROM ADDRESS***********/
	$ShippingFromData = $arryAddressFrom[0]['adbID'];
	$Contactname = $arryAddressFrom[0]['ContactName'];
	$CompanyFrom = $arryAddressFrom[0]['Company'];
	if(!empty($arryAddressFrom[0]['adbID'])){
		$CountryFrom = $arryAddressFrom[0]['Country'];
		$CountryCgFrom	=  $arryAddressFrom[0]['CountryCode'];
		$FirstnameFrom = $arryAddressFrom[0]['Firstname'];
		$LastnameFrom = $arryAddressFrom[0]['Lastname'];
		$Address1From = $arryAddressFrom[0]['Address1'];
		$Address2From = $arryAddressFrom[0]['Address2'];
		$ZipFrom = $arryAddressFrom[0]['Zip'];
		$PhonenoFrom = $arryAddressFrom[0]['PhoneNo'];
	}else{
		$CountryFrom = $arryAddressFrom[0]['Country'];
		$CountryCgFrom	= $arryAddressFrom[0]['Country'];
		$arryContactName = explode(" ",$Contactname);
		$FirstnameFrom = $arryContactName[0];
		$LastnameFrom = $arryContactName[1];
		$Address1From = $arryAddressFrom[0]['Address'];
		$Address2From = '';
		$ZipFrom = $arryAddressFrom[0]['ZipCode'];
		$PhonenoFrom = $arryAddressFrom[0]['phone_number'];
	}
	$CityFrom = $arryAddressFrom[0]['City'];
	$StateFrom =  $arryAddressFrom[0]['State'];
	$DepartmentFrom = $arryAddressFrom[0]['Department'];
	$FaxnoFrom = $arryAddressFrom[0]['FaxNo'];


	/******************************/
	/********TO ADDRESS***********/
	if(!empty($arryAddressTo[0]['adbID'])){
		$ShippingToData = $arryAddressTo[0]['adbID'];
		$ContactNameTo = $arryAddressTo[0]['ContactName'];
		$CompanyTo = $arryAddressTo[0]['Company'];
		$CountryTo = $arryAddressTo[0]['Country'];
		$CountryCgTo	=  $arryAddressTo[0]['CountryCode'];
		$FirstnameTo = $arryAddressTo[0]['Firstname'];
		$LastnameTo = $arryAddressTo[0]['Lastname'];
		$Address1To = $arryAddressTo[0]['Address1'];
		$Address2To = $arryAddressTo[0]['Address2'];
		$ZipTo = $arryAddressTo[0]['Zip'];
		$PhoneNoTo = $arryAddressTo[0]['PhoneNo'];
		$CityTo = $arryAddressTo[0]['City'];
		$StateTo =  $arryAddressTo[0]['State'];
		$DepartmentTo = $arryAddressTo[0]['Department'];
		$FaxNoTo = $arryAddressTo[0]['FaxNo'];
	}

	/*******MASTER CODE**********/
	$SourceZipcode = $arryApiACDetails[0]['SourceZipcode'];
	/*****************/

	$DestinationZipcode=$Currency=$BillDutiesTaxOpt=$BillDutiesTaxAccount='';
	$fedexLabel=$INVOICENO=$PONUMBER=$TotalAmountSED=$CUSTOMERREFERENCE='';
	$ShippingMethod=$AccountType=$ShipAccountNumber=$packageType=$NoOfPackages=$WPK=$WPK_Unit='';
	$AccountNumber=$DeliverySignature=$COD=$CustomValue=$InsureAmount=$CODAmount=$CollectionType='';
	$DSOptionsType = $CustAccountNumber=$SaveCustAccount=$SaveCustAccount2='';
}

?>
<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#formRate").hide();	
	$(".redmsg").hide();	
}

$(document).ready(function(){
	var ShippingMethodVal = '<?=$ShippingMethod?>';
	var ModuleType = '<?=$_GET["ModuleType"]?>';
 
	if(ShippingMethodVal==''){ //for post


	/*$("#CountryCgTo option:contains('" + window.parent.document.getElementById('ShippingCountryTo').value + "')").attr("selected", true);*/

	


	if(ModuleType=='SalesRMA'){

		$('#CountryCgFrom option').filter(function(){
		    return $(this).html() == window.parent.document.getElementById('ShippingCountryTo').value;
		}).attr('selected', 'selected');

		document.getElementById("CompanyFrom").value = window.parent.document.getElementById('ShippingCompanyTo').value;			
		document.getElementById("Address1From").value = window.parent.document.getElementById('ShippingAddressTo').value;
		document.getElementById("CountryFrom").value = window.parent.document.getElementById('ShippingCountryTo').value;
		document.getElementById("CityFrom").value = window.parent.document.getElementById('ShippingCityTo').value;
		
		document.getElementById("StateFrom").value = window.parent.document.getElementById('ShippingStateTo').value;
		document.getElementById("PhonenoFrom").value = window.parent.document.getElementById('ShippingMobileTo').value;
		document.getElementById("ZipFrom").value = window.parent.document.getElementById('shippingZipCodeFdx').value;
		document.getElementById("FaxnoFrom").value = window.parent.document.getElementById('ShippingFaxTo').value;
		document.getElementById("Contactname").value = window.parent.document.getElementById('ShippingNameTo').value;	    	
		document.getElementById("PhonenoFrom").value = window.parent.document.getElementById('ShippingLandlineNumber').value;

		document.getElementById('SourceZipcode').value = window.parent.document.getElementById('shippingZipCodeFdx').value;

		document.getElementById('DestinationZipcode').value = document.getElementById('MasterZipcode').value;
		

	}else{

		$('#CountryCgTo option').filter(function(){
		    return $(this).html() == window.parent.document.getElementById('ShippingCountryTo').value;
		}).attr('selected', 'selected');


		document.getElementById("CompanyTo").value = window.parent.document.getElementById('ShippingCompanyTo').value;		
		document.getElementById("Address1To").value = window.parent.document.getElementById('ShippingAddressTo').value;
		document.getElementById("CountryTo").value = window.parent.document.getElementById('ShippingCountryTo').value;
		document.getElementById("CityTo").value = window.parent.document.getElementById('ShippingCityTo').value;
		document.getElementById("StateTo").value = window.parent.document.getElementById('ShippingStateTo').value;
		document.getElementById("PhoneNoTo").value = window.parent.document.getElementById('ShippingMobileTo').value;
		document.getElementById("ZipTo").value = window.parent.document.getElementById('shippingZipCodeFdx').value;
		document.getElementById("FaxNoTo").value = window.parent.document.getElementById('ShippingFaxTo').value;
		document.getElementById("ContactNameTo").value = window.parent.document.getElementById('ShippingNameTo').value;	    	
		document.getElementById("PhoneNoTo").value = window.parent.document.getElementById('ShippingLandlineNumber').value;
		document.getElementById('DestinationZipcode').value = window.parent.document.getElementById('shippingZipCodeFdx').value;
	}

	
	
	
	document.getElementById("INVOICENO").value = window.parent.document.getElementById('INVNumber').value;
	document.getElementById("PONUMBER").value = window.parent.document.getElementById('SALENUMBER').value;
	
	document.getElementById("Currency").value = window.parent.document.getElementById('BaseCurrency').value;
	document.getElementById("InsureCurrency").value = window.parent.document.getElementById('BaseCurrency').value;
	document.getElementById("CustomValueCurrency").value = window.parent.document.getElementById('BaseCurrency').value;

    

	if(window.parent.document.getElementById('REFERENCE_NUMBER') != null){
	document.getElementById("CUSTOMERREFERENCE").value = window.parent.document.getElementById('REFERENCE_NUMBER').value;
	}

   var subtotal = window.parent.document.getElementById('subtotal').value;
   if(window.parent.document.getElementById('BaseCurrency').value!=window.parent.document.getElementById('CustomerCurrency').value){
	subtotal = parseFloat(subtotal) * window.parent.document.getElementById('ConversionRate').value;
   }
	 
   document.getElementById("GrandTotalAmount").value = subtotal;


	
	//document.getElementById("TotalAmountSED").value = window.parent.document.getElementById('TotalAmount').value;
	}
}); 



function validateForm(frm)
{

		 
		

	if(ValidateForSelect(form1.ShippingMethod, "Shipping Method")
			&& ValidateForSelect(form1.packageType, "Package Type")
			&& ValidateForSelect(form1.AccountType, "Account Type")
			&& ValidateForSimpleBlank(form1.AccountNumber, "Account Number")
			&& ValidateForSimpleBlank(form1.SourceZipcode, "Master Zipcode")
			&& ValidateForSimpleBlank(form1.DestinationZipcode, "Destination Zipcode")
			&& ValidateForSelect(form1.NoOfPackages, "No Of Packages")
			//&& ValidateForSelect(form1.CustomValue, "Custom Value")
	)
		{ 

		if($("#CountryCgFrom").val() != $("#CountryCgTo").val()){

			if(!ValidateForSimpleBlank(document.getElementById("CustomValue"), "Custom Value")){
				return false;
			}
			
		}


		var NumLinev= document.getElementById("NumLine").value;

		var pkt = document.getElementById("packageType").value;

		if(pkt=='YOUR_PACKAGING'){

			for(var j=1;j<=NumLinev;j++){

				if(document.getElementById("Weight"+j) != null){

					if(!ValidateForSimpleBlank(document.getElementById("Weight"+j), "Weight")){
						return false;
					}

					
					if(!ValidateForSimpleBlank(document.getElementById("Length"+j), "Length")){
						return false;
					}

					if(!ValidateForSimpleBlank(document.getElementById("Width"+j), "Width")){
						return false;
					}

					if(!ValidateForSimpleBlank(document.getElementById("Height"+j), "Height")){
						return false;
					}
				
				}
			}
			
		}else{

			if(!ValidateForSimpleBlank(document.getElementById("WPK"), "Weight")){
				return false;
			}
			
		}
		

		if($('.ITN').css('display') != 'none')
		{		 
			if(!ValidateForSimpleBlank(document.getElementById("AES"), "AES Number")){
				return false;
			}
		}




if($('#pickTbl').css('display') != 'none')
			{		 
				if(!ValidateForSimpleBlank(document.getElementById("pickReadyTime"), "Ready Time")){
					return false;
				}

				if(!ValidateForSimpleBlank(document.getElementById("pickCloseTime"), "Close Time")){
					return false;
				}
				if(!ValidateForSimpleBlank(document.getElementById("CourierRemarks"), "Courier Description")){
					return false;
				}
				if(!ValidateForSimpleBlank(document.getElementById("pickWeight"), "Total Weight")){
					return false;
				}
			
			}


	      if($('.BillDutiesTaxTr').css('display') != 'none')
		{		 
			if(!ValidateForSelect(document.getElementById("BillDutiesTaxOpt"), "Bill duties")){
				return false;
			}
		}



		if(document.getElementById("BillDutiesTaxOpt").value == 'THIRD_PARTY')
		{		 
			if(!ValidateForSimpleBlank(document.getElementById("BillDutiesTaxAccount"), "Account Number")){
				return false;
			}
		}



		if(document.getElementById("COD").checked){
			if(!ValidateForSimpleBlank(document.getElementById("CODAmount"), "COD Amount")){
				return false;
			}
		}

		
		$("#BillDutiesTaxOpt").attr("disabled",false);


		ResetSearch();
		
		//return true;	

	}
	else
		{
		return false;	
	}	
	
}


</script>

<script language="JavaScript1.2" type="text/javascript">

function addRows() {
	var i;
	var cols = "";
    var x = document.getElementById("NoOfPackages").value;
    
    $("table.order-list").empty();

  for(i=1;i<=x;i++){
	
		
	var counter = $('#myTable tr').length + 1;

	var newRow = $("<tr class='itembg'>");
	var cols = "";



    cols += '<td><input type="text" onkeypress="return isDecimalKey(event);" maxlength="10" size="10" value="1" name="Weight'+counter+'" id="Weight'+counter+'" class="textbox"> </td><td><select name="wtUnit'+counter+'" id="wtUnit'+counter+'" class="textbox"><option value="LB">Lbs</option><option value="KG">Kg</option></select></td><td ><input type="text" onkeypress="return isDecimalKey(event);" maxlength="10" size="10" value="1" name="Length'+counter+'" id="Length'+counter+'" class="textbox" ></td><td><input type="text" name="Width' + counter + '"  id="Width' + counter + '" value="1"  class="textbox" size="5" maxlength="6" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" onkeypress="return isDecimalKey(event);" maxlength="10" size="10" value="1" name="Height'+counter+'" id="Height'+counter+'" class="textbox" ></td><td><select name="htUnit'+counter+'" id="htUnit'+counter+'" class="textbox"><option value="IN">IN</option><option value="FT">FT</option></select></td>';

	newRow.append(cols);
	//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
	$("table.order-list").append(newRow);
	$("#NumLine").val(counter);
	counter++;
	
}


	<?php if($NumLine>0){
		for($i=1; $i<=$NumLine; $i++){?>
		document.getElementById("Weight<?=$i?>").value = <?=$_POST["Weight$i"]?>;
		document.getElementById("Length<?=$i?>").value = <?=$_POST["Length$i"]?>;
		document.getElementById("Width<?=$i?>").value =  <?=$_POST["Width$i"]?>;
		document.getElementById("Height<?=$i?>").value = <?=$_POST["Height$i"]?>;
		$('#wtUnit<?=$i?> option[value=<?=$_POST["wtUnit$i"]?>]').prop('selected', true);
		$('#htUnit<?=$i?> option[value=<?=$_POST["htUnit$i"]?>]').prop('selected', true);
	<?php }
		
	}?>
	

}


</script>


<script type="text/javascript">
function packType() {
	var packt = document.getElementById("packageType").value;

    if(packt=='YOUR_PACKAGING'){
    	document.getElementById("wline").style.display = "table";
    	document.getElementById("myTable").style.display = 'table';

	$("#WeightPk").hide();$("#WeightPkVal").hide();
    	 
	addRows();
    }else{
    	document.getElementById("wline").style.display = "none";
    	document.getElementById("myTable").style.display = 'none';
    	$("#WeightPk").show();$("#WeightPkVal").show();
    	 
    }

}


function SetCustAccount(){
	var CustAccountNumber =  $('#CustAccountNumber').val();
	var CustID =  $('#CustID').val();
	$("#SaveCustAccountLabel").hide();
	if(CustAccountNumber!='' && CustAccountNumber!='ADD'){
		$("#AccountNumber").val(CustAccountNumber);
		$("#CustAccountNumber").show();
		$("#AccountNumber").hide();
	}else if(CustAccountNumber=='ADD'){
		$("#AccountNumber").val('');
		$("#CustAccountNumber").hide();
		$("#AccountNumber").show();
		if(CustID>0) $("#SaveCustAccountLabel").show();
	}
}

function masterDetail(){
	var fdval = document.getElementById("fdAccount").value;
	var acVal = document.getElementById("AccountType").value;
	
	$("#SaveCustAccountLabel").hide();
 	$("#CustAccountNumber").prop("selectedIndex", 0);

	if(acVal==2){
		$('#AccountNumber').show();
		$('#CustAccountNumber').hide();
		document.getElementById('AccountNumber').value = fdval;
		document.getElementById("AccountNumber").readOnly = true;
		document.getElementById("AccountNumber").className = "disabled_inputbox";
		
	}else if(acVal==4){
		document.getElementById('AccountNumber').value = fdval;
		document.getElementById("AccountNumber").readOnly = true;
		document.getElementById("AccountNumber").className = "disabled_inputbox";
      }else{
		document.getElementById('AccountNumber').value= "" ;
		document.getElementById("AccountNumber").readOnly = false;
		document.getElementById("AccountNumber").className = "inputbox";

		 
		


		var CustAccountNumber =  $('#CustAccountNumber').val();
		if(acVal == "1" && CustAccountNumber != "0"){
			$('#AccountNumber').hide();
			$('#CustAccountNumber').show();
			document.getElementById('AccountNumber').value = CustAccountNumber;
		}else if(acVal == "1" && CustAccountNumber == "0"){
			$("#CustAccountNumber").prop("selectedIndex", 1);
			SetCustAccount();
		}else{			
			$('#AccountNumber').show();
			$('#CustAccountNumber').hide();
		}
		
	}





	displayAES();
	customAutoFill();

}


</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#ShippingFromData').change(function(){
		var FromData = $("#ShippingFromData").val();
		var addType='ShippingFrom';
		var dataString = 'action='+ addType + '&adbID='+ FromData;
		$.ajax({
			type: "POST",
			url: "isRecordExists.php",
			data: dataString,
			dataType : "JSON",
			//cache: false,
			success: function(result){
			//alert(result);
			
				 $('#CountryCgFrom').val(result.CountryCode);
				 $('#CountryFrom').val(result.Country);
				 $('#CompanyFrom').val(result.Company);
				 $('#FirstnameFrom').val(result.Firstname);
				 $('#LastnameFrom').val(result.Lastname);
				 $('#Contactname').val(result.ContactName);
				 $('#Address1From').val(result.Address1);
				 $('#ZipFrom').val(result.Zip);
				 $('#Address2From').val(result.Address2);
				 $('#CityFrom').val(result.City);
				 $('#StateFrom').val(result.State);
				 $('#PhonenoFrom').val(result.PhoneNo);
				 $('#DepartmentFrom').val(result.Department);
				 $('#FaxnoFrom').val(result.FaxNo);	

				 
				$("#CountryCgFrom").trigger("change");
			        
			}
			});
		
	});
	});


</script>



<script type="text/javascript">
$(document).ready(function() {
	$('#ShippingToData').change(function(){
		var ToData = $("#ShippingToData").val();
		var addType='ShippingTo';
		var dataString = 'action='+ addType + '&adbID='+ ToData;
		$.ajax({
			type: "POST",
			url: "isRecordExists.php",
			data: dataString,
			dataType : "JSON",
			//cache: false,
			success: function(result){
			//alert(result);
				 $('#CountryCgTo').val(result.CountryCode);
				 $('#CountryTo').val(result.Country);
				 $('#CompanyTo').val(result.Company);
				 $('#FirstnameTo').val(result.Firstname);
				 $('#LastnameTo').val(result.Lastname);
				 $('#ContactNameTo').val(result.ContactName);
				 $('#Address1To').val(result.Address1);
				 $('#ZipTo').val(result.Zip);
				 $('#Address2To').val(result.Address2);
				 $('#CityTo').val(result.City);
				 $('#StateTo').val(result.State);
				 $('#PhoneNoTo').val(result.PhoneNo);
				 $('#DepartmentTo').val(result.Department);
				 $('#FaxNoTo').val(result.FaxNo);	
	
			        $("#CountryCgTo").trigger("change");

			}
			});
		
	});
	});


</script>


<script type="text/javascript">

function custValHS(){

	var val1 = $("#CountryCgFrom").val();
	var val2 = $("#CountryCgTo").val();
	 
	if(val1 == val2){

		$("#custVal").hide();
		$("#custValTd").hide();
			
		}else{

			  $("#custVal").show();
			 $("#custValTd").show();

	   }

	
	
}

function SetForIternational(){ 
		var TotalAmountSEDVal = $("#TotalAmountSED").val();
		var ShippingMethodVal = '<?=$ShippingMethod?>';
		var cn1 = $("#CountryCgFrom").val();
		var cn2 = $("#CountryCgTo").val();
		var selMethod = '';
		var toAppend = '';
 		 
		var selectValues = {
				INTERNATIONAL_PRIORITY:"FedEx International Priority",
				INTERNATIONAL_PRIORITY_SATURDAY_DELIVERY:"FedEx International Priority Saturday Delivery", 
				INTERNATIONAL_ECONOMY:"FedEx International Economy",
				INTERNATIONAL_FIRST:"FedEx International First",
				INTERNATIONAL_PRIORITY_FREIGHT:"FedEx International Priority Freight",
				INTERNATIONAL_ECONOMY_FREIGHT:"FedEx International Economy Freight",
				INTERNATIONAL_GROUND:"FedEx International Ground",
				};

		if(cn1!=cn2){

			$.each(selectValues, function(key, value) { 

			      if(ShippingMethodVal==key){
				    selMethod = 'Selected';
			      }else{
				    selMethod = '';
			       }

			      toAppend += '<option value="'+ key +'" '+selMethod+'>'+ value +'</option>';
  				

			     /*$('#ShippingMethod')
			         .append($("<option></option>")
			                    .attr("value",key)
			                    .text(value)); */
                 
			});

			$("#ShippingMethod").append(toAppend);

		}else{

			$("#ShippingMethod option[value='INTERNATIONAL_PRIORITY']").remove();
			$("#ShippingMethod option[value='INTERNATIONAL_PRIORITY_SATURDAY_DELIVERY']").remove();
			$("#ShippingMethod option[value='INTERNATIONAL_ECONOMY']").remove();
			$("#ShippingMethod option[value='INTERNATIONAL_FIRST']").remove();
			$("#ShippingMethod option[value='INTERNATIONAL_PRIORITY_FREIGHT']").remove();
			$("#ShippingMethod option[value='INTERNATIONAL_ECONOMY_FREIGHT']").remove();
			$("#ShippingMethod option[value='INTERNATIONAL_GROUND']").remove();
	

		}
		
			$("#ShippingMethod option").each(function(){
			  $(this).siblings("[value='"+ this.value+"']").remove();
			});
		
			displayAES();
            customAutoFill();


}









$(document).ready(function(){

$("#COD").click(function(){	
	if(document.getElementById("COD").checked){
		$('#CODAmountTR').show(500); 
		 
	}else{
		$('#CODAmountTR').hide(500); 
		 
	}
});

$("#DeliverySignature").click(function(){	
	if(document.getElementById("DeliverySignature").checked){
		$('#DSOptions').show(500);  
		$('#DSOptionsVal').show(500);  
	}else{
		$('#DSOptions').hide(500); 
		$('#DSOptionsVal').hide(500);  
	}
});


$("#pickEnable").click(function(){	
	if(document.getElementById("pickEnable").checked){
		$('#pickTbl').fadeIn(500);  
		
	}else{
		$('#pickTbl').fadeOut(500); 

	}
});



$("#CountryCgTo").change(function(){

	var conh1 = $("#CountryCgFrom").val();
	var conh2 = $("#CountryCgTo").val();

	if(conh1.trim() == conh2.trim()){

		$("#custVal").hide();
		$("#custValTd").hide();
			
		}else{

			 $("#custVal").show();
			 $("#custValTd").show();

	   }
	SetForIternational();

});

$("#CountryCgFrom").change(function(){
     //alert('hello this is a testings');
	var ShippingMethodVal = '<?=$ShippingMethod?>';
	var packageTypeVal = '<?=$packageType?>';
    var addType='ShipFromCountry';
	var CountryfrValue = $("#CountryCgFrom").val();
	var CountryTValue = $("#CountryCgTo").val();
	var dataString = 'action='+ addType + '&countryCode='+ CountryfrValue;
	
	
	if(CountryfrValue.trim() == CountryTValue.trim()){

		$("#custVal").hide();
		$("#custValTd").hide();
			
		}else{

			 $("#custVal").show();
			 $("#custValTd").show();

	   }
	

	$.ajax({
        type:'POST',
	url:'isRecordExists.php',
	data: dataString,
	dataType : "JSON",
	success:function(result){
        //alert(result);
		//console.log(result.pk);
		
		if(result !=0){
		var toAppend = '';
		var toAppend1 = '';
		var selMethod = '';
		var selPack = '';

		$.each(result.pk, function(i,o){
			  //console.log(o.package_type);
			   if(packageTypeVal==o.package_type_value){
				selPack = 'Selected';
			  }else{
				selPack = '';
			  }

			  toAppend += '<option value="'+ o.package_type_value +'" '+selPack+'>'+ o.package_type +'</option>';


			  //$("#gggg").remove();
			  
			  //$("#gggg").html(toAppend);

			  $("#packageType").empty().append(toAppend);
		       
		});

		

		$.each(result.st, function(key,value){
			  //console.log(o.package_type);
			  
			  if(ShippingMethodVal==value.service_value){
				selMethod = 'Selected';
			  }else{
				selMethod = '';
			  }

			  toAppend1 += '<option value="'+ value.service_value +'" '+selMethod+'>'+ value.service_type +'</option>';

			  //$("#hhhh").html(toAppend1);
			
			  $("#ShippingMethod").empty().append(toAppend1);
		       
		});


		if(window.parent.document.getElementById("SMVal") != null){
		        var SMValue = window.parent.document.getElementById('SMVal').value;
			if(SMValue !=''){
			 $("#ShippingMethod option[value='" + SMValue + "']").attr("selected","selected");
			}
		}
	        
		

		}else{

			
			 //$("#packageType").empty();
			 //$("#ShippingMethod").empty();
			
		}
		 
		SetForIternational();
		
		}
		
		});

});



	$("#CountryCgFrom").trigger("change");
	packType();

});





function chkInternational(){

	var str = $("#ShippingMethod").val();
    var n = str.indexOf("INTERNATIONAL");
	if(n<0){
		return false;
	}else{
		return true;
	}
	
}



$(document).ready(function(){

        custValHS();

	$('#ShippingMethod').on("change",function() {
		displayAES();
customAutoFill();
	});

	$('#CustomValue').on("keyup",function() {
		displayAES();
	});
	$('#CustomValue').on("blur",function() {
		displayAES();
	});

	 
	
});

function customAutoFill(){
	var countryCus1 = $("#CountryCgFrom").val();
	var countryCus2 = $("#CountryCgTo").val();
	var GrandTotalAmountVal = $('#GrandTotalAmount').val();
	var con = '<?=$CustomValue?>';
	var c = chkInternational();
	if(con=='' && c==true && countryCus1!=countryCus2){
		$("#CustomValue").val(GrandTotalAmountVal);
	}
}
function displayAES(){

var custVal = $("#CustomValue").val();
var country1 = $("#CountryCgFrom").val();
var country2 = $("#CountryCgTo").val();
var AccountTypeVal = $("#AccountType").val(); 
var DefaultCustAccount = $("#DefaultCustAccount").val(); 
//var GrandTotalAmountVal = $('#GrandTotalAmount').val();
var BillDutiesTaxOpt = $("#BillDutiesTaxOpt").val(); 
var BillDutiesTaxAccount = $("#BillDutiesTaxAccount").val(); 

var CustID =  $('#CustID').val();
var k = chkInternational();

if(k==true || country1 != country2){
	$("#CODTR").hide();
	$("#CODAmountTR").hide();
	$('#COD').attr('Checked',false);
}else{
 	$("#CODTR").show();	
}


if(BillDutiesTaxOpt!='' &&  BillDutiesTaxAccount!=''){
	 //set none
}else{
	$("#BillDutiesTaxOpt").val('');
	$("#BillDutiesTaxAccount").val('');
	$("#BillDutiesTaxAccountLab").hide(500);
	$("#BillDutiesTaxAccountinp").hide(500);
	$("#SaveCustAccountLabel2").hide();
}

$("#BillDutiesTaxOpt").attr("disabled",false);
$("#BillDutiesTaxOpt").attr("class","inputbox"); 

 
if(k==true && country1!=country2){
	//$("#CustomValue").val(GrandTotalAmountVal);
     $(".BillDutiesTaxTr").show();

	
     if(AccountTypeVal=="1"){
		$("#BillDutiesTaxAccountLab").show(500);
		$("#BillDutiesTaxAccountinp").show(500); 	 
	 	$("#BillDutiesTaxOpt").val('RECIPIENT');
		$("#BillDutiesTaxOpt").attr("disabled",true);
		$("#BillDutiesTaxOpt").attr("class","disabled_inputbox"); 
		if(CustID>0) $("#SaveCustAccountLabel2").show();

		if(DefaultCustAccount!='' &&  BillDutiesTaxAccount==''){	 
			$("#BillDutiesTaxAccount").val(DefaultCustAccount);
			 		
		}
		 
     }

}else{
    $(".BillDutiesTaxTr").hide();
   // $("#CustomValue").val('');
}

///alert('cust'+custVal+'country1'+country1+'country2'+country2+'k'+k);
if(k==true && custVal>=2500 && country1=='US' && country2!='CA'){

	       $(".ITN").show();
		
	}else{

		$(".ITN").hide();
                $("#AES").val('');

	}
}


function BillDuties(){
	var BillDutiesTaxOptVal = document.getElementById("BillDutiesTaxOpt").value;
	var SenderAccount = document.getElementById("fdAccount").value;
	var DefaultCustAccount = $("#DefaultCustAccount").val(); 
	var CustID =  $('#CustID').val();

	if(BillDutiesTaxOptVal!='SENDER' && BillDutiesTaxOptVal!=''){
		 $("#BillDutiesTaxAccountLab").show(500);
		 $("#BillDutiesTaxAccountinp").show(500); 
		 $("#BillDutiesTaxAccount").val('');
	}else{
		 $("#BillDutiesTaxAccountLab").hide(500);
		 $("#BillDutiesTaxAccountinp").hide(500);
		 $("#BillDutiesTaxAccount").val(SenderAccount); 
	}

  	$("#SaveCustAccountLabel2").hide();
	if(BillDutiesTaxOptVal=='RECIPIENT'){
		$(".billspan").hide();
		if(DefaultCustAccount!=''){
	   		$("#BillDutiesTaxAccount").val(DefaultCustAccount);			  
		}
		if(CustID>0) $("#SaveCustAccountLabel2").show();	   
	}else{
	  	$(".billspan").show();
	}

}

</script>
<style>
.ui-accordion-content.ui-helper-reset.ui-widget-content.ui-corner-bottom.ui-accordion-content-active
	{
	height: auto !important;
}
</style>

<link
	rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script
	src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script language="JavaScript1.2" type="text/javascript">
  $(function() {
    $("#accordion").accordion();
  });
 </script>

<script type="text/javascript">
		$(function() {
			$('#pickDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

				}
			);

			//.datepicker("setDate", new Date());
		});
</script>

<script>
  $(function() {
	$('#pickReadyTime').timepicker({ 
		'timeFormat': 'H:i:s',
		'step': '15'
		});
  });
</script>

<script>
  $(function() {
	$('#pickCloseTime').timepicker({ 
		'timeFormat': 'H:i:s',
		'step': '15'
		});
  });
</script>

<div id="prv_msg_div" style="display: none; padding: 100px;"><b><?=LOADER_MSG_SHIP?></b><br>
<br>
<img src="../images/ajaxloader.gif"></div>

<form name="form1" id="formRate" action="" method="post"
	onSubmit="return validateForm(this);" enctype="multipart/form-data">

<div id="accordion">
<h3>From</h3>
<div>
<p>



<table cellspacing="0" cellpadding="5" border="0">
	<tbody>


		<tr>
			<td width="20%" align="right" class="blackbold">Saved Senders :</td>
			<td width="33%"  align="left"><select class="textbox" name="ShippingFromData"
				id="ShippingFromData">
				<option value="">--- Select ---</option>
				<?php

				foreach($arryAddBookShFrom as $addshipFromValue){?>

				<option value="<?php echo $addshipFromValue['adbID'];?>"
				<?php if($ShippingFromData== $addshipFromValue['adbID']){ echo "selected = 'selected'";}?>><?php echo $addshipFromValue['ContactName'];?>,<?php echo $addshipFromValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td width="20%" align="right" class="blackbold">Country :</td>
			<td align="left"><select name="CountryCgFrom" class="inputbox"
				id="CountryCgFrom">
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
				<option value="<?=$arryCountry[$i]['code']?>"
				<?php if(!empty($CountryCgFrom) && $CountryCgFrom == $arryCountry[$i]['code']){ echo "selected = 'selected'";}?>><?=$arryCountry[$i]['name']?></option>
				<? } ?>
			</select></td>
		</tr>


		<tr>
			<td align="right" class="blackbold" style="display: none">Country :</td>
			<td align="left" style="display: none"><input type="text"
				maxlength="15" value="<?=$CountryFrom?>" id="CountryFrom"
				class="inputbox" name="CountryFrom"></td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="40"
				value="<?=$CompanyFrom?>" id="CompanyFrom" class="inputbox"
				name="CompanyFrom"></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">First Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$FirstnameFrom?>" id="FirstnameFrom" class="inputbox"
				name="FirstnameFrom"></td>

			<td align="right" class="blackbold">Last Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$LastnameFrom?>" id="LastnameFrom" class="inputbox"
				name="LastnameFrom"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact Name :</td>
			<td align="left"><input type="text" maxlength="50"
				value="<?=$Contactname?>" id="Contactname" class="inputbox"
				name="Contactname"></td>

			<td align="right" class="blackbold">Address1 :</td>
			<td align="left"><textarea name="Address1From" type="text"
				maxlength="200" class="textarea" id="Address1From"
				style="height: 30px;"><?=$Address1From?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$ZipFrom?>" id="ZipFrom" class="inputbox" name="ZipFrom"></td>

			<td align="right" class="blackbold">Address2 :</td>
			<td align="left"><textarea name="Address2From" type="text"
				maxlength="200" class="textarea" id="Address2From"
				style="height: 30px;"><?=$Address2From?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$CityFrom?>" id="CityFrom" class="inputbox"
				name="CityFrom"></td>

			<td align="right" class="blackbold">State :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$StateFrom?>" id="StateFrom" class="inputbox"
				name="StateFrom"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone No :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$PhonenoFrom?>" id="PhonenoFrom" class="inputbox"
				name="PhonenoFrom"></td>

			<td align="right" class="blackbold">Department :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$DepartmentFrom?>" id="DepartmentFrom" class="inputbox"
				name="DepartmentFrom"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Save in Address Book :</td>
			<td align="left"><input type="checkbox" maxlength="10" value="Yes"
				id="SaveinAddressbookFrom" 
				name="SaveinAddressbookFrom"  ></td>

			<td align="right" class="blackbold">Fax No :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$FaxnoFrom?>" id="FaxnoFrom" class="inputbox"
				name="FaxnoFrom"></td>
		</tr>



	</tbody>
</table>


</p>
</div>



<h3>To</h3>
<div>
<p>


<table cellspacing="0" cellpadding="5" border="0">
	<tbody>



		<tr>
			<td width="20%"  align="right" class="blackbold">Saved Receiver :</td>
			<td width="33%"  align="left"><select class="textbox" name="ShippingToData"
				id="ShippingToData">
				<option value="">--- Select ---</option>
				<?php

				foreach($arryAddBookShTo as $addshipToValue){?>

				<option value="<?php echo $addshipToValue['adbID'];?>"
				<?php if($ShippingToData== $addshipToValue['adbID']){ echo "selected = 'selected'";}?>><?php echo $addshipToValue['ContactName'];?>,<?php echo $addshipToValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td width="20%"  align="right" class="blackbold">Country :</td>
			<td align="left"><select name="CountryCgTo" class="inputbox"
				id="CountryCgTo">
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryCountry);$i++) {?>
				<option value="<?=$arryCountry[$i]['code']?>"
				<?php if(!empty($CountryCgTo) &&  $CountryCgTo== $arryCountry[$i]['code']){ echo "selected = 'selected'";}?>><?=$arryCountry[$i]['name']?></option>
				<? } ?>
			</select></td>
		</tr>




		<tr>
			<td align="right" class="blackbold" style="display: none">Country :</td>
			<td align="left" style="display: none"><input type="text"
				maxlength="30" value="<?=$CountryTo?>" id="CountryTo"
				class="inputbox" name="CountryTo"></td>

			<td align="right" class="blackbold">Company :</td>
			<td align="left"><input type="text" maxlength="40"
				value="<?=$CompanyTo?>" id="CompanyTo" class="inputbox"
				name="CompanyTo"></td>
		</tr>


		<tr>
			<td align="right" class="blackbold">First Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$FirstnameTo?>" id="FirstnameTo" class="inputbox"
				name="FirstnameTo"></td>

			<td align="right" class="blackbold">Last Name :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$LastnameTo?>" id="LastnameTo" class="inputbox"
				name="LastnameTo"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Contact Name :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$ContactNameTo?>" id="ContactNameTo" class="inputbox"
				name="ContactNameTo"></td>

			<td align="right" class="blackbold">Address1 :</td>
			<td align="left"><textarea name="Address1To" type="text"
				maxlength="200" class="textarea" id="Address1To"
				style="height: 30px;"><?=$Address1To?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Zip :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$ZipTo?>" id="ZipTo" class="inputbox" name="ZipTo"></td>

			<td align="right" class="blackbold">Address2 :</td>
			<td align="left"><textarea name="Address2To" type="text"
				maxlength="200" class="textarea" id="Address2To"
				style="height: 30px;"><?=$Address2To?></textarea></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">City :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$CityTo?>" id="CityTo" class="inputbox" name="CityTo"></td>

			<td align="right" class="blackbold">State :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$StateTo?>" id="StateTo" class="inputbox" name="StateTo"></td>
		</tr>



		<tr>
			<td align="right" class="blackbold">Phone No :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$PhoneNoTo?>" id="PhoneNoTo" class="inputbox"
				name="PhoneNoTo"></td>

			<td align="right" class="blackbold">Department :</td>
			<td align="left"><input type="text" maxlength="30"
				value="<?=$DepartmentTo?>" id="DepartmentTo" class="inputbox"
				name="DepartmentTo"></td>
		</tr>


		<tr>

			<td align="right" class="blackbold">Save in Address Book :</td>
			<td align="left"><input type="checkbox" maxlength="10" value="Yes"
				id="SaveinAddressbookTo"   name="SaveinAddressbookTo"
				 ></td>

			<td align="right" class="blackbold">Fax No :</td>
			<td align="left"><input type="text" maxlength="15"
				value="<?=$FaxNoTo?>" id="FaxNoTo" class="inputbox" name="FaxNoTo"></td>
		</tr>



	</tbody>
</table>



</p>
</div>
</div>



 



<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">

	<tbody>
		<tr>
			<td align="center" valign="top">

			<table width="100%" border="0" cellpadding="5" cellspacing="0"
				class="borderall">
				<tbody>



					<tr>
						<td colspan="4" align="left" class="head">Shipping Carrier Details</td>
					</tr>





					<tr>
						<td width="20%"  align="right" class="blackbold">Shipping Method :<span
							class="red">*</span></td>
						<td width="30%" align="left"><select name="ShippingMethod" size="1"
							id="ShippingMethod" class="inputbox">
							<option value="">--- Select ---</option>
							<?php 
						 
						

						foreach($arrayFdDfService as $fedexService){?>
							<option value="<?=$fedexService['service_value'];?>"
							<?php if($ShippingMethod== $fedexService['service_value']){ echo "selected='selected'";}?>><?=$fedexService['service_type'];?></option>
							<?php }?>
						</select></td>
					 
						<td width="20%"  align="right" class="blackbold">Packages Type:<span
							class="red">*</span></td>
						<td align="left"><select name="packageType" size="1"
							id="packageType" class="inputbox" onchange="packType()">
							<option value="">--- Select ---</option>

							<?php foreach($arrayFdDfpackage as $fedexpack){?>
							<option value="<?=$fedexpack['package_type_value'];?>"
							<?=($packageType==$fedexpack['package_type_value'])?('selected'):('')?>><?=$fedexpack['package_type'];?></option>
							<?php }?>

						</select></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Account Type :<span
							class="red">*</span></td>
						<td align="left"><select name="AccountType" class="inputbox"
							id="AccountType" onchange="masterDetail()">
							<option value="">--- Select ---</option>
							<option value="1"
							<?php if($AccountType=='1'){ echo "selected='selected'";}?>>Customer</option>
							<option value="2"
							<?php if($AccountType=='2'){ echo "selected='selected'";}?>>Shipper</option>
							<option value="3"
							<?php if($AccountType=='3'){ echo "selected='selected'";}?>>Third
							Party</option>

<option value="4"
<?php if($AccountType=='4'){ echo "selected='selected'";}?>>Collect (Authorized Ground)</option>

						</select></td>
					 
						<td align="right" class="blackbold">Account Number :<span
							class="red">*</span></td>
						<td align="left" >



<input name="AccountNumber" type="text" class="inputbox" id="AccountNumber" value="<?=$AccountNumber?>" maxlength="50"  <?=($AccountType=='1' && !empty($CustAccountNumber) && $CustAccountNumber!='ADD' )?('style="display:none"'):('')?>>

<label for="SaveCustAccount" id="SaveCustAccountLabel" <?=(!empty($CustID) && $AccountType=='1' && $CustAccountNumber=="ADD")?(''):('style="display:none"')?>>&nbsp;&nbsp;<input type="checkbox" name="SaveCustAccount" id="SaveCustAccount" value="1" style="vertical-align: middle;" <?=($AccountType=='1' && $CustAccountNumber=="ADD" && $SaveCustAccount=="1")?('Checked'):('')?>>&nbsp;Save</label>

 
<select name="CustAccountNumber" id="CustAccountNumber" class="inputbox" onchange="SetCustAccount()"  <?=(($AccountType=='1' && !empty($CustAccountNumber) && $CustAccountNumber!='ADD')?(''):('style="display:none"'))?>>
<?php 
$DefaultCustAccount='';
if(!empty($arryCustAccount)){
	foreach($arryCustAccount as $cAccount){ 

		if($cAccount['defaultVal']=="1"){
			$DefaultCustAccount=$cAccount['api_account_number'];
		}
		
?>
	<option value="<?=$cAccount['api_account_number'];?>" <?php if($CustAccountNumber == $cAccount['api_account_number']){echo "selected";}?>><?=$cAccount['api_account_number'];?></option>
<?php }
	
}else{ 
	echo '<option value="0">0</option>';

}
	echo '<option value="ADD">Add New</option>';

 ?>
</select>	 
 


</td>
					</tr>


<?php if(sizeof($MultilpleShipAccountDetail)>0){?>
	<tr>
		<td align="right" class="blackbold">Shipping Account :</td>
		<td align="left"><select name="ShipAccountNumber" class="inputbox"
			id="ShipAccountNumber">
			 
			<?php foreach ($MultilpleShipAccountDetail as $shipAccount){?>
			
			<option value="<?=$shipAccount['api_account_number'];?>" <?php if($ShipAccountNumber == $shipAccount['api_account_number']){echo "selected";}?>><?=$shipAccount['api_account_number'];?></option>
			
			<?php } ?>
		</select></td>
	 
		<td align="right" class="blackbold"></td>
	</tr>
<?php } ?>



					<tr>
						<td align="right" class="blackbold">Master Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="SourceZipcode" type="text"
							id="SourceZipcode" value="<?=$SourceZipcode?>" maxlength="30"
							onkeypress="return isNumberKey(event);" readonly
							class="disabled_inputbox"></td>
					 
						<td align="right" class="blackbold">Destination Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="DestinationZipcode" type="text"
							id="DestinationZipcode" class="inputbox"
							value="<?=$DestinationZipcode?>" maxlength="30"
							onkeypress="return isNumberKey(event);"></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">No Of Packages:<span
							class="red">*</span></td>
						<td align="left"><select name="NoOfPackages" class="inputbox"
							id="NoOfPackages" onchange="addRows();">
							<option value="">--- Select ---</option>
							<?php
							for($i=1;$i<=39;$i++){?>

							<option value="<?=$i?>"
							<?=($NoOfPackages==$i)?('selected'):('')?>><?=$i?></option>
							<?php } ?>
						</select></td>
					 
						<td align="right" class="blackbold">Insure The Shipment:</td>
						<td align="left"><input name="InsureAmount" type="text"
							class="textbox" size="10" id="InsureAmount" value="<?=$InsureAmount?>"
							maxlength="10" onkeypress="return isDecimalKey(event);"> 
						
						<input
						type="text" value="<?=$Currency?>" style="width:30px;border:none" maxlenght="10" readonly="" class="textbox"
						id="InsureCurrency" name="InsureCurrency">
					     </td>
					</tr>


				  <tr class="ITN" style="display:none;">
						<td align="right" class="blackbold">AES Number:<span class="red">*</span></td>
						<td align="left">
<input name="AES" type="text"	class="inputbox" size="10" id="AES" value=""  onkeypress="return isUniqueKey(event);"
							maxlength="50"> 
			      	 </td>
				   </tr>


				   	<tr class="BillDutiesTaxTr"  style="display:none;">
				   	
						<td align="right" class="blackbold">Bill duties/taxes/fees to:<span
							class="red">*</span></td>
						<td align="left">
 
<select name="BillDutiesTaxOpt" class="inputbox" id="BillDutiesTaxOpt" onchange="BillDuties()">
	<option value="">--- Select ---</option>
	<option value="SENDER" <?php if($BillDutiesTaxOpt=='SENDER'){ echo "selected";}?>>Shipper</option>
	<option value="RECIPIENT" <?php if($BillDutiesTaxOpt=='RECIPIENT'){ echo "selected";}?>>Recipient</option>
	<option value="THIRD_PARTY" <?php if($BillDutiesTaxOpt=='THIRD_PARTY'){ echo "selected";}?>>Third Party</option>
</select>
 
</td>
					
<?php 
if($BillDutiesTaxOpt=='RECIPIENT' || $BillDutiesTaxOpt=='THIRD_PARTY'){ 
	$BillDutiesStyle = '';
}else{
	$BillDutiesStyle = 'style="display:none;"';
}
?>

						<td align="right" class="blackbold" id="BillDutiesTaxAccountLab" <?=$BillDutiesStyle?>>Account Number :<span
							class="red billspan">*</span></td>
						<td align="left" id="BillDutiesTaxAccountinp"  <?=$BillDutiesStyle?> >

<input name="BillDutiesTaxAccount" type="text" class="inputbox" id="BillDutiesTaxAccount" value="<?=$BillDutiesTaxAccount?>" maxlength="50" >


<label for="SaveCustAccount2" id="SaveCustAccountLabel2" <?=(!empty($CustID) && $BillDutiesTaxOpt=='RECIPIENT')?(''):('style="display:none"')?>>&nbsp;&nbsp;<input type="checkbox" name="SaveCustAccount2" id="SaveCustAccount2" value="1" style="vertical-align: middle;" <?=($BillDutiesTaxOpt=='RECIPIENT' && $SaveCustAccount2=="1")?('Checked'):('')?>>&nbsp;Save</label>


						</td>
					</tr>




					<tr>
						<td align="right" class="blackbold" <?php if($packageType== "YOUR_PACKAGING"){ echo 'style="display: none;"';}?>
						id="WeightPk" >Weight:<span class="red">*</span></td>
						<td align="left" <?php if($packageType== "YOUR_PACKAGING"){ echo 'style="display: none;"';}?>
						id="WeightPkVal"><input name="WPK" type="text" class="textbox"
							size="10" id="WPK" value="<?=$WPK?>" maxlength="10"
							onkeypress="return isDecimalKey(event);"> <select name="WPK_Unit"
							id="WPK_Unit" class="textbox">
							<option value="LB" <?=($WPK_Unit=='LB')?('checked'):('')?>>LB</option>
							<option value="KG" <?=($WPK_Unit=='KG')?('checked'):('')?>>KG</option>
						</select></td>
					 

					    
						<td align="right" class="blackbold" id="custVal">Custom Value:<span class="red">*</span></td>
						<td align="left" id="custValTd"><input name="CustomValue" type="text"
						    class="textbox" size="10" id="CustomValue" value="<?=$CustomValue?>"
						    maxlength="10" onkeypress="return isDecimalKey(event);">
						
						<input
						type="text" value="<?=$Currency?>" style="width:30px;border:none" maxlenght="10" readonly="" class="textbox"
						id="CustomValueCurrency" name="CustomValueCurrency">
						 </td>
					    </tr>


						<tr>
							<td align="right" class="blackbold">Delivery Signature:</td>
							<td align="left"><input type="checkbox" name="DeliverySignature" id="DeliverySignature"
								value="1" <?=($DeliverySignature=='1')?('checked'):('')?>></td>
						
						
						
						 
			<td align="right" class="blackbold" id="DSOptions"
						<?php if($DeliverySignature != "1"){ echo 'style="display: none;"';}?>>Delivery Signature Options:</td>
							<td align="left" id="DSOptionsVal"
						<?php if($DeliverySignature != "1"){ echo 'style="display: none;"';}?>>
							<select name="DSOptionsType" class="inputbox" id="DSOptionsType">
								<option value="INDIRECT"<?php if($DSOptionsType=='INDIRECT'){ echo "selected='selected'";}?>>Indirect Signature</option>
								<option value="DIRECT"<?php if($DSOptionsType=='DIRECT'){ echo "selected='selected'";}?>>Direct Signature</option>
								<option value="ADULT"<?php if($DSOptionsType=='ADULT'){ echo "selected='selected'";}?>>Adult Signature</option>
							</select>
							
							</td>
						</tr>
					

<tr>
	<td align="right" class="blackbold">Pickup:</td>
	<td align="left"><input type="checkbox" name="pickEnable"
		id="pickEnable" value="1"
		<?=($pickEnable=='1')?('checked'):('')?>></td>

	</td>
</tr>




					<!--tr>

						<td align="right" class="blackbold"><strong>Generate Shipmaster Label:</strong></td>
						<td align="left"><input type="checkbox" name="fedexLabel"
							value="Yes" <?=($fedexLabel=='Yes')?('checked'):('')?>></td>
					</tr-->


					<tr id="CODTR">
						<td align="right" class="blackbold"><strong>Generate COD Label:</strong></td>
						<td align="left"><input type="checkbox" name="COD" id="COD"
							value="1" <?=($COD=='1')?('checked'):('')?>></td>
					</tr>

					<tr id="CODAmountTR"
					<?php if(empty($COD)){ echo 'style="display: none;"';}?>>
						<td align="right" class="blackbold">COD Amount:<span class="red">*</span></td>
						<td align="left"><input type="text" class="textbox" size="10"
							maxlenght="10" name="CODAmount" id="CODAmount"
							value="<?=$CODAmount?>" onkeypress="return isDecimalKey(event);">
						<input type="text" name="Currency" id="Currency" class="textbox"
							readonly style="width: 30px; border: none" maxlenght="3"
							value="<?=$Currency?>" /></td>
					 

					 
						<td align="right" class="blackbold">COD Collection Type:</td>
						<td align="left"><select name="CollectionType" id="CollectionType"
							class="textbox">
							<option value="GUARANTEED_FUNDS"
							<?php if($CollectionType=='GUARANTEED_FUNDS'){ echo "selected='selected'";}?>>Secured</option>
							<option value="ANY"
							<?php if($CollectionType=='ANY'){ echo "selected='selected'";}?>>Unsecured</option>

						</select></td>
					</tr>


					<tr>

						<td align="right" class="blackbold"></td>
						<td align="left"><input name="fdAccount" type="hidden"
							id="fdAccount" readonly
							value="<?=$arryApiACDetails[0]['api_account_number']?>"></td>
					</tr>

				</tbody>
			</table>


			</td>
		</tr>

		<input name="Action" type="hidden" id="Action"
			value="Fedex">

	</tbody>


</table>

<?php include 'includes/html/box/fedex_pickup.php';?>


<table width="86%" cellpadding="0" cellspacing="1" id="wline"
	style="display: none">

	<thead>
		<tr align="left">
			<td class="heading" style="padding-left: 33px;">Weight</td>
			<td class="heading" style="padding-left: 33px;">WUnit</td>
			<td class="heading" style="padding-left: 33px;">Length</td>
			<td class="heading" style="padding-left: 33px;">Width</td>
			<td class="heading" style="padding-left: 33px;">Height</td>
			<td class="heading" style="padding-left: 33px;">DUnit</td>

		</tr>


	</thead>
	<input type="hidden" name="NumLine" id="NumLine" value=""
		maxlength="20" />

	<input type="hidden" name="INVOICENO" id="INVOICENO" class="inputbox"
		value="<?=$INVOICENO?>" />
	<input type="hidden" name="PONUMBER" id="PONUMBER" class="inputbox"
		value="<?=$PONUMBER?>" />

	<input type="hidden" name="CUSTOMERREFERENCE" id="CUSTOMERREFERENCE" class="inputbox"
		value="<?=$CUSTOMERREFERENCE?>" />

	<input type="hidden" name="DefaultCustAccount" id="DefaultCustAccount" class="inputbox"
		value="<?=$DefaultCustAccount?>" readonly />
	<input type="hidden" name="CustID" id="CustID" class="inputbox"
		value="<?=$CustID?>" readonly />

	<input type="hidden" name="MasterZipcode" id="MasterZipcode" class="inputbox"
		value="<?=$SourceZipcode?>" readonly />
 

<input name="GrandTotalAmount" type="hidden" id="GrandTotalAmount" value="" />


<input type="hidden" value="<?=$TotalAmountSED?>" class="textbox" id="TotalAmountSED" name="TotalAmountSED">

</table>

<table width="41%" id="myTable" class="order-list" cellpadding="0"
	cellspacing="1" style="display: none">


	<tbody>

	</tbody>
	<tfoot>

		<tr class='itembg'>
			<td colspan="11" align="right"></td>
		</tr>
	</tfoot>

</table>


<table>

	<tr>
		<td align="center"><input name="Submit" type="submit" class="button"
			id="SubmitButton" value="Submit"></td>

		<td align="center"><input name="Preview" type="submit" class="button"
			id="Preview" value="Rate Quote"></td>

	</tr>




</table>


</form>
