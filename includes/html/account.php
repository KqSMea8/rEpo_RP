<?php if (!empty($_SESSION['successMsg'])) { ?>
<div class="successMsg">
<?php echo $_SESSION['successMsg']; ?>
<?php unset($_SESSION['successMsg']);?>
</div>
<?php } ?>
<?php if (!empty($_SESSION['errorMsg'])) { ?>
<div class="warningMsg">
<?php echo $_SESSION['errorMsg']; ?>
<?php unset($_SESSION['errorMsg']);?>
</div>
<?php } ?>
<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen accountpage">
      <h1>My Account</h1>
      <div class="myaccount">
        <h2>My Account</h2>
        <div class="content">
          <ul>
            <li><a href="myProfile.php">Edit your account information</a></li>
            <li><a href="change_password.php">Change your password</a></li>
            <li><a href="addressBook.php">Modify your address book</a></li>
            <?php if($settings['EnableWishList'] == "Yes"){?>
            <li><a href="myWishlist.php?action=manage_wishlist">Modify your wish list</a></li>
            <?php }?>
          </ul>
        </div>
      </div>
      <div class="myorder">
        <h2>My Orders</h2>
        <div class="content">
          <ul>
            <li><a href="myOrders.php">View your order history</a></li>
            <!-- <li><a href="#">Downloads</a></li>
                <li><a href="#">Your Reward Points</a></li>
                <li><a href="#">View your return requests</a></li>
                <li><a href="#">Your Transactions</a></li>
                <li><a href="#">Recurring payments</a></li>-->
          </ul>
        </div>
      </div>
      <div class="newsletter">
        <h2>Newsletter</h2>
        <div class="content">
          <ul>
            <li><a href="newsletter.php">Subscribe / unsubscribe to newsletter</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
StateListSend();
</script>
