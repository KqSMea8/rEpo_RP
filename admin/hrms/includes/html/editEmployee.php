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
		document.getElementById('PermissionValueNew').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValueNew').style.display = 'none'; 
	}
}

function ShowPermissionGroupRole(){
	if(document.getElementById("GroupID").value >0 ){		
		$("#PermissionsVal").hide();
		$("#CollapseExpand").hide();
		$("#PermissionsHad").hide();
	}else{		
		$("#PermissionsVal").show();
		$("#CollapseExpand").show();
		$("#PermissionsHad").show();

	}
}
</script>


<a href="<?=$RedirectURL?>" class="back">Back</a>






<div class="had">
<?=$MainModuleName?>   <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<?

if(!empty($_SESSION['mess_emp'])){
	$errMsg = $_SESSION['mess_emp'];
	unset($_SESSION['mess_emp']);
}


 if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


	if(!empty($_GET['edit'])) {
		if($_GET['tab']=="employment"){
			include("includes/html/box/employment.php");
		}else if($_GET['tab']=="family"){
			include("includes/html/box/family.php");
		}else if($_GET['tab']=="emergency"){
			include("includes/html/box/emergency.php");
		}else if($_GET["tab"]=="sales"){
			include("../includes/html/box/commission_form.php");
		}else if($_GET["tab"]=="territory"){
			include("../includes/html/box/territory_form.php");
		}else if($_GET["tab"]=="vendor"){
			include("../includes/html/box/vendor_form.php");
		}else{
			include("includes/html/box/employee_edit.php");
		}
		
		#include("../includes/html/box/upload_image.php"); 

		if($_GET['tab']=="education"){
			include("includes/html/box/education_doc.php");
			$DocType = "Scan"; $SupportedDoc = SUPPORTED_SCAN_DOC;
			include("../includes/html/box/upload_doc.php");
		}

	}else{
		if($HideForm!=1){ 
			include("includes/html/box/employee_form.php");
		}
	}
	?>
	







