<? if($_GET['pop']!=1){ ?>

<a href="<?= $RedirectURL ?>" class="back">Back</a>

<? if(empty($ErrorMSG)){?>
<!--code for dynamic pdf by sachin-->

<?
/*********************/
$ModuleDepName = "PurchaseRMA";
$module = "RMA"; 
$PdfFolder = $Config['P_Rma'];
 
/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arryPurchase[0]["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'PdfFile' => $arryPurchase[0]['PdfFile']));
/********************/

if(!empty($GetDefPFdTempNameArray)){

		$PdfTmpArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arryPurchase[0]["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
		$DefaultDwnUrl = $PdfTmpArray['DownloadUrl'];
//End//
}else{

	$DefaultDwnUrl = $PdfResArray['DownloadUrl'];
} 
/*********************/

?>


<ul class="editpdf_menu">
    <li>
        <a href="<?= $DefaultDwnUrl ?>" target="_blank" class="pdf" style="float:right;margin-left:5px;">Download</a>
        <ul>
            <?php
            echo '<li><a class="editpdf download" href="' . $DefaultDwnUrl . '">Default</a></li>';
            if (sizeof($GetPFdTempalteNameArray) > 0) {
                foreach ($GetPFdTempalteNameArray as $tempnmval) {
						 
			$PdfTmpsArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arryPurchase[0]["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $PdfFolder, 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));
			$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];
					 
                    echo '<li><a class="editpdf download" href="' . $TempDwnUrl . '">' . $tempnmval['TemplateName'] . '</a></li>';
                }
            }
            ?>

        </ul>
    </li>
</ul>
<!--code for dynamic pdf by sachin-->
<!--<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>-->
<?php /* ?><a href="<?=$EditUrl?>" class="edit">Edit</a><?php */ ?>
<!--<a href="<?= $DownloadUrl ?>" target="_blank" class="pdf" style="float:right">Download</a>-->
<!--code for dynamic pdf by sachin-->
<ul class="editpdf_menu">
    <li><a class="edit" href="javascript:void(0)">Edit PDF</a>
        <ul>
            <?php
            echo '<li><a class="add" href="../editcustompdf.php?curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&ModuleDepName=' . $ModuleDepName . '&po=' . $_GET["po"] . '">Add PDF Template</a></li>';
            if (sizeof($GetPFdTempalteNameArray) > 0) {
                foreach ($GetPFdTempalteNameArray as $tempnmval) {
                    echo '<li>';
         if($tempnmval['AdminID']==$_SESSION['AdminID']){
                    echo '<a class="delete" href="../editcustompdf.php?curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&Deltempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '&rtn=' . $_GET["rtn"] . '"></a>';
                  }
                   echo  '<a class="edit editpdf" href="../editcustompdf.php?curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '">' . $tempnmval['TemplateName'] . '</a></li>';
                }
            }
            ?>

        </ul>
    </li>                               
</ul>
<!--code for dynamic pdf sachin-->
<ul class="editpdf_menu">
       <?php 
       echo '<li><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">Print</a>
   </li>';
    //'pdfCommonhtml.php?o=9977&module=Order&editpdftemp=1&tempid=&ModuleDepName=Sales'
   ?>
</ul>
<? } ?>

<div class="had"><?= $MainModuleName ?>    <span>&raquo;	<?= $ModuleName ?> Detail </span></div>




<div class="message" align="center"><?  if (!empty($_SESSION['mess_Sale'])) {  echo $_SESSION['mess_Sale'];   unset($_SESSION['mess_Sale']);  } ?><? if(!empty($_SESSION['mess_invoice'])) {echo $_SESSION['mess_invoice']; unset($_SESSION['mess_invoice']); }?></div>
<?

}	



if(!empty($ErrorMSG)){
echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


#include("includes/html/box/invoice_view.php");

?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td  align="center" valign="top" >


            <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
                <tr>
                    <td colspan="4" align="left" class="head">RMA Information</td>
                </tr>
                <tr>
                    <td  align="right"   class="blackbold" width="20%"> RMA No# : </td>
                    <td   align="left" width="30%"><B><?= stripslashes($arryPurchase[0]["ReturnID"]) ?></B></td>

                    <td  align="right"   class="blackbold" width="20%">RMA Date  : </td>
                    <td   align="left" >
<?= ($arryPurchase[0]['PostedDate'] > 0) ? (date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_SPECIFIED) ?>
                    </td>
                </tr>  
                <tr>
                    <td  align="right"   class="blackbold" >Item RMA Date  : </td>
                    <td   align="left" >
<?= ($arryPurchase[0]['ReceivedDate'] > 0) ? (date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"  valign="top" class="blackbold" > Comments  : </td>
                    <td   align="left"  valign="top" >
<?= (!empty($arryPurchase[0]['InvoiceComment'])) ? (stripslashes($arryPurchase[0]['InvoiceComment'])) : (NOT_SPECIFIED) ?>

                    </td>
                </tr>
                <tr>
                    <td  align="right"   class="blackbold" >RMA Expiry Date  : </td>
                    <td   align="left" >
<?= ($arryPurchase[0]['ExpiryDate'] > 0) ? (date($Config['DateFormat'], strtotime($arryPurchase[0]['ExpiryDate']))) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold" > Re-Stocking : </td>

                    <td   align="left">
<?= ($arryPurchase[0]["Restocking"] == 1) ? ('Yes') : ('No') ?>

                    </td>  
                </tr>

                <!--tr>
                <td  align="right" class="blackbold">Action :</td>
                <td   align="left">
<?= (!empty($arryPurchase[0]['Module'])) ? (stripslashes($arryPurchase[0]['Module'])) : (NOT_SPECIFIED) ?>
                
                        </td>
        </tr>
        
        <tr>
                <td  align="right" class="heading">Payment Details</td>
                         <td  align="right" class="heading"  colspan="3"></td>
              </tr>
        
                <tr>
                <td  align="right"   class="blackbold" > Total Amount : </td>
                <td   align="left" >
                        <?	echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';?>
                        </td>
            
                <td  align="right"   class="blackbold" > RMA Amount Paid  : </td>
                <td   align="left" >
<?= ($arryPurchase[0]['InvoicePaid'] == 1) ? ('<span class="green">Yes</span>') : ('<span class="red">No</span>') ?>
                   </td>
              </tr>
         <tr>
                <td  align="right"   class="blackbold" >Payment Date  : </td>
                <td   align="left" >
<?= ($arryPurchase[0]['PaymentDate'] > 0) ? (date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))) : (NOT_SPECIFIED) ?>
                        </td>
              
                                <td  align="right"   class="blackbold" > Payment Method  : </td>
                                <td   align="left" >
<?= (!empty($arryPurchase[0]['InvPaymentMethod'])) ? (stripslashes($arryPurchase[0]['InvPaymentMethod'])) : (NOT_SPECIFIED) ?>
        
                        </td>
                </tr>
        
        <tr>
                <td  align="right" class="blackbold">Payment Ref #  :</td>
                <td   align="left">
<?= (!empty($arryPurchase[0]['PaymentRef'])) ? (stripslashes($arryPurchase[0]['PaymentRef'])) : (NOT_SPECIFIED) ?>
                
                        </td>
        </tr-->




            </table>


        </td>
    </tr>

    <tr>
        <td  align="left"><? include("includes/html/box/rma_invoice_view.php");?></td>
    </tr>

<tr>
	<td align="left">
	<?
	$arryShipStand['ModuleType'] = 'PurchaseRMA';
	$arryShipStand['RefID'] = $OrderID; 
	include("../includes/html/box/shipping_info_standalone.php");
	?>
	</td>
</tr>


    <tr>
        <td>

            <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
                <tr>
                    <td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_rma_view.php");?></td>
                    <td width="1%"></td>
                    <td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_rma_view.php");?></td>
                </tr>
            </table>

        </td>
    </tr>

    <tr>
        <td align="right">
            <?
            echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
            ?>	 
        </td>
    </tr>


    <tr>
        <td  align="center" valign="top" >


            <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

                <tr>
                    <td  align="left" class="head" >Line Item
<?php /* ?><div style="float:right"><a class="fancybox hideprint fancybox.iframe" href="vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div><?php */ ?>

                        <script language="JavaScript1.2" type="text/javascript">

                            $(document).ready(function () {
                                $(".fancybox").fancybox({
                                    'width': 900
                                });

                            });

                        </script>


                    </td>
                </tr>


                <tr>
                    <td align="left" >
                        <? 	include("includes/html/box/po_item_order_rma_view.php");?>
                    </td>
                </tr>



            </table>	


        </td>
    </tr>




</table>




<? } ?>



