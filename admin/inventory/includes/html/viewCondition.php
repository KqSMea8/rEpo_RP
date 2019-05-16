<div class="had">Manage Condition <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td ><br>
            <div class="message"><?
if (!empty($_SESSION['mess_cond'])) {
    echo stripslashes($_SESSION['mess_cond']);
    unset($_SESSION['mess_cond']);
}
?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right">

                        <? if ($LevelCondition > 0) { ?>
                            <a href="editCondition.php?ParentID=<?= $ParentID ?>&curP=<?php echo $_GET['curP']; ?>" class="add">Add <?= $cat_title ?></a>
                        <? } ?>
 <? if ($_GET['key'] !='') { ?>
                            <a href="viewCondition.php?curP=<?php echo $_GET['curP']; ?>" class="grey_bt">view All</a>
<? } ?>
                        <? if ($ParentID > 0) { ?>
                            <a href="viewCondition.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="back">Back</a>
<? } ?>

                    </td>
                </tr>

            </table>

            <table <?= $table_bg ?> class="view-category">
                <tr align="left" >
                    <td width="60%" height="20"  class="head1" >
<?= $cat_title ?>
                        Name</td>

                    <td  height="20" width="20%" class="head1" align="center">Sort Order</td>
                    <td  height="20" width="10%" class="head1" align="center">Status</td>
                    <td width="10%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
               // $pagerLink = $objPager->getPager($arryCategory, $RecordsPerPage, $_GET['curP']);
                //(count($arryCategory) > 0) ? ($arryCategory = $objPager->getPageRecords()) : ("");
               
                if (is_array($arryCondition) && $num > 0) {
                    $flag = true;

                    foreach ($arryCondition as $key => $values) {
                        $flag = !$flag;
                        //$bgcolor=($flag)?(""):("#eeeeee");

                        //$arrySubCondition = $objCondition->GetSubConditionByParent($_GET['key'], $values['ConditionID']);

$ConditionTransaction = $objCondition->GetConditionTransaction($values['Name']);
//echo $ConditionTransaction;
													
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"  align="left">
                                <table border="0" cellspacing="0" cellpadding="0" class="margin-left">
                                    <tr>
                                        <td align="left">
                                            <a href="editCondition.php?edit=<?php echo $values['ConditionID']; ?>&ParentID=<?php echo $values['ParentID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue">
                                                <b><?= stripslashes($values['Name']) ?></b>
                                            </a>
                                        </td>
                                    </tr>
                                </table></td>
                            <td align="center"><?= $values['sort_order']; ?></td>
                            <td align="center" ><?
                        if ($values['Status'] == 1) {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }



                        echo '<a href="editCondition.php?active_id=' . $values["ConditionID"] . '&ParentID=' . $values['ParentID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>';
                        ?></td>
                            <td height="26" align="right"  valign="top">
                                <a href="editCondition.php?edit=<?php echo $values['ConditionID']; ?>&ParentID=<?php echo $values['ParentID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <? if (empty($ConditionTransaction)) { ?>
                                    <a href="editCondition.php?del_id=<?php echo $values['ConditionID']; ?>&curP=<?php echo $_GET['curP']; ?>&ParentID=<?php echo $values['ParentID']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>
                                <? } ?> 

                                &nbsp;</td>
                        </tr>
                       <?
                        
                    } // foreach end //
                    ?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No <?= strtolower($cat_title) ?> found. </td>
                    </tr>
<?php } ?>

                <!--<tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?//php echo $num; ?>      <?//php if (count($arryCategory) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                //echo $pagerLink;
            //}
?></td>
                </tr>-->
            </table></td>
    </tr>


</table>
