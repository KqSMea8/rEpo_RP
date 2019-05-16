<?
	require_once($Prefix."classes/finance.class.php");
	$objCommon=new common();
	$ModuleName = "Payment Term";
	$RedirectURL = "viewTerm.php?curP=".$_GET['curP'];

	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objCommon->RemoveTerm($del_id);
					}
					$_SESSION['mess_term'] = TERM_REMOVED;
					break;
			case 'active':
					$objCommon->MultipleTermStatus($multiple_action_id,1);
					$_SESSION['mess_term'] = TERM_STATUS_CHANGED;
					break;
			case 'inactive':
					$objCommon->MultipleTermStatus($multiple_action_id,0);
					$_SESSION['mess_term'] = TERM_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/		

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_term'] = TERM_REMOVED;
		$objCommon->RemoveTerm($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_term'] = TERM_STATUS_CHANGED;
		$objCommon->changeTermStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			 CleanPost();
			 if (empty($_POST['termName'])) {
				$errMsg = ENTER_TERM;
			 } else {
				if (!empty($_POST['termID'])) {
					$termID = $_POST['termID'];
					$objCommon->UpdateTerm($_POST);
					$_SESSION['mess_term'] = TERM_UPDATED;
				} else {	
					$termID = $objCommon->AddTerm($_POST); 
					$_SESSION['mess_term'] = TERM_ADDED;
				}			
						

				header("Location:".$RedirectURL);
				exit;
			
			}
		}
		

	$Status = 1;
	if(!empty($_GET['edit'])){
		$arryTerm = $objCommon->GetTerm($_GET['edit'],'');
		$termID   = $_GET['edit'];	
		$Status = $arryTerm[0]['Status'];
	}
?>
<div><a href="<?=$RedirectURL?>"  class="back">Back</a></div>


<div class="had">
<?=$MainModuleName?>    <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

	<? if (!empty($errMsg)) {?>
    <div  class="red" ><?php echo $errMsg;?></div>
  <? } ?>


<script language="JavaScript1.2" type="text/javascript">
function validateTerm(frm){
	if(!ValidateForSimpleBlank(frm.termName, "Term Name")){
		return false;
	}

	if(document.getElementById("termType").value=='0'){
		if(!ValidateMandNumField2(frm.Day,"Net (days)",1,365)){
			return false;
		}
		if(document.getElementById("Due").value!=''){
			if(parseInt(document.getElementById("Due").value) < parseInt(document.getElementById("Day").value)){
				alert("Due days should not be less than Net days.");
				return false;
			}
		}

	}

	var Url = "isRecordExists.php?termName="+escape(document.getElementById("termName").value)+"&editID="+document.getElementById("termID").value;
	SendExistRequest(Url, "termName", "Term Name");
	return false;	
				
}



function SetTermType(){
	if(document.getElementById("termType").value=='1'){
		$("#DayTr").hide();
		$("#DueTr").hide();
	}else{
		$("#DayTr").show();
		$("#DueTr").show();
	}
}
</script>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateTerm(this);" enctype="multipart/form-data">
   <tr>
    <td  align="center" valign="top" >
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
        <td  align="right"   class="blackbold" width="45%"> Term Type  : </td>
        <td   align="left" >
<select name="termType" class="inputbox" id="termType" onchange="Javascript:SetTermType();">
  	<option value="1" <?  if($arryTerm[0]['termType']=="1"){echo "selected";}?>>Standard</option>
	<option value="0" <?  if($arryTerm[0]['termType']=="0"){echo "selected";}?>>Net</option>				
</select> 

            </td>
      </tr>
	<tr>
        <td  align="right"   class="blackbold" > Term Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="termName" type="text" class="inputbox" id="termName" value="<?php echo stripslashes($arryTerm[0]['termName']); ?>"  maxlength="30"   onKeyPress="Javascript:return isAlphaKey(event);"/>            </td>
      </tr>

	  
	 
   <tr style="display:none">
        <td  align="right"   > Term Date :  </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#termDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")?>:<?=date("Y")+5?>', 
		dateFormat: 'yy-mm-dd',
		minDate: "+1D", 
		changeMonth: true,
		changeYear: true

		}
	);
	$("#termDate").on("click", function () { 
			 $(this).val("");
		}
	);

});
</script>
<input id="termDate" name="termDate" readonly="" class="datebox" value="<?=$arryTerm[0]['termDate']?>"  type="text" >         </td>
      </tr> 


  <tr id="DayTr">
        <td align="right"   class="blackbold" >Net  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Day" type="text" class="textbox" id="Day" value="<?=$arryTerm[0]['Day']?>" size="2" maxlength="3" onkeypress="return isNumberKey(event);"/>	
	 (days)
	 </td>
      </tr> 



        <tr id="DueTr">
          <td align="right"   class="blackbold" >Due in  :</td>
          <td  align="left" >
	 <input name="Due" type="text" class="textbox" id="Due" value="<?=$arryTerm[0]['Due']?>" size="2" maxlength="3" onkeypress="return isNumberKey(event);" />	
			(days)
			</td>
        </tr>
         


  <!--tr>
          <td align="right"   class="blackbold" >Credit Limit  :</td>
          <td  align="left" >
 <? if($arryTerm[0]['CreditLimit']>0){
	  $CreditLimit = $arryTerm[0]['CreditLimit']; 
	} 
	 ?>

	 <input name="CreditLimit" type="text" class="textbox" id="CreditLimit" value="<?=$CreditLimit?>" maxlength="10" onkeypress="return isDecimalKey(event);" />	 <?=$Config['Currency']?>
							  
						  </td>
        </tr-->



	  
	
	
	<tr>
                      <td align="right"  class="blackbold">Status : </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>
	
</table>	
  




	
	  
	
	</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="termID" id="termID" value="<?=$_GET['edit']?>" />

</div>

</td>
   </tr>

   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	SetTermType();
</SCRIPT>


