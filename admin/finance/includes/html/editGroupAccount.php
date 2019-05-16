<script language="JavaScript1.2" type="text/javascript">
function validateAccount(frm){
  var DataExist=0;

	if(ValidateForSimpleBlank(frm.GroupNumber, "Group Number")
           && ValidateForSimpleBlank(frm.GroupName, "Group Name")
	  ){
		
                if(frm.AccountType.value==''){
			alert("Account Number must be in range of account type defined in chart of accounts.");
			return false;
		}

               
		/**********************/
                var GroupName=(document.getElementById("GroupName").value);
                var GroupNumber=(document.getElementById("GroupNumber").value);
		var AccountTypeID = (document.getElementById("AccountType").value);
                var ParentGroupID=(document.getElementById("ParentGroupID").value);
                var GrpID=(document.getElementById("GroupID").value);
                
                if(ParentGroupID==GrpID)
                {
                    alert("Please Select Another Group Name");return false;
                }
                if(ParentGroupID==''){
                    ParentGroupID=0;
                }
                
            	if(AccountTypeID!=''){			
			DataExist = CheckExistingData("isRecordExists.php","&GroupNumber="+escape(GroupNumber)+"&editID="+GrpID, "GroupNumber","Group Number");
                        if(DataExist==1)return false;
		}
		DataExist=0;
		DataExist = CheckExistingData("isRecordExists.php","&GroupName="+escape(GroupName)+"&editID="+GrpID, "GroupName","Group Name");
                if(DataExist==1)return false;
		/**********************/
		
		ShowHideLoader('1','S');
		return true;
		
	}else{
		return false;	
	}

	
}
</script>
<a href="<?=$ListUrl?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
 <div class="message"><? if (!empty($_SESSION['mess_bank_account'])) {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
        
        
        
  
     ?>  

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	
    <tr>
		<td  align="right"   class="blackbold"> Group Number  :<span class="red">*</span> </td>
		<td   align="left" >
		  <input type="text" name="GroupNumber" class="inputbox" id="GroupNumber" maxlength="7" autocomplete="off" onBlur="Javascript:CheckGroupAcctNum('MsgSpan_AccNumber','GroupNumber','<?=$_GET["edit"]?>');"  value="<?=$arryGroupAccount[0]["GroupNumber"]?>" >
		 <span id="MsgSpan_AccNumber"></span>
                 &nbsp;<?=ACCOUNT_NUM_FORMAT?>
		</td>
    </tr>
     <tr>
		<td  align="right"   class="blackbold" width="45%">Group Name  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="GroupName" maxlength="30" class="inputbox" id="GroupName" value="<?=stripslashes(ucwords(strtolower($arryGroupAccount[0]['GroupName'])))?>">
		</td>
	</tr>
        
      <tr>
		<td  align="right"   class="blackbold"> Account Type  :<span class="red">*</span> </td>
		<td   align="left" >
                    
                    <input type="text" name="AccountType" class="disabled_inputbox" id="AccountType" value="<?=stripslashes(ucwords(strtolower($arryGroupAccount[0]['AccountType'])));?>" readonly=""> 
		  <!--select name="AccountType" class="inputbox" id="AccountType" onChange="Javascript: AccountList();">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryAccountType);$i++) {?>
						<option value="<?=$arryAccountType[$i]['AccountTypeID']?>">
						<?=stripslashes(ucwords(strtolower($arryAccountType[$i]['AccountType'])));?>
				   </option>
					<? } ?>
			</select--> 
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
		  	
