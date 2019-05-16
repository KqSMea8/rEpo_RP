<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<!--a href="<?=$EditUrl?>" class="edit">Edit</a-->
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
	 <td colspan="2" align="left" class="head">Adjustment Information</td>
</tr>
 <tr>
                                        <td align="right"  width="45%"  class="blackbold" > <?=ADJ_NO?>:   </td>
                                        <td  align="left">
                                        <?= stripslashes($arryAdjustment[0]['adjustNo']); ?>
                                           </td>
                                    </tr>


 <tr>
                                        <td align="right"  width="45%"  class="blackbold" > <?=ADJ_DATE?>:   </td>
                                        <td  align="left">
                                        <?= date($Config['DateFormat'] , strtotime($arryAdjustment[0]['adjDate'])); ?>
                                           </td>
                                    </tr>
<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 




  <tr>
        <td  align="right" width="45%"   class="blackbold" >Adjustment to Item At Location  : </td>
        <td   align="left" >
 <?=$arryAdjustment[0]['warehouse_name']?> [<?=$arryAdjustment[0]['warehouse_code']?>]
		</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Adjustment Reason : </td>
        <td   align="left"  >
          <?=  stripslashes($arryAdjustment[0]['adjust_reason'])?>
		  
		 </td>
      </tr>


<tr>
        <td  align="right"   class="blackbold" >Adjustment Status  : </td>
        <td   align="left" >
		<? if ( $arryAdjustment[0]['Status']==1) 
                    {
                    echo "Parked";
                    
                    } 
                 else if( $arryAdjustment[0]['Status']==2) { 
                     echo "Completed"; 
                     
                 } 
                 else{ 
                     echo "Canceled";
                     
                 } ?>
           </td>
      </tr>




</table>

	 </td>
</tr>



<tr>
	 <td colspan="2" align="left" class="head" >Adjustment Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/adjust_item_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>


