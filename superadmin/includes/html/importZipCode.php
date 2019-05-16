
<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm){
 
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if(  ValidateForSelect(frm.country_id, "Country")
	    
	){
		/**************/
		var stateDisplay = $("#state_td").css('display');
		if(stateDisplay!='none'){
			if(document.getElementById("state_id") != null){
				document.getElementById("main_state_id").value = document.getElementById("state_id").value;
			}
			if(!ValidateForSelect(document.getElementById("main_state_id"), "State")){
				return false;
			}
		}	 
		/**************/
		if(!ValidateForSelect(document.getElementById("main_city_id"), "City")){
			return false;
		}
		if(!ValidateMandExcel(frm.excel_file,"Please upload lead sheet in excel format.")){
			return false;
		}



		return true;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>
<a href="<?=$BackUrl?>"  class="back">Back</a>
<a href="dwn.php?file=upload/Excel/ZipCodeTemplate.xls" class="download" style="float:right">Download Template</a> 
<div class="had">
Manage Zip Code  <span>&raquo;&nbsp; Import Zip Code</span>
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
 <div class="message"><? if(!empty($_SESSION['mess_zipcode'])) {echo $_SESSION['mess_zipcode']; unset($_SESSION['mess_zipcode']); }?></div>

				  </td>


				  </tr>
                <tr>
                  <td align="center" valign="top" >
				   
				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
                     <tr <?=$Config['CountryDisplay']?>>
                      <td  width="45%" align="right" valign="middle" class="blackbold"> Country :<span class="red">*</span> </td>
                      <td  align="left">
					 
	<select name="country_id" class="inputbox" id="country_id" onchange="Javascript: StateListSend(1);">
	<option value="">--- Select Country ---</option>
      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select>					  </td>
                    </tr>                 
                   
             <tr>
                      <td align="right" valign="middle" class="blackbold"> State :<span class="red">*</span> </td>
                      <td  align="left" id="state_td" class="blacknormal">
					  </td>
                    </tr>  
					
					  <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City :<span class="red">*</span></div></td>
        <td  align="left"  ><div id="city_td"></div></td>
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
				
				 <input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$state_id?>" />
                        <input type="hidden" name="main_city_id" id="main_city_id"  value="<?=$city_id?>" />
				 
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
				 			  </td>
                </tr>		
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<script type="text/javascript">
	StateListSend();
</script>
