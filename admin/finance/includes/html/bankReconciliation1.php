<?
if($_GET['pk']==1){
	/*date_default_timezone_set("UTC");
	echo $dt = date('Y-m-d H:i:s');
	echo '<br>';
	echo $Config['TodayDate'];

	$dateFromPHP = strtotime($dt);*/


?>
<script language="JavaScript1.2" type="text/javascript">
	var d = new Date();
	var now = new Date(<?=$dateFromPHP?> * 1000);
	//alert(d + '=======' + now);
</script>
<? } ?>



<script language="JavaScript1.2" type="text/javascript">

function ValidateFind(frm){
	if(ValidateForSelect(frm.Year,"Year")
	    && ValidateForSelect(frm.Month,"Month")
	    && ValidateForSelect(frm.AccountID,"GL Account")
	){
		ShowHideLoader('1','F');
		return true;
	}
	   
	return false;
}

function ValidateSearch2(){	
	ShowHideLoader(1,'F');
	return true;	
	
}


function SelectCheck(MainID,ToSelect)
{	
	var flag,i;
	var Num = document.getElementById("NumLine").value;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
		 
	}
	for(i=1; i<=Num; i++){
		SetReconcilByCheck(i);
		 
	}
}


 
function SetCheckedTotal(line){
	var DebitAmnt = 0 , CreditAmnt = 0 , Balance = 0, TotalAmount = 0, TotalDeposit = 0, TotalCheck = 0, PaymentType='';
	var Num = document.getElementById("NumLine").value;
	var BeginningBalance = document.getElementById("BeginningBalance").value;
	 
	var payTypeD = ["Sales", "Other Income", "Journal Entry"];
	var payTypeC = ["Purchase", "Other Expense", "Spiff Expense", "Adjustment"];
	  

	for(i=1; i<=Num; i++){
		if(document.getElementById("Reconcil_"+i).checked == true){ 
			 DebitAmnt = parseFloat(document.getElementById("DebitAmnt_"+i).value);
			 CreditAmnt = parseFloat(document.getElementById("CreditAmnt_"+i).value);
			 Balance = DebitAmnt - CreditAmnt;
			 TotalAmount += Balance;

			if(document.getElementById("PaymentType_"+i) != null){	
				PaymentType = document.getElementById("PaymentType_"+i).value;
				if(PaymentType!=''){	
					if(payTypeD.indexOf(PaymentType)>=0){
						 TotalDeposit += Balance;
					}else if(payTypeC.indexOf(PaymentType)>=0){
						 TotalCheck += Balance;
					}		
				}
			}
		}		 
	}
	TotalAmount += parseFloat(BeginningBalance);
	
	document.getElementById("showdiff").innerHTML = TotalAmount.toFixed(2);
	document.getElementById("showdeposit").innerHTML = TotalDeposit.toFixed(2);
	document.getElementById("showcheck").innerHTML = TotalCheck.toFixed(2);
}




 function SetReconcilByCheck(line){
     
	var totalDebitAmt = 0,totalCreditAmt = 0,TotalDebitByCheck=0,TotalCreditByCheck=0;
	TotalDebitByCheck = document.getElementById("TotalDebitByCheck").value;
	TotalCreditByCheck = document.getElementById("TotalCreditByCheck").value;

	var DebitAmnt = parseFloat(document.getElementById("DebitAmnt_"+line).value);
	var CreditAmnt = parseFloat(document.getElementById("CreditAmnt_"+line).value);


	if(DebitAmnt > 0 || DebitAmnt < 0){
		totalDebitAmt = DebitAmnt;                   
	}
	if(CreditAmnt > 0 || CreditAmnt < 0){
		totalCreditAmt = CreditAmnt;
	}
         /***************IF CHECKED****************************************************/ 
            if(document.getElementById("Reconcil_"+line).checked == true){ 
		if(TotalDebitByCheck > 0 || TotalDebitByCheck < 0){
			totalDebitAmt = parseFloat(totalDebitAmt)+parseFloat(TotalDebitByCheck);
		}		
		if(TotalCreditByCheck > 0 || TotalCreditByCheck < 0){
			totalCreditAmt = parseFloat(totalCreditAmt)+parseFloat(TotalCreditByCheck);
		}
		document.getElementById("shtotal").style.display = 'inline';
		document.getElementById("SaveButton").style.display = 'inline';                    
                       
           }else{		
		if(TotalDebitByCheck > 0 || TotalDebitByCheck < 0 ){
			totalDebitAmt = parseFloat(TotalDebitByCheck)- parseFloat(totalDebitAmt);
		}		
		if(TotalCreditByCheck > 0 || TotalCreditByCheck < 0){
			totalCreditAmt = parseFloat(TotalCreditByCheck)-parseFloat(totalCreditAmt);
		}
	  }
            
           /********************CALCULATE AMOUNT**********************************************/ 
            
            document.getElementById("TotalDebitByCheck").value = totalDebitAmt;
            document.getElementById("TotalCreditByCheck").value = totalCreditAmt;
	    var BeginningBalance = document.getElementById("BeginningBalance").value;
		
            var totalDC = parseFloat(BeginningBalance) + (parseFloat(totalDebitAmt)-(totalCreditAmt));
            document.getElementById("TotalDebitCreditByCheck").value = totalDC;
           // document.getElementById("showdiff").innerHTML = totalDC.toFixed(2);
            
            var EndingBankBalance = document.getElementById("EndingBankBalance").value;
            
            if(totalDC == EndingBankBalance)
                { 
                   document.getElementById("Reconcile").style.display = 'inline';
                   document.getElementById("Status").value = 'Reconciled';
                   document.getElementById("SaveButton").style.display = 'none';

		document.getElementById("CompleteLabel").style.display = 'inline';
                   
                }else{
                    document.getElementById("Reconcile").style.display = 'none';
                    document.getElementById("Status").value = 'NotReconciled';
                    document.getElementById("SaveButton").style.display = 'inline';

		document.getElementById("CompleteLabel").style.display = 'none';
		document.getElementById("CompleteReconcile").checked =  false;


                }

		SetCheckedTotal(line);
             
     }
     
    
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


