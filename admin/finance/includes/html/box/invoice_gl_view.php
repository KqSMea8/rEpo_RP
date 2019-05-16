<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	
       
        
 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

     
        <?php   
        $arryRecurr = $arrySale;
        include("../includes/html/box/recurring_2column_sales_view.php");?>

<? if($arrySale[0]['OrderPaid']>0) { ?>
	<tr>
		 <td  align="right"   class="blackbold" >Payment Status  : </td>
		<td   align="left" >	

<? echo $objSale->GetCreditStatusMsg($arrySale[0]['Status'],$arrySale[0]['OrderPaid']); ?>


		</td>
	</tr>
	<? } ?>


 <? if($arrySale[0]['CreatedDate']>0){ ?>
		<tr>
		<td  align="right"   class="blackbold" > Created Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['CreatedDate'])); ?>
		</td>
		<td  align="right"   class="blackbold" >  Updated Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['UpdatedDate'])); ?>
		</td>
		</tr>
	<? } ?>
         
    <tr>
        <td  align="right"   class="blackbold" width="15%"> Invoice Number # : </td>
        <td   align="left" width="35%">
		<B><?=stripslashes($arryOtherIncome[0]["InvoiceID"])?></B>
		</td>
   
	<td  align="right" width="20%"  class="blackbold">Customer : </td>
	<td   align="left" >
            
          <a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
	</td>
	</tr>	
        
         <tr>
        <td align="right"   class="blackbold">Invoice Amount :</td>
        <td align="left">
		<?=number_format($arryOtherIncome[0]['Amount'],2);?>&nbsp;<?=$arrySale[0]['CustomerCurrency'];?>
		   

	<?
	$HideRate='';
	if($arrySale[0]['CustomerCurrency']==$Config['Currency']){
		$HideRate = 'style="display:none;"';
	}
	?>

		</td>
    
	<td  align="right"   class="blackbold" >GL Entry Type :</td>
	<td   align="left" >
	 
            <?=$arryOtherIncome[0]['GlEntryType'];?>
	</td>
	</tr>	
     
<tr>
<td  align="right"   class="blackbold" id="ConversionRateLabel" <?=$HideRate?>> Conversion Rate  : </td>
	<td   align="left" <?=$HideRate?>>
<?=$arrySale[0]['ConversionRate']?>

</td>


	</tr>

	<tr>
                
                <?php if($arryOtherIncome[0]['GlEntryType'] == "Single") { ?>
                
                <td  align="right" class="blackbold">GL Account :</td>
		<td  align="left">
                        <?php
		if($arryOtherIncome[0]["IncomeTypeID"]>0){
                	$arryAccountName = $objBankAccount->getAccountNameByID($arryOtherIncome[0]["IncomeTypeID"]);
		}
                ?>
                <?=$arryAccountName[0]['AccountName'].' ['.$arryAccountName[0]['AccountNumber'].']'?>
		</td>
	 
              
                <?php }?>
		
	</tr>  
	
	<tr>
		<td  align="right" valign="top"  class="blackbold">Invoice Date  :</td>
		
		<td   align="left" valign="top">
                    <?=date($Config['DateFormat'], strtotime($arryOtherIncome[0]['PaymentDate']));?>
		</td>
	 	<td  align="right"   valign="top" class="blackbold">Invoice Comment  :</td>
		
		<td   align="left" valign="top" >
                  <?=stripslashes($arrySale[0]['InvoiceComment'])?>
		</td>
	</tr>	
	
	
      <?php if($arryOtherIncome[0]['GlEntryType'] == "Multiple") { ?>
        <tr>
			<td colspan="4">
				<? 	include("includes/html/box/add_multi_gl_view.php");?>
			</td>
		</tr>
                
         <?php }?> 


	<?  if($CreditCardFlag==1){ ?>	
	<tr>
	 <td colspan="4"><? $BoxPrefix = '../sales/'; include("../includes/html/box/invoice_card_view.php");?> </td>
	</tr>

	<? } ?>  
	 
</table>
        
        
        
      
	
  </td>
 </tr>



</table>

