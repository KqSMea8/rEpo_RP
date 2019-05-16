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
        <div class="right_pen">
            <h1><?= LOGIN ?></h1>

            <div class="loginuser block">
                <h3><?= EXISTING_USERS ?></h3>
                <p><?= TO_LOGIN_MSG ?></p>
                <form name="form1" class="register_form login" action="" method="post"  enctype="multipart/form-data">
                    <fieldset>
                        <label><?= EMAIL_ADDRESS ?><span class="red">*</span></label>
                        <input type="text" name="LoginEmail" id="LoginEmail" value="" />
                    </fieldset>           
                    <fieldset>
                        <label><?= PASSWORD ?><span class="red">*</span></label>
                        <input type="Password" name="LoginPassword" id="LoginPassword" value="" />
                    </fieldset>           
                    <fieldset class="btn">
                        <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?= $_GET['ref'] ?>" />
                        <input type="submit" name="submit" id="btnLOgin" value="<?= LOGIN ?>" />
                    </fieldset>
                    <div class="checkbox"><input type="checkbox" name="Remember" value="Yes" /> <?= REMBER_LOGIN ?></p>
                        <p><?= LOST_PASSWORD ?></p>   
                    </div>
                </form> 
            </div>

            <div class="register block">
                <h3><?= NEW_USERS ?></h3>
                <p><?= NOT_REGISTERED ?></p>
                <form class="register_form login">                       
                    <fieldset class="btn">
                        <input type="button" name="btnRegister" id="btnRegister" value="<?= REGISTER ?>" />
                    </fieldset> 
                    <?php if ($settings['EnableGuestCheckout'] == "Yes") { ?>   
                        <p><strong><?= GUEST_CHECKOUT ?> :</strong>
                            <?= GUEST_CHECKOUT_MSG ?></p>
                        <p><?= START_GUEST_CHECKOUT ?></p>
                    <?php } ?>
                </form>




            </div>        
        </div>
    </div>
</div>