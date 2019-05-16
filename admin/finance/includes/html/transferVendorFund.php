<div class="had">Purchase Vendor Transfer</div>

<div class="message" align="center"><? if(!empty($_SESSION['mess_transfer'])) {echo $_SESSION['mess_transfer']; unset($_SESSION['mess_transfer']); }?></div>

 
<script language="JavaScript1.2" type="text/javascript">
function ResetForm(){	
	$("#loaderDiv").show();
	$("#invoiceDiv").hide();
}

function validateForm(frm)
{

	var PaidAmount = frm.PaidAmount.value;
	var TotalPaidAmount = document.getElementById("total_payment").value;
        var totalOpenBalance = document.getElementById("totalOpenBalance").value;
        var totalInvoice = 0;
        totalInvoice = document.getElementById("totalInvoice").value;

        if(frm.PaidAmount.value == "" || frm.PaidAmount.value == 0)
        {
                  alert("Please Enter Transfer Amount.");
                  frm.PaidAmount.focus();
                  return false;
         }

	

         if(frm.GLAccount.value == "")
          {
                       alert("Please Select GL Account.");
                       frm.GLAccount.focus();
                       return false;
            }
                 
            
           
        for(var i=1; i <= totalInvoice;i++){
            
            var payment_amnt = parseFloat(document.getElementById("payment_amnt_"+i).value);
            var invoice_amnt = parseFloat(document.getElementById("invoice_amnt_"+i).value);
            if( payment_amnt > 0 &&  payment_amnt > invoice_amnt){
                 alert("You Can Pay Only "+document.getElementById("invoice_amnt_"+i).value);
                 document.getElementById("payment_amnt_"+i).focus();
		 return false;
            } 
        }
        
              
         if(parseFloat(PaidAmount) != parseFloat(TotalPaidAmount)){
		alert("Transfer Amount and Total Payment Should be Same.");
		return false;

		} 
                
          if(parseFloat(PaidAmount) > parseFloat(totalOpenBalance)){
		alert("Transfer Amount Should be "+totalOpenBalance);
                frm.PaidAmount.focus();
		return false;

		}
        
        else{
		//parent.jQuery.fancybox.close();
	    	ResetForm();
	 }

		
}
function ChangeConversionrate(line)
{

	var ConversionRate = document.getElementById("ConversionRate_"+line).value;

	var InvoiceAmount=document.getElementById("TotalAmountOld_"+line).value;
	
	var paidAmnt=document.getElementById("paidAmnt_"+line).value;	

	var Totalamount=InvoiceAmount*ConversionRate;
	
	Totalamount = parseFloat(Totalamount).toFixed(2);
	document.getElementById("TotalInvoiceAmount_"+line).value=Totalamount;

	var Openbalance = Totalamount-paidAmnt;
	
	Openbalance = parseFloat(Openbalance).toFixed(2);
	document.getElementById("invoice_amnt_"+line).value=Openbalance;

}
</script>
<?  if (!empty($ErrorMsg)) {   ?>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<?php } else {


?>
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	
	<tr>
	 <td align="left" valign="top">
	 <table width="100%" border="0" cellpadding="5" cellspacing="0" >
	
	 <tr>
        <td  align="right"  class="blackbold" width="20%">Vendor : <span class="red">*</span></td>
        <td  align="left" width="30%">
			
                        <select name="SuppCode" id="SuppCode" class="inputbox" onChange="Javascript:SetVendorInvoice();">
                            <option value="">---Select---</option>
                            <?php foreach($arryVendorList as $values){
				if($values['SuppID']!=$SuppID){

				?>
                            <option value="<?=$values['SuppCode']?>" <?=($values['SuppCode']==$arryTransfer[0]['TransferTo'])?("selected"):("")?>><?=stripslashes($values['VendorName'])?></option>
                            <?php }}?>
                            
                        </select>
			
		</td>
    
        <td align="right"   class="blackbold" width="20%">Transfer Amount : <span class="red">*</span></td>
        <td align="left">
		  <input name="PaidAmount" type="text" class="inputbox" id="PaidAmount" style="width: 90px;" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=$arryTransfer[0]['TransferAmount']?>"  /> <?=$Config["Currency"]?>
		</td>
     </tr>
	  </tr>
	 <tr>
            <td  align="right" valign="top" class="blackbold"> GL Account : <span class="red">*</span></td>
            <td   align="left" valign="top">


                       <select name="GLAccount" class="inputbox" id="GLAccount">
                            <option value="">--- Select ---</option>
                            <? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
                             <option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <? if($arryBankAccount[$i]['BankAccountID']==$arryTransfer[0]['GLAccount']) echo 'Selected'; ?>>
                             <?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
                                    <? } ?>
                    </select> 

                    </td>
        
            <td valign="top" align="right" class="blackbold">Comment :</td>
            <td align="left" valign="top">

 <input name="Comment" type="text" class="inputbox" id="Comment" maxlength="200"  value="<?=stripslashes($arryTransfer[0]['Comment'])?>"  />
