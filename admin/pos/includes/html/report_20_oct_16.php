

<div class="had">Order Id </div>
<form name="catgform" id="catgform" action="syncCategory.php" method="post">
<input type="hidden" name="Allselect" id="Allselect" value="">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td><br>
            <div class="message"><?php if (!empty($_SESSION['mess_cat'])) { echo stripslashes($_SESSION['mess_cat']); unset($_SESSION['mess_cat']);}?></div>
           

            <table <?= $table_bg ?> class="view-category">
                <tr align="left" >
                    
                    <td width="15%" height="20"  class="head1" >  ORDER ID</td>
                    <td  height="20" width="10%" class="head1" align="center">QUANTITY</td>
                    <td  height="20" width="15%" class="head1" align="center">GROSS</td>
                    <td  height="20" width="15%" align="center" class="head1">DISCOUNT</td>
                    <td  height="20" width="15%" align="center" class="head1">NET</td>
                    <td  height="20" width="15%" align="center" class="head1">ORDER TAX</td>
                    <td  height="20" width="15%" align="center" class="head1">INCLUDED TAX</td>
                    
                </tr>
                <?php
                
              
                if (is_array($OrderList) && count($OrderList) > 0) {
                   
                    foreach ($OrderList as $key => $values) {
                                            
                      ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            
                           
                            <td align="center" height="26"><?= $values['order_id']; ?></td>
                            <td align="center"><?= $values['quantity']; ?></td>
                            <td align="center"><?= getPriceWithCurrency($values['gross'],$values['currency_code']);?></td>
                            <td align="center"><?= getPriceWithCurrency($values['discount'],$values['currency_code']); ?></td>
                            <td align="center"><?= getPriceWithCurrency($values['net'],$values['currency_code']); ?></td>
                            <td align="center"><?= getPriceWithCurrency($values['tax'],$values['currency_code']); ?></td>
                            <td align="center"><?= getPriceWithCurrency($values['include_tax'],$values['currency_code']); ?></td>
                        </tr>
                     
                <?php }} else { ?>
                    <tr align="center" >
                        <td height="20" colspan="7"  class="no_record">No <?= strtolower($cat_title) ?> found. </td>
                    </tr>
<?php } ?>

                
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
