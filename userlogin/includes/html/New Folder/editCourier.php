
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if( ValidateForSimpleBlank(frm.name, "Courier Company Name") 
		&& ValidateForBlank(frm.price, "Price") 
		&& ValidateMandDecimalField(frm.price,"Price")
	){

		var CityID = 0;
		if(document.getElementById("city_id") != null){
			CityID = document.getElementById("city_id").value;
		}
		

		var Url = "isRecordExists.php?Courier="+document.getElementById("name").value+"&CountryID="+document.getElementById("country_id").value+"&CityID="+CityID+"&editID="+document.getElementById("courier_id").value;
		SendExistRequest(Url,"name","Courier Company Name");
		return false;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>

<div class="had">
<?=$CourierHeading?>
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("&raquo; Edit ") :("&raquo; Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="300" align="center" valign="middle" >
		  <div  align="right"><a href="<?=$RedirectUrl?>" class="Blue">Back to <?=$CourierHeading?></a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
				    <tr>
                      <td width="42%" align="right" valign="middle" =""  class="blackbold"> Country: </td>
                      <td align="left">
	 <?
	 
	$CountrySelected = (!empty($country_id))?($country_id):($_GET['country']);

	 
	if($fixed==1 || $_GET['city_opt']==1){
		$arryCountryName = $objCourier->getCountryList($CountrySelected,'');
		echo $arryCountryName[0]['name'].'<input type="hidden" name="country_id" id="country_id" value="'.$CountrySelected.'">';
	}else{
	?>
	<select name="country_id" id="country_id" style="width: 180px;" class="inputbox">
      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select>	
	
	<? }  ?>		
	
				  </td>
                    </tr> 
				   
				   
		<? if(sizeof($arryCity)>0){ ?>		   
				    <tr>
				      <td  align="right"  class="blackbold">City: </td>
				      <td  align="left">
<select name="city_id" class="inputbox" id="city_id" style="width: 180px;" >
      <? 
	  $CitySelected = (!empty($city_id))?($city_id):($_GET['city']);
	  
	  for($i=0;$i<sizeof($arryCity);$i++) {
	  ?>
      <option value="<?=$arryCity[$i]['city_id']?>" <?  if($arryCity[$i]['city_id']==$CitySelected){echo "selected";}?>>
      <?=$arryCity[$i]['name']?>
      </option>
      <? } ?>
    </select>
					  
					  </td>
				      </tr>
					<? } ?>  
					  
					  
					  
				    <tr>
                      <td  align="right"  class="blackbold"> Courier Company Name: <span class="red">*</span> </td>
                      <td  align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name"  style="width:180px;" maxlength="31" /> </td>
                    </tr>
                                    
            <tr>
                      <td  align="right" class="blackbold"> Price: <span class="red">*</span> </td>
                      <td  align="left"><input value="<?=stripslashes($price)?>" name="price" type="text" class="inputbox" id="price" size="3" maxlength="6" /> $</td>
                    </tr>  
					<tr>
                      <td  align="right"  class="blackbold" valign="top"> Description: </td>
                      <td  align="left"><textarea name="detail" type="text" class="inputbox" id="detail" style="width:180px;"/><?=stripslashes($detail)?></textarea></td>
                    </tr>        
                  </table></td>
                </tr>
				
			<tr>
                  <td align="center" valign="top" >
				  <br>
				 
				  <input type="hidden" name="courier_id" id="courier_id"  value="<?=$_GET['edit']?>" />
				   <input type="hidden" name="city_opt" id="city_opt"  value="<?=$_GET['city_opt']?>" />
				   <input type="hidden" name="curP" id="curP"  value="<?=$_GET['curP']?>" />
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ;?>" />
                    
					
					  <input type="reset" name="Reset" value="Reset" class="button" />
					 				  </td>
                </tr>		
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>