<script>
    function reply_comment(id) {
        if (document.getElementById('reply_' + id).style.display = 'none') {
            document.getElementById('reply_' + id).style.display = 'block';
        } else {
            document.getElementById('reply_' + id).style.display = 'block';
        }
    }
</script>


<? if ($_GET['pop'] != 1) { ?>


    <?
    /*     * ****************** */
    /*     * ****************** */
    $Module = $ModuleName;
    $NextID = $objCommon->NextPrevTicket($_GET['view'], 1);
    $PrevID = $objCommon->NextPrevTicket($_GET['view'], 2);
    $NextPrevUrl = "vTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    include("includes/html/box/next_prev.php");
    /*     * ****************** */
    /*     * ****************** */
    ?>


    <div class="back"><a class="back" href="<?= $RedirectURL ?>">Back</a> <a class="edit" href="<?= $EditUrl ?>">Edit</a></div>

    <div class="had">
        View Ticket   <span> &raquo; 
            <? echo (!empty($_GET['tab'])) ? ( $_GET['tab']) : ($ModuleName); ?>

        </span>
    </div>
<? } ?>

<br>



<? if ($_GET['tab'] != "Information") { ?>
    <h2><font color="darkred"> Ticket [<?= $arryTicket[0]['TicketID'] ?>] : <?php echo stripslashes($arryTicket[0]['title']); ?> </font>         </h2>

<? } ?>


<? if (!empty($_SESSION['mess_ticket'])) { ?>

    <div  align="center"  class="message"  >
        <? if (!empty($_SESSION['mess_ticket'])) {
            echo $_SESSION['mess_ticket'];
            unset($_SESSION['mess_ticket']);
        } ?>	
    </div>

<? } ?>


<? if ($_GET['tab'] == "Information") { ?>

    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">





        <tr>
            <td colspan="4" align="left" class="head">Ticket Information</td>
        </tr>
        <tr>
            <td  align="right"  class="blackbold"> Title  :</td>
            <td   align="left" >
                <?php echo stripslashes($arryTicket[0]['title']); ?>            </td>

            <td  align="right"   class="blackbold"> Assigned To  : </td>
            <td   align="left" > <? if ($arryTicket[0]['AssignType'] == 'Group') { ?>
                        <?= $AssignName ?> <br>
                    <? } ?>
                <div> <? foreach ($arryAssignee as $values) {
                    ?>
                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>" ><?= $values['UserName'] ?></a>,
    <? } ?>
            </td>
        </tr>

        <tr>
            <td  align="right"   class="blackbold" width="20%">Ticket Status  : </td>
            <td   align="left" width="30%">
    <?= (!empty($arryTicket[0]['Status'])) ? (stripslashes($arryTicket[0]['Status'])) : (NOT_SPECIFIED) ?>

            </td>

            <td  align="right"   class="blackbold" width="20%"> Priority : </td>
            <td   align="left" >
    <?= (!empty($arryTicket[0]['priority'])) ? ($arryTicket[0]['priority']) : (NOT_SPECIFIED) ?>

            </td>
        </tr>

        <tr>
            <td  align="right"   class="blackbold">Ticket Category : </td>
            <td   align="left" >

    <?php echo stripslashes($arryTicket[0]['category']); ?>
            </td>

            <td  align="right"   class="blackbold"> Days : </td>
            <td   align="left" >
    <?php echo stripslashes($arryTicket[0]['day']); ?> </td>
        </tr>
        <tr>
            <td  align="right"   class="blackbold"> Hours : </td>
            <td   align="left" >
    <?php echo stripslashes($arryTicket[0]['hours']); ?>  </td>

            <td  align="right"   class="blackbold">  Customer : </td>
            <td   align="left" >
    <? if (!empty($arryCustomer[0]['FullName'])) { ?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $arryCustomer[0]['CustCode'] ?>"><?= (stripslashes($arryCustomer[0]['FullName'])) ?> </a> <? } else {
        echo NOT_SPECIFIED; ?> <? } ?>	    

            </td>
        </tr>




        <tr>
            <td colspan="4" align="left"   class="head">Description Details</td>
        </tr>

        <tr>
            <td align="right"   class="blackbold" valign="top">Description :</td>
            <td  align="left" colspan="3">
    <? echo stripslashes($arryTicket[0]['description']); ?>

            </td>
        </tr>

        <tr>
            <td colspan="4" align="left"   class="head">Ticket Resolution</td>
        </tr>


        <tr>
            <td align="right"   class="blackbold" valign="top">Solution :</td>
            <td  align="left" colspan="3">
        <?= stripslashes($arryTicket[0]['solution']) ?>		          </td>
        </tr>

    <? if ($HideNavigation != 1) { ?>
            <tr>
                <td colspan="4" align="left"   ><?php include("includes/html/box/comment.php"); ?></td>
            </tr>

    <? } ?>



    </table>	
<? } ?>
<?php if ($_GET['tab'] == "Comments") {
    include("includes/html/box/comment.php");
} ?>
<?php if ($_GET['tab'] == "Document") {
    include("box/document.php");
} ?>


