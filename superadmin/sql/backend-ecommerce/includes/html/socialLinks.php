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
                    <td width="39%" align="right"> <a href="editSocialLink.php" class="add">Add New Social Link</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Social Media</td> 
					<td width="10%" height="20"  class="head1">Priority</td> 
                    <td width="30%" height="20"  class="head1" align="center">URI</td> 
                    <td width="20%" height="20"  class="head1" align="center">Icon</td> 
                    <td  width="20%" height="20"  class="head1" align="center">Status</td>
                    <td width="10%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arrySocialLinks, $RecordsPerPage, $_GET['curP']);
                (count($arrySocialLinks) > 0) ? ($arrySocialLinks = $objPager->getPageRecords()) : ("");
                if (is_array($arrySocialLinks) && $num > 0) {
                    $flag = true;
					
                    foreach ($arrySocialLinks as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['name']; ?>     </td>
							<td height="26"><?= $values['Priority']; ?>     </td>
                            <td height="26" align="center"><?= $values['URL']; ?>     </td>
                            <td height="26" align="center">
                         <?php  $values['icon']; if($values['icon'] !='' && file_exists('../../images/icons/'.$values['icon']) ){ 
                         	echo '<img src="../../images/icons/'.$values['icon'].'" border=0 >';
                        }?>    </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editSocialLink.php?active_id=' . $values["Id"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editSocialLink.php?edit=<?php echo $values['Id']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editSocialLink.php?del_id=<?php echo $values['Id']; ?>" onclick="return confDel('<?= $values['Title'] ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="6"  class="no_record">No Pages found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="6" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arrySocialLinks) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
