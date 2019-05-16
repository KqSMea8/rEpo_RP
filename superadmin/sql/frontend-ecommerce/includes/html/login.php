<!--main container -->
<div class="account">
	<h3 class="section-title-inner"><span><i class="fa fa-lock"></i> Authentication</span></h3>
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
    <div class="row userInfo">
        <div class="col-xs-12 col-sm-6">
            <h3 class="block-title-2"><?= NEW_USERS ?></h3>
            <p><?= NOT_REGISTERED ?></p>


            <form role="form" class="regForm">
                <a href="#createaccount" role="button" id="btnRegister" class="btn btn-primary" data-toggle="modal"><?= REGISTER ?></a><!--
                <input type="button" name="btnRegister" id="btnRegister" value="<?= REGISTER ?>" class="btn   btn-primary" />
                -->
                <?php if ($settings['EnableGuestCheckout'] == "Yes") { ?>   
                    <p><strong><?= GUEST_CHECKOUT ?> :</strong>
                        <?= GUEST_CHECKOUT_MSG ?></p>
                    <p><?= START_GUEST_CHECKOUT ?></p>
                <?php } ?>
            </form>
        </div>
        <div class="col-xs-12 col-sm-6">
            <h3 class="block-title-2"><span><?= EXISTING_USERS ?></span></h3>
            <p><?= TO_LOGIN_MSG ?></p>
            <?php include_once("includes/html/box/loginform.php"); ?>
            
        </div>
    </div>
</div>


<?php /*?><div class="container account">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h3 class="section-title-inner"><span><i class="fa fa-lock"></i> Authentication</span></h3>
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
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-6">
                    <h3 class="block-title-2"><?= NEW_USERS ?></h3>
                    <p><?= NOT_REGISTERED ?></p>


                    <form role="form" class="regForm">
                        <input type="button" name="btnRegister" id="btnRegister" value="<?= REGISTER ?>" class="btn   btn-primary" />
                        <?php if ($settings['EnableGuestCheckout'] == "Yes") { ?>   
                            <p><strong><?= GUEST_CHECKOUT ?> :</strong>
                                <?= GUEST_CHECKOUT_MSG ?></p>
                            <p><?= START_GUEST_CHECKOUT ?></p>
                        <?php } ?>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <h3 class="block-title-2"><span><?= EXISTING_USERS ?></span></h3>
                    <p><?= TO_LOGIN_MSG ?></p>
                    <?php include_once("includes/html/box/loginform.php"); ?>
                    
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-sm-5 col-md-9"> </div>
    </div>

    <div style="clear:both"></div>
</div><?php */?>
<!-- /container -->
