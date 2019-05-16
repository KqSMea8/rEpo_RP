<?php 
require_once($Prefix . "classes/finance.class.php");
require_once($Prefix."classes/finance.account.class.php");
$objBankAccount=new BankAccount();
$objCommon = new common();
$ModuleName = "Payment Method";
$RedirectURL = "viewMethod.php";


$_GET['del_id']=(int)$_GET['del_id'];
$_GET['active_id']=(int)$_GET['active_id'];
$_GET['edit']=(int)$_GET['edit'];

if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_method'] = METHOD_REMOVED;
    $objCommon->RemoveMethod($_GET['del_id']);
    header("Location:" . $RedirectURL);
    exit;
}


if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_method'] = METHOD_STATUS_CHANGED;
    $objCommon->changeMethodStatus($_GET['active_id']);
    header("Location:" . $RedirectURL);
    exit;
}



if ($_POST) {
    CleanPost();
	
    if($_POST['methodType']==1){
		$_POST['glAccount']=0;
    }


    if (empty($_POST['methodName'])) {
        $errMsg = ENTER_METHOD;
    } else { 	
        if (!empty($_POST['methodID'])) {
            $methodID = $_POST['methodID'];
            $objCommon->UpdateMethod($_POST);
            $_SESSION['mess_method'] = METHOD_UPDATED;
        } else {
            $methodID = $objCommon->AddMethod($_POST);
            $_SESSION['mess_method'] = METHOD_ADDED;
        }


        header("Location:" . $RedirectURL);
        exit;
    }
}


$Status = 1;
if (!empty($_GET['edit'])) {
    $arryMethod = $objCommon->GetMethod($_GET['edit'], '');
    $methodID = $_GET['edit'];
    $Status = $arryMethod[0]['Status'];
    if($arryMethod[0]['fixed']=='1'){
	$ReadOnlyBox = 'Readonly';
	$disabledClass = ' disabled';
    }
}
       

$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();

 

?>
<div><a href="<?= $RedirectURL ?>"  class="back">Back</a></div>


<div class="had">
    <?= $ModuleName ?>    <span> &raquo;
        <? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>

    </span>
</div>

<? if (!empty($errMsg)) {?>
<div  class="red" ><?php echo $errMsg; ?></div>
<? } ?>

<script language="JavaScript1.2" type="text/javascript">
    function validateTerm(frm) {
        if (!ValidateForSimpleBlank(frm.methodName, "Payment Method")) {
            return false;
        }

       /*if (document.getElementById("methodType").value == '0') {
            if (!ValidateMandNumField2(frm.Day, "Net (days)", 1, 365)) {
                return false;
            }
        }*/      
       
        var Url = "isRecordExists.php?methodName="+escape(document.getElementById("methodName").value)+"&editID="+escape(document.getElementById("methodID").value);
        SendExistRequest(Url, "methodName", "Payment Method");
        return false;
    }



    function SetMethodsType55() {
        if (document.getElementById("methodType").value == '1') {
            $("#DayTr").hide();
            $("#DueTr").hide();
        } else {
            $("#DayTr").show();
            $("#DueTr").show();
        }
    }

    function SetMethodType() {
        if(document.getElementById("methodType").value == '1') {
            $("#glAccountTr").hide(); 	        
        } else {
            $("#glAccountTr").show();            
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
                        <td  align="right"   class="blackbold" width="45%">Payment Type  : </td>
                        <td align="left" >

			<?
			if($arryMethod[0]['fixed']=='1'){
				echo ($arryMethod[0]["methodType"]==1)?('Standard'):('Term');
				echo '<input type="hidden" name="methodType" id="methodType" value="'.$arryMethod[0]["methodType"].'">';
			}else{
			?>	
                            <select name="methodType" class="inputbox<?=$disabledClass?>" id="methodType" onchange="Javascript:SetMethodType();">
                                <option value="1" <?  if($arryMethod[0]['methodType']=="1"){echo "selected";}?>>Standard</option>
                                <option value="0" <?  if($arryMethod[0]['methodType']=="0"){echo "selected";}?>>Term</option>				
                            </select> 
			<? } ?>
                        </td>
		 </tr>
			 <tr>
                        <td  align="right"   class="blackbold" width="15%">Payment Method  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="methodName" type="text" class="inputbox<?=$disabledClass?>" <?=$ReadOnlyBox?> id="methodName" value="<?php echo stripslashes($arryMethod[0]['methodName']); ?>"  maxlength="30"   onKeyPress="Javascript:return isAlphaKey(event);"/>            </td>
                    
                    </tr>
                    
                    <!--tr id="DayTr">
                        <td  align="right" class="blackbold" >Net  :<span class="red">*</span></td>
                        <td  align="left" >
                            <input name="Day" type="text" class="inputbox" id="Day" value="<?= $arryMethod[0]['Day'] ?>" size="2" maxlength="3" onkeypress="return isNumberKey(event);"/>	
                            (days)
                        </td>
                    </tr> 
                    <tr id="DueTr"  >
                        <td align="right" class="blackbold" >Due in  :</td>
                        <td  align="left" colspan="2" >
                            <input name="Due" type="text" class="inputbox" id="Due" value="<?= $arryMethod[0]['Due'] ?>" size="2" maxlength="3" onkeypress="return isNumberKey(event);" />	
                            (days)
                        </td>
                    </tr-->
  
                    
                    
                   <? if(empty($arryCompany[0]['Department']) || in_array("6",$arryCmpDepartment)){ ?>
                    <tr id="glAccountTr" >
                        <td  align="right"   class="blackbold"> Bank Account  :  </td>
                        <td   align="left" >
                            <select name="glAccount" class="inputbox" id="glAccount" >	
                                  <option value="">--- None ---</option>
<? for($i=0;$i<sizeof($arryBankAccount);$i++) {
	$selected='';
	if($_GET['edit']>0){ 
		if($arryBankAccount[$i]['BankAccountID']==$arryMethod[0]['glAccount']) $selected='Selected'; 
	} 

?>
     <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?=$selected?>>
     <?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>

<? } ?>

                            </select> 
                        </td>
                    </tr>
			<? } ?>
                   
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
                    <input type="hidden" name="methodID" id="methodID" value="<?= $_GET['edit'] ?>" />
                </div>
            </td>
        </tr>
</tbody>
</table>
       
    </form>

<script type="text/javascript">
 SetMethodType();   
</script>
 
 



