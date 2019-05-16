<div class="had">Manage Orders </div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<? if ($ParentID > 0) { ?>
        <tr>

            <td align="right" height="30"><a href="viewManufacturer.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="Blue">Back</a></td>
        </tr>
<? } ?>

    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_man'])) {  echo stripslashes($_SESSION['mess_man']);   unset($_SESSION['mess_man']);} ?></div>
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="10%" height="20"  class="head1"> Order ID</td>      
                    <td width="20%" height="20"  class="head1">  Customer's Name</td>     
                    <td width="20%" height="20"  class="head1">Amount</td>
                    <td width="20%" height="20"  class="head1">  Payment</td>      
                    <td width="10%" height="20"  class="head1" align="center">  Status</td>      
                    <td width="10%" height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryManufacturer, $RecordsPerPage, $_GET['curP']);
                (count($arryManufacturer) > 0) ? ($arryManufacturer = $objPager->getPageRecords()) : ("");
                if (is_array($arryManufacturer) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryManufacturer as $key => $values) {

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                              <td><?= $values['Mcode'];?></td>
                                <td height="26"><?= $values['Mname'];?>     </td>
                                <td><?= $values['Mcode'];?></td>
                                <td><?= $values['Mcode'];?></td>
                            <td align="center" ><?
                                            if ($values['Status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editManufacturer.php?active_id=' . $values["Mid"] . '&ParentID=' . $ParentID . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                   <a href="editManufacturer.php?edit=<?php echo $values['Mid']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editManufacturer.php?del_id=<?php echo $values['Mid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="6"  class="no_record">No Order found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="6" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryManufacturer) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table></td>
    </tr>


</table>
