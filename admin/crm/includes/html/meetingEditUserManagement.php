<div id="AddUser" style="min-height: 240px;">
		<form name="form3" action=""  method="post" onSubmit="" >
		<table width="100%"  border="0" align="left" cellpadding="0" cellspacing="0" class="borderall">
			<input type="hidden" name="id" value="<?=$userData[0]['id']?>" />
			<tr>
				 <td colspan="4" align="left" class="head">Update User</td>
			</tr>
			
			<tr>
				 <td align="left"   class="blackbold" width="20%">Email:</td>
				 <td   align="left" width="40%">
				 <input id="email" name="email" class="disabled inputbox" value="<?=$userData[0]['email']?>" readonly>
				 </td>
			</tr>
			
		    <tr>
				 <td align="left"   class="blackbold" width="20%">First Name:</td>
				 <td   align="left" width="40%">
				 <input id="first_name" name="first_name" class="inputbox" value="<?=$userData[0]['first_name']?>">
				 </td>
			</tr>
			
			<tr>
				 <td align="left"   class="blackbold" width="20%">Last Name:</td>
				 <td   align="left" width="40%">
				 <input id="last_name" name="last_name" class="inputbox" value="<?=$userData[0]['last_name']?>">
				 </td>
			</tr>
			
			 <tr>
				 <td align="left"   class="blackbold" width="20%">Type:</td>
				 <td   align="left" width="40%">
				 <input type="radio" id="type" name="type" class="" value="1" <?php if($userData[0]['type']) echo "checked";?> > Basic 
				 <input type="radio" id="type1" name="type" class="" value="2" <?php if($userData[0]['type']==2) echo "checked";?> > Pro <br/>
				 </td>
			</tr>
			
		    <tr>
		        <td   align="center" width="40%" colspan="2">
		        	<br/>
					<input name="confirmUpdateUser" type="submit" class="button" id="confirmUpdateUser" value="Update" /> 
				</td>
		    </tr>
		</table>
		</form>
	</div>