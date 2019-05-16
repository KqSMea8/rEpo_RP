 
<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	if( ValidateForSimpleBlank(frm.Barcode, "Google Authentication Code")
		)
                {    
			ShowHideLoader(1,'P');
			return true;		
		}
      else{
					return false;	
			}	
}

</script>
 

<div class="had_big">Security Authentication Step <?=$Step?> of <?=$NumSecurity?></div>
<div class="message"><? if(!empty($_SESSION['mess_Barcode'])) {echo $_SESSION['mess_Barcode']; unset($_SESSION['mess_Barcode']); }?></div>


<br><br> 	
<table width="50%" border="0" cellpadding="10" cellspacing="0" class="borderall">
	<form name="form1" method="post" onSubmit="return validateForm(this);">
	

	<tr>
				<td   align="left" class="head">Google Authentication</td>
			</tr>
	<tr>
		<td align="center" valign="top">
		
		<table width="100%" border="0" cellpadding="10" cellspacing="10"		>
			
		
	 <? if(empty($AuthSecretKey)){?>

	<tr>
 
				<td   align="left" ><b><?=GOOGLE_AUTH_MSG?></b> </td>
			</tr>

	<tr>   

		<td align="left"><img src="<?php echo $qrCodeUrl;?>" hight="170" width="170"> </td>
	</tr>

	<? } ?>

			<tr>			 
				
				<td align="left">

Enter Google Authentication Code : &nbsp;&nbsp;
<input name="Barcode" type="text" class="textbox" id="Barcode" value="" placeholder="6 Digit Code"/>
		 </td>
			</tr>
			
 


		</table>
		</td>
	</tr>
	<tr>
			<td   align="center">
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Validate" />
			<!--input name="AppCode" type="hidden" id="AppCode" value="<?=$oneCode?>" -->		
	<input name="secret" type="hidden" id="secret" value="<?=$secret?>"  />		

				</td>
			</tr>
	</form>
</table>
 
