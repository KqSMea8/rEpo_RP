<div class="rows clearfix">

		  
		  
          <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block alerts">
              <h3>PO Report</h3>
			
		<div class="chartdiv">
			<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pChart:bChart">Pie Chart</option>
				<option value="bChart:pChart">Bar Chart</option>
			</select>				
			<img src="barD.php" id="bChart" style="display:none">
			<img src="pieD.php" id="pChart" style="padding:10px;">
		</div>


            </div>
          </div>
		  
		  
		  
          <div class="second_col" style="display:none3;<?=$WidthRow2?>">
            <div class="block listing">
              <h3>Open PO</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/
				$_GET['module']='Order'; 
				$_GET['Status'] = 'Open';
				$_GET['Limit'] = '10';
				$_GET['Approved'] = '';
				$_GET['InvoicePaid'] = '';
				$_GET['ToApprove'] = '';
				$arryOpenPO=$objPurchase->ListPurchase($_GET);
				/********************/
				
				if(sizeof($arryOpenPO)>0){ ?>

				<? foreach($arryOpenPO as $key=>$values){

				if(!empty($values["VendorName"])){
					$VendorName = $values["VendorName"];
				}else{
					$VendorName = $values["SuppCompany"];
				}

 ?>
				<tr>
                  <td width="15%"><a href="vPO.php?module=Order&view=<?=$values['OrderID']?>" target="_blank"><?=$values['PurchaseID']?></a></td>
				  <td width="20%">
					<? if($values['OrderDate']>0) 
					   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
					?></td>
				  <td ><?=stripslashes($VendorName)?></td>
				  <td width="20%"><?=$values['TotalAmount']?> <?=$values['Currency']?></td>
				 <td width="8%" style="text-align:right"><a class="action_bt" href="../warehouse/receiptOrder.php?po=<?=$values['OrderID']?>" target="_blank" >Receive</a></td>

                </tr>  
				<? } 					
					
				}else{ ?>
				 <tr>
                  <td align="center" height="60"><div class="red" align="center"><?=NO_PO?></div></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>
		  
		  
</div>
