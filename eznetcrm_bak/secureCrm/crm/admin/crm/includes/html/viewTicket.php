<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }
    function filterLead(id)
    {

        location.href = "viewTicket.php?customview=" + id + "&module=Ticket&search=Search"
        LoaderSearch();
    }
</script>
<div class="had">Manage <?= $_GET['parent_type'] ?> Ticket</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_ticket'])) {
    echo $_SESSION['mess_ticket'];
    unset($_SESSION['mess_ticket']);
} ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  align="right">


            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_ticket.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>

            <a href="<?= $AddUrl ?>" class="add" >Add <?= $_GET['parent_type'] ?> Ticket</a>

<? if ($_GET['key'] != '') { ?>
                <a class="grey_bt"  href="<?= $ViewUrl ?>">View All</a>
<? } ?>
        </td>
    </tr>

    <tr>
        <td  valign="top">

            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                                  <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?= sizeof($arryTicket) ?>');" /></td>-->
                                <!--td width="7%"  class="head1" >Ticket ID</td-->
                                <td class="head1" >Title</td>
                                <td width="22%" class="head1" > Assign To</td>	
                                <td width="12%"  align="center" class="head1" >Status</td>
                                <td width="12%" class="head1" align="center"> Created On</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>

                        <? } ?>


                        <?php
                        if (is_array($arryTicket) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryTicket as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                echo '<tr align="left"  bgcolor="' . $bgcolor . '">';
                                if ($_GET["customview"] == 'All') {
                                    //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                    ?>

             <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?= $Line ?>" value="<?= $values['TicketID'] ?>" /></td>-->
              <!--td ><?= $values["TicketID"] ?></td-->
                                    <td > 
                                        <a href="<? echo $vTicket . $values['TicketID'] ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= stripslashes($values['title']) ?></a>	       </td>


                                    <td>
                                        <?
                                        if ($values['AssignType'] == 'Group') {

                                            $arryGrp = $objGroup->getGroup($values['GroupID'], 1);
                                            $AssignName = $arryGrp[0]['group_name'];
                                            ?>

                                            <?php
                                            if ($values['AssignedTo'] != '') {
                                                $arryAssignee = $objLead->GetAssigneeUser($values['AssignedTo']);
                                                echo $AssignName;
                                                ?>
                                                <div> 
                                                    <? foreach ($arryAssignee as $values2) { ?>
                                                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values2['EmpID'] ?>" ><?= $values2['UserName'] ?></a>,
                                                    <?
                                                    }
                                                }
                                            } else if ($values['AssignedTo'] != '') {

                                                if ($values['AssignedTo'] != '') {
                                                    $arryAssignee2 = $objLead->GetAssigneeUser($values['AssignedTo']);
                                                    $assignee = $values['AssignedTo'];
                                                }
                                                $AssignName = $arryAssignee2[0]['UserName'];
                                                ?>
                <? foreach ($arryAssignee2 as $values3) { ?>
                                                    <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values3['EmpID'] ?>" ><?= $values3['UserName'] ?></a>,
                <?
                }
            } else {
                echo NOT_SPECIFIED;
            }
            ?>


                                    </td>

                                    <td align="center"><? echo $values['Status']; ?></td>

                                    <td align="center"> <? echo date($Config['DateFormat'], strtotime($values["ticketDate"])); ?></td>

                                <?
                                } else {

                                    foreach ($arryColVal as $key => $cusValue) {
                                        echo '<td>';
                                        if ($cusValue['colvalue'] == 'AssignedTo') {
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


					} else if($cusValue['colvalue'] == 'ticketDate') {
				
				if($values[$cusValue['colvalue']]>0)
				echo date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']]));





                                        } else {
                                            ?>

                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                <?
                }

                echo '</td>';
            }
        }
        ?>

                                <td  align="center"   class="head1_inner"><a href="<? echo $vTicket . $values['TicketID'] ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= $view ?></a>
                                    <a href="<?= $editTicket ?><?php echo $values['TicketID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= $edit ?></a>

                                    <a href="<?= $DelTicket ?><?php echo $values['TicketID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a> 

                                    <br><a class="fancybox com fancybox.iframe"  href="<? echo $vTicket . $values['TicketID'] ?>&curP=<?php echo $_GET['curP']; ?>&tab=Comments&pop=1" >Comments</a>



                                </td>
                                </tr>
                    <?php } // foreach end // ?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTicket) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
<? if (sizeof($arryTicket)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'TicketID', 'editTicket.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'TicketID', 'editTicket.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'TicketID', 'editTicket.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".com").fancybox({
            autoSize: false,
            'width': 800,
            'height': 600,
        });


    });

</script>
