<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	
        <!---------------------------------------------------------------->
        
        <table width="100%"  border="0" align="center" id="glFrom"  cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
  <?php
 
  if(!empty($_GET['Flag'])){ ?>      
	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

    
    <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left" width="30%">
		<B><?=stripslashes($arryOtherExpense[0]["InvoiceID"])?></B>
		</td>
   
	<td  align="right" width="20%"  class="blackbold">Pay to Vendor : </td>
	<td   align="left" >
            
            <?php  
            if(!empty($arryOtherExpense[0]['VendorName'])){ 
            $SupplierName = $arryOtherExpense[0]['VendorName'];
            }elseif(!empty($arryOtherExpense[0]['CompanyName'])){ 
                $SupplierName = $arryOtherExpense[0]['CompanyName'];
            }
            
            ?>
	 <?=(!empty($SupplierName))?(stripslashes($SupplierName)):(NOT_SPECIFIED)?>
	</td>
	</tr>	
        
         <tr>
        <td align="right"   class="blackbold"> Amount :</td>
        <td align="left">
		<?=number_format($arryOtherExpense[0]['Amount'],2,'.','');?>&nbsp;<?=$arryOtherExpense[0]['Currency'];?>
		   
		</td>
    
	<!--td  align="right"   class="blackbold" >Payment Method :</td>
	<td   align="left" >
	 
            <?=$arryOtherExpense[0]['PaymentMethod'];?>
	</td-->
	</tr>
        
         <?php if($arryOtherExpense[0]['PaymentMethod'] == "Check") {?> 
        <tr>
            <td align="right"   class="blackbold">Bank Name :</td>
            <td align="left"><?=$arryOtherExpense[0]['CheckBankName'];?></td>
            
            <td align="right"   class="blackbold">Check Format : </td>
            <td align="left"><?=$arryOtherExpense[0]['CheckFormat'];?></td>
            
            
        </tr>
        <?php }?>
     
	<tr>
             <td  align="right"   class="blackbold">Invoice Date  :</td>
		
		<td   align="left" >
                    <?=date($Config['DateFormat'], strtotime($arryOtherExpense[0]['PaymentDate']));?>
		</td>
                
               
               <?php if($arryOtherExpense[0]['GlEntryType'] != "Multiple") { ?>  
                <td  align="right" class="blackbold">GL Account :</td>
		<td  align="left">
                        <?php

                $arryAccount = $objBankAccount->getAccountNameByID($arryOtherExpense[0]["ExpenseTypeID"]);

                ?>
                <?=$arryAccount[0]['AccountName']?>  [<?=$arryAccount[0]['AccountNumber']?>]
		</td>
               <?php } else {?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
               <?php }?>
	 
               
		
	</tr>  
	
	<tr>
		
	 
	<!--td  align="right"   class="blackbold"> Paid From A/C :</td>
	<td   align="left" >
	<?=$arryOtherExpense[0]['AccountName'];?>
	</td>
         <!--td  align="right" valign="top"   class="blackbold">Reference No#  : </td>
        <td   align="left" valign="top">
		<?=(!empty($arryOtherExpense[0]['ReferenceNo']))?(stripslashes($arryOtherExpense[0]['ReferenceNo'])):(NOT_SPECIFIED)?>
		</td-->
	</tr>	
	
	
	
	
   <!--tr>
       
    
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><?=(!empty($arryOtherExpense[0]['Comment']))?(stripslashes($arryOtherExpense[0]['Comment'])):(NOT_SPECIFIED)?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
	</tr-->
      <?php if($arryOtherExpense[0]['GlEntryType'] == "Multiple") { ?>
        <tr>
			<td colspan="4">
				<? 	include("includes/html/box/add_multi_gl_view.php");?>
			</td>
		</tr>
                
         <?php }?>   
	 
</table>	
<?php } else {?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

     <!---Recurring Start-->
        <?php   
        $arryRecurr = $arryOtherExpense;
        include("../includes/html/box/recurring_2column_sales_view.php");?>

        <!--Recurring End-->

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
        <td  align="right"   class="blackbold" width="15%"> Invoice Number # : </td>
        <td   align="left" width="35%">
		<B><?=stripslashes($arryOtherExpense[0]["InvoiceID"])?></B>
		</td>
   
	<td  align="right" width="20%"  class="blackbold">Pay to Vendor : </td>
	<td   align="left" >
            
            <?php   
            if(!empty($arryOtherExpense[0]['VendorName'])){ 
            $SupplierName = $arryOtherExpense[0]['VendorName'];
            }elseif(!empty($arryOtherExpense[0]['CompanyName'])){ 
                $SupplierName = $arryOtherExpense[0]['CompanyName'];
            }
            
            ?>
            
           
	 <?=(!empty($SupplierName))?(stripslashes($SupplierName)):(NOT_SPECIFIED)?>
	</td>
	</tr>	
        
         <tr>
		<td align="right"   class="blackbold"> Amount :</td>
		<td align="left">
		<?=$arryPurchase[0]['TotalAmount']?>&nbsp;<?=$arryPurchase[0]['Currency'];?>		   
		</td>
    	<?
	if($arryPurchase[0]['Currency']==$Config['Currency']){
		$HideRate = 'style="display:none;"';
	}else{
	$HideRate ='';
	}
	?>
		
	<td  align="right"   class="blackbold" id="ConversionRateLabel" <?=$HideRate?>> Conversion Rate  : </td>
	<td   align="left" <?=$HideRate?>>
<?=$arryPurchase[0]['ConversionRate']?>

</td>


	</tr>
	
	
     
	<tr>
            <!--td  align="right" class="blackbold">Payment Method : </td>
		<td   align="left">
		<?=$arryOtherExpense[0]['PaymentMethod'];?>
		</td-->
                
                <?php if($arryOtherExpense[0]['GlEntryType'] == "Single") { 

		 $arryAccountName = $objBankAccount->getAccountNameByID($arryOtherExpense[0]["ExpenseTypeID"]);
			if(!empty($arryAccountName[0]['AccountName'])){
?>
                

		<td  align="right"   class="blackbold" >GL Entry Type :</td>
	<td   align="left" >
	 
            <?=$arryOtherExpense[0]['GlEntryType'];?>
	</td>
                <td  align="right" class="blackbold">GL Account :</td>
		<td  align="left">
                        
                <?=$arryAccountName[0]['AccountName'].' ['.$arryAccountName[0]['AccountNumber'].']'?>
		</td>
	 
              
                <?php }}?>
		
	</tr>  
	
	<tr>
		<td  align="right"  valign="top" class="blackbold">Invoice Date  :</td>
		
		<td   align="left" valign="top" >
                    <?=date($Config['DateFormat'], strtotime($arryOtherExpense[0]['PaymentDate']));?>
		</td>
		<td  align="right"   valign="top" class="blackbold">Vendor Invoice Date :</td>
		
		<td   align="left" valign="top" >
                 <? if($arryPurchase[0]['VendorInvoiceDate']>0) echo date($Config['DateFormat'], strtotime($arryPurchase[0]['VendorInvoiceDate']));?>
		</td>
	 
	 
	</tr>	
	
<tr>
		 <td  align="right"   valign="top" class="blackbold">PO / Reference #:</td>
		
		<td   align="left" valign="top" >
                  <?=stripslashes($arryPurchase[0]['PurchaseID'])?>
		</td>

		<td  align="right"   valign="top" class="blackbold">Invoice Comment  :</td>
		
		<td   align="left" valign="top" >
                  <?=stripslashes($arryPurchase[0]['InvoiceComment'])?>
		</td>
	 
	<!--td  align="right"   class="blackbold"> Paid From A/C :</td>
	<td   align="left" >
	<?=$arryOtherExpense[0]['AccountName'].' ['.$arryOtherExpense[0]['AccountNumber'].']'?>
	</td-->
	</tr>	
	


	
	<? if($arryPurchase[0]['AdjustmentAmount']!='0.00'){ ?>
		  <tr>
		<td align="right"   class="blackbold"> Adjustments :</td>
		<td align="left">
		<?=$arryPurchase[0]['AdjustmentAmount']?>&nbsp;<?=$arryPurchase[0]['Currency'];?>		   
		</td>
		   </tr>
		<? } ?>
		
   <!--tr>
        <td  align="right" valign="top"   class="blackbold">Reference No#  : </td>
        <td   align="left" valign="top">
		<?=(!empty($arryOtherExpense[0]['ReferenceNo']))?(stripslashes($arryOtherExpense[0]['ReferenceNo'])):(NOT_SPECIFIED)?>
		</td>
    
		<td valign="top" align="right" class="blackbold">Payment Description :</td>
		<td align="left"><?=(!empty($arryOtherExpense[0]['Comment']))?(stripslashes($arryOtherExpense[0]['Comment'])):(NOT_SPECIFIED)?></td>
	</tr-->
	

      <?php if($arryOtherExpense[0]['GlEntryType'] == "Multiple") { ?>
        <tr>
			<td colspan="4">
				<? 	include("includes/html/box/add_multi_gl_view.php");?>
			</td>
		</tr>
                
         <?php }?>   
	 

	 <tr>
			<td colspan="4">
				<? 	include("includes/html/box/vendor_transfer_view.php");?>
			</td>
		</tr>


</table>	
        
  <?php }?>      
  </td>
 </tr>

</table>

        
        
        
        <!------------------------------------------------------------------------------------->
	
  </td>
 </tr>

</table>

