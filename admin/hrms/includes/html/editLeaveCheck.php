
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.Heading, "Check Title")
		&& ValidateMandNumField2(frm.Value, "Value",1,5) 		
		){	
		
		
							
			
			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&LeaveCheckHeading="+escape(document.getElementById("Heading").value)+"&editID="+document.getElementById("checkID").value, "Heading","Check Title");
			if(DataExist==1)return false;

			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&LeaveCheckValue="+escape(document.getElementById("Value").value)+"&editID="+document.getElementById("checkID").value, "Value","Value");
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


<div class="had"><?=$MainModuleName?> <span> &raquo;
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
					   Check Title :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="Heading" id="Heading" value="<?=stripslashes($arryLeaveCheck[0]['Heading'])?>" type="text" class="inputbox" maxlength="30" onkeypress="return isAlphaKey(event);"/>  
					    </td>
                    </tr>
                    
						
                  	
<tr>
                      <td  align="right"  class="blackbold">
					Value :<span class="red">*</span>
					  </td>
                      <td >

<input name="Value" type="text" class="textbox" style="width:15px;" maxlength="1" id="Value" value="<?=$arryLeaveCheck[0]['Value']?>" onkeypress="return isNumberKey(event);"/> 
		 
					  </td>
                    </tr>	





		  <!--tr >
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
                    </tr-->


                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="checkID" id="checkID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>





