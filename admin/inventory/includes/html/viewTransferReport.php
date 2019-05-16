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
		/*if(!ValidateForSelect(frm.w1, "From Warehouse")){
			return false;	
		}
		if(!ValidateForSelect(frm.w2, "To Warehouse")){
			return false;	
		}*/
		if(frm.w1.value!='' && frm.w1.value==frm.w2.value){
			alert("From warehouse and To warehouse should not be same.");
			return false;	
		}
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
		From Warehouse :<br> <select style="width: 120px;" name="w1" class="inputbox" id="w1" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arryWarehouse);$i++) {?>
		  <option value="<?=$arryWarehouse[$i]['WID']?>" <?  if($arryWarehouse[$i]['WID']==$_GET['w1']){echo "selected";}?>>
		  <?=stripslashes($arryWarehouse[$i]['warehouse_name'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>
<td valign="bottom">
		To Warehouse :<br> <select style="width: 120px;" name="w2" class="inputbox" id="w2" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arryWarehouse);$i++) {?>
		  <option value="<?=$arryWarehouse[$i]['WID']?>" <?  if($arryWarehouse[$i]['WID']==$_GET['w2']){echo "selected";}?>>
		  <?=stripslashes($arryWarehouse[$i]['warehouse_name'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
<td>&nbsp;</td>
        <td valign="bottom">
	
		   Status :<br> <select name="ast" class="textbox" id="ast" style="width:90px;">
					<option value="" <?  if(empty($_GET['ast'])){echo "selected";}?>>--- All ---</option>
					<option value="1" <?  if($_GET['ast']=='1'){echo "selected";}?>>Parked</option>
					<option value="2" <?  if($_GET['ast']=='2'){echo "selected";}?>>Completed</option>
					<option value="0" <?  if($_GET['ast']=='0'){echo "selected";}?>>Canceled</option>
		</select> 
		</td>
	   <td>&nbsp;</td>

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:90px;" onChange="Javascript:ShowDateField();">
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
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_transfer_report.php?<?=$QueryString?>';"/>
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
       <td width="13%"  class="head1" >Transfer Number</td>
      <td width="13%" class="head1" >Transfer Date</td>
        <td width="15%" class="head1" >Transfer Reason</td>
     <td class="head1" >From Warehouse</td>
	 <td class="head1" >To Warehouse</td>
	 <td width="10%" align="center" class="head1" >Total Quantity</td>
      <td width="10%" align="center" class="head1" >Total Amount</td>
     
     <td width="8%"  align="center" class="head1" >Status</td>
       
    </tr>
   
    <?php 

	
  if(is_array($arryTransfer) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTransfer as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       <td><a class="fancybox fancybox.iframe" href="vTransfer.php?pop=1&view=<?=$values['transferID']?>" ><?=$values["transferNo"]?></a></td>
	   <td height="20">
	   <? if($values['transferDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['transferDate']));
		?>
	   
	   </td>
      <td><?=$values['transfer_reason']?></td>
      <td><a class="fancybox fancybox.iframe" href="../warehouse/vWarehouse.php?view=<?=$values['from_WID']?>&pop=1" ><?=stripslashes($values['from_warehouse_name'])?> [<?=stripslashes($values["from_warehouse"])?>]</a></td> 
	  <td><a class="fancybox fancybox.iframe" href="../warehouse/vWarehouse.php?view=<?=$values['to_WID']?>&pop=1" ><?=stripslashes($values['to_warehouse_name'])?> [<?=stripslashes($values["to_warehouse"])?>]</a></td> 
	   <td align="center"><?=$values['total_transfer_qty']?></td>
       <td align="center"><?=$values['total_transfer_value']?> <?=$Config['Currency']?></td>
    
     <td align="center">
	<?  $OrderIsOpen = 0;
		 if($values['Status'] == 1 ){
			 $StatusCls = 'green';
			 $Status = "Parked";
		 }else if($values['Status'] == 2){
			 $StatusCls = 'green';
			 $Status = "Completed";
		 }else{
			 $StatusCls = 'red';
			 $Status = "Cancel";
		 }

		echo '<span class="'.$StatusCls.'">'.$Status.'</span>';
		
	 ?>
	 
	</td>


   
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_TRANSFER?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTransfer)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 

<?  //if($num>0){
	//echo '<div style="text-align:center;padding-top:30px;" >';
	//echo '<img src="barPO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&s='.$_GET['s'].'&st='.$_GET['st'].'" >';
	//echo '</div>';
//}
?>

  
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
