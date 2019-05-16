<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><?
    if (!empty($_SESSION['mess_transfer'])) {
        echo $_SESSION['mess_transfer'];
        unset($_SESSION['mess_transfer']);
    }
    ?></div>


<?
if (!empty($ErrorMSG)) {
    echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
} else {
    ?>

    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
        <tr>
            <td align="right" height="22" valign="bottom">

                <? if ($num > 0) { ?>
                    <!-- input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_return.php?<?= $QueryString ?>';" / -->

                <? } ?>

                <? if (empty($_GET['po'])) { ?>
                    <!--a href="TransferList.php?link=editStockTransfer.php" class="fancybox add fancybox.iframe">Add Receive -->
                    <a href="TransferList.php?link=editStockTransfer.php" class="fancybox add fancybox.iframe">Stock In </a>
                <? } ?>

                <? if ($_GET['search'] != '') { ?>
                    <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
    <? } ?>


            </td>
        </tr>

        <tr>
            <td  valign="top">


                <form action="" method="post" name="form1">
                    <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                    <div id="preview_div">

                        <table <?= $table_bg ?>>

                            <tr align="left"  >
							    <td width="8%" class="head1" >ReceiveID</td>
                                <td width="12%" class="head1" >Receive Date</td>
                                <td width="12%"  class="head1" >Transfer Number</td>
                                <td width="8%" class="head1">Ref Number</td>
								<td width="8%" class="head1">From Warehouse</td>
								<td width="8%" class="head1">To Warehouse</td>
                                <td width="8%" class="head1" >Amount</td>
                                 <!--<td width="5%"  align="center" class="head1">Paid</td>-->
                                <td width="12%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>

                         <?php

                            if(is_array($arryTransfer) && $num > 0) {
                                $flag = true;
                                $Line = 0;
                                foreach ($arryTransfer as $key => $values) {
                                    $flag = !$flag;
                                    $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                    $Line++;

                                   ?>
<tr align="left"  bgcolor="<?= $bgcolor ?>">
<td><?=$values['RecieveID']?></td>
   <td height="20">
      <?
        if ($values['RecievedDate'] > 0)
          echo date($Config['DateFormat'], strtotime($values['RecievedDate']));
          ?>

    </td>
 <td ><a class="fancybox fancybox.iframe" href="../inventory/vTransfer.php?module=Order&pop=1&view=<?= $values['refID'] ?>" ><?= $values["transferNo"] ?></td>
 <td ><?= $values["transferNo"] ?></td>
  <td ><?= $values["from_warehouse"] ?></td>
   <td ><?= $values["to_warehouse"] ?></td>
 <td><?= stripslashes($values['total_transfer_value']) ?>  <?= $Config["Currency"] ?></td>

                                       


                         
  <td  align="center" class="head1_inner">

	<a href="vStockTransfer.php?view=<?= $values['transferID'] ?>&curP=<?= $_GET['curP'] ?>&rtn=<?= $values['RecieveID']; ?>"><?=$view?></a>
	<a href="editStockTransfer.php?edit=<?=$values['transferID']?>&curP=<?= $_GET['curP'] ?>&rtn=<?= $values['RecieveID']; ?>"><?= $edit ?></a>
	<a href="editStockTransfer.php?del_id=<?=$values['transferID']?>&curP=<?= $_GET['curP'] ?>&rtn=<?= $values['RecieveID']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"><?= $delete ?></a> 
	 <!--a href="pdfRecieve.php?RTN=<?= $values['transferID'] ?>"><?= $download ?></a -->

   </td>
 </tr>
                                <?php } // foreach end // ?>

    <?php } else { ?>
                                <tr align="center" >
                                    <td  colspan="8" class="no_record"><?= NO_RECORD ?> </td>
                                </tr>
    <?php } ?>

                            <tr > 
                                <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTransfer) > 0) { ?>
                                        &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                echo $pagerLink;
                            }
                            ?></td>
                            </tr>
                        </table>

                    </div> 
    <? if (sizeof($arryRecieve)) { ?>
                        <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                            <tr align="center" > 
                                <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'OrderID', 'editPurchase.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                    <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'OrderID', 'editPurchase.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                    <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'OrderID', 'editPurchase.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
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
            $(".fancybox").fancybox({
                'width': 900
            });

        });

    </script>

<? } ?>