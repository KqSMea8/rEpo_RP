<?php
/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * Description: For user_form.php
 */

?>
<style> .error-message {
    color: red;
    margin-left: 8px;
}
</style>
<?php  if(!empty($_SESSION['msg'])){   ?>
<div style="text-align:center;color:red"> <?php echo $_SESSION['msg']; ?></div>
<?php }?>
<table width="97%" border="0" align="center" cellpadding="0"
  
	cellspacing="0">
	<form name="form1" action="" method="post" onSubmit="" enctype="multipart/form-data">
	<tr>
		<td align="center" valign="top">


		<table width="80%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="2" align="left" class="head">Company Details</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">CompanyName :<span class="red">*</span></td>
				<td align="left"><?php echo $FormHelper->input(__('userFname'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userFname', 'maxlength' => 50, 'value' => stripslashes($arryUser->name)));
				?></td>
			</tr>
<?php if(!empty($_GET['edit'])) {?>
<tr>
				<td align="right" class="blackbold" width="35%">Email :</td>
				<td align="left"><?php echo $FormHelper->input(__('userContacts'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userContacts', 'maxlength' => 50,  disabled,'readonly'=>'readonly', 'value' => stripslashes($arryUser->email)));
				?>
			</tr>
			
<?php }else { ?>
<tr>
				<td align="right" class="blackbold">Email :<span class="red">*</span></td>
				<td align="left"><?php echo $FormHelper->input(__('userContacts'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userContacts','maxlength' => 50, 'value' => stripslashes($arryUser->email)));
				?></td>
			</tr>

<?php } ?>
			<tr>
				<td align="right" class="blackbold" valign="top">ExpireDate :<span
					class="red">*</span></td>
				<td align="left"><?php echo $FormHelper->input(__('userAddress'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'datepicker', 'maxlength' => 50, 'value' => stripslashes($arryUser->expire_date)));
				?></td>
			
			</tr>
                        <?php if(!empty($_GET['edit'])) {?>
                        <tr>
				<td align="right" class="blackbold" valign="top">Number Of User :<span
					class="red">*</span></td>
				<td align="left"><?php echo $FormHelper->input(__('userNumber'), array('type' => 'text', 'class' => 'inputbox', 'id' => 'userFname', 'maxlength' => 50, 'value' => stripslashes($arryUser->allow_users)));
				?></td>
			
			</tr>
                        <?php }?>
			<!--<tr>
				<td align="right" class="blackbold">Package :<span class="red">*</span></td>
				<td align="left"><?php echo $FormHelper->input(__('userPackageId'), array('type' => 'select', 'class' => 'inputbox', 'id' => 'userPackageId', 'maxlength' => 50, 'options' => $package));
				?></td>
			</tr>

			<tr>
				<td colspan="2" align="left" class="head">Account Details</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">User Name :<span class="red">*</span>
				</td>
				<td align="left"><?php //echo $FormHelper->input(__('userDispalyname'), array('type' => 'inputbox', 'class' => 'inputbox', 'id' => 'userDispalyname', 'maxlength' => 50, 'value' => stripslashes($arryUser->userDispalyname)));
				?></td>
			</tr>-->
<?php if(!empty( $_GET['edit'])) {?>

			

			

<?php }else {?>

			<tr>
				<td align="right" class="blackbold">Password :<span class="red">*</span>
				</td>
				<td align="left"><?php echo $FormHelper->input(__('userPwd'), array('type' => 'password', 'class' => 'inputbox', 'id' => 'userPwd', 'maxlength' => 50, 'value' => stripslashes($arryUser->userPwd)));
				?></td>
			</tr>

<?php }?>

			<tr>
				<td align="right" class="blackbold">Status :</td>
				<td align="left"><? 
				$ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryUser->status == 'Active') {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryUser->status == 'Inactive') {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			 }
		  ?> 
		  <label><input type="radio" name="status" id="status" value="Active"
		  <?=$ActiveChecked?> /> Active</label>&nbsp;&nbsp;&nbsp;&nbsp; 
		  <label><input type="radio" name="status" id="status" value="Inactive" <?=$InActiveChecked?> /> InActive</label></td>
			</tr>


                        <tr>
				<td align="right" class="blackbold">Membership Type :</td>
				<td align="left"> <?php
				$activeChecked = 'checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryUser->membership_type == 'demo') {$activeChecked = 'checked'; $InactiveChecked ='';}
				 if($arryUser->membership_type == 'subscribe') {$activeChecked = ''; $InactiveChecked = 'checked';}
			 }?>
		 
                                    <label><input type="radio" name="membership_type" id="membership_type" value="demo" <?=$activeChecked?> />
		   Demo</label>&nbsp;&nbsp;&nbsp;&nbsp; 
		  <label><input type="radio" name="membership_type" id="membership_type" value="subscribe"<?=$InactiveChecked?>  />Subscribe</label></td>
			</tr>


		</table>

		</td>
	</tr>

	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>

	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
		<input name="Submit" type="submit" class="button" id="SubmitButton"value=" <?=$ButtonTitle?> " /> <input type="hidden" name="userID"
			id="userID" value="<?=$_GET['edit']?>" /> </div>

		</td>
	</tr>
	</form>
</table>
<?php unset($_SESSION['msg']); ?>