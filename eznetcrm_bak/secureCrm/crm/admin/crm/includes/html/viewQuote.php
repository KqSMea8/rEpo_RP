<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }

    function filterLead(id)
    {
        location.href = "viewQuote.php?customview=" + id + "&module=Quote&search=Search";
        LoaderSearch();
    }

</script>

<div class="had">Manage <?= $_GET['module'] ?>s</div>

<div class="message" align="center"><?
    if (!empty($_SESSION['mess_quote'])) {
        echo $_SESSION['mess_quote'];
        unset($_SESSION['mess_quote']);
    }
    ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

    <tr>
        <td align="left">
            <a class="add" href="editQuote.php?module=<?= $_GET['module'] ?>" >Add <?= $_GET['module'] ?></a>
            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_quote.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>
            <? if ($_GET['key'] != '') { ?>
                <a class="grey_bt" href="viewQuote.php?module=<?= $_GET['module'] ?>">View All</a>
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
                        <input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','quoteID','<?= sizeof($arryQuote) ?>');" /></td>-->
                                <!--td width="8%"  class="head1" >Quote No</td-->
                                <td   class="head1" >Subject</td>
                                <td width="12%" class="head1"> Quote Stage </td>
                                <!--td  class="head1" >Opportunity Name</td-->
                                <td width="15%" class="head1" >Valid Till</td>
                                <td  class="head1" width="15%" > Total [<?= $Config['Currency'] ?>]</td>
                                <td width="15%"   class="head1" > Created Date</td>
                                <td width="10%"  align="center" class="head1" >Action</td>
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
                        if (is_array($arryQuote) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryQuote as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
        <? if ($_GET["customview"] == 'All') { ?> 
                                          <!--<td ><input type="checkbox" name="quoteID[]" id="quoteID<?= $Line ?>" value="<?= $values['quoteID'] ?>" /></td>-->
                                          <!--td ><?= $values["quoteid"] ?></td-->
                                        <td height="22" > 
                                            <?
                                            echo stripslashes($values["subject"]);
                                            ?>		       </td>

                                        <td><?= $values['quotestage'] ?></td>
                                        <!--td><?= (!empty($values['opportunityName'])) ? (stripslashes($values['opportunityName'])) : (NOT_SPECIFIED) ?>
                                               <!-- <a href="javascript:;" onclick="RediUrl('<?= $values['OpportunityID'] ?>','opportunity');"><?= $values['OpportunityName'] ?></a>--></td-->
                                        <td> <?
                                            if ($values["validtill"] >0 ) {//echo $Config['DateFormat'];
                                                echo date($Config['DateFormat'], strtotime($values["validtill"]));
                                            }
                                            ?></td>
                                        <td><? echo $values['TotalAmount']; ?> </td>

                                        <td>
                                            <?
                                            if ($values["PostedDate"] >0) {//echo $Config['DateFormat'];
                                                echo date($Config['DateFormat'], strtotime($values["PostedDate"]));
                                            }
                                            ?>
                                        </td>

                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'assignTo') {
                                                if ($values[$cusValue['colvalue']] != '') {
                                                    $arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

                                                    foreach ($arryAssignee as $users) {
                                                        ?>
                                                    <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $users['EmpID'] ?>" ><?= $users['UserName'] ?></a>,
                                                    <?
                                                }
                                            } else {
                                                echo "Not Specified";
                                            } 
                                        } else if ($cusValue['colvalue'] == 'validtill' || $cusValue['colvalue'] == 'PostedDate') {
                                            

if($values[$cusValue['colvalue']]>0)
	echo date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']]));


?>
                                            		
                                        <? } else if ($cusValue['colvalue'] == 'CustType' && $values[$cusValue['colvalue']] != '') {
                                            ?>
                                            <?= ($values[$cusValue['colvalue']] == 'c') ? ("Customer") : ("Opportunity") ?>		
                                        <? } else { ?>

                                            <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                            <?
                                        }

                                        echo '</td>';
                                    }
                                }
                                ?>

                                <td  align="center" class="head1_inner" ><a href="vQuote.php?view=<?php echo $values['quoteid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&module=<?php echo $_GET['module']; ?>"><?= $view ?></a>
                                    <a href="editQuote.php?edit=<?php echo $values['quoteid']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&tab=Quote" ><?= $edit ?></a>
                                    <a href="editQuote.php?del_id=<?php echo $values['quoteid']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a> 

                                    <br><a class="fancybox fancybox.iframe" href="<?= $SendUrl . '&view=' . $values['quoteid'] ?>" >Send Quote</a>

                                </td>
                                </tr>
    <?php } // foreach end // ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record">No record found. </td>
                            </tr>
<?php } ?>



                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryQuote) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
    echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
<? if (sizeof($arryQuote)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'quoteID', 'editQuote.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'quoteID', 'editQuote.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'quoteID', 'editQuote.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>
