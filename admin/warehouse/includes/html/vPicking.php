<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	ShowHideLoader('1','P');
}
</script>



<? if($_GET['pop']!=1){ ?>
	
	<?php 
	if($Config['Junk']==0){
		/*********************/
		/*********************/
	   	$NextID = $objSale->NextPrevRow($_GET['view'],1,$_GET["module"]);
		$PrevID = $objSale->NextPrevRow($_GET['view'],2,$_GET["module"]);
		$NextPrevUrl = "vPicking.php?curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}	
	?>
	<a href="<?=$RedirectURL?>" class="back">Back</a>

	


	<? if(empty($ErrorMSG)){?>
	<!--input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/ -->


	 
	



 
 <ul class="editpdf_menu">
 <?php  
/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0]['SaleID'], 'ModuleDepName' => 'Sales', 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Order'], 'PdfFile' => $arrySale[0]['PdfFile']));
 
/********************/

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
	$total_receivedAry = $objSale->GetQtyInvoiced($_GET['view']);

	$total_ordered = (!empty($total_receivedAry[0]['Qty']))?($total_receivedAry[0]['Qty']):(0);
	$total_invoiced = (!empty($total_receivedAry[0]['QtyInvoiced']))?($total_receivedAry[0]['QtyInvoiced']):(0);
 
}
	


	/*if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="../finance/viewInvoice.php?po='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}*/
        
         
      








 } ?>

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
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
  <tr>
	 <td colspan="4" align="left" class="head">Pick Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" valign="top" width="20%"> Pick No# : </td>
	<td align="left" width="30%" valign="top">

	 <?=$arrySale[0]['PickID'];?>
	
	</td>
  
        <td  align="right"   class="blackbold" width="20%">Pick Date  :</td>
        <td   align="left" >
	
		<?php 
			$arryTime = explode(" ",$Config['TodayDate']);
			$ShipmentDate = ($arrySale[0]['PickDate']>0)?($arrySale[0]['PickDate']):($arryTime[0]); 
			#echo $ShipmentDate;
			?>

 <? if($ShipmentDate>0) 
		   echo date($Config['DateFormat'], strtotime($ShipmentDate));
		?>


</td>
      </tr>
<tr>
				<td align="right" class="blackbold">Status :</td>
<td align="left">
<? 

echo $arrySale[0]['PickStatus'];

?>
			</td>
</tr>
</table>
</td>
</tr>


<tr>
	 <td align="left"><? 
 	$SpiffSaleID=$SaleID;
	$SpiffPrefix='../sales/';
	include("../sales/includes/html/box/sales_order_view.php");?></td>
</tr>

<?  if($CreditCardFlag==1){ ?>	
<tr>
	 <td align="left"><? include("../sales/includes/html/box/sale_card_view.php");?></td>
</tr>
 
<? } ?>


<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("../sales/includes/html/box/sale_order_billto_view.php");?></td>
			<td align="left" valign="top"><? include("../sales/includes/html/box/sale_order_shipto_view.php");?></td>
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
				<? 	include("includes/html/box/pick_item_view.php");?>
			</td>
		</tr>
		</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>


