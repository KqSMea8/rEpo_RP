<? 

if($Config['SalesCommission']==1){	
	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); 
	
?>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" >


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 <tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>
<tr>
       		 <td colspan="2" height="30">&nbsp;</td>
        </tr>	


<tr>
        <td align="right" width="45%"  class="blackbold" valign="top" height="30">
		Sales Person Type  :</td>
    <td align="left" valign="top" >

<?=$arrySalesCommission[0]['SalesPersonType']?> 	

	
	</td>
  </tr>	 	


	  <tr>
				<td  align="right" class="blackbold"  valign="top" height="30">Commission Tier :</td>
				<td align="left" valign="top">

<? if($arrySalesCommission[0]['Percentage']>0){ ?>
<?=$arrySalesCommission[0]['Percentage']." %  on sale of : ".$arrySalesCommission[0]['RangeFrom']." - ".$arrySalesCommission[0]['RangeTo']." ".$Config['Currency'].""?>
<? }else {echo "None"; } ?>
			

	</td>
			  </tr>	
					
	 <tr>
				<td align="right" class="blackbold" height="30" valign="top">
				Spiff Amount   :
				
				</td>
				<td  align="left"  valign="top">

			<?
			if(!empty($arrySalesCommission[0]['SpiffAmount'])){
				$SpiffAmount = $arrySalesCommission[0]['SpiffAmount'].' '.$Config['Currency'];
			}else{
				$SpiffAmount = 'None';
			}
			echo $SpiffAmount;
			?>
					
					

		</td>
	</tr>

	<tr>
				<td align="right" class="blackbold" height="30" valign="top">
				Sales Target for Spiff Amount  :
				
				</td>
				<td  align="left" valign="top" >	
			<?
			if(!empty($arrySalesCommission[0]['SpiffTarget'])){
				$SpiffTarget = $arrySalesCommission[0]['SpiffTarget'].' '.$Config['Currency'];
			}else{
				$SpiffTarget = 'None';
			}
			echo $SpiffTarget;
			?>
				
				

		</td>
	</tr>

       <tr>
       		 <td colspan="2" height="30">&nbsp;</td>
        </tr>	
	
</table>	
  




	
	  
	
	</td>
   </tr>

  
   </form>
</table>
<? } ?>

