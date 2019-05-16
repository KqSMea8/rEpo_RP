<div class="rows clearfix">
         <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block alerts">		
                <h3>PO Receipt By Month</h3>		
		<div class="chartdiv" style="width:380px;">
			<select name="chart" id="chart" class="chartselect" onchange="Javascript:showChart(this);">
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
              <h3>PO Receipt Invoices</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/				
				$_GET['Limit'] = '10';
$Config['StartPage'] = 0;
$Config['RecordsPerPage'] = 10;
				$arryPoInvoice=$objPurchase->ListInvoice($_GET);
				/********************/
				
				if(sizeof($arryPoInvoice)>0){ 
					 foreach($arryPoInvoice as $key=>$PoInvoice){
					
				?>
				<tr>
                  <td width="15%"><a href="vPoInvoice.php?view=<?=$PoInvoice['OrderID']?>&amp;po=" target="_blank"><?=$PoInvoice['InvoiceID']?></a></td>
				  <td width="30%">
					<? if($PoInvoice['UpdatedDate']>0) 
					   echo date($Config['DateFormat'], strtotime($PoInvoice['UpdatedDate']));
					?></td>
				  <td width="20%"><?=stripslashes($PoInvoice['SuppCompany'])?></td>
					<td width="20%"><?=stripslashes($PoInvoice['TotalAmount'])?></td>
		 <td width="20%"><?=stripslashes($PoInvoice['Currency'])?></td>
		  <td width="20%">
		   <? if($PoInvoice['InvoicePaid'] ==1){
                                                 $Paid = 'Paid';  $PaidCls = 'green';
                                                }elseif($PoInvoice['InvoicePaid'] == 2){
                                                 $Paid = 'Partially Paid';  $PaidCls = 'red';
                                                }else{
                                                 $Paid = 'Unpaid';  $PaidCls = 'red';
                                                }

                                                  echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';?>
			</td>
			   </tr>  
			
				<? } 	?>				
					   <tr>
                           <td colspan="2">
                           <a href="viewPoInvoice.php">More...</a>
                           </td>
                           </tr>
				<?}else{ ?>
				 <tr>
                  <td align="center" height="60"><div class="red" align="center"><?=NO_INVOICE?></div></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>	  
</div>
