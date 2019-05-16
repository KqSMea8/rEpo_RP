<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm){
		if( ValidateForSimpleBlank(frm.heading, "KRA Title")
			&& ValidateForSelect(frm.JobTitle, "Job Title")
			&& ValidateMandNumField2(frm.MinRating,"Minimum Rating",0,1000)
			&& ValidateMandNumField2(frm.MaxRating,"Maximum Rating",1,1000)
		){

			if(parseInt(frm.MaxRating.value) < parseInt(frm.MinRating.value)){
				alert("Maximum Rating should be greater than Minimum Rating.");
				return false;
			}

			var Url = "isRecordExists.php?KRATitle="+escape(document.getElementById("heading").value)+"&JobTitle="+escape(document.getElementById("JobTitle").value)+"&editID="+document.getElementById("kraID").value;
			SendMultipleExistRequest(Url,"heading","KRA Title","JobTitle","Job Title");
			return false;

		}else{
			return false;	
		}
		
}
</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Manage KRA   <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="45%" align="right"    class="blackbold">
					   KRA Title :<span class="red">*</span> </td>
                      <td align="left" >
					<input  name="heading" id="heading" value="<?=stripslashes($arryKra[0]['heading'])?>" type="text" class="inputbox"  maxlength="40"  />					    </td>
                    </tr>	
					
				  <tr>
					<td  align="right"   class="blackbold"> Job Title  :<span class="red">*</span> </td>
					<td   align="left" >
					
					<select name="JobTitle" class="inputbox" id="JobTitle">
					  <option value="">--- Select ---</option>
					  <? for($i=0;$i<sizeof($arryJobTitle);$i++) {?>
					  <option value="<?=$arryJobTitle[$i]['attribute_value']?>" <?  if($arryJobTitle[$i]['attribute_value']==$arryKra[0]['JobTitle']){echo "selected";}?>>
					  <?=$arryJobTitle[$i]['attribute_value']?>
					  </option>
					  <? } ?>
					</select>		</td>
				  </tr>	                       
              
			<tr>
        <td align="right" class="blackbold">Minimum Rating  :<span class="red">*</span></td>
        <td  align="left">
	 <input name="MinRating" type="text" class="textbox" id="MinRating" value="<?=stripslashes($arryKra[0]['MinRating'])?>" size="3"  maxlength="4"  onkeypress="return isNumberKey(event);" />			</td>
      </tr>	

	  <tr>
        <td align="right" class="blackbold">Maximum Rating :<span class="red">*</span></td>
        <td  align="left">
	 <input name="MaxRating" type="text" class="textbox" id="MaxRating" value="<?=stripslashes($arryKra[0]['MaxRating'])?>" size="3"  maxlength="4"  onkeypress="return isNumberKey(event);" />			</td>
      </tr>		
					
					
                    <tr >
                      <td align="right"   class="blackbold">Status  :</td>
                      <td align="left" class="blacknormal">
				
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" ><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" >Active</td>
            <td width="20" align="left" ><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" >InActive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="kraID" id="kraID"  value="<?=$_GET['edit']?>" />
		
				  
				  </td></tr> 
				
              </form>
          </table>