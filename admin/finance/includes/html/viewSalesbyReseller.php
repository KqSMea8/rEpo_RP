<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	if( ValidateForSelect(frm.s, "Reseller") 
	    && ValidateForSelect(frm.f, "From Date") 
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
<div class="message" align="center"><? if(!empty($_SESSION['mess_sale'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($_GET['pop']!=1){ ?>	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Reseller :<br> <select name="s" class="inputbox" id="s" >
		  <option value="">--- Select ---</option>
		  <? for($i=0;$i<sizeof($arryReseller);$i++) {?>
		  <option value="<?=$arryReseller[$i]['RsID']?>" <?  if($arryReseller[$i]['RsID']==$_GET['s']){echo "selected";}?>>
		  <?=stripslashes($arryReseller[$i]['FullName'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>




		 <td valign="bottom"><? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
<script type="text/javascript">
$(function() {
	$('#f').datepicker(
		{
		showOn: "both",dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
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
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
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
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_rs_report.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>


<? } ?>


	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(!empty($_GET['f']) && !empty($_GET['t'])){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td class="head1" >Payment Date</td>
		<td width="15%" class="head1" >Payment Method</td>
		<td width="10%" class="head1" >Payment Ref #</td>		
		<td width="15%"  class="head1" >Invoice #</td>
		<td width="15%" class="head1" >Invoice Date</td>
		<td width="20%" class="head1" >Customer</td>
		<td width="10%" class="head1" >Amount</td>
		
    </tr>
   
    <?php 
  if(is_array($arryPayment) && $num>0){
  	$flag=true;
	$Line=0; $TotalAmount=0;

  	foreach($arryPayment as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
       <td height="20"> 
	   <? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
		?>
	   
	   </td> 
	    <td><?=stripslashes($values["Method"])?> </td>
	    <td><?=stripslashes($values["ReferenceNo"])?></td>

	   <td>
<? if($_GET['pop']!=1){ ?>
<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["InvoiceID"]?></a>
<? } else { echo $values["InvoiceID"]; }?>
</td>

      <td>
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>	   
	   </td>
      
	   	
      <td> 

<? if($_GET['pop']!=1){ ?>
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> 
<? } else { echo stripslashes($values["CustomerName"]); }?>

</td> 



       <td><?=$values['DebitAmnt']?> <?=$values['Currency']?></td>
     


   
    
    </tr>
    <?php 
		$TotalAmount += $values['PaidAmount'];
    } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  

<?php if($_GET['pop']!=1 && count($arryPayment)>0){?>
 <tr >  <td  colspan="10"  id="td_pager">
Total Record(s) : &nbsp;<?php echo $num;?>      
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; 
<?php echo $pagerLink;?>

</td>
  </tr>
<?}else{ ?>
 <tr >  <td  colspan="10"  id="td_pager" align="right">
	<? if($TotalAmount>0){ ?>Total Amount : &nbsp;<?=$TotalAmount?>&nbsp;&nbsp;&nbsp;<? } ?>


</td>
  </tr>
<?} ?>


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
