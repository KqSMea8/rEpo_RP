
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
		<td   >
		<select id="CustCode" class="inputbox" name="CustCode">
			   <option value="">---All Customers---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_GET['CustCode'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['CustomerName']; ?></option>
				<?php }?>
			</select>
		</td>
		
	           

		<td style="display:none" >
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
		<td  >

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

		<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){ ?>
		 <td>&nbsp;</td>
		<td >
		 <select name="os" class="textbox" id="os" style="width:140px;">
		<option value="">--- Order Source ---</option>
		<!--option value="Amazon" <?  if($_GET['os'] == "Amazon"){echo "selected";}?>>Amazon</option>
		<option value="Ebay" <?  if($_GET['os'] == "Ebay"){echo "selected";}?>>Ebay</option-->
		<?php for($i=0;$i<sizeof($arryOrderSource);$i++) {?>
                                    <option value="<?=$arryOrderSource[$i]['attribute_value']?>" <?  if($arryOrderSource[$i]['attribute_value']==$_GET['os']){echo "selected";}?>>
					<?=$arryOrderSource[$i]['attribute_value']?>
                                    </option>
			<? } ?>

		</select> 
		</td>
               
		<? } ?>
		 <td>&nbsp;</td>
		<td >
		 <select id="sp" method="get" class="inputbox" name="sp">
			    <option value="">--- Sales Person ---</option>
			     <?php foreach($arryEmployee as $employe){?>
				 <option value="<?=$employe['EmpID'];?>" <?php if($_GET['sp'] == $employe['EmpID']){echo "selected";}?>><?=stripslashes($employe["UserName"])?></option>
				<?php }?>
			</select>
		</td>
		
	   <td>&nbsp;</td>
 
		<td  align="right"   class="blackbold"  > Currency  :</td>
                <td   align="left" >
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
$("#CustCode").select2();
$("#sp").select2();
</script> 

	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
              <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_ar_aging_report.php?<?=$QueryString?>&module=Invoice';">
<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/-->
              <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_ArAging_report.php?<?=$QueryString?>&module=Invoice';"-->

	    <? } ?>


		</td>
      </tr>
	 
<tr>
	 <td align="right">
<?
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
		<td class="head1" >Customer</td>  
		<td class="head1" width="10%">Invoice Date</td>    
		<td class="head1">Invoice/Credit Memo #</td>   
		<td class="head1" width="7%">Payment Term</td>   
		<td class="head1" width="9%">Due Date</td>  
		<td class="head1" width="5%">PO #</td>
                <td class="head1" width="5%">Order Source</td>               
                <td class="head1" width="7%">Invoice Amount</td> 
                <td class="head1" width="4%"><? if(empty($_GET['Currency'])){ echo 'Conversion Rate'; } ?></td> 
                <td class="head1" width="6%">Original Amount 
