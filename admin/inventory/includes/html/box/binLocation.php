<? /****************************************************/ ?>

 
<tr>
	 <td colspan="2" align="left"  class="head" >Warehouse/Bin Location</td>
     
</tr>
	<tr>
	<td align="right" class="blackbold" > WareHouse :<span class="red">*</span> </td>
	<td align="left" >
	 <select name="warehouse" id="warehouse" class="inputbox" onchange="return filterwarehouse(this.value);">
						<option value="">--Select--</option>
						<?php foreach($arryWarehouse as $warehouse_data): ?>
							<option value="<?php echo $warehouse_data['WID']; ?>" <?if($warehouse_data['WID'] == $_GET['WID']){ echo "selected";}?>><?php echo $warehouse_data['warehouse_name']; ?></option>
						<?php endforeach; ?>
				</select>          </td>
	</tr>
                    <tr>
                      <td  align="right" valign="top" class="blackbold"> 
					  Bin Location :<span class="red">*</span> </td>
                      <td   align="left" valign="top">   
	 <select name="bin_location" id="bin_location" class="inputbox" >
		<option value="">--Select--</option>
		<?php if(!empty($arryBin)){ 
		foreach($arryBin as $Bin): ?>
			<option value="<?php echo $Bin['binid']; ?>" <?if($Bin['binid'] == $_GET['WID']){ echo "selected";}?>><?php echo $Bin['binlocation_name']; ?></option>
		<?php endforeach; 
		 }
		?>

	</select>      


<script>
$("#bin_location").select2();
</script> 


</td>
	 
	
                        </tr>
	<tr>
	<td align="right" class="blackbold" > Condition :<span class="red">*</span> </td>
	<td align="left" >
	 <select name="QTID" id="QTID" class="inputbox" >
						<option value="">--Select--</option>
						<?php foreach($arryQtyCond as $cond_data): ?>
							<option value="<?php echo $cond_data['ID']; ?>" <? if($cond_data['ID'] == $_GET['WID']){ echo "selected";}?>><?php echo $cond_data['condition']; ?></option>
						<?php endforeach; ?>
				</select>          </td>
	</tr>
						
                    
                     



   


   <tr>
    <td  colspan="2"  align="center" >
	<br />
<div id="SubmitDiv" style="display:none1">
	
<?  $ButtonTitle =  ' Submit ';?>
   
   	<input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />

	<input  name="item_Sku" id="item_Sku" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="hidden"/>
   <input name="Submit" type="submit" class="button" id="Submit" value=" <?= $ButtonTitle ?> " />&nbsp;

</div>




</td>
   </tr>


	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
	<tbody>
	<tr>
	<td class="head1">Warehouse</td>
	<td class="head1">Bin Location</td>
	<td class="head1">Condition</td>
	<td class="head1">Quantity</td>
<td class="head1">Action</td>
	

	</tr>
	<?php if (count($arryWbin) > 0) {
$i=0;
	foreach ($arryWbin as $ItemBin) {
$i++;

$warehouseQtyCond=$objItem->GetConWarehouseQty($arryProduct[0]['Sku'],$ItemBin['WID'],$ItemBin['condition']);
	?>
	<tr class="evenbg" bgcolor="#ffffff" align="left">
	<td ><?=$ItemBin['warehouse_name']?></td>
	<td ><?=$ItemBin['binlocation_name']?></td>
<td ><?=$ItemBin['condition']?></td>
<td ><?=$warehouseQtyCond?></td>
<td><a href="editItem.php?delete_Sid=<? echo $ItemBin['id']; ?>&edit=<?=$_GET['edit']?>&CatID=<?php echo $_GET['CatID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=<?=$_GET['tab']?>" onClick="return confDel('Item')"  ><?= $delete ?></a></td>
	
	
	</tr>
	<?php  }
	} else {
	?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
	<td class="no_record" colspan="7">No Records Found.</td>

	</tr>
	<?php } ?>
	</tbody>
	</table>
	</td>
	</tr>

