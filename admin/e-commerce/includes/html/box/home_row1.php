<div class="rows clearfix">
    <div class="first_col" style="width:230px;">
        <div class="block information">
            <h3>Overview</h3>
            <div class="bgwhite">
                <div class="overview">
                    <div class="dashboard-content" style="min-height:350px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <!--tr>
                                    <td height="35">Total Sales:</td>
                                    <td><?=display_price($totalSale);?></td>
                                </tr-->
                                <tr>
                                    <td height="35">Total Sales <!--This Year-->:</td>
                                    <td><?=display_price($totalSaleCurrentYear);?></td>
                                </tr>
                                <tr>
                                    <td height="35">Total Orders:</td>
                                    <td><?=$TotalOrders;?></td>
                                </tr>
                                <tr>
                                    <td height="35">No. of Customers:</td>
                                    <td><?=$TotalCustomer;?></td>
                                </tr>
                                <tr>
                                    <td height="35">Total Active Category:</td>
                                    <td><?=$TotalCategory;?></td>
                                </tr>
                                <tr>
                                    <td height="35">Total Active Product:</td>
                                    <td><?=$TotalProduct;?></td>
                                </tr>
                             	 <tr>
                                    <td height="30">&nbsp; </td>
                                    <td> </td>
                                </tr>
                            </tbody></table>
                    </div>
                </div>
            </div>

        </div>
    </div>

  



<? 
$xname = 'Sales Statistics for '.date('F, Y');
?>
    <div class="second_col" style="width:711px;">
        <div class="block alerts">
            <h3><?=$xname?>
	<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="bChart:pChart">Bar Chart</option>
				<option value="pChart:bChart">Pie Chart</option>
				
			</select>
</h3>
      

           <div class="chartdiv" style="min-height:350px;text-align:center" >
							
			<img src="barD.php" id="bChart" >
			<img src="pieD.php" id="pChart" style="padding:5px;display:none;width:450px;height:340px;">
		</div>

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
