<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<?php //echo $MainModuleName; ?>
<div class="had"> <?=$MainModuleName?> </div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

   
<? if (!empty($_SESSION['mess_product'])) {?>	
    <tr>
        <td>
            <div class="message"><? echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); ?>
            </div>
        </td>
    </tr>		
<? } ?>
 
    <tr>
        <td  align="right" >
 	<a href="Inventorywritedown.php" class="add">Add New</a>
  	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	</td>
  </tr>
  
    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
	<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
                      <td width="10%" class="head1" >Inv Writedown</td>
                      <td width="14%" class="head1" >SKU</td>
                      <td width="10%" class="head1" >Total Items</td>
                      <td width="10%" class="head1" >Total Qty</td>
                      <td width="13%" class="head1" >Total Cost</td>
                      <td width="12%" class="head1" >Avg Cost</td>
                      <td width="10%" class="head1" >Market Cost</td>
                      <td width="10%"  class="head1"align="center">Status</td>
                      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                   </tr>

                    <?php
                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                
                                <td><?= stripslashes($values['Inv_Writedown']);?></td>
                                <td><?=stripslashes($values['Sku']);?></td>
                                <td><?=stripslashes($values['Total_Items']);?></td>
				<td><?=ucfirst($values['Total_Qty']);?></td>
                                <td><?=stripslashes($values['Total_Cost']); ?></td>
                                <td><?=stripslashes($values['avg_Cost'])?></td>
                                <td><?=$values['Market_cost'];?></td>
                               
                                <td align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Completed';
                                    } else {
                                        $status = 'Parked';
                                    }
                                    echo '<a href="Inventorywritedown.php?active_id=' . $values["ID"] .'&status='.$values['Status']. '&curP=' . $_GET["curP"] . '" class="'.$status.' alt="Click to Change Status" title="Click to Change Status">' . $status . '</a>';
										?>
                                </td>
                                   
                                <td  align="center" class="head1_inner"  >
                          <?php  if ($values['Status'] == 1) { ?>
									<a href="Inventorywritedown.php?del_id=<? echo$values['ID'].'&curP=' . $_GET["curP"]; ?>" onClick="return confDel('Inventory Writedown')"  ><?= $delete ?></a>
						  <?php }else{?>
									 <a  href="Inventorywritedown.php?edit=<? echo $values['ID'].'&curP=' . $_GET["curP"]; ?>" ><?= $edit ?></a>  
									 <a href="Inventorywritedown.php?del_id=<? echo$values['ID'].'&curP=' . $_GET["curP"]; ?>" onClick="return confDel('Inventory Writedown')"  ><?= $delete ?></a>
						  <?php }?>
								</td>
                            </tr>
                        <?php } // foreach end // ?>

                    <?php } else { ?>
                        <tr >
                            <td  colspan="10" class="no_record">No Inventory Items found.</td>
                        </tr>

                    <?php } ?>


                    <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
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
