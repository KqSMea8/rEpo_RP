<div class="had"><?=$ModuleTitle?></div>
 
 <div class="message"><? if (!empty($_SESSION['mess_coupon'])) {  echo stripslashes($_SESSION['mess_coupon']);   unset($_SESSION['mess_coupon']);} ?></div>
 <form method="post" action="" name="frmPromo">
 <table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr valign="top">
    <td style="width: 200px; padding: 5px 0px 0px 20px;">Do you want to enable coupon codes?</td>
    <td>
            <select class="inputboxSmall" name="DiscountsPromo">
                    <option value="No">No</option>
                    <option value="Yes" <?= $settings["DiscountsPromo"] == "Yes" ? "selected" : "" ?>>Yes</option>
            </select>
       
        <input type="submit" value="Save" class="button">
		<a href="editCoupon.php" class="add">Create a New Coupon Code</a>
    </td>
    </tr>
   </table>   
   </form>  
<table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
        <td>
            
            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="15%"  height="20"  class="head1">Campaign Name</td>      
                <td width="15%"  height="20"  class="head1">Date Start</td>  
                <td width="15%"  height="20"  class="head1">Date End</td>  
                <td  width="10%" class="head1" align="center">Coupon Code</td>
                <td  width="10%" class="head1" align="center">Coupon Type</td>
                <td  width="10%" height="20"  class="head1" align="center">Discount</td>
                <td  width="10%" height="20"  class="head1" align="center">Subtotal</td>
                <td  width="8%"  height="20"  class="head1" align="center">Status</td>
                <td  width="10%" height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                
                $pagerLink = $objPager->getPager($arryCouponCodes, $RecordsPerPage, $_GET['curP']);
                (count($arryCouponCodes) > 0) ? ($arryCouponCodes = $objPager->getPageRecords()) : ("");


                if (is_array($arryCouponCodes) && $num > 0) {
                    $flag = 1;
                   
                    foreach ($arryCouponCodes as $key => $values) {
                        
                        if($flag%2==0){
                            $promoclass = "promoclassBlue";
                        }
                        else{
                            $promoclass = "promoclassBlue";
                        }
                    ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                              <td height="26"><?= $values['Name'];?></td>
                              <td><?=date($Config['DateFormat'],strtotime($values["DateStart"]))?></td>
                              <td><?=date($Config['DateFormat'],strtotime($values["DateStop"]))?></td>
                              <td align="center"><span class="<?=$promoclass?>"><?= $values['PromoCode'];?></span></td>
                               <td align="center"><?php if($values['PromoType'] == "Global"){ echo "Global-based";} else{ echo "Product-based"; }?></td>
                               <td align="center"><?= $values['Discount'];?></td>
                               <td align="center"><?= $values['MinAmount'];?></td>
                              <td align="center" ><?
                                            if ($values['Active'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editCoupon.php?active_id=' . $values["PromoID"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="center" class="head1_inner"  valign="top">
                                
                                   <a href="editCoupon.php?promoID=<?php echo $values['PromoID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                   
                                    <a href="editCoupon.php?del_id=<?php echo $values['PromoID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Coupon Code')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php $flag = 1+$flag;} // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="9"  class="no_record">No Coupon found. </td>
                    </tr>
                <?php } ?>

                <tr>  
                    <td height="20" colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      
                        <?php if (count($arryCouponCodes) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                                   }?></td>
                </tr>
            </table>
        </td>
    </tr>


</table>
