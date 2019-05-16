<style>
    .inputbox {
        display: block;
        width: 100px;
    }
   
    input.inputbox {
        display: inline-block;
    }
    
.searchBox {
    margin-bottom: 10px;
        margin-top:25px;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<div class="had">Manage Order</div>
<div class="mid-continent" id="inner_mid" style="text-align: center; margin-left: 10%; width: 80%;">	      
        <tr>
<div><a href="index.php" class="back">Back</a></div>
         
            <td valign="top">
                <div id="preview_div">
                        <!----------------------------    search ------------------- -->

                        <div class="searchBox" >
                            <?php if (!empty($_GET['type'])) { ?>
                                                        <a class="back" style="float: right; background-color:#3498db !important;" href="orderList.php" >Clear Search</a>

                            <?php } ?>
                       <label class="head1">Search By</label>
                            <select id="searchBy" >
                                <option value="none" >Select</option>
                                <option value="nameSearch" >Author</option>
                                <option value="customerSearch" >Customer Name</option>
                                <option value="transectionidSearch" >Transection ID</option>
                                <option value="purchaseDateSearch" >Purchase Date</option>-->

                            </select>
                            <table>
                                <tr id="nameSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action="" name="form1" class="searchForm" >
                                                <label>Search By Author</label>
                                                <input type="text" class="inputbox keyword" name="keyword">
                                                <input type="hidden" readonly="readonly" class="inputbox" name="type" value="byName">
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                                <tr id="customerSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action=""  name="form2" class="searchForm"  >
                                                <label>Search By Customer Name</label>
                                                <input type="text" class="inputbox keyword" name="keyword">
                                                <input type="hidden" readonly="readonly"class="inputbox" name="type" value="byCustomer">
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                                <tr id="transectionidSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action="" name="form3" class="searchForm"  >
                                                <label>Search By Transection ID</label>
                                                <input type="text" class=" inputbox keyword"  name="keyword">
                                                <input type="hidden" readonly="readonly" class="inputbox" name="type" value="byTransection">
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                                <tr id="purchaseDateSearch" class="filterByTr" style="display: none" >
                                    <td>
                                        <fieldset>
                                            <form action=""  name="form4" class="searchForm"  >
                                                <label>Search By Payment Date</label>
                                                <input type="text" class="datepicker inputbox keyword" readonly="true" name="keyword">
                                                <input type="hidden" readonly="readonly" class="inputbox" name="type" value="byPaymentDate"> 
                                                <input type="submit" class="button" name="searchButton" value="Search">
                                            </form>
                                        </fieldset></td>
                                </tr>
                            </table>
                            </form>
                        </div>
                             <!-------------------------- end Search  ------------------------------>
                        <table <?= $table_bg ?>>

                            <tr align="left">
                                <td width="15%" class="head1">Order ID</td>
                                <td width="15%" class="head1">Customer Name</td>
                                <td width="15%" class="head1">Document Name</td>
                                <td width="15%" class="head1">Document Type</td> 
                                <td width="15%" class="head1">Transection ID</td>
                                <td width="15%" class="head1">Amount</td>
                                <td width="15%" class="head1">Purchase Date</td>
                                <td width="15%" class="head1">Author</td>
                                <td width="15%" class="head1">Company</td>
                                <td width="20%" class="head1">Payment Status</td>
                                
                            </tr>
<!--                            <td width=""><a id="download" class="fancybox add_quick fancybox.iframe" href="login.php">Download</a></td>-->
                            <?php
                            
                            if (is_array($arryOrder) && $num > 0) {
                                $flag = true;
                                $Line = 0;
                                $sn = 0;
                               
                                                               
                                foreach ($arryOrder as $key => $values) {
                                  // print_r($values);     
                                    $values = get_object_vars($values);
                                   
                                    $flag = !$flag;
                                    
                                    $Line++;
                                   
                                    ?>
                                    <tr align="left" bgcolor="<?= $bgcolor ?>" data-id="<?= $values['id'] ?>"  data-status="<?= $values['status']; ?>" >
                                        <td><?= $values['orderid']; ?></td>
                                       <td height="50"><strong><a  class="fancybox slnoclass fancybox.iframe" href="viewCustomer.php?id=<?php echo $values['userId'] ?>"><?php echo $values['user'] ?></a></strong></td>
<!--                                       <td height="50"><?php echo  $values['user'] ; ?></td>-->

                                        <td height="50"><?=$values['document']?> </td>
                                         <td height="50"><?=$values['documentType']?> </td>
                                        <td><?= $values["txnId"]; ?></td>
                                        <td>$<?=$values["amount"];?></td>
                                            <td><?php
                                            $data = new DateTime($values["paymentDate"]);
                                            echo $data->format('d-M-Y');
                                            ?></td>
                                     <td height="50"><strong><a  class="fancybox fancybox.iframe" href="viewCustomer.php?id=<?php echo $values['Id'] ?>"><?php echo $values['author'] ?></a></strong></td>
<!--                                            <td> <?php echo '<a href="mailto:' . $values['author'] . '">' . $values['author'] . '</a>'; ?></td>-->
<!--                                      <td height="50"><?php echo  $values['author'] ; ?></td>-->
                                            <td><?= $values["company"];?></td>
                                        <td><?= $values["payment_status"];?></td>
                                      
                                    </tr>
                                <?php } // foreach end //     ?>

                            <?php } else { ?>
                                <tr align="center">
                                    <td colspan="10" class="no_record">No record found.</td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="10">Total Record(s) : &nbsp;<?php echo $num; ?> <?php if (count($arryOrder) > 0) { ?>
                                        &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php
                                        echo $pagerLink;
                                    }
                                    ?></td>
                            </tr>
                        </table>

                    </div>
              
                    </table>
                    <input type="hidden" name="CurrentPage" id="CurrentPage"
                                   value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
                                   id="opt" value="<?php echo $ModuleName; ?>">
                    </td>
                    </tr>
                    </table>
                </div>
                <script>
                    
                    $("#searchBy").change(function () {
                        var showId = $("#searchBy").val();
                        
                        $(".filterByTr").hide();
                        $("#" + showId).show();
                    });
                    $(".searchForm").submit(function (e) {
                        var keyword = $(this).find(".keyword").val();
                        
                        
                        if (keyword == '') {
                            alert("Please enter search keyword");
                            e.preventDefault();
                        }
                    });
                </script>
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                <script>
                    $(function () {
                        $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
                    });
                </script>
                  <script type="text/javascript">
$(document).ready(function() {
            
   $('.slnoclass').fancybox({
    closeClick  : false,
    width:500,
    helpers     : { 
        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
    }
   
    
   });
 
});
</script>