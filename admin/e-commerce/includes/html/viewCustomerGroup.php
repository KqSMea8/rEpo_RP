<div class="had">Customer Groups</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_customer_group'])) {  echo stripslashes($_SESSION['mess_customer_group']);   unset($_SESSION['mess_customer_group']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editCustomerGroup.php" class="add">Add New Customer Group</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="50%" height="20"  class="head1">Group Name</td>      
                <td  width="8%" height="20"  class="head1" align="center">Status</td>
                <td width="10%"   height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                $pagerLink = $objPager->getPager($arryCustomerGroups, $RecordsPerPage, $_GET['curP']);
                (count($arryCustomerGroups) > 0) ? ($arryCustomerGroups = $objPager->getPageRecords()) : ("");
                if (is_array($arryCustomerGroups) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryCustomerGroups as $key => $values) {

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['GroupName'];?>     </td>
                             
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editCustomerGroup.php?active_id=' . $values["GroupID"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <?php if( $values['GroupCreated'] == "admin"){?>
                                    <a href="editCustomerGroup.php?edit=<?php echo $values['GroupID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editCustomerGroup.php?del_id=<?php echo $values['GroupID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('customer group')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                                <?php }?>
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="3"  class="no_record">No Customer Group Found. </td>
                    </tr>
                <?php } ?>

                <tr>  <td height="20" colspan="3" >Total Record(s) : &nbsp;<?php echo $num; ?>    
                <?php if (count($arryCustomerGroups) > 0) { ?>  &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
                          </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
