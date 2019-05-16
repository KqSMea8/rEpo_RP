
<div class="had">Manage Territory <?= (isset($MainParentTerritory)) ? $MainParentTerritory : ''; ?>  <span><?=(isset($ParentTerritory)) ? $ParentTerritory :''; ?></span></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td><br>
            <div class="message"><?php if (!empty($_SESSION['mess_cat'])) { echo stripslashes($_SESSION['mess_cat']); unset($_SESSION['mess_cat']);}?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
					
                    <td width="39%" align="right">
					
                        <?php if ($LevelTerritory > 0) { ?>
                            <a href="editTerritory.php?ParentID=<?= $ParentID ?>&curP=<?php echo $_GET['curP']; ?>" class="add">Add <?= $cat_title ?></a>
                        <?php } ?>
                        <?php if (isset($ParentID) &&  $ParentID> 0) { ?>
                            <a href="viewTerritory.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="back">Back</a>
                        <?php } ?>
						<? if($_GET['search']!='') {?>
						<a href="viewTerritory.php" class="grey_bt">View All</a>
						<? }?>
                    </td>
                </tr>

            </table>

            <table <?= $table_bg ?> class="view-category">
                <tr align="left" >
                    <td width="60%" height="20"  class="head1" ><?= $cat_title ?>  Name</td>    
                    <td  height="20" width="8%" class="head1" align="center">Status</td>
                    <td  height="20" width="8%" align="center" class="head1">Action</td>
                </tr>
                <?php
               // $pagerLink = $objPager->getPager($arryTerritory, $RecordsPerPage, $_GET['curP']);
                //(count($arryTerritory) > 0) ? ($arryTerritory = $objPager->getPageRecords()) : ("");      
                
                
                 $Config['editImg'] = $edit;
                 $Config['deleteImg'] = $delete;
               
                if (is_array($arryTerritory) && $num > 0) {
                    $flag = true;
                    foreach ($arryTerritory as $key => $values) {
                        $flag = !$flag;
                       //$arrySubTerritory = $objTerritory->GetSubTerritoryByParent($_GET['key'], $values['TerritoryID']);
                        
                      ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"  align="left">
                                <table border="0" cellspacing="0" cellpadding="0" class="margin-left">
                                    <tr>
                                        <td align="left">
                                            <a href="editTerritory.php?edit=<?php echo $values['TerritoryID']; ?>&ParentID=<?php echo $values['ParentID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue">
                                                <b><?= stripslashes($values['Name']) ?></b>
                                            </a>
                                        </td>
                                    </tr>
                                </table></td>
                            
                            <td align="center" > <?
                        if ($values['Status'] == 1) {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }



                        echo '<a href="editTerritory.php?active_id=' . $values["TerritoryID"] . '&ParentID=' . $values['ParentID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>';
                        ?> </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="editTerritory.php?edit=<?php echo $values['TerritoryID']; ?>&ParentID=<?php echo $values['ParentID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <? if ($LevelTerritory > 0) { ?>
                                    <a href="editTerritory.php?del_id=<?php echo $values['TerritoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&ParentID=<?php echo $values['ParentID']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>
                                <? } ?> 

                                &nbsp;</td>
                        </tr>
                      <?php  $objTerritory->GetSubTerritoryTree($values['TerritoryID'],0);
                     
                           } // foreach end //
                    ?>
                <?php } else { ?>
                    <tr align="center">
                        <td height="20" colspan="4"  class="no_record">No <?= strtolower($cat_title) ?> found. </td>
                    </tr>
<?php } ?>

                <!--<tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?//php echo $num; ?>      <?//php if (count($arryTerritory) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                //echo $pagerLink;
            //}
?></td>
                </tr>-->
            </table>
        </td>
    </tr>
</table>