</table>	
  </td>
 </tr>

  <?php
     
  
  ?>
	<tr>
	<td  align="center">
            <?php
            
            if(empty($_GET["edit"])){ $editVal="-1";}else {$editVal=$_GET["edit"];}
            
                    ?>
                 <input type="hidden"  id="GroupID" name="GroupID" value="<?=$editVal?>">
		 <input type="hidden" id="main_ParentAccountID" name="main_ParentAccountID" value="">
                 <input type="hidden" value="<?=$arryGroupAccount[0]['ParentGroupID']?>" id="main_ParentGroupID" name="main_ParentGroupID">
                 <input type="hidden" value="" id="RangeFrom" name="RangeFrom">
                 <input type="hidden" value="" id="RangeTo" name="RangeTo">
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
		 
		//alert(opt); return false;
		ShowHideLoader('1','L');
                
		//document.getElementById("ParentAccountID").innerHTML = '<select name="ParentAccountID" class="inputbox" id="ParentAccountID"><option value="">Loading...</option></select>';
		//var SendUrl = 'ajax.php?action=account&AccountType='+document.getElementById("AccountType").value+'&current_account='+document.getElementById("main_ParentAccountID").value+'&r='+Math.random()+'&select=1'; 
		
                document.getElementById("ParentGroupIDPlace").innerHTML = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID"><option value="">Loading...</option></select>';
		//var SendUrl = 'ajax.php?action=Groupaccount&AccountType='+document.getElementById("AccountType").value+'&r='+Math.random()+'&select=1&ParentID='+document.getElementById("main_ParentAccountID").value;
                var sendParam='ajax.php?actionn=getAccountType&Range='+opt+'&r='+Math.random()+'&select=1&ParentID='+document.getElementById("main_ParentGroupID").value; 
                //var sendParam='ajax.php?actionn=getAccountType&Range='+opt+'&r='+Math.random();   
                //alert(sendParam); return false;
		httpObj.open("GET", sendParam, true);
		
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
	
        
                                       //alert(httpObj.responseText); return false;
                                        var TotalResponse=httpObj.responseText.split("##");
                                        //alert(responseText); return false;
                                        if(TotalResponse[0]!='')
                                            {
                                                $("#AccountType").val(TotalResponse[0]);
                                                $("#RangeFrom").val(TotalResponse[2]);
                                                $("#RangeTo").val(TotalResponse[3]);
                                                $("#ParentGroupIDPlace").html(TotalResponse[1]);
                                            }
				//document.getElementById("ParentAccountID").innerHTML  = httpObj.responseText;
                                //document.getElementById("ParentGroupIDPlace").innerHTML  = httpObj.responseText;
                                
				ShowHideLoader('');
			}
		};
		httpObj.send(null);
	}


</script>

<?php
     if($_GET["edit"] > 0)
     {
       $optionss=$arryGroupAccount[0]['RangeFrom'];  
     
   ?> 
<SCRIPT LANGUAGE=JAVASCRIPT> 
    //SettParentGroupAccount('<?=$_GET["edit"]?>');
    AccountList('<?=$optionss?>');
 
</SCRIPT>
<?php  
     }

	}	
 ?>

<script>
$(document).ready(function(){
   
  
   $("#GroupNumber").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //alert("Digits Only");
               return false;
    }
    
    ClearAvail('MsgSpan_AccNumber');
   });
   
   $('#GroupNumber').keyup(function() {
       
       var AccountNumber = $('#GroupNumber').val();
       var AccountNumberLength = AccountNumber.length; 
       if((AccountNumberLength > 5) && (AccountNumberLength <=7)){
           $('#GroupNumber').val(AccountNumber.replace(/(\d{4})\-?(\d{2})/,'$1-$2'));
          var totalStr=$('#GroupNumber').val().split("-");
          var beforr=totalStr[0];
          var afterr=totalStr[1];
           if(AccountNumberLength==6){
               
              $("#main_ParentGroupID").val(0);
              sendParam='actionn=getAccountType&Range='+beforr; 
              
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
          $('#GroupNumber').val(AccountNumber.replace(/(\d{4})\-?(\d{2})/,'$1-$2')); 
          var totalStr=$('#GroupNumber').val().split("-");
          var beforr=totalStr[0];
          var afterr=totalStr[1];
          $('#GroupNumber').val(beforr+"-"+afterr.substr(0,2));
          
          var newLength=($('#GroupNumber').val().length);
          if(newLength==7)
          {
                    sendParam='actionn=getAccountType&Range='+beforr; 
                    $("#main_ParentGroupID").val(0);
                     $.ajax({
                               type: "GET",
                               async:false,
                               url: 'ajax.php',
                               data: sendParam,
                               success: function (responseText) {

                                   var TotalResponse=responseText.split("##");
                              //alert(TotalResponse); return false;
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

function CheckGroupAcctNum(MSG_SPAN,FieldName,editID){
            
              
	
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
