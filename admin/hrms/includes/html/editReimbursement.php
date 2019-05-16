<SCRIPT LANGUAGE=JAVASCRIPT>
function ShowIssueDate(app)
{
	var ExReason=$("#ExReason").val();
	if(app==1){
		$("#IssueDateTitle").show();
		$("#IssueDateVal").show();
		$("#SancAmountTitle").show();
		$("#SancAmountVal").show();
		$("#SancAmount").val("");

	}else{
		$("#IssueDateTitle").hide();
		$("#IssueDateVal").hide();
		$("#CreatedDate").val("");

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
		&& ValidateForSimpleBlank(frm.ExReason,"Expense Reason")		
		&& ValidateForSelect(frm.ApplyDate,"Apply Date")
 		&& ValidateOptionalScan(frm.document, "Reimbursement Document")
	){
		

		/*********************/
	  var flag = false;


          $(".MType").each(function(){
              var counter  =  $(this).attr('data-row');
              var row= $(this).parents('.itembg');
                  if(this.value=="Mile"){

                      var FromZip = row.find("#FromZip"+counter).val();
                      var ToZip = row.find("#ToZip"+counter).val();


                     if(FromZip == ""){
                         alert("Please Enter From Zip");
                         row.find("#FromZip"+counter).focus();
                         flag =  true;
                         return false;
                     }if(ToZip == ""){
                         alert("Please Enter To Zip");
                         row.find("#ToZip"+counter).focus();
                         flag =  true;
                         return false;
                     }

                  }else{
                     var TotalRate = row.find("#TotalRate"+counter).val();
                      if(TotalRate == ""){
                             alert("Please Enter Total Rate");
row.find("#TotalRate"+counter).focus();
                             flag =  true;
                             return false;
                         }
                  }
            });

           if(flag){
                return false;
           } 
	/*********************/





		if(document.getElementById("Approved1").checked){
			if(!ValidateMandDecimalField(frm.SancAmount,"Sanctioned Amount")){
				return false;	
			}

			if(!ValidateForSelect(frm.CreatedDate, "Sanctioned Date")){
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


<form name="form1" action method="post" <?=$OnSubmit?> enctype="multipart/form-data">

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
             
              
                <tr>
                  <td align="center"  >
                   
 <? 
	if($_GET['edit'] >0){	
		include("includes/html/box/Reimbursement_edit.php");
	}else{ 
		include("includes/html/box/Reimbursement_form.php");
		
		include("includes/html/box/Reimbursement_item_form.php");
	} 
?>

                  </td>
                </tr>

				<?  if($HideFlag!=1){ ?>
				 <tr align="center"><td align="center">
			  <br>
<div style="text-align:center;">
<input name="Submit" type="submit" class="button" value="Submit" /></div>
<input type="hidden" name="ReimID" id="ReimID" value="<?=$_GET["edit"]?>" />
<input type="hidden" name="MainEmpID" id="MainEmpID" value="<?=$arryReimbursement[0]['EmpID']?>" />
<input type="hidden" name="AmountDue" id="AmountDue" value="<?=$AmountDue?>" />
<input type="hidden" name="OldApproved" id="OldApproved" value="<?=$arryReimbursement[0]['Approved']?>" />


				  </td></tr> 
				  <? } ?>
				
             
          </table>
          
           </form>
</div>
		


<? } ?>		
	   

