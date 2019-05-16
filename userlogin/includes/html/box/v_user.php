<?
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/territory.class.php");
	$objEmployee=new employee();
	$objTerritory=new territory();
	$ModuleName = "User";
	$RedirectURL = "viewUser.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editUser.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vUser.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 
	$Config['UploadPrefix'] = '../hrms/';

	if (!empty($_GET['view'])) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['view'],'');
		$EmpID   = $_REQUEST['view'];		
		
		if(substr_count("5,6,7", $arryEmployee[0]['Division'])==0){
			$Config['SalesCommission']=0;
		}

		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}



	if($_GET['tab']=='role'){
		$SubHeading = 'Role/Permission';
	}else if($_GET['tab']=='account'){
		$SubHeading = 'Account / Login Details';
	}else if($_GET['tab']=='sales'){
		$SubHeading = 'Sales Commission';
	}else if($_GET['tab']=='territory'){
		$SubHeading = 'Territory';	
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Details";
	}
?>
<script language="JavaScript1.2" type="text/javascript">

function ShowPermission(){
	if(document.getElementById("Role").value=='Admin'){
		document.getElementById('PermissionTitle').style.display = 'block'; 
		document.getElementById('PermissionValue').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValue').style.display = 'none'; 
	}
}
</script>
<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had"><?=$MainModuleName?>   <span> &raquo;
	<? 	echo $SubHeading; ?>
		</span>
</div>

  
<? 
if (!empty($_GET['view'])) {
	if($_GET["tab"]=="sales"){
		include("../includes/html/box/commission_view.php");
	}else if($_GET["tab"]=="territory"){
		include("../includes/html/box/territory_view.php");
	}else{
		include("../includes/html/box/user_view.php");	
	}

	
}

?>



