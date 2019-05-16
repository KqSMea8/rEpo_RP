<?php
require_once($Prefix . "classes/finance.class.php");
require_once($Prefix."classes/finance.account.class.php");
$objBankAccount=new BankAccount();
$objCommon = new common();
$ModuleName = "Payment Term";
$RedirectURL = "viewTerm.php?curP=" . $_GET['curP'];


/* * *******  Multiple Actions To Perform ********* */
if (!empty($_GET['multiple_action_id'])) {
    $multiple_action_id = rtrim($_GET['multiple_action_id'], ",");

    $mulArray = explode(",", $multiple_action_id);

    switch ($_GET['multipleAction']) {
        case 'delete':
            foreach ($mulArray as $del_id) {
                $objCommon->RemoveTerm($del_id);
            }
            $_SESSION['mess_term'] = TERM_REMOVED;
            break;
        case 'active':
            $objCommon->MultipleTermStatus($multiple_action_id, 1);
            $_SESSION['mess_term'] = TERM_STATUS_CHANGED;
            break;
        case 'inactive':
            $objCommon->MultipleTermStatus($multiple_action_id, 0);
            $_SESSION['mess_term'] = TERM_STATUS_CHANGED;
            break;
    }
    header("location: " . $RedirectURL);
    exit;
}

/* * *******  End Multiple Actions ********* */

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
	$_POST['expiryDate'] = $_POST['expiryYear'].'-'.$_POST['expiryMonth'].'-01';
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


$Status = 1;
if (!empty($_GET['edit'])) {
    $arryTerm = $objCommon->GetTerm($_GET['edit'], '');
    $termID = $_GET['edit'];
    $Status = $arryTerm[0]['Status'];
    if($arryTerm[0]['fixed']=='1'){
	$ReadOnlyBox = 'Readonly';
	$disabledClass = ' disabled';
    }
}
       

$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();



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

<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
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
      
        var breakOut = false;
        $("."+$("#paymentType").val()).each(function(){
            if(breakOut){return !breakOut;}
            $(this).find(".validate").each(function(){
                if(!ValidateForSimpleBlank(document.getElementById($(this).attr("id")), $(this).attr("data-msg"))){return !(breakOut = !breakOut); }
            });
        });
        if(breakOut){return !breakOut;}
             
        var Url = "isRecordExists.php?termName=" + escape(document.getElementById("termName").value) + "&editID=" + document.getElementById("termID").value;
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

	

