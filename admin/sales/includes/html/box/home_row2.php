<div class="rows clearfix">
		<div class="first_col" style="display:none;<?=$WidthRow1?>">
            <div class="block listing">
              <h3>Unpaid Invoices</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************
				$_GET['InvoicePaid'] = 'Unpaid';
				$_GET['module'] = 'Invoice';
				$_GET['Limit'] = '10';
				$arryOpenInvoice=$objSale->ListInvoice($_GET);
				/********************/
				
				
				if(!empty($arryOpenInvoice)){ ?>

				<? foreach($arryOpenInvoice as $key=>$values){ ?>
				<tr>
                  <td width="25%"><a href="editInvoice.php?curP=1&edit=<?=$values['OrderID']?>" target="_blank"><?=$values['InvoiceID']?></a></td>
				  <td><?=stripslashes($values["CustomerName"])?></td>
				  <td width="30%" style="text-align:right"><?=$values['TotalAmount']?> <?=$values['CustomerCurrency']?></td>
                </tr>  
				<? } 					
					
				}else{ ?>
				 <tr>
                  <td align="center" height="60"><div class="red" align="center"><?=NO_INVOICE?></div></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>





		  <? if($_SESSION['AdminType'] == "admin") {  ?>
          <div class="second_col" style="display:none3;<?=$WidthRow2?>">
            <div class="block listing">
              <h3>Sales Quote to Approve</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/
				$_GET['module']='Quote'; 
				$_GET['ToApprove'] = '1'; $_GET['Status'] = '';
				$_GET['Limit'] = '10';
				$arryAppSO=$objSale->ListSale($_GET);
				/********************/
				
				
				if(sizeof($arryAppSO)>0){ ?>
				

				<? foreach($arryAppSO as $key=>$values){ ?>
				<tr>
					<td width="15%">
					<a href="editSalesQuoteOrder.php?module=Quote&edit=<?=$values['OrderID']?>" target="_blank"><?=$values['QuoteID']?></a>
					</td>
					<td width="30%">
					<? if($values['OrderDate']>0) 
				    	echo date($Config['DateFormat'], strtotime($values['OrderDate']));
					?></td>
					<td><?=stripslashes($values["CustomerName"])?></td>
					<td width="20%" style="text-align:right"><?=$values['TotalAmount']?> <?=$values['CustomerCurrency']?></td>
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
	<?php }else{

		$StyleCom = 'style="width:530px;"';
		require_once("../includes/html/box/commission_dashboard.php");


	 } ?>
	  
    </div>
