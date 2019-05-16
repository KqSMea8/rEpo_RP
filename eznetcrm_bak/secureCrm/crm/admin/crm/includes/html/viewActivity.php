<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
        /*
         var frm  = document.form1;
         var frm2 = document.form2;
         if(SearchBy==1)  { 
         location.href = 'viewActivity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
         } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
         location.href = 'viewActivity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
         }
         return false;
         */
    }

    function filterLead(id)
    {

        location.href = "viewActivity.php?customview=" + id + "&module=Activity&search=Search";
        LoaderSearch();
    }
</script>

<div class="had">Manage Event / Task</div>

<div class="message" align="center"><?
    if (!empty($_SESSION['mess_activity'])) {
        echo $_SESSION['mess_activity'];
        unset($_SESSION['mess_activity']);
    }
    ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td align="right">
            <!--div align="left">
            <b>Status :</b> <select name="event_status" class="inputbox" id="event_status" onchange="return filterEvent(this.value);" >
                            <option value="">--- Select ---</option>
                            
                                    <option value="Planned"<?
            if ($_GET['key'] == "Planned") {
                echo "selected";
            }
            ?>>Planned</option>
                        <option value="Held" <?
            if ($_GET['key'] == "Held") {
                echo "selected";
            }
            ?>>Held</option>
                        <option value="Not Held" <?
            if (stripslashes($_GET['key']) == "Not Held") {
                echo "selected";
            }
            ?>>Not Held</option>
                            </select>
            </div-->
            <? if ($num > 0) { ?>

                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>

            <a class="add" href="editActivity.php?module=<?= $_GET['module'] ?>&mode=Event" >Add Event / Task</a>
            <? if ($_GET['key'] != '') { ?>
                <a class="grey_bt" href="viewActivity.php?module=<?= $_GET['module'] ?>">View All</a>
            <? } ?>
        </td>
    </tr>
    <tr>
        <td  valign="top">



            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none">
                    <img src="images/loading.gif">&nbsp;Searching.........</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                        <? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                             <!-- <td width="5%" class="head1" >
                        <input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','activityID','<?= sizeof($arryActivity) ?>');" /></td>-->
                                <!--td width="6%"  class="head1" >ID</td-->
                                <td  class="head1" >Title</td>
                                <td width="12%" class="head1"> Activity Type </td>
                                <td width="10%" class="head1" >Priority</td>
                                <td width="12%" class="head1" >Created By</td>
                                <td width="15%" class="head1" > Start Date</td>
                                <td width="15%" class="head1" > Close Date</td>
                                <td width="8%"  align="center" class="head1" >  Status</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                        <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                                <? } ?>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>

                            </tr>

                            <?
                        }

                        if (is_array($arryActivity) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryActivity as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;


                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">

                                    <? if ($_GET["customview"] == 'All') { ?>  
                                    <!--<td ><input type="checkbox" name="activityID[]" id="activityID<?= $Line ?>" value="<?= $values['activityID'] ?>" /></td>-->
                                    <!--td ><?= $values["activityID"] ?></td-->
                                        <td height="22" > 
                                            <?
                                            echo stripslashes($values["subject"]);
                                            ?>		       </td>
                                        <td><?= $values['activityType'] ?></td>
                                        <td><?= (!empty($values['priority'])) ? (stripslashes($values['priority'])) : (NOT_SPECIFIED) ?> </td>
                                        <td>
                                            <?php
                                            if ($values['created_by'] == 'admin') {

                                                $created_by = "Admin";
                                                ?>

                                                <?= $created_by ?> 

                                                <?
                                            } else {

                                                $created_by = $values['created'];
                                                ?>
                                                <a class="fancybox fancybox.iframe" href="../hrms/empInfo.php?view=<?= $values["created_id"] ?>"><?= $created_by ?> </a>
                                                <?
                                            }
                                            ?>


                                        </td>
                                        <td>
                                            <?php
                                            $stdate = $values["startDate"] . " " . $values["startTime"];
                                            echo date($Config['DateFormat'] . " H:i A", strtotime($stdate));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ctdate = $values["closeDate"] . " " . $values["closeTime"];
                                            echo date($Config['DateFormat'] . " H:i A", strtotime($ctdate));
                                            ?>
                                        </td>

                                        <td align="center"><?
                                            $status = $values['status'];
                                            echo $status;
                                            ?></td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'assignedTo') {
                                                if ($values[$cusValue['colvalue']] != '') {
                                                    $arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

                                                    foreach ($arryAssignee as $users) {
                                                        ?>
                                                    <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $users['EmpID'] ?>" ><?= $users['UserName'] ?></a>,
                                                    <?
                                                }
                                            } else {
                                                echo NOT_SPECIFIED;
                                            }
                                        } else if ($cusValue['colvalue'] == 'startDate') {

                                            $stdate = $values["startDate"] . " " . $values["startTime"];
                                            ?>

                                            <?= ($values[$cusValue['colvalue']] > 0) ? (date($Config['DateFormat'] . " H:i A", strtotime($stdate))) : (NOT_SPECIFIED) ?>   
                                            <?
                                        } else if ($cusValue['colvalue'] == 'closeDate') {

                                            $cldate = $values["closeDate"] . " " . $values["closeTime"];
                                            ?>

                                            <?= ($values[$cusValue['colvalue']] > 0) ? (date($Config['DateFormat'] . " H:i A", strtotime($cldate))) : (NOT_SPECIFIED) ?>   
                                        <? } else if ($cusValue['colvalue'] == 'Notification') { ?>

                                            <?= ($values[$cusValue['colvalue']] == 1) ? ("Yes") : ("No") ?>   
                                        <? } else if ($cusValue['colvalue'] == 'reminder') { ?>

                                            <?= ($values[$cusValue['colvalue']] == 1) ? ("Yes") : ("No") ?>   
                                        <? } else { ?>

                                            <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                            <?
                                        }

                                        echo '</td>';
                                    }
                                }
                                ?> 

                                <td  align="center" class="head1_inner" >
                                    <?php
                                    if ($values['activityType'] == "Task") {
                                        $mode = "Task";
                                    } else {
                                        $mode = "Event";
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="window.location = 'vActivity.php?view=<?php echo $values['activityID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&module=<?php echo $_GET['module']; ?>&mode=<?= $mode ?>';">
                                        <?= $view ?></a>
                                    <a href="javascript:;" onclick="window.location = 'editActivity.php?edit=<?php echo $values['activityID']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&mode=<?= $mode ?>&tab=Activity';" ><?= $edit ?></a>
                                    <a href="editActivity.php?del_id=<?php echo $values['activityID']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a> </td>
                                </tr>
                            <?php } // foreach end //   ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryActivity) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryActivity)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
                <? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>
