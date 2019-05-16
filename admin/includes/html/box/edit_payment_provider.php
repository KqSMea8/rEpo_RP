<?php
require_once($Prefix . "classes/finance.class.php");
require_once($Prefix."classes/finance.account.class.php");

require_once($Prefix."lib/paypal/invoice/src/angelleye/PayPal/PayPal.php");
require_once($Prefix."lib/paypal/invoice/src/angelleye/PayPal/Adaptive.php");
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


/**********************************/
/**********************************/
if(!empty($_POST['Check'])) {

	if($_POST['ProviderID']==1){
		$res=$objpaypalInvoice->checkCredential();
	}else if($_POST['ProviderID']==2){
		$arryProvider[0]['ppfUserId']=$_POST['ppfUserId'];
		$arryProvider[0]['ppfPassword']=$_POST['ppfPassword'];
		$arryProvider[0]['ppfVendor']=$_POST['ppfVendor'];
		$arryProvider[0]['ppfPartnerId']=$_POST['ppfPartnerId'];

		require_once("../api/PaypalPayflow/paypalfunctions.php");
		  
		
		$arryTransaction = DirectPayment ( "Sale", 1, 'Visa', $creditCardNumber, $expDateMonth.$expDateYear, $cvv2Number, $firstName, $lastName, $address1, $city, $state, $zip, $country, $currencyCode, $orderDescription,'' );
		 
		$RESULT = $arryTransaction['RESULT'];	
		 
		if($RESULT==1 || $RESULT==26){
			$res['status']=0;
			$res['errors'] = $arryTransaction["RESPMSG"];
		}else{
			$res['status']=1;
		} 

	}else if($_POST['ProviderID']==3){
		$arryProvider[0]['anApiLoginId']=$_POST['anApiLoginId'];
		$arryProvider[0]['anTransactionKey']=$_POST['anTransactionKey'];
 
	 	require_once("../api/Authorize.Net/config.php");

		$authnet_values	= array
		(
			"x_login"			=> $auth_net_login_id,
		 	"x_tran_key"			=> $auth_net_tran_key,
			"x_version"			=> $auth_version,
			"x_delim_char"			=> $auth_delim_char,
			"x_delim_data"			=> $auth_delim_data,
			"x_type"			=> "AUTH_CAPTURE",
			"x_method"			=> "CC"
	
		);
		$fields = "";
		foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
		//echo $fields;exit;
		$ch = curl_init($auth_net_url); 
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
		$resp = curl_exec($ch); 
		curl_close ($ch);
		$TestArry = explode($auth_delim_char,$resp);	

		if($TestArry[2]==13 || $TestArry[2]==103){	
			$res['status']=0;
			$res['errors'] = 'The merchant login ID or password is invalid or the account is inactive.'; 
		}else{
			$res['status']=1;
		} 

	}else if($_POST['ProviderID']==4){
		require_once("../api/Velocity/velocityApi.php");		 
		$objVelocity = new Velocity($_POST);
		$res = $objVelocity->validateCredential();
		 
	}




	if($res['status']==1){
		 $_SESSION['mess_prv'] = 'Authentication Validated Successfully.';
	}else{
	 	$_SESSION['mess_prv'] = $res['errors'];
	}    	
 	$RedirectURL = "editPaymentProvider.php?edit=".$_POST['ProviderID'];
	header("Location:" . $RedirectURL);
	exit; 
}
/**********************************/
/**********************************/

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

//$Config['NormalAccount']=1;
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
<div class="message" align="center"><? if(!empty($_SESSION['mess_prv'])) {echo $_SESSION['mess_prv']; unset($_SESSION['mess_prv']); }?></div>
 
