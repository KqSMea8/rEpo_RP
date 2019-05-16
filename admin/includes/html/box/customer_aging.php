<?  
 
if($CustCode!=''){  
	$arryAging=$objReport->arAgingReportList($CustCode,'');
	$UnpaidInvoice=0;

 
?>
<br>
 <div class="message" align="center">
<?
if(!empty($_SESSION['mess_credit'])) {
	echo $_SESSION['mess_credit']; unset($_SESSION['mess_credit']);
}else if (!empty($_SESSION['mess_Invoice'])) {
	echo $_SESSION['mess_Invoice']; unset($_SESSION['mess_Invoice']);
} 
?>
</div>
<table id="list_table" cellspacing="1" cellpadding="10" width="100%" align="center">
		<tr align="left"  >
		<td class="head1" width="9%">Invoice Date</td>    
		<td class="head1">Invoice/Credit Memo #</td>   
		<!--td class="head1" width="10%">Payment Term</td-->   
		<td class="head1" width="7%">Due Date</td> 		
		<td class="head1" width="15%">Balance in Customer Currency</td>  
		<td class="head1" width="12%">Original Amount [<?=$Config['Currency']?>]</td>  
		<td class="head1" width="9%">Balance [<?=$Config['Currency']?>]</td>  
		<td class="head1" width="7%">Current </td>  
		<td class="head1" width="7%">30 Days </td>
		<td class="head1" width="6%">60 Days </td>
		<td class="head1" width="6%">90 Days </td>
		<td class="head1" width="8%">120 Days</td>
		</tr>
</table>
<div style="overflow-y:scroll; max-height:400px;">
<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">	
		<?php  $TotalUnpaidInvoice = 0;
			$TotalBalanceCC = 0 ;

			$CustomerCurrencyAll = '';
$CreditAmount=0;

		//$DateFormat = $Config['DateFormat'];
		$DateFormat = 'm/d/Y';

		if(sizeof($arryAging)>0){
		$flag=true;
		$Line=0;
               
                $TotalCurrentBalance = 0;
                $TotalBalance30 = 0;
                $TotalBalance60 = 0;
                $TotalBalance90 = 0;
		$TotalBalance120 = 0;
		foreach($arryAging as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;
                
                $ConversionRate=1;
		if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
			$ConversionRate = $values['ConversionRate'];			   
		}
                
		$CurrentBalance = 0;
		$Balance30 =  0;
		$Balance60 =  0;
		$Balance90 =  0;
		$Balance120 =  0;
               /***********************/
		$ModuleDate=''; $ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			$ModuleDate=$values['InvoiceDate'];


			if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoiceGl.php?view='.$values['OrderID'].'&pop=1">'.$values["InvoiceID"].'</a>';
				$ModuleDepName = "SalesInvoiceGl";
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?view='.$values['OrderID'].'&IE='.$values['InvoiceEntry'].'&pop=1">'.$values["InvoiceID"].'</a>';
				$ModuleDepName = "SalesInvoice";
			}
 
			$PdfResArray = GetPdfLinks(array('Module' => 'Invoice',  'ModuleID' => $values['InvoiceID'], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['S_Invoice'], 'PdfFile' => $values['PdfFile']));
			$SendUrl = "sendInvoice.php?editC=".$_GET['edit']."&viewC=".$_GET['view'];

		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];
			$ModuleDate=$values['PostedDate'];
			if($values['OverPaid']=='1'){
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?inv='.$values['InvoiceID'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
			}
			 
			$PdfResArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' => $values["CreditID"], 'ModuleDepName' => "SalesCreditMemo", 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['S_Credit'], 'PdfFile' => $values['PdfFile']));
			$SendUrl = "sendCreditNote.php?editC=".$_GET['edit']."&viewC=".$_GET['view'];
		}

		/*************/
		$EmailIcon = ($values['MailSend']!=1)?('emailgreen.png'):('emailred.png');
	 	$sendemail = '<img src="' . $Config['Url'] . 'admin/images/'.$EmailIcon.'" border="0"  onMouseover="ddrivetip(\'<center>Send '.$values['Module'].'</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';
		/*************/
		 

		$OrderAmount = $orginalAmount;
                $orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 
                $PaidAmnt = $values['ReceiveAmnt'];
                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $orginalAmount;
                }
                
		/***********************/
		$AgingDay = GetAgingDay($ModuleDate); 
		switch($AgingDay){
			case '1': $CurrentBalance = $UnpaidInvoice; break;
			case '2': $Balance30 = $UnpaidInvoice; break;
			case '3': $Balance60 = $UnpaidInvoice; break;
			case '4': $Balance90 = $UnpaidInvoice; break;
			case '5': $Balance120 = $UnpaidInvoice; break;
		} 
		/***********************/

		/********CC: Customer Currency************/
		if(empty($CustomerCurrencyAll)) $CustomerCurrencyAll = $values['CustomerCurrency'];
		else if($CustomerCurrencyAll!=$values['CustomerCurrency']) $CustomerCurrencyAll='None';

		$PaidAmntCC = GetConvertedAmountReverse($ConversionRate, $PaidAmnt); 
 
		if($PaidAmntCC > 0){
                    $BalanceCC = $OrderAmount-$PaidAmntCC;                    
                }else{
                    $BalanceCC = $OrderAmount;  
                }
		$TotalBalanceCC +=$BalanceCC;
		/********************/






                $TotalUnpaidInvoice +=$UnpaidInvoice;

                $TotalCurrentBalance +=$CurrentBalance;
                $TotalBalance30 +=$Balance30;
                $TotalBalance60 +=$Balance60;
                $TotalBalance90 +=$Balance90;
                $TotalBalance120 +=$Balance120;

		$DueDate = ''; $DueDateTemp='';
		if(!empty($values["PaymentTerm"])){
			$PaymentTerm = strtolower(trim($values["PaymentTerm"]));
			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$ModuleDate);
			list($year, $month, $day) = $arryDate;

			
			if($PaymentTerm=='end of month'){				 
				$TempDate  = mktime(0, 0, 0, $month+1 , 1, $year);	
				$DueDateTemp = date("Y-m-t",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDateTemp));
			}else if(!empty($arryTerm[1])){//term
				$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
				$DueDateTemp = date("Y-m-d",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDateTemp));
			}

			if($DueDateTemp>0 && $DueDateTemp<$Config["TodayDate"]){
				$DueDate .= '<span class="redbt">Past Due</span>';
			}

		} 
                

		

		  
			if($Line==1){
				#$CreditAmount = $values['CreditAmount']; 
				if(!empty($CreditAmount)){
		?>
		<tr class="<?=$bgclass?>">
			<td></td>
			 
			<td colspan="2">Customer Credit</td>
			<td colspan="2"></td>
			<td><b>-<?=$CreditAmount?></b></td>
			<td >-<?=$CreditAmount?></td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			 
		</tr>
		<? 		} 
			}



		if(abs($UnpaidInvoice)>0){  //start row
		 ?>
 
		 <tr align="left" class="<?=$bgclass?>">
             
		<td width="9%"><?=date($DateFormat, strtotime($ModuleDate))?></td>
		<td> 
<?
echo $ModuleLink;

echo '&nbsp;&nbsp;&nbsp;&nbsp;<a  href="'.$PdfResArray['DownloadUrl'].'" >'.$download.'</a>&nbsp;&nbsp;<a  '.$PdfResArray['MakePdfLink'].' class="fancybox fancybox.iframe" href="'.$SendUrl . '&view=' . $values['OrderID'].'" >'.$sendemail.'</a>';
?>

</td>
		<!--td width="10%"><?=stripslashes($values["PaymentTerm"])?></td-->
		<td width="8%"><?=$DueDate?></td>
		
		<td width="15%"><? echo number_format($BalanceCC,2).' '.$values['CustomerCurrency']; 
		?></td>
		<td width="12%"><?=number_format($orginalAmount,2)?> </td>
		<td width="9%"><b><?=number_format($UnpaidInvoice,2)?></b></td>
		
		<td width="7%"><?=(!empty($CurrentBalance))?(number_format($CurrentBalance,2)):('-')?></td>
		<td width="7%"><?=(!empty($Balance30))?(number_format($Balance30,2)):('-')?></td>
		<td width="6%"><?=(!empty($Balance60))?(number_format($Balance60,2)):('-')?></td>
		<td width="6%"><?=(!empty($Balance90))?(number_format($Balance90,2)):('-')?></td>
		<td width="7%"><?=(!empty($Balance120))?(number_format($Balance120,2)):('-')?></td>
		
		</tr>
		<?php 
		} //end row

} // foreach end //


		 
		$TotalUnpaidInvoice += -$CreditAmount;
		$TotalCurrentBalance += -$CreditAmount;	

		if($CustomerCurrencyAll=='None') $CustomerCurrencyAll='';
	?>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="11" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>
             
	</table>
	</div>   

