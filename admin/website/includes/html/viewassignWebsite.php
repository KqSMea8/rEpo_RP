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
                    <?php if($allowedWebsite>$assigndWebsite){?>
                    <td width="39%" align="right"> <a href="editAssignWebsite.php" class="add">Assign WebSite</a>      </td>
                    <?php }?>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="50%" height="20"  class="head1">Customer/Admin </td> 
                    <td width="50%" height="20"  class="head1">Website </td> 
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryCustomers, $RecordsPerPage, $_GET['curP']);
                (count($arryCustomers) > 0) ? ($arryCustomers = $objPager->getPageRecords()) : ("");
                if (is_array($arryCustomers) && $num > 0) {
                    $flag = true;
					
                    foreach ($arryCustomers as $key => $values) {
                    	$Domain='';
                    	if($values['IsCompany']=='1'){
                    		$Domain='http://'.$_SERVER['SERVER_NAME'].'/web/'.$_SESSION['DisplayName'].'/';
                    		
                    	}
                    	else if($values['Sitename']!=''){
							$Domain='http://'.$_SERVER['SERVER_NAME'].'/web/'.$_SESSION['DisplayName'].'/'.$values['Sitename'].'/';
                    	 }							 	
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['FullName']; ?>     </td>
							 <td height="26"><a href="<?php echo $Domain;?>" target="_new"><?php echo $Domain;?></a> </td>
                            
                            <td height="26" align="right"  valign="top">                               
                                <a href="editAssignWebsite.php?del_id=<?php echo $values['Id']; ?>&cust_id=<?php echo $values['CustomerId']?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $values['FullName'] ?>')" class="Blue" ><?= $delete ?></a>              
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
<?php if (count($arryCustomers) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
