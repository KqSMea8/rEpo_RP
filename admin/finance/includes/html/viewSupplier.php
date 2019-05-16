

<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

    function filterLead(id)
    {
        location.href = "viewSupplier.php?customview=" + id;
        LoaderSearch();
    }
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_supplier'])) {
    echo $_SESSION['mess_supplier'];
    unset($_SESSION['mess_supplier']);
} ?></div>
<form action="" method="post" name="form1"> <!---- moved here by nisha for row color------>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td>

              <ul class="export_menu" style="margin-right:5px;">
<li><a href="#" class="hide" style="background:#d40503 url('../../admin/images/plus.gif') no-repeat scroll 5px 5px; !important;" >Add Vendor</a>
<ul>
<li  ><a href="editSupplier.php" style="background:#d40503 url('../../admin/images/plus.gif') no-repeat scroll 5px 5px; !important; margin-bottom:2px; margin-top:2px;">Add  New Vendor</a></li>
<li  > <a class="fancybox  fancybox.iframe" href="CustomerViewList.php" style="background:#d40503 url('../../admin/images/plus.gif') no-repeat scroll 5px 5px; !important; ">Add From Customer</a></li>	

</ul>
</li>
</ul>
            <a href="addSupp.php" class="fancybox add_quick fancybox.iframe"><?= QUICK_ENTRY ?></a>
<input type="button" class="export_button"  name="exp" value="Import Excel" onclick="Javascript:window.location = 'importVendor.php';" />
            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_supplier.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>




<? if ($_GET['key'] != '') { ?>
                <a href="viewSupplier.php" class="grey_bt">View All</a>
<? } ?>


        </td>
    </tr>
 <? if ($num > 0 ) { ?>
            <tr>
                <td align="right" height="40" valign="bottom">


<?
	//added by nisha for row color
$ToSelect = 'SuppID';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>
  </td>
    </tr>
<? }?>
    <tr>
        <td  valign="top">


          
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','SuppID','<?= sizeof($arrySupplier) ?>');" /></td>-->
                                <td width="12%"  class="head1" >Vendor Code</td>
				<td class="head1" >Vendor Type</td>
                                <td class="head1" >Vendor Name</td>
                                <td width="12%" class="head1" >Country</td>
                                <td width="12%" class="head1" >State</td>
                                <td width="12%" class="head1" >City</td>
                                <td width="10%"  class="head1" >Currency</td>
                                <td width="6%"  align="center" class="head1" >Status</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
  <!-- addedby nisha for row color------->
	<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'SuppID', '<?= sizeof($arrySupplier) ?>');" /></td>
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
                        if (is_array($arrySupplier) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arrySupplier as $key => $values) {
                                $flag = !$flag;
                                $Line++;
                                ?>
 <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>><!-----modified by nisha for row color--->
                                
        <? if ($_GET["customview"] == 'All') { ?>  
                                        <!--<td ><input type="checkbox" name="SuppID[]" id="SuppID<?= $Line ?>" value="<?= $values['SuppID'] ?>" /></td>-->
                                        <td height="20"><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?= $values['SuppCode'] ?>" ><?= $values["SuppCode"] ?></a>


                                        </td>
					 <td><?=stripslashes($values["SuppType"])?></td> 
                                        <td><?=stripslashes($values["VendorName"])?></td> 
                                        <td><?=stripslashes($values["Country"])?></td> 
                                        <td><?=stripslashes($values["State"])?></td> 
                                        <td><?=htmlentities($values["City"], ENT_IGNORE)?></td> 
                                        <td><?=$values["Currency"]?></td>


                                        <td align="center"><?
                                            if ($values['Status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }



                                            echo '<a href="editSupplier.php?active_id=' . $values["SuppID"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            ?></td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';

                                           if ($cusValue['colvalue'] == 'Status') {
                                                #echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';

                                                if ($values['Status'] == 1) {
                                                    $status = 'Active';
                                                } else {
                                                    $status = 'InActive';
                                                }

                                                echo '<a href="editSupplier.php?active_id=' . $values["SuppID"] . '&customview='.$_GET['customview'].'&curP=' . $_GET["curP"] . '" class="' . $status . '" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            
                                                
                                                } elseif ($cusValue['colvalue'] == 'SupplierSince' || $cusValue['colvalue'] == 'DeliveryDate' || $cusValue['colvalue'] == 'InvoiceDate') {
                                                if ($values[$cusValue['colvalue']] > 0)
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                            }  else { ?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                <?
                                            }

                                            echo '</td>';
                                        }
                                    }
                                    ?>
                                    <td  align="center" class="head1_inner"  >
                                        <a href="vSupplier.php?view=<?= $values['SuppID'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>


                                        <a href="editSupplier.php?edit=<?= $values['SuppID'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $edit ?></a>
					<? if(!$objSupplier->isVendorTransactionExist($values['SuppCode'])){ ?>
                                        <a href="editSupplier.php?del_id=<?php echo $values['SuppID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>  
					<? } ?>

 </td>
     <!----addedby nisha for highlight color functionality------>
		<td ><input type="checkbox" name="SuppID[]" id="SuppID<?= $Line ?>" value="<?= $values['SuppID'] ?>" /></td>
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="10" class="no_record"><?= NO_SUPPLIER ?> </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySupplier) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                            }
?></td>
                        </tr>
                    </table>

                </div> 
  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
<!--added by nisha---->
	<input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arrySupplier) ?>">
           
        </td>
    </tr>
</table>
 </form>
