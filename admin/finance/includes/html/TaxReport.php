<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">
$(function() {
	$( "#rtype" ).selectmenu({
	  change: function( event, ui ) {
             console.log(ui);
               var vals = ui.item.value;		
           	window.location = 'TaxReport.php?rtype='+vals;
		ShowHideLoader('1','F');
         }

     });
      
});


 
function ShowReportBy(){
	 if(document.getElementById("rtype2").value=='P'){
		 if(document.getElementById("rby").value=='L'){
			document.getElementById("taxDiv").style.display = 'block';
			document.getElementById("vendorDiv").style.display = 'none';		
		 }else{
			document.getElementById("taxDiv").style.display = 'none';
			document.getElementById("vendorDiv").style.display = 'block';		 	
		 }
	 }else{
		 if(document.getElementById("rby").value=='L'){
			document.getElementById("taxDiv").style.display = 'block';
			document.getElementById("customerDiv").style.display = 'none';		
		 }else{
			document.getElementById("taxDiv").style.display = 'none';
			document.getElementById("customerDiv").style.display = 'block';		 	
		 }
	 }	

	
	
}

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

	  /*if(document.getElementById("c").value == "")
	  {
		alert("Please Select Customer.");
		document.getElementById("c").focus();
		return false;
	  }*/

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