<? if ($_GET['tab'] == "Campaign") { ?>

    <div id="preview_div">

        <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
            <tr>
                <td align="right">
                    <a class="button" style="font-size:12px; color:#FFFFFF;" href="#" onclick="return window.open('leadCompaign.php?module=<?= $_GET['tab'] ?>&amp;return_module=<?= $_GET['module'] ?>&amp;parent_type=<?= $_GET['module'] ?>&amp;parentID=<?= $_GET['view'] ?>', 'test', 'width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Campaign</b></a>




                </td>
            </tr>



            <tr>
                <td  valign="top">
                    <table <?= $table_bg ?>>



             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?= sizeof($arryCampaign) ?>');" /></td>-->
                        <td width="18%"  class="head1" >Campaign Name</td>
                        <td width="14%"  class="head1" >Campaign Type</td>
                        <td width="12%"  class="head1" >Campaign Status</td>
                        <td width="12%" class="head1" >Expected Revenue</td>
                        <td width="13%" class="head1" >Expected Close Date</td>

                        <td width="16%"  align="center" class="head1" >Assign To</td>
                        <td width="15%"  align="center" class="head1" >Action</td>
            </tr>

            <?php
            if (is_array($arryCampaign) && $num > 0) {
                $flag = true;
                $Line = 0;
                foreach ($arryCampaign as $key => $values) {
                    $flag = !$flag;
                    #$bgcolor=($flag)?("#FDFBFB"):("");
                    $Line++;

                    //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                    ?>
                    <tr align="left"  bgcolor="<?= $bgcolor ?>">
                     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?= $Line ?>" value="<?= $values['campaignID'] ?>" /></td>-->
                        <td ><?= stripslashes($values["campaignname"]) ?></td>
                        <td height="20" > <?= stripslashes($values["campaigntype"]) ?>	 </td>
                        <td height="20" > <?= stripslashes($values["campaignstatus"]) ?>	 </td>

                        <td><?= $values['expectedrevenue'] ?> <?= $Config['Currency'] ?></td>
                        <td height="20" > 
                                <? if ($values["closingdate"] != "0000-00-00") {//echo $Config['DateFormat'];
                                    echo date($Config['DateFormat'], strtotime($values["closingdate"]));
                                }
                                ?> </td>

                        <td><a class="fancybox fancybox.iframe" href="../hrms/empInfo.php?view=<?= $values['EmpID'] ?>">



                    <?= $values['AssignTo'] ?>(<?= $values['Department'] ?>)</a></td>


                        <td  align="center"  >
                            <a href="vCampaign.php?view=<?= $values['campaignID'] ?>&module=Campaign&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>

                            <a href="editCampaign.php?edit=<?php echo $values['campaignID']; ?>&module=Campaign&amp;curP=<?php echo $_GET['curP']; ?>&tab=Edit" ><?= $edit ?></a>

                            <a href="vTicket.php?view=<?= $_GET['view'] ?>&select_del_id=<?php echo $values['sid']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   </td>
                    </tr>
                        <?php } // foreach end // ?>

    <?php } else { ?>
                <tr align="center" >
                    <td  colspan="8" class="no_record">No record found. </td>
                </tr>
    <?php } ?>

            <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryCampaign) > 0) { ?>
                        &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
    }
    ?></td>
            </tr>
        </table>      </td>
    </tr>

    </TABLE>

    </div> 
            <? } ?>

