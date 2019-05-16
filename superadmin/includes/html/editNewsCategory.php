
<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>
<div class="had"><?=$ModuleName?> <span> &raquo; <? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
</span></div>

<? if (!empty($errMsg)) {?>
<div class="red"><?php echo $errMsg;?></div>
<? } ?>

<script language="JavaScript1.2" type="text/javascript">
function validateNewsCategory(frm){

	if( ValidateForSimpleBlank(frm.NewsCategoryName, "Category Name")){
				
				var Url = "isRecordExists.php?NewsCategoryName="+escape(document.getElementById("NewsCategoryName").value)+"&editID="+document.getElementById("CategoryID").value;
				SendExistRequest(Url, "NewsCategoryName", "Category Name");
				return false;	
			}else{
				return false;	
		}			
}
</script>

<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post"
		onSubmit="return validateNewsCategory(this);"
		enctype="multipart/form-data">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td align="right" class="blackbold" width="45%">Category Name :<span
					class="red">*</span></td>
				<td align="left"><input name="NewsCategoryName" type="text"
					class="inputbox" id="NewsCategoryName" size="50"
					value="<?php echo stripslashes($arryNewsCategory[0]['NewsCategoryName']); ?>"
					maxlength="30" onKeyPress="Javascript:return isAlphaKey(event);" />
				</td>
			</tr>

			<tr>
				<td align="right" class="blackbold" valign="top">Order : </td>
				<td align="left"><input name="OrderBy" type="text" class="textbox"
					size="7" id="OrderBy"
					value="<?=stripslashes($arryNewsCategory[0]['OrderBy'])?>"
					maxlength="4" onkeypress="return isNumberKey(event);" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Status :</td>
				<td align="left">
				<table width="151" border="0" cellpadding="0" cellspacing="0"
					style="margin: 0">
					<tr>
						<td width="20" align="left" valign="middle"><input name="Status"
							type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
						<td width="48" align="left" valign="middle">Active</td>
						<td width="20" align="left" valign="middle"><input name="Status"
							type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
						<td width="63" align="left" valign="middle">Inactive</td>
					</tr>
				</table>
				</td>
			</tr>

		</table>


		</td>
	</tr>

	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
		<input name="Submit" type="submit" class="button" id="SubmitButton"
			value=" <?=$ButtonTitle?> " /> <input type="hidden" name="CategoryID"
			id="CategoryID" value="<?=$_GET['edit']?>" /></div>

		</td>
	</tr>

	</form>
</table>


