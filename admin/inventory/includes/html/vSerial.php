<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }


</script>

<div class="had"> Serial Number</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   
   
    <tr>
        <td  valign="top" height="400">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>

<? if($_GET['SerialType'] =='adjust'){?>

<div id="preview_div">

                    <table <?= $table_bg ?>>


                        <tr align="left">

                            <td width="15%" class="head1">Serial Number</td>
<td width="15%" class="head1">Price</td>
                            <td   class="head1"> Description</td>
                           





                        </tr>

                        <?php
                        if (is_array($serial)) {
                            $flag = true;
                            ;
                            for ($Line = 0; $Line<sizeof($serial); $Line++) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                

                                //if($values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                    <td><?= $serial[$Line] ?></td>
 <td><? if(isset($serialPrice[$Line])) echo $serialPrice[$Line]; ?></td>
                                    <td><? if(isset($serialDes[$Line])) echo $serialDes[$Line]; ?> </td>
                                    
                                </tr>
    <?php } // foreach end //  ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="4" class="no_record">No Serial Number found</td>
                            </tr>
<?php } ?>

                       
                    </table>
                </div>





<?}else{?>





                <div id="preview_div">

                    <table <?= $table_bg ?>>


                        <tr align="left">

                            <td  class="head1">Serial Number</td>
                            <td width="15%"  class="head1"> Warehouse Name</td>
                            <td width="9%" class="head1" >Sku</td>





                        </tr>

                        <?php
                        if (is_array($arrySerial) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arrySerial as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                    <td><?= stripslashes($values['serialNumber']); ?></td>
                                    <td> <?= stripslashes($values['warehouse_name']); ?></td>
                                    <td><?= stripslashes($values['Sku']); ?></td>
                                </tr>
    <?php } // foreach end //  ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="4" class="no_record">No Serial Number found</td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="4"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySerial) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>
                </div>
<? }?>
            </form>
