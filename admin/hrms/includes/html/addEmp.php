<div class="had">Add Employee</div>
	<?
	if(!empty($_SESSION['mess_emp'])){
		$errMsg = $_SESSION['mess_emp'];
		unset($_SESSION['mess_emp']);
	}
 if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  
	if($HideForm!=1){ 
		include("includes/html/box/emp_form.php");
	}
	?>
	







