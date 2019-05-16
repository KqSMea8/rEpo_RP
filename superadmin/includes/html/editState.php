
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if(  ValidateForBlank(frm.name, "State Name") 
	){

		var Url = "isRecordExists.php?State="+document.getElementById("name").value+"&CountryID="+document.getElementById("country_id").value+"&editID="+document.getElementById("state_id").value;
		SendExistRequest(Url,"name","State Name");
		return false;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>

<a href="viewStates.php?country=<?=$_GET['country']?>"   class="back">Back</a>
<div class="had">
Manage States  <span> &raquo; 
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
		</span>
</div>

<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	<TR>
	  <TD align="center" valign="top">
	  
	  <table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
                 <tr>
                  <td height="60">
				  </td>
				  </tr>
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="42%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State Name : </td>
                      <td width="58%" align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name"  maxlength="31" /> <span class="red">*</span></td>
                    </tr>
                     <tr <?=$Config['CountryDisplay']?>>
                      <td align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Country : </td>
                      <td  align="left">
					 
	<select name="country_id" class="inputbox" id="country_id" >
      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select>					  </td>
                    </tr>                 
                   
                  </table></td>
                </tr>
				
			<tr>
                  <td align="center" height="40" >
				
				 
				  <input type="hidden" name="state_id" id="state_id"  value="<?=$_GET['edit']?>" />
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
				 			  </td>
                </tr>		
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>