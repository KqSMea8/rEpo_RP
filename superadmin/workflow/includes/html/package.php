<?php /* Developer Name: Niraj Gupta
 * Date : 24-06-15
 * Description: For Package form  package.php
 */ 
?> 

<div class="had">Manage Packages</div>
<div class="message" align="center"><?php // if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); } ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td align="right" >

            <?php if ($_GET['key'] != '') { ?>
                <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location = 'package.php';" />
            <?php } ?>

            <?php //if ($_SESSION['AdminType'] == "admin") { ?>
                <!--<a href="addPackage.php" class="add">Add Package</a>-->
            <?php //} ?>

        </td>
    </tr>
<a href="index.php" class="back">Back</a>
    <tr>
        <td  valign="top">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
                          <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?= sizeof($arryElement) ?>');" /></td>-->
                            <td width="15%"  class="head1">Package Name</td>
                            <td width="8%"  class="head1" >Package Feature</td>
                            <td width="12%" class="head1" >Package Price</td>
                            <td  width="32%" class="head1" >Package Description</td>
                           <!--- <td width="6%"  align="center" class="head1" >Demo Package</td>-->
                            <td width="6%"  align="center" class="head1" >Status</td>
                            <td width="6%"  align="center" class="head1" >Action</td>
                        </tr>

                        <?php
                        $deletePackage = '<img src="' . $Config['Url'] . 'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

                        if (is_array($arryPackage) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryPackage as $key => $values) {
                                $values = get_object_vars($values);
                                $flag = !$flag;
                                #$bgcolor=($flag)?("#FDFBFB"):("");
                                $Line++;
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                    <td ><?= stripslashes($values["pckg_name"]) ?></td>
                                    <td ><?= stripslashes($values["package_feature"]) ?></td>
                                    <td><?= $values["pckg_price"] ?></td>  
                                    <td><?= $values["pckg_description"] ?></td> 
                                    <!--<td width="6%"  align="center" >
                                	 <?php  if ($values['demo'] == 1) {
				                            $status = 'Free';
				                            $class="Active";
				                        } else {
				                            $status = 'Paid';
				                             $class="InActive";
				                        }
                                     echo '<a href="package.php?demo_id=' . $values["pckg_id"] . '&curP=' . $_GET["curP"] . '" class="' . $class . '">' . $status . '</a>';?></td>-->
                                    <td align="center"><?php
                        if ($values['status'] == 1) {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }
                        echo '<a href="package.php?active_id=' . $values["pckg_id"] . '&status=' . $values["status"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                                ?></td>
                                    <td  align="center"  class="head1_inner"><a href="addPackage.php?edit=<?= $values['pckg_id'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $edit ?></a>

                                        <!--<a href="package.php?del_id=<?php echo $values['pckg_id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $ModuleName ?>')"  ><?= $deletePackage ?></a> -->  

                                    </td>
                                </tr>
    <?php } // foreach end //  ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryPackage) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                        echo $pagerLink;
                    }
?></td>
                        </tr>
                    </table>

                </div> 
                <?php if (sizeof($arryPackage)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'CmpID', 'editCompany.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'CmpID', 'editCompany.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'CmpID', 'editCompany.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
                <?php } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>
