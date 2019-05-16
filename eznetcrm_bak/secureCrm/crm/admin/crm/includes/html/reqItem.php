
<div class="had">Additional Items with  SKU: <?=$ParentItem?></div>
<div id="preview_div">

 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <tr align="left"  >
		<td class="heading" width="30%" >SKU</td>
		<td  class="heading" >Description</td>
    		<td width="12%" class="heading" >Qty</td>
	
    </tr>
       <?php 
  if(is_array($arryRequired) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryRequired as $key=>$values){
	$flag=!$flag;
	
	$Line++;		
  ?>
    <tr align="left"  class="itembg">
	<td><?=stripslashes($values["sku"])?></td> 
	<td><?=stripslashes($values["description"])?></td> 
	<td><?=stripslashes($values["qty"])?></td>      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	
  </table>


