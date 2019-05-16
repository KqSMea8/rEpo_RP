<?php  
 
if($_SESSION['AdminType'] == "employee") {
	$salesPerson =1;
}

?>
<div class="rows clearfix">
          <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block alerts">
		<? if($_SESSION['AdminType'] == "admin"){ ?>
                <h3>SO Report</h3>
		
		<div class="chartdiv" style="width:380px;">
			<select name="chart" id="chart" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pChart:bChart">Pie Chart</option>
				<option value="bChart:pChart">Bar Chart</option>
			</select>				
			<img src="barD.php" id="bChart" style="display:none">
			<img src="pieD.php" id="pChart" style="padding:10px;">
		</div>


		<?  }else{
		//$StyleCom = 'style="width:400px;margin-right:10px;"';
		//require_once("../includes/html/box/commission_dashboard.php"); ?>
		<h3>Sales Commission Report</h3>
		<div class="chartdiv" style="width:380px;">
			<select name="comm" id="comm" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pComm:bComm">Pie Chart</option>
				<option value="bComm:pComm">Bar Chart</option>
			</select>				
			<img src="../barComm.php?salesPerson=<?php echo $salesPerson;?>" id="bComm" style="display:none;">
			<img src="../pieComm.php?salesPerson=<?php echo $salesPerson;?>" id="pComm" style="padding:10px;">
		</div>

		<?  } ?>
            </div>
          </div>
	


          <div class="second_col" style="display:none3;<?=$WidthRow2?>">
            <div class="block listing">
              <h3>Open Sales Order</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
		/*******User Full Permission Check********/
		$MainModuleIDSo = 717;
		$Config['vAllRecord'] = $objConfig->GetModulePermission($MainModuleIDSo,$AllowedModules,$RoleGroupUserId);			
		/********************/
				/********************/
				$_GET['module']='Order'; 
				$_GET['Status'] = 'Open';
				$_GET['Limit'] = '10';
				$arryOpenSO=$objSale->ListSale($_GET);
				/********************/
				
				if(sizeof($arryOpenSO)>0){ 


 
?>

				<? foreach($arryOpenSO as $key=>$values){

					$TotalGenerateInvoice=$objSale->GetQtyInvoiced($values['OrderID']);

	$QtyInvoiced = (!empty($TotalGenerateInvoice[0]['QtyInvoiced']))?($TotalGenerateInvoice[0]['QtyInvoiced']):('');
	$QtyOrder = (!empty($TotalGenerateInvoice[0]['Qty']))?($TotalGenerateInvoice[0]['Qty']):('');

	                $TotalInvoice=$objSale->CountInvoices($values['SaleID']);
				?>
				<tr>
                  <td width="15%"><a href="vSalesQuoteOrder.php?module=Order&view=<?=$values['OrderID']?>" target="_blank"><?=$values['SaleID']?></a></td>
				  <td width="30%">
					<? if($values['OrderDate']>0) 
					   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
					?></td>
				  <td ><?=stripslashes($values["CustomerName"])?></td>
				  <td width="20%"><?=$values['TotalAmount']?> <?=$values['CustomerCurrency']?></td>
				<td width="20%" style="text-align:right">
				 <?php
				 if($values['Status'] =='Open' && $values['Approved'] ==1 && $QtyInvoiced != $QtyOrder){
				 ?>
				 <a class="action_bt" href="../finance/generateInvoice.php?so=<?=$values['SaleID'];?>&invoice=<?=$values['OrderID']?>" target="_blank">Generate Invoice</a>
				 <?php } ?>
				 </td>
					
                </tr>  
				<? } 					
					
				}else{ ?>
				 <tr>
                  <td align="center" height="60"><div class="red" align="center"><?=NO_SO?></div></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>	  
</div>
