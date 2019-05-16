<? 
if($arryCustomer[0]['CustCode']!=''){
	 	 
	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];
	/*if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
    	if(empty($_GET['f'])){ $_GET['f'] = date('Y-01-01');}*/

	if(empty($_GET['fby'])){ 
		$_GET['fby'] = 'Month';
		$_GET['m'] = date("m");
		$_GET['y'] = date("Y");
	}

	$arrySalesHistory = $objCustomer->ListCustomerSales($_GET);
 	if(!empty($_GET['pk'])){
		pr($arrySalesHistory,1);
	}
	$NumRec = sizeof($arrySalesHistory);

	$arrayMonth =  array();
	$NumMonth = 12;
	/*****************/
	if($_GET['fby']=="Year"){
		foreach($arrySalesHistory as $key=>$values){
			$arrayMonth[] = $values["MonthDate"];		
		}

	 
		for($i=1;$i<=12;$i++){
			if(!in_array($i,$arrayMonth)){
				$j=$i;
				if($j<10) $j='0'.$i;
				$arrySalesHistory[$NumRec]["MonthDate"] = $j;
				$arrySalesHistory[$NumRec]["InvDate"] = $_GET['y'].'-'.$j.'-01';
				$arrySalesHistory[$NumRec]["TotalInvoiceNo"] = 0;
				$arrySalesHistory[$NumRec]["SalesLineAmount"] = 0;
				$arrySalesHistory[$NumRec]["SalesAmountGL"] = 0;
				$arrySalesHistory[$NumRec]["CostOfSale"] = 0; 
				$arrySalesHistory[$NumRec]["CreditLineAmount"] = 0;
				$arrySalesHistory[$NumRec]["CreditAmountGL"] = 0;
				$arrySalesHistory[$NumRec]["CostOfCredit"] = 0;
				$NumRec++;
			}
		}
		$arrySalesHistory = sortMultiArrayByKey($arrySalesHistory,"MonthDate");
	}else if($_GET['fby']=="Month" && empty($NumRec)){
		$arrySalesHistory[0]["MonthDate"] = $_GET['m'];
		$arrySalesHistory[0]["InvDate"] = $_GET['y'].'-'.$_GET['m'].'-01';
		$arrySalesHistory[0]["TotalInvoiceNo"] = 0;
		$arrySalesHistory[0]["SalesLineAmount"] = 0;
		$arrySalesHistory[0]["SalesAmountGL"] = 0;
		$arrySalesHistory[0]["CostOfSale"] = 0; 
		$arrySalesHistory[0]["CreditLineAmount"] = 0;
		$arrySalesHistory[0]["CreditAmountGL"] = 0;
		$arrySalesHistory[0]["CostOfCredit"] = 0;
		$NumRec++;
		 
	}
	//pr($arrySalesHistory,1);
 	/*****************/
?>
<script language="JavaScript1.2" type="text/javascript">
function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}


