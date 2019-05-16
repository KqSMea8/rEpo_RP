<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">
function validateAccount(frm){
  var DataExist=0;
 
	if(ValidateForSimpleBlank(frm.AccountNumber, "Cash Account Number")
            && ValidateForSimpleBlank(frm.AccountName, "Account Name")            
	  ){
		if(frm.AccountType.value==''){
			alert("Account Number must be in range of account type defined in chart of accounts.");
			return false;
		}

		/*
		if(!ValidateForSimpleBlank(frm.BankAccountNumber, "Bank Account Number")){
			return false;
		}
		if(!ValidateForSimpleBlank(frm.BankName, "Bank Name")){
			return false;
		}
		/**********************/
		var AccountNumber = Trim(document.getElementById("AccountNumber")).value;
		if(AccountNumber!=''){
			if(!ValidateMandRange(document.getElementById("AccountNumber"), "Account Number",6,7)){
				return false;
			}
			var BankAccountID = Trim(document.getElementById("EditBankAccountID")).value;
			var Url = "isRecordExists.php?editID="+BankAccountID;
			DataExist = CheckExistingData(Url,"&AccountNumber="+escape(AccountNumber), "AccountNumber","Account Number");
			if(DataExist==1)return false;

		}
		/**********************/
		DataExist=0;
		var BankAccountNumber = Trim(document.getElementById("BankAccountNumber")).value;
		if(BankAccountNumber!=''){
			if(!ValidateMandRange(document.getElementById("BankAccountNumber"), "Bank Account Number",5,20)){
				return false;
			}
			var BankAccountID = Trim(document.getElementById("EditBankAccountID")).value;
			var Url = "isRecordExists.php?editID="+BankAccountID;

			DataExist = CheckExistingData(Url,"&BankAccountNumber="+escape(BankAccountNumber), "BankAccountNumber","Bank Account Number");
			if(DataExist==1)return false;

		}
		/**********************/
		
		ShowHideLoader('1','S');
		return true;
		
	}else{
		return false;	
	}

	
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 

	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td  align="right"   class="blackbold">Cash Account Number  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountNumber" <?=$EditableClass?> id="AccountNumber" maxlength="7" onBlur="Javascript:CheckAcctNum('MsgSpan_AccNumber','AccountNumber','<?=$arryBankAccount[0]['BankAccountID']?>');"  value="<?=$arryBankAccount[0]['AccountNumber'];?>" autocomplete="off">
		<span id="MsgSpan_AccNumber"></span>
                &nbsp;<?=ACCOUNT_NUM_FORMAT?>
		</td>
	</tr>

        <tr>
		<td  align="right"   class="blackbold" width="45%">Account Name  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="<?=stripslashes($arryBankAccount[0]['AccountName'])?>">
		</td>
	</tr>
    <tr>
		<td  align="right"   class="blackbold"> Account Type  :  </td>
		<td   align="left" >
                    
                    <input type="text" name="AccountType" class="disabled_inputbox" id="AccountType" value="<?=stripslashes($arryBankAccount[0]['AccountType']);?>" readonly=""> 
		
		</td>
	</tr>	

    <tr>
		<td  align="right"   class="blackbold">Parent Group :</td>
		
                <td  align="left" id="ParentGroupIDPlace" class="blacknormal">
                    
                    <select  name="ParentGroupID" class="inputbox" id="ParentGroupID" onchange="Javascript: SetMainGroupAccountId();">
                        <option value="">Select</option>  
                        
                    </select>
                </td>
	</tr>

<tr>
		<td  align="right"   class="blackbold">Bank Account Number  :  </td>
		<td   align="left" >
		<input type="text" name="BankAccountNumber" class="inputbox" id="BankAccountNumber" maxlength="20" onKeyPress="Javascript:return isNumberKey(event);"  autocomplete="off" onBlur="Javascript:CheckBankNum('MsgSpan_BankNumber','BankAccountNumber','<?=$arryBankAccount[0]['BankAccountID']?>');"  value="<?=$arryBankAccount[0]['BankAccountNumber'];?>">
		<span id="MsgSpan_BankNumber"></span>
             
		</td>
	</tr>

<tr>
		<td  align="right"   class="blackbold">Bank Name  :  </td>
		<td   align="left" >
		<input type="text" name="BankName" class="inputbox" id="BankName" maxlength="30" value="<?=stripslashes($arryBankAccount[0]['BankName'])?>">
		
             
		</td>
	</tr>

<tr>
		<td  align="right"   class="blackbold">Next Check Number  :</td>
		<td   align="left" >
		<input type="text" name="NextCheckNumber" class="inputbox" id="NextCheckNumber" maxlength="20" value="<?=stripslashes($arryBankAccount[0]['NextCheckNumber'])?>" onKeyPress="Javascript:return isNumberKey(event);"  autocomplete="off">
		
             
		</td>
	</tr>

<tr>
		<td  align="right" valign="top"  class="blackbold"> Bank Address  : </td>
		<td   align="left" >
		 <textarea id="Address" class="textarea" type="text" name="Address"  maxlength="250"><?=stripslashes($arryBankAccount[0]['Address'])?></textarea>
		</td>
	</tr>	

 
	<tr>
		<td  align="right"  valign="top"  class="blackbold" height="35"> Bank Currency  : </td>
		<td   align="left" >
		 

<?  
if(!empty($arryBankAccount[0]['BankCurrency']) && $objBankAccount->isPaymentDataExist($BankAccountID)){ ?>
	 <input type="text" name="BankCurrency[]" class="disabled_inputbox" id="BankCurrency" value="<?=stripslashes($arryBankAccount[0]['BankCurrency']);?>" readonly="">  <br><span class=red><?=BANK_CURRENCY_DISABLE?></span>
<? }else{

unset($arrySelCurrency);
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);
if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);

