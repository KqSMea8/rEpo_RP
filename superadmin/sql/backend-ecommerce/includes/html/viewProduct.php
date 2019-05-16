<div class="had">   Manage Products <?= $MainParentCategory ?>  <span><?= $ParentCategory ?></span></div>
<div class="message"><? if (!empty($_SESSION['mess_product'])) {    echo $_SESSION['mess_product'];    unset($_SESSION['mess_product']);} ?></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                   
                    <td align="right"> 
					<?php  if (is_array($arryProduct) && $num > 0) {?>
					<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_product.php?<?=$QueryString?>';" />
					<?php }?>
					<a class="fancybox add_quick fancybox.iframe" href="addProd.php">Quick Entry</a>
					<a href="editProduct.php?curP=<?= $_GET['curP'] ?>&tab=basic" class="add">Add Product</a>
					 <? if($_GET['search']!='') {?>
						<a href="viewProduct.php" class="grey_bt">View All</a>
						<? }?>
					<?php if( $sync_items=='E2T' || $sync_items=='both' ){?>
				<input type="button" class="sync_button" name="sync_items"
					value="Sync Item" onclick="Javascript:selectitems();" /> <?php }?>
					</td>

                </tr>

            </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td id="ProductsListing">
            <form action="" method="post" name="form1" id="form1">
                <table <?= $table_bg ?>>
                    <tr align="left">
                        <td width="5%" class="head1" align="center">
                        <input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ProductID','<?= sizeof($arryProduct) ?>');" /></td>
                        <td width="10%" class="head1" align="center">Image</td>
                        <td width="30%"  class="head1" >Product Name</td>
                        <td width="10%"  class="head1" align="center">Product Sku</td>
                        <td class="head1" width="8%" align="center">Price</td>
                        <td width="5%" class="head1" align="center">Stock </td>
                        <td width="5%" class="head1" align="center">Featured</td>
                        <td width="8%"  class="head1"align="center">Status</td>
                        <td width="6%"  align="center" class="head1" >Action</td>
                    </tr>

                    <?php
                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                            //$bgcolor=($flag)?(""):("#F3F3F3");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td align="center"><input type="checkbox" name="ProductID[]" id="ProductID<?= $Line ?>" value="<?= $values['ProductID']; ?>"></td>
                                <td align="center">  
                                     <? if ($values['Image'] != '' && file_exists('../../../upload/products/images/'.$_SESSION['CmpID'].'/' . $values['Image'])) { ?>
                                         <a  data-fancybox-group="gallery" title="<?=stripslashes($values['Name']); ?>" class="fancybox" href="../../../upload/products/images/<? echo $_SESSION['CmpID'].'/'.$values['Image']; ?>">
                                             <? echo '<img src="../../../resizeimage.php?w=70&h=50&img=upload/products/images/'.$_SESSION['CmpID'].'/' . $values['Image'] . '" border=0  >'; ?>
                                         </a>	
                                                                  <? } else { ?>
                                    <? echo '<img src="../../../resizeimage.php?w=70&h=50&img=./images/no.jpg" border=0  >'; ?>
                                
                                <?php }?>
                                </td>
                                <td><?=stripslashes($values['Name']); ?></td>
                                <td align="center"><?=stripslashes($values['ProductSku']); ?></td>
                                <td align="center"><?= number_format($values['Price'],2);?></td>
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
                                <td  align="center"  >
                                      <a href="vProduct.php?view=<?=$values['ProductID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic" ><?=$view?></a>
                                    <a href="editProduct.php?edit=<? echo $values['ProductID']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $values["CategoryID"] ?>&tab=basic"><?= $edit ?></a>  <a href="editProduct.php?del_id=<? echo $values['ProductID']; ?>&CategoryID=<?php echo $values['CategoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&MemberID=<?= $_GET['MemberID'] ?>&CatID=<?=  $values["CategoryID"] ?>" onClick="return confDel('Product')"  ><?= $delete ?></a>	</td>
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="9" class="no_record">No products found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="9" >Total Product(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>

                <? if (sizeof($arryProduct)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left">
                                <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ProductID','editProduct.php?curP=<?= $_GET[curP] ?>&dCatID=<?=$_GET['CatID']?>');" />
                            </td>
                        </tr>
                    </table>
                <? } ?>

                

<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="synctype" value="one" checked="checked" onclick="chosevalue(this.value); ">sycn this page items
    	<input type="radio" name="synctype" value="all" onclick="chosevalue(this.value);" >sync all item
    	
    </div>
</div>
<input type="hidden" name="synctypeselected" id="synctypeselected" value=""  >
            </form>
        </td>
    </tr>
</table>
<script type="text/javascript">
function chosevalue(selectedval){
	
	$('#synctypeselected').val(selectedval);
	 sendtosync();
	 $.fancybox.close();
	 
}


function sendtosync(){
	var selectedItemID=new Array();
	$('[name="ProductID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
	}
	else{
		var selecttype='';
		selecttype=$('#synctypeselected').val();
			
		document.form1.action ="syncItem.php";
		$("#form1").submit();
		//Items=$("input[name='ProductID[]']:checked").serialize();
		//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
	}
	
}

function selectitems(){
	var selectedItemID=new Array();
	$('[name="ProductID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
	}
	else{
		var selecttype='';
		if($('#SelectAll').is(":checked")){
			 
			selecttype='all';
			
			$.fancybox({
		        'type': 'inline',
		        'href': '#dialogContent',
		       'afterClose':function () {
				sendtosync();
	        		}
		    }); 
			//Items=$("input[name='ProductID[]']:checked").serialize();
			//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
		 } 
		else{
			document.form1.action ="syncItem.php";
			$("#form1").submit();
			//Items=$("input[name='ProductID[]']:checked").serialize();
			//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
		}
		
	}
	
}
</script>
