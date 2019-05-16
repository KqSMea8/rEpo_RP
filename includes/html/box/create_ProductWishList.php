<div id="create_ProductWishList_div" style="display:none; width: 350px; height: 300px;">
  <h2>
    <?=CREATE_WISHLIST?>
  </h2>
  <form name="form1" id="wishListId" action=""  method="post">
    <table width="100%" border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td align="right" colspan="2" class="blackbold" style="text-align: center;"><div id="whilist_msgDiv"  class="message" style="display: none;">Your Wishlist Added Successfully.</div></td>
      </tr>
      <tr>
        <td align="right" colspan="2" class="blackbold" style="text-align: center;">&nbsp;</td>
      </tr>
      <tr>
        <td align="right"    class="blackbold"><?=WISHLIST_NAME?>
          <span class="red">*</span></td>
        <td height="30" align="left"  class="blacknormal"><input  name="Name" class="inputbox" id="Name" value="" type="text" />
        </td>
      </tr>
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
    <input type="hidden" name="WhishlistCid" id="WhishlistCid" value="<?=$_SESSION['Cid']?>"  />
    <input name="btnSubmit" type="button" style="display: block; margin: auto;" class="button" id="btnSaveWishlist" value="<?=SAVE_WISHLIST?>" />
  </form>
</div>
