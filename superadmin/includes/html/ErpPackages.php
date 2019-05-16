<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script type="text/javascript">
function checkTheBox() {
    var flag = 0;
    for (var i = 0; i< 4; i++) {
    if(document.form1["PlanDuration[]"][i].checked){
    flag ++;
}
}
if (flag < 1) {
    alert ("Please checked at least one plan duration!");
    return false;
}
return true;
}




function inventryModule(){
	 if($('#Department4').is(":checked")) {
		 //$('.inv_mod').prop('checked', true);
		 $(".invt").show();
	 
	 }else{
    	 $(".invt").hide();
		 $('.inv_mod').prop('checked', false);

	  }
	 
}

function ecomUsLimit(){
	
	 if($('#Department3').is(":checked")) {
		 //$('.inv_mod').prop('checked', true);
		 $(".pl").show();
		 $("#maxProduct").show();

	 }else{
    	// $(".invt").hide();
    	$(".pl").hide();
    	 $("#maxProduct").hide();
		// $('.inv_mod').prop('checked', false);

	  }


	
}



function chkPr(){

	 if($('#unllimited').is(":checked")) {
		 //$('.inv_mod').prop('checked', true);
		 $("#maxProduct").hide();

	 }else{
   	// $(".invt").hide();
   	$("#maxProduct").show();
		// $('.inv_mod').prop('checked', false);

	  }

	  

	  
	
}



function ShipCareerData(){

	var checkedValue = $('#ShippingCareer:checked').val();

	if(checkedValue==1){

		$("#shipVal").show();
		
	}else{

		$("#shipVal").hide();
		$('#ShippingCareerVal0').attr('checked', false); // Unchecks it
		$('#ShippingCareerVal1').attr('checked', false); // Unchecks it
		$('#ShippingCareerVal2').attr('checked', false); // Unchecks it
		$('#ShippingCareerVal3').attr('checked', false); // Unchecks it
		

	}

}

</script>



<style>

.invt {
    margin-left: 30px;
    
}

.pl {
    margin-left: 30px;
}


</style>

<?php include('ErpSiteManagementMenu.php');?>
<div class="clear"></div>
<br>
<div class="message" align="center"><? if(!empty($_SESSION['mess_packages'])) {echo $_SESSION['mess_packages']; unset($_SESSION['mess_packages']); }?>
</div>
<form name="form1" action="" method="post" enctype="multipart/form-data"
	onsubmit="return checkTheBox()">
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle">
				<div align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
				</div>
				<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="borderall">
					<tr>
						<td align="center" valign="top">
						<table width="100%" border="0" cellpadding="5" cellspacing="1">
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Name<span class="red">*</span></td>
								<td width="56%" align="left" valign="top"><input name="name"
									id="name"
									value="<?= !empty($arryPage[0]['name'])?stripslashes($arryPage[0]['name']):''; ?>"
									type="text" class="inputbox disabled" size="50" readonly /> <?php if(!empty($errors['name'])){echo $errors['name'];}?>
								</td>
							</tr>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Price $</td>
								<td width="56%" align="left" valign="top"><input name="price"
									id="price"
									value="<?= !empty($arryPage[0]['price'])?stripslashes($arryPage[0]['price']):''; ?>"
									type="text" class="inputbox" size="50" maxlength="10"
									onkeypress="return isNumberKey(event);" /> <?php if(!empty($errors['price'])){echo $errors['price'];}?>
								</td>
							</tr>


							<tr>
								<td align="right" class="blackbold" valign="top">Please Choose
								Feature :</td>
								<td align="left" style="line-height: 26px;">

<? if(!isset($arryCompany[0]['Department'])) $arryCompany[0]['Department']='';  ?>

