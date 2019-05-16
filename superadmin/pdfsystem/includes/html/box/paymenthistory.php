<style>.inputbox {
        display: block;
        width: 100px;
    }
   
    input.inputbox {
        display: inline-block;
    }
    
.searchBox {
    margin-bottom: 10px;
        margin-top:25px;
}</style>
<table WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
    <tr>
        <td valign="top">        
        <div id="prv_msg_div" style="display: none"><img src="images/loading.gif">&nbsp;Searching..............</div>
        <div id="preview_div">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<div class="searchBox"  >
      <?php if (!empty( $_REQUEST['Todate'])) { ?>
                                <a class="back" style="float: right; background-color:#3498db !important;" href="editCompany.php?edit=<?php echo  $_REQUEST['edit']; ?>&tab=<?php echo  $_REQUEST['tab']?> ">Clear Search</a>
                            <?php } ?>
         <form action="" method="" class="searchForm">
             <label class="head1">Search By Date:</label>
          <input type="hidden" name="edit" value="<?php echo $_REQUEST['edit']; ?>"> 
          <input type="hidden" name="tab" value="<?php echo $_REQUEST['tab']; ?>"> 
          <label for="dates">To</label>
          <input type="text" name="Todate" id="Todate" class="datepicker inputbox keyword" readonly="true" value="<?php echo $_REQUEST['Todate'] ?>">
          <label for="datee">From</label>
          <input type="text" name="Fromdate" id="Fromdate" class="datepicker inputbox keyword" readonly="true" value="<?php echo $_REQUEST['Fromdate'] ?>">
          <input type="submit" value="Search"  class="button">
      </form>
  </div>
            <table <?=$table_bg?>>
                <tr align="left">
                     <td  class="head1">S.N</td>
                      
                      <td  class="head1">Transection ID</td>
                      <td  class="head1">Payment Date</td>
                      <td class="head1">Plan Amount</td>
                      <td class="head1">Extra Doc Amount</td>
                      <td  class="head1">Extra Page Amount</td>
                      <td  class="head1">Extra Video Amount</td>
                      <td  class="head1">Extra Video Size Amount </td>
                      <td  class="head1">Extra User Amount</td>
                      <td  class="head1">Total</td>
                    <td  class="head1">Action</td>
                </tr>

                <?php
                 $num =0;
                 $sn = 0; 
                // print_r($arryOrderHis);
                if(!empty($arryOrderHis)){
                       
                        foreach($arryOrderHis as $val){
                                $num++;
                             $userID = $_REQUEST['edit']; 
                            
                             
 $totalAmount = $val->amount + $val->DocCost + $val->PageCost + $val->VideoCost + $val->VideoSizeCost + $val->UserCost;
                                ?>
                                <tr align="left" bgcolor="<?=$bgcolor?>">
                                    <td><?= ++$sn; ?></td>
                                   
                                    <td ><?= $val->txnId; ?></td>
                                    <td><?= date("Y-m-d", strtotime($val->recordInsertedDate)); ?></td>
                                    <td >$<?= $val->amount; ?></td>
                                    <td>$<?= $val->DocCost; ?></td>
                                    <td>$<?= $val->PageCost; ?></td>
                                    <td>$<?= $val->VideoCost; ?></td>
                                    <td>$<?= $val->VideoSizeCost; ?></td>
                                    <td>$<?= $val->UserCost; ?></td>
                                    <td>$<?= $totalAmount; ?></td>
                                    <td height="50"> <a href="editCompany.php?edit=<?php echo $userID;?>&tab=paymentview&id=<?php echo $val->id;?>"><?= $view ?></a></td>
                                     
                                </tr>           
                <?php } // foreach end //?>

                <?php }else{?>
                <tr align="center">
                        <td colspan="12" class="no_record">No record found.</td>
                </tr>
                <?php } ?>

                <tr>
                        <td colspan="9">Total Record(s) : &nbsp;<?php echo $num;?> 
                           
                        </td>
                </tr>
            </table>
        </div>
	
            <input type="hidden" name="CurrentPage" id="CurrentPage"
            value="<?php echo $_REQUEST['curP']; ?>"> <input type="hidden" name="opt"
            id="opt" value="<?php echo $ModuleName; ?>">
        
        </td>
    </tr>
</table>
<script>
    $(".searchForm").submit(function () {
    
                        var Todate = $("#Todate").val();
                        var Fromdate = $("#Fromdate").val();                      
                        if (Todate =='') {                       
                            alert("Please enter to date");                           
                            return false;                           
                        }                      
                       if(Fromdate ==''){
                            alert("Please enter from date");                           
                           return false;                           
                        }
                        
                        
                    });
                    </script>
 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
                <script>
                    $(function () {
                       
                        $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
                    });
                </script>
