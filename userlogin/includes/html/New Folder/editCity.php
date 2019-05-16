
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if(  ValidateForBlank(frm.name, "City Name") 
	){

		var Url = "isRecordExists.php?City="+document.getElementById("name").value+"&StateID="+ document.getElementById("main_state_id").value+"&editID="+ document.getElementById("city_id").value;
		
		SendExistRequest(Url,"name","City Name");
		return false;
	}else{
		return false;	
	}
	
}


</SCRIPT>

<div class="had">
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%" height="320"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		  <div  align="right"><a href="viewCities.php" class="Blue">List Cities</a>&nbsp;</div><br>
		    <table width="100%"   border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" valign="bottom" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="42%" align="right" valign="middle" =""  class="blackbold"> City Name : </td>
                      <td width="58%" align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name" size="30" maxlength="31" /> <span class="red">*</span></td>
                    </tr>
                     <tr>
                       <td align="right" valign="middle" =""  class="blackbold"> Country : </td>
                       <td align="left">
                           <select name="country_id" class="inputbox" id="country_id" style="width: 200px;" onchange="Javascript: StateListSend(1);">
                             <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                             <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
                             <?=$arryCountry[$i]['name']?>
                             </option>
                             <? } ?>
                           </select>
                       </td>
                     </tr>
                     <tr>
                      <td width="42%" align="right" valign="middle" =""  class="blackbold"> State : </td>
                      <td width="58%" align="left" id="state_td" class="blacknormal">
					   <img src="images/loading.gif">		
					  </td>
                    </tr>                 
                   
                  </table></td>
                </tr>
				
		 <tr>
                  <td align="center" colspan="2" height="35"><input name="Submit" type="submit" id="SubmitButton" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit';?> <?=$ModuleName?>" <? if(sizeof($arryState)<=0) { echo 'disabled';} ?>/>
                          <input type="hidden" name="city_id" id="city_id"  value="<?=$_GET['edit']?>" />                      <input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$state_id?>" />
                          <input type="reset" name="Reset" value="Reset" class="button" /></td>
                    </tr>		
				
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>