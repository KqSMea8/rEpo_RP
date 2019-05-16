<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryContact[0]['FirstName']).' '.stripslashes($arryContact[0]['LastName'])?>
  </h4>
  <div class="right_box">
   <ul class="rightlink">
           <li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="vContact.php?view=<?=$_GET['view']?>&module=<?=$_GET['module']?>">Contact</a></li>
<?  if(in_array('2025',$arryMainMenu)){ ?>
           <li <?=($_GET['tab']=="Email")?("class='active'"):("");?>><a href="vContact.php?view=<?=$_GET['view']?>&module=<?=$_GET['module']?>&tab=Email">Email</a></li>
<? }?>
      </ul>
	
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
