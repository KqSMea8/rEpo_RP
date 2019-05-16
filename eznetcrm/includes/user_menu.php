<!--  <div class="userlink">
<?php if(!empty($_SESSION['CrmDisplayName'])){?>

	<span class="login">Welcome : <i><?php echo $_SESSION['CrmDisplayName']; ?>
	
	</span>
	<span class="login"><a href="../admin/dashboard.php" target="_blank">Application
			Login</a>
	</span>
	
	<span class="login"><a href="log-out">Log Out</a>
	</span>
	<span class="login"><a href="dashboard">Manage Account</a>
	</span>
	<?php }else{?>
<span class="login"><a href="reseller/" >Reseller
			Login</a>
	</span>
	<span class="login"><a href="../admin/dashboard.php" target="_blank">Application
			Login</a>
	</span>
	<span class="login"><a href="user">Manage Account</a>
	</span>
	<?php }?>

</div>
-->
<?php if(!empty($_SESSION['CrmDisplayName'])){?>
<style>
#headerArea .menuArea {
    padding-top: 11px;
}
</style>
 	<?php }?>

<nav id="primary_nav_wrap">

<ul>
<?php if(!empty($_SESSION['CrmDisplayName'])){?>
 <span class="login1">Welcome : <i><?php echo $_SESSION['CrmDisplayName']; ?></span>
 	<?php }?>
  <li><a href="#"><img src="img/menu-icon-responsive.png"> LOGIN</a>
    <ul>
<?php if(!empty($_SESSION['CrmDisplayName'])){?>
	  

		            <li><a href="../admin/dashboard.php" target="_blank">CRM Login</a></li>
                    <li><a href="log-out">Log Out</a></li>
                    <li><a href="user">Manage Web Account</a></li>
	
	<?php }else{?>
	                <li><a href="../admin/dashboard.php" target="_blank">CRM Login</a></li>
                    <li><a href="user">Manage Web Account</a></li>
                    <li><a href="reseller/" >Reseller Login</a></li>
	<?php }?>
	
    </ul>
  </li>
</ul>
</nav>
    
        
