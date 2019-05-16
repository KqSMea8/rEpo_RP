
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Credit Memo Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" > Credit Memo ID # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["CreditID"])?></B></td>
  </tr>
<tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arryPurchase[0]['Approved'] == 1)?('Yes'):('No')?>
		  
		 </td>

	 <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left" >
		 <? 
		 if($arryPurchase[0]['Status'] =='Open'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'redmsg';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryPurchase[0]['Status'].'</span>';
		
		 ?>

           </td>	


      </tr>
  <tr>
        <td  align="right"   class="blackbold" width="20%">Posted Date  : </td>
        <td   align="left" width="30%">
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>

        <td  align="right" class="blackbold" width="20%">Posted By  : </td>
        <td   align="left">
		<?
			if($arryPurchase[0]['AdminType'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryPurchase[0]['AdminID'].'" >'.stripslashes($arryPurchase[0]['CreatedBy']).'</a>';
			}
			echo $CreatedBy;
		?>
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
	

	

	<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['Comment']))?(stripslashes($arryPurchase[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>

		 <? if(!empty($arryPurchase[0]['InvoiceID'])) { 
	$arryInvoice = $objPurchase->GetPurchaseInvoice('',$arryPurchase[0]['InvoiceID'],"Invoice");
?>
 
        <td  align="right"   class="blackbold" > Invoice Number # :</td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="vPoInvoice.php?view=<?=$arryInvoice[0]['OrderID']?>&pop=1" ><?=$arryPurchase[0]["InvoiceID"]?></a>
		</td>
      
<? } ?>

	</tr>


<tr>
       
	<td align="right" class="blackbold">GL Account :</td>
	<td align="left">

		<?=$GLAccount?>

	</td>
    
	<?  if(!empty($arryPurchase[0]['AccountID'])) { ?>
	 
        <td  align="right"   class="blackbold" > Amount  : </td>
        <td   align="left" >
 <?=$arryPurchase[0]['TotalAmount']?> <?=$arryPurchase[0]['Currency']?>
		</td>
    <? } ?>
       
      </tr>


	<? if(empty($arryPurchase[0]['AccountID'])) { ?>
		 </tr>
		 <td  align="right" class="blackbold"> Re-Stocking : </td>
                        <td align="left">
                            <? if($arryPurchase[0]['Restocking']==1){echo "Yes";}else{echo "No";};?>

                        </td>
		 </tr>
		<? } ?>
	

	 
</table>
