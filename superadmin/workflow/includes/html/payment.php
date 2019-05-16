<?php 
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For element.php
 */?> 

<div class="had"> Payment Dashboard</div>
<?php if(!empty($_SESSION['plan_message'])){
	echo '<div>'.$_SESSION['plan_message'].'</div>';
	unset($_SESSION['plan_message']);
}?>
<div class="message" align="center"><?php// if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>
<a class="back" href="index.php">Back</a>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   <!-- <tr>
        <td align="right" >

            <?php if($_GET['key']!='') {?>
            <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location = 'element.php';" />
            <?php }?>

            <?php if($_SESSION['AdminType']=="admin"){?>
           <a href="addCoupan.php" class="add">Add Element</a>
            <?php }?>

        </td>
    </tr>-->
    <tr>
        <td  valign="top">

 
            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
                          <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?= sizeof($arryElement) ?>');" /></td>-->
                            <td width="20%"  class="head1" >Company Name</td>
                            <td width="9%"  class="head1" >Total Amount</td>
                            <td width="9%" class="head1" >Discount Amount</td>
                            <td  width="9%" class="head1" >Pay Amount</td>
 			    <td  width="10%" class="head1" >Allow Users</td>
			    <td  width="10%" class="head1" >Plan Duration</td>
 			    <td  width="20%" class="head1" >Date</td>
                            
                            <td width="6%"  align="center" class="head1" >Action</td>
                        </tr>

                        <?php   
                        $deleteElement = '<img src="' . $Config['Url'] . 'admin/images/delete.png" border="0" >';
			//print_r($arrypayment);
                        if (is_array($arrypayment)&& $num>0) { 
                            $flag = true;
                            $Line = 0;
				//print_r($arrypayment);
                            foreach ($arrypayment as $key => $values) { 
                                 $values     = get_object_vars($values);
                                $flag = !$flag;
                                #$bgcolor=($flag)?("#FDFBFB"):("");
                                $Line++;
                            
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                    <td ><?= stripslashes($values["name"]) ?></td>
                                    <td ><?= stripslashes($values["total_amount"]) ?></td>
                                    <td><?=$values["discount_amount"] ?></td>  
                                    <td><?=$values["pay_amount"] ?></td> 
					 <td><?=$values["allow_users"] ?></td> 
					<td><?=$values["plan_duration"] ?></td> 
					<td><?=$values["date"] ?></td>
                                     
                                     <td  align="center"  class="head1_inner"><a href="paymentdetails.php?edit=<?php echo $values['id'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>

       <!--<a href="coupan.php?del_id=<?php echo $values['id'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirm('Are you sure want to delete')"  ><?=$deleteElement?></a>-->  
                                        
                                    </td>
                                </tr>
    <?php } // foreach end // ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                       <tr>
				<td colspan="9">Total Record(s) : &nbsp;<?php echo $num;?> <?php if(count($arrypayment)>0){?>
                                    &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pageslink;}?>
                                </td>
			</tr>
                    </table>

                </div> 
                <?php if(sizeof($arryElement)){ ?>
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
