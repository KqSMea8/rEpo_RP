<? 
if($Config['SalesCommission']==1){	
	$_GET['AssignTo'] = $EmpID;
	$arryTerritoryAssign = $objTerritory->GetTerritoryAssign($_GET); 

?>

	

<table width="100%" border="0" cellpadding="5" cellspacing="0" 
<? if($Dashboard!=1) echo 'class="borderall"'; ?>  class="normal">
<? if(!empty($SubHeading)){ ?> 
<tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>
<? } ?>


<tr>
       		 <td colspan="2" height="20">&nbsp;</td>
        </tr>	
<tr>
	<td  align="right"  width="45%" valign="top"  >Territory :</td>
	<td align="left" valign="top">

<? if(!empty($arryTerritoryAssign[0]['TerritoryID'])){
  	$arrySubTerritory = $objTerritory->GetTerritoryMulti($arryTerritoryAssign[0]['TerritoryID']); 
        foreach ($arrySubTerritory as $key => $values) {
		$arryParentTerritory = $objTerritory->GetTerritoryMulti($values['ParentID']); 
		echo stripslashes($arryParentTerritory[0]['Name']).' -> '.stripslashes($values['Name']).'<br>';
	}
   }else{
	echo NOT_ASSIGNED;
   }

 ?>

	</td>
  </tr>	 

<? if(!empty($arryTerritoryAssign[0]['TerritoryID'])){ ?>
<tr>
        <td align="right" class="blackbold" valign="top">
		Assign Type  :</td>
    <td align="left" valign="top" >
 	<?=$arryTerritoryAssign[0]['AssignType']?> 
	</td>
  </tr>	

	<? if($arryTerritoryAssign[0]['AssignType'] == "Sales Person"){ ?>
	<tr>
	<td align="right"   class="blackbold">Manager : </td>
	<td  align="left">   
		<?=$arryTerritoryAssign[0]['ManagerName']?> 
	</td>
	</tr>	
	<? }?>

	 
<? }?>

<tr>
       		 <td colspan="2" height="20">&nbsp;</td>
        </tr>	
	

	
</table>	
  




	
	
<? } ?>