function validateReconcile(EditID){
		 
                var Year = document.getElementById("Year").value;
                var Month = document.getElementById("Month").value;
                var AccountID = document.getElementById("AccountID").value;
		
            if(EditID > 0)
                {
                    var SendUrl = 'ajax.php?action=CheckReconcilMonth&Year='+Year+'&Month='+Month+'&AccountID='+AccountID+'&EditID='+EditID+'&r='+Math.random();
                }else{
                    var SendUrl = 'ajax.php?action=CheckReconcilMonth&Year='+Year+'&Month='+Month+'&AccountID='+AccountID+'&r='+Math.random();
                }
                
             //alert(SendUrl);return false;
               
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
                             //alert(httpObj.responseText);
				if(httpObj.responseText > 0)
                                    {
                                        alert("Account reconciliation is already exists for this month.");
                                        return false;
                                    }else{
                                        document.getElementById("bankReconciliationForm").submit();
                                        return true;
                                    }
			
			}
		};
		httpObj.send(null);
	}
                      

    $(document).ready(function(){	

        $("#EndingBankBalance").keyup(function(){
            
           var TotalDebitCreditByCheck = $("#TotalDebitCreditByCheck").val();
           var EndingBankBalance = $("#EndingBankBalance").val();
          
           if(parseFloat(TotalDebitCreditByCheck) == parseFloat(EndingBankBalance) && TotalDebitCreditByCheck > 0)
               {
                   document.getElementById("Reconcile").style.display = 'inline';
                   document.getElementById("Status").value = 'Reconciled';
                   document.getElementById("SaveButton").style.display = 'none';

		   document.getElementById("CompleteLabel").style.display = 'inline';	
		  			
               }else{
                    document.getElementById("Reconcile").style.display = 'none';
                    document.getElementById("Status").value = 'NotReconciled';
                    if(TotalDebitCreditByCheck > 0){
                        document.getElementById("SaveButton").style.display = 'inline';
                    }

		     document.getElementById("CompleteLabel").style.display = 'none';
		     document.getElementById("CompleteReconcile").checked =  false;	  
                }
            
        });

    });



