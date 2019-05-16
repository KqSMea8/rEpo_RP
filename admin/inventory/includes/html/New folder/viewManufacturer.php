<div class="had">Manage Manufacturers </div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<? if ($ParentID > 0) { ?>
        <tr>

            <td align="right" height="30"><a href="viewManufacturer.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="Blue">Back</a></td>
        </tr>
<? } ?>

    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_man'])) {  echo stripslashes($_SESSION['mess_man']);   unset($_SESSION['mess_man']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editManufacturer.php" class="add">Add Manufacturer</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="25%" height="20"  class="head1">  Manufacturer Name</td>      
                    <td width="15%" height="20"  class="head1">  Manufacturer Code</td>  
                    <td width="20%" height="20"  class="head1">  Manufacturer Website</td>
                    <td width="20%" height="20"  class="head1" align="center">  Manufacturer Logo</td>
                    <td width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="10%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryManufacturer, $RecordsPerPage, $_GET['curP']);
                (count($arryManufacturer) > 0) ? ($arryManufacturer = $objPager->getPageRecords()) : ("");
                if (is_array($arryManufacturer) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryManufacturer as $key => $values) {

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Mname'];?>     </td>
                            <td align="center"><?= $values['Mcode'];?></td>
                            <td align="center"><?php if($values['Website'] != ""){?><?= $values['Website'];?><?php } else {?>-<?php }?></td>
                            <td align="center"><?php if($values['Image'] != ""){?> <a data-fancybox-group="gallery" class="fancybox" href="../../upload/manufacturer/<? echo $values['Image']; ?>"><? echo '<img src="../../resizeimage.php?w=70&h=100&img=upload/manufacturer/' . $values['Image'] . '&bg=000000" border=0 >'; ?></a><?php } else {?>-<?php }?></td>
                            <td align="center" ><?
                                            if ($values['Status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editManufacturer.php?active_id=' . $values["Mid"] . '&ParentID=' . $ParentID . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                   <a href="editManufacturer.php?edit=<?php echo $values['Mid']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editManufacturer.php?del_id=<?php echo $values['Mid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Manufacturer  found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryManufacturer) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table></td>
    </tr>


</table>