<!--input type="radio" name="Department" id="Department" value="" <?=($arryCompany[0]['Department']=="")?("checked"):("")?> /> ERP <br>
<input type="radio" name="Department" id="Department" value="1" <?=($arryCompany[0]['Department']=="1")?("checked"):("")?> /> HRMS<br-->



								<label><input type="checkbox" name="feature[]"
									id="Department1" value="1"
									<?php if(in_array(1,$arr)){echo 'checked="checked"';}?> /> <?=MOD_HRMS?>
								<br>
								</label> <label <?=$HideModule?>><input type="checkbox"
									name="feature[]" id="Department2" value="5"
									<?php if(in_array(5,$arr)){echo 'checked="checked"';}?> /> <?=MOD_CRM?>
								<br>
								</label> <label <?=$HideModule?>><input type="checkbox"
									name="feature[]" id="Department3" value="2"
									<?php if(in_array(2,$arr)){echo 'checked="checked"';}?> onclick="Javascript:ecomUsLimit();"/> <?=MOD_ECOMMERCE?>
								<br>
								</label> 
								
								<label class="pl"><input class="inv_mod" type="checkbox" name="unllimited" id="unllimited" value="1" onclick="chkPr();"/> Unlimited Product</label> &nbsp;&nbsp;<input class="inputbox" type="text" name="maxProduct" id="maxProduct" value="<?=$arryPage[0]['maxProduct'];?>" size="50" onkeypress="return isNumberKey(event);"/>
								 <br>
								<label <?=$HideModule?>><input type="checkbox"
									name="feature[]" id="Department4" value="3,4,6,7,8"
									<?php if(in_array("3,4,6,7,8",$arr)){echo 'checked="checked"';}?>
									onclick="Javascript:inventryModule();" /> <?=MOD_INVENTORY?> <br>
								</label> 
								

								
						<label class="invt" ><input class="inv_mod" type="checkbox" name="inventryModule[]" id="inventryModule1" value="601" <?php if(in_array(601,$arrinventryModule)){echo 'checked="checked"';}?> /> Item Master <br></label>
						<label class="invt" ><input class="inv_mod"type="checkbox" name="inventryModule[]" id="inventryModule2" value="602" <?php if(in_array(602,$arrinventryModule)){echo 'checked="checked"';}?> /> Stock Adjustments <br></label>
						<label class="invt" ><input class="inv_mod"type="checkbox" name="inventryModule[]" id="inventryModule3" value="603"<?php if(in_array(603,$arrinventryModule)){echo 'checked="checked"';}?> /> Stock Transfers <br></label>
						<label class="invt" ><input class="inv_mod"type="checkbox" name="inventryModule[]" id="inventryModule4" value="604"<?php if(in_array(604,$arrinventryModule)){echo 'checked="checked"';}?> /> BOM <br></label>
						<label class="invt" ><input class="inv_mod" type="checkbox" name="inventryModule[]" id="inventryModule5" value="605"<?php if(in_array(605,$arrinventryModule)){echo 'checked="checked"';}?> /> Report <br></label>
						<label class="invt" ><input class="inv_mod" type="checkbox" name="inventryModule[]" id="inventryModule6" value="610"<?php if(in_array(610,$arrinventryModule)){echo 'checked="checked"';}?> /> Settings <br></label>
			
								

								<label <?=$HideModule?>><input type="checkbox"
									name="feature[]" id="Department5" value="9"
									<?php if(in_array(9,$arr)){echo 'checked="checked"';}?> /> <?=MOD_WEBSITE?>
								<br>
								</label></td>
							</tr>





<tr class="invt">
	<td align="right" class="blackbold">Batch Management :</td>
	<td align="left"><?  
	$batchChecked = ' checked';$InbatchChecked ='';
	if($_GET['edit'] > 0){
		if($arryPage[0]['batchmgmt'] == 1) {$batchChecked = ' checked'; $InbatchChecked ='';}
		if($arryPage[0]['batchmgmt'] == 0) {$batchChecked = ''; $InbatchChecked = ' checked';}
	}
	?> <label><input type="radio" name="batchmgmt" id="batchmgmt"
		value="1" <?=$batchChecked?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
	<label><input type="radio" name="batchmgmt" id="batchmgmt"
		value="0" <?=$InbatchChecked?> /> No</label></td>
</tr>



	<tr class="invt">
		<td align="right" class="blackbold">Shipping Career :</td>
		<td align="left"><?  
		$shipCareerChecked = 'checked';$shipC ='';
		if($_GET['edit'] > 0){
			if($arryPage[0]['ShippingCareer'] == 1) {$shipCareerChecked = 'checked'; $shipC ='';}
			if($arryPage[0]['ShippingCareer'] == 0) {$shipCareerChecked = ''; $shipC = 'checked';}
		}
		?> <label><input type="radio" name="ShippingCareer"
			id="ShippingCareer" value="1" <?=$shipCareerChecked?> onclick="Javascript:ShipCareerData();" /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="ShippingCareer"
			id="ShippingCareer" value="0" <?=$shipC?> onclick="Javascript:ShipCareerData();" /> No</label></td>
	</tr>
			
			
			
	<tr id="shipVal" class="invt">
	<td align="right" class="blackbold" valign="top">Allowed Ship
	Career :</td>
	<td align="left" style="line-height: 26px;">
<? if(!isset($ShippingCareerchk)) $ShippingCareerchk='';  ?>

