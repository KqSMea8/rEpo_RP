<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script type = "text/javascript">
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
</script>

<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<br>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_packages'])) {echo $_SESSION['mess_packages']; unset($_SESSION['mess_packages']); }?>
</div>
<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return checkTheBox()">
	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<tr>
			<td align="center" valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="middle">
							<div align="right">
								<a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
							</div> <br>
							<table width="100%" border="0" cellpadding="0" cellspacing="0"
								class="borderall">


								<tr>
									<td align="center" valign="top">
										<table width="100%" border="0" cellpadding="5" cellspacing="1">

											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Name<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input name="name"
													id="name"
													value="<?= !empty($arryPage[0]['name'])?stripslashes($arryPage[0]['name']):''; ?>"
													type="text" class="inputbox disabled" size="50" readonly/> <?php if(!empty($errors['name'])){echo $errors['name'];}?>
												</td>
											</tr>

											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Price $ </td>
												<td width="56%" align="left" valign="top"><input
													name="price" id="price"
													value="<?= !empty($arryPage[0]['price'])?stripslashes($arryPage[0]['price']):''; ?>"
													type="text" class="inputbox" size="50" maxlength="10" onkeypress="return isNumberKey(event);" /> <?php if(!empty($errors['price'])){echo $errors['price'];}?>
												</td>
											</tr>


											

											<tr style="display:none;">
												<td width="30%" align="right" valign="top" class="blackbold">
													Duration</td>
												<td width="56%" align="left" valign="top"><input
													name="duration" id="duration"
													value="<?= !empty($arryPage[0]['duration'])?stripslashes($arryPage[0]['duration']):''; ?>"
													type="text" class="inputbox" size="50" /> <?php //if(!empty($errors['duration'])){echo $errors['duration'];}?>
												</td>
											</tr>


										    <tr style="display:none;">
												<td align="right" valign="middle" class="blackbold">Package
													Type<span class="red">*</span></td>
												<td align="left" valign="middle"><select name="package_type"
													id="package_type" class="textbox">
														<option value="">Please Select</option>

														<?php foreach($packl as $pKey=>$pValue){?>
														<option value="<?php echo $pValue['id'];?>"
														<?php if($pValue['id']== $arryPage[0]['package_type']){echo 'selected="selected"';}?>>
															<?php echo $pValue['name'];?>
														</option>
														<?php }?>

												</select> <?php if(!empty($errors['package_type'])){echo $errors['package_type'];}?>
												</td>
											</tr>


										   <tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Please Choose Feature<span class="red">*</span> <?php foreach($packFeatureLt as $plKey=>$plValue){?>
											</td>
											
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
												<?php echo $plValue['feature'];?>
												</td>
												<td width="56%" align="left" valign="top"><input
													name="feature[]" id="feature"
													value="<?php echo $plValue['ModuleID'];?>"
													type="<?php echo $plValue['type'];?>" class="inputbox"
													size="50"
													/<?php if(in_array($plValue['ModuleID'],$arr)){echo 'checked="checked"';}?>>
													<?php if(!empty($errors['feature'])){echo $errors['feature'];}?>
												</td>
											</tr>

											<?php } ?>


											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Allow Users</td>
												<td width="56%" align="left" valign="top"><input
													name="allow_users" id="allow_users"
													value="<?= !empty($arryPage[0]['allow_users'])?stripslashes($arryPage[0]['allow_users']):''; ?>"
													type="text" class="inputbox" size="50" onkeypress="return isNumberKey(event);" /> <?php if(!empty($errors['allow_users'])){echo $errors['allow_users'];}?>
												</td>
											</tr>

											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Free Spaces</td>
												<td width="56%" align="left" valign="top"><input
													name="space" id="space"
													value="<?= !empty($arryPage[0]['space'])?stripslashes($arryPage[0]['space']):''; ?>"
													type="text" class="inputbox" size="50" onkeypress="return isNumberKey(event);"/> IN GB <?php if(!empty($errors['space'])){echo $errors['space'];}?>
												</td>
											</tr>

											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Additional Space Price $</td>
												<td width="56%" align="left" valign="top"><input
													name="additional_spaceprice" id="additional_spaceprice"
													value="<?= !empty($arryPage[0]['additional_spaceprice'])?stripslashes($arryPage[0]['additional_spaceprice']):''; ?>"
													type="text" class="inputbox" size="50" onkeypress="return isNumberKey(event);" /> Per 10 GB <?php if(!empty($errors['additional_spaceprice'])){echo $errors['additional_spaceprice'];}?></td>
											</tr>

											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Short Description</td>
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
													</textarea>
												</td>
											</tr>


<?php 
  $arrayPlanDuration = explode(",",$arryPage[0]['PlanDuration']);
?>							
<tr>

<td align="right" valign="top" class="blackbold">Plan Duration: </td>
<td align="left" style="line-height:26px;">

<label><input type="checkbox" value="user/month"  name="PlanDuration[]"<?php if(in_array("user/month",$arrayPlanDuration)){echo 'checked="checked"';}?>> user/monthly <br></label>

<label><input type="checkbox" value="user/quarter"  name="PlanDuration[]" <?php if(in_array("user/quarter",$arrayPlanDuration)){echo 'checked="checked"';}?>> user/quarterly <br></label>

<label><input type="checkbox" value="user/halfyear" name="PlanDuration[]" <?php if(in_array("user/halfyear",$arrayPlanDuration)){echo 'checked="checked"';}?>>user/half yearly <br></label>

<label><input type="checkbox" value="user/year" name="PlanDuration[]" <?php if(in_array("user/year",$arrayPlanDuration)){echo 'checked="checked"';}?>>user/yearly<br></label>

 <?php if(!empty($errors['PlanDuration'])){echo $errors['PlanDuration'];}?>

</td>

 </tr>	




										</table>
									</td>
								</tr>


							</table></td>
					</tr>
					<tr>
						<td align="center" height="135" valign="top"><br> <? if ($_GET['edit'] > 0) {
							$ButtonTitle = 'Update';
						} else {
							$ButtonTitle = 'Submit';
						} ?> <input type="hidden" name="id" id="id" value="<?= $id; ?>" />
							<input name="Submit" type="submit" class="button" id="SubmitPage"
							value=" <?= $ButtonTitle ?> " />&nbsp;</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</form>
