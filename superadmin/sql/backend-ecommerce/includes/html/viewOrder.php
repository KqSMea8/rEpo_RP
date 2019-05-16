<div class="had">Manage <?=$ListTitle;?> </div>
<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
        <td>
            <div class="message">
             <? if (!empty($_SESSION['mess_order'])) { echo stripslashes($_SESSION['mess_order']);unset($_SESSION['mess_order']); } ?>
           </div>
		    <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
					<td width="39%" align="right">     <?php  if (is_array($arrayOrders) && $num > 0) {?>
					<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_order.php?<?=$QueryString?>';" />

					<? if($_GET['search']!='') {?>
					<a href="viewOrder.php" class="grey_bt">View All</a>
					<? }?>
					<?php }?>      </td>
                </tr>

            </table>
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="8%" height="20"  class="head1" align="center">Order ID</td>      
                    <td width="20%" height="20"  class="head1">Customer's Name</td>     
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
                                <!--<input type="checkbox" name="orderid[]" value="<//?= $values['OrderID']; ?>">-->&nbsp;<?= $values['OrderID']; ?></td>
                            <td height="26"><?= $values['FirstName']." ".$values['LastName']; ?>     </td>
                            <td align="center"><?= display_price_symbol($values['TotalPrice'],$CurrencySymbol); ?></td>
                             <td align="center">
                                 <?php 
                                 /*   if ($values['OrderStatus'] == "Completed") {
                                      echo "Completed";
                                      } else if ($values['OrderStatus'] == "Cancelled") {
                                      echo "Cancelled";
                                      } else {
                                      echo "Process";
                                      }*/
                                     echo  $values['OrderStatus'];
                                 ?>        
                                
                            </td>
                            <td align="center">
                                <?php 
                                        if($values['PaymentStatus'] == "1") { echo "Received";}
                                        else if($values['PaymentStatus'] == "2") { echo "Refunded";}
                                        else if($values['PaymentStatus'] == "3") { echo "Cancelled";}
                    					else if($values['PaymentStatus'] == "5") { echo "Failed";}
                                        else{echo "Pending"; }
                                        ?>
                                
                            </td>
                            <td align="center" ><?= $values['OrderDate']; ?>  </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="vOrder.php?view=<?=$values['OrderID']?>&cid=<?=$values['Cid']?>curP=<?=$_GET['curP']?>"><?=$edit?></a>&nbsp;
                    
                                <a class="fancybox fancybox.iframe" href="orderInvoice.php?invoice=<?=$values['OrderID']?>&cid=<?=$values['Cid']?>curP=<?=$_GET['curP']?>" target="_blank"><img src="../../images/print.png" border="0" onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Print Invoice&lt;/center&gt;', 80,'')"></a>&nbsp;
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
