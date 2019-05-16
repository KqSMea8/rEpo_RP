<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?php echo stripslashes($arryActivity[0]['subject']); ?> 
  </h4>
  <div class="right_box">
   
	<ul class="rightlink">	
    
    <li <?=($_GET['tab']=="Activity")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Activity">Activity Details</a></li>
    
         <li <?=($_GET['tab']=="Comments ")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Comments "><b>Comments </b></a></li> 
         <li <?=($_GET['tab']=="Document ")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Document"><b>Document </b></a></li> 
	
	
  
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>


