<div class="rows clearfix">
    <div class="first_col" style="width:314px;">
        <div class="block information">
            <h3>Overview</h3>
            <div class="bgwhite">
                <div class="overview">
                    <div class="dashboard-content">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td>Total Sales:</td>
                                    <td><?=display_price($totalSale);?></td>
                                </tr>
                                <tr>
                                    <td>Total Sales This Year:</td>
                                    <td><?=display_price($totalSaleCurrentYear);?></td>
                                </tr>
                                <tr>
                                    <td>Total Orders:</td>
                                    <td><?=$TotalOrders;?></td>
                                </tr>
                                <tr>
                                    <td>No. of Customers:</td>
                                    <td><?=$TotalCustomer;?></td>
                                </tr>
                                <tr>
                                    <td>Total Active Category:</td>
                                    <td><?=$TotalCategory;?></td>
                                </tr>
                                <tr>
                                    <td>Total Active Product:</td>
                                    <td><?=$TotalProduct;?></td>
                                </tr>
                             
                            </tbody></table>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <div class="second_col" style="width:611px;">
        <div class="block alerts">
            <h3>Statistics</h3>
      

<script type="text/javascript" src="js/json/json2.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF("open-flash-chart.swf", "my_chart", "590", "300", "9.0.0",{"get-data":"open_flash_chart_data"});
</script>
<script type="text/javascript">


function open_flash_chart_data()
{
  
    return JSON.stringify(data);
}


    
var data = <?php echo $chart->toString(); ?>;

</script>

            <div style="border: 1px solid #E1E1E1;padding:10px;width:585px;background:#fff;"><div id="my_chart"></div></div>
        </div>
    </div>



    <div class="third_col" style="clear: both; width: 964px">
        <div class="block status_updates">
            <h3>Latest 5 Orders</h3>
            <div class="bgwhite" style="min-height:210px;">
                <div class="latest">
             <div class="dashboard-content">
             <table class="list" style="width:100%">
             <tbody>
              <tr>
                <td><b>Order ID</b></td>
                <td><b>Customer</b></td>
                <td><b>Status</b></td>
                <td><b>Order Date</b></td>
                <td><b>Total</b></td>
                <td><b>Action</b></td>
              </tr>
          

             <?php foreach($latestOrders as $orderdata) {?>   
               <tr>
                <td class="right"><?=$orderdata['OrderID']?></td>
                <td class="left"><?=$orderdata['FirstName']?> <?=$orderdata['LastName']?></td>
                <td class="left"><?=$orderdata['OrderStatus']?></td>
                <td class="left"><?=$orderdata['OrderDate']?></td>
                <td class="right"><?=display_price($orderdata['TotalPrice'])?></td>
                <td class="right"><a href="vOrder.php?view=<?=$orderdata['OrderID']?>&cid=<?=$orderdata['Cid']?>curP=1" target="_blank">View</a></td>
              </tr>
              <?php }?>     
               </tbody>
          </table>
        </div>
      </div>
          

            </div>
        </div>
    </div>


</div>
