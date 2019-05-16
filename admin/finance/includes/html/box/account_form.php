
<script language="JavaScript1.2" type="text/javascript">
function validateAccount(frm){
  var DataExist=0;
 
	if(ValidateForSimpleBlank(frm.AccountNumber, "Account Number")
            && ValidateForSimpleBlank(frm.AccountName, "Account Name")            
	  ){
		if(frm.AccountType.value==''){
			alert("Account Number must be in range of account type defined in chart of accounts.");
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
		<td  align="right"   class="blackbold">Account Number  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountNumber" autocomplete="off" <?=$EditableClass?> id="AccountNumber" maxlength="7" onBlur="Javascript:CheckAcctNum('MsgSpan_AccNumber','AccountNumber','<?=$arryBankAccount[0]['BankAccountID']?>');"  value="<?=$arryBankAccount[0]['AccountNumber'];?>">
		<span id="MsgSpan_AccNumber"></span>
                &nbsp;<?=ACCOUNT_NUM_FORMAT?>
		</td>
	</tr>
        <tr>
		<td  align="right"   class="blackbold" width="45%">Account Name  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="<?=$arryBankAccount[0]['AccountName'];?>">
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
	<td  align="right"   class="blackbold">Status  : </td>
	<td   align="left"  >
			<?php 
				$ActiveChecked = ' checked';
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

</script>
