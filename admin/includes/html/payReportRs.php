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
<div class="had"><?=$MainModuleName?> [ <?=$arryReseller[0]['FullName']?> ]</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_sale'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    
      
      <? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_comm_det_report.php?<?=$QueryString?>';" -->
		</td>
      </tr>
	 <? } ?>

	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(!empty($_GET['sb'])){ ?>
<table <?=$table_bg?>>
   
<tr align="left"  >
	<td class="head1">Payment Date</td>
	<td width="20%" class="head1">Customer</td>	
	<td width="17%" class="head1">Invoice #</td>				
	<td width="17%" class="head1">Invoice Total [<?=$Config['Currency']?>]</td>	
	<td width="17%" class="head1" align="right">Sales Amount [<?=$Config['Currency']?>]</td>
	<?if($arryReseller[0]['CommOn']==1){?>
	<td width="17%" class="head1" align="right">Commission [<?=$Config['Currency']?>]</td>
	<?}?>
</tr>
   
    <?php 
  if(is_array($arryPayment) && $num>0){
  	$flag=true;
	$Line=0; $TotalAmount=0;
	$EmpDivision = 5;
  	foreach($arryPayment as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left">
	<td height="20"> 
		<? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
		?>
	</td> 

	<td> 
	<? if($_GET['pop']!=1){ ?>
	<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> 
	<? } else { echo stripslashes($values["CustomerName"]); }?>
	</td> 

	          
	<td>
		<? if($_GET['pop']!=1){ ?>
		<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["InvoiceID"]?></a>
		<? } else { echo $values["InvoiceID"]; }?>
	</td>
    
	<td><?=$values['TotalAmount']?></td>
	<td align="right"><?=$values['DebitAmnt']?></td>    
	<?if($arryReseller[0]['CommOn']==1){
		$PaymentID = $values["PaymentID"];
		include("../includes/html/box/commission_rscal_per.php");
		$TotalCommissionSum += $TotalCommission;
	?>
	<td align="right"><?=number_format($TotalCommission,2,'.',',')?></td>
	<?}?>
</tr>
    <?php 
		$TotalAmount += $values['DebitAmnt'];
		
    } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  

<?php if($TotalAmount>0){ 
	
	if($arryReseller[0]['CommOn']!=1){
		include("../includes/html/box/commission_rscal.php");
	}else{
		$TotalCommission = $TotalCommissionSum;
	}
?>
	<tr id="td_pager">  
		<td colspan="10" align="right">Total Sales Amount : <strong><?=number_format($TotalAmount,2,'.',',')?></strong></td>
		
	</tr>
	<tr id="td_pager">  
		<td colspan="10" align="right">Sales Commission : <strong><?=number_format($TotalCommission,2,'.',',')?></strong></td>
		
	</tr>
<? } ?>


  </table>
<? } ?>

</div> 
 

  
</form>
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
