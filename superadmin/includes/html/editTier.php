

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.tierName, "Tier Name")
		&& ValidateForSimpleBlank(frm.RangeFrom, "Range From") 
		&& ValidateForSimpleBlank(frm.RangeTo, "Range To")
		){	
		
			if(parseInt(frm.RangeTo.value) <= parseInt(frm.RangeFrom.value)){
				alert("Range To should be greater than Range From.");
				frm.RangeTo.focus();
				return false;
			}

			if(!ValidateForSimpleBlank(frm.Percentage, "Percentage")){
				return false;
			}

			if(frm.Percentage.value >= 100){
				alert("Percentage should be less than 100.");
				frm.Percentage.focus();
				return false;
			}

				
			
			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&tierName="+escape(document.getElementById("tierName").value)+"&editID="+document.getElementById("tierID").value, "tierName","Tier Name");
			if(DataExist==1)return false;

			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&tierRangeFrom="+escape(document.getElementById("RangeFrom").value)+"&tierRangeTo="+document.getElementById("RangeTo").value+"&editID="+document.getElementById("tierID").value, "RangeTo","Tier Range");
			if(DataExist==1)return false;
			/**********************
			DataExist = CheckExistingData("isRecordExists.php", "&CommissionTier="+escape(document.getElementById("RangeFrom").value)+"&editID="+document.getElementById("tierID").value, "RangeFrom","Commission Tier");
			if(DataExist==1)return false;
			/**********************
			DataExist = CheckExistingData("isRecordExists.php", "&tierRangeTo="+escape(document.getElementById("RangeTo").value)+"&editID="+document.getElementById("tierID").value, "RangeTo","Tier Range");
			if(DataExist==1)return false;
			/**********************/

			ShowHideLoader('1','S');
			return true;

			
		}else{
			return false;	
		}
		
}

</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>


<div class="had">Commission Tier <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
	

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="45%"  align="right" valign="top"   class="blackbold">
					   Tier Name :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="tierName" id="tierName" value="<?=stripslashes($arryTier[0]['tierName'])?>" type="text" class="inputbox" maxlength="30" onkeypress="return isAlphaKey(event);"/>  
					    </td>
                    </tr>
                    
		<tr>
                      <td align="right"  class="blackbold">
					Range From :<span class="red">*</span>
					  </td>
                      <td >

<input name="RangeFrom" type="text" class="textbox" size="10" maxlength="10" id="RangeFrom" value="<?=$arryTier[0]['RangeFrom']?>" onkeypress="return isNumberKey(event);"/> <?=$Config['Currency']?>
		 
					  </td>
                    </tr>
                   	
			<tr>
                      <td  align="right"  class="blackbold">
					Range To :<span class="red">*</span>
					  </td>
                      <td >

<input name="RangeTo" type="text" class="textbox" size="10" maxlength="10" id="RangeTo" value="<?=$arryTier[0]['RangeTo']?>" onkeypress="return isNumberKey(event);"/> <?=$Config['Currency']?>
		 
					  </td>
                    </tr>				
                  	
<tr>
                      <td  align="right"  class="blackbold">
					Percentage :<span class="red">*</span>
					  </td>
                      <td >

<input name="Percentage" type="text" class="textbox" size="5" maxlength="6" id="Percentage" value="<?=$arryTier[0]['Percentage']?>" onkeypress="return isDecimalKey(event);"/> %
		 
					  </td>
                    </tr>	



					<!--tr >
                      <td align="right" valign="top"  class="blackbold" > Detail : </td>
                      <td align="left" valign="top">

<textarea name="detail" id="detail" class="textarea" maxlength="250"><?=htmlentities(stripslashes($arryTier[0]['detail']))?></textarea>
	
					  
					  </td>
                    </tr-->

	



		  <tr >
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>


                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="tierID" id="tierID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>






