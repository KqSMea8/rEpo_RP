
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.filingStatus, "Filing Status Heading")
		){	
					
			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&filingStatus="+escape(document.getElementById("filingStatus").value)+"&editID="+document.getElementById("filingID").value, "filingStatus","Filing Status Heading");
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
                  <td align="center" valign="top" >
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="47%" height="100"  align="right"   class="blackbold">
					   Filing Status Heading :<span class="red">*</span> </td>
                      <td align="left" >
					<input  name="filingStatus" id="filingStatus" value="<?=stripslashes($arryFiling[0]['filingStatus'])?>" type="text" class="inputbox" style="width:300px;" maxlength="50" />  
					    </td>
                    </tr>
                    
	
                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="filingID" id="filingID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>






