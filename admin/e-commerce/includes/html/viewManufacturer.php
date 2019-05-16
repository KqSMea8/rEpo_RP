<div class="had">Manage Manufacturers</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_man'])) {  echo stripslashes($_SESSION['mess_man']);   unset($_SESSION['mess_man']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> 
					<a class="fancybox add_quick fancybox.iframe" href="addManufacturer.php">Quick Entry</a>
					<a href="editManufacturer.php" class="add">Add Manufacturer</a></td>
                </tr>

            </table>
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="25%" height="20"  class="head1"> Manufacturer Name</td>      
                    <td width="15%" height="20"  class="head1"> Manufacturer Code</td>  
                    <td width="20%" height="20"  class="head1" align="center"> Manufacturer Website</td>
                    <td width="20%" height="20"  class="head1" align="center">  Manufacturer Logo</td>
                    <td width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="10%"   height="20" align="center" class="head1">Action&nbsp;&nbsp;</td>
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
                            <td align="center">

		<? 
		 
		 if ($values['Image'] != ''){
		    $PreviewArray['Folder'] = $Config['ProductsManufacturer'];
		    $PreviewArray['FileName'] = $values['Image']; 
		    $PreviewArray['FileTitle'] = stripslashes($values['Mname']);
		    $PreviewArray['Width'] = "80";
		    $PreviewArray['Height'] = "80";
		    $PreviewArray['Link'] = "1";
		    echo '<div id="ImageDiv">'.PreviewImage($PreviewArray).'</div>';
		 }

		?>
				</td>
                            <td align="center" ><?
                                            if ($values['Status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editManufacturer.php?active_id=' . $values["Mid"] . '&ParentID=' . $ParentID . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" class="head1_inner" align="center"  valign="middle">
                                   <a href="editManufacturer.php?edit=<?php echo $values['Mid']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editManufacturer.php?del_id=<?php echo $values['Mid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="6"  class="no_record">No Manufacturer  found. </td>
                    </tr>
                <?php } ?>

                <tr>  <td height="20" colspan="6" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryManufacturer) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
