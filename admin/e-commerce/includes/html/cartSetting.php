<?php
$compDisplayname=$_SESSION['DisplayName'];
$ErpDomain='';
if($arrydomain[0]['ErpDomain']!=''){
	$ErpDomain='http://www.eznetcrm.com/ecom_latest/'.$compDisplayname.'/';
}
$module= $_REQUEST['module'];
?>
<div class="had"><?= $ModuleName; ?></div>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td align="center" valign="top">
		<form name="form1" action="" method="post"
			enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" class="message"><?php if (!empty($_SESSION['mess_cart'])) { ?><?= $_SESSION['mess_cart'];
				unset($_SESSION['mess_cart']); ?><?php } ?></td>
			</tr>
			<tr>
				<td align="center" valign="middle">

				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="borderall">

					<tr>
						<td align="center" valign="top"><?php

						if (count($arryCartSettingFields) > 0) { ?>
						<table width="100%" border="0" cellpadding="5" cellspacing="1">
						<?php foreach ($arryCartSettingFields as $field) {
							$it = strtolower($field["input_type"]);
							?>
							<tr>
								<td width="30%" align="right" valign="top" class="blackbold"><?= $field['Caption'] ?>
								: <?php if($field['Validation'] == "Yes") { ?><span class="red">*</span>
								<?php }?></td>

								<td width="56%" align="left" valign="top"><?php
								switch ($it) {
									case "select" : {
										$v = explode(",", $field["Options"]);
										$short = strtolower($field["Options"]) == 'yes, no' || strtolower($field["Options"]) == 'yes,no';
										?><select name="<?= $field["Name"] ?>"
									id="<?= $field["Name"] ?>" class="inputbox">

									<?php
									for ($i = 0; $i < count($v); $i++) {
										$v[$i] = trim($v[$i]);
										if ($v[$i] != "") {
											echo '<option value="' . $v[$i] . '" ' . ($field["Value"] == $v[$i] ? "selected=\"selected\"" : "") . '>' . ucfirst(strtolower($v[$i])) . '</option>';
										}
									}
									?>
								</select> <?php
								break;
									}
case "textarea" : {
	?> <textarea class="inputbox" style="width: 60%; height: 85px;"
									name="<?= $field["Name"] ?>" id="<?= $field["Name"] ?>"><?=$field["Value"];?></textarea>

									<?php
									break;
}
case "stextarea" : {
	?> <textarea class="inputbox" style="width: 60%; height: 85px;"
									name="<?= $field["Name"] ?>" id="<?= $field["Name"] ?>"><?=$field["Value"];?></textarea>
								<div class="formItemComment"><a href="javascript:void(0)"
									onclick="generatecode();">Generate</a> a redirect code. Paste this code in your index.html file to redirect to your main domain.</div>
								<?php
								break;
}

default :
case "text" : {
	?> <input type="text" name="<?= $field["Name"] ?>"
									id="<?= $field["Name"] ?>" class="inputbox"
									value="<?=$field["Value"];?>"> <?php
									break;
}
								}
								/* if (trim($field["Description"] != "")) {
								 ?>
								 <div class="formItemComment">
								 <?= str_replace("\n", '<br/>', htmlspecialchars(str_replace("<br/>", "\n", $field["Description"]))) ?>
								 </div>
								 <?php
								 }*/
								?></td>
							</tr>

							<?php } ?>
							<?php if($module==1){?>
							<tr>
								<td width="30%" valign="top" align="right" class="blackbold">
								Domain :</td>

								<td width="56%" valign="top" align="left"><a href="<?php echo $ErpDomain;?>" target="_new"><?php echo $ErpDomain;?></a>
								</td>
							</tr>

							
							<?php }?>
						</table>
						<?php } ?></td>
					</tr>
				</table>


				</td>
			</tr>
			<tr>
				<td align="center" height="135" valign="top"><br>
				<? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Save'; ?>
				<input type="hidden" name="CartSettingId" id="CartSettingId"
					value="<?php echo $CartSettingId; ?>"> <input name="Submit"
					type="submit" class="button" id="SaveCartSettings_<?=$groupId;?>"
					value=" <?= $ButtonTitle ?> " />&nbsp;</td>
			</tr>

		</table>
		</form>
		</td>
	</tr>

</table>
<script>
function generatecode(domain){
	var domain='<?php echo $ErpDomain;?>';
	if(domain!=''){
	var content='<!DOCTYPE html><html><head><meta http-equiv="refresh"  content="0; url='+domain+'"></head></html>';
	$('#DRedirect').val(content);
	}else{
		alert('domain name not avilable.');
	}
}


	function isNumberKey(evt,inputfield)
	{
		 
	   var charCode = (evt.which) ? evt.which : event.keyCode
		
	           if (charCode == 46)
	           {
	               var inputValue = $("#"+inputfield).val()
	               if (inputValue.indexOf('.') < 1)
	               {
	                   return true;
	               }
	               return false;
	           }       
	   if (charCode > 31 && (charCode < 48 || charCode > 57))
	      return false;

	   return true;
	}


</script>
