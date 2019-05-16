<style>
	.showTr{	
	}
	.hideTr{
		display:none;
	}
	.expandrow{
		cursor:pointer;
	}
</style>
<script type="text/javascript">
			$(function() {
				$('#ToDate').datepicker(
				{
					showOn: "both",
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true

				}
				);
			});
			
			$(function() {
				$('#FromDate').datepicker(
				{
					showOn: "both", 
					dateFormat: 'yy-mm-dd',
					changeMonth: true,
					changeYear: true

				}
				);
			});

function SetAccountHistory(str){
		ShowHideLoader('1','F');
                var AccountID = str;
		 window.location = 'accountHistory.php?accountID='+AccountID;
		 
	}
 function ResetSearch(){
		ShowHideLoader('1','F');
             		 
	}
/*
$(function() {
	$( "#accountID" ).selectmenu({
	  change: function( event, ui ) {
             console.log(ui);
               var vals = ui.item.value;		
           	SetAccountHistory(vals);
         }

     });
      
});*/

</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had"><?=ACCOUNT_HISTORY;?>
<?php if($num > 0){?>
<!--<a href="<?=$EmailUrl?>" target="_blank" class="fancybox fancybox.iframe email_button" style="float:right;margin-left:5px;">Email</a>
<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>-->
<?php }?>
</div>
<br>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td valign="bottom">

<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<form name="frmSrch" id="frmSrch" action="accountHistory.php" method="get" onSubmit="return ResetSearch();">
<tr>
<td align="left"> Select Account :  </td>


<td align="left"> <select name="accountID" class="inputbox" id="accountID"  onChange="Javascript: SetAccountHistory(this.value);">
					 
					<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
						<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" <?php if($arryBankAccountList[$i]['BankAccountID'] == $_GET['accountID']){ echo "selected";}?>>
						<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
						[<?=$arryBankAccountList[$i]['AccountNumber']?>]
				   </option>
					<? } ?>
			</select> 

<script>
$("#accountID").select2();
</script> 

	</td>


<? if(sizeof($CurrencyArray)>1){ ?>
   <td align="left">
	  &nbsp; &nbsp; &nbsp;Currency :

	</td>
 <td align="left">
<select name="Currency" class="inputbox" id="Currency" style="width:70px">		
	<?	
	foreach($CurrencyArray as $Currency){ 
		$sel = ($_GET['Currency']==$Currency)?("selected"):("");
		echo '<option value="'.$Currency.'" '.$sel.'>'.$Currency.'</option>';				
	 }
	?>
</select> 

<script>
$("#Currency").select2();
</script> 
</td>
<? } ?>

   <td align="left">
	  &nbsp; &nbsp; &nbsp;From :

	</td>

	 <td align="left">
<input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$FromDate;?>"  type="text">
	</td>

	 <td align="left">

	
	 &nbsp; &nbsp; &nbsp;To : 

	</td>

	 <td align="left"><input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$ToDate;?>"  type="text">
	
	</td>
		 <td align="left"> &nbsp;
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">
	</td>
	 <td align="left">	
	<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
	
	
	 
  
	</td>

</tr>
</form>
</table>


		</td>
      </tr>
	<tr>
	  <td align="right">
<b>Currency : <?
if(!empty($Config['ModuleCurrencySel'])){		
	echo $_GET['Currency'];
}else{
	echo $Config['Currency'];
}