function SetGrossHtml(){
	if(document.getElementById("GrandTotalSalesID") != null){
		var GrandTotalSales = document.getElementById("GrandTotalSalesID").innerHTML;
		
		GrandTotalSales = GrandTotalSales.replace(",", "");
		GrandTotalSales = GrandTotalSales.replace(",", "");
  
		var GrandTaxableSales = document.getElementById("GrandTaxableSalesID").innerHTML;
		GrandTaxableSales = GrandTaxableSales.replace(",", "");
		GrandTaxableSales = GrandTaxableSales.replace(",", "");	
 
		var ExemptSalesID = parseFloat(GrandTotalSales) - parseFloat(GrandTaxableSales);
		ExemptSalesID = number_format(ExemptSalesID,2);


	 	document.getElementById("GrossSalesID").innerHTML = document.getElementById("GrandTotalSalesID").innerHTML;
		document.getElementById("ExemptSalesID").innerHTML = ExemptSalesID;
		document.getElementById("TaxableSalesID").innerHTML = GrandTaxableSales;
		 
	}else{
		document.getElementById("GrossSalesID").innerHTML = '0.00';
		document.getElementById("ExemptSalesID").innerHTML = '0.00';
		document.getElementById("TaxableSalesID").innerHTML = '0.00';
	}
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td valign="top" height="60">
		  <select name="rtype" class="inputbox" id="rtype" style="width:170px;">
			 <option value="S" <?  if($_GET['rtype']=='S'){echo "selected";}?>>Sales Tax Report</option>
			 <option value="P" <?  if($_GET['rtype']=='P'){echo "selected";}?>>Purchase Tax Report</option>
			 
		</select> 
	  </td>
</tr>



<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

<td valign="bottom" style="display:none1">
		  Report By :<br> 
		  <select name="rby" class="textbox" id="rby" style="width:100px;" onChange="Javascript:ShowReportBy();">
			 <? if($_GET['rtype']=='P'){  ?>
			  <option value="V" <?  if($_GET['rby']=='V'){echo "selected";}?>>Vendor</option>
			 <? }else{?>
			 <option value="C" <?  if($_GET['rby']=='C'){echo "selected";}?>>Customer</option>
			 <? }?>
			 <option value="L" <?  if($_GET['rby']=='L'){echo "selected";}?>>Tax Rate</option>
			 
		</select> 
		</td>
	   <td>&nbsp;</td>

<td valign="bottom">

<div id="customerDiv" <?  if($_GET['rby']!='C'){echo 'style="display:none"';}?>>
Customer :<br> 
		<select id="CustCode" class="inputbox" name="CustCode">
			   <option value="">---All Customers---</option>
			     <?php
			if(!empty($arryCustomer)){
			 foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_GET['CustCode'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['CustomerName']; ?></option>
				<?php }}?>
			</select>
</div>


<div id="vendorDiv" <?  if($_GET['rby']!='V'){echo 'style="display:none"';}?>>
Vendor :<br> 
		 <select name="SuppCode" id="SuppCode" class="inputbox">
                            <option value="">---All Vendors---</option>
                            <?php
		if(!empty($arryVendorList)){
		 foreach($arryVendorList as $values){?>
                            <option value="<?=$values['SuppCode']?>" <?php if($_GET['SuppCode'] == $values['SuppCode']){echo "selected";}?>>  <?=stripslashes($values['VendorName'])?></option>
                            <?php }}?>
                            
                        </select>
</div>



<div id="taxDiv"  <?  if($_GET['rby']!='L'){echo 'style="display:none"';}?>>
Tax Rate :<br> 
		<select id="Tax" class="inputbox" name="Tax">
			   <option value="">---All Taxes---</option>
			     <?php foreach($arryTax as $tax){
 
?>
				 <option value="<?=$tax?>" <?php if($_GET['Tax'] == $tax){echo "selected";}?>><?php echo $tax; ?></option>
				<?php }?>
			</select>
</div>


</td>

<script>
$("#CustCode").select2();
$("#SuppCode").select2();
$("#Tax").select2();
</script> 
		

 <td>&nbsp;</td>
		<td valign="bottom">
		Status :<br> <select name="st" class="textbox" id="st" style="width:100px;">
		<option value="">--- All ---</option>
		<option value="1" <?  if($_GET['st'] == "1"){echo "selected";}?>>Paid</option>
		<option value="2" <?  if($_GET['st'] == "2"){echo "selected";}?>>Pending</option>
		</select> 
		</td>
	   <td>&nbsp;</td>

<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
					 <option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
					 <option value="Month" <?  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>
		</select> 
		</td>
	   <td>&nbsp;</td>


		 <td valign="bottom">
                			
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
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$_GET['f']?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	 

		 <td valign="bottom">

                			
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
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$_GET['t']?>"  type="text" placeholder="To Date">
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



 <input name="search" type="submit" class="search_button" value="Go"  />

	  <input id="rtype2" name="rtype" readonly="" value="<?=$_GET['rtype']?>"  type="hidden"> 


	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	

<tr>
	<td align="right" valign="top">
		<? if($num>0){?>
		<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_tax_report.php?<?=$QueryString?>&module=Invoice';" />
		<? } ?>
	</td>
</tr>

<tr>
			 <td align="right">
		<?		 
		echo $CurrencyInfo = str_replace("[Currency]",$Config['Currency'],CURRENCY_INFO);
		?>	 
			 </td>
		</tr>

	 	 	  
<tr>
	<td>

	<table id="myTable" class="order-list" cellspacing="1" cellpadding="0" width="100%">
	<tr >
		<td class="heading">Gross <?=$Module?> </td>
		<td class="heading">Exempt <?=$Module?> </td>
		<td class="heading">Taxable <?=$Module?> </td>
		<td class="heading">Taxable Amount  </td>
		<td class="heading">Tax Collected </td>
	</tr>
	<tr class="itembg">
		<td id="GrossSalesID"><? //number_format($GrossSale,2); ?></td>
		<td id="ExemptSalesID"><? //number_format($ExemptSale,2)?></td>
		<td id="TaxableSalesID"><? //number_format($TaxableSales,2); ?></td>
		<td><?=number_format($TaxabaleAmount,2)?></td>
		<td><?=number_format($TaxCol,2)?></td>
	</tr>
	</table>


	</td>
</tr>

	  
	
	<tr>
	  <td  valign="top"> 
    <? include_once("includes/html/box/tax_report_data.php"); ?>
	  
	</td>
	</tr>

</table>
<script language="JavaScript1.2" type="text/javascript">
SetGrossHtml();
</script>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>


