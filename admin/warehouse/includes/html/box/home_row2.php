
<div class="rows clearfix">
         <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block alerts">
		
                <h3>Shipment By Month</h3>
		
		<div class="chartdiv" style="width:380px;">
			<select name="chartSO" id="chartSO" class="chartselect" onchange="Javascript:showChart(this);">
				<option value="pSOChart:bSOChart">Pie Chart</option>
				<option value="bSOChart:pSOChart">Bar Chart</option>
			</select>				
			<img src="barSO.php" id="bSOChart" style="display:none">
			<img src="pieSO.php" id="pSOChart" style="padding:10px;">
		</div>
			
            </div>
          </div>
	


          <div class="second_col" style="display:none3;<?=$WidthRow2?>">
            <div class="block listing">
              <h3>Shipment</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/				
				$_GET['Status'] = '';
				$_GET['Limit'] = '10';
				$arryShipment=$objShipment->ListShipment($_GET);
				/********************/
				
				if(sizeof($arryShipment)>0){ 
					 foreach($arryShipment as $key=>$values){
			
				?>
				<tr>
                  <td width="15%"><a target="_blank" href="vShipment.php?view=<?=$values['OrderID']?>&ship=<?=$values['ShippingID'];?>"><?=$values['ShippingID']?></a></td>
				  <td width="30%">
					<? if($values['ShipmentDate']>0) 
					   echo date($Config['DateFormat'], strtotime($values['ShipmentDate']));
					?></td>
				  
				  <td width="15%"><?=stripslashes($values['RefID'])?></td>
					
					<td width="15%"><?=stripslashes($values['TotalAmount'])?></td>
					<td width="19%"><?=stripslashes($values['CustomerCurrency'])?></td>
					     <td align="center">
				<?
				if($values['ShipmentStatus'] == 'Shipped'){
					$cls ='green';
				}else{
					$cls ='red';
				}
				?>
				<span class="<?=$cls?>"><?=$values['ShipmentStatus']?></span>
					 
					</td>
						
					
                </tr>  
			
				<? }
				
				
				
				?>
	<tr>
                           <td colspan="2">
                           <a href="viewShipment.php">More...</a>
                           </td>
                           </tr>				
					
				<?}else{ ?>
				 <tr>
                  <td align="center" height="60"><div class="red" align="center"><?=NO_RECORD?></div></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>	  
</div>
