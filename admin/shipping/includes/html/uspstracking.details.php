<h2>Tracking Information for <?php echo $trackId; ?></h2>
<?php
if(!empty($StatusCode)){	

	 
	?>

<table cellspacing="1" cellpadding="3" width="100%" align="center"
	id="list_table">
	<tbody>
		<tr align="left">
			<td align="center" class="head1">Status:</td>
			<td align="center" class="head1">Shipper Number:</td>
			<td align="center" class="head1">Ship to Address:</td>
			<td align="center" class="head1">Service:</td>
			<td align="center" class="head1">DATE[SENDING]</td>
		
		</tr>
		
		<tr bgcolor="#FFFFFF" align="left" class="evenbg">

		<td align="center"> <?=$arrayDetail['TrackInfo']['TrackSummary']['Event']?></td>
		<td align="center"></td>
		<td align="center">
<?
echo $arrayDetail['TrackInfo']['DestinationCity'].', '.$arrayDetail['TrackInfo']['DestinationState'].' - '.$arrayDetail['TrackInfo']['DestinationZip'];
?>
		
		
		</td>
		<td align="center">
		
		</td>
		
		<td align="center"><?=$arrayDetail['TrackInfo']['TrackSummary']['EventDate']?></td>

				
		</tr>
	</tbody>
</table>
<?php } else { echo '<div align="center" class="redmsg">Tracking number not valid.</div>';}?>
