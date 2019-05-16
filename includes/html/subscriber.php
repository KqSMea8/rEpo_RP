<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen">
      <h1><?=SUBSCRIBER?></h1>
      
      <span>
              <?php if(!empty($_SESSION['MsgSubscriber'])) {
                         echo $_SESSION['MsgSubscriber'].'<br><br>'; unset($_SESSION['MsgSubscriber']); 
                     }?>
      </span>
    
      <b><a href="index.php"><?=GO_TO_HOME_PAGE?></a></b>
    
      
    </div>
  </div>
</div>
<script type="text/javascript">
</script>
