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
            <a href="editWorkOrder.php?curP=<?= $_GET['curP'] ?>" class="add">Add Work Order</a>	
            <? if ($_GET['key'] != '') { ?>
                <a href="viewWorkOrder.php?curP=<?= $_GET['curP'] ?>" class="grey_bt">View All</a>
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
                            <!-- <td width="4%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryWorkOrder) ?>');" /></td>-->
                            <td width="12%" class="head1" align="center">Work Order No.</td>
                          
                            
                            <td  class="head1" >Description</td>
<td width="15%"  class="head1" >Location</td>
                            <td width="10%" class="head1" > Qty</td>
                            <td   class="head1" >Date</td>
                            <td width="10%" class="head1" ><?= VIEW_STATUS ?></td>

                            <td width="7%"  align="center" class="head1 head1_action" ><?= Action ?></td>
                        </tr>

                        <?php
                        if (is_array($arryWorkOrder) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryWorkOrder as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                    <!--<td><input type="checkbox" name="Oid[]" id="Oid<?= $Line ?>" value="<?= $values['Oid']; ?>"></td>-->

<td align="center">  
                                        <?= stripslashes($values['WON']); ?>
                                    </td>
                                   

                                
 
                                    <td><?= stripslashes($values['description']); ?></td>
    <td><?= stripslashes($values['warehouse_name']); ?></td>
                                    <td><?= stripslashes($values['WoQty']); ?></td>
                                    <td><?= date($Config['DateFormat'], strtotime($values['SchDate'])); ?></td>



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
																			
																					<a href="vWorkOrder.php?view=<?= $values['Oid'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>
																			
                                        <? if ($values['Status'] != 2 ) {?>
                                        <a href="editWorkOrder.php?edit=<? echo $values['Oid']; ?>&curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a>  

                                        <a href="editWorkOrder.php?del_id=<? echo $values['Oid']; ?>&curP=<?php echo $_GET['curP']; ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>
<? }?>	</td>
                                       </tr>
                            <?php } // foreach end //  ?>



                        <?php } else { ?>
                            <tr >
                                <td  colspan="8" class="no_record">No  record found</td>
                            </tr>

                        <?php } ?>



                        <tr >  <td  colspan="8" ><?= TOTAL_ADJUST_RECORD ?> : &nbsp;<?php echo $num; ?>      <?php if (count($arryWorkOrder) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                            echo $pagerLink;
                        }
                        ?></td>
                        </tr>
                    </table>
                </div>
            

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