function getSelectedCard(sel){    
	 
    if(sel.value == 'Amex'){
          $("#cardNumber").mask("9999-999999-99999");  
          $("#cvv").mask("9999");
    }
    else{
        $("#cardNumber").mask("9999-9999-9999-9999");
        $("#cvv").mask("999");
        }
        
}




    function SetPaymentType555() {
        if (document.getElementById("paymentType").value == '') {
            $(".paypalPayFlow").hide();
            $(".creditCard").hide();
	    $(".authorizeNet").hide();

	  
	    $(".red").hide();	
	    $("#DayTr .red").show();

        } else {
            $(".paypalPayFlow").show();
            $(".creditCard").show();
	    $(".authorizeNet").show();



	   /* $("."+$("#paymentType").val()).each(function(){
		var  paymentType = $("#paymentType").val();
		if(paymentType=='paypalPayFlow'){
			$(".paypalPayFlow .red").show();
			$(".creditCard .red").hide();
			$(".authorizeNet .red").hide();
		}else if(paymentType=='creditCard'){
			$(".paypalPayFlow .red").hide();
			$(".creditCard .red").show();
			$(".authorizeNet .red").hide();
		}else if(paymentType=='authorizeNet'){
			$(".paypalPayFlow .red").hide();
			$(".creditCard .red").hide();
			$(".authorizeNet .red").show();
		}	
	    });*/


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
                         <td align="left" class="head" colspan="4">General Information</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold" width="15%"> Term Type  : </td>
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
  
                    <tr>
                        <td  align="right"   class="blackbold" > Default Payment Type  : </td>
                        <td  align="left"  > 
                            
                            <select name="paymentType" class="inputbox" id="paymentType" >
				<option value="None" <?= $arryTerm[0]['paymentType']=='None'?'selected':''; ?> > None</option>
                                <option value="paypalPayFlow" <?= $arryTerm[0]['paymentType']=='paypalPayFlow'?'selected':''; ?> > Paypal Pay Flow </option>
                                <option value="authorizeNet" <?= $arryTerm[0]['paymentType']=='authorizeNet'?'selected':''; ?> > Authorize.net </option>
                                 <option value="creditCard"  <?= $arryTerm[0]['paymentType']=='creditCard'?'selected':''; ?> > Credit Card </option>
                            </select> 
                        </td>
                    </tr>
                    <tr class="paypalPayFlow">
                         <td align="left" class="head" colspan="4">Paypal Pay FLow</td>
                    </tr>
                    <tr class="paypalPayFlow" >  
                        <td  align="right"   class="blackbold"> Partner Id :<span class="red">*</span></td>
                        <td   align="left" >
                            <input data-msg="Partner id" name="ppfPartnerId" value="<?= $arryTerm[0]['ppfPartnerId'] ?>" type="text" class="inputbox validate" id="ppfPartnerId" size="50"  maxlength="50" />
                        </td>
                        <td  align="right"  class="blackbold" > Password :<span class="red">*</span></td>
                        <td   align="left" >
                            <input data-msg="Password" name="ppfPassword" value="<?= $arryTerm[0]['ppfPassword'] ?>" type="text" class="inputbox validate" id="ppfPassword" size="50"  maxlength="50" />
                        </td>
                    </tr>

                    <tr class="paypalPayFlow" >
                        <td  align="right" class="blackbold" > Vendor :<span class="red">*</span></td>
                        <td   align="left" >
                            <input data-msg="Vendor" name="ppfVendor" value="<?= $arryTerm[0]['ppfVendor'] ?>" type="text" class="inputbox validate" id="ppfVendor" size="50"  maxlength="50" />
                        </td>
                        <td  align="right"   class="blackbold" > User Id :<span class="red">*</span></td>
                        <td   align="left" >
                            <input data-msg="User Id" name="ppfUserId" value="<?= $arryTerm[0]['ppfUserId'] ?>" type="text" class="inputbox validate" id="ppfUserId" size="50"  maxlength="50" />
                        </td>
                    </tr>
                    
                    <tr class="authorizeNet">
                         <td align="left" class="head" colspan="4">Authorize .Net</td>
                    </tr>
                    <tr class="authorizeNet" >
                        <td  align="right"   class="blackbold" > API Login Id :<span class="red">*</span></td>
                        <td   align="left" >
                            <input data-msg="API Login Id" name="anApiLoginId" value="<?= $arryTerm[0]['anApiLoginId'] ?>" type="text" class="inputbox validate" id="anApiLoginId" />
                        </td>
                        <td  align="right"   class="blackbold" > Transaction Key :<span class="red">*</span></td>
                        <td   align="left" >
                            <input data-msg="Transaction Key" name="anTransactionKey" value="<?= $arryTerm[0]['anTransactionKey'] ?>" type="text" class="inputbox validate" id="anTransactionKey" />
                        </td>
                    </tr>
                    <tr class="creditCard">
                         <td align="left" class="head" colspan="4">Credit Card</td>
                    </tr>
                    <tr class="creditCard" >

			 <td  align="right"   class="blackbold" > Card Type  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <select name="cardType" class="inputbox validate" data-msg="Card Type" id="cardType" onchange="getSelectedCard(this)">
				<option value="">--- Select ---</option>
				<option value="Visa" <?  if($arryTerm[0]['cardType']=="Visa"){echo "selected";}?>>Visa</option>
				<option value="MasterCard" <?  if($arryTerm[0]['cardType']=="MasterCard"){echo "selected";}?>>MasterCard</option>
				<option value="Discover" <?  if($arryTerm[0]['cardType']=="Discover"){echo "selected";}?>>Discover</option>
				<option value="Amex" <?  if($arryTerm[0]['cardType']=="Amex"){echo "selected";}?>>American Express</option>		
                            </select> 
                        </td>

                        <td  align="right"   class="blackbold" > Card Number :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="cardNumber" value="<?= $arryTerm[0]['cardNumber'] ?>" type="text" class="inputbox validate" data-msg="Card Number" id="cardNumber" size="16"  maxlength="16" onkeypress="return isNumberKey(event);"/>
                        </td>
                      
                    </tr>
                    <tr class="creditCard" >
                        <td  align="right"   class="blackbold"> Expiry Date :<span class="red">*</span> </td>
                        <td   align="left" >
                            
<?  
if($arryTerm[0]['expiryDate']>0){
	$arryDt = explode("-",$arryTerm[0]['expiryDate']);
}
?>


<?=getMonths($arryDt[1],"expiryMonth","textbox")?>&nbsp;&nbsp;<?=getExpireYears($arryDt[0],"expiryYear","textbox")?>



                        </td>
                         <td  align="right"   class="blackbold"> Security Code :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="cvv" value="<?= $arryTerm[0]['cvv'] ?>" type="text" class="inputbox validate" data-msg="Security Code" id="cvv" size="3"  maxlength="3" onkeypress="return isNumberKey(event);"/>
                        </td>
                    </tr>
                    <tr class="creditCard" >
                        <td  align="right" class="blackbold"> Billing Address :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="billingAddress" value="<?= $arryTerm[0]['billingAddress'] ?>" type="text" class="inputbox validate" data-msg="Billing Address" id="billingAddress" />
                        </td>
                        <td  align="right"   class="blackbold" > City :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="billingCity" value="<?= $arryTerm[0]['billingCity'] ?>" type="text" class="inputbox validate" data-msg="City" id="billingCity" />
                        </td>
                    </tr>
                    <tr class="creditCard" >
                        <td  align="right"   class="blackbold" > State :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="billingState" value="<?= $arryTerm[0]['billingState'] ?>" type="text"  class="inputbox validate" data-msg="State" id="billingState" />
                        </td>
                        <td  align="right"   class="blackbold"> Zipcode :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="billingZipCode" value="<?= $arryTerm[0]['billingZipCode'] ?>" type="text"  class="inputbox validate" data-msg="Zipcode" id="billingZipCode" maxlength="6" onkeypress="return isNumberKey(event);" />
                        </td>
                    </tr>
                    <tr class="creditCard" >
                        <td  align="right"   class="blackbold"> Country :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="billingCountry" value="<?= $arryTerm[0]['billingCountry'] ?>" type="text" class="inputbox validate" data-msg="Country"  id="billingCountry" />
                        </td>
                        <td  align="right"   class="blackbold"> Rate (%) :<span class="red">*</span></td>
                        <td   align="left" >
                            <input name="rate" value="<?= $arryTerm[0]['rate'] ?>" type="text" class="inputbox validate" data-msg="Rate (%)"  id="rate" maxlength="2" onkeypress="return isNumberKey(event);" />
                        </td>
                    </tr>

                    <tr>
                         <td align="left" class="head" colspan="4">Other information</td>
                    </tr>
                    <tr>
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
                    </tr>
                    <?php      
                    /*
                     *    END's HERE
                     */ ?>
                    <tr>
                        <td align="right">Status</td>
                    
                    <td   align="left" >
                        <input type="radio" <?php echo $arryTerm[0]['Status']==1?"checked":''; ?>  value="1" id="Status" name="Status">
                        Active&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" <?php echo $arryTerm[0]['Status']==0?"checked":''; ?> value="0" id="Status" name="Status">
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
    $(function () {
   
            $('#termDate').datepicker(
                {
                    showOn: "both",
                    yearRange: '<?= date("Y") ?>:<?= date("Y") + 5 ?>',
                    dateFormat: 'yy-mm-dd',
                    minDate: "+1D",
                    changeMonth: true,
                    changeYear: true
                }
            );
            $("#termDate").on("click", function () {
                $(this).val("");
            });
    });
</script>
 
<script>
$("#paymentType").change(function(){



	if(document.getElementById("paymentType").value == 'None') {
            $(".paypalPayFlow").hide();
            $(".creditCard").hide();
	    $(".authorizeNet").hide();
        } else {
	 
            $(".paypalPayFlow").show();
            $(".creditCard").show();
	    $(".authorizeNet").show();
	}



        $(".validate").each(function(){$(this).parent("td").siblings().find("span.red").html("")});
        $("."+$(this).val()).each(function(){
            $(this).find(".validate").each(function(){
                 $(this).parent("td").siblings().find("span.red").each(function(){$(this).html("*")});                
            });           
        });
    });

    $('form[name=form1] input[name=glAccountStatus]').on('change', function() {
        parseInt($(this).val())?$(".glAccount").show():$(".glAccount").hide();
    });
    $("document").ready(function(){
        $("form[name=form1] input[name=glAccountStatus]:checked,#paymentType").trigger("change");
       
	//SetPaymentType();
    });
</script>



