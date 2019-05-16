<script language="JavaScript1.2" type="text/javascript">
function validateMail(frm){

	if(ValidateForSimpleBlank(frm.ToEmail, "To Email")
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
<div class="had">Send Document</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"> Document Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Document Title : </td>
        <td   align="left" ><B><?=stripslashes($arryDoc[0]['title'])?></B></td>
  </tr>
 <? 
$description = stripslashes(strip_tags($arryDoc[0]['description']));
if(!empty($description)){ ?>
	<tr>
			<td  align="right"   class="blackbold" valign="top"> Description  : </td>
			<td   align="left" >
<?=$description?>	</td>
	</tr>
<? } ?>
 <tr>
        <td  align="right"   class="blackbold" >Created On  : </td>
        <td   align="left" >
 <?=($arryDoc[0]['AddedDate']>0)?(date($Config['DateFormat'], strtotime($arryDoc[0]['AddedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	<tr>
			<td  align="right"   class="blackbold" > Document  : </td>
			<td   align="left" >

 <? 
$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
if($arryDoc[0]['FileName'] !='' && file_exists($MainDir.$arryDoc[0]['FileName']) ){
	$DocExist=1;
	?>	
	<a href="dwn.php?file=<?=$MainDir.$arryDoc[0]['FileName']?>" class="download">Download</a>
<? } else {
	$DocExist=0;
	echo NOT_UPLOADED;
}

	?> 


	</td>
	</tr>

</table>

</td>
</tr>




<? if($DocExist==1){ ?>
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
         	<input type="text" name="ToEmail" id="ToEmail" value="<?=stripslashes($arryDoc[0]['CustomerEmail'])?>" class="inputbox" >
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

  <? } ?>

  
</table>
</div>


<? } ?>


