
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if(  ValidateForSelect(frm.country_id, "Country") 
	     && ValidateMandExcel(frm.excel_file,"Please upload lead sheet in excel format.")
	){

		return true;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>

<a href="dwn.php?file=upload/Excel/CityStateTemplate.xls" class="download" style="float:right">Download Template</a> 
<div class="had">
Import City/State
</div>
<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>
<TABLE WIDTH="80%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	<TR>
	  <TD align="center" valign="top">
	
	  <table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
                 <tr>
                  <td height="60">
 <div class="message"><? if(!empty($_SESSION['mess_city'])) {echo $_SESSION['mess_city']; unset($_SESSION['mess_city']); }?></div>

				  </td>


				  </tr>
                <tr>
                  <td align="center" valign="top" >
				   
				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
                     <tr <?=$Config['CountryDisplay']?>>
                      <td  width="45%" align="right" valign="middle" class="blackbold"> Country :<span class="red">*</span> </td>
                      <td  align="left">
					 
	<select name="country_id" class="inputbox" id="country_id" >
	<option value="">--- Select Country ---</option>
      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select>					  </td>
                    </tr>                 
                   

 <tr>
                    <td  class="blackbold" valign="top"  align="right"> Import Sheet :<span class="red">*</span></td>
                    <td  align="left"   class="blacknormal" valign="top" height="40"><input name="excel_file" type="file" class="inputbox"  id="excel_file"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					<br>
					<?=IMPORT_SHEET_FORMAT_MSG?>
	                 </td>
					</tr>	


                  </table></td>
                </tr>
			



	
			<tr>
                  <td align="center" height="40" >
				
				 
				 
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
				 			  </td>
                </tr>		
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
