<?  
if($SuppCode!=''){  
	$arryAging=$objReport->apAgingReportList($SuppCode,'');
	
?>
<br>
<table id="list_table" cellspacing="1" cellpadding="10" width="100%" align="center">
<tr align="left"  >
		<td class="head1" width="9%">Invoice Date</td>    
		<td class="head1">Invoice/Credit Memo #</td>   
		<td class="head1" width="10%">Payment Term</td>    
		<td class="head1" width="9%">Due Date</td>  
		<td class="head1" width="8%">PO #</td>  
		<td class="head1" width="10%">Balance [<?=$Config['Currency']?>]</td>  
		<td class="head1" width="8%">Current </td>  
		<td class="head1" width="8%">30 Days </td>
		<td class="head1" width="8%">60 Days </td>
		<td class="head1" width="8%">90 Days </td>
		<td class="head1" width="8%">120 Days</td>
		</tr>
</table>
<div style="overflow-y:scroll; max-height:400px;">
<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">	
<?php 

	//$DateFormat = $Config['DateFormat'];
	$DateFormat = 'm/d/Y';
 $TotalUnpaidInvoice = 0;
                $TotalCurrentBalance = 0;
		if(sizeof($arryAging)>0){
		$flag=true;
		$Line=0;
		$CreditAmount=0;
                
                $TotalBalance30 = 0;
                $TotalBalance60 = 0;
                $TotalBalance90 = 0;
		$TotalBalance120 = 0;
		foreach($arryAging as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;
                
                $ConversionRate=1;
		if($values['Currency']!=$Config['Currency'] && $values['ConversionRate']>0 ){				
			$ConversionRate = $values['ConversionRate'];			
		 
		}

		$CurrentBalance = 0;
		$Balance30 =  0;
		$Balance60 =  0;
		$Balance90 =  0;
		$Balance120 =  0;
	 	/***********************/
		$ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			 if($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { 
				$ModuleLink = '<a href="vOtherExpense.php?pop=1&view='.$values['ExpenseID'].'" class="fancybox fancybig fancybox.iframe">'.$values["InvoiceID"].'</a>';
			 } else { 
				$ModuleLink = '<a href="vPoInvoice.php?module=Invoice&pop=1&view='.$values['OrderID'].'" class="fancybox fancybig fancybox.iframe">'.$values["InvoiceID"].'</a>';
			} 

			 

		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];			 
			if($values['OverPaid']=='1'){	
				$ModuleLink = '<a href="vPoInvoice.php?module=Invoice&pop=1&inv='.$values['InvoiceID'].'" class="fancybox fancybig fancybox.iframe">'.$values["InvoiceID"].'</a>';
			}else{	 
				$ModuleLink = '<a class="fancybox fancybig fancybox.iframe" href="vPoCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
			}

			 			

		}
		/***********************/	
 		/******Hide for vendor commission invoice if it is unpaid******/		
		if(!empty($values['ArInvoiceID'])){
			 $ArInvoiceIDStatus = $objReport->getArInvoiceIDStatus($values['ArInvoiceID']);
			 if($ArInvoiceIDStatus!="Paid")$orginalAmount=0;
			 		  
		}
		/***********************/

         	$OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount);          
                $PaidAmnt = $values['PaidAmnt'];
                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $orginalAmount;
                }
                
		 
		/***********************/
		$AgingDay = GetAgingDay($values['PostedDate']); 
		switch($AgingDay){
			case '1': $CurrentBalance = $UnpaidInvoice; break;
			case '2': $Balance30 = $UnpaidInvoice; break;
			case '3': $Balance60 = $UnpaidInvoice; break;
			case '4': $Balance90 = $UnpaidInvoice; break;
			case '5': $Balance120 = $UnpaidInvoice; break;
		} 
		/***********************/


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
			$arryDate = explode("-",$values['PostedDate']);
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
                
		?>



		<? 
			if($Line==1){
				#$CreditAmount = $values['CreditAmount']; 
				if(!empty($CreditAmount)){
		?>
		<tr class="<?=$bgclass?>">
			 
			<td></td>
			<td colspan="2">Vendor Credit</td>
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
		<td width="9%"><?=date($DateFormat, strtotime($values['PostedDate']))?></td>
		<td><?=$ModuleLink?></td>	
		<td  width="10%"><?=stripslashes($values["PaymentTerm"])?></td>
		<td width="9%"><?=$DueDate?> </td>
		<td width="8%"><?=$values["PurchaseID"]?></td>
		<td width="10%"><b><?=number_format($UnpaidInvoice,2)?></b></td>
		
		<td width="8%"><?=(!empty($CurrentBalance))?(number_format($CurrentBalance,2)):('-')?></td>
		<td width="8%"><?=(!empty($Balance30))?(number_format($Balance30,2)):('-')?></td>
		<td width="8%"><?=(!empty($Balance60))?(number_format($Balance60,2)):('-')?></td>
		<td width="8%"><?=(!empty($Balance90))?(number_format($Balance90,2)):('-')?></td>
		<td width="7%"><?=(!empty($Balance120))?(number_format($Balance120,2)):('-')?></td>
		
		</tr>
		<?php 
		} //end row

} // foreach end //


		
		$TotalUnpaidInvoice += -$CreditAmount;
		$TotalCurrentBalance += -$CreditAmount;

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
		<td align="right"><b>Total : </b></td>
		<td width="9%"><b><?=number_format($TotalUnpaidInvoice,2);?></b></td>
		<td width="8%"><b><?=number_format($TotalCurrentBalance,2);?></b></td>
		<td width="8%"><b><?=number_format($TotalBalance30,2);?></b></td>
		<td width="8%"><b><?=number_format($TotalBalance60,2);?></b></td>
		<td width="8%"><b><?=number_format($TotalBalance90,2);?></b></td>
		<td width="8%"><b><?=number_format($TotalBalance120,2);?></b></td>
		</tr>

		
</table>
<?  } ?>


<script language="JavaScript1.2" type="text/javascript">
SetCreditBalance(<?=$TotalUnpaidInvoice?>);
function SetCreditBalance(UnpaidInvoice){
	
	if(document.getElementById("CreditBalance") != null){
		var CreditLimit = document.getElementById("CreditLimit").value;
		var CreditBalance = CreditLimit - UnpaidInvoice;
		$("#CreditBalance").html(CreditBalance);
		if(CreditBalance!='' && !isNaN(CreditBalance)){
			$("#CreditBalance").show();
			$("#CreditBalanceCurrency").show();
		}else{
			$("#CreditBalance").hide();
			$("#CreditBalanceCurrency").hide();
		}
	}
}

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });
</script>

<? } ?>


