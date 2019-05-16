<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >	

	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	<?php foreach($binlocation_listted as $bindata):

		
	$warehouse_listted 	= 	$objWarehouse->getWarehousedata($bindata['warehouse_id']);	 
		
	foreach($warehouse_listted as $warehouse_data): ?>
				<tr>
					<td colspan="2" align="left" class="head">Warehouse Details</td>
				</tr>

				<tr>
					<td  align="right"   class="blackbold" width="40%"> Warehouse Code  : </td>
					<td   align="left" ><?php echo stripslashes($warehouse_data['warehouse_code']); ?>

					<input name="warehouse_code" type="hidden" class="inputbox" id="warehouse_code" value="<?php echo stripslashes($warehouse_data['warehouse_code']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');" onBlur="Javascript:CheckAvailField('MsgSpan_Display','warehouse_code','<?=$_GET['edit']?>');"/>

					<span id="MsgSpan_Display"></span>
					</td>
				</tr>
				<tr>
					<td  align="right"   class="blackbold"> Warehouse Name  :</td>
					<td   align="left" ><?php echo stripslashes($warehouse_data['warehouse_name']); ?>
					<input name="warehouse_name" type="hidden" class="inputbox" id="warehouse_name" value="<?php echo stripslashes($warehouse_data['warehouse_name']); ?>"  maxlength="50" />            </td>
				</tr>
		 <?php endforeach; ?>  

				<tr>
					<td  align="right"   class="blackbold"> Bin Location  : </td>
					<td   align="left" >
					<input name="BinLocation" type="text" class="inputbox" id="BinLocation" value="<?php echo stripslashes($bindata['binlocation_name']); ?>"  maxlength="50" />            </td>
				</tr>
				<tr>
					<td  align="right"   class="blackbold" 
						>Status  : </td>
					<td   align="left"  >
					  <? 
						  	 $ActiveChecked = ' checked';
							 if($_REQUEST['edit'] > 0){
								 if($bindata['status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
								 if($bindata['status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
							}
						  ?>
					  <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
					  Active&nbsp;&nbsp;&nbsp;&nbsp;
					  <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
					  InActive </td>
				</tr>

	<?php endforeach; ?>	 
	</table>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td  align="center">
			<div id="SubmitDiv" style="display:none1">
				<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
				<input type="hidden" name="binid" id="binid" value="<?=$_GET['edit']?>" />
			</div>
		</td>
	</tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
