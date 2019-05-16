<?php	
    require_once("../classes/company.class.php");	
    
    $objCompany=new company();
    
	$CmpID=$_GET['edit'];
    
		$RedirectUrl = 'editCompany.php?edit='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'].'&tab=ip';	
		
	
	if($_POST){	
		//CleanPost();	
		$objCompany->UpdateIpRestriction($_POST,$CmpID);		
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
			$('.TrPunching').hide();
		}else{
			$('.TrPunching').show();
		}
}
	
function SetLogin(){
	var LoginBlock = document.getElementById('LoginBlock').value;
	if(LoginBlock == '0'){
		$('.TrLogin').hide();
	}else{
		$('.TrLogin').show();
	}
}
//for punch in/out
$(document).on('click', '.rangDel', function(){ 
	if($(this).closest('td').parent('tr').find('.add_row_po').length) {
	}
	$(this).closest('td').parent('tr').remove(); 
})

function addMoreRangePr(thisobj)
{	
		$('.TrPunching:first').clone().attr('id','TrPunching'+$('.TrPunching').length).insertAfter($('.TrPunching:last')).find('td:last').append('<img src="images/delete.png" class="rangDel" style="cursor:pointer">');
		$('.TrPunching:last a').remove();
		$('.TrPunching:last').find(':input').val('');
}
$(document).on('click','.add_row_po', function(){	addMoreRangePr($(this));	});
//end code forthe punchin punchout
	
//start code for login block ip
	$(document).on('click', '.rangDelloginip', function(){ 
	if($(this).closest('td').parent('tr').find('.add_row_loginip').length) {
	}
	$(this).closest('td').parent('tr').remove(); 
})
function addMoreRangelohinip(thisobj)
{	
		$('.TrLogin:first').clone().attr('id','TrLogin'+$('.TrLogin').length).insertAfter($('.TrLogin:last')).find('td:last').append('<img src="images/delete.png" class="rangDel" style="cursor:pointer">');
		$('.TrLogin:last a').remove();
		$('.TrLogin:last').find(':input').val('');
		$('.TrLogin:last').find(':input').val('');
}
$(document).on('click','.add_row_loginip', function(){	addMoreRangelohinip($(this));	});
//end code for login block ip	
</script>
 



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
 
 
 <?php  

       $PunchingIP	= explode(',',$arryCompany[0]['PunchingIP']);	
		$count 		= count($PunchingIP);
		for($i=0;$i<$count;$i++){
			 

?>               
<tr id="TrPunching" style="display:none;" class="TrPunching">
	
    <td  align="right" class="blackbold" valign="top">Allow IP Address :</td>
	<td  valign="top" align="left">
		


	<input name="PunchingIP[]" type="text" class="inputbox track" id="PunchingIP" value="<?php echo stripslashes($PunchingIP[$i]); ?>"  maxlength="15" onkeypress="return isDecimalKey(event);" />     <? if($i==0){?>		<a href="javascript:;" class="add_row_po" id="addmore">Add More</a> <?}?> <? if($i>=1){?> <img src="images/delete.png" class="rangDel" style="cursor:pointer"> <? }?>    
	</td>
</tr>
<? }?> 
	

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
         <?php  

	$loginIps = explode(',',$arryCompany[0]['LoginIP']);	
	$counter  = count($loginIps);
	for($j=0;$j<$counter;$j++){
		
?>
                
<tr id="TrLogin" style="display:none;" class="TrLogin">
	<td align="right" valign="top" class="blackbold">Allow IP Address :</td>
	<td  valign="top" align="left">
				

	<input name="LoginIP[]" type="text" class="inputbox track" id="LoginIP" value="<?php echo stripslashes($loginIps[$j]); ?>"  maxlength="15" onkeypress="return isDecimalKey(event);" />     <? if($j==0){?>		<a href="javascript:;" class="add_row_loginip" id="addmore">Add More</a> <?}?> <? if($j>=1){?> <img src="images/delete.png" class="rangDelloginip" style="cursor:pointer"> <? }?>    
	</td>
</tr>
<? }?> 

</table>


</td>
</tr>

<tr><td align="center"><input type="submit" value=" Update " id="SubmitButton" class="button" name="Submit"></td></tr>

</table>

</form>




<SCRIPT LANGUAGE=JAVASCRIPT>
SetLogin();
</SCRIPT>