?></b>
		</td>
      </tr> 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
	<td width="10%"  class="head1">Date</td>
	<td width="8%" class="head1">Reference</td>
	<td class="head1">Name</td>
	<td width="15%" class="head1">Category</td>
	<td width="11%" class="head1" align="right">Beginning Balance</td>
	<td width="8%" class="head1" align="right">Debit</td>
	<td width="8%"  class="head1" align="right">Credit</td>
	<td width="8%"  class="head1" align="right">Net Change</td>
	<td width="10%"  class="head1" align="right">Ending Balance</td>
	<td width="5%"  class="head1" align="right">Action</td>
    </tr>
   
    <?php 
 
  if($num>0 || $BeginningBalance>0){
  	$flag = true;
	$Line = 0;
	$Balance = $BeginningBalance;
	$TotalDebit = 0;
	$TotalCredit = 0;
	$TotalCheckPaid = 0;
	$TotalCheckReceived = 0;
	$SameCheck = 0;
  	foreach($arryBankAccountHistory as $key=>$values){
	$flag=!$flag;
	 
	$Line++;
	
	$HideCurrentRow=0;
	$ReceivedAmount = '';
	$PaidAmount = '';
	
	
 	/*******PK*********/
 	if(!empty($Config['ModuleCurrencySel'])){		
		if($values["TransactionType"]=='D')$ReceivedAmount = $values["OriginalAmnt"];
		if($values["TransactionType"]=='C')$PaidAmount = $values["OriginalAmnt"];	
	}else{
		$ReceivedAmount = $values["DebitAmnt"];
		$PaidAmount = 	$values["CreditAmnt"];	
	}
	/**********************/


	if($Config['CreditMinusDebit']==1){
		$Balance +=  $PaidAmount - $ReceivedAmount;
	}else{
        	$Balance +=  $ReceivedAmount-$PaidAmount;
	}
	$TotalDebit += $ReceivedAmount;
	$TotalCredit += $PaidAmount;

	
	 if(!empty($values["CustomerName"])){
		$Name = stripslashes(ucfirst($values["CustomerName"]));
	 }else if(!empty($values["VendorName"])){
		$Name = stripslashes(ucfirst($values["VendorName"]));
	 }


	/*************************/
	/*************************/
	if($PrevName == $Name && $PrevCheckNumber == $values["CheckNumber"] && $PrevPaymentDate == $values["PaymentDate"] && $PrevPaymentType == $values["PaymentType"] && $values['Method']=='Check' && !empty($values['CheckNumber'])){
		if(empty($TotalCheckPaid)){
			 $TotalCheckPaid = $PrevPaidAmount;
			 $CheckReferenceNo[] = $PrevReferenceNo;			 
		}
		if(empty($TotalCheckReceived)){
			 $TotalCheckReceived = $PrevReceivedAmount;
			 $CheckReferenceNo[] = $PrevReferenceNo;			 
		}
		

		$TotalCheckPaid += $PaidAmount;
		$TotalCheckReceived += $ReceivedAmount;
		$CheckReferenceNo[] = $values["ReferenceNo"];
		$SameCheck = 1;	
		?>
		<script>$(".row"+<?=$Line-1?>).hide();</script>	 
	<?
	}else{		
		$SameCheck = 0;
		$CheckReferenceNo = array_unique($CheckReferenceNo);
		$CheckRef = implode(", ", $CheckReferenceNo);
		unset($CheckReferenceNo);
	}

	if($SameCheck==0 && ($TotalCheckPaid>0 || $TotalCheckReceived>0)){		
		echo '<tr>
		<td>'.date($Config['DateFormat'], strtotime($PrevPaymentDate)).'</td>
		<td>'.$CheckRef.'</td>
		<td>'.$PrevName.'</td>
		<td>'.stripslashes($PrevPaymentType).' - '.$PrevMethod.' - '.$PrevCheckNumber.'</td>
		<td></td>';

		echo '<td align="right">';
		if($TotalCheckReceived>0 || $TotalCheckReceived<0){echo number_format($TotalCheckReceived,2);}
		echo '</td>';

		echo '<td align="right">';
		if($TotalCheckPaid>0 || $TotalCheckPaid<0){echo number_format($TotalCheckPaid,2);}
		echo '</td>';

		echo '<td></td>
		<td align="right"><strong>'.number_format($PrevBalance,2).'</strong></td>
		<td></td>
		</tr>';
		$TotalCheckReceived = 0;
		$TotalCheckPaid = 0;
		$HideCurrentRow = 1;
		
	}
	/*************************/
	/*************************/

  ?>
    <tr class="row<?=$Line?>">
    <td><?=date($Config['DateFormat'], strtotime($values['PaymentDate']));	?></td>
    <td><?=stripslashes($values["ReferenceNo"])?></td> 
    <td><?=$Name?></td> 
    <td>

<?
 	
	if($values["PaymentType"]=='Sales'  && $values["EntryType"]=='Invoice'  && $values["PaymentType"]==$arryAccount[0]['AccountName']){
		echo 'Customer Invoice';
	}else{
		echo stripslashes($values["PaymentType"]);
		if(!empty($values['Method'])){
			 echo " - ".$values['Method'];
			if($values['Method']=='Check' && !empty($values['CheckNumber'])){
				echo " - ".$values['CheckNumber'];
			}
		}
		if(!empty($AccountName)){ 
			echo " - ".$AccountName;
		}
	}

?>


</td> 
<td align="right"><strong><? if($Line==1){ echo number_format($BeginningBalance,2); }?></strong>
 
</td>
    <td align="right"><? if($ReceivedAmount>0 || $ReceivedAmount<0){echo number_format($ReceivedAmount,2);}?></td> 
    <td align="right"><? 
if($PaidAmount>0 || $PaidAmount<0){
	echo number_format($PaidAmount,2);
}


?></td>
<td align="right"><? if($_GET['pk']) echo $values["PaymentID"]; ?></td>
 <td align="right"><strong><?=number_format($Balance,2)?></strong></td>
<td align="center"> 
<?php if(!empty($values['JournalID'])){?>
<a href="vGeneralJournal.php?pop=1&amp;view=<?=$values['JournalID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<?php if(!empty($values['InvoiceID']) && $values['PaymentType'] == 'Sales'){?>
<a href="receiveInvoiceHistory.php?pop=1&amp;InvoiceID=<?=$values['InvoiceID']?>&edit=<?=$values['OrderID']?>&InvoiceID=<?=$values['InvoiceID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<?php if(!empty($values['InvoiceID']) && $values['PaymentType'] == 'Purchase'){?>
<a href="payInvoiceHistory.php?pop=1&amp;po=<?=$values['PurchaseID']?>&view=<?=$values['OrderID']?>&inv=<?=$values['InvoiceID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<!-----------NOT REQUIRED------------------>
<?php if(!empty($values['IncomeID'])){ if($_GET['accountID'] == 30)$Flag=1;else$Flag=0; ?>
<!--a href="vOtherIncome.php?pop=1&amp;Flag=<?=$Flag;?>&amp;view=<?=$values['IncomeID']?>" class="fancybox po fancybox.iframe"><?=$view?></a-->
<?php }?>
<?php if(!empty($values['ExpenseID'])){ /*if($_GET['accountID'] == 32)$Flag=1;else$Flag=0;*/$Flag=1;?>
<a href="vOtherExpense.php?pop=1&amp;Flag=<?=$Flag;?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<!-----------NOT REQUIRED------------------>

<?php if(!empty($values['TransferID'])){?>
<a href="vTransfer.php?pop=1&amp;view=<?=$values['TransferID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<?php if(!empty($values['DepositID'])){?>
<a href="vDeposit.php?pop=1&amp;view=<?=$values['DepositID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>

<? //if($_GET['pk']=='22101980'){ ?>
<!--a href="accountHistory.php?delp=<?=$values['PaymentID']?>&pk=<?=$_GET['pk']?>"><?=$delete?></a-->
<? //} ?>

</td>
      
    </tr>
    <?php 

 	if($HideCurrentRow==1){
		$HideCurrentRow=0;
	?>
		<script>$(".row"+<?=$Line-1?>).hide();</script>	 
	<?
	}



	$PrevPaymentDate = $values['PaymentDate'];
	$PrevReferenceNo = $values["ReferenceNo"];
	$PrevPaymentType = $values["PaymentType"];
	$PrevMethod = $values["Method"];
	$PrevCheckNumber = $values['CheckNumber'];
	$PrevPaidAmount = $PaidAmount;
	$PrevReceivedAmount = $ReceivedAmount;
	$PrevName = $Name;
	$PrevBalance = $Balance;


} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } 

$TotalDebit = round($TotalDebit,2);
$TotalCredit = round($TotalCredit,2);
?>
  

<tr> 
<td colspan="4" align="right" >
<strong>Report Total : </strong>
</td>
<td align="right"><strong><?=number_format($BeginningBalance,2)?></strong></td>
<td align="right"><strong><?=number_format($TotalDebit,2)?></strong></td>
<td align="right"><strong><?=number_format($TotalCredit,2)?></strong></td>
<td align="right">
<strong>
<? 
if($Config['CreditMinusDebit']==1){
	$TotalNetChange = $TotalCredit - $TotalDebit;
}else{
	$TotalNetChange = $TotalDebit - $TotalCredit;
}

echo number_format($TotalNetChange,2); ?>
</strong>
</td>
 <td align="right"><strong><?=number_format($Balance,2)?></strong></td>
<td >



</td>
</tr>

<? //if($num>$RecordsPerPage){ ?>
<!--tr >  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBankAccountHistory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr-->
<? //} ?>

  </table>

  </div> 
 
  
</form>
</td>
	</tr>
</table>
	

<? echo '<script>SetInnerWidth();</script>'; ?>
