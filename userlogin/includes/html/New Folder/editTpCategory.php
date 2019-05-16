<div class="had">
<? 
$MemberTitle = (!empty($_GET['edit']))?("&nbsp; Edit Template ") :("&nbsp; Add Template ");
echo $MemberTitle.$ModuleName;


?>
</div>
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);"><TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="middle" >
		  <div  align="right"><a href="<?=$ListUrl?>" class="Blue">List Template Categories</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
            
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                    <tr>
                      <td width="44%" align="right" valign="top" =""  class="blackbold"> 
					  Category Name <span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top"><input  name="Name" id="Name" value="<?=stripslashes($arryCategory[0]['Name'])?>" type="text" class="inputbox"  size="30" maxlength="255" />
					  </td>
                    </tr>
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status  </td>
                      <td align="left" class="blacknormal">
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($CategoryStatus==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($CategoryStatus==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                      </td>
                    </tr>
                   
                  </table></td>
                </tr>
				
          
          </table></td>
        </tr>
		<tr>
				<td align="center" height="135" valign="top"><br>
			<? if($_GET['edit'] >0) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>
					
	<input type="hidden" name="catID" id="catID" value="<?php echo $_GET['edit']; ?>">   
  
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" /></td>
		  </tr>
		
      </table></TD>
  </TR>
	    </form>
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	var module_title = 'Category Name';

	if(  ValidateForBlank(frm.Name, module_title) 
		&& ValidateMandRange(frm.Name, module_title,3,50)
	){

		var Url = "isRecordExists.php?TemplateCategoryName="+escape(document.getElementById("Name").value)+"&editID="+document.getElementById("catID").value;
		SendExistRequest(Url,"Name", module_title);
		return false;
	}else{
		return false;	
	}
	

	
	
}

</SCRIPT>