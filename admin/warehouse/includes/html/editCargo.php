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

function SelectDeselect(AllCheck,InnerCheck)
{	
	var Checked = false;
	if(document.getElementById(AllCheck).checked){
		Checked = true;
	}
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById(InnerCheck+i).checked=Checked;
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


<a href="<?=$RedirectURL?>" class="back">Back</a>


<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


	if(!empty($_GET['edit'])) {
		include("includes/html/box/cargo_edit.php");
		
	
	}else{
		if($HideForm!=1){ 
			include("includes/html/box/cargo_form.php");
		}
	}
	?>
	







