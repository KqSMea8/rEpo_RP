<script type="text/javascript">
//Chetan30Sep//
function syncEcomcategory()
{
    var selectedCategory = new Array();
    $('[name="CategoryID[]"]:checked').each(function(i,e) {

            selectedCategory.push(e.value);
    });
    if(selectedCategory.length==0){
            alert('Please select Category first');
    }
    else{
            if($('#SelectAll').is(":checked")){

                selecttype='all';

                $.fancybox({
                'type': 'inline',
                'href': '#dialogContent',
               'afterClose':function () {
                                if($('input[name="synctype"]:checked').val() == 'one' )
                                {
                                    $('#Allselect').val('N');
                                }else{
                                     $('#Allselect').val('Y');
                                }
                               
                                $('#catgform').submit();
                        }
            }); 
        } 
        else{

           $('#Allselect').val('N');
           $('#catgform').submit();

        }
    }
}
    
</script>


<div class="had">Manage Categories <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span></div>
<form name="catgform" id="catgform" action="syncCategory.php" method="post">
<input type="hidden" name="Allselect" id="Allselect" value="">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td><br>
            <div class="message"><?php if (!empty($_SESSION['mess_cat'])) { echo stripslashes($_SESSION['mess_cat']); unset($_SESSION['mess_cat']);}?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
					
                    <td width="39%" align="right">
					<a class="fancybox add_quick fancybox.iframe" href="addCat.php">Quick Entry</a>
                        <?php if ($LevelCategory > 0) { ?>
                            <a href="editCategory.php?ParentID=<?= $ParentID ?>&curP=<?php echo $_GET['curP']; ?>" class="add">Add <?= $cat_title ?></a><?php if( $_SESSION['sync_items']=='E2I' ||$_SESSION['sync_items']=='both' ){?>
                            <!--By Chetan11Aug-->
                            <input type="button" onclick="Javascript:syncEcomcategory();" value="Sync Category" name="sync_Category" class="sync_button">
                            <!--End-->
<?php } ?>
                                <?php } ?>
                        <?php if ($ParentID > 0) { ?>
                            <a href="viewCategory.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="back">Back</a>
                        <?php } ?>
						<? if($_GET['search']!='') {?>
						<a href="viewCategory.php" class="grey_bt">View All</a>
						<? }?>
                    </td>
                </tr>

            </table>

            <table <?= $table_bg ?> class="view-category">
                <tr align="left" >
                     <!--By Chetan11Aug-->
                    <td width="5%" align="center" class="head1">
                    <input type="checkbox" onclick="Javascript:SelectCheckBoxes('SelectAll','CategoryID','<?= sizeof($arryCategory) ?>');" id="SelectAll" name="SelectAll">
                    </td>
                    <!--End-->
                    <td width="60%" height="20"  class="head1" ><?= $cat_title ?>  Name</td>
                    <td  height="20" width="8%" class="head1" align="center">Sort Order</td>
                    <td  height="20" width="8%" class="head1" align="center">Status</td>
                    <td  height="20" width="8%" align="center" class="head1">Action</td>
                </tr>
                <?php
                
                 $Config['editImg'] = $edit;
                 $Config['deleteImg'] = $delete;
               
                if (is_array($arryCategory) && $num > 0) {
                    $flag = true;
                    $Line = 0;              //By Chetan11Aug//     
                    foreach ($arryCategory as $key => $values) {
                        $flag = !$flag;
                        $Line++;            //By Chetan11Aug//                        
                      ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                             <!--By Chetan11Aug-->
                            <td align="center"><input type="checkbox" value="<?php echo $values['CategoryID']; ?>" id="CategoryID<?= $Line ?>" name="CategoryID[]"></td>
                            <!--End-->
                            <td height="26"  align="left">
                                <table border="0" cellspacing="0" cellpadding="0" class="margin-left">
                                    <tr>
                                        <td align="left">
                                            <a href="editCategory.php?edit=<?php echo $values['CategoryID']; ?>&ParentID=<?php echo $values['ParentID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue">
                                                <b><?= stripslashes($values['Name']) ?></b>
                                            </a>
                                        </td>
                                    </tr>
                                </table></td>
                            <td align="center"><?= $values['sort_order']; ?></td>
                            <td align="center" ><?
                        if ($values['Status'] == 1) {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }



                        echo '<a href="editCategory.php?active_id=' . $values["CategoryID"] . '&ParentID=' . $values['ParentID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>';
                        ?></td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="editCategory.php?edit=<?php echo $values['CategoryID']; ?>&ParentID=<?php echo $values['ParentID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <? if ($LevelCategory > 0) { ?>
                                    <a href="editCategory.php?del_id=<?php echo $values['CategoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&ParentID=<?php echo $values['ParentID']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>
                                <? } ?> 

                                &nbsp;</td>
                        </tr>
                      <?php  $objCategory->GetSubCategoryTree($values['CategoryID'],0);
                     
                           } // foreach end //
                    ?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No <?= strtolower($cat_title) ?> found. </td>
                    </tr>
<?php } ?>

                <!--<tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?//php echo $num; ?>      <?//php if (count($arryCategory) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                //echo $pagerLink;
            //}
?></td>
                </tr>-->
            </table>
        </td>
    </tr>
</table>
<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="synctype" value="one" checked="checked" onclick="chosevalue(this.value); ">sync this page Category
    	<input type="radio" name="synctype" value="all" onclick="chosevalue(this.value);" >sync all Category
    	
    </div>
</div>

</form>
