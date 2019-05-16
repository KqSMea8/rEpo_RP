<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>


<?
if($CreditCardFlag==1 && !empty($ProviderName)){
	if($AmountToRefund>0){	
		$VoidCardUrl .= '&Crd='.$OrderID;

		
			#echo '<div style="float:right;display:none2"><a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card for '.$AmountToRefund.' '.$arryInvoice[0]['CustomerCurrency'].'</a></div>';	
		
			echo '<div style="float:right;display:none2"><a href="#void_card_div"  class="fancybox grey_bt" >Refund Credit Card for '.$AmountToRefund.' '.$arryInvoice[0]['CustomerCurrency'].'</a></div>';	
			include("includes/html/box/void_card_div.php");	
		
	} 		 
}

?>



	<? if(empty($ErrorMSG)){?>
	<!--input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/-->
	<!--a href="<?=$EditUrl?>" class="edit">Edit</a-->
 
<?
/************/
$ModuleDepName = "SalesCreditMemo";
$PdfResArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' => $arrySale[0]["CreditID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Credit'], 'PdfFile' => $arrySale[0]['PdfFile']));

if(!empty($GetDefPFdTempNameArray)){
	$PdfTmpArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' =>  $arrySale[0]["CreditID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Credit'], 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
	$DefaultDwnUrl = $PdfTmpArray['DownloadUrl'];
}else{ 
	$DefaultDwnUrl = $PdfResArray['DownloadUrl'];
  
}
 
 
/***********/

?>
<ul class="editpdf_menu">
 <?php 
	echo '<li><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">Print</a>
	</li>';
 
	?>
</ul>
<ul class="editpdf_menu">
    <li>
        <a href="<?= $DefaultDwnUrl ?>" target="_blank" class="pdf" style="float:right;margin-left:5px;">Download</a>
        <ul>
            <?php
            echo '<li><a class="editpdf download" href="' . $DefaultDwnUrl . '">Default</a></li>';
            if (sizeof($GetPFdTempalteNameArray) > 0) {
                foreach ($GetPFdTempalteNameArray as $tempnmval) {
			
			$PdfTmpsArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' => $arrySale[0]["CreditID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arrySale[0]['OrderID'], 'PdfFolder' => $Config['S_Credit'], 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));
 
			$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];

                    echo '<li><a class="editpdf download" href="' . $TempDwnUrl . '">' . $tempnmval['TemplateName'] . '</a></li>';
                }
            }
            ?>

        </ul>
    </li>
</ul>
 



<ul class="editpdf_menu">
    <li><a class="edit" href="javascript:void(0)">Edit PDF</a>
        <ul>
            <?php
            echo '<li><a class="add" href="../editcustompdf.php?module=' . $mmodule . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&ModuleDepName=' . $ModuleDepName . '">Add PDF Template</a></li>';
            if (sizeof($GetPFdTempalteNameArray) > 0) {
                foreach ($GetPFdTempalteNameArray as $tempnmval) {
                  echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
                    echo '<a class="delete" href="../editcustompdf.php?module=' . $mmodule . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&Deltempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '"></a>';

              }
             echo '<a class="edit editpdf" href="../editcustompdf.php?module=' . $mmodule . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '">' . $tempnmval['TemplateName'] . '</a></li>';
                }
            }
            ?>

        </ul>
    </li>                               
</ul>
<!--code by sachin -->
	 

	<? } ?>

	<div class="had"> <?=$MainModuleName?>    <span>&raquo;	<?=$ModuleName.' Detail'?>	</span>	</div>
		
	  <?php }	if(!empty($ErrorMSG)){
		echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
		}else{
	?>
	

<div class="message" align="center"><? if(!empty($_SESSION['mess_credit'])) {echo $_SESSION['mess_credit']; unset($_SESSION['mess_credit']); }?></div>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left"><? 	include("includes/html/box/credit_note_view.php");?></td>
</tr>

<? if(!empty($arrySale[0]['InvoiceID']) && $PaymentTermInvoice=="Credit Card") { 

	$Config["CreditOrderID"] = $OrderID;
	$OrderID = $InvOrderID;
	$arrySale[0]['PaymentTerm'] = $arryInvoice[0]['PaymentTerm'];
	$arrySale[0]['SaleID'] = $arryInvoice[0]['SaleID'];
	

 ?>	
<tr>
	 <td align="left"><? $BoxPrefix = '../sales/'; include($BoxPrefix."includes/html/box/sale_card_transaction.php");?></td>
</tr>
 
<? } ?>


<? if(empty($arrySale[0]['AccountID'])) { ?>
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

  <? } ?>

  
</table>



<? } ?>


