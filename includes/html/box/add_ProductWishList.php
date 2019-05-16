
<div id="add_ProductWishList_div" style="display:none; width: 300px; height: 300px;">
  <h2>
    <?=ADD_TO_WISHLIST?>
  </h2>
  <form name="wishListForm" id="wishListFormId" method="post" action="">
    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="wishlist_name">
    	<tr>
        	<td></td>
        	<td class="add"><a class="fancybox" href="#create_ProductWishList_div">Add New WishList</a></td>
        </tr>      
      <?php if(count($arryWishlist) > 0) {

                            foreach($arryWishlist as $k=>$wishlist)
                            {
                            ?>
      <tr>
        <td align="left" class="list"><input type="radio" id="Wlid" name="Wlid" value="<?=$wishlist['Wlid']?>"> <span class="wishname"><?=$wishlist['Name']?></span></td>
        <td></td>        
      </tr>
      <?php }

                        } else {?>
      <tr>
        <td colspan="2" class="blackbold message" style="text-align: center;">You Have Not Created Wishlist Yet.</td>
      </tr>
      <?php }?>
    </table>
    
    <?php if(!empty($arryProductAttributes)){
                        $options = array();
                    foreach($arryProductAttributes as $key=>$attribute)
                    {   
                        $options = $objProduct->parseOptions($attribute['options']);     
                    ?>
    <?php if ($attribute['attribute_type'] == "select") { ?>
    <select id="attribute_input_<?=$attribute['paid']?>" name="oa_attributes[<?=$attribute['paid']?>]" style="display:none;">
      <?php foreach($options as $option) {  ?>
      <option value="<?=trim($option)?>">
      <?=trim($option)?>
      </option>
      <?php }?>
    </select>
    <?php }
                    
                          }
                       
                       }?>
    <input type="hidden" name="WhislistProductId" id="WhislistProductId" value="<?=$_GET['id']?>"  />
    <?php if(count($arryWishlist) > 0) { ?>
    <input name="btnSubmit" type="button" class="button" id="addToWishlsit" value="Add" />
    <?php }?>
  </form>
</div>
