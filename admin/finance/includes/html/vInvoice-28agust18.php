<? if($_GET['pop']!=1){ ?>
	<?php 
	if($Config['Junk']==0){
		/*********************/
		/*********************/
	   	$NextID = $objSale->NextPrevRow($_GET['view'],1,'Invoice');
		$PrevID = $objSale->NextPrevRow($_GET['view'],2,'Invoice');
		$Ie = 'yes';
		$NextPrevUrl = "vInvoice.php?curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}
?>
	<a href="<?=$RedirectURL?>" class="back">Back</a>

	<? 
	/*********************/
	/*********************/
	if($arrySale[0]['InvoiceEntry'] == "1" && $ModifyLabel==1){ //Only Invoice Entry
		$CloneLabel = 'Copy '.$module;
		$CloneConfirm = str_replace("[MODULE]", $module, CLONE_CONFIRM_MSG);
	?>
	<a href="<?=$CloneURL?>" class="edit" onclick="return confirmAction(this, '<?=$CloneLabel?> ', '<?=$CloneConfirm?>')" ><?=$CloneLabel?></a>
	<?	
 	}
	/*********************/
	/*********************/
 	?>







<? if($HideEdit!=1){?>
<a href="<?=$EditUrl?>" class="edit">Edit</a>
<? } ?>

<a href="#" onClick="pop('mrgn')" class="edit">Invoice Margin</a>
<!--pdf code by sachin-->

<?
/************/
if($arrySale[0]['InvoiceEntry'] == "2" || $arrySale[0]['InvoiceEntry'] == "3"){
	$ModuleDepName = "SalesInvoiceGl";
}else{
	$ModuleDepName = "SalesInvoice";
}
 
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0]["InvoiceID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Invoice'], 'PdfFile' => $arrySale[0]['PdfFile']));
 

if(!empty($GetDefPFdTempNameArray)){
	$PdfTmpArray = GetPdfLinks(array('Module' => $module,  'ModuleID' =>  $arrySale[0]["InvoiceID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Invoice'], 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
	$DefaultDwnUrl = $PdfTmpArray['DownloadUrl'];
}else{ 
	$DefaultDwnUrl = $PdfResArray['DownloadUrl'];
  
}
  
/***********/

?>

<ul class="editpdf_menu">
	<li>
        <a href="<?=$DefaultDwnUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
                <ul>
		<?php 

		echo '<li><a class="editpdf download" href="'.$DefaultDwnUrl.'">Default</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
	 		$PdfTmpsArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arrySale[0]["InvoiceID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Invoice'], 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));
 
			$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];	
 
		echo '<li><a class="editpdf download" href="'.$TempDwnUrl.'">'.$tempnmval['TemplateName'].'</a></li>';
			/*End*/

		//echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&tempid='.$tempnmval['id'].'">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&dwntype=excel"> Excel Format </a></li>';
		?>

		</ul>
        </li>
	
        </ul>
	 <ul class="editpdf_menu">
 <?php 
	echo '<li><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">Print</a>
	</li>';
 
	?>
</ul>
<!--pdf code by sachin-->
	 
	<!--pdf code by sachin
        <a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>-->
        <ul class="editpdf_menu">
	<li><a class="edit" href="javascript:void(0)">Edit PDF</a>
		<ul>
		<?php 

		echo '<li><a class="add" href="../editcustompdf.php?curP='.$_GET['curP'].'&view='.$_GET["view"].'&ModuleDepName='.$ModuleDepName.'">Add PDF Template</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
		 echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
		echo '<a class="delete" href="../editcustompdf.php?curP='.$_GET['curP'].'&view='.$_GET["view"].'&Deltempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'"></a>';
	           }

		echo '<a class="edit editpdf" href="../editcustompdf.php?curP='.$_GET['curP'].'&view='.$_GET["view"].'&tempid='.$tempnmval['id'].'&ModuleDepName='.$ModuleDepName.'">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		?>

		</ul>
	</li>                               
        </ul>
        <!--pdf code by sachin-->
   <//?php
	//if(!empty($_REQUEST['view']) && $paidAmnt != $InvoiceAmount){?>
	<!--<a class="fancybox add" href="#payInvoice_div" style="float: right;">Pay Invoice</a>-->
	<//?php //}?>
   <div class="had"><?=$MainModuleName?>    <span>&raquo;		<?=$ModuleName.' Detail'?>	</span>	</div>
    <div class="message" align="center"><?php
        if (!empty($_SESSION['mess_Sale'])) {
            echo $_SESSION['mess_Sale'];
            unset($_SESSION['mess_Sale']);
        }
        ?></div>
		
	  <?}	if(!empty($ErrorMSG)){	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';}else{?>
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<!--<tr>
			 <td align="left"><//? include("includes/html/box/invoice_payment_view.php");?></td>
		</tr>-->

		<tr>
			 <td align="left">
                             
                          
                             
                             <?php
                                if($_GET['IE'] == 1){
                                    include("includes/html/box/invoice_Entry_information_view.php");
                                }else{
                                   include("includes/html/box/invoice_information_view.php");
                                }
                                ?>
                         
                         </td>
		</tr>

<?  if($CreditCardFlag==1){ ?>	
<tr>
	 <td align="left"><? $BoxPrefix = '../sales/'; include($BoxPrefix."includes/html/box/sale_card_view.php");?></td>
</tr>
 
<? } ?>

 <tr>
	<td align="left">
		<? include("../includes/html/box/shipping_info.php");?>
	</td>
</tr>

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
				<?php
                                if($_GET['IE'] == 1){
                                    include("includes/html/box/invoice_entry_item_view.php");
                                }else{
                                    include("includes/html/box/sales_order_item_view.php");
                                }
                                ?>
			</td>
		</tr>
                <?php if($_GET['pop'] != 1){?>
		<!--tr>
			 <td colspan="2" align="left" class="head" >Payment History</td>
		</tr>
		<tr>
			<td align="left" colspan="2">
				<? 	//include("includes/html/box/payment_invoice_view.php");?>
			</td>
		</tr-->
               <?php }?>

		</table>	
    
	
	</td>
   </tr>

  

  
</table>



<?
 

	//include("includes/html/box/invoice_payment_form.php");
 } ?>

<div id="mrgn"  class="ontop" >

<div class="inner-mrgn">
<div class="close-mgn"><i class="fa fa-times" aria-hidden="true"></i></div>
<div class="popup-header">Invoice Margin</div>
<?php 
$FeelLable='';
if($arrySale[0]['PaymentTerm']=="Credit Card"){
	$FeelLable = 'Credit Card';
}

$ConversionRate=1;
if($arrySale[0]['CustomerCurrency']!=$Config['Currency'] && $arrySale[0]['ConversionRate']>0){
	$ConversionRate = $arrySale[0]['ConversionRate'];			   
}

echo '<br><b>Sub Total</b> : '.number_format($subtotal,2).' '.$arrySale[0]['CustomerCurrency'];
echo '<br><br><b>Cost of Good </b>: '.number_format($costofgood,2).' '.$Config['Currency'];
echo '<br><br><b>'.$FeelLable.' Fees</b>: '.number_format($arrySale[0]['Fee'],2).' '.$arrySale[0]['CustomerCurrency'];
echo '<br><br><b>Freight </b>: '.number_format($Freight,2).' '.$arrySale[0]['CustomerCurrency'];

$OrginalSubTotal = GetConvertedAmount($ConversionRate, $subtotal); 
$OrginalFreight = GetConvertedAmount($ConversionRate, $Freight); 
$OrginalFee = GetConvertedAmount($ConversionRate, $arrySale[0]['Fee']); 
$OrginalDiscount = GetConvertedAmount($ConversionRate, $arrySale[0]['TDiscount']); 

$Grossprofit = ($OrginalSubTotal+$OrginalFreight) - $OrginalDiscount - $costofgood - $OrginalFee; 
echo '<br>-----------------------------------------------';
echo '<br><b>Gross Profit </b>: '.number_format($Grossprofit,2).' '.$Config['Currency'];
echo '<br>-----------------------------------------------';
$sale_comm = 0;
if(!empty($arrySalesCommission[0]['CommPercentage']) && !empty($Grossprofit)){
	$sale_comm = ($arrySalesCommission[0]['CommPercentage'] / 100) * $Grossprofit;
}

echo '<br><br><b>Sales Commision</b> : '.number_format($sale_comm,2).' '.$Config['Currency'];
echo '<br>-----------------------------------------------';

$Netprofit = $Grossprofit - $sale_comm;
echo '<br><b>Net Profit </b>: '.number_format($Netprofit,2).' '.$Config['Currency'];
echo '<br>-----------------------------------------------';
//echo 'CommPercentage';
?>
</div></div>

