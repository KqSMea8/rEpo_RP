<? if($_GET['pop']!=1){ ?>

<a href="<?= $RedirectURL ?>" class="back">Back</a>

<? if(empty($ErrorMSG)){

/************/
$ModuleDepName = "PurchaseCreditMemo";
$PdfResArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' => $arryPurchase[0]["CreditID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $Config['P_Credit'], 'PdfFile' => $arryPurchase[0]['PdfFile']));

if(!empty($GetDefPFdTempNameArray)){
	$PdfTmpArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' =>  $arryPurchase[0]["CreditID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $Config['P_Credit'], 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
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
 
<!-- code by sachin -->
<ul class="editpdf_menu">
    <li>
        <a href="<?= $DefaultDwnUrl ?>" target="_blank" class="pdf" style="float:right;margin-left:5px;">Download</a>
        <ul>
            <?php
            echo '<li><a class="editpdf download" href="' . $DefaultDwnUrl . '">Default</a></li>';
            if (sizeof($GetPFdTempalteNameArray) > 0) {
                foreach ($GetPFdTempalteNameArray as $tempnmval) {
			$PdfTmpsArray = GetPdfLinks(array('Module' => 'Credit',  'ModuleID' => $arryPurchase[0]["CreditID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $Config['P_Credit'], 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));
 
			$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];
                    echo '<li><a class="editpdf download" href="' . $TempDwnUrl . '">' . $tempnmval['TemplateName'] . '</a></li>';
                }
            }
            ?>

        </ul>
    </li>
</ul>
<!--code by sachin -->

<!--code by sachin -->
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
<!--a href="<?= $EditUrl ?>" class="edit">Edit</a-->
<!--	<a href="<?= $DownloadUrl ?>" target="_blank" class="pdf" style="float:right;margin-left:5px;">Download</a>-->

 

<? 
/*
if($arryPurchase[0]['Approved'] == 1 && $arryPurchase[0]['Status'] == 'Open'){
echo '<a href="recieveOrder.php?po='.$arryPurchase[0]['OrderID'].'&curP='.$_GET['curP'].'" onclick="Javascript:ShowHideLoader(\'1\',\'L\');" class="edit">'.RECIEVE_ORDER.'</a>';
} 


if($module=='Order' && $arryPurchase[0]['PurchaseID']!='' ){ 
$TotalInvoice=$objPurchase->CountInvoices($arryPurchase[0]['PurchaseID']);
if($TotalInvoice>0)
echo '<a href="viewPoInvoice.php?po='.$arryPurchase[0]['PurchaseID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
}
*/
?>








<? } ?>

<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <?= $ModuleName . ' Detail' ?>

    </span>
</div>
<div class="message" align="center"><?php
    if (!empty($_SESSION['mess_Sale'])) {
        echo $_SESSION['mess_Sale'];
        unset($_SESSION['mess_Sale']);
    }
    ?></div>	
<? 

}	


if(!empty($ErrorMSG)){
echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
#include("includes/html/box/po_view.php");



?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
        <td align="left">


	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
		 <td colspan="4" align="left" class="head">Vendor</td>
	</tr>
	<tr>
			<td  align="right"   class="blackbold" width="20%"> Vendor Code  : </td>
			<td   align="left"  width="30%" >
<?=stripslashes($arryPurchase[0]['SuppCode'])?>

			</td>
	 
			<td  align="right"   class="blackbold" width="20%"> Vendor Name  : </td>
			<td   align="left" >
<?=stripslashes($arryPurchase[0]['SuppCompany'])?>		</td>
	</tr>

</table>

</td>
        </tr>



	

    <tr>
        <td align="left"><? include("includes/html/box/po_credit_note_view.php");?></td>
    </tr>


<? if(empty($arryPurchase[0]['AccountID'])) { ?>
    <tr>
        <td>

            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
                <tr>
                    <td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_vendor_view.php");?></td>
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
                    <td colspan="2" align="left" class="head" ><?= LINE_ITEM ?></td>
                </tr>
                <tr>
                    <td align="left" colspan="2">
                        <? 	include("includes/html/box/po_credit_item_view.php");?>
                    </td>
                </tr>
            </table>	


        </td>
    </tr>

<? } ?>


</table>



<? } ?>


