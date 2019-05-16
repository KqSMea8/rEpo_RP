
         <form name="RequestForm" action=""  method="post" onSubmit="return validateRequest(this);">

<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	   <tr>
        <td  align="left" valign="middle" class="heading">Request a catalogue</td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> Request a catalogue</td>
      </tr>
      
	  <tr>
        <td height="35" align="left" valign="middle">
		</td>
      </tr>	 
	  <?
	  if(!empty($_SESSION['cat_send'])){
	  ?>
	  <tr>
        <td height="200" align="center" class="redtxt" valign="middle">
		<?=$_SESSION['cat_send']?>
		</td>
      </tr>	  
      <? 
		  unset($_SESSION['cat_send']);
	  }else{ ?>

	  <? if($numCatalog>0 ) { ?>

	   <tr>
        <td  align="left" valign="top">
		
If you would like a copy of any of our latest catalogues, please tick the appropriate box(es) and fill in your details below. We'll post these out to you within a few days.	
		
		</td>
      </tr>
	  	  <tr>
        <td height="15" >
		</td>
      </tr>	
	   <tr>
        <td valign="top" class="outline">
		<? include("includes/html/box/catalog-listing.php");?>
		
		
		</td>
      </tr>	 

 <tr>
        <td height="25" >
		</td>
      </tr>		  
 <tr>
        <td  id="ContactFormTD" valign="top">
		
	
		<table width="90%" border="0" align="left" cellpadding="0" cellspacing="0">
		 
          <tr>
            <td width="21%" height="30" align="left" valign="middle" >First Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="FirstName" id="FirstName" maxlength="30" type="text"  class="txtfield" size="30"/>
            </span></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Last Name <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="LastName" id="LastName" maxlength="30" type="text"  class="txtfield" size="30"/>
            </span></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Contact Number <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
			
		 <? 
	if($arryMember[0]['isd_code'] != ''){
		$IsdSelected = $arryMember[0]['isd_code']; 
	}else{
		$IsdSelected = 1;
	}
	?>
	<!--
   <select name="isd_code" class="txtfield" id="isd_code" style="width: 72px;"  >
   			<option value="">ISD Code</option>
                        <? for($i=0;$i<sizeof($arryIsd);$i++) {
						  if($arryIsd[$i]['isd_code']>0){
						?>
                        <option value="<?=$arryIsd[$i]['isd_code']?>" <?  if($arryIsd[$i]['isd_code']==$IsdSelected){echo "selected";}?>>
                        <?=$arryIsd[$i]['isd_code']?>
                        </option>
				
                        <? }} ?>
  </select>		-->
			
              <input name="ContactNumber" id="ContactNumber" maxlength="30" type="text"  class="txtfield" size="30"/>           </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >Email Address <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" >
              <input name="ContactEmail" id="ContactEmail" maxlength="70" type="text"  class="txtfield" size="30"/>            </td>
          </tr>
            <tr>
            <td height="30" align="left" valign="middle" >Address <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="Address" id="Address" maxlength="30" type="text"  class="txtfield" size="30"/>
            </span></td>
          </tr>        <tr>
            <td height="30" align="left" valign="middle" >City <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="City" id="City" maxlength="30" type="text"  class="txtfield" size="30"/>
            </span></td>
          </tr>
           <tr>
            <td height="30" align="left" valign="middle" >State <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="State" id="State" maxlength="30" type="text"  class="txtfield" size="30"/>
            </span></td>
          </tr>     
		  
		  <tr>
            <td height="30" align="left" valign="middle" >Country <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <select name="Country" class="txtfield" id="Country" style="width: 190px;" >
              <option value="">---- Select Country---- </option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['name']?>">
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>			  
			  
            </span></td>
          </tr>

           <tr>
            <td height="30" align="left" valign="middle" >Post Code <span class="bluestar">*</span></td>
            <td height="30" align="left" valign="middle" ><span class="generaltxt">
              <input name="PostCode" id="PostCode" maxlength="30" type="text"  class="txtfield" size="30"/>
            </span></td>
          </tr>   

          <tr>
            <td height="30" align="left" valign="top" >Comments</td>
            <td height="30" align="left" valign="middle" ><textarea name="comments"  id="comments"  rows="5"  class="txtfield" style="width:300px;resize: none;"></textarea></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" >&nbsp;</td>
            <td height="50" align="left" valign="middle" ><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right"><input name="SubmitButton" id="SubmitButton" type="submit" value="Send Request" class="button" /></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="35" colspan="2" valign="bottom">&nbsp;</td>
          </tr>
        
		 
        </table></td>
      </tr>	  
	  <? }else{ ?>
	     <tr>
            <td height="35" colspan="2" height="250" class="redtxt">No Catalog Found.</td>
          </tr>
	  <? } } ?>
    </table>

</form>