<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch(SearchBy){
        /*
          var frm  = document.form1;
          var frm2 = document.form2;
           if(SearchBy==1)  {
                   location.href = 'viewProducts.php?curP='+frm.CurrentPage.value+'&MemberID='+document.topForm.MemberID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&CatID='+document.topForm.CatID.value;
           } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
                   location.href = 'viewProducts.php?curP='+frm.CurrentPage.value+'&MemberID='+document.topForm.MemberID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&CatID='+document.topForm.CatID.value;
                }
		
                return false;*/
    }


    function submitThisForm(frm){	
        if(document.getElementById("ProductsListing") != null){
            document.getElementById("ProductsListing").innerHTML= '<img src="images/loading.gif"><br><br><br><br>';
        }
        document.topForm.submit();
    }

</script> 


<div class="had">
    Manage Items <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

 
    <tr>
        <td  align="right" >
            <a href="editProduct.php?curP=<?= $_GET['curP'] ?>&tab=basic" class="add">Add New Item</a>			
        </td>
    </tr>	
    <tr>
        <td  >
            <div class="message"><? if (!empty($_SESSION['mess_product'])) {
    echo $_SESSION['mess_product'];
    unset($_SESSION['mess_product']);
} ?>
            </div>
        </td>
    </tr>		

    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                <table <?= $table_bg ?>>


                    <tr align="left">
                        <td width="4%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ProductID','<?= sizeof($arryProduct) ?>');" /></td>
                      <td width="9%" class="head1" align="center">Item Code</td>
                      <td width="18%"  class="head1" >Item Description</td>
                      <td width="12%"  class="head1" >Category</td>
                      <td width="7%" class="head1">Tax</td>
                        <td width="11%" class="head1" align="center">Purchase Cost </td>
                      <td width="8%" class="head1" align="center">Sale Price</td>
                      <td width="8%" class="head1" align="center">Qty on Hand</td>
                          <td width="9%"  class="head1"align="center">Measure</td>
                      <td width="14%"  align="center" class="head1" >Action</td>
                  </tr>

                    <?php
                    if (is_array($arryProduct5) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td><input type="checkbox" name="ProductID[]" id="ProductID<?= $Line ?>" value="<?= $values['ProductID']; ?>"></td>
                                <td align="center">  
                                     <? if ($values['Image'] != '' && file_exists('../../upload/products/images/' . $values['Image'])) { ?>
                                         <a  data-fancybox-group="gallery" class="fancybox" href="../../upload/products/images/<? echo $values['Image']; ?>">
                                             <? echo '<img src="../../resizeimage.php?w=70&h=50&img=upload/products/images/' . $values['Image'] . '" border=0  >'; ?>
                                         </a>	
                                                                  <? } else { ?>
                                    <? echo '<img src="../../resizeimage.php?w=70&h=50&img=./images/no.jpg" border=0  >'; ?>
                                
                                <?php }?>
                                </td>
                                <td><?=stripslashes($values['Name']); ?></td>
                                <td><?=stripslashes($values['ProductSku']); ?></td>
                                <td><?= number_format($values['Price'],2);?></td>
                                <td align="center">
                                   <?php if ($values['Quantity'] > 0) { ?>
                                    <?=$values['Quantity'];?>
                                    <?php }else{?>
                                     -
                                    <?php }  ?></td>
                                 <td align="center">
                                    <?
                                    if($values['Featured'] == "Yes")
                                    {$featured = "Yes"; $status = 'Active';}else{$featured = "No"; $status = 'InActive';}
                                    echo '<a href="editProduct.php?featured_id=' . $values["ProductID"] . '&curP=' . $_GET["curP"] . '&CatID=' . $values["CategoryID"]. '" class='.$status.'  alt="Click to Change Featured Status" title="Click to Change Featured Status">' .$featured. '</a>';
                                    ?>


                                </td>
                                  <td align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Active';
                                    } else {
                                        $status = 'InActive';
                                    }

                               

                                    echo '<a href="editProduct.php?active_id=' . $values["ProductID"] . '&curP=' . $_GET["curP"] . '&CatID=' .  $values["CategoryID"] . '" class="'.$status.' alt="Click to Change Status" title="Click to Change Status">' . $status . '</a>';
                                    ?></td>
                                    <td></td>
                                <td  align="center"  >
                                      <a href="vProduct.php?view=<?=$values['ProductID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic" ><?=$view?></a>
                                    <a href="editProduct.php?edit=<? echo $values['ProductID']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $values["CategoryID"] ?>&tab=basic"><?= $edit ?></a>  <a href="editProduct.php?del_id=<? echo $values['ProductID']; ?>&CategoryID=<?php echo $values['CategoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&MemberID=<?= $_GET['MemberID'] ?>&CatID=<?=  $values["CategoryID"] ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>	</td>
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="10" class="no_record">No Inventory Items found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php //echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php //echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>

                <? if (sizeof($arryProduct)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                                <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');">
                                <!--<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


            </form>
        </td>
    </tr>

</table>
