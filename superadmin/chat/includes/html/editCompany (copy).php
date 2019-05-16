<SCRIPT LANGUAGE=JAVASCRIPT>


function SetModuleOff()
{
	var flag = false; var checkflag = ''; var ErpOff = 0;
	if(document.getElementById("Department0").checked){
		flag = true;
		checkflag = 1;
	}else{
		flag = false;
	}
	
	
	for(var i=1;i<=4;i++){
		document.getElementById("Department"+i).disabled =  flag;
		if(checkflag==1){
			document.getElementById("Department"+i).checked =  false;
		}

		if(document.getElementById("Department"+i).checked == false){
			ErpOff = 1;
		}

	}



	
	if(ErpOff == 0){
		document.getElementById("Department0").checked =  true;
		for(var i=1;i<=4;i++){
			document.getElementById("Department"+i).disabled =  true;
			document.getElementById("Department"+i).checked =  false;		
		}
	}



}




function StorageUnit(){
	if(document.getElementById("StorageLimit").value>0){
		document.getElementById("StorageLimitUnit").style.display =  'inline';
	}else{
		document.getElementById("StorageLimitUnit").style.display =  'none';
	}
}


</SCRIPT>


<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage Company    <span> &raquo;
	<? 
	if(!empty($_GET['edit'])){
		if($_GET['tab']=="UserInfo"){
			echo "User Details";
		}else if($_GET["tab"]=="DateTime"){
			echo "Edit DateTime Settings";
		}else if($_GET["tab"]=="ip"){
				echo "IP Restriction";	
		}else if($_GET["tab"]=="Call"){
			echo "Edit Call Server";
		}else if($_GET["tab"]=="UserLog"){
			echo "Session Log";
		}else if($_GET["tab"]=="UserProfileLog"){
			echo "User Profile Log";
		}else{
			echo "Edit ".ucfirst($_GET["tab"])." Details";
		}
	}else{
		echo "Add ".$ModuleName;
	}
	 ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } ?>
  <?php if(!empty($_SESSION['mess_company'])){
  	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_company'].'</div>';
  	unset($_SESSION['mess_company']);  	
  }?>


	<? 
	if(!empty($_GET['edit'])) {
		if($_GET['tab']=="UserInfo"){
			include("includes/html/box/company_user.php");
		}else if($_GET['tab']=="Call"){
			include("includes/html/box/company_call_server.php");
		}else if($_GET['tab']=="UserLog"){
			
			include("includes/html/box/company_user_log.php");
		}else if($_GET["tab"]=="ip"){
			include("includes/html/box/company_ip_restriction.php");
			}else if($_GET['tab']=="UserProfileLog"){
			
			include("includes/html/box/user_profile_log.php");	
		}else{	
			include("includes/html/box/company_edit.php");
		}
	}else{
		include("includes/html/box/company_form.php");
	}
	
	
	?>