function getReconciliationList(Type,Srch){
	$("#loaderdiv").show();	
	$("#ReconciliationListing").hide();	
	if(Srch!=1)$("#tr").val(Type);
	var RType = $("#tr").val();
	var RAccountID = $("#RAccountID").val();
	var RYear = $("#RYear").val();
	var RMonth = $("#RMonth").val();
	
	if(RType=='D'){
		$("#tabd").attr('class', 'grey_bt');
		$('#tabc').attr('class', 'white_bt');
		$('#taball').attr('class', 'white_bt');
	}else if(RType=='C'){
		$('#tabc').attr('class', 'grey_bt');
		$('#tabd').attr('class', 'white_bt');
		$('#taball').attr('class', 'white_bt');
	}else{
		$('#taball').attr('class', 'grey_bt');
		$('#tabc').attr('class', 'white_bt');
		$('#tabd').attr('class', 'white_bt');
	}


	$.ajax({
		type: "GET",
		async:false,
		url: "ajax.php",
		data: "&action=getReconciliationList&tr="+escape(RType)+"&RAccountID="+escape(RAccountID)+"&RYear="+escape(RYear)+"&RMonth="+escape(RMonth)+"&r"+Math.random(),
		success: function (responseText) {
			$("#loaderdiv").hide();	
			$("#ReconciliationListing").show();	
			$("#ReconciliationListing").html(responseText);	
						
		}
	});
	 
}



function getTransactionList(Type){
	var payType = '';

	if(Type=='D'){
		$("#tab_d").attr('class', 'grey_bt');
		$('#tab_c').attr('class', 'white_bt');
		$('#tab_all').attr('class', 'white_bt');
		payType = 'Sales,Other Income,Journal Entry';
		$("#totalBottom").hide();
		$("#totalBottomD").show();
		$("#totalBottomC").hide();
		$("#dptotal").show();
		$("#chtotal").hide();
	}else if(Type=='C'){
		$('#tab_c').attr('class', 'grey_bt');
		$('#tab_d').attr('class', 'white_bt');
		$('#tab_all').attr('class', 'white_bt');
		payType = 'Purchase,Other Expense,Spiff Expense,Adjustment';
		$("#totalBottom").hide();
		$("#totalBottomD").hide();
		$("#totalBottomC").show();
		$("#dptotal").hide();
		$("#chtotal").show();
	}else{
		$('#tab_all').attr('class', 'grey_bt');
		$('#tab_c').attr('class', 'white_bt');
		$('#tab_d').attr('class', 'white_bt');
		payType = '';
		$("#totalBottom").show();
		$("#totalBottomD").hide();
		$("#totalBottomC").hide();
		$("#dptotal").hide();
		$("#chtotal").hide();
	}
	var NumLine = parseInt($("#NumLine").val());
	var PaymentType = '';
	var n = 0;
	for(var i=1;i<=NumLine;i++){ 
		if(document.getElementById("PaymentType_"+i) != null){
			//$('#Reconcil_'+i).attr('checked', false); 
			//SetReconcilByCheck(i);

			PaymentType = document.getElementById("PaymentType_"+i).value;
			if(payType!=''){
				var n = payType.indexOf(PaymentType);
				if(n>=0){
					$("#trRow"+i).show();					
				}else{
					$("#trRow"+i).hide();
				}
			}else{
				$("#trRow"+i).show();
			}
		}
	}

	SetCheckedTotal(0);
	 
}
</script>
<div class="had"><?= $ModuleName; ?></div>

<div  align="center" class="message">
    <?php if ($_SESSION['mess_reconcile'] != "") { ?><?=
        $_SESSION['mess_reconcile'];
        unset($_SESSION['mess_reconcile']);
        ?><?php } ?>
</div>
      
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
 <form name="bankReconciliation" id="bankReconciliation" action="" method="get"  onSubmit="return ValidateFind(this);" > 
               
