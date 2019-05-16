<?php 
$ShippInfoAmount=0;
if(!empty($arryShipStand['ModuleType']) && !empty($arryShipStand['RefID'])){
	$arryShippInfo = $objConfig->getStandaloneShipmentByID($arryShipStand['ModuleType'], $arryShipStand['RefID']);
	$ShippInfoAmount = $objConfig->getTotalShippingAmount($arryShipStand['ModuleType'], $arryShipStand['RefID']);
}

if(!empty($arryShippInfo[0]['ShippingCarrier'])){
	$arryShippInfo[0]['totalFreight'] = $arryShippInfo[0]['TotalFreight'];
	$arryShippInfo[0]['ShipType'] = $arryShippInfo[0]['ShippingCarrier'];
	$arryShippInfo[0]['trackingId'] = $arryShippInfo[0]['TrackingID'];
	$arryShippInfo[0]['sendingLabel'] = $arryShippInfo[0]['SendingLabel'];
	$arryShippInfo[0]['label'] = $arryShippInfo[0]['Label'];
	$arryShippInfo[0]['createdDate'] = $arryShippInfo[0]['CreatedDate'];
}

if(!empty($arryShippInfo[0]['totalFreight'])){

	/*if($CurrentDepID!=3){
		$WarehousePrefix = '../warehouse/';
	}*/
	$WarehousePrefix = '../shipping/';
	$LabelFolder = strtolower($arryShippInfo[0]["ShipType"])."/";
	$LabelPath = $WarehousePrefix."upload/".$LabelFolder.$_SESSION['CmpID']."/";	

	/*********Start International Document ********************/
	$tableName=strtolower($arryShippInfo[0]["ShipType"]).'_service_type'; 
	$serValue=$arryShippInfo[0]['ShippingMethod'];
	if(!empty($serValue)){
		$strSQLQuery = "select * from ".$Config['DbMain'].".".$tableName." where service_value = '".$serValue."'";
		$arryInter = $objConfig->query($strSQLQuery,1);
	} 
	/*********Start International Document end ****************/
?>
<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall standalone-ship">
			<tr>
				<td colspan="4" align="left" class="head" id="">Shipping Details</td>
			</tr>
			<tr>
				<td align="right" class="blackbold" valign="top">Shipping Carrier :</td>
				<td align="left" valign="top"  class="green"><b><?=$arryShippInfo[0]['ShipType'];?></b>
				</td>

				<td align="right" class="blackbold">Shipping Method :</td>
			<td align="left"  ><?=$arryInter[0]['service_type']?> </td>

			</td>
			
				 
			</tr>

			<tr>
				<td align="right" class="blackbold" valign="top"  width="20%">Total Freight :</td>
				<td align="left" valign="top"  width="30%"><b><?=$arryShippInfo[0]['totalFreight'];?><b>
				</td>


			<? if(!empty($arryShippInfo[0]['trackingId'])){ ?>
				<td align="right" class="blackbold" valign="top"  width="20%">Tracking Number :</td>
				<td align="left" valign="top">
				
				<?php 
				if($arryShippInfo[0]["ShipType"]=='FedEx'){
					
					echo "<a href='".$WarehousePrefix."tracking.details.php?view=".$arryShippInfo[0]["trackingId"]."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";
					
				}elseif ($arryShippInfo[0]["ShipType"]=='UPS'){
					echo "<a href='".$WarehousePrefix."upstracking.details.php?view=".$arryShippInfo[0]["trackingId"]."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";
					
				}elseif($arryShippInfo[0]["ShipType"]=='DHL'){
					
					echo "<a href='".$WarehousePrefix."dhltracking.details.php?view=".$arryShippInfo[0]["trackingId"]."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";
					
				}elseif($arryShippInfo[0]["ShipType"]=='USPS'){

echo "<a href='".$WarehousePrefix."uspstracking.details.php?view=".$arryShippInfo[0]["trackingId"]."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";

}
				?>
		
					
					</td>

			<? } ?>
				 

			</tr>

			<tr>
				
				

				<td align="right" class="blackbold" valign="top">Created Date :</td>
				<td align="left" valign="top"><?=date($Config['DateFormat'], strtotime($arryShippInfo[0]['createdDate']));?>

				</td>

				<td align="right" class="blackbold">COD :</td>
				<td align="left"  ><?php if($arryShippInfo[0]['COD']==1){echo "Yes";}else{echo "No";}?></td>

				</td>
			</tr>

			

			<tr>

<?   if(IsDocExist($LabelPath, $LabelFolder, $arryShippInfo[0]['label']) ){ ?>
				<td align="right" class="blackbold"  >Shipmaster Label :</td>
				<td align="left" >

<a href="<?=GetDocUrl($LabelPath, $LabelFolder, $arryShippInfo[0]['label'])?>" target="_blank"><?=$arryShippInfo[0]['label'];?></a> 

<? if(!empty($arryShippInfo[0]['trackingId']) && empty($arryShippInfo[0]['PostToGL']) ){?>
  &nbsp;&nbsp;&nbsp;&nbsp;	


<?
if($arryShippInfo[0]["ShipType"]=='FedEx'){				
 	$VoidLink = '../shipping/voidShipmentFedex.php';					
}elseif ($arryShippInfo[0]["ShipType"]=='UPS'){
 	$VoidLink = '../shipping/voidShipmentUps.php';
}

if(!empty($_GET['view']) && !empty($VoidLink) && empty($HideVoid)){
	$VoidLink .= '?trackingId='.$arryShippInfo[0]['trackingId'].'&view='.$_GET['view'].'&Module='.$arryShipStand['ModuleType'];
?>

<a href="<?=$VoidLink?>" onclick="return confirmAction(this, 'Void Shipment', 'Are you sure you want to void this shipment?')" class="action_bt" >VOID</a> 
	<? } } ?>

				</td>
<? } ?>





<?  if(IsDocExist($LabelPath, $LabelFolder, $arryShippInfo[0]['sendingLabel']) ){ ?>
		<td align="right" class="blackbold"  >COD Return Label :</td>
			<td align="left"  >
			<a href="<?=GetDocUrl($LabelPath, $LabelFolder, $arryShippInfo[0]['sendingLabel'])?>"
				target="_blank"><?=$arryShippInfo[0]['sendingLabel'];?></a>
		</td>						
<? } ?>	


			</tr>


		<?   if($arryShippInfo[0]['LabelChild'] !='' ){  ?>
			<tr>
						<td align="right" class="blackbold"  valign="top" >Child Labels :</td>
						<td align="left" >

		<?
			$LabelChildArry = explode("#",$arryShippInfo[0]['LabelChild']);
			foreach($LabelChildArry as $childlabel)
			if(IsDocExist($LabelPath, $LabelFolder, $childlabel) ){
		?>

				<a href="<?=GetDocUrl($LabelPath, $LabelFolder, $childlabel)?>" target="_blank"><?=$childlabel?></a> <br>
			 <? } ?>

				</td>
		</tr>
		<? } ?>




<? 	/*********Start International Document ****************/

	/*$strSQLQuery = "select service_value from ".$Config['DbMain'].".fedex_service_type where service_value like '%International%'";
	$arryInter = $objConfig->query($strSQLQuery,1);
	foreach($arryInter as $keyi=>$valuesi){
		$InternationArray[] = $valuesi['service_value'];
	}
	if(in_array($arryShippInfo[0]['ShippingMethod'],$InternationArray)){*/

	if(!empty($arryInter[0]['service_check'])){
?>
		<tr>
			 
		<td align="right" class="blackbold">International Document :</td>
			<td align="left"  ><a href="<?=$WarehousePrefix?>pdfInternational_stand_alone.php?ShippedID=<?=$arryShipStand['RefID']?>&Module=<?=$arryShipStand['ModuleType']?>" class="download" target="_blank">Download</a></td>
 
			</td>



			<?php 

			if($ShippInfoAmount>=2500){ //2500 ?>
			
		    <td align="right" class="blackbold">SED Document:</td>
<td align="left"  ><a href="<?=$WarehousePrefix?>pdfSed_stand_alone.php?ShippedID=<?=$arryShipStand['RefID']?>&Module=<?=$arryShipStand['ModuleType']?>" class="download" target="_blank">Download</a></td>

			</td>
				
			<?php } ?>


			
		</tr>
	<? }//end ?>




		</table>

<?php } ?>
