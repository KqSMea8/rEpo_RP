<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<? } ?>

	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$ModuleName.' Detail'?>
			
			</span>
	</div>
		<? if (!empty($errMsg)) {?>
		<div align="center"  class="red" ><?php echo $errMsg;?></div>
	  <? } 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_view.php");



?>
	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Transfer Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 




  <tr>
        <td  align="right" width="45%"   class="blackbold" >Transfer from  Location  : </td>
        <td   align="left" >
 <?=$arryTransfer[0]['from_warehouse']?>
		</td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" >Transfer to  Location  : </td>
        <td   align="left" >
 <?=$arryTransfer[0]['to_warehouse']?>
		</td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" >Transfer Reason : </td>
        <td   align="left"  >
          <?=  stripslashes($arryTransfer[0]['transfer_reason'])?>
		  
		 </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" >Transfer Status  : </td>
        <td   align="left" >
		
		<? if ($arryTransfer[0]['Status'] == 1) {
			$cls = 'green';
			$status = 'Parked';
		} else if($arryTransfer[0]['Status'] == 2) {
			$cls = 'green';
			$status = 'Completed';
		}else{
			$cls = 'red';
			$status = 'Canceled';  
		}

		echo '<span class="'.$cls.'"  >' . $status . '</span>';?>
		
		
           </td>
      </tr>




</table>

	 </td>
</tr>



<tr>
	 <td colspan="2" align="left" class="head" >Transfer Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/transfer_item_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>


