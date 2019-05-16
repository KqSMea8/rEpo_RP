<div class="had"> <?=$MainModuleName?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
        <td  align="right" >
            <? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_itemserials.php?<?=$QueryString?>';" />
	  <? } ?>
    <tr>
        <td id="ProductsListing">
            <form action="" method="post" name="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>

                    <tr align="left">
			<td width="15%"  class="head1">Serial Number</td>
			<!--td  class="head1" width="15%"> Warehouse Name</td-->
    			<td  class="head1" width="15%"> Unit Price</td>	                  
                  </tr>

                    <?php
                    if (is_array($arrySerial) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arrySerial as $key => $values) {
                            $flag = !$flag;
                            $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td><?= stripslashes($values['serialNumber']); ?></td>
                                <!--td><?= stripslashes($values['warehouse_name']); ?></td-->
				<td><?= stripslashes($values['UnitCost'])." ".$Config['Currency']; ?></td>
                            </tr>
                        <?php } // foreach end // ?>
                    <?php } else { ?>
                        <tr >
                            <td  colspan="4" class="no_record">No Inventory Items Serial Number found.</td>
                        </tr>

                    <?php } ?>

                    <tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySerial) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
              </form>
        </td>
    </tr>

</table>
