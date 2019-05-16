<div class="had"><?=$ModuleName?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Payment'])) {  echo stripslashes($_SESSION['mess_Payment']);   unset($_SESSION['mess_Payment']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
            </table>
            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="50%" height="20"  class="head1">Payment Name</td> 
                <td  width="10%" height="20"  class="head1" align="center">Status</td>
                <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                $pagerLink = $objPager->getPager($arryPaymentMethods, $RecordsPerPage, $_GET['curP']);
                (count($arryPaymentMethods) > 0) ? ($arryPaymentMethods = $objPager->getPageRecords()) : ("");
                if (is_array($arryPaymentMethods) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryPaymentMethods as $key => $values) {

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['PaymentMethodName'];?>     </td>
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editPayment.php?active_id=' . $values["PaymetMethodId"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                    <a href="editPayment.php?paymentId=<?php echo $values['PaymetMethodId']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
<!--                                    <a href="editPayment.php?del_id=<?php echo $values['PaymetMethodId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Payment Method')" class="Blue" ><?= $delete ?></a>              -->
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="3"  class="no_record">No Payment Method found. </td>
                    </tr>
                <?php } ?>

                <tr>  <td height="20" colspan="3" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryPaymentMethods) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
