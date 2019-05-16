<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen newsletters_sub">
      <h1><?=NEWSLETTER_SUBSCRIPTION?></h1>
      <div class="register fulllayout myProfile">
      <form class="register_form" method="post" action="">
      <div class="block">
      <div class="fieldset ">
        <fieldset>
        <div class="field">
          <label style="padding:0 5px 0 0;"><?=SUBSCRIBE?>:</label>
          <input type="radio" <?=$newsletter_yes?> style="width:20px;vertical-align: middle;" value="Yes" name="Newsletters">
            Yes&nbsp;
            <input type="radio" <?=$newsletter_no?> value="No" style="width:20px;vertical-align: middle;" name="Newsletters">
            No   
        </div>
        </fieldset>
       
      </div>
      <div class="buttons">
          <input type="hidden" name="Cid" id="Cid"  value="<?php echo $Cid; ?>" />
          <input type="submit" value="<?=SAVE?>" class="button submit">
      
        </div>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
