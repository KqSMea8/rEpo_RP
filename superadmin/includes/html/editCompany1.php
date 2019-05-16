<SCRIPT LANGUAGE=JAVASCRIPT>
$(document).ready(function () {
	$("#ZipCode").on("click", function () { 
		autozipcode();
	});

if($("#Department0").is(':checked')){
		$("#trtext").show();
		$("#trErpDomain").show();
		$("#trWebDomain").show();
	}else{
		for(var i=1;i<=5;i++){
			if($("#Department"+i).is(':checked')){
				if($("#Department"+i).val()=='2' ){
					$("#trtext").show();
					$("#trErpDomain").show();
				}
				if($("#Department"+i).val()=='9' ){
					$("#trtext").show();
					$("#trWebDomain").show();
				}
			}
			

		}	
	}	 
});


function SetDomain()
{
	var flagecommerce = ''; var flagweb = ''; 
	if($("#Department0").is(':checked')){
		$("#trtext").show();
		$("#trErpDomain").show();
		$("#trWebDomain").show();
	}else{
		for(var i=1;i<=5;i++){
			if($("#Department"+i).is(':checked')){
				if($("#Department"+i).val()=='2' ){
					flagecommerce=1;
					
				}
				if($("#Department"+i).val()=='9' ){
					flagweb=1;
					
				}
			}
			

		}	

		if(flagecommerce==1 && flagweb==1){
			$("#trtext").show();
			$("#trErpDomain").show();
			$("#trWebDomain").show();
		}else if(flagecommerce==1 ){
			$("#trtext").show();
			$("#trErpDomain").show();
			
		}else if( flagweb==1){
			$("#trtext").show();			
			$("#trWebDomain").show();
		}else{
			$("#trtext").hide();
			$("#trErpDomain").hide();
			$("#trWebDomain").hide();
		}
	}	
}

function SetModuleOff()
{
	var flag = false; var checkflag = ''; var ErpOff = 0;
	if(document.getElementById("Department0").checked){
		flag = true;
		checkflag = 1;
	}else{
		flag = false;
	}
	
	
	for(var i=1;i<=5;i++){
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
		for(var i=1;i<=5;i++){
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

function validateCompany(frm){
	return true;
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
		}else if($_GET["tab"]=="mod"){
			echo "Module Settings";	
		}else if($_GET["tab"]=="Call"){
			echo "Edit Call Server";
		}else if($_GET["tab"]=="UserLog"){
			echo "Session Log";
		}else if($_GET["tab"]=="UserProfileLog"){
			echo "User Profile Log";
		}else if($_GET["tab"]=="InvSetting"){
			echo "Inventory Settings";
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
		}else if($_GET['tab']=="mod"){
			include("includes/html/box/company_module_setting.php");
		}else if($_GET["tab"]=="ip"){
			include("includes/html/box/company_ip_restriction.php");
			}else if($_GET['tab']=="UserProfileLog"){
			
			include("includes/html/box/user_profile_log.php");	
		}else if($_GET["tab"]=="InvSetting"){

include("includes/html/box/inv_setting.php");

		}else{	
			include("includes/html/box/company_edit.php");
		}
	}else{
		include("includes/html/box/company_form.php");
	}
	
	
	?>

