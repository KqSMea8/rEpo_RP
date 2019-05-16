<? 
if($arryCustomer[0]['CustCode']!=''){
	$_GET['module']='Invoice'; $module = $_GET['module'];
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	$ViewDetailUrl = "../finance/vInvoice.php?pop=1";

	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];		
	$arrySale=$objSale->ListSale($_GET);
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
 <input name="edit" type="hidden" value="<?=$_GET['edit']?>"  />
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
	<td width="15%" class="head1" ><?=$module?> Date</td>
	<td width="15%"  class="head1" ><?=$module?> Number</td>
	<td width="12%" class="head1" >SO Number</td>
	<td class="head1">Sales Person</td>
	<td width="15%" align="center" class="head1" >Amount</td>
	<td width="10%" align="center" class="head1" >Currency</td>
	<td width="12%"  align="center" class="head1" >Status</td>
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
		<? 
		  $ddate = $module.'Date';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td >
<a class="fancybox fancybig fancybox.iframe" href="<?=$ViewDetailUrl.'&view='.$values['OrderID']?>" ><?=$values[$ModuleID]?></a>

</td>
<td>		 
<a href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" class="fancybox fancybig fancybox.iframe"><?=$values['SaleID']?></a>
</td>


<td><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['SalesPersonID']?>"><?=stripslashes($values["SalesPerson"])?></a> </td>
		<td align="center"><?=$values['TotalAmount']?></td>
		<td align="center"><?=$values['CustomerCurrency']?></td>
		
		<td align="center">
	  <? 
		 if($values['InvoicePaid'] =='Unpaid'){
			echo '<span class="red">'.$values['InvoicePaid'].'</span>';
		 }else{
			if($values['InvoicePaid'] == 'Paid'){
			  	$StatusCls = 'green';
			}else{
				$StatusCls = 'red';
			}
			echo '<a  class="fancybox fancybig fancybox.iframe" href="receiveInvoiceHistory.php?edit='.$values['OrderID'].'&InvoiceID='.$values['InvoiceID'].'&IE='.$values['InvoiceEntry'].'&pop=1" ><span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</a>';
		 }
	
		
	 ?>
 



	</td>


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_INVOICE?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } 



include("../includes/html/box/customer_credit_memo.php");
?>
