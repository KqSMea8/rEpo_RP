<? 

if($Config['SalesCommission']==1){
	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); ?>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" >


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 <tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>

<tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>	

 <tr>
			<td  align="right" class="blackbold" width="45%">Sales Commission :</td>
			<td align="left">

			<?
			if($arrySalesCommission[0]['CommType']=="Percentage"){
				$Commission = $arrySalesCommission[0]['CommPercentage'].'% of Sales';
			}else if($arrySalesCommission[0]['CommType']=="Fixed"){
				$Commission = $arrySalesCommission[0]['CommAmount'].' '.$Config['Currency'];
			}else{
				$Commission = 'None';
			}
			echo $Commission;
			?>


			</td>
		 </tr>

<? if(!empty($arrySalesCommission[0]['CommType'])){?>
<tr>
        <td align="right"   class="blackbold" valign="top">
		Sales Target for Commission  :</td>
    <td height="30" align="left" valign="top" >	
	<?=($arrySalesCommission[0]['TargetAmount']>0)?($arrySalesCommission[0]['TargetAmount'].' '.$Config['Currency']):('None')?>
	</td>
  </tr>	 
<? } ?>



 <tr>
       		 <td colspan="2" height="50">&nbsp;</td>
        </tr>
       
	
</table>	
  




	
	  
	
	</td>
   </tr>

  
   </form>
</table>
<? } ?>

