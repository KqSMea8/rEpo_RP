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
  <li><a href="#"><!--img src="img/menu-icon-responsive.png"--> LOGIN</a>
    <ul>
<?php if(!empty($_SESSION['CrmDisplayName'])){?>
	  

		            <li><a href="<?=$Config['Url']?>admin/dashboard.php" target="_blank">ERP Login</a></li>
                    <li><a href="log-out">Log Out</a></li>
                    
                    <li><a href="pricing-signup">Upgrade Account</a></li>
                    <li><a href="dashboard">Manage Web Account</a></li-->
	
	<?php }else{?>
	                <li><a href="<?=$Config['Url']?>admin/dashboard.php" target="_blank">ERP Login</a></li>
                    <li><a href="user">Manage Web Account</a></li>
                    <!--li><a href="reseller/" >Reseller Login</a></li-->
	<?php }?>
	
    </ul>
  </li>
</ul>
</nav>
