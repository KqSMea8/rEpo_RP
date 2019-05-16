<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }
    function filterLead(id)
    {
        location.href = "viewLead.php?customview=" + id + "&module=lead&search=Search";
        LoaderSearch();
    }
</script>


<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_lead'])) {
    echo $_SESSION['mess_lead'];
    unset($_SESSION['mess_lead']);
} ?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
        <tr>  
            <td  valign="top" align="right">

                <input type="button" class="export_button"  name="imp" value="Import Lead" onclick="Javascript:window.location = 'importLead.php';" />
                <? if ($num > 0) { ?>

                    <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_lead.php?<?= $QueryString ?>';" />
                    <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
                <? } ?>
                <a class="fancybox add_quick fancybox.iframe" href="addLead.php">Quick Entry</a>
                <a href="editLead.php?module=lead" class="add" >Add Lead</a>

<? if ($_GET['key'] != '') { ?>
                    <a class="grey_bt"  href="viewLead.php?module=<?= $_GET['module'] ?>">View All</a>
        <? } ?>
            </td>
        </tr>

<? if ($num > 0) { ?>
            <tr>
                <td align="right" height="40" valign="bottom">
                    <input type="submit" name="DeleteButton" class="button" value="Delete" onclick="javascript: return ValidateMultiple('lead', 'delete', 'NumField', 'leadID');">
                </td>
            </tr>
<? } ?>


        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >

                                <!--td width="8%"  class="head1" >Lead No</td-->
                                <td class="head1" >Lead Name</td>
                                <td width="11%" class="head1">Company  </td>
                                <!--td width="9%" class="head1">Lead Type  </td-->
                                <td width="9%" class="head1">	Phone  </td>
                                <td width="13%" class="head1" > Primary Email</td>
                                <td  class="head1" > Sales Person</td>
                                <td width="5%"  align="center" class="head1" > Status</td>
                                <td width="11%" align="center" class="head1" > Created Date</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                                <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'leadID', '<?= sizeof($arryLead) ?>');" /></td>
                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

    <? } ?>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                                <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'leadID', '<?= sizeof($arryLead) ?>');" /></td>
                            </tr>

                        <?
                        }
                        if (is_array($arryLead) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;

                            foreach ($arryLead as $key => $values) {
                                $flag = !$flag;
                                #$bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">     
        <? if ($_GET["customview"] == 'All' ) { ?>   
                                      <!--td><?= $LeadNo ?></td-->
                                        <td> 
                                            <a href="vLead.php?view=<?php echo $values['leadID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;module=<?php echo $_GET['module']; ?>" ><?= stripslashes($values["FirstName"]) . " " . stripslashes($values["LastName"]) ?></a>		       </td>
                                        <td><?= (!empty($values['company'])) ? (stripslashes($values['company'])) : (NOT_SPECIFIED) ?></td>
                                <!--td><?= (!empty($values['type'])) ? (stripslashes($values['type'])) : (NOT_SPECIFIED) ?></td-->
                                        <td><?= (!empty($values['LandlineNumber'])) ? (stripslashes($values['LandlineNumber'])) : (NOT_SPECIFIED) ?></td>

                                        <td><?= (!empty($values['primary_email'])) ? (stripslashes($values['primary_email'])) : (NOT_SPECIFIED) ?></td>


                                        <td><?
                                            if ($values['AssignType'] == 'Group') {

                                                $arryGrp = $objGroup->getGroup($values['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];

                                                if ($values['AssignTo'] != '') {
                                                    $arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
                                                    echo $AssignName;
                                                    echo '<br>';
                                                    ?>
                                                    <div> 
                                                        <? foreach ($arryAssignee as $values2) { ?>
                                                        <!--img border="0" title="Manager" src="../images/manager.png"-->
                                                            <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values2['EmpID'] ?>" ><?= $values2['UserName'] ?></a>,<br>
                                                            <?
                                                        }
                                                    }
                                                } else if ($values['AssignTo'] != '') {

                                                    if ($values['AssignTo'] != '') {
                                                        $arryAssignee2 = $objLead->GetAssigneeUser($values['AssignTo']);
                                                        $assignee = $values['AssignTo'];
                                                    }
                                                    $AssignName = $arryAssignee2[0]['UserName'];
                                                    ?>
                                                    <? foreach ($arryAssignee2 as $values3) { ?>
                                                            <!--img border="0" title="Manager" src="../images/manager.png"-->
                                                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values3['EmpID'] ?>" ><?= $values3['UserName'] ?></a>,<br>
                                                        <?
                                                    }
                                                } else {
                                                    echo NOT_SPECIFIED;
                                                }
                                                ?></td>

                                        <td align="center">
                                            <?= (!empty($values['lead_status'])) ? (stripslashes($values['lead_status'])) : (NOT_SPECIFIED) ?>		
                                        </td>

                                        <td align="center">
                                        <?= ($values['UpdatedDate'] > 0) ? (date($Config['DateFormat'], strtotime($values['UpdatedDate']))) : (NOT_SPECIFIED) ?>		
                                        </td>
                                    <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'AssignTo') {
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
                                            


			} else if(($cusValue['colvalue'] == 'UpdatedDate' || $cusValue['colvalue'] == 'JoiningDate' || $cusValue['colvalue'] == 'LeadDate')) {
				
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

                                <td  align="center" class="head1_inner"><a href="vLead.php?view=<?php echo $values['leadID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;module=<?php echo $_GET['module']; ?>" ><?= $view ?></a>
                                    <a href="editLead.php?edit=<?php echo $values['leadID']; ?>&amp;module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&amp;tab=Lead" ><?= $edit ?></a>

                                    <a href="editLead.php?del_id=<?php echo $values['leadID']; ?>&amp;module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   </td>
                                <td ><input type="checkbox" name="leadID[]" id="leadID<?= $Line ?>" value="<?= $values['leadID'] ?>" class="checkbox"/></td>
                                </tr>
                                    <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryLead) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
<? if (sizeof($arryLead)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryLead) ?>">

            </td>
        </tr>
    </table>
</form>
<script language="javascript1.2" type="text/javascript">
$(document).ready(function () {
	$(".checkbox").on("click", function () { 
		//var checked = $(this).is(':checked'); 
		//$(this).closest("tr").toggleClass('selectedbg');
	});	
	 
});
</script>
