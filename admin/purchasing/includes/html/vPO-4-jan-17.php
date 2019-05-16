<? if($_GET['pop']!=1){ ?>
	
	<?php 
	if($Config['Junk']==0){
		/*********************/
		/*********************/
	   	$NextID = $objPurchase->NextPrevRow($_GET['view'],1,$_GET["module"]);
		$PrevID = $objPurchase->NextPrevRow($_GET['view'],2,$_GET["module"]);
		$NextPrevUrl = "vPO.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}
?>	

	<a href="<?=$RedirectURL?>" class="back">Back</a>



	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
   <ul class="editpdf_menu">
	<li>
	<a href="<?=$DownloadUrl?>" target="_blank" class="pdf" style="float:right;margin-left:5px;">Download</a>
                <ul>
		<?php 

		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'">Default</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
		 
		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&tempid='.$tempnmval['id'].'">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		?>

		</ul>
        </li>
        </ul>
	
	



<? 
	if($OrderIsOpen ==  1){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_PO.'</a>';
			include("includes/html/box/convert_form.php");
		}else if($module=='Order' ){ 
			echo '<a href="../warehouse/receiptOrder.php?po='.$arryPurchase[0]['OrderID'].'&curP='.$_GET['curP'].'" class="edit" target="_blank">'.RECIEVE_ORDER.'</a>';
		}
	} 


	if($module=='Order' && $arryPurchase[0]['PurchaseID']!='' ){ 
		$TotalInvoice=$objPurchase->CountInvoices($arryPurchase[0]['PurchaseID']);
		if($TotalInvoice>0)
			echo '<a href="../warehouse/viewPoInvoice.php?po='.$arryPurchase[0]['PurchaseID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}

 } ?>
<ul class="editpdf_menu">
	<li><a class="edit" href="javascript:void(0)">Edit PDF</a>
		<ul>
		<?php 

		echo '<li><a class="add" href="../editcustompdf.php?module='.$module.'&curP='.$_GET['curP'].'&view='.$_GET["view"].'&ModuleDepName='.$ModuleDepName.'">Add PDF Template</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
		 
		echo '<li><a class="delete" href="../editcustompdf.php?module='.$module.'&curP='.$_GET['curP'].'&view='.$_GET["view"].'&Deltempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'"></a><a class="edit editpdf" href="../editcustompdf.php?module='.$module.'&curP='.$_GET['curP'].'&view='.$_GET["view"].'&tempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		?>

		</ul>
	</li>                               
        </ul>
	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$ModuleName.' Detail'?>
			
			</span>
	</div>
<?  if (!empty($_SESSION['mess_Sale'])) { ?>	<div class="message" align="center"> <?php echo $_SESSION['mess_Sale'];   unset($_SESSION['mess_Sale']); ?></div>	
	  <?  } 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_view.php");



?>
	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?

$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="4" align="left" class="head" ><?=LINE_ITEM?></td>
		</tr>
		<tr>
			<td align="left" colspan="4">
				<? 	include("includes/html/box/po_item_view.php");?>
			</td>
		</tr>
		</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>


