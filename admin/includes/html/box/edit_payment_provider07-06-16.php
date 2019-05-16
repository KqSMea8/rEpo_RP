<?php
require_once($Prefix . "classes/finance.class.php");
require_once($Prefix."classes/finance.account.class.php");
require_once($Prefix."classes/paypal.invoice.class.php");
$objBankAccount=new BankAccount();
$objCommon = new common();
$objpaypalInvoice = new paypalInvoice();
$ModuleName = "Payment Provider";
$RedirectURL = "viewPaymentProvider.php";

$_GET['active_id']=(int)$_GET['active_id'];
$_GET['edit']=(int)$_GET['edit'];
 
if($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_prv'] = PAYPRV_STATUS_CHANGED;
    $objCommon->changeProviderStatus($_GET['active_id']);
    header("Location:" . $RedirectURL);
    exit;
}



if(!empty($_POST['Check']) && $_POST['ProviderID']==1) {
	$res=$objpaypalInvoice->checkCredential();
	if($res['status']==1){
		 $_SESSION['mess_prv'] = 'Valid Data!!';
	}else{
	 	$_SESSION['mess_prv'] = $res['error'];
	}    	
	header("Location:" . $RedirectURL);
	exit; 
}


if(!empty($_POST['Submit'])) {
    	CleanPost();	 
	if(!empty($_POST['ProviderID'])) {
	    $ProviderID = $_POST['ProviderID'];
	    $objCommon->UpdatePaymentProvider($_POST);
	    $_SESSION['mess_prv'] = PAYPRV_UPDATED;
	}
	header("Location:" . $RedirectURL);
	exit; 
}


$Status = 1;
if(!empty($_GET['edit'])) {
    $arryProvider = $objCommon->GetPaymentProvider($_GET['edit'], '');
    $ProviderID = $arryProvider[0]['ProviderID'];
    $Status = $arryProvider[0]['Status'];    
}
       
if(empty($ProviderID)){
	header("Location:" . $RedirectURL);
	exit;
}

$Config['NormalAccount']=1;
$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
/************************/

$CardTypeArray = array
(
	array("label" => "Visa",  "value" => "Visa"),
	array("label" => "MasterCard",  "value" => "MasterCard"),
	array("label" => "Discover",  "value" => "Discover"),
	array("label" => "Amex",  "value" => "Amex"),
); 


$arryExistingCardType=$objCommon->getExistingCardType($ProviderID);
foreach($arryExistingCardType as $key=>$values){
	$ArryCard = explode(", ",$values['CardType']);	
	foreach($ArryCard as $cardtype){
		$arryExistingcard[] = $cardtype;
	}	
}
$arryExistingcard = array_unique($arryExistingcard);

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
function validateThisForm(frm) {

	if(document.getElementById("paypalID") != null){
		if(document.getElementById("paypalID").value!=''){
			if(!isEmail(frm.paypalID)){
				return false;
			}
		}
	}

       
	ShowHideLoader('1','S');
	return true;
}
</script>



    <form name="form1" action=""  method="post" onSubmit="return validateThisForm(this);" enctype="multipart/form-data">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody>
       <tr>
            <td valign="top" align="center">
                <table width="100%" cellspacing="0" cellpadding="5" border="0" class="borderall">
                <tbody>
                    <tr>
                         <td align="left" class="head" colspan="2">General Information</td>
                    </tr>
                    <tr>
                         
                        <td  align="right"   class="blackbold" width="45%"> Provider Name  :  </td>
                        <td   align="left" >
                            <input name="ProviderName" type="text" class="inputbox disabled" readonly id="ProviderName" value="<?=stripslashes($arryProvider[0]['ProviderName'])?>"  maxlength="30"   />            </td>
                    
                    </tr>
                    
                    <tr>

			 <td  align="right"   class="blackbold" valign="top"> Card Type  : </td>
                        <td   align="left" valign="top">


                            <select name="CardType[]" class="inputbox"  id="CardType" multiple style="height:100px">
				<option value="">--- None ---</option>
<?
if(!empty($arryProvider[0]['CardType'])){
	$ArryCardType = explode(", ",$arryProvider[0]['CardType']);		
}else{
	$ArryCardType='';
}

