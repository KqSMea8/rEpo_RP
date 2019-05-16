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
                    <td width="39%" align="right"> <a href="editContent.php?CustomerID=<?php echo  $_REQUEST['CustomerID'];?>" class="add">Add New Page</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="50%" height="20"  class="head1">Title </td> 
					
                    <td width="10%" height="20"  class="head1" align="center">Order</td> 
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryArticles, $RecordsPerPage, $_GET['curP']);
                (count($arryArticles) > 0) ? ($arryArticles = $objPager->getPageRecords()) : ("");
                if (is_array($arryArticles) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryArticles as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Title']; ?>     </td>
							
                            <td height="26" align="center"><?= $values['Priority']; ?>     </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editContent.php?active_id=' . $values["ArticleId"] .'&CustomerID=' . $_REQUEST['CustomerID'] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editContent.php?edit=<?php echo $values['ArticleId']; ?>&curP=<?php echo $_GET['curP']; ?>&CustomerID=<?php echo  $_REQUEST['CustomerID'];?>" class="Blue"><?= $edit ?></a>
                                <a href="editContent.php?del_id=<?php echo $values['ArticleId']; ?>&curP=<?php echo $_GET['curP']; ?>&CustomerID=<?php echo  $_REQUEST['CustomerID'];?>" onclick="return confDel('<?= $values['Name'] ?>')" class="Blue" ><?= $delete ?></a>              
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
<?php if (count($arryArticles) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
