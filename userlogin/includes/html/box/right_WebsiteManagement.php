<? if (!empty($_GET['CustomerID'])) { ?>
<div class="right-search">
  
  <div class="right_box">
  
    <ul class="rightlink">
      <li <?=($_GET['tab']=="LoginPermission")?("class='active'"):("");?>>WebSite Management
     	<ul>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="viewMenus.php")?("class='active'"):("");?> ><a href="viewMenus.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Menu</a></li>
     	<li>Form
     	<ul>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="viewForms.php")?("class='active'"):("");?>><a href="viewForms.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Form</a></li>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="viewFormFields.php")?("class='active'"):("");?>><a href="viewFormFields.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Form Fields</a></li>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="viewFormData.php")?("class='active'"):("");?>><a href="viewFormData.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Customer Form Data</a></li>
     
     	</ul>
     	</li>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="viewContents.php")?("class='active'"):("");?>><a href="viewContents.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Page</a></li>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="template.php")?("class='active'"):("");?>><a href="template.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Template</a></li>
     	<li <?=(basename($_SERVER['PHP_SELF'])=="setting.php")?("class='active'"):("");?>><a href="setting.php?CustomerID=<?php echo $_GET["CustomerID"]?>">Global Setting</a></li>
     	</ul>
     </li>
     <li><a href="dashboard.php">Dashboard</a></li>
    </ul>
  </div>
</div>

<? }else{
	$SetInnerWidth=1;
}



?>
