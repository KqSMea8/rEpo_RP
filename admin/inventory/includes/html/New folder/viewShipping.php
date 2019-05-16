<div class="had">Manage Shipping Methods </div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<? if ($ParentID > 0) { ?>
        <tr>

            <td align="right" height="30"><a href="viewManufacturer.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="Blue">Back</a></td>
        </tr>
<? } ?>

    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_ship'])) {  echo stripslashes($_SESSION['mess_ship']);   unset($_SESSION['mess_ship']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editShipping.php" class="add">Add shipping method</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">  Carrier Name</td>      
                    <td width="20%" height="20"  class="head1">  Carrier method</td>  
                    <td  width="20%" height="20"  class="head1">Country/State</td>
                    <td  height="20%" width="8%" class="head1" align="center">Carrier Rates</td>
                    <td  height="20" width="8%" class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
                     /********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
                
                $pagerLink = $objPager->getPager($arryShipingMethod, $RecordsPerPage, $_GET['curP']);
                (count($arryShipingMethod) > 0) ? ($arryShipingMethod = $objPager->getPageRecords()) : ("");
                if (is_array($arryShipingMethod) && $num > 0) {
                    $flag = true;
                   
                    foreach ($arryShipingMethod as $key => $values) {

                   
		if($values['Country']>0){
			$arryCountryName = $objRegion->GetCountryName($values['Country']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($values['State'])) {
			$StateName = $objRegion->getAllStateName($values['State']);
                                           
		} 
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['CarrierName'];?>     </td>
                              <td><?= $values['MethodName'];?></td>
                              <td><?= $CountryName."-".substr($StateName,0,50);?></td>
                              <td align="center"><a href="shippingRates.php?curP=1&Ssid=<?=$values['Ssid'];?>&MethodId=<?=$values['MethodId'];?>">Click to view</a></td>
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editShipping.php?active_id=' . $values["Ssid"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                   <a href="editShipping.php?edit=<?php echo $values['Ssid']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editShipping.php?del_id=<?php echo $values['Ssid']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="6"  class="no_record">No Shipping Method found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="6" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryShipingMethod) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table></td>
    </tr>


</table>
