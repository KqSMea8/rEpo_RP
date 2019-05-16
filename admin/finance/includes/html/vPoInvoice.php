<? if($_GET['pop']!=1){ ?>
	<?php 
	if(empty($Config['Junk'])){
		/*********************/
		/*********************/
	   	$NextID = $objPurchase->NextPrevRow($_GET['view'],1,'Invoice');
		$PrevID = $objPurchase->NextPrevRow($_GET['view'],2,'Invoice');
		$NextPrevUrl = "vPoInvoice.php?curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}
?>
	<a href="<?=$RedirectURL?>" class="back">Back</a>


	<? if(empty($ErrorMSG)){?>



	<? 
	/*********************/
	/*********************/
	if($ModifyLabel==1 && $arryPurchase[0]['InvoiceEntry'] == "1"){
		$CloneLabel = 'Copy '.$module;
		$CloneConfirm = str_replace("[MODULE]", $module, CLONE_CONFIRM_MSG);
	?>
	<a href="<?=$CloneURL?>" class="edit" onclick="return confirmAction(this, '<?=$CloneLabel?> ', '<?=$CloneConfirm?>')" ><?=$CloneLabel?></a>
	<?	
 	}
	/*********************/
	/*********************/
 	?>


<?
/************/
$ModuleDepName = "PurchaseInvoice";
 
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arryPurchase[0]["InvoiceID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $Config['P_Invoice'], 'PdfFile' => $arryPurchase[0]['PdfFile']));
 

if(!empty($GetDefPFdTempNameArray)){
	$PdfTmpArray = GetPdfLinks(array('Module' => $module,  'ModuleID' =>  $arryPurchase[0]["InvoiceID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $Config['P_Invoice'], 'TemplateID'=> $GetDefPFdTempNameArray[0]['id'], 'PdfFile' => $GetDefPFdTempNameArray[0]['PdfFile'] ));		 
	$DefaultDwnUrl = $PdfTmpArray['DownloadUrl'];
}else{ 
	$DefaultDwnUrl = $PdfResArray['DownloadUrl'];
  
}
  
/***********/


?>




        <!--code for dynamic pdf by sachin-->
        <ul class="editpdf_menu">
            <li>
                <a href="<?= $DefaultDwnUrl ?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
                <ul>
                    <?php
                    echo '<li><a class="editpdf download" href="' . $DefaultDwnUrl . '">Default</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
							
				$PdfTmpsArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $arryPurchase[0]["InvoiceID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $arryPurchase[0]['OrderID'], 'PdfFolder' => $Config['P_Invoice'], 'TemplateID'=> $tempnmval['id'] , 'PdfFile' => $tempnmval['PdfFile']));

				$TempDwnUrl = $PdfTmpsArray['DownloadUrl'];							

                            echo '<li><a class="editpdf download" href="' . $TempDwnUrl . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
					echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&dwntype=excel"> Excel Format </a></li>';
                    ?>

                </ul>
            </li>
        </ul>
    <!--code for dynamic pdf by sachin-->	
<ul class="editpdf_menu">
 <?php 
	echo '<li><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">Print</a>
	</li>';
 
	?>
</ul>
	<!--a href="<?=$EditUrl?>" class="edit">Edit</a-->
<!--	<a href="<?=$DownloadUrl?>" target="_blank" class="pdf" style="float:right">Download</a>-->
         <!--code for dynamic pdf by sachin-->
        <ul class="editpdf_menu">
            <li><a class="edit" href="javascript:void(0)">Edit PDF</a>
                <ul>
                    <?php
                    echo '<li><a class="add" href="../editcustompdf.php?curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&ModuleDepName=' . $ModuleDepName . '&po=' . $_GET['po'] . '&IE=' . $_GET['IE'] . '">Add PDF Template</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
                           echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
                            echo '<a class="delete" href="../editcustompdf.php?curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&Deltempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '"></a>';
                              }
                            echo '<a class="edit editpdf" href="../editcustompdf.php?curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '&po=' . $_GET['po'] . '&IE=' . $_GET['IE'] . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>                               
        </ul>
        <!--code for dynamic pdf sachin-->
	<? } ?>

	<div class="had"><?=$MainModuleName?>    <span>&raquo;	<?=$ModuleName?> Detail </span></div>
         <div class="message" align="center"><?php
        if (!empty($_SESSION['mess_Sale'])) {
            echo $_SESSION['mess_Sale'];
            unset($_SESSION['mess_Sale']);
        }
        ?></div>
	
	
	

	<div class="message" align="center"><? if(!empty($_SESSION['mess_invoice'])) {echo $_SESSION['mess_invoice']; unset($_SESSION['mess_invoice']); }?></div>
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
	
 <?php if($arryPurchase[0]['InvoiceEntry'] == 1){ ?>
        
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 

 <tr>
	 <td colspan="4" align="left" class="head">Invoice Information
	 <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['view']?>&module=PurchasesInvoice" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a>
	 </td>
</tr>
   <?php   
        $arryRecurr = $arryPurchase;

        include("../includes/html/box/recurring_2column_sales_view.php");
        ?>  
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" width="20%"><B><?=stripslashes($arryPurchase[0]["InvoiceID"])?></B></td>
   

        <td  align="right" width="30%"  class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
                <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>

		</td>
      </tr>  
      <? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	 
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>
      
      
 <tr>
        <td  align="right"   class="blackbold" >Item Received Date  :</td>
        <td   align="left" >
 <?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
</td>
	<? if($arryPurchase[0]['VendorInvoiceDate']>0){?>
	 <td  align="right"   class="blackbold" >Vendor Invoice Date :</td>
        <td   align="left" >
 <?=date($Config['DateFormat'], strtotime($arryPurchase[0]['VendorInvoiceDate']))?>
</td>
	<? } ?>

  
      </tr>
      


      <tr>
        
 	<td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		 <?=(!empty($arryPurchase[0]['PaymentTerm']))?(stripslashes($arryPurchase[0]['PaymentTerm'])):(NOT_SPECIFIED)?>
		</td>
	 
       

 

<? if(strtolower(trim($arryPurchase[0]['PaymentTerm']))=='credit card' && !empty($arryPurchase[0]['CreditCardVendor'])){  
	$arryCreditCardVendor = $objPurchase->GetSupplier('',$arryPurchase[0]['CreditCardVendor'],'');
 ?>
	 
		<td  align="right" class="blackbold">Credit Card Vendor :</td>
		<td   align="left">
		 
		<a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$arryCreditCardVendor[0]['SuppCode']?>" ><?=stripslashes($arryCreditCardVendor[0]["VendorName"])?></a>
		 		
		
		</td>
	 

	
	<? } ?>

<? if(!empty($BankAccount)){ ?>
	 
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

			 
	 
	<? } ?>
</tr>
<tr>
		<td  align="right" class="blackbold">Shipping Carrier  :</td>
		<td   align="left">
		<?=(!empty($arryPurchase[0]['ShippingMethod']))?(stripslashes($arryPurchase[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
		</td>

<td align="right" valign="top" class="blackbold">Shipping Method :</td>
		<td align="left" valign="top">

<?
if(!empty($arryPurchase[0]['ShippingMethodVal'])){		
	$arryShipMethodName = $objConfigure->GetShipMethodName($arryPurchase[0]['ShippingMethod'],$arryPurchase[0]['ShippingMethodVal']);
}
?>

<?=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED)?>
		</td>

</tr>

        <tr>          
                 <td valign="top" align="right" class="blackbold">Reference No#  :</td>
                   <td valign="top" align="left">
                    <B><?=stripslashes($arryPurchase[0]['PurchaseID'])?></B>
                </td>
			<td  align="right"  valign="top" class="blackbold" > Comments  : </td>
			<td  valign="top" align="left" >
                        <?=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED)?>
		</td>
      </tr>
  <?php
// Abid //
 if($arryCurrentLocation[0]['country_id']==106){ ?>
 <tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Upload Documents  :</td>
    <td  align="left" valign="top" >
	
	<? 
	 
       if(IsFileExist($Config['P_DocomentDir'],$arryPurchase[0]['UploadDocuments']) ){ ?>
	<div id="IdProofDiv">
	<?=$arryPurchase[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryPurchase[0]['UploadDocuments']?>&folder=<?=$Config['P_DocomentDir']?>" class="download">Download</a> 

	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>
 <?php } 
// End //
?> 

</table>       
        
 <?php } else {?>       
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Vendor
	 <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['view']?>&module=PurchasesInvoice" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a>
	 </td>
</tr>

<tr>
			<td  align="right"   class="blackbold" width="20%" > Vendor Code  : </td>
			<td   align="left" >
<?=stripslashes($arryPurchase[0]['SuppCode'])?>

			</td>
	 </tr>
 <tr>
	 <td colspan="2" align="left" class="head">Invoice Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["InvoiceID"])?></B></td>
      </tr>
	 <tr>
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
	  <tr>
        <td  align="right"   class="blackbold" >Item Received Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	</tr>
	<tr>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>
      <tr>
        <td  align="right"   class="blackbold">Assigned To  : </td>
        <td   align="left">

<? if(!empty($arryPurchase[0]['AssignedEmp'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryPurchase[0]['AssignedEmpID']?>" ><?=stripslashes($arryPurchase[0]['AssignedEmp'])?></a>   
<? 
	}else{
		echo NOT_SPECIFIED;
	}
?>
		  
		   </td>
                  
      </tr>
	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>
<?php 
// Abid //
if($arryCurrentLocation[0]['country_id']==106){ ?>
 <tr>
    <td height="30" align="right" valign="top"   class="blackbold" > Upload Documents  :</td>
    <td  align="left" valign="top" >
	
	<? 
        
       if(IsFileExist($Config['P_DocomentDir'],$arryPurchase[0]['UploadDocuments']) ){
?>
	<div id="IdProofDiv">
	<?=$arryPurchase[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryPurchase[0]['UploadDocuments']?>&folder=<?=$Config['P_DocomentDir']?>" class="download">Download</a> 

	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>
 <?php }
// End //
 ?> 
 <!--tr>
        <td  align="right" class="heading">Payment Details</td>
		 <td  align="right" class="heading"></td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';?>
		</td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Invoice Paid  : </td>
        <td   align="left" >
    <?=($arryPurchase[0]['InvoicePaid'] == 1)?('<span class="green">Yes</span>'):('<span class="red">No</span>')?>
           </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" >Payment Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
<tr>
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['InvPaymentMethod']))?(stripslashes($arryPurchase[0]['InvPaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

<tr>
        <td  align="right" class="blackbold">Payment Ref #  :</td>
        <td   align="left">
	<?=(!empty($arryPurchase[0]['PaymentRef']))?(stripslashes($arryPurchase[0]['PaymentRef'])):(NOT_SPECIFIED)?>
	
		</td>
</tr-->

</table>
 <?php }?>	
	
 </td>
</tr>

<tr>
	 <td  align="left">
<? 
if($arryPurchase[0]['InvoiceEntry'] == 0){ 
	include("includes/html/box/po_order_view.php");
}
?></td>
</tr>

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
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
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td  align="left" class="head" ><?=RECEIVED_ITEM?>
             <?php  if($arryPurchase[0]['InvoiceEntry'] != 1){?>
	 <div style="float:right"><a class="fancybox hideprint fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div>
             <?php }?>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>


	 </td>
</tr>


<tr>
	<td align="left" >
            <?php
                if($arryPurchase[0]['InvoiceEntry'] == 1){
                    
                    include("includes/html/box/po_item_Invoice_Entry_view.php");
                }else{
                    include("includes/html/box/po_item_invoice.php");
                }
            ?>
		
         
            
	</td>
</tr>



</table>	
    
	
	</td>
   </tr>

  

  
</table>
	



<? } ?>



