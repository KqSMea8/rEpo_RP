<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	ShowHideLoader(1,'F');
	return true;		
}
</script>
<?php 
     $conversionRateArray[$Config['Currency']] = '';
?>
<div class="had"><?=$MainModuleName?> Report</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td >
		  <select name="s" id="s" class="inputbox">
                            <option value="">---All Vendors---</option>
                            <?php foreach($arryVendorList as $values){?>
                            <option value="<?=$values['SuppCode']?>" <?php if($_GET['s'] == $values['SuppCode']){echo "selected";}?>>  <?=$values['VendorName']?></option>
                            <?php }?>
                            
                        </select>
		</td>
		

		<td style="display:none">
		 <? if($_GET['From']>0) $FromDate = $_GET['From'];  ?>				
		<script type="text/javascript">
		$(function() {
			$('#From').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				//maxDate: "+0D", 
				changeMonth: true,
				changeYear: true

				}
			);
			$("#From").on("click", function () {
			    $(this).val("");
			   });
		});
		</script>

 <input id="From" name="From" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 


	</td> 


		 <td>&nbsp;</td>
		<td  align="right"   class="blackbold"> As of Date : </td>
		<td >

		 <? if($_GET['To']>0) $ToDate = $_GET['To'];  ?>				
<script type="text/javascript">
$(function() {
	$('#To').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				//maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
	 $("#To").on("click", function () {
            $(this).val("");
           });
});
</script>
 
<input id="To" name="To" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="">

</td> 


 <td>&nbsp;</td> <td>&nbsp;</td>
		<td  align="right"   class="blackbold"> 

<select name="InvDtType" id="InvDtType" class="textbox">
	<option value="i" > Invoice Post Date </option>
 	<option value="v" <?=($_GET['InvDtType']=='v')?('selected'):('')?>> Vendor Invoice Date  </option>
</select>
: </td>
		<td >

		 <? if($_GET['InvDt']>0) $InvDt = $_GET['InvDt'];  ?>				
<script type="text/javascript">
$(function() {
	$('#InvDt').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 				
		changeMonth: true,
		changeYear: true

		}
	);
	 $("#InvDt").on("click", function () {
            $(this).val("");
           });
});
</script>
 
<input id="InvDt" name="InvDt" readonly="" class="datebox" value="<?=$InvDt?>"  type="text" placeholder="">

</td> 

                <td>&nbsp;</td> <td>&nbsp;</td>
		<td  align="right"   class="blackbold"> Currency  :</td>
                <td   align="left"  >

                    <!--select name="Currency" multiple="multiple" class="inputbox js-example-basic-multiple" id="Currency" style="width:230px;"-->
			 <select name="Currency" class="textbox" id="Currency" style="width:80px;">
			<option value="">--- All ---</option>
                      <?php 
                      for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
                      <option value="<?=$arrySelCurrency[$i]?>" <?php if(in_array($arrySelCurrency[$i], $currencyArray)){echo "selected";}?>>
                      <?=$arrySelCurrency[$i];?>
                      </option>
                      <? } ?>
                    </select>       
                </td>
<script>
//$(".js-example-basic-multiple").select2();
</script>                
              

	  <td align="right"  >   <input name="search" type="submit" class="search_button" value="Go"  />	  
	 
	  
	  </td> 
 </tr>


</table>
 	</form>


<script>
$("#s").select2();
</script> 
	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
              <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_ap_aging_report.php?<?=$QueryString?>&module=Invoice';" -->

	    <? } ?>

		</td>
      </tr>
	 	
<tr>
	 <td align="right">