<? if(sizeof($arryAging)>0){ ?>
<table id="list_table"  cellspacing="1" cellpadding="10" width="100%" align="center">

		 <tr>
		<td colspan="3" align="right" ><b>Total : </b></td>
		<td width="14%"><b><?=number_format($TotalBalanceCC,2);?> <?=$CustomerCurrencyAll?></b></td>
		<td width="12%"></td>
		<td  width="9%"><b><?=number_format($TotalUnpaidInvoice,2);?></b></td>
		
		<td  width="7%"><b><?=number_format($TotalCurrentBalance,2);?></b></td>
		<td width="7%"><b><?=number_format($TotalBalance30,2);?></b></td>
		<td width="6%"><b><?=number_format($TotalBalance60,2);?></b></td>
		<td width="6%"><b><?=number_format($TotalBalance90,2);?></b></td>
		<td width="8%"><b><?=number_format($TotalBalance120,2);?></b></td>
		</tr>

		
</table>
<?  } ?>

<script language="JavaScript1.2" type="text/javascript">

  function makepdffile(url) {
        $.ajax({
            url: url,
        });
    }

$(document).ready(function() {

	
	var BaseCurrency = '<?=$Config["Currency"]?>';
	var CreditLimitCurrency = '<?=$arryCustomer[0]["CreditLimitCurrency"]?>';
	var CustomerCurrency = '<?=$arryCustomer[0]["Currency"]?>';

	SetCreditBalance(<?=$TotalUnpaidInvoice?>,<?=$TotalBalanceCC?>);
	function SetCreditBalance(UnpaidInvoice,BalanceCC){   
		if(document.getElementById("CreditBalance") != null){				  
			var CreditLimit = 0;
			var CreditBalance = 0;
			var Currency = BaseCurrency;

			if(CustomerCurrency!='' && CustomerCurrency != BaseCurrency){			
				CreditLimit = '<?=$arryCustomer[0]["CreditLimitCurrency"]?>';  				 	 
				CreditBalance = CreditLimit - BalanceCC;
				Currency = CustomerCurrency;			
			}else{
				CreditLimit = '<?=$arryCustomer[0]["CreditLimit"]?>';    
				CreditBalance = CreditLimit - UnpaidInvoice;
			}
	
			if(document.getElementById("TotalOpenAmount") != null){	
				CreditBalance = CreditBalance - document.getElementById("TotalOpenAmount").value;
			}

			CreditBalance = parseFloat(CreditBalance).toFixed(2);
			$("#CreditBalance").html(CreditBalance+' '+Currency);		
			if(CreditBalance!='' && !isNaN(CreditBalance)){
				$("#CreditBalanceTr").show();
			} 				 
		}
	}








        $(".fancybig").fancybox({
            'width': 900
        });

    });
</script>


<? } ?>
