<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<? if(empty($ErrorMSG)){?>
        <!--<a class="pdf" style="float:right;margin-left:5px;" target="_blank" href="pdfBOM.php?bom=<?=$_GET['view']?>">Download</a>-->
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
	 <td colspan="2" align="left" class="head">Merge Item Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
                 
      
      <tr>
                         <td  align="right"   class="blackbold" width="25%"> Sku :   </td>
                        <td  align="left">
                       <?=$arryBOM[0]['Sku']?>
                       <input  name="item_id" id="item_id" value="<?=$arryBOM[0]['ItemID']?>" type="hidden"  class="inputbox"  maxlength="30" />
                        <input  name="on_hand_qty" id="on_hand_qty" value="<?=$arryBOM[0]['ItemID']?>" type="hidden"  class="inputbox"  maxlength="30" />	
                        	
                           

               </td>
  

</tr>
                   <tr>
                        <td  align="right"   class="blackbold" > Description :   </td>
                        <td  height="30" align="left">

                           <?=  stripslashes($arryBOM[0]['description'])?></td>
                    </tr>

<tr>  
  <td  align="right"   class="blackbold" > Item Condition:  <span class="red">*</span> </td>
                                        <td height="30" align="left">

<?=  stripslashes($arryBOM[0]['ParentCondition'])?>


                                        </td>
                                   </tr>

<? if($arryBOM[0]['ParentValuationType']== 'Serialized' || $arryBOM[0]['ParentValuationType']== 'Serialized Average'){?>
 <tr>
                        <td  align="right"   class="blackbold" > Serial Number :   </td>
                        <td  height="30" align="left">

                           <?=  stripslashes($arryBOM[0]['serial_Num'])?></td>
                    </tr>
<? }?>
                   <tr>
                        <td  align="right"   class="blackbold" > Cost :   </td>
                        <td  height="30" align="left">

                           <?=  stripslashes($arryBOM[0]['AvgCost'])?></td>
                    </tr>
				

 <tr>
                        <td  align="right"   class="blackbold" > Status :   </td>
                        <td  height="30" align="left">

                           <? if ($arryBOM[0]['Status'] == 1) {
        echo "Completed"; } else{ echo "Parked"; } ?></td>
                    </tr>
				

</table>

	 </td>
</tr>



<tr>
	 <td colspan="2" align="left" class="head" >Sub Item</td>
</tr>

<tr>
	<td align="left" colspan="2">


		<? 	include("includes/html/box/merge_item_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>

<script>
$(document).ready(function() {


        $(".slnoclass2").fancybox({
            'width': 300
        });



    });

</script>
