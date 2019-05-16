<SCRIPT LANGUAGE=JAVASCRIPT>
function ShowIssueDate(app)
{
	var ClaimAmount=$("#ClaimAmount").val();
	if(app==1){
		$("#IssueDateTitle").show();
		$("#IssueDateVal").show();
		$("#SancAmountTitle").show();
		$("#SancAmountVal").show();
		$("#SancAmount").val(ClaimAmount);

	}else{
		$("#IssueDateTitle").hide();
		$("#IssueDateVal").hide();
		$("#IssueDate").val("");

		$("#SancAmountTitle").hide();
		$("#SancAmountVal").hide();
		$("#SancAmount").val("");
	}

}


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
		&& ValidateForSimpleBlank(frm.ExpenseReason,"Expense Reason")
		&& ValidateMandDecimalField(frm.ClaimAmount,"Claim Amount")
		&& ValidateForSelect(frm.ExpenseDate,"Expense Date")
 		&& ValidateOptionalScan(frm.document, "Bill")
	){
		
		if(document.getElementById("Approved1").checked){
			if(!ValidateMandDecimalField(frm.SancAmount,"Sanctioned Amount")){
				return false;	
			}
			if(parseInt(frm.SancAmount.value) > parseInt(frm.ClaimAmount.value)){
				alert("Sanctioned amount should not be greater than claim amount.");
				return false;	
			}

			if(!ValidateForSelect(frm.IssueDate, "Sanctioned Date")){
				return false;	
			}
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
		include("includes/html/box/claim_edit.php");
	}else{ 
		include("includes/html/box/claim_form.php");
	} 
?>

                  </td>
                </tr>

				<? if($HideFlag!=1){ ?>
				 <tr><td align="center">
			  <br>

<input name="Submit" type="submit" class="button" value="Submit" />
<input type="hidden" name="ClaimID" id="ClaimID" value="<?=$_GET["edit"]?>" />
<input type="hidden" name="MainEmpID" id="MainEmpID" value="<?=$arryExpenseClaim[0]['EmpID']?>" />
<input type="hidden" name="AmountDue" id="AmountDue" value="<?=$AmountDue?>" />
<input type="hidden" name="OldApproved" id="OldApproved" value="<?=$arryExpenseClaim[0]['Approved']?>" />


				  </td></tr> 
				  <? } ?>
				
              </form>
          </table>
</div>
		


<? } ?>		
	   

