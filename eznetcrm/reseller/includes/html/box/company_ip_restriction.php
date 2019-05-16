<?php	
    require_once("../../classes/company.class.php");	
    
    $objCompany=new company();
    
	$CmpID=$_GET['edit'];
    
		$RedirectUrl = 'editCompany.php?edit='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'].'&tab=ip';	
		
	
	if($_POST){	
		//CleanPost();	
		$objCompany->UpdateIpDetail($_POST,$CmpID);		
		$_SESSION['mess_ip'] = IP_SUBMIT_MSG;
		header("location:".$RedirectUrl);
		exit;
	}
	
	$arryCompany = $objCompany->GetCompany($CmpID,'');
?>


<script language="JavaScript1.2" type="text/javascript">

function SetPunching(){
		var PunchingBlock = document.getElementById('PunchingBlock').value;
		if(PunchingBlock == '0'){
			$('#TrPunching').hide();
		}else{
			$('#TrPunching').show();
		}
}
	
function SetLogin(){
	var LoginBlock = document.getElementById('LoginBlock').value;
	if(LoginBlock == '0'){
		$('#TrLogin').hide();
	}else{
		$('#TrLogin').show();
	}
}



</script>
<div class="had"><?=$MainModuleName?></div>



<form action="" method="post">	

<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  <? if (!empty($_SESSION['mess_ip'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? echo $_SESSION['mess_ip']; unset($_SESSION['mess_ip']); ?>	
</td>
</tr>
<? } ?>

<tr>
	 <td>




			  
<table width="100%" cellspacing="0" cellpadding="5" border="0" class="borderall">

<tr>
	 <td align="left" class="head" colspan="4">Punch In/Out</td>
</tr>
 
<tr>
	<td width="48%" align="right" class="blackbold">Block IP:</td>
	<td  valign="top" align="left">
	<select name="PunchingBlock"  id="PunchingBlock" class="textbox" onchange="SetPunching()" >
	<option value="0"  >No</option>
	<option value="1" <?php if($arryCompany[0]['PunchingBlock']=='1') {echo 'selected';} ?> >Yes</option>
	</select>
	</td>
   
</tr>
 
 
                 
<tr id="TrPunching" style="display:none;">
	
    <td  align="right" class="blackbold" valign="top">Allow IP Address :</td>
	<td  valign="top" align="left">
	<textarea class="bigbox" name="PunchingIP" id="PunchingIP"><?=stripslashes($arryCompany[0]['PunchingIP'])?></textarea><br>
	<?php echo INPUT_IP_HINT;?>
	 </td>

</tr>

<SCRIPT LANGUAGE=JAVASCRIPT>
SetPunching();
</SCRIPT>


<tr>
	 <td align="left" class="head" colspan="4">Login</td>
</tr>

<tr>
	<td  width="48%" class="blackbold" align="right">Block IP: </td>
	<td  valign="top" align="left">
	<select name="LoginBlock" id="LoginBlock" class="textbox" onchange="SetLogin()">
	<option value="0" >No</option>
	<option value="1" <?php if($arryCompany[0]['LoginBlock']=='1') {echo 'selected';} ?>>Yes</option>
	</select>
	</td>
</tr>
                 
<tr id="TrLogin" style="display:none;">
	<td align="right" valign="top" class="blackbold">Allow IP Address :</td>
	<td  valign="top" align="left">
	<textarea class="bigbox" name="LoginIP" id="LoginIP"><?=stripslashes($arryCompany[0]['LoginIP'])?></textarea><br>
	<?php echo INPUT_IP_HINT;?>
 	</td>
 	
</tr>


</table>


</td>
</tr>

<tr><td align="center"><input type="submit" value=" Update " id="SubmitButton" class="button" name="Submit"></td></tr>

</table>

</form>




<SCRIPT LANGUAGE=JAVASCRIPT>
SetLogin();
</SCRIPT>
