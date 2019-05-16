<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm)
{
	
	if( ValidateForSimpleBlank(frm.catName, "Category Name")
	
	)
	{
		var Url = "isRecordExists.php?EmpCategoryName="+escape(document.getElementById("catName").value)+"&editID="+document.getElementById("value_id").value;
		 
		SendExistRequest(Url,"catName","Category Name");
		return false;
	}
	else
	{
		return false;	
	}
}

</SCRIPT>
 
  <div ><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$MainModuleName?>  <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:80px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   
                    <tr>
                      <td width="30%" align="right" valign="top" =""  class="blackbold"> Category
					  Name :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top"><input  name="catName" id="catName" value="<?=$catName?>" type="text" class="inputbox" maxlength="40" />
					  </td>
                    </tr>
					
					
                  
	
					
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status :</td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                      </td>
                    </tr>
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
			<? if(isset($_GET['edit']) && $_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="value_id" id="value_id" value="<?=$_GET['edit']?>">   
 	 
 
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" /></td>
		  </tr>
	    </form>
</TABLE>
