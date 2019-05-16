<?php 
 
$WarehousePrefix = '../shipping/';

if(!empty($arryShippInfo[0]['ShipType'])){


	/*if($CurrentDepID!=3){
		$WarehousePrefix = '../warehouse/';
	}*/
	
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




if(!empty($arryShippInfo[0]['AccountType'])){	
	if($arryShippInfo[0]['AccountType']==1){		
		$AccountType = 'Customer';		
	}elseif ($arryShippInfo[0]['AccountType']==2){
		$AccountType = 'Shipper';		
	}elseif ($arryShippInfo[0]['AccountType']==3){
		$AccountType = 'Third Party';		
	}else{		
		$AccountType = '';
		
	}

}





if($arryShippInfo[0]['ShipType']=="Customer Pickup"){
	$arryShippInfo[0]['ShipType'] = $arryShippInfo[0]['ShipType'].' ('.$arryShippInfo[0]['CustomerPickupCarrier'].')';
}


?>
<table width="100%" border="0" cellpadding="5" cellspacing="0"
			class="borderall">
			<tr>
				<td colspan="4" align="left" class="head">Shipping Details</td>
			</tr>
			<tr>
				<td align="right" class="blackbold" valign="top">Shipping Carrier :</td>
				<td align="left" valign="top"  class="green"><b><?=$arryShippInfo[0]['ShipType'];?></b>
				</td>

				<td align="right" class="blackbold">Shipping Method :</td>
			<td align="left"  ><? if(!empty($arryInter[0]['service_type'])){ echo $arryInter[0]['service_type']; }?> <? //$arryShippInfo[0]['ShippingMethod55']?></td>

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

 


$ShipNumberLink = "";
if(!empty($arrySale[0]["ShipAccountNumber"])) {
	$ShipNumberLink = "&acc=".$arrySale[0]["ShipAccountNumber"];
}

				if($arryShippInfo[0]["ShipType"]=='FedEx'){
					
					echo "<a href='".$WarehousePrefix."tracking.details.php?view=".$arryShippInfo[0]["trackingId"].$ShipNumberLink."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";
					
				}elseif ($arryShippInfo[0]["ShipType"]=='UPS'){
					echo "<a href='".$WarehousePrefix."upstracking.details.php?view=".$arryShippInfo[0]["trackingId"].$ShipNumberLink."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";
		 			
				}elseif($arryShippInfo[0]["ShipType"]=='DHL'){
					
					echo "<a href='".$WarehousePrefix."dhltracking.details.php?view=".$arryShippInfo[0]["trackingId"].$ShipNumberLink."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";
					
				}elseif($arryShippInfo[0]["ShipType"]=='USPS'){

echo "<a href='".$WarehousePrefix."uspstracking.details.php?view=".$arryShippInfo[0]["trackingId"].$ShipNumberLink."' class='fancybox fancybox.iframe'>".$arryShippInfo[0]['trackingId']."</a>";

}else{
			/**********/
		$trackingIds = explode(",",$arryShippInfo[0]['trackingId']);

		for($i=0;$i<sizeof($trackingIds);$i++){
			echo $trackingIds[$i].' &nbsp; &nbsp;';
		}


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


	<?php if($arryShippInfo[0]['AccountType']!='' && $arryShippInfo[0]['AccountNumber']!=''){?>
			<tr>
				
				<td align="right" class="blackbold" valign="top">Account Type :</td>
				<td align="left" valign="top"><?=$AccountType;?>

				</td>

				<td align="right" class="blackbold">Account Number :</td>
				<td align="left"  ><?=$arryShippInfo[0]['AccountNumber'];?></td>

				</td>
			</tr>
			
			<?php } ?>

			

			<tr>

<?   
if(IsDocExist($LabelPath, $LabelFolder, $arryShippInfo[0]['label']) ){  

	

?>
				<td align="right" class="blackbold"  >Shipmaster Label :</td>
				<td align="left" >

<a href="<?=GetDocUrl($LabelPath, $LabelFolder, $arryShippInfo[0]['label'])?>" target="_blank"><?=$arryShippInfo[0]['label'];?></a> 

<? if(!empty($arryShippInfo[0]['trackingId']) && !empty($_GET['ship'])  && !empty($_GET['view'])  && $arryInvoice[0]['PostToGL']!=1){?>
  &nbsp;&nbsp;&nbsp;&nbsp;	


<?
if($arryShippInfo[0]["ShipType"]=='FedEx'){				
 	$VoidLink = 'deleteShipment.php';					
}elseif ($arryShippInfo[0]["ShipType"]=='UPS'){
 	$VoidLink = 'upsDeleteShipment.php';
}
$VoidLink .= '?trackingId='.$arryShippInfo[0]['trackingId'].'&view='.$_GET['view'].'&ship='.$_GET['ship'].'&batch='.$_GET['batch'];
?>

<a href="<?=$VoidLink?>" onclick="return confirmAction(this, 'Void Shipment', 'Are you sure you want to void this shipment?')" class="action_bt" >VOID</a> 
	<? } ?>

				</td>
<? } ?>





<?  
if(IsDocExist($LabelPath, $LabelFolder, $arryShippInfo[0]['sendingLabel']) ){
 ?>
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
			<td align="left"  ><a href="<?=$WarehousePrefix?>pdfInternational.php?ShippedID=<?=$arryShippInfo[0]['ShippedID']?>" class="download" target="_blank">Download</a></td>

			</td>



			<?php 
			if($arrySale[0]['TotalAmount']>=2500){ //2500 ?>
			
		    <td align="right" class="blackbold">SED Document:</td>
<td align="left"  ><a href="<?=$WarehousePrefix?>pdfSed.php?ShippedID=<?=$arryShippInfo[0]['ShippedID']?>" class="download" target="_blank">Download</a></td>

			</td>
				
			<?php } ?>


			
		</tr>
	<? }//end ?>

	
	<? if($_SESSION['CmpID']=="37" && !empty($arryShippInfo[0]['AesNumber'])){?>
	 <tr>
		<td align="right" class="blackbold"  width="20%">AES Document:</td>
		<td align="left"  ><a href="<?=$WarehousePrefix?>editAES.php?ShippedID=<?=$arryShippInfo[0]['ShippedID']?>"   target="_blank"><?=$arryShippInfo[0]['AesNumber']?></a></td>
	</tr>
	<? } ?>


		</table>

<?php

 }else if(!empty($arryShippInfo[0]['ShippedID'])){

 
/*************************************/
if(!empty($arrySale[0]['ShippingMethod']) && !empty($arrySale[0]['ShippingMethodVal'])){
	
	$serviceTableName=strtolower($arrySale[0]['ShippingMethod']).'_service_type'; 
	$SQLQuery = "select * from ".$Config['DbMain'].".".$serviceTableName." where service_value = '".$arrySale[0]['ShippingMethodVal']."'";
	$arryInterInter = $objConfig->query($SQLQuery,1);
	if($arryInterInter[0]['service_check']==1){ ?>

	<table class="borderall" width="100%" border="0" cellspacing="0" cellpadding="5">
			<tbody><tr>
				<td colspan="4" class="head" align="left">Shipping Details</td>
			</tr>
		
        <tr>
			 
		<td align="right" class="blackbold" width="20%">International Document :</td>
			<td align="left"  ><a href="<?=$WarehousePrefix?>pdfInternational.php?ShippedID=<?=$arryShippInfo[0]['ShippedID']?>" class="download" target="_blank">Download</a></td>

			</td>

			<?php 
			if($arrySale[0]['TotalAmount']>=2500){  ?>
			
		    <td align="right" class="blackbold"  width="20%">SED Document:</td>
<td align="left"  ><a href="<?=$WarehousePrefix?>pdfSed.php?ShippedID=<?=$arryShippInfo[0]['ShippedID']?>" class="download" target="_blank">Download</a></td>

			</td>
				
		  <?php } ?>
		
	</tr>


	<? if($_SESSION['CmpID']=="37" && !empty($arryShippInfo[0]['AesNumber'])){?>
	 <tr>
		<td align="right" class="blackbold"  width="20%">AES Document:</td>
		<td align="left"  ><a href="<?=$WarehousePrefix?>editAES.php?ShippedID=<?=$arryShippInfo[0]['ShippedID']?>"   target="_blank"><?=$arryShippInfo[0]['AesNumber']?></a></td>
	</tr>
	<? } ?>
		
		</tbody>
</table>
<?

	}

}


/*************************************/

} ?>
