<?php  if($HideNavigation!=1){?>
<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">Contact <span>&raquo; <? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>

</span></div>
<?php }?>
<? if (!empty($errMsg)) {?>
<div align="center" class="red"><?php echo $errMsg;?></div>
<? } ?>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_contact'])) { 
    echo $_SESSION['mess_contact'];
    unset($_SESSION['mess_contact']);
} ?></div>





<script language="JavaScript1.2" type="text/javascript">
function validateContact(frm){
	if(     ValidateForSimpleBlank(frm.FirstName, "first name")
                && ValidateForSimpleBlank(frm.Email, "Email") && isEmail(frm.Email)
		){
			return true;
				
		}else{
			return false;	
		}	
}

function validateContactEdit(frm){
	if(     ValidateForSimpleBlank(frm.FirstName, "first name")
            && ValidateForSimpleBlank(frm.Email, "Email") && isEmail(frm.Email)
	){
		return true;
			
	}else{
		return false;	
	}	
		
}
</script>

<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post"
		onSubmit="<?php if(empty($_GET['edit'])) {?> return validateContact(this);<?php } else {?> return validateContactEdit(this); <?php }?>"
		enctype="multipart/form-data">


	<tr>
		<td align="center" valign="top">


		<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
                                <td colspan="4" align="left" class="head"><?php if(empty($arryEmailId[0]['FirstName'])) {echo "Add";} else { echo "Edit";} ?> Contact Information</td>
			</tr>

			<tr>
				<td align="right" class="blackbold">First Name :<span class="red">*</span>
				</td>
				<td align="left"><input name="FirstName" type="text"
					class="inputbox" id="FirstName"
					value="<?php if(isset($_REQUEST['FirstName'])) echo $_REQUEST['FirstName']; else echo $arryEmailId[0]['FirstName'];?>"
					maxlength="80" onkeypress="return isCharKey(event);" /></td>

			</tr>
			<tr>
				<td align="right" class="blackbold">Last Name :
				</td>
				<td align="left"><input name="LastName" type="text"
					class="inputbox" id="LastName"
					value="<?php if(isset($_REQUEST['LastName'])) echo $_REQUEST['LastName']; else echo $arryEmailId[0]['LastName'];?>"
					maxlength="80" /></td>

			</tr>

			<tr>
				<td align="right" class="blackbold">Email :<span class="red">*</span>
				</td>
				<td align="left"><input name="Email" type="email" class="inputbox"
					id="Email"
					value="<?php if(isset($_REQUEST['Email'])) echo $_REQUEST['Email']; 
					elseif(isset($_GET['edit'])) echo $_GET['edit']; 
					else echo $arryEmailId[0]['Email'];?>"
					maxlength="80" /></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Nickname :
				</td>
				<td align="left"><input name="NickName" type="text" class="inputbox"
					id="NickName"
					value="<?php if(isset($_REQUEST['NickName'])) echo $_REQUEST['NickName']; else echo $arryEmailId[0]['NickName'];?>"
					maxlength="80" /></td>
			</tr>
		</table>

		</td>
	</tr>



	<tr>
		<td align="center">

		<div id="SubmitDiv" style="display: none1"><? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
		<input name="Submit" type="submit" class="button" id="SubmitButton"
			value=" <?=$ButtonTitle?> " /> <input type="hidden" name="AddID"
			id="AddID" value="<?=$_GET['edit']?>" /> <input type="hidden"
			name="AdminID" id="AdminID"
			value="<?php echo $_SESSION['AdminID']; ?>" /> <input type="hidden"
			name="AdminType" id="AdminType"
			value="<?php echo $_SESSION['AdminType']; ?>" />
                <input type="hidden"
			name="hiddenFname" id="AdminType"
			value="<?php echo $arryEmailId[0]['FirstName']; ?>" />
                
                </div>

		</td>
	</tr>
	</form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>