<? if ($_GET['tab'] == "Event") { ?>



    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

    <? if (!empty($_SESSION['mess_Event'])) { ?>
            <tr>
                <td  align="center"  class="message"  >
        <? if (!empty($_SESSION['mess_Event'])) {
            echo $_SESSION['mess_Event'];
            unset($_SESSION['mess_Event']);
        } ?>	
                </td>
            </tr>
    <? } ?>
        <tr>
            <td align="right">

                <a class="fancybox fancybox.iframe add"  href="addActivity.php?module=<?= $_GET['module'] ?>&parent_type=<?= $_GET['module'] ?>&parentID=<?= $_GET['view'] ?>" >Add Event</a>


            </td>
        </tr>



        <tr>
            <td  valign="top">
                <table <?= $table_bg ?>>

                    <tr align="left"  >
                     <!-- <td width="5%" class="head1" >
                <input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','activityID','<?= sizeof($arryActivity) ?>');" /></td>-->

                        <td width="15%"  class="head1" >Title</td>
                        <td width="13%" class="head1"> Activity Type </td>
                        <td width="12%" class="head1" >Priority</td>
                        <td width="19%" class="head1" > Start Date</td>
                        <td width="19%" class="head1" > Close Date</td>
                        <td width="11%"  align="center" class="head1" >  Status</td>
                        <td width="12%"  align="center" class="head1" >Action</td>
                    </tr>

    <?php
    if (is_array($arryActivity) && $num > 0) {
        $flag = true;
        $Line = 0;
        foreach ($arryActivity as $key => $values) {
            $flag = !$flag;
            #$bgcolor=($flag)?("#FDFBFB"):("");
            $Line++;

            //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
            ?>
                            <tr align="left"  bgcolor="<?= $bgcolor ?>">
                              <!--<td ><input type="checkbox" name="activityID[]" id="activityID<?= $Line ?>" value="<?= $values['activityID'] ?>" /></td>-->

                                <td height="22" > 
                                    <a class="fancybox fancybox.iframe" href="vActivity.php?view=<?= $values['activityID'] ?>&pop=1"> <? echo stripslashes($values["subject"]); ?></a> 	       </td>
                                <td><?= $values['activityType'] ?></td>
                                <td>
            <?= (!empty($values['priority'])) ? (stripslashes($values['priority'])) : (NOT_SPECIFIED) ?>
                                </td>

                                <td>
                            <?php
                            $stdate = $values["startDate"] . " " . $values["startTime"];
                            echo date($Config['DateFormat'] . " H:i A", strtotime($stdate));
                            ?>
                                </td>
                                <td>
                            <?php
                            $cldate = $values["closeDate"] . " " . $values["closeTime"];
                            echo date($Config['DateFormat'] . " H:i A", strtotime($cldate));
                            ?>
                                </td>
                                <td align="center"><? $status = $values['status'];
                            echo $status; ?></td>
                                <td  align="center" >
                                    <a href="vTicket.php?act_id=<?php echo $values['activityID']; ?>&view=<?= $_GET['view'] ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&tab=Event" onclick="return confirmDialog(this, 'Event')"  ><?= $delete ?></a> </td>
                            </tr>
        <?php } // foreach end //?>

    <?php } else { ?>
                        <tr align="center" >
                            <td  colspan="9" class="no_record">No record found. </td>
                        </tr>
    <?php } ?>

                    <tr>  
                        <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryActivity) > 0) { ?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
    } ?></td>
                    </tr>
                </table> 
            </td>
        </tr>  
    </TABLE>

<? } ?>
	




