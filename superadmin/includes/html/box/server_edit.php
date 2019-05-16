<script language="JavaScript1.2" type="text/javascript">
   function validate(frm){
    if( ValidateForSimpleBlank(frm.name, "Name") 
        && ValidateForSimpleBlank(frm.ip,"IP") 
            && ValidateForSimpleBlank(frm.port,"Port")
                && ValidateForSimpleBlank(frm.username,"Username") 
                    && ValidateForSimpleBlank(frm.password,"Password"))
    {
            ShowHideLoader('1','S');
            return true;    
        }else{
            return false;   
        }   
   }
</script>
<div class="right_box">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" method="post" onSubmit="return validate(this);"><input
		name="id" type="hidden" id="id"
		value="<?php echo !empty($arryServer[0]['id'])?$arryServer[0]['id']:0; ?>" />
	<tr>
		<td align="center" valign="top">
		<table width="80%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="2" align="left" class="head">Server Details</td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Server Name :<span class="red">*</span>
				</td>
				<td align="left"><input name="name" type="text" class="inputbox"
					id="name"
					value="<?php echo stripslashes($arryServer[0]['name']); ?>"
					maxlength="50" /></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">IP :<span class="red">*</span></td>
				<td align="left"><input name="ip" type="text" class="inputbox"
					id="ip" value="<?php echo stripslashes($arryServer[0]['ip']); ?>"
					maxlength="50" /></td>
			</tr>
			

			
			<tr>
				<td align="right" class="blackbold">Port :<span class="red">*</span>
				</td>
				<td align="left"><input name="port" type="text"
					class="inputbox onlyNumber" id="port"
					value="<?php echo stripslashes($arryServer[0]['port']); ?>"
					maxlength="50" /></td>
			</tr>
			
						
			<tr>
				<td align="right" class="blackbold">URL :<span class="red">*</span></td>
				<td align="left"><input name="url" type="text" class="inputbox"
					id="url" value="<?php echo stripslashes($arryServer[0]['url']); ?>"
					maxlength="50" /></td>
			</tr>
			
			
			
			<tr>
				<td align="right" class="blackbold">Username :<span class="red">*</span>
				</td>
				<td align="left"><input name="username" type="text" class="inputbox"
					id="username"
					value="<?php echo stripslashes($arryServer[0]['username']); ?>"
					maxlength="50" /></td>
			</tr>
			<tr>
				<td align="right" class="blackbold">Password :<span class="red">*</span>
				</td>
				<td align="left"><input name="password" type="text" class="inputbox"
					id="password"
					value="<?php echo stripslashes($arryServer[0]['password']); ?>"
					maxlength="50" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Status :<span class="red">*</span>
				</td>
				<td><label><input type="radio" name="status" value="1"
				<?php echo !empty($arryServer[0]['status'])?'Checked':''; ?> />
				Active</label>&nbsp;&nbsp;&nbsp;&nbsp; <label><input type="radio"
					name="status" value="0"
					<?php echo empty($arryServer[0]['status'])?'Checked':''; ?> />
				InActive</label></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Type:<span class="red">*</span>
				</td>
				<td align="left">
				<select id="ServerType" class="inputbox" name="ServerType">
					<option value="">--- Select ---</option>
					<option value="1" <?if($arryServer[0]['ServerType']==1){echo "selected='selected'";}?>>EZNETERP</option>
					<option value="2" <?if($arryServer[0]['ServerType']==2){echo "selected='selected'";}?>>EZNETCRM</option>
					<option value="3" <?if($arryServer[0]['ServerType']==3){echo "selected='selected'";}?>>BLOG</option>
					<option value="4" <?if($arryServer[0]['ServerType']==4){echo "selected='selected'";}?>>ECOMMERCE</option>
			
				</select>
				
				</td>
			</tr>
			
			
			<tr>
				<td align="right" class="blackbold">Fixed:<span class="red">*</span>
				</td>
				<td align="left">
				<select id="Fixed" class="inputbox" name="Fixed">
					<option value="">--- Select ---</option>
					<option value="0" <?if($arryServer[0]['Fixed']==0){echo "selected='selected'";}?>>UNFIXED</option>
					<option value="1" <?if($arryServer[0]['Fixed']==1){echo "selected='selected'";}?>>FIXED</option>
				
				</select>
				
				</td>
			</tr>
			
			
			


			<tr>
				<td colspan=2 align="center"><input name="Submit" type="submit"
					class="button" id="SubmitButton" value="Save" /></td>
			</tr>


		</table>
		</td>
	</tr>
	</form>
</table>
</div>

