<? 
if(!empty($SuppCode)){
	 	 
	$_GET['SuppCode'] = $SuppCode;
	/*if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
    	if(empty($_GET['f'])){ $_GET['f'] = date('Y-01-01');}*/

	if(empty($_GET['fby'])){ 
		$_GET['fby'] = 'Month';
		$_GET['m'] = date("m");
		$_GET['y'] = date("Y");
	}

	 
	$arryPurchaseHistory = $objSupplier->ListSupplierPurchase($_GET);
	if(!empty($_GET['pk'])){
		pr($arryPurchaseHistory,1);
	}
 	$NumRec = sizeof($arryPurchaseHistory);

	$NumMonth = 12;
	/*****************/
	if($_GET['fby']=="Year"){
		$arrayMonth = array();
		foreach($arryPurchaseHistory as $key=>$values){
			$arrayMonth[] = $values["MonthDate"];		
		}

	 
		for($i=1;$i<=12;$i++){
			if(!in_array($i,$arrayMonth)){
				$j=$i;
				if($j<10) $j='0'.$i;
				$arryPurchaseHistory[$NumRec]["MonthDate"] = $j;
				$arryPurchaseHistory[$NumRec]["PostedDate"] = $_GET['y'].'-'.$j.'-01';
				$arryPurchaseHistory[$NumRec]["TotalInvoiceNo"] = 0;

				$arryPurchaseHistory[$NumRec]["PurchaseLineAmount"] = 0;
				$arryPurchaseHistory[$NumRec]["PurchaseAmountGL"] = 0;
				$arryPurchaseHistory[$NumRec]["CreditLineAmount"] = 0;
				$arryPurchaseHistory[$NumRec]["CreditAmountGL"] = 0;
				$NumRec++;
			}
		}
		$arryPurchaseHistory = sortMultiArrayByKey($arryPurchaseHistory,"MonthDate");
	}else if($_GET['fby']=="Month" && empty($NumRec)){
		$arryPurchaseHistory[0]["MonthDate"] = $_GET['m'];
		$arryPurchaseHistory[0]["PostedDate"] = $_GET['y'].'-'.$_GET['m'].'-01';
		$arryPurchaseHistory[0]["TotalInvoiceNo"] = 0;
		$arryPurchaseHistory[0]["PurchaseLineAmount"] = 0;
		$arryPurchaseHistory[0]["PurchaseAmountGL"] = 0;
		$arryPurchaseHistory[0]["CreditLineAmount"] = 0;
		$arryPurchaseHistory[0]["CreditAmountGL"] = 0;
		$NumRec++;
		 
	}
	//pr($arryPurchaseHistory,1);
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
                 <? if(sizeof($arryPurchaseHistory)>0){ ?>
					 <tbody>
				<tr align="left"  >
					<td width="10%" class="head1">Period</td>
					<td width="20%" class="head1">Ending</td>
					<td width="20%" class="head1">Purchases</td>
					<td width="20%" class="head1">Payments</td>
					<td class="head1" align="right" >No. Invoices/Credit Memo</td>
				</tr>
               
<?
  	 
	$Line=0;
	$CountRow=0;
	$TotalPurchaseAmount = 0;
	$TotalVendorPayment = 0;
	$TotalNoInvoices = 0;
	$i=01;
 	
  	foreach($arryPurchaseHistory as $key=>$values){
		 	 
		$Line++;
		 
		$month = date('n',strtotime($values["PostedDate"]));
		$year = date('Y',strtotime($values["PostedDate"]));
       		$vendorPayment = $objSupplier->getVendorPaymentByDate($_GET, $SuppCode,$year,$month);
              	
		$vendorPayment = round($vendorPayment,2);


		$PurchaseAmount = $values['PurchaseLineAmount'] + $values['PurchaseAmountGL'];
		
		//credit
		$CreditAmount = $values['CreditLineAmount'] + $values['CreditAmountGL'];
		$PurchaseAmount = $PurchaseAmount - $CreditAmount;
		$PurchaseAmount = round($PurchaseAmount,2);
		$TotalPurchaseAmount +=$PurchaseAmount;
		$TotalVendorPayment +=$vendorPayment;
		$TotalNoInvoices +=$values['TotalInvoiceNo'];
		
		
		if(!empty($values['TotalInvoiceNo']) || !empty($vendorPayment)){
	 
		$CountRow++;
  ?>
<tr  >
 
<td>
		<?=$i;?>

 

		</td>
	    <td ><?=date('M',strtotime($values["PostedDate"]))?> <?=cal_days_in_month(CAL_GREGORIAN, $month, $year);?></td>
		<td><?=number_format($PurchaseAmount,2);?> </td>
        <td><?=number_format($vendorPayment,2);?></td>
	    <td align="right" ><?=$values['TotalInvoiceNo'];?></td>

 
</tr>

 <?
	}
	 

$i++;} // foreach end //

	if($CountRow>0){
	$TotalPurchaseAmount = round($TotalPurchaseAmount,2);
	$TotalVendorPayment = round($TotalVendorPayment,2);
?>
     <tr class="oddbg">
		 			 
		<td height="30" align="right" colspan="2"><b>Grand Total (<?=$Config['Currency']?>): </b></td>
			<td> <b><?=number_format($TotalPurchaseAmount,2);?></b></td>
			<td> <b><?=number_format($TotalVendorPayment,2);?></b></td>
			<td align="right" ><b><?=$TotalNoInvoices?></b></td>
		</tr>
  
    <?php 
	}
}

	if($CountRow<=0){
?>
    <tr align="center" >
      <td  class="no_record" colspan="5"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
   </tbody>
	</table>
	</td>
	</tr>
</table>
	

	 
  

<? } ?>