</td>
	</tr>
  
 
	</table>
	 
	 </td>
	
	</tr>
	 <tr>
            <td colspan="2"><div id="loaderDiv" style="display:none;" align="center"><img src="../images/ajaxloader.gif"></div></td>
        </tr>
        <tr>
            <td colspan="2"  valign="top" style="height: 300px;"><div id="invoiceDiv" style="display:none;"></div></td>
        </tr>

          <tr>
            <td colspan="2" align="center">
<input type="submit" class="button" name="save_payment" id="save_payment" style="display: none;" value="OK">
&nbsp;&nbsp;
 <input type="hidden" name="TransferID" id="TransferID" value="<?=$TransferID?>" readonly />

</td>
        </tr>
	</table>
 </form>
<?php }?>





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
var httpObj2 = false;
		try {
			 httpObj2 = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj2 = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj2 = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj2 = false;
			}
	  }

	}



	function SetVendorInvoice(){
		ResetForm();
		var SuppCode =  $("#SuppCode").val();
		var TransferID =  $("#TransferID").val();

		var SendUrl = 'ajax.php?action=getVendorInvoiceForTransfer&SuppCode='+SuppCode+'&TransferID='+TransferID+'&r='+Math.random()+'&select=1'; 
		httpObj.open("GET", SendUrl, true);
		//alert(SendUrl);
		httpObj.onreadystatechange = function VendorInvoiceRecieve(){
			if (httpObj.readyState == 4) {
				$("#invoiceDiv").show();
				$("#loaderDiv").hide();
				document.getElementById("invoiceDiv").innerHTML  = httpObj.responseText;
                                if(httpObj.responseText.length > 1500){
					$("#save_payment").show();                                   
                                }else{
                                    $("#save_payment").hide();
                                }
                                
			 	

			}
		};
		httpObj.send(null);
		 
	}
        
        
        
     function SetPayAmnt(){
         var totalAmt = 0;
         var totalInvoice = 0;
         totalInvoice = document.getElementById("totalInvoice").value;
        for(var i=1; i <= totalInvoice;i++){
            if(document.getElementById("payment_amnt_"+i).value > 0){
                 totalAmt += parseFloat(document.getElementById("payment_amnt_"+i).value);
                  document.getElementById("invoice_check_"+i).checked = true
            }else{
                document.getElementById("payment_amnt_"+i).value = '';
                 document.getElementById("invoice_check_"+i).checked = false
            }
        }
            if(totalAmt > 0){
                //document.getElementById("PaidAmount").value = totalAmt;
                document.getElementById("total_payment").value = totalAmt;
            }else{
                //document.getElementById("PaidAmount").value = '';
                document.getElementById("total_payment").value = '';
            }
     }
     
      function SetPayAmntByCheck(line){
          
         var totalAmt = 0,totalInvoice = 0,PaidAmount = 0,invAmnt = 0,remainInvAmnt = 0;
        
         totalInvoice = document.getElementById("totalInvoice").value;
         PaidAmount = document.getElementById("PaidAmount").value;
         
         for(var i=1; i <= totalInvoice;i++){
            
             if(document.getElementById("payment_amnt_"+i).value  > 0){
              invAmnt +=  parseFloat(document.getElementById("payment_amnt_"+i).value);
             }
         }
        
       remainInvAmnt = parseFloat(PaidAmount)-parseFloat(invAmnt);
     

            if(document.getElementById("invoice_check_"+line).checked){
                 //document.getElementById("payment_amnt_"+line).value = parseFloat(document.getElementById("invoice_amnt_"+line).value);
                 if(remainInvAmnt > parseFloat(document.getElementById("invoice_amnt_"+line).value))
                     {
                       document.getElementById("payment_amnt_"+line).value =  parseFloat(document.getElementById("invoice_amnt_"+line).value); 
                     }else{
                         
                             document.getElementById("payment_amnt_"+line).value = remainInvAmnt;
                     }
            }else{
                document.getElementById("payment_amnt_"+line).value = '';
            }
        
        SetPayAmnt();
       
     }
     

 
</script>


<? if($TransferID>0){?>
<script type="text/javascript">
	SetVendorInvoice();
</script>
<? } ?>

