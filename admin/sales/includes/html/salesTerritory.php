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

	  if(document.getElementById("TerritoryID").value == "")
	  {
		alert("Please Select Territory.");
		document.getElementById("TerritoryID").focus();
		return false;
	  }

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

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Territory :<br>
               
                <select name="TerritoryID" id="TerritoryID" class="inputbox">
                                                <option value="">Select Territory</option>
                                                  <?php $objTerritory->getTerritoryOption(0,0,$_GET['TerritoryID']);?>
                                                </select> 
		</td>
		
	   <td>&nbsp;</td>
		<td valign="bottom">
		Order Status :<br> <select name="st" class="textbox" id="st" style="width:100px;">
		<option value="">--- All ---</option>
		<option value="Open" <?  if($_GET['st'] == "Open"){echo "selected";}?>>Open</option>
		<option value="Completed" <?  if($_GET['st'] == "Completed"){echo "selected";}?>>Completed</option>
		<option value="Cancelled" <?  if($_GET['st'] == "Cancelled"){echo "selected";}?>>Cancelled</option>
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
		 <? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
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

		 <? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
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
		
	 <? if($num>0 && !empty($arryCustomer)){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
          <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_sales_territory_report.php?<?=$QueryString?>&module=Order';" />

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
		<td width="10%" class="head1">Order Date</td>
		<td width="10%"  align="center" class="head1" >Order Number</td>
		<td class="head1" width="15%">Customer Name</td>
                <td class="head1" width="15%">Sales Person</td>
		<td width="8%" align="center" class="head1">Currency</td>
		<td width="8%"  align="center" class="head1">Status</td>
		<td class="head1">Freight Amount</td>
		<td class="head1">Tax Amount</td>
		<td class="head1">Discount Amount</td>
		<td align="right" class="head1">Total Amount</td>
		
		</tr>

		<?php 
		if(!empty($arryCustomer) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arrySale as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;

		?>
		<tr align="left"  bgcolor="<?=$bgcolor?>">
		<td height="20">
		<? 
		  $ddate = 'OrderDate';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td align="center"><a href="vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?=$values['SaleID']?>" class="fancybox po fancybox.iframe"><?=$values['SaleID']?></a></td>
		<td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>" ><?=stripslashes($values["CustomerName"])?></a></td> 
                <td><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['SalesPersonID']?>" ><?=stripslashes($values["SalesPerson"])?></a></td> 
		<td align="center"><?=$values['CustomerCurrency']?></td>
		<td align="center">
		<?php 
		if($values['Status'] =='Open'){
		$StatusCls = 'green';
		}else{
		$StatusCls = 'red';
		}

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';

		?>

		</td>
		<td align="center"><?=$values['Freight']?></td>
		<td align="center"><?=$values['taxAmnt']?></td>
		<td align="center"><?=$values['discountAmnt']?></td>
		<td align="right"><?=$values['TotalAmount']?></td>
		</tr>
		<?php } // foreach end //?>
		
		<!--<tr align="right" bgcolor="#FFF">
		<td  colspan="9"><b>Total Sales Amount In <?=$values['CustomerCurrency']?> - <?=$totalOrderAmnt;?> </b></td>
		</tr>-->

		<?php }else{?>
		<tr align="center" >
		<td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="10"  id="td_pager"></td>
		</tr>
		</table>
		</div> 
		<?  if($num>0){
		/*echo '<div class="bar_chart">';
		echo '<h2>'.$MainModuleName.'</h2>';
		echo '<img src="barSO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&m='.$_GET['m'].'&y='.$_GET['y'].'&c='.$_GET['c'].'&st='.$_GET['st'].'" >';
		echo '</div>';*/
		}
		?>
		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		</form>
</td>
</tr>

</table>

