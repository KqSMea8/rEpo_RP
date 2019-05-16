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
            

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="50%" height="20"  class="head1">Name</td> 
					
                     <td width="50%" height="20"  class="head1">Size</td> 
                    
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryWidgets, $RecordsPerPage, $_GET['curP']);
                (count($arryWidgets) > 0) ? ($arryWidgets = $objPager->getPageRecords()) : ("");
                if (is_array($arryWidgets) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryWidgets as $key => $values) {
                    	$style=json_decode($values['style']);
                    	
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['widgets_name']; ?>     </td>
							 <td height="26"><?php echo 'Width :'.$style->width.'Height :'.$style->height; ?>     </td> 
                          
                            
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="5"  class="no_record">No Records found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryWidgets) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
