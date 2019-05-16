<? 

if($arryCustomer[0]['CustCode']!=''){
	$_GET['module']='Invoice'; $module = $_GET['module'];
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	$ViewDetailUrl = "../finance/vInvoice.php?pop=1";

	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];		
	$arrySale=$objSale->ListARInvoice($_GET);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arrySale)>0){ ?>
<tr align="left"  >
	<td width="15%" class="head1" ><?=$module?> Date</td>
	<td width="15%"  class="head1" ><?=$module?> Number</td>
	<td width="12%" class="head1" >SO/Reference #</td>
	<td class="head1">PO #</td>
	<td width="15%" align="center" class="head1" >Amount</td>
	<td width="10%" align="center" class="head1" >Currency</td>
	
	<td width="12%"  align="center" class="head1" >Status</td>
	<td width="5%" align="center" class="head1" >Download</td>
</tr>
<?

$pdf = '<img src="'.$Config['Url'].'admin/images/pdf.gif" border="0"  onMouseover="ddrivetip(\'<center>Download PDF</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';

$excel = '<img src="'.$Config['Url'].'admin/images/export.png" border="0"  onMouseover="ddrivetip(\'<center>Download Excel</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';

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
                                            if ($values['InvoiceDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
                                            ?>

		</td>
		<td >
<a class="fancybox fancybig fancybox.iframe" href="../admin/finance/vInvoice.php?view=<?=$values['OrderID']?>&pop=1" ><?=$values[$ModuleID]?></a>

</td>
<td>		 
<a href="../admin/sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" class="fancybox fancybig fancybox.iframe"><?=$values['SaleID']?></a>
</td>


<td><?=$values["CustomerPO"]?></td>
		<td align="center"><?=$values['TotalInvoiceAmount']?></td>
		<td align="center"><?=$values['CustomerCurrency']?></td>
	   
		<td align="center">
	   <?		
					$InvoicePaid = $values['InvoicePaid'];


                                            if ($InvoicePaid == 'Paid') {
                                                $StatusCls = 'green';
                                            } else {
                                                $StatusCls = 'red';
                                            }


					if($InvoicePaid=='Unpaid' && $values['PaymentTerm']=='Credit Card' && $values['OrderPaid']==1){
						 $StatusCls = 'green';
						 $InvoicePaid = 'Credit Card';
					}


                                            echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
                                            ?>
	 
	</td>

<td align="center">
			

<?
 /*if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){?>
	<a target="_blank" href="../admin/pdfCommonhtml.php?o=<?= $values['OrderID']; ?>&amp;ModuleDepName=SalesInvoiceGl"><?=$pdf?></a>
<? }else if($values['InvoiceEntry']<2){ ?>
<a target="_blank" href="../admin/pdfCommonhtml.php?o=<?= $values['OrderID']; ?>&amp;ModuleDepName=SalesInvoice"><?=$pdf?></a>
<? }*/ ?>
<?php
if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
	$ModuleDepName = "SalesInvoiceGl";
}else{
	$ModuleDepName = "SalesInvoice";
}
$PdfResArray = GetPdfLinks(array('Module' => 'Invoice',  'ModuleID' => $values['InvoiceID'], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['S_Invoice'], 'PdfFile' => $values['PdfFile']));
 
 
 $DownloadUrl = str_replace("../pdfCommonhtml.php","../admin/pdfCommonhtml.php", $PdfResArray['PrintUrl']);
?>
<a href="<?=$DownloadUrl?>" target="_blank"><?=$pdf?></a>

&nbsp;
<a target="_blank" href="../admin/pdfCommonhtml.php?o=<?= $values['OrderID']; ?>&amp;ModuleDepName=SalesInvoice&dwntype=excel"><?=$excel?></a>

		</td>
 
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
