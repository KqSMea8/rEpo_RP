<SCRIPT LANGUAGE=JAVASCRIPT>


function ShowIssueDate(app)
{
	if(app==1){
		$("#IssueDateTitle").show();
		$("#IssueDateVal").show();
	}else{
		$("#IssueDateTitle").hide();
		$("#IssueDateVal").hide();
		$("#IssueDate").val("");
	}

}

function SetEmpID(){

	$("#SalValue").hide();
	$("#SalValueCurrency").hide();
	$("#NetSalary").val(0);
	if(document.getElementById("EmpID").value>0){
				var SendUrl = "&action=emp_salary&EmpID="+document.getElementById("EmpID").value+"&r="+Math.random(); 

				$.ajax({
					type: "GET",
					url: "ajax.php",
					data: SendUrl,
					success: function (responseText) {
						$("#SalValue").html("<b>Net Salary : "+number_format(responseText)+"</b>");
						$("#SalValue").show();
						$("#SalValueCurrency").show();
						$("#NetSalary").val(responseText);
					}
				});
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
		&& ValidateMandDecimalField(frm.Amount,"Amount")
 	){

		if(parseInt(frm.Amount.value) > parseInt(frm.NetSalary.value)){
			alert("Advance amount should not be greater than Net Salary.");
			return false;	
		}

		if(document.getElementById("ReturnType2").checked){
			if(!ValidateForSelect(frm.ReturnPeriod, "Return Period")){
				return false;	
			}
		}else{
			if(!ValidateForSelect(frm.ReturnDate, "Return Date")){
				return false;	
			}
		}

		if(document.getElementById("Approved1").checked){
			if(!ValidateForSelect(frm.IssueDate, "Issue Date")){
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
		include("includes/html/box/advance_edit.php");
	}else{ 
		include("includes/html/box/advance_form.php");
	} 
?>

                  </td>
                </tr>

				<? if($HideFlag!=1){ ?>
				 <tr><td align="center">
			  <br>

<input name="Submit" type="submit" class="button" value="Submit" />
<input type="hidden" name="AdvID" id="AdvID" value="<?=$_GET["edit"]?>" />
<input type="hidden" name="MainEmpID" id="MainEmpID" value="<?=$arryAdvance[0]['EmpID']?>" />
<input type="hidden" name="AmountDue" id="AmountDue" value="<?=$AmountDue?>" />
<input type="hidden" name="OldApproved" id="OldApproved" value="<?=$arryAdvance[0]['Approved']?>" />


				  </td></tr> 
				  <? } ?>
				
              </form>
          </table>
</div>
		


<? } ?>		
	   

