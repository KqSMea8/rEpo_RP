<?
if(!empty($_POST)){
	extract($_POST);
 

}else{
	 
	$PickupNo=$PickupFrom=$Freight=$Action=$CustomerPickupCarrier='';
 
}

?>
<script src="<?=$Prefix?>js/jquery.switchButton.js"></script>
<link rel="stylesheet" href="<?=$Prefix?>css/jquery.switchButton.css">
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

	document.getElementById("Currency").value = window.parent.document.getElementById('BaseCurrency').value;

   var subtotal = window.parent.document.getElementById('subtotal').value;
   if(window.parent.document.getElementById('BaseCurrency').value!=window.parent.document.getElementById('CustomerCurrency').value){
	subtotal = parseFloat(subtotal) * window.parent.document.getElementById('ConversionRate').value;
   }
	 
   document.getElementById("GrandTotalAmount").value = subtotal;

	}
}); 



$(function() { 
	$("#InPersonPickup").switchButton({ 
		on_label: 'Yes',
		off_label: 'No',
		on_callback: ShowOtherOption,
		off_callback: ShowOtherOption 
	});  

});


function ShowOtherOption(){	
 
	if(document.getElementById("InPersonPickup").checked){
		$(".TrackingRange").show();
		$(".OtherOption").show();
	}else{
		$(".TrackingRange").hide();
		$(".OtherOption").hide();
	}
	 
}


function validateForm(frm)
{
	
	if(document.getElementById("InPersonPickup").checked){

	if(ValidateForSimpleBlank(form1.CustomerPickupCarrier, "Shipping Carrier")			
		//&& ValidateForSimpleBlank(form1.Freight, "Freight Amount")
 		 
	)
		{ 


		var chks = document.getElementsByName('TrackingNo[]');

		for (var i = 0; i < chks.length; i++)
        {        
        if (chks[i].value=="")
        {
        alert("Please Fillup Tracking Number");
        chks[i].focus();
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
	
}




</script>


<script type="text/javascript">

function addMoreRangePr(thisobj)
{	
		$('.TrackingRange:first').clone().attr('id','TrackingRange'+$('.TrackingRange').length).insertAfter($('.TrackingRange:last')).find('td:last').append('<img src="../images/delete.png" class="rangDel" style="cursor:pointer">');
		$('.TrackingRange:last a').remove();
		$('.TrackingRange:last').find(':input').val('');
		//$('.TrackingRange:last .prpercent').show();
}

$(document).on('click','.add_rowtr', function(){	addMoreRangePr($(this));	});

$(document).on('click', '.rangDel', function(){ 
	if($(this).closest('td').parent('tr').find('.add_rowtr').length) {
		//$(this).closest('td').parent('tr').prev('tr').find('.qtyto').closest('td').append('<a href="javascript:;" class="add_row" id="addmore">Add More</a>');
	}
	$(this).closest('td').parent('tr').remove(); 
})


</script>
 


<div id="prv_msg_div" style="display: none; padding: 100px;">
	<b><?=LOADER_MSG_SHIP?> </b><br> <br> <img
		src="../images/ajaxloader.gif">
</div>

<form name="form1" id="formRate" action="" method="post"
	onSubmit="return validateForm(this);" enctype="multipart/form-data">


	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="0">

		<tbody>
			<tr>
				<td align="center" valign="top">

					<table width="100%" border="0" cellpadding="5" cellspacing="0"
						class="borderall">
						<tbody>



							<tr>
								<td colspan="2" align="left" class="head"> Customer Pickup</td>
							</tr>




							<!--tr>
								<td align="right" class="blackbold">Pickup No:<span class="red">*</span>
								</td>
								<td align="left"><input name="PickupNo" type="text"
									class="inputbox" id="PickupNo" value="<?=$PickupNo?>"
									maxlength="50">
								</td>

								<td align="right" class="blackbold">Pickup From :<span
									class="red">*</span></td>
								<td align="left">
										
									<select name="PickupFrom" class="inputbox" id="PickupFrom" >
									<option value="">--- Select ---</option>
									<? //for($i=0;$i<sizeof($arryVendor);$i++) {     ?>
									<option value="<?=$arryVendor[$i]['SuppCode']?>" <?php if($PickupFrom == $arryVendor[$i]['SuppCode']){echo "selected";}?>>
									<?=stripslashes($arryVendor[$i]["VendorName"])?></option>
									<? //} ?>
									</select> 
									
									
									</td>

							</tr-->

<tr>
			<td align="right" class="blackbold" width="30%"> In-Person Pickup : 
			</td>
			<td align="left">
<input name="InPersonPickup" type="checkbox"  id="InPersonPickup" value="1">
			</td>

			 

		</tr>

<tr class="OtherOption">
			<td align="right" class="blackbold">Shipping Carrier :<span class="red">*</span>
			</td>
			<td align="left"><input name="CustomerPickupCarrier" type="text"
				class="inputbox" id="CustomerPickupCarrier" value="<?=$CustomerPickupCarrier?>"
				maxlength="50">
			</td>

			 

		</tr>



							<tr style="display:none">
								<td align="right" class="blackbold">Freight Amount :<span class="red">*</span>
								</td>
								<td align="left"><input name="Freight" type="text"
									class="inputbox" id="Freight" value="<?=$Freight?>"
									maxlength="50">
								</td>

								 

							</tr>


							<tr id='TrackingRange' class="TrackingRange">
								<td align="right" class="blackbold">Tracking :<span class="red">*</span></td>
								<td align="left"><input name="TrackingNo[]" type="text"
									class="inputbox track" id="TrackingNo"
									value="<?php echo stripslashes($TrackingNo[$i]); ?>"
									maxlength="100" /> <a href="javascript:;"
									class="add_rowtr" id="addmoretr">Add More</a>   
								 
								</td>
							</tr>


						</tbody>
					</table>
				</td>
			</tr>

			<input name="Action" type="hidden" id="Action" value="customPickup">
			
			<input type="hidden" name="Currency" id="Currency"  value="<?=$Currency?>" readonly />
			
			<input name="GrandTotalAmount" type="hidden" id="GrandTotalAmount"
			value="" />

		</tbody>


	</table>


	
	<table>

		<tr>
			<td align="center"><input name="Submit" type="submit" class="button"
				id="SubmitButton" value="Submit"></td>
 

		</tr>




	</table>


</form>

