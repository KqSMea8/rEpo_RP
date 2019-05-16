<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	if( ValidateForSimpleBlank(frm.IndustryName, "Industry Name")
		&& ValidateForSelect(frm.Parent, "Account GL")
){
				
				var Url = "isRecordExists.php?IndustryName="+escape(document.getElementById("IndustryName").value)+"&editID="+document.getElementById("IndustryID").value;
				SendExistRequest(Url, "IndustryName", "Industry Name");
				return false;	
			}else{
				return false;	
		}			
}


</script>


 
<div class="clear"></div>
<div class="had">Manage Industry <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add  ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_industry'])) {echo $_SESSION['mess_industry']; unset($_SESSION['mess_industry']); }?>
</div>

<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm(this);">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
	<td align="center" valign="top">
	    <table width="100%" border="0" cellpadding="0" cellspacing="0">
	      <tr>
		<td align="center" valign="middle">
		   <div align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
			</div>
			  <br>
		   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">			
		     <tr>
		       <td align="center" valign="top">
				<table width="100%" border="0" cellpadding="5" cellspacing="1">
		<tr>                              
			<td  width="45%" align="right"   class="blackbold"> Industry Name   :<span class="red">*</span> </td>                         	
			<td width="56%" align="left" valign="top"><input name="IndustryName" id="IndustryName" type="text" class="inputbox" size="50" maxlength="50"
			value="<?= stripslashes($arryeditIndustry[0]['IndustryName']) ?>"/> 									 
			</td>
		</tr>
		<tr>
			<td  width="45%" align="right"   valign="top" class="blackbold">  Description   :</td> 
			<td  align="left" >
			<textarea name="Description" class="bigbox" id="Description" maxlength="200"><?=stripslashes($arryeditIndustry[0]['Description'])?></textarea></td>
		</tr>
<?php if(($_GET['edit']=='') || ($_GET['edit']>100) ) { ?>				
		<tr>
			<td align="right" class="blackbold">Copy GL Account From :<span
			class="red">*</span></td>
			<td align="left"><select name="Parent" id="Parent"
			class="textbox" style="width: 200px">
			                                   <option value=""> --- Select ---</option>
			<?php foreach ($arryIndustryName as $arryIndustryName){
			//echo "<pre>";print_r($arryIndustryName);die('abbas');
			?>
			<option value="<?=$arryIndustryName['IndustryID']?>"
			<?php if($arryeditIndustry[0]['Parent']==$arryIndustryName['IndustryID']){echo "selected='selected'";}?>><?php echo $arryIndustryName['IndustryName']?></option>
			
			<?php } ?>
				</select></td>
		</tr>										
<?php }?>	
			
		<tr>
				<td align="right" valign="middle" class="blackbold">Status :</td>
				<td align="left" class="blacknormal">
					<table width="151" border="0" cellpadding="0" cellspacing="0"
					class="blacknormal margin-left">
						<tr>
							<td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($IndustryStatus == "1") ? "checked" : "" ?> /></td>								
							<td width="48" align="left" valign="middle">Active</td>
							<td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($IndustryStatus == "0") ? "checked" : "" ?> value="0" /></td>
							<td width="63" align="left" valign="middle">Inactive</td>
						</tr>
					</table>
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
						} ?> 
					
					<input type="hidden" name="IndustryID" id="IndustryID" value="<?= $IndustryID; ?>" /> 
					
					<input name="Submit" type="submit" class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />
					
					
					</td>
					</tr>

		           </table>
		</td>
	</tr>
</table>
</form>
