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




<?
	/*********************/
	/*********************/
	$FirstName = stripslashes($arryContact[0]['FirstName']);
   	$NextID = $objCommon->NextPrevContact($_GET['view'],$FirstName,1);
	$PrevID = $objCommon->NextPrevContact($_GET['view'],$FirstName,2);
	$NextPrevUrl = "vContact.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	include("includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>





<a href="<?=$RedirectURL?>" class="back">Back</a>
<a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had">
Manage Contact    <span>&raquo;
	Contact Details
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  

  <? 
	if (!empty($_GET['view'])) {
		include("includes/html/box/contact_view.php");
		include("../includes/html/box/upload_image.php");
	}
	
	
	?>
	




