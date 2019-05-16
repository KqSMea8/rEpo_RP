
<script>
function SyncType(Type){

alert(Type);
}
</script>

<div class="had">Manage <?=$ListTitle;?> </div>
<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
        <td>
            <div class="message">
             <? if (!empty($_SESSION['mess_order'])) { echo stripslashes($_SESSION['mess_order']);unset($_SESSION['mess_order']); } ?>
           </div>
		     <form action="" method="post" name="Amazon">
		    <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
					<td width="39%" align="right">     <?php  if (is_array($arrayOrders) && $num > 0) {?>
					<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_order.php?<?=$QueryString?>';" />
					<? if($_GET['search']!='') {?>
					<a href="viewOrder.php" class="grey_bt">View All</a>
					<? }?>
					<?php }?>  
<ul style="margin-right:5px;" class="export_menu">
<li><a style="background:#d40503 !important; width: 96px;" class="hide" href="#">Sync Orders</a>
<ul>
<li><a style="background:#d40503 !important; margin-bottom:2px; margin-top:2px; width: 96px;" href="viewOrder.php?synctype=sync_amazon&curP=<?=$_GET['curP']?>">Sync Amazon</a></li>
<li> <a style="background:#d40503 !important;width: 96px; "  href="viewOrder.php?synctype=sync_ebay&curP=<?=$_GET['curP']?>" >Sync Ebay</a></li>	

</ul>
</li>
</ul>
		
    </td>
                </tr>

            </table>
            </form>
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="8%" height="20"  class="head1" align="center">Order ID</td>      
                    <td width="20%" height="20"  class="head1">Customer's Name</td>
                    <td width="10%" height="20"  class="head1" align="center">Order Type</td>     
                    <td width="10%" height="20"  class="head1" align="center">Amount</td>
                    <td width="8%" height="20"  class="head1" align="center">Order Status</td>      
                    <td width="8%" height="20"  class="head1" align="center">Payment Status</td>      
                    <td width="8%" height="20"  class="head1" align="center">Order Date</td>      
                    <td width="9%" height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arrayOrders, $RecordsPerPage, $_GET['curP']);
                (count($arrayOrders) > 0) ? ($arrayOrders = $objPager->getPageRecords()) : ("");
                if ($num > 0) {
                  
                    foreach ($arrayOrders as $key => $values) {
                         $CurrencySymbol=$values['Currency'];
                        if(!empty($values['CurrencySymbol'])) $CurrencySymbol=$values['CurrencySymbol'];
                        
                        if($values['PaymentStatus'] == "1")
                            $bgcolor = "#ffffff";
                            else
                             $bgcolor = "#e9e8e8";
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td align="center">
                                <!--<input type="checkbox" name="orderid[]" value="<//?= $values['OrderID']; ?>">-->&nbsp;<?= $values['OrderID']; ?>  </td>
                             <td height="26">



<?= ( $values['OrderType']=='Amazon' || $values['OrderType']=='Ebay') ? $values['BillingName'] : $values['FirstName']." ".$values['LastName']; ?>     </td>
 			     <!--<td align="center"><?= ( !empty($values['OrderType']) ) ? $values['SellerChannel'] : 'Web'; ?>     </td>-->
                            <td align="center"><?php if( !empty($values['OrderType']) ) { 
                            	switch ($values['SellerChannel']){
                            		case 'Amazon.com':
                            			$logo = 'amazon_com.gif';
                            		break;
                            		case 'Amazon.ca':
                            			$logo = 'amazon_ca.gif';
                            		break;
                            		case 'Amazon.co.jp':
                            			$logo = 'amazon_co.jp.gif';
                            		break;
                            		case 'Amazon.es':
                            			$logo = 'amazon_es.jpg';
                            		break;
                            		case 'Amazon.com.mx':
                            			$logo = 'amazon_com.mx.jpg';
                            		break;
                            		case 'Amazon.it':
                            			$logo = 'amazon_it.gif';
                            		break;
                            		case 'Amazon.fr':
                            			$logo = 'amazon_fr.gif';
                            		break;
                            		case 'Amazon.de':
                            			$logo = 'amazon_de.gif';
                            		break;
                            		case 'Amazon.co.uk':
                            			$logo = 'amazon_co.uk.gif';
                            		break;
                            		case 'Amazon.in':
                            			$logo = 'amazon_in.gif';
                            		break;
                            		case 'Ebay.com':
                            			$logo = 'ebay.png';
                            		break;
                            	} 
                            ?>
                            <img alt="" src="../upload/orderTypeLogo/<?=$logo?>" height="15">
                            <?php }else{ ?>
                            	<img alt="" src="../../images/logo.png" height="13">
                           <?php } ?>     </td>
                          <td align="center"><?= display_price_symbol($values['TotalPrice']);//display_price_symbol($values['TotalPrice'],$CurrencySymbol) ?></td>
                             <td align="center">
                                 <?php 
                                 /*   if ($values['OrderStatus'] == "Completed") {
                                      echo "Completed";
                                      } else if ($values['OrderStatus'] == "Cancelled") {
                                      echo "Cancelled";
                                      } else {
                                      echo "Process";
                                      }*/
														if ($values['OrderStatus'] == "Shipped" || $values['OrderStatus'] == "Completed" ) {
																	$status = 'Active';
																	$Design ='width: 55px;display: block;text-decoration: none;cursor: default;';				
																	$StatusText = 'Shipped';

															} else  {
																	$status = 'InActive';
																	$Design ='width: 65px;display: block;text-decoration: none;cursor: default;';
																	$StatusText = $values['OrderStatus'];
															}



                        echo '<a style="'.$Design.'" class=' . $status . '>' . $StatusText . '</a>';


                                     //echo  $values['OrderStatus'];
                                 ?>        
                                
                            </td>
                           <td align="center">
                                <?php  if($values['OrderType']=='Amazon' || $values['OrderType']=='Ebay'){
                                		echo 'Paid';
		                                }else{
		                                        if($values['PaymentStatus'] == "1") { echo "Received";}
		                                        else if($values['PaymentStatus'] == "2") { echo "Refunded";}
		                                        else if($values['PaymentStatus'] == "3") { echo "Cancelled";}
		                    					else if($values['PaymentStatus'] == "5") { echo "Failed";}
		                                        else{echo "Pending"; }
		                                }
                                        ?>
                                
                            </td>
                            <td align="center" >
<?  
            if ($values['OrderDate'] > 0)
                echo date($Config['DateFormat'].' '.$Config['TimeFormat'], strtotime($values['OrderDate']));
            ?>



  </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="vOrder.php?view=<?=$values['OrderID']?>&cid=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>&nbsp;
                    
                                <a class="fancybox fancybox.iframe" href="orderInvoice.php?invoice=<?=$values['OrderID']?>&cid=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>" target="_blank"><img src="../images/print.png" border="0" onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Print Invoice&lt;/center&gt;', 80,'')"></a>&nbsp;
                                <?php if($ModifyLabel == 1){ ?>
                                <a href="viewOrder.php?del_id=<?php echo $values['OrderID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Order')" class="Blue" ><?= $delete ?></a>              
                                <?php }?>
                                &nbsp;
                            </td>
                            </tr>
                            <?php } // foreach end // ?>
                            <?php } else { ?>
                            <tr align="center" >
                            <td height="20" colspan="7"  class="no_record">No Order found. </td>
                            </tr>
                            <?php } ?>

                        <tr>  <td height="20" colspan="7" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrayOrders) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                echo $pagerLink;
                            }
                        ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
