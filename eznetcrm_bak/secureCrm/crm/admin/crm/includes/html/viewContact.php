<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewContact.php?module=contact&customview=" + id;
        LoaderSearch();
    }
</script>
<div class="had">Manage Contact</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_contact'])) {
    echo $_SESSION['mess_contact'];
    unset($_SESSION['mess_contact']);
} ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


    <tr>
        <td align="right">

            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_contact.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>



            <a href="editContact.php?module=<?= $_GET['module'] ?>" class="add">Add Contact</a>

<? if ($_GET['key'] != '') { ?>
                <a href="viewContact.php?module=<?= $_GET['module'] ?>" class="grey_bt">View All</a>
<? } ?>


        </td>
    </tr>

    <tr>
        <td  valign="top">



            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="15%"  class="head1" >First Name</td>
                                <td width="15%"  class="head1" >Last Name</td>
                                <td width="20%"  class="head1" >Email</td>
                                <td width="15%"  class="head1" >Title</td>

                                <td  class="head1" >Assign To</td>
                                <td width="6%"  align="center" class="head1" >Status</td>
                                <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
                            </tr>

                        <? } ?>
                        <?php
                        if (is_array($arryContact) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryContact as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                        <? if ($_GET["customview"] == 'All') { ?> 
                                        <!--<td ><input type="checkbox" name="AddID[]" id="AddID<?= $Line ?>" value="<?= $values['AddID'] ?>" /></td>-->
                                         <!--td ><?= $values["AddID"] ?></td-->
                                        <td >
                                            <?= stripslashes($values["FirstName"]) ?></a>		 </td>

                                        <td  >
            <?= stripslashes($values["LastName"]) ?>		 </td>


                                        <td><? echo '<a href="mailto:' . $values['Email'] . '">' . $values['Email'] . '</a>'; ?></td>

                                        <td ><?= (!empty($values['Title'])) ? (stripslashes($values['Title'])) : (NOT_SPECIFIED) ?></td>
                                        <td ><? if (!empty($values['AssignTo'])) { ?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>"><?= stripslashes($values['AssignTo']) ?></a><? } else {
                                echo NOT_ASSIGNED;
                            } ?></td>

                                        <td align="center" >
                                            <?
                                            if ($values['Status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }

                                            echo '<a href="editContact.php?active_id=' . $values["AddID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            ?></td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'DepositDate') {

                                                if ($values[$cusValue['colvalue']] > 0) {
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                } else {
                                                    echo NOT_SPECIFIED;
                                                }
                                            } else if ($cusValue['colvalue'] == 'Status') {

                                                if ($values[$cusValue['colvalue']] == 1) {
                                                    $status = 'Active';
                                                } else {
                                                    $status = 'InActive';
                                                }

                                                echo '<a href="editContact.php?active_id=' . $values["AddID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            }else if($cusValue['colvalue'] == 'CustID'){ 
                                               
                                                if(!empty($values['CustID'])){ echo $values['CustomerName'];}else{ echo NOT_SPECIFIED;}
                                                
                                            } else if ($cusValue['colvalue'] == 'AssignTo') {
                                                if (!empty($values['AssignTo'])) {
                                                    ?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>"><?= stripslashes($values['AssignTo']) ?></a><? } else {
                        echo NOT_ASSIGNED;
                    } ?>


                                        <? } else { ?>

                                            <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                <?
                }
                echo '</td>';
            }
        }
        ?>
                                <td  align="center" class="head1_inner" >

                                    <a href="vContact.php?view=<?= $values['AddID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>
                                    <a href="editContact.php?edit=<?= $values['AddID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $edit ?></a>

                                    <a href="editContact.php?del_id=<?php echo $values['AddID']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   </td>
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryContact) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryContact)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>