for($i=0;$i<sizeof($CardTypeArray);$i++){
	if(!in_array($CardTypeArray[$i]['value'],$arryExistingcard)){
		$sel = in_array($CardTypeArray[$i]['value'],$ArryCardType)?("selected"):("");
		echo '<option value="'.$CardTypeArray[$i]['value'].'" '.$sel.'>'.$CardTypeArray[$i]['label'].'</option>';
	}
}
?>


 	
                            </select> 
                        </td>

                    </tr>
		  <tr>
                       
                        <td  align="right"   class="blackbold"> Provider Fee (%) : </td>
                        <td   align="left" >
                            <input name="ProviderFee" value="<?=$arryProvider[0]['ProviderFee']?>" type="text" class="textbox" size="5"  id="ProviderFee" maxlength="5" onkeypress="return isDecimalKey(event);" />
                        </td>
                    </tr>
                   

		 
                    <tr  >
                        <td  align="right"   class="blackbold"> GL Account  :  </td>
                        <td   align="left" >
                        <select name="glAccount" class="inputbox" id="glAccount">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['glAccount']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select>
                        </td>
                    </tr>
			 <tr>
                        <td align="right">Status</td>
                    
                    <td   align="left" >
                        <input type="radio" <?php echo $arryProvider[0]['Status']==1?"checked":''; ?>  value="1" id="Status" name="Status">
                        Active&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" <?php echo $arryProvider[0]['Status']==0?"checked":''; ?> value="0" id="Status" name="Status">
                        InActive </td>
                    </tr>  
 <tr>
                         <td align="left" class="head" colspan="2"><?=stripslashes($arryProvider[0]['ProviderName'])?> Credentials</td>
                    </tr>
		<? if($ProviderID==1){ ?>
		<tr >  
                        <td  align="right"   class="blackbold"> PayPal Email :</td>
                        <td   align="left" >
                            <input name="paypalID" value="<?=$arryProvider[0]['paypalID']?>" type="text" class="inputbox" id="paypalID"  maxlength="80" />
                        </td>
			 </tr>
		<tr >  
                        <td  align="right"   class="blackbold"> PayPal APP ID :</td>
                        <td   align="left" >
                            <input name="paypalAppid" value="<?=$arryProvider[0]['paypalAppid']?>" type="text" class="inputbox" id="paypalAppid"  maxlength="80" />
                        </td>
			 </tr>

<tr >  
                        <td  align="right"   class="blackbold"> PayPal API Username :</td>
                        <td   align="left" >
                            <input name="paypalUsername" value="<?=$arryProvider[0]['paypalUsername']?>" type="text" class="inputbox" id="paypalUsername"  maxlength="80" />
                        </td>
			 </tr>

<tr >  
                        <td  align="right"   class="blackbold"> PayPal API Password :</td>
                        <td   align="left" >
                            <input name="paypalPassword" value="<?=$arryProvider[0]['paypalPassword']?>" type="password" class="inputbox" id="paypalPassword"  maxlength="30" />
                        </td>
			 </tr>

<tr >  
                        <td  align="right"   class="blackbold"> PayPal API Signature :</td>
                        <td   align="left" >
                            <input name="paypalSignature" value="<?=$arryProvider[0]['paypalSignature']?>" type="text" class="inputbox" id="paypalSignature"  maxlength="80" />
                        </td>
			 </tr>

		<? }else if($ProviderID==2){ ?>
                    <tr >  
                        <td  align="right"   class="blackbold"> Partner Id :</td>
                        <td   align="left" >
                            <input data-msg="Partner id" name="ppfPartnerId" value="<?= $arryProvider[0]['ppfPartnerId'] ?>" type="text" class="inputbox validate" id="ppfPartnerId"    maxlength="50" />
                        </td>
			 </tr>
		 <tr>
                        <td  align="right"  class="blackbold" > Password :</td>
                        <td   align="left" >
                            <input data-msg="Password" name="ppfPassword" value="<?= $arryProvider[0]['ppfPassword'] ?>" type="text" class="inputbox validate" id="ppfPassword"    maxlength="50" />
                        </td>
                    </tr>

                    <tr>
                        <td  align="right" class="blackbold" > Vendor :</td>
                        <td   align="left" >
                            <input data-msg="Vendor" name="ppfVendor" value="<?= $arryProvider[0]['ppfVendor'] ?>" type="text" class="inputbox validate" id="ppfVendor"   maxlength="50" />
                        </td>
 </tr>
		 <tr>
                        <td  align="right"   class="blackbold" > User Id :</td>
                        <td   align="left" >
                            <input data-msg="User Id" name="ppfUserId" value="<?= $arryProvider[0]['ppfUserId'] ?>" type="text" class="inputbox validate" id="ppfUserId"    maxlength="50" />
                        </td>
                    </tr>
                 <? }else if($ProviderID==3){ ?>
                    
                    <tr >
                        <td  align="right"   class="blackbold" > API Login Id : </td>
                        <td   align="left" >
                            <input data-msg="API Login Id" name="anApiLoginId" value="<?= $arryProvider[0]['anApiLoginId'] ?>" type="text" class="inputbox validate" id="anApiLoginId" />
                        </td>
			 </tr> <tr>
                        <td  align="right"   class="blackbold" > Transaction Key : </td>
                        <td   align="left" >
                            <input data-msg="Transaction Key" name="anTransactionKey" value="<?= $arryProvider[0]['anTransactionKey'] ?>" type="text" class="inputbox validate" id="anTransactionKey" />
                        </td>
                    </tr>
		<? } ?>
                   
                 
                     
                    
                </tbody>
                </table>	
	</td>
   </tr>
   
    <tr>
            <td  align="center">
                <div id="SubmitDiv" style="display:none1">
                    <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />

<?php if($_GET['edit']==1){?>

 		   <input name="Check" type="submit" class="button" id="SubmitButton" value="Check"  />
<?}?>

                    <input type="hidden" name="ProviderID" id="ProviderID" value="<?= $_GET['edit'] ?>" />
                </div>
            </td>
        </tr>
</tbody>
</table>
       
    </form>




