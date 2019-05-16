<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	ShowHideLoader('1','P');
}
</script>



<? 

$TotalGenerateInvoice = $objSale->GetQtyInvoicedCheck($_GET['view']);
$QtyInvoiced = (!empty($TotalGenerateInvoice[0]['QtyInvoiced']))?($TotalGenerateInvoice[0]['QtyInvoiced']):('');

if($_GET['pop']!=1){ ?>
	
	<?php 
	if($Config['Junk']==0){
		/*********************/
		/*********************/
	   	$NextID = $objSale->NextPrevRow($_GET['view'],1,$_GET["module"]);
		$PrevID = $objSale->NextPrevRow($_GET['view'],2,$_GET["module"]);
		$NextPrevUrl = "vSalesQuoteOrder.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}	
	?>
	<a href="<?=$RedirectURL?>" class="back">Back</a>

	<? 
	/*********************/
	/*********************/
	if($ModifyLabel==1){
		$CloneLabel = 'Copy Sales '.$_GET["module"];
		$CloneConfirm = str_replace("[MODULE]", "Sales ".$_GET["module"], CLONE_CONFIRM_MSG);
	?>
	<a href="<?=$CloneURL?>" class="edit" onclick="return confirmAction(this, '<?=$CloneLabel?> ', '<?=$CloneConfirm?>')" ><?=$CloneLabel?></a>
	<?	
 	}
	/*********************/
/*********************/
$module = $arrySale[0]['Module'];
if($module=="Order"){
	$PdfFolder = $Config['S_Order'];
	$SaleIDCol = 'SaleID';
}else{
	$PdfFolder = $Config['S_Quote'];
	$SaleIDCol = 'QuoteID';
}

/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0][$SaleIDCol], 'ModuleDepName' => 'Sales', 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'PdfFile' => $arrySale[0]['PdfFile']));
 

if(!empty($GetDefPFdTempNameArray)){
		$PdfTmpArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0][$SaleIDCol], 'ModuleDepName' => 'Sales', 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
		$DefaultDwnUrl = $PdfTmpArray['DownloadUrl'];
}else{ 
	$DefaultDwnUrl = $PdfResArray['DownloadUrl'];
  
}

 	?>


	<? if(empty($ErrorMSG)){?>
	<!--input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/ -->
<ul class="editpdf_menu">
	<li>
	<a href="<?=$DefaultDwnUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
                <ul>
		<?php 

		echo '<li><a class="editpdf download" href="'.$DefaultDwnUrl.'">Default</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
		 					
			$PdfTmpsArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0][$SaleIDCol], 'ModuleDepName' => 'Sales', 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));
 
			$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];	

		echo '<li><a class="editpdf download" href="'.$TempDwnUrl.'">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&dwntype=excel"> Excel Format </a></li>';
		?>

		</ul>
        </li>
        </ul>

	 
	<? if(empty($arrySale[0]['paypalInvoiceId']) && empty($arrySale[0]['batchId']) && empty($QtyInvoiced) ){?>
		<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<? } ?>



 <ul class="editpdf_menu">
  <?php //PR($GetPFdTempalteNameArray); ?>
	<li><a class="edit" href="javascript:void(0)">Edit PDF</a>
		<ul>
		<?php 

		echo '<li><a class="add" href="../editcustompdf.php?module='.$module.'&curP='.$_GET['curP'].'&view='.$_GET["view"].'&ModuleDepName='.$ModuleDepName.'">Add PDF Template</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
			echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
		echo '<a class="delete" href="../editcustompdf.php?module='.$module.'&curP='.$_GET['curP'].'&view='.$_GET["view"].'&Deltempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'"></a>';
         }
		echo '<a class="edit editpdf" href="../editcustompdf.php?module='.$module.'&curP='.$_GET['curP'].'&view='.$_GET["view"].'&tempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'">'.$tempnmval['TemplateName'].'</a></li>';

		}
		}
		?>

		</ul>
	</li>                               
</ul>
 <ul class="editpdf_menu">
 <?php 
 

	echo '<li><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">Print</a>
	</li>';
	//'pdfCommonhtml.php?o=9977&module=Order&editpdftemp=1&tempid=&ModuleDepName=Sales'
	?>
</ul>
  <ul class="editpdf_menu">
            <li>
                <a class="download" href="<?= $DownloadPickingSheetUrl ?>" style="float:right;margin-left:5px;">Picking sheet</a>
            </li>
        </ul>










<? 
if(!empty($_GET['view'])){
            $total_received = $objSale->GetQtyInvoiced($_GET['view']);
			$total_ordered = (!empty($total_received[0]['Qty']))?($total_received[0]['Qty']):('');
			$total_invoiced = (!empty($total_received[0]['QtyInvoiced']))?($total_received[0]['QtyInvoiced']):('');
		}
	if($arrySale[0]['Approved'] == 1 && $arrySale[0]['Status'] == 'Open'){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_SALE_ORDER.'</a>';
			include("includes/html/box/convert_form.php");
		}/*else if($module=='Order' && $total_ordered != $total_invoiced){ 
			echo '<a class="edit" href="../finance/generateInvoice.php?so='.$arrySale[0]['SaleID'].'&view='.$arrySale[0]['OrderID'].'" target="_blank">'.GENERATE_INVOICE.'</a>';
				//include("includes/html/box/generate_invoice_form.php");
		}*/
	} 


	/*if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="../finance/viewInvoice.php?po='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}*/
        
         
        if($arrySale[0]["OrderType"] == 'Against PO' && ($POStatus == 'Completed' || $POStatus == 'Invoicing')  && ($_SESSION['AdminType'] == 'admin' || $ApproveLabel==1)){ ?>
        <a class="edit" href="<?=$convertUrl;?>" onClick="return ResetSearch();"><?=CONVERT_TO_STANDARD_ORDER?></a>
            
        <?php }

?>








	<? } ?>

	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$ModuleName.' Detail'?>
			
			</span>
	</div>
        
        <div class="message" align="center"><?  if (!empty($_SESSION['mess_Sale'])) {  echo $_SESSION['mess_Sale'];   unset($_SESSION['mess_Sale']);  } ?></div>
		
	  <? 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	



?>
	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left"><? 
$SpiffOrderID=$OrderID;	
include("includes/html/box/sales_order_view.php");?></td>
</tr>

<?  if($CreditCardFlag==1){ ?>	
<tr>
	 <td align="left"><? include("includes/html/box/sale_card_view.php");?></td>
</tr>
 
<? } ?>


<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td align="left" valign="top"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?

$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" colspan="2">
				<? 	include("includes/html/box/sales_order_item_view.php");?>
			</td>
		</tr>
		</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>