<table id="search_table"  cellspacing="1" cellpadding="0" border="0"  align="left" >
                                            <tbody>
                                                <tr>

						<!--td   align="left">Type: &nbsp;
		<select name="Type" class="textbox" id="Type" style="width:100px;">
			<option value="">--- All ---</option>
			<option value="D" <? if($_GET['Type']=='D'){echo "selected";}?>>Deposits</option>
			<option value="C" <? if($_GET['Type']=='C'){echo "selected";}?>>Checks</option>
		</select> 
                                                        
                                                    </td-->

                                                  <td   align="left">Year: &nbsp;
                                                        <?php
                                                        $Year_String = '<select name="Year" id="Year" class="textbox" style="width: 100px;">';
                                                        $c_year = date('Y')-1;
                                                        $start_year = $c_year+2;  
							if(!empty($NextYear) && $NextYear>$c_year) $start_year = $NextYear;
                                                        $Year_String .= '<option value="">--- Select ---</option>';
							
                                                        for($y=$c_year;$y<=$start_year;$y++){
                                                        if($_GET['Year'] == $y) $y_selected=' Selected'; else $y_selected='';
                                                        $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                                        }
                                                        $Year_String .= ' </select>';
                                                        echo $Year_String;
                                                        ?>
                                                        
                                                    </td>
                                                    <td align="left"> &nbsp;&nbsp;&nbsp;&nbsp;Month:&nbsp;
                                                        <select name="Month" id="Month" class="textbox" style="width: 100px;">
                                                        <option value="">--- Select ---</option>
                                                        <?php
						$end_month = 12;
						if(!empty($NextMonth)) $end_month = $NextMonth;
                                                         for ($m=1; $m<=$end_month; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            if($_GET['Month'] == $m) $m_selected=' Selected'; else $m_selected='';
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>" <?=$m_selected;?>><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
                                                        
                                                    </td>
                                                     <td  align="left">&nbsp;&nbsp;&nbsp;&nbsp;GL Account:&nbsp;
                                                        <select name="AccountID" id="AccountID" class="inputbox">
                                                        <option value="">--- Select ---</option>
                                                            <?php for($i=0;$i<sizeof($arryAccount);$i++) {?>
                                                            <option value="<?=$arryAccount[$i]['BankAccountID']?>" <?php if($_GET['AccountID'] == $arryAccount[$i]['BankAccountID']){echo "selected";}?>>
                                                            &nbsp;<?=ucwords($arryAccount[$i]['AccountName'])?> [<?=$arryAccount[$i]['AccountNumber']?>]
                                                            </option>
                                                            <? } ?>
                                                        </select>
                                                        
                                                    </td>
                                                    <td>
                                                        <input name="Submit" type="Submit"  value="Go" class="button"/>
                                                    </td>
                                                   
                                                </tr>
                                            </tbody>
                                        </table>



            </form>
        </td>
    </tr>

    
<tr>
<td  valign="top">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
 <form name="bankReconciliationForm" id="bankReconciliationForm" action="" method="post"  enctype="multipart/form-data"> 

<?
if($_GET['tran']=='D'){
	$cls_all = 'white_bt';
	$cls_d = 'grey_bt';
	$cls_c = 'white_bt';
}else if($_GET['tran']=='C'){
	$cls_all = 'white_bt';
	$cls_d = 'white_bt';
	$cls_c = 'grey_bt';
}else{
	$cls_all = 'grey_bt';
	$cls_d = 'white_bt';
	$cls_c = 'white_bt';
}
?>     
  
   
 <a href="Javascript:void(0);" id="tab_all" class="<?=$cls_all?>" style="float:left;border-bottom:none;width:60px;" onclick="Javascript:getTransactionList('','');"><strong>All</strong></a><a href="Javascript:void(0);" onclick="Javascript:getTransactionList('D','');" id="tab_d" class="<?=$cls_d?>" style="float:left;border-bottom:none;60px;"><strong>Deposits</strong></a> <a href="Javascript:void(0);" id="tab_c"  class="<?=$cls_c?>" style="float:left;border-bottom:none;60px;" onclick="Javascript:getTransactionList('C','');"><strong>Checks</strong></a>  
<div style="clear:both"></div>   


<table <?=$table_bg?>>
     <? if(!empty($ErrorMsg)){ ?>
     <tr align="center" >
      <td  colspan="7" class="redmsg"><?=$ErrorMsg?> </td>
    </tr>
	<? }else{ ?>
      <tr align="left" style="background-color:#fff;" >
                <td colspan="7" style="font-weight: bold;" height="40">
		   Ending GL Balance : <? echo number_format($BeginningBalance,2); ?>
 &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    Ending Bank Balance : 
                    <input type="text" value="<?=number_format($arryMonthReconcil[0]['EndingBankBalance'],2,'.','');?>" onkeypress="return isDecimalKey(event);" maxlength="10" style="width: 90px;" id="EndingBankBalance" class="inputbox" name="EndingBankBalance">
                    <?=$Config['Currency']?>
 &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                     <?php if($_GET['edit'] > 0){?>
                     <span  id="shtotal" style="font-weight: bold;display:inline;">Total : <b id="showdiff"><?=number_format($arryMonthReconcil[0]['TotalDebitCreditByCheck'],2,'.','');?></b>&nbsp;<?=$Config['Currency']?></span>
                     <?php } else{?>
                      <span id="shtotal" style="display:none;">Total : <b id="showdiff"></b>&nbsp;&nbsp;<?=$Config['Currency']?></span>
                     <?php }?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			<span id="dptotal" style="display:none;">Total Deposits: <b id="showdeposit"></b></span>

			<span id="chtotal" style="display:none;">Total Checks : <b id="showcheck"></b></span>









		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label  id="CompleteLabel" <?php  if(($_GET['edit'] > 0) && ($arryMonthReconcil[0]['TotalDebitCreditByCheck'] == $arryMonthReconcil[0]['EndingBankBalance'])){ echo 'style="display:inline;"'; } else {echo 'style="display:none;"'; }?>><input type="checkbox" name="CompleteReconcile" id="CompleteReconcile" value="1">Complete</label>

                    <input name="Submit" type="button" <?php  if(($_GET['edit'] > 0) && ($arryMonthReconcil[0]['EndingBankBalance'] != $arryMonthReconcil[0]['TotalDebitCreditByCheck'])){?>style="display:inline;"<?php } else {?>style="display:none;"<?php }?> id="SaveButton" onClick="Javascript: validateReconcile(<?=$_GET['edit']?>);" class="button" value="Save" />&nbsp;
                    <input name="Submit" type="button" <?php  if(($_GET['edit'] > 0) && ($arryMonthReconcil[0]['EndingBankBalance'] == $arryMonthReconcil[0]['TotalDebitCreditByCheck'])){?>style="display:inline;"<?php } else {?>style="display:none;"<?php }?> id="Reconcile" onClick="Javascript: validateReconcile(<?=$_GET['edit']?>);" class="button" value="Reconcile" />
		
<?
//echo $totalDifference .'=='. $arryMonthReconcil[0]['TotalDebitCreditByCheck'];

?>


                </td>
                
    </tr>
   
    <tr align="left">
                <td width="13%" align="left" class="head1">Payment Date</td>
		<td   align="left" class="head1">Account Name</td>
                <td width="13%" align="left" class="head1">Transaction Type</td>
		<td width="13%" align="left" class="head1">Payment Method</td>
		<td width="13%" align="right" class="head1">Debit (<?=$Config['Currency']?>)</td>
		<td width="13%"  align="right" class="head1">Credit (<?=$Config['Currency']?>)</td>
                <td width="5%" align="center" class="head1">Action<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'Reconcil_');" style="display:none"></td>
    </tr>
   
  <?php 
  
 
  if(is_array($arryTransaction) && $num2>0){
	$flag=true;
	$Line=0;
	$invAmnt=0;
	$TotalDebit = 0;
	$TotalCredit = 0;
	$TotalDeposit = 0;
	$TotalCheck = 0;
	$ArryPaymentDeposit = array('Sales','Other Income','Journal Entry');
	$ArryPaymentCheck = array('Purchase','Other Expense','Spiff Expense','Adjustment');
 
  	foreach($arryTransaction as $key=>$values){
		$PaymentID=0;
		if($_GET['edit'] > 0){
                    $PaymentID = $objReport->checkPaymentIDExist($values['PaymentID']);
                }
			       
             //  if(($values['PaymentID'] == $PaymentID) || empty($_GET['edit'])){

			$flag=!$flag;
			 
			$Line++;

	$TotalDebit += $values['DebitAmnt'];
	$TotalCredit += $values['CreditAmnt'];


	if(in_array($values['PaymentType'],$ArryPaymentDeposit)){
		$TotalDeposit += $values['DebitAmnt'] - $values['CreditAmnt'];
	}else if(in_array($values['PaymentType'],$ArryPaymentCheck)){ 
		$TotalCheck += $values['DebitAmnt'] - $values['CreditAmnt'];
	}

  ?>

		
    <tr align="left"  id="trRow<?=$Line?>">
      <td > <? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));

if($_GET['pk']==1){
	echo ' # '.$values['PaymentID'].'#'.$PaymentID;
}
 
		?></td>  
      <td ><?=stripslashes($values['AccountName']).' ['.$values['AccountNumber'].']'?></td>
       <td><?=stripslashes($values['PaymentType']);?><input type="hidden" value="<?=stripslashes($values['PaymentType']);?>" id="PaymentType_<?=$Line;?>" name="PaymentType_<?=$Line;?>" readonly></td>
  <td  >
<? 
	echo stripslashes($values['Method']);
	if($values['Method']=='Check' && !empty($values['CheckNumber'])){
		echo " - ".$values['CheckNumber'];
	}

?>


</td>
      <td align="right"><strong><?=$values['DebitAmnt']?></strong><input type="hidden" value="<?=$values['DebitAmnt']?>" id="DebitAmnt_<?=$Line;?>" name="DebitAmnt_<?=$Line;?>"></td>
      <td align="right"><strong><?=$values['CreditAmnt']?></strong><input type="hidden" value="<?=$values['CreditAmnt']?>" id="CreditAmnt_<?=$Line;?>" name="CreditAmnt_<?=$Line;?>"></td>
      <td align="center"><?//=$values['PaymentID']?><input type="checkbox" value="<?=$values['PaymentID']?>"  <?php if($values['PaymentID'] == $PaymentID){echo "checked";}?> onclick="SetReconcilByCheck(<?=$Line;?>)" id="Reconcil_<?=$Line;?>" name="Reconcil_<?=$Line;?>"></td>
    
    </tr>
	

	
        <?php //}

} // foreach end //



