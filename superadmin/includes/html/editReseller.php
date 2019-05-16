


<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage Reseller    <span> &raquo;
	<? 
	if(!empty($_GET['edit'])){
		echo $PageTitle;
	}else{
		echo 'Add '.$ModuleName;
	}
	 ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } ?>
  <?php if(!empty($_SESSION['mess_reseller'])){
  	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_reseller'].'</div>';
  	unset($_SESSION['mess_reseller']);  	
  }?>


	<? 
	if(!empty($_GET['edit'])){
		if($_GET["tab"]=="comm"){
			include("includes/html/box/commission_form.php");		
		}else if($_GET['tab']=="sales"){
			//include("includes/html/box/rs_sales_report.php");		
		}else if($_GET['tab']=="report"){
			//include("includes/html/box/rs_comm_report.php");	
		}else{
			include("includes/html/box/reseller_edit.php");
		}		
	}else{
		include("includes/html/box/reseller_form.php");
	}
	
	
	?>

