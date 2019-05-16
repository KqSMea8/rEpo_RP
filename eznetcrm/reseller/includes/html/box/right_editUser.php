<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryUser[0]['FirstName']).' '.stripslashes($arryUser[0]['LastName'])?>
  </h4>
  <div class="right_box">

	<ul class="rightlink">	
    <li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$EditUrl?>user">User Details</a></li>
   
    <li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Change Password</a></li>
	   
    
    <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$EditUrl?>role">Role/Permission</a></li>

    

	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} 

?>

