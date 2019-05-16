<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	if( ValidateForSelect(frm.f, "From Date") 
		&& ValidateForSelect(frm.t, "To Date") 
	){
			if(frm.f.value>frm.t.value){
				alert("From Date should not be greater than To Date.");
				return false;	
			}
			ShowHideLoader(1,'F');
			return true;	
	}else{
		return false;	
	}
	
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
		  <?=stripslashes($arrySupplier[$i]['CompanyName'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>


        <td valign="bottom">
		  Invoice Paid :<br> 
		  <select name="p" class="textbox" id="p" style="width:70px;">
			 <option value="" <?=($_GET['p']=="")?("selected"):("")?> >--- All ---</option>
			 <option value="1" <?=($_GET['p']=="1")?("selected"):("")?> >Yes</option>
			 <option value="0" <?=($_GET['p']=="0")?("selected"):("")?> >No</option>
		  </select> 
		</td>
		
		  	 

	   <td>&nbsp;</td>



		 <td valign="bottom"><? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
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
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 
	</td> 



	   <td>&nbsp;</td>

		

		 <td valign="bottom"><? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
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
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</td> 


	  <td align="right" valign="bottom"> <input name="sb" type="submit" class="search_button" value="Go"  /></td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_inv_report.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>

	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(!empty($_GET['f']) && !empty($_GET['t'])){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td width="13%"  class="head1" >Invoice Number</td>
		<td width="10%" class="head1" >Invoice Date</td>
		<td width="10%"  class="head1" >PO Number</td>
		<td width="10%" class="head1" >Order Date</td>
		<td class="head1" >Vendor</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="8%" align="center" class="head1" >Currency</td>
		<td width="10%"  align="center" class="head1" >Invoice Paid</td>
    </tr>
   
    <?php 
  if(is_array($arryInvoice) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left">
       <td><a class="fancybox fancybox.iframe" href="vPoInvoice.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["InvoiceID"]?></a></td>
      <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
       <td><a class="fancybox fancybox.iframe" href="vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
      <td> <a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a> </td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


    <td align="center"><? 
		 if($values['InvoicePaid'] ==1){
			  $Paid = 'Yes';  $PaidCls = 'green';
		 }else{
			  $Paid = 'No';  $PaidCls = 'red';
		 }

		echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
		
	 ?></td>
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_INVOICE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryInvoice)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 

<?  if($num>0){
	echo '<div class="bar_chart" >';
	echo '<h2>'.$MainModuleName.'</h2>';
	echo '<img src="barInv.php?f='.$_GET['f'].'&t='.$_GET['t'].'&s='.$_GET['s'].'&p='.$_GET['p'].'" >';
	echo '</div>';
}
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