$TotalNetChange = $TotalDebit - $TotalCredit;
 
$Balance = $BeginningBalance + $TotalNetChange;
 
 
?>

 <tr  >
     	<td  colspan="5" class="head1"  align="right"> Ending GL Balance : <?=number_format($BeginningBalance,2)?>   </td>
	 <td colspan="2"  class="head1" align="right">
	<span id="totalBottom">Total : <?=number_format($TotalNetChange,2)?></span> 
	<span id="totalBottomD" style="display:none">Total Deposit: <?=number_format($TotalDeposit,2)?></span>   
	<span id="totalBottomC" style="display:none">Total Checks: <?=number_format($TotalCheck,2)?></span>     </td>
    </tr>


  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php }} ?>
   <input type="hidden" name="NumLine" id="NumLine" value="<?=$Line?>" readonly>
  </table>
     <?php if(is_array($arryTransaction) && $num2>0){ ?>
     
        <div  style="text-align:center;width:100%;padding-top: 15px;">
            
            
            <?php if($_GET['edit'] > 0){?>
            <div>
                    
                            <input type="hidden" name="TotalDebitByCheck" id="TotalDebitByCheck" value="<?=$arryMonthReconcil[0]['TotalDebitByCheck'];?>">
                            <input type="hidden" name="TotalCreditByCheck" id="TotalCreditByCheck" value="<?=$arryMonthReconcil[0]['TotalCreditByCheck'];?>">
                            <input type="hidden" name="TotalDebitCreditByCheck" id="TotalDebitCreditByCheck" value="<?=$arryMonthReconcil[0]['TotalDebitCreditByCheck'];?>">
                           
                        </div> 
            <?php } else {?>
                <div>
                   
                        <input type="hidden" name="TotalDebitByCheck" id="TotalDebitByCheck" value="">
                            <input type="hidden" name="TotalCreditByCheck" id="TotalCreditByCheck" value="">
                            <input type="hidden" name="TotalDebitCreditByCheck" id="TotalDebitCreditByCheck" value="">
                           
                        </div> 
            
            <?php }?>
                  </div>

        <div style="width:100%; padding-top: 20px;text-align:center;clear: both;">
            <input type="hidden" name="Year" id="Year" value="<?=$_GET['Year'];?>">
            <input type="hidden" name="Month" id="Month" value="<?=$_GET['Month'];?>">
            <input type="hidden" name="AccountID" id="AccountID" value="<?=$_GET['AccountID'];?>">
            <?php  if(($_GET['edit'] > 0) && ($arryMonthReconcil[0]['EndingBankBalance'] == $arryMonthReconcil[0]['TotalDebitCreditByCheck'])){?>
            <input type="hidden" name="Status" id="Status" value="Reconciled">
            <?php } else {?>
            <input type="hidden" name="Status" id="Status" value="NotReconciled">
            <?php }?>
            <input type="hidden" name="totalChecked" id="totalChecked" value="<?=$num2;?>">
             <input type="hidden" name="BeginningBalance" id="BeginningBalance" value="<?=$BeginningBalance;?>"> 
           
          </div>
 <?php }?>
 </form>
  </div> 
  </td>
 </tr>
