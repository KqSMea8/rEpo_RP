<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
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

function SetSuppType(){
	if(document.getElementById("SuppType").value=='Individual'){
		$("#cmpred").hide();
		$("#fred").show();		
	}else{
		$("#cmpred").show();
		$("#fred").hide();		
	}
 

	if(document.getElementById("SSN") != null){
		if(document.getElementById("SuppType").value=='Individual'){
			$("#ssntr").show();
			$("#eintr").hide();
		}else{
			$("#ssntr").hide();
			$("#eintr").show();
		}
	}
}


/*
$(document).ready(function(){
	$("#SSN").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#SSN').keyup(function() {
		var SSN = $('#SSN').val(); 
		var SSNLength = SSN.length; 
		if((SSNLength > 5) && (SSNLength <=11)){
			$('#SSN').val(SSN.replace(/(\d{3})\-?(\d{2})/,'$1-$2'));
		}
	});



	$("#EIN").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	$('#EIN').keyup(function() {
		var EIN = $('#EIN').val(); 
		var EINLength = EIN.length; 
		if((EINLength > 2) && (EINLength <=10)){
			$('#EIN').val(EIN.replace(/(\d{2})\-?(\d{2})/,'$1-$2'));
		}
	});

});*/


jQuery(function($){
   $("#EIN").mask("99-9999999");
   $("#SSN").mask("999-99-9999");
});





$(document).ready(function () {
    //$("#TaxRateSh").hide();
			
    $("#TaxableYes").click(function () {
        $("#TaxRateSh").show();
    });
    $("#TaxableNo").click(function () {
        $("#TaxRateSh").hide();
    });
});


   

</script>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<a href="<?=$RedirectURL?>" class="back">Back</a>


<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?($SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  

if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{

	if(!empty($_GET['edit'])) {
		include("includes/html/box/supplier_edit.php");
		
	}else{
		if($HideForm!=1){ 
			include("includes/html/box/supplier_form.php");
		}
	}
}
	?>
	


<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>




