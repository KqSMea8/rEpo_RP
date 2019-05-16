<?php
require_once($Prefix . "classes/finance.class.php");
//require_once($Prefix."classes/finance.account.class.php");
//$objBankAccount=new BankAccount();
$objCommon = new common();
$ModuleName = "Payment Term";
$RedirectURL = "viewTerm.php?curP=" . $_GET['curP'];


$_GET['del_id']=(int)$_GET['del_id'];
$_GET['active_id']=(int)$_GET['active_id'];
$_GET['edit']=(int)$_GET['edit'];


if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_term'] = TERM_REMOVED;
    $objCommon->RemoveTerm($_GET['del_id']);
    header("Location:" . $RedirectURL);
    exit;
}


if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_term'] = TERM_STATUS_CHANGED;
    $objCommon->changeTermStatus($_GET['active_id']);
    header("Location:" . $RedirectURL);
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


        header("Location:" . $RedirectURL);
        exit;
    }
}

$ReadOnlyBox = $disabledClass='';


$Status = 1;
if (!empty($_GET['edit'])) {
    $arryTerm = $objCommon->GetTerm($_GET['edit'], '');
    $termID = $_GET['edit'];
    $Status = $arryTerm[0]['Status'];
    if($arryTerm[0]['fixed']=='1'){
	$ReadOnlyBox = 'Readonly';
	$disabledClass = ' disabled';
    }
}else{
$arryTerm = $objConfigure->GetDefaultArrayValue('f_term');
}
       

//$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();

$arryProvider = $objCommon->GetPaymentProvider('', '1');

?>
<div><a href="<?= $RedirectURL ?>"  class="back">Back</a></div>


<div class="had">
    <?= $MainModuleName ?>    <span> &raquo;
        <? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>

    </span>
</div>

<? if (!empty($errMsg)) {?>
<div  class="red" ><?php echo $errMsg; ?></div>
<? } ?>

<script language="JavaScript1.2" type="text/javascript">
    function validateTerm(frm) {
        if (!ValidateForSimpleBlank(frm.termName, "Term Name")) {
            return false;
        }

        if (document.getElementById("termType").value == '0') {
            if (!ValidateMandNumField2(frm.Day, "Net (days)", 1, 365)) {
                return false;
            }
        }      
       
        var Url = "isRecordExists.php?termName="+escape(document.getElementById("termName").value)+"&editID="+escape(document.getElementById("termID").value);
        SendExistRequest(Url, "termName", "Term Name");
        return false;
    }



    function SetTermType() {
        if (document.getElementById("termType").value == '1') {
            $("#DayTr").hide();
            $("#DueTr").hide();
        } else {
            $("#DayTr").show();
            $("#DueTr").show();
        }
    }

 

