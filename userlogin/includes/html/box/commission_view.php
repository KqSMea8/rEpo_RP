<? 

if($Config['SalesCommission']==1){	
	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); 



	
?>


	

<table width="100%" border="0" cellpadding="5" cellspacing="0" 
<? if($Dashboard!=1) echo 'class="borderall"'; ?>  class="normal">
<? if(!empty($SubHeading)){ ?> 
<tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>
<? } ?>



<tr>
	<td  align="right"  width="45%" valign="top"  >&nbsp;&nbsp;Sales Structure :</td>
	<td align="left" valign="top">
<?=(!empty($arrySalesCommission[0]['CommType']))?($arrySalesCommission[0]['CommType']):(NOT_DEFINED)?> 
	</td>
  </tr>	 


<tr>     
    <td colspan="2">
<? if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //start commission ?>
<div id="CommDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
        <td align="right"   valign="top"   width="45%">
		Sales Person Type  :</td>
    <td align="left" valign="top" >

<?=$arrySalesCommission[0]['SalesPersonType']?> 	

	
	</td>
  </tr>	 	


	  <tr>
		<td  align="right"   valign="top" >Commission On :</td>
		<td align="left" valign="top">
<?=($arrySalesCommission[0]['CommOn'] == "0")?("Total Amount"):("Per Invoice Payment");?>			

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

	
	
<?if($arrySalesCommission[0]['Percentage']>0){ ?>
<tr>
        <td align="right"  valign="top" >
		Accelerator  :</td>
    <td align="left" valign="top" >
<?=$arrySalesCommission[0]['Accelerator']?>	

	</td>
  </tr>	

	<? if($arrySalesCommission[0]['Accelerator']=="Yes"){?>
	<tr>
		<td align="right"  valign="top" >
			Accelerator  Percentage :</td>
	    <td align="left" valign="top" >
	<?=$arrySalesCommission[0]['AcceleratorPer']?> % 	

		</td>
	  </tr>	
	<? } ?>

<tr>
        <td colspan="2" height=2>

	</td>
  </tr>	

<? } ?>
</table>
</div>


<? } // end commission ?>



<? if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //start spiff ?>
<div id="SpiffDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
		<td  align="right"   valign="top"  width="45%">Spiff Tier :</td>
		<td align="left" valign="top">

<? if($arrySalesCommission[0]['SpiffAmount']>0){ ?>
<?=$arrySalesCommission[0]['SpiffAmount']." ".$Config['Currency']."  on sale of : ".$arrySalesCommission[0]['SalesTarget']." ".$Config['Currency'].""?>
<? }else {echo "None"; } ?>
			

		</td>
	</tr>


<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Target :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['SpiffTarget'])?>  <?=$Config['Currency']?>	
	</td>
</tr>

<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Amount :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['SpiffEmp'])?> 	<?=$Config['Currency']?>	
	</td>
</tr>




</table>
</div>
<? } // end spiff ?>


	
	</td>
  </tr>	 





<? if($ShowSalesReport==1 && $arrySalesCommission[0]['CommType']!=''){ // to view sales calculation ?>
<tr>  
	<td align="right"  >&nbsp;&nbsp;Total Sales Amount : </td>
	<td align="left"><b><?=round($TotalSales,2).' '.$Config["Currency"]?></b></td>
  </tr>
 <!--tr>  
	<td align="right">&nbsp;&nbsp;Sales Amount for Commission : </td>
	<td align="left"><b><?=round($TotalSalesComm,2).' '.$Config["Currency"]?></b></td>
  </tr>	
 <tr>  
	<td align="right">&nbsp;&nbsp;Sales Amount for Spiff : </td>
	<td align="left"><b><?=round($TotalSalesSpiff,2).' '.$Config["Currency"]?></b></td>
  </tr-->
 <tr>  
	<td align="right">&nbsp;&nbsp;Sales Commission : </td>
	<td align="left"><b><?=round($TotalCommission,2).' '.$Config["Currency"]?></b></td>
  </tr>
			
<? } ?>	

	

	
</table>	
  




	
	
<? } ?>

