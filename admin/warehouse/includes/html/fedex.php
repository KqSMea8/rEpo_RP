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
	document.getElementById("Currency").value = window.parent.document.getElementById('CustomerCurrency').value;
	document.getElementById("InsureCurrency").value = window.parent.document.getElementById('CustomerCurrency').value;
	document.getElementById("CustomValueCurrency").value = window.parent.document.getElementById('CustomerCurrency').value;
	document.getElementById("TotalAmountSED").value = window.parent.document.getElementById('TotalAmount').value;
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
	var packt = document.getElementById("packageType").value;

    if(packt=='YOUR_PACKAGING'){
    	document.getElementById("wline").style.display = "table";
    	document.getElementById("myTable").style.display = 'table';
    	document.getElementById("WeightPk").style.display = 'none';
	addRows();
    }else{
    	document.getElementById("wline").style.display = "none";
    	document.getElementById("myTable").style.display = 'none';
    	document.getElementById("WeightPk").style.display = 'table-row';
    	 
    }

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

function custValHS(){

	var val1 = $("#CountryCgFrom").val();
	var val2 = $("#CountryCgTo").val();
	
	if(val1 == val2){

		$("#custVal").hide();
			
		}else{

			  $("#custVal").show();

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


			/* if(cn1=='US' && cn2!=='CA' && TotalAmountSEDVal>=2500){
				$(".ITN").show();				
			}else{
				$(".ITN").hide();
				
			}*/


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
		

		


		var k = chkInternational();

		if(k==true && TotalAmountSEDVal>=2500 && cn1=='US' && cn2!=='CA'){

		  $(".ITN").show();
			
		}else{

			  $(".ITN").hide();

		}


}









$(document).ready(function(){

$("#COD").click(function(){	
	if(document.getElementById("COD").checked){
		$('#CODAmountTR').show(500); 
		$('#CollectionTypeTR').show(500); 
	}else{
		$('#CODAmountTR').hide(500); 
		$('#CollectionTypeTR').hide(500); 
	}
});

$("#DeliverySignature").click(function(){	
	if(document.getElementById("DeliverySignature").checked){
		$('#DSOptions').show(500);  
	}else{
		$('#DSOptions').hide(500); 
	}
});


$("#CountryCgTo").change(function(){
	SetForIternational();
	custValHS();
});

$("#CountryCgFrom").change(function(){
     //alert('hello this is a testings');
	var ShippingMethodVal = '<?=$ShippingMethod?>';
	var packageTypeVal = '<?=$packageType?>';
        var addType='ShipFromCountry';
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
		custValHS();
		
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
<h3>From</h3>
<div>
<p>



<table cellspacing="0" cellpadding="5" border="0">
	<tbody>


		<tr>
			<td align="right" class="blackbold">Saved Senders :</td>
			<td align="left"><select class="textbox" name="ShippingFromData"
				id="ShippingFromData">
				<option value="">--- Select ---</option>
				<?php

				foreach($arryAddBookShFrom as $addshipFromValue){?>

				<option value="<?php echo $addshipFromValue['adbID'];?>"
				<?php if($ShippingFromData== $addshipFromValue['adbID']){ echo "selected = 'selected'";}?>><?php echo $addshipFromValue['ContactName'];?>,<?php echo $addshipFromValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td align="right" class="blackbold">Country :</td>
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
				id="SaveinAddressbookFrom" class="inputbox"
				name="SaveinAddressbookFrom" style="width: 10%;"></td>

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
			<td align="right" class="blackbold">Saved Receiver :</td>
			<td align="left"><select class="textbox" name="ShippingToData"
				id="ShippingToData">
				<option value="">--- Select ---</option>
				<?php

				foreach($arryAddBookShTo as $addshipToValue){?>

				<option value="<?php echo $addshipToValue['adbID'];?>"
				<?php if($ShippingToData== $addshipToValue['adbID']){ echo "selected = 'selected'";}?>><?php echo $addshipToValue['ContactName'];?>,<?php echo $addshipToValue['City'];?></option>

				<?php } ?>

			</select></td>

			<td align="right" class="blackbold">Country :</td>
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
				id="SaveinAddressbookTo" class="inputbox" name="SaveinAddressbookTo"
				style="width: 10%;"></td>

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
						<td colspan="2" align="left" class="head">Shipping Carrier Details</td>
					</tr>





					<tr>
						<td align="right" class="blackbold">Shipping Method :<span
							class="red">*</span></td>
						<td align="left"><select name="ShippingMethod" size="1"
							id="ShippingMethod" class="inputbox">
							<option value="">--- Select ---</option>
							<?php foreach($arrayFdDfService as $fedexService){?>
							<option value="<?=$fedexService['service_value'];?>"
							<?php if($_POST['ShippingMethod']== $fedexService['service_value']){ echo "selected='selected'";}?>><?=$fedexService['service_type'];?></option>
							<?php }?>
						</select></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Packages Type:<span
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
							<?php if($_POST['AccountType']=='1'){ echo "selected='selected'";}?>>Customer</option>
							<option value="2"
							<?php if($_POST['AccountType']=='2'){ echo "selected='selected'";}?>>Shipper</option>
							<option value="3"
							<?php if($_POST['AccountType']=='3'){ echo "selected='selected'";}?>>Third
							Party</option>
						</select></td>
					</tr>



					<tr>
						<td align="right" class="blackbold">Account Number :<span
							class="red">*</span></td>
						<td align="left"><input name="AccountNumber" type="text"
							class="inputbox" id="AccountNumber" value="<?=$AccountNumber?>"
							maxlength="50" ></td>
					</tr>



					<tr>
						<td align="right" class="blackbold">Master Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="SourceZipcode" type="text"
							id="SourceZipcode" value="<?=$SourceZipcode?>" maxlength="30"
							onkeypress="return isNumberKey(event);" readonly
							class="disabled_inputbox"></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Destination Zipcode:<span
							class="red">*</span></td>
						<td align="left"><input name="DestinationZipcode" type="text"
							id="DestinationZipcode" class="inputbox"
							value="<?=$DestinationZipcode?>" maxlength="30"
							onkeypress="return isNumberKey(event);"></td>
					</tr>


					<tr>
						<td align="right" width="45%" class="blackbold">No Of Packages:<span
							class="red">*</span></td>
						<td align="left"><select name="NoOfPackages" class="inputbox"
							id="NoOfPackages" onchange="addRows();">
							<option value="">--- Select ---</option>
							<?php
							for($i=1;$i<=25;$i++){?>

							<option value="<?=$i?>"
							<?=($NoOfPackages==$i)?('selected'):('')?>><?=$i?></option>
							<?php } ?>
						</select></td>
					</tr>


				  <tr class="ITN" style="display:none;">
						<td align="right" class="blackbold">AES Number:<span class="red">*</span></td>
						<td align="left">
<input name="AES" type="text"	class="inputbox" size="10" id="AES" value=""  onkeypress="return isUniqueKey(event);"
							maxlength="50"> 
			      	 </td>
				   </tr>


					<tr
					<?php if($_POST['packageType']== "YOUR_PACKAGING"){ echo 'style="display: none;"';}?>
						id="WeightPk">
						<td align="right" class="blackbold">Weight:<span class="red">*</span></td>
						<td align="left"><input name="WPK" type="text" class="textbox"
							size="10" id="WPK" value="<?=$WPK?>" maxlength="10"
							onkeypress="return isDecimalKey(event);"> <select name="WPK_Unit"
							id="WPK_Unit" class="textbox">
							<option value="LB" <?=($WPK_Unit=='LB')?('checked'):('')?>>LB</option>
							<option value="KG" <?=($WPK_Unit=='KG')?('checked'):('')?>>KG</option>
						</select></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">Insure The Shipment:</td>
						<td align="left"><input name="InsureAmount" type="text"
							class="textbox" size="10" id="InsureAmount" value="<?=$InsureAmount?>"
							maxlength="10" onkeypress="return isDecimalKey(event);"> 
						
						<input
						type="text" value="<?=$Currency?>" style="width:30px;border:none" maxlenght="10" readonly="" class="textbox"
						id="InsureCurrency" name="InsureCurrency">
					     </td>
					</tr>



					      <tr id="custVal">
						<td align="right" class="blackbold">Custom Value:<span class="red">*</span></td>
						<td align="left"><input name="CustomValue" type="text"
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
						</tr>
						
						
						<tr id="DSOptions"
						<?php if($DeliverySignature != "1"){ echo 'style="display: none;"';}?>>
							<td align="right" class="blackbold">Delivery Signature Options:</td>
							<td align="left">
							<select name="DSOptionsType" class="inputbox" id="DSOptionsType">
								<option value="INDIRECT"<?php if($_POST['DSOptionsType']=='INDIRECT'){ echo "selected='selected'";}?>>Indirect Signature</option>
								<option value="DIRECT"<?php if($_POST['DSOptionsType']=='DIRECT'){ echo "selected='selected'";}?>>Direct Signature</option>
								<option value="ADULT"<?php if($_POST['DSOptionsType']=='ADULT'){ echo "selected='selected'";}?>>Adult Signature</option>
							</select>
							
							</td>
						</tr>
					


					<tr>

						<td align="right" class="blackbold">Shipmaster Label:</td>
						<td align="left"><input type="checkbox" name="fedexLabel"
							value="Yes" <?=($fedexLabel=='Yes')?('checked'):('')?>></td>
					</tr>


					<tr>
						<td align="right" class="blackbold">COD Label:</td>
						<td align="left"><input type="checkbox" name="COD" id="COD"
							value="1" <?=($COD=='1')?('checked'):('')?>></td>
					</tr>

					<tr id="CODAmountTR"
					<?php if($COD != "1"){ echo 'style="display: none;"';}?>>
						<td align="right" class="blackbold">COD Amount:<span class="red">*</span></td>
						<td align="left"><input type="text" class="textbox" size="10"
							maxlenght="10" name="CODAmount" id="CODAmount"
							value="<?=$CODAmount?>" onkeypress="return isDecimalKey(event);">
						<input type="text" name="Currency" id="Currency" class="textbox"
							readonly style="width: 30px; border: none" maxlenght="3"
							value="<?=$Currency?>" /></td>
					</tr>

					<tr id="CollectionTypeTR"
					<?php if($COD != "1"){ echo 'style="display: none;"';}?>>
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
			value="<?php echo $_GET['sp'];?>">

	</tbody>


</table>


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
