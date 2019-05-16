<SCRIPT LANGUAGE=JAVASCRIPT>


function ValidateForm(frm)
{
	if( ValidateForSimpleBlank(frm.ExReason,"Expense Reason")
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






		ShowHideLoader('1','S');
		return true;	
	}else{
		return false;	
	}
	
}





</SCRIPT>
<div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$MainModuleName?> &raquo; <span> <? 
$MemberTitle = (!empty($_GET['edit']))?(" ".$PgHead." ") :(" Apply For ");
echo $MemberTitle.$ModuleName;
?> </span></div>

<? if(!empty($ErrorMsg)){ ?>
<div align="center" id="ErrorMsg" class="redmsg"><br>
<?=$ErrorMsg?></div>
<? }else{ ?>

<div id="prv_msg_div" style="display: none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div">

<form name="form1" action method="post" <?=$OnSubmit?> enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

	<tr>
		<td align="center"><? include("includes/html/box/Reimbursement_form.php"); ?>

		</td>
	</tr>

	<tr>
		<td align="left">
		<? include("includes/html/box/Reimbursement_item_form.php"); ?>
		

		</td>
	</tr>

	<? if($HideFlag!=1){ ?>
	<tr>
		<td align="center"><br>

		<input name="Submit" type="submit" class="button" value="Submit" /></td>
	</tr>
	<? } ?>

</table>

</form>

</div>



	<? } ?>


