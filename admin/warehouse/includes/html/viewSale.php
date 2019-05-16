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
	

	  if(document.getElementById("so").value == "")
	  {
		alert("Please Enter Order Number.");
		document.getElementById("so").focus();
		return false;
	  }else{

	ShowHideLoader(1,'F');
	return true;	

	  }

	
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
		Order Number :<span class="red">*</span><br> <input type="text" name="so"  id="so" value="<?=$_GET['so']?>" class="textbox" size="10"  />
			  
		</td>

		<td>&nbsp;</td>
		<td valign="bottom">

		Invoice Number :<br> <input type="text" name="InvoiceID" value="<?=$_GET['InvoiceID']?>" id="InvoiceID" class="textbox" size="10"  />
			  
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
		
	 <? if($num>0 && !empty($_REQUEST['c'])){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
          <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_so_report.php?<?=$QueryString?>&module=Order';" />

	    <? } ?>


		</td>
      </tr>
	 
<?php if(!empty($_REQUEST['so']) || !empty($_REQUEST['key']) ){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arrySale)?>');" /></td>-->
		<td width="13%" class="head1" >Invoice Date</td>
		<td width="12%"  class="head1" ><?=$ModuleIDTitle?></td>
		<td width="12%"  align="center" class="head1" >SO Number</td>
		<td class="head1">Customer Name</td>
		<td class="head1">Sales Person</td>
		<td width="8%" align="center" class="head1">Amount</td>
		<!--<td width="8%" align="center" class="head1">Total Amount</td>-->
		<td width="8%" align="center" class="head1">Currency</td>
		<td width="8%"  align="center" class="head1">Status</td>
		<td width="8%"  align="center" class="head1">Download</td>
		<td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>

		<?php 

		
		if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arrySale as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;

		?>
		 <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>
	   
	   </td>
      <td align="center"><?=$values[$ModuleID]?></td>
	  <td align="center"><a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?=$values['SaleID']?>" class="fancybox po fancybox.iframe"><?=$values['SaleID']?></a></td>
      <td><a class="fancybox fancybox.iframe" href="../sales/custInfo.php?view=<?=$values['CustCode']?>" ><?=stripslashes($values["CustomerName"])?></a></td> 
	  <td><?=stripslashes($values['SalesPerson'])?></td>
      <td align="center"><?=$values['TotalInvoiceAmount']?></td>
	  <!--<td align="center"><//?=$values['TotalAmount']?></td>-->
      <td align="center"><?=$values['CustomerCurrency']?></td>
      <td align="center">
	 <? 
		 if($values['InvoicePaid'] =='Paid'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</span>';
		
	 ?>
	 
	</td>


    <td align="center" class="head1_inner" ><a target="_blank" href="../sales/pdfInvoice.php?IN=<?=$values['OrderID'];?>&amp;module=Invoice"><?=$download?></a></td>
    <td  align="center" class="head1_inner">

<!--a href="<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a-->
<!--a href="<?=$EditUrl.'&edit='.$values['OrderID']?>" ><?=$edit?></a-->

<?
//if($module=="Invoice"){ 

//$TotalGenerateInvoice=$objSale->GetQtyInvoiced($values['OrderID']);


	/*$TotalInvoice=$objSale->CountInvoices($values['SaleID']);
	if($TotalInvoice>0)
		echo '<br><a href="viewInvoice.php?so='.$values['SaleID'].'" target="_blank">Invoices</a>';*/
	if($values['Approved'] ==1 )
		echo '<br><a href="ShipInvoice.php?so='.$values['SaleID'].'&shipid='.$values['InvoiceID'].'" target="_blank">'.CREATE_SHIPPING.'</a>';
//}
?>

	</td>
    </tr>
		<?php } // foreach end //?>
		
		

		<?php }else{?>
		<tr align="center" >
		<td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>
		</table>
		</div> 
		
		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
		</form>
</td>
</tr>
<?php } else {?>
<!--<tr><td style=" border-top: 1px solid #DDDDDD;font-weight: bold; padding-left: 123px;text-align: left;" class="no_record">Please Select Customer.</td></tr>-->
<?php }?>
</table>

