<div class="had">
<?=$MainModuleName?>   
</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
    echo stripslashes($_SESSION['mess_Page']);
    unset($_SESSION['mess_Page']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editMenu.php" class="add">Add New Menu</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="50%" height="20"  class="head1">Menu Name</td> 
					<td width="50%" height="20"  class="head1">Menu Type</td> 
                    <td width="10%" height="20"  class="head1" align="center">Order</td> 
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryMenus, $RecordsPerPage, $_GET['curP']);
                (count($arryMenus) > 0) ? ($arryMenus = $objPager->getPageRecords()) : ("");
                if (is_array($arryMenus) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryMenus as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Name']; ?>     </td>
							 <td height="26"><?= $values['MenuType']; ?>     </td>
                            <td height="26" align="center"><?= $values['Priority']; ?>     </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editMenu.php?active_id=' . $values["MenuId"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editMenu.php?edit=<?php echo $values['MenuId']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editMenu.php?del_id=<?php echo $values['MenuId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $values['Name'] ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Pages found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryMenus) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
