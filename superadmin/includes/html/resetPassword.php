<SCRIPT LANGUAGE=JAVASCRIPT>
function SetClose(){
	parent.jQuery.fancybox.close();
}

</SCRIPT>

<SCRIPT LANGUAGE=JAVASCRIPT>
function validate()
{

if(document.getElementById("Password").value==''){
	alert('Please Enter Password');
	 return false;
}
if(document.getElementById("ConfirmPassword").value==''){
	alert('Please Enter Confirm Password');
	 return false;
}
	
}
</SCRIPT>


<? if(!empty($ErrorMsg)){
	echo '<div class="redmsg" align="center">'.$ErrorMsg.'</div>';
 }else{ ?>
<div class="had" style="margin-bottom:5px;">Reset Password for Employee: <?=stripslashes($arryEmployee[0]['UserName'])?> </div>

<form name="form1" action="" method="post" onSubmit="return validate();">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">

 <tr>
	<td colspan="2" class="blackbold" height="30"><div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_conf'])) {echo $_SESSION['mess_conf']; unset($_SESSION['mess_conf']); }?></div></td>
 </tr>
            
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" >

 <tr>
        <td  align="right"   class="blackbold" width="45%"> New Password : </td>
        <td   align="left" >
		<input name="Password" type="password"
						 class="inputbox" id="Password"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>
	</td>

 </tr>

	 <tr>
        <td  align="right"   class="blackbold"> Confirm Password : </td>
        <td   align="left" >
		<input name="ConfirmPassword" type="password" class="inputbox" id="ConfirmPassword"  value="" maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>
	</td>
      </tr>
      
       <input type="hidden" name="AdminID" value="<?php echo $_GET['cmp'];?>">
       <input type="hidden" name="UserID" value="<?php echo $_GET['emp'];?>">
       

           <tr>
              <td align="right"   class="blackbold">&nbsp;</td>
              <td align="left" ><input name="Submit" type="submit" value="Update" class="button" /></td>
            </tr>
 <tr>
              <td colspan="2"   class="blackbold">&nbsp;</td>
            </tr>


</table>		
	
	
	</td>

  </tr>
</table>
</form>
<? } ?>
