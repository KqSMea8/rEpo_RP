<script language="JavaScript1.2" type="text/javascript">
function ShowLoader(){
	$("#prv_msg_div").show();
	$("#preview_div").hide();	
} 
function validate_auth_form(frm){ 
	$("#msgdiv").html("&nbsp;");
	var AmountToCharge = parseFloat(document.getElementById("AmountToCharge").value);  
	var AmountToChargeMax = parseFloat(document.getElementById("AmountToChargeMax").value);
	if(Trim(document.getElementById("AmountToCharge")).value <= 0 ){ 	
		$("#msgdiv").html('Please Enter Amount.');		
		return false;
	}else if(AmountToCharge > AmountToChargeMax){	 	
		$("#msgdiv").html('Authorize Amount should not exceed '+AmountToChargeMax+'.');		
		return false;
	}else{
		ShowLoader();		
		return true;
	}

} 







</script>
<div class="ui-dialog-titlebar had"><?=$Heading?></div>

		
<?	if(!empty($ErrorMSG)){	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';}else{?>


<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="min-height:200px;" >
 
<?php if($Action=="VCard"){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" style="display:none1">
 <!--tr>
	 <td align="left">                                        
             <?php   // include("includes/html/box/so_brief_view.php");
        ?>         
         </td>
</tr-->
<tr>
	 <td align="left">                                        
             <?php include("includes/html/box/sale_card_transaction.php");  ?>   
	    <input type="hidden" name="CustomLoader" id="CustomLoader" value="1" readonly />      
         </td>
</tr>
</table>

<? }else if(!empty($ChargeCreditCard)){ ?>
<form name="formCard" action="" method="post"  enctype="multipart/form-data" onSubmit="return validate_auth_form(this);">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr> 
	<td height="20">
<div id="msgdiv" class="redmsg" align="center"> </div>
</td>	
  </tr>
<tr> 
	<td >
		<table width="70%" border="0" cellpadding="5" cellspacing="1" align="center" bgcolor="#FFFFFF" class="borderall">
		<tr>
		<td align="right"   class="blackbold" valign="top">Authorize Amount :</td>
		<td  align="left" >

		<input name="AmountToCharge" type="text" class="datebox" id="AmountToCharge" value="<?=$AmountToCharge?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('msgdiv'); Javascript: return isDecimalKey(event);"  />
		<?=$arrySale[0]['CustomerCurrency']?>

		<input type="hidden" name="AmountToChargeMax" id="AmountToChargeMax" value="<?=$AmountToCharge?>" readonly />
 
		
		</td>
		</tr>
		</table>
	</td>
	</tr>

<tr >
    <td align="center">
 
<input type="submit" class="button" name="AuthCardSubmit" id="AuthCardSubmit" value="Confirm Payment">
</td>	
  </tr>



</table>

</form>
<?  } ?>




</div>

 
<? } ?>


