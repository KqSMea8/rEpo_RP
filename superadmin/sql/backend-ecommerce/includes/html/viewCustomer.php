<div class="had">Manage Customers</div>
<table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_cust'])) {  echo stripslashes($_SESSION['mess_cust']);   unset($_SESSION['mess_cust']);} ?></div>
			            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> 
					<?php  if (is_array($arryCustomer) && $num > 0) {?>
					<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_customer.php?<?=$QueryString?>';" />

					<? if($_GET['search']!='') {?>
					<a href="viewCustomer.php" class="grey_bt">View All</a>
					<? }?>
					<?php }?>

					</td>
                </tr>

            </table>
            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="15%" height="20"  class="head1">Name</td>    
                    <td width="15%" height="20"  class="head1" align="center">Phone</td>    
                    <td width="16%" height="20"  class="head1">Email Address</td>  
                    <td width="17%" height="20"  class="head1">Country - State</td> 
                    <td width="12%" height="20"  class="head1" align="center">Group</td> 
                    <td width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="10%"  height="20" align="center" class="head1">Action</td>
                </tr>
                <?php
                    /********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
                $pagerLink = $objPager->getPager($arryCustomer, $RecordsPerPage, $_GET['curP']);
                (count($arryCustomer) > 0) ? ($arryCustomer = $objPager->getPageRecords()) : ("");
                if (is_array($arryCustomer) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryCustomer as $key => $values) {
                        
                        if($values['Country']>0){
			$arryCountryName = $objRegion->GetCountryName($values['Country']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($values['State'])) {
			$StateName = $objRegion->getAllStateName($values['State']);
                                           
		} else if(!empty($values['OtherState'])){
			 $StateName = stripslashes($values['OtherState']);
		}

                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['FirstName']." ".$values['LastName'];?>     </td>
                                <td align="center"><?= $values['Phone'];?></td>
                                 <td><?= $values['Email'];?></td>
                                   <td><?= $CountryName." - ".$StateName;?></td>
                                <td align="center"><?=$values['GroupName'] ?></td>
                                 <td align="center" ><?
                                            if ($values['Status'] == 'Yes') {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editCustomer.php?active_id=' . $values["Cid"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td  class="head1_inner" align="center">
                                   <a href="vCustomer.php?view=<?=$values['Cid']?>&curP=<?=$_GET['curP']?>"><?=$view?></a>
                                   <a href="editCustomer.php?edit=<?php echo $values['Cid']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                   <a href="editCustomer.php?del_id=<?php echo $values['Cid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="7"  class="no_record">No Customer  found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="7" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryCustomer) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
