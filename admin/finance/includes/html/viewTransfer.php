<script language="javascript1.2" type="text/javascript">


    function filterLead(id)
    {
        location.href = "viewTransfer.php?customview=" + id;
        LoaderSearch();
    }
</script>


<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center">
    <?php if (!empty($_SESSION['mess_transfer'])) {
        echo $_SESSION['mess_transfer'];
        unset($_SESSION['mess_transfer']);
    } ?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td align="right" valign="top">
            <a  class="transfer" href="editTransfer.php">Transfer</a>

<? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
<? } ?>


        </td>
    </tr>

    <tr>
        <td  valign="top" height="400">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                                <td width="10%"  class="head1">Transfer Date</td>
                                <td width="15%" class="head1">Transfer From</td>
                                <td width="15%" class="head1">Transfer To</td>
                                <td width="8%" class="head1" align="right">Amount (<?= $Config['Currency'] ?>)</td>
                                <!--<td width="8%" class="head1" align="center">Currency</td>-->
                                <td width="20%" class="head1">Reference No</td>
                                <td width="8%" class="head1" align="center">Action</td>
                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="8%" class="head1" align="center">Action</td>
                            </tr>

                        <?
                        }
                        if (is_array($arryTransfer) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            foreach ($arryTransfer as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                             <? if ($_GET["customview"] == 'All') { ?>  
                                        <td><?= date($Config['DateFormat'], strtotime($values['TransferDate'])); ?></td>
                                        <td><?= stripslashes($values["TransferFrom"]) ?></td> 
                                        <td><?= stripslashes($values["TransferTo"]) ?></td> 
                                        <td align="right"><strong><?= $values["TransferAmount"] ?></strong></td> 
                                        <!--<td align="center"></?=$values["Currency"];?></td>-->
                                        <td><?= stripslashes($values["ReferenceNo"]) ?></td> 

                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'TransferDate') {

                                                if ($values[$cusValue['colvalue']] > 0){
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                }else{
                                                    echo NOT_SPECIFIED;
                                                }
                                                
                                            } else {?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                <? }
                                            echo '</td>';
                                        }
                                    }
                                    ?>
                                    <td height="26" align="center" class="head1_inner">
                                        <a href="vTransfer.php?view=<?= $values['TransferID'] ?>&curP=<?= $_GET['curP'] ?>"><?= $view ?></a>
                                        <!--<a href="editTransfer.php?edit=<?php echo $values['TransferID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>-->
                                        <a href="editTransfer.php?del_id=<?php echo $values['TransferID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Transfer')" class="Blue" ><?= $delete ?></a>
                                        &nbsp;
                                    </td>

                                </tr>
                            <?php } // foreach end // ?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="6" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr><td colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?><?php if (count($arryTransfer) > 0) { ?>&nbsp;&nbsp;&nbsp;Page(s) :&nbsp; <?php echo $pagerLink;
                            }
?></td>
                        </tr>
                    </table>

                </div> 


            </form>
        </td>
    </tr>
</table>
