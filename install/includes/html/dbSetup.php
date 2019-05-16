<script language="JavaScript1.2" type="text/javascript">
function isDatabaseName(formInput) {
   var reg = /^[A-Za-z0-9_\-\.]+$/;

   var address = formInput.value;
   if(reg.test(address) == false) {
	  alert("Please Enter only alphanumeric characters for Database Name.");  
	  formInput.select();
      return 0;
   }
	return 1;
}


function validateForm(frm){

	if( ValidateMandRange(frm.DbHost, "Database Host",5,50)
	&& ValidateMandRange(frm.DbUser,"Username",3,30)
	&& ValidateMandRange(frm.DbPassword,"Password",3,30)
	&& ValidateMandRange(frm.DbName, "Database Name",3,30)
	&& isDatabaseName(frm.DbName)		
	){  	
		ShowHideLoader(1,'D');
		return true;					
	}else{
		return false;	
	}	

		
}
</script>



<? 
$Step2 = 'class=active';
require_once("includes/nav.php");
?>

<? if(!empty($_SESSION['mess_db'])) { ?>
<div class="redmsg" align="center"><? echo $_SESSION['mess_db']; unset($_SESSION['mess_db']); ?></div>
<? }?>

<br><br><br>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<tr>
    <td align="left" class="success" valign="top" >	
		<?=LICENSE_VERIFIED?>
	</td>
   </tr>

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	 <tr>
       		 <td colspan="2" align="left" class="head">Database Setup</td>
        </tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
        <td  align="right"   class="blackbold" width="45%">Database Host :<span class="red">*</span> </td>
        <td   align="left" ><input name="DbHost" type="text" class="inputbox" id="DbHost" value="<?php echo stripslashes($_POST['DbHost']); ?>"  maxlength="50" /> </td>
      </tr>		 
	  <tr>

	 <tr>
        <td  align="right"   class="blackbold">Username :<span class="red">*</span> </td>
        <td   align="left" ><input name="DbUser" type="text" class="inputbox" id="DbUser" value="<?php echo stripslashes($_POST['DbUser']); ?>"  maxlength="30" /></td>
      </tr>	

	 <tr>
        <td  align="right"   class="blackbold">Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="DbPassword" type="Password" class="inputbox" id="DbPassword" value=""  maxlength="30" /></td>
      </tr>
	
   <tr>
        <td  align="right"   class="blackbold"> Database Name  :<span class="red">*</span> </td>
        <td   align="left" >
<?=$Config['DbName'].'_';?> <input name="DbName" type="text" class="textbox" style="width:162px;" id="DbName" value="<?php echo stripslashes($_POST['DbName']); ?>"  maxlength="30" />

</td>
      </tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	
</table>	
  

	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center">
	<input name="Submit" type="submit" value="Continue &raquo;" class="button" />		

   </td>
   </tr>
   </form>
</table>

