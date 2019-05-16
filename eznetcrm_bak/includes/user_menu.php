<ul class="userlink">
<?php if(!empty($_SESSION['CrmDisplayName'])){?>

	<li class="login">Welcome : <i><?php echo $_SESSION['CrmDisplayName']; ?>
	
	</li>
	<li class="login"><a href="../admin/dashboard.php" target="_blank">Application
			Login</a>
	</li>
	
	<li class="login"><a href="log-out">Log Out</a>
	</li>
	<li class="login"><a href="dashboard">Manage Account</a>
	</li>
	<?php }else{?>

	<li class="login"><a href="../admin/dashboard.php" target="_blank">Application
			Login</a>
	</li>
	<li class="login"><a href="user">Manage Account</a>
	</li>
	<?php }?>




</ul>