</script>



    <form name="form1" action=""  method="post" onSubmit="return validateTerm(this);" enctype="multipart/form-data">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody>
       <tr>
            <td valign="top" align="center">
                <table width="100%" cellspacing="0" cellpadding="5" border="0" class="borderall">
                <tbody>
                    
                    <tr>
                        <td  align="right"   class="blackbold" width="45%"> Term Type  : </td>
                        <td align="left" >

			<?
			if($arryTerm[0]['fixed']=='1'){
				echo ($arryTerm[0]["termType"]==1)?('Standard'):('Net');
				echo '<input type="hidden" name="termType" id="termType" value="'.$arryTerm[0]["termType"].'">';
			}else{
			?>	
                            <select name="termType" class="inputbox<?=$disabledClass?>" id="termType" onchange="Javascript:SetTermType();">
                                <option value="1" <?  if($arryTerm[0]['termType']=="1"){echo "selected";}?>>Standard</option>
                                <option value="0" <?  if($arryTerm[0]['termType']=="0"){echo "selected";}?>>Net</option>				
                            </select> 
			<? } ?>
                        </td>
		 </tr>
			 <tr>
                        <td  align="right"   class="blackbold" width="15%"> Term Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="termName" type="text" class="inputbox<?=$disabledClass?>" <?=$ReadOnlyBox?> id="termName" value="<?php echo stripslashes($arryTerm[0]['termName']); ?>"  maxlength="30"   onKeyPress="Javascript:return isAlphaKey(event);"/>            </td>
                    
                    </tr>
                    
                    <tr id="DayTr">
                        <td  align="right" class="blackbold" >Net  :<span class="red">*</span></td>
                        <td  align="left" >
                            <input name="Day" type="text" class="inputbox" id="Day" value="<?= $arryTerm[0]['Day'] ?>" size="2" maxlength="3" onkeypress="return isNumberKey(event);"/>	
                            (days)
                        </td>
                    </tr> 
                    <tr id="DueTr"  >
                        <td align="right" class="blackbold" >Due in  :</td>
                        <td  align="left" colspan="2" >
                            <input name="Due" type="text" class="inputbox" id="Due" value="<?= $arryTerm[0]['Due'] ?>" size="2" maxlength="3" onkeypress="return isNumberKey(event);" />	
                            (days)
                        </td>
                    </tr>
  
                    <!--tr>
                        <td  align="right"   class="blackbold" >   Payment Provider  : </td>
                        <td  align="left"  >
                            
                            <select name="paymentType" class="inputbox" id="paymentType" >
				<option value="" > None</option>
                                <? foreach($arryProvider as $key=>$values){ 
					$sel = ($arryTerm[0]['paymentType'] == $values['ProviderID']) ? ("selected") : ("");
					echo '<option value="'.$values['ProviderID'].'" '.$sel.'>'.$values['ProviderName'].'</option>';
				 } ?>
                            </select> 
                        </td>
                    </tr-->
                    
                    <!--tr>
                        <td align="right"  class="blackbold">Associate GL Account : </td>
                        <td align="left" >

<input name="glAccountStatus" type="radio" value="1" <?= ($arryTerm[0]['glAccount'] != 0) ? "checked" : "" ?> /> Yes
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="glAccountStatus" type="radio" <?= ($arryTerm[0]['glAccount'] == 0) ? "checked" : "" ?> value="0" /> No

                          
                        </td>
                    </tr>
                    <tr class="glAccount"  <?  if($arryTerm[0]['glAccount']<=0){echo 'style="display:none"';}?>>
                        <td  align="right"   class="blackbold"> Default Account  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <select name="glAccount" class="inputbox" id="glAccount" >	
                                <?php if(!empty($arryBankAccount)){
                                    foreach($arryBankAccount as $arryBankAccountVal){ ?>
                                        <option value="<?php echo $arryBankAccountVal['BankAccountID']; ?>"  <?= ($arryTerm[0]['glAccount'] == $arryBankAccountVal['BankAccountID']) ? "selected" : "" ?> ><?php echo $arryBankAccountVal['AccountName']; ?></option>
                                   <?php } } ?>
                            </select> 
                        </td>
                    </tr-->
                   
                    <tr>
                        <td align="right">Status</td>
                    
                    <td   align="left" >
                        <input type="radio" <?php echo $Status==1?"checked":''; ?>  value="1" id="Status" name="Status">
                        Active&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" <?php echo $Status==0?"checked":''; ?> value="0" id="Status" name="Status">
                        InActive </td>
                    </tr>    
                    
                </tbody>
                </table>	
	</td>
   </tr>
   
    <tr>
            <td  align="center">
                <div id="SubmitDiv" style="display:none1">
                    <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="termID" id="termID" value="<?= $_GET['edit'] ?>" />
                </div>
            </td>
        </tr>
</tbody>
</table>
       
    </form>

<script type="text/javascript">
 SetTermType();   
</script>
 
<script>

    $('form[name=form1] input[name=glAccountStatus]').on('change', function() {
        parseInt($(this).val())?$(".glAccount").show():$(".glAccount").hide();
    });
   
</script>



