<script type="text/javascript">
//Chetan30Sep//
function syncitemcategory()
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

           Category = JSON.stringify(selectedCategory);
           window.location='syncCategory.php?Category='+Category+'&Select=N';

        }
    }
}
    
</script>

<div class="had">Manage Categories <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span></div>
<form name="catgform" id="catgform" action="syncCategory.php" method="post">
<input type="hidden" name="Allselect" id="Allselect" value="">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td ><br>
            <div class="message"><?
if (!empty($_SESSION['mess_cat'])) {
    echo stripslashes($_SESSION['mess_cat']);
    unset($_SESSION['mess_cat']);
}
?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right">
                        <? if ($LevelCategory > 0) { ?>
                            <a href="editCategory.php?ParentID=<?= $ParentID ?>&curP=<?php echo $_GET['curP']; ?>" class="add">Add <?= $cat_title ?></a>
                       <?php if( $_SESSION['sync_items']=='I2E' ||$_SESSION['sync_items']=='both' ){?>
                            <input type="button" onclick="Javascript:syncitemcategory();" value="Sync Category" name="sync_Category" class="sync_button">
                              <? } ?>  
                                <? } ?>
                        <? if ($ParentID > 0) { ?>
                            <a href="viewCategory.php?curP=<?= $_GET['curP'] ?>&ParentID=<?= $BackParentID ?>" class="back">Back</a>
<? } ?>
                    </td>
                </tr>

            </table>

             <table <?= $table_bg ?> class="view-category">
                <tr align="left" >
                     <td width="5%" align="center" class="head1">
                     <input type="checkbox" onclick="Javascript:SelectCheckBoxes('SelectAll','CategoryID','<?= sizeof($arryCategory) ?>');" id="SelectAll" name="SelectAll">
                    </td>
                    <td   class="head1" ><?= $cat_title ?>  Name</td>
                    <td    class="head1" align="center">Sort Order</td>
                    <td  class="head1" align="center">Status</td>
                    <td   align="center" class="head1">Action</td>
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
											$result =0;
											$arrySubCategory =$objItem->checkSubCatByTran($values['CategoryID']);
											
                      //$result =0;
											foreach ($arrySubCategory as $key => $SubValues) {  
//echo $SubValues['CategoryID'];




														if(!empty($SubValues['CategoryID'])){
                                 $chktran = $objItem->isCategoryTransactionExist($SubValues['CategoryID']);
																if($chktran==1){
																  $result = 1;

																}
														}

											}

                      ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                             <td align="center"><input type="checkbox" value="<?php echo $values['CategoryID']; ?>" id="CategoryID<?= $Line ?>" name="CategoryID[]"></td>
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
<? 
//echo $result;
if(!$objItem->isCategoryTransactionExist($values['CategoryID']) && $result !=1){

//if($result ==1){
 if ($LevelCategory > 0) { ?>
                                    <a href="editCategory.php?del_id=<?php echo $values['CategoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&ParentID=<?php echo $values['ParentID']; ?>" onclick="return confDel('<?=$values['Name'] ?>')" class="Blue" ><?= $delete ?></a>
                                <? } }//}?> 

                                &nbsp;</td>
                        </tr>
                      <?php  $objCategory->GetSubCategoryTree($values['CategoryID'],0);
                     
                           } // foreach end //
                    ?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="5"  class="no_record">No <?= strtolower($cat_title) ?> found. </td>
                    </tr>
<?php } ?>

 
            </table>
        </td>
    </tr>


</table>
<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="synctype" value="one" checked="checked" >sync this page Category
    	<input type="radio" name="synctype" value="all" >sync all Category
    	
    </div>
</div>

</form>
