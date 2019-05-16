<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

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
</script>
<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>

<div class="had">
		<?=$MainModuleName?>  &raquo; <span>
			<? if($_GET["tab"]=="Summary"){?>
		<? 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
		<?} else{?>
		
			<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
			<? }?>
						
				</span>
		</div>
		
			<? if (!empty($errMsg)) {?>
		  
		    <div  align="center"  class="red" ><?php echo $errMsg;?></div>
		    
		  <? } ?>
		  
	<? 
		include("includes/html/box/RmaAction_form.php");
	?>