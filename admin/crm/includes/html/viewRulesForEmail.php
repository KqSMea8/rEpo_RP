<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewImportEmailId.php?module=email&customview=" + id;
        LoaderSearch();
    }
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_contact1'])) {
    echo $_SESSION['mess_contact1'];
    unset($_SESSION['mess_contact1']);
} ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


    <tr>
        <td align="right">




            <a href="editImportEmailRule.php" class="add ">Add Rule</a>


           


        </td>
    </tr>

    <tr>
        <td  valign="top">



            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="3%"  class="head1" >Email For Rule</td>
                                <td width="10%"  align="" class="head1" >Rules Applied</td>
                                <td width="2%"  align="center" class="head1">Status</td>
                                <td width="2%"  align="center"  class="head1 head1_action" >Action</td>
                            </tr>

                        <?php
                        if (is_array($arryRuleList) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryRuleList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                        
                                      <td><?= stripslashes($values["RuleForEmail"]) ?></td>
                                      
                                      

                                      <td  >
                                         &nbsp;<input type="checkbox" name="Markread" id="Markread" value="1" <?php if($values["ReadEmail"]==1) echo "checked"; ?>> Mark as read&nbsp; &nbsp;
                                        <input type="checkbox" name="MarkasFlagged" id="MarkasFlagged" value="1" <?php if($values["FlaggedEmail"]==1) echo "checked";?> > Mark as flagged &nbsp; &nbsp; 
                                        Moved To Folder ::&nbsp;&nbsp;<?php if($values["MoveToFolder"]==0)
                                        {
                                           echo "No"; 
                                        }else {
                                            
                                            echo $values["FolderName"];
                                        }
                                            
                                            ?>
                                          
                                      </td>
                                      
                                      <td align="center">
                                          <?php 
                                            if ($values['RuleStatus'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'Inactive';
                                            }

                                            echo '<a href="editImportEmailRule.php?active_id=' . $values["RuleID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            ?> </td>
                                      
                                <td  align="center" class="head1_inner" >

                                    <!--a href="vImportEmailId.php?view=<?= $values['RuleID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a-->
                                    <a class="" href="editImportEmailRule.php?edit=<?= $values['RuleID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $edit ?></a>

                                    <a href="editImportEmailRule.php?del_id=<?php echo $values['RuleID']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, 'Email Rule  ')"  ><?= $delete ?></a>   </td>
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryRuleList) > 0) { ?>
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