<? if(empty($_GET['Currency'])){ echo '['.$Config['Currency'].']'; } ?></td> 
  
		<td class="head1" width="6%">Balance </td>  
		<td class="head1" width="6%">Current </td>  
		<td class="head1" width="6%">30 Days </td>
		<td class="head1" width="6%">60 Days </td>
		<td class="head1" width="6%">90 Days </td>
		<td class="head1" width="6%">120 Days</td>
		</tr>


		<?php 
		if(is_array($arryAging) && $num>0){
		$NewCustCode='';
		$CreditAmount='';
		$flag=true;
		$Line=0;
		$TotalOriginalAmount = 0;
                $TotalUnpaidInvoice = 0;
                $TotalCurrentBalance = 0;
                $TotalBalance30 = 0;
                $TotalBalance60 = 0;
                $TotalBalance90 = 0;
		$TotalBalance120 = 0;
                
              
		
      
                
 		$CustomerOriginalAmount = 0;
		$CustomerUnpaidInvoice = 0;
		$CustomerCurrentBalance = 0;
                $CustomerBalance30 = 0;
                $CustomerBalance60 = 0;
                $CustomerBalance90 = 0;
		$CustomerBalance120 = 0;
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
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?view='.$values['OrderID'].'&IE='.$values['InvoiceEntry'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}

			/*$CurrentBalance = $objReport->getARUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 29 days')),date('Y-m-d'),$values['InvoiceID']);
			$Balance30 = $objReport->getARUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 59 days')),date('Y-m-d',strtotime('today - 30 days')),$values['InvoiceID']);
			$Balance60 = $objReport->getARUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 89 days')),date('Y-m-d',strtotime('today - 60 days')),$values['InvoiceID']);
			$Balance90 = $objReport->getARUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 119 days')),date('Y-m-d',strtotime('today - 90 days')),$values['InvoiceID']);
		 	$Balance120 = $objReport->getARUnpaidInvoiceByDays(date('Y-m-d', strtotime('today - 600 days')),date('Y-m-d',strtotime('today - 120 days')),$values['InvoiceID']);*/

		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];
			$ModuleDate=$values['PostedDate'];

			if($values['OverPaid']=='1'){
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?inv='.$values['InvoiceID'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
			}
			//if($values['ReceiveAmnt']!='') $values['ReceiveAmnt']=-$values['ReceiveAmnt'];

			/*$CurrentBalance = $objReport->getARUnpaidCreditByDays(date('Y-m-d', strtotime('today - 29 days')),date('Y-m-d'),$values['CreditID']);
			$Balance30 = $objReport->getARUnpaidCreditByDays(date('Y-m-d', strtotime('today - 59 days')),date('Y-m-d',strtotime('today - 30 days')),$values['CreditID']);
			$Balance60 = $objReport->getARUnpaidCreditByDays(date('Y-m-d', strtotime('today - 89 days')),date('Y-m-d',strtotime('today - 60 days')),$values['CreditID']);
			$Balance90 = $objReport->getARUnpaidCreditByDays(date('Y-m-d', strtotime('today - 119 days')),date('Y-m-d',strtotime('today - 90 days')),$values['CreditID']);
		 	$Balance120 = $objReport->getARUnpaidCreditByDays(date('Y-m-d', strtotime('today - 600 days')),date('Y-m-d',strtotime('today - 120 days')),$values['CreditID']);*/

		}
		/***********************/
		/*$CurrentBalance = GetConvertedAmount($ConversionRate, $CurrentBalance); 
		$Balance30 = GetConvertedAmount($ConversionRate, $Balance30); 
		$Balance60 = GetConvertedAmount($ConversionRate, $Balance60); 
		$Balance90 = GetConvertedAmount($ConversionRate, $Balance90); 
		$Balance120 = GetConvertedAmount($ConversionRate, $Balance120);*/ 
		

	$OrderAmount = $orginalAmount;
	$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 
	$PaidAmnt = $values['ReceiveAmnt'];

		if(!empty($_GET['Currency']) && $values['CustomerCurrency']!=$BaseCurrency && $values['ConversionRate']>0){
			$PaidAmnt = GetConvertedAmountReverse($values['ConversionRate'], $PaidAmnt); 
		}


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
               
		?>

		<?php if(($NewCustCode != '' && $NewCustCode != $values['CustCode'])){ 

			$CustomerUnpaidInvoice += -$CreditAmount;
			$CustomerCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
			//'. number_format($CustomerOriginalAmount,2).'
			$CustomerTotal = '<tr class="oddbg">
			<td colspan="9" align="right" height="30" ><b> Total : </b></td>
			<td><b></b></td>
                        <td><b>'.number_format($CustomerUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($CustomerCurrentBalance,2).'</b></td>
			<td><b>'.number_format($CustomerBalance30,2).'</b></td>
			<td><b>'.number_format($CustomerBalance60,2).'</b></td>
			<td><b>'.number_format($CustomerBalance90,2).'</b></td>
			<td><b>'.number_format($CustomerBalance120,2).'</b></td>
			</tr>';
		 	echo $CustomerTotal;
			$CustomerOriginalAmount=0;
			$CustomerUnpaidInvoice = 0;
			$CustomerCurrentBalance = 0;
			$CustomerBalance30 = 0;
			$CustomerBalance60 = 0;
			$CustomerBalance90 = 0;
			$CustomerBalance120 = 0;
			 
   
                      
               

     

		} ?>

		<? if($NewCustCode != $values['CustCode']){  ?>
		<tr>
		<td colspan="4" height="30" class="head1">
		<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID=<?=$values['CustID']?>" ><b><?=stripslashes($values["Customer"])?></b></a>
		</td>
		<td colspan="4" class="head1"><b>Phone:</b> <?=$values['Landline']?>	</td>
		<td colspan="5" class="head1"><b>Contact :</b>   <?
			echo $values['ContactPerson'];
			/*$Address='';
		   if(!empty($values['Address'])) $Address =  stripslashes($values['Address']).', ';		   
		   if(!empty($values['CityName'])) $Address .= htmlentities($values['CityName'], ENT_IGNORE).', ';		   
		   if(!empty($values['StateName'])) $Address .= $values['StateName'].', ';		   
		   if(!empty($values["CountryName"])) $Address .= $values["CountryName"];	   
		   if(!empty($values['ZipCode'])) $Address .= ' - '. $values['ZipCode'];	
		   
			echo $Address;*/

		   ?></td>
		
		
		
		<td colspan="3" class="head1">
<b>Credit Limit:</b> <?=(!empty($values['CreditLimitCurrency']) && !empty($values['CustCurrency']) && $values['CustCurrency']!=$Config['Currency'])?($values['CreditLimitCurrency'].' '.$values['CustCurrency']):($values['CreditLimit']); ?>

</td>
		</tr>

		<? #$CreditAmount = $values['CreditAmount']; 
			if($CreditAmount>0){
		?>
		<tr>
			<td></td>
			<td></td>
			<td colspan="2">Customer Credit</td>
			<td colspan="6"></td>
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
                <td>   </td>
		<td><?=date($Config['DateFormat'], strtotime($ModuleDate))?></td>
		<td><?=$ModuleLink?></td>
                <td><?=stripslashes($values["PaymentTerm"])?> </td>
		<td><?=$DueDate?> </td>
		<td><?=$values["CustomerPO"]?></td>
                <td><?=$values["OrderSource"]?></td>
                <td><?=$OrderAmount. " ".$values["CustomerCurrency"]?></td>
                
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


		$NewCustCode = $values['CustCode'];
		$Customer =  $values["Customer"];

		
		$CustomerOriginalAmount +=$orginalAmount;
		$CustomerUnpaidInvoice +=$UnpaidInvoice;
		$CustomerCurrentBalance +=$CurrentBalance;
		$CustomerBalance30 +=$Balance30;
		$CustomerBalance60 +=$Balance60;
		$CustomerBalance90 +=$Balance90;
		$CustomerBalance120 +=$Balance120;

 } // foreach end //


		if(empty($_GET['CustCode'])){

			$CustomerUnpaidInvoice += -$CreditAmount;
			$CustomerCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			//'.number_format($CustomerOriginalAmount,2).'
			$CustomerTotal = '<tr class="evenbg">
			<td colspan="9" align="right" height="30"><b>Total : </b></td>
                        <td><b></b></td> 
			<td><b>'.number_format($CustomerUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($CustomerCurrentBalance,2).'</b></td>
			<td><b>'.number_format($CustomerBalance30,2).'</b></td>
			<td><b>'.number_format($CustomerBalance60,2).'</b></td>
			<td><b>'.number_format($CustomerBalance90,2).'</b></td>
			<td><b>'.number_format($CustomerBalance120,2).'</b></td>
			</tr>';
			echo $CustomerTotal;
		}else{
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
		}


?>
              <tr class="oddbg">
		<td colspan="9" align="right" ><b>Total : </b></td>  
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
		<td  colspan="16" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		
		</table>
		</div> 
		
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

