<div class="had">
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="388" align="center" valign="middle" >
		  <div  align="right"><a href="viewStates.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="42%" align="right" valign="middle" =""  class="blackbold"> State Name : </td>
                      <td width="58%" align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name" size="30" maxlength="31" /> <span class="red">*</span></td>
                    </tr>
                     <tr>
                      <td width="42%" align="right" valign="middle" =""  class="blackbold"> Country : </td>
                      <td width="58%" align="left">
					  <?php 
	if($country_id != ''){
		$CountrySelected = $country_id; 
	}else{
		$CountrySelected = 1;
	}
	?>
	<select name="country_id" class="blacknormal" id="country_id" style="width: 200px;">
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
                  <td align="center" valign="top" >
				  <br>
				 
				  <input type="hidden" name="state_id" id="state_id"  value="<?=$_GET['edit']?>" />
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
                    
					
					  <input type="reset" name="Reset" value="Reset" class="button" />
					  <br>  <br>				  </td>
                </tr>		
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
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