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
           <a class="back" href="<?=$RedirectURL?>">Back</a>   

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="30%" height="20"  class="head1" align="center" >Form Name</td> 
					
                    <td  width="20%" height="20"  class="head1" align="center">Submit Date</td>
                    <td width="15%"   height="20" align="center"  class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryFormData, $RecordsPerPage, $_GET['curP']);
                (count($arryFormData) > 0) ? ($arryFormData = $objPager->getPageRecords()) : ("");
                if (is_array($arryFormData) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryFormData as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26" align="center" ><?= $values['FormName']; ?>     </td>
							 
                           <td height="26" align="center" ><?= $values['Added_date']; ?>     </td>
                            <td height="26" align="center"  valign="top">
                                <a href="showFormData.php?view=<?php echo $values['Added_no']; ?>&formId=<?php echo $values['FormId']; ?>&CustomerID=<?php echo  $_REQUEST['CustomerID'];?>" class="Blue"><?= $view ?></a>
                                <a href="showFormData.php?del_id=<?php echo $values['Added_no']; ?>&formId=<?php echo $values['FormId']; ?>&CustomerID=<?php echo  $_REQUEST['CustomerID'];?>" onclick="return confDel('<?= $values['Name'] ?>')" class="Blue" ><?= $delete ?></a>              
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
<?php if (count($arryFormData) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