function ValidateSearch(frm){	
	
	if(document.getElementById("fby").value=='Year'){
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else if(document.getElementById("fby").value=='Month'){
		if(!ValidateForSelect(frm.m, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else{
		if(!ValidateForSelect(frm.f, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.t, "To Date")){
			return false;	
		}

		if(frm.f.value>frm.t.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

	}

	ShowHideLoader(1,'F');
	return true;	



	
}

</script>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<? if($HideSearch!=1){ ?>

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
         <tr>
             <td valign="bottom">Filter By :<br> 
		        <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <!--option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option-->
					 <option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
					 <option value="Month" <?  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>
		        </select> 
		    </td>
	   <td>&nbsp;</td>
           <td valign="bottom">
		      <? if($_GET['f']>0) {
			   $FromDate = $_GET['f'];}else{$FromDate = date('Y-01-01');}?>				
<script type="text/javascript">
$(function() {
    $('#f').datepicker(
        {
		showOn: "both",dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
	    maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="fromDiv" style="display:none">
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 
</div>
    </td> 
       <td valign="bottom">
        <? if($_GET['t']>0){ $ToDate = $_GET['t'];}else{$ToDate = date('Y-m-d');}  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="toDiv" style="display:none">
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</div>

<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['m'],"m","textbox")?>
</div>





</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['y'],"y","textbox")?>
</div></td>
    <td align="right" valign="bottom">  
 <input name="view" type="hidden" value="<?=$_GET['view']?>"  />
 <input name="edit" type="hidden" value="<?=$_GET['edit']?>"  />
 <input name="tab" type="hidden" value="<?=$_GET['tab']?>"  />
 <input name="search" type="submit" class="search_button" value="Go"  />	  
<script>
 ShowDateField();
</script></td></tr>
</table>
</form>
</td> 
</tr>
<? } ?>

<tr>
			 <td align="right">
		<?		 
		echo $CurrencyInfo = str_replace("[Currency]",$Config['Currency'],CURRENCY_INFO);
		?>	 
			 </td>
		</tr>
	<tr>
		 <td valign="top">
		 
             
				 <table width="100%" align="center" cellpadding="3" cellspacing="1" id="list_table">
                 <? if(sizeof($arrySalesHistory)>0){ ?>
					 <tbody>
				<tr align="left"  >
					<td width="10%" class="head1">Period</td>
					<td width="15%" class="head1">Ending</td>
					<td width="10%" class="head1">Sales</td>
					<td width="12%" class="head1">Cost of Sales</td>
					<td width="12%" class="head1">Profit %</td>
					<td width="12%" class="head1">Profit [<?=$Config['Currency']?>]</td>
					<td width="12%" class="head1">Cash Received</td>
					<td class="head1" align="right" >No. Invoices/Credit Memo</td>
				</tr>
               
<?
  	 
	$Line=0;
	$CountRow=0;
	$TotalSalesAmount = 0;
	$TotalCostOfSaleAmount = 0;	
	$TotalProfitPercentage = 0;
	$TotalProfitAmount = 0;
	$TotalCashReceipt = 0;
	$TotalNoInvoices = 0;
	$i=01;
 	
  	foreach($arrySalesHistory as $key=>$values){
		 	 
		$Line++;
		 
		$month = date('n',strtotime($values["InvDate"]));
		$year = date('Y',strtotime($values["InvDate"]));
       		$cashRecived = $objCustomer->getCashReciviedByDate($_GET, $CustID,$year,$month);
              	
		$cashRecived = round($cashRecived,2);


		$SalesAmount = $values['SalesLineAmount'] + $values['SalesAmountGL'];
		$CostOfSale = $values['CostOfSale'] ; //+ $values['CostDropship']
		
		//credit
		$CreditAmount = $values['CreditLineAmount'] + $values['CreditAmountGL'];
		$SalesAmount = $SalesAmount - $CreditAmount;
		$CostOfSale = $CostOfSale - $values['CostOfCredit'];



		$SalesAmount = round($SalesAmount,2);
		$CostOfSale = round($CostOfSale,2);


		$profit = $SalesAmount - $CostOfSale;
		$profit = round($profit,2);
		#$profitPercentage = ($SalesAmount!=0 && $profit>0)?(($profit*100)/$SalesAmount):(0);
		$profitPercentage = (!empty($SalesAmount))?(($profit*100)/$SalesAmount):(0);

		$profitPercentage = round($profitPercentage,2);


		$TotalSalesAmount +=$SalesAmount;
		$TotalCostOfSaleAmount +=$CostOfSale;
		$TotalProfitPercentage +=$profitPercentage;
		$TotalProfitAmount +=$profit;
		$TotalCashReceipt +=$cashRecived;
		$TotalNoInvoices +=$values['TotalInvoiceNo'];
		
		
		if(!empty($values['TotalInvoiceNo']) || !empty($cashRecived)){
	 
		$CountRow++;
  ?>
<tr  >
 
<td>
		<?=$i;?>

 

		</td>
	    <td ><?=date('M',strtotime($values["InvDate"]))?> <?=cal_days_in_month(CAL_GREGORIAN, $month, $year);?></td>
		<td><?=number_format($SalesAmount,2);?> </td>
		<td><?=number_format($CostOfSale,2);?></td>
		<td><?=number_format($profitPercentage,2);?> %</td>
		<td><?=number_format($profit,2);?></td>
        <td><?=number_format($cashRecived,2);?></td>
	    <td align="right" ><?=$values['TotalInvoiceNo'];?></td>

 
</tr>

 <?
	}
	 

$i++;} // foreach end //

	if($CountRow>0){

		$TotalSalesAmount = round($TotalSalesAmount,2);
		$TotalCostOfSaleAmount = round($TotalCostOfSaleAmount,2);		
		$TotalProfitAmount = round($TotalProfitAmount,2);
		$TotalCashReceipt = round($TotalCashReceipt,2);


		$FinalProfitPercentage = $TotalProfitPercentage/$CountRow;
		#$FinalProfitPercentage = ($TotalSalesAmount!=0 && $TotalProfitAmount>0)?(($TotalProfitAmount*100)/$TotalSalesAmount):(0);
?>
     <tr class="oddbg">
		 			 
		<td height="30" align="right" colspan="2"><b>Grand Total (<?=$Config['Currency']?>): </b></td>
			<td> <b id="GrandTotalSalesID"><?=number_format($TotalSalesAmount,2);?></b></td>
			<td> <b><?=number_format($TotalCostOfSaleAmount,2);?></b></td>
			<td> <b><?=number_format($FinalProfitPercentage,2);?> %</b></td>
			<td> <b><?=number_format($TotalProfitAmount,2);?></b></td>
			<td> <b><?=number_format($TotalCashReceipt,2);?></b></td>
			<td align="right" ><b><?=$TotalNoInvoices?></b></td>
		</tr>
  
    <?php 
	}
}

	if($CountRow<=0){
?>
    <tr align="center" >
      <td  class="no_record" colspan="8"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
   </tbody>
	</table>
	</td>
	</tr>
</table>
	

	 
  

<? } ?>
