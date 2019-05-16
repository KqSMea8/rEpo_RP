<div class="container account">
    <div class="mid_wraper clearfix">
        <?php //include_once("includes/left.php"); ?>
        <div class="right_pen allmyOrders">
            <h3><?= MY_ORDERS ?></h3>
            <table width="100%" border="1" cellpadding="3" cellspacing="1" class="wishlist">            
                <tr>
                    <td class="wish_head"><?= ORDER_ID ?></td>
                    <td class="wish_head"><?= ORDER_STATUS ?></td>
                    <td class="wish_head"><?= ORDER_DATE ?></td>
                    <td class="wish_head"><?= CURRENT_TOTAL ?></td>
                    <td class="wish_head">Action</td>
                </tr>
                <?php
                if (count($arrayMyOrders) > 0) {

                    foreach ($arrayMyOrders as $key => $order) {
                        $CurrencySymbol=$order['Currency'];
                        if(!empty($order['CurrencySymbol'])) $CurrencySymbol=$order['CurrencySymbol'];
                        
                        ?>
                        <tr class="wish-field">
                            <td ><?= $order['OrderID'] ?></td>
                            <td><?= $order['OrderStatus'] ?> </td>
                            <td><?= date($Config['DateFormat'], strtotime($order['OrderDate'])) ?> </td>   
                            <td><?= display_price_symbol($order['TotalPrice'], $CurrencySymbol) ?></td>
                            <td><a  href="myOrder.php?oid=<?= $order['OrderID'] ?>" class="small_link"><img src="../images/view_g.png" onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;View Order&lt;/center&gt;', 40, '')"></a>
                                <a href="cart.php?oid=<?= $order['OrderID'] ?>&action=reorder" class="small_link"><img src="../images/reorder.png" alt="Reorder" title="Reorder"></a></td>
                        </tr>

                    <?php } ?>
                    <tr><td colspan="5" style="text-align: right;"><b><?= ORDER_PLACED ?> : <?= count($arrayMyOrders); ?></b></td></tr>
                <?php } else { ?>

                    <tr>
                        <td colspan="5"><?= NO_ORDER_FOUND ?></td>

                    </tr>
                <?php } ?>

            </table>


        </div>
    </div>
</div>
