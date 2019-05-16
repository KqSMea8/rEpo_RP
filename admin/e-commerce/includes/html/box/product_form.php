<div class="e_right_box">
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<form name="form1" id="productBasicInfoForm" action=""
						method="post" enctype="multipart/form-data">
					<tr>
						<td align="center" valign="top">
						<table width="100%" border="0" cellpadding="3" cellspacing="1"
							class="borderall">
							<tr>
								<td colspan="2" align="left" class="head">Basic Properties</td>
							</tr>
							<tr>
								<td height="30" class="blackbold" align="right">Product Type:</td>
								<td><select name="product_type" id="product_type"
									class="inputbox" onchange="getSecureType();">
									<option value="Physical">Physical</option>
									<option value="Virtual">Virtual</option>
								</select></td>
							</tr>
							<tr id="td_secure_type" style="display: none">
								<td height="30" class="blackbold" align="right">Secure Type:</td>
								<td><select name="secure_type" id="secure_type" class="inputbox">
									<option value="Secure">Secure</option>
									<option value="Unsecure">Unsecure</option>
								</select></td>
							</tr>
							<tr id="td_virtual_file" style="display: none">
								<td height="30" class="blackbold" align="right">File: <span class="red">*</span></td>
								<td><input name="virtual_file" type="file" class="inputbox" id="virtual_file" />
<br/><span>(Supported file types are: .pdf)</span>
</td>
							</tr>
							<tr>
								<td width="40%" align="right" class="blackbold">Product Category
								: <span class="red">*</span></td>
								<td width="60%" height="30" align="left"><select
									name="CategoryID" id="CategoryID" class="inputbox">
									<option value="">Select Category</option>
									<?php

									$objCategory->getCategories(0,0,$_GET['ParentID']);
									?>
								</select></td>
							</tr>
							<tr>
								<td width="31%" align="right" class="blackbold">Product Name : <span
									class="red">*</span></td>
								<td width="69%" height="30" align="left"><input name="Name"
									id="Name"
									value="<? echo stripslashes($arryProduct[0]['Name']); ?>"
									type="text" class="inputbox" size="30" maxlength="100" /></td>
							</tr>
							<tr>
								<td align="right" class="blackbold">Product Sku : <span
									class="red">*</span></td>
								<td height="30" align="left"><input name="ProductSku"
									id="ProductSku"
									value="<? echo stripslashes($arryProduct[0]['ProductSku']); ?>"
									type="text" class="inputbox"
									onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);"
									onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','ProductSku','');"
									size="30" maxlength="40" /> <span id="MsgSpan_ModuleID"></span>

								</td>
							</tr>
							<tr>
								<td height="30" align="right" class="blackbold">Price : <span
									class="red">*</span></td>
								<td align="left"><input name="Price" type="text"
									class="inputbox" id="Price"
									value="<? echo $arryProduct[0]['Price']; ?>"
									onkeyup="keyup(this);" size="10" maxlength="10"> <?= $Config['Currency']; ?></td>
							</tr>
							<tr>
								<td height="30" align="right" class="blackbold">Sale Price :</td>
								<td align="left"><input name="Price2" type="text"
									class="inputbox" id="Price2"
									value="<? echo $arryProduct[0]['Price2']; ?>" size="10"
									maxlength="10"> <?=$Config['Currency']; ?></td>
							</tr>
							<tr>
								<td height="70" align="right" valign="top" class="blackbold">
								Product Image :</td>
								<td height="50" align="left" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="66%" class="blacknormal" valign="top"><input
											name="Image" type="file" class="inputbox" id="Image"
											size="25" onkeypress="javascript: return false;"
											style="width: 183px;" onkeydown="javascript: return false;"
											oncontextmenu="return false" ondragstart="return false"
											onselectstart="return false"> <br>
											<?= $MSG[201] ?></td>
										<td width="34%"><? if ($arryProduct[0]['Image'] != '' && file_exists('../../upload/products/images/' . $arryProduct[0]['Image'])) { ?>
										<a
											href="Javascript:OpenNewPopUp('../../showimage.php?img=upload/products/images/<? echo $arryProduct[0][Image]; ?>', 150, 100, 'yes' );"><? echo '<img src="../../resizeimage.php?w=100&h=100&img=upload/products/images/' . $arryProduct[0]['Image'] . '" border=0  >'; ?></a>
											<? } ?></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td height="30" class="blackbold" align="right">File Upload</td>
								<td><input type="checkbox" name="is_upld" id="is_upld"
								<?php if($arryProduct[0]['is_upld'] == "1"){echo "checked";} ?>
									onclick="getUploadType(this.value);" value="1"></td>
							</tr>
							<?php if($arryProduct[0]['is_upld'] == "1"){$style='';}else{ $style='style="display:none;"';} ?>
							<tr id="label_up" <?=$style?>>
								<td height="30" class="blackbold" align="right">Label</td>
								<td><input type="text" class="inputbox" name="label_txt"
									id="label_txt"
									value="<? echo stripslashes($arryProduct[0]['label_txt']); ?>"></td>
							</tr>
							<tr>
								<td align="right" class="blackbold">Status :</td>
								<td height="30" align="left"><span class="blacknormal"> <?
								$ActiveChecked = ' checked';
								if ($_GET['edit'] > 0) {
									if ($arryProduct[0]['Status'] == 1) {
										$ActiveChecked = ' checked';
										$InActiveChecked = '';
									}
									if ($arryProduct[0]['Status'] == 0) {
										$ActiveChecked = '';
										$InActiveChecked = ' checked';
									}
								}
								?> <input type="radio" name="Status"
									style="vertical-align: text-top; width: 10px;" id="Status"
									value="1" <?= $ActiveChecked ?>> Active&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="Status"
									style="vertical-align: text-top; width: 10px; margin-left: 20px;"
									id="Status" value="0" <?= $InActiveChecked ?>> InActive </span></td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td height="54" align="center"><br>
						<?php
						if ($_GET['edit'] > 0)
						$ButtonTitle = 'Update'; else
						$ButtonTitle = 'Submit';

$PostedByID = (!empty($arryProduct[0]['PostedByID'])?($arryProduct[0]['PostedByID']):(''));

						if ($PostedByID <= 1)
						$PostedByID = 1;

						if (sizeof($arryCategory) <= 0)
						$DisabledButton = 'disabled';
						?> <input name="Submit" type="button" class="button"
							id="SubmitButton" value=" <?= $ButtonTitle ?> "
							<?= $DisabledButton ?> /> <input type="hidden" name="ProductID"
							id="ProductID" value="<? echo $_GET['edit']; ?>" /> <input
							type="hidden" name="MaxProductImage" id="MaxProductImage"
							value="<? echo $MaxProductImage; ?>" /> <input type="hidden"
							name="OldStatus" id="OldStatus"
							value="<?= $arryProduct[0]['Status'] ?>"> <input type="hidden"
							name="NumLanguages" id="NumLanguages"
							value="<?= $NumLanguages ?>" /> <input type="reset" name="Reset"
							value="Reset" class="button" /></td>
					</tr>
					</form>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
<script>
function getUploadType(EntryType){

    if(document.getElementById("is_upld").checked)
        {
            document.getElementById("label_up").style.display='';
            
        }else{
            document.getElementById("label_up").style.display='none';
            
        }
     
 }
function getSecureType(){
	if($('#product_type').val()=='Virtual'){
		$('#td_secure_type').show();
		$('#td_virtual_file').show();
		
	}else{
		$('#td_secure_type').hide();
		$('#td_virtual_file').hide();
	}
}
</script>


