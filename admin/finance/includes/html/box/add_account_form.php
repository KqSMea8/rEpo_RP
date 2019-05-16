<script language="JavaScript1.2" type="text/javascript">
function validateAccount(frm){
  var DataExist=0;
 
	if(ValidateForSelect(frm.AccountType, "Account Type")
	    && ValidateForSimpleBlank(frm.AccountName, "Account Name")
	    /*&& ValidateForSimpleBlank(frm.AccountCode, "Account Code")*/
	    && ValidateForSimpleBlank(frm.AccountNumber, "Account Number")
	  ){
		
		/**********************/
		var AccountNumber = Trim(document.getElementById("AccountNumber")).value;
		if(AccountNumber!=''){
			if(!ValidateMandRange(document.getElementById("AccountNumber"), "Account Number",3,30)){
				return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&AccountNumber="+escape(AccountNumber), "AccountNumber","Account Number");
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
		<td  align="right"   class="blackbold"> Account Type  :<span class="red">*</span> </td>
		<td   align="left" >
		  <select name="AccountType" class="inputbox" id="AccountType" onChange="Javascript: AccountList();">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryAccountType);$i++) {?>
						<option value="<?=$arryAccountType[$i]['AccountTypeID']?>">
						<?=stripslashes(ucwords(strtolower($arryAccountType[$i]['AccountType'])));?>
				   </option>
					<? } ?>
			</select> 
		</td>
	</tr>	

    <tr>
		<td  align="right"   class="blackbold">Parent Account :</td>
		<!--td  align="left" id="ParentAccountID" class="blacknormal">&nbsp;</td--earlier this was working-->
                <td  align="left" id="ParentGroupIDPlace" class="blacknormal">&nbsp;</td>
	</tr>	
	<!--<tr>
		<td  align="right"   class="blackbold"  width="45%">Bank Account Name :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="">
		</td>
	</tr>-->
	<tr>
		<td  align="right"   class="blackbold" width="45%">Account Name  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="">
		</td>
	</tr>	  	
	<!--<tr>
		<td  align="right"   class="blackbold">Account Code :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountCode" maxlength="30"  class="inputbox" id="AccountCode" value="">
		</td>
	</tr>-->	
	
	<tr>
		<td  align="right"   class="blackbold">Account Number  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountNumber" maxlength="30" class="inputbox" id="AccountNumber" maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_AccNumber');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_AccNumber','AccountNumber','');"  value="">
		<span id="MsgSpan_AccNumber"></span>
		</td>
	</tr>	
	
	
	
	 
	<tr>
		<td  align="right" valign="top"  class="blackbold"> Bank Address  : </td>
		<td   align="left" >
		 <textarea id="Address" class="textarea" type="text" name="Address"></textarea>
		</td>
	</tr>	
	
	<tr>
		<td  align="right"   class="blackbold">Status  : </td>
		<td   align="left"  >

		<input type="radio" name="Status" id="Status" value="Yes" checked />
		Active&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="Status" id="Status" value="No"  />
		InActive </td>
	</tr>
	
	

</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
		 <input type="hidden" value="" id="main_ParentAccountID" name="main_ParentAccountID">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
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
                
                //earlier this was working
		//document.getElementById("ParentAccountID").innerHTML = '<select name="ParentAccountID" class="inputbox" id="ParentAccountID"><option value="">Loading...</option></select>';
		//var SendUrl = 'ajax.php?action=account&AccountType='+document.getElementById("AccountType").value+'&r='+Math.random()+'&select=1'; 
		
                document.getElementById("ParentGroupIDPlace").innerHTML = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID"><option value="">Loading...</option></select>';
		var SendUrl = 'ajax.php?action=Groupaccount&AccountType='+document.getElementById("AccountType").value+'&r='+Math.random()+'&select=1'; 
                
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				//alert(httpObj.responseText);
                                
                                //earlier this was working
				//document.getElementById("ParentAccountID").innerHTML  = httpObj.responseText;
                                
                                document.getElementById("ParentGroupIDPlace").innerHTML  = httpObj.responseText;
                                
				ShowHideLoader('');
				/*if(document.getElementById("ParentAccountID").value != '' ){
					document.getElementById("main_ParentAccountID").value = document.getElementById("ajax_ParentAccountID").value;
					 
				}else{
					document.getElementById("main_ParentAccountID").value   = '';
						
				}*/
				

			}
		};
		httpObj.send(null);
	}

function SetMainAccountId(){

		document.getElementById("main_ParentAccountID").value = document.getElementById("BankAccountID").value;
		 
	}
function SetMainGroupAccountId(){

		document.getElementById("main_ParentAccountID").value = document.getElementById("ParentGroupID").value;
		 
	}
</script>

<SCRIPT LANGUAGE=JAVASCRIPT> 
 AccountList();
</SCRIPT>

