<?php 
if(!empty($response->TrackDetails->CarrierCode)){

//echo '<pre>';print_r($response);exit;
?>

<!--table cellspacing="1" cellpadding="3" width="100%" align="center"
	id="list_table">
	<tbody>
		<tr align="left">
			<td align="left"   colspan="5"><strong>Tracking Number# <?php echo $response->TrackDetails->TrackingNumber;?></strong></td>
			 
		</tr>
		<tr align="left">
			 
			<td align="center" class="head1" width="15%">Service</td>
			<td align="center" class="head1"  >Status</td>
			<td align="center" class="head1" width="15%">Weight[LB]</td>
			<td align="center" class="head1" width="15%">Date [SENDING]</td>
			<td align="center" class="head1" width="15%">Date [RECEIVING]</td>
		</tr>
		
		<tr bgcolor="#FFFFFF" align="left" class="evenbg">
			 
			<td align="center"><?php echo $response->TrackDetails->ServiceInfo;?></td>
			<td align="center">
<?php echo $response->TrackDetails->StatusDescription;?><br>
<?php echo $response->TrackDetails->ServiceCommitMessage;?>

</td>
			<td align="center"><?php echo $response->TrackDetails->ShipmentWeight->Value;?></td>
			<td align="center"><?php if($response->TrackDetails->ShipTimestamp>0)echo date('d/m/Y', strtotime($response->TrackDetails->ShipTimestamp));?></td>
			<td align="center"><?php if($response->TrackDetails->ActualDeliveryTimestamp>0)echo date('d/m/Y', strtotime($response->TrackDetails->ActualDeliveryTimestamp));?></td>
				
		</tr>
	</tbody>
</table -->
	

<table cellspacing="0" cellpadding="5" border="0" width="100%" class="borderall">
			<tbody>
<tr>
				<td align="left" class="head" colspan="4">Tracking Details</td>
			</tr>

<tr>
        <td align="right" width="20%" class="blackbold"> Tracking number: </td>
        <td align="left" width="30%">
 <?php echo $response->TrackDetails->TrackingNumber;?>
        </td>

	<td align="right" width="20%" class="blackbold">Service : </td>
	<td align="left"><?php echo $response->TrackDetails->ServiceInfo;?> </td>


  </tr>
<tr>
        <td align="right"  class="blackbold"> Invoice#: </td>
        <td align="left"  >
 <?php echo $response->TrackDetails->OtherIdentifiers[0]->Value;?> 
        </td>

	<td align="right"   class="blackbold">PO#: </td>
	<td align="left"> <?php echo $response->TrackDetails->OtherIdentifiers[1]->Value;?>  </td>

  </tr>

<tr>
        <td align="right" width="20%" class="blackbold"> Status: </td>
        <td align="left" width="30%">
 <?php echo $response->TrackDetails->StatusDescription;?>
        </td>

	<td align="right" width="20%" class="blackbold">Dimensions : </td>
	<td align="left"><?php echo $response->TrackDetails->PackageDimensions->Length;?> x <?php echo $response->TrackDetails->PackageDimensions->Width;?> x <?php echo $response->TrackDetails->PackageDimensions->Height;?> <?php echo $response->TrackDetails->PackageDimensions->Units;?> . </td>

  </tr>



<tr>
        <td align="right" width="20%" class="blackbold"> Weight: </td>
        <td align="left" width="30%">
 <?php echo $response->TrackDetails->PackageWeight->Value;?> <?php echo $response->TrackDetails->PackageWeight->Units;?>
        </td>

	<td align="right" width="20%" class="blackbold">Packaging: </td>
	<td align="left"><?php echo $response->TrackDetails->Packaging;?> </td>

  </tr>





		</tbody></table>

<?php } else { echo '<div align="center" class="redmsg">'.$ermsg.'</div>';}?>








