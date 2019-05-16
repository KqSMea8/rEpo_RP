<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm){
		if(!ValidateForSimpleBlank(frm.heading, "Heading")){
			return false;
		}
		
		var Url = "isRecordExists.php?DecHeading="+escape(document.getElementById("heading").value)+"&catID="+document.getElementById("catID").value+"&editID="+document.getElementById("headID").value;
		SendExistRequest(Url,"heading","Heading");
		return false;
		
}

</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Declaration Structure  &raquo; <?=$PayCategory?><span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
                    <tr>
                      <td width="45%" align="right"    class="blackbold">
					  Heading :<span class="red">*</span> </td>
                      <td align="left" >
					<input  name="heading" id="heading" value="<?=stripslashes($arryHead[0]['heading'])?>" type="text" class="textbox"  maxlength="100" size="70" />					    </td>
                    </tr>	
					
				  <tr>
					<td  align="right"   class="blackbold"> Sub Heading  : </td>
					<td   align="left" >
					<input  name="subheading" id="subheading" value="<?=stripslashes($arryHead[0]['subheading'])?>" type="text" class="textbox"  maxlength="100"  size="70" />						</td>
				  </tr>	                       
              
	
					
					
                    <tr >
                      <td align="right"   class="blackbold">Status  :</td>
                      <td align="left" >
				
        <table border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="10" align="left" ><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" >Active</td>
            <td width="10" align="left" ><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" >InActive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
							  

                  
                  </table></td>
                </tr>
			
				 <tr><td align="center"><br />
			
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="headID" id="headID"  value="<?=$_GET['edit']?>" />
				  
			  <input type="hidden" name="catID" id="catID"  value="<?=$_GET['cat']?>" />
				  
			 <input type="hidden" name="Default" id="Default"  value="<?=$arryHead[0]['Default']?>" />	 
				  
				  
				  </td></tr> 
			
				
              </form>
          </table>
