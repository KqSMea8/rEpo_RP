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
                    <td width="39%" align="right"> <a href="editFormField.php" class="add">Add New Form Field</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="40%" height="20"  class="head1">Form</td> 
					<td width="40%" height="20"  class="head1">Field Label</td> 
					<td width="40%" height="20"  class="head1">Field Type</td> 
                    <td width="10%" height="20"  class="head1" align="center">Order</td> 
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryFormFields, $RecordsPerPage, $_GET['curP']);
                (count($arryFormFields) > 0) ? ($arryFormFields = $objPager->getPageRecords()) : ("");
                if (is_array($arryFormFields) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryFormFields as $key => $values) {
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['Fieldlabel']; ?>     </td>
							 <td height="26"><?= $values['FormName']; ?>     </td>
							 <td height="26"><?= $values['FieldType']; ?>     </td>
                            <td height="26" align="center"><?= $values['Priority']; ?>     </td>
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="editFormField.php?active_id=' . $values["FieldId"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editFormField.php?edit=<?php echo $values['FieldId']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="editFormField.php?del_id=<?php echo $values['FieldId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $values['Name'] ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="5"  class="no_record">No Pages found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="5" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryFormFields) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
