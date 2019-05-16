
<div class="container account">
    <div class="mid_wraper clearfix">
        <?php //include_once("includes/left.php"); ?>
        <?php if (!empty($_SESSION['successMsg'])) { ?>
    <div class="successMsg">
        <?php echo $_SESSION['successMsg']; ?>
        <?php unset($_SESSION['successMsg']); ?>
    </div>
<?php } ?>
<?php if (!empty($_SESSION['errorMsg'])) { ?>
    <div class="warningMsg">
        <?php echo $_SESSION['errorMsg']; ?>
        <?php unset($_SESSION['errorMsg']); ?>
    </div>
<?php } ?>
        <div class="right_pen">
            <h3>My Wishlist</h3>
            <?php if ($_REQUEST['action'] == "manage_wishlist") { ?>

                <table width="100%" border="1" cellpadding="3" cellspacing="1" class="wishlist">

                    <tr>
                        <td class="wish_head">Wishlist Name</td>
                        <td class="wish_head">Action</td>
                    </tr>
                    <?php
                   
                    if (count($arrayWishlist) > 0) {

                        foreach ($arrayWishlist as $key => $wishlist) {
                            ?>
                            <tr class="wish-field">
                                <td><a href="myWishlist.php?action=edit_wishlist&WishlistID=<?= $wishlist['Wlid'] ?>&CustID=<?= $wishlist['Cid'] ?>"><?= $wishlist['Name'] ?></a></td>
                                <td>
                                    <a class="emailWishlist btn btn-info" title="Email Wishlist" href="myWishlist.php?action=send_email&Wlid=<?= $wishlist['Wlid'] ?>">Email Wishlist</a>
                                    <a class="addWishlist btn btn-info" title="Add To Cart" href="cart.php?Wlid=<?= $wishlist['Wlid'] ?>">Add To Cart</a>
                                    <a href="javascript:void();" title="Remove" class="removeWishlist btn btn-info" alt="<?= $wishlist['Wlid'] ?>#<?= $wishlist['Cid'] ?>">Remove</a>
                                </td>
                            </tr>

                        <?php
                        }
                    } else {
                        ?>

                        <tr>
                            <td colspan="2"> NO Wishlist Found!</td>

                        </tr>
    <?php } ?>

                </table>
<?php } ?>



<?php if ($_REQUEST['action'] == "edit_wishlist") {  ?>
                <form name="WishlistForm" method="post" action="">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wishlist_edit">

                        <tr>
                            <td colspan="2" width="14%">Wishlist Name</td>
                            <td><input type="text" name="Name" id="Name" value="<?= $wishlist_data['Name'] ?>">
                                <input type="hidden" name="Wlid" value="<?= $wishlist_data['Wlid'] ?>" />
                                <input type="hidden" name="action" value="update_wishlist" />
                                <input type="submit" name="btnSubmit" id="btnUpdateWishlist" class="btn btn-info " value="Update">
                            </td>
                        </tr>
                    </table>
                </form>
                <br><br>
                <table width="100%" border="1" cellpadding="3" cellspacing="1" class="wishlist">            
                    <tr>
                        <td class="wish_head">Image</td>
                        <td class="wish_head">Description</td>
                        <td class="wish_head">Price</td>
                        <td class="wish_head">Action</td>
                    </tr>
                    <?php
                    if (count($wishlist_data) > 0) {

                        foreach ($wishlist_data['whishlist_products'] as $key => $wishlistproduct) {
                            $ImagePath = 'resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/products/images/' . $Config['CmpID'] . '/' . $wishlistproduct['Image'] . '&w=150&h=100';
                            ?>
                            <tr class="wish-field">
                                <td class="img">
                                    <a  href="productDetails.php?id=<?= $wishlistproduct['ProductID'] ?>">
            <?php if (!empty($wishlistproduct['Image'])) { ?>

                                            <img src="<?= $ImagePath; ?>" width="70" height="62" title="<?= ucfirst(stripslashes($wishlistproduct['Image'])) ?>" />


                                        <?php } else { ?>
                                            <img src="./../images/no.jpg" width="70" height="62" title="<?= ucfirst(stripslashes($wishlistproduct['Image'])) ?>" />
            <?php } ?>   
                                    </a>

                                </td>
                                <td width="35%"><?php echo (!empty($wishlistproduct['AliasID']))? $wishlistproduct['ItemAliasCode'] :$wishlistproduct['Name']; ?><br>
                                    <?= $wishlistproduct['ProductSku'] ?><br>
            <?= $wishlistproduct['attributes'] ?>
                                </td>
                                <td><?= display_price($wishlistproduct['Price'], '', '', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']); ?></td>
                                <td>
                                    <a class="addWishlist btn btn-info" title="Add To Cart" href="cart.php?Wlpid=<?= $wishlistproduct['Wlpid'] ?>">Add To Cart</a>
                                    <a href="javascript:void();" title="Remove" class="removeWishlistProduct btn btn-info" alt="<?= $wishlistproduct['Wlpid'] ?>#<?= $_GET['WishlistID'] ?>">Remove</a>
                                </td>
                            </tr>

                        <?php
                        }
                    } else {
                        ?>

                        <tr class="wish-field">
                            <td colspan="4"> NO Wishlist Product Found!</td>

                        </tr>
    <?php } ?>

                </table>

<?php } ?>

        </div>
    </div>
</div>
