<div class="had">Manage Subscriber</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Subscriber'])) {
    echo stripslashes($_SESSION['mess_Subscriber']);
    unset($_SESSION['mess_Subscriber']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="50%" height="20"  class="head1">Email Address</td> 
                    <td width="10%" height="20"  class="head1" align="center">Added At</td> 
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arrySubscribers, $RecordsPerPage, $_GET['curP']);
                (count($arrySubscribers) > 0) ? ($arrySubscribers = $objPager->getPageRecords()) : ("");
                if (is_array($arrySubscribers) && $num > 0) {
                    $flag = true;

                    foreach ($arrySubscribers as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Email']; ?>     </td>
                            <td height="26" align="center"><?= $values['Created_Date']; ?>     </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editSubscriber.php?active_id=' . $values["EmailId"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editSubscriber.php?edit=<?php echo $values['EmailId']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editSubscriber.php?del_id=<?php echo $values['EmailId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Subscriber found. </td>
                    </tr>
<?php } ?>

                <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySubscribers) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
    echo $pagerLink;
}
?></td>
                </tr>
            </table>
        </td>
    </tr>


</table>
