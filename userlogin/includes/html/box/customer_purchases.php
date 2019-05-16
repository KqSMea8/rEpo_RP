<? 
if($arryCustomer[0]['CustCode']!=''){
	$ViewDetailUrl = "../sales/vSalesQuoteOrder.php?module=".$_GET['module']."&pop=1";

	 
		$InvPrefix = "../admin/finance/";
	 

	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];
	$arrySale=$objSale->ListPaymentReport($_GET);
?>
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




<table width="100%" border="0" cellpadding="5" cellspacing="5">

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

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

	  <td align="right" valign="bottom">  

 <input name="view" type="hidden" value="<?=$_GET['view']?>"  />
 <input name="tab" type="hidden" value="<?=$_GET['tab']?>"  />
 <input name="search" type="submit" class="search_button" value="Go"  />	  
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
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arrySale)>0){ ?>
<tr align="left"  >
	<td width="11%" class="head1" >Payment Date</td>
	<td class="head1" >Payment Method</td>
	<td width="12%" class="head1" >Payment Ref #</td>		
	<td width="10%"  class="head1" >Invoice #</td>
	<td width="11%" class="head1" >Invoice Date</td>
	<td width="10%"  class="head1" >Order #</td>
	<td width="11%" class="head1" >Order Date</td>
	<td width="12%" class="head1" >Sales Person</td>
	<td width="10%" class="head1" >Amount</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
 
<td height="20"> 
	   <? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
		?>
	   
	   </td> 
	    <td><?=stripslashes($values["Method"])?> </td>
	    <td><?=stripslashes($values["ReferenceNo"])?></td>

	   <td>
<? if($_GET['pop']!=1){ 

   
?>
<a class="fancybox fancybig fancybox.iframe" href="<?=$InvPrefix?>vInvoice.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["InvoiceID"]?></a>
<? } else { echo $values["InvoiceID"]; }?>
</td>

      <td>
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>	   
	   </td>
       <td>

<? if($_GET['pop']!=1){ ?>
<a class="fancybox fancybig fancybox.iframe" href="../admin/sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" ><?=$values["SaleID"]?></a>
<? } else { echo $values["SaleID"]; }?>

</td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
      

	<td><a class="fancybox fancybox.iframe" href="../admin/userInfo.php?view=<?=$values['SalesPersonID']?>"><?=stripslashes($values["SalesPerson"])?></a> </td>

       <td><?=$values['DebitAmnt']?> <?=$values['Currency']?></td>


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } ?>

