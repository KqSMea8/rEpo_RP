
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Credit Memo Information</td>
</tr>
 <tr>
        <td  align="right"  width="20%" class="blackbold" > Credit Memo ID # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]["CreditID"])?></B></td>

        <td  align="right"   class="blackbold" width="20%"> Customer : </td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
</td>
  </tr>


	<tr>
	<td  align="right"   class="blackbold" >Credit Memo Type : </td>
        <td   align="left" >
 <?=(!empty($arrySale[0]['InvoiceID']))?("Against Invoice"):("Standard")?>
		</td>


<? if(!empty($arrySale[0]['InvoiceID'])) { 
	$arryInvoice = $objSale->GetInvoice('',$arrySale[0]['InvoiceID'],"Invoice");
?>
 
        <td  align="right"   class="blackbold" > Invoice Number # :</td>
        <td   align="left" >
	<? if(!empty($arryInvoice[0]['OrderID'])){?>
<a class="fancybox fancybox.iframe" href="vInvoice.php?view=<?=$arryInvoice[0]['OrderID']?>&pop=1" ><?=$arrySale[0]["InvoiceID"]?></a>
	<? }else{ echo $arrySale[0]["InvoiceID"];}?>

		</td>
       
<? } ?>

	</tr>

  <tr>
        <td  align="right"   class="blackbold" >Posted Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
   <td  align="right" class="blackbold" >Posted By  : </td>
        <td   align="left">
		<?
			if($arrySale[0]['AdminType'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arrySale[0]['AdminID'].'" >'.stripslashes($arrySale[0]['CreatedBy']).'</a>';
			}
			echo $CreatedBy;
		?>
          </td>
      </tr>

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
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arrySale[0]['Approved'] == 1)?('<span class=greenmsg>Yes</span>'):('<span class=redmsg>No</span>')?>
		  
		 </td>

        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left" >
		 <? 
		/* if($arrySale[0]['Status'] =='Open'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'redmsg';
		 }

		echo '<span class="'.$StatusCls.'">'.$arrySale[0]['Status'].'</span>';
		*/

echo $objSale->GetCreditStatusMsg($arrySale[0]['Status'],$arrySale[0]['OrderPaid']);
 

		 ?>

           </td>
      </tr>


 	

  <tr>
     
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arrySale[0]['Comment']))?(stripslashes($arrySale[0]['Comment'])):(NOT_SPECIFIED)?>

		</td>

		<? if(empty($arrySale[0]['AccountID'])) { ?>
		 <td  align="right" class="blackbold"> Re-Stocking : </td>
                        <td align="left">
                            <? if($arrySale[0]['ReSt']==1){echo "Yes";}else{echo "No";};?>

                        </td>
		<? } ?>
	</tr>

	<tr>
	<td align="right" class="blackbold">GL Account :</td>
	<td align="left">

		<?=$GLAccount?>

	</td>
	

<? if(!empty($arrySale[0]['AccountID'])) { ?>
	 
        <td  align="right"   class="blackbold" > Amount  : </td>
        <td   align="left" >
 <?=$arrySale[0]['TotalAmount']?> <?=$arrySale[0]['CustomerCurrency']?>
		</td>
    <? } ?>

	</td>
	</tr>



	<tr>
	<? if($arrySale[0]['Fee']>0) { ?>
		<td align="right" class="blackbold">Fee :</td>
		<td align="left"><?=$arrySale[0]['Fee']?>
		</td>
	  <? } ?>
	 
	<? if(!empty($arrySale[0]['OrderSource'])) { ?>
        <td  align="right"   class="blackbold" > Order Source  : </td>
        <td   align="left" >
 		<?=$arrySale[0]['OrderSource']?>
		</td>
  	<? } ?>

	</td>
	</tr>


</table>
