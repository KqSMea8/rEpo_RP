<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<? if(empty($ErrorMSG)){?>
        <!--<a class="pdf" style="float:right;margin-left:5px;" target="_blank" href="pdfBOM.php?bom=<?=$_GET['view']?>">Download</a>-->
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
        <? if($arryBOM[0]['Status']!=2){?>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
        <? }  } ?>

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
	 <td colspan="2" align="left" class="head">BOM Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
                 
       <?
if(!isset($arryBOM[0]['ItemID'])) $arryBOM[0]['ItemID']='';

?>


      <tr>
           <td  align="right"   class="blackbold" > Disassembly Number :   </td>
          <td  align="left">
         <?=$arryBOM[0]['DsmCode']?>
        
          	
             

      </td>
      </tr>  
      <tr>
                         <td width="45%" align="right"   class="blackbold" > Bill Number:   </td>
                        <td width="69%" height="30" align="left">
                       <?=$arryBOM[0]['Sku']?>
                       <input  name="item_id" id="item_id" value="<?=$arryBOM[0]['ItemID']?>" type="hidden"  class="inputbox"  maxlength="30" />
                        <input  name="on_hand_qty" id="on_hand_qty" value="<?=$arryBOM[0]['ItemID']?>" type="hidden"  class="inputbox"  maxlength="30" />	
                        	
                           

               </td>


                    </tr>
 <tr>
                        <td width="31%" align="right"   class="blackbold" > Item Condition:   </td>
                        <td width="69%" height="30" align="left">
                           <?=  stripslashes($arryBOM[0]['bomCondition'])?></td>
                    </tr>
                    <tr>
                        <td width="31%" align="right"   class="blackbold" > Description:   </td>
                        <td width="69%" height="30" align="left">
                           <?=  stripslashes($arryBOM[0]['description'])?></td>
                    </tr>
					<tr>
                        <td width="31%" align="right"   class="blackbold" > Available Quantity:   </td>
                        <td width="69%" height="30" align="left">
                         <?=$arryBOM[0]['on_hand_qty']?></td>
                    </tr>


  <tr>
                         <td width="45%" align="right"   class="blackbold" > Warehouse Location:   </td>
                        <td width="69%" height="30" align="left">
                       <?=$arryBOM[0]['WarehouseCode']?> </td>

                    </tr>
					<tr>
                        <td width="31%" align="right"   class="blackbold" > Assemble Quantity:   </td>
                        <td width="69%" height="30" align="left">
                         <?=$arryBOM[0]['disassembly_qty']?>
                        <? if ( $arryBOM[0]['serial_Num'] !='') { ?>
                                                &nbsp&nbsp&nbsp&nbsp<a  class="fancybox slnoclass2 fancybox.iframe" href="BillSerial.php?id=<?= $_GET['bc'] ?>&sku=<?=$arryBOM[0]['Sku']?>&total=<?=$arryBOM[0]['disassembly_qty']?>&serial_value_sel=<?=$arryBOM[0]['serial_Num']?>&view=1" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  View S.N</a>
                                                 
                                            <? } ?>
                        
                        
                        </td>
                    </tr>

                     <tr style="display:none;">
                        <td width="31%" align="right"   class="blackbold" > Total Cost:   </td>
                        <td width="69%" height="30" align="left">
                         <?=$arryBOM[0]['unit_cost']?></td>
                    </tr>
					<tr>
                        <td width="31%" align="right"   class="blackbold" > Status:   </td>
                        <td width="69%" height="30" align="left">

			  <?php if($arryBOM[0]['Status']==2){
				$Status = "Completed";
				}else{
				$Status = "Parked";
				}
						?>
                         <?=$Status?></td>
                    </tr>



</table>

	 </td>
</tr>



<tr>
	 <td colspan="2" align="left" class="head" >Component Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/disassemble_item_view.php");?>
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
