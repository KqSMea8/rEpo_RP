<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
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

	 /* if(document.getElementById("s").value == "")
	  {
		alert("Please Select Vendor.");
		document.getElementById("s").focus();
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

<div class="had"><?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Vendor :<br> 
                        <select name="s" id="s" class="inputbox">
                            <option value="">---All---</option>
                            <?php foreach($arryVendorList as $values){?>
                            <option value="<?=$values['SuppCode']?>" <?php if($_GET['s'] == $values['SuppCode']){echo "selected";}?>><?=$values['VendorName']?></option>
                            <?php }?>
                            
                        </select>
		</td>
		
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
		  <? if($_GET['f']>0){ $FromDate = $_GET['f'];}else{$FromDate = date('Y-m-01');}  ?>					
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

<script>
$("#s").select2();
</script> 

	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
              <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_purchase_tax_report.php?<?=$QueryString?>&module=Invoice';" />

	    <? } ?>


		</td>
      </tr>
	 	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		<tr align="left"  >
                <td width="20%" class="head1">Vendor</td>    
		<td width="15%" class="head1">Invoice Date</td>
		<td width="15%"  align="center" class="head1">Order Number</td>
		<td class="head1" align="center" width="20%">Invoice Number</td>
                <td class="head1" align="center" width="10%">Status</td>
		<td class="head1" align="right">Tax Amount (<?=$Config['Currency']?>)</td>
		</tr>

		<?php 
$totalTaxAmnt=0;
		if(is_array($arryTax) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arryTax as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;
                
	       if(!empty($values["VendorName"])){ 
		    $SupplierName = $values["VendorName"];
		}else{
		    $SupplierName = $values["SuppCompany"];
		}

		$ConversionRate=1;		
		if($values['Currency']!=$Config['Currency']){
			$ConversionRate = $values['ConversionRate'];			   
		}
		$taxAmnt = GetConvertedAmount($ConversionRate, $values['taxAmnt']);
		$totalTaxAmnt+=$taxAmnt;

		?>
		<tr align="left"  bgcolor="<?=$bgcolor?>">
               <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><?=stripslashes(ucfirst($SupplierName))?></a>

 
</td>      
		<td height="20">
		<? 
		  $ddate = 'PostedDate';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td align="center"><a href="../purchasing/vPO.php?module=Order&amp;pop=1&amp;po=<?=$values['PurchaseID']?>" class="fancybox po fancybox.iframe"><?=$values['PurchaseID']?></a></td>
		<td align="center"><a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?=$values['OrderID']?>" class="fancybox po fancybox.iframe"><?=$values['InvoiceID']?></a></td> 
                <td align="center">
                        <?php 
		if($values['InvoicePaid'] =='1'){
		$StatusCls = 'green';
                $Status = 'Paid';
		}else{
		 $StatusCls = 'red';
                 $Status = 'Pending';
		}

		echo '<span class="'.$StatusCls.'">'.$Status.'</span>';

		?>
                 </td>
                <td align="right"><?=number_format($taxAmnt,2)?></td>
		</tr>
		<?php } // foreach end //?>
		
		<tr bgcolor="#FFF">
		<td  colspan="6" align="right"><b>Total Tax Amount : <?=number_format($totalTaxAmnt,2);?>&nbsp;<?=$Config['Currency']?></b></td>
		</tr>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="6" class="no_record"><?=NO_RECORD?> </td>
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
		$(".po").fancybox({
			'width'         : 900
		 });

});

</script>