<script language="JavaScript1.2" type="text/javascript">
function validateThisForm(frm) {
	if(document.getElementById("AccountPaypal") != null){
		if(document.getElementById("AccountPaypal").value!='' && document.getElementById("AccountPaypal").value==document.getElementById("AccountPaypalFee").value){
			alert("Please do not select same gl account for PayPal Email and PayPal Fee.");	
			return false;
		}
	}


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


jQuery('document').ready(function(){
		jQuery('.authopen').click(function(){
			window.open("https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?scope=https://uri.paypal.com/services/invoicing email&response_type=code&redirect_uri=https://www.eznetcrm.com/erp/paypalAuthAccept.php&client_id=AQZ4wvC7sS6xKMgfNWdyqjmAYDxKLkdKNE5TEepaDKWIXouZKC5tki2rr1_nW-L0ok-b4VipmLB-0ny4", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=500,width=500,height=600");
			
		});
	
});
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



<tr class="visa" >
                        <td  align="right"   class="blackbold"> GL Account  [Visa] :  </td>
                        <td   align="left" >
                        <select name="VisaGL" class="inputbox" id="VisaGL">
						<option value="">--- None ---</option>
						<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
						<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['VisaGL']){echo "selected";}?>>
						<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
						<? } ?>
						</select>
                        </td>
                    </tr>                 


					<tr class="mastercard" >
                        <td  align="right"   class="blackbold"> GL Account  [MasterCard] :  </td>
                        <td   align="left" >
                        <select name="MasterCardGL" class="inputbox" id="MasterCardGL">
						<option value="">--- None ---</option>
						<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
						<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['MasterCardGL']){echo "selected";}?>>
						<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
						<? } ?>
						</select>
                        </td>
                    </tr>
              


					<tr class="discover" >
                        <td  align="right"   class="blackbold"> GL Account  [Discover] :  </td>
                        <td   align="left" >
                        <select name="DiscoverGL" class="inputbox" id="DiscoverGL">
						<option value="">--- None ---</option>
						<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
						<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['DiscoverGL']){echo "selected";}?>>
						<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
						<? } ?>
						</select>
                        </td>
                    </tr>
 
					<tr class="amex" >
                        <td  align="right"   class="blackbold"> GL Account  [Amex] :  </td>
                        <td   align="left" >
                        <select name="AmexGL" class="inputbox" id="AmexGL">
						<option value="">--- None ---</option>
						<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
						<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['AmexGL']){echo "selected";}?>>
						<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
						<? } ?>
						</select>
                        </td>
                    </tr>










		  <tr>
                       
                        <td  align="right"   class="blackbold"> Provider Fee (%) : </td>
                        <td   align="left" >
                            <input name="ProviderFee" value="<?=$arryProvider[0]['ProviderFee']?>" type="text" class="textbox" size="5"  id="ProviderFee" maxlength="5" onkeypress="return isDecimalKey(event);" />
                        </td>
                    </tr>
                   

		 
                    <!--tr>
                        <td  align="right"   class="blackbold"> GL Account  [Credit Card] :  </td>
                        <td   align="left" >
                        <select name="glAccount" class="inputbox" id="glAccount">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['glAccount']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select>
                        </td>
                    </tr-->

		<? if($ProviderID==1 || $ProviderID==2){?>
	
 		<tr>
                        <td  align="right"   class="blackbold"> GL Account  [PayPal Email] :  </td>
                        <td   align="left" >
                        <select name="AccountPaypal" class="inputbox" id="AccountPaypal">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['AccountPaypal']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select>
                        </td>
                    </tr>

		 <tr>
                        <td  align="right"   class="blackbold"> GL Account  [PayPal Fee] :  </td>
                        <td   align="left" >
                        <select name="AccountPaypalFee" class="inputbox" id="AccountPaypalFee">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['AccountPaypalFee']){echo "selected";}?>>
			<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select>
                        </td>
                    </tr>
		 

		<? } ?>


		 <tr>
                        <td  align="right"   class="blackbold"> GL Account  [CreditCard Fee] :  </td>
                        <td   align="left" >
                        <select name="AccountCardFee" class="inputbox" id="AccountCardFee">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
			<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryProvider[0]['AccountCardFee']){echo "selected";}?>>
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
		<!--tr >  
                        <td  align="right"   class="blackbold"> PayPal APP ID :</td>
                        <td   align="left" >
                            <input name="paypalAppid" value="<?=$arryProvider[0]['paypalAppid']?>" type="text" class="inputbox" id="paypalAppid"  maxlength="80" />
                        </td>
			 </tr-->

		<tr >  
                        <td  align="right"   class="blackbold"> PayPal Token :</td>
                        <td   align="left" >
                            <input name="PaypalToken" value="<?=$arryProvider[0]['PaypalToken']?>" type="text" class="disabled_inputbox" id="PaypalToken" readonly />

