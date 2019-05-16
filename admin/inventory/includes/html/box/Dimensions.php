<tr>
	<td colspan="3" align="left" class="head">Dimensions </td>
	</tr>
	<tr style="display:none;">
	<td align="right"  class="blackbold" >Pack Size :</td>
	<td align="left"  class="blacknormal"><input  name="pack_size" id="pack_size" value="<? echo stripslashes($arryProduct[0]['pack_size']); ?>" type="text"  class="textbox"  size="10" maxlength="10" /> </td>
	
        </tr>

	<tr>
	<td align="right"  class="blackbold" width="45%" >Weight</td>
	<td align="left"  class="blacknormal"><input  name="weight" id="weight" value="<? echo stripslashes($arryProduct[0]['weight']); ?>" type="text"  class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" /> 
        <select name="wtUnit" class="textbox" id="wtUnit"  >

	<option value="Lbs"  <?php if ($arryProduct[0]['wt_Unit'] == "Lbs") { echo " selected"; }
?>>&nbsp;Lbs&nbsp;</option>
	<option value="Kg" <?php if ($arryProduct[0]['wt_Unit']== "Kg") { echo " selected"; }?>>&nbsp;Kg&nbsp;</option>
        
        
        
        
	</select> 
        
        </td>
       
        

	</tr>

	<tr>
	<td align="right"  class="blackbold">Length:</td>
	<td align="left"  class="blacknormal"><input  name="width" id="width" value="<? echo stripslashes($arryProduct[0]['width']); ?>" type="text"  class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" /> 
        
          <select name="lnUnit" class="textbox" id="lnUnit" >

	<option value="Inch"  <?php if ($arryProduct[0]['ln_Unit'] == "Inch") { echo " selected"; }
?>>Inch</option>
	<option value="Cm"  <?php if ($arryProduct[0]['ln_Unit'] == "Cm") { echo " selected"; }
?>>Cm</option>
	</select>   
            </td>
        </tr>

	<tr>
	<td align="right"  class="blackbold">Width:</td>
	<td align="left"  class="blacknormal"><input  name="height" id="height" value="<? echo stripslashes($arryProduct[0]['height']); ?>" type="text"  class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" /> 
       
              <select name="wdUnit" class="textbox" id="wdUnit" >

	<option value="Inch"  <?php if ($arryProduct[0]['wd_Unit'] == "Inch") { echo " selected"; }
?>>Inch</option>
	<option value="Cm"  <?php if ($arryProduct[0]['wd_Unit'] == "Cm") { echo " selected"; }
?>>Cm</option>
	</select> 
        </td>
	</tr>

	<tr>
	<td align="right"  class="blackbold">Height:</td>
	<td align="left"  class="blacknormal"><input  name="depth" id="depth" value="<? echo stripslashes($arryProduct[0]['depth']); ?>" type="text"  class="textbox"  size="10" maxlength="10" onkeypress="return isDecimalKey(event);" /> 
       
              <select name="htUnit" class="textbox" id="htUnit" >

	<option value="Inch"  <?php if ($arryProduct[0]['ht_Unit'] == "Inch") { echo " selected"; }
?>>Inch</option>
	<option value="Cm"  <?php if ($arryProduct[0]['ht_Unit'] == "Cm") { echo " selected"; }
?>>Cm</option>
	</select> 
        </td>
	</tr>