<?php
$BaseCurrency =  $Config['Currency'];
if(!empty($_GET['Currency'])) $Config['Currency']=$_GET['Currency'];
echo $CurrencyInfo = str_replace("[Currency]",$Config['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>
  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		<tr align="left"  >
		<td class="head1" >Vendor</td>  
		<td class="head1" width="10%">Invoice Date</td>    
		<td class="head1">Invoice/Credit Memo #</td>   

		<td class="head1" width="5%">Payment Term</td>    
		<td class="head1" width="9%">Due Date</td>  
		<td class="head1" width="6%">PO #</td>  
 	
                <td class="head1" width="6%">Invoice Amount</td> 
                <td class="head1" width="4%"><? if(empty($_GET['Currency'])){ echo 'Conversion Rate'; } ?></td> 
                 <td class="head1" width="8%">Original Amount 
<? if(empty($_GET['Currency'])){ echo '['.$Config['Currency'].']'; } ?></td> 
  	
		<td class="head1" width="7%">Balance </td>  
		<td class="head1" width="7%">Current </td>  
		<td class="head1" width="6%">30 Days </td>
		<td class="head1" width="6%">60 Days </td>
		<td class="head1" width="6%">90 Days </td>
		<td class="head1" width="6%">120 Days</td>
		</tr>

		<?php 
		if(is_array($arryAging) && $num>0){
		$NewSuppCode='';
		$CreditAmount = '';
		$flag=true;
		$Line=0;
		$TotalOriginalAmount=0;
                $TotalUnpaidInvoice = 0;
                $TotalCurrentBalance = 0;
                $TotalBalance30 = 0;
                $TotalBalance60 = 0;
                $TotalBalance90 = 0;
		$TotalBalance120 = 0;

 
              

     
                $VendorOriginalAmount = 0;
		$VendorUnpaidInvoice = 0;
		$VendorCurrentBalance = 0;
                $VendorBalance30 = 0;
                $VendorBalance60 = 0;
                $VendorBalance90 = 0;
		$VendorBalance120 = 0;

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

			/*$CurrentBalance = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 29 days')),date('Y-m-d'),$values['InvoiceID']);
		        $Balance30 = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 59 days')),date('Y-m-d',strtotime('today - 30 days')),$values['InvoiceID']);
		        $Balance60 = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 89 days')),date('Y-m-d',strtotime('today - 60 days')),$values['InvoiceID']);
		        $Balance90 = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 119 days')),date('Y-m-d',strtotime('today - 90 days')),$values['InvoiceID']);
		 	$Balance120 = $objReport->getAPUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 600 days')),date('Y-m-d',strtotime('today - 120 days')),$values['InvoiceID']);*/		

		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];	
			if($values['OverPaid']=='1'){	
				$ModuleLink = '<a href="vPoInvoice.php?module=Invoice&pop=1&inv='.$values['InvoiceID'].'" class="fancybox fancybig fancybox.iframe">'.$values["InvoiceID"].'</a>';
			}else{	 
				$ModuleLink = '<a class="fancybox fancybig fancybox.iframe" href="vPoCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
			}

			/*$CurrentBalance = $objReport->getAPUnpaidCreditByDays(date('Y-m-d', strtotime('today - 29 days')),date('Y-m-d'),$values['CreditID']);
		        $Balance30 = $objReport->getAPUnpaidCreditByDays(date('Y-m-d', strtotime('today - 59 days')),date('Y-m-d',strtotime('today - 30 days')),$values['CreditID']);
		        $Balance60 = $objReport->getAPUnpaidCreditByDays(date('Y-m-d', strtotime('today - 89 days')),date('Y-m-d',strtotime('today - 60 days')),$values['CreditID']);
		        $Balance90 = $objReport->getAPUnpaidCreditByDays(date('Y-m-d', strtotime('today - 119 days')),date('Y-m-d',strtotime('today - 90 days')),$values['CreditID']);
		 	$Balance120 = $objReport->getAPUnpaidCreditByDays(date('Y-m-d', strtotime('today - 600 days')),date('Y-m-d',strtotime('today - 120 days')),$values['CreditID']);*/				

		}
		/***********************/
		/*$CurrentBalance = GetConvertedAmount($ConversionRate, $CurrentBalance); 
		$Balance30 = GetConvertedAmount($ConversionRate, $Balance30); 
		$Balance60 = GetConvertedAmount($ConversionRate, $Balance60); 
		$Balance90 = GetConvertedAmount($ConversionRate, $Balance90); 
		$Balance120 = GetConvertedAmount($ConversionRate, $Balance120); */


		/******Hide for vendor commission invoice if it is unpaid******/		
		if(!empty($values['ArInvoiceID'])){
			 $ArInvoiceIDStatus = $objReport->getArInvoiceIDStatus($values['ArInvoiceID']);
			 if($ArInvoiceIDStatus!="Paid")$orginalAmount=0;
			 		  
		}
		/***********************/


         	$OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount);         
                $PaidAmnt = $values['PaidAmnt'];

		if(!empty($_GET['Currency']) && $values['Currency']!=$BaseCurrency && $values['ConversionRate']>0){
			$PaidAmnt = GetConvertedAmountReverse($values['ConversionRate'], $PaidAmnt); 
		}

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

		

                if(!empty($values["VendorName"])){ 
                	$SupplierName = $values["VendorName"];
                }else{
                	$SupplierName = $values["SuppCompany"];
                }

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

		<? if(($NewSuppCode != '' && $NewSuppCode != $values['SuppCode'])){ 

			$VendorUnpaidInvoice += -$CreditAmount;
			$VendorCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			//number_format($VendorOriginalAmount,2);
			$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b> Total : </b></td>
                        <td><b> </b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';
		 	echo $VendorTotal;
			$VendorOriginalAmount=0;
			$VendorUnpaidInvoice = 0;
			$VendorCurrentBalance = 0;
			$VendorBalance30 = 0;
			$VendorBalance60 = 0;
			$VendorBalance90 = 0;
			$VendorBalance120 = 0;

                        


		} ?>



		<? if($NewSuppCode != $values['SuppCode']){  ?>
		<tr>
		<td colspan="4" height="30" class="head1">
		<a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><b><?=stripslashes(ucfirst($SupplierName))?></b></a>
		</td>
		<td colspan="4" class="head1"><b>Phone:</b> <?=$values['Landline']?>	</td>
		<td colspan="4" class="head1"><b>Contact :</b>   <?
			echo $values['ContactPerson'];
			/*$Address='';
		   if(!empty($values['Address'])) $Address =  stripslashes($values['Address']).', ';		   
		   if(!empty($values['City'])) $Address .= htmlentities($values['City'], ENT_IGNORE).', ';		   
		   if(!empty($values['State'])) $Address .= $values['State'].', ';		   
		   if(!empty($values["Country"])) $Address .= $values["Country"];	   
		   if(!empty($values['ZipCode'])) $Address .= ' - '. $values['ZipCode'];	
		   
			echo $Address;*/

		   ?></td>
		
		
		
		<td colspan="3" class="head1"><b>Credit Limit:</b> <?=$values['CreditLimit']?></td>
		</tr>
		<? #$CreditAmount = $values['CreditAmount']; 
			if($CreditAmount>0){
		?>
		<tr>
			<td></td>
			<td></td>
			<td colspan="2">Vendor Credit</td>
			<td colspan="5"></td>
			<td><b>-<?=$CreditAmount?></b></td>
			<td>-<?=$CreditAmount?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<? } 
		}


		if(abs($UnpaidInvoice)>0){  //start row
	 ?> 
		 <tr align="left" class="<?=$bgclass?>">
                <td>  </td>
		<td><?=date($Config['DateFormat'], strtotime($values['PostedDate']))?></td>
		<td><?=$ModuleLink?></td>		 
		<td><?=stripslashes($values["PaymentTerm"])?></td>
		<td><?=$DueDate?> </td>
		<td><?=$values["PurchaseID"]?></td>
            
                <td><?=$OrderAmount. " ".$values["Currency"]?></td>
                 
              <td>
		<?	 
			if($ConversionRate!=1){	
				echo $ConversionRate;			   
			}

		 
		?>


		</td>
                <td><?php 
                 
                 echo number_format($orginalAmount,2);
                $TotalOriginalAmount  +=$orginalAmount;
                ?></td>

		<td><b><?=number_format($UnpaidInvoice,2)?></b></td>
		
		<td><?=(!empty($CurrentBalance))?(number_format($CurrentBalance,2)):('-')?></td>
		<td><?=(!empty($Balance30))?(number_format($Balance30,2)):('-')?></td>
		<td><?=(!empty($Balance60))?(number_format($Balance60,2)):('-')?></td>
		<td><?=(!empty($Balance90))?(number_format($Balance90,2)):('-')?></td>
		<td><?=(!empty($Balance120))?(number_format($Balance120,2)):('-')?></td>
		
		</tr>
	

		<?
 		} //end row

		$NewSuppCode = $values['SuppCode'];
		$Supplier = $SupplierName;

		$VendorOriginalAmount +=$orginalAmount;
		$VendorUnpaidInvoice +=$UnpaidInvoice;
   		$VendorCurrentBalance +=$CurrentBalance;
                $VendorBalance30 +=$Balance30;
                $VendorBalance60 +=$Balance60;
                $VendorBalance90 +=$Balance90;
                $VendorBalance120 +=$Balance120;

} // foreach end //


		if(empty($_GET['s'])){
			
			$VendorUnpaidInvoice += -$CreditAmount;
			$VendorCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			//number_format($VendorOriginalAmount,2)
			$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b>Total : </b></td>
                        <td><b></b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';
			echo $VendorTotal;
		}else{
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
		}
	?>

		<tr>
		<td colspan="8" align="right"><b>Total : </b></td>
                <td><b><? //echo number_format($TotalOriginalAmount,2);?></b></td>
		<td><b><?=number_format($TotalUnpaidInvoice,2);?></b></td>
		<td><b><?=number_format($TotalCurrentBalance,2);?></b></td>
		<td><b><?=number_format($TotalBalance30,2);?></b></td>
		<td><b><?=number_format($TotalBalance60,2);?></b></td>
		<td><b><?=number_format($TotalBalance90,2);?></b></td>
		<td><b><?=number_format($TotalBalance120,2);?></b></td>
		</tr>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="15" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		
		</table>
		</div> 
		<?  /*if($num>0){
		echo '<div class="bar_chart">';
		echo '<h2>'.$MainModuleName.'</h2>';
		echo '<img src="barSO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&m='.$_GET['m'].'&y='.$_GET['y'].'&c='.$_GET['c'].'&st='.$_GET['st'].'" >';
		echo '</div>';
		}*/
		?>
		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		</form>
</td>
</tr>

</table>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>

