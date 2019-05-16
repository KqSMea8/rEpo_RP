<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen">
      <h1><?=CHANGE_PASSWORD?></h1>
      <div class="register fulllayout myProfile">
      <form class="register_form" method="post" action="">
      <div class="block">
      <h2><?=YOUR_PASSWORD?></h2>
      <div class="fieldset ">
        <fieldset>
        <div class="field">
          <label><?=PASSWORD?> : <span class="red">*</span></label>
            <input type="password" value="" name="Password" maxlength="24" class="formControlText" id="Password">
        </div>
        </fieldset>
        <fieldset>
        <div class="field">
          <label><?=CONFIRM_PASSWORD?> : <span class="red">*</span></label>
          <div class="password">
            <input type="password" value="" name="Con_Password" maxlength="24" class="formControlText" id="Con_Password">
          </div>
        </div>
        </fieldset>
      </div>
      <div class="buttons">
          <input type="hidden" name="Cid" id="Cid"  value="<?php echo $Cid; ?>" />
          <input type="submit" value="<?=SAVE?>" class="button submit" id="ChangePassword">
      
        </div>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
