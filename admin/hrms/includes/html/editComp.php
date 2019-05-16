<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	if(document.getElementById("EmpID") != null){
		document.getElementById("MainEmpID").value = document.getElementById("EmpID").value;
	}
	if(document.getElementById("Department") != null){
		if(!ValidateForSelect(frm.Department,"Department")){
			return false;
		}
	}


	if( ValidateForSelect(frm.MainEmpID, "Employee") 
		&& ValidateForSelect(frm.WorkingDate,"Working Date")
		&& ValidateMandDecimalField(frm.Hours,"Working Hours")
 	){
		var  Hours = parseFloat(document.getElementById("Hours").value);
		if(Hours <= 1){
			alert("Working Hours should not be less than 1.");
			return false;	
		}


		ShowHideLoader('1','S');
		return true;	
	}else{
		return false;	
	}
	
}





</SCRIPT>
  <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$MainModuleName?> &raquo; <span>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" ".$PgHead." ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<? if(!empty($ErrorMsg)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMsg?>
	  </div>
<? }else{ ?>  

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" <?=$OnSubmit?> enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >
                   
 <? 
	if($_GET['edit'] >0){	
		include("includes/html/box/comp_edit.php");
	}else{ 
		include("includes/html/box/comp_form.php");
	} 
?>

                  </td>
                </tr>

				<? if($HideFlag!=1){ ?>
				 <tr><td align="center">
			  <br>

<input name="Submit" type="submit" class="button" value="Submit" />
<input type="hidden" name="CompID" id="CompID" value="<?=$_GET["edit"]?>" />
<input type="hidden" name="MainEmpID" id="MainEmpID" value="<?=$arryComp[0]['EmpID']?>" />
<input type="hidden" name="OldApproved" id="OldApproved" value="<?=$arryComp[0]['Approved']?>" />


				  </td></tr> 
				  <? } ?>
				
              </form>
          </table>
</div>
		


<? } ?>		
	   

