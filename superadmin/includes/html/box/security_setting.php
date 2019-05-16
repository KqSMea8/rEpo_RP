 

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_company'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >




<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
       		 <td colspan="2" align="left" class="head">Security Settings</td>
        </tr>

	<tr>
        <td  align="right"   class="blackbold"  valign="top" > Allowed Security  : </td>
        <td   align="left" style="line-height:26px;" >
        
		<label><input type="checkbox" name="AllowSecurity[]" id="AllowSecurity1" value="1" <?=substr_count($arryCompany[0]['AllowSecurity'],"1")?("checked"):("")?> /> <?=QUESTION_VERI?> <br></label>
		
		<label><input type="checkbox" name="AllowSecurity[]" id="AllowSecurity2" value="2" <?=substr_count($arryCompany[0]['AllowSecurity'],"2")?("checked"):("")?> /> <?=GOOGLE_VERI?>  <br></label>
		
		<label><input type="checkbox" name="AllowSecurity[]" id="AllowSecurity3" value="3" <?=substr_count($arryCompany[0]['AllowSecurity'],"3")?("checked"):("")?>  /> <?=SMS_VERI?> <br></label>

       </td>
    </tr>

</table>

	
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	

      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "  />


<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" readonly />






</div>

</td>
   </tr>
   </form>
</table>




