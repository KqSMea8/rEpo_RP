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
</script>

<div class="had"><?=$MainModuleName?> Report</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		
		<!--td valign="bottom">
		Status :<br> <select name="st" class="textbox" id="st" style="width:100px;">
		<option value="">--- All ---</option>
		<option value="Paid" <?  if($_GET['st'] == "Paid"){echo "selected";}?>>Paid</option>
		<option value="Unpaid" <?  if($_GET['st'] == "Unpaid"){echo "selected";}?>>Pending</option>
		</select> 
		</td-->
	  

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
                 <? if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-1');}  ?>				
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

	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
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
              <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_invoice_margin_report.php?<?=$QueryString?>&module=Invoice';" />

	    <? } ?>


		</td>
      </tr>
	 	
	<tr>
	  <td  valign="top"> 
   	 <? //include_once("includes/html/box/margin_report_data.php"); ?>
	  
	</td>
	</tr>


  
	<tr>
	  <td  valign="top">
	

		 
		
		

		<table <?=$table_bg?>>
		<tr align="left"  >
      <td class="head1" align="center" >Invoice Date</td>         
		<td class="head1" width="15%" align="center" >Invoice Number</td>
<td class="head1" width="10%" align="center" >Purchase Number</td>
                  <td class="head1" align="right" width="15%">Sale Price [<?=$Config['Currency']?>]</td>    
		<td width="15%" class="head1" align="right">Cost of Good [<?=$Config['Currency']?>]</td>
		<td width="15%"  align="right" class="head1">Fees [<?=$Config['Currency']?>]</td>
		<td class="head1" width="20%"  align="right">Margin [<?=$Config['Currency']?>]</td>
		</tr>

		<?php 
		if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		$SubTotalSum=0;
		$AvgCostSum=0;
		$FeeSum=0;
		$MarginSum=0;
		foreach($arrySale as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;
		//$arryShippInfo = $objCommon->GetShippInfoByTrackingId($values['TrackingNo']);	
		//$ShipFreight = $arryShippInfo[0]['totalFreight'];

		/**********************/
		$ConversionRate=1;
		if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
			$ConversionRate = $values['ConversionRate'];			   
		}		

		$SubTotal=$values['SubTotal'];
		$OrginalSubTotal = GetConvertedAmount($ConversionRate, $SubTotal);
		$SubTotalSum += $OrginalSubTotal; 


		$TotalAvgCost = $objSale->GetTotalAverageCost($values['OrderID']);
		$OrginalAvgCost = GetConvertedAmount($ConversionRate, $TotalAvgCost);
		$AvgCostSum += $OrginalAvgCost;  

		$Freight = $values['Freight'];
		$OrginalFreight = GetConvertedAmount($ConversionRate, $Freight); 

		$Fee = $values['Fee'];
		$OrginalFee = GetConvertedAmount($ConversionRate, $Fee); 
		$FeeSum += $OrginalFee;  


		$Margin = ($OrginalSubTotal+$OrginalFreight) - $OrginalAvgCost - $OrginalFee; 	
		$MarginSum += $Margin;  
		/**********************/
		?>
		<tr align="left"  bgcolor="<?=$bgcolor?>">
<td align="center"><?php echo date($Config['DateFormat'], strtotime($values['InvoiceDate'])); ?></td>
<td align="center"><a href="vInvoice.php?pop=1&amp;view=<?=$values['OrderID']?>" class="fancybox po fancybox.iframe"><?=$values['InvoiceID']?></a></td>

<td align="center"><a href="../purchasing/vPO.php?module=Order&pop=1&amp;view=<?=$values['PID']?>" class="fancybox po fancybox.iframe"><?=$values['PurchaseID']?></a>

</td>

<td align="right"><?=number_format($OrginalSubTotal,2)?></td>
<td align="right"><?=number_format($OrginalAvgCost,2)?></td>
<td align="right"><?=number_format($OrginalFee,2)?></td>
<td align="right"><?=number_format($Margin,2)?></td>		 
		 
               
                
		</tr>
		<?php } // foreach end //?>
		
		<tr bgcolor="#FFF">
<td   align="right"></td>
<td   align="right"></td>
<td   align="center"><h5>Total  : </h5></td>
<td   align="right"><h5> <?=number_format($SubTotalSum,2)?> <?=$Config['Currency']?></h5></td>
<td   align="right"><h5>  <?=number_format($AvgCostSum,2)?> <?=$Config['Currency']?></h5></td>
<td   align="right"><h5>  <?=number_format($FeeSum,2)?> <?=$Config['Currency']?></h5></td>
		<td   align="right"><h5> <?=number_format($MarginSum,2)?> <?=$Config['Currency']?></h5></td>
		</tr>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="7" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		
		</table>
		
		 
		
</td>
</tr>

</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>
