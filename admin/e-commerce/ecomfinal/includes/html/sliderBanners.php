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
                    <td width="39%" align="right"> <a href="editSliderBanner.php" class="add">Add New Slider Banner</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Name</td> 
                    <td width="10%" height="20"  class="head1">Priority</td>
					<td width="10%" height="20"  class="head1">Image</td> 
                    
                    <td  width="20%" height="20"  class="head1" align="center">Status</td>
                    <td width="10%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arrySliderBanners, $RecordsPerPage, $_GET['curP']);
                (count($arrySliderBanners) > 0) ? ($arrySliderBanners = $objPager->getPageRecords()) : ("");
                if (is_array($arrySliderBanners) && $num > 0) {
                    $flag = true;
					
                    foreach ($arrySliderBanners as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Name']; ?>     </td>
							<td height="26"><?= $values['Priority']; ?>     </td>
                            <td height="26" align="center">
                         <?php  if($values['Slider_image'] !='' && file_exists('../../../upload/company/'.$_SESSION['CmpID'].'/slider_image/'.$values['Slider_image']) ){ 
                         	echo '<img src="../../../upload/company/'.$_SESSION['CmpID'].'/slider_image/'.$values['Slider_image'].'" border=0 width="80px;" >';
                        }?>    </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editSliderBanner.php?active_id=' . $values["Id"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editSliderBanner.php?edit=<?php echo $values['Id']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editSliderBanner.php?del_id=<?php echo $values['Id']; ?>" onclick="return confDel('<?= $values['Title'] ?>')" class="Blue" ><?= $delete ?></a>              
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
<?php if (count($arrySliderBanners) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