</table>
<br>
<br>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    
    <tr>
      <td  valign="top" class="had">Reconciliation List</td>  
  </tr>
    <tr>
      <td  valign="top" align="left" style="padding:0; "> 
<?
if($_GET['tr']=='D'){
	$cls_all = 'white_bt';
	$cls_d = 'grey_bt';
	$cls_c = 'white_bt';
}else if($_GET['tr']=='C'){
	$cls_all = 'white_bt';
	$cls_d = 'white_bt';
	$cls_c = 'grey_bt';
}else{
	$cls_all = 'grey_bt';
	$cls_d = 'white_bt';
	$cls_c = 'white_bt';
}

?>
<!--
<a href="Javascript:void(0);" id="taball" class="<?=$cls_all?>" style="float:left;border-bottom:none;width:60px;" onclick="Javascript:getReconciliationList('','');"><strong>All</strong></a><a href="Javascript:void(0);" onclick="Javascript:getReconciliationList('D','');" id="tabd" class="<?=$cls_d?>" style="float:left;border-bottom:none;60px;"><strong>Deposits</strong></a> <a href="Javascript:void(0);" id="tabc"  class="<?=$cls_c?>" style="float:left;border-bottom:none;60px;" onclick="Javascript:getReconciliationList('C','');"><strong>Checks</strong></a>  -->

