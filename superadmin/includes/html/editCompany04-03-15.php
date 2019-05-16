<SCRIPT LANGUAGE=JAVASCRIPT>
$(document).ready(function () {
	$("#ZipCode").on("click", function () { 
		autozipcode();
	});	 
});



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
		}else if($_GET["tab"]=="Call"){
			echo "Edit Call Server";
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


	<? 
	if(!empty($_GET['edit'])) {
		if($_GET['tab']=="UserInfo"){
			include("includes/html/box/company_user.php");
		}else if($_GET['tab']=="Call"){
			include("includes/html/box/company_call_server.php");
		}else{	
			include("includes/html/box/company_edit.php");
		}
	}else{
		include("includes/html/box/company_form.php");
	}
	
	
	?>

