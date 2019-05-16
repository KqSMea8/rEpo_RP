<?
$arrySalesCommission = $objSupplier->GetsalesCommission($_GET['view']);
$TabName = ucfirst($_GET["tab"]);
$NumSaleCommision = sizeof($arrySalesCommission);
?>
<tr>
       		 <td colspan="2" align="left"   class="head"><?=$TabName?> Commission </td>
        </tr>   
<? if($NumSaleCommision>0){ 
?>
<tr><td>


 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
		<td  align="right"   class="blackbold" width="45%"> Sales Structure  : </td>
		<td   align="left" >
		<?=(!empty($arrySalesCommission[0]['CommType']))?(stripslashes($arrySalesCommission[0]['CommType'])):(NOT_SPECIFIED)?>
		</td>
	</tr>
<? if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //start commission ?>

<? if($arrySalesCommission[0]['SalesStructureType']==1){ ?>
<tr>
        <td align="right"   valign="top"    >
		Sales Person Type  :</td>
    <td align="left" valign="top" >

<?=$arrySalesCommission[0]['SalesPersonType']?> 	

	
	</td>
  </tr>	 	
<? } ?>




	  <tr>
		<td  align="right"   valign="top" >Commission On :</td>
		<td align="left" valign="top">
<?
$CommOn = $arrySalesCommission[0]['CommOn'];
if($CommOn  == "1"){
	echo 'Per Invoice Payment';
}else if($CommOn  == "2"){
	echo 'Margin';
}else{
	echo 'Total Amount';
		
}

 


?>			

		</td>
	</tr>

<tr>
	<td  align="right" class="blackbold"  valign="top">Commission Paid On : </td>
	<td align="left">
		<?=$arrySalesCommission[0]['CommPaidOn']?> 
 </td>
</tr>

<tr>
	<td  align="right" class="blackbold"  valign="top">Commission Type : </td>
	<td align="left">
		
<? if(!empty($arrySalesCommission[0]['CommissionType'])){ ?>
<?=$arrySalesCommission[0]['CommissionType']?>
<? }else {echo "Monthly"; } ?>
 </td>
</tr>

<tr>
		<td  align="right"   valign="top" >Commission Tier :</td>
		<td align="left" valign="top">

<? if($arrySalesCommission[0]['Percentage']>0){ ?>
<?=$arrySalesCommission[0]['Percentage']." %  on Range : ".$arrySalesCommission[0]['RangeFrom']." - ".$arrySalesCommission[0]['RangeTo'].""?>
<? }else {echo "None"; } ?>
			

		</td>
	</tr>
<tr>
	<td align="right" class="blackbold" valign="top" >
	Commission  Percentage :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['CommPercentage'])?> % &nbsp;&nbsp;&nbsp;&nbsp;	
	<?
	if($arrySalesCommission[0]['TargetFrom']!='' && $arrySalesCommission[0]['TargetTo']!='')
	{
		$TargetFrom = $arrySalesCommission[0]['TargetFrom'];
		$TargetTo = $arrySalesCommission[0]['TargetTo'];
		#if($TargetTo==0) $TargetTo=$arrySalesCommission[0]['RangeFrom'];
		echo '[ Range: '.$TargetFrom.' - '.$TargetTo.' ]';
	}
	?>
	</td>
</tr>
<tr>
        <td align="right"  valign="top" >
		Accelerator  :</td>
    <td align="left" valign="top" >
<?=$arrySalesCommission[0]['Accelerator']?>	

<? if($arrySalesCommission[0]['Accelerator']=="Yes"){
	
	echo '&nbsp;&nbsp;[ '.$arrySalesCommission[0]['AcceleratorPer'].'% ]';	
	
 } ?>

	</td>
  </tr>	
<? } ?>


<? if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  



	if($arrySalesCommission[0]['CommType']=="Spiff" && $arrySalesCommission[0]['SpiffOn']=="1"){
 ?>


	<tr>
        <td align="right" class="blackbold" valign="top" width="45%">
		Spiff On  :</td>
    <td align="left" valign="top" >
 Per Invoice 	
	</td>
  </tr>	

  <tr  >
	<td  align="right" class="blackbold"  valign="top">Commission Paid On : </td>
	<td align="left">
<?=$arrySalesCommission[0]['CommPaidOn']?>  
 </td>
</tr>

	<? }else{ ?>


<tr>
	<td  align="right"   valign="top"  >
Spiff Type :
	</td>
	<td align="left" valign="top" >
	<?php if($arrySalesCommission[0]['SpiffType']=="one"){ echo 'One Time';}else{ echo 'Recurring';} ?>
	</td>
</tr>
<tr>
	<td align="right" class="blackbold" valign="top" >
Spiff Based On :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['spiffBasedOn'])?> 
	</td>
</tr>
<? if($arrySalesCommission[0]['spiffBasedOn']=='Customer'){?>
<tr>
	<td align="right" class="blackbold" valign="top" >
Amount Type :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['amountType'])?> 
	</td>
</tr>


<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Amount :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['SpiffEmp'])?> 	
<? if($arrySalesCommission[0]['amountType']!="Percentage") echo $Config['Currency']; ?>
 
	</td>
</tr>
<? } 
	}
 } ?>
 
      </table>


</tr></td>
<?php  } else{ ?>
<tr>
       		 <td colspan="2" height="300" align="center"><?=NOT_SPECIFIED?></td>
        </tr>
<? } ?>


