<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
</script> 


<div class="had">
    <?= $MainModuleName ?>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">


    <tr>
        <td  align="right" >

            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_asm.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>
            <a href="editAssemble.php?curP=<?= $_GET['curP'] ?>" class="add">Add New Assembly</a>	
            <? if ($_GET['key'] != '') { ?>
                <a href="viewAssemble.php?curP=<?= $_GET['curP'] ?>" class="grey_bt">View All</a>
            <? } ?>

        </td>
    </tr>	
    <tr>
        <td >
            <div class="message"><? if (!empty($_SESSION['mess_asm'])) {
                echo $_SESSION['mess_asm'];
                unset($_SESSION['mess_asm']);
            } ?>
            </div>
        </td>
    </tr>		

    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">

                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table <?= $table_bg ?>>
                        <tr align="left">
                            <!-- <td width="4%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryAssemble) ?>');" /></td>-->
                            <td width="12%" class="head1" align="center"><?= Assemble_NO ?></td>
                            <td width="15%"  class="head1" ><?= Assemble_Location ?></td>
                            <td width="12%"  class="head1" ><?= Assemble_DATE ?></td>
                            <td width="12%" class="head1" >Bill Number</td>
                            <td  class="head1" > Description</td>

                            <td width="12%" class="head1" >Assemble Qty</td>


                            <td width="10%" class="head1" ><?= VIEW_STATUS ?></td>

                            <td width="7%"  align="center" class="head1 head1_action" ><?= Action ?></td>
                        </tr>

                        <?php
                        if (is_array($arryAssemble) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryAssemble as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                    <!--<td><input type="checkbox" name="adjustmentID[]" id="ItemID<?= $Line ?>" value="<?= $values['asmID']; ?>"></td>-->
                                    <td align="center">  
                                        <?= stripslashes($values['asm_code']); ?>
                                    </td>
                                    <td><?= stripslashes($values['warehouse_name']); ?></td>
                                    <td><?= date($Config['DateFormat'], strtotime($values['asmDate'])); ?></td>
                                    <td><?= stripslashes($values['Sku']); ?></td>
                                    <td><?= stripslashes($values['description']); ?></td>
                                    <td><?= stripslashes($values['assembly_qty']); ?></td>

                                    <td width="10%" ><?
                                        if ($values['Status'] == 1) {
                                            $status = 'Cancel';
                                            $Class = 'red';
                                        } else if ($values['Status'] == 2) {
                                            $status = 'Completed';
                                            $Class = 'green';
                                        } else {

                                            $status = 'Parked';
                                            $Class = 'green';
                                        }



                                        echo '<span class="' . $Class . '" >' . $status . '</span>';
                                        ?></td>




                                    <td  align="center"  class="head1_inner" >
 
                                        <a href="vAssemble.php?view=<?= $values['asmID'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>

                                        <? if ($values['Status'] != 2 ) {?>
                                        <a href="editAssemble.php?edit=<? echo $values['asmID']; ?>&curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a>  
                                       
                                        <a href="editAssemble.php?del_id=<? echo $values['asmID']; ?>&curP=<?php echo $_GET['curP']; ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>
<? }?>	</td>
                                       
                                </tr>
                            <?php } // foreach end //  ?>



                        <?php } else { ?>
                            <tr >
                                <td  colspan="8" class="no_record">No  Assemly found</td>
                            </tr>

                        <?php } ?>



                        <tr >  <td  colspan="8" ><?= TOTAL_ADJUST_RECORD ?> : &nbsp;<?php echo $num; ?>      <?php if (count($arryAssemble) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                            echo $pagerLink;
                        }
                        ?></td>
                        </tr>
                    </table>
                </div>
                <? if (sizeof($arryAssemble)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                                 <!-- <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product', 'delete', '<?= $Line ?>', 'ItemID', 'editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?= $_GET['CatID'] ?>');">
                              <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?= $_GET['CatID'] ?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?= $_GET['CatID'] ?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
