<?php
	require_once($Prefix."classes/warehouse.class.php");

	$objWarehouse 		= 	new Warehouse();	
	$binlocation_listted 	= 	$objWarehouse->getBindata($_GET['view']); 


?>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

		<form name="form1" action=""  method="post" onSubmit="return validateLead(this);" enctype="multipart/form-data">
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                                <?php  foreach($binlocation_listted as $bin_data): ?>
				<tr><td colspan="2" align="left" class="head">Manage Bin Details</td></tr>
                                <?php
					$warehouse_listted 	= 	$objWarehouse->getWarehousedata($bin_data['warehouse_id']);	 
					foreach($warehouse_listted as $warehouse_data): ?>					
					
						<tr>
							<td  align="right"   class="blackbold" width="40%"> Warehouse Code  :</td>
							<td   align="left" ><?php echo $warehouse_data['warehouse_code']?></td>
						</tr>
						<tr>
							<td  align="right"   class="blackbold"> Warehouse Name  : </td>
							<td   align="left" ><?php echo $warehouse_data['warehouse_name']; ?></td>
						</tr>
                        		<?php endforeach; ?>
						<tr>
							<td  align="right"   class="blackbold"> Bin Location  :</td>
							<td   align="left" ><?php echo $bin_data['binlocation_name']; ?></td>
						</tr>
						<tr>
							<td  align="right"   class="blackbold"> Description  :</td>
							<td   align="left" ><?php echo $bin_data['description']; ?></td>
	</tr>
                                 <?php endforeach; ?>
			</table>			
			</td>
		</tr>

		<tr>
			<td align="left" valign="top">&nbsp;</td>
		</tr>

		<tr>
			<td  align="center">
			<div id="SubmitDiv" style="display:none">
				<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>

				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
				<input type="hidden" name="binid" id="binid" value="<?=$_GET['edit']?>" />
				

			</div>
			</td>
		</tr>
		</form>
	</table>
<script>
 function popSn(vl) {
//alert(vl);
				document.getElementById(vl).style.display = 'block';
			}
			function hide(vl) {
				document.getElementById(vl).style.display = 'none';
			}
			//To detect escape button
			document.onkeydown = function(evt) {
				evt = evt || window.event;
				if (evt.keyCode == 27) {
					hide(vl);
				}
			};
function closeSN(vl){
//alert(vl);

			//alert("hiii");
			document.getElementById(vl).style.display = 'none';
		

}
	

</script>
