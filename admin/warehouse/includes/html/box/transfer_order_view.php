<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $module ='Order';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$module?> Transfer Information</td>
</tr>
 <tr>
        <td  align="right" width="45%"   class="blackbold" >Transfer from  Location  : </td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="vWarehouse.php?pop=1&view=<?=$from_WID?>" > <?=$from_location?></a>
		</td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold" >Transfer to  Location  : </td>
        <td   align="left" >
<a class="fancybox fancybox.iframe" href="vWarehouse.php?pop=1&view=<?=$to_WID?>" > <?=$to_location?></a>
		</td>
      </tr>

	  <tr>
        <td  align="right"   class="blackbold" >Transfer Reason : </td>
        <td   align="left"  >
          <?=  stripslashes($arryTransfer[0]['transfer_reason'])?>
		  
		 </td>
      </tr>

<tr>
        <td  align="right" class="blackbold" >Created By  : </td>
        <td   align="left">
		<?
			if($arryTransfer[0]['created_by'] == 'admin'){
				$CreatedBy = 'Administrator';
			}else{
				$CreatedBy = '<a class="fancybox fancybox.iframe" href="../hrms/empInfo.php?view='.$arryTransfer[0]['created_id'].'" >'.stripslashes($arryTransfer[0]['created_by']).'</a>';
			}
			echo $CreatedBy;
		?>
          </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Transfer Date  : </td>
        <td   align="left" >
		<? echo date($Config['DateFormat'], strtotime($arryTransfer[0]['transferDate']));?>
	
	
           </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Transfer Status  : </td>
        <td   align="left" >
		<?=$arryTransfer[0]['Status']?>
	
           </td>
      </tr>


	

	

	

	
</table>