<?
if($_GET['type']=='UPS'){ //UPS
	$MeterLable = 'Account Number';
	$Username = 'Account Number'; //$Username = 'Username';
}else{ //Fedex
	$MeterLable = 'Meter Number';
	$Username = 'Account Number';
}


if($_GET['type']=='DHL'){ //DHL
 	$ApiKeyLable = 'Site ID';
	$HideMeter = 'Style="display:none"';
}else{ //Other
	$ApiKeyLable = 'API Key';
}

?>

<script language="JavaScript1.2" type="text/javascript">
function ResetDiv(){
	$("#prv_msg_div").show();
	$("#preview_div").hide();	
}

function validateForm(frm)
{
	if(window.parent.document.getElementById("CurrentDivision") != null){
  		document.getElementById("CurrentDivision").value = window.parent.document.getElementById("CurrentDivision").value;
	}

	var editVal =  $('#ID').val();
	var CustID =  $('#CustID').val();
	var AccountNumber = $('#api_account_number').val();
	var DataExist=0;
	var UsernameLabel =  $('#UsernameLabel').html();


	if(ValidateForSimpleBlank(form1.api_account_number, UsernameLabel)
			 
		 	
	)
		{

		if(AccountNumber!=''){
			DataExist = CheckExistingData("isRecordExists.php","&CustShipAccountNumber="+escape(AccountNumber)+"&editID="+escape(editVal)+"&CustID="+escape(CustID),"api_account_number","Account Number");
			if(DataExist==1)return false;
		}


		
	
		ResetDiv();
		return true;	

	}else{
		return false;	
	}	
	
}

function AccountChk(){
		var editVal =  $('#ID').val();
		var AccountNumber = $('#api_account_number').val();
		var CustID =  $('#CustID').val();
		if(AccountNumber!=''){
				$.ajax({
					type: "GET",
					url: "isRecordExists.php",
					data: "CustShipAccountNumber="+escape(AccountNumber)+"&editID="+escape(editVal)+"&CustID="+escape(CustID) ,
		  			success: function(html){
						 
						if(html==1){
							$("#disp").html('<span class="redmsg">Already exist</span>');
						}else{
							$("#disp").html('<span class="greenmsg">Available!</span>');
						}

				}

		
			});
	
		}


}


</script>



<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:250px;" >

 
	<div class="message" align="center"><?php if(!empty($_SESSION['mess_ship_msg'])){echo $_SESSION['mess_ship_msg'];unset($_SESSION['mess_ship_msg']);unset($_SESSION['mess_ship_msg']);}?></div>
 


<? if(empty($ErrorExist)){ ?>
<div class="had"><?=$Action;?> <?=ucfirst($_GET['type'])?> Account  
   </div>

<table cellspacing="0" cellpadding="0" width="100%" border="0"
	align="center">
	<form enctype="multipart/form-data" method="post" action=""
		name="form1" onSubmit="return validateForm(this);">
	<tbody>
		<tr>
			<td align="center">
			<table cellspacing="0" cellpadding="0" width="100%" border="0">

				<tbody>
					<tr>
						<td valign="top" align="center">

						<table cellspacing="0" cellpadding="5" width="100%" border="0"
							class="borderall">
							<tbody>
								 

								<tr>
									<td align="right" class="blackbold" valign="top" width="45%"><span id="UsernameLabel"><?=$Username?></span>:<span
										class="red">*</span></td>
									<td valign="top" align="left"><input type="text"
										name="api_account_number" class="inputbox" maxlength="50"
										id="api_account_number"
										value="<?php echo stripslashes($ShipAcoountDetails[0]['api_account_number']);?>"
										onblur="AccountChk()">

									<div id="disp"></div>

									</td>

									 
								 


								<tr>	 


									<td class="blackbold" align="right">Default   Account:</td>
									<td align="left"><input value="1" id="defaultVal"
										name="defaultVal" type="checkbox"
										<?php if($ShipAcoountDetails[0]['defaultVal']==1){echo 'checked';}?>>

									</td>

								</tr>

								 

							</tbody>
						</table>

						</td>
					</tr>

				</tbody>
			</table>

			</td>
		</tr>
		<tr>
			<td valign="top" align="center"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton"
				value=" <?=$ButtonTitle?> " /> 

<? if($_GET['edit'] >0){ ?>
  <!--input name="Check"
				type="submit" class="button" id="SubmitButton" value="Validate" -->
<? } ?>



<input type="hidden" name="api_name" class="inputbox" maxlength="50" id="api_name" value="<?=$_GET['type'];?>">
									<input type="hidden" name="ID" class="inputbox" maxlength="50" id="ID" value="<?php echo $_GET['edit'];?>">
 <input type="hidden" name="CustID" id="CustID" value="<?= $_GET['CustID'] ?>" />
 
<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="">

</td>
		</tr>
		
		
		
		

	</tbody>
	</form>
</table>
<? } ?>
</div>


