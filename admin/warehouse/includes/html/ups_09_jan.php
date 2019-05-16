<?
if($_POST){
	extract($_POST);
}else{
	/******************************/
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


	/*******MASTER CODE**********/
	$SourceZipcode = $arryApiACDetails[0]['SourceZipcode'];
	/*****************/
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
	if(ShippingMethodVal==''){ //for post

	/*$("#CountryCgTo option:contains('" + window.parent.document.getElementById('ShippingCountryTo').value + "')").attr("selected", true);*/

	$('#CountryCgTo option').filter(function(){
	    return $(this).html() == window.parent.document.getElementById('ShippingCountryTo').value;
	}).attr('selected', 'selected');

	document.getElementById('DestinationZipcode').value = window.parent.document.getElementById('shippingZipCodeFdx').value;

	document.getElementById("CompanyTo").value = window.parent.document.getElementById('ShippingCompanyTo').value;
	document.getElementById("Address1To").value = window.parent.document.getElementById('ShippingAddressTo').value;
	document.getElementById("CountryTo").value = window.parent.document.getElementById('ShippingCountryTo').value;
	document.getElementById("CityTo").value = window.parent.document.getElementById('ShippingCityTo').value;
	document.getElementById("StateTo").value = window.parent.document.getElementById('ShippingStateTo').value;
	document.getElementById("PhoneNoTo").value = window.parent.document.getElementById('ShippingMobileTo').value;
	document.getElementById("ZipTo").value = window.parent.document.getElementById('shippingZipCodeFdx').value;
	document.getElementById("FaxNoTo").value = window.parent.document.getElementById('ShippingFaxTo').value;
	document.getElementById("ContactNameTo").value = window.parent.document.getElementById('ShippingNameTo').value;
    document.getElementById("ContactNameTo").value = window.parent.document.getElementById('ShippingNameTo').value;
	
	document.getElementById("INVOICENO").value = window.parent.document.getElementById('INVNumber').value;
	document.getElementById("PONUMBER").value = window.parent.document.getElementById('SALENUMBER').value;
	//document.getElementById("Currency").value = window.parent.document.getElementById('CustomerCurrency').value;
	//document.getElementById("InsureCurrency").value = window.parent.document.getElementById('CustomerCurrency').value;
	//document.getElementById("TotalAmountSED").value = window.parent.document.getElementById('TotalAmount').value;
	}
}); 



function validateForm(frm)
{

		 
		

	if(ValidateForSelect(form1.ShippingMethod, "Shipping Method")
			&& ValidateForSelect(form1.packageType, "Package Type")
			&& ValidateForSelect(form1.AccountType, "Account Type")
			//&& ValidateForSimpleBlank(form1.AccountNumber, "Account Number")
			&& ValidateForSimpleBlank(form1.SourceZipcode, "Master Zipcode")
			&& ValidateForSimpleBlank(form1.DestinationZipcode, "Destination Zipcode")
			&& ValidateForSelect(form1.NoOfPackages, "No Of Packages")
	)
		{ 

		var NumLine= document.getElementById("NumLine").value;

		var pkt = document.getElementById("packageType").value;

			for(var j=1;j<=NumLine;j++){

				

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
			

		

		if($('.ITN').css('display') != 'none')
		{		 
			if(!ValidateForSimpleBlank(document.getElementById("AES"), "AES Number")){
				return false;
			}
		}

		if(document.getElementById("COD").checked){
			if(!ValidateForSimpleBlank(document.getElementById("CODAmount"), "COD Amount")){
				return false;
			}
		}

		



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
    
    if(x=='' || x==null){

     x = 1;   
        
    }
    
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


}


</script>


<script type="text/javascript">
function packType() {
    	document.getElementById("wline").style.display = "table";
    	document.getElementById("myTable").style.display = 'table';
    	document.getElementById("WeightPk").style.display = 'none';
	addRows();
 
}


function masterDetail(){
	var fdval = document.getElementById("fdAccount").value;
	var acVal = document.getElementById("AccountType").value;
	
	if(acVal==2){
		document.getElementById('AccountNumber').value = fdval;
		document.getElementById("AccountNumber").readOnly = true;
		document.getElementById("AccountNumber").className = "disabled_inputbox";
		
	}else{
		document.getElementById('AccountNumber').value= " " ;
		document.getElementById("AccountNumber").readOnly = false;
		document.getElementById("AccountNumber").className = "inputbox";
		
	}
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
			        
			}
			});
		
	});
	});


