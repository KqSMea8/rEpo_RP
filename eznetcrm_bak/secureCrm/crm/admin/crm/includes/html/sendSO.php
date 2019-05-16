<script language="JavaScript1.2" type="text/javascript">
function validateMail(frm){

	if(ValidateForSelect(frm.ToEmail, "To Email")
	&& isEmail(frm.ToEmail)
	&& isEmailOpt(frm.CCEmail)
	&& ValidateOptionalDoc(frm.document, "Document")
	){
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

		return true;	
			
	}else{
		return false;	
	}	

		
}
</script>


		
<? 

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>
<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">	
<div class="had"><?='Send '.$module?> </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>
  </tr>
	<tr>
			<td  align="right"   class="blackbold" > Subject  : </td>
			<td   align="left" >
<?=stripslashes($arrySale[0]['subject'])?>	</td>
	</tr>

 <tr>
        <td  align="right"   class="blackbold" >Quote Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

<!--tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arrySale[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>')?>
		  
		 </td>
      </tr-->




	<!--tr>
			<td  align="right"   class="blackbold" > Customer  : </td>
			<td   align="left" >
<?=stripslashes($arrySale[0]['CustomerName'])?>	</td>
	</tr>

<tr>
			<td align="right"   class="blackbold">Customer Email  : </td>
			<td  align="left" ><?=stripslashes($arrySale[0]['CustomerEmail'])?></td>
		  </tr-->


</table>

</td>
</tr>





<tr>
    <td  align="center" valign="top" >

<form name="formMail" action=""  method="post" onSubmit="return validateMail(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Send Email</td>
		</tr>
   <tr>
        <td  align="right"   class="blackbold" width="20%">To  : <span class="red">*</span></td>
        <td   align="left"  >
	<? if(sizeof($arryCustomer)>0){ ?>
		
	<select name="ToEmail" id="ToEmail" class="textbox" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['primary_email']?>" >
			<?=stripslashes($arryCustomer[$i]['FirstName']).' '.stripslashes($arryCustomer[$i]['LastName']).' ['.$arryCustomer[$i]['primary_email'].']'?>
			</option>
		<? } ?>

		 </select>

	<? }else{ ?>
         	<input type="text" name="ToEmail" id="ToEmail" value="<?=stripslashes($arrySale[0]['CustomerEmail'])?>" class="inputbox" >
	<? } ?>	  
		 </td>
      </tr>
   <tr>
        <td  align="right"   class="blackbold" >CC  : </td>
        <td   align="left"  >
         	<input type="text" name="CCEmail" id="CCEmail" value="" class="inputbox" maxlength="80">
		  
		 </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Attach Document  : </td>
        <td   align="left"  >
         <input name="document" type="file" class="inputbox"  id="document"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />	
	</td>
      </tr>


   <tr>
        <td  align="right"   class="blackbold" valign="top">Message  : </td>
        <td   align="left"  >
         	<textarea name="Message" id="Message" class="bigbox" maxlength="500"></textarea>
		  
		 </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" ></td>
        <td   align="left"  >
         	<input type="submit" name="butt" id="butt" class="button" value="Send">
		  
		 </td>
      </tr>
		</table>	
    </form>
	
	</td>
   </tr>

  

  
</table>
</div>


<? } ?>