</td>  
  </tr>

<tr>
<td  valign="top" class="borderall">
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


	

    <tr>
      <td  valign="top" >
          
                  Year: <?php
                                $Year_String = '<select name="RYear" id="RYear" class="textbox" style="width: 110px;">';
                                $c_year = date('Y')-1;
                                $start_year = $c_year+2;
                                $Year_String .= '<option value="">All</option>';
                                for($y=$c_year;$y<=$start_year;$y++){
                                if($_GET['RYear'] == $y) $y_selected=' Selected'; else $y_selected='';
                                $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                }
                                $Year_String .= ' </select>';
                                echo $Year_String;
                        ?>&nbsp;&nbsp;
                     Month: <select name="RMonth" id="RMonth" class="textbox" style="width: 110px;">
                                                        <option value="">All</option>
                                                          <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>" <?php if($_GET['RMonth'] == $m){ echo "selected";}?>><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
                     &nbsp;&nbsp;
                     GL Account: <select name="RAccountID" id="RAccountID" class="textbox" style="width: 150px;">
                                                        <option value="">All</option>
                                                            <?php for($i=0;$i<sizeof($arryAccount);$i++) {?>
                                                            <option value="<?=$arryAccount[$i]['BankAccountID']?>" <?php if($_GET['RAccountID'] == $arryAccount[$i]['BankAccountID']){echo "selected";}?>>
                                                            <?=ucwords($arryAccount[$i]['AccountName'])?>  [<?=$arryAccount[$i]['AccountNumber']?>]
                                                            </option>
                                                            <? } ?>
                                                        </select>
               <input type="hidden" name="search" id="search" value="Search">
   <input type="hidden" name="tr" id="tr" value="<?=$_GET['tr']?>" readonly>
               <input type="button" name="sbt" value="Go" class="search_button" onclick="getReconciliationList('','1');">
           
      </td>  
  </tr>
<tr>
   <td  valign="top">
<div id="loaderdiv" style="display:none;padding:20px" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="ReconciliationListing"></div>



</td>

	</tr>  
	    </table>
	</td>
</tr>


</table>
<script type="text/javascript">
getReconciliationList('<?=$_GET["tr"]?>','');
</script>


<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>
