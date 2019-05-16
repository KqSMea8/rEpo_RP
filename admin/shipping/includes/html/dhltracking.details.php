
<h2>Tracking Information for :<?php echo $trackId; ?></h2>

<?php
if($arrayDetail['AWBInfo'][0]['Status']['ActionStatus']=='success'){

	//echo '<pre>';print_r($arrayDetail);exit;
	?>

<table cellspacing="1" cellpadding="3" width="100%" align="center"
	id="list_table">
	<tbody>
		<tr align="left">
			<td align="center" class="head1">Status:</td>
			<td align="center" class="head1">Origin</td>
			<td align="center" class="head1">Destination</td>
			<td align="center" class="head1">Shipper Name:</td>
			<td align="center" class="head1">Consignee Name:</td>
			<td align="center" class="head1">Shipment Date</td>
			<td align="center" class="head1">Weight/Unit</td>
			<td align="center" class="head1">Pieces</td>

		</tr>

		<tr bgcolor="#FFFFFF" align="left" class="evenbg">
			<td align="center"><?php echo ucfirst($arrayDetail['AWBInfo'][0]['Status']['ActionStatus']);?></td>
			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['OriginServiceArea']['Description'];?></td>
			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['DestinationServiceArea']['Description'];?></td>
			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ShipperName'];?></td>
			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ConsigneeName'];?></td>


			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['ShipmentDate'];?></td>
			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['Weight'];?>/<?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['WeightUnit'];?></td>
			<td align="center"><?php echo $arrayDetail['AWBInfo'][0]['ShipmentInfo']['Pieces'];?></td>

		</tr>
	</tbody>
</table>

			<?php } else { echo '<div align="center" class="redmsg">Tracking number not valid</div>';}?>