</script>


<script type="text/javascript">



function SetForIternational(){
		var TotalAmountSEDVal = $("#TotalAmountSED").val();
		var ShippingMethodVal = '<?=$ShippingMethod?>';
		var cn1 = $("#CountryCgFrom").val();
		var cn2 = $("#CountryCgTo").val();
		var selMethod = '';
		var toAppend = '';
 
		var selectValues = {
				11:"UPS Standard",
				07:"UPS Worldwide Express",
				54:"UPS Worldwide Express Plus",
				08:"UPS Worldwide Expedited",
				65:"UPS Worldwide Saver",
				96:"UPS Worldwide Express Freight",
				82:"UPS Today Standard",
				83:"UPS Today Dedicated Courier",
				84:"UPS Today Intercity",
				85:"UPS Today Express",
				86:"UPS Today Express Saver",
				70:"UPS Access Point Economy",
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


			if(cn1=='US' && cn2!=='CA' && TotalAmountSEDVal>=2500){
				$(".ITN").show();				
			}else{
				$(".ITN").hide();
				
			}


		}else{

			$("#ShippingMethod option[value='11']").remove();
			$("#ShippingMethod option[value='07']").remove();
			$("#ShippingMethod option[value='54']").remove();
			$("#ShippingMethod option[value='08']").remove();
			$("#ShippingMethod option[value='65']").remove();
			$("#ShippingMethod option[value='96']").remove();
			$("#ShippingMethod option[value='82']").remove();
			$("#ShippingMethod option[value='83']").remove();
			$("#ShippingMethod option[value='84']").remove();
			$("#ShippingMethod option[value='85']").remove();
			$("#ShippingMethod option[value='86']").remove();
			$("#ShippingMethod option[value='70']").remove();

			$("#ShippingMethod option[value='7']").remove();
			$("#ShippingMethod option[value='8']").remove();

		}
		
			$("#ShippingMethod option").each(function(){
			  $(this).siblings("[value='"+ this.value+"']").remove();
			});
		

		


		var k = chkInternational();

		if(k==true && TotalAmountSEDVal>=2500){

		  $(".ITN").show();
			
		}else{

			  $(".ITN").hide();

		}


}









$(document).ready(function(){

$("#COD").click(function(){	
	if(document.getElementById("COD").checked){
		$('#CODAmountTR').show(500); 
		$('#CollectionTypeTR').hide(500); 
	}else{
		$('#CODAmountTR').hide(500); 
		$('#CollectionTypeTR').hide(500); 
	}
});

$("#CountryCgTo").change(function(){
	SetForIternational();
});

$("#DeliverySignature").click(function(){	
	if(document.getElementById("DeliverySignature").checked){
		$('#DSOptions').show(500);  
	}else{
		$('#DSOptions').hide(500); 
	}
});


$("#CountryCgFrom").change(function(){
     //alert('hello this is a testings');
	var ShippingMethodVal = '<?=$ShippingMethod?>';
	var packageTypeVal = '<?=$packageType?>';
        var addType='UpsShipFromCountry';
	var CountryfrValue = $("#CountryCgFrom").val();
	var dataString = 'action='+ addType + '&countryCode='+ CountryfrValue;
	//alert(CountryfrValue);

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

	$('select[name=NoOfPackages] option:eq(1)').attr('selected', 'selected');

	$('#ShippingMethod').on("change",function() {

		var k = chkInternational();
		var TotalAmountSEDVal = $("#TotalAmountSED").val();
		if(k==true && TotalAmountSEDVal>=2500){

		  $(".ITN").show();
			
		}else{

			  $(".ITN").hide();

		}
	

	});


	 
	
});


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

<div id="prv_msg_div" style="display: none; padding: 100px;"><b><?=LOADER_MSG_SHIP?></b><br>
<br>
<img src="../images/ajaxloader.gif"></div>

<form name="form1" id="formRate" action="" method="post"
	onSubmit="return validateForm(this);" enctype="multipart/form-data">

<div id="accordion">
<?php include 'includes/html/box/from_shipmet.php';?>
<?php include 'includes/html/box/to_shipment.php';?>
</div>

<?php include 'includes/html/box/package_shipment.php';?>

</form>