<label><input
		type="checkbox" name="ShippingCareerVal[]" id="ShippingCareerVal0"
		value="Fedex" <?if(in_array('Fedex',$ShippingCareerchk)){echo "checked";}?> />FedEx<br>
	</label> <label><input type="checkbox" name="ShippingCareerVal[]"
		id="ShippingCareerVal1" value="UPS"
		<?if(in_array('UPS',$ShippingCareerchk)){echo "checked";}?> />UPS<br>
	</label> <label><input type="checkbox" name="ShippingCareerVal[]"
		id="ShippingCareerVal2" value="USPS"
		<?if(in_array('USPS',$ShippingCareerchk)){echo "checked";}?> />USPS <br>
	</label> <label><input type="checkbox" name="ShippingCareerVal[]"
		id="ShippingCareerVal3" value="DHL"
		<?if(in_array('DHL',$ShippingCareerchk)){echo "checked";}?> />DHL<br>
	</label></td>
</tr>








							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Allow Users : </td>
								<td width="56%" align="left" valign="top"><input
									name="allow_users" id="allow_users"
									value="<?= !empty($arryPage[0]['allow_users'])?stripslashes($arryPage[0]['allow_users']):''; ?>"
									type="text" class="inputbox" size="50"
									onkeypress="return isNumberKey(event);" /> <?php if(!empty($errors['allow_users'])){echo $errors['allow_users'];}?>
								</td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Free Spaces : </td>
								<td width="56%" align="left" valign="top"><input name="space"
									id="space"
									value="<?= !empty($arryPage[0]['space'])?stripslashes($arryPage[0]['space']):''; ?>"
									type="text" class="inputbox" size="50"
									onkeypress="return isNumberKey(event);" /> IN GB <?php if(!empty($errors['space'])){echo $errors['space'];}?>
								</td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Additional Space Price $</td>
								<td width="56%" align="left" valign="top"><input
									name="additional_spaceprice" id="additional_spaceprice"
									value="<?= !empty($arryPage[0]['additional_spaceprice'])?stripslashes($arryPage[0]['additional_spaceprice']):''; ?>"
									type="text" class="inputbox" size="50"
									onkeypress="return isNumberKey(event);" /> Per 10 GB <?php if(!empty($errors['additional_spaceprice'])){echo $errors['additional_spaceprice'];}?>
								</td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Short Description : </td>
								<td width="56%" align="left" valign="top"><input
									name="short_description" id="short_description"
									value="<?= !empty($arryPage[0]['short_description'])?stripslashes($arryPage[0]['short_description']):''; ?>"
									type="text" class="inputbox" size="50" /></td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Editional Feature</td>
								<td width="56%" align="left" valign="top"><input
									name="edition_features" id="edition_features"
									value="<?= !empty($arryPage[0]['edition_features'])?stripslashes($arryPage[0]['edition_features']):''; ?>"
									type="text" class="inputbox" size="50" /></td>
							</tr>

							<tr>
								<td width="30%" align="right" valign="top" class="blackbold">
								Description</td>
								<td align="left"><textarea id="description" class="bigbox"
									type="text" name="description">
									<?= !empty($arryPage[0]['description'])?stripslashes($arryPage[0]['description']):''; ?>
                                                        </textarea></td>
							</tr>

							<?php
							$arrayPlanDuration = explode(",",$arryPage[0]['PlanDuration']);
							?>
							<tr>

								<td align="right" valign="top" class="blackbold">Plan Duration:
								</td>
								<td align="left" style="line-height: 26px;"><label><input
									type="checkbox" value="user/month" name="PlanDuration[]"
									<?php if(in_array("user/month",$arrayPlanDuration)){echo 'checked="checked"';}?>>
								user/monthly <br>
								</label> <label><input type="checkbox" value="user/quarter"
									name="PlanDuration[]"
									<?php if(in_array("user/quarter",$arrayPlanDuration)){echo 'checked="checked"';}?>>
								user/quarterly <br>
								</label> <label><input type="checkbox" value="user/halfyear"
									name="PlanDuration[]"
									<?php if(in_array("user/halfyear",$arrayPlanDuration)){echo 'checked="checked"';}?>>user/half
								yearly <br>
								</label> <label><input type="checkbox" value="user/year"
									name="PlanDuration[]"
									<?php if(in_array("user/year",$arrayPlanDuration)){echo 'checked="checked"';}?>>user/yearly<br>
								</label> <?php if(!empty($errors['PlanDuration'])){echo $errors['PlanDuration'];}?>

								</td>

							</tr>
						</table>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align="center" height="135" valign="top"><br>
				<? if ($_GET['edit'] > 0) {
					$ButtonTitle = 'Update';
				} else {
					$ButtonTitle = 'Submit';
				} ?> <input type="hidden" name="id" id="id" value="<?= $id; ?>" /> <input
					name="Submit" type="submit" class="button" id="SubmitPage"
					value=" <?= $ButtonTitle ?> " />&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">
inventryModule();
ecomUsLimit();
chkPr();
ShipCareerData();
</script>
