<div class="had">Manage Global Attributes </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_attr'])) {
        echo stripslashes($_SESSION['mess_attr']);
        unset($_SESSION['mess_attr']);
    } ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editAttribute.php" class="add">Add New Global Attribute</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="60%" height="20"  class="head1"> Attribute Name</td>      
                    <td width="8%" height="20"  class="head1" align="center">  Global</td>      
                    <td width="8%" height="20"  class="head1" align="center">Status</td>
                    <td width="8%" height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryGlobalAttributes, $RecordsPerPage, $_GET['curP']);
                (count($arryGlobalAttributes) > 0) ? ($arryGlobalAttributes = $objPager->getPageRecords()) : ("");
                if (is_array($arryGlobalAttributes) && $num > 0) {
                    $flag = true;

                    foreach ($arryGlobalAttributes as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Name']; ?>     </td>
                            <td align="center"><?= $values['IsGlobal']; ?></td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editAttribute.php?active_id=' . $values["Gaid"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="editAttribute.php?edit=<?php echo $values['Gaid']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editAttribute.php?del_id=<?php echo $values['Gaid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
    <?php } // foreach end // ?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Attribute found. </td>
                    </tr>
<?php } ?>

                <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryGlobalAttributes) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                        echo $pagerLink;
                    }
?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
