<?php 
require_once($Prefix."classes/inv_tax.class.php");
$objTax=new tax();


$arryTax=$objTax->getTaxes();
$num=$objTax->numRows();

$pagerLink = $objPager->getPager($arryTax, $RecordsPerPage, $_GET['curP']);
(count($arryTax) > 0) ? ($arryTax = $objPager->getPageRecords()) : ("");


if($Config['CurrentDepID']==5){
	$HideTd = 'style="display:none;" ';
}
?>

<div class="had">Manage Taxes </div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<? /*if ($ParentID > 0) { ?>
        <tr>

            <td align="right" height="30"><a href="viewManufacturer.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="Blue">Back</a></td>
        </tr>
<? }*/ ?>

    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_tax'])) {  echo stripslashes($_SESSION['mess_tax']);   unset($_SESSION['mess_tax']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editTax.php" class="add">Add Tax</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                <td width="22%"   class="head1">  Tax Rate Name</td>      
                <td width="20%"   class="head1">  Tax Rate</td>  
                <td width="20%"   class="head1">  Tax Location</td> 
                <td   width="10%" class="head1" <?=$HideTd?>>Class Name</td>
                <td  width="18%"   class="head1" align="center">Status</td>
                <td width="5%"    align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                
      
                
              




  if (is_array($arryTax) && $num > 0) {

/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/

          foreach ($arryTax as $key => $values) {	
            $flag = true;
            $flag = !$flag;
            $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
            $Line++;

		
		if($values['Coid']>0){
		$arryCountryName = $objRegion->GetCountryName($values['Coid']);
		$CountryName = stripslashes($arryCountryName[0]["name"]); 
		}else{
		$CountryName = "ALL";
		}

		if($values['Stid'] > 0) {
		$StateName = $objRegion->getAllStateName($values['Stid']); 
		} 
		else{
		$StateName = "ALL";
		} ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['RateDescription'];?>     </td>
                              <td><?= number_format($values['TaxRate'],2);?>%</td>
                             <td><?=$CountryName." - ".substr($StateName,0,50);?></td>
				  <td <?=$HideTd?>><?=$values['ClassId']?></td>
                             <td align="center" ><?
                                            if ($values['Status'] == "Yes") {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo '<a href="editTax.php?active_id=' . $values["RateId"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                   <a href="editTax.php?edit=<?php echo $values['RateId']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="editTax.php?del_id=<?php echo $values['RateId']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Tax')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php 
} // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td  colspan="5"  class="no_record">No Tax  found. </td>
                    </tr>
                <?php } ?>

                <tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTax) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table></td>
    </tr>


</table>