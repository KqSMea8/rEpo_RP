<div class="container account">
    <div class="mid_wraper clearfix">
        <?php //include_once("includes/left.php"); ?>
        <div class="right_pen newsletters_sub">
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
            <h3><?= NEWSLETTER_SUBSCRIPTION ?></h3>
            <div class="register fulllayout myProfile">
                <form class="register_form_newsletter" method="post" action="">
                    <div class="block">
                        <div class="fieldset ">
                            <fieldset>
                                <div class="field">
                                    <label style="padding:0 5px 0 0;"><?= SUBSCRIBE ?>:</label>
                                    <input type="radio" <?= $newsletter_yes ?> style="width:20px;vertical-align: middle;" value="Yes" name="Newsletters">
                                    Yes&nbsp;
                                    <input type="radio" <?= $newsletter_no ?> value="No" style="width:20px;vertical-align: middle;" name="Newsletters">
                                    No   
                                </div>
                            </fieldset>

                        </div>
                        <div class="buttons">
                            <input type="hidden" name="Cid" id="Cid"  value="<?php echo $Cid; ?>" />
                            <input type="submit" value="<?= SAVE ?>" class="btn btn-info submit">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
