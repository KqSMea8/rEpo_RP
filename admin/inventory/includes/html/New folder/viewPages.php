<div class="had"><?=MANAGE_PAGES?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {  echo stripslashes($_SESSION['mess_Page']);   unset($_SESSION['mess_Page']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editPage.php" class="add">Add New Page</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="50%" height="20"  class="head1">Page Name</td> 
                <td width="10%" height="20"  class="head1" align="center">Order</td> 
                <td  width="10%" height="20"  class="head1" align="center">Status</td>
                <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                $pagerLink = $objPager->getPager($arryPages, $RecordsPerPage, $_GET['curP']);
                (count($arryShipingMethod) > 0) ? ($arryPages = $objPager->getPageRecords()) : ("");
                if (is_array($arryPages) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryPages as $key => $values) {

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Title'];?>     </td>
                             <td height="26" align="center"><?= $values['Priority'];?>     </td>
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editPage.php?active_id=' . $values["PageId"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                   <a href="editPage.php?edit=<?php echo $values['PageId']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editPage.php?del_id=<?php echo $values['PageId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Tax Class found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryShipingMethod) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table></td>
    </tr>


</table>
