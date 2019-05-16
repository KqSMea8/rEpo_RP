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
	include("includes/html/box/employee_view.php");
}

?>

