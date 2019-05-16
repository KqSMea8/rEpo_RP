<div class="rows clearfix">



		<div class="first_col" style="display:none;<?=$WidthRow1?>">
            <div class="block listing">
              <h3>Open Invoices</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************
				$_GET['InvoicePaid'] = '0';
				$_GET['Limit'] = '10';
				$arryOpenInvoice=$objPurchase->ListInvoice($_GET);
				/********************/
				
				
				if(!empty($arryOpenInvoice)){  

				 foreach($arryOpenInvoice as $key=>$values){


				if(!empty($values["VendorName"])){
					$VendorName = $values["VendorName"];
				}else{
					$VendorName = $values["SuppCompany"];
				}

 ?>
				<tr>
                  <td width="25%"><a href="vPoInvoice.php?view=<?=$values['OrderID']?>" target="_blank"><?=$values['InvoiceID']?></a></td>
				  <td><?=stripslashes($VendorName)?></td>
				  <td width="30%" style="text-align:right"><?=$values['TotalAmount']?> <?=$values['Currency']?></td>
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
              <h3>PO to Approve</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/
				$_GET['module']='Order'; 
				$_GET['ToApprove'] = '1'; $_GET['Status'] = '';
				$_GET['Limit'] = '10';
				$arryAppPO=$objPurchase->ListPurchase($_GET);
				/********************/
				
				
				if(sizeof($arryAppPO)>0){ ?>
				

				<? foreach($arryAppPO as $key=>$values){
			if(!empty($values["VendorName"])){
					$VendorName = $values["VendorName"];
				}else{
					$VendorName = $values["SuppCompany"];
				}

 ?>
				<tr>
                  <td width="15%"><a href="editPO.php?module=Order&edit=<?=$values['OrderID']?>" target="_blank"><?=$values['PurchaseID']?></a></td>
				  <td width="20%">
					<? if($values['OrderDate']>0) 
					   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
					?></td>
				  <td><?=stripslashes($VendorName)?></td>
				  <td width="20%" style="text-align:right"><?=$values['TotalAmount']?> <?=$values['Currency']?></td>
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
		









		<? }else{ ?>

			<div class="second_col" style="display:none3;<?=$WidthRow2?>">
            <div class="block listing">
              <h3>PO Assigned to Me</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? 
				/********************/
				$_GET['module']='Order'; 
				$_GET['Status'] = '';
				$_GET['Limit'] = '10';
				$_GET['AssignedEmpID'] = $_SESSION['AdminID'];		
				$arryAssPO=$objPurchase->ListPurchase($_GET);
				/********************/
				
				
				if(sizeof($arryAssPO)>0){ ?>
			

				<? foreach($arryAssPO as $key=>$values){ ?>
				<tr>
                  <td width="15%"><a href="editPO.php?module=Order&edit=<?=$values['OrderID']?>" target="_blank"><?=$values['PurchaseID']?></a></td>
				  <td width="20%">
					<? if($values['OrderDate']>0) 
					   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
					?></td>
				  <td><?=stripslashes($values["SuppCompany"])?></td>
				  <td width="20%" style="text-align:right"><?=$values['TotalAmount']?> <?=$values['Currency']?></td>
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



		<? } ?>
		  
		  
</div>
