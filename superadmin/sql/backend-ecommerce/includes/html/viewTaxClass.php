<div class="had">Manage Tax Classes </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_taxclass'])) {  echo stripslashes($_SESSION['mess_taxclass']);   unset($_SESSION['mess_taxclass']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editTaxClass.php" class="add">Add Tax Class</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="50%" height="20"  class="head1">Tax Class Name</td>      
                <!--<td width="20%" height="20"  class="head1"> Tax Class Description</td>  -->
                <td  width="8%" height="20"  class="head1" align="center">Status</td>
                <td width="3%"   height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                $pagerLink = $objPager->getPager($arryTaxClasses, $RecordsPerPage, $_GET['curP']);
                (count($arryTaxClasses) > 0) ? ($arryTaxClasses = $objPager->getPageRecords()) : ("");
                if (is_array($arryTaxClasses) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryTaxClasses as $key => $values) {

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['ClassName'];?>     </td>
                             <!-- <td><?= $values['ClassDescription'];?></td>-->
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editTaxClass.php?active_id=' . $values["ClassId"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                   <!--<a href="editTaxClass.php?edit=<?//php echo $values['ClassId']; ?>&curP=<?//php echo $_GET['curP']; ?>" class="Blue"><?//= $edit ?></a>-->
                                    <a href="editTaxClass.php?del_id=<?php echo $values['ClassId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="3"  class="no_record">No Tax Class found. </td>
                    </tr>
                <?php } ?>

                <tr>  <td height="20" colspan="3" >Total Record(s) : &nbsp;<?php echo $num; ?>    
                <?php if (count($arryTaxClasses) > 0) { ?>  &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
                          </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
