<div class="had">Manage Newsletter Templates</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_template'])) {
    echo stripslashes($_SESSION['mess_template']);
    unset($_SESSION['mess_template']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editNewsletterTemplate.php" class="add">Add New Template</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="10%" height="20"  class="head1">Template Name</td> 
                    <td width="40%" height="20"  class="head1">Template Subject</td> 
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryTemplates, $RecordsPerPage, $_GET['curP']);
                (count($arryTemplates) > 0) ? ($arryTemplates = $objPager->getPageRecords()) : ("");
                if (is_array($arryTemplates) && $num > 0) {
                    $flag = true;

                    foreach ($arryTemplates as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Template_Name']; ?>     </td>
                            <td height="26"><?= $values['Template_Subject']; ?>     </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editNewsletterTemplate.php?active_id=' . $values["Templapte_Id"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editNewsletterTemplate.php?edit=<?php echo $values['Templapte_Id']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editNewsletterTemplate.php?del_id=<?php echo $values['Templapte_Id']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Template found. </td>
                    </tr>
<?php } ?>

                <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTemplates) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
    echo $pagerLink;
}
?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
