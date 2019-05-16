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
   /* if(!ValidateForSelect(frm.w, "Warehouse")){
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
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Warehouse :<br> <select name="w" class="inputbox" id="w" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arryWarehouse);$i++) {?>
		  <option value="<?=$arryWarehouse[$i]['warehouse_code']?>" <?  if($arryWarehouse[$i]['warehouse_code']==$_GET['w']){echo "selected";}?>>
		  <?=stripslashes($arryWarehouse[$i]['warehouse_name'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>


        <td valign="bottom">
	
		  Adjustment Status :<br> <select name="ast" class="textbox" id="ast" style="width:100px;">
					<option value="" <?  if(empty($_GET['ast'])){echo "selected";}?>>--- All ---</option>
					<option value="1" <?  if($_GET['ast']=='1'){echo "selected";}?>>Parked</option>
					<option value="2" <?  if($_GET['ast']=='2'){echo "selected";}?>>Completed</option>
					<option value="0" <?  if($_GET['ast']=='0'){echo "selected";}?>>Canceled</option>
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
<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['m'],"m","textbox")?>
</div>





</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['y'],"y","textbox")?>
</div></td>







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
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_adj_report.php?<?=$QueryString?>';" />
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
       <td width="14%"  class="head1" >Adjustment Number</td>
      <td width="15%" class="head1" >Adjustment Date Date</td>
        <td  class="head1" >Adjustment Reason</td>
		<td class="head1" width="10%" >Total Quantity</td>
     <td class="head1" width="8%" >Warehouse</td>
      <td  align="center" class="head1" >Total Amount [<?=$Config['Currency']?>]</td>
   
     <td width="8%"  align="center" class="head1" >Status</td>
       
    </tr>
   
    <?php 

	
  if(is_array($arryAdjustment) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryAdjustment as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       <td><a class="fancybox fancybox.iframe" href="vAdjustment.php?pop=1&view=<?=$values['adjID']?>" ><?=$values["adjustNo"]?></a></td>
	   <td height="20">
	   <? if($values['adjDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['adjDate']));
		?>
	   
	   </td>
      <td><?=$values['adjust_reason']?></td>
	  <td ><?=$values['total_adjust_qty']?></td>
      <td><a class="fancybox fancybox.iframe" href="../warehouse/vWarehouse.php?view=<?=$values['WID']?>&pop=1" ><?=stripslashes($values["warehouse_code"])?></a></td> 
       <td align="center"><?=$values['total_adjust_value']?>  </td>
    
     <td align="center">
	<?  $OrderIsOpen = 0;
		 if($values['Status'] == 1 ){
			 $StatusCls = 'green';
			 $status="Parked";
		 }else if($values['Status'] == 2){
			 $StatusCls = 'green';
			 $status="Completed";
		 }else{
			 $StatusCls = 'red';
			 $status="Cancel";
		 }

		echo '<span class="'.$StatusCls.'">'.$status.'</span>';
		
	 ?>
	 
	</td>


  
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_ADJ?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAdjustment)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 

<?  if($num>0){
	/*echo '<div class="bar_chart" >';
	echo '<h2>'.$MainModuleName.'</h2>';
	echo '<img src="barAdj.php?f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&w='.$_GET['w'].'&ast='.$_GET['ast'].'" >';
	echo '</div>';*/
?>
<div class="report_chart" >
	<h2><?=$MainModuleName?></h2>
	
	<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
	<option value="bChart:pChart">Bar Chart</option>
	<option value="pChart:bChart">Pie Chart</option>
	</select>	
	<div class="cb3"></div>
	<? echo '<img  id="bChart" src="barAdj.php?f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&w='.$_GET['w'].'&ast='.$_GET['ast'].'">'; 
	echo '<img  id="pChart" style="display:none" src="pieAdj.php?f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&w='.$_GET['w'].'&ast='.$_GET['ast'].'">'; ?>


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
<? echo '<script>SetInnerWidth();</script>'; ?>
