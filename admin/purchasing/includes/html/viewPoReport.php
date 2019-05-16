<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
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
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Vendor :<br> <select name="s" class="inputbox" id="s" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arrySupplier);$i++) {?>
		  <option value="<?=$arrySupplier[$i]['SuppCode']?>" <?  if($arrySupplier[$i]['SuppCode']==$_GET['s']){echo "selected";}?>>
		  <?=stripslashes($arrySupplier[$i]['VendorName'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>


        <td valign="bottom">
		  Order Status :<br> 
		  <select name="st" class="textbox" id="st" style="width:100px;">
			 <option value="">--- All ---</option>
				<option value="Completed" <? if($_GET['st']=='Completed'){echo "selected";}?>>Completed</option>
				<option value="Cancelled" <? if($_GET['st']=='Cancelled'){echo "selected";}?>>Cancelled</option>
				<option value="Rejected" <? if($_GET['st']=='Rejected'){echo "selected";}?>>Rejected</option>

				<? for($i=0;$i<sizeof($arryOrderStatus);$i++) {?>
					<option value="<?=$arryOrderStatus[$i]['attribute_value']?>" <?  if($arryOrderStatus[$i]['attribute_value']==$_GET['st']){echo "selected";}?>>
					<?=$arryOrderStatus[$i]['attribute_value']?>
			</option>
				<? } ?>

		</select> 
		</td>
	   <td>&nbsp;</td>

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
					 <option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
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

	   <td>&nbsp;</td>

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

<div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['y'],"y","textbox")?>
</div>

</td> 


	  <td align="right" valign="bottom"> <input name="sb" type="submit" class="search_button" value="Go"  />
	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_po_report.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>

	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if($ShowData == 1){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
       <td width="13%"  class="head1" >PO Number</td>
      <td width="15%" class="head1" >Order Date</td>
        <td width="10%" class="head1" >Order Type</td>
     <td class="head1" >Vendor</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
     <td width="8%"  align="center" class="head1" >Status</td>
       <td width="8%"  align="center" class="head1" >Approved</td>
    </tr>
   
    <?php 
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
       <td><a class="fancybox fancybox.iframe" href="vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   <td height="20">
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>
	   
	   </td>
      <td><?=$values['OrderType']?></td>
      <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><?=stripslashes($values["VendorName"])?></a></td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>
     <td align="center">
	<?  $OrderIsOpen = 0;
		 if($values['Status'] == 'Cancelled' || $values['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($values['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
			 $OrderIsOpen = 1;
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?>
	 
	</td>


    <td align="center"><? 
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_PO?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 

<?  if($num>0){
	/*echo '<div class="report_chart" >';
	echo '<h2>'.$MainModuleName.'</h2>';
	echo '<img src="barPO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&s='.$_GET['s'].'&st='.$_GET['st'].'" >';
	echo '</div>';*/
?>
	
<div class="report_chart" >
	<h2><?=$MainModuleName?></h2>
	
	<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
	<option value="bChart:pChart">Bar Chart</option>
	<option value="pChart:bChart">Pie Chart</option>
	</select>	
	<div class="cb3"></div>
	<? echo '<img  id="bChart" src="barPO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&s='.$_GET['s'].'&st='.$_GET['st'].'">'; 
	echo '<img  id="pChart" style="display:none" src="piePO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&s='.$_GET['s'].'&st='.$_GET['st'].'">'; ?>


</div>


<? } ?>

  
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>
