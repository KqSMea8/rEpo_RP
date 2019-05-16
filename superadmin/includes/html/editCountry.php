<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if(  ValidateForBlank(frm.name, "Country Name") 
	){

		var Url = "isRecordExists.php?Country="+document.getElementById("name").value+"&editID="+ document.getElementById("country_id").value;
		SendExistRequest(Url,"name","Country Name");
		return false;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>
<a href="<?=$RedirectUrl?>"  class="back">Back</a>
<div class="had">
Manage Countries    <span> &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle">
		  <br><br />
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				 
				 	<!--
                    <tr>
                      <td align="right" valign="middle" nowrap="nowrap"  class="blackbold">Continent : </td>
                      <td align="left">
	<?php 
	if($continent_id != ''){
		$ContinentSelected = $continent_id; 
	}else{
		$ContinentSelected = 2;
	}
	?>
	
					
                        <select name="continent_id" class="blacknormal" id="continent_id" style="width: 200px;">
                          <? if(!empty($arryContinent)){
		for($i=0;$i<sizeof($arryContinent);$i++) {?>
                          <option value="<?=$arryContinent[$i]['continent_id']?>" <?  if($arryContinent[$i]['continent_id']==$ContinentSelected){echo "selected";}?>>
                          <?=$arryContinent[$i]['name']?>
                          </option>
                          <? } } ?>
                        </select>>
						
						 <strong>Africa</strong>
						
						</td>
                    </tr>-->
					
					<tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Country Name : </td>
                      <td width="56%" align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name" size="31" maxlength="30" <? if($_GET['edit']==1) echo 'Readonly'; ?>/> <span class="red">*</span></td>
                    </tr>
                  </table></td>
                </tr>
				
			<tr>
                  <td align="center" valign="top" >
				  <br>
				  <input type="hidden" name="continent_id" id="continent_id" value="2" />
				  <input type="hidden" name="country_id" id="country_id"  value="<?=$_GET['edit']?>" />
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
				  <br>  
				  <br>				  </td>
                </tr>	
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
