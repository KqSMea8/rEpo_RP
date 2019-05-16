<h2>Tracking Information for <?php echo $trackingNumber; ?></h2>

<?php 
if(empty($ermsg)){

?>
<table cellspacing="1" cellpadding="3" width="100%" align="center"
	id="list_table">
	<tbody>
		<tr align="left">
			<td align="center" class="head1">Status:</td>
			<td align="center" class="head1">Shipper Number:</td>
			<td align="center" class="head1">Ship to Address:</td>
			<td align="center" class="head1">Service</td>
			<td align="center" class="head1">DATE[SENDING]</td>
		
		</tr>
		
		<tr bgcolor="#FFFFFF" align="left" class="evenbg">
			<td align="center"><?php echo $response['TrackResponse']['Shipment']['Package']['Activity']['Status']['StatusType']['Description']['VALUE']; ?></td>
		<td align="center"><?php echo $response['TrackResponse']['Shipment']['Shipper']['ShipperNumber']['VALUE']; ?></td>
		<td align="center">
	
		<?php echo $response['TrackResponse']['Shipment']['ShipTo']['Address']['AddressLine1']['VALUE']; ?>
		<?php echo $response['TrackResponse']['Shipment']['ShipTo']['Address']['AddressLine2']['VALUE']; ?>	
		<?php echo $response['TrackResponse']['Shipment']['ShipTo']['Address']['City']['VALUE']; ?>	
		<?php echo $response['TrackResponse']['Shipment']['ShipTo']['Address']['StateProvinceCode']['VALUE']; ?> 	
		<?php echo $response['TrackResponse']['Shipment']['ShipTo']['Address']['PostalCode']['VALUE']; ?>
		<?php echo $response['TrackResponse']['Shipment']['ShipTo']['Address']['CountryCode']['VALUE']; ?>
		
		
		</td>
		<td align="center">
		
	    <?php //echo $response['TrackResponse']['Shipment']['Service']['Code']['VALUE']; ?>
		<?php echo $response['TrackResponse']['Shipment']['Service']['Description']['VALUE']; ?> 	
		
		</td>
		
		<td align="center"><?php echo date('d/m/Y', strtotime($response['TrackResponse']['Shipment']['PickupDate']['VALUE']));?></td>

				
		</tr>
	</tbody>
</table>

<?php } else { echo '<div align="center" class="redmsg">'.$ermsg.'</div>';}?>
