<script language="JavaScript1.2" type="text/javascript">
function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}

function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}

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


<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage Contact    <span>&raquo;
	<? 	if($_GET['tab']=='portal') {echo 'Edit Customer Detail';}else{ echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); }?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  

  <? 
	if (!empty($_GET['edit'])) {

	        include("includes/html/box/contact_edit.php");
		include("../includes/html/box/upload_image.php");
	}else{
		include("includes/html/box/contact_form.php");
	}
	
	
	?>
	




