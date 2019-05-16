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


<div class="account">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h3 class="section-title-inner"><span><i class="fa fa-lock"></i> <?=REGISTER?></span></h3>
      <div class="row userInfo">
         <div class="col-xs-12 col-sm-12">
          <h3 class="block-title-2"><span><?= CONTACT_INFORMATION ?></span></h3>
          <p><?= TO_LOGIN_MSG ?></p>
          <?php include_once("includes/html/box/registerform.php"); ?>
          
        </div>
      </div>
      <!--/row end--> 
      
    </div>
    <div class="col-lg-6 col-sm-5 col-md-9"> </div>
  </div>
  <!--/row-->
  
  <div style="clear:both"></div>
</div>
<!-- /container -->


<script type="text/javascript">
StateListSend();
</script>