<? if(empty($arryProvider[0]['PaypalToken'])){?>
<a class="action_bt authopen" href="javascript:void(0)">PayPal Authorize</a>
<? } ?>

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
		<? }else if($ProviderID==4){ ?>
                    <tr >  
                        <td  align="right"   class="blackbold"> Merchant Profile ID :</td>
                        <td   align="left" >
                            <input data-msg="Merchant Profile ID" name="NabMerchantID" value="<?= $arryProvider[0]['NabMerchantID'] ?>" type="text" class="inputbox validate" id="NabMerchantID"    maxlength="100" />
                        </td>
						 </tr>
		 <tr style="display:none">
                        <td  align="right"  class="blackbold" > Industry :</td>
                        <td   align="left" >
                            <input data-msg="Industry" name="NabIndustry" value="<?= $arryProvider[0]['NabIndustry'] ?>" type="text" class="inputbox disabled" readonly id="NabIndustry" />
                        </td>
                    </tr>

                  
				 
				  <tr>
                        <td  align="right"   class="blackbold" > Application Profile ID :</td>
                        <td   align="left" >
                            <input data-msg="Application Profile ID" name="NabApplicationID" value="<?= $arryProvider[0]['NabApplicationID'] ?>" type="text" class="inputbox" id="NabApplicationID"    maxlength="50" />
                        </td>
                    </tr>
                    
                      <tr>
                        <td  align="right"   class="blackbold" > Workflow/Service ID :</td>
                        <td   align="left" >
                            <input data-msg="Workflow Service ID" name="NabServiceID" value="<?= $arryProvider[0]['NabServiceID'] ?>" type="text" class="inputbox validate" id="NabServiceID"    maxlength="50" />
                        </td>
                    </tr>

			  <tr>
                        <td  align="right" class="blackbold" valign="top"> Identity Token :</td>
                        <td   align="left" >
                            <textarea data-msg="Identity Token" name="NabToken" type="text" class="bigbox validate" id="NabToken" style="height:200px;" /><?= $arryProvider[0]['NabToken']?></textarea>
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
 		   <input name="Check" type="submit" class="button" id="SubmitButton" value="Validate"  />
                    <input type="hidden" name="ProviderID" id="ProviderID" value="<?= $_GET['edit'] ?>" />



                </div>
            </td>
        </tr>
</tbody>
</table>
       
    </form>

<script language="JavaScript1.2" type="text/javascript">
    
$(document).ready(function() {
    $("#CardType").change(function(){
	        $(".visa").hide(); 
	        $(".mastercard").hide();
	        $(".discover").hide();
	        $(".amex").hide();
	        if( $(this).val()){
	            for(var i=0; i < $(this).val().length; i++){
	                if($(this).val()[i] == "Visa"){
	                     $(".visa").fadeIn("fast")['show']();
	                }
	                else if($(this).val()[i] == "MasterCard"){
	                     $(".mastercard").fadeIn("fast")['show']();
	                }
	                 else if($(this).val()[i] == "Discover"){
	                        $(".discover").fadeIn("fast")['show']();
	                }
	                 else if($(this).val()[i] == "Amex"){
	                        $(".amex").fadeIn("fast")['show']();
	                }
	            }
	        }
		});
	   
		$("#CardType").change();
});
</script>


