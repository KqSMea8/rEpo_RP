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
<div class="had">Manage Email Id </div>
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



            <a href="editImportEmailId.php" class="add">Add Email ID</a>


                <!--a href="viewImportEmailId.php?module=<?= $_GET['module'] ?>" class="grey_bt">View All</a-->


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
                                <td width="15%"  class="head1" >Email Id</td>
                                <td width="6%"  align="center" class="head1" >Status</td>
                                <td width="6%"  align="center" class="head1" >Default Email</td>
                                <td width="6%"  align="center" class="head1" >Import</td>
                                <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
                            </tr>

                        <?php
                        if (is_array($arryEmailList) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryEmailList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                        
                                      <td><?= stripslashes($values["EmailId"]) ?></td>
                                      
                                      

                                      <td align="center" >
                                         <?
                                            if ($values['status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'Inactive';
                                            }

                                            echo '<a href="editImportEmailId.php?active_id=' . $values["id"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            ?> 
                                          
                                          
                                      </td>
                                      <td align="center" >
                                         <?
                                            if ($values['DefalultEmail'] == 1) {
                                                $status = 'Active';
                                                $text='Yes';
                                            } else {
                                                $status = 'Inactive';
                                                $text='No';
                                                
                                            }

                                            echo '<a href="editImportEmailId.php?defaultEmail_id=' . $values["id"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $text . '</a>';
                                            ?> 
                                          
                                          
                                      </td>
                                      <td align="center">
                                           <?
                                            if (($values['status'] == 1) and ($values['DefalultEmail'] == 1) and ($countExist[0][TotalRecords] > 0)) {
                                                $status = 'Import';
                                                echo '<a class="active" href="editImportEmailId.php?activeEmailId=' . $values["id"] .  '&mailImport=UNSEEN&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>&nbsp;&nbsp;<a class="active" href="viewImportedEmails.php?ownerId=' . $values["id"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');"> View</a>';
                                            }else if(($values['status'] == 1) and ($values['DefalultEmail'] == 1) and ($countExist[0][TotalRecords] == 0)) {
                                                $status = 'Import';
                                                echo '<a class="active" href="editImportEmailId.php?activeEmailId=' . $values["id"] .  '&mailImport=&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>&nbsp;&nbsp;<a class="active" href="viewImportedEmails.php?ownerId=' . $values["id"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');"> View</a>';
                                            } 
                                            else {
                                              echo "";
                                            }

                                            
                                            ?> 
                                          
                                          
                                      </td>
                                        
        
                                <td  align="center" class="head1_inner" >

                                    <a href="vImportEmailId.php?view=<?= $values['id'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>
                                    <a href="editImportEmailId.php?edit=<?= $values['id'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $edit ?></a>

                                    <a href="editImportEmailId.php?del_id=<?php echo $values['id']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, 'Email Id  ')"  ><?= $delete ?></a>   </td>
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryEmailList) > 0) { ?>
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
