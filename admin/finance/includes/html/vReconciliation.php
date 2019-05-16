<div style="padding:20px;">
<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
<div class="had" style="padding-top:20px;">Reconciliation Details</div>
 
<? if (!empty($ErrorMSG)) {?>
<div align="center"  class="redmsg" ><?php echo $ErrorMSG;?></div>
<?php } else{  ?>

<table  cellspacing="1" cellpadding="3" width="100%" align="center" class="borderall">
<tr>
        <td width="15%" align="right">GL Account : </td>
	<td > <?=ucwords($AccountName[0]['AccountName']).' ['.$AccountName[0]['AccountNumber'].']'?></td>
      
</tr>
<tr>
        <td align="right">Ending Balance : </td>
	<td > <?=number_format($arryReconcile[0]['EndingBankBalance'],2)?></td>
      
</tr>
<tr>
        <td align="right">Year : </td>
	<td > <?=$arryReconcile[0]['Year']?> </td>
      
</tr>
<tr>
        <td align="right">Month : </td>
	<td > 
<?
	$monthNum  = $arryReconcile[0]['Month'];
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	echo    $monthName = $dateObj->format('F'); // March
?>
 </td>
      
</tr>

<tr>
        <td align="right">Status : </td>
	<td  class="<?=$StatusCls?>"><?=$Status?></td>
      
</tr>
</table>
<br>
<table id="myTable" cellspacing="1" cellpadding="3" width="100%" align="center">
 <tr align="left">
                <td width="13%"  class="heading">Payment Date</td>
		<td    class="heading">Account Name</td>
                <td width="15%"  class="heading">Transaction Type</td>
		<td width="20%"  class="heading">Payment Method</td>
		<td width="13%" align="right" class="heading">Debit (<?=$Config['Currency']?>)</td>
		<td width="13%"  align="right" class="heading">Credit (<?=$Config['Currency']?>)</td>
    </tr>


<?php 
 
  if(is_array($arryTransaction) && $num2>0){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($arryTransaction as $key=>$values){
		$PaymentID=0;
		if($_GET['view'] > 0){
                    $PaymentID = $objReport->checkPaymentIDExist($_GET['view'], $values['PaymentID']);
                }
			
		unset($arryPaymentID);
		$arryPaymentID = explode(",",$values['PaymentID']);
       
               //if($values['PaymentID']>0 && ($values['PaymentID'] == $PaymentID)){
		if(in_array($PaymentID,$arryPaymentID)){
			$flag=!$flag;
			
			$Line++;


		$DebitAmnt = round($values['DebitAmnt'],2);
		$CreditAmnt = round($values['CreditAmnt'],2);
  ?>

		
    <tr align="left"  class="itembg">
      <td > <? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
		?></td>  
      <td ><?=stripslashes($values['AccountName']).' ['.$values['AccountNumber'].']'?></td>
       <td><?=stripslashes($values['PaymentType']);?></td>
	  <td  >
<? 
	echo stripslashes($values['Method']);
	if($values['Method']=='Check' && !empty($values['CheckNumber'])){
		echo " - ".$values['CheckNumber'];
	}

?>


</td>
	<td align="right"><strong><?=number_format($DebitAmnt,2)?></strong></td>
	<td align="right"><strong><?=number_format($CreditAmnt,2)?></strong></td>
    
    </tr>
	

	
        <?php }else{
		
		$arryTransactionUn[] = $values;
	}


} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
</table>

<br>
<? if(sizeof($arryTransactionUn)>0){ ?>
<strong>Unreconciled Items</strong>
<br>
<table id="myTable" cellspacing="1" cellpadding="3" width="100%" align="center">
 <tr align="left">
                <td width="13%"  class="heading">Payment Date</td>
		<td    class="heading">Account Name</td>
                <td width="15%"  class="heading">Transaction Type</td>
		<td width="20%"  class="heading">Payment Method</td>
		<td width="13%" align="right" class="heading">Debit (<?=$Config['Currency']?>)</td>
		<td width="13%"  align="right" class="heading">Credit (<?=$Config['Currency']?>)</td>
    </tr>


<?php 
 
  
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($arryTransactionUn as $key=>$values){
		$PaymentID=0;
		if($_GET['view'] > 0){
                    $PaymentID = $objReport->checkPaymentIDExist($_GET['view'], $values['PaymentID']);
                }
			
		unset($arryPaymentID);
		$arryPaymentID = explode(",",$values['PaymentID']);
       
               
			$flag=!$flag;
			
			$Line++;

		$DebitAmnt = round($values['DebitAmnt'],2);
		$CreditAmnt = round($values['CreditAmnt'],2);

  ?>

		
    <tr align="left"  class="itembg">
      <td > <? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
		?></td>  
      <td ><?=stripslashes($values['AccountName']).' ['.$values['AccountNumber'].']'?></td>
       <td><?=stripslashes($values['PaymentType']);?></td>
	  <td  >
<? 
	echo stripslashes($values['Method']);
	if($values['Method']=='Check' && !empty($values['CheckNumber'])){
		echo " - ".$values['CheckNumber'];
	}

?>


</td>
	<td align="right"><strong><?=number_format($DebitAmnt,2)?></strong></td>
	<td align="right"><strong><?=number_format($CreditAmnt,2)?></strong></td>
    
    </tr>
	

	
        <?php  


} // foreach end //?>
  
  
</table>
  
    <?php } ?>








<? }?>
</div>