if(empty($arryBankAccount[0]['BankCurrency'])) $arryBankAccount[0]['BankCurrency'] =$Config['Currency'];


if(!empty($arryBankAccount[0]['BankCurrency'])){$currencyArray = explode(",",$arryBankAccount[0]['BankCurrency']);}
?>
<select name="BankCurrency[]" id="BankCurrency" multiple="multiple" class="inputbox js-example-basic-multiple"  style="width:230px;">
<!--select name="BankCurrency" class="inputbox" id="BankCurrency">
	<option value="">--- None ---</option-->
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <? if(in_array($arrySelCurrency[$i], $currencyArray)){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>
<script>
$("#BankCurrency").select2();
</script> 

<? } ?>
		</td>
	</tr>


  <tr style="display:none"  >
                        <td  align="right"   class="blackbold" height="35"> Gain & Loss Account:  </td>
                        <td   align="left" >
                        <select name="AccountGainLoss" class="inputbox" id="AccountGainLoss">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryAccountList);$i++) {?>
			<option value="<?=$arryAccountList[$i]['BankAccountID']?>" <?  if($arryAccountList[$i]['BankAccountID']==$arryBankAccount[0]['AccountGainLoss']){echo "selected";}?>>
			<?=ucwords($arryAccountList[$i]['AccountName'])?> [<?=$arryAccountList[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select>

<script>
$("#AccountGainLoss").select2();
</script> 

                        </td>
                    </tr>

<?  if(empty($arryBankAccount[0]['AccountLoss']))$arryBankAccount[0]['AccountLoss']='';?>
  <!--tr  >
                        <td  align="right"   class="blackbold" height="35"> GL Account  for Loss :  </td>
                        <td   align="left" >
                        <select name="AccountLoss" class="inputbox" id="AccountLoss">
			<option value="">--- None ---</option>
			<? for($i=0;$i<sizeof($arryAccountList);$i++) {?>
			<option value="<?=$arryAccountList[$i]['BankAccountID']?>" <?  if($arryAccountList[$i]['BankAccountID']==$arryBankAccount[0]['AccountLoss']){echo "selected";}?>>
			<?=ucwords($arryAccountList[$i]['AccountName'])?> [<?=$arryAccountList[$i]['AccountNumber']?>]</option>
			<? } ?>
		</select>

<script>
$("#AccountLoss").select2();
</script> 

                        </td>
                    </tr-->

 
        
<tr>
        <td  align="right"   class="blackbold" >Default Account : </td>
        <td   align="left"  >
          <? 
   $InActiveChecked = ' checked';
if($_GET['edit'] > 0){
	if($arryBankAccount[0]['DefaultAccount'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
	if($arryBankAccount[0]['DefaultAccount'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
}
  ?>
          <label><input type="radio" name="DefaultAccount" id="DefaultAccount1" value="1" <?=$ActiveChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="DefaultAccount" id="DefaultAccount" value="0" <?=$InActiveChecked?> />
          No</label> </td>
      </tr>



	<tr>
	<td  align="right"   class="blackbold">Status  : </td>
	<td   align="left"  >
			<?php 
				$ActiveChecked = ' checked'; $InActiveChecked ='';
				if($arryBankAccount[0]['Status'] == "Yes") {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				if($arryBankAccount[0]['Status'] == "No") {$ActiveChecked = ''; $InActiveChecked = ' checked';}
				
			?>
	  <input type="radio" name="Status" id="Status" value="Yes" <?=$ActiveChecked?> />
	  Active&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="Status" id="Status" value="No" <?=$InActiveChecked?> />
	  InActive </td>
	</tr>
	

</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
		
		<input type="hidden" name="EditBankAccountID" id="EditBankAccountID"  value="<?=$_GET['edit'];?>" />
                <input type="hidden" value="" id="main_ParentAccountID" name="main_ParentAccountID">
                 <input type="hidden" value="<?=$arryBankAccount[0]['GroupID'];?>" id="main_ParentGroupID" name="main_ParentGroupID">
                 <input type="hidden" value="<?=$arryBankAccount[0]['RangeFrom'];?>" id="RangeFrom" name="RangeFrom">
                 <input type="hidden" value="<?=$arryBankAccount[0]['RangeTo'];?>" id="RangeTo" name="RangeTo">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="<?=$ButtonAction?>"  />
	</td>
	</tr>
 </form>
</table>
<script type="text/javascript">

var httpObj = false;
		try {
			  httpObj = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj = false;
			}
	  }

	}


function AccountList(opt){
		
		ShowHideLoader('1','L');
                	
		
                document.getElementById("ParentGroupIDPlace").innerHTML = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID"><option value="">Loading...</option></select>';
		
                var sendParam='ajax.php?actionn=getAccountType&Range='+opt+'&r='+Math.random()+'&select=1&ParentID='+document.getElementById("main_ParentGroupID").value;   
    
		httpObj.open("GET", sendParam, true);
		
		httpObj.onreadystatechange = function AccountListRecieve(){
			if (httpObj.readyState == 4) {
	
                                        var TotalResponse=httpObj.responseText.split("##");
                                        //alert(responseText); return false;
                                        if(TotalResponse[0]!='')
                                            {
                                                $("#AccountType").val(TotalResponse[0]);
                                                $("#RangeFrom").val(TotalResponse[2]);
                                                $("#RangeTo").val(TotalResponse[3]);
                                                $("#ParentGroupIDPlace").html(TotalResponse[1]);
                                            }
				
                                
				ShowHideLoader('');
			}
		};
		httpObj.send(null);
	}


</script>

<? if($arryBankAccount[0]['RangeFrom']>0){?>
<SCRIPT LANGUAGE=JAVASCRIPT> 
 AccountList(<?=$arryBankAccount[0]['RangeFrom'];?>);
</SCRIPT> 
<? } ?>

<script>
$(document).ready(function(){
   
  
   $("#AccountNumber").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //alert("Digits Only");
               return false;
    }
    
    ClearAvail('MsgSpan_AccNumber');
   });
   
   $('#AccountNumber').keyup(function() {
       
       var AccountNumber = $('#AccountNumber').val();
       var AccountNumberLength = AccountNumber.length; 
       if((AccountNumberLength > 5) && (AccountNumberLength <=7)){
           $('#AccountNumber').val(AccountNumber.replace(/(\d{4})\-?(\d{2})/,'$1-$2'));
          var totalStr=$('#AccountNumber').val().split("-");
          var beforr=totalStr[0];
          var afterr=totalStr[1];
           if(AccountNumberLength==6){
               
              $("#main_ParentGroupID").val(0);
              sendParam='actionn=getAccountType&Range='+beforr+'&r='+Math.random()+'&select=1&ParentID='+document.getElementById("main_ParentGroupID").value;
              
              
             
              $.ajax({
                        type: "GET",
                        async:false,
                        url: 'ajax.php',
                        data: sendParam,
                        success: function (responseText) {
                          
                          
                          var TotalResponse=responseText.split("##");
                          //alert(responseText); return false;
                          if(TotalResponse[0]!='')
                                        {
                                            $("#AccountType").val(TotalResponse[0]);
                                            $("#RangeFrom").val(TotalResponse[2]);
                                            $("#RangeTo").val(TotalResponse[3]);
                                            $("#ParentGroupIDPlace").html(TotalResponse[1]);
                                        }else {
                                        $("#AccountType").val('');   
                                        alert("Please Enter First Digit between 1-8"); 
                                        }
                          //if(!empty(responseText)) $("#AccountType").val(responseText);
                            
                        }
          });
               
               
               
               
           }
       }else if(AccountNumberLength > 7)
       {
          //this.value=this.value.substr(0, 7);
          //$('#AccountNumber').val(AccountNumber.substr(0, 7));
          $('#AccountNumber').val(AccountNumber.replace(/(\d{4})\-?(\d{2})/,'$1-$2')); 
          var totalStr=$('#AccountNumber').val().split("-");
          var beforr=totalStr[0];
          var afterr=totalStr[1];
          $('#AccountNumber').val(beforr+"-"+afterr.substr(0,2));
          
          var newLength=($('#AccountNumber').val().length);
          if(newLength==7)
          {
              
                    $("#main_ParentGroupID").val(0);
                    sendParam='actionn=getAccountType&Range='+beforr+'&r='+Math.random()+'&select=1&ParentID='+document.getElementById("main_ParentGroupID").value; 

                    
                     $.ajax({
                               type: "GET",
                               async:false,
                               url: 'ajax.php',
                               data: sendParam,
                               success: function (responseText) {

                                   var TotalResponse=responseText.split("##");
                              //alert(TotalResponse[0]); return false;
                          if(TotalResponse[0]!='')
                                        {
                                            $("#AccountType").val(TotalResponse[0]);
                                            $("#RangeFrom").val(TotalResponse[2]);
                                            $("#RangeTo").val(TotalResponse[3]);
                                            $("#ParentGroupIDPlace").html(TotalResponse[1]);
                                        }else {
                                        $("#AccountType").val('');   
                                        alert("Please Enter First Digit between 1-8"); 
                                        }
                          //if(!empty(responseText)) $("#AccountType").val(responseText);
                            
                        }

                              
                 });
                 
          }
          
       }
       
   });
      
});

function CheckAcctNum(MSG_SPAN,FieldName,editID){
            
              
	
		document.getElementById(MSG_SPAN).innerHTML="";

		FieldLength = document.getElementById(FieldName).value.length;

		if(FieldLength>=6){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
			var Url = "isRecordExists.php?"+FieldName+"="+escape(document.getElementById(FieldName).value)+"&editID="+editID;
			var SendUrl = Url+"&r="+Math.random(); 
                        //alert(SendUrl);return false;
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function RecieveAcctNumRequest(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Not Available!</span>";
					}else if(httpObj.responseText==0) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>Available!</span>";
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
				}
			};
			httpObj.send(null);

		}else if(FieldLength>0){
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>It should be minimum of 6 characters long.</span>";
		}

	}
        
        
        function SetMainGroupAccountId(){
          $("#main_ParentGroupID").val($("#ParentGroupID").val());
        }



function CheckBankNum(MSG_SPAN,FieldName,editID){
            
              
	
		document.getElementById(MSG_SPAN).innerHTML="";

		FieldLength = document.getElementById(FieldName).value.length;

		if(FieldLength>=6){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';
			var Url = "isRecordExists.php?"+FieldName+"="+escape(document.getElementById(FieldName).value)+"&editID="+editID;
			var SendUrl = Url+"&r="+Math.random(); 
                        //alert(SendUrl);return false;
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function RecieveBankNumRequest(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Not Available!</span>";
					}else if(httpObj.responseText==0) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>Available!</span>";
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
				}
			};
			httpObj.send(null);

		}else if(FieldLength>0){
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>It should be minimum of 5 digits long.</span>";
		}

	}
        



</script>
