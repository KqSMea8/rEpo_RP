<div class="had">Order Item </div>
<form name="catgform" id="catgform" action="syncCategory.php" method="post">
<input type="hidden" name="Allselect" id="Allselect" value="">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td><br>
            <div class="message"><?php if (!empty($_SESSION['mess_cat'])) { echo stripslashes($_SESSION['mess_cat']); unset($_SESSION['mess_cat']);}?></div>
           

            <table <?= $table_bg ?> class="view-category">
                <tr align="left" >
                    <td width="15%" height="20"  class="head1" >Order Item</td>
                    <td  height="20" width="10%" class="head1" align="center">Items</td>
                    <td  height="20" width="15%" class="head1" align="center">Amount</td>
                    <td  height="20" width="15%" align="center" class="head1">Discount</td>
                    <td  height="20" width="15%" align="center" class="head1">Tax</td>
                    <td  height="20" width="15%" align="center" class="head1">Total</td>
                </tr>
                <?php
                
              
                if (isset($OrderList) && is_array($OrderList) && count($OrderList) > 0) {
                   
                    foreach ($OrderList as $key => $values) {
                                            
                      ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['product_name']; ?></td>
                            <td align="center"><?= $values['quantity']; ?></td>
                            <td align="center"><?= getPriceWithCurrency($values['gross'],$values['currency_code']);?></td>
                            <td align="center"><?= getPriceWithCurrency($values['discount'],$values['currency_code']); ?></td>
                            <td align="center"><?= getPriceWithCurrency($values['tax'],$values['currency_code']); ?></td>
							<td align="center"><?= getPriceWithCurrency($values['net'],$values['currency_code']); ?></td>
                        </tr>
                     
                <?php }} else { ?>
                    <tr align="center" >
                        <td height="20" colspan="7"  class="no_record">No Records found. </td>
                    </tr>
<?php } ?>
<!-----------Amit Singh----------------->
                    <tr>  
                    <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (isset($OrderList) && count($OrderList) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pageslink;
} ?>       
                    </td>
                </tr><!------------------------end----------------->
                
            </table>
        </td>
    </tr>
</table>
<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="synctype" value="one" checked="checked" onclick="chosevalue(this.value); ">sync this page Category
    	<input type="radio" name="synctype" value="all" onclick="chosevalue(this.value);" >sync all Category
    	
    </div>
</div>

</form>
